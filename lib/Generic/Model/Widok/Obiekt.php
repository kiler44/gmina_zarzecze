<?php
namespace Generic\Model\Widok;
use Generic\Biblioteka\ObiektDanych;


/**
 * Klasa odwzorowująca widoki z układem treści.
 * @author Łukasz Wrucha
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $idProjektu
 * @property string $kodJezyka
 * @property string $nazwa
 * @property string $ukladStrony
 * @property string $struktura
 * @property string $jsonUkladu
 * @property string $htmlUkladu
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
		'nazwa',
		'ukladStrony',
		'struktura',
		'jsonUkladu',
		'htmlUkladu',
	);



	function pobierzUkladBlokow()
	{
		$this->_cache['ukladBlokow'] = null;
		$aktywnyRegion = 0;
		$blok = null;
		$ukladBlokow = array();
		if (trim($this->_wartosci['struktura']) != '')
		{
			$lista = explode(',', $this->_wartosci['struktura']);
			while ($element = array_shift($lista)) {
				if (strpos($element, 'blok_') !== false)
				{
					$element = str_replace('blok_', '', $element);
					$ukladBlokow[$aktywnyRegion][] = $element;
				}
				else if (strpos($element, 'kategoria') !== false)
				{
					$ukladBlokow[$aktywnyRegion][] = $element;
				}
				else
				{
					$aktywnyRegion = $element;
				}
			}
			$this->_cache['ukladBlokow'] = $ukladBlokow;
		}
		return $this->_cache['ukladBlokow'];
	}

}
