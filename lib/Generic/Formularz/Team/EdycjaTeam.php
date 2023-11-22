<?php
namespace Generic\Formularz\Team;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Router;

class EdycjaTeam extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{
		$this->formularz = new Formularz\Automat('', 'team_form');

		$this->formularz->wstawInputyObiektu($this->obiekt, array('!wszystkie', 'teamNumber', 'numberPlate', 'email', 'idUsers', 'idLeader', 'status'));
		
		$this->formularz->input('status')->ustawParametr('lista', $this->tlumaczenia['status']);
		$this->formularz->input(new Input\Select('bazaTeamu', array(
			'wartosc' => $this->obiekt->bazaTeamu,
			'lista' => $this->konfiguracja['bkt_bazy'],
		), $this->tlumaczenia['baza_teamu']));
		$this->formularz->stopka(new Input\Submit('zapisz'));
		$this->formularz->stopka(new Input\Button('wstecz', array(
			'atrybuty' => array('onclick' => 'window.location = \'' . $this->urlPowrotny . '\'' )
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