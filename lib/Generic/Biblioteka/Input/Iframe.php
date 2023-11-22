<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;


/**
 * Klasa wyświetlająca ramkę.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Iframe extends Input
{
	protected $katalogSzablonu = 'IframeNew';
	protected $tpl = '
	<iframe type="text" id="{{$nazwa}}" src="{{$wartosc}}" {{$atrybuty}}>{{$tekst_alternatywny}}</iframe>
	';

	protected $parametry = array(
		'text_alternatywny' => '',
	);

/*
	function pobierzWartosc()
	{
		return null;
	}
 * 
 */



	function pobierzHtml()
	{
		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'wartosc' => $this->pobierzWartosc(),
			'atrybuty' => $this->pobierzAtrybuty(),
			'tekst_alternetywny' => $this->parametry['text_alternetywny'],
		);

		$this->szablon->ustaw($dane);

		return $this->szablon->parsuj();
	}

}

