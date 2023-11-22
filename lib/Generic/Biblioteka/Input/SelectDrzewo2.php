<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;


/**
 * Klasa obsługująca strukturę drzewa z dodatkową wyszukiwarką.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class SelectDrzewo2 extends Input
{
	protected $katalogSzablonu = 'SelectTree2New';
	protected $tpl ='
	<div style="margin: 5px;">
	<div>{{$etykieta_podpowiedz}}</div>
	<input type="text" id="{{$nazwa}}_fraza"/>
	<div id="{{$nazwa}}_wyniki"></div>
	<input type="hidden" name="{{$nazwa}}" id="{{$nazwa}}" value="{{$wartosc}}" {{$atrybuty}}/>
	</div>
	<script type="text/javascript">
	<!--
	var {{$nazwa}}_drzewo = { {{$drzewo}} };
	var sciezka = [];
	var lista = [];

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
				$(this).attr("style", "width:100%");
			}
		});

		if ($("input[name={{$nazwa}}]").val() == "")
		{
			$("#{{$nazwa}}_komunikat").show();
		}
	}

	$(document).ready(function(){

		$("input[name={{$nazwa}}]").optionTree({{$nazwa}}_drzewo, {{$parametry_cfg}});

		$("#{{$nazwa}}_fraza").keyup(function() {
			var zapytanie = jQuery.trim($("#{{$nazwa}}_fraza").val());

			if (zapytanie.length > 2)
			{
				$("input[name={{$nazwa}}]").unbind("optionTree");
				$("input[name={{$nazwa}}]").optionTree({{$nazwa}}_drzewo, {{$parametry_cfg}});
				przeszukajDrzewo(zapytanie, {{$nazwa}}_drzewo, sciezka);
				var tresc = "<select size=8 style=\"width:100%;overflow: scroll;\" onchange=\"wybierz(this.options[selectedIndex].value, \'{{$nazwa}}\');\">";
				for (var i=0;i < lista.length; i++)
				{
					wartosc = lista[i].join(" / ");
					//opis = wartosc.replace(new RegExp(zapytanie,"i"), "<strong>" + zapytanie + "</strong>");
					tresc = tresc + "<option value=\"" + wartosc + "\">" + wartosc + "</option>";
				}
				tresc = tresc + "</select>";
				$("#{{$nazwa}}_wyniki").html(tresc);
				lista = [];
			}
			else
			{
				$("#{{$nazwa}}_wyniki").html("");
				$("#{{$nazwa}}_komunikat").hide();
				lista = [];
			}
		});
	});

	-->
	</script>
	';

	protected $parametry = array(
		'wybierz' => '- select -',
		'cfg' => array(),
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
			'etykieta_podpowiedz' => $this->tlumaczenia['input_selectdrzewo2_captcha_text_etykieta_podpowiedz'],
			'drzewo' => $drzewo,
			'wybierz' => $this->parametry['wybierz'],
			'parametry_cfg' => json_encode($parametry['cfg']),
		));

		return $this->szablon->parsuj();
	}

}


