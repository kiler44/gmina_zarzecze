<?php
namespace Generic\Tlumaczenie\No\Modul\Timelist;

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
 * @property string $t['formularz.idTeam.etykieta']
 * @property string $t['formularz.idTeam.opis']
 * @property string $t['formularz.idUser.etykieta']
 * @property string $t['formularz.idUser.opis']
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
 * @property string $t['_akcje_etykiety_']['wykonajDelete']
 * @property string $t['_akcje_etykiety_']['wykonajHoliday']
 * @property string $t['_akcje_etykiety_']['wykonajDetailsForWorker']
 * @property string $t['_akcje_etykiety_']['wykonajAddTimelist']
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
		'addtimelist.tytul_modulu' => 'Legge timelist',
		'addtimelist.tytul_modulu_zamowienie' => 'Legge timelist : {$zamowienie}',
		'addtimelist.tytul_strony' => 'Legge timelist',
		'addtimelist.tytul_strony_zamowienie' => 'Legge timelist : {$zamowienie}',
		'addtimelist.zamowienie_nie_istnieje' => 'Bestill eksisterer ikke',
		'addworker.dobierz_pracownika_blad' => 'Kan ikke velge arbeidstaker å slå',
		'addworker.formularz_blad' => 'Ikke alle skjemafeltene er korrekt utfylt',
		'addworker.formularz_poprawny' => 'Arbeideren ble logget inn ordrer og tildeles til lag',
		'addworker.tytul_modulu' => 'Velg arbeidstaker til teamet',
		'addworker.tytul_strony' => 'Velg arbeidstaker til teamet',
		'delete.nie_mozna_pobrac_timelist' => 'Kan ikke lese tidsliste',
		'delete.nie_mozna_usunac_timelist' => 'Kan ikke slette tidsliste',
		'delete.timelist_usunieta' => 'Tid Liste ble slettet',
		'deleteworker.formularz_blad' => 'Klarte å fjerne arbeidstaker fra teamet',
		'deleteworker.formularz_poprawny' => 'Arbeideren har blitt logget ut fra bestilling og fjernet fra teamet',
		'deleteworker.tytul_modulu' => 'Slett arbeidstaker fra teamet',
		'deleteworker.tytul_strony' => 'Slett arbeidstaker fra teamet',
		'deleteworker.usun_pracownika_blad' => 'Klarte å fjerne arbeidstaker fra teamet',
		'details.chorobowe_link_etykieta' => 'Legg søke dagen',
		'details.chorobowe_naglowek' => 'Søke dagen',
		'details.delete' => 'Fjern',
		'details.edycja_timelist' => 'Edition',
		'details.etykieta_data_start' => 'Dato start',
		'details.etykieta_data_stop' => 'Dato stopp',
		'details.etykieta_dni' => ' dager',
		'details.etykieta_dzien' => 'dager',
		'details.etykieta_ekipa' => 'Teamet',
		'details.etykieta_godzin' => ' timer',
		'details.etykieta_godzina' => ' tid',
		'details.etykieta_godziny' => ' t',
		'details.etykieta_hours' => 'Mengde timer',
		'details.etykieta_liczba_godzin' => 'Arbeidstid',
		'details.etykieta_minut' => ' min.',
		'details.etykieta_multiplier' => 'Multiplier',
		'details.etykieta_netto' => ' net',
		'details.etykieta_order_name' => 'Tittel',
		'details.etykieta_status_work' => 'Status for arbeidet',
		'details.etykieta_stawka' => 'Rate',
		'details.etykieta_type' => 'Type',
		'details.etykieta_waluta' => ' nok',
		'details.etykieta_x_multiplier' => 'x ',
		'details.etykieta_zarobil' => 'Bruttobeløp',
		'details.holiday_link_etykieta' => 'Legg ferie',
		'details.naglowek_holiday' => 'Ferie',
		'details.podglad_zamowienia' => 'Forhåndsvisning bestillinger',
		'details.podsumowanie_etykieta_netto' => 'Nettobeløpet',
		'details.podsumowanie_naglowek' => 'Oppsummering av arbeidstimer',
		'details.podsumownie_etykieta_godziny' => 'Mengde timer',
		'details.podsumownie_etykieta_typ' => 'Type ',
		'details.podsumownie_etykieta_zarobil' => 'Bruttobeløp',
		'details.podsumownie_rok' => 'Skatte år',
		'details.podsumownie_tabela_podatkowa' => 'Skatte Tabell',
		'details.pracownik_nie_istnieje' => 'Valgt arbeidstaker ikke eksisterer',
		'details.tytul_modulu' => 'Worker informasjon',
		'details.tytul_modulu_pracownik' => 'Worker informasjon : {{$pracownik}}',
		'details.tytul_strony' => 'Worker informasjon',
		'details.tytul_strony_pracownik' => 'Worker informasjon : {{$pracownik}}',
		'details.usun' => 'Slett',
		'details.zamowienia_naglowek' => 'Pålegg',
		'detailsorder.etykieta_dateAdded' => 'Dato lagt',
		'detailsorder.etykieta_date_start' => 'Dato start',
		'detailsorder.etykieta_ekipa' => 'Teamet',
		'detailsorder.etykieta_godzin_lacznie' => 'Timer',
		'detailsorder.etykieta_pracownik' => 'Worker',
		'detailsorder.etykieta_stawka' => 'Rate',
		'detailsorder.etykieta_stop' => 'Dato stopp ',
		'detailsorder.etykieta_zarobil_brutto' => 'Bruttobeløp',
		'detailsorder.link_wstecz_etykieta' => 'Tilbake',
		'detailsorder.tytul_modulu' => 'Bestill detaljer',
		'detailsorder.tytul_modulu_info' => 'Bestill detaljer : {{$zamowienie}}',
		'detailsorder.tytul_strony' => 'Bestill detaljer',
		'detailsorder.tytul_strony_info' => 'Bestill detaljer : {{$zamowienie}}',
		'detailsorder.wybrane_zamowienie_nie_istnieje' => 'Valgt rekkefølge eksisterer ikke',
		'editTimelist.nie_mozna_pobrac_timelisty' => 'Valgt tidsliste eksisterer ikke',
		'edittimelist.tytul_modulu' => 'Edit tidsliste',
		'edittimelist.tytul_modulu_informacja' => 'Edit tidsliste : {{$pracownik}} ({{$zamowienie}})',
		'edittimelist.tytul_strony' => 'Edit tidsliste',
		'edittimelist.tytul_strony_informacja' => 'Edit tidsliste : {{$pracownik}} ({{$zamowienie}})',
		'formularz.blad' => 'Ikke alle obligatoriske felt er korrekt utfylt skjema',
		'formularz.dataStart.etykieta' => 'Dato start : ',
		'formularz.dataStart.opis' => 'Dato stop',
		'formularz.dataStop.etykieta' => 'Dato ferdig : ',
		'formularz.dataStop.opis' => 'Dato ferdig bestillinger',
		'formularz.etykieta_select_wybierz' => 'valg',
		'formularz.hours.etykieta' => 'Arbeidstimer : ',
		'formularz.hours.opis' => '',
		'formularz.idTeam.etykieta' => 'Teamet : ',
		'formularz.idTeam.opis' => '',
		'formularz.idUser.etykieta' => 'Medarbeider : ',
		'formularz.idUser.opis' => '',
		'formularz.multiplier.etykieta' => 'Multiplier : ',
		'formularz.multiplier.opis' => '',
		'formularz.poprawne' => 'Data ble lagret',
		'formularz.select_wybierz' => '- velg -',
		'formularz.stawka.etykieta' => 'Rate',
		'formularz.stawka.opis' => 'Sats per time',
		'formularz.type.etykieta' => 'Type : ',
		'formularz.type.opis' => '',
		'formularz.wstecz.wartosc' => 'Avbryt',
		'formularz.zapisz.wartosc' => 'Lagre',
		'formularzAddWorker.pracownik.etykieta' => 'Arbeider : ',
		'formularzAddWorker.wstecz.wartosc' => 'Avbryt',
		'formularzAddWorker.zapisz.wartosc' => 'Lagre',
		'formularzSeekDay.dataStart.etykieta' => 'Dato fra : ',
		'formularzSeekDay.dataStart.opis' => '',
		'formularzSeekDay.dataStop.etykieta' => 'Dato til : ',
		'formularzSeekDay.dataStop.opis' => '',
		'formularzSeekDay.formularz.region' => 'Legg søke dagen',
		'formularzSeekDay.wstecz.wartosc' => 'Tilbake',
		'formularzSeekDay.zapisz.wartosc' => 'Lagre',
		'formularzSzukaj.czysc.wartosc' => 'Clear',
		'formularzSzukaj.data_start_do.etykieta' => 'til : ',
		'formularzSzukaj.data_start_od.etykieta' => 'Dato fra  : ',
		'formularzSzukaj.etykieta_select_wybierz' => '-velg-',
		'formularzSzukaj.miesiac.etykieta' => 'Velg dato : ',
		'formularzSzukaj.pracownik.etykieta' => 'Medarbeider : ',
		'formularzSzukaj.szukaj.wartosc' => 'Søk',
		'formularzSzukajOrders.czysc.wartosc' => 'Clear',
		'formularzSzukajOrders.date_start_do.etykieta' => 'til : ',
		'formularzSzukajOrders.date_start_od.etykieta' => 'Dato fra : ',
		'formularzSzukajOrders.etykieta_select_wybierz' => '-velg-',
		'formularzSzukajOrders.fraza.etykieta' => 'Søkefrase : ',
		'formularzSzukajOrders.miesiac.etykieta' => 'Velg dato : ',
		'formularzSzukajOrders.status_work.etykieta' => 'Status : ',
		'formularzSzukajOrders.szukaj.wartosc' => 'Søk',
		'holiday.blad_zakresu_dat' => 'Valgte datoområdet er ugyldig',
		'holiday.dane_zapisane' => 'Data ble lagret',
		'holiday.etykieta_data_start' => 'Dato fra',
		'holiday.etykieta_data_stop' => 'Dato til',
		'holiday.ilosc_dni_wolnych' => 'Beløp dag ferie i inneværende år : {{$iloscDniWolnych}}',
		'holiday.nie_mozna_pobrac_uzytkownika' => 'Kan ikke hente arbeidstaker',
		'holiday.nie_mozna_zapisac_danych' => 'Feil ved skriving av data',
		'holiday.przekroczono_ilsc_dni_wolnych_max' => 'Du har overskredet det maksimale antall dager',
		'holiday.tabela_wakacje_naglowek' => 'Ferie',
		'holiday.tytul_modulu' => 'Ferie',
		'holiday.tytul_modulu_informacja' => 'Ferie {{$pracownik}}',
		'holiday.tytul_strony' => 'Ferie',
		'holiday.tytul_strony_informacja' => 'Ferie {{$pracownik}}',
		'holidayDays.tytul_modulu' => '[ETYKIETA:holidayDays.tytul_modulu]',	//TODO
		'holidayDays.tytul_strony' => '[ETYKIETA:holidayDays.tytul_strony]',	//TODO
		'index.etykieta_liczba_godzin' => 'Arbeidstid',
		'index.etykieta_potwierdz_usun' => 'Er du sikker på at du vil slette en timelist?',
		'index.etykieta_stawka_godzinowa' => 'Rate',
		'index.etykieta_team_name' => 'Teamet',
		'index.etykieta_zarobil' => 'Brutto beløp',
		'index.etykieta_zarobil_netto' => 'Net beløp',
		'index.etykieta_zdjecie' => 'Medarbeider',
		'index.holiday' => 'Ferie',
		'index.komunikat_zakres_dat' => 'Data fra en rekke datoer fra : {{$data_od}} til {{$data_do}}',
		'index.seek_day' => 'Oppsøk dag',
		'index.timelist_etykieta_edytuj' => 'Forhåndsvisning',
		'index.tytul_modulu' => 'Timelist',
		'index.tytul_strony' => 'Timelist',
		'orders.dodaj_timelist' => 'Legge timelist',
		'orders.etykieta_dateAdded' => 'Dato lagt',
		'orders.etykieta_ekipa' => 'Teamet',
		'orders.etykieta_godzin_lacznie' => 'Arbeidstid',
		'orders.etykieta_orderName' => 'Pålegg',
		'orders.etykieta_pracownicy' => 'Arbeidere',
		'orders.etykieta_statusWork' => 'Arbeid status',
		'orders.godzin_etykieta' => ' t',
		'orders.tabela_brak_ekipy' => 'ingen data',
		'orders.tabela_brak_pracownika' => 'ingen data',
		'orders.tytul_modulu' => 'Timelist - bestillinger',
		'orders.tytul_strony' => 'Timelist - bestillinger',
		'orders.zamowienia_szczegoly' => 'Detaljer bestillinger',
		'preview.brak_akcji_podgladu' => 'Det er ingen handlinger å forhåndsvise i konfigurasjonen',
		'preview.nie_mozna_pobrac_timelist' => 'En timelist med den gitte id ikke finnes i databasen',
		'previewOrder.blad_podgladu_zamowienia' => '[ETYKIETA:previewOrder.blad_podgladu_zamowienia]',	//TODO
		'seekDay.ilosc_dni_wolnych' => 'Beløp søke dag i inneværende år : {{$iloscDniWolnych}}',
		'seekDay.tabela_chorobowe_naglowek' => 'Oppsøk dag',
		'seekDay.tytul_modulu' => 'Oppsøk dag',
		'seekDay.tytul_modulu_informacja' => 'Oppsøk dag {{$pracownik}}',
		'seekDay.tytul_strony' => 'Oppsøk dag',
		'seekDay.tytul_strony_informacja' => 'Oppsøk dag {{$pracownik}}',
		'seekday.blad_formularza' => 'Ikke alle obligatoriske felt er korrekt utfylt',
		'seekday.blad_zakres_dat' => 'Valgt område av datoer er feil',
		'seekday.dane_zapisane' => 'Data ble registrert',
		'seekday.nie_mozna_pobrac_uzytkownika' => 'Kan ikke hente arbeidstaker',
		'seekday.nie_mozna_zapisac_danych' => 'Du kan ikke lagre data',
		'seekday.pracownik_jest_liderem' => 'Merk: Arbeideren som du gir fridag er leder av teamet. <a href="{$link}" alt="edytuj ekipe" target="_blank"> Endre lederteamet </a>',
		'seekday.przekroczono_limit_dni_wolnych' => 'Skredet grenseverdiene sykedager',
		'suma_etykieta' => 'Sum : ',
		'timelist_holiday_days.etykietaMenu' => 'Manage holidays',
		'timelist_index.etykietaMenu' => 'Liste over arbeideren',
		'timelist_orders.etykietaMenu' => 'Liste over bestillinger',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Timelist av arbeidstaker',
			'wykonajDetails' => 'Detaljert tid av arbeidstaker',
			'wykonajPreview' => 'Forhåndsvisning bestillinger',
			'wykonajEditTimelist' => 'Edit tidsliste',
			'wykonajSeekDay' => 'Liste over søke dagen',
			'wykonajDelete' => 'Slett timelist',
			'wykonajHoliday' => 'Ferie timelist',
			'wykonajDetailsForWorker' => 'Detaljer timelist for arbeidstaker',
			'wykonajAddTimelist' => 'Legg til en oppføring i Timelisty',
			'wykonajOrders' => 'Liste over arbeidstids bestillinger',
			'wykonajDetailsOrder' => 'Detaljer om arbeidstiden i løpet bestillinger',
			'wykonajAddWorker' => 'Legg arbeidstaker å utføre ordre',
			'wykonajDeleteWorker' => 'Slett arbeidstaker å utføre ordre',
		),
		'formularz.status' => array(
			'red_day' => 'Red day',
			'holiday' => 'Holiday',
			'seek_day' => 'Seek day',
			'night_hours' => 'Night Hours',
			'orders' => 'Orders',
		),
		'formularzSzukaj.miesiace' => array(
			'01' => 'Januar',
			'02' => 'Februar',
			'03' => 'Mars',
			'04' => 'April',
			'05' => 'Mai',
			'06' => 'Juni',
			'07' => 'Juli',
			'08' => 'August',
			'09' => 'September',
			'10' => 'Oktober',
			'11' => 'November',
			'12' => 'Desember',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}