<?php
return $konfiguracja = array(
	'nazwa' => 'Project',
	'opis' => 'Assign project to team and send message',
	'konfiguracjaPodstawowa' => array(
		'typObiektu' => 'Zamowienie', // typ obiektu głównego
		'idObiektu' => 'zamowienieInput', // id pobieranie z wygenerowanego formularza
		'wyswietlajWMenu' => true,
		'typWyswietlania' => 'eTeam', // eTeam , eUser, moze eHoursTeam i eHoursUser
	),
	'akcje' => array(
		0 => array(
			'nazwa' => 'akcjaPrzydzielTeam', // nazwa metody
			'tytul' => 'Assign team to project', // tytuł metody wyswietlany w widoku
			'typ' => 'cron',
			'obiektyPowiazane' => array(
				'Team' => array('daneWejsciowe' => 'idTeam',),
				'Zamowienie' => array('daneWejsciowe' => 'idProjektu',),	
			),
			'opis' => 'Assign team {TEAM_NAZWA} to project {PROJEKT_NAZWA}', // opis metody
			'blokiSzablonu' => array( // blok szablonu przy dodawaniu Eventu
				'szukajZamowienia' => array(
						'parametry' => array(
							'linki' => array(
								'urlSzukajZamowienie' => 'ajax:Kalendarz:szukajZamowienie:type=4:admin', // ajax/admin:cel:akcja:parametry:usluga
							),
						)
				),
			),
			'daneWejsciowe' => array( // dane potrzebne do wykonania metody
				'idTeam' => 'idTeam', // id przydzielanego teamu
				'zamowienieInput' => 'idProjektu', // id przydzielanego projektu 
			),
			'daneWyjsciowe' => array( // zwracane przez metode
				'dataWykonania' => 'dataWykonania',
			),
			'dataWykonania' => array( // data wykonania metody
				'liczOd' => 'startKalendarz',
				'dni' => '- 7 day',
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
				'nazwaWyswietlana' => array( 'parametry' => array(), ),
				'komentarz' => array( 'parametry' => array(), ),
				'kolor' => array( 'parametry' => array('kolorDomyslny' => '#f8fc9d'), ),
				'wstawZMetody' => array('ustawDataStartStopTeam' => array() ),
				),
			'konfiguracjaMetody' => array(
					'region' => 'closed', 
					),
			'daneWejsciowe' => array(),
			'daneWyjsciowe' => array(),
			'dataWykonania' => array( // data wykonania metody 
				'liczOd' => 'startKalendarz',
				'dni' => '+ 0 day',
			),
				),
		2 => array(
			'nazwa' => 'akcjaPowiadomienie', // nazwa metody
			'typ' => 'cron',
			'tytul' => 'Reminder for team',
			'blokiSzablonu' => array(
				'uzytkownicySelect' => array(
					'wstawZMetody' => array( // niestandardowe bloki które wymagają dodatkowego kodu tablica zawiera nazwe metody w pliku Event/Metody/Powiadomienie
											'ustawListeUzytkownikowDoPowiadomienia' => array('domyslnyStartSms' => 'before_start', 'domyslnyStartEmail' => 'before_start', 'dniSms' => '5', 'dniEmail' => '5'),
										), 
					'parametry' => array(
						'linki' => array(
							'urlSearchUser' => 'ajax:Kalendarz:szukajUzytkownik::admin', // ajax/admin:cel:akcja:parametry:usluga
							),
					),
				),
			),
			'wymagane' => array('akcjaPrzydzielTeam(0)'), // akcje które muszą zostać wykonane przed wykonaniem tej akcji
			'daneWejsciowe' => array( // dane potrzebne do wykonania akcji :  input z któego zostanie pobrana wartość => nazwaZmiennej do której zostanie wartosc przypisana
				'idTeam' => 'idTeam',
				'zamowienieInput' => 'idProjektu', // id przydzielanego projektu
				'akcjaPrzydzielTeam.dataWykonania' => 'dataWykonania', // dane zostaną pobrane z akcji Przydziel team dataWykonania i przypisane do zmiennej dataWykonania
				'metoda' => array( // dane wejsciowe zostaną zwrócone z metod akcji z pliku Event/Metody/Powiadomienie
					//'powiadomUzytkownikSms' => 'powiadomUzytkownikSms', // nazwa inputa z którego ma zostac pobrana wartosc => nazwa metody przetwarzającej wartosc
					//'powiadomUzytkownikEmail' => 'powiadomUzytkownikEmail', // nazwa inputa z którego ma zostac pobrana wartosc => nazwa metody przetwarzającej wartosc
				),
			),
			'daneWyjsciowe' => array(	), //dane wyjściowe akcji
			'dataWykonania' => array( // data wykonania metody 
				'liczOd' => 'akcjaPrzydzielTeam',
				'dni' => '+ 1 day',
			),
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
				'idSzablonEmail' => 39,
				'region' => 'closed', 
				'zaznaczPowiadomienieSms' => true,
				'zaznaczPowiadomienieEmail' => true,
			),
			'obiektyPowiazane' => array(
				'Team' => array('daneWejsciowe' => 'idTeam',),
				'Zamowienie' => array('daneWejsciowe' => 'idProjektu',),				
			),
			'opis' => 'Send message to team {TEAM_NAZWA} with project assign information {PROJEKT_NAZWA}',
		),
	),
);

?>