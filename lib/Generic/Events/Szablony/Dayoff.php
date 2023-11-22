<?php
return $konfiguracja = array(
	'nazwa' => 'Add Day Off',
	'opis' => 'Add Day Off to Workers',
	'nazwaWyswietlana' => "Day Off: {USER_NAME} ( {DATA_START} - {DATA_STOP} )",
	'konfiguracjaPodstawowa' => array(
		'typObiektu' => 'Uzytkownik', // typ obiektu głównego
		'idObiektu' => 'idUser', // id pobieranie z wygenerowanego formularza
		'wyswietlajWMenu' => true,
		'typWyswietlania' => 'eUser', // eTeam , eUser, moze eHoursTeam i eHoursUser
		//'multiEvent' => true, // jesli przy dodawaniu eventu występują odstepy w zaznaczonych datach to każdy nowy początek - koniec okresu będzie dodawany jako nowy event
	),
	'akcje' => array(
		0 => array(
			'nazwa' => 'akcjaUstawUrlop', // nazwa metody
			'tytul' => 'Add Day Off for users', // tytuł metody wyswietlany w widoku
			'typ' => 'cron',
			'obiektyPowiazane' => array(
				'Uzytkownik' => 'obiektGlowny',
			),
			'opis' => 'Day Off {UZYTKOWNIK_IMIE} {UZYTKOWNIK_NAZWISKO} {DATA_START} {DATA_STOP}' ,
			'daneWejsciowe' => array( // dane potrzebne do wykonania metody
				'idTeam' => 'idTeam', // id przydzielanego teamu
				'idUser' => 'idUser', //
				'dataStart' => 'dataStart',
				'dataStop' => 'dataStop',
				'rodzajDniWolnych' => 'rodzajDniWolnych',
				'hourPerDay' => 'hourPerDay',
			),
			'daneWyjsciowe' => array( // zwracane przez metode
				'dataWykonania' => 'dataWykonania',
			),
			'blokiSzablonu' => array( // blok szablonu przy dodawaniu Eventu
				'wstawZMetody' => array('wstawListeUzytkownikowIDniWolnych' => array()),
			),
			'dataWykonania' => array( // data wykonania metody 
				'liczOd' => 'startKalendarz',
				'dni' => '- 1 day',
			),
			'konfiguracjaMetody' => array(
				'region' => '', 
			),
			'wymagane' => array(), // metody wymagane do wykonania tej metody
		),
		1 => array(
			'nazwa' => 'akcjaDaneKalendarza',
			'tytul' => 'General information',
			'typ' => 'zapis',
			'blokiSzablonu' => array(
				'nazwaWyswietlana' => array(
						'parametry' => array( // $(aktualizujTytul).on(aktulizujPo, function(){ $('input[name^=nazwaWyswietlana]').val(tekst); } tekst - mozna wstrzyknac kawałek kodu javascript )
							'aktualizujTytul' => 'document',
							'aktulizujPo' => 'now', // po jakim evencie ma być aktualizowane pole Tytułu (now -> wstawiony tytuł z tekst, możliwosci click, load itp)
							'tekst' => '"Day Off: {USER_NAME} ( {DATA_START} - {DATA_STOP} )"', // nazwa eventu
						),
						),
				'komentarz' => array(
					'parametry' => array(),
					),
				'kolor' => array(
						'parametry' => array('kolorDomyslny' => '#ccccc'),
						),
				),
			'konfiguracjaMetody' => array(
					'region' => '', 
					),
				),
		
	),
);

?>