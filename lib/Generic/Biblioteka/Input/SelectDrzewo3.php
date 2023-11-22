<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;


/**
 * Klasa obsługująca strukturę drzewa z dodatkową wyszukiwarką. Nowy wygląd.
 *
 * @author @authoronrad Rudowski, Krzysztof Lesiczka
 * @package biblioteki
 */

class SelectDrzewo3 extends Input
{
	protected $katalogSzablonu = 'SelectTree3New';
	protected $tpl = '
	<div style="margin: 5px;">
	<div>{{$etykieta_podpowiedz}}</div>
	<input style="width:150px;" type="text" id="{{$nazwa}}_fraza" {{$atrybuty}}/> <input type="button" class="buttonSet buttonLight3" name="fraza_btn" id="{{$nazwa}}_btn" onclick="" value="{{$etykieta_szukaj}}" {{$atrybuty}} />

	{{IF $nie_disabled}}
		{{$wybierz_lub}} <a onclick="pokazReczne()">{{$wybierz_recznie}}</a>
	{{END}}

	<div id="{{$nazwa}}_wyniki_opis" style="display:none;">
		{{$wyszukaj_kategorie}}
	</div>
	<div id="{{$nazwa}}_wyniki_brak" style="display:none;">
		<strong>{{$wyszukaj_kategorie_brak}}</strong><br />
		{{$wyszukaj_kategorie_brak2}} <a onclick="pokazReczne()">{{$wybierz_recznie}}</a>
	</div>
	<div id="{{$nazwa}}_wyniki">
	</div>

	<div id="{{$nazwa}}_recznie" style="display:none;">
		<input type="hidden" name="{{$nazwa}}" id="{{$nazwa}}" value="{{$wartosc}}" {{$atrybuty}}/>
	</div>
	</div>
	<script type="text/javascript">
	<!--
	var {{$nazwa}}_drzewo = { {{$drzewo}} };
	var sciezka = [];
	var lista = [];

	if ($("#{{$nazwa}}_fraza").val() == "")
	{
		$("#{{$nazwa}}_fraza").val("{{$domyslny_napis}}");
	}
	$("#{{$nazwa}}_fraza").focus(function () {
		if ($("#{{$nazwa}}_fraza").val() == "{{$domyslny_napis}}")
		{
			$("#{{$nazwa}}_fraza").val("");
		}
	})
	$("#{{$nazwa}}_fraza").blur(function () {
		if ($("#{{$nazwa}}_fraza").val() == "")
		{
			$("#{{$nazwa}}_fraza").val("{{$domyslny_napis}}");
		}
	})

	function pokazReczne ()
	{
		$("#{{$nazwa}}_recznie").css("display","block");

		$("#{{$nazwa}}_wyniki_opis").css("display", "none");
		$("#{{$nazwa}}_wyniki").css("display", "none");
		$("#{{$nazwa}}_wyniki_brak").css("display", "none");
	}

	function przeszukajDrzewo(szukana, {{$nazwa}}_drzewo, sciezka)
	{
		if (typeof {{$nazwa}}_drzewo == "object")
		{
			var zapytanie = new RegExp(szukana,"i");
			for (var klucz in {{$nazwa}}_drzewo)
			{
				if (klucz.match(zapytanie))
				{
					sciezka.push(klucz);
					lista.push(clone(sciezka));
					sciezka.pop();
				}
				if (typeof {{$nazwa}}_drzewo[klucz] == "object")
				{
					sciezka.push(klucz);
					przeszukajDrzewo(szukana, {{$nazwa}}_drzewo[klucz], sciezka);
					sciezka.pop();
				}
			}
		}
	}

	function clone(obj)
	{
		if (obj == null || typeof(obj) != "object") return obj;
		var temp = obj.constructor(); // changed
		for (var key in obj) temp[key] = clone(obj[key]);
		return temp;
	}

