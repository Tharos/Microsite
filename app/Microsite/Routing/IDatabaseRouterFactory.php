<?php

namespace Microsite\Routing;

/**
 * @author Vojtěch Kohout
 */
interface IDatabaseRouterFactory
{

	/**
	 * @return DatabaseRouter
	 */
	function create();

}
