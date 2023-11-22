<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;


/**
 * Klasa obsługująca pola daty i czasu w postaci list rozwijanych(select).
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class DataCzasSelect extends Input
{

	protected $katalogSzablonu = 'DateTimeNew';
	
	protected $parametry = array(
		'rok_zakres' => '', // zakres dat w formacie 1234:1234 np. "1978:2004"
		'wybierz' => '',
		'datepicker' => false,
		'datepicker_cfg' => array(),
		'wyswietlaj_dzien' => 1,
		'wyswietlaj_date' => 1,
		'wyswietlaj_czas' => 1,
		'tlumaczenia_miesiece' => array(),
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

{{BEGIN datepicker}}
<script type="text/javascript">
<!--
$(function() {
	$("#{{$nazwa}}").datepicker({
		onClose: function(dateText, inst) { {{$nazwa}}Odswiez(dateText); },
		onSelect: function(dateText, inst) { {{$nazwa}}Odswiez(dateText); odswiez(); },
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

	function odswiez()
	{
		// sprawdzamy czy dzien miesiaca pasuje
		var ostatniMiesiaca = new Date($("#{{$nazwa}}_rok").val(), $("#{{$nazwa}}_miesiac").val(), 0);

		if ($("#{{$nazwa}}_dzien").val() > ostatniMiesiaca.getDate())
		{
			dzien = (ostatniMiesiaca.getDate() < 10) ? "0" + ostatniMiesiaca.getDate() : ostatniMiesiaca.getDate();
			$("#{{$nazwa}}_dzien option[value=\'" + dzien + "\']").attr("selected", "selected");
		}

		var godzina;
		var czas;

		if($("#{{$nazwa}}_rok").val() != ""
		&& $("#{{$nazwa}}_miesiac").val() != ""
		&& $("#{{$nazwa}}_dzien").val() != "")
		{
			if($("#{{$nazwa}}_godzina").val() != ""
			   && $("#{{$nazwa}}_minuta").val() != "")
			{
				godzina = $("#{{$nazwa}}_godzina").val() + ":" + $("#{{$nazwa}}_minuta").val() + ":00";
			}
			else
			{
				godzina = "00:00:00";
			}

			czas =	$("#{{$nazwa}}_rok").val() + "-" +
					$("#{{$nazwa}}_miesiac").val() + "-" +
					$("#{{$nazwa}}_dzien").val() + " " + godzina;
		}
		else
		{
			czas = "";
		}

		$("#{{$nazwa}}").val(czas);
	}

	// kiedy select-y sa zmieniane updateujemy tez datePicker
	$("#{{$nazwa}}_dzien, #{{$nazwa}}_miesiac, #{{$nazwa}}_rok, #{{$nazwa}}_godzina, #{{$nazwa}}_minuta").change(function(){
		odswiez();
	});
});
-->
</script>
{{END}}

{{BEGIN selectGodzina}}
	<select name="{{$nazwa}}_godzina" id="{{$nazwa}}_godzina" {{$atrybuty}}>
	{{BEGIN wybierz}}
		<option value="">{{$etykieta_wybierz}}</option>
	{{END}}
	{{BEGIN option}}
		<option value="{{$godzina}}" {{ if($selected,\'selected="selected"\') }}>{{$godzina}}</option>
	{{END}}
	</select> :
{{END}}

{{BEGIN selectMinuta}}
	<select name="{{$nazwa}}_minuta" id="{{$nazwa}}_minuta" {{$atrybuty}}>
	{{BEGIN wybierz}}
		<option value="">{{$etykieta_wybierz}}</option>
	{{END}}
	{{BEGIN option}}
		<option value="{{$minuta}}" {{ if($selected,\'selected="selected"\') }}>{{$minuta}}</option>
	{{END}}
	</select>
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

		if ($this->wartosc !== null)
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
		$wybranaGodzina = substr($data, 11, 2);
		$wybranaMinuta =substr($data, 14, 2);
		$rokStart = ($wybranyRok > 0) ? $wybranyRok - 50 : date("Y") - 50;
		$rokStop = ($wybranyRok > 0) ? $wybranyRok + 50 : date("Y") + 50;

		if ($this->parametry['rok_zakres'] != '')
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
			
			if(isset($this->parametry['tlumaczenia_miesiece'][$miesiac]) && $this->parametry['tlumaczenia_miesiece'][$miesiac] !='')
			{
				$miesiac_label = $this->parametry['tlumaczenia_miesiece'][$miesiac];
			}
			else
			{
				$miesiac_label = $miesiac;
			}
			
			$dane['selectMiesiac']['option'][] = array(
				'selected' => ($miesiac == $wybranyMiesiac) ? 1 : 0,
				'miesiac' => $miesiac,
				'label' => $miesiac_label,
			);
		}
		
		if($this->parametry['wyswietlaj_dzien'])
		{
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
			$dane['wyswietlaj_dzien'] = 1;
		}
		else
		{
			$dane['wyswietlaj_dzien'] = 0;
		}

		if ((bool)$this->parametry['datepicker'] == true)
		{
			$datepicker_cfg = '';
			$parametry = (is_array($this->parametry['datepicker_cfg']) && !empty($this->parametry['datepicker_cfg'])) ? $this->parametry['datepicker_cfg'] : array();

			$parametry['showOn'] = "'button'";
			$parametry['buttonImage'] = "'/_system/admin/ikony/calendar.png'";
			$parametry['buttonImageOnly'] = 'true';

			foreach ($parametry as $nazwa => $wartosc)
			{
				$datepicker_cfg .= $nazwa.': '.$wartosc.', ';
			}
			$datepicker_cfg = substr($datepicker_cfg, 0 , -2);

			$dane['datepicker'] = array(
				'datapicker_config' => $datepicker_cfg,
				'kod_jezyka' => KOD_JEZYKA,
			);
		}
		
		if($this->parametry['wyswietlaj_czas'])
		{
			if ($this->parametry['wybierz'] != '')
			{
				$dane['selectGodzina']['wybierz'] = array('etykieta_wybierz' => $this->parametry['wybierz']);
			}
			foreach (range(0, 23) as $godzina)
			{
				$godzina = sprintf("%02d", $godzina);
				$dane['selectGodzina']['option'][] = array(
					'selected' => ($godzina == $wybranaGodzina) ? 1 : 0,
					'godzina' => $godzina,
				);
			}

			if ($this->parametry['wybierz'] != '')
			{
				$dane['selectMinuta']['wybierz'] = array('etykieta_wybierz' => $this->parametry['wybierz']);
			}
			foreach (range(0, 59) as $minuta)
			{
				$minuta = sprintf("%02d", $minuta);
				$dane['selectMinuta']['option'][] = array(
					'selected' => ($minuta == $wybranaMinuta) ? 1 : 0,
					'minuta' => $minuta,
				);
			}
			$dane['wyswietlaj_czas'] = 1;
		}
		else
		{
			$dane['wyswietlaj_czas'] = 0;
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
