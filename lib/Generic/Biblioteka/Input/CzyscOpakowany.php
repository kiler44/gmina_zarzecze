<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;


/**
 * Klasa obsługująca pole czyszczenia formularza.
 *
 * @author Krzysztof Żak
 * @package biblioteki
 */

class CzyscOpakowany extends Input
{
	protected $katalogSzablonu = 'ClearCoverNew';
	protected $tpl = '
	<span class="{{$klasa}}"><input type="button" id="__{{$nazwa}}" name="__{{$nazwa}}" onclick="{{$nazwa}}_czysc(this)" value="{{$wartosc_poczatkowa}}" {{$atrybuty}} /></span>
	<script type="text/javascript">
	<!--
	function {{$nazwa}}_czysc(element) {
		if ($(\'input[name="{{$nazwa}}"]\').size() < 1)
			$(element).after(\'<input type="hidden" name="{{$nazwa}}" value="{{$nazwa}}"/>\');
		element.form.submit();
	}
	-->
	</script>
	';

	function pobierzWartosc()
	{
		return null;
	}



	function pobierzHtml()
	{
		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'wartosc_poczatkowa' => $this->pobierzWartoscPoczatkowa(),
			'atrybuty' => $this->pobierzAtrybuty(),
			'klasa' => (isset($this->parametry['klasa'])) ? $this->parametry['klasa'] : '',
		);

		$this->szablon->ustaw($dane);

		return $this->szablon->parsuj();
	}

}
