<?php

namespace Generic\Biblioteka\Kreator\KreatorBaza;

use Generic\Biblioteka\Kreator;

/**
 * Klasa odpowiedzialna za wygenerowanie pliku Definicja dla podanej tabelibazy danych.
 * @author Marek Bar
 */
class Definicja extends Kreator\KreatorBaza
{

	/**
	 * Odczytane pola z zainicjowanego obiektu definicji
	 * @var array
	 */
	private $polaObiektuTypy;

	/**
	 * Odczytane domyslne wartości z zainicjowanego obiektu definicji
	 * @var array
	 */
	private $domyslneWartosci;

	/**
	 * Odczytane dopuszczalne wartości z zainicjowanego obiektu definicji
	 * @var array
	 */
	private $dopuszczalneWartosci;

	/**
	 * Odczytane pola formularza z zainicjowanego obiektu definicji
	 * @var array
	 */
	private $polaFormularza;

	/**
	 * Tłumaczenia
	 * @var array
	 */
	protected $t = array(
		'todo' => '//TODO: ',
		'poprawic_typ_pola' => 'Poprawić nierozpoznany typ pola',
		'nieznany_typ' => 'Nieznany typ',
		'znaleziony_typ' => 'Znaleziony typ pola.',
		'odczytany_z_bazy' => 'Odczytany typ pola z bazy.',
		'typ_zgodny' => 'Typ pola zgodny ze znalezionym w bazie.',
		'wartosc_w_pliku' => 'Wartość domyślna znaleziona w pliku.',
		'wartosc_z_bazy' => 'Wartość domyślna znaleziona w bazie.',
		'wartosc_taka_sama' => 'Znaleziona wartość domyślna jest taka sama w pliku i tabeli bazy.',
		'sa_tylko_w_pliku' => 'Nie znaleziono dopuszczalnych wartości w bazie, ale pozostawiono znalezione w pliku.',
		'dopuszczalne_z_pliku' => 'Pozostawiono dopuszczalne wartości znalezione w tym pliku.',
		'dopuszczalne_z_bazy' => 'Znaleziono dopuszczalne wartości w bazie.',
		'podpowiedz_nieznana' => 'Nieznany typ pola.',
		'podpowiedz_zmienil_sie_typ' => 'Zmienił się typ kolumny, i różni się od znalezionego. Typ z tabeli to: ',
		'generowany_input' => ' - wygenerowany typ inputa, ',
		'odczytany_input' => ' - zachowany typ inputa z pliku',
		'zachowano_walidator' => ' - zachowano ten walidator, ponieważ generator go sam nie dodał',
		'dodano_walidator' => ' - ten walidator został dodany jako nowy',
		'wymagane_zachowano_true' => 'true - pozostawiono, false - proponowana zmiana',
		'wymagane_zachowano_false' => 'false - pozostawiono, true - proponowana zmiana',
		'filtr_dodano' => ' - ten filtr został dodany jako nowy',
		'zachowano_filtr' => ' - zachowano ten filtr, ponieważ generator go nie stworzył',
		'dopuszczalne_nie_ma_w_bazie' => 'Tej wartości nie ma w bazie',
	);
	private $walidatoryPrzyjmujaceLiczbe = array('KrotszeOd',);

	/**
	 * Konstruktor ustawiający nazwę generowanego pliku i nazwę pliku jego szablonu.
	 */
	function __construct($nazwaBazy = 'crm')
	{
		$this->nazwaBazy = $nazwaBazy;
		$this->polacz();
		$this->nazwaGenerowanegoPliku = 'Definicja.php';
		$this->nazwaPlikuSzablonu = 'szablon_definicja.tpl';
	}



