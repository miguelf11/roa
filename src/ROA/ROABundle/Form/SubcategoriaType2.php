<?php

namespace ROA\ROABundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class SubcategoriaType2 extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $opcionesNombre =  array('required' => false,
                            'attr'=>array('class'=>'input_form'),
                            'label_attr'=>array('class'=>'label_form'),
                            'label'=>'Nombre Subcategoría');

        $opcionesDescripcion =  array('required' => false,
                            'attr'=>array('class'=>'input_form','rows' => '5','cols'=>'100'),
                            'label_attr'=>array('class'=>'label_form',
                            'label'=>'Descripción'));



        $builder
            ->add('nombre', 'text', $opcionesNombre)
            ->add('descripcion', 'textarea', $opcionesDescripcion);
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
