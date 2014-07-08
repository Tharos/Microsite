<?php

namespace Microsite\Routing;

use LeanQuery\DomainQueryFactory;
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


	/**
	 * @param DomainQueryFactory $domainQueryFactory
	 */
	public function __construct(DomainQueryFactory $domainQueryFactory)
	{
		$this->domainQueryFactory = $domainQueryFactory;
	}

	/**
	 * @param IRequest $httpRequest
	 * @return Request
	 */
	public function match(IRequest $httpRequest)
	{
		$relativeUrl = $this->getRelativeUrl($httpRequest);

		$matches = [];
		if (!preg_match('#^(cz|en)(?:/(.*))?$#', $relativeUrl, $matches)) {
			return null;
		}

		$query = $this->domainQueryFactory->createQuery()
			->select('p')
			->from('Microsite\Domain\Page', 'p') // you can use Page::class instead of string in PHP 5.5
			->where('p.lang = %s', $matches[1]);

		if (isset($matches[2])) {
			$query->where('p.webalizedName = %s', $matches[2]);
		} else {
			$query->where('p.homepage = %b', true);
		}

		$page = $query->getEntity();
		if ($page === null) {
			return null;
		}

		$params = $httpRequest->getQuery() + ['action' => 'default', 'currentPage' => $page, 'lang' => $matches[1]];

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

		if (!array_key_exists('page', $params)) {
			if (!array_key_exists('pageId', $params)) {
				return null;
			}
			$page = $this->domainQueryFactory->createQuery()
				->select('p')
				->from('Microsite\Domain\Page', 'p') // you can use Page::class instead of string in PHP 5.5
				->where('p.id = %i AND p.lang = %s', $params['pageId'], $params['lang'])
				->getEntity();

			if ($page === null) {
				return null;
			}
		} else {
			$page = $params['page'];
		}
		$relativeUrl = $params['lang'] . ($page->homepage ? '' : '/' . $page->webalizedName);

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
	private function getRelativeUrl(IRequest $httpRequest)
	{
		$relativeUrl = $httpRequest->getUrl()->getRelativeUrl();
		$position = strpos($relativeUrl, '?');
		if ($position !== false) {
			$relativeUrl = Strings::truncate($relativeUrl, $position, '');
		}
		return $relativeUrl;
	}

}
