<?php
namespace Generic\Formularz\Uprawnienie;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;

class EdycjaEventy extends \Generic\Formularz\Abstrakcja
{
	/**
	 * @var Array
	 */
	protected $uprawnienia = array();

	
	/**
	 * @var Array
	 */
	protected $zapisaneUprawnienia = array();


	/**
	 * @var \Generic\Biblioteka\Szablon
	 */
	protected $szablon;


	protected function generujFormularz()
	{

		$this->formularz = new Formularz('', 'uprawnieniaEventow');

		foreach($this->uprawnienia as $szablonPlik => $szablonNazwa)
		{
			$wartosc = (in_array($szablonPlik, $this->zapisaneUprawnienia)) ? 1 : 0;
			$this->formularz->input(new Input\Checkbox($szablonPlik, $szablonNazwa['nazwa'], array(
				  'wartosc' => $wartosc,
				  'atrybuty' => array('class' => $szablonPlik),
			  )));
			$this->formularz->$szablonPlik->dodajFiltr('intval');
		}
			 

		$this->formularz->stopka(new Input\Submit('zapisz', '', array(
			'wartosc' => $this->tlumaczenia['etykieta_input_zapisz']
		)));
		$this->formularz->stopka(new Input\Button('wstecz', '', array(
			'wartosc' => $this->tlumaczenia['etykieta_input_wstecz'],
			'atrybuty' => array('onclick' => 'window.location = \'' . $this->urlPowrotny . '\'' )
		)));

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * @return \Generic\Formularz\Uprawnienie\Administracyjne
	 */
	public function ustawUprawnienia(Array $uprawnienia)
	{
		$this->uprawnienia = $uprawnienia;

		return $this;
	}


	/**
	 * @return \Generic\Formularz\Uprawnienie\Administracyjne
	 */
	public function ustawZapisaneUprawnienia(Array $uprawnienia)
	{
		$this->zapisaneUprawnienia = $uprawnienia;

		return $this;
	}


	/**
	 * @return \Generic\Formularz\Uprawnienie\Administracyjne
	 */
	public function ustawSzablon(\Generic\Biblioteka\Szablon $szablon)
	{
		$this->szablon = $szablon;

		return $this;
	}
}