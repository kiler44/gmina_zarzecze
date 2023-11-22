<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;


/**
 * Klasa obsługująca pole wyboru(checkbox).
 *
 * @author Łukasz Wrucha
 * @package biblioteki
 */

class Checkbox extends Input
{
	protected $katalogSzablonu = 'CheckboxNew';
	
	protected $tpl = '
	<input type="checkbox" name="{{$nazwa}}" value="1" id="{{$nazwa}}" {{IF $zaznaczony}}checked="checked"{{END}} {{$atrybuty}}/>
	<input type="hidden" name="{{$nazwa}}_wyswietlony" value="1" id="{{$nazwa}}_wyswietlony" />
	';

	/**
	 * Pobiera obecna wartosc inputa.
	 *
	 * @return boolean
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
		if (Zadanie::pobierz($this->pobierzNazwe().'_wyswietlony') !== null)
		{
			$this->wartosc = (Zadanie::pobierz($this->pobierzNazwe()) == '1') ? 1 : 0;
			$this->wartosc = $this->filtrujWartosc($this->wartosc);
		}
		else
		{
			$this->wartosc = $this->pobierzWartoscPoczatkowa();
		}
		return $this->wartosc;
	}



	/**
	 * Sprawdza czy input zostal zmodyfikowany.
	 *
	 * @return boolean
	 */
	function zmieniony()
	{
		return ((bool)$this->pobierzWartosc() != (bool)$this->pobierzWartoscPoczatkowa());
	}



	function pobierzHtml()
	{
		$zaznaczony = ((int)$this->pobierzWartosc() > 0) ? true : false;

		$dane = array(
			'nazwa' => $this->nazwa,
			'zaznaczony' => $zaznaczony,
			'atrybuty' => $this->pobierzAtrybuty(),
            'wymagany' => $this->wymagany
		);

		$this->szablon->ustaw($dane);
		return $this->szablon->parsuj();
	}
}
