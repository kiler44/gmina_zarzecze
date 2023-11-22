<?php
namespace Generic\Biblioteka\Cache\Serwisu;
use Generic\Biblioteka\Cache;
use Generic\Biblioteka\Cms;


/**
 * Obsluga cache subdomen
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
class Subdomena extends Cache\Serwisu
{

	public $czyscLinkiPojedynczo = true;


	protected $subdomena;



	public function __construct($subdomena)
	{
		$this->subdomena = $subdomena;
		$sciezka_cache = CACHE_KATALOG.'/wizytowki/'.substr($subdomena, 0, 2).'/'.$subdomena.'/';
		$silnik = new Cache\Silnik\Katalog($sciezka_cache, '');
		$this->ustawSilnikCache($silnik);
	}



	public function pobierzListe()
	{
		$katalog = CACHE_KATALOG.'/wizytowki/'.substr($this->subdomena, 0, 2).'/'.$this->subdomena.'/';
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
					if (substr($nazwa, -10) == 'index.html')
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
		if (substr($klucz, -1) == '/')
		{
			$klucz .= 'index.html';
		}
		return $klucz;
	}



	public function tworzCache($klucz, $tresc)
	{
		$utworzono = parent::tworzCache($klucz, $tresc);
		if ($utworzono) $this->zapiszCacheLinkow('#'.$this->subdomena.'#'.$klucz, $tresc, 'podstrona_wizytowki');
		return $utworzono;
	}



	public function usunCache($klucz)
	{
		$usunieto = parent::usunCache($klucz);
		if ($usunieto && $this->czyscLinkiPojedynczo)
		{
			Cms::inst()->dane()->CacheLinki()->usunWielePoUrl(array('#'.$this->subdomena.'#'.$klucz));
		}
		return $usunieto;
	}



	public function czyscCache()
	{
		$wyczyszczono = parent::czyscCache();
		if ($wyczyszczono) Cms::inst()->dane()->CacheLinki()->czyscSubdomene($this->subdomena);
		return $wyczyszczono;
	}

}
