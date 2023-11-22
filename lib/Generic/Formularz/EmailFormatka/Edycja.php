<?php
namespace Generic\Formularz\EmailFormatka;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Router;

class Edycja extends \Generic\Formularz\Abstrakcja
{
	/**
	 * @var string;
	 */
	protected $urlZalaczniki;


	/**
	 * @var string;
	 */
	protected $urlUsun;


	/**
	 * @var array
	 */
	protected $listaSzablonow;


	/**
	 * @var int;
	 */
	protected $iloscZalacznikow;


	/**
	 * @var array
	 */
	protected $wymaganePola;


	/**
	 * @var array
	 */
	protected $odbiorcy;


	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'formatka_formularz');
		$this->formularz->otworzZakladke('dane_podstawowe');

			$this->formularz->input(new Input\Text('tytul', array(
				'atrybuty' => array('maxlength' => '100', 'class' => 'sredniePole')
			)))
				->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

			$this->formularz->input(new Input\TextArea('opis', array(
				'atrybuty' => array('maxlength' => '500', 'class' => 'sredniePole')
			)))
				->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

			$this->formularz->input(new Input\Select('kategoria', array(
				'lista' => $this->tlumaczenia['formatka.kategorie'],
				'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
			)));

			$this->formularz->input(new Input\Select('typWysylania', array(
				'lista' => $this->tlumaczenia['formatka.typy_wysylania'],
			)));

		$this->formularz->zamknijZakladke('dane_podstawowe');

		$this->formularz->otworzZakladke('tresc_wiadomosci');

			$this->formularz->input(new Input\Text('emailTytul', array(
				'atrybuty' => array('maxlength' => '300', 'class' => 'dlugiePole')
			)))
				->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

			$this->formularz->input(new Input\TextArea('emailTrescHtml', array(
				'atrybuty' => array('class' => 'dlugiePole', 'rows' => 20),
			)))
				->dodajFiltr('filtr_xss');

			$this->formularz->input(new Input\TextArea('emailTrescTxt', array(
				'atrybuty' => array('class' => 'dlugiePole', 'rows' => 20),
			)))
				->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

			$this->formularz->input(new Input\Text('emailNadawcaEmail', array(
				'atrybuty' => array('maxlength' => '100', 'class' => 'sredniePole'),
			)))
				->dodajFiltr('strip_tags', 'filtr_xss', 'trim')
				->dodajWalidator(new Walidator\Email());

			$this->formularz->input(new Input\Text('emailNadawcaNazwa', array(
				'atrybuty' => array('maxlength' => '100', 'class' => 'sredniePole'),
			)))
				->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

			$this->formularz->input(new Input\Text('emailPotwierdzenieEmail', array(
				'atrybuty' => array('maxlength' => '100', 'class' => 'sredniePole'),
			)))
				->dodajFiltr('strip_tags', 'filtr_xss', 'trim')
				->dodajWalidator(new Walidator\Email());

			$nr = 0;
			while ($nr < $this->iloscZalacznikow)
			{
				$this->formularz->input(new Input\Plik('emailZalaczniki'.$nr, array(
						'sciezka_plikow' => $this->urlZalaczniki,
						'link_usun' => $this->urlUsun,
					),
					$this->tlumaczenia['emailZalaczniki']['etykieta'],
					$this->tlumaczenia['emailZalaczniki']['opis']
				));
				$nr++;
			}

			if ($this->listaSzablonow)
			{
				$this->formularz->input(new Input\Select('emailSzablon', array(
					'lista' => $this->listaSzablonow,
					'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
				)));
			}
			else
			{
				$this->komunikat($this->tlumaczenia['info_brak_aktywnych_szablonow_email'], 'info');
			}

		$this->formularz->zamknijZakladke('tresc_wiadomosci');

		$this->formularz->otworzZakladke('odbiorcy_wiadomosci');

			$this->formularz->input(new Input\AutocompleteLista('emailOdbiorcy', array(
				'dodawanie_wierszy' => true,
				'lista' => $this->odbiorcy,
			)))
				->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

			$this->formularz->input(new Input\AutocompleteLista('emailKopie', array(
				'dodawanie_wierszy' => true,
				'lista' => $this->odbiorcy,
			)))
				->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

			$this->formularz->input(new Input\AutocompleteLista('emailKopieUkryte', array(
				'dodawanie_wierszy' => true,
				'lista' => $this->odbiorcy,
			)))
				->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

			$this->formularz->input(new Input\AutocompleteLista('emailOdpowiedzi', array(
				'dodawanie_wierszy' => true,
				'lista' => $this->odbiorcy,
			)))
				->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->zamknijZakladke('odbiorcy_wiadomosci');


		$zdarzenie = Zadanie::pobierz('zdarzenie', 'strip_tags', 'filtr_xss', 'trim');

		$przyciskPodpowiedz = '';
		if ($zdarzenie != '' && $obiekty = $this->pobierzObiektyZdarzenia($zdarzenie))
		{
			$przyciskPodpowiedz = new Input\Button('podpowiedz', array('atrybuty' => array('onclick' => '$(\'#podpowiedzTresc\').dialog(\'open\'); return false;'),));
			$przyciskPodpowiedz->ustawWartosc($this->tlumaczenia['podpowiedz.wartosc']);
			$przyciskPodpowiedz = $przyciskPodpowiedz->pobierzHtml() . ' ';
			$mapa = array('obiekt' => '');
			foreach ($obiekty as $obiekt)
			{
				array_walk($obiekt['etykiety'], function( & $val){ $val = array('etykieta' => $val);});
				array_walk($obiekt['propercje'], function( & $val){ $val = array('propercja' => $val);});
				$mapa['obiekt'][] = array(
					'etykiety' => $obiekt['etykiety'],
					'propercje' => $obiekt['propercje'],
				);
			}

			$this->formularz->poleHtml('podpowiedzTresc', $this->szablon->parsujBlok('/podpowiedz', $mapa));
		}


		$this->formularz->stopka(new Input\Submit('zapisz'));
		$this->formularz->stopka(new Input\Button('wstecz', array(
			'atrybuty' => array('onclick' => 'window.location = \''.Router::urlAdmin('EmailZarzadzanie').'\'' )
		)));

		foreach ($this->obiekt->emailZalaczniki as $nr => $plik)
		{
			$nazwaPola = 'emailZalaczniki'.$nr;
			if (isset($this->formularz->$nazwaPola))
				$this->formularz->input($nazwaPola)->ustawWartosc(array('name' => trim($plik)));
		}
		foreach ($this->formularz as $nazwaPola => $input)
		{
			if (in_array($nazwaPola, $this->wymaganePola))
			{
				$this->formularz->$nazwaPola->wymagany = true;
				$this->formularz->$nazwaPola->dodajWalidator(new Walidator\NiePuste);
			}

			if (strpos($nazwaPola, 'emailZalaczniki') !== false) continue;

			$this->formularz->$nazwaPola->ustawWartosc($this->obiekt->$nazwaPola);
		}

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);

		$przyciskPodglad = new Input\Button('podglad', array('atrybuty' => array('onclick' => 'podgladTresciHtml(this);'),));
		$przyciskPodglad->ustawWartosc($this->tlumaczenia['formularzSzablon.podgladHtml.wartosc']);
		$przyciskPodglad = $przyciskPodglad->pobierzHtml();

		$this->formularz->input('emailTrescHtml')->ustawOpis(
			$this->formularz->input('emailTrescHtml')->pobierzOpis() . $przyciskPodpowiedz . $przyciskPodglad
		);
	}

	/**
	 * @return \Generic\Formularz\EmailFormatka\Edycja
	 */
	public function ustawUrlUsun($urlUsun)
	{
		$this->urlUsun = $urlUsun;

		return $this;
	}

	/**
	 * @return \Generic\Formularz\EmailFormatka\Edycja
	 */
	public function ustawUrlZalaczniki($urlZalaczniki)
	{
		$this->urlZalaczniki = $urlZalaczniki;

		return $this;
	}

	/**
	 * @return \Generic\Formularz\EmailFormatka\Edycja
	 */
	public function ustawListaSzablonow(Array $listaSzablonow)
	{
		$this->listaSzablonow = $listaSzablonow;

		return $this;
	}

	/**
	 * @return \Generic\Formularz\EmailFormatka\Edycja
	 */
	public function ustawIloscZalacznikow($iloscZalacznikow)
	{
		$this->iloscZalacznikow = $iloscZalacznikow;

		return $this;
	}

	/**
	 * @return \Generic\Formularz\EmailFormatka\Edycja
	 */
	public function ustawWymaganePola(Array $wymaganePola)
	{
		$this->wymaganePola = $wymaganePola;

		return $this;
	}

	/**
	 * @return \Generic\Formularz\EmailFormatka\Edycja
	 */
	public function ustawOdbiorcy(Array $odbiorcy)
	{
		$this->odbiorcy = $odbiorcy;

		return $this;
	}
}