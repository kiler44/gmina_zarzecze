<?php
namespace Generic\Model\FormularzKontaktowyTemat;
use Generic\Biblioteka;
use Generic\Biblioteka\Pager;


/**
 * Klasa obsługująca zapis i odczyt z bazy dla obiektów odwzorowujących tematy formularza kontaktowego.
 * @author Łukasz Wrucha
 * @package dane
 */
class Mapper extends Biblioteka\Mapper\Baza
{

	/**
	 * nazwa klasy tworzonego obiektu
	 * @var string
	 */
	protected $zwracanyObiekt = 'Generic\Model\FormularzKontaktowyTemat\Obiekt';



	/**
	 * nazwe tabeli w bazie do ktorej beda zapisywane dane
	 * @var string
	 */
	protected $tabela = 'modul_formularz_kontaktowy_tematy';



	/**
	 * tablica tlumaczaca kolumny tabeli na nazwy pol obiektu
	 * @var array
	 */
	protected $polaTabeliObiekt = array(
		'id' => 'id',
		'id_projektu' => 'idProjektu',
		'kod_jezyka' => 'kodJezyka',
		'id_kategorii' => 'idKategorii',
		'temat' => 'temat',
		'email' => 'email',
		'email_dw' => 'emailDw',
		'konfiguracja' => 'konfiguracja',
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
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\''
			. ' AND id_kategorii = ' . ID_KATEGORII;

		return $this->pobierzJeden($sql);
	}



	public function pobierzDlaKategorii($idKategorii, Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_kategorii = ' . intval($idKategorii)
			. ' AND id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\'';

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	public function pobierzWszystko(Pager $pager = null, Biblioteka\Sorter $sorter = null)
	{
		$sql = 'SELECT * FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\'';

		return $this->pobierzWiele($sql, $pager, $sorter);
	}



	public function iloscDlaKategorii($idKategorii)
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\''
			. ' AND id_kategorii = ' . intval($idKategorii);

		return $this->pobierzWartosc($sql);
	}



	public function iloscWszystko()
	{
		$sql = 'SELECT COUNT(*) AS ilosc FROM ' . $this->tabela
			. ' WHERE id_projektu = ' . ID_PROJEKTU
			. ' AND kod_jezyka = \'' . KOD_JEZYKA .'\'';

		return $this->pobierzWartosc($sql);
	}

}
