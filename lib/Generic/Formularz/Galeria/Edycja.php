<?php
namespace Generic\Formularz\Galeria;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Cms;
use Generic\Model\GaleriaZdjecie;

class Edycja extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'galeria_form');

		if ($this->obiekt->id >0)
		{
			$this->formularz->otworzZakladke('zdjecia', 'Zdjęcia');

            $zdjeciaMapper = new GaleriaZdjecie\Mapper();
            $zdjeciaSorter = new GaleriaZdjecie\Sorter('pozycja');
            $zdjecia = $zdjeciaMapper->pobierzDlaGalerii($this->obiekt->id, null, $zdjeciaSorter);

            $kategorieMapper = new \Generic\Model\Kategoria\Mapper();
            $kategoriaCropper = $kategorieMapper->pobierzDlaModulu('CropperZdjec');

            $cms = Cms::inst();
            $lista_zdjec = [];
            /**
             * @var GaleriaZdjecie\Obiekt $zdjecie
             */
            foreach($zdjecia as $zdjecie)
            {
                $zdjecieDoCroppera = $cms->url('galeria' , $this->obiekt->id).'/'.$zdjecie->nazwaPliku;
                $sciezkaZdjecia = $cms->katalog('galeria' , $this->obiekt->id);

                $linkCropper = Router::urlAjax('Http', $kategoriaCropper[0], 'formularz', array(
                    'obraz' => urlencode(zakoduj($zdjecieDoCroppera, $cms->config['cropper']['klucz_szyfrowania'])),
                    'sciezka' => urlencode(zakoduj($sciezkaZdjecia, $cms->config['cropper']['klucz_szyfrowania'])),
                ));

                $lista_zdjec[$zdjecie->nazwaPliku] = array(
                    'id' => $zdjecie->id,
                    'zdjecie_id' => $zdjecie->id,
                    'tytul' => $zdjecie->tytul,
                    'opis' => $zdjecie->opis,
                    'autor' => $zdjecie->autor,
                    'kod' => $zdjecie->nazwaPliku,
                    'nazwa' => $zdjecie->nazwaPliku,
                    'rozmiar' => 88888,
                    'linkPoprawMiniature' => $linkCropper
                );
            }
			$this->formularz->input(new Input\MultiUploadZdjec( 'zdjecia', array(
                    'lista' => [],
                    'url_upload' => Router::urlAjax('Admin', $this->kategoriaLinkow, 'zapiszPlik', array('idGalerii' => $this->obiekt->id)),
                    'url_plikow' => $this->konfiguracja['urlZalacznikow'],
                    'url_usun' => Router::urlAjax('Admin', $this->kategoriaLinkow, 'usunPlik' ,array('idGalerii' =>  $this->obiekt->id)),
                    'prefix' => 'min',
                    'lista' => $lista_zdjec,
                    'wyswietlaj_drop_area' => 0,
                    'rozmiary_miniaturek' => $this->konfiguracja['kody_miniatur'],
                    'dozwolone_rozszerzenia' => $this->konfiguracja['formularz.dozwolone_formaty_zdjec'],
                )
            ));
            $this->formularz->zamknijZakladke('zdjecia');
		}

		$this->formularz->otworzZakladke('dane_opisowe');

		$this->formularz->input(new Input\Text('nazwa', array(
			'atrybuty' => array('maxlength' => 255),
		)));
		$this->formularz->nazwa->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\TextArea('opis', array(
			'atrybuty' => array('rows' => 5, 'cols' => 60, ),
			'atrybuty' => array('maxlength' => 1000),
		)));
		$this->formularz->opis->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\Text('autor', array(
			'atrybuty' => array('maxlength' => 128),
		)));
		$this->formularz->autor->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		/**  START ZDJECE GLOWNE */
        $kategorieMapper = new \Generic\Model\Kategoria\Mapper();
        $kategoriaCropper = $kategorieMapper->pobierzDlaModulu('CropperZdjec');

        $linkCropper = '';
        $prefix = (isset($this->konfiguracja['formularz.prefix_zdjecia'])) ? $this->konfiguracja['formularz.prefix_zdjecia'].'-' : '';
        $prefix_miniaturki = (isset($this->konfiguracja['formularz.prefix_miniaturki_zdjecia'])) ? $this->konfiguracja['formularz.prefix_miniaturki_zdjecia'].'-' : '';
        if (isset($kategoriaCropper[0]) && $kategoriaCropper[0] instanceof \Generic\Model\Kategoria\Obiekt && $this->obiekt->id > 0)
        {
            $zdjecieDoCroppera = Cms::inst()->url('galeria', $this->obiekt->id).'/'. $prefix.trim($this->obiekt->zdjecieGlowne);
            $sciezkaZdjecia = Cms::inst()->katalog('galeria', $this->obiekt->id);

            $linkCropper = Router::urlAjax('Http', $kategoriaCropper[0], 'formularz', array(
                'obraz' => urlencode(zakoduj($zdjecieDoCroppera, Cms::inst()->config['cropper']['klucz_szyfrowania'])),
                'sciezka' => urlencode(zakoduj($sciezkaZdjecia, Cms::inst()->config['cropper']['klucz_szyfrowania'])),
            ));
        }

        $this->formularz->input(new Input\ZdjecieCropowane('zdjecieGlowne', '', array(
            'wartosc' => array('name' => (($this->obiekt->zdjecieGlowne != '') ? $prefix.$this->obiekt->zdjecieGlowne : '')),
            'sciezka_plikow' => Cms::inst()->url('galeria', $this->obiekt->id).'/',
            'link_usun' => (($this->obiekt->id > 0) ? Router::urlAdmin($this->kategoriaLinkow, 'usunZdjecie', array('id' => $this->obiekt->id, 'glowne' => 1)) : ''),
            'link_miniaturka' => ($this->obiekt->zdjecieGlowne != '') ? $prefix_miniaturki.$this->obiekt->zdjecieGlowne : '',
            //'link_popraw_miniaturke' => (($this->obiekt->id > 0) ? Router::urlAdmin($this->kategoriaLinkow, 'poprawMiniaturke', array('id' => $this->obiekt->id, 'kod' => '{KOD}', 'x1' => '{X1}', 'x2' => '{X2}', 'y1' => '{Y1}', 'y2' => '{Y2}')) : ''),
            'link_popraw_miniaturke' => $linkCropper,
            'rozmiary_miniaturek' => $this->konfiguracja['kody_miniatur'],
        )));
        $this->formularz->zdjecieGlowne->dodajWalidator(new Walidator\PoprawnyUpload());
        $this->formularz->zdjecieGlowne->dodajWalidator(new Walidator\RozszerzeniePliku($this->konfiguracja['formularz.dozwolone_formaty_zdjec']));
        /** koniec zdjecie glowne */

		$this->formularz->input(new Input\Checkbox('publikuj'));
		$this->formularz->publikuj->dodajFiltr('intval','abs');

		$this->formularz->zamknijZakladke('dane_opisowe');

		$this->formularz->stopka(new Input\Submit('zapisz'));
		$this->formularz->stopka(new Input\Button('wstecz', '', array(
			'atrybuty' => array('onclick' => 'window.location = \''.Router::urlAdmin($this->kategoriaLinkow, 'index').'\'' )
		)));

		foreach ($this->formularz as $nazwaInputa => $input)
		{
			if (in_array($nazwaInputa, $this->konfiguracja['wymagane_pola']))
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