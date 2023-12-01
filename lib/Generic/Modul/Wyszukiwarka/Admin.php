<?php
namespace Generic\Modul\Wyszukiwarka;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\TabelaDanych;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Pager;
use Generic\Model\Aktualnosc;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Katalog;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\TimelistPomocnik;
use Generic\Model\Uzytkownik;
use Generic\Model\Team;
use Generic\Model\Polaczenia;
use Generic\Model\TidsbankenGodzinyUzytkownika;

//require_once "Spreadsheet/Excel/Writer.php";


/**
 * Moduł odpowiedzialny za wyswietlenie strony startowej
 *
 * @author Łukasz Wrucha
 * @package moduly
 */

class Admin extends Modul\Admin
{

	protected $uprawnienia = array(
		'wykonajIndex',
	);


	/**
	 * @var \Generic\Konfiguracja\Modul\WidokPoczatkowy\Admin
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\WidokPoczatkowy\Admin
	 */
	protected $j;


	
	public function wykonajIndex()
	{

		$this->ustawGlobalne(array(
			'tytul_strony' => $this->j->t['index.tytul_strony'],
			'tytul_modulu' => $this->j->t['index.tytul_modulu'],
		));

		$this->tresc .= $this->szablon->parsujBlok('index', array('tytul' => 'To jest super strona'));
	}
	

}
