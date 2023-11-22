<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;


/**
 * Klasa obsługująca przycisk.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
class Button extends Input
{

	protected $katalogSzablonu = 'ButtonNew';
	
	protected $tpl = '
		{{BEGIN button}}<button type="{{$typ}}" id="{{$nazwa}}" name="{{$nazwa}}" value="{{$wartosc_poczatkowa}}" {{$atrybuty}}>{{$html}}</button>{{END}}
		{{BEGIN input}}<input type="{{$typ}}" id="{{$nazwa}}" name="{{$nazwa}}" value="{{$wartosc_poczatkowa}}" {{$atrybuty}}/>{{END}}
	';

	protected $parametry = array(
		'typ' => 'button',
		'html' => '',
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
			'wartosc_poczatkowa' => $this->pobierzWartoscPoczatkowa(),
			'atrybuty' => $this->pobierzAtrybuty(),
		);
		if (isset($this->parametry['html']) && $this->parametry['html'] != '')
		{
			$dane = array(
				'button' => array_merge($dane, array('html' => $this->parametry['html']))
			);
		}
		else
		{
			$dane = array(
				'input' => $dane,
			);
		}
		$this->szablon->ustaw($dane);
		return $this->szablon->parsuj();
	}

}
