<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;


/**
 * Klasa obsługująca listę rozwijaną(select)
 *
 * @author Łukasz Wrucha
 * @package biblioteki
 */

class SelectProdukty extends Input
{
	protected $katalogSzablonu = 'SelectProductsNew';
	protected $tpl = '';

	protected $parametry = array(
		'lista' => array(),
		'skok_h' => 0.25,
		'skok_szt' => 1,
		'skok_gr' => 0.01,
		'min_h' => 0.25,
		'min_szt' => 1,
		'min_gr' => 0.01,
		'wybierz' => '',
	);

	
	function pobierzHtml()
	{
		$wartosc = $this->pobierzWartosc();
		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'atrybuty' => $this->pobierzAtrybuty(),
			'wybierz' => $this->parametry['wybierz'],
			'skok_h' => $this->parametry['skok_h'],
			'skok_szt' => $this->parametry['skok_szt'],
            'skok_gr' => $this->parametry['skok_gr'],
			'min_h' => $this->parametry['min_h'],
			'min_szt' => $this->parametry['min_szt'],
            'min_gr' => $this->parametry['min_gr'],
			'potwierdzResetuj' => $this->tlumaczenia['select_produkty_potwierdz_resetuj'],
			'komunikat_opuszczenie_strony' => $this->tlumaczenia['select_produkty_komunikat_opuszczenie_strony'],
		);

		$this->szablon->ustawGlobalne($dane);

		$lista = array();
		if (is_array($this->parametry['lista']) && count($this->parametry['lista']) > 0)
		{
			$lista = $this->parametry['lista'];
		}


		if (count($lista) > 0)
		{
			foreach($lista as $klucz => $val)
			{
				$dane['wiersz'][] = array(
					'wartosc' => htmlspecialchars($klucz),
					'etykieta' => $val['etykieta'],
					'multiple' => ($val['multiple']) ? 'true' : 'false',
					'main' => $val['main'],
					'jednostka' => (isset($val['jednostka'])) ? $val['jednostka'] : '',
				);
			}
		}
		foreach ($wartosc as $id => $element)
		{
			$dane['produkt_dodany'][] = array(
				'wartosc_id' => $id,
				'wartosc_nazwa' => $element['nazwa'],
				'wartosc_ilosc' => $element['ilosc'],
				'wartosc_multiple' => ($element['multiple'] == 'true') ? 'true' : 'false',
				'wartosc_jednostka' => (isset($element['jednostka'])) ? $element['jednostka'] : '',
				'wartosc_usun' => (isset($element['usun'])) ? $element['usun'] : true,
			);
		}

		$this->szablon->ustaw($dane);
		return $this->szablon->parsuj();
	}
	
	
	/**
	 * Obecna wartosc inputa w formacie array(id_produktu => array('nazwa' => 'Nazwa produktu', 'ilosc' => 4)),
	 *
	 * @return Obecna wartosc inputa.
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
		
		$dane = Zadanie::pobierz($this->pobierzNazwe());
		
		if ($dane !== null)
		{
			$ids = Zadanie::pobierz($this->pobierzNazwe().'_id');
			if ($ids == '')
			$ids = array();
		
			$nazwy = Zadanie::pobierz($this->pobierzNazwe().'_nazwa');
			$ilosci = Zadanie::pobierz($this->pobierzNazwe().'_qty');
			$multiple = Zadanie::pobierz($this->pobierzNazwe().'_multiple');
			$jednostka = Zadanie::pobierz($this->pobierzNazwe().'_jednostka');

			$this->wartosc = array();
			$i = 0;
			foreach ($ids as $id)
			{
				if (isset($nazwy[$i]) && isset($ilosci[$i]))
					$this->wartosc[$id] = array('nazwa' => $nazwy[$i], 'ilosc' => $ilosci[$i], 'multiple' => $multiple[$i], 'jednostka' => $jednostka[$i] ); $i++;
			}
		}
		else
		{
			$this->wartosc = $this->pobierzWartoscPoczatkowa();
		}
		
		
		return $this->wartosc;
	}
	
	function pobierzWartoscPoczatkowa()
	{
		$wartoscPoczatkowa = parent::pobierzWartoscPoczatkowa();
		if (! is_array($wartoscPoczatkowa))
			$wartoscPoczatkowa = array();
		
		return $wartoscPoczatkowa;
	}
	
	/**
	 * Sprawdza czy input zostal zmodyfikowany.
	 *
	 * @return boolean
	 */
	public function zmieniony()
	{
		return ($this->pobierzWartosc() !== $this->pobierzWartoscPoczatkowa());
	}
}