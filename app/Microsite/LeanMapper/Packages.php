<?php

namespace Microsite\LeanMapper;

use InvalidArgumentException;
use LeanMapper\Exception\InvalidValueException;

/**
 * @author Vojtěch Kohout
 */
class Packages
{

	/** @var array */
	private $packages;

	/** @var array */
	private $indexByTable = [];


	/**
	 * @throws InvalidValueException
	 */
	public function __construct()
	{
		$this->packages = json_decode(file_get_contents(__DIR__ . '/packages.json'), true);
		if ($this->packages === null) {
			throw new InvalidValueException('JSON with packages could not be decoded.');
		}
		foreach ($this->packages as $package => $tables) {
			foreach ($tables as $table) {
				if (array_key_exists($table, $this->indexByTable)) {
					throw new InvalidValueException("Multiple packages for table $table found.");
				}
				$this->indexByTable[$table] = $package;
			}
		}
	}

	/**
	 * @param string $table
	 * @return string
	 * @throws InvalidArgumentException
	 */
	public function getByTable($table)
	{
		if (!array_key_exists($table, $this->indexByTable)) {
			throw new InvalidArgumentException("Missing package for table $table.");
		}
		return $this->indexByTable[$table];
	}

}
