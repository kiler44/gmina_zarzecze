<?php

namespace Generic\Biblioteka\Kreator;

use \Generic\Biblioteka;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Kreator
 *
 * @author Marek Bar
 */
class Kreator
{

	/**
	 * Używać tylko do celu zbierania informacji o błędach. Zawiera podsumowanie działąnia danego generatorka.
	 * @var string
	 */
	protected $podsumowanie = array();

	/**
	 * Katalog w którym są przechowywane szablony klas: Definicja, Obiekt, Mapper, Sorter, Tlumaczenie i Konfiguracja.
	 * @var string
	 */
	protected $katalogSzablonow;

	/**
	 * Katalog, w którym mają być umieszczane wygenerowane pliki klasa: Definicja, Obekt, Mapper i Sorter.
	 * @var string
	 */
	protected $katalogModel;

	/**
	 * Katalog, w którym mają być umieszczane wygenerowane pliki klas: Tlumaczenie.
	 * @var string
	 */
	protected $katalogTlumaczen;

	/**
	 * Katalog, w którym mają być umieszczane wygenerowane pliki klas: Konfiguracja.
	 * @var string
	 */
	protected $katalogKonfiguracji;

	/**
	 * Ścieżka do katalogu Generic
	 * @var string
	 */
	protected $katalogGeneric;

	/**
	 * Przechowuje dostępne walidatory w systemie
	 * @var array
	 */
	protected $dostepneWalidatory = array();

	/**
	 * Przechowuje dostępny inputy w systemie
	 * @var array
	 */
	protected $dostepneInputy = array();

	/**
	 * Ścieżka do pliku szablonu danej klasy. Należy ustawić w konstruktorze.
	 * @var string
	 */
	protected $sciezkaDoPlikuSzablonu;

	/**
	 * Obiekt odpowiedzialny za generowanie kodu PHP z szablonu.
	 * @var Generic\Biblioteka\Szablon
	 */
	protected $szablon;
	protected $czyPlikMaNazweObiektu = false;

	/**
	 * Nazwa generowanej klasy PHP.
	 * @var string
	 */
	protected $nazwaGenerowanegoPliku;

	/**
	 * Nazwa pliku szablonu na podstawie którego zostanie wygenerowany kod PHP.
	 * @var string
	 */
	protected $nazwaPlikuSzablonu;

	/**
	 * Przechowuje zainicjowany obiekt
	 * @var mixed
	 */
	protected $obiekt = null;

	/**
	 * Czy obiekt został zainicjowany i utworzony?
	 * @var bool
	 */
	protected $czyObiektIstnieje = false;

	/**
	 * Zapisuje komunikat o przebiegu działania generatora
	 * @param string $tekst
	 */
	protected function log($tekst)
	{
		$this->podsumowanie[] = $tekst;
	}



	/**
	 * Ustawia ścieżki do katalogów używanych przez kreator.
	 */
	protected function inicjujKatalogi()
	{
		$this->katalogGeneric = CMS_KATALOG . '/lib/Generic';
		$this->katalogSzablonow = CMS_KATALOG . '/szablon_system/konsola';
		$this->katalogModel = $this->katalogGeneric . '/Model';
		$this->katalogTlumaczen = $this->katalogGeneric . '/Tlumaczenie';
		$this->katalogKonfiguracji = $this->katalogGeneric . '/Konfiguracja';
	}



	/**
	 * Zwraca sformatowane komunikaty, gotowe do wyświetlenia
	 * @return string
	 */
	protected function pobierzLog()
	{
		$tekst = '';
		if (count($this->podsumowanie) > 0)
		{
			$tekst .= $this->t['tytul'];
		}
		foreach ($this->podsumowanie as $trescWpisuLoga)
		{
			$tekst .= "\n * " . $trescWpisuLoga;
		}
		$tekst = $tekst != '' ? $tekst . "\n" : '';
		return $tekst;
	}



	/**
	 * Odczytuje walidatory jak jeszcze tego nie zrobiono.
	 * @return mixed
	 */
	protected function utworzListeWalidatorow()
	{
		if (!empty($this->dostepneWalidatory))
		{
			return;
		}
		$sciezkaDoKataloguWalidatorow = $this->katalogGeneric . '/Biblioteka/Walidator';
		$katalog = new Biblioteka\Katalog($sciezkaDoKataloguWalidatorow);
		if (!$katalog->istnieje())
		{
			return array();
		}

		$plikiWalidatorow = $this->pobierzListePlikow('php', $katalog, false);
		foreach ($plikiWalidatorow as $nazwaPlikuWalidatora)
		{
			$this->dostepneWalidatory[] = str_replace('.php', '', $nazwaPlikuWalidatora);
		}
	}



