<?php
namespace Generic\Biblioteka;
use Generic\Model\Dokument;
use Generic\Model\Produkt;
use Generic\Biblioteka\Cms;
use Generic\Model\Uzytkownik;
use Generic\Model\DokumentSzablon;
use Generic\Biblioteka\LiczbaSlownie;
use Generic\Biblioteka\Szablon;
use Generic\Biblioteka\Rabat;


/**
 * Obsluga generowania faktur w systemie
 *
 * @author Konrad Rudowski
 * @package biblioteki
 */

class Faktura
{

	/**
	 * Dane tekstowe faktury.
	 *
	 * @var Array
	 */
	protected $_daneFaktury = array();


	/**
	 * Id szablonu faktury.
	 *
	 * @var int
	 */
	protected $_idSzablonuFaktury = 0;


	/**
	 * Termin płatności w dniach.
	 *
	 * @var int
	 */
	protected $_terminPlatnosciDni = 0;


	/**
	 * Termin płatności jako data
	 *
	 * @var int
	 */
	protected $_terminPlatnosciData;


	/**
	 * Lista pozycji na fakturze
	 *
	 * @var Array
	 */
	protected $_pozycjeNaFakturze = array();


	/**
	 * Lista pozycji na fakturze do wyświetlenia
	 *
	 * @var Array
	 */
	protected $_pozycjeNaFakturzePrzeliczone = array();


	/**
	 * Dane nabywcy faktury obiekt / tablica
	 *
	 * @var mixed
	 */
	protected $_nabywca = null;


	/**
	 * Data wystawienia faktury
	 *
	 * @var DateTime
	 */
	protected $_dataWystawienia;



	/**
	 * Format numery faktury
	 *
	 * Dostępne zmienne:
	 *	{DD}		- dzien
	 *  {MM}		- miesiac
	 *  {YYYY}		- rok
	 *  {ID_KLIENTA}- id klienta (wizytówki)
	 *  {NR_FAKTURY}- nr kolejnej faktury
	 *
	 * @var string
	 */
	protected $_formatNumeruFaktury = 'FPF/ST/{DD}/{MM}/{YYYY}/{ID_KLIENTA}/{NR_FAKTURY}';



	/**
	 * Html faktury proforma
	 *
	 * @var string
	 */
	protected $_htmlFaktura = '';



	/**
	 * Numer faktury
	 *
	 * @var string
	 */
	protected $_fakturaNumer = '';



	/**
	 * Całkowita wartość netto
	 *
	 * @var float
	 */
	protected $_calkowitaWartoscNetto = 0.0;



	/**
	 * Całkowita wartość VAT
	 *
	 * @var float
	 */
	protected $_calkowitaWartoscVat = 0.0;



	/**
	 * Całkowita wartość brutto
	 *
	 * @var float
	 */
	protected $_calkowitaWartoscBrutto = 0.0;



	/**
	 * Id faktury głównej w bazie dnaych
	 *
	 * @var int
	 */
	protected $_idFakturyWBazie = null;



	/**
	 * Obiekt faktury głównej w bazie dnaych
	 *
	 * @var Dokument
	 */
	protected $_fakturaWBazie = null;



	/**
	 * Sposob dostarczenia
	 *
	 * @var string
	 */
	protected $_sposobDostarczenia = 'email';



	/**
	 * Status dostarczenia
	 *
	 * @var int
	 */
	protected $_statusDostarczenia = 0;



	/**
	 * Status płatności
	 *
	 * @var string
	 */
	protected $_statusPlatnosci = 'nieoplacony';



	/**
	 * Format daty na fakturze
	 *
	 * @var string
	 */
	protected $_formatDatyNaFakturze = 'd.m.Y';



	/**
	 * Blokowanie przypomnienia
	 *
	 * @var int
	 */
	protected $_blokujPrzypomnienie = 0;



	/**
	 * Kod faktury
	 *
	 * @var string
	 */
	protected $_kodFaktury = 'faktura_proforma';



	/**
	 * Flaga informująca o przygotowaniu faktury (przeliczenie pozycji, ustawienie danych)
	 *
	 * @var bool
	 */
	protected $_fakturaPrzygotowana = false;




