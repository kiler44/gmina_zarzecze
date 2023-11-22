<?php
namespace Generic\Model\PozycjaMenuAplikacji;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Sorter;


/**
 * Klasa obsługująca zapis i odczyt z bazy elementów menu aplikacji.
 * @author Łukasz Wrucha
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Baza
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\PozycjaMenuAplikacji\Obiekt';



	/**
	 * nazwe tabeli w bazie do ktorej beda zapisywane dane
	 * @var string
	 */
	protected $tabela = 'modul_menu_aplikacji';



	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'id_uzytkownika' => 'idUzytkownika',
		'czy_modul_administracyjny' => 'czyModulAdministracyjny',
		'id_kategorii' => 'idKategorii',
		'akcja' => 'akcja',
		'parametry' => 'parametry',
		'anchor' => 'anchor',
		'ikona' => 'ikona',
		'klikniecia' => 'klikniecia',
		'zawsze_widoczna' => 'zawszeWidoczna',
		'kolejnosc' => 'kolejnosc',
		'id_rodzica' => 'idRodzica',
		'etykieta' => 'etykieta',
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



	public function pobierzDlaUzytkownika($idUzytkownika, $orazWszytkich = true, Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
		. ' WHERE id_projektu = ' . ID_PROJEKTU
		. ' AND (id_uzytkownika = ' . intval($idUzytkownika);
		if ($orazWszytkich)
		{
			$sql .= ' OR id_uzytkownika = NULL)';
		}
		else
		{
			$sql .= ')';
		}

		return $this->pobierzWiele($sql, null, $sorter);
	}

	
	public function pobierzDlaWszystkich(Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
		. ' WHERE id_projektu = ' . ID_PROJEKTU
		. ' AND id_uzytkownika = \'\'';
		
		return $this->pobierzWiele($sql, null, $sorter);
	}
	
	
	public function aktualizujKolejnosc($porzadek)
	{
		if (!is_array($porzadek) || empty($porzadek) || count($porzadek) == 0)
			return false;

		try
		{
			$this->baza->transakcjaStart();

			$warunek = array('id' => 0, 'id_projektu' => ID_PROJEKTU);

			$licznik = 1;
			foreach ($porzadek as $id)
			{
				$warunek['id'] = $id;
				$sql = $this->baza->sqlUpdate('modul_menu_aplikacji', array('kolejnosc' => $licznik), array('AND' => $warunek));
				$this->baza->zapytanie($sql);
				$licznik++;
			}

			$this->baza->transakcjaPotwierdz();
			return true;
		}
		catch (BazaWyjatek $wyjatek)
		{
			$this->baza->transakcjaCofnij();
			return false;
		}
	}
}

