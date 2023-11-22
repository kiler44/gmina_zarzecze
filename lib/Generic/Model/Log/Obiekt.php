<?php
namespace Generic\Model\Log;
use Generic\Biblioteka\ObiektDanych;


/**
 * Klasa odwzorowująca wiersz loga.
 * @author Krzysztof Lesiczka
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $idProjektu
 * @property string $kodJezyka
 * @property string $czas
 * @property string $adresIp
 * @property string $przegladarka
 * @property string $zadanieHttp
 * @property int $idUzytkownika
 * @property int $idKategorii
 * @property string $usluga
 * @property string $kodModulu
 * @property string $akcja
 * @property string $daneDodatkowe
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
		'czas',
		'adresIp',
		'przegladarka',
		'zadanieHttp',
		'idUzytkownika',
		'idKategorii',
		'usluga',
		'kodModulu',
		'akcja',
		'daneDodatkowe',
	);
}