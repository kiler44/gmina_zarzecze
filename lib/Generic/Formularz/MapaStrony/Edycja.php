<?php
namespace Generic\Formularz\MapaStrony;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Cms;

class Edycja extends \Generic\Formularz\Abstrakcja
{

	/**
	 * @var Array
	 */
	protected $wybrane;


	protected function generujFormularz()
	{

		$this->formularz = new Formularz('', 'formularzEdycji');

		$this->formularz->input(new Input\Html('opis', '&nbsp;', array('wartosc' => $this->tlumaczenia['etykieta_opis'])));

		foreach (Cms::inst()->dane()->Kategoria()->zwracaTablice()->pobierzWszystko() as $kategoria)
		{
			if (in_array($kategoria['typ'], array('glowna','menu')))
			{
				$this->formularz->input(new Input\CheckboxOpis('kategoria_'.$kategoria['id'], '&nbsp;', array(
					'wartosc' => (in_array($kategoria['id'],$this->wybrane)) ? 1 : 0,
					'opis' => $kategoria['nazwa'],
				)));
			}
		}
		$this->formularz->stopka(new Input\Submit('zapisz', '', array(
			'wartosc' => $this->tlumaczenia['etykieta_zapisz']
		)));

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * @return Generic\Formularz\MapaStrony\Edycja
	 */
	public function ustawWybrane(Array $wybrane)
	{
		$this->wybrane = $wybrane;

		return $this;
	}
}