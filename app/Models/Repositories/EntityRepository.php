<?php

namespace App\Models\Repositories;

use Doctrine\ORM\Query;

class EntityRepository extends \Doctrine\ORM\EntityRepository {

	public function getDataTables($data, $options = array()) {
		$defaults = array(
			'alias' => $this->_entityName
		);
		$options += $defaults;

		// $metadata = $this->_em->getClassMetadata($this->_entityName);
		$aColumns = explode(',', $data['columns']);
		for ( $i=0 ; $i<count($aColumns) ; $i++ ) {
			$aColumns[$i] = "{$options['alias']}.{$aColumns[$i]}";
		}

		$qb = $this->createQueryBuilder($options['alias']);
		$qb->select("count({$options['alias']})");

		$query = $qb->getQuery();
		$totalRecords = (int) $query->getSingleScalarResult();

		$qb->select($aColumns);

		// PAGINATION		
		if (isset( $data['iDisplayStart'] ) && $data['iDisplayLength'] != '-1' )
    	{
			$qb
				->setFirstResult($data['iDisplayStart'] )
				->setMaxResults($data['iDisplayLength'])
			;
		}

		// ORDER
		if ( isset( $data['iSortCol_0'] ) ) {
			$sort = "";
			for ( $i=0 ; $i<intval( $data['iSortingCols'] ) ; $i++ )
	        {
	            if ( $data[ 'bSortable_'.intval($data['iSortCol_'.$i]) ] == "true" )
	            {
	                $sort .= $aColumns[ intval( $data['iSortCol_'.$i] ) ];
	                $options['order'] =  $data['sSortDir_'.$i] === 'asc' ? 'asc' : 'desc';
	            }
	        }

			if ($sort !== "") {
				$qb->orderBy($sort, $options['order']);
			}
		}

		//Filteirng
		if ( isset($data['sSearch']) && $data['sSearch'] != "" )
	    {
	        for ( $i=0 ; $i<count($aColumns) ; $i++ )
	        {
	            if ( isset($data['bSearchable_'.$i]) && $data['bSearchable_'.$i] == "true" )
	            {
	                $qb->orWhere("{$aColumns[$i]} LIKE '%" . $data['sSearch'] . "%'");
	            }
	        }
	    }

	    /* Individual column filtering */
	    for ( $i=0 ; $i<count($aColumns) ; $i++ )
	    {
	        if ( isset($data['bSearchable_'.$i]) && $data['bSearchable_'.$i] == "true" && $data['sSearch_'.$i] != '' )
	        {
	            $qb->andWhere("{$aColumns[$i]} LIKE '%" . $data['sSearch_'.$i] . "%'");
	        }
	    }

		$query = $qb->getQuery();		
		$records = $query->getResult();

		$qb
			->select("count({$options['alias']})")
			->setFirstResult(null)
			->setMaxResults(null);
		$query = $qb->getQuery();
		$foundRows = (int) $query->getSingleScalarResult();

		$filas = array();
		foreach ($records as $record) {
			$row = array();
			foreach($record as $value) {
				$row[] = $value;
			}
			$filas[] = $row;
		}

	    $pagination = array(
			"sEcho" => intval($data['sEcho']),
	        "iTotalRecords" => $totalRecords,
	        "iTotalDisplayRecords" => $foundRows,
	        "aaData" => $filas
		);

		return $pagination;
	}

}
