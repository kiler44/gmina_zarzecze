<?php
namespace Generic\Model\Widok;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;


/**
 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących widoki z układem treści.
 * @author Łukasz Wrucha
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Baza
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\Widok\Obiekt';



	/**
	 * nazwe tabeli w bazie do ktorej beda zapisywane dane
	 * @var string
	 */
	protected $tabela = 'cms_widoki';



	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'nazwa' => 'nazwa',
		'uklad_strony' => 'ukladStrony',
		'struktura' => 'struktura',
		'json_ukladu' => 'jsonUkladu',
		'html_ukladu' => 'htmlUkladu',
	);



	/**
	 * pola tabeli tworzace klucz glowny
	 * @var array
	 */
	protected $polaTabeliKlucz = array('id', 'id_projektu');



	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



	function usunWszystko()
	{
		$sql = 'DELETE FROM ' . $this->tabela . '
			WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->wykonajSql($sql);
	}



	public function pobierzPoNazwie($nazwa)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE nazwa = \'' . addslashes($nazwa) . '\''
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



	public function pobierzZawierajaceBlok($idBloku, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND struktura LIKE \'%,blok\_' . intval($idBloku) . ',%\'';

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	public function iloscZawierajaceBlok($idBloku)
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND struktura LIKE \'%,blok\_' . intval($idBloku) . ',%\'';

		return $this->pobierzWartosc($sql);
	}



	public function pobierzWszystko(Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWartosc($sql);
	}

}