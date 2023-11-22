<?php
namespace Generic\Model\KategorieMagazyn;
use Generic\Biblioteka\ObiektDanych;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id 
 * @property int $idProjektu 
 * @property int $prawy 
 * @property int $lewy 
 * @property int $poziom 
 * @property string $nazwa 
 * @property string $kategoriaGlowna 
 * @property bool $blokujWyswietlanie 
 * @property bool $blokujPrzypisywanie 
 * @property int $opiekun 
 */

class Obiekt extends ObiektDanych
{
	/**
	 * @var \Generic\Konfiguracja\Model\KategorieMagazyn\Obiekt
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Model\KategorieMagazyn\Obiekt
	 */
	protected $j;
	
	function pobierzRodzic()
	{
		$mapper = Cms::inst()->dane()->KategoriaOgloszen();
		if (isset($this->_wartosci['idRodzica']) && $this->_wartosci['idRodzica'] > 0)
		{
			$this->_cache['rodzic'] = $mapper->pobierzPoId($this->_wartosci['idRodzica']);
		}
		else
		{
			return false;
		}
		return $this->_cache['rodzic'];
	}



	function ustawPrawy($wartosc)
	{
		trigger_error('Nie mozna ustwic klucza \'prawy\' obiektu '.get_class($this), E_USER_WARNING);
	}



	function ustawLewy($wartosc)
	{
		trigger_error('Nie mozna ustwic klucza \'lewy\' obiektu '.get_class($this), E_USER_WARNING);
	}



	function ustawPoziom($wartosc)
	{
		trigger_error('Nie mozna ustwic klucza \'poziom\' obiektu '.get_class($this), E_USER_WARNING);
	}



	/*
	 * Przenosi obiekt danych obok kategorii o podanym id
	 *
	 * @param KategorieOgloszenMapper $mapper Mapper obslugujacy polaczenie z baza
	 * @param int $idNowegoSasiada Identyfikator nowego sasiada
	 * @param string $polozenie Polozenie obok nowego sasiada: 'przed' lub 'po'
	 * @return bool True jezeli sukces, False w przeciwnym wypadku
	 */
	function przeniesObok(KategoriaOgloszen\Mapper $mapper, $idNowegoSasiada, $polozenie)
	{
		if ( ! array_key_exists('id', $this->_wartosci) || $this->_wartosci['id'] < 1)
		{
			trigger_error('Nie mozna przenosic obiektu klasy '.get_class($this).' poniewaz nie jest on zapisany w bazie.', E_USER_WARNING);
			return false;
		}
		if ($mapper->przeniesObok($this, $idNowegoSasiada, $polozenie))
		{
			list($lewyId, $prawyId, $poziom) = $mapper->info($this);
			$this->_wartosci['prawy'] = $prawyId;
			$this->_wartosci['lewy'] = $lewyId;
			$this->_wartosci['poziom'] = $poziom;
			return true;
		}
		return false;
	}



	/*
	 * Zmienia kategorie nadrzedna dla bierzacej kategorii
	 *
	 * @param KategorieOgloszenMapper $mapper Mapper obslugujacy polaczenie z baza
	 * @param int $idNowegoRodzica Identyfikator nowego rodzica
	 *
	 * @return bool True jezeli sukces, False w przeciwnym wypadku
	 */
	function zmienRodzica(KategoriaOgloszen\Mapper $mapper, $idNowegoRodzica)
	{
		if ( ! array_key_exists('id', $this->_wartosci) || $this->_wartosci['id'] < 1)
		{
			trigger_error('Nie mozna przenosic obiektu klasy '.get_class($this).' poniewaz nie jest on zapisany w bazie.', E_USER_WARNING);
			return false;
		}
		if ($mapper->zmienRodzica($this, $idNowegoRodzica))
		{
			list($lewyId, $prawyId, $poziom) = $mapper->info($this);
			$this->_wartosci['prawy'] = $prawyId;
			$this->_wartosci['lewy'] = $lewyId;
			$this->_wartosci['poziom'] = $poziom;
			$this->_wartosci['idRodzica'] = $idNowegoRodzica;
			return true;
		}
		return false;
	}
}