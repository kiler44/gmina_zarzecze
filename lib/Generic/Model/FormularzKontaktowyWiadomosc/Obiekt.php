<?php
namespace Generic\Model\FormularzKontaktowyWiadomosc;
use Generic\Biblioteka\ObiektDanych;


/**
 * Klasa odwzorowująca wiadomości z formularza kontaktowego.
 * @author Łukasz Wrucha
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $idProjektu
 * @property string $kodJezyka
 * @property int $idKategorii
 * @property int $idTematu
 * @property string $tresc
 * @property string $dataWyslania
 * @property string $imie
 * @property string $nazwisko
 * @property string $firmaNazwa
 * @property string $stronaWWW
 * @property string $gg
 * @property string $skype
 * @property string $telefon
 * @property string $komorka
 * @property string $fax
 * @property int $idUzytkownika
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
		'idTematu',
		'tresc',
		'dataWyslania',
		'imie',
		'nazwisko',
		'nadawca',
		'firmaNazwa',
		'stronaWWW',
		'gg',
		'skype',
		'telefon',
		'komorka',
		'fax',
		'idUzytkownika',
	);
}
