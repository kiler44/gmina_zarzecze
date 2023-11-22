<?php
namespace Generic\Biblioteka\Events;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Szablon as SzablonWidoku;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Zadanie;
use Generic\Model\EventMetody;
use Generic\Biblioteka\Input;
use Exception;

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Metoda
 *
 * @author Marcin
 */
abstract class Metoda extends Szablon{
	
	protected $_konfiguracja;
	protected $_kod;
	private $_idTeam;
	private $_idUser;
	private $_dataStart;
	private $_dataStop;
	private $_obiektGlowny;
	protected $_event;
	private $_daneStartowe = array();
	//protected $_idTeams;
	
	protected $_zamienTekst = array(
		'{TEAM_NAZWA}' => array(
			'obiekt' => 'Team',
			'wlasnosc' => 'teamNumber'
		),
		'{PROJEKT_NAZWA}' => array(
			'obiekt' => 'Zamowienie',
			'wlasnosc' => 'orderName'
		),
		'{NOTATKA_ZAMOWIENIE_NUMER}' => array(
			'obiekt' => 'Notes',
			'wlasnosc' => 'orderNumber'
		),
		'{UZYTKOWNIK_IMIE}' => array(
			'obiekt' => 'Uzytkownik',
			'wlasnosc' => 'imie',
		),
		'{UZYTKOWNIK_NAZWISKO}' => array(
			'obiekt' => 'Uzytkownik',
			'wlasnosc' => 'nazwisko',
		),
		'{DATA_START}' => array(
			'metoda' => 'pobierzDataStart'
		),
		'{DATA_STOP}' => array(
			'metoda' => 'pobierzDataStop'
		),
	);

	public function __construct(\Generic\Model\Event\Obiekt $event, $kod, $daneStartowe = array())
	{
		
		parent::__construct($event->nazwaSzablonu);
		
		$this->_kod = $kod;
		$this->_konfiguracja = $this->pobierzKonfiguracjeAkcji();
		$this->_event = $event;
		//dump($this->_event->nazwa);
		if(count($daneStartowe))
		{
			$this->_daneStartowe = $daneStartowe;
		}
		elseif($event->id)
		{
			$this->ustawDaneStartowe($event->pobierzDateStart(), $event->pobierzDateStop(), $event->pobierzIdTeamu(), $event->pobierzObiektGlowny(), $event->pobierzIdUser());
		}
	}

	abstract public function start(EventMetody\Obiekt $eventMetoda);
	
	abstract public function stop(EventMetody\Obiekt $eventMetoda);
	
	private function ustawIdTeamu($idTeam)
	{
		$this->_idTeam = $idTeam;
	}
	
	private function ustawDaneStartowe($dataStart, $dataStop, $idTeam, $obiektGlowny, $idUser)
	{
		$this->_daneStartowe = array(
			'dataStart' => $dataStart,
			'dataStop' => $dataStop,
			'idTeam' => $idTeam,
			'idUser' => $idUser,
			'obiektGlowny' => $obiektGlowny,
		);
	}

	private function pobierzDataStart()
	{
		if(isset($this->_daneStartowe['dataStart']))
		{
			if($this->_daneStartowe['dataStart'] instanceof \DateTime)
				$this->_daneStartowe['dataStart'] = $this->_daneStartowe['dataStart']->format('d-m-Y');
		}
		else
			trigger_error ('Zmienna dataStart nie została ustawiona', E_USER_ERROR);

		return $this->_daneStartowe['dataStart'];
	}
	
	private function pobierzDataStop()
	{
		if(isset($this->_daneStartowe['dataStop']))
		{
			if($this->_daneStartowe['dataStop'] instanceof \DateTime)
				$this->_daneStartowe['dataStop'] = $this->_daneStartowe['dataStop']->format('d-m-Y');
		}
		else
			trigger_error ('Zmienna dataStop nie została ustawiona', E_USER_ERROR);

		return $this->_daneStartowe['dataStop'];
		
	}
	
