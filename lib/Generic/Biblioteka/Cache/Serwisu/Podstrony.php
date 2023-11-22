<?php
namespace Generic\Biblioteka\Cache\Serwisu;
use Generic\Biblioteka\Cache;
use Generic\Biblioteka\Cms;


/**
 * Obsluga cache podstron serwisu
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
class Podstrony extends Cache\Serwisu
{

	public $czyscLinkiPojedynczo = true;


	public function __construct()
	{
		$sciezka_cache = CACHE_KATALOG.'/kategorie/';
		$silnik = new Cache\Silnik\Katalog($sciezka_cache, '.html');

		//uwaga na klucze  i pobieranie listy przy zmianie na memcache
		//$serwery = array('' => 100);
		//$silnik = new Cache_Silnik_Memcached($serwery);

		$this->ustawSilnikCache($silnik);
	}



	public function pobierzListe()
	{
		$katalog = CACHE_KATALOG.'/kategorie/';
		$sciezki[] = $katalog.'*';
		$lista = array();
		while (count($sciezki) != 0)
		{
			$sciezka = array_shift($sciezki);
			foreach (glob($sciezka, GLOB_NOSORT) as $plik)
			{
				if (is_dir($plik))
				{
					$sciezki[] = $plik . '/*';
				}
				else
				{
					$nazwa = str_replace($katalog, '', $plik);
					if (preg_match('/\/([a-z\d][a-z\d-]+[a-z\d])-o([\d]+)$/', $nazwa))
					{
						$nazwa = substr($nazwa, 4);
					}
					elseif (substr($nazwa, -10) == 'index.html')
					{
						$nazwa = substr($nazwa, 0, -10);
					}

					$lista[] = array(
						'nazwa' => '/'.$nazwa,
						'data_modyfikacji' => date('Y-m-d H:i:s', filemtime((string)$plik))
					);
				}
			}
		}
		return $lista;
	}



	protected function filtrujKlucz($klucz)
	{
		$klucz = trim($klucz);
		if (preg_match('/^\/([a-z\d][a-z\d-]+[a-z\d])-o([\d]+)$/', $klucz))
		{
			$klucz = substr($klucz, 0, 4).'/'.ltrim($klucz,'/');
		}
		elseif (substr($klucz, -1) == '/')
		{
			$klucz .= 'index.html';
		}
		return $klucz;
	}



	public function tworzCache($klucz, $tresc)
	{
		$utworzono = parent::tworzCache($klucz, $tresc);
		if ($utworzono)
		{
			$this->zapiszCacheLinkow($klucz, $tresc, 'podstrona_portalowa');
		}
		return $utworzono;
	}



	public function usunCache($klucz)
	{
		$usunieto = parent::usunCache($klucz);
		if ($usunieto && $this->czyscLinkiPojedynczo)
		{
			Cms::inst()->dane()->CacheLinki()->usunWielePoUrl(array($klucz));
		}
		return $usunieto;
	}



	public function czyscCache()
	{
		$wyczyszczono = parent::czyscCache();
		if ($wyczyszczono) Cms::inst()->dane()->CacheLinki()->czyscStrony();
		return $wyczyszczono;
	}

}
