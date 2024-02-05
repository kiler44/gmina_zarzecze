<?php
namespace Generic\Formularz\Aktualnosc;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Katalog;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Router;
use Generic\Model\Zalacznik\Obiekt;

class Edycja extends \Generic\Formularz\Abstrakcja
{
	/**
	 * @var Generic\Biblioteka\Katalog
	 */
	protected $katalog;

	/**
	 * @var Array
	 */
	protected $listaGalerii = array();


	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'aktualnosciFormularz');
        $this->formularz->otworzZakladke('glowna');
		$this->formularz->input(new Input\Text('tytul', '', array(
			'atrybuty' => array('style' => 'width: 90%;', 'maxlength' => 255),
			'wymagany' => true,
		)));
		$this->formularz->tytul->dodajWalidator(new Walidator\NiePuste);
		$this->formularz->tytul->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\TextArea('zajawka', '', array(
			'atrybuty' => array('style' => 'height: 100px; width: 90%;', 'maxlength' => 1000),
		)));
		$this->formularz->zajawka->dodajWalidator(new Walidator\NiePuste);
		$this->formularz->zajawka->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		if ($this->katalog->doZapisu())
		{

            $kategorieMapper = new \Generic\Model\Kategoria\Mapper();
            $kategoriaCropper = $kategorieMapper->pobierzDlaModulu('CropperZdjec');

            $linkCropper = '';
            $prefix = ($this->konfiguracja['formularz.prefix_zdjecia'] != '') ? $this->konfiguracja['formularz.prefix_zdjecia'].'-' : '';
            $prefix_miniaturki = ($this->konfiguracja['formularz.prefix_miniaturki_zdjecia'] != '') ? $this->konfiguracja['formularz.prefix_miniaturki_zdjecia'].'-' : '';
            if (isset($kategoriaCropper[0]) && $kategoriaCropper[0] instanceof \Generic\Model\Kategoria\Obiekt && $this->obiekt->id > 0)
            {
                $zdjecieDoCroppera = Cms::inst()->url('aktualnosci', $this->obiekt->id).'/'. $prefix.trim($this->obiekt->zdjecieGlowne);
                $sciezkaZdjecia = Cms::inst()->katalog('aktualnosci', $this->obiekt->id);

                $linkCropper = Router::urlAjax('Http', $kategoriaCropper[0], 'formularz', array(
                    'obraz' => urlencode(zakoduj($zdjecieDoCroppera, Cms::inst()->config['cropper']['klucz_szyfrowania'])),
                    'sciezka' => urlencode(zakoduj($sciezkaZdjecia, Cms::inst()->config['cropper']['klucz_szyfrowania'])),
                ));
            }

			$this->formularz->input(new Input\ZdjecieCropowane('zdjecieGlowne', '', array(
				'wartosc' => array('name' => (($this->obiekt->zdjecieGlowne != '') ? $prefix.$this->obiekt->zdjecieGlowne : '')),
				'sciezka_plikow' => Cms::inst()->url('aktualnosci', $this->obiekt->id).'/',
				'link_usun' => (($this->obiekt->id > 0) ? Router::urlAdmin($this->kategoriaLinkow, 'usunZdjecie', array('id' => $this->obiekt->id)) : ''),
				'link_miniaturka' => ($this->obiekt->zdjecieGlowne != '') ? $prefix_miniaturki.$this->obiekt->zdjecieGlowne : '',
				//'link_popraw_miniaturke' => (($this->obiekt->id > 0) ? Router::urlAdmin($this->kategoriaLinkow, 'poprawMiniaturke', array('id' => $this->obiekt->id, 'kod' => '{KOD}', 'x1' => '{X1}', 'x2' => '{X2}', 'y1' => '{Y1}', 'y2' => '{Y2}')) : ''),
				'link_popraw_miniaturke' => $linkCropper,
				'rozmiary_miniaturek' => $this->konfiguracja['rozmiary_miniaturek'],
			)));
			$this->formularz->zdjecieGlowne->dodajWalidator(new Walidator\PoprawnyUpload());
			$this->formularz->zdjecieGlowne->dodajWalidator(new Walidator\RozszerzeniePliku($this->konfiguracja['formularz.dozwolone_formaty_zdjec']));
		}

		$this->formularz->input(new Input\TextArea('tresc', '', array(
			'ckeditor' => true,
			'ckeditor_przelacznik' => true,
		)));
		$this->formularz->tresc->dodajFiltr('filtr_xss', 'trim');
		$this->formularz->tresc->dodajWalidator(new Walidator\NiePuste);

		$this->formularz->input(new Input\Text('autor', '', array(
			'atrybuty' => array('maxlength' => 255),
		)));
        $this->formularz->autor->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

        $this->formularz->input(new Input\Text('autorZdjec', '', array(
            'atrybuty' => array('maxlength' => 255),
        )));
        $this->formularz->autorZdjec->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\Checkbox('priorytetowa'));
        $this->formularz->priorytetowa->dodajFiltr('boolval');

		$this->formularz->input(new Input\Checkbox('publikuj'));
        $this->formularz->publikuj->dodajFiltr('boolval');

		$this->formularz->input(new Input\DataCzasSelect('dataDodania', '', array('wartosc' => $this->tlumaczenia['etykieta_data_wybierz'])));
		$this->formularz->dataDodania->dodajWalidator(new Walidator\DataCzasIso());
		//$this->formularz->dataDodania->dodajWalidator(new Walidator\MniejszeOd(date("Y-m-d H:i:s"),true));

		$this->formularz->input(new Input\DataCzasSelect('dataWaznosci', '', array('wartosc' => $this->tlumaczenia['etykieta_data_wybierz'])));
		$this->formularz->dataWaznosci->dodajWalidator(new Walidator\DataCzasIso);

		if (count($this->listaGalerii) > 0)
		{
			$this->formularz->input(new Input\Select('idGalerii', '', array(
				'lista' => $this->listaGalerii,
				'wybierz' => $this->tlumaczenia['etykieta_select_wybierz']
			)));
		}
		$this->formularz->zamknijZakladke('glowna');

		if($this->obiekt->id > 0)
        {
            $this->formularz->otworzZakladke('pliki');

            $zalaczniki = $this->obiekt->pobierzZalaczniki();
            $listaZalacznikow = [];
            /**
             * @var Obiekt $zalacznik
             */
            foreach ($zalaczniki as $zalacznik)
            {
                $listaZalacznikow[$zalacznik->id] = [
                    'id' => $zalacznik->id,
                    'kod' => $zalacznik->file,
                    'nazwa' => $zalacznik->file,
                    'rozmiar'=> $zalacznik->rozmiar,
                    'opis'=> $zalacznik->opis
                ];
            }

            $this->formularz->input(new Input\MultiUploadPlikow('zalaczniki', array(
                'lista' => $listaZalacznikow,
                'url_upload' => Router::urlAjax('Admin', $this->kategoriaLinkow, 'zapiszPlik'),
                'url_usun' => Router::urlAjax('Admin', $this->kategoriaLinkow, 'usunPlik'),
                'url_plikow' => Cms::inst()->url('aktualnosci', $this->obiekt->id),
                'prefix' => 's',
                'max_wielkosc_pliku' => 50000000,
                'dozwolone_rozszerzenia' => ['pdf', 'xls', 'xlsx', 'doc', 'docs'],
            )));

            $this->formularz->zamknijZakladke('pliki');
        }


		$this->formularz->stopka(new Input\Submit('zapisz'));
		$this->formularz->stopka(new Input\Button('wstecz', '', array(
			'atrybuty' => array('onclick' => 'window.location = \''.Router::urlAdmin($this->kategoriaLinkow, 'index').'\'' )
		)));

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}

	public function wypelniony()
	{
		$czyWypelniony = parent::wypelniony();

		if ($czyWypelniony)
		{
			if($this->formularz->dataWaznosci->pobierzWartosc() != '' && $this->formularz->dataWaznosci->pobierzWartosc() != '0000-00-00 00:00:00')
			{
				$this->formularz->dataWaznosci->dodajWalidator(new Walidator\WiekszeOd($this->formularz->dataDodania->pobierzWartosc(), true));
			}
		}

		return $czyWypelniony;
	}


	/**
	 * @return \Generic\Formularz\Aktualnosc\Edycja
	 */
	public function ustawWartosciDomyslneObiektu()
	{
		foreach ($this->formularz as $nazwaPola => $input)
		{
			if ($nazwaPola == 'zdjecieGlowne') continue;
			$input->ustawWartosc($this->obiekt->$nazwaPola);
		}

		return $this;
	}


	/**
	 * @return \Generic\Formularz\Aktualnosc\Edycja
	 */
	public function ustawKatalog(Katalog $katalog)
	{
		$this->katalog = $katalog;

		return $this;
	}


	/**
	 * @return \Generic\Formularz\Aktualnosc\Edycja
	 */
	public function ustawListeGalerii(Array $lista)
	{
		$this->listaGalerii = $lista;

		return $this;
	}
}
