<?php

namespace App\Form;

use App\Entity\Participant;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', null, ["attr" => ["class" => "form-control", "placeholder" => "Votre nom"]])
            ->add('prenom', null, ["attr" => ["class" => "form-control", "placeholder" => "Votre prénom"]])
            ->add('telephone', null, ["attr" => ["class" => "form-control", "placeholder" => "Votre numéro de téléphone"]])
            ->add('mail', null, ["attr" => ["class" => "form-control", "placeholder" => "Votre adresse email"]])
            ->add('motDePasse', null, ["attr" => ["class" => "form-control", "placeholder" => "Votre mot de passe"]])
            ->add('site', null, ["attr" => ["class" => "form-control"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
