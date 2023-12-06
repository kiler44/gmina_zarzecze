<?php
namespace Generic\Model\Galeria;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Sorter;

class Mapper extends Biblioteka\Mapper\Baza
{

	// nazwa klasy tworzonego obiektu
	protected $zwracanyObiekt = 'Generic\Model\Galeria\Obiekt';



	// przetrzymuje nazwe tabeli w bazie do ktorej beda zapisywane dane
	protected $tabela = 'modul_galeria';



	// przetrzymuje tablice tlumaczaca kolumny tabeli na nazwy pol obiektu
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'kod_jezyka' => 'kodJezyka',
		'nazwa' => 'nazwa',
		'opis' => 'opis',
		'autor' => 'autor',
		'data_dodania' => 'dataDodania',
		'zdjecie_glowne' => 'zdjecieGlowne',
		'publikuj' => 'publikuj',
		'id_kategorii' => 'idKategorii',
	);

	// pola tabeli tworzace klucz glowny
	protected $polaTabeliKlucz = array('id', 'id_projektu', 'kod_jezyka');

	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\'';

		return $this->pobierzJeden($sql);
	}



	public function pobierzWszystko(Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\'';

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	public function pobierzWszystkoOpublikowane(array $kryteria = [], Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\''
			. ' AND publikuj = true';
        if (isset($kryteria['id_kategorii']))
        {
            if(is_array($kryteria['id_kategorii']))
                $sql .= ' AND id_kategorii IN ('. implode(',', $kryteria['id_kategorii']).')';
            else
                $sql .= ' AND id_kategorii = '. (int)$kryteria['id_kategorii'];
        }

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\'';

		return $this->pobierzWartosc($sql);
	}



	public function iloscWszystkoOpublikowane(array $kryteria = [])
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\''
			. ' AND publikuj = true';
        if (isset($kryteria['id_kategorii']))
        {
            if(is_array($kryteria['id_kategorii']))
                $sql .= ' AND id_kategorii IN ('. implode(',', $kryteria['id_kategorii']).')';
            else
                $sql .= ' AND id_kategorii = '. (int)$kryteria['id_kategorii'];
        }

		return $this->pobierzWartosc($sql);
	}



	public function szukaj($kryteria, Pager $pager = null, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\'';

		if (isset($kryteria['przeszukaj_zdjecia']) && isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$zdjecia = array();
			$mapper = new GalerieZdjeciaMapper(Mapper::ZWRACA_TABLICE);
			foreach ($mapper->szukaj($kryteria) as $zdjecie)
			{
				$zdjecia[] = $zdjecie['id_galerii'];
			}
		}
		if (isset($kryteria['publikuj']))
		{
			$sql .= ' AND publikuj = '. (bool)$kryteria['publikuj'];
		}
        if (isset($kryteria['id_kategorii']) && $kryteria['id_kategorii'] > 0)
        {
            $sql .= ' AND id_kategorii = '. (int)$kryteria['id_kategorii'];
        }
		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$fraza = addslashes($kryteria['fraza']);
			$sql .= ' AND (
					nazwa LIKE \'%'.$fraza.'%\''
				. ' OR opis LIKE \'%'.$fraza.'%\''
				. ' OR autor LIKE \'%'.$fraza.'%\''
				. (isset($zdjecia) && (count($zdjecia) > 0) ? ' AND id IN ('.implode(',', $zdjecia).')' : '')
				. ')';
		}
		if (isset($kryteria['data_dodania']) && $kryteria['data_dodania'] != '')
		{
			$sql .= ' AND data_dodania > DATE_SUB(\''.date('Y-m-d').'\', INTERVAL '.intval($kryteria['data_dodania']).' DAY)';
		}

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	public function iloscSzukaj($kryteria)
	{
		$sql = 'SELECT COUNT(*) FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\'';

		if (isset($kryteria['przeszukaj_zdjecia']) && isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$zdjecia = array();
			$mapper = new GalerieZdjeciaMapper(Mapper::ZWRACA_TABLICE);
			foreach ($mapper->szukaj($kryteria) as $zdjecie)
			{
				$zdjecia[] = $zdjecie['id_galerii'];
			}
		}
        if (isset($kryteria['id_kategorii']) && $kryteria['id_kategorii'] > 0)
        {
            $sql .= ' AND id_kategorii = '. (int)$kryteria['id_kategorii'];
        }
		if (isset($kryteria['publikuj']))
		{
			$sql .= ' AND publikuj = '. (bool)$kryteria['publikuj'];
		}
		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$fraza = addslashes($kryteria['fraza']);
			$sql .= ' AND (
					nazwa LIKE \'%'.$fraza.'%\''
				. ' OR opis LIKE \'%'.$fraza.'%\''
				. ' OR autor LIKE \'%'.$fraza.'%\''
				. (isset($zdjecia) && (count($zdjecia) > 0) ? ' AND id IN ('.implode(',', $zdjecia).')' : '')
				. ')';
		}
		if (isset($kryteria['data_dodania']) && $kryteria['data_dodania'] != '')
		{
			$sql .= ' AND data_dodania > DATE_SUB(\''.date('Y-m-d').'\', INTERVAL '.intval($kryteria['data_dodania']).' DAY)';
		}

		return $this->pobierzWartosc($sql);
	}
}
