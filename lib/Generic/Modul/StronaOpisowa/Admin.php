<?php
namespace Generic\Modul\StronaOpisowa;
use Generic\Biblioteka\Modul;
use Generic\Model\StronaOpisowa;
use Generic\Biblioteka\Cms;


/**
 * Moduł odpowiedzialny za edytowanie strony opisowej.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Admin extends Modul\Admin
{

	/**
	 * @var \Generic\Konfiguracja\Modul\StronaOpisowa\Admin
	 */
	protected $k;



	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\StronaOpisowa\Admin
	 */
	protected $j;



	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));

		$mapper = $this->dane()->StronaOpisowa();

		$strona = $mapper->pobierzDlaKategorii(ID_KATEGORII);

		if (!($strona instanceof StronaOpisowa\Obiekt))
		{
			$strona = new StronaOpisowa\Obiekt();
		}

		$obiektFormularza = new \Generic\Formularz\StronaOpisowa\Edycja();
		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
			->ustawObiekt($strona);

		if ($obiektFormularza->wypelniony() && $obiektFormularza->danePoprawne())
		{
			foreach ($obiektFormularza->pobierzWartosci() as $klucz => $wartosc)
			{
				$strona->$klucz = $wartosc;
			}
			$strona->idProjektu = ID_PROJEKTU;
			$strona->kodJezyka = KOD_JEZYKA;
			$strona->idKategorii = ID_KATEGORII;
			$strona->idAutora = Cms::inst()->profil()->id;
			$strona->dataDodania = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
			if ($strona->zapisz($mapper))
			{
				$this->komunikat($this->j->t['index.info_zapisano_dane_strony'], 'info', 'sesja');
			}
			else
			{
				$this->komunikat($this->j->t['index.blad_nie_mozna_zapisac_strony'], 'error');
			}
		}
		$dane['form'] = $obiektFormularza->html();
		$this->tresc .= $this->szablon->parsujBlok('index', $dane);
	}

}


