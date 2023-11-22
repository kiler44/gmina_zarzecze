<?php
namespace Generic\Tlumaczenie\En\Modul\Reports;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie 
 * @property string $t['delete.blad_nie_mozna_pobrac_obiektu']
 * @property string $t['delete.obiekt_usuniety']
 * @property string $t['delete.obiekt_usuniety_blad']
 * @property string $t['dodajZarzadzanie.tytul_modulu']
 * @property string $t['dodajZarzadzanie.tytul_strony']
 * @property string $t['edytujZarzadzanie.blad_nie_mozna_pobrac_raportu']
 * @property string $t['edytujZarzadzanie.tytul_modulu']
 * @property string $t['edytujZarzadzanie.tytul_strony']
 * @property string $t['formularz.blad_nie_mozna_zapisac']
 * @property string $t['formularz.cache.etykieta']
 * @property string $t['formularz.cache.opis']
 * @property string $t['formularz.error_nie_wyczyszono_cache']
 * @property string $t['formularz.filtry.etykieta']
 * @property string $t['formularz.filtry.opis']
 * @property string $t['formularz.filtryPoczatkowe.etykieta']
 * @property string $t['formularz.filtryPoczatkowe.opis']
 * @property string $t['formularz.filtryPoczatkoweEtykiety.etykieta']
 * @property string $t['formularz.filtryPoczatkoweEtykiety.opis']
 * @property string $t['formularz.filtryPoczatkoweRegion.region']
 * @property string $t['formularz.filtryPoczatkoweWartosci.etykieta']
 * @property string $t['formularz.filtryPoczatkoweWartosci.opis']
 * @property string $t['formularz.grupa.etykieta']
 * @property string $t['formularz.grupa.opis']
 * @property string $t['formularz.info_wyczyszono_cache']
 * @property string $t['formularz.info_zapisano_dane']
 * @property string $t['formularz.kodSql.etykieta']
 * @property string $t['formularz.kodSql.opis']
 * @property string $t['formularz.kolumnaWykresuDaty.etykieta']
 * @property string $t['formularz.kolumnaWykresuDaty.opis']
 * @property string $t['formularz.kolumnyWykresu.etykieta']
 * @property string $t['formularz.kolumnyWykresu.opis']
 * @property string $t['formularz.nazwa.etykieta']
 * @property string $t['formularz.nazwa.opis']
 * @property string $t['formularz.nazwyPol.etykieta']
 * @property string $t['formularz.nazwyPol.opis']
 * @property string $t['formularz.opis.etykieta']
 * @property string $t['formularz.opis.opis']
 * @property string $t['formularz.subZapytania.etykieta']
 * @property string $t['formularz.subZapytania.opis']
 * @property string $t['formularz.typWykresu.etykieta']
 * @property string $t['formularz.typWykresu.opis']
 * @property string $t['formularz.typWykresuModyfikowalny.etykieta']
 * @property string $t['formularz.typWykresuModyfikowalny.opis']
 * @property string $t['formularz.typyKolumnTabeli.etykieta']
 * @property string $t['formularz.typyKolumnTabeli.opis']
 * @property string $t['formularz.uprawnieniUzytkownicy.etykieta']
 * @property string $t['formularz.uprawnieniUzytkownicy.opis']
 * @property string $t['formularz.widokZaawansowany.region']
 * @property string $t['formularz.wstecz.wartosc']
 * @property string $t['formularz.zapisz.wartosc']
 * @property string $t['formularz.zezwolZaawansowany.etykieta']
 * @property string $t['formularz.zezwolZaawansowany.opis']
 * @property string $t['formularzFiltryPoczatkowe.etykieta.do']
 * @property string $t['formularzFiltryPoczatkowe.etykieta.od']
 * @property string $t['formularzFiltryPoczatkowe.wstecz.wartosc']
 * @property string $t['formularzFiltryPoczatkowe.wybierz.etykieta']
 * @property string $t['formularzFiltryPoczatkowe.zapisz.wartosc']
 * @property string $t['formularzSzukaj.czysc.wartosc']
 * @property string $t['formularzSzukaj.kategoria.etykieta']
 * @property string $t['formularzSzukaj.szukaj.wartosc']
 * @property string $t['formularzSzukaj.wybierz']
 * @property string $t['index.etykietaMenu']
 * @property string $t['index.etykieta_autor']
 * @property string $t['index.etykieta_data_do']
 * @property string $t['index.etykieta_data_dodania']
 * @property string $t['index.etykieta_data_od']
 * @property string $t['index.etykieta_kategoria']
 * @property string $t['index.etykieta_obiekt']
 * @property string $t['index.etykieta_raportyExcel']
 * @property string $t['index.etykieta_raportyPdf']
 * @property string $t['index.etykieta_wyslany']
 * @property string $t['index.raport_zapisany']
 * @property string $t['index.tabela_etykieta_revert']
 * @property string $t['index.tytul_modulu']
 * @property string $t['index.tytul_strony']
 * @property string $t['indexKlient.tytul_modulu']
 * @property string $t['indexKlient.tytul_strony']
 * @property string $t['indexZarzadzanie.etykieta_data_dodania']
 * @property string $t['indexZarzadzanie.etykieta_edytujZarzadzanie']
 * @property string $t['indexZarzadzanie.etykieta_kasujCache']
 * @property string $t['indexZarzadzanie.etykieta_nazwa']
 * @property string $t['indexZarzadzanie.etykieta_usunZarzadzanie']
 * @property string $t['indexZarzadzanie.tytul_modulu']
 * @property string $t['indexZarzadzanie.tytul_strony']
 * @property string $t['indexZarzadzanie_dodaj.etykietaMenu']
 * @property string $t['kasujCacheZarzadzanie.blad']
 * @property string $t['kasujCacheZarzadzanie.usunieto']
 * @property string $t['listaRaportowKlient.etylieta.podgladKlient']
 * @property string $t['listaRaportowKlient.komunikat.brak_raportow']
 * @property string $t['podgladKlient.etykieta_doCsv']
 * @property string $t['podgladKlient.etykieta_doFiltry']
 * @property string $t['podgladKlient.etykieta_powrot']
 * @property string $t['podgladKlient.etykieta_wykres']
 * @property string $t['podgladKlient.komunikat_error_brak_raportu']
 * @property string $t['podgladKlient.komunikat_error_brak_uprawnien']
 * @property string $t['podgladKlient.tytul_modulu']
 * @property string $t['podgladKlient.tytul_strony']
 * @property string $t['raportExcel.komunikat_zapis_dnia']
 * @property string $t['raportyExcel.etykieta_avg_kilometer_per_team']
 * @property string $t['raportyExcel.etykieta_avg_reel_kjortid_2']
 * @property string $t['raportyExcel.etykieta_avg_timepris']
 * @property string $t['raportyExcel.etykieta_bkt_income']
 * @property string $t['raportyExcel.etykieta_bkt_profit']
 * @property string $t['raportyExcel.etykieta_bkt_profit_overtime']
 * @property string $t['raportyExcel.etykieta_brak_danych']
 * @property string $t['raportyExcel.etykieta_daily_reports']
 * @property string $t['raportyExcel.etykieta_diff_oppstart']
 * @property string $t['raportyExcel.etykieta_diff_real_hour_income']
 * @property string $t['raportyExcel.etykieta_do_wypelnienia_dni']
 * @property string $t['raportyExcel.etykieta_domyslne_godziny']
 * @property string $t['raportyExcel.etykieta_domyslne_nadgodziny']
 * @property string $t['raportyExcel.etykieta_domyslne_pauza']
 * @property string $t['raportyExcel.etykieta_download_excel']
 * @property string $t['raportyExcel.etykieta_loses_on_oppstart']
 * @property string $t['raportyExcel.etykieta_not_ready']
 * @property string $t['raportyExcel.etykieta_oppstart_for_1_guy']
 * @property string $t['raportyExcel.etykieta_oppstart_for_team']
 * @property string $t['raportyExcel.etykieta_oppsumering_kjoring']
 * @property string $t['raportyExcel.etykieta_oppsumering_timer']
 * @property string $t['raportyExcel.etykieta_pokaz_ukrytych_pracownikow']
 * @property string $t['raportyExcel.etykieta_reel_kilometer_total']
 * @property string $t['raportyExcel.etykieta_reel_kjortid_1']
 * @property string $t['raportyExcel.etykieta_reel_kjortid_2']
 * @property string $t['raportyExcel.etykieta_sum_godziny']
 * @property string $t['raportyExcel.etykieta_sum_nadgodziny']
 * @property string $t['raportyExcel.etykieta_sum_oversendt']
 * @property string $t['raportyExcel.etykieta_sum_overtime_costs']
 * @property string $t['raportyExcel.etykieta_sum_pauzy']
 * @property string $t['raportyExcel.etykieta_sum_regular_costs']
 * @property string $t['raportyExcel.etykieta_sum_total']
 * @property string $t['raportyExcel.etykieta_suma']
 * @property string $t['raportyExcel.etykieta_usun_pracownika']
 * @property string $t['raportyExcel.etykieta_wypelnione_dni']
 * @property string $t['raportyExcel.etykieta_zapisz_dzien']
 * @property string $t['raportyExcel.filtr_dataDo.etykieta']
 * @property string $t['raportyExcel.filtr_dataOd.etykieta']
 * @property string $t['raportyExcel.filtr_szukaj.wartosc']
 * @property string $t['raportyExcel.tytul_modulu']
 * @property string $t['raportyExcel.tytul_strony']
 * @property string $t['raportyPdf.etykieta_lista_raportow']
 * @property string $t['raportyPdf.etykieta_potwierdz_usun']
 * @property string $t['raportyPdf.etykieta_wyslij_raport']
 * @property string $t['raportyPdf.etykieta_zalacznik']
 * @property string $t['raportyPdf.tabela_etykieta_edytuj']
 * @property string $t['raportyPdf.tabela_etykieta_podglad']
 * @property string $t['raportyPdf.tabela_etykieta_usun']
 * @property string $t['raportyPdf.tytul_modulu']
 * @property string $t['raportyPdf.tytul_strony']
 * @property string $t['revert.blad_nie_mozna_pobrac_obiektu']
 * @property string $t['revert.obiekt_przywrocona_z_kosza']
 * @property string $t['tabelaKlient.etykieta_nazwa']
 * @property string $t['tabelaKlient.etykieta_opis']
 * @property string $t['trash.etykietaMenu']
 * @property string $t['trash.tytul_modulu']
 * @property string $t['trash.tytul_strony']
 * @property string $t['usunPracownika.etykieta_blad_zapisu']
 * @property string $t['usunZarzadzanie.blad']
 * @property string $t['usunZarzadzanie.usunieto']
 * @property string $t['wykresKlient.etykieta_filtr_daty']
 * @property string $t['wykresKlient.etykieta_ilosc_wierszy']
 * @property string $t['wykresKlient.etykieta_modyfikuj_wykres']
 * @property string $t['wykresKlient.komunikat_error_brak_danych']
 * @property string $t['wykresKlient.komunikat_wartosci_nieprawidlowe']
 * @property string $t['wykresKlient.range_etykieta_do']
 * @property string $t['wykresKlient.range_etykieta_od']
 * @property string $t['wykresKlient.range_etykieta_ustaw']
 * @property string $t['wyslijRaport.brak_raportu']
 * @property string $t['wyslijRaport.raport_nie_wyslany']
 * @property string $t['wyslijRaport.raport_wyslany']
 * @property string $t['zapiszDzian.bladZapisu']
 * @property string $t['zapiszDzien.blad_pobrania_dystansu_trasy']
 * @property string $t['zapiszDzien.blad_zapisu_danych_raportu']
 * @property string $t['zapiszDzien.etykieta_blad_zapisu_nadgodziny']
 * @property string $t['zapiszNadgodziny.etykieta_blad_zapisu_nadgodziny']
 * @property string $t['zarzadzanie_raportami.etykietaMenu']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajListaRaportow']
 * @property string $t['_akcje_etykiety_']['wykonajPodglad']
 * @property string $t['_akcje_etykiety_']['wykonajDoCsv']
 * @property string $t['_akcje_etykiety_']['wykonajWykres']
 * @property string $t['_akcje_etykiety_']['wszystkieRaporty']
 * @property string $t['_akcje_etykiety_']['wykonajFiltryPoczatkowe']
 * @property array $t['_zdarzenia_etykiety_']
 * @property array $t['kategorie_raportow']
 * @property string $t['kategorie_raportow']['villa instalacje raport faktura']
 * @property string $t['kategorie_raportow']['b2b instalacje raport faktura']
 * @property string $t['kategorie_raportow']['digging report']
 * @property array $t['objekty_raportow']
 * @property string $t['objekty_raportow']['zamowienie']
 * @property array $t['raportyExcel.dni_tygodnia']
 * @property string $t['raportyExcel.dni_tygodnia']['1']
 * @property string $t['raportyExcel.dni_tygodnia']['2']
 * @property string $t['raportyExcel.dni_tygodnia']['3']
 * @property string $t['raportyExcel.dni_tygodnia']['4']
 * @property string $t['raportyExcel.dni_tygodnia']['5']
 * @property string $t['raportyExcel.dni_tygodnia']['6']
 * @property string $t['raportyExcel.dni_tygodnia']['7']
 */
