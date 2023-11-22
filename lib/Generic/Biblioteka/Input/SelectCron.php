<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;


/**
 * Klasa obsługująca konfigurację zadań cyklicznych(cron).
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class SelectCron extends Input
{
	protected $katalogSzablonu = 'SelectCronNew';
	protected $tpl = '
	<table border="0" class="input_cron">
		<tr>
		{{BEGIN lista}}
			<td><label for="{{$nazwa}}_{{$pole}}">{{$etykieta}}<br/><select name="{{$nazwa}}_{{$pole}}" id="{{$nazwa}}_{{$pole}}" {{$atrybuty}}>
			{{IF $wybierz}}<option value="">{{$wybierz}}</option>{{END}}
			<option value="*" {{IF $wybrane_pole}}selected="selected"{{END}}>*</option>
			{{BEGIN wiersze}}
				<option value="{{$wartosc}}" {{IF $selected}}selected="selected"{{END}}>{{$wartosc}}</option>
			{{END}}
			</select></td>
		{{END}}
		</tr>
	</table>
	';

	protected $parametry = array(
		'wybierz' => '',
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

		$temp = array(
			'minuty' => Zadanie::pobierz($this->nazwa.'_minuty'),
			'godziny' => Zadanie::pobierz($this->nazwa.'_godziny'),
			'dni' => Zadanie::pobierz($this->nazwa.'_dni'),
			'miesiace' => Zadanie::pobierz($this->nazwa.'_miesiace'),
			'dni_tygodnia' => Zadanie::pobierz($this->nazwa.'_dni_tygodnia'),
		);

		if ($temp['minuty'] !== null
			|| $temp['godziny'] !== null
			|| $temp['dni'] !== null
			|| $temp['miesiace'] !== null
			|| $temp['dni_tygodnia'] !== null)
		{
			$this->wartosc = $this->filtrujWartosc($temp);
		}
		else
		{
			$this->wartosc = $this->pobierzWartoscPoczatkowa();
		}
		return $this->wartosc;
	}



	/**
	 * Filtruje wartosc podana w argumencie
	 *
	 * @param array $tablica Wartosc do filtrowania.
	 * @return array Wartosc po zastosowaniu filtrow.
	 */
	protected function filtrujWartosc($tablica)
	{
		foreach($this->filtry as $filtr)
		{
			foreach ($tablica as $klucz => $wartosc)
			{
				$tablica[$klucz] = $filtr($wartosc);
			}
		}
		$this->filtrowany = true;
		return $tablica;
	}



	function pobierzHtml()
	{
		$lista = array(
			'minuty' => array(0,5,10,15,20,25,30,35,40,45,50,55),
			'godziny' => range(0,23),
			'dni' => range(1,31),
			'miesiace' => range(1,12),
			'dni_tygodnia' => range(0,6),
		);
		$wybrane = array(
			'minuty' => '*',
			'godziny' => '*',
			'dni' => '*',
			'miesiace' => '*',
			'dni_tygodnia' => '*',
		);
		if (is_array($this->pobierzWartosc()))
		{
			foreach ($this->pobierzWartosc() as $klucz => $wartosc)
			{
				if ((string)$wartosc != '') $wybrane[$klucz] =  $wartosc;
			}
		}

		$dane_szablonu = array(
			'nazwa' => $this->pobierzNazwe(),
			'atrybuty' => $this->pobierzAtrybuty(),
		);

		$this->szablon->ustawGlobalne($dane_szablonu);

		$i = 0;
		foreach ($lista as $pole => $dane)
		{
			$dane_szablonu['lista'][$i] = array(
				'pole' => $pole,
				'etykieta' => $this->tlumaczenia['input_select_cron_etykieta_'.$pole],
				'wybierz' => $this->parametry['wybierz'],
				'wybrane_pole' => ($wybrane[$pole] == '*') ? true : false,
			);

			foreach($dane as $wartosc)
			{
				$dane_szablonu['lista'][$i]['wiersze'][] = array(
					'selected' => ($wybrane[$pole] == (string)$wartosc) ? true : false,
					'wartosc' => $wartosc,
				);
			}
			$i++;
		}

		$this->szablon->ustaw($dane_szablonu);

		return $this->szablon->parsuj();
	}
}