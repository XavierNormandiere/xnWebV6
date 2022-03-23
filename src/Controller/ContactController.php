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
 * @Route("/contact", name="contact_")
 */
class ContactController extends AbstractController
{
    /**
     * @param ContactRepository $repository
     * @return Response
     * @Route("/", name="contacts")
     */
    public function contacts(ContactRepository $repository): Response
    {
        $contacts = $repository->findAll();
        return $this->render('contact/contacts.html.twig', [
            'contacts' => $contacts,
        ]);
    }

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     * @Route("/formulaire", name="formulaire")
     */
    public function createContact(Request $request, EntityManagerInterface $em): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($contact);
            $em->flush();
            $this->addFlash('success', 'Enregistrement réussi');
            return $this->redirectToRoute('main_home');
        }
        $formView = $form->createView();
        return $this->render('contact/formulaire.html.twig', [
            'form'=>$formView
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
            return $this->redirectToRoute('contact_contacts');
        }
        $formView = $form->createView();
        return $this->render('contact/editContact.html.twig', [
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
            return $this->redirectToRoute('contact_contacts');
        }
        $formView = $form->createView();
        return $this->render('contact/deleteContact.html.twig', [
           'form'=>$formView
        ]);
    }

}
