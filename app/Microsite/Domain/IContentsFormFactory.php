<?php

namespace Microsite\Domain;

/**
 * @author Vojtěch Kohout
 */
interface IContentsFormFactory
{

	/**
	 * @param Content[] $contents
	 * @return ContentsForm
	 */
	function create(array $contents);

} 