	/**
	 * Konstruktor.
	 *
	 * @param $idSzablonuFaktury Identyfikator szblonu faktury w bazie.
	 */
	function __construct($idSzablonuFaktury = 0)
	{

		if ($idSzablonuFaktury > 0)
		{
			$this->_idSzablonuFaktury = $idSzablonuFaktury;
		}

		$this->_dataWystawienia = new \DateTime('now', new \DateTimeZone('Europe/Warsaw'));

	}



	/**
	 * Ustawia id szablonu faktury.
	 *
	 * @param $idSzablonuFaktury Identyfikator szblonu faktury w bazie.
	 */
	function ustawSzablonFaktury($idSzablonuFaktury)
	{

		$this->_idSzablonuFaktury = $idSzablonuFaktury;

	}


	/**
	 * Ustawia podstawowe dane faktury.
	 *
	 * @param $idSzablonuFaktury Identyfikator szblonu faktury w bazie.
	 */
	function ustawDaneFaktury(Array $daneFaktury)
	{

		$this->_daneFaktury = array_merge($this->_daneFaktury, $daneFaktury);

	}



	/**
	 * Ustawia termin płatności faktury.
	 *
	 * @param $terminPlatnosci Liczba dni na zapłatę faktury.
	 */
	function ustawTerminPlatnosci($terminPlatnosci)
	{

		$this->_terminPlatnosciDni = intval($terminPlatnosci);

	}



	/**
	 * Ustawia termin płatności faktury.
	 *
	 * @param $dataPlatnosciDni Liczba dni na zapłatę faktury.
	 */
	function ustawDatePlatnosci(\DateTime $dataPlatnosci)
	{

		$this->_terminPlatnosciData = $dataPlatnosci;

	}


	/**
	 * Ustawia nabywcę.
	 *
	 * @param $nabywca.
	 */
	function ustawNabywce($nabywca)
	{

		$this->_nabywca = $nabywca;

	}


	/**
	 * Ustawia datę wystawienia.
	 *
	 * @param $dataWystawienia
	 */
	function ustawDateWystawienia(\DateTime $dataWystawienia)
	{

		$this->_dataWystawienia = $dataWystawienia;

	}



	/**
	 * Ustawia format nr faktury proforma.
	 *
	 * Dostępne zmienne:
	 *	{DD}		- dzien
	 *  {MM}		- miesiac
	 *  {YYYY}		- rok
	 *  {ID_KLIENTA}- id klienta (wizytówki)
	 *  {NR_FAKTURY}- nr kolejnej faktury
	 *
	 * @param $formatNumeruFaktury
	 */
	function ustawFormatNumeruFaktury($formatNumeruFaktury)
	{

		$this->_formatNumeruFaktury = $formatNumeruFaktury;

	}



	/**
	 * Ustawia numer faktury
	 *
	 * @param $numerFaktury
	 */
	function ustawNumerFaktury($numerFaktury)
	{

		$this->_fakturaNumer = $numerFaktury;

	}


	/**
	 * Ustawia sposób dostarczenia
	 *
	 * @param $sposobDostarczenia
	 */
	function ustawSposobDostarczenia($sposobDostarczenia)
	{

		$this->_sposobDostarczenia = $sposobDostarczenia;

	}


	/**
	 * Ustawia status dostarczenia
	 *
	 * @param $statusDostarczenia
	 */
	function ustawStatusDostarczenia($statusDostarczenia)
	{

		$this->_statusDostarczenia = $statusDostarczenia == 0 ? 0 : 1;

	}


	/**
	 * Ustawia status platnosci
	 *
	 * @param $statusPlatnosci
	 */
	function ustawStatusPlatnosci($statusPlatnosci)
	{

		$this->_statusPlatnosci = $statusPlatnosci;

	}


	/**
	 * Ustawia format daty na fakturze
	 *
	 * @param $formatDaty
	 */
	function ustawFormatDaty($formatDaty)
	{

		$this->_formatDatyNaFakturze = $formatDaty;

	}


	/**
	 * Blokuje przypomnienie o płatności dla faktury
	 *
	 */
	function blokujPrzypomnienie()
	{

		$this->_blokujPrzypomnienie = 1;

	}


	/**
	 * Ustawia kod faktury
	 * @param $kod - kod faktury proforma
	 *
	 */
	function ustawKodFaktury($kod)
	{

		$this->_kodFaktury = $kod;

	}


