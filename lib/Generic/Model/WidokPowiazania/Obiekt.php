<?php
namespace Generic\Model\WidokPowiazania;
use Generic\Biblioteka\ObiektDanych;


/**
 * Klasa odwzorowująca powiązania widoków/układów z użytkownikiem/grupą/akcją.
 * @author Marek Bar
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $idProjektu
 * @property int $idWidoku
 * @property string $kodJezyka
 * @property int $uzytkownik
 * @property int $grupa
 * @property string $akcja
 *
 * dostepne tylko z poziomu cache
 * @property array $ukladBlokow
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
		'idWidoku',
		'kodJezyka',
		'uzytkownik',
		'grupa',
		'akcja',
		
	);

}
