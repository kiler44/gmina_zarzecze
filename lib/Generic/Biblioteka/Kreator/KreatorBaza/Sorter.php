<?php

namespace Generic\Biblioteka\Kreator\KreatorBaza;

use Generic\Biblioteka\Kreator;

/**
 * Pozwala wygenerować kog PHP klasy Sorter.
 * @author Marek Bar
 */
class Sorter extends Kreator\KreatorBaza
{

	public $czyObiektIstnieje = false;
	private $_rodzaje = array();

	/**
	 * Konstruktor ustawiający nazwę generowanego pliku i nazwę pliku jego szablonu.
	 */
	function __construct($nazwaBazy = 'crm')
	{
		$this->nazwaBazy = $nazwaBazy;
		$this->polacz();
		$this->nazwaGenerowanegoPliku = 'Sorter.php';
		$this->nazwaPlikuSzablonu = 'szablon_sorter.tpl';
	}



	/**
	 * Generuje kod PHP klasy Sorter dla podanej tabeli.
	 * @param string $nazwaTabeli
	 * @return boolean
	 */
	public function generuj($nazwaTabeli, $nazwaUzytkownika)
	{
		if (!$this->inicjuj($nazwaTabeli))
		{
			return false;
		}

		$this->czyObiektIstnieje = $this->inicjujObiekt();
		$stareKlucze = array_keys($this->_rodzaje);
		$noweKlucze = array();
		foreach ($this->opisKolumnTabeli as $nazwaKolumny => $opisKolumny)
		{
			$noweKlucze[] = $nazwaKolumny;
		}

		$stareKluczeNieDodane = array_values(array_diff($stareKlucze, $noweKlucze));

		foreach ($this->opisKolumnTabeli as $nazwaKolumny => $opisKolumny)
		{
			$this->szablon->ustawBlok('/RODZAJE_SORTOWANIA', array(
				'RODZAJ_SORTOWANIA' => $nazwaKolumny,
				'KOMENTARZ' => '',
			));
			if (!in_array($nazwaKolumny, $stareKlucze))
			{
				foreach ($this->opisKolumnTabeli as $nazwa => $opis)
				{
					if ($nazwa != $nazwaKolumny)
					{
						$this->szablon->ustawBlok('/RODZAJE_SORTOWANIA/FILTRY', array(
							'FILTR' => $nazwa,
							'WARTOSC' => 'ASC',
							'KOMENTARZ' => '//TODO:'
						));
					}
				}
			}
			else
			{
				$stareFiltry = isset($this->_rodzaje[$nazwaKolumny]) ? $this->_rodzaje[$nazwaKolumny] : array();

				foreach ($this->opisKolumnTabeli as $nazwa => $opis)
				{
					if ($nazwa != $nazwaKolumny)
					{
						$filtr = 'ASC';
						$komentarz = '//TODO:';
						if (isset($stareFiltry[$nazwa]) && $stareFiltry[$nazwa] != 'ASC')
						{
							$filtr = $stareFiltry[$nazwa];
							$komentarz = '//TODO: pozostawiono stary filtr';
						}
						$this->szablon->ustawBlok('/RODZAJE_SORTOWANIA/FILTRY', array(
							'FILTR' => $nazwa,
							'WARTOSC' => $filtr,
							'KOMENTARZ' => $komentarz,
						));
					}
				}
			}
		}

		foreach ($stareKluczeNieDodane as $nazwaKlucza)
		{
			$this->szablon->ustawBlok('/RODZAJE_SORTOWANIA', array(
				'RODZAJ_SORTOWANIA' => $nazwaKlucza,
				'KOMENTARZ' => '//TODO: znaleziony w pliku'
			));

			foreach ($this->_rodzaje[$nazwaKlucza] as $nazwaFiltra => $wartoscFiltra)
			{
				$this->szablon->ustawBlok('/RODZAJE_SORTOWANIA/FILTRY', array(
					'FILTR' => $nazwaFiltra,
					'WARTOSC' => $wartoscFiltra,
					'KOMENTARZ' => '//TODO: ten filtr został znaleziony w pliku',
				));
			}
		}

		$wygenerowanyKodMappera = $this->szablon->parsujBlok('/', array(
			'NAZWA' => $this->nazwaObiektuModelu,
			'DOMYSLNY_RODZAJ_SORTOWANIA' => $this->pobierzPierwszyKlucz($this->opisKolumnTabeli),
		));

		return $this->zapiszKodDoPliku($nazwaUzytkownika, $this->katalogModel, $this->nazwaGenerowanegoPliku, $wygenerowanyKodMappera);
	}



	public function pokazPodsumowanie()
	{
		echo $this->pobierzLog();
	}



	private function inicjujObiekt()
	{
		$sciezkaDoObiektu = $this->katalogModel . '/' . $this->nazwaObiektuModelu . '/' . $this->nazwaGenerowanegoPliku;
		if (!file_exists($sciezkaDoObiektu))
		{
			$this->log('Plik generowany po raz pierwszy');
			$this->_rodzaje = array();
			return false;
		}

		$sciezkaObiektu = '\\Generic\\Model\\' . $this->nazwaObiektuModelu . '\\' . str_replace('.php', '', $this->nazwaGenerowanegoPliku);

		$this->obiekt = new $sciezkaObiektu();

		if ($this->obiekt == null)
		{
			$this->log('Obiekt nie został zainicjalizowany.');
			return false;
		}
		$this->_rodzaje = $this->obiekt->_rodzaje;
	}



}