	private function pobierzIdUser()
	{
		return (isset($this->_daneStartowe['idUser'])) ? $this->_daneStartowe['idUser'] : trigger_error ('Zmienna idUser nie została ustawiona', E_USER_ERROR);
	}
	
	private function pobierzIdTeam()
	{
		return (isset($this->_daneStartowe['idTeam'])) ? $this->_daneStartowe['idTeam'] : trigger_error ('Zmienna idTeam nie została ustawiona', E_USER_ERROR);
	}

	private function pobierzObiektGlowny()
	{
		return (isset($this->_daneStartowe['obiektGlowny'])) ? $this->_daneStartowe['obiektGlowny'] : trigger_error ('Zmienna obiektGlowny nie została ustawiona', E_USER_ERROR);
	}
	
	public function aktualizuj(EventMetody\Obiekt $eventMetoda, $idTeam, $dataStart, $dataStop, $idUser = null)
	{
		$blad = 0;
		$eventMetoda->wykonany = false;

		if($idUser != null) if(!$this->aktualizujUser($eventMetoda, $idUser)) $blad++;
		if($idTeam) if(!$this->aktualizujTeam($eventMetoda, $idTeam)) $blad++;
		if(!$this->aktualizujDateWykonania($eventMetoda)) $blad++;
		//if(!$this->aktualizujDateWykonania($eventMetoda, $dataStara, $dataNowa)) $blad++;
		
		if(!$this->aktualizujDataStartStop($eventMetoda)) $blad++;
		
		if(method_exists($this, 'aktualizujEventAkcja')){ if(!$this->aktualizujEventAkcja($eventMetoda, $dataStart, $dataStop, $idTeam, $idUser)) $blad++; }
		
		$this->generujOpisMetody($eventMetoda);
		
		return ($blad) ? false : true;
	}

	//protected function aktualizujDataStartStop(EventMetody\Obiekt $eventMetoda, $dataStart, $dataStop)
	protected function aktualizujDataStartStop(EventMetody\Obiekt $eventMetoda)
	{
		$mapperMetody = $this->_cms->dane()->EventMetody();
		
		$daneWejsciowe = $eventMetoda->daneWejsciowe;
		$daneWyjsciowe = $eventMetoda->daneWyjsciowe;
		
		if(isset($daneWejsciowe['dataStart']) && $daneWejsciowe['dataStart'] != '' )
			$daneWejsciowe['dataStart'] = $this->pobierzDataStart();
		if(isset($daneWyjsciowe['dataStart']) && $daneWyjsciowe['dataStart'] != '' )
			$daneWyjsciowe['dataStart'] = $this->pobierzDataStart();
		if(isset($daneWejsciowe['dataStop']) && $daneWejsciowe['dataStop'] != '' )
			$daneWejsciowe['dataStop'] = $this->pobierzDataStop();
		if(isset($daneWyjsciowe['dataStop']) && $daneWyjsciowe['dataStop'] != '' )
			$daneWyjsciowe['dataStop'] = $this->pobierzDataStop();
		
		 $eventMetoda->daneWejsciowe = $daneWejsciowe;
		 $eventMetoda->daneWyjsciowe = $daneWyjsciowe;
		
		return $eventMetoda->zapisz($mapperMetody);
	}
	
	public function aktualizujTeam(EventMetody\Obiekt $eventMetoda, $idTeam)
	{
		$mapperMetody = $this->_cms->dane()->EventMetody();
		if($idTeam == $eventMetoda->daneWejsciowe['idTeam'])
			return true;
			
		if(isset($eventMetoda->daneWejsciowe['idTeam']) && (int)$eventMetoda->daneWejsciowe['idTeam'] > 0 )
		{
			$daneWejsciowe = $eventMetoda->daneWejsciowe;
			$daneWejsciowe['idTeam'] = $idTeam;
			$eventMetoda->daneWejsciowe = $daneWejsciowe;
		}
		
		if(isset($eventMetoda->daneWyjsciowe['idTeam']) && (int)$eventMetoda->daneWyjsciowe['idTeam'] > 0 )
		{
			$daneWyjsciowe = $eventMetoda->daneWyjsciowe;
			$daneWyjsciowe['idTeam'] = $idTeam;
			$eventMetoda->daneWyjsciowe = $daneWyjsciowe;
		}
		$eventMetoda->wykonany = false;
		$eventMetoda->opis = $this->generujOpisMetody($eventMetoda);
		
		return $eventMetoda->zapisz($mapperMetody);
	}
	
