<?php
namespace Generic\Tlumaczenie\En\Modul\Tidsbanken;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie 
 * @property string $t['getKey.ip_klienta_nie_istnieje']
 * @property string $t['getKey.klucz_nie_istnieje']
 * @property string $t['zalogujPracownika.bledne_dane_klienta']
 * @property string $t['zalogujPracownika.uzytkownik_nie_aktywny']
 * @property string $t['zalogujPracownika.uzytkownik_nie_istnieje']
 */
class Api extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'getKey.ip_klienta_nie_istnieje' => 'Wrong ip address',
		'getKey.klucz_nie_istnieje' => 'Key does not exist',
		'zalogujPracownika.bledne_dane_klienta' => 'Wrong client data',
		'zalogujPracownika.uzytkownik_nie_aktywny' => 'Not active user',
		'zalogujPracownika.uzytkownik_nie_istnieje' => 'User does not exist',
		'zalogujPracownika.komunikatLogowanieLinia1' => '{UZYTKOWNIK}',
		'zalogujPracownika.komunikatLogowanieLinia2' => 'Log IN at {CZAS}',
		'zalogujPracownika.komunikatLogowanieLinia3' => '',
		'zalogujPracownika.komunikatWylogowanieLinia1' => '{UZYTKOWNIK}',
		'zalogujPracownika.komunikatWylogowanieLinia2' => 'Log OUT at {CZAS}',
		'zalogujPracownika.komunikatWylogowanieLinia3' => 'Work time : {CZAS_PRACY} ',
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}