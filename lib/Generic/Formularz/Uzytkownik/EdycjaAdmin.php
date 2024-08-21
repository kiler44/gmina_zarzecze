<?php
namespace Generic\Formularz\Uzytkownik;
use Generic\Biblioteka\Input\MultiCheckbox;

use Generic\Biblioteka\Walidator\DluzszeOd;

use Generic\Biblioteka\Input\Select;
use Generic\Model\TidsbankenKolekcja;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Router;
use Generic\Model\Rola;

class EdycjaAdmin extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{
		$cms = Cms::inst();
		$this->formularz = new Formularz('', 'uzytkownik_form');
		$this->formularz->otworzZakladke('uzytkownik');

		$this->formularz->otworzRegion('dane_podstawowe');

			if ($this->obiekt->id < 1)
			{
				$this->formularz->input(new Input\Text('login', array(
					'atrybuty'	=> array('autocomplete' => 'off'),
				)));
				$this->formularz->login->dodajWalidator(new Walidator\WyrazenieRegularne($this->konfiguracja['formularz.walidacja_loginu']));
			}

			if (! $this->konfiguracja['emailAktywacyjny.link_do_ustawienia_hasla'])
			{
				$this->formularz->input(new Input\Password('haslo', array(
					'atrybuty'	=> array('autocomplete' => 'off'),
				)));
				$this->formularz->haslo->dodajFiltr('strip_tags', 'filtr_xss', 'trim');
				$this->formularz->haslo->ustawWartosc('');

				$this->formularz->input(new Input\Password('hasloPowtorz', array(
					'atrybuty'	=> array('autocomplete' => 'off'),
				)));
				$this->formularz->hasloPowtorz->dodajFiltr('strip_tags', 'filtr_xss', 'trim');
				
				$this->formularz->input(new Input\Checkbox('czyAdmin'));
				$this->formularz->czyAdmin->dodajFiltr('intval');
				
				$this->formularz->input(new Input\Select('status', array(
				'lista' => $this->tlumaczenia['uzytkownik.statusy'],
			)));
			}
			else
			{
				$this->formularz->input(new Input\Hidden('status', 'niekatywny'));
				$this->formularz->input(new Input\Hidden('czyAdmin', '1'));
			}


			$listaJezykow = array();
			foreach ($cms->projekt->jezyki as $jezyk)
			{
				$listaJezykow[$jezyk->kod] = $jezyk->nazwa;
			}
			$this->formularz->input(new Input\Select('jezyk', array(
				'lista' => $listaJezykow,
			)));

			$this->formularz->input(new Input\Text('imie'));
			$this->formularz->imie->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

			$this->formularz->input(new Input\Text('nazwisko'));
			$this->formularz->nazwisko->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

			$this->formularz->input(new Input\Text('email'));
			$this->formularz->email->dodajFiltr('strip_tags', 'filtr_xss', 'trim');
			$this->formularz->email->dodajWalidator(new Walidator\Email);

			$this->formularz->input(new Input\Data('dataUrodzenia', array(
				'datepicker_cfg' => array('yearRange' => '"'.(date("Y") - 100).':'.date("Y").'"', 'defaultDate' => '""')
			)));
			$this->formularz->dataUrodzenia->dodajWalidator(new Walidator\DataIso);

			$this->formularz->input(new Input\Select('krajPochodzenia', array(
				'lista' => $cms->lang['kraje'],
			)));
			$this->formularz->krajPochodzenia->dodajWalidator(new Walidator\DozwoloneWartosci(array_keys($cms->lang['kraje'])));

			$linkCropper = '';

			$kategorieMapper = new \Generic\Model\Kategoria\Mapper();
			$kategoriaCropper = $kategorieMapper->pobierzDlaModulu('CropperZdjec');

			$prefix = ($this->konfiguracja['formularz.prefix_miniatury_podgladu'] != '' ) ? $this->konfiguracja['formularz.prefix_miniatury_podgladu'].'-' : '';

			if (isset($kategoriaCropper[0]) && $kategoriaCropper[0] instanceof \Generic\Model\Kategoria\Obiekt && $this->obiekt->id > 0)
			{
				$zdjecieDoCroppera = $cms->url('zdjecia_pracownikow') . trim($this->obiekt->zdjecie);
				$sciezkaZdjecia = $cms->katalog('zdjecia_pracownikow');

				$linkCropper = Router::urlAjax('Http', $kategoriaCropper[0], 'formularz', array(
					'obraz' => urlencode(zakoduj($zdjecieDoCroppera, $cms->config['cropper']['klucz_szyfrowania'])),
					'sciezka' => urlencode(zakoduj($sciezkaZdjecia, $cms->config['cropper']['klucz_szyfrowania'])),
				));
			}


