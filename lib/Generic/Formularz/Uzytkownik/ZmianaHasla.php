<?php
namespace Generic\Formularz\Uzytkownik;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;

class ZmianaHasla extends \Generic\Formularz\Abstrakcja
{
	protected $token;

	
	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'zmiana_hasla');

		if ($this->token == '')
		{
			$this->formularz->input(new Input\Password('haslo'));
			$this->formularz->haslo->dodajFiltr('md5');
			$this->formularz->haslo->dodajWalidator(new Walidator\Rowne($this->obiekt->haslo, true));
		}
		else
		{
			$this->formularz->input(new Input\Hidden('token', $this->token));
		}

		$this->formularz->input(new Input\Password('nowe_haslo', array('atrybuty' => array('autocomplete' => 'off'))));
		$this->formularz->nowe_haslo->dodajWalidator(new Walidator\WyrazenieRegularne($this->konfiguracja['zmienHaslo.walidacja_hasla']));

		$this->formularz->input(new Input\Password('nowe_haslo_powtorz', array('atrybuty' => array('autocomplete' => 'off'))));

		$this->formularz->stopka(new Input\Submit('potwierdz'));

		foreach ($this->formularz as $nazwaInputa => $input)
		{
			$this->formularz->$nazwaInputa->wymagany = true;
			$this->formularz->$nazwaInputa->dodajWalidator(new Walidator\NiePuste);
		}

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * @return \Generic\Formularz\Uzytkownik\ZmianaHasla
	 */
	public function ustawToken($token)
	{
		$this->token = $token;

		return $this;
	}

}