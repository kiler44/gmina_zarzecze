<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;


/**
 * Klasa obsługująca pole hasła.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
class Password extends Input
{
	protected $katalogSzablonu = 'PasswordNew';
	protected $tpl = '
	<input type="password" id="{{$nazwa}}" name="{{$nazwa}}" value="" {{$atrybuty}} />
	';

	function pobierzHtml()
	{
		$this->szablon->ustaw(array(
			'nazwa' => $this->pobierzNazwe(),
			'atrybuty' => $this->pobierzAtrybuty(),
		));
		return $this->szablon->parsuj();
	}
}