	function wybierz(tresc, nazwa)
	{
		var tresc = tresc.split(" / ");

		var opcje = {
			empty_value: 0,
			select_class: "selectDrzewo_" + nazwa,
			rozmiar: 8,
			choose: \'{{$wybierz}}\',
			preselect: {nazwa: tresc}
		};
		opcje.preselect[nazwa] = tresc;

		$("input[name=\'"+nazwa+"\']").optionTree(window[nazwa+"_drzewo"], opcje);
		$(".selectDrzewo_" + nazwa).each(function() {
			if (this.selectedIndex > 0) {
				$(this).attr("size", 1);
				$(this).attr("style", "width:100%; border:1px solid #D9DFE6; border-radius:6px; margin:3px 0px; padding:5px;");
			}
		});

		if ($("input[name={{$nazwa}}]").val() == "")
		{
			$("#{{$nazwa}}_komunikat").show();
		}
		pokazReczne();
	}

	$(document).ready(function(){

		$("input[name={{$nazwa}}]").optionTree({{$nazwa}}_drzewo, {{$parametry_cfg}});

		$("#{{$nazwa}}_btn").click(function() {
			var zapytanie = jQuery.trim($("#{{$nazwa}}_fraza").val());
			$("#{{$nazwa}}_recznie").css("display","none");

			if (zapytanie.length > 2)
			{
				$("input[name={{$nazwa}}]").unbind("optionTree");
				$("input[name={{$nazwa}}]").optionTree({{$nazwa}}_drzewo, {{$parametry_cfg}});
				przeszukajDrzewo(zapytanie, {{$nazwa}}_drzewo, sciezka);
				var tresc = "<select size=8 style=\"width:100%;overflow: scroll; border:1px solid #D9DFE6; border-radius:6px;\" onchange=\"wybierz(this.options[selectedIndex].value, \'{{$nazwa}}\');\">";
				var i;
				for (i=0;i < lista.length; i++)
				{
					wartosc = lista[i].join(" / ");
					//opis = wartosc.replace(new RegExp(zapytanie,"i"), "<strong>" + zapytanie + "</strong>");
					tresc = tresc + "<option value=\"" + wartosc + "\">" + wartosc + "</option>";
				}

				tresc = tresc + "</select>";
				$("#{{$nazwa}}_wyniki").html(tresc);
				$("#{{$nazwa}}_wyniki_opis").css("display", "block");
				lista = [];

				if (i == 0)
				{
					$("#{{$nazwa}}_wyniki_opis").css("display", "none");
					$("#{{$nazwa}}_wyniki").css("display", "none");
					$("#{{$nazwa}}_wyniki_brak").css("display", "block");
				}
				else
				{
					$("#{{$nazwa}}_wyniki_opis").css("display", "block");
					$("#{{$nazwa}}_wyniki").css("display", "block");
					$("#{{$nazwa}}_wyniki_brak").css("display", "none");
				}
			}
			else
			{
				$("#{{$nazwa}}_wyniki").html("");
				$("#{{$nazwa}}_komunikat").hide();
				$("#{{$nazwa}}_wyniki_opis").css("display", "none");
				lista = [];
			}
		});
		$("#{{$nazwa}}_fraza").keypress(function(e){
			if(e.keyCode == 13)
			{
				$("#{{$nazwa}}_btn").click();
				return false;
			}
		});
	});

	-->
	</script>
	';


	protected $parametry = array(
		'wybierz' => '',
		'cfg' => array(),
		'domyslny_napis' => '',
		'lista' => array(), //lista w postaci array( 0 => array('id' => 1, 'poziom' => 1, 'nazwa' => 'przykladowanazwa') )
	);



