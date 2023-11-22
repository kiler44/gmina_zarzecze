<?php
namespace Generic\Formularz\Platnosc;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Zadanie;

class Wyszukiwanie extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'wyszukiwaniePlatnosci' . 'Platnosci', 'multipart/form-data', 'post', true, true);

		$this->formularz->input(new Input\Czysc('czysc'));

		$this->formularz->input(new Input\Submit('szukaj'));

		$this->formularz->input(new Input\Text('fraza'));
		$this->formularz->fraza->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\DataSelect('data_dodania_max', array(
			'datepicker' => true,
			'datepicker_cfg' => array(
				'defaultDate' => '""',
				'maxDate' => 'new Date('.(date("Y")).', '.date("m").', '.date("d").')',
			),
			'rok_zakres' => '2010-'.(date("Y")),
			'atrybuty' => array(
				'class' => 'noinput',
			),
			'wybierz' => ' - ',
		)));
		$this->formularz->data_dodania_max->dodajWalidator(new Walidator\DataIso());
		$this->formularz->data_dodania_max->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\DataSelect('data_dodania_min', array(
			'datepicker' => true,
			'datepicker_cfg' => array(
				'defaultDate' => '""',
				'maxDate' => 'new Date('.(date("Y")).', '.date("m").', '.date("d").')',
			),
			'rok_zakres' => '2010-'.(date("Y")),
			'atrybuty' => array(
				'class' => 'noinput',
			),
			'wybierz' => ' - ',
		)));
		$this->formularz->data_dodania_min->dodajWalidator(new Walidator\DataIso());
		$this->formularz->data_dodania_min->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\Select('status', array(
			'lista' => $this->tlumaczenia['status'],
			'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
		)));

		$this->formularz->input(new Input\Text('kwota_max'))->dodajAtrybuty(array('size' => 5));

		$this->formularz->input(new Input\Text('kwota_min'))->dodajAtrybuty(array('size' => 5));


		if (Zadanie::pobierz('czysc', 'trim') != '') $this->formularz->resetuj();

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}
}