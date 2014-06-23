<?php

namespace Microsite\Domain;

use Exception;
use Nette\Application\AbortException;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

/**
 * @author Vojtěch Kohout
 */
class ContentsForm extends Control
{

	/** @var array */
	public $onSuccess;

	/** @var Content[] */
	private $contents;

	/** @var ContentRepository */
	private $contentRepository;


	/**
	 * @param Content[] $contents
	 * @param ContentRepository $contentRepository
	 */
	public function __construct(ContentRepository $contentRepository, array $contents)
	{
		$this->contents = $contents;
		$this->contentRepository = $contentRepository;
	}


	public function render()
	{
		$this->template->contents = $this->contents;
		$this->template->render(__DIR__ . '/templates/contentsForm.latte');
	}

	/**
	 * @param Form $form
	 * @throws AbortException
	 */
	public function processForm(Form $form)
	{
		$values = $form->getValues();
		try {
			foreach ($this->contents as $content) {
				$html = $values['c' . $content->id];
				if ($html !== $content->html) {
					$content->html = $html === '' ? null : $html;
					$this->contentRepository->persist($content);
				}
			}
			$this->onSuccess();

		} catch (Exception $e) {
			if ($e instanceof AbortException) {
				throw $e;
			}
			$form->addError('Při ukládání obsahů došlo k následující chybě: ' . lcfirst($e->getMessage()));
		}
	}

	/**
	 * @return Form
	 */
	protected function createComponentForm()
	{
		$form = new Form;

		if (!empty($this->contents)) {
			foreach ($this->contents as $content) {
				$form->addTextArea('c' . $content->id)
					->setDefaultValue($content->html);
			}

			$form->addSubmit('submit', 'Uložit změny');

			$form->onSuccess[] = [$this, 'processForm'];
		}
		return $form;
	}

}
