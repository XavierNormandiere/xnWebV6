<?php

namespace App\Form;

use App\Entity\Ville;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VilleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_ville', TextType::class, [
                'label'=>'Nom : ',
                'required'=>true,
            ])
            ->add('nom_pays', TextType::class, [
                'label'=>'Pays : ',
                'required'=>true,
            ])
            ->add('province', TextType::class, [
                'label'=>'Province : ',
                'required'=>false,
            ])
            ->add('capitale', CheckboxType::class, [
                'label'=>'Capitale : ',
                'required'=>true,
            ])
            ->add('info', TextareaType::class, [
                'label'=>'Informations',
                'required'=>false,
            ])
            ->add('img1', FileType::class, [
                'label'=>'Photo 1 : ',
                'mapped'=>false,
                'required'=>false,
            ])
            ->add('img2', FileType::class, [
                'label'=>'Photo 2 : ',
                'mapped'=>false,
                'required'=>false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ville::class,
        ]);
    }
}