			$this->formularz->input(new Input\ZdjecieCropowane('zdjecie', array(
				'sciezka_plikow' => $cms->url('zdjecia_pracownikow'),
				'link_usun' => Router::urlAdmin('UzytkownicyZarzadzanie', 'usunZdjecie', array('id' => $this->obiekt->id)),
				'link_miniaturka' => ($this->obiekt->zdjecie != '') ? $prefix.$this->obiekt->zdjecie : '',
				'link_popraw_miniaturke' => (($this->obiekt->id > 0 && $linkCropper != '') ? $linkCropper : ''),
				'rozmiary_miniaturek' => $this->konfiguracja['formularz.rozmiary_miniaturek_zdjecia'],
			)));



		$this->formularz->zamknijRegion('dane_podstawowe');

		if ($this->uprawnienia['edycjaDanychKontaktowych'])
		{
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

        if ($this->uprawnienia['edycjaDanychOpiekuna']) {
            $this->formularz->otworzRegion('dane_opiekuna');

            $this->formularz->input(new Input\Text('opiekun'));
            $this->formularz->input(new Input\Text('emailOpiekun'));
            $this->formularz->emailOpiekun->dodajWalidator(new Walidator\Email());
            $this->formularz->input(new Input\Text('telefonOpiekun'));
            $this->formularz->telefonOpiekun->dodajWalidator(new Walidator\Telefon());

            $this->formularz->zamknijRegion('dane_opiekuna');
        }
		
        /*
		if ($this->uprawnienia['edycjaDanychPracowniczych'])
		{
            $this->formularz->otworzRegion('dane_pracownicze');
			$this->formularz->input(new Input\Text('stawkaGodzinowa', array(
				'wymagany' => false,
			)));
			$this->formularz->stawkaGodzinowa->dodajFiltr('doubleval');
			$this->formularz->stawkaGodzinowa->dodajWalidator(new Walidator\NiePuste());
			$this->formularz->stawkaGodzinowa->dodajWalidator(new Walidator\WiekszeOd(0));
			$this->formularz->stawkaGodzinowa->dodajWalidator(new Walidator\LiczbaZmiennoprzecinkowa());
			
			$this->formularz->input(new Input\Text('stalaWyplata', array(
				'wymagany' => false,
			)));
			
			$this->formularz->input(new Input\Checkbox('praktykant'));
			
			$this->formularz->input(new Input\Data('praktykantDataDo'));
			
			$tabelePodatkowe = listaZTablicy($cms->dane()->TabelaPodatkowa()->zwracaTablice()->pobierzListeTabel(), 'nr_tabeli', 'nr_tabeli');
			asort($tabelePodatkowe);
			$tabelePodatkowe[0] = '- select -';
			$this->formularz->input(new Input\Select('tabelaPodatkowa', array(
				'lista' => $tabelePodatkowe,
				'wymagany' => true,
			)));


			$this->formularz->input(new Input\MultiCheckbox('umiejetnosci', array(
				'lista' => $this->konfiguracja['formularz.available_skills'],
				)
			));
           
            $this->formularz->zamknijRegion('dane_pracownicze');
		}
        */


		$this->formularz->zamknijZakladke('uzytkownik');

		/*
		if ($this->uprawnienia['edycjaDaneTidsbanken'])
		{
			$this->formularz->otworzZakladke('tidsbanken');
			
			$this->formularz->otworzRegion('tidsbankenLogin');
			
				$this->formularz->input(new Input\Text('tidsbankenNumerPracownika'));
				$this->formularz->input(new Input\Text('tidsbankenKod'));
				$this->formularz->tidsbankenKod->dodajFiltr('intval');
				$this->formularz->input( new Input\Checkbox('wyswietlajWTidsbanken'));

				$this->formularz->input(new Input\Checkbox('tidsbankenLogujPrzezHaslo'));
				$this->formularz->input(new Input\Text('tidsbankenHaslo'));
				
			$this->formularz->zamknijRegion('tidsbankenLogin');
			
			$this->formularz->otworzRegion('informacjeZatrudnienie');
				$this->formularz->input(new Input\Text('stanowisko'));
				$dzialMapper = Cms::inst()->dane()->TidsbankenDzial();
				$dzialy = listaZTablicy($dzialMapper->zwracaTablice()->pobierzWszystko(), 'id', 'nazwa');
				$this->formularz->input(new Input\Select('dzial', array('lista' => $dzialy)));
				$this->formularz->input(new Input\Text('etat', array('spinner' => true, 'spinner_min' => 10, 'spinner_max' => 100, 'spinner_skok' => 10)));
				
				$listaWlascicielKonta[0] = array('etykieta' => ' - select - ', 'konto' => '');
				$maperUzytkownicy = Cms::inst()->dane()->Uzytkownik();
				foreach($maperUzytkownicy->pobierzWszystko() as $uzytkownikKonta)
				{
					$listaWlascicielKonta[$uzytkownikKonta->imie.' '.$uzytkownikKonta->nazwisko] =  array(
						'etykieta' => $uzytkownikKonta->imie.' '.$uzytkownikKonta->nazwisko,
						'konto' => $uzytkownikKonta->kontoBankowe,);
				}
				$this->formularz->input(new Input\SelectDynamiczny('wlascicielKonta', array('lista' => $listaWlascicielKonta)));
				
				$this->formularz->input(new Input\Text('kontoBankowe'));
				$this->formularz->input(new Input\Text('dniWolne'));
				$this->formularz->input(new Input\Text('dniChorobowe'));
				
			$this->formularz->zamknijRegion('informacjeZatrudnienie');
			
			$this->formularz->zamknijZakladke('tidsbanken');
		}
		 */
		
		/*
		if ($this->uprawnienia['edycjaStawkaUzytkownika'] && $this->obiekt->id > 0)
		{
			$this->formularz->otworzZakladke('stawkaUzytkownika');
			$listaStawek = listaZTablicy($cms->dane()->StawkaUzytkownika()->zwracaTablice()->pobierzDlaUzytkownika($this->obiekt->id), 'id');
				$this->formularz->input(new Input\StawkaUzytkownika('stawka', 
						  array(
							  'urlDodajStawke' => $this->konfiguracja['urlDodajStawke'], 
							  'urlUsunStawke' => $this->konfiguracja['urlUsunStawke'], 
							  'urlAktualizujStawke' => $this->konfiguracja['urlAktualizujStawke'],
							  'listaStawek' => $listaStawek,
							  'idUzytkownika' => $this->obiekt->id,
						  )
						  ));
			$this->formularz->zamknijZakladke('stawkaUzytkownika');
		}
		
		if ($this->uprawnienia['edycjaKolekcje'])
		{
			$this->formularz->otworzZakladke('kolekcje');

			$kolekcjeMapper = Cms::inst()->dane()->TidsbankenKolekcja();
			$przypisane = array();
			if ($this->obiekt->id > 0)
			{
				foreach ($kolekcjeMapper->pobierzPrzypisaneUzytkownikowi($this->obiekt->id, array('aktywne' => true)) as $przypisanaKolekcja)
				{
					$przypisane[$przypisanaKolekcja->id] = $przypisanaKolekcja;
				}
			}
			$conf = array();
			$listaKolekcji = $kolekcjeMapper->szukaj(array('aktywne' => true),null, new TidsbankenKolekcja\Sorter('nazwa', 'asc'));
		
			foreach ($listaKolekcji as $kolekcja)
			{
				$zaznaczony = (array_key_exists($kolekcja->id, $przypisane)) ? 1 : 0;
				$this->formularz->input(new Input\Checkbox('kolekcja_'.$kolekcja->id, array('wartosc' => $zaznaczony), $kolekcja->nazwa, $kolekcja->opis));
			}

			$this->formularz->zamknijZakladke('kolekcje');
		}
		*/
		
		if ($this->uprawnienia['edycjaRoli'])
		{
			$this->formularz->otworzZakladke('role');

			$roleMapper = Cms::inst()->dane()->Rola();
			$przypisane = array();
			if ($this->obiekt->id > 0)
			{
				foreach ($roleMapper->pobierzPrzypisaneUzytkownikowi($this->obiekt->id) as $rola)
				{
					$przypisane[$rola->kod] = $rola;
				}
			}
			$conf = array();
			foreach ($roleMapper->szukaj(array('tylko_zwykle_role' => true, 'nie_kontekstowa' => true),null, new Rola\Sorter('nazwa', 'asc')) as $rola)
			{
				$zaznaczony = (array_key_exists($rola->kod, $przypisane)) ? 1 : 0;
				$this->formularz->input(new Input\Checkbox('rola_'.$rola->kod, array('wartosc' => $zaznaczony), $rola->nazwa, $rola->opis));
			}

			$this->formularz->zamknijZakladke('role');
		}
		
		if ($this->uprawnienia['edycjaPliki'] && $this->obiekt->id > 0)
		{
			
			$plikiPrywatne = $this->obiekt->pobierzPlikiPrywatneUzytkownika();
			$zalacznikiLista = array();
			$i = 0;
			foreach($plikiPrywatne as $klucz => $dane)
			{
				$i++;
				$zalacznikiLista[] = array (
						'id' => $dane['id_baza'],
						'kod' => $dane['nazwa'], 
						'nazwa' => $dane['nazwa'],
						'rozmiar' => 270744, 
						'opis' => '',
						'uprawnieniaUzytkownika' => $dane['ma_uprawnienie'],
					  );
			}
			
			$this->formularz->otworzZakladke('pliki');
			$listaZalacznikow = array();
			
			$this->formularz->input(new Input\MultiUploadPlikowUzytkownika('zalaczniki', array(
				'lista' => $zalacznikiLista,
				'urlUpranienia' => Router::urlAjax('Admin', 'UzytkownicyZarzadzanie', 'przypiszUprawnieniaDoPliku'),
				'url_upload' => Router::urlAjax('Admin', 'UzytkownicyZarzadzanie', 'zapiszPlik'),
				'url_usun' => Router::urlAjax('Admin', 'UzytkownicyZarzadzanie', 'usunPlik'),
				'url_plikow' => Cms::inst()->url('pliki_uzytkownika', $this->obiekt->id),
				'prefix' => '',
				'max_wielkosc_pliku' => 50000000,
				//'dozwolone_rozszerzenia' => $this->konfiguracja['import.dozwolone_pliki'],
			)));

			$this->formularz->zamknijZakladke('pliki');
		}
		
		
		if ($this->uprawnienia['edycjaDodatkoweAkcje'])
		{
			$this->formularz->otworzZakladke('akcje');

				if ($this->obiekt->id > 0 && $this->uprawnienia['wykonajPrzechwyc'])
				{
					$this->formularz->input(new Input\Button('zaloguj', '&nbsp;', array(
						'atrybuty' => array('onclick' => 'window.location = \''.Router::urlAdmin('UzytkownicyZarzadzanie', 'przechwyc', array('id' => $this->obiekt->id)).'\'' )
					)));
				}
				if ($this->obiekt->id > 0 && $this->obiekt->status == 'nieaktywny')
				{
					$this->formularz->input(new Input\Button('wyslijEmailAktywacyjny', '&nbsp;', array(
						'atrybuty' => array('onclick' => 'window.location.href = \''.Router::urlAdmin('UzytkownicyZarzadzanie', 'emailAktywacyjny', array('id' => $this->obiekt->id)).'\'' )
					)));
				}
				$rolaIndywidualna = Cms::inst()->dane()->Rola()->pobierzPoKodzie('uzytkownik_' . $this->obiekt->id);
				if ($rolaIndywidualna instanceof Rola\Obiekt)
				{
					$this->formularz->input(new Input\Button('uprawnienie', '&nbsp;', array(
						'atrybuty' => array('onclick' => 'window.location = \''.Router::urlAdmin('UprawnieniaZarzadzanie', 'podglad', array('id' => $rolaIndywidualna->id)).'\'' )
					)));
				}

			$this->formularz->zamknijZakladke('akcje');
		}

		$this->formularz->stopka(new Input\Submit('zapisz'));
		$this->formularz->stopka(new Input\Button('wstecz', array(
			'atrybuty' => array('onclick' => 'window.location = \'' . $this->urlPowrotny . '\'' )
		)));

		foreach ($this->formularz as $pole => $input)
		{
			if (!in_array($pole, array('gridPliki', 'login','haslo','hasloPowtorz', 'zaloguj', 'uprawnienie', 'wyslijEmailAktywacyjny', 'doWizytowki', 'stawka', 'zalaczniki')) && strpos($pole, 'rola_') === false && strpos($pole, 'kolekcja_') === false)
			{
				$this->formularz->$pole->ustawWartosc($this->obiekt->$pole);
			}

			if (in_array($pole, $this->konfiguracja['formularz.wymagane_pola']))
			{
				if ($this->obiekt->id > 0 && in_array($pole, array('login', 'haslo', 'hasloPowtorz', 'zaloguj', 'stawka'))) continue;
				$this->formularz->$pole->wymagany = true;
				$this->formularz->$pole->dodajWalidator(new Walidator\NiePuste);
			}
		}


		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}
}