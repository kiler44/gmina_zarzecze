<?php
namespace Generic\Formularz\Tlumaczenie;
use Generic\Biblioteka\Formularz;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Modul;
use Generic\Model\DostepnyModul;

class Edycja extends \Generic\Formularz\Abstrakcja
{

	/**
	 * @var \Generic\Biblioteka\Szablon
	 */
	protected $szablon;


	/**
	 * @var Array
	 */
	protected $zakladki;


	/**
	 * @var String
	 */
	protected $urlCzysc;


	/**
	 * @var String
	 */
	protected $linkCzysc;


	/**
	 * @var Array
	 */
	protected $nazwy;


	protected function generujFormularz()
	{
		$cms = Cms::inst();

		$this->formularz = new Formularz('', 'edycja');

		// pobranie konfiguracji domyslnej dla edytowanego modulu
		$kodModulu = Zadanie::pobierz('kod', 'strval', 'trim');

		if ($this->obiekt instanceof Kategoria\Obiekt && $this->obiekt->modul instanceof DostepnyModul\Obiekt)
		{
			$kodModulu = $this->obiekt->modul->kod;
		}

		foreach ($this->zakladki as $usluga => $tlumaczenia)
		{
			$opis_uslugi = (isset($cms->lang['uslugi'][$usluga])) ? $cms->lang['uslugi'][$usluga] : $usluga;
			$this->formularz->otworzZakladke($usluga, $opis_uslugi);

			foreach ($tlumaczenia as $klucz => $pole)
			{
				$nazwa = str_replace(array('.', '-'), '_', $usluga.'_'.$klucz);
				$this->nazwy[$nazwa] = $klucz;
				$wartosc = $pole['wartosc'];
				$wartoscDomyslna = null;
				$opis = '';

				if ($kodModulu != '' && isset($pole['klucz_baza']) && $pole['klucz_baza'] != '' && $this->urlCzysc != '')
				{
					$klasaModulu = "Generic\\Modul\\" . $kodModulu . "\\" . $usluga;
					$modul = new $klasaModulu();

					// weryfikacja modulu
					if($modul instanceof Modul)
					{
						$tlumaczeniaDomyslneModulu = $modul->pobierzTlumaczenia();
					}
					else
					{
						trigger_error("Nieprawidłowy kod modułu.", E_USER_ERROR);
						exit();
					}

					// inicjalizacja zmiennych do wyświetlenia
					$podgladTresc = $klucz . ":<br/><br/>";
					$wartoscDomyslna = $tlumaczeniaDomyslneModulu[$klucz];

					$opis = str_replace('{KOD}', $pole['klucz_baza'], $this->linkCzysc);
				}

				$klucz = (string) $klucz;


				$klasaInputa = '';

				switch ($pole['typ'])
				{
					case'array': $klasaInputa = 'Generic\\Biblioteka\\Input\\Tablica'; break;
					case'list': $klasaInputa = 'Generic\\Biblioteka\\Input\\Lista'; break;
					case'text': $klasaInputa = 'Generic\\Biblioteka\\Input\\TextArea'; break;
					default: {
						if (is_array($wartosc))
						{
							$klasaInputa = 'Generic\\Biblioteka\\Input\\Tablica';
						}
						else
						{
							$klasaInputa = 'Generic\\Biblioteka\\Input\\Text';
						}
					} break;
				}


				$this->formularz->input(new $klasaInputa($nazwa, $klucz, array(
					'wymagany' => true,
					'wartosc' => $wartosc,
					'dodawanie_wierszy' => true,
				), $opis));

				// ustawienie podgladu wartosci domyslnych
				if(isset($wartoscDomyslna))
				{
					$inputClone = clone $this->formularz->$nazwa;
					$inputClone->ustawWartosc($wartoscDomyslna);
					$inputClone->ustawNazwe(md5($inputClone->pobierzNazwe()));
					$podgladTresc .= $inputClone->pobierzHtml();

					// generowanie linku z podgladem
					$linkPodglad = $this->szablon->parsujBlok('/podgladWartosciDomyslnej', array(
						'id' => 'nyro_' . $nazwa,
						'etykieta_link_podglad' => 'Podgląd',
						'podglad_tresc' => $podgladTresc,
					));

					$opisTmp = $this->formularz->$nazwa->pobierzOpis();
					$this->formularz->$nazwa->ustawOpis($linkPodglad . $opisTmp);
				}

			}
			$this->formularz->zamknijZakladke($usluga);
		}

		$this->formularz->stopka(new Input\Submit('zapisz'));
		if ($this->urlPowrotny != '')
		{
			$this->formularz->stopka(new Input\Button('wstecz', array(
				'atrybuty' => array('onclick' => 'window.location = \'' . $this->urlPowrotny . '\'')
			)));
		}


		$this->formularz->ustawTlumaczenia($this->tlumaczenia);
	}


	/**
	 * @return \Generic\Formularz\Tlumaczenie\Edycja
	 */
	public function ustawSzablon(\Generic\Biblioteka\Szablon $szablon)
	{
		$this->szablon = $szablon;

		return $this;
	}


	/**
	 * @return \Generic\Formularz\Tlumaczenie\Edycja
	 */
	public function ustawZakladki(Array $zakladki)
	{
		$this->zakladki = $zakladki;

		return $this;
	}


	/**
	 * @return \Generic\Formularz\Tlumaczenie\Edycja
	 */
	public function ustawUrlCzysc($url)
	{
		$this->urlCzysc = $url;

		return $this;
	}


	/**
	 * @return \Generic\Formularz\Tlumaczenie\Edycja
	 */
	public function ustawLinkCzysc($url)
	{
		$this->linkCzysc = $url;

		return $this;
	}


	/**
	 * @return \Generic\Formularz\Tlumaczenie\Edycja
	 */
	public function ustawNazwy(&$nazwy)
	{
		$this->nazwy = &$nazwy;

		return $this;
	}
}