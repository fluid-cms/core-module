<?php

namespace Grapesc\GrapeFluid\CoreModule\Command;

use Grapesc\GrapeFluid\AssetRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class AssetsShowPackagesCommand extends Command
{

	/** @var AssetRepository @inject */
	public $assets;


	public function configure()
	{
		$this->setName('assets:packages-show');
	}


	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$output->writeln("<info>Assets (sorted, removed disabled):</info>");
		foreach ($this->assets->getAssets() as $name => $asset) {
			$output->writeln($name);
		}

		return Command::SUCCESS;
	}

}