	/**
	 * Zwraca id faktury po zapisaniu w bazie
	 * @return int
	 *
	 */
	function pobierzIdFaktury()
	{

		if ($this->_idFakturyWBazie < 1)
		{
			return null;
		}

		return $this->_idFakturyWBazie;

	}


	/**
	 * Zwraca obiekt faktury po zapisaniu w bazie
	 * @return Dokument
	 *
	 */
	function pobierzDokumentFaktury()
	{

		if ($this->_fakturaWBazie instanceof Dokument\Obiekt)
		{
			return $this->_fakturaWBazie;
		}

		return null;

	}


	/**
	 * Zwraca kod HTML faktury
	 *
	 */
	function pobierzHtmlFaktury()
	{

		if ($this->_htmlFaktura == '')
		{
			return null;
		}

		return $this->_htmlFaktura;

	}


	/**
	 * Dodaje pozycje na fakturze.
	 *
	 * @param $pozycja - nazwa lub obiekt produktu
	 * @param $cenaNetto - wartość ceny jeśli inna niż w obiekcie lub jeśli podajemy stringa jako pozycję
	 * @param $stawkaVat - wartość stawki VAT jako int, domyślnie 23%
	 * @param $ilosc - ilość zakupionych domyślnie 1
	 * @param $rabat - rabat % jako int
	 */
	function dodajPozycje($pozycja, $cenaNetto, $stawkaVat, $ilosc = 1, $rabat = 0)
	{
		$this->_pozycjeNaFakturze[] = array(
			'pozycja' => $pozycja,
			'ilosc' => $ilosc,
			'cenaNetto' => $cenaNetto,
			'stawkaVat' => $stawkaVat,
			'rabat' => $rabat,
		);

	}


	/**
	 * Dodaje pozycje na fakturze.
	 *
	 * @param $pozycja - nazwa lub obiekt produktu
	 * @param $ilosc - ilość zakupionych domyślnie 1
	 * @param $rabat - obiekt klasy rabat
	 */
	function dodajProdukt(Produkt\Obiekt $pozycja, $ilosc = 1, $rabat = null)
	{

		$this->_pozycjeNaFakturze[] = array(
			'pozycja' => $pozycja,
			'ilosc' => $ilosc,
			'cenaNetto' => 0.0,
			'stawkaVat' => $pozycja->stawkaVat,
			'rabat' => $rabat,
		);

	}


