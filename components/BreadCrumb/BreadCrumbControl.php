<?php

namespace Grapesc\GrapeFluid\CoreModule\Control\BreadCrumb;

/**
 * BreadCrumbControl
 */
use Grapesc\GrapeFluid\CoreModule\Service\BreadCrumbService;
use Grapesc\GrapeFluid\MagicControl\BaseMagicTemplateControl;

class BreadCrumbControl extends BaseMagicTemplateControl
{

	/** @var BreadCrumbService */
	private $breadCrumbService;

	/** @var string */
	protected $defaultTemplateFilename =  __DIR__ . '/BreadCrumb.latte';


	/**
	 * BreadCrumbControl constructor.
	 * @param BreadCrumbService $breadCrumbService
	 */
	public function __construct(BreadCrumbService $breadCrumbService)
	{
		$this->breadCrumbService = $breadCrumbService;
	}


	/**
	 * Render function
	 */
	public function render()
	{
		$this->template->links = $this->breadCrumbService->getLinks();
		$this->template->show  = $this->breadCrumbService->isVisible();
		$this->template->render();
	}


	/**
	 * @param array $params
	 */
	public function setParams(array $params = [])
	{
	}

}