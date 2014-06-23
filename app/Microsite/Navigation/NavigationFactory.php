<?php

namespace Microsite\Navigation;

use LeanQuery\DomainQueryFactory;

/**
 * @author Vojtěch Kohout
 */
class NavigationFactory
{

	/** @var string */
	private $siteName;

	/** @var DomainQueryFactory */
	private $domainQueryFactory;


	/**
	 * @param string $siteName
	 * @param DomainQueryFactory $domainQueryFactory
	 */
	public function __construct($siteName, DomainQueryFactory $domainQueryFactory)
	{
		$this->siteName = $siteName;
		$this->domainQueryFactory = $domainQueryFactory;
	}

	/**
	 * @param string $lang
	 * @return Navigation
	 */
	public function create($lang)
	{
		return new Navigation($lang, $this->siteName, $this->domainQueryFactory);
	}

} 
