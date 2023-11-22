<?php

namespace Generic\Biblioteka\Kreator;

use \Generic\Biblioteka;

/**
 * Klasa odpowiedzialna za wygenerowanie pliku Tlumaczenie dla podanej tabeli bazy danych.
 * @author Konrad Rudowski
 * @author Marek Bar
 */
class Tlumaczenie implements Interfejs
{

	protected $przetwarzanyTyp = 'Model';
	protected $przetwarzanyNazwa = '';
	protected $tokeny = array();
	protected $kluczeTlumaczen = array();
	protected $listaTlumaczen = array();
	protected $listaTypow = array();
	protected $listaIstniejacychTlumaczen = array();
	protected $sciezkaTlumaczenie = '';
	protected $katalogTlumaczenie = '';
	protected $jezyk = 'Pl';
	protected $znacznikNowegoTlumaczenia = '[ETYKIETA:%s]';
	protected $sciezkaPrzetwarzany;
	private $tlumaczenieCzego = 'Obiekt';
	private $nazwaKlasyTlumaczenia;
	private $tryb = 'standard';
	private $ileNowychTlumaczen;
	private $liczbaTlumaczen;

	/**
	 * Katalog w którym są przechowywane szablony klas: Definicja, Obiekt, Mapper, Sorter, Tlumaczenie i Konfiguracja.
	 * @var string
	 */
	private $katalogSzablonow;

	/**
	 * Katalog, w którym mają być umieszczane wygenerowane pliki klasa: Definicja, Obekt, Mapper i Sorter.
	 * @var string
	 */
	private $katalogModel;

	/**
	 * Katalog, w którym mają być umieszczane wygenerowane pliki klas: Tlumaczenie.
	 * @var string
	 */
	private $katalogTlumaczen;

	/**
	 * Katalog, w którym mają być umieszczane wygenerowane pliki klas: Konfiguracja.
	 * @var string
	 */
	private $katalogKonfiguracji;

	/**
	 * Nazwa tabeli
	 * @var string
	 */
	private $nazwaTabeli = '';
	private $szablon;
	private $podsumowanie = array();

	/**
	 * Tłumaczenia
	 * @var array
	 */
	private $t = array(
		'tytul' => " Podsumowanie:",
	);

	/**
	 * Konstruktor ustawiający nazwę generowanego pliku i nazwę pliku jego szablonu.
	 */
	function __construct($nazwaBazy = 'crm')
	{
		$this->nazwaBazy = $nazwaBazy;
		$this->nazwaPlikuSzablonu = 'szablon_tlumaczenia.tpl';
		$this->nazwaKlasyTlumaczenia = $this->tlumaczenieCzego;
		$this->tlumaczenieCzego = $this->tlumaczenieCzego != '' ? '/' . $this->tlumaczenieCzego : '';
		$this->katalogGeneric = CMS_KATALOG . '/lib/Generic';
		$this->katalogSzablonow = CMS_KATALOG . '/szablon_system/konsola';
		$this->katalogModel = $this->katalogGeneric . '/Model';
		$this->katalogTlumaczen = $this->katalogGeneric . '/Tlumaczenie';
		$this->katalogKonfiguracji = $this->katalogGeneric . '/Konfiguracja';
		$this->ileNowychTlumaczen = 0;
		$this->liczbaTlumaczen = 0;
	}



	/**
	 * Konwertuje tekst na styl CamelCase
	 * @param string $tekst
	 * @param bool $czyZaczynacOdPierwszejLitery - domyślnie jest ustawione na nie
	 * @return string - CamelCase
	 */
	protected function konwertujNaWielblada($tekst, $czyZaczynacOdPierwszejLitery = false)
	{
		if ($tekst == '')
		{
			return '';
		}
		if ($czyZaczynacOdPierwszejLitery)
		{
			$tekst[0] = strtoupper($tekst[0]);
		}

		$func = create_function('$c', 'return strtoupper($c[1]);');
		return preg_replace_callback('/_([a-z])/', $func, $tekst);
	}



	/**
	 * Inicjuje szablon pliku PHP
	 * @return boolean
	 */
	public function inicjujSzablon()
	{
		$sciezkaDoPlikuSzablonu = $this->katalogSzablonow . '/' . $this->nazwaPlikuSzablonu;
		$plik = new Biblioteka\Plik($sciezkaDoPlikuSzablonu);
		if (!$plik->istnieje())
		{
			$this->log($this->t['szablon_nie_istneje'] . $sciezkaDoPlikuSzablonu);
			return false;
		}

		$this->szablon = new Biblioteka\Szablon();
		$this->szablon->ladujTresc($plik->pobierzZawartosc());
		return true;
	}



