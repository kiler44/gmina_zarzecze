<?php
namespace Generic\Model\Obserwator;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;


/**
 * Klasa obsługująca zapis i odczyt z pliku dla obiektów obserwatora.
 * @author Krzysztof Żak
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Tablica
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\Obserwator\Obiekt';


	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'opis' => 'opis',
		'typ'=> 'typ',
		'obiekt_docelowy' => 'obiekt_docelowy',
		'ustawienia' => 'ustawienia',
		'zdarzenia' => 'zdarzenia',
	);



	/**
	 * pola tabeli tworzace klucz glowny
	 * @var array
	 */
	protected $polaTabeliKlucz = array('id');



	/**
	 * Zwraca instancje obiektu
	 *
	 * @return DostepneModulyMapper
	 */
	public static function wywolaj($zwracaTablice = false)
	{
		parent::$klasa = __CLASS__;
		return parent::wywolaj($zwracaTablice);
	}



	public function zaladujDane()
	{
		$plikDanych = TEMP_KATALOG.'/obserwatory.inc.php';
		if ( ! is_file($plikDanych)) return false;
		$dane = @include($plikDanych);
		if ( ! is_array($dane)) return false;
		$this->przetworzDane($dane);
		return true;
	}



	public function zapiszDane()
	{
		$tresc = "<?php
namespace Generic\Model\Obserwator;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
 return " . var_export($this->dane, true) . ";";
		$zapisanoBajtow = file_put_contents(TEMP_KATALOG.'/obserwatory.inc.php', $tresc);
		return ($zapisanoBajtow !== false) ? true : false;
	}



	public function pobierzPoId($id)
	{
		if (array_key_exists((string)$id, $this->dane))
		{
			return $this->przetworzWynik($this->dane[$id]);
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

