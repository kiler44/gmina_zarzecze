<?php
namespace Generic\Model\ZadanieCykliczne;
use Generic\Biblioteka\ObiektDanych;


/**
 * Klasa odwzorowująca zadania cykliczne.
 * @author Krzysztof Lesiczka, Łukasz Wrucha
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $idProjektu
 * @property string $kodJezyka
 * @property bool $aktywne
 * @property string $dataRozpoczecia
 * @property string $dataZakonczenia
 * @property string $minuty
 * @property string $godziny
 * @property string $dni
 * @property string $miesiace
 * @property string $dniTygodnia
 * @property int $idKategorii
 * @property string $kodModulu
 * @property string $akcja
 * @property string $opisZadania
 * @property int $dodawaneWielokrotnie
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
		'aktywne',
		'dataRozpoczecia',
		'dataZakonczenia',
		'minuty',
		'godziny',
		'dni',
		'miesiace',
		'dniTygodnia',
		'idKategorii',
		'kodModulu',
		'akcja',
		'opisZadania',
		'dodawaneWielokrotnie',
	);


	public function pobierzKodZadania()
	{
		if (isset($this->_wartosci['idKategorii']) && isset($this->_wartosci['kodModulu']) && isset($this->_wartosci['akcja']) &&
			$this->_wartosci['idKategorii'] != '' && $this->_wartosci['kodModulu'] != '' && $this->_wartosci['akcja'] != '')
		{
			return $this->_wartosci['kodModulu'].'_'.$this->_wartosci['idKategorii'].'_'.$this->_wartosci['akcja'];
		}
		else
		{
			return '';
		}
	}

}

