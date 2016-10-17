<?php

namespace ROA\ROABundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;


class MetaMetadataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $opciones =  array('required' => false, 
                            'attr'=>array('class'=>'input_form', 'tipo'=>'opcional'),
                            'label_attr'=>array('class'=>'label_form'));
        $opcionesEsquema = $opciones;
        $opcionesEsquema['attr']['tipo'] = 'requerido';

        $builder->add('lenguaje', 'text', $opciones)
                ->add('esquema', 'text', $opcionesEsquema)
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
        return 'MetaMetadata_form';
    }
   public function getDefaultOptions(array $options){

        return array('data_class' => 'ROA\ROABundle\Entity\MetaMetadata');

    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ROA\ROABundle\Entity\MetaMetadata'
        ));
    }
}