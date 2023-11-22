<?php
namespace Generic\Model\UzytkownikRola;
use Generic\Biblioteka;


/**
 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących powiązania ról z użytkownikami.
 * @author Krzysztof Lesiczka
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Baza
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\UzytkownikRola\Obiekt';



	/**
	 * nazwe tabeli w bazie do ktorej beda zapisywane dane
	 * @var string
	 */
	protected $tabela = 'cms_uzytkownicy_role';



	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'id_roli' => 'idRoli',
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



	public function pobierzDlaRoli($idRoli)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_roli = ' . intval($idRoli)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql);
	}



	public function pobierzDlaUzytkownika($idUzytkownika)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_uzytkownika = ' . intval($idUzytkownika)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql);
	}



	public function pobierzDlaUzytkownikaRoli($idUzytkownika, $idRoli)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_roli = ' . intval($idRoli)
			. ' AND id_uzytkownika = ' . intval($idUzytkownika)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}

}
