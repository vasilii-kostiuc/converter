<?php
/**
 * converter - SyncronizeCurrencyRatesCommand.php
 *
 * Created by Admin
 * Created on: 20.10.2021 21:49
 */

namespace App\Command;


use App\Converter\CurrencyRatesSyncronizer;
use App\Repository\CurrencyRateRepository;
use App\Repository\CurrencyRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SyncronizeCurrencyRatesCommand extends \Symfony\Component\Console\Command\Command {
// название команды (часть после "bin/console")
	protected static $defaultName = 'app:sincronize-currency-rates';

	private CurrencyRatesSyncronizer $currencyRatesSincronizer;

	private CurrencyRepository $currencyRepository;

	public function __construct(CurrencyRatesSyncronizer $sincronizer, CurrencyRepository $currencyRepository)
	{
		parent::__construct();
		$this->currencyRatesSincronizer = $sincronizer;
		$this->currencyRepository = $currencyRepository;
	}

	protected function configure(): void
	{
		// ...
	}

	protected function execute(InputInterface $input, OutputInterface $output): int
	{
		$currenciesForSincronization = $this->currencyRepository->findAll();
		$this->currencyRatesSincronizer->syncronize($currenciesForSincronization);
		return Command::SUCCESS;
	}
}