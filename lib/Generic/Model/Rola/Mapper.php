<?php
namespace Generic\Model\Rola;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;


/**
 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących role użytkowników.
 * @author Krzysztof Lesiczka
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Baza
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\Rola\Obiekt';



	/**
	 * nazwe tabeli w bazie do ktorej beda zapisywane dane
	 * @var string
	 */
	protected $tabela = 'cms_role';



	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'kod' => 'kod',
		'nazwa' => 'nazwa',
		'opis' => 'opis',
		'moduly_dostep' => 'modulyDostep',
		'kontekstowa' => 'kontekstowa',
		'kontekst_obiekt' => 'kontekstObiekt',
		'kontekst_pole' => 'kontekstPole',
		'kontekst_powiazanie' => 'kontekstPowiazanie',
		'kontekst_powiazanie_ktore_id' => 'kontekstPowiazanieKtoreId',
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
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE  kod = \'' . addslashes($kod) . '\''
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}
	
	public function pobierzPoKodach(Array $kody)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE  kod IN (\'' . implode('\', \'' , $kody).'\' ) '
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql);
	}



	public function pobierzDlaDostepnegoModulu($kod)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE  moduly_dostep LIKE \'%,' . addslashes($kod) . ',%\''
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzWiele($sql);
	}



	public function pobierzPrzypisaneUzytkownikowi($idUzytkownika)
	{
		$sql = 'SELECT r.* FROM cms_uzytkownicy_role ur '
			. ' JOIN ' . $this->tabela . ' AS r '
			. ' ON ur.id_uzytkownika = ' . intval($idUzytkownika)
			. ' AND ur.id_projektu = ' . ID_PROJEKTU
			. ' AND ur.id_roli = r.id '
			. ' AND ur.id_projektu = r.id_projektu ';

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

	public function iloscSzukaj(Array $kryteria = array())
	{
		$sql = 'SELECT COUNT(*) FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		$sql .= $this->generujKryteria($kryteria);

		return $this->pobierzWartosc($sql);
	}

	public function szukaj(Array $kryteria = array(), Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU;

		$sql .= $this->generujKryteria($kryteria);

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	protected function generujKryteria($kryteria)
	{
		$sql = '';

		if (isset($kryteria['tylko_zwykle_role']) && $kryteria['tylko_zwykle_role'])
		{
			$sql .= ' AND kod NOT LIKE \'uzytkownik_%\'';
		}

		if (isset($kryteria['nie_kontekstowa']) && $kryteria['nie_kontekstowa'])
		{
			$sql .= ' AND kontekstowa = 0';
		}

		if (isset($kryteria['kontekstowa']) && $kryteria['kontekstowa'])
		{
			$sql .= ' AND kontekstowa = 1';
		}

		return $sql;
	}

}

