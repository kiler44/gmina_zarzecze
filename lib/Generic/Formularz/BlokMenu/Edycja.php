<?php
namespace Generic\Formularz\BlokMenu;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Cms;

class Edycja extends \Generic\Formularz\Abstrakcja
{

	protected $wierszeKonfiguracji = array();

	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'edycjaBlokuOpisowego');

		$this->formularz->input(new Input\Select('typ_menu', $this->tlumaczenia['etykieta_input_typ_menu'], array(
			'wymagany' => true,
			'wartosc' => $this->wierszeKonfiguracji['typ_menu']->wartosc,
			'lista' => $this->tlumaczenia['typy_menu'],
			'atrybuty' => array(
				'onchange' => 'window.location = \''.Router::urlAdmin($this->kategoriaLinkow, 'index').'&typ_menu=\' + this.options[selectedIndex].value; return false'),
		),$this->tlumaczenia['opis_input_typ_menu']));
		$this->formularz->typ_menu->dodajWalidator(new Walidator\DozwoloneWartosci(array_keys($this->tlumaczenia['typy_menu'])));

		$typ = $this->formularz->typ_menu->pobierzWartosc();

		if ($typ == 'gotowe_menu')
		{
			$kategorie =  Cms::inst()->dane()->Kategoria()->pobierzDoPoziomu(1);
			foreach ($kategorie as $kategoria)
			{
				if (in_array($kategoria->typ, array('glowna','menu')))
				{
					$lista[$kategoria->id] = $kategoria->nazwa;
				}
			}
		}
		elseif ($typ == 'wybrana_rodzicem')
		{
			$kategorie = Cms::inst()->dane()->Kategoria()->pobierzWszystko();
			foreach ($kategorie as $kategoria)
			{
				if ($kategoria->poziom < 1) continue;
				if (in_array($kategoria->typ, array('glowna','menu')))
				{
					$grupa = $kategoria->nazwa;
					$lista[$grupa] = array();
				}
				else
				{
					$lista[$grupa][$kategoria->id] = str_repeat('&nbsp;&nbsp;&nbsp;', $kategoria->poziom - 2) . $kategoria->nazwa;
				}
			}
		}

		if ($typ == 'gotowe_menu' || $typ == 'wybrana_rodzicem')
		{
			$this->formularz->input(new Input\Select('kategoria_startowa', $this->tlumaczenia['etykieta_input_kategoria_startowa'], array(
				'wymagany' => true,
				'lista' => $lista,
				'wartosc' => $this->wierszeKonfiguracji['kategoria_startowa']->wartosc,
				'wybierz' => $this->tlumaczenia['etykieta_select_wybierz']
			), $this->tlumaczenia['opis_input_kategoria_startowa']));
			$this->formularz->kategoria_startowa->dodajFiltr('intval', 'abs');
			$this->formularz->kategoria_startowa->dodajWalidator(new Walidator\NiePuste());
			$this->formularz->kategoria_startowa->dodajWalidator(new Walidator\WiekszeOd(1));
		}

		if ($typ == 'biezaca_dzieckiem')
		{
			$this->formularz->input(new Input\Text('minimalny_poziom', $this->tlumaczenia['etykieta_input_minimalny_poziom'], array(
				'wartosc' => $this->wierszeKonfiguracji['minimalny_poziom']->wartosc,
			), $this->tlumaczenia['opis_input_minimalny_poziom']));
			$this->formularz->minimalny_poziom->dodajWalidator(new Walidator\WiekszeOd(0));
			$this->formularz->minimalny_poziom->dodajFiltr('intval', 'abs');
		}

		$this->formularz->input(new Input\Text('maksymalny_poziom', $this->tlumaczenia['etykieta_input_maksymalny_poziom'], array(
			'wartosc' => $this->wierszeKonfiguracji['maksymalny_poziom']->wartosc,
		), $this->tlumaczenia['opis_input_maksymalny_poziom']));
		$this->formularz->maksymalny_poziom->dodajWalidator(new Walidator\WiekszeOd(0));
		$this->formularz->maksymalny_poziom->dodajFiltr('intval', 'abs');

		$this->formularz->stopka(new Input\Submit('zapisz', '', array(
			'wartosc' => $this->tlumaczenia['etykieta_zapisz']
		)));
		$this->formularz->stopka(new Input\Button('wstecz', '', array(
			'wartosc' => $this->tlumaczenia['etykieta_wstecz'],
			'atrybuty' => array('onclick' => 'window.location = \'' . $this->urlPowrotny . '\'' )
		)));

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * @return \Generic\Formularz\BlokMenu\Edycja
	 */
	public function ustawWierszeKonfiguracji(Array $wiersze)
	{
		$this->wierszeKonfiguracji = $wiersze;

		return $this;
	}
}