	/**
	 * Ustawia nazwę pliku w module, dla którego ma zostać wykonana analiza tłumaczeń i wygenerowanie pliku tłumaczenia.
	 * @param string $nazwaPlikuModulu - np.: Admin lub Http lub Cron
	 */
	public function ustawNazwePlikuModulu($nazwaPlikuModulu)
	{
		$dozwolone = array('admin', 'http', 'cron');
		if (!in_array(strtolower($nazwaPlikuModulu), $dozwolone))
		{
			$nazwaPlikuModulu = '';
		}
		$this->tlumaczenieCzego = ucfirst($nazwaPlikuModulu);
		$this->nazwaKlasyTlumaczenia = $this->tlumaczenieCzego;
		$this->tlumaczenieCzego = $this->tlumaczenieCzego != '' ? '/' . $this->tlumaczenieCzego : '';
	}



	/**
	 * Generuje kod klasy Tlumaczenie dla podanej nazwy tabeli.
	 * @param string $nazwaTabeli - nazwa tabeli dla, której jest generowane tłumaczenie
	 * @param string $nazwaUzytkownika - nazwa dla modelu/modułu podana przez użytkownika
	 * @return bool
	 */
	public function generuj($nazwaTabeli, $nazwaUzytkownika)
	{
		$this->nazwaTabeli = $nazwaTabeli;
		$nazwaOdTabeli = $this->konwertujNaWielblada($nazwaTabeli, true);

		$nazwaOdUzytkownika = $this->konwertujNaWielblada($nazwaUzytkownika, true);
		if ($nazwaOdUzytkownika != '' && $nazwaOdUzytkownika != $nazwaOdTabeli)
		{
			$nazwaOdTabeli = $nazwaOdUzytkownika;
		}
		$this->przetwarzanyNazwa = $nazwaOdTabeli;
		if ($this->przetwarzanyNazwa == '')
		{
			$this->log('Nieznana nazwa tabeli.');
			return false;
		}

		$this->sciezkaPrzetwarzany = $this->katalogGeneric . '/' . $this->przetwarzanyTyp . '/' . str_replace('\\', '/', $this->przetwarzanyNazwa) . $this->tlumaczenieCzego . '.php';
		$this->sciezkaTlumaczenie = $this->katalogTlumaczen . '/' . $this->jezyk . '/' . $this->przetwarzanyTyp . '/' . str_replace('\\', '/', $nazwaOdTabeli) . $this->tlumaczenieCzego . '.php';

		$nazwa = explode('\\', $this->przetwarzanyNazwa);
		unset($nazwa[count($nazwa) - 1]);
		$nazwa = implode('/', $nazwa);

		$this->katalogTlumaczenie = $this->katalogTlumaczen . '/' . $this->jezyk . '/' . $this->przetwarzanyTyp . '/' . $nazwa . $nazwaOdTabeli;
		$katalog = new Biblioteka\Katalog($this->katalogTlumaczenie, true);
		$plikTlumaczenia = new Biblioteka\Plik($this->sciezkaTlumaczenie, true);
		if (!file_exists($this->sciezkaPrzetwarzany))
		{
			$this->log('Nie można odnaleść pliku: ' . $this->sciezkaPrzetwarzany);
			return false;
		}

		switch ($this->tryb)
		{
			case'standard':
				{
					return $this->analizujTlumaczenia();
				}
				break;
			case'migracja':
				{
					echo "Tworzę nowy plik '$this->sciezkaTlumaczenie' (migracja)\n";
					return $this->utworzNowyPlik();
				}
				break;
		}
	}



	/**
	 * Zapisuje komunikat o przebiegu działania generatora
	 * @param string $tekst
	 */
	private function log($tekst)
	{
		$this->podsumowanie[] = $tekst;
	}



	/**
	 * Zwraca sformatowane komunikaty, gotowe do wyświetlenia
	 * @return string
	 */
	public function pobierzLog()
	{
		$tekst = '';
		if (count($this->podsumowanie) > 0)
		{
			$tekst .= $this->t['tytul'];
		}
		foreach ($this->podsumowanie as $trescWpisuLoga)
		{
			$tekst .= "\n * " . $trescWpisuLoga;
		}
		$tekst = $tekst != '' ? $tekst . "\n" : '';
		return $tekst;
	}



