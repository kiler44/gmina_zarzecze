<?php
namespace Generic\Formularz\Kategoria;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;

class MenuCzesciowe extends \Generic\Formularz\Abstrakcja
{
	/**
	 * @var Array
	 */
	protected $listaKategorii = array();


	protected function generujFormularz()
	{
        $this->formularz = new Formularz('', 'edycjaMenuCzesciowego');

        $this->formularz->input(new Input\Select('idKategorii', $this->tlumaczenia['etykieta_kategoria'], array(
			'wymagany' => true,
			'lista' => $this->listaKategorii,
			'wartosc' => $this->obiekt->wartosc,
			'wybierz' => $this->tlumaczenia['etykieta_select_wybierz']
		)));
        $this->formularz->idKategorii->dodajWalidator(new Walidator\NiePuste());

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