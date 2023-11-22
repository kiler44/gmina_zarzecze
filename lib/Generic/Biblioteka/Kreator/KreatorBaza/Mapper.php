<?php

namespace Generic\Biblioteka\Kreator\KreatorBaza;

use Generic\Biblioteka\Kreator;

/**
 * Pozwala wygenerować kod PHP klasy Mapper.
 * @author Marek Bar
 */
class Mapper extends Kreator\KreatorBaza
{

	private $tabela;
	private $polaTabeliObiekt;
	private $polaTabeliKlucz;
	private $uzyteKlucze = array();
	public $czyObiektIstnieje = false;
	protected $t = array(
		'todo' => '//TODO: ',
		'nazwa_tabeli_rozna' => ' - stara nazwa tabeli, użyto nazwy tabeli z bazy',
		'juz_nie_jest_kluczem' => ' - ta kolumna już nie jest częścią klucza',
	);

	/**
	 * Konstruktor ustawiający nazwę generowanego pliku i nazwę pliku jego szablonu.
	 */
	function __construct($nazwaBazy = 'crm')
	{
		$this->nazwaBazy = $nazwaBazy;
		$this->polacz();
		$this->nazwaGenerowanegoPliku = 'Mapper.php';
		$this->nazwaPlikuSzablonu = 'szablon_mapper.tpl';
	}



	/**
	 * Generuje kod PHP klasy Mapper dla podanej tabeli.
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
			$this->ustawKlucze($opisKolumny);
			$this->ustawPola($opisKolumny);
		}


		$nazwaTabeli = $this->konwertujNaWielblada($nazwaTabeli, true);
		$nazwaUzytkownika = $this->konwertujNaWielblada($nazwaUzytkownika,true);
		if ($nazwaUzytkownika != '' && $nazwaUzytkownika != $nazwaTabeli)
		{
			$nazwaTabeli = $nazwaUzytkownika;
		}
		$zwracanyObiekt = 'Generic\\Model\\' . $this->nazwaObiektuModelu . '\\Obiekt';
		
		$wygenerowanyKodMappera = $this->szablon->parsujBlok('/', array(
			'NAZWA' => $this->nazwaObiektuModelu,
			'NAZWA_TABELI_W_BAZIE' => $this->nazwaTabeli,
			'KOMENTARZ_TABELI' => $nazwaTabeli != $this->tabela && $this->tabela != '' ? $this->t['todo'] . $this->tabela . $this->t['nazwa_tabeli_rozna'] : '',
			'ZWRACANY_OBIEKT' => $zwracanyObiekt,
		));

		return $this->zapiszKodDoPliku($nazwaUzytkownika, $this->katalogModel, $this->nazwaGenerowanegoPliku, $wygenerowanyKodMappera);
	}



	/**
	 * Pokazuje informacje na temat wyników generowania mappera
	 * @return string
	 */
	public function pokazPodsumowanie()
	{
		return $this->pobierzLog();
	}



	/**
	 * Inicjuje obiekt mappera, jeśli istnieje
	 * @return boolean
	 */
	public function inicjujObiekt()
	{
		$sciezkaDoObiektu = $this->katalogModel . '/' . $this->nazwaObiektuModelu . '/' . $this->nazwaGenerowanegoPliku;
		if (!file_exists($sciezkaDoObiektu))
		{
			$this->tabela = '';
			$this->polaTabeliKlucz = array();
			$this->polaTabeliObiekt = array();
			$this->czyObiektIstnieje = false;
			return;
		}

		$sciezkaObiektu = '\\Generic\\Model\\' . $this->nazwaObiektuModelu . '\\' . str_replace('.php', '', $this->nazwaGenerowanegoPliku);

		$this->obiekt = new $sciezkaObiektu();

		if ($this->obiekt == null)
		{
			$this->czyObiektIstnieje = false;
		}

		$this->tabela = isset($this->obiekt->tabela) ? $this->obiekt->tabela : '';
		$this->polaTabeliKlucz = isset($this->obiekt->polaTabeliKlucz) ? $this->obiekt->polaTabeliKlucz : array();
		$this->polaTabeliObiekt = isset($this->obiekt->polaTabeliObiekt) ? $this->obiekt->polaTabeliObiekt : array();
		$this->czyObiektIstnieje = true;
	}



	/**
	 * Odczytuje i generuje kod kluczy tabeli
	 * @param array $opisKolumny
	 */
	private function ustawKlucze($opisKolumny)
	{
		if ($opisKolumny['czy_klucz'])
		{
			$this->szablon->ustawBlok('/POLA_TABELI_KLUCZ', array(
				'POLE_BEDACE_CZESCIA_KLUCZA' => $opisKolumny['nazwa'],
				'KOMENTARZ1' => '',
				'KOMENTARZ2' => '',
			));
			$this->uzyteKlucze[] = $opisKolumny['nazwa'];
		}
	}



	/**
	 * Odczytuje i generuje kod pól tabeli
	 * @param array $opisKolummy
	 */
	private function ustawPola($opisKolumny)
	{
		$this->szablon->ustawBlok('/POLA_TABELI_OBIEKT', array(
			'OBIEKT_POLE' => $this->konwertujNaWielblada($opisKolumny['nazwa'], false),
			'TABELA_KOLUMNA' => $opisKolumny['nazwa'],
		));
	}



}