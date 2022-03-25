<?php

namespace App\Controller;

use App\Repository\VilleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/ville", name="ville_")
 */
class VilleController extends AbstractController
{
    /**
     * @param VilleRepository $repository
     * @return Response
     * @Route("/", name="villes")
     */
    public function ville(VilleRepository $repository): Response
    {
        $villes = $repository->findAll();
        return $this->render('ville/villes.html.twig', [
            'villes' => $villes,
        ]);
    }
}