	/**
	 * Odczytuje inputy jak jeszcze tego nie zrobiono.
	 */
	protected function utworzListeInputow()
	{
		if (!empty($this->dostepneInputy))
		{
			return;
		}
		$sciezkaDoKataloguInputow = $this->katalogGeneric . '/Biblioteka/Input';
		$katalog = new Biblioteka\Katalog($sciezkaDoKataloguInputow);
		if (!$katalog->istnieje())
		{
			return array();
		}

		$plikiInputow = $this->pobierzListePlikow('php', $katalog, false);
		foreach ($plikiInputow as $nazwaPlikuInputa)
		{
			$this->dostepneInputy[] = str_replace('.php', '', $nazwaPlikuInputa);
		}
	}



	/**
	 * Zwraca pliki o podanym rozszerzeniu ze wskazanego katalogu
	 * @param string $folder - katalog gdzie ma szukać - domyślnie można pominąć i będzie to główny katalog strony
	 * @param string $filter - jakie rozszerzenie mają mieć pliki
	 * @return array - tablica plików z pełną ścieżką dostępu
	 */
	protected function pobierzListePlikow($filter, $folder = '', $pelnaSciezka = true)
	{
		if ($folder == '')
		{
			$folder = FOLDER_STRONY;
		}
		rtrim($folder, '/');
		$lista = array();
		$uchwyt = opendir($folder);
		while ($nazwa = readdir($uchwyt))
		{
			if (substr($nazwa, 0, 1) != '.')
			{
				$rozbite = explode('.', $nazwa);
				if (isset($rozbite[1]))
				{
					if ($rozbite[1] == $filter)
					{
						if ($pelnaSciezka)
						{
							$lista[] = $folder . '/' . $nazwa;
						}
						else
						{
							$lista[] = $nazwa;
						}
					}
				}
			}
		}
		closedir($uchwyt);
		return $lista;
	}



	/**
	 * Zachowuje wartości, które nie występują w tabeli $nowe, a są w $stare
	 * @param array $stare
	 * @param array $nowe
	 * @return array
	 */
	protected function zachowajStare($stare, $nowe)
	{
		$wartosciDoZachowania = array();
		foreach ($stare as $staraWartosc)
		{
			if (!in_array($staraWartosc, $nowe))
			{
				$wartosciDoZachowania[] = $staraWartosc;
			}
		}
		return $wartosciDoZachowania;
	}



	/**
	 * Konwertuje tekst na styl CamelCase
	 * @param string $tekst
	 * @param bool $czyZaczynacOdPierwszejLitery - domyślnie jest ustawione na nie
	 * @return string - CamelCase
	 */
	protected function konwertujNaWielblada($tekst, $czyZaczynacOdPierwszejLitery = false)
	{
		if ($tekst == '')
		{
			return '';
		}
		if ($czyZaczynacOdPierwszejLitery)
		{
			$tekst[0] = strtoupper($tekst[0]);
		}

		$func = create_function('$c', 'return strtoupper($c[1]);');
		return preg_replace_callback('/_([a-z])/', $func, $tekst);
	}



	/**
	 * Zwraca pierwszy klucz z tablicy. array_shift(array_keyes($tab)) - jest niezgodne ze standardem PHP 5.4
	 * @param array $tablica
	 * @return string
	 */
	protected function pobierzPierwszyKlucz($tablica)
	{
		if (!is_array($tablica))
		{
			return '';
		}
		return key($tablica);
	}



	/**
	 * Inicjuje szablon pliku PHP
	 * @return boolean
	 */
	public function inicjujSzablon()
	{
		$sciezkaDoPlikuSzablonu = $this->katalogSzablonow . '/' . $this->nazwaPlikuSzablonu;

		$plik = new Biblioteka\Plik($sciezkaDoPlikuSzablonu);
		if (!$plik->istnieje())
		{
			$this->log($this->t['szablon_nie_istneje'] . $sciezkaDoPlikuSzablonu);
			return false;
		}

		$this->szablon = new Biblioteka\Szablon();
		$this->szablon->ladujTresc($plik->pobierzZawartosc());
		return true;
	}



	/**
	 * Sprawdza czy w podany tekst kończy się na podaną frazę
	 * @param string $fragment - fraza, na którą kończy się tekst lub zaczyna
	 * @param string $wCzym - przeszukiwany tekst
	 * @return boolean
	 */
	protected function czyKonczyLubZaczynaNa($fragment, $wCzym)
	{
		$fragment = strtolower($fragment);
		$dlugosc = strlen($fragment);
		$dlugoscPrzeszukiwanego = strlen($wCzym);

		if ($dlugoscPrzeszukiwanego < $dlugosc)
		{
			return false;
		}

		$poczatek = strtolower(substr($wCzym, 0, $dlugosc));
		$koniec = strtolower(substr($wCzym, $dlugoscPrzeszukiwanego - $dlugosc, $dlugoscPrzeszukiwanego));

		if ($fragment == $poczatek || $fragment == $koniec)
		{
			return true;
		}
		else
		{
			return false;
		}
	}



	/**
	 * Opakowuje tekst w znaki podane w ciele tej funkcji.
	 * @param string $nazwa
	 * @return string
	 */
	protected function zabezpieczNazwe($nazwa)
	{
		return '[' . $nazwa . ']';
	}



}

