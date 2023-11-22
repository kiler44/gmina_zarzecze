<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka;
use Generic\Biblioteka\MapperWyjatek;
use Generic\Biblioteka\Cms;


/**
 * Klasa bazowa dla wszystkich obiektów przetrzymujących dane
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class ObiektDanych implements \IteratorAggregate
{

	/**
	 * Pola obslugiwane przez obiekt
	 *
	 * @var array
	 */
	protected $_pola = array();


	/**
	 * Tabela wartosci
	 *
	 * @var array
	 */
	protected $_wartosci = array();


	/**
	 * Nazwy zmodyfikowanych parametrów
	 *
	 * @var array
	 */
	protected $_zmodyfikowane = array();


	/**
	 * Zmienna przetrzymująca cache-owane obiekty
	 *
	 * @var array
	 */
	protected $_cache = array();


	/**
	 * Instancja obiektu definicji
	 *
	 * @var Generic\Biblioteka\DefinicjaObiektu
	 */
	public $definicjaObiektu = null;



	/**
	 * Ustawia wewnetrzna tablice z danymi na podstwie wiersza pobranego z bazy
	 *
	 * @param array $dane tablica z danymi pobranymi z bazy
	 */
	public function __construct($dane = array())
	{
		$nazwaKlasyBazowej = 'Generic\\Model\\'.$this->pobierzNazweObiektuBazowego();

		$this->definicjaObiektu = utworzObiektRaz($nazwaKlasyBazowej.'\\Definicja');

		if (!$this->definicjaObiektu instanceof DefinicjaObiektu)
		{
			throw new \Exception('Nie załadowano definicji dla obiektu: '.get_class($this), E_USER_ERROR);
		}
		else
		{
			$this->_pola = array_keys($this->definicjaObiektu->polaObiektuTypy);
			
			foreach ($this->definicjaObiektu->domyslneWartosci as $nazwa_pola => $wartosc_domyslna)
			{
				if (in_array($nazwa_pola, $this->_pola))
				{
					$this->_wartosci[$nazwa_pola] = $wartosc_domyslna;
					$this->_zmodyfikowane[] = $nazwa_pola;
				}
				else
				{
					trigger_error('Błąd ustawienia wartości domyślnej pola "'.$nazwa_pola.'" obiektu "'.get_class($this).'"', E_USER_WARNING);
				}
			}
		}

		if (is_array($dane) && count($dane) > 0)
		{
			$this->wypelnij($dane);
		}
	}



	/**
	 * Ustawia wewnetrzna tablice z danymi na podstwie wiersza pobranego z bazy
	 *
	 * @param array $dane tablica z danymi pobranymi z bazy
	 */
	public function wypelnij($dane = array())
	{
		// sprawdzanie spojnosci danych
		/**
		foreach ($dane as $parametr => $wartosc)
		{
			if (!in_array($parametr, $this->_pola))
			{
				trigger_error('Przekazano nieprawidlowy parametr \''.$parametr.'\' do obiektu '.get_class($this), E_USER_NOTICE);
			}
		}
		*/
		foreach ($this->_pola as $parametr)
		{
			if (array_key_exists($parametr, $dane))
			{
				$this->_wartosci[$parametr] = $dane[$parametr];
			}
			else
			{
				trigger_error('Brak klucza \''.$parametr.'\' w danych przekazanych obiektu '.get_class($this), E_USER_NOTICE);
			}
		}

		//$this->_wartosci = $dane;
		$this->_zmodyfikowane = array();
		$this->_cache = array();
	}



	/**
	 * Pobiera parametr z cacheu za pomoca zdeklarowanej metody typu "pobierzParametr" lub z wewnetrznej tablicy obiektu
	 *
	 * @param string $parametr nazwa pobieranego parametru
	 * @return mixed w zależnoci od tego czy parametr istnieje w wewnetrznej tablicy
	 */
	public function __get($parametr)
	{
		$definicjePolObiektu = $this->definicjaObiektu;

		if ( ! $definicjePolObiektu->_ochronaUprawnieniami || $definicjePolObiektu->saUprawnieniaDo($parametr . '_odczyt', $this) || $definicjePolObiektu->saUprawnieniaDo('wszystko_odczyt', $this))
		{
			if (array_key_exists($parametr, $this->_cache))
			{
				return $this->_cache[$parametr];
			}
			elseif (method_exists($this, "pobierz".$parametr))
			{
				if (array_key_exists($parametr, $this->_cache))
				{
					return $this->_cache[$parametr];
				}
				elseif (method_exists($this, "pobierz".$parametr))
				{
					// Wartosc pobierana przez metodę typu pobierzParametr
					$wartosc = $this->{'pobierz'.$parametr}();
					return $wartosc;
				}
				elseif (in_array($parametr, $this->_pola) && array_key_exists($parametr, $this->_wartosci) && isset($this->_wartosci[$parametr]))
				{
					return $this->_wartosci[$parametr];
				}
				if ( ! in_array($parametr, $this->_pola)) trigger_error('Nieznane pole: '.$parametr, E_USER_WARNING);
				return false;
			}
			elseif (array_key_exists($parametr, $definicjePolObiektu->polaObiektuTypy) && in_array($parametr, $this->_pola) && array_key_exists($parametr, $this->_wartosci) && isset($this->_wartosci[$parametr])) // Tutaj predefiniowane pola
			{
				switch ($definicjePolObiektu->polaObiektuTypy[$parametr])
				{
					case $definicjePolObiektu::_INTEGER:
						$wartosc = (int)$this->_wartosci[$parametr];
					break;
					case $definicjePolObiektu::_FLOAT:
						$wartosc = (float)$this->_wartosci[$parametr];
					break;
					case $definicjePolObiektu::_DOUBLE:
						$wartosc = (double)$this->_wartosci[$parametr];
					break;
					case $definicjePolObiektu::_STRING:
						$wartosc = (string)$this->_wartosci[$parametr];
					break;
					case $definicjePolObiektu::_BOOLEAN:
						$wartosc = (bool)$this->_wartosci[$parametr];
					break;
					case $definicjePolObiektu::_LIST:
						$tab = explode('|', $this->_wartosci[$parametr]);
						if (count($tab) > 2)
						{
							array_shift($tab);
							array_pop($tab);
						}
						$wartosc = $tab;
					break;
					case $definicjePolObiektu::_ARRAY:
						if (is_array($this->_wartosci[$parametr]))
						{
							$wartosc = $this->_wartosci[$parametr];
						}
						elseif (is_serialized($this->_wartosci[$parametr]))
						{
							$wartosc = unserialize($this->_wartosci[$parametr]);
						}
						else
						{
							$wartosc = $this->_wartosci[$parametr];
							trigger_error('Bład serializacji pola: '.$parametr.' dla obiektu: '.get_class($this), E_USER_WARNING);
						}
					break;
					case $definicjePolObiektu::_JSON:
						if(is_json($this->_wartosci[$parametr]))
						{
							$wartosc = json_decode($this->_wartosci[$parametr], true);
						}
						elseif($this->_wartosci[$parametr] == '' || $this->_wartosci[$parametr] == '[]' || $this->_wartosci[$parametr] == 'null' || $this->_wartosci[$parametr] == null )
						{
							$wartosc = null;
						}
						else
						{
							//dump($parametr);
							$wartosc = $this->_wartosci[$parametr];
							//var_dump($wartosc);
							trigger_error('Bład dekodowania pola: '.$parametr.' dla obiektu: '.get_class($this), E_USER_WARNING);
						}
					break;
					case $definicjePolObiektu::_DATETIME:
					 $wartosc = new \DateTime($this->_wartosci[$parametr]); 
					break;
					
					case $definicjePolObiektu::_MIXED:
						//Brak konwersji/rzutowania typów
						$wartosc = $this->_wartosci[$parametr];
					break;

					default:
						$wartosc = $this->_wartosci[$parametr];
					break;
				}

				return $wartosc;
			}
		}
		elseif (in_array($parametr, $this->_pola) && array_key_exists($parametr, $this->_wartosci) && isset($this->_wartosci[$parametr]))
		{

			if( isset($this->definicjaObiektu->domyslneWartosci[$parametr]))
			{
				return $this->definicjaObiektu->domyslneWartosci[$parametr];
			}
			elseif (isset($this->_wartosci[$parametr]) && is_array($this->_wartosci[$parametr]))
			{
				return array();
			}
			else
			{
				return null;
			}
		}

		if ( ! in_array($parametr, $this->_pola)) trigger_error('Nieznane pole: "'.$parametr.'" w obiekcie danych "'.get_class($this).'", porównaj deklarację pól oraz formularz.', E_USER_WARNING);
		return false;
	}



	/**
	 * Ustawia parametr w wewnetrznej tablicy obiektu
	 *
	 * @param string $parametr nazwa pobieranego parametru
	 * @param mixed $wartosc wartosc pobieranego parametru
	 */
	public function __set($parametr, $wartosc)
	{
		$definicjePolObiektu = $this->definicjaObiektu;
		
		if ( ! $definicjePolObiektu->_ochronaUprawnieniami || $definicjePolObiektu->saUprawnieniaDo($parametr . '_zapis', $this) || $definicjePolObiektu->saUprawnieniaDo('wszystko_zapis', $this))
		{
			
			if (method_exists($this, "ustaw".$parametr))
			{
				// Wartosc ustawiana przez metodę typu ustawParametr
				$wartosc = $this->{'ustaw'.$parametr}($wartosc);
			}
			elseif (array_key_exists($parametr, $definicjePolObiektu->polaObiektuTypy)) // Tutaj predefiniowane pola
			{
				switch ($definicjePolObiektu->polaObiektuTypy[$parametr])
				{
					case $definicjePolObiektu::_BOOLEAN:
						$this->_wartosci[$parametr] = $wartosc;
						break;
					case $definicjePolObiektu::_LIST:
						asort($wartosc);
						$this->_wartosci[$parametr] = '|'.implode('|', $wartosc).'|';
						break;
					case $definicjePolObiektu::_ARRAY:
						$this->_wartosci[$parametr] = serialize($wartosc);
						break;
					case $definicjePolObiektu::_DATETIME:
						$this->_wartosci[$parametr] = new \DateTime($wartosc->format('Y-m-d H:i:s'), new \DateTimeZone('Europe/Oslo'));
						break;
					case $definicjePolObiektu::_ENUM:
						if (isset($definicjePolObiektu->dopuszczalneWartosci[$parametr]))
						{
							$this->poleSprawdzUstawWartosc($parametr, $wartosc, $definicjePolObiektu->dopuszczalneWartosci[$parametr]);
						}
						else
						{
							throw new \Exception('Brak deklaracji dopuszczalnych wartości pola: "'.$parametr.'", dla pola typu ENUM w obiekcie '.get_class($definicjePolObiektu), E_USER_ERROR);
						}
						break;
					case $definicjePolObiektu::_JSON:
							$this->_wartosci[$parametr] = json_encode($wartosc);
					break;
					case $definicjePolObiektu::_MIXED:
						//Bez konwersji/rzutowania
						$this->_wartosci[$parametr] = $wartosc;
						break;

					default:
						$this->_wartosci[$parametr] = $wartosc;
						break;
				}
				if (!in_array($parametr, $this->_zmodyfikowane)) $this->_zmodyfikowane[] = $parametr;
			}
		}
		elseif (in_array($parametr, $this->_pola) && strtolower($parametr) != 'id')
		{
			if (method_exists($this, "ustaw".$parametr))
			{
				// Wartosc ustawiana przez metodę typu ustawParametr
				$wartosc = $this->{'ustaw'.$parametr}($wartosc);
			}
			elseif (in_array($parametr, $this->_pola) && strtolower($parametr) != 'id')
			{
				if (!in_array($parametr, $this->_zmodyfikowane)) $this->_zmodyfikowane[] = $parametr;

				$this->_wartosci[$parametr] = $wartosc;
			}
			else
			{
				trigger_error('Nie mozna ustwic parametru \''.$parametr.'\' dla obiektu '.get_class($this), E_USER_WARNING);
			}
		}
		else
		{
			trigger_error('Nie mozna ustwic parametru \''.$parametr.'\' dla obiektu '.get_class($this).'. Brak uprawnien.', E_USER_WARNING);
		}
	}


	/**
	 * Klonowanie obiektu.
	 */
	public function __clone()
	{
		unset($this->_wartosci['id']);
	}



	/**
	 * Iterator dla obiektu
	 *
	 * @return Iterator.
	 */
	function getIterator()
	{
		return new \ArrayIterator($this->_wartosci);
	}



	/**
	 * Przekazuje obiekt do zapisania w zrodle danych
	 *
	 * @return boolean
	 */
	public function zapisz(Biblioteka\Mapper\Interfejs $mapper)
	{
		try
		{
			$id = (isset($this->_wartosci['id'])) ? $this->_wartosci['id'] : '';
			if (array_key_exists('id', $this->_wartosci) && $this->_wartosci['id'] > 0)
			{
				$mapper->aktualizuj($this);
				$this->_zmodyfikowane = array();

				return true;
			}
			else
			{
				$this->_wartosci['id'] = $mapper->wstaw($this);
				$this->_zmodyfikowane = array();
				return true;
			}
		}
		catch (MapperWyjatek $wyjatek)
		{
			dump($wyjatek); die;
			return false;
		}
	}



	/**
	 * Usuwa obiekt ze zrodla danych i czyści zawartosc wewnetrznych zmiennych
	 *
	 * @return boolean
	 */
	public function usun(Biblioteka\Mapper\Interfejs $mapper)
	{
		try
		{
			if (array_key_exists('id', $this->_wartosci) && $this->_wartosci['id'] != '')
			{
				$mapper->usun($this);
				$this->_cache = array();
				$this->_wartosci = array();
				$this->_zmodyfikowane = array();
				return true;
			}
			else
			{
				return false;
			}
		}
		catch (MapperWyjatek $wyjatek)
		{
			//Cms::inst()->bledy->przechwycWyjatek($wyjatek);
			return false;
		}
	}



	/**
	 * Zwraca tablice z nazwami pol zmieninych podczas edycji obiektu.
	 *
	 * @return array
	 */
	public function zmodyfikowanePola()
	{
		return $this->_zmodyfikowane;
	}



	/**
	 * Zwraca tablice z polami i wartosciami pol obiektu.
	 *
	 * @return array
	 */
	public function daneDoZapisu()
	{
		return $this->_wartosci;
	}


	/**
	 * Zwraca instancje kontenera przechowującego mappery
	 *
	 * @return \Generic\Biblioteka\Kontener\Mappery
	 */

	public function dane()
	{
		return Cms::inst()->dane();
	}



	/**
	 * Ustawia wartosc pola wykonujac wczesniej sprawdzenie czy przypisywana wartosc znajduje sie na liscie dozwolonych
	 *
	 * @param string $nazwaPola Nazwa pola ktorego wartosc ustawiamy
	 * @param mixed $wartosc Ustawiana wartosc
	 * @param array $dozwoloneWartosci Lista dozwolonych wartosci dla tego pola
	 */
	protected function poleSprawdzUstawWartosc($nazwaPola, $wartosc, Array $dozwoloneWartosci)
	{
		if (in_array($wartosc, $dozwoloneWartosci))
		{
			$this->_wartosci[$nazwaPola] = $wartosc;
			if ( ! in_array($nazwaPola, $this->_zmodyfikowane)) $this->_zmodyfikowane[] = $nazwaPola;
		}
		else
		{
			trigger_error('Niedozwolona wartosc "'.$wartosc.'" pola '.$nazwaPola.' dla obiektu '.  get_class($this), E_USER_WARNING);
		}
	}



	/**
	 * Ustawia wartosc pola
	 *
	 * @param string $nazwaPola Nazwa pola ktorego wartosc ustawiamy
	 * @param mixed $wartosc Ustawiana wartosc
	 */
	protected function poleUstawWartosc($nazwaPola, $wartosc)
	{
		$this->_wartosci[$nazwaPola] = $wartosc;
		if ( ! in_array($nazwaPola, $this->_zmodyfikowane)) $this->_zmodyfikowane[] = $nazwaPola;
	}



	/**
	 * Ustawia elementy zserializowanej tablicy
	 *
	 * @param string $nazwaPola Nazwa pola ktorego wartosc ustawiamy
	 * @param array $wartosc  Elementy tablicy do zapisania
	 */
	protected function tablicaUstawWartosc($nazwaPola, Array $wartosc)
	{
		unset($wartosc['']);
		$this->_wartosci[$nazwaPola] = (count($wartosc) > 0) ? serialize($wartosc) : '';
		if ( ! in_array($nazwaPola, $this->_zmodyfikowane)) $this->_zmodyfikowane[] = $nazwaPola;
	}



	/**
	 * Zwraca elementy zserializowanej tablicy
	 *
	 * @param string $nazwaPola Nazwa pola ktorego wartosc pobieramy
	 * @return array
	 */
	protected function tablicaPobierzWartosc($nazwaPola)
	{
		return (isset($this->_wartosci[$nazwaPola]) && $this->_wartosci[$nazwaPola] != '') ? unserialize($this->_wartosci[$nazwaPola]) : array();
	}



	/**
	 * Ustawia elementy listy rozdzielonej znakiem
	 *
	 * @param string $nazwaPola Nazwa pola ktorego wartosc pobieramy
	 * @param array $wartosc Elementy listy do zapisania
	 * @param string $znakRozdzielajacy Znak rozdzielajacy kolejne elementy listy
	 */
	protected function listaUstawWartosc($nazwaPola, Array $wartosc, $znakRozdzielajacy)
	{
		$this->_wartosci[$nazwaPola] = (count($wartosc) > 0) ? implode($znakRozdzielajacy, $wartosc) : '';
		if (!in_array($nazwaPola, $this->_zmodyfikowane)) $this->_zmodyfikowane[] = $nazwaPola;
	}



	/**
	 * Zwraca w postaci tablicy elementy listy rozdzielonej znakiem
	 *
	 * @param string $nazwaPola Nazwa pola ktorego wartosc pobieramy
	 * @param string $znakRozdzielajacy Znak rozdzielajacy kolejne elementy listy
	 * @return array
	 */
	protected function listaPobierzWartosc($nazwaPola, $znakRozdzielajacy)
	{
		return (isset($this->_wartosci[$nazwaPola]) && $this->_wartosci[$nazwaPola] != '') ? explode($znakRozdzielajacy, $this->_wartosci[$nazwaPola]) : array();
	}


	/**
	 * Metoda wyłuskuje nazwę obiektu w obrębie jakiego działamy
	 *
	 * @return string
	 */
	protected function pobierzNazweObiektuBazowego()
	{
		$chunks = explode('\\', get_class($this));
		return $chunks[count($chunks)-2];
	}

	/**
	 * Metoda zwraca tablicę z polami zdefiniowanego dla obiektu formularza
	 *
	 * @return array
	 */
	public function pobierzPolaFormularza()
	{
		return $this->definicjaObiektu->formularz;
	}


	public function pobierzTlumaczeniaObiektu()
	{
		$namespaceTlumaczenia = '\\Generic\\Tlumaczenie\\'.ucfirst(KOD_JEZYKA_ITERFEJSU).'\\Model';
		$tlumaczenie = utworzObiektRaz($namespaceTlumaczenia.'\\'.$this->pobierzNazweObiektuBazowego());
		return $tlumaczenie;
	}
	
	
	/**
	 * Ustawia tlumaczenia startowe dla obiektu.
	 */
	public function ladujTlumaczenia()
	{
		$mapper = new \Generic\Model\WierszTlumaczen();
		
		$tlumaczenia = $mapper->zwracaTablice()->pobierzDlaModulu($this->pobierzNazweModulu(), $this->kategoria->id, null, KOD_JEZYKA_ITERFEJSU);
		
		$this->ustawTlumaczenia($mapper->przetworzNaListe($tlumaczenia));
		$this->j->ustawTlumaczenia($mapper->przetworzNaListe($tlumaczenia));
	}
	
	/**
	 * Ustawia nowe tlumaczeniami dla modulu.
	 *
	 * @param array $tlumaczenia Tablica z tlumaczeniami dla modulu.
	 */
	public function ustawTlumaczenia($tlumaczenia = array())
	{
		$this->t = array_merge($this->t, $tlumaczenia);
	}
	

	public function pobierzWartoscPola($pole)
	{
		return $this->_wartosci[$pole];
	}
	
	public function pobierzDozwoloneWartosciPola($pole)
	{
		return $this->definicjaObiektu->dopuszczalneWartosci[$pole];
	}

	public function toArray()
    {
        return ($this->_wartosci);
    }
}

class ObiektDanychWyjatek extends \Exception {}
