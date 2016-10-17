<?php

namespace ROA\ROABundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class IdentificadorType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $opciones =  array('required' => false, 
                            'attr'=>array('class'=>'input_form', 'tipo'=>'recomendado'),
                            'label_attr'=>array('class'=>'label_form'));
        $opcionesCatalogo = $opciones;
        $opcionesCatalogo['label']= "Catálogo";
        $builder->add('catalogo', 'text', $opcionesCatalogo)
                ->add('entrada', 'text', $opciones);

    }
    public function getName()
    {
        return 'Identificador_form';
    }
   public function getDefaultOptions(array $options){

        return array('data_class' => 'ROA\ROABundle\Entity\Identificador');

    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ROA\ROABundle\Entity\Identificador',
        ));
    }
}