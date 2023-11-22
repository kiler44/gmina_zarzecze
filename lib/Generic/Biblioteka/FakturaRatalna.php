<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\Faktura;
use Generic\Biblioteka\Cms;
use Generic\Model\Uzytkownik;
use Generic\Model\Dokument;
use Generic\Model\DokumentSzablon;
use Generic\Biblioteka\LiczbaSlownie;
use Generic\Biblioteka\Szablon;


/**
 * Obsluga generowania faktur ratalnych w systemie
 *
 * @author Konrad Rudowski
 * @package biblioteki
 */

class FakturaRatalna extends Faktura
{

	/**
	 * Id szablonu faktury raty.
	 *
	 * @var int
	 */
	protected $_idSzablonuRaty = 0;


	/**
	 * Dane rat w postaci tablicy
	 *
	 * @var Array
	 */
	protected $_daneRat = array();


	/**
	 * Wynikowe dane rat w postaci tablicy
	 *
	 * @var Array
	 */
	protected $_daneRatPrzeliczone = array();



	/**
	 * Html faktury rat
	 *
	 * @var array
	 */
	protected $_htmlRat = array();



	/**
	 * Tytuł wstawiany do raty
	 *
	 * @var string
	 */
	protected $_fragmentTytuluRaty = 'Rata za fakturę ';



	/**
	 * Konstruktor.
	 *
	 * @param $idSzablonuFaktury Identyfikator szblonu faktury w bazie.
	 * @param $idSzablonuRaty Identyfikator szblonu raty w bazie.
	 */
	function __construct($idSzablonuFaktury = 0, $idSzablonuRaty = 0)
	{

		if ($idSzablonuFaktury > 0)
		{
			$this->_idSzablonuFaktury = $idSzablonuFaktury;
		}

		if ($idSzablonuRaty > 0)
		{
			$this->_idSzablonuRaty = $idSzablonuRaty;
		}

		$this->_dataWystawienia = new \DateTime('now', new \DateTimeZone('Europe/Warsaw'));

	}



	/**
	 * Ustawia id szablonu faktury.
	 *
	 * @param $idSzablonuRaty Identyfikator szblonu raty w bazie.
	 */
	function ustawSzablonRaty($idSzablonuRaty)
	{

		$this->_idSzablonuRaty = $idSzablonuRaty;

	}


	/**
	 * Dodaje ratę.
	 *
	 * @param $kwota
	 * @param $terminPlatnosci
	 */
	function dodajRate($kwota, $terminPlatnosci = 30)
	{

		$this->_daneRat[] = array(
			'terminPlatnosci' => $terminPlatnosci,
			'kwota' => $kwota,
			);

	}


	/**
	 * Dodaje raty (kilka na raz).
	 *
	 * Wymagany format kazdej raty:
	 * Array(
	 *	'terminPlatnosci' => wartosc,
	 *	'kwota' => wartosc
	 * )
	 *
	 * lub podane w tablicy terminy płatności
	 *
	 * @param $raty
	 */
	function ustawRaty(Array $raty)
	{
		if ( ! isset($raty[0]) || ! is_array($raty[0]) || ! isset($raty[0]['terminPlatnosci']))
		{
			foreach ($raty as $rata)
			{
				$this->_daneRat[] = array (
					'terminPlatnosci' => $rata,
					'kwota' => 0.0,
				);
			}
		}
		else
		{
			$this->_daneRat = $raty;
		}

	}


	/**
	 * Zwraca kod HTML rat w postaci tablicy
	 *
	 */
	function pobierzHtmlRat()
	{

		if (count($this->_htmlRat) < 2)
		{
			return null;
		}

		return $this->_htmlRat;
	}


	/**
	 * Zwraca dane rat w postaci tablicy
	 *
	 */
	function pobierzDaneRat()
	{

		if (count($this->_daneRatPrzeliczone) < 2)
		{
			return null;
		}

		return $this->_daneRatPrzeliczone;
	}

