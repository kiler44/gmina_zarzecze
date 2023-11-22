<?php

namespace Generic\Biblioteka\Kreator\KreatorBaza;

use Generic\Biblioteka\Kreator;

/**
 * Klasa odpowiedzialna za wygenerowanie pliku Tlumaczenie dla podanej tabelibazy danych.
 * @author Marek Bar
 */
class Tlumaczenie extends Kreator\KreatorBaza
{

	/**
	 * Jaki język tłumaczeń?
	 * @var string
	 */
	private $jezyk = 'Pl';

	/**
	 * Generować dla modelu czy dla modułu? - Model
	 * @var string
	 */
	private $modulCzyModel = 'Model';

	/**
	 * Tłumaczenia
	 * @var array
	 */
	protected $t = array(
		'todo' => '//TODO: ',
		'podaj_etykieta' => 'Podaj tłumaczenie etykiety',
		'podaj_opis' => 'Podaj tłumaczenie opisu',
		'podaj_wartosc' => 'Podaj tłumaczenie wartości',
		'stara_etykieta' => 'Zostało zachowane stare tłumaczenie etykiety',
		'stary_opis' => 'Zostało zachowane stare tłumaczenie opisu',
		'stara_wartosc' => 'Zostało zachowane stare tłumaczenie wartości'
	);

	/**
	 * Tłumaczenia znalezione w istniejącym pliku
	 * @var array
	 */
	private $tlumaczeniaDomyslne = array();

	/**
	 * Konstruktor ustawiający nazwę generowanego pliku i nazwę pliku jego szablonu.
	 */
	function __construct($nazwaBazy = 'crm')
	{
		$this->nazwaBazy = $nazwaBazy;
		$this->polacz();
		$this->nazwaGenerowanegoPliku = '';
		$this->nazwaPlikuSzablonu = 'szablon_tlumaczenie.tpl';
	}



	/**
	 *
	 * @param string $nazwaTabeli
	 * @param string $nazwaUzytkownika
	 * @return boolean
	 */
	public function generuj($nazwaTabeli, $nazwaUzytkownika)
	{
		$this->nazwaGenerowanegoPliku = $this->nazwaObiektuModelu . '.php';
		$this->nazwaTabeli = $nazwaTabeli;
		if (!$this->inicjuj($nazwaTabeli))
		{
			return false;
		}

		$this->inicjujObiekt();

		foreach ($this->opisKolumnTabeli as $opisKolumny)
		{
			$this->ustawPodpowiedz($opisKolumny);
			$this->ustawTlumaczenie($opisKolumny);
		}
		$wygenerowanyKodTlumaczenia = $this->szablon->parsujBlok('/', array(
			'JEZYK' => $this->jezyk,
			'MODEL_MODUL' => $this->modulCzyModel,
			'NAZWA_KLASY' => $this->konwertujNaWielblada($nazwaTabeli, true),
				));
		$this->czyPlikMaNazweObiektu = true;
		$katalog = $this->katalogTlumaczen . '/' . $this->jezyk . '/' . $this->modulCzyModel;
		return $this->zapiszKodDoPliku($nazwaUzytkownika, $katalog, $this->nazwaGenerowanegoPliku, $wygenerowanyKodTlumaczenia);
	}



	/**
	 * Ustawia poszczególne @property
	 * @param array $opisKolumny
	 */
	private function ustawPodpowiedz($opisKolumny)
	{
		$nazwaPodpowiedzi = $this->konwertujNaWielblada($opisKolumny['nazwa']);
		$this->szablon->ustawBlok('/PODPOWIEDZ', array());
		$this->szablon->ustawBlok('/PODPOWIEDZ/ETYKIETA', array(
			'NAZWA' => $nazwaPodpowiedzi,
			'KOMENTARZ' => '',
		));

		$this->szablon->ustawBlok('/PODPOWIEDZ/OPIS', array(
			'NAZWA' => $nazwaPodpowiedzi,
			'KOMENTARZ' => '',
		));

		if (count($this->pobierzWartosciEnuma($opisKolumny, $this->nazwaTabeli)) > 0)
		{
			$this->szablon->ustawBlok('/PODPOWIEDZ/WARTOSCI', array(
				'NAZWA' => $nazwaPodpowiedzi,
				'KOMENTARZ' => '',
			));
		}
	}



