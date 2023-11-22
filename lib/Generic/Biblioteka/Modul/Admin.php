<?php
namespace Generic\Biblioteka\Modul;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\Szablon;
use Generic\Biblioteka\Cms;
use Generic\Model\Blok;


/**
 * Klasa odpowiedzialna za drzewo modulow Admin.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Admin extends Modul
{

	/**
	 * Przetrzymuje strukturę menu kontekstowego wyświetlanego w module SciezkaAdministracyjna
	 * @var array
	 */
	private $menuKontestowe = array();
	
	
	/**
	 * Laduje szablon dla modulu.
	 */
	public function ladujSzablon($szablon = null)
	{
		/*
		$szablonKomunikatu = Plik::pobierzTrescPliku(CMS_KATALOG.'/' . SZABLON_SYSTEM . '/komunikat.tpl');

		$plikSzablonu = SZABLON_KATALOG.'/moduly/'.str_replace('_', '/', $this->pobierzNazweModulu()).'.tpl';
		$szablon = Plik::pobierzTrescPliku($plikSzablonu);
		if ($szablon == '')
		{
			trigger_error('Nie mozna znalezc pliku szablonu '.$plikSzablonu, E_USER_WARNING);
			$szablon = Plik::pobierzTrescPliku(CMS_KATALOG.'/' . SZABLON_SYSTEM . '/modul.tpl');
		}

		$this->szablon = new Szablon();
		$this->szablon->ladujTresc($szablonKomunikatu.$szablon);
		*/
		
		$plikSzablonu = SZABLON_KATALOG.'/'.SZABLON_KOMUNIKATU;
		$szablonKomunikatu = Plik::pobierzTrescPliku($plikSzablonu);
		if ($szablonKomunikatu == '')
		{
			trigger_error('Nie mozna znalezc pliku szablonu komunikatu'.$plikSzablonu, E_USER_WARNING);
			$szablonKomunikatu = Plik::pobierzTrescPliku(CMS_KATALOG.'/' . SZABLON_SYSTEM . '/'.SZABLON_KOMUNIKATU);
		}
		
		//$plikSzablonu = SZABLON_KATALOG.'/moduly/'.str_replace('_', '/', $this->pobierzNazweModulu()).'.tpl';
		
		$rodzaj = ($this->blok instanceof Blok\Obiekt) ? 'blok' : 'kategoria';
		$katalogSzablonu = ($this->$rodzaj->szablonKatalog != '' && NOWY_SZABLON) ? $this->$rodzaj->szablonKatalog : $this->$rodzaj->kodModulu;
		$usluga = explode('_', $this->pobierzNazweModulu());
		
		$plikSzablonu = SZABLON_KATALOG.'/moduly/'.$katalogSzablonu.'/'.$usluga[1].'.tpl';

		if ($szablon != '')
		{
			$szablon = SZABLON_KATALOG.'/moduly/'.$katalogSzablonu.'/'.$szablon;
			if (is_file($szablon))
			{
				$plikSzablonu = $szablon;
			}
		}
		elseif ($this->$rodzaj->szablon != '')
		{
			$szablon = SZABLON_KATALOG.'/moduly/'.$katalogSzablonu.'/'.$this->$rodzaj->szablon;
			if (is_file($szablon))
			{
				$plikSzablonu = $szablon;
			}
		}
		
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

		if($pelna_sciezka)
			$plikSzablonu = $sciezkaSzablonu;
		else
			$plikSzablonu = CMS_KATALOG.'/' . SZABLON_SYSTEM . '/'.ltrim($sciezkaSzablonu, '/');

		return Plik::pobierzTrescPliku($plikSzablonu);
	}
	
	
	public function dodajElementMenuKontekstowego($nazwa, $url, $ikona, $etykieta = null)
	{
		if ($etykieta == null && !isset($this->j->t[$nazwa.'.etykietaMenu']))
			trigger_error('Brak wiersza tłumaczeń "'.$nazwa.'.etykietaMenu'.'" dla elementu menu kontekstowego w module: '.$this->pobierzNazweModulu(), E_USER_NOTICE);
		else
			$etykieta = $this->j->t[$nazwa.'.etykietaMenu'];
		
		$this->menuKontestowe[$nazwa] = array(
			'url' => $url,
			'ikona' => $ikona,
			'etykieta' => $etykieta,
		);
	}
	
	public function usunElementMenuKontekstowego($nazwa)
	{
		if (isset($this->menuKontestowe[$nazwa]))
		{
			unset($this->menuKontestowe[$nazwa]);
		}
	}
	
	
	/**
	 * Sprawdza poprwnosć podanej tablicy definicji menu kontekstowego a następnie przekazuje do Cms::inst()->temp()
	 * a następnie skorzysta z tych danych moduł SciezkaAdministracyjna aby takie menu wyświetlić
	 * format:
	 * <pre>
	 * array(
	 * <pre>
	 * 	'nazwa' => array(
	 * 	<pre>
	 * 		'url' => '', // Link
	 * 		'ikona' => 'icon-add-sign', //Ikona
	 * 		'etykieta' => '', // Opcjonalnie - jeśli nie podane powinien być wpis w tłumaczeniach jako "nazwa.etykietaMenu"
	 * 	</pre>
	 * 	)
	 * 	</pre>
	 * )
	 * </pre>
	 * @param array $menu
	 */
	public function dodajMenuKontekstowe($menu = array())
	{
		if (empty($menu) || count($menu) == 0 || !is_array($menu))
		{
			trigger_error('Błąd formatu definicji menu kontekstowego. W komentarzu tej metody jest przykładowy format', E_USER_ERROR);
		}
      
		foreach ($menu as $nazwa => $dane)
		{
			if (isset($dane['url']) && $dane['url'] != '' &&
				isset($dane['ikona']) && $dane['ikona'] != '')
			{
				if (isset($dane['etykieta']) && $dane['etykieta'] != '')
					$this->dodajElementMenuKontekstowego($nazwa, $dane['url'], $dane['ikona'], $dane['etykieta']);
				else
					$this->dodajElementMenuKontekstowego($nazwa, $dane['url'], $dane['ikona']);
			}
			else
			{
				trigger_error('Nie podano wszystkich wymaganych danych przy dodawaniu menu kontekstowego dla elementu: '.$nazwa);
			}
		}
	}
	
	public function wyswietlMenuKontekstowe()
	{
		Cms::inst()->temp('menuKontekstowe', $this->menuKontestowe);
	}

}