	/**
	 * Analizuje tłumaczenia użyte i te istniejące w pliku tłumaczeń.
	 * @return bool
	 */
	protected function analizujTlumaczenia()
	{
		$this->wczytajUzyteKlucze();
		$this->wczytajIstniejaceKlucze();
		$trescPliku = $this->wygenerujTrescPliku();
		$wynik = $this->zapiszTrescPliku($trescPliku);
		if (!$wynik)
		{
			$this->log('Nie zapisano wygenerowanej treści.');
		}
		return $wynik;
	}



	/**
	 * Tworzy nowy plik tłumaczenia
	 * @return boolean
	 */
	protected function utworzNowyPlik()
	{
		$plikTlumaczenia = new Plik($this->sciezkaTlumaczenie, true);
		if (!$plikTlumaczenia->istnieje())
		{
			$this->log('Plik tłumaczenia nie istnieje: ' . $this->sciezkaTlumaczenie);
			return false;
		}

		$this->wczytajStareTlumaczenia();

		$trescPliku = $this->wygenerujTrescPliku();

		return $this->zapiszTrescPliku($trescPliku);
	}



	/**
	 * Odczytuje istniejące tłumaczenia z pliku tłumaczeń.
	 */
	protected function wczytajStareTlumaczenia()
	{
		$namespace = 'Generic\\' . $this->przetwarzanyTyp . '\\' . $this->przetwarzanyNazwa;

		$obiekt = new $namespace();

		$this->listaTlumaczen = $this->listaIstniejacychTlumaczen = $obiekt->pobierzTlumaczenia();
	}



	/**
	 * Odczytuje wykorzystane klucze tłumaczeń z pliku tłumaczeń.
	 */
	protected function wczytajUzyteKlucze()
	{
		$this->tokeny = token_get_all(php_strip_whitespace($this->sciezkaPrzetwarzany));

		$ile = count($this->tokeny);

		//wczytanie uzywanych kluczy tłumaczeń
		for ($i = 5; $i < $ile; ++$i)
		{
			if ($this->czyTlumaczenie($i))
			{
				$klucz = str_replace(array('\'', '"'), '', $this->tokeny[$i][1]);

				if ($this->tokeny[$i + 2] == '[' && $this->tokeny[$i + 4] == ']')
				{
					if (!isset($this->kluczeTlumaczen[$klucz]))
					{
						$this->kluczeTlumaczen[$klucz] = array();
					}

					$klucz2 = str_replace(array('\'', '"'), '', $this->tokeny[$i + 3][1]);

					$this->kluczeTlumaczen[$klucz][$klucz2] = sprintf($this->znacznikNowegoTlumaczenia, $klucz2);
				}
				else
				{
					$this->kluczeTlumaczen[$klucz] = sprintf($this->znacznikNowegoTlumaczenia, $klucz);
				}
			}
		}
	}



	/**
	 * Odczytuje istniejące klucze tłumaczeń w pliku tłumaczeń.
	 * @return array
	 */
	protected function wczytajIstniejaceKlucze()
	{
		if (file_exists($this->sciezkaTlumaczenie))
		{
			$nazwaKlasyTlumaczen = 'Generic\\Tlumaczenie\\' . $this->jezyk . '\\' . $this->przetwarzanyTyp . '\\' . $this->przetwarzanyNazwa . '\\' . $this->nazwaKlasyTlumaczenia;
			$plik = new Biblioteka\Plik($this->sciezkaTlumaczenie);
			if ($plik->pobierzZawartosc() == '')
			{
				return array();
			};

			$obiektTlumaczen = new $nazwaKlasyTlumaczen;

			$this->listaTlumaczen = ($this->listaIstniejacychTlumaczen = $obiektTlumaczen->pobierzTlumaczeniaDomyslne()) + $this->kluczeTlumaczen;
			$this->listaTypow = $obiektTlumaczen->pobierzTypyTlumaczen();
		}
	}



	/**
	 * Zapisuje wygenerowaną treść pliku PHP, który mazawierać tłumaczenia
	 * @param string $trescPliku
	 * @return boolean
	 */
	protected function zapiszTrescPliku($trescPliku)
	{
		$katalog = new \Generic\Biblioteka\Katalog($this->katalogTlumaczenie, true);
		$plik = new Biblioteka\Plik($this->sciezkaTlumaczenie, true);
		return $plik->ustawZawartosc($trescPliku);
	}



