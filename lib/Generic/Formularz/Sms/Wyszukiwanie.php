<?php
namespace Generic\Formularz\Sms;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Zadanie;

class Wyszukiwanie extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{ 
		$this->formularz = new Formularz('', 'wyszukiwarkaSms', '', '' ,true, true);

		$this->formularz->input(new Input\Czysc('czysc'));
		$this->formularz->input(new Input\Submit('szukaj'));

		$this->formularz->input(new Input\Text('fraza'));
		$this->formularz->fraza->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\Select('sent', array(
			'lista' => $this->tlumaczenia['wiadomosc_wyslana'],
		)));
		if (Zadanie::pobierz('czysc', 'trim') != '') $this->formularz->resetuj();
      
      $this->formularz->ustawTlumaczenia($this->tlumaczenia);
      
	}
}