<?php
namespace Generic\Tlumaczenie\Pl\Modul\Klienci;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie 
 * @property string $t['addCustomer.klienci_etykieta_dodaj']
 * @property string $t['dodaj.blad_nie_mozna_pobrac_rodzica']
 * @property string $t['dodaj.blad_nie_mozna_zapisac_klienta']
 * @property string $t['dodaj.info_klient_edycja_zapisany']
 * @property string $t['dodaj.info_klient_zapisany']
 * @property string $t['dodaj.tytul_modulu']
 * @property string $t['dodaj.tytul_strony']
 * @property string $t['dodaj.tytul_strony_kategoria_dodaj']
 * @property string $t['editCustomer.klienci_etykieta_edytuj']
 * @property string $t['edytuj.blad_nie_mozna_pobrac_klienta']
 * @property string $t['edytuj.tytul_strony']
 * @property string $t['etykieta_select_wybierz']
 * @property string $t['formularz.address.etykieta']
 * @property string $t['formularz.address.opis']
 * @property string $t['formularz.apartament.etykieta']
 * @property string $t['formularz.apartament.opis']
 * @property string $t['formularz.city.etykieta']
 * @property string $t['formularz.city.opis']
 * @property string $t['formularz.companyName.etykieta']
 * @property string $t['formularz.companyName.opis']
 * @property string $t['formularz.dane_podstawowe.region']
 * @property string $t['formularz.edycja_admin_blad_walidacji']
 * @property string $t['formularz.edycja_klienta_zablokowana']
 * @property string $t['formularz.email.etykieta']
 * @property string $t['formularz.email.opis']
 * @property string $t['formularz.etykieta_pelny_form']
 * @property string $t['formularz.etykieta_prosty_form']
 * @property string $t['formularz.etykieta_tytul']
 * @property string $t['formularz.fax.etykieta']
 * @property string $t['formularz.fax.opis']
 * @property string $t['formularz.idCustomer.etykieta']
 * @property string $t['formularz.idCustomer.opis']
 * @property string $t['formularz.idParent.etykieta']
 * @property string $t['formularz.idParent.opis']
 * @property string $t['formularz.korespondencja.region']
 * @property string $t['formularz.korespondencjaAddress.etykieta']
 * @property string $t['formularz.korespondencjaAddress.opis']
 * @property string $t['formularz.korespondencjaApartament.etykieta']
 * @property string $t['formularz.korespondencjaApartament.opis']
 * @property string $t['formularz.korespondencjaCity.etykieta']
 * @property string $t['formularz.korespondencjaCity.opis']
 * @property string $t['formularz.korespondencjaPostcode.etykieta']
 * @property string $t['formularz.korespondencjaPostcode.opis']
 * @property string $t['formularz.name.etykieta']
 * @property string $t['formularz.name.opis']
 * @property string $t['formularz.orgNumber.etykieta']
 * @property string $t['formularz.orgNumber.opis']
 * @property string $t['formularz.phoneMobile.etykieta']
 * @property string $t['formularz.phoneMobile.opis']
 * @property string $t['formularz.phoneNumber.etykieta']
 * @property string $t['formularz.phoneNumber.opis']
 * @property string $t['formularz.phoneNumber1.etykieta']
 * @property string $t['formularz.phoneNumber2.etykieta']
 * @property string $t['formularz.postcode.etykieta']
 * @property string $t['formularz.postcode.opis']
 * @property string $t['formularz.secondName.etykieta']
 * @property string $t['formularz.secondName.opis']
 * @property string $t['formularz.surname.etykieta']
 * @property string $t['formularz.surname.opis']
 * @property string $t['formularz.type.etykieta']
 * @property string $t['formularz.type.opis']
 * @property string $t['formularz.wstecz.wartosc']
 * @property string $t['formularz.www.etykieta']
 * @property string $t['formularz.www.opis']
 * @property string $t['formularz.wybierz']
 * @property string $t['formularz.wybor_typu_klienta_info']
 * @property string $t['formularz.zapisz.wartosc']
 * @property string $t['formularzSzukaj.czysc.wartosc']
 * @property string $t['formularzSzukaj.data_dodania_do.etykieta']
 * @property string $t['formularzSzukaj.data_dodania_od.etykieta']
 * @property string $t['formularzSzukaj.email.etykieta']
 * @property string $t['formularzSzukaj.fraza.etykieta']
 * @property string $t['formularzSzukaj.status.etykieta']
 * @property string $t['formularzSzukaj.szukaj.wartosc']
 * @property string $t['formularzSzukaj.typ.etykieta']
 * @property string $t['index.etykieta_company_name']
 * @property string $t['index.etykieta_data_added']
 * @property string $t['index.etykieta_email']
 * @property string $t['index.etykieta_link_dodaj']
 * @property string $t['index.etykieta_name']
 * @property string $t['index.etykieta_org_number']
 * @property string $t['index.etykieta_phone_number']
 * @property string $t['index.etykieta_status']
 * @property string $t['index.etykieta_surname']
 * @property string $t['index.etykieta_type']
 * @property string $t['index.klienci_etykieta_przejdz_dalej']
 * @property string $t['index.tytul_modulu']
 * @property string $t['index.tytul_strony']
 * @property string $t['index.tytul_strony_kategoria']
 * @property string $t['klienci_dodaj.etykietaMenu']
 * @property string $t['klienci_index.etykietaMenu']
 * @property string $t['klienci_trash.etykietaMenu']
 * @property string $t['revert.blad_nie_mozna_pobrac_klienta']
 * @property string $t['revert.blad_rodzic_ma_status_delete']
 * @property string $t['revert.blad_rodzic_nie_istnieje']
 * @property string $t['revert.etykieta_potwierdz_przywroc']
 * @property string $t['revert.klienci_etykieta_przywroc']
 * @property string $t['revert.klient_przywrocony_z_kosza']
 * @property string $t['trash.tytul_strony']
 * @property string $t['usun.blad_klient_ma_dzieci']
 * @property string $t['usun.blad_nie_mozna_pobrac_klienta']
 * @property string $t['usun.etykieta_potwierdz_usun']
 * @property string $t['usun.klienci_etykieta_usun']
 * @property string $t['usun.klient_usuniety']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajAddCustomer']
 * @property string $t['_akcje_etykiety_']['wykonajTrash']
 * @property string $t['_akcje_etykiety_']['wykonajRevert']
 * @property string $t['_akcje_etykiety_']['wykonajDelete']
 * @property string $t['_akcje_etykiety_']['wykonajEditCustomer']
 * @property string $t['_akcje_etykiety_']['wykonajWyszukajKlientowAjax']
 * @property array $t['formularz.klienci_typy']
 * @property string $t['formularz.klienci_typy']['0']
 * @property string $t['formularz.klienci_typy']['company']
 * @property string $t['formularz.klienci_typy']['developer']
 * @property string $t['formularz.klienci_typy']['private']
 * @property string $t['formularz.klienci_typy']['branch contact person']
 * @property array $t['klienci_status']
 * @property string $t['klienci_status']['active']
 * @property string $t['klienci_status']['delete']
 */
