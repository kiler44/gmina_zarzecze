<?php
namespace Generic\Model\Obserwator;
use Generic\Biblioteka\ObiektDanych;


/**
 * Klasa odwzorowująca moduł obserwator.
 * @author Krzysztof Żak
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property string $id
 * @property string $opis
 * @property string $typ
 * @property string $obiekt_docelowy
 * @property array $ustawienia
 * @property array $zdarzenia
 *
 */

class Obiekt extends ObiektDanych
{

	static protected $_typy = array(
		'DoPliku',
		'DoBazy',
		'NaMail',
		'Email',
	);



	public function ustawTyp($wartosc)
	{
		$this->poleSprawdzUstawWartosc('typ', $wartosc, self::$_typy);
	}



	static function pobierzDostepneTypy()
	{
		return self::$_typy;
	}

}
