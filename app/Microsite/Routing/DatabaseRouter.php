<?php

namespace Microsite\Routing;

use LeanQuery\DomainQueryFactory;
use Microsite\Localisation\Lang;
use Microsite\Localisation\Langs;
use Nette\Application\IRouter;
use Nette\Application\Request;
use Nette\Http\IRequest;
use Nette\Http\Url;
use Nette\Utils\Strings;

/**
 * @author Vojtěch Kohout
 */
class DatabaseRouter implements IRouter
{

	/** @var DomainQueryFactory */
	private $domainQueryFactory;

	/** @var Langs */
	private $langs;


	/**
	 * @param DomainQueryFactory $domainQueryFactory
	 * @param Langs $langs
	 */
	public function __construct(DomainQueryFactory $domainQueryFactory, Langs $langs)
	{
		$this->domainQueryFactory = $domainQueryFactory;
		$this->langs = $langs;
	}

	/**
	 * @param IRequest $httpRequest
	 * @return Request
	 */
	public function match(IRequest $httpRequest)
	{
		$pageUrl = $this->getPageUrl($httpRequest);

		if ($pageUrl === null) {
			return null;
		}

		$query = $this->domainQueryFactory->createQuery()
			->select('p')
			->from('Microsite\Domain\Page', 'p') // you can use Page::class instead of string in PHP 5.5
			->where('p.lang = %s', $this->langs->getCurrentLang()->id);

		if ($pageUrl !== '') {
			$query->where('p.webalizedName = %s', $pageUrl);
		} else {
			$query->where('p.homepage = %b', true);
		}

		$page = $query->getEntity();
		if ($page === null) {
			return null;
		}

		$params = $httpRequest->getQuery() + ['action' => 'default', 'currentPage' => $page, 'lang' => $this->langs->getCurrentLang()];

		return new Request(
			'Page',
			$httpRequest->getMethod(),
			$params,
			$httpRequest->getPost(),
			$httpRequest->getFiles(),
			[Request::SECURED => $httpRequest->isSecured()]
		);
	}

	/**
	 * @param Request $appRequest
	 * @param Url $refUrl
	 * @return string
	 */
	public function constructUrl(Request $appRequest, Url $refUrl)
	{
		if ($appRequest->getPresenterName() !== 'Page') {
			return null;
		}
		$params = $appRequest->getParameters();

		if (!array_key_exists('lang', $params)) {
			return null;
		}
		$lang = $params['lang'];
		if ($lang instanceof Lang) {
			$lang = $lang->id;
		}

		if (!array_key_exists('page', $params)) {
			if (!array_key_exists('pageId', $params)) {
				return null;
			}
			$page = $this->domainQueryFactory->createQuery()
				->select('p')
				->from('Microsite\Domain\Page', 'p') // you can use Page::class instead of string in PHP 5.5
				->where('p.id = %i AND p.lang = %s', $params['pageId'], $lang)
				->getEntity();

			if ($page === null) {
				return null;
			}
		} else {
			$page = $params['page'];
		}
		$relativeUrl = $lang . ($page->homepage ? '' : '/' . $page->webalizedName);

		unset($params['pageId'], $params['action'], $params['lang']);

		$url = 'http://' . $refUrl->getAuthority() . $refUrl->getPath() . $relativeUrl;

		$sep = ini_get('arg_separator.input');
		$query = http_build_query($params, '', $sep ? $sep[0] : '&');
		if ($query != '') {
			$url .= '?' . $query;
		}
		return $url;
	}

	////////////////////
	////////////////////

	/**
	 * @param IRequest $httpRequest
	 * @return string
	 */
	private function getPageUrl(IRequest $httpRequest)
	{
		$matches = [];
		$pattern = sprintf('~
			^%s # current lang
			(?:/([^?]+))? # page URL
			(?:\?.*)?$ # query string
		~x', $this->langs->getCurrentLang());

		if (!preg_match($pattern, $httpRequest->getUrl()->getRelativeUrl(), $matches)) {
			return null;
		}

		return !empty($matches[1]) ? $matches[1] : '';
	}

}
