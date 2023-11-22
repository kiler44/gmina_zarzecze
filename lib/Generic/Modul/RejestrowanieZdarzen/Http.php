<?php
namespace Generic\Modul\RejestrowanieZdarzen;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Model\Uzytkownik;


/**
 * Moduł odpowiedzialny za rejestrowanie zdarzeń.
 *
 * @author Konrad Rudowski
 * @package moduly
 */

class Http extends Modul\Http
{

	/**
	 * @var \Generic\Konfiguracja\Modul\RejestrowanieZdarzen\Http
	 */
	protected $k;



	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\RejestrowanieZdarzen\Http
	 */
	protected $j;



	protected $uprawnienia = array(
		'wykonajIndex',
		'wykonajRejestrujZalogowany',
	);


	protected $akcjeAjax = array(
		'RejestrujZalogowany'
	);

	protected $zdarzenia = array(
		'aktualnie_zalogowany' => 'Generic\\Zdarzenie\\UzytkownikAktualnieZalogowany',
	);



	public function wykonajIndex()
	{
		cms_blad_404('', '');
	}



	public function wykonajRejestrujZalogowany()
	{
		$czyUplynalOdpowiedniCzas = (! isset(Cms::inst()->sesja->ostatniaRejestracjaZalogowany))
			|| (time() > strtotime('+' . $this->k->k['logowanieObecnosci.okres'] . 'second', Cms::inst()->sesja->ostatniaRejestracjaZalogowany));

		if ((Cms::inst()->profil() instanceof Uzytkownik\Obiekt) && $czyUplynalOdpowiedniCzas)
		{
			$this->zdarzenie('aktualnie_zalogowany', array(
				'obiekt_Uzytkownik' => Cms::inst()->profil(),
			));

			Cms::inst()->sesja->ostatniaRejestracjaZalogowany = time();
		}

		$this->tresc .= $this->szablon->parsujBlok('ok');
	}

}


