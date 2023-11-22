<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;


/**
 * Klasa obsługująca pole daty w postaci listy rozwijanej(select).
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class DataSelect extends Input
{
	protected $katalogSzablonu = 'DateSelectNew';
	protected $parametry = array(
		'rok_zakres' => '',
		'wybierz' => '',
		'datepicker' => false,
		'datepicker_cfg' => array(),
		'onchange' => ''
	);


	protected $tpl = '
{{BEGIN selectRok}}
	<select name="{{$nazwa}}_rok" id="{{$nazwa}}_rok" {{$atrybuty}}>
	{{BEGIN wybierz}}
		<option value="">{{$etykieta_wybierz}}</option>
	{{END}}
	{{BEGIN option}}
		<option value="{{$rok}}" {{ if($selected,\'selected="selected"\') }}>{{$rok}}</option>
	{{END}}
	</select> -
{{END}}

{{BEGIN selectMiesiac}}
	<select name="{{$nazwa}}_miesiac" id="{{$nazwa}}_miesiac" {{$atrybuty}}>
	{{BEGIN wybierz}}
		<option value="">{{$etykieta_wybierz}}</option>
	{{END}}
	{{BEGIN option}}
		<option value="{{$miesiac}}" {{ if($selected,\'selected="selected"\') }}>{{$miesiac}}</option>
	{{END}}
	</select> -
{{END}}

{{BEGIN selectDzien}}
	<select name="{{$nazwa}}_dzien" id="{{$nazwa}}_dzien" {{$atrybuty}}>
	{{BEGIN wybierz}}
		<option value="">{{$etykieta_wybierz}}</option>
	{{END}}
	{{BEGIN option}}
		<option value="{{$dzien}}" {{ if($selected,\'selected="selected"\') }}>{{$dzien}}</option>
	{{END}}
	</select>
{{END}}
<input type="hidden" id="{{$nazwa}}" name="{{$nazwa}}" value="{{$data}}" />

{{BEGIN noDatapicer}}
<script type="text/javascript">
<!--
$(document).ready(function(){

$("#{{$nazwa}}_dzien, #{{$nazwa}}_miesiac, #{{$nazwa}}_rok").change(function(){

	// sprawdzamy czy dzien miesiaca pasuje
	var ostatniMiesiaca = new Date($("#{{$nazwa}}_rok").val(), $("#{{$nazwa}}_miesiac").val(), 0);
	if ($("#{{$nazwa}}_dzien").val() > ostatniMiesiaca.getDate())
	{
		dzien = (ostatniMiesiaca.getDate() < 10) ? "0" + ostatniMiesiaca.getDate() : ostatniMiesiaca.getDate();
		$("#{{$nazwa}}_dzien option[value=\'" + dzien + "\']").attr("selected", "selected");
	}

	$("#{{$nazwa}}").val($("#{{$nazwa}}_rok").val() + "-" + $("#{{$nazwa}}_miesiac").val() + "-" + $("#{{$nazwa}}_dzien").val());
});

});
-->
</script>
{{END}}

{{BEGIN datapicker}}
<script type="text/javascript">
<!--
$(function() {
$("#{{$nazwa}}").datepicker({
	onClose: function(dateText, inst) { {{$nazwa}}Odswiez(dateText); },
	onSelect: function(dateText, inst) { {{$nazwa}}Odswiez(dateText); {{$onchange_function}} },
	{{$datapicker_config}}
},
$.datetimepicker.regional[\'{{$kod_jezyka}}\']);

var {{$nazwa}}Odswiez = function(wybranaData)
{
	var dzien, miesiac, rok;

	if (wybranaData instanceof Date)
	{
		dzien = (wybranaData.getDate() < 10) ? "0" + wybranaData.getDate() : wybranaData.getDate();
		miesiac = (wybranaData.getMonth()+1 < 10) ? "0" + (wybranaData.getMonth() +1 ) : (wybranaData.getMonth() + 1);
		rok = wybranaData.getFullYear();
	}
	else
	{
		wybranaData = wybranaData.split("-");
		dzien = wybranaData[2];
		miesiac = wybranaData[1];
		rok = wybranaData[0];
	}

	$("#{{$nazwa}}_dzien option[value=\'" + dzien + "\']").attr("selected", "selected");
	$("#{{$nazwa}}_miesiac option[value=\'" + miesiac + "\']").attr("selected", "selected");
	$("#{{$nazwa}}_rok option[value=\'" + rok + "\']").attr("selected", "selected");
}


// kiedy select-y sa zmieniane updateujemy tez datePicker
$("#{{$nazwa}}_dzien, #{{$nazwa}}_miesiac, #{{$nazwa}}_rok").change(function(){

	// sprawdzamy czy dzien miesiaca pasuje
	var ostatniMiesiaca = new Date($("#{{$nazwa}}_rok").val(), $("#{{$nazwa}}_miesiac").val(), 0);

	if ($("#{{$nazwa}}_dzien").val() > ostatniMiesiaca.getDate())
	{
		dzien = (ostatniMiesiaca.getDate() < 10) ? "0" + ostatniMiesiaca.getDate() : ostatniMiesiaca.getDate();
		$("#{{$nazwa}}_dzien option[value=\'" + dzien + "\']").attr("selected", "selected");
	}

	$("#{{$nazwa}}").val($("#{{$nazwa}}_rok").val() + "-" + $("#{{$nazwa}}_miesiac").val() + "-" + $("#{{$nazwa}}_dzien").val());
	{{$onchange_function}}
});

});
-->
</script>
{{END}}
';



	/**
	 * Pobiera obecna wartosc inputa.
	 *
	 * @return string
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
		$this->wartosc = Zadanie::pobierz($this->pobierzNazwe());
		if ($this->wartosc == '--')
		{
			$this->wartosc = '';
		}
		elseif ($this->wartosc !== null)
		{
			$this->wartosc = $this->filtrujWartosc($this->wartosc);
		}
		else
		{
			$this->wartosc = $this->pobierzWartoscPoczatkowa();
		}
		return $this->wartosc;
	}



	function pobierzHtml()
	{
		$data = $this->pobierzWartosc();
		$wybranyRok = substr($data, 0, 4);
		$wybranyMiesiac = substr($data, 5, 2);
		$wybranyDzien =substr($data, 8, 2);
		$rokStart = ($wybranyRok > 0) ? $wybranyRok - 50 : date("Y") - 50;
		$rokStop = ($wybranyRok > 0) ? $wybranyRok + 50 : date("Y") + 50;

		if (isset($this->parametry['rok_zakres']) && $this->parametry['rok_zakres'] != '')
		{
			$r1 = substr($this->parametry['rok_zakres'], 0, 4);
			$r2 = substr($this->parametry['rok_zakres'], 5, 4);
			if (strlen($this->parametry['rok_zakres']) == 9
				&& intval($r1) > 1 && intval($r1) < 3000
				&& intval($r2) > 1 && intval($r2) < 3000)
			{
				$rokStart = $r1;
				$rokStop = $r2;
			}
			else
			{
				trigger_error('Nieprawidlowy zakres dla pola rok(prawidlowo "1978:2004").', E_USER_WARNING);
			}
		}

		$dane = array();

		$dane['data'] = $data;

		if (isset($this->parametry['wybierz']))
		{
			$dane['selectRok']['wybierz'] = array('etykieta_wybierz' => $this->parametry['wybierz']);
		}
		foreach (range($rokStart, $rokStop) as $rok)
		{
			$dane['selectRok']['option'][] = array(
				'selected' => ($rok == $wybranyRok) ? 1 : 0,
				'rok' => $rok,
			);
		}

		if (isset($this->parametry['wybierz']))
		{
			$dane['selectMiesiac']['wybierz'] = array('etykieta_wybierz' => $this->parametry['wybierz']);
		}
		foreach (range(1, 12) as $miesiac)
		{
			$miesiac = sprintf("%02d", $miesiac);
			$dane['selectMiesiac']['option'][] = array(
				'selected' => ($miesiac == $wybranyMiesiac) ? 1 : 0,
				'miesiac' => $miesiac,
			);
		}

		if (isset($this->parametry['wybierz']))
		{
			$dane['selectDzien']['wybierz'] = array('etykieta_wybierz' => $this->parametry['wybierz']);
		}
		foreach (range(1, 31) as $dzien)
		{
			$dzien = sprintf("%02d", $dzien);
			$dane['selectDzien']['option'][] = array(
				'selected' => ($dzien == $wybranyDzien) ? 1 : 0,
				'dzien' => $dzien,
			);
		}

		if (isset($this->parametry['datepicker']) && (bool)$this->parametry['datepicker'] == true)
		{
			$datepicker_cfg = '';
			$parametry = (isset($this->parametry['datepicker_cfg'])) ? (array)$this->parametry['datepicker_cfg'] : array();

			$parametry['showOn'] = "'button'";
			$parametry['buttonImage'] = "'/_system/admin/ikony/calendar.png'";
			$parametry['buttonImageOnly'] = 'true';
			if (!isset($parametry['yearRange'])) $parametry['yearRange'] = '"'.$rokStart.':'.$rokStop.'"';

			foreach ($parametry as $nazwa => $wartosc)
			{
				$datepicker_cfg .= $nazwa.': '.$wartosc.', ';
			}
			$datepicker_cfg = substr($datepicker_cfg, 0 , -2);

			$dane['datapicker'] = array(
				'onchange_function' => $this->parametry['onchange'],
				'datapicker_config' => $datepicker_cfg,
				'kod_jezyka' => KOD_JEZYKA,
			);
		}
		else
		{
			$dane['noDatapicker'] = array(
				'kod_jezyka' => KOD_JEZYKA,
			);
		}

		$this->szablon->ustawGlobalne(array(
			'nazwa' => $this->nazwa,
			'atrybuty' => $this->pobierzAtrybuty(),
		));

		$this->szablon->ustaw($dane);
		$html = $this->szablon->parsuj();

		return $html;
	}

}