class Admin extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'delete.blad_nie_mozna_pobrac_obiektu' => 'Report not found',
		'delete.obiekt_usuniety' => 'The report has been deleted',
		'delete.obiekt_usuniety_blad' => 'You can\'t delete this report',
		'dodajZarzadzanie.tytul_modulu' => 'Define new report',
		'dodajZarzadzanie.tytul_strony' => 'Define new report',
		'edytujZarzadzanie.blad_nie_mozna_pobrac_raportu' => 'Selected report was not found.',
		'edytujZarzadzanie.tytul_modulu' => 'Edit report definition',
		'edytujZarzadzanie.tytul_strony' => 'Edit report definition',
		'formularz.blad_nie_mozna_zapisac' => 'Error has occured. Report was not saved.',
		'formularz.cache.etykieta' => 'Cache period',
		'formularz.cache.opis' => '',
		'formularz.error_nie_wyczyszono_cache' => 'Error has occured. Cache was not cleared.',
		'formularz.filtry.etykieta' => 'Filtered columns',
		'formularz.filtry.opis' => 'Podaj je w formacie: nazwa_kolumny -> nazwa_filtru, gdzie dopuszczalne filtry to date, range, select, text. Filtr date może być użyty tylko raz.',
		'formularz.filtryPoczatkowe.etykieta' => 'Filtry początkowe',
		'formularz.filtryPoczatkowe.opis' => 'Jeśli zostaną dodane, to przed wyświetleniem raportu zostanie pokazany formularz filtrów, który pozwoli zawężyć zakres danych.<br /> Każdy ze zdefiniowanych filtrów może zostać użyty w kodzie SQL poprzez wpisanie "{FILTR_nazwa_filtra}". <br />Dopuszczalne typy filtrów: date, date_range, select, checkbox, text.<br />Podajemy w formacie: nazwa_pola -> typ',
		'formularz.filtryPoczatkoweEtykiety.etykieta' => 'Etykiety pól filtrów początkowych',
		'formularz.filtryPoczatkoweEtykiety.opis' => 'Definujemy na zasadzie nazwa_pola => Tytuł',
		'formularz.filtryPoczatkoweRegion.region' => 'Filtry początkowe',
		'formularz.filtryPoczatkoweWartosci.etykieta' => 'Wartości dla filtrów początkowych',
		'formularz.filtryPoczatkoweWartosci.opis' => 'Dla filtrów select można pobrać listę wartości dla filtru.<br />Wartości podajemy jako nazwa_filtra -> SQL.<br /> Kod SQL powinien zwracać 2 wartości: wartosc i etykieta. Dla pozostalych filtrów można zdefiniować tutaj wartości początkowe podane jako zwykły tekst (Dla filtra date_range rozdzielamy wartości &quot;|&quot;).',
		'formularz.grupa.etykieta' => 'Grupa',
		'formularz.grupa.opis' => 'Grupa, do której jest przypisany raport.',
		'formularz.info_wyczyszono_cache' => 'Wyczyszczono cache.',
		'formularz.info_zapisano_dane' => 'Raport został zapisany.',
		'formularz.kodSql.etykieta' => 'Kod SQL odpowiedzialny za pobranie danych',
		'formularz.kodSql.opis' => 'Musi zawierać zmienną {FILTRY}, która wstawi odpowiednie parametry podczas pobierania raportu.',
		'formularz.kolumnaWykresuDaty.etykieta' => 'Kolumna dla wykresu filtra daty',
		'formularz.kolumnaWykresuDaty.opis' => 'Podaj nazwę (nie etykietę) kolumny, która ma być użyta w wykresie filtra daty.',
		'formularz.kolumnyWykresu.etykieta' => 'Kolumny wykresu',
		'formularz.kolumnyWykresu.opis' => 'Podaj nazwy kolumn do wykresu.<br /><strong>Pierwsza kolumna jest kluczem.</strong>',
		'formularz.nazwa.etykieta' => 'Report name',
		'formularz.nazwa.opis' => '',
		'formularz.nazwyPol.etykieta' => 'Etykiety pól w tabeli',
		'formularz.nazwyPol.opis' => 'Podaj etykiety w formacie: nazwa_pola -> etykieta',
		'formularz.opis.etykieta' => 'Report description',
		'formularz.opis.opis' => 'Możesz podać osobne opisy dla listy, formularza filtrów startowych oraz podglądu raportu. Rozdziel je znacznikiem {PODZIAL}.',
		'formularz.subZapytania.etykieta' => 'Podzapytania wykonywane przed głównym SQL',
		'formularz.subZapytania.opis' => 'Należy podać w następującym formacie: IDENTYFIKATOR -> Zapytanie SQL. Do skryptu zostaną wstawione wartości zwrócone przez subzapytanie w miejscu wstawienia IDENTYFIKATORA.',
		'formularz.typWykresu.etykieta' => 'Typ wykresu',
		'formularz.typWykresu.opis' => '',
		'formularz.typWykresuModyfikowalny.etykieta' => 'Pozwól modyfikować typ wykresu.',
		'formularz.typWykresuModyfikowalny.opis' => 'Dla niektórych zestawów danych modyfikacja domyślnego typu wykresu może powodować błędy.',
		'formularz.typyKolumnTabeli.etykieta' => 'Typy kolumn tabeli',
		'formularz.typyKolumnTabeli.opis' => 'Podaj typy kolumn dla widoku tabeli. Musisz zdefiniować wszystkie kolumny ustawione w polu Etykiety pól w tabeli. Dopuszczalne typy: string, number, boolean, date.<br />Dla filtra date należy ustawić typ date.',
		'formularz.uprawnieniUzytkownicy.etykieta' => 'Użytkownicy uprawnieni',
		'formularz.uprawnieniUzytkownicy.opis' => 'Uzytkownicy, którzy będą mogli przeglądać raport.',
		'formularz.widokZaawansowany.region' => 'Opcje widoku zaawansowanego',
		'formularz.wstecz.wartosc' => 'Wstecz',
		'formularz.zapisz.wartosc' => 'Zapisz',
		'formularz.zezwolZaawansowany.etykieta' => 'Switch to advanced view',
		'formularz.zezwolZaawansowany.opis' => '',
		'formularzFiltryPoczatkowe.etykieta.do' => 'to',
		'formularzFiltryPoczatkowe.etykieta.od' => 'from',
		'formularzFiltryPoczatkowe.wstecz.wartosc' => 'Cancel',
		'formularzFiltryPoczatkowe.wybierz.etykieta' => '- select -',
		'formularzFiltryPoczatkowe.zapisz.wartosc' => 'Choose filter',
		'formularzSzukaj.czysc.wartosc' => 'Clear',
		'formularzSzukaj.kategoria.etykieta' => 'Category : ',
		'formularzSzukaj.szukaj.wartosc' => 'Search',
		'formularzSzukaj.wybierz' => 'Select',
		'index.etykietaMenu' => 'Reports',
		'index.etykieta_autor' => 'Author',
		'index.etykieta_data_do' => 'Date to',
		'index.etykieta_data_dodania' => 'Date added',
		'index.etykieta_data_od' => 'Date from',
		'index.etykieta_kategoria' => 'Category',
		'index.etykieta_obiekt' => 'Object',
		'index.etykieta_raportyExcel' => 'Villa excel report',
		'index.etykieta_raportyPdf' => 'Villa, B2B, Digging PDF reports',
		'index.etykieta_wyslany' => 'Sent',
		'index.raport_zapisany' => 'Report has been saved',
		'index.tabela_etykieta_revert' => 'Revert from trash',
		'index.tytul_modulu' => 'Reports',
		'index.tytul_strony' => 'Reports',
		'indexKlient.tytul_modulu' => 'List of reports',
		'indexKlient.tytul_strony' => 'List of reports',
		'indexZarzadzanie.etykieta_data_dodania' => 'Date added',
		'indexZarzadzanie.etykieta_edytujZarzadzanie' => 'Edit',
		'indexZarzadzanie.etykieta_kasujCache' => 'Delete Cache',
		'indexZarzadzanie.etykieta_nazwa' => 'Name',
		'indexZarzadzanie.etykieta_usunZarzadzanie' => 'Remove',
		'indexZarzadzanie.tytul_modulu' => 'Editable reporta',
		'indexZarzadzanie.tytul_strony' => 'Editable reports',
		'indexZarzadzanie_dodaj.etykietaMenu' => 'Add new report',
		'kasujCacheZarzadzanie.blad' => 'Error has occured. Try again later.',
		'kasujCacheZarzadzanie.usunieto' => 'Report cache was cleared',
		'listaRaportowKlient.etylieta.podgladKlient' => 'Preview',
		'listaRaportowKlient.komunikat.brak_raportow' => 'You have no reports available at the moment.',
		'podgladKlient.etykieta_doCsv' => 'Download report',
		'podgladKlient.etykieta_doFiltry' => 'Back to filters',
		'podgladKlient.etykieta_powrot' => 'Back',
		'podgladKlient.etykieta_wykres' => 'Advanced view',
		'podgladKlient.komunikat_error_brak_raportu' => 'Selected report does not exists.',
		'podgladKlient.komunikat_error_brak_uprawnien' => 'You have no rights to see that report.',
		'podgladKlient.tytul_modulu' => 'Report preview "%s"',
		'podgladKlient.tytul_strony' => 'Report preview "%s"',
		'raportExcel.komunikat_zapis_dnia' => 'Processing selected day: {DZIEN}, this may take a while. You will be informed when it\'s done.',
		'raportyExcel.etykieta_avg_kilometer_per_team' => 'Snitt kjøretid i timer pr.bil v/ 2 montører på bil',
		'raportyExcel.etykieta_avg_reel_kjortid_2' => 'Snitt kjøretid i timer pr.bil v/ 2 montører på bil',
		'raportyExcel.etykieta_avg_timepris' => 'Timepris iht innkjøring og timeforbruk u/beregning av OT',
		'raportyExcel.etykieta_bkt_income' => 'Reel innkjøring etter produktkoder',
		'raportyExcel.etykieta_bkt_profit' => 'Resultat u/beregning av OT',
		'raportyExcel.etykieta_bkt_profit_overtime' => 'Resultat m/beregning av OT',
		'raportyExcel.etykieta_brak_danych' => 'No driving data for date: ',
		'raportyExcel.etykieta_daily_reports' => 'Daily Villa reports',
		'raportyExcel.etykieta_diff_oppstart' => 'Diff. avsatt tid på ordre i timer vs reel kjøretidtid 2 stk montører',
		'raportyExcel.etykieta_diff_real_hour_income' => 'Differanse pr. time pr. montør iht fast timepris kr 581,-',
		'raportyExcel.etykieta_do_wypelnienia_dni' => 'Days that still need your attention',
		'raportyExcel.etykieta_domyslne_godziny' => 'Worked hours',
		'raportyExcel.etykieta_domyslne_nadgodziny' => 'Overtime',
		'raportyExcel.etykieta_domyslne_pauza' => 'Pause',
		'raportyExcel.etykieta_download_excel' => 'Download excel report',
		'raportyExcel.etykieta_loses_on_oppstart' => 'Manglende avsatt tid på ordre, beregnet med timepris kr 581,-',
		'raportyExcel.etykieta_not_ready' => 'Download with defaults',
		'raportyExcel.etykieta_oppstart_for_1_guy' => 'Avsatt tid på ordre v/ 2 montører på bil',
		'raportyExcel.etykieta_oppstart_for_team' => 'Avsatt tid på ordre v/ 1 montør på bil',
		'raportyExcel.etykieta_oppsumering_kjoring' => 'Oppsummering kjøring',
		'raportyExcel.etykieta_oppsumering_timer' => 'Oppsummering timer',
		'raportyExcel.etykieta_pokaz_ukrytych_pracownikow' => 'Show/hide removed employees',
		'raportyExcel.etykieta_reel_kilometer_total' => 'Reel kilometer totalt (google map)',
		'raportyExcel.etykieta_reel_kjortid_1' => 'Reel kjørtid totalt i timer v/ 1 montør på bil (google map)',
		'raportyExcel.etykieta_reel_kjortid_2' => 'Reel kjørtid totalt i timer v/ 2 montører på bil (google map)',
		'raportyExcel.etykieta_sum_godziny' => 'Sum timer ordinær arbeid',
		'raportyExcel.etykieta_sum_nadgodziny' => 'Sum timer overtid',
		'raportyExcel.etykieta_sum_oversendt' => 'Sum timer oversendt av Get u/kanselering',
		'raportyExcel.etykieta_sum_overtime_costs' => 'Forventet omsetning m/ beregning av OT (OTxkr581x1,4)',
		'raportyExcel.etykieta_sum_pauzy' => 'Sum timer betalt matpause',
		'raportyExcel.etykieta_sum_regular_costs' => 'Forventet omsetning u/ beregning av OT (timerxkr581)',
		'raportyExcel.etykieta_sum_total' => 'Sum timer totalt',
		'raportyExcel.etykieta_suma' => 'Sum:',
		'raportyExcel.etykieta_usun_pracownika' => 'Remove user',
		'raportyExcel.etykieta_wypelnione_dni' => 'Days ready for export',
		'raportyExcel.etykieta_zapisz_dzien' => 'Set day "ready"',
		'raportyExcel.filtr_dataDo.etykieta' => 'Date to',
		'raportyExcel.filtr_dataOd.etykieta' => 'Date from',
		'raportyExcel.filtr_szukaj.wartosc' => 'Search',
		'raportyExcel.tytul_modulu' => 'Villa excel report',
		'raportyExcel.tytul_strony' => 'Villa excel report',
		'raportyPdf.etykieta_lista_raportow' => 'Standard reports',
		'raportyPdf.etykieta_potwierdz_usun' => 'Are you sure you want to delete this report ?',
		'raportyPdf.etykieta_wyslij_raport' => 'Send report',
		'raportyPdf.etykieta_zalacznik' => 'Download attachment',
		'raportyPdf.tabela_etykieta_edytuj' => 'Edit',
		'raportyPdf.tabela_etykieta_podglad' => 'Preview',
		'raportyPdf.tabela_etykieta_usun' => 'Delete',
		'raportyPdf.tytul_modulu' => 'Reports',
		'raportyPdf.tytul_strony' => 'Reports',
		'revert.blad_nie_mozna_pobrac_obiektu' => 'Report not found',
		'revert.obiekt_przywrocona_z_kosza' => 'The report was revert from the trash',
		'tabelaKlient.etykieta_nazwa' => 'Name',
		'tabelaKlient.etykieta_opis' => 'Report description',
		'trash.etykietaMenu' => 'Trash',
		'trash.tytul_modulu' => 'Trash',
		'trash.tytul_strony' => 'Trash',
		'usunPracownika.etykieta_blad_zapisu' => 'Selected employee couldn\'t be removed from employes list',
		'usunZarzadzanie.blad' => 'error has occured. Try again later.',
		'usunZarzadzanie.usunieto' => 'Selected report was deleted',
		'wykresKlient.etykieta_filtr_daty' => 'Date range',
		'wykresKlient.etykieta_ilosc_wierszy' => 'Results',
		'wykresKlient.etykieta_modyfikuj_wykres' => 'Chart settings',
		'wykresKlient.komunikat_error_brak_danych' => 'No data to display at this moment.',
		'wykresKlient.komunikat_wartosci_nieprawidlowe' => 'Entered values are invalid!',
		'wykresKlient.range_etykieta_do' => 'to',
		'wykresKlient.range_etykieta_od' => 'Set range from',
		'wykresKlient.range_etykieta_ustaw' => 'set',
		'wyslijRaport.brak_raportu' => 'There are no reports',
		'wyslijRaport.raport_nie_wyslany' => 'Failed sending the report',
		'wyslijRaport.raport_wyslany' => 'The report was sent',
		'zapiszDzian.bladZapisu' => 'Saving the selected day failed.',
		'zapiszDzien.blad_pobrania_dystansu_trasy' => 'The problem has occured while gathering the route from Google Distance Matrix service',
		'zapiszDzien.blad_zapisu_danych_raportu' => 'The data for report couldn\'t be saved',
		'zapiszDzien.etykieta_blad_zapisu_nadgodziny' => 'Worked and overtime hours couldn\'t be saved',
		'zapiszNadgodziny.etykieta_blad_zapisu_nadgodziny' => 'Worked and overtime hours couldn\'t be saved',
		'zarzadzanie_raportami.etykietaMenu' => 'Reports management',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Wyswietlanie modułu',
			'wykonajListaRaportow' => 'Lista raportów',
			'wykonajPodglad' => 'Podglad raportu',
			'wykonajDoCsv' => 'Generowanie pliku CSV z raportem',
			'wykonajWykres' => 'Generowanie wykresu',
			'wszystkieRaporty' => 'Dostęp do wszystkich raportów',
			'wykonajFiltryPoczatkowe' => 'Wyświetlanie filtrów początkowych',
		),
		'_zdarzenia_etykiety_' => array(
		),
		'kategorie_raportow' => array(
			'villa instalacje raport faktura' => 'Report faktura from Villa installations',
			'b2b instalacje raport faktura' => 'Report faktura from B2B installations',
			'digging report' => 'Report faktura from GET Digging orders',
		),
		'objekty_raportow' => array(
			'zamowienie' => 'Orders',
		),
		'raportyExcel.dni_tygodnia' => array(
			'1' => 'Monday',
			'2' => 'Tuesday',
			'3' => 'Wednesday',
			'4' => 'Thursday',
			'5' => 'Friday',
			'6' => 'Saturday',
			'7' => 'Sunday',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}