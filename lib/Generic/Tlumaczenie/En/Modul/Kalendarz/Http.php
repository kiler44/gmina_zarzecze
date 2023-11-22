<?php
namespace Generic\Tlumaczenie\En\Modul\Kalendarz;

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
 * @property string $t['edycjaTeamu.potwierdz_usun_pracownika']
 * @property string $t['index.nieZaznaczonoDatyKomunikat']
 * @property string $t['index.potwierdzUsunPrzypisanie']
 * @property string $t['index.tytul_modulu']
 * @property string $t['index.tytul_strony']
 * @property string $t['konfiguracja.data_start_etykieta']
 * @property string $t['konfiguracja.data_stop_etykieta']
 * @property string $t['konfiguracja.data_suwak_start_etykieta']
 * @property string $t['konfiguracja.data_suwak_stop_etykieta']
 * @property string $t['konfiguracja.domyslna_grupa_etykieta']
 * @property string $t['konfiguracja.etykieta_konfiguruj_team']
 * @property string $t['konfiguracja.etykieta_select_grupa']
 * @property string $t['konfiguracja.potwierdz_usun_grupe']
 * @property string $t['konfiguracja.wybierzDomyslnaGrupeEtykieta']
 * @property string $t['pobierzIdTemowDlaGrupy.brak_grypy_w_konfiguracji']
 * @property string $t['pobierzTeamy.brak_grupy_w_konfiguracji']
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
 * @property string $t['uzunTeamZListy.blad_zapisu']
 * @property string $t['zapiszKomentarz.bladZapisu']
 * @property string $t['zapiszNotatka.blad_zapisu_danych']
 * @property string $t['zapiszNotatka.nie_wybrano_dat']
 * @property string $t['zapiszNotatka.notatka_pusta']
 * @property string $t['zapiszNotatka.zamowienie_nie_istnieje']
 * @property string $t['zapiszProjekt.blad_zapisu_danych']
 * @property string $t['zapiszProjekt.nie_wybrano_dat']
 * @property string $t['zapiszProjekt.zamowienie_nie_istnieje']
 * @property string $t['zapiszSortowanie.blad_zapisu']
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
class Http extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'dodajGrupe.blad_zapisu' => '[ETYKIETA:dodajGrupe.blad_zapisu]',	//TODO
		'dodajGrupe.grupa_istnieje' => '[ETYKIETA:dodajGrupe.grupa_istnieje]',	//TODO
		'dodajNotatke.blad_kolor' => '[ETYKIETA:dodajNotatke.blad_kolor]',	//TODO
		'dodajNotatke.blad_nazwa_wyswietlana' => '[ETYKIETA:dodajNotatke.blad_nazwa_wyswietlana]',	//TODO
		'dodajNotatke.notatka_nie_wypelniona' => '[ETYKIETA:dodajNotatke.notatka_nie_wypelniona]',	//TODO
		'dodajProjekt.bladKolor' => '[ETYKIETA:dodajProjekt.bladKolor]',	//TODO
		'dodajProjekt.bladNazwaWyswietlana' => '[ETYKIETA:dodajProjekt.bladNazwaWyswietlana]',	//TODO
		'dodajProjekt.bladZamowienia' => '[ETYKIETA:dodajProjekt.bladZamowienia]',	//TODO
		'dodajTeamDoListy.blad_zapisu' => '[ETYKIETA:dodajTeamDoListy.blad_zapisu]',	//TODO
		'dodajTeamDoListy.team_nie_istnieje' => '[ETYKIETA:dodajTeamDoListy.team_nie_istnieje]',	//TODO
		'dodajUzytownikaDoEkipy.uzytkownik_nie_istnieje' => '[ETYKIETA:dodajUzytownikaDoEkipy.uzytkownik_nie_istnieje]',	//TODO
		'edycjaTeamu.potwierdz_usun_pracownika' => '[ETYKIETA:edycjaTeamu.potwierdz_usun_pracownika]',	//TODO
		'index.nieZaznaczonoDatyKomunikat' => '[ETYKIETA:index.nieZaznaczonoDatyKomunikat]',	//TODO
		'index.potwierdzUsunPrzypisanie' => '[ETYKIETA:index.potwierdzUsunPrzypisanie]',	//TODO
		'index.tytul_modulu' => '[ETYKIETA:index.tytul_modulu]',	//TODO
		'index.tytul_strony' => '[ETYKIETA:index.tytul_strony]',	//TODO
		'konfiguracja.data_start_etykieta' => 'Date range start:',
		'konfiguracja.data_stop_etykieta' => 'Date range stop:',
		'konfiguracja.data_suwak_start_etykieta' => 'Data slider start',
		'konfiguracja.data_suwak_stop_etykieta' => 'Data slider stop',
		'konfiguracja.domyslna_grupa_etykieta' => 'Select default group',
		'konfiguracja.etykieta_konfiguruj_team' => 'Menage group',
		'konfiguracja.etykieta_select_grupa' => 'Select group: ',
		'konfiguracja.potwierdz_usun_grupe' => '[ETYKIETA:konfiguracja.potwierdz_usun_grupe]',	//TODO
		'konfiguracja.wybierzDomyslnaGrupeEtykieta' => 'Select group',
		'pobierzIdTemowDlaGrupy.brak_grypy_w_konfiguracji' => '[ETYKIETA:pobierzIdTemowDlaGrupy.brak_grypy_w_konfiguracji]',	//TODO
		'pobierzTeamy.brak_grupy_w_konfiguracji' => '[ETYKIETA:pobierzTeamy.brak_grupy_w_konfiguracji]',	//TODO
		'ustawLidera.blad_zapisu' => '[ETYKIETA:ustawLidera.blad_zapisu]',	//TODO
		'ustawLidera.team_nie_istnieje' => '[ETYKIETA:ustawLidera.team_nie_istnieje]',	//TODO
		'usunGrupe.blad_zapisu' => '[ETYKIETA:usunGrupe.blad_zapisu]',	//TODO
		'usunGrupe.grupa_nie_istnieje' => '[ETYKIETA:usunGrupe.grupa_nie_istnieje]',	//TODO
		'usunGrupe.usuwasz_grupe_domyslna_komunikat' => '[ETYKIETA:usunGrupe.usuwasz_grupe_domyslna_komunikat]',	//TODO
		'usunPracownikaZEkipy.blad_podczas_wylogowanie_pracownika' => '[ETYKIETA:usunPracownikaZEkipy.blad_podczas_wylogowanie_pracownika]',	//TODO
		'usunPracownikaZEkipy.pracownik_zalogowany' => '[ETYKIETA:usunPracownikaZEkipy.pracownik_zalogowany]',	//TODO
		'usunPracownikaZEkipy.team_nie_istnieje' => '[ETYKIETA:usunPracownikaZEkipy.team_nie_istnieje]',	//TODO
		'usunPracownikaZEkipy.uzytkownik_nie_istnieje' => '[ETYKIETA:usunPracownikaZEkipy.uzytkownik_nie_istnieje]',	//TODO
		'usunPrzypisanie.blad_usuwania' => '[ETYKIETA:usunPrzypisanie.blad_usuwania]',	//TODO
		'usunPrzypomnienie.bladZapisu' => '[ETYKIETA:usunPrzypomnienie.bladZapisu]',	//TODO
		'uzunTeamZListy.blad_zapisu' => '[ETYKIETA:uzunTeamZListy.blad_zapisu]',	//TODO
		'zapiszKomentarz.bladZapisu' => '[ETYKIETA:zapiszKomentarz.bladZapisu]',	//TODO
		'zapiszNotatka.blad_zapisu_danych' => '[ETYKIETA:zapiszNotatka.blad_zapisu_danych]',	//TODO
		'zapiszNotatka.nie_wybrano_dat' => '[ETYKIETA:zapiszNotatka.nie_wybrano_dat]',	//TODO
		'zapiszNotatka.notatka_pusta' => '[ETYKIETA:zapiszNotatka.notatka_pusta]',	//TODO
		'zapiszNotatka.zamowienie_nie_istnieje' => '[ETYKIETA:zapiszNotatka.zamowienie_nie_istnieje]',	//TODO
		'zapiszProjekt.blad_zapisu_danych' => 'write error data',
		'zapiszProjekt.nie_wybrano_dat' => '[ETYKIETA:zapiszProjekt.nie_wybrano_dat]',	//TODO
		'zapiszProjekt.zamowienie_nie_istnieje' => '[ETYKIETA:zapiszProjekt.zamowienie_nie_istnieje]',	//TODO
		'zapiszSortowanie.blad_zapisu' => '[ETYKIETA:zapiszSortowanie.blad_zapisu]',	//TODO

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