<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;


/**
 * Klasa obsługująca pole cena - dedykowane do formularza edycji produktu.
 * Posiada wewnętrzną walidację!
 *
 * @author Konrad Rudowski
 * @package biblioteki
 */

class Cena extends Input
{
	protected $katalogSzablonu = 'PriceNew';

	protected $parametry = array(
		'lista' => array(),
		'inline' => false,
	);

	
	protected $tpl = '
		<div id="{{$nazwa}}">
		{{BEGIN typCeny}}
			{{IF $inline}}<span>{{ELSE}}<div style="margin:3px 0px; height:40px;">{{END}}

			<input type="radio" name="{{$nazwa}}" value="{{$klucz}}" id="{{$nazwa}}_{{$klucz}}" class="noinput"{{IF $selected}} checked="checked"{{END}} {{$atrybuty}}/>
			<label for="{{$nazwa}}_{{$klucz}}">

				{{$przedPole1}}

				{{BEGIN pole1}}
					<input onclick="setFocus(this);" onclick="" style="width:50px;" type="text" name="{{$nazwa}}_{{$klucz}}_cenaOd" value="{{IF $selected}}{{$wartoscCenaOd}}{{END}}" id="{{$nazwa}}_{{$klucz}}_cenaOd" class="{{$nazwa}}_{{$klucz}}_cenaOd {{$nadanaKlasa}}" {{$atrybuty}} />
				{{END}}

				{{$poPole1}}

				{{BEGIN pole2}}
					<input onclick="setFocus(this);" style="width:50px;" type="text" name="{{$nazwa}}_{{$klucz}}_cenaDo" value="{{IF $selected}}{{$wartoscCenaDo}}{{END}}" id="{{$nazwa}}_{{$klucz}}_cenaDo" class="{{$nazwa}}_{{$klucz}}_cenaDo {{$nadanaKlasa}}" {{$atrybuty}} />
				{{END}}

				{{$poPole2}}

			</label>

			{{IF $inline}}</span>{{ELSE}}</div>{{END}}
		{{END}}
		</div><script>
		function setFocus(pole)
		{
			setTimeout(function () {pole.focus();}, 10);
		}
		</script>
	';

	function pobierzHtml()
	{
		if (!is_array($this->parametry['lista']) || count($this->parametry['lista']) == 0)
		{
			trigger_error('Nieprawidlowy parametr "lista" w parametrach '.get_class($this), E_USER_WARNING);
			return;
		}

		$wartosci = $this->pobierzWartosc();

		$dane = array(
			'nazwa' => $this->nazwa,
		);

		$dane['typCeny'] = array();

		$nadanaKlasa = '';
		if (isset($this->parametry['atrybuty']['class']))
		{
			$nadanaKlasa = $this->parametry['atrybuty']['class'];
		}

		foreach($this->parametry['lista'] as $klucz => $wartosc)
		{
			$selected = ($klucz == $wartosci['wartosc']) ? 'checked="checked"' : null;
			if ($klucz == '50' && $wartosci['wartosc'] == '')
			{
				$selected = 'checked="checked"';
			}

			$wystepujePole1 = (bool) strpos($wartosc, '{{pole1}}');
			$wystepujePole2 = (bool) strpos($wartosc, '{{pole2}}');

			$wartosc = explode('|', str_replace(array('{{pole1}}', '{{pole2}}'), '|', $wartosc));


			$typCeny = array(
				'inline' => (bool)$this->parametry['inline'] == true,
				'przedPole1' => isset($wartosc[0]) ? $wartosc[0] : '',
				'poPole1' => isset($wartosc[1]) ? $wartosc[1] : '',
				'poPole2' => isset($wartosc[2]) ? $wartosc[2] : '',
				'nazwa' => $this->nazwa,
				'klucz' => $klucz,
				'selected' => $selected,
				'atrybuty' => $this->pobierzAtrybuty(),

			);

			if ($wystepujePole1)
			{
				$typCeny['pole1'] = array(
					'nazwa' => $this->nazwa,
					'klucz' => $klucz,
					'selected' => $selected,
					'atrybuty' => $this->pobierzAtrybuty(),
					'wartoscCenaOd' => $selected == null ? '' :$wartosci['cenaOd'],
				);
			}

			if ($wystepujePole2)
			{
				$typCeny['pole2'] = array(
					'nazwa' => $this->nazwa,
					'klucz' => $klucz,
					'selected' => $selected,
					'atrybuty' => $this->pobierzAtrybuty(),
					'wartoscCenaDo' => $selected == null ? '' :$wartosci['cenaDo'],
				);
			}

			$dane['typCeny'][] = $typCeny;
		}


		$this->szablon->ustawGlobalne(array(
			'nazwa' => $this->nazwa,
			'atrybuty' => $this->pobierzAtrybuty(),
		));

		$this->szablon->ustaw($dane);
		$html = $this->szablon->parsuj();

		return $html;
	}

