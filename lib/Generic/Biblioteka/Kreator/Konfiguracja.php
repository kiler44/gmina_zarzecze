<?php

namespace Generic\Biblioteka\Kreator;

use \Generic\Biblioteka;

/**
 * Skrypt odpowiada za automatyczne wygenerowanie klasy konfiguracji dla modelu.
 * Skrypt dopisuje do listy konfiguracji nowe klucze. Nie kasuje kluczy, których
 * nie odnajdzie.
 * @author Konrad Rudowski
 * @author Marek Bar
 */
class Konfiguracja implements Interfejs
{

	protected $przetwarzanyTyp = 'Model';
	protected $przetwarzanyNazwa = '';
	protected $tokeny = array();
	protected $kluczeKonfiguracji = array();
	protected $listaKonfiguracji = array();
	protected $listaOpisow = array();
	protected $listaIstniejacychKonfiguracji = array();
	protected $sciezkaKonfiguracja = '';
	protected $katalogKonfiguracja = '';
	protected $znacznikNowejKonfiguracji = '';
	private $tryb = 'standard';
	private $konfiguracjaCzego = 'Obiekt';
	private $nazwaKlasyKonfiguracja;
	private $ileNowychKonfiguracji;
	private $ileKonfiguracji;

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
		$this->nazwaPlikuSzablonu = 'szablon_konfiguracja.tpl';
		$this->nazwaKlasyKonfiguracja = $this->konfiguracjaCzego;
		$this->konfiguracjaCzego = $this->konfiguracjaCzego != '' ? '/' . $this->konfiguracjaCzego : '';
		$this->katalogGeneric = CMS_KATALOG . '/lib/Generic';
		$this->katalogSzablonow = CMS_KATALOG . '/szablon_system/konsola';
		$this->katalogModel = $this->katalogGeneric . '/Model';
		$this->katalogTlumaczen = $this->katalogGeneric . '/Tlumaczenie';
		$this->katalogKonfiguracji = $this->katalogGeneric . '/Konfiguracja';
		$this->ileKonfiguracji = 0;
		$this->ileNowychKonfiguracji = 0;
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
		return $tekst != '' ? $tekst . "\n" : '';
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
		$this->konfiguracjaCzego = ucfirst($nazwaPlikuModulu);
		$this->nazwaKlasyKonfiguracja = $this->konfiguracjaCzego;
		$this->konfiguracjaCzego = $this->konfiguracjaCzego != '' ? '/' . $this->konfiguracjaCzego : '';
	}



	/**
	 * Generuje kod klasy Konfiguracja dla podanej nazwy tabeli.
	 * @param string $nazwaTabeli - nazwa tabeli dla, której jest generowana konfiguracja
	 * @param string $nazwaUzytkownika - nazwa dla modelu/modułu podana przez użytkownika
	 * @return boolean
	 */
	public function generuj($nazwaTabeli, $nazwaUzytkownika)
	{
		$this->nazwaTabeli = $nazwaTabeli;
		$this->przetwarzanyNazwa = $this->konwertujNaWielblada($nazwaTabeli, true);
		if ($this->przetwarzanyNazwa == '')
		{
			return false;
		}

		$this->sciezkaPrzetwarzany = $this->katalogGeneric . '/' . $this->przetwarzanyTyp . '/' . str_replace('\\', '/', $this->przetwarzanyNazwa) . $this->konfiguracjaCzego . '.php';
		$this->sciezkaKonfiguracja = $this->katalogKonfiguracji . '/' . $this->przetwarzanyTyp . '/' . str_replace('\\', '/', $this->przetwarzanyNazwa) . $this->konfiguracjaCzego . '.php';

		$nazwa = explode('\\', $this->przetwarzanyNazwa);
		unset($nazwa[count($nazwa) - 1]);
		$nazwa = implode('/', $nazwa);

		$nazwaDlaKataloguTabela = $this->konwertujNaWielblada($nazwaTabeli, true);
		$nazwaDlaKataloguUzytkownik = $this->konwertujNaWielblada($nazwaUzytkownika, true);
		if ($nazwaDlaKataloguUzytkownik != '' && $nazwaDlaKataloguUzytkownik != $nazwaDlaKataloguTabela)
		{
			$nazwaDlaKataloguTabela = $nazwaDlaKataloguUzytkownik;
		}
		$this->katalogKonfiguracja = $this->katalogKonfiguracji . '/' . $this->przetwarzanyTyp . '/' . str_replace('\\', '/', $nazwaDlaKataloguTabela);
		$katalog = new Biblioteka\Katalog($this->katalogKonfiguracja, true);
		if (!file_exists($this->sciezkaPrzetwarzany))
		{
			return false;
		}

		switch ($this->tryb)
		{
			case'standard':
				{
					return $this->analizujKonfiguracje();
				}
				break;
			case'migracja':
				{
					echo "Tworzę nowy plik '$this->sciezkaKonfiguracja' (migracja)\n";

					$this->utworzNowyPlik();
				} break;
		}
	}



	/**
	 * Analizuje konfigurację
	 * @return bool
	 */
	protected function analizujKonfiguracje()
	{
		$this->wczytajUzyteKlucze();

		$this->wczytajIstniejaceKlucze();

		$trescPliku = $this->wygenerujTrescPliku();

		return $this->zapiszTrescPliku($trescPliku);
	}



	/**
	 * Tworzy nowy plik konfiguracji
	 * @return bol
	 */
	protected function utworzNowyPlik()
	{
		$plikKonfiguracji = new Plik($this->sciezkaKonfiguracja, true);
		if (!$plikKonfiguracji->istnieje())
		{
			return false;
		}

		$this->wczytajStareKonfiguracje();
		$trescPliku = $this->wygenerujTrescPliku();
		$this->zapiszTrescPliku($trescPliku);
	}



	/**
	 * Odczytuje istniejącą konfigurację
	 */
	protected function wczytajStareKonfiguracje()
	{
		$namespace = 'Generic\\' . $this->przetwarzanyTyp . '\\' . $this->przetwarzanyNazwa;

		$obiekt = new $namespace();

		$this->listaKonfiguracji = $this->listaIstniejacychKonfiguracji = $obiekt->pobierzKonfiguracje();
		$this->listaOpisow = $obiekt->pobierzOpisKonfiguracji();
	}



	/**
	 * Odczytuje używaną konfigurację
	 */
	protected function wczytajUzyteKlucze()
	{
		$this->tokeny = token_get_all(php_strip_whitespace($this->sciezkaPrzetwarzany));

		$ile = count($this->tokeny);

		//wczytanie uzywanych kluczy tłumaczeń
		for ($i = 5; $i < $ile; ++$i)
		{
			if ($this->czyKonfiguracja($i))
			{
				$klucz = str_replace(array('\'', '"'), '', $this->tokeny[$i][1]);

				if ($this->tokeny[$i + 2] == '[' && $this->tokeny[$i + 4] == ']')
				{
					if (!isset($this->kluczeKonfiguracji[$klucz]))
					{
						$this->kluczeKonfiguracji[$klucz] = array();
					}

					$klucz2 = str_replace(array('\'', '"'), '', $this->tokeny[$i + 3][1]);

					$this->kluczeKonfiguracji[$klucz][$klucz2] = null;
				}
				else
				{
					$this->kluczeKonfiguracji[$klucz] = null;
				}
			}
		}
	}



	/**
	 * Wczytuje istniejące klucze
	 */
	protected function wczytajIstniejaceKlucze()
	{
		if (file_exists($this->sciezkaKonfiguracja))
		{
			$nazwaKlasyTlumaczen = 'Generic\\Konfiguracja\\' . $this->przetwarzanyTyp . '\\' . $this->przetwarzanyNazwa . '\\' . $this->nazwaKlasyKonfiguracja;

			$plik = new Biblioteka\Plik($this->sciezkaKonfiguracja);
			if ($plik->pobierzZawartosc() == '')
			{
				return;
			}
			$obiektKonfiguracji = new $nazwaKlasyTlumaczen;

			$this->listaKonfiguracji = ($this->listaIstniejacychKonfiguracji = $obiektKonfiguracji->pobierzKonfiguracje()) + $this->kluczeKonfiguracji;
			$this->listaOpisow = $obiektKonfiguracji->pobierzOpisKonfiguracji();
		}
	}



	/**
	 * Zapisuje wygenerowany kod PHP
	 * @param string $trescPliku
	 * @return bool
	 */
	protected function zapiszTrescPliku($trescPliku)
	{
		$katalog = new \Generic\Biblioteka\Katalog($this->katalogKonfiguracja, true);
		$plik = new \Generic\Biblioteka\Plik($this->sciezkaKonfiguracja, true);
		return $plik->ustawZawartosc($trescPliku);
	}



	protected function czyKonfiguracja($idTokenu)
	{
		if ($this->tokeny[$idTokenu - 1] == '[' && $this->tokeny[$idTokenu + 1] == ']'
				&& is_array($this->tokeny[$idTokenu - 2]) && is_array($this->tokeny[$idTokenu - 3]) && is_array($this->tokeny[$idTokenu - 4])
				&& $this->tokeny[$idTokenu - 2][1] == 'k' && $this->tokeny[$idTokenu - 3][1] == '->' && $this->tokeny[$idTokenu - 4][1] == 'k'
		)
		{
			return true;
		}

		return false;
	}



	/**
	 * Tworzy kod PHP dla pliku konfiguracji
	 * @return string
	 */
	protected function wygenerujTrescPliku()
	{
		$przetwarzanyNazwa = explode('\\', $this->przetwarzanyNazwa);

		if (!$this->inicjujSzablon())
		{
			return '';
		}

		$this->szablon->ustaw(array(
			'typ' => $this->przetwarzanyTyp,
			'nazwa' => $przetwarzanyNazwa[0],
			'nazwaKlasy' => $this->nazwaKlasyKonfiguracja,
			'czego' => 'Generic\\' . $this->przetwarzanyTyp . '\\' . $przetwarzanyNazwa[0] . '\\' . $this->nazwaKlasyKonfiguracja,
		));

		ksort($this->listaKonfiguracji);

		$poprzedniKlucz = null;

		foreach ($this->listaKonfiguracji as $klucz => $wartosc)
		{
			$wiersz = array('wartosc' => $wartosc);

			if (isset($this->listaOpisow[$klucz]))
			{
				$wiersz = $wiersz + $this->listaOpisow[$klucz];
			}

			if (!isset($wiersz['opis']))
			{
				$wiersz['opis'] = '';
			}
			else
			{
				$wiersz['opis'] = str_replace('\'', '\\\'', $wiersz['opis']);
			}

			if (!isset($wiersz['typ']))
			{
				$wiersz['typ'] = 'varchar';
			}

			$this->szablon->ustawBlok('wiersz', array(
				'klucz' => $klucz,
				'todo' => $wartosc === null,
				'wartoscTyp' => $this->okreslTypZmiennej($wiersz['typ']),
			));
			$this->ileKonfiguracji++;

			ksort($wiersz);

			foreach ($wiersz as $klucz2 => $wartosc2)
			{
				if (is_array($wartosc2))
				{
					$this->szablon->ustawBlok('wiersz/wiersz2Tablica', array(
						'klucz' => $klucz,
						'klucz2' => $klucz2,
					));


					foreach ($wartosc2 as $klucz3 => $wartosc3)
					{
						if ($this->czyString($wartosc3))
						{
							$wartosc3 = '\'' . $wartosc3 . '\'';
						}

						if ($this->czyString($klucz3))
						{
							$klucz3 = '\'' . $klucz3 . '\'';
						}

						$this->szablon->ustawBlok('wiersz/wiersz2Tablica/wiersz3' . ($wiersz['typ'] == 'list' ? 'Lista' : ''), array(
							'klucz' => $klucz,
							'klucz2' => $klucz2,
							'klucz3' => $klucz3,
							'wartosc3' => $wartosc3,
						));
						$this->ileKonfiguracji++;
					}
				}
				else
				{
					if ($klucz2 == 'wartosc' && in_array($wiersz['typ'], array('mail', 'int', 'float', 'bool')))
					{
						$wartosc2 = $wartosc2;
					}
					else
					{
						$wartosc2 = '\'' . $wartosc2 . '\'';
					}

					$this->szablon->ustawBlok('wiersz/wiersz2', array(
						'klucz' => $klucz,
						'klucz2' => $klucz2,
						'wartosc2' => $wartosc2,
					));
					$this->ileKonfiguracji++;
				}
			}

			if ($wartosc == '')
			{
				++$this->ileNowychKonfiguracji;
			}

			$poprzedniKlucz = $klucz;
		}

		$this->log('Liczba nowych tłumaczeń: ' . $this->ileNowychKonfiguracji);
		$this->log('Liczba tłumaczeń ogółem: ' . $this->ileKonfiguracji);
		return $this->szablon->parsuj();
	}



	/**
	 * Sprawdza czy podana wartość jest typu string
	 * @param mixed $wartosc
	 * @return bool
	 */
	protected function czyString($wartosc)
	{
		if (strval($wartosc + 0) == strval($wartosc))
		{
			return false;
		}
		else
		{
			return true;
		}
	}



	/**
	 * Zwraca typ podanej zmiennej - typ php
	 * @param string $typ
	 * @return string
	 */
	protected function okreslTypZmiennej($typ)
	{
		switch ($typ)
		{
			case'text':
			case'html':
			case'select':
			case'varchar': return 'string';
				break;
			case'array':
			case'region':
			case'pager':
			case'miniatury':
			case'list': return 'array';
				break;
			case'int':
			case'mail': return 'int';
				break;
			case'float': return 'float';
				break;
			case'bool': return 'bool';
				break;

			default: return 'string';
				break;
		}
	}



	/**
	 * Zwraca tekst podsumowujący działanie generatora.
	 * @return string
	 */
	public function pokazPodsumowanie()
	{
		return $this->pobierzLog();
	}



	/**
	 * Ustawia przetwarzany typ - Modul lub Model
	 * @param string $typ
	 */
	public function ustawPrzetwarzanyTyp($typ)
	{
		$typ = ucfirst($typ);
		$this->przetwarzanyTyp = $typ === 'Model' || $typ === 'Modul' ? $typ : 'Model';
	}



}