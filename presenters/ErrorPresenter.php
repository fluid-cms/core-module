<?php

namespace Grapesc\GrapeFluid\CoreModule\Presenters;

use Grapesc\GrapeFluid\BaseParametersRepository;
use Nette;
use Nette\Application\BadRequestException;
use Nette\Application\Request;
use Nette\Application\Response;
use Nette\Application\Responses\CallbackResponse;
use Nette\Application\Responses\ForwardResponse;
use Nette\Application\Responses\RedirectResponse;
use Nette\Http\IResponse;
use Nette\Http\Url;
use Tracy\ILogger;


class ErrorPresenter implements Nette\Application\IPresenter
{

	/** @var ILogger */
	private $logger;

	/** @var BaseParametersRepository */
	private $baseParametersRepository;


	public function __construct(ILogger $logger, BaseParametersRepository $baseParametersRepository)
	{
		$this->logger                   = $logger;
		$this->baseParametersRepository = $baseParametersRepository;
	}


	/**
	 * @param Request $request
	 * @return Nette\Application\IResponse
	 */
	public function run(Request $request): Response
	{
		$e = $request->getParameter('exception');

		if ($e instanceof BadRequestException) {
			if ($e->getCode() == IResponse::S403_FORBIDDEN) {
				$previousPresenter = $request->getParameter('previousPresenter');
				$storedRequestKey = $previousPresenter && property_exists($previousPresenter, 'storedRequestKey') ? $previousPresenter->storedRequestKey : null;
				$redirectUrl = $this->baseParametersRepository->getParam('redirect_url');
				if ($redirectUrl) {
					$this->baseParametersRepository->setParam('redirect_url', null);
					if ($storedRequestKey) {
						$url = new Url($redirectUrl);
						$url->appendQuery(['backlink' => $storedRequestKey]);
						$redirectUrl = $url->getAbsoluteUrl();
					}
					return new RedirectResponse($redirectUrl, IResponse::S302_FOUND);
				}
			}

			return new ForwardResponse($request->setPresenterName('Core:Error4xx'));
		}

		$this->logger->log($e, ILogger::EXCEPTION);
		return new CallbackResponse(function () {
			require __DIR__ . '/../templates/Error/500.phtml';
		});
	}

}
