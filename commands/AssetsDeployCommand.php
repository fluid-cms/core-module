<?php

namespace Grapesc\GrapeFluid\CoreModule\Command;

use Grapesc\GrapeFluid\AssetRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class AssetsDeployCommand extends Command
{

	/** @var AssetRepository @inject */
	public $assets;


	public function configure()
	{
		$this->setName('assets:deploy')
			->addOption("u", false, InputOption::VALUE_NONE, "Deploy upload files only");
	}


	protected function execute(InputInterface $input, OutputInterface $output)
	{
		if ($input->getOption("u")) {
			$output->writeln("<info>Deploying upload files...</info>");
			$i = 0;
			foreach ($this->assets->forceDeployUpload() as $path) {
				$output->writeln("<info>Deployed - $path</info>");
				$i++;
			}
			$output->writeln("<info>$i upload files successfully deployed</info>");
		} else {
			$output->writeln("<info>Deploying assets files...</info>");
			$i = 0;
			foreach ($this->assets->deployAssets(true) as $path) {
				$output->writeln("<info>Deployed - $path</info>");
				$i++;
			}
			$output->writeln("<info>$i assets files successfully deployed</info>");
			$output->writeln("<info>Assets were re-cached</info>");
		}
	}

}