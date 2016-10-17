<?php

namespace ROA\ROABundle\Servicios;
use ROA\ROABundle\Servicios\ExtensionChecker;

class ExtensionChecker
{

	public function __construct(){

	}
	public function check($extension){
		switch ($extension) {
			case 'mp4':
			case 'ogg':
			case 'webm':
			case 'avi':
				return 'video';
				break;

			case 'ogg':
			case 'flac':
			case 'mpeg':
				return 'audio';
				break;
			
			default:
				# code...
				break;
		}
	}

}
?>