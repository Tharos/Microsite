<?php

namespace Microsite\Application;

use Microsite\Auth\ISignFormFactory;
use Microsite\Auth\SignForm;

/**
 * @author Vojtěch Kohout
 */
class SignPresenter extends Presenter
{

	/** @var ISignFormFactory */
	private $signFormFactory;


	/**
	 * @param ISignFormFactory $signFormFactory
	 */
	public function __construct(ISignFormFactory $signFormFactory)
	{
		$this->signFormFactory = $signFormFactory;
	}


	public function startup()
	{
		parent::startup();
		if ($this->getUser()->isLoggedIn()) {
			$this->redirect('Admin:');
		}
	}

	/**
	 * @return SignForm
	 */
	protected function createComponentSignForm()
	{
		$signForm = $this->signFormFactory->create();

		$signForm->onSuccess[] = function () {
			$this->redirect('Admin:');
		};

		return $signForm;
	}

}
