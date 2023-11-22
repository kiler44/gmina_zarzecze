<?php
namespace Generic\Modul\KontoUzytkownika;
use Generic\Biblioteka\Modul;


/**
 * Modul odpowiedzialny za konta uzytkownika.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Admin extends Modul\Admin
{

	/**
	 * @var \Generic\Konfiguracja\Modul\KontoUzytkownika\Admin
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\KontoUzytkownika\Admin
	 */
	protected $j;


	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));
		$this->komunikat($this->j->t['index.info_brak_mozliwosci_zarzadzania_modulem'],'info');
	}

}

