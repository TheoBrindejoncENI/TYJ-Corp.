<?php

namespace App\Form;

use App\Entity\Sortie;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, ["attr" => ["class" => "form-control", "placeholder" => "Titre de la sortie"]])
            ->add('dateHeureDebut', DateTimeType::class, ["attr" => ["class" => "form-control", "placeholder" => "Date et heure du début de la sortie"],'widget' => "single_text"])
            ->add('duree', IntegerType::class, ["attr" => ["class" => "form-control", "placeholder" => "Durée de la sortie"]])
            ->add('dateLimiteInscription', DateTimeType::class, ["attr" => ["class" => "form-control", "placeholder" => "Date limite d'inscription"], 'widget' => "single_text"])
            ->add('nbInscriptionsMax', IntegerType::class, ["attr" => ["class" => "form-control", "placeholder" => "Nombre de place"]])
            ->add('infosSortie', TextareaType::class, ["attr" => ["class" => "form-control", "placeholder" => "Description"]])
            ->add('site', null, ["attr" => ["class" => "form-control", "placeholder" => "Site de la sortie"]])
            ->add('lieu', null, ["attr" => ["class" => "form-control", "placeholder" => "Lieu de la sortie"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
