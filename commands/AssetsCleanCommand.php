<?php

namespace Grapesc\GrapeFluid\CoreModule\Command;

use Grapesc\GrapeFluid\AssetRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class AssetsCleanCommand extends Command
{

	/** @var AssetRepository @inject */
	public $assets;


	public function configure()
	{
		$this->setName('assets:clean');
	}


	/** {@inheritdoc} */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$this->assets->clean(null, $output);
	}

}