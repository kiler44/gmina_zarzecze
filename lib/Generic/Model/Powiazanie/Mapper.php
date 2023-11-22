<?php
namespace Generic\Model\Powiazanie;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Model\PowiazanieTyp;


class Mapper extends Biblioteka\Mapper\Baza
{

	// nazwa klasy tworzonego obiektu
	protected $zwracanyObiekt = 'Generic\Model\Powiazanie\Obiekt';



	// przetrzymuje nazwe tabeli w bazie do ktorej beda zapisywane dane
	protected $tabela = 'cms_powiazania';



	// przetrzymuje tablice tlumaczaca kolumny tabeli na nazwy pol obiektu
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id1' => 'id1',
		'id2' => 'id2',
		'typ' => 'typ',
		'data_start' => 'dataStart',
		'data_stop' => 'dataStop',
	);



	// pola tabeli tworzace klucz glowny
	protected $polaTabeliKlucz = array('id', );



	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id);

		return $this->pobierzJeden($sql);
	}



	public function szukaj($kryteria, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela;


		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	public function iloscSzukaj($kryteria)
	{
		$sql = 'SELECT COUNT(*) FROM ' . $this->tabela;


		return $this->pobierzWartosc($sql);
	}


	public function pobierzPoId1Typie($id1, $typ, $aktualne = true, $dataStart = null, $dataStop = null)
	{
		$typPowiazania = $this->dane()->PowiazanieTyp()->pobierzPoNazwie($typ);

		if ($typPowiazania instanceof PowiazanieTyp\Obiekt)
		{
			$sql = 'SELECT * FROM ' . $this->tabela
				. ' WHERE typ = ' . intval($typPowiazania->id)
				. ' AND id1 = ' . intval($id1);

			//jeśli aktualne === null to nie uwzględniamy dat
			if ($aktualne === true)
			{
				$sql .=' AND (data_start IS NULL OR data_start <= NOW()) AND (data_stop IS NULL OR data_stop >= NOW())';
			}
			elseif ($aktualne === false)
			{
				$sql .=' AND NOT((data_start IS NULL OR data_start <= NOW()) AND (data_stop IS NULL OR data_stop >= NOW()))';
			}
			if($dataStart != '')
			{
				$sql .=' AND (data_start IS NULL OR data_start >= ' . $dataStart . ')';
			}
			if($dataStop != '')
			{
				$sql .=' AND (data_stop IS NULL OR data_stop <= ' . $dataStop . ')';
			}

			return $this->pobierzWiele($sql);
		}
		else
		{
			trigger_error('Brak powiazania ' . $typ);
			return array();
		}

	}


	public function pobierzPoId2Typie($id2, $typ, $aktualne = true, $dataStart = null, $dataStop = null)
	{
		$typPowiazania = $this->dane()->PowiazanieTyp()->pobierzPoNazwie($typ);

		if ($typPowiazania instanceof PowiazanieTyp\Obiekt)
		{
			$sql = 'SELECT * FROM ' . $this->tabela
				. ' WHERE typ = ' . intval($typPowiazania->id)
				. ' AND id2 = ' . intval($id2);

			//jeśli aktualne === null to nie uwzględniamy dat
			if ($aktualne === true)
			{
				$sql .=' AND (data_start IS NULL OR data_start <= NOW()) AND (data_stop IS NULL OR data_stop >= NOW())';
			}
			elseif ($aktualne === false)
			{
				$sql .=' AND NOT((data_start IS NULL OR data_start <= NOW()) AND (data_stop IS NULL OR data_stop >= NOW()))';
			}
			if($dataStart != '')
			{
				$sql .=' AND (data_start IS NULL OR data_start >= ' . $dataStart . ')';
			}
			if($dataStop != '')
			{
				$sql .=' AND (data_stop IS NULL OR data_stop <= ' . $dataStop . ')';
			}

			return $this->pobierzWiele($sql);
		}
		else
		{
			trigger_error('Brak powiazania ' . $typ);
			return array();
		}
	}

	public function sprawdz($id1, $id2, $idTypu, $aktualne = true, $dataStart = null, $dataStop = null)
	{
			$sql = 'SELECT COUNT(*) FROM ' . $this->tabela
				. ' WHERE typ = ' . intval($idTypu)
				. ' AND id2 = ' . intval($id2)
				. ' AND id1 = ' . intval($id1);

			//jeśli aktualne === null to nie uwzględniamy dat
			if ($aktualne === true)
			{
				$sql .=' AND (data_start IS NULL OR data_start <= NOW()) AND (data_stop IS NULL OR data_stop >= NOW())';
			}
			elseif ($aktualne === false)
			{
				$sql .=' AND NOT((data_start IS NULL OR data_start <= NOW()) AND (data_stop IS NULL OR data_stop >= NOW()))';
			}
			if($dataStart != '')
			{
				$sql .=' AND (data_start IS NULL OR data_start >= ' . $dataStart . ')';
			}
			if($dataStop != '')
			{
				$sql .=' AND (data_stop IS NULL OR data_stop <= ' . $dataStop . ')';
			}

			return $this->pobierzWartosc($sql) > 0;
		}

}
