<?php

namespace App\DataFixtures;

use App\Entity\Currency;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CurrencyFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        // $product = new Product();
        // $manager->persist($product);

		$usd = new Currency();
		$usd->setCode('USD');
		$usd->setTitle('Доллар США');
		$manager->persist($usd);

		$eur = new Currency();
		$eur->setCode('EUR');
		$eur->setTitle('Евро');
		$manager->persist($eur);

		$mdl = new Currency();
		$mdl->setCode('MDL');
		$mdl->setTitle('Молдавский лей');
		$manager->persist($mdl);

        $manager->flush();
    }
}
