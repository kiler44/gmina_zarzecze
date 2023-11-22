<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\TabelaDanychWyjatek;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\Szablon;


/**
 * Klasa generuje widok tabeli danych do sortowania
 *
 * @author Konrad Rudowski
 * @package biblioteki
 */

class TabelaSortowanie
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
	private $przyciskiUsun = array();
	private $ustawKlase = '';


	/**
	 * Zmienne przetrzymujące dane potrzebne do sortowania
	 */

	private $sortowanieKolumny = array();
	private $sortowanieBierzaca;
	private $sortowanieKierunek;

	/**
	 * Zmienne przetrzymujące treść HTML sekcji tablic danych
	 */

	private $naglowekHtml = '';
	private $stopkaHtml = '';


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


	/**
	 * Ustawia dane poczatkowe dla tabela danych.
	 */
	function __construct()
	{

	}

	/**
	 * @var \Generic\Tlumaczenie\Pl\Biblioteka\MenedzerPlikow
	 */
	protected $j;
	

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
		$nazwaKlasy = explode('\\', get_class($this));
		$namespaceJezyka = '\\Generic\\Tlumaczenie\\'.ucfirst(KOD_JEZYKA_ITERFEJSU).'\\Biblioteka\\'.end($nazwaKlasy);
		$this->j = new $namespaceJezyka;
		
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
	 * Metoda ustawia klasę CSS dla kolejnego wiersza ktory zostanie dodany do grida
	 *
	 * @param string $klasa
	 */
	public function ustawKlase($klasa)
	{
		$this->ustawKlase .= ' ' . $klasa;
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
	 * Zwraca html z gotową tabelą
	 *
	 * @param string $plikSzablonu Plik szablonu kóry należy wczytać
	 */
	public function html($szablon = '', $szablonTresc = false)
	{
		$iloscKolumn = count($this->kolumny);
		$iloscWierszy = count($this->wiersze);
		if ($iloscKolumn < 1)
		{
			throw new TabelaDanychWyjatek('Nie zadeklarowano żadnych kolumn do wyswietlenia', E_USER_NOTICE);
		}

		if ( ! $szablonTresc)
		{
			$szablon = ($szablon != '') ? $szablon : CMS_KATALOG.'/' . SZABLON_SYSTEM . '/'.SZABLON_TABELA_SORTOWANIE;
			$szablon = Plik::pobierzTrescPliku($szablon);
		}

		$tabela = new Szablon();
		$tabela->ladujTresc($szablon);
		$tabela->ustawGlobalne(
			array(
				'ilosc_kolumn' => $iloscKolumn + 2, // uwzglednione kolumny akcji i zaznaczenia
			)
		);

		$tabela->ustawBlok('tabela', array(
			'naglowek_html' => $this->naglowekHtml,
			'stopka_html' => $this->stopkaHtml,
			'etykieta_zapisz_sortowanie' => $this->j->t['przycisk_zapisz'],
		));

		// generowanie kolumn naglowkowych dla tabeli
		foreach($this->kolumnyDeklaracje as $kolumna)
		{
			if ($kolumna['nazwa'] == $this->kolumnyKlucz)
			{
				continue;
			}
			$szerokosc = ($kolumna['szerokosc'] > 0) ? $kolumna['szerokosc'] : '';

			$klasa = (in_array($kolumna['nazwa'], $this->sortowanieKolumny) && $this->sortowanieBierzaca == $kolumna['nazwa']) ? 'aktywna '.$this->sortowanieKierunek : '';

			$tabela->ustawBlok('tabela/kolumna_naglowka', array(
				'szerokosc_kolumny' => $szerokosc,
				'nazwa_kolumny' => $kolumna['etykieta']
			));
		}

		$licznik = 1;
		if ($iloscWierszy < 1)
		{
			$tabela->ustawBlok('tabela/wiersz_brak_danych', array(
				'etykieta_brak_wierszy' => $this->j->t['etykieta_brak_wierszy']
			));
		}
		else
		{
			// generowanie wierszy tabeli z trescia
			foreach($this->wiersze as $wiersz)
			{
				$klasa = ($licznik % 2) ? 'nieparzysty' : 'parzysty';
				$wartoscKlucza = $wiersz[$this->kolumnyKlucz];

				$tabela->ustawBlok('tabela/wiersz', array(
					'klasa' => $klasa . (isset($wiersz['_ustaw_klase_']) ? $wiersz['_ustaw_klase_'] : ''),
					'klucz' => $wartoscKlucza,
				));

				foreach($this->kolumnyDeklaracje as $kolumna)
				{
					if ($kolumna['nazwa'] == $this->kolumnyKlucz)
					{
						continue;
					}
					$szerokosc = ($kolumna['szerokosc'] > 0) ? $kolumna['szerokosc'] : '';

					$tabela->ustawBlok('tabela/wiersz/kolumna', array(
						'klasa' => $klasa,
						'szerokosc_kolumny' => $szerokosc,
						'wartosc' => $wiersz[$kolumna['nazwa']] != '' ? $wiersz[$kolumna['nazwa']] : '&nbsp;',
					));
				}

				$licznik++;
				$wiersz++;
			}
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
