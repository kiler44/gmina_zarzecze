<?php
namespace Generic\Konfiguracja\Modul\RejestrowanieZdarzen;

use Generic\Konfiguracja\Konfiguracja;

/**
 * @property string $k['uaktualnijIdObiektow.czasOstatniegoUruchomienia']
 * @property string $k['uaktualnijIdObiektow.okresWyszukiwania']
 */

class Cron extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(
		'uaktualnijIdObiektow.czasOstatniegoUruchomienia' => array(
			'opis' => 'Czas ostatniego uaktualnienia identyfikatorów obiektów. <strong>Ustawienie aktualizowane automatycznie.</strong>',
			'typ' => 'varchar',
			'wartosc' => '2010-01-01 00:00:01',
		),
		'uaktualnijIdObiektow.okresWyszukiwania' => array(
			'opis' => 'Określa jak daleko wstecz poszukiwane będą tokeny formularzy do uaktualnienia. Ustawienie ścisle powiązane z uaktualnijIdObiektow.czasOstatniegoUruchomienia. <br />Jeśli okres będzie krótszy od ostatniego uruchomienia zostana zebrane dane od daty wcześniejszej.',
			'typ' => 'select',
			'wartosc' => '1 day',
			'dozwolone' => array(
				'1 hour',
				'2 hour',
				'3 hour',
				'4 hour',
				'5 hour',
				'6 hour',
				'9 hour',
				'12 hour',
				'1 day',
				'2 day',
				'3 day',
				'4 day',
				'5 day',
				'6 day',
				'1 week',
				'2 week',
				'3 week',
				'1 month',
			),
		),
	);
}
