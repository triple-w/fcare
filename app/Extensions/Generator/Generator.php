<?php

namespace App\Extensions\Generator;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class Generator extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'make:template';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generar Template';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Template';

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);

        $name = $this->argument('name');
        $path = $this->argument('path');
        $paths = explode('/', $path);
        $namespace = end($paths);

        $optionData = $this->option('data');
        $data = explode(',', $optionData);

        $plural = strtolower($name);
        $singular = strtolower($name);
        if (substr($singular, -1) === 's') {
            $singular = substr($singular, 0, strlen($singular) - 1);
        }

        $arrayToReplace = [ ':name', ':namespace', ':singular', ':plural' ];
        $arrayFromReplace = [ $name, $namespace, $singular, $plural ];
        foreach ($data as $value) {
            $dataValue = explode(':', $value);
            $arrayToReplace[] = ":{$dataValue[0]}";
            $arrayFromReplace[] = $dataValue[1];
        }

        return str_replace($arrayToReplace, $arrayFromReplace, $stub);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        $template = $this->argument('template');
        return base_path("resources/templates/{$template}.stub");
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = str_replace($this->laravel->getNamespace(), '', $name);
        $path = $this->argument('path');
        $type = $this->argument('type');
        $ext = '.php';

        switch ($type) {
            case 'view':
                $ext = '.blade.php' ;
            break;
            case 'controller':
                $path = "app/Http/Controllers/{$path}";
                $name = "{$name}Controller";
            break;
            case 'model':
                $path = "app/Models/{$path}";
            break;
        }

        return base_path("{$path}").'/'.str_replace('\\', '/', $name).$ext;
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['type', InputArgument::REQUIRED, 'The type of template.'],
            ['template', InputArgument::REQUIRED, 'The name of template.'],
            ['path', InputArgument::REQUIRED, 'The namespace to create.'],
            ['name', InputArgument::REQUIRED, 'The name file.'],
        ];
    }

    protected function getOptions() {
        return [
            ['data', null, InputOption::VALUE_OPTIONAL, 'Data to the template on format key:vale,key:value', 'command:data'],
        ];
    }

}

?>