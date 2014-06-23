<?php

namespace Microsite\Auth;

/**
 * @author Vojtěch Kohout
 */
interface ISignFormFactory
{

	/**
	 * @return SignForm
	 */
	function create();
	
}
