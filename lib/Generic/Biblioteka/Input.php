<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\Tlumaczenia;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Szablon;


/**
 * Klasa abstrakcyjna dla inputow formularza.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

abstract class Input implements Tlumaczenia\Interfejs
{

	/**
	 * Unikalna nazwa inputa.
	 *
	 * @var string
	 */
	protected $nazwa;


	/**
	 * Etykieta inputa.
	 *
	 * @var string
	 */
	protected $etykieta;


	/**
	 * Opcjonany opis inputa.
	 *
	 * @var string
	 */
	protected $opis;


	/**
	 * Dodatkowe parametry inputa.
	 *
	 * @var array
	 */
	protected $parametry = array();


	/**
	 * Obecna wartosc inputa.
	 * Uwaga!!! w zapytaniach wewnętrznych nie odnosic się do tego pola
	 * tylko korzystac z metrody pobierzWartosc()
	 *
	 * @var mixed
	 */
	protected $wartosc = null;


	/**
	 * Poczatkowa wartosc inputa.
	 *
	 * @var mixed
	 */
	protected $wartoscPoczatkowa = null;


	/**
	 * Wymusza zwracanie poczatkowej wartosc inputa.
	 *
	 * @var boolean
	 */
	protected $wymusPoczatkowa;


	/**
	 * Czy wartosc inputa zostal byla juz filtrowana.
	 *
	 * @var boolean
	 */
	protected $filtrowany = false;


	/**
	 * Czy input zostal juz sprawdzony.
	 *
	 * @var boolean
	 */
	protected $sprawdzony = false;


	/**
	 * Komunikat o bledzie podczas walidacji.
	 *
	 * @var string
	 */
	protected $bladWalidacji;


	/**
	 * Filtry nalozone na input.
	 *
	 * @var array
	 */
	protected $filtry = array();


	/**
	 * Walidatory nalozone na input.
	 *
	 * @var array
	 */
	protected $walidatory = array();


	/**
	 * Czy pole wymagane.
	 *
	 * @var boolean
	 */
	public $wymagany = false;


	/**
	 * Tlumaczenia dla inputa.
	 *
	 * @var array
	 */
	protected $tlumaczenia = array();


	/**
	 * Domyslna tresc szablonu inputa
	 *
	 * @var string
	 */
	protected $tpl = null;


	/**
	 * Obiekt szablonu inputa
	 *
	 * @var Szablon
	 */
	protected $szablon = null;
	
	/**
	 * Katalog szablonu inputa
	 * @var type string
	 */
	protected $katalogSzablonu = null;


	protected $zaladowanoSzablonZwenetrzny = false;

	/**
	 * Konstruktor.
	 *
	 * @param string $nazwa nazwa inputa.
	 * @param array $parametry dodatkowe parametry dla inputa,
	 * @param string $etykieta Etykieta inputa.
	 * Zarezerwowane klucze:
	 * - 'wartosc' (poczatkowa wartosc inputa),
	 * - 'wymagany' (czy wymagane jest wypełnienie inputa),
	 * - 'atrybuty' (atrybuty inputa w formie tablicy, np. 'atrybuty' => array('onclick' => 'this.form.submit()'))
	 * @param string $opis tekstowy opis pola.
	 * @param string szablon - szblon inputa, podawana jest nazwa szablonu
	 */
	public function __construct($nazwa, $parametry = null, $etykieta = null, $opis = null, $szablon = null)
	{
		$this->nazwa = $nazwa;

		/*
		 * Zamiana kolejnosci argumentow $parametry i $etykiety
		 *
		 * Sprawdzenie czy argumeny zostaly wprowadzone w stary sposob, jesli tak zamieniamy kolejnosc parametrow $parametry i $etykiety
		 */

		if ((is_array($etykieta) || $etykieta == null) && (is_string($parametry) || $parametry == null))
		{
			$tmp_parametry = $parametry;
			$parametry = $etykieta;
			$etykieta = $tmp_parametry;
		}

		$parametry = (array) $parametry;
		$this->etykieta = $etykieta;
		if (isset($parametry['wartosc']))
		{
			$this->ustawWartosc($parametry['wartosc']);
			unset($parametry['wartosc']);
		}
		if (isset($parametry['wymagany']))
		{
			$this->wymagany = (bool) $parametry['wymagany'];
			unset($parametry['wymagany']);
		}
		$this->ustawParametry($parametry);
		$this->ustawOpis($opis);
		
		$this->ustawTlumaczenia(Cms::inst()->lang['inputy']);


		if ($this->tpl != null)
		{
			$this->ustawSzablon($szablon);
		}
	}



	/**
	 * Zwraca nazwe inputa
	 *
	 * @return string
	 */
	public function pobierzNazwe()
	{
		return $this->nazwa;
	}



	/**
	 * Ustawia nazwe inputa
	 *
	 * @param string $nazwa
	 *
	 * @return Input
	 */
	public function ustawNazwe($nazwa)
	{
		$this->nazwa = (string)$nazwa;

		return $this;
	}



	/**
	 * Zwraca etykiete inputa
	 *
	 * @return string
	 */
	public function pobierzEtykiete()
	{
		return $this->etykieta;
	}



	/**
	 * Ustawia etykiete inputa
	 *
	 * @param string $etykieta
	 *
	 * @return Input
	 */
	public function ustawEtykiete($etykieta)
	{
		$this->etykieta = (string)$etykieta;

		return $this;
	}



	/**
	 * Zwraca opis inputa
	 *
	 * @return string
	 */
	public function pobierzOpis()
	{
		return $this->opis;
	}



	/**
	 * Ustawia opis inputa
	 *
	 * @param string
	 *
	 * @return Input
	 */
	public function ustawOpis($opis)
	{
		$this->opis = (string)$opis;

		return $this;
	}



	/**
	 * Zwraca parametry
	 *
	 * @return string
	 */
	public function pobierzParametry()
	{
		return $this->parametry;
	}



	/**
	 * Ustawia tablicę parametrów
	 *
	 * @param Array $parametry
	 *
	 * @return Input
	 */
	public function ustawParametry(Array $parametry)
	{
		$this->parametry = array_replace($this->parametry, $parametry);

		return $this;
	}



	/**
	 * Zwraca wartosc parametru o podanej nazwie jezeli ten istnieje
	 *
	 * @param string $nazwa
	 *
	 * @return mixed
	 */
	public function pobierzParametr($nazwa)
	{
		if (array_key_exists($nazwa ,$this->parametry))
		{
			return $this->parametry[$nazwa];
		}
		else
		{
			trigger_error('Nieprawidlowa nazwa parametru dla inputa '.$this->nazwa, E_USER_WARNING);
			return null;
		}
	}



	/**
	 * Ustawia wartosc parametru jezeli ten istnieje
	 *
	 * @param string $nazwa
	 * @param mixed $wartosc
	 *
	 * @return Input
	 */
	public function ustawParametr($nazwa, $wartosc)
	{
		if (array_key_exists($nazwa ,$this->parametry))
			$this->parametry[$nazwa] = $wartosc;
		else
			trigger_error('Nieprawidlowa nazwa parametru dla inputa '.$this->nazwa, E_USER_WARNING);

		return $this;
	}



	/**
	 * Pobiera obecna wartosc inputa.
	 *
	 * @return mixed
	 */
	public function pobierzWartosc()
	{
		$cms = Cms::inst();

		if ($this->wymusPoczatkowa)
		{
			return $this->pobierzWartoscPoczatkowa();
		}
		if ($this->filtrowany)
		{
			return $this->wartosc;
		}

		$this->wartosc = Zadanie::pobierz($this->pobierzNazwe());
		if ($this->wartosc !== null)
		{
			$this->wartosc = $this->filtrujWartosc($this->wartosc);
		}
		else
		{
			$this->wartosc = $this->pobierzWartoscPoczatkowa();
		}
		return $this->wartosc;
	}



	/**
	 * Ustawia wartosc poczatkowa inputa.
	 *
	 * @param mixed $wartoscPoczatkowa Wartosc poczatkowa inputa.
	 * @param boolean $wymus wymuszanie nadpisania wartosc.
	 *
	 * @return Input
	 */
	public function ustawWartosc($wartoscPoczatkowa, $wymus = false)
	{
		$this->wartoscPoczatkowa = $wartoscPoczatkowa;
		$this->wymusPoczatkowa = (bool) $wymus;

		return $this;
	}



	/**
	 * Pobiera wartosc poczatkowa inputa.
	 *
	 * @return mixed
	 */
	public function pobierzWartoscPoczatkowa()
	{
		return $this->wartoscPoczatkowa;
	}



	/**
	 * Sprawdza czy input zostal zmodyfikowany.
	 *
	 * @return boolean
	 */
	public function zmieniony()
	{
		return ($this->pobierzWartosc() != $this->pobierzWartoscPoczatkowa());
	}



	/**
	 * Dodaje filtr do wewnetrznej tablicy filtrow i zwraca obiekt.
	 *
	 * @param string $nazwa Nazwa(lub nazwy odzielone przecinkiem) filtra(funkcji filtrujacej).
	 *
	 * @return Input
	 */
	public function dodajFiltr($nazwa)
	{
		$filtry = func_get_args();
		$this->filtry = array_merge($this->filtry, $filtry);
		$this->sprawdzony = false;

		return $this;
	}



	/**
	 * Dodaje walidator do wewnetrznej tablicy walidatorow.
	 *
	 * @param Walidator $walidator Obiekt walidatora
	 *
	 * @return Input
	 */
	public function dodajWalidator(Walidator $walidator)
	{
		$this->walidatory[] = $walidator;
		$this->sprawdzony = false;

		return $this;
	}



	/**
	 * Zwraca blad walidacji.
	 *
	 * @return string
	 */
	public function pobierzBladWalidacji()
	{
		if (!$this->sprawdzony)
		{
			$this->sprawdzony = true;
			$this->bladWalidacji = null;
			$wartosc = $this->pobierzWartosc();
			/*
			 * Jezeli input ma wartosc pusta i nie jest wymagany to pomijamy sprawdzanie
			 * poniewaz niektore walidatory nie akceptuja wartosci pustej wiec zwroca blad
			 * mimo iz wartosc pusta jest dozwolona.
			 */
			if ($wartosc == '' && (bool) $this->wymagany === false)
			{
				return $this->bladWalidacji;
			}
			foreach ($this->walidatory as $walidator)
			{
				// pierwszy walidator który zwróci blad przerywa sprawdzanie
				if (!$walidator->sprawdz($wartosc))
				{
					$this->bladWalidacji = $walidator->pobierzBlad();
					break;
				}
			}
		}
		return $this->bladWalidacji;
	}



	/**
	 * Czy input byl sprawdzany.
	 *
	 * @return boolean
	 */
	public function sprawdzony()
	{
		return $this->sprawdzony;
	}



	/**
	 * Sprawdza czy input sie poprawnie zwalidowal.
	 *
	 * @return boolean
	 */
	public function poprawny()
	{
		return ($this->pobierzBladWalidacji() == null);
	}



	/**
	 * Filtruje wartosc podana w argumencie
	 *
	 * @param mixed $wartosc Wartosc do filtrowania.
	 *
	 * @return mixed
	 */
	protected function filtrujWartosc($wartosc)
	{
		foreach ($this->filtry as $filtr)
		{
			$wartosc = $filtr($wartosc);
		}
		$this->filtrowany = true;
		return $wartosc;
	}



	/**
	 * Zwraca kod HTML atrybutow inputa.
	 *
	 * @return string
	 */
	protected function pobierzAtrybuty()
	{
		$html = '';
		if (isset($this->parametry['atrybuty']) && count($this->parametry['atrybuty']) > 0)
		{
			foreach ($this->parametry['atrybuty'] as $nazwa => $watosc)
			{
				$html .= ' ' . $nazwa . '="' . htmlspecialchars($watosc) . '"';
			}
		}
		return $html;
	}



	/**
	 * Metoda dodaje atrybuty do Inputa.
	 *
	 * @param array $atrybuty - tablica z atrybutami
	 *
	 * @return Input
	 */
	public function dodajAtrybuty(Array $atrybuty)
	{
		if (isset($this->parametry['atrybuty']) && count($this->parametry['atrybuty']) > 0)
			$this->parametry['atrybuty'] = array_merge($this->parametry['atrybuty'], $atrybuty);
		else
			$this->parametry['atrybuty'] = $atrybuty;

		return $this;
	}



	/**
	 * Zwraca kod HTML inputa.
	 *
	 * @return string
	 */
	public abstract function pobierzHtml();



	/**
	 * Pobiera tablice z tlumaczeniami.
	 *
	 * @return array
	 */
	public function pobierzTlumaczenia()
	{
		$tlumaczenia = array();

		$klucz = $this->nazwa;

		$tlumaczenia[$klucz.'.etykieta'] = $this->etykieta;
		$tlumaczenia[$klucz.'.opis'] = $this->opis;

		foreach ($this->walidatory as $walidator)
		{
			$kluczWaliator = get_class($walidator);
			/* @var $walidator Walidator */
			foreach ($walidator->pobierzTlumaczenia() as $kluczBlad => $wartosc)
			{
				$tlumaczenia[$klucz.'.'.$kluczWaliator.'.'.$kluczBlad] = $wartosc;
	}
		}

		return $tlumaczenia;
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
		if (is_array($tlumaczenia))
		{
			foreach ($tlumaczenia as $klucz => $wartosc)
			{
			$pomin = false;

			foreach($this->walidatory as $walidator)
			{
				if ($walidator instanceof $klucz)
				{
				$walidator->ustawTlumaczenia($wartosc);
				$pomin = true;
				}
			}
			if ($pomin) continue;

			if ($klucz == 'etykieta')
				$this->etykieta = $wartosc;
			elseif ($klucz == 'opis')
				$this->opis = $wartosc;
			if ($klucz == 'wartosc' && is_null($this->pobierzWartoscPoczatkowa()))
				$this->ustawWartosc($wartosc);
			else
				$this->tlumaczenia[$klucz] = $wartosc;
			}
			return true;
		}
		return false;
	}



	/**
	 * Metod inicjuje szablon
	 */
	protected function inicjujSzablon()
	{
		if (!($this->szablon instanceof Szablon))
		{
			$this->szablon = new Szablon();
			$this->szablon->ladujTresc($this->tpl);

			$this->szablon->ustawGlobalne($this->tlumaczenia);
		}
	}


	/**
	 * Ustawia tresc szablonu dla inputa
	 *
	 * @param string $trescSzablonu Nazwa pliku lub kod szablonu
	 */
	public function ustawSzablon($szablon = null)
	{
		if ($szablon == null)
		{
			$this->inicjujSzablon();
			return $this;
		}
		else
		{
			$katalog = ($this->katalogSzablonu != null && NOWY_SZABLON) ? 'inputy/'.$this->katalogSzablonu : str_replace('Generic\\Biblioteka\\Input\\' , 'inputy/', get_class($this));

			$trescSzablonu = SZABLON_KATALOG . '/' . $katalog . '/' . $szablon;

			if (is_file($trescSzablonu))
			{
				$nowySzablon = new Szablon($trescSzablonu);
				$this->szablon = $nowySzablon;
				$this->szablon->ustawGlobalne($this->tlumaczenia);
				$this->zaladowanoSzablonZwenetrzny = true;
				
				return $this;
			}
			else
			{
				trigger_error('Brak pliku szablonu inputa: '.$trescSzablonu, E_USER_WARNING);
				return $this;
			}
		}
	}
	
	
	/**
	 * Zwraca bool czy ustawiono niestandardowy szablon
	 */
	public function sprawdzSzablonZewnetrzny()
	{
		return $this->zaladowanoSzablonZwenetrzny;
	}

}

class InputWyjatek extends \Exception {}

