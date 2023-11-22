<?php
namespace Generic\Tlumaczenie\No\Modul\Faktura;

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
 * @property string $t['formularzFaktura.dane_dodatkowe_get.region']
 * @property string $t['formularzFaktura.etykieta_wybierz']
 * @property string $t['formularzFaktura.etykieta_wybierz_kategorie']
 * @property string $t['formularzFaktura.fakturaHeading.etykieta']
 * @property string $t['formularzFaktura.fakturaHeading.opis']
 * @property string $t['formularzFaktura.nazwaFaktury.etykieta']
 * @property string $t['formularzFaktura.nazwaFaktury.opis']
 * @property string $t['formularzFaktura.project_code_get.etykieta']
 * @property string $t['formularzFaktura.project_number_get.etykieta']
 * @property string $t['formularzFaktura.wybor_klienta_info']
 * @property string $t['formularzFaktura.wybor_produktow.region']
 * @property string $t['formularzFaktura.zalaczniki.region']
 * @property string $t['formularzFaktura.zalaczniki_czy.etykieta']
 * @property string $t['formularzFaktura.zalaczniki_czy.opis']
 * @property string $t['formularzFaktura.zalaczniki_input.etykieta']
 * @property string $t['formularzKreditnota.dataWystawienia.etykieta']
 * @property string $t['formularzKreditnota.dataZaplaty.etykieta']
 * @property string $t['formularzKreditnota.dniPlatnosci.etykieta']
 * @property string $t['formularzKreditnota.kreditnotaPozycje.etykieta']
 * @property string $t['formularzKreditnota.wstecz.wartosc']
 * @property string $t['formularzKreditnota.zapisz.wartosc']
 * @property string $t['formularzKreditnota.zmnieszKwote.etykieta']
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
		'dodajFaktura.blad_walidacji_klient' => 'Vennligst velg kunde',
		'dodajFaktura.blad_walidacji_komunikat' => 'Ikke alle obligatoriske felt er fylt ut riktig. Vennligst sjekk felt med rød farge.',
		'dodajFaktura.blad_walidacji_produkty' => 'Legg til minst én faktura element med riktig pris.',
		'dodajFaktura.blad_zerowa_wartosc_faktury' => 'Vennligst øke mengde eller legge til ekstra% verdi. Nå fakturaen er null verdi.',
		'dodajFaktura.etykieta_korespondencyjny' => 'Leveringsadresse',
		'dodajFaktura.etykieta_norm' => 'Adresse',
		'dodajFaktura.etykieta_nowy_adres' => 'Annen adresse',
		'dodajFaktura.tytul_modulu' => 'Skape faktura manuelt',
		'dodajFaktura.tytul_modulu_edycja' => '[ETYKIETA:dodajFaktura.tytul_modulu_edycja]',	//TODO
		'dodajFaktura.tytul_strony' => 'Skape faktura manuelt',
		'dodajFaktura.tytul_strony_edycja' => '[ETYKIETA:dodajFaktura.tytul_strony_edycja]',	//TODO
		'email_etykieta' => 'Epost : ',
		'email_wartosc' => 'kontakt@bktas.no',
		'faktura.etykieta_best_ref' => 'Best.ref.',
		'faktura.etykieta_bet_bet' => 'Bet bet.',
		'faktura.etykieta_data_platnosci' => 'Forfalls dato',
		'faktura.etykieta_data_wystawienia' => 'Fakturadato',
		'faktura.etykieta_deres_ref' => 'Deres ref.',
		'faktura.etykieta_kostsenter' => 'Kostsenter:',
		'faktura.etykieta_get_lider' => 'Get V/',
		'faktura.etykieta_innkjops_nr' => 'Get Innkjøpsnr.',
		'faktura.etykieta_innkjopsnr' => 'Get innkjøpsnr.:',
		'faktura.etykieta_innkjopsnr_pozostale' => 'Innkjøpsnr.:',
		'faktura.etykieta_kundenr' => 'Kundenr.',
		'faktura.etykieta_numers' => 'FAKTURA NR.',
		'faktura.etykieta_ordrenr' => 'Ordrenr.',
		'faktura.etykieta_projekt_nr' => 'Get Prosjekt',
		'faktura.etykieta_prosjektnr' => 'Get prosjektnr.:',
		'faktura.etykieta_prosjektnr_pozostale' => 'Prosjektnr.:',
		'faktura.etykieta_selger' => 'Selger',
		'faktura.etykieta_sendt_pr' => 'Sendt pr.',
		'faktura.etykieta_var_ref' => 'Vår ref.',
		'faktura.logo_alt' => 'Bredbånd og Kabel-TV Service AS',
		'faktura.nadawca_adres' => 'MICHELETVEIEN 37B ',
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
		'formularzEmail.dane_podstawowe.region' => 'Generelt data ',
		'formularzEmail.email.etykieta' => 'Email : ',
		'formularzEmail.tekst.wartosc' => 'Denne kunden ikke har e-postadresse i vår database. Skriv inn klient e-postadresse og klikk Send faktura eller gå til forhåndsvisning fakturaen til å skrive ut dokumentet.',
		'formularzEmail.wstecz.wartosc' => 'Avbryt',
		'formularzEmail.wysleListem.etykieta' => 'Send per post',
		'formularzEmail.wysleListem.opis' => 'Kunden har ikke en e-post',
		'formularzEmail.zapisz.wartosc' => 'Sende faktura',
		'formularzEmail.zapiszEmail.etykieta' => 'Lagre email : ',
		'formularzEmail.zapiszEmail.opis' => 'Lagre email i kundedata',
		'formularzFaktura.dane_dodatkowe_get.region' => 'Spesifikke detaljer GET',
		'formularzFaktura.etykieta_wybierz' => 'Velg',
		'formularzFaktura.etykieta_wybierz_kategorie' => 'Velg kategori',
		'formularzFaktura.fakturaHeading.etykieta' => 'Invoice heading',
		'formularzFaktura.fakturaHeading.opis' => 'Text that will be printed ablove invoice elements as a heading',
		'formularzFaktura.nazwaFaktury.etykieta' => 'Faktura navn',
		'formularzFaktura.nazwaFaktury.opis' => 'Dette er bare til orientering, slik at du kan easly identifisere denne fakturaen.',
		'formularzFaktura.project_code_get.etykieta' => 'Get prosjektnr.',
		'formularzFaktura.project_number_get.etykieta' => 'Get innkjøpsnr.',
		'formularzFaktura.wybor_klienta_info' => 'Skriv for å søke etter kunde i boksen ovenfor eller klikk på plusstegnet til høyre for å legge til ny kunde. Vær oppmerksom på at hvis du ønsker å velge prosjektleder i GET bør du søke etter den personen eller legge til nye ved å velge "gren kontaktperson" når du oppretter ny kunde.',
		'formularzFaktura.wybor_produktow.region' => 'Faktura produkter',
		'formularzFaktura.zalaczniki.region' => 'Vedlegg',
		'formularzFaktura.zalaczniki_czy.etykieta' => 'Legge til vedlegg',
		'formularzFaktura.zalaczniki_czy.opis' => 'Hvis du velger å legge til vedlegg denne fakturaen skal være satt til å være 100% betalt (delvis fakturaer med vedlegg er ikke tillatt)',
		'formularzFaktura.zalaczniki_input.etykieta' => 'Legge ved filer',
		'formularzKreditnota.dataWystawienia.etykieta' => 'Date of facture : ',
		'formularzKreditnota.dataZaplaty.etykieta' => 'Date of payment : ',
		'formularzKreditnota.dniPlatnosci.etykieta' => 'Days to payment : ',
		'formularzKreditnota.kreditnotaPozycje.etykieta' => 'Products : ',
		'formularzKreditnota.wstecz.wartosc' => 'Avbryt',
		'formularzKreditnota.zapisz.wartosc' => 'Lagre',
		'formularzKreditnota.zmnieszKwote.etykieta' => 'Reduser mengden / mengde av prosjektet:',
		'grid.numer_faktura_reczna_glowna' => 'hoved',
		'index.error_kwota_recznie_naglowek' => 'Error',
		'index.error_kwota_recznie_tresc' => 'Error writing data',
		'index.error_licz_data_platnosci_naglowek' => 'Error',
		'index.error_licz_data_platnosci_tresc' => 'Error writing data',
		'index.error_licz_dni_naglowek' => 'Error',
		'index.error_licz_dni_tresc' => 'Error writing data',
		'index.error_wroc_fakture_naglowek' => '[ETYKIETA:index.error_wroc_fakture_naglowek]',	//TODO
		'index.error_wroc_fakture_tresc' => '[ETYKIETA:index.error_wroc_fakture_tresc]',	//TODO
		'index.error_wyslij_fakture_naglowek' => 'Feil',
		'index.error_wyslij_fakture_tresc' => 'Feil under sending av faktura',
		'index.error_wystaw_fakture_naglowek' => 'Error',
		'index.error_wystaw_fakture_tresc' => 'Error writing data',
		'index.error_zaplac_fakture_naglowek' => 'Error',
		'index.error_zaplac_fakture_tresc' => 'Error writing data',
		'index.etykieta_data_dodania' => 'Dato lagt',
		'index.etykieta_data_wystawienia' => 'F.dato ',
		'index.etykieta_data_zaplaty' => 'FF.dato',
		'index.etykieta_faktura_odbiorca' => 'Fakt. adresse',
		'index.etykieta_graving' => 'Graving',
		'index.etykieta_ilosc_dni_na_platnosc' => 'dager til å betale',
		'index.etykieta_instalacja' => 'Installasjon',
		'index.etykieta_kwota_do_zaplaty_brutto' => 'Tot. Inkl. mva.',
		'index.etykieta_kwota_do_zaplaty_netto' => 'Totalt',
		'index.etykieta_kwota_graving' => 'Graving',
		'index.etykieta_kwota_installation' => 'Installation',
		'index.etykieta_kwota_vat' => 'Mva',
		'index.etykieta_kwota_zaplacona_brutto' => 'Utestående',
		'index.etykieta_nazwa_faktury' => 'Prosjekt navn',
		'index.etykieta_nazwa_projektu' => 'Prosjekt navn',
		'index.etykieta_numer_faktury' => 'Faktnr',
		'index.etykieta_odbiorca' => 'Fakt. adresse',
		'index.etykieta_podsumowanie_brutto' => 'Tot. Inkl. mva.',
		'index.etykieta_podsumowanie_netto' => 'Totalt',
		'index.etykieta_potwierdz_usun' => 'Er du sikker på at du vil slette valgte elementet',
		'index.etykieta_pozostalo_do_zaplaty' => 'Igjen til å betale',
		'index.etykieta_suma_brutto' => 'Tot. Inkl. mva.',
		'index.etykieta_suma_graving' => 'Tot. graving',
		'index.etykieta_suma_instalacje' => 'Tot. installasjon',
		'index.etykieta_suma_netto' => 'Totalt',
		'index.etykieta_suma_tax' => 'Tot. mva',
		'index.etykieta_vat' => 'Mva',
		'index.etykieta_zaplacono' => 'Utestående',
		'index.etykieta_zaplacono_brutto' => 'Tot. Utestående',
		'index.tabela_etykieta_dodaj_kreditnota' => 'Legge kreditnota',
		'index.tabela_etykieta_dodaj_upomnienie' => 'legge påminnelse',
		'index.tabela_etykieta_edytuj' => 'Redigere',
		'index.tabela_etykieta_faktura_podglad' => 'Forhåndsvisning',
		'index.tabela_etykieta_faktura_zaplacona' => 'Fakturaen betalt',
		'index.tabela_etykieta_odswierz_faktura' => 'Oppfrisknings vedlegg',
		'index.tabela_etykieta_pokaz_zrodlo' => 'Faktura kilde',
		'index.tabela_etykieta_usun' => 'Delete',
		'index.tabela_etykieta_wrocDoPrzygotujFaktura' => '[ETYKIETA:index.tabela_etykieta_wrocDoPrzygotujFaktura]',	//TODO
		'index.tabela_etykieta_wyslij_fakture' => 'Sende faktura',
		'index.tabela_etykieta_wystaw_faktura' => 'Forberede facture',
		'index.tabela_etykieta_zalaczniki_wszystkie' => '[ETYKIETA:index.tabela_etykieta_zalaczniki_wszystkie]',	//TODO
		'index.tytul_modulu' => 'Facture',
		'index.tytul_strony' => 'Facture',
		'index.zakladka_faktury_do_wystawienia' => 'Forberede facture',
		'index.zakladka_menual_invoice' => 'Manuelt facture',
		'index.zakladka_search' => 'Søke',
		'index.zakladka_termin1' => '1.termin',
		'index.zakladka_termin2' => '2.termin',
		'index.zakladka_termin3' => '3.termin',
		'index.zakladka_termin4' => '4.termin',
		'index.zakladka_termin5' => '5.termin',
		'index.zakladka_termin6' => '6.termin',
		'info_blad_daty' => 'Feil dato',
		'inkassovarsel.nadawca_naglowek' => 'Med hilsen',
		'inkassovarsel.naglowek' => 'INKASSOVARSEL',
		'inkassovarsel.numer_konta_i_termin_platnosci' => 'Beløpet bes innbetalt på vår konto : {NUMER_KONTA_BANKOWEGO}. <p> Dere er med dette brevet varslet i henhold til inkassolovens § 9. Om betaling ikke er mottatt innen {ILOSC_DNI_NA_PLATNOSC} dager fra dette brevets dato vil inkasso iverksettes med de meromkostninger dette kan medføre. </p><p> Ved spørsmål eller innsigelser til kravet, ta kontakt på telefon/mail.</p>',
		'inkassovarsel.tresc' => 'Vi kan ikke se å ha mottatt innbetaling for vårt utestående. <br/>Dersom deres betaling har krysset dette varslet ber vi om at dere ser bort fra henvendelsen.',
		'kr' => 'kr',
		'kreditnota.numer' => 'Kreditnota {KREDITNOTA_NUMER}',
		'kreditnota.refering' => 'Se faktura nr. {FAKTURA_NUMER} av {FAKTURA_DATA}',
		'manuallyinvoices.tabela_etykieta_dodaj_reczna_faktura' => 'Lag faktura manuelt',
		'manuallyinvoices.tytul_modulu' => 'Manuelt fakturaer',
		'manuallyinvoices.tytul_strony' => 'Manuelt fakturaer',
		'miasto_wartosc_post' => '1053 Oslo',
		'org_numer_etykieta' => 'Org. nr.',
		'org_numer_wartosc' => 'NO 999 301 789 MVA',
		'pdf.etykieta_data' => 'Dato',
		'pdf.etykieta_faktura_numer' => 'Fakturanr',
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
		'pdf.naglowek_sum_pozycja' => '[ETYKIETA:pdf.naglowek_sum_pozycja]',	//TODO
		'pdf.naglowek_sum_total' => 'Sum ',
		'pdf.naglowek_tax' => 'mva.',
		'pdf.naglowek_vat' => '[ETYKIETA:pdf.naglowek_vat]',	//TODO
		'pdf.rodzaj_rabatu_kwotowy' => 'kr',
		'pdf.rodzaj_rabatu_procentowy' => '%',
		'pdf.tax_procent_znaczek' => '%',
		'pdf.waluta' => 'Kr.',
		'pobierzWynikiSzukaj.brak_wynikow_wyszukiwania' => 'Ingen søkeresultater',
		'pobierzWynikiSzukaj.minimalna_ilosc_znakow_informacja' => 'Angi minimum 3 tegn',
		'purring.nadawca_naglowek' => 'Med vennlig hilsen',
		'purring.naglowek' => 'PURRING PÅ UTESTÅENDE',
		'purring.numer_konta_i_termin_platnosci' => 'Beløpet bes innbetalt på vår konto : {NUMER_KONTA_BANKOWEGO} innen {ILOSC_DNI_NA_PLATNOSC} dager fra brevets dato.',
		'purring.podpis' => 'Trygve Hansen',
		'purring.pozycja_pierwsza' => 'Faktura nr. {FAKTURA_NUMER} med forfall {DATA_PLATNOSCI_FAKTURY_RODZICA}',
		'purring.pozycja_podsumowanie' => 'Til sammen å betale pr. {DATA_PLATNOSCI_PURRING}',
		'purring.pozycje_naglowek' => 'Vårt utestående er som følger:',
		'purring.tresc' => 'Vi kan ikke se å ha mottatt innbetaling på vårt utestående, og minner derfor om saken. <br/>Dersom deres betaling har krysset denne purringen ber vi om at dere ser bort fra denne henvendelsen',
		'search.dodajKreditnotaEtykieta' => '[ETYKIETA:search.dodajKreditnotaEtykieta]',	//TODO
		'search.dodajUpomnienieEtykieta' => '[ETYKIETA:search.dodajUpomnienieEtykieta]',	//TODO
		'search.fraza_szukaj' => '[ETYKIETA:search.fraza_szukaj]',	//TODO
		'search.gravEtykieta' => '[ETYKIETA:search.gravEtykieta]',	//TODO
		'search.instalEtykieta' => '[ETYKIETA:search.instalEtykieta]',	//TODO
		'search.podgladFakturaEtykieta' => '[ETYKIETA:search.podgladFakturaEtykieta]',	//TODO
		'search.sumaNettoEtykieta' => '[ETYKIETA:search.sumaNettoEtykieta]',	//TODO
		'search.szukajFrazaPlaceholder' => '[ETYKIETA:search.szukajFrazaPlaceholder]',	//TODO
		'search.wyslijFaktureEtykieta' => '[ETYKIETA:search.wyslijFaktureEtykieta]',	//TODO
		'search.wystawFaktureEtykieta' => '[ETYKIETA:search.wystawFaktureEtykieta]',	//TODO
		'search.zalacznikiLinkEtykieta' => '[ETYKIETA:search.zalacznikiLinkEtykieta]',	//TODO
		'search.zaznaczOplaconaEtykieta' => '[ETYKIETA:search.zaznaczOplaconaEtykieta]',	//TODO
		'search.znaleziono_ilosc_etykieta' => '[ETYKIETA:search.znaleziono_ilosc_etykieta]',	//TODO
		'telefon_etykieta' => 'Sentralbord : ',
		'telefon_wartosc' => '45 45 45 02',
		'www_etykieta' => 'www',
		'www_wartosc' => 'www.bktas.no',
		'zapiszFaktura.blad_brak_adresu' => 'Adressefeltet kan ikke være tomt',
		'zapiszFaktura.blad_brak_klienta' => 'Vennligst velg riktig kunde',
		'zapiszFaktura.blad_brak_produktow' => 'Ingen fakturaelementer (produkter) er valgt, kan du legge til minst ett produkt.',
		'zapiszFaktura.blad_cena_produktu' => 'En av varer prisene er galt. Pris må være større enn 0',
		'zapiszFaktura.blad_ilosc_produktu' => 'En av varer mengder er galt. Produktmengde må være større enn 0',
		'zapiszFaktura.blad_nazwa_produktu' => 'En av produktnavn er tom. Alle produktene må ha navn',
		'zapiszFaktura.blad_odczytu_rodzica_klienta' => 'Kan du ikke lese selskapets data for valgt kontaktperson.',
		'zapiszFaktura.blad_procent_produktu' => 'En av produktet prosent er galt. Verdien bør være mellom 0 og 100%',
		'zapiszFaktura.blad_zapisu_faktura_dzielona' => 'Det har oppstått en feil under lagring delt faktura. Vennligst prøv igjen senere eller kontakt søknad admin.',
		'zapiszFaktura.blad_zapisu_faktury' => 'Det har oppstått en feil under oppretting faktura. Vennligst prøv igjen senere eller kontakt søknad admin.',
		'zapiszNaglowek.blad_odczytu_faktury_id' => 'Kan ikke få valgte fakturaen som skal oppdateres.',
		'zapiszNaglowek.blad_zapisu_naglowka' => 'Kan ikke lagre faktura overskriften.',
		'zapiszNaglowek.success_zapisu_naglowka' => 'Faktura overskriften har blitt oppdatert.',
		'znaczek_rozdziel' => '/',

	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}