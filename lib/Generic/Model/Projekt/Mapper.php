<?php
namespace Generic\Model\Projekt;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;


/**
 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących projekty.
 * @author Krzysztof Lesiczka
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Baza
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\Projekt\Obiekt';



	/**
	 * nazwe tabeli w bazie do ktorej beda zapisywane dane
	 * @var string
	 */
	protected $tabela = 'cms_projekty';



	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'kod' => 'kod',
		'domena' => 'domena',
		'nazwa' => 'nazwa',
		'opis' => 'opis',
		'szablon' => 'szablon',
		'domyslny_jezyk' => 'domyslnyJezyk',
		'przypisane_moduly' => 'przypisaneModuly',
		'moduly_rss' => 'modulyRss',
		'moduly_cron' => 'modulyCron',
		'moduly_api' => 'modulyApi',
	);



	/**
	 * pola tabeli tworzace klucz glowny
	 * @var array
	 */
	protected $polaTabeliKlucz = array('id');



	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id);

		return $this->pobierzJeden($sql);
	}



	public function pobierzPoKodzie($kod)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE kod = \'' . addslashes($kod) . '\'';

		return $this->pobierzJeden($sql);
	}



	public function pobierzPoDomenie($domena)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE domena = \'' . addslashes($domena) . '\'';

		return $this->pobierzJeden($sql);
	}



	public function pobierzZawierajaceModul($kodModulu, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE przypisane_moduly LIKE \'%,' . addslashes($kodModulu) . ',%\'';

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	public function pobierzWszystko(Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela;

		return $this->pobierzWartosc($sql);
	}

}