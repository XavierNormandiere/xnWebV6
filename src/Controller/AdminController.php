<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Entity\Pays;
use App\Entity\Ville;
use App\Entity\Visite;
use App\Form\ContactType;
use App\Form\PaysType;
use App\Form\VilleType;
use App\Form\VisiteType;
use App\Repository\ContactRepository;
use App\Repository\PaysRepository;
use App\Repository\VilleRepository;
use App\Repository\VisiteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @param ContactRepository $repository
     * @param VisiteRepository $visiteRepository
     * @param PaysRepository $paysRepository
     * @param VilleRepository $villeRepository
     * @return Response
     * @Route("/", name="admin")
     */
    public function admin(ContactRepository $repository,
                          VisiteRepository $visiteRepository,
                          PaysRepository $paysRepository,
                          VilleRepository $villeRepository): Response
    {
        $contacts = $repository->findAll();
        $visites =$visiteRepository->findAll();
        $villes = $villeRepository->findAll();
        $payss = $paysRepository->findAll();
        return $this->render('admin/admin.html.twig', [
            'contacts' => $contacts,
            'visites'=>$visites,
            'villes'=>$villes,
            'payss'=>$payss,
        ]);
    }

    /**
     * @param Request $request
     * @param Contact $contact
     * @param EntityManagerInterface $em
     * @return Response
     * @Route("/editContact/{id}", name="editContact")
     */
    public function editContact(Request $request, Contact $contact, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em->flush();
            $this->addFlash('success', 'Modification enregistr??e avec succ??s !!');
            return $this->redirectToRoute('admin_admin');
        }
        $formView = $form->createView();
        return $this->render('admin/editContact.html.twig', [
            'form'=>$formView
        ]);
    }


    /**
     * @param Request $request
     * @param Contact $contact
     * @param EntityManagerInterface $em
     * @return Response
     * @Route("/deleteContact/{id}", name="deleteContact")
     */
    public function deleteContact(Request $request, Contact $contact, EntityManagerInterface $em): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $em->remove($contact);
            $em->flush();
            $this->addFlash('success', 'Contact supprim?? avec succ??s !!');
            return $this->redirectToRoute('admin_admin');
        }
        $formView = $form->createView();
        return $this->render('admin/deleteContact.html.twig', [
            'form'=>$formView
        ]);
    }


    /**
     * @param Request $request
     * @param SluggerInterface $slugger
     * @param EntityManagerInterface $em
     * @return Response
     * @Route("/newVisite", name="newVisite")
     */
    public function createVisite(Request $request, SluggerInterface $slugger, EntityManagerInterface $em): Response
    {
        $visite = new Visite();
        $formVisite = $this->createForm(VisiteType::class, $visite);
        $formVisite->handleRequest($request);
        if (($formVisite->isSubmitted() && $formVisite->isValid())){
            $imgFile1 = $formVisite->get('img1')->getData();
            $imgFile2 = $formVisite->get('img2')->getData();
            $imgFile3 = $formVisite->get('img3')->getData();

            if ($imgFile1){
                $originalFilename = pathinfo($imgFile1->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$imgFile1->guessExtension();
                try {
                    $imgFile1->move($this->getParameter('visite_directory'), $newFilename);
                } catch (FileException $exception){
                    return $this->redirectToRoute('visite_visites');
                }
                $visite->setImg1($newFilename);
            }

            if ($imgFile2){
                $originalFilename = pathinfo($imgFile2->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$imgFile2->guessExtension();
                try {
                    $imgFile2->move($this->getParameter('visite_directory'), $newFilename);
                } catch (FileException $exception){
                    return $this->redirectToRoute('visite_visites');
                }
                $visite->setImg2($newFilename);
            }

            if ($imgFile3){
                $originalFilename = pathinfo($imgFile3->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$imgFile3->guessExtension();
                try {
                    $imgFile3->move($this->getParameter('visite_directory'), $newFilename);
                } catch (FileException $exception){
                    return $this->redirectToRoute('visite_visites');
                }
                $visite->setImg3($newFilename);
            }

            $em->persist($visite);
            $em->flush();
            $this->addFlash('success', 'Nouvelle visite ajout??e avec succ??s !!');
            return $this->redirectToRoute('visite_visites');
        }
        $formView = $formVisite->createView();
        return $this->render('admin/newVisite.html.twig', [
           'formVisite'=>$formView
        ]);
    }


    /**
     * @param Request $request
     * @param Visite $visite
     * @param SluggerInterface $slugger
     * @param EntityManagerInterface $em
     * @return Response
     * @Route("/editVisite/{id}", name="editVisite")
     */
    public function editVisite(Request $request, Visite $visite, SluggerInterface $slugger, EntityManagerInterface $em): Response
    {
        $formVisite = $this->createForm(VisiteType::class, $visite);
        $formVisite->handleRequest($request);
        if (($formVisite->isSubmitted() && $formVisite->isValid())){
            $imgFile1 = $formVisite->get('img1')->getData();
            $imgFile2 = $formVisite->get('img2')->getData();
            $imgFile3 = $formVisite->get('img3')->getData();

            if ($imgFile1){
                $originalFilename = pathinfo($imgFile1->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$imgFile1->guessExtension();
                try {
                    $imgFile1->move($this->getParameter('visite_directory'), $newFilename);
                } catch (FileException $exception){
                    return $this->redirectToRoute('visite_visites');
                }
                $visite->setImg1($newFilename);
            }

            if ($imgFile2){
                $originalFilename = pathinfo($imgFile2->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$imgFile2->guessExtension();
                try {
                    $imgFile2->move($this->getParameter('visite_directory'), $newFilename);
                } catch (FileException $exception){
                    return $this->redirectToRoute('visite_visites');
                }
                $visite->setImg2($newFilename);
            }

            if ($imgFile3){
                $originalFilename = pathinfo($imgFile3->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$imgFile3->guessExtension();
                try {
                    $imgFile3->move($this->getParameter('visite_directory'), $newFilename);
                } catch (FileException $exception){
                    return $this->redirectToRoute('visite_visites');
                }
                $visite->setImg3($newFilename);
            }

            $em->persist($visite);
            $em->flush();
            $this->addFlash('success', 'Visite modifi??e avec succ??s !!');
            return $this->redirectToRoute('visite_visites');
        }
        $formView = $formVisite->createView();
        return $this->render('admin/editVisite.html.twig', [
            'formVisite'=>$formView
        ]);
    }


    /**
     * @param Request $request
     * @param SluggerInterface $slugger
     * @param EntityManagerInterface $em
     * @return Response
     * @Route("/createPays", name="createPays")
     */
    public function createPays(Request $request, SluggerInterface $slugger, EntityManagerInterface $em):Response
    {
        $pays = new Pays();
        $formPays = $this->createForm(PaysType::class, $pays);
        $formPays->handleRequest($request);
        if ($formPays->isSubmitted() && $formPays->isValid()){
            $imgFile1 = $formPays->get('img1')->getData();
            $imgFile2 = $formPays->get('img2')->getData();
            if ($imgFile1){
                $originalFilename = pathinfo($imgFile1->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$imgFile1->guessExtension();
                try {
                    $imgFile1->move($this->getParameter('pays_directory'), $newFilename);
                } catch (FileException $exception){
                    return $this->redirectToRoute('pays_pays');
                }
                $pays->setImg1($newFilename);
            }

            if ($imgFile2){
                $originalFilename = pathinfo($imgFile2->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$imgFile2->guessExtension();
                try {
                    $imgFile2->move($this->getParameter('pays_directory'), $newFilename);
                } catch (FileException $exception){
                    return $this->redirectToRoute('pays_pays');
                }
                $pays->setImg2($newFilename);
            }
            $em->persist($pays);
            $em->flush();
            $this->addFlash('success', 'Pays ajout?? avec succ??s !!');
            return $this->redirectToRoute('pays_pays');
        }
        $formView = $formPays->createView();
        return $this->render('admin/createPays.html.twig', [
            'formPays'=>$formView,
        ]);
    }

    /**
     * @param Request $request
     * @param Pays $pays
     * @param SluggerInterface $slugger
     * @param EntityManagerInterface $em
     * @return Response
     * @Route("/editPays/{id}", name="editPays")
     */
    public function editPays(Request $request, Pays $pays, SluggerInterface $slugger, EntityManagerInterface $em):Response
    {
        $formPays = $this->createForm(PaysType::class, $pays);
        $formPays->handleRequest($request);
        if ($formPays->isSubmitted() && $formPays->isValid()){
            $imgFile1 = $formPays->get('img1')->getData();
            $imgFile2 = $formPays->get('img2')->getData();
            if ($imgFile1){
                $originalFilename = pathinfo($imgFile1->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$imgFile1->guessExtension();
                try {
                    $imgFile1->move($this->getParameter('pays_directory'), $newFilename);
                } catch (FileException $exception){
                    return $this->redirectToRoute('pays_pays');
                }
                $pays->setImg1($newFilename);
            }

            if ($imgFile2){
                $originalFilename = pathinfo($imgFile2->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$imgFile2->guessExtension();
                try {
                    $imgFile2->move($this->getParameter('pays_directory'), $newFilename);
                } catch (FileException $exception){
                    return $this->redirectToRoute('pays_pays');
                }
                $pays->setImg2($newFilename);
            }
            //$em->persist($pays);
            $em->flush();
            $this->addFlash('success', 'Pays modifi?? avec succ??s !!');
            return $this->redirectToRoute('pays_pays');
        }
        $formView = $formPays->createView();
        return $this->render('admin/editPays.html.twig', [
            'formPays'=>$formView
        ]);
    }

    /**
     * @param Request $request
     * @param SluggerInterface $slugger
     * @param EntityManagerInterface $em
     * @return Response
     * @Route("/createVille", name="createVille")
     */
    public function createVille(Request $request, SluggerInterface $slugger, EntityManagerInterface $em): Response
    {
        $ville = new Ville();
        $formVille = $this->createForm(VilleType::class, $ville);
        $formVille->handleRequest($request);
        if ($formVille->isSubmitted() && $formVille->isValid()){
            $imgFile1 = $formVille->get('img1')->getData();
            $imgFile2 = $formVille->get('img2')->getData();
            if ($imgFile1){
                $originalFilename = pathinfo($imgFile1->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$imgFile1->guessExtension();
                try {
                    $imgFile1->move($this->getParameter('ville_directory'), $newFilename);
                } catch (FileException $exception){
                    return $this->redirectToRoute('ville_villes');
                }
                $ville->setImg1($newFilename);
            }
            if ($imgFile2){
                $originalFilename = pathinfo($imgFile2->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$imgFile2->guessExtension();
                try {
                    $imgFile2->move($this->getParameter('ville_directory'), $newFilename);
                } catch (FileException $exception){
                    return $this->redirectToRoute('ville_villes');
                }
                $ville->setImg2($newFilename);
            }
            $em->persist($ville);
            $em->flush();
            $this->addFlash('success', 'Ville ajout??e avec succ??s !!');
            return $this->redirectToRoute('ville_villes');
        }
        $formView = $formVille->createView();
        return $this->render('admin/createVille.html.twig', [
            'formVille'=>$formView,
        ]);
    }

    /**
     * @param Request $request
     * @param Ville $ville
     * @param SluggerInterface $slugger
     * @param EntityManagerInterface $em
     * @return Response
     * @Route("/editVille/{id}", name="editVille")
     */
    public function editVille(Request $request, Ville $ville, SluggerInterface $slugger, EntityManagerInterface $em): Response
    {
        $formVille = $this->createForm(VilleType::class, $ville);
        $formVille->handleRequest($request);
        if ($formVille->isSubmitted() && $formVille->isValid()){
            $imgFile1 = $formVille->get('img1')->getData();
            $imgFile2 = $formVille->get('img2')->getData();
            if ($imgFile1){
                $originalFilename = pathinfo($imgFile1->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$imgFile1->guessExtension();
                try {
                    $imgFile1->move($this->getParameter('ville_directory'), $newFilename);
                } catch (FileException $exception){
                    return $this->redirectToRoute('ville_villes');
                }
                $ville->setImg1($newFilename);
            }
            if ($imgFile2){
                $originalFilename = pathinfo($imgFile2->getClientOriginalName(), PATHINFO_FILENAME);
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'.'.$imgFile2->guessExtension();
                try {
                    $imgFile2->move($this->getParameter('ville_directory'), $newFilename);
                } catch (FileException $exception){
                    return $this->redirectToRoute('ville_villes');
                }
                $ville->setImg2($newFilename);
            }
            $em->persist($ville);
            $em->flush();
            $this->addFlash('success', 'Ville ajout??e avec succ??s !!');
            return $this->redirectToRoute('ville_villes');
        }
        $formView = $formVille->createView();
        return $this->render('admin/editVille.html.twig', [
            'formVille'=>$formView,
        ]);
    }


}