	/**
	 * Generuje fakturę proforma oraz zapisuje dokumenty o ile nie zablokowano
	 * tworzenia dokumentu.
	 *
	 * @param $czyTworzycDokument
	 * @return bool
	 */
	function utworzFakture($czyTworzycDokument = true)
	{
		if ( ! $this->czyMoznaUtworzycFakture())
		{
			trigger_error('Błąd. Nie mogę utworzyc faktury.', E_USER_WARNING);
			return false;
		}

		if ( ! $this->generujHtmlFaktury())
		{
			trigger_error('Błąd. Nie mogę utworzyc HTML faktury.', E_USER_WARNING);
			return false;
		}

		if ($czyTworzycDokument)
		{
			if ( ! $this->zapiszDokumentyFaktury())
			{
				trigger_error('Błąd. Nie mogę zapisać dokumentów faktury.', E_USER_WARNING);
				return false;
			}
		}

		return true;

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
			$faktura = new Dokument\Obiekt();
			$faktura->idProjektu = ID_PROJEKTU;
			$faktura->kodJezyka = KOD_JEZYKA;
			$faktura->idSzablonu = $this->_idSzablonuFaktury;
			$faktura->idUzytkownika = $this->_nabywca->id;
			$faktura->dataDodania = $this->_dataWystawienia->format('Y-m-d H:i:s');
			$faktura->sposobDostarczenia = $this->_sposobDostarczenia;
			$faktura->typ = 'html';
			$faktura->kod = $this->_kodFaktury;
			$faktura->tytul = $this->_fakturaNumer;
			$faktura->tresc = $this->_htmlFaktura;
			$faktura->kwotaPlatnosci = $this->_calkowitaWartoscBrutto;
			$faktura->statusPlatnosci = $this->_statusPlatnosci;
			$faktura->dostarczono = $this->_statusDostarczenia;
			$faktura->idRodzica = null;
			$faktura->dataPlatnosci = $this->_terminPlatnosciData->format('Y-m-d');
			$faktura->blokujPrzypomnienie = $this->_blokujPrzypomnienie;
			$faktura->kodHandlowca = $this->_nabywca->wizytowka->kodHandlowca;
			if ( ! $faktura->zapisz($cms->dane()->Dokument()))
			{
				trigger_error('Błąd. Niepowodzenie zapisu dokumentu faktury.', E_USER_WARNING);
				return false;
			}

			$this->_idFakturyWBazie = $faktura->id;
			$this->_fakturaWBazie = $faktura;

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

		if ( !$this->pobierzDaneNabywcy())
		{
			trigger_error('Błąd. Nieprawidłowe dane nabywcy.', E_USER_WARNING);
			return false;
		}

		//jeśli nie ustawiono daty wystawienia to ustawiamy aktualną
		$this->_dataWystawienia = $this->_dataWystawienia instanceof \DateTime ?
				$this->_dataWystawienia
				: new \DateTime('now', new \DateTimeZone('Europe/Warsaw'));


		if ( $this->_fakturaNumer == '' && ! $this->wygenerujNumerFaktury())
		{
			trigger_error('Błąd. Nie wygenerowano numeru faktury.', E_USER_WARNING);
			return false;
		}

		if ( ! $this->przeliczPozycje())
		{
			trigger_error('Błąd. Nie przeliczono pozycji.', E_USER_WARNING);
			return false;
		}


		//ustawienie terminu płatności zależnie od przekazanych danych
		if ( ! ($this->_terminPlatnosciData instanceof \DateTime))
		{
			$this->_terminPlatnosciData = new \DateTime($this->_dataWystawienia->format('Y-m-d'), new \DateTimeZone('Europe/Warsaw'));

			if ($this->_terminPlatnosciDni >= 30)
			{
				$this->_terminPlatnosciData->modify('+' . intval($this->_terminPlatnosciDni / 30) . ' month');
			}
			else
			{
				$this->_terminPlatnosciData->modify('+' . $this->_terminPlatnosciDni . ' day');
			}

		}

		return true;

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
			trigger_error('Błąd. Nie przygotowano faktury.', E_USER_WARNING);
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



	/**
	 * Przelicza pozycje na fakturze wylicza ceny i sumuje wartości
	 *
	 */
	protected function przeliczPozycje()
	{
		foreach ($this->_pozycjeNaFakturze as $pozycja)
		{
			$pozycjaPrzeliczona = array();

			if ($pozycja['pozycja'] instanceof Produkt\Obiekt)
			{
				$pozycjaPrzeliczona['nazwa'] = $pozycja['pozycja']->nazwa;
				$pozycjaPrzeliczona['cenaNetto'] = $pozycja['pozycja']->cenaNetto;
				$pozycjaPrzeliczona['stawkaVat'] = $pozycja['pozycja']->stawkaVat;
			}
			elseif (is_string($pozycja['pozycja']))
			{
				$pozycjaPrzeliczona['nazwa'] = $pozycja['pozycja'];
			}

			if ($pozycja['ilosc'] > 1)
			{
				$pozycjaPrzeliczona['ilosc'] = $pozycja['ilosc'];
			}
			else
			{
				$pozycjaPrzeliczona['ilosc'] = 1;
			}

			if ($pozycja['cenaNetto'] != 0) // ŁW: zmieniłem z >0 na !=0 (dowolna pozycja na fakturze - rabat)
			{
				$pozycjaPrzeliczona['cenaNetto'] = $pozycja['cenaNetto'];
			}

			if ($pozycja['stawkaVat'] >= 0.0) // ŁW: zmieniłem z > na >=
			{
				$pozycjaPrzeliczona['stawkaVat'] = $pozycja['stawkaVat'];
			}

			if ($pozycjaPrzeliczona['nazwa'] == '' || $pozycjaPrzeliczona['cenaNetto'] == 0)
			{
				trigger_error('Błąd. Niepoprawna pozycja na fakturze.', E_USER_WARNING);
				continue;
			}

			$pozycjaPrzeliczona = $this->ustawWartosciPozycji($pozycjaPrzeliczona);

			$this->_pozycjeNaFakturzePrzeliczone[] = $pozycjaPrzeliczona;

			if ($pozycja['rabat'] instanceof Rabat)
			{
				$this->dodajPozycjeRabatu($pozycja['rabat']);
			}
		}

		$this->_fakturaPrzygotowana = true;

		return true;
	}


	protected function dodajPozycjeRabatu(Rabat $rabat)
	{
		$this->_pozycjeNaFakturzePrzeliczone[] = $this->ustawWartosciPozycji($rabat->pobierzWiersz());
	}


	protected function ustawWartosciPozycji($pozycjaPrzeliczona)
	{
		$pozycjaPrzeliczona['cenaNetto'] = $this->formatujCene($pozycjaPrzeliczona['cenaNetto'] * $pozycjaPrzeliczona['ilosc']);

		$pozycjaPrzeliczona['wartoscVat'] = $this->formatujCene(floatval($pozycjaPrzeliczona['cenaNetto']) * floatval($pozycjaPrzeliczona['stawkaVat'] / 100.0));
		$pozycjaPrzeliczona['cenaBrutto'] = $this->formatujCene(floatval($pozycjaPrzeliczona['cenaNetto']) + floatval($pozycjaPrzeliczona['wartoscVat']));

		$pozycjaPrzeliczona['FAKTURA_POZYCJA_NAZWA'] = $pozycjaPrzeliczona['nazwa'];
		$pozycjaPrzeliczona['FAKTURA_POZYCJA_ILOSC'] = $pozycjaPrzeliczona['ilosc'];
		$pozycjaPrzeliczona['FAKTURA_POZYCJA_NETTO'] = number_format($pozycjaPrzeliczona['cenaNetto'], 2,',', '');
		$pozycjaPrzeliczona['FAKTURA_POZYCJA_VAT'] = number_format($pozycjaPrzeliczona['wartoscVat'], 2,',', '');
		$pozycjaPrzeliczona['FAKTURA_POZYCJA_STAWKA_VAT'] = $pozycjaPrzeliczona['stawkaVat'];
		$pozycjaPrzeliczona['FAKTURA_POZYCJA_BRUTTO'] = number_format($pozycjaPrzeliczona['cenaBrutto'], 2,',', '');

		$this->_calkowitaWartoscNetto += $pozycjaPrzeliczona['cenaNetto'];
		$this->_calkowitaWartoscVat += $pozycjaPrzeliczona['wartoscVat'];
		$this->_calkowitaWartoscBrutto += $pozycjaPrzeliczona['cenaBrutto'];

		return $pozycjaPrzeliczona;
	}

	/**
	 *
	 * @param type $cena
	 */
	protected function formatujCene($cena)
	{
		if (strpos($cena, '.') > 0)
		{
			return substr($cena, 0, (strpos($cena, '.') + 3));
		}
		else
		{
			return $cena;
		}
	}


	/**
	 * Generuje numer faktury
	 *
	 */
	protected function wygenerujNumerFaktury()
	{

		if ($this->_formatNumeruFaktury == '')
		{
			trigger_error('Błąd. Nie podano formatu numeru faktury.', E_USER_WARNING);
			return false;
		}

		$nrKolejnegoDokumentu = 1;

		if ($this->_nabywca instanceof Uzytkownik\Obiekt)
		{
			$cms = Cms::inst();
			$kryteria = array();
			$kryteria['id_uzytkownika'] = $this->_nabywca->id;
			$kryteria['kod'] = array('faktura_proforma', 'proforma_uzupelnienia');
			$nrKolejnegoDokumentu = intval($cms->dane()->Dokument()->iloscSzukaj($kryteria)) + 1;
		}

		$this->_fakturaNumer = str_replace(
				array(
					'{DD}',
					'{MM}',
					'{YYYY}',
					'{ID_KLIENTA}',
					'{NR_FAKTURY}'
					),
				array(
					$this->_dataWystawienia->format('d'),
					$this->_dataWystawienia->format('m'),
					$this->_dataWystawienia->format('Y'),
					$this->_nabywca instanceof Uzytkownik\Obiekt ? $this->_nabywca->id : $this->_nabywca['id'],
					$nrKolejnegoDokumentu
					),
				$this->_formatNumeruFaktury);

		return true;
	}


	/**
	 * Ustawia dane nabycy zależnie od obiektu przekazanego do szablonu
	 *
	 */
	protected function pobierzDaneNabywcy()
	{

		if ($this->_nabywca instanceof Uzytkownik\Obiekt)
		{
			$this->_daneFaktury['FIRMA_NAZWA'] = $this->_nabywca->firmaNazwa;
			$this->_daneFaktury['FIRMA_ADRES'] = $this->_nabywca->firmaAdres;
			$this->_daneFaktury['FIRMA_KOD_POCZTOWY'] = $this->_nabywca->firmaKodPocztowy;
			$this->_daneFaktury['FIRMA_MIASTO'] = $this->_nabywca->firmaMiasto;
			$this->_daneFaktury['FIRMA_NIP'] = $this->_nabywca->firmaNip;
			$this->_daneFaktury['NAZWA_KONTA'] = $this->_nabywca->firmaNazwa;

			if ($this->_nabywca->numerKontaBankowego != '')
			{
				$this->_daneFaktury['FAKTURA_KONTO'] = $this->_nabywca->numerKontaBankowego;
			}
		}
		elseif (is_array($this->_nabywca))
		{
			if (isset($this->_nabywca['firma_nazwa']) && isset($this->_nabywca['firma_adres']) &&
				isset($this->_nabywca['firma_kod_pocztowy']) && isset($this->_nabywca['firma_miasto']) &&
				isset($this->_nabywca['firma_nip']) && isset($this->_nabywca['nazwa_konta']) &&
				isset($this->_nabywca['id']))
			{
				$this->_daneFaktury['FIRMA_NAZWA'] = $this->_nabywca['firma_nazwa'];
				$this->_daneFaktury['FIRMA_ADRES'] = $this->_nabywca['firma_adres'];
				$this->_daneFaktury['FIRMA_KOD_POCZTOWY'] = $this->_nabywca['firma_kod_pocztowy'];
				$this->_daneFaktury['FIRMA_MIASTO'] = $this->_nabywca['firma_miasto'];
				$this->_daneFaktury['FIRMA_NIP'] = $this->_nabywca['firma_nip'];
				$this->_daneFaktury['NAZWA_KONTA'] = $this->_nabywca['nazwa_konta'];

				if (isset($this->_nabywca['numer_konta_bankowego']) && $this->_nabywca['numer_konta_bankowego'] != '')
				{
					$this->_daneFaktury['FAKTURA_KONTO'] = $this->_nabywca['numer_konta_bankowego'];
				}
			}
		}
		else
		{
			return false;
		}

		return true;

	}

	protected function sprawdzWarunkiPodstawowe()
	{
		if (count($this->_daneFaktury) < 1)
		{
			trigger_error('Błąd. Nie ustawiono danych faktury.', E_USER_WARNING);
			return false;
		}

		if ($this->_idSzablonuFaktury <1)
		{
			trigger_error('Błąd. Nie ustawiono szablonu faktury.', E_USER_WARNING);
			return false;
		}

		if (count($this->_pozycjeNaFakturze) < 1)
		{
			trigger_error('Błąd. Nie dodano żadnych pozycji do faktury.', E_USER_WARNING);
			return false;
		}

		if ($this->_nabywca == null)
		{
			trigger_error('Błąd. Nie ustawiono danych nabywcy.', E_USER_WARNING);
			return false;
		}

		if (strlen($this->_formatNumeruFaktury) < 1)
		{
			trigger_error('Błąd. Format numeru faktury nie jest poprawny.', E_USER_WARNING);
			return false;
		}

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


		if ($this->_terminPlatnosciDni <1 && ! ($this->_terminPlatnosciData instanceof \DateTime))
		{
			trigger_error('Błąd. Nie ustawiono poprawnego temrinu płatności.', E_USER_WARNING);
			return false;
		}

		return true;
	}


	/**
	 * Pobiera sumę netto na fakturze
	 *
	 * @return float
	 */
	public function pobierzKwoteNetto()
	{
		if ($this->_fakturaPrzygotowana)
		{
			return $this->_calkowitaWartoscNetto;
		}
		else
		{
			return null;
		}
	}

}