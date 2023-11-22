<?php
namespace Generic\Model\UkladStrony;
use Generic\Biblioteka\ObiektDanych;
use Generic\Biblioteka\Szablon;
use Generic\Biblioteka\Plik;
use Generic\Model\UkladStrony\UkladStronyWyjatek;
use Generic\Biblioteka\Cms;


/**
 * Klasa odwzorowująca układ strony(z regionami).
 * @author Krzysztof Lesiczka, Łukasz Wrucha
 * @package dane
 *
 * Klasa obslugujaca generowanie strony i sprawdzanie poprawnosci regionow w szablonie
 *
 * @author Krzysztof Lesiczka
 *
 * show off @property, @property-read, @property-write
 *
 * @property string $kod
 * @property string $nazwa
 * @property string $plik
 * @property array $regiony
 * @property string $struktura
 */

class Obiekt extends ObiektDanych
{

	/*
	 * Katalog szablonów ukladów stron
	 */
	protected $katalog;



	/*
	 * Zmienna przetrzymujaca obiekt szablonu
	 */
	protected $szablon;



	/*
	 * Zmienna przetrzymujaca typy regionow w szablonie
	 */
	protected $regiony = array();



	/*
	 * Tresc do dodania do regionu
	 */
	protected $regionyTresc = array();



	/*
	 * Okresla czy szablon zawiera bledy
	 */
	protected $szablonPrawidlowy;



	/*
	 * Opis struktury szablonu
	 */
	protected $strukturaSzablonu = array();



	/*
	 * Wszytuje tresc szablonu ze zmiennej.
	 *
	 * @param string $tresc Tresc szablonu
	 */
	public function ustawTrescSzablonu($tresc)
	{
		$this->szablon = new Szablon();
		$this->szablon->ladujTresc($tresc);
		$this->strukturaSzablonu = $this->szablon->struktura();
	}



	/*
	 * Ustawia katalog dla szablonow.
	 *
	 * @param string $katalog Katalog szablonów
	 */
	public function ustawKatalog($katalog)
	{
		$this->katalog = $katalog;
	}



	/*
	 * Wszytuje szablon z podanego pliku.
	 *
	 * @param string $plikSzablonu Nazwa pliku szablonu
	 */
	protected function wczytajPlik($plikSzablonu)
	{
		if (is_file($plikSzablonu) && is_readable($plikSzablonu))
		{
			$this->szablon = new Szablon();
			$this->szablon->ladujTresc(Plik::pobierzTrescPliku($plikSzablonu));
			$this->strukturaSzablonu = $this->szablon->struktura();
		}
		else
		{
			throw new UkladStronyWyjatek('Nie mozna odczytac pliku szablonu '.$plikSzablonu.'. Sprawdz prawa dostepu.', E_USER_ERROR);
		}
	}



	/*
	 * Porownouje strukture szablonu z tablica regionow i ustawia wewnętrzną zmienną.
	 *
	 * @param array $regiony Tablica z numerami regionow.
	 */
	protected function wczytajRegiony(Array $regiony)
	{
		foreach ($regiony as $region => $dozwoloneModuly)
		{
			$region = (string)$region;

			if (in_array('/'.$region, $this->strukturaSzablonu))
			{
				$this->regiony[$region] = 'zmienna';
			}
			elseif (in_array('/'.$region.'/', $this->strukturaSzablonu) && in_array('/'.$region.'/'.$region.'_tresc', $this->strukturaSzablonu))
			{
				$this->regiony[$region] = 'blok';
			}
			else
			{
				throw new UkladStronyWyjatek('Brak prawidlowej deklaracji regionu '.$region.' w pliku szablonu '.$this->plik, E_USER_NOTICE);
			}
		}
	}



