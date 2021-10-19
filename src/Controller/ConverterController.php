<?php

namespace App\Controller;

use App\Converter\CurrencyExchangeInterface;
use App\Converter\CurrencyRatesSyncronizer;
use App\Converter\ExchangeRatesClient;
use App\Repository\CurrencyRepository;
use App\Repository\SyncronizationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConverterController extends AbstractController {
	/**
	 * @Route("/converter", name="converter")
	 */
	public function index(CurrencyRepository $currencyRepository,SyncronizationRepository $syncRepository): Response {

		return $this->render('converter/index.html.twig', [
			'controller_name' => 'ConverterController',
			'currencies' => $currencyRepository->findAll()
		]);
	}
}
