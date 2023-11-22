<?php
namespace Generic\Biblioteka\Router;


/**
 * Klasa filtrowanie parametrow w adresie url
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class FiltrParametry
{

	/**
	 * Tablica przetrzymujaca tlumaczenia parametrow na ich odpowiedniki w adresie url
	 *
	 * @var array
	 */
	protected $slownik = array();


	/**
	 * Tablica przetrzymujaca tlumaczenia odpowiedników w adresie url na parametry
	 *
	 * @var array
	 */
	protected $slownikOdwrotny = array();


	/**
	 * Tablica przetrzymujaca parametry ktore maja sie znalezc w adresie url
	 * Uwaga!!! Kolejnosc decyduje o kolejnosci wyswietlania w sciezce
	 * @var string
	 */
	protected $parametrySciezka = array();



	/**
	 * Ustawia podstawowe parametry filtru
	 *
	 * @param string $rodzaj Wybrany rodzaj sortowania (zbiór kolumn)
	 * @param string $porzadek Wybrany porządek sortowania (rosnace lub malejace)
	 */
	public function __construct(Array $slownik = array(), Array $parametrySciezka = array())
	{
		$this->ustawSlownik($slownik);
		$this->ustawParametrySciezka($parametrySciezka);
	}



	/**
	 * Ustawia tablice zawierajaca tlumaczenia parametrow na ich odpowiedniki w adresie url
	 * @param array $slownik
	 */
	public function ustawSlownik(Array $slownik = array())
	{
		$this->slownik = $slownik;
		$this->slownikOdwrotny = array_flip($this->slownik);
	}



	/**
	 * Zwraca tablice zawierajaca tlumaczenia parametrow na ich odpowiedniki w adresie url
	 * @return array
	 */
	public function pobierzSlownik()
	{
		return $this->slownik;
	}



	/**
	 * Ustawia kolumny które maja zostac wpisane jako parametry w sciezce adresu url
	 * Uwaga!!! Kolejnosc decyduje o kolejnosci wyswietlania w sciezce
	 * @param array|string $parametrySciezka tablica parametrow lub kolejne parametry podawana po sobie
	 */
	public function ustawParametrySciezka(Array $parametrySciezka = array())
	{
		$parametrySciezka = is_array($parametrySciezka) ? $parametrySciezka : func_get_args();
		$this->parametrySciezka = array_unique($parametrySciezka);
	}



	/**
	 * Zwraca kolumny które maja zostac wpisane jako parametry w sciezce adresu url
	 * @return array
	 */
	public function pobierzParametrySciezka()
	{
		return $this->parametrySciezka;
	}



	/**
	 * Tlumaczy parametry na ciag tekstowy zapisany w sciezce
	 * @param array $parametry
	 * @param string $separator
	 * @param string $separatorNazwy
	 * @return string
	 */
	public function tworzSciezke(Array $parametry, $separator = ',', $separatorNazwy = '.')
	{
		$wartosci = array();
		$nazwy = array();

		foreach ($this->parametrySciezka as $nazwa)
		{
			if (array_key_exists($nazwa, $parametry))
			{
				$wartosc = trim($parametry[$nazwa]);
				if ($wartosc == '') continue;

				$wartosci[] = $wartosc;
				$nazwy[] = trim($this->tlumaczNazwe($nazwa));
			}
		}
		$wartosci[] = implode($separatorNazwy, $nazwy);

		return implode($separator, $wartosci);
	}



	/**
	 * Analizuje sciezke i tworzy tablice parametrow
	 * @param string $sciezka
	 * @param string $separator
	 * @param string $separatorNazwy
	 * @return array
	 */
	public function analizujSciezke($sciezka, $separator = ',', $separatorNazwy = '.')
	{
		$wartosci = explode($separator, $sciezka);
		$nazwy = explode($separatorNazwy, array_pop($wartosci));

		$parametry = array();
		if (count($wartosci) > 0 && count($nazwy) > 0
			&& count($wartosci) == count($nazwy))
		{
			foreach ($nazwy as $nr => $nazwa)
			{
				$nazwa = $this->tlumaczNazwe($nazwa, true);

				$parametry[$nazwa] = trim($wartosci[$nr]);
			}
		}

		return $parametry;
	}



	/**
	 * Tlumaczy nazwe przy uzyciu slownika
	 * @param string $nazwa Nazwa do przetlumaczenia
	 * @param  boolean $odwrotne Tlumaczenie odwrotne
	 * @return string
	 */
	public function tlumaczNazwe($nazwa, $odwrotne = false)
	{
		$slownik = ($odwrotne) ? $this->slownikOdwrotny : $this->slownik;

		if (array_key_exists($nazwa, $slownik))
		{
			return $slownik[$nazwa];
		}
		else
		{
			return $nazwa;
		}
	}
}