	public function aktualizujUser(EventMetody\Obiekt $eventMetoda, $idUser)
	{
		$mapperMetody = $this->_cms->dane()->EventMetody();
		if(isset($eventMetoda->daneWejsciowe['idUser']) && $idUser == $eventMetoda->daneWejsciowe['idUser'])
			return true;
			
		if(isset($eventMetoda->daneWejsciowe['idUser']) && (int)$eventMetoda->daneWejsciowe['idUser'] > 0 )
		{
			$daneWejsciowe = $eventMetoda->daneWejsciowe;
			$daneWejsciowe['idUser'] = $idUser;
			$eventMetoda->daneWejsciowe = $daneWejsciowe;
		}
		
		if(isset($eventMetoda->daneWyjsciowe['idUser']) && (int)$eventMetoda->daneWyjsciowe['idUser'] > 0 )
		{
			$daneWyjsciowe = $eventMetoda->daneWyjsciowe;
			$daneWyjsciowe['idUser'] = $idUser;
			$eventMetoda->daneWyjsciowe = $daneWyjsciowe;
		}
		$eventMetoda->wykonany = false;
		$eventMetoda->opis = $this->generujOpisMetody($eventMetoda);
		
		return $eventMetoda->zapisz($mapperMetody);
	}
	
	//public function aktualizujDateWykonania(EventMetody\Obiekt $eventMetoda, $dataStara, $dataNowa)
	public function aktualizujDateWykonania(EventMetody\Obiekt $eventMetoda)
	{
		$mapperMetody = $this->_cms->dane()->EventMetody();
		/*
		$roznicaData = $this->liczRozniceDat($dataStara, $dataNowa);
		
		if($eventMetoda->dataWykonania == '')
			return true;
		 * 
		 */
		
		/*
		if($roznicaData > 0)
		{
			$dataWykonania = $eventMetoda->dataWykonania->add(new \DateInterval('P'.$roznicaData.'D'));
			$eventMetoda->dataWykonania = $dataWykonania;
		}
		else
		{
			$dataWykonania = $eventMetoda->dataWykonania->sub(new \DateInterval('P'.abs($roznicaData).'D'));
			$eventMetoda->dataWykonania = $dataWykonania;
		}
		 * 
		 */
		
		$dataWykonania = $this->generujDateWykonania($this->pobierzDataStart(), $this->pobierzDataStop(), $this->_konfiguracja['dataWykonania']['liczOd'], $this->_konfiguracja['dataWykonania']['dni']);
		 
		if($dataWykonania != null)
			$eventMetoda->dataWykonania = $dataWykonania;
		
		$daneWejsciowe = $eventMetoda->daneWejsciowe;
		$daneWyjsciowe = $eventMetoda->daneWyjsciowe;
					
		if(isset($eventMetoda->daneWejsciowe['dataWykonania']) && (int)$eventMetoda->daneWejsciowe['dataWykonania'] > 0 && $dataWykonania != null )
			$daneWejsciowe['dataWykonania'] = $dataWykonania->format('d-m-Y');
		if(isset($eventMetoda->daneWyjsciowe['dataWykonania']) && (int)$eventMetoda->daneWyjsciowe['dataWykonania'] > 0 && $dataWykonania != null )
			$daneWyjsciowe['dataWykonania'] = $dataWykonania->format('d-m-Y');
					
		$eventMetoda->daneWejsciowe = $daneWejsciowe;
		$eventMetoda->daneWyjsciowe = $daneWyjsciowe;
		$eventMetoda->opis = $this->generujOpisMetody($eventMetoda);
		
		return $eventMetoda->zapisz($mapperMetody);
	}
	
