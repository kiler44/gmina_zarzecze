<?php
namespace Generic\Formularz\Uzytkownik;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Router;

class Edycja extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{
		$cms = Cms::inst();
		$this->formularz = new Formularz('', 'uzytkownik_form');

		// Region DANE PODSTAWOWE
		$this->formularz->otworzRegion('dane_podstawowe');

			$listaJezykow = array();

			$this->formularz->input(new Input\Text('imie'));
			$this->formularz->imie->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

			$this->formularz->input(new Input\Text('nazwisko'));
			$this->formularz->nazwisko->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

			foreach (Cms::inst()->projekt->jezyki as $jezyk)
			{
				$listaJezykow[$jezyk->kod] = $jezyk->nazwa;
			}
			$this->formularz->input(new Input\Select('jezyk', array(
				'lista' => $listaJezykow,
			)));
			$this->formularz->jezyk->dodajWalidator(new Walidator\NiePuste());

			$this->formularz->input(new Input\Data('dataUrodzenia', array(
				'datepicker_cfg' => array('yearRange' => '"'.(date("Y") - 100).':'.date("Y").'"', 'defaultDate' => '""')
			)));
			$this->formularz->dataUrodzenia->dodajWalidator(new Walidator\DataIso);

			$linkCropper = '';

			$kategorieMapper = new \Generic\Model\Kategoria\Mapper();
			$kategoriaCropper = $kategorieMapper->pobierzDlaModulu('CropperZdjec');

			$prefix = ($this->konfiguracja['formularz.prefix_miniatury_podgladu'] != '' ) ? $this->konfiguracja['formularz.prefix_miniatury_podgladu'].'-' : '';

			if (isset($kategoriaCropper[0]) && $kategoriaCropper[0] instanceof \Generic\Model\Kategoria\Obiekt && $this->obiekt->id > 0)
			{
				$zdjecieDoCroppera = $cms->url('zdjecia_pracownikow') . trim($this->obiekt->zdjecie);
				$sciezkaZdjecia = $cms->katalog('zdjecia_pracownikow');

				$linkCropper = Router::urlAjax('http', $kategoriaCropper[0], 'formularz', array(
					'obraz' => urlencode(zakoduj($zdjecieDoCroppera, $cms->config['cropper']['klucz_szyfrowania'])),
					'sciezka' => urlencode(zakoduj($sciezkaZdjecia, $cms->config['cropper']['klucz_szyfrowania'])),
				));
			}

			$this->formularz->input(new Input\ZdjecieCropowane('zdjecie', array(
				'sciezka_plikow' => $cms->url('zdjecia_pracownikow'),
				'link_usun' => ($this->uprawnienia['moznaUsunacZdjecie']) ? Router::urlAdmin('UserAccount', 'removePhoto', array('id' => $this->obiekt->id)) : null,
				'link_miniaturka' => ($this->obiekt->zdjecie != '') ? $prefix.$this->obiekt->zdjecie : '',
				'link_popraw_miniaturke' => ($this->uprawnienia['moznaPoprawicMiniaturke']) ? (($this->obiekt->id > 0 && $linkCropper != '') ? $linkCropper : '') : null,
				'rozmiary_miniaturek' => $this->konfiguracja['formularz.rozmiary_miniaturek_zdjecia'],
			)));


		$this->formularz->zamknijRegion('dane_podstawowe');

		if ($this->konfiguracja['formularz.wyswietlaj_dane_kontaktowe'] == 1)
		{
			// Region KONTAKT
			$this->formularz->otworzRegion('dane_kontaktowe');

				$this->formularz->input(new Input\Text('telKomorkaFirmowa'));
				$this->formularz->telKomorkaFirmowa->dodajFiltr('strip_tags', 'filtr_xss', 'trim');
				$this->formularz->telKomorkaFirmowa->dodajWalidator(new Walidator\Telefon);

				$this->formularz->input(new Input\Text('telKomorkaPrywatna'));
				$this->formularz->telKomorkaPrywatna->dodajFiltr('strip_tags', 'filtr_xss', 'trim');
				$this->formularz->telKomorkaPrywatna->dodajWalidator(new Walidator\Telefon);

				$this->formularz->input(new Input\Text('telDomowy'));
				$this->formularz->telDomowy->dodajFiltr('strip_tags', 'filtr_xss', 'trim');
				$this->formularz->telDomowy->dodajWalidator(new Walidator\Telefon);

				$this->formularz->input(new Input\Text('kontaktAdres'));
				$this->formularz->kontaktAdres->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

				$this->formularz->input(new Input\KodPocztowyNorwegia('kontaktKodPocztowy'));
				$this->formularz->kontaktKodPocztowy->dodajWalidator(new Walidator\DluzszeOd(3));
				$this->formularz->kontaktKodPocztowy->dodajWalidator(new Walidator\KrotszeOd(5));
				$this->formularz->kontaktKodPocztowy->dodajFiltr('strval', 'trim');
				$this->formularz->kontaktKodPocztowy->dodajWalidator(new Walidator\WiekszeOd(0));
				$this->formularz->kontaktKodPocztowy->dodajWalidator(new Walidator\MniejszeOd(9992));

				$this->formularz->input(new Input\Text('kontaktMiasto'));
				$this->formularz->kontaktMiasto->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

			$this->formularz->zamknijRegion('dane_kontaktowe');
		}



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
			
			if (!empty($wartosc)) continue;
			$this->formularz->$nazwaInputa->ustawWartosc($this->obiekt->$nazwaInputa);
		}

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}
}