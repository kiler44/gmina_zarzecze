<?php
namespace Generic\Model\RegulaRoutingu;
use Generic\Biblioteka\ObiektDanych;


/**
 * Klasa odwzorowująca regułę routingu
 * @author Konrad Rudowski
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property string $nazwa
 * @property int $idKategorii
 * @property string $kodModulu
 * @property string $nazwaAkcji
 * @property string $typReguly
 * @property string $wartosc
 * @property string $szablonUrl
 */

class Obiekt extends ObiektDanych
{

	/**
	 * pola obslugiwane przez obiekt
	 * @var array
	 */
	protected $_pola = array(
		'id',
		'nazwa',
		'idKategorii',
		'kodModulu',
		'nazwaAkcji',
		'typReguly',
		'wartosc',
		'szablonUrl',
	);


	protected $_typyRegul = array(
		'porownanie',
		'wyrazenie',
		'kategoria',
		'branza',
		'lista',
		'oferta',
		'strona',
		'wizytowka_porownanie',
		'wizytowka_wyrazenie',
		'wizytowka_kategoria',
		'wizytowka_lista',
		'wizytowka_oferta',
		'wizytowka_strona',
	);



	function pobierzDostepneTypyRegul()
	{
		return $this->_typyRegul;
	}



	function ustawTypReguly($wartosc)
	{
		$wartosc = strtolower($wartosc);
		if (in_array($wartosc, $this->_typyRegul))
		{
			$this->_wartosci['typReguly'] = $wartosc;
			$this->_zmodyfikowane[] = 'typReguly';
		}
		else
		{
			trigger_error('Niedozwolony typ reguly '.$wartosc, E_USER_WARNING);
		}
	}

}
