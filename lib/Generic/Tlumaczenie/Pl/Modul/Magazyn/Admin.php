<?php
namespace Generic\Tlumaczenie\Pl\Modul\Magazyn;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie 
 * @property string $t['adres_etykieta']
 * @property string $t['adres_wartosc_post']
 * @property string $t['anulujZamowienie.blad']
 * @property string $t['bankgiro_etykieta']
 * @property string $t['bankgiro_wartosc']
 * @property string $t['dodaj.blad_brak_kategorii_nadrzednej']
 * @property string $t['dodaj.blad_duplikacja_kategorii']
 * @property string $t['dodaj.blad_kod_zajety']
 * @property string $t['dodaj.blad_nie_mozna_zapisac_kategorii']
 * @property string $t['dodaj.info_zapisano_dane_kategorii']
 * @property string $t['dodaj.tytul_strony']
 * @property string $t['dodajDoZamowienia.ilosc_za_duza']
 * @property string $t['dodajDoZamowienia.nie_przekazano_wszystkich_parametrow']
 * @property string $t['dodajDoZamowienia.produkt_nie_istnieje']
 * @property string $t['dodajProdukty.grupaRoznaOdBazowej']
 * @property string $t['dodajProdukty.niekompletnyProduktDodanyDoBazowego']
 * @property string $t['dodajProdukty.sugerowane_produkty_w_grupie']
 * @property string $t['dodajprodukt.bladIlosciWgrupieProduktow']
 * @property string $t['dodajprodukt.tytul_modulu']
 * @property string $t['dodajprodukt.tytul_strony']
 * @property string $t['drzewoKategorii.blad_nieprawidlowa_kategoria_glowna']
 * @property string $t['drzewoKategorii.etykieta_link_sortowanie']
 * @property string $t['drzewoKategorii.etykieta_link_usun_pytanie']
 * @property string $t['drzewoKategorii.etykieta_link_usun_wszystkie']
 * @property string $t['drzewoKategorii.etykieta_link_usun_wszystkie_pytanie']
 * @property string $t['drzewoKategorii.tytul_modulu_produkty']
 * @property string $t['drzewoKategorii.tytul_strony_ogloszenie']
 * @property string $t['drzewoKategorii.tytul_strony_produkt']
 * @property string $t['drzewoKategorii.tytul_strony_produkty']
 * @property string $t['drzewoKategorii.tytul_strony_usluga']
 * @property string $t['drzewokategorii.usun_confirm_naglowek']
 * @property string $t['edytuj.blad_brak_kategorii']
 * @property string $t['edytuj.blad_nie_mozna_edytowac_kategorii']
 * @property string $t['edytuj.blad_nie_mozna_zapisac_kategorii']
 * @property string $t['edytuj.info_zapisano_dane_kategorii']
 * @property string $t['edytuj.tytul_strony']
 * @property string $t['email_etykieta']
 * @property string $t['email_wartosc']
 * @property string $t['finalizacja.etykietaFinalizacjaCzysc']
 * @property string $t['finalizacja.wsteczEtykieta']
 * @property string $t['finalizacjaZamowienia.zalogowany_uzytkownik_nie_istnieje']
 * @property string $t['finalizacjaZamowienia.zamowienie_zostalo_wyslane_pomyslnie']
 * @property string $t['finalizujZamowienie.blad_zapisu_danych']
 * @property string $t['finalizujZamowienie.brakZdjecia']
 * @property string $t['finalizujZamowienie.brak_zamowienia_do_edycji']
 * @property string $t['finalizujZamowienie.dane_zapisane']
 * @property string $t['finalizujZamowienie.iloscLacznieEtykieta']
 * @property string $t['finalizujZamowienie.komunikatKoszykPusty']
 * @property string $t['finalizujZamowienie.koszyk_pusty_blad_formularza']
 * @property string $t['finalizujZamowienie.listaZamowionychProduktowEtykieta']
 * @property string $t['finalizujZamowienie.produktIdEtykieta']
 * @property string $t['finalizujZamowienie.produktIloscEtykieta']
 * @property string $t['finalizujZamowienie.produktKodEtykieta']
 * @property string $t['finalizujZamowienie.produktNazwaEtykieta']
 * @property string $t['finalizujZamowienie.tytul_modulu']
 * @property string $t['finalizujZamowienie.tytul_strony']
 * @property string $t['finalizujZamowienie.usunEtykieta']
 * @property string $t['finalizujZamowienie.zdjecieEtykieta']
 * @property string $t['formularz.blokujPrzypisywanie.etykieta']
 * @property string $t['formularz.blokujWyswietlanie.etykieta']
 * @property string $t['formularz.description.etykieta']
 * @property string $t['formularz.etykieta_powrot']
 * @property string $t['formularz.etykieta_select_wybierz']
 * @property string $t['formularz.filtr18.etykieta']
 * @property string $t['formularz.generujDane.etykieta']
 * @property string $t['formularz.generujDane.nazwa']
 * @property string $t['formularz.generujUrl.etykieta']
 * @property string $t['formularz.info_zablokowana_zmiana_filtr18']
 * @property string $t['formularz.info_zablokowana_zmiana_przypisywania']
 * @property string $t['formularz.info_zablokowana_zmiana_wyswietlania']
 * @property string $t['formularz.info_znaleziono_duplakcje_url']
 * @property string $t['formularz.kod.etykieta']
 * @property string $t['formularz.nazwa.etykieta']
 * @property string $t['formularz.opiekun.etykieta']
 * @property string $t['formularz.sciezka.etykieta']
 * @property string $t['formularz.tagi.etykieta']
 * @property string $t['formularz.title.etykieta']
 * @property string $t['formularz.url.etykieta']
 * @property string $t['formularz.wstecz.wartosc']
 * @property string $t['formularz.wybierz']
 * @property string $t['formularz.zapisz.wartosc']
 * @property string $t['formularzFinalizuj.dodajGrupowo.etykieta']
 * @property string $t['formularzFinalizuj.odbiorcaTeam.etykieta']
 * @property string $t['formularzFinalizuj.odbiorcaTeamLista.etykieta']
 * @property string $t['formularzFinalizuj.odbiorcaUzytkownik.etykieta']
 * @property string $t['formularzFinalizuj.odbiorcaUzytkownikLista.etykieta']
 * @property string $t['formularzFinalizuj.opis.etykieta']
 * @property string $t['formularzFinalizuj.wybierzOdbiorce.etykieta']
 * @property string $t['formularzFinalizuj.wydaj.etykieta']
 * @property string $t['formularzFinalizuj.zapisz.wartosc']
 * @property string $t['formularzPodpis.idOsobyAkceptujacej.etykieta']
 * @property string $t['formularzPodpis.zapisz.wartosc']
 * @property string $t['formularzProduktyDodaj.produkt.region']
 * @property string $t['formularzProduktyDodaj.wstecz.wartosc']
 * @property string $t['formularzProduktyDodaj.zapisz.wartosc']
 * @property string $t['formularzSzukaj.czysc.wartosc']
 * @property string $t['formularzSzukaj.fraza.etykieta']
 * @property string $t['formularzSzukaj.odbiorcaTeam.etykieta']
 * @property string $t['formularzSzukaj.odbiorcaUzytkownik.etykieta']
 * @property string $t['formularzSzukaj.przyjete.etykieta']
 * @property string $t['formularzSzukaj.szukaj.wartosc']
 * @property string $t['formularzSzukaj.tylkoMoje.etykieta']
 * @property string $t['index.anulujZamowienieEtykieta']
 * @property string $t['index.data']
 * @property string $t['index.data_dodania']
 * @property string $t['index.data_wydania']
 * @property string $t['index.edytujZamowienieEtykieta']
 * @property string $t['index.etykieta_link_kategorie_produktow']
 * @property string $t['index.etykieta_link_kategorie_uslug']
 * @property string $t['index.etykieta_link_lista_produktow']
 * @property string $t['index.etykieta_link_usun_wszystkie']
 * @property string $t['index.etykieta_link_usun_wszystkie_pytanie']
 * @property string $t['index.etykieta_produkty']
 * @property string $t['index.etykieta_uslugi']
 * @property string $t['index.filtr_po_statusie_etykieta']
 * @property string $t['index.id']
 * @property string $t['index.id_osoby_wydajacej']
 * @property string $t['index.kartaZamowieniaPodglad']
 * @property string $t['index.odbiorca']
 * @property string $t['index.opis']
 * @property string $t['index.podgladPdf']
 * @property string $t['index.status']
 * @property string $t['index.status_anulowane']
 * @property string $t['index.status_oczekuje']
 * @property string $t['index.status_wydane']
 * @property string $t['index.status_zaakceptowane']
 * @property string $t['index.tytul_modulu']
 * @property string $t['index.tytul_strony']
 * @property string $t['index.ustawZaakceptowaneEtykieta']
 * @property string $t['index.wszystkie']
 * @property string $t['inputRadio.team']
 * @property string $t['inputRadion.uzytkownik']
 * @property string $t['kartaZamowienia.blad_formularza']
 * @property string $t['kartaZamowienia.blad_zapisu_podpisu']
 * @property string $t['kartaZamowienia.dataEtykieta']
 * @property string $t['kartaZamowienia.etykietaDrukuj']
 * @property string $t['kartaZamowienia.etykietaNaglowek']
 * @property string $t['kartaZamowienia.from_etykieta']
 * @property string $t['kartaZamowienia.from_miasto_firma']
 * @property string $t['kartaZamowienia.from_nazwa_firmy']
 * @property string $t['kartaZamowienia.from_ulica_firma']
 * @property string $t['kartaZamowienia.iloscLacznieEtykieta']
 * @property string $t['kartaZamowienia.informacjeNo']
 * @property string $t['kartaZamowienia.osobaWydajacaEtykieta']
 * @property string $t['kartaZamowienia.pdopisane_przez']
 * @property string $t['kartaZamowienia.powrotEtykieta']
 * @property string $t['kartaZamowienia.produktCodeEtykieta']
 * @property string $t['kartaZamowienia.produktIdEtykieta']
 * @property string $t['kartaZamowienia.produktIloscEtykieta']
 * @property string $t['kartaZamowienia.produktNazwaEtykieta']
 * @property string $t['kartaZamowienia.produktStanEtykieta']
 * @property string $t['kartaZamowienia.to_etykieta']
 * @property string $t['kartaZamowienia.tytul']
 * @property string $t['kartaZamowienia.tytul_modulu']
 * @property string $t['kartaZamowienia.tytul_strony']
 * @property string $t['kartaZamowienia.zamowienieNieIstnieje']
 * @property string $t['kartaZamowienia.zamowienie_zostalo_wydane']
 * @property string $t['kartaZwrotu.etykietaDrukuj']
 * @property string $t['kartaZwrotu.from_etykieta']
 * @property string $t['kartaZwrotu.naglowek']
 * @property string $t['kartaZwrotu.produktStanEtykieta']
 * @property string $t['kartaZwrotu.tytul']
 * @property string $t['kartaZwrotu.tytul_modulu']
 * @property string $t['kartaZwrotu.tytul_przyjecie']
 * @property string $t['kartaZwrotu.tytul_strony']
 * @property string $t['kartaZwrotu.wroc_do_lista_przyjec']
 * @property string $t['kartaZwrotu.wroc_do_lista_uzytkownikow']
 * @property string $t['listaPrzyjec.data_dodania']
 * @property string $t['listaPrzyjec.id']
 * @property string $t['listaPrzyjec.id_oddajacego']
 * @property string $t['listaPrzyjec.id_przyjmujacego']
 * @property string $t['listaPrzyjec.podglad']
 * @property string $t['listaPrzyjec.tytul_modulu']
 * @property string $t['listaPrzyjec.tytul_strony']
 * @property string $t['magazyn.bladEdycjiProduktu']
 * @property string $t['magazyn.czyscKoszyk']
 * @property string $t['magazyn.dodajProduktEtykieta']
 * @property string $t['magazyn.edycja_brak_zamowienia']
 * @property string $t['magazyn.fraza_szukaj']
 * @property string $t['magazyn.koszykEtykieta']
 * @property string $t['magazyn.koszyk_finalizuj_etykieta']
 * @property string $t['magazyn.koszyk_ilosc_etykieta']
 * @property string $t['magazyn.koszyk_kod_etykieta']
 * @property string $t['magazyn.koszyk_nazwa_etykieta']
 * @property string $t['magazyn.koszyk_pusty']
 * @property string $t['magazyn.koszyk_pusty_blad_formularza']
 * @property string $t['magazyn.koszyk_usun_etykieta']
 * @property string $t['magazyn.minimalna_ilosc_znakow_informacja']
 * @property string $t['magazyn.produkty_niekompletne_etykieta']
 * @property string $t['magazyn.produkty_serwis_etykieta']
 * @property string $t['magazyn.szukajFrazaPlaceholder']
 * @property string $t['magazyn.tytul_modulu']
 * @property string $t['magazyn.tytul_modulu_edycja']
 * @property string $t['magazyn.tytul_strony']
 * @property string $t['magazyn.tytul_strony_edycja']
 * @property string $t['magazyn.znaleziono_ilosc_etykieta']
 * @property string $t['miasto_wartosc_post']
 * @property string $t['mojeProdukty.tytul_modulu']
 * @property string $t['mojeProdukty.tytul_strony']
 * @property string $t['mojeZamowienia.tytulRegionu']
 * @property string $t['mojeZamowienia.tytulRegionuTeam']
 * @property string $t['mojeZamowienia.tytul_modulu']
 * @property string $t['mojeZamowienia.tytul_strony']
 * @property string $t['org_numer_etykieta']
 * @property string $t['org_numer_wartosc']
 * @property string $t['parsujPojedynczyWierszWyszukiwania.dodajDoZamowieniaEtykieta']
 * @property string $t['parsujPojedynczyWierszWyszukiwania.edytujProduktEtykieta']
 * @property string $t['parsujPojedynczyWierszWyszukiwania.iloscEtykieta']
 * @property string $t['parsujPojedynczyWierszWyszukiwania.ilosc_etykieta']
 * @property string $t['parsujPojedynczyWierszWyszukiwania.kodEtykieta']
 * @property string $t['parsujPojedynczyWierszWyszukiwania.nazwaEtykieta']
 * @property string $t['parsujPojedynczyWierszWyszukiwania.podgladGrupyEtykieta']
 * @property string $t['parsujPojedynczyWierszWyszukiwania.ustawJakoNaprawiony']
 * @property string $t['parsujPojedynczyWierszWyszukiwania.zapiszIloscEtykieta']
 * @property string $t['pobierzWynikiSzukaj.brak_wynikow_wyszukiwania']
 * @property string $t['pobierzWynikiSzukaj.minimalna_ilosc_znakow_informacja']
 * @property string $t['pobierzWynikiSzukaj.sciezka_label']
 * @property string $t['podgladProduktu.atrybuty_produktu']
 * @property string $t['podgladProduktu.cena']
 * @property string $t['podgladProduktu.dodany_przez']
 * @property string $t['podgladProduktu.ilosc']
 * @property string $t['podgladProduktu.kategoria']
 * @property string $t['podgladProduktu.kod_produktu']
 * @property string $t['podgladProduktu.kr']
 * @property string $t['podgladProduktu.opiekun_produktu']
 * @property string $t['podgladProduktu.produkty_w_grupie']
 * @property string $t['podgladProduktu.status']
 * @property string $t['podgladProduktu.szt']
 * @property string $t['podgladProduktu.wybrany_produkt_nie_istnieje']
 * @property string $t['podgladProduktu.zalaczniki']
 * @property string $t['produktyDodaj.blad_formularza']
 * @property string $t['produktyDodaj.blad_zapisu']
 * @property string $t['produktyDodaj.komunikat_dodano_produkt']
 * @property string $t['produktyDodaj.komunikat_edycja_ok']
 * @property string $t['produktylista.tytul_modulu']
 * @property string $t['produktylista.tytul_strony']
 * @property string $t['przyjmijTowar.komunikatTowarPrzyjety']
 * @property string $t['przyjmijTowar.koszykPusty']
 * @property string $t['przyjmijTowar.tytul_modulu']
 * @property string $t['przyjmijTowar.tytul_strony']
 * @property string $t['select_wybierz_etykieta']
 * @property string $t['sortowanie.blad_nie_mozna_pobrac_kategorii']
 * @property string $t['sortowanie.blad_nie_mozna_zmienic_rodzica_kategorii']
 * @property string $t['sortowanie.blad_nie_mozna_zmienic_ustawienia_kategorii']
 * @property string $t['sortowanie.blad_niepelne_dane_kategorii']
 * @property string $t['sortowanie.blad_nieprawidlowa_kategoria_glowna']
 * @property string $t['sortowanie.blad_nieprawidlowe_dane_kategorii']
 * @property string $t['sortowanie.blad_nieprawidlowe_dane_sasiada']
 * @property string $t['sortowanie.blad_nieprawidlowe_oznaczenie_polozenia']
 * @property string $t['sortowanie.info_zmieniono_rodzica_kategorii']
 * @property string $t['sortowanie.info_zmieniono_ustawienie_kategorii']
 * @property string $t['sortowanie.tytul_modulu_produkty']
 * @property string $t['sortowanie.tytul_strony_ogloszenie']
 * @property string $t['sortowanie.tytul_strony_produkt']
 * @property string $t['sortowanie.tytul_strony_produkty']
 * @property string $t['sortowanie.tytul_strony_usluga']
 * @property string $t['stanOdbiorcy.tytul_modulu']
 * @property string $t['stanOdbiorcy.tytul_strony']
 * @property string $t['telefon_etykieta']
 * @property string $t['telefon_wartosc']
 * @property string $t['ustawJakoNaprawiony.bladZapisu']
 * @property string $t['ustawJakoNaprawiony.produktGlownyNieIstnieje']
 * @property string $t['ustawJakoNaprawiony.produktNieIstanieje']
 * @property string $t['ustawZaakceptowane.blad']
 * @property string $t['usun.blad_brak_kategorii']
 * @property string $t['usun.blad_nie_mozna_usunac_kategorii']
 * @property string $t['usun.blad_nie_mozna_usunac_kategorii_glownej']
 * @property string $t['usun.etykieta_anuluj']
 * @property string $t['usun.etykieta_blad_usun']
 * @property string $t['usun.etykieta_nazwa_firmy']
 * @property string $t['usun.etykieta_nazwa_ogloszenia']
 * @property string $t['usun.etykieta_nazwa_zobacz']
 * @property string $t['usun.etykieta_potwierdzenie_usun']
 * @property string $t['usun.etykieta_usun']
 * @property string $t['usun.info_usuniecie_kategorii']
 * @property string $t['usun.info_usunieto_kategorie']
 * @property string $t['usunZdjecie.blad_nie_mozna_usunac_zdjecia']
 * @property string $t['usunZdjecie.info_usunieto_zdjecie']
 * @property string $t['widokPracownika.alertTrescNieZaznaczono']
 * @property string $t['widokPracownika.alertTytulNieZaznaczono']
 * @property string $t['widokPracownika.data']
 * @property string $t['widokPracownika.data_dodania']
 * @property string $t['widokPracownika.etykietaPrzekazProdukt']
 * @property string $t['widokPracownika.etykietaZwrotProduktu']
 * @property string $t['widokPracownika.id']
 * @property string $t['widokPracownika.ilosc']
 * @property string $t['widokPracownika.kartaProduktu']
 * @property string $t['widokPracownika.kod']
 * @property string $t['widokPracownika.komunikat_wybierz_team_lub_pracownika']
 * @property string $t['widokPracownika.nazwa_produktu']
 * @property string $t['widokPracownika.pracownik_nie_istnieje']
 * @property string $t['widokPracownika.przyciskListaKartZamowien']
 * @property string $t['widokPracownika.przyciskListaProduktow']
 * @property string $t['widokPracownika.przyciskZlozZamowienie']
 * @property string $t['widokPracownika.status']
 * @property string $t['widokPracownika.team_nie_istnieje']
 * @property string $t['widokPracownika.tytul_modulu']
 * @property string $t['widokPracownika.tytul_pracownik_lista_produktow']
 * @property string $t['widokPracownika.tytul_strony']
 * @property string $t['widokPracownika.tytul_team_lista_produktow']
 * @property string $t['widokPracownika.zdjecie']
 * @property string $t['www_etykieta']
 * @property string $t['www_wartosc']
 * @property string $t['zakladka.noweZamowienie']
 * @property string $t['zakladki.finalizacja']
 * @property string $t['zakladki.index']
 * @property string $t['zakladki.kategorie']
 * @property string $t['zakladki.kategorie_drzewo']
 * @property string $t['zakladki.kategorie_sortowanie']
 * @property string $t['zakladki.listaPrzyjec']
 * @property string $t['zakladki.magazyn']
 * @property string $t['zakladki.mojMagazyn']
 * @property string $t['zakladki.mojeProdukty']
 * @property string $t['zakladki.mojeZamowienia']
 * @property string $t['zakladki.produkty']
 * @property string $t['zakladki.produkty_dodaj']
 * @property string $t['zakladki.produkty_lista']
 * @property string $t['zakladki.przyjmij_towar']
 * @property string $t['zakladki.stanOdbiorca']
 * @property string $t['zakladki.widokPracownika']
 * @property string $t['zamowNowyProdukt.tytul_modulu']
 * @property string $t['zamowNowyProdukt.tytul_strony']
 * @property string $t['zatwierdzZwrotProduktow.infoPrzekazProdukt']
 * @property string $t['zatwierdzZwrotProduktow.infoWymienProdukt']
 * @property string $t['zatwierdzZwrotProduktow.tytul_modulu']
 * @property string $t['zatwierdzZwrotProduktow.tytul_strony']
 * @property string $t['zatwierdzZwrotProduktow.wystapilyBledyPodczasZwrotu']
 * @property string $t['zlozZamowienie.tytul_modulu']
 * @property string $t['zlozZamowienie.tytul_strony']
 * @property string $t['znaczek_rozdziel']
 * @property string $t['zwrocProdukty.etykietaZatwierdzZwrot']
 * @property string $t['zwrocProdukty.iloscEtykieta']
 * @property string $t['zwrocProdukty.kodEtykieta']
 * @property string $t['zwrocProdukty.nazwaEtykieta']
 * @property string $t['zwrocProdukty.nieWybranoProduktowDoZwrotu']
 * @property string $t['zwrocProdukty.opisEtykieta']
 * @property string $t['zwrocProdukty.powrotDoListaProduktowEtykieta']
 * @property string $t['zwrocProdukty.pracownik_nie_istnieje']
 * @property string $t['zwrocProdukty.produktPrzeniesionyDoGrupyNieplene']
 * @property string $t['zwrocProdukty.produktPrzeniesionyDoGrupySerwis']
 * @property string $t['zwrocProdukty.przekazEtykieta']
 * @property string $t['zwrocProdukty.przekazLabel']
 * @property string $t['zwrocProdukty.przekazLabel_pracownik']
 * @property string $t['zwrocProdukty.przekazLabel_team']
 * @property string $t['zwrocProdukty.statusEtykieta']
 * @property string $t['zwrocProdukty.team_nie_istnieje']
 * @property string $t['zwrocProdukty.tytul_modulu']
 * @property string $t['zwrocProdukty.tytul_strony']
 * @property string $t['zwrocProdukty.wybraneProduktyNieZostalyZnalezione']
 * @property string $t['zwrocProdukty.wymienEtykieta']
 * @property string $t['zwrocProdukty.zdjecieEtykieta']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajDrzewoKategorii']
 * @property string $t['_akcje_etykiety_']['wykonajDodaj']
 * @property string $t['_akcje_etykiety_']['wykonajSortowanie']
 * @property string $t['_akcje_etykiety_']['wykonajEdytuj']
 * @property string $t['_akcje_etykiety_']['wykonajUsun']
 * @property string $t['_akcje_etykiety_']['wykonajMagazyn']
 * @property string $t['_akcje_etykiety_']['wykonajProduktyLista']
 * @property string $t['_akcje_etykiety_']['wykonajProduktyDodaj']
 * @property array $t['_zdarzenia_etykiety_']
 * @property string $t['_zdarzenia_etykiety_']['dodano_kategorie']
 * @property string $t['_zdarzenia_etykiety_']['edytowano_kategorie']
 * @property string $t['_zdarzenia_etykiety_']['usunieto_kategorie']
 * @property string $t['_zdarzenia_etykiety_']['usunieto_wszystkie_kategorie_z_glownej']
 * @property string $t['_zdarzenia_etykiety_']['usunieto_dane_kategorii']
 * @property string $t['_zdarzenia_etykiety_']['zmieniono_kategorie_ogloszenia']
 * @property array $t['data_dodania_opcje']
 * @property string $t['data_dodania_opcje']['7']
 * @property string $t['data_dodania_opcje']['14']
 * @property string $t['data_dodania_opcje']['31']
 * @property string $t['data_dodania_opcje']['93']
 * @property string $t['data_dodania_opcje']['183']
 * @property array $t['uprawnienia_atrybuty_produktu']
 * @property string $t['uprawnienia_atrybuty_produktu']['publiczne']
 * @property string $t['uprawnienia_atrybuty_produktu']['wlasciciel_grupy']
 * @property string $t['uprawnienia_atrybuty_produktu']['uzytkownik']
 * @property string $t['uprawnienia_atrybuty_produktu']['osoba_wydajaca']
 * @property string $t['uprawnienia_atrybuty_produktu']['osoba_dodajaca_produkt']
 * @property string $t['uprawnienia_atrybuty_produktu']['pracownik_biurowy']
 * @property array $t['zwrocProdukty.stan_produktu']
 * @property string $t['zwrocProdukty.stan_produktu']['nowy']
 * @property string $t['zwrocProdukty.stan_produktu']['uzywany']
 * @property string $t['zwrocProdukty.stan_produktu']['zniszczone_uzytkownik']
 * @property string $t['zwrocProdukty.stan_produktu']['kosz']
 * @property string $t['zwrocProdukty.stan_produktu']['zgubiony']
 * @property string $t['zwrocProdukty.stan_produktu']['serwis']
 */
