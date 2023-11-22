<?php
namespace Generic\Model\ProduktyMagazyn;
use Generic\Biblioteka\ObiektDanych;
use Generic\Biblioteka\Cms;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $idProjektu 
 * @property int $kategoria 
 * @property string $kod 
 * @property string $nazwaProduktu 
 * @property int $ilosc 
 * @property int $iloscWydanych 
 * @property bool $wyswietlaj 
 * @property mixed $status 
 * @property string $zdjecie
 * @property bool $grupa
 * @property string $produktyGrupy
 * @property string $atrybuty
 * @property int $idOsobyDodajacej
 * @property string $opis
 * @property float $cena
 */

class Obiekt extends ObiektDanych
{
	/**
	 * @var \Generic\Konfiguracja\Model\ProduktyMagazyn\Obiekt
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Model\ProduktyMagazyn\Obiekt
	 */
	protected $j;


	public function __toString()
    {
        return $this->nazwaProduktu;
    }

    public function pobierzAtrybutyDlaUprawnien()
	{
		if( ! isset($this->_cache['atrybutyDlaUprawnien']))
		{
			$idOsobyZalogowanej = Cms::inst()->profil()->id;
			$uprawnienieUzytkownika = $this->pobierzUprawnieniaUzytkownika($idOsobyZalogowanej);
			
			$uprawnienia = $this->pobierzUprawnieniaAtrybutowZKonfiguracji();
			$atrybutyUprawnien = array();
			
			
			if(count($this->atrybuty) && $this->atrybuty != '' )
			{
				foreach($this->atrybuty as $nazwyAtrybutow => $dane )
				{
					$atrybutyUprawnien[$nazwyAtrybutow] = array(
						'uprawnienie' => $dane['uprawnienie'],
						'wartosc' => $dane['wartosc'],
						'wyswietlaj' => $this->sprawdzCzyWyswietlacAtrybut($dane['uprawnienie'], $uprawnienia, $uprawnienieUzytkownika),
					);
				}
			}
			

			$this->_cache['atrybutyDlaUprawnien'] = $atrybutyUprawnien;
		}
		return $this->_cache['atrybutyDlaUprawnien'];
	}
	
	public function pobierzOsobaDodajaca()
	{
		if( ! isset($this->_cache['osobaDodajaca']))
		{
			$this->_cache['osobaDodajaca'] = $this->dane()->Uzytkownik()->pobierzPoId($this->idOsobyDodajacej);
		}
		
		return $this->_cache['osobaDodajaca'];
	}

	private function sprawdzCzyWyswietlacAtrybut($dostep, $uprawnienia, $uprawnienieUzytkownika)
	{
		
		if(Cms::inst()->profil()->maRole(array('admin'))) return true;
		$tablicaUprawnien = explode(',', $uprawnienia[$dostep]);
		foreach($tablicaUprawnien as $uprawnienie)
		{
			if(trim($uprawnienie) == $uprawnienieUzytkownika)
				return true;
		}
		return false;
	}
	
	private function pobierzUprawnieniaUzytkownika($idOsobyZalogowanej)
	{
		if( ! isset($this->_cache['uprawnieniaUzytkownikaDoAtrybutow']))
		{
			$mapperKonfiguracja = new \Generic\Model\WierszKonfiguracji\Mapper();
			$roleOsobyWydajacej = $mapperKonfiguracja->pobierzWartoscWierszaKonfiguracji('role_opiekunow_kategorii_prodoktow', 'Magazyn_Admin');


			if($this->idOsobyDodajacej == $idOsobyZalogowanej)
			{
				$this->_cache['uprawnieniaUzytkownikaDoAtrybutow'] = 'osoba_dodajaca_produkt';
			}
			else if($this->sprawdzCzyWlascicielGrupy($idOsobyZalogowanej))
			{
				$this->_cache['uprawnieniaUzytkownikaDoAtrybutow'] = 'wlasciciel_grupy';
			}
			else if (Cms::inst()->profil()->maRole($roleOsobyWydajacej))
			{
				$this->_cache['uprawnieniaUzytkownikaDoAtrybutow'] = 'osoba_wydajaca';
			}
			else if(Cms::inst()->profil()->maRole(array('office_worker')))
			{
				$this->_cache['uprawnieniaUzytkownikaDoAtrybutow'] = 'pracownik_biurowy';
			}
			else if($this->sprawdzCzyUzytkownikPosiadaProdukt($idOsobyZalogowanej))
			{
				$this->_cache['uprawnieniaUzytkownikaDoAtrybutow'] = 'uzytkownik';
			}
			else
			{
				$this->_cache['uprawnieniaUzytkownikaDoAtrybutow'] = 'publiczne';
			}
		}
		return $this->_cache['uprawnieniaUzytkownikaDoAtrybutow'];
	}
	
	public function sprawdzCzyUzytkownikPosiadaProdukt($idUzytkownika)
	{
		if($this->id)
		{
			$produkt = Cms::inst()->dane()->MagazynWydane()->pobierzPoIdUzytkownikaIIdProduktu($this->id, $idUzytkownika);
			return (isset($produkt[0]['id']) && $produkt[0]['id'] > 0 ) ? true : false;
		}
		return false;
	}
	
	public function pobierzOpiekunProduktu()
	{
		if(!isset($this->_cache['opiekunProduktu']))
		{
			$sciezka = Cms::inst()->dane()->KategorieMagazyn()->pobierzSciezke($this->kategoria);
			$opiekun = null;
			foreach($sciezka as $kategoria)
			{
				if($kategoria->opiekun > 0)
					$opiekun = $this->pobierzOpiekuna($kategoria->opiekun);
			}
			$this->_cache['opiekunProduktu'] = $opiekun;
		}
		return $this->_cache['opiekunProduktu'];
	}
	
	private function pobierzOpiekuna($id)
	{
		$uzytkownik = $this->dane()->Uzytkownik()->pobierzPoId($id);
		if($uzytkownik instanceof \Generic\Model\Uzytkownik\Obiekt)
			return $uzytkownik;
		else
			return null;
	}
	
	public function sprawdzCzyWlascicielGrupy($idOsobyZalogowanej)
	{
		$sciezka = Cms::inst()->dane()->KategorieMagazyn()->pobierzSciezke($this->kategoria);
		foreach($sciezka as $kategoria)
		{
			if($kategoria->opiekun == $idOsobyZalogowanej)
				return true;
		}
		return false;
	}

	private function pobierzUprawnieniaAtrybutowZKonfiguracji()
	{
		$mapperKonfiguracja = new \Generic\Model\WierszKonfiguracji\Mapper();
		$uprawnienia = $mapperKonfiguracja->pobierzWartoscWierszaKonfiguracji('hierarachia_uprawnien', 'Magazyn_Admin');
		
		return $uprawnienia;
	}
	
	public function pobierzSciezkaKategorii()
	{
		if(!isset($this->_cache['sciezkaKategorii']))
		{
			$this->_cache['sciezkaKategorii'] = Cms::inst()->dane()->KategorieMagazyn()->pobierzSciezke($this->kategoria);
		}
		return $this->_cache['sciezkaKategorii'];
		
	}
}