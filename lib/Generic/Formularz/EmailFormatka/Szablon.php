<?php
namespace Generic\Formularz\EmailFormatka;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;

class Szablon extends \Generic\Formularz\Abstrakcja
{
	/**
	 * @var int
	 */
	protected $ileFormatekZawieraSzablon = 0;

	
	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'szablon_formularz');

		$this->formularz->input(new Input\Text('nazwa', array(
			'atrybuty' => array('maxlength' => '100', 'class' => 'sredniePole')
		)))
			->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\TextArea('trescHtml', array(
			'atrybuty' => array('maxlength' => '100000', 'class' => 'dlugiePole', 'rows' => 20),
			'ckeditor' => true,
		)))
			->dodajFiltr('filtr_xss')
			->dodajWalidator(new Walidator\ZawieraTekst('{TRESC}'));

		$this->formularz->input(new Input\TextArea('trescTxt', array(
			'atrybuty' => array('maxlength' => '100000', 'class' => 'dlugiePole', 'rows' => 20),
		)))
			->dodajFiltr('strip_tags', 'filtr_xss', 'trim')
			->dodajWalidator(new Walidator\ZawieraTekst('{TRESC}'));

		$this->formularz->input(new Input\Checkbox('aktywny'));

		$this->formularz->stopka(new Input\Submit('zapisz'));

		$this->formularz->stopka(new Input\Button('wstecz', array(
			'atrybuty' => array('onclick' => 'window.location = \'' . $this->urlPowrotny . '\'' )
		)));

		foreach ($this->formularz as $nazwaPola => $input)
		{
			if (in_array($nazwaPola, $this->konfiguracja['wymagane_pola']))
			{
				$this->formularz->$nazwaPola->wymagany = true;
				$this->formularz->$nazwaPola->dodajWalidator(new Walidator\NiePuste);
			}

			$this->formularz->$nazwaPola->ustawWartosc($this->obiekt->$nazwaPola);
		}

		if ($this->ileFormatekZawieraSzablon > 0)
		{
			$this->formularz->input('aktywny')->dodajAtrybuty(array('disabled' => 'disabled'))->ustawWartosc(1);
		}

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * @return \Generic\Formularz\EmailFormatka\Szablon
	 */
	public function ustawIleFormatekZawieraSzablon($ile)
	{
		$this->ileFormatekZawieraSzablon = $ile;

		return $this;
	}
}