<?php

namespace Microsite\Site;

use InvalidArgumentException;
use Microsite\LeanMapper\Entity;
use Microsite\Localisation\Lang;

/**
 * @property int $id
 * @property Lang $lang m:hasOne
 * @property Content[] $contents m:belongsToMany
 *
 * @property string $layout = 'default'
 * @property string $name
 * @property string $webalizedName
 * @property string|null $title
 * @property string|null $description
 * @property int|null $ord
 * @property bool $homepage = false
 * @property bool $visibleInMenu = true
 */
class Page extends Entity
{

	/** @var Content[] */
	private $contentsIndex;


	/**
	 * @param string $code
	 * @return Content
	 */
	public function getContent($code)
	{
		if ($this->contentsIndex === null) {
			$this->contentsIndex = [];
			foreach ($this->contents as $content) {
				$this->contentsIndex[$content->code] = $content;
			}
		}

		if (!isset($this->contentsIndex[$code])) {
			throw new InvalidArgumentException("Missing content with code $code.");
		}

		return $this->contentsIndex[$code];
	}

}
