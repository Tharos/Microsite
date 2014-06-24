<?php

namespace Microsite\Auth;

use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette\Security\AuthenticationException;
use Nette\Security\User;

/**
 * @author Vojtěch Kohout
 */
class SignForm extends Control
{

	/** @var array */
	public $onSuccess;

	/** @var User */
	private $user;


	/**
	 * @param User $user
	 */
	public function __construct(User $user)
	{
		$this->user = $user;
	}


	public function render()
	{
		echo $this['form'];
	}

	/**
	 * @param Form $form
	 */
	public function processForm(Form $form)
	{
		$values = $form->getValues();
		try {
			$this->user->login($values->username, $values->password);
			$this->onSuccess();
		} catch (AuthenticationException $e) {
			$form->addError('Zadané přihlašovací údaje nejsou platné.');
		}
	}

	/**
	 * @return Form
	 */
	protected function createComponentForm()
	{
		$form = new Form;

		$form->addText('username', 'Uživ. jméno')->setRequired();
		$form->addPassword('password', 'Heslo')->setRequired();
		$form->addSubmit('submit', 'Přihlásit se');

		$form->onSuccess[] = $this->processForm;

		return $form;
	}

}
