<?php
namespace Generic\Model\MagazynWydane;
use Generic\Biblioteka\ObiektDanych;
use Generic\Biblioteka\Cms;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $idProjektu 
 * @property int $idOdbiorcy 
 * @property string $obiektOdbiorcy 
 * @property mixed $status 
 * @property string $podpis 
 * @property mixed $typPodpisu 
 * @property int $idOsobyAkceptujacej 
 * @property int $idOsobyWydajacej 
 * @property mixed $dataDodania
 * @property mixed $dataWydania
 * @property string $opis 
 * @property string $podpisVector
 */

class Obiekt extends ObiektDanych
{
	/**
	 * @var \Generic\Konfiguracja\Model\MagazynWydane\Obiekt
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Model\MagazynWydane\Obiekt
	 */
	protected $j;
	
	public function pobierzOdbiorce()
	{
		if ( ! isset($this->_cache['odbiorca']))
		{
			$obiektOdbiorcy = $this->obiektOdbiorcy;
			
			if($this->idOdbiorcy > 0)
				$this->_cache['odbiorca'] = Cms::inst()->dane()->$obiektOdbiorcy()->pobierzPoId($this->idOdbiorcy);
			else
				$this->_cache['odbiorca'] = null;
		}
		
		return $this->_cache['odbiorca'];
	}
	
	public function pobierzOsobeAkceptujaca()
	{
		if ( ! isset($this->_cache['osobaAkceptujaca']))
		{
			
			if($this->idOsobyAkceptujacej > 0)
				$this->_cache['osobaAkceptujaca'] = Cms::inst()->dane()->Uzytkownik()->pobierzPoId($this->idOsobyAkceptujacej);
			else
				$this->_cache['osobaAkceptujaca'] = null;
		}
		
		return $this->_cache['osobaAkceptujaca'];
	}
	
	public function pobierzOsobeWydajaca()
	{
		if ( ! isset($this->_cache['osobaWydajaca']))
		{
			
			if($this->idOsobyWydajacej > 0)
				$this->_cache['osobaWydajaca'] = Cms::inst()->dane()->Uzytkownik()->pobierzPoId($this->idOsobyWydajacej);
			else
				$this->_cache['osobaWydajaca'] = null;
		}
		
		return $this->_cache['osobaWydajaca'];
	}
	
	public function pobierzProdukty()
	{
		if ( ! isset($this->_cache['produkty']))
		{
			$this->_cache['produkty'] = Cms::inst()->dane()->MagazynWydaneProdukty()->zwracaTablice()->szukaj(array('id_zamowienia' => $this->id ));
		}
		
		return $this->_cache['produkty'];
	}
	
	
}