	/**
	 * Generuje kod klasy Definicja dla podanej nazwy tabeli.
	 * @param string $nazwaTabeli
	 * @return boolean
	 */
	public function generuj($nazwaTabeli, $nazwaUzytkownika)
	{
		$this->nazwaTabeli = $nazwaTabeli;
		if (!$this->inicjuj($nazwaTabeli))
		{
			return false;
		}

		$this->inicjujObiekt();

		foreach ($this->opisKolumnTabeli as $opisKolumny)
		{
			$this->ustawKomentarzPola($opisKolumny);
			$this->ustawTypObiektuPola($opisKolumny);
			$this->ustawDomyslnaWartoscPola($opisKolumny);
			$this->ustawDopuszczalenWartosciPola($opisKolumny);
			$this->ustawPoleFormularza($opisKolumny);
		}

		$wygenerowanyKodObiektu = $this->szablon->parsujBlok('/', array(
			'NAZWA' => $this->nazwaObiektuModelu,
		));


		return $this->zapiszKodDoPliku($nazwaUzytkownika, $this->katalogModel, $this->nazwaGenerowanegoPliku, $wygenerowanyKodObiektu);
	}

    /**
     * Tworzy obiekt Definicji i odczytuje istniejące jego własności.
     */
    private function inicjujObiekt()
    {
        $sciezkaDoObiektu = $this->katalogModel . '/' . $this->nazwaObiektuModelu . '/' . $this->nazwaGenerowanegoPliku;

        if (!file_exists($sciezkaDoObiektu))
        {
            $this->domyslneWartosci = array();
            $this->dopuszczalneWartosci = array();
            $this->polaFormularza = array();
            $this->polaObiektuTypy = array();
            $this->czyObiektIstnieje = false;
            return;
        }

        $sciezkaObiektu = '\\Generic\\Model\\' . $this->nazwaObiektuModelu . '\\' . str_replace('.php', '', $this->nazwaGenerowanegoPliku);

        $this->obiekt = new $sciezkaObiektu();

        if ($this->obiekt == null)
        {
            $this->czyObiektIstnieje = false;
        }

        $this->domyslneWartosci = isset($this->obiekt->domyslneWartosci) ? $this->obiekt->domyslneWartosci : array();
        $this->dopuszczalneWartosci = isset($this->obiekt->dopuszczalneWartosci) ? $this->obiekt->dopuszczalneWartosci : array();
        $this->polaFormularza = isset($this->obiekt->polaFormularza) ? $this->obiekt->polaFormularza : array();
        $this->polaObiektuTypy = isset($this->obiekt->polaObiektuTypy) ? $this->obiekt->polaObiektuTypy : array();
        $this->czyObiektIstnieje = true;


    }



	/**
	 * Ustawia komentarze
	 * @param array $opisKolumny
	 */
	private function ustawKomentarzPola($opisKolumny)
	{
		$typPolaDlaPHPDoc = $this->poprawTypDlaPHPDoc($opisKolumny['typ']);
		$nazwaKolumny = $opisKolumny['nazwa'];
		if ($this->czyObiektIstnieje && !in_array($opisKolumny['nazwa'], array_keys($this->polaObiektuTypy)))
		{
			$this->szablon->ustawBlok('/PODPOWIEDZI', array(
				'TYP' => $typPolaDlaPHPDoc,
				'NAZWA' => $opisKolumny['nazwa'],
				'KOMENTARZ' => ($typPolaDlaPHPDoc === 'mixed' ? $this->t['todo'] . $this->t['podpowiedz_nieznana'] : ''),
			));
		}
		elseif ($this->czyObiektIstnieje && strtolower($this->polaObiektuTypy[$nazwaKolumny]) != strtolower($typPolaDlaPHPDoc))
		{
			$this->szablon->ustawBlok('/PODPOWIEDZI', array(
				'TYP' => $this->poprawTypDlaPHPDoc($this->polaObiektuTypy[$nazwaKolumny]),
				'NAZWA' => $opisKolumny['nazwa'],
				'KOMENTARZ' => $this->t['todo'] . $this->t['podpowiedz_zmienil_sie_typ'] . $typPolaDlaPHPDoc . ' ' . ($typPolaDlaPHPDoc === 'mixed' ? $this->t['podpowiedz_nieznana'] : ''),
			));
		}
		else
		{
			$this->szablon->ustawBlok('/PODPOWIEDZI', array(
				'TYP' => $typPolaDlaPHPDoc,
				'NAZWA' => $opisKolumny['nazwa'],
				'KOMENTARZ' => ($typPolaDlaPHPDoc === 'mixed' ? $this->t['todo'] . $this->t['podpowiedz_nieznana'] : ''),
			));
		}
	}



