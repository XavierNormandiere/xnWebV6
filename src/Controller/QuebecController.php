<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class QuebecController extends AbstractController
{
    /**
     * @Route("/quebec", name="app_quebec")
     */
    public function index(): Response
    {
        return $this->render('quebec/quebec.html.twig', [
            'controller_name' => 'QuebecController',
        ]);
    }
}
