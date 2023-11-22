<?php
namespace Generic\Tlumaczenie\Pl\Modul\FormularzKontaktowy;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['formularz.error_zapisano_waidomosc']
 * @property string $t['formularz.etykieta_input_daneOsobowe']
 * @property string $t['formularz.etykieta_input_fax']
 * @property string $t['formularz.etykieta_input_firmaNazwa']
 * @property string $t['formularz.etykieta_input_gg']
 * @property string $t['formularz.etykieta_input_imie']
 * @property string $t['formularz.etykieta_input_komorka']
 * @property string $t['formularz.etykieta_input_nadawca']
 * @property string $t['formularz.etykieta_input_nazwisko']
 * @property string $t['formularz.etykieta_input_skype']
 * @property string $t['formularz.etykieta_input_stronaWWW']
 * @property string $t['formularz.etykieta_input_telefon']
 * @property string $t['formularz.etykieta_input_tematy']
 * @property string $t['formularz.etykieta_input_tresc']
 * @property string $t['formularz.etykieta_reset']
 * @property string $t['formularz.etykieta_wstecz']
 * @property string $t['formularz.etykieta_zapisz']
 * @property string $t['formularz.info_zapisano_waidomosc']
 * @property string $t['formularz.warning_formularz_niewypelniony']
 * @property string $t['index.blad_brak_strony']
 * @property string $t['index.tytul_modulu']
 * @property array $t['_akcje_etykiety_']
 * @property string $t['_akcje_etykiety_']['wykonajIndex']
 * @property string $t['_akcje_etykiety_']['wykonajFormularz']
 * @property array $t['_zdarzenia_etykiety_']
 * @property string $t['_zdarzenia_etykiety_']['wyslanie_maila']
 */

class Http extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
	
		'formularz.error_zapisano_waidomosc' => 'Błąd! Wiadomość nie została wysłana.',
		'formularz.etykieta_input_daneOsobowe' => 'Dane osobowe',
		'formularz.etykieta_input_fax' => 'Fax:',
		'formularz.etykieta_input_firmaNazwa' => 'Nazwa firmy:',
		'formularz.etykieta_input_gg' => 'GaduGadu:',
		'formularz.etykieta_input_imie' => 'Imię:',
		'formularz.etykieta_input_komorka' => 'Komórka:',
		'formularz.etykieta_input_nadawca' => 'Email nadawcy:',
		'formularz.etykieta_input_nazwisko' => 'Nazwisko:',
		'formularz.etykieta_input_skype' => 'Skype:',
		'formularz.etykieta_input_stronaWWW' => 'Strona WWW:',
		'formularz.etykieta_input_telefon' => 'Telefon:',
		'formularz.etykieta_input_tematy' => 'Temat: ',
		'formularz.etykieta_input_tresc' => 'Treść wiadomości:',
		'formularz.etykieta_reset' => 'Wyczyść',
		'formularz.etykieta_wstecz' => 'Wstecz',
		'formularz.etykieta_zapisz' => 'Wyślij',
		'formularz.info_zapisano_waidomosc' => 'Wiadomość została wysłana. Dziękujemy!',
		'formularz.warning_formularz_niewypelniony' => '<strong>Uwaga!</strong> Nie wszystkie wymagane pola zostały poprawnie wypełnione!',

		'index.blad_brak_strony' => 'Nie można pobrać treści strony',
		'index.tytul_modulu' => 'Formularz kontaktowy',
			'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Wyświetlanie modułu',
			'wykonajFormularz' => 'Wyświetlanie formularza',
		),

		'_zdarzenia_etykiety_' => array(
			'wyslanie_maila' => 'Wysłanie maila',
		),
	);
}
