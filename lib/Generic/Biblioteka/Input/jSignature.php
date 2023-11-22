<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Zadanie;


/**
 * Klasa obsługująca pole do podpisu.
 *
 * @author Marcin Mucha
 * @package biblioteki
 */

class jSignature extends Input
{
	protected $katalogSzablonu = 'jSignatureNew';
	protected $tpl = '';
	
	/**
	 * for more information about type check 
	 * @link www.willowsystems.github.io/jSignature/
	 * @var array
	 */
	private $_dozwolonyTypDanych = array(
		'native', 'image', 'base30', 'image/jsignature;base30', 'svg', 'image/svg+xml', 'svgbase64', 'image/svg+xml;base64'
	);
	private $_dozwolonyTypDanychVector = array(
		'native', 'base30', 'svg','svgbase64'
	);
	
	protected $parametry = array(
		'test' => false,
		'typDanych' => 'image',
		'typDanychVector' => 'base30',
		'podpisNaglowek' => '',
		'wyswlietlajNaglowek' => true,
	);


	function pobierzHtml()
	{
		$cms = Cms::inst();

		//ustawienie domyślnej klasy css long
		if (isset($this->parametry['atrybuty']['class']))
			$this->parametry['atrybuty']['class'] .= ' podpis';
		else
			$this->parametry['atrybuty']['class'] = 'podpis';

		$dane = array(
			'nazwa' => $this->pobierzNazwe(), 
			'wartosc' => htmlspecialchars($this->pobierzWartosc()['wartosc']),
			'wartosc_vector' => htmlspecialchars($this->pobierzWartosc()['wartosc_vector']),
			'atrybuty' => $this->pobierzAtrybuty(),
			'typDanych' => $this->parametry['typDanych'],
			'typDanychVector' => $this->parametry['typDanychVector'],
			'zablokujScroll' => $this->tlumaczenia['input_podpis_zablokujScroll'],
			'odblokujScroll' => $this->tlumaczenia['input_podpis_odblokujScroll'],
		);
		
		if(!in_array($this->parametry['typDanychVector'], $this->_dozwolonyTypDanychVector))
			trigger_error ('Wrong set return vector data type in Input '.__CLASS__);
		
		if(!in_array($this->parametry['typDanych'], $this->_dozwolonyTypDanych))
			trigger_error ('Wrong set return data type in Input '.__CLASS__);
			
		if (isset($this->parametry['wyswlietlajNaglowek']) && $this->parametry['wyswlietlajNaglowek'])
			$this->szablon->ustawBlok('/domyslny/naglowek', array('podpis_naglowek' => ($this->parametry['podpisNaglowek'] != '') ? $this->parametry['podpisNaglowek'] : $this->tlumaczenia['input_podpis_naglowek'],));

		if (isset($this->parametry['test']) && $this->parametry['test'])
			$this->szablon->ustawBlok('/domyslny/test', array());

		return $this->szablon->parsujBlok('domyslny', $dane);
		
	}
	
	/**
	 * Obecna wartosc inputa w formacie [nazwaInputa] => array([wartosc] => wartosc, [wartosc_vector] => $wartoscVector)
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
			$daneVoctor = Zadanie::pobierz($this->pobierzNazwe().'_vector');

			$this->wartosc = array();
			$this->wartosc['wartosc'] = $dane;
			$this->wartosc['wartosc_vector'] = $daneVoctor;
			
		}
		else
		{
			$this->wartosc = $this->pobierzWartoscPoczatkowa();
		}
		
		
		return $this->wartosc;
	}

}
