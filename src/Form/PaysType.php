<?php

namespace App\Form;

use App\Entity\Pays;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PaysType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom_pays', TextType::class, [
                'label'=>'Pays : ',
                'required'=>true,
            ])
            ->add('continent', TextType::class, [
                'label'=>'Continent : ',
                'required'=>true,
            ])
            ->add('monnaie', TextType::class, [
                'label'=>'Monnaie : ',
                'required'=>true,
            ])
            ->add('capitale', TextType::class, [
                'label'=>'Capitale : ',
                'required'=>true,
            ])
            ->add('langue', TextType::class, [
                'label'=>'Langue : ',
                'required'=>true,
            ])
            ->add('img1', FileType::class, [
                'label'=>'photo1 : ',
                'mapped'=>false,
                'required'=>false,
            ])
            ->add('img2', FileType::class, [
                'label'=>'photo2 : ',
                'mapped'=>false,
                'required'=>false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Pays::class,
        ]);
    }
}
