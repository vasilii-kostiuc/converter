<?php
/**
 * converter - CurrencyRatesSyncronizer.php
 *
 * Created by Admin
 * Created on: 18.10.2021 19:45
 */

namespace App\Converter;


use App\Entity\CurrencyRate;
use App\Entity\Syncronization;
use App\Repository\CurrencyRateRepository;
use Doctrine\ORM\EntityManagerInterface;

class CurrencyRatesSyncronizer {

	private CurrencyExchangeInterface $exchange;

	private EntityManagerInterface $entityManager;

	private CurrencyRateRepository $currencyRateRepository;

	public function __construct(CurrencyExchangeInterface $exchange, EntityManagerInterface $entityManager, CurrencyRateRepository $currencyRateRepository) {
		$this->exchange = $exchange;
		$this->entityManager = $entityManager;
		$this->currencyRateRepository = $currencyRateRepository;
	}

	public function syncronize(array $currencies) {
		$currenciesAssoc = [];
		foreach ($currencies as $currency) {
			$currenciesAssoc[$currency->getCode()] = $currency;
		}

		$currencyCodes = array_keys($currenciesAssoc);

		foreach ($currencies as $currency) {
			$symbols = array_diff($currencyCodes, [$currency->getCode()]);
			$latestRates = $this->exchange->latest($currency->getCode(), $symbols);
			$this->saveRates($latestRates, $currenciesAssoc);
		}
	}

	private function saveRates(array $rates, array $currenciesAssoc) {
		foreach ($rates['rates'] as $currencyCode => $value) {
			$currRate = new CurrencyRate();
			$currRate->setFromCurrency($currenciesAssoc[$rates['base']]);
			$currRate->setToCurrency($currenciesAssoc[$currencyCode]);
			$currRate->setValue($value);
			$currRate->setDate(new \DateTime($rates['date']));

			$this->entityManager->persist($currRate);
		}
		$this->entityManager->flush();
	}

}