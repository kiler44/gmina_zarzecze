<?php
namespace Generic\Tlumaczenie\Pl\Modul\Reports;

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
 * @property string $t['formularzSzukaj.fraza.etykieta']
 * @property string $t['formularzSzukaj.kategoria.etykieta']
 * @property string $t['formularzSzukaj.szukaj.wartosc']
 * @property string $t['formularzSzukaj.wybierz']
 * @property string $t['index.etykietaMenu']
 * @property string $t['index.etykieta_autor']
 * @property string $t['index.etykieta_data_do']
 * @property string $t['index.etykieta_data_dodania']
 * @property string $t['index.etykieta_data_od']
 * @property string $t['index.etykieta_kategoria']
 * @property string $t['index.etykieta_lista_raportow_niestandardowych']
 * @property string $t['index.etykieta_obiekt']
 * @property string $t['index.etykieta_potwierdz_usun']
 * @property string $t['index.etykieta_raportyExcel']
 * @property string $t['index.etykieta_raportyPdf']
 * @property string $t['index.etykieta_wyslany']
 * @property string $t['index.etykieta_wyslij_raport']
 * @property string $t['index.etykieta_zalacznik']
 * @property string $t['index.tabela_etykieta_edytuj']
 * @property string $t['index.tabela_etykieta_podglad']
 * @property string $t['index.tabela_etykieta_revert']
 * @property string $t['index.tabela_etykieta_usun']
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
 * @property string $t['raportyExcel.dni_tygodnia']
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
 */
