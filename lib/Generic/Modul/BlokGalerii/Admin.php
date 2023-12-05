<?php
namespace Generic\Modul\BlokGalerii;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Zadanie;
use Generic\Model\BlokOpisowy;
use Generic\Biblioteka\Cms;


/**
 * Blok odpowiadajacy za zarządzanie dodatkową treścią wyświetlaną na stronie.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Admin extends Modul\Admin
{

	/**
	 * @var \Generic\Konfiguracja\Modul\BlokOpisowy\Admin
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\BlokOpisowy\Admin
	 */
	protected $j;



	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));

		$mapper = $this->dane()->BlokOpisowy();

		$idBloku = Zadanie::pobierz('b', 'intval','abs');

		$blok = $mapper->pobierzDlaBloku($idBloku);

		if (!($blok instanceof BlokOpisowy\Obiekt))
		{
			$blok = new BlokOpisowy\Obiekt();
		}

		$formlarzObiekt = new \Generic\Formularz\BlokOpisowy\Edycja();
		$formlarzObiekt->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
			->ustawObiekt($blok)
			->ustawUrlPowrotny($this->pobierzUrlPowrotny('widok'))
			->ustawCkeditor($this->k->k['formularz.wlacz_ckeditor']);

		if ($formlarzObiekt->wypelniony() && $formlarzObiekt->danePoprawne())
		{
			foreach ($formlarzObiekt->pobierzWartosci() as $klucz => $wartosc)
			{
				$blok->$klucz = $wartosc;
			}
			$blok->idProjektu = ID_PROJEKTU;
			$blok->kodJezyka = KOD_JEZYKA;
			$blok->idBloku = $idBloku;
			$blok->idAutora = Cms::inst()->profil()->id;
			$blok->dataDodania = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
			if ($blok->zapisz($mapper))
			{
				$this->komunikat($this->j->t['index.info_zapisano_dane_strony'], 'info', 'sesja');
			}
			else
			{
				$this->komunikat($this->j->t['index.blad_nie_mozna_zapisac_strony'], 'error');
			}
		}
		$dane['form'] = $formlarzObiekt->zwrocFormularz()->html();
		$this->tresc .= $this->szablon->parsujBlok('index', $dane);
	}

}


