<?php
namespace Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\TabelaDanych2;
use Generic\Biblioteka\TabelaDanych;

/**
 * Klasa generuje widok tabeli danych (data grid)
 *
 * @author Krzysztof Lesiczka, Konrad Rudowski
 * @package biblioteki
 */

class Gui extends TabelaDanych2
{
	/**
	 * Przetrzymuje tłumaczenia domyślne
	 *
	 * @var array
	 */
	protected $tlumaczenia = array(
		'etykieta_dodaj' => 'Dodaj',
		'etykieta_edytuj' => 'Edytuj',
		'etykieta_podglad' => 'Podgląd',
		'etykieta_publikuj' => 'Publikuj',
		'etykieta_usun' => 'Usuń',
		'etykieta_potwierdz_usun' => 'Czy chcesz usnąć zaznaczony wiersz?',

		'etykieta_zaznacz_wszystkie' => 'Zaznacz wszystkie',
		'etykieta_odznacz_wszystkie' => 'Odznacz wszystkie',
		'blad_zaznaczenie_puste' => 'Nie zaznaczono żadnych wierszy!',
		'etykieta_odwroc_zaznaczenie' => 'Odwróć zaznaczenie',
		'etykieta_eksportuj_zaznaczone' => 'Eksportuj zaznaczone',
		'etykieta_usun_zaznaczone' => 'Usuń zaznaczone',
		'etykieta_potwierdz_usun_zaznaczone' => 'Czy chcesz usunąć wszystkie zaznaczone wiersze?',
		'etykieta_sortuj_po' => 'Sortuj po kolumnie: ',
		);

	/**
	 * Zmienne opisujące kolumny tabeli danych
	 */

	protected $kolumnyKlucz = null;

	/**
	 * Zmienne opisujące przyciski w tabeli danych
	 */

	protected $przyciski = array();
	protected $przyciskiUrl;
	protected $przyciskiDomyslne = array();
	protected $przyciskiUsun = array();
	protected $ustawKlase = '';
	protected $atrybuty = '';

	/**
	 * Zmienne opisujące przyciski grupowe w tabeli danych
	 */

	protected $przyciskiGrupowe = array();
	protected $przyciskiGrupoweUrl;
	protected $przyciskiGrupoweDomyslne = array();

	/**
	 * Zmienne przetrzymujące dane potrzebne do sortowania
	 */

	protected $sortowanieKolumny = array();
	protected $sortowanieBiezaca;
	protected $sortowanieKierunek;
	protected $sortowanieUrl;


	/**
	 * Przetrzymuje dodatkowe akcje do pol wierszy dodanych do tabeli
	 *
	 * @var array
	 */
	protected $wierszAkcje = array();
	protected $wierszAkcjePrzyciski = array();


	/**
	 * Przetrzymuje informacje czy usuniete przyciski zastepowac kropkami
	 *
	 * @var boolean
	 */
	protected $uzupelniajKropkami = false;

