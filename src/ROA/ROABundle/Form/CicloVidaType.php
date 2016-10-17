<?php

namespace ROA\ROABundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;


class CicloVidaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){

        $opciones =  array('required' => false, 
                            'attr'=>array('class'=>'input_form'),
                            'label_attr'=>array('class'=>'label_form'));
        $opciones3 = array(
                            'class'=>'ROA\ROABundle\Entity\Vocablo',
                            'property'=>'descripcion',
                            'query_builder' => function (\Doctrine\ORM\EntityRepository $repository){
                                return $repository->createQueryBuilder('v')->where('v.vocabulario=2');
                            },
                            'empty_value' => 'Seleccione una opción',
                            'required' => false, 
                            'attr'=>array('class'=>'select_form'),
                            'label_attr'=>array('class'=>'label_form')
                        );
     
    
        $builder->add('version','text', $opciones)
                ->add('status','entity', $opciones3)
                ->add('contribuciones', 'collection', array('type' => new ContribucionType(),
                                                'allow_add' => true,
                                                'allow_delete' => true,
                                                'by_reference' => false,
                                                'attr'=>array('class'=>'input_form'),
                                                'label_attr'=>array('class'=>'label_form')
                                                ));

    }
    public function getName()
    {
        return 'CicloVida_form';
    }
   public function getDefaultOptions(array $options){

        return array('data_class' => 'ROA\ROABundle\Entity\CicloVida');

    }
}