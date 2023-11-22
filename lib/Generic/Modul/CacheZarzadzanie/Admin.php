<?php
namespace Generic\Modul\CacheZarzadzanie;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Katalog;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Cache;
use Generic\Model\DostepnyModul;
use Generic\Model\Blok;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Plik;


/**
 * Moduł administracyjny odpowiedzialny za zarządzanie różnymi rodzajami cache.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Admin extends Modul\System
{

	/**
	 * @var \Generic\Konfiguracja\Modul\CacheZarzadzanie\Admin
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\CacheZarzadzanie\Admin
	 */
	protected $j;


	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajCacheWizytowki',
		'wykonajCacheStrony',
		'wykonajCacheBloki',
		'wykonajCacheBaza',
		'wykonajEdytujCacheBloku',
		'wykonajPodglad',
		'wykonajUsun',
		'wykonajCzyscCacheWizytowki',
		'wykonajCzyscCacheStrony',
		'wykonajCzyscCacheBloki',
		'wykonajCzyscCacheBaza',
		'wykonajCzyscCachePhp',
		'wykonajCzyscCacheTpl',
	);



	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));

		$cms = Cms::inst();

		$katalogCacheWizytowki = new Katalog(CACHE_KATALOG.'/wizytowki', true);
		$katalogCacheStrony = new Katalog(CACHE_KATALOG.'/kategorie', true);
		$katalogCacheBloki = new Katalog(CACHE_KATALOG.'/bloki', true);
		$katalogCacheBaza = new Katalog(CACHE_KATALOG.'/baza', true);
		$katalogCachePhp = new Katalog(CACHE_KATALOG.'/php', true);
		$katalogCacheTpl = new Katalog(CACHE_KATALOG.'/tpl', true);

		$iloscWizytowki = -1;
		$iloscStrony = -1;
		// zakomentowane z powodu problemow z wydajnoscia
		$iloscWizytowki = count(glob($katalogCacheWizytowki."/*/*", GLOB_ONLYDIR & GLOB_NOSORT));
		$iloscStrony = count(glob($katalogCacheStrony."/*", GLOB_NOSORT));
		$iloscBloki = count(glob($katalogCacheBloki.'/*', GLOB_ONLYDIR & GLOB_NOSORT));

		$dane = array(
			'link_cache_wizytowki' => Router::urlAdmin('CacheZarzadzanie', 'cacheWizytowki'),
			'link_czysc_cache_wizytowki' => Router::urlAdmin('CacheZarzadzanie', 'czyscCacheWizytowki'),
			'cache_wizytowki_ilosc' => sprintf($this->j->t['index.etykieta_cache_wizytowki_ilosc'], $iloscWizytowki),
			'cache_wizytowki_wlaczony' => (bool)$cms->config['cache']['wizytowki'],

			'link_cache_strony' => Router::urlAdmin('CacheZarzadzanie', 'cacheStrony'),
			'link_czysc_cache_strony' => Router::urlAdmin('CacheZarzadzanie', 'czyscCacheStrony'),
			'cache_strony_ilosc' => sprintf($this->j->t['index.etykieta_cache_strony_ilosc'], $iloscStrony),
			'cache_strony_wlaczony' => (bool)$cms->config['cache']['strony'],

			'link_cache_bloki' => Router::urlAdmin('CacheZarzadzanie', 'cacheBloki'),
			'link_czysc_cache_bloki' => Router::urlAdmin('CacheZarzadzanie', 'czyscCacheBloki'),
			'cache_bloki_ilosc' => sprintf($this->j->t['index.etykieta_cache_bloki_ilosc'], $iloscBloki),
			'cache_bloki_wlaczony' => (bool)$cms->config['cache']['bloki'],

			'link_cache_baza' => Router::urlAdmin('CacheZarzadzanie', 'cacheBaza'),
			'link_czysc_cache_baza' => Router::urlAdmin('CacheZarzadzanie', 'czyscCacheBaza'),
			'cache_baza_wlaczony' => (bool)$cms->config['cache']['baza'],

			'link_czysc_cache_php' => Router::urlAdmin('CacheZarzadzanie', 'czyscCachePhp'),
			'cache_php_ilosc' => sprintf($this->j->t['index.etykieta_cache_php_ilosc'], count(glob($katalogCachePhp.'/*.php'))),
			'cache_php_wlaczony' => (bool)$cms->config['cache']['php'],

			'link_czysc_cache_tpl' => Router::urlAdmin('CacheZarzadzanie', 'czyscCacheTpl'),
			'cache_tpl_ilosc' => sprintf($this->j->t['index.etykieta_cache_tpl_ilosc'], count(glob($katalogCacheTpl.'/*.php'))),
			'cache_tpl_wlaczony' => (bool)$cms->config['cache']['tpl'],

		);
		$this->tresc .= $this->szablon->parsujBlok('index', $dane);
	}



	public function wykonajCacheWizytowki()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['cacheWizytowki.tytul_strony']));

		$grid = new TabelaDanych();
		$grid->dodajKolumne('wizytowka', '', 0, '', true);
		$grid->dodajKolumne('nazwa', $this->j->t['cacheWizytowki.etykieta_nazwa']);
		$grid->dodajKolumne('data_modyfikacji', $this->j->t['cacheWizytowki.etykieta_data_modyfikacji'], 150);

		$grid->dodajPrzyciski(
			Router::urlAdmin('CacheZarzadzanie', '{AKCJA}', array('{KLUCZ}' => '{WARTOSC}')),
			array('podglad','usun')
		);

		$wzorzecWyszukiwania = CACHE_KATALOG.'/wizytowki/*/*';

		$kryteria = $this->formularzWyszukiwania($grid);
		// wstępne filtrowanie nazwy
		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '') $wzorzecWyszukiwania = CACHE_KATALOG.'/wizytowki/*/*'.$kryteria['fraza'].'*';

		$katalogi = array();
		foreach (glob($wzorzecWyszukiwania, GLOB_NOSORT) as $katalog)
		{
			$nazwa = basename($katalog);
			$data_modyfikacji = date('Y-m-d H:i:s', filemtime($katalog));

			// gdyby wstępne filtrowanie nazwy nie dzialalo
			if (isset($kryteria['fraza']) && $kryteria['fraza'] != ''
				&& stripos($nazwa, $kryteria['fraza']) === false) continue;

			if (isset($kryteria['data_modyfikacji']) && $kryteria['data_modyfikacji'] != ''
				&& stripos($data_modyfikacji, $kryteria['data_modyfikacji']) === false) continue;

			$katalogi[] = array(
				'nazwa' => $nazwa,
				'data_modyfikacji' => $data_modyfikacji,
			);
		}

		$ilosc = count($katalogi);
		if ($ilosc > 0)
		{
			$naStronie = $this->pobierzParametr('naStronie', $this->k->k['cacheWizytowki.wierszy_na_stronie'], true, array('intval','abs'));
			$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
			$kolumna = $this->pobierzParametr('kolumna', $this->k->k['cacheWizytowki.domyslne_sortowanie'], true, array('strval'));
			$kierunek = $this->pobierzParametr('kierunek', 'asc', true, array('strval', 'strtolower'));

			$kolumna = (in_array($kolumna, array('nazwa', 'data_modyfikacji'))) ? $kolumna : $this->k->k['cacheWizytowki.domyslne_sortowanie'];
			$kierunek = (in_array($kierunek, array('asc', 'desc'))) ? $kierunek : 'asc';

			$pager = new Pager\Html($ilosc, $naStronie, $nrStrony);
			$grid->pager($pager->html(Router::urlAdmin('CacheZarzadzanie', 'cacheWizytowki', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

			$grid->ustawSortownie(array('nazwa', 'data_modyfikacji'), $kolumna, $kierunek,
				Router::urlAdmin('CacheZarzadzanie', 'cacheWizytowki', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
			);

			($kierunek == 'asc') ? masort($katalogi, $kolumna) : marsort($katalogi, $kolumna);

			foreach (array_slice($katalogi, $pager->pierwszyNaStronie() - 1, $pager->naStronie()) as $katalog)
			{
				$katalog['wizytowka'] = $katalog['nazwa'];
				$grid->dodajWiersz($katalog);
			}
		}
		$this->tresc .= $grid->html();
	}



	public function wykonajCacheStrony()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['cacheStrony.tytul_strony']));

		$grid = new TabelaDanych();
		$grid->dodajKolumne('strona', '', 0, '', true);
		$grid->dodajKolumne('nazwa', $this->j->t['cacheStrony.etykieta_nazwa']);
		$grid->dodajKolumne('data_modyfikacji', $this->j->t['cacheStrony.etykieta_data_modyfikacji'], 150);

		$grid->dodajPrzyciski(
			Router::urlAdmin('CacheZarzadzanie', '{AKCJA}', array('{KLUCZ}' => '{WARTOSC}')),
			array('usun')
		);


		$kryteria = $this->formularzWyszukiwania($grid);

		$cache = new Cache\Serwisu\Podstrony();

		$wpisy = $cache->pobierzListe();

		foreach ($wpisy as $nr => $wpis)
		{
			// gdyby wstępne filtrowanie nazwy nie dzialalo
			if (isset($kryteria['fraza']) && $kryteria['fraza'] != ''
				&& stripos($wpis['nazwa'], $kryteria['fraza']) === false) unset($wpisy[$nr]);

			if (isset($kryteria['data_modyfikacji']) && $kryteria['data_modyfikacji'] != ''
				&& stripos($wpis['data_modyfikacji'], $kryteria['data_modyfikacji']) === false) unset($wpisy[$nr]);
		}

		$ilosc = count($wpisy);
		if ($ilosc > 0)
		{
			$naStronie = $this->pobierzParametr('naStronie', $this->k->k['cacheStrony.wierszy_na_stronie'], true, array('intval','abs'));
			$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
			$kolumna = $this->pobierzParametr('kolumna', $this->k->k['cacheStrony.domyslne_sortowanie'], true, array('strval'));
			$kierunek = $this->pobierzParametr('kierunek', 'asc', true, array('strval', 'strtolower'));

			$kolumna = (in_array($kolumna, array('nazwa', 'data_modyfikacji'))) ? $kolumna : $this->k->k['cacheWizytowki.domyslne_sortowanie'];
			$kierunek = (in_array($kierunek, array('asc', 'desc'))) ? $kierunek : 'asc';

			$pager = new Pager\Html($ilosc, $naStronie, $nrStrony);
			$grid->pager($pager->html(Router::urlAdmin('CacheZarzadzanie', 'cacheStrony', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

			$grid->ustawSortownie(array('nazwa', 'data_modyfikacji'), $kolumna, $kierunek,
				Router::urlAdmin('CacheZarzadzanie', 'cacheStrony', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
			);

			($kierunek == 'asc') ? masort($wpisy, $kolumna) : marsort($wpisy, $kolumna);

			foreach (array_slice($wpisy, $pager->pierwszyNaStronie() - 1, $pager->naStronie()) as $wpis)
			{
				$wpis['strona'] = $wpis['nazwa'];
				$grid->dodajWiersz($wpis);
			}
		}
		$this->tresc .= $grid->html();
	}



	public function wykonajCacheBloki()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['cacheBloki.tytul_strony']));

		$grid = new TabelaDanych();
		$grid->dodajKolumne('id', '', 0, '', true);
		$grid->dodajKolumne('nazwa', $this->j->t['cacheBloki.etykieta_nazwa']);
		$grid->dodajKolumne('kod_modulu', $this->j->t['cacheBloki.etykieta_kod_modulu'], 200);
		$grid->dodajKolumne('cache', $this->j->t['cacheBloki.etykieta_cache'], 50);
		$grid->dodajKolumne('cache_czas', $this->j->t['cacheBloki.etykieta_cache_czas'], 100);
		$grid->dodajKolumne('data_modyfikacji', $this->j->t['cacheBloki.etykieta_data_modyfikacji'], 150);

		$grid->dodajPrzyciski(
			Router::urlAdmin('CacheZarzadzanie', '{AKCJA}', array('{KLUCZ}' => '{WARTOSC}')),
			array(
				array(
					'akcja' => Router::urlAdmin('CacheZarzadzanie', 'edytujCacheBloku', array('{KLUCZ}' => '{WARTOSC}')),
					'ikona' => 'icon-pencil',
					'etykieta' => $this->j->t['cacheBloki.etykieta_edytuj'],
				),
				array(
					'akcja' => Router::urlAdmin('CacheZarzadzanie', 'usun', array('blokCache' => '{WARTOSC}', '{KLUCZ}' => '{WARTOSC}')),
					'ikona' => 'icon-remove',
					'etykieta' => $this->j->t['cacheBloki.etykieta_usun'],
					'klucz' => 'usun',
					'onclick' => 'return confirm(\''.$this->j->t['cacheBloki.etykieta_usun_pytanie'].'\')',
				),
			)
		);

		$kryteria = $this->formularzWyszukiwania($grid);

		$modulyCacheKody = DostepnyModul\Mapper::wywolaj()->zwracaTablice('kod')->szukaj(array('typ' => 'blok', 'cache' => true));
		$modulyCacheKody = listaZTablicy($modulyCacheKody,null,'kod');

		$ilosc = $this->dane()->Blok()->zwracaTablice()->iloscDlaModulu($modulyCacheKody);

		if ($ilosc > 0)
		{
			$naStronie = $this->pobierzParametr('naStronie', $this->k->k['cacheBloki.wierszy_na_stronie'], true, array('intval','abs'));
			$nrStrony = $this->pobierzParametr('nrStrony', 1, true, array('intval','abs'));
			$kolumna = $this->pobierzParametr('kolumna', $this->k->k['cacheBloki.domyslne_sortowanie'], true, array('strval'));
			$kierunek = $this->pobierzParametr('kierunek', 'asc', true, array('strval', 'strtolower'));

			$pager = new Pager\Html($ilosc, $naStronie, $nrStrony);
			$grid->pager($pager->html(Router::urlAdmin('CacheZarzadzanie', 'cacheBloki', array('nrStrony' => '{NR_STRONY}', 'naStronie' => '{NA_STRONIE}'))));

			$sorter = new Blok\Sorter($kolumna, $kierunek);
			$grid->ustawSortownie(array('nazwa', 'kod_modulu', 'cache', 'cache_czas'), $kolumna, $kierunek,
				Router::urlAdmin('CacheZarzadzanie', 'cacheBloki', array('kolumna' => '{KOLUMNA}', 'kierunek' => '{KIERUNEK}'))
			);

			$cache = new Cache\Serwisu\Bloki();
			//sprawdzamy czy mamy pliki cache i jakie maja daty modyfikacji
			$czasy = array();
			foreach ($cache->pobierzListe() as $plik)
			{
				$czasy[basename($plik['nazwa'])] = $plik['data_modyfikacji'];
			}

			foreach ($this->dane()->Blok()->zwracaTablice()->pobierzDlaModulu($modulyCacheKody, $pager, $sorter) as $blok)
			{
				$blok['cache'] = $this->j->t['cacheBloki.cache_wartosci'][$blok['cache']];
				$blok['cache_czas'] = (isset($this->j->t['cacheBloki.cache_czas_wartosci'][$blok['cache_czas']]))
					? $this->j->t['cacheBloki.cache_czas_wartosci'][$blok['cache_czas']] : $blok['cache_czas'];

				if (isset($czasy[$blok['id']]))
				{
					$blok['data_modyfikacji'] = $czasy[$blok['id']];
				}
				else
				{
					$blok['data_modyfikacji'] = '&nbsp;';
					$grid->usunPrzyciski(array('usun'));
				}

				if (isset($kryteria['fraza']) && $kryteria['fraza'] != ''
					&& stripos($blok['nazwa'], $kryteria['fraza']) === false) continue;

				if (isset($kryteria['data_modyfikacji']) && $kryteria['data_modyfikacji'] != ''
					&& stripos($blok['data_modyfikacji'], $kryteria['data_modyfikacji']) === false) continue;

				$grid->dodajWiersz($blok);
			}
		}
		$this->tresc .= $grid->html();
	}



	public function wykonajCacheBaza()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['cacheBaza.tytul_strony']));

		$grid = new TabelaDanych();
		$grid->dodajKolumne('baza', '', 0, '', true);
		$grid->dodajKolumne('nazwa', $this->j->t['cacheBaza.etykieta_nazwa']);
		$grid->dodajKolumne('data_modyfikacji', $this->j->t['cacheBaza.etykieta_data_modyfikacji'], 150);

		$grid->dodajPrzyciski(
			Router::urlAdmin('CacheZarzadzanie', '{AKCJA}', array('{KLUCZ}' => '{WARTOSC}')),
			array('usun')
		);

		foreach (glob(CACHE_KATALOG.'/baza/*') as $katalog)
		{
			$nazwa = basename($katalog, '.php');
			$data_modyfikacji = date('Y-m-d H:i:s', filemtime($katalog));

			$grid->dodajWiersz(array(
				'baza' => $nazwa,
				'nazwa' => $nazwa,
				'data_modyfikacji' => $data_modyfikacji,
			));
		}
		$this->tresc .= $grid->html();
	}



	public function wykonajEdytujCacheBloku()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['edytujCacheBloku.tytul_strony']));

		$blok = $this->dane()->Blok()->pobierzPoId(Zadanie::pobierz('id', 'intval', 'abs'));

		$plik = new Plik(CACHE_KATALOG.'/bloki/'.$blok->id.'.html');

		if ( ! $blok instanceof Blok\Obiekt)
		{
			$this->komunikat($this->j->t['edytujCacheBloku.blad_brak_bloku'], 'error', 'sesja');
			Router::przekierujDo(Router::urlAdmin('CacheZarzadzanie', 'cacheBloki'));
		}

		$obiektFormularza = new \Generic\Formularz\Cache\Blok();
		$obiektFormularza
			->ustawObiekt($blok)
			->ustawPlik($plik)
			->ustawTlumaczenia($this->pobierzBlokTlumaczen('edytujCacheBloku'))
			->ustawTlumaczenia($this->pobierzBlokTlumaczen('cacheBloki'));

		if ($obiektFormularza->wypelniony() && $obiektFormularza->danePoprawne())
		{
			$dane = $obiektFormularza->pobierzZmienioneWartosci();
			foreach ($dane as $klucz => $wartosc)
			{
				if ( ! in_array($klucz, array('cache', 'cacheCzas'))) continue;
				$blok->$klucz = $wartosc;
			}

			if ($blok->zapisz($this->dane()->Blok()))
			{
				if (isset($dane['cacheCzysc']) && $dane['cacheCzysc'] == true)
				{
					if ( ! $plik->istnieje() || $plik->usun())
					{
						$this->komunikat($this->j->t['edytujCacheBloku.info_usunieto_cache_bloku'], 'info', 'sesja');
					}
				}
				$this->komunikat($this->j->t['edytujCacheBloku.info_zapisano_dane_bloku'], 'info', 'sesja');
				Router::przekierujDo(Router::urlAdmin('CacheZarzadzanie', 'cacheBloki'));
			}
			else
			{
				$this->komunikat($this->j->t['edytujCacheBloku.blad_nie_mozna_zapisac_bloku'], 'error');
			}
		}
		$this->tresc .= $obiektFormularza->html();
	}



	public function wykonajPodglad()
	{
		$wizytowka = Zadanie::pobierz('wizytowka', 'strval', 'trim');

		$this->ustawGlobalne(array('tytul_strony' => sprintf($this->j->t['podglad.tytul_strony'], $wizytowka)));

		$grid = new TabelaDanych();
		$grid->dodajKolumne('wizytowka_plik', '', 0, '', true);
		$grid->dodajKolumne('nazwa', $this->j->t['podglad.etykieta_nazwa']);
		$grid->dodajKolumne('data_modyfikacji', $this->j->t['podglad.etykieta_data_modyfikacji'], 150);

		$grid->dodajPrzyciski(
			Router::urlAdmin('CacheZarzadzanie', '{AKCJA}', array('{KLUCZ}' => '{WARTOSC}')),
			array(
				array(
					'akcja' => Router::urlAdmin('CacheZarzadzanie', 'usun', array('{KLUCZ}' => '{WARTOSC}')),
					'ikona' => 'icon-remove',
					'etykieta' => $this->j->t['podglad.etykieta_usun'],
					'onclick' => 'return confirm(\''.$this->j->t['podglad.etykieta_usun_pytanie'].'\')',
				),
			)
		);

		$kryteria = $this->formularzWyszukiwania($grid);

		if ($wizytowka != '')
		{
			$cache = new Cache\Serwisu\Subdomena($wizytowka);

			$pliki = $cache->pobierzListe();

			foreach ($pliki as $nr => $plik)
			{
				// gdyby wstępne filtrowanie nazwy nie dzialalo
				if (isset($kryteria['fraza']) && $kryteria['fraza'] != ''
					&& stripos($plik['nazwa'], $kryteria['fraza']) === false) continue;

				if (isset($kryteria['data_modyfikacji']) && $kryteria['data_modyfikacji'] != ''
					&& stripos($plik['data_modyfikacji'], $kryteria['data_modyfikacji']) === false) continue;

				$plik['wizytowka_plik'] = $wizytowka.'@'.$plik['nazwa'];

				$grid->dodajWiersz($plik);
			}
		}

		$this->tresc .= $grid->html();
	}



	public function wykonajUsun()
	{
		$strona = Zadanie::pobierz('strona', 'strval', 'trim');
		$wizytowka = Zadanie::pobierz('wizytowka', 'strval', 'trim');
		$wizytowka_plik = Zadanie::pobierz('wizytowka_plik', 'strval', 'trim');
		$blok = Zadanie::pobierz('blokCache', 'intval', 'abs');
		$baza = Zadanie::pobierz('baza', 'strval', 'trim');

		$usunieto = false;

		if ($wizytowka != '')
		{
			$cache = new Cache\Serwisu\Subdomena($wizytowka);
			$usunieto = $cache->czyscCache();
			$urlPowrotny = Router::urlAdmin('CacheZarzadzanie', 'cacheWizytowki');
		}
		if ($wizytowka_plik != '')
		{
			$wizytowka_plik = explode('@', $wizytowka_plik);
			$wizytowka = $wizytowka_plik[0];
			$url = $wizytowka_plik[1];

			$cache = new Cache\Serwisu\Subdomena($wizytowka);
			$usunieto = $cache->usunCache($url);
			$urlPowrotny = Router::urlAdmin('CacheZarzadzanie', 'podglad', array('wizytowka' => $wizytowka));
		}
		elseif ($strona != '')
		{
			$cache = new Cache\Serwisu\Podstrony();
			$usunieto = $cache->usunCache($strona);
			$urlPowrotny = Router::urlAdmin('CacheZarzadzanie', 'cacheStrony');
		}
		elseif ($blok != '')
		{
			$cache = new Cache\Serwisu\Bloki();
			$usunieto = $cache->usunCache($blok);
			$urlPowrotny = Router::urlAdmin('CacheZarzadzanie', 'cacheBloki');
		}
		elseif ($baza != '')
		{
			$plik = new Plik(CACHE_KATALOG.'/baza/'.$baza.'.php');
			$usunieto = ($plik->istnieje() && $plik->usun());
			$urlPowrotny = Router::urlAdmin('CacheZarzadzanie', 'cacheBaza');
		}
		if ($usunieto)
		{
			$this->komunikat($this->j->t['usun.info_usunieto_pliki'], 'info', 'sesja');
		}
		else
		{
			$this->komunikat($this->j->t['usun.blad_nie_mozna_usunac_plikow'], 'error', 'sesja');
		}
		Router::przekierujDo($urlPowrotny);
	}



	public function wykonajCzyscCacheWizytowki()
	{
		if ($this->czyscKatalog(CACHE_KATALOG.'/wizytowki'))
		{
			Cms::inst()->dane()->CacheLinki()->czyscSubdomeny();
			$this->komunikat($this->j->t['czyscCacheWizytowki.info_wyczyszczono_cache'], 'info', 'sesja');
		}
		else
		{
			$this->komunikat($this->j->t['czyscCacheWizytowki.blad_wyczyszczono_cache'], 'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin('CacheZarzadzanie', 'index'));
	}



	public function wykonajCzyscCacheStrony()
	{
		$cacheStrony = new Cache\Serwisu\Podstrony();

		if ($cacheStrony->czyscCache())
		{
			$this->komunikat($this->j->t['czyscCacheStrony.info_wyczyszczono_cache'], 'info', 'sesja');
		}
		else
		{
			$this->komunikat($this->j->t['czyscCacheStrony.blad_wyczyszczono_cache'], 'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin('CacheZarzadzanie', 'index'));
	}



	public function wykonajCzyscCacheBloki()
	{
		$cacheBloki = new Cache\Serwisu\Bloki();

		if ($cacheBloki->czyscCache())
		{
			$this->komunikat($this->j->t['czyscCacheBloki.info_wyczyszczono_cache'], 'info', 'sesja');
		}
		else
		{
			$this->komunikat($this->j->t['czyscCacheBloki.blad_wyczyszczono_cache'], 'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin('CacheZarzadzanie', 'index'));
	}



	public function wykonajCzyscCacheBaza()
	{
		if ($this->czyscKatalog(CACHE_KATALOG.'/baza'))
		{
			$this->komunikat($this->j->t['czyscCacheBaza.info_wyczyszczono_cache'], 'info', 'sesja');
		}
		else
		{
			$this->komunikat($this->j->t['czyscCacheBaza.blad_wyczyszczono_cache'], 'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin('CacheZarzadzanie', 'index'));
	}



	public function wykonajCzyscCachePhp()
	{
		if ($this->czyscKatalog(CACHE_KATALOG.'/php'))
		{
			$this->komunikat($this->j->t['czyscCachePhp.info_wyczyszczono_cache'], 'info', 'sesja');
		}
		else
		{
			$this->komunikat($this->j->t['czyscCachePhp.blad_wyczyszczono_cache'], 'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin('CacheZarzadzanie', 'index'));
	}



	public function wykonajCzyscCacheTpl()
	{
		if ($this->czyscKatalog(CACHE_KATALOG.'/tpl'))
		{
			$this->komunikat($this->j->t['czyscCacheTpl.info_wyczyszczono_cache'], 'info', 'sesja');
		}
		else
		{
			$this->komunikat($this->j->t['czyscCacheTpl.blad_wyczyszczono_cache'], 'error', 'sesja');
		}
		Router::przekierujDo(Router::urlAdmin('CacheZarzadzanie', 'index'));
	}



	private function formularzWyszukiwania(TabelaDanych $grid)
	{
		$obiektFormularza = new \Generic\Formularz\Cache\Wyszukiwanie();

		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularzWyszukiwania'));

		$grid->naglowek($obiektFormularza->html($this->ladujSzablonZewnetrzny($this->k->k['szablon.formularz_wyszukiwarka']), true));

		return $obiektFormularza->pobierzWartosci();
	}



	private function czyscKatalog($sciezka)
	{
		$usunieto = false;

		$katalog = new Katalog($sciezka);
		if ($katalog->istnieje())
		{
			$usunieto = (bool)$katalog->usun();
		}
		else
		{
			$usunieto = true;
		}
		if ($usunieto)
		{
			$katalog = new Katalog($sciezka, true);
			$katalog->ustawDostep(0777);
		}

		return $usunieto;
	}
}
