<?php
namespace Generic\Formularz\FormularzKontaktowy;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Cms;

class Podglad extends \Generic\Formularz\Abstrakcja
{

	/**
	 * @var array
	 */
	protected $listaPol;

	
	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'podgladWiadomosciFormularz');

		$tematy_mapper = Cms::inst()->dane()->FormularzKontaktowyTemat();
		$temat = $tematy_mapper->pobierzPoId($this->obiekt->idTematu);
		$konfiguracja = unserialize($temat->konfiguracja);

		foreach ($this->listaPol as $nazwa => $pole)
		{
			if ($nazwa == 'daneOsobowe') continue;
			if (isset($konfiguracja[$nazwa]) && $this->obiekt->$nazwa != '')
			{
				$this->formularz->input(new Input\Html('pole_'.$nazwa, '', array(
					'wartosc' => ($nazwa == 'tresc') ? nl2br($this->obiekt->$nazwa) : $this->obiekt->$nazwa,
				)));
			}
		}

		$this->formularz->stopka(new Input\Button('wstecz', '', array(
			'wartosc' => $this->tlumaczenia['etykieta_wstecz'],
			'atrybuty' => array('onclick' => 'window.location = \''.Router::urlAdmin($this->kategoriaLinkow, 'index').'\'' )
		)));

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * @return \Generic\Formularz\FormularzKontaktowy\Podglad
	 */
	public function ustawListaPol(Array $listaPol)
	{
		$this->listaPol = $listaPol;

		return $this;
	}

}