<?php
namespace Generic\Model\BlokMenu;
use Generic\Biblioteka;


/**
 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących bloki menu.
 * @author Krzysztof Lesiczka, Łukasz Wrucha
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Baza
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\BlokMenu\Obiekt';



	/**
	 * nazwe tabeli w bazie do ktorej beda zapisywane dane
	 * @var string
	 */
	protected $tabela = 'modul_blok_menu';



	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'kod_jezyka' => 'kodJezyka',
		'id_bloku' => 'idBloku',
		'id_kategorii' => 'idKategorii',
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



	public function pobierzDlaBloku($idBloku)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
		. ' WHERE id_bloku = ' . intval($idBloku)
		. ' AND id_projektu = ' . ID_PROJEKTU
		. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\'';

		return $this->pobierzJeden($sql);
	}

}

