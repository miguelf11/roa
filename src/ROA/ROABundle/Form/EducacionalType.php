<?php

namespace ROA\ROABundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class EducacionalType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){

        $opciones =  array('required' => false, 
                            'attr'=>array('class'=>'input_form', 'tipo'=>'opcional'),
                            'label_attr'=>array('class'=>'label_form'));

        $opciones3 = array(
                            'class'=>'ROA\ROABundle\Entity\Vocablo',
                            'property'=>'descripcion',
                            'query_builder' => function (\Doctrine\ORM\EntityRepository $repository){
                                return $repository->createQueryBuilder('v')->where('v.vocabulario=3');
                            },
                            'empty_value' => 'Seleccione una opción',
                            'required' => false, 
                            'attr'=>array('class'=>'select_form', 'tipo'=>'opcional'),
                            'label_attr'=>array('class'=>'label_form')
                        );
        $opcionesTipoRecurso = $opciones3;
        $opcionesTipoRecurso['attr']['tipo'] ='requerido';
        $opcionesTipoRecurso['query_builder']=function (\Doctrine\ORM\EntityRepository $repository){
                                        return $repository->createQueryBuilder('v')->where('v.vocabulario=4');
                                    };
        $opcionesNivelInteraccion=$opciones3;
        $opcionesNivelInteracion['attr']['tipo']='opcional';
        $opcionesNivelInteraccion['query_builder']=function (\Doctrine\ORM\EntityRepository $repository){
                                        return $repository->createQueryBuilder('v')->where('v.vocabulario=5');
                                    };

        $opcionesRol=$opciones3;
        $opcionesRol['attr']['tipo'] = 'recomendado';
        $opcionesRol['query_builder']=function (\Doctrine\ORM\EntityRepository $repository){
                                        return $repository->createQueryBuilder('v')->where('v.vocabulario=6');
                                    };

        $opcionesContexto=$opciones3;
        $opcionesContexto['attr']['tipo'] = 'requerido';
        $opcionesContexto['query_builder']=function (\Doctrine\ORM\EntityRepository $repository){
                                        return $repository->createQueryBuilder('v')->where('v.vocabulario=7');
                                    };

        $opcionesDificultad=$opciones3;
        $opcionesDificultad['attr']['tipo']='opcional';
        $opcionesDificultad['query_builder']=function (\Doctrine\ORM\EntityRepository $repository){
                                        return $repository->createQueryBuilder('v')->where('v.vocabulario=8');
                                    };

        $opcionesLenguaje = array(
                            'required' => false, 
                            'attr'=>array('class'=>'select_form', 'tipo'=>'opcional'),
                            'label_attr'=>array('class'=>'label_form'),
                            'empty_value' => 'Seleccione una opción',
                            'choices' => array('Español'=>'Español', 'Inglés'=>'Inglés', 'Francés'=>'Francés', 'Aleman'=>'Aleman', 'Italiano'=>'Italiano', 'Portugues' =>'Portugues'),
                            );

        $opcionesTiempo = $opciones;
        $opcionesTiempo['attr']['tipo']='recomendado';
    
        $builder->add('tipo_interaccion','entity', $opciones3)
                ->add('tipo_recurso', 'entity', $opcionesTipoRecurso)
                ->add('nivel_interaccion', 'entity', $opcionesNivelInteraccion)
                ->add('semantica', 'text', $opciones)
                ->add('rol', 'entity', $opcionesRol)
                ->add('contexto', 'entity', $opcionesContexto)
                //->add('edad', 'text', $opciones)
                ->add('dificultad', 'entity', $opcionesDificultad)
                //->add('tiempo', 'text', $opcionesTiempo)
                ->add('descripcion', 'text', $opciones)
                ->add('lenguaje', 'choice', $opcionesLenguaje);

    }
    public function getName()
    {
        return 'Educacional_form';
    }
   public function getDefaultOptions(array $options){

        return array('data_class' => 'ROA\ROABundle\Entity\Educacional');

    }
}