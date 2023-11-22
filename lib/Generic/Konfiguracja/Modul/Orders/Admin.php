<?php
namespace Generic\Konfiguracja\Modul\Orders;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property int $k['addReclamation.wyszukajOrder_na_stronie']
 * @property bool $k['editOrder.charge_by_products_require_any_product']
 * @property array $k['formularz.wymagane_pola']
 * @property array $k['formularzZamknijZamowienie.order_status']
 * @property array $k['import.ajax.zabron_edycji']
 * @property bool $k['import.aktualizuj_dane_klienta']
 * @property array $k['import.dozwolone_pliki']
 * @property array $k['import.dozwolone_pliki_zdjec']
 * @property array $k['import.edycja_pola_data']
 * @property array $k['import.edycja_pola_tekstarea']
 * @property string $k['import.katalog_importu']
 * @property string $k['import.katalog_zamowienia_zalaczniki']
 * @property array $k['import.kody_rol_koordynatora']
 * @property string $k['import.komenda_do_biblioteki_tika']
 * @property string $k['import.pobierz_zalaczniki_pdf_pattern']
 * @property string $k['import.pobierz_zdjecia_pattern']
 * @property int $k['import.pobierz_zdjecia_pattern_prefix_klient_id']
 * @property int $k['import.pobierz_zdjecia_pattern_prefix_nazwa']
 * @property int $k['import.pobierz_zdjecia_pattern_prefix_nr_zamowienia']
 * @property array $k['import.pola_atrybuty_zamowien']
 * @property array $k['import.pola_nie_wyswietlaj']
 * @property array $k['import.prasuj_dane_pdf.pomin_przy_opisie']
 * @property string $k['import.rola_koorydynator']
 * @property array $k['import.rozmiary_miniaturek']
 * @property array $k['import.service_tablica_cen_przsun_o_dwa']
 * @property array $k['import.service_tablica_cen_przsun_o_jeden']
 * @property array $k['import.typ_zamowienia_txt']
 * @property array $k['import.typ_zamowienia_txt_domyslny']
 * @property int $k['import.xls_wiersz_z_dane_1']
 * @property string $k['import.xls_wiersz_z_data']
 * @property int $k['import.xls_wiersz_z_data_1']
 * @property int $k['import.xls_wiersz_z_glowny_service']
 * @property int $k['import.xls_wiersz_z_godziny_przedzial']
 * @property int $k['import.xls_wiersz_z_godziny_przedzial_1']
 * @property int $k['import.xls_wiersz_z_gwiazdka_1']
 * @property int $k['import.xls_wiersz_z_gwiazdka_2']
 * @property int $k['import.xls_wiersz_z_gwiazdka_3']
 * @property int $k['import.xls_wiersz_z_gwiazdka_4']
 * @property int $k['import.xls_wiersz_z_klient_adres']
 * @property int $k['import.xls_wiersz_z_klient_id']
 * @property int $k['import.xls_wiersz_z_klient_id_1']
 * @property int $k['import.xls_wiersz_z_klient_komorka']
 * @property int $k['import.xls_wiersz_z_klient_miasto']
 * @property int $k['import.xls_wiersz_z_klient_nazwa']
 * @property int $k['import.xls_wiersz_z_klient_telefon1']
 * @property int $k['import.xls_wiersz_z_klient_telefon2']
 * @property int $k['import.xls_wiersz_z_node_lub_villa_kod']
 * @property int $k['import.xls_wiersz_z_numer_get_1']
 * @property int $k['import.xls_wiersz_z_numerem']
 * @property int $k['import.xls_wiersz_z_numerem_zamowienia']
 * @property int $k['import.xls_wiersz_z_numerem_zamowienia_1']
 * @property int $k['import.xls_wiersz_z_opis']
 * @property int $k['import.xls_wiersz_z_total_time']
 * @property int $k['import.xls_wiersz_z_total_time_1']
 * @property array $k['import.xls_wiersze_z_service']
 * @property string $k['import.zapisz_klienta_b2b']
 * @property array $k['import.zapisz_klienta_typ']
 * @property string $k['import.zapisz_klienta_typ_domyslny']
 * @property string $k['import.zapisz_zamowienie_kod_b2b']
 * @property string $k['import.zapisz_zamowienie_kod_villa']
 * @property array $k['import.zapisz_zamowienie_typ']
 * @property string $k['import.zapisz_zamowienie_typ_domyslny']
 * @property array $k['index.nie_wyswietlaj_zamowien_ze_statusami']
 * @property array $k['index.pager_konfiguracja']
 * @property array $k['index.role_tablica_pol_widocznych']
 * @property array $k['index.role_z_pelnym_dostepem']
 * @property int $k['index.wierszy_na_stronie']
 * @property array $k['indexLider.kolor_status_work']
 * @property array $k['indexLider.kolor_typ_zadania']
 * @property string $k['indexLider.kolor_wysoki_priorytet']
 * @property array $k['indexLider.status_work_kryteria']
 * @property string $k['indexLider.zdjecia_pracownikow_przedrostek']
 * @property array $k['logIn.sms_id_orders_type']
 * @property string $k['logIn.sms_kategoria_done_get']
 * @property string $k['logIn.sms_numer_tel_get']
 * @property array $k['logIn.sms_work_status_nie_wysylaj']
 * @property string $k['logIn.status_done']
 * @property string $k['logIn.status_not_done']
 * @property string $k['logIn.data_format']
 * @property string $k['orderTypes.domyslne_sortowanie']
 * @property array $k['orderTypes.pager_konfiguracja']
 * @property string $k['orderTypes.szablon_formularz_wyszukiwarka']
 * @property int $k['orderTypes.wierszy_na_stronie']
 * @property string $k['orders.domyslna_grupa_zamowien']
 * @property int $k['orders.get_id']
 * @property array $k['orders.grupy_zamowien']
 * @property array $k['orders.lista_rol_pracownikow']
 * @property string $k['orders.rola_koordynatorow']
 * @property string $k['previewOrder.format_daty']
 * @property int $k['przydzielenieDoEkipy.id_formatki_email']
 * @property int $k['przydzielenieDoKoordynatora.id_formatki_email']
 * @property string $k['reklamacje.charge_amounts']
 * @property bool $k['reklamacje.charge_guilty']
 * @property string $k['reklamacje.charge_guilty_by']
 * @property bool $k['reklamacje.possible_charge_guilty']
 * @property int $k['wyszukajKlientow.ilosc_na_stronie']
 * @property int $k['zmianaEkipy.id_formatki_email']
 * @property int $k['zmianaKoordynatora.id_formatki_email']
 * @property int $k['zmianaStatusu.id_formatki_email']
 * @property int $k['zmianaTerminu.id_formatki_email']
 * @property array $k['indexLider.tlo_zamowienia_status']
 * @property array $k['indexLider.zamowienia_zamkniete_ilosc_dni_wstecz']
 * @property array $k['zamowienieWidok.IDS_typow_godziny_razy_ilosc_pracownikow']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(
	
	'addReclamation.wyszukajOrder_na_stronie' => array(
		'maks' => '100',
		'opis' => 'Ilość wyników zwracanych w polu AJAX Select wyszukaj Order',
		'typ' => 'int',
		'wartosc' => 20,
		),
	'editOrder.id_typ_zamowienia_zezwol_zamknij' => array(
		'opis' => 'Id typów dla których możliwe jest ręczne zamykanie zamówień',
		'typ' => 'list',
		'wartosc' => array(
			4 , 5 , 6 , 7 , 25 , 8 , 3
			),
		),
	'editOrder.charge_by_products_require_any_product' => array(
		'opis' => 'If charge by products is slected some product will need to be added',
		'typ' => 'bool',
		'wartosc' => null,
		),
	'editOrder.wyswietlaj_przycisk_reopen' => array(
		'opis' => 'Wyświetla przycisk reopen order w edycji zamówienia',
		'typ' => 'bool',
		'wartosc' => true,
		),
	'formularz.wymagane_pola' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array(
			'name',
			'possibleChargeTypes',
			),
		),
	'formularzZamknijZamowienie.kategorie_produktow_zakupionych' => array(
		'opis' => 'Kategorie produktów zakupionych dla projektów',
		'typ' => 'array',
		'wartosc' => array(
				'Installation' => 'Installation',
				'Graving' => 'Graving',
			),
	),
	'formularzZamknijZamowienie.skok_produkty_na_godziny' => array(
		'opis' => 'Skok spinner dla produktów na godziny',
		'typ' => 'float',
		'wartosc' => 0.25 ,
	),
	'formularzZamknijZamowienie.min_produkty_na_godziny' => array(
		'opis' => 'Min spinner dla produktów na godziny',
		'typ' => 'float',
		'wartosc' => 0.25 ,
	),
	'formularzZamknijZamowienie.skok_produkty_na_sztuki' => array(
		'opis' => 'Skok spinner dla produktów na godziny',
		'typ' => 'float',
		'wartosc' => 1 ,
	),
	'formularzZamknijZamowienie.min_produkty_na_sztuki' => array(
		'opis' => 'Min spinner dla produktów na godziny',
		'typ' => 'float',
		'wartosc' => 1 ,
	),
	'formularzZamknijZamowienie.wyswietlaj_not_done' => array(
		'opis' => 'Id typów dla których wyświetlać status nie wykonane',
		'typ' => 'list',
		'wartosc' => array(
			2, 24, 31
			),
		),
	'formularzZamknijZamowienie.status_anulowane' => array(
		'opis' => 'Id typów dla których zmieniamy tłumaczenie dla statusu anulowane z Order canceled by GET via SMS na Order canceled',
		'typ' => 'list',
		'wartosc' => array(
			17, 26, 27, 28, 29, 31
			),
	),
	'formularzZamknijZamowienie.order_status' => array(
		'opis' => 'Statusy zamówień jakie mogą występwać przy zamykaniu zadania',
		'typ' => 'array',
		'wartosc' => array(
			0 => 'done',
			1 => 'not done',
			),
		),
	'formularzZamknijZamowienie.status_domyslny' => array(
		'opis' => 'Domyślny status przy zamykaniu zamówień',
		'typ' => 'varchar',
		'wartosc' => 'wykonane',
	),
	'formularzZamknijZamowienie.wyslij_sms_wartosc_domyslna' => array(
		'opis' => 'Domyślna wartość dla opcji wysłania raportu SMSem do Getu',
		'typ' => 'select',
		'wartosc' => 'send_later',
		'dozwolone' => array('send', 'send_later', 'dont_send'),
	),
	'formularzZamknijZamowienie.anulowane_idType_wyslij_sms' => array(
		'opis' => 'Id typów zamówień dla których ma zostać wysłany sms do GET jeżeli zamówienie ma status anulowane',
		'typ' => 'list',
		'wartosc' => array(
			1, 2
			),
	),
	'formularzZamknijZamowienie.anulowane_sms_dolacz_typ' => array(
		'opis' => 'Do sms-a wysyłanego przy anulowaniu zamówienia dołącza początek wiadomości (T712 nr_orderu , B2B ...), można użyć {$ID_ORDERS}',
		'typ' => 'bool',
		'wartosc' => 1,
	),
	'formularzZamknijZamowienie.anulowane_sms_dolacz_txt' => array(
		'opis' => 'Tekst wysyłany przy anluwoaniu zamówienia',
		'typ' => 'varchar',
		'wartosc' => ' canceled',
	),
	'formularzZamknijZamowienie.anulowane_wysylaj_sms' => array(
		'opis' => 'Włącza wysyłanie sms do anulowanych zamówień',
		'typ' => 'bool',
		'wartosc' => 0,
	),
		
	'formularzZamknijZamowienie.oznaczenie_statusu_sms' => array(
		'opis' => 'Dopisek do SMS oznaczający status zamówienia',
		'typ' => 'array',
		'wartosc' => array(
			'wykonane' => 'OK',
			'nie_wykonane' => 'ND',
		)
	),
	'formularzZamknijZamowienie.standardowa_polityka_dla_not_done' => array(
		'opis' => 'Jeśli wybierzemy NOT DONE reszta polityki bedzie zachowywała po staremu',
		'typ' => 'bool',
		'wartosc' => false,
	),
		
	'formularzZamknijZamowienie.nie_pokazuj_produktow_powyzej_wybranego' => array(
		'opis' => 'Nie będa pokazywane produkty powyżej już wybranego',
		'typ' => 'bool',
		'wartosc' => true,
	),
	
	'formularzZamknijZamowienie.nie_pokazuj_produktow_powyzej_wybranego_tyko_grupa_not_done' => array(
		'opis' => 'Nie będa pokazywane produkty powyżej już wybranego ale tylko dla produktów z grupy NOT DONE',
		'typ' => 'bool',
		'wartosc' => true,
	),
		
	'formularzZamknijZamowienie.not_done_ids_wymaganych_produktow_dodatkowych' => array(
		'opis' => 'Lista IDków produktów dodatkowych wymaganych przy NOT DONE',
		'typ' => 'list',
		'wartosc' => array(
			'5',
		),
	),
		
	'formularzZamknijZamowienie.wyswietlaj_input_szacowana_ilosc_godzin' => array(
		'opis' => 'Id typów zamówień dla których będzie wyświetlany input z szacowaną ilością godzin do końća',
		'typ' => 'list',
		'wartosc' => array(
			'24', '31',
		),
	),
	'formularzZamknijZamowienie.wyswietlajZaslepkeIframe' => array(
		'opis' => 'Włącza wyświetlanie zaślepki żeby chłopaki nie mogli zamknąć orderu jeśli Lopende timer występuje',
		'typ' => 'bool',
		'wartosc' => 1,
	),
	'podgladGet_kolor_zaslepki' => array(
		'opis' => 'Kolor tła dla zaślepki w podglądzie Getu',
		'typ' => 'varchar',
		'wartosc' => '#E9D3D9',
	),
		
	'import.nazwa_produktu_digging' => array(
		'opis' => 'Lista IDków produktów dodatkowych wymaganych przy NOT DONE',
		'typ' => 'varchar',
		'wartosc' => 'Priset av {USER_NAME}',
	),
	'import.produkty_wyjatki' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
				'TilkoblingshjelpTrådløs Boligpakke 3-pack' => "TilkoblingshjelpTrå dløs Boligpakke 3 -pack",
				'HjemleveringTrådløs Boligpakke' => "HjemleveringTrådl øs Boligpakke",
			),
	),
	'import.id_homenet_villa' => array(
		'opis' => 'Id homenet villa',
		'typ' => 'int',
		'wartosc' => 37,
	),
	'import.id_gravebefaring' => array(
		'opis' => 'Id gravebefaring',
		'typ' => 'int',
		'wartosc' => 36,
	),
	'import.id_b2b_befaring' => array(
		'opis' => 'Id b2b befaring',
		'typ' => 'int',
		'wartosc' => 35,
	),
	'import.id_b2b_befaring_pola_zamowienia' => array(
			'opis' => '',
			'typ' => 'array',
			'wartosc' => array(
				'jobDescription' => array('8|6', '9|6', '10|6', '11|6', '12|6', '13|6', '14|6', '1|10', '2|11', '3|10', '3|11', '4|10', '4|11', '5|10', '5|11', '6|10', '7|11', '8|10', '8|11', '9|10', '9|11') ,
				'companyName' => array('1|1') ,
				'address' => array('2|1') ,
				'nodeVillaCode' => array('1|6')
			)
		),
	'import.id_b2b_befaring_atrybuty_zamowienia' => array(
			'opis' => '',
			'typ' => 'array',
			'wartosc' => array(
				'1|6' => '1|6',
				'4|0' => '4|1',
				'5|0' => '5|1',
				'6|0' => '6|1',
				'4|3' => '4|4',
				'5|3' => '5|4',
				'6|3' => '6|4',
			)
		),
	'import.id_b2b_befaring_additionalData' => array(
			'opis' => '',
			'typ' => 'array',
			'wartosc' => array(
				'Enebolig' => '4|1',
				'Rekkehust' => '5|1', 
				'Blokk' => '6|1', 
				'Annet' => '4|4',
				'BRL' => '5|4',
				'Bedrift' => '6|4',
				'Luftkabel' => '8|1',
				'Luftkabel_Metter' => '8|3',
				'Luftkabel_Type' => '8|5',
				'Jordkabel' => '9|1',
				'Jordkabel_Metter' => '9|3',
				'Jordkabel_Type' => '9|5',
				'Nye_Stolper' => '10|1',
				'Nye_Stolper_Stk' => '10|3',
				'EL' => '11|1',
				'EL_Stk' => '11|3',
				'Tele' => '12|1',
				'Tele_Stk' => '12|3',
				'om_i_stolpe' => '14|5',
				'Ma_Grave' => '16|1',
				'Ma_Grave_Metter' => '16|3',
				'Ma_Grave_Type_Grunn' => '16|5',
				'Vei' => '17|1',
				'Vei_Metter' => '17|3',
				'Vei_Type_Grunn' => '17|5',
				'Privat_Grunn' => '18|1',
				'Privat_Grunn_Metter' => '18|3',
				'Privat_Grunn_Type_Grunn' => '18|5',
				'Offentelig_grunn' => '19|1',
				'Offentelig_grunn_Metter' => '19|3',
				'Offentelig_grunn_Type_Grunn' => '19|5',
				'Andre_tilkoblingsalternativ' => '21|0',
				'Trenger_tillatelser' => '24|1',
				'Hvis_ja_spesifiser' => '25|0',
				'Filter_type' => '30|2',
				'Filter_Plassering' => '30|3',
				'Filter_Adresse' => '30|7',
				'Signalet_hentes_fra_Forsterker' => '31|2',
				'Forsterker_Plassering' => '31|3',
				'Forsterker_Adresse' => '31|12',
				'Signalet_hentes_fra_Annet' => '32|2',
				'Annet_Plassering' => '32|3',
				'Annet_Adresse' => '32|12',
				'Pris_pa_arbeidet' => '33|2',
				'Tid_pa_arbeidet' => '34|1',
				'Switch_og_port_nr' => '35|3',
				'Andre_opplysninger_eventuelt_vedlegg' => '37|0',
			)
		),
	'raportExcel.b2bBefaring_szerokosci_kolumn_default' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 15,
	),
	'raportExcel.b2bBefaring_szerokosci_kolumn' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
				0 => '18',
				1 => '4',
				2 => '10',
			   3 => '9',
				4 => '4',
				5 => '15',
				6 => '10',
				7 => '6',
				8 => '6',
				9 => '35',
				10 => '9',
				11 => '14',
			),
		),
	'raportExcel.b2b_befaring_koordynaty_wartosci' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
				'Enebolig' => '4|1', 
				'Rekkehust' => '5|1', 
				'Blokk' => '6|1', 
				'Annet' => '4|4',
				'BRL' => '5|4',
				'Bedrift' => '6|4',
				'Luftkabel' => '8|1',
				'Luftkabel_Metter' => '8|3',
				'Luftkabel_Type' => '8|5',
				'Jordkabel' => '9|1',
				'Jordkabel_Metter' => '9|3',
				'Jordkabel_Type' => '9|5',
				'Nye_Stolper' => '10|1',
				'Nye_Stolper_Stk' => '10|3',
				'EL' => '11|1',
				'EL_Stk' => '11|3',
				'Tele' => '12|1',
				'Tele_Stk' => '12|3',
				'om_i_stolpe' => '14|5',
				'Ma_Grave' => '16|1',
				'Ma_Grave_Metter' => '16|3',
				'Ma_Grave_Type_Grunn' => '16|5',
				'Vei' => '17|1',
				'Vei_Metter' => '17|3',
				'Vei_Type_Grunn' => '17|5',
				'Privat_Grunn' => '18|1',
				'Privat_Grunn_Metter' => '18|3',
				'Privat_Grunn_Type_Grunn' => '18|5',
				'Offentelig_grunn' => '19|1',
				'Offentelig_grunn_Metter' => '19|3',
				'Offentelig_grunn_Type_Grunn' => '19|5',
				'Andre_tilkoblingsalternativ' => '21|0',
				'Trenger_tillatelser' => '24|1',
				'Hvis_ja_spesifiser' => '25|0',
				'Filter_type' => '30|2',
				'Filter_Plassering' => '30|3',
				'Filter_Adresse' => '30|7',
				'Signalet_hentes_fra_Forsterker' => '31|2',
				'Forsterker_Plassering' => '31|3',
				'Forsterker_Adresse' => '31|12',
				'Signalet_hentes_fra_Annet' => '32|2',
				'Annet_Plassering' => '32|3',
				'Annet_Adresse' => '32|12',
				'Pris_pa_arbeidet' => '33|2',
				'Tid_pa_arbeidet' => '34|1',
				'Switch_og_port_nr' => '35|3',
				'Andre_opplysninger_eventuelt_vedlegg' => '37|0',
			),
		),
	'raportExcel.szerokosci_kolumn_default' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 15,
	),
	'raportExcel.szerokosci_kolumn' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
				9 => '22',
				8 => '25',
				10 => '22',
			   19 => '36',
				34 => '180',
			),
		),
	'raportExcel.koordynaty_wartosci' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
				'PRIS_TOTALT' => '21',
				'PRIS_UTANFOR_KUNDENS_TOMT' => '22',
				'PRIS_KUNDENS_TOMT' => '23',
				'ANTALL_METER_TOTALT' => '24',
				'ANTALL_METER_UTENFOR_KUNDENS_TOMT' => '25',
				'ANTALL_METER_INNE_PA_KUNDENS_TOMT' => '26',
				'MA_DET_SOKES_TILLATELSE_AV_ANDRE_GRUNNEIER' => '27',
				'Tillatelse_Adresse_1' => '28',
				'Tillatelse_Adresse_2' => '29',
				'Tillatelse_Adresse_2' => '29',
				'Tillatelse_Adresse_3' => '30',
				'Tillatelse_Adresse_4' => '31',
				'GJELDER_GRAVING_OFFENENTELIG_GRUNN' => '32',
				'MULIG_MED_PROVISORISK' => '33',
				'KOMMENTAR_ENTREPRENOR' => '34',
			),
		),
	'raportExcel.naglowek_kolor_czcionki' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'Black',
		),
	'raportExcel.naglowek_kolor_tla' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 3,
		),
	'raportExcel.wiersz_nieparzysty_kolor_tla' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'White',
		),
	'raportExcel.wiersz_parzysty_kolor_tla' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'White',
		),
	'index.id_type_wyswietlaj_kreate_xls' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array(
			35, 36
		)
	),
	'import.gravebefaring_klient_type' => array(
		'opis' => 'Typ klienta dla gravebefaring',
		'typ' => 'varchar',
		'wartosc' => 'private',
	),
	'import.b2b_befaring_klient_type' => array(
		'opis' => 'Typ klienta dla b2b  ',
		'typ' => 'varchar',
		'wartosc' => 'company',
	),
	'import.id_b2b_befaring' => array(
		'opis' => 'Id gravebefaring',
		'typ' => 'int',
		'wartosc' => 35,
	),
	'import.sprawdz_poprawnosc_pliku_homenetvilla' => array(
		'opis' => '',
			'typ' => 'array',
			'wartosc' => array(
				'0|0' => 'Area Name',
			)
	),
	'import.sprawdz_poprawnosc_pliku_b2b_befaring' => array(
		'opis' => '',
			'typ' => 'array',
			'wartosc' => array(
				'1|0' => 'Firma',
			)
	),
	'import.sprawdz_poprawnosc_pliku_gravebefaring' => array(
		'opis' => '',
			'typ' => 'array',
			'wartosc' => array(
				'0|0' => 'DATO',
				'0|1' => 'TYPE JOBB',
			)
	),
	'import.id_digging' => array(
		'opis' => 'Id digging',
		'typ' => 'int',
		'wartosc' => 24,
	),
	'import.id_villa' => array(
		'opis' => 'Id villa typ',
		'typ' => 'int',
		'wartosc' => 1,
	),
	'login.villa_nowy_formularz' =>array(
		'opis' => 'Włącza logowanie do Villi poprzez nowy formularz',
		'typ' => 'bool',
		'wartosc' => true,
	),
	'import.typy_zamowien_do_importu' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array(37, 36, 35, 24, 1) 
	),
	'import.ajax.zabron_edycji' => array(
		'opis' => 'Określ zaimportowane pola które nie będą podlegały edycji ajax-a',
		'typ' => 'array',
		'wartosc' => array(
			0 => 'zdjecie',
			1 => 'poprawne',
			2 => 'numer_zamowienia',
			),
		),

	'import.aktualizuj_dane_klienta' => array(
		'opis' => 'Nadpisuje dane klienta jeżeli istnieje w bazie danych',
		'typ' => 'bool',
		'wartosc' => 1,
		),
	'importHomenetVilla.pola_obiekty' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			0 => 'Zamowienie|city',
			1 => 'Zamowienie|address',
			2 => 'Zamowienie|apartment',
			3 => 'Klient|idCustomer',
			4 => 'Klient|name',
			5 => 'Klient|surname',
			6 => 'Klient|phoneNumber',
			7 => 'Klient|email',
			8 => 'Zamowienie|dateStart',
			9 => 'Zamowienie|hoursInterval',
			10 => 'Zamowienie|jobDescription'
			),
	),
	'importHomenetVilla.pola_z_datami' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array(
			8
		)
	),
	'importHomenetVilla.pola_z_godzina' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array(
			9
		)
	),
	'importHomenetVilla.hours_interval' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			8 => '08:00-10:00',
			9 => '09:00-11:00',
			10 => '10:00-12:00',
			11 => '11:00-13:00',
			12 => '12:00-14:00',
			13 => '13:00-15:00',
			14 => '14:00-16:00',
			15 => '15:00-17:00',
			16 => '16:00-18:00',
			17 => '17:00-19:00',
		)
	),
	'importGraveXls.pola_obiekty' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			0 => 'Zamowienie|attributes',
			1 => 'Zamowienie|attributes',
			2 => 'Zamowienie|numberOrderGet',
			3 => 'Zamowienie|attributes',
			4 => 'Zamowienie|attributes',
			5 => 'Zamowienie|attributes',
			6 => 'Zamowienie|attributes',
			7 => 'Klient|attributes',
			8 => 'Klient|idCustomer',
			9 => 'Klient|name',
			10 => 'Klient|address',
			11 => 'Klient|city',
			12 => 'Klient|phoneNumber',
			13 => 'Zamowienie|attributes',
			14 => 'Zamowienie|attributes',
			15 => 'Zamowienie|attributes',
			16 => 'Zamowienie|attributes',
			17 => 'Zamowienie|attributes',
			18 => 'Zamowienie|attributes',
			19 => 'Zamowienie|jobDescription',
			),
	),
	'importGraveXls.pola_z_datami' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array(
			0, 5
		)
	),
	'import.dozwolone_pliki' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array(
			'jpg',
			'gif',
			'png',
			'pdf',
			'xlsx',
			'xls',
			'doc',
			'docx',
			),
		),

	'import.dozwolone_pliki_zdjec' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array(
			'jpg',
			'gif',
			'png',
			),
		),

	'import.edycja_pola_data' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			0 => 'data',
			1 => 'data_1',
			),
		),

	'import.edycja_pola_tekstarea' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			0 => 'opis_xls',
			1 => 'service',
			2 => 'dane_klienta',
			3 => 'opis',
			4 => 'atrybuty_zamowienia',
			),
		),

	'import.katalog_importu' => array(
		'opis' => 'Katalog z zaimportowanymi danymi',
		'typ' => 'varchar',
		'wartosc' => 'orders_import',
		),

	'import.katalog_zamowienia_zalaczniki' => array(
		'opis' => 'Katalog z załącznikami zamówień',
		'typ' => 'varchar',
		'wartosc' => 'orders',
		),

	'import.kody_rol_koordynatora' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array(
			'coordinator',
			),
		),
		'import.id_type_wyswietlaj_przypisz_do' => array(
			'opis' => '',
			'typ' => 'list',
			'wartosc' => array(35, 36),
		),
		'import.przydziel_domyslny_koordynator' => array(
				'opis' => '',
				'typ' => 'int',
				'wartosc' => 42,
				),
		'import.przydziel_domyslny_team' => array(
				'opis' => '',
				'typ' => 'int',
				'wartosc' => 25,
				),
	'import.komenda_do_biblioteki_tika' => array(
		'opis' => 'Komenda wykonywana przez exec() do konwersji PDF na TXT',
		'typ' => 'varchar',
		'wartosc' => 'java -jar /bin/tika-app-1.4.jar -t {PLIK_PDF} > {PLIK_TEKSTOWY}',
		),

	'import.pobierz_zalaczniki_pdf_pattern' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '/^([a-zA-Z0-9]{4})-[j]{1}([0-9]{6})-([0-9]{8})-(sjekk-for-service)$/',
		),
	'import.nazwa_pliku_pdf_z_zamowieniami' => array(
		'opis' => 'nawa pliku pdf z danymi zamówień dla typu villa do importu',
		'typ' => 'varchar',
		'wartosc' => '/^(((t{1})([[:punct:],[:space:]]{0,2})(712)([[:punct:],[:space:]]{0,2}))*)((b2b)([[:punct:],[:space:]]{0,2})){0,1}(((get)([[:punct:],[:space:]]{0,2})(work)([[:punct:],[:space:]]{0,2})(order))|(Jobber|jobb))([[:punct:],[:space:]]{0,2})((([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{2,4}){0,1})|(pdf))\.(pdf)$/i',
		),
	'import.nazwa_pliku_pdf_z_zamowieniami_digging' => array(
		'opis' => 'nawa pliku pdf z danymi zamówień dla typu digging do importu',
		'typ' => 'varchar',
		'wartosc' => '/GRAVEORDREBKT/i',
		),
	'import.nazwa_pliku_xls_b2b' => array(
		'opis' => 'nawa pliku xls z danymi zamówień dla typu b2b do importu',
		'typ' => 'varchar',
		'wartosc' => '/^(((t{1})([[:punct:],[:space:]]{0,2})(712))|(b2b))([[:punct:],[:space:]]{0,2})(b2b){0,1}([[:punct:],[:space:]]{0,2})(jobb|jobber)([[:punct:],[:space:]]{0,2})(([0-9]{1,2}\.[0-9]{1,2}\.[0-9]{2,4})|(EXcel))\.(xlsx)$/i'
		),
	'import.nazwa_pliku_xls_digging' => array(
		'opis' => 'nawa pliku xls z danymi zamówień dla typu digging do importu',
		'typ' => 'varchar',
		'wartosc' => '/GRAVEORDREBKT/i'
		),
	'import.nazwa_pliku_xls_villa' => array(
		'opis' => 'nawa pliku xls z danymi zamówień dla typu villa do importu',
		'typ' => 'varchar',
		'wartosc' => '/^(((t{1})([[:punct:],[:space:]]{0,2})(712)){0,1})([[:punct:],[:space:]]{0,2})(basefil|excel)\.(xlsx)$/',
		),
	'import.nazwa_pliku_gravebefaring' => array(
		'opis' => 'nawa pliku xls z danymi zamówień dla typu gravebefaring do importu',
		'typ' => 'varchar',
		'wartosc' => '/cfs-t712-bkt-gravebefaringsordre/i',
		),
	'import.pobierz_zdjecia_pattern' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '/^([a-zA-Z0-9]{4})-[j]{1}([0-9]{6})-([0-9]{8})(-(kart))?\.(?:jpg|gif|png)$/',
		),

	'import.pobierz_zdjecia_pattern_prefix_klient_id' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 1,
		),

	'import.pobierz_zdjecia_pattern_prefix_nazwa' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '0',
		),

	'import.pobierz_zdjecia_pattern_prefix_nr_zamowienia' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 2,
		),

	'import.pola_atrybuty_zamowien' => array(
		'opis' => 'Atrybuty zamówień',
		'typ' => 'array',
		'wartosc' => array(
			0 => 'Bolig Type',
			1 => 'CaReference.DTV',
			2 => 'Cluster',
			3 => 'Demographic1',
			4 => 'Demographic2',
			5 => 'Demographic3',
			6 => 'Filtered Two Way',
			7 => 'GSM coverage',
			8 => 'HC Status',
			9 => 'HFC Two Way Network',
			10 => 'HFC Two Way Network Date',
			11 => 'Homes Passed',
			12 => 'Homes Passed Date',
			13 => 'Info',
			14 => 'Latitude',
			15 => 'Longitude',
			16 => 'Needs Upgrade',
			17 => 'Network Type',
			18 => 'Node',
			19 => 'Villa Complex',
			20 => 'Market Type',
			21 => 'Construction Area',
			),
		),

	'import.pola_nie_wyswietlaj' => array(
		'opis' => 'Określ które pola nie będą wyświetlane w tabeli po zaimportowaniu',
		'typ' => 'array',
		'wartosc' => array(
			0 => 'poprawne',
			1 => 'zdjecie_poprawne',
			2 => 'numer_zamowienia',
			3 => 'service',
			4 => 'zamowione_produkty',
			5 => 'zalaczniki_dodane',
			6 => 'poprawneXls',
			),
		),

	'import.prasuj_dane_pdf.pomin_przy_opisie' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			0 => 'Initials:',
			1 => 'Date:',
			2 => 'Technician Signature:',
			3 => 'Customer Signature:',
			4 => 'Technician Signature: Customer Signature:',
			5 => 'Initials: Date:',
			),
		),

	'import.rola_koorydynator' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'coordinator',
		),

	'import.rozmiary_miniaturek' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			's' => '100.100.crop',
			'' => '926.389.scale',
			),
		),

	'import.service_tablica_cen_przsun_o_dwa' => array(
		'opis' => 'Określa dla jakiego produktu informację na temat ceny i ilości mają być pobierane od drugiego elementu tablicy',
		'typ' => 'array',
		'wartosc' => array(
			0 => 'Pris Villa',
			),
		),

	'import.service_tablica_cen_przsun_o_jeden' => array(
		'opis' => 'Określa dla jakiego produktu informację na temat ceny i ilości mają być pobierane od następnego elementu tablicy',
		'typ' => 'array',
		'wartosc' => array(
			0 => 'Installation',
			),
		),

	'import.typ_zamowienia_txt' => array(
		'opis' => 'Typ zamówienia',
		'typ' => 'array',
		'wartosc' => array(
			'B2B' => 'B2B',
			712 => 'Villa',
			),
		),

	'import.typ_zamowienia_txt_domyslny' => array(
		'opis' => 'Typ zamówienia domyślny',
		'typ' => 'array',
		'wartosc' => array(
			0 => 'Villa',
			),
		),

	'import.xls_wiersz_z_dane_1' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 27,
		),

	'import.xls_wiersz_z_data' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '0',
		),

	'import.xls_wiersz_z_data_1' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 28,
		),

	'import.xls_wiersz_z_glowny_service' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 34,
		),

	'import.xls_wiersz_z_godziny_przedzial' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 4,
		),

	'import.xls_wiersz_z_godziny_przedzial_1' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 35,
		),

	'import.xls_wiersz_z_gwiazdka_1' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 36,
		),

	'import.xls_wiersz_z_gwiazdka_2' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 38,
		),

	'import.xls_wiersz_z_gwiazdka_3' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 39,
		),

	'import.xls_wiersz_z_gwiazdka_4' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 40,
		),
	'import.xls_wiersz_z_wycena' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 41,
		),
	'import.xls_wiersz_z_klient_adres' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 7,
		),

	'import.xls_wiersz_z_klient_id' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 5,
		),

	'import.xls_wiersz_z_klient_id_1' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 31,
		),

	'import.xls_wiersz_z_klient_komorka' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 15,
		),

	'import.xls_wiersz_z_klient_miasto' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 11,
		),

	'import.xls_wiersz_z_klient_nazwa' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 6,
		),

	'import.xls_wiersz_z_klient_telefon1' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 13,
		),

	'import.xls_wiersz_z_klient_telefon2' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 14,
		),

	'import.xls_wiersz_z_node_lub_villa_kod' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 37,
		),

	'import.xls_wiersz_z_numer_get_1' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 29,
		),

	'import.xls_wiersz_z_numerem' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 1,
		),

	'import.xls_wiersz_z_numerem_zamowienia' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 2,
		),

	'import.xls_wiersz_z_numerem_zamowienia_1' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 30,
		),

	'import.xls_wiersz_z_opis' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 16,
		),

	'import.xls_wiersz_z_total_time' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 25,
		),

	'import.xls_wiersz_z_total_time_1' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 33,
		),

	'import.xls_wiersze_z_service' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			0 => 18,
			1 => 19,
			2 => 20,
			3 => 21,
			4 => 22,
			5 => 23,
			6 => 24,
			),
		),

	'import.zapisz_klienta_b2b' => array(
		'opis' => 'Kod zamówień b2b',
		'typ' => 'varchar',
		'wartosc' => 'company',
		),

	'import.zapisz_klienta_typ' => array(
		'opis' => 'Typ klienta zapisywany przy imporcie (kod z importu => kod w bazie)',
		'typ' => 'array',
		'wartosc' => array(
			'B2B' => 'company',
			712 => 'private',
			),
		),

	'import.zapisz_klienta_typ_domyslny' => array(
		'opis' => 'Domyślny typ klienta zapisywany przy imporcie',
		'typ' => 'varchar',
		'wartosc' => 'private',
		),

	'import.zapisz_zamowienie_kod_b2b' => array(
		'opis' => 'Kod zamówień b2b',
		'typ' => 'varchar',
		'wartosc' => 'b2b',
		),

	'import.zapisz_zamowienie_kod_villa' => array(
		'opis' => 'Kod zamówień villa',
		'typ' => 'varchar',
		'wartosc' => 'villa',
		),

	'import.zapisz_zamowienie_typ' => array(
		'opis' => 'Typ zamówienia zapisywany przy imporcie (kod z importu => id w bazie)',
		'typ' => 'array',
		'wartosc' => array(
			'B2B' => 2,
			712 => 1,
			24 => 24
			),
		),
	
	'import.zapisz_zamowienie_typ_domyslny' => array(
		'opis' => 'Domyślny typ zamówienia zapisywany przy imporcie',
		'typ' => 'varchar',
		'wartosc' => '1',
		),

	'index.nie_wyswietlaj_zamowien_ze_statusami' => array(
		'opis' => 'Zamówienia posiadające wymienione tutaj statusy nie bedą się wyświetlać na liscie zamówień - dopiero po wybraniu odpowiedniego statusu w filtrach',
		'typ' => 'list',
		'wartosc' => array(
			),
		),

	'index.pager_konfiguracja' => array(
		'opis' => 'Konfiguracja stronnicowania',
		'typ' => 'pager',
		'wartosc' => array(
			'zakres' => 5,
			'wyborStrony' => 'linki',
			'wyborZakresu' => 'select',
			'skoczDo' => 'form',
			'pierwszaOstatnia' => 1,
			'poprzedniaNastepna' => 1,
			),
		),

	'index.role_tablica_pol_widocznych' => array(
		'opis' => 'Lista "kod_roli.pole_widoczne" aby dla konkretnych ról pokazywały się zdefiniowane pola',
		'typ' => 'list',
		'wartosc' => array(
			'user.number_order_get',
			'user.client',
			'user.address',
			'user.client_contact',
			'user.hours_interval',
			'user.total_time',
			'user.status_work',
			'user.date_start',
			'user.date_stop',
			'user.order_name',
			'user.reclamation_for',
			'user.reclamation_address',
			
			'guest.number_order_get',
			'guest.client',
			'guest.address',
			'guest.client_contact',
			'guest.hours_interval',
			'guest.status_work',
			'guest.order_name',
			'guest.reclamation_for',
			'guest.reclamation_address',
			),
		),

	'index.role_z_pelnym_dostepem' => array(
		'opis' => 'Lista kodów rol z pełnym dostępem do wszystkich pól',
		'typ' => 'list',
		'wartosc' => array(
			'admin',
			'boss',
			),
		),
	'indexLider.idTypu_wyswietlaj_czas_do_konca' => array(
		'opis' => 'Id typów zamówień dla których wyswietlamy czas do zakończenia',
		'typ' => 'list',
		'wartosc' => array(
			0
			),
	),
	'productCorrection.sprawdzaj_czy_czas_nie_przekroczony' => array(
		'opis' => 'Id typów zamówień dla któych sprawdzamy czy czas spędzony na zadaniu nie został przekroczony',
		'typ' => 'list',
		'wartosc' => array(
			1,
			),
	),
	'indexLider.id_typow_zezwol_edycja' => array(
		'opis' => 'Id typów zamówień zamkniętych które lider może edytować',
		'typ' => 'list',
		'wartosc' => array(
			32, 33,
			),
		),
	'indexLider.id_typow_ekstrakontakt' => array(
		'opis' => 'Id typów ekstrakontaktów',
		'typ' => 'list',
		'wartosc' => array(
			26, 27,
			),
		),
	'indexLider.zezwol_edycja_ekstrakontakt_apartament' => array(
		'opis' => 'Zezwala na edycje extrakontaktów dodanych do apartamentów',
		'typ' => 'bool',
		'wartosc' => true
		),
	'indexLider.zamowienie_kolor_tla' => array(
		'opis' => 'Kolory tła nagłówków zamówień w zależności od typu zamówienia',
		'typ' => 'array',
		'wartosc' => array(
				'1' => '#FFFAFA',
				'2' => '#FFE4E1',
				'23' => '#FFFACD',
			),
	),
	'indexLider.produkty_zakupione_id_type' => array(
		'opis' => 'Id typów zamówień dla produktów zamówionych które nie sa brane z importu (np. w ekstrakontaktach produkty wybierane są z produktów nie zaimportowanych )',
		'typ' => 'list',
		'wartosc' => array('|26|', '|27|', '|28|', '|29|') ,
	),	
	'indexLider.apartamenty_kolor_tla' => array(
		'opis' => 'Kolory tła apartamentów w zależności od statusu ',
		'typ' => 'array',
		'wartosc' => array(
				'new' => '#E8E8E8',
				'done' => '#CCFFFF',
				'in progress' => '#E8E8E8',
				'not done' => '#FFCC66',
				'default' => '#fff'
			),
	),
	'indexLider.kolor_projektu_apartamentu' => array(
		'opis' => 'Kolor tła nagłówka projektu apartamentów',
		'typ' => 'varchar',
		'wartosc' => '#FFBC70',
	),
	'inexLider.zamowienie_kolor_tla_status' => array(
		'opis' => 'Kolory tła nagłówków w zależności od statusu zadania zalogowany aktualnie albo zaczął ale nie skończył',
		'typ' => 'array',
		'wartosc' => array(
			'zalogowany' => '#dfff7d',
			'przeskoczone' => '#9932CC',
		),
	),
	'indexLider.pokaz_historie_logowania' => array(
		'opis' => 'Czy ma pokazywać historię logowań do orderów',
		'typ' => 'bool',
		'wartosc' => true,
	),
	'index.wierszy_na_stronie' => array(
		'maks' => '100',
		'opis' => 'Ilość wierszy na stronie w liście użytkowników',
		'typ' => 'int',
		'wartosc' => 10,
	),
	'indexLider.rola_lider_bkt_projekt' => array(
		'opis' => 'kod roli lidera bkt projektów',
		'typ' => 'varchar',
		'wartosc' => 'ProjectLeaderBkt',
	),
	'indexLider.zamowienia_zamkniete_ilosc_dni_wstecz' => array(
		'opis' => 'Zakres dni wstecz od dni obecnego z których będą wyświetlały się zamówienia zamknięte',
		'typ' => 'int',
		'wartosc' => 7,
	),
	'indexLider.lista_nie_wyswietlaj_login' => array(
		'opis' => 'statusy zamówień do których nie można się logować (przycisk zaloguj nie będzie wyświetlany)',
		'typ' => 'list',
		'wartosc' => array(
				'closed',
				'cancelled',
			),
	),
	'indexLider.formularz_szukaj_usun_inputy' => array(
		'opis' => 'Lista inputów formularza wyszukaj które nie będą wyświetlane',
		'typ' => 'list',
		'wartosc' => array(
				'ma_dzieci',
				'ma_reklamacje',
			),
	),
	'indexLider.kolor_typ_zadania' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			),
		),

	'indexLider.kolor_wysoki_priorytet' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '',
		),

	'indexLider.status_work_kryteria' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array(
			'new',
			'in progress',
			),
		),

	'indexLider.zdjecia_pracownikow_przedrostek' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'xs',
		),
	'indexLider.format_data_dodania' => array(
		'opis' => 'Format daty dodania',
		'typ' => 'varchar',
		'wartosc' => "d.m.Y",
	),
	'indexLider.format_data_zakonczenia' => array(
		'opis' => 'Format daty zakończenia',
		'typ' => 'varchar',
		'wartosc' => "d.m.Y",
	),
	'indexLider.id_typow_zamowien_apartamentow' => array(
		'opis' => 'ID typów zamowień apartamentów',
		'typ' => 'list',
		'wartosc' => array(32, 33),
	),
	'indexLider.ilosc_dni_wyswietlane_apartamenty_do_przodu' => array(
		'opis' => 'Ile dni do przodu apartamenty będą wyświetlane',
		'typ' => 'int',
		'wartosc' => 7,
	),
	'login.wylacz_notatka_wymagana_dla_produktow' => array(
		'opis' => 'id typów dla których nie brać pod uwagę wymaganej notatki dla produktów',
		'typ' => 'array',
		'wartosc' => array(1),
	),
	'login.id_typow_udostepnij_kolejny_krok' => array(
		'opis' => 'id typów dla których bedzie wyswietlany nastepny krok z wysylaniem sms',
		'typ' => 'array',
		'wartosc' => array(1),
	),
	'login.kod_produktu_dodatkowi_pracownicy' => array(
		'opis' => 'Kod produktu dla dodatkowych pracowników na Villa',
		'typ' => 'varchar',
		'wartosc' => 'lopende_timer_ekstra_arbeidstaker',
	),
	'logIn.wyswietlaj_formularz_akceptacji' => array(
		'opis' => 'Włącza wyświetlanie formularza z checkboxami do akceptacji dla danego typu zamówienia',
		'typ' => 'list',
		'wartosc' => array(1, 2),
	),
	'logIn.wlacz_auto_dodawanie_lopende_timer' => array(
		'opis' => 'Włącza dodawanie automatczne lopende timerów',
		'typ' => 'bool',
		'wartosc' => 0,
	),
	'logIn.zamknij_apartament_wykonany_notatka_wymagana' => array(
		'opis' => 'Wymaga notatki podczas zamykania apartamenu ze statusem wykonany',
		'typ' => 'bool',
		'wartosc' => 1,
	),
	'logIn.id_formatki_email_apartament' => array(
		'opis' => 'Wyślij powiadomienie apartament spoznienie',
		'typ' => 'mail',
		'wartosc' => '28',
		),
	'logIn.id_formatki_email_nowy_apartament' => array(
		'opis' => 'Wyślij powiadomienie dodano nowe zamówienie do apartamentu',
		'typ' => 'mail',
		'wartosc' => '29',
		),
	'logIn.id_uzytkownika_powiadomienie_b2b' => array(
		'opis' => 'Id użytkownika(odbiorcy) wyślij powiadomienie b2b',
		'typ' => 'varchar',
		'wartosc' => '41',
		),
	'logIn.sms_kategoria_powiadomienie_b2b' => array(
		'opis' => 'Kategoria sms dla powiadomień b2b',
		'typ' => 'varchar',
		'wartosc' => 'powiadomienia b2b',
	),
	'logIn.id_lopende_timer' => array(
		'opis' => 'Id produktó typy lopende Timer',
		'typ' => 'list',
		'wartosc' => array('lopende_timer_montor', 'lopende_timer_peilet_reflektert_kabel' , 'lopende_timer_trekt_kabel_i_ror_til_kunde' , 'lopende_timer_gravd_droppkabel' , 'lopende_timer_gravd_skap' , 'lopende_timer_peilet_kabel' , 'befaring_lopende_timer'),
	),
	'logIn.id_lopende_timer_zamknij_zamowienie' => array(
		'opis' => 'Id produktó typy lopende Timer',
		'typ' => 'list',
		'wartosc' => array('lopende_timer_montor', 'lopende_timer_peilet_reflektert_kabel' , 'lopende_timer_trekt_kabel_i_ror_til_kunde' , 'lopende_timer_gravd_droppkabel' , 'lopende_timer_gravd_skap' , 'lopende_timer_peilet_kabel' , 'befaring_lopende_timer'),
	),
	'logIn.kod_lopende_timer_dodaj_automatycznie' => array(
		'opis' => 'id lopendetimer dodawanego automatycznie po pzekroczeniu czasu na zamówieniu',
		'typ' => 'varchar',
		'wartosc' => 'lopende_timer_montor',
	),
	'logIn.idTypu_wyjatek_produkty' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array(2),
		),
	'logIn.nie_wykonane_b2b_status' => array(
		'opis' => 'Status zamówienia przy wybranej opcji not done (nie_wykonane_b2b)',
		'typ' => 'varchar',
		'wartosc' => 'open',
	),
	'logIn.wykonane_wyslij_mail_id_zamowienia' => array(
		'opis' => 'Id typów zamówień dla których wysyłany jest email z informacją o zakończeniu zadania',
		'typ' => 'list',
		'wartosc' => array(
			24, 31
		),
	),
	'logIn.sms_id_orders_type' => array(
		'opis' => 'Id typu orderów dla których wysyłamy sms do get',
		'typ' => 'list',
		'wartosc' => array(
			1, 2, 24, 36
			),
		),

	'logIn.sms_kategoria_done_get' => array(
		'opis' => 'Kategoria sms wysyłanego do get z informacją o zamkniętym projekcie',
		'typ' => 'varchar',
		'wartosc' => 'orders_get_done',
		),
	'logIn.sms_kategoria_anulowane_get' => array(
		'opis' => 'Kategoria sms wysyłanego do get z informacją o anulowanym projekcie',
		'typ' => 'varchar',
		'wartosc' => 'orders_get_anluowane',
		),
	'logIn.sms_numer_tel_get' => array(
		'opis' => 'Numer na który będą wysyłane sms do Get (Must be 14 characters long and start with 26114)',
		'typ' => 'varchar',
		'wartosc' => '26114123450049',
		),

	'logIn.status_done' => array(
		'opis' => 'Statusy zamówień wykonanych',
		'typ' => 'text',
		'wartosc' => 'closed',
		),
	'logIn.id_reklamacja_typ' => array(
		'opis' => 'Id typu reklamacji - dla zamówień tego typu wychodzi mail do Administracji',
		'typ' => 'list',
		'wartosc' => array(
			23,
			),
	),
	'logIn.idType_wyslij_powiadomienie_sms' => array(
		'opis' => 'Id typu - dla zamówień tego typu wychodzi sms do Administracji z informacją o stanie zamówienia',
		'typ' => 'list',
		'wartosc' => array(
			2,
			),
	),
	'logIn.idType_wyslij_powiadomienie_email' => array(
		'opis' => 'Id typu - dla zamówień tego typu wychodzi mail do Administracji z informacją o stanie zamówienia',
		'typ' => 'list',
		'wartosc' => array(
			2, 24,
			),
	),
	'logIn.id_formatki_email_zakonczona_reklamacja' => array(
		'opis' => 'Formatka zakończono reklamację',
		'typ' => 'mail',
		'wartosc' => 6,
	),
		// To nie jest tylko dla B2B doszły też diggingi bo podobne zachowanie
	'logIn.id_formatki_email_wylogowanie_b2b' => array(
		'opis' => 'Formatka wylogowano z zamówienia z statusem nie wykonane id_typu => id_formatki',
		'typ' => 'array',
		'wartosc' => array( 2 => 14, 24 => 35 ),
	),
	'logIn.id_formatki_email_wykonano_zadanie' => array(
		'opis' => 'Formatka wykonano zadanie',
		'typ' => 'mail',
		'wartosc' => 16,
	),
	'logIn.status_not_done' => array(
		'opis' => 'Statusy zamówień nie wykonanych',
		'typ' => 'text',
		'wartosc' => 'closed',
		),
		
	'logIn.status_pomin_order' => array(
		'opis' => 'Statusy zamówień pominietych',
		'typ' => 'text',
		'wartosc' => 'active',
		),
		
	'logIn.data_format' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'Y-m-d H:i',
		),
	
	'logIn.seriale_walidatory' => array(
		'opis' => 'Ilość znakow wymaganych dla danego rodzaju seriala',
		'typ' => 'array',
		'wartosc' => array(
			'dekoder' => 8,
			'modem' => 12,
			'h_dek' => 8,
			'h_modem' => 12,
			'voip' => 12,
			'ont' => 12,
			'air_ties' => 12,
			'h_airties' => 12,
		),
	),
	
	'orderTypes.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'name',
		'dozwolone' => array(
			0 => 'name',
			1 => 'date_added',
			),
		),

	'orderTypes.pager_konfiguracja' => array(
		'opis' => 'Konfiguracja stronnicowania',
		'typ' => 'pager',
		'wartosc' => array(
			'zakres' => 5,
			'wyborStrony' => 'linki',
			'wyborZakresu' => 'select',
			'skoczDo' => 'form',
			'pierwszaOstatnia' => 1,
			'poprzedniaNastepna' => 1,
			),
		),

	'orderTypes.szablon_formularz_wyszukiwarka' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'formularz_grid.tpl',
		),

	'orderTypes.wierszy_na_stronie' => array(
		'maks' => '100',
		'opis' => 'Ilość wierszy na stronie w liście użytkowników',
		'typ' => 'int',
		'wartosc' => 10,
		),

	'orders.domyslna_grupa_zamowien' => array(
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'get_installation',
		'dozwolone' => array(
			0 => 'get_installation',
			1 => 'get_project',
			2 => 'other_orders',
			3 => 'internal_jobs',
			4 => 'reclamations',
			5 => 'projects',
			),
		),
	'orders.get_id' => array(
		'opis' => 'Id Getu w bazie',
		'typ' => 'int',
		'wartosc' => 1,
		),
	'orders.homenet_id' => array(
		'opis' => 'Id Homenet w bazie',
		'typ' => 'int',
		'wartosc' => 59920,
		),
	'orders.grupy_zamowien' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array(
			'get_installation',
			'get_project',
			'other_orders',
			'internal_jobs',
			'reclamations',
			),
		),

	'orders.lista_rol_pracownikow' => array(
		'opis' => 'Lista ról mających znaczenie jako role pracowników',
		'typ' => 'list',
		'wartosc' => array(
			'worker',
			'call-center',
			'traffic-manager',
			'project-leader-get',
			'boss',
			'guest',
			),
		),

	'orders.rola_koordynatorow' => array(
		'opis' => 'Kod roli dla osób koordynujacych projekty',
		'typ' => 'varchar',
		'wartosc' => 'coordinator',
		),

	'orders.pokazuj_typy_zamowien_dla_roli' => array(
		'opis' => 'Ustawienie dla roli gościa głównie jesli w tablicy nie ma roli wyświetlamy wszystkie typy, jeśli jest rola to tylko typy tutaj wylistowane',
		'typ' => 'array',
		'wartosc' => array(
			'guest' => array('1', '2'),
			),
		),
		
	'previewOrder.format_daty' => array(
		'opis' => 'Format daty według: <a href="http://php.net/manual/pl/function.date.php" target="_blank">http://php.net/manual/pl/function.date.php</a>',
		'typ' => 'varchar',
		'wartosc' => 'd-m-Y',
		),

	'przydzielenieDoEkipy.id_formatki_email' => array(
		'opis' => 'ID formatki wysłanej do przydzielonej ekipy po utworzeniu zamówienia',
		'typ' => 'mail',
		'wartosc' => 8,
		),

	'przydzielenieDoKoordynatora.id_formatki_email' => array(
		'opis' => 'ID formatki wysłanej do przydzielonego koordynatora po utworzeniu zamówienia',
		'typ' => 'mail',
		'wartosc' => 6,
		),

	'reklamacje.charge_amounts' => array(
		'opis' => 'Wielkości możliwe do obciążenia karą za reklamację',
		'typ' => 'select',
		'wartosc' => '100',
		'dozwolone' => array(
			10 => '10%',
			25 => '25%',
			50 => '50%',
			75 => '75%',
			100 => '100%',
			),
		),

	'reklamacje.charge_guilty' => array(
		'opis' => 'Czy zabieranie godzin ma byc z automatu włączone',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	'reklamacje.charge_guilty_by' => array(
		'opis' => 'Sposoby zabierania godzin winnym',
		'typ' => 'select',
		'wartosc' => 'reclamation_hours',
		'dozwolone' => array(
			'reclamation_hours' => 'Reclamation logged hours',
			'order_hours' => 'Order logged hours',
			),
		),

	'reklamacje.possible_charge_guilty' => array(
		'opis' => 'Czy zabieranie godzin winnym ma być możliwe',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	'wyszukajKlientow.ilosc_na_stronie' => array(
		'opis' => 'Ilość wynikow zwracanych ajaxem przy wyszukiwaniu klientów',
		'typ' => 'int',
		'wartosc' => 10,
		),

	'zmianaEkipy.id_formatki_email' => array(
		'opis' => 'ID formatki wysłanej do przydzielonego koordynatora po utworzeniu zamówienia',
		'typ' => 'mail',
		'wartosc' => 9,
		),

	'zmianaKoordynatora.id_formatki_email' => array(
		'opis' => 'ID formatki wysłanej przy zmianie kordynatora',
		'typ' => 'mail',
		'wartosc' => 7,
		),

	'zmianaStatusu.id_formatki_email' => array(
		'opis' => 'ID formatki wysłanej do przydzielonego koordynatora po utworzeniu zamówienia',
		'typ' => 'mail',
		'wartosc' => 11,
		),

	'zmianaTerminu.id_formatki_email' => array(
		'opis' => 'ID formatki wysłanej do przydzielonego koordynatora po utworzeniu zamówienia',
		'typ' => 'mail',
		'wartosc' => 12,
		),

	'zakonczDzien.format_daty' => array(
		'opis' => 'Format daty dla metody zakonczDzien',
		'typ' => 'varchar',
		'wartosc' => "d-m-Y",
		),
	'zamknijDzien.zezwalaj_na_dodawanie_czasu' => array(
		'opis' => 'Jeśli zaznaczone przy kończeniu dnia pracy można dodać czas na dojazd do domu',
		'typ' => 'bool',
		'wartosc' => false,
		),
	'zamknijDzien.ilosc_godzin_na_dojazd' => array(
		'opis' => 'Jeśli opcja powyżej jest zaznaczona to można ustalić ile godzin można dodać na dojazd',
		'typ' => 'int',
		'wartosc' => 3,
		),
	'zamknijDzien.maksymalna_mozliwa_ilosc_godzin' => array(
		'opis' => 'Ilość godzin ile maksymalnie może zostać zapisane do Time listy',
		'typ' => 'int',
		'wartosc' => 16,
		),
	'zamowienieWidok.wyswietlaj_przycisk_reopen' => array(
		'opis' => 'Wyświetla przycisk reopen orders na widoku zamówień',
		'typ' => 'bool',
		'wartosc' => true,
		),
	'zamowienieWidok.format_daty' => array(
		'opis' => 'Format daty w historii logowań na podgladzie zamówienia',
		'typ' => 'varchar',
		'wartosc' => "H:i d-m-Y",
		),
		
	'zamowienieWidok.produkty_IDs_widoczne_w_typach_zamowien' => array(
		'opis' => 'IDs typów orderów dla jakich ma byc pobierana lista produktów - dla modułu korekcji produktów',
		'typ' => 'array',
		'wartosc' => array('1', '2', '24'),
		),
	'zamowienieWidok.ids_produktow_wykluczonych_z_formularza' => array(
		'opis' => 'IDs produktów wykluczonych z wyświetlania w formularzu',
		'typ' => 'array',
		'wartosc' => array('92'),
		),
		
	'zamknijZamowienie.descriptionPrzepracowaneGodzinyProduktB2B' => array(
		'opis' => 'Tekst jaki bedzie zapisywany do pola description doawanego produktu zakupionego dla przepracowanych godzin',
		'typ' => 'varchar',
		'wartosc' => 'Total worked hours',
		),
	'zamowienieWidok.IDS_typow_godziny_razy_ilosc_pracownikow' => array(
		'opis' => 'IDs typów zamowien dla jakich godziny na historii logowań maja byc mnozone przez ilość pracowników',
		'typ' => 'array',
		'wartosc' => array(4),
		),
	'productCorrection.min_przekroczony_czas' => array(
		'opis' => 'Po przekroczeniu tej ilości minut będzie wyswietlany komunikat o przekroczeniu czasu na Villi',
		'typ' => 'int',
		'wartosc' => -10,
	),
	'zamowienieWidok.IDS_typow_projektow' => array(
		'opis' => 'IDs typów zamowien projektow - np do wyświetlania produktów z procentami wykonania',
		'typ' => 'array',
		'wartosc' => array(4),
		),
	'widokProjektApartamenty.id_typu_apartament' => array(
		'opis' => 'IDs typów zamowien apartamentów',
		'typ' => 'array',
		'wartosc' => array(33, 32),
		),
	'indexLider.id_typow_zamowien_przypisanych_do_apartamentu' => array(
		'opis' => 'IDs typów zamowien przypisanych do apartamentow',
		'typ' => 'array',
		'wartosc' => array(26, 27, 28, 29),
		),
	'dodajZamowienieDoApartamentu.kopiuj_pola_apartament'  => array(
			'opis' => 'Lista pól kopiowanych z apartamentu do nowego zamówienia',
			'typ' => 'list',
			'wartosc' => array('idProjektu' , 'address', 'city', 'apartment', 'idPdf', 'postcode',  ),
		),
	'stworzPdf.sciezka_do_mPDF' => array(
		'opis' => 'Ścieżka do biblioteki zewnetrznej mPDF',
		'typ' => 'varchar',
		'wartosc' => '../lib/Mpdf/mpdf.php',
		),
	'zamknijZamowienieVilla.sms_klargjoring' => array(
		'opis' => 'Sms z info o wykonanym klargjoringu',
		'typ' => 'varchar',
		'wartosc' => 'Klargjøring WO {WO} done. {NOTE}',
	),
	'wyslijInfoTeamyNieZalogowane.uwzgeldnij_hours_interval' => array(
		'opis' => 'Uwzględnia tylko zamówienia które powinny zaczac sie od godziny 8 rano',
		'typ' => 'bool',
		'wartosc' => false,
		),
	'wyslijInfoTeamyNieZalogowane.id_formatki_email' => array(
		'opis' => 'ID formatki wysłanej do przydzielonego koordynatora po utworzeniu zamówienia',
		'typ' => 'mail',
		'wartosc' => 31,
		),
	'productCorrection.idTypuZamowieniaZkonfigurajcaDlaPrywatnych' => array(
		'opis' => 'id ZamowieniaTyp gdzie przechowywana jast konfiguracja [corrections][grupa_typow_zamowien]',
		'typ' => 'int',
		'wartosc' => 26,
		),
	'productCorrection.idTypuZamowieniaZezwolUsun' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(1, 2, 24, 26, 27, 28, 29, 35, 36, 37),
		)
	);
}
