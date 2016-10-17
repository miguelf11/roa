<?php

namespace ROA\ROABundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class DerechosType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $opciones =  array('required' => false, 
                            'attr'=>array('class'=>'input_form', 'tipo'=>'requerido'),
                            'label_attr'=>array('class'=>'label_form'));
         $opciones3 = array(
                            'class'=>'ROA\ROABundle\Entity\Vocablo',
                            'property'=>'descripcion',
                            'query_builder' => function (\Doctrine\ORM\EntityRepository $repository){
                                return $repository->createQueryBuilder('v')->where('v.vocabulario=9');
                            },
                            'empty_value' => 'Seleccione una opción',
                            'required' => false, 
                            'attr'=>array('class'=>'select_form', 'tipo'=>'requerido'),
                            'label_attr'=>array('class'=>'label_form')
                        );

        $builder->add('costo', 'entity', $opciones3)
                ->add('restricciones', 'text', $opciones)
                ->add('descripcion', 'text', $opciones);
    }
    public function getName()
    {
        return 'Derechos_form';
    }
   public function getDefaultOptions(array $options){

        return array('data_class' => 'ROA\ROABundle\Entity\Derechos');

    }
}