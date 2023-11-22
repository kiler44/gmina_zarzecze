<?php
namespace Generic\Model\BlokOpisowy;
use Generic\Biblioteka\ObiektDanych;


/**
 * Klasa odwzorowująca blok opisowy.
 * @author Krzysztof Lesiczka, Łukasz Wrucha
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $idProjektu
 * @property string $kodJezyka
 * @property int $idBloku
 * @property string $tytul
 * @property string $tresc
 * @property int $idAutora
 * @property string $dataDodania
 */

class Obiekt extends ObiektDanych
{

	/**
	 * pola obslugiwane przez obiekt
	 * @var array
	 */
	protected $_pola = array(
		'id',
		'idProjektu',
		'kodJezyka',
		'idBloku',
		'tytul',
		'tresc',
		'idAutora',
		'dataDodania',
	);

}

