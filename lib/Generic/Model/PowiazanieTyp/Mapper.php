<?php
namespace Generic\Model\PowiazanieTyp;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;


class Mapper extends Biblioteka\Mapper\Baza
{

	// nazwa klasy tworzonego obiektu
	protected $zwracanyObiekt = 'Generic\Model\PowiazanieTyp\Obiekt';



	// przetrzymuje nazwe tabeli w bazie do ktorej beda zapisywane dane
	protected $tabela = 'cms_powiazania_typy';



	// przetrzymuje tablice tlumaczaca kolumny tabeli na nazwy pol obiektu
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'nazwa' => 'nazwa',
		'typ1' => 'typ1',
		'typ2' => 'typ2',
	);



	// pola tabeli tworzace klucz glowny
	protected $polaTabeliKlucz = array('id', );



	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id);

		return $this->pobierzJeden($sql);
	}



	public function pobierzPoNazwie($nazwa)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE nazwa = \'' . addslashes($nazwa) . '\'';

		return $this->pobierzJeden($sql);
	}



	public function szukaj($kryteria, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE TRUE';

		$sql .= $this->zapytanieSql($kryteria);

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	public function iloscSzukaj($kryteria)
	{
		$sql = 'SELECT COUNT(*) FROM ' . $this->tabela
			. ' WHERE TRUE';

		$sql .= $this->zapytanieSql($kryteria);

		return $this->pobierzWartosc($sql);
	}

	protected function zapytanieSql($kryteria)
	{
		$sql = '';

		if (isset($kryteria['typObiektow']) && $kryteria['typObiektow'] != '')
		{
			$sql .= ' AND (typ1 = \'' . addslashes($kryteria['typObiektow']) . '\' OR typ2 = \'' . addslashes($kryteria['typObiektow']) . '\')';
		}

		return $sql;

	}

}
