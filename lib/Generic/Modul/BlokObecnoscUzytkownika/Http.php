<?php
namespace Generic\Modul\BlokObecnoscUzytkownika;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;


/**
 * Blok z wyborem jezykow.
 *
 * @author Konrad Rudowski
 * @package moduly
 */

class Http extends Modul\Http
{

	/**
	 * @var \Generic\Konfiguracja\Modul\BlokJezyki\Http
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\BlokJezyki\Http
	 */
	protected $j;


	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_modulu' => $this->blok->nazwa));

		$cms = Cms::inst();

		$kategoria = $this->dane()->Kategoria()->pobierzDlaModulu('RejestrowanieZdarzen');

		$this->tresc .= $this->szablon->parsujBlok('index', array(
			'interwal' => $this->k->k['logowanieObecnosci.okres'] * 1000,
			'urlLogowanie' => $kategoria[0] instanceof Kategoria\Obiekt ? Router::urlAjax('Http', $kategoria[0], 'RejestrujZalogowany') : '',
		));
	}

}