	private function liczRozniceDat($dataStara, $dataNowa)
	{
		$stara = new \DateTime($dataStara);
		$nowa = new \DateTime($dataNowa);
		$roznicaDat = $stara->diff($nowa, false);
		return $roznicaDat->format("%r%a");
	}
	
	private function error(EventMetody\Obiekt $eventMetoda, $error)
	{
		$errorArray = $eventMetoda->error;
		$mapper = $this->_cms->dane()->EventMetody;
		$bledy = array_merge($errorArray, array(
			'data' => date('d-m-Y H:i'),
			'tekst' => $error,
		));
		$eventMetoda->error = $bledy;
		
		$eventMetoda->zapisz($mapper);
	}

	protected function pobierzKodSzablonu()
	{
		return $this->_nazwaSzablonu.'_'.$this->_kod;
	}
	
	private function pobierzKonfiguracjeAkcji()
	{
		return $this->pobierzKonfiguracjeAkcjiZSzablonu($this->pobierzKlase(), $this->_kod);
	}
	
	protected function pobierzOpisZSzablonu(\Generic\Model\EventMetody\Obiekt $eventMetody = null)
	{
		if($eventMetody != null)
			return $eventMetody->konfiguracjaSzablon['opis'];
		else
			return $this->_konfiguracja['opis'];
	}

	protected function pobierzBlokiWidoku()
	{
		$konfiguracjaSzablonu = array();
		if(isset($this->_konfiguracja['blokiSzablonu']))
			$konfiguracjaSzablonu = $this->_konfiguracja['blokiSzablonu'];
		else
			trigger_error ('Bloki dla akcji '.$this->pobierzKlase ().' nie istnieje', E_USER_ERROR);
		
		return $konfiguracjaSzablonu;
	}
	
	protected function pobierzKonfiguracjeMetody()
	{
		$konfiguracjaMetody = array();
		if(isset($this->_konfiguracja['konfiguracjaMetody']))
			$konfiguracjaMetody = $this->_konfiguracja['konfiguracjaMetody'];
		else
			trigger_error ('Konfiguracja dla akcji '.$this->pobierzKlase ().' nie istnieje', E_USER_ERROR);
		
		return $konfiguracjaMetody;
	}
	
	protected function ladujWidok()
	{
		$szablon = SZABLON_KATALOG.'/events/'.$this->pobierzKlase().'.tpl';
		$szablonTresc = Plik::pobierzTrescPliku($szablon);
		$widok = new SzablonWidoku();
		$widok->ladujTresc($szablonTresc);
		
		return $widok;
	}

	protected function pobierzKlase()
	{
		$paramNazwyKlasy = explode('\\', get_called_class());
		return $paramNazwyKlasy[count($paramNazwyKlasy)-1];
	}
	
	protected function parsujParametryWidoku($parametry)
	{
		$parametryTab = array();
		
		foreach($parametry as $klucz => $parametr)
		{
			if($klucz == 'linki')
			{
				foreach($parametr as $nazwa => $link)
				{
					$parametryTab[$nazwa] = $this->generujLink($link);
				}
			}
			else
			{
				$parametryTab[$klucz] = $parametr;
			}
		}
		
		return $parametryTab;
	}
	
	private function generujLink($parametryRouter)
	{
		$kategorieMapper = $this->_cms->dane()->Kategoria();
			
		list($czyAjax, $cel, $akcja, $parametry, $usluga) = explode(':', $parametryRouter);

		$parametryUrl = array();
		
		if($parametry != '')
		{
			 $listaParametrow = explode('|', $parametry);
			 if(count($listaParametrow))
			 {
				 foreach($listaParametrow as $parametr)
				{
					list($klucz, $wartosc) = explode('=', $parametr);
					$parametryUrl[$klucz] = $wartosc;
				}
			 }
		}

		$cel = $kategorieMapper->pobierzDlaModulu($cel)[0];
		
		if($czyAjax == 'ajax')
		{
			return Router::urlAjax($usluga, $cel, $akcja, $parametryUrl);
		}
		else
		{
			return Router::urlAdmin($cel, $akcja, $parametryUrl);
		}
	}
	