	/**
	 * Generuje formularz z poszczególnych kolumn.
	 * @param array $opisKolumny
	 */
	private function ustawPoleFormularza($opisKolumny)
	{
		$tychPolNieDodawajDoFormularza = array('id', 'id_projektu');
		if (in_array(strtolower($opisKolumny['nazwa']), $tychPolNieDodawajDoFormularza))
		{
			return;
		}
		$this->szablon->ustawBlok('/POLA_FORMULARZA', array(
			'NAZWA_POLA' => $this->konwertujNaWielblada($opisKolumny['nazwa']),
		));

		$zachowanyTypInputa = ($this->czyObiektIstnieje && isset($this->polaFormularza[$opisKolumny['nazwa']]['input'])) ? $this->polaFormularza[$opisKolumny['nazwa']]['input'] : '';
		$wygenerowanyTypInputa = $this->przetlumaczTypPolaNaInput($opisKolumny);

		$komentarz = ($zachowanyTypInputa != '' && $zachowanyTypInputa != $wygenerowanyTypInputa ? $this->t['todo'] . $wygenerowanyTypInputa . $this->t['generowany_input'] . $zachowanyTypInputa . $this->t['odczytany_input'] : '');
		$this->szablon->ustawBlok('/POLA_FORMULARZA/INPUT', array(
			'TYP_INPUTA' => ($zachowanyTypInputa == '' ? $wygenerowanyTypInputa : $zachowanyTypInputa),
			'KOMENTARZ' => $komentarz,
		));

		$czyWymaganeWygenerowane = $this->czyPoleMaBycWymagane($opisKolumny);

		if ($this->czyObiektIstnieje)
		{
			$czyWymaganeOdczytane = isset ($this->polaFormularza[$opisKolumny['nazwa']]['wymagane']) ? $this->polaFormularza[$opisKolumny['nazwa']]['wymagane'] : false;
			if ($czyWymaganeOdczytane && $czyWymaganeWygenerowane)
			{
				$this->szablon->ustawBlok('/POLA_FORMULARZA/WYMAGANE', array(
					'WYMAGAJ' => 'true',
					'KOMENTARZ' => '',
				));
			}
			elseif ($czyWymaganeOdczytane && !$czyWymaganeWygenerowane)
			{
				$this->szablon->ustawBlok('/POLA_FORMULARZA/WYMAGANE', array(
					'WYMAGAJ' => 'true',
					'KOMENTARZ' => $this->t['todo'] . $this->t['wymagane_zachowano_true'],
				));
			}
			elseif (!$czyWymaganeOdczytane && $czyWymaganeWygenerowane)
			{
				$this->szablon->ustawBlok('/POLA_FORMULARZA/WYMAGANE', array(
					'WYMAGAJ' => 'false',
					'KOMENTARZ' => $this->t['todo'] . $this->t['wymagane_zachowano_false'],
				));
			}
		}
		else
		{
			if ($czyWymaganeWygenerowane)
			{
				$this->szablon->ustawBlok('/POLA_FORMULARZA/WYMAGANE', array(
					'WYMAGAJ' => 'true',
					'KOMENTARZ' => '',
				));
			}
		}

		$wygenerowaneFiltry = $this->pobierzFiltryDla($opisKolumny['typ'], $wygenerowanyTypInputa);
		$this->szablon->ustawBlok('/POLA_FORMULARZA/FILTROWANIE', array());

		$odczytaneFiltry = !$this->czyObiektIstnieje ? array() : (!isset($this->polaFormularza[$opisKolumny['nazwa']]['filtry']) ? array() : $this->polaFormularza[$opisKolumny['nazwa']]['filtry']);
		$stareKtoreNalezyZachowac = $this->zachowajStare($odczytaneFiltry, $wygenerowaneFiltry);
		foreach ($wygenerowaneFiltry as $klucz => $filtr)
		{
			$komentarz = !in_array($filtr, $odczytaneFiltry) && !empty($odczytaneFiltry) ? $this->t['todo'] . $this->t['filtr_dodano'] : '';
			$this->szablon->ustawBlok('/POLA_FORMULARZA/FILTROWANIE/FILTR', array(
				'NAZWA_FILTRA' => $filtr,
				'KOMENTARZ' => $komentarz,
			));
		}
		foreach ($stareKtoreNalezyZachowac as $klucz => $filtr)
		{
			$this->szablon->ustawBlok('/POLA_FORMULARZA/FILTROWANIE/FILTR', array(
				'NAZWA_FILTRA' => $filtr,
				'KOMENTARZ' => $this->t['todo'] . $this->t['zachowano_filtr'],
			));
		}


		$wygenerowaneWalidatory = $this->pobierzWalidatoryDla($opisKolumny);
		$odczytaneWalidatory = isset($this->polaFormularza[$opisKolumny['nazwa']]['walidatory']) ? $this->polaFormularza[$opisKolumny['nazwa']]['walidatory'] : array();

		$stareKtoreNalezyZachowac = $this->zachowajStare($odczytaneWalidatory, $wygenerowaneWalidatory);
		$this->szablon->ustawBlok('/POLA_FORMULARZA/WALIDATORY', array());
		foreach ($wygenerowaneWalidatory as $klucz => $walidator)
		{
			if ($walidator == '')
			{
				continue;
			}
			$komentarz = !in_array($walidator, $odczytaneWalidatory) && !empty($odczytaneWalidatory) ? $this->t['todo'] . $this->t['dodano_walidator'] : '';
			$this->szablon->ustawBlok('/POLA_FORMULARZA/WALIDATORY/WALIDATOR', array(
				'WALIDATOR' => $walidator,
				'KOMENTARZ' => $komentarz,
			));
			$dozwoloneWartosci = $this->pobierzWartosciEnuma($opisKolumny, $this->nazwaTabeli);
			if ($walidator == 'DozwoloneWartosci' && count($dozwoloneWartosci) > 0)
			{
				$this->szablon->ustawBlok('/POLA_FORMULARZA/WALIDATORY/WALIDATOR/DOZWOLONE_TABLICA', array());

				foreach ($dozwoloneWartosci as $dozwolonaWartosc)
				{
					$this->szablon->ustawBlok('/POLA_FORMULARZA/WALIDATORY/WALIDATOR/DOZWOLONE_TABLICA/DOZWOLONE', array(
						'DOZWOLONA_WARTOSC' => $dozwolonaWartosc,
					));
				}
			}
			elseif ($opisKolumny['rozmiar'] > 0 && in_array($walidator, $this->walidatoryPrzyjmujaceLiczbe))
			{
				$this->szablon->ustawBlok('/POLA_FORMULARZA/WALIDATORY/WALIDATOR/WARTOSC', array(
					'WARTOSC' => $opisKolumny['rozmiar'],
				));
			}
		}

		foreach ($stareKtoreNalezyZachowac as $klucz => $walidator)
		{
			$this->szablon->ustawBlok('/POLA_FORMULARZA/WALIDATORY/WALIDATOR', array(
				'WALIDATOR' => $walidator,
				'KOMENTARZ' => $this->t['todo'] . $this->t['zachowano_walidator'],
			));
		}
	}



