<?php
namespace Generic\Formularz\Obserwator;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Szablon;
use Generic\Biblioteka\Cms;
use Generic\Modul\EmailZarzadzanie;

class Edycja extends \Generic\Formularz\Abstrakcja
{
	protected $zdarzenia;


	protected $zdarzeniaAdministracyjne;


	protected $szablon;


	protected function generujFormularz()
	{
		$cms = Cms::inst();

		$this->formularz = new Formularz('', 'dodajObserwator');

		$this->formularz->otworzRegion('dane');

		$this->formularz->input(new Input\Text('opis', array(
			'wartosc' => $this->obiekt->opis,
			'atrybuty' => array('style' => 'width: 350px', 'maxlength' => 255),
			)));
		$obiekt = $this->obiekt;
		$this->formularz->input(new Input\Select('typ', array(
			'lista' => $this->konfiguracja['obserwator.typy_obserwatorow'],
			'wartosc' => $this->obiekt->typ,
			'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
			'atrybuty' => array(
				'onchange' => 'this.form.submit();',
			),
		)))
			->dodajWalidator(new Walidator\DozwoloneWartosci($obiekt::pobierzDostepneTypy()));

		$wybranyTyp = $this->formularz->input('typ')->pobierzWartosc();


		switch ($wybranyTyp)
		{
			case 'Email':
				$this->formularz->input(new Input\Select('obiekt_docelowy', array(
					'wartosc' => $this->obiekt->obiekt_docelowy,
					'lista' => EmailZarzadzanie\Admin::listaFormatek(),
					'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
				)))
					->dodajFiltr('intval', 'abs');

				$this->formularz->input(new Input\Checkbox('edycja_formatki'));
			break;

			case 'NaMail':
			case 'DoPliku':
		$this->formularz->input(new Input\Text('obiekt_docelowy', array(
			'wartosc' => $this->obiekt->obiekt_docelowy,
			'atrybuty' => array('style' => 'width: 350px', 'maxlength' => 50),
				)))
					->dodajFiltr('strip_tags', 'filtr_xss', 'trim')
					->dodajWalidator(new Walidator\NiedozwoloneWartosci($this->konfiguracja['formularz.niedozwolone_nazwy_plikow']));
			break;
		}

		$this->formularz->zamknijRegion('dane');

		$zdarzeniaObserwatora = $this->obiekt->zdarzenia;
		if ( ! is_array($zdarzeniaObserwatora))
		{
			$zdarzeniaObserwatora = array();
		}

		if ($wybranyTyp == 'Email')
		{
			$lista = array();
			$klasy = array();
		foreach ($this->zdarzenia as $usluga => $kategorie)
		{
				foreach ($kategorie as $id => $dane)
				{
					$kodModulu = $dane['kod_modulu'];
					if ($kodModulu == '') continue;
					$sekcja = $cms->lang['uslugi'][$usluga].' - '.$dane['nazwa'].' ('.$dane['kod_modulu'].')';
					unset($dane['poziom']);
					unset($dane['kod_modulu']);
					unset($dane['nazwa']);
					foreach ($dane as $kodZdarzenia => $daneZdarzenia)
					{
						$kod = $usluga.'_'.$kodModulu.'_'.$id.'_'.$kodZdarzenia;
						$lista[$sekcja][$kod] = ' '.$daneZdarzenia['etykieta'];
						if ($daneZdarzenia['klasa'] != '') $klasy[$kod] = $daneZdarzenia['klasa'];
					}
				}
			}
			foreach ($this->zdarzeniaAdministracyjne as $id => $dane)
			{
				$kodModulu = $dane['kod_modulu'];
				if ($kodModulu == '') continue;
				$sekcja = $this->tlumaczenia['zakladka_moduly_administracyjne'].' - '.$dane['nazwa'].' ('.$dane['kod_modulu'].')';
				unset($dane['poziom']);
				unset($dane['kod_modulu']);
				unset($dane['nazwa']);

				foreach ($dane as $kodZdarzenia => $daneZdarzenia)
				{
					$kod = $kodModulu.'_'.$kodZdarzenia;
					$lista[$sekcja][$kod] = ' '.$daneZdarzenia['etykieta'];
					if ($daneZdarzenia['klasa'] != '') $klasy[$kod] = $daneZdarzenia['klasa'];
				}
			}
			$this->formularz->otworzRegion('region_zdarzenia', $this->tlumaczenia['przypisz_zdarzenia']);
				$this->formularz->input(new Input\Select('zdarzenia_email', array(
					'wartosc' => array_pop($zdarzeniaObserwatora),
					'lista' => $lista,
					'wybierz' => $this->tlumaczenia['etykieta_select_wybierz'],
				)))
					->dodajFiltr('strip_tags', 'filtr_xss', 'trim');
			$this->formularz->zamknijRegion('region_zdarzenia');
		}
		else
		{
			foreach ($this->zdarzenia as $usluga => $kategorie)
			{
			$this->formularz->otworzZakladke($usluga, $cms->lang['uslugi'][$usluga]);
			$this->formularz->otworzRegion($usluga, $this->tlumaczenia['przypisz_zdarzenia']);

			foreach ($kategorie as $id => $dane)
			{
				$kodModulu = $dane['kod_modulu'];
				$tresc = array(
					'poziom' => $dane['poziom'],
					'nazwa' => $dane['nazwa'].' ('.$dane['kod_modulu'].')',
				);
				$rel = $usluga.'_'.$kodModulu.'_'.$id;
				if(count($dane) > 4)
				{
					$tresc['zaznacz_wiele_link'] = array('rel' => $rel);
				}
				$nazwa_kategorii = $this->szablon->parsujBlok('kategoria', $tresc);

				if ($kodModulu == '') continue;
				$this->formularz->input(new Input\Html($usluga.'_'.$kodModulu.'_'.$id, '', array('wartosc' => $nazwa_kategorii)));
				unset($dane['poziom']);
				unset($dane['kod_modulu']);
				unset($dane['nazwa']);

				$rel = $usluga.'_'.$kodModulu.'_'.$id;

					foreach ($dane as $kodZdarzenia => $daneZdarzenia)
				{
						$kod = $usluga.'_'.$kodModulu.'_'.$id.'_'.$kodZdarzenia;
						$wartosc = (is_array($zdarzeniaObserwatora) && array_key_exists($kod, $zdarzeniaObserwatora)) ? 1 : 0;
						$this->formularz->input(new Input\Checkbox($kod, array(
						'wartosc' => $wartosc,
						'atrybuty' => array('class' => $rel),
						), $daneZdarzenia['etykieta']));
				}
			}

			$this->formularz->zamknijRegion($usluga);
			$this->formularz->zamknijZakladke($usluga);
		}

		$this->formularz->otworzZakladke('zakladka_admin', $this->tlumaczenia['zakladka_moduly_administracyjne']);
		$this->formularz->otworzRegion('region_admin', $this->tlumaczenia['przypisz_zdarzenia']);

			foreach ($this->zdarzeniaAdministracyjne as $id => $dane)
		{
			$kodModulu = $dane['kod_modulu'];

			$tresc = array(
					'poziom' => $dane['poziom'],
					'nazwa' => $dane['nazwa'].' ('.$dane['kod_modulu'].')',
			);
			$rel = $usluga.'_'.$kodModulu.'_'.$id;
				if (count($dane) > 4)
			{
				$tresc['zaznacz_wiele_link'] = array('rel' => $rel);
			}
			$nazwa_kategorii = $this->szablon->parsujBlok('kategoria', $tresc);
			$this->formularz->input(new Input\Html($kodModulu, '', array('wartosc' => $nazwa_kategorii)));
			unset($dane['poziom']);
			unset($dane['kod_modulu']);
			unset($dane['nazwa']);

				foreach ($dane as $kodZdarzenia => $daneZdarzenia)
			{
					$kod = $kodModulu.'_'.$kodZdarzenia;
					$wartosc = (is_array($zdarzeniaObserwatora) && array_key_exists($kod, $zdarzeniaObserwatora)) ? 1 : 0;
					$this->formularz->input(new Input\Checkbox($kod, $daneZdarzenia['etykieta'], array(
					'wartosc' => $wartosc,
					'atrybuty' => array('class' => $rel),
				)));
			}
		}

		$this->formularz->zamknijRegion('region_admin');
		$this->formularz->zamknijZakladke('zakladka_admin');
		}

		$this->formularz->stopka(new Input\Submit('zapisz'));
		$this->formularz->stopka(new Input\Button('wstecz', array(
			'atrybuty' => array('onclick' => 'window.location = \''.$this->urlPowrotny.'\'')
		)));

		foreach ($this->formularz as $nazwaInputa => $input)
		{
			if (in_array($nazwaInputa, $this->konfiguracja['formularz.wymagane_pola']))
			{
				$this->formularz->$nazwaInputa->wymagany = true;
				$this->formularz->$nazwaInputa->dodajWalidator(new Walidator\NiePuste);
			}
		}

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * @return \Generic\Formularz\Obserwator\Edycja
	 */
	public function ustawZdarzenia(Array $zdarzenia)
	{
		$this->zdarzenia = $zdarzenia;

		return $this;
	}


	/**
	 * @return \Generic\Formularz\Obserwator\Edycja
	 */
	public function ustawZdarzeniaAdministracyjne(Array $zdarzenia)
	{
		$this->zdarzeniaAdministracyjne = $zdarzenia;

		return $this;
	}


	/**
	 * @return \Generic\Formularz\Obserwator\Edycja
	 */
	public function ustawSzablon(Szablon $szablon)
	{
		$this->szablon = $szablon;

		return $this;
	}

}