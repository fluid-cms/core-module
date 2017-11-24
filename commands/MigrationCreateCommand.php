<?php

namespace Grapesc\GrapeFluid\CoreModule\Command;

use Grapesc\GrapeFluid\MigrationService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;


class MigrationCreateCommand extends Command
{

	/** @var MigrationService @inject */
	public $migrationService;


	public function configure()
	{
		$this->setName('migration:create');
	}


	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$question = $this->getHelper('question');

		$moduleQuestion = new Question('<question>Module name or [project]: [core]</question> ', "core");
		$moduleQuestion->setValidator(function($val) {
			if ($this->migrationService->createMigrationFile(ucfirst(strtolower($val)))) {
				return $val;
			} else {
				throw new RuntimeException("Module '$val' doesn't exists.");
			}
		});

		$module = $question->ask($input, $output, $moduleQuestion);
		$output->write("New migration file for " . ($module == "project" ? "project" : "module '" . $module . "'") . " successfully created!");
	}

}