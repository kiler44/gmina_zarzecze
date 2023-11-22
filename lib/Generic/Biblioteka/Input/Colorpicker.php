<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;


/**
 * Klasa obsługująca wybór koloru przy użyciu jQuery SimpleColorPicker oraz jQUiColorPicker.
 *
 * @author Konrad Rudowski
 * @package biblioteki
 */

class Colorpicker extends Input
{
	protected $katalogSzablonu = 'ColorpickerNew';
	protected $tpl = '
	<link rel="stylesheet" media="screen" type="text/css" href="/_szablon/be_css/colorpicker.css" />
	<script type="text/javascript" src="/_szablon/biblioteki/jqcolorpicker/js/colorpicker.js"></script>
	<div id="{{$nazwa}}_layout" class="colorSelector">
		<div style=" background-color:{{$wartosc}};" id="{{$nazwa}}_picker"></div>
	</div>
	<input type="hidden" id="{{$nazwa}}" name="{{$nazwa}}" value="{{$wartosc}}"/>
	<script type="text/javascript">
	<!--
	$(\'#{{$nazwa}}_picker\').ColorPicker({
		color: \'{{$wartosc}}\',
		onShow: function (colpkr) {
			$(colpkr).fadeIn(300);
			return false;
		},
		onHide: function (colpkr) {
			$(colpkr).fadeOut(300);
			return false;
		},
		onChange: function (hsb, hex, rgb) {
			$("#{{$nazwa}}").val("#" + hex);
			$("#{{$nazwa}}_picker").css("background-color", "#"+hex);
			{{$click}}
		}
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
		$click = '';
		if (is_array($this->parametry['click']) && count($this->parametry['click']) > 0)
		{
			foreach($this->parametry['click'] as $wartosc)
			{
				$click .= $wartosc."\n";
			}
		}

		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'wartosc' => $this->pobierzWartosc(),
			'click' => $click,
		);

		$this->szablon->ustaw($dane);

		return $this->szablon->parsuj();
	}
}
