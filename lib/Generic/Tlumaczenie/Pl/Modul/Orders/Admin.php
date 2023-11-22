<?php
namespace Generic\Tlumaczenie\Pl\Modul\Orders;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie 
 * @property string $t['CreateBefaringXls.b2b_brak_pliku']
 * @property string $t['CreateBefaringXls.blad_pliku_xls']
 * @property string $t['CreateBefaringXls.brak_pliku_xls']
 * @property string $t['CreateBefaringXls.nieznany_typ_zamowienia']
 * @property string $t['CreateBefaringXls.wybrane_zamowienie_nie_istnieje']
 * @property string $t['addChild.tytul_modulu']
 * @property string $t['addChild.tytul_strony']
 * @property string $t['addChildOrder.error_brak_danych_rodzica']
 * @property string $t['addOrder.tytul_modulu']
 * @property string $t['addOrder.tytul_strony']
 * @property string $t['addOrderType.tytul_modulu']
 * @property string $t['addOrderType.tytul_strony']
 * @property string $t['addReclamation.error_brak_zamowienia_o_podanym_id']
 * @property string $t['addReclamation.etykieta_placeholder']
 * @property string $t['addReclamation.sciezka_selectOrder']
 * @property string $t['addReclamation.selectOrder_tytul_strony']
 * @property string $t['addReclamation.tytul_modulu']
 * @property string $t['addReclamation.tytul_strony']
 * @property string $t['addorderViaGroup.bkak_typow_zamowien_w_danej_grupie']
 * @property string $t['deleteOrder.blad_nie_mozna_pobrac_wiersza']
 * @property string $t['deleteOrder.przeniesiono_do_usunietych_error']
 * @property string $t['deleteOrder.przeniesiono_do_usunietych_success']
 * @property string $t['deleteOrder.tytul_modulu']
 * @property string $t['deleteOrder.tytul_strony']
 * @property string $t['deleteOrder.zamowienie_zablokowane']
 * @property string $t['deleteOrderType.blad_nie_mozna_pobrac_wiersza']
 * @property string $t['deleteOrderType.przeniesiono_do_usunietych_error']
 * @property string $t['deleteOrderType.przeniesiono_do_usunietych_success']
 * @property string $t['deleteOrderType.tytul_modulu']
 * @property string $t['deleteOrderType.tytul_strony']
 * @property string $t['deleteReclamation.przeniesiono_do_usunietych_error']
 * @property string $t['deleteReclamation.przeniesiono_do_usunietych_success']
 * @property string $t['deletedOrderTypes.etykieta_potwierdz_przywroc']
 * @property string $t['deletedOrderTypes.etykieta_przywroc']
 * @property string $t['deletedOrderTypes.tytul_modulu']
 * @property string $t['deletedOrderTypes.tytul_strony']
 * @property string $t['dodajDrugaTura.blad']
 * @property string $t['dodajDrugaTura.poprawnie']
 * @property string $t['editOrder.addReclamation.etykietaMenu']
 * @property string $t['editOrder.blokada_edycji']
 * @property string $t['editOrder.dodajDrugaTuraEtykieta']
 * @property string $t['editOrder.etykieta_close_order']
 * @property string $t['editOrder.etykieta_notatki']
 * @property string $t['editOrder.etykieta_notatki_akcja']
 * @property string $t['editOrder.etykieta_preview_order']
 * @property string $t['editOrder.etykieta_reopen_order']
 * @property string $t['editOrder.otworzProjekt']
 * @property string $t['editOrder.potwierdzZmianaStatusu']
 * @property string $t['editOrder.potwierdzZmianaStatusuNaglowek']
 * @property string $t['editOrder.save_attachement_error']
 * @property string $t['editOrder.save_attachement_success']
 * @property string $t['editOrder.sciezka_edit_main_order']
 * @property string $t['editOrder.sciezka_edit_order']
 * @property string $t['editOrder.sciezka_main_order']
 * @property string $t['editOrder.sciezka_suborder']
 * @property string $t['editOrder.tytul_modulu']
 * @property string $t['editOrder.tytul_modulu_podzamowienie']
 * @property string $t['editOrder.tytul_strony']
 * @property string $t['editOrder.tytul_strony_podzamowienie']
 * @property string $t['editOrder.zakladka_etykieta_podzamowienia']
 * @property string $t['editOrder.zakladka_etykieta_reklamacje']
 * @property string $t['editOrder.zakladka_etykieta_zalaczniki']
 * @property string $t['editOrder.zakladka_etykieta_zamowienie']
 * @property string $t['editOrderType.tytul_modulu']
 * @property string $t['editOrderType.tytul_strony']
 * @property string $t['edytuj.blad_nie_mozna_pobrac_wiersza']
 * @property string $t['edytujZamowienieTeam.blad_edycji_danych']
 * @property string $t['edytujZamowienieTeam.edycja_przebiegla_pomyslnie']
 * @property string $t['edytujZamowienieTeam.formularz_blednie_wypelniony']
 * @property string $t['edytujZamowienieTeam.zamowienie_nie_istnieje']
 * @property string $t['etykieta_select_wybierz']
 * @property string $t['formZamknijZamowienie.address.etykieta']
 * @property string $t['formZamknijZamowienie.akceptacja_dobryKlient.etykieta']
 * @property string $t['formZamknijZamowienie.akceptacja_nieWysylajSms.etykieta']
 * @property string $t['formZamknijZamowienie.akceptacja_nieWysylajSms.nie']
 * @property string $t['formZamknijZamowienie.akceptacja_nieWysylajSms.nie_wiem']
 * @property string $t['formZamknijZamowienie.akceptacja_nieWysylajSms.tak']
 * @property string $t['formZamknijZamowienie.akceptacja_notatka.etykieta']
 * @property string $t['formZamknijZamowienie.akceptacja_produkty.etykieta']
 * @property string $t['formZamknijZamowienie.attachments.region']
 * @property string $t['formZamknijZamowienie.city.etykieta']
 * @property string $t['formZamknijZamowienie.cofnij.wartosc']
 * @property string $t['formZamknijZamowienie.dodaj_zamowienie.etykieta']
 * @property string $t['formZamknijZamowienie.dodatkowiPracownicy.etykieta']
 * @property string $t['formZamknijZamowienie.email.etykieta']
 * @property string $t['formZamknijZamowienie.etykieta_wybierz_klienta']
 * @property string $t['formZamknijZamowienie.formularz.region']
 * @property string $t['formZamknijZamowienie.formularzAkceptacja.wartosc']
 * @property string $t['formZamknijZamowienie.imie.etykieta']
 * @property string $t['formZamknijZamowienie.klient.region']
 * @property string $t['formZamknijZamowienie.komunikat_brak_internetu']
 * @property string $t['formZamknijZamowienie.listaAkceptacji']
 * @property string $t['formZamknijZamowienie.listaDoAkceptacji.region']
 * @property string $t['formZamknijZamowienie.nazwisko.etykieta']
 * @property string $t['formZamknijZamowienie.not_done_za_malo_produktow']
 * @property string $t['formZamknijZamowienie.notatka.etykieta']
 * @property string $t['formZamknijZamowienie.note.etykieta']
 * @property string $t['formZamknijZamowienie.numberPrivatCustomer.etykieta']
 * @property string $t['formZamknijZamowienie.ostrzezenie_opuszczenie_strony']
 * @property string $t['formZamknijZamowienie.pierwszy_produkt']
 * @property string $t['formZamknijZamowienie.pierwszy_produkt_opis']
 * @property string $t['formZamknijZamowienie.pierwszy_produkt_wybierz']
 * @property string $t['formZamknijZamowienie.podpowiedz_lopende_timer']
 * @property string $t['formZamknijZamowienie.poprzedniKrok']
 * @property string $t['formZamknijZamowienie.postcode.etykieta']
 * @property string $t['formZamknijZamowienie.potwierdz_nie_dodawaj_lopende_timer']
 * @property string $t['formZamknijZamowienie.potwierdz_nie_wysylaj_sms']
 * @property string $t['formZamknijZamowienie.potwierdzenie_resetujProdukty']
 * @property string $t['formZamknijZamowienie.pozostalo_godzin.etykieta']
 * @property string $t['formZamknijZamowienie.pozostalo_godzin.opis']
 * @property string $t['formZamknijZamowienie.produkty.etykieta']
 * @property string $t['formZamknijZamowienie.produkty_dodatkowe.etykieta']
 * @property string $t['formZamknijZamowienie.serial.etykieta']
 * @property string $t['formZamknijZamowienie.serialDelivered.region']
 * @property string $t['formZamknijZamowienie.serialTaken.region']
 * @property string $t['formZamknijZamowienie.sms.etykieta']
 * @property string $t['formZamknijZamowienie.sms_nie_wysylaj.etykieta']
 * @property string $t['formZamknijZamowienie.sms_wyslij_pozniej.etykieta']
 * @property string $t['formZamknijZamowienie.status.etykieta']
 * @property string $t['formZamknijZamowienie.status_zamowienie_dodane.etykieta']
 * @property string $t['formZamknijZamowienie.telefon.etykieta']
 * @property string $t['formZamknijZamowienie.workStatus.etykieta']
 * @property string $t['formZamknijZamowienie.wstecz.wartosc']
 * @property string $t['formZamknijZamowienie.wyslij_sms.etykieta']
 * @property string $t['formZamknijZamowienie.zakoncz.wartosc']
 * @property string $t['formZamknijZamowienie.zakonczApi.wartosc']
 * @property string $t['formZamknijZamowienie.zamknij_zamowienie_anulowany_podmien']
 * @property string $t['formZamknijZamowienie.zapisz.wartosc']
 * @property string $t['formZamknijZamowienie.zapiszApi.wartosc']
 * @property string $t['formularz.blad_nie_wszystkie_pola_wypelnione']
 * @property string $t['formularz.idCoordinator.etykieta']
 * @property string $t['formularz.idCoordinator.opis']
 * @property string $t['formularz.idTypuZamowienia.etykieta']
 * @property string $t['formularz.plik_pdf.etykieta']
 * @property string $t['formularz.plik_pdf.opis']
 * @property string $t['formularz.plik_xls.etykieta']
 * @property string $t['formularz.plik_xls.opis']
 * @property string $t['formularz.pliki.etykieta']
 * @property string $t['formularz.team.etykieta']
 * @property string $t['formularz.wstecz.wartosc']
 * @property string $t['formularz.wybierz']
 * @property string $t['formularz.zapisz.wartosc']
 * @property string $t['formularz.zapisz_zalaczniki.wartosc']
 * @property string $t['formularz.zdjecia.etykieta']
 * @property string $t['formularz.zdjecia.opis']
 * @property string $t['formularzEdytujZamowienieTeam.dodaj_zamowienie.etykieta']
 * @property string $t['formularzEdytujZamowienieTeam.note.etykieta']
 * @property string $t['formularzEdytujZamowienieTeam.produkty_dodatkowe.etykieta']
 * @property string $t['formularzEdytujZamowienieTeam.status.etykieta']
 * @property string $t['formularzEdytujZamowienieTeam.status_zamowienie_dodane.etykieta']
 * @property string $t['formularzEdytujZamowienieTeam.zapisz.wartosc']
 * @property string $t['formularzTypyWyszukiwanie.child_orders.etykieta']
 * @property string $t['formularzTypyWyszukiwanie.czysc.wartosc']
 * @property string $t['formularzTypyWyszukiwanie.main_type.etykieta']
 * @property string $t['formularzTypyWyszukiwanie.parent_types.etykieta']
 * @property string $t['formularzTypyWyszukiwanie.possible_charge_types.etykieta']
 * @property string $t['formularzTypyWyszukiwanie.szukaj.wartosc']
 * @property string $t['formularzTypyZamowien.formFields.etykieta']
 * @property string $t['formularzTypyZamowien.formFields.opis']
 * @property string $t['formularzTypyZamowien.parameters.etykieta']
 * @property string $t['formularzTypyZamowien.parameters.opis']
 * @property string $t['formularzTypyZamowien.wstecz.wartosc']
 * @property string $t['formularzTypyZamowien.zapisz.wartosc']
 * @property string $t['formularzZamknijZamowienie.przejdz_dalej']
 * @property string $t['formularzZamowienia.appointedTime.etykieta']
 * @property string $t['formularzZamowienia.appointment.etykieta']
 * @property string $t['formularzZamowienia.appointment.regionRegion']
 * @property string $t['formularzZamowienia.assignToCoordinator.etykieta']
 * @property string $t['formularzZamowienia.assignToTeam.etykieta']
 * @property string $t['formularzZamowienia.czyObciazyc.etykieta']
 * @property string $t['formularzZamowienia.czyObciazyc.opis']
 * @property string $t['formularzZamowienia.directAssignment.etykieta']
 * @property string $t['formularzZamowienia.etykieta_idCoordinator']
 * @property string $t['formularzZamowienia.etykieta_idTeam']
 * @property string $t['formularzZamowienia.etykieta_wybierz']
 * @property string $t['formularzZamowienia.etykieta_wybierz_klienta']
 * @property string $t['formularzZamowienia.idCoordinator.etykieta']
 * @property string $t['formularzZamowienia.idPricedBy.etykieta']
 * @property string $t['formularzZamowienia.idPricedBy.opis']
 * @property string $t['formularzZamowienia.idProjectLeaderBkt.etykieta']
 * @property string $t['formularzZamowienia.idProjectLeaderBkt.opis']
 * @property string $t['formularzZamowienia.idProjectLeaderGetContact.etykieta']
 * @property string $t['formularzZamowienia.idProjectLeaderGetContact.opis']
 * @property string $t['formularzZamowienia.idTeam.etykieta']
 * @property string $t['formularzZamowienia.kategoria.etykieta']
 * @property string $t['formularzZamowienia.numberContactId.etykieta']
 * @property string $t['formularzZamowienia.numberContactId.opis']
 * @property string $t['formularzZamowienia.numberCustomer.etykieta']
 * @property string $t['formularzZamowienia.numberCustomer.opis']
 * @property string $t['formularzZamowienia.numberPrivatCustomer.etykieta']
 * @property string $t['formularzZamowienia.numberPrivatCustomer.opis']
 * @property string $t['formularzZamowienia.numberPrivatCustomer_etykieta_wybierz']
 * @property string $t['formularzZamowienia.obciazenie.etykieta']
 * @property string $t['formularzZamowienia.open_order.etykieta']
 * @property string $t['formularzZamowienia.open_order_opis']
 * @property string $t['formularzZamowienia.produkty.etykieta']
 * @property string $t['formularzZamowienia.produktyNiestandardowe.etykieta']
 * @property string $t['formularzZamowienia.produktyProjekt.etykieta']
 * @property string $t['formularzZamowienia.same_address.etykieta']
 * @property string $t['formularzZamowienia.wstecz.wartosc']
 * @property string $t['formularzZamowienia.wybierz_kategorie_produktu']
 * @property string $t['formularzZamowienia.wybierz_produkt_niestandardowy']
 * @property string $t['formularzZamowienia.zapisz.wartosc']
 * @property string $t['formularzZamowieniaWyszukiwanie.czysc.wartosc']
 * @property string $t['formularzZamowieniaWyszukiwanie.date_start_do.etykieta']
 * @property string $t['formularzZamowieniaWyszukiwanie.date_start_od.etykieta']
 * @property string $t['formularzZamowieniaWyszukiwanie.domyslny_sorter_etykieta']
 * @property string $t['formularzZamowieniaWyszukiwanie.fraza.etykieta']
 * @property string $t['formularzZamowieniaWyszukiwanie.ma_dzieci.etykieta']
 * @property string $t['formularzZamowieniaWyszukiwanie.ma_reklamacje.etykieta']
 * @property string $t['formularzZamowieniaWyszukiwanie.przypisane_do_mnie.etykieta']
 * @property string $t['formularzZamowieniaWyszukiwanie.status.etykieta']
 * @property string $t['formularzZamowieniaWyszukiwanie.status_work.etykieta']
 * @property string $t['formularzZamowieniaWyszukiwanie.szukaj.wartosc']
 * @property string $t['import.ajax_brak_parametru']
 * @property string $t['import.blad_obiektu_zalacznik']
 * @property string $t['import.blad_pliku_xls']
 * @property string $t['import.blad_uploadu_pdf']
 * @property string $t['import.blad_uploadu_xls']
 * @property string $t['import.blad_zapisu_klienta_do_bazy']
 * @property string $t['import.blad_zaznacz_radio']
 * @property string $t['import.blad_zaznacz_radio_naglowek']
 * @property string $t['import.brak_bledow']
 * @property string $t['import.brak_pliku_pdf']
 * @property string $t['import.brak_pliku_xls']
 * @property string $t['import.brak_pliku_zamowien']
 * @property string $t['import.brak_produktu_w_pliku_pdf']
 * @property string $t['import.brak_wymaganych_plikow']
 * @property string $t['import.button_zapisz_do_bazy_etykieta']
 * @property string $t['import.dodano_produkt_zakupiony_blad']
 * @property string $t['import.dodano_produkt_zakupiony_ok']
 * @property string $t['import.formularz_blednie_wypelniony']
 * @property string $t['import.formularz_brak_plikow']
 * @property string $t['import.generuj_tytul_zamowienia']
 * @property string $t['import.importParsujDaneXls.blad_parsera_xls']
 * @property string $t['import.importujesz_pliki_do_zamowienia']
 * @property string $t['import.jeditable.przycisk_cancel']
 * @property string $t['import.jeditable.przycisk_ok']
 * @property string $t['import.jeditable.tooltip']
 * @property string $t['import.klient_istnieje_w_bazie']
 * @property string $t['import.komunikat_blad_generowania_pliku_txt']
 * @property string $t['import.nie_zapisano_zamowienia']
 * @property string $t['import.nie_znaleziono_ilosci_lub_godzin']
 * @property string $t['import.nie_znaleziono_zamowienia']
 * @property string $t['import.nieprawidlowa_zawartosc_pliku_xls']
 * @property string $t['import.parsuj_dane_pdf.brak_klienta']
 * @property string $t['import.parsuj_dane_pdf.brak_tablicy_zamowien_dla_atrybotow']
 * @property string $t['import.parsuj_dane_pdf.brak_tablicy_zamowien_dla_opisu']
 * @property string $t['import.parsuj_dane_pdf.nieprawidlowy_numer_zamowienia']
 * @property string $t['import.pdf_informacja_brak_zamowien']
 * @property string $t['import.pdf_informacja_ilosc_zamowien']
 * @property string $t['import.pobierz_zdjecia_nieprawidlowa_nazwa']
 * @property string $t['import.polacz_tablice_brak_dopasowania_pdf']
 * @property string $t['import.polacz_tablice_brak_dopasowania_xls']
 * @property string $t['import.polacz_tablice_error_pdf_pusta']
 * @property string $t['import.polacz_tablice_error_rozna_ilosc_zamowien']
 * @property string $t['import.polacz_tablice_error_xls_pusta']
 * @property string $t['import.tabela.brak_danych']
 * @property string $t['import.tabela.dane_naglowek']
 * @property string $t['import.tabela.etykieta_address']
 * @property string $t['import.tabela.etykieta_atrybuty_zamowienia']
 * @property string $t['import.tabela.etykieta_atrybuty_zamowienia_address_key_hash']
 * @property string $t['import.tabela.etykieta_atrybuty_zamowienia_bolig_type']
 * @property string $t['import.tabela.etykieta_atrybuty_zamowienia_careference.dtv']
 * @property string $t['import.tabela.etykieta_atrybuty_zamowienia_cluster']
 * @property string $t['import.tabela.etykieta_atrybuty_zamowienia_construction_area']
 * @property string $t['import.tabela.etykieta_atrybuty_zamowienia_demographic1']
 * @property string $t['import.tabela.etykieta_atrybuty_zamowienia_demographic2']
 * @property string $t['import.tabela.etykieta_atrybuty_zamowienia_demographic3']
 * @property string $t['import.tabela.etykieta_atrybuty_zamowienia_filtered_two_way']
 * @property string $t['import.tabela.etykieta_atrybuty_zamowienia_gsm_coverage']
 * @property string $t['import.tabela.etykieta_atrybuty_zamowienia_hc_status']
 * @property string $t['import.tabela.etykieta_atrybuty_zamowienia_hfc_two_way_network']
 * @property string $t['import.tabela.etykieta_atrybuty_zamowienia_hfc_two_way_network_date']
 * @property string $t['import.tabela.etykieta_atrybuty_zamowienia_homes_passed']
 * @property string $t['import.tabela.etykieta_atrybuty_zamowienia_homes_passed_date']
 * @property string $t['import.tabela.etykieta_atrybuty_zamowienia_info']
 * @property string $t['import.tabela.etykieta_atrybuty_zamowienia_latitude']
 * @property string $t['import.tabela.etykieta_atrybuty_zamowienia_longitude']
 * @property string $t['import.tabela.etykieta_atrybuty_zamowienia_market_type']
 * @property string $t['import.tabela.etykieta_atrybuty_zamowienia_needs_upgrade']
 * @property string $t['import.tabela.etykieta_atrybuty_zamowienia_network_type']
 * @property string $t['import.tabela.etykieta_atrybuty_zamowienia_node']
 * @property string $t['import.tabela.etykieta_atrybuty_zamowienia_villa_complex']
 * @property string $t['import.tabela.etykieta_city']
 * @property string $t['import.tabela.etykieta_dane_1']
 * @property string $t['import.tabela.etykieta_dane_klienta']
 * @property string $t['import.tabela.etykieta_dane_klienta_ID']
 * @property string $t['import.tabela.etykieta_dane_klienta_adres']
 * @property string $t['import.tabela.etykieta_dane_klienta_apartament']
 * @property string $t['import.tabela.etykieta_dane_klienta_email']
 * @property string $t['import.tabela.etykieta_dane_klienta_imie']
 * @property string $t['import.tabela.etykieta_dane_klienta_komorka']
 * @property string $t['import.tabela.etykieta_dane_klienta_tel1']
 * @property string $t['import.tabela.etykieta_dane_klienta_tel2']
 * @property string $t['import.tabela.etykieta_dane_klienta_tel3']
 * @property string $t['import.tabela.etykieta_dane_zamowienia']
 * @property string $t['import.tabela.etykieta_data']
 * @property string $t['import.tabela.etykieta_data_1']
 * @property string $t['import.tabela.etykieta_glowny_service']
 * @property string $t['import.tabela.etykieta_godziny_przedzial']
 * @property string $t['import.tabela.etykieta_godziny_przedzial_1']
 * @property string $t['import.tabela.etykieta_gwiazdka_1']
 * @property string $t['import.tabela.etykieta_gwiazdka_2']
 * @property string $t['import.tabela.etykieta_gwiazdka_3']
 * @property string $t['import.tabela.etykieta_gwiazdka_4']
 * @property string $t['import.tabela.etykieta_idCustomer']
 * @property string $t['import.tabela.etykieta_id_1']
 * @property string $t['import.tabela.etykieta_klient_id_1']
 * @property string $t['import.tabela.etykieta_klient_xls']
 * @property string $t['import.tabela.etykieta_naglowek']
 * @property string $t['import.tabela.etykieta_name']
 * @property string $t['import.tabela.etykieta_node_lub_villa_kod']
 * @property string $t['import.tabela.etykieta_numer_get']
 * @property string $t['import.tabela.etykieta_numer_get_1']
 * @property string $t['import.tabela.etykieta_numer_zamowienia']
 * @property string $t['import.tabela.etykieta_numer_zamowienia_1']
 * @property string $t['import.tabela.etykieta_opis']
 * @property string $t['import.tabela.etykieta_opis_dodatkowy']
 * @property string $t['import.tabela.etykieta_opis_xls']
 * @property string $t['import.tabela.etykieta_phoneMobile']
 * @property string $t['import.tabela.etykieta_phoneNumber']
 * @property string $t['import.tabela.etykieta_phoneNumber1']
 * @property string $t['import.tabela.etykieta_poprawne']
 * @property string $t['import.tabela.etykieta_service']
 * @property string $t['import.tabela.etykieta_service_pdf']
 * @property string $t['import.tabela.etykieta_total_time']
 * @property string $t['import.tabela.etykieta_total_time_1']
 * @property string $t['import.tabela.etykieta_tytul_zamowienia']
 * @property string $t['import.tabela.etykieta_wycena']
 * @property string $t['import.tabela.etykieta_zalaczniki_pdf']
 * @property string $t['import.tabela.etykieta_zdjecie']
 * @property string $t['import.tabela.import_bez_zalacznika']
 * @property string $t['import.tabela.import_blad_pdf']
 * @property string $t['import.tabela.import_blad_xls']
 * @property string $t['import.tabela.import_blad_zdjecie']
 * @property string $t['import.tabela.import_dodano_zalacznik']
 * @property string $t['import.tabela.import_poprawny_pdf']
 * @property string $t['import.tabela.import_poprawny_xls']
 * @property string $t['import.tabela.import_poprawny_zdjecie']
 * @property string $t['import.tabela.numer_zamowienia']
 * @property string $t['import.tlumaczenie_pomin']
 * @property string $t['import.tytul_modulu']
 * @property string $t['import.tytul_strony']
 * @property string $t['import.tytul_strony_import_b2bbefaring']
 * @property string $t['import.tytul_strony_import_digging']
 * @property string $t['import.tytul_strony_import_gravebefaring']
 * @property string $t['import.tytul_strony_import_villa']
 * @property string $t['import.wystapily_bledy']
 * @property string $t['import.xls_informacja_ilosc_zamowien']
 * @property string $t['import.zaktualizowano_klienta']
 * @property string $t['import.zaktualizowano_produkt_blad']
 * @property string $t['import.zaktualizowano_produkt_ok']
 * @property string $t['import.zamowienie_istnieje']
 * @property string $t['import.zamowienie_istnieje_aktualizuj']
 * @property string $t['import.zamowienie_istnieje_dodaj_jako_nowe']
 * @property string $t['import.zapisano_klienta_do_bazy']
 * @property string $t['import.zapisano_zamowienie']
 * @property string $t['import.zapiszZamowienie_brak_id_klienta']
 * @property string $t['import.zapiszZamowienie_brak_id_zamowienia']
 * @property string $t['import.zapisz_produkt_error']
 * @property string $t['import.zapisz_produkt_poprawne']
 * @property string $t['import.zapisz_produkty_pusta_tablica']
 * @property string $t['import.zapisz_zalacznik_brak_zalacznika']
 * @property string $t['import.zapisz_zalacznik_error']
 * @property string $t['import.zapisz_zalacznik_error_idObject']
 * @property string $t['import.zapisz_zalacznik_error_katalog']
 * @property string $t['import.zapisz_zalacznik_error_plik']
 * @property string $t['import.zapisz_zalacznik_ok']
 * @property string $t['import.zapisz_zamowione_produkty_brak_id_zamowienia']
 * @property string $t['import.zaznacz_wszystkie']
 * @property string $t['importB2b.blad_zapisu_zamowienia']
 * @property string $t['importB2b.zapisano_zamowien']
 * @property string $t['importGrave.dopasowano_zalacznikow']
 * @property string $t['importGrave.zapisano_zamowien']
 * @property string $t['importGrave.znaleziono_zalacznikow']
 * @property string $t['importGrave.znaleziono_zamowien']
 * @property string $t['importzapiszdobazy.tytul_modulu']
 * @property string $t['importzapiszdobazy.tytul_strony']
 * @property string $t['index.bkt_id']
 * @property string $t['index.error_brak_konfiguracji_typow_zamowien']
 * @property string $t['index.etykieta_add_child']
 * @property string $t['index.etykieta_createBefaringXls']
 * @property string $t['index.etykieta_edytuj']
 * @property string $t['index.etykieta_import']
 * @property string $t['index.etykieta_logIn']
 * @property string $t['index.etykieta_podglad']
 * @property string $t['index.etykieta_potwierdz_usun']
 * @property string $t['index.etykieta_usun']
 * @property string $t['index.grid_etykieta_address']
 * @property string $t['index.grid_etykieta_budget']
 * @property string $t['index.grid_etykieta_budget_spent']
 * @property string $t['index.grid_etykieta_client']
 * @property string $t['index.grid_etykieta_client_contact']
 * @property string $t['index.grid_etykieta_date_start']
 * @property string $t['index.grid_etykieta_date_stop']
 * @property string $t['index.grid_etykieta_hours_interval']
 * @property string $t['index.grid_etykieta_ilosc_dzieci']
 * @property string $t['index.grid_etykieta_ilosc_podzamowien']
 * @property string $t['index.grid_etykieta_ilosc_reklamacji']
 * @property string $t['index.grid_etykieta_ilosc_zamowien']
 * @property string $t['index.grid_etykieta_money_spent']
 * @property string $t['index.grid_etykieta_number_order_get']
 * @property string $t['index.grid_etykieta_order_id']
 * @property string $t['index.grid_etykieta_order_name']
 * @property string $t['index.grid_etykieta_reclamation_address']
 * @property string $t['index.grid_etykieta_reclamation_for']
 * @property string $t['index.grid_etykieta_status_work']
 * @property string $t['index.grid_etykieta_total_time']
 * @property string $t['index.tytul_modulu']
 * @property string $t['index.tytul_strony']
 * @property string $t['indexLider.additionalData_etykieta']
 * @property string $t['indexLider.adres_klienta_etykieta']
 * @property string $t['indexLider.anuluj_sms_ajax']
 * @property string $t['indexLider.atrybuty_etykieta']
 * @property string $t['indexLider.brak_uprawnien_do_przegladania_strony']
 * @property string $t['indexLider.brak_zamowien']
 * @property string $t['indexLider.czasNaZalogowaneZamowienie']
 * @property string $t['indexLider.etykieta_apartamenty_biezace']
 * @property string $t['indexLider.etykieta_apartamenty_wszystkie']
 * @property string $t['indexLider.etykieta_do']
 * @property string $t['indexLider.etykieta_od']
 * @property string $t['indexLider.etykieta_podglad_projektu']
 * @property string $t['indexLider.etykieta_produkty_zsumowane']
 * @property string $t['indexLider.etykieta_suma_godzin']
 * @property string $t['indexLider.etykieta_telefon']
 * @property string $t['indexLider.etykieta_typ_projektu_apartamenty']
 * @property string $t['indexLider.etykieta_wersje']
 * @property string $t['indexLider.etykieta_zaloguj']
 * @property string $t['indexLider.formularzAkceptacjiNaglowek']
 * @property string $t['indexLider.info_tlumaczenie']
 * @property string $t['indexLider.job_description_naglowek']
 * @property string $t['indexLider.komunikatMaszApartamenty']
 * @property string $t['indexLider.komunikat_nie_przekroczony_czas']
 * @property string $t['indexLider.komunikat_przekroczony_czas']
 * @property string $t['indexLider.komunikat_suma_nie_przekroczony_czas']
 * @property string $t['indexLider.komunikat_suma_przekroczony_czas']
 * @property string $t['indexLider.liczba_godzin']
 * @property string $t['indexLider.lista_apartamentow_etykieta']
 * @property string $t['indexLider.maile_naglowek']
 * @property string $t['indexLider.note_naglowek']
 * @property string $t['indexLider.note_pierwsza_tura_naglowek']
 * @property string $t['indexLider.numer_klienta_etykieta']
 * @property string $t['indexLider.obecniePrzypisani_naglowek']
 * @property string $t['indexLider.pobierz_etykieta']
 * @property string $t['indexLider.podglad_etykieta']
 * @property string $t['indexLider.potwierdz_usun_komunikat']
 * @property string $t['indexLider.potwierdz_usun_naglowek']
 * @property string $t['indexLider.pozostalyCzasNaZamowienie']
 * @property string $t['indexLider.price_etykieta']
 * @property string $t['indexLider.priced_by_etykieta']
 * @property string $t['indexLider.procent_etykieta']
 * @property string $t['indexLider.procent_price_etykieta']
 * @property string $t['indexLider.projekt_lider_bkt_etykieta']
 * @property string $t['indexLider.projekt_lider_get_etykieta']
 * @property string $t['indexLider.projektyLideraBktNaglowek']
 * @property string $t['indexLider.projektyNaglowek']
 * @property string $t['indexLider.przekroczonyCzas']
 * @property string $t['indexLider.quantity_etykieta']
 * @property string $t['indexLider.service_etykieta']
 * @property string $t['indexLider.service_zakupione_etykieta']
 * @property string $t['indexLider.service_zakupione_poprawione_etykieta']
 * @property string $t['indexLider.sms_edytuj_etykieta']
 * @property string $t['indexLider.sms_naglowek']
 * @property string $t['indexLider.sms_nie_wyslany']
 * @property string $t['indexLider.sms_wyslany']
 * @property string $t['indexLider.sms_wyslij_ponownie_etykieta']
 * @property string $t['indexLider.sum_price_etykieta']
 * @property string $t['indexLider.suma_godzin']
 * @property string $t['indexLider.suma_price_etykieta']
 * @property string $t['indexLider.suma_procent_price_etykieta']
 * @property string $t['indexLider.suma_time_etykieta']
 * @property string $t['indexLider.telefon_klienta_etykieta']
 * @property string $t['indexLider.time_etykieta']
 * @property string $t['indexLider.tytul_modulu']
 * @property string $t['indexLider.tytul_modulu_sms_nie_wyslane']
 * @property string $t['indexLider.tytul_modulu_zamkniete']
 * @property string $t['indexLider.tytul_strony']
 * @property string $t['indexLider.tytul_strony_sms_nie_wyslane']
 * @property string $t['indexLider.tytul_strony_zamkniete']
 * @property string $t['indexLider.villaInstalationNaglowek']
 * @property string $t['indexLider.wersje_naglowek']
 * @property string $t['indexLider.zakoncz_prace_etykieta']
 * @property string $t['indexLider.zalacznik_naglowek']
 * @property string $t['indexLider.zalogowany_etykieta']
 * @property string $t['indexLider.zamkniete_zamowienia_daty_info']
 * @property string $t['indexLider.zapisz_sms_ajax']
 * @property string $t['index_addOrder.etykietaMenu']
 * @property string $t['index_import.etykietaMenu']
 * @property string $t['index_index.etykietaMenu']
 * @property string $t['index_orderTypes.etykietaMenu']
 * @property string $t['logIn.blad_dodawania_klienta']
 * @property string $t['logIn.blad_dodawania_zamowienia']
 * @property string $t['logIn.sms_wylogowanie_b2b']
 * @property string $t['logInLogOut.sciezka_lista_zamowien']
 * @property string $t['logInLogOutKrok2.czas_z_lopendetimer']
 * @property string $t['logInLogOutKrok2.czas_z_produktow']
 * @property string $t['logInLogOutKrok2.godzinyProduktuTxt']
 * @property string $t['logInLogOutKrok2.godziny_info']
 * @property string $t['logInLogOutKrok2.iloscProduktuTxt']
 * @property string $t['logInLogOutKrok2.info_przekroczony_czas']
 * @property string $t['logInLogOutKrok2.info_szybciej']
 * @property string $t['logInLogOutKrok2.lista_produktow']
 * @property string $t['logInLogOutKrok2.naglowek_info']
 * @property string $t['logInLogOutKrok2.naglowke_lopende']
 * @property string $t['logInLogOutKrok2.nazwaProduktuTxt']
 * @property string $t['logInLogOutKrok2.przepracowane_godziny']
 * @property string $t['logInLogOutKrok2.sumaGodzinTxt']
 * @property string $t['logInLogOutKrok2.tytul_modulu']
 * @property string $t['logInLogOutKrok2.tytul_strony']
 * @property string $t['login.apartament_posiada_dzieci']
 * @property string $t['login.blad_logowania']
 * @property string $t['login.blad_sms']
 * @property string $t['login.koniec_pracy']
 * @property string $t['login.link_wyloguj_etykieta']
 * @property string $t['login.link_zaloguj_etykieta']
 * @property string $t['login.link_zamknij_order_etykieta']
 * @property string $t['login.nie_mozesz_logowac_do_zadania']
 * @property string $t['login.nie_mozesz_wylogowac_z_zadania']
 * @property string $t['login.nie_mozna_zalogowac_lidera']
 * @property string $t['login.notatka_dodaj_pozostale_godziny']
 * @property string $t['login.start_pracy_etykieta']
 * @property string $t['login.tytul_modulu']
 * @property string $t['login.tytul_modulu_info']
 * @property string $t['login.tytul_strony']
 * @property string $t['login.tytul_strony_info']
 * @property string $t['login.wylogowano_z_wszystkich_zadan']
 * @property string $t['login.zamowienie_tytul_etykieta']
 * @property string $t['login.zostales_zalogowany']
 * @property string $t['loginKrok2.komunikat_opuszczenia_strony']
 * @property string $t['logout.nie_mozesz_wylogowac_z_zadania']
 * @property string $t['logout.nie_mozna_zalogowac_lidera']
 * @property string $t['logout.zostales_wylogowany']
 * @property string $t['orderType.zapis_zmian_error']
 * @property string $t['orderType.zapis_zmian_success']
 * @property string $t['orderTypes.etykieta_charge_types']
 * @property string $t['orderTypes.etykieta_child_orders']
 * @property string $t['orderTypes.etykieta_date_added']
 * @property string $t['orderTypes.etykieta_edytuj']
 * @property string $t['orderTypes.etykieta_main_type']
 * @property string $t['orderTypes.etykieta_name']
 * @property string $t['orderTypes.etykieta_order_group']
 * @property string $t['orderTypes.etykieta_parent_types']
 * @property string $t['orderTypes.etykieta_potwierdz_usun']
 * @property string $t['orderTypes.etykieta_usun']
 * @property string $t['orderTypes.tytul_modulu']
 * @property string $t['orderTypes.tytul_strony']
 * @property string $t['orderTypes_addOrderType.etykietaMenu']
 * @property string $t['orderTypes_deletedOrderTypes.etykietaMenu']
 * @property string $t['orders.etykieta_BKT']
 * @property string $t['orders.zapis_zmian_error']
 * @property string $t['orders.zapis_zmian_error_usowanie_produktow']
 * @property string $t['orders.zapis_zmian_srror_produkty']
 * @property string $t['orders.zapis_zmian_success']
 * @property string $t['pobierzApartamentyData.brak_uprawnien']
 * @property string $t['pobierzApartamentyData.projekt_nie_istnieje']
 * @property string $t['previewOrder.blad_podgladu_zamowienia']
 * @property string $t['previewOrder.error_get_order_data']
 * @property string $t['previewOrder.sciezka_lista_orderow_lidera']
 * @property string $t['previewOrder.sciezka_main_order']
 * @property string $t['previewOrder.sciezka_suborder']
 * @property string $t['previewOrder.tytul_modulu']
 * @property string $t['previewOrder.tytul_strony']
 * @property string $t['productCorrection.przekroczono_czas_na_zamowieniu']
 * @property string $t['przydzielenieDoEkipy.blad_nie_mozna_wyslac_emaila']
 * @property string $t['przydzielenieDoEkipy.wyslano_maila']
 * @property string $t['przydzielenieDoKoordynatora.blad_nie_mozna_wyslac_emaila']
 * @property string $t['przydzielenieDoKoordynatora.wyslano_maila']
 * @property string $t['raport.historia_logowania_etykieta']
 * @property string $t['raport.klient_adres_etykieta']
 * @property string $t['raport.klient_etykieta']
 * @property string $t['raport.klient_firma_etykieta']
 * @property string $t['raport.klient_nazwa_etykieta']
 * @property string $t['raport.naglowek']
 * @property string $t['raport.notatki_etykieta']
 * @property string $t['raport.produkty_zakupione_etykieta']
 * @property string $t['raport.status_etykieta']
 * @property string $t['reczneCloseOrder.brak_wpisow_w_timeliscie']
 * @property string $t['reczneCloseOrder.pracownicy_zalogowani_do_zadania']
 * @property string $t['reczneCloseOrder.zamowienie_zostalo_zamkniete']
 * @property string $t['reklamacja.zapis_zmian_error']
 * @property string $t['reklamacja.zapis_zmian_error_produkty']
 * @property string $t['reklamacja.zapis_zmian_success']
 * @property string $t['reklamacje.etykieta_date_added']
 * @property string $t['reklamacje.etykieta_edytuj']
 * @property string $t['reklamacje.etykieta_hours_interval']
 * @property string $t['reklamacje.etykieta_logIn']
 * @property string $t['reklamacje.etykieta_order_name']
 * @property string $t['reklamacje.etykieta_podglad']
 * @property string $t['reklamacje.etykieta_potwierdz_usun']
 * @property string $t['reklamacje.etykieta_usun']
 * @property string $t['reklamacje.etykieta_work_status']
 * @property string $t['reklamacje.tytul_modulu_podzamowienie']
 * @property string $t['reklamacje.tytul_strony_podzamowienie']
 * @property string $t['reopenOrder.blad_brak_zamowienia']
 * @property string $t['reopenOrder.blad_zapisu_zamowienia']
 * @property string $t['reopenOrder.zamowienie_otwarte_ponownie']
 * @property string $t['restoreOrderType.blad_nie_mozna_pobrac_wiersza']
 * @property string $t['restoreOrderType.przeniesiono_do_aktywnych_error']
 * @property string $t['restoreOrderType.przeniesiono_do_aktywnych_success']
 * @property string $t['restoreOrderType.tytul_modulu']
 * @property string $t['restoreOrderType.tytul_strony']
 * @property string $t['sprawdzCzyZamknieteWGet.nie_zamkniete']
 * @property string $t['sprawdzCzyZamknieteWGet.zamowienie_nie_istnieje']
 * @property string $t['sprawdzWymaganeZalaczniki.wymagana_ilosc_zalacznikow_apartament']
 * @property string $t['suborders.etykieta_address']
 * @property string $t['suborders.etykieta_charge_type']
 * @property string $t['suborders.etykieta_client']
 * @property string $t['suborders.etykieta_client_faktura']
 * @property string $t['suborders.etykieta_date_added']
 * @property string $t['suborders.etykieta_order_name']
 * @property string $t['suborders.etykieta_order_type']
 * @property string $t['suborders.etykieta_products']
 * @property string $t['suborders.etykieta_taki_sam_klient']
 * @property string $t['widokProjektApartamenty.daty_apartamentow_etykieta']
 * @property string $t['widokProjektApartamenty.lista_apartamentow_etykieta']
 * @property string $t['widokProjektApartamenty.lista_dat_pusta']
 * @property string $t['widokProjektApartamenty.open_orders']
 * @property string $t['widokProjektApartamenty.projekt_nie_istnieje']
 * @property string $t['widokProjektApartamenty.pusta_lista_apartamentow']
 * @property string $t['widokProjektApartamenty.tytul_modulu']
 * @property string $t['widokProjektApartamenty.tytul_strony']
 * @property string $t['widokZamowienia.komunikat_brak_klienta']
 * @property string $t['widokZamowienie.etykieta_edytuj_zamowienie']
 * @property string $t['widokZamowienie.etykieta_reopen_zamowienie']
 * @property string $t['widokZamowienie.pokaz_powiazane']
 * @property string $t['wyslijSmsPonownie.brak_sms_id']
 * @property string $t['wyslijSmsPonownie.sms_blad_wysylania']
 * @property string $t['wyslijSmsPonownie.sms_nie_istnieje']
 * @property string $t['wyslijSmsPonownie.sms_wyslany']
 * @property string $t['zakonczDzien.blad_nie_zakonczono_wszystkich_zadan']
 * @property string $t['zakonczDzien.etykieta_bkt_id']
 * @property string $t['zakonczDzien.etykieta_czy_skonczyles_o_godzinie']
 * @property string $t['zakonczDzien.etykieta_godziny_przepracowane']
 * @property string $t['zakonczDzien.etykieta_lista_zamowien']
 * @property string $t['zakonczDzien.etykieta_miejscowosci']
 * @property string $t['zakonczDzien.etykieta_ordery_wykonane']
 * @property string $t['zakonczDzien.etykieta_produkty_dostarczone']
 * @property string $t['zakonczDzien.etykieta_statystyki_dnia']
 * @property string $t['zakonczDzien.etykieta_straszak_o_godzinie']
 * @property string $t['zakonczDzien.tytul_modulu']
 * @property string $t['zakonczDzien.tytul_strony']
 * @property string $t['zamknijDzien.brak_adresu_zamowienia']
 * @property string $t['zamknijDzien.etykieta_koniecPracy']
 * @property string $t['zamknijDzien.etykieta_wstecz']
 * @property string $t['zamknijDzien.etykieta_zapisz']
 * @property string $t['zamknijDzien.formularz_nie_poprawnie_wypelniony']
 * @property string $t['zamknijDzien.komunikat_bladAktualizacjiTimelisty']
 * @property string $t['zamknijDzien.komunikat_bladZapisuNajduzszegoDystansu']
 * @property string $t['zamknijDzien.komunikat_dzienJuzZamkniety']
 * @property string $t['zamknijDzien.komunikat_dzienPozytywnieZamkniety']
 * @property string $t['zamknijDzien.maksymalna_mozliwa_ilosc_godzin_poprawa']
 * @property string $t['zamknijDzien.opis_koniecPracy']
 * @property string $t['zamknijDzien.sciezka_lista_zamowien']
 * @property string $t['zamknijDzien.walidator_data_mniejsza_od_rozpoczecia']
 * @property string $t['zamknijDzien.walidator_data_za_duza']
 * @property string $t['zamknijDzien.walidator_data_za_duza_dojazd']
 * @property string $t['zamknijDzien.walidator_data_za_duzo_godzin']
 * @property string $t['zamowienieWidok.autowylogowany_alert']
 * @property string $t['zamowienieWidok.etykieta_czyNotatka']
 * @property string $t['zamowienieWidok.etykieta_historia_logowan']
 * @property string $t['zamowienieWidok.etykieta_historia_logowan_apartamenty']
 * @property string $t['zamowienieWidok.etykieta_mniej']
 * @property string $t['zamowienieWidok.etykieta_notCharge']
 * @property string $t['zamowienieWidok.etykieta_opisDoFaktury']
 * @property string $t['zamowienieWidok.etykieta_trescNotatki']
 * @property string $t['zamowienieWidok.etykieta_waluta']
 * @property string $t['zamowienieWidok.etykieta_wiecej']
 * @property string $t['zamowienieWidok.etykieta_zapisz_produkty']
 * @property string $t['zamowienieWidok.opcja_radio_notatka_wlasna']
 * @property string $t['zamowienieWidok.opis_czyNotatka']
 * @property string $t['zamowienieWidok.opis_notCharge']
 * @property string $t['zamowienieWidok.opis_opisDoFaktury']
 * @property string $t['zamowienieWidok.opis_trescNotatki']
 * @property string $t['zamowienieWidok.productCorrectionUsunZListy']
 * @property string $t['zamowienieWidok.przycisk_usun_zatwierdz_etykieta']
 * @property string $t['zamowienieWidok.przycisk_zatwierdz_etykieta']
 * @property string $t['zamowienieWidok.zamowieniaPowiazane_naglowek']
 * @property string $t['zmianaEkipy.blad_nie_mozna_wyslac_emaila']
 * @property string $t['zmianaEkipy.wyslano_maila']
 * @property string $t['zmianaKoordynatora.blad_nie_mozna_wyslac_emaila']
 * @property string $t['zmianaKoordynatora.wyslano_maila']
 * @property string $t['zmianaStatusu.blad_nie_mozna_wyslac_emaila']
 * @property string $t['zmianaStatusu.wyslano_maila']
 * @property string $t['zmianaTerminu.blad_nie_mozna_wyslac_emaila']
 * @property string $t['zmianaTerminu.wyslano_maila']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajIndexLider']
 * @property string $t['_akcje_etykiety_']['wykonajImport']
 * @property string $t['_akcje_etykiety_']['wykonajImportEdytujAjax']
 * @property string $t['_akcje_etykiety_']['wykonajZapiszPlik']
 * @property string $t['_akcje_etykiety_']['wykonajImportZapiszDoBazy']
 * @property string $t['_akcje_etykiety_']['wykonajUsunPlik']
 * @property string $t['_akcje_etykiety_']['wykonajUsunZalaczniki']
 * @property string $t['_akcje_etykiety_']['wykonajAddOrderViaGroup']
 * @property string $t['_akcje_etykiety_']['wykonajAddOrder']
 * @property string $t['_akcje_etykiety_']['wykonajAddChildOrder']
 * @property string $t['_akcje_etykiety_']['wykonajEditOrder']
 * @property string $t['_akcje_etykiety_']['wykonajDeleteOrder']
 * @property string $t['_akcje_etykiety_']['wykonajLogInLogOut']
 * @property string $t['_akcje_etykiety_']['wykonajOrderTypes']
 * @property string $t['_akcje_etykiety_']['wykonajAddOrderType']
 * @property string $t['_akcje_etykiety_']['wykonajEditOrderType']
 * @property string $t['_akcje_etykiety_']['wykonajDeleteOrderType']
 * @property string $t['_akcje_etykiety_']['wykonajDeletedOrderTypes']
 * @property string $t['_akcje_etykiety_']['wykonajRestoreOrderType']
 * @property string $t['_akcje_etykiety_']['wykonajNotatkiButton']
 * @property string $t['_akcje_etykiety_']['wykonajPreviewOrder']
 * @property string $t['_akcje_etykiety_']['wykonajAddReclamation']
 * @property string $t['_akcje_etykiety_']['wykonajWyszukajOrder']
 * @property string $t['_akcje_etykiety_']['wykonajAktualizujZamknijZadanieForm']
 * @property string $t['_akcje_etykiety_']['wykonajZakonczDzien']
 * @property string $t['_akcje_etykiety_']['wykonajReopenOrder']
 * @property array $t['_zdarzenia_etykiety_']
 * @property string $t['_zdarzenia_etykiety_']['wyslano_email_przydzielenia_do_ekipy']
 * @property string $t['_zdarzenia_etykiety_']['wyslano_email_zmiana_ekipy']
 * @property string $t['_zdarzenia_etykiety_']['wyslano_email_zmiana_koordynatora']
 * @property string $t['_zdarzenia_etykiety_']['wyslano_email_przydzielenia_do_koordynatora']
 * @property string $t['_zdarzenia_etykiety_']['wyslano_email_o_zmianie_statusu']
 * @property string $t['_zdarzenia_etykiety_']['wyslano_email_o_zmianie_terminu']
 * @property array $t['chargeTypes.wartosci']
 * @property string $t['chargeTypes.wartosci']['given price']
 * @property string $t['chargeTypes.wartosci']['price per hour']
 * @property string $t['chargeTypes.wartosci']['by products']
 * @property array $t['formZamknijZamowienie.opcjeSms']
 * @property string $t['formZamknijZamowienie.opcjeSms']['send']
 * @property string $t['formZamknijZamowienie.opcjeSms']['send_later']
 * @property string $t['formZamknijZamowienie.opcjeSms']['dont_send']
 * @property array $t['formZamknijZamowienie.seriale']
 * @property string $t['formZamknijZamowienie.seriale']['dekoder']
 * @property string $t['formZamknijZamowienie.seriale']['modem']
 * @property string $t['formZamknijZamowienie.seriale']['h_dek']
 * @property string $t['formZamknijZamowienie.seriale']['h_modem']
 * @property string $t['formZamknijZamowienie.seriale']['voip']
 * @property string $t['formZamknijZamowienie.seriale']['ont']
 * @property string $t['formZamknijZamowienie.seriale']['air_ties']
 * @property string $t['formZamknijZamowienie.seriale']['h_airties']
 * @property array $t['formZamknijZamowienie.zamknij_zamowienie_statusy']
 * @property string $t['formZamknijZamowienie.zamknij_zamowienie_statusy']['wykonane']
 * @property string $t['formZamknijZamowienie.zamknij_zamowienie_statusy']['anulowane']
 * @property string $t['formZamknijZamowienie.zamknij_zamowienie_statusy']['pomin_order']
 * @property string $t['formZamknijZamowienie.zamknij_zamowienie_statusy']['nie_wykonane_b2b']
 * @property string $t['formZamknijZamowienie.zamknij_zamowienie_statusy']['brak_klienta']
 * @property string $t['formZamknijZamowienie.zamknij_zamowienie_statusy']['spoznienie']
 * @property array $t['formZamknijZamowienie.zamknij_zamowienie_zamowienie_dodatkowe_statusy']
 * @property string $t['formZamknijZamowienie.zamknij_zamowienie_zamowienie_dodatkowe_statusy']['wykonane']
 * @property string $t['formZamknijZamowienie.zamknij_zamowienie_zamowienie_dodatkowe_statusy']['nie_wykonane']
 * @property array $t['formularzZamowienia.charge_amounts']
 * @property string $t['formularzZamowienia.charge_amounts']['10']
 * @property string $t['formularzZamowienia.charge_amounts']['25']
 * @property string $t['formularzZamowienia.charge_amounts']['50']
 * @property string $t['formularzZamowienia.charge_amounts']['75']
 * @property string $t['formularzZamowienia.charge_amounts']['100']
 * @property array $t['formularzZamowienia.charge_guilty_by']
 * @property string $t['formularzZamowienia.charge_guilty_by']['reclamation_hours']
 * @property string $t['formularzZamowienia.charge_guilty_by']['order_hours']
 * @property array $t['formularzZamowienia.sendorderOptions']
 * @property string $t['formularzZamowienia.sendorderOptions']['open_order']
 * @property string $t['formularzZamowienia.sendorderOptions']['assignToCoordinator']
 * @property string $t['formularzZamowienia.sendorderOptions']['assignToTeam']
 * @property array $t['indexLider.statusy_pracy']
 * @property string $t['indexLider.statusy_pracy']['new']
 * @property string $t['indexLider.statusy_pracy']['in progress']
 * @property string $t['indexLider.statusy_pracy']['done']
 * @property string $t['indexLider.statusy_pracy']['not done']
 * @property array $t['indexLider.tlumaczenia_wersje']
 * @property string $t['indexLider.tlumaczenia_wersje']['opis_etykieta']
 * @property array $t['previewOrder.etykiety_podgladu']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-ORDER_NAME']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-ID_ORDER_BKT']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-NUMBER_ORDER_GET']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-NUMBER_ORDER_BKT']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-NUMBER_PROJECT_GET']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CHARGE_TYPE']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-DATE_ADDED']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-HOURS_INTERVAL']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-TOTAL_TIME']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-DATE_START']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-DATE_STOP']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-STATUS_WORK']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-ADDRESS']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CITY']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-POSTCODE']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-LOCATION_LAT']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-LOCATION_LNG']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-BUDGET']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-NODE_VILLA_CODE']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-ATTRIBUTES']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-JOB_DESCRIPTION']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-NOTES']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CUSTOMER-ID']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CUSTOMER-IDCUSTOMER']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CUSTOMER-FULLNAME']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CUSTOMER-FULLCOMPANYNAME']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CUSTOMER-PHONENUMBERS']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CUSTOMER-NAME']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CUSTOMER-SECONDNAME']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CUSTOMER-SURNAME']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CUSTOMER-ORGNUMBER']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CUSTOMER-COMPANYNAME']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CUSTOMER-ADDRESS']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CUSTOMER-POSTCODE']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CUSTOMER-CITY']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CUSTOMER-PHONENUMBER']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CUSTOMER-PHONENUMBER1']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CUSTOMER-PHONENUMBER2']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CUSTOMER-PHONEMOBILE']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CUSTOMER-FAX']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CUSTOMER-EMAIL']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CUSTOMER-DATAADDED']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CUSTOMER-WWW']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-PRIVATCUSTOMER-ID']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-PRIVATCUSTOMER-IDCUSTOMER']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-PRIVATCUSTOMER-FULLNAME']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-PRIVATCUSTOMER-FULLCOMPANYNAME']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-PRIVATCUSTOMER-PHONENUMBERS']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-PRIVATCUSTOMER-NAME']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-PRIVATCUSTOMER-SECONDNAME']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-PRIVATCUSTOMER-SURNAME']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-PRIVATCUSTOMER-ORGNUMBER']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-PRIVATCUSTOMER-COMPANYNAME']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-PRIVATCUSTOMER-ADDRESS']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-PRIVATCUSTOMER-POSTCODE']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-PRIVATCUSTOMER-CITY']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-PRIVATCUSTOMER-PHONENUMBER']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-PRIVATCUSTOMER-PHONENUMBER1']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-PRIVATCUSTOMER-PHONENUMBER2']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-PRIVATCUSTOMER-PHONEMOBILE']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-PRIVATCUSTOMER-FAX']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-PRIVATCUSTOMER-EMAIL']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-PRIVATCUSTOMER-DATAADDED']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-PRIVATCUSTOMER-WWW']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CONTACT-ID']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CONTACT-PHONENUMBERS']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CONTACT-NAME']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CONTACT-SECONDNAME']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CONTACT-SURNAME']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CONTACT-ADDRESS']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CONTACT-POSTCODE']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CONTACT-CITY']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CONTACT-PHONENUMBER']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CONTACT-PHONENUMBER1']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CONTACT-PHONENUMBER2']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CONTACT-PHONEMOBILE']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CONTACT-FAX']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CONTACT-EMAIL']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CONTACT-DATAADDED']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CONTACT-WWW']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CUSTOMER-SECTION']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-CONTACT-SECTION']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-SERVICES']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-SERVICES-TOTAL']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-ATTACHEMENTS']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-ATTACHEMENTS-DOWNLOAD']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-SERVICES-NAME']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-SERVICES-QUANTITY']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-SERVICES-TIME']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-SERVICES-VAT']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-SERVICES-BRUTTO']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-SUBORDERS']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-SUBORDERS-ORDER_NAME']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-SUBORDERS-DATE_ADDED']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-SUBORDERS-DATE_START']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-SUBORDERS-DATE_STOP']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-SUBORDERS-ORDER_TYPE']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-SUBORDERS-URL_PREVIEW']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-RECLAMATIONS']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-RECLAMATIONS-ORDER_NAME']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-RECLAMATIONS-DATE_START']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-RECLAMATIONS-DATE_STOP']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-RECLAMATIONS-DATE_ADDED']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-RECLAMATIONS-HOURS_INTERVAL']
 * @property string $t['previewOrder.etykiety_podgladu']['LABEL-RECLAMATIONS-URL_PREVIEW']
 * @property array $t['statusWork.wartosci']
 * @property string $t['statusWork.wartosci']['new']
 * @property string $t['statusWork.wartosci']['in progress']
 * @property string $t['statusWork.wartosci']['done']
 * @property string $t['statusWork.wartosci']['not done']
 */
