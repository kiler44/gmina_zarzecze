<?php
namespace Generic\Tlumaczenie\En\Modul\Corrections;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie 
 * @property string $t['adres_etykieta']
 * @property string $t['adres_wartosc_post']
 * @property string $t['bankgiro_etykieta']
 * @property string $t['bankgiro_wartosc']
 * @property string $t['email_etykieta']
 * @property string $t['email_wartosc']
 * @property string $t['index.alert_brak_sprawdzonych_tresc']
 * @property string $t['index.alert_brak_sprawdzonych_tytul']
 * @property string $t['index.blad_formularza_tresc']
 * @property string $t['index.blad_formularza_tytul']
 * @property string $t['index.brak_wynikow']
 * @property string $t['index.etykieta_kwota_znaczek']
 * @property string $t['index.etykieta_lista_zamowien']
 * @property string $t['index.etykieta_money_checked']
 * @property string $t['index.etykieta_money_counter']
 * @property string $t['index.etykieta_order_counter']
 * @property string $t['index.etykieta_oznacz_sprawdzony']
 * @property string $t['index.etykieta_podglad_raport']
 * @property string $t['index.etykieta_waluta']
 * @property string $t['index.etykieta_wykonaj_fakturowanie']
 * @property string $t['index.etykieta_wykonaj_raport']
 * @property string $t['index.etykieta_wykonaj_raport_xls']
 * @property string $t['index.filtr_czysc.wartosc']
 * @property string $t['index.filtr_dataDo.etykieta']
 * @property string $t['index.filtr_dataOd.etykieta']
 * @property string $t['index.filtr_szukaj.wartosc']
 * @property string $t['index.not_charge_info']
 * @property string $t['index.tytul_modulu']
 * @property string $t['index.tytul_modulu_edycja_raportu']
 * @property string $t['index.tytul_strony']
 * @property string $t['index.usun_z_listy_confirm']
 * @property string $t['makeRaport.powielone_id_obiektow_w_raporcie']
 * @property string $t['makeRaport.raport_zapisany']
 * @property string $t['makeReport.brak_sprawdzonych_zamowien']
 * @property string $t['makeReport.cena_podsumowanie_dnia']
 * @property string $t['makeReport.cena_zamowienie']
 * @property string $t['makeReport.etykieta_dnia']
 * @property string $t['makeReport.etykieta_komentarz']
 * @property string $t['makeReport.etykieta_lista_produktow']
 * @property string $t['makeReport.etykieta_longest_distance']
 * @property string $t['makeReport.etykieta_page_number']
 * @property string $t['makeReport.etykieta_podsumowanie_dnia']
 * @property string $t['makeReport.etykieta_price']
 * @property string $t['makeReport.etykieta_tekst_produktow']
 * @property string $t['makeReport.etykieta_total_price_dnia']
 * @property string $t['makeReport.etykieta_waluta']
 * @property string $t['makeReport.info_podsumowanie']
 * @property string $t['makeReport.info_podsumowanie_raportu']
 * @property string $t['makeReport.logo_alt']
 * @property string $t['makeReport.longest_distance_text']
 * @property string $t['makeReport.page_of']
 * @property string $t['makeReport.podsumowanie_raportu']
 * @property string $t['makeReport.stopka_adres']
 * @property string $t['makeReport.stopka_email']
 * @property string $t['makeReport.stopka_telefon']
 * @property string $t['makeReport.work_order']
 * @property string $t['makeReport.work_order_b2bBefaring']
 * @property string $t['makeReport.work_order_graveBefaring']
 * @property string $t['miasto_wartosc_post']
 * @property string $t['org_numer_etykieta']
 * @property string $t['org_numer_wartosc']
 * @property string $t['oznaczSprawdzony.blad_odczytu_zamowienia']
 * @property string $t['oznaczSprawdzony.blad_zapisu_do_bazy']
 * @property string $t['pobierzNotatkeGet.brak_zamowienia_w_historii']
 * @property string $t['pobierzNotatkeGet.zamowienie_nie_istnieje']
 * @property string $t['szukaj.brak_wynikow']
 * @property string $t['szukaj.przekroczono_ilosc_wynikow']
 * @property string $t['telefon_etykieta']
 * @property string $t['telefon_wartosc']
 * @property string $t['usunZamowienieZListy.blad_zapisu_zamowienia']
 * @property string $t['usunZamowienieZListy.zamowienie_nie_istnieje']
 * @property string $t['www_etykieta']
 * @property string $t['www_wartosc']
 * @property string $t['wyslijPrywatneDofakturowania.komunikat_blad_zapisu']
 * @property string $t['wyslijPrywatneDofakturowania.komunikat_zapisano']
 * @property string $t['zapiszProdukty.blad_aktualizacji_produktu']
 * @property string $t['zapiszProdukty.blad_aktualizacji_zamowienia']
 * @property string $t['zapiszProdukty.blad_dodania_nowego_produktu']
 * @property string $t['zapiszProdukty.blad_usunięcia_produktu']
 * @property string $t['zapiszProdukty.blad_zapisu_notatki']
 * @property string $t['znaczek_rozdziel']
 * @property string $t['zwrocTrescorderu.blad_odczytu_orderu_o_podanym_id']
 * @property array $t['makeReport.dni_tygodnia']
 * @property string $t['makeReport.dni_tygodnia']['Monday']
 * @property string $t['makeReport.dni_tygodnia']['Tuesday']
 * @property string $t['makeReport.dni_tygodnia']['Wednesday']
 * @property string $t['makeReport.dni_tygodnia']['Thursday']
 * @property string $t['makeReport.dni_tygodnia']['Friday']
 * @property string $t['makeReport.dni_tygodnia']['Saturday']
 * @property string $t['makeReport.dni_tygodnia']['Sunday']
 * @property array $t['makeReport.standardowy_tekst_kategorie']
 * @property string $t['makeReport.standardowy_tekst_kategorie']['']
 * @property string $t['makeReport.standardowy_tekst_kategorie']['Standard']
 * @property string $t['makeReport.standardowy_tekst_kategorie']['Villa']
 * @property string $t['makeReport.standardowy_tekst_kategorie']['B2B']
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
		'email_etykieta' => 'Epost : ',
		'email_wartosc' => 'kontakt@bktas.no',
		'index.alert_brak_sprawdzonych_tresc' => 'Report generation error',
		'index.alert_brak_sprawdzonych_tytul' => 'You have no checked orders as so far. Report generation is impossible.',
		'index.blad_formularza_tresc' => 'Not all required fields are filled properly. Check those with red color.',
		'index.blad_formularza_tytul' => 'Form error',
		'index.brak_wynikow' => 'There are no orders to perform products correction in selected dates range',
		'index.etykieta_kwota_znaczek' => ',-',
		'index.etykieta_lista_zamowien' => 'Orders list',
		'index.etykieta_money_checked' => 'Checked',
		'index.etykieta_money_counter' => 'Total price',
		'index.etykieta_order_counter' => 'Checked',
		'index.etykieta_oznacz_sprawdzony' => 'Mark as checked',
		'index.etykieta_podglad_raport' => 'Preview report',
		'index.etykieta_waluta' => 'kr',
		'index.etykieta_wykonaj_fakturowanie' => 'Send to faktura',
		'index.etykieta_wykonaj_raport' => 'Make report',
		'index.etykieta_wykonaj_raport_xls' => 'Excel raport',
		'index.filtr_czysc.wartosc' => 'Reset',
		'index.filtr_dataDo.etykieta' => 'To',
		'index.filtr_dataOd.etykieta' => 'From',
		'index.filtr_szukaj.wartosc' => 'Search',
		'index.not_charge_info' => 'This order is set to don\'t charge - will not show up in preparing faktura view',
		'index.tytul_modulu' => 'Products correction',
		'index.tytul_modulu_edycja_raportu' => ' - edition of the report',
		'index.tytul_strony' => 'Products correction',
		'index.usun_z_listy_confirm' => 'Are you sure you want delete this order from list ? If You delete this order You can\'t make invoice from this orders.',
		'makeRaport.powielone_id_obiektow_w_raporcie' => 'Trying to save orders that have already been sent to the report',
		'makeRaport.raport_zapisany' => 'Reports was saved',
		'makeReport.brak_sprawdzonych_zamowien' => 'There are no checked orders for that dates range. Check more orders or change dates range',
		'makeReport.cena_podsumowanie_dnia' => 'kr {CENA},-',
		'makeReport.cena_zamowienie' => 'kr {CENA},-',
		'makeReport.etykieta_dnia' => 'Orders for: {DATA}',
		'makeReport.etykieta_komentarz' => 'Kommentar: ',
		'makeReport.etykieta_lista_produktow' => 'Order details: ',
		'makeReport.etykieta_longest_distance' => 'Longest distances of the day for each team',
		'makeReport.etykieta_page_number' => 'Page: ',
		'makeReport.etykieta_podsumowanie_dnia' => 'Summary of the day: ({DAY}) <span class="strong">{DATA}</span>',
		'makeReport.etykieta_price' => 'Sum: ',
		'makeReport.etykieta_tekst_produktow' => 'Text: ',
		'makeReport.etykieta_total_price_dnia' => 'Total sum:',
		'makeReport.etykieta_waluta' => 'kr',
		'makeReport.info_podsumowanie' => 'Number of orders: <span class="strong">{WSZYSTKICH_ZAMOWIEN}</span><br/> orders done: <span class="strong">{DONE_ORDERS}</span>',
		'makeReport.info_podsumowanie_raportu' => 'Total number of orders <span class="strong">{ILOSC_ZAMOWIEN}</span><br/> done orders: <span class="strong">{ILOSC_ZROBIONYCH}</span>',
		'makeReport.logo_alt' => 'Bredbånd og Kabel-TV Service AS',
		'makeReport.longest_distance_text' => '{TEAM} was driving to: {CITY}',
		'makeReport.page_of' => 'OF',
		'makeReport.podsumowanie_raportu' => 'Report summary from: {DATA_OD} to: {DATA_DO}',
		'makeReport.stopka_adres' => 'Addresse:<br/>MICHELETVEIEN 37B <br/>1053 Oslo',
		'makeReport.stopka_email' => 'Epost:<br/>kontakt@bktas.no',
		'makeReport.stopka_telefon' => 'Telefon:<br/>45454502',
		'makeReport.work_order' => 'WO: {WO}',
		'makeReport.work_order_b2bBefaring' => '{WO}',
		'makeReport.work_order_graveBefaring' => 'KND.NR {WO}',
		'miasto_wartosc_post' => '1053 Oslo',
		'org_numer_etykieta' => 'Org. nr.',
		'org_numer_wartosc' => 'NO 999 301 789 MVA',
		'oznaczSprawdzony.blad_odczytu_zamowienia' => 'Cannot read order with requested ID',
		'oznaczSprawdzony.blad_zapisu_do_bazy' => 'An error has occurred while saving to database',
		'pobierzNotatkeGet.brak_zamowienia_w_historii' => '[ETYKIETA:pobierzNotatkeGet.brak_zamowienia_w_historii]',	//TODO
		'pobierzNotatkeGet.zamowienie_nie_istnieje' => '[ETYKIETA:pobierzNotatkeGet.zamowienie_nie_istnieje]',	//TODO
		'szukaj.brak_wynikow' => 'No search results for the specified criteria',
		'szukaj.przekroczono_ilosc_wynikow' => 'Exceeded allowed number of results (max. : {ILOSC_WYNIKOW_MAX} / results {ILOSC_WYNIKOW}), results were limited from date {DATA}. Please change date range to see interesting data',
		'telefon_etykieta' => 'Sentralbord : ',
		'telefon_wartosc' => '45 45 45 02',
		'usunZamowienieZListy.blad_zapisu_zamowienia' => '[ETYKIETA:usunZamowienieZListy.blad_zapisu_zamowienia]',	//TODO
		'usunZamowienieZListy.zamowienie_nie_istnieje' => '[ETYKIETA:usunZamowienieZListy.zamowienie_nie_istnieje]',	//TODO
		'www_etykieta' => 'www',
		'www_wartosc' => 'www.bktas.no',
		'wyslijPrywatneDofakturowania.komunikat_blad_zapisu' => '[ETYKIETA:wyslijPrywatneDofakturowania.komunikat_blad_zapisu]',	//TODO
		'wyslijPrywatneDofakturowania.komunikat_zapisano' => '[ETYKIETA:wyslijPrywatneDofakturowania.komunikat_zapisano]',	//TODO
		'zapiszProdukty.blad_aktualizacji_produktu' => 'An error has occurred while updating product to database',
		'zapiszProdukty.blad_aktualizacji_zamowienia' => 'An error has occurred while updating order to database',
		'zapiszProdukty.blad_dodania_nowego_produktu' => 'An error has occurred while adding new product to database',
		'zapiszProdukty.blad_usunięcia_produktu' => 'An error has occurred while removing product from database',
		'zapiszProdukty.blad_zapisu_notatki' => 'An error has occurred while saving note to database',
		'znaczek_rozdziel' => '/',
		'zwrocTrescorderu.blad_odczytu_orderu_o_podanym_id' => 'Order with specified ID does not exists',

		'makeReport.dni_tygodnia' => array(
			'Monday' => 'Monday',
			'Tuesday' => 'Tuesday',
			'Wednesday' => 'Wednesday',
			'Thursday' => 'Thursday',
			'Friday' => 'Friday',
			'Saturday' => 'Saturday',
			'Sunday' => 'Sunday',
		),
		'makeReport.standardowy_tekst_kategorie' => array(
			'' => 'Digging order',
			'Standard' => 'Digging order',
			'Villa' => 'Digging for villa',
			'B2B' => 'Digging for B2B',
		),
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}