	protected function pobierzIdTeamow($dataTeam)
	{
		return array_keys($dataTeam);
	}

	protected function pobierzDatyDlaIdTeam($dataTeam, $idTeam)
	{
		return $dataTeam[$idTeam];
	}
	
	private function pobierzInput($nazwa, $daneInputa, $wartosc = '')
	{
		$input = '\\Generic\Biblioteka\Input\\'.$daneInputa['input'];
		
		if($wartosc == ''){ $wartosc = (isset($daneInputa['wartosc'])) ? $daneInputa['wartosc'] : '';  }
			
		$podstawowe = array('wartosc' => $wartosc ,'wymagany' => (isset($daneInputa['wymagany']) && $daneInputa['wymagany']) ? true : false);
      $dodatkowe = (isset($daneInputa['parametry']) && !empty($daneInputa['parametry'])) ? $daneInputa['parametry'] : array();
      $konfiguracja = array_merge($podstawowe, $dodatkowe);
				
		
		/* var Input $inputObiekt */
		$inputObiekt = new $input($nazwa, $konfiguracja, $daneInputa['etykieta'], $daneInputa['opis']);
		return $inputObiekt;
	}
	
	/**
	 * 
	 * @param array $dataTeam - [idTeam][daty]
	 * @return string - html
	 */
	public function budujWidok($dataTeam)
	{
		$blokiSzablonu = $this->pobierzBlokiWidoku();
		$widok = $this->ladujWidok();
		$html = '';
		//dump($dataTeam);
		foreach($blokiSzablonu as $blok => $dane)
		{
			// wstawiamy bloki z metod Eventow
			if($blok == 'wstawZMetody')
			{
				foreach($dane as $akcja => $parametry)
				{
					$akcja = $akcja.'Widok';
					if(method_exists($this, $akcja))
						$widok = $this->$akcja($widok, $parametry, $dataTeam);
				}
				continue;
			}
			
			// ustawiamy bloki widoku z parametrami
			$parametry = (isset($dane['parametry'])) ? $this->parsujParametryWidoku($dane['parametry']) : array() ;
			$daneWidok = array_merge( array('kod' => $this->pobierzKodSzablonu()) , $parametry );
			
			if(isset($dane['inputy']) && count($dane['inputy']))
			{
				$inputy = array();
				foreach($dane['inputy'] as $nazwa => $daneInputa)
				{
					$inputy[$nazwa] = $this->pobierzInput($nazwa, $daneInputa)->pobierzHtml();
				}
				$daneWidok = array_merge($daneWidok, $inputy);
			}
			dump($blok);
			$widok->ustawBlok('index/'.$blok, $daneWidok);
			
			// wstawiamy bloki z metod Eventow zagnierzczone w wyzej ustawionym bloku
			if(isset($dane['wstawZMetody']))
			{
				foreach($dane['wstawZMetody'] as $akcja => $parametry)
				{
					$akcja = $akcja.'Widok';
					if(method_exists($this, $akcja))
						$widok = $this->$akcja($widok, $parametry, $dataTeam);
				}
			}
		}
		
		return $widok->parsujBlok('index', array(
				'tytul' => isset($this->_konfiguracja['tytul']) ? $this->_konfiguracja['tytul'] : '',
				'kod' => $this->pobierzKodSzablonu(),
				'wyswietlajRegion' => $this->_konfiguracja['konfiguracjaMetody']['region'],
				'szablon' => $this->_nazwaSzablonu,
			));
	}
	
	private function pobierzIdyWymaganejMetody($idEvent, $wymagane)
	{
		preg_match('/(akcja)([a-zA-Z0-9]+)(\()([0-9])(\))/', $wymagane, $matches);
		if($this->akcjaIstnieje('akcja'.$matches[2], $matches[4]))
		{
			$kryteria = array('id_event' => $idEvent, );
			$maperEventMetoda = $this->_cms->dane()->EventMetody();
			$event = $maperEventMetoda->szukaj(array('id_event' => $idEvent, 'kod' => $matches[4], 'akcja' => $matches[2]));
			return $event[0]->id;
		}
		else 
		{
			throw new Exception('Brak wymaganej akcji '.$matches[2].' o kodzie '.$matches[4].' w szablonie '.$this->_nazwaSzablonu.' ', E_ERROR);
		}
	}
	
