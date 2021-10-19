<?php

namespace App\Converter;

interface CurrencyExchangeInterface{
	public function latest(string $base,array $symbols);
}