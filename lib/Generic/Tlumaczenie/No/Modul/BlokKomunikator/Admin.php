<?php
namespace Generic\Tlumaczenie\No\Modul\BlokKomunikator;

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
class Admin extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'index.bkt_wo' => 'BKT ID:',
		'index.etykieta_brak_kontaktow' => 'Ingen valgt kontakter i øyeblikket.',
		'index.etykieta_historia_podglad' => 'Meldingshistorikk',
		'index.etykieta_lista_kontaktow' => 'Kontaktliste',
		'index.etykieta_naglowek' => 'BKT AS Communicator',
		'index.etykieta_odznacz_wszystkie' => 'Opphev alle',
		'index.etykieta_rodzaj_email' => 'Email',
		'index.etykieta_rodzaj_sms' => 'Sms',
		'index.etykieta_zaznacz_wszystkie' => 'Velg alle',
		'index.filtruj_placeholder' => 'Skriv for å søke ...',
		'index.get_wo' => 'WO:',
		'index.komunikat_brak_maila_tresc' => 'Click to switch communicator into <a href="javascript:switchTo(\\\'tryb_sms\\\', \\\'{ID}\\\');">SMS</a> mode.',
		'index.komunikat_brak_maila_tytul' => 'Selected contact does not have email address.',
		'index.komunikat_brak_numeru_tresc' => 'Click to switch communicator into <a href="javascript:switchTo(\\\'tryb_email\\\', \\\'{ID}\\\');">E-mail</a> mode.',
		'index.komunikat_brak_numeru_tytul' => 'Selected contact does not have mobile number.',
		'index.powiazane_zamowienie' => 'Angående bestilling {WO} <a href="javascript:czyscPowiazanie({ID})" class="tip-top btn-danger btn-small" title="Fjern tilkobling"><i class="icon icon-remove"></i></a>',
		'index.wiadomosc_placeholder' => 'Skriv inn melding her...',
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}