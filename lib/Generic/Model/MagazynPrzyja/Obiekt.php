<?php
namespace Generic\Model\MagazynPrzyja;
use Generic\Biblioteka\ObiektDanych;
use Generic\Biblioteka\Cms;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $idProjektu 
 * @property int $idOddajacego 
 * @property int $idOsobyAkceptujacej 
 * @property string $obiektOddajacy 
 * @property int $idPrzyjmujacego 
 * @property string $dataDodania 
 * @property string $podpis 
 * @property string $podpisVector 
 * @property bool $zwrot 
 */

class Obiekt extends ObiektDanych
{
	/**
	 * @var \Generic\Konfiguracja\Model\MagazynPrzyja\Obiekt
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Model\MagazynPrzyja\Obiekt
	 */
	protected $j;
	
	public function pobierzOsobeZdajacaProdukty()
	{
		if ( ! isset($this->_cache['osobaZdajaca']))
		{
			$obiektZdajacy = $this->obiektOddajacy;
			
			if($this->idOddajacego > 0)
				$this->_cache['osobaZdajaca'] = Cms::inst()->dane()->$obiektZdajacy()->pobierzPoId($this->idOddajacego);
			else
				$this->_cache['osobaZdajaca'] = null;
		}
		
		return $this->_cache['osobaZdajaca'];
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

	public function pobierzOsobePrzyjmujaca()
	{
		if ( ! isset($this->_cache['osobaPrzyjmujaca']))
		{
			if($this->idPrzyjmujacego  > 0)
				$this->_cache['osobaPrzyjmujaca'] = Cms::inst()->dane()->Uzytkownik()->pobierzPoId($this->idPrzyjmujacego );
			else
				$this->_cache['osobaPrzyjmujaca'] = null;
		}
		
		return $this->_cache['osobaPrzyjmujaca'];
	}
	
	public function pobierzProdukty()
	{
		if ( ! isset($this->_cache['produkty']))
		{
			$this->_cache['produkty'] = Cms::inst()->dane()->MagazynPrzyjeteProdukty()->zwracaTablice()->szukaj(array('id_magazyn_przyja' => $this->id ));
		}
		
		return $this->_cache['produkty'];
	}
	
}