<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;


/**
 * Klasa obsługująca wybieranie kolejnych wartości z listy przy pomocy kolejnych list rozwijanych(select).
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class SelectWiele extends Input
{
	protected $katalogSzablonu = 'SelectMenyNew';
	protected $parametry = array(
		'lista' => array(),
		'wybierz' => '',
		'dodaj' => '',
		'ilosc' => 99,
	);


	protected $tpl = '
<div id="{{$nazwa}}" class="selectWiele"><div class="selectBoxes">
{{BEGIN select}}
	<span class="select_wrap">
		<select name="{{$nazwa}}[{{$numer}}]" {{$atrybuty}}>
		{{BEGIN wybierz}}
			<option value="">{{$etykieta_wybierz}}</option>
		{{END}}
		{{BEGIN optgroup}}
			<optgroup label="{{$klucz}}">
				{{BEGIN option}}
					<option value="{{$element}}" {{ if($selected,\'selected="selected"\') }}>{{$etykieta}}</option>
				{{END}}
			</optgroup>
		{{END}}
		{{BEGIN option}}
			<option value="{{$klucz}}" {{ if($selected,\'selected="selected"\') }}>{{$wartosc}}</option>
		{{END}}
		</select>
	</span>
{{END}}

<div class="clear"></div></div>
<script type="text/javascript">
<!--

{{$nazwa}}SprawdzPola = function()
	{
		var wartosci = new Array();
		$("#{{$nazwa}} .selectBoxes select").each(function()
		{
			if (wartosci.join().indexOf($(this).val()) >= 0 && $(this).val() != "")
			{
				alert("{{$input_select_wiele_wartosc_juz_wybrana}}");
				$(this).val("");
			}
			else
			{
				wartosci[wartosci.length] = $(this).val();
			}
		});
}

$(document).ready(function(){
	$("#{{$nazwa}} .selectBoxes select").change({{$nazwa}}SprawdzPola);
});
-->
</script>

{{BEGIN dodaj}}
<input type="button" name="{{$nazwa}}_butt" id="{{$nazwa}}_dodaj" value="{{$etykieta_dodaj}}" />
<script type="text/javascript">
<!--
$(document).ready(function() {
var {{$nazwa}}_bierzacy_select = {{$numer}};

$("#{{$nazwa}}_dodaj").click(function()
{
	if ({{$nazwa}}_bierzacy_select < {{$maksymalna_ilosc}})
	{
		$("#{{$nazwa}} .selectBoxes .clear").before(
			$("#{{$nazwa}} .selectBoxes select:first").clone().attr({
				selectedIndex: false,
				name: "{{$nazwa}}[" + {{$nazwa}}_bierzacy_select + "]"
			})
		);
		{{$nazwa}}_bierzacy_select++;
		$("#{{$nazwa}} .selectBoxes select").change({{$nazwa}}SprawdzPola);
		if ({{$nazwa}}_bierzacy_select >= {{$maksymalna_ilosc}})
		{
			$("#{{$nazwa}}_dodaj").css("display","none");
		}
	}
});
});
-->
</script>
{{END}}

</div>
';



	/**
	 * Pobiera obecna wartosc inputa.
	 *
	 * @return array
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
			foreach ($this->wartosc as $k => $v) if ($v == '') unset($this->wartosc[$k]);
			$this->wartosc = $this->filtrujWartosc($this->wartosc);
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
	 *
	 * @return array
	 */
	protected function filtrujWartosc($tablica)
	{
		foreach($this->filtry as $filtr)
		{
			foreach ($tablica as $klucz => $wartosc)
			{
				$tablica[$klucz] = $filtr($wartosc);
			}
		}
		$this->filtrowany = true;
		return $tablica;
	}



	function pobierzHtml()
	{
		$temp = array_unique((array)$this->pobierzWartosc());
		$wartosci = array();
		foreach ($temp as $wartosc)
		{
			$wartosc = trim($wartosc);
			if ($wartosc != '') $wartosci[] = $wartosc;
		}
		unset($temp);
		$wartosci = (empty($wartosci)) ? array(0 => '') : $wartosci;

		if (is_array($this->parametry['lista']) && count($this->parametry['lista']) > 0)
		{
			$lista = $this->parametry['lista'];
		}
		else
		{
			trigger_error('Brak listy danych danych dla pola select', E_USER_WARNING);
		}

		$maksymalnaIlosc = (int)$this->parametry['ilosc'];
		$maksymalnaIlosc = ($maksymalnaIlosc > 0 && $maksymalnaIlosc < 100) ? $maksymalnaIlosc : 99;

		$dane = array();
		$i = 0;
		
		foreach($lista as $klucz => $wartosc)
		{
			if (is_array($wartosc))
			{
				foreach($wartosc as $element => $etykieta)
				{
					$dane['select'][$numer]['optgroup'][$i]['option'][] = array(
						'element' => $element,
						'etykieta' => $etykieta,
						'selected' => (in_array($element, $wartosci)) ? 'selected="selected"' : null,
					);
				}
			}
			else
			{
				if (isset($this->parametry['wybierz']) && $this->parametry['wybierz'] !== '')
				{
					$dane['select']['wybierz'] = array('etykieta_wybierz' => $this->parametry['wybierz']);
				}
				$dane['select']['option'][] = array(
					'klucz' => $klucz,
					'wartosc' => $wartosc,
					'selected' => (in_array($klucz, $wartosci)) ? 'selected="selected"' : null,
				);
			}
			$i++;
		}

		if ($this->parametry['dodaj'] != '' && $numer < $maksymalnaIlosc)
		{
			$dane['dodaj'] = array(
				'etykieta_dodaj' => $this->parametry['dodaj'],
				'numer' => $numer,
				'maksymalna_ilosc' => $maksymalnaIlosc,
			);
		}

		$this->szablon->ustawGlobalne(array(
			'nazwa' => $this->pobierzNazwe(),
			'atrybuty' => $this->pobierzAtrybuty(),
			'input_select_wiele_wartosc_juz_wybrana' => $this->tlumaczenia['input_select_wiele_wartosc_juz_wybrana'],
		));

		$this->szablon->ustaw($dane);

		return $this->szablon->parsuj();
	}

}
