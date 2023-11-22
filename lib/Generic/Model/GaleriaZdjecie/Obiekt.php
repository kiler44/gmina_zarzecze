<?php
namespace Generic\Model\GaleriaZdjecie;
use Generic\Biblioteka\ObiektDanych;
/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $idProjektu
 * @property string $kodJezyka
 * @property int $idGalerii
 * @property string $nazwaPliku
 * @property string $tytul
 * @property string $opis
 * @property string $dataDodania
 * @property string $autor
 * @property int $publikuj
 * @property int $pozycja
 */

class Obiekt extends ObiektDanych
{

	// pola obslugiwane przez obiekt
	protected $_pola = array(
		'id',
		'idProjektu',
		'kodJezyka',
		'idGalerii',
		'nazwaPliku',
		'tytul',
		'opis',
		'dataDodania',
		'autor',
		'publikuj',
		'pozycja',
	);

}
