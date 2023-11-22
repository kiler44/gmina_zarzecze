<?php
namespace Generic\Model\Uzytkownik;
use Generic\Biblioteka;
use Generic\Biblioteka\Cms;

/**
 * show off @property, @property-read, @property-write
 *
 * @property int $id
 * @property int $id_projektu
 * @property string $login
 * @property string $haslo
 * @property string $email
 * @property string $data_dodania
 * @property string $data_aktywacji
 * @property string $token
 * @property bool $czy_admin
 * @property enum $status
 * @property string $imie
 * @property string $nazwisko
 * @property string $data_urodzenia
 * @property string $tel_komorka_firmowa
 * @property string $tel_komorka_prywatna
 * @property string $tel_domowy
 * @property string $kontakt_adres
 * @property string $kontakt_kod_pocztowy
 * @property string $kontakt_miasto
 * @property string $jezyk
 * @property string $kraj_pochodzenia
 * @property string $zdjecie
 * @property double $stawka_godzinowa
 * @property string $tabelaPodatkowa
 * @property string $umiejetnosci
 * @property array $dane
 * @property string $tidsbankenKod
 * @property integer $tidsbankenNumerPracownika
 * @property string $tidsbankenHaslo
 * @property boolen $tidsbankenLogujPrzezHaslo
 * @property integer $dniWolne
 * @property integer $dzial
 * @property double $etat 
 * @property string $stanowisko
 * @property string $kontoBankowe 
 * @property string $wlascicielKonta
 * @property string $opiekun
 * @property string $emailOpiekun
 * @property string $telefonOpiekun
 * @property boolen $praktykant
 * @property date $praktykantDataDo
 * @property int $dniChorobowe
 * @property double $stala_wyplata
 * @property boolen $wyswietlajWTidsbanken
 * @property string $kodGet
 */
class Definicja extends Biblioteka\DefinicjaObiektu
{
        
	/**
	* Przetrzymuje typy pól w bazie.
	* @var array
	*/
	public $polaObiektuTypy = array(
		'id' => self::_INTEGER,
		'idProjektu' => self::_INTEGER,
		'login' => self::_STRING,
		'haslo' => self::_STRING,
		'email' => self::_STRING,
		'dataDodania' => self::_STRING,
		'dataAktywacji' => self::_STRING,
		'token' => self::_STRING,
		'czyAdmin' => self::_BOOLEAN,
		'status' => self::_ENUM,
		'imie' => self::_STRING,
		'nazwisko' => self::_STRING,
		'dataUrodzenia' => self::_STRING,
		'telKomorkaFirmowa' => self::_STRING,
		'telKomorkaPrywatna' => self::_STRING,
		'telDomowy' => self::_STRING,
		'kontaktAdres' => self::_STRING,
		'kontaktKodPocztowy' => self::_STRING,
		'kontaktMiasto' => self::_STRING,
		'jezyk' => self::_STRING,
		'krajPochodzenia' => self::_STRING,
		'zdjecie' => self::_STRING,
		'stawkaGodzinowa' => self::_DOUBLE,
		'tabelaPodatkowa' => self::_STRING,
		'umiejetnosci' => self::_LIST,
		'dane' => self::_ARRAY,
		'tidsbankenKod' => self::_STRING,
		'tidsbankenNumerPracownika' => self::_INTEGER,
		'tidsbankenHaslo' => self::_STRING,
		'tidsbankenLogujPrzezHaslo' => self::_BOOLEAN,
		'dzial' => self::_STRING,
		'etat' => self::_DOUBLE,
		'stanowisko' => self::_STRING,
		'kontoBankowe' => self::_STRING,
		'wlascicielKonta' => self::_STRING,
		'dniWolne' => self::_INTEGER,
		'opiekun' => self::_STRING,
		'telefonOpiekun' => self::_STRING,
		'emailOpiekun' => self::_STRING,
		'praktykant' => self::_BOOLEAN,
		'praktykantDataDo' => self::_STRING,
		'dniChorobowe' => self::_INTEGER,
		'stalaWyplata' => self::_DOUBLE,
		'wyswietlajWTidsbanken' => self::_BOOLEAN,
		'kodGet' => self::_STRING,
	);

