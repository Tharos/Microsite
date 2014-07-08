<?php

namespace Microsite\Navigation;

/**
 * @author Vojtěch Kohout
 */
interface INavigationFactory
{

	/**
	 * @param string $lang
	 * @return Navigation
	 */
	function create($lang);

} 
