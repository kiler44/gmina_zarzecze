<?php
namespace Generic\Tlumaczenie\Pl\Modul\BlokKomunikator;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie 
 * @property string $t['index.bkt_wo']
 * @property string $t['index.etykieta_brak_kontaktow']
 * @property string $t['index.etykieta_historia_podglad']
 * @property string $t['index.etykieta_lista_kontaktow']
 * @property string $t['index.etykieta_naglowek']
 * @property string $t['index.etykieta_odznacz_wszystkie']
 * @property string $t['index.etykieta_rodzaj_email']
 * @property string $t['index.etykieta_rodzaj_sms']
 * @property string $t['index.etykieta_zaznacz_wszystkie']
 * @property string $t['index.filtruj_placeholder']
 * @property string $t['index.get_wo']
 * @property string $t['index.komunikat_brak_maila_tresc']
 * @property string $t['index.komunikat_brak_maila_tytul']
 * @property string $t['index.komunikat_brak_numeru_tresc']
 * @property string $t['index.komunikat_brak_numeru_tytul']
 * @property string $t['index.powiazane_zamowienie']
 * @property string $t['index.wiadomosc_placeholder']
 */
class Http extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'index.bkt_wo' => 'BKT ID:',
		'index.etykieta_brak_kontaktow' => 'Nie wybrano żadnych kontaktów.',
		'index.etykieta_historia_podglad' => 'Historia komunikatów',
		'index.etykieta_lista_kontaktow' => 'Kontakty',
		'index.etykieta_naglowek' => 'Komunikator BKT AS',
		'index.etykieta_odznacz_wszystkie' => 'Nikt',
		'index.etykieta_rodzaj_email' => 'Email',
		'index.etykieta_rodzaj_sms' => 'Sms',
		'index.etykieta_zaznacz_wszystkie' => 'Wszyscy',
		'index.filtruj_placeholder' => 'szukaj kontaktu...',
		'index.get_wo' => 'WO:',
		'index.komunikat_brak_maila_tresc' => 'Kliknij aby przełączyć komunikator w tryb <a href="javascript:switchTo(\\\'tryb_sms\\\', \\\'{ID}\\\');">SMS</a>.',
		'index.komunikat_brak_maila_tytul' => 'Wybrany kontakt nie posiada adresu e-mail.',
		'index.komunikat_brak_numeru_tresc' => 'Kliknij aby przełączyć komunikator w tryb <a href="javascript:switchTo(\\\'tryb_email\\\', \\\'{ID}\\\');">E-mail</a>.',
		'index.komunikat_brak_numeru_tytul' => 'Wybrany kontakt nie posiada telefonu komórkowego.',
		'index.powiazane_zamowienie' => 'Powiązane zamówienie {WO} <a href="javascript:czyscPowiazanie({ID})" class="tip-top btn-danger btn-xs" title="Usuń powiązanie"><i class="icon icon-remove"></i></a>',
		'index.wiadomosc_placeholder' => 'Wpisz wiadomość tutaj...',
		
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}