<?php

namespace ROA\ROABundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class ComentarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $opciones =  array('required' => false, 
                            'attr'=>array('class'=>'textarea_form'),
                            'label_attr'=>array('class'=>'label_form'));

        $opciones3 = array(
                            'class'=>'ROA\ROABundle\Entity\Vocablo',
                            'property'=>'descripcion',
                            'query_builder' => function (\Doctrine\ORM\EntityRepository $repository){
                                return $repository->createQueryBuilder('v')->where('v.vocabulario=16');
                            },
                            //'defautl_value' => 'Seleccione una opción',
                            //'required' => false, 
                            'attr'=>array('class'=>'select_form'),
                            'label_attr'=>array('class'=>'label_form'),
                            'attr' => array('style' => 'display:block')
                        );

        $builder->add('descripcion', 'textarea', $opciones)
                ->add('status', 'entity', $opciones3);
                

    }
    public function getName()
    {
        return 'Comentario_form';
    }
   public function getDefaultOptions(array $options){

        return array('data_class' => 'ROA\ROABundle\Entity\Comentario');

    }
}