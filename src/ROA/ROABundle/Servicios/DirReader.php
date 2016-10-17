<?php

namespace ROA\ROABundle\Servicios;
use ROA\ROABundle\Servicios\DirReader;

class DirReader
{
	private $handle;

	public function __construct(){

	}
	public function read($path, $param){

		//$handle = opendir($path);	
		if ($handle = opendir($path)) {

		    while (false !== ($entry = readdir($handle))) {

		    	$fullName = explode('.', $entry);
		    	$name = $fullName[0];
		    	$extension = $fullName[1];

		    	if ($name == $param){
		    		return $fullName;
		    	}
		    }
	    }

	}
}
?>