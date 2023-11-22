<?php
namespace Generic\Konfiguracja\Modul\RejestrowanieZdarzen;

use Generic\Konfiguracja\Konfiguracja;

/**
 */

class Admin extends Konfiguracja
{
	protected $konfiguracjaDomyslna = array(
		'formularzPrzeszukiwania.listaObiektowGlownych' =>  array(
			'opis' => 'Lista obiektów głównych widoczna w formularzu przeszukiwania. Zapisujemy w postaci namespace => etykieta',
			'typ' => 'array',
			'wartosc' => array(
				'Generic\\Model\\Uzytkownik\\Obiekt' => 'Użytkownik',
				'Generic\\Model\\EmailFormatka\\Obiekt' => 'Email formatka',
				'Generic\\Model\\FormularzKontaktowyWiadomosc\\Obiekt' => 'Wiadomość z formularza kontaktowego',
				'Generic\\Model\\Kategoria\\Obiekt' => 'Kategoria',
				'Generic\\Model\\Ogloszenie\\Obiekt' => 'Oferta',
				'Generic\\Model\\Wizytowka\\Obiekt' => 'Wizytówka',
				'Generic\\Model\\Lokalizacja\\Obiekt' => 'Lokalizacja wizytówki',
				),
			),
		'index.wierszy_na_stronie' => array(
			'opis' => 'Ilość wierszy na stronie',
			'typ' => 'int',
			'wartosc' => 20,
		),
		'index.domyslne_sortowanie' => array(
			'opis' => 'Domyślne sortowanie listy',
			'typ' => 'select',
			'wartosc' => 'timestamp',
			'dozwolone' => array('data', 'nazwa', 'uzytkownik', 'typObiektuGlownego', 'idObiektuGlownego', 'tokenProcesu'),
		),

	);
}
