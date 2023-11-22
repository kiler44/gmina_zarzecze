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

class SelectProduktyProjekt extends Input
{
	protected $katalogSzablonu = 'SelectProductsProjectNew';
	protected $tpl = '';

	protected $parametry = array(
		'lista' => array(),
		'wybierz' => '',
		'kategorie' => array(),
		'procent_skok' => '5',
		'zabron_dodaj_produkt' => false,
		'wyswietla_edytuj_procent' => false,
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
			'wyswietla_edytuj_procent' => $this->parametry['wyswietla_edytuj_procent'],
			'waluta' => $this->tlumaczenia['input_select_produkty_projekt_etykieta_waluta'],
			'etykieta_kategorie' => $this->tlumaczenia['input_select_produkty_projekt_etykieta_kategoria'],
			'etykieta_procent' => $this->tlumaczenia['input_select_produkty_projekt_etykieta_procent'],
			'etykieta_kwota' => $this->tlumaczenia['input_select_produkty_projekt_etykieta_kwota'],
			'etykieta_waluta' => $this->tlumaczenia['input_select_produkty_projekt_etykieta_waluta'],
			'etykieta_kwota_znaczek' => $this->tlumaczenia['input_select_produkty_projekt_etykieta_kwota_znaczek'],
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
		
		$i = 0;
		foreach ($wartosc as $id => $element)
		{
			$dane['produkt_dodany'][] = array(
				'i' => $i,
				'wartosc_id' => $id,
				'wartosc_nazwa' => $element['nazwa'],
				'wartosc_cena' => $element['cena'],
				'wartosc_procent_wykonania' => $element['procent_wykonania'],
				'wartosc_ilosc' => $element['ilosc'],
				'wartosc_kategoria' => $element['kategoria'],
				'zabron_edycji_ceny' => (isset($element['zabron_edycji_ceny']) && $element['zabron_edycji_ceny']) ? 'true' : 'false',
				'zabron_edycji_kategorii' => (isset($element['zabron_edycji_kategorii']) && $element['zabron_edycji_kategorii']) ? 'true' : 'false',
				'zabron_usun' => (isset($element['zabron_usun']) && $element['zabron_usun']) ? 'true' : 'false',
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
			
			$nazwy = Zadanie::pobierz($this->pobierzNazwe().'_nazwa');
			$cena = Zadanie::pobierz($this->pobierzNazwe().'_cena');
			$kategoria = Zadanie::pobierz($this->pobierzNazwe().'_category');
			$ilosci = Zadanie::pobierz($this->pobierzNazwe().'_qty');
			$procent_wykonania = Zadanie::pobierz($this->pobierzNazwe().'_procent_wykonania');
			
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
						'procent_wykonania' => $procent_wykonania[$i],
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