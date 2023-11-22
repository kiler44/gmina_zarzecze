<?php
namespace Generic\Model\Mailing;
use Generic\Biblioteka\ObiektDanych;


/**
 * Klasa odwzorowująca liste wysylkowa.
 * @author Konrad Rudowski
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $idProjektu
 * @property string $kodJezyka
 * @property string $dataDodania
 * @property string $nazwa
 * @property string $tytul
 * @property string $tresc
 * @property string $trescHtml
 * @property string $plikZLista
 * @property string $dataWysylki
 * @property int $ileAdresow
 * @property int $ileWyslano
 * @property int $ileBledow
 * @property int $idZadaniaCron
 * @property string $dataZakonczenia
 * @property string $nazwaNadawcy
 * @property string $emailNadawcy
 * @property int $zaladujSzablon
 * @property int $pominSprawdzanieZgody
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
		'dataDodania',
		'nazwa',
		'tytul',
		'tresc',
		'trescHtml',
		'plikZLista',
		'dataWysylki',
		'ileAdresow',
		'ileWyslano',
		'ileBledow',
		'idZadaniaCron',
		'dataZakonczenia',
		'nazwaNadawcy',
		'emailNadawcy',
		'zaladujSzablon',
		'pominSprawdzanieZgody',
	);


}
