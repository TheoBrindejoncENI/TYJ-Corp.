<?php

namespace App\Form;

use App\Entity\Participant;
use Doctrine\DBAL\Types\BlobType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ParticipantType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, ["attr" => ["class" => "form-control", "placeholder" => "Votre nom"]])
            ->add('prenom', TextType::class, ["attr" => ["class" => "form-control", "placeholder" => "Votre prénom"]])
            ->add('telephone', TelType::class, ["attr" => ["class" => "form-control", "placeholder" => "Votre numéro de téléphone"]])
            ->add('mail', EmailType::class, ["attr" => ["class" => "form-control", "placeholder" => "Votre adresse email"]])
            ->add('motDePasse', PasswordType::class, ["attr" => ["class" => "form-control", "placeholder" => "Votre mot de passe"]])
            ->add('site', null, ["attr" => ["class" => "form-control"]])
            ->add('image', FileType::class, ['data_class' => null,
                                                        "attr" => ["class" => "custom-file", "placeholder" => "Votre avatar"]])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}
