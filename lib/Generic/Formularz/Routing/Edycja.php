<?php
namespace Generic\Formularz\Routing;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;

class Edycja extends \Generic\Formularz\Abstrakcja
{

	/**
	 * @var Array
	 */
	protected $listaKategorii = array();

	/**
	 * @var Array
	 */
	protected $listaAkcji = array();


	protected function generujFormularz()
	{

		$this->formularz = new Formularz('', 'reguly_routingu');

		$this->formularz->input(new Input\Text('routing_nazwa', array(
			'wartosc' => $this->obiekt->nazwa,
		)))
			->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\Select('routing_typReguly', array(
			'lista' => $this->tlumaczenia['typyRegul'],
			'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
			'wartosc' => $this->obiekt->typReguly,
		)))
			->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\Select('routing_kategoria', array(
			'lista' => $this->listaKategorii,
			'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
			'wartosc' => $this->obiekt->idKategorii,
		)))
			->dodajAtrybuty(array('onchange' => 'zaladujAkcje();'))
			->dodajFiltr('intval');

		$ustawioneIdKategorii = $this->formularz->routing_kategoria->pobierzWartosc() > 0 ? $this->formularz->routing_kategoria->pobierzWartosc() : $this->obiekt->idKategorii;

		$this->formularz->input(new Input\Select('routing_nazwaAkcji', array(
			'lista' => array_merge(
				array( '' => $this->tlumaczenia['etykieta_select_wybierz']),
					$ustawioneIdKategorii > 0 ? $this->pobierzListeAkcjiDlaInputa($ustawioneIdKategorii): array()
				),
			'wartosc'=> $this->obiekt->nazwaAkcji,
		)))
			->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\Text('routing_wartosc', array(
			'wartosc' => $this->obiekt->wartosc,
		)))
			->dodajFiltr('filtr_xss', 'trim')
			->dodajAtrybuty(array('style' => 'width: 450px;'));

		$this->formularz->input(new Input\Text('routing_szablonUrl', array(
			'wartosc' => $this->obiekt->szablonUrl,
		)))
			->dodajFiltr('strip_tags', 'filtr_xss', 'trim')
			->dodajAtrybuty(array('style' => 'width: 450px;'));


		$this->formularz->stopka(new Input\Submit('zapisz'));
		$this->formularz->stopka(new Input\Button('wstecz', array(
			'atrybuty' => array('onclick' => 'window.location = \'' . $this->urlPowrotny . '\'' )
		)));

		foreach ($this->formularz as $nazwaInputa => $input)
		{
			if (in_array($nazwaInputa, $this->konfiguracja['wymagane_pola']))
			{
				$this->formularz->$nazwaInputa->wymagany = true;
				$this->formularz->$nazwaInputa->dodajWalidator(new Walidator\NiePuste);
			}
		}

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * @return \Generic\Formularz\Routing\Edycja
	 */
	public function ustawListaAkcji(Array $listaAkcji)
	{
		$this->listaAkcji = $listaAkcji;

		return $this;
	}


	/**
	 * @return \Generic\Formularz\Routing\Edycja
	 */
	public function ustawListaKategorii(Array $listaKategorii)
	{
		$this->listaKategorii = $listaKategorii;

		return $this;
	}


	protected function pobierzListeAkcjiDlaInputa($idKategorii)
	{
		$lista = array();
		$kategoria = \Generic\Biblioteka\Cms::inst()->dane()->Kategoria()->zwracaTablice()->pobierzPoId($idKategorii);

		$nazwaModulu = '';

		//TODO: tutaj raz mam obiekt raz tablice - chyba coś z cache
		if (is_array($kategoria))
		{
			$nazwaModulu = 'Generic\\Modul\\' . $kategoria['kod_modulu'] . '\\Http';
		}
		else
		{
			$nazwaModulu = 'Generic\\Modul\\' . $kategoria->kodModulu . '\\Http';
		}

		$modul = new $nazwaModulu;

		foreach ($modul->pobierzAkcje() as $klucz => $akcja)
		{
			$lista[$akcja] = $akcja;
		}

		return $lista;
	}
}