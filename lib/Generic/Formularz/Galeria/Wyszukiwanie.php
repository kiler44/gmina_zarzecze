<?php
namespace Generic\Formularz\Galeria;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;

class Wyszukiwanie extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'wyszukiwanieWGalerii');
		$this->formularz->input(new Input\Submit('szukaj'));

		$this->formularz->input(new Input\Text('fraza'));
		$this->formularz->fraza->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\Select('data_dodania', array(
			'lista' => $this->tlumaczenia['data_dodania_opcje'],
			'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
		)));

		$this->formularz->input(new Input\Checkbox('publikuj'));

		$this->formularz->input(new Input\Checkbox('przeszukaj_zdjecia'));

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}

}