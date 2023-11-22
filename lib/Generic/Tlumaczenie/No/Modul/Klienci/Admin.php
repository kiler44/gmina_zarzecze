<?php
namespace Generic\Tlumaczenie\No\Modul\Klienci;

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
		'addCustomer.klienci_etykieta_dodaj' => 'Legg kunde',
		'dodaj.blad_nie_mozna_pobrac_rodzica' => 'Kan ikke få en forelder du vil tilordne en ny kunde',
		'dodaj.blad_nie_mozna_zapisac_klienta' => 'Feil ved skriving av kunden',
		'dodaj.info_klient_edycja_zapisany' => 'Redigering var vellykket',
		'dodaj.info_klient_zapisany' => 'Lagt ny kundebase',
		'dodaj.tytul_modulu' => 'Lagt ny kunde',
		'dodaj.tytul_strony' => 'Legg klient',
		'dodaj.tytul_strony_kategoria_dodaj' => 'Legg kunden til kategori:',
		'editCustomer.klienci_etykieta_edytuj' => 'Redigere kunde',
		'edytuj.blad_nie_mozna_pobrac_klienta' => 'Kan ikke få en kunden',
		'edytuj.tytul_strony' => 'Redigere kunden',
		'etykieta_select_wybierz' => '- velg -',
		'formularz.address.etykieta' => 'Adresse : ',
		'formularz.address.opis' => '',
		'formularz.apartament.etykieta' => 'Leilighet : ',
		'formularz.apartament.opis' => '',
		'formularz.city.etykieta' => 'By : ',
		'formularz.city.opis' => '',
		'formularz.companyName.etykieta' => 'Firmanavn : ',
		'formularz.companyName.opis' => '',
		'formularz.dane_podstawowe.region' => 'Generelle data',
		'formularz.edycja_admin_blad_walidacji' => 'Ikke alle nødvendige felt er korrekt utfylt',
		'formularz.edycja_klienta_zablokowana' => 'You don\'t have permission to edit this customer, Please contact with Administrator to make changes.',
		'formularz.email.etykieta' => 'Email : ',
		'formularz.email.opis' => '',
		'formularz.etykieta_pelny_form' => 'Fullstendige opplysninger',
		'formularz.etykieta_prosty_form' => 'Grunnleggende informasjon',
		'formularz.etykieta_tytul' => 'Opprett ny kunde',
		'formularz.fax.etykieta' => 'Fax : ',
		'formularz.fax.opis' => '',
		'formularz.idCustomer.etykieta' => 'Id kunde : ',
		'formularz.idCustomer.opis' => 'Id kunde (Get)',
		'formularz.idParent.etykieta' => 'Far : ',
		'formularz.idParent.opis' => '',
		'formularz.kostsenter.etykieta' => 'Kostsenter : ',
		'formularz.kostsenter.opis' => '',
		'formularz.korespondencja.region' => 'Delivery address',
		'formularz.korespondencjaAddress.etykieta' => 'Address : ',
		'formularz.korespondencjaAddress.opis' => '',
		'formularz.korespondencjaApartament.etykieta' => 'Leilighet : ',
		'formularz.korespondencjaApartament.opis' => '',
		'formularz.korespondencjaCity.etykieta' => 'City : ',
		'formularz.korespondencjaCity.opis' => '',
		'formularz.korespondencjaPostcode.etykieta' => 'Postcode : ',
		'formularz.korespondencjaPostcode.opis' => '',
		'formularz.name.etykieta' => 'Navn : ',
		'formularz.name.opis' => '',
		'formularz.orgNumber.etykieta' => 'Org. number : ',
		'formularz.orgNumber.opis' => '',
		'formularz.phoneMobile.etykieta' => 'Mobiltelefon : ',
		'formularz.phoneMobile.opis' => '',
		'formularz.phoneNumber.etykieta' => 'Telefon : ',
		'formularz.phoneNumber.opis' => '',
		'formularz.phoneNumber1.etykieta' => 'Telefon : ',
		'formularz.phoneNumber2.etykieta' => 'Telefon : ',
		'formularz.postcode.etykieta' => 'Postnummer : ',
		'formularz.postcode.opis' => '',
		'formularz.secondName.etykieta' => 'Andre navn : ',
		'formularz.secondName.opis' => '',
		'formularz.surname.etykieta' => 'Etternavn : ',
		'formularz.surname.opis' => '',
		'formularz.type.etykieta' => 'Kundetype : ',
		'formularz.type.opis' => '',
		'formularz.wstecz.wartosc' => 'Tilbake',
		'formularz.www.etykieta' => 'www : ',
		'formularz.www.opis' => 'www',
		'formularz.wybierz' => ' - velg - ',
		'formularz.wybor_typu_klienta_info' => 'Velg kundetype først. Hvis du er i ferd med å skape "gren kontaktperson" må du kontrollere at morselskapet er allerede i systemet. Hvis ikke legge til morselskapet før du legger gren kontakt.',
		'formularz.zapisz.wartosc' => 'Spare',
		'formularzSzukaj.czysc.wartosc' => 'Klart',
		'formularzSzukaj.data_dodania_do.etykieta' => 'til : ',
		'formularzSzukaj.data_dodania_od.etykieta' => 'Dato fra: ',
		'formularzSzukaj.email.etykieta' => 'Email : ',
		'formularzSzukaj.fraza.etykieta' => 'Søkefrase : ',
		'formularzSzukaj.status.etykieta' => 'Status : ',
		'formularzSzukaj.szukaj.wartosc' => 'Søk',
		'formularzSzukaj.typ.etykieta' => 'Type : ',
		'index.etykieta_company_name' => 'Firmanavn',
		'index.etykieta_data_added' => 'Data lagt',
		'index.etykieta_email' => 'Email',
		'index.etykieta_link_dodaj' => 'Legg kunden',
		'index.etykieta_name' => 'Navn',
		'index.etykieta_org_number' => 'org. no.',
		'index.etykieta_phone_number' => 'Telefon',
		'index.etykieta_status' => 'Status',
		'index.etykieta_surname' => 'Etternavn',
		'index.etykieta_type' => 'Kundetype',
		'index.klienci_etykieta_przejdz_dalej' => 'Vis kategori',
		'index.tytul_modulu' => 'Kunder',
		'index.tytul_strony' => 'Kunder',
		'index.tytul_strony_kategoria' => 'Kundekontakt listen:',
		'klienci_dodaj.etykietaMenu' => 'Legg kunde',
		'klienci_index.etykietaMenu' => 'Liste over kunde',
		'klienci_trash.etykietaMenu' => 'Søppel',
		'revert.blad_nie_mozna_pobrac_klienta' => 'Kan ikke få en kunden',
		'revert.blad_rodzic_ma_status_delete' => 'Kan ikke gjenopprette en kunden, ble morselskapet slettet',
		'revert.blad_rodzic_nie_istnieje' => 'Kan ikke gjenopprette en kunden, betyr kunden `s foreldre ikke eksisterer',
		'revert.etykieta_potwierdz_przywroc' => 'Er du sikker på at du vil gjenopprette en kunden?',
		'revert.klienci_etykieta_przywroc' => 'Gjenopprette kunden',
		'revert.klient_przywrocony_z_kosza' => 'Kunden har blitt restaurert',
		'trash.tytul_strony' => 'Liste over slettede kunder',
		'usun.blad_klient_ma_dzieci' => 'Du kan ikke slette en kunde, har kunden barn',
		'usun.blad_nie_mozna_pobrac_klienta' => 'Kan ikke få en kunden',
		'usun.etykieta_potwierdz_usun' => 'Er du sikker på at du vil slette kunden?',
		'usun.klienci_etykieta_usun' => 'Fjern kunde',
		'usun.klient_usuniety' => 'Kunden har blitt fjernet',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Kunder liste',
			'wykonajAddCustomer' => 'Legg klient',
			'wykonajTrash' => 'Kunder slettet',
			'wykonajRevert' => 'Gjenopprette kunde',
			'wykonajDelete' => 'Fjern kunde',
			'wykonajEditCustomer' => 'Redigere kunde',
			'wykonajWyszukajKlientowAjax' => 'Søk etter kunde via Ajax forespørsel',
		),
		'formularz.klienci_typy' => array(
			'0' => '- velg -',
			'company' => 'Selskapet',
			'developer' => 'Utvikler',
			'private' => 'Privatperson',
			'branch contact person' => 'Gren kontaktperson',
		),
		'klienci_status' => array(
			'active' => 'Aktiv',
			'delete' => 'Slett',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}