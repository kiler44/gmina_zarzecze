<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;


/**
 * Klasa obsługująca pole wysyłania formularza(submit).
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Submit extends Input
{

	protected $katalogSzablonu = 'SubmitNew';
	protected $tpl = '<input type="submit" id="{{$nazwa}}" name="{{$nazwa}}" value="{{$wartosc}}" {{$atrybuty}} />';


	function pobierzWartosc()
	{
		return null;
	}



	function pobierzHtml()
	{
		$this->szablon->ustaw(array(
			'nazwa' => $this->pobierzNazwe(),
			'wartosc' => $this->pobierzWartoscPoczatkowa(),
			'atrybuty' => $this->pobierzAtrybuty(),
		));

		return $this->szablon->parsuj();
	}

}
