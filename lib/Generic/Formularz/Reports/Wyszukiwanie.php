<?php
namespace Generic\Formularz\Reports;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Zadanie;

class Wyszukiwanie extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{ 
		$this->formularz = new Formularz('', 'wyszukiwanieRaportu', '', '' ,true, true);

		$this->formularz->input(new Input\Czysc('czysc'));
		$this->formularz->input(new Input\Submit('szukaj'));
		
		$this->formularz->input(new Input\Select('kategoria', array(
			'lista' => $this->tlumaczenia['kategorie_raportow'],
			'wybierz' => $this->tlumaczenia['wybierz'],
		)));
		
		$this->formularz->kategoria->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		if (Zadanie::pobierz('czysc', 'trim') != '') $this->formularz->resetuj();
      
      $this->formularz->ustawTlumaczenia($this->tlumaczenia);
      
	}
}