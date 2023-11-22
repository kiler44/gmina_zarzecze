<?php
namespace Generic\Formularz\Routing;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;

class Przekierowania extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'formularzPrzekierowania');

		$this->formularz->input(new Input\Tablica('stale', array(
			'atrybuty' => array('style' => 'width: 400px'),
			'dodawanie_wierszy' => true,
			'wartosc' => $this->obiekt['stale'],
		)));

		$this->formularz->input(new Input\Tablica('regexp', array(
			'atrybuty' => array('style' => 'width: 400px'),
			'dodawanie_wierszy' => true,
			'wartosc' => $this->obiekt['regexp'],
		)));

		$this->formularz->stopka(new Input\Submit('zapisz'));
		$this->formularz->stopka(new Input\Button('wstecz', '', array(
			'atrybuty' => array('onclick' => 'window.location = \'' . $this->urlPowrotny . '\''),
		)));

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}
}