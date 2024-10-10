<?php

namespace Grapesc\GrapeFluid\CoreModule\Command;

use Grapesc\GrapeFluid\MigrationService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class MigrationUpCommand extends Command
{

	/** @var MigrationService @inject */
	public $migrationService;


	public function configure()
	{
		$this->setName('migration:up')
			->addOption('force', 'f', InputOption::VALUE_NONE,'Ignore SQL errors in migrations');
	}


	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$this->migrationService->up($output, false, (bool) $input->getOption('force'));

		return Command::SUCCESS;
	}

}
