<?php

namespace ROA\ROABundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use ROA\ROABundle\Form\EventListener\AddSubcategoriaFieldSubscriber;
use ROA\ROABundle\Form\EventListener\AddCategoriaFieldSubscriber;


class OAType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        

        $opciones =  array('required' => false, 
                            'attr'=>array('class'=>'input_form'),
                            'label_attr'=>array('class'=>'label_form'));

        $opcionesSubcategoria = array(
                            'class'=>'ROA\ROABundle\Entity\Subcategoria',
                            'property'=>'nombre',
                            'query_builder' => function (\Doctrine\ORM\EntityRepository $repository){
                                return $repository->createQueryBuilder('c');
                            },
                            'empty_value' => 'Seleccione una opción',
                            'required' => false, 
                            'attr'=>array('class'=>'select_form'),
                            'label_attr'=>array('class'=>'label_form'),
                            'label'=>'Categoria'
                        );

        //$opcionesSubcategoria['attr']['tipo'] = 'requerido';

        $opcionesArea = array(
                            'class'=>'ROA\ROABundle\Entity\Area',
                            'property'=>'nombre',
                            'query_builder' => function (\Doctrine\ORM\EntityRepository $repository){
                                return $repository->createQueryBuilder('c');
                            },
                            'empty_value' => 'Seleccione una opción',
                            'required' => false, 
                            'attr'=>array('class'=>'select_form'),
                            'label_attr'=>array('class'=>'label_form'),
                            'label'=>'Area'
                        );

        $opcionesArea['attr']['tipo'] = 'requerido';

        $opcionesTitulo = $opciones;
        $opcionesTitulo['attr']['tipo'] = 'requerido';

        //$opcionesCategoria = $opciones;
        //$opcionesCategoria['attr']['title'] = 'Esta es la ayuda de la categoria';

        $opcionesFile = $opciones;
        $opcionesFile['label'] = "Archivo";
        $opcionesFile['attr']['tipo'] = 'requerido';

        $opcionesFile['data_class'] = 'Symfony\Component\HttpFoundation\File\File';
        $opcionesFile['property_path'] = 'file';
      
        


        $opcionesStatus = array(
                            'class'=>'ROA\ROABundle\Entity\Vocablo',
                            'property'=>'descripcion',
                            'query_builder' => function (\Doctrine\ORM\EntityRepository $repository){
                                return $repository->createQueryBuilder('v')->where('v.vocabulario=15');
                            },
                            //'defautl_value' => 'Seleccione una opción',
                            //'required' => false, 
                            'attr'=>array('class'=>'select_form'),
                            'label_attr'=>array('class'=>'label_form2'),
                            'attr' => array('style' => 'display:block')
                        );

        $opcionesPuntuacion = array(
                                    'required' => false, 
                                    'attr'=>array('class'=>'select_form'),
                                    'label_attr'=>array('class'=>'label_form2'),
                                    'empty_value' => 'Seleccione una opción',
                                    'label' => 'Valoración',
                                    'choices' => array('1' => '1 Estrella', '2' => '2 Estrellas', '3' => '3 Estrellas', '4' => '4 Estrellas', '5' => '5 Estrellas'),
                                    );

        $builder->add('titulo', 'text', $opcionesTitulo)
                ->add('file', 'file', $opcionesFile)
                ->add('subcategoria', 'entity', $opcionesSubcategoria)
                ->add('area','entity',$opcionesArea)
                ->add('status', 'entity', $opcionesStatus)
                ->add('puntuacion', 'choice', $opcionesPuntuacion)
                ->add('general', new GeneralType(), $opciones)
                ->add('ciclovida', new CicloVidaType(), $opciones)
                ->add('metametadata', new MetaMetadataType(), $opciones)
                ->add('tecnico', new TecnicoType(), $opciones)
                ->add('educacional', new EducacionalType(), $opciones)
                ->add('derechos', new DerechosType(), $opciones)
                ->add('relaciones', 'collection', array('type' => new RelacionType(),
                                                'allow_add' => true,
                                                'allow_delete' => true,
                                                'by_reference' => false,
                                                'attr'=>array('class'=>'input_form'),
                                                'label_attr'=>array('class'=>'label_form')
                                                ))
                ->add('anotaciones', 'collection', array('type' => new AnotacionType(),
                                                'allow_add' => true,
                                                'allow_delete' => true,
                                                'by_reference' => false,
                                                'attr'=>array('class'=>'input_form'),
                                                'label_attr'=>array('class'=>'label_form')
                                                ))
                ->add('clasificaciones', 'collection', array('type' => new ClasificacionType(),
                                                'allow_add' => true,
                                                'allow_delete' => true,
                                                'by_reference' => false,
                                                'label' => ' ',
                                                'attr'=>array('class'=>'input_form'),
                                                'label_attr'=>array('class'=>'label_form')
                                                ));
                //->setAttribute('cascade_validation', $options['cascade_validation']);
                //->addValidator(new DelegatingValidator($this->validator));

    }
    public function getName()
    {
        return 'OA_form';
    }
   public function getDefaultOptions(array $options){

        return array('data_class' => 'ROA\ROABundle\Entity\OA', 'cascade_validation' => true);

    }
}