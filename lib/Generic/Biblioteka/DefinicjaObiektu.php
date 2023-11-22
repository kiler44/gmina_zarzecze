<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka;

/**
 * Klasa bazowa dla wszystkich definicji obiektów
 *
 * @author Łukasz Wrucha
 * @package biblioteki
 */

class DefinicjaObiektu
{
	/**
	 * Ciąg znaków
	 * @const _STRING
	 */
	const _STRING = 'string';
	/**
	 * Wartość logiczna <b>true</b> | <b>false</b>
	 * @const _BOOLEAN
	 */
	const _BOOLEAN = 'boolean';
	/**
	 * Liczba całkowita
	 * @const _INTEGER
	 */
	const _INTEGER = 'integer';
	/**
	 * Liczba zmiennoprzecinkowa
	 * @const _FLOAT
	 */
	const _FLOAT = 'float';
	/**
	 * Liczba zmiennoprzecinkowa podwójnej precyzji
	 * @const _DOUBLE
	 */
	const _DOUBLE = 'double';
	/**
	 * <b>Lista</b> - w bazie reprezentowana jest jako ciąg rozdzielony znakiem <b>|</b>
	 * @const _LIST
	 */
	const _LIST = 'list';
	/**
	 * <b>Tablica</b> - w bazie reprezentowana jako zserializowany ciąg znaków
	 * @const _ARRAY
	 */
	const _ARRAY = 'array';
	/**
	 * Wartość wystepująca na liście wartości dozwolonych (definiujesz w tablicy poleDozwoloneWartosci)
	 * @const _ENUM
	 */
	const _ENUM = 'enum';
	/**
	 * Obiekt <b>DateTime</b> reprezentowany w bazie jako <b>timestamp</b> bez strefy czasowej
	 * @const _DATETIME
	 */
	const _DATETIME = 'datetime';
	/**
	 * Wartość przepuszczana bez zmian - ma zastosowanie dla mapperów plikowych gdzie odczytujemy kod PHP
	 * @const _MIXED
	 */
	const _MIXED = 'mixed';
	/**
	 * <b>json</b> - w bazie reprezentowana jako dane w formacie json
	 * @const _ARRAY
	 */
	const _JSON = 'json';
	

	/**
	 * typy pol obiektu
	 * @var array
	 */
	public $polaObiektuTypy = array();


	/**
	 * domyślne wartości dla poszczególnych pól
	 * @var array
	 */
	public $domyslneWartosci = array();


	/**
	 * dopuszczalne wartości dla poszczególnych pól typu enum
	 * @var array
	 */
	public $dopuszczalneWartosci = array();


	/**
	 * definicja formularza dla tego obiektu
	 * @var array
	 */
	public $formularz = array();


	/**
	 * Zmienna przetrzymująca listę pól, których uprawnienien nie sprawdzamy
	 *
	 * @var array
	 */
	public $_nieSprawdzajUprawnien = array();


	/**
	 * Zmienna przetrzymująca listę pól, których uprawnienien nie sprawdzamy
	 *
	 * @var boolean
	 */
	public $_ochronaUprawnieniami = false;





	/**
	 * Zwraca tablice z obsługiwanymi polami
	 *
	 * @return array
	 */
	public function obslugiwanePola()
	{
		return array_merge(array_keys($this->polaObiektuTypy));
	}


	public function saUprawnieniaDo($nazwaPola, ObiektDanych $obiekt)
	{
		if (in_array($nazwaPola, $this->_nieSprawdzajUprawnien))
		{
			return true;
		}

		$nazwaObiektu = explode('\\', get_class($this));

		$kod = $nazwaObiektu[count($nazwaObiektu) - 2] . '_' .$nazwaPola;

		return (Cms::inst()->profil() instanceof \Generic\Model\Uzytkownik\Obiekt) ? Cms::inst()->profil()->maUprawnieniaDo((string)$kod, $obiekt) : false;
	}


	/**
	 * @return boolean
	 */
	public function czyOchronaUprawnieniami()
	{
		return $this->_ochronaUprawnieniami;
	}

}