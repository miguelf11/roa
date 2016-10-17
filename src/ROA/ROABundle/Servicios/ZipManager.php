<?php

namespace ROA\ROABundle\Servicios;
use ROA\ROABundle\Servicios\PclZip;

class ZipManager
{
	private $archive;

	public function __construct(){

	}
	public function unZip($webpath, $id){


		$this->archive = new PclZip();
		//$this->archive = $this->get('pclzip');
        $this->archive->setZipname($webpath);
         if ($this->archive->extract(PCLZIP_OPT_PATH, 'downloads/'.$id) == 0) {
            die("Error : ".$this->archive->errorInfo(true));
        }
		
	}
}
?>