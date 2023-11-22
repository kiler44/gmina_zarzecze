<?php
namespace Generic\Modul\BlokObecnoscUzytkownika;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Router;
use Generic\Model\Kategoria;


/**
 * Zarzadzanie bloku z wyborem jezykow.
 *
 * @author Konrad Rudowski
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
		$cms = Cms::inst();

		$kategoria = $this->dane()->Kategoria()->pobierzDlaModulu('RejestrowanieZdarzen');


		$this->tresc .= $this->szablon->parsujBlok('index', array(
			'interwal' => $this->k->k['logowanieObecnosci.okres'] * 1000,
			'urlLogowanie' => $kategoria[0] instanceof Kategoria\Obiekt ? Router::urlAjax('Http', $kategoria[0], 'RejestrujZalogowany') : '',
		));
	}

}
