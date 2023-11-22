<?php
namespace Generic\Biblioteka;


/**
 * Klasa bazowa dla kontenerów.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Kontener
{

	/**
	 * Przetrzymuje instance obiektów.
	 *
	 * @var array
	 */
	protected $instancje = array();



	/**
	 * Pobiera instancję obiektu podanej klasy.
	 *
	 * @param string $nazwaKlasy Nazwa kalsy której instancją ma być zwracany obiekt.
	 *
	 * @return object
	 */
	public function pobierz($nazwaKlasy)
	{
		if ( ! isset($this->instancje[$nazwaKlasy]))
		{
			$this->ustaw($nazwaKlasy);
		}
		return $this->instancje[$nazwaKlasy];
	}



	/**
	 * Usuwa instancję obiektu podanej klasy.
	 *
	 * @param string $nazwaKlasy Nazwa klasy której instancją ma być zwracany obiekt.
	 *
	 * @return boolean
	 */
	public function usun($nazwaKlasy)
	{
		unset($this->instancje[$nazwaKlasy]);
		return isset($this->instancje[$nazwaKlasy]);
	}



	/**
	 * Dodaje instancję obiektu żądanej klasy do wewnętrznej tablicy obiektów.
	 *
	 * @param string $nazwaKlasy Nazwa klasy której instancją ma być tworzony obiekt.
	 */

	protected function ustaw($nazwaKlasy)
	{
		$this->instancje[$nazwaKlasy] = new $nazwaKlasy;
	}



	/**
	 * Sprawdza czy kontener jest pusty
	 *
	 * @return boolean
	 */
	public function czyPusty()
	{
		return (count($this->instancje) == 0);
	}



	/**
	 * Sprawdza, czy istnieje obiekt o podanej nazwie
	 *
	 * @param string $nazwa Nazwa która ma być sprawdzona.
	 *
	 * @return boolean
	 */
	public function czyIstnieje($nazwa)
	{
		return isset($this->instancje[$nazwa]);
	}



	public function sprawdz()
	{
		echo implode(', ', array_keys($this->instancje));
	}
}