	/**
	 * 
	 * @param mixed $idTokenu
	 * @return boolean
	 */
	protected function czyTlumaczenie($idTokenu)
	{
		if ($this->tokeny[$idTokenu - 1] == '[' && $this->tokeny[$idTokenu + 1] == ']'
				&& is_array($this->tokeny[$idTokenu - 2]) && is_array($this->tokeny[$idTokenu - 3]) && is_array($this->tokeny[$idTokenu - 4])
				&& $this->tokeny[$idTokenu - 2][1] == 't' && $this->tokeny[$idTokenu - 3][1] == '->' && $this->tokeny[$idTokenu - 4][1] == 'j'
		)
		{
			return true;
		}

		return false;
	}



	/**
	 * Tworzy kod PHP tłumaczenia
	 * @return string
	 */
	protected function wygenerujTrescPliku()
	{
		$przetwarzanyNazwa = explode('\\', $this->przetwarzanyNazwa);
		if (!$this->inicjujSzablon())
		{
			$this->log('Nie utworzono szablonu klasy tłumaczenia.');
			return '';
		}

		$this->szablon->ustaw(array(
			'typ' => $this->przetwarzanyTyp,
			'nazwa' => $przetwarzanyNazwa[0],
			'nazwaKlasy' => $this->nazwaKlasyTlumaczenia,
			'czego' => 'Generic\\' . $this->przetwarzanyTyp . '\\' . $przetwarzanyNazwa[0] . '\\' . $this->nazwaKlasyTlumaczenia,
		));

		ksort($this->listaTlumaczen);
		$poprzedniKlucz = null;
		$this->liczbaTlumaczen = 0;
		foreach ($this->listaTlumaczen as $klucz => $wartosc)
		{
			if (is_array($wartosc))
			{

				$this->szablon->ustawBlok('wartoscTablica', array(
					'klucz' => $klucz,
				));

				foreach ($wartosc as $klucz2 => $wartosc2)
				{
					$this->liczbaTlumaczen++;
					$this->szablon->ustawBlok('wartoscTablica/wartoscTekst2', array(
						'klucz' => $klucz,
						'klucz2' => $klucz2,
						'wartosc2' => str_replace('\'', '\\\'', $wartosc2),
						'todo' => ($wartosc2 == sprintf($this->znacznikNowegoTlumaczenia, $klucz2)),
					));

					if ($wartosc2 == sprintf($this->znacznikNowegoTlumaczenia, $klucz2))
					{
						++$this->ileNowychTlumaczen;
					}
				}
			}
			else
			{
				$this->liczbaTlumaczen++;
				$this->szablon->ustawBlok('wartoscTekst', array(
					'klucz' => $klucz,
					'wartosc' => str_replace('\'', '\\\'', $wartosc),
					'todo' => ($wartosc == sprintf($this->znacznikNowegoTlumaczenia, $klucz)),
				));
			}

			if ($wartosc == sprintf($this->znacznikNowegoTlumaczenia, $klucz))
			{
				++$this->ileNowychTlumaczen;
			}

			$poprzedniKlucz = $klucz;
		}

		ksort($this->listaTypow);

		foreach ($this->listaTypow as $klucz => $wartosc)
		{
			$this->szablon->ustawBlok('typPola', array(
				'klucz' => $klucz,
				'wartosc' => str_replace('\'', '\\\'', $wartosc),
			));
		}

		$this->log('Liczba nowych tłumaczeń: ' . $this->ileNowychTlumaczen);
		$this->log('Liczba tłumaczeń ogółem: ' . $this->liczbaTlumaczen);
		return $this->szablon->parsuj();
	}



	/**
	 * Zwraca tekst podsumowujący działanie generatora.
	 * @return string
	 */
	public function pokazPodsumowanie()
	{
		echo $this->pobierzLog();
	}



	/**
	 * Ustawia przetwarzany typ - dostępny jest: Modul i Model
	 * @param string $typ
	 */
	public function ustawPrzetwarzanyTyp($typ)
	{
		$typ = ucfirst($typ);
		$this->przetwarzanyTyp = $typ === 'Model' || $typ === 'Modul' ? $typ : 'Model';
	}



}