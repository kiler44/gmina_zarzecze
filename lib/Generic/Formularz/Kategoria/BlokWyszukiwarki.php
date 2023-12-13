<?php
namespace Generic\Formularz\Kategoria;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;

class BlokWyszukiwarki extends \Generic\Formularz\Abstrakcja
{
	/**
	 * @var Array
	 */
	protected $listaKategorii = array();


	protected function generujFormularz()
	{
        $this->formularz = new Formularz('', 'edycjaMenuCzesciowego');

        $this->formularz->input(new Input\Checkbox('wyszukiwarka_schowana', $this->tlumaczenia['etykieta_wyszukiwarka_schowana'], array(
			'wartosc' => $this->obiekt->wartosc,
		)));

        $this->formularz->stopka(new Input\Submit('zapisz', '', array(
			'wartosc' => $this->tlumaczenia['etykieta_zapisz']
		)));

        $this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * @return \Generic\Formularz\Kategoria\MenuCzesciowe
	 */
	public function ustawListeKategorii(Array $lista)
	{
		$this->listaKategorii = $lista;

		return $this;
	}
}