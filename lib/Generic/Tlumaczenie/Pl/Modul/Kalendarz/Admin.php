<?php
namespace Generic\Tlumaczenie\Pl\Modul\Kalendarz;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie 
 * @property string $t['dodajGrupe.blad_zapisu']
 * @property string $t['dodajGrupe.grupa_istnieje']
 * @property string $t['dodajNotatke.blad_kolor']
 * @property string $t['dodajNotatke.blad_nazwa_wyswietlana']
 * @property string $t['dodajNotatke.notatka_nie_wypelniona']
 * @property string $t['dodajProjekt.bladKolor']
 * @property string $t['dodajProjekt.bladNazwaWyswietlana']
 * @property string $t['dodajProjekt.bladZamowienia']
 * @property string $t['dodajTeamDoListy.blad_zapisu']
 * @property string $t['dodajTeamDoListy.team_nie_istnieje']
 * @property string $t['dodajUzytownikaDoEkipy.uzytkownik_nie_istnieje']
 * @property string $t['dodajWydarzenie.lista_wydarzen_pusta']
 * @property string $t['edycjaTeamu.date_from_etykieta']
 * @property string $t['edycjaTeamu.date_to_etykieta']
 * @property string $t['edycjaTeamu.edcyja_teamu_etykieta']
 * @property string $t['edycjaTeamu.potwierdz_usun_pracownika']
 * @property string $t['edycjaTeamu.set_as_leader_etykieta']
 * @property string $t['edycjaTeamu.set_day_off_etykieta']
 * @property string $t['index.anuluj_etykieta']
 * @property string $t['index.bg_etykieta']
 * @property string $t['index.clear_etykieta']
 * @property string $t['index.date_etykieta']
 * @property string $t['index.date_from_etykieta']
 * @property string $t['index.date_range_etykieta']
 * @property string $t['index.date_to_etykieta']
 * @property string $t['index.edcyja_teamu_etykieta']
 * @property string $t['index.filter_etykieta']
 * @property string $t['index.get_more_etykieta']
 * @property string $t['index.menu_add_comment']
 * @property string $t['index.menu_clear_select']
 * @property string $t['index.menu_clone_event']
 * @property string $t['index.menu_edit_comment']
 * @property string $t['index.menu_move_event']
 * @property string $t['index.menu_remove_comment']
 * @property string $t['index.menu_remove_selected_event']
 * @property string $t['index.menu_select_similar_event']
 * @property string $t['index.menu_show_comment']
 * @property string $t['index.menu_show_day_details']
 * @property string $t['index.menu_show_note']
 * @property string $t['index.menu_show_order_details']
 * @property string $t['index.menu_ustaw_lidera']
 * @property string $t['index.menu_usun_z_grupy']
 * @property string $t['index.menu_wykonaj_event']
 * @property string $t['index.menu_zaznacz_pracownika']
 * @property string $t['index.nieZaznaczonoDatyKomunikat']
 * @property string $t['index.number_of_teams_etykieta']
 * @property string $t['index.potwierdzUsunPrzypisanie']
 * @property string $t['index.pusta_lista_wyszukiwania']
 * @property string $t['index.run_current_events_etykieta']
 * @property string $t['index.search_etykieta']
 * @property string $t['index.team_filter_etykieta']
 * @property string $t['index.txt_etykieta']
 * @property string $t['index.typ_eventu_etykieta']
 * @property string $t['index.tytul_modulu']
 * @property string $t['index.tytul_strony']
 * @property string $t['index.zapisz_etykieta']
 * @property string $t['konfiguracja.data_start_etykieta']
 * @property string $t['konfiguracja.data_stop_etykieta']
 * @property string $t['konfiguracja.data_suwak_start_etykieta']
 * @property string $t['konfiguracja.data_suwak_stop_etykieta']
 * @property string $t['konfiguracja.domyslna_grupa_etykieta']
 * @property string $t['konfiguracja.etykieta_konfiguruj_team']
 * @property string $t['konfiguracja.etykieta_select_grupa']
 * @property string $t['konfiguracja.potwierdz_usun_grupe']
 * @property string $t['konfiguracja.wybierzDomyslnaGrupeEtykieta']
 * @property string $t['menuPodreczne.brak_metod_dla_menu']
 * @property string $t['menu_add_event']
 * @property string $t['parsujTeamNaglowek.niezalogowany']
 * @property string $t['parsujTeamNaglowek.zalogowany']
 * @property string $t['pobierzTeamy.brak_grupy_w_konfiguracji']
 * @property string $t['przeniesEvent.blad_zapisu_danych']
 * @property string $t['przeniesEvent.event_nie_istnieje']
 * @property string $t['sortujTeamWidok.listaTeamowUsunietychNaglowek']
 * @property string $t['sortujTeamWidok.listaTwoichTeamowNaglowek']
 * @property string $t['uruchomEvent.blad_uruchamiania']
 * @property string $t['ustawLidera.blad_zapisu']
 * @property string $t['ustawLidera.team_nie_istnieje']
 * @property string $t['usunGrupe.blad_zapisu']
 * @property string $t['usunGrupe.grupa_nie_istnieje']
 * @property string $t['usunGrupe.usuwasz_grupe_domyslna_komunikat']
 * @property string $t['usunPracownikaZEkipy.blad_podczas_wylogowanie_pracownika']
 * @property string $t['usunPracownikaZEkipy.pracownik_zalogowany']
 * @property string $t['usunPracownikaZEkipy.team_nie_istnieje']
 * @property string $t['usunPracownikaZEkipy.uzytkownik_nie_istnieje']
 * @property string $t['usunPrzypisanie.blad_usuwania']
 * @property string $t['usunPrzypomnienie.bladZapisu']
 * @property string $t['usunTeamZListy.blad_zapisu']
 * @property string $t['usunTeamZListy.grupa_nie_istnieje']
 * @property string $t['zapiszKalendarz']
 * @property string $t['zapiszKalendarz.pola_data_team_nie_zaznaczone']
 * @property string $t['zapiszKomentarz.bladZapisu']
 * @property string $t['zapiszNotatka.blad_zapisu_danych']
 * @property string $t['zapiszNotatka.nie_wybrano_dat']
 * @property string $t['zapiszNotatka.notatka_pusta']
 * @property string $t['zapiszNotatka.zamowienie_nie_istnieje']
 * @property string $t['zapiszProjekt.blad_zapisu_danych']
 * @property string $t['zapiszProjekt.nie_wybrano_dat']
 * @property string $t['zapiszProjekt.zamowienie_nie_istnieje']
 * @property string $t['zapiszSortowanie.blad_zapisu']
 * @property string $t['zapiszSortowanieTeamu.blad_zapisu']
 * @property string $t['zapiszWydarzenie.komunikat_uruchom_event']
 * @property string $t['zmianyWTeamie.nowy_team_nie_istnieje']
 * @property string $t['zmianyWTeamie.potwierdz_wyloguj_pracownika_z_zadania']
 * @property string $t['zmianyWTeamie.potwierdz_wyloguj_team_z_zadania']
 * @property string $t['zmianyWTeamie.stary_team_nie_istnieje']
 * @property string $t['zmianyWTeamie.uzytkownik_nie_istnieje']
 * @property string $t['zmianyWTeamie.uzytkownik_zostanie_zalogowany_do_zadnia']
 * @property string $t['zmianyWTeamie.uzytkownik_zostanie_zalogowany_do_zadnia_wylogowanie']
 * @property string $t['zmienKolor.blad_zapisu']
 * @property array $t['dodajProjekt.przypomnienie_opcje_dni']
 * @property string $t['dodajProjekt.przypomnienie_opcje_dni']['0']
 * @property string $t['dodajProjekt.przypomnienie_opcje_dni']['1']
 * @property string $t['dodajProjekt.przypomnienie_opcje_dni']['2']
 * @property string $t['dodajProjekt.przypomnienie_opcje_dni']['5']
 * @property string $t['dodajProjekt.przypomnienie_opcje_dni']['7']
 * @property array $t['konfiguracja.zakres_dat']
 * @property string $t['konfiguracja.zakres_dat']['-|0|day']
 * @property string $t['konfiguracja.zakres_dat']['-|7|day']
 * @property string $t['konfiguracja.zakres_dat']['-|1|month']
 * @property string $t['konfiguracja.zakres_dat']['-|2|month']
 * @property string $t['konfiguracja.zakres_dat']['-|3|month']
 * @property string $t['konfiguracja.zakres_dat']['+|7|day']
 * @property string $t['konfiguracja.zakres_dat']['+|1|month']
 * @property string $t['konfiguracja.zakres_dat']['+|2|month']
 * @property string $t['konfiguracja.zakres_dat']['+|3|month']
 */
