<?php
namespace Generic\Model\FormularzKontaktowyTemat;
use Generic\Biblioteka\ObiektDanych;


/**
 * Klasa odwzorowująca tematy formularza kontaktowego.
 * @author Łukasz Wrucha
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $idProjektu
 * @property string $kodJezyka
 * @property int $idKategorii
 * @property string $temat
 * @property string $email
 * @property string $emailDw
 * @property array $konfiguracja
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
		'temat',
		'email',
		'emailDw',
		'konfiguracja',
	);
}
