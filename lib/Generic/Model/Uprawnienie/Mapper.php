<?php
namespace Generic\Model\Uprawnienie;
use Generic\Biblioteka;
use Generic\Biblioteka\BazaWyjatek;
use Generic\Biblioteka\Pager;


/**
 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących uprawnienia do podstron.
 * @author Krzysztof Lesiczka
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Baza
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\Uprawnienie\Obiekt';



	/**
	 * nazwe tabeli w bazie do ktorej beda zapisywane dane
	 * @var string
	 */
	protected $tabela = 'cms_uprawnienia';



	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'usluga' => 'usluga',
		'id_kategorii' => 'idKategorii',
		'kod_modulu' => 'kodModulu',
		'akcja' => 'akcja',
		'hash' => 'hash',
	);



	/**
	 * pola tabeli tworzace klucz glowny
	 * @var array
	 */
	protected $polaTabeliKlucz = array('id', 'id_projektu');



	public function usunDlaKategorii($idKategorii)
	{
		$sql = 'DELETE FROM ' . $this->tabela
			. ' WHERE (usluga = \'Admin\' OR usluga = \'Http\')'
			. ' AND id_kategorii = ' . intval($idKategorii)
			. ' AND id_projektu = ' . ID_PROJEKTU;


		return $this->wykonajSql($sql);
	}



	public function usunDlaBloku($idBloku)
	{
		$sql = 'DELETE FROM ' . $this->tabela
			. ' WHERE usluga = \'Bloki\''
			. ' AND id_kategorii = ' . intval($idBloku)
			. ' AND id_projektu = ' . ID_PROJEKTU;


		return $this->wykonajSql($sql);
	}


	/**
	 * Usuwanie uprawnien dla blokow
	 *
	 * @return boolean
	 */
	public function usunDlaBlokow()
	{
		$sql = 'DELETE FROM ' . $this->tabela
			. ' WHERE usluga = \'Bloki\''
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->wykonajSql($sql);
	}



	public function pobierzPoId($id)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id = ' . intval($id)
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



	public function pobierzPoKodzie($kod)
	{
		$kod = explode('_', $kod);

		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE usluga = \'' . $kod[0] .'\''
			. ' AND kod_modulu = \'' . $kod[1] .'\''
			. ' AND id_kategorii = ' . $kod[2]
			. ' AND akcja = \'' . $kod[3] .'\''
			. ' AND id_projektu = ' . ID_PROJEKTU;


		return $this->pobierzJeden($sql);
	}



	public function pobierzDlaRoli($idRoli)
	{
		$sql = 'SELECT u.* FROM cms_role AS r'
			. ' JOIN cms_role_uprawnienia AS ru '
			. ' ON (r.id = ' . intval($idRoli)
			. ' AND r.id_projektu = ' . ID_PROJEKTU
			. ' AND r.id = ru.id_roli '
			. ' AND r.id_projektu = ru.id_projektu)'
			. ' JOIN ' . $this->tabela . ' AS u'
			. ' ON (u.id_projektu = ' . ID_PROJEKTU
			. ' AND u.id = ru.id_uprawnienia'
			. ' AND u.id_projektu = ru.id_projektu)';

		return $this->pobierzWiele($sql);
	}



	public function pobierzDlaUzytkownika($idUzytkownika)
	{
		$sql = 'SELECT u.* FROM cms_uzytkownicy_role AS ur'
			. ' JOIN cms_role_uprawnienia AS ru'
			. ' ON (ur.id_uzytkownika = ' . intval($idUzytkownika)
			. ' AND ur.id_projektu = ' . ID_PROJEKTU
			. ' AND ur.id_roli = ru.id_roli'
			. ' AND ur.id_projektu = ru.id_projektu)'
			. ' JOIN ' . $this->tabela . ' AS u'
			. ' ON (u.id_projektu = ' . ID_PROJEKTU
			. ' AND u.id = ru.id_uprawnienia'
			. ' AND u.id_projektu = ru.id_projektu)';

		return $this->pobierzWiele($sql);
	}



	public function pobierzDlaModulu($kodModulu, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND kod_modulu = \'' . addslashes($kodModulu) .'\'';

		return $this->pobierzWiele($sql, $pager, $sorter);
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
