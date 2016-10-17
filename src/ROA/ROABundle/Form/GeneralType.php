<?php

namespace ROA\ROABundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class GeneralType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){


        $opciones =  array('required' => false, 
                            'attr'=>array('class'=>'input_form', 'tipo'=>'opcional'),
                            'label_attr'=>array('class'=>'label_form'));

        $opcionesClave = $opciones;
        $opcionesClave['attr']['tipo'] = 'requerido';

        $opciones2 = $opciones;
        $opciones2['attr']=array('class'=>'textarea_form');
        $opcionesDescripcion = $opciones2;
        $opcionesDescripcion['attr']['tipo'] = 'requerido';

        $opcionesEstructura = array(
                            'class'=>'ROA\ROABundle\Entity\Vocablo',
                            'property'=>'descripcion',
                            'query_builder' => function (\Doctrine\ORM\EntityRepository $repository){
                                
                               return $repository->createQueryBuilder('v')->select(array())->where('v.vocabulario=1');
                               // ->setParameter(1, 'basic')
                                //->add('orderBy', 's.sort_order ASC');*/
                            },
                            'empty_value' => 'Seleccione una opción',
                            'required' => false, 
                            'attr'=>array('class'=>'select_form', 'tipo'=>'opcional'),
                            'label_attr'=>array('class'=>'label_form')
                        );


        $opcionesLenguaje = array(
                            'required' => false, 
                            'attr'=>array('class'=>'select_form', 'tipo'=>'requerido'),
                            'label_attr'=>array('class'=>'label_form'),
                            'empty_value' => 'Seleccione una opción',
                            'choices' => array('Español'=>'Español', 'Inglés'=>'Inglés', 'Francés'=>'Francés', 'Aleman'=>'Aleman', 'Italiano'=>'Italiano', 'Portugues' =>'Portugues'),
                            );
        $opcionesNivelAgregacion = $opcionesLenguaje;
        $opcionesNivelAgregacion['attr']['tipo'] = "opcional";
        $opcionesNivelAgregacion['choices'] = array('1'=>'1', '2'=>'2', '3'=>'3', '4'=>'4');
    
        $builder->add('lenguaje','choice', $opcionesLenguaje)
                ->add('descripcion','textarea', $opcionesDescripcion)
                ->add('clave','text', $opcionesClave)
                ->add('cobertura','text', $opciones)
                ->add('estructura','entity', $opcionesEstructura)   
                ->add('nivel_agregacion','choice', $opcionesNivelAgregacion)
                ->add('identificadores', 'collection', array('type' => new IdentificadorType(),
                                                'allow_add' => true,
                                                'allow_delete' => true,
                                                'by_reference' => false,
                                                'attr'=>array('class'=>'input_form'),
                                                'label_attr'=>array('class'=>'label_form')
                                                ));

               
    }
    public function getName()
    {
        return 'General_form';
    }
   public function getDefaultOptions(array $options){

        return array('data_class' => 'ROA\ROABundle\Entity\General');

    }
}