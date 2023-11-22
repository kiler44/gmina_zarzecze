<?php
namespace Generic\Formularz\Uzytkownik;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Cms;
use Generic\Model\Rola;

class Wyszukiwanie extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'wyszukiwanieUzytkownikow' . 'Uzytkownicy', 'multipart/form-data', 'post', true, true);

		$this->formularz->input(new Input\Czysc('czysc'));

		$this->formularz->input(new Input\Submit('szukaj'));

		$this->formularz->input(new Input\Text('fraza'));
		$this->formularz->fraza->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\Data('data_dodania_do', array(
			'datepicker' => true,
			'datepicker_cfg' => array(
				'defaultDate' => '""',
				'maxDate' => 'new Date('.(date("Y")).', '.date("m").', '.date("d").')',
			),
			'rok_zakres' => '2010-'.(date("Y")),
			'atrybuty' => array(
				'class' => 'noinput input-small',
			),
			'wybierz' => ' - ',
		)));
		$this->formularz->data_dodania_do->dodajWalidator(new Walidator\DataIso());
		$this->formularz->data_dodania_do->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\Data('data_dodania_od', array(
			'datepicker' => true,
			'datepicker_cfg' => array(
				'defaultDate' => '""',
				'maxDate' => 'new Date('.(date("Y")).', '.date("m").', '.date("d").')',
			),
			'rok_zakres' => '2010-'.(date("Y")),
			'atrybuty' => array(
				'class' => 'noinput input-small',
			),
			'wybierz' => ' - ',
		)));
		$this->formularz->data_dodania_od->dodajWalidator(new Walidator\DataIso());
		$this->formularz->data_dodania_od->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\Text('email'));
		$this->formularz->email->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\Select('status', array(
			'lista' => $this->tlumaczenia['uzytkownik.statusy'],
			'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
		)));

		$this->formularz->input(new Input\Select('czy_admin', array(
			'lista' => array(
				'3' => $this->tlumaczenia['admin_tak'],
				'2' => $this->tlumaczenia['admin_nie'],
			),
			'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
		)));
		$this->formularz->czy_admin->dodajFiltr('intval','abs');

		$role = Cms::inst()->dane()->Rola()->zwracaTablice()->szukaj(array('tylko_zwykle_role' => true), null, new Rola\Sorter('nazwa', 'ASC'));
		$lista = listaZTablicy($role, 'id', 'nazwa');

		if (count($lista) > 0)
		{
			$this->formularz->input(new Input\Select('rola', array(
				'lista' => $lista,
				'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
			)));
			$this->formularz->rola->dodajFiltr('intval','abs');
		}

		if (Zadanie::pobierz('czysc', 'trim') != '') $this->formularz->resetuj();

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}
}