	function pobierzHtml()
	{
		if (is_array($this->parametry['cfg']) && count($this->parametry['cfg']) > 0)
		{
			$parametry['cfg'] = $this->parametry['cfg'];
		}
		else
		{
			trigger_error('Nieprawidlowy parametr "cfg" w konfiguracji '.get_class($this), E_USER_WARNING);
		}

		if ($this->parametry['wybierz'] !='')
		{
			$parametry['cfg']['choose'] = $this->parametry['wybierz'];
		}

		$lista = array();
		if (is_array($this->parametry['lista'])
			&& count($this->parametry['lista']) > 0
			&& isset($this->parametry['lista'][0]['id'])
			&& isset($this->parametry['lista'][0]['poziom'])
			&& isset($this->parametry['lista'][0]['nazwa']))
		{
			$lista = $this->parametry['lista'];
		}
		else
		{
			trigger_error('Brak lub nieprawidlowa lista danych dla pola select', E_USER_WARNING);
		}

		$drzewo = '';
		$poprzedni = $pierwszy = $this->parametry['lista'][0];

		$szukana = $this->pobierzWartosc();
		$sciezka = array();
		$wyszukiwanie = ($szukana != '') ? true : false;

		foreach ($this->parametry['lista'] as $bierzacy)
		{
			$poprzedni['nazwa'] = str_replace('"', '', $poprzedni['nazwa']);
			if ($poprzedni['poziom'] < $bierzacy['poziom'])
			{
				$drzewo .= '"'.$poprzedni['nazwa'].'":{';
				if ($wyszukiwanie)
				{
					$sciezka[] = $poprzedni['nazwa'];
				}
			}
			elseif ($poprzedni['poziom'] == $bierzacy['poziom'])
			{
				$drzewo .= '"'.$poprzedni['nazwa'].'":'.$poprzedni['id'].',';
			}
			elseif ($poprzedni['poziom'] > $bierzacy['poziom'])
			{
				$i = (int)($poprzedni['poziom'] - $bierzacy['poziom']);
				$drzewo .= '"'.$poprzedni['nazwa'].'":'.$poprzedni['id']."\n";
				$drzewo .= str_repeat('}', $i).',';
				if ($wyszukiwanie)
				{
					while ($i > 0)
					{
						array_pop($sciezka);
						--$i;
					}
				}
			}
			if ($wyszukiwanie && $bierzacy['id'] == $szukana)
			{
				$sciezka[] = $bierzacy['nazwa'];
				$wyszukiwanie = false;
			}
			$poprzedni = $bierzacy;
		}

		$drzewo .= '"'.$bierzacy['nazwa'].'":'.$bierzacy['id']."\n";
		$drzewo .= str_repeat('}', (int)($bierzacy['poziom'] - $pierwszy['poziom']));

		if ($szukana != '')
		{
			$sciezka[] = $szukana;
			$parametry['cfg']['preselect'] = '{\''.$this->nazwa.'\': [\''.implode("','", $sciezka).'\']}';
		}

		$this->szablon->ustaw(array(
			'nazwa' => $this->pobierzNazwe(),
			'wartosc' => $this->pobierzWartosc(),
			'atrybuty' => $this->pobierzAtrybuty(),

			'etykieta_podpowiedz' => $this->tlumaczenia['input_selectdrzewo3_input_captcha_text_etykieta_podpowiedz'],
			'etykieta_szukaj' => $this->tlumaczenia['input_selectdrzewo3_button.szukaj'],
			'wybierz_lub' => $this->tlumaczenia['input_selectdrzewo3_wybierz.lub'],
			'wybierz_recznie' => $this->tlumaczenia['input_selectdrzewo3_wybierz.recznie'],
			'wyszukaj_kategorie' => $this->tlumaczenia['input_selectdrzewo3_wyszukaj_kategorie'],
			'wyszukaj_kategorie_brak' => $this->tlumaczenia['input_selectdrzewo3_wyszukaj_kategorie_brak'],
			'wyszukaj_kategorie_brak2' => $this->tlumaczenia['input_selectdrzewo3_wyszukaj_kategorie_brak2'],

			'nie_disabled' => (!isset($this->parametry['atrybuty']) || $this->parametry['atrybuty']['disabled'] != 'disabled') ? true : false,
			'drzewo' => $drzewo,
			'domyslny_napis' => $this->parametry['domyslny_napis'],
			'parametry_cfg' => json_encode($parametry['cfg']),
		));

		return $this->szablon->parsuj();
	}

}


