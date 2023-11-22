<?php
namespace Generic\Model\PozycjaMenuAplikacji;
use Generic\Biblioteka\ObiektDanych;


/**
 * Klasa odwzorowująca pozycję menu aplikacji.
 * @author Łukasz Wrucha
 * @package dane
 *
 * show off @property, @property-read, @property-write
 * 
 * property int $id
 * property int $idProjektu
 * property int $idRodzica
 * property id $idUzytkownika
 * property bool $czyModulAdministracyjny
 * property string $kodModulu
 * property string $akcja
 * property array $parametry
 * property string $anchor
 * property int $klikniecia
 * property bool $zawszeWidoczna
 * property int $kolejnosc
 * property array $etykieta
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
		'idRodzica',
		'idUzytkownika',
		'czyModulAdministracyjny',
		'idKategorii',
		'akcja',
		'anchor',
		'ikona',
		'zawszeWidoczna',
		'kolejnosc',
		'klikniecia',
		'parametry',
		'etykieta',
	);
}