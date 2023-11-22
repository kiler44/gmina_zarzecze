<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\Tlumaczenia;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\TabelaDanychWyjatek;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\Szablon;


/**
 * Klasa generuje widok tabeli danych (data grid)
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class TabelaDanych
{

	/**
	 * Zmienne opisujące kolumny tabeli danych
	 */

	private $kolumny = array();
	private $kolumnyDeklaracje = array();
	private $kolumnyKlucz = null;
	private $kolumnyNazwyZabronione = array(
		'_przyciski_usun_'
	);

	/**
	 * Zmienne opisujące przyciski w tabeli danych
	 */

	private $przyciski = array();
	private $przyciskiUrl;
	private $przyciskiDomyslne = array();
	private $przyciskiUsun = array();
	private $ustawKlase = '';
	private $atrybuty = '';

	/**
	 * Zmienne opisujące przyciski grupowe w tabeli danych
	 */

	private $przyciskiGrupowe = array();
	private $przyciskiGrupoweUrl;
	private $przyciskiGrupoweDomyslne = array();

	/**
	 * Zmienne przetrzymujące dane potrzebne do sortowania
	 */

	private $sortowanieKolumny = array();
	private $sortowanieBierzaca;
	private $sortowanieKierunek;
	private $sortowanieUrl;

	/**
	 * Zmienne przetrzymujące treść HTML sekcji tablic danych
	 */

	private $naglowekHtml = '';
	private $stopkaHtml = '';
	private $pagerHtml = '';
	private $pagerSelektorHtml = '';


	/**
	 * Przetrzymuje wiersze dodane do tabeli
	 *
	 * @var array
	 */
	private $wiersze = array();


	/**
	 * Przetrzymuje dodatkowe akcje do pol wierszy dodanych do tabeli
	 *
	 * @var array
	 */
	private $wierszAkcje = array();
	private $wierszAkcjePrzyciski = array();

	private $wierszKlasyPrzycisku = array();


	/**
	 * Przetrzymuje informacje czy usuniete przyciski zastepowac kropkami
	 *
	 * @var boolean
	 */
	private $uzupelniajKropkami = false;
	
	/**
	 * @var \Generic\Tlumaczenie\Pl\Biblioteka\MenedzerPlikow
	 */
	protected $j;
	

	/**
	 * Ustawia dane poczatkowe dla tabela danych.
	 */
	function __construct()
	{
		$nazwaKlasy = explode('\\', get_class($this));
		$namespaceJezyka = '\\Generic\\Tlumaczenie\\'.ucfirst(KOD_JEZYKA_ITERFEJSU).'\\Biblioteka\\'.end($nazwaKlasy);
		$this->j = new $namespaceJezyka;

		$this->przyciskiDomyslne = array(
			'dodaj' => array(
				'klucz' => 'dodaj',
				'akcja' => 'dodaj',
				'etykieta' => $this->j->t['etykieta_dodaj'],
				'ikona' => 'icon-plus-sign',
			),
			'dodajNowy' => array(
				'klucz' => 'dodaj',
				'akcja' => 'dodaj',
				'etykieta' => $this->j->t['etykieta_dodaj'],
				'class' => 'przyciskDodaj',
			),
			'edytuj' => array(
				'klucz' => 'edytuj',
				'akcja' => 'edytuj',
				'etykieta' => $this->j->t['etykieta_edytuj'],
				'ikona' => 'icon-pencil',
			),
			'edytujNowy' => array(
				'klucz' => 'edytuj',
				'akcja' => 'edytuj',
				'etykieta' => $this->j->t['etykieta_edytuj'],
				'class' => 'przyciskEdytuj',
			),
			'usun' => array(
				'klucz' => 'usun',
				'akcja' => 'usun',
				'etykieta' => $this->j->t['etykieta_usun'],
				'ikona' => 'icon-remove',
				'onclick' => 'return potwierdzenieUsun(\''.$this->j->t['etykieta_potwierdz_usun'].'\', $(this))',
			),
			'usunNowy' => array(
				'klucz' => 'usun',
				'akcja' => 'usun',
				'etykieta' => $this->j->t['etykieta_usun'],
				'class' => 'przyciskUsun',
				'onclick' => 'confirmLightbox(this, \'\', \''.$this->j->t['etykieta_potwierdz_usun'].'\'); return false;',
			),
			'podglad' => array(
				'klucz' => 'podglad',
				'akcja' => 'podglad',
				'etykieta' => $this->j->t['etykieta_podglad'],
				'ikona' => 'icon-search',
			),
			'podgladNowy' => array(
				'klucz' => 'podglad',
				'akcja' => 'podglad',
				'etykieta' => $this->j->t['etykieta_podglad'],
				'class' => 'przyciskPodglad',
			),
			'publikuj' => array(
				'klucz' => 'publikuj',
				'akcja' => 'publikuj',
				'etykieta' => $this->j->t['etykieta_publikuj'],
				'ikona' => 'publikuj.png',
			),
		);

		$this->przyciskiGrupoweDomyslne = array(
			'zaznacz' => array(
				'akcja' => 'javascript:void(0)',
				'etykieta' => $this->j->t['etykieta_zaznacz_wszystkie'],
				'ikona' => 'icon-check-empty',
				'id' => 'zaznacz_wszystkie',
			),
			'odwroc' => array(
				'akcja' => 'javascript:void(0)',
				'etykieta' => $this->j->t['etykieta_odwroc_zaznaczenie'],
				'ikona' => 'icon-retweet',
				'id' => 'odwroc_zaznaczenie',
			),
			'usun' => array(
				'akcja' => 'usun',
				'etykieta' => $this->j->t['etykieta_usun_zaznaczone'],
				'ikona' => 'icon-remove',
				'id' => 'usun_zaznaczone',
				//'href' => 'javascript::wyslijAkcjeGrupowa($(this));',
				'onclick' => 'confirmLightbox(this, \'\', \''.$this->j->t['etykieta_potwierdz_usun_zaznaczone'].'\', \'eWarning\', \'confirm\', true); return false;',
			),
			'eksport' => array(
				'akcja' => 'eksport',
				'etykieta' => $this->j->t['etykieta_eksportuj_zaznaczone'],
				'ikona' => 'icon-share',
			),
		);
	}


	/**
	 * Czy usuniete przyciski zastepowac kropkami
	 *
	 */
	public function uzupelniajKropkami($wartosc = true)
	{
		$this->uzupelniajKropkami = $wartosc;
	}

	public function dodajKolumny(array $kolumny, string $kolumnaKlucz)
    {
        foreach ($kolumny as $kolumna) {
            $this->dodajKolumne($kolumna, $this->j->t[$kolumna]);
        }
    }
	/**
	 * Dodaje kolumne do tabeli
	 *
	 * @param string $nazwa Nazwa kolumny.
	 * @param string $etykieta Widoczna nazwa kolumny.
	 * @param integer $szerokosc Szerokosc kolumny w pikselach.
	 * @param string $akcja Akcja w postaci domyslnej np. 'podglad' tekst który zostanie wstawiony do <a href="...
	 * @param boolean $kluczGlowny Okresla czy kolumna jest juz kluczem glownym
	 */
	public function dodajKolumne($nazwa, $etykieta, $szerokosc = 0, $akcja = '', $kluczGlowny = false)
	{
		if (in_array($nazwa, $this->kolumny))
		{
			throw new TabelaDanychWyjatek('Kolumna o nazwie '.$nazwa.' zostala juz zadeklarowana', E_USER_NOTICE);
		}
		if (in_array($nazwa, $this->kolumnyNazwyZabronione))
		{
			throw new TabelaDanychWyjatek('Nie mozna zdefiniowac kolumny o podanej nazwie.', E_USER_NOTICE);
		}
		else
		{
			$this->kolumny[] = $nazwa;
			$this->kolumnyDeklaracje[] = array(
				'nazwa' => $nazwa,
				'etykieta' => $etykieta,
				'szerokosc' => (int)$szerokosc,
				'akcja' => $akcja,
			);
		}
		if ($kluczGlowny)
		{
			if (is_null($this->kolumnyKlucz))
			{
				$this->kolumnyKlucz = $nazwa;
			}
			else
			{
				throw new TabelaDanychWyjatek('Klucz glowny zostal juz ustawiony dla kolumny o nazwie '.$this->kolumnyKlucz, E_USER_NOTICE);
			}
		}
	}



	/**
	 * Dodaje akcje w postaci przyciskow do tabeli danych.
	 *
	 * @param string $url Url do ktorego beda wstawiane akcje powinien zawierac: '{AKCJA}', '{KLUCZ}', '{WARTOSC}'
	 * @param array $przyciski Tablica definiujaca przyciski. Ma postac:
	 * array(
	 *     'edytuj',										<- domyslana akcja z dostepnych
	 *     ...,
	 *     array(											<- definiowanie niestandardowej akcji
	 * 	       'akcja' => 'strona.com/przenies/{KLUCZ}',	<- wymagane!!! tresc zostanie umieszcznona w <a href=""
	 *         'etykieta' => 'Zrob cos',					<- wymagane!!! tekstowa etykieta przycisku
	 *         'ikona' => 'zrob_cos.png',					<- jezeli okreslone to zostanie ustawione jako ikona do akcji
	 *         'onClick' => 'javascript: zrobCos();'		<- pozostale wpisy beda doklejkone do linka w postaci <a ... onClick="javascript: zrobCos();"
	 * 	   )
	 * )
	 */
	function dodajPrzyciski($url, Array $przyciski = array())
	{
		if (strpos($url, '{AKCJA}') === false || strpos($url, '{KLUCZ}') === false || strpos($url, '{WARTOSC}') === false)
		{
			throw new TabelaDanychWyjatek('Adres URL musi zawierac: {AKCJA}, {KLUCZ}, {WARTOSC}', E_USER_NOTICE);
		}
		else
		{
			$this->przyciskiUrl = $url;
		}
		if (count($przyciski) < 1)
		{
			throw new TabelaDanychWyjatek('Nie okreslono zadnych przyciskow', E_USER_NOTICE);
		}
		foreach ($przyciski as $przycisk)
		{
			if (is_string($przycisk))
			{
				if (array_key_exists($przycisk, $this->przyciskiDomyslne))
				{
					$p = $this->przyciskiDomyslne[$przycisk];
					$p['akcja'] = (array_key_exists($p['akcja'], $this->przyciskiDomyslne)) ? str_replace('{AKCJA}', $p['akcja'], $this->przyciskiUrl) : $p['akcja'];
					$this->przyciski[] = $p;
				}
				else
				{
					throw new TabelaDanychWyjatek('Nieprawidlowa nazwa akcji \''.$przycisk.'\'', E_USER_NOTICE);
				}
			}
			elseif (is_array($przycisk))
			{
				if (array_key_exists('akcja', $przycisk) && array_key_exists('etykieta', $przycisk))
				{
					$this->przyciski[] = $przycisk;
				}
				else
				{
					throw new TabelaDanychWyjatek('Brak akcji lub etykiety w niestandardowym przycisku', E_USER_NOTICE);
				}
			}
			else
			{
				throw new TabelaDanychWyjatek('Nieprawidlowa nazwa akcji \''.$przycisk.'\'', E_USER_NOTICE);
			}
		}
	}


	/**
	 * Metoda usuwa wybrane przyciski z kolejnego wiersza ktory zostanie dodany do grida
	 *
	 * @param array $przyciski
	 */
	public function usunPrzyciski(Array $przyciski)
	{
		$this->przyciskiUsun = array_merge($this->przyciskiUsun, $przyciski);
	}


	/**
	 * Metoda ustawia klasę CSS dla kolejnego wiersza ktory zostanie dodany do grida
	 *
	 * @param string $klasa
	 */
	public function ustawKlase($klasa)
	{
		$this->ustawKlase .= ' ' . $klasa;
	}

	/**
	 * Metoda ustawia atrybuty HTML dla kolejnego wiersza, ktory zostanie dodany do grida
	 *
	 * @param Array $atrybuty
	 */
	public function ustawAtrybuty($atrybuty)
	{
		if (is_array($atrybuty) && count($atrybuty) > 0)
		{
			$_atrybuty = '';
			foreach($atrybuty as $atrybut => $wartosc)
			{
				$_atrybuty .= $atrybut . '="'. $wartosc .'" ';
			}
			$this->atrybuty = $_atrybuty;
		}
	}



	/**
	 * Dodaje akcje grupowe w postaci przyciskow do tabeli danych.
	 *
	 * @param string $url Url do ktorego beda wstawiane akcje powinien zawierac: '{AKCJA}'
	 * @param array $przyciski Tablica definiujaca przyciski. Ma postac:
	 * array(
	 *     'usun',											<- domyslana akcja z dostepnych
	 *     ...,
	 *     array(											<- definiowanie niestandardowej akcji
	 * 	       'akcja' => 'strona.com/przenies_wszystkie',	<- wymagane!!! tresc zostanie umieszcznona w <a href=""
	 *         'etykieta' => 'Zrob cos',					<- wymagane!!! tekstowa etykieta przycisku
	 *         'ikona' => 'zrob_cos.png',					<- jezeli okreslone to zostanie ustawione jako ikona do akcji
	 *         'onClick' => 'javascript: zrobCos();'		<- pozostale wpisy beda doklejkone do linka w postaci <a ... onClick="javascript: zrobCos();"
	 * 	   )
	 * )
	 */
	function dodajPrzyciskiGrupowe($url, Array $przyciski = array())
	{
		if (strpos($url, '{AKCJA}') === false)
		{
			throw new TabelaDanychWyjatek('Adres URL musi zawierac: {AKCJA}', E_USER_NOTICE);
		}
		else
		{
			$this->przyciskiGrupoweUrl = $url;
		}
		if (count($przyciski) < 1)
		{
			throw new TabelaDanychWyjatek('Nie okreslono zadnych przyciskow', E_USER_NOTICE);
		}
		foreach ($przyciski as $przycisk)
		{
			if (is_string($przycisk))
			{
				if (array_key_exists($przycisk, $this->przyciskiGrupoweDomyslne))
				{
					$p = $this->przyciskiGrupoweDomyslne[$przycisk];
					$p['akcja'] = (array_key_exists($p['akcja'], $this->przyciskiGrupoweDomyslne)) ? str_replace('{AKCJA}', $p['akcja'], $this->przyciskiGrupoweUrl) : $p['akcja'];
					$this->przyciskiGrupowe[] = $p;
				}
				else
				{
					throw new TabelaDanychWyjatek('Nieprawidlowa nazwa akcji \''.$przycisk.'\'', E_USER_NOTICE);
				}
			}
			elseif (is_array($przycisk))
			{
				if (array_key_exists('akcja', $przycisk) && array_key_exists('etykieta', $przycisk))
				{
					$this->przyciskiGrupowe[] = $przycisk;
				}
				else
				{
					throw new TabelaDanychWyjatek('Brak akcji i etykiety w niestandardowym przycisku', E_USER_NOTICE);
				}
			}
			else
			{
				throw new TabelaDanychWyjatek('Nieprawidlowa nazwa akcji \''.$przycisk.'\'', E_USER_NOTICE);
			}
		}
	}


	/**
	 * Dodanie akcji do kolumny z aktualnie przypisywanego wiersza do tabeli
	 *
	 * @param type $kolumna
	 * @param type $url
	 */
	public function dodajAkcje($kolumna, $url)
	{
		$this->wierszAkcje[count($this->wiersze)][$kolumna] = $url;
	}


	/**
	 * Zmienia domyślną akcje dla wybranego przycisku z aktualnie przypisywanego wiersza do tabeli
	 *
	 * @param type $kolumna
	 * @param type $url
	 */
	public function zmienAkcjePrzycisk($przycisk, $url)
	{
		$this->wierszAkcjePrzyciski[count($this->wiersze)][$przycisk] = $url;
	}

    /**
     * Zmienia domyślną akcje dla wybranego przycisku z aktualnie przypisywanego wiersza do tabeli
     *
     * @param type $kolumna
     * @param type $url
     */
    public function zmienKlasePrzycisk($przycisk, $class)
    {
        $this->wierszKlasyPrzycisku[count($this->wiersze)][$przycisk] = $class;
    }



	/**
	 * Ustawia parametry sortowania
	 *
	 * @param array $kolumny Nazwy kolumn ktore wyswietlaja sortowanie.
	 * @param string $bierzaca Bierzaca kolumna sortowania.
	 * @param string $kierunek Kierunek sortowania do wyboru: 'asc' i 'desc'.
	 * @param string $url Url do sortowania.
	 */
	public function ustawSortownie(Array $kolumny, $bierzaca, $kierunek, $url)
	{
		if (count($kolumny) < 1)
		{
			throw new TabelaDanychWyjatek('Nie okreslono zadnych kolumn sortowania', E_USER_NOTICE);
		}
		foreach ($kolumny as $kolumnaSortowania)
		{
			if ( ! in_array($kolumnaSortowania, $this->kolumny))
			{
				throw new TabelaDanychWyjatek('Nie zdefiniowano kolumny o nazwie '.$kolumnaSortowania, E_USER_NOTICE);
			}
		}
		$this->sortowanieKolumny = $kolumny;

		if (in_array($bierzaca, $this->kolumny))
		{
			$this->sortowanieBierzaca = $bierzaca;
		}
		else
		{
			trigger_error('Nie zdefiniowano kolumny o nazwie '.$bierzaca.' wiec nie moze ona byc kluczem sortowania', E_USER_NOTICE);
		}

		$kierunek = strtolower($kierunek);
		$this->sortowanieKierunek = ($kierunek == 'desc') ? $kierunek : 'asc';

		if (strpos($url, '{KOLUMNA}') === false || strpos($url, '{KIERUNEK}') === false)
		{
			throw new TabelaDanychWyjatek('Adres URL musi zawierac: {KOLUMNA}, {KIERUNEK}', E_USER_NOTICE);
		}
		$this->sortowanieUrl = $url;
	}



	/**
	 * Dodaje wiersz z danymi do tablicy.
	 *
	 * @param array $dane Dane do wstawienia
	 */
	public function dodajWiersz(Array $dane)
	{
		foreach ($this->kolumny as $kolumna)
		{
			if (!array_key_exists($kolumna, $dane))
			{
				throw new TabelaDanychWyjatek('Brak wartosci dla kolumny '.$kolumna.' w przekazanych danych', E_USER_NOTICE);
			}
		}


		if ( ! empty($this->przyciskiUsun))
		{
			$dane['_przyciski_usun_'] = $this->przyciskiUsun;
			$this->przyciskiUsun = array();
		}
		if ($this->ustawKlase != '')
		{
			$dane['_ustaw_klase_'] = $this->ustawKlase;
			$this->ustawKlase = '';
		}
		if ($this->atrybuty != '')
		{
			$dane['_ustaw_atrybuty_'] = $this->atrybuty;
			$this->atrybuty = '';
		}
		$this->wiersze[] = $dane;
	}



	/**
	 * Ustawia tresc naglowka
	 *
	 * @param string $tresc Tresc naglowka
	 */
	function naglowek($tresc)
	{
		$this->naglowekHtml = $tresc;
	}



	/**
	 * Ustawia tresc stopki
	 *
	 * @param string $tresc Tresc stopki
	 */
	function stopka($tresc)
	{
		$this->stopkaHtml = $tresc;
	}



	/**
	 * Ustawia tresc pagera w stopce
	 *
	 * @param string $html Tresc html pager-a
	 */
	public function pager($html)
	{
		$this->pagerHtml = $html;
	}



	/**
	 * Ustawia dodatkową tresc pagera w stopce
	 *
	 * @param string $html Tresc html pager-a
	 */
	public function pagerSelektor($html)
	{
		$this->pagerSelektorHtml = $html;
	}



	/**
	 * Zwraca html z gotową tabelą
	 *
	 * @param string $plikSzablonu Plik szablonu kóry należy wczytać
	 */
	public function html($szablon = '', $szablonTresc = false)
	{
		$iloscKolumn = count($this->kolumny);
		if (empty($this->przyciski))
		{
			--$iloscKolumn;
		}

		$iloscWierszy = count($this->wiersze);
		if ($iloscKolumn < 1)
		{
			throw new TabelaDanychWyjatek('Nie zadeklarowano żadnych kolumn do wyswietlenia', E_USER_NOTICE);
		}

		if ( ! $szablonTresc)
		{
			$szablon = ($szablon != '') ? $szablon : CMS_KATALOG.'/' . SZABLON_SYSTEM . '/'.SZABLON_TABELA_DANYCH;
			$szablon = Plik::pobierzTrescPliku($szablon);
		}

		$tabela = new Szablon();
		$tabela->ladujTresc($szablon);
		$tabela->ustawGlobalne(
			array(
				'etykieta_zaznacz_wszystkie' => $this->j->t['etykieta_zaznacz_wszystkie'],
				'etykieta_odznacz_wszystkie' => $this->j->t['etykieta_odznacz_wszystkie'],
				'etykieta_usun_zaznaczone' => $this->j->t['etykieta_usun_zaznaczone'],
				'blad_zaznaczenie_puste' => $this->j->t['blad_zaznaczenie_puste'],
				'ilosc_kolumn' => $iloscKolumn, // uwzglednione kolumny akcji i zaznaczenia
				'pager_html' => $this->pagerHtml,
				'pager_selektor_html' => $this->pagerSelektorHtml,
			)
		);

		// naglowek tabeli
		if ($this->naglowekHtml != '')
		{
			$tabela->ustawBlok('naglowek', array('naglowek_html' => $this->naglowekHtml));
		}

		// wlaczenie obslugi akcji na wielu wierszach
		if (!empty($this->przyciskiGrupowe) && $this->kolumnyKlucz != '')
		{
			$tabela->ustawBlok('skrypt_zaznaczenie', array());
			$tabela->ustawBlok('naglowek_kolumna_zaznaczenie', array());
			$tabela->ustawBlok('stopka_kolumna_zaznaczenie', array('pager_html' => $this->pagerHtml));
		}
		elseif ($this->pagerHtml != '')
		{
			$tabela->ustawBlok('stopka_kolumna_zaznaczenie', array('pager_html' => $this->pagerHtml));
		}

		// generowanie kolumn naglowkowych dla tabeli
		foreach($this->kolumnyDeklaracje as $kolumna)
		{
			if ($kolumna['nazwa'] == $this->kolumnyKlucz)
			{
				continue;
			}
			$szerokosc = ($kolumna['szerokosc'] > 0) ? $kolumna['szerokosc'] : '';

			$klasa = $kolumna['nazwa'] .' ' . ((in_array($kolumna['nazwa'], $this->sortowanieKolumny) && $this->sortowanieBierzaca == $kolumna['nazwa']) ? 'sort '.$this->sortowanieKierunek : 'sort inactive');

			$tabela->ustawBlok('naglowek_kolumna_zwykla', array(
				'szerokosc' => $szerokosc,
				'klasa' => $klasa,
				'etykieta_kolumny' => $kolumna['etykieta']
			));

			if(in_array($kolumna['nazwa'], $this->sortowanieKolumny))
			{
				$kierunek = ($this->sortowanieKierunek == 'asc') ? 'desc': 'asc';
				$url = htmlspecialchars(str_replace(array('{KOLUMNA}', '{KIERUNEK}'), array($kolumna['nazwa'], $kierunek), $this->sortowanieUrl));

				$tabela->ustawBlok('/naglowek_kolumna_zwykla/sortowanie_start', array(
					'url' => $url,
					'klasa' => $klasa,
					'ikona' => $this->sortowanieBierzaca == $kolumna['nazwa'] ? ($this->sortowanieKierunek == 'asc' ? 'icon-sort-up' : 'icon-sort-down') : (in_array($kolumna['nazwa'], $this->sortowanieKolumny) ? 'icon-sort': ''),
					'etykieta_kolumny' => $kolumna['etykieta'],
					'etykieta_sortuj_po' => $this->j->t['etykieta_sortuj_po'].$kolumna['etykieta'],
				));
				$tabela->ustawBlok('/naglowek_kolumna_zwykla/sortowanie_stop', array());
			}
		}

		if (!empty($this->przyciski))
		{
			$tabela->ustawBlok('naglowek_kolumna_przyciski', array('szerokosc' => (count($this->przyciski) * 30 + 20)));
		}

		$licznik = 1;
		if ($iloscWierszy < 1)
		{
			$tabela->ustawBlok('wiersz_brak_danych', array(
				'etykieta_brak_wierszy' => $this->j->t['etykieta_brak_wierszy'],
				'ilosc_kolumn' => $iloscKolumn + (!empty($this->przyciskiGrupowe) ? 1 : 0),
			));
		}
		else
		{
			$atrybuty = '';
			// generowanie wierszy tabeli z trescia
			foreach($this->wiersze as $wiersz)
			{
				$klasa = ($licznik % 2) ? 'nieparzysty' : 'parzysty';
				$wartoscKlucza = $wiersz[$this->kolumnyKlucz];

				$tabela->ustawBlok('wiersz', array(
					'klasa' => $klasa . (isset($wiersz['_ustaw_klase_']) ? $wiersz['_ustaw_klase_'] : ''),
					'atrybuty' => (isset($wiersz['_ustaw_atrybuty_'])) ? $wiersz['_ustaw_atrybuty_'] : '',
					'wartosc_klucza' => $wartoscKlucza
				));

				foreach($this->kolumnyDeklaracje as $kolumna)
				{
					// wlaczenie obslugi akcji na wielu wierszach
					if (!empty($this->przyciskiGrupowe) && $kolumna['nazwa'] == $this->kolumnyKlucz)
					{
						$tabela->ustawBlok('wiersz/kolumna_zaznaczenie', array(
							'klasa' => $klasa,
							'nazwa_klucza' => $this->kolumnyKlucz,
							'wartosc_klucza' => $wartoscKlucza
						));
						continue;
					}
					elseif (empty($this->przyciskiGrupowe) && $kolumna['nazwa'] == $this->kolumnyKlucz)
					{
						continue;
					}

					if ($kolumna['akcja'] != '')
					{
						$kolumna['akcja'] = htmlspecialchars(str_replace(array('{KLUCZ}', '{WARTOSC}'), array($this->kolumnyKlucz, $wartoscKlucza), $kolumna['akcja']));

						$tabela->ustawBlok('wiersz/kolumna', array('klasa' => $klasa));
						$tabela->ustawBlok('wiersz/kolumna/akcja', array(
							'klasa' => $klasa,
							'url' => $kolumna['akcja'],
							'tresc_kolumny' => $wiersz[$kolumna['nazwa']]
						));
					}
					//Sprawdzenie czy do kolumny z aktualnego wiersza zostala przypisana jakas akcja
					elseif(isset($this->wierszAkcje[$licznik-1][$kolumna['nazwa']]))
					{
						$tabela->ustawBlok('wiersz/kolumna', array('klasa' => $klasa));
						$tabela->ustawBlok('wiersz/kolumna/akcja', array(
							'klasa' => $klasa,
							'url' => $this->wierszAkcje[$licznik-1][$kolumna['nazwa']],
							'tresc_kolumny' => $wiersz[$kolumna['nazwa']]
						));
					}
					else
					{
						$tabela->ustawBlok('wiersz/kolumna', array(
							'klasa' => $klasa,
							'tresc_kolumny' => $wiersz[$kolumna['nazwa']]
						));
					}
				}

				//renderowanie przyciskow
				if (!empty($this->przyciski))
				{
					$url = '';
					$przycisk = array();
					$tabela->ustawBlok('wiersz/kolumna_przyciski', array('klasa' => $klasa));
					foreach ($this->przyciski as $przycisk)
					{
						if( isset($przycisk['klucz'])
							&& (isset($wiersz['_przyciski_usun_']) && is_array($wiersz['_przyciski_usun_']))
							&& array_search($przycisk['klucz'], $wiersz['_przyciski_usun_']) !== false )
						{
							if ($this->uzupelniajKropkami)
								$tabela->ustawBlok('wiersz/kolumna_przyciski/przycisk_pusty');
							continue;
						}

						//Sprawdzenie czy mamy nadpisac domyslna akcje przycisku
						if(isset($przycisk['klucz']) && isset($this->wierszAkcjePrzyciski[$licznik-1][$przycisk['klucz']]))
							$url = $this->wierszAkcjePrzyciski[$licznik-1][$przycisk['klucz']];
						else
							$url = htmlspecialchars(str_replace(array('{KLUCZ}', '{WARTOSC}'), array($this->kolumnyKlucz, $wartoscKlucza), $przycisk['akcja']));
						$parametry = '';
						foreach ($przycisk as $klucz => $wartosc)
						{
							if (!in_array($klucz, array('akcja', 'etykieta', 'ikona', 'klasa_przycisku'))) $parametry .= $klucz.'="'.$wartosc.'"';
						}
						if (!isset($przycisk['klasa_przycisku'])) $przycisk['klasa_przycisku'] = '';

                        if(isset($przycisk['klucz']) && isset($this->wierszKlasyPrzycisku[$licznik-1][$przycisk['klucz']]))
                            $klasaPrzycisku = $przycisk['klasa_przycisku'].' '.$this->wierszKlasyPrzycisku[$licznik-1][$przycisk['klucz']];
                        else
                            $klasaPrzycisku = $przycisk['klasa_przycisku'];

						if (array_key_exists('ikona', $przycisk))
						{
							$tabela->ustawBlok('wiersz/kolumna_przyciski/przycisk', array(
								'url' => $url,
								'parametry' => $parametry,
								'etykieta' => $przycisk['etykieta'],
								'klasa_przycisku' => $klasaPrzycisku,
							));
							$tabela->ustawBlok('wiersz/kolumna_przyciski/przycisk/ikona', array(
								'etykieta' => $przycisk['etykieta'],
								'ikona' => $przycisk['ikona'],
							));
						}
						elseif (array_key_exists('class', $przycisk))
						{
							$tabela->ustawBlok('wiersz/kolumna_przyciski/przyciskNowy', array(
								'url' => $url,
								'etykieta' => $przycisk['etykieta'],
								'parametry' => $parametry,
								'klasa_przycisku' => $klasaPrzycisku,
							));
						}
						else
						{
							$tabela->ustawBlok('wiersz/kolumna_przyciski/przycisk', array(
								'url' => $url,
								'etykieta' => $przycisk['etykieta'],
								'parametry' => $parametry,
								'klasa_przycisku' => $klasaPrzycisku,
							));
						}
					}
				}
				$licznik++;
				$wiersz++;
			}
		}

		//renderowanie przyciskow grupowych
		if (!empty($this->przyciskiGrupowe))
		{
			$przycisk = array();
			foreach ($this->przyciskiGrupowe as $przycisk)
			{
				$parametry = '';
				foreach ($przycisk as $klucz => $wartosc)
				{
					if (!in_array($klucz, array('akcja', 'etykieta', 'ikona'))) $parametry .= $klucz.'="'.$wartosc.'"';
				}
				if (array_key_exists('ikona', $przycisk))
				{
					$tabela->ustawBlok('stopka_kolumna_zaznaczenie/przycisk', array(
						'url' => htmlspecialchars($przycisk['akcja']),
						'etykieta' => $przycisk['etykieta'],
						'parametry' => $parametry,
					));
					$tabela->ustawBlok('stopka_kolumna_zaznaczenie/przycisk/ikona', array(
						'ikona' => $przycisk['ikona'],
					));
				}
				else
				{
					$tabela->ustawBlok('stopka_kolumna_zaznaczenie/przycisk', array(
						'url' => htmlspecialchars($przycisk['akcja']),
						'etykieta' => $przycisk['etykieta'],
						'parametry' => $parametry,
					));
				}
			}
		}

		// stopka tabeli
		if ($this->stopkaHtml != '')
		{
			$tabela->ustawBlok('stopka', array('stopka_html' => $this->stopkaHtml));
		}

		return $tabela->parsuj();
	}



	/**
	 * Pobiera tablice z tlumaczeniami.
	 *
	 * @return array
	 */
	public function pobierzTlumaczenia()
	{
		return $this->j->t;
	}



	/**
	 * Ustawia nowe tlumaczenia.
	 *
	 * @param array $tlumaczenia Tablica z nowymi tlumaczeniami.
	 *
	 * @return boolean
	 */
	public function ustawTlumaczenia($tlumaczenia = array())
	{
		if (is_array($tlumaczenia) && $this->j->t = array_merge($this->j->t, $tlumaczenia))
		{
			return true;
		}
		return false;
	}
}

class TabelaDanychWyjatek extends \Exception {}
