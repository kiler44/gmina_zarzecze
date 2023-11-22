<?php
namespace Generic\Biblioteka\Modul;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Plik;
use Generic\Model\Blok;
use Generic\Biblioteka\Szablon;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Usluga;


/**
 * Klasa odpowiedzialna za drzewo modulow Http.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Http extends Modul
{
	/*
	 * Zmienna przechowuje nazwy akcji możliwe do wykonania za pomocą ajax'a
	 *
	 * @var array
	 */
	protected $akcjeAjax = array();



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
	 * Szuka i zwraca wartosc parametru z nastepujacych zrodel: Zadanie Http, Sesja(gdy zaznaczone), Wartosc domyslna(gdy ustawiona).
	 *
	 * @param string $nazwa Nazwa parametru.
	 * @param mixed $wartoscDomyslna Domyslna wartosc parametru.
	 * @param boolean $uzyjSesji Czy uzywac sesji do zapamietywania i odtwarzania parametru.
	 * @param array $filtry filtry do zastosowania podczas pobierania parametru.
	 *
	 * @return mixed
	 */
	protected function parametrHttp($nazwa, $wartoscDomyslna = null, $uzyjSesji = false, Array $filtry = array())
	{
		$router = Router\Http::inst();
		$wartosc = $router->pobierzParametr($nazwa);
		if (is_null($wartosc))
		{
			$wartosc = Zadanie::pobierzGet($nazwa);
		}
		if (is_null($wartosc) && $router->filtr() instanceof Router\FiltrParametry)
		{
			$nazwa = $router->filtr()->tlumaczNazwe($nazwa);
			$wartosc = Zadanie::pobierzGet($nazwa);
		}

		foreach ($filtry as $filtr)
		{
			$wartosc = Zadanie::filtruj($wartosc, $filtr);
		}

		$wartosc = $this->parametrWSesji($nazwa, $wartosc, (bool)$uzyjSesji);

		if (empty($wartosc) && $wartoscDomyslna !== null)
		{
			return $wartoscDomyslna;
		}
		return $wartosc;
	}



	/**
	 * Wywoluje akcje podana jako parametr. W przypadku braku wywoluje akcje domyslna.
	 * Dodatkowo dla usługi ajax sprawdzane sa uprawnienia do wywyoływania
	 * okreslonej akcji dla ajax'a.
	 *
	 * @param string $wybranaAkcja Nazwa akcji do wykonania.
	 */
	public function wykonajAkcje($wybranaAkcja = null)
	{
		/*
		 * To najpiękniejsze nie jest, ale to jedyne rozwiązanie jakie znalazłem
		 * aby zablokować niechciane ajaxy, które nie wymaga przerobienia połowy
		 * kodu.
		*/
		if (Cms::inst()->usluga instanceof Usluga\Ajax)
		{
			$this->sprawdzAkcjeAjax($wybranaAkcja);
		}

		parent::wykonajAkcje($wybranaAkcja);
	}



	/**
	 * Sprawdza, czy dana akcja znajduje sie na liście akcji możliwych do uruchomienia
	 * za pomocą usługi ajax.
	 *
	 * @param string $wybranaAkcja Nazwa akcji do sprawdzenia.
	 */
	protected function sprawdzAkcjeAjax($wybranaAkcja)
	{
		if ( !in_array($wybranaAkcja, $this->akcjeAjax))
		{
			cms_blad_404(Cms::inst()->lang['bledy']['blad_zadania'], Cms::inst()->lang['bledy']['nie_znaleziono_stony']);
		}

		return true;
	}

}
