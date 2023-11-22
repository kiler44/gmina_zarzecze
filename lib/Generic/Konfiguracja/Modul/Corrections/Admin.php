<?php
namespace Generic\Konfiguracja\Modul\Corrections;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['index.domyslna_data_do']
 * @property bool $k['index.edytuj_raport_kryteria_id_zamowien']
 * @property string $k['index.id_domyslnego_typu_zamowienia']
 * @property array $k['index.id_typow_zamowien']
 * @property string $k['index.nazwaZamowieniaLista']
 * @property bool $k['index.oznacz_sprawdzone_przyciskiem']
 * @property string $k['makeReport.format_daty_dnia_naglowek']
 * @property string $k['makeReport.format_daty_podsumowania_dnia']
 * @property string $k['makeReport.format_daty_zakonczenie_zamowienia']
 * @property string $k['makeReport.nazwa_pliku']
 * @property string $k['makeReport.sciezka_do_mPDF']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(
	'logIn.id_lopende_timer' => array(
		'opis' => 'Id produktów typy lopende Timer',
		'typ' => 'list',
		'wartosc' => array('lopende_timer_montor', 'lopende_timer_peilet_reflektert_kabel' , 'lopende_timer_trekt_kabel_i_ror_til_kunde' , 'lopende_timer_gravd_droppkabel' , 'lopende_timer_gravd_skap' , 'lopende_timer_peilet_kabel' , 'befaring_lopende_timer'),
		),
	'index.domyslna_data_do' => array(
		'opis' => 'Modyfikacja dzisiejszej daty w formacie - 3 day, - 1 month etc.',
		'typ' => 'varchar',
		'wartosc' => '- 1 day',
		),
	'index.id_typu_wyswietlaj_raport_excel' => array(
		'opis' => 'tablica id typów zamówień dla których będzie wyświetlany przycisk z możliwością utworzenia raportu Excel',
		'typ' => 'list',
		'wartosc' => array(26),
	),
	'index.edytuj_raport_kryteria_id_zamowien' => array(
		'opis' => 'W trybie edycji raportu wyświetla tylko te zamówienia które zostały zawarte w raporcie',
		'typ' => 'bool',
		'wartosc' => null,
		),

	'index.id_domyslnego_typu_zamowienia' => array(
		'opis' => 'ID typu zamówienia jakie będzie domyślnie uruchamiane',
		'typ' => 'int',
		'wartosc' => 1,
		),

	'index.id_typow_zamowien' => array(
		'opis' => 'ID typów zamówień jakie mogą być sprawdzane',
		'typ' => 'array',
		'wartosc' => array(
			0 => 1,
			),
		),

	'index.nazwaZamowieniaLista' => array(
		'opis' => 'Format listy przy korkcie produktów. Mozliwe zmienne: {ID_GET}, {CUSTOMER_NAME}, {ADDRESS}',
		'typ' => 'varchar',
		'wartosc' => '<span class="label label-info">{ID_GET}</span> {CUSTOMER_NAME}<address>{ADDRESS}</address>',
		),

	'index.oznacz_sprawdzone_przyciskiem' => array(
		'opis' => 'Czy sprawdzone zamówienia oznaczamy tylko przez kliknięcie przycisku, czy np. strzałkami?',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	'makeReport.format_daty_dnia_naglowek' => array(
		'opis' => 'Format daty',
		'typ' => 'varchar',
		'wartosc' => 'd-m-Y',
		),
	'makeReport.homenet_villa_id_type' => array(
		'opis' => 'ID typu zamówienia homenet villa',
		'typ' => 'int',
		'wartosc' => 37,
	),
	'makeReport.format_daty_podsumowania_dnia' => array(
		'opis' => 'Format daty dla daty podsumowania dnia z uwzględzieniem LOCALE',
		'typ' => 'varchar',
		'wartosc' => '%d-%m-%Y',
		),

	'makeReport.format_daty_zakonczenie_zamowienia' => array(
		'opis' => 'Format daty dla daty zakończenia zamówienia',
		'typ' => 'varchar',
		'wartosc' => 'H:i d-m-Y',
		),

	'makeReport.nazwa_pliku' => array(
		'opis' => 'Nazwa dla generowanego pliku pdf',
		'typ' => 'varchar',
		'wartosc' => 'raport-villa-inst-{$DATA_OD}-{$DATA_DO}',
		),
		
	'makeReport.nazwa_pliku_kategorie' => array(
		'opis' => 'Nazwa dla generowanego pliku pdf',
		'typ' => 'array',
		'wartosc' => array(
			1 => 'raport-villa-inst-{$DATA_OD}-{$DATA_DO}',
			2 => 'raport-b2b-inst-{$DATA_OD}-{$DATA_DO}',
			24 => 'raport-digging-{$DATA_OD}-{$DATA_DO}',
			35 => 'raport-b2b-befaring-{$DATA_OD}-{$DATA_DO}',
			36 => 'raport-grave-befaring-{$DATA_OD}-{$DATA_DO}',
			26 => 'raport-private-orders-{$DATA_OD}-{$DATA_DO}',
			),
		),

	'makeReport.sciezka_do_mPDF' => array(
		'opis' => 'Ścieżka do biblioteki zewnetrznej mPDF',
		'typ' => 'varchar',
		'wartosc' => '..\lib\Mpdf\mpdf.php',
		),
	'makeReport.rodzaj_tekstu_raport_given_price' => array(
		'opis' => 'Wybór rodzjau tekstu przy orderach z Given price - lista produktów niestandardowych bądź standardowy tekst z tłumaczeń',
		'typ' => 'select',
		'dozwolone' => array(
			'Standard text',
			'List of products',
			),
		'wartosc' => 'List of products',
		),
	'raportExcel.nazwa_pliku' => array(
		'opis' => 'Nazwa generowanego excela',
		'typ' => 'varchar',
		'wartosc' => 'Raport_privat_orders',
		),
	'raportExcel.naglowek_kolor_czcionki' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'Black',
		),
	'raportExcel.naglowek_kolor_tla' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'Gray',
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
	'raportExcel.kryteria_sprawdzony_wlacz' => array(
		'opis' => '',
		'typ' => 'bool',
		'wartosc' => false,
	),
	'raportExcel.kryteria_sprawdzony' => array(
		'opis' => '',
		'typ' => 'bool',
		'wartosc' => false,
	),
	'raportExcel.kryteria_wyslany_do_raportu' => array(
		'opis' => '',
		'typ' => 'bool',
		'wartosc' => false,
	),
	'raportExcel.kryteria_status' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array('closed'),
	),
	'raportExcel.kryteria_status_work' => array(
		'opis' => '',
		'typ' => 'list',
		'wartosc' => array('done', 'not done'),
	),
	'raportExcel.polaExcela' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(0 => 'A', 1 => 'B',2 => 'C',3 => 'D',4 => 'E',5 => 'F',6 => 'G',7 => 'H',8 => 'I',9 => 'J',10 => 'K',11 => 'L',12 => 'M',13 => 'N',14 => 'O',15 => 'P',16 => 'Q',17 => 'R',18 => 'S',19 => 'T', 20 => 'U',21 => 'V',22 => 'W',23 => 'X',24 => 'Y' ,25 => 'Z'),
	),
	'raportExcel.rozmiarPolaExcela' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			0 => '6',
			1 => '12',
			2 => '8',
			3 => '12',
			4 => '25',
			5 => '10',
			6 => '22',
			7 => '22',
		),
	),
	'raportExcel.rozmiarPolaExcelaDefault' => array(
			'opis' => '',
			'typ' => 'int',
			'wartosc' => 12,
		),
	'szukaj.ogranicz_ilosc_wynikow' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 1000,
	),
	'raportExcel.nazwy_pol' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			'bkt_id' => 'Bkt Id',
			//'number_order_get' => 'Number order GET',
			'data_zakonczenia' => 'Date',
			'postcode' => 'Postcode',
			'city' => 'City',
			'address' => 'Address',
			'apartment' => 'Apartment',
			'name' => 'Customer name',
			'surname' => 'Customer surname',
			//'order_name' => 'Order name',
			//'inst_ftth_kontakt_1' => 'Inst FTTH kontakt',
			//'x_inst_ftth_kontakt_1' => 'x',
			//'inst_ftth_switch_for_tv' => 'Inst FTTH switch for TV',
			//'x_inst_ftth_switch_for_tv' => 'x',
			//'inst_ftth_switch_for_bredband' => 'Inst FTTH switch for bredbånd',
			//'x_inst_ftth_switch_for_bredband' => 'x',
			//'product_list' => 'Product list',
			//'sum_price' => 'Sum price',
		),
		),
	);
}
