<?php
namespace Generic\Modul\BlokSciezka;
use Generic\Biblioteka\Modul;


/**
 * Zarzadzanie sciezka od strony administracyjnej.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Admin extends Modul\Admin
{

	/**
	 * @var \Generic\Konfiguracja\Modul\BlokSciezka\Admin
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\BlokSciezka\Admin
	 */
	protected $j;


	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));
		$this->komunikat($this->j->t['index.info_brak_mozliwosci_zarzadzania_modulem'], 'info');
	}

}


