<?php

namespace ROA\ROABundle\Servicios;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;

class Objeto2Arreglo
{
	private $arreglo;

	public function __construct(){
		
		$arreglo = array();
	}

	public function OA_to_arreglo(\ROA\ROABundle\Entity\OA $oa){

		$arreglo['id'] = $oa->getId();
		$arreglo['titulo'] = $oa->getTitulo();
		$arreglo['subcategoria'] = $oa->getSubcategoria()->getNombre();
		$arreglo['area'] = $oa->getArea()->getNombre();
		$arreglo['fecha_publicacion'] = $oa->getFecha_publicacion();
		//General
		$arreglo['general']['lenguaje'] = $oa->getGeneral()->getLenguaje();
		$arreglo['general']['descripcion'] = $oa->getGeneral()->getDescripcion();
		$arreglo['general']['clave'] = $oa->getGeneral()->getClave();
		$arreglo['general']['cobertura'] = $oa->getGeneral()->getCobertura();


		if ($oa->getGeneral()->getEstructura() == false){
			$arreglo['general']['estructura']= 'null';	
		}else{
			$arreglo['general']['estructura'] = $oa->getGeneral()->getEstructura()->getDescripcion();
		}
		
		$arreglo['general']['nivel_agregacion'] = $oa->getGeneral()->getNivelAgregacion();

		foreach ($oa->getGeneral()->getIdentificadores() as $key => $identificador) {
			$arreglo['general']['identificadores'][$key]['catalogo'] = $identificador->getCatalogo();
			$arreglo['general']['identificadores'][$key]['entrada'] = $identificador->getEntrada();
		}

		//Ciclo Vida
		$arreglo['ciclovida']['version'] = $oa->getCicloVida()->getVersion();

		if ($oa->getCicloVida()->getStatus() == false){
			$arreglo['ciclovida']['status']= 'null';	
		}else{
			$arreglo['ciclovida']['status'] = $oa->getCicloVida()->getStatus()->getDescripcion();
		}
		
		foreach ($oa->getCicloVida()->getContribuciones() as $key => $contribucion) {
			$arreglo['ciclovida']['contribuciones'][$key]['rol'] = $contribucion->getRol();
			$arreglo['ciclovida']['contribuciones'][$key]['fecha'] = $contribucion->getFecha();
			foreach ($contribucion->getEntidades() as $key2 => $entidad) {
				$arreglo['ciclovida']['contribuciones'][$key]['entidades'][$key2]['nombre'] = $entidad->getNombre();
				$arreglo['ciclovida']['contribuciones'][$key]['entidades'][$key2]['email'] = $entidad->getEmail();
				$arreglo['ciclovida']['contribuciones'][$key]['entidades'][$key2]['organizacion'] = $entidad->getOrganizacion();
			}
		}

		//Metametadata
		$arreglo['metametadata']['lenguaje'] = $oa->getMetametadata()->getLenguaje();
		$arreglo['metametadata']['esquema'] = $oa->getMetametadata()->getEsquema();

		foreach ($oa->getMetametadata()->getContribuciones() as $key => $contribucion) {
			$arreglo['metametadata']['contribuciones'][$key]['rol'] = $contribucion->getRol();
			$arreglo['metametadata']['contribuciones'][$key]['fecha'] = $contribucion->getFecha();

			foreach ($contribucion->getEntidades() as $key2 => $entidad) {
				$arreglo['metametadata']['contribuciones'][$key]['entidades'][$key2]['nombre'] = $entidad->getNombre();
				$arreglo['metametadata']['contribuciones'][$key]['entidades'][$key2]['email'] = $entidad->getEmail();
				$arreglo['metametadata']['contribuciones'][$key]['entidades'][$key2]['organizacion'] = $entidad->getOrganizacion();
			}
		}

		//Tecnico
		$arreglo['tecnico']['formato'] = $oa->getTecnico()->getFormato();
		$arreglo['tecnico']['tamano'] = $oa->getTecnico()->getTamano();
		$arreglo['tecnico']['ubicacion'] = $oa->getTecnico()->getUbicacion();
		$arreglo['tecnico']['comentario'] = $oa->getTecnico()->getComentario();

		foreach ($oa->getTecnico()->getRequerimientos() as $key => $requerimiento) {
			$arreglo['tecnico']['requerimientos'][$key]['tipo'] = $requerimiento->getTipo();
			$arreglo['tecnico']['requerimientos'][$key]['nombre'] = $requerimiento->getNombre();
			$arreglo['tecnico']['requerimientos'][$key]['version_minima'] = $requerimiento->getVersionMinima();
			$arreglo['tecnico']['requerimientos'][$key]['version_maxima'] = $requerimiento->getVersionMaxima();
		}

		//Educacional

		if ($oa->getEducacional()->getTipoInteraccion() == false){
			$arreglo['educacional']['tipo_interaccion'] = 'null';	
		}else{
			$arreglo['educacional']['tipo_interaccion'] = $oa->getEducacional()->getTipoInteraccion()->getDescripcion();
		}

		if ($oa->getEducacional()->getTipoRecurso() == false){
			$arreglo['educacional']['tipo_recurso'] = 'null';	
		}else{
			$arreglo['educacional']['tipo_recurso'] = $oa->getEducacional()->getTipoRecurso()->getDescripcion();
		}

		if ($oa->getEducacional()->getNivelInteraccion() == false){
			$arreglo['educacional']['nivel_interaccion'] = 'null';	
		}else{
			$arreglo['educacional']['nivel_interaccion'] = $oa->getEducacional()->getNivelInteraccion()->getDescripcion();
		}

		$arreglo['educacional']['semantica'] = $oa->getEducacional()->getSemantica();

		if ($oa->getEducacional()->getRol() == false){
			$arreglo['educacional']['rol'] = 'null';	
		}else{
			$arreglo['educacional']['rol'] = $oa->getEducacional()->getRol()->getDescripcion();
		}

		if ($oa->getEducacional()->getContexto() == false){
			$arreglo['educacional']['contexto'] = 'null';	
		}else{
			$arreglo['educacional']['contexto'] = $oa->getEducacional()->getContexto()->getDescripcion();
		}

		$arreglo['educacional']['edad'] = $oa->getEducacional()->getEdad();

		if ($oa->getEducacional()->getDificultad() == false){
			$arreglo['educacional']['dificultad'] = 'null';	
		}else{
			$arreglo['educacional']['dificultad'] = $oa->getEducacional()->getDificultad()->getDescripcion();
		}

		$arreglo['educacional']['tiempo'] = $oa->getEducacional()->getTiempo();
		$arreglo['educacional']['descripcion'] = $oa->getEducacional()->getDescripcion();
		$arreglo['educacional']['lenguaje'] = $oa->getEducacional()->getLenguaje();

		//Derechos
		if ($oa->getDerechos()->getCosto() == false){
			$arreglo['derechos']['costo'] = 'null';	
		}else{
			$arreglo['derechos']['costo'] = $oa->getDerechos()->getCosto()->getDescripcion();
		}

		$arreglo['derechos']['restricciones'] = $oa->getDerechos()->getRestricciones();
		$arreglo['derechos']['descripcion'] = $oa->getDerechos()->getDescripcion();

		//Relaciones

		foreach ($oa->getRelaciones()as $key => $relacion) {
			$arreglo['relaciones'][$key]['tipo']= $relacion->getTipo()->getDescripcion();
			$arreglo['relaciones'][$key]['recurso']['descripcion']= $relacion->getRecurso()->getDescripcion();
			foreach ($relacion->getRecurso()->getIdentificadores() as $key2 => $identificador) {
			$arreglo['relaciones'][$key]['recurso']['identificadores'][$key2]['catalogo'] = $identificador->getCatalogo();
			$arreglo['relaciones'][$key]['recurso']['identificadores'][$key2]['entrada'] = $identificador->getEntrada();
			}
		}

		//Anotaciones

		foreach ($oa->getAnotaciones() as $key => $anotacion) {
			$arreglo['anotaciones'][$key]['fecha'] = $anotacion->getFecha();
			$arreglo['anotaciones'][$key]['descripcion'] = $anotacion->getDescripcion();
			foreach ($anotacion->getEntidades() as $key2 => $entidad) {
				$arreglo['anotaciones'][$key]['entidades'][$key2]['nombre'] = $entidad->getNombre();
				$arreglo['anotaciones'][$key]['entidades'][$key2]['email'] = $entidad->getEmail();
				$arreglo['anotaciones'][$key]['entidades'][$key2]['organizacion'] = $entidad->getOrganizacion();
			}
		}

		//Clasificaciones
		foreach ($oa->getClasificaciones() as $key => $clasificacion) {
			$arreglo['clasificaciones'][$key]['proposito'] = $clasificacion->getProposito()->getDescripcion();
			$arreglo['clasificaciones'][$key]['descripcion'] = $clasificacion->getDescripcion();
			$arreglo['clasificaciones'][$key]['clave'] = $clasificacion->getClave();
		}
		return $arreglo;
		
	}

	
}
?>