<?php

namespace Microsite\LeanMapper;

use LeanMapper\Caller;
use LeanMapper\Fluent;
use LeanMapper\IMapper;
use LeanMapper\ImplicitFilters;

/**
 * @author Vojtěch Kohout
 */
class ImplicitFiltersProvider
{

	/** @var MappingHelper */
	private $mappingHelper;


	/**
	 * @param MappingHelper $mappingHelper
	 */
	public function __construct(MappingHelper $mappingHelper)
	{
		$this->mappingHelper = $mappingHelper;
	}

	/**
	 * @param IMapper $mapper
	 * @param string $entityClass
	 * @param Caller $caller
	 * @return array|ImplicitFilters
	 */
	public function getImplicitFilters(IMapper $mapper, $entityClass, Caller $caller = null)
	{
		return array();
	}

}
