<?php

namespace App\Extensions\Doctrine;

use EntityManager;
use Validator;

use Illuminate\Foundation\Validation\ValidatesRequests;

use BadMethodCallException;
use DateTime;
use Exception;

class DoctrineEntity {

    use ValidatesRequests;

    public static function __callStatic($name, $arguments) {
        if (
            ($repository = EntityManager::getRepository(get_called_class())) &&
            method_exists($repository, $name) &&
            is_callable(array($repository, $name))
        ) {
            return call_user_func_array(array($repository, $name), $arguments);
        }
        $message = "No repository method named `{$name}` to call.";
        throw new BadMethodCallException($message);
    }

    public function __set($name, $value) {
        $this->setterProperty($name, $value);
    }

    public function __get($value) {
         if(method_exists($this , $method = ('get'.ucfirst($value)))) {
            return $this->$method();
        }

        throw new Exception( 'Can\'t get property ' . $value );
    }

    public function validateEntity($request, $event = null) {
        $properties = $this->getProperties();

        $rules = array();
        foreach ($properties as $property) {
            if ($property->getName() === 'rules') {
                $property->setAccessible(true);
                foreach ($property->getValue($this) as $value) {
                    foreach ($rules as $rule) {
                        if ($rule['field'] === $value['field']) {
                            continue 2;
                        }
                    }
                    $rules[] = $value;
                }
            }
        }

        $rulesValidate = [];
        $rulesMensajes = [];
        foreach ($rules as $rule => $values) {
            if (!empty($event)) {
                if (array_key_exists('on', $values)) {
                    if (is_array($values['on'])) {
                        if (array_key_exists($event, array_flip($values['on']))) {
                            $rulesValidate[$values['field']] = $values['rule'];
                        }
                    } else {
                        if ($event === $values['on']) {
                            $rulesValidate[$values['field']] = $values['rule'];
                        }
                    }
                }
            } else {
                if (!array_key_exists('on', $values)) {
                    $rulesValidate[$values['field']] = $values['rule'];
                }
            }

            if (array_key_exists('mensajes', $values)) {
                foreach ($values['mensajes'] as $key => $mensaje) {
                    $rulesMensajes["{$values['field']}.{$key}"] = $mensaje;
                }
            }
        }

        $validator = Validator::make($request->all(), $rulesValidate, $rulesMensajes);
        if ($validator->fails()) {
            $this->throwValidationException(
                $request, $validator
            );
        }

    }

    public function getMeta() {
        return EntityManager::getClassMetadata(static::class);
    }

    public function getAssociationMapping($field) {
        return $this->getMeta()->getAssociationMapping($field);
    }

    public function getAssociationNames() {
        return $this->getMeta()->getAssociationNames();
    }

    public function getAssociationByType($type) {
        $associationsNames = $this->getAssociationNames();
        $associations = [];
        foreach ($associationsNames as $associationName) {
            $association = $this->getAssociationMapping($associationName);
            if ($association['type'] === $type) {
                $associations[$association['fieldName']] = $association;
            }
        }

        return $associations;
    }

    public function set(array $data, array $whitelist = array()) {
        if (!empty($whitelist)) {
            $data = array_intersect_key($data, array_flip($whitelist));
        }

        $associationsManyToOne = $this->getAssociationByType(\Doctrine\ORM\Mapping\ClassMetadataInfo::MANY_TO_ONE);

        $properties = $this->getProperties();
        foreach ($data as $name => $value) {
            if ($name !== 'id') {
                foreach ($properties as $property) {
                    if ($property->name === $name) {
                        if (array_key_exists($name, $associationsManyToOne)) {
                            $value = EntityManager::getRepository($associationsManyToOne[$name]['targetEntity'])->find($value);
                        }

                        switch ($this->getMeta()->getTypeOfField($property->name)) {
                            case "CarbonDateTime":
                            case "CarbonDate":
                                $value = new \Carbon\Carbon($value);
                            break;
                        }

                        if ($property->isPublic()) {
                            $this->$name = $value;
                        } else {
                            $this->setterProperty($name, $value);
                        }
                        break;
                    }
                }
            }
        }
    }

