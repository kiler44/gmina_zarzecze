<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;


/**
 * Klasa obsługująca upload zdjęć z podglądem zdjęcia.
 *
 * @author Krzysztof Lesiczka, modyfikacja Łukasz Wrucha
 * @package biblioteki
 */

class Zdjecie extends Input
{
	protected $katalogSzablonu = 'PhotoNew';
	protected $tpl = '
	<div class="section">
		<div class="info-gray clearfix">{{BEGIN jest_zdjecie}}<input type="hidden" name="{{$nazwa}}" id="{{$nazwa}}" value="{{$zdjecie_name}}" {{$atrybuty}} />{{IF $link_miniaturka}}<a href="{{$sciezka_plikow}}{{$zdjecie_name}}" rel="lightbox"><img class="inputZdjecieMiniatura" alt="" src="{{$sciezka_plikow}}{{$link_miniaturka}}"></a>{{END}}<div class="right-upload">{{IF $link_usun}}<a onclick="if({{$potwierdz_usun}}){return confirmLightbox(this, \'{{$etykieta_usun_tytul}}\', \'{{$etykieta_usun_pytanie}}\', \'eWarning\', \'confirm\');}" href="{{$link_usun}}" class="remove" title="{{$etykieta_usun}}">{{$etykieta_usun}} <span></span></a>{{END}}<div class="upload {{$nazwa}}">{{IF $zdjecie_opis}}{{$etykieta_opis}}<input type="text" name="{{$nazwa}}_title" id="{{$nazwa}}_title" value="{{$zdjecie_description}}" /><br />{{END}}<a href="{{$sciezka_plikow}}{{$zdjecie_name}}">{{$zdjecie_name}}</a>{{IF $popraw_miniaturke}}<a href="javascript:void(0);" onclick="pokazUkryj{{$nazwa}}(\'#{{$nazwa}}_kontener\');" class="popraw_miniature" ><img src="/_system/admin/ikony/edytuj.gif" alt="{{$etykieta_popraw}}"/></a>{{END}}{{IF $wyswietlac_dozwolone_typy}}<p>{{$etykieta_dozwolone_typy}} {{$dozwolone_typy}}</p>{{END}}</div></div>{{END}}
		{{BEGIN brak_zdjecia}}
			<div class="upload"><input type="file" name="{{$nazwa}}" id="{{$nazwa}}" value="" {{$atrybuty}} />
			{{IF $wyswietlac_dozwolone_typy}}<p>{{$etykieta_dozwolone_typy}} {{$dozwolone_typy}})</p>{{END}}
			</div>
		{{END}}
		</div>
	</div>
	{{BEGIN obsluga_poprawy_miniaturki}}
		<div class="clear"></div>
		<div id="{{$nazwa}}_kontener" style="display: none;">
		<div style="float: left; margin-right: 6px;">
		{{BEGIN jeden_rozmiar}}
			<input type="hidden" id="{{$nazwa}}_ratio" name="{{$nazwa}}_ratio" value="{{$kod}}">
		{{END}}
		{{BEGIN wiele_rozmiarow}}
			{{$etykieta_wybierz}} <select name="{{$nazwa}}_ratio" id="{{$nazwa}}_ratio">{{BEGIN wiersze}}<option value="{{$kod}}">{{$kod}}</option>{{END}}</select>
		{{END}}
		</div>
		<a href="{{$link_popraw_miniaturke}}" id="{{$nazwa}}_popraw" class="button"><span>{{$etykieta_zatwierdz}}</span></a>
		<div class="clear"></div>
		<div id="{{$nazwa}}_ramka" class="ramka">
			<img src="{{$sciezka_plikow}}{{$zdjecie_name}}" alt="obraz" id="{{$nazwa}}_obraz">
		</div>
		<div id="{{$nazwa}}_ramka_podglad" class="ramka_podglad">
			<img src="{{$sciezka_plikow}}{{$zdjecie_name}}" alt="miniatura" id="{{$nazwa}}_obraz_podglad">
		</div>
		<div class="clear"></div>
		</div>

		<script type="text/javascript">
		<!--

		var {{$nazwa}}_avc = undefined;
		var {{$nazwa}}_jcrop = undefined;
		var tabelaRatio = new Array();
		{{BEGIN lista_js}}
			tabelaRatio["{{$kod}}"] = {{$ratio}};
		{{END}}


		var {{$nazwa}}_generuj = function(coords) {
			var rx = {{$nazwa}}_avc.h_podglad.width() / coords.w;
			var ry = {{$nazwa}}_avc.h_podglad.height() / coords.h;

			{{$nazwa}}_avc.h_miniatura.css({
				width: Math.round(rx * {{$nazwa}}_avc.h_obraz.width()) + "px",
				height: Math.round(ry * {{$nazwa}}_avc.h_obraz.height()) + "px",
				marginLeft: "-" + Math.round(rx * coords.x) + "px",
				marginTop: "-" + Math.round(ry * coords.y) + "px"
			});

			var x1 = parseFloat((coords.x / {{$nazwa}}_avc.h_obraz.width()) * 100);
			var y1 = parseFloat((coords.y / {{$nazwa}}_avc.h_obraz.height()) * 100);
			var x2 = parseFloat((coords.x2 / {{$nazwa}}_avc.h_obraz.width()) * 100);
			var y2 = parseFloat((coords.y2 / {{$nazwa}}_avc.h_obraz.height()) * 100);

			var link = "{{$link_popraw_miniaturke}}";
			link = link.replace("{X1}",x1).replace("{Y1}",y1).replace("{X2}",x2).replace("{Y2}",y2).replace("{KOD}", $("#{{$nazwa}}_ratio").val());
			$("#{{$nazwa}}_popraw").attr("href",link);
		}


		function pokazUkryj{{$nazwa}}() {
			if(pokazUkryj(\'#{{$nazwa}}_kontener\'))
			{
				if({{$nazwa}}_avc == undefined || {{$nazwa}}_jcrop == undefined)
				{
					{{$nazwa}}_avc = new avcreator("{{$nazwa}}");
					{{$nazwa}}_avc.obraz = { w: {{$nazwa}}_avc.h_obraz.width(), h: {{$nazwa}}_avc.h_obraz.height() }
					{{$nazwa}}_avc.skalujRamke();
					{{$nazwa}}_avc.korekta();
					{{$nazwa}}_avc.ustawRatio(tabelaRatio[$("#{{$nazwa}}_ratio").val()]);
					{{$nazwa}}_jcrop = $.Jcrop("#{{$nazwa}}_obraz");
					{{$nazwa}}_jcrop.setOptions({
						onChange: {{$nazwa}}_generuj,
						onSelect: {{$nazwa}}_generuj,
						aspectRatio: {{$nazwa}}_avc.ratio,
					});

					$("#{{$nazwa}}_ratio").change(function(){
						{{$nazwa}}_avc.ustawRatio(tabelaRatio[$("#{{$nazwa}}_ratio").val()]);
						{{$nazwa}}_jcrop.setOptions({
							aspectRatio: {{$nazwa}}_avc.ratio
						});
						{{$nazwa}}_avc.korekta();
					});
				}
				{{$nazwa}}_jcrop.enable();
				{{$nazwa}}_jcrop.focus();
			}
			else
			{
				{{$nazwa}}_jcrop.disable();
			}
		}
		-->
		</script>
	{{END}}
	';

	protected $parametry = array(
		'sciezka_plikow' => '', // okresla url katalogu w ktorym znajduje sie plik
		'link_usun' => '', // url do usuwania zdjecia, jezeli dodany pokaze sie link do usuwania
		'link_miniaturka' => '', // url miniaturki zdjecia, jezeli podany wyswietli miniaturke
		'link_popraw_miniaturke' => '', //url do poprawiania miniaturki zdjecia, jezeli dodany pokaze sie ekran do poprawiania miniaturki
		'rozmiary_miniaturek' => array(), // tablica z rozmiarami miniaturek w formacie array('kod_miniaturki' => 'szerokosc.wysokosc.kod_operacji'
		'dozwolone_typy' => '',
		'etykieta_usun' => '',
	);



	function pobierzHtml()
	{
		$zdjecie = $this->pobierzWartosc();

		$link_usun = null;
		$link_popraw_miniature = null;
		$opis = null;

		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'atrybuty' => $this->pobierzAtrybuty(),

			'etykieta_usun' => $this->tlumaczenia['input_zdjecie_etykieta_usun'],
			'etykieta_usun_tytul' => $this->tlumaczenia['input_zdjecie_etykieta_usun_tytul'],
			'etykieta_usun_pytanie' => $this->tlumaczenia['input_zdjecie_etykieta_usun_pytanie'],
			'etykieta_popraw' => $this->tlumaczenia['input_zdjecie_etykieta_popraw'],
			'etykieta_wybierz' => $this->tlumaczenia['input_zdjecie_etykieta_wybierz'],
			'etykieta_zatwierdz' => $this->tlumaczenia['input_zdjecie_etykieta_zatwierdz'],
			'etykieta_opis' => $this->tlumaczenia['input_zdjecie_etykieta_opis'],
			'etykieta_dozwolone_typy' => $this->tlumaczenia['input_zdjecie_etykieta_dozwolone_typy'],
		);

		if (isset($zdjecie['description']))
		{
			$dane['zdjecie_description'] = $zdjecie['description'];
		}

		$this->szablon->ustawGlobalne($dane);

		if ($zdjecie['name'] != '' && (!isset($zdjecie['tmp_name']) || $zdjecie['tmp_name'] == ''))
		{
			$dane['jest_zdjecie']['sciezka_plikow'] = $this->parametry['sciezka_plikow'];
			$dane['jest_zdjecie']['zdjecie_name'] = $zdjecie['name'];

			if (isset($zdjecie['description']))
			{
				$dane['jest_zdjecie']['zdjecie_opis'] = true;
			}

			$dane['jest_zdjecie']['zdjecie_name'] = $zdjecie['name'];

			if ($this->parametry['link_miniaturka'] != '')
			{
				$dane['jest_zdjecie']['link_miniaturka'] = $this->parametry['link_miniaturka'];
			}


			if ($this->parametry['link_miniaturka'] != '')
			{
				if ($this->parametry['link_usun'] != '')
				{
					$dane['jest_zdjecie']['link_usun'] = $this->parametry['link_usun'];

					if ( ! key_exists('sprawdz_usun', $this->parametry) || $this->parametry['sprawdz_usun'] != false)
						$dane['jest_zdjecie']['potwierdz_usun'] = true;
				}
			}

			if ($this->parametry['link_popraw_miniaturke'] != '')
			{
				if (strpos($this->parametry['link_popraw_miniaturke'],'{X1}') === false
					|| strpos($this->parametry['link_popraw_miniaturke'],'{X2}') === false
					|| strpos($this->parametry['link_popraw_miniaturke'],'{Y1}') === false
					|| strpos($this->parametry['link_popraw_miniaturke'],'{Y2}') === false
					|| strpos($this->parametry['link_popraw_miniaturke'],'{KOD}') === false)
				{
					trigger_error('Nieprawidlowe parametry w linku do generowania miniaturki', E_USER_WARNING);
				}
				elseif (!is_array($this->parametry['rozmiary_miniaturek']) || empty($this->parametry['rozmiary_miniaturek']))
				{
					trigger_error('Brak lub nieprawidlowy parametr \'rozmiary_miniaturek\'', E_USER_WARNING);
				}
				else
				{
					$dane['jest_zdjecie']['popraw_miniaturke'] = true;
					$link_popraw_miniature = '<a href="javascript:void(0);" onclick="pokazUkryj'.$this->nazwa.'(\'#'.$this->nazwa.'_kontener\');" class="popraw_miniature" ><img src="/_system/admin/ikony/edytuj.gif" alt="'.$this->tlumaczenia['input_zdjecie_etykieta_popraw'].'"/></a>';
				}
			}

			if ($this->parametry['dozwolone_typy'] != '')
			{
				$dane['jest_zdjecie']['wyswietlac_dozwolone_typy'] = true;
				$dane['jest_zdjecie']['dozwolone_typy'] = strtoupper($this->parametry['dozwolone_typy']);
			}
		}
		else
		{
			$dane['brak_zdjecia']['nazwa'] = $this->pobierzNazwe();
			if ($this->parametry['dozwolone_typy'] != '')
			{
				$dane['brak_zdjecia']['wyswietlac_dozwolone_typy'] = true;
				$dane['brak_zdjecia']['dozwolone_typy'] = strtoupper($this->parametry['dozwolone_typy']);
			}
		}

		if ($link_popraw_miniature !== null)
		{
			$lista = array();
			$lp = 0;
			foreach ($this->parametry['rozmiary_miniaturek'] as $kod => $wymiary)
			{
				$wymiary = explode('.',$wymiary);
				if (trim($kod) != '' && is_numeric($wymiary[0]) && is_numeric($wymiary[1]))
				{
					$lp++;
					$lista[$kod] = number_format($wymiary[0]/$wymiary[1], 2, '.', '');
				}
			}

			if ($lp > 0)
			{
				$dane['obsluga_poprawy_miniaturki'] = array(
					'nazwa' => $this->pobierzNazwe(),
					'link_popraw_miniaturke' =>$this->parametry['link_popraw_miniaturke'],
					'sciezka_plikow' => $this->parametry['sciezka_plikow'],
					'zdjecie_name' => $zdjecie['name'],
				);


				if ($lp == 1)
				{
					$dane['obsluga_poprawy_miniaturki']['jeden_rozmiar']['kod'] = $kod;
				}
				else
				{
					$dane['obsluga_poprawy_miniaturki']['wiele_rozmiarow']['nazwa'] = $this->pobierzNazwe();
					foreach ($lista as $kod => $ratio)
					{
						$dane['obsluga_poprawy_miniaturki']['wiele_rozmiarow']['wiersze'][] = array(
							'kod' => $kod,
						);
					}
				}



				foreach ($lista as $kod => $ratio)
				{
					$dane['obsluga_poprawy_miniaturki']['lista_js'][] = array(
						'kod' => $kod,
						'ratio' => (float)$ratio,
					);
				}
			}
		}

		$this->szablon->ustaw($dane);

		return $this->szablon->parsuj();
	}



	/**
	 * Ustawia wartosc poczatkowa inputa.
	 *
	 * @param mixed $wartoscPoczatkowa Wartosc poczatkowa inputa,
	 * powinna to byc tablica zawierajaca:
	 * - nazwe pliku (pole: 'name'),
	 * - ewantualnym opisem (pole: 'description')
	 * @param bool $wymus wymuszanie nadpisania wartosc.
	 */
	public function ustawWartosc($wartoscPoczatkowa, $wymus = false)
	{
		if (is_string($wartoscPoczatkowa))
		{
			$wartoscPoczatkowa = array('name' => $wartoscPoczatkowa);
		}
		$this->wartoscPoczatkowa = $wartoscPoczatkowa;
		$this->wymusPoczatkowa = (bool)$wymus;
	}



	/**
	 * Pobiera obecna wartosc inputa.
	 *
	 * @return mixed Obecna wartosc inputa.
	 */
	function pobierzWartosc()
	{
		if ($this->wymusPoczatkowa)
		{
			return $this->pobierzWartoscPoczatkowa();
		}
		if ($this->filtrowany)
		{
			return $this->wartosc;
		}
		$opis = Zadanie::pobierz($this->pobierzNazwe().'_title');
		if (isset($_FILES[$this->pobierzNazwe()]))
		{
			$temp = $_FILES[$this->pobierzNazwe()];
			if ($opis !== null) $temp['description'] = $opis;
			$this->wartosc = $this->filtrujWartosc($temp);
			unset($temp);
		}
		elseif (Zadanie::pobierz($this->pobierzNazwe()) !== null)
		{
			$temp['name'] = Zadanie::pobierz($this->pobierzNazwe());
			if ($opis !== null) $temp['description'] = $opis;
			$this->wartosc = $this->filtrujWartosc($temp);
			unset($temp);
		}
		else
		{
			$this->wartosc = $this->pobierzWartoscPoczatkowa();
		}
		return $this->wartosc;
	}



	/**
	 * Filtruje wartosc podana w argumencie
	 *
	 * @param array $tablica Wartosc do filtrowania.
	 * @return array Wartosc po zastosowaniu filtrow.
	 */
	protected function filtrujWartosc($tablica)
	{
		if (isset($tablica['description']))
		{
			foreach($this->filtry as $filtr)
			{
				$tablica['description'] = $filtr($tablica['description']);
			}
		}
		$this->filtrowany = true;
		return $tablica;
	}



	/**
	 * Sprawdza czy input zostal zmodyfikowany.
	 *
	 * @return bool True jezel input zostal zmodyfikowany, false w przeciwnym wyadku.
	 */
	function zmieniony()
	{
		$wartoscPoczatkowa = $this->pobierzWartoscPoczatkowa();
		if ((isset($_FILES[$this->pobierzNazwe()]) && is_uploaded_file($_FILES[$this->pobierzNazwe()]['tmp_name']))
			||(isset($this->wartosc['description']) && $this->wartosc['description'] != $wartoscPoczatkowa['description']))
			return true;
		else
			return false;
	}
}