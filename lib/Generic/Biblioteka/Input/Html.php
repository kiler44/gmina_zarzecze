<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;


/**
 * Klasa wyświetlająca dowolną treść html.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Html extends Input
{
	protected $katalogSzablonu = 'HtmlNew';
	protected $tpl = '
	<span id="{{$nazwa}}" {{$atrybuty}} class="statycznyHtmlInput">{{$wartosc}}</span>
	';

	function pobierzHtml()
	{
		//vdump('Z Inputa HTML: '.$this->szablon->parsuj());
		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'wartosc' => $this->pobierzWartosc(),
			'atrybuty' => $this->pobierzAtrybuty(),
		);

		$this->szablon->ustaw($dane);

		return $this->szablon->parsuj();
	}
}
