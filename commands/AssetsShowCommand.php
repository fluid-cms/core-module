<?php

namespace Grapesc\GrapeFluid\CoreModule\Command;

use Grapesc\GrapeFluid\AssetRepository;
use Grapesc\GrapeFluid\BaseParametersRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class AssetsShowCommand extends Command
{

	/** @var BaseParametersRepository @inject */
	public $params;

	/** @var AssetRepository @inject */
	public $assets;


	public function configure()
	{
		$this->setName('assets:show')
			->addOption("c", false, InputOption::VALUE_NONE, "Include copy files");
	}


	protected function execute(InputInterface $input, OutputInterface $output)
	{
		foreach ($this->assets->getFileList() as $limit => $files) {
			foreach ($files as $path => $desc) {
				if ($input->getOption("c") === false && $desc['type'] == "copy") {
					continue;
				} else {
					$output->writeln("<info>" . str_replace(DIRECTORY_SEPARATOR, "/", str_replace($this->params->getParam("appDir"), "", $path)) . " - " . implode(", ", $desc) . "</info>");
				}
			}
		}
	}

}