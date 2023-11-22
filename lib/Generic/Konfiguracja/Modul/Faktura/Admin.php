<?php
namespace Generic\Konfiguracja\Modul\Faktura;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property int $k['dodajFaktura.dozwolona_wielkosc_zalacznika']
 * @property array $k['dodajFaktura.dozwolone_rozszerzenia_plikow']
 * @property array $k['dodatkowe_typy_projektow']
 * @property int $k['domyslna_ilosc_dni_na_platnosc']
 * @property string $k['domyslny_typ_faktury']
 * @property string $k['faktura.nazwa_pliku']
 * @property string $k['faktura.nazwa_pliku_kreditnota']
 * @property string $k['faktura.sciezka_do_mPDF']
 * @property string $k['faktura.wartosc_var_ref_domyslna']
 * @property string $k['faktura.wartosc_var_ref_prywatni']
 * @property string $k['fakturaPdf.brak_rabatu_znaczek']
 * @property string $k['fakturaPdf.jednostka']
 * @property bool $k['fakturaPdf.wyswietla_numer_klienta']
 * @property bool $k['fakturaPdf.wyswietlaj_bet_bet']
 * @property bool $k['fakturaPdf.wyswietlaj_od_kogo']
 * @property string $k['grid.data_wystawienia_format']
 * @property string $k['grid.data_wystawienia_format_datapicker']
 * @property string $k['grid.data_zaplaty_format']
 * @property string $k['grid.data_zaplaty_format_datapicker']
 * @property string $k['grid.dziecko_przedrostek']
 * @property string $k['grid.klient_get']
 * @property string $k['grid.klient_prywatny']
 * @property string $k['grid.kreditnota_przedrostek']
 * @property string $k['grid.purring_przedrostek']
 * @property string $k['grupa_zamowien_odbiorcy_prywatni']
 * @property int $k['id_klient_get']
 * @property array $k['id_typow_prywatnych']
 * @property int $k['ilosc_dni_na_platnosc_firma']
 * @property int $k['ilosc_dni_na_platnosc_inkassovarsel']
 * @property int $k['ilosc_dni_na_platnosc_klient_prywatny']
 * @property int $k['ilosc_dni_na_platnosc_odbiorcy_prywatni']
 * @property int $k['ilosc_dni_na_platnosc_projekt']
 * @property int $k['ilosc_dni_na_platnosc_purring']
 * @property int $k['ilosc_dni_na_platnosc_raport']
 * @property int $k['ilosc_upomnien_inkassovarsel']
 * @property string $k['index.domyslne_sortowanie']
 * @property array $k['index.pager_konfiguracja']
 * @property int $k['index.wierszy_na_stronie']
 * @property array $k['index.zakladki']
 * @property array $k['kategorie_raport_osoba_kontaktowa']
 * @property string $k['klient_prywatny_nazwa_faktury']
 * @property int $k['kreditnota_ilosc_dni_na_platnosc']
 * @property string $k['kreditnota_nazwa']
 * @property int $k['kwota_upomnienia_purring']
 * @property string $k['kwota_znaczek']
 * @property string $k['magazyn.wyszukiwarka_wierszy_na_stronie']
 * @property int $k['maksymalna_ilosc_upomnien']
 * @property string $k['manuallyinvoices.domyslne_sortowanie']
 * @property string $k['nazwa_inkassovarsel_przedrostek']
 * @property string $k['nazwa_pliku_inkassovarsel']
 * @property string $k['nazwa_pliku_purring']
 * @property string $k['nazwa_purring_przedrostek']
 * @property string $k['numer_konta_bankowego']
 * @property string $k['pdf.data_zaplaty_format']
 * @property int $k['pdf.numer_klienta_start']
 * @property string $k['pierwszy_numer_faktury']
 * @property string $k['pierwszy_numer_kreditnota']
 * @property int $k['pobierzWynikiSzukaj.iloscZnakow']
 * @property string $k['pobierzWynikiSzukaj.pager_konfiguracja']
 * @property string $k['purring.miejsce_wystawienia']
 * @property string $k['raport_b2b_nazwa_faktury']
 * @property string $k['raport_digging_nazwa_faktury']
 * @property string $k['raport_domyslna_nazwa_faktury']
 * @property string $k['raport_villa_nazwa_faktury']
 * @property string $k['rodzaj_inkassovarsel']
 * @property string $k['rodzaj_purring']
 * @property int $k['search.wyszukiwarka_wierszy_na_stronie']
 * @property bool $k['tylko_adres_podstawowy_faktury']
 * @property string $k['typ_produktu_klienci_prywatni']
 * @property string $k['typ_produktu_raport']
 * @property string $k['varenr_szablon_pozycje_faktury']
 * @property string $k['varenr_szablon_produkty']
 * @property string $k['varenr_szablon_produkty_zakupione']
 * @property string $k['varenr_szablon_raport']
 * @property int $k['vat']
 * @property int $k['wyslijFaktura.id_formatki_faktura_kreditnota']
 * @property int $k['wyslijFaktura.id_formatki_faktura_projekt']
 * @property int $k['wyslijFaktura.id_formatki_faktura_prywatni']
 * @property int $k['wyslijFaktura.id_formatki_faktura_raport']
 * @property int $k['wyslijFaktura.id_formatki_faktura_reczna']
 * @property int $k['wyslijFaktura.id_formatki_faktura_upomnienie']
 * @property bool $k['wyslijFakture.wysylaj_do_osoby_kontaktowej_']
 * @property bool $k['wyslijFakture.wysylaj_do_osoby_kontaktowej_Reports']
 * @property bool $k['wyslijFakture.wysylaj_do_osoby_kontaktowej_Zamowienie']
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'dodajFaktura.dozwolona_wielkosc_zalacznika' => array(
		'opis' => 'Moksymalny rozmiar załącznika w bytach',
		'typ' => 'int',
		'wartosc' => 20480000,
		),

	'dodajFaktura.dozwolone_rozszerzenia_plikow' => array(
		'opis' => 'Dozwolone rozszerzenia ',
		'typ' => 'list',
		'wartosc' => array(
			'jpg',
			'jpeg',
			'png',
			'gif',
			'pdf',
			'doc',
			'docx',
			'xls',
			'xlsx',
			),
		),

	'dodatkowe_typy_projektow' => array(
		'opis' => 'Id typów projektów poza grupą Get Project',
		'typ' => 'list',
		'wartosc' => array(
			34,
			),
		),

	'domyslna_ilosc_dni_na_platnosc' => array(
		'opis' => 'Helper - domyślna ilość dni na płatność',
		'typ' => 'int',
		'wartosc' => 14,
		),

	'domyslny_typ_faktury' => array(
		'opis' => 'Helper - domyslny typ faktury',
		'typ' => 'varchar',
		'wartosc' => 'zwykla',
		),

	'faktura.nazwa_pliku' => array(
		'opis' => 'Nazwa pliku pdf faktury',
		'typ' => 'varchar',
		'wartosc' => 'Faktura_{NR_FAKTURY}',
		),

	'faktura.nazwa_pliku_kreditnota' => array(
		'opis' => 'Nazwa pliku pdf kreditnoty',
		'typ' => 'varchar',
		'wartosc' => 'Kreditnota_{NR_FAKTURY}',
		),

	'faktura.sciezka_do_mPDF' => array(
		'opis' => 'Ścieżka do biblioteki zewnetrznej mPDF',
		'typ' => 'varchar',
		'wartosc' => '../lib/Mpdf/mpdf.php',
		),

	'faktura.wartosc_var_ref_domyslna' => array(
		'opis' => 'Wartość pola var ref w fakturze dla klientów nie prywatnych',
		'typ' => 'varchar',
		'wartosc' => 'Jan Petter Hansen',
		),

	'faktura.wartosc_var_ref_prywatni' => array(
		'opis' => 'Wartość pola var ref w fakturze dla klientów prywatnych',
		'typ' => 'varchar',
		'wartosc' => 'Renate Nielsen',
		),
	'faktura.var_ref_po_nowemu' => array(
		'opis' => 'Nowy sposób ustawiania wartosci var ref - wartość ustawiana w zależności kto dodał FV',
		'typ' => 'bool',
		'wartosc' => true,
	),
	'faktura.var_ref_fv_reczne' => array(
		'opis' => 'Jeśli nie ustawiona jest konfiguracja dla danego typu FV ustawiamy domyślną osobą var ref',
		'typ' => 'array',
		'wartosc' => array(
			'klient_prywatny' => 'login',
			'klient_firma' => 'login',
		),
	),
	'faktura.var_ref_id_uzytkownika_domyslne' => array(
		'opis' => 'Jeśli nie ustawiona jest konfiguracja dla danego typu FV ustawiamy domyślną osobą var ref',
		'typ' => 'varchar',
		'wartosc' => 'login',
	),
	
	'faktura.var_ref_id_uzytkownika_zamowienie' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			'1' => 'login',
			'2' => 'login',
			'3' => 'login',
			'4' => 'login',
			'5' => 'login',
			'6' => 'login',
			'7' => 'login',
			'8' => 'login',
			'17' => 'login',
			'23' => 'login',
			'24' => 'login',
			'25' => 'login',
			'26' => 'login',
			'27' => 'login',
			'28' => 'login',
			'29' => 'login',
			'30' => 'login',
			'31' => 'login',
			'32' => 'login',
			'33' => 'login',
			'34' => 'login',
		),
	),
	'faktura.var_ref_id_uzytkownika_reports' => array(
		'opis' => '',
		'typ' => 'array',
		'wartosc' => array(
			'villa instalacje raport faktura' => 'login',
			'homenet villa report' => 'login',
			'b2b instalacje raport faktura' => 'login',
			'digging report' => 'login',
			'gravebefaring raport faktura' => 'login',
			'b2b befaring raport faktura' => 'login',
		),
	),
	'fakturaPdf.brak_rabatu_znaczek' => array(
		'opis' => 'Znaczek wyświetlany na pozycji faktury rabat',
		'typ' => 'varchar',
		'wartosc' => '-',
		),

	'fakturaPdf.jednostka' => array(
		'opis' => 'Domyślna jednostka na fakturze',
		'typ' => 'varchar',
		'wartosc' => 'STK',
		),

	'fakturaPdf.wyswietla_numer_klienta' => array(
		'opis' => 'Wyswietla numer klienta na fakturze',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	'fakturaPdf.wyswietlaj_bet_bet' => array(
		'opis' => 'Wyswietla bet bet na fakturze',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	'fakturaPdf.wyswietlaj_od_kogo' => array(
		'opis' => 'Wyswietla pole Var ref. na fakturze',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	'grid.data_wystawienia_format' => array(
		'opis' => 'Format daty wystawienia faktury',
		'typ' => 'varchar',
		'wartosc' => 'd-m-Y',
		),

	'grid.data_wystawienia_format_datapicker' => array(
		'opis' => 'Format daty wystawienia faktury',
		'typ' => 'varchar',
		'wartosc' => 'dd-mm-yyyy',
		),

	'grid.data_zaplaty_format' => array(
		'opis' => 'Format daty zapłaty faktury',
		'typ' => 'varchar',
		'wartosc' => 'd-m-Y',
		),

	'grid.data_zaplaty_format_datapicker' => array(
		'opis' => 'Format daty zapłaty faktury',
		'typ' => 'varchar',
		'wartosc' => 'dd-mm-yyyy',
		),

	'grid.dziecko_przedrostek' => array(
		'opis' => 'Ikona wskazująca na dziecko faktury',
		'typ' => 'varchar',
		'wartosc' => ' <i class="icon icon-long-arrow-right"></i> ',
		),

	'grid.klient_get' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'get',
		),

	'grid.klient_prywatny' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'Private',
		),

	'grid.kreditnota_przedrostek' => array(
		'opis' => 'Dodawany na gridzie dla oznaczenia kreditnota',
		'typ' => 'varchar',
		'wartosc' => '<span class="label label-success"><i class="icon icon-minus-sign"></i></span> ',
		),

	'grid.purring_przedrostek' => array(
		'opis' => 'Dodawany na gridzie dla oznaczenia purring',
		'typ' => 'varchar',
		'wartosc' => '<span class="label label-success"><i class="icon icon-legal"></i></span> ',
		),

	'grupa_zamowien_odbiorcy_prywatni' => array(
		'opis' => 'Helper - grupa zamówień dla odbiorców prywatnych',
		'typ' => 'varchar',
		'wartosc' => 'other_orders',
		),
	'odbiorca_raport_kategoria' => array(
		'opis' => 'Helper - odbiorca dla kategorii raportu',
		'typ' => 'array',
		'wartosc' => array(
			'villa instalacje raport faktura' => 1,
			'homenet villa report' => 59920,
			'b2b instalacje raport faktura' => 1,
			'digging report' => 1,
			'gravebefaring raport faktura' => 1,
			'b2b befaring raport faktura' => 1,
		),
	),
	'id_klient_get' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 1,
		),

	'id_typow_prywatnych' => array(
		'opis' => 'Id typów zamówień dla faktur prywatnych',
		'typ' => 'list',
		'wartosc' => array(
			26,
			27,
			28,
			29,
			17,
			31,
			),
		),
	'ilosc_dni_na_platnosc_id_klienta' => array(
		'opis' => 'id klienta -> ilosc dni na platnosc',
		'typ' => 'array',
		'wartosc' => array(
			59920 => 45
			),
	),
	'ilosc_dni_na_platnosc_firma' => array(
		'opis' => 'Helper - ilosc dni na platnosc firma',
		'typ' => 'int',
		'wartosc' => 30,
		),

	'ilosc_dni_na_platnosc_inkassovarsel' => array(
		'opis' => 'Ilość dnia na płatności dla inkassovarsel',
		'typ' => 'int',
		'wartosc' => 14,
		),

	'ilosc_dni_na_platnosc_klient_prywatny' => array(
		'opis' => 'Helper - ilosc dni na platnosc dla klient prywatnego',
		'typ' => 'int',
		'wartosc' => 14,
		),

	'ilosc_dni_na_platnosc_odbiorcy_prywatni' => array(
		'opis' => 'Helper - ilość dni na płatność dla odbiorców prywatnych',
		'typ' => 'int',
		'wartosc' => 14,
		),

	'ilosc_dni_na_platnosc_projekt' => array(
		'opis' => 'Helper - ilość dni na płatność dla projektów',
		'typ' => 'int',
		'wartosc' => 30,
		),

	'ilosc_dni_na_platnosc_purring' => array(
		'opis' => 'Ilość dnia na płatności dla purring',
		'typ' => 'int',
		'wartosc' => 14,
		),

	'ilosc_dni_na_platnosc_raport' => array(
		'opis' => 'Helper - ilość dni na płatność dla raportów',
		'typ' => 'array',
		'wartosc' => array(
			'villa instalacje raport faktura' => 30,
			'homenet villa report' => 45,
			'b2b instalacje raport faktura' => 30,
			'digging report' => 30,
			'gravebefaring raport faktura' => 30,
			'b2b befaring raport faktura' => 30,
		),
		),

	'ilosc_upomnien_inkassovarsel' => array(
		'opis' => 'Ilość upomnień po których zostanie wystawiony inkassovarsel',
		'typ' => 'int',
		'wartosc' => 1,
		),

	'index.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'data_wystawienia',
		'dozwolone' => array(
			0 => 'id',
			1 => 'data_wystawienia',
			2 => 'data_zaplaty',
			3 => 'numer_faktury',
			),
		),

	'index.pager_konfiguracja' => array(
		'opis' => 'Konfiguracja stronnicowania',
		'typ' => 'pager',
		'wartosc' => array(
			'zakres' => 10,
			'wyborStrony' => 'linki',
			'wyborZakresu' => 'select',
			'skoczDo' => 'form',
			'pierwszaOstatnia' => 1,
			'poprzedniaNastepna' => 1,
			),
		),

	'index.wierszy_na_stronie' => array(
		'maks' => '100',
		'opis' => 'Ilość wierszy na stronie w liście użytkowników',
		'typ' => 'int',
		'wartosc' => 999,
		),

	'index.zakladki' => array(
		'opis' => 'Zakładki z linkami',
		'typ' => 'list',
		'wartosc' => array(
			'Prepare factura',
			'1.termin',
			'2.termin',
			'3.termin',
			'4.termin',
			'5.termin',
			'6.termin',
			),
		),

	'kategorie_raport_osoba_kontaktowa' => array(
		'opis' => 'Id osoby kontaktowej dla kategorii raportów',
		'typ' => 'array',
		'wartosc' => array(
			'villa instalacje raport faktura' => 57762,
			'b2b instalacje raport faktura' => 57762,
			'digging report' => 57762,
			'gravebefaring raport faktura' => 57762,
			'b2b befaring raport faktura' => 57762,
			'homenet villa report' => 62512,
			),
		),
	'klient_prywatny_nazwa_faktury' => array(
		'opis' => 'Helper - nazwa faktury dla klientów prywatnych',
		'typ' => 'varchar',
		'wartosc' => '{KOD} {MIASTO}, {ADRES}',
		),

	'kreditnota_ilosc_dni_na_platnosc' => array(
		'opis' => 'Ilość dni na płatność kreditnoty',
		'typ' => 'int',
		'wartosc' => 14,
		),

	'kreditnota_nazwa' => array(
		'opis' => 'Nazwa kreditnota',
		'typ' => 'varchar',
		'wartosc' => 'Kreditnota {NAZWA_FAKTURY}',
		),

	'kwota_upomnienia_purring' => array(
		'opis' => 'domyślna kwota upomnienia dla purring',
		'typ' => 'int',
		'wartosc' => 64,
		),

	'kwota_znaczek' => array(
		'opis' => 'Format daty zapłaty faktury',
		'typ' => 'varchar',
		'wartosc' => '',
		),

	'magazyn.wyszukiwarka_wierszy_na_stronie' => array(//TODO
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '',
		),

	'maksymalna_ilosc_upomnien' => array(
		'opis' => 'Po przekroczeniu tej liczby nie będzie można dodawać upomnień',
		'typ' => 'int',
		'wartosc' => 2,
		),

	'manuallyinvoices.domyslne_sortowanie' => array(
		'opis' => '',
		'typ' => 'select',
		'wartosc' => 'data_dodania',
		'dozwolone' => array(
			0 => 'id',
			1 => 'data_dodania',
			2 => 'numer_faktury',
			),
		),

	'nazwa_inkassovarsel_przedrostek' => array(
		'opis' => 'Przedrostek który zostanie dodany do nazwy faktury dla inkassovarsel',
		'typ' => 'varchar',
		'wartosc' => 'Inkassovarsel - ',
		),

	'nazwa_pliku_inkassovarsel' => array(
		'opis' => 'Nazwa pliku pdf purring',
		'typ' => 'varchar',
		'wartosc' => 'Inkassovarsel_{NR_FAKTURY}',
		),

	'nazwa_pliku_purring' => array(
		'opis' => 'Nazwa pliku pdf purring',
		'typ' => 'varchar',
		'wartosc' => 'Purring_{NR_FAKTURY}',
		),

	'nazwa_purring_przedrostek' => array(
		'opis' => 'Przedrostek który zostanie dodany do nazwy faktury dla purring',
		'typ' => 'varchar',
		'wartosc' => 'Purring - ',
		),

	'numer_konta_bankowego' => array(
		'opis' => 'Numer konta bankowego',
		'typ' => 'varchar',
		'wartosc' => '1503 32 27407',
		),

	'pdf.data_zaplaty_format' => array(
		'opis' => 'Domyślna jednostka na fakturze',
		'typ' => 'varchar',
		'wartosc' => 'd.m.Y',
		),

	'pdf.numer_klienta_start' => array(
		'opis' => 'Numer klienta na fakturze',
		'typ' => 'int',
		'wartosc' => 10000,
		),

	'pierwszy_numer_faktury' => array(
		'opis' => 'Cyfra od której będzie zaczynało się numerowanie faktur',
		'typ' => 'varchar',
		'wartosc' => '6000',
		),

	'pierwszy_numer_kreditnota' => array(
		'opis' => 'Cyfra od której będzie zaczynało się numerowanie kreditnoty',
		'typ' => 'varchar',
		'wartosc' => '100',
		),

	'pobierzWynikiSzukaj.iloscZnakow' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 2,
		),

	'pobierzWynikiSzukaj.pager_konfiguracja' => array(//TODO
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '',
		),

	'purring.miejsce_wystawienia' => array(
		'opis' => 'Miejsce wystawienia purringu',
		'typ' => 'varchar',
		'wartosc' => 'Oslo',
		),

	'raport_b2b_nazwa_faktury' => array(
		'opis' => 'Helper - nazwa faktury dla raportów',
		'typ' => 'varchar',
		'wartosc' => 'Installasjon B2B {DATA_OD} - {DATA_DO}',
		),

	'raport_digging_nazwa_faktury' => array(
		'opis' => 'Helper - nazwa faktury dla raportów',
		'typ' => 'varchar',
		'wartosc' => 'Digging {DATA_OD} - {DATA_DO}',
		),
	'raport_homenet_villa_nazwa_faktury' => array(
		'opis' => 'Helper - nazwa faktury dla raportów',
		'typ' => 'varchar',
		'wartosc' => 'Villainstallasjon {DATA_OD} - {DATA_DO}',
		),
	'raport_domyslna_nazwa_faktury' => array(
		'opis' => 'Helper - nazwa faktury dla raportów domyslna',
		'typ' => 'varchar',
		'wartosc' => 'Raport id {ID}',
		),

	'raport_villa_nazwa_faktury' => array(
		'opis' => 'Helper - nazwa faktury dla raportów',
		'typ' => 'varchar',
		'wartosc' => 'Villainstallasjon {DATA_OD} - {DATA_DO}',
		),
	'raport_gravebefaring_nazwa_faktury' => array(
		'opis' => 'Helper - nazwa faktury dla raportów',
		'typ' => 'varchar',
		'wartosc' => 'Utførte Gravebefaringer iht. vedlegg',
		),
	'raport_b2b_befaring_nazwa_faktury' => array(
		'opis' => 'Helper - nazwa faktury dla raportów',
		'typ' => 'varchar',
		'wartosc' => 'Utførte B2B befaringer iht. vedlegg',
	),
	'rodzaj_inkassovarsel' => array(
		'opis' => 'Rodzaj faktury dla inkassovarsel',
		'typ' => 'varchar',
		'wartosc' => 'inkassovarsel',
		),

	'rodzaj_purring' => array(
		'opis' => 'Rodzaj faktury dla purring',
		'typ' => 'varchar',
		'wartosc' => 'purring',
		),

	'search.wyszukiwarka_wierszy_na_stronie' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 10,
		),

	'tylko_adres_podstawowy_faktury' => array(//TODO
		'opis' => 'Przy wystawianiu faktury wymusza użycie adresu podstawowego klienta, w przeciwnym razie brany jest adres korespondencyjny a przy jego braku adres podstawowy',
		'typ' => 'bool',
		'wartosc' => null,
		),

	'typ_produktu_klienci_prywatni' => array(
		'opis' => 'Helper - typ produktu dla klientów prywatnych',
		'typ' => 'varchar',
		'wartosc' => 'Installation',
		),

	'typ_produktu_raport' => array(
		'opis' => 'Helper - typ produktu dla raportów',
		'typ' => 'varchar',
		'wartosc' => 'Installation',
		),

	'varenr_szablon_pozycje_faktury' => array(
		'opis' => 'Szablon nazwy dla varenr dla pozycji zapisanych w tabeli modul_pozycje_faktury (faktury reczne)',
		'typ' => 'varchar',
		'wartosc' => 'FP{ID}',
		),

	'varenr_szablon_produkty' => array(
		'opis' => 'Szablon nazwy dla varenr dla produktów zapisanych w tabeli modul_produkty',
		'typ' => 'varchar',
		'wartosc' => '{ID}',
		),

	'varenr_szablon_produkty_zakupione' => array(
		'opis' => 'Szablon nazwy dla varenr dla produkty zakupione',
		'typ' => 'varchar',
		'wartosc' => 'PZ{ID}',
		),

	'varenr_szablon_raport' => array(
		'opis' => 'Szablon nazwy dla varenr dla raportów',
		'typ' => 'varchar',
		'wartosc' => 'R{ID}',
		),

	'vat' => array(
		'opis' => '',
		'typ' => 'int',
		'wartosc' => 25,
		),

	'wyslijFaktura.id_formatki_faktura_kreditnota' => array(
		'opis' => 'Formatka maila dla faktury z kreditnota',
		'typ' => 'mail',
		'wartosc' => 25,
		),

	'wyslijFaktura.id_formatki_faktura_projekt' => array(
		'opis' => 'Formatka maila dla faktury dla projektu',
		'typ' => 'mail',
		'wartosc' => 22,
		),

	'wyslijFaktura.id_formatki_faktura_prywatni' => array(
		'opis' => 'Formatka maila dla faktury dla klientow prywatnych',
		'typ' => 'mail',
		'wartosc' => 23,
		),

	'wyslijFaktura.id_formatki_faktura_raport' => array(
		'opis' => 'Formatka maila dla faktury z raportem',
		'typ' => 'mail',
		'wartosc' => 21,
		),

	'wyslijFaktura.id_formatki_faktura_reczna' => array(
		'opis' => 'Formatka maila dla faktur ręcznych',
		'typ' => 'mail',
		'wartosc' => 24,
		),

	'wyslijFaktura.id_formatki_faktura_upomnienie' => array(
		'opis' => 'Formatka maila dla faktury upomnienie',
		'typ' => 'mail',
		'wartosc' => 26,
		),

	'wyslijFakture.wysylaj_do_osoby_kontaktowej_' => array(//TODO
		'opis' => 'Czy wysylać email do osoby kontaktowej w fakturach recznych',
		'typ' => 'bool',
		'wartosc' => null,
		),

	'wyslijFakture.wysylaj_do_osoby_kontaktowej_Reports' => array(//TODO
		'opis' => 'Czy wysylać email do osoby kontaktowej w raportach',
		'typ' => 'bool',
		'wartosc' => null,
		),

	'wyslijFakture.wysylaj_do_osoby_kontaktowej_Zamowienie' => array(//TODO
		'opis' => 'Czy wysylać email do osoby kontaktowej w zamówieniach',
		'typ' => 'bool',
		'wartosc' => null,
		),
	'rodzajeRabatu' => array(
		'opis' => 'Rodzaje rabatu',
		'typ' => 'list',
		'wartosc' => array(
			'kwotowy',
			'procentowy',
			),
		),
	);
}
