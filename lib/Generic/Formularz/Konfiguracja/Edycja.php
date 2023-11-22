<?php
namespace Generic\Formularz\Konfiguracja;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Walidator;
use Generic\Biblioteka\Cms;
use Generic\Modul\EmailZarzadzanie;
use Generic\Biblioteka\Modul;

class Edycja extends \Generic\Formularz\Abstrakcja
{
	/**
	 * @var Array;
	 */
	protected $zakladki;


	/**
	 * @var Array;
	 */
	protected $nazwyPol = array();


	/**
	 * @var string
	 */
	protected $urlCzysc;


	/**
	 * @var string
	 */
	protected $linkCzysc;


	/**
	 * @var string
	 */
	protected $linkPodglad;




	protected function generujFormularz()
	{
		$this->formularz = new Formularz('', 'edycjaKonfiguracji');

		foreach ($this->zakladki as $usluga => $konfiguracja)
		{
			$this->formularz->otworzZakladke($usluga, Cms::inst()->lang['uslugi'][$usluga]);

			$otwartyRegion = '';

			foreach ($konfiguracja as $klucz => $pole)
			{
				if (isset($pole['systemowy']) && !in_array('opcjeSystemowe', $this->uprawnienia)) continue;

				$nazwa = str_replace(array('.', '-'), '_', $usluga.'_'.$klucz);
				$this->nazwyPol[$nazwa] = $klucz;
				$wartosc = (isset($pole['wartosc'])) ? $pole['wartosc'] : '';
				$wartoscDomyslna = null;
				$etykieta = (isset($pole['etykieta'])) ? nl2br($pole['etykieta']) : $klucz;
				$opis = (isset($pole['opis'])) ? nl2br($pole['opis']) : '';
				if (isset($pole['klucz_baza']) && $pole['klucz_baza'] != '' && $this->urlCzysc != '')
				{
					// pobranie konfiguracji domyslnej dla edytowanego modulu
					$kodModulu = $konfiguracja[$klucz]['kod_modulu'];
					$klasaModulu = "Generic\\Modul\\" . $kodModulu . "\\" . $usluga;
					$modul = new $klasaModulu();

					// weryfikacja modulu
					if ($modul instanceof Modul)
					{
						$konfiguracjaDomyslnaModulu = $modul->pobierzKonfiguracje();
					}
					else
					{
						trigger_error("Nieprawidłowy kod modułu.", E_USER_ERROR);
						exit();
					}

					// inicjalizacja zmiennych do wyświetlenia
					$podgladTresc = "";
					$wartoscDomyslna = $konfiguracjaDomyslnaModulu[$klucz];

					$opis = str_replace('{KOD}', $pole['klucz_baza'], $this->linkCzysc) .$opis;
				}
				if (!isset($pole['typ']))
				{
					$pole['typ'] = (is_array($wartosc)) ? 'array' : 'varchar';
				}
				if (isset($pole['maks']) && $pole['maks'] > 0)
					$maxlength = array('maxlength' => $pole['maks']);
				else
					$maxlength = array();

				switch ($pole['typ'])
				{
					case 'region':
						if ($otwartyRegion != '') $this->formularz->zamknijRegion($otwartyRegion);
						$this->formularz->otworzRegion($nazwa, $etykieta);
						$otwartyRegion = $nazwa;
					break;

					case 'varchar':
						$this->formularz->input(new Input\Text($nazwa, $etykieta, array(
							'atrybuty' => array_merge(array('class' => 'dlugiePole'), $maxlength),
						), $opis));
					break;

					case 'text':
						$this->formularz->input(new Input\TextArea($nazwa, $etykieta, array(
							'atrybuty' => array_merge(array('rows' => 10, 'cols' => 110), $maxlength),
						), $opis));
					break;

					case 'html':
						$this->formularz->input(new Input\TextArea($nazwa, $etykieta, array(
							'ckeditor' => true,
						), $opis));
					break;

					case 'pager':
						$this->formularz->input(new Input\Pager($nazwa, $etykieta, array(), $opis));
					break;

					case 'mail':
						$listaMaili = EmailZarzadzanie\Admin::listaFormatek();
						if (is_array($listaMaili) && count($listaMaili) > 0)
							$this->formularz->input(new Input\Select($nazwa, $etykieta, array('lista' => $listaMaili), $opis));
						else
							$this->formularz->input(new Input\Text($nazwa, $etykieta, array(), $opis));
						$this->formularz->$nazwa->dodajFiltr('intval');
					break;

					case 'miniatury':
						$this->formularz->input(new Input\Miniatury($nazwa, $etykieta, array(), $opis));
					break;

					case 'int':
						$this->formularz->input(new Input\Text($nazwa, $etykieta, array(), $opis));
						$this->formularz->$nazwa->dodajFiltr('intval');
					break;

					case 'float':
						$this->formularz->input(new Input\Text($nazwa, $etykieta, array(), $opis));
						$this->formularz->$nazwa->dodajFiltr('floatval');
					break;

					case 'select':
						if (isset($pole['dozwolone']))
						{
							$this->formularz->input(new Input\Select($nazwa, $etykieta, array('lista' => array_combine($pole['dozwolone'], $pole['dozwolone'])), $opis));
						}
						else
						{
							$this->formularz->input(new Input\Text($nazwa, $etykieta, array(), $opis));
						}
					break;

					case 'array':
						$this->formularz->input(new Input\Tablica($nazwa, $etykieta, array('dodawanie_wierszy' => true), $opis));
					break;

					case 'list':
						$this->formularz->input(new Input\Lista($nazwa, $etykieta, array('dodawanie_wierszy' => true), $opis));
					break;

					case 'bool':
						$this->formularz->input(new Input\Checkbox($nazwa, $etykieta, array(), $opis));
					break;
				}

				if ($pole['typ'] != 'region')
				{
					if (isset($wartoscDomyslna))
					{
						$inputClone;

						if ($pole['typ'] == 'html')
						{
							$inputClone = new Input\Html($nazwa);
						}
						else
						{
							$inputClone = clone $this->formularz->$nazwa;
						}


						$inputClone->ustawWartosc($wartoscDomyslna);
						$inputClone->ustawNazwe(md5($inputClone->pobierzNazwe()));
						$podgladTresc .= $inputClone->pobierzHtml();

						// generowanie linku z podgladem
						$linkPodglad = str_replace(array('{NAZWA}', '{TRESC}'), array($nazwa, $podgladTresc), $this->linkPodglad);

						$opisTmp = $this->formularz->$nazwa->pobierzOpis();
						$this->formularz->$nazwa->ustawOpis($linkPodglad . $opisTmp);
					}

					$this->formularz->$nazwa->ustawWartosc($wartosc);
				}

				if (isset($pole['dozwolone']))
				{
					$this->formularz->$nazwa->dodajWalidator(new Walidator\DozwoloneWartosci($pole['dozwolone']));
				}
				if (isset($pole['maks']))
				{
					switch ($pole['typ'])
					{
						case 'varchar':
						case 'text':
						case 'html':
							$this->formularz->$nazwa->dodajWalidator(new Walidator\KrotszeOd($pole['maks'], true));
						break;

						case 'int':
						case 'float':
							$this->formularz->$nazwa->dodajWalidator(new Walidator\MniejszeOd($pole['maks'], true));
						break;
					}
				}
			}
			if ($otwartyRegion != '') $this->formularz->zamknijRegion($otwartyRegion);

			$this->formularz->zamknijZakladke($usluga);
		}

		$this->formularz->stopka(new Input\Submit('zapisz', '', array(
			'wartosc' => $this->tlumaczenia['etykieta_zapisz']
		)));
		if ($this->urlPowrotny != '')
		{
			$this->formularz->stopka(new Input\Button('wstecz', '', array(
				'wartosc' => $this->tlumaczenia['etykieta_wstecz'],
				'atrybuty' => array('onclick' => 'window.location = \''.$this->urlPowrotny.'\'' )
			)));
		}

		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * return \Generic\Formularz\Konfiguracja\Edycja
	 */
	public function ustawZakladki(Array $zakladki)
	{
		$this->zakladki = $zakladki;

		return $this;
	}


	/**
	 * return \Generic\Formularz\Konfiguracja\Edycja
	 */
	public function ustawUrlCzysc($urlCzysc)
	{
		$this->urlCzysc = $urlCzysc;

		return $this;
	}


	/**
	 * return \Generic\Formularz\Konfiguracja\Edycja
	 */
	public function ustawLinki($linkCzysc, $linkPodglad)
	{
		$this->linkCzysc = $linkCzysc;
		$this->linkPodglad = $linkPodglad;

		return $this;
	}


	/**
	 * return Array
	 */
	public function pobierzNazwyPol()
	{
		return $this->nazwyPol;
	}

}