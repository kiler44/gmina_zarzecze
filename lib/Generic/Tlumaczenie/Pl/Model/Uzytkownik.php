<?php
namespace Generic\Tlumaczenie\Pl\Model;

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
class CmsUzytkownicy extends Tlumaczenie
{

	protected $tlumaczeniaDomyslne = array(
		'login.etykieta' => 'Login',
		'login.opis' => '',

		'haslo.etykieta' => 'Hasło',
		'haslo.opis' => '',

		'email.etykieta' => 'Email',
		'email.opis' => '',

		'dataDodania.etykieta' => 'Data dodania',
		'dataDodania.opis' => '',

		'dataAktywacji.etykieta' => 'Data aktywacji',
		'dataAktywacji.opis' => '',

		'token.etykieta' => 'Token',
		'token.opis' => '',

		'czyAdmin.etykieta' => 'Czy admin',
		'czyAdmin.opis' => 'jesli zaznaczone użytkownik może logowac się do panelu',
		
		'praktykant.etykieta' => 'Praktykant',
		'praktykant.opis' => '',
		
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

		'telKomorkaFirmowa.etykieta' => 'Komórka służbowa',
		'telKomorkaFirmowa.opis' => '',

		'telKomorkaPrywatna.etykieta' => 'Komórka prywatna',
		'telKomorkaPrywatna.opis' => '',

		'telDomowy.etykieta' => 'Telefon domowy',
		'telDomowy.opis' => '',

		'kontaktAdres.etykieta' => 'Adres',
		'kontaktAdres.opis' => '',

		'kontaktKodPocztowy.etykieta' => 'Kod pocztowy',
		'kontaktKodPocztowy.opis' => '',

		'kontaktMiasto.etykieta' => 'Miasto',
		'kontaktMiasto.opis' => '',

		'jezyk.etykieta' => 'Język',
		'jezyk.opis' => '',

		'krajPochodzenia.etykieta' => 'Kraj pochodzenia',
		'krajPochodzenia.opis' => '',

		'zdjecie.etykieta' => 'Zdjęcie',
		'zdjecie.opis' => '',

		'stawkaGodzinowa.etykieta' => 'Stawka godzinowa',
		'stawkaGodzinowa.opis' => '',

		'umiejetnosci.etykieta' => 'Umiejętnosci',
		'umiejetnosci.opis' => '',

	);
}