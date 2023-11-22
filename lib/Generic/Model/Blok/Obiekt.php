<?php
namespace Generic\Model\Blok;
use Generic\Biblioteka\ObiektDanych;
use Generic\Model\DostepnyModul;


/**
 * Klasa odwzorowująca blok towarzyszący.
 * @author Krzysztof Lesiczka
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $idProjektu
 * @property string $kodJezyka
 * @property string $kodModulu
 * @property string $kontener
 * @property string $klasa
 * @property string $nazwa
 * @property bool $cache
 * @property int $cacheCzas
 *
 * dostepne tylko z poziomu cache
 * @property DostepnyModul $modul
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
		'kontener',
		'klasa',
		'nazwa',
		'szablon',
		'cache',
		'cacheCzas',
		'szablonKatalog'
	);



	function pobierzModul()
	{
		$this->_cache['modul'] = null;
		if (isset($this->_wartosci['kodModulu']) && $this->_wartosci['kodModulu'] != '')
		{
			$mapper = DostepnyModul\Mapper::wywolaj();
			$this->_cache['modul'] = $mapper->pobierzPoKodzie($this->_wartosci['kodModulu']);
		}
		return $this->_cache['modul'];
	}
}
