<?php
namespace Generic\Formularz\EmailFormatka;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;

class WyszukiwanieKolejka extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'wyszukiwanieWKolejce', 'multipart/form-data', 'post', true, true);

		$this->formularz->input(new Input\Czysc('czysc'));

		$this->formularz->input(new Input\Submit('szukaj'));

		$this->formularz->input(new Input\Text('fraza'));
		$this->formularz->fraza->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\Text('email'));
		$this->formularz->email->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\Select('typ_wysylania_rowne_', array(
			'lista' => $this->tlumaczenia['typy_wysylania'],
			'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
		)))
			->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		if (Zadanie::pobierz('czysc', 'trim') != '') $this->formularz->resetuj();

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}
}