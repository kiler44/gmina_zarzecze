<?php
namespace Generic\Model\PlikPrywatnyRolaPowiazanie;
use Generic\Biblioteka;
use Generic\Biblioteka\BazaWyjatek;


/**
 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących powiązania plików prywatnych z rolami.
 * @author Krzysztof Lesiczka, Dariusz Półtorak
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Baza
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\PlikPrywatnyRolaPowiazanie\Obiekt';



	/**
	 * nazwe tabeli w bazie do ktorej beda zapisywane dane
	 * @var string
	 */
	protected $tabela = 'cms_pliki_role_powiazania';



	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'id_pliku' => 'idPliku',
		'id_roli' => 'idRoli',
	);



	/**
	 * pola tabeli tworzace klucz glowny
	 * @var array
	 */
	protected $polaTabeliKlucz = array('id','id_projektu');



	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



	public function pobierzPoRoli($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_roli = ' . intval($id)
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
}
