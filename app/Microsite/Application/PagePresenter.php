<?php

namespace Microsite\Application;

use Microsite\Site\Page;
use Microsite\Navigation\Navigation;

/**
 * @author Vojtěch Kohout
 */
class PagePresenter extends Presenter
{

	/** @var Page */
	private $currentPage;


	public function startup()
	{
		$this->autoCanonicalize = false;
		$this->currentPage = $this->getParameter('currentPage');

		parent::startup();
	}


	public function renderDefault()
	{
		$this->setView($this->currentPage->layout);
		$this->template->currentPage = $this->currentPage;
	}

	/**
	 * @return Navigation
	 */
	protected function createComponentNavigation()
	{
		$navigation = parent::createComponentNavigation();
		$navigation->setCurrentPage($this->currentPage);

		return $navigation;
	}

}
