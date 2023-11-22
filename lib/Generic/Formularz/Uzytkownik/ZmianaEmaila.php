<?php
namespace Generic\Formularz\Uzytkownik;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;

class ZmianaEmaila extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'zmiana_email');

		$this->formularz->input(new Input\Password('haslo'));
		$this->formularz->haslo->dodajFiltr('md5');
		$this->formularz->haslo->dodajWalidator(new Walidator\Rowne($this->obiekt->haslo, true));

		$this->formularz->input(new Input\Text('email'));
		$this->formularz->email->dodajFiltr('trim');
		$this->formularz->email->dodajWalidator(new Walidator\Email(true));

		$this->formularz->stopka(new Input\Submit('potwierdz'));

		foreach ($this->formularz as $nazwaInputa => $input)
		{
			$this->formularz->$nazwaInputa->wymagany = true;
			$this->formularz->$nazwaInputa->dodajWalidator(new Walidator\NiePuste);
		}

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}

}