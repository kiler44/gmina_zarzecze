<?php
namespace Generic\Model\EmailSzablon;
use Generic\Biblioteka\ObiektDanych;


/**
 * Klasa odwzorowująca szablon emaila.
 * @author Krzysztof Lesiczka
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property string $id
 * @property string $nazwa
 * @property string $trescHtml
 * @property string $trescTxt
 * @property bool $aktywny
 *
 */

class Obiekt extends ObiektDanych
{

	/**
	 * @var \Generic\Konfiguracja\Model\ZamowienieTyp\Obiekt
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Model\ZamowienieTyp\Obiekt
	 */
	protected $j;

}
