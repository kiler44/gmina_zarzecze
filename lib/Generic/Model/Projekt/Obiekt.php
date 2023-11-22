<?php
namespace Generic\Model\Projekt;
use Generic\Biblioteka\ObiektDanych;
use Generic\Biblioteka\Cms;


/**
 * Klasa odwzorowująca projekt.
 * @author Krzysztof Lesiczka
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property string $kod
 * @property string $domena
 * @property string $nazwa
 * @property string $opis
 * @property string $szablon
 * @property array $jezyki
 * @property array $jezykiKody
 * @property string $domyslnyJezyk
 * @property string $przypisaneModuly
 * @property string $modulyRss
 * @property string $modulyCron
 *
 * dostepne tylko z poziomu cache
 * @property Array $jezyki
 * @property Array $jezykiKody
 * @property Array $powiazaneModulyHttp
 * @property Array $powiazaneModulyAdmin
 * @property Array $powiazaneModulyRss
 * @property Array $powiazaneModulyCron
 */

class Obiekt extends ObiektDanych
{

	/**
	 * pola obslugiwane przez obiekt
	 * @var array
	 */
	protected $_pola = array(
		'id',
		'kod',
		'domena',
		'nazwa',
		'opis',
		'szablon',
		'domyslnyJezyk',
		'przypisaneModuly',
		'modulyRss',
		'modulyCron',
		'modulyApi',
	);



	public function pobierzJezyki()
	{
		$this->_cache['jezyki'] = array();
		if ( !isset($this->_wartosci['id']) || $this->_wartosci['id'] == '')
		{
			$this->_wartosci['id'] = 1;
		}
		$mapper = Cms::inst()->dane()->JezykProjektu();
		$this->_cache['jezyki'] = $mapper->pobierzDlaProjektu($this->_wartosci['id']);
		return $this->_cache['jezyki'];
	}



	function pobierzJezykiKody()
	{
		$this->_cache['jezykiKody'] = array();
		if (is_array($this->jezyki))
		{
			foreach ($this->jezyki as $jezyk)
			{
				$this->_cache['jezykiKody'][] = $jezyk->kod;
			}
		}
		return $this->_cache['jezykiKody'];
	}



	function pobierzPowiazaneModulyHttp()
	{
		$this->_cache['powiazaneModulyHttp'] = array();
		if (isset($this->_wartosci['przypisaneModuly']) && $this->_wartosci['przypisaneModuly'] != '')
		{
			$this->_cache['powiazaneModulyHttp'] = array_filter(explode(',', $this->_wartosci['przypisaneModuly']));
		}
		return $this->_cache['powiazaneModulyHttp'];
	}



	function pobierzPowiazaneModulyAdmin()
	{
		$this->_cache['powiazaneModulyAdmin'] = array();
		if (isset($this->_wartosci['przypisaneModuly']) && $this->_wartosci['przypisaneModuly'] != '')
		{
			$this->_cache['powiazaneModulyAdmin'] = array_filter(explode(',', $this->_wartosci['przypisaneModuly']));
		}
		return $this->_cache['powiazaneModulyAdmin'];
	}



	function pobierzPowiazaneModulyRss()
	{
		$this->_cache['powiazaneModulyRss'] = array();
		if (isset($this->_wartosci['modulyRss']) && $this->_wartosci['modulyRss'] != '')
		{
			$this->_cache['powiazaneModulyRss'] = array_filter(explode(',', $this->_wartosci['modulyRss']));
		}
		return $this->_cache['powiazaneModulyRss'];
	}
	
	function pobierzPowiazaneModulyApi()
	{
		$this->_cache['powiazaneModulyApi'] = array();
		if (isset($this->_wartosci['modulyApi']) && $this->_wartosci['modulyApi'] != '')
		{
			$this->_cache['powiazaneModulyApi'] = array_filter(explode(',', $this->_wartosci['modulyApi']));
		}
		return $this->_cache['powiazaneModulyApi'];
	}



	function pobierzPowiazaneModulyCron()
	{
		$this->_cache['powiazaneModulyCron'] = array();
		if (isset($this->_wartosci['modulyCron']) && $this->_wartosci['modulyCron'] != '')
		{
			$this->_cache['powiazaneModulyCron'] = array_filter(explode(',', $this->_wartosci['modulyCron']));
		}
		return $this->_cache['powiazaneModulyCron'];
	}

}