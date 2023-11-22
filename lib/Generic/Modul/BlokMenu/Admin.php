<?php
namespace Generic\Modul\BlokMenu;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Formularz;
use Generic\Model\WierszKonfiguracji;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Walidator;


/**
 * Zarzadzanie menu kategorii od strony administracyjnej.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Admin extends Modul\Admin
{

	/**
	 * @var \Generic\Konfiguracja\Modul\BlokMenu\Admin
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\BlokMenu\Admin
	 */
	protected $j;



	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_strony' => sprintf($this->j->t['index.tytul_strony'],$this->blok->nazwa)));

		$konfiguracjaMapper = $this->dane()->WierszKonfiguracji();
		$wierszeKonfiguracji = array();
		$wierszeKonfiguracji['typ_menu'] = $konfiguracjaMapper->pobierzWierszDlaModulu('typ_menu', 'BlokMenu_Http', null, $this->blok->id);
		if (!($wierszeKonfiguracji['typ_menu'] instanceof WierszKonfiguracji\Obiekt))
		{
			$wierszeKonfiguracji['typ_menu'] = $this->wygenerujSzkieletWierszaKonfiguracji();
			$wierszeKonfiguracji['typ_menu']->nazwa = 'typ_menu';
			$wierszeKonfiguracji['typ_menu']->typ = 'string';
			$wierszeKonfiguracji['typ_menu']->wartosc = 'biezaca_rodzicem';
		}

		$wierszeKonfiguracji['kategoria_startowa'] = $konfiguracjaMapper->pobierzWierszDlaModulu('kategoria_startowa', 'BlokMenu_Http', null, $this->blok->id);
		if (!($wierszeKonfiguracji['kategoria_startowa'] instanceof WierszKonfiguracji\Obiekt))
		{
			$wierszeKonfiguracji['kategoria_startowa'] = $this->wygenerujSzkieletWierszaKonfiguracji();
			$wierszeKonfiguracji['kategoria_startowa']->nazwa = 'kategoria_startowa';
			$wierszeKonfiguracji['kategoria_startowa']->typ = 'integer';
		}

		$wierszeKonfiguracji['minimalny_poziom'] = $konfiguracjaMapper->pobierzWierszDlaModulu('minimalny_poziom', 'BlokMenu_Http', null, $this->blok->id);
		if (!($wierszeKonfiguracji['minimalny_poziom'] instanceof WierszKonfiguracji\Obiekt))
		{
			$wierszeKonfiguracji['minimalny_poziom'] = $this->wygenerujSzkieletWierszaKonfiguracji();
			$wierszeKonfiguracji['minimalny_poziom']->nazwa = 'minimalny_poziom';
			$wierszeKonfiguracji['minimalny_poziom']->typ = 'integer';
		}

		$wierszeKonfiguracji['maksymalny_poziom'] = $konfiguracjaMapper->pobierzWierszDlaModulu('maksymalny_poziom', 'BlokMenu_Http', null, $this->blok->id);
		if (!($wierszeKonfiguracji['maksymalny_poziom'] instanceof WierszKonfiguracji\Obiekt))
		{
			$wierszeKonfiguracji['maksymalny_poziom'] = $this->wygenerujSzkieletWierszaKonfiguracji();
			$wierszeKonfiguracji['maksymalny_poziom']->nazwa = 'maksymalny_poziom';
			$wierszeKonfiguracji['maksymalny_poziom']->typ = 'integer';
		}

		$formularzObiekt = new \Generic\Formularz\BlokMenu\Edycja();
		$formularzObiekt->ustawWierszeKonfiguracji($wierszeKonfiguracji)
			->ustawUrlPowrotny($this->pobierzUrlPowrotny('widok'))
			->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
			->ustawKategorieLinkow($this->blok);

		if ($formularzObiekt->wypelniony() && $formularzObiekt->danePoprawne())
		{
			$wiersze = 0;
			$zapisane = 0;
			foreach ($formularzObiekt->pobierzWartosci() as $wiersz => $wartosc)
			{
				$wiersze++;
				$wierszeKonfiguracji[$wiersz]->wartosc = $wartosc;
				if ($wierszeKonfiguracji[$wiersz]->zapisz($konfiguracjaMapper)) $zapisane++;
			}

			if ($wiersze == $zapisane)
			{
				$this->komunikat($this->j->t['index.info_zapisano_konfiguracje'], 'info');
			}
			else
			{
				$this->komunikat($this->j->t['index.blad_nie_mozna_zapisac_konfiguracji'], 'error');
			}
		}

		$dane['form'] = $formularzObiekt->html();
		$this->tresc .= $this->szablon->parsujBlok('index', $dane);
	}


	protected function wygenerujSzkieletWierszaKonfiguracji()
	{
		$wiersz = new WierszKonfiguracji\Obiekt;
		$wiersz->idProjektu = ID_PROJEKTU;
		$wiersz->kodJezyka = KOD_JEZYKA;
		$wiersz->kodModulu = 'BlokMenu_Http';
		$wiersz->idBloku = $this->blok->id;

		return $wiersz;
	}

}
