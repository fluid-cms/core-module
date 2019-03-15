<?php

namespace Grapesc\GrapeFluid\CoreModule\Model;

use Grapesc\GrapeFluid\Model\BaseModel;
use Grapesc\GrapeFluid\Model\CachedModel;


class SettingModel extends BaseModel
{

	use CachedModel;


	public function startup()
	{
		$this->assocBy = 'variable';
	}


	/**
	 * @param $var
	 * @return mixed
	 */
	public function getVal($var)
	{
		return $this->getItem($var)['value'];
	}

}