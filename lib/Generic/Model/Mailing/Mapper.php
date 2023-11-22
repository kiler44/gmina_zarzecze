<?php
namespace Generic\Model\Mailing;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;


/**
 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących dokumenty.
 * @author Konrad Rudowski
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Baza
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\Mailing\Obiekt';



	/**
	 * nazwe tabeli w bazie do ktorej beda zapisywane dane
	 * @var string
	 */
	protected $tabela = 'modul_mailing';



	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'kod_jezyka' => 'kodJezyka',
		'data_dodania' => 'dataDodania',
		'nazwa' => 'nazwa',
		'tytul' => 'tytul',
		'tresc' => 'tresc',
		'tresc_html' => 'trescHtml',
		'plik_z_lista' => 'plikZLista',
		'data_wysylki' => 'dataWysylki',
		'ile_adresow' => 'ileAdresow',
		'ile_wyslano' => 'ileWyslano',
		'ile_bledow' => 'ileBledow',
		'id_zadania_cron' => 'idZadaniaCron',
		'data_zakonczenia' => 'dataZakonczenia',
		'nazwa_nadawcy' => 'nazwaNadawcy',
		'email_nadawcy' => 'emailNadawcy',
		'zaladuj_szablon' => 'zaladujSzablon',
		'pomin_sprawdzanie_zgody' => 'pominSprawdzanieZgody',
	);


	/**
	 * pola tabeli tworzace klucz glowny
	 * @var array
	 */
	protected $polaTabeliKlucz = array('id', 'id_projektu', 'kod_jezyka');


	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\'';

		return $this->pobierzJeden($sql);
	}


	public function pobierzPoIdZadaniaCron($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_zadania_cron = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\'';

		return $this->pobierzJeden($sql);
	}



	public function szukaj($kryteria, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\'';

		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$fraza = addslashes($kryteria['fraza']);
			$sql .= ' AND (
					tytul LIKE \'%'.$fraza.'%\''
				. ' OR tresc LIKE \'%'.$fraza.'%\''
				. ')';
		}
		if (isset($kryteria['data_dodania']) && intval($kryteria['data_dodania']) > 0)
		{
			$sql .= ' AND data_dodania > DATE_SUB(\''.date('Y-m-d').'\', INTERVAL '.intval($kryteria['data_dodania']).' DAY)';
		}

		return $this->pobierzWiele($sql, $pager, $sorter);
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
		$sql = 'SELECT COUNT(*) FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\'';

		return $this->pobierzWartosc($sql);
	}



	public function iloscWOkresie($dataOd, $dataDo, $idRekordu = null)
	{
		$sql = 'SELECT COUNT(*) FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\''
			. ' AND ((data_wysylki <= \''. $dataOd .'\' AND data_zakonczenia >= \''. $dataOd .'\')'
			. ' OR (data_wysylki <= \''. $dataDo .'\' AND data_zakonczenia >= \''. $dataDo .'\'))';
		if ($idRekordu != null)
		{
			$sql .= ' AND id <> '. intval($idRekordu);
		}

		return $this->pobierzWartosc($sql);
	}



	public function iloscSzukaj($kryteria)
	{
		$sql = 'SELECT COUNT(*) FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\'';


		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$fraza = addslashes($kryteria['fraza']);
			$sql .= ' AND (
					tytul LIKE \'%'. $fraza .'%\''
				. ' OR tresc LIKE \'%'. $fraza .'%\''
				. ')';
		}
		if (isset($kryteria['data_dodania']) && intval($kryteria['data_dodania']) > 0)
		{
			$sql .= ' AND data_dodania > DATE_SUB(\''. date('Y-m-d') .'\', INTERVAL '. intval($kryteria['data_dodania']) .' DAY)';
		}

		return $this->pobierzWartosc($sql);
	}

}
