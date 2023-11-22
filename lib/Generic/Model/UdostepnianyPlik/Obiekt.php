<?php
namespace Generic\Model\UdostepnianyPlik;
use Generic\Biblioteka\ObiektDanych;


/**
 * Klasa odwzorowująca pliki udostępniany.
 * @author Krzysztof Lesiczka, Dariusz Półtorak
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $idProjektu
 * @property string $kodJezyka
 * @property int $idKategorii
 * @property string $tytul
 * @property string $plik
 * @property string $tresc
 * @property string $dataDodania
 * @property string $dataWaznosci
 * @property int $publikuj
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
		'idKategorii',
		'tytul',
		'plik',
		'tresc',
		'autor',
		'dataDodania',
		'dataWaznosci',
	);
}
