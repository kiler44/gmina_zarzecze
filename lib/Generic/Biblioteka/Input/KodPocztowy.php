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

class KodPocztowy extends Input
{

	protected $katalogSzablonu = 'PostCodeNew';
	protected $tpl = '
<input type="text" name="{{$nazwa}}_cz1" value="{{$wartosc_cz1}}" size="2" maxlength="2" class="kod_pocztowy_cz1" {{$atrybuty}} id="{{$nazwa}}" onkeyup="nastepnyInput(this, event, \'input[name={{$nazwa}}_cz2]\')" />
-
<input type="text" name="{{$nazwa}}_cz2" value="{{$wartosc_cz2}}" size="3" maxlength="3"  class="kod_pocztowy_cz2" {{$atrybuty}} onkeyup="poprzedniInput(this, event, \'input[name={{$nazwa}}_cz1]\')" />';

	/**
	 * Obecna wartosc inputa w formacie xx-xxx.
	 *
	 * @return Obecjna wartosc inputa.
	 */
	function pobierzWartosc()
	{
		if ($this->wymusPoczatkowa)
		{
			return $this->pobierzWartoscPoczatkowa();
		}
		if ($this->filtrowany)
		{
			return $this->wartosc;
		}
		$this->wartosc = Zadanie::pobierz($this->pobierzNazwe()."_cz1").'-'.Zadanie::pobierz($this->pobierzNazwe()."_cz2");
		if ($this->wartosc != '-')
		{
			$this->wartosc = $this->filtrujWartosc($this->wartosc);
		}
		else
		{
			$this->wartosc = $this->pobierzWartoscPoczatkowa();
		}
		return $this->wartosc;
	}



	function pobierzHtml()
	{
		$kodCz1 = $kodCz2 = '';
		$kod = $this->pobierzWartosc();
		if (strpos($kod, '-') != 0)
		{
			$kod = explode('-', $kod);
			$kodCz1 = $kod[0];
			$kodCz2 = $kod[1];
		}

		$this->szablon->ustaw(array(
			'nazwa' => $this->pobierzNazwe(),
			'wartosc_cz1' => $kodCz1,
			'wartosc_cz2' => $kodCz2,
			'atrybuty' => $this->pobierzAtrybuty(),
		));

		return $this->szablon->parsuj();
	}
}


