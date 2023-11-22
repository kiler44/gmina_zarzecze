<?php
//Ustawienie kodowania, sciezek katalogow, wyswietlanie wszystkich bledow
require_once 'cli.inc.php';

//Inicjowanie cms-a dla konsoli
require_once 'cli-cms.inc.php';

/**
 * Skrypt odpowiada za automatyczne wygenerowanie klasy konfiguracji dla modułu.
 *
 * Skrypt dopisuje do listy konfiguracji nowe klucze. Nie kasuje kluczy, których
 * nie odnajdzie.
 */

class KreatorKonfiguracja
{
	protected $tpl = '<?php
namespace Generic\Konfiguracja\{{$typ}}\{{$nazwa}};

use Generic\Konfiguracja\Konfiguracja;

/**{{BEGIN wiersz}}
 * @property {{$wartoscTyp}} $k[\'{{$klucz}}\']{{END}}
 */

class {{$nazwaKlasy}} extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(
	{{BEGIN wiersz}}

	\'{{$klucz}}\' => array({{IF $todo}}//TODO{{END}}{{BEGIN wiersz2}}
		\'{{$klucz2}}\' => {{IF $wartosc2}}{{$wartosc2}}{{ELSE}}null{{END}},{{END}}{{BEGIN wiersz2Tablica}}
		\'{{$klucz2}}\' => array({{BEGIN wiersz3}}
			{{$klucz3}} => {{$wartosc3}},{{END}}
			{{BEGIN wiersz3Lista}}
			{{$wartosc3}},
			{{END}}
			),{{END}}
		),
	{{END}}

	);
}
';
	protected $przetwarzanyTyp = 'Modul';
	protected $przetwarzanyNazwa = '';
	protected $tokeny = array();
	protected $kluczeKonfiguracji = array();
	protected $listaKonfiguracji = array();
	protected $listaOpisow = array();
	protected $listaIstniejacychKonfiguracji = array();
	protected $sciezkaKonfiguracja = '';
	protected $katalogKonfiguracja = '';
	protected $znacznikNowejKonfiguracji = '';


	public function generujPlik($przetwarzanyNazwa, $przetwarzanyTyp, $tryb = 'standard')
	{
		if ($przetwarzanyTyp != '')
		{
			$this->przetwarzanyTyp = $przetwarzanyTyp;
		}

		$this->przetwarzanyNazwa = $przetwarzanyNazwa;

		if ($this->przetwarzanyNazwa == '')
		{
			return;
		}
		$this->sciezkaPrzetwarzany = CMS_KATALOG . '/lib/Generic/' . $this->przetwarzanyTyp . '/' . str_replace('\\', '/', $this->przetwarzanyNazwa) . '.php';
		$this->sciezkaKonfiguracja = CMS_KATALOG . '/lib/Generic/Konfiguracja/' . $this->przetwarzanyTyp . '/' . str_replace('\\', '/', $this->przetwarzanyNazwa) . '.php';

		$nazwa = explode('\\', $this->przetwarzanyNazwa);
		unset($nazwa[count($nazwa) - 1]);
		$nazwa = implode('/', $nazwa);

		$this->katalogKonfiguracja = CMS_KATALOG . '/lib/Generic/Konfiguracja/' . $this->przetwarzanyTyp . '/' . $nazwa;

		if ( ! file_exists($this->sciezkaPrzetwarzany))
		{
			echo "Podano nieprawidłowe argumenty - plik nie istnieje!\n";
			return;
		}

		switch ($tryb)
		{
			case'standard':
			{
				echo "Analizuję plik '$this->sciezkaKonfiguracja'\n";

				$this->analizujTlumaczenia();
			} break;
			case'migracja':
			{
				echo "Tworzę nowy plik '$this->sciezkaKonfiguracja' (migracja)\n";

				$this->utworzNowyPlik();
			} break;
		}
	}


	protected function analizujTlumaczenia()
	{
		$this->wczytajUzyteKlucze();

		$this->wczytajIstniejaceKlucze();

		$trescPliku = $this->wygenerujTrescPliku();

		$this->zapiszTrescPliku($trescPliku);

	}


	protected function utworzNowyPlik()
	{
		if (file_exists($this->sciezkaKonfiguracja))
		{
			echo "Plik konfiguracji istnieje. Pomijam.\n";
			return;
		}

		$this->wczytajStareKonfiguracje();

		$trescPliku = $this->wygenerujTrescPliku();

		$this->zapiszTrescPliku($trescPliku);
	}


	protected function wczytajStareKonfiguracje()
	{
		$namespace = 'Generic\\' . $this->przetwarzanyTyp . '\\' . $this->przetwarzanyNazwa;

		$obiekt = new $namespace();

		$this->listaKonfiguracji = $this->listaIstniejacychKonfiguracji = $obiekt->pobierzKonfiguracje();
		$this->listaOpisow = $obiekt->pobierzOpisKonfiguracji();
	}


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
					if ( ! isset($this->kluczeKonfiguracji[$klucz]))
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


	protected function wczytajIstniejaceKlucze()
	{
		if (file_exists($this->sciezkaKonfiguracja))
		{
			$nazwaKlasyTlumaczen = 'Generic\\Konfiguracja\\' . $this->przetwarzanyTyp . '\\' . $this->przetwarzanyNazwa;

			$obiektKonfiguracji = new $nazwaKlasyTlumaczen;

			$this->listaKonfiguracji = ($this->listaIstniejacychKonfiguracji = $obiektKonfiguracji->pobierzKonfiguracje()) + $this->kluczeKonfiguracji;
			$this->listaOpisow = $obiektKonfiguracji->pobierzOpisKonfiguracji();
		}
	}


	protected function zapiszTrescPliku($trescPliku)
	{
		$katalog = new \Generic\Biblioteka\Katalog($this->katalogKonfiguracja, true);

		$plik = new Generic\Biblioteka\Plik($this->sciezkaKonfiguracja, true);

		if ( ! $plik->ustawZawartosc($trescPliku))
		{
			echo "Wystąpił błąd zapisu pliku tlumaczenia! \n\n";
		}
		else
		{
			echo "Plik tłumaczenia zapisany poprawnie. \n\n";
		}
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


	protected function wygenerujTrescPliku()
	{
		$przetwarzanyNazwa = explode('\\', $this->przetwarzanyNazwa);

		$szablon = new \Generic\Biblioteka\Szablon();
		$szablon->ladujTresc($this->tpl);
		$szablon->ustaw(array(
			'typ' => $this->przetwarzanyTyp,
			'nazwa' => $przetwarzanyNazwa[0],
			'nazwaKlasy' => $przetwarzanyNazwa[1]
		));

		ksort($this->listaKonfiguracji);

		$ileNowychTlumaczen = 0;

		$poprzedniKlucz = null;

		foreach ($this->listaKonfiguracji as $klucz => $wartosc)
		{
			$wiersz = array('wartosc' => $wartosc);

			if (isset($this->listaOpisow[$klucz]))
			{
				$wiersz = $wiersz + $this->listaOpisow[$klucz];
			}

			if ( ! isset($wiersz['opis']))
			{
				$wiersz['opis'] = '';
			}
			else
			{
				$wiersz['opis'] = str_replace('\'', '\\\'', $wiersz['opis']);
			}

			if ( ! isset($wiersz['typ']))
			{
				$wiersz['typ'] = 'varchar';
			}

			$szablon->ustawBlok('wiersz', array(
				'klucz' => $klucz,
				'todo' => $wartosc === null,
				'wartoscTyp' => $this->okreslTypZmiennej($wiersz['typ']),
			));

			ksort($wiersz);

			foreach ($wiersz as $klucz2 => $wartosc2)
			{
				if (is_array($wartosc2))
				{
					$szablon->ustawBlok('wiersz/wiersz2Tablica', array(
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

						$szablon->ustawBlok('wiersz/wiersz2Tablica/wiersz3' . ($wiersz['typ'] == 'list' ? 'Lista' : ''), array(
							'klucz' => $klucz,
							'klucz2' => $klucz2,
							'klucz3' => $klucz3,
							'wartosc3' => $wartosc3,
						));
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

					$szablon->ustawBlok('wiersz/wiersz2', array(
						'klucz' => $klucz,
						'klucz2' => $klucz2,
						'wartosc2' => $wartosc2,
					));
				}
			}

			if ($wartosc == '')
			{
				++$ileNowychTlumaczen;
			}

			$poprzedniKlucz = $klucz;
		}

		echo "Liczba nowych konfiguracji: $ileNowychTlumaczen\n\n";

		return $szablon->parsuj();
	}


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


	protected function okreslTypZmiennej($typ)
	{
		switch($typ)
		{
			case'text':
			case'html':
			case'select':
			case'varchar': return 'string'; break;
			case'array':
			case'region':
			case'pager':
			case'miniatury':
			case'list': return 'array'; break;
			case'int':
			case'mail': return 'int'; break;
			case'float': return 'float'; break;
			case'bool': return 'bool'; break;

			default: return 'string'; break;
		}
	}
}

$creator  = new KreatorKonfiguracja();

//dzieki tej zmiennej jestem w stanie zablokować domyślne działanie pliku przy wykorzystaniu go w innym skrypcie
if ( ! isset($blokadaGenerowaniaPliku))
{
	$przetwarzanyTyp = '';
	$przetwarzanyNazwa = '';

	switch ($argc)
	{
		case 1: echo"\nNależy podać przynajmniej nazwę modułu!.\n\nUruchomienie creatorKonfiguracja.php Wizytowki\\\\Http lub creatorKonfiguracja.php Model Wizytowki\n\n"; break;
		case 2: $przetwarzanyNazwa = $argv[1]; break;
		case 3: $przetwarzanyTyp = $argv[1]; $przetwarzanyNazwa = $argv[2]; break;
	}

	$creator->generujPlik($przetwarzanyNazwa, $przetwarzanyTyp);
}