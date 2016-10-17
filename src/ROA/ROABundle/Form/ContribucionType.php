<?php

namespace ROA\ROABundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class ContribucionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $opciones =  array('required' => false, 
                            'attr'=>array('class'=>'input_form', 'tipo'=>'opcional'),
                            'label_attr'=>array('class'=>'label_form'));

        $opciones2 =  array('required' => false, 
                            'attr'=>array('class'=>'fecha', 'tipo'=>'opcional'),
                            'label_attr'=>array('class'=>'label_form'),
                            //'input' => 'datetime',
                            'widget' => 'single_text',
                            'format' => 'dd-MM-yyyy');

        $builder->add('rol', 'text', $opciones)
                ->add('fecha', 'date', $opciones2)
                ->add('entidades', 'collection', array('type' => new EntidadType(),
                                                'allow_add' => true,
                                                'allow_delete' => true,
                                                'by_reference' => false,
                                                'prototype_name' => '__name2__',
                                                'label' => ' ',
                                                'required' => 'false'));


    }
    public function getName()
    {
        return 'Contribucion_form';
    }
   public function getDefaultOptions(array $options){

        return array('data_class' => 'ROA\ROABundle\Entity\Contribucion');

    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ROA\ROABundle\Entity\Contribucion'
        ));
    }
}