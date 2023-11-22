<?php
namespace Generic\Biblioteka\Pomocnik;
use Generic\Biblioteka\Tlumaczenia;
use Generic\Biblioteka\Konfiguracja;
use Generic\Biblioteka\TabelaDanych\Gui;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\Formularz;

/**
 * Ułatwia pracę ze standardowymi gridami
 *
 * @author Konrad Rudowski
 * @package biblioteki
 */

class TabelaHtml implements Tlumaczenia\Interfejs, Konfiguracja\Interfejs
{
	/**
	 * Zmienne przetrzymująca instancję obiektu grida
	 *
	 * @var \Generic\Biblioteka\TabelaDanych\Gui\Html
	 */
	protected $grid;


	/**
	 * Zmienne przetrzymująca instancję obiektu formularza wyszukiwania
	 *
	 * @var \Generic\Biblioteka\Formularz
	 */
	protected $formularzWyszukiwania;


	/**
	 * Zmienne przetrzymująca tablicę z kryteriami początkowymi
	 *
	 * @var mixed
	 */
	protected $kryteriaPoczatkowe = array();


	/**
	 * Zmienne przetrzymująca tłumaczenia
	 *
	 * @var Array
	 */
	protected $tlumaczenia = array();


	/**
	 * Nazwa mappera danych
	 *
	 * @var String
	 */
	protected $nazwaMappera = '';


	/**
	 * Nazwa funcji pobierajacej ilosc
	 *
	 * @var String
	 */
	protected $nazwaIlosc = '';


	/**
	 * Nazwa funcji pobierajacej dane
	 *
	 * @var String
	 */
	protected $nazwaSzukaj = '';


	protected $szablonUrl;
	protected $nrStronyParametr = 'url_parametr_1';
	protected $naStronieParametr = 'url_parametr_2';
	protected $kolumnaParametr = 'url_parametr_3';
	protected $kierunekParametr = 'url_parametr_4';

	/**
	 * Szablon url dla przycisków grida
	 *
	 * @var String
	 */
	protected $szablonUrlPrzyciski;


	/**
	 * Tablica przechowująca kolumny tabeli
	 *
	 * @var Array
	 */
	protected $kolumny = array();


	/**
	 * Tablica przechowująca konfigurację
	 *
	 * @var Array
	 */
	protected $konfiguracja = array();


	/**
	 * Ręcznie zdefiniowane kolumny sortowania
	 *
	 * @var Array
	 */
	protected $kolumnySortowane;


	/**
	 * Funkcja odpowiedzialna za przetworzenie danych wierszy
	 * Przyjmuje 2 parametry - obiekt grida i wiersz.
	 * Musi zwracać wiersz.
	 *
	 * @var Array
	 */
	protected $funkcjaPrzetwarzajajacaWiersze;


	/**
	 * Dane do wstawienia do grida
	 *
	 * @var Array
	 */
	protected $dane = array();


	/**
	 * Ilość wierszy
	 *
	 * @var Int
	 */
	protected $ilosc;


	public function __construct() {
		$this->grid = new Gui\Html();

		$this->konfiguracja = array(
			'wierszy_na_stronie' => 20,
			'domyslne_sortowanie' => 'data_dodania',
			'domyslne_sortowanie_kierunek' => 'desc',
			'szablonFormularz' => SZABLON_FORMULARZ,
			'szablonPager' => 'pager_nowy.tpl',
		);

		$this->funkcjaPrzetwarzajajacaWiersze = function ($grid, $wiersz) { return $wiersz; };
	}

	/**
	 * Zwraca instancje obiektu tabeli danych
	 *
	 * @return \Generic\Biblioteka\TabelaDanych\Gui\Html
	 */
	public function grid()
	{
		return $this->grid;
	}


	/**
	 * Ustawia listę kolumn w gridzie. Pierwszy element tablicy to klucz podstawowy
	 *
	 * @param Array $listaKolumn tablica przechowująca listę kolumn
	 *
	 * @return \Generic\Biblioteka\Pomocnik\TabelaHtml
	 */
	public function ustawKolumny(Array $listaKolumn)
	{
		$this->kolumny = $listaKolumn;

		return $this;
	}


