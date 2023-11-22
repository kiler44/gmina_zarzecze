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

class SelectKreditnota extends Input
{
	protected $katalogSzablonu = 'SelectKreditnotaNew';
	protected $tpl = '';

	protected $parametry = array(
		'lista' => array(),
		'wybierz' => '',
		'kategorie' => array(),
		'procent_skok' => '5',
	);

	
	function pobierzHtml()
	{
		$wartosc = $this->pobierzWartosc();
		
		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'atrybuty' => $this->pobierzAtrybuty(),
			'wybierz' => $this->parametry['wybierz'],
			'procent_skok' => $this->parametry['procent_skok'],
			'waluta' => $this->tlumaczenia['input_select_kreditnota_etykieta_waluta'],
			'etykieta_procent' => $this->tlumaczenia['input_select_kreditnota_etykieta_procent'],
			'etykieta_minus' => $this->tlumaczenia['input_select_kreditnota_etykieta_minus'],
			'etykieta_ilosc' => $this->tlumaczenia['input_select_kreditnota_etykieta_ilosc'],
			'etykieta_razy' => $this->tlumaczenia['input_select_kreditnota_etykieta_mnoznik'],
			'etykieta_zmniesz_kwote' => $this->tlumaczenia['input_select_etykieta_zmniesz_kwote'],
		);

		$this->szablon->ustawGlobalne($dane);

		
		$lista = array();
		if (is_array($this->parametry['lista']) && count($this->parametry['lista']) > 0)
			$lista = $this->parametry['lista'];
		

		if (count($lista) > 0)
		{
			foreach($lista as $klucz => $val)
			{
				$dane['wiersz'][] = array(
					'wartosc' => htmlspecialchars($klucz),
					'etykieta' => $val['etykieta'],
					'cena' => $val['cena'],
					'procent' => $val['procent'],
					'zmniejszkwote' => $val['zmniejszkwote'],
					'wyswietlaj_zmniejszkwote' => $val['wyswietlaj_zmniejszkwote'],
				);
			}
		}
		
		foreach ($wartosc as $id => $element)
		{
			$dane['produkt_dodany'][] = array(
				'wartosc_id' => $id,
				'wartosc_nazwa' => $element['nazwa'],
				'wartosc_cena' => $element['cena'],
				'wartosc_procent' => $element['procent'],
				'wartosc_kreditnota' => $element['wartosc_kreditnota'],
				'wartosc_sztuka' => $element['wartosc_sztuka'],
				'ilosc' => $element['ilosc'],
				'wyswietlaj_ilosc' => $element['wyswietlaj_ilosc'],
				'kategoria' => $element['kategoria'],
				//'zmniejszkwote' => $element['zmniejszkwote'],
				'wyswietlaj_zmniejszkwote' => (isset($element['wyswietlaj_zmniejszkwote']) && $element['wyswietlaj_zmniejszkwote']) ? 1 : 0,
			);
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
			$wartosc_kreditnota = Zadanie::pobierz($this->pobierzNazwe().'_wartosc_kreditnota');
			$procent = Zadanie::pobierz($this->pobierzNazwe().'_procent');
			$ilosc = Zadanie::pobierz($this->pobierzNazwe().'_ilosc');
			$kategoria = Zadanie::pobierz($this->pobierzNazwe().'_kategoria');
			$wartosc_sztuka = Zadanie::pobierz($this->pobierzNazwe().'_wartosc_sztuka');
			$wyswietlaj_ilosc = Zadanie::pobierz($this->pobierzNazwe().'_wyswietlaj_ilosc');
			//$zmniejszkwote = Zadanie::pobierz($this->pobierzNazwe().'_zmniejszkwote');
			
			$this->wartosc = array();
			$i = 0;
			foreach ($ids as $id)
			{
				$zmniejszkwote = Zadanie::pobierz($this->pobierzNazwe().'_zmniejszkwote_'.$id);
						  
				$this->wartosc[$id] = array(
					'wartosc_id' => $id,
					'nazwa' => $nazwy[$i],
					'cena' => $cena[$i],
					'procent' => $procent[$i],
					'wartosc_kreditnota' => $wartosc_kreditnota[$i],
					'wartosc_sztuka' => $wartosc_sztuka[$i],
					'ilosc' => $ilosc[$i],
					'wyswietlaj_ilosc' => $wyswietlaj_ilosc[$i],
					'kategoria' => $kategoria[$i],
					'zmniejszkwote' => $zmniejszkwote,
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