<?php
namespace Generic\Tlumaczenie\Pl\Biblioteka;

use Generic\Tlumaczenie\Tlumaczenie;


/**
 *
 */
class Walidatory extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
		'walidator_adres_ip_nieprawidlowy_adres' => 'Adres IP nieprawidłowy',
		'walidator_captcha_text_nieprawidlowa_wartosc' => 'Podany wynik jest nieprawidłowy. Przykład: "cztery razy 1" - należy wpisać "4"',
		'walidator_dluzsze_od_wartosc_za_krotka' => 'Wartość zbyt krótka',
		'walidator_data_czas_iso_nieprawidlowa_data' => 'Nieprawidłowa data',
		'walidator_data_iso_nieprawidlowa_data' => 'Nieprawidłowa data',
		'walidator_data_pl_nieprawidlowa_data' => 'Nieprawidłowa data',
		'walidator_dluzsze_od_wartosc_za_krotka' => 'Wartość zbyt krótka',
		'walidator_domena_nieprawidlowa_domena' => 'Domena nieprawidłowa',
		'walidator_domena_serwer_nie_odpowiada' => 'Serwer nie odpowiada',
		'walidator_dozwolone_wartosci_niedozwolona_wartosc' => 'Wartość nie znajduje się na liście wartości akceptowanych.',
		'walidator_email_nieprawidlowy_email' => 'Nieprawidłowy adres e-mail',
		'walidator_email_serwer_nie_obsluguje_poczty' => 'Nieprawidłowy adres e-mail: serwer nie obsługuje poczty',
		'walidator_godzina_nieprawidlowa_godzina' => 'Nieprawidłowa godzina',
		'walidator_niepoprawny_html' => 'Wprowadzona treść jest niezgodna z formatem HTML',
		'walidator_kod_pocztowy_nieprawidlowy_kod' => 'Kod pocztowy jest nieprawidłowy',
		'walidator_krotsze_od_wartosc_za_dluga' => 'Wartość zbyt długa',
		'walidator_kwota_nieprawidlowa_kwota' => 'Nieprawidłowy zapis kwoty',
		'walidator_liczba_calkowita_nieprawidlowa_liczba' => 'To nie jest liczba całkowita.',
		'walidator_liczba_zmiennoprzecinkowa_nieprawidlowa_liczba' => 'To nie jest liczba zmiennoprzecinkowa',
		'walidator_mniejsze_od_liczba_za_duza' => 'Wartość zbyt duża',
		'walidator_niedozwolone_wartosci_niedozwolona_wartosc' => 'Niedozwolona Wartość.',
		'walidator_niedozwolony_tekst_zawiera_tekst' => 'Wartość zawiera niedozwolony tekst',
		'walidator_nie_puste_wartosc_pusta' => 'Pole nie może być puste.',
		'walidator_nip_nieprawidlowy_nip' => 'Nieprawidłowy numer NIP',
		'walidator_nr_konta_iban_nieprawidlowy_numer' => 'Nieprawidłowy numer konta w formacie IBAN',
		'walidator_nr_konta_nrb_nieprawidlowy_numer' => 'Nieprawidłowy numer konta w formacie NRB',
		'walidator_numer_dowodu_nieprawidlowy_numer' => 'Numer i seria dowodu osobistego nieprawidłowa',
		'walidator_numer_paszportu_nieprawidlowy_numer' => 'Numer i seria paszportu nieprawidłowa',
		'walidator_pesel_nieprawidlowy_numer' => 'Numer PESEL nieprawidłowy',
		'walidator_pesel_data_urodzenia_nie_zgadza_sie' => 'Data urodzenia niezgodna z numerem Pesel',
		'walidator_poprawny_upload_UPLOAD_ERR_OK' => 'Kopiowanie pliku zakończyło się sukcesem.',
		'walidator_poprawny_upload_UPLOAD_ERR_INI_SIZE' => 'Rozmiar pliku przekroczył wartość upload_max_filesize z pliku php.ini.',
		'walidator_poprawny_upload_UPLOAD_ERR_FORM_SIZE' => 'Rozmiar pliku przekroczył wartość MAX_FILE_SIZE z formularza HTML.',
		'walidator_poprawny_upload_UPLOAD_ERR_PARTIAL' => 'Plik został skopiowany tylko częściowo.',
		'walidator_poprawny_upload_UPLOAD_ERR_NO_FILE' => 'Żaden plik nie został skopiowany.',
		'walidator_poprawny_upload_UPLOAD_ERR_NO_TMP_DIR' => 'Brak katalogu tymczasowego.',
		'walidator_poprawny_upload_UPLOAD_ERR_CANT_WRITE' => 'Nie można zapisać pliku na dysk.',
		'walidator_poprawny_upload_UPLOAD_ERR_EXTENSION' => 'Kopiowanie pliku wstrzymane przez rozszerzenie PHP.',
		'walidator_puste_nie_puste' => 'Nie jest puste',
		'walidator_regon_nieprawidlowy' => 'Numer REGON nie jest nieprawidłowy',
		'walidator_rowne_nie_jest_rowne' => 'Nieprawidłowa wartość.',
		'walidator_rozmiar_pliku_nieprawidlowy' => 'Plik ma niedozwoloną wielkość.',
		'walidator_rozne_od_nie_jest_rozne' => 'Nieprawidłowa wartość.',
		'walidator_rozszerzenie_pliku_nieprawidlowe' => 'Plik ma niedozwolone rozszerzenie.',
		'walidator_niepoprawna_domena' => 'Niepoprawna nazwa subdomeny',
		'walidator_telefon_nieprawidlowy_numer' => 'Numer telefonu nieprawidłowy',
		'walidator_url_nieprawidlowy_url' => 'Adres URL nieprawidłowy',
		'walidator_url_serwer_nie_odpowiada' => 'Serwer nie odpowiada',
		'walidator_wieksze_od_liczba_za_mala' => 'Wartość zbyt mała.',
		'walidator_wspolrzedne_geograficzne_nieprawidlowe' => 'Lokalizacja jest nieprawidłowa',
		'walidator_wymagane_wartosci_brak_wartosci' => 'Brak wymaganej wartości',
		'walidator_wyrazenie_regularne_niespelnione' => 'Wartość nie spełnia warunku',
		'walidator_zawiera_tekst_brak_tekstu' => 'Brak wymaganego tekstu',
	);
}