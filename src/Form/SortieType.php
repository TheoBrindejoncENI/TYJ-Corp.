<?php

namespace App\Form;

use App\Entity\Sortie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', null, ["attr" => ["class" => "form-control", "placeholder" => "Titre de la sortie"]])
            ->add('dateHeureDebut', null, ["attr" => ["class" => "form-control", "placeholder" => "Date et heure du début de la sortie"],'widget' => "single_text"])
            ->add('duree', null, ["attr" => ["class" => "form-control", "placeholder" => "Durée de la sortie"]])
            ->add('dateLimiteInscription', null, ["attr" => ["class" => "form-control", "placeholder" => "Date limite d'inscription"], 'widget' => "single_text"])
            ->add('nbInscriptionsMax', null, ["attr" => ["class" => "form-control", "placeholder" => "Nombre de place"]])
            ->add('infosSortie', null, ["attr" => ["class" => "form-control", "placeholder" => "Description"]])
            ->add('etat', null, ["attr" => ["class" => "form-control", "placeholder" => "Statut"]])
            ->add('lieu', null, ["attr" => ["class" => "form-control", "placeholder" => "Lieu de la sortie"]])
            ->add('site', null, ["attr" => ["class" => "form-control", "placeholder" => "Site de la sortie"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
