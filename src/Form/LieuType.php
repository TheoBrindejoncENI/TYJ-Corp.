<?php

namespace App\Form;

use App\Entity\Lieu;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LieuType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, ["attr" => ["class" => "form-control", "placeholder" => "Nom du lieu"]])
            ->add('rue', TextType::class, ["attr" => ["class" => "form-control", "placeholder" => "Rue"]])
            ->add('latitude', NumberType::class, ["attr" => ["class" => "form-control", "placeholder" => "Latitude"]])
            ->add('longitude', NumberType::class, ["attr" => ["class" => "form-control", "placeholder" => "Longitude"]])
            ->add('ville', null, ["attr" => ["class" => "form-control selectpicker", "data-live-search" => "true", "placeholder" => "Ville"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Lieu::class,
        ]);
    }
}
