<?php
namespace Generic\Model\UprawnienieObiektu;
use Generic\Biblioteka\ObiektDanych;
use Generic\Biblioteka\Cms;
use Generic\Model\RolaUprawnienieObiektu;

/**
 * show off @property, @property-read, @property-write
 *
* @property int $id
* @property int $id_projektu
* @property string $kod_jezyka
* @property string $kod_obiektu
* @property string $pole
* @property mixed $hash
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
		'kodObiektu',
		'pole',
		'hash',
	);



	public function usunDlaRoli($idRoli)
	{
		if ($idRoli < 1)
		{
			trigger_error('Nie podano identyfikatora roli');
			return false;
		}
		$mapper = Cms::inst()->dane()->RolaUprawnienieObiektu();
		$powiazanie = $mapper->pobierzDlaRoliUprawnienia($idRoli, $this->_wartosci['id']);
		if ($powiazanie instanceof RolaUprawnienieObiektu\Obiekt)
		{
			return $powiazanie->usun($mapper);
		}
		else
		{
			trigger_error('Nie znaleziono powiazania', E_USER_NOTICE);
		}
		return true;
	}



	public function przypiszDoRoli($idRoli)
	{
		if ($idRoli < 1)
		{
			trigger_error('Nie podano identyfikatora roli');
			return false;
		}
		$mapper = Cms::inst()->dane()->RolaUprawnienieObiektu();
		$powiazanie = $mapper->pobierzDlaRoliUprawnienia($idRoli, $this->_wartosci['id']);
		if ($powiazanie instanceof RolaUprawnienieObiektu\Obiekt)
		{
			return true;
		}
		else
		{
			$powiazanie = new RolaUprawnienieObiektu\Obiekt;
			$powiazanie->idProjektu = ID_PROJEKTU;
			$powiazanie->kodJezyka = KOD_JEZYKA;
			$powiazanie->idRoli = $idRoli;
			$powiazanie->idUprawnieniaObiektu = $this->_wartosci['id'];
			return $powiazanie->zapisz($mapper);
		}
	}
}