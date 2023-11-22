<?php
return $konfiguracja = array(
	'nazwa' => 'Befaring',
	'opis' => '',
	'konfiguracjaPodstawowa' => array(
		'idObiektu' => array('akcja' => 'akcjaDodajNotatke', 'metoda' => 'zapiszNotatke'), // 
		'typObiektu' => 'Notes', // typ obiektu glownego
		'wyswietlajWMenu' => true,
		'typWyswietlania' => 'eTeam', // eTeam , eUser, moze eHoursTeam i eHoursUser
	),
	'akcje' => array(
		0 => array(
			'nazwa' => 'akcjaDodajNotatke',
			'tytul' => 'Add note',
			'typ' => 'zapis',
			'opis' => 'Note for {TEAM_NAZWA} ',
			'daneWejsciowe' => array(
			),
			'daneWyjsciowe' => array( // zwracane przez metode
			),
			'blokiSzablonu' => array( // blok szablonu przy dodawaniu Eventu
				'dodajNotatke' => array(
						'parametry' => array(
						),
				),
				'dodajDoBefaring' => array(
					'parametry' => array(),
				)
			),
			'dataWykonania' => array( // data wykonania metody 
				'liczOd' => 'startKalendarz',
				'dni' => '+ 0 day',
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
			'blokiSzablonu' => array( // blok szablonu przy dodawaniu Eventu
				'nazwaWyswietlana' => array(
						'parametry' => array(
							'aktualizujTytul' => '#orderNumber_Befaring_0',
							'aktulizujPo' => 'focusout',
							'tekst' => '"Befaring : " + $(\'#orderNumber_Befaring_0\').val()',
						),
						),
				'komentarz' => array(
					'parametry' => array(),
					),
				'kolor' => array(
						'parametry' => array('kolorDomyslny' => '#00f2ff'),
						),
				),
			'konfiguracjaMetody' => array(
					'region' => 'closed', 
					),
			),
		2 => array(
			'nazwa' => 'akcjaPrzypiszNotatkeDoZamowienia',
			'typ' => 'cron',
			'tytul' => 'Assign note to Order',
			'daneWejsciowe' => array( // dane potrzebne do wykonania metody :  wartość pobierana => nazwaZmiennej
				'idTeam' => 'idTeam',
				'obiektGlowny:id' => 'idNotatki',
			),
			'obiektyPowiazane' => array(
				'Team' => array('daneWejsciowe' => 'idTeam',),
				'Notes' => array('daneWejsciowe' => 'idNotatki',),				
			),
			'daneWyjsciowe' => array(	),
			'blokiSzablonu' => array(
				
			),
			'dataWykonania' => array( // data wykonania metody 
				'liczOd' => 'startKalendarz',
				'dni' => '+ 0 day',
			),
			'wymagane' => array(), // wymagane wykonanie metody przydziel Team o kodzie 0
			'konfiguracjaMetody' => array(
				'region' => 'closed', 
			),
			'opis' => 'Assigns note to Order No. {NOTATKA_ZAMOWIENIE_NUMER} if order exist',
		),
	),
);

?>