<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;


/**
 * Klasa obsługująca pole wysyłania formularza(submit) opakowane w treść(span).
 *
 * @author Łukasz Wrucha
 * @package biblioteki
 */

class SubmitOpakowany extends Input
{
	protected $katalogSzablonu = 'SubmitCoverNew';
	protected $tpl = '
	<input class="{{$klasa}}" type="submit" id="{{$nazwa}}" name="{{$nazwa}}" value="{{$wartosc_poczatkowa}}" {{$atrybuty}} />
	';

	protected $parametry = array(
		'klasa' => 'buttonSet buttonRed',
	);


	function pobierzWartosc()
	{
		return null;
	}


	function pobierzHtml()
	{
		$this->szablon->ustaw(array(
			'nazwa' => $this->pobierzNazwe(),
			'wartosc_poczatkowa' => $this->pobierzWartoscPoczatkowa(),
			'atrybuty' => $this->pobierzAtrybuty(),
			'klasa' => $this->parametry['klasa'],
		));

		return $this->szablon->parsuj();
	}

//	function pobierzHtml()
//	{
//		return '<input class="'.$this->parametry['klasa'].'" type="submit" id="'.$this->nazwa.'" name="'.$this->nazwa.'" value="'.$this->pobierzWartoscPoczatkowa().'" '.$this->pobierzAtrybuty().' />';
//	}

}

?>
