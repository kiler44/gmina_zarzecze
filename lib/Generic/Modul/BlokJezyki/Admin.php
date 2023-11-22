<?php
namespace Generic\Modul\BlokJezyki;
use Generic\Biblioteka\Modul;


/**
 * Zarzadzanie bloku z wyborem jezykow.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Admin extends Modul\Admin
{

	/**
	 * @var \Generic\Konfiguracja\Modul\BlokJezyki\Admin
	 */
	protected $k;



	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\BlokJezyki\Admin
	 */
	protected $j;



	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));
		$this->komunikat($this->j->t['index.info_brak_mozliwosci_zarzadzania_modulem'],'info');
	}

}
