<?php
namespace Generic\Formularz\Notes;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Router;

class EdycjaNotes extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{
		$this->formularz = new Formularz\Automat('', 'notes_form');

		$this->formularz->wstawInputyObiektu($this->obiekt, array('!wszystkie', 'description'));
		
		$this->formularz->stopka(new Input\Submit('zapisz', array('atrybuty' => array('class' => 'btn btn-primary'))));
		$this->formularz->stopka(new Input\Button('wstecz', array(
			'atrybuty' => (Cms::inst()->usluga instanceof \Generic\Biblioteka\Usluga\Ajax) ? array('class' => 'btn') : array('onclick' => 'window.location = \'' . $this->urlPowrotny . '\'', 'class' => 'btn'),
		)));
		
		foreach ($this->formularz as $nazwaInputa => $input)
		{
			if (in_array($nazwaInputa, $this->konfiguracja['formularz.wymagane_pola']))
			{
				$this->formularz->$nazwaInputa->wymagany = true;
				$this->formularz->$nazwaInputa->dodajWalidator(new Walidator\NiePuste);
			}

			$wartosc = $input->pobierzWartoscPoczatkowa();
			if (!empty($wartosc)) continue;
			$this->formularz->$nazwaInputa->ustawWartosc($this->obiekt->$nazwaInputa);
		}

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
		
	}
}