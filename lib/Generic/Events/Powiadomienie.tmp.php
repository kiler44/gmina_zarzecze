<?php
return $konfiguracja = array(
	'nazwa' => 'Project', // nazwa szablonu wyświetlana w menu
	'opis' => 'Assign project to team and send message', // opis szablonu
	'konfiguracjaPodstawowa' => array(
		'typObiektu' => 'Zamowienie', // typ obiektu głównego
		'idObiektu' => 'zamowienieInput', // id obiektu głównego pobierane z formularza
		'wyswietlajWMenu' => true, //szablon bedzie wyswietlany w menu
		'typWyswietlania' => 'eTeam', // eTeam , eUser, czy event ma byc dla uzytkownika czy teamu
	),
	'akcje' => array( // akcje Eventu
		2 => array(
			'nazwa' => 'akcjaPowiadomienie', // nazwa metody
			'typ' => 'cron',
			'tytul' => 'Reminder for team',
			'blokiSzablonu' => array(
				'uzytkownicySelect' => array(
					'wstawBloki' => array( // niestandardowe bloki które wymagają dodatkowego kodu tablica zawiera nazwe metody w pliku Event/Metody/Powiadomienie
											'ustawListeUzytkownikowDoPowiadomienia' => array('domyslnyStartSms' => 'before_start', 'domyslnyStartEmail' => 'before_start', 'dniSms' => '5', 'dniEmail' => '5'),
										), 
					'parametry' => array(
						'linki' => array(
							'urlSearchUser' => 'ajax:Kalendarz:szukajUzytkownik::admin', // ajax/admin:cel:akcja:parametry:usluga
							),
					),
				),
			),
			'daneWejsciowe' => array( // dane potrzebne do wykonania metody :  wartość pobierana => nazwaZmiennej
				'idTeam' => 'idTeam',
				'zamowienieInput' => 'idProjektu', // id przydzielanego projektu
				'akcjaPrzydzielTeam.dataWykonania' => 'dataWykonania',
				'metoda' => array( // dane wejsciowe zostaną zwrócone z metod akcji 
					'powiadomUzytkownikSms' => 'powiadomUzytkownikSms', // nazwa inputa z którego ma zostac pobrana wartosc => nazwa metody przetwarzającej wartosc
					'powiadomUzytkownikEmail' => 'powiadomUzytkownikEmail',
				),
			),
			'daneWyjsciowe' => array(	),
			'dataWykonania' => array( // data wykonania metody 
				'liczOd' => 'akcjaPrzydzielTeam',
				'dni' => '+ 1 day',
			),
			'wymagane' => array('akcjaPrzydzielTeam(0)'), // wymagane wykonanie metody przydziel Team o kodzie 0
			'konfiguracjaMetody' => array(
				'powiadomienie' => array(
					'grupyUzytkownikow' => array('lider'), // grupa jaka ma zostać przypisana do powiadomienia (lider)
					'uzytkownicy' => array(), // id uzytkownikow do powiadomienia
					'profil' => false, // osoba dodajaca event
				),
				'obiekty' => array( // obiekty przekazywane do szablonu email 'nazwa_z_kontenera' => array( [dane - maper z jakiego bedzie pobierany obiekt], [daneWejsciowe -> z jakiego parametru ma zostac pobrany id obiektu])  )'
					'obiekt_Zamowienie' => array(
						'dane' => 'Zamowienie',
						'daneWejsciowe' => 'idProjektu',
						),
					'obiekt_NowyTeam' => array(
						'dane' => 'Team',
						'daneWejsciowe' => 'idTeam',
						),
				),
				'wiadomoscSms' => array(
					'pl' => 'Ekipie {TEAM_NAME} zostal przydzielony nowy projekt {ZAMOWIENIE_NAZWA}. Zaloguj sie do systemu zeby zobaczyc aktualne przydzielenia.',
					'no' => 'Your team {TEAM_NAME} have a new project assigned {ZAMOWIENIE_NAZWA}. Log in to the BTK CRM system to check the assigned tasks.',
					'en' => 'Your team {TEAM_NAME} have a new project assigned {ZAMOWIENIE_NAZWA}. Log in to the BTK CRM system to check the assigned tasks.',
				),
				'idSzablonEmail' => 8,
				'region' => 'closed', 
				'zaznaczPowiadomienieSms' => true,
				'zaznaczPowiadomienieEmail' => true,
			),
			'obiektyPowiazane' => array(
				'Team' => array('daneWejsciowe' => 'idTeam',),
				'Zamowienie' => array('daneWejsciowe' => 'idProjektu',),				
			),
			'opis' => 'Send email message to team {TEAM_NAZWA} with project assign information {PROJEKT_NAZWA}',
		),
	),
	);

?>