	public function __construct()
	{
		$this->przyciskiDomyslne = array(
			'dodaj' => array(
				'klucz' => 'dodaj',
				'akcja' => 'dodaj',
				'etykieta' => $this->tlumaczenia['etykieta_dodaj'],
				'ikona' => 'dodaj.png',
			),
			'dodajNowy' => array(
				'klucz' => 'dodaj',
				'akcja' => 'dodaj',
				'etykieta' => $this->tlumaczenia['etykieta_dodaj'],
				'class' => 'przyciskDodaj',
			),
			'edytuj' => array(
				'klucz' => 'edytuj',
				'akcja' => 'edytuj',
				'etykieta' => $this->tlumaczenia['etykieta_edytuj'],
				'ikona' => 'edytuj.png',
			),
			'edytujNowy' => array(
				'klucz' => 'edytuj',
				'akcja' => 'edytuj',
				'etykieta' => $this->tlumaczenia['etykieta_edytuj'],
				'class' => 'przyciskEdytuj',
			),
			'usun' => array(
				'klucz' => 'usun',
				'akcja' => 'usun',
				'etykieta' => $this->tlumaczenia['etykieta_usun'],
				'ikona' => 'usun.png',
				'onclick' => 'return confirm(\''.$this->tlumaczenia['etykieta_potwierdz_usun'].'\' + getRowName($(this)))',
			),
			'usunNowy' => array(
				'klucz' => 'usun',
				'akcja' => 'usun',
				'etykieta' => $this->tlumaczenia['etykieta_usun'],
				'class' => 'przyciskUsun',
				'onclick' => 'confirmLightbox(this, \'\', \''.$this->tlumaczenia['etykieta_potwierdz_usun'].'\'); return false;',
			),
			'podglad' => array(
				'klucz' => 'podglad',
				'akcja' => 'podglad',
				'etykieta' => $this->tlumaczenia['etykieta_podglad'],
				'ikona' => 'podglad.png',
			),
			'podgladNowy' => array(
				'klucz' => 'podglad',
				'akcja' => 'podglad',
				'etykieta' => $this->tlumaczenia['etykieta_podglad'],
				'class' => 'przyciskPodglad',
			),
			'publikuj' => array(
				'klucz' => 'publikuj',
				'akcja' => 'publikuj',
				'etykieta' => $this->tlumaczenia['etykieta_publikuj'],
				'ikona' => 'publikuj.png',
			),
		);

		$this->przyciskiGrupoweDomyslne = array(
			'zaznacz' => array(
				'akcja' => 'javascript:void(0)',
				'etykieta' => $this->tlumaczenia['etykieta_zaznacz_wszystkie'],
				'ikona' => 'zaznacz.png',
				'id' => 'zaznacz_wszystkie',
			),
			'odwroc' => array(
				'akcja' => 'javascript:void(0)',
				'etykieta' => $this->tlumaczenia['etykieta_odwroc_zaznaczenie'],
				'ikona' => 'odwroc.png',
				'id' => 'odwroc_zaznaczenie',
			),
			'usun' => array(
				'akcja' => 'usun',
				'etykieta' => $this->tlumaczenia['etykieta_usun_zaznaczone'],
				'ikona' => 'usun.png',
				'id' => 'usun_zaznaczone',
				'onclick' => 'confirmLightbox(this, \'\', \''.$this->tlumaczenia['etykieta_potwierdz_usun_zaznaczone'].'\', \'eWarning\', \'confirm\', true); return false;',
			),
			'eksport' => array(
				'akcja' => 'eksport',
				'etykieta' => $this->tlumaczenia['etykieta_eksportuj_zaznaczone'],
				'ikona' => 'export.png',
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
			throw new TabelaDanych\Wyjatek('Adres URL musi zawierac: {AKCJA}, {KLUCZ}, {WARTOSC}', E_USER_NOTICE);
		}
		else
		{
			$this->przyciskiUrl = $url;
		}
		if (count($przyciski) < 1)
		{
			throw new TabelaDanych\Wyjatek('Nie okreslono zadnych przyciskow', E_USER_NOTICE);
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
					throw new TabelaDanych\Wyjatek('Nieprawidlowa nazwa akcji \''.$przycisk.'\'', E_USER_NOTICE);
				}
			}
			elseif (is_array($przycisk))
			{
				if (array_key_exists('akcja', $przycisk) && array_key_exists('etykieta', $przycisk))
				{
					$this->przyciski[] = $przycisk;
				}
				elseif (array_key_exists('akcja', $przycisk) && isset($przycisk['klucz']) && isset($this->tlumaczenia['etykieta_button_' . $przycisk['klucz']]))
				{
					$przycisk['etykieta'] = $this->tlumaczenia['etykieta_button_' . $przycisk['klucz']];
					$this->przyciski[] = $przycisk;
				}
				else
				{
					throw new TabelaDanych\Wyjatek('Brak akcji lub etykiety w niestandardowym przycisku', E_USER_NOTICE);
				}
			}
			else
			{
				throw new TabelaDanych\Wyjatek('Nieprawidlowa nazwa akcji \''.$przycisk.'\'', E_USER_NOTICE);
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
			throw new TabelaDanych\Wyjatek('Adres URL musi zawierac: {AKCJA}', E_USER_NOTICE);
		}
		else
		{
			$this->przyciskiGrupoweUrl = $url;
		}
		if (count($przyciski) < 1)
		{
			throw new TabelaDanych\Wyjatek('Nie okreslono zadnych przyciskow', E_USER_NOTICE);
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
					throw new TabelaDanych\Wyjatek('Nieprawidlowa nazwa akcji \''.$przycisk.'\'', E_USER_NOTICE);
				}
			}
			elseif (is_array($przycisk))
			{
				if (array_key_exists('akcja', $przycisk) && array_key_exists('etykieta', $przycisk))
				{
					$this->przyciskiGrupowe[] = $przycisk;
				}
				elseif (array_key_exists('akcja', $przycisk) && isset($przycisk['klucz']) && isset($this->tlumaczenia['etykieta_button_' . $przycisk['klucz']]))
				{
					$przycisk['etykieta'] = $this->tlumaczenia['etykieta_button_' . $przycisk['klucz']];
					$this->przyciskiGrupowe[] = $przycisk;
				}
				else
				{
					throw new TabelaDanych\Wyjatek('Brak akcji i etykiety w niestandardowym przycisku', E_USER_NOTICE);
				}
			}
			else
			{
				throw new TabelaDanych\Wyjatek('Nieprawidlowa nazwa akcji \''.$przycisk.'\'', E_USER_NOTICE);
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
	 * Ustawia parametry sortowania
	 *
	 * @param array $kolumny Nazwy kolumn ktore wyswietlaja sortowanie.
	 * @param string $biezaca biezaca kolumna sortowania.
	 * @param string $kierunek Kierunek sortowania do wyboru: 'asc' i 'desc'.
	 * @param string $url Url do sortowania.
	 */
	public function ustawSortownie(Array $kolumny, $biezaca, $kierunek, $url)
	{
		if (count($kolumny) < 1)
		{
			throw new TabelaDanych\Wyjatek('Nie okreslono zadnych kolumn sortowania', E_USER_NOTICE);
		}
		foreach ($kolumny as $kolumnaSortowania)
		{
			if ( ! in_array($kolumnaSortowania, $this->kolumny))
			{
				throw new TabelaDanych\Wyjatek('Nie zdefiniowano kolumny o nazwie '.$kolumnaSortowania, E_USER_NOTICE);
			}
		}
		$this->sortowanieKolumny = $kolumny;

		if (in_array($biezaca, $this->kolumny))
		{
			$this->sortowanieBiezaca = $biezaca;
		}
		else
		{
			trigger_error('Nie zdefiniowano kolumny o nazwie '.$biezaca.' wiec nie moze ona byc kluczem sortowania', E_USER_NOTICE);
		}

		$kierunek = strtolower($kierunek);
		$this->sortowanieKierunek = ($kierunek == 'desc') ? $kierunek : 'asc';

		if (strpos($url, '{KOLUMNA}') === false || strpos($url, '{KIERUNEK}') === false)
		{
			throw new TabelaDanych\Wyjatek('Adres URL musi zawierac: {KOLUMNA}, {KIERUNEK}', E_USER_NOTICE);
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

		$this->wstawWiersz($dane);
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
	public function dodajKolumne($nazwa, $etykieta = '', $szerokosc = 0, $akcja = '', $kluczGlowny = false)
	{

		$this->wstawKolumne($nazwa, array(
				'nazwa' => $nazwa,
				'etykieta' => ($etykieta == '' && isset($this->tlumaczenia['etykieta_' . $nazwa])) ? $this->tlumaczenia['etykieta_' . $nazwa] : $etykieta,
				'szerokosc' => (int)$szerokosc,
				'akcja' => $akcja,
			));

		if ($kluczGlowny)
		{
			if (is_null($this->kolumnyKlucz))
			{
				$this->kolumnyKlucz = $nazwa;
			}
			else
			{
				throw new TabelaDanych\Wyjatek('Klucz glowny zostal juz ustawiony dla kolumny o nazwie '.$this->kolumnyKlucz, E_USER_NOTICE);
			}
		}
	}




}