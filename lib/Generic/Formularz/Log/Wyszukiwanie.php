<?php
namespace Generic\Formularz\Log;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;

class Wyszukiwanie extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'logi');
		$this->formularz->input(new Input\Submit('szukaj', '', array('wartosc' => $this->tlumaczenia['etykieta_input_szukaj'])));
		$this->formularz->input(new Input\Text('fraza', $this->tlumaczenia['etykieta_input_fraza'], array(
			'wartosc' => $this->obiekt['fraza'],
		)));
		$this->formularz->fraza->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\Select('typ', $this->tlumaczenia['etykieta_input_typ'], array(
			'wartosc' => $this->obiekt['typ'],
			'lista' => $this->tlumaczenia['logi_typy'],
			'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
		)));

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}
}