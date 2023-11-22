<?php
namespace Generic\Biblioteka\TabelaDanych\Gui;
use Generic\Biblioteka\TabelaDanych\Gui;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\Szablon;
use Generic\Biblioteka\TabelaDanych;

/**
 * Klasa generuje widok tabeli danych (data grid) HTML
 *
 * @author Krzysztof Lesiczka, Konrad Rudowski
 * @package biblioteki
 */

class Html extends Gui
{
	/**
	 * Zmienne przetrzymujące treść HTML sekcji tablic danych
	 */

	protected $naglowekHtml = '';
	protected $stopkaHtml = '';
	protected $pagerHtml = '';
	protected $pagerSelektorHtml = '';


	/**
	 * Zwraca html z gotową tabelą
	 *
	 * @param string $plikSzablonu Plik szablonu kóry należy wczytać
	 */
	public function html($szablon = '', $szablonTresc = false)
	{
		$iloscKolumn = count($this->kolumny);
		if (empty($this->przyciski))
		{
			--$iloscKolumn;
		}

		$iloscWierszy = count($this->wiersze);
		if ($iloscKolumn < 1)
		{
			throw new TabelaDanych\Wyjatek('Nie zadeklarowano żadnych kolumn do wyswietlenia', E_USER_NOTICE);
		}

		if ( ! $szablonTresc)
		{
			$szablon = ($szablon != '') ? $szablon : CMS_KATALOG.'/' . SZABLON_SYSTEM . '/'.SZABLON_TABELA_DANYCH;
			$szablon = Plik::pobierzTrescPliku($szablon);
		}

		$tabela = new Szablon();
		$tabela->ladujTresc($szablon);
		$tabela->ustawGlobalne(
			array(
				'etykieta_zaznacz_wszystkie' => $this->tlumaczenia['etykieta_zaznacz_wszystkie'],
				'etykieta_odznacz_wszystkie' => $this->tlumaczenia['etykieta_odznacz_wszystkie'],
				'etykieta_usun_zaznaczone' => $this->tlumaczenia['etykieta_usun_zaznaczone'],
				'blad_zaznaczenie_puste' => $this->tlumaczenia['blad_zaznaczenie_puste'],
				'ilosc_kolumn' => $iloscKolumn, // uwzglednione kolumny akcji i zaznaczenia
				'pager_html' => $this->pagerHtml,
				'pager_selektor_html' => $this->pagerSelektorHtml,
			)
		);

		// naglowek tabeli
		if ($this->naglowekHtml != '')
		{
			$tabela->ustawBlok('naglowek', array('naglowek_html' => $this->naglowekHtml));
		}

		// wlaczenie obslugi akcji na wielu wierszach
		if (!empty($this->przyciskiGrupowe) && $this->kolumnyKlucz != '')
		{
			$tabela->ustawBlok('skrypt_zaznaczenie', array());
			$tabela->ustawBlok('naglowek_kolumna_zaznaczenie', array());
			$tabela->ustawBlok('stopka_kolumna_zaznaczenie', array());
		}

		// generowanie kolumn naglowkowych dla tabeli
		foreach($this->kolumnyDeklaracje as $kolumna)
		{
			if ($kolumna['nazwa'] == $this->kolumnyKlucz)
			{
				continue;
			}

			$szerokosc = ($kolumna['szerokosc'] > 0) ? $kolumna['szerokosc'] : '';

			$klasa = $kolumna['nazwa'] .' ' . ((in_array($kolumna['nazwa'], $this->sortowanieKolumny) && $this->sortowanieBiezaca == $kolumna['nazwa']) ? 'sort '.$this->sortowanieKierunek : 'sort inactive');

			$tabela->ustawBlok('naglowek_kolumna_zwykla', array(
				'szerokosc' => $szerokosc,
				'klasa' => $klasa,
				'etykieta_kolumny' => $kolumna['etykieta']
			));

			if(in_array($kolumna['nazwa'], $this->sortowanieKolumny))
			{
				$kierunek = ($this->sortowanieKierunek == 'asc') ? 'desc': 'asc';
				$url = htmlspecialchars(str_replace(array('{KOLUMNA}', '{KIERUNEK}'), array($kolumna['nazwa'], $kierunek), $this->sortowanieUrl));

				$tabela->ustawBlok('/naglowek_kolumna_zwykla/sortowanie_start', array(
					'url' => $url,
					'klasa' => $klasa,
					'etykieta_kolumny' => $kolumna['etykieta'],
					'etykieta_sortuj_po' => $this->tlumaczenia['etykieta_sortuj_po'].$kolumna['etykieta'],
				));
				$tabela->ustawBlok('/naglowek_kolumna_zwykla/sortowanie_stop', array());
			}
		}

		if (!empty($this->przyciski))
		{
			$tabela->ustawBlok('naglowek_kolumna_przyciski', array('szerokosc' => (count($this->przyciski) * 30 + 20)));
		}

		$licznik = 1;
		if ($iloscWierszy < 1)
		{
			$tabela->ustawBlok('wiersz_brak_danych', array(
				'etykieta_brak_wierszy' => $this->tlumaczenia['etykieta_brak_wierszy'],
				'ilosc_kolumn' => $iloscKolumn + (!empty($this->przyciskiGrupowe) ? 1 : 0),
			));
		}
		else
		{
			$atrybuty = '';
			// generowanie wierszy tabeli z trescia
			foreach($this->wiersze as $wiersz)
			{
				$klasa = ($licznik % 2) ? 'nieparzysty' : 'parzysty';
				$wartoscKlucza = $wiersz[$this->kolumnyKlucz];

				$tabela->ustawBlok('wiersz', array(
					'klasa' => $klasa . (isset($wiersz['_ustaw_klase_']) ? $wiersz['_ustaw_klase_'] : ''),
					'atrybuty' => (isset($wiersz['_ustaw_atrybuty_'])) ? $wiersz['_ustaw_atrybuty_'] : '',
					'wartosc_klucza' => $wartoscKlucza
				));

				foreach($this->kolumnyDeklaracje as $kolumna)
				{
					// wlaczenie obslugi akcji na wielu wierszach
					if (!empty($this->przyciskiGrupowe) && $kolumna['nazwa'] == $this->kolumnyKlucz)
					{
						$tabela->ustawBlok('wiersz/kolumna_zaznaczenie', array(
							'klasa' => $klasa,
							'nazwa_klucza' => $this->kolumnyKlucz,
							'wartosc_klucza' => $wartoscKlucza
						));
						continue;
					}
					elseif (empty($this->przyciskiGrupowe) && $kolumna['nazwa'] == $this->kolumnyKlucz)
					{
						continue;
					}

					if ($kolumna['akcja'] != '')
					{
						$kolumna['akcja'] = htmlspecialchars(str_replace(array('{KLUCZ}', '{WARTOSC}'), array($this->kolumnyKlucz, $wartoscKlucza), $kolumna['akcja']));

						$tabela->ustawBlok('wiersz/kolumna', array('klasa' => $klasa));
						$tabela->ustawBlok('wiersz/kolumna/akcja', array(
							'klasa' => $klasa,
							'url' => $kolumna['akcja'],
							'tresc_kolumny' => $wiersz[$kolumna['nazwa']]
						));
					}
					//Sprawdzenie czy do kolumny z aktualnego wiersza zostala przypisana jakas akcja
					elseif(isset($this->wierszAkcje[$licznik-1][$kolumna['nazwa']]))
					{
						$tabela->ustawBlok('wiersz/kolumna', array('klasa' => $klasa));
						$tabela->ustawBlok('wiersz/kolumna/akcja', array(
							'klasa' => $klasa,
							'url' => $this->wierszAkcje[$licznik-1][$kolumna['nazwa']],
							'tresc_kolumny' => $wiersz[$kolumna['nazwa']]
						));
					}
					else
					{
						$tabela->ustawBlok('wiersz/kolumna', array(
							'klasa' => $klasa,
							'tresc_kolumny' => $wiersz[$kolumna['nazwa']]
						));
					}
				}

				//renderowanie przyciskow
				if (!empty($this->przyciski))
				{
					$url = '';
					$przycisk = array();
					$tabela->ustawBlok('wiersz/kolumna_przyciski', array('klasa' => $klasa));
					foreach ($this->przyciski as $przycisk)
					{
						if( isset($przycisk['klucz'])
							&& (isset($wiersz['_przyciski_usun_']) && is_array($wiersz['_przyciski_usun_']))
							&& array_search($przycisk['klucz'], $wiersz['_przyciski_usun_']) !== false )
						{
							if ($this->uzupelniajKropkami)
								$tabela->ustawBlok('wiersz/kolumna_przyciski/przycisk_pusty');
							continue;
						}

						//Sprawdzenie czy mamy nadpisac domyslna akcje przycisku
						if(isset($przycisk['klucz']) && isset($this->wierszAkcjePrzyciski[$licznik-1][$przycisk['klucz']]))
							$url = $this->wierszAkcjePrzyciski[$licznik-1][$przycisk['klucz']];
						else
							$url = htmlspecialchars(str_replace(array('{KLUCZ}', '{WARTOSC}'), array($this->kolumnyKlucz, $wartoscKlucza), $przycisk['akcja']));
						$parametry = '';
						foreach ($przycisk as $klucz => $wartosc)
						{
							if (!in_array($klucz, array('akcja', 'etykieta', 'ikona', 'klasa_przycisku'))) $parametry .= $klucz.'="'.$wartosc.'"';
						}
						
						if (array_key_exists('ikona', $przycisk))
						{
							$tabela->ustawBlok('wiersz/kolumna_przyciski/przycisk', array(
								'url' => $url,
								'parametry' => $parametry,
								'etykieta' => $przycisk['etykieta'],
								'klasa_przycisku' => $przycisk['klasa_przycisku'],
							));
							$tabela->ustawBlok('wiersz/kolumna_przyciski/przycisk/ikona', array(
								'etykieta' => $przycisk['etykieta'],
								'ikona' => $przycisk['ikona'],
							));
						}
						else
						{
							$tabela->ustawBlok('wiersz/kolumna_przyciski/przycisk', array(
								'url' => $url,
								'etykieta' => $przycisk['etykieta'],
								'parametry' => $parametry,
								'klasa_przycisku' => $przycisk['klasa_przycisku'],
							));
						}
					}
				}
				$licznik++;
				$wiersz++;
			}
		}

		//renderowanie przyciskow grupowych
		if (!empty($this->przyciskiGrupowe))
		{
			$przycisk = array();
			foreach ($this->przyciskiGrupowe as $przycisk)
			{
				$parametry = '';
				foreach ($przycisk as $klucz => $wartosc)
				{
					if (!in_array($klucz, array('akcja', 'etykieta', 'ikona'))) $parametry .= $klucz.'="'.$wartosc.'"';
				}
				if (array_key_exists('ikona', $przycisk))
				{
					$tabela->ustawBlok('stopka_kolumna_zaznaczenie/przycisk', array(
						'url' => htmlspecialchars($przycisk['akcja']),
						'etykieta' => $przycisk['etykieta'],
						'parametry' => $parametry,
					));
					$tabela->ustawBlok('stopka_kolumna_zaznaczenie/przycisk/ikona', array(
						'ikona' => $przycisk['ikona'],
					));
				}
				else
				{
					$tabela->ustawBlok('stopka_kolumna_zaznaczenie/przycisk', array(
						'url' => htmlspecialchars($przycisk['akcja']),
						'etykieta' => $przycisk['etykieta'],
						'parametry' => $parametry,
					));
				}
			}
		}

		// stopka tabeli
		if ($this->stopkaHtml != '')
		{
			$tabela->ustawBlok('stopka', array('stopka_html' => $this->stopkaHtml));
		}

		return $tabela->parsuj();
	}



	/**
	 * Ustawia tresc naglowka
	 *
	 * @param string $tresc Tresc naglowka
	 */
	function naglowek($tresc)
	{
		$this->naglowekHtml = $tresc;
	}



	/**
	 * Ustawia tresc stopki
	 *
	 * @param string $tresc Tresc stopki
	 */
	function stopka($tresc)
	{
		$this->stopkaHtml = $tresc;
	}



	/**
	 * Ustawia tresc pagera w stopce
	 *
	 * @param string $html Tresc html pager-a
	 */
	public function pager($html)
	{
		$this->pagerHtml = $html;
	}



	/**
	 * Ustawia dodatkową tresc pagera w stopce
	 *
	 * @param string $html Tresc html pager-a
	 */
	public function pagerSelektor($html)
	{
		$this->pagerSelektorHtml = $html;
	}


}