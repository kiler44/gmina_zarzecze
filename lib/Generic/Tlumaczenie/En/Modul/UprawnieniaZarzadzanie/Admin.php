<?php
namespace Generic\Tlumaczenie\En\Modul\UprawnieniaZarzadzanie;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['dodaj.etykieta_odwroc_zaznaczenie']
 * @property string $t['dodaj.etykieta_odznacz_wiele']
 * @property string $t['dodaj.etykieta_zaznacz_wiele']
 * @property string $t['dodaj.tytul_strony']
 * @property string $t['edytuj.blad_nie_mozna_pobrac_roli']
 * @property string $t['edytuj.etykieta_odwroc_zaznaczenie']
 * @property string $t['edytuj.etykieta_odznacz_wiele']
 * @property string $t['edytuj.etykieta_zaznacz_wiele']
 * @property string $t['edytuj.tytul_strony']
 * @property string $t['formularz.blad_nie_mozna_zapisac_roli']
 * @property string $t['formularz.etykieta_input_kod']
 * @property string $t['formularz.etykieta_input_nazwa']
 * @property string $t['formularz.etykieta_input_opis']
 * @property string $t['formularz.etykieta_input_wstecz']
 * @property string $t['formularz.etykieta_input_zapisz']
 * @property string $t['formularz.region_bloki']
 * @property string $t['formularz.region_moduly']
 * @property string $t['formularz.zakladka_dane']
 * @property string $t['formularz.zakladka_moduly']
 * @property string $t['formularz.zapisano_dane_roli']
 * @property string $t['index.etykieta_kod']
 * @property string $t['index.etykieta_link_dodaj']
 * @property string $t['index.etykieta_nazwa']
 * @property string $t['index.etykieta_opis']
 * @property string $t['index.tytul_strony']
 * @property string $t['podglad.etykieta_edytuj']
 * @property string $t['podglad.etykieta_kod']
 * @property string $t['podglad.etykieta_link_edytuj']
 * @property string $t['podglad.etykieta_link_uprawnienia_administracyjne']
 * @property string $t['podglad.etykieta_link_uprawnienia_tresci']
 * @property string $t['podglad.etykieta_nazwa']
 * @property string $t['podglad.etykieta_opis']
 * @property string $t['podglad.etykieta_uprawnienia_administracyjne']
 * @property string $t['podglad.etykieta_uprawnienia_tresci']
 * @property string $t['podglad.tytul_strony']
 * @property string $t['uprawnieniaAdministracyjne.blad_nie_mozna_pobrac_roli']
 * @property string $t['uprawnieniaAdministracyjne.blad_nie_mozna_zapisac_uprawnien']
 * @property string $t['uprawnieniaAdministracyjne.etykieta_odwroc_zaznaczenie']
 * @property string $t['uprawnieniaAdministracyjne.etykieta_odznacz_wiele']
 * @property string $t['uprawnieniaAdministracyjne.etykieta_zaznacz_wiele']
 * @property string $t['uprawnieniaAdministracyjne.info_zapisano_uprawnienia']
 * @property string $t['uprawnieniaAdministracyjne.tytul_strony']
 * @property string $t['uprawnieniaTresci.blad_nie_mozna_pobrac_roli']
 * @property string $t['uprawnieniaTresci.blad_nie_mozna_zapisac_uprawnien']
 * @property string $t['uprawnieniaTresci.etykieta_odwroc_zaznaczenie']
 * @property string $t['uprawnieniaTresci.etykieta_odznacz_wiele']
 * @property string $t['uprawnieniaTresci.etykieta_zaznacz_wiele']
 * @property string $t['uprawnieniaTresci.info_zapisano_uprawnienia']
 * @property string $t['uprawnieniaTresci.tytul_strony']
 * @property string $t['usun.blad_brak_roli']
 * @property string $t['usun.blad_nie_mozna_usunac_roli']
 * @property string $t['usun.info_rola_usunieta']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajDodaj']
 * @property string $t['_akcje_etykiety_']['wykonajEdytuj']
 * @property string $t['_akcje_etykiety_']['wykonajPodglad']
 * @property string $t['_akcje_etykiety_']['wykonajUprawnieniaTresci']
 * @property string $t['_akcje_etykiety_']['wykonajUprawnieniaAdministracyjne']
 * @property string $t['_akcje_etykiety_']['wykonajUsun']
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(

		'dodaj.etykieta_odwroc_zaznaczenie' => 'Reverse selected',
		'dodaj.etykieta_odznacz_wiele' => 'Uncheck all',
		'dodaj.etykieta_zaznacz_wiele' => 'Check all',
		'dodaj.tytul_strony' => 'Add role',

		'edytuj.blad_nie_mozna_pobrac_roli' => 'Cannot obtain role data',
		'edytuj.etykieta_odwroc_zaznaczenie' => 'Reverse selected',
		'edytuj.etykieta_odznacz_wiele' => 'Uncheck all',
		'edytuj.etykieta_zaznacz_wiele' => 'Check all',
		'edytuj.tytul_strony' => 'Edit role',

		'formularz.blad_nie_mozna_zapisac_roli' => 'Cannot save role data',
		'formularz.etykieta_input_kod' => 'Code',
		'formularz.etykieta_input_nazwa' => 'Name',
		'formularz.etykieta_input_opis' => 'Description',
		'formularz.etykieta_input_wstecz' => 'Back',
		'formularz.etykieta_input_zapisz' => 'Save',
		'formularz.region_bloki' => 'Available blocks',
		'formularz.region_moduly' => 'Available modules',
		'formularz.zakladka_dane' => 'Role data',
		'formularz.zakladka_moduly' => 'Modules with automatic access',
		'formularz.zapisano_dane_roli' => 'Role data saved',
		'formularz.kontekstowa.etykieta' => 'Context role',
		'formularz.kontekstowa.opis' => 'If checked, to give acces you will need apropriate context',
		'formularz.kontekstowa.lista' => array(
			1 => 'no',
			2 => 'yes',
		),
		'formularz.kontekstObiekt.etykieta' => 'Related object',
		'formularz.kontekstObiekt.opis' => '',
		'formularz.kontekstPole.etykieta' => 'Object properties',
		'formularz.kontekstPole.opis' => '',
		'formularz.kontekstPowiazanie.etykieta' => 'Link of user and object',
		'formularz.kontekstPowiazanie.opis' => '',
		'formularz.kontekstPowiazanieKtoreId.etykieta' => 'Which field in object is related',
		'formularz.kontekstPowiazanieKtoreId.opis' => '',
		'formularz.kontekstPowiazanieKtoreId.lista' => array(
			'' => '- Select -',
			1 => 'ID1',
			2 => 'ID2'
		),
		'formularz.wybierz' => '- Select -',

		'index.etykieta_kod' => 'Code',
		'index.etykieta_link_dodaj' => 'Add new role',
		'index.etykieta_nazwa' => 'name',
		'index.etykieta_opis' => 'Description',
		'index.tytul_strony' => 'User roles in system',

		'podglad.etykieta_edytuj' => 'Edit data of automatic modules access',
		'podglad.etykieta_kod' => 'Code',
		'podglad.etykieta_link_edytuj' => 'Edit role',
		'podglad.etykieta_link_uprawnienia_administracyjne' => 'Edit administrative permissions',
		'podglad.etykieta_link_uprawnienia_tresci' => 'Edit permissions',
		'podglad.etykieta_link_uprawnienia_obiektow' => 'Edit objects permissions',
		'podglad.etykieta_nazwa' => 'Name',
		'podglad.etykieta_opis' => 'Description',
		'podglad.etykieta_uprawnienia_administracyjne' => 'Edit administrative permissions',
		'podglad.etykieta_uprawnienia_tresci' => 'Edit contetnt permissions',
		'podglad.etykieta_uprawnienia_obiektow' => 'Edit objects permissions',
		'podglad.tytul_strony' => 'Role informations',
		'podglad.etykieta_uprawnienia_do_eventow' => 'Edit events permissions',
		'podglad.etykieta_link_uprawnienia_do_eventow' => 'Edit events permissions',

		'uprawnieniaAdministracyjne.blad_nie_mozna_pobrac_roli' => 'Cannot obtain role data',
		'uprawnieniaAdministracyjne.blad_nie_mozna_zapisac_uprawnien' => 'Cannot save role permissions',
		'uprawnieniaAdministracyjne.etykieta_odwroc_zaznaczenie' => 'Reverse selected',
		'uprawnieniaAdministracyjne.etykieta_odznacz_wiele' => 'Uncheck all',
		'uprawnieniaAdministracyjne.etykieta_zaznacz_wiele' => 'Check all',
		'uprawnieniaAdministracyjne.info_zapisano_uprawnienia' => 'Role permissions saved',
		'uprawnieniaAdministracyjne.tytul_strony' => 'Edit administrative permissions for role "%s"',
		
		'uprawnieniaEventow.tytul_strony' => 'Edit event permissions for role "%s"',
		'uprawnieniaEventow.brak_uprawnien_do_kalendarza' => 'This role does not have permission to Calendar module',

		'uprawnieniaObiektow.blad_nie_mozna_pobrac_roli' => 'Cannot obtain role data',
		'uprawnieniaObiektow.blad_nie_mozna_zapisac_uprawnien' => 'Cannot save role permissions',
		'uprawnieniaObiektow.etykieta_odwroc_zaznaczenie' => 'Reverse selected',
		'uprawnieniaObiektow.etykieta_odznacz_wiele' => 'Uncheck all',
		'uprawnieniaObiektow.etykieta_zaznacz_wiele' => 'Check all',
		'uprawnieniaObiektow.info_zapisano_uprawnienia' => 'Role permissions saved',
		'uprawnieniaObiektow.tytul_strony' => 'Edit objects permissions for role "%s"',
		'uprawnieniaObiektow.odczyt' => '<span style="color:#5BB75B;"><strong>%s</strong> read</span>',
		'uprawnieniaObiektow.zapis' => '<span style="color:#DA4F49;"><strong>%s</strong> write</span>',

		'uprawnieniaTresci.blad_nie_mozna_pobrac_roli' => 'Cannot obtain role data',
		'uprawnieniaTresci.blad_nie_mozna_zapisac_uprawnien' => 'Cannot save role permissions',
		'uprawnieniaTresci.etykieta_odwroc_zaznaczenie' => 'Reverse selected',
		'uprawnieniaTresci.etykieta_odznacz_wiele' => 'Uncheck all',
		'uprawnieniaTresci.etykieta_zaznacz_wiele' => 'Check all',
		'uprawnieniaTresci.info_zapisano_uprawnienia' => 'Role permissions saved',
		'uprawnieniaTresci.tytul_strony' => 'Edit permissions for role "%s"',

		'usun.blad_brak_roli' => 'Cannot obtain role data',
		'usun.blad_nie_mozna_usunac_roli' => 'Cannot delete selected role',
		'usun.info_rola_usunieta' => 'Role removed',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'List of roles',
			'wykonajDodaj' => 'Add role',
			'wykonajEdytuj' => 'Edit role',
			'wykonajPodglad' => 'Edit role main screen',
			'wykonajUprawnieniaTresci' => 'Edit content permissions',
			'wykonajUprawnieniaAdministracyjne' => 'Edit administrative permissions',
			'wykonajUsun' => 'Remove role',
		),
	);
}
