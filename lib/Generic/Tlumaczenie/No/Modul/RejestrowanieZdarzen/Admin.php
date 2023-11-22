<?php
namespace Generic\Tlumaczenie\No\Modul\RejestrowanieZdarzen;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 */

class Admin extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
		'_akcje_etykiety_' => array(
			'wykonajIndex' => 'Przeszukiwanie zarejestrowanych zdarzeń.',
		),

		'index.tytul_strony' => 'Przeszukaj zarejestrowane zdarzenia',
		'index.formularzNiepoprawny' => 'Niektóre pola nie zostały wypełnione poprawnie.',

		'formularzPrzeszukiwania.dataOd.etykieta' => 'Data od',
		'formularzPrzeszukiwania.dataOd.opis' => '',
		'formularzPrzeszukiwania.dataDo.etykieta' => 'Data do',
		'formularzPrzeszukiwania.dataDo.opis' => '',
		'formularzPrzeszukiwania.zdarzenie.etykieta' => 'Zdarzenie',
		'formularzPrzeszukiwania.zdarzenie.opis' => '',
		'formularzPrzeszukiwania.typObiektuGlownego.etykieta' => 'Obiekt główny',
		'formularzPrzeszukiwania.typObiektuGlownego.opis' => '',
		'formularzPrzeszukiwania.idObiektuGlownego.etykieta' => 'Identyfikator obiektu głównego',
		'formularzPrzeszukiwania.idObiektuGlownego.opis' => '',
		'formularzPrzeszukiwania.idPracownika.etykieta' => 'Identyfikator użytkownika',
		'formularzPrzeszukiwania.idPracownika.opis' => '',
		'formularzPrzeszukiwania.tokenProcesu.etykieta' => 'Toekn procesu',
		'formularzPrzeszukiwania.tokenProcesu.opis' => '',
		'formularzPrzeszukiwania.pokaz.wartosc' => 'Pokaż',
		'formularzPrzeszukiwania.dowolne' => '- Dowolne -',

		'raportZdarzen.data' => 'Data',
		'raportZdarzen.nazwa' => 'Nazwa',
		'raportZdarzen.uzytkownik' => 'Użytkownik',
		'raportZdarzen.typObiektuGlownego' => 'Obiekt główny',
		'raportZdarzen.idObiektuGlownego' => 'Id obiektu głównego',
		'raportZdarzen.tokenProcesu' => 'Token procesu',
		'raportZdarzen.pustyWiersz' => 'b.d.',
	);

	protected $typyPolTlumaczen = array(

	);
}
