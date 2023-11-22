<?php
namespace Generic\Model\Uprawnienie;
use Generic\Biblioteka\ObiektDanych;
use Generic\Biblioteka\Cms;
use Generic\Model\RolaUprawnienie;


/**
 * Klasa odwzorowująca uprawnienie do podstrony.
 * @author Krzysztof Lesiczka
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $idProjektu
 * @property string $kodJezyka
 * @property string $usluga
 * @property int $idKategorii
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
		'kodJezyka',
		'usluga',
		'idKategorii',
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
		$mapper = Cms::inst()->dane()->RolaUprawnienie();
		$powiazanie = $mapper->pobierzDlaRoliUprawnienia($idRoli, $this->_wartosci['id']);
		if ($powiazanie instanceof RolaUprawnienie\Obiekt)
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
		$mapper = Cms::inst()->dane()->RolaUprawnienie();
		$powiazanie = $mapper->pobierzDlaRoliUprawnienia($idRoli, $this->_wartosci['id']);
		if ($powiazanie instanceof RolaUprawnienie\Obiekt)
		{
			return true;
		}
		else
		{
			$powiazanie = new RolaUprawnienie\Obiekt;
			$powiazanie->idProjektu = ID_PROJEKTU;
			$powiazanie->kodJezyka = KOD_JEZYKA;
			$powiazanie->idRoli = $idRoli;
			$powiazanie->idUprawnienia = $this->_wartosci['id'];
			return $powiazanie->zapisz($mapper);
		}
	}

}

