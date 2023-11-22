<?php
namespace Generic\Formularz\Uzytkownik;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;

class PrzypomnijHaslo extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{

		$this->formularz = new Formularz('', 'przypomnienie_hasla');
		$this->formularz->input(new Input\Html('info'));
		$this->formularz->input(new Input\Text('login'));
		$this->formularz->login->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\Text('email'));
		$this->formularz->email->dodajFiltr('trim');
		$this->formularz->email->dodajWalidator(new Walidator\Email());

		//$this->formularz->input(new Input\Submit('submit'));

		$this->formularz->stopka(new Input\Submit('zapisz'));
		$this->formularz->stopka(new Input\Button('wstecz', array(
			'atrybuty' => array('onclick' => 'window.location = \'' . $this->urlPowrotny . '\'' )
		)));
		
		foreach ($this->formularz as $nazwaInputa => $input)
		{
			if($nazwaInputa == 'submit') continue;
			$this->formularz->$nazwaInputa->wymagany = true;
			$this->formularz->$nazwaInputa->dodajWalidator(new Walidator\NiePuste);
		}

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}

}