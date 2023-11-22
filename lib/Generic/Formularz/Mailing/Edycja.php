<?php
namespace Generic\Formularz\Mailing;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Cms;

class Edycja extends \Generic\Formularz\Abstrakcja
{
	protected $celFormularza;


	protected $tylkoPodglad;


	protected $wykonywanaAkcja;


	protected function generujFormularz()
	{
		$this->formularz = new Formularz($this->celFormularza, 'mailing_formularz');

		$this->formularz->input(new Input\Text('nazwa'));
		$this->formularz->nazwa->dodajFiltr('strip_tags', 'filtr_xss', 'trim');
		$this->formularz->nazwa->dodajWalidator(new Walidator\NiePuste);
		$this->formularz->nazwa->wymagany = true;

		$this->formularz->input(new Input\Text('nazwaNadawcy', array('wartosc' => $this->obiekt->nazwaNadawcy == '' ? Cms::inst()->config['email']['from_name'] : $this->obiekt->nazwaNadawcy)));
		$this->formularz->nazwaNadawcy->dodajFiltr('strip_tags', 'filtr_xss', 'trim');
		$this->formularz->nazwaNadawcy->dodajWalidator(new Walidator\NiePuste);
		$this->formularz->nazwaNadawcy->wymagany = true;

		$this->formularz->input(new Input\Text('emailNadawcy', array('wartosc' => $this->obiekt->emailNadawcy == '' ? Cms::inst()->config['email']['from'] : $this->obiekt->emailNadawcy)));
		$this->formularz->emailNadawcy->dodajFiltr('strip_tags', 'filtr_xss', 'trim');
		$this->formularz->emailNadawcy->dodajWalidator(new Walidator\NiePuste);
		$this->formularz->emailNadawcy->dodajWalidator(new Walidator\Email());
		$this->formularz->emailNadawcy->wymagany = true;

		$this->formularz->input(new Input\Text('tytul'));
		$this->formularz->tytul->dodajFiltr('strip_tags', 'filtr_xss', 'trim');
		$this->formularz->tytul->dodajWalidator(new Walidator\NiePuste);
		$this->formularz->tytul->wymagany = true;

		$this->formularz->input(new Input\TextArea('tresc'));
		$this->formularz->tresc->dodajFiltr('strip_tags', 'filtr_xss', 'trim');

		$this->formularz->input(new Input\TextArea('trescHtml', array(
			'ckeditor' => true
		)));
		$this->formularz->trescHtml->dodajFiltr('filtr_xss', 'trim');

		$this->formularz->input(new Input\Checkbox('zaladujSzablon'));

		$this->formularz->input(new Input\Checkbox('pominSprawdzanieZgody'));

		$this->formularz->input(new Input\DataCzasSelect('dataWysylki', array (
			'datepicker' => true,
		)));
		$this->formularz->dataWysylki->dodajFiltr('strip_tags', 'filtr_xss', 'trim');
		$this->formularz->dataWysylki->dodajWalidator(new Walidator\DataCzasIso);
		$this->formularz->dataWysylki->wymagany = true;

		$this->formularz->input(new Input\Plik('plikZLista'));
		$this->formularz->plikZLista->dodajWalidator(new Walidator\PoprawnyUpload(true));
		$this->formularz->plikZLista->dodajWalidator(new Walidator\RozszerzeniePliku(array('csv')));
		$this->formularz->plikZLista->wymagany = true;

		$this->formularz->input(new Input\Text('emailTestowy'));
		$this->formularz->emailTestowy->dodajFiltr('strip_tags', 'filtr_xss', 'trim');
		if (Zadanie::pobierz('wysylkaTestowa') == 'TAK')
		{
			$this->formularz->emailTestowy->dodajWalidator(new Walidator\NiePuste);
			$this->formularz->emailTestowy->dodajWalidator(new Walidator\Email());
			$this->formularz->emailTestowy->wymagany = true;
		}

		if ( ! $this->tylkoPodglad)
			$this->formularz->stopka(new Input\Submit('zapisz'));

		$this->formularz->stopka(new Input\Button('wstecz', array(
			'atrybuty' => array('onclick' => 'window.location = \''.$this->urlPowrotny.'\'' )
		)));


		$formularzAkcjaTest = Router::urlAdmin('Mailing',$this->wykonywanaAkcja, Zadanie::pobierz('id', 'intval', 'abs')>0 ? array('wysylkaTestowa' => 'TAK', 'id' => Zadanie::pobierz('id', 'intval', 'abs')) : array('wysylkaTestowa' => 'TAK'));
		$formularzAkcjaPobierzRaport = Router::urlAdmin('Mailing','pobierzRaport', array('id' => Zadanie::pobierz('id', 'intval', 'abs')));

		$this->formularz->stopka(new Input\Button('wyslijTestowo', array(
			'atrybuty' => array('onclick' => 'document.getElementById(\'mailing_formularz\').action = \''.$formularzAkcjaTest.'\'; document.getElementById(\'mailing_formularz\').submit();' )
		)));

		if ($this->tylkoPodglad)
		{
			$this->formularz->stopka(new Input\Button('pobierzRaport', array(
				'atrybuty' => array('onclick' => 'document.location.href=\''.$formularzAkcjaPobierzRaport.'\';' )
			)));
		}

		foreach ($this->formularz as $nazwaInputa => $input)
		{
			$wartosc = $input->pobierzWartoscPoczatkowa();
			if (!empty($wartosc) || $wartosc === 0 || $nazwaInputa == 'emailTestowy') continue;
			$this->formularz->$nazwaInputa->ustawWartosc($this->obiekt->$nazwaInputa);
		}

		if ($this->formularz->dataWysylki->pobierzWartosc() == '')
		{
			$data = new \DateTime('+ 1 day', new \DateTimeZone('Europe/Warsaw'));
			$this->formularz->dataWysylki->ustawWartosc($data->format('Y-m-d 03:00:00'));
		}


		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * @return \Generic\Formularz\Mailing\Edycja
	 */
	public function ustawCelFormularza($cel)
	{
		$this->celFormularza = $cel;

		return $this;
	}



	/**
	 * @return \Generic\Formularz\Mailing\Edycja
	 */
	public function ustawTylkoPodglad($czyPodglad)
	{
		$this->tylkoPodglad = $czyPodglad;

		return $this;
	}



	/**
	 * @return \Generic\Formularz\Mailing\Edycja
	 */
	public function ustawWykonywanaAkcja($akcja)
	{
		$this->wykonywanaAkcja = $akcja;

		return $this;
	}

}