	/**
	 * Zapisuje dane faktury głównej do bazy danych (tabela modul_dokumenty)
	 *
	 * @return bool
	 */
	protected function zapiszDokumentyFaktury()
	{
		$cms = Cms::inst();

		if ($this->_nabywca instanceof Uzytkownik\Obiekt)
		{
			//faktura główna przy ratach ma mieć blokowane przypomnienie - zapamiętujemy wartość opcji.

			$domyslneBlokowaniePrzypomnienia = $this->_blokujPrzypomnienie;

			$this->_blokujPrzypomnienie = 1;

			parent::zapiszDokumentyFaktury();

			$this->_blokujPrzypomnienie = $domyslneBlokowaniePrzypomnienia;

			foreach ($this->_daneRatPrzeliczone as $rataPrzeliczona)
			{
				$rata = new Dokument\Obiekt();
				$rata->idProjektu = ID_PROJEKTU;
				$rata->kodJezyka = KOD_JEZYKA;
				$rata->idSzablonu = $this->_idSzablonuRaty;
				$rata->idUzytkownika = $this->_nabywca->id;
				$rata->dataDodania = $this->_dataWystawienia->format('Y-m-d H:i:s');
				$rata->sposobDostarczenia = $this->_sposobDostarczenia;
				$rata->typ = 'html';
				$rata->kod = 'faktura_rata';
				$rata->tytul = $this->_fragmentTytuluRaty . $this->_fakturaNumer;
				$rata->tresc = $this->_htmlRat[$rataPrzeliczona['nrRaty']];
				$rata->kwotaPlatnosci = $rataPrzeliczona['kwotaBrutto'];
				$rata->statusPlatnosci = $this->_statusPlatnosci;
				$rata->dostarczono = $this->_statusDostarczenia;
				$rata->idRodzica = $this->_idFakturyWBazie;
				$rata->dataPlatnosci = $rataPrzeliczona['terminPlatnosci']->format('Y-m-d');
				$rata->kodHandlowca = $this->_nabywca->wizytowka->kodHandlowca;
				if ( ! $rata->zapisz($cms->dane()->Dokument()))
				{
					trigger_error('Błąd. Niepowodzenie zapisu dokumentu raty.', E_USER_WARNING);
					return false;
				}
			}

		}
		else
		{
			trigger_error('Błąd. Nie można zapisać dokumentu, jeśli nabywca faktury nie jest obiektem.', E_USER_WARNING);
			return false;
		}

		return true;
	}


	/**
	 * Przygotowuje system do wygenerowania faktur
	 *
	 * @return bool
	 */
	protected function przygotujFakture()
	{
		$this->przygotujFaktureGlowna();

		if ( ! $this->przeliczRaty())
		{
			trigger_error('Błąd. Nie przeliczono rat.', E_USER_WARNING);
			return false;
		}

		return true;

	}

	/**
	 * Przygotowuje fakture główna
	 */
	protected function przygotujFaktureGlowna()
	{
		parent::przygotujFakture();
	}


	/**
	 * Generuje HTML faktury i przpeisuje do pola.
	 *
	 * @return bool
	 */
	protected function generujHtmlFaktury()
	{
		$cms = Cms::inst();

		if ( ! $this->przygotujFakture())
		{
			trigger_error('Błąd. Nie mogę utworzyc HTML faktury.', E_USER_WARNING);
			return false;
		}

		$szablonBaza = $cms->dane()->DokumentSzablon()->pobierzPoId($this->_idSzablonuFaktury);

		if ( ! ($szablonBaza instanceof DokumentSzablon\Obiekt))
		{
			trigger_error('Błąd. Nie odnaleziono szablonu faktury.', E_USER_WARNING);
			return false;
		}

		//Przygotowanie słownego zapisu liczby
		$slownie = new LiczbaSlownie();
		$poPrzecinku = substr(number_format($this->_calkowitaWartoscBrutto, 2, ',', ''), -2);

		//załadowanie szablonu
		$szablonProforma = new Szablon();
		$szablonProforma->ladujTresc($szablonBaza->tresc);

		//pozycje na fakturze
		foreach ($this->_pozycjeNaFakturzePrzeliczone as $pozycja)
		{
			$szablonProforma->ustawBlok('/pozycja', $pozycja);
		}

		$szablonProforma->ustawBlok('/tabelaRaty', array(
			'FAKTURA_SUMA' => number_format($this->_calkowitaWartoscBrutto, 2, ',', ''),
		));

		foreach ($this->_daneRatPrzeliczone as $rata)
		{
			$rata = $this->ustawWartosciRatyTabelka($rata);
			$szablonProforma->ustawBlok('/tabelaRaty/rata', $rata);

			if ( ! $this->generujHtmlRaty($rata))
			{
				trigger_error('Błąd. Nie utworzono faktury raty.', E_USER_WARNING);
				return false;
			}
		}

		//dane dodatkowe do faktury
		$this->_daneFaktury['FAKTURA_NUMER'] = $this->_fakturaNumer;
		$this->_daneFaktury['FAKTURA_DATA_WYSTAWIENIA'] = 	$this->_dataWystawienia->format($this->_formatDatyNaFakturze);
		$this->_daneFaktury['FAKTURA_DATA_ZAPLATY'] = $this->_terminPlatnosciData->format($this->_formatDatyNaFakturze);
		$this->_daneFaktury['FAKTURA_SUMA'] = number_format($this->_calkowitaWartoscBrutto, 2, ',', '');
		$this->_daneFaktury['FAKTURA_SUMA_SLOWNIE'] = $slownie->slownie(intval($this->_calkowitaWartoscBrutto)).' '.$poPrzecinku.'/100';

		$szablonProforma->ustaw($this->_daneFaktury);

		$this->_htmlFaktura = $szablonProforma->parsuj();

		return true;
	}


