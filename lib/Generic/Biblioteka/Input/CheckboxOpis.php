<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;


/**
 * Klasa obsługująca pole wyboru(checkbox) z opisem obok.
 *
 * @author Łukasz Wrucha
 * @package biblioteki
 */

class CheckboxOpis extends Input
{
	protected $katalogSzablonu = 'CheckboxDescriptionNew';
	
	protected $tpl = '
	<span id="{{$nazwa}}"></span><input type="checkbox" class="{{$klasa}}" name="{{$nazwa}}" value="1" id="checkbox_{{$nazwa}}" {{IF $zaznaczony}}checked="checked"{{END}} {{$atrybuty}}/>
	<label for="checkbox_{{$nazwa}}">{{$opis}}</label>
	<input type="hidden" name="{{$nazwa}}_wyswietlony" value="1" id="{{$nazwa}}_wyswietlony" />
	';

	protected $parametry = array(
		'opis' => '',
		'klasa' => '',
	);


	/**
	 * Pobiera obecna wartosc inputa.
	 *
	 * @return mixed Obecna wartosc inputa.
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



	function pobierzHtml()
	{
		$zaznaczony = ((int)$this->pobierzWartosc() > 0) ? true : false;

		$dane = array(
			'nazwa' => $this->nazwa,
			'klasa' => (isset($this->parametry['klasa'])) ? $this->parametry['klasa'] : '',
			'zaznaczony' => $zaznaczony,
			'opis' => (isset($this->parametry['opis'])) ? $this->parametry['opis'] : '',
			'atrybuty' => $this->pobierzAtrybuty(),
		);

		$this->szablon->ustaw($dane);
		return $this->szablon->parsuj();
	}

}

