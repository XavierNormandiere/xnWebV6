<?php

namespace App\Controller;

use App\Repository\VisiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/visite", name="visite_")
 */
class VisiteController extends AbstractController
{
    /**
     * @param VisiteRepository $repository
     * @return Response
     * @Route("/", name="visites")
     */
    public function listVisites(VisiteRepository $repository): Response
    {
        $visites = $repository->findAll();
        return $this->render('visite/listVisites.html.twig', [
            'visites' => $visites
        ]);
    }

    /**
     * @param VisiteRepository $repository
     * @param int $id
     * @return Response
     * @Route("/detailVisite/{id}", name="detailVisite")
     */
    public function detailVisite(VisiteRepository $repository, int $id): Response
    {
        $visite = $repository->find($id);
        if (!$visite){
            throw $this->createNotFoundException('Erreur : destination inexistante');
        }
        return $this->render('visite/detailVisite.html.twig', [
           'visite'=>$visite
        ]);
    }



}
