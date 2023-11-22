<?php
namespace Generic\Biblioteka\Zdarzenia;

/**
 * Obiekt zdarzenia odpowiedzialny za zachowanie sie zdarzenia
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Zdarzenie
{

	/**
	 * Przetrzymuje etykiety obiektow i odpowiadajace im klasy
	 * @var string
	 */
	protected $kod;


	/**
	 * Tabela danych
	 * @var array
	 */
	protected $dane = array();


	/**
	 * Przetrzymuje etykiety obiektow i odpowiadajace im klasy
	 * @var array
	 */
	protected $daneWymagane = array();


	/**
	 * Przetrzymuje etykietę obiektu głównego
	 * @var string
	 */
	protected $etykietaObiektuGlownego = '';


	/**
	 * Przetrzymuje token prcesu do jakiego należy zdarzenie
	 * @var string
	 */
	protected $tokenProcesu = '';


	/**
	 * Obiekt w ktorym zostalo utworzone zdarzenie
	 * @var object
	 */
	protected $zrodlo;



	public function ustawKod($kod)
	{
		$this->kod = (string)$kod;
	}



	public function pobierzKod()
	{
		return $this->kod;
	}



	/**
	 * Wypelnia wewnetrna tablice danymi zaladowanymi potrzebnymi obslugi do zdarzenia
	 * Podczas ustawiania dane sa sprawdzane pod katem wymaganych pol i ich typow
	 * @param array $dane
	 */
	public function ustawDane(Array $dane)
	{
		foreach ($this->daneWymagane as $etykieta => $typ)
		{
			if (isset($dane[$etykieta]))
			{
				$wartosc = $dane[$etykieta];
				if (substr($etykieta, 0, 7) == 'obiekt_')
				{
					if ( ! $wartosc instanceof $typ) trigger_error("Nieprawidlowy typ pola $etykieta w danych przekazanych do zdarzenia", E_USER_WARNING);
				}
				else
				{
					if (gettype($wartosc) != $typ) trigger_error("Nieprawidlowy typ pola $etykieta w danych przekazanych do zdarzenia", E_USER_WARNING);
				}
			}
			else
			{
				trigger_error("Brak wymaganego pola $etykieta w danych przekazanych do zdarzenia", E_USER_WARNING);
			}
		}
		$this->dane = $dane;
	}



	/**
	 * Zwraca tablice z danymi zaladowanymi do zdarzenia
	 * @return array
	 */
	public function pobierzDane()
	{
		return $this->dane;
	}



	/**
	 * Zwraca tablice z wymaganymi danymi zdarzenia
	 * @return array
	 */
	public function pobierzDaneWymagane()
	{
		return $this->daneWymagane;
	}



	/**
	 * Zwraca etykietę obiektu głównego
	 * @return string
	 */
	public function pobierzEtykietaObiektuGlownego()
	{
		return $this->etykietaObiektuGlownego;
	}



	/**
	 * Ustawia obiekt zdrodla z ktorego wywolano zdarzenie
	 * @param object $zrodlo
	 */
	public function ustawZrodlo($zrodlo)
	{
		$this->zrodlo = $zrodlo;
	}



	/**
	 * Zwraca obiekt zdrodla
	 * @return object
	 */
	public function pobierzZrodlo()
	{
		return $this->zrodlo;
	}


	public function ustawTokenProcesu($token)
	{
		$this->tokenProcesu = (string)$token;
	}



	public function pobierzTokenProcesu()
	{
		return $this->tokenProcesu;
	}

}
