<?php
namespace Generic\Model\PowiazanieTyp;
use Generic\Biblioteka\ObiektDanych;


/**
 * show off @property, @property-read, @property-write
 *
 * @property integer $id
 * @property string $nazwa
 * @property string $typ1
 * @property string $typ2
 */

class Obiekt extends ObiektDanych
{

	// pola obslugiwane przez obiekt
	protected $_pola = array(
		'id',
		'nazwa',
		'typ1',
		'typ2',
	);
}
