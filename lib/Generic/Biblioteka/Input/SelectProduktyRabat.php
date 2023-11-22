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

class SelectProduktyRabat extends Input
{
	protected $katalogSzablonu = 'SelectProductsDiscountNew';
	protected $tpl = '';

	protected $parametry = array(
		'lista' => array(),
		'wybierz' => '',
	);

	
	function pobierzHtml()
	{
		$wartosc = $this->pobierzWartosc();
		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'atrybuty' => $this->pobierzAtrybuty(),
			'wybierz' => $this->parametry['wybierz'],
			'waluta' => $this->tlumaczenia['input_select_rabat_etykieta_waluta'],
			'etykieta_rabat_rodzaj' => $this->tlumaczenia['input_select_rabat_etykieta_rodzaj'],
			'etykieta_rabat_rodzaj_procentowy' => $this->tlumaczenia['input_select_rabat_etykieta_rabat_rodzaj_procentowy'],
			'etykieta_rabat_rodzaj_kwotowy' => $this->tlumaczenia['input_select_rabat_etykieta_rabat_rodzaj_kwotowy'],
			'etykieta_rabat_na_calosc' => $this->tlumaczenia['input_select_rabat_etykieta_rabat_na_calosc'],
			'etykieta_procent' => $this->tlumaczenia['input_select_rabat_etykieta_procent'],
			'etykieta_discount' => $this->tlumaczenia['input_select_rabat_etykieta_discount'],
			'etykieta_total' => $this->tlumaczenia['input_select_rabat_etykieta_total'],
			'etykieta_total_sum' => $this->tlumaczenia['input_select_rabat_etykieta_total_sum'],
			//Total after discount : 
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
				);
			}
		}
		
		$i = 0;
		foreach ($wartosc as $id => $element)
		{
			$dane['produkt_dodany'][] = array(
				'i' => $i,
				'wartosc_id' => $id,
				'wartosc_nazwa' => $element['nazwa'],
				'wartosc_cena' => $element['cena'],
			);
			$i++;
		}

		$this->szablon->ustaw($dane);
		return $this->szablon->parsuj();
	}
	
	
	/**
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
			
			$rodzajRabatu = Zadanie::pobierz($this->pobierzNazwe().'_rabat_rodzaj');
			$nazwy = Zadanie::pobierz($this->pobierzNazwe().'_nazwa');
			$cena = Zadanie::pobierz($this->pobierzNazwe().'_cena');
			$rabat = Zadanie::pobierz($this->pobierzNazwe().'_rabat');
			$kwota_po_rabacie = Zadanie::pobierz($this->pobierzNazwe().'_kwota_po_rabacie');
			
			$this->wartosc = array();
			$i = 0;
			foreach ($ids as $id)
			{
					$this->wartosc[$id] = array(
						'nazwa' => $nazwy[$i], 
						'cena' => $cena[$i],
						'rabat' => $rabat[$i],
						'kwota_po_rabacie' => $kwota_po_rabacie[$i],
						'rodzajRabatu' => $rodzajRabatu,
						);
				$i++;
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