<?php
namespace Generic\Tlumaczenie\No\Modul\Orders;

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
 * @property string $t['formularzZamowienia.appointmentRegion.region']
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
 * @property string $t['_akcje_etykiety_']['wykonajImportZapiszDoBazy']
 * @property string $t['_akcje_etykiety_']['wykonajZapiszPlik']
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
 * @property string $t['statusWork.wartosci']['brak_klienta']
 * @property string $t['statusWork.wartosci']['spoznienie']
 */
class Admin extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'CreateBefaringXls.b2b_brak_pliku' => 'The excel file was not found',
		'CreateBefaringXls.blad_pliku_xls' => 'Error while trying to read the excel file',
		'CreateBefaringXls.brak_pliku_xls' => 'The excel file was not found',
		'CreateBefaringXls.nieznany_typ_zamowienia' => 'Unknown type of order',
		'CreateBefaringXls.wybrane_zamowienie_nie_istnieje' => 'Order does not exist',
		'addChild.tytul_modulu' => 'Legg sub rekkefølge',
		'addChild.tytul_strony' => 'Legg sub rekkefølge',
		'addChildOrder.error_brak_danych_rodzica' => 'Forelder ordredata ikke funnet - kan ikke legge til underordenen',
		'addOrder.tytul_modulu' => 'Opprett rekkefølge',
		'addOrder.tytul_strony' => 'Opprett rekkefølge',
		'addOrderType.tytul_modulu' => 'Opprett ny ordre type',
		'addOrderType.tytul_strony' => 'Opprett ny ordre type',
		'addReclamation.error_brak_zamowienia_o_podanym_id' => 'Kan ikke legge til gjenvinning - for at du prøver å legge til gjenvinning for ikke eksisterer i vårt system.',
		'addReclamation.etykieta_placeholder' => 'Skriv inn søkeordet her (kunde eller Ordreinformasjon)',
		'addReclamation.sciezka_selectOrder' => 'Orden utvalg',
		'addReclamation.selectOrder_tytul_strony' => 'Velg ordre, de klager',
		'addReclamation.tytul_modulu' => 'Legg gjenvinning for: {ORDER_NAME} (ID: {ORDER_ID})',
		'addReclamation.tytul_strony' => 'Legg gjenvinning',
		'addorderViaGroup.bkak_typow_zamowien_w_danej_grupie' => 'En utvalgt gruppe av ordretyper er fortsatt tom. Kontakt administratoren for å fikse konfigurasjonen.',
		'deleteOrder.blad_nie_mozna_pobrac_wiersza' => 'Kan ikke slette valgte rekkefølge - for med gitt id ikke eksisterer i vårt system',
		'deleteOrder.przeniesiono_do_usunietych_error' => 'Kan ikke slette bestilling, vennligst prøv igjen senere',
		'deleteOrder.przeniesiono_do_usunietych_success' => 'Valgt ordren er slettet',
		'deleteOrder.tytul_modulu' => 'Slette ordre',
		'deleteOrder.tytul_strony' => 'Slette ordre',
		'deleteOrder.zamowienie_zablokowane' => 'Du kan ikke slette denne ordren. Ordren er blokkert.',
		'deleteOrderType.blad_nie_mozna_pobrac_wiersza' => 'Kan ikke få utvalgte raddata, vennligst prøv igjen senere.',
		'deleteOrderType.przeniesiono_do_usunietych_error' => 'En feil har oppstått og valgt for typen ble ikke slettet.',
		'deleteOrderType.przeniesiono_do_usunietych_success' => 'Valgte ordretype slettet.',
		'deleteOrderType.tytul_modulu' => 'Slett ordretype: %s',
		'deleteOrderType.tytul_strony' => 'Slett ordretype',
		'deleteReclamation.przeniesiono_do_usunietych_error' => 'Det har oppstått en feil og valgt gjenvinning ble ikke slettet',
		'deleteReclamation.przeniesiono_do_usunietych_success' => 'Valgt gjenvinning slettet',
		'deletedOrderTypes.etykieta_potwierdz_przywroc' => 'Er du sikker på at du vil gjenopprette valgt oreder type?',
		'deletedOrderTypes.etykieta_przywroc' => 'Gjenopprette orden typen',
		'deletedOrderTypes.tytul_modulu' => 'Slettede ordretyper',
		'deletedOrderTypes.tytul_strony' => 'Slettede ordretyper',
		'dodajDrugaTura.blad' => 'Feil på vei inn i andre runde',
		'dodajDrugaTura.poprawnie' => 'Bestill var å flytte inn i andre runde',
		'editOrder.addReclamation.etykietaMenu' => 'Legg inn en klage',
		'editOrder.blokada_edycji' => 'Ordren er låst for redigering.',
		'editOrder.dodajDrugaTuraEtykieta' => 'Legg til andre runde',
		'editOrder.etykieta_close_order' => 'Nære bestillinger',
		'editOrder.etykieta_notatki' => 'Notater',
		'editOrder.etykieta_notatki_akcja' => 'Vise eller legge til notater',
		'editOrder.etykieta_preview_order' => 'Forhåndsvisning ordre',
		'editOrder.etykieta_reopen_order' => 'Ordren er re-åpnet',
		'editOrder.otworzProjekt' => 'Open project',
		'editOrder.potwierdzZmianaStatusu' => 'Are You sure you want change status of this order ?',
		'editOrder.potwierdzZmianaStatusuNaglowek' => 'Confirm',
		'editOrder.save_attachement_error' => 'Noen feil oppstod under lagring av vedlegg',
		'editOrder.save_attachement_success' => 'Vedlegg har lagret',
		'editOrder.sciezka_edit_main_order' => 'Rediger rekkefølge',
		'editOrder.sciezka_edit_order' => 'Redigere rekkefølgen',
		'editOrder.sciezka_main_order' => 'Viktigste bestilling',
		'editOrder.sciezka_suborder' => 'Suborder',
		'editOrder.tytul_modulu' => 'Redigere orden (type: {ORDER_TYPE})',
		'editOrder.tytul_modulu_podzamowienie' => 'Redigere rekkefølgen med #{NUMBER_GET} (type: {ORDER_TYPE})',
		'editOrder.tytul_strony' => 'Rredigere orden',
		'editOrder.tytul_strony_podzamowienie' => 'Redigere rekkefølgen',
		'editOrder.zakladka_etykieta_podzamowienia' => 'Gå bestillinger',
		'editOrder.zakladka_etykieta_reklamacje' => 'Klager',
		'editOrder.zakladka_etykieta_zalaczniki' => 'Vedlegg',
		'editOrder.zakladka_etykieta_zamowienie' => 'Bestill',
		'editOrderType.tytul_modulu' => 'Rediger ordretype',
		'editOrderType.tytul_strony' => 'Rediger ordretype',
		'edytuj.blad_nie_mozna_pobrac_wiersza' => 'Kan ikke få utvalgte raddata',
		'edytujZamowienieTeam.blad_edycji_danych' => 'Feil redigere data',
		'edytujZamowienieTeam.edycja_przebiegla_pomyslnie' => 'Redigerer var vellykket',
		'edytujZamowienieTeam.formularz_blednie_wypelniony' => 'Skjemaet ble feilaktig fylt',
		'edytujZamowienieTeam.zamowienie_nie_istnieje' => 'Rekkefølgen ikke eksisterer',
		'etykieta_select_wybierz' => '- velg -',
		'formZamknijZamowienie.zamknijZamowienieVillaProdukty' => 'Maybe You should add some products ?',
		'formZamknijZamowienie.zamknijZamowienieVillaStatusy' => 'There is probably problem with GET system, please select correct status.',
		'formZamknijZamowienie.produktyRegion.region' => 'Products not done',
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
		'formZamknijZamowienie.attachments.region' => 'Attachments',
		'formZamknijZamowienie.city.etykieta' => 'City : ',
		'formZamknijZamowienie.cofnij.wartosc' => 'Cancel',
		'formZamknijZamowienie.dodaj_zamowienie.etykieta' => 'Andre produkter ',
		'formZamknijZamowienie.dodatkowiPracownicy.etykieta' => 'Select workers for Løpende timer ekstra arbeidstaker : ',
		'formZamknijZamowienie.email.etykieta' => 'Email : ',
		'formZamknijZamowienie.etykieta_wybierz_klienta' => 'select customer',
		'formZamknijZamowienie.formularz.region' => 'Lukk bestillinger',
		'formZamknijZamowienie.formularzAkceptacja.wartosc' => 'Next step >>',
		'formZamknijZamowienie.imie.etykieta' => 'Name : ',
		'formZamknijZamowienie.klient.region' => 'Customer information for faktura',
		'formZamknijZamowienie.komunikat_brak_internetu' => '<strong>Internett-tilkobling feil!</strong> Vent i <b id="counter">5</b> sek. og forespørselen vil bli behandlet på nytt automatisk ....',
		'formZamknijZamowienie.listaAkceptacji' => 'List to accept',
		'formZamknijZamowienie.listaDoAkceptacji.region' => 'Accept list',
		'formZamknijZamowienie.nazwisko.etykieta' => 'Surname : ',
		'formZamknijZamowienie.not_done_za_malo_produktow' => 'Du må legge til minst ett produkt til å være i stand til å fortsette ...',
		'formZamknijZamowienie.notatka.etykieta' => 'Note : ',
		'formZamknijZamowienie.note.etykieta' => 'Legg til et notat: ',
		'formZamknijZamowienie.numberPrivatCustomer.etykieta' => 'Customer : ',
		'formZamknijZamowienie.ostrzezenie_opuszczenie_strony' => 'Er du sikker på at du vil forlate denne siden? - Alt gjøres for nå, vil ikke endringene bli lagret',
		'formZamknijZamowienie.pierwszy_produkt' => 'Legg første produkt : ',
		'formZamknijZamowienie.pierwszy_produkt_opis' => 'Mulighet for å legge neste produkter vil basere på hva du valgte her - ta deg tid ...',
		'formZamknijZamowienie.pierwszy_produkt_wybierz' => '- Velg første produkt -',
		'formZamknijZamowienie.podpowiedz_lopende_timer' => 'You should add {ILOSC} ({CZAS} h) x Ekstra tid installasjon',
		'formZamknijZamowienie.poprzedniKrok' => '<< Prev step',
		'formZamknijZamowienie.postcode.etykieta' => 'Postcode : ',
		'formZamknijZamowienie.potwierdz_nie_dodawaj_lopende_timer' => 'Time spent on this order was exceeded about {CZAS} min.',
		'formZamknijZamowienie.potwierdz_nie_wysylaj_sms' => 'Du har valgt alternativet \"Ikke send SMS i det hele tatt\". Er du sikker på at du ikke ønsker å sende sms?',
		'formZamknijZamowienie.potwierdzenie_resetujProdukty' => 'Er du sikker på at du vil slette primære produkt? - Dette vil starte produkter utvalg fra begynnelsen.',
		'formZamknijZamowienie.pozostalo_godzin.etykieta' => 'Estimated left time',
		'formZamknijZamowienie.pozostalo_godzin.opis' => 'Number of hours remaining to complete the order',
		'formZamknijZamowienie.produkty.etykieta' => 'Legg neste produkter : ',
		'formZamknijZamowienie.produkty_dodatkowe.etykieta' => 'Produkter : ',
		'formZamknijZamowienie.serial.etykieta' => 'SN/MAC av enheter: ',
		'formZamknijZamowienie.serialDelivered.region' => 'Serial numbers of products delivered',
		'formZamknijZamowienie.serialTaken.region' => 'Serial numbers of products taken',
		'formZamknijZamowienie.sms.etykieta' => 'SMS : ',
		'formZamknijZamowienie.sms_nie_wysylaj.etykieta' => 'Ikke send sms',
		'formZamknijZamowienie.sms_wyslij_pozniej.etykieta' => 'Sende senere',
		'formZamknijZamowienie.status.etykieta' => 'Status : ',
		'formZamknijZamowienie.status_zamowienie_dodane.etykieta' => 'Status : ',
		'formZamknijZamowienie.telefon.etykieta' => 'Phone : ',
		'formZamknijZamowienie.workStatus.etykieta' => 'Velg : ',
		'formZamknijZamowienie.wstecz.wartosc' => 'Avbryt',
		'formZamknijZamowienie.wyslij_sms.etykieta' => 'Ønsker du å sende SMS-rapporten til GET',
		'formZamknijZamowienie.zakoncz.wartosc' => 'Finish bestill',
		'formZamknijZamowienie.zakonczApi.wartosc' => 'Finish bestill',
		'formZamknijZamowienie.zamknij_zamowienie_anulowany_podmien' => 'Order canceled',
		'formZamknijZamowienie.zapisz.wartosc' => 'Logg deg på en ny jobb',
		'formZamknijZamowienie.zapiszApi.wartosc' => 'Logg deg på en ny jobb',
		'formularz.blad_nie_wszystkie_pola_wypelnione' => 'Ikke alle obligatoriske felt er fylt ut riktig.',
		'formularz.idCoordinator.etykieta' => 'Koordinator : ',
		'formularz.idCoordinator.opis' => '',
		'formularz.idTypuZamowienia.etykieta' => 'Order type : ',
		'formularz.plik_pdf.etykieta' => 'Fil pdf',
		'formularz.plik_pdf.opis' => '',
		'formularz.plik_xls.etykieta' => 'Fil xlsx',
		'formularz.plik_xls.opis' => '',
		'formularz.pliki.etykieta' => 'Felles',
		'formularz.team.etykieta' => 'Assign to : ',
		'formularz.wstecz.wartosc' => 'Avbryt',
		'formularz.wybierz' => ' - velg - ',
		'formularz.zapisz.wartosc' => 'Spare',
		'formularz.zapisz_zalaczniki.wartosc' => 'Lagre vedlegg',
		'formularz.zdjecia.etykieta' => 'Filer',
		'formularz.zdjecia.opis' => '',
		'formularzEdytujZamowienieTeam.dodaj_zamowienie.etykieta' => 'Andre produkter',
		'formularzEdytujZamowienieTeam.note.etykieta' => 'Note',
		'formularzEdytujZamowienieTeam.produkty_dodatkowe.etykieta' => 'Produkter',
		'formularzEdytujZamowienieTeam.status.etykieta' => 'Status',
		'formularzEdytujZamowienieTeam.status_zamowienie_dodane.etykieta' => 'Status',
		'formularzEdytujZamowienieTeam.zapisz.wartosc' => 'Lagre',
		'formularzTypyWyszukiwanie.child_orders.etykieta' => 'Kan ha delaktiviteter',
		'formularzTypyWyszukiwanie.czysc.wartosc' => 'Klart',
		'formularzTypyWyszukiwanie.main_type.etykieta' => 'Hovedtypen',
		'formularzTypyWyszukiwanie.parent_types.etykieta' => 'Typer av vesentlig betydning',
		'formularzTypyWyszukiwanie.possible_charge_types.etykieta' => 'Type oppgjør',
		'formularzTypyWyszukiwanie.szukaj.wartosc' => 'Søk',
		'formularzTypyZamowien.formFields.etykieta' => 'Skjemafelt',
		'formularzTypyZamowien.formFields.opis' => 'Velg hvilke skjemafelt skal være synlig når du redigerer denne type ordre',
		'formularzTypyZamowien.parameters.etykieta' => 'Parametere',
		'formularzTypyZamowien.parameters.opis' => 'Parametere som konfigurerer denne ordretype - du kan fjerne unødvendige attributter hvis vil bety FALSE for dette attributtet',
		'formularzTypyZamowien.wstecz.wartosc' => 'Avbryt',
		'formularzTypyZamowien.zapisz.wartosc' => 'Lagre',
		'formularzZamknijZamowienie.przejdz_dalej' => 'Go next',
		'formularzZamowienia.appointedTime.etykieta' => 'Avtale tid',
		'formularzZamowienia.appointment.etykieta' => '',
		'formularzZamowienia.appointmentRegion.region' => 'Send til',
		'formularzZamowienia.assignToCoordinator.etykieta' => 'Koordinator',
		'formularzZamowienia.assignToTeam.etykieta' => 'Teamet',
		'formularzZamowienia.czyObciazyc.etykieta' => 'Skulle sviktende lag bli belastet for denne gjenvinning?',
		'formularzZamowienia.czyObciazyc.opis' => '',
		'formularzZamowienia.directAssignment.etykieta' => 'Ordre oppdrag',
		'formularzZamowienia.etykieta_idCoordinator' => '- Velg koordinator -',
		'formularzZamowienia.etykieta_idTeam' => '- Velg teamet -',
		'formularzZamowienia.etykieta_wybierz' => '- velg -',
		'formularzZamowienia.etykieta_wybierz_klienta' => '- Velg kunde -',
		'formularzZamowienia.idCoordinator.etykieta' => 'Koordinator',
		'formularzZamowienia.idPricedBy.etykieta' => 'Priced by',
		'formularzZamowienia.idPricedBy.opis' => '',
		'formularzZamowienia.idProjectLeaderBkt.etykieta' => 'Prosjektleder BKT',
		'formularzZamowienia.idProjectLeaderBkt.opis' => '',
		'formularzZamowienia.idProjectLeaderGetContact.etykieta' => 'Prosjektleder GET',
		'formularzZamowienia.idProjectLeaderGetContact.opis' => '',
		'formularzZamowienia.idTeam.etykieta' => 'Teamet',
		'formularzZamowienia.kategoria.etykieta' => 'Category',
		'formularzZamowienia.numberContactId.etykieta' => 'Kontaktperson',
		'formularzZamowienia.numberContactId.opis' => '',
		'formularzZamowienia.numberCustomer.etykieta' => 'Fakturering kunde',
		'formularzZamowienia.numberCustomer.opis' => '',
		'formularzZamowienia.numberPrivatCustomer.etykieta' => 'Kunde',
		'formularzZamowienia.numberPrivatCustomer.opis' => '',
		'formularzZamowienia.numberPrivatCustomer_etykieta_wybierz' => 'Søk kunde',
		'formularzZamowienia.obciazenie.etykieta' => 'Typen og størrelsen på lasten',
		'formularzZamowienia.open_order.etykieta' => '<br/>',
		'formularzZamowienia.open_order_opis' => 'Apne ordre',
		'formularzZamowienia.produkty.etykieta' => 'Produkter',
		'formularzZamowienia.produktyNiestandardowe.etykieta' => 'Produkt : ',
		'formularzZamowienia.produktyProjekt.etykieta' => 'Produkter : ',
		'formularzZamowienia.same_address.etykieta' => 'Samme adresse som kundens adresse',
		'formularzZamowienia.wstecz.wartosc' => 'Avbryt',
		'formularzZamowienia.wybierz_kategorie_produktu' => '- velg -',
		'formularzZamowienia.wybierz_produkt_niestandardowy' => ' - legge et produkt - ',
		'formularzZamowienia.zapisz.wartosc' => 'Lagre',
		'formularzZamowieniaWyszukiwanie.czysc.wartosc' => 'Klart',
		'formularzZamowieniaWyszukiwanie.date_start_do.etykieta' => 'til:',
		'formularzZamowieniaWyszukiwanie.date_start_od.etykieta' => 'Dato fra:',
		'formularzZamowieniaWyszukiwanie.domyslny_sorter_etykieta' => 'Min standard sortering',
		'formularzZamowieniaWyszukiwanie.fraza.etykieta' => 'Søkefrase:',
		'formularzZamowieniaWyszukiwanie.ma_dzieci.etykieta' => 'Med gå bestillinger:',
		'formularzZamowieniaWyszukiwanie.ma_reklamacje.etykieta' => 'Med reclamations:',
		'formularzZamowieniaWyszukiwanie.przypisane_do_mnie.etykieta' => 'Mine ordre:',
		'formularzZamowieniaWyszukiwanie.status.etykieta' => 'Status:',
		'formularzZamowieniaWyszukiwanie.status_work.etykieta' => 'Arbeid status:',
		'formularzZamowieniaWyszukiwanie.szukaj.wartosc' => 'Søk',
		'import.ajax_brak_parametru' => 'Ikke sette parameteren til å redigere',
		'import.blad_obiektu_zalacznik' => 'Ingen klient for å redde kontrakten',
		'import.blad_pliku_xls' => 'This is not a valid excel file, please try to open and save this file as .xlsx',
		'import.blad_uploadu_pdf' => 'Feil under pdf filopplasting',
		'import.blad_uploadu_xls' => 'Feil under xlsx filopplasting',
		'import.blad_zapisu_klienta_do_bazy' => 'Feil lagre klient ({id klienta}) til databasen',
		'import.blad_zaznacz_radio' => 'Ikke alle nødvendige radioknapper er valgt',
		'import.blad_zaznacz_radio_naglowek' => 'Varsling',
		'import.brak_bledow' => 'Importert bestill',
		'import.brak_pliku_pdf' => 'Pdf fil med datakontrakter ikke funnet',
		'import.brak_pliku_xls' => 'Xlsx fil med datakontrakter ikke funnet',
		'import.brak_pliku_zamowien' => 'Contrcts filer ikke funnet',
		'import.brak_produktu_w_pliku_pdf' => 'i den rekkefølgen: {number_order} ikke funnet produkt {produktet} pdf-fil',
		'import.brak_wymaganych_plikow' => 'Ikke alle nødvendige filen har blitt lastet opp',
		'import.button_zapisz_do_bazy_etykieta' => 'Lagre til database',
		'import.dodano_produkt_zakupiony_blad' => 'Feil write produkt',
		'import.dodano_produkt_zakupiony_ok' => 'Nytt produkt har blitt lagret',
		'import.formularz_blednie_wypelniony' => 'Ikke alle felt er korrekt utfylt',
		'import.formularz_brak_plikow' => 'Ingen gyldige data i opplastede filer',
		'import.generuj_tytul_zamowienia' => '{$typZamowienia} {$numerZamowienia} ({$klientId}, {$nazwaKlienta})',
		'import.importParsujDaneXls.blad_parsera_xls' => 'Feil ved behandling xls-fil ',
		'import.importujesz_pliki_do_zamowienia' => '[ETYKIETA:import.importujesz_pliki_do_zamowienia]',	//TODO
		'import.jeditable.przycisk_cancel' => 'Avbryt',
		'import.jeditable.przycisk_ok' => 'OK',
		'import.jeditable.tooltip' => 'Klikk for å redigere',
		'import.klient_istnieje_w_bazie' => 'Kunden {id_klienta} finnes allerede i databasen',
		'import.komunikat_blad_generowania_pliku_txt' => 'Feil ved oppretting av tekstfil fra pdf-fil',
		'import.nie_zapisano_zamowienia' => 'Feil ved skriving bestillinger',
		'import.nie_znaleziono_ilosci_lub_godzin' => '[ETYKIETA:import.nie_znaleziono_ilosci_lub_godzin]',	//TODO
		'import.nie_znaleziono_zamowienia' => '[ETYKIETA:import.nie_znaleziono_zamowienia]',	//TODO
		'import.nieprawidlowa_zawartosc_pliku_xls' => 'This file is not compatible with the selected order type',
		'import.parsuj_dane_pdf.brak_klienta' => 'Kunder informasjonen ikke funnet for bestillinger ',
		'import.parsuj_dane_pdf.brak_tablicy_zamowien_dla_atrybotow' => 'Ikke funnet ordrenummer å tildele attributter ',
		'import.parsuj_dane_pdf.brak_tablicy_zamowien_dla_opisu' => 'Ikke funnet ordrenummer å tildele beskrivelse ',
		'import.parsuj_dane_pdf.nieprawidlowy_numer_zamowienia' => 'Ugyldig ordrenummer, må antallet ha seks sifre',
		'import.pdf_informacja_brak_zamowien' => 'Ikke funnet bestillinger i pdf-fil',
		'import.pdf_informacja_ilosc_zamowien' => 'Antall bestillinger finnes i pdf-filen : ',
		'import.pobierz_zdjecia_nieprawidlowa_nazwa' => 'Bilde navn {nazwa_zdjecia} er ikke kompatibel med importere standarden',
		'import.polacz_tablice_brak_dopasowania_pdf' => 'Funnet forskjell i pdf fil under matchende ordre',
		'import.polacz_tablice_brak_dopasowania_xls' => 'Funnet forskjell i xlsx fil under matchende ordre, <strong> ordre nummer {$NR_ZAMOWIENIA} vil ikke bli lagret </strong>',
		'import.polacz_tablice_error_pdf_pusta' => 'Tabell over ordre fra pdf-fil er tom',
		'import.polacz_tablice_error_rozna_ilosc_zamowien' => 'Antall bestillinger funnet i xls-filen er forskjellig fra antall bestillinger finnes i pdf-fil',
		'import.polacz_tablice_error_xls_pusta' => 'Tabell over ordrer fra xlsx fil er tom',
		'import.tabela.brak_danych' => 'Ingen data funnet',
		'import.tabela.dane_naglowek' => 'Verdi : ',
		'import.tabela.etykieta_address' => 'Kunde adresse : ',
		'import.tabela.etykieta_atrybuty_zamowienia' => 'Attributter i kontrakten : ',
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
		'import.tabela.etykieta_city' => 'Kunde by : ',
		'import.tabela.etykieta_dane_1' => 'Dane : ',
		'import.tabela.etykieta_dane_klienta' => '<strong>Kundedata (pdf): </strong>',
		'import.tabela.etykieta_dane_klienta_ID' => ' kunde-ID: ',
		'import.tabela.etykieta_dane_klienta_adres' => ' Adresse : ',
		'import.tabela.etykieta_dane_klienta_apartament' => ' Apartament : ',
		'import.tabela.etykieta_dane_klienta_email' => ' E-mail : ',
		'import.tabela.etykieta_dane_klienta_imie' => ' Navn : ',
		'import.tabela.etykieta_dane_klienta_komorka' => ' Mobiltelefon : ',
		'import.tabela.etykieta_dane_klienta_tel1' => ' Telefon : ',
		'import.tabela.etykieta_dane_klienta_tel2' => ' Telefon : ',
		'import.tabela.etykieta_dane_klienta_tel3' => ' Telefon : ',
		'import.tabela.etykieta_dane_zamowienia' => 'Bestilling av data : ',
		'import.tabela.etykieta_data' => 'Dato : ',
		'import.tabela.etykieta_data_1' => 'Dato 1 : ',
		'import.tabela.etykieta_glowny_service' => 'Viktigste tjenesten : ',
		'import.tabela.etykieta_godziny_przedzial' => 'Tidsperiode : ',
		'import.tabela.etykieta_godziny_przedzial_1' => 'Tidsperiode 1 : ',
		'import.tabela.etykieta_gwiazdka_1' => 'Stjerners 1 : ',
		'import.tabela.etykieta_gwiazdka_2' => 'Stjerners 2 : ',
		'import.tabela.etykieta_gwiazdka_3' => 'Stjerners 3 : ',
		'import.tabela.etykieta_gwiazdka_4' => 'Stjerners 4 : ',
		'import.tabela.etykieta_idCustomer' => 'Kunde id : ',
		'import.tabela.etykieta_id_1' => 'Kunde id 1 : ',
		'import.tabela.etykieta_klient_id_1' => 'Kunde id 1 : ',
		'import.tabela.etykieta_klient_xls' => 'Kunde (xls) : ',
		'import.tabela.etykieta_naglowek' => 'Parameter : ',
		'import.tabela.etykieta_name' => 'Kunde navn : ',
		'import.tabela.etykieta_node_lub_villa_kod' => 'Kod villa/node : ',
		'import.tabela.etykieta_numer_get' => 'Ordretype kode : ',
		'import.tabela.etykieta_numer_get_1' => 'Ordretype kode : ',
		'import.tabela.etykieta_numer_zamowienia' => 'Bestill antall : ',
		'import.tabela.etykieta_numer_zamowienia_1' => 'Ordrenummer 1 : ',
		'import.tabela.etykieta_opis' => 'Beskrivelse (pdf) : ',
		'import.tabela.etykieta_opis_dodatkowy' => 'Ytterligere beskrivelse : ',
		'import.tabela.etykieta_opis_xls' => 'Beskrivelse fra xls : ',
		'import.tabela.etykieta_phoneMobile' => 'Kunde mobiltelefon : ',
		'import.tabela.etykieta_phoneNumber' => 'Kunde telefon : ',
		'import.tabela.etykieta_phoneNumber1' => 'Kunde telefon : ',
		'import.tabela.etykieta_poprawne' => 'Koblet z pdf : ',
		'import.tabela.etykieta_service' => 'Tjeneste : ',
		'import.tabela.etykieta_service_pdf' => 'Bestilte produkter : ',
		'import.tabela.etykieta_total_time' => 'Total tid : ',
		'import.tabela.etykieta_total_time_1' => 'Total tid 1 : ',
		'import.tabela.etykieta_tytul_zamowienia' => 'Ordrenavn',
		'import.tabela.etykieta_wycena' => 'Priset',
		'import.tabela.etykieta_zalaczniki_pdf' => 'Vedlegg : ',
		'import.tabela.etykieta_zdjecie' => 'Vedlegg : ',
		'import.tabela.import_bez_zalacznika' => '<span class="label label-warning">Ingen vedlegg pdf</span>',
		'import.tabela.import_blad_pdf' => '<span class="label label-warning">Ikke funnet i pdf</span>',
		'import.tabela.import_blad_xls' => 'Error found in excel file',
		'import.tabela.import_blad_zdjecie' => '<span class="label label-warning">Ikke funnet i vedlegg</span>',
		'import.tabela.import_dodano_zalacznik' => '<span class="label label-success">Lagt vedlagte pdf</span>',
		'import.tabela.import_poprawny_pdf' => '<span class="label label-success">Koblet pdf</span>',
		'import.tabela.import_poprawny_xls' => 'Excel file is OK',
		'import.tabela.import_poprawny_zdjecie' => '<span class="label label-success">Lagt vedlegg</span>',
		'import.tabela.numer_zamowienia' => 'Antall : ',
		'import.tlumaczenie_pomin' => 'Hopp over dette bestillinger',
		'import.tytul_modulu' => 'Import bestillinger',
		'import.tytul_strony' => 'Import bestillinger',
		'import.tytul_strony_import_b2bbefaring' => 'Import B2B Befaring',
		'import.tytul_strony_import_digging' => 'Import Digging',
		'import.tytul_strony_import_gravebefaring' => 'Import Gravebefaring',
		'import.tytul_strony_import_villa' => 'Import villa orders',
		'import.wystapily_bledy' => 'Feil import bestillinger, sjekke systemlogger',
		'import.xls_informacja_ilosc_zamowien' => 'Antall bestillinger funnet i xls-fil : ',
		'import.zaktualizowano_klienta' => 'Kunde ({id_klienta}) har blitt oppdatert',
		'import.zaktualizowano_produkt_blad' => 'Feil oppdatering produkt',
		'import.zaktualizowano_produkt_ok' => 'Product has bean update',
		'import.zamowienie_istnieje' => '<strong style="font-size:18px;" >Merk noen av de importerte ordrer allerede finnes i databasen. Velg riktig alternativ i ordre.</strong>',
		'import.zamowienie_istnieje_aktualizuj' => 'oppdatere eksisterende',
		'import.zamowienie_istnieje_dodaj_jako_nowe' => 'legge til som ny',
		'import.zapisano_klienta_do_bazy' => 'Lagre en ny klient (({id_klienta}) til basen',
		'import.zapisano_zamowienie' => 'Nye bestillinger ({zamowienie}) er lagt til databasen',
		'import.zapiszZamowienie_brak_id_klienta' => 'Du kan ikke lagre ordren ble kunden ikke lagt',
		'import.zapiszZamowienie_brak_id_zamowienia' => 'Du kan ikke lagre vedlegg, ordren ble ikke lagt',
		'import.zapisz_produkt_error' => 'Feil handlelisten (code {product})',
		'import.zapisz_produkt_poprawne' => 'Produktet har blitt frelst (code {product})',
		'import.zapisz_produkty_pusta_tablica' => 'Tom tabell av produkter',
		'import.zapisz_zalacznik_brak_zalacznika' => 'Fil av vedlegget ikke eksisterer',
		'import.zapisz_zalacznik_error' => 'Feil lagre vedlegg',
		'import.zapisz_zalacznik_error_idObject' => 'Du har ikke skrevet inn objekt id å overføre Vedlegg',
		'import.zapisz_zalacznik_error_katalog' => 'Ingen katalog er angitt å overføre Vedlegg',
		'import.zapisz_zalacznik_error_plik' => 'Ingen bilder å flytte',
		'import.zapisz_zalacznik_ok' => 'Vedlegg er lagret',
		'import.zapisz_zamowione_produkty_brak_id_zamowienia' => 'Ordre id ikke funnet',
		'import.zaznacz_wszystkie' => 'Velg alle : ',
		'importB2b.blad_zapisu_zamowienia' => 'Filed to save {ILOSC} orders',
		'importB2b.zapisano_zamowien' => '{ILOSC} orders have been imported',
		'importGrave.dopasowano_zalacznikow' => 'Matched {ILOSC} attachments',
		'importGrave.zapisano_zamowien' => 'Save {ILOSC} orders',
		'importGrave.znaleziono_zalacznikow' => 'Found {ILOSC} attachments',
		'importGrave.znaleziono_zamowien' => 'Found {ILOSC} orders',
		'importzapiszdobazy.tytul_modulu' => 'Importere lagre til database',
		'importzapiszdobazy.tytul_strony' => 'Importere lagre til database',
		'index.bkt_id' => 'Bkt id:',
		'index.error_brak_konfiguracji_typow_zamowien' => 'Søknad feil - Ordretyper konfigurasjon kunne ikke lastes inn, ta kontakt med systemansvarlig umiddelbart.',
		'index.etykieta_add_child' => 'Legge barnet rekkefølge',
		'index.etykieta_createBefaringXls' => 'Create excel files',
		'index.etykieta_edytuj' => 'Rediger',
		'index.etykieta_import' => '[ETYKIETA:index.etykieta_import]',	//TODO
		'index.etykieta_logIn' => 'Logg innn',
		'index.etykieta_podglad' => 'Forhåndsvisning Bestill',
		'index.etykieta_potwierdz_usun' => 'Er du sikker på at du vil slette valgte raden?',
		'index.etykieta_usun' => 'Slett',
		'index.grid_etykieta_address' => 'Adresse',
		'index.grid_etykieta_budget' => 'Budsjett',
		'index.grid_etykieta_budget_spent' => 'Budsjettet brukt',
		'index.grid_etykieta_client' => 'Client',
		'index.grid_etykieta_client_contact' => 'Kontakt',
		'index.grid_etykieta_date_start' => 'Startdato',
		'index.grid_etykieta_date_stop' => 'Stopdato',
		'index.grid_etykieta_hours_interval' => 'Timer',
		'index.grid_etykieta_ilosc_dzieci' => 'Gå bestillinger',
		'index.grid_etykieta_ilosc_podzamowien' => 'Oppgaver',
		'index.grid_etykieta_ilosc_reklamacji' => 'Klager',
		'index.grid_etykieta_ilosc_zamowien' => 'Versjoner',
		'index.grid_etykieta_money_spent' => 'Penger brukt',
		'index.grid_etykieta_number_order_get' => '#GET',
		'index.grid_etykieta_order_id' => 'Id bestill',
		'index.grid_etykieta_order_name' => 'Navn',
		'index.grid_etykieta_reclamation_address' => 'Gjenvinning adresse',
		'index.grid_etykieta_reclamation_for' => 'Gjenvinning for',
		'index.grid_etykieta_status_work' => 'Arbeid status',
		'index.grid_etykieta_total_time' => 'Total tid',
		'index.tytul_modulu' => 'Bestill',
		'index.tytul_strony' => 'Bestill',
		'indexLider.additionalData_etykieta' => 'Additional Data',
		'indexLider.adres_klienta_etykieta' => 'Adresse',
		'indexLider.anuluj_sms_ajax' => 'Avbryt',
		'indexLider.atrybuty_etykieta' => 'Attributter',
		'indexLider.brak_uprawnien_do_przegladania_strony' => 'Du har ikke tillatelse til å vise siden',
		'indexLider.brak_zamowien' => 'Bestill lister er tom',
		'indexLider.czasNaZalogowaneZamowienie' => 'Husk at du har apartments i dag! Viktig å sjekke klokkeslett og utstyr.',
		'indexLider.etykieta_apartamenty_biezace' => 'Neste uke jobber',
		'indexLider.etykieta_apartamenty_wszystkie' => 'Alle jobber',
		'indexLider.etykieta_do' => 'til:',
		'indexLider.etykieta_od' => 'fra:',
		'indexLider.etykieta_podglad_projektu' => 'Apne',
		'indexLider.etykieta_produkty_zsumowane' => 'Produktliste',
		'indexLider.etykieta_suma_godzin' => 'Totalt antall arbeidstimer',
		'indexLider.etykieta_telefon' => 'tlf.',
		'indexLider.etykieta_typ_projektu_apartamenty' => '',
		'indexLider.etykieta_wersje' => 'Tidligere versjoner: ',
		'indexLider.etykieta_zaloguj' => 'Logget inn',
		'indexLider.formularzAkceptacjiNaglowek' => 'Accepted form',
		'indexLider.info_tlumaczenie' => 'Project GET ID: {ID_GET}, BKT ID: {ID_BKT}',
		'indexLider.job_description_naglowek' => 'Stillingsbeskrivelse',
		'indexLider.komunikatMaszApartamenty' => 'Remember that today you are installing apartments! Check the exact time and equipment.',
		'indexLider.komunikat_nie_przekroczony_czas' => 'The order was made faster about {CZAS} min',
		'indexLider.komunikat_przekroczony_czas' => 'Time spent on this order was exceeded about {CZAS} min.',
		'indexLider.komunikat_suma_nie_przekroczony_czas' => 'Today you are {CZAS} minutes faster than the sum of the declared time on orders.',
		'indexLider.komunikat_suma_przekroczony_czas' => 'Today you spent {CZAS} minutes more than the sum of the declared time on orders.',
		'indexLider.liczba_godzin' => '{HOURS}h',
		'indexLider.lista_apartamentow_etykieta' => 'Liste over leiligheter',
		'indexLider.maile_naglowek' => 'E-mails sent regarding this order',
		'indexLider.note_naglowek' => 'Notater',
		'indexLider.note_pierwsza_tura_naglowek' => 'Notater fra første runde',
		'indexLider.numer_klienta_etykieta' => 'Kundenummer',
		'indexLider.obecniePrzypisani_naglowek' => 'Tilordnet ordren',
		'indexLider.pobierz_etykieta' => 'Nedlasting',
		'indexLider.podglad_etykieta' => 'Forhåndsvisning',
		'indexLider.potwierdz_usun_komunikat' => 'Er du sikker på at du vil slette denne ordren?',
		'indexLider.potwierdz_usun_naglowek' => 'Bekrefte',
		'indexLider.pozostalyCzasNaZamowienie' => 'You have left <span class="pozostaloSekund" style="font-weight:bold;" ></span> to finish this order ',
		'indexLider.price_etykieta' => 'Pris',
		'indexLider.priced_by_etykieta' => 'Priset av',
		'indexLider.procent_etykieta' => '% / antall',
		'indexLider.procent_price_etykieta' => 'Fakturense',
		'indexLider.projekt_lider_bkt_etykieta' => 'Prosjektleder BKT',
		'indexLider.projekt_lider_get_etykieta' => 'Kunde Prosjektleder',
		'indexLider.projektyLideraBktNaglowek' => 'Du er leder for Prosjekter:',
		'indexLider.projektyNaglowek' => 'Prosjekter',
		'indexLider.przekroczonyCzas' => 'You have exceeded the time <span class="pozostaloSekund" style="font-weight:bold;" ></span> for this order. Product <strong>Løpende timer</strong> will be added automatically',
		'indexLider.quantity_etykieta' => 'Nummer',
		'indexLider.service_etykieta' => 'Bestilte produktet',
		'indexLider.service_zakupione_etykieta' => 'Produkter valgt av teamet',
		'indexLider.service_zakupione_poprawione_etykieta' => 'Produkter korrigert av veileder',
		'indexLider.sms_edytuj_etykieta' => 'Rediger',
		'indexLider.sms_naglowek' => 'SMS-meldinger',
		'indexLider.sms_nie_wyslany' => '( <span class="red">Mislyktes</span> )',
		'indexLider.sms_wyslany' => '( Sendte )',
		'indexLider.sms_wyslij_ponownie_etykieta' => 'Send',
		'indexLider.sum_price_etykieta' => 'Sum pris',
		'indexLider.suma_godzin' => '{SUMA_GODZIN}h',
		'indexLider.suma_price_etykieta' => 'Total pris',
		'indexLider.suma_procent_price_etykieta' => 'Fakturense pris',
		'indexLider.suma_time_etykieta' => 'Total tid',
		'indexLider.telefon_klienta_etykieta' => 'Telefonen',
		'indexLider.time_etykieta' => 'Tid',
		'indexLider.tytul_modulu' => 'Liste over bestillinger',
		'indexLider.tytul_modulu_sms_nie_wyslane' => 'Liste over usendte sms',
		'indexLider.tytul_modulu_zamkniete' => 'Liste over tidligere bestillinger',
		'indexLider.tytul_strony' => 'Liste over bestillinger',
		'indexLider.tytul_strony_sms_nie_wyslane' => 'Liste over usendte sms',
		'indexLider.tytul_strony_zamkniete' => 'Liste over tidligere bestillinger',
		'indexLider.villaInstalationNaglowek' => 'Installasjon og annen',
		'indexLider.wersje_naglowek' => 'Tidligere versjoner av denne rekkefølgen',
		'indexLider.zakoncz_prace_etykieta' => 'Ferdig arbeid',
		'indexLider.zalacznik_naglowek' => 'Vedlegg',
		'indexLider.zalogowany_etykieta' => 'Logget inn',
		'indexLider.zamkniete_zamowienia_daty_info' => 'Ordrer lukket med en rekke datoer fra : {$dataStartOd} til : {$dataStartDo}',
		'indexLider.zapisz_sms_ajax' => 'Spare',
		'index_addOrder.etykietaMenu' => 'Skape orden',
		'index_import.etykietaMenu' => 'Import bestillinger',
		'index_index.etykietaMenu' => 'Liste over bestillinger',
		'index_orderTypes.etykietaMenu' => 'Administrer ordretyper',
		'logIn.blad_dodawania_klienta' => 'Error has occured while adding customer.',
		'logIn.blad_dodawania_zamowienia' => 'Feil ved ny ordre',
		'logIn.sms_wylogowanie_b2b' => 'Information : {$zamowienie} has not been done and returned to the pool of open orders',
		'logInLogOut.sciezka_lista_zamowien' => 'Dine Ordre',
		'logInLogOutKrok2.czas_z_lopendetimer' => 'Hours from lopende timer',
		'logInLogOutKrok2.czas_z_produktow' => 'Hours from products',
		'logInLogOutKrok2.godzinyProduktuTxt' => 'Hours',
		'logInLogOutKrok2.godziny_info' => 'Time per team / (time per user)',
		'logInLogOutKrok2.iloscProduktuTxt' => 'Quantity',
		'logInLogOutKrok2.info_przekroczony_czas' => 'Your team has spent {CZAS_LOPENDE_USR} more than expected. In the note, please explain why.',
		'logInLogOutKrok2.info_szybciej' => 'You completed the order faster by {CZAS_SZYBCIEJ_USR}. Congratulations, you are wonderful.',
		'logInLogOutKrok2.lista_produktow' => 'List of products you have chosen',
		'logInLogOutKrok2.naglowek_info' => 'Details of the order {ZAMOWIENIE_WO}',
		'logInLogOutKrok2.naglowke_lopende' => 'Product added by system',
		'logInLogOutKrok2.nazwaProduktuTxt' => 'Product',
		'logInLogOutKrok2.przepracowane_godziny' => 'Worked hours',
		'logInLogOutKrok2.sumaGodzinTxt' => 'Sum hours :',
		'logInLogOutKrok2.tytul_modulu' => 'Order information',
		'logInLogOutKrok2.tytul_strony' => 'Order information',
		'login.apartament_posiada_dzieci' => 'Denne leiligheten har tildelt ekstra for, du kan se dem ved å klikke på lenken <a class="btn btn-primary" href="{$LINK}">link</a>',
		'login.blad_logowania' => 'Logg mislyktes',
		'login.blad_sms' => 'Kunne ikke sende sms',
		'login.koniec_pracy' => 'Du har blitt logget ut av siste ordre for i dag. Bare ett trinn og du er fri for i dag :-). Vennligst sjekk om alt er OK ...',
		'login.link_wyloguj_etykieta' => 'Logg outguj av oppgaver',
		'login.link_zaloguj_etykieta' => 'Logg inn til forskjellige oppgaver',
		'login.link_zamknij_order_etykieta' => 'Tett rekkefølge',
		'login.nie_mozesz_logowac_do_zadania' => 'Du kan ikke logge på oppgaven',
		'login.nie_mozesz_wylogowac_z_zadania' => 'Du kan ikke logge ut av oppgavene',
		'login.nie_mozna_zalogowac_lidera' => 'Du har ikke tillatelse til å logge på en jobb',
		'login.notatka_dodaj_pozostale_godziny' => ' Estimated left time : {{$POZOSTALO_GODZIN}} h',
		'login.start_pracy_etykieta' => 'Logging skjedde : ',
		'login.tytul_modulu' => 'Logg inn til oppgaven',
		'login.tytul_modulu_info' => 'Logg inn til oppgaven : {{$zadanie}}',
		'login.tytul_strony' => 'Logg inn til oppgaven',
		'login.tytul_strony_info' => 'Logg inn til oppgaven : {{$zadanie}}',
		'login.wylogowano_z_wszystkich_zadan' => 'Du har blitt logget ut av siste ordre for',
		'login.zamowienie_tytul_etykieta' => 'Tiden du er logget inn: ',
		'login.zostales_zalogowany' => 'Pålogging var vellykket',
		'loginKrok2.komunikat_opuszczenia_strony' => 'Please use the button \"Go next\" at the bottom of the site',
		'logout.nie_mozesz_wylogowac_z_zadania' => 'Det oppstod en feil ved å logge av fra oppgaven',
		'logout.nie_mozna_zalogowac_lidera' => 'Du har ikke tillatelse til å logge av jobben',
		'logout.zostales_wylogowany' => 'Logging av var vellykket',
		'orderType.zapis_zmian_error' => 'En feil har oppstått og orden typen ble ikke lagret',
		'orderType.zapis_zmian_success' => 'Bestill typen lagret',
		'orderTypes.etykieta_charge_types' => 'Mulige charge typer',
		'orderTypes.etykieta_child_orders' => 'Kan ha barnet ordre',
		'orderTypes.etykieta_date_added' => 'Dato lagt inn',
		'orderTypes.etykieta_edytuj' => 'Rediger rekkefølge type',
		'orderTypes.etykieta_main_type' => 'Hoved type',
		'orderTypes.etykieta_name' => 'Navn',
		'orderTypes.etykieta_order_group' => 'Gruppe',
		'orderTypes.etykieta_parent_types' => 'Parent typer',
		'orderTypes.etykieta_potwierdz_usun' => 'Vil du virkelig ønsker å flytte denne rekkefølgen for å slette?',
		'orderTypes.etykieta_usun' => 'Slett',
		'orderTypes.tytul_modulu' => 'Administrer ordretyper',
		'orderTypes.tytul_strony' => 'Administrer ordretyper',
		'orderTypes_addOrderType.etykietaMenu' => 'Legg ordretype',
		'orderTypes_deletedOrderTypes.etykietaMenu' => 'Slettede ordretyper',
		'orders.etykieta_BKT' => 'Intern BKT AS',
		'orders.zapis_zmian_error' => 'En feil har oppstått og orden ble ikke lagret',
		'orders.zapis_zmian_error_usowanie_produktow' => 'Det oppstod feil under fjerning produkter fra bestilling - ordren ble ikke lagret',
		'orders.zapis_zmian_srror_produkty' => 'Det oppsto en feil under lagring av produktet - for ikke lagret på riktig måte',
		'orders.zapis_zmian_success' => 'Bestill lagret succesfully',
		'pobierzApartamentyData.brak_uprawnien' => 'Ingen tilgang',
		'pobierzApartamentyData.projekt_nie_istnieje' => 'Det valgte prosjektet ikke eksisterer',
		'previewOrder.blad_podgladu_zamowienia' => 'Feil med denne rekkefølgen forhåndsvisning!',
		'previewOrder.error_get_order_data' => 'Kan ikke få forespurt data for',
		'previewOrder.sciezka_lista_orderow_lidera' => 'Dine ordre',
		'previewOrder.sciezka_main_order' => 'Viktigste bestilling',
		'previewOrder.sciezka_suborder' => 'Suborder',
		'previewOrder.tytul_modulu' => 'Forhåndsvisning av: "{ORDER_NAME}"',
		'previewOrder.tytul_strony' => 'Forhåndsvisning rekkefølge',
		'productCorrection.przekroczono_czas_na_zamowieniu' => 'Time spent on this order was exceeded about {PRZEKROCZONY_CZAS} min.',
		'przydzielenieDoEkipy.blad_nie_mozna_wyslac_emaila' => 'Email message cannot be send.',
		'przydzielenieDoEkipy.wyslano_maila' => 'Email message was succefully sent',
		'przydzielenieDoKoordynatora.blad_nie_mozna_wyslac_emaila' => 'Email message cannot be send.',
		'przydzielenieDoKoordynatora.wyslano_maila' => 'Email message was succefully sent',
		'raport.historia_logowania_etykieta' => 'Logging in history',
		'raport.klient_adres_etykieta' => 'Address : ',
		'raport.klient_etykieta' => 'Customer',
		'raport.klient_firma_etykieta' => 'Company name : ',
		'raport.klient_nazwa_etykieta' => 'Name : ',
		'raport.naglowek' => 'Raport B2B',
		'raport.notatki_etykieta' => 'Notes',
		'raport.produkty_zakupione_etykieta' => 'Products',
		'raport.status_etykieta' => 'STATUS : ',
		'reczneCloseOrder.brak_wpisow_w_timeliscie' => 'This order has not been made ​​by any of the teams. No records found in Timelist. Are you sure you want to close this order ? <a href="{URL_ZAMKNIJ_ZAMOWIENIE}" alt="close order"> Close </a>/<a href="{URL_NIE_ZAMYKAJ}" alt="not close"> Not close </a>.',
		'reczneCloseOrder.pracownicy_zalogowani_do_zadania' => 'To this order are currently logged teams: {ZALOGOWANE_EKIPY}. The closure order will log out teams from the order. Are you sure you want to close this order ?. <a href="{URL_ZAMKNIJ_ZAMOWIENIE}" alt="close order"> Close </a> / <a href="{URL_NIE_ZAMYKAJ}" alt="not close"> not close </a>.',
		'reczneCloseOrder.zamowienie_zostalo_zamkniete' => 'Ordren er stengt',
		'reklamacja.zapis_zmian_error' => 'Gjenvinning ble ikke lagret på riktig måte. Prøv igjen senere',
		'reklamacja.zapis_zmian_error_produkty' => 'Gjenvinning ble ikke spart på grunn av spare-produkter til databasen mislyktes',
		'reklamacja.zapis_zmian_success' => 'Gjenvinning av data lagret',
		'reklamacje.etykieta_date_added' => 'Dato lagt',
		'reklamacje.etykieta_edytuj' => 'Rediger',
		'reklamacje.etykieta_hours_interval' => 'Timer',
		'reklamacje.etykieta_logIn' => 'Logg inn',
		'reklamacje.etykieta_order_name' => 'Navn klage',
		'reklamacje.etykieta_podglad' => 'Forhåndsvisning gjenvinning',
		'reklamacje.etykieta_potwierdz_usun' => 'Er du sikker på at du vil slette de valgte rad?',
		'reklamacje.etykieta_usun' => 'Slett',
		'reklamacje.etykieta_work_status' => 'status for arbeidet',
		'reklamacje.tytul_modulu_podzamowienie' => 'Redigere klage til kontrakten: #{NUMBER_GET}',
		'reklamacje.tytul_strony_podzamowienie' => 'Edit klage',
		'reopenOrder.blad_brak_zamowienia' => 'Ordre at du ønsket å gjenåpne ikke eksisterer i systemet.',
		'reopenOrder.blad_zapisu_zamowienia' => 'Feil har oppstått når forsøkt å re-åpne ordre. Denne situasjonen er logget for administratoren.',
		'reopenOrder.zamowienie_otwarte_ponownie' => 'Ordren er re-åpnet nå, og skal være synlig på denne visningen.',
		'restoreOrderType.blad_nie_mozna_pobrac_wiersza' => 'Kan ikke få utvalgte raddata, vennligst prøv igjen senere.',
		'restoreOrderType.przeniesiono_do_aktywnych_error' => 'En feil har oppstått og orden typen ble ikke gjenopprettet',
		'restoreOrderType.przeniesiono_do_aktywnych_success' => 'Ordretype gjenopprettet.',
		'restoreOrderType.tytul_modulu' => 'Gjenopprette orden typen: %s',
		'restoreOrderType.tytul_strony' => 'Gjenopprette orden typen',
		'sprawdzCzyZamknieteWGet.nie_zamkniete' => 'First You must close order in GET system',
		'sprawdzCzyZamknieteWGet.zamowienie_nie_istnieje' => 'Order does not exist',
		'sprawdzWymaganeZalaczniki.wymagana_ilosc_zalacznikow_apartament' => 'Required number of photos for this apartment is {ILOSC}',
		'suborders.etykieta_address' => 'Adresse',
		'suborders.etykieta_charge_type' => 'Kostnad typen',
		'suborders.etykieta_client' => 'Kunde',
		'suborders.etykieta_client_faktura' => 'Faktura for',
		'suborders.etykieta_date_added' => 'Dato lagt',
		'suborders.etykieta_order_name' => 'Navn',
		'suborders.etykieta_order_type' => 'Ordere type',
		'suborders.etykieta_products' => 'Tjenester lagt',
		'suborders.etykieta_taki_sam_klient' => 'Det samme som faktura',
		'widokProjektApartamenty.daty_apartamentow_etykieta' => 'Dato',
		'widokProjektApartamenty.lista_apartamentow_etykieta' => 'Liste over leiligheter',
		'widokProjektApartamenty.lista_dat_pusta' => 'En liste over datoer er tom',
		'widokProjektApartamenty.open_orders' => 'åpne ordrer',
		'widokProjektApartamenty.projekt_nie_istnieje' => 'Prosjektet ikke eksisterer',
		'widokProjektApartamenty.pusta_lista_apartamentow' => 'Liste over leilighetene er tom',
		'widokProjektApartamenty.tytul_modulu' => 'Liste over leiligheter',
		'widokProjektApartamenty.tytul_strony' => 'Liste over leiligheter',
		'widokZamowienia.komunikat_brak_klienta' => 'Det er ingen kundedata for denne ordren. Vennligst sjekk denne rekkefølgen.',
		'widokZamowienie.etykieta_edytuj_zamowienie' => 'Rediger denne ordre',
		'widokZamowienie.etykieta_reopen_zamowienie' => 'Re-åpne ordre',
		'widokZamowienie.pokaz_powiazane' => 'Show related',
		'wyslijSmsPonownie.brak_sms_id' => 'Ikke spesifisert id sms-meldinger',
		'wyslijSmsPonownie.sms_blad_wysylania' => 'Klarte ikke å sende sms-melding',
		'wyslijSmsPonownie.sms_nie_istnieje' => 'Sms-melding ikke funnet',
		'wyslijSmsPonownie.sms_wyslany' => 'Sms meldingen er sendt',
		'zakonczDzien.blad_nie_zakonczono_wszystkich_zadan' => 'Før du lukker den dagen du trenger å lukke alle startet bestillinger først. Lukk denne ordren og enn lukke arbeidsdag.',
		'zakonczDzien.etykieta_bkt_id' => 'BKT ID: ',
		'zakonczDzien.etykieta_czy_skonczyles_o_godzinie' => 'Skriv inn den tiden du er ferdig med arbeidet',
		'zakonczDzien.etykieta_godziny_przepracowane' => 'Arbeidstid',
		'zakonczDzien.etykieta_lista_zamowien' => 'Liste over fullførte ordrene',
		'zakonczDzien.etykieta_miejscowosci' => 'Den lengste avstanden til landsbyen',
		'zakonczDzien.etykieta_ordery_wykonane' => 'Fullførte ordrene',
		'zakonczDzien.etykieta_produkty_dostarczone' => 'Forut tjenester/produkter',
		'zakonczDzien.etykieta_statystyki_dnia' => 'Statistikk over',
		'zakonczDzien.etykieta_straszak_o_godzinie' => 'Gi tid for ferdigstillelse av arbeidet, husk at programmet lagrer din posisjon ved bestemte tidsintervaller.',
		'zakonczDzien.tytul_modulu' => 'Lukk arbeidsdag: {AKTUALNA_DATA}',
		'zakonczDzien.tytul_strony' => 'Lukk arbeidsdag',
		'zamknijDzien.brak_adresu_zamowienia' => 'Ingen adresse tilgjengelig',
		'zamknijDzien.etykieta_koniecPracy' => 'Sluttid arbeid',
		'zamknijDzien.etykieta_wstecz' => 'Avbryt',
		'zamknijDzien.etykieta_zapisz' => 'Fullfør arbeidet for i dag!',
		'zamknijDzien.formularz_nie_poprawnie_wypelniony' => 'Den angitte sluttid arbeid er ikke gyldig',
		'zamknijDzien.komunikat_bladAktualizacjiTimelisty' => 'Tid List oppdateringen har mislyktes, og arbeidsdagen ble ikke lukket. Kontakt teknisk support eller prøv igjen senere.',
		'zamknijDzien.komunikat_bladZapisuNajduzszegoDystansu' => 'Den lengste distansen for i dag ble ikke lagret, og arbeidsdagen kan ikke lukkes. Kontakt teknisk support eller prøv igjen senere.',
		'zamknijDzien.komunikat_dzienJuzZamkniety' => 'Arbeidsdagen er allerede stengt - få resten :-)',
		'zamknijDzien.komunikat_dzienPozytywnieZamkniety' => 'Arbeidsdagen har blitt stengt. Nå er det på tide å få hvile :-). Ha en fin kveld!',
		'zamknijDzien.maksymalna_mozliwa_ilosc_godzin_poprawa' => 'Din totale arbeidstid overskredet tillatt {MAX_GODZIN}t. Du har sannsynligvis glemt å avslutte siste arbeidsdag! Velg riktig sluttid og dato.',
		'zamknijDzien.opis_koniecPracy' => '',
		'zamknijDzien.sciezka_lista_zamowien' => 'Dine ordre',
		'zamknijDzien.walidator_data_mniejsza_od_rozpoczecia' => 'Valgte tiden er lavere enn starten av arbeidstiden.',
		'zamknijDzien.walidator_data_za_duza' => 'Du kan ikke jobbe senere enn siste ordren ble stengt.',
		'zamknijDzien.walidator_data_za_duza_dojazd' => 'Du vei hjem ikke kan være lengre enn {GODZINY_NA_DOJAZD} time(r).',
		'zamknijDzien.walidator_data_za_duzo_godzin' => 'Din arbeidsdag skredet maksimum {MAX GODZIN} tillatt arbeidstid.',
		'zamowienieWidok.autowylogowany_alert' => 'Laget auto logget ut av denne rekkefølgen - vennligst sjekk tidsliste!',
		'zamowienieWidok.etykieta_czyNotatka' => 'Lagre notat til rapporten?',
		'zamowienieWidok.etykieta_historia_logowan' => 'Logging i historien',
		'zamowienieWidok.etykieta_historia_logowan_apartamenty' => '[ETYKIETA:zamowienieWidok.etykieta_historia_logowan_apartamenty]',	//TODO
		'zamowienieWidok.etykieta_mniej' => '[ETYKIETA:zamowienieWidok.etykieta_mniej]',	//TODO
		'zamowienieWidok.etykieta_notCharge' => 'IKKE belaste denne kunden for denne bestillingen?',
		'zamowienieWidok.etykieta_opisDoFaktury' => 'Description to invoice',
		'zamowienieWidok.etykieta_trescNotatki' => '',
		'zamowienieWidok.etykieta_waluta' => 'kr',
		'zamowienieWidok.etykieta_wiecej' => '[ETYKIETA:zamowienieWidok.etykieta_wiecej]',	//TODO
		'zamowienieWidok.etykieta_zapisz_produkty' => 'Spar',
		'zamowienieWidok.opcja_radio_notatka_wlasna' => 'Lag nytt notat',
		'zamowienieWidok.opis_czyNotatka' => '',
		'zamowienieWidok.opis_notCharge' => '',
		'zamowienieWidok.opis_opisDoFaktury' => 'This text will go to invoice under the table with product list',
		'zamowienieWidok.opis_trescNotatki' => '',
		'zamowienieWidok.productCorrectionUsunZListy' => 'Delete from list',
		'zamowienieWidok.przycisk_usun_zatwierdz_etykieta' => 'Mark som ikke sjekket',
		'zamowienieWidok.przycisk_zatwierdz_etykieta' => 'Mark som innsjekket',
		'zamowienieWidok.zamowieniaPowiazane_naglowek' => 'Denne ordren er laget av : ',
		'zmianaEkipy.blad_nie_mozna_wyslac_emaila' => 'Email message was not sent. Some error has occured.',
		'zmianaEkipy.wyslano_maila' => 'Email message was succefully sent',
		'zmianaKoordynatora.blad_nie_mozna_wyslac_emaila' => 'Email message was not sent. Some error has occured.',
		'zmianaKoordynatora.wyslano_maila' => 'Email message was succefully sent',
		'zmianaStatusu.blad_nie_mozna_wyslac_emaila' => 'Email message was not sent. Some error has occured.',
		'zmianaStatusu.wyslano_maila' => 'Email message was succefully sent',
		'zmianaTerminu.blad_nie_mozna_wyslac_emaila' => 'Email message was not sent. Some error has occured.',
		'zmianaTerminu.wyslano_maila' => 'Email message was succefully sent',

		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Liste over bestillinger',
			'wykonajIndexLider' => 'Vis lederen på tabletter',
			'wykonajImport' => 'Import bestillinger',
			'wykonajImportEdytujAjax' => 'Importere edit Ajax',
			'wykonajImportZapiszDoBazy' => 'Lagre importere til databasen',
			'wykonajZapiszPlik' => 'Lagre filer multiuploadu',
			'wykonajUsunPlik' => 'Slett filer multiuploadu',
			'wykonajUsunZalaczniki' => 'Slette vedlegg',
			'wykonajAddOrderViaGroup' => 'Opprett ny ordre via ordren gruppe',
			'wykonajAddOrder' => 'Lag ny ordre',
			'wykonajAddChildOrder' => 'Legge barnet rekkefølge',
			'wykonajEditOrder' => 'Rediger bestilling',
			'wykonajDeleteOrder' => 'Slette ordre',
			'wykonajLogInLogOut' => 'Logg inn / Logg ut',
			'wykonajOrderTypes' => 'Ordretyper ledelse',
			'wykonajAddOrderType' => 'Legg ordretype',
			'wykonajEditOrderType' => 'Redigere ordretype',
			'wykonajDeleteOrderType' => 'Slette ordretype',
			'wykonajDeletedOrderTypes' => 'Slettede ordretyper',
			'wykonajRestoreOrderType' => 'Gjenopprette slettede ordretyper',
			'wykonajNotatkiButton' => 'Memos button ajax reload',
			'wykonajPreviewOrder' => 'Forhåndsvisning Bestill',
			'wykonajAddReclamation' => 'Legg inn en klage',
			'wykonajWyszukajOrder' => 'Søke etter ordre AJAX',
			'wykonajAktualizujZamknijZadanieForm' => 'Oppdater nær ordreskjema AJAX',
			'wykonajZakonczDzien' => 'Lukk arbeidsdag',
			'wykonajReopenOrder' => 'Ordren er re-åpnet',
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
			'given price' => 'Den oppgitte pris',
			'price per hour' => 'Pris per time',
			'by products' => 'Av utvalgte produkter',
		),
		'formZamknijZamowienie.opcjeSms' => array(
			'send' => 'Send nå',
			'send_later' => 'Send senere',
			'dont_send' => 'Ikke send SMS i det hele tatt',
		),
		'formZamknijZamowienie.seriale' => array(
			'dekoder' => 'SN of dekoder number: {NUMBER}',
			'modem' => 'MAC address of device number: {NUMBER}',
			'h_dek' => 'SN of returned dekoder number: {NUMBER}',
			'h_modem' => 'MAC address of returned device number: {NUMBER}',
			'voip' => 'MAC address of VoIP box',
			'ont' => 'MAC address of ONT number: {NUMBER}',
			'air_ties' => 'SN number {NUMBER}',
			'h_airties' => 'SN number {NUMBER}',
		),
		'formZamknijZamowienie.zamknij_zamowienie_statusy' => array(
			'wykonane' => 'Ordre laget',
			'anulowane' => 'Bestill kansellert',
			'pomin_order' => 'Hoppe til neste bestilling',
			'nie_wykonane_b2b' => 'Ikke ferdig',
			'brak_klienta' => 'Kunden ikke er hjemme',
			'spoznienie' => 'Vi er sent (ikke ferdig)',
		),
		'formZamknijZamowienie.zamknij_zamowienie_zamowienie_dodatkowe_statusy' => array(
			'wykonane' => 'Ferdig',
			'nie_wykonane' => 'Ikke ferdig',
		),
		'formularzZamowienia.charge_amounts' => array(
			'10' => '10%',
			'25' => '25%',
			'50' => '50%',
			'75' => '75%',
			'100' => '100%',
		),
		'formularzZamowienia.charge_guilty_by' => array(
			'reclamation_hours' => 'Gjenvinning logget timer',
			'order_hours' => 'Bestill logget timer',
		),
		'formularzZamowienia.sendorderOptions' => array(
			'open_order' => 'Lagre som åpen rekkefølge',
			'assignToCoordinator' => 'Send til koordinator',
			'assignToTeam' => 'Send direkte til teamet',
		),
		'indexLider.statusy_pracy' => array(
			'new' => 'New',
			'in progress' => 'In progress',
			'done' => 'Done',
			'not done' => 'Not done',
		),
		'indexLider.tlumaczenia_wersje' => array(
			'opis_etykieta' => 'Stillingsbeskrivelse',
		),
		'previewOrder.etykiety_podgladu' => array(
			'LABEL-ORDER_NAME' => 'Bestillings navn',
			'LABEL-ID_ORDER_BKT' => 'BKT Order ID',
			'LABEL-NUMBER_ORDER_GET' => 'Bestill # GET',
			'LABEL-NUMBER_ORDER_BKT' => 'Bestill # BKT',
			'LABEL-NUMBER_PROJECT_GET' => 'Prosjekt # GET',
			'LABEL-CHARGE_TYPE' => 'Lad typen',
			'LABEL-DATE_ADDED' => 'Dato lagt',
			'LABEL-HOURS_INTERVAL' => 'Timer intervall',
			'LABEL-TOTAL_TIME' => 'Total tid',
			'LABEL-DATE_START' => 'Dato start',
			'LABEL-DATE_STOP' => 'Dato stopp',
			'LABEL-STATUS_WORK' => 'Arbeid status',
			'LABEL-ADDRESS' => 'Adresse',
			'LABEL-CITY' => 'By',
			'LABEL-POSTCODE' => 'Post-kode',
			'LABEL-LOCATION_LAT' => 'Latitude',
			'LABEL-LOCATION_LNG' => 'Longitude',
			'LABEL-BUDGET' => 'Budsjett',
			'LABEL-NODE_VILLA_CODE' => 'Node/Villa kode',
			'LABEL-ATTRIBUTES' => 'Attributter',
			'LABEL-JOB_DESCRIPTION' => 'Stillingsbeskrivelse',
			'LABEL-NOTES' => 'Merknader',
			'LABEL-CUSTOMER-ID' => 'Kunde-ID',
			'LABEL-CUSTOMER-IDCUSTOMER' => 'GET kunde-ID',
			'LABEL-CUSTOMER-FULLNAME' => 'Navn',
			'LABEL-CUSTOMER-FULLCOMPANYNAME' => 'Firmanavn',
			'LABEL-CUSTOMER-PHONENUMBERS' => 'Telefonnumre',
			'LABEL-CUSTOMER-NAME' => 'Navn',
			'LABEL-CUSTOMER-SECONDNAME' => 'Andre navn',
			'LABEL-CUSTOMER-SURNAME' => 'Etternavn',
			'LABEL-CUSTOMER-ORGNUMBER' => 'Org nummer',
			'LABEL-CUSTOMER-COMPANYNAME' => 'Firmanavn',
			'LABEL-CUSTOMER-ADDRESS' => 'Adresse',
			'LABEL-CUSTOMER-POSTCODE' => 'Post-kode',
			'LABEL-CUSTOMER-CITY' => 'By',
			'LABEL-CUSTOMER-PHONENUMBER' => 'Telefonnummer',
			'LABEL-CUSTOMER-PHONENUMBER1' => 'Telefon nummer to',
			'LABEL-CUSTOMER-PHONENUMBER2' => 'Telefon nummer tre',
			'LABEL-CUSTOMER-PHONEMOBILE' => 'Mobiltelefon',
			'LABEL-CUSTOMER-FAX' => 'Fax',
			'LABEL-CUSTOMER-EMAIL' => 'E-post',
			'LABEL-CUSTOMER-DATAADDED' => 'Dato lagt',
			'LABEL-CUSTOMER-WWW' => 'WWW',
			'LABEL-PRIVATCUSTOMER-ID' => 'Kunde-ID',
			'LABEL-PRIVATCUSTOMER-IDCUSTOMER' => 'GET ID',
			'LABEL-PRIVATCUSTOMER-FULLNAME' => 'Navn',
			'LABEL-PRIVATCUSTOMER-FULLCOMPANYNAME' => 'Firmanavn',
			'LABEL-PRIVATCUSTOMER-PHONENUMBERS' => 'Telefonnumre',
			'LABEL-PRIVATCUSTOMER-NAME' => 'Navn',
			'LABEL-PRIVATCUSTOMER-SECONDNAME' => 'Andre navn',
			'LABEL-PRIVATCUSTOMER-SURNAME' => 'Etternavn',
			'LABEL-PRIVATCUSTOMER-ORGNUMBER' => 'Org nummer',
			'LABEL-PRIVATCUSTOMER-COMPANYNAME' => 'Firmanavn',
			'LABEL-PRIVATCUSTOMER-ADDRESS' => 'Adresse',
			'LABEL-PRIVATCUSTOMER-POSTCODE' => 'Post-kode',
			'LABEL-PRIVATCUSTOMER-CITY' => 'By',
			'LABEL-PRIVATCUSTOMER-PHONENUMBER' => 'Telefonnummer',
			'LABEL-PRIVATCUSTOMER-PHONENUMBER1' => 'Telefonnummer to',
			'LABEL-PRIVATCUSTOMER-PHONENUMBER2' => 'Telefonnummer tre',
			'LABEL-PRIVATCUSTOMER-PHONEMOBILE' => 'Mobiltelefon',
			'LABEL-PRIVATCUSTOMER-FAX' => 'Fax',
			'LABEL-PRIVATCUSTOMER-EMAIL' => 'E-post',
			'LABEL-PRIVATCUSTOMER-DATAADDED' => 'Dato lagt',
			'LABEL-PRIVATCUSTOMER-WWW' => 'WWW',
			'LABEL-CONTACT-ID' => 'Kontakt ID',
			'LABEL-CONTACT-PHONENUMBERS' => 'Telefonnumre',
			'LABEL-CONTACT-NAME' => 'Navn',
			'LABEL-CONTACT-SECONDNAME' => 'Andre navn',
			'LABEL-CONTACT-SURNAME' => 'Etternavn',
			'LABEL-CONTACT-ADDRESS' => 'Adresse',
			'LABEL-CONTACT-POSTCODE' => 'Post-kode',
			'LABEL-CONTACT-CITY' => 'By',
			'LABEL-CONTACT-PHONENUMBER' => 'Telefonnummer',
			'LABEL-CONTACT-PHONENUMBER1' => 'Telefon nummer to',
			'LABEL-CONTACT-PHONENUMBER2' => 'Telefon nummer tre',
			'LABEL-CONTACT-PHONEMOBILE' => 'Mobiltelefon',
			'LABEL-CONTACT-FAX' => 'Fax',
			'LABEL-CONTACT-EMAIL' => 'E-post',
			'LABEL-CONTACT-DATAADDED' => 'Dato lagt',
			'LABEL-CONTACT-WWW' => 'WWW',
			'LABEL-CUSTOMER-SECTION' => 'Kunde',
			'LABEL-CONTACT-SECTION' => 'Kontaktperson',
			'LABEL-SERVICES' => 'Service',
			'LABEL-SERVICES-TOTAL' => 'Total',
			'LABEL-ATTACHEMENTS' => 'Vedlegg',
			'LABEL-ATTACHEMENTS-DOWNLOAD' => 'Nedlasting',
			'LABEL-SERVICES-NAME' => 'Navn',
			'LABEL-SERVICES-QUANTITY' => 'Antall',
			'LABEL-SERVICES-TIME' => 'Tid',
			'LABEL-SERVICES-VAT' => 'Vat',
			'LABEL-SERVICES-BRUTTO' => 'Pris',
			'LABEL-SUBORDERS' => 'Sub bestillinger',
			'LABEL-SUBORDERS-ORDER_NAME' => 'Bestillings navn',
			'LABEL-SUBORDERS-DATE_ADDED' => 'Dato lagt',
			'LABEL-SUBORDERS-DATE_START' => 'Dato start',
			'LABEL-SUBORDERS-DATE_STOP' => 'Dato stop',
			'LABEL-SUBORDERS-ORDER_TYPE' => 'Type',
			'LABEL-SUBORDERS-URL_PREVIEW' => 'Forhåndsvisning',
			'LABEL-RECLAMATIONS' => 'Klager',
			'LABEL-RECLAMATIONS-ORDER_NAME' => 'Navn',
			'LABEL-RECLAMATIONS-DATE_START' => 'Dato start',
			'LABEL-RECLAMATIONS-DATE_STOP' => 'Dato stop',
			'LABEL-RECLAMATIONS-DATE_ADDED' => 'Dato lagt',
			'LABEL-RECLAMATIONS-HOURS_INTERVAL' => 'Tid',
			'LABEL-RECLAMATIONS-URL_PREVIEW' => 'Forhåndsvisning',
		),
		'statusWork.wartosci' => array(
			'new' => 'Ny',
			'in progress' => 'In progress',
			'done' => 'Ferdig',
			'not done' => 'Ikke ferdig',
			'brak_klienta' => 'Kunden er ikke hjemme',
			'spoznienie' => 'Ankommer sent (Ikke ferdig)',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}