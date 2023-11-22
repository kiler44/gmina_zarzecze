<?php
namespace Generic\Formularz\Aktualnosc;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;

class EdycjaKategorii extends \Generic\Formularz\Abstrakcja
{

	protected $listaKategorii = array();

	protected $urlPowrotny = '';

	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'edycjaKategorii');

		$this->formularz->input(new Input\Select('idKategorii', $this->tlumaczenia['etykieta_input_kategoria'], array(
			'lista' => $this->listaKategorii,
			'wartosc' => $this->obiekt->wartosc,
			'wybierz' => $this->tlumaczenia['etykieta_input_kateroria_wybierz'],
		), $this->tlumaczenia['opis_input_kategoria']));

		$this->formularz->stopka(new Input\Submit('zapisz', '', array(
			'wartosc' => $this->tlumaczenia['etykieta_zapisz']
		)));

		$this->formularz->stopka(new Input\Button('wstecz', '', array(
			'wartosc' => $this->tlumaczenia['etykieta_wstecz'],
			'atrybuty' => array('onclick' => 'window.location = \''. $this->urlPowrotny .'\'' )
		)));

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * @return \Generic\Formularz\Aktualnosc\EdycjaKategorii
	 */
	public function ustawListeKategorii(Array $lista)
	{
		$this->listaKategorii = $lista;

		return $this;
	}


	/**
	 * @return \Generic\Formularz\Aktualnosc\EdycjaKategorii
	 */
	public function ustawUrlPowrotny($url)
	{
		$this->urlPowrotny = $url;

		return $this;
	}
}