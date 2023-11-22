<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Router;


/**
 * Klasa obsługująca listę rozwijaną(select)
 *
 * @author Łukasz Wrucha
 * @package biblioteki
 */

class SelectProduktyMagazyn extends Input
{
	protected $katalogSzablonu = 'SelectProductsStorageNew';
	protected $tpl = '';

	protected $parametry = array(
		'lista' => array(),
		'wybierz' => '',
		'blokuj' => 0,
	);

	
	function pobierzHtml()
	{
		$wartosc = $this->pobierzWartosc();
		$kategorieMapper = new \Generic\Model\Kategoria\Mapper();
		$kategoriaMagazyn = $kategorieMapper->pobierzDlaModulu('Magazyn');
		
		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'atrybuty' => $this->pobierzAtrybuty(),
			'linkAjaxSzukaj' => Router::urlAjax('admin', $kategoriaMagazyn[0], 'szukajProduktowSelectAjax' ) ,
			'szukaj_produkty_magazyn_etykieta' => $this->tlumaczenia['input_szukaj_produkty_magazyn_etykieta'],
			'blokuj' => $this->parametry['blokuj'],
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
					'main' => $val['main'],
				);
			}
		}
		foreach ($wartosc as $id => $element)
		{
			$dane['produkt_dodany'][] = array(
				'wartosc_id' => $id,
				'wartosc_nazwa' => $element['nazwa'],
				'wartosc_ilosc' => $element['ilosc'],
				'wartosc_kod' => $element['kod'],
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
			$kod = Zadanie::pobierz($this->pobierzNazwe().'_kod');

			$this->wartosc = array();
			$i = 0;
			foreach ($ids as $id)
			{
				if (isset($nazwy[$i]) && isset($ilosci[$i]))
					$this->wartosc[$id] = array('nazwa' => $nazwy[$i], 'ilosc' => $ilosci[$i], 'kod' => $kod[$i]); $i++;
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