class Admin extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'addCustomer.klienci_etykieta_dodaj' => 'Dodaj klienta',
		'dodaj.blad_nie_mozna_pobrac_rodzica' => 'Nie można pobrać rodzica do którego chcesz przypisać nowego klienta',
		'dodaj.blad_nie_mozna_zapisac_klienta' => 'Błąd przy zapisie klienta',
		'dodaj.info_klient_edycja_zapisany' => 'Edycja przebiegła pomyślnie',
		'dodaj.info_klient_zapisany' => 'Dodano nowego klienta do bazy',
		'dodaj.tytul_modulu' => 'Utwórz nowego klienta',
		'dodaj.tytul_strony' => 'Dodaj Klienta',
		'dodaj.tytul_strony_kategoria_dodaj' => 'Dodajesz klienta do kategorii : ',
		'editCustomer.klienci_etykieta_edytuj' => 'Edytuj klienta',
		'edytuj.blad_nie_mozna_pobrac_klienta' => 'Nie można pobrać klienta',
		'edytuj.tytul_strony' => 'Edycja klienta',
		'etykieta_select_wybierz' => '- wybierz -',
		'formularz.address.etykieta' => 'Adres',
		'formularz.address.opis' => '',
		'formularz.apartament.etykieta' => 'Apartament : ',
		'formularz.apartament.opis' => '',
		'formularz.city.etykieta' => 'Miasto',
		'formularz.city.opis' => '',
		'formularz.companyName.etykieta' => 'Nazwa firmy',
		'formularz.companyName.opis' => '',
		'formularz.dane_podstawowe.region' => 'Dane podstawowe',
		'formularz.edycja_admin_blad_walidacji' => 'Nie wszystkie wymagane pola zostały poprawnie wypełnione',
		'formularz.edycja_klienta_zablokowana' => 'Nie posiadasz uprawnień do edycji tego klienta. Skontaktuj się z Administratorem systemu aby dokonać zmian.',
		'formularz.email.etykieta' => 'Email',
		'formularz.email.opis' => '',
		'formularz.etykieta_pelny_form' => 'Pełne informacje',
		'formularz.etykieta_prosty_form' => 'Podstawowe informacje',
		'formularz.etykieta_tytul' => 'Stwórz nowego klienta',
		'formularz.fax.etykieta' => 'Fax',
		'formularz.fax.opis' => '',
		'formularz.idCustomer.etykieta' => 'Id klienta',
		'formularz.idCustomer.opis' => 'Id klienta (Get)',
		'formularz.idParent.etykieta' => 'Rodzic',
		'formularz.idParent.opis' => '',
		'formularz.kostsenter.etykieta' => 'Centrum kosztów : ',
		'formularz.kostsenter.opis' => '',
		'formularz.korespondencja.region' => 'Adres korespondencyjny',
		'formularz.korespondencjaAddress.etykieta' => 'Adres : ',
		'formularz.korespondencjaAddress.opis' => '',
		'formularz.korespondencjaApartament.etykieta' => 'Apartament : ',
		'formularz.korespondencjaApartament.opis' => '',
		'formularz.korespondencjaCity.etykieta' => 'Miasto : ',
		'formularz.korespondencjaCity.opis' => '',
		'formularz.korespondencjaPostcode.etykieta' => 'Kod pocztowy : ',
		'formularz.korespondencjaPostcode.opis' => '',
		'formularz.name.etykieta' => 'Imię',
		'formularz.name.opis' => '',
		'formularz.orgNumber.etykieta' => 'Numer firmy',
		'formularz.orgNumber.opis' => '',
		'formularz.phoneMobile.etykieta' => 'Telefon komórkowy',
		'formularz.phoneMobile.opis' => '',
		'formularz.phoneNumber.etykieta' => 'Telefon stacjonarny',
		'formularz.phoneNumber.opis' => '',
		'formularz.phoneNumber1.etykieta' => 'Telefon stacjonarny',
		'formularz.phoneNumber2.etykieta' => 'Telefon stacjonarny',
		'formularz.postcode.etykieta' => 'Kod pocztowy',
		'formularz.postcode.opis' => '',
		'formularz.secondName.etykieta' => 'Drugie imię',
		'formularz.secondName.opis' => '',
		'formularz.surname.etykieta' => 'Nazwisko',
		'formularz.surname.opis' => '',
		'formularz.type.etykieta' => 'Klient typ',
		'formularz.type.opis' => '',
		'formularz.wstecz.wartosc' => 'Wstecz',
		'formularz.www.etykieta' => 'www',
		'formularz.www.opis' => '',
		'formularz.wybierz' => ' - wybierz - ',
		'formularz.wybor_typu_klienta_info' => 'Wybierz typ klienta w pierwszej kolejności. Jeśli chcesz dodać osobę kontaktową w firmie pamiętaj że firma musi być dodana do systemu w pierwszej kolejności.',
		'formularz.zapisz.wartosc' => 'Zapisz',
		'formularzSzukaj.czysc.wartosc' => 'Czyść',
		'formularzSzukaj.data_dodania_do.etykieta' => 'do : ',
		'formularzSzukaj.data_dodania_od.etykieta' => 'Data dodania od : ',
		'formularzSzukaj.email.etykieta' => 'Email : ',
		'formularzSzukaj.fraza.etykieta' => 'Fraza : ',
		'formularzSzukaj.status.etykieta' => 'Status : ',
		'formularzSzukaj.szukaj.wartosc' => 'Szukaj',
		'formularzSzukaj.typ.etykieta' => 'Type : ',
		'index.etykieta_company_name' => 'Nazwa firmy',
		'index.etykieta_data_added' => 'Data dodania',
		'index.etykieta_email' => 'Email',
		'index.etykieta_link_dodaj' => 'Dodaj klienta',
		'index.etykieta_name' => 'Imię',
		'index.etykieta_org_number' => 'Kod firmy',
		'index.etykieta_phone_number' => 'Telefon',
		'index.etykieta_status' => 'Status',
		'index.etykieta_surname' => 'Nazwisko',
		'index.etykieta_type' => 'Typ klienta',
		'index.klienci_etykieta_przejdz_dalej' => 'Pokaż kategorie',
		'index.tytul_modulu' => 'Klienci',
		'index.tytul_strony' => 'Klienci',
		'index.tytul_strony_kategoria' => 'Lista kontaktów klienta : ',
		'klienci_dodaj.etykietaMenu' => 'Dodaj klienta',
		'klienci_index.etykietaMenu' => 'Lista klientów',
		'klienci_trash.etykietaMenu' => 'Kosz',
		'revert.blad_nie_mozna_pobrac_klienta' => 'Nie można pobrać klienta',
		'revert.blad_rodzic_ma_status_delete' => 'Nie można przywrócić klienta, rodzic klienta ma status usunięty',
		'revert.blad_rodzic_nie_istnieje' => 'Nie można przywrócić klienta, rodzic klienta nie istnieje',
		'revert.etykieta_potwierdz_przywroc' => 'Czy napewno chcesz przywrócić klienta ?',
		'revert.klienci_etykieta_przywroc' => 'Przywróć klienta',
		'revert.klient_przywrocony_z_kosza' => 'Klient został przywrócony',
		'trash.tytul_strony' => 'Lista usuniętych klientów',
		'usun.blad_klient_ma_dzieci' => 'Nie można usunąć klienta, klient posiada dzieci',
		'usun.blad_nie_mozna_pobrac_klienta' => 'Nie można pobrać klienta',
		'usun.etykieta_potwierdz_usun' => 'Czy napewno chcesz usunąć klienta ?',
		'usun.klienci_etykieta_usun' => 'Usuń klienta',
		'usun.klient_usuniety' => 'Klient został usunięty',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Lista klientów',
			'wykonajAddCustomer' => 'Dodaj klienta',
			'wykonajTrash' => 'Klienci usunięci',
			'wykonajRevert' => 'Przywróć z kosza',
			'wykonajDelete' => 'Usuń klienta',
			'wykonajEditCustomer' => 'Edytuj klienta',
			'wykonajWyszukajKlientowAjax' => 'Wyszukaj klientów poprzez żądanie Ajax',
		),
		'formularz.klienci_typy' => array(
			'0' => '- wybierz -',
			//'company' => 'Firma',
			//'developer' => 'Deweloper',
			'private' => 'Osoba prywatna',
			//'branch contact person' => 'Osoba kontaktowa',
		),
		'klienci_status' => array(
			'active' => 'Aktywny',
			'delete' => 'Usunięty',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}