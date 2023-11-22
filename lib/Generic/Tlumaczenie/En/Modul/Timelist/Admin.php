<?php
namespace Generic\Tlumaczenie\En\Modul\Timelist;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie 
 * @property string $t['addtimelist.tytul_modulu']
 * @property string $t['addtimelist.tytul_modulu_zamowienie']
 * @property string $t['addtimelist.tytul_strony']
 * @property string $t['addtimelist.tytul_strony_zamowienie']
 * @property string $t['addtimelist.zamowienie_nie_istnieje']
 * @property string $t['addworker.dobierz_pracownika_blad']
 * @property string $t['addworker.formularz_blad']
 * @property string $t['addworker.formularz_poprawny']
 * @property string $t['addworker.tytul_modulu']
 * @property string $t['addworker.tytul_strony']
 * @property string $t['delete.nie_mozna_pobrac_timelist']
 * @property string $t['delete.nie_mozna_usunac_timelist']
 * @property string $t['delete.timelist_usunieta']
 * @property string $t['deleteworker.formularz_blad']
 * @property string $t['deleteworker.formularz_poprawny']
 * @property string $t['deleteworker.tytul_modulu']
 * @property string $t['deleteworker.tytul_strony']
 * @property string $t['deleteworker.usun_pracownika_blad']
 * @property string $t['details.chorobowe_link_etykieta']
 * @property string $t['details.chorobowe_naglowek']
 * @property string $t['details.delete']
 * @property string $t['details.edycja_timelist']
 * @property string $t['details.etykieta_data_start']
 * @property string $t['details.etykieta_data_stop']
 * @property string $t['details.etykieta_dni']
 * @property string $t['details.etykieta_dzien']
 * @property string $t['details.etykieta_ekipa']
 * @property string $t['details.etykieta_godzin']
 * @property string $t['details.etykieta_godzina']
 * @property string $t['details.etykieta_godziny']
 * @property string $t['details.etykieta_hours']
 * @property string $t['details.etykieta_liczba_godzin']
 * @property string $t['details.etykieta_minut']
 * @property string $t['details.etykieta_multiplier']
 * @property string $t['details.etykieta_netto']
 * @property string $t['details.etykieta_order_name']
 * @property string $t['details.etykieta_status_work']
 * @property string $t['details.etykieta_stawka']
 * @property string $t['details.etykieta_type']
 * @property string $t['details.etykieta_waluta']
 * @property string $t['details.etykieta_x_multiplier']
 * @property string $t['details.etykieta_zarobil']
 * @property string $t['details.holiday_link_etykieta']
 * @property string $t['details.naglowek_holiday']
 * @property string $t['details.podglad_zamowienia']
 * @property string $t['details.podsumowanie_etykieta_netto']
 * @property string $t['details.podsumowanie_naglowek']
 * @property string $t['details.podsumownie_etykieta_godziny']
 * @property string $t['details.podsumownie_etykieta_typ']
 * @property string $t['details.podsumownie_etykieta_zarobil']
 * @property string $t['details.podsumownie_rok']
 * @property string $t['details.podsumownie_tabela_podatkowa']
 * @property string $t['details.pracownik_nie_istnieje']
 * @property string $t['details.tytul_modulu']
 * @property string $t['details.tytul_modulu_pracownik']
 * @property string $t['details.tytul_strony']
 * @property string $t['details.tytul_strony_pracownik']
 * @property string $t['details.usun']
 * @property string $t['details.zamowienia_naglowek']
 * @property string $t['detailsorder.etykieta_dateAdded']
 * @property string $t['detailsorder.etykieta_date_start']
 * @property string $t['detailsorder.etykieta_ekipa']
 * @property string $t['detailsorder.etykieta_godzin_lacznie']
 * @property string $t['detailsorder.etykieta_pracownik']
 * @property string $t['detailsorder.etykieta_stawka']
 * @property string $t['detailsorder.etykieta_stop']
 * @property string $t['detailsorder.etykieta_zarobil_brutto']
 * @property string $t['detailsorder.link_wstecz_etykieta']
 * @property string $t['detailsorder.tytul_modulu']
 * @property string $t['detailsorder.tytul_modulu_info']
 * @property string $t['detailsorder.tytul_strony']
 * @property string $t['detailsorder.tytul_strony_info']
 * @property string $t['detailsorder.wybrane_zamowienie_nie_istnieje']
 * @property string $t['editTimelist.nie_mozna_pobrac_timelisty']
 * @property string $t['edittimelist.tytul_modulu']
 * @property string $t['edittimelist.tytul_modulu_informacja']
 * @property string $t['edittimelist.tytul_strony']
 * @property string $t['edittimelist.tytul_strony_informacja']
 * @property string $t['formularz.blad']
 * @property string $t['formularz.dataStart.etykieta']
 * @property string $t['formularz.dataStart.opis']
 * @property string $t['formularz.dataStop.etykieta']
 * @property string $t['formularz.dataStop.opis']
 * @property string $t['formularz.etykieta_select_wybierz']
 * @property string $t['formularz.hours.etykieta']
 * @property string $t['formularz.hours.opis']
 * @property string $t['formularz.multiplier.etykieta']
 * @property string $t['formularz.multiplier.opis']
 * @property string $t['formularz.poprawne']
 * @property string $t['formularz.select_wybierz']
 * @property string $t['formularz.stawka.etykieta']
 * @property string $t['formularz.stawka.opis']
 * @property string $t['formularz.type.etykieta']
 * @property string $t['formularz.type.opis']
 * @property string $t['formularz.wstecz.wartosc']
 * @property string $t['formularz.zapisz.wartosc']
 * @property string $t['formularzAddWorker.pracownik.etykieta']
 * @property string $t['formularzAddWorker.wstecz.wartosc']
 * @property string $t['formularzAddWorker.zapisz.wartosc']
 * @property string $t['formularzSeekDay.dataStart.etykieta']
 * @property string $t['formularzSeekDay.dataStart.opis']
 * @property string $t['formularzSeekDay.dataStop.etykieta']
 * @property string $t['formularzSeekDay.dataStop.opis']
 * @property string $t['formularzSeekDay.formularz.region']
 * @property string $t['formularzSeekDay.wstecz.wartosc']
 * @property string $t['formularzSeekDay.zapisz.wartosc']
 * @property string $t['formularzSzukaj.czysc.wartosc']
 * @property string $t['formularzSzukaj.data_start_do.etykieta']
 * @property string $t['formularzSzukaj.data_start_od.etykieta']
 * @property string $t['formularzSzukaj.etykieta_select_wybierz']
 * @property string $t['formularzSzukaj.miesiac.etykieta']
 * @property string $t['formularzSzukaj.pracownik.etykieta']
 * @property string $t['formularzSzukaj.szukaj.wartosc']
 * @property string $t['formularzSzukajOrders.czysc.wartosc']
 * @property string $t['formularzSzukajOrders.date_start_do.etykieta']
 * @property string $t['formularzSzukajOrders.date_start_od.etykieta']
 * @property string $t['formularzSzukajOrders.etykieta_select_wybierz']
 * @property string $t['formularzSzukajOrders.fraza.etykieta']
 * @property string $t['formularzSzukajOrders.miesiac.etykieta']
 * @property string $t['formularzSzukajOrders.status_work.etykieta']
 * @property string $t['formularzSzukajOrders.szukaj.wartosc']
 * @property string $t['holiday.blad_zakresu_dat']
 * @property string $t['holiday.dane_zapisane']
 * @property string $t['holiday.etykieta_data_start']
 * @property string $t['holiday.etykieta_data_stop']
 * @property string $t['holiday.ilosc_dni_wolnych']
 * @property string $t['holiday.nie_mozna_pobrac_uzytkownika']
 * @property string $t['holiday.nie_mozna_zapisac_danych']
 * @property string $t['holiday.przekroczono_ilsc_dni_wolnych_max']
 * @property string $t['holiday.tabela_wakacje_naglowek']
 * @property string $t['holiday.tytul_modulu']
 * @property string $t['holiday.tytul_modulu_informacja']
 * @property string $t['holiday.tytul_strony']
 * @property string $t['holiday.tytul_strony_informacja']
 * @property string $t['holidayDays.tytul_modulu']
 * @property string $t['holidayDays.tytul_strony']
 * @property string $t['index.etykieta_liczba_godzin']
 * @property string $t['index.etykieta_potwierdz_usun']
 * @property string $t['index.etykieta_stawka_godzinowa']
 * @property string $t['index.etykieta_team_name']
 * @property string $t['index.etykieta_zarobil']
 * @property string $t['index.etykieta_zarobil_netto']
 * @property string $t['index.etykieta_zdjecie']
 * @property string $t['index.holiday']
 * @property string $t['index.komunikat_zakres_dat']
 * @property string $t['index.seek_day']
 * @property string $t['index.timelist_etykieta_edytuj']
 * @property string $t['index.tytul_modulu']
 * @property string $t['index.tytul_strony']
 * @property string $t['orders.dodaj_timelist']
 * @property string $t['orders.etykieta_dateAdded']
 * @property string $t['orders.etykieta_ekipa']
 * @property string $t['orders.etykieta_godzin_lacznie']
 * @property string $t['orders.etykieta_orderName']
 * @property string $t['orders.etykieta_pracownicy']
 * @property string $t['orders.etykieta_statusWork']
 * @property string $t['orders.godzin_etykieta']
 * @property string $t['orders.tabela_brak_ekipy']
 * @property string $t['orders.tabela_brak_pracownika']
 * @property string $t['orders.tytul_modulu']
 * @property string $t['orders.tytul_strony']
 * @property string $t['orders.zamowienia_szczegoly']
 * @property string $t['preview.brak_akcji_podgladu']
 * @property string $t['preview.nie_mozna_pobrac_timelist']
 * @property string $t['previewOrder.blad_podgladu_zamowienia']
 * @property string $t['seekDay.ilosc_dni_wolnych']
 * @property string $t['seekDay.tabela_chorobowe_naglowek']
 * @property string $t['seekDay.tytul_modulu']
 * @property string $t['seekDay.tytul_modulu_informacja']
 * @property string $t['seekDay.tytul_strony']
 * @property string $t['seekDay.tytul_strony_informacja']
 * @property string $t['seekday.blad_formularza']
 * @property string $t['seekday.blad_zakres_dat']
 * @property string $t['seekday.dane_zapisane']
 * @property string $t['seekday.nie_mozna_pobrac_uzytkownika']
 * @property string $t['seekday.nie_mozna_zapisac_danych']
 * @property string $t['seekday.pracownik_jest_liderem']
 * @property string $t['seekday.przekroczono_limit_dni_wolnych']
 * @property string $t['suma_etykieta']
 * @property string $t['timelist_holiday_days.etykietaMenu']
 * @property string $t['timelist_index.etykietaMenu']
 * @property string $t['timelist_orders.etykietaMenu']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajDetails']
 * @property string $t['_akcje_etykiety_']['wykonajPreview']
 * @property string $t['_akcje_etykiety_']['wykonajEditTimelist']
 * @property string $t['_akcje_etykiety_']['wykonajSeekDay']
 * @property string $t['_akcje_etykiety_']['wykonajDetailsForWorker']
 * @property string $t['_akcje_etykiety_']['wykonajAddTimelist']
 * @property string $t['_akcje_etykiety_']['wykonajDelete']
 * @property string $t['_akcje_etykiety_']['wykonajHoliday']
 * @property string $t['_akcje_etykiety_']['wykonajOrders']
 * @property string $t['_akcje_etykiety_']['wykonajDetailsOrder']
 * @property string $t['_akcje_etykiety_']['wykonajAddWorker']
 * @property string $t['_akcje_etykiety_']['wykonajDeleteWorker']
 * @property array $t['formularz.status']
 * @property string $t['formularz.status']['red_day']
 * @property string $t['formularz.status']['holiday']
 * @property string $t['formularz.status']['seek_day']
 * @property string $t['formularz.status']['night_hours']
 * @property string $t['formularz.status']['orders']
 * @property array $t['formularzSzukaj.miesiace']
 * @property string $t['formularzSzukaj.miesiace']['01']
 * @property string $t['formularzSzukaj.miesiace']['02']
 * @property string $t['formularzSzukaj.miesiace']['03']
 * @property string $t['formularzSzukaj.miesiace']['04']
 * @property string $t['formularzSzukaj.miesiace']['05']
 * @property string $t['formularzSzukaj.miesiace']['06']
 * @property string $t['formularzSzukaj.miesiace']['07']
 * @property string $t['formularzSzukaj.miesiace']['08']
 * @property string $t['formularzSzukaj.miesiace']['09']
 * @property string $t['formularzSzukaj.miesiace']['10']
 * @property string $t['formularzSzukaj.miesiace']['11']
 * @property string $t['formularzSzukaj.miesiace']['12']
 */
