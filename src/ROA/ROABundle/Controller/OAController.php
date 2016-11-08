<?php

namespace ROA\ROABundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\RedirectResponse;

use ROA\ROABundle\Entity\OA;
use ROA\ROABundle\Entity\Anotacion;
use ROA\ROABundle\Entity\Clasificacion;
use ROA\ROABundle\Entity\Relacion;
use ROA\ROABundle\Entity\MetaMetadata;
use ROA\ROABundle\Entity\Contribucion;
use ROA\ROABundle\Form\OAType;
use ROA\ROABundle\Form\GeneralType;
use ROA\ROABundle\Form\CicloVidaType;
use ROA\ROABundle\Form\MetaMetadataType;
use ROA\ROABundle\Form\TecnicoType;
use ROA\ROABundle\Form\EducacionalType;
use ROA\ROABundle\Form\DerechosType;
use ROA\ROABundle\Form\RelacionType;
use ROA\ROABundle\Form\AnotacionType;
use ROA\ROABundle\Form\ClasificacionType;
use ROA\ROABundle\Form\ContribucionType;
use ROA\ROABundle\Entity\Vocablo;

use ROA\ROABundle\Entity\Categoria;
use ROA\ROABundle\Entity\Usuario;

use ROA\ROABundle\Entity\Ip;

use ROA\ROABundle\Entity\PclZip;


class OAController extends Controller
{


