<?php
/**
 * converter - ExchangeRatesClient.php
 *
 * Created by Admin
 * Created on: 17.10.2021 13:05
 */

namespace App\Converter;


class ExchangeRatesClient implements CurrencyExchangeInterface {

	private string $apiUrl;

	private string $apiKey;

	public function __construct(string $apiUrl, string $apiKey) {
		$this->apiUrl = $apiUrl;
		$this->apiKey = $apiKey;
	}

	public function latest(string $base, array $symbols) {
		$latestRates = [];

		$response = $this->request('latest', ['base' => $base, 'symbols' => implode(',', $symbols)]);

		$latestRates['date'] = $response['date'];
		$latestRates['base'] = $response['base'];
		$latestRates['rates'] = $response['rates'];

		return $latestRates;
	}

	private function request($endpoint, array $params) {
		$allParams = array_merge(['access_key' => $this->apiKey], $params);
		$query = http_build_query($allParams);

		$ch = curl_init($this->apiUrl . $endpoint . '?' . $query);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$json = curl_exec($ch);
		curl_close($ch);
		$response = json_decode($json, true);
		dump($response);
		if ($response['error']) {
			throw new \Exception($response['error']['info']);
		}

		return $response;
	}
}