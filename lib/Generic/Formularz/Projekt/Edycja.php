<?php
namespace Generic\Formularz\Projekt;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Katalog;
use Generic\Model\DostepnyModul;

class Edycja extends \Generic\Formularz\Abstrakcja
{
	/**
	 * @var \Generic\Biblioteka\Szablon
	 */
	protected $szablon;


	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'projekt_formularz');

		$this->formularz->otworzZakladke('ogolne');

			if ($this->obiekt->id < 1)
			{
				$this->formularz->input(new Input\Text('kod', array(
					'wartosc' => '',
				)));
				$this->formularz->kod->dodajFiltr('strip_tags', 'filtr_xss', 'trim');
				$this->formularz->kod->dodajWalidator(new Walidator\WyrazenieRegularne('/^([a-z0-9_]{4,16})/'));
			}
			else
			{
				$this->formularz->input(new Input\Html('kod'));
			}

			$this->formularz->input(new Input\Text('domena'));
			$this->formularz->domena->dodajFiltr('strip_tags', 'filtr_xss', 'trim', 'strtolower');
			$this->formularz->domena->dodajWalidator(new Walidator\Domena());

			$this->formularz->input(new Input\Text('nazwa'));
			$this->formularz->nazwa->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

			if ($this->obiekt->id < 1)
			{
				$this->formularz->input(new Input\Html('szablon', array(
					'wartosc' => $this->konfiguracja['dodaj.nazwa_szablonu']
				)));
			}
			else
			{
				$szablony = new Katalog(CMS_KATALOG);
				$szablony = $szablony->pobierzZawartosc(1);
				$lista = array();
				foreach ($szablony as $nazwa => $typ)
				{
					if (is_array($typ) && strpos($nazwa, '.') === false && strpos($nazwa, SZABLON_SYSTEM) === false && strpos($nazwa, 'szablon_') !== false)
					{
						$lista[$nazwa] = $nazwa;
					}
				}
				$this->formularz->input(new Input\Select('szablon', array(
					'lista' => $lista,
				)));
			}

			$this->formularz->input(new Input\TextArea('opis'));

			$lista = array();
			if (is_array($this->obiekt->jezyki) && count($this->obiekt->jezyki) > 0)
			{
				foreach ($this->obiekt->jezyki as $jezyk)
				{
					$lista[$jezyk->kod] = $jezyk->nazwa;
				}
			}
			$this->formularz->input(new Input\Tablica('jezyki', array(
				'wartosc' => (count($lista) > 0) ? $lista : $this->konfiguracja['dodaj.jezyki'],
				'dodawanie_wierszy' => true,
			)));
			$this->formularz->jezyki->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

			$this->formularz->input(new Input\Text('domyslnyJezyk', array(
				'wartosc' => ($this->obiekt->id > 0) ? $this->obiekt->domyslnyJezyk : $this->konfiguracja['dodaj.domyslnyJezyk'],
				'atrybuty' => array('size' => '2', 'maxlength' => 2),
			)));
			$this->formularz->domyslnyJezyk->dodajFiltr('strip_tags', 'filtr_xss', 'trim', 'strtolower');

		$this->formularz->zamknijZakladke('ogolne');

		$this->formularz->otworzZakladke('moduly_zakladka');

			$mapper = DostepnyModul\Mapper::wywolaj();
			$bloki = array();
			$moduly = array();
			$rss = array();
			$cron = array();
			$api = array();
			
			foreach($mapper->pobierzDoPrzypisania(null, new DostepnyModul\Sorter('nazwa', 'asc')) as $modul)
			{

				if ($modul->typ == 'blok')
				{
					$bloki[] = new Input\Checkbox('modul_'.$modul->kod, $modul->nazwa, array(
						'wartosc' => ((in_array($modul->kod, $this->obiekt->powiazaneModulyHttp)) ? 1 : 0),
						'atrybuty' => (count($modul->wymagane) > 0) ? array('onclick' => "zaznaczInputy(this, '#modul_".implode(", #modul_",$modul->wymagane)."');") : array(),
					), $modul->opis);
				}
				else
				{
					$moduly[] = new Input\Checkbox('modul_'.$modul->kod, $modul->nazwa, array(
						'wartosc' => ((in_array($modul->kod, $this->obiekt->powiazaneModulyHttp)) ? 1 : 0),
						'atrybuty' => (count($modul->wymagane) > 0) ? array('onclick' => "zaznaczInputy(this, '#modul_".implode(", #modul_",$modul->wymagane)."');") : array(),
					), $modul->opis);

					if (in_array('Rss', $modul->uslugi))
					{
						$rss[] = new Input\Checkbox('rss_'.$modul->kod, $modul->nazwa, array(
							'wartosc' => ((in_array($modul->kod, $this->obiekt->powiazaneModulyRss)) ? 1 : 0),
						), $modul->opis);
					}
					if (in_array('Cron', $modul->uslugi))
					{
						$cron[] = new Input\Checkbox('cron_'.$modul->kod, $modul->nazwa, array(
							'wartosc' => ((in_array($modul->kod, $this->obiekt->powiazaneModulyCron)) ? 1 : 0),
						), $modul->opis);
					}
					if (in_array('Api', $modul->uslugi))
					{
						$api[] = new Input\Checkbox('api_'.$modul->kod, $modul->nazwa, array(
							'wartosc' => ((in_array($modul->kod, $this->obiekt->powiazaneModulyApi)) ? 1 : 0),
						), $modul->opis);
					}
				}
			}

			$zaznacz_linki = array(
				'etykieta_zaznacz_wiele' => $this->tlumaczenia['etykieta_zaznacz_wiele'],
				'etykieta_odznacz_wiele' => $this->tlumaczenia['etykieta_odznacz_wiele'],
				'etykieta_odwroc_zaznaczenie' => $this->tlumaczenia['etykieta_odwroc_zaznaczenie'],
			);

			$zaznacz_linki['region'] = 'moduly';
			$zaznacz_wiele = $this->szablon->parsujBlok('/zaznacz_wiele_link', $zaznacz_linki);

			$this->formularz->otworzRegion('moduly', $this->tlumaczenia['region_moduly'].$zaznacz_wiele);

			foreach ($moduly as $input)
			{
				$this->formularz->input($input);
			}

			$this->formularz->zamknijRegion('moduly');

			$zaznacz_linki['region'] = 'bloki';
			$zaznacz_wiele = $this->szablon->parsujBlok('/zaznacz_wiele_link', $zaznacz_linki);

			$this->formularz->otworzRegion('bloki', $this->tlumaczenia['region_bloki'].$zaznacz_wiele);

			foreach ($bloki as $input)
			{
				$this->formularz->input($input);
			}

			$this->formularz->zamknijRegion('bloki');

		$this->formularz->zamknijZakladke('moduly_zakladka');

		$this->formularz->otworzZakladke('dodatkowe_uslugi');
			
			if (count($api) > 0)
			{
				$this->formularz->otworzRegion('usluga_api');
				foreach ($api as $input)
				{
					$this->formularz->input($input);
				}
				$this->formularz->zamknijRegion('usluga_api');
			}
		
			if (count($rss) > 0)
			{
				$this->formularz->otworzRegion('usluga_rss');
				foreach ($rss as $input)
				{
					$this->formularz->input($input);
				}
				$this->formularz->zamknijRegion('usluga_rss');
			}

			if (count($cron) > 0)
			{
				$this->formularz->otworzRegion('usluga_cron');
				foreach ($cron as $input)
				{
					$this->formularz->input($input);
				}
				$this->formularz->zamknijRegion('usluga_cron');
			}

		$this->formularz->zamknijZakladke('dodatkowe_uslugi');


		$this->formularz->stopka(new Input\Submit('zapisz'));
		$this->formularz->stopka(new Input\Button('wstecz', array(
			'atrybuty' => array('onclick' => 'window.location = \'' . $this->urlPowrotny . '\'' )
		)));

		foreach ($this->formularz as $nazwaInputa => $input)
		{
			if (in_array($nazwaInputa, $this->konfiguracja['formularz.wymagane_pola']))
			{
				$this->formularz->$nazwaInputa->wymagany = true;
				$this->formularz->$nazwaInputa->dodajWalidator(new Walidator\NiePuste);
			}

			$wartosc = $input->pobierzWartoscPoczatkowa();
			if (!empty($wartosc) || $wartosc === 0) continue;
			$this->formularz->$nazwaInputa->ustawWartosc($this->obiekt->$nazwaInputa);
		}

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * @return \Generic\Formularz\Projekt\Edycja
	 */
	public function ustawSzablon(\Generic\Biblioteka\Szablon $szablon)
	{
		$this->szablon = $szablon;

		return $this;
	}
}