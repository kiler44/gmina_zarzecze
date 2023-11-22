<?php
namespace Generic\Formularz\Aktualnosc;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;

class Wyszukiwanie extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'wyszukiwanieAktualnosci');
		$this->formularz->input(new Input\Submit('szukaj'));
		$this->formularz->input(new Input\Text('fraza'));
		$this->formularz->fraza->dodajFiltr('strip_tags', 'filtr_xss', 'trim');
		$this->formularz->input(new Input\Select('data_dodania', array(
			'lista' => $this->tlumaczenia['data_dodania_opcje'],
			'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
		)));
		$this->formularz->input(new Input\Checkbox('priorytetowa'));
		$this->formularz->input(new Input\Checkbox('publikuj'));

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}
}