	/**
	 * Czy chronić uprawnieniami Obiekt.
	 * @var bool
	 */
	public $_ochronaUprawnieniami = false;
	
	
	/**
	 * Lista pól których uprawnienia nie będa sprawdzane - żeby było mozliwe zalogowanie i pobranie uprawnień
	 * @var array
	 */
	public $_nieSprawdzajUprawnien = array(
		'id_odczyt',
		'idProjektu_odczyt',
		'login_odczyt',
		'haslo_odczyt',
		'email_odczyt',
		'dataDodania_odczyt',
		'dataAktywacji_odczyt',
		'token_odczyt',
		'czyAdmin_odczyt',
		'status_odczyt',
		'uprawnienia_odczyt',
		'pelnaNazwa_odczyt',
	);


	/**
	* Domyślne wartości dla kolumn, które nie mogą być puste (NOT NULL).
	* @var array
	*/
	public $domyslneWartosci = array(
		'status' => 'nieaktywny',
		'jezyk' => 'pl',
		'krajPochodzenia' => 'no',
		'stawkaGodzinowa' => '0.00',
		'praktykant' => false,
	);



	/**
	* Dopuszczalne wartości dla pól enum.
	* @var array
	*/
	public $dopuszczalneWartosci = array(
		'status' => array(
			'nieaktywny',
			'aktywny',
			'zablokowany',
		),

	);



	/**
	* Definicja pól dla formularza tego obiektu.
	* @var array
	*/
	public $formularz = array(
		'login' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
					'KrotszeOd' => 32,
			),
		),

		'haslo' => array(
			'input' => 'Password',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
					'KrotszeOd' => 32,
			),
		),

		'email' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'wymagane' => true,
			'walidatory' => array(
					'Email',
					'NiePuste',
					'KrotszeOd' => 128,
			),
		),

		'dataDodania' => array(
			'input' => 'Text',
			'filtry' => array(
			),
			'walidatory' => array(
			),
		),

		'dataAktywacji' => array(
			'input' => 'Text',
			'filtry' => array(
			),
			'walidatory' => array(
			),
		),

		'token' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
					'KrotszeOd' => 32,
			),
		),

		'czyAdmin' => array(
			'input' => 'Checkbox',
			'filtry' => array(
				'intval',
				'abs',
			),
			'walidatory' => array(
			),
		),

		'status' => array(
			'input' => 'Select',
			'filtry' => array(
			),
			'wymagane' => true,
			'walidatory' => array(
					'DozwoloneWartosci' => array('nieaktywny','aktywny','zablokowany',),
			),
		),

		'imie' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'wymagane' => true,
			'walidatory' => array(
					'KrotszeOd' => 50,
			),
		),

		'nazwisko' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'wymagane' => true,
			'walidatory' => array(
					'KrotszeOd' => 50,
			),
		),

		'dataUrodzenia' => array(
			'input' => 'Data',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
			),
		),

		'telKomorkaFirmowa' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
					'KrotszeOd' => 15,
			),
		),

		'telKomorkaPrywatna' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
					'KrotszeOd' => 15,
			),
		),

		'telDomowy' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
					'KrotszeOd' => 15,
			),
		),

		'kontaktAdres' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
					'KrotszeOd' => 90,
			),
		),

		'kontaktKodPocztowy' => array(
			'input' => 'KodPocztowy',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
					'KrotszeOd' => 6,
			),
		),

		'kontaktMiasto' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
					'KrotszeOd' => 50,
			),
		),

		'jezyk' => array(
			'input' => 'Select',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
					'KrotszeOd' => 2,
			),
		),

		'krajPochodzenia' => array(
			'input' => 'Text',
			'filtry' => array(
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
					'KrotszeOd' => 2,
			),
		),

		'zdjecie' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
					'KrotszeOd' => 64,
			),
		),

		'stawkaGodzinowa' => array(
			'input' => 'Text',
			'filtry' => array(
			),
			'wymagane' => true,
			'walidatory' => array(
					'NiePuste',
			),
		),

		'umiejetnosci' => array(
			'input' => 'Text',
			'filtry' => array(
				'strval',
				'trim',
				'filtr_xss',
			),
			'walidatory' => array(
					'KrotszeOd' => 64,
			),
		),

	);
}