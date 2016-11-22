<?php

namespace ROA\ROABundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * OARepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class OARepository extends EntityRepository
{

	public function findByUsuarioAndStatus($id, $status){

		$em = $this->getEntityManager();
		$dql = "select o from ROABundle:OA o JOIN o.status s WITH s.descripcion LIKE '".$status."' JOIN o.usuario u WITH u.id = '".$id."' ORDER BY o.fecha_publicacion DESC";
		$query = $em->createQuery($dql);
		$usuarios = $query->getResult();
		return $usuarios;
	}

	public function findBySubcategoriaAndStatus($subcategoria, $status){

		$em = $this->getEntityManager();
		$dql = "select o from ROABundle:OA o JOIN o.status s JOIN o.subcategoria sub WITH s.descripcion LIKE '".$status."' AND sub.id =".$subcategoria." ORDER BY o.fecha_publicacion DESC";
		$query = $em->createQuery($dql);
		$OAs = $query->getResult();
		return $OAs;
	}

	public function findByAreaAndStatus($area, $status){

		$em = $this->getEntityManager();
		$dql = "select o from ROABundle:OA o JOIN o.status s JOIN o.area sub WITH s.descripcion LIKE '".$status."' AND sub.id =".$area." ORDER BY o.fecha_publicacion DESC";
		$query = $em->createQuery($dql);
		$OAs = $query->getResult();
		return $OAs;
	}

	public function findNoAutorizados(){

		$em = $this->getEntityManager();
		$dql = "select o from ROABundle:OA o JOIN o.status s WITH s.descripcion NOT LIKE 'Certificado' ORDER BY o.fecha_publicacion DESC";
		$query = $em->createQuery($dql);
		$OAs = $query->getResult();
		return $OAs;
	}

	public function findByStatusCustom($status){

		$em = $this->getEntityManager();
		$dql = "select o from ROABundle:OA o JOIN o.status s WITH s.descripcion LIKE '".$status."' ORDER BY o.fecha_publicacion DESC";
		$query = $em->createQuery($dql);
		$OAs = $query->getResult();
		return $OAs;
	}

	public function findRecientes($limit){

		$em = $this->getEntityManager();
		$dql = "select o from ROABundle:OA o JOIN o.status s WITH s.descripcion LIKE 'Certificado' ORDER BY o.fecha_publicacion DESC";
		$query = $em->createQuery($dql);
		$query->setMaxResults($limit);
		$OAs = $query->getResult();
		return $OAs;
	}

	public function findMas_descargados($limit){

		$em = $this->getEntityManager();
		$dql = "select o from ROABundle:OA o JOIN o.status s WITH s.descripcion LIKE 'Certificado' ORDER BY o.num_descargas DESC";
		$query = $em->createQuery($dql);
		$query->setMaxResults($limit);
		$OAs = $query->getResult();
		return $OAs;
	}

	public function findAvanzada($area, $autor, $ano, $titulo){

		if ($area != ">0"){
			$area = "=".$area;
		}

		if ($titulo == ""){
			$titulo = "%";
		}

		if ($autor == "''"){
			$dql = "select o from ROABundle:OA o JOIN o.area s JOIN o.status st WHERE o.ano LIKE '".$ano."' AND s.id".$area." AND o.titulo LIKE '%".$titulo."%' AND st.descripcion LIKE 'Certificado' ORDER BY o.fecha_publicacion DESC";
		}else{
			$dql = "select o from ROABundle:OA o JOIN o.area s JOIN o.status st JOIN o.usuario u WHERE o.ano LIKE '".$ano."' AND s.id".$area." AND o.titulo LIKE '%".$titulo."%' AND st.descripcion LIKE 'Certificado' AND (u.nombre IN (".$autor.") OR u.apellido IN (".$autor.")) ORDER BY o.fecha_publicacion DESC";
		}

		$em = $this->getEntityManager();
		//$dql = "select o from ROABundle:OA o JOIN o.subcategoria s JOIN o.usuario u WHERE o.ano = ".$ano." AND s.id=".$subcategoria." AND u.nombre LIKE '%".$autor."%'";
		//$dql = "select o from ROABundle:OA o JOIN o.subcategoria s JOIN o.usuario u WHERE o.ano LIKE '".$ano."' AND s.id".$subcategoria." AND (u.nombre IN (".$autor.") OR u.apellido IN (".$autor."))";
		$query = $em->createQuery($dql);
		$OAs = $query->getResult();
		return $OAs;

	}
}
