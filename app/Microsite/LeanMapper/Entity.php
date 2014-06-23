<?php

namespace Microsite\LeanMapper;

use Exception;
use LeanMapper\Relationship\HasOne;

/**
 * @author Vojtěch Kohout
 */
abstract class Entity extends \LeanMapper\Entity
{

	/**
	 * @param string $name
	 * @param mixed $value
	 */
	public function __set($name, $value)
	{
		$property = $this->getCurrentReflection()->getEntityProperty($name);
		$relationship = $property->getRelationship();
		if (($relationship instanceof HasOne) and !($value instanceof \LeanMapper\Entity)) {
			if (is_string($value) and ctype_digit($value)) {
				settype($value, 'integer');
			}
			$this->row->{$property->getColumn()} = $value;
			$this->row->cleanReferencedRowsCache($relationship->getTargetTable(), $relationship->getColumnReferencingTargetTable());
		} else {
			parent::__set($name, $value);
		}
	}

	/**
	 * @param Entity $entity
	 * @throws Exception
	 * @return bool
	 */
	public function equals(Entity $entity)
	{
		if ($this->mapper === null) {
			throw new Exception('Cannot compare entities without mapper.');
		}
		$tableA = $this->mapper->getTable(get_called_class());
		$tableB = $this->mapper->getTable(get_class($entity));

		$idA = $this->mapper->getEntityField($tableA, $this->mapper->getPrimaryKey($tableA));
		$idB = $this->mapper->getEntityField($tableB, $this->mapper->getPrimaryKey($tableB));

		return $this->$idA === $entity->$idB;
	}

}
