<?php

namespace Microsite\Domain;

/**
 * @author Vojtěch Kohout
 */
class ContentsFormFactory
{

	/** @var ContentRepository */
	private $contentRepository;


	/**
	 * @param ContentRepository $contentRepository
	 */
	public function __construct(ContentRepository $contentRepository)
	{
		$this->contentRepository = $contentRepository;
	}

	/**
	 * @param Content[] $contents
	 * @return ContentsForm
	 */
	public function create(array $contents)
	{
		return new ContentsForm($this->contentRepository, $contents);
	}

} 