class Admin extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'CreateBefaringXls.b2b_brak_pliku' => 'Brak wymaganego pliku excel',
		'CreateBefaringXls.blad_pliku_xls' => 'Wystąpiły błędy podczas odczytu pliku Excel',
		'CreateBefaringXls.brak_pliku_xls' => 'Brak wymaganego pliku excel',
		'CreateBefaringXls.nieznany_typ_zamowienia' => 'Nie znany typ zamówienia',
		'CreateBefaringXls.wybrane_zamowienie_nie_istnieje' => 'Zamówienie nie istnieje',
		'addChild.tytul_modulu' => 'Dodaj podzamówienie',
		'addChild.tytul_strony' => 'Dodaj podzamówienie',
		'addChildOrder.error_brak_danych_rodzica' => 'Nie można dodać pod zamówienia - zamówienie rodzić nie odnalezione',
		'addOrder.tytul_modulu' => 'Dodaj zamówienie',
		'addOrder.tytul_strony' => 'Dodaj zamówienie',
		'addOrderType.tytul_modulu' => 'Dodaj typ zamówienia',
		'addOrderType.tytul_strony' => 'Dodaj typ zamówienia',
		'addReclamation.error_brak_zamowienia_o_podanym_id' => 'Nie mozna dodać reklamacji - zamówienie o podanym ID nie istnieje',
		'addReclamation.etykieta_placeholder' => 'Wpisz szukaną frazę tutaj (Dane klienta lub dane zamówienia)',
		'addReclamation.sciezka_selectOrder' => 'Wybór zamówienia',
		'addReclamation.selectOrder_tytul_strony' => 'Wybierz zamówienie, którego dotyczy reklamacja',
		'addReclamation.tytul_modulu' => 'Dodaj reklamację do: {ORDER_NAME} (ID: {ORDER_ID})',
		'addReclamation.tytul_strony' => 'Dodawanie reklamacji',
		'addorderViaGroup.bkak_typow_zamowien_w_danej_grupie' => 'Wybrana grupa typów zamówień jest jeszcze pusta. Skontaktuj się z administartorem aby poprawił konfigurację.',
		'deleteOrder.blad_nie_mozna_pobrac_wiersza' => 'Nie można usunąć zamówienia - zamówienie o podanym ID nie istnieje',
		'deleteOrder.przeniesiono_do_usunietych_error' => 'Nie można usunąć zamówienia, proszę spróbować ponownie później',
		'deleteOrder.przeniesiono_do_usunietych_success' => 'Wybrane zamówienie zostało usunięte',
		'deleteOrder.tytul_modulu' => 'Usuń zamówienie',
		'deleteOrder.tytul_strony' => 'Usuwanie zamówienia',
		'deleteOrder.zamowienie_zablokowane' => 'Nie możesz usunąć tego zamówienia. Zamówienie zostało zablokowane.',
		'deleteOrderType.blad_nie_mozna_pobrac_wiersza' => 'Wystąpił błąd. Nie można pobrać danych wybranego wiersza.',
		'deleteOrderType.przeniesiono_do_usunietych_error' => 'Wystąpił błąd podczas usuwania wybranego typu zamówienia.',
		'deleteOrderType.przeniesiono_do_usunietych_success' => 'Wybrany typ zamówienia został przeniesiony do usuniętych.',
		'deleteOrderType.tytul_modulu' => 'Usuń typ zamówienia: %s',
		'deleteOrderType.tytul_strony' => 'Usuń typ zamówienia',
		'deleteReclamation.przeniesiono_do_usunietych_error' => 'Wystąpił błąd i wybrana reklamacja nie została usunięta',
		'deleteReclamation.przeniesiono_do_usunietych_success' => 'Wybrana reklamacja została usunięta',
		'deletedOrderTypes.etykieta_potwierdz_przywroc' => 'Czy jesteś pewien że chcesz przywrócić wybrany typ zamówienia?',
		'deletedOrderTypes.etykieta_przywroc' => 'Przywróć typ zamówienia',
		'deletedOrderTypes.tytul_modulu' => 'Usuń typ zamówienia',
		'deletedOrderTypes.tytul_strony' => 'usuń typ zamówienia',
		'dodajDrugaTura.blad' => 'Wystąpiły błędy podczas przenoszenia do drugiej rundy',
		'dodajDrugaTura.poprawnie' => 'Zamówienie zostało przeniesione do drugiej rundy',
		'editOrder.addReclamation.etykietaMenu' => 'Dodaj reklamację',
		'editOrder.blokada_edycji' => 'Brak możliwości edycji zamówienia. Zamówienie zostało zablokowane do edycji.',
		'editOrder.dodajDrugaTuraEtykieta' => 'Przenieś do drugiej tury',
		'editOrder.etykieta_close_order' => 'Zamknij zamówienie',
		'editOrder.etykieta_notatki' => 'Notatki',
		'editOrder.etykieta_notatki_akcja' => 'Wyświetl lub dodaj notatki',
		'editOrder.etykieta_preview_order' => 'Podgląd zamówienia',
		'editOrder.etykieta_reopen_order' => 'Przenieś do puli otwartych zamówień',
		'editOrder.otworzProjekt' => 'Otwórz projekt',
		'editOrder.potwierdzZmianaStatusu' => 'Czy napewno chcesz zmienić status projektu ?',
		'editOrder.potwierdzZmianaStatusuNaglowek' => 'Potwierdź',
		'editOrder.save_attachement_error' => 'Podczas zapisu załączników wystapiły pewne błędy',
		'editOrder.save_attachement_success' => 'Wszystkie załączniki zostały poprawnie zapisane',
		'editOrder.sciezka_edit_main_order' => 'Edycja zamówienia',
		'editOrder.sciezka_edit_order' => 'Edycja podzamówienia',
		'editOrder.sciezka_main_order' => 'Zamówienie główne',
		'editOrder.sciezka_suborder' => 'Podzamówienie',
		'editOrder.tytul_modulu' => 'Edycja zamówienie (typ: {ORDER_TYPE})',
		'editOrder.tytul_modulu_podzamowienie' => 'Edycja podzamówienia o numerze #{NUMBER_GET} (typ: {ORDER_TYPE})',
		'editOrder.tytul_strony' => 'Edycja zamówienia',
		'editOrder.tytul_strony_podzamowienie' => 'Edycja podzamówienia',
		'editOrder.zakladka_etykieta_podzamowienia' => 'Podzamówienia',
		'editOrder.zakladka_etykieta_reklamacje' => 'Reklamacje',
		'editOrder.zakladka_etykieta_zalaczniki' => 'Załączniki',
		'editOrder.zakladka_etykieta_zamowienie' => 'Zamówienie',
		'editOrderType.tytul_modulu' => 'Edycja typu zamówienia',
		'editOrderType.tytul_strony' => 'Edycja typu zamówienia',
		'edytuj.blad_nie_mozna_pobrac_wiersza' => 'Nie można pobrac danych elementu, który próbujesz edytować',
		'edytujZamowienieTeam.blad_edycji_danych' => 'Błąd edycji danych',
		'edytujZamowienieTeam.edycja_przebiegla_pomyslnie' => 'Edycja przebiegła pomyślnie',
		'edytujZamowienieTeam.formularz_blednie_wypelniony' => 'Formularz został błędnie wypełniony',
		'edytujZamowienieTeam.zamowienie_nie_istnieje' => 'Zamówienie nie istnieje',
		'etykieta_select_wybierz' => '- wybierz -',
		'formZamknijZamowienie.zamknijZamowienieVillaProdukty' => 'Może powinieneś dodać jakieś produkty ?',
		'formZamknijZamowienie.zamknijZamowienieVillaStatusy' => 'Prawdopodobnie wystąpił problem z systemem GET, proszę wybierz poprawny status.',
		'formZamknijZamowienie.produktyRegion.region' => 'Produkty not done',
		'formZamknijZamowienie.statusyDodatkowe.region' => 'Status',
		'formZamknijZamowienie.statusBkt.etykieta' => 'Status : ',
		'formZamknijZamowienie.address.etykieta' => 'Address : ',
		'formZamknijZamowienie.akceptacja_dobryKlient.etykieta' => 'Describe customer satisfaction with the service provided',
		'formZamknijZamowienie.akceptacja_nieWysylajSms.etykieta' => 'You have selected send SMS later ?',
		'formZamknijZamowienie.akceptacja_nieWysylajSms.nie' => 'No',
		'formZamknijZamowienie.akceptacja_nieWysylajSms.nie_wiem' => 'I don\'t know',
		'formZamknijZamowienie.akceptacja_nieWysylajSms.tak' => 'Yes',
		'formZamknijZamowienie.akceptacja_notatka.etykieta' => 'Field note has been filed correctly ?',
		'formZamknijZamowienie.akceptacja_produkty.etykieta' => 'All products have been added correctly ?',
		'formZamknijZamowienie.attachments.region' => 'Załączniki',
		'formZamknijZamowienie.city.etykieta' => 'City : ',
		'formZamknijZamowienie.cofnij.wartosc' => 'Anuluj',
		'formZamknijZamowienie.dodaj_zamowienie.etykieta' => 'Dodatkowe produkty ',
		'formZamknijZamowienie.dodatkowiPracownicy.etykieta' => 'Wybierz pracownika : ',
		'formZamknijZamowienie.email.etykieta' => 'Email : ',
		'formZamknijZamowienie.etykieta_wybierz_klienta' => 'wybierz klienta',
		'formZamknijZamowienie.formularz.region' => 'Zamknij zadanie',
		'formZamknijZamowienie.formularzAkceptacja.wartosc' => 'Następny krok >>',
		'formZamknijZamowienie.imie.etykieta' => 'Name : ',
		'formZamknijZamowienie.klient.region' => 'Customer information for faktura',
		'formZamknijZamowienie.komunikat_brak_internetu' => '<strong>Brak połączenia z internetem!</strong> Odczekaj kolejne <b id="counter">5</b> sek. a system automatycznie spróbuje ponowić żądanie....',
		'formZamknijZamowienie.listaAkceptacji' => 'Lista do akceptacji',
		'formZamknijZamowienie.listaDoAkceptacji.region' => 'Lista do akceptacji',
		'formZamknijZamowienie.nazwisko.etykieta' => 'Surname : ',
		'formZamknijZamowienie.not_done_za_malo_produktow' => 'Musisz dodać jeszcze co najmniej jeden produkt aby móc kontynuować...',
		'formZamknijZamowienie.notatka.etykieta' => 'Note : ',
		'formZamknijZamowienie.note.etykieta' => 'Dodaj notatkę : ',
		'formZamknijZamowienie.numberPrivatCustomer.etykieta' => 'Klient : ',
		'formZamknijZamowienie.ostrzezenie_opuszczenie_strony' => 'Czy na pewno chcesz opuścić aktualną stronę? - Wszystkie poczynione tutaj zmiany NIE zostaną zapisane!',
		'formZamknijZamowienie.pierwszy_produkt' => 'Dodaj pierwszy produkty : ',
		'formZamknijZamowienie.pierwszy_produkt_opis' => 'Możliwość dodawania kolejnych produktów będzie mocno zależała od tego co teraz wybierzesz - nie bądź raptus...',
		'formZamknijZamowienie.pierwszy_produkt_wybierz' => '- Wybierz pierwszy produkt -',
		'formZamknijZamowienie.podpowiedz_lopende_timer' => 'Powinieneś dodać {ILOSC} ({CZAS} h) x Ekstra tid installasjon',
		'formZamknijZamowienie.poprzedniKrok' => '<< Poprzedni krok',
		'formZamknijZamowienie.postcode.etykieta' => 'Postcode : ',
		'formZamknijZamowienie.potwierdz_nie_dodawaj_lopende_timer' => 'Przekroczyłeś szacowany czas na tym zamówieniu. Czy napewno nie chce dodać produktu Løpende timer.?',
		'formZamknijZamowienie.potwierdz_nie_wysylaj_sms' => 'Wybrałeś opcję \"Nie wysyłaj sms\". Czy jesteś pewny, że nie chcesz żeby sms został wysłany ?',
		'formZamknijZamowienie.potwierdzenie_resetujProdukty' => 'Czy jesteś pewien że chcesz usunąc podstawowy produkt? To oznacza rozpoczęcie dodawania produktów od początku.',
		'formZamknijZamowienie.pozostalo_godzin.etykieta' => 'Szacowny czas do końca : ',
		'formZamknijZamowienie.pozostalo_godzin.opis' => 'Ilość godzin pozostałych do wykanania zadania',
		'formZamknijZamowienie.produkty.etykieta' => 'Dodaj następne produkty : ',
		'formZamknijZamowienie.produkty_dodatkowe.etykieta' => 'Produkty : ',
		'formZamknijZamowienie.serial.etykieta' => 'SN/MAC urządzeń: ',
		'formZamknijZamowienie.serialDelivered.region' => 'Numery seryjne produktów dostarczonych',
		'formZamknijZamowienie.serialTaken.region' => 'Numery seryjne produktów zabranych',
		'formZamknijZamowienie.sms.etykieta' => 'SMS : ',
		'formZamknijZamowienie.sms_nie_wysylaj.etykieta' => 'Nie wysyłaj sms',
		'formZamknijZamowienie.sms_wyslij_pozniej.etykieta' => 'Wyślij później',
		'formZamknijZamowienie.status.etykieta' => 'Status : ',
		'formZamknijZamowienie.status_zamowienie_dodane.etykieta' => 'Status : ',
		'formZamknijZamowienie.telefon.etykieta' => 'Phone : ',
		'formZamknijZamowienie.workStatus.etykieta' => 'Wybierz : ',
		'formZamknijZamowienie.wstecz.wartosc' => 'Anuluj',
		'formZamknijZamowienie.wyslij_sms.etykieta' => 'Czy chcesz wysłać raport SMSem do GETu?',
		'formZamknijZamowienie.zakoncz.wartosc' => 'Zakończ pracę',
		'formZamknijZamowienie.zakonczApi.wartosc' => 'Zakończ pracę',
		'formZamknijZamowienie.zamknij_zamowienie_anulowany_podmien' => 'Zamówienie anulowane',
		'formZamknijZamowienie.zapisz.wartosc' => 'Zaloguj do nowego zadania',
		'formZamknijZamowienie.zapiszApi.wartosc' => 'Zaloguj do nowego zadania',
		'formularz.blad_nie_wszystkie_pola_wypelnione' => 'Nie wszystkie wymagane pola zostały poprawnie wypełnione',
		'formularz.idCoordinator.etykieta' => 'Koordynator : ',
		'formularz.idCoordinator.opis' => '',
		'formularz.idTypuZamowienia.etykieta' => 'Typ zamówienia : ',
		'formularz.plik_pdf.etykieta' => 'Plik pdf',
		'formularz.plik_pdf.opis' => '',
		'formularz.plik_xls.etykieta' => 'Plik xlsx',
		'formularz.plik_xls.opis' => '',
		'formularz.pliki.etykieta' => 'Pliki',
		'formularz.team.etykieta' => 'Przypisz do : ',
		'formularz.wstecz.wartosc' => 'Anuluj',
		'formularz.wybierz' => ' - wybierz - ',
		'formularz.zapisz.wartosc' => 'Zapisz',
		'formularz.zapisz_zalaczniki.wartosc' => 'Zapisz załączniki',
		'formularz.zdjecia.etykieta' => 'Pliki',
		'formularz.zdjecia.opis' => '',
		'formularzEdytujZamowienieTeam.dodaj_zamowienie.etykieta' => 'Dodatkowe produkty',
		'formularzEdytujZamowienieTeam.note.etykieta' => 'Notatka',
		'formularzEdytujZamowienieTeam.produkty_dodatkowe.etykieta' => 'Produkty',
		'formularzEdytujZamowienieTeam.status.etykieta' => 'Status',
		'formularzEdytujZamowienieTeam.status_zamowienie_dodane.etykieta' => 'Status',
		'formularzEdytujZamowienieTeam.zapisz.wartosc' => 'Zapisz',
		'formularzTypyWyszukiwanie.child_orders.etykieta' => 'Może mieć podzadania',
		'formularzTypyWyszukiwanie.czysc.wartosc' => 'Czyść',
		'formularzTypyWyszukiwanie.main_type.etykieta' => 'Typ główny',
		'formularzTypyWyszukiwanie.parent_types.etykieta' => 'Typy nadrzędne',
		'formularzTypyWyszukiwanie.possible_charge_types.etykieta' => 'Rodzaj rozliczenia',
		'formularzTypyWyszukiwanie.szukaj.wartosc' => 'Szukaj',
		'formularzTypyZamowien.formFields.etykieta' => 'Form fields',
		'formularzTypyZamowien.formFields.opis' => 'Select which form fields should be visible while editing this type of order',
		'formularzTypyZamowien.parameters.etykieta' => 'Attributes',
		'formularzTypyZamowien.parameters.opis' => 'Attributes that configures this order type - you can remove unnecessary attributes if will mean FALSE for this attribute',
		'formularzTypyZamowien.wstecz.wartosc' => 'Anuluj',
		'formularzTypyZamowien.zapisz.wartosc' => 'Zapisz',
		'formularzZamknijZamowienie.przejdz_dalej' => 'Przejdź dalej',
		'formularzZamowienia.appointedTime.etykieta' => 'Czas wizyty',
		'formularzZamowienia.appointment.etykieta' => '',
		'formularzZamowienia.appointment.regionRegion' => 'Wyślij do',
		'formularzZamowienia.assignToCoordinator.etykieta' => 'Koordynator',
		'formularzZamowienia.assignToTeam.etykieta' => 'Zespół',
		'formularzZamowienia.czyObciazyc.etykieta' => 'Czy drużyna powodująca reklamację ma być obciążona?',
		'formularzZamowienia.czyObciazyc.opis' => '',
		'formularzZamowienia.directAssignment.etykieta' => 'Przydzielanie zamówienia',
		'formularzZamowienia.etykieta_idCoordinator' => '- Wybierz koordynatora -',
		'formularzZamowienia.etykieta_idTeam' => '- Wybierz zespół -',
		'formularzZamowienia.etykieta_wybierz' => '- wybierz -',
		'formularzZamowienia.etykieta_wybierz_klienta' => '- Wybierz klienta -',
		'formularzZamowienia.idCoordinator.etykieta' => 'Koordynator',
		'formularzZamowienia.idPricedBy.etykieta' => 'Osoba wyceniająca',
		'formularzZamowienia.idPricedBy.opis' => '',
		'formularzZamowienia.idProjectLeaderBkt.etykieta' => 'Projekt Lider BKT',
		'formularzZamowienia.idProjectLeaderBkt.opis' => '',
		'formularzZamowienia.idProjectLeaderGetContact.etykieta' => 'Projekt Lider Klienta',
		'formularzZamowienia.idProjectLeaderGetContact.opis' => '',
		'formularzZamowienia.idTeam.etykieta' => 'Zespół',
		'formularzZamowienia.kategoria.etykieta' => 'Kategoria',
		'formularzZamowienia.numberContactId.etykieta' => 'Osoba kontaktowa',
		'formularzZamowienia.numberContactId.opis' => '',
		'formularzZamowienia.numberCustomer.etykieta' => 'Klient do faktury',
		'formularzZamowienia.numberCustomer.opis' => '',
		'formularzZamowienia.numberPrivatCustomer.etykieta' => 'Klient',
		'formularzZamowienia.numberPrivatCustomer.opis' => '',
		'formularzZamowienia.numberPrivatCustomer_etykieta_wybierz' => 'Szukaj klienta',
		'formularzZamowienia.obciazenie.etykieta' => 'Sposób oraz wielkość obciążenia',
		'formularzZamowienia.open_order.etykieta' => '<br/>',
		'formularzZamowienia.open_order_opis' => 'Otwarte zamówienie',
		'formularzZamowienia.produkty.etykieta' => 'Produkty',
		'formularzZamowienia.produktyNiestandardowe.etykieta' => 'Produkt : ',
		'formularzZamowienia.produktyProjekt.etykieta' => 'Produkty : ',
		'formularzZamowienia.same_address.etykieta' => 'Taki sam jak adres klienta',
		'formularzZamowienia.wstecz.wartosc' => 'Anuluj',
		'formularzZamowienia.wybierz_kategorie_produktu' => '- wybierz -',
		'formularzZamowienia.wybierz_produkt_niestandardowy' => ' - dodaj produkt - ',
		'formularzZamowienia.zapisz.wartosc' => 'Zapisz',
		'formularzZamowieniaWyszukiwanie.czysc.wartosc' => 'Czyść',
		'formularzZamowieniaWyszukiwanie.date_start_do.etykieta' => 'do:',
		'formularzZamowieniaWyszukiwanie.date_start_od.etykieta' => 'Data od:',
		'formularzZamowieniaWyszukiwanie.domyslny_sorter_etykieta' => 'Moje domyślne sortowanie',
		'formularzZamowieniaWyszukiwanie.fraza.etykieta' => 'Fraza:',
		'formularzZamowieniaWyszukiwanie.ma_dzieci.etykieta' => 'Z podzamówieniami:',
		'formularzZamowieniaWyszukiwanie.ma_reklamacje.etykieta' => 'Z reklamacjami:',
		'formularzZamowieniaWyszukiwanie.przypisane_do_mnie.etykieta' => 'Moje zamówienia:',
		'formularzZamowieniaWyszukiwanie.status.etykieta' => 'Status:',
		'formularzZamowieniaWyszukiwanie.status_work.etykieta' => 'Status:',
		'formularzZamowieniaWyszukiwanie.szukaj.wartosc' => 'Szukaj',
		'import.ajax_brak_parametru' => 'Nie określono parametru do edycji',
		'import.blad_obiektu_zalacznik' => 'Nie udało się zapisać załączika',
		'import.blad_pliku_xls' => 'To nie jest prawidłowy format pliku Excel, spróbuj przesłać plik o rozszeżeniu .xlsx',
		'import.blad_uploadu_pdf' => 'Błąd uploadu pliku pdf ',
		'import.blad_uploadu_xls' => 'Błąd uploadu pliku xlsx ',
		'import.blad_zapisu_klienta_do_bazy' => 'Błąd zapisu klienta ({id_klienta}) do bazy',
		'import.blad_zaznacz_radio' => 'Nie wszystkie wymagane przyciski radio zostały zaznaczone',
		'import.blad_zaznacz_radio_naglowek' => 'Uwaga',
		'import.brak_bledow' => 'Import przebiegł pomyślnie',
		'import.brak_pliku_pdf' => 'Brak pliku pdf z danymi zamówień',
		'import.brak_pliku_xls' => 'Brak pliku xlsx z danymi zamówień',
		'import.brak_pliku_zamowien' => 'Brak pliku zamówień',
		'import.brak_produktu_w_pliku_pdf' => 'w pliku xls nie znaleziono odpowiednika produkt {product} w pliku pdf (zamówieniu : {number_order}) ',
		'import.brak_wymaganych_plikow' => 'Nie wszystkie wymagane pliku zostały wgrane',
		'import.button_zapisz_do_bazy_etykieta' => 'Zapisz do bazy',
		'import.dodano_produkt_zakupiony_blad' => 'Błąd podczas zapisu produktu',
		'import.dodano_produkt_zakupiony_ok' => 'Produkt został zapisany',
		'import.formularz_blednie_wypelniony' => 'Nie wszystkie pola zostały poprawnie wypełnione',
		'import.formularz_brak_plikow' => 'Brak poprawnych danych w przesłanych plikach',
		'import.generuj_tytul_zamowienia' => '{$typZamowienia} {$numerZamowienia} ({$klientId}, {$nazwaKlienta})',
		'import.importParsujDaneXls.blad_parsera_xls' => 'Błąd przetwarzania pliku xls ',
		'import.importujesz_pliki_do_zamowienia' => 'Importujesz informacje do istniejace zamówienia',
		'import.jeditable.przycisk_cancel' => 'Anuluj',
		'import.jeditable.przycisk_ok' => 'OK',
		'import.jeditable.tooltip' => 'Kliknij żeby edytować',
		'import.klient_istnieje_w_bazie' => 'Klient o id {id_klienta} istnieje już w bazie danych',
		'import.komunikat_blad_generowania_pliku_txt' => 'Nie udało się utowrzyć pliku txt z pdf',
		'import.nie_zapisano_zamowienia' => 'Błąd zapisu zamówienia',
		'import.nie_znaleziono_ilosci_lub_godzin' => 'Ilość lub czas dla produktu {product} w zamówieniu {number_order} nie został znaleziony',
		'import.nie_znaleziono_zamowienia' => 'Zamówienie nie istnieje',
		'import.nieprawidlowa_zawartosc_pliku_xls' => 'Nie prawidłowa zawartość pliku Excel, sprawdź czy wybrałeś poprawny typ zamówienia',
		'import.parsuj_dane_pdf.brak_klienta' => 'Nie znaleziono zamówienia do którego należy przypisać klienta ',
		'import.parsuj_dane_pdf.brak_tablicy_zamowien_dla_atrybotow' => 'Nie znaleziono zamówienia do którego należy przypisać atrybuty',
		'import.parsuj_dane_pdf.brak_tablicy_zamowien_dla_opisu' => 'Nie znaleziono zamówienia do którego należy przypisać opis ',
		'import.parsuj_dane_pdf.nieprawidlowy_numer_zamowienia' => 'Nieprawidłowy numer zamówienia, numer musi zawierać 6 cyfr',
		'import.pdf_informacja_brak_zamowien' => 'Ilość zamóień znalezionych w pliku pdf',
		'import.pdf_informacja_ilosc_zamowien' => 'Ilość zamówień znalezionych w pliku pdf : ',
		'import.pobierz_zdjecia_nieprawidlowa_nazwa' => 'Nazwa zdjęcia {nazwa_zdjecia} nie jest zgodna ze standardem',
		'import.polacz_tablice_brak_dopasowania_pdf' => 'Znaleziono różnice w dopasowaniu pliku pdf do xls ',
		'import.polacz_tablice_brak_dopasowania_xls' => 'Znaleziono różnice w dopasowaniu pliku xls do pdf, <strong> zamówienie numer {$NR_ZAMOWIENIA} nie zostanie zapisane </strong>',
		'import.polacz_tablice_error_pdf_pusta' => 'Tabela zamówień z pliku pdf jest pusta',
		'import.polacz_tablice_error_rozna_ilosc_zamowien' => 'Ilość zamóień znalezionych w pliku xls jest różna od ilości zamówień znalezionych w pliku pdf',
		'import.polacz_tablice_error_xls_pusta' => 'Tabela zamówień z pliku xls jest pusta',
		'import.tabela.brak_danych' => 'brak danych',
		'import.tabela.dane_naglowek' => 'Wartość : ',
		'import.tabela.etykieta_address' => 'Klient adres : ',
		'import.tabela.etykieta_atrybuty_zamowienia' => 'Atrybuty zamówienia : ',
		'import.tabela.etykieta_atrybuty_zamowienia_address_key_hash' => 'ADDRESS_KEY_HASH : ',
		'import.tabela.etykieta_atrybuty_zamowienia_bolig_type' => 'Bolig Type : ',
		'import.tabela.etykieta_atrybuty_zamowienia_careference.dtv' => 'Careference.dtv : ',
		'import.tabela.etykieta_atrybuty_zamowienia_cluster' => 'Cluster : ',
		'import.tabela.etykieta_atrybuty_zamowienia_construction_area' => 'Construction Area : ',
		'import.tabela.etykieta_atrybuty_zamowienia_demographic1' => 'Demographic1 : ',
		'import.tabela.etykieta_atrybuty_zamowienia_demographic2' => 'Demographic2 : ',
		'import.tabela.etykieta_atrybuty_zamowienia_demographic3' => 'Demographic3 : ',
		'import.tabela.etykieta_atrybuty_zamowienia_filtered_two_way' => 'Filtered Two Way : ',
		'import.tabela.etykieta_atrybuty_zamowienia_gsm_coverage' => 'GSM coverage : ',
		'import.tabela.etykieta_atrybuty_zamowienia_hc_status' => 'HC Status : ',
		'import.tabela.etykieta_atrybuty_zamowienia_hfc_two_way_network' => 'HFC Two Way Network : ',
		'import.tabela.etykieta_atrybuty_zamowienia_hfc_two_way_network_date' => 'HFC Two Way Network Date : ',
		'import.tabela.etykieta_atrybuty_zamowienia_homes_passed' => 'Homes Passed : ',
		'import.tabela.etykieta_atrybuty_zamowienia_homes_passed_date' => 'Homes Passed Date : ',
		'import.tabela.etykieta_atrybuty_zamowienia_info' => 'Info : ',
		'import.tabela.etykieta_atrybuty_zamowienia_latitude' => 'Latitude : ',
		'import.tabela.etykieta_atrybuty_zamowienia_longitude' => 'Longitude : ',
		'import.tabela.etykieta_atrybuty_zamowienia_market_type' => 'Market Type : ',
		'import.tabela.etykieta_atrybuty_zamowienia_needs_upgrade' => 'Needs Upgrade : ',
		'import.tabela.etykieta_atrybuty_zamowienia_network_type' => 'Network Type : ',
		'import.tabela.etykieta_atrybuty_zamowienia_node' => 'Node : ',
		'import.tabela.etykieta_atrybuty_zamowienia_villa_complex' => 'Villa Complex : ',
		'import.tabela.etykieta_city' => 'Klient miasto : ',
		'import.tabela.etykieta_dane_1' => 'Dane : ',
		'import.tabela.etykieta_dane_klienta' => '<strong>Dane klienta (pdf): </strong>',
		'import.tabela.etykieta_dane_klienta_ID' => ' Id klienta : ',
		'import.tabela.etykieta_dane_klienta_adres' => ' Adres : ',
		'import.tabela.etykieta_dane_klienta_apartament' => ' Apartament : ',
		'import.tabela.etykieta_dane_klienta_email' => ' E-mail : ',
		'import.tabela.etykieta_dane_klienta_imie' => ' Imię : ',
		'import.tabela.etykieta_dane_klienta_komorka' => ' Komórka : ',
		'import.tabela.etykieta_dane_klienta_tel1' => ' Telefon : ',
		'import.tabela.etykieta_dane_klienta_tel2' => ' Telefon : ',
		'import.tabela.etykieta_dane_klienta_tel3' => ' Telefon : ',
		'import.tabela.etykieta_dane_zamowienia' => 'Dane zamówienia : ',
		'import.tabela.etykieta_data' => 'Data : ',
		'import.tabela.etykieta_data_1' => 'Data 1 : ',
		'import.tabela.etykieta_glowny_service' => 'Główny serwis : ',
		'import.tabela.etykieta_godziny_przedzial' => 'Przedział godzin : ',
		'import.tabela.etykieta_godziny_przedzial_1' => 'Godziny przedzial 1 : ',
		'import.tabela.etykieta_gwiazdka_1' => 'Gwiazdka 1 : ',
		'import.tabela.etykieta_gwiazdka_2' => 'Gwiazdka 2 : ',
		'import.tabela.etykieta_gwiazdka_3' => 'Gwiazdka 3 : ',
		'import.tabela.etykieta_gwiazdka_4' => 'Gwiazdka 4 : ',
		'import.tabela.etykieta_idCustomer' => 'Klient id : ',
		'import.tabela.etykieta_id_1' => 'Klient id 1 : ',
		'import.tabela.etykieta_klient_id_1' => 'Klient id : ',
		'import.tabela.etykieta_klient_xls' => 'Klient (xls) : ',
		'import.tabela.etykieta_naglowek' => 'Parametr : ',
		'import.tabela.etykieta_name' => 'Klient nazwa : ',
		'import.tabela.etykieta_node_lub_villa_kod' => 'Kod villa/node : ',
		'import.tabela.etykieta_numer_get' => 'Kod typu zamówienia : ',
		'import.tabela.etykieta_numer_get_1' => 'Kod typu zamówienia 1 : ',
		'import.tabela.etykieta_numer_zamowienia' => 'Numer zamówienia : ',
		'import.tabela.etykieta_numer_zamowienia_1' => 'Numer zamówienia : ',
		'import.tabela.etykieta_opis' => 'Opis (pdf) : ',
		'import.tabela.etykieta_opis_dodatkowy' => 'Opis dodatkowy : ',
		'import.tabela.etykieta_opis_xls' => 'Opis z xls : ',
		'import.tabela.etykieta_phoneMobile' => 'Klient komórka : ',
		'import.tabela.etykieta_phoneNumber' => 'Klient telefon : ',
		'import.tabela.etykieta_phoneNumber1' => 'Klient telefon : ',
		'import.tabela.etykieta_poprawne' => 'Połączono z pdf : ',
		'import.tabela.etykieta_service' => 'Serwis : ',
		'import.tabela.etykieta_service_pdf' => 'Zamówione produkty : ',
		'import.tabela.etykieta_total_time' => 'Total time : ',
		'import.tabela.etykieta_total_time_1' => 'Total time 1 : ',
		'import.tabela.etykieta_tytul_zamowienia' => 'Tytuł zamówienia',
		'import.tabela.etykieta_wycena' => 'Wycena',
		'import.tabela.etykieta_zalaczniki_pdf' => 'Załączniki : ',
		'import.tabela.etykieta_zdjecie' => 'Załączniki : ',
		'import.tabela.import_bez_zalacznika' => '<span class="label label-warning">Brak załącznika pdf</span>',
		'import.tabela.import_blad_pdf' => '<span class="label label-warning">Brak w pdf</span>',
		'import.tabela.import_blad_xls' => 'Znaleziono błędy w pliku excel.',
		'import.tabela.import_blad_zdjecie' => '<span class="label label-warning">Brak załączników</span>',
		'import.tabela.import_dodano_zalacznik' => '<span class="label label-success">Dodano załącznik pdf</span>',
		'import.tabela.import_poprawny_pdf' => '<span class="label label-success">Połączono z Pdf</span>',
		'import.tabela.import_poprawny_xls' => 'Plik excel jest poprawny',
		'import.tabela.import_poprawny_zdjecie' => '<span class="label label-success">Dodano załączniki</span>',
		'import.tabela.numer_zamowienia' => 'Numer zamówienia : ',
		'import.tlumaczenie_pomin' => 'Pomiń to zamówienie',
		'import.tytul_modulu' => 'Import zamówień',
		'import.tytul_strony' => 'Import zamówień',
		'import.tytul_strony_import_b2bbefaring' => 'Import B2B Befaring',
		'import.tytul_strony_import_digging' => 'Import Digging',
		'import.tytul_strony_import_gravebefaring' => 'Import Gravebefaring',
		'import.tytul_strony_import_villa' => 'Import villa orders',
		'import.wystapily_bledy' => 'Wystąpiły błędy podczas importu zamówień, sprawdz logi serwisu',
		'import.xls_informacja_ilosc_zamowien' => 'Ilość zamówień znalezionych w pliku xls : ',
		'import.zaktualizowano_klienta' => 'Klient ({id_klienta}) został zaktualizowany',
		'import.zaktualizowano_produkt_blad' => 'Nie można zaktualizować produktu',
		'import.zaktualizowano_produkt_ok' => 'Produkt został zaktualizowany',
		'import.zamowienie_istnieje' => '<strong style="font-size:18px;" >Uwaga niektóre z zaimportowanych zamówień istnieją już w bazie. Proszę wybrać odpowiednią opcje przy zamówieniu.</strong>',
		'import.zamowienie_istnieje_aktualizuj' => 'aktualizuj',
		'import.zamowienie_istnieje_dodaj_jako_nowe' => 'dodaj jako nowe',
		'import.zapisano_klienta_do_bazy' => 'Zapisano nowego klienta (({id_klienta}) do bazy',
		'import.zapisano_zamowienie' => 'Nowe zamówienie ({zamowienie}) zostało dodane do bazy',
		'import.zapiszZamowienie_brak_id_klienta' => 'Próbujesz zapisać zamówienie do którego nie jest przypisany klient',
		'import.zapiszZamowienie_brak_id_zamowienia' => 'Próbujesz zapisać załącznik do którego nie jest przypisane zamówienie',
		'import.zapisz_produkt_error' => 'Nie można zapisać produktu',
		'import.zapisz_produkt_poprawne' => 'Produkt został zapisany',
		'import.zapisz_produkty_pusta_tablica' => 'Brak produktów do zapisu',
		'import.zapisz_zalacznik_brak_zalacznika' => 'Brak załącznika do zapisu',
		'import.zapisz_zalacznik_error' => 'Wystąpił błąd podczas zapisu załącznika',
		'import.zapisz_zalacznik_error_idObject' => 'Nie podano id objektu załącznika',
		'import.zapisz_zalacznik_error_katalog' => 'Nie podano katalogu do przeniesienia załącznika',
		'import.zapisz_zalacznik_error_plik' => 'Brak pliku do przeniesienia',
		'import.zapisz_zalacznik_ok' => 'Załącznik został zapisany',
		'import.zapisz_zamowione_produkty_brak_id_zamowienia' => 'Brak zamówienia do którego należą produkty',
		'import.zaznacz_wszystkie' => 'Zaznacz wszystkie : ',
		'importB2b.blad_zapisu_zamowienia' => 'Wystąpiły błędy podczas zapisu {ILOSC} zamówień',
		'importB2b.zapisano_zamowien' => '{ILOSC} zamówień zośtało zaimportowanych',
		'importGrave.dopasowano_zalacznikow' => 'Dopasowano {ILOSC} załączników',
		'importGrave.zapisano_zamowien' => 'Zapisano {ILOSC} zamówień',
		'importGrave.znaleziono_zalacznikow' => 'Znaleziono {ILOSC} załączników',
		'importGrave.znaleziono_zamowien' => 'Znaleziono {ILOSC} zamówień',
		'importzapiszdobazy.tytul_modulu' => 'Zapis importu do bazy',
		'importzapiszdobazy.tytul_strony' => 'Zapis importu do bazy',
		'index.bkt_id' => 'Bkt id:',
		'index.error_brak_konfiguracji_typow_zamowien' => 'Błąd aplikacji - nie można odczytać konfiguracji typów zamówien, skontaktuj się z administratorem systemu.',
		'index.etykieta_add_child' => 'Dodaj podzamówienie',
		'index.etykieta_createBefaringXls' => 'Wygeneruj plik Excel',
		'index.etykieta_edytuj' => 'Edytuj',
		'index.etykieta_import' => 'Import',
		'index.etykieta_logIn' => 'Zaloguj',
		'index.etykieta_podglad' => 'Podgląd zamówienia',
		'index.etykieta_potwierdz_usun' => 'Czy jesteś pewien że chcesz usunąć wybrany wiersz?',
		'index.etykieta_usun' => 'Usuń',
		'index.grid_etykieta_address' => 'Adres',
		'index.grid_etykieta_budget' => 'Budżet',
		'index.grid_etykieta_budget_spent' => 'Wydany budżet',
		'index.grid_etykieta_client' => 'Klient',
		'index.grid_etykieta_client_contact' => 'Kontakt',
		'index.grid_etykieta_date_start' => 'Data start',
		'index.grid_etykieta_date_stop' => 'Data stop',
		'index.grid_etykieta_hours_interval' => 'W godzinach',
		'index.grid_etykieta_ilosc_dzieci' => 'Podzamówienia',
		'index.grid_etykieta_ilosc_podzamowien' => 'Zadania',
		'index.grid_etykieta_ilosc_reklamacji' => 'Reklamacje',
		'index.grid_etykieta_ilosc_zamowien' => 'Wersje',
		'index.grid_etykieta_money_spent' => 'Wydano',
		'index.grid_etykieta_number_order_get' => '#GET',
		'index.grid_etykieta_order_id' => 'Id zamówienia',
		'index.grid_etykieta_order_name' => 'Nazwa',
		'index.grid_etykieta_reclamation_address' => 'Adres reklamacji',
		'index.grid_etykieta_reclamation_for' => 'Reklamacja do',
		'index.grid_etykieta_status_work' => 'Status wykonania',
		'index.grid_etykieta_total_time' => 'Czas zadania',
		'index.tytul_modulu' => 'Zamówienia',
		'index.tytul_strony' => 'Zamówienia',
		'indexLider.additionalData_etykieta' => 'Dane dodatkowe',
		'indexLider.adres_klienta_etykieta' => 'Adres',
		'indexLider.anuluj_sms_ajax' => 'Anuluj',
		'indexLider.atrybuty_etykieta' => 'Atrybuty',
		'indexLider.brak_uprawnien_do_przegladania_strony' => 'Nie posiadasz uprawnień do przeglądania strony',
		'indexLider.brak_zamowien' => 'Lista przydzielonych zamówień jest pusta',
		'indexLider.czasNaZalogowaneZamowienie' => 'Przewidywany czas na to zamówienie to : {CZAS_NA_ZAMOWIENIE} godz.',
		'indexLider.etykieta_apartamenty_biezace' => 'Najbliższe zadania',
		'indexLider.etykieta_apartamenty_wszystkie' => 'Wszystkie zadania',
		'indexLider.etykieta_do' => 'do:',
		'indexLider.etykieta_od' => 'od:',
		'indexLider.etykieta_podglad_projektu' => 'Otwórz',
		'indexLider.etykieta_produkty_zsumowane' => 'Lista produktów',
		'indexLider.etykieta_suma_godzin' => 'Łączna liczba przepracowanych godzin',
		'indexLider.etykieta_telefon' => 'tel.',
		'indexLider.etykieta_typ_projektu_apartamenty' => 'Projekt z apartamentami',
		'indexLider.etykieta_wersje' => 'Poprzednie wersje: ',
		'indexLider.etykieta_zaloguj' => 'Zaloguj',
		'indexLider.formularzAkceptacjiNaglowek' => 'Formularz akceptacji',
		'indexLider.info_tlumaczenie' => 'Project GET ID: {ID_GET}, BKT ID: {ID_BKT}',
		'indexLider.job_description_naglowek' => 'Opis prac',
		'indexLider.komunikatMaszApartamenty' => 'Pamietaj, ze dzisiaj wykonujesz instalacje apartamenty! Sprawdz dokladna godzine i sprzet.',
		'indexLider.komunikat_nie_przekroczony_czas' => 'Zamówienie zostało wykonane szybciej o około {CZAS} min',
		'indexLider.komunikat_przekroczony_czas' => 'Czas spędzony na tym zamówieniu został przekroczony o {CZAS} min.',
		'indexLider.komunikat_suma_nie_przekroczony_czas' => 'Dzisiaj skończyłeś szybciej o {CZAS} minut od sumy deklarowanego czasu na zamówieniach.',
		'indexLider.komunikat_suma_przekroczony_czas' => 'Dzisiaj spędziłeś {CZAS} minut więcej od sumy zadeklarowanego czasu na zamówieniach',
		'indexLider.liczba_godzin' => '{HOURS}h',
		'indexLider.lista_apartamentow_etykieta' => 'Lista apartamentów',
		'indexLider.maile_naglowek' => 'E-maile wysłane odnośnie tego zamówienia',
		'indexLider.note_naglowek' => 'Notatki',
		'indexLider.note_pierwsza_tura_naglowek' => 'Notatki z pierwszej rundy',
		'indexLider.numer_klienta_etykieta' => 'Numer klienta',
		'indexLider.obecniePrzypisani_naglowek' => 'Przypisanie do zadania',
		'indexLider.pobierz_etykieta' => 'Pobierz',
		'indexLider.podglad_etykieta' => 'Podgląd',
		'indexLider.potwierdz_usun_komunikat' => 'Czy napewno chcesz usunąć to zamówienie?',
		'indexLider.potwierdz_usun_naglowek' => 'Potwierdzenie',
		'indexLider.pozostalyCzasNaZamowienie' => 'Pozostało Ci <span class="pozostaloSekund" style="font-weight:bold;" ></span> do zakończenia zadania',
		'indexLider.price_etykieta' => 'Cena jedn.',
		'indexLider.priced_by_etykieta' => 'Wyceniony przez',
		'indexLider.procent_etykieta' => '% / ilość',
		'indexLider.procent_price_etykieta' => 'Zafakturowano',
		'indexLider.projekt_lider_bkt_etykieta' => 'Projekt Lider BKT',
		'indexLider.projekt_lider_get_etykieta' => 'Projekt Lider Klienta',
		'indexLider.projektyLideraBktNaglowek' => 'Jesteś liderem projektów : ',
		'indexLider.projektyNaglowek' => 'Projekty',
		'indexLider.przekroczonyCzas' => 'Przekroczyłeś przewidywany czas na to zamówienie o <span class="pozostaloSekund" style="font-weight:bold;" ></span>. Produkt <strong>Løpende timer</strong> zostanie dodany automatycznie',
		'indexLider.quantity_etykieta' => 'Ilość',
		'indexLider.service_etykieta' => 'Produkty zamówione',
		'indexLider.service_zakupione_etykieta' => 'Produkty wybrane przez monterów',
		'indexLider.service_zakupione_poprawione_etykieta' => 'Produkty po korekcie',
		'indexLider.sms_edytuj_etykieta' => 'Edit',
		'indexLider.sms_naglowek' => 'Wiadomości SMS',
		'indexLider.sms_nie_wyslany' => '( <span class="red">Nie wysłana</span> )',
		'indexLider.sms_wyslany' => '( Wysłana )',
		'indexLider.sms_wyslij_ponownie_etykieta' => 'Wyślij',
		'indexLider.sum_price_etykieta' => 'Cena',
		'indexLider.suma_godzin' => '{SUMA_GODZIN}h',
		'indexLider.suma_price_etykieta' => 'Łączna kwota',
		'indexLider.suma_procent_price_etykieta' => 'Łącznie zafakturowano',
		'indexLider.suma_time_etykieta' => 'Suma godzin',
		'indexLider.telefon_klienta_etykieta' => 'Telefony',
		'indexLider.time_etykieta' => 'Godziny',
		'indexLider.tytul_modulu' => 'Lista zamówień',
		'indexLider.tytul_modulu_sms_nie_wyslane' => 'Sms nie wysłane',
		'indexLider.tytul_modulu_zamkniete' => 'Lista zamówień zamkniętych',
		'indexLider.tytul_strony' => 'Lista zamówień',
		'indexLider.tytul_strony_sms_nie_wyslane' => 'Sms nie wysłane',
		'indexLider.tytul_strony_zamkniete' => 'Lista zamówień zamkniętych',
		'indexLider.villaInstalationNaglowek' => 'Instalacje i pozostałe',
		'indexLider.wersje_naglowek' => 'Poprzednie wersje tego zamówienia',
		'indexLider.zakoncz_prace_etykieta' => 'Zakończ pracę',
		'indexLider.zalacznik_naglowek' => 'Załączniki',
		'indexLider.zalogowany_etykieta' => 'Zalogowany',
		'indexLider.zamkniete_zamowienia_daty_info' => 'Zamówienia zamknięte z zakresu dat od : {$dataStartOd} do : {$dataStartDo}',
		'indexLider.zapisz_sms_ajax' => 'Zapisz',
		'index_addOrder.etykietaMenu' => 'Stwórz zamówienie',
		'index_import.etykietaMenu' => 'Import zamówień',
		'index_index.etykietaMenu' => 'Lista zamówień',
		'index_orderTypes.etykietaMenu' => 'Zarządzanie typami zamówień',
		'logIn.blad_dodawania_klienta' => 'Błąd zapisu danych klienta',
		'logIn.blad_dodawania_zamowienia' => 'Wystąpił błąd podczas zapisu danych nowego zamówienia.',
		'logIn.sms_wylogowanie_b2b' => 'Information : {$zamowienie} has not been done and returned to the pool of open orders',
		'logInLogOut.sciezka_lista_zamowien' => 'Twoje zamówienia',
		'logInLogOutKrok2.czas_z_lopendetimer' => 'Czas lopende timer',
		'logInLogOutKrok2.czas_z_produktow' => 'Godziny z produktów',
		'logInLogOutKrok2.godzinyProduktuTxt' => 'Godziny',
		'logInLogOutKrok2.godziny_info' => 'Czas na drużynę / (czas na pracownika)',
		'logInLogOutKrok2.iloscProduktuTxt' => 'Ilość',
		'logInLogOutKrok2.info_przekroczony_czas' => 'Twoja drużyna spędziła {CZAS_LOPENDE_USR} więcej niż zakładano. W notatce wpisz wyjaśnienie co się stało.',
		'logInLogOutKrok2.info_szybciej' => 'Wykonałeś zadanie szybciej o {CZAS_SZYBCIEJ_USR} . Gratuluje jesteś wspaniały.',
		'logInLogOutKrok2.lista_produktow' => 'Lista wybranych produktów',
		'logInLogOutKrok2.naglowek_info' => 'Szczegóły dotyczące zamówienia {ZAMOWIENIE_WO}',
		'logInLogOutKrok2.naglowke_lopende' => 'Produkt dodany przez system',
		'logInLogOutKrok2.nazwaProduktuTxt' => 'Produkt',
		'logInLogOutKrok2.przepracowane_godziny' => 'Przepracowane godziny ',
		'logInLogOutKrok2.sumaGodzinTxt' => 'Suma godzin :',
		'logInLogOutKrok2.tytul_modulu' => 'Podsumowanie zamówienia',
		'logInLogOutKrok2.tytul_strony' => 'Podsumowanie zamówienia',
		'login.apartament_posiada_dzieci' => 'This apartment have assigned additional order, you can see them by clicking the link <a class="btn btn-primary" href="{$LINK}">link</a>',
		'login.blad_logowania' => 'Logowanie nie powiodło się',
		'login.blad_sms' => 'Nie udało się wysłać wiadomości sms',
		'login.koniec_pracy' => 'Zostałeś wylogowany z ostatniego zamówienia na dziś. Jeszcze ostatni krok i jesteś wolny na dziś :-), proszę sprawdź czy wszystko się zgadza...',
		'login.link_wyloguj_etykieta' => 'Wyloguj z zadania',
		'login.link_zaloguj_etykieta' => 'Zaloguj do nowego zadania',
		'login.link_zamknij_order_etykieta' => 'Zamknij zamówienie',
		'login.nie_mozesz_logowac_do_zadania' => 'Nie możesz logować się do zadania',
		'login.nie_mozesz_wylogowac_z_zadania' => 'Nie możesz wylogowywać się z zadań',
		'login.nie_mozna_zalogowac_lidera' => 'Nie masz uprawnień do logowanie się do zadań',
		'login.notatka_dodaj_pozostale_godziny' => ' Estimated left time : {{$POZOSTALO_GODZIN}} h',
		'login.start_pracy_etykieta' => 'Zalogowanie nastąpiło : ',
		'login.tytul_modulu' => 'Logowanie do zadania',
		'login.tytul_modulu_info' => 'Logowanie do zadania : {{$zadanie}}',
		'login.tytul_strony' => 'Logowanie do zadania',
		'login.tytul_strony_info' => 'Logowanie do zadania : {{$zadanie}}',
		'login.wylogowano_z_wszystkich_zadan' => 'Zostałeś pomyslnie wylogowany z wszystkich zadań',
		'login.zamowienie_tytul_etykieta' => 'Obecnie jesteś zalogowany do : ',
		'login.zostales_zalogowany' => 'Logowanie przebiegło pomyślnie',
		'loginKrok2.komunikat_opuszczenia_strony' => 'Proszę użyć przycisku \"Przejdz dalej\" na dole strony',
		'logout.nie_mozesz_wylogowac_z_zadania' => 'Wystąpił błąd podczas wylogowania z zadania',
		'logout.nie_mozna_zalogowac_lidera' => 'Nie masz uprawnień do wylogowania się z zadań',
		'logout.zostales_wylogowany' => 'Wylogowanie przebiegło pomyślnie',
		'orderType.zapis_zmian_error' => 'Wystąpił bład przy zapisie typu zamówienia',
		'orderType.zapis_zmian_success' => 'Typ zamówienia został zapisany',
		'orderTypes.etykieta_charge_types' => 'Sposób rozliczenia',
		'orderTypes.etykieta_child_orders' => 'Zamówienia podległe',
		'orderTypes.etykieta_date_added' => 'Data dodania',
		'orderTypes.etykieta_edytuj' => 'Edytuj typ zamówienia',
		'orderTypes.etykieta_main_type' => 'Typ głowny',
		'orderTypes.etykieta_name' => 'Nazwa',
		'orderTypes.etykieta_order_group' => 'Grupa',
		'orderTypes.etykieta_parent_types' => 'Typy nadrzędne',
		'orderTypes.etykieta_potwierdz_usun' => 'Czy jesteś pewien że chcesz przenieść wybrany typ zamówienia do usunietych?',
		'orderTypes.etykieta_usun' => 'Usuń typ zamówienia',
		'orderTypes.tytul_modulu' => 'Zarządzanie typami zamówień',
		'orderTypes.tytul_strony' => 'Zarządzanie typami zamówień',
		'orderTypes_addOrderType.etykietaMenu' => 'Dodaj typ zamówienia',
		'orderTypes_deletedOrderTypes.etykietaMenu' => 'Usunięte typy zamówień',
		'orders.etykieta_BKT' => 'Wewnętrznie BKT AS',
		'orders.zapis_zmian_error' => 'Wystąpił błąd przy zapisie zamówienia',
		'orders.zapis_zmian_error_usowanie_produktow' => 'Wystąpił bład podczas usówania produktów z zamówienia - zamówienie nie zostało zapisane',
		'orders.zapis_zmian_srror_produkty' => 'Wystapił bład podczas próby zapisu produktów - zamówienie nie zostało zaktualizowane',
		'orders.zapis_zmian_success' => 'Zamówienie zostało zapisane',
		'pobierzApartamentyData.brak_uprawnien' => 'Brak uprawnień do wykonania akcji',
		'pobierzApartamentyData.projekt_nie_istnieje' => 'Wybrany projekt nie istnieje',
		'previewOrder.blad_podgladu_zamowienia' => 'Bład podglądu zamówienia!',
		'previewOrder.error_get_order_data' => 'Nie można pobrać danych wybranego zamówienia',
		'previewOrder.sciezka_lista_orderow_lidera' => 'Twoje zamówienia',
		'previewOrder.sciezka_main_order' => 'Zamówienie główne',
		'previewOrder.sciezka_suborder' => 'Podzamówienie',
		'previewOrder.tytul_modulu' => 'Podgląd zamówienia: "{ORDER_NAME}"',
		'previewOrder.tytul_strony' => 'Podgląd zamówienia',
		'productCorrection.przekroczono_czas_na_zamowieniu' => 'Czas spędzony na tym zamówieniu został przekroczony o około {PRZEKROCZONY_CZAS} min.',
		'przydzielenieDoEkipy.blad_nie_mozna_wyslac_emaila' => 'Nie udało się wysłac maila o przydzieleniu do ekipy',
		'przydzielenieDoEkipy.wyslano_maila' => 'Email o przydzieleniu ekipy został wysłany',
		'przydzielenieDoKoordynatora.blad_nie_mozna_wyslac_emaila' => 'Nie udało się wysłac maila o przydzieleniu do koordynatora',
		'przydzielenieDoKoordynatora.wyslano_maila' => 'Email o przydzieleniu do koordynatora został wysłany',
		'raport.historia_logowania_etykieta' => 'Logging in history',
		'raport.klient_adres_etykieta' => 'Address : ',
		'raport.klient_etykieta' => 'Customer',
		'raport.klient_firma_etykieta' => 'Company name : ',
		'raport.klient_nazwa_etykieta' => 'Name : ',
		'raport.naglowek' => 'Raport B2B',
		'raport.notatki_etykieta' => 'Notes',
		'raport.produkty_zakupione_etykieta' => 'Products',
		'raport.status_etykieta' => 'STATUS : ',
		'reczneCloseOrder.brak_wpisow_w_timeliscie' => 'To zamówienie nie zostało wykonane przez żadną z ekip. Brak wpisów w Timelist. Czy jesteś pewny, że chcesz zamknąć to zamówienie ? <a href="{URL_ZAMKNIJ_ZAMOWIENIE}" alt="zamknij zamówienie"> Zamknij </a>/<a href="{URL_NIE_ZAMYKAJ}" alt="nie zamykaj"> Nie zamykaj </a>.',
		'reczneCloseOrder.pracownicy_zalogowani_do_zadania' => 'Do tego zamówienia obecnie zalogowane są ekipy : {ZALOGOWANE_EKIPY} . Zamknięcie zamówienia spowoduje wylogowanie drużyn z zamówienia. Czy jesteś pewny, że chcesz zamknąć zamówienie ?. <a href="{URL_ZAMKNIJ_ZAMOWIENIE}" alt="zamknij zamówienie"> Zamknij </a>/<a href="{URL_NIE_ZAMYKAJ}" alt="nie zamykaj"> Nie zamykaj </a>.',
		'reczneCloseOrder.zamowienie_zostalo_zamkniete' => 'Zamówienie zostało zamknięte',
		'reklamacja.zapis_zmian_error' => 'Wystąpił błąd i dane reklamacji nie zostały zapisane',
		'reklamacja.zapis_zmian_error_produkty' => 'Wystapił bład podczas zapisu reklamacji związany z zapisem produktów',
		'reklamacja.zapis_zmian_success' => 'Dane reklamacji zostały zapisane',
		'reklamacje.etykieta_date_added' => 'Data dodania',
		'reklamacje.etykieta_edytuj' => 'Edytuj',
		'reklamacje.etykieta_hours_interval' => 'Godziny',
		'reklamacje.etykieta_logIn' => 'Zaloguj do reklamacji',
		'reklamacje.etykieta_order_name' => 'Nazwa reklamacji',
		'reklamacje.etykieta_podglad' => 'Podgląd reklamacji',
		'reklamacje.etykieta_potwierdz_usun' => 'Jesteś pewny że chcesz usunąć wybraną reklamację?',
		'reklamacje.etykieta_usun' => 'Usuń',
		'reklamacje.etykieta_work_status' => 'Status pracy',
		'reklamacje.tytul_modulu_podzamowienie' => 'Edycja reklamacji do zamówienia: #{NUMBER_GET}',
		'reklamacje.tytul_strony_podzamowienie' => 'Edycja reklamacji',
		'reopenOrder.blad_brak_zamowienia' => 'Zamówienie, któro próbowałeś re-aktywować nie występuje w systemie.',
		'reopenOrder.blad_zapisu_zamowienia' => 'Wystapił błąd podczas próby re-aktywacji zamówienia. Zdarzenie to zostało zalogowane i administrator zostanie o tym poinformowany.',
		'reopenOrder.zamowienie_otwarte_ponownie' => 'Zamówienie zostało re-aktywowane i powinno znajdować się na liscie zamówień mozliwych do przydzielenia.',
		'restoreOrderType.blad_nie_mozna_pobrac_wiersza' => 'Błąd. Nie można pobrac danych elementu, który próbujesz przywrócić.',
		'restoreOrderType.przeniesiono_do_aktywnych_error' => 'Wystąpił błąd i wybrany typ zamówienia nie został przywrócony.',
		'restoreOrderType.przeniesiono_do_aktywnych_success' => 'Wybrany typ zamówienia został pomyślnie przywrócony.',
		'restoreOrderType.tytul_modulu' => 'Przywróć typ zamówienia: %s',
		'restoreOrderType.tytul_strony' => 'Przywróć typ zamówienia',
		'sprawdzCzyZamknieteWGet.nie_zamkniete' => 'Zamówienie nie zostało zamknięte w systemie GET.',
		'sprawdzCzyZamknieteWGet.zamowienie_nie_istnieje' => 'Zamówienie nie istnieje',
		'sprawdzWymaganeZalaczniki.wymagana_ilosc_zalacznikow_apartament' => 'Wymagana ilość zdjęć dla tego apartamentu to {ILOSC}',
		'suborders.etykieta_address' => 'Adres',
		'suborders.etykieta_charge_type' => 'Naliczanie',
		'suborders.etykieta_client' => 'Dla kogo',
		'suborders.etykieta_client_faktura' => 'Faktura dla',
		'suborders.etykieta_date_added' => 'Data dodania',
		'suborders.etykieta_order_name' => 'Nazwa',
		'suborders.etykieta_order_type' => 'Typ zamówienia',
		'suborders.etykieta_products' => 'Wykonane usługi',
		'suborders.etykieta_taki_sam_klient' => 'Jak na fakturze',
		'widokProjektApartamenty.daty_apartamentow_etykieta' => 'Daty',
		'widokProjektApartamenty.lista_apartamentow_etykieta' => 'Lista apartamentów',
		'widokProjektApartamenty.lista_dat_pusta' => 'Lista dat jest pusta',
		'widokProjektApartamenty.open_orders' => 'Apartamenty otwarte',
		'widokProjektApartamenty.projekt_nie_istnieje' => 'Projekt nie istnieje',
		'widokProjektApartamenty.pusta_lista_apartamentow' => 'Brak listy apartamentów dla podanych kryteriów',
		'widokProjektApartamenty.tytul_modulu' => 'Lista apartamentów',
		'widokProjektApartamenty.tytul_strony' => 'Lista apartamentów',
		'widokZamowienia.komunikat_brak_klienta' => 'Dane zamówienie nie ma przypisanego żadnego klienta. Sprawdź proszę to zamówienie.',
		'widokZamowienie.etykieta_edytuj_zamowienie' => 'Edytuj to zamówienie',
		'widokZamowienie.etykieta_reopen_zamowienie' => 'Przenieś do puli otwartych zamówień',
		'widokZamowienie.pokaz_powiazane' => 'Pokaż powiązane',
		'wyslijSmsPonownie.brak_sms_id' => 'Nie podano id wiadomości sms',
		'wyslijSmsPonownie.sms_blad_wysylania' => 'Nie udało się wysłać wiadomości sms',
		'wyslijSmsPonownie.sms_nie_istnieje' => 'Wiadomośc o podanym id nie istnieje',
		'wyslijSmsPonownie.sms_wyslany' => 'Wiadomość została wysłana',
		'zakonczDzien.blad_nie_zakonczono_wszystkich_zadan' => 'Przed zamknięciem dnia roboczego musisz najpierw zakończyc wszystkie rozpoczęte zamówienia. Zakończ zamówienie a nastepnie dzień roboczy.',
		'zakonczDzien.etykieta_bkt_id' => 'BKT ID: ',
		'zakonczDzien.etykieta_czy_skonczyles_o_godzinie' => 'Podaj godzinę o której skończyłeś pracę',
		'zakonczDzien.etykieta_godziny_przepracowane' => 'Przepracowane godziny',
		'zakonczDzien.etykieta_lista_zamowien' => 'Lista wykonanych zleceń',
		'zakonczDzien.etykieta_miejscowosci' => 'Najdłuższy dystans do miejscowości',
		'zakonczDzien.etykieta_ordery_wykonane' => 'Wykonane zlecenia',
		'zakonczDzien.etykieta_produkty_dostarczone' => 'Dostarczonych usług/produktów',
		'zakonczDzien.etykieta_statystyki_dnia' => 'Statystyki dnia',
		'zakonczDzien.etykieta_straszak_o_godzinie' => 'Podając godzinę zakończenia pracy miej na pamięci że aplikacja zapisuje Twoją lokalizację w pewnych interwałach czasu.',
		'zakonczDzien.tytul_modulu' => 'Zakończ dzień pracy: {AKTUALNA_DATA}',
		'zakonczDzien.tytul_strony' => 'Zakończ dzień pracy',
		'zamknijDzien.brak_adresu_zamowienia' => 'Adres nie został podany',
		'zamknijDzien.etykieta_koniecPracy' => 'Koniec pracy',
		'zamknijDzien.etykieta_wstecz' => 'Anuluj',
		'zamknijDzien.etykieta_zapisz' => 'Zakończ pracę na dziś!',
		'zamknijDzien.formularz_nie_poprawnie_wypelniony' => 'Podany czas zakończenia pracy nie jest prawidłowy',
		'zamknijDzien.komunikat_bladAktualizacjiTimelisty' => 'Nie udało się zaktualizować Time listy, w związku z tym dzień roboczy nie został zamkniety. Skontaktuj się z obsługą techniczną lub spróbuj ponownie później.',
		'zamknijDzien.komunikat_bladZapisuNajduzszegoDystansu' => 'Nie udało się zapisać najodleglejszego dystansu w dniu dzisiejszym, w związku z tym dzień roboczy nie został zamknięty. Skontaktuj się z obsługą techniczną lub spróbuj ponownie później.',
		'zamknijDzien.komunikat_dzienJuzZamkniety' => 'Dzień już został zamknięty - po prostu odpoczywaj i czekaj na kolejne zamówienia :-)',
		'zamknijDzien.komunikat_dzienPozytywnieZamkniety' => 'Dzień roboczy został poprawnie zamknięty. Nadszedł czas na odpoczynek. Miłego wieczoru!',
		'zamknijDzien.maksymalna_mozliwa_ilosc_godzin_poprawa' => 'Twój dzień roboczy przekroczył dozwolone maksimum {MAX_GODZIN}h. Najprawdopodobniej zapomniałeś zakończyć poprzedni dzień roboczy! Ustaw prawidłową datę i godzinę zakończenia pracy.',
		'zamknijDzien.opis_koniecPracy' => '',
		'zamknijDzien.sciezka_lista_zamowien' => 'Twoje zamówienia',
		'zamknijDzien.walidator_data_mniejsza_od_rozpoczecia' => 'Data zakończenia pracy nie może być mniejsza od daty rozpoczęcia daty.',
		'zamknijDzien.walidator_data_za_duza' => 'Nie możesz pracować dłużej od czasu zamknięcia ostatniego zlecenia.',
		'zamknijDzien.walidator_data_za_duza_dojazd' => 'Maksymalny przewidziany czas na dojazd to: {GODZINY_NA_DOJAZD}h',
		'zamknijDzien.walidator_data_za_duzo_godzin' => 'Twój dzień roboczy przekroczył dozwolone maksimum {MAX_GODZIN}h.',
		'zamowienieWidok.autowylogowany_alert' => 'Zespół został automatycznie wylogowany z tego zadania - sprawdź proszę timeliste',
		'zamowienieWidok.etykieta_czyNotatka' => 'Czy dołączyć notatkę do raportu',
		'zamowienieWidok.etykieta_historia_logowan' => 'Historia logowań',
		'zamowienieWidok.etykieta_historia_logowan_apartamenty' => '[ETYKIETA:zamowienieWidok.etykieta_historia_logowan_apartamenty]',	//TODO
		'zamowienieWidok.etykieta_mniej' => '[ETYKIETA:zamowienieWidok.etykieta_mniej]',	//TODO
		'zamowienieWidok.etykieta_notCharge' => 'NIE pobieraj opłaty za to zamówienie?',
		'zamowienieWidok.etykieta_opisDoFaktury' => '[ETYKIETA:zamowienieWidok.etykieta_opisDoFaktury]',	//TODO
		'zamowienieWidok.etykieta_trescNotatki' => '',
		'zamowienieWidok.etykieta_waluta' => 'kr',
		'zamowienieWidok.etykieta_wiecej' => '[ETYKIETA:zamowienieWidok.etykieta_wiecej]',	//TODO
		'zamowienieWidok.etykieta_zapisz_produkty' => 'Zapisz',
		'zamowienieWidok.opcja_radio_notatka_wlasna' => 'Stwórz nową notatkę',
		'zamowienieWidok.opis_czyNotatka' => '',
		'zamowienieWidok.opis_notCharge' => '',
		'zamowienieWidok.opis_opisDoFaktury' => '[ETYKIETA:zamowienieWidok.opis_opisDoFaktury]',	//TODO
		'zamowienieWidok.opis_trescNotatki' => '',
		'zamowienieWidok.productCorrectionUsunZListy' => 'Usuń z listy',
		'zamowienieWidok.przycisk_usun_zatwierdz_etykieta' => 'Oznacz jako nie sprawdzony',
		'zamowienieWidok.przycisk_zatwierdz_etykieta' => 'Oznacz jako sprawdzony',
		'zamowienieWidok.zamowieniaPowiazane_naglowek' => 'To zamówienie zostało wykonane razem z : ',
		'zmianaEkipy.blad_nie_mozna_wyslac_emaila' => 'Nie udało się wysłać maila o zmianie ekipy',
		'zmianaEkipy.wyslano_maila' => 'Email o zmianie ekipy został wysłany',
		'zmianaKoordynatora.blad_nie_mozna_wyslac_emaila' => 'Nie udało się wysłać maila o zmianie koordynatora',
		'zmianaKoordynatora.wyslano_maila' => 'Email o zmianie koordynatora został wysłany',
		'zmianaStatusu.blad_nie_mozna_wyslac_emaila' => 'Nie udało się wysłać maila o zmianie statusu zamówienia',
		'zmianaStatusu.wyslano_maila' => 'Email o zmianie statusu zamówienia został wysłany',
		'zmianaTerminu.blad_nie_mozna_wyslac_emaila' => 'Nie udało się wysłac maila o zmianie terminu zamówienia',
		'zmianaTerminu.wyslano_maila' => 'Email o zmianie terminu zamówienia został wysłany',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Lista zamówień',
			'wykonajIndexLider' => 'Widok dla Lidera na Tablety',
			'wykonajImport' => 'Import zamówień',
			'wykonajImportEdytujAjax' => 'Import edycja Ajax',
			'wykonajZapiszPlik' => 'Zapisz pliki multiuploadu',
			'wykonajImportZapiszDoBazy' => 'Zapisz import do bazy',
			'wykonajUsunPlik' => 'Usuń pliki multiuploadu',
			'wykonajUsunZalaczniki' => 'Usuń załącznik',
			'wykonajAddOrderViaGroup' => 'Dodaj zamówienie poprzez grupę zamówień',
			'wykonajAddOrder' => 'Dodaj zamówienie',
			'wykonajAddChildOrder' => 'Dodaj podzamówienie',
			'wykonajEditOrder' => 'Edytuj zamówienie',
			'wykonajDeleteOrder' => 'Usuń zamówienie',
			'wykonajLogInLogOut' => 'Zaloguj do zadania',
			'wykonajOrderTypes' => 'Zarządzanie typami zamówień',
			'wykonajAddOrderType' => 'Dodaj typ zamówienia',
			'wykonajEditOrderType' => 'Edytuj typ zamówienia',
			'wykonajDeleteOrderType' => 'Usuń typ zamówienia',
			'wykonajDeletedOrderTypes' => 'Usunięte typy zamówień',
			'wykonajRestoreOrderType' => 'Przywracanie usuniętych typów zamówień',
			'wykonajNotatkiButton' => 'Przeładowanie przycisku z notatkami',
			'wykonajPreviewOrder' => 'Podgląd zamówień',
			'wykonajAddReclamation' => 'Dodaj reklamację',
			'wykonajWyszukajOrder' => 'Wyszukiwanie zamówień AJAX',
			'wykonajAktualizujZamknijZadanieForm' => 'Aktualizuj formularz zamykania zamówienia AJAX',
			'wykonajZakonczDzien' => 'Zamknij dzień roboczy',
			'wykonajReopenOrder' => 'Re-aktywuj zamówienie',
		),
		'_zdarzenia_etykiety_' => array(
			'wyslano_email_przydzielenia_do_ekipy' => 'Email przydzielenie zadania do ekipy',
			'wyslano_email_zmiana_ekipy' => 'Email zmiana ekipy',
			'wyslano_email_zmiana_koordynatora' => 'Email zmiana koordynatora',
			'wyslano_email_przydzielenia_do_koordynatora' => 'Email przydzielenie koordynatora',
			'wyslano_email_o_zmianie_statusu' => 'Email zmiana statusu',
			'wyslano_email_o_zmianie_terminu' => 'Email zmiana terminu zamówienia',
		),
		'chargeTypes.wartosci' => array(
			'given price' => 'Cena ustalona z góry',
			'price per hour' => 'Płatne za godzinę',
			'by products' => 'Płatne po sumie produktów',
		),
		'formZamknijZamowienie.opcjeSms' => array(
			'send' => 'Wyślij normalnie',
			'send_later' => 'Wyślij później',
			'dont_send' => 'Nie wysyłaj wcale',
		),
		'formZamknijZamowienie.seriale' => array(
			'dekoder' => 'SN dekodera numer: {NUMBER}',
			'modem' => 'Adres MAC urządzenia numer: {NUMBER}',
			'h_dek' => 'SN zwracanego dekodera numer: {NUMBER}',
			'h_modem' => 'Adres MAC zwracanego urządzenia numer: {NUMBER}',
			'voip' => 'Adres MAC centralki VoIP',
			'ont' => 'Adres MAC ONTka numer: {NUMBER}',
			'air_ties' => 'SN number {NUMBER}',
			'h_airties' => 'SN number {NUMBER}',
		),
		'formZamknijZamowienie.zamknij_zamowienie_statusy' => array(
			'wykonane' => 'Wykonane',
			'anulowane' => 'Zamówienie anulowane ',
			'pomin_order' => 'Skocz do następnego zamówienia',
			'nie_wykonane_b2b' => 'Nie wykonane',
			'brak_klienta' => 'Klienta nie ma w domu',
			'spoznienie' => 'Spóźnienie (niewykonane)',
		),
		'formZamknijZamowienie.zamknij_zamowienie_zamowienie_dodatkowe_statusy' => array(
			'wykonane' => 'Wykonane',
			'nie_wykonane' => 'Nie wykonane',
		),
		'formularzZamowienia.charge_amounts' => array(
			'10' => '10%',
			'25' => '25%',
			'50' => '50%',
			'75' => '75%',
			'100' => '100%',
		),
		'formularzZamowienia.charge_guilty_by' => array(
			'reclamation_hours' => 'Ile czasu zajęło naprawienie reklamacji',
			'order_hours' => 'Ile czasu zajęło błędne wykonanie zadania',
		),
		'formularzZamowienia.sendorderOptions' => array(
			'open_order' => 'Zapisz jako otwarte',
			'assignToCoordinator' => 'Przydziel koordynatorowi',
			'assignToTeam' => 'Przydziel zespołowi',
		),
		'indexLider.statusy_pracy' => array(
			'new' => 'Nowe',
			'in progress' => 'Rozpoczęte',
			'done' => 'Wykonane',
			'not done' => 'Nie wykonane',
		),
		'indexLider.tlumaczenia_wersje' => array(
			'opis_etykieta' => 'Opis prac',
		),
		'previewOrder.etykiety_podgladu' => array(
			'LABEL-ORDER_NAME' => 'Order name',
			'LABEL-ID_ORDER_BKT' => 'ID zamówienia BKT',
			'LABEL-NUMBER_ORDER_GET' => 'Zamówienie #GET',
			'LABEL-NUMBER_ORDER_BKT' => 'Zamówienie #BKT',
			'LABEL-NUMBER_PROJECT_GET' => 'Projekt #GET',
			'LABEL-CHARGE_TYPE' => 'Rodzaj naliczania',
			'LABEL-DATE_ADDED' => 'Data dodania',
			'LABEL-HOURS_INTERVAL' => 'Godziny',
			'LABEL-TOTAL_TIME' => 'Czas',
			'LABEL-DATE_START' => 'Data rozpoczęcia',
			'LABEL-DATE_STOP' => 'Data zakończenia',
			'LABEL-STATUS_WORK' => 'Status',
			'LABEL-ADDRESS' => 'Adres',
			'LABEL-CITY' => 'Miasto',
			'LABEL-POSTCODE' => 'Kod pocztowy',
			'LABEL-LOCATION_LAT' => 'Latitude',
			'LABEL-LOCATION_LNG' => 'Longitude',
			'LABEL-BUDGET' => 'Budżet',
			'LABEL-NODE_VILLA_CODE' => 'Kod Node/Villa',
			'LABEL-ATTRIBUTES' => 'Atrybuty',
			'LABEL-JOB_DESCRIPTION' => 'Opis zadania',
			'LABEL-NOTES' => 'Notatki',
			'LABEL-CUSTOMER-ID' => 'ID Klienta',
			'LABEL-CUSTOMER-IDCUSTOMER' => 'ID GET',
			'LABEL-CUSTOMER-FULLNAME' => 'Nazwisko, Imię',
			'LABEL-CUSTOMER-FULLCOMPANYNAME' => 'Nazwa firmy',
			'LABEL-CUSTOMER-PHONENUMBERS' => 'Numery telefonów',
			'LABEL-CUSTOMER-NAME' => 'Imię',
			'LABEL-CUSTOMER-SECONDNAME' => 'Drugie imię',
			'LABEL-CUSTOMER-SURNAME' => 'Nazwisko',
			'LABEL-CUSTOMER-ORGNUMBER' => 'Numer organizacji',
			'LABEL-CUSTOMER-COMPANYNAME' => 'Nazwa firmy',
			'LABEL-CUSTOMER-ADDRESS' => 'Adres',
			'LABEL-CUSTOMER-POSTCODE' => 'Kod pocztowy',
			'LABEL-CUSTOMER-CITY' => 'Miasto',
			'LABEL-CUSTOMER-PHONENUMBER' => 'Telefon',
			'LABEL-CUSTOMER-PHONENUMBER1' => 'Telefon 2',
			'LABEL-CUSTOMER-PHONENUMBER2' => 'Telefon 3',
			'LABEL-CUSTOMER-PHONEMOBILE' => 'Komórka',
			'LABEL-CUSTOMER-FAX' => 'Fax',
			'LABEL-CUSTOMER-EMAIL' => 'Email',
			'LABEL-CUSTOMER-DATAADDED' => 'Data dodania',
			'LABEL-CUSTOMER-WWW' => 'WWW',
			'LABEL-PRIVATCUSTOMER-ID' => 'ID klienta',
			'LABEL-PRIVATCUSTOMER-IDCUSTOMER' => 'ID klienta GET',
			'LABEL-PRIVATCUSTOMER-FULLNAME' => 'Nazwisko, Imię',
			'LABEL-PRIVATCUSTOMER-FULLCOMPANYNAME' => 'Nazwa firmy',
			'LABEL-PRIVATCUSTOMER-PHONENUMBERS' => 'Numery telefonów',
			'LABEL-PRIVATCUSTOMER-NAME' => 'Imię',
			'LABEL-PRIVATCUSTOMER-SECONDNAME' => 'Drugi imię',
			'LABEL-PRIVATCUSTOMER-SURNAME' => 'Nazwisko',
			'LABEL-PRIVATCUSTOMER-ORGNUMBER' => 'Numer organizacji',
			'LABEL-PRIVATCUSTOMER-COMPANYNAME' => 'Nazwa firmy',
			'LABEL-PRIVATCUSTOMER-ADDRESS' => 'Adres',
			'LABEL-PRIVATCUSTOMER-POSTCODE' => 'Kod pocztowy',
			'LABEL-PRIVATCUSTOMER-CITY' => 'Miasto',
			'LABEL-PRIVATCUSTOMER-PHONENUMBER' => 'Telefon',
			'LABEL-PRIVATCUSTOMER-PHONENUMBER1' => 'Telefon 2',
			'LABEL-PRIVATCUSTOMER-PHONENUMBER2' => 'Telefon 3',
			'LABEL-PRIVATCUSTOMER-PHONEMOBILE' => 'Komórka',
			'LABEL-PRIVATCUSTOMER-FAX' => 'Fax',
			'LABEL-PRIVATCUSTOMER-EMAIL' => 'Email',
			'LABEL-PRIVATCUSTOMER-DATAADDED' => 'Data dodania',
			'LABEL-PRIVATCUSTOMER-WWW' => 'WWW',
			'LABEL-CONTACT-ID' => 'ID kontaktu',
			'LABEL-CONTACT-PHONENUMBERS' => 'Numery telefonów',
			'LABEL-CONTACT-NAME' => 'Imię',
			'LABEL-CONTACT-SECONDNAME' => 'Drugie imię',
			'LABEL-CONTACT-SURNAME' => 'Nazwisko',
			'LABEL-CONTACT-ADDRESS' => 'Adres',
			'LABEL-CONTACT-POSTCODE' => 'Kod pocztowy',
			'LABEL-CONTACT-CITY' => 'Miasto',
			'LABEL-CONTACT-PHONENUMBER' => 'Telefon',
			'LABEL-CONTACT-PHONENUMBER1' => 'Telefon 2',
			'LABEL-CONTACT-PHONENUMBER2' => 'Telefon 3',
			'LABEL-CONTACT-PHONEMOBILE' => 'Komórka',
			'LABEL-CONTACT-FAX' => 'Fax',
			'LABEL-CONTACT-EMAIL' => 'Email',
			'LABEL-CONTACT-DATAADDED' => 'Data dodania',
			'LABEL-CONTACT-WWW' => 'WWW',
			'LABEL-CUSTOMER-SECTION' => 'Klient',
			'LABEL-CONTACT-SECTION' => 'Osoba kontaktowa',
			'LABEL-SERVICES' => 'Usługi',
			'LABEL-SERVICES-TOTAL' => 'Łącznie',
			'LABEL-ATTACHEMENTS' => 'Załączniki',
			'LABEL-ATTACHEMENTS-DOWNLOAD' => 'Ściągnij',
			'LABEL-SERVICES-NAME' => 'nazwa',
			'LABEL-SERVICES-QUANTITY' => 'Ilość',
			'LABEL-SERVICES-TIME' => 'Czas',
			'LABEL-SERVICES-VAT' => 'Vat',
			'LABEL-SERVICES-BRUTTO' => 'Cena',
			'LABEL-SUBORDERS' => 'Pod zamówienia',
			'LABEL-SUBORDERS-ORDER_NAME' => 'Nazwa zamówienia',
			'LABEL-SUBORDERS-DATE_ADDED' => 'Data dodania',
			'LABEL-SUBORDERS-DATE_START' => 'Data rozpoczęcia',
			'LABEL-SUBORDERS-DATE_STOP' => 'Data zakończenia',
			'LABEL-SUBORDERS-ORDER_TYPE' => 'Typ',
			'LABEL-SUBORDERS-URL_PREVIEW' => 'Podgląd',
			'LABEL-RECLAMATIONS' => 'Reklamacje',
			'LABEL-RECLAMATIONS-ORDER_NAME' => 'Nazwa',
			'LABEL-RECLAMATIONS-DATE_START' => 'Data rozpoczęcia',
			'LABEL-RECLAMATIONS-DATE_STOP' => 'Data zakończenia',
			'LABEL-RECLAMATIONS-DATE_ADDED' => 'Data dodania',
			'LABEL-RECLAMATIONS-HOURS_INTERVAL' => 'Czas',
			'LABEL-RECLAMATIONS-URL_PREVIEW' => 'Podgląd',
		),
		'statusWork.wartosci' => array(
			'new' => 'Nowe',
			'in progress' => 'W realizacji',
			'done' => 'Zakończone',
			'not done' => 'Nie wykonane',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}