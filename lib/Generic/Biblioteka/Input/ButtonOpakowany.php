<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;


/**
 * Klasa obsługująca przycisk z dodatkowym opakowaniem(span).
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class ButtonOpakowany extends Input
{
	protected $katalogSzablonu = 'ButtonCoverNew';
	
	protected $tpl = '
		<input class="{{$klasa}}" type="{{$typ}}" id="{{$nazwa}}" name="{{$nazwa}}" value="{{$wartosc_poczatkowa}}" {{$atrybuty}} />
	';

	protected $parametry = array(
		'klasa' => 'buttonSet buttonLight',
		'typ' => 'button',
	);


	function pobierzWartosc()
	{
		return null;
	}

	function pobierzHtml()
	{
		$typ = (in_array(strtolower($this->parametry['typ']), array('submit', 'reset', 'button', 'image'))) ? $this->parametry['typ'] : 'button';

		$dane = array(
			'nazwa' => $this->nazwa,
			'typ' => $typ,
			'klasa' => (isset($this->parametry['klasa'])) ? $this->parametry['klasa'] : '',
			'wartosc_poczatkowa' => $this->pobierzWartoscPoczatkowa(),
			'atrybuty' => $this->pobierzAtrybuty(),
		);

		$this->szablon->ustaw($dane);
		return $this->szablon->parsuj();
	}
}