	/**
	 * Wstawia kolumny do obiektu grida.
	 *
	 * @return \Generic\Biblioteka\Pomocnik\TabelaHtml
	 */
	protected function dodajKolumny()
	{
		$kolumnyDoWstawienia = array();
		$nazwaMappera = $this->nazwaMappera;
		foreach ($this->kolumny as $klucz => $wartosc)
		{
			switch ($wartosc)
			{
				case 'wszystko' : {
					foreach (array_keys(Cms::inst()->dane()->$nazwaMappera()->pobierzPolaTabeliObiekt()) as $kolumna)
					{
						if ( ! isset($kolumnyDoWstawienia[$kolumna]))
						{
							$kolumnyDoWstawienia[$kolumna] = 0;
						}
					}
				} break;
				case '!wszystko' : {
					$kolumnyDoWstawienia = array();
				} break;
				default: {
					if (is_int($wartosc))
					{
						$kolumnyDoWstawienia[$klucz] = $wartosc;
					}
					else
					{
						if (str_cut($wartosc, 1, false) == '!' && isset($kolumnyDoWstawienia[substr($wartosc, 1)]))
						{
							unset($kolumnyDoWstawienia[substr($wartosc, 1)]);
						}
						else
						{
							$kolumnyDoWstawienia[$wartosc] = 0;
						}
					}
				} break;
			}
		}

		$pierwszaKolumna = true;
		foreach ($kolumnyDoWstawienia as $klucz => $wartosc)
		{
			$this->grid->dodajKolumne($klucz, $pierwszaKolumna ? '' : $this->tlumaczenia['etykieta_' . $klucz], $wartosc, '', $pierwszaKolumna);

			$pierwszaKolumna = false;
		}

		return $this;
	}

	/**
	 * Pobiera tablice z tlumaczeniami.
	 *
	 * @return array
	 */
	public function pobierzTlumaczenia()
	{
		return $this->tlumaczenia;
	}



	/**
	 * Ustawia nowe tlumaczenia.
	 *
	 * @param array $tlumaczenia Tablica z nowymi tlumaczeniami.
	 *
	 * @return boolean
	 */
	public function ustawTlumaczenia($tlumaczenia = array())
	{
		if (is_array($tlumaczenia) && $this->tlumaczenia = array_merge($this->tlumaczenia, $tlumaczenia))
		{
			return $this->grid->ustawTlumaczenia($tlumaczenia);
		}
		return false;
	}

	/**
	 * @return \Generic\Biblioteka\Pomocnik\TabelaHtml
	 */
	public function dodajPrzyciski()
	{
		if ($this->szablonUrlPrzyciski == '')
		{
			trigger_error('Szablon URL dla przycisków nie został zdefiniowany.');
		}
		else
		{
			$this->grid->dodajPrzyciski($this->szablonUrlPrzyciski, func_get_args());
		}

		return $this;
	}


	/**
	 * Ustawia formularz wyszukiwania nad gridem
	 *
	 * @param \Generic\Biblioteka\Formularz $formularz
	 *
	 * @return \Generic\Biblioteka\Pomocnik\TabelaHtml
	 */
	public function ustawFormularzWyszukiwania(Formularz $formularz)
	{
		$this->formularzWyszukiwania = $formularz;

		return  $this;
	}


	/**
	 * Ustawia kolumny sortowane
	 *
	 * @param array $kolumnySortowane
	 * @return \Generic\Biblioteka\Pomocnik\TabelaHtml
	 */
	public function ustawKolumnySortowane(Array $kolumnySortowane)
	{
		$this->kolumnySortowane = $kolumnySortowane;

		return  $this;
	}


	/**
	 * Ustawia szablon url'i przycisków
	 *
	 * @param String $szablonUrl
	 * @return \Generic\Biblioteka\Pomocnik\TabelaHtml
	 */
	public function ustawSzablonUrlPrzyciskow($szablonUrl)
	{
		$this->szablonUrlPrzyciski = $szablonUrl;

		return  $this;
	}


	/**
	 * Ustawia kryteria początkowe danych grida
	 *
	 * @param mixed $kryteria kryteria początkowe
	 *
	 * @return  \Generic\Biblioteka\Pomocnik\TabelaHtml
	 */
	public function ustawKryteriaPoczatkowe($kryteria)
	{
		$this->kryteriaPoczatkowe = $kryteria;

		return $this;
	}

