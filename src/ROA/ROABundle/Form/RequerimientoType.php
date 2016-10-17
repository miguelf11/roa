<?php

namespace ROA\ROABundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class RequerimientoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $opciones =  array('required' => false, 
                            'attr'=>array('class'=>'input_form'),
                            'label_attr'=>array('class'=>'label_form'));

        $builder->add('tipo', 'text', $opciones)
                ->add('nombre', 'text', $opciones)
                ->add('version_minima', 'text', $opciones)
                ->add('version_maxima', 'text', $opciones);
                
    }
    public function getName()
    {
        return 'Requerimiento_form';
    }
   public function getDefaultOptions(array $options){

        return array('data_class' => 'ROA\ROABundle\Entity\Requerimiento');

    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ROA\ROABundle\Entity\Requerimiento'
        ));
    }
}