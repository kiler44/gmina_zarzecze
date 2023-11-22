<?php
namespace Generic\Formularz\EmailFormatka;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;

class Wyszukiwanie extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'wyszukiwanieFormatekEmaili', 'multipart/form-data', 'post', true, true);

		$this->formularz->input(new Input\Czysc('czysc'));

		$this->formularz->input(new Input\Submit('szukaj'));

		$this->formularz->input(new Input\Text('fraza'))
				->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\Select('kategoria_rowne_', array(
			'lista' => $this->tlumaczenia['kategorie'],
			'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
		)))
			->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\Text('email'))
			->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\Select('typ_wysylania_rowne_', array(
			'lista' => $this->tlumaczenia['typy_wysylania'],
			'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
		)))
			->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		if (Zadanie::pobierz('czysc', 'trim') != '') $this->formularz->resetuj();

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}
}