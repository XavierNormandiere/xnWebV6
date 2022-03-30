<?php

namespace App\Form;

use App\Entity\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\IsTrue;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'label'=>'Nom : ',
                'required'=>false,
            ])
            ->add('email', EmailType::class, [
                'label'=>'Votre adresse e-mail : ',
                'required'=>true
            ])
            ->add('message', TextareaType::class, [
                'label'=>'Message : ',
                'required'=>false
            ])
            ->add('conditions', CheckboxType::class, [
                'mapped'=>true,
                'label'=>'En cochant cette case vous accepêtez les politiques de confidentialité',
                'constraints'=>[
                    new IsTrue([
                        'message'=>'Vous devez valider les conditions'
                    ]),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class,
        ]);
    }
}
