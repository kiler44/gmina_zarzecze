<?php
namespace Generic\Biblioteka\Cache\Silnik;
use Generic\Biblioteka\Cache;
use Generic\Biblioteka;
use Generic\Biblioteka\Plik;


/**
 * Obsluga cache z dysku
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
class Katalog implements Cache\Silnik
{

	/**
	 * Katalog przetrzymujący Cache
	 * @var Katalog
	 */
	private $katalogCache;



	/**
	 * Rozszerzenie pliku przetrzymującego cache
	 * @var string
	 */
	private $rozszerzenie;



	/**
	 * Czas w sekundach przez jaki ma byc przetrzymywany cache
	 * @var integer
	 */
	private $czas = 0;



	public function __construct($katalogCache, $rozszerzenie = '.html')
	{
		$this->katalogCache = new Biblioteka\Katalog($katalogCache, true);
		$this->rozszerzenie = (string)$rozszerzenie;
	}



	public function dostepny()
	{
		return $this->katalogCache->doZapisu();
	}



	public function ustawCzas($czas = 0)
	{
		$this->czas = (int)$czas;
	}



	public function pobierz($klucz)
	{
		$plik = new Plik($this->_budujSciezke($klucz));
		if ( ! $plik->istnieje()) return null;

		if ($this->czas > 0)
		{
			$czasModyfikacji = filemtime((string)$plik);
			if ($czasModyfikacji + $this->czas < date('U'))
			{
				return null;
			}
		}
		return file_get_contents((string)$plik);
	}



	public function zapisz($klucz, $dane)
	{
		$plik = fopen($this->_budujSciezke($klucz, true), 'w');
		if ( ! is_resource($plik)) return;
		$zapisano = fwrite($plik, $dane);
		fclose($plik);
		return $zapisano;

		//$zapisanoBajtow = file_put_contents($this->_budujSciezke($klucz, true), $dane/*, LOCK_EX*/);
		//return ($zapisanoBajtow !== false) ? true : false;
	}



	public function usun($klucz)
	{
		$plik = new Plik($this->_budujSciezke($klucz));
		if ($plik->istnieje())
		{
			return $plik->usun();
		}
		else
		{
			return 1;
		}
	}



	public function istnieje($klucz)
	{
		$plik = new Plik($this->_budujSciezke($klucz));
		return $plik->istnieje();
	}



	public function czysc()
	{
/*		$sciezka = (string)$this->katalogCache;
		if ( ! $this->katalogCache->usun()) return false;
		$this->katalogCache = new Katalog($sciezka, true);
		return $this->katalogCache->istnieje();
*/		return $this->katalogCache->usun();
	}



	protected function _budujSciezke($klucz, $tworzKatalog = false)
	{
		$klucz = $this->normalizujNazwe($klucz);
		$sciezka = explode('/', ltrim($klucz, '/'));

		$nazwa_pliku = array_pop($sciezka);

		$katalog = trim(implode('/', $sciezka));
		if ($katalog != '') $katalog .= '/';

		$rozszerzenie = '';
		if (substr($nazwa_pliku, -((int)strlen($this->rozszerzenie))) != $this->rozszerzenie) $rozszerzenie = $this->rozszerzenie;

		$sciezka = rtrim($this->katalogCache, '/').'/'.$katalog;

		if ($tworzKatalog && $katalog != '') $k = new Biblioteka\Katalog($sciezka, true);

		return $sciezka.$nazwa_pliku.$rozszerzenie;
	}



	protected function normalizujNazwe($string)
	{
		$znajdz = array('?', '&', '&amp;', '\\', ',', '=', ':', '*', '"', '<', '>', '|');
		$zamien = array('-');
		$wynik = str_replace($znajdz, '-', $string);

		return $wynik;
	}

}
