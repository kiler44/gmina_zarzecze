<?php
namespace Generic\Formularz\ZadanieCykliczne;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Router;

class Edycja extends \Generic\Formularz\Abstrakcja
{
	/**
	 * @var string
	 */
	protected $nazwaZadania = '';


	/**
	 * @var Array
	 */
	protected $listaZadan = array();


	protected function generujFormularz()
	{
		$cms = Cms::inst();

		$this->formularz = new Formularz('', 'zadanie_cykliczne');

		if ($this->obiekt->kodZadania == '')
		{
			$this->formularz->input(new Input\Select('zadanie', array(
				'lista' => $this->listaZadan,
				'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
				'wartosc' => $this->obiekt->kodZadania,
			)));
		}
		else
		{
			$this->formularz->input(new Input\Html('zadanie', array(
				'wartosc' => $this->nazwaZadania,
			)));
			// konfiguracja zadan modulow systemowych
			if ($this->obiekt->idKategorii == 1)
			{
				$this->formularz->input(new Input\Button('konfiguracja', array(
					'atrybuty' => array('onclick' => 'window.location = \''.Router::urlAdmin('KonfiguracjaSystemu', 'edytujAdministracyjny', array('kod' => $this->obiekt->kodModulu)).'#Cron\'' )
				)));
			}
			// konfiguracja zadan modulow zwyklych
			elseif ($this->obiekt->idKategorii > 1)
			{
				$this->formularz->input(new Input\Button('konfiguracja', array(
					'atrybuty' => array('onclick' => 'window.location = \''.Router::urlAdmin('KonfiguracjaSystemu', 'edytujKategorie', array('id' => $this->obiekt->idKategorii)).'#Cron\'' )
				)));
			}
		}

		$this->formularz->input(new Input\SelectCron('zapisCron', array(
			'wartosc' => array(
				'minuty' => $this->obiekt->minuty,
				'godziny' => $this->obiekt->godziny,
				'dni' => $this->obiekt->dni,
				'miesiace' => $this->obiekt->miesiace,
				'dni_tygodnia' => $this->obiekt->dniTygodnia,
			),
		)));

		$this->formularz->input(new Input\DataCzasSelect('dataRozpoczecia', array(
			'wartosc' => $this->obiekt->dataRozpoczecia,
			'wybierz' => $this->tlumaczenia['etykieta_data_wybierz'],
			'datepicker' => true,
		)));
		$this->formularz->dataRozpoczecia->dodajWalidator(new Walidator\DataCzasIso);

		$this->formularz->input(new Input\DataCzasSelect('dataZakonczenia', array(
			'wartosc' => $this->obiekt->dataZakonczenia,
			'wybierz' => $this->tlumaczenia['etykieta_data_wybierz'],
			'datepicker' => true,
		)));
		$this->formularz->dataZakonczenia->dodajWalidator(new Walidator\DataCzasIso);


		$this->formularz->input(new Input\Checkbox('aktywne', array(
			'wartosc' => $this->obiekt->aktywne
		)));
		$this->formularz->aktywne->dodajFiltr('intval');

		if ($cms->profil()->maUprawnieniaDo('ZadaniaCykliczne_ustawWielokrotne'))
		{
			$this->formularz->input(new Input\Checkbox('dodawaneWielokrotnie', array(
				'wartosc' => $this->obiekt->dodawaneWielokrotnie,
			)));
			$this->formularz->dodawaneWielokrotnie->dodajFiltr('intval');
		}

		$this->formularz->input(new Input\TextArea('opisZadania', array(
			'wartosc' => $this->obiekt->opisZadania
		)));
		$this->formularz->opisZadania->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->stopka(new Input\Submit('zapisz'));
		$this->formularz->stopka(new Input\Button('wstecz', array(
			'atrybuty' => array('onclick' => 'window.location = \'' . $this->urlPowrotny . '\'' )
		)));

		foreach ($this->formularz as $nazwaInputa => $input)
		{
			if (in_array($nazwaInputa, $this->konfiguracja['wymagane_pola']))
			{
				$this->formularz->$nazwaInputa->wymagany = true;
				$this->formularz->$nazwaInputa->dodajWalidator(new Walidator\NiePuste);
			}
		}

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * @return \Generic\Formularz\ZadanieCykliczne\Edycja
	 */
	public function ustawNazwaZadania($nazwa)
	{
		$this->nazwaZadania = $nazwa;

		return $this;
	}


	/**
	 *@return \Generic\Formularz\ZadanieCykliczne\Edycja
	 */
	public function ustawListaZadan(Array $lista)
	{
		$this->listaZadan = $lista;

		return $this;
	}

}