	/**
	 * Ustawia parametry źródła danych dla grida i wczytuje  z niego dane
	 *
	 * @param String $nazwaMappera Nazwa mappera z kontenera mapperów
	 * @param boolean $tylkoZwroc - jeśli ustawione to nie wpisuje pobranych danych do grida
	 * @param String $nazwaIlosc - nazwa metody pobierającej ilość obiektu nazwaMappera
	 * @param String $nazwaSzukaj - nazwa metody wyszukującej obiektu nazwaMappera
	 *
	 * @return Array - tablica z danymi do grida
	 */
	public function wczytajDane($nazwaMappera, $tylkoZwroc = false, $nazwaIlosc = 'iloscSzukaj', $nazwaSzukaj = 'szukaj')
	{
		$this->nazwaMappera = $nazwaMappera;
		$this->nazwaIlosc = $nazwaIlosc;
		$this->nazwaSzukaj = $nazwaSzukaj;

		$this->ilosc = 0;
		$this->dane = array();
		$kryteria = $this->kryteriaPoczatkowe;

		if ($this->formularzWyszukiwania instanceof Formularz)
		{
			$kryteria = array_merge($kryteria, $this->formularzWyszukiwania->pobierzWartosci());
			$this->grid->naglowek($this->formularzWyszukiwania->html($this->ladujSzablon($this->konfiguracja['szablonFormularz']), true));
		}

		if ($this->nazwaMappera != '' && $this->nazwaIlosc =! '' && $this->nazwaSzukaj != '' && $this->nazwaSzukaj == $this->nazwaIlosc)
		{
			$this->ilosc = count(Cms::inst()->dane()->$nazwaMappera()->$nazwaIlosc($kryteria));
		}
		elseif ($this->nazwaMappera != '' && $this->nazwaIlosc =! '' && $this->nazwaSzukaj != '')
		{
			$this->ilosc = Cms::inst()->dane()->$nazwaMappera()->$nazwaIlosc($kryteria);
		}
		else
		{
			trigger_error('Nie ustawiono poprawnego źródla danych grida.');
		}

		if ($this->ilosc > 0)
		{
			$nrStrony = Zadanie::pobierz($this->nrStronyParametr, 'intval','abs');
			$naStronie = Zadanie::pobierz($this->naStronieParametr, 'intval', 'abs');
			$kolumna = Zadanie::pobierz($this->kolumnaParametr, 'strval', 'trim');
			$kierunek = Zadanie::pobierz($this->kierunekParametr, 'strval', 'trim');

			$naStronie = ($naStronie > 0) ? $naStronie : $this->konfiguracja['wierszy_na_stronie'];
			$nrStrony = $nrStrony == 0 ? 1 : $nrStrony;
			$kolumna = ($kolumna != '') ? $kolumna : $this->konfiguracja['domyslne_sortowanie'];
			$kierunek = $kierunek == '' ? $this->konfiguracja['domyslne_sortowanie_kierunek'] : $kierunek;

			if ($naStronie > $this->ilosc) $naStronie = $this->ilosc;
			$pager = new Pager\Html($this->ilosc, $naStronie, $nrStrony);
			$pager->ustawSzablon($this->ladujSzablon($this->konfiguracja['szablonPager']), false);

			if (isset($this->konfiguracja['pager_konfiguracja']))
			{
				$pager->ustawKonfiguracje($this->konfiguracja['pager_konfiguracja']);
			}

			$this->grid->pager($pager->html(str_replace(array('{KOLUMNA}', '{KIERUNEK}'),  array($kolumna, $kierunek), $this->szablonUrl)));

			$nazwaSortera = '\\Generic\\Model\\' . $this->nazwaMappera . '\\Sorter';

			$sorter = new $nazwaSortera($kolumna, $kierunek);

			if (is_array($this->kolumnySortowane))
			{
				$dozwoloneSortowanie = $this->kolumnySortowane;
			}
			else
			{
				$dozwoloneSortowanie = array_intersect(array_keys($sorter->mozliweKolumny()), $this->kolumny);
			}

			if ($this->grid->pobierzIloscKolumn() == 0)
			{
				$this->dodajKolumny();
			}

			$this->dane = Cms::inst()->dane()->$nazwaMappera()->zwracaTablice()->$nazwaSzukaj($kryteria, $pager, $sorter);

			$this->grid->ustawSortownie($dozwoloneSortowanie, $kolumna, $kierunek,
				str_replace(array('{NR_STRONY}', '{NA_STRONIE}'),  array($nrStrony, $naStronie), $this->szablonUrl)
			);

			if ( ! $tylkoZwroc)
			{
				$funkcjaPrzetwarzajaca = $this->funkcjaPrzetwarzajajacaWiersze;
				foreach ($this->dane as $wiersz)
				{
					$wiersz = $funkcjaPrzetwarzajaca($this->grid, $wiersz);

					if (is_array($wiersz))
					{
						$this->grid->dodajWiersz($wiersz);
					}
				}
			}
		}

		return $this->dane;
	}

