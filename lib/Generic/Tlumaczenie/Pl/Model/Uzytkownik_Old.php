<?php
namespace Generic\Tlumaczenie\Pl\Model;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['autor.etykieta']
 * @property string $t['autor.opis']
 * @property string $t['haslo.etykieta']
 * @property string $t['haslo.opis']
 * @property string $t['email.etykieta']
 * @property string $t['email.opis']
 * @property string $t['czyAdmin.etykieta']
 * @property string $t['czyAdmin.opis']
 * @property string $t['status.etykieta']
 * @property string $t['status.opis']
 * @property array $t['status.wartosci']
 * @property string $t['imie.etykieta']
 * @property string $t['imie.opis']
 * @property string $t['nazwisko.etykieta']
 * @property string $t['nazwisko.opis']
 * @property string $t['dataUrodzenia.etykieta']
 * @property string $t['dataUrodzenia.opis']
 * @property string $t['plec.etykieta']
 * @property string $t['plec.opis']
 * @property array $t['plec.wartosci']
 * @property string $t['kontaktTelefon.etykieta']
 * @property string $t['kontaktTelefon.opis']
 * @property string $t['kontaktKomorka.etykieta']
 * @property string $t['kontaktKomorka.opis']
 * @property string $t['kontaktFax.etykieta']
 * @property string $t['kontaktFax.opis']
 * @property string $t['kontaktWWW.etykieta']
 * @property string $t['kontaktWWW.opis']
 * @property string $t['kontaktNazwa.etykieta']
 * @property string $t['kontaktNazwa.opis']
 * @property string $t['kontaktAdres.etykieta']
 * @property string $t['kontaktAdres.opis']
 * @property string $t['kontaktKodPocztowy.etykieta']
 * @property string $t['kontaktKodPocztowy.opis']
 * @property string $t['kontaktMiasto.etykieta']
 * @property string $t['kontaktMiasto.opis']
 * @property string $t['jezyk.etykieta']
 * @property string $t['jezyk.opis']
 * @property string $t['zgodaMailing.etykieta']
 * @property string $t['zgodaMailing.opis']
 * @property string $t['zgodaMarketing.etykieta']
 * @property string $t['zgodaMarketing.opis']
*/

class Uzytkownik extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
		'login.etykieta' => 'Login',
		'login.opis' => '',
		'haslo.etykieta' => 'Hasło',
		'haslo.opis' => 'Hasło ma tam jakieś swoje zasady, że ileś znaków etc.',
		'email.etykieta' => 'E-mail',
		'email.opis' => '',
		'czyAdmin.etykieta' => 'Czy administrator',
		'czyAdmin.opis' => '',
		'status.etykieta' => 'Status',
		'status.opis' => '',
		'status.wartosci' => array(
			'nieaktywny' => 'Nieaktywny',
			'aktywny' => 'Aktywny',
			'zablokowany' => 'Zablokowany',
		),
		'imie.etykieta' => 'Imię',
		'imie.opis' => '',
		'nazwisko.etykieta' => 'Nazwisko',
		'nazwisko.opis' => '',
		'dataUrodzenia.etykieta' => 'Data urodzenia',
		'dataUrodzenia.opis' => '',
		'plec.etykieta' => 'Płeć',
		'plec.opis' => '',
		'plec.wartosci' => array(
			'K' => 'Kobieta',
			'M' => 'Mężczyzna',
		),
		'kontaktTelefon.etykieta' => 'Telefon',
		'kontaktTelefon.opis' => '',
		'kontaktKomorka.etykieta' => 'Telefon komórkowy',
		'kontaktKomorka.opis' => '',
		'kontaktFax.etykieta' => 'Fax',
		'kontaktFax.opis' => '',
		'kontaktWWW.etykieta' => 'Strona WWW',
		'kontaktWWW.opis' => '',
		'kontaktNazwa.etykieta' => 'Adresat',
		'kontaktNazwa.opis' => '',
		'kontaktAdres.etykieta' => 'Ulica',
		'kontaktAdres.opis' => '',
		'kontaktKodPocztowy.etykieta' => 'Kod pocztowy',
		'kontaktKodPocztowy.opis' => '',
		'kontaktMiasto.etykieta' => 'Miasto',
		'kontaktMiasto.opis' => '',
		'jezyk.etykieta' => 'Język użytkownika',
		'jezyk.opis' => '',
		'zgodaMailing.etykieta' => 'Zgoda na mailing',
		'zgodaMailing.opis' => '',
		'zgodaMarketing.etykieta' => 'Zgoda na treści marketingowe',
		'zgodaMarketing.opis' => '',
		'danePodstawowe.region' => 'Dane podstawowe',
		'ustawienia.region' => 'Ustawienia',
		'daneKontaktowe.region' => 'Dane kontaktowe',
		'daneDodatkowe.region' => 'Dane dodatkowe',
	);
}