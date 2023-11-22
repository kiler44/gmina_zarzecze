<?php
namespace Generic\Model\CennikMiejscowosci;
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
		'kodPocztowy' => self::_STRING,
		'miejscowosc' => self::_STRING,
		'cena' => self::_INTEGER,
	);


	/**
	 * definicja formularza dla tego obiektu
	 * @var array
	 */
	public $formularza = array(
		'kodPocztowy' => array(
			'input' => 'Text',
			'wymagany' => true,
		),
		
		'miejscowosc' => array(
			'input' => 'Text',
			'wymagany' => true,
			'walidatory' => array(),
		),
		
		'cena' => array(
			'input' => 'Text',
         'wymagany' => true,
			'walidatory' => array(),
		),
	);

}
