<?php
namespace Generic\Model\RaportEdytowalny;
use Generic\Biblioteka\ObiektDanych;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $idProjektu 
 * @property string $nazwa 
 * @property string $opis 
 * @property int $grupa 
 * @property string $kodSql 
 * @property string $nazwyPol 
 * @property string $uprawnieniUzytkownicy 
 * @property string $filtry 
 * @property mixed $dataDodania 
 * @property int $cache 
 * @property mixed $dataModyfikacji 
 * @property int $zezwolZaawansowany 
 * @property string $typWykresu 
 * @property string $kolumnyWykresu 
 * @property string $typyKolumnTabeli 
 * @property string $kolumnaWykresuDaty 
 * @property int $typWykresuModyfikowalny 
 * @property string $subZapytania 
 */

class Obiekt extends ObiektDanych
{
	/**
	 * @var \Generic\Konfiguracja\Model\RaportyEdytowalne\Obiekt
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Model\RaportyEdytowalne\Obiekt
	 */
	protected $j;
	
	//Dwie poniższe metody muszą być w takie formie.s

	public function ustawUprawnieniUzytkownicy(Array $wartosc)
	{
		$this->_wartosci['uprawnieniUzytkownicy'] = ',' . implode(',', $wartosc) . ',';
		if ( ! in_array('uprawnieniUzytkownicy', $this->_zmodyfikowane)) $this->_zmodyfikowane[] = 'uprawnieniUzytkownicy';
	}

	public function pobierzUprawnieniUzytkownicy()
	{
		if ( !isset($this->_wartosci['uprawnieniUzytkownicy']))
		{
			return array();
		}

		return explode(',', substr($this->_wartosci['uprawnieniUzytkownicy'], 1, strlen($this->_wartosci['uprawnieniUzytkownicy']) - 2));
	}


	public function ustawNazwyPol(Array $wartosc)
	{
		$this->tablicaUstawWartosc('nazwyPol', $wartosc);
	}

	public function pobierzNazwyPol()
	{
		return $this->tablicaPobierzWartosc('nazwyPol');
	}


	public function ustawKolumnyWykresu(Array $wartosc)
	{
		$this->tablicaUstawWartosc('kolumnyWykresu', $wartosc);
	}

	public function pobierzKolumnyWykresu()
	{
		return $this->tablicaPobierzWartosc('kolumnyWykresu');
	}


	public function ustawFiltry(Array $wartosc)
	{
		$this->tablicaUstawWartosc('filtry', $wartosc);
	}

	public function pobierzFiltry()
	{
		return $this->tablicaPobierzWartosc('filtry');
	}


	public function ustawTypyKolumnTabeli(Array $wartosc)
	{
		$this->tablicaUstawWartosc('typyKolumnTabeli', $wartosc);
	}

	public function pobierzSubZapytania()
	{
		return $this->tablicaPobierzWartosc('subZapytania');
	}


	public function ustawSubZapytania(Array $wartosc)
	{
		$this->tablicaUstawWartosc('subZapytania', $wartosc);
	}

	public function pobierzTypyKolumnTabeli()
	{
		return $this->tablicaPobierzWartosc('typyKolumnTabeli');
	}

	public function czyUzytkownikUprawniony($idUzytkownika)
	{
		return in_array($idUzytkownika, $this->pobierzUprawnieniUzytkownicy());
	}

	public function pobierzFiltryPoczatkowe()
	{
		return $this->tablicaPobierzWartosc('filtryPoczatkowe');
	}


	public function ustawFiltryPoczatkowe(Array $wartosc)
	{
		$this->tablicaUstawWartosc('filtryPoczatkowe', $wartosc);
	}

	public function pobierzFiltryPoczatkoweWartosci()
	{
		return $this->tablicaPobierzWartosc('filtryPoczatkoweWartosci');
	}


	public function ustawFiltryPoczatkoweWartosci(Array $wartosc)
	{
		$this->tablicaUstawWartosc('filtryPoczatkoweWartosci', $wartosc);
	}

	public function pobierzFiltryPoczatkoweEtykiety()
	{
		return $this->tablicaPobierzWartosc('filtryPoczatkoweEtykiety');
	}


	public function ustawFiltryPoczatkoweEtykiety(Array $wartosc)
	{
		$this->tablicaUstawWartosc('filtryPoczatkoweEtykiety', $wartosc);
	}
}