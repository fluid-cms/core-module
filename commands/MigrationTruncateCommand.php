<?php

namespace Grapesc\GrapeFluid\CoreModule\Command;

use Grapesc\GrapeFluid\MigrationService;
use Nette\Utils\Random;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Exception\RuntimeException;


class MigrationTruncateCommand extends Command
{

	/** @var MigrationService @inject */
	public $migrationService;


	public function configure()
	{
		$this->setName('migration:truncate');
	}


	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$question = $this->getHelper('question');
		$token = Random::generate(10);

		$skipQuestion = new Question('<question>Skip tables (use "," separator): [admin_user]</question>', 'admin_user');
		$skipQuestion->setValidator(function ($val) {
			if (is_array($tables = explode(",", $val))) {
				return $tables;
			} else {
				throw new RuntimeException("Creating list of table field. Try again");
			}
		});

		$tables = $question->ask($input, $output, $skipQuestion);

		$verificationQuestin = new Question('<question>Confirm the action: [' . $token . ']</question> ');
		$verificationQuestin->setValidator(function($val) use ($token) {
			if ($token == $val) {
				return true;
			} else {
				throw new RuntimeException("Verification token doesn't match. Try again.");
			}
		});

		if ($question->ask($input, $output, $verificationQuestin)) {
			$this->migrationService->truncate($output, $tables);
		}

		return Command::SUCCESS;
	}

}