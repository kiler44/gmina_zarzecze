<?php
namespace Generic\Tlumaczenie\Pl\Modul\Corrections;

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
		'index.alert_brak_sprawdzonych_tresc' => 'Błąd generowania raportu',
		'index.alert_brak_sprawdzonych_tytul' => 'Nie masz żadnych sprawdzonych zamówień. raport nie może być wygenerowany.',
		'index.blad_formularza_tresc' => 'Nie wszystkie wymagane pola zostały poprawnie wypełnione, sprawdź pola oznaczone na czerwono.',
		'index.blad_formularza_tytul' => 'Błąd formularza',
		'index.brak_wynikow' => 'W wybranym zakresie dat nie ma zamówień gdzie można by poprawiać produkty',
		'index.etykieta_kwota_znaczek' => ',-',
		'index.etykieta_lista_zamowien' => 'Lista zamówień',
		'index.etykieta_money_checked' => 'Sprawdzone',
		'index.etykieta_money_counter' => 'Łączna kwota',
		'index.etykieta_order_counter' => 'Sprawdzonych',
		'index.etykieta_oznacz_sprawdzony' => 'Oznacz jako sprawdzony',
		'index.etykieta_podglad_raport' => 'Podgląd raportu',
		'index.etykieta_waluta' => 'kr',
		'index.etykieta_wykonaj_fakturowanie' => 'Wyślij do fakturowania',
		'index.etykieta_wykonaj_raport' => 'Wykonaj raport',
		'index.etykieta_wykonaj_raport_xls' => '[ETYKIETA:index.etykieta_wykonaj_raport_xls]',	//TODO
		'index.filtr_czysc.wartosc' => 'Resetuj',
		'index.filtr_dataDo.etykieta' => 'Do',
		'index.filtr_dataOd.etykieta' => 'Od',
		'index.filtr_szukaj.wartosc' => 'Szukaj',
		'index.not_charge_info' => 'To zamówienie jest bezpłatne, w związku z tym nie pojawi się na liście w przygotowaniu faktur',
		'index.tytul_modulu' => 'Korekta produktów',
		'index.tytul_modulu_edycja_raportu' => ' - edycja raportu',
		'index.tytul_strony' => 'Korekta produktów',
		'index.usun_z_listy_confirm' => 'Czy na pewno chcesz usunać to zamówienie z listy ?. Jeśli usuniesz to zamówienie nie będziesz mógł wystawić faktury za to zamówienie.',
		'makeRaport.powielone_id_obiektow_w_raporcie' => 'Próbujesz zapisać zamówienia które zostały już wysłane do raportu',
		'makeRaport.raport_zapisany' => 'Raport został zapisany',
		'makeReport.brak_sprawdzonych_zamowien' => 'W wybranym zakresie dat nie ma żadnych sprawdzonych zamówień. Sprawdź więcej zamówień lub zmień zakres dat',
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
		'makeReport.info_podsumowanie' => 'Number of orders: <span class="strong">{WSZYSTKICH_ZAMOWIEN}</span><br/> orders done: <span class="strong">{DONE_ORDERS}</span> ',
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
		'oznaczSprawdzony.blad_odczytu_zamowienia' => 'Nie odnaleziono zamówienia o podanym ID',
		'oznaczSprawdzony.blad_zapisu_do_bazy' => 'Wystąpił bład podczas zapisu do bazy dany',
		'pobierzNotatkeGet.brak_zamowienia_w_historii' => '[ETYKIETA:pobierzNotatkeGet.brak_zamowienia_w_historii]',	//TODO
		'pobierzNotatkeGet.zamowienie_nie_istnieje' => '[ETYKIETA:pobierzNotatkeGet.zamowienie_nie_istnieje]',	//TODO
		'szukaj.brak_wynikow' => 'Brak wyników wyszukiwania dla podanych kryteriów',
		'szukaj.przekroczono_ilosc_wynikow' => 'Przekroczono dopuszczalną ilość wyników (max. : {ILOSC_WYNIKOW_MAX} / wszystkich: {ILOSC_WYNIKOW}), wyniki zostały ograniczone od daty {DATA}. Zmień zakres dat aby zobaczyć interesujące dane.',
		'telefon_etykieta' => 'Sentralbord : ',
		'telefon_wartosc' => '45 45 45 02',
		'usunZamowienieZListy.blad_zapisu_zamowienia' => '[ETYKIETA:usunZamowienieZListy.blad_zapisu_zamowienia]',	//TODO
		'usunZamowienieZListy.zamowienie_nie_istnieje' => '[ETYKIETA:usunZamowienieZListy.zamowienie_nie_istnieje]',	//TODO
		'www_etykieta' => 'www',
		'www_wartosc' => 'www.bktas.no',
		'wyslijPrywatneDofakturowania.komunikat_blad_zapisu' => '[ETYKIETA:wyslijPrywatneDofakturowania.komunikat_blad_zapisu]',	//TODO
		'wyslijPrywatneDofakturowania.komunikat_zapisano' => '[ETYKIETA:wyslijPrywatneDofakturowania.komunikat_zapisano]',	//TODO
		'zapiszProdukty.blad_aktualizacji_produktu' => 'Wystąpił bład podczas aktualizacji produktu',
		'zapiszProdukty.blad_aktualizacji_zamowienia' => 'Wystąpił błąd podczas aktualizacji zamówienia',
		'zapiszProdukty.blad_dodania_nowego_produktu' => 'Wystapił błąd podczas dodawania produktu zakupionego do bazy danych',
		'zapiszProdukty.blad_usunięcia_produktu' => 'Wystąpił bład podczas usuwania produktu zakupionego z bazy danych',
		'zapiszProdukty.blad_zapisu_notatki' => 'Wystąpił bład podczas zapisu notatki do bazy danych',
		'znaczek_rozdziel' => '/',
		'zwrocTrescorderu.blad_odczytu_orderu_o_podanym_id' => 'Błąd odczytu zamówienia o podanym ID',

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