class Admin extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'addtimelist.tytul_modulu' => 'Add timelist',
		'addtimelist.tytul_modulu_zamowienie' => 'Add timelist to : {$zamowienie}',
		'addtimelist.tytul_strony' => 'Add timelist',
		'addtimelist.tytul_strony_zamowienie' => 'Add timelist to : {$zamowienie}',
		'addtimelist.zamowienie_nie_istnieje' => 'Order not exist',
		'addworker.dobierz_pracownika_blad' => 'Unable to select worker to team',
		'addworker.formularz_blad' => 'Not all form fields have been correctly filled in',
		'addworker.formularz_poprawny' => 'The worker was logged into orders and assigned to team',
		'addworker.tytul_modulu' => 'Select worker to the team',
		'addworker.tytul_strony' => 'Select worker to the team',
		'delete.nie_mozna_pobrac_timelist' => 'Unable to read timelist',
		'delete.nie_mozna_usunac_timelist' => 'Unable to delete timelist',
		'delete.timelist_usunieta' => 'Timelist was deleted',
		'deleteworker.formularz_blad' => 'Failed to remove worker from team',
		'deleteworker.formularz_poprawny' => 'The worker has been logged out from order and removed from the team',
		'deleteworker.tytul_modulu' => 'Delete worker from team',
		'deleteworker.tytul_strony' => 'Delete worker from team',
		'deleteworker.usun_pracownika_blad' => 'Failed to remove worker from team',
		'details.chorobowe_link_etykieta' => 'Add sick day',
		'details.chorobowe_naglowek' => 'Sick day',
		'details.delete' => 'Delete',
		'details.edycja_timelist' => 'Edit',
		'details.etykieta_data_start' => 'Date start',
		'details.etykieta_data_stop' => 'Date stop',
		'details.etykieta_dni' => ' day',
		'details.etykieta_dzien' => 'days',
		'details.etykieta_ekipa' => 'Team',
		'details.etykieta_godzin' => ' hours',
		'details.etykieta_godzina' => ' hour',
		'details.etykieta_godziny' => ' h',
		'details.etykieta_hours' => 'Amount of hours',
		'details.etykieta_liczba_godzin' => 'Working hours',
		'details.etykieta_minut' => ' min.',
		'details.etykieta_multiplier' => 'Multiplier',
		'details.etykieta_netto' => ' net',
		'details.etykieta_order_name' => 'Title',
		'details.etykieta_status_work' => 'Status of work',
		'details.etykieta_stawka' => 'Rate',
		'details.etykieta_type' => 'Type',
		'details.etykieta_waluta' => ' nok',
		'details.etykieta_x_multiplier' => 'x ',
		'details.etykieta_zarobil' => 'Brutto amount',
		'details.holiday_link_etykieta' => 'Add holiday',
		'details.naglowek_holiday' => 'Holiday',
		'details.podglad_zamowienia' => 'Preview order',
		'details.podsumowanie_etykieta_netto' => 'Net amount',
		'details.podsumowanie_naglowek' => 'Summary of worked hours',
		'details.podsumownie_etykieta_godziny' => 'Amount of hours',
		'details.podsumownie_etykieta_typ' => 'Type ',
		'details.podsumownie_etykieta_zarobil' => 'Brutto amount',
		'details.podsumownie_rok' => 'Tax year',
		'details.podsumownie_tabela_podatkowa' => 'Tax table',
		'details.pracownik_nie_istnieje' => 'Selected worker does not exist',
		'details.tytul_modulu' => 'Worker information',
		'details.tytul_modulu_pracownik' => 'Worker information : {{$pracownik}}',
		'details.tytul_strony' => 'Worker information',
		'details.tytul_strony_pracownik' => 'Worker information : {{$pracownik}}',
		'details.usun' => 'Delete',
		'details.zamowienia_naglowek' => 'Orders',
		'detailsorder.etykieta_dateAdded' => 'Date added',
		'detailsorder.etykieta_date_start' => 'Date start',
		'detailsorder.etykieta_ekipa' => 'Team',
		'detailsorder.etykieta_godzin_lacznie' => 'Hours',
		'detailsorder.etykieta_pracownik' => 'Worker',
		'detailsorder.etykieta_stawka' => 'Rate',
		'detailsorder.etykieta_stop' => 'Date stop',
		'detailsorder.etykieta_zarobil_brutto' => 'Brutto amount',
		'detailsorder.link_wstecz_etykieta' => 'Back',
		'detailsorder.tytul_modulu' => 'Order details',
		'detailsorder.tytul_modulu_info' => 'Order details : {{$zamowienie}}',
		'detailsorder.tytul_strony' => 'Order details',
		'detailsorder.tytul_strony_info' => 'Order details : {{$zamowienie}}',
		'detailsorder.wybrane_zamowienie_nie_istnieje' => 'Selected order does not exist',
		'editTimelist.nie_mozna_pobrac_timelisty' => 'Selected timelist does not exist',
		'edittimelist.tytul_modulu' => 'Edit timelist',
		'edittimelist.tytul_modulu_informacja' => 'Edit timelist : {{$pracownik}} ({{$zamowienie}})',
		'edittimelist.tytul_strony' => 'Edit timelist',
		'edittimelist.tytul_strony_informacja' => 'Edit timelist : {{$pracownik}} ({{$zamowienie}})',
		'formularz.blad' => 'Not all required fields have been correctly filled in form',
		'formularz.dataStart.etykieta' => 'Date start : ',
		'formularz.dataStart.opis' => 'Date start orders',
		'formularz.dataStop.etykieta' => 'Date stop : ',
		'formularz.dataStop.opis' => 'Date finished orders',
		'formularz.etykieta_select_wybierz' => 'choice',
		'formularz.hours.etykieta' => 'Worked hours : ',
		'formularz.hours.opis' => '',
		'formularz.multiplier.etykieta' => 'Multiplier : ',
		'formularz.multiplier.opis' => '',
		'formularz.poprawne' => 'Data were saved',
		'formularz.select_wybierz' => 'choice',
		'formularz.stawka.etykieta' => 'Rate : ',
		'formularz.stawka.opis' => 'Rate per hours',
		'formularz.type.etykieta' => 'Type : ',
		'formularz.type.opis' => '',
		'formularz.wstecz.wartosc' => 'Cancel',
		'formularz.zapisz.wartosc' => 'Save',
		'formularzAddWorker.pracownik.etykieta' => 'Worker : ',
		'formularzAddWorker.wstecz.wartosc' => 'Cancel',
		'formularzAddWorker.zapisz.wartosc' => 'Save',
		'formularzSeekDay.dataStart.etykieta' => 'Date from : ',
		'formularzSeekDay.dataStart.opis' => '',
		'formularzSeekDay.dataStop.etykieta' => 'Date to : ',
		'formularzSeekDay.dataStop.opis' => '',
		'formularzSeekDay.formularz.region' => 'Add sick day',
		'formularzSeekDay.wstecz.wartosc' => 'Back',
		'formularzSeekDay.zapisz.wartosc' => 'Save',
		'formularzSzukaj.czysc.wartosc' => 'Clear',
		'formularzSzukaj.data_start_do.etykieta' => 'til : ',
		'formularzSzukaj.data_start_od.etykieta' => 'Date from : ',
		'formularzSzukaj.etykieta_select_wybierz' => '-select-',
		'formularzSzukaj.miesiac.etykieta' => 'Select data : ',
		'formularzSzukaj.pracownik.etykieta' => 'Worker : ',
		'formularzSzukaj.szukaj.wartosc' => 'Search',
		'formularzSzukajOrders.czysc.wartosc' => 'Clear',
		'formularzSzukajOrders.date_start_do.etykieta' => 'to : ',
		'formularzSzukajOrders.date_start_od.etykieta' => 'Date from : ',
		'formularzSzukajOrders.etykieta_select_wybierz' => '-select-',
		'formularzSzukajOrders.fraza.etykieta' => 'Phrase : ',
		'formularzSzukajOrders.miesiac.etykieta' => 'Select data : ',
		'formularzSzukajOrders.status_work.etykieta' => 'State : ',
		'formularzSzukajOrders.szukaj.wartosc' => 'Search',
		'holiday.blad_zakresu_dat' => 'Selected date range is invalid',
		'holiday.dane_zapisane' => 'Data were saved',
		'holiday.etykieta_data_start' => 'Date from',
		'holiday.etykieta_data_stop' => 'Date to',
		'holiday.ilosc_dni_wolnych' => 'Amount day of holiday in current year : {{$iloscDniWolnych}}',
		'holiday.nie_mozna_pobrac_uzytkownika' => 'Unable to retrieve worker',
		'holiday.nie_mozna_zapisac_danych' => 'Error writing data',
		'holiday.przekroczono_ilsc_dni_wolnych_max' => 'You have exceeded the maximum number of days',
		'holiday.tabela_wakacje_naglowek' => 'Holiday',
		'holiday.tytul_modulu' => 'Holiday',
		'holiday.tytul_modulu_informacja' => 'Holiday {{$pracownik}}',
		'holiday.tytul_strony' => 'Holiday',
		'holiday.tytul_strony_informacja' => 'Holiday {{$pracownik}}',
		'holidayDays.tytul_modulu' => '[ETYKIETA:holidayDays.tytul_modulu]',	//TODO
		'holidayDays.tytul_strony' => '[ETYKIETA:holidayDays.tytul_strony]',	//TODO
		'index.etykieta_liczba_godzin' => 'Working hours',
		'index.etykieta_potwierdz_usun' => 'Are you sure you want to delete a timelist ?',
		'index.etykieta_stawka_godzinowa' => 'Rate',
		'index.etykieta_team_name' => 'Team',
		'index.etykieta_zarobil' => 'Brutto amount',
		'index.etykieta_zarobil_netto' => 'Net amount',
		'index.etykieta_zdjecie' => 'Worker',
		'index.holiday' => 'Holiday',
		'index.komunikat_zakres_dat' => 'Data from a range of dates from : {{$data_od}} to {{$data_do}}',
		'index.seek_day' => 'Sick day',
		'index.timelist_etykieta_edytuj' => 'Preview',
		'index.tytul_modulu' => 'Timelist',
		'index.tytul_strony' => 'Timelist',
		'orders.dodaj_timelist' => 'Add timelist',
		'orders.etykieta_dateAdded' => 'Date added',
		'orders.etykieta_ekipa' => 'Team',
		'orders.etykieta_godzin_lacznie' => 'Working hours',
		'orders.etykieta_orderName' => 'Orders',
		'orders.etykieta_pracownicy' => 'Workers',
		'orders.etykieta_statusWork' => 'Work status',
		'orders.godzin_etykieta' => ' h',
		'orders.tabela_brak_ekipy' => 'no data',
		'orders.tabela_brak_pracownika' => 'no data',
		'orders.tytul_modulu' => 'Timelist - orders',
		'orders.tytul_strony' => 'Timelist - orders',
		'orders.zamowienia_szczegoly' => 'Details order',
		'preview.brak_akcji_podgladu' => 'There are no actions to preview in the configuration',
		'preview.nie_mozna_pobrac_timelist' => 'A timelist with the given id does not exist in the database',
		'previewOrder.blad_podgladu_zamowienia' => '[ETYKIETA:previewOrder.blad_podgladu_zamowienia]',	//TODO
		'seekDay.ilosc_dni_wolnych' => 'Amount sick day in current year : {{$iloscDniWolnych}}',
		'seekDay.tabela_chorobowe_naglowek' => 'Sick day',
		'seekDay.tytul_modulu' => 'Sick day',
		'seekDay.tytul_modulu_informacja' => 'Sick day {{$pracownik}}',
		'seekDay.tytul_strony' => 'Sick day',
		'seekDay.tytul_strony_informacja' => 'Sick day {{$pracownik}}',
		'seekday.blad_formularza' => 'Not all required fields have been correctly filled in',
		'seekday.blad_zakres_dat' => 'Selected range of dates are incorrect',
		'seekday.dane_zapisane' => 'Data were recorded',
		'seekday.nie_mozna_pobrac_uzytkownika' => 'Unable to retrieve worker',
		'seekday.nie_mozna_zapisac_danych' => 'You can not save data',
		'seekday.pracownik_jest_liderem' => 'Note: The worker which you give day off is the leader of team. <a href="{$link}" alt="edytuj ekipe" target="_blank"> Change leadership team </a>',
		'seekday.przekroczono_limit_dni_wolnych' => 'Exceeded limit sick days',
		'suma_etykieta' => 'Sum : ',
		'timelist_holiday_days.etykietaMenu' => 'Manage holidays',
		'timelist_index.etykietaMenu' => 'List of worker',
		'timelist_orders.etykietaMenu' => 'Orders on timelist',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Timelist of worker',
			'wykonajDetails' => 'Detailed timelist of worker',
			'wykonajPreview' => 'Preview orders',
			'wykonajEditTimelist' => 'Edit timelist',
			'wykonajSeekDay' => 'List of sick day',
			'wykonajDetailsForWorker' => 'Show details timelist for worker',
			'wykonajAddTimelist' => 'Add timelist',
			'wykonajDelete' => 'Delete timelist',
			'wykonajHoliday' => 'List of holiday',
			'wykonajOrders' => 'List of working time orders',
			'wykonajDetailsOrder' => 'Details of working time over orders',
			'wykonajAddWorker' => 'Add worker to perform orders',
			'wykonajDeleteWorker' => 'Delete worker from perform orders',
		),
		'formularz.status' => array(
			'red_day' => 'Red day',
			'holiday' => 'Holiday',
			'seek_day' => 'Sick day',
			'night_hours' => 'Night Hours',
			'orders' => 'Orders',
		),
		'formularzSzukaj.miesiace' => array(
			'01' => 'January',
			'02' => 'February',
			'03' => 'March',
			'04' => 'April',
			'05' => 'May',
			'06' => 'June',
			'07' => 'July',
			'08' => 'August',
			'09' => 'September',
			'10' => 'October',
			'11' => 'November',
			'12' => 'December',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}