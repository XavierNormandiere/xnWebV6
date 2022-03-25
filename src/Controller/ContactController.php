<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/contact", name="contact_")
 */
class ContactController extends AbstractController
{
     /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return Response
     * @Route("/formulaire", name="formulaire")
     */
    public function createContact(Request $request, EntityManagerInterface $em, MailerInterface $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $em->persist($contact);
            $em->flush();

            $email = (new Email())
                ->from('contact@xnormandiere.com')
                ->to('xavier@xnormandiere.com')
                ->subject('Message de XNWeb')
                ->text('Nouveau contact')
                ->html('<p>Email de : </p>'
                    . $contact->getEmail() . '<p>message : </p>'
                    . $contact->getMessage()
                );
            try {
                $mailer->send($email);
            } catch (TransportExceptionInterface $e){
                return $this->redirectToRoute('main_home');
            }

            $this->addFlash('success', 'Enregistrement réussi');
            return $this->redirectToRoute('main_home');
        }
        $formView = $form->createView();
        return $this->render('contact/formulaire.html.twig', [
            'form'=>$formView
        ]);
    }


}
