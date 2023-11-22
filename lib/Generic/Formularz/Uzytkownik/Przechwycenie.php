<?php
namespace Generic\Formularz\Uzytkownik;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;

class Przechwycenie extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'przechwyc');

		$this->formularz->input(new Input\Html('uzytkownik', '&nbsp;', array(
			'wartosc' => sprintf($this->tlumaczenia['etykieta_input_pytanie'], trim($this->obiekt->pelnaNazwa.' ('.$this->obiekt->login.')'))
		)));

		$this->formularz->otworzZbiorowyInput('pytanie', '&nbsp;');

			$this->formularz->input(new Input\Submit('zapisz', '', array(
				'wartosc' => $this->tlumaczenia['etykieta_input_zapisz']
			)));
			$this->formularz->input(new Input\Button('wstecz', '', array(
				'wartosc' => $this->tlumaczenia['etykieta_input_wstecz'],
				'atrybuty' => array('onclick' => 'window.location = \'' . $this->urlPowrotny . '\'' )
			)));

		$this->formularz->zamknijZbiorowyInput('pytanie');

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}
}