	protected function pobierzMetodyWymagane($idEvent, $idMetoda)
	{
		$maperEventMetoda = $this->_cms->dane()->EventMetody();
		$event = $maperEventMetoda->szukaj(array('id_event' => $idEvent, 'id_wymagane' => $idMetoda));
		
		return $event;
	}
	/**
	 * 
	 * @param \Generic\Model\Event\Obiekt $event
	 * @param type $idTeam
	 * @param type $idUser
	 * @param type $dataStart
	 * @param type $dataStop
	 * @param type $daneDataTeam
	 * @return boolean
	 */
	public function zapisz(\Generic\Model\Event\Obiekt $event, $idTeam, $idUser, $dataStart, $dataStop, $daneDataTeam)
	{
		$obiektGlowny = $event->pobierzObiektGlowny();
		$this->ustawDaneStartowe($dataStart, $dataStop, $idTeam, $obiektGlowny, $idUser);
		$idEvent = $event->id;
				  
		if(isset($this->_konfiguracja['typ']))
		{
			if( $this->_konfiguracja['typ'] == 'cron')
			{
				$maperEventMetoda = $this->_cms->dane()->EventMetody();
				
				$eventMetoda = new EventMetody\Obiekt();
				$eventMetoda->idEvent = $idEvent;
				$eventMetoda->akcja = $this->pobierzKlase();
				$eventMetoda->konfiguracjaSzablon = $this->_konfiguracja;
				$eventMetoda->konfiguracja = $this->pobierzKonfiguracjeMetody();

				$daneWejsciowe = array();
				foreach($this->_konfiguracja['daneWejsciowe'] as $input => $nazwa)
				{
					// dane wejsciowe zdefiniowane 
					if($nazwa == 'idTeam'){ $daneWejsciowe[$nazwa] = $idTeam; continue; }
					if($nazwa == 'idUser'){ $daneWejsciowe[$nazwa] = $idUser; continue; }
					if($nazwa == 'dataStart'){ $daneWejsciowe[$nazwa] = $dataStart; continue; }
					if($nazwa == 'dataStop'){ $daneWejsciowe[$nazwa] = $dataStop; continue; }
					
					/* metody wywoływane w danej akcji
					 * 'metoda' => array( // nazwa inputa z którego ma zostac pobrana wartosc => nazwa metody przetwarzającej wartosc
							'powiadomUzytkownikSms' => 'powiadomUzytkownikSms', 
							'powiadomUzytkownikEmail' => 'powiadomUzytkownikEmail',
						),
					 */
					
					if($input == 'metoda')
					{
						/*
						if(!count($nazwa)) continue;
							
						foreach($nazwa as $nazwaInputa => $nazwaMetody)
						{
							$nazwaMetody = $nazwaMetody.'Zapisz';
							$daneWejsciowe[$nazwaInputa] = $this->$nazwaMetody(Zadanie::pobierz('daneForm'), $idTeam, $idUser, $daneDataTeam);
						}
						 * 
						 */
						continue;
					}
					
					
					/**
					 *  dane wejsciowe pochodzace z własnosci obiektow powiazanych
					 * 'obiektGlowny:id' => 'idNotatki', 
					 */
					if(strpos($input, ':') != FALSE)
					{
						list($obiekt, $wlasnosc) = explode(':', $input);
						$daneWejsciowe[$nazwa] = $obiektGlowny->$wlasnosc;
						continue;
					}
					// dane wejsciowe pochodzace z formularza
					$daneWejsciowe[$nazwa] = isset(Zadanie::pobierz('daneForm')[$input]) ? Zadanie::pobierz('daneForm')[$input] : $input;
				}
				
				$eventMetoda->daneWejsciowe = $daneWejsciowe;
				$eventMetoda->daneWyjsciowe = $this->_konfiguracja['daneWyjsciowe'];
				$eventMetoda->kod = $this->_kod;
				$eventMetoda->szablon = $this->_nazwaSzablonu;
				
				// zapisujemy metody wymagane do wykonania bierzacej metody
				if(isset($this->_konfiguracja['wymagane']))
				{
					$wymaganeArray = array();
					foreach($this->_konfiguracja['wymagane'] as $wymagane)
						$wymaganeArray[] = $this->pobierzIdyWymaganejMetody($idEvent, $wymagane);
					
					$eventMetoda->idWymagane = '|'.implode('|', $wymaganeArray).'|';
				}
				
				if(method_exists($this, 'zapiszEventAkcja'))
				{
					return $this->zapiszEventAkcja($idTeam, $idUser, $dataStart, $dataStop, $daneDataTeam, Zadanie::pobierz('daneForm'), $eventMetoda);
				}
				
				// zapisujemy date wykonania metody
				$dataWykonania = $this->generujDateWykonania($dataStart, $dataStop, $this->_konfiguracja['dataWykonania']['liczOd'], $this->_konfiguracja['dataWykonania']['dni']);
				
				if($dataWykonania != null)
				{
					$eventMetoda->dataWykonania = $dataWykonania;
				}
				
				if(!isset($this->_konfiguracja['wymagane']) || count($this->_konfiguracja['wymagane']) == 0)
					$eventMetoda->opis = $this->generujOpisMetody($eventMetoda);
				
				return $eventMetoda->zapisz($maperEventMetoda);
			}
			else
			{
				if(method_exists($this, 'zapiszEventAkcja'))
				{
					//$idTeam, $idUser, $dataStart, $dataStop, $daneDataTeam
					return $this->zapiszEventAkcja($idTeam, $idUser, $dataStart, $dataStop, $daneDataTeam, Zadanie::pobierz('daneForm'), null);
				}
			}
		}
		
		return true;
	}
	
