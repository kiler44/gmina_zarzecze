<?php
namespace Generic\Model\EmailWpisKolejki;
use Generic\Biblioteka;

/**
 * Klasa definiujaca (opisujaca) obiekt
 * @author Łukasz Wrucha
 * @package dane
 */
class Definicja extends Biblioteka\DefinicjaObiektu
{

	/**
	 * typy pol obiektu
	 * @var array
	 */
	public $polaObiektuTypy = array(
		'id' => self::_INTEGER,
		'idProjektu' => self::_INTEGER,
		'kodJezyka' => self::_STRING,
		'dataDodania' => self::_STRING,
		'idFormatki' => self::_INTEGER,
		'typWysylania' => self::_STRING,
		'bledyLicznik' => self::_INTEGER,
		'bledyOpis' => self::_STRING,
		'emailNadawcaEmail' => self::_STRING,
		'emailNadawcaNazwa' => self::_STRING,
		'emailPotwierdzenieEmail' => self::_STRING,
		'emailOdbiorcy' => self::_STRING,
		'emailKopie' => self::_STRING,
		'emailKopieUkryte' => self::_STRING,
		'emailOdpowiedzi' => self::_STRING,
		'emailTytul' => self::_STRING,
		'emailTrescHtml' => self::_STRING,
		'emailTrescTxt' => self::_STRING,
		'emailZalaczniki' => self::_STRING,
		'emailZalacznikiKatalog' => self::_STRING,
		'nieWysylaj' => self::_BOOLEAN,
		'idNadawcy' => self::_INTEGER,
		'idOdbiorcy' => self::_INTEGER,
		'object' => self::_STRING,
		'idObject' => self::_INTEGER,
	);


	/**
	 * definicja formularza dla tego obiektu
	 * @var array
	 */
	public $polaFormularza = array();

}
