<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;


/**
 * Klasa obsługująca kod pocztowy w postaci pól tekstowych.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class KodPocztowyNorwegia extends Input
{

	protected $katalogSzablonu = 'PostCodeNorwayNew';
	protected $tpl = '
<input type="text" name="{{$nazwa}}" value="{{$wartosc}}" size="4" maxlength="4" class="kod_pocztowy" {{$atrybuty}} id="{{$nazwa}}" />';

	
	protected function uzupelnijZerami($wartosc)
	{
		$przerabiana = strval($wartosc);
		for ($i = 4; $i < strlen($przerabiana); $i--)
		{
			$przerabiana .= '0'.$przerabiana;
		}
		return $przerabiana;
	}
	

	function pobierzHtml()
	{

		$this->szablon->ustaw(array(
			'nazwa' => $this->pobierzNazwe(),
			'wartosc' => $this->uzupelnijZerami($this->pobierzWartosc()),
			'atrybuty' => $this->pobierzAtrybuty(),
		));

		return $this->szablon->parsuj();
	}
}