class Admin extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'dodajGrupe.blad_zapisu' => 'Błąd zapisu danych',
		'dodajGrupe.grupa_istnieje' => 'Taka grupa już istnieje',
		'dodajNotatke.blad_kolor' => '[ETYKIETA:dodajNotatke.blad_kolor]',	//TODO
		'dodajNotatke.blad_nazwa_wyswietlana' => '[ETYKIETA:dodajNotatke.blad_nazwa_wyswietlana]',	//TODO
		'dodajNotatke.notatka_nie_wypelniona' => '[ETYKIETA:dodajNotatke.notatka_nie_wypelniona]',	//TODO
		'dodajProjekt.bladKolor' => '[ETYKIETA:dodajProjekt.bladKolor]',	//TODO
		'dodajProjekt.bladNazwaWyswietlana' => '[ETYKIETA:dodajProjekt.bladNazwaWyswietlana]',	//TODO
		'dodajProjekt.bladZamowienia' => '[ETYKIETA:dodajProjekt.bladZamowienia]',	//TODO
		'dodajTeamDoListy.blad_zapisu' => 'Wystąpiły błądy podczas zapisu danych',
		'dodajTeamDoListy.team_nie_istnieje' => 'Wybrany Team nie isnieje',
		'dodajUzytownikaDoEkipy.uzytkownik_nie_istnieje' => 'Nie znaleziono wybranego pracownika',
		'dodajWydarzenie.lista_wydarzen_pusta' => 'Lista dostepnych wydażeń jest pusta, lub nie posiadasz uprawnień do żadnego wydażenia',
		'edycjaTeamu.date_from_etykieta' => 'Data od: ',
		'edycjaTeamu.date_to_etykieta' => 'Data do:',
		'edycjaTeamu.edcyja_teamu_etykieta' => 'Edytujesz team {TEAM_NAZWA}',
		'edycjaTeamu.potwierdz_usun_pracownika' => 'Czy napwno chcesz usunąć tego pracownika z Teamu ?',
		'edycjaTeamu.set_as_leader_etykieta' => 'Ustaw jako lider',
		'edycjaTeamu.set_day_off_etykieta' => 'Ustaw dni wolne',
		'index.anuluj_etykieta' => 'Anuluj',
		'index.bg_etykieta' => 'Bg',
		'index.clear_etykieta' => 'Czyść',
		'index.date_etykieta' => 'Data',
		'index.date_from_etykieta' => 'Data od',
		'index.date_range_etykieta' => 'Zakres dat : ',
		'index.date_to_etykieta' => 'Data do',
		'index.edcyja_teamu_etykieta' => 'Edytuj team',
		'index.filter_etykieta' => 'Filtruj',
		'index.get_more_etykieta' => 'Pokaż więcej dat',
		'index.menu_add_comment' => 'Dodaj komentarz',
		'index.menu_clear_select' => 'Czyść zaznaczenie',
		'index.menu_clone_event' => 'Powiel wydarzenie',
		'index.menu_edit_comment' => 'Edytuj komentarz',
		'index.menu_move_event' => 'Przenieś wydarzenie',
		'index.menu_remove_comment' => 'Usuń komentarz',
		'index.menu_remove_selected_event' => 'Usuń zaznaczone wydarzenia',
		'index.menu_select_similar_event' => 'Zaznacz podobne wydarzenia',
		'index.menu_show_comment' => 'Podgląd komenarza',
		'index.menu_show_day_details' => 'Pokaż szczegóły dni',
		'index.menu_show_note' => 'Podgląd notatki',
		'index.menu_show_order_details' => 'Podgląd zamówienia',
		'index.menu_ustaw_lidera' => '[ETYKIETA:index.menu_ustaw_lidera]',	//TODO
		'index.menu_usun_z_grupy' => '[ETYKIETA:index.menu_usun_z_grupy]',	//TODO
		'index.menu_wykonaj_event' => '[ETYKIETA:index.menu_wykonaj_event]',	//TODO
		'index.menu_zaznacz_pracownika' => '[ETYKIETA:index.menu_zaznacz_pracownika]',	//TODO
		'index.nieZaznaczonoDatyKomunikat' => 'Proszę najpierw zaznaczyć datę w kalendarzu.',
		'index.number_of_teams_etykieta' => 'Ilość teamów',
		'index.potwierdzUsunPrzypisanie' => 'Czy napewno chcesz usunać wydarzenie?',
		'index.pusta_lista_wyszukiwania' => 'Brak wyników wyszukiwania',
		'index.run_current_events_etykieta' => 'Uruchom bieżące wydarzenia',
		'index.search_etykieta' => 'Szukaj : ',
		'index.team_filter_etykieta' => 'Filtr ekip',
		'index.txt_etykieta' => 'Txt',
		'index.typ_eventu_etykieta' => 'Typ : ',
		'index.tytul_modulu' => 'Kalendarz',
		'index.tytul_strony' => 'Kalendarz',
		'index.zapisz_etykieta' => 'Zapisz',
		'konfiguracja.data_start_etykieta' => 'Początkowa data generowania kalendarza',
		'konfiguracja.data_stop_etykieta' => 'Końcowa data wygenerowania kalendarza',
		'konfiguracja.data_suwak_start_etykieta' => 'Data wyświetlania start',
		'konfiguracja.data_suwak_stop_etykieta' => 'Data wyświetlnia stop',
		'konfiguracja.domyslna_grupa_etykieta' => 'Wybierz domyślną grupę',
		'konfiguracja.etykieta_konfiguruj_team' => 'Konfiguruj ekipy',
		'konfiguracja.etykieta_select_grupa' => 'Wybierz grupę do edycji',
		'konfiguracja.potwierdz_usun_grupe' => 'Czy na pewno chce usunać wybraną grupę ?',
		'konfiguracja.wybierzDomyslnaGrupeEtykieta' => 'Wybierz domyślną grupę',
		'menuPodreczne.brak_metod_dla_menu' => '[ETYKIETA:menuPodreczne.brak_metod_dla_menu]',	//TODO
		'menu_add_event' => 'Dodaj wydarzenie',
		'parsujTeamNaglowek.niezalogowany' => '[ETYKIETA:parsujTeamNaglowek.niezalogowany]',	//TODO
		'parsujTeamNaglowek.zalogowany' => '[ETYKIETA:parsujTeamNaglowek.zalogowany]',	//TODO
		'pobierzTeamy.brak_grupy_w_konfiguracji' => 'Wybrana grupa nie istnieje',
		'przeniesEvent.blad_zapisu_danych' => 'Nie udało się przenieść wydarzenia',
		'przeniesEvent.event_nie_istnieje' => 'Wydarzenie nie istnieje',
		'sortujTeamWidok.listaTeamowUsunietychNaglowek' => '[ETYKIETA:sortujTeamWidok.listaTeamowUsunietychNaglowek]',	//TODO
		'sortujTeamWidok.listaTwoichTeamowNaglowek' => '[ETYKIETA:sortujTeamWidok.listaTwoichTeamowNaglowek]',	//TODO
		'uruchomEvent.blad_uruchamiania' => '[ETYKIETA:uruchomEvent.blad_uruchamiania]',	//TODO
		'ustawLidera.blad_zapisu' => 'Błąd zapisu danych',
		'ustawLidera.team_nie_istnieje' => 'Ekipa nie istnieje',
		'usunGrupe.blad_zapisu' => 'Nie udało się usunac grupy',
		'usunGrupe.grupa_nie_istnieje' => 'Grupa nie istnieje',
		'usunGrupe.usuwasz_grupe_domyslna_komunikat' => 'Usuwasz grupę ustawioną jako domyślną, ustaw nową grupę domyślną.',
		'usunPracownikaZEkipy.blad_podczas_wylogowanie_pracownika' => 'Wystąpiły błędy podczas próby wylogowania pracownika',
		'usunPracownikaZEkipy.pracownik_zalogowany' => 'Ten pracownik jest zalogowany do innego zadania czy na pewno chcesz przenieść tego pracownika ?',
		'usunPracownikaZEkipy.team_nie_istnieje' => 'Wybrany team nie isnieje',
		'usunPracownikaZEkipy.uzytkownik_nie_istnieje' => 'Wybrany pracownik nie został znaleziony w bazie',
		'usunPrzypisanie.blad_usuwania' => 'Wystąpiły błędy podczas usuwania pracownika',
		'usunPrzypomnienie.bladZapisu' => '[ETYKIETA:usunPrzypomnienie.bladZapisu]',	//TODO
		'usunTeamZListy.blad_zapisu' => 'Nie udało się usunąć temu z listy',
		'usunTeamZListy.grupa_nie_istnieje' => '[ETYKIETA:usunTeamZListy.grupa_nie_istnieje]',	//TODO
		'zapiszKalendarz' => '[ETYKIETA:zapiszKalendarz]',	//TODO
		'zapiszKalendarz.pola_data_team_nie_zaznaczone' => '[ETYKIETA:zapiszKalendarz.pola_data_team_nie_zaznaczone]',	//TODO
		'zapiszKomentarz.bladZapisu' => 'Wystąpiły błędy podczas zapisu komentarza.',
		'zapiszNotatka.blad_zapisu_danych' => '[ETYKIETA:zapiszNotatka.blad_zapisu_danych]',	//TODO
		'zapiszNotatka.nie_wybrano_dat' => '[ETYKIETA:zapiszNotatka.nie_wybrano_dat]',	//TODO
		'zapiszNotatka.notatka_pusta' => '[ETYKIETA:zapiszNotatka.notatka_pusta]',	//TODO
		'zapiszNotatka.zamowienie_nie_istnieje' => '[ETYKIETA:zapiszNotatka.zamowienie_nie_istnieje]',	//TODO
		'zapiszProjekt.blad_zapisu_danych' => '[ETYKIETA:zapiszProjekt.blad_zapisu_danych]',	//TODO
		'zapiszProjekt.nie_wybrano_dat' => '[ETYKIETA:zapiszProjekt.nie_wybrano_dat]',	//TODO
		'zapiszProjekt.zamowienie_nie_istnieje' => '[ETYKIETA:zapiszProjekt.zamowienie_nie_istnieje]',	//TODO
		'zapiszSortowanie.blad_zapisu' => 'Wystąpiły błedy podczas zmiany kolejności ekip',
		'zapiszSortowanieTeamu.blad_zapisu' => '[ETYKIETA:zapiszSortowanieTeamu.blad_zapisu]',	//TODO
		'zapiszWydarzenie.komunikat_uruchom_event' => '[ETYKIETA:zapiszWydarzenie.komunikat_uruchom_event]',	//TODO
		'zmianyWTeamie.nowy_team_nie_istnieje' => '[ETYKIETA:zmianyWTeamie.nowy_team_nie_istnieje]',	//TODO
		'zmianyWTeamie.potwierdz_wyloguj_pracownika_z_zadania' => '[ETYKIETA:zmianyWTeamie.potwierdz_wyloguj_pracownika_z_zadania]',	//TODO
		'zmianyWTeamie.potwierdz_wyloguj_team_z_zadania' => '[ETYKIETA:zmianyWTeamie.potwierdz_wyloguj_team_z_zadania]',	//TODO
		'zmianyWTeamie.stary_team_nie_istnieje' => '[ETYKIETA:zmianyWTeamie.stary_team_nie_istnieje]',	//TODO
		'zmianyWTeamie.uzytkownik_nie_istnieje' => '[ETYKIETA:zmianyWTeamie.uzytkownik_nie_istnieje]',	//TODO
		'zmianyWTeamie.uzytkownik_zostanie_zalogowany_do_zadnia' => '[ETYKIETA:zmianyWTeamie.uzytkownik_zostanie_zalogowany_do_zadnia]',	//TODO
		'zmianyWTeamie.uzytkownik_zostanie_zalogowany_do_zadnia_wylogowanie' => '[ETYKIETA:zmianyWTeamie.uzytkownik_zostanie_zalogowany_do_zadnia_wylogowanie]',	//TODO
		'zmienKolor.blad_zapisu' => 'Zmiana koloru nie powiodła się.',

		'dodajProjekt.przypomnienie_opcje_dni' => array(
			'0' => 'event day',
			'1' => '1 day',
			'2' => '2 day',
			'5' => '5 day',
			'7' => '7 day',
		),
		'konfiguracja.zakres_dat' => array(
			'-|0|day' => 'nowdays',
			'-|7|day' => '- 7 day',
			'-|1|month' => '- 1 month',
			'-|2|month' => '- 2 month',
			'-|3|month' => '- 3 month',
			'+|7|day' => '+ 7 day',
			'+|1|month' => '+ 1 month',
			'+|2|month' => '+ 2 month',
			'+|3|month' => '+ 3 month',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}