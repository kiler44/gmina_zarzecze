<?php
namespace Generic\Model\Rola;
use Generic\Biblioteka\ObiektDanych;
use Generic\Biblioteka\Cms;
use Generic\Model\UzytkownikRola;
use Generic\Model\PlikPrywatny;
use Generic\Model\PlikPrywatnyRolaPowiazanie;

/**
 * Klasa odwzorowująca rolę użytkownika.
 * @author Krzysztof Lesiczka
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $idProjektu
 * @property string $kod
 * @property string $nazwa
 * @property string $opis
 * @property array $modulyDostep
 * @property int $kontekstowa
 * @property int $kontekstObiekt
 * @property int $kontekstPole
 * @property int $kontekstPowiazanie
 * @property int $kontekstPowiazanieKtoreId
 *
 * dostepne tylko z poziomu cache
 * @property array $uzytkownicy
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
		'kod',
		'nazwa',
		'opis',
		'modulyDostep',
		'kontekstowa',
		'kontekstObiekt',
		'kontekstPole',
		'kontekstPowiazanie',
		'kontekstPowiazanieKtoreId',
	);

	
	public function przypiszUprawnieniaDoPliku(PlikPrywatny\Obiekt $plik)
	{
		$PlikiRole = new PlikPrywatnyRolaPowiazanie\Obiekt();
		$PlikiRoleMapper = new PlikPrywatnyRolaPowiazanie\Mapper();
		$PlikiRole->idProjektu = ID_PROJEKTU;
		$PlikiRole->idPliku = $plik->id;
		$PlikiRole->idRoli = $this->id;
		return $PlikiRole->zapisz($PlikiRoleMapper);
	}

	public function pobierzUzytkownicy()
	{
		$mapper = Cms::inst()->dane()->Uzytkownik();
		$this->_cache['uzytkownicy'] = $mapper->pobierzDlaRoli($this->_wartosci['id']);
		return $this->_cache['uzytkownicy'];
	}



	public function usunDlaUzytkownika($idUzytkownika)
	{
		if ($idUzytkownika < 1)
		{
			trigger_error('Nie podano identyfikatora użytkownika');
			return false;
		}
		$mapper = Cms::inst()->dane()->UzytkownikRola();
		$powiazanie = $mapper->pobierzDlaUzytkownikaRoli($idUzytkownika, $this->_wartosci['id']);
		if ($powiazanie instanceof UzytkownikRola\Obiekt)
		{
			return $powiazanie->usun($mapper);
		}
		return true;
	}



	public function przypiszDoUzytkownika($idUzytkownika)
	{
		if ($idUzytkownika < 1)
		{
			trigger_error('Nie podano identyfikatora użytkownika');
			return false;
		}
		$mapper = Cms::inst()->dane()->UzytkownikRola();
		$powiazanie = $mapper->pobierzDlaUzytkownikaRoli($idUzytkownika, $this->_wartosci['id']);
		if ($powiazanie instanceof UzytkownikRola\Obiekt)
		{
			return true;
		}
		else
		{
			$powiazanie = new UzytkownikRola\Obiekt;
			$powiazanie->idProjektu = ID_PROJEKTU;
			$powiazanie->idRoli = $this->_wartosci['id'];
			$powiazanie->idUzytkownika = $idUzytkownika;
			return $powiazanie->zapisz($mapper);
		}
	}
	
	public function pobierzUprawnienia()
	{
		if (isset($this->_cache['uprawnienia']) && !empty($this->_cache['uprawnienia']))
			return $this->_cache['uprawnienia'];
		
		$mapper = $this->dane()->Uprawnienie();
		$dane_baza = $mapper->zwracaTablice()->pobierzDlaRoli($this->_wartosci['id']);
		$uprawnienia_baza = array();
		if (is_array($dane_baza) && count($dane_baza) > 0)
		{
			foreach ($dane_baza as $wiersz)
			{
				$uprawnienia_baza[$wiersz['usluga'].'_'.$wiersz['id_kategorii'].'_'.$wiersz['akcja']] = $wiersz['hash'];
			}
		}
		$this->_cache['uprawnienia'] = $uprawnienia_baza;
		return $this->_cache['uprawnienia'];
	}
	
	
	public function maUprawnieniaDo($kod)
	{
		$uprawnienia = $this->pobierzUprawnienia();
		return array_key_exists($kod, $uprawnienia);
	}

}

