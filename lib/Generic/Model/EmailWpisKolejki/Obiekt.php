<?php
namespace Generic\Model\EmailWpisKolejki;
use Generic\Biblioteka\ObiektDanych;


/**
 * show off @property, @property-read, @property-write
 *
 * @property integer $id
 * @property integer $idProjektu
 * @property string $kodJezyka
 * @property string $dataDodania
 * @property integer $idFormatki
 * @property string $typWysylania
 * @property integer $bledyLicznik
 * @property string $bledyOpis
 * @property string $emailNadawcaEmail
 * @property string $emailNadawcaNazwa
 * @property string $emailPotwierdzenieEmail
 * @property string $emailOdbiorcy
 * @property string $emailKopie
 * @property string $emailKopieUkryte
 * @property string $emailOdpowiedzi
 * @property string $emailTytul
 * @property string $emailTrescHtml
 * @property string $emailTrescTxt
 * @property string $emailZalaczniki
 * @property string $emailZalacznikiKatalog
 * @property boolean $nieWysylaj
 * @property integer $idNadawcy
 * @property integer $idOdbiorcy
 * @property string $object
 * @property integer $idObject
 *
 * dostepne tylko z poziomu cache
 * @property EmailFormatka $formatka
 */

class Obiekt extends ObiektDanych
{

	// pola obslugiwane przez obiekt
	protected $_pola = array(
		'id',
		'idProjektu',
		'kodJezyka',
		'dataDodania',
		'idFormatki',
		'typWysylania',
		'bledyLicznik',
		'bledyOpis',
		'emailNadawcaEmail',
		'emailNadawcaNazwa',
		'emailPotwierdzenieEmail',
		'emailOdbiorcy',
		'emailKopie',
		'emailKopieUkryte',
		'emailOdpowiedzi',
		'emailTytul',
		'emailTrescHtml',
		'emailTrescTxt',
		'emailZalaczniki',
		'emailZalacznikiKatalog',
		'nieWysylaj',
		'idNadawcy',
		'idOdbiorcy',
		'object',
		'idObject',
	);



	public function ustawEmailZalaczniki(Array $wartosc)
	{
		$this->listaUstawWartosc('emailZalaczniki', $wartosc, ',');
	}



	public function pobierzEmailZalaczniki()
	{
		return $this->listaPobierzWartosc('emailZalaczniki', ',');
	}



	public function ustawEmailOdbiorcy(Array $wartosc)
	{
		$this->tablicaUstawWartosc('emailOdbiorcy', $wartosc);
	}



	public function pobierzEmailOdbiorcy()
	{
		return $this->tablicaPobierzWartosc('emailOdbiorcy');
	}



	public function ustawEmailKopie(Array $wartosc)
	{
		$this->tablicaUstawWartosc('emailKopie', $wartosc);
	}



	public function pobierzEmailKopie()
	{
		return $this->tablicaPobierzWartosc('emailKopie');
	}



	public function ustawEmailKopieUkryte(Array $wartosc)
	{
		$this->tablicaUstawWartosc('emailKopieUkryte', $wartosc);
	}



	public function pobierzEmailKopieUkryte()
	{
		return $this->tablicaPobierzWartosc('emailKopieUkryte');
	}



	public function ustawEmailOdpowiedzi(Array $wartosc)
	{
		$this->tablicaUstawWartosc('emailOdpowiedzi', $wartosc);
	}



	public function pobierzEmailOdpowiedzi()
	{
		return $this->tablicaPobierzWartosc('emailOdpowiedzi');
	}



	public function pobierzFormatka()
	{
		if ( ! isset($this->_cache['formatka']))
		{
			$mapper = $this->dane()->EmailFormatka();
			$this->_cache['formatka'] = ($this->idFormatki > 0) ? $mapper->pobierzPoId($this->idFormatki) : null;
		}
		return $this->_cache['formatka'];
	}

}
