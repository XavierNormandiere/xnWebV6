<?php

namespace App\Form;

use App\Entity\Visite;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VisiteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label'=>'Titre : ',
                'required'=>true
            ])
            ->add('lieu', TextType::class, [
                'label'=>'Lieu : ',
                'required'=>true
            ])
            ->add('pays', TextType::class, [
                'label'=>'Pays : ',
                'required'=>true
            ])
            ->add('longitude', TextType::class, [
                'label'=>'Longitude : ',
                'required'=>false
            ])
            ->add('latitude', TextType::class, [
                'label'=>'Latitude',
                'required'=>false
            ])
            ->add('information', TextareaType::class, [
                'label'=>'Informations : ',
                'required'=>false
            ])
            ->add('img1', FileType::class, [
                'label'=>'Ajouter une photo',
                'mapped'=>false,
                'required'=>false
            ])
            ->add('img2', FileType::class, [
                'label'=>'Ajouter une photo',
                'mapped'=>false,
                'required'=>false
            ])
            ->add('img3', FileType::class, [
                'label'=>'Ajouter une photo',
                'mapped'=>false,
                'required'=>false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Visite::class,
        ]);
    }
}
