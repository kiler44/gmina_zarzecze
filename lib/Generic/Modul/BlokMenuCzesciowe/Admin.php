<?php
namespace Generic\Modul\BlokMenuCzesciowe;
use Generic\Biblioteka\Modul;
use Generic\Model\WierszKonfiguracji;


/**
 * Zarzadzanie menu od wybranej kategorii od strony administracyjnej.
 *
 * @author Krzysztof Lesiczka
 * @package moduly
 */

class Admin extends Modul\Admin
{

	/**
	 * @var \Generic\Konfiguracja\Modul\BlokMenuCzesciowe\Admin
	 */
	protected $k;



	/**
	 * @var \Generic\Tlumaczenie\Pl\Modul\BlokMenuCzesciowe\Admin
	 */
	protected $j;


	public function wykonajIndex()
	{
		$this->ustawGlobalne(array('tytul_strony' => sprintf($this->j->t['index.tytul_strony'],$this->blok->nazwa)));

		$konfiguracjaMapper = $this->dane()->WierszKonfiguracji();
		$wiersz = $konfiguracjaMapper->pobierzWierszDlaModulu('kategoria_startowa', 'BlokMenuCzesciowe_Http', null, $this->blok->id);

		if (!($wiersz instanceof WierszKonfiguracji\Obiekt))
		{
			$wiersz = new WierszKonfiguracji\Obiekt;
			$wiersz->idProjektu = ID_PROJEKTU;
			$wiersz->kodJezyka = KOD_JEZYKA;
			$wiersz->typ = 'integer';
			$wiersz->nazwa = 'kategoria_startowa';
			$wiersz->idBloku = $this->blok->id;
			$wiersz->kodModulu = 'BlokMenuCzesciowe_Http';
		}

		$kategorie = $this->dane()->Kategoria()->pobierzWszystko();
		foreach ($kategorie as $kategoria)
		{
			if ($kategoria->poziom < 1) continue;
			if (in_array($kategoria->typ, array('glowna','menu')))
			{
				$lista[] = '---------------';
			}
			else
			{
				$lista[$kategoria->id] = str_repeat('&nbsp;&nbsp;', $kategoria->poziom).$kategoria->nazwa;
			}
		}

		$obiektFormularza = new \Generic\Formularz\Kategoria\MenuCzesciowe();
		$obiektFormularza->ustawObiekt($wiersz)
			->ustawTlumaczenia($this->pobierzBlokTlumaczen('formularz'))
			->ustawListeKategorii($lista);



		if ($obiektFormularza->wypelniony() && $obiektFormularza->danePoprawne())
		{
			$dane = $obiektFormularza->pobierzWartosci();
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
		$dane['form'] = $obiektFormularza->zwrocFormularz()->html();
		$this->tresc .= $this->szablon->parsujBlok('index', $dane);
	}

}
