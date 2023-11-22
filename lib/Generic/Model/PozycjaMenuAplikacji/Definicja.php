<?php
namespace Generic\Model\PozycjaMenuAplikacji;
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
		'idRodzica' => self::_INTEGER,
		'idUzytkownika' => self::_INTEGER,
		'czyModulAdministracyjny' => self::_BOOLEAN,
		'idKategorii' => self::_INTEGER,
		'akcja' => self::_STRING,
		'anchor' => self::_STRING,
		'ikona' => self::_STRING,
		'zawszeWidoczna' => self::_BOOLEAN,
		'kolejnosc' => self::_INTEGER,
		'klikniecia' => self::_INTEGER,
		'parametry' => self::_ARRAY,
		'etykieta' => self::_ARRAY,
	);


	/**
	 * definicja formularza dla tego obiektu
	 * @var array
	 */
	public $formularza = array(
		
		'idRodzica' => array(
			'input' => 'Select',
			'wymagany' => false,
			'walidatory' => array('LiczbaCalkowita'),
		),
		
		'anchor' => array(
			'input' => 'Text',
			'wymagany' => false,
		),
		
		'kolejnosc' => array(
			'input' => 'Text',
			'wymagany' => false,
			'walidatory' => array(),
			'parametry' => array(
				'atrybuty' => array('class' => 'spinner'),
			),
		),
		
		'parametry' => array(
			'input' => 'Tablica',
         'parametry' => array(
            'dodawanie_wierszy' => true,
         ),
		),
	);

}
