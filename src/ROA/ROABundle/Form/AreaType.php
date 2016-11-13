<?php
namespace ROA\ROABundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
class AreaType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $opcionesNombre =  array('required' => false,
                            'attr'=>array('class'=>'input_form'),
                            'label_attr'=>array('class'=>'label_form',
                            'label'=>'Nombre Area'));

        $opcionesImagen = $opcionesNombre;
        $opcionesImagen['label'] = 'Imagen';



        $builder
            ->add('nombre', 'text', $opcionesNombre)
            ->add('file','file',$opcionesImagen);
    }
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'ROA\ROABundle\Entity\Area'
        ));
    }
    public function getName()
    {
        return 'roa_roabundle_areatype';
    }
}