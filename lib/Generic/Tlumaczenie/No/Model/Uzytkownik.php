<?php
namespace Generic\Tlumaczenie\No\Model;

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
		'login.etykieta' => 'Brukernavn',
		'login.opis' => '',

		'haslo.etykieta' => 'Passord',
		'haslo.opis' => '',

		'email.etykieta' => 'E-post',
		'email.opis' => '',

		'dataDodania.etykieta' => 'Dato lagt',
		'dataDodania.opis' => '',

		'dataAktywacji.etykieta' => 'Dato for aktivering',
		'dataAktywacji.opis' => '',

		'token.etykieta' => 'Pollett',
		'token.opis' => '',

		'czyAdmin.etykieta' => 'Gjør admin',
		'czyAdmin.opis' => '',
		
		'praktykant.etykieta' => 'Trainee',
		'praktykant.opis' => '',
		
		'status.etykieta' => 'Status',
		'status.opis' => '',
		'status.wartosci' => array(
			'nieaktywny' => 'Inaktiv',
			'aktywny' => 'Aktiv',
			'zablokowany' => 'Blokkert',
		),

		'imie.etykieta' => 'Navn',
		'imie.opis' => '',

		'nazwisko.etykieta' => 'Familienavn',
		'nazwisko.opis' => '',

		'dataUrodzenia.etykieta' => 'Fødselsdato',
		'dataUrodzenia.opis' => '',

		'telKomorkaFirmowa.etykieta' => 'Mobil Uniformer',
		'telKomorkaFirmowa.opis' => '',

		'telKomorkaPrywatna.etykieta' => 'Mobil Privat',
		'telKomorkaPrywatna.opis' => '',

		'telDomowy.etykieta' => 'Hjem Phone',
		'telDomowy.opis' => '',

		'kontaktAdres.etykieta' => 'Adresse',
		'kontaktAdres.opis' => '',

		'kontaktKodPocztowy.etykieta' => 'Postnummer',
		'kontaktKodPocztowy.opis' => '',

		'kontaktMiasto.etykieta' => 'Sted',
		'kontaktMiasto.opis' => '',

		'jezyk.etykieta' => 'Språk',
		'jezyk.opis' => '',

		'krajPochodzenia.etykieta' => 'Opprinnelsesland',
		'krajPochodzenia.opis' => '',

		'zdjecie.etykieta' => 'Fotografi',
		'zdjecie.opis' => '',

		'stawkaGodzinowa.etykieta' => 'Timeprisen',
		'stawkaGodzinowa.opis' => '',

		'umiejetnosci.etykieta' => 'Kunnskap',
		'umiejetnosci.opis' => '',

	);
}