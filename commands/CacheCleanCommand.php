<?php

namespace Grapesc\GrapeFluid\CoreModule\Command;

use Grapesc\GrapeFluid\Console\WithoutContainerCommand;
use Nette\Utils\Finder;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


class CacheCleanCommand extends WithoutContainerCommand
{

	/** @var OutputInterface */
	private $output;


	public function configure()
	{
		$this->setName('cache:clean');
	}


	/** {@inheritdoc} */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$this->output             = $output;
		$baseParametersRepository = $this->getFluidHelper()->getBaseParametersRepository();

		$this->clean($baseParametersRepository->getParam('tempDir') . 'cache', true);
		$this->clean($baseParametersRepository->getParam('tempDir'), true);
	}


	/**
	 * @param string $path
	 * @param bool $grantParent
	 */
	private function clean($path, $grantParent = false)
	{
		$output = $this->output;
		$directory = realpath($path);

		if (!is_dir($directory)) {
			return;
		}

		foreach (Finder::find('*')->in($directory) AS $item) {
			/* @var $item \SplFileInfo */
			if ($item->isDir()) {
				if ($grantParent) {
					$output->writeln("<comment>Deleting {$item->getPathname()}</comment>");
				}
				$this->clean($item->getPathname());

				if (!@rmdir($item->getPathname())) {
					$output->writeln("<error>Can`t delete directory {$item->getPathname()}</error>");
				}
			} elseif ($item->isFile()) {
				if (!@unlink($item->getPathname())) {
					$output->writeln("<error>Can`t delete file {$item->getPathname()}</error>");
				}
			}
		}
	}

}