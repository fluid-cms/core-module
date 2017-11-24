<?php

namespace Grapesc\GrapeFluid\CoreModule\Command;

use Grapesc\GrapeFluid\MigrationService;
use Nette\Utils\Random;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Exception\RuntimeException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;


class MigrationReinstallCommand extends Command
{

	/** @var MigrationService @inject */
	public $migrationService;


	public function configure()
	{
		$this->setName('migration:reinstall');
	}


	protected function execute(InputInterface $input, OutputInterface $output)
	{

		$question = $this->getHelper('question');
		$token = Random::generate(10);

		$verificationQuestin = new Question('<question>Confirm the action: [' . $token . ']</question> ');
		$verificationQuestin->setValidator(function($val) use ($token) {
			if ($token == $val) {
				return true;
			} else {
				throw new RuntimeException("Verification token doesn't match. Try again.");
			}
		});

		if ($question->ask($input, $output, $verificationQuestin)) {
			$this->migrationService->up($output, true);
		}
	}

}