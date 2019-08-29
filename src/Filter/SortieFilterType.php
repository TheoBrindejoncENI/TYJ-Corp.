<?php
// SortieFilterType.php
namespace App\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Lexik\Bundle\FormFilterBundle\Filter\Form\Type as Filters;

class SortieFilterType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder->add('nom', TextType::class,[
                    "required" => false,
                    "label" => false,
                    "attr" => [
                    "placeholder" => "Entrez le nom d'une sortie"
                        ]
                    ])
                ->add('dateMin', DateType::class,[
                    'widget' => 'single_text',

                    // prevents rendering it as type="date", to avoid HTML5 date pickers
                    'html5' => false,

                    // adds a class that can be selected in JavaScript
                    'attr' => ['class' => 'js-datepicker'],
                ])
                ->add('dateMax', DateType::class, [
                    'widget' => 'single_text',

                    // prevents rendering it as type="date", to avoid HTML5 date pickers
                    'html5' => false,

                    // adds a class that can be selected in JavaScript
                    'attr' => ['class' => 'js-datepicker'],
                ])
                ->add('site', EntityType::class, [
                        'class' => 'App:Site',
                        'choice_label' => 'nom',
                        'required' => false
                ])
                ->add('myOwnSortie', CheckboxType::class,[
                    'label' => 'mes Sorties organisée'                         
                ])
                ->add('mySortie', CheckboxType::class,[
                    'label' => 'mes Sorties'                         
                ])
                ->add('past', CheckboxType::class,[
                    'label' => 'Sorties passée'                         
                ])
                ->add('unsign', CheckboxType::class,[
                    'label' => 'Soirée non inscrits'                         
                ])
                ->add('submit', SubmitType::class, [
                    'label' => 'Rechercher'
                ])
    ;
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'translation_domain' => false
        ));
    }

}