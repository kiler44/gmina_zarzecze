<?php
namespace Generic\Formularz\ZadanieCykliczne;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;

class Uruchom extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'zadanie_cykliczne');

		$this->formularz->input(new Input\DataCzasSelect('dataDanych', array(
			'wartosc' => date('Y-m-d H:i:s'),
			'wybierz' => $this->tlumaczenia['etykieta_data_wybierz'],
			'datepicker' => true,
		)))
		->dodajWalidator(new Walidator\NiePuste)
		->dodajWalidator(new Walidator\DataCzasIso)
		->wymagany = true;

		$this->formularz->input(new Input\DataCzasSelect('dataTresci', array(
			'wartosc' => date('Y-m-d H:i:s'),
			'wybierz' => $this->tlumaczenia['etykieta_data_wybierz'],
			'datepicker' => true,
		)))
		->dodajWalidator(new Walidator\NiePuste)
		->dodajWalidator(new Walidator\DataCzasIso)
		->wymagany = true;

		$this->formularz->stopka(new Input\Submit('zapisz', array('atrybuty' => array(
			'onclick' => 'return confirm(\'' . $this->tlumaczenia['zapisz']['confirm'] . '\');'
		))));
		$this->formularz->stopka(new Input\Button('wstecz', array(
			'atrybuty' => array('onclick' => 'window.location = \'' . $this->urlPowrotny . '\'' )
		)));

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}

}