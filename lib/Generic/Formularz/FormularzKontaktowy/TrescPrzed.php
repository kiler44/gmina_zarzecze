<?php
namespace Generic\Formularz\FormularzKontaktowy;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Router;

class TrescPrzed extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'trescPrzedFormularz');

		$this->formularz->input(new Input\TextArea('trescPrzed', '', array(
			'wartosc' => $this->obiekt->wartosc,
			'ckeditor' => true,
		)));
		$this->formularz->trescPrzed->dodajFiltr('trim');

		$this->formularz->stopka(new Input\Submit('zapisz', '', array(
			'wartosc' => $this->tlumaczenia['etykieta_zapisz']
		)));
		$this->formularz->stopka(new Input\Button('wstecz', '', array(
			'wartosc' => $this->tlumaczenia['etykieta_wstecz'],
			'atrybuty' => array('onclick' => 'window.location = \''.Router::urlAdmin($this->kategoriaLinkow).'\'' )
		)));

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}

}