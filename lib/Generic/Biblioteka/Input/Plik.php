<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;


/**
 * Klasa obsługująca pole upload-u plików(file).
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Plik extends Input
{
	protected $katalogSzablonu = 'FileNew';
	protected $tpl = '
	{{BEGIN jest_plik}}
		{{IF $plik_opis}}{{$etykieta_opis}}<input type="text" name="{{$nazwa}}_title" id="{{$nazwa}}_title" value="{{$plik_opis}}" /><br />{{END}}
		<input type="hidden" name="{{$nazwa}}" id="{{$nazwa}}" value="{{$plik_nazwa}}" {{$atrybuty}} />
		{{IF $sciezka}}<a href="{{$sciezka_do_plikow}}{{$plik_nazwa}}">{{$plik_nazwa}}</a>{{ELSE}}{{$plik_nazwa}}{{END}}
		{{IF $usun}}<a href="{{$link_usun}}" class="usun_zdjecie" title="{{$etykieta_usun}}"><img src="/_system/admin/ikony/usun.gif" alt="{{$etykieta_usun}}"/></a>{{END}}
		<br/>
	{{END}}
	{{BEGIN upload}}
		<div class="upload"><input type="file" name="{{$nazwa}}" id="{{$nazwa}}" value="" {{$atrybuty}} /></div>
	{{END}}
	';

	protected $parametry = array(
		'sciezka_plikow' => '', // okresla url katalogu w ktorym znajduje sie plik
		'link_usun' => '', // url do usuwania pliku, jezeli dodany pokaze sie link do usuwania
	);


	function pobierzHtml()
	{
		$plik = $this->pobierzWartosc();

		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'atrybuty' => $this->pobierzAtrybuty(),
			'plik_opis' => (isset($plik['description']) && $plik['description'] != '') ? $plik['description'] : '',
			'plik_nazwa' => $plik['name'],
			'sciezka' => ($this->parametry['sciezka_plikow'] != '') ? true : false,
			'sciezka_do_plikow' => $this->parametry['sciezka_plikow'],
			'usun' => ($this->parametry['link_usun'] != '') ? true : false,
			'link_usun' => str_replace('{PLIK}', $plik['name'], $this->parametry['link_usun']),

			'etykieta_usun' => $this->tlumaczenia['input_plik_etykieta_usun'],
			'etykieta_opis' => $this->tlumaczenia['input_plik_etykieta_opis'],
		);

		$this->szablon->ustawGlobalne($dane);

		if ($plik['name'] != '' && (!isset($plik['tmp_name']) || $plik['tmp_name'] == ''))
		{
			$dane['jest_plik'] = array('nazwa' => $this->pobierzNazwe());


			($this->parametry['link_usun'] != '') ? $dane['jest_plik']['usun'] = true : $dane['jest_plik']['usun'] = false;
		}
		else
		{
			$dane['upload'] = array('nazwa' => $this->pobierzNazwe());
		}

		$this->szablon->ustaw($dane);
		return $this->szablon->parsuj();
	}


	/**
	 * Ustawia wartosc poczatkowa inputa.
	 *
	 * @param mixed $wartoscPoczatkowa Wartosc poczatkowa inputa,
	 * powinna to byc tablica zawierajaca:
	 * - nazwe pliku (pole: 'name'),
	 * - ewantualnym opisem (pole: 'description')
	 * @param bool $wymus wymuszanie nadpisania wartosc.
	 */
	public function ustawWartosc($wartoscPoczatkowa, $wymus = false)
	{
		if (is_string($wartoscPoczatkowa))
		{
			$wartoscPoczatkowa = array('name' => $wartoscPoczatkowa);
		}
		$this->wartoscPoczatkowa = $wartoscPoczatkowa;
		$this->wymusPoczatkowa = (bool)$wymus;
	}



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
		$opis = Zadanie::pobierz($this->pobierzNazwe().'_title');
		if (isset($_FILES[$this->pobierzNazwe()]))
		{
			$temp = $_FILES[$this->pobierzNazwe()];
			if ($opis !== null) $temp['description'] = $opis;
			$this->wartosc = $this->filtrujWartosc($temp);
			unset($temp);
		}
		elseif (Zadanie::pobierz($this->pobierzNazwe()) !== null)
		{
			$temp['name'] = Zadanie::pobierz($this->pobierzNazwe());
			if ($opis !== null) $temp['description'] = $opis;
			$this->wartosc = $this->filtrujWartosc($temp);
			unset($temp);
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
		if (isset($tablica['description']))
		{
			foreach($this->filtry as $filtr)
			{
				$tablica['description'] = $filtr($tablica['description']);
			}
		}
		$this->filtrowany = true;
		return $tablica;
	}



	/**
	 * Sprawdza czy input zostal zmodyfikowany.
	 *
	 * @return bool True jezel input zostal zmodyfikowany, false w przeciwnym wyadku.
	 */
	function zmieniony()
	{
		$wartoscPoczatkowa = $this->pobierzWartoscPoczatkowa();
		if ((isset($_FILES[$this->pobierzNazwe()]) && is_uploaded_file($_FILES[$this->pobierzNazwe()]['tmp_name']))
			||(isset($this->wartosc['description']) && $this->wartosc['description'] != $wartoscPoczatkowa['description']))
			return true;
		else
			return false;
	}
}


