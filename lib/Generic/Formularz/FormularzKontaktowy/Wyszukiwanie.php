<?php
namespace Generic\Formularz\FormularzKontaktowy;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;

class Wyszukiwanie extends \Generic\Formularz\Abstrakcja
{
	/**
	 * @var array
	 */
	protected $tematy;

	
	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'formularzKontatkowyWyszukiwanie');
		$this->formularz->input(new Input\Submit('szukaj', '', array('wartosc' => $this->tlumaczenia['etykieta_input_szukaj'])));
		$this->formularz->input(new Input\Text('fraza', $this->tlumaczenia['etykieta_input_fraza']));
		$this->formularz->fraza->dodajFiltr('strip_tags', 'filtr_xss', 'trim');
		$this->formularz->input(new Input\Select('data_wyslania', $this->tlumaczenia['etykieta_input_data_wyslania'], array(
			'lista' => $this->tlumaczenia['data_dodania_opcje'],
			'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
		)));
		$tematy = array();

		foreach($this->tematy as $temat)
		{
			$tematy[$temat->id] = $temat->temat;
		}
		$this->formularz->input(new Input\Select('temat', $this->tlumaczenia['etykieta_input_temat'], array(
			'lista' => $tematy,
			'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
		)));

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * @return \Generic\Formularz\FormularzKontaktowy\Wyszukiwanie
	 */
	public function ustawTematy(Array $tematy)
	{
		$this->tematy = $tematy;

		return $this;
	}
}