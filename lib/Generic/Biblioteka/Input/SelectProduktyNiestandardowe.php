<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;


/**
 * Klasa obsługująca listę rozwijaną(select)
 *
 * @author Marcin Mucha
 * @package biblioteki
 */

class SelectProduktyNiestandardowe extends Input
{
	protected $katalogSzablonu = 'SelectProductsNotStandardNew';
	protected $tpl = '';

	protected $parametry = array(
		'lista' => array(),
		'wybierz' => '',
		'waluta' => 'Kr.',
		'alert' => 'Alert : ',
		'no-alert' => false,
		'skok' => 1,
	);

	
	function pobierzHtml()
	{
		$wartosc = $this->pobierzWartosc();
		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'atrybuty' => $this->pobierzAtrybuty(),
			'wybierz' => $this->parametry['wybierz'],
			'waluta' => $this->parametry['waluta'],
			'alert' => $this->parametry['alert'],
			'no-alert' => $this->parametry['no-alert'],
			'skok' => $this->parametry['skok'],
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
					'cena' => $val['cena'],
					'zabron_edycji_ceny' => (isset($val['zabron_edycji_ceny']) && $val['zabron_edycji_ceny']) ? 'true' : 'false',
					'multiple' => ($val['multiple']) ? 'true' : 'false',
				);
			}
		}
		
		
		foreach ($wartosc as $id => $element)
		{
			$dane['produkt_dodany'][] = array(
				'wartosc_id' => $id,
				'wartosc_nazwa' => $element['nazwa'],
				'wartosc_ilosc' => $element['ilosc'],
				'wartosc_cena' => $element['cena'],
				'wartosc_alert' => ($this->parametry['no-alert']) ? null : $element['alert'],
				'zabron_edycji_ceny' => (isset($element['zabron_edycji_ceny']) && $element['zabron_edycji_ceny']) ? 'true' : 'false',
				'wartosc_multiple' => ($element['multiple'] == 'true') ? 'true' : 'false',
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
		
		$alert = array();
		
		if ($dane !== null)
		{
			$ids = Zadanie::pobierz($this->pobierzNazwe().'_id');
			if ($ids == '')
			$ids = array();
			
			$nazwy = Zadanie::pobierz($this->pobierzNazwe().'_nazwa');
			$ilosci = Zadanie::pobierz($this->pobierzNazwe().'_qty');
			$cena = Zadanie::pobierz($this->pobierzNazwe().'_cena');
			$alert = Zadanie::pobierz($this->pobierzNazwe().'_alert');
			$multiple = Zadanie::pobierz($this->pobierzNazwe().'_multiple');
			$iloscAlert = count($alert);
			
			$this->wartosc = array();
			$i = 0;
			foreach ($ids as $id)
			{
				$alertZaznacz = ($iloscAlert > 0 && in_array($id, $alert)) ? true : false;
				
				if (isset($nazwy[$i]) && isset($ilosci[$i]))
					$this->wartosc[$id] = array(
						'nazwa' => $nazwy[$i], 
						'ilosc' => $ilosci[$i],
						'cena' => $cena[$i],
						'alert' => $alertZaznacz,
						'multiple' => $multiple[$i]); $i++;
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