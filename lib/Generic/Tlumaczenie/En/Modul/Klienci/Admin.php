<?php
namespace Generic\Tlumaczenie\En\Modul\Klienci;

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
 * @property string $t['index.tytul_strony_kategoria_dodaj']
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
		'addCustomer.klienci_etykieta_dodaj' => 'Add customer',
		'dodaj.blad_nie_mozna_pobrac_rodzica' => 'Unable to get a parent you want to assign a new customer',
		'dodaj.blad_nie_mozna_zapisac_klienta' => 'Error writing customer',
		'dodaj.info_klient_edycja_zapisany' => 'Editing was successful',
		'dodaj.info_klient_zapisany' => 'Added new customer to database',
		'dodaj.tytul_modulu' => 'Create new customer',
		'dodaj.tytul_strony' => 'Add customer',
		'dodaj.tytul_strony_kategoria_dodaj' => 'Add customer to category : ',
		'editCustomer.klienci_etykieta_edytuj' => 'Edit customer',
		'edytuj.blad_nie_mozna_pobrac_klienta' => 'Can`t get a customer',
		'edytuj.tytul_strony' => 'Edit customer',
		'etykieta_select_wybierz' => '- select -',
		'formularz.address.etykieta' => 'Address : ',
		'formularz.address.opis' => '',
		'formularz.apartament.etykieta' => 'Apartment : ',
		'formularz.apartament.opis' => '',
		'formularz.city.etykieta' => 'City : ',
		'formularz.city.opis' => '',
		'formularz.companyName.etykieta' => 'Company name : ',
		'formularz.companyName.opis' => '',
		'formularz.dane_podstawowe.region' => 'General data',
		'formularz.edycja_admin_blad_walidacji' => 'Not all required fields have been correctly filled in',
		'formularz.edycja_klienta_zablokowana' => 'You don\'t have permission to edit this customer, Please contact with Administrator to make changes.',
		'formularz.email.etykieta' => 'Email : ',
		'formularz.email.opis' => '',
		'formularz.etykieta_pelny_form' => 'Full informations',
		'formularz.etykieta_prosty_form' => 'Basic informations',
		'formularz.etykieta_tytul' => 'Create new customer',
		'formularz.fax.etykieta' => 'Fax : ',
		'formularz.fax.opis' => '',
		'formularz.idCustomer.etykieta' => 'Id customer : ',
		'formularz.idCustomer.opis' => 'Id customer (Get)',
		'formularz.idParent.etykieta' => 'Parent : ',
		'formularz.idParent.opis' => '',
		'formularz.kostsenter.etykieta' => 'Cost center : ',
		'formularz.kostsenter.opis' => '',
		'formularz.korespondencja.region' => 'Delivery address',
		'formularz.korespondencjaAddress.etykieta' => 'Address : ',
		'formularz.korespondencjaAddress.opis' => '',
		'formularz.korespondencjaApartament.etykieta' => 'Apartment : ',
		'formularz.korespondencjaApartament.opis' => '',
		'formularz.korespondencjaCity.etykieta' => 'City : ',
		'formularz.korespondencjaCity.opis' => '',
		'formularz.korespondencjaPostcode.etykieta' => 'Postcode : ',
		'formularz.korespondencjaPostcode.opis' => '',
		'formularz.name.etykieta' => 'First name : ',
		'formularz.name.opis' => '',
		'formularz.orgNumber.etykieta' => 'Organization number : ',
		'formularz.orgNumber.opis' => '',
		'formularz.phoneMobile.etykieta' => 'Mobile phone : ',
		'formularz.phoneMobile.opis' => '',
		'formularz.phoneNumber.etykieta' => 'Phone number : ',
		'formularz.phoneNumber.opis' => '',
		'formularz.phoneNumber1.etykieta' => 'Phone number : ',
		'formularz.phoneNumber2.etykieta' => 'Phone number : ',
		'formularz.postcode.etykieta' => 'Postcode : ',
		'formularz.postcode.opis' => '',
		'formularz.secondName.etykieta' => 'Second name : ',
		'formularz.secondName.opis' => '',
		'formularz.surname.etykieta' => 'Surname : ',
		'formularz.surname.opis' => '',
		'formularz.type.etykieta' => 'Customer type : ',
		'formularz.type.opis' => '',
		'formularz.wstecz.wartosc' => 'Back',
		'formularz.www.etykieta' => 'www : ',
		'formularz.www.opis' => '',
		'formularz.wybierz' => ' - select - ',
		'formularz.wybor_typu_klienta_info' => 'Please select customer type first. If you are about to create "branch contact person" please make sure that parent company is already in the system. If not add parent company before adding branch contact.',
		'formularz.zapisz.wartosc' => 'Save',
		'formularzSzukaj.czysc.wartosc' => 'Reset',
		'formularzSzukaj.data_dodania_do.etykieta' => 'to : ',
		'formularzSzukaj.data_dodania_od.etykieta' => 'Date from : ',
		'formularzSzukaj.email.etykieta' => 'Email : ',
		'formularzSzukaj.fraza.etykieta' => 'Phrase : ',
		'formularzSzukaj.status.etykieta' => 'Status : ',
		'formularzSzukaj.szukaj.wartosc' => 'Search',
		'formularzSzukaj.typ.etykieta' => 'Type : ',
		'index.etykieta_company_name' => 'Company Name',
		'index.etykieta_data_added' => 'Data added',
		'index.etykieta_email' => 'Email',
		'index.etykieta_link_dodaj' => 'Add customer',
		'index.etykieta_name' => 'Name',
		'index.etykieta_org_number' => 'Org. number',
		'index.etykieta_phone_number' => 'Phone',
		'index.etykieta_status' => 'Status',
		'index.etykieta_surname' => 'Surname',
		'index.etykieta_type' => 'Customer type',
		'index.klienci_etykieta_przejdz_dalej' => 'Show category',
		'index.tytul_modulu' => 'Customers',
		'index.tytul_strony' => 'Customers',
		'index.tytul_strony_kategoria' => 'Customer contact list:',
		'index.tytul_strony_kategoria_dodaj' => 'Add the customer to the category:',
		'klienci_dodaj.etykietaMenu' => 'Add customers',
		'klienci_index.etykietaMenu' => 'List of customers',
		'klienci_trash.etykietaMenu' => 'Trash',
		'revert.blad_nie_mozna_pobrac_klienta' => 'Can`t get a customer',
		'revert.blad_rodzic_ma_status_delete' => 'Can`t restore a customer, the parent was deleted',
		'revert.blad_rodzic_nie_istnieje' => 'Can`t restore a customer, customer`s parent does not exist',
		'revert.etykieta_potwierdz_przywroc' => 'Are you sure you want to restore a customer?',
		'revert.klienci_etykieta_przywroc' => 'Restore customer',
		'revert.klient_przywrocony_z_kosza' => 'The customer has been restored',
		'trash.tytul_strony' => 'List of deleted customers',
		'usun.blad_klient_ma_dzieci' => 'You can not delete a customer, the customer has children',
		'usun.blad_nie_mozna_pobrac_klienta' => 'Can`t get a customer',
		'usun.etykieta_potwierdz_usun' => 'Are you sure you want to delete the customer?',
		'usun.klienci_etykieta_usun' => 'Remove customer',
		'usun.klient_usuniety' => 'The customer has been removed',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Customers list',
			'wykonajAddCustomer' => 'Add client',
			'wykonajTrash' => 'Customers deleted',
			'wykonajRevert' => 'Restore customer',
			'wykonajDelete' => 'Remove customer',
			'wykonajEditCustomer' => 'Edit client',
			'wykonajWyszukajKlientowAjax' => 'Search for customer via Ajax request',
		),
		'formularz.klienci_typy' => array(
			'0' => ' - select - ',
			'company' => 'Company',
			'developer' => 'Developer',
			'private' => 'Private person',
			'branch contact person' => 'Branch contact person',
		),
		'klienci_status' => array(
			'active' => 'Active',
			'delete' => 'Delete',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}