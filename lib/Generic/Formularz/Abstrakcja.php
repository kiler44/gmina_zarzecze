<?php
namespace Generic\Formularz;
use Generic\Biblioteka\Konfiguracja;


abstract class Abstrakcja implements Konfiguracja\Interfejs
{
	/**
	 * @var Array
	 */
	protected $konfiguracja = array();


	/**
	 * @var Array
	 */
	protected $tlumaczenia = array();


	/**
	 * @var Array
	 */
	protected $uprawnienia = array();


	/**
	 * @var \Generic\Biblioteka\Formularz\Automat
	 */
	protected $formularz;


	/**
	 * @var \Generic\Biblioteka\ObiektDanych
	 */
	protected $obiekt;

	/**
	 * @var \Generic\Model\Kategoria\Obiekt
	 */
	protected $kategoriaLinkow;

	/**
	 * @var string
	 */
	protected $urlPowrotny = '';


	protected abstract function generujFormularz();


	/**
	 * @return \Generic\Formularz\Abstrakcja
	 */
	protected function generujFormularzJedenRaz()
	{
		if ( ! ($this->formularz instanceof \Generic\Biblioteka\Formularz))
		{
			$this->generujFormularz();
		}

		return $this;
	}

	/**
	 * return \Generic\Biblioteka\Formularz
	 */
	public function zwrocFormularz()
	{
		$this->generujFormularzJedenRaz();

		return $this->formularz;
	}



	public function wypelniony()
	{
		$this->generujFormularzJedenRaz();

		return $this->formularz->wypelniony();
	}


	public function danePoprawne()
	{
		$this->generujFormularzJedenRaz();

		return $this->formularz->danePoprawne();
	}

	/**
	 * @return \Generic\Formularz\Abstrakcja
	 */
	public function ustawObiekt($obiekt)
	{
		$this->obiekt = $obiekt;

		return $this;
	}


	public function pobierzWartosci()
	{
		$this->generujFormularzJedenRaz();

		return $this->formularz->pobierzWartosci();
	}


	public function pobierzZmienioneWartosci()
	{
		$this->generujFormularzJedenRaz();

		return $this->formularz->pobierzZmienioneWartosci();
	}


	/**
	 * @return \Generic\Formularz\Abstrakcja
	 */
	public function ustawWartosciDomyslneObiektu()
	{
		foreach ($this->formularz as $nazwaPola => $input)
		{
			$input->ustawWartosc($this->obiekt->$nazwaPola);
		}

		return $this;
	}


	/**
	 * @return \Generic\Formularz\Abstrakcja
	 */
	public function ustawKategorieLinkow($kategoria)
	{
		$this->kategoriaLinkow = $kategoria;

		return $this;
	}


	/**
	 * @return \Generic\Formularz\Abstrakcja
	 */
	public function ustawWartosciDomyslne(Array $wartosciDomyslne)
	{
		foreach ($this->formularz as $nazwaPola => $input)
		{
			$input->ustawWartosc($wartosciDomyslne[$nazwaPola]);
		}

		return $this;
	}


	/**
	 * Zwraca treść html formularza
	 *
	 * @param string $plikSzablonu plik szablonu
	 *
	 * @return string
	 */
	public function html($szablon = '', $szablonTresc = false)
	{
		$this->generujFormularzJedenRaz();

		return $this->formularz->html($szablon, $szablonTresc);
	}


	/**
	 * @return \Generic\Formularz\BlokOpisowy\Edycja
	 */
	public function ustawUrlPowrotny($url)
	{
		$this->urlPowrotny = $url;

		return $this;
	}


	/**
	 * @return String
	 */
	public function pobierzIdentyfikatorFormularza()
	{
		return $this->formularz->pobierzIdentyfikatorFormularza();
	}


	/**
	 * Sprawdza czy dane w formularzu zostały zmienione
	 *
	 * @return boolean
	 */
	function zmieniony()
	{
		return $this->formularz->zmieniony();
	}




	/**
	 * Implementacja interfejsu Konfiguracja_Interfejs
	 */

	/**
	 * Zwraca tablice z konfiguracja dla formularza.
	 *
	 * @return array
	 */
	public function pobierzKonfiguracje()
	{
		return $this->konfiguracja;
	}



	/**
	 * Ustawia nowa konfiguracje dla formularza.
	 *
	 * @param array $konfiguracja Tablica z konfiguracja dla formularza.
	 *
	 * @return \Generic\Biblioteka\Formularz
	 */
	public function ustawKonfiguracje($konfiguracja)
	{
		$this->konfiguracja = array_merge($this->konfiguracja, $konfiguracja);

		return $this;
	}

	/**
	 * Implementacja interfejsu Tlumaczenia_Interfejs
	 */

	/**
	 * Zwraca tablice z tlumaczeniami dla formularza.
	 *
	 * @return array
	 */
	public function pobierzTlumaczenia()
	{
		return $this->tlumaczenia;
	}



	/**
	 * Ustawia nowe tlumaczeniami dla formularza.
	 *
	 * @param array $tlumaczenia Tablica z tlumaczeniami dla formularza.
	 */
	public function ustawTlumaczenia($tlumaczenia = array())
	{
		$this->tlumaczenia = array_merge($this->tlumaczenia, $tlumaczenia);

		return $this;
	}


	/**
	 * @return \Generic\Formularz\Uzytkownik\EdycjaAdmin
	 */
	public function ustawUprawnienia(Array $uprawnienia)
	{
		$this->uprawnienia = $uprawnienia;

		return $this;
	}
}