	/**
	 * Ustawia dane do grida
	 *
	 * @param array $dane
	 * @return \Generic\Biblioteka\Pomocnik\TabelaHtml
	 */
	public function ustawDane(Array $dane)
	{
		$this->dane = $dane;

		return $this;
	}

	/**
	 * Generuje grida i zwraca HTML
	 *
	 * @return String;
	 */
	public function html($nazwaSzablonu = null)
	{
		if ($nazwaSzablonu != null)
		{
			return $this->grid->html($this->ladujSzablon($nazwaSzablonu), true);
		}
		else
		{
			return $this->grid->html();
		}
	}


	/**
	 * Ustawia parametry urli oraz domyslne sortowanie
	 *
	 * @param String $nrStronyParametr
	 * @param String $naStronieParametr
	 * @param String $kolumnaParametr
	 * @param String $kierunekParametr
	 *
	 * @return  \Generic\Biblioteka\Pomocnik\TabelaHtml
	 */
	public function ustawParametrySorterPager($nrStronyParametr = 'url_parametr_1', $naStronieParametr = 'url_parametr_2', $kolumnaParametr = 'url_parametr_3', $kierunekParametr = 'url_parametr_4')
	{
		$this->nrStronyParametr = $nrStronyParametr;
		$this->naStronieParametr = $naStronieParametr;
		$this->kolumnaParametr = $kolumnaParametr;
		$this->kierunekParametr = $kierunekParametr;

		return $this;
	}


	/**
	 * Ustawia szablon url dla pagera i sortera
	 *
	 * @param String $szablonUrl
	 *
	 * @return  \Generic\Biblioteka\Pomocnik\TabelaHtml
	 */
	public function ustawSzablonUrl($szablonUrl)
	{
		$this->szablonUrl = $szablonUrl;

		return $this;
	}


	/**
	 * Zwraca tablice z konfiguracja dla modulu.
	 *
	 * @return array
	 */
	public function pobierzKonfiguracje()
	{
		return $this->konfiguracja;
	}



	/**
	 * Ustawia nowa konfiguracje dla modulu.
	 *
	 * @param array $konfiguracja Tablica z konfiguracja dla modulu.
	 *
	 * @return  \Generic\Biblioteka\Pomocnik\TabelaHtml
	 */
	public function ustawKonfiguracje($konfiguracja)
	{
		$this->konfiguracja = array_merge($this->konfiguracja, $konfiguracja);

		return $this;
	}


	/**
	 * Ustawia funkcję, która będzie przetwarzała każdy wiersz przed wpisaniem do grida
	 *
	 * @param type $funkcja
	 *
	 * @return  \Generic\Biblioteka\Pomocnik\TabelaHtml
	 */
	public function ustawFunkcjePrzetwarzajacaWiersze($funkcja)
	{
		if ( !is_callable($funkcja))
		{
			trigger_error('Nie podano prawidlowej funkcji przetwarzającej wiersze.');
		}
		else
		{
			$this->funkcjaPrzetwarzajajacaWiersze = $funkcja;
		}

		return $this;
	}


	/**
	 * Laduje szablon zewnetrzny
	 *
	 * @param string $sciezkaSzablonu Sciezka szablonu
	 */
	protected function ladujSzablon($sciezkaSzablonu)
	{
		if (empty($sciezkaSzablonu))
		{
			trigger_error('Nie podano sciezki do pliku szablonu', E_USER_WARNING);
		}

		return Plik::pobierzTrescPliku(SZABLON_KATALOG.'/'.ltrim($sciezkaSzablonu, '/'));
	}
}