	/*
	 * Sprawdza czy szablon zostal poprawnie wczytany.
	 */
	public function sprawdz()
	{
		$cms = Cms::inst();
		if (!($this->szablon instanceof Szablon))
		{
			if (empty($this->katalog))
			{
				$this->katalog = SZABLON_KATALOG.'/uklady/';
			}
			$plikSzablonu = $this->katalog.$this->_wartosci['plik'];
			$this->wczytajPlik($plikSzablonu);
		}
		if (!is_array($this->strukturaSzablonu) || count($this->strukturaSzablonu) < 1)
		{
			throw new UkladStronyWyjatek('Nie mozna odczytac struktury szablonu '.$this->nazwa.'.', E_USER_ERROR);
		}
		if (count($this->regiony) < 1)
		{
			$this->wczytajRegiony($this->_wartosci['regiony']);
		}
	}



	/*
	 * Ustawia zmienna w szablonie
	 *
	 * @param string $zmienna Nazwa zmiennej w szablonie
	 * @param string $wartosc Wartosc zmiennej
	 */
	public function dodajZmienna($zmienna, $wartosc)
	{
		$this->sprawdz();
		if (strpos($zmienna, 'region_') !== false)
		{
			throw new UkladStronyWyjatek('Tresc regionow nalezy ustawiac za pomoca metody dodajTrescRegionu()', E_USER_NOTICE);
		}
		else//if (in_array('/'.$zmienna, $this->strukturaSzablonu))
		{
			$this->szablon->ustaw(array($zmienna => $wartosc));
		}
/*		elseif ($wartosc != '')
		{
			trigger_error('Brak zadeklarowanej zmiennej '.$zmienna.' w szablonie '.$this->nazwa, E_USER_NOTICE);
		}
*/	}



	/*
	 * Dodaje kanal rss do szablonu
	 *
	 * @param string $url Url kanału rss
	 * @param string $tytul opcjonalny tytul kanału rss
	 */
	public function dodajKanalRss($url, $tytul = '')
	{
		if (in_array('/rss/', $this->strukturaSzablonu)
			&& in_array('/rss/url', $this->strukturaSzablonu)
			&& in_array('/rss/tytul', $this->strukturaSzablonu))
		{
			$this->szablon->ustawBlok('/rss', array('url' => $url, 'tytul' => $tytul));
		}
		else
		{
			trigger_error('Brak prawidlowo zadeklarowanego bloku rss w szablonie '.$this->nazwa, E_USER_NOTICE);
		}
	}


	/*
	 * Dodaje tresc do regionu
	 *
	 * @param int $nrRegionu Numer regionu
	 * @param string|array $tresc Tresc do dodania w regionie
	 */
	public function dodajTrescRegionu($nrRegionu, $tresc)
	{
		$this->sprawdz();
		if (isset($this->regiony[$nrRegionu]))
		{
			$this->regionyTresc[$nrRegionu][] = (is_array($tresc)) ? implode('',$tresc) : (string)$tresc;
		}
		else
		{
			throw new UkladStronyWyjatek('Region '.$nrRegionu.' nie zostal wczesnij zadeklarowany w szablonie '.$this->nazwa, E_USER_NOTICE);
		}
	}



	/*
	 * Zwraca przetworzona tresc strony
	 *
	 * @return string Przetworzona tresc strony
	 */
	public function pobierzHtml()
	{
		$this->sprawdz();
		foreach ($this->regiony as $nrRegionu => $typRegionu)
		{
			$tresc = (isset($this->regionyTresc[$nrRegionu])) ? implode($this->regionyTresc[$nrRegionu]) : '';
			if ($typRegionu == 'blok')
			{
				$this->szablon->ustawBlok('/'.$nrRegionu, array($nrRegionu.'_tresc' => $tresc));
			}
			else
			{
				$this->szablon->ustaw(array($nrRegionu => $tresc));
			}
		}
		return $this->szablon->parsuj();
	}



	/*
	 * Wyswietla tresc strony
	 *
	 * @return string Tresc strony
	 */
	public function wyswietl()
	{
		echo $this->pobierzHtml();
	}

}

class UkladStronyWyjatek extends \Exception {}


