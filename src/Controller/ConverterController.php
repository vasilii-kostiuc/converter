<?php

namespace App\Controller;

use App\Converter\CurrencyExchangeInterface;
use App\Converter\CurrencyRatesMap;
use App\Converter\CurrencyRatesSyncronizer;
use App\Converter\ExchangeRatesClient;
use App\Entity\CurrencyRate;
use App\Repository\CurrencyRateRepository;
use App\Repository\CurrencyRepository;
use App\Repository\SyncronizationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class ConverterController extends AbstractController {

	private CurrencyRepository $currencyRepository;
	private CurrencyRateRepository $currencyRateRepository;

	public function __construct(CurrencyRepository $currencyRepository, CurrencyRateRepository $currencyRateRepository) {
		$this->currencyRepository = $currencyRepository;
		$this->currencyRateRepository = $currencyRateRepository;
	}


	/**
	 * @Route("/", name="converter")
	 */
	public function index(): Response {
		return $this->render('converter/index.html.twig', [
			'currencies' => $this->currencyRepository->findAll(),
		]);
	}

	/**
	 * @Route("/currencies_map", name="convert")
	 */
	public function getCurrencyRatesMap(Request $request) {
		$currencies = $this->currencyRepository->findAll();
		$currencyRatesMap = new CurrencyRatesMap($currencies, $this->currencyRateRepository);
		return $this->json($currencyRatesMap->getCurrencyMap());
	}

}
