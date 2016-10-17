<?php

namespace ROA\ROABundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class RelacionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $opciones =  array('required' => false, 'label_attr' => array('style'=>'display:none'), 'attr'=> array('tipo'=>'recomendado'));

        $opcionesTipo = array(
                            'class'=>'ROA\ROABundle\Entity\Vocablo',
                            'property'=>'descripcion',
                            'query_builder' => function (\Doctrine\ORM\EntityRepository $repository){
                                return $repository->createQueryBuilder('v')->where('v.vocabulario=10');
                            },
                            'empty_value' => 'Seleccione una opción',
                            'required' => false, 
                            'attr'=>array('class'=>'select_form', 'tipo'=>'recomendado'),
                            'label_attr'=>array('class'=>'label_form'),
                        );

        $builder->add('tipo', 'entity', $opcionesTipo)
                ->add('recurso', new RecursoType(), $opciones);
                //->add('oa')
                //->add('oa_objetivo');

    }
    public function getName()
    {
        return 'Relacion_form';
    }
   public function getDefaultOptions(array $options){

        return array('data_class' => 'ROA\ROABundle\Entity\Relacion');

    }
}