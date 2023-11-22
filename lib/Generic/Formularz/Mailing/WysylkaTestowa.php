<?php
namespace Generic\Formularz\Mailing;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;

class WysylkaTestowa extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'email_testowy');
		$this->formularz->otworzZakladke('dane_email');

		$this->formularz->input(new Input\Text('odNazwa'));
		$this->formularz->odNazwa->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\Text('odEmail'));
		$this->formularz->odEmail->dodajFiltr('strip_tags', 'filtr_xss', 'trim');
		$this->formularz->odEmail->dodajWalidator(new Walidator\Email);

		$this->formularz->input(new Input\Text('doNazwa'));
		$this->formularz->doNazwa->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\Text('doEmail'));
		$this->formularz->doEmail->dodajFiltr('strip_tags', 'filtr_xss', 'trim');
		$this->formularz->doEmail->dodajWalidator(new Walidator\Email);

		$this->formularz->input(new Input\Select('smtpDebug', array(
			'lista' => $this->tlumaczenia['smtpDebug']['wartosci'],
		)));

		$this->formularz->input(new Input\Text('tytul'));
		$this->formularz->tytul->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\TextArea('tresc'));
		$this->formularz->tresc->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\TextArea('trescHtml',  array(
			'ckeditor' => true
		)));
		$this->formularz->trescHtml->dodajFiltr('filtr_xss', 'trim');

		$this->formularz->zamknijZakladke('dane_email');

		foreach ($this->formularz as $pole => $input)
		{
			if (in_array($pole, $this->konfiguracja['wymaganePola']))
			{
				$this->formularz->$pole->wymagany = true;
				$this->formularz->$pole->dodajWalidator(new Walidator\NiePuste);
			}
		}

		$this->formularz->stopka(new Input\Submit('zapisz'));
		$this->formularz->stopka(new Input\Button('wstecz', array(
			'atrybuty' => array('onclick' => 'window.location = \'' . $this->urlPowrotny . '\'' )
		)));

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}
}