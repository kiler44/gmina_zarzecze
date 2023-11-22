<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\FakturaRatalna;


/**
 * Obsluga generowania faktur zaliczkowych. Tworzy fakturę główną oraz 2 raty:
 * 1. W ciągu oznaczonej liczby dni
 * 2. Drugą ez dokładnie określonego terminu płatności (np. 7 dni po mwykonaniu usługi)
 *
 * @author Konrad Rudowski
 * @package biblioteki
 */

class FakturaZaliczkowa extends FakturaRatalna
{

	/**
	 * Wartość procentowa raty zaliczkowej
	 */

	protected $_procentZaliczki = 50;


	protected $_terminPlatnosciEtykieta = 'W ciągu %d dni od wykonania usługi.';

	/**
	 * Tytuł wstawiany do raty
	 *
	 * @var string
	 */
	protected $_fragmentTytuluRaty = 'Opłata do faktury ';

	/**
	 * Ustawia procentową warość raty zaliczkowej
	 *
	 * @param int $procent
	 */

	function ustawProcentZaliczki($procent)
	{
		$procent = intval($procent);

		if ($procent > 0 && $procent < 100)
		{
			$this->_procentZaliczki = $procent;
		}
		else
		{
			trigger_error('Błąd. Niewłaściwy procent zaliczki.', E_USER_WARNING);
		}
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

		return true;
	}


	/**
	 * Przygotowuje system do wygenerowania faktur
	 *
	 * @return bool
	 */
	protected function przygotujFakture()
	{
		parent::przygotujFaktureGlowna();

		//mamy przeliczone pozycje ustawiamy parametry rat

		$this->utworzRatyZaliczka();

		if ( ! $this->przeliczRaty())
		{
			trigger_error('Błąd. Nie przeliczono rat.', E_USER_WARNING);
			return false;
		}

		return true;

	}



	protected function utworzRatyZaliczka()
	{

		$this->_daneRat = array();

		$wartoscZaliczki = intval($this->_calkowitaWartoscNetto * ($this->_procentZaliczki / 100));
		$wartoscPozostala = $this->_calkowitaWartoscNetto - $wartoscZaliczki;

		$this->dodajRate($wartoscZaliczki, $this->_terminPlatnosciDni);
		$this->dodajRate($wartoscPozostala, $this->_terminPlatnosciDni);
	}


	protected function ustawWartosciRatyTabelka($rata)
	{
		switch($rata['nrRaty'])
		{
			case 1:
				$rata['RATA_NAZWA'] = 'Opłata zaliczkowa';
				break;
			case 2:
				$rata['RATA_NAZWA'] = 'Opłata końcowa';
				break;
		}

		if ($rata['nrRaty'] > 1)
		{
			$rata['RATA_TERMIN'] = sprintf($this->_terminPlatnosciEtykieta, $this->_terminPlatnosciDni);
		}
		else
		{
			$rata['RATA_TERMIN'] = $rata['terminPlatnosci']->format($this->_formatDatyNaFakturze);
		}

		return $rata;
	}

	protected function ustawWartosciRatyDokument($daneRaty, $rata)
	{
		$daneRaty['FAKTURA_NUMER'] =  $this->_fragmentTytuluRaty . $this->_fakturaNumer;
		$daneRaty['FAKTURA_DATA_WYSTAWIENIA'] = 	$this->_dataWystawienia->format($this->_formatDatyNaFakturze);

		if ($rata['nrRaty'] > 1)
		{
			$daneRaty['FAKTURA_DATA_ZAPLATY'] = 'PO_WYKONANIU_USLUGI';
		}
		else
		{
			$daneRaty['FAKTURA_DATA_ZAPLATY'] = $rata['terminPlatnosci']->format($this->_formatDatyNaFakturze);
		}

		$daneRaty['FAKTURA_SUMA'] = number_format($rata['kwotaBrutto'], 2, ',', '');

		return $daneRaty;
	}

	protected function zapiszDokumentyFaktury()
	{
		return true;
	}

	/**
	 * W wygenerowanym wcześniej dokumencie drugiej raty jest mijesce na datę, ta metoda ją ustawia.
	 *
	 * @param string $htmlRaty - kod HTML 2 raty faktury zaliczkowej
	 * @param int $terminPlatnosciDni
	 *
	 * @return string
	 */


	public static function oznaczTerminPlatnosciDrugiejRaty($htmlRaty, $terminPlatnosciDni)
	{
		$terminPlatnosciDni = intval(abs($terminPlatnosciDni));

		$terminPlatnosci = new \DateTime('now', new \DateTimeZone('Europe/Warsaw'));
		$terminPlatnosci->modify('+ ' . $terminPlatnosciDni . ' day');

		if ( !strpos($htmlRaty, 'PO_WYKONANIU_USLUGI'))
		{
			trigger_error('Błąd. Nieprawidłowy HTML raty.', E_USER_WARNING);
			return null;
		}

		return str_replace('PO_WYKONANIU_USLUGI', $terminPlatnosci->format('d.m.Y'), $htmlRaty);
	}

	/**
	 *
	 * @param type $cena
	 */
	protected function formatujCene($cena)
	{
		if (strpos($cena, '.') > 0)
		{
			return round($cena, 2);
		}
		else
		{
			return $cena;
		}
	}

	protected function generujHtmlRaty($rata)
	{
		switch($rata['nrRaty'])
		{
			case 1:
				$this->_fragmentTytuluRaty = 'Opłata zaliczkowa do faktury ';
				break;
			case 2:
				$this->_fragmentTytuluRaty = 'Opłata końcowa do faktury ';
				break;
		}

		return parent::generujHtmlRaty($rata);
	}

}