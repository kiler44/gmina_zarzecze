<?php
namespace Generic\Formularz\StronaOpisowa;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Router;
use Generic\Model\Zalacznik\Obiekt;

class Edycja extends \Generic\Formularz\Abstrakcja
{
	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'stronaEdycja');

        $this->formularz->otworzZakladke('glowna');
		$this->formularz->input(new Input\Text('tytul', array(
			'wartosc' => $this->obiekt->tytul,
			'atrybuty' => array('style' => 'width: 90%;')
		)));
		$this->formularz->tytul->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\TextArea('tresc', array(
			'wartosc' => $this->obiekt->tresc,
			'ckeditor' => true,
			'ckeditor_przelacznik' => true,
			'atrybuty' => array('style' => 'width: 90%;'),
		)));
		$this->formularz->tresc->dodajFiltr('filtr_xss', 'trim');
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
                'url_plikow' => Cms::inst()->url('strona_opisowa', $this->obiekt->id),
                'prefix' => 's',
                'max_wielkosc_pliku' => 50000000,
                'dozwolone_rozszerzenia' => ['pdf', 'xls', 'xlsx', 'doc', 'docs', 'jpg', 'jpeg', 'png'],
            )));

            $this->formularz->zamknijZakladke('pliki');
        }

		$this->formularz->stopka(new Input\Submit('zapisz', '', array(
			'wartosc' => $this->tlumaczenia['button_zapisz']
		)));


		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}
}