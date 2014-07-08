<?php

namespace Microsite\Routing;

use Microsite\Localisation\Lang;
use Microsite\Localisation\Langs;
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

	/** @var Langs */
	private $langs;


	/**
	 * @param IDatabaseRouterFactory $databaseRouterFactory
	 * @param Langs $langs
	 */
	public function __construct(IDatabaseRouterFactory $databaseRouterFactory, Langs $langs)
	{
		$this->databaseRouterFactory = $databaseRouterFactory;
		$this->langs = $langs;
	}

	/**
	 * @return IRouter
	 */
	public function createRouter()
	{
		$router = new RouteList;

		$router[] = new Route('<lang>/<presenter admin|sign>[/<action=default>[/<id>]]', [
			'lang' => [
				Route::FILTER_IN => function ($langId) {
					return $this->langs->getLang($langId);
				},
				Route::FILTER_OUT => function ($lang) {
					return $lang instanceof Lang ? $lang->id : $lang;
				}
			]
		]);
		$router[] = $this->databaseRouterFactory->create();

		return $router;
	}

}
