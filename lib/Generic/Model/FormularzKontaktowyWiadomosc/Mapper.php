<?php
namespace Generic\Model\FormularzKontaktowyWiadomosc;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;


/**
 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących wiadomości z formularza kontaktowego.
 * @author Łukasz Wrucha
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Baza
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\FormularzKontaktowyWiadomosc\Obiekt';



	/**
	 * nazwe tabeli w bazie do ktorej beda zapisywane dane
	 * @var string
	 */
	protected $tabela = 'modul_formularz_kontaktowy_wiadomosci';



	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'kod_jezyka' => 'kodJezyka',
		'id_kategorii' => 'idKategorii',
		'id_tematu' => 'idTematu',
		'tresc' => 'tresc',
		'data_wyslania' => 'dataWyslania',
		'imie' => 'imie',
		'nazwisko' => 'nazwisko',
		'email' => 'email',
		'firma_nazwa' => 'firmaNazwa',
		'strona_www' => 'stronaWww',
		'gg' => 'gg',
		'skype' => 'skype',
		'telefon' => 'telefon',
		'komorka' => 'komorka',
		'fax' => 'fax',
		'id_uzytkownika' => 'idUzytkownika',
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



	public function pobierzDlaKategorii($idKategorii)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_kategorii = ' . intval($idKategorii)
			. ' AND id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\'';

		return $this->pobierzWiele($sql);
	}



	public function pobierzDlaKategoriiTematu($idKategorii, $idTematu)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_kategorii = ' . intval($idKategorii)
			. ' AND id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\''
			. ' AND id_tematu = ' . intval($idTematu) ;

		return $this->pobierzWiele($sql);
	}



	public function pobierzWszystko(Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\''
			. ' AND id_kategorii = ' . ID_KATEGORII;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\''
			. ' AND id_kategorii = ' . ID_KATEGORII;

		return $this->pobierzWartosc($sql);
	}



	public function szukaj($kryteria, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\''
			. ' AND id_kategorii = ' . ID_KATEGORII;

		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$fraza = addslashes($kryteria['fraza']);
			$sql .= ' AND (
					tresc LIKE \'%'.$fraza.'%\''
				. ' OR imie LIKE \'%'.$fraza.'%\''
				. ' OR nazwisko LIKE \'%'.$fraza.'%\''
				. ' OR email LIKE \'%'.$fraza.'%\''
				. ' OR firma_nazwa LIKE \'%'.$fraza.'%\''
				. ' OR strona_www LIKE \'%'.$fraza.'%\''
				. ' OR gg LIKE \'%'.$fraza.'%\''
				. ' OR skype LIKE \'%'.$fraza.'%\''
				. ' OR telefon LIKE \'%'.$fraza.'%\''
				. ' OR komorka LIKE \'%'.$fraza.'%\''
				. ' OR fax LIKE \'%'.$fraza.'%\''
				. ')';
		}
		if (isset($kryteria['data_wyslania']) && $kryteria['data_wyslania'] != '')
		{
			$sql .= ' AND data_wyslania > DATE_SUB(\''.date('Y-m-d').'\', INTERVAL '.intval($kryteria['data_wyslania']).' DAY)';
		}
		if (isset($kryteria['temat']) && $kryteria['temat'] != '')
		{
			$sql .= ' AND id_tematu = ' . intval($kryteria['temat']);
		}

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	public function iloscSzukaj($kryteria)
	{
		$sql = 'SELECT COUNT(*) FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\''
			. ' AND id_kategorii = ' . ID_KATEGORII;

		if (isset($kryteria['fraza']) && $kryteria['fraza'] != '')
		{
			$fraza = addslashes($kryteria['fraza']);
			$sql .= ' AND (
					tresc LIKE \'%'.$fraza.'%\''
				. ' OR imie LIKE \'%'.$fraza.'%\''
				. ' OR nazwisko LIKE \'%'.$fraza.'%\''
				. ' OR email LIKE \'%'.$fraza.'%\''
				. ' OR firma_nazwa LIKE \'%'.$fraza.'%\''
				. ' OR strona_www LIKE \'%'.$fraza.'%\''
				. ' OR gg LIKE \'%'.$fraza.'%\''
				. ' OR skype LIKE \'%'.$fraza.'%\''
				. ' OR telefon LIKE \'%'.$fraza.'%\''
				. ' OR komorka LIKE \'%'.$fraza.'%\''
				. ' OR fax LIKE \'%'.$fraza.'%\''
				. ')';
		}
		if (isset($kryteria['data_wyslania']) && $kryteria['data_wyslania'] != '')
		{
			$sql .= ' AND data_wyslania > DATE_SUB(\''.date('Y-m-d').'\', INTERVAL '.intval($kryteria['data_wyslania']).' DAY)';
		}
		if (isset($kryteria['temat']) && $kryteria['temat'] != '')
		{
			$sql .= ' AND id_tematu = ' . intval($kryteria['temat']);
		}

		return $this->pobierzWartosc($sql);
	}
}
