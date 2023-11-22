<?php
namespace Generic\Model\Powiazanie;
use Generic\Biblioteka\ObiektDanych;
use Generic\Model\PowiazanieTyp;


/**
 * show off @property, @property-read, @property-write
 *
 * @property integer $id
 * @property integer $id1
 * @property integer $id2
 * @property integer $typ
 * @property string $dataStart
 * @property string $dataStop
 *
 * @property ObiektDanych $obiekt1
 * @property ObiektDanych $obiekt2
 * @property PowiazanieTyp $obiektTypu
 * @property string $nazwaTypu
 */

class Obiekt extends ObiektDanych
{

	// pola obslugiwane przez obiekt
	protected $_pola = array(
		'id',
		'id1',
		'id2',
		'typ',
		'dataStart',
		'dataStop',
	);

	public function ustawTyp($wartosc)
	{
		if ($this->id > 0 && $wartosc != $this->typ)
		{
			trigger_error('Nie mozna zmienic typu powiązania na istniejacym obiekcie!');
		}
		else
		{
			$this->poleUstawWartosc('typ', intval($wartosc));
			if (isset($this->_cache['obiektTypu']))
			{
				unset($this->_cache['obiektTypu']);
			}
		}
	}

	public function ustawId1($wartosc)
	{
		$this->poleUstawWartosc('id1', intval($wartosc));
		if (isset($this->_cache['obiekt1']))
		{
			unset($this->_cache['obiekt1']);
		}
	}

	public function ustawId2($wartosc)
	{
		$this->poleUstawWartosc('id2', intval($wartosc));
		if (isset($this->_cache['obiekt2']))
		{
			unset($this->_cache['obiekt2']);
		}
	}

	public function pobierzObiektTypu()
	{
		$mapper = $this->dane()->PowiazanieTyp();
		$this->_cache['obiektTypu'] = ($this->typ > 0) ? $mapper->pobierzPoId($this->typ) : null;
		return $this->_cache['obiektTypu'];
	}

	public function pobierzNazwaTypu()
	{
		$mapper = $this->dane()->PowiazanieTyp();
		$this->_cache['kodTypu'] = ($this->typ > 0) ? $mapper->pobierzPoId($this->typ)->nazwa : null;
		return $this->_cache['kodTypu'];
	}

	public function ustawObiektTypu($obiekt)
	{
		if ($obiekt instanceof PowiazanieTyp\Obiekt)
		{
			$this->poleUstawWartosc('typ', $obiekt->id);
			if (isset($this->_cache['obiektTypu']))
			{
				unset($this->_cache['obiektTypu']);
			}
			if (isset($this->_cache['kodTypu']))
			{
				unset($this->_cache['kodTypu']);
			}
		}
		else
		{
			trigger_error('Nieprawidłowy typ obiektu!');
		}
	}

	public function ustawNazwaTypu($nazwa)
	{
		$obiekt = $this->dane()->PowiazanieTyp()->pobierzPoNazwie($nazwa);
		if ($obiekt instanceof PowiazanieTyp\Obiekt)
		{
			$this->poleUstawWartosc('typ', $obiekt->id);
			if (isset($this->_cache['obiektTypu']))
			{
				unset($this->_cache['obiektTypu']);
			}
			if (isset($this->_cache['kodTypu']))
			{
				unset($this->_cache['kodTypu']);
			}
		}
		else
		{
			trigger_error('Nieprawidłowa nazwa typu obiektu!');
		}
	}

	public function pobierzObiekt1()
	{
		$nazwaMappera = $this->obiektTypu->typ1;

		if ($nazwaMappera != '')
		{
			$this->_cache['obiekt1'] = ($this->id1 > 0) ? $this->dane()->$nazwaMappera()->pobierzPoId($this->id1) : null;
			return $this->_cache['obiekt1'];
		}
		else
		{
			trigger_error('Nie ustawiono typu obiektu!');
		}

	}

	public function ustawObiekt1($obiekt)
	{
		$nazwaObiektu = 'Generic\\Model\\' . $this->obiektTypu->typ1 . '\\Obiekt';

		if ($obiekt instanceof $nazwaObiektu)
		{
			$this->poleUstawWartosc('id1', $obiekt->id);
			if (isset($this->_cache['obiekt1']))
			{
				unset($this->_cache['obiekt1']);
			}
		}
		else
		{
			trigger_error('Nieprawidłowy typ obiektu!');
		}
	}

	public function pobierzObiekt2()
	{
		$nazwaMappera = $this->obiektTypu->typ2;

		if ($nazwaMappera != '')
		{
			$this->_cache['obiekt2'] = ($this->id2 > 0) ? $this->dane()->$nazwaMappera()->pobierzPoId($this->id2) : null;
			return $this->_cache['obiekt2'];
		}
		else
		{
			trigger_error('Nie ustawiono typu obiektu!');
		}

	}

	public function ustawObiekt2($obiekt)
	{
		$nazwaObiektu = 'Generic\\Model\\' . $this->obiektTypu->typ2 . '\\Obiekt';

		if ($obiekt instanceof $nazwaObiektu)
		{
			$this->poleUstawWartosc('id2',$obiekt->id);
			if (isset($this->_cache['obiekt2']))
			{
				unset($this->_cache['obiekt2']);
			}
		}
		else
		{
			trigger_error('Nieprawidłowy typ obiektu!');
		}
	}
}
