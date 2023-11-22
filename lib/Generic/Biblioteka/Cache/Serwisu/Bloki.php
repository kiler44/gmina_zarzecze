<?php
namespace Generic\Biblioteka\Cache\Serwisu;
use Generic\Biblioteka\Cache;
use Generic\Biblioteka\Cms;


/**
 * Obsluga cache blokow
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
class Bloki extends Cache\Serwisu
{

	public $czyscLinkiPojedynczo = true;


	public function __construct()
	{
		$sciezka_cache = CACHE_KATALOG.'/bloki';
		$silnik = new Cache\Silnik\Katalog($sciezka_cache, '');
		$this->ustawSilnikCache($silnik);
	}



	public function pobierzListe()
	{
		$katalog = CACHE_KATALOG.'/bloki/';
		$lista = array();
		foreach (glob($katalog.'*', GLOB_NOSORT) as $plik)
		{
			$lista[] = array(
				'nazwa' => str_replace($katalog, '', $plik),
				'data_modyfikacji' => date('Y-m-d H:i:s', filemtime((string)$plik))
			);
		}
		return $lista;
	}



	protected function filtrujKlucz($klucz)
	{
		return $klucz;
	}



	public function tworzCache($klucz, $tresc)
	{
		$utworzono = parent::tworzCache($klucz, $tresc);
		if ($utworzono)
		{
			$this->zapiszCacheLinkow('#blok#'.$klucz, $tresc, 'blok');
		}
		return $utworzono;
	}



	public function usunCache($klucz)
	{
		$usunieto = parent::usunCache($klucz);
		if ($usunieto && $this->czyscLinkiPojedynczo)
		{
			Cms::inst()->dane()->CacheLinki()->usunWielePoUrl(array('#blok#'.$klucz));
		}
		return $usunieto;
	}



	public function czyscCache()
	{
		$wyczyszczono = parent::czyscCache();
		if ($wyczyszczono) Cms::inst()->dane()->CacheLinki()->czyscBloki();
		return $wyczyszczono;
	}


}
