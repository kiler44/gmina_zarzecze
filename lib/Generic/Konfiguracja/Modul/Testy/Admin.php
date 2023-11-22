<?php
namespace Generic\Konfiguracja\Modul\Testy;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property array $k['emailTestowy.wymagane_pola']
 * @property string $k['logi.domyslny_kierunek']
 * @property int $k['logi.wierszy_na_stronie']
 * @property array $k['porownajKonfiguracje.dozwolone_formaty_plikow']
 * @property int $k['resetujDaneUzytkownikow.id_formatki_email']
 * @property array $k['resetujDaneUzytkownikow.kod_roli_ph']
 * @property array $k['resetujDaneUzytkownikow.konfiguracje_email_odbiorcy']
 * @property bool $k['resetujDaneUzytkownikow.raport_wyslij']
 * @property string $k['resetujDaneUzytkownikow.ustawiany_email']
 * @property string $k['resetujDaneUzytkownikow.ustawiany_email_odbiorcy']
 * @property string $k['resetujDaneUzytkownikow.ustawiany_telefon']
 * @property string $k['szablon.formularz_wyszukiwarka']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'emailTestowy.wymagane_pola' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array(
			'odNazwa',
			'odEmail',
			'doNazwa',
			'doEmail',
			'tytul',
			'tresc',
			),
		),

	'logi.domyslny_kierunek' => array(
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'desc',
		'dozwolone' => array(
			'0' => 'asc',
			1 => 'desc',
			),
		),

	'logi.wierszy_na_stronie' => array(
		'maks' => '100',
		'opis' => 'Ilość wierszy na stronie w liście plików logów',
		'typ' => 'int',
		'wartosc' => 10,
		),

	'porownajKonfiguracje.dozwolone_formaty_plikow' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array(
			'csv',
			),
		),

	'resetujDaneUzytkownikow.id_formatki_email' => array(
		'opis' => '',
		'typ' => 'mail',
		'wartosc' => 36,
		),

	'resetujDaneUzytkownikow.kod_roli_ph' => array(
		'opis' => 'Lista kodów roli dla PH.',
		'typ' => 'list',
		'wartosc' => array(
			'przedstawiciel',
			),
		),

	'resetujDaneUzytkownikow.konfiguracje_email_odbiorcy' => array(
		'opis' => 'Lista pól konfiguracji, w których zostanie wpisany email odbiorcy.',
		'typ' => 'list',
		'wartosc' => array(
			'faktura.email_kopia',
			'faktura.email_dw',
			'crm_email',
			'powiadomienie.email_powiadamiany',
			'powiadomienie.email_powiadamiany_dw',
			'handlowcy.lista_maili_kierownikow',
			'emailKoniecWaznosciPH.lista_maili_kierownikow',
			'emailKoniecWaznosciKierPH.lista_maili_kierownikow',
			'powiadomienieAdministracyjna.odbiorcy',
			'powiadomienieAdministracyjna.odbiorcy_dw',
			'email.email_odbiorcy',
			'email.email_dw',
			'nowaWiadomosc.adres_obserwatora',
			'wyslijDokument.email_kopia',
			),
		),

	'resetujDaneUzytkownikow.raport_wyslij' => array(
		'opis' => 'Czy wysyłać raport po Zresetowaniu danych?',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	'resetujDaneUzytkownikow.ustawiany_email' => array(
		'opis' => 'Adres email ustawiany dla wsyzstkich użytkowników',
		'typ' => 'varchar',
		'wartosc' => 'test@sttest.pl',
		),

	'resetujDaneUzytkownikow.ustawiany_email_odbiorcy' => array(
		'opis' => 'Adres email ustawiany dla odbiorców emaili wychodzących z seriwsu.',
		'typ' => 'varchar',
		'wartosc' => 'test@sttest.pl',
		),

	'resetujDaneUzytkownikow.ustawiany_telefon' => array(
		'opis' => 'Telefon ustawiany dla wszystkich użytkowników',
		'typ' => 'varchar',
		'wartosc' => '000 000 000',
		),

	'szablon.formularz_wyszukiwarka' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'formularz_grid.tpl',
		),

	);
}
