<?php
namespace Generic\Biblioteka\Modul;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\Szablon;
use Generic\Biblioteka\Cms;
use Generic\Model\Blok;
use Generic\Model\Kategoria;


/**
 * Klasa odpowiedzialna za drzewo modulow Cron.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Cron extends Modul
{
	/**
	 * Ustalana data, dla której zostaną pobrane dane do modułu.
	 *
	 * @var DateTime
	 */
	protected $dataDanych;


	/**
	 * Ustalana data, dla której zostaną wygenerowane treści. Może być różna od
	 * daty danych np. w przypadku, kiedy wsyłamy zaległe przypomienia
	 * o płatności do firm.
	 *
	 * @var DateTime
	 */
	protected $dataTresci;


	public function __construct() {
		parent::__construct();

		$this->dataDanych = new \DateTime('now', new \DateTimeZone('Europe/Oslo'));
		$this->dataTresci = new \DateTime($this->dataDanych->format('Y-m-d H:i:s'), new \DateTimeZone('Europe/Oslo'));
	}


	/**
	 * Laduje szablon dla modulu.
	 */
	public function ladujSzablon($szablon = null)
	{
		$plikSzablonu = SZABLON_KATALOG.'/'.SZABLON_KOMUNIKATU;
		$szablonKomunikatu = Plik::pobierzTrescPliku($plikSzablonu);
		if ($szablonKomunikatu == '')
		{
			trigger_error('Nie mozna znalezc pliku szablonu komunikatu'.$plikSzablonu, E_USER_WARNING);
			$szablonKomunikatu = Plik::pobierzTrescPliku(CMS_KATALOG.'/' . SZABLON_SYSTEM . '/'.SZABLON_KOMUNIKATU);
		}
		
		$plikSzablonu = SZABLON_KATALOG.'/moduly/'.str_replace('_', '/', $this->pobierzNazweModulu()).'.tpl';
		$rodzaj = ($this->blok instanceof Blok\Obiekt) ? 'blok' : 'kategoria';
		
		if ($szablon != '')
		{
			$szablon = SZABLON_KATALOG.'/moduly/'.$this->$rodzaj->kodModulu.'/'.$szablon;
			if (is_file($szablon))
			{
				$plikSzablonu = $szablon;
			}
		}
		elseif ($this->$rodzaj->szablon != '')
		{
			$szablon = SZABLON_KATALOG.'/moduly/'.$this->$rodzaj->kodModulu.'/'.$this->$rodzaj->szablon;
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
	 * Ustawia konfiguracje startowa dla modulu.
	 */
	public function ladujKonfiguracje()
	{
		$mapper = Cms::inst()->dane()->WierszKonfiguracji();
		if ($this->blok instanceof Blok\Obiekt)
		{
			$konfiguracja = $mapper->zwracaTablice()->pobierzDlaModulu($this->pobierzNazweModulu(), null, $this->blok->id, KOD_JEZYKA_ITERFEJSU);
		}
		elseif($this->kategoria instanceof Kategoria\Obiekt)
		{
			$konfiguracja = $mapper->zwracaTablice()->pobierzDlaModulu($this->pobierzNazweModulu(), $this->kategoria->id, null, KOD_JEZYKA_ITERFEJSU);
		}
		else
		{
			$konfiguracja = $mapper->zwracaTablice()->pobierzDlaModulu($this->pobierzNazweModulu(), null, null, KOD_JEZYKA_ITERFEJSU);
		}
		$this->ustawKonfiguracje($mapper->przetworzNaListe($konfiguracja));
	}


	/**
	 * Ustawia tlumaczenia startowe dla modulu.
	 */
	public function ladujTlumaczenia($jezyk = KOD_JEZYKA_ITERFEJSU)
	{
		$kodJezyka = KOD_JEZYKA_ITERFEJSU;
		
		$projekt = new \Generic\Model\Projekt\Obiekt();
		if (in_array($jezyk, $projekt->jezykiKody))
		{
			$kodJezyka = $jezyk;
		}
		$kod = explode('_', $this->pobierzNazweModulu());
		$namespaceJezyka = '\\Generic\\Tlumaczenie\\'.ucfirst($kodJezyka).'\\Modul\\' . $kod[0] . '\\' . $kod[1];
		if (class_exists($namespaceJezyka, true))
		{
			$this->j = new $namespaceJezyka;
		}
		
		$mapper = Cms::inst()->dane()->WierszTlumaczen();
		if ($this->blok instanceof Blok\Obiekt)
		{
			$tlumaczenia = $mapper->zwracaTablice()->pobierzDlaModulu($this->pobierzNazweModulu(), null, $this->blok->id, $kodJezyka);
		}
		elseif ($this->kategoria instanceof Kategoria\Obiekt)
		{
			$tlumaczenia = $mapper->zwracaTablice()->pobierzDlaModulu($this->pobierzNazweModulu(), $this->kategoria->id, null, $kodJezyka);
		}
		else
		{
			$tlumaczenia = $mapper->zwracaTablice()->pobierzDlaModulu($this->pobierzNazweModulu(), null, null, $kodJezyka);
		}

		$this->ustawTlumaczenia($mapper->przetworzNaListe($tlumaczenia));
	}



	/**
	 * Sprawdza czy metoda może byc wykonywana.
	 */
	protected function moznaWykonacAkcje($metoda, $wlasnyKod = false, $obiektKontekstu = NULL)
	{
		return true;
	}



	/**
	 * Ustawia datę danych
	 *
	 * @param DateTime $data
	 */
	public function ustawDateDanych(\DateTime $data)
	{
		$this->dataDanych = $data;
	}



	/**
	 * Ustawia datę treści
	 *
	 * @param DateTime $data
	 */
	public function ustawDateTresci(\DateTime $data)
	{
		$this->dataTresci = $data;
	}

	/**
	 * Sprawdza czy metoda może byc wykonywana.
	 *
	 * @param string $metoda Nazwa wywolywanej akcji (tekst albo null).
	 * @param boolean $wlasnyKod Czy podajemy własny kod uprawnienia
	 *
	 * @return boolean
	 */
	/*protected function moznaWykonacAkcje($metoda, $wlasnyKod = false)
	{
		return true;
	}*/
}
