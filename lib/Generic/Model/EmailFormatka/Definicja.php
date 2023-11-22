<?php
namespace Generic\Model\EmailFormatka;
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
		'dataDodania' => self::_STRING,
		'typWysylania' => self::_STRING,
		'kategoria' => self::_STRING,
		'tytul' => self::_STRING,
		'opis' => self::_STRING,
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
		'emailSzablon' => self::_INTEGER,
	);


	/**
	 * definicja formularza dla tego obiektu
	 * @var array
	 */
	public $polaFormularza = array();

}