class Admin extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'delete.blad_nie_mozna_pobrac_obiektu' => 'Nie znaleziono obiektu do usunięcia',
		'delete.obiekt_usuniety' => 'Raport został usunięty',
		'delete.obiekt_usuniety_blad' => 'Nie można usunać obiektu',
		'dodajZarzadzanie.tytul_modulu' => 'Dodaj nowy raport',
		'dodajZarzadzanie.tytul_strony' => 'Dodaj nowy raport',
		'edytujZarzadzanie.blad_nie_mozna_pobrac_raportu' => 'Wybrany raport nie zotsał znaleziony.',
		'edytujZarzadzanie.tytul_modulu' => 'Edit report definition',
		'edytujZarzadzanie.tytul_strony' => 'Edit report definition',
		'formularz.blad_nie_mozna_zapisac' => 'Wystąpił błąd. Raport nie został zapisany.',
		'formularz.cache.etykieta' => 'Okres przechowywania cache dla raportu',
		'formularz.cache.opis' => '',
		'formularz.error_nie_wyczyszono_cache' => 'Wystąpił błąd. Cache nie został wyczyszczony.',
		'formularz.filtry.etykieta' => 'Filtrowane kolumny',
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
		'formularz.nazwa.etykieta' => 'Nazwa raportu',
		'formularz.nazwa.opis' => '',
		'formularz.nazwyPol.etykieta' => 'Etykiety pól w tabeli',
		'formularz.nazwyPol.opis' => 'Podaj etykiety w formacie: nazwa_pola -> etykieta',
		'formularz.opis.etykieta' => 'Opis raportu',
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
		'formularz.zezwolZaawansowany.etykieta' => 'Wyświetlać zaawansowany widok',
		'formularz.zezwolZaawansowany.opis' => '',
		'formularzFiltryPoczatkowe.etykieta.do' => 'do',
		'formularzFiltryPoczatkowe.etykieta.od' => 'od',
		'formularzFiltryPoczatkowe.wstecz.wartosc' => 'Anuluj',
		'formularzFiltryPoczatkowe.wybierz.etykieta' => '- wybierz -',
		'formularzFiltryPoczatkowe.zapisz.wartosc' => 'Ustaw filtry',
		'formularzSzukaj.czysc.wartosc' => 'Czyść',
		'formularzSzukaj.fraza.etykieta' => 'Fraza : ',
		'formularzSzukaj.kategoria.etykieta' => 'Kategoria : ',
		'formularzSzukaj.szukaj.wartosc' => 'Szukaj',
		'formularzSzukaj.wybierz' => 'Wybierz',
		'index.etykietaMenu' => 'Raporty',
		'index.etykieta_autor' => 'Autor',
		'index.etykieta_data_do' => 'Data do',
		'index.etykieta_data_dodania' => 'Data dodania',
		'index.etykieta_data_od' => 'Data od',
		'index.etykieta_kategoria' => 'Kategoria',
		'index.etykieta_lista_raportow_niestandardowych' => 'Villa, B2B, Digging PDF reports',
		'index.etykieta_obiekt' => 'Obiekt',
		'index.etykieta_potwierdz_usun' => 'Czy na pewno chcesz usunąć wybrany wiersz ?',
		'index.etykieta_raportyExcel' => '[ETYKIETA:index.etykieta_raportyExcel]',	//TODO
		'index.etykieta_raportyPdf' => 'Raporty PDF Villa, B2B oraz Digging',
		'index.etykieta_wyslany' => 'Wysłany',
		'index.etykieta_wyslij_raport' => 'Wyślij raport',
		'index.etykieta_zalacznik' => 'Pobierz załącznik',
		'index.tabela_etykieta_edytuj' => 'Edytuj',
		'index.tabela_etykieta_podglad' => 'Podgląd',
		'index.tabela_etykieta_revert' => 'Przywróć z kosza',
		'index.tabela_etykieta_usun' => 'Usuń',
		'index.tytul_modulu' => 'Raporty',
		'index.tytul_strony' => 'Raporty',
		'indexKlient.tytul_modulu' => 'Lista raportów',
		'indexKlient.tytul_strony' => 'Lista raportów',
		'indexZarzadzanie.etykieta_data_dodania' => 'Dodano',
		'indexZarzadzanie.etykieta_edytujZarzadzanie' => 'Edytuj',
		'indexZarzadzanie.etykieta_kasujCache' => 'Kasuj Cache',
		'indexZarzadzanie.etykieta_nazwa' => 'Nazwa',
		'indexZarzadzanie.etykieta_usunZarzadzanie' => 'Usuń',
		'indexZarzadzanie.tytul_modulu' => 'Raporty Edytowalne',
		'indexZarzadzanie.tytul_strony' => 'Raporty Edytowalne',
		'indexZarzadzanie_dodaj.etykietaMenu' => 'Dodaj nowy raport',
		'kasujCacheZarzadzanie.blad' => 'Wystąpil błąd. Spróbuj ponownie.',
		'kasujCacheZarzadzanie.usunieto' => 'Cache raportu został usunięty',
		'listaRaportowKlient.etylieta.podgladKlient' => 'Podgląd raportu',
		'listaRaportowKlient.komunikat.brak_raportow' => 'Żaden raport nie jest dostępny.',
		'podgladKlient.etykieta_doCsv' => 'Pobierz raport',
		'podgladKlient.etykieta_doFiltry' => 'Ustawienia filtrów początkowych',
		'podgladKlient.etykieta_powrot' => 'Powrót',
		'podgladKlient.etykieta_wykres' => 'Widok zaawansowany',
		'podgladKlient.komunikat_error_brak_raportu' => 'Wybrany raport nie istnieje.',
		'podgladKlient.komunikat_error_brak_uprawnien' => 'Brak uprawnień do przeglądania wybranego raportu.',
		'podgladKlient.tytul_modulu' => 'Podglad raportu "%s"',
		'podgladKlient.tytul_strony' => 'Podglad raportu "%s"',
		'raportExcel.komunikat_zapis_dnia' => 'Processing selected day: {DZIEN}, this may take a while. You will be informed when it\'s done.',
		'raportyExcel.dni_tygodnia' => '[ETYKIETA:raportyExcel.dni_tygodnia]',	//TODO
		'raportyExcel.etykieta_avg_kilometer_per_team' => 'Snitt kjøretid i timer pr.bil v/ 2 montører på bil',
		'raportyExcel.etykieta_avg_reel_kjortid_2' => 'Snitt kjøretid i timer pr.bil v/ 2 montører på bil',
		'raportyExcel.etykieta_avg_timepris' => 'Timepris iht innkjøring og timeforbruk u/beregning av OT',
		'raportyExcel.etykieta_bkt_income' => 'Reel innkjøring etter produktkoder',
		'raportyExcel.etykieta_bkt_profit' => 'Resultat u/beregning av OT',
		'raportyExcel.etykieta_bkt_profit_overtime' => 'Resultat m/beregning av OT',
		'raportyExcel.etykieta_brak_danych' => '[ETYKIETA:raportyExcel.etykieta_brak_danych]',	//TODO
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
		'raportyExcel.etykieta_pokaz_ukrytych_pracownikow' => '[ETYKIETA:raportyExcel.etykieta_pokaz_ukrytych_pracownikow]',	//TODO
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
		'raportyExcel.etykieta_usun_pracownika' => 'Usuń pracownika',
		'raportyExcel.etykieta_wypelnione_dni' => 'Days ready for export',
		'raportyExcel.etykieta_zapisz_dzien' => 'Set day "ready"',
		'raportyExcel.filtr_dataDo.etykieta' => 'Date to',
		'raportyExcel.filtr_dataOd.etykieta' => 'Date from',
		'raportyExcel.filtr_szukaj.wartosc' => 'Search',
		'raportyExcel.tytul_modulu' => 'Villa excel report',
		'raportyExcel.tytul_strony' => 'Villa excel report',
		'raportyPdf.etykieta_lista_raportow' => 'Raporty standardowe',
		'raportyPdf.etykieta_potwierdz_usun' => 'Czy na pewno chcesz usunąć wybrany rapoer?',
		'raportyPdf.etykieta_wyslij_raport' => 'Wyślij raport',
		'raportyPdf.etykieta_zalacznik' => 'Pobierz załącznik',
		'raportyPdf.tabela_etykieta_edytuj' => 'Edytuj raport',
		'raportyPdf.tabela_etykieta_podglad' => 'Podgląd raportu',
		'raportyPdf.tabela_etykieta_usun' => 'Usuń raport',
		'raportyPdf.tytul_modulu' => 'Raporty PDF Villa, B2B oraz Digging',
		'raportyPdf.tytul_strony' => 'Raporty PDF Villa, B2B oraz Digging',
		'revert.blad_nie_mozna_pobrac_obiektu' => 'Nie znaleziono raportu',
		'revert.obiekt_przywrocona_z_kosza' => 'Raport został przywrócony z kosza',
		'tabelaKlient.etykieta_nazwa' => 'Nazwa',
		'tabelaKlient.etykieta_opis' => 'Opis raportu',
		'trash.etykietaMenu' => 'Kosz',
		'trash.tytul_modulu' => 'Kosz',
		'trash.tytul_strony' => 'Kosz',
		'usunPracownika.etykieta_blad_zapisu' => '[ETYKIETA:usunPracownika.etykieta_blad_zapisu]',	//TODO
		'usunZarzadzanie.blad' => 'Wystąpil błąd. Spróbuj ponownie.',
		'usunZarzadzanie.usunieto' => 'Wybrany raport został usunięty',
		'wykresKlient.etykieta_filtr_daty' => 'Przedział czasowy',
		'wykresKlient.etykieta_ilosc_wierszy' => 'Ilość wierszy',
		'wykresKlient.etykieta_modyfikuj_wykres' => 'Ustawienia wykresu',
		'wykresKlient.komunikat_error_brak_danych' => 'Brak danych do wyświetlenia.',
		'wykresKlient.komunikat_wartosci_nieprawidlowe' => 'Podane wartości nie są prawidłowe!',
		'wykresKlient.range_etykieta_do' => 'do',
		'wykresKlient.range_etykieta_od' => 'Ustaw zakres od',
		'wykresKlient.range_etykieta_ustaw' => 'Ustaw',
		'wyslijRaport.brak_raportu' => 'Nie znaleziono raportu',
		'wyslijRaport.raport_nie_wyslany' => 'Wysłanie raportu nie powiodło się',
		'wyslijRaport.raport_wyslany' => 'Raport został wysłany',
		'zapiszDzian.bladZapisu' => 'Wystąpił błąd zapisu',
		'zapiszDzien.blad_pobrania_dystansu_trasy' => 'Wystąpił bład pobrania trasy z Google Distance matrix',
		'zapiszDzien.blad_zapisu_danych_raportu' => 'Wystąpił błąd podczas zapisu danych raportu',
		'zapiszDzien.etykieta_blad_zapisu_nadgodziny' => 'Wystąpił błąd zapisu nadgodzin',
		'zapiszNadgodziny.etykieta_blad_zapisu_nadgodziny' => 'Wystąpił błąd zapisu nadgodzin',
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
			'villa instalacje raport faktura' => 'Raport faktura z instalacji Villi',
			'b2b instalacje raport faktura' => 'Raport faktura z instalacji B2B',
			'digging report' => 'Raport faktura z zamówień kopania',
		),
		'objekty_raportow' => array(
			'zamowienie' => 'Zamówienia',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}