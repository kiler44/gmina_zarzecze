<?php
namespace Generic\Model\UprawnienieAdministracyjne;
use Generic\Biblioteka\ObiektDanych;
use Generic\Biblioteka\Cms;
use Generic\Model\RolaUprawnienieAdministracyjne;


/**
 * Klasa odwzorowująca uprawnienie do modułu administracyjnego.
 * @author Krzysztof Lesiczka
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $idProjektu
 * @property string $kodModulu
 * @property string $akcja
 * @property string $hash
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
		'kodModulu',
		'akcja',
		'hash',
	);



	public function usunDlaRoli($idRoli)
	{
		if ($idRoli < 1)
		{
			trigger_error('Nie podano identyfikatora roli');
			return false;
		}
		$mapper = Cms::inst()->dane()->RolaUprawnienieAdministracyjne();
		$powiazanie = $mapper->pobierzDlaRoliUprawnienia($idRoli, $this->_wartosci['id']);
		if ($powiazanie instanceof RolaUprawnienieAdministracyjne\Obiekt)
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
		$mapper = Cms::inst()->dane()->RolaUprawnienieAdministracyjne();
		$powiazanie = $mapper->pobierzDlaRoliUprawnienia($idRoli, $this->_wartosci['id']);
		if ($powiazanie instanceof RolaUprawnienieAdministracyjne\Obiekt)
		{
			return true;
		}
		else
		{
			$powiazanie = new RolaUprawnienieAdministracyjne\Obiekt;
			$powiazanie->idProjektu = ID_PROJEKTU;
			$powiazanie->idRoli = $idRoli;
			$powiazanie->idUprawnieniaAdministracyjnego = $this->_wartosci['id'];
			return $powiazanie->zapisz($mapper);
		}
	}

}

