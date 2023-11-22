<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\Tlumaczenia;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Sesja;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\FormularzWyjatek;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\Szablon;


/**
 * Klasa obslugujaca formularze
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Formularz implements Tlumaczenia\Interfejs, \Iterator
{

	/**
	 * Akcja w formularzu
	 *
	 * @var string
	 */
	protected $akcja;


	/**
	 * Nazwa formularza
	 *
	 * @var string
	 */
	protected $nazwa;


	/**
	 * Typ formularza
	 *
	 * @var string
	 */
	protected $typ;


	/**
	 * Metoda wysylania
	 *
	 * @var string
	 */
	protected $metoda;

	/**
	 * Dodatkwe parametry formularza
	 *
	 * @var array
	 */
	protected $parametry = array();

	/**
	 * Pola formularza
	 *
	 * @var array
	 */
	protected $pola = array();


	/**
	 * Kursor formularza dla interfejsu Iterator
	 *
	 * @var string
	 */
	protected $polaKursor;


	/**
	 * Ilosc pol formularza dla interfejsu Iterator
	 *
	 * @var string
	 */
	protected $polaIlosc;


	/**
	 * Pola formularza znajdujace sie w stopce
	 *
	 * @var array
	 */
	protected $stopka = array();


	/**
	 * Zawiera kod aktywnego zbiorowego inputa
	 *
	 * @var string
	 */
	protected $aktywnyZbiorowyInput = null;


	/**
	 * Zawiera kod aktywnego regionu
	 *
	 * @var string
	 */
	protected $aktywnyRegion = null;


	/**
	 * Przetrzymuje nazwę aktywnej zakałdki
	 *
	 * @var string
	 */
	protected $aktywnaZakladka = null;


	/**
	 * Przetrzymuje tablicę zakładek
	 *
	 * @var array
	 */
	protected $zakladki = array();


	/**
	 * Obiekt sesji
	 *
	 * @var Sesja
	 */
	protected $sesja;


	/**
	 * Wartość przechowuje informacje czy zapisywać wartości formualrza w sesji
	 *
	 * @var bool
	 */
	protected $wartosciSesja = false;


	/**
	 * Tlumaczenia dla formularza
	 *
	 * @var array
	 */
	protected $tlumaczenia = array();


	/**
	 * Unikalny identyfikator formularza
	 *
	 * @var string
	 */
	protected $identyfikatorFormularza = '';


	/**
	 * Domyslny szablon dla inputow w formularzu
	 *
	 * @var string
	 */
	protected $szablonInput = null;



	/**
	 * Ustawia podstawowe dane formularza
	 *
	 * @param string $akcja akcja formularza
	 * @param string $nazwa nazwa formularzaetoda
	 * @param string $typ typ wysylanych danych z formularza
	 * @param string $metoda metoda wysylania formularza
	 * @param boolean $uzyjSesji czy zapisac wartosci formularza do sesji
	 */
	function __construct($akcja, $nazwa = 'formularz', $typ = 'multipart/form-data', $metoda = 'post', $uzyjSesji = true, $wartosciSesja = false)
	{
		$this->akcja = $akcja;
		$this->nazwa = $nazwa;
		$this->typ = (in_array($typ, array('multipart/form-data','application/x-www-form-urlencoded','text/plain'))) ? $typ : 'multipart/form-data';
		$metoda = strtolower($metoda);
		$this->metoda = ($metoda == 'get' || $metoda =='post') ? $metoda : 'post';
		if ($uzyjSesji && Cms::inst()->sesja instanceof Sesja)
		{
			$this->sesja = Cms::inst()->sesja;
			$this->wartosciSesja = (bool) $wartosciSesja;
		}
		$this->ustawTlumaczenia(Cms::inst()->lang['formularz']);
		// TODO !!!
		$this->szablonInput = (Cms::inst()->usluga->kod() == 'Admin' || Cms::inst()->usluga->kod() == 'Ajax') ? 'Admin.tpl' : null;
	}



	/**
	 * Pobiera pole z wewnętrznej tablicy z polami formularza
	 *
	 * @param string $pole nazwa inputa do zwrócenia
	 *
	 * @return Input
	 */
	function __get($pole)
	{
		if (array_key_exists($pole, $this->pola) && $this->pola[$pole] instanceof Input)
		{
			return $this->pola[$pole];
		}
		else
		{
			throw new FormularzWyjatek('Brak inputa o nazwie "'.$pole.'" w formularzu.');
		}
	}



	/**
	 * Sprawdza czy pole istnieje w wewnętrznej tablicy z polami formularza
	 *
	 * @param string $pole nazwa inputa
	 *
	 * @return boolean
	 */
	function __isset($pole)
	{
		return isset($this->pola[$pole]);
	}



	/**
	 * Pobiera pole z wewnętrznej tablicy z polami formularza
	 *
	 * @param string $pole nazwa inputa do ustawienia
	 * @param object $input input do ustawienia
	 */
	function __set($pole, $input)
	{
		throw new FormularzWyjatek('Dodawanie inputa przez metody input() i stopka().');
	}


	function __unset($pole)
	{
		unset($this->pola[$pole]);
	}

	/**
	 * Dodaje input do formularza
	 *
	 * @param Input|string $input Input do wstawienia
	 * @param string $wstawPo nazwa Inputa po jakim nowy input ma byc wstawiony jeśli parametr równe 'start' dodaj na początku tablicy
	 *
	 * @return Input
	 */
	function input($input, $wstawPo = null)
	{
		/**
		 * @var $input \Generic\Biblioteka\Input
		 */
		if ($input instanceof Input)
		{
			$nazwa = $input->pobierzNazwe();

			if ( ! array_key_exists($nazwa, $this->pola))
			{
				if (!$input->sprawdzSzablonZewnetrzny())
				{
					$input->ustawSzablon($this->szablonInput);
				}

				if ($wstawPo !== null)
				{

				    if($wstawPo == 'start')
                    {
                        //array_unshift($this->pola,   );
                        $this->pola = array_merge([$nazwa => $input], $this->pola);
                        //$this->pola[$nazwa] = $input;
                    }
				    else
                    {
                        if (! array_key_exists($wstawPo, $this->pola))
                        {
                            throw new FormularzWyjatek('Pole o nazwie "'.$wstawPo.'" po ktorym chcesz wstawic Input nie istnieje w tym formularzu.');
                        }
                        $nowePola = array_insert_after($wstawPo, $this->pola, $nazwa, $input);
                        if ($nowePola !== false)
                        {
                            $this->pola = $nowePola;
                        }
                        else
                        {
                            throw new FormularzWyjatek('Nie udalo sie wstawic nowego Inputa po "'.$wstawPo.'".');
                        }
                    }
				}
				else
				{
					$this->pola[$nazwa] = $input;
				}
				$this->polaIlosc++;
				
				return $this->pola[$nazwa];
			}
			else
			{
				throw new FormularzWyjatek('Input o nazwie "'.$nazwa.'" zostal juz dodany do formularza.');
			}
		}
		elseif (is_string($input))
		{
			if (array_key_exists($input, $this->pola) && $this->pola[$input] instanceof Input)
			{
				return $this->pola[$input];
			}
			else
			{
				throw new FormularzWyjatek('Brak inputa o nazwie "'.$input.'" w formularzu.');
			}
		}
		else
		{
			throw new FormularzWyjatek('Nieprawidlowy typ parametru. Należy przekazać obiekt klasy Input lub nazwę pola ktore zostalo juz dodane.');
		}
	}



	/**
	 * Usuwa input do formularza
	 *
	 * @param string $input Nazwa inputa do usuniecia
	 *
	 * @return bool
	 */
	function usunInput($input)
	{
		if (is_string($input)
			&& array_key_exists($input, $this->pola)
			&& $this->pola[$input] instanceof Input
			)
		{
			unset ($this->pola[$input]);
			return true;
		}
		else
		{
			trigger_error('Brak inputa o nazwie "'.$input.'" w formularzu.', E_USER_WARNING);
			return false;
		}
	}



	/**
	 * Dodaje nowy obszar html do formularza
	 *
	 * @param string $nazwa Nazwa pola
	 * @param string $tresc Tresc html
	 */
	function poleHtml($nazwa, $tresc)
	{
		$pelnaNazwa = '__pole__html__'.$nazwa;

		if (!array_key_exists($pelnaNazwa, $this->pola))
		{
			$this->pola[$pelnaNazwa] = $tresc;
		}
		else
		{
			throw new FormularzWyjatek('Input o nazwie "'.$nazwa.'" zostal juz dodany do formularza.');
		}
	}



	/**
	 * Dodaje input do stopki formularza
	 *
	 * @param Input $input Input do wstawienia do stopki
	 */
	function stopka(Input $input)
	{
		$nazwa = $input->pobierzNazwe();

		if (!array_key_exists($nazwa, $this->stopka))
		{
			$input->ustawSzablon($this->szablonInput);
			$this->stopka[$nazwa] = $input;
		}
		else
		{
			throw new FormularzWyjatek('Input o nazwie "'.$nazwa.'" zostal juz dodany do stopki.');
		}
	}


	/**
	 * Usuwa input ze stopki formularza
	 *
	 * @param string $input nazwa inputa do usunięcia ze stopki
	 */
	function usunZeStopki($input)
	{
		if (array_key_exists($input, $this->stopka))
		{
			unset($this->stopka[$input]);
		}
		else
		{
			throw new FormularzWyjatek('Inputa o nazwie "'.$input.'" nie zostal jeszcze dodany do stopki.');
		}
	}

	/**
	 * Ustawia zbiorowy input jako aktywny (mozliwe jest dopisywanie do niego inputow)
	 *
	 * @param string $nazwa Unikalna nazwa inputa
	 * @param string $etykieta Etykieta inputa
	 * @param string $opis Opis inputa
	 * @param boolean $pionowyUklad Czy pionowy uklad (domyslnie poziomy)
	 * @param strin $klasa Indywidualna klasa dla inputa zbiorowego
	 */
	function otworzZbiorowyInput($nazwa, $etykieta = '', $opis = '', $pionowyUklad = false, $klasa = '')
	{
		$pelnaNazwa = '__zbiorowy__start__'.$nazwa;

		if (array_key_exists($pelnaNazwa, $this->pola))
		{
			throw new FormularzWyjatek('Nazwa inputa zbiorowego "'.$nazwa.'" zostala juz uzyta.');
		}
		else if ($this->aktywnyZbiorowyInput != null)
		{
			throw new FormularzWyjatek('Nie zamknieto aktywnego regionu "'.$this->aktywnyZbiorowyInput.'".');
		}
		else
		{
			$this->aktywnyZbiorowyInput = $nazwa;
			$this->pola[$pelnaNazwa] = array(
				'nazwa' => $nazwa,
				'etykieta' => $etykieta,
				'opis' => $opis,
				'pionowy' => (bool)$pionowyUklad,
				'klasa' => $klasa,
			);
		}
	}



	/**
	 * Ustawia zbiorowy input jako nieaktywny
	 *
	 * @param string $nazwa Unikalna nazwa inputa
	 */
	function zamknijZbiorowyInput($nazwa)
	{
		$pelnaNazwa = '__zbiorowy__stop__'.$nazwa;

		if ($this->aktywnyZbiorowyInput != $nazwa)
		{
			throw new FormularzWyjatek('Nie otwarto wczesniej inputa zbiorowego o nazwie "'.$nazwa.'".');
		}
		else
		{
			$this->aktywnyZbiorowyInput = null;
			$this->pola[$pelnaNazwa] = array('nazwa' => $nazwa);
		}
	}



	/**
	 * Ustawia region jako aktywny (mozliwe jest dopisywanie do niego inputow)
	 *
	 * @param string $nazwa nazwa regionu
	 * @param string $etykieta Etykieta zakladki
	 * @param bool $otwarty Czy domyslnie otwarty
	 */
	function otworzRegion($nazwa, $etykieta = null, $otwarty = true, $klasa = '')
	{
		$pelnaNazwa = '__region__start__'.$nazwa;

		if (array_key_exists($pelnaNazwa, $this->pola))
		{
			throw new FormularzWyjatek('Nazwa regionu "'.$nazwa.'" zostala juz uzyta.');
		}
		else if ($this->aktywnyRegion != null)
		{
			throw new FormularzWyjatek('Nie zamknieto aktywnego regionu "'.$this->aktywnyRegion.'".');
		}
		else
		{
			$this->aktywnyRegion = $nazwa;
			$this->pola[$pelnaNazwa] = array(
				'nazwa' => $nazwa,
				'etykieta' => $etykieta,
				'otwarty' => (bool)$otwarty,
				'klasa' => $klasa,
			);
		}
		return $this;
	}



	/**
	 * Ustawia region jako nieaktywny
	 *
	 * @param string $nazwa nazwa regionu
	 */
	function zamknijRegion($nazwa)
	{
		$pelnaNazwa = '__region__stop__'.$nazwa;

		if ($this->aktywnyRegion != $nazwa)
		{
			throw new FormularzWyjatek('Nie otwarto wczesniej regionu o nazwie "'.$nazwa.'".');
		}
		else
		{
			$this->aktywnyRegion = null;
			$this->pola[$pelnaNazwa] = array('nazwa' => $nazwa);
		}
		return $this;
	}



	/**
	 * Ustawia zakladke jako aktywnya (mozliwe jest dopisywanie do niej inputow)
	 *
	 * @param string $nazwa nazwa zakladki
	 * @param string $etykieta Etykieta zakladki
	 */
	function otworzZakladke($nazwa, $etykieta = null)
	{
		$pelnaNazwa = '__zakladka__start__'.$nazwa;

		if (array_key_exists($pelnaNazwa, $this->pola))
		{
			throw new FormularzWyjatek('Nazwa zakladki "'.$nazwa.'" zostala juz uzyta.');
		}
		else if ($this->aktywnaZakladka != null)
		{
			throw new FormularzWyjatek('Nie zamknieto aktywnej zakladki "'.$this->aktywnaZakladka.'".');
		}
		else if ($this->aktywnyRegion != null)
		{
			throw new FormularzWyjatek('Nie zamknieto aktywnego regionu "'.$this->aktywnyRegion.'" w zakladce.');
		}
		else
		{
			$this->zakladki[] = array('nazwa' => $nazwa, 'etykieta' => $etykieta);
			$this->aktywnaZakladka = $nazwa;
			$this->pola[$pelnaNazwa] = array('nazwa' => $nazwa, 'etykieta' => $etykieta);
		}
		return $this;
	}



	/**
	 * Ustawia zakladke jako niektywna
	 *
	 * @param string $nazwa nazwa zakladki
	 */
	function zamknijZakladke($nazwa)
	{
		$pelnaNazwa = '__zakladka__stop__'.$nazwa;

		if ($this->aktywnaZakladka != $nazwa)
		{
			throw new FormularzWyjatek('Nie otwarto wczesniej zakladki o nazwie "'.$nazwa.'"');
		}
		else
		{
			$this->aktywnaZakladka = null;
			$this->pola[$pelnaNazwa] = array('nazwa' => $nazwa);
		}
		return $this;
	}



	/**
	 * Sprawdza czy formularz jest wypelniony
	 *
	 * @return boolean
	 */
	function wypelniony()
	{
		if ($this->metoda == 'post')
		{
			$wynik = Zadanie::pobierzPost('__'.$this->nazwa);
		}
		else
		{
			$wynik = Zadanie::pobierzGet('__'.$this->nazwa);
		}
		return ($wynik && $this->tokenPoprawny()) ? true : false;
	}



	/**
	 * Generuje i zwraca unikalny identyfikator formularza, który jest
	 * utrzymywany po jego przesłaniu.
	 *
	 * @return string
	 */
	protected function generujIdentyfikatorFormularza()
	{
		if (Zadanie::pobierz("__identyfikator") != '')
		{
			$this->identyfikatorFormularza = Zadanie::pobierz("__identyfikator");
		}

		if ($this->identyfikatorFormularza == '')
		{
			if (Cms::inst()->profil())
			{
				$this->identyfikatorFormularza = md5(Cms::inst()->profil()->id . time() . mt_rand());
			}
			else
			{
				$this->identyfikatorFormularza = md5(time() . mt_rand());
			}
		}

		return $this->identyfikatorFormularza;
	}


	/**
	 * Zwraca identyfikator formularza. Jeżeli nie został wcześniej wygenerowany
	 * to wygeneruje nowy identyfikator dla formularza.
	 *
	 * @return string
	 */
	public function pobierzIdentyfikatorFormularza()
	{
		return $this->generujIdentyfikatorFormularza();
	}



	/**
	 * Generuje i zwraca token formularza przechowywany w sesji.
	 * Zabezpieczenie przed atakami.
	 *
	 * @return string
	 */
	private function generujToken()
	{
		if ($this->sesja instanceof Sesja)
		{
			if (!is_array($this->sesja->tokenyFormularzy))
			{
				$this->sesja->tokenyFormularzy = array();
			}
			// token generowany tylko jezeli nie byl generowany wczesniej
			if (array_key_exists($this->nazwa, $this->sesja->tokenyFormularzy))
			{
				//Kasowanie juz raz uzutego tokena
				//unset($this->sesja->tokenyFormularzy[$this->nazwa]);
				$token = $this->sesja->tokenyFormularzy[$this->nazwa];
			}
			else
			{
				$token = md5(rand());
				$tokenyFormularzy = $this->sesja->tokenyFormularzy;
				$tokenyFormularzy[$this->nazwa] = $token;
				$this->sesja->tokenyFormularzy = $tokenyFormularzy;
			}
		}
		else
		{
			$token = md5(rand());
		}
		return $token;
	}



	/**
	 * Sprawdza unikalny token odpowiadający za ochrone formularz przed atakami.
	 *
	 * @return boolean
	 */
	function tokenPoprawny()
	{
		static $blad = false;

		if ($this->sesja instanceof Sesja)
		{
			if (is_array($this->sesja->tokenyFormularzy)
			&& array_key_exists($this->nazwa, $this->sesja->tokenyFormularzy)
			&& ($this->sesja->tokenyFormularzy[$this->nazwa] == Zadanie::pobierz("__token")))
			{
				return true;
			}
			else
			{
				if (!$blad)
				{
					trigger_error("Brak lub nieprawidlowy token dla formularza ". $this->nazwa, E_USER_NOTICE);
					$blad = true;
				}

				return false;
			}
		}
		else
		{
			return true;
		}
	}



	/**
	 * Sprawdza czy dane w formularzu są poprawne
	 *
	 * @return boolean
	 */
	function danePoprawne()
	{
		$wynik = true;
		foreach ($this->pola as $input)
		{
			if ($input instanceof Input && !$input->poprawny())
			{
				$wynik = false;
			}
		}

		return $wynik;
	}

    public function zapisz(ObiektDanych $obiekt):bool
    {
        $wartosci = $this->pobierzZmienioneWartosci();

        foreach ($wartosci as $klucz => $wartosc) {

            if (key_exists($klucz, $obiekt->definicjaObiektu->polaObiektuTypy))
            {
                $obiekt->$klucz = $wartosc;
            }

        }
        $className = get_class($obiekt);

        $reflection_class = new \ReflectionClass($className);
        $namespace = $reflection_class->getNamespaceName().'\Mapper';
        $mapper = new $namespace();

        return $obiekt->zapisz($mapper);
    }

	/**
	 * Zwraca tablice z wszystkimi wartosciami inputow.
	 *
	 * @return array
	 */
	function pobierzWartosci()
	{
		$wartosci = array();

		foreach ($this->pola as $input)
		{
			if ($input instanceof Input && $input->pobierzWartosc() !== null)
			{
				$wartosci[$input->pobierzNazwe()] = $input->pobierzWartosc();
			}
		}

		//Sprawdzenie czy uzywac sesji do zapamietywania i odtwarzania wartosci z formularza.
		if($this->wartosciSesja == true && $this->wypelniony() == false)
		{
			if(isset($this->sesja->wartosciFormularzy[$this->nazwa]))
				$wartosci = $this->sesja->wartosciFormularzy[$this->nazwa];
		}
		else
		{
			$this->sesja->wartosciFormularzy[$this->nazwa] = $wartosci;
		}
/*		if ($this->sesja instanceof Sesja && isset($this->sesja->tokenyFormularzy[$this->nazwa]))
		{
			unset($this->sesja->tokenyFormularzy[$this->nazwa]);
		}
*/
		return $wartosci;
	}



	/**
	 * Zwraca tablice ze zmodyfikowanymi wartosciami inputow.
	 *
	 * @return array
	 */
	function pobierzZmienioneWartosci()
	{
		$wartosci = array();
		
		foreach($this->pola as $input)
		{
			if ($input instanceof Input && $input->zmieniony() && $input->pobierzWartosc() !== null)
			{
				$wartosci[$input->pobierzNazwe()] = $input->pobierzWartosc();
			}
		}

		/*
		 * Sprawdzenie czy uzywac sesji do zapamietywania i odtwarzania wartosci z formularza.
		 */
		if($this->wartosciSesja == true && $this->wypelniony() == false)
		{
			if(isset($this->sesja->wartosciFormularzy[$this->nazwa]))
				$wartosci = $this->sesja->wartosciFormularzy[$this->nazwa];
		}
		else
		{
			$this->sesja->wartosciFormularzy[$this->nazwa] = $wartosci;
		}

/*		if ($this->sesja instanceof Sesja && isset($this->sesja->tokenyFormularzy[$this->nazwa]))
		{
			unset($this->sesja->tokenyFormularzy[$this->nazwa]);
		}
*/		return $wartosci;
	}



	/**
	 * Sprawdza czy dane w formularzu zostały zmienione
	 *
	 * @return boolean
	 */
	function zmieniony()
	{
		foreach($this->pola as $input)
		{
			if ($input instanceof Input && $input->zmieniony() && $input->pobierzWartosc() !== null)
			{
				return true;
			}
		}
		return false;
	}


	/**
	 * Przywraca początkowe wartości wszystkich pól
	 *
	 * @return bool
	 */
	function resetuj()
	{
		foreach ($this->pola as $input)
		{
			/* @var $input \Generic\Biblioteka\Input */
			if (!$input instanceof Input)
				continue;
			
			$input->ustawWartosc($input->pobierzWartoscPoczatkowa(), true);
		}
		if (isset($this->sesja->wartosciFormularzy[$this->nazwa]))
			$this->sesja->wartosciFormularzy[$this->nazwa] = $this->pobierzWartosci();

		return false;
	}



	/**
	 * Zwraca treść html formularza
	 *
	 * @param string $plikSzablonu plik szablonu
	 *
	 * @return string
	 */
	function html($szablon = '', $szablonTresc = false, $dolaczJS = true, $szablonSzukaj = false)
	{
		$html = '';
		$formularz_wypelniony = $this->wypelniony();

		if ( ! $szablonTresc)
		{
			$szablon = ($szablon != '') ? $szablon : CMS_KATALOG.'/' . SZABLON_SYSTEM . '/'.SZABLON_FORMULARZ;
			$szablon = Plik::pobierzTrescPliku($szablon);
		}

		$formularz = new Szablon();
		$formularz->ladujTresc($szablon);

		if($this->wartosciSesja == true)
		{
			foreach ($this->pola as $nazwa => $input)
			{
				if($input instanceof Input && ! isset($this->sesja->wartosciFormularzy[$this->nazwa][$input->pobierzNazwe()]) || is_array($input)) continue;
				$input->ustawWartosc($this->sesja->wartosciFormularzy[$this->nazwa][$input->pobierzNazwe()]);
			}
		}
		$formularz->ustawBlok('/formularz_start', array(
			'akcja' => $this->akcja,
			'typ' => $this->typ,
			'nazwa' => $this->nazwa,
			'metoda' => $this->metoda,
			'etykieta_wymagane_pola' => isset($this->tlumaczenia['etykieta_wymagane_pola']) ? $this->tlumaczenia['etykieta_wymagane_pola'] : '',
		));
		if ($dolaczJS)
		{
			$formularz->ustawBlok('/formularz_start/formularz_js', array('nazwa' => $this->nazwa,));
		}
		if ($this->sesja instanceof Sesja)
		{
			$formularz->ustawBlok('/formularz_start/token', array('token' => $this->generujToken()));
		}

		$formularz->ustawBlok('/formularz_start/identyfikatorFormularza', array('id' => $this->generujIdentyfikatorFormularza()));

		if (count($this->zakladki) == 0)
		{
			$formularz->ustawBlok('/formularz_start/brak_zakladek', array());
		}

		$nr_etykiety_zakladki = 0;
		if (count($this->zakladki) > 0)
		{
			$formularz->ustawBlok('/formularz_start/zakladki', array());
			foreach ($this->zakladki as $zakladka)
			{
				$zakladka_klasa = ($nr_etykiety_zakladki == 0) ? 'active' : null;

				$nr_etykiety_zakladki ++;

				$formularz->ustawBlok('/formularz_start/zakladki/zakladka_label', array(
					'zakladka_nazwa' => $zakladka['nazwa'],
					'zakladka_etykieta' => $zakladka['etykieta'],
					'zakladka_klasa' => $zakladka_klasa,
				));
			}
		}
		
		if ($dolaczJS  && $szablonSzukaj)
		{
			$html .= $formularz->parsujBlok('/formularz_js');
		}
		
		$html .= $formularz->parsujBlok('/formularz_start');

		$nr_zakladki = 0;
		$aktywny_zbiorowy = array();

		foreach ($this->pola as $nazwa => $input)
		{
			if ($input instanceof Input && !($input instanceof Input\Hidden))
			{
				if (count($aktywny_zbiorowy) > 0)
				{
					$aktywny_zbiorowy['pola'][] = $input;
					continue;
				}

				$blad = ($input->sprawdzony()) ? $input->pobierzBladWalidacji() : null;
				$klasa = ($formularz_wypelniony && $blad != null) ? 'input_blad error' : 'input_ok';

				if ($input->pobierzEtykiete() != '' || $input->pobierzOpis() != '')
				{
					$formularz->ustawBlok('/input/etykieta', array(
						'etykieta' => $input->pobierzEtykiete(),
						'opis' => $input->pobierzOpis(),
						'wymagany' => $input->wymagany,
						'nazwa' => $input->pobierzNazwe(),
						'klasa' => $klasa,
					));
				}
				if ($input->pobierzOpis() != '')
				{
					$formularz->ustawBlok('/input/opisBuble', array(
						'opis' => $input->pobierzOpis(),
						'wymagany' => $input->wymagany,
						'nazwa' => $input->pobierzNazwe(),
						'klasa' => $klasa,
					));
				}

				if ($formularz_wypelniony && $blad != null)
				{
					$formularz->ustawBlok('/input/blad', array('tresc' => $blad));
				}

				$html .=  $formularz->parsujBlok('/input', array(
					'nazwa' => $input->pobierzNazwe(),
					'opis' => $input->pobierzOpis(),
					'html' => $input->pobierzHtml(),
					'klasa' => $klasa . ($input->pobierzEtykiete() == '' ? ' no-label' : ''),
				));
			}
			else if (stripos($nazwa, '__pole__html__') !== false)
			{
				$html .= $formularz->parsujBlok('/pole_html', array('tresc' => $input));
			}
			else if (stripos($nazwa, '__zakladka__start__') !== false)
			{
				$atrybuty = ($nr_zakladki != 0) ? '' : null;

				$nr_zakladki++;
				$html .= $formularz->parsujBlok('/zakladka_start', array(
					'zakladka_nazwa' => $input['nazwa'],
					'zakladka_etykieta' => $input['etykieta'],
					'zakladka_tresc_atrybuty' => $atrybuty
				));
			}
			else if (stripos($nazwa, '__zakladka__stop__') !== false)
			{
				$html .= $formularz->parsujBlok('/zakladka_stop', array('zakladka_nazwa' => $input['nazwa']));
			}
			else if (stripos($nazwa, '__region__start__') !== false)
			{
				$html .=  $formularz->parsujBlok('/region_start', array(
					'region_nazwa' => $input['nazwa'],
					'region_etykieta' => $input['etykieta'],
					'region_klasa' => $input['klasa'],
					'region_zamkniety' => (int)(bool)!$input['otwarty'],
					'etykieta_region_zwin_rozwin' => $this->tlumaczenia['etykieta_region_zwin_rozwin'],
				));
			}
			else if (stripos($nazwa, '__region__stop__') !== false)
			{
				$html .= $formularz->parsujBlok('/region_stop', array('region_nazwa' => $input['nazwa']));
			}
			else if (stripos($nazwa, '__zbiorowy__start__') !== false)
			{
				$aktywny_zbiorowy = $input;
			}
			else if (stripos($nazwa, '__zbiorowy__stop__') !== false)
			{
				$uklad = ($aktywny_zbiorowy['pionowy']) ? 'pionowy' : 'poziomy';
				$wymagany = false;

				$formularz->ustawBlok('/input_zbiorowy/'.$uklad, array(
					'klasa' => $aktywny_zbiorowy['klasa'],
					'nazwa' => $nazwa,
				));

				foreach ($aktywny_zbiorowy['pola'] as $input)
				{
					$klasa = 'input_ok';
					if ($input->wymagany) $wymagany = true;
					$blad = ($input->sprawdzony()) ? $input->pobierzBladWalidacji() : null;

					if ($formularz_wypelniony && $blad != null)
					{
						$klasa = 'input_blad';
					}

					$formularz->ustawBlok('/input_zbiorowy/'.$uklad.'/pole', array(
						'html' => $input->pobierzHtml(),
						'klasa' => $klasa,
						'brakEtykiety' => $input->pobierzEtykiete() == '' ? true : false,
					));

					if ($input->pobierzEtykiete() != '' || $input->pobierzOpis() != '')
					{
						$formularz->ustawBlok('/input_zbiorowy/'.$uklad.'/pole/etykieta', array(
							'etykieta' => $input->pobierzEtykiete(),
							'wymagany' => $input->wymagany,
							'nazwa' => $input->pobierzNazwe(),
							'opis' => $input->pobierzOpis(),
						));
					}

					if ($input->pobierzOpis() != '')
					{
						$formularz->ustawBlok('/input_zbiorowy/'.$uklad.'/pole/opis', array(
							'opis' => $input->pobierzOpis(),
							'wymagany' => $input->wymagany,
							'nazwa' => $input->pobierzNazwe(),
						));
					}

					if ($formularz_wypelniony && $blad != null)
					{
						$klasa = 'input_blad';
						$formularz->ustawBlok('/input_zbiorowy/'.$uklad.'/pole/blad', array('tresc' => $blad));
					}
				}

				if ($aktywny_zbiorowy['etykieta'])
				{
					$formularz->ustawBlok('/input_zbiorowy/etykieta', array(
						'etykieta' => $aktywny_zbiorowy['etykieta'],
						'wymagany' => $wymagany,
						'nazwa' => $aktywny_zbiorowy['nazwa'],
						'klasa' => $klasa,
					));

					$formularz->ustawBlok('/input_zbiorowy/'.$uklad.'/etykieta', array(
						'etykieta' => $aktywny_zbiorowy['etykieta'],
						'opis' => $aktywny_zbiorowy['opis'],
						'wymagany' => $wymagany,
						'nazwa' => $aktywny_zbiorowy['nazwa'],
						'klasa' => $klasa,
					));
				}

				if ($aktywny_zbiorowy['opis'])
				{
					$formularz->ustawBlok('/input_zbiorowy/opis', array(
						'opis' => $aktywny_zbiorowy['opis'],
						'wymagany' => $wymagany,
						'nazwa' => $aktywny_zbiorowy['nazwa'],
						'klasa' => $klasa,
					));

					$formularz->ustawBlok('/input_zbiorowy/'.$uklad.'/opis', array(
						'etykieta' => $aktywny_zbiorowy['etykieta'],
						'opis' => $aktywny_zbiorowy['opis'],
						'wymagany' => $wymagany,
						'nazwa' => $aktywny_zbiorowy['nazwa'],
						'klasa' => $klasa,
					));
				}

				$html .=  $formularz->parsujBlok('/input_zbiorowy', array(
					'nazwa' => $aktywny_zbiorowy['nazwa'],
					'klasa' => $aktywny_zbiorowy['klasa'],
				));

				$aktywny_zbiorowy = array();
			}
		}

		$zawartoscStopki = '';
		foreach ($this->stopka as $input)
		{
			$zawartoscStopki .= $input->pobierzHtml();
		}
		if ($zawartoscStopki != '')
		{
			$formularz->ustawBlok('/formularz_stop/stopka', array('input_html' => $zawartoscStopki));
		}

		foreach ($this->pola as $nazwa => $input)
		{
			if ($input instanceof Input\Hidden)
			{
				$html .= $input->pobierzHtml();
			}
		}

		if (count($this->zakladki) > 0)
		{
			$html .=  $formularz->ustawBlok('/formularz_stop/zakladki_stop');
		}

		$html .=  $formularz->parsujBlok('/formularz_stop');

		return $html;
	}



	/**
	 * Pobiera tablice z tlumaczeniami.
	 *
	 * @return array
	 */
	public function pobierzTlumaczenia()
	{
		$tlumaczenia = array();

		$klucz = $this->nazwa;

		foreach ($this->pola as $nazwaPola => $pole)
		{
			if ($pole instanceof Input)
			{
				foreach ($pole->pobierzTlumaczenia() as $kluczInput => $wartoscInput)
				{
					$tlumaczenia[$klucz.'.'.$kluczInput] = $wartoscInput;
				}
			}
			elseif (strpos($nazwaPola, 'zbiorowy__start__') !== false)
			{
				$nazwaPola = str_replace('__zbiorowy__start__', '', $nazwaPola);
				$tlumaczenia[$klucz.'.'.$nazwaPola.'.etykieta'] = $pole['etykieta'];
				$tlumaczenia[$klucz.'.'.$nazwaPola.'.opis'] = $pole['opis'];
			}
			elseif (strpos($nazwaPola, 'region__start__') !== false)
			{
				$nazwaPola = str_replace('__region__start__', '', $nazwaPola);
				$tlumaczenia[$klucz.'.'.$nazwaPola.'.region'] = $pole['etykieta'];
			}
			elseif (strpos($nazwaPola, 'zakladka__start__') !== false)
			{
				$nazwaPola = str_replace('__zakladka__start__', '', $nazwaPola);
				$tlumaczenia[$klucz.'.'.$nazwaPola.'.zakladka'] = $pole['etykieta'];
			}
		}
		foreach ($this->stopka as $nazwaPola => $pole)
		{
			foreach ($pole->pobierzTlumaczenia() as $kluczInput => $wartoscInput)
			{
				$tlumaczenia[$klucz.'.'.$kluczInput] = $wartoscInput;
			}
		}
		foreach ($this->tlumaczenia as $kluczWew => $wartosc)
		{
			$tlumaczenia[$klucz.'.'.$kluczWew] = $wartosc;
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
				if (isset($this->pola[$klucz]) && $this->pola[$klucz] instanceof Input)
				{
					$this->pola[$klucz]->ustawTlumaczenia($wartosc);
				}
				elseif (isset($this->pola['__region__start__'. $klucz]))
				{
					$this->pola['__region__start__'. $klucz]['etykieta'] = $wartosc['region'];
				}
				elseif (isset($this->pola['__zbiorowy__start__'. $klucz]))
				{
					$this->pola['__zbiorowy__start__'. $klucz] = array_merge($this->pola['__zbiorowy__start__'. $klucz], $wartosc);
				}
				elseif (isset($this->pola['__zakladka__start__'. $klucz]))
				{
					$this->pola['__zakladka__start__'. $klucz]['etykieta'] = $wartosc['zakladka'];
					foreach ($this->zakladki as $numer => $zakladka)
					{
						if ($zakladka['nazwa'] == $klucz)
							 $this->zakladki[$numer]['etykieta'] = $wartosc['zakladka'];
					}
				}
				elseif (isset($this->stopka[$klucz]) && $this->stopka[$klucz] instanceof Input)
				{
					$this->stopka[$klucz]->ustawTlumaczenia($wartosc);
				}
				else
				{
					$this->tlumaczenia[$klucz] = $wartosc;
				}
			}
			return true;
		}
		return false;
	}


	/**
	 * Ustawia pola formularza przechowywane w sesji
	 */
	public function ustawPola()
	{
		if (isset(Cms::inst()->sesja->polaFormularzy[$this->nazwa]))
			$this->pola = unserialize(Cms::inst()->sesja->polaFormularzy[$this->nazwa]);
		else
			trigger_error('Brak pol do ustawienia w formularzu.', E_USER_NOTICE);
	}



	/**
	 * Definiowana w interfejsie Iterator
	 *
	 * @return mixed
	 */
	public function current()
	{
		return current($this->pola);
	}



	/**
	 * Definiowana w interfejsie Iterator
	 *
	 * @return mixed
	 */
	public function key()
	{
		return key($this->pola);
	}



	/**
	 * Definiowana w interfejsie Iterator
	 */
	public function next()
	{
		$i = 0;
		do
		{
			next($this->pola);
			$i++;
		}
		while (!(current($this->pola) instanceof Input) && $i < $this->polaIlosc);
		$this->polaKursor++;
	}



	/**
	 * Definiowana w interfejsie Iterator
	 */
	public function rewind()
	{
		reset($this->pola);
		$i = 0;
		while (!(current($this->pola) instanceof Input) && $i < $this->polaIlosc)
		{
			next($this->pola);
			$i++;
		}
		$this->polaKursor = 0;
	}



	/**
	 * Definiowana w interfejsie Iterator
	 *
	 * @return boolean
	 */
	public function valid()
	{
		return $this->polaKursor < $this->polaIlosc;
	}


	/**
	 * Destruktor
	 *
	 * Przechowuje zserializowane pola formularza w przypadku gdy zostal on przeslany do innego modulu i akcji
	 * Pewnie to sie Krzyskowi nie spodoba dlatego narazie zakomentowalem:)
	 */
//	function __destruct()
//	{
//		if ($this->akcja !== '')
//			Cms::inst()->sesja->polaFormularzy[$this->nazwa] = serialize($this->pola);
//	}

}

class FormularzWyjatek extends \Exception {}


