<?php
namespace Generic\Formularz\StronaOpisowa;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;

class Edycja extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'stronaEdycja');

		$this->formularz->input(new Input\Text('tytul', array(
			'wartosc' => $this->obiekt->tytul,
			'atrybuty' => array('style' => 'width: 90%;')
		)));
		$this->formularz->tytul->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\TextArea('tresc', array(
			'wartosc' => $this->obiekt->tresc,
			'ckeditor' => true,
			'ckeditor_przelacznik' => true,
			'atrybuty' => array('style' => 'width: 90%;'),
		)));
		$this->formularz->tresc->dodajFiltr('filtr_xss', 'trim');

		$this->formularz->stopka(new Input\Submit('zapisz', '', array(
			'wartosc' => $this->tlumaczenia['button_zapisz']
		)));


		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}
}