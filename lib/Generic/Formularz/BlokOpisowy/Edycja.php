<?php
namespace Generic\Formularz\BlokOpisowy;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;

class Edycja extends \Generic\Formularz\Abstrakcja
{

	protected $wlaczycCkeditor = false;


	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'stronaEdycja');

		$this->formularz->input(new Input\Text('tytul', array(
			'wartosc' => $this->obiekt->tytul,
			'atrybuty' => array('style' => 'width: 90%;', 'maxlength' => 255),
		)));
		$this->formularz->tytul->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\TextArea('tresc', array(
			'wartosc' => $this->obiekt->tresc,
			'ckeditor' => $this->wlaczycCkeditor,
			'atrybuty' => array('style' => 'width: 90%;'),
		)));
		$this->formularz->tresc->dodajFiltr('filtr_xss', 'trim');

		$this->formularz->stopka(new Input\Submit('zapisz'));
		$this->formularz->stopka(new Input\Button('wstecz', array(
			'atrybuty' => array('onclick' => 'window.location = \'' . $this->urlPowrotny . '\'' )

		)));

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * @return \Generic\Formularz\BlokOpisowy\Edycja
	 */
	public function ustawCkeditor($czyWlaczycCkeditor)
	{
		$this->wlaczycCkeditor = (bool) $czyWlaczycCkeditor;

		return $this;
	}
}