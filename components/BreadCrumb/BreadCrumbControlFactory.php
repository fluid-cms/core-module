<?php

namespace Grapesc\GrapeFluid\CoreModule\Control\BreadCrumb;

use Grapesc\GrapeFluid\CoreModule\Service\BreadCrumbService;
use Grapesc\GrapeFluid\MagicControl\IFactory;


class BreadCrumbControlFactory implements IFactory
{

	/** @var BreadCrumbService @inject */
	public $breadCrumbService;


	public function create()
	{
		return new BreadCrumbControl($this->breadCrumbService);
	}

}
