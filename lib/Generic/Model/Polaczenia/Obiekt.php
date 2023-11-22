<?php
namespace Generic\Model\Polaczenia;
use Generic\Biblioteka\ObiektDanych;
use Generic\Biblioteka\Kontener\Mappery;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $idProjektu 
 * @property int $idObject_1 
 * @property int $idObject_2 
 * @property string $typObject_1 
 * @property string $typObject_2 
 * @property mixed $dataDodania 
 */

class Obiekt extends ObiektDanych
{
	/**
	 * @var \Generic\Konfiguracja\Model\Polaczenia\Obiekt
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Model\Polaczenia\Obiekt
	 */
	protected $j;
	
	private $kryteriaWieleId = array(
		'Zamowienie' => 'wiele_id',
	);
	
	public function pobierzPolaczeniaDlaObiekt1($obiekt1, $pobierzTablica = false, $polaTablicy = array())
	{
		$maperPolaczenie = new Mapper();
		$kryteria['obiekt_1'] = $obiekt1->id;
		$kryteria['typ_obiekt_1'] = $this->pobierzTypObjektu($obiekt1);
		if($pobierzTablica)
		{
			return $maperPolaczenie->zwracaTablice(implode(',',$polaTablicy))->szukaj($kryteria);
		}
		return $maperPolaczenie->szukaj($kryteria);
	}
	
	public function pobierzPolaczeniaDlaObiekt2($obiekt2, $pobierzTablica = false, $polaTablicy = array())
	{
		$maperPolaczenie = new Mapper();
		$kryteria['obiekt_2'] = $obiekt2->id;
		$kryteria['typ_obiekt_2'] = $this->pobierzTypObjektu($obiekt2);
		if($pobierzTablica)
		{
			return $maperPolaczenie->zwracaTablice(implode(',',$polaTablicy))->szukaj($kryteria);
		}
		return $maperPolaczenie->szukaj($kryteria);
	}
	
	public function pobierzPolaczeniaDlaObiekt2argumentami($idObiektu, $typObiektu, $pobierzTablica = false, $polaTablicy = array())
	{
		$maperPolaczenie = new Mapper();
		$kryteria['obiekt_2'] = $idObiektu;
		$kryteria['typ_obiekt_2'] = $typObiektu;
		if($pobierzTablica)
		{
			return $maperPolaczenie->zwracaTablice(implode(',',$polaTablicy))->szukaj($kryteria);
		}
		return $maperPolaczenie->szukaj($kryteria);
	}
	
	/**
	 * @todo dorobić auto zaczytywanie różnego typu obiektów
	 * @param type $obiekt2 - Objekt dla którego szukamy polaczen
	 * @param type $typObject1 - typ obiektu 1 dla szukanych polaczen
	 * @return type
	 */
	public function pobierzPolaczoneObiektyDlaObiekt2($obiekt2, $typObject1 = null, $kryteria = array() )
	{
		$maperPolaczenie = new Mapper();
		$kryteria['obiekt_2'] = $obiekt2->id;
		$kryteria['typ_obiekt_2'] = $this->pobierzTypObjektu($obiekt2);
		$polaczenia = $maperPolaczenie->zwracaTablice('id_object_1', 'typ_object_1')->szukaj($kryteria);
		
		$pobraneDane = array();
		
		if($typObject1 != null)
		{
			if(count($polaczenia) > 0)
			{
				$mappery = new Mappery();
				if(method_exists($mappery, $typObject1))
				{
					$wieleId = array_keys(listaZTablicy($polaczenia, 'id_object_1'));
					$mapperObject1 = $mappery->$typObject1();
					if($wieleId > 0)
					{
						$kryteriaSzukania = array_merge(array($this->kryteriaWieleId[$typObject1] => $wieleId), $kryteria);
						$pobraneDane = $mapperObject1->zwracaTablice()->szukaj($kryteriaSzukania);
					}
				}
			}
			
		}
		return $pobraneDane;
	}
	
	public function usunPolaczenie($obiekt1 , $obiekt2)
	{
		$maperPolaczenie = new Mapper();
		$polaczenie = $this->pobierzPolaczenia($obiekt1, $obiekt2);
		if(isset($polaczenie[0]))
			$polaczenie[0]->usun($maperPolaczenie);
			
	}


	public function pobierzPolaczenia($obiekt1 , $obiekt2)
	{
		$maperPolaczenie = new Mapper();
		$kryteria['obiekt_1'] = $obiekt1->id;
		$kryteria['obiekt_2'] = $obiekt2->id;
		
		$kryteria['typ_obiekt_1'] = $this->pobierzTypObjektu($obiekt1);
		$kryteria['typ_obiekt_2'] = $this->pobierzTypObjektu($obiekt2);
		
		return $maperPolaczenie->szukaj($kryteria);
	}
	
	public function zapiszPolaczenie($obiekt1 , $obiekt2)
	{
		$maperPolaczenie = new Mapper();
		
		$typObiektu1 = $this->pobierzTypObjektu($obiekt1);
		$typObiektu2 = $this->pobierzTypObjektu($obiekt2);
		
		$this->idObject_1 = $obiekt1->id;
		$this->idObject_2 = $obiekt2->id;
		$this->typObject_1 = $typObiektu1;
		$this->typObject_2 = $typObiektu2;
		
		return $this->zapisz($maperPolaczenie);
	}
	
	protected function pobierzTypObjektu($obiekt)
	{
		$chunks = explode('\\', get_class($obiekt));
		return $chunks[count($chunks)-2];
	}
}