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

class SelectListaPracownikow extends Input
{
	//protected $katalogSzablonu = 'SelectListNew';
	protected $tpl = '';

	protected $parametry = array(
		'lista' => array(),
		'wybierz' => '',
		'dodawanie' => true,
		'skok' => 1,
	);

	
	function pobierzHtml()
	{
		$wartosc = $this->pobierzWartosc();
		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'atrybuty' => $this->pobierzAtrybuty(),
			'wybierz' => $this->parametry['wybierz'],
			'dodawanie' => (bool)$this->parametry['dodawanie'],
			'skok' => $this->parametry['skok'],
		);

		$this->szablon->ustawGlobalne($dane);

		$lista = array();
		if (is_array($this->parametry['lista']) && count($this->parametry['lista']) > 0)
		{
			$lista = $this->parametry['lista'];
		}
		else
		{
			trigger_error('Brak listy danych dla pola select '.$this->nazwa, E_USER_WARNING);
		}

		if (count($lista) > 0)
		{
			foreach($lista as $klucz => $val)
			{
				$dane['wiersz'][] = array(
					'wartosc' => htmlspecialchars($klucz),
					'etykieta' => $val,
				);
			}
			
			foreach ($wartosc as $id => $element)
			{
				$dane['produkt_dodany'][] = array(
					'wartosc_id' => $id,
					'wartosc_nazwa' => $element,
				);
			}
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
		
		if ($dane !== null)
		{
			$ids = Zadanie::pobierz($this->pobierzNazwe().'_id');
			if ($ids == '')
			$ids = array();
		
			$nazwy = Zadanie::pobierz($this->pobierzNazwe().'_nazwa');

			$this->wartosc = array();
			$i = 0;
			foreach ($ids as $id)
			{
				if (isset($nazwy[$i]))
					$this->wartosc[$id] = $nazwy[$i]; $i++;
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