	public function generujOpisMetody(\Generic\Model\EventMetody\Obiekt $eventMetody)
	{
		$obiektyPowiazane = $this->pobierzObiektyPowiazane($eventMetody);
		$opis = $this->pobierzOpisZSzablonu($eventMetody);
		
		foreach($this->_zamienTekst as $znajdz => $dane)
		{
			if(isset($dane['obiekt']) && isset($obiektyPowiazane[$dane['obiekt']]))
			{
				$opis = str_replace($znajdz, $obiektyPowiazane[$dane['obiekt']]->$dane['wlasnosc'], $opis);
			}
			elseif(isset($dane['metoda']) && $dane['metoda'] != '')
			{
				$opis = str_replace($znajdz, $this->$dane['metoda']() , $opis);
			}
		}
		return $opis;
	}
	
	protected function pobierzObiektyPowiazane(\Generic\Model\EventMetody\Obiekt $eventMetody)
	{
		$obiekty = array();
		if(!isset($eventMetody->konfiguracjaSzablon['obiektyPowiazane'])) return $obiekty;
			
		foreach($eventMetody->konfiguracjaSzablon['obiektyPowiazane'] as $obiekt => $dane)
		{
			if(isset($dane['daneWejsciowe']))
			{
				if(strpos($dane['daneWejsciowe'], 'metoda:') !== FALSE)
				{
					list($metoda, $nazwaMetody, $parametryMetody) = explode(':', $dane['daneWejsciowe']);
					$id = $this->$nazwaMetody($eventMetody, $parametryMetody);
				}
				else
				{
					$id = $eventMetody->daneWejsciowe[$dane['daneWejsciowe']];
				}
			}
			else
			{
				switch($dane)
				{
					case 'idTeam' :  $id = $this->pobierzIdTeam();
						break;
					case 'idUser' : $id = $this->pobierzIdUser();
						break;
					case 'obiektGlowny' : $id = $this->pobierzObiektGlowny()->id;
						break;
				}
			}
			
			$obiektO = $this->_cms->dane()->$obiekt()->pobierzPoId($id);
			$obiekty[$obiekt] = $obiektO;
		}
		
		return $obiekty;
	}

