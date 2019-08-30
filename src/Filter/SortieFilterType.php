<?php
// SortieFilterType.php
namespace App\Filter;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use App\Entity\Site;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SortieFilterType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options) {
        
        $builder->add('search', TextType::class,[
                    'label' =>'Search',
                    "required" => false,
                    "attr" => [
                    "placeholder" => "Entrez le nom d'une sortie"
                        ]
                    ])
                ->add('dateMin', DateTimeType::class,[
                    "attr" => [
                        "class" => "form-control", "placeholder" => "Date Min"],
                    'widget' => "single_text",'required' => false])
                ->add('dateMax', DateTimeType::class, [
                    "attr" => [
                        "class" => "form-control", "placeholder" => "Date Max"],
                    "widget" => "single_text","required" => false])
                ->add('site', EntityType::class, [
                    "class" => Site::class, "attr" => [
                        "class" => "form-control", "placeholder" => "Site de la sortie"]
                ])
                ->add('myOwnSortie', CheckboxType::class,[
                    'label' => 'mes Sorties organisée',
                    "required" => false,                       
                ])
                ->add('mySortie', CheckboxType::class,[
                    'label' => 'mes Sorties',
                    "required" => false,                         
                ])
                ->add('passee', CheckboxType::class,[
                    'label' => 'Sorties passée',
                    "required" => false,                        
                ])
                ->add('unsign', CheckboxType::class,[
                    'label' => 'Soirée non inscrits',
                    "required" => false,                         
                ])
                ->add('submit', SubmitType::class, [
                    'label' => 'Rechercher'
                ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults(array(
            'translation_domain' => false
            
        ));
    }

}