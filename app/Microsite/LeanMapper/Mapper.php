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
	protected $basePackagesNamespace = 'Microsite';

	/** @var Packages */
	private $packages;


	/**
	 * @param Packages $packages
	 */
	public function __construct(Packages $packages)
	{
		$this->packages = $packages;
	}

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
		return $this->basePackagesNamespace . '\\' . $this->packages->getByTable($table) . '\\' . ucfirst($table);
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
