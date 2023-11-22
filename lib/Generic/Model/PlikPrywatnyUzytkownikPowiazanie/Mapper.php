<?php
namespace Generic\Model\PlikPrywatnyUzytkownikPowiazanie;
use Generic\Biblioteka;
use Generic\Biblioteka\BazaWyjatek;


/**
 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących powiązania plików prywatnych z użytkownikami.
 * @author Krzysztof Lesiczka, Dariusz Półtorak
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Baza
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\PlikPrywatnyUzytkownikPowiazanie\Obiekt';



	/**
	 * nazwe tabeli w bazie do ktorej beda zapisywane dane
	 * @var string
	 */
	protected $tabela = 'cms_pliki_uzytkownicy_powiazania';



	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'id_pliku' => 'idPliku',
		'id_uzytkownika' => 'idUzytkownika',
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



	public function pobierzPoUzytkowniku($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_uzytkownika = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql);
	}



	public function pobierzPoPliku($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_pliku = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql);
	}



	public function usunDlaPliku($idPliku)
	{
		$sql = 'DELETE FROM ' . $this->tabela
			. ' WHERE id_pliku = ' . intval($idPliku)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->wykonajSql($sql);
	}
	
	public function usunDlaPlikuUzytkownika($idPliku, $idUzytkownika)
	{
		$sql = 'DELETE FROM ' . $this->tabela
			. ' WHERE id_pliku = ' . intval($idPliku)
			. ' AND id_projektu = ' . ID_PROJEKTU
		   . ' AND id_uzytkownika = ' . intval($idUzytkownika);

		return $this->wykonajSql($sql);
	}

}
