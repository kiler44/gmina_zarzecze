<?php
namespace Generic\Tlumaczenie\No\Modul\Tidsbanken;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie 
 * @property string $t['aktualizujWpis.blad_wartosci']
 * @property string $t['aktualizujWpis.wpis_nie_istnieje']
 * @property string $t['dodajProdukt.blad_wypelnienia_formularza']
 * @property string $t['dodajProdukt.dodawanie_produktu_etykieta']
 * @property string $t['dodajProdukt.edycja_produktu_blad']
 * @property string $t['dodajProdukt.edycja_produktu_ok']
 * @property string $t['dodajProdukt.produkt_nie_istnieje']
 * @property string $t['dodajProdukt.tytul_modulu']
 * @property string $t['dodajProdukt.tytul_strony']
 * @property string $t['dodajProduktDlugoterminowy.dataDoLabel']
 * @property string $t['dodajProduktDlugoterminowy.dataOdLabel']
 * @property string $t['dodajProduktDlugoterminowy.dodajFerieLabel']
 * @property string $t['dodajProduktDlugoterminowy.tytul_modulu']
 * @property string $t['dodajProduktDlugoterminowy.tytul_strony']
 * @property string $t['dodajProduktDlugoterminowy.zapiszLabel']
 * @property string $t['dodajProduktGrupowy.ferie']
 * @property string $t['dodajProduktGrupowy.nieWybranoPracownikow']
 * @property string $t['dodajStawke.blad_zapisu']
 * @property string $t['dodajStawke.daty_zajete']
 * @property string $t['dodaj_produkt.etykietaMenu']
 * @property string $t['grupoweDodawanie.dataDoLabel']
 * @property string $t['grupoweDodawanie.dataOdLabel']
 * @property string $t['grupoweDodawanie.dodajFerieLabel']
 * @property string $t['grupoweDodawanie.miesiacLabel']
 * @property string $t['grupoweDodawanie.tytul_modulu']
 * @property string $t['grupoweDodawanie.tytul_strony']
 * @property string $t['grupoweDodawanie.zapiszLabel']
 * @property string $t['index.data_start']
 * @property string $t['index.data_stop']
 * @property string $t['index.dodajProduktDlugoterminowy']
 * @property string $t['index.dodajProduktDugoterminowy']
 * @property string $t['index.edytujUzytkownika']
 * @property string $t['index.etykieta_filtry']
 * @property string $t['index.imie']
 * @property string $t['index.kod']
 * @property string $t['index.kod_ksiegowy']
 * @property string $t['index.login']
 * @property string $t['index.logout']
 * @property string $t['index.nazwa']
 * @property string $t['index.nazwa_ksiegowa']
 * @property string $t['index.nazwisko']
 * @property string $t['index.podglądDlugoterminowy']
 * @property string $t['index.pokazDzien']
 * @property string $t['index.produkt']
 * @property string $t['index.status']
 * @property string $t['index.szukajFraza']
 * @property string $t['index.szukajFrazaPlaceholder']
 * @property string $t['index.szukajLogin']
 * @property string $t['index.szukajOddzial']
 * @property string $t['index.szukajProdukt']
 * @property string $t['index.szukajStatus']
 * @property string $t['index.tabela_etykieta_edytuj_produkt']
 * @property string $t['index.tabela_etykieta_revert']
 * @property string $t['index.tidsbanken_loguj_przez_haslo']
 * @property string $t['index.tidsbanken_numer_pracownika']
 * @property string $t['index.tytul_modulu']
 * @property string $t['index.tytul_strony']
 * @property string $t['index.zaznacz']
 * @property string $t['listaProduktow.tabela_etykieta_edytuj_produkt']
 * @property string $t['listaProduktow.tytul_modulu']
 * @property string $t['listaProduktow.tytul_strony']
 * @property string $t['lista_produktow.etykietaMenu']
 * @property string $t['login.blad_zapisu_danych']
 * @property string $t['login.uzytkownik_nie_istnieje']
 * @property string $t['logout.brak_kolekcji_uzytkownika']
 * @property string $t['logout.nie_prawidlowa_godzina']
 * @property string $t['logout.uzytkownik_nie_jest_zalogowany']
 * @property string $t['nattarbeid.tytul_modulu']
 * @property string $t['nattarbeid.tytul_strony']
 * @property string $t['podgladDlugoterminowy.tytul_modulu']
 * @property string $t['podgladDlugoterminowy.tytul_strony']
 * @property string $t['podgladDni.tytul']
 * @property string $t['podgladDni.tytul_bez_uzytkownika']
 * @property string $t['podgladDnia.etykieta_dataStart']
 * @property string $t['podgladDnia.etykieta_dataStop']
 * @property string $t['podgladDnia.etykieta_minuty']
 * @property string $t['podgladDnia.etykieta_nazwaProduktu']
 * @property string $t['podgladDnia.etykieta_notatka']
 * @property string $t['poprawCalyTydzien.autologoutInfo']
 * @property string $t['poprawCalyTydzien.brak_pracownika']
 * @property string $t['poprawCalyTydzien.godzinyNazwa']
 * @property string $t['poprawCalyTydzien.naglowek']
 * @property string $t['poprawCalyTydzien.produktNazwa']
 * @property string $t['poprawCalyTydzien.realny_czas_logowania']
 * @property string $t['poprawCalyTydzien.sumaGodzinNaglowek']
 * @property string $t['poprawCalyTydzien.uzyj_tych_godzin']
 * @property string $t['raportFerie.tytul_modulu']
 * @property string $t['raportFerie.tytul_strony']
 * @property string $t['raportPrzerwy.tytul_modulu']
 * @property string $t['raportPrzerwy.tytul_strony']
 * @property string $t['raportSumaProduktow.tytul_modulu']
 * @property string $t['raportSumaProduktow.tytul_strony']
 * @property string $t['raportWyplata.tytul_modulu']
 * @property string $t['raportWyplata.tytul_strony']
 * @property string $t['raporty.tytul_modulu']
 * @property string $t['raporty.tytul_strony']
 * @property string $t['sprawdzTydzien.tytul_modulu']
 * @property string $t['sprawdzTydzien.tytul_strony']
 * @property string $t['test.tytul_modulu']
 * @property string $t['test.tytul_strony']
 * @property string $t['usunWpis.wpis_nie_istnieje']
 * @property string $t['zapiszAkceptacja.brakWpisu']
 * @property string $t['zapiszNotatka.notatka_zapisana']
 * @property string $t['zapiszNotatka.wpis_nie_istnieje']
 * @property array $t['index.wyszukiwarka_statusy']
 * @property string $t['index.wyszukiwarka_statusy']['nieaktywny']
 * @property string $t['index.wyszukiwarka_statusy']['aktywny']
 * @property string $t['index.wyszukiwarka_statusy']['zablokowany']
 * @property array $t['widokTidsbanken.listaMiesiecy']
 * @property string $t['widokTidsbanken.listaMiesiecy']['1']
 * @property string $t['widokTidsbanken.listaMiesiecy']['2']
 * @property string $t['widokTidsbanken.listaMiesiecy']['3']
 * @property string $t['widokTidsbanken.listaMiesiecy']['4']
 * @property string $t['widokTidsbanken.listaMiesiecy']['5']
 * @property string $t['widokTidsbanken.listaMiesiecy']['6']
 * @property string $t['widokTidsbanken.listaMiesiecy']['7']
 * @property string $t['widokTidsbanken.listaMiesiecy']['8']
 * @property string $t['widokTidsbanken.listaMiesiecy']['9']
 * @property string $t['widokTidsbanken.listaMiesiecy']['10']
 * @property string $t['widokTidsbanken.listaMiesiecy']['11']
 * @property string $t['widokTidsbanken.listaMiesiecy']['12']
 */
