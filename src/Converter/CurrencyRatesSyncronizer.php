<?php
/**
 * converter - CurrencyRatesSyncronizer.php
 *
 * Created by Admin
 * Created on: 18.10.2021 19:45
 */

namespace App\Converter;


use App\Entity\Syncronization;
use App\Repository\CurrencyRepository;
use App\Repository\SyncronizationRepository;
use Doctrine\ORM\EntityManagerInterface;

class CurrencyRatesSyncronizer {

	private CurrencyExchangeInterface $exchange;

	private EntityManagerInterface $entityManager;

	private SyncronizationRepository $syncRepozitory;

	private CurrencyRepository $currencyRepository;

	private array $currencies;

	public function __construct(CurrencyExchangeInterface $exchange, EntityManagerInterface $entityManager, SyncronizationRepository $syncRepository, CurrencyRepository $currencyRepository) {
		$this->exchange = $exchange;
		$this->entityManager = $entityManager;
		$this->syncRepozitory = $syncRepository;
		$this->currencyRepository = $currencyRepository;
	}

	public function syncronize() {
		$currencies = [];
		foreach ($this->currencyRepository->findAll() as $currency) {
			$currencies[$currency->getCode()] = $currency;
		}

		$currencyCodes = array_keys($currencies);

		foreach ($currencies as $currency) {
			$symbols = array_diff($currencyCodes, [$currency->getCode()]);
			$latestRates = $this->exchange->latest($currency->getCode(), $symbols);
			$this->saveRates($latestRates, $currencies);
		}
	}

	private function saveRates(array $rates, array $currencies) {
		foreach ($rates['rates'] as $currencyCode => $value) {
			$sync = new Syncronization();
			$sync->setFromCurrency($currencies[$rates['base']]);
			$sync->setToCurrency($currencies[$currencyCode]);
			$sync->setValue($value);
			$sync->setSyncronizedAt(new \DateTime($rates['date']));

			$this->entityManager->persist($sync);
		}
		$this->entityManager->flush();
	}

}