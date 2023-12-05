<?php
namespace Generic\Biblioteka\Router;
use Generic\Biblioteka\Router;
use Generic\Model\RegulaRoutingu;
use Generic\Biblioteka\Cms;
use Generic\Model\Kategoria;
use Generic\Biblioteka\Zadanie;
use Generic\Model\Wizytowka;
use Generic\Model\Ogloszenie;
use Generic\Model\KategoriaOgloszen;
use Generic\Model\WizytowkaBranza;

/**
 * Obsluga tworzenia linkow i przekierowan.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Http
{

	/**
	 * Przechowuje instancję klasy Singleton
	 *
	 * @var Router_Http
	 */
	private static $_instancja = false;



	/**
	 * Przetrzymuje reguły filtrowania adresów url
	 * @var array
	 */
	private $reguly = array();



	/**
	 * Filtr parametrow url
	 * @var Router_FiltrParametry
	 */
	private $filtrParametrow;




	/**
	 * Przetrzymuje adres url który należy przetłumaczyć na kategorię i akcję
	 * @var string
	 */
	private $url = '';


	/**
	 * Przetrzymuje domenę
	 * @var string
	 */
	private $domena = '';


	/**
	 * Dane żądania pobrane z metody Router::analizujUrl()
	 *
	 * @var array
	 */
	private $parametryZadania = array(
		'usluga' => '',
		'jezyk' => '',
		'sciezka' => '',
		'parametry' => array(),
		'subdomena' => '',
		'kategoria' => '',
		'akcja' => '',
	);


	/**
	 * Typy regul dla serwisu
	 *
	 * @var array
	 */
	private $regulyAlgorytmy = array(
		'porownanie' => 'Generic\\Biblioteka\\Router\\Regula\\Porownanie',
		'wyrazenie' => 'Generic\\Biblioteka\\Router\\Regula\\WyrazenieRegularne',
		'kategoria' => 'Generic\\Biblioteka\\Router\\Regula\\KategoriaOgloszen',
		'lista' => 'Generic\\Biblioteka\\Router\\Regula\\Lista',
		'oferta' => 'Generic\\Biblioteka\\Router\\Regula\\Oferta',
		'strona' => 'Generic\\Biblioteka\\Router\\Regula\\StronaDodatkowa',
		'branza' => 'Generic\\Biblioteka\\Router\\Regula\\Branza',

		'wizytowka_porownanie' => 'Generic\\Biblioteka\\Router\\Regula\\Porownanie',
		'wizytowka_wyrazenie' => 'Generic\\Biblioteka\\Router\\Regula\\WyrazenieRegularne',
		'wizytowka_kategoria' => 'Generic\\Biblioteka\\Router\\Regula\\KategoriaOgloszen',
		'wizytowka_lista' => 'Generic\\Biblioteka\\Router\\Regula\\Lista',
		'wizytowka_oferta' => 'Generic\\Biblioteka\\Router\\Regula\\Oferta',
		'wizytowka_strona' => 'Generic\\Biblioteka\\Router\\Regula\\StronaDodatkowa',
	);


	/**
	 * Typy regul dla wizytowki
	 *
	 * @var array
	 */
	private $regulyWizytowka = array(
		'wizytowka_porownanie',
		'wizytowka_wyrazenie',
		'wizytowka_kategoria',
		'wizytowka_lista',
		'wizytowka_oferta',
		'wizytowka_strona',
	);



	/**
	 * Zwraca instancje Router-a Http
	 *
	 * @return Router_Http
	 */
	static public function inst()
	{
		if (self::$_instancja === false)
		{
			self::$_instancja = new Router\Http();
		}
		return self::$_instancja;
	}



	public function __construct()
	{
		$this->domena = $_SERVER['SERVER_NAME'];
		$this->url = (isset($_SERVER['ST_URL'])) ? $_SERVER['ST_URL'] : $_SERVER['REQUEST_URI'];
		$this->parametryZadania = array_replace($this->parametryZadania, Router::analizujUrl());

		$domena = trim(str_replace('www.', '', strtolower($this->domena)));
		$this->parametryZadania['subdomena'] = (DOMENA != $domena) ? str_replace('.'.DOMENA, '', $domena) : '';
	}



	/**
	 * Ustawia wewnetrzna tablice regul
	 *
	 * @param array $reguly
	 */
	public function ustawReguly(Array $reguly)
	{
		foreach ($reguly as $regula)
		{
			if ($regula instanceof RegulaRoutingu\Obiekt)
			{
				$kod = $regula->idKategorii.'_'.$regula->kodModulu.'_'.$regula->nazwaAkcji;
				$this->reguly[$kod] = $regula;
			}
			else
			{
				trigger_error('Do routera przekazano obiekt nie bedacy regula routingu', E_USER_NOTICE);
			}
		}
	}



	public function pobierzUrl()
	{
		return $this->url;
	}



	/**
	 * Jezeli parametr istnieje w tablicy zwraca jego wartosc inaczej zwraca null
	 *
	 * @param string $nazwa
	 * @return string|array|NULL
	 */
	public function pobierzParametr($nazwa)
	{
		if (array_key_exists($nazwa, $this->parametryZadania))
		{
			return $this->parametryZadania[$nazwa];
		}
		else
		{
			return null;
		}
	}



	/**
	 * Ustawia dane w tablicy $_REQUEST
	 */
	public function uzupelnijTabliceRequest()
	{
		if (count($this->parametryZadania['parametry']) > 0)
		{
			foreach ($this->parametryZadania['parametry'] as $numer => $wartosc)
			{
				$_REQUEST['url_parametr_'.$numer] = $wartosc;
			}
		}

		if ($this->parametryZadania['subdomena'] != '')
			$_REQUEST['iqcms_subdomena'] = $this->parametryZadania['subdomena'];
	}



	/**
	 * Ustawia lub zwraca obiekt filtru parametrow url
	 * @param Router_FiltrParametry $filtrParametrow Jezeli podany ustawia obiekt filtru
	 * @return Router_FiltrParametry|null
	 */
	public function filtr(Router\FiltrParametry $filtrParametrow = null)
	{
		if ($filtrParametrow instanceof Router\FiltrParametry)
		{
			$this->filtrParametrow = $filtrParametrow;
		}
		return $this->filtrParametrow;
	}



	/**
	 * Analizuje zadanie na podstawie regul i zwraca true jezeli znaleziono kategorie
	 *
	 * @return boolean
	 */
	public function analizujZadanie()
	{
		$wizytowka = (bool)($this->parametryZadania['subdomena'] != '');

		$znaleziono = false;

		foreach ($this->reguly as $regula)
		{
			if (($wizytowka && ! in_array($regula->typReguly, $this->regulyWizytowka))
				|| ( ! $wizytowka && in_array($regula->typReguly, $this->regulyWizytowka)))
			{
				continue;
			}

			$klasaAlgorytmu = $this->regulyAlgorytmy[$regula->typReguly];
			$mechanizmSprawdzajacy = new $klasaAlgorytmu($regula, $this->filtrParametrow);
			//$mechanizmSprawdzajacy = new Router_Regula($regula, $this->filtrParametrow); // do testow
			$znaleziono = $mechanizmSprawdzajacy->sprawdzUrl($this->url);

			if ($znaleziono)
			{
				$this->parametryZadania = array_merge($this->parametryZadania, $mechanizmSprawdzajacy->pobierzParametry());
				break;
			}
		}

		if ( ! $znaleziono)
		{
			// Jezeli nie znaleziono w regulach stosujemy stary mechanizm sprawdzajacy cms-a
			$znaleziono = $this->sprawdzUrlPrzezAnalize();
		}

		return $znaleziono;
	}



	/**
	 * Analizuje url wedlug starych zasad
	 * Jezeli znajdzie kategorie ustawia wewnetrzna tablice i zwraca true
	 *
	 * @return boolean
	 */
	protected function sprawdzUrlPrzezAnalize()
	{
		$kategorieMapper = Cms::inst()->dane()->Kategoria();
		$kategoria = null;

		if ($this->parametryZadania['subdomena'] != '')
		{
			// jeżeli wykryta subdomena ustawiamy kategorie na modul WizytowkaPodglad
			$temp = $kategorieMapper->pobierzDlaModulu('WizytowkaPodglad');
			if (isset($temp[0]) && $temp[0] instanceof Kategoria\Obiekt) $kategoria = $temp[0];
		}
		else
		{
			// jezeli normalna strona to pobieramy po sciezce wygenerowanej przez Router::analizujUrl()
			$kategoria = $kategorieMapper->pobierzPoLinku($this->parametryZadania['sciezka']);
			$kategoria = $this->sprawdzLinkWewnetrzny($kategoria);
		}

		if ($kategoria instanceof Kategoria\Obiekt)
		{
			$this->parametryZadania['kategoria'] = $kategoria;
			$this->parametryZadania['akcja'] = 'index';
			return true;
		}
		return false;
	}



	/**
	 * Sprawdza czy kategoria jest linkiem wewnetrznym a jeżeli tak zwraca kategorie docelowa
	 *
	 * @param mixed $kategoria
	 * @return Ambigous <Kategoria, multitype:, boolean, unknown>|Kategoria
	 */
	public function sprawdzLinkWewnetrzny($kategoria)
	{
		if ($kategoria instanceof Kategoria\Obiekt && $kategoria->typ == 'link_wewnetrzny')
		{
			return Cms::inst()->dane()->Kategoria()->pobierzPoId($kategoria->idKategorii);
		}
		else
		{
			return $kategoria;
		}
	}



	public function obslugaPrzekierowan()
	{
		$this->obslugaPrzekierowanStatycznych();
	}



	protected function obslugaPrzekierowanStatycznych()
	{
		$adres = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		$adresPelny = Zadanie::protokol().'://'.$adres;

		$plikDanych = TEMP_KATALOG.'/przekierowania301.inc.php';
		if (is_file($plikDanych))
		{
			$przekierowania = include($plikDanych);
		}
		if ( ! isset($przekierowania) || ! is_array($przekierowania)
			|| ! isset($przekierowania['stale']) || ! isset($przekierowania['regexp']))
		{
			return;
		}

		// przekierowania przez porownanie wartosci
		if (isset($przekierowania['stale'][$adresPelny]))
		{
			Router::przekierujDo($przekierowania['stale'][$adresPelny], true);
		}
		elseif (isset($przekierowania['stale'][$adres]))
		{
			Router::przekierujDo($przekierowania['stale'][$adres], true);
		}

		// przekierowania przez sprawdzenie wyrażenia regularnego
		foreach ($przekierowania['regexp'] as $wyrazenie => $nowyAdres)
		{
			if (preg_match($wyrazenie, $adresPelny, $znalezione) || preg_match($wyrazenie, $adres, $znalezione))
			{
				if (count($znalezione) > 0)
				{
					foreach ($znalezione as $nr => $wartosc)
					{
						$nowyAdres = str_replace('$'.$nr, $wartosc, $nowyAdres);
					}
				}
				Router::przekierujDo($nowyAdres, true);
				break;
			}
		}
	}



	public function obslugaBlokad()
	{
		$cms = Cms::inst();

		$adres = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
		$adresPelny = Zadanie::protokol().'://'.$adres;

		$plikDanych = TEMP_KATALOG.'/blokady404.inc.php';
		if (is_file($plikDanych))
		{
			$blokady = include($plikDanych);
		}
		if ( ! isset($blokady) || ! is_array($blokady)
			|| ! isset($blokady['stale']) || ! isset($blokady['regexp']))
		{
			return;
		}

		// przekierowania przez porownanie wartosci
		if (isset($blokady['stale'][$adresPelny]) || isset($blokady['stale'][$adres]))
		{
			cms_blad_404($cms->lang['bledy']['blad_zadania'], $cms->lang['bledy']['nie_znaleziono_stony']);
		}

		// przekierowania przez sprawdzenie wyrażenia regularnego
		foreach ($blokady['regexp'] as $wyrazenie)
		{
			if (preg_match($wyrazenie, $adresPelny) || preg_match($wyrazenie, $adres))
			{
				cms_blad_404($cms->lang['bledy']['blad_zadania'], $cms->lang['bledy']['nie_znaleziono_stony']);
				break;
			}
		}
	}



	/**
	 * Tworzy url dla modulu/kategorii i podanej akcji
	 *
	 * @param Kategoria|string $kategoria Nazwa modulu do ktorego sie odwolujemy
	 * @param string $akcja Akcja modulu do ktorej sie odwolujemy
	 * @param array $parametry Dodatkowe parametry w adresie url
	 *
	 * @return bool|string
	 */
	public function url($kategoria, $akcja, Array $parametry = array())
	{
		if (is_string($kategoria))
		{
			$kategorie = Cms::inst()->dane()->Kategoria()->pobierzDlaModulu($kategoria);
			$kategoria = $kategorie[0];
		}
		if ( ! $kategoria instanceof Kategoria\Obiekt)
		{
			trigger_error(sprintf('Nie znaleziono kategorii %s', $kategoria), E_USER_WARNING);
			return;
		}
		$url = '';
		$parametrySzablonuUrl = array();

		$kod = $kategoria->id.'_'.$kategoria->kodModulu.'_'.$akcja;

		if (isset($this->reguly[$kod]))
		{
			$regula = $this->reguly[$kod];
			$klasaAlgorytmu = $this->regulyAlgorytmy[$regula->typReguly];
			$mechanizmSprawdzajacy = new $klasaAlgorytmu($regula, $this->filtrParametrow);
			//$mechanizmSprawdzajacy = new Router_Regula($regula, $this->filtrParametrow); // linia do testow
			$url = $mechanizmSprawdzajacy->tworzUrl($parametry);

			preg_match_all('/\{\{([\w_-]+)\}\}/', $url, $parametrySzablonuUrl);
			$parametrySzablonuUrl = ($parametrySzablonuUrl[1]) ?: array();
		}
		else
		{
			$url = '{{protokol}}{{domena}}{{sciezka}}{{parametry_url}}';
			$parametrySzablonuUrl = array('protokol','domena','sciezka','parametry_url');
		}
		$parametryPredefiniowane = array('protokol','domena','sciezka','parametry_url');

		// analizujemy parametry pod kątem zgodnosci z szablonem
		$niestandardoweParametrySzablonuUrl = array_diff($parametrySzablonuUrl, $parametryPredefiniowane);
		$brakujaceParametry = array_diff($niestandardoweParametrySzablonuUrl,
			array_intersect(array_keys($parametry), $niestandardoweParametrySzablonuUrl)
		);
		if (count($brakujaceParametry) > 0)
		{
			trigger_error(sprintf('Nie przekazano wymaganych parametrow url: %s', implode(',', $brakujaceParametry)), E_USER_WARNING);
			return;
		}

		$parametryUrl = $parametryHtml = $parametryGet = array();
		foreach ($parametry as $klucz => $wartosc)
		{
			if (is_numeric($klucz))
			{
				$parametryHtml[] = $wartosc;
			}
			elseif (in_array($klucz, $parametrySzablonuUrl))
			{
				$parametryUrl[$klucz] = $wartosc;
			}
			else
			{
				$parametryGet[$klucz] = $wartosc;
			}
		}

		if (strpos($url, '{{protokol}}') !== false)
		{
			if (isset($parametryUrl['protokol']))
			{
				$protokol = strtolower($parametryUrl['protokol']);
				unset($parametryUrl['protokol']);
			}
			else
			{
				$protokol = ($kategoria->wymagaHttps) ? 'https' : 'http';
			}
			$protokol = (substr($protokol, -3) == '://') ? $protokol : $protokol.'://';
			$url = str_replace('{{protokol}}', $protokol, $url);
		}
		$dodacWWW = false;
		if (strpos($url, '{{subdomena}}') !== false)
		{
			if (isset($parametryUrl['subdomena']) && $parametryUrl['subdomena'] != '')
			{
				$subdomena = strtolower($parametryUrl['subdomena']);
				$subdomena = (substr($subdomena, 0, 4) == 'www.') ? $subdomena : 'www.'.$subdomena.'.';
				$dodacWWW = false;
				unset($parametryUrl['subdomena']);
			}
			else
			{
				$subdomena = '';
			}
			$url = str_replace('{{subdomena}}', $subdomena, $url);
		}
		if (strpos($url,'{{domena}}') !== false)
		{
			$cms = Cms::inst();
			if (isset($parametryUrl['domena']))
			{
				$domena = $parametryUrl['domena'];
				unset($parametryUrl['domena']);
			}
			else
			{
				$domena = $cms->projekt->domena;
			}
			$domena = (substr($domena, 0, 4) != 'www.' && $dodacWWW) ? 'www.'.$domena : $domena;
			$url = str_replace('{{domena}}', $domena, $url);
		}
		if (strpos($url, '{{sciezka}}') !== false)
		{
			if (isset($parametryUrl['sciezka']))
			{
				$sciezka = $parametryUrl['sciezka'];
				unset($parametryUrl['sciezka']);
			}
			else
			{
				$sciezka = $kategoria->pelnyLink;
			}
			$sciezka = (substr($sciezka, 0, 1) == '/') ? $sciezka : '/'.$sciezka;
			$url = str_replace('{{sciezka}}', $sciezka, $url);
		}
		if (count($parametryUrl) > 0)
		{
			foreach ($parametryUrl as $klucz => $wartosc)
			{
				$url = str_replace('{{'.$klucz.'}}', $wartosc, $url);
			}
		}
		if (strpos($url, '{{parametry_url}}') !== false)
		{
			if (count($parametryHtml) == 1 && empty($parametryHtml[0])) $parametryHtml = array();
			$parametryHtml = (count($parametryHtml) > 0) ? implode(',', $parametryHtml).'.html' : '';
			$url = str_replace('{{parametry_url}}', $parametryHtml, $url);
		}
		if (count($parametryGet) > 0)
		{
			if ($this->filtrParametrow instanceof Router\FiltrParametry)
			{
				$temp = array();
				foreach ($parametryGet as $nazwa => $wartosc)
				{
					$nazwa = $this->filtrParametrow->tlumaczNazwe($nazwa);
					$temp[$nazwa] = str_replace(array('%7B', '%7D'), array('{', '}'), urlencode($wartosc));
				}
				$parametryGet = $temp;
			}
			$url .= '?';
			foreach ($parametryGet as $klucz => $wartosc) $url .= $klucz.'='.$wartosc.'&';
			$url = rtrim($url, '&');
		}

		return (string)$url;
	}

	public function pobierzParametry()
    {
        return $this->parametryZadania;
    }



	/**
	 * Sprawdza czy podany url ma kopie w:
	 * - kategoriach serwisu,
	 * - branzach,
	 * - kategoriach ogloszen
	 * Zwraca tablice ze znalezionymi obiektami
	 * @param string $url Url do sprawdzenia
	 * @return array
	 */
	public static function sprawdzDuplikacje($url)
	{
		$url = trim($url,'/');
		$dane = Cms::inst()->dane();
		$znalezione = array();
		$kategoria = $dane->Kategoria()->pobierzPoLinku('/'.$url.'/');
		if ($kategoria instanceof Kategoria\Obiekt) $znalezione[] = $kategoria;
		$kategoriaOgloszen = $dane->KategoriaOgloszen()->pobierzPoUrl($url);
		if ($kategoriaOgloszen instanceof KategoriaOgloszen\Obiekt) $znalezione[] = $kategoriaOgloszen;
		$branza = $dane->WizytowkaBranza()->pobierzPoUrl($url);
		if ($branza instanceof WizytowkaBranza\Obiekt) $znalezione[] = $branza;
		return $znalezione;
	}

}
