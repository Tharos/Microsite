<?php

namespace Microsite\Navigation;

/**
 * @author Vojtěch Kohout
 */
interface INavigationFactory
{

	/**
	 * @param string $langId
	 * @return Navigation
	 */
	function create($langId);

} 
