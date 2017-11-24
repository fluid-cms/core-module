<?php

namespace Grapesc\GrapeFluid\Module\Core;


use Nette\Config\Configurator;

class CoreModule extends \Grapesc\GrapeFluid\BaseModule
{

	protected $parents = [];

	/**
	 * Zaregistruje config soubor(y) daného modulu
	 * @param Configurator $configurator
	 */
	protected function registerConfig(Configurator $configurator)
	{
		parent::registerConfig($configurator);
		$configurator->addConfig(__DIR__ . DIRECTORY_SEPARATOR . "config/configuration.neon");
	}

}