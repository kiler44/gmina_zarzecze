<?php
namespace Generic\Konfiguracja\Modul\FormularzKontaktowy;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['formularz.dane_osobowe_tresc']
 * @property string $k['formularz.tekst_przed_formularzem']
 * @property string $k['formularz.tekst_za_formularzem']
 * @property bool $k['formularz.wiele_tematow']
 * @property string $k['szablon.formularz']
 */

class Http extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'formularz.dane_osobowe_tresc' => array(
		'opis' => 'Treść zgody na przetwarzanie danych osobowych',
		'typ' => 'html',
		'wartosc' => 'Wyrażam zgodę na przetwarzanie moich danych osobowych, zgodnie z treścią ustawy z dn. 29 sierpnia 1997 r. o ochronie danych osobowych (Dz. U. z 1997 r. Nr 133 poz. 882)',
		),

	'formularz.tekst_przed_formularzem' => array(
		'opis' => 'Treść wyświetlająca się przed formularzem',
		'typ' => 'html',
		'wartosc' => '',
		),

	'formularz.tekst_za_formularzem' => array(
		'opis' => 'Treść wyświetlająca się za formularzem',
		'typ' => 'html',
		'wartosc' => '',
		),

	'formularz.wiele_tematow' => array(
		'opis' => 'Czy wyświtlać wiele tematów do wyboru',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	'szablon.formularz' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => 'formularz_rejestracja.tpl',
		),

	);
}
