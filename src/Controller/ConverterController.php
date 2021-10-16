<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ConverterController extends AbstractController
{
    /**
     * @Route("/converter", name="converter")
     */
    public function index(): Response
    {
        return $this->render('converter/index.html.twig', [
            'controller_name' => 'ConverterController',
        ]);
    }
}
