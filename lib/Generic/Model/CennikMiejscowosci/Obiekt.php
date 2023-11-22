<?php
namespace Generic\Model\CennikMiejscowosci;
use Generic\Biblioteka\ObiektDanych;


/**
 * Klasa odwzorowująca ceny za trasę do odpowiednich miejscowości.
 * @author Łukasz Wrucha
 * @package dane
 *
 * show off @property, @property-read, @property-write
 * 
 * property int $id
 * property int $idProjektu
 * property string $kodPocztowy
 * property string $miejscowosc
 * property int $cena
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
		'kodPocztowy',
		'miejscowosc',
		'cena',
	);
}