<?php
namespace Generic\Formularz\Cache;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Walidator;

class Wyszukiwanie extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{

		$this->formularz = new Formularz('');

		$this->formularz->input(new Input\Czysc('czysc'));

		$this->formularz->input(new Input\Submit('szukaj'));

		$this->formularz->input(new Input\Text('fraza'))
			->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\DataSelect('data_modyfikacji', array(
			'datepicker' => true,
			'datepicker_cfg' => array(
				'defaultDate' => '""',
				'maxDate' => 'new Date('.(date("Y")).', '.date("m").', '.date("d").')',
			),
			'rok_zakres' => (date("Y")-1).'-'.(date("Y")),
			'wybierz' => ' - ',
		)))
			->dodajWalidator(new Walidator\DataIso())
			->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		if (Zadanie::pobierz('czysc', 'trim') != '') $this->formularz->resetuj();

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}
}