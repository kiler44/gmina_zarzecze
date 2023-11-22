<?php
namespace Generic\Model\RolaUprawnienie;
use Generic\Biblioteka;


/**
 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących połączenia ról uprawnieniami.
 * @author Krzysztof Lesiczka
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Baza
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\RolaUprawnienie\Obiekt';



	/**
	 * nazwe tabeli w bazie do ktorej beda zapisywane dane
	 * @var string
	 */
	protected $tabela = 'cms_role_uprawnienia';



	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'id_roli' => 'idRoli',
		'id_uprawnienia' => 'idUprawnienia',
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



	public function pobierzDlaUprawnienia($idUprawnienia)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_uprawnienia = ' . intval($idUprawnienia)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql);
	}



	public function pobierzDlaRoliUprawnienia($idRoli, $idUprawnienia)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_roli = ' . intval($idRoli)
			. ' AND id_uprawnienia = ' . intval($idUprawnienia)
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}

}
