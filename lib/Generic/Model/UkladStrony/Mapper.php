<?php
namespace Generic\Model\UkladStrony;
use Generic\Biblioteka;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\MapperWyjatek;
use Generic\Biblioteka\Pager;


/**
 * Klasa obsługująca zapis i odczyt z plików dla obiektów odwzorowujących układów stron(z regionami).
 * @author Krzysztof Lesiczka, Łukasz Wrucha
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Tablica
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\UkladStrony\Obiekt';



	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'kod' => 'kod',
		'nazwa' => 'nazwa',
		'plik' => 'plik',
		'regiony' => 'regiony',
		'struktura' => 'struktura',
	);



	/**
	 * pola tabeli tworzace klucz glowny
	 * @var array
	 */
	protected $polaTabeliKlucz = array('kod');



	/**
	 * Zwraca instancje obiektu
	 *
	 * @return UkladyStronMapper
	 */
	public static function wywolaj($zwracaTablice = false)
	{
		parent::$klasa = __CLASS__;
		return parent::wywolaj($zwracaTablice);
	}



	public function zaladujDane()
	{
		$projekt = Cms::inst()->projekt;
		if ($dane = include(SZABLON_KATALOG.'/uklady/uklady.php'))
		{
			$this->przetworzDane($dane);
			return true;
		}
		else
		{
			throw new MapperWyjatek('Nie mozna odczytac pliku zawierajacego dane dla '.get_class($this));
		}
	}



	public function pobierzPoKodzie($kod)
	{
		if (array_key_exists($kod, $this->dane))
		{
			return $this->przetworzWynik($this->dane[$kod]);
		}
		else
		{
			return null;
		}
	}



	public function pobierzWszystko(Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		return $this->pobierzWiele($this->dane, $pager, $sorter);
	}



	public function iloscWszystko()
	{
		return count($this->dane);
	}

}

