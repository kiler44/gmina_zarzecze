<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;


/**
 * Klasa obsługująca pole ukryte(hidden).
 *
 * @author Łukasz Wrucha
 * @package biblioteki
 */

class Hidden extends Input
{
	protected $katalogSzablonu = 'HiddenNew';
	protected $tpl = '
	<input type="hidden" name="{{$nazwa}}" value="{{$wartosc}}" id="{{$nazwa}}" />
	';


	function __construct($nazwa, $wartosc, $szablon = null)
	{
		$this->nazwa = $nazwa;
		$this->ustawWartosc($wartosc);

		if ($this->tpl != null)
		{
			$this->ustawSzablon($szablon);
		}
	}


	function pobierzHtml()
	{
		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'wartosc' => $this->pobierzWartosc(),
		);

		//$this->szablon->ustaw($dane);

		return $this->szablon->parsujBlok('domyslny', $dane);
	}
}
