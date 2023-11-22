<?php
namespace Generic\Formularz\FormularzKontaktowy;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Walidator;

class TematEdycja extends \Generic\Formularz\Abstrakcja
{

	/**
	 * @var array
	 */
	protected $listaPol;

	
	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'tematyFormularz');
		$this->formularz->otworzRegion('konfiguracja', '');

		$this->formularz->input(new Input\Text('temat', array(
			'wymagany' => true,
			'atrybuty' => array('maxlength' => 255),
			'wartosc' => $this->obiekt->temat,
		)));
		$this->formularz->temat->dodajWalidator(new Walidator\NiePuste);
		$this->formularz->temat->dodajFiltr('trim','strip_tags');

		$this->formularz->input(new Input\Lista('email', array(
			'wartosc' => (count(unserialize($this->obiekt->email)) > 0) ? unserialize($this->obiekt->email) : array(''),
			'dodawanie_wierszy' => true,
		)));
		$this->formularz->email->dodajWalidator(new Walidator\Email());

		$this->formularz->input(new Input\Lista('emailDw', array(
			'wartosc' => (count(unserialize($this->obiekt->emailDw)) > 0) ? unserialize($this->obiekt->emailDw) : array(''),
			'dodawanie_wierszy' => true,
		)));
		$this->formularz->emailDw->dodajWalidator(new Walidator\Email());

		$this->formularz->zamknijRegion('konfiguracja');
		$this->formularz->otworzRegion('pola', '');

		foreach ($this->listaPol as $nazwa => $pole)
		{
			$wartosc = (isset($this->konfiguracja[$nazwa])) ? $this->konfiguracja[$nazwa] : 0;

			$this->formularz->input(new Input\Radio('pole_'.$nazwa, '', array(
				'lista' => array(
					$this->tlumaczenia['etykieta_brak'],
					$this->tlumaczenia['etykieta_pokaz'],
					$this->tlumaczenia['etykieta_wymagane'],
				),
				'wartosc' => $wartosc,
				'inline' => true,
			)));
		}

		$this->formularz->zamknijRegion('pola');

		$this->formularz->stopka(new Input\Submit('zapisz', '', array(
			'wartosc' => $this->tlumaczenia['etykieta_zapisz'],
		)));
		$this->formularz->stopka(new Input\Button('wstecz', '', array(
			'wartosc' => $this->tlumaczenia['etykieta_wstecz'],
			'atrybuty' => array('onclick' => 'window.location = \''.Router::urlAdmin($this->kategoriaLinkow, 'konfiguruj').'\'' ),
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