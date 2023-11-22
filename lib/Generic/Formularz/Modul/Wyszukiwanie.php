<?php
namespace Generic\Formularz\Modul;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Model\DostepnyModul;

class Wyszukiwanie extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'wyszukiwanie');
		$this->formularz->input(new Input\Submit('szukaj', '', array(
			'wartosc' => $this->tlumaczenia['etykieta_input_szukaj']
		)));
		$this->formularz->input(new Input\Text('fraza', $this->tlumaczenia['etykieta_input_fraza']));
		$this->formularz->fraza->dodajFiltr('strip_tags', 'filtr_xss', 'trim');
		$lista = array();
		foreach (DostepnyModul\Obiekt::pobierzDostepneTypy() as $typ)
		{
			$lista[$typ] = $this->tlumaczenia['modul_typy'][$typ];
		}
		$this->formularz->input(new Input\Select('typ', $this->tlumaczenia['etykieta_input_typ'], array(
			'lista' => $lista,
			'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
		)));

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}
}