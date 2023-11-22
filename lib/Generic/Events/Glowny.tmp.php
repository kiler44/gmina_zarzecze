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
		
		'nazwa' => 'akcjaNazwa', // nazwa akcji akcja+Nazwa
		'tytul' => 'Tytuł akcji', // tytuł akcji
		'typ' => 'cron', // zapis / cron - zapis służy jedynie do zapisania danych akcja nie bedzie wywoływana w cronie
		'blokiSzablonu' => array( // bloki szablonu zawsze parsowany jest blok index
				'wstawBloki' => array( 'nazwaMetody' => array() ), // nazwa metody parsującej jakiś blok metoda znajduje się w pliku Event/Metody/akcjaNazwa => parametry przekazane do metody
				'uzytkownicySelect' => array( // parsuje blok usytkownicySelect $this->szablon->ustawBlok(/index/uzytkownicySelect, $parametry) $parametry - dane przekazywane do szablonu
					'wstawBloki' => array( // nazwa metody parsującej jakiś blok metoda znajduje się w pliku Event/Metody/akcjaNazwa => parametry przekazane do metody
											'ustawListeUzytkownikowDoPowiadomienia' => array('domyslnyStartSms' => 'before_start', 'domyslnyStartEmail' => 'before_start', 'dniSms' => '5', 'dniEmail' => '5'),
										), 
					'parametry' => array( // parametry przekazywane do szablonu
						'linki' => array( // link zostanie wygenerowany link Router::(ajax/admin:cel:akcja:parametry:usluga)
							'urlSearchUser' => 'ajax:Kalendarz:szukajUzytkownik::admin', // ajax/admin:cel:akcja:parametry:usluga
							),
					),
				),
			),
		
	), 
		
	);

?>