	private function ustawSzczegolyWalidatora($walidator, $opisKolumny)
	{
      
	}



	/**
	 * Ustawia typ pola obiektu, zachowując istniejące dane.
	 * @param array $opisKolumny
	 */
	private function ustawTypObiektuPola($opisKolumny)
	{
		$nazwaKolumny = $this->konwertujNaWielblada($opisKolumny['nazwa']);
		$typPola = $this->poprawTypDlaTypuPolaBazy($opisKolumny['typ']);
      
		if ($this->czyObiektIstnieje && !in_array($nazwaKolumny, array_keys($this->polaObiektuTypy)))
		{
			$this->szablon->ustawBlok('/POLA_OBIEKTU_TYPY', array(
				'NAZWA_POLA' => $nazwaKolumny,
				'TYP_POLA' => $typPola,
				'KOMENTARZ' => (($typPola === 'MIXED') ? $this->t['todo'] . $this->t['poprawic_typ_pola'] : ''),
			));
		}
		elseif ($this->czyObiektIstnieje && strtolower(str_replace('self::_', '', $this->polaObiektuTypy[$nazwaKolumny])) != strtolower($typPola))
		{
			$this->szablon->ustawBlok('/POLA_OBIEKTU_TYPY', array(
				'NAZWA_POLA' => $nazwaKolumny,
				'TYP_POLA' => strtoupper($this->polaObiektuTypy[$nazwaKolumny]),
				'KOMENTARZ' => $this->t['todo'] . $this->t['znaleziony_typ'],
			));
			$this->szablon->ustawBlok('/POLA_OBIEKTU_TYPY', array(
				'NAZWA_POLA' => $this->zabezpieczNazwe($nazwaKolumny),
				'TYP_POLA' => $typPola,
				'KOMENTARZ' => ($this->t['todo'] . $this->t['odczytany_z_bazy'] . (($typPola === 'MIXED') ? $this->t['poprawic_typ_pola'] : '')),
			));
		}
		else
		{
			$this->szablon->ustawBlok('/POLA_OBIEKTU_TYPY', array(
				'NAZWA_POLA' => $nazwaKolumny,
				'TYP_POLA' => $typPola,
				'KOMENTARZ' => ($typPola === 'MIXED') ? $this->t['todo'].$this->t['poprawic_typ_pola'] : '',
			));
		}
	}



