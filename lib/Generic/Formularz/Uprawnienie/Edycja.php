<?php
namespace Generic\Formularz\Uprawnienie;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Model\DostepnyModul;
use Generic\Biblioteka\Katalog;
use Generic\Biblioteka\Zadanie;

class Edycja extends \Generic\Formularz\Abstrakcja
{
	/**
	 * @var \Generic\Biblioteka\Szablon
	 */
	protected $szablon;

	/**
	 * @var Array
	 */
	protected $listaPowiazan = array();

	/**
	 * @var Array
	 */
	protected $listaObiektow = array();

	protected function generujFormularz()
	{

		$this->formularz = new Formularz('', 'edytuj');

		$this->formularz->otworzZakladke('dane', $this->tlumaczenia['zakladka_dane']);

		$this->formularz->input(new Input\Text('kod', $this->tlumaczenia['etykieta_input_kod'], array('wymagany' => true, 'wartosc' => $this->obiekt->kod)));
		$this->formularz->kod->dodajWalidator(new Walidator\NiePuste);
		$this->formularz->input(new Input\Text('nazwa', $this->tlumaczenia['etykieta_input_nazwa'], array('wymagany' => true, 'wartosc' => $this->obiekt->nazwa)));
		$this->formularz->nazwa->dodajWalidator(new Walidator\NiePuste);
		$this->formularz->input(new Input\TextArea('opis', $this->tlumaczenia['etykieta_input_opis'], array('wymagany' => true, 'wartosc' => $this->obiekt->opis)));
		$this->formularz->opis->dodajFiltr('strip_tags');

		$this->formularz->input(new Input\Hidden('czyZapisac', '1'));

		$this->formularz->input(new Input\Select('kontekstowa', array(
			'lista' => $this->tlumaczenia['kontekstowa']['lista'],
			'wartosc' => $this->obiekt->kontekstowa + 1,
		)));
		$this->formularz->kontekstowa->dodajFiltr('strip_tags');
		$this->formularz->kontekstowa->dodajWalidator(new Walidator\DozwoloneWartosci(array_keys($this->tlumaczenia['kontekstowa']['lista'])));

		$this->formularz->input(new Input\Select('kontekstObiekt', array(
			'lista' => $this->pobierzListeObiektow(),
			'wybierz' => $this->tlumaczenia['wybierz'],
			'wartosc' => $this->obiekt->kontekstObiekt,
		)));
		$this->formularz->kontekstObiekt->dodajWalidator(new Walidator\DozwoloneWartosci(array_keys($this->pobierzListeObiektow())));


		if ($this->formularz->kontekstObiekt->pobierzWartosc() != '')
		{
			$this->formularz->input(new Input\Select('kontekstPole', array(
				'lista' =>  $this->pobierzListePolObiektu($this->formularz->kontekstObiekt->pobierzWartosc()),
				'wybierz' => $this->tlumaczenia['wybierz'],
			'wartosc' => $this->obiekt->kontekstPole,
			)));
		}

		$this->formularz->input(new Input\Select('kontekstPowiazanie', array(
			'lista' => $this->pobierzListePowiazan(),
			'wybierz' => $this->tlumaczenia['wybierz'],
			'wartosc' => $this->obiekt->kontekstPowiazanie,
		)));
		$this->formularz->kontekstPowiazanie->dodajFiltr('intval');
		$this->formularz->kontekstPowiazanie->dodajWalidator(new Walidator\DozwoloneWartosci(array_keys($this->pobierzListePowiazan())));



		$this->formularz->input(new Input\Select('kontekstPowiazanieKtoreId', array(
			'lista' => $this->tlumaczenia['kontekstPowiazanieKtoreId']['lista'],
			'wartosc' => $this->obiekt->kontekstPowiazanieKtoreId,
		)));
		$this->formularz->kontekstPowiazanieKtoreId->dodajFiltr('intval');
		$this->formularz->kontekstPowiazanieKtoreId->dodajWalidator(new Walidator\DozwoloneWartosci(array_keys($this->tlumaczenia['kontekstPowiazanieKtoreId']['lista'])));


		$this->formularz->zamknijZakladke('dane');

		$this->formularz->otworzZakladke('moduly', $this->tlumaczenia['zakladka_moduly']);

		$sorter = new DostepnyModul\Sorter('nazwa', 'asc');
		$mapper = DostepnyModul\Mapper::wywolaj();
		$bloki = array();
		$moduly = array();
		$przypisane = explode(',', $this->obiekt->modulyDostep);
		foreach($mapper->pobierzPrzypisane(array('zwykly','jednorazowy','blok'), null, $sorter) as $modul)
		{
			$zaznaczony = (in_array($modul->kod, $przypisane)) ? 1 : 0;

			if ($modul->typ == 'blok')
			{
				$bloki[] = new Input\Checkbox('modul_'.$modul->kod, $modul->nazwa, array('wartosc' => $zaznaczony, 'atrybuty' => array('class' => 'blok')), $modul->opis);
			}
			else
			{
				$moduly[] = new Input\Checkbox('modul_'.$modul->kod, $modul->nazwa, array('wartosc' => $zaznaczony, 'atrybuty' => array('class' => 'modul')), $modul->opis);
			}
		}
		$zaznacz_wiele = $this->szablon->parsujBlok('/zaznacz_wiele_link', array(
			'region' => 'moduly',
			'rel' => 'modul',
		));
		$this->formularz->otworzRegion('moduly', $this->tlumaczenia['region_moduly'].$zaznacz_wiele);
		foreach ($moduly as $input)
		{
			$this->formularz->input($input);
		}
		$this->formularz->zamknijRegion('moduly');

		$zaznacz_wiele = $this->szablon->parsujBlok('/zaznacz_wiele_link', array(
			'region' => 'bloki',
			'rel' => 'blok',
		));
		$this->formularz->otworzRegion('bloki', $this->tlumaczenia['region_bloki'].$zaznacz_wiele);
		foreach ($bloki as $input)
		{
			$this->formularz->input($input);
		}
		$this->formularz->zamknijRegion('bloki');

		$this->formularz->zamknijZakladke('moduly');

		$this->formularz->stopka(new Input\Submit('zapisz', '', array(
			'wartosc' => $this->tlumaczenia['etykieta_input_zapisz']
		)));
		$this->formularz->stopka(new Input\Button('wstecz', '', array(
			'wartosc' => $this->tlumaczenia['etykieta_input_wstecz'],
			'atrybuty' => array('onclick' => 'window.location = \'' . $this->urlPowrotny . '\'' )
		)));

		if ($this->formularz->wypelniony() && Zadanie::pobierzPost('czyZapisac') > 0)
		{

			if ($this->formularz->kontekstowa->pobierzWartosc() == 2)
			{
				if ($this->formularz->kontekstObiekt->pobierzWartosc() != '')
				{
					$this->formularz->kontekstPole->dodajWalidator(new Walidator\NiePuste());
				}

				if ($this->formularz->kontekstPowiazanieKtoreId->pobierzWartosc() != '')
				{
					$this->formularz->kontekstPowiazanieKtoreId->dodajWalidator(new Walidator\NiePuste());
				}
			}


		}

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * @return \Generic\Formularz\Uprawnienie\Edycja
	 */
	public function ustawSzablon(\Generic\Biblioteka\Szablon $szablon)
	{
		$this->szablon = $szablon;

		return $this;
	}


	/**
	 * @return array
	 */
	protected function pobierzListePowiazan()
	{
		if (count($this->listaPowiazan) == 0)
		{
			foreach (\Generic\Biblioteka\Cms::inst()->dane()->PowiazanieTyp()->zwracaTablice()->szukaj(array('typObiektow' => 'Uzytkownik')) as $powiazanie)
			{
				$this->listaPowiazan[$powiazanie['id']] = $powiazanie['nazwa'];

			}
		}

		return $this->listaPowiazan;
	}


	/**
	 * @return Array
	 */
	protected function pobierzListePolObiektu($nazwaObiektu)
	{
		$namespace = '\\Generic\\Model\\' . $this->listaObiektow[$nazwaObiektu] . '\\Definicja';

		$instancja = new $namespace();

		$pola = array();
		foreach ($instancja->obslugiwanePola() as $pole)
		{
			$pola[$pole] = $pole;
		}

		return $pola;
	}


	/**
	 * @return Array
	 */
	protected function pobierzListeObiektow()
	{
		if (count($this->listaObiektow) == 0)
		{

			$katalogMappery = new Katalog(CMS_KATALOG.'/lib/Generic/Model/');
			$this->listaObiektow = array();

			foreach ($katalogMappery->pobierzZawartosc(1) as $klucz => $wartosc)
			{
				if ( !is_array($wartosc)
						|| strpos($klucz, '.') === 0
						|| ! is_file(CMS_KATALOG.'/lib/Generic/Model/' . $klucz . '/Obiekt.php')
						|| $klucz == 'Drzewo'
					)
				{
					continue;
				}

				$this->listaObiektow[$klucz] = $klucz;
			}
		}

		return $this->listaObiektow;
	}
}