<?php
namespace Generic\Tlumaczenie\En\Biblioteka;

use Generic\Tlumaczenie\Tlumaczenie;


/**
 *
 */
class Walidatory extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
		'walidator_adres_ip_nieprawidlowy_adres' => 'IP address invalid',
		'walidator_captcha_text_nieprawidlowa_wartosc' => 'Entered value is not valid. Example: "four times 1" - enter "4"',
		'walidator_dluzsze_od_wartosc_za_krotka' => 'Value too short',
		'walidator_data_czas_iso_nieprawidlowa_data' => 'Data is not valid',
		'walidator_data_iso_nieprawidlowa_data' => 'Data is not valid',
		'walidator_data_pl_nieprawidlowa_data' => 'Data is not valid',
		'walidator_domena_nieprawidlowa_domena' => 'Domain is not valid',
		'walidator_domena_serwer_nie_odpowiada' => 'Server doesn\'t respond',
		'walidator_dozwolone_wartosci_niedozwolona_wartosc' => 'Value not acceptable.',
		'walidator_email_nieprawidlowy_email' => 'E-mail is not valid',
		'walidator_email_serwer_nie_obsluguje_poczty' => 'E-mail is not valid',
		'walidator_godzina_nieprawidlowa_godzina' => 'Time is not valid',
		'walidator_niepoprawny_html' => 'This is invalid HTML input',
		'walidator_kod_pocztowy_nieprawidlowy_kod' => 'Postcode is not valid',
		'walidator_krotsze_od_wartosc_za_dluga' => 'Value too long',
		'walidator_kwota_nieprawidlowa_kwota' => 'Amount is not valid',
		'walidator_liczba_calkowita_nieprawidlowa_liczba' => 'This is not valid integer value.',
		'walidator_liczba_zmiennoprzecinkowa_nieprawidlowa_liczba' => 'This is not valid float value',
		'walidator_mniejsze_od_liczba_za_duza' => 'Value id too big',
		'walidator_niedozwolone_wartosci_niedozwolona_wartosc' => 'Value is not valid.',
		'walidator_niedozwolony_tekst_zawiera_tekst' => 'Value contains not allowed text',
		'walidator_nie_puste_wartosc_pusta' => 'This field cannot remain empty.',
		'walidator_nip_nieprawidlowy_nip' => 'Tax number not valid',
		'walidator_nr_konta_iban_nieprawidlowy_numer' => 'Account number not valid',
		'walidator_nr_konta_nrb_nieprawidlowy_numer' => 'Account number not valid',
		'walidator_numer_dowodu_nieprawidlowy_numer' => 'Document number not valid',
		'walidator_numer_paszportu_nieprawidlowy_numer' => 'Document number not valid',
		'walidator_pesel_nieprawidlowy_numer' => 'Personal number not valid',
		'walidator_pesel_data_urodzenia_nie_zgadza_sie' => 'Date of birth not valid according to the personal number',
		'walidator_poprawny_upload_UPLOAD_ERR_OK' => 'File upload successfull.',
		'walidator_poprawny_upload_UPLOAD_ERR_INI_SIZE' => 'File size is too big.',
		'walidator_poprawny_upload_UPLOAD_ERR_FORM_SIZE' => 'File size is too big.',
		'walidator_poprawny_upload_UPLOAD_ERR_PARTIAL' => 'File uploaded partially.',
		'walidator_poprawny_upload_UPLOAD_ERR_NO_FILE' => 'File upload failed.',
		'walidator_poprawny_upload_UPLOAD_ERR_NO_TMP_DIR' => 'No temporary directory.',
		'walidator_poprawny_upload_UPLOAD_ERR_CANT_WRITE' => 'Cannot write to the disk.',
		'walidator_poprawny_upload_UPLOAD_ERR_EXTENSION' => 'Upload canceled by PHP extension.',
		'walidator_puste_nie_puste' => 'Value in not empty',
		'walidator_regon_nieprawidlowy' => 'REGON is not valid',
		'walidator_rowne_nie_jest_rowne' => 'Value is not valid.',
		'walidator_rozmiar_pliku_nieprawidlowy' => 'File size is wrong.',
		'walidator_rozne_od_nie_jest_rozne' => 'Value is not valid.',
		'walidator_rozszerzenie_pliku_nieprawidlowe' => 'File has wrong extension.',
		'walidator_niepoprawna_domena' => 'Subdomain not valid',
		'walidator_telefon_nieprawidlowy_numer' => 'Telephone number not valid',
		'walidator_url_nieprawidlowy_url' => 'URL address not valid',
		'walidator_url_serwer_nie_odpowiada' => 'Server doesn\'t response',
		'walidator_wieksze_od_liczba_za_mala' => 'Value too small.',
		'walidator_wspolrzedne_geograficzne_nieprawidlowe' => 'Coordinates (Latitude, Longitude) not valid',
		'walidator_wymagane_wartosci_brak_wartosci' => 'The value doesn\'t match required one',
		'walidator_wyrazenie_regularne_niespelnione' => 'Value doesn\'t obbey required rule',
		'walidator_zawiera_tekst_brak_tekstu' => 'The value doesn\'t contain required text',
	);
}