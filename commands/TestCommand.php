<?php

namespace Grapesc\GrapeFluid\CoreModule\Command;

use Grapesc\GrapeFluid\BaseParametersRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;


class TestCommand extends Command
{

	/** @var BaseParametersRepository @inject */
	public $baseParametersRepository;


	public function configure()
	{
		$this->setName('test:parameters')
			->addOption('param', 'p', InputOption::VALUE_OPTIONAL, 'show only specific param')
			->setDescription("List all parameters from Fluid BaseParametersRepository");
	}


	protected function execute(InputInterface $input, OutputInterface $output)
	{
		if ($input->getOption('param')) {
			if (key_exists($input->getOption('param'), $this->baseParametersRepository->getAllParams())) {
				$output->writeln("<info>Value of param {$input->getOption('param')} is {$this->baseParametersRepository->getParam($input->getOption('param'))}.</info>");
			} else {
				$output->writeln("<error>Param {$input->getOption('param')} not found.</error>");
			}
		} else {
			foreach ($this->baseParametersRepository->getAllParams() AS $key => $value) {
				$output->writeln("<info> " . $key . ": " . $value . " </info>");
			}
		}
	}

}