<?php
namespace Generic\Formularz\Kategoria;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;

class Import extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'wczytajKonfiguracje');

		$this->formularz->input(new Input\Plik('plik', array(
			'wymagany' => true
		)));
		$this->formularz->plik->dodajWalidator(new Walidator\NiePuste());
		$this->formularz->plik->dodajWalidator(new Walidator\RozszerzeniePliku($this->konfiguracja['dozwolone_formaty_plikow']));

		$this->formularz->stopka(new Input\Submit('zapisz', array(
			'klasa' => 'btn mid',
			'atrybuty' => array('onclick' => 'return confirm(\''.$this->tlumaczenia['etykieta_potwierdz_wczytanie_konfiguracji'].'\')' )
		)));

		$this->formularz->stopka(new Input\Button('wstecz', array(
			'atrybuty' => array('onclick' => 'window.location = \'' . $this->urlPowrotny . '\'' )
		)));

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}

}