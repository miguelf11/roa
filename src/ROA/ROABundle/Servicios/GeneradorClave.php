<?php

namespace ROA\ROABundle\Servicios;

class GeneradorClave
{
	private $letras;
	private $numeros;
	private $clave;

	public function __construct(){

		$this->numeros = rand(100, 1000);

        for ($i = 1; $i <= 4; $i++){
            $random = chr(rand(ord("a"), ord("z")));
            $this->letras .= $random;
        }
        $this->clave = $this->letras.$this->numeros;

	}
	public function getClave(){
		return $this->clave;	
	}
}
?>