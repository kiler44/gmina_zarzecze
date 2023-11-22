<?php
namespace Generic\Model\Blok;
use Generic\Biblioteka;
use Generic\Biblioteka\BazaWyjatek;
use Generic\Biblioteka\Pager;


/**
 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących bloki towarzyszące.
 * @author Krzysztof Lesiczka
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Baza
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\Blok\Obiekt';



	/**
	 * nazwe tabeli w bazie do ktorej beda zapisywane dane
	 * @var string
	 */
	protected $tabela = 'cms_bloki';



	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'kod_jezyka' => 'kodJezyka',
		'kod_modulu' => 'kodModulu',
		'kontener' => 'kontener',
		'klasa' => 'klasa',
		'nazwa' => 'nazwa',
		'szablon' => 'szablon',
		'cache' => 'cache',
		'cache_czas' => 'cacheCzas',
		'szablon_katalog' => 'szablonKatalog'
	);



	/**
	 * pola tabeli tworzace klucz glowny
	 * @var array
	 */
	protected $polaTabeliKlucz = array('id', 'id_projektu', 'kod_jezyka');



	function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA . '\'';

		return $this->pobierzJeden($sql);
	}



	function pobierzPoNazwie($nazwa)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE nazwa = \''.addslashes($nazwa).'\''
			. ' AND id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA . '\'';

		return $this->pobierzJeden($sql);
	}



	function usunWszystko()
	{
		$sql = 'DELETE FROM ' . $this->tabela . '
			WHERE id_projektu = ' . ID_PROJEKTU . '
			AND kod_jezyka = \'' . KOD_JEZYKA . '\'';

		return $this->wykonajSql($sql);
	}



	function pobierzDlaModulu($kod_modulu, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$kod_modulu = (is_array($kod_modulu)) ? $kod_modulu : array($kod_modulu);
		$kod_modulu = array_map('addslashes', $kod_modulu);

		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE kod_modulu IN (\''.implode('\',\'', $kod_modulu).'\')'
			. ' AND id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA . '\'';

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	function iloscDlaModulu($kod_modulu)
	{
		$kod_modulu = (is_array($kod_modulu)) ? $kod_modulu : array($kod_modulu);
		$kod_modulu = array_map('addslashes', $kod_modulu);

		$sql = 'SELECT COUNT(*) FROM ' . $this->tabela
			. ' WHERE kod_modulu IN (\''.implode('\',\'', $kod_modulu).'\')'
			. ' AND id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA . '\'';

		return $this->pobierzWartosc($sql);
	}



	public function pobierzWszystko(Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\'';

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\'';

		return $this->pobierzWartosc($sql);
	}

}

