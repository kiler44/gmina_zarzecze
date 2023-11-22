<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\Cms;


/**
 * Klasa odpowiedzialna za sparsowanie danych o przelewach i zwrócenie ich
 * w formacie, który umożliwi dalsze operowanie danymi w systemie.
 *
 * @author Konrad Rudowski
 * @package biblioteki
 */

abstract class PrzelewyParser
{
	/**
	 * Przetrzymuje dane wejściowe
	 *
	 * @var String
	 */
	protected $dane;


	/**
	 * Przetrzymuje dane wyjściowe
	 *
	 * @var Array
	 */
	protected $daneWyjsciowe;

	/**
	 * Przetrzymuje wyrażenie regularne definujące budowę numery faktury proforma
	 *
	 * @var String
	 */
	protected $formatNrProformy = '/(FPF\/S[T|W|A]\/[0-9]{2}\/[0-9]{2}\/[0-9]{4}\/[0-9]+\/?[0-9]{1,5}?)/i';


	/**
	 * Wczytuje dane wejściwe z pliku
	 *
	 * @param String $sciezkaPliku ścieżka do pliku, z którego będą wczytane dane
	 *
	 * @return null
	 */
	public function daneZPliku($sciezkaPliku)
	{
		$plik = new Plik($sciezkaPliku);
		$this->dane = $plik->pobierzZawartosc();
	}


	/**
	 * Wczytuje dane wejściwe z łańcucha tekstowego
	 *
	 * @param String $daneString dane do analizy
	 *
	 * @return null
	 */
	public function daneZeString($daneString)
	{
		$this->dane = $daneString;
	}


	protected abstract function przetworzDane();


	/**
	 * Ustawia format zapisu faktury
	 *
	 * @param String $format format zapisu w postaci regex'a
	 *
	 * @return null
	 */
	public function ustawFormatNrFaktury($format)
	{
		$this->formatNrFaktury = $format;
	}


	/**
	 * Rozpoczyna parsowanie danych i zwraca przeanalizowane przelewy przychodzące
	 *
	 * @return Array
	 */
	public function parsujDane()
	{
		$this->przetworzDane();

		return $this->daneWyjsciowe;
	}


	/**
	 * Pozyskuje idUzytkownika na podstawie końcówki indywidualnego numeru konta
	 *
	 * @param String $postfixNrKonta końcówka numeru konta
	 *
	 * @return Array
	 */
	protected function dopasujPoNrKonta($postfixNrKonta)
	{
		$dane = array();

		$uzytkownik = Cms::inst()->dane()->Uzytkownik()->zwracaTablice(array('id'))->pobierzPoNrKonta($postfixNrKonta);

		if (isset ($uzytkownik['id']) && $uzytkownik['id'] > 0)
		{
			return array(
				'dopasowanie' => 'NRKONTA',
				'idUzytkownika' => $uzytkownik['id']
			);
		}

		return array(
			'dopasowanie' => 'BRAK',
			'idUzytkownika' => null,
		);
	}


	/**
	 * Pozyskuje idUzytkownika na podstawie nr proformy
	 *
	 * @param String $tytulPrzelewu
	 *
	 * @return Array
	 */
	protected function dopasujPoNrProformy($tytulPrzlewu)
	{
		$tytulPrzlewu = str_replace(' ', '', $tytulPrzlewu);

		if (preg_match_all($this->formatNrProformy, $tytulPrzlewu, $znalezione) !== false && isset($znalezione[0][0]))
		{
			$idUzytkownikow = array();

			foreach (Cms::inst()->dane()->Dokument()->zwracaTablice('id_uzytkownika')->szukaj(array('fraza' => $znalezione[0][0])) as $wartosc)
			{
				$idUzytkownikow[] = $wartosc['id_uzytkownika'];
			}

			$idUzytkownikow = array_unique($idUzytkownikow);

			if (count($idUzytkownikow) == 1)
			{
				return array(
					'dopasowanie' => 'PROFORMA',
					'idUzytkownika' => $idUzytkownikow[0]
				);
			}
		}

		return array(
			'dopasowanie' => 'BRAK',
			'idUzytkownika' => null,
		);
	}
}
