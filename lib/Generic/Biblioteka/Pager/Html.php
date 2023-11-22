<?php
namespace Generic\Biblioteka\Pager;
use Generic\Biblioteka\Pager;
use Generic\Biblioteka\Tlumaczenia;
use Generic\Biblioteka\Konfiguracja;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Szablon;
use Generic\Biblioteka\Plik;


/**
 * Klasa obslugujaca stronnicowanie
 *
 * @author Dariusz Poltorak
 * @package biblioteki
 */

class Html extends Pager implements Tlumaczenia\Interfejs, Konfiguracja\Interfejs
{

	/**
	 * Tablica tlumaczen domyslnych
	 *
	 * @var array
	 */
	protected $tlumaczenia = array(
		'pager_wstecz' => '&laquo;',
		'pager_przod' => '&raquo;',
		'pager_pierwsza' => '&laquo;',
		'pager_ostatnia' => '&raquo;',
		'pager_wybierz_strone' => '',
		'pager_wybierz_przedzial' => 'Przedział: ',
		'pager_wybierz_zakres' => 'Na stronie: ',
		'pager_pokaz_wszystko' => 'Wszystko',
		'pager_na_stronie' => ' Na stronie ',
		'pager_ilosc' => 'Wyników: ',
		'pager_skocz_do' => 'Skocz do strony:',
		'pager_wartosc_skocz_do' => '#'
	);


	/**
	 * Konfiguracja domyślna
	 *
	 * @var array
	 */
	protected $konfiguracja = array(
		'zakres' 				=> 3,
		'dostepneZakresy'		=> '5,10,20,50,100,200,500,wszystko',
		'wyborStrony'			=> 'linki',		//Opcje: '', 'linki', 'select'
		'wyborZakresu'			=> 'select',	//Opcje: '', 'linki', 'select'
		'skoczDo' 				=> '',			//Opcje: '', 'form'
		'pierwszaOstatnia'		=> false,
		'poprzedniaNastepna'	=> true,
		'pokazujWszystkieZakresy'=> true,
	);


	/**
	 * Tablica przetrzymujaca zakresy
	 *
	 * @var array
	 */
	protected $zakresy = array(5, 10, 20, 50, 100, 200, 500, 'wszystko');


	/**
	 * Obiekt szablonu
	 *
	 * @var Szablon
	 */
	protected $szablon = null;

	/**
	 * Obiekt szablonu dla nagłówka HTML
	 *
	 * @var Szablon
	 */
	protected $szablonHead = null;


	/**
	 * Domyslana tresc szablonu
	 * W calej tresci szablonu mozna uzywac wszystkie klucze tlumaczen oraz nastepujace todatkowe zmienne:
	 * "pager_wartosc_nrStrony", "pager_wartosc_naStronie", "pager_wartosc_ilosc", "pager_wartosc_iloscStron"
	 *
	 * @var string
	 */
	protected $tpl = '
{{BEGIN html}}
<div class="pager">
	<div class="gora"><b></b></div>
	<div class="tresc">
	<div class="r_left">{{$pager_ilosc}} <strong>{{$pager_wartosc_ilosc}}</strong></div>
	<div class="r_right">
	{{$wyborStrony}}
	{{$skoczDo}}
	{{$wyborZakresu}}
	</div>
	<div class="r_clear"></div>
	</div>
	<div class="dol"><b class="l"></b><b class="r"></b></div>
</div>
{{END}}

{{BEGIN linkiWyborStrony}}
<span class="stronicowanie">{{$pager_wybierz_strone}}<b class="b"></b><span class="stronicowanie_box">

