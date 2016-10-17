<?php

namespace ROA\ROABundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class RecursoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $opciones =  array('required' => false, 
                            'attr'=>array('class'=>'textarea_form', 'tipo'=>'opcional'),
                            'label_attr'=>array('class'=>'label_form'));

        $builder->add('descripcion', 'textarea', $opciones)
                ->add('identificadores', 'collection', array('type' => new IdentificadorType(),
                                                'allow_add' => true,
                                                'allow_delete' => true,
                                                'by_reference' => false,
                                                'prototype_name' => '__name2__',
                                                'label' => ' ',
                                                'required' => 'false'));

       

    }
    public function getName()
    {
        return 'Recurso_form';
    }
   public function getDefaultOptions(array $options){

        return array('data_class' => 'ROA\ROABundle\Entity\Recurso');

    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ROA\ROABundle\Entity\Recurso',
        ));
    }
}