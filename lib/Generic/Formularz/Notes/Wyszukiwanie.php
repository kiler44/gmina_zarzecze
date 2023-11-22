<?php
namespace Generic\Formularz\Notes;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Zadanie;

class Wyszukiwanie extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{ 
		$this->formularz = new Formularz('', 'wyszukiwanieNotatek', '', '' ,true, true);

		$this->formularz->input(new Input\Czysc('czysc'));
		$this->formularz->input(new Input\Submit('szukaj'));

		/*
		$mapper = new \Generic\Model\WierszKonfiguracji\Mapper();
		$mapper2 = new \Generic\Model\WierszTlumaczen\Mapper();
		$tlumaczenia = $mapper2->pobierzWartoscWierszaTlumaczen('objekty_notatek', 'Notes_Admin');
	   $konfiguracja = $mapper->pobierzWartoscWierszaKonfiguracji('objekty_notatek', 'Notes_Admin');

		$this->formularz->input(new Input\Select('object', array(
			'lista' => $tlumaczenia,
			'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
		)));
		
		$this->formularz->object->dodajFiltr('strip_tags', 'filtr_xss', 'trim');
		 * 
		 */
				  
		$this->formularz->input(new Input\Text('fraza'));
		$this->formularz->fraza->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		if (Zadanie::pobierz('czysc', 'trim') != '') $this->formularz->resetuj();
      
      $this->formularz->ustawTlumaczenia($this->tlumaczenia);
      
	}
}