	protected function ustawWartosciRatyTabelka($rata)
	{
		$rata['RATA_NAZWA'] = 'Rata ' . $rata['nrRaty'];
		$rata['RATA_TERMIN'] = $rata['terminPlatnosci']->format($this->_formatDatyNaFakturze);

		return $rata;
	}


	/**
	 * Tworzy fakturę raty w formacie HTML
	 *
	 */
	protected function generujHtmlRaty($rata)
	{
		$cms = Cms::inst();

		$szablonBaza = $cms->dane()->DokumentSzablon()->pobierzPoId($this->_idSzablonuRaty);

		if ( ! ($szablonBaza instanceof DokumentSzablon\Obiekt))
		{
			trigger_error('Błąd. Nie odnaleziono szablonu raty.', E_USER_WARNING);
			return false;
		}

		//Przygotowanie słownego zapisu liczby
		$slownie = new LiczbaSlownie();
		$poPrzecinku = substr(number_format($rata['kwotaBrutto'], 2, ',', ''), -2);

		$szablonProforma = new Szablon();
		$szablonProforma->ladujTresc($szablonBaza->tresc);

		$rata['RATA_POZYCJA_NAZWA'] = $this->_fragmentTytuluRaty . $this->_fakturaNumer;

		$szablonProforma->ustawBlok('/pozycja', $rata);

		$daneRaty = $this->ustawWartosciRatyDokument($this->_daneFaktury, $rata);

		$daneRaty['FAKTURA_SUMA_SLOWNIE'] = $slownie->slownie(intval($rata['kwotaBrutto'])).' '.$poPrzecinku.'/100';

		$szablonProforma->ustaw($daneRaty);

		$this->_htmlRat[$rata['nrRaty']] = $szablonProforma->parsuj();

		return true;
	}

	protected function ustawWartosciRatyDokument($daneRaty, $rata)
	{
		$daneRaty['FAKTURA_NUMER'] =  $this->_fragmentTytuluRaty . $this->_fakturaNumer;
		$daneRaty['FAKTURA_DATA_WYSTAWIENIA'] = 	$this->_dataWystawienia->format($this->_formatDatyNaFakturze);
		$daneRaty['FAKTURA_DATA_ZAPLATY'] = $rata['terminPlatnosci']->format($this->_formatDatyNaFakturze);
		$daneRaty['FAKTURA_SUMA'] = number_format($rata['kwotaBrutto'], 2, ',', '');

		return $daneRaty;
	}



