<?php
namespace Generic\Model\Rola;
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
		'kod' => self::_STRING,
		'nazwa' => self::_STRING,
		'opis' => self::_STRING,
		'modulyDostep' => self::_STRING,
		'kontekstowa' => self::_INTEGER,
		'kontekstObiekt' => self::_STRING,
		'kontekstPole' => self::_STRING,
		'kontekstPowiazanie' => self::_STRING,
		'kontekstPowiazanieKtoreId' => self::_INTEGER,
	);


	/**
	 * definicja formularza dla tego obiektu
	 * @var array
	 */
	public $formularz = array(
		'nazwa' => array(
			'input' => 'Text',
			'filtry' => array('strval', 'trim', 'filtr_xss'),
			'wymagany' => true,
			'walidatory' => array('KrotszeOd' => 32),
		),
		'opis' => array(
			'input' => 'TextArea',
			'filtry' => array('strval', 'trim', 'filtr_xss'),
			'walidatory' => array('KrotszeOd' => 500),
		),
	);

}
