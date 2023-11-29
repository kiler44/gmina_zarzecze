<?php
namespace Generic\Modul\BlokWyszukiwarki;
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
	 * @var \Generic\Konfiguracja\Modul\BlokWyszukiwarki\Admin
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\BlokWyszukiwarki\Admin
	 */
	protected $j;


	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));

	}

}


