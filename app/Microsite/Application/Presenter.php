<?php

namespace Microsite\Application;

use Microsite\Navigation\NavigationFactory;
use Microsite\Navigation\Navigation;

/**
 * @author Vojtěch Kohout
 */
abstract class Presenter extends \Nette\Application\UI\Presenter
{

	/**
	 * @var string
	 * @persistent
	 */
	public $lang;

	/** @var NavigationFactory */
	private $navigationFactory;


	/**
	 * @param NavigationFactory $navigationFactory
	 */
	public function injectBase(NavigationFactory $navigationFactory)
	{
		$this->navigationFactory = $navigationFactory;
	}


	protected function beforeRender()
	{
		parent::beforeRender();
		$this->template->langId = $this->lang;
	}

	/**
	 * @return Navigation
	 */
	protected function createComponentNavigation()
	{
		return $this->navigationFactory->create($this->lang);
	}

}
