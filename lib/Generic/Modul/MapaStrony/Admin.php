<?php
namespace Generic\Modul\MapaStrony;
use Generic\Biblioteka\Modul;
use Generic\Model\WierszKonfiguracji;


/**
 * Zarzadzanie mapą strony od strony administracyjnej.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Admin extends Modul\Admin
{

	/**
	 * @var \Generic\Konfiguracja\Modul\MapaStrony\Admin
	 */
	protected $k;


	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\MapaStrony\Admin
	 */
	protected $j;


	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_strony' => $this->j->t['index.tytul_strony']));

		$konfiguracjaMapper = $this->dane()->WierszKonfiguracji();
		$wiersze = $konfiguracjaMapper->pobierzDlaModulu('MapaStrony_Http', $this->kategoria->id, null);

		$wiersz = null;
		if (is_array($wiersze) && count($wiersze) > 0)
		{
			foreach ($wiersze as $w)
			{
				if ($w->idKategorii == $this->kategoria->id)
				{
					$wiersz = $w;
				}
			}
		}
		if (!($wiersz instanceof WierszKonfiguracji\Obiekt))
		{
			$wiersz = new WierszKonfiguracji\Obiekt;
			$wiersz->idProjektu = ID_PROJEKTU;
			$wiersz->kodJezyka = KOD_JEZYKA;
			$wiersz->typ = 'array';
			$wiersz->nazwa = 'wybrane_kategorie_startowe';
			$wiersz->idKategorii = $this->kategoria->id;
			$wiersz->kodModulu = 'MapaStrony_Http';
		}
		$wybrane = unserialize($wiersz->wartosc);
		$wybrane = (is_array($wybrane)) ? $wybrane : array();

		$obiektFormularza = new \Generic\Formularz\MapaStrony\Edycja();
		$obiektFormularza->ustawTlumaczenia($this->pobierzBlokTlumaczen('index'))
			->ustawWybrane($wybrane);

		if ($obiektFormularza->wypelniony() && $obiektFormularza->danePoprawne())
		{
			$wybrane = array();
			foreach ($obiektFormularza->pobierzWartosci() as $klucz => $wartosc)
			{
				if ((int)$wartosc == 1) $wybrane[] = (int)str_replace('kategoria_', '', $klucz);
			}
			$wiersz->wartosc = serialize($wybrane);

			if ($wiersz->zapisz($konfiguracjaMapper))
			{
				$this->komunikat($this->j->t['index.info_zapisano_konfiguracje_mapy'], 'info');
			}
			else
			{
				$this->komunikat($this->j->t['index.blad_nie_mozna_zapisac_konfiguracji_mapy'], 'error');
			}
		}
		$dane['form'] = $obiektFormularza->html();
		$this->tresc .= $this->szablon->parsujBlok('index', $dane);
	}

}


