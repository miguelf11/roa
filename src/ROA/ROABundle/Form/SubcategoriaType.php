<?php

namespace ROA\ROABundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SubcategoriaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $opciones =  array('required' => false,
                            'attr'=>array('class'=>'input_form'),
                            'label_attr'=>array('class'=>'label_form'));
        $builder
            ->add('nombre', 'text', $opciones)
            //->add('categoria')
        ;
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ROA\ROABundle\Entity\Subcategoria'
        ));
    }

    public function getName()
    {
        return 'roa_roabundle_subcategoriatype';
    }
}