	/**
	 * Odczytuje i ustawia domyślną wartość pola, jeśli jest
	 * @param array $opisKolumny
	 */
	private function ustawDomyslnaWartoscPola($opisKolumny)
	{
		$nazwaKolumny = $opisKolumny['nazwa'];
		if (isset($opisKolumny['czy_nie_puste']) && $opisKolumny['czy_nie_puste'] && $opisKolumny['domyslna'] != '')
		{
			$odczytanaWartoscDomyslna = $opisKolumny['domyslna'];

			if ($this->czyObiektIstnieje && !in_array($nazwaKolumny, array_keys($this->domyslneWartosci)))
			{
				$this->szablon->ustawBlok('/DOMYSLNE_WARTOSCI_POL', array(
					'NAZWA_POLA' => $nazwaKolumny,
					'DOMYSLNA_WARTOSC_POLA' => $odczytanaWartoscDomyslna,
					'KOMENTARZ' => '',
				));
			}
			elseif ($this->czyObiektIstnieje && $this->domyslneWartosci[$nazwaKolumny] != $odczytanaWartoscDomyslna)
			{
				$this->szablon->ustawBlok('/DOMYSLNE_WARTOSCI_POL', array(
					'NAZWA_POLA' => $nazwaKolumny,
					'DOMYSLNA_WARTOSC_POLA' => $this->domyslneWartosci[$nazwaKolumny],
					'KOMENTARZ' => $this->t['todo'] . $this->t['znalezione_w_pliku'],
				));

				$this->szablon->ustawBlok('/DOMYSLNE_WARTOSCI_POL', array(
					'NAZWA_POLA' => $this->zabezpieczNazwe($nazwaKolumny),
					'DOMYSLNA_WARTOSC_POLA' => $odczytanaWartoscDomyslna,
					'KOMENTARZ' => $this->t['todo'] . $this->t['znalezione_w_bazie'],
				));
			}
			else
			{
				$this->szablon->ustawBlok('/DOMYSLNE_WARTOSCI_POL', array(
					'NAZWA_POLA' => $nazwaKolumny,
					'DOMYSLNA_WARTOSC_POLA' => $odczytanaWartoscDomyslna,
					'KOMENTARZ' => $this->t['todo'] . $this->t['wartosc_taka_sama'],
				));
			}
		}
	}



