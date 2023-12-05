<?php
namespace Generic\Biblioteka\Usluga;
use Generic\Biblioteka\Mapper;
use Generic\Biblioteka\Usluga;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Router;
use Generic\Model\Uzytkownik;
use Generic\Model\RegulaRoutingu;
use Generic\Model\Kategoria;
use Generic\Biblioteka\Zadanie;
use Generic\Model\Projekt;
use Generic\Biblioteka\Cache;
use Generic\Biblioteka\Sterownik;
use Generic\Biblioteka\Szablon;
use Generic\Biblioteka\Plik;
use Generic\Model\Blok;
use Generic\Biblioteka\SterownikWyjatek;
use Generic\Model\UkladStrony;


/**
 * Usluga Http odpowiadajaca za pobranie polecenia z zadania, pobranie danych z bazy
 * i zbudowanie strony na podstawie wybranego widoku.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Http extends Usluga
{

	// Tutaj sprzwdzamy co keszować
	protected $rodzajTworzonegoCache = null;


	protected $trescCache = '';


	/**
	 * @var Cache_Serwisu
	 */
	protected $cacheHtml;


	/**
	 * @var Cache_Serwisu_PlikiPhp
	 */
	protected $cachePhp;


	/**
	 * @var Cache_Serwisu_PlikiTpl
	 */
	protected $cacheTpl;



	public function start()
	{
    	$this->plikiStatyczneBlad404();

		$cms = Cms::inst();
		$cms->ladujBazeDanych();
		$cms->rozpocznijSesje();
		$this->ustawSzablony();
		$this->ustawProjekt();

		/*
		 * To jest TYMCZASOWE logowanie - na czas testów przez centralę i handlowców
		 */
		if ($cms->config['blokady']['serwis_zabezpieczony_haslem'])
		{
			if ( ! isset($cms->sesja->tymczasowoZalogowany)
				|| $cms->sesja->tymczasowoZalogowany['chksum_przegladarki'] != sha1($_SERVER['HTTP_USER_AGENT']))
			{
				if (!zaloguj())
				{
					logowanie('Zaloguj się', 'Aby przjść dalej musisz się zalogować');
				}
				else
				{
					$cms->sesja->tymczasowoZalogowany = array(
								'chksum_przegladarki' => sha1($_SERVER['HTTP_USER_AGENT']),
					);
					Router::przekierujDo('http://'.DOMENA);
				}
			}
		}
		/*
		 * Dotąd to skasować jak już wywalamy tymczasowe logowanie
		 * !!!! DODATKOWOWO z lib.inc.php wywalić dwie funkcje: logowanie() i zaloguj()
		 */

		$router = Router\Http::inst();

		// w przyszlosci będzie można wywalić ustawianie tablicy request
		$router->uzupelnijTabliceRequest();

		$zmienionoJezyk = $this->ustawJezyk($router->pobierzParametr('jezyk'));

		$uzytkownik = $cms->profil();

		// jezeli zmieniono jezyk musimy odnowic uprawnienia dla wersji jezykowej
		if ($uzytkownik instanceof Uzytkownik\Obiekt && $zmienionoJezyk) $uzytkownik->odnowUprawnienia();


		// znamy juz ID_PROJEKTU i KOD_JEZYKA wiec mozemy uzupelnic konfiguracje
		$cms->konfiguracjaBaza();
		$cms->tlumaczeniaBaza();

		//Sprawdzenie czy jest uruchomiony tryb serwisowy
		if ($cms->config['blokady']['tryb_serwisowy'])
		{
			cms_blad($cms->lang['blokady']['tryb_serwisowy'], $cms->lang['blokady']['trwaja_prace_serwisowe'], 503, '/' . SZABLON_SYSTEM . '/cms_tryb_serwisowy.tpl');
		}

		if ($cms->config['blokady']['blokowanie_logowania']
			&& $uzytkownik instanceof Uzytkownik\Obiekt
			&& $uzytkownik->czyAdmin == 0)
		{
			unset($cms->sesja->uzytkownik);
			setcookie('zalogowany', '', time()-3600, '/', DOMENA);
			unset($_COOKIE['zalogowany']);
			Router::przekierujDo(Router::urlHttp('KontoUzytkownika'));
			exit(0);
		}

		$router->ustawReguly(RegulaRoutingu\Mapper::wywolaj()->pobierzWszystko());
		if ($cms->config['router']['wlacz_filtr_url'])
		{
			$router->filtr(new Router\FiltrParametry(
				$cms->config['router']['parametry_slownik'],
				$cms->config['router']['parametry_url']
			));
		}

		$router->analizujZadanie();
		//dump($router->pobierzParametry());

		if ($cms->config['router']['blokady'])
		{
			$router->obslugaBlokad();
		}

		if ($cms->config['router']['przekierowania'])
		{
			$router->obslugaPrzekierowan();
		}

        /* @var $kategoria Kategoria */
		$kategoria = $router->pobierzParametr('kategoria');
		$akcja = $router->pobierzParametr('a');
        if(! $kategoria instanceof Kategoria\Obiekt)
        {
            $mapper = new Kategoria\Mapper();
            $kategoria = $mapper->pobierzGlowna();
        }
        /*
         * $kategoriaId = $router->pobierzParametr('cat');
		if($kategoriaId > 0)
        {
            $mapper = new Kategoria\Mapper();
            $kategoria = $mapper->pobierzPoId($kategoriaId);
        }
		else{
            $mapper = new Kategoria\Mapper();
            $kategoria = $mapper->pobierzGlowna();
        }
        */

		if ( ! $kategoria instanceof Kategoria\Obiekt)
		{
			cms_blad_404($cms->lang['bledy']['blad_zadania'], $cms->lang['bledy']['nie_znaleziono_stony']);
		}

		$this->obslugaPrzekierowanDlaKategorii($kategoria, $uzytkownik);

		define('ID_KATEGORII', $kategoria->id);

		$this->odczytajCache($router);

		if ($this->trescCache != '')
		{
			$tresc_strony = $this->trescCache;
		}
		else
		{
			$tresc_strony = $this->generujTrescStrony($kategoria, $akcja);
		}

		// rozbijamy na pojedyncze wiersze, wykonujemy trim() na wierszach i usuwamy puste pola
		$naglowkiHttp = array_filter(array_map('trim', explode("\n", $kategoria->naglowekHttp)));
		if (count($naglowkiHttp) > 0 && ! headers_sent())
		{
			foreach ($naglowkiHttp as $naglowek)
			{
				header($naglowek);
			}
		}

		echo $tresc_strony;

		$this->tworzCache($tresc_strony, $router);
	}



	/**
	 * Wyświetla błąd 404 jezeli odwolano sie do nieistniejacego pliku
	 */
	protected function plikiStatyczneBlad404()
	{
		$url = strtolower(trim($_SERVER['REQUEST_URI']));

		if (strpos($url, '/_system/') !== false
			|| strpos($url, '/_szablon/') !== false
			|| strpos($url, '/_public/') !== false
			|| $url == '/favicon.ico'
			|| $url == '/robots.txt')
		{
			$plik = LOGI_KATALOG.'/'.date ("Y-m-d", $_SERVER['REQUEST_TIME']).'-img404.log';
			$tresc = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']).', '.Zadanie::wywolanyUrl().', '.Zadanie::adresIp().((isset($_SERVER['HTTP_REFERER'])) ? ', '.$_SERVER['HTTP_REFERER'] : '')."\n";
			file_put_contents($plik, $tresc, FILE_APPEND);
			cms_blad_404(Cms::inst()->lang['bledy']['blad_zadania'], Cms::inst()->lang['bledy']['nie_znaleziono_stony']);
		}
	}



	/**
	 * Pobiera projekt i ustawia stale dotyczace projektu
	 */
	protected function ustawProjekt()
	{
		$cms = Cms::inst();
		if ($cms->sesja->projektCache instanceof Projekt\Obiekt
			&& $cms->sesja->projektCache->kod == KOD_PROJEKTU
			&& ((defined('DOMENA') && $cms->sesja->projektCache->domena == DOMENA) || ! defined('DOMENA'))
			)
		{
			$cms->projekt = $cms->sesja->projektCache;
		}
		else
		{
			$cms->projekt = Cms::inst()->dane()->Projekt()->pobierzPoKodzie(KOD_PROJEKTU);
		}

		if ($cms->projekt instanceof Projekt\Obiekt)
		{
			//wywolanie w celu pobrania deklaracji jezykow
			$cms->projekt->jezyki;
			define('ID_PROJEKTU', $cms->projekt->id);
			if ( ! defined('DOMENA')) define('DOMENA', $cms->projekt->domena);
		}
		else
		{
			cms_blad($cms->lang['bledy']['blad_zadania'], $cms->lang['bledy']['nie_znaleziono_projektu'], 503);
		}
		if ( ! ($cms->sesja->projektCache instanceof Projekt\Obiekt && $cms->sesja->projektCache->kod == KOD_PROJEKTU))
		{
			$cms->sesja->projektCache = $cms->projekt;
		}
	}



	/**
	 * Definiuje stałe dotyczace jezyka i zwraca true jezeli jezyk zostal zmieniony przez uzytkownika
	 * @param string $kod_jezyka jezyk zmieniany
	 * @return boolean
	 */
	protected function ustawJezyk($kod_jezyka)
	{
		$cms = Cms::inst();
		if ( ! isset($cms->sesja->kod_jezyka)) $cms->sesja->kod_jezyka = '';

		// zmieniamy kod jezyka tylko jezeli inny niz ten z sesji
		if ($kod_jezyka != '' && in_array($kod_jezyka, $cms->projekt->jezykiKody)
			&& ($cms->sesja->kod_jezyka == '' || $cms->sesja->kod_jezyka != $kod_jezyka))
		{
			define('KOD_JEZYKA_ITERFEJSU', $kod_jezyka);
			define('KOD_JEZYKA', $kod_jezyka);
			$cms->sesja->kod_jezyka = $kod_jezyka;
			return true;
		}
		elseif ($cms->sesja->kod_jezyka != '')
		{
			define('KOD_JEZYKA_ITERFEJSU', $cms->sesja->kod_jezyka);
			define('KOD_JEZYKA', $cms->sesja->kod_jezyka);
		}
		else
		{
			define('KOD_JEZYKA_ITERFEJSU', $cms->projekt->domyslnyJezyk);
			define('KOD_JEZYKA', $cms->projekt->domyslnyJezyk);
		}
		return false;
	}



	/**
	 * Odczytywanie roznych rodzajow cache
	 * @param Router_Http $router
	 */
	protected function odczytajCache(Router\Http $router)
	{
		$cms = Cms::inst();
		$url = $_SERVER['REQUEST_URI'];

		/* @var $kategoria Kategoria */
		$kategoria = $router->pobierzParametr('kategoria');

        /*

        if(! $kategoria instanceof Kategoria\Obiekt)
        {

            $sciezka = $router->pobierzParametr('sciezka');

            if ($sciezka !== '')
            {
                $kategorieMapper = Cms::inst()->dane()->Kategoria();
                $kategoria = $kategorieMapper->pobierzPoLinku($sciezka);
                var_dump($kategoria);
            }
        }
        */

		$subdomena = $router->pobierzParametr('subdomena');

		if ($kategoria->kodModulu == 'WizytowkaPodglad'
			&& $cms->config['cache']['wizytowki']
			&& ! $cms->profil() instanceof Uzytkownik\Obiekt)
		{
			$this->cacheHtml = new Cache\Serwisu\Subdomena($subdomena);
			$this->cacheHtml->ustawCzasCache($kategoria->czasCache);
			$this->trescCache = $this->cacheHtml->odczytajCache($url);
			if ($this->trescCache == '') $this->rodzajTworzonegoCache = 'wizytowki';
		}
		elseif ($kategoria->kodModulu != 'WizytowkaPodglad'
				&& $kategoria->cache && $kategoria->modul->cache
				&& $cms->config['cache']['strony']
				&& ! $cms->profil() instanceof Uzytkownik\Obiekt)
		{
			$this->cacheHtml = new Cache\Serwisu\Podstrony();
			$this->cacheHtml->ustawCzasCache($kategoria->czasCache);
			$this->trescCache = $this->cacheHtml->odczytajCache($url);
			if ($this->trescCache == '') $this->rodzajTworzonegoCache = 'kategorie';
		}
		if ($cms->config['cache']['php'])
		{
			$this->cachePhp = new Cache\Serwisu\PlikiPhp($router);
			$this->cachePhp->odczytajCache($url);
		}
		if ($cms->config['cache']['tpl'])
		{
			$this->cacheTpl = new Cache\Serwisu\PlikiTpl($router);
			$this->cacheTpl->odczytajCache($url);
		}
	}



	/**
	 * Zapisywanie roznych rodzajow cache
	 * @param string $tresc_strony Tresc strony zapisywanej w cache
	 * @param Router_Http $router
	 */
	protected function tworzCache($tresc_strony, Router\Http $router)
	{
		$cms = Cms::inst();
		$url = $_SERVER['REQUEST_URI'];
		$kategoria = $router->pobierzParametr('kategoria');

		if ($cms->config['cache']['znacznik']['html_tresc'] != '')
		{
			$cfg = $cms->config['cache']['znacznik'];
			$tresc_strony .= strtr($cfg['html_tresc'], array(
				'{DATA_START}' => date($cfg['data_format']),
				'{DATA_STOP}' => ($kategoria->czasCache > 0) ? date($cfg['data_format'], time() + $kategoria->czasCache) : '',
			));
		}
		if ($this->rodzajTworzonegoCache != '' && ! $cms->profil() instanceof Uzytkownik\Obiekt && $this->trescCache == '')
		{
			if ($this->rodzajTworzonegoCache == 'wizytowki' && ! $cms->temp('blokada_cache_wizytowka'))
			{
				$this->cacheHtml->tworzCache($url, $tresc_strony);
			}
			elseif ($this->rodzajTworzonegoCache == 'kategorie' && ! $cms->temp('bolkada_cache_kategoria'))
			{
				$this->cacheHtml->tworzCache($url, $tresc_strony);
			}
		}
		if ($this->trescCache == '')
		{
			// cache dla plikow tworzymy tylko jezeli musielismy wygenerowac tresc strony
			// musi byc na samym koncu
			if ($cms->config['cache']['php'])
			{
				$this->cachePhp->tworzCache($url);
			}
			if ($cms->config['cache']['tpl'])
			{
				$this->cacheTpl->tworzCache($url);
			}
		}
	}



	/**
	 * Sprawdza kategorie i wykonuje odpowiednie przekierowania jezeli sa konieczne
	 *
	 * @param Kategoria $kategoria
	 * @param Uzytkownik $uzytkownik
	 */
	protected function obslugaPrzekierowanDlaKategorii(Kategoria\Obiekt $kategoria, Uzytkownik\Obiekt $uzytkownik = null)
	{
		if ($kategoria->typ == 'link_zewnetrzny')
		{
			Router::przekierujDo($kategoria->adresZewnetrzny);
			exit;
		}
		if ($kategoria->wymagaHttps && Zadanie::protokol() != 'https')
		{
			$url = Zadanie::wywolanyUrl();
			$url = str_replace('http://','https://',$url);
			Router::przekierujDo($url);
			exit;
		}
		elseif ( ! $kategoria->wymagaHttps && Zadanie::protokol() == 'https')
		{
			$url = Zadanie::wywolanyUrl();
			$url = str_replace('https://','http://',$url);
			Router::przekierujDo($url);
			exit;
		}
		if ($kategoria->dlaZalogowanych == 1 && $kategoria->kodModulu != 'KontoUzytkownika'
			&& ! ($uzytkownik instanceof Uzytkownik\Obiekt))
		{
			$urlLogowanie = Router::urlHttp('KontoUzytkownika');
			if ($urlLogowanie != '')
			{
				Cms::inst()->sesja->urlPoZalogowaniu = Zadanie::wywolanyUrl();
				Router::przekierujDo($urlLogowanie);
				exit;
			}
		}
	}



	/**
	 * Fukcja generująca tresc strony dla danej kategorii
	 * @param Kategoria $kategoria
	 * @param unknown_type $akcja
	 * @return string|Ambiguous
	 */
	protected function generujTrescStrony(Kategoria\Obiekt $kategoria, $akcja)
	{
		$cms = Cms::inst();

		try
		{
			$stronaGlobalne = array(
				'tytul_strony' => '',
				'opis_strony' => '',
				'tytul_kategorii' => '',
				'slowa_kluczowe' => '',
				'jezyk_strony' => KOD_JEZYKA,
				'stopka_skrypt' => '',
				'naglowek_html' => '',
				'google_analytics_tracker_wizytowka' => '',
				'rodzaj_strony_g' => '',
				'obraz_strony' => '',
				'url_strony' => '',
				'openGraphTags' => '',
			);

			$sterownik = new Sterownik('Http');

			// generowanie tresci glownej dla strony
			$sterownik->nastepnaAkcja(null, $kategoria, null, $akcja);
			$sterownik->wykonaj();
			$glownaTresc = trim(implode('', $sterownik->pobierzTresc(true)));
			$glowneGlobalne = $sterownik->pobierzGlobalne();

			//Ustawienie kontenera i ukladu strony dla wykonanej akcji
			$kontener = $sterownik->pobierzKontener();
			if (isset($kontener) && $kontener != '')
				$kategoria->kontener = $kontener;

			//Ustawienie klasy css dla wykonywanej akcji
			$klasa = $sterownik->pobierzKlase();
			if (isset($klasa) && $klasa != '')
				$kategoria->klasa = $klasa;

			// obsluga podgladu dla zarzadzania widokami olewamy zmiany widoku dokonane tutaj
			if (Zadanie::pobierz('podgladEdytowanegoUkladu')
				&& isset($cms->sesja->podglad_widokow)
				&& isset($cms->sesja->podglad_widokow[$kategoria->widok->id]))
			{
				$kategoria->widok->struktura = $cms->sesja->podglad_widokow[$kategoria->widok->id];
			}

			$idWidoku = $sterownik->pobierzIdWidoku();
			if ($idWidoku > 0)
				$kategoria->idWidoku = $idWidoku;

			$strukturaStrony = $this->generujStruktureStrony($kategoria);

			// globalne do szablonu
			foreach ($glowneGlobalne as $klucz => $wartosc)
			{
				if (isset($stronaGlobalne[$klucz])) $stronaGlobalne[$klucz] = $glowneGlobalne[$klucz];
			}

			$kontenery = new Szablon();
			$kontenery->ladujTresc(Plik::pobierzTrescPliku(SZABLON_KATALOG.'/'.SZABLON_KONTENER));
			$dostepneKontenery = $kontenery->struktura();

			$cacheBloki = new Cache\Serwisu\Bloki();

			$regionyTresc = array();
			foreach ($strukturaStrony as $kodRegionu => $operacje)
			{
				$regionyTresc[$kodRegionu] = '';
				// wykonujemy ciag akcji w modulach dla okreslonego regionu
				foreach ($operacje as $operacja)
				{
					$tresc = '';
					$zmienneGlobalne = array();
					$trescCache = '';

					if ($operacja['blok'] instanceof Blok\Obiekt)
					{
						$cacheBloki->ustawCzasCache($operacja['blok']->cacheCzas);
						if (isset($cms->config['cache']['bloki'] ) && $cms->config['cache']['bloki'] && $operacja['blok']->cache)
						{
							$trescCache = trim($cacheBloki->odczytajCache($operacja['blok']->id));

							if ($trescCache != '')
							{
								// tresc cache bloku zapisana razem z otaczajacym go kontenerem
								$regionyTresc[$kodRegionu] .= $trescCache;
								// nie ma potrzeby przetwarzac dalej
								continue;
							}
						}
						$sterownik->nastepnaAkcja($operacja['blok'], $operacja['kategoria'], $operacja['modul']);
						$sterownik->wykonaj();
						$tresc = trim(implode('', $sterownik->pobierzTresc(true)));
						$zmienneGlobalne = $sterownik->pobierzGlobalne();
					}
					else
					{
						// modul glowny wykonał sie wczesniej wiec ustawiamy gotowa tresc
						$tresc = $glownaTresc;
						$zmienneGlobalne = $glowneGlobalne;
						unset($glownaTresc);
						unset($glowneGlobalne);
					}

					if ($tresc != '')
					{
						//sprawdzanie czy wykonywany modul ma kontener i czy jest on dostepny w szablonie
						if (isset($operacja['kontener']) && in_array('/'.$operacja['kontener'].'/', $dostepneKontenery))
						{
							$trescKontenera = array();
							foreach ($zmienneGlobalne as $zmienna => $wartosc)
							{
								if (in_array('/'.$operacja['kontener'].'/'.$zmienna, $dostepneKontenery))
								{
									$trescKontenera[$zmienna] = $wartosc;
								}
							}
							$trescKontenera['tresc'] = $tresc;

							/**
							 * Ustawienie indywidualnej klasy css dla bloku
							 */
							if ($operacja['blok'] != '' && $operacja['blok']->klasa)
								$trescKontenera['klasa']['nazwa'] = $operacja['blok']->klasa;

							/**
							 * Ustawienie indywidualnej klasy css dla kontenera kategorii
							 */
							if ($operacja['blok'] == '' && $operacja['kategoria']->klasa)
								$trescKontenera['klasa']['nazwa'] = $operacja['kategoria']->klasa;

							/**
							 * Dodanie identyfiaktora bloku do tresci
							 */
							if ($operacja['blok'] instanceof Blok\Obiekt)
							{
								$trescKontenera['id'] = $operacja['blok']->id;
							}

							$tresc = $kontenery->parsujBlok($operacja['kontener'], $trescKontenera);
						}
					}
					//tresc cache bloku zostaje zapisana razem z otaczajacym go kontenerem
					if (isset($cms->config['cache']['bloki']) && $cms->config['cache']['bloki'] && $trescCache == '' &&
						$operacja['blok'] instanceof Blok\Obiekt && $operacja['blok']->cache)
					{
						$cacheBloki->tworzCache($operacja['blok']->id, $tresc);
					}
					$regionyTresc[$kodRegionu] .= $tresc;
				}
			}
		}
		catch (SterownikWyjatek $wyjatek)
		{
			cms_blad($cms->lang['bledy']['blad_aplikacji'], $cms->lang['bledy']['przerwane_przetwarzanie_strony'], 503);
			return '';
		}
		$tresc_strony = $this->parsujTrescStrony($kategoria, $regionyTresc, $stronaGlobalne);

		$tresc_strony = $this->parsujZmienneGlobalne($tresc_strony);

		return $tresc_strony;
	}



	/**
	 * Generuje strukture strony dla danej kategorii
	 *
	 * Struktura strony to tablica w postaci:
	 * array(
	 * 	   'numer_regionu' => array(				<- numer regionu
	 *         0 => array(							<- kolejna akcja do wywolania
	 *             'blok' => new Blok,				<- obiekt klasy Blok lub null (jezeli generujemy glowna tresc)
	 * 	           'kategoria' => new Kategoria,	<- obiekt klasy Kategoria lub null
	 *             'modul' => 'nazwaModulu'			<- opcjonalna nazwa modulu
	 * 	           'kontener' => 'kontener'			<- opcjonalnie kontener w jaki nalezy opakowac tresc
	 *         )
	 *         1 => array(
	 *             ...
	 *         )
	 *     )
	 * )
	 *
	 * @param Kategoria $kategoria
	 * @return array
	 */
	protected function generujStruktureStrony(Kategoria\Obiekt $kategoria)
	{
		$dostepneBloki = array();
		foreach (Cms::inst()->dane()->Blok()->pobierzWszystko() as $blok)
		{
			$dostepneBloki[$blok->id] = $blok;
		}

		$strukturaStrony = array();
		$ukladBlokow = $kategoria->widok->ukladBlokow;
		if (count($ukladBlokow) > 0)
		{
			foreach ($ukladBlokow as $nrRegionu => $idBlokow)
			{
				foreach ($idBlokow as $id)
				{
					if (isset($dostepneBloki[$id]))
					{
						$blok = $dostepneBloki[$id];
						$strukturaStrony[$nrRegionu][] = array(
							'blok' => $blok,
							'kategoria' => $kategoria,
							'modul' => null,
							'kontener' => $blok->kontener,
						);
					}
					else
					{
						$strukturaStrony[$nrRegionu][] = array(
							'blok' => null,
							'kategoria' => $kategoria,
							'modul' => null,
							'kontener' => $kategoria->kontener,
						);
					}
				}
			}
		}
		return $strukturaStrony;
	}



	/**
	 * Wstawia wygenerowane tresci do odpowiednich regionow i parsuje odpowiednie zmienne globalne
	 * @param Kategoria $kategoria
	 * @param array $regionyTresc
	 * @param array $stronaGlobalne
	 * @return string
	 */
	protected function parsujTrescStrony(Kategoria\Obiekt $kategoria, Array $regionyTresc, Array $stronaGlobalne)
	{
		/** var UkladStrony $strona */
		
		$strona = UkladStrony\Mapper::wywolaj()->pobierzPoKodzie($kategoria->widok->ukladStrony);

		if ($kategoria->tytulStrony != '' && $stronaGlobalne['tytul_strony'] == '')
		{
			$stronaGlobalne['tytul_strony'] = $kategoria->tytulStrony;
		}
		if ($kategoria->opis != '' && $stronaGlobalne['opis_strony'] == '')
		{
			$stronaGlobalne['opis_strony'] = $kategoria->opis;
		}
		if ($kategoria->slowaKluczowe != '' && $stronaGlobalne['slowa_kluczowe'] == '')
		{
			$stronaGlobalne['slowa_kluczowe'] = $kategoria->slowaKluczowe;
		}
		if ($kategoria->skrypt != '' && $stronaGlobalne['stopka_skrypt'] == '')
		{
			$stronaGlobalne['stopka_skrypt'] = $kategoria->skrypt;
		}
		if ($kategoria->naglowekHtml != '' && $stronaGlobalne['naglowek_html'] == '')
		{
			$stronaGlobalne['naglowek_html'] = $kategoria->naglowekHtml;
		}

		foreach ($stronaGlobalne as $zmienna => $wartosc)
		{
			$strona->dodajZmienna($zmienna, $wartosc);
		}
		foreach ($regionyTresc as $kodRegionu => $tresc )
		{
			$strona->dodajTrescRegionu($kodRegionu, $tresc);
		}

		if ($kategoria->typ == 'glowna')
		{
			foreach (Cms::inst()->dane()->Kategoria()->pobierzDlaRss() as $katRss)
			{
				$strona->dodajKanalRss(Router::urlRss($katRss), $katRss->tytul);
			}
		}
		elseif ($kategoria->rssWlaczony)
		{
			$strona->dodajKanalRss(Router::urlRss($kategoria), $kategoria->tytul);
		}
		return $strona->pobierzHtml();
	}



	/**
	 * Parsuje zmienne globalne w tresci strony i zamienia je na odpowiednie wartosci
	 * @param string $tresc_strony
	 * @return string
	 */
	protected function parsujZmienneGlobalne($tresc_strony)
	{
		$plikGlobalne = TEMP_KATALOG.'/zmienne_globalne.inc.php';

		if (is_file($plikGlobalne) && is_readable($plikGlobalne))
		{
			$globalne = array();
			$globalne = include($plikGlobalne);
			if (is_array($globalne) && count($globalne) > 0)
			{
				$tab_globalnych = array('DOMENA' => DOMENA);
				if (array_key_exists('uzytkownika',$globalne)) { $tab_globalnych = array_merge($tab_globalnych, $globalne['uzytkownika']); }
				if (array_key_exists('zarezerwowane',$globalne)) { $tab_globalnych = array_merge($tab_globalnych, $globalne['zarezerwowane']); }
				if (array_key_exists('systemowe',$globalne)) { $tab_globalnych = array_merge($tab_globalnych, $globalne['systemowe']); }
				if (count($tab_globalnych) > 0)
				{
					foreach($tab_globalnych as $tag => $wartosc)
					{
						$tresc_strony = str_replace('{$'.$tag.'}', $wartosc, $tresc_strony);
					}
					$tresc_strony = str_replace('{$DOMENA}', DOMENA, $tresc_strony);
				}
			}
		}
		return $tresc_strony;
	}

}
