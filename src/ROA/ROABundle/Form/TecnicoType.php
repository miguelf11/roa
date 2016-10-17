<?php

namespace ROA\ROABundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class TecnicoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $opciones =  array('required' => false, 
                            'attr'=>array('class'=>'input_form', 'tipo'=>'opcional'),
                            'label_attr'=>array('class'=>'label_form'));

        $opciones2 = $opciones;
        $opciones2['attr']['class']='textarea_form';

        $opcionesFormato = $opciones;
        $opcionesFormato['attr']['tipo'] = 'requerido';

        $opcionesUbicacion = $opciones;
        $opcionesUbicacion['attr']['tipo'] = 'requerido';

        $opcionesTamano = $opciones;
        $opcionesTamano['attr']['tipo'] = 'recomendado';

        $opcionesRequisitos = $opciones;
        $opcionesRequisitos['attr']['tipo'] = 'recomendado';
        
        $builder->add('formato', 'text', $opcionesFormato)
                ->add('tamano', 'text', $opcionesTamano)
                ->add('ubicacion', 'text', $opcionesUbicacion)
                ->add('comentario', 'textarea', $opciones2)
                //->add('requerimiento')
                ->add('requisitos', 'text', $opcionesRequisitos)
                ->add('duracion', 'text', $opciones)
                ->add('requerimientos', 'collection', array('type' => new RequerimientoType(),
                                                'allow_add' => true,
                                                'allow_delete' => true,
                                                'by_reference' => false,
                                                'attr'=>array('class'=>'input_form', 'tipo' => 'opcional'),
                                                'label_attr'=>array('class'=>'label_form')
                                                ));

    }
    public function getName()
    {
        return 'Tecnico_form';
    }
   public function getDefaultOptions(array $options){

        return array('data_class' => 'ROA\ROABundle\Entity\Tecnico');

    }
}