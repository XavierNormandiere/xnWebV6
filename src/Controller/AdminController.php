<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
/**
 * @Route("/admin", name="admin_")
 */
class AdminController extends AbstractController
{
    /**
     * @param ContactRepository $repository
     * @return Response
     * @Route("/", name="admin")
     */
    public function admin(ContactRepository $repository): Response
    {
        $contacts = $repository->findAll();
        return $this->render('admin/admin.html.twig', [
            'contacts' => $contacts,
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
            $this->addFlash('success', 'Modification enregistrée avec succès !!');
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
            $this->addFlash('success', 'Contact supprimé avec succès !!');
            return $this->redirectToRoute('admin_admin');
        }
        $formView = $form->createView();
        return $this->render('admin/deleteContact.html.twig', [
            'form'=>$formView
        ]);
    }

}
