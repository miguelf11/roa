<?php

namespace ROA\ROABundle\Servicios;
use ROA\ROABundle\Servicios\HtmlGenerator;

class HtmlGenerator
{
	public $data;

	public function __construct(){
		$data ="";
	}
	public function html_video($path){
		$data = 
		'<html>
            <head>
            	<title></title>
            </head>

            <body>
           	<video width="500" height="350" controls>
                <source src="'.$path.'" type="video/ogg">
                <source src="'.$path.'" type="video/mp4">
                <source src="'.$path.'" type="video/webm">
                <source src="'.$path.'" type="video/avi">
                <source src="'.$path.'" type="video/msvideo">
                <source src="'.$path.'" type="video/x-msvideo">
                Tu Navegador no soporta este video.
            </video>
           	</body>
        </html>';
        return $data;
	}

	public function html_audio($path){
		$data = 
		'<html>
            <head>
            	<title></title>
            </head>

            <body>
            <audio controls>d
	  			<source src="'.$path.'" type="audio/mpeg">
                <source src="'.$path.'" type="audio/ogg">
                <source src="'.$path.'" type="audio/flac">
                <source src="'.$path.'" type="audio/opus">
                <source src="'.$path.'" type="audio/webm">   
	  			Tu Navegador no soporta este archivo de audio.
			</audio>
           	</body>
        </html>';
        return $data;
	}

}
?>