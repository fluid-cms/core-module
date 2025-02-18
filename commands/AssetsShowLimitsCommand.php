<?php

namespace Grapesc\GrapeFluid\CoreModule\Command;

use Grapesc\GrapeFluid\AssetRepository;
use Grapesc\GrapeFluid\BaseParametersRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class AssetsShowLimitsCommand extends Command
{

	/** @var BaseParametersRepository @inject */
	public $params;

	/** @var AssetRepository @inject */
	public $assets;


	public function configure()
	{
		$this->setName('assets:limits-show')
			->addOption("copy", "c", InputOption::VALUE_NONE, "Include copy files")
			->addOption("filter", "f", InputOption::VALUE_OPTIONAL, "Filter by given Nette link", null)
			->addOption("description", "d", InputOption::VALUE_NONE, "Show file description");
	}


	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		if (($filter = $input->getOption("filter")) !== null) {
			$output->writeln("Assets only for limit [$filter]:");
			$this->processFiles($this->assets->getForCurrentLink("css", $filter) + $this->assets->getForCurrentLink("js", $filter), $input, $output);
		} else {
			foreach ($this->assets->getFileList() as $limit => $files) {
				if (empty($files)) {
					continue;
				}
				$output->writeln("<info>Assets for limit [$limit]:</info>");
				$this->processFiles($files, $input, $output);
				$output->write("\n");
			}
		}

		return Command::SUCCESS;
	}


	private function processFiles($files, InputInterface $input, OutputInterface $output)
	{
		foreach ($files as $path => $desc) {
			if ($input->getOption("copy") === false && $desc['type'] == "copy") {
				continue;
			} else {
				$output->writeln("<info>" . str_replace(DIRECTORY_SEPARATOR, "/", str_replace($this->params->getParam("appDir"), "", $path)) . ($input->getOption("description") ? " - " . json_encode($desc) : "") . "</info>");
			}
		}
	}

}