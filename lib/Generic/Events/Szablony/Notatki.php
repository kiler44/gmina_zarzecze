<?php
return $konfiguracja = array(
	'nazwa' => 'Note',
	'opis' => '',
	'konfiguracjaPodstawowa' => array(
		'idObiektu' => array('akcja' => 'akcjaDodajNotatke', 'metoda' => 'zapiszNotatke'), // 
		'typObiektu' => 'Notes', // typ obiektu glownego
		'wyswietlajWMenu' => true,
		'typWyswietlania' => 'eTeam eUser', // eTeam , eUser, moze eHoursTeam i eHoursUser
	),
	'akcje' => array(
		0 => array(
			'nazwa' => 'akcjaDodajNotatke',
			'tytul' => 'Add note',
			'typ' => 'zapis',
			'opis' => 'Note for {TEAM_NAZWA} ',
			'blokiSzablonu' => array( // blok szablonu przy dodawaniu Eventu
				'dodajNotatke' => array(
						'parametry' => array(),
						/*
						'inputy' => array(
							 'trescNotatki' => array(
									'input' => 'Textarea',
									'filtry' => array(
										 'strval',
										 'trim',
										 'filtr_xss',
									),
									'wymagane' => true,
									'walidatory' => array(
										 'KrotszeOd' => 1000,
									),
							  ),
						*/
						),
			),
			'daneWejsciowe' => array(),
			'daneWyjsciowe' => array( // zwracane przez metode 
				),
			'dataWykonania' => array( // data wykonania metody 
				'liczOd' => 'startKalendarz',
				'dni' => '+ 0 day',
			),
			'konfiguracjaMetody' => array(
				'region' => '', 
			),
			'wymagane' => array(), // metody wymagane do wykonania tej akcji
		),
		1 => array(
			'nazwa' => 'akcjaDaneKalendarza',
			'tytul' => 'General information',
			'typ' => 'zapis',
			'blokiSzablonu' => array( // blok szablonu przy dodawaniu Eventu
				'nazwaWyswietlana' => array(
						'parametry' => array(
							'aktualizujTytul' => '#trescNotatki_Notatki_0',
							'aktulizujPo' => 'focusout',
							'typ' => 'script', // script/tekst 
							'tekst' => '$(\'#trescNotatki_Notatki_0\').val().substring(0, 128)',
						),
					),
				'komentarz' => array(
					'parametry' => array(),
					),
				'kolor' => array(
						'parametry' => array('kolorDomyslny' => '#81c659'),
						),
				),
			'konfiguracjaMetody' => array(
					'region' => 'closed', 
					),
			),
		2 => array(
			'nazwa' => 'akcjaPowiadomienie',
			'typ' => 'cron',
			'tytul' => 'Reminder for team',
			'daneWejsciowe' => array( // dane potrzebne do wykonania metody :  wartość pobierana => nazwaZmiennej
				'idTeam' => 'idTeam',
				'obiektGlowny:id' => 'idNotatki',
				'metoda' => array( // dane wejsciowe zostaną zwrócone z metod akcji 
					//'powiadomUzytkownikSms' => 'powiadomUzytkownikSms', // nazwa inputa z którego ma zostac pobrana wartosc => nazwa metody przetwarzającej wartosc
					//'powiadomUzytkownikEmail' => 'powiadomUzytkownikEmail',
				),
			),
			'daneWyjsciowe' => array(),
			'blokiSzablonu' => array(
				'uzytkownicySelect' => array(
					'wstawZMetody' => array(
							'ustawListeUzytkownikowDoPowiadomienia' => array('domyslnyStartSms' => 'before_start', 'domyslnyStartEmail' => 'before_start', 'domyslnyStartEmail' => 'before_start', 'dniSms' => '5', 'dniEmail' => '5'),						
						), // niestandardowe bloki które wymagają dodatkowego kodu tablica zawiera nazwe metody z akcji powiadomienie
					'parametry' => array(
						'linki' => array(
							'urlSearchUser' => 'ajax:Kalendarz:szukajUzytkownik::admin', // ajax/admin:cel:akcja:parametry:usluga
							),
					),
				),
			),
			'dataWykonania' => array( // data wykonania metody 
				'liczOd' => 'startKalendarz',
				'dni' => '+ 0 day',
			),
			'wymagane' => array(), // wymagane wykonanie metody przydziel Team o kodzie 0
			'konfiguracjaMetody' => array(
				'powiadomienie' => array(
					'grupyUzytkownikow' => array(), // grupa jaka ma zostać przypisana do powiadomienia (lider)
					'uzytkownicy' => array(), // id uzytkownikow do powiadomienia
					'profil' => true, // osoba dodajaca event
				),
				'obiekty' => array( // obiekty przekazywane do szablonu email 'nazwa_z_kontenera' => array( [dane - maper z jakiego bedzie pobierany obiekt], [daneWejsciowe -> z jakiego parametru ma zostac pobrany id obiektu])  )'
					'obiekt_Notes' => array(
						'dane' => 'Notes',
						'daneWejsciowe' => 'idNotatki',
						),
					'obiekt_Team' => array(
						'dane' => 'Team',
						'daneWejsciowe' => 'idTeam',
						),
				),
				'wiadomoscSms' => array(
					'pl' => '{NOTATKA_TRESC}',
					'no' => '{NOTATKA_TRESC}',
					'en' => '{NOTATKA_TRESC}',
				),
				'idSzablonEmail' => 32,
				'region' => 'closed', 
				'zaznaczPowiadomienieSms' => true,
				'zaznaczPowiadomienieEmail' => true,
			),
			'opis' => '{TYP} reminder with Note to user {UZYTKOWNIK_IMIE} {UZYTKOWNIK_NAZWISKO}',
		),
	),
);

?>