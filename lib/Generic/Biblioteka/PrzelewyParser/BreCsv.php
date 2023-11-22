<?php
namespace Generic\Biblioteka\PrzelewyParser;
use Generic\Biblioteka\PrzelewyParser;


/**
 * Klasa odpowiedzialna za sparsowanie danych o przelewach i zwrócenie ich
 * w formacie, który umożliwi dalsze operowanie danymi w systemie.
 * Obsługuje format BRE CSV.
 *
 * @author Konrad Rudowski
 * @package biblioteki
 */

class BreCsv extends PrzelewyParser
{

	/**
	 * Przechowuje kody transakcji IPH (na indywidualne konta bankowe)
	 *
	 * @var Array
	 */
	protected $kodyIph = array(911);


	/**
	 * Przechowuje kody zwykłych transakcji przychodzących
	 *
	 * @var Array
	 */
	protected $kodyPrzychodzace = array(760, 770, 771, 772, 773, 963);

	/**
	 * Przetwarza dane z formatu CSV i zwraca tablicę przelewów przychodzacyh
	 *
	 * @return Array
	 */
	protected function przetworzDane()
	{
		foreach (explode("\n", $this->dane) as $wiersz)
		{
			$wierszTablica = str_getcsv($wiersz, ';');

			if (count($wierszTablica) > 9 && $wierszTablica[0] == intval($wierszTablica[0]))
			{
				if (in_array($wierszTablica[2], $this->kodyIph))
				{
					$this->daneWyjsciowe[] = $this->parsujWierszIph($wierszTablica);
				}
				elseif (in_array($wierszTablica[2], $this->kodyPrzychodzace))
				{
					$this->daneWyjsciowe[] = $this->parsujWierszPrzychodzacy($wierszTablica);
				}
			}
		}
	}


	/**
	 * Analizuje dane przlewu na konto indywidualne.
	 * Parsuje wiersz, odnajduje odpowiednie idUzytkownika w sysytemie i zwraca
	 * sparsowane wartości
	 *
	 * @param Array $wiersz wiersz danych z pliku CSV
	 *
	 * @return Array
	 */
	protected function parsujWierszIph(Array $wiersz)
	{
		$dane = array(
			'typ' => 'IPH',
			'dataKsiegowania' => $wiersz[1],
			'kwota' => str_replace(',', '.', $wiersz[3]),
			'waluta' => $wiersz[4],
			'od' => trim(str_replace('od: ', '', iconv('cp1250', 'UTF-8', $wiersz[8]))),
			'tytul' => trim(str_replace('tyt.: ', '', iconv('cp1250', 'UTF-8', $wiersz[9]))),
			'idIph' => str_replace('ID IPH: XX', '', $wiersz[6]),
			'tnr' => str_replace('TNR: ', '', $wiersz[count($wiersz)  -1]),
		);

		if (strpos($wiersz[count($wiersz)  -2], 'data stempla: ') === 0)
		{
			$dane['dataStempla'] = str_replace('data stempla: ', '', $wiersz[count($wiersz)  -2]);
		}

		$dane['idIph'] = substr($dane['idIph'], 0, 4) . ' ' . substr($dane['idIph'], 4, 4) . ' ' . substr($dane['idIph'], 8, 4);

		$dane += $this->dopasujPoNrKonta($dane['idIph']);

		return $dane;
	}



	/**
	 * Analizuje dane zwykłego przelwu przychodzącego
	 * Parsuje wiersz, odnajduje odpowiednie idUzytkownika w sysytemie i zwraca
	 * sparsowane wartości
	 *
	 * @param Array $wiersz wiersz danych z pliku CSV
	 *
	 * @return Array
	 */
	protected function parsujWierszPrzychodzacy(Array $wiersz)
	{
		$dane = array(
			'typ' => 'PRZELEW',
			'dataKsiegowania' => $wiersz[1],
			'kwota' => str_replace(',', '.', $wiersz[3]),
			'waluta' => $wiersz[4],
			'od' => trim(str_replace('od: ', '', iconv('cp1250', 'UTF-8', $wiersz[7]))),
			'tytul' => trim(str_replace('tyt.: ', '', iconv('cp1250', 'UTF-8', $wiersz[8]))),
			'tnr' => str_replace('TNR: ', '', $wiersz[count($wiersz)  -1]),
		);

		$dane += $this->dopasujPoNrProformy($dane['tytul']);

		return $dane;
	}
}