<?php
use Generic\Biblioteka\Cms;

//Ustawienie kodowania, sciezek katalogow, wyswietlanie wszystkich bledow
require_once 'cli.inc.php';

//Inicjowanie cms-a dla konsoli
require_once 'cli-cms.inc.php';

/**
 * Skrypt odpowiada za automatyczne wygenerowanie klasy tłumaczeń dla modułu.
 *
 * Skrypt dopisuje do listy tłumaczeń nowe klucze. Nie kasuje kluczy, których
 * nie odnajdzie.
 */

class Creator
{

	protected $przetwarzanyTyp = 'Modul';
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


	public function generujPlik($przetwarzanyNazwa, $przetwarzanyTyp, $jezyki = 'all', $tryb = 'standard')
	{
		$projektyMapper = new \Generic\Model\Projekt\Mapper();
		$projektObiekt = $projektyMapper->pobierzPoKodzie(KOD_PROJEKTU);
		$jezyki_projektu = array();
		foreach ($projektObiekt->jezyki as $jezyk)
		{
			$jezyki_projektu[] = $jezyk->kod;
		}
		
		//echo var_dump($jezyki);
		if ($jezyki != 'all')
		{
			$_jezyki = explode(',', $jezyki);
			$jezyki = [];
			foreach ($_jezyki as $jezyk)
			{
				$jezyk = trim($jezyk);
				
				if (! in_array($jezyk, $jezyki_projektu))
					continue;
				$jezyki[] = $jezyk;
			}
		}
		else
		{
			$jezyki = $jezyki_projektu;
		}
		//echo var_dump($jezyki);
		foreach ($jezyki as $jezyk)
		{
			$this->jezyk = ucfirst($jezyk);
			
			echo '======== Generuje dla jezka: '.$this->jezyk."\n\n";
			
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
			$this->sciezkaTlumaczenie = CMS_KATALOG . '/lib/Generic/Tlumaczenie/' . $this->jezyk . '/' . $this->przetwarzanyTyp . '/' . str_replace('\\', '/', $this->przetwarzanyNazwa) . '.php';

			//dump($this->sciezkaPrzetwarzany);
			$nazwa = explode('\\', $this->przetwarzanyNazwa);
			unset($nazwa[count($nazwa) - 1]);
			$nazwa = implode('/', $nazwa);
	
			$this->katalogTlumaczenie = CMS_KATALOG . '/lib/Generic/Tlumaczenie/' . $this->jezyk . '/' . $this->przetwarzanyTyp . '/' . $nazwa;
	
			if ( ! file_exists($this->sciezkaPrzetwarzany))
			{
				echo "Podano nieprawidłowe argumenty - plik nie istnieje!\n";
				return;
			}
	
			echo "Wybor trybu dzialania\n";
			switch ($tryb)
			{
				case'standard':
				{
					echo "Analizuję plik '$this->sciezkaTlumaczenie'\n";
	
					$this->analizujTlumaczenia();
				} break;
				case'migracja':
				{
					echo "Tworzę nowy plik '$this->sciezkaTlumaczenie' (migracja)\n";
	
					$this->utworzNowyPlik();
				} break;
			}
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
		if (file_exists($this->sciezkaTlumaczenie))
		{
			echo "Plik tlumaczeń istnieje. Pomijam.\n";
			return;
		}

		$this->wczytajStareTlumaczenia();

		$trescPliku = $this->wygenerujTrescPliku();

		$this->zapiszTrescPliku($trescPliku);
	}


	protected function wczytajStareTlumaczenia()
	{
		$namespace = 'Generic\\' . $this->przetwarzanyTyp . '\\' . $this->przetwarzanyNazwa;

		$obiekt = new $namespace();

		$this->listaTlumaczen = $this->listaIstniejacychTlumaczen = $obiekt->pobierzTlumaczenia();
	}


	protected function wczytajUzyteKlucze()
	{
		echo "Wczytuje uzyte w kodzie klucze\n\n";
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
					if ( ! isset($this->kluczeTlumaczen[$klucz]))
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


	protected function wczytajIstniejaceKlucze()
	{
		echo "Wczytuje istniejace klucze\n";
		if (file_exists($this->sciezkaTlumaczenie))
		{
			$nazwaKlasyTlumaczen = 'Generic\\Tlumaczenie\\' . $this->jezyk . '\\' . $this->przetwarzanyTyp . '\\' . $this->przetwarzanyNazwa;

			$obiektTlumaczen = new $nazwaKlasyTlumaczen;

			$this->listaTlumaczen = ($this->listaIstniejacychTlumaczen = $obiektTlumaczen->pobierzTlumaczeniaDomyslne()) + $this->kluczeTlumaczen;
			$this->listaTypow = $obiektTlumaczen->pobierzTypyTlumaczen();
		}
	}


	protected function zapiszTrescPliku($trescPliku)
	{
		$katalog = new \Generic\Biblioteka\Katalog($this->katalogTlumaczenie, true);

		$plik = new Generic\Biblioteka\Plik($this->sciezkaTlumaczenie, true);

		if ( ! $plik->ustawZawartosc($trescPliku))
		{
			echo "Wystąpił błąd zapisu pliku tlumaczenia! \n\n";
		}
		else
		{
			echo "Plik tłumaczenia zapisany poprawnie. \n\n";
		}
	}


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


	protected function wygenerujTrescPliku()
	{
		echo "Generuje tresc pliku\n=======================================================================================\n";
		$przetwarzanyNazwa = explode('\\', $this->przetwarzanyNazwa);

		$szablon = new \Generic\Biblioteka\Szablon();
		
		$sciezkaPlikuSzablonu = CMS_KATALOG. '/' .SZABLON_SYSTEM . '/konsola/szablon_tlumaczenia.tpl';
		$trescSzablonu = new \Generic\Biblioteka\Plik($sciezkaPlikuSzablonu);
		$szablon->ladujTresc($trescSzablonu->pobierzZawartosc());
		
		$szablon->ustaw(array(
			'typ' => $this->przetwarzanyTyp,
			'nazwa' => $przetwarzanyNazwa[0],
			'nazwaKlasy' => $przetwarzanyNazwa[1],
			'jezyk' => $this->jezyk,
		));

		ksort($this->listaTlumaczen);

		echo "Tablica z lista tlumaczen w pliku tlumaczen\n";
		
		
		$ileNowychTlumaczen = 0;

		$poprzedniKlucz = null;

		foreach ($this->listaTlumaczen as $klucz => $wartosc)
		{
			if (is_array($wartosc))
			{

				$szablon->ustawBlok('wartoscTablica', array(
					'klucz' => $klucz,
					'odstep' => (explode('.', $klucz)[0] != explode('.', $poprzedniKlucz)[0] && $poprzedniKlucz != null) ? true : false,
				));

				foreach ($wartosc as $klucz2 => $wartosc2)
				{
					$szablon->ustawBlok('wartoscTablica/wartoscTekst2', array(
						'klucz' => $klucz,
						'klucz2' => $klucz2,
						'wartosc2' => str_replace('\'', '\\\'', $wartosc2),
						'todo' => ($wartosc2 == sprintf($this->znacznikNowegoTlumaczenia, $klucz2)),
					));

					if ($wartosc2 == sprintf($this->znacznikNowegoTlumaczenia, $klucz2))
					{
						++$ileNowychTlumaczen;
					}
				}
			}
			else
			{
				$szablon->ustawBlok('wartoscTekst', array(
					'klucz' => $klucz,
					'wartosc' => str_replace('\'', '\\\'', $wartosc),
					'todo' => ($wartosc == sprintf($this->znacznikNowegoTlumaczenia, $klucz)),
					'odstep' => (explode('.', $klucz)[0] != explode('.', $poprzedniKlucz)[0] && $poprzedniKlucz != null) ? true : false,
				));
			}

			if ($wartosc == sprintf($this->znacznikNowegoTlumaczenia, $klucz))
			{
				++$ileNowychTlumaczen;
			}

			$poprzedniKlucz = $klucz;
		}

		echo "Tablica z typami pol\n";
		//echo var_dump($this->listaTypow);
		ksort($this->listaTypow);

		foreach ($this->listaTypow as $klucz => $wartosc)
		{
			$szablon->ustawBlok('typPola', array(
				'klucz' => $klucz,
				'wartosc' => str_replace('\'', '\\\'', $wartosc),
				));
		}

		echo "Liczba nowych tłumaczeń: $ileNowychTlumaczen\n\n";

		echo "Wygenerowana tresc pliku:\n==================================================================================\n";
		
		return $szablon->parsuj();
	}
}

$creator  = new Creator();

//dzieki tej zmiennej jestem w stanie zablokować domyślne działanie pliku przy wykorzystaniu go w innym skrypcie
if ( ! isset($blokadaGenerowaniaPliku))
{
	$przetwarzanyTyp = '';
	$przetwarzanyNazwa = '';
	$jezyki = 'all';
	
	switch ($argc)
	{
		case 1: echo"\nNależy podać przynajmniej nazwę modułu!.\n\nUruchomienie creatorTlumaczenia.php Wizytowki\\\\Http lub creatorTlumaczenia.php Model Wizytowki\n\n"; break;
		case 2: $przetwarzanyNazwa = $argv[1]; break;
		case 3: $przetwarzanyTyp = $argv[1]; $przetwarzanyNazwa = $argv[2]; break;
		case 4: $przetwarzanyTyp = $argv[1]; $przetwarzanyNazwa = $argv[2]; $jezyki = $argv[3]; break;
	}

	$creator->generujPlik($przetwarzanyNazwa, $przetwarzanyTyp, $jezyki);
}