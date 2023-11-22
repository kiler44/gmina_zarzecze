<?php
namespace Generic\Tlumaczenie\No\Modul\BlokKontoUzytkownika;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * @property string $t['index.blad_przekroczono_limit']
 * @property string $t['index.etykieta_input_haslo']
 * @property string $t['index.etykieta_input_login']
 * @property string $t['index.etykieta_input_submit']
 * @property string $t['index.etykieta_link_logowanie']
 * @property string $t['index.etykieta_link_przypomnienie']
 * @property string $t['index.etykieta_link_rejestracja']
 * @property string $t['index.etykieta_link_wylogowanie']
 * @property string $t['index.etykieta_pracownik_bok']
 * @property string $t['index.etykieta_profil']
 * @property string $t['index.etykieta_zalogowany']
 * @property string $t['index.tytul_strony']
 */

class Http extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
			'index.blad_przekroczono_limit' => 'Przekroczono limit nieudanych prób logowania',
		'index.etykieta_input_haslo' => 'Hasło',
		'index.etykieta_input_login' => 'Login',
		'index.etykieta_input_submit' => 'Zaloguj',
		'index.etykieta_link_logowanie' => 'Zaloguj',
		'index.etykieta_link_przypomnienie' => 'Przypomnij hasło',
		'index.etykieta_link_rejestracja' => 'Nowe konto',
		'index.etykieta_link_wylogowanie' => 'Wyloguj',
		'index.etykieta_pracownik_bok' => 'Tryb serwisowy',
		'index.etykieta_profil' => 'Twój profil',
		'index.etykieta_zalogowany' => 'Zalogowany użytkownik: ',
		'index.tytul_strony' => 'Logowanie do serwisu',
		);
}
