<?php

namespace ROA\ROABundle\Form;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use ROA\ROABundle\Entity\Usuario;


class UsuarioType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options){

        $opciones =  array('required' => false,
                            'attr'=>array('class'=>'input_form'),
                            'label_attr'=>array('class'=>'label_form'));

        $opciones2 = $opciones;
        $opciones2['label'] = 'Foto de perfil';

        $opciones3 = array(
                            'class'=>'ROA\ROABundle\Entity\Vocablo',
                            'property'=>'descripcion',
                            'query_builder' => function (\Doctrine\ORM\EntityRepository $repository){
                                return $repository->createQueryBuilder('v')->where('v.vocabulario=12');
                            },
                            'empty_value' => 'Seleccione una opción',
                            'required' => false, 
                            'attr'=>array('class'=>'select_form'),
                            'label_attr'=>array('class'=>'label_form')
                        );
        $opciones4 = $opciones3;
        $opciones4['query_builder']=function (\Doctrine\ORM\EntityRepository $repository){
                                        return $repository->createQueryBuilder('v')->where('v.vocabulario=14');
                                    };

        $opciones5 = $opciones;
        $opciones5['choices']= array('Si'=>'Si', 'No'=>'No');
        $opciones5['attr']=array('class'=>'select_form');

        $opcionesTipoUsuario = $opciones3;
        $opcionesTipoUsuario['label'] = 'Tipo de Usuario';
        $opcionesTipoUsuario['empty_value'] = false;
        $opcionesTipoUsuario['query_builder'] = function (\Doctrine\ORM\EntityRepository $repository){
                                        return $repository->createQueryBuilder('v')->where('v.vocabulario=17');
                                    }; 

        /*$opcionesRoles = $opciones3;
        $opcionesRoles['label'] = 'Rol';
        $opcionesRoles['class'] = 'ROA\ROABundle\Entity\Role';
        $opcionesRoles['property'] = 'descripcion';
        $opcionesRoles['empty_value'] = false;
        $opcionesRoles['query_builder'] = function (\Doctrine\ORM\EntityRepository $repository){
                                        return $repository->createQueryBuilder('v')->where('v.id != 1');
                                    };*/
    
        $builder->add('nombre','text', $opciones)
                ->add('apellido','text', $opciones)
                ->add('email','text', $opciones)
                ->add('tipo_usuario','entity', $opcionesTipoUsuario)
                ->add('password','repeated', array(
                                            'required' => false,
                                            'type' => 'password', 
                                            'first_name' => 'Contrasena',
                                            'second_name' => 'Confirme_su_contrasena',
                                            'invalid_message' =>'Contraseñas no coinciden',
                                            'label_attr'=>array('class'=>'label_form'),
                                            'attr'=>array('class'=>'input_form'),
                                            ))
                ->add('file', 'file', $opciones2);
                //->add('roles', 'entity', $opcionesRoles);
                

    }
    public function getName()
    {
        return 'Usuario_form';
    }
   public function getDefaultOptions(array $options){

        return array('data_class' => 'ROA\ROABundle\Entity\Usuario');

    }
}