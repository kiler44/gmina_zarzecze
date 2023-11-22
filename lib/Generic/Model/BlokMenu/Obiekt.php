<?php
namespace Generic\Model\BlokMenu;
use Generic\Biblioteka\ObiektDanych;


/**
 * Klasa odwzorowująca blok menu.
 * @author Krzysztof Lesiczka, Łukasz Wrucha
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $idProjektu
 * @property string $kodJezyka
 * @property int $idBloku
 * @property int $idKategorii
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
		'idKategorii',
	);

}