class Admin extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'adres_etykieta' => 'Postadresse : ',
		'adres_wartosc_post' => 'Micheletveien 37b',
		'anulujZamowienie.blad' => 'Wystąpił błąd podczas anulowania zamówienia',
		'bankgiro_etykieta' => 'BANKGIRO',
		'bankgiro_wartosc' => '1503 32 27407',
		'dodaj.blad_brak_kategorii_nadrzednej' => 'Nie określono kategorii nadrzędnej!',
		'dodaj.blad_duplikacja_kategorii' => 'Nie można zapisać danych kategorii - nazwa kategorii zduplikowana!',
		'dodaj.blad_kod_zajety' => 'Wybrany kod jest już zajęty!',
		'dodaj.blad_nie_mozna_zapisac_kategorii' => 'Nie można zapisać danych kategorii!',
		'dodaj.info_zapisano_dane_kategorii' => 'Sukces! Dodano nową kategorię.',
		'dodaj.tytul_strony' => 'Nowa kategoria',
		'dodajDoZamowienia.ilosc_za_duza' => 'Wprowadzona ilość jest zbyt duża',
		'dodajDoZamowienia.nie_przekazano_wszystkich_parametrow' => 'Wybrany produkt nie istnieje lub błędna ilość produktów',
		'dodajDoZamowienia.produkt_nie_istnieje' => 'Wybrany produkt nie istnieje',
		'dodajProdukty.grupaRoznaOdBazowej' => 'Grupa nie zawiera wymaganych produktów',
		'dodajProdukty.niekompletnyProduktDodanyDoBazowego' => 'Proukt został zapisany pomyslnie',
		'dodajProdukty.sugerowane_produkty_w_grupie' => 'Sugerowane produkty w grupie : {LISTA_PRODUKTOW}',
		'dodajprodukt.bladIlosciWgrupieProduktow' => 'Brak wymaganej ilości produktów na magazynie ({LISTA_PRODUKTOW})',
		'dodajprodukt.tytul_modulu' => 'Dodaj produkt',
		'dodajprodukt.tytul_strony' => 'Dodaj produkt',
		'drzewoKategorii.blad_nieprawidlowa_kategoria_glowna' => 'Nieprawidlowa kategoria główna',
		'drzewoKategorii.etykieta_link_sortowanie' => 'Sortowanie kategorii',
		'drzewoKategorii.etykieta_link_usun_pytanie' => 'Czy na pewno chcesz usunąć tą kategorię i wszystkie podległe?',
		'drzewoKategorii.etykieta_link_usun_wszystkie' => 'Usuń wszystkie kategorie',
		'drzewoKategorii.etykieta_link_usun_wszystkie_pytanie' => 'Czy na pewno chcesz usunąć wszystkie kategorie?',
		'drzewoKategorii.tytul_modulu_produkty' => 'Zarzadzanie kategoriami produktów',
		'drzewoKategorii.tytul_strony_ogloszenie' => 'Zarzadzanie kategoriami ogłoszeń',
		'drzewoKategorii.tytul_strony_produkt' => 'Zarzadzanie kategoriami produktów',
		'drzewoKategorii.tytul_strony_produkty' => 'Zarzadzanie kategoriami produktów',
		'drzewoKategorii.tytul_strony_usluga' => 'Zarzadzanie kategoriami usług',
		'drzewokategorii.usun_confirm_naglowek' => 'Czy napewno chcesz usunąć wybraną kategorie ?',
		'edytuj.blad_brak_kategorii' => 'Nie można pobrać danych kategorii!',
		'edytuj.blad_nie_mozna_edytowac_kategorii' => 'Nie można edytować tej kategorii!',
		'edytuj.blad_nie_mozna_zapisac_kategorii' => 'Nie można zapisać danych kategorii!',
		'edytuj.info_zapisano_dane_kategorii' => 'Sukces! Zaktualizowano dane kategorii.',
		'edytuj.tytul_strony' => 'Edycja kategorii: ',
		'email_etykieta' => 'Epost : ',
		'email_wartosc' => 'kontakt@bktas.no',
		'finalizacja.etykietaFinalizacjaCzysc' => 'Wyczyść liste produktów',
		'finalizacja.wsteczEtykieta' => 'Przejdź do wyszukiwarki',
		'finalizacjaZamowienia.zalogowany_uzytkownik_nie_istnieje' => 'Proszę zalogować sie ponownie do systemu',
		'finalizacjaZamowienia.zamowienie_zostalo_wyslane_pomyslnie' => 'Zamówienie zostało wysłane pomyślnie',
		'finalizujZamowienie.blad_zapisu_danych' => 'Wystąpił problem z zapisem zamówienia.',
		'finalizujZamowienie.brakZdjecia' => 'brak',
		'finalizujZamowienie.brak_zamowienia_do_edycji' => 'Wybrane zamówienie nie istnieje',
		'finalizujZamowienie.dane_zapisane' => 'Zamówienie zostało zapisane do systemu',
		'finalizujZamowienie.iloscLacznieEtykieta' => 'Suma ',
		'finalizujZamowienie.komunikatKoszykPusty' => 'Lista zamówionych produktów jest pusta',
		'finalizujZamowienie.koszyk_pusty_blad_formularza' => 'Koszyk jest pusty lub formularz został błędnie wypełniony.',
		'finalizujZamowienie.listaZamowionychProduktowEtykieta' => 'Lista zamówionych produktów',
		'finalizujZamowienie.produktIdEtykieta' => 'Id',
		'finalizujZamowienie.produktIloscEtykieta' => 'Ilość',
		'finalizujZamowienie.produktKodEtykieta' => 'Kod',
		'finalizujZamowienie.produktNazwaEtykieta' => 'Nazwa',
		'finalizujZamowienie.tytul_modulu' => 'Finalizacja zamówienia',
		'finalizujZamowienie.tytul_strony' => 'Finalizacja zamówienia',
		'finalizujZamowienie.usunEtykieta' => 'Usuń',
		'finalizujZamowienie.zdjecieEtykieta' => 'Zdjęcie',
		'formularz.blokujPrzypisywanie.etykieta' => 'Czy blokować możliwość przypisywania?',
		'formularz.blokujWyswietlanie.etykieta' => 'Czy blokować wyświetlanie?',
		'formularz.description.etykieta' => 'Opis (description)',
		'formularz.etykieta_powrot' => 'Powrót do listy kategorii',
		'formularz.etykieta_select_wybierz' => ' - wybierz - ',
		'formularz.filtr18.etykieta' => 'Czy zastosować filtr +18?',
		'formularz.generujDane.etykieta' => 'Kod',
		'formularz.generujDane.nazwa' => 'Generuj',
		'formularz.generujUrl.etykieta' => 'Url kategorii',
		'formularz.info_zablokowana_zmiana_filtr18' => 'Nie można zmienić statusu filtr +18 kategorii.',
		'formularz.info_zablokowana_zmiana_przypisywania' => 'Nie można zmienić statusu przypisywania kategorii.',
		'formularz.info_zablokowana_zmiana_wyswietlania' => 'Nie można zmienić statusu wyświetlania kategorii.',
		'formularz.info_znaleziono_duplakcje_url' => 'Znaleziono duplakcje url dla obiektów : %s.',
		'formularz.kod.etykieta' => 'Kod',
		'formularz.nazwa.etykieta' => 'Nazwa',
		'formularz.opiekun.etykieta' => 'Opiekun : ',
		'formularz.sciezka.etykieta' => 'Kategorie nadrzędne',
		'formularz.tagi.etykieta' => 'Tagi',
		'formularz.title.etykieta' => 'Tytuł (title)',
		'formularz.url.etykieta' => 'Url kategorii',
		'formularz.wstecz.wartosc' => 'Wstecz',
		'formularz.wybierz' => '-Wybierz-',
		'formularz.zapisz.wartosc' => 'Zapisz',
		'formularzFinalizuj.dodajGrupowo.etykieta' => 'Dodaj grupowo : ',
		'formularzFinalizuj.odbiorcaTeam.etykieta' => 'Ekipa',
		'formularzFinalizuj.odbiorcaTeamLista.etykieta' => 'Lista ekip : ',
		'formularzFinalizuj.odbiorcaUzytkownik.etykieta' => 'Pracownik',
		'formularzFinalizuj.odbiorcaUzytkownikLista.etykieta' => 'Lista pracowników : ',
		'formularzFinalizuj.opis.etykieta' => 'Notatka',
		'formularzFinalizuj.wybierzOdbiorce.etykieta' => 'Wybierz',
		'formularzFinalizuj.wydaj.etykieta' => 'Zapisz i wydaj',
		'formularzFinalizuj.zapisz.wartosc' => 'Zapisz',
		'formularzPodpis.idOsobyAkceptujacej.etykieta' => 'Wybierz pracownika do podpisu : ',
		'formularzPodpis.zapisz.wartosc' => 'Zapisz',
		'formularzProduktyDodaj.produkt.region' => 'Dodaj produkt',
		'formularzProduktyDodaj.wstecz.wartosc' => 'Anuluj',
		'formularzProduktyDodaj.zapisz.wartosc' => 'Zapisz',
		'formularzSzukaj.czysc.wartosc' => 'Czyść',
		'formularzSzukaj.fraza.etykieta' => 'Fraza : ',
		'formularzSzukaj.odbiorcaTeam.etykieta' => 'Ekipa : ',
		'formularzSzukaj.odbiorcaUzytkownik.etykieta' => 'Pracownik : ',
		'formularzSzukaj.przyjete.etykieta' => 'Reception',
		'formularzSzukaj.szukaj.wartosc' => 'Szukaj',
		'formularzSzukaj.tylkoMoje.etykieta' => 'Tylko moje zamówienia : ',
		'index.anulujZamowienieEtykieta' => 'Anuluj',
		'index.data' => 'Data',
		'index.data_dodania' => 'Data dodania',
		'index.data_wydania' => 'Data wydania',
		'index.edytujZamowienieEtykieta' => 'Edytuj',
		'index.etykieta_link_kategorie_produktow' => 'Zarzadzanie kategoriami produktów',
		'index.etykieta_link_kategorie_uslug' => 'Zarzadzanie kategoriami usług',
		'index.etykieta_link_lista_produktow' => 'Przypisz oferty',
		'index.etykieta_link_usun_wszystkie' => 'Usuń wszystkie kategorie',
		'index.etykieta_link_usun_wszystkie_pytanie' => 'Czy na pewno chcesz usunąć wszystkie kategorie?',
		'index.etykieta_produkty' => 'Produkty',
		'index.etykieta_uslugi' => 'Usługi',
		'index.filtr_po_statusie_etykieta' => 'Status : ',
		'index.id' => '#No',
		'index.id_osoby_wydajacej' => 'Osoba wydająca towar',
		'index.kartaZamowieniaPodglad' => 'Podgląd',
		'index.odbiorca' => 'Odbiorca',
		'index.opis' => 'Notatka',
		'index.podgladPdf' => 'Podgląd Pdf',
		'index.status' => 'Status',
		'index.status_anulowane' => 'Anulowane',
		'index.status_oczekuje' => 'Oczekujące',
		'index.status_wydane' => 'Wydane',
		'index.status_zaakceptowane' => 'Zaakceptowane',
		'index.tytul_modulu' => 'Magazyn',
		'index.tytul_strony' => 'Magazyn',
		'index.ustawZaakceptowaneEtykieta' => 'Ustaw jako zaakceptowane',
		'index.wszystkie' => 'Wszystkie',
		'inputRadio.team' => 'Ekipa',
		'inputRadion.uzytkownik' => 'Pracownik',
		'kartaZamowienia.blad_formularza' => 'Formularz został błędnie wypełniony',
		'kartaZamowienia.blad_zapisu_podpisu' => 'Wystąpił problem podczas zapisu zamówienia',
		'kartaZamowienia.dataEtykieta' => 'Data : ',
		'kartaZamowienia.etykietaDrukuj' => 'Drukuj',
		'kartaZamowienia.etykietaNaglowek' => 'Storage information card',
		'kartaZamowienia.from_etykieta' => 'From : ',
		'kartaZamowienia.from_miasto_firma' => '1053 Oslo',
		'kartaZamowienia.from_nazwa_firmy' => 'Bredbånd og Kabel-TV Service AS',
		'kartaZamowienia.from_ulica_firma' => ' Micheletveien 37B',
		'kartaZamowienia.iloscLacznieEtykieta' => 'Total : ',
		'kartaZamowienia.informacjeNo' => 'No.',
		'kartaZamowienia.osobaWydajacaEtykieta' => 'Storekeeper : ',
		'kartaZamowienia.pdopisane_przez' => 'Signature by : ',
		'kartaZamowienia.powrotEtykieta' => 'Wróć do listy zamówień',
		'kartaZamowienia.produktCodeEtykieta' => 'Code',
		'kartaZamowienia.produktIdEtykieta' => 'Id',
		'kartaZamowienia.produktIloscEtykieta' => 'Quantity ',
		'kartaZamowienia.produktNazwaEtykieta' => 'Name',
		'kartaZamowienia.produktStanEtykieta' => 'Condition',
		'kartaZamowienia.to_etykieta' => 'To : ',
		'kartaZamowienia.tytul' => 'Storage information card',
		'kartaZamowienia.tytul_modulu' => 'Card of issued products',
		'kartaZamowienia.tytul_strony' => 'Card of issued products',
		'kartaZamowienia.zamowienieNieIstnieje' => 'Order does not exist',
		'kartaZamowienia.zamowienie_zostalo_wydane' => 'Produkty zostały wydane pomyślnie.',
		'kartaZwrotu.etykietaDrukuj' => 'Drukuj',
		'kartaZwrotu.from_etykieta' => 'Company',	
		'kartaZwrotu.naglowek' => 'Card of products receipt',
		'kartaZwrotu.produktStanEtykieta' => 'Condition',
		'kartaZwrotu.tytul' => 'Card of products receipt',	
		'kartaZwrotu.tytul_modulu' => 'Card of products receipt',
		'kartaZwrotu.tytul_przyjecie' => 'Card of products receipt',
		'kartaZwrotu.tytul_strony' => 'Card of products receipt',
		'kartaZwrotu.wroc_do_lista_przyjec' => 'Wróć do listy',
		'kartaZwrotu.wroc_do_lista_uzytkownikow' => 'Wróć do listy',
		'listaPrzyjec.data_dodania' => 'Data',
		'listaPrzyjec.id' => '#No',
		'listaPrzyjec.id_oddajacego' => 'Osoba zwracająca',
		'listaPrzyjec.id_przyjmujacego' => 'Magazynier',
		'listaPrzyjec.podglad' => 'Podgląd',
		'listaPrzyjec.tytul_modulu' => 'Lista przyjęć/zwrotów do magazynu',
		'listaPrzyjec.tytul_strony' => 'Lista przyjęć/zwrotów do magazynu',
		'magazyn.bladEdycjiProduktu' => 'Błąd edycji produktu',
		'magazyn.czyscKoszyk' => 'Wyczyść koszyk',
		'magazyn.dodajProduktEtykieta' => 'Dodaj nowy produkt',
		'magazyn.edycja_brak_zamowienia' => 'Wybrane zamówienie nie istnieje',
		'magazyn.fraza_szukaj' => 'Szukaj',
		'magazyn.koszykEtykieta' => 'Karta produktów',
		'magazyn.koszyk_finalizuj_etykieta' => 'Finalizacja',
		'magazyn.koszyk_ilosc_etykieta' => 'Ilość',
		'magazyn.koszyk_kod_etykieta' => 'Kod',
		'magazyn.koszyk_nazwa_etykieta' => 'Nazwa',
		'magazyn.koszyk_pusty' => 'Lista jest pusta',
		'magazyn.koszyk_pusty_blad_formularza' => 'Lista jest pusta lub formularz został błędnie wypełniony',
		'magazyn.koszyk_usun_etykieta' => 'Usuń',
		'magazyn.minimalna_ilosc_znakow_informacja' => 'Proszę wprowadzić min. 3 znaki',
		'magazyn.produkty_niekompletne_etykieta' => 'Produkty niekompetne',
		'magazyn.produkty_serwis_etykieta' => 'Produkty w naprawie',
		'magazyn.szukajFrazaPlaceholder' => 'Proszę wprowadzić min. 3 znaki',
		'magazyn.tytul_modulu' => 'Magazyn',
		'magazyn.tytul_modulu_edycja' => 'Edytujesz zamówienie #{ID} pracownika {USER}',
		'magazyn.tytul_strony' => 'Magazyn',
		'magazyn.tytul_strony_edycja' => 'Edytujesz zamówienie #{ID} pracownika {USER}',
		'magazyn.znaleziono_ilosc_etykieta' => 'Ilość zanlezionych produktów : ',
		'miasto_wartosc_post' => '1053 Oslo',
		'mojeProdukty.tytul_modulu' => 'Moje produkty',
		'mojeProdukty.tytul_strony' => 'Moje produkty',
		'mojeZamowienia.tytulRegionu' => 'Moje zamówienia',
		'mojeZamowienia.tytulRegionuTeam' => 'Zamówienia mojego teamu',
		'mojeZamowienia.tytul_modulu' => 'Moje zamówienia',
		'mojeZamowienia.tytul_strony' => 'Moje zamówienia',
		'org_numer_etykieta' => 'Org. nr.',
		'org_numer_wartosc' => 'NO 999 301 789 MVA',
		'parsujPojedynczyWierszWyszukiwania.dodajDoZamowieniaEtykieta' => 'Dodaj',
		'parsujPojedynczyWierszWyszukiwania.edytujProduktEtykieta' => 'Edytuj',
		'parsujPojedynczyWierszWyszukiwania.iloscEtykieta' => 'Ilość',
		'parsujPojedynczyWierszWyszukiwania.ilosc_etykieta' => 'Ilość : ',
		'parsujPojedynczyWierszWyszukiwania.kodEtykieta' => 'Kod',
		'parsujPojedynczyWierszWyszukiwania.nazwaEtykieta' => 'Nazwa',
		'parsujPojedynczyWierszWyszukiwania.podgladGrupyEtykieta' => 'Podgląd grupy',
		'parsujPojedynczyWierszWyszukiwania.ustawJakoNaprawiony' => 'Naprawiony',
		'parsujPojedynczyWierszWyszukiwania.zapiszIloscEtykieta' => 'Zapisz ilość',
		'pobierzWynikiSzukaj.brak_wynikow_wyszukiwania' => 'Brak wyników wyszukiwania',
		'pobierzWynikiSzukaj.minimalna_ilosc_znakow_informacja' => 'Proszę wprowadzić min. 3 znaki',
		'pobierzWynikiSzukaj.sciezka_label' => 'Ścieżka : ',
		'podgladProduktu.atrybuty_produktu' => 'Atrybuty produktu : ',
		'podgladProduktu.cena' => 'Cena',
		'podgladProduktu.dodany_przez' => 'Produkt dodał : ',
		'podgladProduktu.ilosc' => 'Ilość : ',
		'podgladProduktu.kategoria' => 'Kategoria : ',
		'podgladProduktu.kod_produktu' => 'Kod produktu : ',
		'podgladProduktu.kr' => 'kr.-',
		'podgladProduktu.opiekun_produktu' => 'Opiekun produktu : ',
		'podgladProduktu.produkty_w_grupie' => 'Produkty w paczce : ',
		'podgladProduktu.status' => 'Status : ',
		'podgladProduktu.szt' => 'szt.',
		'podgladProduktu.wybrany_produkt_nie_istnieje' => 'Wybrany produkt nie istnieje w bazie',
		'podgladProduktu.zalaczniki' => 'Załączniki',
		'produktyDodaj.blad_formularza' => 'Nie wszystkie pola formularza zostały wypełnione poprawnie',
		'produktyDodaj.blad_zapisu' => 'Wystąpił problem podczas zapisu danych',
		'produktyDodaj.komunikat_dodano_produkt' => 'Nowy produkt został dodany do bazy',
		'produktyDodaj.komunikat_edycja_ok' => 'Edycja przebiegła pomyślnie',
		'produktylista.tytul_modulu' => 'Lista produktów',
		'produktylista.tytul_strony' => 'Lista produktów',
		'przyjmijTowar.komunikatTowarPrzyjety' => 'Towar został przyjęty do magaynu',
		'przyjmijTowar.koszykPusty' => 'Lista produktów jest pusta',
		'przyjmijTowar.tytul_modulu' => 'Przyjęcie towaru',
		'przyjmijTowar.tytul_strony' => 'Przyjęcie towaru',
		'select_wybierz_etykieta' => '-- wybierz --',
		'sortowanie.blad_nie_mozna_pobrac_kategorii' => 'Przekazano nieprawidlowe dane kategorii',
		'sortowanie.blad_nie_mozna_zmienic_rodzica_kategorii' => 'Nie można zmienić kategorii nadrzędnej dla sortowanej',
		'sortowanie.blad_nie_mozna_zmienic_ustawienia_kategorii' => 'Nie można zmienić ustawienia kategorii',
		'sortowanie.blad_niepelne_dane_kategorii' => 'Nieprawidlowe oznaczenia kategorii do sortowania ',
		'sortowanie.blad_nieprawidlowa_kategoria_glowna' => 'Nieprawidlowa kategoria główna',
		'sortowanie.blad_nieprawidlowe_dane_kategorii' => 'Nie można sortować tych kategorii',
		'sortowanie.blad_nieprawidlowe_dane_sasiada' => 'Blad nieprawidłowe dane sąsiada',
		'sortowanie.blad_nieprawidlowe_oznaczenie_polozenia' => 'Nieprawidlowe oznaczenie polozenia',
		'sortowanie.info_zmieniono_rodzica_kategorii' => 'Zmieniono kategorię nadrzędną dla sortowanej',
		'sortowanie.info_zmieniono_ustawienie_kategorii' => 'Zmieniono ustawienie kategorii',
		'sortowanie.tytul_modulu_produkty' => 'Sortowanie kategorii produktów',
		'sortowanie.tytul_strony_ogloszenie' => 'Zarzadzanie kategoriami ogłoszeń',
		'sortowanie.tytul_strony_produkt' => 'Zarzadzanie kategoriami produktów',
		'sortowanie.tytul_strony_produkty' => 'Sortowanie kategorii produktów',
		'sortowanie.tytul_strony_usluga' => 'Zarzadzanie kategoriami usług',
		'stanOdbiorcy.tytul_modulu' => 'Lista produktów ',
		'stanOdbiorcy.tytul_strony' => 'Lista produktów ',
		'telefon_etykieta' => 'Sentralbord : ',
		'telefon_wartosc' => '45 45 45 02',
		'ustawJakoNaprawiony.bladZapisu' => 'Nie udało się przenieść produktu do naprawionych',
		'ustawJakoNaprawiony.produktGlownyNieIstnieje' => 'Produkt główny nie istnieje',
		'ustawJakoNaprawiony.produktNieIstanieje' => 'Produkt nie istnieje',
		'ustawZaakceptowane.blad' => 'Wystąpiły błędy podczas zmiany statusu',
		'usun.blad_brak_kategorii' => 'Nie można pobrać danych kategorii',
		'usun.blad_nie_mozna_usunac_kategorii' => 'Nie można usunąć kategorii.',
		'usun.blad_nie_mozna_usunac_kategorii_glownej' => 'Nie można usunąć kategorii glownej',
		'usun.etykieta_anuluj' => 'Wstecz',
		'usun.etykieta_blad_usun' => 'Nie można usunąć kategorii gdyż zawiera ona ogłoszenia! Poniżej lista:',
		'usun.etykieta_nazwa_firmy' => 'Nazwa firmy',
		'usun.etykieta_nazwa_ogloszenia' => 'Tytuł ogłoszenia',
		'usun.etykieta_nazwa_zobacz' => 'Zobacz',
		'usun.etykieta_potwierdzenie_usun' => 'Czy napewno chcesz usunąć wybraną kategorię',
		'usun.etykieta_usun' => 'Usuń',
		'usun.info_usuniecie_kategorii' => 'Sukces! Kategoria została usunięta.',
		'usun.info_usunieto_kategorie' => 'Kategoria została usunięta',
		'usunZdjecie.blad_nie_mozna_usunac_zdjecia' => 'Błąd. Usunięcie zdjęcia nie powiodło się',
		'usunZdjecie.info_usunieto_zdjecie' => 'Zdjęcie zostało usunięte',
		'widokPracownika.alertTrescNieZaznaczono' => 'Proszę zaznaczyć przynajmniej jeden produkt',
		'widokPracownika.alertTytulNieZaznaczono' => 'Uwaga',
		'widokPracownika.data' => 'Data',
		'widokPracownika.data_dodania' => 'Data dodania',
		'widokPracownika.etykietaPrzekazProdukt' => 'Przekaż produkty',
		'widokPracownika.etykietaZwrotProduktu' => 'Zwróć do magazynu',
		'widokPracownika.id' => 'Id',
		'widokPracownika.ilosc' => 'Ilość',
		'widokPracownika.kartaProduktu' => 'Karta produktu',
		'widokPracownika.kod' => 'Kod',
		'widokPracownika.komunikat_wybierz_team_lub_pracownika' => 'Proszę wybrać ekipe lub pracownika z listy ',
		'widokPracownika.nazwa_produktu' => 'Nazwa',
		'widokPracownika.pracownik_nie_istnieje' => 'Wybrany pracownik nie został znaleziony w bazie',
		'widokPracownika.przyciskListaKartZamowien' => 'Lista kart zamówień',
		'widokPracownika.przyciskListaProduktow' => 'Lista produktów',
		'widokPracownika.przyciskZlozZamowienie' => 'Wyślij zamówienie',
		'widokPracownika.status' => 'Status',
		'widokPracownika.team_nie_istnieje' => 'Wybrana ekipa nie istnieje w naszej bazie',
		'widokPracownika.tytul_modulu' => 'Lista produktów ',
		'widokPracownika.tytul_pracownik_lista_produktow' => 'Lista produktów',
		'widokPracownika.tytul_strony' => 'Lista produktów',
		'widokPracownika.tytul_team_lista_produktow' => 'Lista produktów',
		'widokPracownika.zdjecie' => 'Zdjęcie',
		'www_etykieta' => 'www',
		'www_wartosc' => 'www.bktas.no',
		'zakladka.noweZamowienie' => 'Utwórz nowe zamówienie',
		'zakladki.finalizacja' => 'Finalizacja zamówienia',
		'zakladki.index' => 'Karty zamówień',
		'zakladki.kategorie' => 'Kategorie',
		'zakladki.kategorie_drzewo' => 'Zarządzaj kategoriami',
		'zakladki.kategorie_sortowanie' => 'Sortuj kategorie',
		'zakladki.listaPrzyjec' => 'Lista przyjęć/zwrotów',	
		'zakladki.magazyn' => 'Magazyn',
		'zakladki.mojMagazyn' => 'Mój magazyn',
		'zakladki.mojeProdukty' => 'Moje produkty',
		'zakladki.mojeZamowienia' => 'Moje zamówienia',
		'zakladki.produkty' => 'Dodaj produkt',
		'zakladki.produkty_dodaj' => 'Dodaj produkt',
		'zakladki.produkty_lista' => 'Lista produktów',
		'zakladki.przyjmij_towar' => 'Przyjęcie towaru',
		'zakladki.stanOdbiorca' => '[ETYKIETA:zakladki.stanOdbiorca]',
		'zakladki.widokPracownika' => 'Lista produktów pracowników',
		'zamowNowyProdukt.tytul_modulu' => 'Nowe zamówienie',
		'zamowNowyProdukt.tytul_strony' => 'Nowe zamówienie',
		'zatwierdzZwrotProduktow.infoPrzekazProdukt' => 'Zostało utworzone nowe zamówienie w systemie dla <strong>{NAZWA}</strong>, możesz je prezglądnąć klikając w <a href="{LINK}"><strong>link</strong></a> , lub przechodząc do zakładki Magazyn wydane',
		'zatwierdzZwrotProduktow.infoWymienProdukt' => 'Zostało utworzone nowe zamówienie w systemie dla <strong>{NAZWA}</strong>, możesz je prezglądnąć klikając w <a href="{LINK}"><strong>link</strong></a> , lub przechodząc do zakładki Magazyn wydane',
		'zatwierdzZwrotProduktow.tytul_modulu' => 'Zwrot produktów',
		'zatwierdzZwrotProduktow.tytul_strony' => 'Zwrot produktów',
		'zatwierdzZwrotProduktow.wystapilyBledyPodczasZwrotu' => 'Wystąpiły błędy podczas zapisu w bazie produktów do zwrotu.',
		'zlozZamowienie.tytul_modulu' => 'Nowe zamówienie',
		'zlozZamowienie.tytul_strony' => 'Nowe zamówienie',
		'znaczek_rozdziel' => '/',
		'zwrocProdukty.etykietaZatwierdzZwrot' => 'Zwróć produkty do magazynu',
		'zwrocProdukty.iloscEtykieta' => 'Ilość',
		'zwrocProdukty.kodEtykieta' => 'Kod',
		'zwrocProdukty.nazwaEtykieta' => 'Nazwa',
		'zwrocProdukty.nieWybranoProduktowDoZwrotu' => 'Nie wybrano produktów do zwrotu',
		'zwrocProdukty.opisEtykieta' => 'Opis',
		'zwrocProdukty.powrotDoListaProduktowEtykieta' => 'Wróć do listy produktów',
		'zwrocProdukty.pracownik_nie_istnieje' => 'Nie znaleziono pracownika w bazie',
		'zwrocProdukty.produktPrzeniesionyDoGrupyNieplene' => 'Produkt został przeniesiony do grupy produktów niepełnych',
		'zwrocProdukty.produktPrzeniesionyDoGrupySerwis' => 'Produkt został przeniesiony do grupy produktów do naprawy',
		'zwrocProdukty.przekazEtykieta' => 'Przekaż produkty',
		'zwrocProdukty.przekazLabel' => 'Przekaż innemu pracownikowi',
		'zwrocProdukty.przekazLabel_pracownik' => 'Przekaż produkty do : ',
		'zwrocProdukty.przekazLabel_team' => 'Przekaż produkty do : ',
		'zwrocProdukty.statusEtykieta' => 'Status',
		'zwrocProdukty.team_nie_istnieje' => 'Ekipa nie została znaleziona w bazie',
		'zwrocProdukty.tytul_modulu' => 'Zwrot produktów',
		'zwrocProdukty.tytul_strony' => 'Zwrot produktów',
		'zwrocProdukty.wybraneProduktyNieZostalyZnalezione' => 'Produkt nie został znaleziony w bazie',
		'zwrocProdukty.wymienEtykieta' => 'Wymień na nowy',
		'zwrocProdukty.zdjecieEtykieta' => 'Zdjęcie',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Product storage',
			'wykonajDrzewoKategorii' => 'Grzewo kategorii',
			'wykonajDodaj' => 'Dodaj kategorie',
			'wykonajSortowanie' => 'Sortowanie kategorii',
			'wykonajEdytuj' => 'Edycja kategorii',
			'wykonajUsun' => 'Usuń kategorie',
			'wykonajMagazyn' => 'Magazyn produktów',
			'wykonajProduktyLista' => 'Lista produktów',
			'wykonajProduktyDodaj' => 'Dodawanie produktów',
		),
		'_zdarzenia_etykiety_' => array(
			'dodano_kategorie' => 'Dodano kategorię',
			'edytowano_kategorie' => 'Zmieniono kategorię',
			'usunieto_kategorie' => 'Usunięto kategorię',
			'usunieto_wszystkie_kategorie_z_glownej' => 'Usunięto wszystkie kategorie z kategorii głównej',
			'usunieto_dane_kategorii' => 'Usunieto dane kategorii',
			'zmieniono_kategorie_ogloszenia' => 'Zmieniono kategorię ogłoszenia',
		),
		'data_dodania_opcje' => array(
			'7' => 'Ostatni tydzień',
			'14' => 'Ostatnie dwa tygodnie',
			'31' => 'Ostatni miesiąc',
			'93' => 'Ostatne trzy miesiące',
			'183' => 'Ostatne pół roku',
		),
		'uprawnienia_atrybuty_produktu' => array(
			'publiczne' => 'Publiczne',
			'wlasciciel_grupy' => 'Właściciel grupy produktów',
			'uzytkownik' => 'Użytkownik',
			'osoba_wydajaca' => 'Osoba wydająca towar',
			'osoba_dodajaca_produkt' => 'Osoba dodająca produkt',
			'pracownik_biurowy' => 'Pracownik biurowy',
		),
		'zwrocProdukty.stan_produktu' => array(
			'nowy' => 'Brend new',
			'uzywany' => 'Used',
			'zniszczone_uzytkownik' => 'Damaged by user',
			'kosz' => 'Not fit to be used.',
			'zgubiony' => 'Lost',
			'serwis' => 'To repair',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}