	public function pobierzWartosc()
	{
		$wartosc = parent::pobierzWartosc();

		$tmpCenaOd = floatval(isset($this->wartosc['cenaOd']) ? $this->wartosc['cenaOd'] : 0);
		$tmpCenaDo = floatval(isset($this->wartosc['cenaDo']) ? $this->wartosc['cenaDo'] : 0);

		if (isset($_POST[$this->nazwa.'_20_cenaOd']))
		{
			$tmpCenaOd = 0;
			$tmpCenaDo = 0;
		}

		$cenaOdDokladna =	Zadanie::pobierzPost($this->nazwa.'_20_cenaOd', 'filtr_xss', 'trim', 'floatval') > 0 ? Zadanie::pobierzPost($this->nazwa.'_20_cenaOd', 'filtr_xss', 'trim', 'floatval') : $tmpCenaOd;
		$cenaOdOdDo =		Zadanie::pobierzPost($this->nazwa.'_30_cenaOd', 'filtr_xss', 'trim', 'floatval') > 0 ? Zadanie::pobierzPost($this->nazwa.'_30_cenaOd', 'filtr_xss', 'trim', 'floatval') : $tmpCenaOd;
		$cenaDoOdDo =		Zadanie::pobierzPost($this->nazwa.'_30_cenaDo', 'filtr_xss', 'trim', 'floatval') > 0 ? Zadanie::pobierzPost($this->nazwa.'_30_cenaDo', 'filtr_xss', 'trim', 'floatval') : $tmpCenaDo;
		$cenaOdOd =			Zadanie::pobierzPost($this->nazwa.'_40_cenaOd', 'filtr_xss', 'trim', 'floatval') > 0 ? Zadanie::pobierzPost($this->nazwa.'_40_cenaOd', 'filtr_xss', 'trim', 'floatval') : $tmpCenaOd;

		if ( ! is_array($wartosc))
		{
			$wartosc = array('wartosc' => $wartosc);
		}

		switch($wartosc['wartosc'])
		{
			case '20': return array('wartosc' => '20', 'cenaTyp' => '20', 'cenaOd' => $cenaOdDokladna, 'cenaDo' => 0); break;
			case '30': return array('wartosc' => '30', 'cenaTyp' => '30', 'cenaOd' => $cenaOdOdDo, 'cenaDo' => $cenaDoOdDo); break;
			case '40': return array('wartosc' => '40', 'cenaTyp' => '40', 'cenaOd' => $cenaOdOd, 'cenaDo' => 0); break;
			case '50': return array('wartosc' => '50', 'cenaTyp' => '50', 'cenaOd' => 0, 'cenaDo' => 0); break;
		}
	}

	/**
	 * Sprawdza czy input zostal zmodyfikowany.
	 *
	 * @return boolean
	 */
	public function zmieniony()
	{
		$wartosc = $this->pobierzWartosc();
		$poczatkowa = $this->pobierzWartoscPoczatkowa();

		return ($wartosc['wartosc'] != $poczatkowa['wartosc'] || $wartosc['cenaOd'] != $poczatkowa['cenaOd'] || $wartosc['cenaDo'] != $poczatkowa['cenaDo']);
	}


	/**
	 * Zwraca blad walidacji. Uwaga! Własna walidacja pola!
	 *
	 * @return string
	 */
	public function pobierzBladWalidacji()
	{
		if (!$this->sprawdzony)
		{
			$this->sprawdzony = true;
			$this->bladWalidacji = null;
			$wartosc = $this->pobierzWartosc();
			switch ($wartosc['wartosc'])
			{
				case '20': if ($wartosc['cenaOd'] < 0.01) $this->bladWalidacji = $this->tlumaczenia['input_cena_nieprawidlowa_cena']; break;
				case '30': if ($wartosc['cenaOd'] < 0.01 || $wartosc['cenaDo'] < $wartosc['cenaOd']) $this->bladWalidacji = $this->tlumaczenia['input_cena_nieprawidlowa_cena']; break;
				case '40': if ($wartosc['cenaOd'] < 0.01) $this->bladWalidacji = $this->tlumaczenia['input_cena_nieprawidlowa_cena']; break;
			}
		}

		return $this->bladWalidacji;

	}
}
