<?php
namespace Generic\Tlumaczenie\No\Modul\Magazyn;

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
 * @property string $t['drzewoKategorii.tytul_strony_produkty']
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
 * @property string $t['index.etykieta_link_lista_produktow']
 * @property string $t['index.etykieta_link_usun_wszystkie']
 * @property string $t['index.etykieta_link_usun_wszystkie_pytanie']
 * @property string $t['index.etykieta_produkty']
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
 * @property string $t['listaKartZamowienPracownika.tytul_modulu']
 * @property string $t['listaKartZamowienPracownika.tytul_strony']
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
 * @property string $t['sortowanie.tytul_strony_produkt']
 * @property string $t['sortowanie.tytul_strony_produkty']
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
 * @property string $t['uprawnienia_atrybuty_produktu']['uzytkownik']
 * @property string $t['uprawnienia_atrybuty_produktu']['wlasciciel_grupy']
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
		'anulujZamowienie.blad' => 'Error change status to canceled',
		'bankgiro_etykieta' => 'BANKGIRO',
		'bankgiro_wartosc' => '1503 32 27407',
		'dodaj.blad_brak_kategorii_nadrzednej' => 'Ikke spesifisert ordnede kategorien!',
		'dodaj.blad_duplikacja_kategorii' => 'Du kan ikke lagre data kategori - kategorinavnet duplisert!',
		'dodaj.blad_kod_zajety' => 'Den valgte koden er allerede tatt!',
		'dodaj.blad_nie_mozna_zapisac_kategorii' => 'Du kan ikke lagre data kategori!',
		'dodaj.info_zapisano_dane_kategorii' => 'En ny kategori har blitt lagt',
		'dodaj.tytul_strony' => 'ny kategori',
		'dodajDoZamowienia.ilosc_za_duza' => 'Antallet er for høy',
		'dodajDoZamowienia.nie_przekazano_wszystkich_parametrow' => 'Feil data å legge produkter',
		'dodajDoZamowienia.produkt_nie_istnieje' => 'Produktet finnes ikke',
		'dodajProdukty.grupaRoznaOdBazowej' => '[ETYKIETA:dodajProdukty.grupaRoznaOdBazowej]',	//TODO
		'dodajProdukty.niekompletnyProduktDodanyDoBazowego' => '[ETYKIETA:dodajProdukty.niekompletnyProduktDodanyDoBazowego]',	//TODO
		'dodajProdukty.sugerowane_produkty_w_grupie' => '[ETYKIETA:dodajProdukty.sugerowane_produkty_w_grupie]',	//TODO
		'dodajprodukt.bladIlosciWgrupieProduktow' => '[ETYKIETA:dodajprodukt.bladIlosciWgrupieProduktow]',	//TODO
		'dodajprodukt.tytul_modulu' => 'Legg produkt',
		'dodajprodukt.tytul_strony' => 'Legg produkt',
		'drzewoKategorii.blad_nieprawidlowa_kategoria_glowna' => 'Ugyldig hovedkategori',
		'drzewoKategorii.etykieta_link_sortowanie' => 'Sorteringskategori',
		'drzewoKategorii.etykieta_link_usun_pytanie' => 'Er du sikker på at du vil slette denne kategorien og alle underkategori?',
		'drzewoKategorii.etykieta_link_usun_wszystkie' => 'Fjern alle kategorier',
		'drzewoKategorii.etykieta_link_usun_wszystkie_pytanie' => 'Er du sikker på at du vil slette alle kategorier?',
		'drzewoKategorii.tytul_modulu_produkty' => 'Kategori ledelse',
		'drzewoKategorii.tytul_strony_produkty' => 'Kategori ledelse',
		'drzewokategorii.usun_confirm_naglowek' => 'Er du sikker på at du vil fjerne de markerte kategoriene?',
		'edytuj.blad_brak_kategorii' => 'Kan ikke hente kategorien!',
		'edytuj.blad_nie_mozna_edytowac_kategorii' => 'Du kan ikke redigere denne kategorien!',
		'edytuj.blad_nie_mozna_zapisac_kategorii' => 'Du kan ikke redigere denne kategorien!',
		'edytuj.info_zapisano_dane_kategorii' => 'Redigerer var vellykket',
		'edytuj.tytul_strony' => 'Rediger kategori',
		'email_etykieta' => 'Epost : ',
		'email_wartosc' => 'kontakt@bktas.no',
		'finalizacja.etykietaFinalizacjaCzysc' => 'Clear produktliste',
		'finalizacja.wsteczEtykieta' => 'Tilbake til produktlistet',
		'finalizacjaZamowienia.zalogowany_uzytkownik_nie_istnieje' => '[ETYKIETA:finalizacjaZamowienia.zalogowany_uzytkownik_nie_istnieje]',	//TODO
		'finalizacjaZamowienia.zamowienie_zostalo_wyslane_pomyslnie' => '[ETYKIETA:finalizacjaZamowienia.zamowienie_zostalo_wyslane_pomyslnie]',	//TODO
		'finalizujZamowienie.blad_zapisu_danych' => 'Data skrivefeil',
		'finalizujZamowienie.brakZdjecia' => 'ingen foto',
		'finalizujZamowienie.brak_zamowienia_do_edycji' => 'Bestill eksisterer ikke',
		'finalizujZamowienie.dane_zapisane' => 'Data spare vellykket',
		'finalizujZamowienie.iloscLacznieEtykieta' => 'Total',
		'finalizujZamowienie.komunikatKoszykPusty' => '[ETYKIETA:finalizujZamowienie.komunikatKoszykPusty]',	//TODO
		'finalizujZamowienie.koszyk_pusty_blad_formularza' => 'Produktliste er tom eller form ble feilaktig fylt.',
		'finalizujZamowienie.listaZamowionychProduktowEtykieta' => 'Liste over produkter',
		'finalizujZamowienie.produktIdEtykieta' => 'Id',
		'finalizujZamowienie.produktIloscEtykieta' => 'Mengde',
		'finalizujZamowienie.produktKodEtykieta' => 'Kode',
		'finalizujZamowienie.produktNazwaEtykieta' => 'Navn',
		'finalizujZamowienie.tytul_modulu' => 'Oppsummering tatt produkter',
		'finalizujZamowienie.tytul_strony' => 'Oppsummering tatt produkter',
		'finalizujZamowienie.usunEtykieta' => 'Slett',
		'finalizujZamowienie.zdjecieEtykieta' => 'Bilde',
		'formularz.blokujPrzypisywanie.etykieta' => 'Blokkere muligheten til å tildele?',
		'formularz.blokujWyswietlanie.etykieta' => 'Block skjerm?',
		'formularz.description.etykieta' => 'Beskrivelse',
		'formularz.etykieta_powrot' => 'Tilbake til kategorilisten',
		'formularz.etykieta_select_wybierz' => ' - velge - ',
		'formularz.filtr18.etykieta' => 'Czy zastosować filtr +18?',
		'formularz.generujDane.etykieta' => 'Kode',
		'formularz.generujDane.nazwa' => 'Generere',
		'formularz.generujUrl.etykieta' => 'Url kategorii',
		'formularz.info_zablokowana_zmiana_filtr18' => 'Nie można zmienić statusu filtr +18 kategorii.',
		'formularz.info_zablokowana_zmiana_przypisywania' => 'Du kan ikke endre status for tildeling av kategorier.',
		'formularz.info_zablokowana_zmiana_wyswietlania' => 'Du kan ikke endre status for tildeling av kategorier.',
		'formularz.info_znaleziono_duplakcje_url' => 'Znaleziono duplakcje url dla obiektów : %s.',
		'formularz.kod.etykieta' => 'Kode',
		'formularz.nazwa.etykieta' => 'Navn',
		'formularz.opiekun.etykieta' => 'Keeper : ',
		'formularz.sciezka.etykieta' => 'Kategorier ordnede',
		'formularz.tagi.etykieta' => 'Tagi',
		'formularz.title.etykieta' => 'Tytuł (title)',
		'formularz.url.etykieta' => 'Url kategorii',
		'formularz.wstecz.wartosc' => 'Back',
		'formularz.wybierz' => '-select-',
		'formularz.zapisz.wartosc' => 'Spare',
		'formularzFinalizuj.dodajGrupowo.etykieta' => 'Legg for gruppen: ',
		'formularzFinalizuj.odbiorcaTeam.etykieta' => 'Team',
		'formularzFinalizuj.odbiorcaTeamLista.etykieta' => 'Team liste : ',
		'formularzFinalizuj.odbiorcaUzytkownik.etykieta' => 'Bruker',
		'formularzFinalizuj.odbiorcaUzytkownikLista.etykieta' => 'Bruker liste : ',
		'formularzFinalizuj.opis.etykieta' => 'Beskrivelse',
		'formularzFinalizuj.wybierzOdbiorce.etykieta' => 'Velge',
		'formularzFinalizuj.wydaj.etykieta' => 'Lagre og utstede',
		'formularzFinalizuj.zapisz.wartosc' => 'Spare',
		'formularzPodpis.idOsobyAkceptujacej.etykieta' => 'Velg bruker til signatur : ',
		'formularzPodpis.zapisz.wartosc' => 'Spare',
		'formularzProduktyDodaj.produkt.region' => 'Legg produkt',
		'formularzProduktyDodaj.wstecz.wartosc' => 'Kansellere',
		'formularzProduktyDodaj.zapisz.wartosc' => 'Spare',
		'formularzSzukaj.czysc.wartosc' => 'Klar',
		'formularzSzukaj.fraza.etykieta' => 'Fraze : ',
		'formularzSzukaj.odbiorcaTeam.etykieta' => 'Team : ',
		'formularzSzukaj.odbiorcaUzytkownik.etykieta' => 'Bruker : ',
		'formularzSzukaj.przyjete.etykieta' => 'Reception',
		'formularzSzukaj.szukaj.wartosc' => 'Søke',
		'formularzSzukaj.tylkoMoje.etykieta' => 'Only my order : ',
		'index.anulujZamowienieEtykieta' => 'Klar',
		'index.data' => 'Data',
		'index.data_dodania' => '[ETYKIETA:index.data_dodania]',	//TODO
		'index.data_wydania' => '[ETYKIETA:index.data_wydania]',	//TODO
		'index.edytujZamowienieEtykieta' => 'Redigere',
		'index.etykieta_link_kategorie_produktow' => 'Kategori ledelse',
		'index.etykieta_link_lista_produktow' => 'Tildele tilbud',
		'index.etykieta_link_usun_wszystkie' => 'Delete all categories',
		'index.etykieta_link_usun_wszystkie_pytanie' => 'Are you sure you want to delete all categories?',
		'index.etykieta_produkty' => 'Produkter',
		'index.filtr_po_statusie_etykieta' => 'Filtrer etter status: ',
		'index.id' => '#id',
		'index.id_osoby_wydajacej' => '[ETYKIETA:index.id_osoby_wydajacej]',	//TODO
		'index.kartaZamowieniaPodglad' => 'Ferdig / Preview',
		'index.odbiorca' => 'Mottaker',
		'index.opis' => 'Beskrivelse',
		'index.podgladPdf' => 'Forhåndsvisning Pdf',
		'index.status' => 'Status',
		'index.status_anulowane' => 'avbrutt',
		'index.status_oczekuje' => 'Venter på aksepterer',
		'index.status_wydane' => 'Ferdig',
		'index.status_zaakceptowane' => 'Akseptert',
		'index.tytul_modulu' => 'Lagring',
		'index.tytul_strony' => 'Lagring',
		'index.ustawZaakceptowaneEtykieta' => 'Sett som aksepterer',
		'index.wszystkie' => 'Alle',
		'inputRadio.team' => 'Bil',
		'inputRadion.uzytkownik' => 'Bruker',
		'kartaZamowienia.blad_formularza' => 'Skjemaet ble fylt feil',
		'kartaZamowienia.blad_zapisu_podpisu' => 'Data skrivefeil',
		'kartaZamowienia.dataEtykieta' => 'Date : ',
		'kartaZamowienia.etykietaDrukuj' => 'Skriv ut',
		'kartaZamowienia.etykietaNaglowek' => 'Card of issued products',
		'kartaZamowienia.from_etykieta' => 'From : ',
		'kartaZamowienia.from_miasto_firma' => '1053 Oslo',
		'kartaZamowienia.from_nazwa_firmy' => 'Bredbånd og Kabel-TV Service AS',
		'kartaZamowienia.from_ulica_firma' => ' Micheletveien 37B',
		'kartaZamowienia.iloscLacznieEtykieta' => 'Total',
		'kartaZamowienia.informacjeNo' => 'No.',
		'kartaZamowienia.osobaWydajacaEtykieta' => '[ETYKIETA:kartaZamowienia.osobaWydajacaEtykieta]',	//TODO
		'kartaZamowienia.pdopisane_przez' => 'Signature by : ',
		'kartaZamowienia.powrotEtykieta' => '[ETYKIETA:kartaZamowienia.powrotEtykieta]',	//TODO
		'kartaZamowienia.produktCodeEtykieta' => 'Code',
		'kartaZamowienia.produktIdEtykieta' => 'Id',
		'kartaZamowienia.produktIloscEtykieta' => 'Quantity',
		'kartaZamowienia.produktNazwaEtykieta' => 'Name',
		'kartaZamowienia.produktStanEtykieta' => '[ETYKIETA:kartaZamowienia.produktStanEtykieta]',	//TODO
		'kartaZamowienia.to_etykieta' => 'To : ',
		'kartaZamowienia.tytul' => 'Storage information card',
		'kartaZamowienia.tytul_modulu' => 'Kortet utstedte produkter',
		'kartaZamowienia.tytul_strony' => 'Kortet utstedte produkter',
		'kartaZamowienia.zamowienieNieIstnieje' => '[ETYKIETA:kartaZamowienia.zamowienieNieIstnieje]',	//TODO
		'kartaZamowienia.zamowienie_zostalo_wydane' => '[ETYKIETA:kartaZamowienia.zamowienie_zostalo_wydane]',	//TODO
		'kartaZwrotu.etykietaDrukuj' => '[ETYKIETA:kartaZwrotu.etykietaDrukuj]',	//TODO
		'kartaZwrotu.from_etykieta' => '[ETYKIETA:kartaZwrotu.from_etykieta]',	//TODO
		'kartaZwrotu.naglowek' => '[ETYKIETA:kartaZwrotu.naglowek]',	//TODO
		'kartaZwrotu.produktStanEtykieta' => '[ETYKIETA:kartaZwrotu.produktStanEtykieta]',	//TODO
		'kartaZwrotu.tytul' => '[ETYKIETA:kartaZwrotu.tytul]',	//TODO
		'kartaZwrotu.tytul_modulu' => '[ETYKIETA:kartaZwrotu.tytul_modulu]',	//TODO
		'kartaZwrotu.tytul_przyjecie' => '[ETYKIETA:kartaZwrotu.tytul_przyjecie]',	//TODO
		'kartaZwrotu.tytul_strony' => '[ETYKIETA:kartaZwrotu.tytul_strony]',	//TODO
		'kartaZwrotu.wroc_do_lista_przyjec' => '[ETYKIETA:kartaZwrotu.wroc_do_lista_przyjec]',	//TODO
		'kartaZwrotu.wroc_do_lista_uzytkownikow' => '[ETYKIETA:kartaZwrotu.wroc_do_lista_uzytkownikow]',	//TODO
		'listaKartZamowienPracownika.tytul_modulu' => '[ETYKIETA:listaKartZamowienPracownika.tytul_modulu]',	//TODO
		'listaKartZamowienPracownika.tytul_strony' => '[ETYKIETA:listaKartZamowienPracownika.tytul_strony]',	//TODO
		'listaPrzyjec.data_dodania' => '[ETYKIETA:listaPrzyjec.data_dodania]',	//TODO
		'listaPrzyjec.id' => '[ETYKIETA:listaPrzyjec.id]',	//TODO
		'listaPrzyjec.id_oddajacego' => '[ETYKIETA:listaPrzyjec.id_oddajacego]',	//TODO
		'listaPrzyjec.id_przyjmujacego' => '[ETYKIETA:listaPrzyjec.id_przyjmujacego]',	//TODO
		'listaPrzyjec.podglad' => '[ETYKIETA:listaPrzyjec.podglad]',	//TODO
		'listaPrzyjec.tytul_modulu' => '[ETYKIETA:listaPrzyjec.tytul_modulu]',	//TODO
		'listaPrzyjec.tytul_strony' => '[ETYKIETA:listaPrzyjec.tytul_strony]',	//TODO
		'magazyn.bladEdycjiProduktu' => 'Feil redigering produkt',
		'magazyn.czyscKoszyk' => 'Klar',
		'magazyn.dodajProduktEtykieta' => '[ETYKIETA:magazyn.dodajProduktEtykieta]',	//TODO
		'magazyn.edycja_brak_zamowienia' => 'Bestill eksisterer ikke',
		'magazyn.fraza_szukaj' => 'Søke ',
		'magazyn.koszykEtykieta' => 'CART',
		'magazyn.koszyk_finalizuj_etykieta' => 'Ferdig',
		'magazyn.koszyk_ilosc_etykieta' => 'Mengde',
		'magazyn.koszyk_kod_etykieta' => 'Kode',
		'magazyn.koszyk_nazwa_etykieta' => 'Produktnavn',
		'magazyn.koszyk_pusty' => 'Liste over bestille produkter er tom',
		'magazyn.koszyk_pusty_blad_formularza' => 'Produktliste er tom eller form ble fylt feil',
		'magazyn.koszyk_usun_etykieta' => 'Slett',
		'magazyn.minimalna_ilosc_znakow_informacja' => 'Skriv inn minst 3 tegn',
		'magazyn.produkty_niekompletne_etykieta' => '[ETYKIETA:magazyn.produkty_niekompletne_etykieta]',	//TODO
		'magazyn.produkty_serwis_etykieta' => '[ETYKIETA:magazyn.produkty_serwis_etykieta]',	//TODO
		'magazyn.szukajFrazaPlaceholder' => 'Enter at least 3 characters',
		'magazyn.tytul_modulu' => 'Lagring',
		'magazyn.tytul_modulu_edycja' => 'Edit order #{ID} for {USER}',
		'magazyn.tytul_strony' => 'Storage',
		'magazyn.tytul_strony_edycja' => 'Edit order #{ID} for {USER}',
		'magazyn.znaleziono_ilosc_etykieta' => 'Products found : ',
		'miasto_wartosc_post' => '1053 Oslo',
		'mojeProdukty.tytul_modulu' => '[ETYKIETA:mojeProdukty.tytul_modulu]',	//TODO
		'mojeProdukty.tytul_strony' => '[ETYKIETA:mojeProdukty.tytul_strony]',	//TODO
		'mojeZamowienia.tytulRegionu' => '[ETYKIETA:mojeZamowienia.tytulRegionu]',	//TODO
		'mojeZamowienia.tytulRegionuTeam' => '[ETYKIETA:mojeZamowienia.tytulRegionuTeam]',	//TODO
		'mojeZamowienia.tytul_modulu' => '[ETYKIETA:mojeZamowienia.tytul_modulu]',	//TODO
		'mojeZamowienia.tytul_strony' => '[ETYKIETA:mojeZamowienia.tytul_strony]',	//TODO
		'org_numer_etykieta' => 'Org. nr.',
		'org_numer_wartosc' => 'NO 999 301 789 MVA',
		'parsujPojedynczyWierszWyszukiwania.dodajDoZamowieniaEtykieta' => 'Add too product list',
		'parsujPojedynczyWierszWyszukiwania.edytujProduktEtykieta' => 'Edit product',
		'parsujPojedynczyWierszWyszukiwania.iloscEtykieta' => 'Quantity',
		'parsujPojedynczyWierszWyszukiwania.ilosc_etykieta' => 'Quantity',
		'parsujPojedynczyWierszWyszukiwania.kodEtykieta' => 'Kod',
		'parsujPojedynczyWierszWyszukiwania.nazwaEtykieta' => '[ETYKIETA:parsujPojedynczyWierszWyszukiwania.nazwaEtykieta]',	//TODO
		'parsujPojedynczyWierszWyszukiwania.podgladGrupyEtykieta' => '[ETYKIETA:parsujPojedynczyWierszWyszukiwania.podgladGrupyEtykieta]',	//TODO
		'parsujPojedynczyWierszWyszukiwania.ustawJakoNaprawiony' => '[ETYKIETA:parsujPojedynczyWierszWyszukiwania.ustawJakoNaprawiony]',	//TODO
		'parsujPojedynczyWierszWyszukiwania.zapiszIloscEtykieta' => '[ETYKIETA:parsujPojedynczyWierszWyszukiwania.zapiszIloscEtykieta]',	//TODO
		'pobierzWynikiSzukaj.brak_wynikow_wyszukiwania' => 'No search results',
		'pobierzWynikiSzukaj.minimalna_ilosc_znakow_informacja' => 'Enter at least 3 characters',
		'pobierzWynikiSzukaj.sciezka_label' => 'Category path : ',
		'podgladProduktu.atrybuty_produktu' => '[ETYKIETA:podgladProduktu.atrybuty_produktu]',	//TODO
		'podgladProduktu.cena' => '[ETYKIETA:podgladProduktu.cena]',	//TODO
		'podgladProduktu.dodany_przez' => '[ETYKIETA:podgladProduktu.dodany_przez]',	//TODO
		'podgladProduktu.ilosc' => '[ETYKIETA:podgladProduktu.ilosc]',	//TODO
		'podgladProduktu.kategoria' => '[ETYKIETA:podgladProduktu.kategoria]',	//TODO
		'podgladProduktu.kod_produktu' => '[ETYKIETA:podgladProduktu.kod_produktu]',	//TODO
		'podgladProduktu.kr' => '[ETYKIETA:podgladProduktu.kr]',	//TODO
		'podgladProduktu.opiekun_produktu' => '[ETYKIETA:podgladProduktu.opiekun_produktu]',	//TODO
		'podgladProduktu.produkty_w_grupie' => '[ETYKIETA:podgladProduktu.produkty_w_grupie]',	//TODO
		'podgladProduktu.status' => '[ETYKIETA:podgladProduktu.status]',	//TODO
		'podgladProduktu.szt' => '[ETYKIETA:podgladProduktu.szt]',	//TODO
		'podgladProduktu.wybrany_produkt_nie_istnieje' => '[ETYKIETA:podgladProduktu.wybrany_produkt_nie_istnieje]',	//TODO
		'podgladProduktu.zalaczniki' => '[ETYKIETA:podgladProduktu.zalaczniki]',	//TODO
		'produktyDodaj.blad_formularza' => 'The form was filled incorrectly',
		'produktyDodaj.blad_zapisu' => 'Data write error',
		'produktyDodaj.komunikat_dodano_produkt' => 'The product has been successfully saved',
		'produktyDodaj.komunikat_edycja_ok' => 'Product edition was successful',
		'produktylista.tytul_modulu' => 'List of products',
		'produktylista.tytul_strony' => 'list of products',
		'przyjmijTowar.komunikatTowarPrzyjety' => '[ETYKIETA:przyjmijTowar.komunikatTowarPrzyjety]',	//TODO
		'przyjmijTowar.koszykPusty' => '[ETYKIETA:przyjmijTowar.koszykPusty]',	//TODO
		'przyjmijTowar.tytul_modulu' => '[ETYKIETA:przyjmijTowar.tytul_modulu]',	//TODO
		'przyjmijTowar.tytul_strony' => '[ETYKIETA:przyjmijTowar.tytul_strony]',	//TODO
		'select_wybierz_etykieta' => '-- select -- ',
		'sortowanie.blad_nie_mozna_pobrac_kategorii' => 'Wrong data of category',
		'sortowanie.blad_nie_mozna_zmienic_rodzica_kategorii' => 'You can not change the parent category for sorted category',
		'sortowanie.blad_nie_mozna_zmienic_ustawienia_kategorii' => 'You can not change the category',
		'sortowanie.blad_niepelne_dane_kategorii' => 'Incorrect mark a category for sorting ',
		'sortowanie.blad_nieprawidlowa_kategoria_glowna' => 'Invalid main category',
		'sortowanie.blad_nieprawidlowe_dane_kategorii' => 'You can not sort these categories',
		'sortowanie.blad_nieprawidlowe_dane_sasiada' => 'Error invalid data neighbor category tree',
		'sortowanie.blad_nieprawidlowe_oznaczenie_polozenia' => 'False position',
		'sortowanie.info_zmieniono_rodzica_kategorii' => 'Changed the parent category for sorted category',
		'sortowanie.info_zmieniono_ustawienie_kategorii' => 'Changed category setting',
		'sortowanie.tytul_modulu_produkty' => 'Category management',
		'sortowanie.tytul_strony_produkt' => 'Category management',
		'sortowanie.tytul_strony_produkty' => 'Category management',
		'stanOdbiorcy.tytul_modulu' => '[ETYKIETA:stanOdbiorcy.tytul_modulu]',	//TODO
		'stanOdbiorcy.tytul_strony' => '[ETYKIETA:stanOdbiorcy.tytul_strony]',	//TODO
		'telefon_etykieta' => 'Sentralbord : ',
		'telefon_wartosc' => '45 45 45 02',
		'ustawJakoNaprawiony.bladZapisu' => '[ETYKIETA:ustawJakoNaprawiony.bladZapisu]',	//TODO
		'ustawJakoNaprawiony.produktGlownyNieIstnieje' => '[ETYKIETA:ustawJakoNaprawiony.produktGlownyNieIstnieje]',	//TODO
		'ustawJakoNaprawiony.produktNieIstanieje' => '[ETYKIETA:ustawJakoNaprawiony.produktNieIstanieje]',	//TODO
		'ustawZaakceptowane.blad' => 'Error change status',
		'usun.blad_brak_kategorii' => 'Unable to retrieve category',
		'usun.blad_nie_mozna_usunac_kategorii' => 'You can not delete this category.',
		'usun.blad_nie_mozna_usunac_kategorii_glownej' => 'You can not delete main category.',
		'usun.etykieta_anuluj' => 'Delete',
		'usun.etykieta_blad_usun' => 'You can not delete category because this category includes products! Below is a list:',
		'usun.etykieta_nazwa_firmy' => 'Company name',
		'usun.etykieta_nazwa_ogloszenia' => 'Delete',
		'usun.etykieta_nazwa_zobacz' => 'Preview',
		'usun.etykieta_potwierdzenie_usun' => 'Are you sure you want to remove the selected category',
		'usun.etykieta_usun' => 'Delete',
		'usun.info_usuniecie_kategorii' => 'Category was deleted.',
		'usun.info_usunieto_kategorie' => 'Category was deleted',
		'usunZdjecie.blad_nie_mozna_usunac_zdjecia' => 'Error delete photo',
		'usunZdjecie.info_usunieto_zdjecie' => 'Photo was removed successfully',
		'widokPracownika.alertTrescNieZaznaczono' => '[ETYKIETA:widokPracownika.alertTrescNieZaznaczono]',	//TODO
		'widokPracownika.alertTytulNieZaznaczono' => '[ETYKIETA:widokPracownika.alertTytulNieZaznaczono]',	//TODO
		'widokPracownika.data' => '[ETYKIETA:widokPracownika.data]',	//TODO
		'widokPracownika.data_dodania' => '[ETYKIETA:widokPracownika.data_dodania]',	//TODO
		'widokPracownika.etykietaPrzekazProdukt' => '[ETYKIETA:widokPracownika.etykietaPrzekazProdukt]',	//TODO
		'widokPracownika.etykietaZwrotProduktu' => '[ETYKIETA:widokPracownika.etykietaZwrotProduktu]',	//TODO
		'widokPracownika.id' => '[ETYKIETA:widokPracownika.id]',	//TODO
		'widokPracownika.ilosc' => '[ETYKIETA:widokPracownika.ilosc]',	//TODO
		'widokPracownika.kartaProduktu' => '[ETYKIETA:widokPracownika.kartaProduktu]',	//TODO
		'widokPracownika.kod' => '[ETYKIETA:widokPracownika.kod]',	//TODO
		'widokPracownika.komunikat_wybierz_team_lub_pracownika' => '[ETYKIETA:widokPracownika.komunikat_wybierz_team_lub_pracownika]',	//TODO
		'widokPracownika.nazwa_produktu' => '[ETYKIETA:widokPracownika.nazwa_produktu]',	//TODO
		'widokPracownika.pracownik_nie_istnieje' => '[ETYKIETA:widokPracownika.pracownik_nie_istnieje]',	//TODO
		'widokPracownika.przyciskListaKartZamowien' => '[ETYKIETA:widokPracownika.przyciskListaKartZamowien]',	//TODO
		'widokPracownika.przyciskListaProduktow' => '[ETYKIETA:widokPracownika.przyciskListaProduktow]',	//TODO
		'widokPracownika.przyciskZlozZamowienie' => '[ETYKIETA:widokPracownika.przyciskZlozZamowienie]',	//TODO
		'widokPracownika.status' => '[ETYKIETA:widokPracownika.status]',	//TODO
		'widokPracownika.team_nie_istnieje' => '[ETYKIETA:widokPracownika.team_nie_istnieje]',	//TODO
		'widokPracownika.tytul_modulu' => '[ETYKIETA:widokPracownika.tytul_modulu]',	//TODO
		'widokPracownika.tytul_pracownik_lista_produktow' => '[ETYKIETA:widokPracownika.tytul_pracownik_lista_produktow]',	//TODO
		'widokPracownika.tytul_strony' => '[ETYKIETA:widokPracownika.tytul_strony]',	//TODO
		'widokPracownika.tytul_team_lista_produktow' => '[ETYKIETA:widokPracownika.tytul_team_lista_produktow]',	//TODO
		'widokPracownika.zdjecie' => '[ETYKIETA:widokPracownika.zdjecie]',	//TODO
		'www_etykieta' => 'www',
		'www_wartosc' => 'www.bktas.no',
		'zakladka.noweZamowienie' => '[ETYKIETA:zakladka.noweZamowienie]',	//TODO
		'zakladki.finalizacja' => 'Summary taken products',
		'zakladki.index' => 'List of issued products',
		'zakladki.kategorie' => 'Category',
		'zakladki.kategorie_drzewo' => 'Menage category',
		'zakladki.kategorie_sortowanie' => 'Sort category',
		'zakladki.listaPrzyjec' => '[ETYKIETA:zakladki.listaPrzyjec]',	//TODO
		'zakladki.magazyn' => 'Products storage',
		'zakladki.mojMagazyn' => '[ETYKIETA:zakladki.mojMagazyn]',	//TODO
		'zakladki.mojeProdukty' => '[ETYKIETA:zakladki.mojeProdukty]',	//TODO
		'zakladki.mojeZamowienia' => '[ETYKIETA:zakladki.mojeZamowienia]',	//TODO
		'zakladki.produkty' => 'Add products',
		'zakladki.produkty_dodaj' => 'Add product',
		'zakladki.produkty_lista' => 'List of products',
		'zakladki.przyjmij_towar' => '[ETYKIETA:zakladki.przyjmij_towar]',	//TODO
		'zakladki.stanOdbiorca' => '[ETYKIETA:zakladki.stanOdbiorca]',	//TODO
		'zakladki.widokPracownika' => '[ETYKIETA:zakladki.widokPracownika]',	//TODO
		'zamowNowyProdukt.tytul_modulu' => '[ETYKIETA:zamowNowyProdukt.tytul_modulu]',	//TODO
		'zamowNowyProdukt.tytul_strony' => '[ETYKIETA:zamowNowyProdukt.tytul_strony]',	//TODO
		'zatwierdzZwrotProduktow.infoPrzekazProdukt' => '[ETYKIETA:zatwierdzZwrotProduktow.infoPrzekazProdukt]',	//TODO
		'zatwierdzZwrotProduktow.infoWymienProdukt' => '[ETYKIETA:zatwierdzZwrotProduktow.infoWymienProdukt]',	//TODO
		'zatwierdzZwrotProduktow.tytul_modulu' => '[ETYKIETA:zatwierdzZwrotProduktow.tytul_modulu]',	//TODO
		'zatwierdzZwrotProduktow.tytul_strony' => '[ETYKIETA:zatwierdzZwrotProduktow.tytul_strony]',	//TODO
		'zatwierdzZwrotProduktow.wystapilyBledyPodczasZwrotu' => '[ETYKIETA:zatwierdzZwrotProduktow.wystapilyBledyPodczasZwrotu]',	//TODO
		'zlozZamowienie.tytul_modulu' => '[ETYKIETA:zlozZamowienie.tytul_modulu]',	//TODO
		'zlozZamowienie.tytul_strony' => '[ETYKIETA:zlozZamowienie.tytul_strony]',	//TODO
		'znaczek_rozdziel' => '/',
		'zwrocProdukty.etykietaZatwierdzZwrot' => '[ETYKIETA:zwrocProdukty.etykietaZatwierdzZwrot]',	//TODO
		'zwrocProdukty.iloscEtykieta' => '[ETYKIETA:zwrocProdukty.iloscEtykieta]',	//TODO
		'zwrocProdukty.kodEtykieta' => '[ETYKIETA:zwrocProdukty.kodEtykieta]',	//TODO
		'zwrocProdukty.nazwaEtykieta' => '[ETYKIETA:zwrocProdukty.nazwaEtykieta]',	//TODO
		'zwrocProdukty.nieWybranoProduktowDoZwrotu' => '[ETYKIETA:zwrocProdukty.nieWybranoProduktowDoZwrotu]',	//TODO
		'zwrocProdukty.opisEtykieta' => '[ETYKIETA:zwrocProdukty.opisEtykieta]',	//TODO
		'zwrocProdukty.powrotDoListaProduktowEtykieta' => '[ETYKIETA:zwrocProdukty.powrotDoListaProduktowEtykieta]',	//TODO
		'zwrocProdukty.pracownik_nie_istnieje' => '[ETYKIETA:zwrocProdukty.pracownik_nie_istnieje]',	//TODO
		'zwrocProdukty.produktPrzeniesionyDoGrupyNieplene' => '[ETYKIETA:zwrocProdukty.produktPrzeniesionyDoGrupyNieplene]',	//TODO
		'zwrocProdukty.produktPrzeniesionyDoGrupySerwis' => '[ETYKIETA:zwrocProdukty.produktPrzeniesionyDoGrupySerwis]',	//TODO
		'zwrocProdukty.przekazEtykieta' => '[ETYKIETA:zwrocProdukty.przekazEtykieta]',	//TODO
		'zwrocProdukty.przekazLabel' => '[ETYKIETA:zwrocProdukty.przekazLabel]',	//TODO
		'zwrocProdukty.przekazLabel_pracownik' => '[ETYKIETA:zwrocProdukty.przekazLabel_pracownik]',	//TODO
		'zwrocProdukty.przekazLabel_team' => '[ETYKIETA:zwrocProdukty.przekazLabel_team]',	//TODO
		'zwrocProdukty.statusEtykieta' => '[ETYKIETA:zwrocProdukty.statusEtykieta]',	//TODO
		'zwrocProdukty.team_nie_istnieje' => '[ETYKIETA:zwrocProdukty.team_nie_istnieje]',	//TODO
		'zwrocProdukty.tytul_modulu' => '[ETYKIETA:zwrocProdukty.tytul_modulu]',	//TODO
		'zwrocProdukty.tytul_strony' => '[ETYKIETA:zwrocProdukty.tytul_strony]',	//TODO
		'zwrocProdukty.wybraneProduktyNieZostalyZnalezione' => '[ETYKIETA:zwrocProdukty.wybraneProduktyNieZostalyZnalezione]',	//TODO
		'zwrocProdukty.wymienEtykieta' => '[ETYKIETA:zwrocProdukty.wymienEtykieta]',	//TODO
		'zwrocProdukty.zdjecieEtykieta' => '[ETYKIETA:zwrocProdukty.zdjecieEtykieta]',	//TODO

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
			'publiczne' => 'Public',
			'uzytkownik' => 'User',
			'wlasciciel_grupy' => 'Owner of product group',
			'osoba_wydajaca' => 'Storekeeper',
			'osoba_dodajaca_produkt' => 'User adds a product',
			'pracownik_biurowy' => 'Office worker',
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