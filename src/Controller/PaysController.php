<?php

namespace App\Controller;

use App\Repository\PaysRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/pays", name="pays_")
 */
class PaysController extends AbstractController
{
    /**
     * @param PaysRepository $repository
     * @return Response
     * @Route("/", name="pays")
     */
    public function pays(PaysRepository $repository): Response
    {
        $payss = $repository->findAll();
        return $this->render('pays/pays.html.twig', [
            'payss' => $payss,
        ]);
    }
}
