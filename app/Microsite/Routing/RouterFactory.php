<?php

namespace Microsite\Routing;

use LeanQuery\DomainQueryFactory;
use Nette\Application\IRouter;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;

class RouterFactory
{

	/** @var DomainQueryFactory */
	private $domainQueryFactory;


	/**
	 * @param DomainQueryFactory $domainQueryFactory
	 */
	public function __construct(DomainQueryFactory $domainQueryFactory)
	{
		$this->domainQueryFactory = $domainQueryFactory;
	}

	/**
	 * @return IRouter
	 */
	public function createRouter()
	{
		$router = new RouteList;

		$router[] = new Route('<lang cz|en>/<presenter admin|sign>[/<action=default>[/<id>]]');
		$router[] = new DatabaseRouter($this->domainQueryFactory);

		return $router;
	}

}
