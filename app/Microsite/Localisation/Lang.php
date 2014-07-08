<?php

namespace Microsite\Localisation;

use Microsite\LeanMapper\Entity;

/**
 * @property string $id
 */
class Lang extends Entity
{

	/**
	 * @return string
	 */
	public function __toString()
	{
		return $this->id;
	}

}