class Admin extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'aktualizujWpis.blad_wartosci' => '[ETYKIETA:aktualizujWpis.blad_wartosci]',	//TODO
		'aktualizujWpis.wpis_nie_istnieje' => '[ETYKIETA:aktualizujWpis.wpis_nie_istnieje]',	//TODO
		'dodajProdukt.blad_wypelnienia_formularza' => '[ETYKIETA:dodajProdukt.blad_wypelnienia_formularza]',	//TODO
		'dodajProdukt.dodawanie_produktu_etykieta' => '[ETYKIETA:dodajProdukt.dodawanie_produktu_etykieta]',	//TODO
		'dodajProdukt.edycja_produktu_blad' => '[ETYKIETA:dodajProdukt.edycja_produktu_blad]',	//TODO
		'dodajProdukt.edycja_produktu_ok' => '[ETYKIETA:dodajProdukt.edycja_produktu_ok]',	//TODO
		'dodajProdukt.produkt_nie_istnieje' => '[ETYKIETA:dodajProdukt.produkt_nie_istnieje]',	//TODO
		'dodajProdukt.tytul_modulu' => '[ETYKIETA:dodajProdukt.tytul_modulu]',	//TODO
		'dodajProdukt.tytul_strony' => '[ETYKIETA:dodajProdukt.tytul_strony]',	//TODO
		'dodajProduktDlugoterminowy.dataDoLabel' => '[ETYKIETA:dodajProduktDlugoterminowy.dataDoLabel]',	//TODO
		'dodajProduktDlugoterminowy.dataOdLabel' => '[ETYKIETA:dodajProduktDlugoterminowy.dataOdLabel]',	//TODO
		'dodajProduktDlugoterminowy.dodajFerieLabel' => '[ETYKIETA:dodajProduktDlugoterminowy.dodajFerieLabel]',	//TODO
		'dodajProduktDlugoterminowy.tytul_modulu' => '[ETYKIETA:dodajProduktDlugoterminowy.tytul_modulu]',	//TODO
		'dodajProduktDlugoterminowy.tytul_strony' => '[ETYKIETA:dodajProduktDlugoterminowy.tytul_strony]',	//TODO
		'dodajProduktDlugoterminowy.zapiszLabel' => '[ETYKIETA:dodajProduktDlugoterminowy.zapiszLabel]',	//TODO
		'dodajProduktGrupowy.ferie' => '[ETYKIETA:dodajProduktGrupowy.ferie]',	//TODO
		'dodajProduktGrupowy.nieWybranoPracownikow' => '[ETYKIETA:dodajProduktGrupowy.nieWybranoPracownikow]',	//TODO
		'dodajStawke.blad_zapisu' => '[ETYKIETA:dodajStawke.blad_zapisu]',	//TODO
		'dodajStawke.daty_zajete' => '[ETYKIETA:dodajStawke.daty_zajete]',	//TODO
		'dodaj_produkt.etykietaMenu' => 'Add product',
		'grupoweDodawanie.dataDoLabel' => '[ETYKIETA:grupoweDodawanie.dataDoLabel]',	//TODO
		'grupoweDodawanie.dataOdLabel' => '[ETYKIETA:grupoweDodawanie.dataOdLabel]',	//TODO
		'grupoweDodawanie.dodajFerieLabel' => '[ETYKIETA:grupoweDodawanie.dodajFerieLabel]',	//TODO
		'grupoweDodawanie.miesiacLabel' => '[ETYKIETA:grupoweDodawanie.miesiacLabel]',	//TODO
		'grupoweDodawanie.tytul_modulu' => '[ETYKIETA:grupoweDodawanie.tytul_modulu]',	//TODO
		'grupoweDodawanie.tytul_strony' => '[ETYKIETA:grupoweDodawanie.tytul_strony]',	//TODO
		'grupoweDodawanie.zapiszLabel' => '[ETYKIETA:grupoweDodawanie.zapiszLabel]',	//TODO
		'index.data_start' => '[ETYKIETA:index.data_start]',	//TODO
		'index.data_stop' => '[ETYKIETA:index.data_stop]',	//TODO
		'index.dodajProduktDlugoterminowy' => '[ETYKIETA:index.dodajProduktDlugoterminowy]',	//TODO
		'index.dodajProduktDugoterminowy' => '[ETYKIETA:index.dodajProduktDugoterminowy]',	//TODO
		'index.edytujUzytkownika' => '[ETYKIETA:index.edytujUzytkownika]',	//TODO
		'index.etykieta_filtry' => '[ETYKIETA:index.etykieta_filtry]',	//TODO
		'index.imie' => '[ETYKIETA:index.imie]',	//TODO
		'index.kod' => '[ETYKIETA:index.kod]',	//TODO
		'index.kod_ksiegowy' => '[ETYKIETA:index.kod_ksiegowy]',	//TODO
		'index.login' => '[ETYKIETA:index.login]',	//TODO
		'index.logout' => '[ETYKIETA:index.logout]',	//TODO
		'index.nazwa' => '[ETYKIETA:index.nazwa]',	//TODO
		'index.nazwa_ksiegowa' => '[ETYKIETA:index.nazwa_ksiegowa]',	//TODO
		'index.nazwisko' => '[ETYKIETA:index.nazwisko]',	//TODO
		'index.podglądDlugoterminowy' => '[ETYKIETA:index.podglądDlugoterminowy]',	//TODO
		'index.pokazDzien' => '[ETYKIETA:index.pokazDzien]',	//TODO
		'index.produkt' => '[ETYKIETA:index.produkt]',	//TODO
		'index.status' => '[ETYKIETA:index.status]',	//TODO
		'index.szukajFraza' => '[ETYKIETA:index.szukajFraza]',	//TODO
		'index.szukajFrazaPlaceholder' => '[ETYKIETA:index.szukajFrazaPlaceholder]',	//TODO
		'index.szukajLogin' => '[ETYKIETA:index.szukajLogin]',	//TODO
		'index.szukajOddzial' => '[ETYKIETA:index.szukajOddzial]',	//TODO
		'index.szukajProdukt' => '[ETYKIETA:index.szukajProdukt]',	//TODO
		'index.szukajStatus' => '[ETYKIETA:index.szukajStatus]',	//TODO
		'index.tabela_etykieta_edytuj_produkt' => '[ETYKIETA:index.tabela_etykieta_edytuj_produkt]',	//TODO
		'index.tabela_etykieta_revert' => '[ETYKIETA:index.tabela_etykieta_revert]',	//TODO
		'index.tidsbanken_loguj_przez_haslo' => '[ETYKIETA:index.tidsbanken_loguj_przez_haslo]',	//TODO
		'index.tidsbanken_numer_pracownika' => '[ETYKIETA:index.tidsbanken_numer_pracownika]',	//TODO
		'index.tytul_modulu' => '[ETYKIETA:index.tytul_modulu]',	//TODO
		'index.tytul_strony' => '[ETYKIETA:index.tytul_strony]',	//TODO
		'index.zaznacz' => '[ETYKIETA:index.zaznacz]',	//TODO
		'listaProduktow.tabela_etykieta_edytuj_produkt' => '[ETYKIETA:listaProduktow.tabela_etykieta_edytuj_produkt]',	//TODO
		'listaProduktow.tytul_modulu' => '[ETYKIETA:listaProduktow.tytul_modulu]',	//TODO
		'listaProduktow.tytul_strony' => '[ETYKIETA:listaProduktow.tytul_strony]',	//TODO
		'lista_produktow.etykietaMenu' => 'Product list',
		'login.blad_zapisu_danych' => '[ETYKIETA:login.blad_zapisu_danych]',	//TODO
		'login.uzytkownik_nie_istnieje' => '[ETYKIETA:login.uzytkownik_nie_istnieje]',	//TODO
		'logout.brak_kolekcji_uzytkownika' => '[ETYKIETA:logout.brak_kolekcji_uzytkownika]',	//TODO
		'logout.nie_prawidlowa_godzina' => '[ETYKIETA:logout.nie_prawidlowa_godzina]',	//TODO
		'logout.uzytkownik_nie_jest_zalogowany' => '[ETYKIETA:logout.uzytkownik_nie_jest_zalogowany]',	//TODO
		'nattarbeid.tytul_modulu' => '[ETYKIETA:nattarbeid.tytul_modulu]',	//TODO
		'nattarbeid.tytul_strony' => '[ETYKIETA:nattarbeid.tytul_strony]',	//TODO
		'podgladDlugoterminowy.tytul_modulu' => '[ETYKIETA:podgladDlugoterminowy.tytul_modulu]',	//TODO
		'podgladDlugoterminowy.tytul_strony' => '[ETYKIETA:podgladDlugoterminowy.tytul_strony]',	//TODO
		'podgladDni.tytul' => '[ETYKIETA:podgladDni.tytul]',	//TODO
		'podgladDni.tytul_bez_uzytkownika' => '[ETYKIETA:podgladDni.tytul_bez_uzytkownika]',	//TODO
		'podgladDnia.etykieta_dataStart' => '[ETYKIETA:podgladDnia.etykieta_dataStart]',	//TODO
		'podgladDnia.etykieta_dataStop' => '[ETYKIETA:podgladDnia.etykieta_dataStop]',	//TODO
		'podgladDnia.etykieta_minuty' => '[ETYKIETA:podgladDnia.etykieta_minuty]',	//TODO
		'podgladDnia.etykieta_nazwaProduktu' => '[ETYKIETA:podgladDnia.etykieta_nazwaProduktu]',	//TODO
		'podgladDnia.etykieta_notatka' => '[ETYKIETA:podgladDnia.etykieta_notatka]',	//TODO
		'poprawCalyTydzien.autologoutInfo' => 'User was logged out automatically',
		'poprawCalyTydzien.brak_pracownika' => '[ETYKIETA:poprawCalyTydzien.brak_pracownika]',	//TODO
		'poprawCalyTydzien.godzinyNazwa' => '[ETYKIETA:poprawCalyTydzien.godzinyNazwa]',	//TODO
		'poprawCalyTydzien.naglowek' => '[ETYKIETA:poprawCalyTydzien.naglowek]',	//TODO
		'poprawCalyTydzien.produktNazwa' => '[ETYKIETA:poprawCalyTydzien.produktNazwa]',	//TODO
		'poprawCalyTydzien.realny_czas_logowania' => '[ETYKIETA:poprawCalyTydzien.realny_czas_logowania]',	//TODO
		'poprawCalyTydzien.sumaGodzinNaglowek' => '[ETYKIETA:poprawCalyTydzien.sumaGodzinNaglowek]',	//TODO
		'poprawCalyTydzien.uzyj_tych_godzin' => '[ETYKIETA:poprawCalyTydzien.uzyj_tych_godzin]',	//TODO
		'raportFerie.tytul_modulu' => '[ETYKIETA:raportFerie.tytul_modulu]',	//TODO
		'raportFerie.tytul_strony' => '[ETYKIETA:raportFerie.tytul_strony]',	//TODO
		'raportPrzerwy.tytul_modulu' => '[ETYKIETA:raportPrzerwy.tytul_modulu]',	//TODO
		'raportPrzerwy.tytul_strony' => '[ETYKIETA:raportPrzerwy.tytul_strony]',	//TODO
		'raportSumaProduktow.tytul_modulu' => '[ETYKIETA:raportSumaProduktow.tytul_modulu]',	//TODO
		'raportSumaProduktow.tytul_strony' => '[ETYKIETA:raportSumaProduktow.tytul_strony]',	//TODO
		'raportWyplata.tytul_modulu' => '[ETYKIETA:raportWyplata.tytul_modulu]',	//TODO
		'raportWyplata.tytul_strony' => '[ETYKIETA:raportWyplata.tytul_strony]',	//TODO
		'raporty.tytul_modulu' => '[ETYKIETA:raporty.tytul_modulu]',	//TODO
		'raporty.tytul_strony' => '[ETYKIETA:raporty.tytul_strony]',	//TODO
		'sprawdzTydzien.tytul_modulu' => '[ETYKIETA:sprawdzTydzien.tytul_modulu]',	//TODO
		'sprawdzTydzien.tytul_strony' => '[ETYKIETA:sprawdzTydzien.tytul_strony]',	//TODO
		'test.tytul_modulu' => '[ETYKIETA:test.tytul_modulu]',	//TODO
		'test.tytul_strony' => '[ETYKIETA:test.tytul_strony]',	//TODO
		'usunWpis.wpis_nie_istnieje' => '[ETYKIETA:usunWpis.wpis_nie_istnieje]',	//TODO
		'zapiszAkceptacja.brakWpisu' => '[ETYKIETA:zapiszAkceptacja.brakWpisu]',	//TODO
		'zapiszNotatka.notatka_zapisana' => '[ETYKIETA:zapiszNotatka.notatka_zapisana]',	//TODO
		'zapiszNotatka.wpis_nie_istnieje' => '[ETYKIETA:zapiszNotatka.wpis_nie_istnieje]',	//TODO

		'index.wyszukiwarka_statusy' => array(
			'nieaktywny' => 'Not active',
			'aktywny' => 'Active',
			'zablokowany' => 'Blocked',
		),
		'widokTidsbanken.listaMiesiecy' => array(
			'1' => 'January',
			'2' => 'Febraury',
			'3' => 'March',
			'4' => 'April',
			'5' => 'May',
			'6' => 'June',
			'7' => 'July',
			'8' => 'August',
			'9' => 'September',
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