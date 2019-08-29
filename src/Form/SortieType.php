<?php

namespace App\Form;

use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortieType extends AbstractType
{
    private $em;

    /**
     * The Type requires the EntityManager as argument in the constructor. It is autowired
     * in Symfony 3.
     *
     * @param EntityManagerInterface $em
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder
            ->add('nom', TextType::class, ["attr" => ["class" => "form-control", "placeholder" => "Titre de la sortie"]])
            ->add('dateHeureDebut', DateTimeType::class, ["attr" => ["class" => "form-control", "placeholder" => "Date et heure du début de la sortie"],'widget' => "single_text"])
            ->add('duree', IntegerType::class, ["attr" => ["class" => "form-control", "placeholder" => "Durée de la sortie"]])
            ->add('dateLimiteInscription', DateTimeType::class, ["attr" => ["class" => "form-control", "placeholder" => "Date limite d'inscription"], 'widget' => "single_text"])
            ->add('nbInscriptionsMax', IntegerType::class, ["attr" => ["class" => "form-control", "placeholder" => "Nombre de place"]])
            ->add('infosSortie', TextareaType::class, ["attr" => ["class" => "form-control", "placeholder" => "Description"]])
            ->add('site', EntityType::class, ["class" => "App\Entity\Site", "attr" => ["class" => "form-control", "placeholder" => "Site de la sortie"]])
            ->add('ville', EntityType::class, ["class" => "App\Entity\Ville", "mapped" => false, "placeholder" => "Ville de la sortie", "attr" => ["class" => "form-control selectVille", "data-live-search" => "true"]]);
        $builder->addEventListener(FormEvents::PRE_SET_DATA, array($this, 'onPreSetData'));
        $builder->addEventListener(FormEvents::PRE_SUBMIT, array($this, 'onPreSubmit'));
        $builder->addEventListener(FormEvents::POST_SET_DATA, array($this, 'onEdit'));
    }

    protected function addElements(FormInterface $form, ?Ville $ville) {
        // Neighborhoods empty, unless there is a selected City (Edit View)
        $lieux = array();

        // If there is a city stored in the Person entity, load the neighborhoods of it
        if ($ville) {
            // Fetch Neighborhoods of the City if there's a selected city
            $repoLieux = $this->em->getRepository('App\Entity\Lieu');

            $lieux = $repoLieux->findAllByCity($ville);
        }

        // Add the Neighborhoods field with the properly data
        $form->add('lieu', EntityType::class, array(
            'required' => true,
            'placeholder' => "Lieu de la sortie",
            'class' => 'App\Entity\Lieu',
            'choices' => $lieux,
            "attr" => ["class" => "form-control selectLieu", "data-live-search" => "true"]
        ));
    }

    function onPreSubmit(FormEvent $event) {
        $form = $event->getForm();
        $data = $event->getData();
        $ville = $this->em->getRepository('App\Entity\Ville')->find($data['ville']);

        $this->addElements($form, $ville);
    }

    function onPreSetData(FormEvent $event) {
        $form = $event->getForm();

        $this->addElements($form, null);
    }

    function onEdit(FormEvent $event) {
        $data = $event->getData();
        /* @var $lieu Lieu */
        $lieu = $data->getLieu();
        $form = $event->getForm();
        if ($lieu) {
            $ville = $lieu->getVille();
            $this->addElements($form, $ville);
            $form->get('ville')->setData($ville);
            $form->get('lieu')->setData($lieu);
        } else {
            $this->addElements($form, null);
        }
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
