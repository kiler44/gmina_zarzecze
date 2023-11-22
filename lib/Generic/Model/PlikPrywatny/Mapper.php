<?php
namespace Generic\Model\PlikPrywatny;
use Generic\Biblioteka;
use Generic\Model\Uzytkownik;


/**
 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących pliki prywatne.
 * @author Krzysztof Lesiczka, Dariusz Półtorak
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Baza
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\PlikPrywatny\Obiekt';



	/**
	 * nazwe tabeli w bazie do ktorej beda zapisywane dane
	 * @var string
	 */
	protected $tabela = 'cms_pliki';



	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'url' => 'url',
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



	public function pobierzPoUrl($url)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE url = \'' . addslashes($url) . '\''
			. ' AND id_projektu = ' . ID_PROJEKTU;

		return $this->pobierzJeden($sql);
	}



	public function sprawdzUprawnienia($url, Uzytkownik\Obiekt $uzytkownik)
	{
		$role_id = array();
		
		if (count($uzytkownik->role) > 0)
		{
			foreach ($uzytkownik->role as $rola)
			{
				$role_id[] = $rola['id'];
			}
		}

		$sql = 'SELECT COUNT(*) FROM ' . $this->tabela . ' AS p
				WHERE p.url = \'' . addslashes($url) . '\'
				AND p.id_projektu = '. ID_PROJEKTU .'
				AND (p.id IN (
					SELECT pu.id_pliku FROM cms_pliki_uzytkownicy_powiazania AS pu
					WHERE pu.id_uzytkownika = ' . $uzytkownik->id .'
					AND pu.id_projektu = ' . ID_PROJEKTU .')';

		if (count($role_id) > 0)
		{
			$sql .= ' OR p.id IN (
					SELECT pr.id_pliku FROM cms_pliki_role_powiazania AS pr
					WHERE pr.id_roli IN (' . implode(',',$role_id) . ')
					AND pr.id_projektu = ' . ID_PROJEKTU .')';
		}

		$sql .= ')';

		return $this->pobierzWartosc($sql);
	}
}
