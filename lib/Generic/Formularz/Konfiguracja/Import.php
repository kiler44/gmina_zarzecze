<?php
namespace Generic\Formularz\Konfiguracja;
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
		)));

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}

}