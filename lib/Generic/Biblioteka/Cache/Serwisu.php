<?php
namespace Generic\Biblioteka\Cache;
use Generic\Biblioteka\Cache;
use Generic\Model\CacheLinki;
use Generic\Biblioteka\Cms;


/**
 * Klasa bazowa dla elementow serwisu
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
abstract class Serwisu
{

	/**
	 * Silnik ogsługujący generowanie cache
	 * @var Cache_Silnik
	 */
	protected $silnikCache;



	/**
	 * Ustawia silnik cache
	 * @param Cache_Silnik $silnik
	 */
	public function ustawSilnikCache(Cache\Silnik $silnik)
	{
		$this->silnikCache = $silnik;
	}



	/**
	 * Sprawdza czy cache jest dostepny
	 * @return bool
	 */
	public function cacheDostepny()
	{
		return $this->silnikCache->dostepny();
	}



	/**
	 * Ustawienie czasu dla generowanego cache
	 * @param int $czas
	 */
	public function ustawCzasCache($czas = 0)
	{
		$this->silnikCache->ustawCzas($czas);
	}



	/**
	 * Zapisuje tresc cache dla konkretnego klucza
	 * @param string $klucz
	 * @param string $tresc
	 * @return bool
	 */
	public function tworzCache($klucz, $tresc)
	{
		$klucz = $this->filtrujKlucz($klucz);
		$tresc = $this->filtrujTresc($tresc);

		return $this->silnikCache->zapisz($klucz, $tresc);
	}



	/**
	 * Odczytuje tresc cache dla konkretnego klucza
	 * @param string $klucz
	 * @return bool
	 */
	public function odczytajCache($klucz)
	{
		$klucz = $this->filtrujKlucz($klucz);
		return $this->silnikCache->pobierz($klucz);
	}



	/**
	 * Usuwa tresc cache dla konkretnego klucza
	 * @param string $klucz
	 * @return bool
	 */
	public function usunCache($klucz)
	{
		$klucz = $this->filtrujKlucz($klucz);
		return $this->silnikCache->usun($klucz);
	}



	/**
	 * Sprawdza czy istnieje cache dla konkretnego klucza
	 * @param string $klucz
	 * @return bool
	 */
	public function istniejeCache($klucz)
	{
		$klucz = $this->filtrujKlucz($klucz);
		return $this->silnikCache->istnieje($klucz);
	}



	/**
	 * Czysci caly cache
	 * @return bool
	 */
	public function czyscCache()
	{
		return $this->silnikCache->czysc();
	}



	/**
	 * Wyswietla liste zcachowanych elementow dla danego typu cache
	 * @return array
	 */
	protected abstract function pobierzListe();



	/**
	 * Filtruje nazwe klucza przy kazdym odwołaniu się do niego
	 * @param string $klucz
	 * @return string
	 */
	protected abstract function filtrujKlucz($klucz);



	/**
	 * Filtruje zapisywana tresc
	 * @param string $tresc
	 * @return string
	 */
	protected function filtrujTresc($tresc)
	{
		return $tresc;
	}



	protected function zapiszCacheLinkow($klucz, $tresc, $typ)
	{
		$listaUrl = array();
		if (preg_match_all('/<a\s+[^>]*href="(http[^"]*)"/', $tresc, $znalezione) !== false)
		{
			foreach ($znalezione[1] as $url)
			{
				$url = strtolower($url);
				if (in_array($url, $listaUrl)) continue;
				if (preg_match('/\/([a-z\d][a-z\d-]+[a-z\d])-o([\d]+)$/', $url)
					|| preg_match('/www\.[a-z\d]+.'.DOMENA.'\/$/', $url))
				{
					$listaUrl[] = $url;
				}
			}
			$linkiCache = new CacheLinki\Obiekt();
			$linkiCache->url = $klucz;
			$linkiCache->typ = $typ;
			$linkiCache->dataDodania = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
			$linkiCache->listaZawartychUrl = (count($listaUrl) > 0) ? '|'.implode('|', $listaUrl).'|' : '';
			$linkiCache->zapisz(Cms::inst()->dane()->CacheLinki());
		}
	}

}
