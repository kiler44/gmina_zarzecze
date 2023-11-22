<?php
namespace Generic\Formularz\EmailFormatka;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Router;

class WpisKolejki extends \Generic\Formularz\Abstrakcja
{


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

			$this->formularz->input(new Input\Html('bledyLicznik'));

			$this->formularz->input(new Input\Html('bledyOpis'));

			$this->formularz->input(new Input\Html('typWysylania'));

			$this->formularz->input(new Input\Html('idFormatki'));

		$this->formularz->zamknijZakladke('dane_podstawowe');

		$this->formularz->otworzZakladke('tresc_wiadomosci');

			$this->formularz->input(new Input\Text('emailTytul', array(
				'atrybuty' => array('maxlength' => '200', 'class' => 'dlugiePole')
			)))
				->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

			$this->formularz->input(new Input\TextArea('emailTrescHtml', array(
				'atrybuty' => array('class' => 'dlugiePole', 'rows' => 20),
			)))
				->dodajFiltr('filtr_xss', 'trim');

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

			$this->formularz->input(new Input\Lista('emailZalaczniki'));

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

		$this->formularz->stopka(new Input\Button('wstecz', array(
			'atrybuty' => array('onclick' => 'window.location = \''.Router::urlAdmin('EmailZarzadzanie', 'kolejka').'\'' )
		)));
		
		if (! $this->konfiguracja['nie_wysylaj'])
			$this->formularz->stopka(new Input\Submit('wyslijPonownieWpis'));
		
		$this->formularz->stopka(new Input\Submit('usunWpis'));


		foreach ($this->formularz as $nazwaPola => $input)
		{
			if (in_array($nazwaPola, $this->wymaganePola))
			{
				$this->formularz->$nazwaPola->wymagany = true;
				$this->formularz->$nazwaPola->dodajWalidator(new Walidator\NiePuste);
			}
			$wartosc = $this->obiekt->$nazwaPola;

			if (in_array($nazwaPola, array('emailOdbiorcy','emailKopie','emailKopieUkryte','emailOdpowiedzi')))
			{
				foreach ($wartosc as $k => $v) if ( ! is_int($k)) $wartosc[$k] = $k;
			}
			if ($nazwaPola == 'typWysylania')
			{
				$wartosc = $this->tlumaczenia['typy_wysylania'][$wartosc];
			}
			if ($nazwaPola == 'idFormatki')
			{
				$formatka = $this->obiekt->formatka;
				if ($formatka instanceof EmailFormatka\Obiekt)
				{
					$wartosc = $this->szablon->parsujBlok('/podglad/formatka', array(
						'tytul' => $formatka->tytul,
						'opis' => $formatka->opis,
						'link_formatka' => Router::urlAdmin('EmailZarzadzanie','edytuj', array('id' => $formatka->id)),
					));
				}
				else
				{
					$wartosc = $this->tlumaczenia['brak_formatki'];
				}
			}
			if ($nazwaPola == 'bledyOpis')
			{
				$wartosc = nl2br($wartosc);
			}
			$this->formularz->input($nazwaPola)->ustawWartosc($wartosc);
		}

		$podgladHtml = new Input\Button('podglad', array('atrybuty' => array('onclick' => 'podgladTresciHtml();'),));
		$podgladHtml->ustawWartosc($this->tlumaczenia['podgladHtml']['wartosc']);
		$this->formularz->input('emailTrescHtml')->ustawOpis(
			$this->formularz->input('emailTrescHtml')->pobierzOpis() . $podgladHtml->pobierzHtml()
		);

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}

	/**
	 * @return \Generic\Formularz\EmailFormatka\WpisKolejki
	 */
	public function ustawWymaganePola(Array $wymaganePola)
	{
		$this->wymaganePola = $wymaganePola;

		return $this;
	}

	/**
	 * @return \Generic\Formularz\EmailFormatka\WpisKolejki
	 */
	public function ustawOdbiorcy(Array $odbiorcy)
	{
		$this->odbiorcy = $odbiorcy;

		return $this;
	}
}