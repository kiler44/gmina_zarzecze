<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Router;


/**
 * Klasa obsługująca listę rozwijaną(select)
 *
 * @author Marcin Mucha
 * @package biblioteki
 */

class SelectZamowienie extends Input
{
	protected $katalogSzablonu = 'SelectOrderNew';
	protected $tpl = '';

	protected $parametry = array(
		'wybierz' => '',
	);

	
	function pobierzHtml()
	{
		$wartosc = $this->pobierzWartosc();
		$kategorieMapper = new \Generic\Model\Kategoria\Mapper();
		$kategoriaKalendarz = $kategorieMapper->pobierzDlaModulu('Kalendarz');
		
		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'atrybuty' => $this->pobierzAtrybuty(),
			'urlSzukajZamowienie' => Router::urlAjax('admin', $kategoriaKalendarz[0], 'szukajZamowienie' ),
			'szukaj_produkty_magazyn_etykieta' => $this->tlumaczenia['input_szukaj_produkty_magazyn_etykieta'],
		);

		$this->szablon->ustawGlobalne($dane);

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
			$this->wartosc = $dane;
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