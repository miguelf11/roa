<?php

namespace ROA\ROABundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class AnotacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $opciones =  array('required' => false, 
                            'attr'=>array('class'=>'input_form', 'tipo'=>'opcional'),
                            'label_attr'=>array('class'=>'label_form'));

        $opciones2 = $opciones;
        $opciones2['attr']=array('class'=>'textarea_form');

        $opciones3 = $opciones;
        $opciones3['attr']=array('class'=>'fecha');
        $opciones3['widget'] = 'single_text';
        $opciones3['format'] = 'dd-MM-yyyy';

        $builder->add('fecha', 'date', $opciones3)
                ->add('descripcion', 'textarea', $opciones2)
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
        return 'Anotacion_form';
    }
   public function getDefaultOptions(array $options){

        return array('data_class' => 'ROA\ROABundle\Entity\Anotacion');

    }
}