<?php
namespace Generic\Modul\BlokWyszukiwarki;
use Generic\Biblioteka\Modul;
use Generic\Model\WierszKonfiguracji;


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
        $this->ustawGlobalne(array('tytul_strony' => sprintf($this->j->t['index.tytul_strony'],$this->blok->nazwa)));

        $konfiguracjaMapper = $this->dane()->WierszKonfiguracji();
        $wiersz = $konfiguracjaMapper->pobierzWierszDlaModulu('wyszukiwarka_schowana', 'BlokWyszukiwarki_Http', null, $this->blok->id);

        if (!($wiersz instanceof WierszKonfiguracji\Obiekt))
        {
            $wiersz = new WierszKonfiguracji\Obiekt;
            $wiersz->idProjektu = ID_PROJEKTU;
            $wiersz->kodJezyka = KOD_JEZYKA;
            $wiersz->typ = 'boolean';
            $wiersz->nazwa = 'wyszukiwarka_schowana';
            $wiersz->idBloku = $this->blok->id;
            $wiersz->kodModulu = 'BlokWyszukiwarki_Http';
        }
        $obiektFormularza = new \Generic\Formularz\Kategoria\BlokWyszukiwarki();
        $obiektFormularza->ustawObiekt($wiersz)
            ->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'));

        if ($obiektFormularza->wypelniony() && $obiektFormularza->danePoprawne())
        {
            $dane = $obiektFormularza->pobierzWartosci();
            $wiersz->wartosc = $dane['wyszukiwarka_schowana'];

            if ($wiersz->zapisz($konfiguracjaMapper))
            {
                $this->komunikat($this->j->t['index.info_zapisano_konfiguracje'], 'info');
            }
            else
            {
                $this->komunikat($this->j->t['index.blad_nie_mozna_zapisac_konfiguracji'], 'error');
            }
        }
        $dane['form'] = $obiektFormularza->zwrocFormularz()->html();
        $this->tresc .= $this->szablon->parsujBlok('index', $dane);
	}

}


