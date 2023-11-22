<?php
namespace Generic\Konfiguracja\Modul\BlokKontoUzytkownika;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['index.tresc_zalogowany']
 * @property string $k['index.tresc_zamiast_formularza']
 * @property bool $k['index.wyswietlac_formularz']
 * @property string $k['szablon.formularz']
 */

class Http extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(

	'index.tresc_zalogowany' => array(
		'opis' => 'Treść wyświetlana jeśli użytkownik jest zalogowany. Pozostaw puste aby bloczek nie wyświetlił się.
 Można użyć następujących zmiennych: {link_konto_uzytkownika}, {nazwa_uzytkownika}, {link_wylogowanie}',
		'typ' => 'html',
		'wartosc' => '<div class="fR" id="logArea"><span>Zalogowany: <a href="{link_konto_uzytkownika}" title="Edycja profilu"><var>{nazwa_uzytkownika}</var></a></span> <a href="{link_wylogowanie}"><span><strong>Wyloguj</strong></span></a></div>',
		),

	'index.tresc_zamiast_formularza' => array(
		'opis' => 'Treść wyświetlana zamiast formularza logowania gdy użytkownik nie jest zalogowany. Można użyć następujących zmiennych: {link_rejestracja}, {link_logowanie}, {link_przypomnienie}, {link_wylogowanie}, {link_konto_uzytkownika}',
		'typ' => 'html',
		'wartosc' => '<div id="logArea" class="fR"><span>Nie masz jeszcze konta?</span><a href="{link_rejestracja}" title="Zarejestruj">Zarajestruj się</a><span>teraz lub<span><a href="{link_logowanie}" title="Zaloguj">zaloguj się</a></div>',
		),

	'index.wyswietlac_formularz' => array(
		'opis' => 'Czy wyświetlać formularz logowania? Jeżeli odznaczone wyświetla się blok tekstowy.',
		'typ' => 'bool',
		'wartosc' => 1,
		),

	'szablon.formularz' => array(
		'opis' => '',
		'typ' => 'varchar',
		'wartosc' => '/moduly/BlokKontoUzytkownika/formularz.tpl',
		),

	);
}
