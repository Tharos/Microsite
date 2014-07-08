<?php

namespace Microsite\LeanMapper;

use LeanMapper\DefaultMapper;
use LeanMapper\Caller;
use LeanMapper\Row;

/**
 * @author Vojtěch Kohout
 */
class Mapper extends DefaultMapper
{

	/** @var string */
	protected $defaultEntityNamespace = 'Microsite\Domain';


	/*
	 * @inheritdoc
	 */
	public function getPrimaryKey($table)
	{
		return $table . $this->relationshipTableGlue . 'id';
	}

	/*
	 * @inheritdoc
	 */
	public function getColumn($entityClass, $field)
	{
		if ($field === 'id') {
			return $this->getTable($entityClass) . $this->relationshipTableGlue . $field;
		}
		return parent::getColumn($entityClass, $field);
	}

	/*
	 * @inheritdoc
	 */
	public function getEntityClass($table, Row $row = null)
	{
		if ($table === 'user') {
			return 'Microsite\Auth\User';
		}
		if ($table === 'lang') {
			return 'Microsite\Localisation\Lang';
		}
		return ($this->defaultEntityNamespace !== null ? $this->defaultEntityNamespace . '\\' : '') . ucfirst($table);
	}

	/*
	 * @inheritdoc
	 */
	public function getEntityField($table, $column)
	{
		if ($column === $this->getPrimaryKey($table)) {
			return 'id';
		}
		return parent::getEntityField($table, $column);
	}

	/*
	 * @inheritdoc
	 */
	public function getImplicitFilters($entityClass, Caller $caller = null)
	{
		return [];
	}

	/*
	 * @inheritdoc
	 */
	public function getRelationshipColumn($sourceTable, $targetTable)
	{
		return $this->getPrimaryKey($targetTable);
	}

}
