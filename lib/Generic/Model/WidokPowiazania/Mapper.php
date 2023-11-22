<?php
namespace Generic\Model\WidokPowiazania;
use Generic\Biblioteka;
use Generic\Biblioteka\BazaWyjatek;
use Generic\Biblioteka\Pager;


/**
 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących powiązania widoku z użytkownikiem/grupą/akcją.
 * @author Marek Bar
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Baza
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\WidokPowiazania\Obiekt';



	/**
	 * nazwe tabeli w bazie do ktorej beda zapisywane dane
	 * @var string
	 */
	protected $tabela = 'crm_widoki_powiazania';



	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'id_widoku' => 'idWidoku',
		'kod_jezyka' => 'kodJezyka',
		'uzytkownik' => 'uzytkownik',
		'grupa' => 'grupa',
		'akcja' => 'akcja',
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



	function usunWszystko()
	{
		$sql = 'DELETE FROM ' . $this->tabela . '
			WHERE id_projektu = ' . ID_PROJEKTU . '
			AND kod_jezyka = \'' . KOD_JEZYKA . '\'';

		return $this->wykonajSql($sql);
	}



	public function pobierzPoIdWidoku($idWidoku)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_widoku = ' . $idWidoku
			. ' AND id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\'';

		return $this->pobierzJeden($sql);
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
