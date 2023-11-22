<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;


/**
 * Klasa obsługująca wybór koloru przy użyciu jQuery SimpleColorPicker.
 *
 * @author Łukasz Wrucha
 * @package biblioteki
 */

class SimpleColorpicker extends Input
{
	protected $katalogSzablonu = 'SimpleColorpickerNew';
	protected $tpl = '
	<div id="{{$nazwa}}_layout"></div>
	<input type="hidden" id="{{$nazwa}}" name="{{$nazwa}}" value="{{$wartosc}}"/>
	<script type="text/javascript">
	<!--
	$("#{{$nazwa}}_layout").colorPicker({
		defaultColor: {{$wybrany_index}},
		{{$paleta_js}}
		click: function(color){
			$("#{{$nazwa}}").val(color);
			{{$click}}
		}
		{{$cfg}}
	});
	-->
	</script>
	';

	protected $parametry = array(
		'cfg' => array(),
		'click' => array(),
		'paleta' => array(),
	);



	function pobierzHtml()
	{
		$cfg = '';
		if (is_array($this->parametry['cfg']) && count($this->parametry['cfg']) > 0)
		{
			foreach($this->parametry['cfg'] as $nazwa => $wartosc)
			{
				$cfg .= $nazwa.': '.$wartosc.', ';
			}
			$cfg = ",\n".substr($cfg, 0, -2);
		}

		$click = '';
		if (is_array($this->parametry['click']) && count($this->parametry['click']) > 0)
		{
			foreach($this->parametry['click'] as $wartosc)
			{
				$click .= $wartosc."\n";
			}
		}

		$paleta_js = '';
		$wybrany_index = 13;
		if (is_array($this->parametry['paleta']) && count($this->parametry['paleta']) > 0)
		{
			$paleta_js = 'color: [';
			foreach($this->parametry['paleta'] as $wartosc)
			{
				$paleta_js .= '\''.$wartosc.'\',';
			}
			$paleta_js = substr($paleta_js, 0, -1);
			$paleta_js .= '],';

			$wybrany_index = array_search($this->pobierzWartosc(), $this->parametry['paleta']);
			if (!is_int($wybrany_index)) $wybrany_index = count($this->parametry['paleta']) - 1;
		}

		$this->szablon->ustaw(array(
			'nazwa' => $this->pobierzNazwe(),
			'atrybuty' => $this->pobierzAtrybuty(),
			'wartosc' => $this->pobierzWartosc(),

			'wybrany_index' => $wybrany_index,
			'paleta_js' => $paleta_js,
			'click' => $click,
			'cfg' => $cfg,
		));

		return $this->szablon->parsuj();
	}
}