	/**
	 * Ustawia dopuszczalne wartości pól typu enum, jeśli pole nie jest enumem to nie doda go do tabliczki.
	 * @param array $opisKolumny
	 */
	private function ustawDopuszczalenWartosciPola($opisKolumny)
	{
		$nazwaKolumny = $opisKolumny['nazwa'];
		$odczytaneWartosciTabela = $this->pobierzWartosciEnuma($opisKolumny, $this->nazwaTabeli);

		$odczytaneWartosciPlik = array();

		if ($this->czyObiektIstnieje && isset($this->dopuszczalneWartosci[$nazwaKolumny]))/* coś jest w pliku */
		{
			$odczytaneWartosciPlik = $this->dopuszczalneWartosci[$nazwaKolumny];
			if (empty($odczytaneWartosciTabela) && !empty($odczytaneWartosciPlik))/* coś jest w pliku, nie ma w tabeli */
			{
				$this->szablon->ustawBlok('/DOPUSZCZALNE_WARTOSCI', array(
					'NAZWA_POLA' => $nazwaKolumny,
					'KOMENTARZ' => $this->t['todo'] . $this->t['sa_tylko_w_pliku'],
				));
				foreach ($odczytaneWartosciPlik as $klucz => $wartosc)
				{
					$this->szablon->ustawBlok('/DOPUSZCZALNE_WARTOSCI/DOPUSZCZALNA_WARTOSC', array(
						'WARTOSC' => $wartosc,
						'KOMENTARZ1' => '',
						'KOMENTARZ2' => '',
					));
				}
			}
			else/* coś jest w pliku i w tabeli */
			{
				$this->szablon->ustawBlok('/DOPUSZCZALNE_WARTOSCI', array(
					'NAZWA_POLA' => $nazwaKolumny,
					'KOMENTARZ' => '',
				));

				$tychNieMaWBazie = $this->zachowajStare($odczytaneWartosciPlik, $odczytaneWartosciTabela);

				foreach ($odczytaneWartosciTabela as $klucz => $wartosc)
				{
					$this->szablon->ustawBlok('/DOPUSZCZALNE_WARTOSCI/DOPUSZCZALNA_WARTOSC', array(
						'WARTOSC' => $wartosc,
						'KOMENTARZ1' => '',
						'KOMENTARZ2' => '',
					));
				}

				foreach ($tychNieMaWBazie as $klucz => $wartosc)
				{
					$this->szablon->ustawBlok('/DOPUSZCZALNE_WARTOSCI/DOPUSZCZALNA_WARTOSC', array(
						'WARTOSC' => $wartosc,
						'KOMENTARZ1' => $this->t['todo'],
						'KOMENTARZ2' => $this->t['dopuszczalne_nie_ma_w_bazie'],
					));
				}
			}
		}
		elseif (!empty($odczytaneWartosciTabela))
		{
			$this->szablon->ustawBlok('/DOPUSZCZALNE_WARTOSCI', array(
				'NAZWA_POLA' => $nazwaKolumny,
			));
			foreach ($odczytaneWartosciTabela as $klucz => $wartosc)
			{
				$this->szablon->ustawBlok('/DOPUSZCZALNE_WARTOSCI/DOPUSZCZALNA_WARTOSC', array(
					'WARTOSC' => $wartosc,
					'KOMENTARZ1' => '',
					'KOMENTARZ2' => '',
				));
			}
		}
	}


	/**
	 * Zwraca tekst podsumowujący działanie generatora definicji
	 * @return string
	 */
	public function pokazPodsumowanie()
	{
		return $this->pobierzLog();
	}



}