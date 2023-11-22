<?php
namespace Generic\Biblioteka\Tlumaczenia;
use Symfony\Component\Translation\MessageSelector;

/**
 * Klasa odpowiadająca za odmianę tłumaczeń uzależnioną od liczebników i zmiennych.
 *
 * @author Konrad Rudowski
 * @package biblioteki
 */

class Odmiana
{
	/**
	 * @var Symfony\Component\Translation\MessageSelector
	 */
	protected static $selektor;

	public static function odmien($tlumaczenie, $liczebnik)
	{
		if (! self::$selektor instanceof MessageSelector)
		{
			self::$selektor = new MessageSelector();
		}

		return strtr(self::$selektor->choose($tlumaczenie, $liczebnik, KOD_JEZYKA), array('%wartosc%' => $liczebnik));
	}
}

