<?php
namespace Generic\Modul\BlokKontoUzytkownika;
use Generic\Biblioteka\Modul;


/**
 * Ustawienia administracyjne dla bloku konta uzytkownika.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Admin extends Modul\Admin
{

	/**
	 * @var \Generic\Konfiguracja\Modul\BlokKontoUzytkownika\Admin
	 */
	protected $k;



	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\BlokKontoUzytkownika\Admin
	 */
	protected $j;


	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));
		$this->komunikat($this->j->t['index.info_brak_mozliwosci_zarzadzania_modulem'],'info');
	}

}

