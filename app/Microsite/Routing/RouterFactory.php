<?php

namespace Microsite\Routing;

use Nette\Application\IRouter;
use Nette\Application\Routers\Route;
use Nette\Application\Routers\RouteList;

/**
 * @author Vojtěch Kohout
 */
class RouterFactory
{

	/** @var IDatabaseRouterFactory */
	private $databaseRouterFactory;


	/**
	 * @param IDatabaseRouterFactory $databaseRouterFactory
	 */
	public function __construct(IDatabaseRouterFactory $databaseRouterFactory)
	{
		$this->databaseRouterFactory = $databaseRouterFactory;
	}

	/**
	 * @return IRouter
	 */
	public function createRouter()
	{
		$router = new RouteList;

		$router[] = new Route('<lang cz|en>/<presenter admin|sign>[/<action=default>[/<id>]]');
		$router[] = $this->databaseRouterFactory->create();

		return $router;
	}

}
