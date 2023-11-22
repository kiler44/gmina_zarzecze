<?php
namespace Generic\Model\WierszTlumaczen;
use Generic\Biblioteka\ObiektDanych;


/**
 * Klasa odwzorowująca wiersz tłumaczeń.
 * @author Krzysztof Lesiczka, Łukasz Wrucha
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $idProjektu
 * @property string $kodJezyka
 * @property string $kodModulu
 * @property int $idKategorii
 * @property int $idBloku
 * @property string $nazwa
 * @property string $typ
 * @property string $wartosc
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
		'kodModulu',
		'idKategorii',
		'idBloku',
		'nazwa',
		'typ',
		'wartosc',
	);


	// dozwolone typy kategorii
	protected $_typy = array(
		'boolean',
		'integer',
		'float',
		'string',
		'array',
		'object',
	);



	function pobierzDostepneTypy()
	{
		return $this->_typy;
	}



	function ustawTyp($wartosc)
	{
		$wartosc = strtolower($wartosc);
		if (in_array($wartosc, $this->_typy))
		{
			$this->_wartosci['typ'] = $wartosc;
			$this->_zmodyfikowane[] = 'typ';
		}
		else
		{
			trigger_error('Niedozwolony typ wiersza tlumaczen '.$wartosc, E_USER_WARNING);
		}
	}

}
