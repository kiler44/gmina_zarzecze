<?php
namespace Generic\Formularz\ZadanieCykliczne;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;

class Wyszukiwanie extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'wyszukajSprawdz', 'multipart/form-data', 'post', true);

		$this->formularz->input(new Input\Submit('szukaj'));

		$this->formularz->input(new Input\DataCzasSelect('data_graniczna', array(
			'datepicker' => true,
			'datepicker_cfg' => array(
				'defaultDate' => 'new Date()',
			),
			'rok_zakres' => '2010-' . (date("Y")),
			'atrybuty' => array(
				'class' => 'noinput',
			),
			'wybierz' => ' - ',
		)));
		$this->formularz->data_graniczna->dodajWalidator(new Walidator\DataCzasIso());
		$this->formularz->data_graniczna->dodajFiltr('strip_tags', 'filtr_xss', 'trim');
		$this->formularz->data_graniczna->ustawWartosc(date('Y-m-d H:i'));

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}

}