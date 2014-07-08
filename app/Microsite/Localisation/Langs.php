<?php

namespace Microsite\Localisation;

use InvalidArgumentException;
use LeanQuery\DomainQueryFactory;
use Nette\Application\BadRequestException;
use Nette\Http\IRequest;

/**
 * @author Vojtěch Kohout
 */
class Langs
{

	/** @var Lang[] */
	private $availableLangs;

	/** @var Lang */
	private $currentLang;


	/**
	 * @param DomainQueryFactory $domainQueryFactory
	 * @param IRequest $httpRequest
	 * @throws BadRequestException
	 */
	public function __construct(DomainQueryFactory $domainQueryFactory, IRequest $httpRequest)
	{
		$langs = $domainQueryFactory->createQuery()
			->select('l')
			->from('Microsite\Localisation\Lang', 'l')  // you can use Lang::class instead of string in PHP 5.5
			->getEntities();

		$langInUrl = substr($httpRequest->getUrl()->getRelativeUrl(), 0, 2);

		foreach ($langs as $lang) {
			$this->availableLangs[$lang->id] = $lang;

			if ($lang->id === $langInUrl) {
				$this->currentLang = $lang;
			}
		}

		if ($this->currentLang === null) {
			throw new BadRequestException('Cannot determine page language.');
		}
	}

	/**
	 * @param string $id
	 * @return Lang
	 */
	public function getLang($id)
	{
		if (!isset($this->availableLangs[$id])) {
			throw new InvalidArgumentException("Missing lang with id $id.");
		}
		return $this->availableLangs[$id];
	}

	/**
	 * @return Lang
	 */
	public function getCurrentLang()
	{
		return $this->currentLang;
	}

}
