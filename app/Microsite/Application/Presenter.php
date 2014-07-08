<?php

namespace Microsite\Application;

use Microsite\Localisation\Lang;
use Microsite\Navigation\INavigationFactory;
use Microsite\Navigation\Navigation;

/**
 * @author Vojtěch Kohout
 */
abstract class Presenter extends \Nette\Application\UI\Presenter
{

	/**
	 * @var Lang
	 * @persistent
	 */
	public $lang;

	/** @var INavigationFactory */
	private $navigationFactory;


	/**
	 * @param INavigationFactory $navigationFactory
	 */
	public function injectBase(INavigationFactory $navigationFactory)
	{
		$this->navigationFactory = $navigationFactory;
	}


	protected function beforeRender()
	{
		parent::beforeRender();
		$this->template->lang = $this->lang;
	}

	/**
	 * @return Navigation
	 */
	protected function createComponentNavigation()
	{
		return $this->navigationFactory->create($this->lang);
	}

}
