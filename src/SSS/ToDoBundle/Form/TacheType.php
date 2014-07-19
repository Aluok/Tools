<?php

namespace SSS\ToDoBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TacheType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',          'textarea')
            ->add('description',    'textarea', array('required' => false))
            ->add('id',             'hidden', array('required' => false))
            ->add('tachePrincipale','entity', array(
                    "required" => false,
                    "class"=>"SSSToDoBundle:Tache",
                    "property" => 'titre',
                    "multiple" => false,
                    "empty_data" => null,
                    ))
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SSS\ToDoBundle\Entity\Tache'
        ));
    }

    public function getName()
    {
        return 'sss_todobundle_tachetype';
    }
}
