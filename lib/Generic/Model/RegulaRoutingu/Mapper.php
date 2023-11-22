<?php
namespace Generic\Model\RegulaRoutingu;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;


/**
 * Klasa obsługująca zapis i odczyt z pliku dla obiektów regul routingu.
 * @author Konrad Rudowski
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Tablica
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\RegulaRoutingu\Obiekt';


	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'id' =>				'id',
		'nazwa' =>			'nazwa',
		'idKategorii' =>	'idKategorii',
		'kodModulu' =>		'kodModulu',
		'nazwaAkcji' =>		'nazwaAkcji',
		'typReguly' =>		'typReguly',
		'wartosc' =>		'wartosc',
		'szablonUrl' =>		'szablonUrl',
	);



	/**
	 * pola tabeli tworzace klucz glowny
	 * @var array
	 */
	protected $polaTabeliKlucz = array('id');

	protected $plikDanych;
	protected $plikDanychDocelowy;



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
		$plikDanych = TEMP_KATALOG.'/regulyRoutingu.inc.php';
		$this->plikDanych = $plikDanych;
		if ( ! is_file($plikDanych)) return false;
		$dane = @include($plikDanych);
		if ( ! is_array($dane)) return false;
		$this->przetworzDane($dane);
		return true;
	}



	public function zapiszDane()
	{
		$tresc = "<?php
namespace Generic\Model\RegulaRoutingu;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
 return " . var_export($this->dane, true) . ";";
		$zapisanoBajtow = file_put_contents($this->plikDanych, $tresc);
		return ($zapisanoBajtow !== false) ? true : false;
	}



	/**
	 * UWAGA!!!
	 * Transakcja musi obejmować zapisanie zawartości całego pliku!
	 */
	public function rozpocznijTransakcje()
	{
		$this->plikDanychDocelowy = $this->plikDanych;
		$this->plikDanych = $this->plikDanych . '_nowy';
	}



	public function zatwierdzTransakcje()
	{
		copy($this->plikDanychDocelowy, $this->plikDanychDocelowy . '_poprzednia');
		$wynik = copy($this->plikDanych, $this->plikDanychDocelowy);
		unlink($this->plikDanych);
		$this->plikDanych = $this->plikDanychDocelowy;

		return $wynik;
	}



	public function cofnijTransakcje()
	{
		if (file_exists($this->plikDanych))
		{
			ulink($this->plikDanych);
		}

		$this->plikDanych = $this->plikDanychDocelowy;
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

