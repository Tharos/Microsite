<?php

namespace Microsite\Navigation;

use DomainException;
use LeanQuery\DomainQueryFactory;
use Nette\Application\UI\Control;
use Microsite\Domain\Page;

/**
 * @author Vojtěch Kohout
 */
class Navigation extends Control
{

	/** @var string */
	private $langId;

	/** @var string */
	private $siteName;

	/** @var DomainQueryFactory */
	private $domainQueryFactory;

	/** @var Page */
	private $currentPage;

	/** @var Page[] */
	private $pages;

	/** @var Page */
	private $homepage;


	/**
	 * @param string $langId
	 * @param string $siteName
	 * @param DomainQueryFactory $domainQueryFactory
	 */
	public function __construct($langId, $siteName, DomainQueryFactory $domainQueryFactory)
	{
		$this->langId = $langId;
		$this->siteName = $siteName;
		$this->domainQueryFactory = $domainQueryFactory;
	}

	/**
	 * @param Page $currentPage
	 */
	public function setCurrentPage(Page $currentPage)
	{
		$this->currentPage = $currentPage;
	}


	public function renderSiteName()
	{
		echo $this->siteName;
	}


	public function renderTitle()
	{
		if ($this->currentPage === null) {
			echo $this->siteName;
		} else {
			if (isset($this->currentPage->title)) {
				echo $this->currentPage->title;
			} else {
				echo $this->currentPage->name . ' | ' . $this->siteName;
			}
		};
	}


	public function renderMetaDescriptionElement()
	{
		if (isset($this->currentPage->description)) {
			echo '<meta name="description" content="' . $this->currentPage->description . '">';
		}
	}


	public function renderHomepageLink()
	{
		echo $this->getPresenter()->link('Page:', ['page' => $this->getHomepage(), 'lang' => $this->langId]);
	}


	public function renderMenu()
	{
		$this->template->currentPage = $this->currentPage;
		$this->template->pages = $this->getPages();
		$this->template->langId = $this->langId;
		$this->template->includeHomepage = (func_num_args() === 0 or func_get_arg(0) === true);

		$this->template->render(__DIR__ . '/menu.latte');
	}


	public function renderMenuWithoutHomepage()
	{
		$this->renderMenu(false);
	}

	////////////////////
	////////////////////

	/**
	 * @return Page
	 */
	private function getHomepage()
	{
		if ($this->homepage === null) {
			$this->getPages();
		}
		return $this->homepage;
	}

	/**
	 * @return Page[]
	 */
	private function getPages()
	{
		if ($this->pages === null) {
			$this->pages = $this->loadPages();
			foreach ($this->pages as $page) {
				if ($page->homepage) {
					$this->homepage = $page;
					break;
				}
			}
			if ($this->homepage === null) {
				throw new DomainException("Missing homepage in $this->langId version.");
			}
		}
		return $this->pages;
	}

	/**
	 * @return Page[]
	 */
	private function loadPages()
	{
		return $this->domainQueryFactory->createQuery()
			->select('p')
			->from(Page::class, 'p')
			->where('p.lang = %s', $this->langId)
			->orderBy('p.ord')
			->getEntities();
	}

}
