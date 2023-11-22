<?php
namespace Generic\Formularz\Konfiguracja;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;

class ZmienneGlobalne extends \Generic\Formularz\Abstrakcja
{

	/**
	 * @var Array
	 */
	protected $zmienneSystemowe = array();


	/**
	 * @var Array
	 */
	protected $zmienneZarezerwowane = array();


	/**
	 * @var Array
	 */
	protected $zmienneGlobalne = array();


	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'zmienneGlobalne');

		if (is_array($this->zmienneSystemowe) && count($this->zmienneSystemowe) > 0)
		{
			if ( ! $this->moznaWykonacAkcje('opcjeSystemowe'))
			{
				$var_wynik = '';
				foreach ($this->zmienneSystemowe as $k => $w)
				{
					$var_wynik .= htmlspecialchars($k).' => '.htmlspecialchars($w).'<br />';
				}
				$this->formularz->input(new Input\Html('globalne_systemowe', $this->tlumaczenia['tablica_globalnych_systemowych'], array('wartosc' => $var_wynik), $this->tlumaczenia['opis_globalnych_zarezerwowanych']));
			}
			else
			{
				$this->formularz->input(new Input\Tablica('globalne_systemowe', $this->tlumaczenia['tablica_globalnych_systemowych'], array('dodawanie_wierszy' => false, 'blokowanie_kluczy' => true, 'wartosc' => $this->zmienneSystemowe), $this->tlumaczenia['opis_globalnych_zarezerwowanych']));
			}
		}

		if (is_array($this->zmienneZarezerwowane) && count($this->zmienneZarezerwowane) > 0)
		{
			$this->formularz->input(new Input\Tablica('globalne_zarezerwowane', $this->tlumaczenia['tablica_globalnych_zarezerwowanych'], array('dodawanie_wierszy' => false, 'blokowanie_kluczy' => true, 'wartosc' => $this->zmienneZarezerwowane), $this->tlumaczenia['opis_globalnych_zarezerwowanych']));
		}

		$this->formularz->input(new Input\Tablica('globalne', $this->tlumaczenia['tablica_globalnych'], array('dodawanie_wierszy' => true, 'blokowanie_kluczy' => false, 'wartosc' => $this->zmienneGlobalne), $this->tlumaczenia['opis_globalnych']));

		$this->formularz->stopka(new Input\Submit('zapisz', '', array(
			'wartosc' => $this->tlumaczenia['etykieta_zapisz']
		)));

		if ($this->urlPowrotny != '')
		{
			$this->formularz->stopka(new Input\Button('wstecz', '', array(
				'wartosc' => $this->tlumaczenia['etykieta_wstecz'],
				'atrybuty' => array('onclick' => 'window.location = \''.$this->urlPowrotny.'\'' )
			)));
		}

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * @return \Generic\Formularz\Konfiguracja\ZmienneGlobalne
	 */
	public function ustawZmienne(Array $systemowe = array(), Array $zarezerwowane = array(), Array $globalne = array())
	{
		$this->zmienneSystemowe = $systemowe;
		$this->zmienneZarezerwowane = $zarezerwowane;
		$this->zmienneGlobalne = $globalne;

		return $this;
	}

}