	/**
	 * Ustawia poszczególne tłumaczenia: etykieta, opis i ewentualne wartości dopuszczalne
	 * @param array $opisKolumny
	 */
	private function ustawTlumaczenie($opisKolumny)
	{
		$nazwa = $this->konwertujNaWielblada($opisKolumny['nazwa']);
		$this->szablon->ustawBlok('/TLUMACZENIE', array());
		$this->szablon->ustawBlok('/TLUMACZENIE/ETYKIETA', $this->pobierzWartosciTlumaczenia($nazwa, 'etykieta', 'stara_etykieta', 'podaj_etykieta'));
		$this->szablon->ustawBlok('/TLUMACZENIE/OPIS', $this->pobierzWartosciTlumaczenia($nazwa, 'opis', 'stary_opis', 'podaj_opis'));

		$wartosci = $this->pobierzWartosciEnuma($opisKolumny, $this->nazwaTabeli);
		if (count($wartosci) > 0)
		{
			$this->szablon->ustawBlok('/TLUMACZENIE/WARTOSCI', array(
				'NAZWA' => $nazwa,
				'KOMENTARZ' => '',
			));
			foreach ($wartosci as $wartoscNazwa)
			{
				$istniejeStara = isset($this->tlumaczeniaDomyslne[$nazwa]['wartosci'][$wartoscNazwa]);
				$wartosc = $istniejeStara ? $this->tlumaczeniaDomyslne[$nazwa]['wartosci'][$wartoscNazwa] : '';
				$komentarz = $istniejeStara ? 'stara_wartosc' : 'podaj_wartosc';
				$this->szablon->ustawBlok('/TLUMACZENIE/WARTOSCI/WARTOSC', array(
					'NAZWA' => $wartoscNazwa,
					'WARTOSC' => $wartosc,
					'KOMENTARZ' => $this->t['todo'] . $this->t[$komentarz],
				));
			}
		}
	}



	private function pobierzWartosciTlumaczenia($nazwaKolumny, $czegoDotyczy, $jestKomentarz, $nieMaKomentarz)
	{
		$czyIstniejeStara = isset($this->tlumaczeniaDomyslne[$nazwaKolumny][$czegoDotyczy]);
		$wartosc = $czyIstniejeStara ? $this->tlumaczeniaDomyslne[$nazwaKolumny][$czegoDotyczy] : '';
		$komentarz = $czyIstniejeStara ? $jestKomentarz : $nieMaKomentarz;
		return array(
			'NAZWA' => $nazwaKolumny,
			'WARTOSC' => $wartosc,
			'KOMENTARZ' => $this->t['todo'] . $this->t[$komentarz],
		);
	}



	/**
	 * Wczytuje istniejący obiekt tłumaczeń do pamięci
	 */
	private function inicjujObiekt()
	{
		$sciezkaDoObiektu = $this->katalogTlumaczen . '/' . $this->jezyk . '/' . $this->modulCzyModel . '/' . $this->nazwaObiektuModelu;

		if (!file_exists($sciezkaDoObiektu))
		{
			$this->tlumaczeniaDomyslne = array();
			$this->czyObiektIstnieje = false;
			return;
		}

		$sciezkaObiektu = '\\Generic\\Tlumaczenie\\' . $this->jezyk . '\\' . $this->modulCzyModel . '\\' . str_replace('.php', '', $this->nazwaObiektuModelu);

		$this->obiekt = new $sciezkaObiektu();

		if ($this->obiekt == null)
		{
			$this->czyObiektIstnieje = false;
		}
		$this->tlumaczeniaDomyslne = $this->obiekt->t;
		$this->czyObiektIstnieje = true;
		$this->przygotujStareTlumaczenia();
	}



	/**
	 * Przetwarza tłumaczenia do łatwiejszej w porównywaniu postaci
	 */
	private function przygotujStareTlumaczenia()
	{
		$tlumaczenia = array();
		foreach ($this->tlumaczeniaDomyslne as $tlumaczenie => $wartosc)
		{
			list($nazwaPola, $typ) = explode('.', $tlumaczenie);
			$tlumaczenia[$nazwaPola][$typ] = $wartosc;
		}
		$this->tlumaczeniaDomyslne = $tlumaczenia;
	}



	public function pokazPodsumowanie()
	{
		echo $this->pobierzLog();
	}



}