<?php
namespace Generic\Tlumaczenie\Pl\Modul\Timelist;

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
 * @property string $t['timelist_type.etykietaMenu']
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
		'addtimelist.tytul_modulu' => 'Dodaj wpis',
		'addtimelist.tytul_modulu_zamowienie' => 'Dodaj wpis do : {$zamowienie}',
		'addtimelist.tytul_strony' => 'Dodaj wpis',
		'addtimelist.tytul_strony_zamowienie' => 'Dodaj wpis do : {$zamowienie}',
		'addtimelist.zamowienie_nie_istnieje' => 'Wybrane zamówienie nie istnieje',
		'addworker.dobierz_pracownika_blad' => 'Nie udało się dobrać pracownika do ekipy',
		'addworker.formularz_blad' => 'Nie wszystkie pola formularza zostały poprawnie wypełnione',
		'addworker.formularz_poprawny' => 'Pracownik został zalogowany do zadania i przypisany do ekipy',
		'addworker.tytul_modulu' => 'Dobierz pracownika do ekipy',
		'addworker.tytul_strony' => 'Dobierz pracownika do ekipy',
		'delete.nie_mozna_pobrac_timelist' => 'Nie można pobrać timelisty',
		'delete.nie_mozna_usunac_timelist' => 'Nie można usunąć timelisty',
		'delete.timelist_usunieta' => 'Wpis został usunięty',
		'deleteworker.formularz_blad' => 'Nie udało się usunąć pracownika z ekipy',
		'deleteworker.formularz_poprawny' => 'Pracownik został wylogowany z zadania i usunięty z ekipy',
		'deleteworker.tytul_modulu' => 'Usuń pracownika z ekipy',
		'deleteworker.tytul_strony' => 'Usuń pracownika z ekipy',
		'deleteworker.usun_pracownika_blad' => 'Nie udało się usunąć pracownika z ekipy',
		'details.chorobowe_link_etykieta' => 'Dodaj chorobowe',
		'details.chorobowe_naglowek' => 'Dnie chorobowe',
		'details.delete' => 'Usuń',
		'details.edycja_timelist' => 'Edycja',
		'details.etykieta_data_start' => 'Data rozpoczęcia',
		'details.etykieta_data_stop' => 'Data zakończenia',
		'details.etykieta_dni' => ' dni',
		'details.etykieta_dzien' => 'dzień/dni',
		'details.etykieta_ekipa' => 'Ekipa',
		'details.etykieta_godzin' => ' godzin',
		'details.etykieta_godzina' => ' godzina',
		'details.etykieta_godziny' => ' godz.',
		'details.etykieta_hours' => 'Ilość godzin',
		'details.etykieta_liczba_godzin' => 'Przepracowane godziny',
		'details.etykieta_minut' => ' min.',
		'details.etykieta_multiplier' => 'Mnożnik',
		'details.etykieta_netto' => ' netto',
		'details.etykieta_order_name' => 'Tytuł',
		'details.etykieta_status_work' => 'Status prac',
		'details.etykieta_stawka' => 'Stawka',
		'details.etykieta_type' => 'Typ',
		'details.etykieta_waluta' => ' nok',
		'details.etykieta_x_multiplier' => 'x ',
		'details.etykieta_zarobil' => 'Kwota brutto',
		'details.holiday_link_etykieta' => 'Dodaj urlop wypoczynkowy',
		'details.naglowek_holiday' => 'Urlop',
		'details.podglad_zamowienia' => 'Podgląd zamówienia',
		'details.podsumowanie_etykieta_netto' => 'Kwota netto',
		'details.podsumowanie_naglowek' => 'Podsumowanie przepracowanych godzin',
		'details.podsumownie_etykieta_godziny' => 'Ilość godzin',
		'details.podsumownie_etykieta_typ' => 'Rodzaj ',
		'details.podsumownie_etykieta_zarobil' => 'Kwota brutto',
		'details.podsumownie_rok' => 'Rok podatkowy',
		'details.podsumownie_tabela_podatkowa' => 'Tabela',
		'details.pracownik_nie_istnieje' => 'Wybrany pracownik nie istnieje',
		'details.tytul_modulu' => 'Karta pracownika',
		'details.tytul_modulu_pracownik' => 'Karta pracownika : {{$pracownik}}',
		'details.tytul_strony' => 'Karta pracownika',
		'details.tytul_strony_pracownik' => 'Karta pracownika : {{$pracownik}}',
		'details.usun' => 'Usuń',
		'details.zamowienia_naglowek' => 'Zamówienia',
		'detailsorder.etykieta_dateAdded' => 'Data dodania',
		'detailsorder.etykieta_date_start' => 'Data start',
		'detailsorder.etykieta_ekipa' => 'Ekipa',
		'detailsorder.etykieta_godzin_lacznie' => 'Godziny',
		'detailsorder.etykieta_pracownik' => 'Pracownik',
		'detailsorder.etykieta_stawka' => 'Stawka',
		'detailsorder.etykieta_stop' => 'Data stop',
		'detailsorder.etykieta_zarobil_brutto' => 'Kwota brutto',
		'detailsorder.link_wstecz_etykieta' => 'Wstecz',
		'detailsorder.tytul_modulu' => 'Szczegóły zamówienia',
		'detailsorder.tytul_modulu_info' => 'Szczegóły zamówienia : {{$zamowienie}}',
		'detailsorder.tytul_strony' => 'Szczegóły zamówienia',
		'detailsorder.tytul_strony_info' => 'Szczegóły zamówienia : {{$zamowienie}}',
		'detailsorder.wybrane_zamowienie_nie_istnieje' => 'Wybrane zamówienie nie istnieje',
		'editTimelist.nie_mozna_pobrac_timelisty' => 'Wiersz timelisty nie istnieje w bazie',
		'edittimelist.tytul_modulu' => 'Edycja czasu pracy',
		'edittimelist.tytul_modulu_informacja' => 'Edycja czasu pracy : {{$pracownik}} ({{$zamowienie}})',
		'edittimelist.tytul_strony' => 'Edycja czasu pracy',
		'edittimelist.tytul_strony_informacja' => 'Edycja czasu pracy : {{$pracownik}} ({{$zamowienie}})',
		'formularz.blad' => 'Nie wszystki wymagane pola formularza zostały poprawnie wypełnione',
		'formularz.dataStart.etykieta' => 'Data rozpoczęcia',
		'formularz.dataStart.opis' => 'Data rozpoczęcia zadania',
		'formularz.dataStop.etykieta' => 'Data zakończenia',
		'formularz.dataStop.opis' => 'Data zakończenia zadania',
		'formularz.etykieta_select_wybierz' => 'wybierz',
		'formularz.hours.etykieta' => 'Godziny przepracowane',
		'formularz.hours.opis' => '',
		'formularz.idTeam.etykieta' => 'Ekipa',
		'formularz.idTeam.opis' => '',
		'formularz.idUser.etykieta' => 'Pracownik',
		'formularz.idUser.opis' => '',
		'formularz.multiplier.etykieta' => 'Mnożnik',
		'formularz.multiplier.opis' => '',
		'formularz.poprawne' => 'Dane zostały zapisane',
		'formularz.select_wybierz' => 'wybierz',
		'formularz.stawka.etykieta' => 'Stawka',
		'formularz.stawka.opis' => 'Stawka godzinowa',
		'formularz.type.etykieta' => 'Typ',
		'formularz.type.opis' => '',
		'formularz.wstecz.wartosc' => 'Anuluj',
		'formularz.zapisz.wartosc' => 'Zapisz',
		'formularzAddWorker.pracownik.etykieta' => 'Pracownik : ',
		'formularzAddWorker.wstecz.wartosc' => 'Anuluj',
		'formularzAddWorker.zapisz.wartosc' => 'Zapisz',
		'formularzSeekDay.dataStart.etykieta' => 'Data od : ',
		'formularzSeekDay.dataStart.opis' => '',
		'formularzSeekDay.dataStop.etykieta' => 'Data do : ',
		'formularzSeekDay.dataStop.opis' => '',
		'formularzSeekDay.formularz.region' => 'Dodaj dni wolne',
		'formularzSeekDay.wstecz.wartosc' => 'Wstecz',
		'formularzSeekDay.zapisz.wartosc' => 'Zapisz',
		'formularzSzukaj.czysc.wartosc' => 'Czyść',
		'formularzSzukaj.data_start_do.etykieta' => 'do : ',
		'formularzSzukaj.data_start_od.etykieta' => 'Data od : ',
		'formularzSzukaj.etykieta_select_wybierz' => '-wybierz-',
		'formularzSzukaj.miesiac.etykieta' => 'Wybierz date : ',
		'formularzSzukaj.pracownik.etykieta' => 'Pracownik : ',
		'formularzSzukaj.szukaj.wartosc' => 'Szukaj',
		'formularzSzukajOrders.czysc.wartosc' => 'Czyść',
		'formularzSzukajOrders.date_start_do.etykieta' => 'do : ',
		'formularzSzukajOrders.date_start_od.etykieta' => 'Data od : ',
		'formularzSzukajOrders.etykieta_select_wybierz' => '-wybierz-',
		'formularzSzukajOrders.fraza.etykieta' => 'Fraza : ',
		'formularzSzukajOrders.miesiac.etykieta' => 'Wybierz datę : ',
		'formularzSzukajOrders.status_work.etykieta' => 'Status',
		'formularzSzukajOrders.szukaj.wartosc' => 'Szukaj',
		'holiday.blad_zakresu_dat' => 'Wybrany zakres dat jest niepoprawny',
		'holiday.dane_zapisane' => 'Dane zostały zapisane',
		'holiday.etykieta_data_start' => 'Data od',
		'holiday.etykieta_data_stop' => 'Data do',
		'holiday.ilosc_dni_wolnych' => 'Wybrane dni wolne w bieżącym roku : {{$iloscDniWolnych}}',
		'holiday.nie_mozna_pobrac_uzytkownika' => 'Nie można pobrać użytkownika',
		'holiday.nie_mozna_zapisac_danych' => 'Błąd podczas zapisu danych',
		'holiday.przekroczono_ilsc_dni_wolnych_max' => 'Przekroczono maksymalną ilość dni wolnych wybranych jednorazowo',
		'holiday.tabela_wakacje_naglowek' => 'Urlop',
		'holiday.tytul_modulu' => 'Urlop',
		'holiday.tytul_modulu_informacja' => 'Urlop {{$pracownik}}',
		'holiday.tytul_strony' => 'Urlop',
		'holiday.tytul_strony_informacja' => 'Urlop {{$pracownik}}',
		'holidayDays.tytul_modulu' => '[ETYKIETA:holidayDays.tytul_modulu]',	//TODO
		'holidayDays.tytul_strony' => '[ETYKIETA:holidayDays.tytul_strony]',	//TODO
		'index.etykieta_liczba_godzin' => 'Przepracowane godziny',
		'index.etykieta_potwierdz_usun' => 'Czy napewno chcesz usunąć wiersz ?',
		'index.etykieta_stawka_godzinowa' => 'Stawka',
		'index.etykieta_team_name' => 'Ekipa',
		'index.etykieta_zarobil' => 'Kwota brutto',
		'index.etykieta_zarobil_netto' => 'Kwota netto',
		'index.etykieta_zdjecie' => 'Pracownik',
		'index.holiday' => 'Urlop',
		'index.komunikat_zakres_dat' => 'Dane z zakresu dat od : {{$data_od}} do {{$data_do}}',
		'index.seek_day' => 'Dni chorobowe',
		'index.timelist_etykieta_edytuj' => 'Podgląd',
		'index.tytul_modulu' => 'Lista czasu pracy',
		'index.tytul_strony' => 'Lista czasu pracy',
		'orders.dodaj_timelist' => 'Dodaj wpis',
		'orders.etykieta_dateAdded' => 'Data dodania',
		'orders.etykieta_ekipa' => 'Ekipa',
		'orders.etykieta_godzin_lacznie' => 'Przepracowane godziny',
		'orders.etykieta_orderName' => 'Zamówienie',
		'orders.etykieta_pracownicy' => 'Pracownicy',
		'orders.etykieta_statusWork' => 'Status prac',
		'orders.godzin_etykieta' => ' godz.',
		'orders.tabela_brak_ekipy' => 'brak',
		'orders.tabela_brak_pracownika' => 'brak',
		'orders.tytul_modulu' => 'Lista czasu pracy - zamówienia',
		'orders.tytul_strony' => 'Lista czasu pracy - zamówienia',
		'orders.zamowienia_szczegoly' => 'Szczegóły zamówienia',
		'preview.brak_akcji_podgladu' => 'Brak akcji podglądu w konfiguracji',
		'preview.nie_mozna_pobrac_timelist' => 'Wiersz o podanym id nie istnieje w bazie',
		'previewOrder.blad_podgladu_zamowienia' => '[ETYKIETA:previewOrder.blad_podgladu_zamowienia]',	//TODO
		'seekDay.ilosc_dni_wolnych' => 'Wybrane dni chorobowe w bieżącym roku : {{$iloscDniWolnych}}',
		'seekDay.tabela_chorobowe_naglowek' => 'Wybrane dni chorobowe',
		'seekDay.tytul_modulu' => 'Dni chorobowe',
		'seekDay.tytul_modulu_informacja' => 'Dni chorobowe {{$pracownik}}',
		'seekDay.tytul_strony' => 'Dni chorobowe',
		'seekDay.tytul_strony_informacja' => 'Dni chorobowe {{$pracownik}}',
		'seekday.blad_formularza' => 'Nie wszystkie wymagane pola zostały poprawnie wypełnione',
		'seekday.blad_zakres_dat' => 'Wybrany zakres dat jest błędny',
		'seekday.dane_zapisane' => 'Dane zostały zapisane',
		'seekday.nie_mozna_pobrac_uzytkownika' => 'Nie można pobrać użytkownika',
		'seekday.nie_mozna_zapisac_danych' => 'Nie można zapisać danych',
		'seekday.pracownik_jest_liderem' => 'Uwaga : pracownik któremu dajesz wolne jest liderem Ekipy. <a href="{$link}" alt="edytuj ekipe" target="_blank"> Zmień lidera ekipy </a>',
		'seekday.przekroczono_limit_dni_wolnych' => 'Przekroczono limit dni chorobowych',
		'suma_etykieta' => 'Suma : ',
		'timelist_holiday_days.etykietaMenu' => 'Zarządzaj wolnymi dniami',
		'timelist_index.etykietaMenu' => 'Lista pracowników',
		'timelist_orders.etykietaMenu' => 'Lista zamówień',
		'timelist_type.etykietaMenu' => 'Konfiguracja typu',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Lista czasu pracy pracowników',
			'wykonajDetails' => 'Szczegółowy czas pracownika',
			'wykonajPreview' => 'Podgląd zamówień',
			'wykonajEditTimelist' => 'Edycja timelisty',
			'wykonajSeekDay' => 'Lista dni chorobowych',
			'wykonajDelete' => 'Usuń timelist',
			'wykonajHoliday' => 'Lista dni wolnych',
			'wykonajDetailsForWorker' => 'Timelist wyświetlana pracownikowi',
			'wykonajAddTimelist' => 'Dodaj wpis do Timelisty',
			'wykonajOrders' => 'Lista czasu pracy zamówień',
			'wykonajDetailsOrder' => 'Szczegóły czasu pracy nad zamówieniem',
			'wykonajAddWorker' => 'Dodaj pracownika do wykonywanego zadania',
			'wykonajDeleteWorker' => 'Usuń pracownika z wykonywanego zadania',
		),
		'formularz.status' => array(
			'red_day' => 'Dni wolne (red day)',
			'holiday' => 'Urlop (holiday)',
			'seek_day' => 'Urlop zdrowotny',
			'night_hours' => 'Prace nocne',
			'orders' => 'Zamówienie',
		),
		'formularzSzukaj.miesiace' => array(
			'01' => 'Styczeń',
			'02' => 'Luty',
			'03' => 'Marzec',
			'04' => 'Kwiecień',
			'05' => 'Maj',
			'06' => 'Czerwiec',
			'07' => 'Lipiec',
			'08' => 'Sierpień',
			'09' => 'Wrzesień',
			'10' => 'Październik',
			'11' => 'Listopad',
			'12' => 'Grudzień',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}