    public function edit_adminAction($id)
    {
        
        $mensaje = $this->getRequest()->getSession()->getFlash('mensaje');

        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ROABundle:OA')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OA entity.');
        }

        $editForm = $this->createForm(new OAType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('ROABundle:OA:edit-admin.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'usuario' => $usuario,
            'mensaje' => $mensaje,
        ));
    }


    public function editAction($id_usuario, $id)
    {
        
        
        if( !($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) ){
            return $this->redirect($this->generateUrl('inicio', array()));
        }

        $mensaje = $this->getRequest()->getSession()->getFlash('mensaje');

        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ROABundle:OA')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OA entity.');
        }

        $editForm = $this->createForm(new OAType(), $entity);
        $deleteForm = $this->createDeleteForm($id);



        return $this->render('ROABundle:OA:edit.html.twig', array(
            'entity'      => $entity,
            'OA_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'usuario' => $usuario,
            'categorias' => $this->getDoctrine()->getManager()->getRepository('ROABundle:Categoria')->findAll(),
            'mensaje' => $mensaje,
        ));
    }


    public function updateAction(Request $request, $id_usuario, $id)
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ROABundle:OA')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OA entity.');
        }


        /*Clasificaciones orginales*/
        $originalClasificaciones = array();
        foreach ($entity->getClasificaciones() as $clasificacion) {
            $originalClasificaciones[] = $clasificacion;
        }

        /*Identificadores orginales*/
        $originalIdentificadores = array();
        foreach ($entity->getGeneral()->getIdentificadores() as $identificador) {
            $originalIdentificadores[] = $identificador;
        }

        /*Relaciones orginales*/
        $originalRelaciones = array();
        foreach ($entity->getRelaciones() as $relacion) {
            $originalRelaciones[] = $relacion;
        }


        /*Contribuciones ciclovida originales*/
        $originalContribuciones2 = array();
        foreach ($entity->getCiclovida()->getContribuciones() as $contribucion) {
            $originalContribuciones2[] = $contribucion;
        }

        /*Contribuciones metametadata originales*/
        $originalContribuciones = array();
        foreach ($entity->getMetametadata()->getContribuciones() as $contribucion) {
            $originalContribuciones[] = $contribucion;
        }

        /*Requerimientos tecnico originales*/
        $originalRequerimientos = array();
        foreach ($entity->getTecnico()->getRequerimientos() as $requerimiento) {
            $originalRequerimientos[] = $requerimiento;
        }

        /*Anotaciones orginales*/
        $originalAnotaciones = array();
        foreach ($entity->getAnotaciones() as $anotacion) {
            $originalAnotaciones[] = $anotacion;
        }


        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new OAType(), $entity, array('validation_groups' => array('update')));
        $editForm->bind($request);

        if ($editForm->isValid()) {

            /*Eliminar clasificaciones*/
            foreach ($entity->getClasificaciones() as $clasificacion) {
                foreach ($originalClasificaciones as $key => $toDel) {
                    if ($toDel->getId() === $clasificacion->getId()) {
                        unset($originalClasificaciones[$key]);
                    }
                }
            }
            foreach ($originalClasificaciones as $clasificacion) {
                $em->remove($clasificacion);
            }

            /*Eliminar identificadores*/
            foreach ($entity->getGeneral()->getIdentificadores() as $identificador) {
                foreach ($originalIdentificadores as $key => $toDel) {
                    if ($toDel->getId() === $identificador->getId()) {
                        unset($originalIdentificadores[$key]);
                    }
                }
            }
            foreach ($originalIdentificadores as $identificador) {
                $em->remove($identificador);
            }

            /*Eliminar relaciones*/
            foreach ($entity->getRelaciones() as $relacion) {
                foreach ($originalRelaciones as $key => $toDel) {
                    if ($toDel->getId() === $relacion->getId()) {
                        unset($originalRelaciones[$key]);
                    }
                }
            }
            foreach ($originalRelaciones as $relacion) {
                $em->remove($relacion);
            }

            /*Eliminar contribuciones ciclovida*/
            foreach ($entity->getCiclovida()->getContribuciones() as $contribucion) {
                foreach ($originalContribuciones2 as $key => $toDel) {
                    if ($toDel->getId() === $contribucion->getId()) {
                        unset($originalContribuciones2[$key]);
                    }
                }
            }
            foreach ($originalContribuciones2 as $contribucion) {
                $em->remove($contribucion);
            }

            /*Eliminar contribuciones metametadata*/
            foreach ($entity->getMetametadata()->getContribuciones() as $contribucion) {
                foreach ($originalContribuciones as $key => $toDel) {
                    if ($toDel->getId() === $contribucion->getId()) {
                        unset($originalContribuciones[$key]);
                    }
                }
            }
            foreach ($originalContribuciones as $contribucion) {
                $em->remove($contribucion);
            }

            /*Eliminar requerimientos tecnico*/
            foreach ($entity->getTecnico()->getRequerimientos() as $requerimiento) {
                foreach ($originalRequerimientos as $key => $toDel) {
                    if ($toDel->getId() === $requerimiento->getId()) {
                        unset($originalRequerimientos[$key]);
                    }
                }
            }
            foreach ($originalRequerimientos as $requerimiento) {
                $em->remove($requerimiento);
            }

            /*Eliminar anotaciones*/
            foreach ($entity->getAnotaciones() as $anotacion) {
                foreach ($originalAnotaciones as $key => $toDel) {
                    if ($toDel->getId() === $anotacion->getId()) {
                        unset($originalAnotaciones[$key]);
                    }
                }
            }
            foreach ($originalAnotaciones as $anotacion) {
                $em->remove($anotacion);
            }

            $em = $this->getDoctrine()->getManager();
            $status = $em->getRepository('ROABundle:Vocablo')->find('86');
            $entity->setStatus($status);
            $em->persist($entity);
            $em->flush();


            //Envio de email
            $email = \Swift_Message::newInstance()
                    ->setSubject('ROACAR')
                    ->setFrom('juansneak@gmail.com')
                    ->setTo($usuario->getEmail())
                    ->setBody(
                            $this->renderView(
                                'ROABundle:Email:email_edicion_OA.html.twig',
                                array('objeto'=>$entity, 'usuario' => $usuario)), 'text/html');
            $this->get('mailer')->send($email);

            $this->getRequest()->getSession()->setFlash('mensaje', '¡Objeto editado exitosamente!');

            return $this->redirect($this->generateUrl('OA_edit', array('id' => $id, 'id_usuario'=>$usuario->getId())));
        }else{
            $this->get('session')->getFlashBag()->set('datos_invalidos', 'Algunos datos son inválidos');
        }

        return $this->render('ROABundle:OA:edit.html.twig', array(
            'entity'      => $entity,
            'OA_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'usuario' => $usuario,
            'categorias' => $this->getDoctrine()->getManager()->getRepository('ROABundle:Categoria')->findAll(),
            'mensaje'=>''
            //'role' => $role,
        ));
    }





    public function update_adminAction(Request $request, $id)
    {
        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();

        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('ROABundle:OA')->find($id);


        if (!$entity) {
            throw $this->createNotFoundException('Unable to find OA entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new OAType(), $entity);
        $editForm->bind($request);

        /*Esto se hace para permitir que el campo file esté vacío cuando se esta editando*/
        if (substr_count($editForm->getErrorsAsString(), 'ERROR') == 1){
            $aux = strpos($editForm->getErrorsAsString(), 'file: ERROR');
            if ($aux){
                $formValido = true;
            }else{
                $formValido = true;
            }
        }else{
            $formValido = $editForm->isValid();
        }

        if ($formValido) {


            $fecha_publicacion = new \DateTime("now");
            $ano = $fecha_publicacion->format('Y');
            $entity->setAno($ano);
            $entity->setFecha_publicacion($fecha_publicacion);

            $em->persist($entity);
            $em->flush();

            $autor = $entity->getUsuario();

            //Envio de email
            $email = \Swift_Message::newInstance()
                        ->setSubject('ROACAR')
                        ->setFrom('juansneak@gmail.com')
                        ->setTo($autor->getEmail())
                        ->setBody(
                                $this->renderView(
                                    'ROABundle:Email:email_edicion_status_OA.html.twig',
                                    array('objeto'=>$entity, 'autor' => $autor)), 'text/html');
            $this->get('mailer')->send($email);

            $this->getRequest()->getSession()->setFlash('mensaje', '¡Objeto editado exitosamente!');

            return $this->redirect($this->generateUrl('OA_edit_admin', array('id' => $id)));
        }

        return $this->render('ROABundle:OA:edit-admin.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
            'usuario' => $usuario,
            'mensaje'=>'',
            //'role' => $role,
        ));
    }



	public function deleteAction($id){
		
		$error = $this->getRequest()->getSession()->getFlash('error');
        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();

        $em = $this->getDoctrine()->getEntityManager();
        $objeto = $em->getRepository('ROABundle:OA')->find($id);
        $em->remove($objeto);
        $em->flush();

        $Oas = $usuario->getOasArray();
        if(count($Oas) == 0) {
            $role_no_contribuyente = $em->getRepository('ROABundle:Role')->findOneByDescripcion('No Contribuyente');
            $usuario->changeToNoContribuyente($role_no_contribuyente);
        }

        $em->persist($usuario);
        $em->flush();

        $variables = array('error'=> $error,'usuario'=> $usuario);

        $this->getRequest()->getSession()->setFlash('mensaje', '¡Objeto eliminado exitosamente!');

        return $this->redirect($this->generateUrl('OA_index', array('filtro' => 'usuario', 'id'=>$usuario->getId())));
	}


    public function delete_adminAction($id){
        
        $error = $this->getRequest()->getSession()->getFlash('error');
        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();

        $em = $this->getDoctrine()->getEntityManager();
        $objeto = $em->getRepository('ROABundle:OA')->find($id);
        $em->remove($objeto);
        $em->flush();

        $autor = $objeto->getUsuario();

        //DESPUES DE ELIMINAR SE LE DEBERIA ENVIAR UN CORREO AL USUARIO
        //Envio de email
        $mensaje = \Swift_Message::newInstance()
                    ->setSubject('ROACAR')
                    ->setFrom('juansneak@gmail.com')
                    ->setTo($autor->getEmail())
                    ->setBody(
                            $this->renderView(
                                'ROABundle:Email:email_eliminacion_OA.html.twig',
                                array('objeto'=>$objeto, 'autor' => $autor)), 'text/html');
        $this->get('mailer')->send($mensaje);

        $variables = array('error'=> $error,'usuario'=> $usuario);

        $this->getRequest()->getSession()->setFlash('mensaje', '¡Objeto eliminado exitosamente!');

        return $this->redirect($this->generateUrl('OA_index_admin'));
    }

	public function indexAction($filtro , $id){

        if(($filtro != 'subcategoria') && !($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) ){
            return $this->redirect($this->generateUrl('inicio', array()));
        }

        $mensaje = $this->getRequest()->getSession()->getFlash('mensaje');
        $politicas = $this->getRequest()->getSession()->getFlash('politicas');

        $error = $this->getRequest()->getSession()->getFlash('error');
        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();
        
        $em = $this->getDoctrine()->getEntityManager();


        switch($filtro){

            case 'usuario':
                
                $objetos = $em->getRepository('ROABundle:OA')->findByUsuario($usuario, array('fecha_publicacion'=>'DESC'));
                            
                switch($format){

                    case 'json':
                        foreach ($objetos as $key => $oa) {
                            $arreglo[] = $this->get('objeto_2_arreglo')->OA_to_arreglo($oa);
                        }
                        return new JsonResponse($arreglo); break;

                    default:
                        $variables = array('error'=> $error,'usuario'=> $usuario, 'objetos'=>$objetos, 'categorias' => $this->getDoctrine()->getManager()->getRepository('ROABundle:Categoria')->findAll(), 'filtro' => $filtro, 'mensaje' =>$mensaje, 'politicas'=>$politicas);
                        $content = $this->renderView('ROABundle:OA:index-usuario.html.twig', $variables);
                        break;
                }
                break;

            case 'subcategoria':

                $subcategoria = $em->getRepository('ROABundle:Subcategoria')->find($id);
                $objetos = $em->getRepository('ROABundle:OA')->findBySubcategoriaAndStatus($id, 'Certificado');

                switch($format){

                    case 'json':
                    
                        foreach ($objetos as $key => $oa) {
                            $arreglo[] = $this->get('objeto_2_arreglo')->OA_to_arreglo($oa);
                        }
                        return new JsonResponse($arreglo); break;

                    default:
                    $variables = array('error'=> $error,'usuario'=> $usuario, 'objetos'=>$objetos, 'categorias' => $this->getDoctrine()->getManager()->getRepository('ROABundle:Categoria')->findAll(), 'filtro' => $filtro, 'subcategoria'=>$subcategoria);
                    $content = $this->renderView('ROABundle:OA:index.html.twig', $variables);
                    break; 
                }
                break;

        }
        return new Response($content);
           
	}


    public function index_adminAction(){

        $mensaje = $this->getRequest()->getSession()->getFlash('mensaje');

        $error = $this->getRequest()->getSession()->getFlash('error');
        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();
        
        $em = $this->getDoctrine()->getEntityManager();

        switch($format){

            case 'json':
                //$content = $this->get('serializador')->serializar($personas, 'json');
                break;

            case 'xml':
                break;

            default: 

                $id = $usuario->getId();
                //$status = $em->getRepository('ROABundle:Vocablo')->findByDescripcion('Sin revisar');
                // $objetos = $em->getRepository('ROABundle:OA')->findByUsuarioAndStatus($id, 'Sin revisar');
                //$objetos = $em->getRepository('ROABundle:OA')->findNoAutorizados();
                $objetos_certificados = $em->getRepository('ROABundle:OA')->findByStatusCustom('Certificado');
                $objetos_no_autorizados = $em->getRepository('ROABundle:OA')->findByStatusCustom('No Autorizado');
                $objetos_en_revision = $em->getRepository('ROABundle:OA')->findBystatusCustom('En Revision');
                $variables = array('error'=> $error,'usuario'=> $usuario, 'objetos_certificados'=>$objetos_certificados, 'objetos_no_autorizados'=>$objetos_no_autorizados, 'objetos_en_revision'=>$objetos_en_revision,'mensaje'=>$mensaje);
                $content = $this->renderView('ROABundle:OA:index-admin.html.twig', $variables);              
        }
        return new Response($content);
           
    }


    public function createAction(Request $request, $filtro, $id)
    {

        $error = $this->getRequest()->getSession()->getFlash('error');
        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();

        $OA  = new OA();
        $OA_form= $this->createForm(new OAType(), $OA, array('validation_groups'=>array('create')));
        $OA_form->bind($request);

        //echo $OA_form->getErrorsAsString(); exit();

        if( $OA_form->isValid()){

            //Persistencia y almacenamiento en Base de Datos

            $em = $this->getDoctrine()->getEntityManager();

            if ($usuario->esContribuyente()== false){
                $role_contribuyente = $em->getRepository('ROABundle:Role')->findOneByDescripcion('Contribuyente'); 
                $usuario->changeToContribuyente($role_contribuyente);
            }

            $OA->setUsuario($usuario);
            //$OA->setNum_descargas(0);
            $em->persist($OA);
            $em->flush();

            $variables = array('error'=> $error,'usuario'=> $usuario, 'categorias' => $this->getDoctrine()->getManager()->getRepository('ROABundle:Categoria')->findAll());
        
            //return $this->render('ROABundle:OA:create.html.twig', $variables);


            //Envio de email
            $email = \Swift_Message::newInstance()
                    ->setSubject('ROACAR')
                    ->setFrom('juansneak@gmail.com')
                    ->setTo($usuario->getEmail())
                    ->setBody(
                            $this->renderView(
                                'ROABundle:Email:email_insercion_OA.html.twig',
                                array('objeto'=>$OA)), 'text/html');
            $this->get('mailer')->send($email);


            $this->getRequest()->getSession()->setFlash('mensaje', '¡Objeto almacenado exitosamente!');
            $this->getRequest()->getSession()->setFlash('politicas', true);
            return $this->redirect($this->generateUrl('OA_index', array('filtro' => 'usuario', 'id'=>$usuario->getId())));


        }else{
            $this->get('session')->getFlashBag()->set('datos_invalidos', 'Algunos datos son inválidos');
        }

        $variables = array(
                    'error'=> $error,
                    'usuario'=> $usuario,
                    'OA_form' => $OA_form->createView(),
                    'categorias' => $this->getDoctrine()->getManager()->getRepository('ROABundle:Categoria')->findAll(),
                    'mensaje' => '');

        return $this->render('ROABundle:OA:new.html.twig', $variables);   
    }
    

	public function newAction($filtro, $id){

        if( !($this->get('security.context')->isGranted('IS_AUTHENTICATED_FULLY')) ){
            return $this->redirect($this->generateUrl('inicio', array()));
        }

        $error = $this->getRequest()->getSession()->getFlash('error');
        $usuario = $this->get('security.context')->getToken()->getUser();
        $format = $this->getRequest()->getRequestFormat();
    
        switch($format){
       
            case 'json':
                break;

            case 'xml':
                break;

           default: 

                $OA = New OA();

                //Creación de los formularios
                $OA_form= $this->createForm(new OAType(), $OA);

                //Variables que son pasadas a la vista
                $variables = array(
                    'error'=> $error,
                    'usuario'=> $usuario,
                    'OA_form' => $OA_form->createView(),
                    'categorias' => $this->getDoctrine()->getManager()->getRepository('ROABundle:Categoria')->findAll());

                $content = $this->renderView('ROABundle:OA:new.html.twig', $variables);
            
            }
        return new Response($content);
	}


    public function buscarAction(){
            
    }

    public function dispatcherAction($id){
     
        $request = $this->getRequest(); 

        //$method = $request->query->get('method');
        $method = $request->request->get('method');

        switch($method){
            case 'delete':
            $response = $this->forward('ROABundle:OA:delete', array('id' => $id));
            break;

            case 'put':
            $response = $this->forward('ROABundle:OA:update', array('id' => $id));
            break;

            default:
            $response = $this->forward('ROABundle:OA:read', array('id' => $id));
        }
        return $response;
    }

    public function descargaAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $OA = $em->getRepository('ROABundle:OA')->find($id);
        $path = $OA->getWebPath();
        $filename = $OA->getPath();
        //$path = $em->getRepository('ROABundle:OA')->find($id)->getWebPath();
        //$filename = $em->getRepository('ROABundle:OA')->find($id)->getPath();

        $content = file_get_contents($path);

        $response = new Response();

        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment;filename="'.$filename);

        $response->setContent($content);

       // $ip = $this->get('request')->server->get("REMOTE_ADDR");
        $direccion_ip = $this->get('request')->getClientIp();

        $ip = $em->getRepository('ROABundle:Ip')->findOneByDireccion($direccion_ip);

        if (!($ip)){
            
            $ip = New Ip();
            $ip->setDireccion($direccion_ip);
            $em->persist($ip);
            $em->flush();

            $OA->addIp($ip);
            $OA->IncrementarNum_descargas();
            $em->persist($OA);
            $em->flush();

        }else{

            if (!($OA->existeIp($ip))){
                $OA->addIp($ip);
                $OA->IncrementarNum_descargas();
            }
            $em->persist($OA);
            $em->flush();
        }
        return $response;

    }
    public function visualizacionAction($id){

        $em = $this->getDoctrine()->getEntityManager();
        $webpath = $em->getRepository('ROABundle:OA')->find($id)->getWebPath();
        $path = $em->getRepository('ROABundle:OA')->find($id)->getPath();

        $original_name = $em->getRepository('ROABundle:OA')->find($id)->getOriginal_name();
        $original_name = explode('.', $original_name);

        $name = $original_name[0];
        $extension = $original_name[1];

        if($extension == 'zip'){
            $this->get('zip_manager')->unZip($webpath, $id);

            
            //$index = $this->get('dir_reader')->read('uploads/objetos', 'index');/*NO SE QUE PASO!*/
            $index = 'index.html';
            return new RedirectResponse('/roa/web/downloads/'.$id.'/'.$original_name[0].'/'.$index); 
        }else{
            switch ($this->get('extension_checker')->check($extension)) {
                case 'audio':
                    if (!(file_exists('downloads/'.$id.'/audio.html'))) {

                        mkdir('downloads/'.$id, 0777);
                        $fileManager = fopen('downloads/'.$id.'/audio.html', "w");
                        $data = $this->get('html_generator')->html_audio('../../'.$webpath);
                        fwrite($fileManager, $data); 
                    }
                         
                    return new RedirectResponse('/roa/web/downloads/'.$id.'/audio.html');
                    break;

                case 'video':
                    if (!(file_exists('downloads/'.$id.'/video.html'))) {

                        mkdir('downloads/'.$id, 0777);
                        $fileManager = fopen('downloads/'.$id.'/video.html', "w");
                        $data = $this->get('html_generator')->html_video('../../'.$webpath);
                        fwrite($fileManager, $data); 
                    }
                         
                    return new RedirectResponse('/roa/web/downloads/'.$id.'/video.html');
                    break;
                
                default:
                    return new RedirectResponse('/roa/web/'.$webpath);
                    break;       
            }
        }
    }


    public function metadatosAction($id){
        $em = $this->getDoctrine()->getEntityManager();
        $objeto = $em->getRepository('ROABundle:OA')->find($id);
        $comentarios = $em->getRepository('ROABundle:Comentario')->findComentariosPublicados($id);
        return $this->render('ROABundle:OA:metadatos.html.twig', array('objeto'=>$objeto, 'comentarios'=>$comentarios));
    }


    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

}
