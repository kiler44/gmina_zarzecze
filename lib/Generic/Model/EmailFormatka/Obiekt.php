<?php
namespace Generic\Model\EmailFormatka;
use Generic\Biblioteka\ObiektDanych;


/**
 * Klasa odwzorowująca formatke emaila.
 * @author Krzysztof Lesiczka
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property integer $id
 * @property integer $idProjektu
 * @property string $kodJezyka
 * @property string $dataDodania
 * @property string $typWysylania
 * @property string $kategoria
 * @property string $tytul
 * @property string $opis
 * @property string $emailNadawcaEmail
 * @property string $emailNadawcaNazwa
 * @property string $emailPotwierdzenieEmail
 * @property array $emailOdbiorcy
 * @property array $emailKopie
 * @property array $emailKopieUkryte
 * @property array $emailOdpowiedzi
 * @property string $emailTytul
 * @property string $emailTrescHtml
 * @property string $emailTrescTxt
 * @property array $emailZalaczniki
 * @property integer $emailSzablon
 */

class Obiekt extends ObiektDanych
{

	// pola obslugiwane przez obiekt
	protected $_pola = array(
		'id',
		'idProjektu',
		'kodJezyka',
		'dataDodania',
		'typWysylania',
		'kategoria',
		'tytul',
		'opis',
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
		'emailSzablon',
	);


	// dozwolone typy wysylania
	protected $_typyWysylania = array(
		'natychmiast',
		'cron',
		//'kolejka',
	);



	public function pobierzDostepneTypyWysylania()
	{
		return $this->_typy;
	}



	public function ustawTypWysylania($wartosc)
	{
		$this->poleSprawdzUstawWartosc('typWysylania', strtolower($wartosc), $this->_typyWysylania);
	}



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

}
