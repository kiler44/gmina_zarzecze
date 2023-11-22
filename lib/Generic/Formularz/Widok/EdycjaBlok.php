<?php
namespace Generic\Formularz\Widok;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Mapper;
use Generic\Biblioteka\Szablon;
use Generic\Model\DostepnyModul;

class EdycjaBlok extends \Generic\Formularz\Abstrakcja
{
	/**
	 * @var string
	 */
	protected $szablonKontenery = '';


	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'formularzDodawanieBloku');

		$this->formularz->input(new Input\Text('nazwa'))
			->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		if ($this->obiekt->id > 0)
		{
			$this->formularz->input(new Input\Html('kodModulu'));

			$widoki = Cms::inst()->dane()->Widok()->zwracaTablice('nazwa')->pobierzZawierajaceBlok($this->obiekt->id);

			$this->formularz->input(new Input\Html('widoki', array(
				'wartosc' => implode(', ', listaZTablicy($widoki, null, 'nazwa'))
			)));

			$szablony_ = glob(SZABLON_KATALOG.'/moduly/'.$this->obiekt->kodModulu.'/Http*.tpl');
			foreach ($szablony_ as $szablon)
			{
				$szablon = basename($szablon);
				$szablony[$szablon] = $szablon;
			}

			if (count($szablony) > 1)
			{
				$this->formularz->input(new Input\Select('szablon', array(
					'lista' => $szablony,
				)));
			}
		}
		else
		{
			$moduly = DostepnyModul\Mapper::wywolaj(Mapper::ZWRACA_TABLICE);
			$moduly = $moduly->pobierzPrzypisane('blok', null, new DostepnyModul\Sorter('nazwa', 'asc'));

			$this->formularz->input(new Input\Select('kodModulu', array(
				'lista' => listaZTablicy($moduly, 'kod', 'nazwa'),
				'wybierz' => $this->tlumaczenia['etykieta_select_wybierz']
			)));
		}

		$kontenery = new Szablon();
		$kontenery->ladujTresc($this->szablonKontenery, true);
		$dostepneKontenery = array();
		foreach ($kontenery->struktura() as $kod)
		{
			$kod = explode('/', $kod);
			if (count($kod) == 3) $dostepneKontenery[$kod[1]] = $kod[1];
		}
		$this->formularz->input(new Input\Select('kontener', array(
			'lista' => $dostepneKontenery,
			'wybierz' => $this->tlumaczenia['etykieta_select_wybierz']
		)))
			->dodajWalidator(new Walidator\DozwoloneWartosci($dostepneKontenery));

		$this->formularz->input(new Input\Text('klasa'))
			->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		if ($this->obiekt->modul instanceof DostepnyModul\Obiekt && $this->obiekt->modul->cache == true)
		{
			$this->formularz->input(new Input\Checkbox('cache'))
				->dodajFiltr('intval', 'abs');

			$this->formularz->input(new Input\Select('cacheCzas', array(
				'lista' => $this->tlumaczenia['cache_przedzialy_czasowe'],
			)))
				->dodajFiltr('intval', 'abs')
				->dodajWalidator(new Walidator\DozwoloneWartosci(array_keys($this->tlumaczenia['cache_przedzialy_czasowe'])));
		}

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

			$wartosc = $input->pobierzWartoscPoczatkowa();
			if (!empty($wartosc) || in_array($nazwaInputa, array('podglad', 'kopiowanyWidok', 'widoki'))) continue;
			$this->formularz->$nazwaInputa->ustawWartosc($this->obiekt->$nazwaInputa);
		}

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * @return \Generic\Formularz\Widok\EdycjaBlok
	 */
	public function ustawSzablonKontenery($szablon)
	{
		$this->szablonKontenery = $szablon;

		return $this;
	}

}