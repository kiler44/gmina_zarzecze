<?php
namespace Generic\Model\Zalacznik;
use Generic\Biblioteka\ObiektDanych;
use Generic\Biblioteka\Cms;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $idProjektu 
 * @property int $object 
 * @property int $idObject 
 * @property string $file 
 * @property string $dateAdded 
 * @property enum $status
 * @property string $type
 * @property int $idAuthor
 * @property string $rozmiar
 * @property string $kod
 * @property string $opis
 * @property int $pozycja
 */

class Obiekt extends ObiektDanych
{
	public function __construct($dane = array())
    {
        parent::__construct($dane);

        if($this->kod == null || $this->kod == '')
            $this->dajKod();
    }

    public function dajKod()
    {
        $this->kod = uniqid('', true);
    }

    public function ustawObiekt(ObiektDanych $obiekt)
    {
        $this->object = getModelClassNameWithouNamespace($obiekt);
        $this->idObject = $obiekt->id;
    }
	 
	 /**
	  * @param bool $pobierzZdomena
	  * @return string
	  */
    public function pobierzUrlZewnetrzny(bool $pobierzZdomena = false) : string
    {
		 $cms = Cms::inst();
		 $domena = $cms->projekt->domena;
		 $url = $cms->url(strtolower($this->object), $this->idObject,  $this->kod, $this->file);
		 return ($pobierzZdomena) ? $domena.$url : $domena;
    }
	 
	 /**
	  * 
	  * @param array $zalacznikArray
	  * @param bool $pobierzZdomena
	  * @return string
	  */
	 public function generujUrlZewnetrznyZTablicyObiektu(array $zalacznikArray, bool $pobierzZdomena = false): string
	 {
		 $cms = Cms::inst();
		 $domena = $cms->projekt->domena;
		 $url = $cms->url(strtolower($zalacznikArray['object']), $zalacznikArray['id_object'],  $zalacznikArray['kod'], $zalacznikArray['file']);
		 return ($pobierzZdomena) ? $domena.$url : $domena;
	 }
}