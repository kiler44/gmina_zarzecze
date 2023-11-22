<?php
namespace Generic\Tlumaczenie\En\Modul\Faktura;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie 
 * @property string $t['adres_etykieta']
 * @property string $t['adres_wartosc_post']
 * @property string $t['bankgiro_etykieta']
 * @property string $t['bankgiro_wartosc']
 * @property string $t['dodajFaktura.blad_walidacji_klient']
 * @property string $t['dodajFaktura.blad_walidacji_komunikat']
 * @property string $t['dodajFaktura.blad_walidacji_produkty']
 * @property string $t['dodajFaktura.blad_zerowa_wartosc_faktury']
 * @property string $t['dodajFaktura.etykieta_korespondencyjny']
 * @property string $t['dodajFaktura.etykieta_norm']
 * @property string $t['dodajFaktura.etykieta_nowy_adres']
 * @property string $t['dodajFaktura.tytul_modulu']
 * @property string $t['dodajFaktura.tytul_modulu_edycja']
 * @property string $t['dodajFaktura.tytul_strony']
 * @property string $t['dodajFaktura.tytul_strony_edycja']
 * @property string $t['email_etykieta']
 * @property string $t['email_wartosc']
 * @property string $t['faktura.etykieta_best_ref']
 * @property string $t['faktura.etykieta_bet_bet']
 * @property string $t['faktura.etykieta_data_platnosci']
 * @property string $t['faktura.etykieta_data_wystawienia']
 * @property string $t['faktura.etykieta_deres_ref']
 * @property string $t['faktura.etykieta_get_lider']
 * @property string $t['faktura.etykieta_innkjops_nr']
 * @property string $t['faktura.etykieta_innkjopsnr']
 * @property string $t['faktura.etykieta_innkjopsnr_pozostale']
 * @property string $t['faktura.etykieta_kundenr']
 * @property string $t['faktura.etykieta_numers']
 * @property string $t['faktura.etykieta_ordrenr']
 * @property string $t['faktura.etykieta_projekt_nr']
 * @property string $t['faktura.etykieta_prosjektnr']
 * @property string $t['faktura.etykieta_prosjektnr_pozostale']
 * @property string $t['faktura.etykieta_selger']
 * @property string $t['faktura.etykieta_sendt_pr']
 * @property string $t['faktura.etykieta_var_ref']
 * @property string $t['faktura.logo_alt']
 * @property string $t['faktura.nadawca_adres']
 * @property string $t['faktura.nadawca_etykieta']
 * @property string $t['faktura.nadawca_miasto']
 * @property string $t['faktura.nadawca_nazwa']
 * @property string $t['faktura.nadawca_nieznany']
 * @property string $t['faktura.nadawca_numer_konta']
 * @property string $t['faktura.nadawca_org_numer']
 * @property string $t['faktura.nadawca_telefon']
 * @property string $t['faktura.numer']
 * @property string $t['faktura.odbiorca_etykieta']
 * @property string $t['faktura.stopka_adres']
 * @property string $t['faktura.stopka_email']
 * @property string $t['faktura.stopka_telefon']
 * @property string $t['faktura.stopka_www']
 * @property string $t['faktura.tax_etykieta']
 * @property string $t['faktura.wartosc_bet_bet']
 * @property string $t['faktura.wartosc_var_ref']
 * @property string $t['fakturaPdf.naglowek_total']
 * @property string $t['fakturaPdf.naglowek_znaczek_av']
 * @property string $t['fakturaPdf.znaczek_av']
 * @property string $t['faktura_numer_strony']
 * @property string $t['formularzArchiwum.archiwum.etykieta']
 * @property string $t['formularzArchiwum.dodaj_etykieta']
 * @property string $t['formularzEmail.dane_podstawowe.region']
 * @property string $t['formularzEmail.email.etykieta']
 * @property string $t['formularzEmail.tekst.wartosc']
 * @property string $t['formularzEmail.wstecz.wartosc']
 * @property string $t['formularzEmail.wysleListem.etykieta']
 * @property string $t['formularzEmail.wysleListem.opis']
 * @property string $t['formularzEmail.zapisz.wartosc']
 * @property string $t['formularzEmail.zapiszEmail.etykieta']
 * @property string $t['formularzEmail.zapiszEmail.opis']
 * @property string $t['formularzFaktura.address.etykieta']
 * @property string $t['formularzFaktura.city.etykieta']
 * @property string $t['formularzFaktura.dane_dodatkowe_get.region']
 * @property string $t['formularzFaktura.deliveryAddress.region']
 * @property string $t['formularzFaktura.dodajRabat.etykieta']
 * @property string $t['formularzFaktura.etykieta_wybierz']
 * @property string $t['formularzFaktura.etykieta_wybierz_kategorie']
 * @property string $t['formularzFaktura.etykieta_wybierz_klienta']
 * @property string $t['formularzFaktura.fakturaHeading.etykieta']
 * @property string $t['formularzFaktura.fakturaHeading.opis']
 * @property string $t['formularzFaktura.nazwaFaktury.etykieta']
 * @property string $t['formularzFaktura.nazwaFaktury.opis']
 * @property string $t['formularzFaktura.numberPrivatCustomer.etykieta']
 * @property string $t['formularzFaktura.numberPrivatCustomer.opis']
 * @property string $t['formularzFaktura.postcode.etykieta']
 * @property string $t['formularzFaktura.produkty.etykieta']
 * @property string $t['formularzFaktura.produkty.opis']
 * @property string $t['formularzFaktura.project_code_get.etykieta']
 * @property string $t['formularzFaktura.project_number_get.etykieta']
 * @property string $t['formularzFaktura.ragionRabat.region']
 * @property string $t['formularzFaktura.same_address.etykieta']
 * @property string $t['formularzFaktura.wstecz.wartosc']
 * @property string $t['formularzFaktura.wybor_adresu_html.etykieta']
 * @property string $t['formularzFaktura.wybor_klienta_info']
 * @property string $t['formularzFaktura.wybor_produktow.region']
 * @property string $t['formularzFaktura.zalaczniki.region']
 * @property string $t['formularzFaktura.zalaczniki_czy.etykieta']
 * @property string $t['formularzFaktura.zalaczniki_czy.opis']
 * @property string $t['formularzFaktura.zalaczniki_input.etykieta']
 * @property string $t['formularzFaktura.zapisz.wartosc']
 * @property string $t['formularzKreditnota.dataWystawienia.etykieta']
 * @property string $t['formularzKreditnota.dataZaplaty.etykieta']
 * @property string $t['formularzKreditnota.dniPlatnosci.etykieta']
 * @property string $t['formularzKreditnota.kreditnotaPozycje.etykieta']
 * @property string $t['formularzKreditnota.wstecz.wartosc']
 * @property string $t['formularzKreditnota.zapisz.wartosc']
 * @property string $t['formularzKreditnota.zmnieszKwote.etykieta']
 * @property string $t['formularzPurring.dataWystawienia.etykieta']
 * @property string $t['formularzPurring.dataZaplaty.etykieta']
 * @property string $t['formularzPurring.iloscDniNaPlatnosc.etykieta']
 * @property string $t['formularzPurring.kwotaUpomnienia.etykieta']
 * @property string $t['grid.numer_faktura_reczna_glowna']
 * @property string $t['index.error_kwota_recznie_naglowek']
 * @property string $t['index.error_kwota_recznie_tresc']
 * @property string $t['index.error_licz_data_platnosci_naglowek']
 * @property string $t['index.error_licz_data_platnosci_tresc']
 * @property string $t['index.error_licz_dni_naglowek']
 * @property string $t['index.error_licz_dni_tresc']
 * @property string $t['index.error_wroc_fakture_naglowek']
 * @property string $t['index.error_wroc_fakture_tresc']
 * @property string $t['index.error_wyslij_fakture_naglowek']
 * @property string $t['index.error_wyslij_fakture_tresc']
 * @property string $t['index.error_wystaw_fakture_naglowek']
 * @property string $t['index.error_wystaw_fakture_tresc']
 * @property string $t['index.error_zaplac_fakture_naglowek']
 * @property string $t['index.error_zaplac_fakture_tresc']
 * @property string $t['index.etykieta_data_dodania']
 * @property string $t['index.etykieta_data_wystawienia']
 * @property string $t['index.etykieta_data_zaplaty']
 * @property string $t['index.etykieta_faktura_odbiorca']
 * @property string $t['index.etykieta_graving']
 * @property string $t['index.etykieta_ilosc_dni_na_platnosc']
 * @property string $t['index.etykieta_instalacja']
 * @property string $t['index.etykieta_kwota_do_zaplaty_brutto']
 * @property string $t['index.etykieta_kwota_do_zaplaty_netto']
 * @property string $t['index.etykieta_kwota_graving']
 * @property string $t['index.etykieta_kwota_installation']
 * @property string $t['index.etykieta_kwota_vat']
 * @property string $t['index.etykieta_kwota_zaplacona_brutto']
 * @property string $t['index.etykieta_nazwa_faktury']
 * @property string $t['index.etykieta_nazwa_projektu']
 * @property string $t['index.etykieta_numer_faktury']
 * @property string $t['index.etykieta_odbiorca']
 * @property string $t['index.etykieta_podsumowanie_brutto']
 * @property string $t['index.etykieta_podsumowanie_netto']
 * @property string $t['index.etykieta_potwierdz_usun']
 * @property string $t['index.etykieta_pozostalo_do_zaplaty']
 * @property string $t['index.etykieta_suma_brutto']
 * @property string $t['index.etykieta_suma_graving']
 * @property string $t['index.etykieta_suma_instalacje']
 * @property string $t['index.etykieta_suma_netto']
 * @property string $t['index.etykieta_suma_tax']
 * @property string $t['index.etykieta_vat']
 * @property string $t['index.etykieta_zaplacono']
 * @property string $t['index.etykieta_zaplacono_brutto']
 * @property string $t['index.tabela_etykieta_dodaj_kreditnota']
 * @property string $t['index.tabela_etykieta_dodaj_upomnienie']
 * @property string $t['index.tabela_etykieta_edytuj']
 * @property string $t['index.tabela_etykieta_faktura_podglad']
 * @property string $t['index.tabela_etykieta_faktura_zaplacona']
 * @property string $t['index.tabela_etykieta_odswierz_faktura']
 * @property string $t['index.tabela_etykieta_pokaz_zrodlo']
 * @property string $t['index.tabela_etykieta_usun']
 * @property string $t['index.tabela_etykieta_wrocDoPrzygotujFaktura']
 * @property string $t['index.tabela_etykieta_wyslij_fakture']
 * @property string $t['index.tabela_etykieta_wystaw_faktura']
 * @property string $t['index.tabela_etykieta_zalaczniki_wszystkie']
 * @property string $t['index.tytul_modulu']
 * @property string $t['index.tytul_strony']
 * @property string $t['index.zakladka_faktury_do_wystawienia']
 * @property string $t['index.zakladka_menual_invoice']
 * @property string $t['index.zakladka_search']
 * @property string $t['index.zakladka_termin1']
 * @property string $t['index.zakladka_termin2']
 * @property string $t['index.zakladka_termin3']
 * @property string $t['index.zakladka_termin4']
 * @property string $t['index.zakladka_termin5']
 * @property string $t['index.zakladka_termin6']
 * @property string $t['info_blad_daty']
 * @property string $t['inkassovarsel.nadawca_naglowek']
 * @property string $t['inkassovarsel.naglowek']
 * @property string $t['inkassovarsel.numer_konta_i_termin_platnosci']
 * @property string $t['inkassovarsel.tresc']
 * @property string $t['kr']
 * @property string $t['kreditnota.numer']
 * @property string $t['kreditnota.refering']
 * @property string $t['manuallyinvoices.tabela_etykieta_dodaj_reczna_faktura']
 * @property string $t['manuallyinvoices.tytul_modulu']
 * @property string $t['manuallyinvoices.tytul_strony']
 * @property string $t['miasto_wartosc_post']
 * @property string $t['org_numer_etykieta']
 * @property string $t['org_numer_wartosc']
 * @property string $t['pdf.etykieta_data']
 * @property string $t['pdf.etykieta_faktura_numer']
 * @property string $t['pdf.etykieta_kreditnota_numer']
 * @property string $t['pdf.etykieta_numer_klienta']
 * @property string $t['pdf.informacje_etykieta_data_platnosci']
 * @property string $t['pdf.informacje_etykieta_konto']
 * @property string $t['pdf.informacje_etykieta_kwota_zaplaty']
 * @property string $t['pdf.informacje_naglowek']
 * @property string $t['pdf.kwota_rabat_kwotowy']
 * @property string $t['pdf.kwota_rabat_procentowy']
 * @property string $t['pdf.med_fakturanr']
 * @property string $t['pdf.naglowek_cena']
 * @property string $t['pdf.naglowek_cena_lacznie']
 * @property string $t['pdf.naglowek_ilosc']
 * @property string $t['pdf.naglowek_jednostka']
 * @property string $t['pdf.naglowek_kwota_po_rabacie']
 * @property string $t['pdf.naglowek_nazwa_pozycji']
 * @property string $t['pdf.naglowek_numer_pozycji']
 * @property string $t['pdf.naglowek_rabat']
 * @property string $t['pdf.naglowek_sum']
 * @property string $t['pdf.naglowek_sum_pozycja']
 * @property string $t['pdf.naglowek_sum_total']
 * @property string $t['pdf.naglowek_tax']
 * @property string $t['pdf.naglowek_vat']
 * @property string $t['pdf.rodzaj_rabatu_kwotowy']
 * @property string $t['pdf.rodzaj_rabatu_procentowy']
 * @property string $t['pdf.tax_procent_znaczek']
 * @property string $t['pdf.waluta']
 * @property string $t['pobierzWynikiSzukaj.brak_wynikow_wyszukiwania']
 * @property string $t['pobierzWynikiSzukaj.minimalna_ilosc_znakow_informacja']
 * @property string $t['purring.nadawca_naglowek']
 * @property string $t['purring.naglowek']
 * @property string $t['purring.numer_konta_i_termin_platnosci']
 * @property string $t['purring.podpis']
 * @property string $t['purring.pozycja_pierwsza']
 * @property string $t['purring.pozycja_podsumowanie']
 * @property string $t['purring.pozycje_naglowek']
 * @property string $t['purring.tresc']
 * @property string $t['search.dodajKreditnotaEtykieta']
 * @property string $t['search.dodajUpomnienieEtykieta']
 * @property string $t['search.fraza_szukaj']
 * @property string $t['search.gravEtykieta']
 * @property string $t['search.instalEtykieta']
 * @property string $t['search.podgladFakturaEtykieta']
 * @property string $t['search.sumaNettoEtykieta']
 * @property string $t['search.szukajFrazaPlaceholder']
 * @property string $t['search.wyslijFaktureEtykieta']
 * @property string $t['search.wystawFaktureEtykieta']
 * @property string $t['search.zalacznikiLinkEtykieta']
 * @property string $t['search.zaznaczOplaconaEtykieta']
 * @property string $t['search.znaleziono_ilosc_etykieta']
 * @property string $t['telefon_etykieta']
 * @property string $t['telefon_wartosc']
 * @property string $t['www_etykieta']
 * @property string $t['www_wartosc']
 * @property string $t['zapiszFaktura.blad_brak_adresu']
 * @property string $t['zapiszFaktura.blad_brak_klienta']
 * @property string $t['zapiszFaktura.blad_brak_produktow']
 * @property string $t['zapiszFaktura.blad_cena_produktu']
 * @property string $t['zapiszFaktura.blad_ilosc_produktu']
 * @property string $t['zapiszFaktura.blad_nazwa_produktu']
 * @property string $t['zapiszFaktura.blad_odczytu_rodzica_klienta']
 * @property string $t['zapiszFaktura.blad_procent_produktu']
 * @property string $t['zapiszFaktura.blad_zapisu_faktura_dzielona']
 * @property string $t['zapiszFaktura.blad_zapisu_faktury']
 * @property string $t['zapiszNaglowek.blad_odczytu_faktury_id']
 * @property string $t['zapiszNaglowek.blad_zapisu_naglowka']
 * @property string $t['zapiszNaglowek.success_zapisu_naglowka']
 * @property string $t['znaczek_rozdziel']
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
		'bankgiro_etykieta' => 'BANKGIRO',
		'bankgiro_wartosc' => '1503 32 27407',
		'dodajFaktura.blad_walidacji_klient' => 'Please select customer',
		'dodajFaktura.blad_walidacji_komunikat' => 'Not all of required fields are filled out properly. Please check fields with red colour.',
		'dodajFaktura.blad_walidacji_produkty' => 'Please add at least one invoice element with correct price.',
		'dodajFaktura.blad_zerowa_wartosc_faktury' => 'Please increase quantity or add additional % value. Now the invoice is zero value.',
		'dodajFaktura.etykieta_korespondencyjny' => 'Delivery address',
		'dodajFaktura.etykieta_norm' => 'Address',
		'dodajFaktura.etykieta_nowy_adres' => 'Different address',
		'dodajFaktura.tytul_modulu' => 'Create invoice manually',
		'dodajFaktura.tytul_modulu_edycja' => '[ETYKIETA:dodajFaktura.tytul_modulu_edycja]',	//TODO
		'dodajFaktura.tytul_strony' => 'Create invoice',
		'dodajFaktura.tytul_strony_edycja' => '[ETYKIETA:dodajFaktura.tytul_strony_edycja]',	//TODO
		'email_etykieta' => 'Epost : ',
		'email_wartosc' => 'kontakt@bktas.no',
		'faktura.etykieta_best_ref' => 'Best.ref.',
		'faktura.etykieta_bet_bet' => 'Bet.bet',
		'faktura.etykieta_data_platnosci' => 'Forfalls dato',
		'faktura.etykieta_data_wystawienia' => 'Faktura dato',
		'faktura.etykieta_deres_ref' => 'Deres ref.',
		'faktura.etykieta_kostsenter' => 'Kostsenter:',
		'faktura.etykieta_get_lider' => 'Get V/',
		'faktura.etykieta_innkjops_nr' => 'Get Innkjøpsnr.',
		'faktura.etykieta_innkjopsnr' => 'Get innkjøpsnr.:',
		'faktura.etykieta_innkjopsnr_pozostale' => 'Innkjøpsnr : ',
		'faktura.etykieta_kundenr' => 'Kundenr.',
		'faktura.etykieta_numers' => 'FAKTURA NR.',
		'faktura.etykieta_ordrenr' => 'Ordrenr.',
		'faktura.etykieta_projekt_nr' => 'Get Prosjekt',
		'faktura.etykieta_prosjektnr' => 'Get prosjektnr.:',
		'faktura.etykieta_prosjektnr_pozostale' => 'Prosjektnr : ',
		'faktura.etykieta_selger' => 'Selger',
		'faktura.etykieta_sendt_pr' => 'Sendt pr.',
		'faktura.etykieta_var_ref' => 'Vår ref.',
		'faktura.logo_alt' => 'Bredbånd og Kabel-TV Service AS',
		'faktura.nadawca_adres' => 'MICHELETVEIEN 37B',
		'faktura.nadawca_etykieta' => 'SELGER : ',
		'faktura.nadawca_miasto' => '1053 Oslo',
		'faktura.nadawca_nazwa' => 'Bredbånd og Kabel-TV Service AS',
		'faktura.nadawca_nieznany' => 'Author of invoices not found ',
		'faktura.nadawca_numer_konta' => 'Bankgiro {NUMER_KONTA_BANKOWEGO}',
		'faktura.nadawca_org_numer' => 'Org. nr. NO 999 301 789 MVA',
		'faktura.nadawca_telefon' => 'Telefon 45 45 45 00',
		'faktura.numer' => 'Faktura {FAKTURA_NUMER}',
		'faktura.odbiorca_etykieta' => 'SELGER : ',
		'faktura.stopka_adres' => 'Postadresse: Micheletveien 37B, 1053 Oslo /',
		'faktura.stopka_email' => 'Epost: kontakt@bktas.no /',
		'faktura.stopka_telefon' => 'Sentralbord: 45 45 45 02 /',
		'faktura.stopka_www' => 'www.bktas.no ',
		'faktura.tax_etykieta' => 'Tax',
		'faktura.wartosc_bet_bet' => 'Netto per {ILOSC_DNI_NA_PLATNOSC} dager',
		'faktura.wartosc_var_ref' => 'Trygve Hansen',
		'fakturaPdf.naglowek_total' => 'Total',
		'fakturaPdf.naglowek_znaczek_av' => '',
		'fakturaPdf.znaczek_av' => 'av',
		'faktura_numer_strony' => 'Sidenr.{PAGENO}',
		'formularzArchiwum.archiwum.etykieta' => 'Select year : ',
		'formularzArchiwum.dodaj_etykieta' => 'Create invoice manually',
		'formularzEmail.dane_podstawowe.region' => 'General data ',
		'formularzEmail.email.etykieta' => 'Email : ',
		'formularzEmail.tekst.wartosc' => 'This customer does not have email address in our database. Enter client email address and click Send invoice or go to the invoice preview to print document',
		'formularzEmail.wstecz.wartosc' => 'Cancel',
		'formularzEmail.wysleListem.etykieta' => 'Send by post',
		'formularzEmail.wysleListem.opis' => 'The customer does not have an e-mail (invoice will be sent only to faktura@bktas.no)',
		'formularzEmail.zapisz.wartosc' => 'Send invoice',
		'formularzEmail.zapiszEmail.etykieta' => 'Save email : ',
		'formularzEmail.zapiszEmail.opis' => 'Save the e-mail address in the customer data',
		'formularzFaktura.address.etykieta' => 'Address',
		'formularzFaktura.city.etykieta' => 'City',
		'formularzFaktura.dane_dodatkowe_get.region' => 'Specific details GET',
		'formularzFaktura.deliveryAddress.region' => 'Different delivery address',
		'formularzFaktura.dodajRabat.etykieta' => 'Add discount',
		'formularzFaktura.etykieta_wybierz' => 'Select one of predfined product names or type it here...',
		'formularzFaktura.etykieta_wybierz_kategorie' => 'No category',
		'formularzFaktura.etykieta_wybierz_klienta' => 'Type to search for customer...',
		'formularzFaktura.fakturaHeading.etykieta' => 'Invoice heading',
		'formularzFaktura.fakturaHeading.opis' => 'Text that will be printed ablove invoice elements as a heading',
		'formularzFaktura.nazwaFaktury.etykieta' => 'Invoice name',
		'formularzFaktura.nazwaFaktury.opis' => 'This is for your information, so you can easily identify this invoice in future.',
		'formularzFaktura.numberPrivatCustomer.etykieta' => 'Customer',
		'formularzFaktura.numberPrivatCustomer.opis' => '',
		'formularzFaktura.postcode.etykieta' => 'Post code',
		'formularzFaktura.produkty.etykieta' => 'Invoice elements',
		'formularzFaktura.produkty.opis' => '',
		'formularzFaktura.project_code_get.etykieta' => 'Project code GET',
		'formularzFaktura.project_number_get.etykieta' => 'Project # GET',
		'formularzFaktura.ragionRabat.region' => 'Discount',
		'formularzFaktura.same_address.etykieta' => 'Different delivery address?',
		'formularzFaktura.wstecz.wartosc' => 'Cancel',
		'formularzFaktura.wybor_adresu_html.etykieta' => 'Invoice address',
		'formularzFaktura.wybor_klienta_info' => 'Type to search for customer in box above or click the plus sign on the right to add new customer. Please note that if you wish to select project leader in GET you should search for that person or add new one by selecting parent company first and than "branch contact person" as customer type when creating new customer.',
		'formularzFaktura.wybor_produktow.region' => 'Invoice products',
		'formularzFaktura.zalaczniki.region' => 'Attachments',
		'formularzFaktura.zalaczniki_czy.etykieta' => 'Add attachments',
		'formularzFaktura.zalaczniki_czy.opis' => 'If you choose to add attachments this invoice must be set to be 100% paid (partial invoices with attachments are not allowed)',
		'formularzFaktura.zalaczniki_input.etykieta' => 'Attach files',
		'formularzFaktura.zapisz.wartosc' => 'Save',
		'formularzKreditnota.dataWystawienia.etykieta' => 'Date of facture : ',
		'formularzKreditnota.dataZaplaty.etykieta' => 'Date of payment : ',
		'formularzKreditnota.dniPlatnosci.etykieta' => 'Days to payment : ',
		'formularzKreditnota.kreditnotaPozycje.etykieta' => 'Products : ',
		'formularzKreditnota.wstecz.wartosc' => 'Cancel',
		'formularzKreditnota.zapisz.wartosc' => 'Save',
		'formularzKreditnota.zmnieszKwote.etykieta' => 'Reduce the amount / quantity in the project : ',
		'formularzPurring.dataWystawienia.etykieta' => 'Date of facture : ',
		'formularzPurring.dataZaplaty.etykieta' => 'Date of payment : ',
		'formularzPurring.iloscDniNaPlatnosc.etykieta' => 'Days to payment : ',
		'formularzPurring.kwotaUpomnienia.etykieta' => 'Purrebegyr : ',
		'grid.numer_faktura_reczna_glowna' => 'main',
		'index.error_kwota_recznie_naglowek' => 'Error',
		'index.error_kwota_recznie_tresc' => 'Error writing data',
		'index.error_licz_data_platnosci_naglowek' => 'Error',
		'index.error_licz_data_platnosci_tresc' => 'Error writing data',
		'index.error_licz_dni_naglowek' => 'Error',
		'index.error_licz_dni_tresc' => 'Error writing data',
		'index.error_wroc_fakture_naglowek' => '[ETYKIETA:index.error_wroc_fakture_naglowek]',	//TODO
		'index.error_wroc_fakture_tresc' => '[ETYKIETA:index.error_wroc_fakture_tresc]',	//TODO
		'index.error_wyslij_fakture_naglowek' => 'Error',
		'index.error_wyslij_fakture_tresc' => 'Error sending invoice',
		'index.error_wystaw_fakture_naglowek' => 'Error',
		'index.error_wystaw_fakture_tresc' => 'Error writing data',
		'index.error_zaplac_fakture_naglowek' => 'Error',
		'index.error_zaplac_fakture_tresc' => 'Error writing data',
		'index.etykieta_data_dodania' => 'Date added',
		'index.etykieta_data_wystawienia' => 'Date of facture',
		'index.etykieta_data_zaplaty' => 'Date of payment',
		'index.etykieta_faktura_odbiorca' => 'Recipient',
		'index.etykieta_graving' => 'Graving',
		'index.etykieta_ilosc_dni_na_platnosc' => 'Days to payment',
		'index.etykieta_instalacja' => 'Installation',
		'index.etykieta_kwota_do_zaplaty_brutto' => 'Sum with tax',
		'index.etykieta_kwota_do_zaplaty_netto' => 'Sum netto',
		'index.etykieta_kwota_graving' => 'Graving',
		'index.etykieta_kwota_installation' => 'Installation',
		'index.etykieta_kwota_vat' => 'Tax',
		'index.etykieta_kwota_zaplacona_brutto' => 'Paid',
		'index.etykieta_nazwa_faktury' => 'Name',
		'index.etykieta_nazwa_projektu' => 'Name',
		'index.etykieta_numer_faktury' => 'Invoice number',
		'index.etykieta_odbiorca' => 'Recipient',
		'index.etykieta_podsumowanie_brutto' => 'Sum price with tax',
		'index.etykieta_podsumowanie_netto' => 'Sum netto price',
		'index.etykieta_potwierdz_usun' => 'Are you sure you want to remove selected invoice',
		'index.etykieta_pozostalo_do_zaplaty' => 'Left to pay',
		'index.etykieta_suma_brutto' => 'Sum with tax',
		'index.etykieta_suma_graving' => 'Sum graving',
		'index.etykieta_suma_instalacje' => 'Sum installation',
		'index.etykieta_suma_netto' => 'Sum netto',
		'index.etykieta_suma_tax' => 'Sum tax',
		'index.etykieta_vat' => 'Tax',
		'index.etykieta_zaplacono' => 'Paid',
		'index.etykieta_zaplacono_brutto' => 'Sum paid',
		'index.tabela_etykieta_dodaj_kreditnota' => 'Add kreditnota',
		'index.tabela_etykieta_dodaj_upomnienie' => 'Add reminder',
		'index.tabela_etykieta_edytuj' => 'Edit',
		'index.tabela_etykieta_faktura_podglad' => 'Preview',
		'index.tabela_etykieta_faktura_zaplacona' => 'Paid',
		'index.tabela_etykieta_odswierz_faktura' => 'Refresh attachment',
		'index.tabela_etykieta_pokaz_zrodlo' => 'Invoice source',
		'index.tabela_etykieta_usun' => 'Delete',
		'index.tabela_etykieta_wrocDoPrzygotujFaktura' => '[ETYKIETA:index.tabela_etykieta_wrocDoPrzygotujFaktura]',	//TODO
		'index.tabela_etykieta_wyslij_fakture' => 'Send an invoice',
		'index.tabela_etykieta_wystaw_faktura' => 'Create invoice',
		'index.tabela_etykieta_zalaczniki_wszystkie' => 'Attachments',
		'index.tytul_modulu' => 'Invoices menagement',
		'index.tytul_strony' => 'Invoices menagement',
		'index.zakladka_faktury_do_wystawienia' => 'Create invoices',
		'index.zakladka_menual_invoice' => 'Partial invoices',
		'index.zakladka_search' => 'Search',
		'index.zakladka_termin1' => '1.termin',
		'index.zakladka_termin2' => '2.termin',
		'index.zakladka_termin3' => '3.termin',
		'index.zakladka_termin4' => '4.termin',
		'index.zakladka_termin5' => '5.termin',
		'index.zakladka_termin6' => '6.termin',
		'info_blad_daty' => 'Wrong date',
		'inkassovarsel.nadawca_naglowek' => 'Med hilsen',
		'inkassovarsel.naglowek' => 'INKASSOVARSEL',
		'inkassovarsel.numer_konta_i_termin_platnosci' => 'Beløpet bes innbetalt på vår konto : {NUMER_KONTA_BANKOWEGO}. <p> Dere er med dette brevet varslet i henhold til inkassolovens § 9. Om betaling ikke er mottatt innen {ILOSC_DNI_NA_PLATNOSC} dager fra dette brevets dato vil inkasso iverksettes med de meromkostninger dette kan medføre. </p><p> Ved spørsmål eller innsigelser til kravet, ta kontakt på telefon/mail.</p>',
		'inkassovarsel.tresc' => 'Vi kan ikke se å ha mottatt innbetaling for vårt utestående. <br/>Dersom deres betaling har krysset dette varslet ber vi om at dere ser bort fra henvendelsen.',
		'kr' => 'kr',
		'kreditnota.numer' => 'Kreditnota {KREDITNOTA_NUMER}',
		'kreditnota.refering' => 'Se faktura nr. {FAKTURA_NUMER} av {FAKTURA_DATA}',
		'manuallyinvoices.tabela_etykieta_dodaj_reczna_faktura' => 'Create invoice manually',
		'manuallyinvoices.tytul_modulu' => 'Partial invoices',
		'manuallyinvoices.tytul_strony' => 'Partial invoices',
		'miasto_wartosc_post' => '1053 Oslo',
		'org_numer_etykieta' => 'Org. nr.',
		'org_numer_wartosc' => 'NO 999 301 789 MVA',
		'pdf.etykieta_data' => 'Dato',
		'pdf.etykieta_faktura_numer' => 'Fakturanr',
		'pdf.etykieta_kreditnota_numer' => 'Kreditnota',
		'pdf.etykieta_numer_klienta' => 'Kundenr',
		'pdf.informacje_etykieta_data_platnosci' => 'Betalingsfrist',
		'pdf.informacje_etykieta_konto' => 'Kontonummer : ',
		'pdf.informacje_etykieta_kwota_zaplaty' => 'Beløp',
		'pdf.informacje_naglowek' => 'Betalingsdetaljer',
		'pdf.kwota_rabat_kwotowy' => ' - {RABAT_KWOTA} kr ',
		'pdf.kwota_rabat_procentowy' => ' - {RABAT_WARTOSC} % ( {RABAT_KWOTA} kr )',
		'pdf.med_fakturanr' => 'Vennligst merk betalingen med faktura nr',
		'pdf.naglowek_cena' => 'Pris',
		'pdf.naglowek_cena_lacznie' => 'Beløp',
		'pdf.naglowek_ilosc' => 'Antall',
		'pdf.naglowek_jednostka' => 'Enhet',
		'pdf.naglowek_kwota_po_rabacie' => 'SUM',
		'pdf.naglowek_nazwa_pozycji' => 'Betegnelse',
		'pdf.naglowek_numer_pozycji' => 'Varenr',
		'pdf.naglowek_rabat' => 'Rabatt',
		'pdf.naglowek_sum' => 'Mvagrl.',
		'pdf.naglowek_sum_pozycja' => 'Sum',
		'pdf.naglowek_sum_total' => 'Sum ',
		'pdf.naglowek_tax' => 'mva.',
		'pdf.naglowek_vat' => 'Tax',
		'pdf.rodzaj_rabatu_kwotowy' => 'kr',
		'pdf.rodzaj_rabatu_procentowy' => '%',
		'pdf.tax_procent_znaczek' => '%',
		'pdf.waluta' => 'Kr.',
		'pobierzWynikiSzukaj.brak_wynikow_wyszukiwania' => 'No search results',
		'pobierzWynikiSzukaj.minimalna_ilosc_znakow_informacja' => 'Enter at least 3 characters',
		'purring.nadawca_naglowek' => 'Med vennlig hilsen',
		'purring.naglowek' => 'PURRING PÅ UTESTÅENDE',
		'purring.numer_konta_i_termin_platnosci' => 'Beløpet bes innbetalt på vår konto : {NUMER_KONTA_BANKOWEGO} innen {ILOSC_DNI_NA_PLATNOSC} dager fra brevets dato.',
		'purring.podpis' => 'Trygve Hansen',
		'purring.pozycja_pierwsza' => 'Faktura nr. {FAKTURA_NUMER} med forfall {DATA_PLATNOSCI_FAKTURY_RODZICA}',
		'purring.pozycja_podsumowanie' => 'Til sammen å betale pr. {DATA_PLATNOSCI_PURRING}',
		'purring.pozycje_naglowek' => 'Vårt utestående er som følger:',
		'purring.tresc' => 'Vi kan ikke se å ha mottatt innbetaling på vårt utestående, og minner derfor om saken. <br/>Dersom deres betaling har krysset denne purringen ber vi om at dere ser bort fra denne henvendelsen',
		'search.dodajKreditnotaEtykieta' => 'Add kreditnota',
		'search.dodajUpomnienieEtykieta' => '[ETYKIETA:search.dodajUpomnienieEtykieta]',	//TODO
		'search.fraza_szukaj' => 'Search',
		'search.gravEtykieta' => 'Grav.:',
		'search.instalEtykieta' => 'Install.:',
		'search.podgladFakturaEtykieta' => 'Preview',
		'search.sumaNettoEtykieta' => 'Sum Netto',
		'search.szukajFrazaPlaceholder' => 'Enter at least 3 characters',
		'search.wyslijFaktureEtykieta' => 'Send en invoice',
		'search.wystawFaktureEtykieta' => 'Create invoice',
		'search.zalacznikiLinkEtykieta' => 'Attachments',
		'search.zaznaczOplaconaEtykieta' => 'Paid',
		'search.znaleziono_ilosc_etykieta' => 'Orders found : ',
		'telefon_etykieta' => 'Sentralbord : ',
		'telefon_wartosc' => '45 45 45 02',
		'www_etykieta' => 'www',
		'www_wartosc' => 'www.bktas.no',
		'zapiszFaktura.blad_brak_adresu' => 'The address field cannot remain empty',
		'zapiszFaktura.blad_brak_klienta' => 'Please select proper customer',
		'zapiszFaktura.blad_brak_produktow' => 'No invoice elements (products) are selected, please add at least one product.',
		'zapiszFaktura.blad_cena_produktu' => 'One of products prices is wrong. Price must be greater than 0',
		'zapiszFaktura.blad_ilosc_produktu' => 'One of products quantities is wrong. Product quantity must be greater than 0',
		'zapiszFaktura.blad_nazwa_produktu' => 'One of product names is empty. All of the products must have name',
		'zapiszFaktura.blad_odczytu_rodzica_klienta' => 'Cannot read the company data for selected contact person.',
		'zapiszFaktura.blad_procent_produktu' => 'One of product percentage is wrong. Value should be between 0 and 100%',
		'zapiszFaktura.blad_zapisu_faktura_dzielona' => 'An error has occurred during saving splitted invoice. Please try again later or contact application admin.',
		'zapiszFaktura.blad_zapisu_faktury' => 'An error has occured during creating invoice. Please try again later or contact application admin.',
		'zapiszNaglowek.blad_odczytu_faktury_id' => 'Cannot obtain selected invoice to be updated.',
		'zapiszNaglowek.blad_zapisu_naglowka' => 'Cannot save invoice heading.',
		'zapiszNaglowek.success_zapisu_naglowka' => 'Invoice heading has been updated.',
		'znaczek_rozdziel' => '/',

	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}