    private function setterProperty($name, $value) {
        if(method_exists( $this , $method = ('set'.ucfirst($name)))) {
            return $this->$method( $value );
        }

        throw new Exception( 'Can\'t set property ' . $name );

    }

    public function getProperties() {
        $class = new \ReflectionClass(get_class($this));
        $properties = [];
        $properties = array_merge($properties, $class->getProperties());
        while ($class->getParentClass()) {
            $class = $class->getParentClass();
            $properties = array_merge($properties, $class->getProperties());
        }

        return $properties;
    }

    public function save($request, array $whitelist = array(), array $options = array()) {
        $defaults = array(
            'validate' => false,
            'event' => null,
            'flush' => false,
        );
        $options += $defaults;

        if ($options['validate']) {
            $this->validateEntity($request, $options['event']);
        }

        if ($request) {
            $this->set($request->all(), $whitelist);
        }

        // dump("entre");die;

        if ($options['flush']){
            EntityManager::persist($this);
            EntityManager::flush();
        }
    }

    public function toArray($entity = null, $options = []) {
        $default = [
            'relationships' => true,
            'deep' => null,
            'deepStart' => -1,
            'fields' => [],
            'formatters' => []
        ];
        $options += $default;
        if ($options['deep'] !== null && ($options['deepStart'] > $options['deep'])) {
            return;
        }

        $data = [];

        $metaData = $this->getMeta();

        foreach ($metaData->fieldMappings as $field => $mapping)
        {
            if (!array_key_exists($metaData->getName(), $options['fields'])) {
                if (array_key_exists($metaData->getName(), $options['formatters'])) {
                    if (array_key_exists($field, $options['formatters'][$metaData->getName()])) {
                        $data[$field] = $options['formatters'][$metaData->getName()][$field]($this->$field);
                    } else {
                        $data[$field] = $this->$field;
                    }
                } else {
                    $data[$field] = $this->$field;
                }
            } elseif (in_array($field, $options['fields'][$metaData->getName()])) {
                if (array_key_exists($metaData->getName(), $options['formatters'])) {
                    if (array_key_exists($field, $options['formatters'][$metaData->getName()])) {
                        $data[$field] = $options['formatters'][$metaData->getName()][$field]($this->$field);
                    } else {
                        $data[$field] = $this->$field;
                    }
                } else {
                    $data[$field] = $this->$field;
                }
            }
        }

        if ($options['relationships']) {
            foreach ($metaData->associationMappings as $field => $mapping)
            {
                if ($mapping['targetEntity'] === $entity) {
                    continue;
                }

                $opts = $options;
                // unset($opts['fields']);
                if ($options['deep'] !== null) {
                    $opts['deepStart'] = $opts['deepStart'] + 1;
                }

                if (!array_key_exists($metaData->getName(), $options['fields'])) {
                    $object = $metaData->reflFields[$field]->getValue($this);
                    if (!empty($object)) {
                        if (is_array($object) || $object instanceof \Doctrine\ORM\PersistentCollection) {
                            $dataTmp = [];
                            foreach ($object as $key => $value) {
                                $dataTmp[] = $value->toArray($metaData->getName(), $opts);
                            }
                            $data[$field] = $dataTmp;
                        } else {
                            $data[$field] = $object->toArray($metaData->getName(), $opts);
                        }
                    }
                } elseif (in_array($field, $options['fields'][$metaData->getName()])) {
                    $object = $metaData->reflFields[$field]->getValue($this);
                    if (!empty($object)) {
                        if (is_array($object) || $object instanceof \Doctrine\ORM\PersistentCollection) {
                            $dataTmp = [];
                            foreach ($object as $key => $value) {
                                $dataTmp[] = $value->toArray($metaData->getName(), $opts);
                            }
                            $data[$field] = $dataTmp;
                        } else {
                            $data[$field] = $object->toArray($metaData->getName(), $opts);
                        }
                    }
                }
            }
        }

        return $data;
    }

    public function persist() {
        EntityManager::persist($this);
    }

    public function persistRemove() {
        EntityManager::remove($this);
    }

    public function remove() {
        EntityManager::remove($this);
        EntityManager::flush();
    }

    public function flush($entitys = null) {
        EntityManager::persist($this);
        EntityManager::flush($entitys);
    }

}

?>
