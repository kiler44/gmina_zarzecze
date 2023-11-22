<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;


/**
 * Klasa obsługująca listę rozwijaną(select)
 *
 * @author Marcin Mucha
 * @package biblioteki
 */

class SelectDynamiczny extends Input
{
	protected $katalogSzablonu = 'DynamicSelectNew';
	protected $tpl = '
	<span class="select_wrap"><select name="{{$nazwa}}" id="{{$nazwa}}" {{$atrybuty}}>
	{{IF $wybierz}}<option value="">{{$wybierz}}</option>{{END}}
	{{BEGIN wiele_poziomow}}
		<optgroup label="{{$etykieta_grupy}}">
		{{BEGIN wiersz}}
			<option value="{{$wartosc}}" {{IF $selected}}selected="selected"{{END}}>{{$etykieta}}</option>
		{{END}}
		</optgroup>
	{{END}}

	{{BEGIN wiersz}}
		<option value="{{$wartosc}}" {{IF $selected}}selected="selected"{{END}}>{{$etykieta}}</option>
	{{END}}
	</select></span>
	';

	protected $parametry = array(
		'lista' => array(),
		'wybierz' => '',
	);



	function pobierzHtml()
	{
		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'atrybuty' => $this->pobierzAtrybuty(),
			'wybierz' => $this->parametry['wybierz'],
		);

		$this->szablon->ustawGlobalne($dane);

		$lista = array();
		if (is_array($this->parametry['lista']) && count($this->parametry['lista']) > 0)
		{
			$lista = $this->parametry['lista'];
		}
		else
		{
			trigger_error('Brak listy danych dla pola select '.$this->nazwa, E_USER_WARNING);
		}

		$wybrane = $this->pobierzWartosc();
		$dane['wybrane'] = $wybrane;
		if (count($lista) > 0)
		{
			$i = 0;
			
			foreach($lista as $klucz => $wartosc)
			{
				$dane['wiersz'][] = array(
					'selected' => ($wybrane !== null && in_array($klucz, (array)$wybrane)) ? true : false,
					'wartosc' => htmlspecialchars($klucz),
					'etykieta' => $wartosc['etykieta'],
					'konto' =>  $wartosc['konto'],
				);
			}
		}

		$this->szablon->ustaw($dane);
		return $this->szablon->parsuj();
	}
	
}