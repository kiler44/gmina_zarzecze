<?php
namespace Generic\Biblioteka\Modul;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Szablon;
use Generic\Biblioteka\Plik;


/**
 * Klasa odpowiedzialna za drzewo modulow Rss.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Rss extends Modul
{

	/**
	 * Tablica przetrzymująca dane kanalu rss.
	 *
	 * @var array
	 */
	private $daneRss = array();



	/**
	 * Laduje szablon dla modulu.
	 */
	public function ladujSzablon()
	{
		$this->szablon = new Szablon();
		$this->szablon->ladujTresc(Plik::pobierzTrescPliku(CMS_KATALOG.'/' . SZABLON_SYSTEM . '/rss.tpl'));
	}



	/**
	 * Ustawia dane dla kanału rss.
	 *
	 * @param array $dane Dane dla kanalu rss.
	 */
	protected function daneKanalu(Array $dane)
	{
		$wymaganePola = array('tytul_kanalu', 'opis_kanalu', 'url_kanalu');
		foreach ($wymaganePola as $pole)
		{
			if (!isset($dane[$pole]))
			{
				trigger_error('Brak wymaganego pola dla kanalu rss: '.$pole , E_USER_WARNING);
			}
		}
		if (isset($dane['wiersz']))
		{
			trigger_error('Nie mozna ustawiac wierszy kanalu w danych ogolnych' , E_USER_WARNING);
			unset($dane['wiersz']);
		}
		$this->daneRss = array_merge($this->daneRss, $dane);
	}



	/**
	 * Ustawia dane dla wiersza kanału rss.
	 *
	 * @param array $dane Dane dla wiersza kanalu rss.
	 */
	protected function dodajWierszKanalu(Array $dane)
	{
		$wymaganePola = array('tytul', 'opis', 'url');
		foreach ($wymaganePola as $pole)
		{
			if (!isset($dane[$pole]))
			{
				trigger_error('Brak wymaganego pola dla wiersza kanalu rss: '.$pole , E_USER_WARNING);
			}
		}
		if (!isset($this->daneRss['wiersz']))
		{
			$this->daneRss['wiersz'] = array();
		}
		$this->daneRss['wiersz'][] = $dane;
	}



	/**
	 * Zwraca tresc wygenerowana podczas wykonywania sie modulu.
	 *
	 * @param bool $czysc Czy wyczyscic tresc wygenerowana do tej pory w module.
	 *
	 * @return string
	 */
	public function pobierzTresc($czysc = false)
	{
		$this->szablon->ustaw($this->daneRss);
		return $this->szablon->parsuj(true);
	}

}
