<?php

namespace Microsite\LeanMapper;

use LeanMapper\IMapper;
use LeanMapper\Reflection\EntityReflection;

/**
 * @author Vojtěch Kohout
 */
class MappingHelper
{

	/**
	 * @param IMapper $mapper
	 * @param string $entityClass
	 * @param array $properties
	 * @return array
	 */
	public function getTableAndColumns(IMapper $mapper, $entityClass, array $properties = [])
	{
		$mapping = [
			'table' => $mapper->getTable($entityClass),
		];
		if (!empty($properties)) {
			/** @var EntityReflection $reflection */
			$reflection = $entityClass::getReflection($mapper);
			foreach ($properties as $property) {
				$mapping[$property] = $reflection->getEntityProperty($property)->getColumn();
			}
		}
		return $mapping;
	}

}