	/**
	 * 
	 * @param type $dataStart
	 * @param type $dataStop
	 * @param type $liczOd
	 * @param type $dni
	 * @return type
	 */
	protected function generujDateWykonania($dataStart, $dataStop, $liczOd, $dni)
	{
		$data = null;
	
		switch($liczOd)
		{
			case 'startKalendarz' : $data = $this->liczDateWykonania($dataStart, $dni);
				break;
			case 'stopKalendarz' : $data = $this->liczDateWykonania($dataStop, $dni);
				break;
			case 'before_start' : $data = $this->liczDateWykonania($dataStart, ' - '.$dni.' day');
				break;
			case 'in_start' : $data = $this->liczDateWykonania($dataStart, ' + 0 day');
				break;
			case 'after_start' : $data = $this->liczDateWykonania($dataStart, ' + '.$dni.' day');
				break;
			case 'before_end' : $data = $this->liczDateWykonania($dataStop, ' - '.$dni.' day');
				break;
			case 'in_end' : $data = $this->liczDateWykonania($dataStop, '+ 0 day');
				break;
			case 'after_end' : $data = $this->liczDateWykonania($dataStop, ' + '.$dni.' day' );
				break;
			default : $date = null;
		}
		
		return $data;
	}
	
	protected function liczDateWykonania($dataWykonania, $dodajDni)
	{
		return new \DateTime(date('Y-m-d', strtotime($dataWykonania.' '.$dodajDni)));
	}
	
	protected function aktualizujDaneWejscioweMetodWymaganych(EventMetody\Obiekt $eventMetoda)
	{
		$metodyPowiazane = $this->pobierzMetodyWymagane($eventMetoda->idEvent, $eventMetoda->id);
		$maperMetody = $this->_cms->dane()->EventMetody();
		
		foreach($metodyPowiazane as $akcja)
		{
			if($akcja->dataWykonania == '')
			{
				if($akcja->konfiguracjaSzablon['dataWykonania']['liczOd'] == 'akcja'.$this->pobierzKlase())
				{
					$akcja->dataWykonania = $this->liczDateWykonania($eventMetoda->dataWykonania->format('Y-m-d H:i:s') , $akcja->konfiguracjaSzablon['dataWykonania']['dni']);
				}
			}
			
			foreach($eventMetoda->daneWyjsciowe as $zmiennaWyjsciowa => $wartoscWyjsciowa)
			{
				foreach($akcja->daneWejsciowe as $zmiennaWejsciowa => $wartoscWejsciowa)
				{
					if($wartoscWejsciowa == 'akcja'.$this->pobierzKlase().'.'.$zmiennaWyjsciowa)
					{
						$daneWejsciowe = $akcja->daneWejsciowe;
						$daneWejsciowe[$zmiennaWejsciowa] = $wartoscWyjsciowa;
						$akcja->daneWejsciowe = $daneWejsciowe;
					}
				}
			}
			$akcja->opis = $this->generujOpisMetody($akcja);
			$akcja->zapisz($maperMetody);
		}
	}
	
	protected function zamknijEvent(EventMetody\Obiekt $eventMetoda)
	{
		$maperEvent = $this->_cms->dane()->EventMetody();
		$eventMetoda->wykonany = true;
		$eventMetoda->zapisz($maperEvent);
		
		$event = $eventMetoda->pobierzEvent();
		if($event instanceof \Generic\Model\Event\Obiekt)
		{
			$wszystkieMetodyEventu = $event->pobierzMetody();
			$eventyWykonane = true;
			foreach ($wszystkieMetodyEventu as $eventM)
			{
				if(!$eventM->wykonany) $eventyWykonane = false;
			}
			if($eventyWykonane)
			{
				$maperEvent = new \Generic\Model\Event\Mapper();
				$event->wykonany = true;
				$event->zapisz($maperEvent);
			}
		}
	}
	
		
}
