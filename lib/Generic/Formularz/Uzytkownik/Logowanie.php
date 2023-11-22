<?php
namespace Generic\Formularz\Uzytkownik;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;

class Logowanie extends \Generic\Formularz\Abstrakcja
{
	protected $linkLogowanie = '';


	protected function generujFormularz()
	{
		$this->formularz = new Formularz($this->linkLogowanie, 'logowanie', null, 'post', false);

		$this->formularz->input(new Input\Html('info'));
		$this->formularz->input(new Input\Text('login', null, array('wymagany' => true)));
		$this->formularz->login->dodajFiltr('strip_tags', 'trim');
		$this->formularz->login->dodajWalidator(new Walidator\NiePuste());

		$this->formularz->input(new Input\Password('haslo', null, array('wymagany' => true)));
		$this->formularz->haslo->dodajFiltr('strip_tags', 'trim');
		$this->formularz->haslo->dodajWalidator(new Walidator\NiePuste());

		/*
		$this->formularz->input(new Input\Submit('zaloguj',  null, array(
			'wartosc' => $this->tlumaczenia['submit']['wartosc'],
			'atrybuty' => array('class' => 'link'),
			'klasa' => 'btn mid'
		)));
		*/
		
		$this->formularz->stopka(new Input\Submit('zaloguj', null, array('wartosc' => $this->tlumaczenia['submit']['wartosc'])));
		
		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * @return \Generic\Formularz\Uzytkownik\Logowanie
	 */
	public function ustawLinkLogowanie($link)
	{
		$this->linkLogowanie = $link;

		return $this;
	}
}