	/**
	 * Przelicza raty ustawiając im odpowiednie dane
	 *
	 */
	protected function przeliczRaty()
	{
		$sumaNettoRat = 0.0;
		$licznikRat = 0;
		$dataPlatnosciRat = new \DateTime($this->_dataWystawienia->format('Y-m-d'), new \DateTimeZone('Europe/Warsaw'));
		$stawkaVat = $this->_pozycjeNaFakturzePrzeliczone[0]['stawkaVat'];
		$dataPlatnosciOstatniejRaty = '';

		foreach ($this->_daneRat as $rata)
		{
			$rataPrzeliczona = array();
			if ($rata['terminPlatnosci'] instanceof \DateTime)
			{
				$dataPlatnosciRat = $rata['terminPlatnosci'];
			}
			else
			{
				switch ($rata['terminPlatnosci'])
				{
					case'7' :	$dataPlatnosciRat->modify('+1 week');	break;
					case'14' :	$dataPlatnosciRat->modify('+2 week');	break;
					case'21' :	$dataPlatnosciRat->modify('+3 week');	break;
					case'30' :	$dataPlatnosciRat->modify('+1 month');	break;
					default:	$dataPlatnosciRat = new \DateTime($rata['terminPlatnosci'], new \DateTimeZone('Europe/Warsaw')); break;
				}
			}

			if ($rata['kwota'] == 0.0)
			{
				//ostatnia rata może być większa
				if ($licznikRat == count($this->_daneRat) - 1)
				{
					$rata['kwota'] = $this->_calkowitaWartoscNetto - $sumaNettoRat;
				}
				else
				{
					$rata['kwota'] = floor($this->_calkowitaWartoscNetto / count($this->_daneRat));
				}

			}

			$rataPrzeliczona['nrRaty'] = ++$licznikRat;
			$rataPrzeliczona['terminPlatnosci'] = new \DateTime($dataPlatnosciRat->format('Y-m-d'), new \DateTimeZone('Europe/Warsaw'));
			$rataPrzeliczona['terminPlatnosciTxt'] = $rataPrzeliczona['terminPlatnosci']->format($this->_formatDatyNaFakturze);
			$rataPrzeliczona['kwotaNetto'] = floatval($rata['kwota']);
			$rataPrzeliczona['stawkaVat'] = intval($stawkaVat);
			$rataPrzeliczona['wartoscVat'] = floatval($rataPrzeliczona['kwotaNetto'] * $rataPrzeliczona['stawkaVat'] / 100);
			$rataPrzeliczona['kwotaBrutto'] = floatval($rataPrzeliczona['kwotaNetto'] +  $rataPrzeliczona['wartoscVat']);

			$rataPrzeliczona['RATA_POZYCJA_ILOSC'] = 1;
			$rataPrzeliczona['RATA_POZYCJA_NETTO'] = number_format($rataPrzeliczona['kwotaNetto'], 2,',', '');
			$rataPrzeliczona['RATA_POZYCJA_VAT'] = number_format($rataPrzeliczona['wartoscVat'], 2,',', '');
			$rataPrzeliczona['RATA_POZYCJA_STAWKA_VAT'] = $rataPrzeliczona['stawkaVat'];
			$rataPrzeliczona['RATA_POZYCJA_BRUTTO'] = number_format($rataPrzeliczona['kwotaBrutto'], 2,',', '');


			$sumaNettoRat += floatval($rataPrzeliczona['kwotaNetto']);
			$dataPlatnosciOstatniejRaty = $dataPlatnosciRat->format('Y-m-d');

			$this->_daneRatPrzeliczone[] = $rataPrzeliczona;
		}

		if ($sumaNettoRat != $this->_calkowitaWartoscNetto)
		{
			$this->_daneRatPrzeliczone = array();
			trigger_error('Błąd. Suma wartości rat niezgodna z wartością faktury.', E_USER_WARNING);
			return false;
		}

		$this->_terminPlatnosciData = new \DateTime($dataPlatnosciRat->format('Y-m-d'), new \DateTimeZone('Europe/Warsaw'));

		return true;
	}




	/**
	 * Sprawdza czy ustawiono wszystkie dane aby utworzyc fakture
	 *
	 */
	protected function czyMoznaUtworzycFakture()
	{
		if ( ! $this->sprawdzWarunkiPodstawowe())
		{
			return false;
		}

		if (count($this->_daneRat) < 2)
		{
			trigger_error('Błąd. Liczba rat mniejsza od 2.', E_USER_WARNING);
			return false;
		}

		if ($this->_idSzablonuRaty < 1)
		{
			trigger_error('Błąd. Nie ustawiono szablonu raty.', E_USER_WARNING);
			return false;
		}


		return true;
	}

}