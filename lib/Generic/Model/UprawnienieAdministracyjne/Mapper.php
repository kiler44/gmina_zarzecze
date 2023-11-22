<?php
namespace Generic\Model\UprawnienieAdministracyjne;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;


/**
 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących uprawnienia do modułów administracyjnych.
 * @author Krzysztof Lesiczka
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Baza
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\UprawnienieAdministracyjne\Obiekt';



	/**
	 * nazwe tabeli w bazie do ktorej beda zapisywane dane
	 * @var string
	 */
	protected $tabela = 'cms_uprawnienia_administracyjne';



	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'kod_modulu' => 'kodModulu',
		'akcja' => 'akcja',
		'hash' => 'hash',
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



	public function pobierzPoKodzie($kod)
	{
		$kod = explode('_', $kod);

		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE kod_modulu = \'' . $kod[0] .'\''
			. ' AND akcja = \'' . $kod[1] .'\''
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



	public function pobierzDlaRoli($idRoli)
	{
		$sql = 'SELECT ua.* FROM cms_role AS r'
			. ' JOIN cms_role_uprawnienia_administracyjne AS rua'
			. ' ON (r.id = ' . intval($idRoli)
			. ' AND r.id_projektu = ' . ID_PROJEKTU
			. ' AND r.id = rua.id_roli '
			. ' AND r.id_projektu = rua.id_projektu)'
			. ' JOIN ' . $this->tabela . ' AS ua'
			. ' ON (ua.id_projektu = ' . ID_PROJEKTU
			. ' AND ua.id = rua.id_uprawnienia_administracyjnego'
			. ' AND ua.id_projektu = rua.id_projektu)';

		return $this->pobierzWiele($sql);
	}



	public function pobierzDlaUzytkownika($idUzytkownika)
	{
		$sql = 'SELECT ua.* FROM cms_uzytkownicy_role AS ur'
			. ' JOIN cms_role_uprawnienia_administracyjne AS rua'
			. ' ON (ur.id_uzytkownika = ' . intval($idUzytkownika)
			. ' AND ur.id_projektu = ' . ID_PROJEKTU
			. ' AND ur.id_roli = rua.id_roli'
			. ' AND ur.id_projektu = rua.id_projektu)'
			. ' JOIN ' . $this->tabela . ' AS ua'
			. ' ON (ua.id_projektu = ' . ID_PROJEKTU
			. ' AND ua.id = rua.id_uprawnienia_administracyjnego'
			. ' AND ua.id_projektu = rua.id_projektu)';

		return $this->pobierzWiele($sql);
	}



	public function pobierzWszystko(Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	public function iloscWszystko()
	{
		$sql = 'SELECT  COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWartosc($sql);
	}

}

