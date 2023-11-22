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
		1 => array( 
			'nazwa' => 'akcjaDaneKalendarza', // akcja wymagana dla każdego szablonu
			'tytul' => 'General information', // tytuł akcji
			'typ' => 'zapis', // zapis / cron - zapis służy jedynie do zapisania danych akcja nie bedzie wywoływana w cronie
			'blokiSzablonu' => array( // blok szablonu przy dodawaniu Eventu
				'nazwaWyswietlana' => array( // parsuje blok nazwaWyswietlana z parametrami poniżej
						'parametry' => array(
						),
						),
				'komentarz' => array( // parsuje blok komentarz z parametrami poniżej
					'parametry' => array(),
					),
				'kolor' => array( // parsuje blok nazwaWyswietlana z parametrami poniżej
						'parametry' => array('kolorDomyslny' => '#f8fc9d'), // parametr kolorDomyślny wstawia domyślny kolor dla eventu
						),
				),
			'konfiguracjaMetody' => array(
					'region' => 'closed',
					),
				),
		),
	);

?>