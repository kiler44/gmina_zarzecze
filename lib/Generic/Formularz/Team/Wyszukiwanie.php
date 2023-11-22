<?php
namespace Generic\Formularz\Team;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Zadanie;

class Wyszukiwanie extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{ 
		$this->formularz = new Formularz('', 'wyszukiwanieTeam', '', '' ,true, true);

		$this->formularz->input(new Input\Czysc('czysc'));
		$this->formularz->input(new Input\Submit('szukaj'));
		
		$objektDefinicja = new \Generic\Model\Team\Definicja();
		$listaPracownikow = $objektDefinicja->pobierzPracownikow();
		 
		foreach($listaPracownikow as $pracownik)
		{
			$lista[$pracownik->id] = $pracownik->imie.' '.$pracownik->nazwisko;
		}
		
		$this->formularz->input(new Input\Select('pracownik', array(
			'lista' => $lista,
			'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
		)));

		$this->formularz->input(new Input\Text('fraza'));
		$this->formularz->fraza->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		if (Zadanie::pobierz('czysc', 'trim') != '') $this->formularz->resetuj();
      
      $this->formularz->ustawTlumaczenia($this->tlumaczenia);
      
	}
}