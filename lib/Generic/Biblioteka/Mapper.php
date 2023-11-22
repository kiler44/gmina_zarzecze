<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\ObiektDanych;
use Generic\Biblioteka\MapperWyjatek;
use Generic\Biblioteka\Cms;


/**
 * Abstrakcyjna klasa odpowiedzialna za pobieranie i zapisywanie danych do zrodla danych
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Mapper
{

	/**
	 * Okresla czy zwracac wynik jako tablice czy jako obiekt
	 */
	const ZWRACA_TABLICE = true;


	/**
	 * Okresla typ wyniku(tablica lub obiekt)
	 *
	 * @var boolean
	 */
	protected $zwracaTablice = false;


	/**
	 * Okresla kolumny ktore maja byc zwracane jezeli $zwracaTablice = true
	 * Jezeli zmienna pusta to zwraca wszystkie kolumny
	 *
	 * @var array
	 */
	protected $zwracaneKolumnyTablicy = array();


	/**
	 * Okresla nazwe klasy tworzonego obiektu
	 *
	 * @var string
	 */
	protected $zwracanyObiekt = '';


	/**
	 * Instancja klasy tworzonego obiektu
	 *
	 * @var ObiektDanych
	 */
	protected $_instancja;


	/**
	 * Instancja obiektu definicji
	 *
	 * @var Generic\Biblioteka\DefinicjaObiektu
	 */
	protected $definicjaObiektu = null;



	/**
	 * Konstruktor ustawia typ zwracanego obiektu i ładuje definicje dla tegoż obiektu
	 *
	 * @param boolean $zwracaTablice Czy wynik ma byc zwracany w postaci tablicy czy standardowo w postaci obiektu
	 */
	public function __construct(bool $zwracaTablice = false)
	{
		$this->zwracaTablice = $zwracaTablice;

		$nazwaKlasyBazowej = $this->pobierzNazweObiektuBazowego();

		// Jeśli nie zdefiniujesz w Mapperze jaki obiekt ma być zwracany to zostanie pobrany automatycznie, KL albo i nie
		$klasaObiektu = $nazwaKlasyBazowej.'\Obiekt';//($this->zwracanyObiekt != '') ? $this->zwracanyObiekt : $this->pobierzNazweObiektuBazowego().'\Obiekt';
		$klasaDefinicji = $nazwaKlasyBazowej.'\Definicja';

		$this->definicjaObiektu = (class_exists($klasaDefinicji)) ? new $klasaDefinicji : null;

		if (!$this->zwracaTablice)
		{
			if (class_exists($klasaObiektu))
			{
				$this->zwracanyObiekt = $klasaObiektu;
				$this->_instancja = new $klasaObiektu;
			}
			else
			{
				trigger_error('Brak obiektu danych \''.$klasaObiektu.'\'', E_USER_ERROR);
			}
		}

	}


	/**
	 * Metoda wyłuskuje nazwę obiektu w obrębie jakiego działamy
	 *
	 * @return string
	 */
	protected function pobierzNazweObiektuBazowego() : string
	{
		$chunks = explode('\\', get_class($this));
		return $chunks[0].'\\'.$chunks[1].'\\'.$chunks[count($chunks)-2];
	}



	/**
	 * Sprawdzanie czy wszystkie kategorie w tablicy sa instancja danego obiektu
	 *
	 * @param array $kategorie - tablica kategorii
	 * @return boolean
	 */
	public function instancja(Array $kategorie) : bool
	{
		foreach($kategorie as $kategoria)
		{
			if ( ! isset($kategoria) && ! ($kategoria instanceof $this->zwracanyObiekt))
				return false;
		}
		return true;
	}



	/**
	 * Ustawia typ zwracanego obiektu na tablice i zwraca instancja obiektu z hierarchii Mapper
	 *
	 * @param array $kolumny Kolumny ktore powinny byc pobierane w trybie tablicowym
	 *
	 * @return Mapper
	 */
	public function zwracaTablice($kolumny = array())
	{
		$this->zwracaTablice = true;
		$this->zwracaneKolumnyTablicy = array();

		$kolumny = is_array($kolumny) ? $kolumny : func_get_args();

		if (count($kolumny) > 0)
		{
			foreach (array_values($kolumny) as $kolumna)
			{
				$kolumna = (string)$kolumna;
				if ($kolumna == '') continue;
				$this->zwracaneKolumnyTablicy[] = $kolumna;
			}
		}
		return $this;
	}



	/**
	 * Ustawia typ zwracanego obiektu na obiekt i zwraca instancja obiektu z hierarchii Mapper
	 *
	 * @return Mapper
	 */
	public function zwracaObiekt()
	{
		$this->zwracaTablice = false;
		$this->zwracaneKolumnyTablicy = array();
		$this->_instancja = new $this->zwracanyObiekt();
		return $this;
	}

	public function pobierzZwracanyTyp()
	{
		return ($this->zwracaTablice) ? 'zwracaTablice' : 'zwracaObiekt';
	}


	/**
	 * Sprawdza czy obiekt danych jest obslugiwany przez mapper
	 *
	 * @param ObiektDanych $obiekt Sprawdzany obiekt
	 *
	 * @return boolean
	 */
	protected function obiektObslugiwany(ObiektDanych $obiekt)
	{
		if ($obiekt instanceof $this->zwracanyObiekt)
		{
			return true;
		}
		else
		{
			trigger_error('Obiekt klasy '.get_class($obiekt).' nie moze byc zapisywany przez mapper '.get_class($this), E_USER_WARNING);
			return false;
		}
	}



	/**
	 * Zwraca obiekt(o typie podanym w zmiennej self::klasaObiektu) lub tablice, na na podstawie danych ze zrodla
	 *
	 * @param array $dane Tablica z danymi potrzebnymi do utworzenia obiektu
	 *
	 * @return ObiektDanych|array
	 */
	protected function przetworzWynik(array $dane)
	{
		if ($this->zwracaTablice == self::ZWRACA_TABLICE)
		{
			return $dane;
		}
		else
		{
			// Zastosowanie Prototype
			$obiekt = clone $this->_instancja;
			$obiekt->wypelnij($dane);
			return $obiekt;
		}
	}



	/**
	 * Dodaje nowy obiekt do zrodla danych i zwraca identyfikator utworzonego rekordu
	 *
	 * @param ObiektDanych $obiekt Zapisywany obiekt
	 *
	 * @return integer
	 */
	public function wstaw(ObiektDanych $obiekt)
	{
		throw new MapperWyjatek ('Nie zaimplementowano metody w klasie potomnej');
	}



	/**
	 * Uaktualnia rekord w zrodle danych
	 *
	 * @param ObiektDanych $obiekt Zapisywany obiekt
	 *
	 * @return boolean
	 */
	public function aktualizuj(ObiektDanych $obiekt)
	{
		throw new MapperWyjatek ('Nie zaimplementowano metody w klasie potomnej');
	}



	/**
	 * Usuwa obiekt z zrodla danych
	 *
	 * @param ObiektDanych $obiekt zapisywany obiekt
	 *
	 * @return boolean
	 */
	public function usun(ObiektDanych $obiekt)
	{
		throw new MapperWyjatek ('Nie zaimplementowano metody w klasie potomnej');
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

}

class MapperWyjatek extends \Exception{}


