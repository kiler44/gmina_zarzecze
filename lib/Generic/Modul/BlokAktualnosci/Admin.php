<?php
namespace Generic\Modul\BlokAktualnosci;
use Generic\Biblioteka\Modul;
use Generic\Model\WierszKonfiguracji;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;


/**
 * Blok odpowiedzialny za wyświetlanie skrótów aktualności.
 *
 * @author Łukasz Wrucha
 * @package moduly
 */

class Admin extends Modul\Admin
{

	/**
	 * @var \Generic\Konfiguracja\Modul\BlokAktualnosci\Admin
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\BlokAktualnosci\Admin
	 */
	protected $j;



	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));

		$kategorieMapper = $this->dane()->Kategoria();
		$kategorie = $kategorieMapper->pobierzDlaModulu('Aktualnosci');
		if (count($kategorie) < 1)
		{
			$this->komunikat($this->j->t['index.blad_nie_mozna_pobrac_kategorii'], 'warning');
			return;
		}

		$listaKategorii = array();
		foreach($kategorie as $kategoria)
		{
			$listaKategorii[$kategoria->id] = $kategoria->nazwa;
		}

		$konfiguracjaMapper = $this->dane()->WierszKonfiguracji();

		$wiersz = $konfiguracjaMapper->pobierzWierszDlaModulu('idKategorii', 'BlokAktualnosci_Http', $this->kategoria, $this->blok->id);

		if (!($wiersz instanceof WierszKonfiguracji\Obiekt))
		{
			$wiersz = new WierszKonfiguracji\Obiekt;
			$wiersz->idProjektu = ID_PROJEKTU;
			$wiersz->kodJezyka = KOD_JEZYKA;
			$wiersz->typ = 'integer';
			$wiersz->nazwa = 'idKategorii';
			$wiersz->idBloku = $this->blok->id;
			$wiersz->kodModulu = 'BlokAktualnosci_Http';
		}

		$formularzObiekt = new \Generic\Formularz\Aktualnosc\EdycjaKategorii();
		$formularzObiekt->ustawTlumaczenia($this->j->pobierzBlokTlumaczen('index'))
			->ustawObiekt($wiersz)
			->ustawListeKategorii($listaKategorii)
			->ustawUrlPowrotny($this->pobierzUrlPowrotny('widok'));

		if ($formularzObiekt->wypelniony() && $formularzObiekt->danePoprawne())
		{
			$dane = $formularzObiekt->pobierzWartosci();
			$wiersz->wartosc = $dane['idKategorii'];

			if ($wiersz->zapisz($konfiguracjaMapper))
			{
				$this->komunikat($this->j->t['index.info_zapisano_blok'], 'info');
			}
			else
			{
				$this->komunikat($this->j->t['index.blad_nie_mozna_zapisac_bloku'], 'error');
			}
		}
		$tresc['formularz'] = $formularzObiekt->zwrocFormularz()->html();
		$this->tresc .= $this->szablon->parsujBlok('index', $tresc);
	}
}

