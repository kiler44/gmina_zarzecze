<?php
namespace Generic\Biblioteka\Modul;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\Szablon;
use Generic\Biblioteka\Cms;
use Generic\Model\DostepnyModul;


/**
 * Klasa odpowiedzialna za drzewo modulow administracyjnych cms-a.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class System extends Modul
{

	/**
	 * Laduje szablon dla modulu.
	 */
	public function ladujSzablon()
	{
	    if(!defined('SZABLON_KOMUNIKATU')) define('SZABLON_KOMUNIKATU', 'komunikat.tpl');

		$dostepneModulyMapper = DostepnyModul\Mapper::wywolaj();
		list($kod, $usluga) = explode('_', $this->pobierzNazweModulu());
		
		$wybranyModul = $dostepneModulyMapper->pobierzPoKodzie($kod);
		$kod = ($wybranyModul instanceof DostepnyModul\Obiekt && $wybranyModul->katalogSzablon != '') ? $wybranyModul->katalogSzablon : $kod;
		$szablonKomunikatu = Plik::pobierzTrescPliku(CMS_KATALOG.'/' . SZABLON_SYSTEM . '/'.SZABLON_KOMUNIKATU);

		//$plikSzablonu = CMS_KATALOG.'/' . SZABLON_SYSTEM . '/moduly/'.str_replace('_', '/', $this->pobierzNazweModulu()).'.tpl';
		$plikSzablonu = CMS_KATALOG.'/' . SZABLON_SYSTEM . '/moduly/'.$kod.'/'.$usluga.'.tpl';
		$szablon = Plik::pobierzTrescPliku($plikSzablonu);
		if ($szablon == '')
		{
			trigger_error('Nie mozna znalezc pliku szablonu '.$plikSzablonu, E_USER_WARNING);
			$szablon = Plik::pobierzTrescPliku(CMS_KATALOG.'/' . SZABLON_SYSTEM . '/'.SZABLON_MODUL);
		}

		$this->szablon = new Szablon();
		$this->szablon->ladujTresc($szablonKomunikatu.$szablon);
	}



	/**
	 * Ustawia tlumaczenia startowe dla modulu.
	 */
	public function ladujTlumaczenia()
	{
		$mapper = Cms::inst()->dane()->WierszTlumaczen();
		$tlumaczenia = $mapper->zwracaTablice()->pobierzDlaModulu($this->pobierzNazweModulu(), null, null, KOD_JEZYKA_ITERFEJSU);
		$this->ustawTlumaczenia($mapper->przetworzNaListe($tlumaczenia));
	}



	/**
	 * Ustawia konfiguracje startowa dla modulu.
	 */
	public function ladujKonfiguracje()
	{
		$mapper = Cms::inst()->dane()->WierszKonfiguracji();
		$konfiguracja = $mapper->zwracaTablice()->pobierzDlaModulu($this->pobierzNazweModulu(), null, null, KOD_JEZYKA_ITERFEJSU);
		$this->ustawKonfiguracje($mapper->przetworzNaListe($konfiguracja));
	}



	/**
	 * Laduje szablon zewnetrzny dla elementow takich jak grid, formularz, pager, itd.
	 *
	 * UWAGA !!! dla modulow administracyjnych szablony dodatkowe sa czytane z katalogu systemowego
	 *
	 * @param string $sciezkaSzablonu Sciezka czesciowa do szablonu
	 * @param bool $pelnaSciezka Parametr sprawdzajacy czy podano pelna sciezke szablonu
	 */
	public function ladujSzablonZewnetrzny($sciezkaSzablonu, $pelna_sciezka = false)
	{
		if (empty($sciezkaSzablonu))
		{
			trigger_error('Nie podano sciezki do pliku szablonu', E_USER_WARNING);
		}
		$cms = Cms::inst();

		if($pelna_sciezka)
			$plikSzablonu = $sciezkaSzablonu;
		else
			$plikSzablonu = CMS_KATALOG.'/' . SZABLON_SYSTEM . '/'.ltrim($sciezkaSzablonu, '/');

		return Plik::pobierzTrescPliku($plikSzablonu);
	}

}