	{{BEGIN skokPoprzednia}} <a href="{{$link}}" class="strzalka prev">{{$pager_wstecz}}</a> {{END}}
	{{BEGIN pierwszaStrona}} <a href="{{$link}}" class="first prev">{{$nrStrony}}</a> {{END}}
	{{BEGIN skokWstecz}} <a href="{{$link}}" class="{{if($pierwszy,\'first\')}} skok prev">{{$nrStrony}}</a> .. {{END}}
	{{BEGIN poprzedzajacaStrona}} <a href="{{$link}}" class="{{if($pierwszy,\'first\')}} prev">{{$nrStrony}}</a> {{END}}
	{{BEGIN biezacaStrona}} <strong class="{{if($pierwszy,\'first\')}} {{if($ostatni,\'last\')}} selected">{{$nrStrony}}</strong> {{END}}
	{{BEGIN nastepujacaStrona}} <a href="{{$link}}" class="{{if($ostatni,\'last\')}} next">{{$nrStrony}}</a> {{END}}
	{{BEGIN skokNaprzod}} .. <a href="{{$link}}" class="{{if($ostatni,\'last\')}} skok next">{{$nrStrony}}</a> {{END}}
	{{BEGIN ostatniaStrona}} <a href="{{$link}}" class="last next">{{$nrStrony}}</a> {{END}}
	{{BEGIN skokNastepna}} <a href="{{$link}}" class="strzalka next">{{$pager_przod}}</a> {{END}}
</span></span>
{{END}}

{{BEGIN selectWyborStrony}}
	{{$pager_wybierz_przedzial}}
	{{BEGIN poprzednia}} <a href="{{$link}}" class="strzalka prev">{{$pager_wstecz}}</a>{{END}}
	<select name="wybor_strony" onchange=" if (this.options[selectedIndex].value == \'1\') window.location = \'{{$urlPierwsza}}\'.replace(/{NA_STRONIE}/, {{$pager_wartosc_naStronie}}).replace(/{NR_STRONY}/, this.options[selectedIndex].value); else  window.location = \'{{$url}}\'.replace(/{NA_STRONIE}/, {{$pager_wartosc_naStronie}}).replace(/{NR_STRONY}/, this.options[selectedIndex].value);">
		{{BEGIN opcje}}<option value="{{$nrStrony}}" {{if($wybrany,"selected=\"selected\"")}}>{{$poczatek}} - {{$koniec}}</option>{{END}}
	</select>
	{{BEGIN nastepna}} <a href="{{$link}}" class="strzalka next">{{$pager_przod}}</a>{{END}}
{{END}}

{{BEGIN linkiWyborZakresu}}
	{{$pager_wybierz_zakres}}
	{{BEGIN opcje}}<a href="{{$link}}" class="{{if($wybrany,\'selected\')}}">{{$zakres}}</a> {{END}}
	{{BEGIN wszystko}}<a href="{{$link}}" class="{{if($wybrany,\'selected\')}}">{{$pager_pokaz_wszystko}}</a> {{END}}
{{END}}

{{BEGIN selectWyborZakresu}}
	{{$pager_wybierz_zakres}}
		<select name="naStronie" onchange="window.location = \'{{$url}}\'.replace(/{NR_STRONY}/, {{$pager_wartosc_nrStrony}}).replace(/{NA_STRONIE}/, this.options[selectedIndex].value);">
			{{BEGIN opcje}}<option value="{{$zakres_wartosc}}" {{if($wybrany,"selected=\"selected\"")}}>{{$zakres_etykieta}}</option>{{END}}
		</select>
{{END}}

{{BEGIN formSkoczDo}}
<script type="text/javascript">
<!--
$(document).ready(function(){

	$(".pager_form_{{$klasaform}} .skocz_do").keyup(function(){
		$(".pager_form_{{$klasaform}} .skocz_do").val($(this).val());
	});
	$(".pager_form_{{$klasaform}} .skocz_do").focus(function(){
		$(this).val(\'\');
	});
	$(".pager_form_{{$klasaform}} .skocz_do").blur(function(){
		$(this).val(\'{{$pager_wartosc_skocz_do}}\');
	});

	$(".pager_form_{{$klasaform}}").submit(function(){
		var wartosc = $(".pager_form_{{$klasaform}} .skocz_do").val();
		if ((!isNaN(wartosc) && parseInt(wartosc) == wartosc)
			&& (wartosc > 0 && wartosc <= parseInt(\'{{$ilosc_stron}}\')))
		{
			if (wartosc == "1" && \'{{$urlPierwsza_js}}\' != \'\')
			{
				document.location.href = \'{{$urlPierwsza_js}}\'.replace(/{NR_STRONY}/, wartosc).replace(/{NA_STRONIE}/, {{$pager_wartosc_naStronie}});
			}
			else
			{
				document.location.href = \'{{$url_js}}\'.replace(/{NR_STRONY}/, wartosc).replace(/{NA_STRONIE}/, {{$pager_wartosc_naStronie}});
			}
		}
		else
		{
			$(".pager_form_{{$klasaform}} .skocz_do").val(\'\');
		}
		return false;
	});
});
-->
</script>
<form class="pager_form_{{$klasaform}} pager_form" action="#">
	{{$pager_skocz_do}}<input type="text" name="strona" class="skocz_do" size="1" value="{{$pager_wartosc_skocz_do}}"/>
</form>
{{END}}
	';


	/**
	 * Tablica przetrzymujaca strukturę szablonu potrzebna do walidacji
	 *
	 * @var array
	 */
	protected $strukturaTpl = array(
		'/html/',
		'/html/wyborStrony',
		'/html/skoczDo',
		'/html/wyborZakresu',
		'/linkiWyborStrony/',
		'/linkiWyborStrony/skokPoprzednia/',
		//'/linkiWyborStrony/skokPoprzednia/link',
		'/linkiWyborStrony/pierwszaStrona/',
		//'/linkiWyborStrony/pierwszaStrona/link',
		'/linkiWyborStrony/skokWstecz/',
		//'/linkiWyborStrony/skokWstecz/link',
		'/linkiWyborStrony/skokWstecz/nrStrony',
		'/linkiWyborStrony/poprzedzajacaStrona/',
		//'/linkiWyborStrony/poprzedzajacaStrona/link',
		'/linkiWyborStrony/poprzedzajacaStrona/nrStrony',
		'/linkiWyborStrony/biezacaStrona/',
		'/linkiWyborStrony/biezacaStrona/nrStrony',
		'/linkiWyborStrony/nastepujacaStrona/',
		//'/linkiWyborStrony/nastepujacaStrona/link',
		'/linkiWyborStrony/nastepujacaStrona/nrStrony',
		'/linkiWyborStrony/skokNaprzod/',
		//'/linkiWyborStrony/skokNaprzod/link',
		'/linkiWyborStrony/skokNaprzod/nrStrony',
		'/linkiWyborStrony/ostatniaStrona/',
		//'/linkiWyborStrony/ostatniaStrona/link',
		'/linkiWyborStrony/skokNastepna/',
		//'/linkiWyborStrony/skokNastepna/link',
		'/selectWyborStrony/',
		'/selectWyborStrony/poprzednia/',
		//'/selectWyborStrony/poprzednia/link',
		'/selectWyborStrony/url',
		'/selectWyborStrony/urlPierwsza',
		'/selectWyborStrony/opcje/',
		'/selectWyborStrony/opcje/nrStrony',
		'/selectWyborStrony/nastepna/',
		//'/selectWyborStrony/nastepna/link',
		'/linkiWyborZakresu/',
		'/linkiWyborZakresu/opcje/',
		//'/linkiWyborZakresu/opcje/link',
		'/linkiWyborZakresu/opcje/zakres',
		'/linkiWyborZakresu/wszystko/',
		//'/linkiWyborZakresu/wszystko/link',
		'/selectWyborZakresu/',
		//'/selectWyborZakresu/url',
		'/selectWyborZakresu/opcje/',
		//'/selectWyborZakresu/opcje/zakres',
		'/formSkoczDo/',
		'/formSkoczDo/klasaform',
		'/formSkoczDo/url_js',
		'/formSkoczDo/urlPierwsza_js',
	);

/**
	 *  Domyślna treść szablonu dla nagłówka html-owego
	 *
	 * @var string
	 */
	protected $htmlHeadTpl = '
{{BEGIN htmlHead}}
	{{$linkFirst}}
	{{$linkPrev}}
	{{$linkNext}}
	{{$linkLast}}
{{END}}

{{BEGIN first}}<link rel="First" href="{{$url}}" />{{END}}
{{BEGIN prev}}<link rel="Prev" href="{{$url}}" />{{END}}
{{BEGIN next}}<link rel="Next" href="{{$url}}" />{{END}}
{{BEGIN last}}<link rel="Last" href="{{$url}}" />{{END}}';

	protected $htmlHeadStrukturaTpl =  array(
		'/htmlHead/',
		'/htmlHead/linkFirst',
		'/htmlHead/linkPrev',
		'/htmlHead/linkNext',
		'/htmlHead/linkLast',
		'/first/',
		'/first/url',
		'/prev/',
		'/prev/url',
		'/next/',
		'/next/url',
		'/last/',
		'/last/url',
	);

	/**
	 * Konstruktor, ustawia partemetry poczatkowe pager-a.
	 *
	 * @param integer $ilosc Ilosc wszystkich elementow.
	 * @param integer $naStronie Ilosc elementow na stronie.
	 * @param integer $nrStrony Numer biezacej strony.
	 */
	public function __construct($ilosc, $naStronie = 10, $nrStrony = 1)
	{
		parent::__construct($ilosc,$naStronie,$nrStrony);
		
		$nazwaKlasy = explode('\\', get_class($this));
		$namespaceJezyka = '\\Generic\\Tlumaczenie\\'.ucfirst(KOD_JEZYKA_ITERFEJSU).'\\Biblioteka\\Pager\\'.end($nazwaKlasy);
		$this->j = new $namespaceJezyka;
		
		$this->ustawTlumaczenia(Cms::inst()->lang['pagery']);
		$this->ustawSzablon(CMS_KATALOG . '/szablon_system/pager_bootstrap.tpl');
	}



	/**
	 * Wyświetlanie pełnego przetworzonego szablonu
	 *
	 * @param string $url Link do przetworzenia
	 * @param string $urlPierwsza Link do pierwszej strony do przetworzenia
	 *
	 * @return string
	 */
	public function html($url, $urlPierwsza = '')
	{
		$this->inicjujSzablon();
		return $this->szablon->parsujBlok('/html', array(
			'wyborStrony' => $this->wyborStrony($url, $urlPierwsza),
			'wyborZakresu' => $this->wyborZakresu($url, $urlPierwsza),
			'skoczDo' => $this->skoczDo($url, $urlPierwsza)
		));
	}

	/**
	 * Zwraca linki dla SEO do nagłówka określające pierwszą ostatnią i nast.
	 * poprzednie strony listy.
	 *
	 * @param string $url Link do przetworzenia
	 * @param string $urlPierwsza Link do pierwszej strony do przetworzenia
	 *
	 * @return string
	 */
	public function naglowekHtml($url, $urlPierwsza = '')
	{
		$this->inicjujSzablonHead();

		return $this->szablonHead->parsujBlok('/htmlHead',
				$this->generujLinkiNaglowka($url, $urlPierwsza));

	}



	protected function generujLinkiNaglowka($url, $urlPierwsza = '')
	{
		$linki = array();

		$urlBlok = '';
		if ($this->_nrStrony > 1)
		{
			if ($urlPierwsza != '')
			{
				$urlBlok = $urlPierwsza;
			}
			else
			{
				$urlBlok = $url;
			}

			$linki['linkFirst'] = $this->szablonHead->parsujBlok('/first', array('url' => str_replace(array('{NR_STRONY}', '{NA_STRONIE}'), array(1, $this->_naStronie), $urlBlok)));

			if ($this->_nrStrony-1 < 2 && $urlPierwsza != '')
			{
				$urlBlok = $urlPierwsza;
			}
			else
			{
				$urlBlok = $url;
			}

			$linki['linkPrev'] = $this->szablonHead->parsujBlok('/prev', array('url' =>  str_replace(array('{NR_STRONY}', '{NA_STRONIE}'), array($this->_nrStrony-1, $this->_naStronie), $urlBlok)));
		}

		if ($this->_nrStrony < $this->_iloscStron)
		{
			$urlBlok = $url;

			$linki['linkNext'] = $this->szablonHead->parsujBlok('/next', array('url' =>  str_replace(array('{NR_STRONY}', '{NA_STRONIE}'), array($this->_nrStrony+1, $this->_naStronie), $urlBlok)));

			$linki['linkLast'] = $this->szablonHead->parsujBlok('/last', array('url' =>  str_replace(array('{NR_STRONY}', '{NA_STRONIE}'), array($this->_iloscStron, $this->_naStronie), $urlBlok)));

		}

		return $linki;
	}

	/**
	 * Zwraca sparsowaną treść elementu do wyboru stron lub pusty tekst
	 *
	 * @param string $url Link do przetworzenia
	 * @param string $urlPierwsza Link do pierwszej strony do przetworzenia
	 *
	 * @return string
	 */
	public function wyborStrony($url, $urlPierwsza = '')
	{
		if ($this->_ilosc <= $this->_naStronie) { return ''; }

		switch($this->konfiguracja['wyborStrony'])
		{
			case 'linki':
				return $this->linkiWyborStrony($url, $urlPierwsza);
			case 'select':
				return $this->selectWyborStrony($url, $urlPierwsza);
			default:
				return '';
		}
	}



	/**
	 * Zwraca sparsowaną treść elementu do zmiany ilości wyświetlanych elementów lub pusty tekst
	 *
	 * @param string $url Link do przetworzenia
	 * @param string $urlPierwsza Link do pierwszej strony przetworzenia
	 *
	 * @return string
	 */
	public function wyborZakresu($url, $urlPierwsza = '')
	{
		$zakresy = explode(',', $this->konfiguracja['dostepneZakresy']);
		foreach ($zakresy as $k => $v)
		{
			$v = trim($v);
			if($v <= 0 && $v != 'wszystko') unset($zakresy[$k]);
		}
		if (count($zakresy) > 0)
		{
			$zakresy = array_map("trim", $zakresy);
			$zakresy = array_unique($zakresy);
			sort($zakresy);
			$this->zakresy = $zakresy;
		}

		switch ($this->konfiguracja['wyborZakresu'])
		{
			case 'linki':
				return $this->linkiWyborZakresu($url);
			case 'select':
				return $this->selectWyborZakresu($url);
			default:
				return '';
		}
	}



	/**
	 * Zwraca sparsowaną treść elementu do wykonania skoku na stronę lub pusty tekst
	 *
	 * @param string $url Link do przetworzenia
	 * @param string $urlPierwsza Link do pierwszej strony do przetworzenia
	 *
	 * @return string
	 */
	public function skoczDo($url, $urlPierwsza = '')
	{
		switch ($this->konfiguracja['skoczDo'])
		{
			case 'form':
			{
				if ($this->iloscStron() > 1)
				{
					return $this->formSkoczDo($url, $urlPierwsza);
				}
			}
			default:
				return '';
		}
	}



	protected function linkiWyborStrony($url, $urlPierwsza = '')
	{
		if ($this->_ilosc < $this->_naStronie) { return ''; }
		$this->inicjujSzablon();

		ksort($this->konfiguracja);

		//Poprzednia
		if ($this->konfiguracja['poprzedniaNastepna'] == true && ($this->_nrStrony-1) > 0)
		{
			$link;
			if ($this->_nrStrony == 2 && $urlPierwsza != '')
			{
				$link = str_replace(array('{NR_STRONY}', '{NA_STRONIE}'), array($this->_nrStrony-1, $this->_naStronie), $urlPierwsza);
			}
			else
			{
				$link = str_replace(array('{NR_STRONY}', '{NA_STRONIE}'), array($this->_nrStrony-1, $this->_naStronie), $url);
			}
			$this->szablon->ustawBlok('/linkiWyborStrony/skokPoprzednia', array(
				'link' => $link,
				'link_seo' => strToHex($link),
			));
		}

		//Pierwsza
		if ($this->konfiguracja['pierwszaOstatnia'] == true && $this->_nrStrony - $this->konfiguracja['zakres'] > 1)
		{
			$link;
			if ($urlPierwsza != '')
			{
				$link = str_replace(array('{NR_STRONY}', '{NA_STRONIE}'), array(1, $this->_naStronie), $urlPierwsza);
			}
			else
			{
				$link = str_replace(array('{NR_STRONY}', '{NA_STRONIE}'), array(1, $this->_naStronie), $url);
			}
			$this->szablon->ustawBlok('/linkiWyborStrony/pierwszaStrona', array(
				'link' => $link,
				'link_seo' => strToHex($link),
				'nrStrony' => 1,
			));
		}

		//Skoki do stron wstecz
		foreach($this->konfiguracja as $klucz => $wartosc)
		{
			if (!is_numeric($klucz) || $klucz >= 0) { continue; }
			$klucz = abs($klucz);
			$nrStrony = $this->_nrStrony - $klucz;
			if (strlen($wartosc) == 0) { $wartosc = $nrStrony; }

			$pierwszaStrona = ($this->konfiguracja['pierwszaOstatnia'] == true && $nrStrony == 1) ? false : true;
			if ($nrStrony <= $this->_iloscStron && $nrStrony > 0 && $pierwszaStrona)
			{
				if ($wartosc == 1 && $urlPierwsza != '')
				{
					$link = str_replace(array('{NR_STRONY}', '{NA_STRONIE}'), array($nrStrony, $this->_naStronie), $urlPierwsza);
				}
				else
				{
					$link = str_replace(array('{NR_STRONY}', '{NA_STRONIE}'), array($nrStrony, $this->_naStronie), $url);
				}
				$this->szablon->ustawBlok('/linkiWyborStrony/skokWstecz',array(
					'link' => $link,
					'link_seo' => strToHex($link),
					'nrStrony' => $wartosc,
					'pierwszy' => ($nrStrony == 1) ? 1 : 0,
				));
			}
		}

		//Strony poprzedzajace
		$nrStrony = $this->_nrStrony - $this->konfiguracja['zakres'];
		if ($nrStrony < 1) { $nrStrony = 1; }
		$koniec = $this->_nrStrony;

		for ($nrStrony; $nrStrony < $koniec; $nrStrony++)
		{
			$link;
			if ($nrStrony == 1 && $urlPierwsza != '')
			{
				$link = str_replace(array('{NR_STRONY}', '{NA_STRONIE}'), array($nrStrony, $this->_naStronie), $urlPierwsza);
			}
			else
			{
				$link = str_replace(array('{NR_STRONY}', '{NA_STRONIE}'), array($nrStrony, $this->_naStronie), $url);
			}

			$this->szablon->ustawBlok('/linkiWyborStrony/poprzedzajacaStrona', array(
				'link' => $link,
				'link_seo' => strToHex($link),
				'nrStrony' => $nrStrony,
				'pierwszy' => ($nrStrony == 1) ? 1 : 0,
			));
		}

		//Biezaca strona
		$this->szablon->ustawBlok('/linkiWyborStrony/biezacaStrona', array(
			'nrStrony' => $this->_nrStrony,
			'pierwszy' => ($this->_nrStrony == 1) ? 1 : 0,
			'ostatni' => ($this->_nrStrony == $this->_iloscStron) ? 1 : 0,
		));

		//Strony nastepujace
		$nrStrony = $this->_nrStrony + 1;
		$koniec = $this->_nrStrony + $this->konfiguracja['zakres'];
		if ($koniec > $this->_iloscStron) { $koniec = $this->_iloscStron; }

		for ($nrStrony; $nrStrony <= $koniec; $nrStrony++)
		{
			$link = str_replace(array('{NR_STRONY}', '{NA_STRONIE}'), array($nrStrony, $this->_naStronie), $url);
			$this->szablon->ustawBlok('/linkiWyborStrony/nastepujacaStrona', array(
				'link' => $link,
				'link_seo' => strToHex($link),
				'nrStrony' => $nrStrony,
				'ostatni' => ($nrStrony == $this->_iloscStron) ? 1 : 0,
			));
		}

		//Skoki do stron naprzod
		foreach ($this->konfiguracja as $klucz => $wartosc)
		{
			if (!is_numeric($klucz) || $klucz <= 0) { continue; }
			$nrStrony = $this->_nrStrony + $klucz;
			if (strlen($wartosc) == 0) { $wartosc = $nrStrony; }

			$ostatniaStrona = ($this->konfiguracja['pierwszaOstatnia'] == true && $nrStrony == $this->_iloscStron) ? false : true;
			if ($nrStrony <= $this->_iloscStron && $nrStrony > $this->_nrStrony && $ostatniaStrona)
			{
				$link = str_replace(array('{NR_STRONY}', '{NA_STRONIE}'), array($nrStrony, $this->_naStronie), $url);

				$this->szablon->ustawBlok('/linkiWyborStrony/skokNaprzod',array(
					'link' => $link,
					'link_seo' => strToHex($link),
					'nrStrony' => $wartosc,
					'ostatni' => ($nrStrony == $this->_iloscStron) ? 1 : 0,
				));
			}
		}

		//Ostatnia
		if ($this->konfiguracja['pierwszaOstatnia'] == true && $this->_nrStrony + $this->konfiguracja['zakres'] < $this->_iloscStron )
		{

			$link = str_replace(array('{NR_STRONY}', '{NA_STRONIE}'), array($this->_iloscStron, $this->_naStronie), $url);
			$this->szablon->ustawBlok('/linkiWyborStrony/ostatniaStrona', array(
				'link' => $link,
				'link_seo' => strToHex($link),
				'nrStrony' => $this->_iloscStron,
			));
		}

		//Nastepna
		if ($this->konfiguracja['poprzedniaNastepna'] == true && ($this->_nrStrony+1) <= $this->_iloscStron)
		{
			$link = str_replace(array('{NR_STRONY}', '{NA_STRONIE}'), array($this->_nrStrony+1, $this->_naStronie), $url);
			$this->szablon->ustawBlok('/linkiWyborStrony/skokNastepna', array(
				'link' => $link,
				'link_seo' => strToHex($link),
			));
		}

		return $this->szablon->parsujBlok('/linkiWyborStrony/');
	}



	protected function selectWyborStrony($url, $urlPierwsza = '')
	{
		if ($this->_ilosc < $this->_naStronie) { return ''; }
		$this->inicjujSzablon();
		$url_js = str_replace('&amp;', '&', $url);
		$urlPierwsza_js = str_replace('&amp;', '&', $urlPierwsza);

		//Poprzednia
		if ($this->konfiguracja['poprzedniaNastepna'] == true && ($this->_nrStrony-1) > 0)
		{
			$link;
			if ($this->_nrStrony == 2)
			{
				$link = str_replace(array('{NR_STRONY}', '{NA_STRONIE}'), array($this->_nrStrony-1, $this->_naStronie), $urlPierwsza);
			}
			else
			{
				$link = str_replace(array('{NR_STRONY}', '{NA_STRONIE}'), array($this->_nrStrony-1, $this->_naStronie), $url);
			}
			$this->szablon->ustawBlok('/selectWyborStrony/poprzednia', array(
				'link' => $link,
				'link_seo' => strToHex($link),
			));
		}

		for ($i = 1; $i <= $this->iloscStron(); $i++)
		{
			$poczatek = ($i == 1) ? 1 : (($i - 1) * $this->_naStronie) + 1;

			$koniec = (($i * $this->_naStronie) < $this->_ilosc) ? $i * $this->_naStronie : $this->_ilosc;
			$wybrany = ($this->_nrStrony == $i) ? true : false;

			$this->szablon->ustawBlok('/selectWyborStrony/opcje',array(
				'poczatek' => $poczatek,
				'koniec' => $koniec,
				'nrStrony' => $i,
				'wybrany' => $wybrany
			));
		}

		//Nastepna
		if ($this->konfiguracja['poprzedniaNastepna'] == true && ($this->_nrStrony+1) <= $this->_iloscStron)
		{
			$link = str_replace(array('{NR_STRONY}', '{NA_STRONIE}'), array($this->_nrStrony+1, $this->_naStronie), $url);
			$this->szablon->ustawBlok('/selectWyborStrony/nastepna', array(
				'link' => $link,
				'link_seo' => strToHex($link),
			));
		}

		return $this->szablon->parsujBlok('/selectWyborStrony/',array(
			'url' => $url_js,
			'url_seo' => strToHex($url_js),
			'urlPierwsza' => $urlPierwsza_js,
			'urlPierwsza_seo' => strToHex($urlPierwsza_js),
		));
	}



	protected function linkiWyborZakresu($url)
	{
		$this->inicjujSzablon();
		$url_js = str_replace('&amp;', '&', $url);
		$ileZakresow = count($this->zakresy);
		$licznik = 0;
		foreach ($this->zakresy as $zakres)
		{
			++$licznik;
			$link = str_replace(array('{NR_STRONY}', '{NA_STRONIE}'), array($this->_nrStrony, $zakres), $url);
			if (($zakres > $this->_ilosc || $zakres == 'wszystko') && $zakres != $this->zakresy[0] && ! $this->konfiguracja['pokazujWszystkieZakresy']) { continue; }
			$wybrany = ($zakres == $this->_naStronie) ? 'current' : false;
			$this->szablon->ustawBlok('/linkiWyborZakresu/opcje',array(
				'link' => $link,
				'link_seo' => strToHex($link),
				'zakres' => $zakres,
				'wybrany' => $wybrany,
				'pierwszy' => $licznik == 1 ? true : false,
			));
		}

		$link = str_replace(array('{NR_STRONY}', '{NA_STRONIE}'), array($this->_nrStrony, $this->_ilosc), $url);
		$wybrany = ($this->_ilosc == $this->_naStronie) ? true : false;

		if (in_array('wszystko', $this->zakresy))
		{
			$this->szablon->ustawBlok('/linkiWyborZakresu/wszystko',array(
				'link' => $link,
				'link_seo' => strToHex($link),
				'wybrany' => $wybrany
			));
		}

		return $this->szablon->parsujBlok('/linkiWyborZakresu',array(
			'url' => $url_js,
			'url_seo' => strToHex($url_js),
		));
	}



	protected function selectWyborZakresu($url)
	{
		$this->inicjujSzablon();
		$url_js = str_replace('&amp;', '&', $url);

		$wystepujeWszystko = in_array('wszystko', $this->zakresy);

		foreach ($this->zakresy as $zakres)
		{
			if ($zakres > $this->_ilosc)
			{
				//tutaj unikam blednego oznaczenia rekordow na strone w pagerze
				//jesli jest np 8 rekordow (pojawialo sie wtedy 5 w selecie,
				//a na strone a bylo 8)
				if($this->_naStronie > $this->_ilosc)
						$this->_naStronie = $this->_ilosc;
				continue;
			}

			if ($zakres == $this->_ilosc && $wystepujeWszystko)
			{
				continue;
			}

			$zakres_etykieta = $zakres_wartosc = $zakres;
			if ($zakres == 'wszystko')
			{
				$zakres_etykieta = $this->j->t['pager_pokaz_wszystko'];
				$zakres_wartosc = $zakres = $this->_ilosc;
			}

			$wybrany = ($zakres == $this->_naStronie) ? true : false;

			$this->szablon->ustawBlok('/selectWyborZakresu/opcje',array(
				'zakres_etykieta' => $zakres_etykieta,
				'zakres_wartosc' => $zakres_wartosc,
				'wybrany' => $wybrany
			));
		}
		$wybrany = ($this->_ilosc == $this->_naStronie) ? true : false;

		return $this->szablon->parsujBlok('/selectWyborZakresu',array(
			'url' => $url_js,
			'url_seo' => strToHex($url_js),
		));
	}



	protected function formSkoczDo($url, $urlPierwsza = '')
	{
		$this->inicjujSzablon();
		$url_js = str_replace('&amp;', '&', $url);
		$urlPierwsza_js = str_replace('&amp;', '&', $urlPierwsza);

		if ($this->_ilosc < $this->_naStronie) { return ''; }

		return $this->szablon->parsujBlok('/formSkoczDo',array(
			'url_js' => $url_js,
			'url_js_seo' => strToHex($url_js),
			'urlPierwsza_js' => $urlPierwsza_js,
			'urlPierwsza_js_seo' => strToHex($urlPierwsza_js),
			'klasaform' => abs(crc32($url.microtime())),
			'ilosc_stron' => $this->_iloscStron,
		));
	}



	protected function inicjujSzablon()
	{
		if (!($this->szablon instanceof Szablon))
		{
			$this->szablon = new Szablon();
			$this->szablon->ladujTresc($this->tpl);

			$this->szablon->ustawGlobalne($this->j->t);
			$this->szablon->ustawGlobalne(array(
				'pager_wartosc_nrStrony' => $this->_nrStrony,
				'pager_wartosc_naStronie' => $this->_naStronie,
				'pager_wartosc_ilosc' => $this->_ilosc,
				'pager_wartosc_iloscStron' => $this->_iloscStron
			));
		}
	}



	protected function inicjujSzablonHead()
	{
		if (!($this->szablonHead instanceof Szablon))
		{
			$this->szablonHead = new Szablon();
			$this->szablonHead->ladujTresc($this->htmlHeadTpl);

			$this->szablonHead->ustawGlobalne($this->j->t);
			$this->szablonHead->ustawGlobalne(array(
				'pager_wartosc_nrStrony' => $this->_nrStrony,
				'pager_wartosc_naStronie' => $this->_naStronie,
				'pager_wartosc_ilosc' => $this->_ilosc,
				'pager_wartosc_iloscStron' => $this->_iloscStron
			));
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
				trigger_error('Brak pliku szablonu pagera: '.$trescSzablonu, E_USER_WARNING);
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
				&&  ! in_array($element.'_seo', $nowyStruktura) ) $brakujace[] = $element;
		}
		if (count($brakujace) > 0)
		{
			trigger_error('Nieprawidlowa struktura zaladowanego szablonu dla pager-a. Brak elementow: '.implode(', ', $brakujace), E_USER_WARNING);
			return false;
		}
		$this->szablon = $nowySzablon;
		$this->szablon->ustawGlobalne($this->j->t);
		$this->szablon->ustawGlobalne(array(
			'pager_wartosc_nrStrony' => $this->_nrStrony,
			'pager_wartosc_naStronie' => $this->_naStronie,
			'pager_wartosc_ilosc' => $this->_ilosc,
			'pager_wartosc_iloscStron' => $this->_iloscStron
		));
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
	 * wyborStrony - 'link', 'select', ''
	 * wyborZakresu - 'link', 'select', ''
	 * skoczDo - 'form', ''
	 * poprzedniaNastepna - true, false
	 * pierwszaOstatnia - true, false
	 *
	 * @param array $config Tablica z konfiguracją
	 */
	public function ustawKonfiguracje($config)
	{
		if (!is_array($config) || count($config) < 1) { return false; }

		//Zakres wyswietlanych linkow w lewo i prawo od wybranej strony
		$this->konfiguracja['zakres'] = (isset($config['zakres'])) ? abs((int)$config['zakres']) : 3;

		// Okreslenie zakresow
		if (isset($config['dostepneZakresy']))
		{
			$this->konfiguracja['dostepneZakresy'] = $config['dostepneZakresy'];
		}

		// Typ elementu do wyboru strony
		if (isset($config['wyborStrony']))
		{
			$this->konfiguracja['wyborStrony'] = $config['wyborStrony'];
		}

		//Typ elementu do wyboru zakresu
		if (isset($config['wyborZakresu']))
		{
			$this->konfiguracja['wyborZakresu'] = $config['wyborZakresu'];
		}

		//Pole skoku do strony
		if (isset($config['skoczDo']))
		{
			$this->konfiguracja['skoczDo'] = $config['skoczDo'];
		}

		//Odnośnik do pierwszej/ostatniej strony
		if (isset($config['pierwszaOstatnia']))
		{
			$this->konfiguracja['pierwszaOstatnia'] = (bool)$config['pierwszaOstatnia'];
		}

		//Odnośnik do nastepnej/poprzedniej strony
		if (isset($config['poprzedniaNastepna']))
		{
			$this->konfiguracja['poprzedniaNastepna'] = (bool)$config['poprzedniaNastepna'];
		}

		foreach ($config as $klucz => $wartosc)
		{
			if (!is_numeric($klucz)) { unset($config[$klucz]); continue; }
			$this->konfiguracja[trim($klucz)] = $wartosc;
		}
	}



	/**
	 * Zwraca tablice z tlumaczeniami.
	 *
	 * @return array
	 */
	public function pobierzTlumaczenia()
	{
		return $this->j->t;
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
		if (is_array($tlumaczenia) && $this->j->t = array_merge($tlumaczenia, $this->j->t))
		{
			return true;
		}
		return false;
	}

}


