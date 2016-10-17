<?php

namespace ROA\ROABundle\Servicios;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class Serializador
{
	private $normalizers;
	private $encoders;
	private $serializer;

	public function __construct(){

		$this->encoders = array(new XmlEncoder(), new JsonEncoder());
        $this->normalizers = array(new GetSetMethodNormalizer());
       	$this->serializer = new Serializer($this->normalizers,  $this->encoders);
		//return $this->serializer;
	}
	public function getNormalizers(){
		return $this->normalizers;
	}
	public function getEncoders(){
		return $this->encoders;
	}
	public function getSerializer(){
		return $this->serializer;
	}
	public function serializar($objeto, $formato){
		
		return $this->getSerializer()->serialize($objeto, $formato);
	}

}
?>