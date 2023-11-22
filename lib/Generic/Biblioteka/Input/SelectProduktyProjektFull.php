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

class SelectProduktyProjektFull extends Input
{
	protected $katalogSzablonu = 'SelectProductsProjectFullNew';
	protected $tpl = '';

	protected $parametry = array(
		'lista' => array(),
		'wybierz' => '',
		'kategorie' => array(),
		'procent_skok' => '5',
		'domyslna_wartosc_vat' => '25',
		'zabron_dodaj_produkt' => false,
		'zabron_edycji_ilosci' => false,
		'wyswietla_edytuj_procent' => false,
		'zabron_edycji_kategorii' => false,
		'wyswietlaj_vat' => true,
	);
			  
	function pobierzHtml()
	{
		$wartosc = $this->pobierzWartosc();
		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'atrybuty' => $this->pobierzAtrybuty(),
			'wybierz' => $this->parametry['wybierz'],
			'procent_skok' => $this->parametry['procent_skok'],
			'zabron_dodaj_produkt' => $this->parametry['zabron_dodaj_produkt'],
			'zabron_edycji_ilosci' => $this->parametry['zabron_edycji_ilosci'],
			'zabron_edycji_kategorii' => $this->parametry['zabron_edycji_kategorii'],
			'wyswietla_edytuj_procent' => $this->parametry['wyswietla_edytuj_procent'],
			'domyslna_wartosc_vat' => $this->parametry['domyslna_wartosc_vat'],
			'wyswietlaj_vat' => $this->parametry['wyswietlaj_vat'],
			'waluta' => $this->tlumaczenia['input_select_produkty_projekt_etykieta_waluta'],
			'ilosc' => $this->tlumaczenia['input_select_produkty_projekt_etykieta_ilosc'],
			'kwota' => $this->tlumaczenia['input_select_produkty_projekt_etykieta_kwota'],
			'kwota_total' => $this->tlumaczenia['input_select_produkty_projekt_etykieta_kwota_total'],
			'etykieta_kategorie' => $this->tlumaczenia['input_select_produkty_projekt_etykieta_kategoria'],
			'etykieta_procent' => $this->tlumaczenia['input_select_produkty_projekt_etykieta_procent'],
			'etykieta_kwota' => $this->tlumaczenia['input_select_produkty_projekt_etykieta_kwota'],
			'etykieta_waluta' => $this->tlumaczenia['input_select_produkty_projekt_etykieta_waluta'],
			'etykieta_kwota_znaczek' => $this->tlumaczenia['input_select_produkty_projekt_etykieta_kwota_znaczek'],
			'etykieta_vat' => $this->tlumaczenia['input_select_produkty_projekt_etykieta_vat'],
		);

		$this->szablon->ustawGlobalne($dane);

		if (is_array($this->parametry['kategorie']) && count($this->parametry['kategorie']) > 0)
		{
			$dane['kategorie'][] = array(
					'wartosc' => null,
					'etykieta' => $this->parametry['wybierz_kategorie'],
				);
			foreach( $this->parametry['kategorie'] as $klucz => $val )
			{
				$dane['kategorie'][] = array(
					'wartosc' => $klucz,
					'etykieta' => $val,
				);
			}
		}
		
		
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
				);
			}
		}
		$kwota_total_suma = 0;
		if (count($wartosc))
		{
			$i = 0;
			foreach ($wartosc as $id => $element)
			{
				$kwota = $element['ilosc'] * $element['cena'];
				$kwota_total = 0;
				if (isset($element['procent_wykonania']))
				{
					$kwota_total = ($element['ilosc'] > 1) ? $element['procent_wykonania'] * $element['cena'] : $kwota * ($element['procent_wykonania']/100);
				}
				else
				{
					$kwota_total = $kwota;
				}
				$kwota_total_suma += $kwota_total;
				$dane['produkt_dodany'][] = array(
					'i' => $i,
					'wartosc_id' => $id,
					'wartosc_nazwa' => $element['nazwa'],
					'wartosc_kategoria' => $element['kategoria'],
					'wartosc_cena' => $element['cena'],
					'wartosc_ilosc' => $element['ilosc'],
					'wartosc_procent' => isset($element['procent_wykonania'])? $element['procent_wykonania'] : 100,
					'wartosc_kwota' => number_format($kwota, 2, ',', ' '),
					'wartosc_kwota_total' => number_format($kwota_total, 2, ' ', ','),
					'zabron_edycji_ceny' => (isset($element['zabron_edycji_ceny']) && $element['zabron_edycji_ceny']) ? true : false,
					'zabron_edycji_ilosci' => $this->parametry['zabron_edycji_ilosci'],
					'zabron_edycji_kategorii' => (isset($element['zabron_edycji_kategorii']) && $element['zabron_edycji_kategorii']) ? true : false,
					'zabron_usun' => (isset($element['zabron_usun']) && $element['zabron_usun']) ? true : false,
					'wartosc_vat' => (isset($element['vat'])) ? $element['vat'] : '', 
				);
				$i++;
			}
		}
		$dane['suma_total'] = number_format($kwota_total_suma, 2, ',', ' ');

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
		$dane = Zadanie::pobierz($this->pobierzNazwe().'_id');
		$alert = array();
		
		if ($dane !== null)
		{
			$ids = Zadanie::pobierz($this->pobierzNazwe().'_id');
			if ($ids == '')
				$ids = array();
			
			$nazwy = Zadanie::pobierz($this->pobierzNazwe().'_nazwa');
			$cena = Zadanie::pobierz($this->pobierzNazwe().'_cena');
			$kategoria = Zadanie::pobierz($this->pobierzNazwe().'_kategoria');
			$ilosci = Zadanie::pobierz($this->pobierzNazwe().'_ilosc');
			$procent_wykonania = Zadanie::pobierz($this->pobierzNazwe().'_procent_wykonania');
			$vat = Zadanie::pobierz($this->pobierzNazwe().'_vat');

			$this->wartosc = null;
			if (count($ids))
			{
				$this->wartosc = array();
				$i = 0;
				foreach ($ids as $id)
				{
					if (isset($nazwy[$i]) && isset($ilosci[$i]))
						$this->wartosc[$id] = array(
							'nazwa' => $nazwy[$i], 
							'cena' => $cena[$i],
							'kategoria' => $kategoria[$i],
							'ilosc' => $ilosci[$i],
							'wartosc_procent' => $procent_wykonania[$i],
							'vat' => $vat[$i],
						);
					$i++;
				}
			}
		}
		else
		{
			$this->wartosc = $this->pobierzWartoscPoczatkowa();
		}
		ksort($this->wartosc);
		return $this->wartosc;
	}
	
	function pobierzWartoscPoczatkowa()
	{
		$wartoscPoczatkowa = parent::pobierzWartoscPoczatkowa();
		//dump('Wartosc poczatkowa: ');
		//dump($wartoscPoczatkowa);
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