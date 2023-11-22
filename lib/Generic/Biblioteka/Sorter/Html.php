<?php
namespace Generic\Biblioteka\Sorter;
use Generic\Biblioteka\Tlumaczenia;
use Generic\Biblioteka\WierszKonfiguracji;
use Generic\Biblioteka;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Szablon;
use Generic\Biblioteka\Plik;


/**
 * Klasa obslugujaca sortowanie (generowanie htmla)
 *
 * @author Łukasz Wrucha
 * @package biblioteki
 */

class Html implements Tlumaczenia\Interfejs, Konfiguracja\Interfejs
{

	/**
	 * Tablica tlumaczen domyslnych
	 *
	 * @var array
	 */
	protected $tlumaczenia = array(
	);


	/**
	 * Konfiguracja domyślna
	 *
	 * @var array
	 */
	protected $konfiguracja = array(

	);


	/**
	 * Prztrzymuje obiekt sortera
	 * @var Sorter
	 */
	protected $sorter;

	/**
	 * Obiekt szablonu
	 *
	 * @var Szablon
	 */
	protected $szablon = null;

	/**
	 * Domyslana tresc szablonu
	 *
	 * @var string
	 */
	protected $tpl = '
{{BEGIN html}}
<div class="sorter">
	{{$etykieta_sorter}} {{$sorter}}
</div>
{{END}}

{{BEGIN sorter_select}}
	<select>
		{{BEGIN opcja}}
		<option value="{{$url}}" {{if($selected, \'selected="selected"\')}}>{{$etykieta}}</option>
		{{END}}
	</select>
	<script type="text/javascript">
	$(document).ready(function(){
		$(".sorter select").change(function(){
			document.location.href = $(this).val();
			return false;
		});
	});
	</script>
{{END}}

{{BEGIN sorter_linki}}
	{{BEGIN link}} {{ if($_first,\'\',\' | \') }}<a href="{{$url}}" title="{{escape($tytul)}}" class="{{$klasa}}">{{$etykieta}}</a>{{END}}
	{{BEGIN etykieta}} {{ if($_first,\'\',\' | \') }}<span class="{{$klasa}}">{{$etykieta}}</span>{{END}}
{{END}}
	';


	/**
	 * Tablica przetrzymujaca strukturę szablonu potrzebna do walidacji
	 *
	 * @var array
	 */
	protected $strukturaTpl = array(
		'/html/',
		'/sorter_select/',
		'/sorter_select/opcja/',
		'/sorter_linki/',
		'/sorter_linki/link/',
		'/sorter_linki/etykieta/',
	);


	/**
	 * Konstruktor, ustawia partemetry poczatkowe sorter-a.
	 *
	 * @param Sorter $sorter Sorter z którego generujemy html
	 *
	 */
	public function __construct(Biblioteka\Sorter $sorter)
	{
		$this->sorter = $sorter;
		$this->ustawTlumaczenia(Cms::inst()->lang['sortery']);
	}



	/**
	 * Wyświetlanie pełnego przetworzonego szablonu
	 *
	 * @param string $url Link do przetworzenia
	 * @param array $mozliweSortowania tablica sortowań do wyświetlenia
	 *
	 * @return string
	 */
	public function html($url, $mozliweSortowania = array(), $zablokowaneKierunki = array())
	{
		$this->inicjujSzablon();
		return $this->szablon->parsujBlok('/html', array(
			'sorter' => $this->sorterHtml($url, $mozliweSortowania, $zablokowaneKierunki),
		));
	}


	protected function sorterHtml($url, $mozliweSortowania, $zablokowaneKierunki)
	{
		$cms = Cms::inst();
		//Rodzaj sortera - jeśli nie ustawiony, wybieramy domyślny
		$rodzaj = (isset($this->konfiguracja['rodzaj']) && $this->konfiguracja['rodzaj'] == 'select') ? 'select': 'linki';

		$kolumna = $this->sorter->wybraneSortowanie();
		$kierunek = $this->sorter->wybranyPorzadek();

		if (count($mozliweSortowania) > 0)
		{
			$roznice = array_diff($mozliweSortowania, array_keys($this->sorter->mozliweKolumny()));
			if (count($roznice) > 0)
			{
				trigger_error("Podano nieznane kolumny do sortowania: ".implode(', ', $roznice), E_USER_WARNING);
				$kolumny = array_intersect(array_keys($this->sorter->mozliweKolumny()), $mozliweSortowania);
			}
			else $kolumny = $mozliweSortowania;

		}
		else
		{
			$kolumny = array_keys($this->sorter->mozliweKolumny());
		}

		if ($rodzaj == 'linki')
		{
			$tresc = '';
			$i = 0;
			foreach ($kolumny as $_kolumna)
			{
				$element = 'link';
				$klasa = '';
				$kierunek_wyswietlania = $kierunek;
				if ($_kolumna == $kolumna)
				{
					$klasa = strtolower($kierunek);
					$klasa .= ' active';
					$klasa .= ($kierunek == 'ASC') ? ' up' : '';

					if (count($zablokowaneKierunki) > 0 && array_key_exists($_kolumna, $zablokowaneKierunki))
					{
						$element = 'etykieta';
					}

					$nowy_kierunek = $this->sorter->porzadekOdwrotny();
				}
				else
				{
					if (count($zablokowaneKierunki) > 0 && array_key_exists($_kolumna, $zablokowaneKierunki))
					{
						$nowy_kierunek = strtolower($zablokowaneKierunki[$_kolumna]);
						$kierunek_wyswietlania = strtolower($zablokowaneKierunki[$_kolumna]);
					}
					else
					{
						$nowy_kierunek = $kierunek;
						$kierunek_wyswietlania = 'asc';
					}
				}


				$nowy_kierunek = strtolower($nowy_kierunek);

				if (isset($this->tlumaczenia[$_kolumna.'_'.strtolower($kierunek_wyswietlania)]))
				{
					$etykieta = $this->tlumaczenia[$_kolumna.'_'.strtolower($kierunek_wyswietlania)];
				}
				else if (isset($this->tlumaczenia[$_kolumna]))
				{
					$etykieta = $this->tlumaczenia[$_kolumna];
				}
				else
				{
					trigger_error('Brak tłumaczeń dla klucza kolumny: '.$_kolumna, E_USER_WARNING);
				}

				$link = strtr($url, array('{KOLUMNA}' => $_kolumna, '{KIERUNEK}' => $nowy_kierunek));

				$tresc .= $this->szablon->parsujBlok('/sorter_linki/'.$element, array(
					'etykieta' => $etykieta,
					'url' => $link,
					'url_seo' => strToHex($link),
					'tytul' => sprintf($cms->lang['sortery']['etykieta_'.$nowy_kierunek], $etykieta),
					'klasa' => $klasa,
				));
				$i++;
			}
			return $tresc;
		}
		else
		{
			$kierunki = array('asc', 'desc');
			$znajdz = array('{KOLUMNA}', '{KIERUNEK}');

			foreach ($kolumny as $_kolumna)
			{
				if (count($zablokowaneKierunki) > 0 && array_key_exists($_kolumna, $zablokowaneKierunki))
				{
					if (isset($this->tlumaczenia[$_kolumna.'_'.strtolower($zablokowaneKierunki[$_kolumna])]))
					{
						$etykieta = $this->tlumaczenia[$_kolumna.'_'.strtolower($zablokowaneKierunki[$_kolumna])];
					}
					else if (isset($this->tlumaczenia[$_kolumna]))
					{
						$etykieta = sprintf($cms->lang['sortery']['etykieta_select_'.strtolower($zablokowaneKierunki[$_kolumna])], $this->tlumaczenia[$_kolumna]);
					}
					else
					{
						trigger_error('Brak tłumaczeń dla klucza kolumny: '.$_kolumna, E_USER_WARNING);
					}

					$zamien = array($_kolumna, strtolower($zablokowaneKierunki[$_kolumna]));
					$link = str_replace($znajdz, $zamien, $url);
					$this->szablon->ustawBlok('/sorter_select/opcja', array(
						'url' => $link,
						'url_seo' => strToHex($link),
						'etykieta' => $etykieta,
						'selected' => ($kolumna == $_kolumna && strtolower($kierunek) == strtolower($zablokowaneKierunki[$_kolumna])) ? 1 : 0,
					));
				}
				else
				{
					foreach ($kierunki as $_kierunek)
					{
						if (isset($this->tlumaczenia[$_kolumna.'_'.$_kierunek]))
						{
							$etykieta = $this->tlumaczenia[$_kolumna.'_'.$_kierunek];
						}
						else if (isset($this->tlumaczenia[$_kolumna]))
						{
							$etykieta = sprintf($cms->lang['sortery']['etykieta_'.$_kierunek], $this->tlumaczenia[$_kolumna]);
						}
						else
						{
							trigger_error('Brak tłumaczeń dla klucza kolumny: '.$_kolumna, E_USER_WARNING);
						}

						$zamien = array($_kolumna, $_kierunek);
						$link = str_replace($znajdz, $zamien, $url);
						$this->szablon->ustawBlok('/sorter_select/opcja', array(
							'url' => $link,
							'url_seo' => strToHex($link),
							'etykieta' => $etykieta,
							'selected' => ($kolumna == $_kolumna && strtolower($kierunek) == $_kierunek) ? 1 : 0,
						));
					}
				}
			}
			return $this->szablon->parsujBlok('/sorter_select');
		}
	}


	protected function inicjujSzablon()
	{
		if (!($this->szablon instanceof Szablon))
		{
			$this->szablon = new Szablon();
			$this->szablon->ladujTresc($this->tpl);

			$this->szablon->ustawGlobalne($this->tlumaczenia);

		}
	}


	/**
	 * Ustawia używany szablon
	 *
	 * @param string $trescSzablonu Nazwa pliku lub kod szablonu
	 * @param boolean $plik Informacja czy pierwszy parametr jest plikiem (true) czy stringiem (false)
	 */
	public function ustawSzablon($trescSzablonu, $plik = true)
	{
		$this->inicjujSzablon();

		if ($plik)
		{
			if (is_file($trescSzablonu))
			{
				$nowySzablon = new Szablon();
				$nowySzablon->ladujTresc(Plik::pobierzTrescPliku($trescSzablonu));
			}
			else
			{
				trigger_error('Brak pliku szablonu sortera: '.$trescSzablonu, E_USER_WARNING);
				return false;
			}
		}
		else
		{
			$nowySzablon = new Szablon();
			$nowySzablon->ladujTresc($trescSzablonu);
		}
		$nowyStruktura = $nowySzablon->struktura();
		$brakujace = array();
		foreach ($this->strukturaTpl as $element)
		{
			if ( ! in_array($element, $nowyStruktura)
				&&  ! in_array($element.'_seo', $nowyStruktura)) $brakujace[] = $element;
		}
		if (count($brakujace) > 0)
		{
			trigger_error('Nieprawidlowa struktura zaladowanego szablonu dla sorter-a. Brak elementow: '.implode(', ', $brakujace), E_USER_WARNING);
			return false;
		}
		$this->szablon = $nowySzablon;
		$this->szablon->ustawGlobalne($this->tlumaczenia);

		return true;
	}



	/**
	 * Zwraca konfiguracje systemu
	 *
	 * @return array
	 */
	public function pobierzKonfiguracje()
	{
		return $this->konfiguracja;
	}



	/**
	 * Zmienia konfiguracje systemu. Możliwe opcje to:
	 * rodzaj - 'linki', 'select'
	 *
	 * @param array $config Tablica z konfiguracją
	 */
	public function ustawKonfiguracje($config)
	{
		if (!is_array($config) || count($config) < 1) { return false; }
		$this->konfiguracja = $config;
	}



	/**
	 * Zwraca tablice z tlumaczeniami.
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
			return true;
		}
		return false;
	}

}


