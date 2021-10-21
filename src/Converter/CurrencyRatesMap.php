<?php
/**
 * converter - CurrencyRatesMap.php
 *
 * Created by Admin
 * Created on: 21.10.2021 8:35
 */

namespace App\Converter;


use App\Entity\CurrencyRate;
use App\Repository\CurrencyRateRepository;

class CurrencyRatesMap {

	private array $currencyMap;

	private array $currencies;

	private CurrencyRateRepository $currencyRatesRepository;

	public function __construct(array $currencies, CurrencyRateRepository $currencyRatesRepository) {
		$this->currencies = $currencies;
		$this->currencyRatesRepository = $currencyRatesRepository;

		$this->buildCurrencyMap();
	}

	private function buildCurrencyMap() {
		foreach ($this->currencies as $currencyFrom) {
			foreach ($this->currencies as $currencyTo) {
				if ($currencyFrom->getId() != $currencyTo->getId()) {
					$rate = $this->currencyRatesRepository->findRate($currencyFrom->getId(), $currencyTo->getId());
					$this->currencyMap[$currencyFrom->getCode()][$currencyTo->getCode()] = ['value' => $rate->getValue(), 'date' => $rate->getDate()->format('d.m.Y')];
				}
			}
		}
	}

	/**
	 * @return array
	 */
	public function getCurrencies(): array {
		return $this->currencies;
	}

	/**
	 * @return array
	 */
	public function getCurrencyMap(): array {
		return $this->currencyMap;
	}

	public function convert(string $codeFrom, string $codeTo, $amount): float {
		if ($codeFrom == $codeTo) {
			return $amount;
		}

		if (!isset($this->currencyMap[$codeFrom][$codeTo])) {
			return $amount * $this->currencyMap[$codeFrom][$codeTo]['value'];
		} else {
			throw new \Exception("$codeFrom or/and $codeTo not found in currency map");
		}
	}


}