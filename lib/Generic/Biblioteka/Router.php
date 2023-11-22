<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Zadanie;
use Generic\Model\Kategoria;
use Generic\Model\Blok;
use Generic\Model\DostepnyModul;

/*
 * Stala potrzebna do generowania adresow url przez router
 */
define('WWW_PREF', (isset($_SERVER['SERVER_NAME']) && (strtolower(substr($_SERVER['SERVER_NAME'], 0, 4)) == 'www.') ? 'www.' : ''));

/**
 * Obsluga tworzenia linkow i przekierowan.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Router
{

	/**
	 * Przekierowanie na zadany adres URL.
	 *
	 * @param int $sciezka Sciezka z adresu url.
	 * @param array $oznaczenia Tablica z tekstami oznaczeniami parametr w linku, domyslnie: "," i ".html"
	 *
	 * @return array Tablica z rozpoznanymi elementami linku.
	 */
	static function analizujUrl($sciezka = '', Array $oznaczenia = array())
	{
		$wynik = array(
			'usluga' => '',
			'jezyk' => '',
			'sciezka' => '',
			'parametry' => array(),
		);
		$sciezka = ($sciezka != '') ? $sciezka : strtolower(trim($_SERVER['ST_URL']));

		$oznaczenia = (count($oznaczenia) > 0) ? $oznaczenia : array(',', '.html');

		if ($sciezka != '')
		{
			$cms = Cms::inst();
			$sciezka = explode('/', $sciezka);
			//sprawdzanie uslugi
			if (count($sciezka) > 0 && array_key_exists($sciezka[0], $cms->pobierzUslugi()))
			{
				$wynik['usluga'] = $sciezka[0];
				array_shift($sciezka);
			}
			//sprawdzanie jezyka
			if (count($sciezka) > 0 && in_array($sciezka[0], array_keys($cms->lang['kraje'])))
			{
				$wynik['jezyk'] = $sciezka[0];
				array_shift($sciezka);
			}
			$ostatni = str_replace($oznaczenia, '|', array_pop($sciezka));

			if (strpos($ostatni, '|') === false)
			{
				$sciezka[] = $ostatni;
			}
			else
			{
				$wynik['parametry'] = explode('|', $ostatni);
				unset($wynik['parametry'][count($wynik['parametry'])-1]);
			}
			$sciezka = '/'.trim(implode('/', $sciezka),'/').'/';
			$sciezka = ($sciezka == '//') ? '' : $sciezka;
			$wynik['sciezka'] = $sciezka;
		}

		return $wynik;
	}

    static function analizujUrl1($sciezka = '', Array $oznaczenia = array())
    {
        $wynik = array(
            'usluga' => '',
            'jezyk' => '',
            'sciezka' => '',
            'parametry' => array(),
            'kategoria' => '',
            'akcja' => ''
        );
        $sciezka = ($sciezka != '') ? $sciezka : strtolower(trim($_SERVER['ST_URL']));
        $oznaczenia = (count($oznaczenia) > 0) ? $oznaczenia : array(',', '.html');

        if ($sciezka != '')
        {
            $cms = Cms::inst();
            $sciezka = explode('/', $sciezka);
            //sprawdzanie uslugi
            if (count($sciezka) > 0 && array_key_exists($sciezka[0], $cms->pobierzUslugi()))
            {
                $wynik['usluga'] = $sciezka[0];
                array_shift($sciezka);
            }
            else
            {
                $wynik['usluga'] = 'http';
            }

            //sprawdzanie jezyka
            if (count($sciezka) > 0 && in_array($sciezka[0], array_keys($cms->lang['kraje'])))
            {
                $wynik['jezyk'] = $sciezka[0];
                array_shift($sciezka);
            }
            $ostatni = str_replace($oznaczenia, '|', array_pop($sciezka));
            if (strpos($ostatni, '|') === false)
            {
                $sciezka[] = $ostatni;
            }
            else
            {
                $wynik['parametry'] = explode('|', $ostatni);
                unset($wynik['parametry'][count($wynik['parametry'])-1]);
            }
            $sciezka = '/'.trim(implode('/', $sciezka),'/').'/';
            $sciezka = ($sciezka == '//') ? '' : $sciezka;
            $wynik['sciezka'] = $sciezka;
        }

        return $wynik;
    }
	
	
	static function pobierzKluczUprawnieniaUrl($url)
	{
		$kluczUprawnienia = '';
		
		$usluga = '';
				
		//$sciezka = ($url != '') ? $url : strtolower(trim($_SERVER['ST_URL']));
		$url_parts = parse_url($url);
		
		$parametry = array();
		
		$sciezka = $url_parts['path'];
		parse_str($url_parts['query'], $parametry);
		
		if ($sciezka != '')
		{
			$cms = Cms::inst();
			$sciezka = explode('/', $sciezka);
			//sprawdzanie uslugi
			if (count($sciezka) > 0 && array_key_exists($sciezka[1], $cms->pobierzUslugi()))
			{
				$usluga = ucfirst($sciezka[1]);
				array_shift($sciezka);
			}
		}
		
		if ($usluga == '')
		{
			trigger_error('Nie rozpoznano usługi po URLu wejściowym. Zakładam że Admin', E_USER_WARNING);
		}
		
		if (! in_array($usluga, array('Admin', 'Blok')))
		{
			trigger_error('Nie przewidziano w metodzie pobierzKluczUprawnienUrl innej usługi niż Admin...DOPISAĆ!!!', E_USER_NOTICE);
		}
		
		$idKategorii = (isset($parametry['cat']) && intval($parametry['cat']) > 0) ? $parametry['cat'] : null;
		$nazwaModulu = (isset($parametry['m']) && strval($parametry['m']) != '') ? $parametry['m'] : null;
		
		
		if (! isset($parametry['a']) || $parametry['a'] == '')
			$akcja = 'index';
		else
			$akcja = $parametry['a'];
		
		$akcja = 'wykonaj'.ucfirst($akcja);
		
		if ($nazwaModulu !== null)
		{
			$kluczUprawnienia = $nazwaModulu.'_'.$akcja;
		}
		
		if ($idKategorii !== null && $kluczUprawnienia == '')
		{
			$kluczUprawnienia = $usluga.'_'.$idKategorii.'_'.$akcja;
		}
		else
		{
			trigger_error('Podany url jest nieprawidłowy - zawiera nazwę modułu oraz idkategorii jednocześnie. Zakładam że chodzi o moduł administracyjny', E_USER_WARNING);
		}
		
		return $kluczUprawnienia;
	}



	/**
	 * Tworzy url dla uslugi Http.
	 *
	 * @param Kategoria|integer|string $kategoria Obiekt kategorii, id kategorii lub kod modulu
	 * @param array $parametry Tablica z parametrami ktorych wartosci nalezy dodac na koncu linku.
	 * @param string $schematUrl Schemat według którego ma być konstruowany url.
	 *
	 * @return string
	 */
	static function urlHttp($kategoria, $parametry = array(), $schematUrl = null, $dodacWWW = DOMENA_Z_WWW)
	{
		if (is_numeric($kategoria))
		{
			$mapper = Cms::inst()->dane()->Kategoria();
			$kategoria = $mapper->pobierzPoId($kategoria);
		}
		elseif (is_string($kategoria))
		{
			$mapper = Cms::inst()->dane()->Kategoria();
			$kategorie = $mapper->pobierzDlaModulu($kategoria);
			$kategoria = $kategorie[0];
		}

		if ( ! $kategoria instanceof Kategoria\Obiekt)
		{
			return false;
		}

		$url = ($schematUrl == null) ? '{protokol}{domena}{sciezka}{parametry}' : strtolower($schematUrl);

		if (strpos($url, '{protokol}') !== false)
		{
			if (isset($parametry['protokol']))
			{
				$protokol = $parametry['protokol'];
				unset($parametry['protokol']);
			}
			else
			{
				$protokol = (Cms::inst()->config['router']['caly_serwis_https'] || $kategoria->wymagaHttps) ? 'https' : 'http';
			}
			$protokol = (strpos('://', $protokol) != false) ? $protokol : $protokol.'://';
			$url = str_replace('{protokol}', $protokol, $url);
		}

		if (strpos($url, '{subdomena}') !== false)
		{
			if (isset($parametry['subdomena']) && $parametry['subdomena'] != '')
			{
				$dodacWWW = false;
				$subdomena = 'www.'.$parametry['subdomena'].'.';
				unset($parametry['subdomena']);
			}
			else
			{
				$subdomena = '';
			}
			$url = str_replace('{subdomena}', $subdomena, $url);
		}
		if (strpos($url,'{domena}') !== false)
		{
			$cms = Cms::inst();
			if (isset($parametry['domena']))
			{
				$domena = $parametry['domena'];
				unset($parametry['domena']);
			}
			else
			{
				$domena = $cms->projekt->domena;
			}
			if ($dodacWWW) $domena = 'www.'.$domena;
			if (count($cms->projekt->jezykiKody) > 1) $domena .= '/'.KOD_JEZYKA;
			$url = str_replace('{domena}', $domena, $url);
		}
		if (strpos($url, '{sciezka}') !== false)
		{
			if (isset($parametry['sciezka']))
			{
				$sciezka = $parametry['sciezka'];
				unset($parametry['sciezka']);
			}
			else
			{
				$sciezka = $kategoria->pelnyLink;
			}
			$sciezka = (substr($sciezka, -1) == '/') ? substr($sciezka, 0, -1) : $sciezka;
			$url = str_replace('{sciezka}', $sciezka, $url);
		}
		if (strpos($url, '{parametry}') !== false)
		{
			if (count($parametry) == 1 && empty($parametry[0])) $parametry = array();
			$parametry = (count($parametry) > 0) ? '/'.implode(',', $parametry).'.html' : '';
			$url = str_replace('{parametry}', $parametry, $url);
		}
		return (string)$url;
	}



	/**
	 * Tworzy url dla uslugi Admin.
	 *
	 * @param mixed $cel instancja klas: Kategoria, Blok, DostepnyModul lub nazwa modulu.
	 * @param string $akcja Akcja ktora nalezy wykonac na celu.
	 * @param array $parametry Parametry dla linku.
	 *
	 * return string
	 */
	static function urlAdmin($cel, $akcja = '', Array $parametry = array())
	{
		$url = Zadanie::protokol().'://'.WWW_PREF.Cms::inst()->projekt->domena.'/'.Cms::inst()->pobierzKodUslugi('Admin').'/?';

		if ($cel instanceof Kategoria\Obiekt)
		{
			$url .= 'cat='.$cel->id;
		}
		else if ($cel instanceof Blok\Obiekt)
		{
			$url .= 'b='.$cel->id;
		}
		else if ($cel instanceof DostepnyModul\Obiekt)
		{
			$url .= 'm='.$cel->kod;
		}
		else
		{
			$url .= 'm='.$cel;
		}

		$url .= ($akcja != '') ? '&a='.$akcja : '';

		if (count($parametry) > 0)
		{
			foreach($parametry as $k => $v)
			{
				$url .= '&'.$k.'='.$v;
			}
		}
		
		return $url;
	}



	/**
	 * Tworzy url dla uslugi Rss.
	 *
	 * @param mixed $kategoria Obiekt kategorii lub id kategorii.
	 * @param array $parametry Tablica z parametrami ktorych wartosci nalezy dodac na koncu linku.
	 *
	 * @return string
	 */
	static function urlRss($kategoria, $parametry = array())
	{
		if (is_numeric($kategoria))
		{
			$mapper = Cms::inst()->dane()->Kategoria();
			$kategoria = $mapper->pobierzPoId($kategoria);
		}
		if ($kategoria instanceof Kategoria\Obiekt)
		{
			$cms = Cms::inst();

			$url = 'http://'.WWW_PREF.$cms->projekt->domena.'/'.$cms->pobierzKodUslugi('Rss').'/';
			$url .= (count($cms->projekt->jezykiKody) > 1) ? KOD_JEZYKA.'/' : '';
			$url .= trim($kategoria->pelnyLink, '/');
			$url .= (is_array($parametry) && count($parametry) > 0) ? '/rss'.implode(',', $parametry).'.xml' : '/rss.xml';

			return (string)$url;
		}
		return false;
	}



	/**
	 * Tworzy url dla uslugi Ajax.
	 *
	 * @param string $usluga Usluga w ktorej ma pracowac cel.
	 * @param mixed $cel instancja klas: Kategoria, Blok, DostepnyModul lub nazwa modulu.
	 * @param string $akcja Akcja ktora nalezy wykonac na celu.
	 * @param array $parametry Parametry dla linku.
	 * @param bool $domena Czy dodawać domene do adresu żądania
	 *
	 * return string
	 */
	static function urlAjax($usluga, $cel, $akcja = '', Array $parametry = array(), $domena = true)
	{
		$usluga = strtolower($usluga);
		
		if ($domena == true)
		{
			$url = Zadanie::protokol().'://';
			$url .= WWW_PREF.Cms::inst()->projekt->domena.'/ajax/?';
		}
		else
			$url = '/ajax/?';
		
		if (!array_key_exists($usluga, Cms::inst()->pobierzUslugi()))
		{
			trigger_error('Nieprawidlowa wartosc parametru usluga dla funkcji urlAjax');
		}
		else
		{
			$url .= 'usluga='.$usluga;
		}

		if ($cel instanceof Kategoria\Obiekt)
		{
			$url .= '&cat='.$cel->id;
		}
		else if ($cel instanceof Blok\Obiekt)
		{
			$url .= '&blok='.$cel->id;
		}
		else if ($cel instanceof DostepnyModul\Obiekt)
		{
			$url .= '&m='.$cel->kod;
		}
		else
		{
			$url .= '&m='.$cel;
		}

		$url .= ($akcja != '') ? '&a='.$akcja : '';

		if (count($parametry) > 0)
		{
			foreach($parametry as $k => $v)
			{
				$url .= '&'.$k.'='.$v;
			}
		}

		return $url;
	}



	/**
	 * Tworzy url dla uslugi Popup.
	 *
	 * @param string $usluga Usluga w ktorej ma pracowac cel.
	 * @param mixed $cel instancja klas: Kategoria, Blok, DostepnyModul lub nazwa modulu.
	 * @param string $akcja Akcja ktora nalezy wykonac na celu.
	 * @param array $parametry Parametry dla linku.
	 *
	 * return string
	 */
	static function urlPopup($usluga, $cel, $akcja = '', Array $parametry = array())
	{
		$url = Zadanie::protokol().'://';
		$url .= WWW_PREF.Cms::inst()->projekt->domena.'/popup/?';

		$usluga = strtolower($usluga);
		if (array_key_exists($usluga, Cms::inst()->pobierzUslugi()))
		{
			$url .= 'usluga='.$usluga;
		}
		else
		{
			trigger_error('Nieprawidlowa wartosc parametru usluga dla funkcji urlPopup');
		}

		if ($cel instanceof Kategoria\Obiekt)
		{
			$url .= '&cat='.$cel->id;
		}
		else if ($cel instanceof Blok\Obiekt)
		{
			$url .= '&blok='.$cel->id;
		}
		else if ($cel instanceof DostepnyModul\Obiekt)
		{
			$url .= '&m='.$cel->kod;
		}
		else
		{
			$url .= '&m='.$cel;
		}

		$url .= ($akcja != '') ? '&a='.$akcja : '';

		if (count($parametry) > 0)
		{
			foreach($parametry as $k => $v)
			{
				$url .= '&'.$k.'='.$v;
			}
		}

		return $url;
	}



	/**
	 * Tworzy dowolny url.
	 *
	 * @param string $adres podany adres.
	 * @param array $parametry Parametry dla linku.
	 *
	 * return string
	 */
	static function url($adres = '', Array $parametry = array())
	{
		$url = '';
		$url .= ($adres != '') ? $adres : WWW_PREF.Cms::inst()->projekt->domena.'/';
		if (count($parametry) > 0)
		{
			$params = array();
			foreach($parametry as $k => $v)
			{
				$params[] = $k.'='.$v;
			}
			$url .= '?'.implode('&',$params);
		}
		return $url;
	}



	/**
	 * Przekierowanie na zadany adres URL.
	 *
	 * @param string $url Url na ktory nalezy przekierowac.
	 * @param boolean $trwale Czy przekierowanie ma byc na stale.
	 * @param boolean $js Czy przekierowac przy pomocy java script
	 */
	static function przekierujDo($url , $trwale = false, $przekieruj_js = false)
	{
		if ( ! headers_sent() && $przekieruj_js == false) // jezeli naglowki nie zostaly wyslane robimy zwykly redirect
		{
			if ($trwale) header("HTTP/1.1 301 Moved Permanently");
			header("Location: ".$url);
		}
		else // jezeli naglowki zostaly juz wyslane ratujemy sie inaczej
		{
			echo '<script type="text/javascript">window.location.href="'.$url.'";</script>';
			echo '<noscript><meta http-equiv="refresh" content="0;url='.$url.'" /></noscript>';
		}
		exit;
	}

}


