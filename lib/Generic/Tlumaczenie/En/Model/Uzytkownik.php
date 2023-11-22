<?php
namespace Generic\Tlumaczenie\En\Model;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['id.etykieta']
 * @property string $t['id.opis']
 * @property string $t['idProjektu.etykieta']
 * @property string $t['idProjektu.opis']
 * @property string $t['login.etykieta']
 * @property string $t['login.opis']
 * @property string $t['haslo.etykieta']
 * @property string $t['haslo.opis']
 * @property string $t['email.etykieta']
 * @property string $t['email.opis']
 * @property string $t['dataDodania.etykieta']
 * @property string $t['dataDodania.opis']
 * @property string $t['dataAktywacji.etykieta']
 * @property string $t['dataAktywacji.opis']
 * @property string $t['token.etykieta']
 * @property string $t['token.opis']
 * @property string $t['czyAdmin.etykieta']
 * @property string $t['czyAdmin.opis']
 * @property string $t['status.etykieta']
 * @property string $t['status.opis']
 * @property array $t['status']
 * @property string $t['imie.etykieta']
 * @property string $t['imie.opis']
 * @property string $t['nazwisko.etykieta']
 * @property string $t['nazwisko.opis']
 * @property string $t['dataUrodzenia.etykieta']
 * @property string $t['dataUrodzenia.opis']
 * @property string $t['telKomorkaFirmowa.etykieta']
 * @property string $t['telKomorkaFirmowa.opis']
 * @property string $t['telKomorkaPrywatna.etykieta']
 * @property string $t['telKomorkaPrywatna.opis']
 * @property string $t['telDomowy.etykieta']
 * @property string $t['telDomowy.opis']
 * @property string $t['kontaktAdres.etykieta']
 * @property string $t['kontaktAdres.opis']
 * @property string $t['kontaktKodPocztowy.etykieta']
 * @property string $t['kontaktKodPocztowy.opis']
 * @property string $t['kontaktMiasto.etykieta']
 * @property string $t['kontaktMiasto.opis']
 * @property string $t['jezyk.etykieta']
 * @property string $t['jezyk.opis']
 * @property string $t['krajPochodzenia.etykieta']
 * @property string $t['krajPochodzenia.opis']
 * @property string $t['zdjecie.etykieta']
 * @property string $t['zdjecie.opis']
 * @property string $t['stawkaGodzinowa.etykieta']
 * @property string $t['stawkaGodzinowa.opis']
 * @property string $t['umiejetnosci.etykieta']
 * @property string $t['umiejetnosci.opis']
 */
class Uzytkownik extends Tlumaczenie
{

	protected $tlumaczeniaDomyslne = array(
		'login.etykieta' => 'Login',
		'login.opis' => '',

		'haslo.etykieta' => 'Password',
		'haslo.opis' => '',

		'email.etykieta' => 'Email',
		'email.opis' => '',

		'dataDodania.etykieta' => 'Date of creation',
		'dataDodania.opis' => '',

		'dataAktywacji.etykieta' => 'Date of activation',
		'dataAktywacji.opis' => '',

		'token.etykieta' => 'Token',
		'token.opis' => '',

		'czyAdmin.etykieta' => 'Is admin',
		'czyAdmin.opis' => '',
		
		'praktykant.etykieta' => 'Trainee',
		'praktykant.opis' => '',

		'status.etykieta' => 'Status',
		'status.opis' => '',
		'status.wartosci' => array(
			'nieaktywny' => 'Not active',
			'aktywny' => 'Active',
			'zablokowany' => 'Blocked',
		),

		'imie.etykieta' => 'Name',
		'imie.opis' => '',

		'nazwisko.etykieta' => 'Surname',
		'nazwisko.opis' => '',

		'dataUrodzenia.etykieta' => 'Date of birth',
		'dataUrodzenia.opis' => '',

		'telKomorkaFirmowa.etykieta' => 'Business mobile',
		'telKomorkaFirmowa.opis' => '',

		'telKomorkaPrywatna.etykieta' => 'Private mobile',
		'telKomorkaPrywatna.opis' => '',

		'telDomowy.etykieta' => 'Telephone',
		'telDomowy.opis' => '',

		'kontaktAdres.etykieta' => 'Address',
		'kontaktAdres.opis' => '',

		'kontaktKodPocztowy.etykieta' => 'Postcode',
		'kontaktKodPocztowy.opis' => '',

		'kontaktMiasto.etykieta' => 'City',
		'kontaktMiasto.opis' => '',

		'jezyk.etykieta' => 'Language',
		'jezyk.opis' => '',

		'krajPochodzenia.etykieta' => 'Country of origin',
		'krajPochodzenia.opis' => '',

		'zdjecie.etykieta' => 'Photo',
		'zdjecie.opis' => '',

		'stawkaGodzinowa.etykieta' => 'Wage per hour',
		'stawkaGodzinowa.opis' => '',
		
		'stalaWyplata.etykieta' => 'Salary',
		'stalaWyplata.opis' => '',

		'umiejetnosci.etykieta' => 'Skills',
		'umiejetnosci.opis' => '',

	);
}