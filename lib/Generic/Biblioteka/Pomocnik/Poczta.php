<?php
namespace Generic\Biblioteka\Pomocnik;
use Generic\Biblioteka\{
    Cms,
    Kontener,
    Szablon,
    Plik
};
use Generic\Model\{
    EmailFormatka,
    EmailWpisKolejki,
    EmailSzablon,
    Uzytkownik
};
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


/**
 * Klasa odpowiedzialna za obsługę poczty korzystajaca z PHPMailer
 *
 * @author Krzysztof Lesiczka, Marcin Mucha
 * @package biblioteki
 */

class Poczta
{
	use MetodaWysylaniaZalacznikowTrait;

	/**
	 * Tablica z ustawieniami dotyczacymi wysylania wiadomosci email, zastępuja one dane zawarte w formatce
	 * @var Array
	 */
	protected $ustawienia = array(
		'typWysylania' => 'natychmiast',
		'przygotujWiadomosc' => true,
		'zapiszStanWKolejce' => true,
		'emailNadawcaEmail' => '',
		'emailNadawcaNazwa' => '',
		'emailPotwierdzenieEmail' => '',
		'emailOdbiorcy' => array(),
		'emailKopie' => array(),
		'emailKopieUkryte' => array(),
		'emailOdpowiedzi' => array(),
		'emailTytul' => '',
		'emailTrescHtml' => '',
		'emailTrescTxt' => '',
		'emailZalaczniki' => array(),
		'emailZalacznikiKatalog' => '',
		'emailSzablon' => 0,
	);


	/**
	 * Tablica z danymi do sparsowania w tytule i tresci wiadomosci email
	 * @var Array
	 */
	protected $dane = array();


	/**
	 * Obiekt formatki na podstawie ktorego wysylamy wiadoamosc
	 * @var EmailFormatka
	 */
	protected $formatka = null;


	/**
	 * Lista odbiorcow dla logow w zapisie tekstowym
	 * @var string
	 */
	protected $odbiorcyLog = '';


	/**
	 * Informacje klasy wysyłającej emaile
	 * @var string
	 */
	protected $debug = '';


	/**
	 * Kontener przetrzymujacy obiekty powiazane z wizytowka
	 * @var Kontener_WizytowkaObiekty
	 */
	protected $kontener;




	private $szablonZalacznikiUrl = '<ul>{{BEGIN pozycja}}<li><a href="{{$link}}">{{$etykieta}}</a></li>{{END pozycja}}</ul>';

	/**
	 *
	 * @var array
	 */
	protected $obiektyOdbiorcow = [];

	public function __construct($idFormatki = null, Array $dane = array())
	{
		$this->kontener = new Kontener\WizytowkaObiekty;
		if ($idFormatki !== null)
		{
			$formatka = Cms::inst()->dane()->EmailFormatka()->pobierzPoId((int)$idFormatki);
			if ($formatka instanceof EmailFormatka\Obiekt)
			{
				$this->wczytajFormatke($formatka);
			}
			else
			{
				throw new PocztaWyjatek('Nie mozna wczytac formatki email o identyfikatorze '.$idFormatki, E_USER_ERROR);
			}
		}
		if (count($dane) > 0)
		{
			$this->wczytajDane($dane);
		}
	}



	/**
	 * Zwraca tablice w formie:
	 *  '{ETYKIETA_ODBIORCY}' => array('EtykietaObiektuZKontenera', 'poleObiektu')
	 *
	 * @return Array
	 */
	public static function predefiniowaniOdbiorcy()
	{
		return array(
			'{KLIENT_WYSLIJ_FAKTURA}' => array('Klient', 'email'),
			'{KLIENT_OSOBA_KONTAKTOWA}' => array('KlientOsobaKontaktowa', 'email'),
			'{KLIENT}' => array('Uzytkownik', 'email'),
			'{KLIENT_FAKTURA}' => array('Uzytkownik', 'email'),
			'{KIEROWNIK_PROJEKTU_GET}' => array('Uzytkownik', 'email'),
			'{KOORDYNATOR_BKT}' => array('NowyKoordynator', 'email'),
			'{KOORDYNATOR_BKT_STARY}' => array('StaryKoordynator', 'email'),
			'{NADAWCA_WIADOMOSCI}' => array('Nadawca', 'email'),
			'{ODBIORCA_WIADOMOSCI}' => array('Odbiorca', 'email'),
			'{TEAM}' => array('Team', 'email'),
			'{NEW_TEAM}' => array('NowyTeam', 'email'),
			'{PREVIOUS_TEAM}' => array('StaryTeam', 'email'),
			'{UZYTKOWNIK}' => array('Uzytkownik', 'email'),
			'{OPIEKUN_MAGAZYNU}' => array('OpiekunMagazynu', 'email'),
		);
	}



	/**
	 * Wczytuje formatke zawierajaca ustawienia potrzebne do ustawiania maila
	 * @param EmailFormatka $formatka
	 */
	public function wczytajFormatke(EmailFormatka\Obiekt $formatka)
	{
		$this->formatka = $formatka;
		foreach ($formatka as $pole => $wartosc)
		{
			if (array_key_exists($pole, $this->ustawienia))
				$this->ustawienia[$pole] = $formatka->$pole;
		}
		if ($this->ustawienia['typWysylania'] == 'cron')
		{
			$this->ustawienia['zapiszStanWKolejce'] = true;
		}

		$this->ustawienia['emailZalacznikiKatalog'] =  Cms::inst()->katalog('email_zalaczniki', $formatka->id);
	}



	/**
	 * Wczytuje ustawienia dotyczace wysylania wiadomosci email, zastępuja one dane zawarte w formatce
	 * @param array $ustawienia
	 */
	public function wczytajUstawienia(Array $ustawienia)
	{
		$this->ustawienia = array_replace($this->ustawienia, $ustawienia);
	}



	/**
	 * Buduje tablicę ustawień na podstawie wpisu kolejki
	 * @param EmailWpisKolejki $wpis
	 * @return array
	 */
	public static function przygotujUstawieniaDlaWpisu(EmailWpisKolejki\Obiekt $wpis)
	{
		return array(
			'typWysylania' => 'natychmiast',
			'przygotujWiadomosc' => false,
			'zapiszStanWKolejce' => false,
			'emailNadawcaEmail' => $wpis->emailNadawcaEmail,
			'emailNadawcaNazwa' => $wpis->emailNadawcaNazwa,
			'emailPotwierdzenieEmail' => $wpis->emailPotwierdzenieEmail,
			'emailOdbiorcy' => $wpis->emailOdbiorcy,
			'emailKopie' => $wpis->emailKopie,
			'emailKopieUkryte' => $wpis->emailKopieUkryte,
			'emailOdpowiedzi' => $wpis->emailOdpowiedzi,
			'emailTytul' => $wpis->emailTytul,
			'emailTrescHtml' => $wpis->emailTrescHtml,
			'emailTrescTxt' => $wpis->emailTrescTxt,
			'emailZalaczniki' => $wpis->emailZalaczniki,
			'emailZalacznikiKatalog' => $wpis->emailZalacznikiKatalog,
		);
	}



	/**
	 * Ustawia tablice z danymi do sparsowania w tytule i tresci wiadomosci email
	 * @param array $ustawienia
	 */
	public function wczytajDane(Array $dane)
	{
		$this->dane = $dane;

		$obiekty = array();
		foreach ($this->kontener->pobierzObslugiwaneObiekty() as $nazwaObiektu => $klasaObiektu)
		{
			$klucz = 'obiekt_'.$nazwaObiektu;
			if (isset($this->dane[$klucz]) && $this->dane[$klucz] instanceof $klasaObiektu)
			{
				$obiekty[$nazwaObiektu] = $this->dane[$klucz];
				unset($this->dane[$klucz]);
			}
		}
		if (count($obiekty) > 0)
		{
			$this->kontener->wczytajObiekty($obiekty);
		}
	}



	/**
	 * W czytuje przygotowany wczesniej email jednoczesnie ustawiając
	 *
	 * @param bool $czyWyslano
	 */
	protected function zapiszStanWKolejce($czyWyslano)
	{
		
		//jezeli wiadomosc wyslano w trybie natychmiastowym to nie ma sensu zapisywac
		if ($this->ustawienia['zapiszStanWKolejce'] == false
			|| ($this->ustawienia['typWysylania'] == 'natychmiast' && $czyWyslano == true) && $this->ustawienia['zapiszStanWKolejce'] !== true)
		{
			return;
		}
		
		$wpis = new EmailWpisKolejki\Obiekt();
		$wpis->idProjektu = ID_PROJEKTU;
		$wpis->kodJezyka = KOD_JEZYKA;
		$wpis->dataDodania = date("Y-m-d H:i:s");
		
		$zalogowany_uzytkownik = Cms::inst()->profil();
		
		if ($zalogowany_uzytkownik instanceof Uzytkownik\Obiekt && $zalogowany_uzytkownik->id > 0)
		{
			$wpis->idNadawcy = $zalogowany_uzytkownik->id;
		}
		
		if ($czyWyslano == false)
		{
			$wpis->bledyLicznik = 1;
			$wpis->bledyOpis = trim($this->debug);
		}
		if ($this->formatka instanceof EmailFormatka\Obiekt)
		{
			$wpis->idFormatki = $this->formatka->id;
		}
		$pomijane = array('przygotujWiadomosc','zapiszStanWKolejce','emailSzablon');
		foreach ($this->ustawienia as $pole => $wartosc)
		{
			if ($pole == 'emailZalacznikiKatalog')
			{
				if(is_array($wartosc))
					$wpis->$pole = implode(',', $wartosc);
				continue;
			}
			if (in_array($pole, $pomijane))	continue;
			$wpis->$pole = $wartosc;
		}
		
		$wpis->zapisz(Cms::inst()->dane()->EmailWpisKolejki());
	}



	/**
	 * Wysyła wiadomość email i zwraca wynik
	 * @return bool
	 */
	public function wyslij()
	{
		if ($this->ustawienia['przygotujWiadomosc'])
		{
			$this->przygotujWiadomosc();
		}
		switch ($this->ustawienia['typWysylania'])
		{
			case 'natychmiast':
				$czyWyslano = $this->wyslijEmail();
				$this->zapiszStanWKolejce($czyWyslano);
				return $czyWyslano;
			break;

			case 'cron':
				$czyWyslano = true;
				$this->ustawienia['zapiszStanWKolejce'] = true;
				$this->zapiszStanWKolejce($czyWyslano);
				return $czyWyslano;
			break;

			default:
				trigger_error("Nieobslugiwany tryb wysyłania wiadomosci " . $this->ustawienia['typWysylania'], E_USER_WARNING);
			break;
		}
	}



	/**
	 * Parsuje wszystkie tresci i odbiorcow na podstawie dolaczonych danych
	 */
	protected function przygotujWiadomosc()
	{
		$this->ustawienia['emailOdbiorcy'] = $this->parsujOdbiorcow($this->ustawienia['emailOdbiorcy']);
		$this->ustawienia['emailKopie'] = $this->parsujOdbiorcow($this->ustawienia['emailKopie']);
		$this->ustawienia['emailKopieUkryte'] = $this->parsujOdbiorcow($this->ustawienia['emailKopieUkryte']);
		$this->ustawienia['emailOdpowiedzi'] = $this->parsujOdbiorcow($this->ustawienia['emailOdpowiedzi']);

		$this->pobierzMetodeWysylki();

		$this->ustawienia['emailTytul'] = $this->parsujTresc($this->ustawienia['emailTytul']);
		$this->ustawienia['emailTrescHtml'] = $this->parsujTresc($this->ustawienia['emailTrescHtml'], 1);
		$this->ustawienia['emailTrescTxt'] = $this->parsujTresc($this->ustawienia['emailTrescTxt']);
		


		if ($this->ustawienia['emailSzablon'] > 0)
		{
			$szablon = EmailSzablon\Mapper::wywolaj()->pobierzPoId($this->ustawienia['emailSzablon']);

			if ($szablon instanceof EmailSzablon\Obiekt)
			{
				$this->ustawienia['emailTrescHtml'] = str_replace('{TRESC}', $this->ustawienia['emailTrescHtml'], $szablon->trescHtml);
				$this->ustawienia['emailTrescTxt'] = str_replace('{TRESC}', $this->ustawienia['emailTrescTxt'], $szablon->trescTxt);
			}
		}
	}

	
	protected function parsujOdbiorcow(Array $adresyEmail)
	{
		if (count($adresyEmail) < 1) return array();

		$mapaOdbiorcow = self::predefiniowaniOdbiorcy();
		$obiektyKlasy = $this->kontener->pobierzObslugiwaneObiekty();

		$zamiana = array();
		$adresyEmailPoprawione = array();

		foreach ($adresyEmail as $adres => $nazwa)
		{
			if ($nazwa == '' && $adres == '') continue;

			foreach ($mapaOdbiorcow as $etykieta => $deklaracjaObiektPole)
			{
				if ((string)$adres == (string)$etykieta || (string)$nazwa == (string)$etykieta)
				{
					if ( ! array_key_exists($etykieta, $zamiana))
					{
						
						list($nazwaObiektu, $poleObiektu) = $deklaracjaObiektPole;
						$obiekt = $this->kontener->pobierz($nazwaObiektu);
						$klasaObiektu = $obiektyKlasy[$nazwaObiektu];
						//$zamiana[$etykieta] = ($obiekt instanceof $klasaObiektu) ? $obiekt->$poleObiektu : '';
						if($obiekt instanceof $klasaObiektu)
						{
							$this->obiektyOdbiorcow[] = $obiekt;
							$zamiana[$etykieta] = $obiekt->$poleObiektu;
						}
						else
							$zamiana[$etykieta] = '';
						
					}
					//TODO logowac to jak wyprostuja sytuacje z brakami w bazie
					//if ($zamiana[$etykieta] == '')
					//	trigger_error('Nie można znalezc uzytkownika dla deklaracji adres: '.$adres.', nazwa: '.$nazwa.' email: '.$this->ustawienia['emailTytul'], E_USER_WARNING);

					$adres = str_replace($etykieta, $zamiana[$etykieta], $adres);
					$nazwa = str_replace($etykieta, $zamiana[$etykieta], $nazwa);
			
				}
			}
			if (strpos($adres, 'PRACOWNIK-') !== false || strpos($nazwa, 'PRACOWNIK-') !== false)
			{
				if (strpos($adres, 'PRACOWNIK-') !== false)
					$id = (int)str_replace('}', '', str_replace('{PRACOWNIK-', '', trim($adres)));
				if (strpos($nazwa, 'PRACOWNIK-') !== false)
					$id = (int)str_replace('}', '', str_replace('{PRACOWNIK-', '', trim($nazwa)));

				$pracownik = ($id > 0) ? Cms::inst()->dane()->Uzytkownik()->pobierzPoId($id) : null;
				if ($pracownik instanceof Uzytkownik\Obiekt)
				{
					$adres = $pracownik->email;
					$nazwa = $pracownik->pelnaNazwa;
					$this->obiektyOdbiorcow[] = $pracownik;
				}
				else
				{
					trigger_error('Nie można znalezc uzytkownika dla deklaracji: '.$adres.', '.$nazwa.', email: '.$this->ustawienia['emailTytul'], E_USER_WARNING);
					$adres = $nazwa = '';
				}
			}
			$adresyEmailPoprawione[$adres] = $nazwa;
		}
		
		return $adresyEmailPoprawione;
	}



	protected function parsujTresc($tresc, $trescGlowna = 0)
	{
		$szablon = new Szablon;

		if( (isset($this->ustawienia['htmlZalaczniki']) && $this->ustawienia['htmlZalaczniki'] != '')
				  && $trescGlowna
				  && ( $this->metodaWysylaniaZalacznikow == 'url' || $this->metodaWysylaniaZalacznikow == 'zalacznik_url') 
		)
		{
			$tresc.=$this->ustawienia['htmlZalaczniki'];
		}

		$szablon->ladujTresc($tresc);
		$struktura = $szablon->struktura(true);

		if (empty($struktura)) return $tresc;

		$dane = $this->dane;
		$obiekty = array();
		foreach ($struktura as $sciezka)
		{
			// wyciagamy klucze w postaci "obiekt-NazwaObiektu-nazwaPropercji" do tablicy obiektow
			if (preg_match_all('/(obiekt-([a-zA-Z0-9]+)-([a-zA-Z0-9]+))/', $sciezka, $znalezione, PREG_SET_ORDER))
			{
				$znalezione = array_pop($znalezione);

				$definicjaObiektu = $znalezione[1];
				$nazwaObiektu = $znalezione[2];
				$propercjaObiektu = $znalezione[3];

				$klucz = 'obiekt_'.$nazwaObiektu;
				// pobieranie obiektu z wewnetrznej tablicy danych lub z kontenera
				$obiekt = (isset($this->dane[$klucz])) ? $this->dane[$klucz] : $this->kontener->pobierz($nazwaObiektu);
				$wartoscZObiektu = (is_object($obiekt)) ? $obiekt->$propercjaObiektu : null;

				/*
				 * Na podstawie analizy sciezki wstawiamy do danych wartosc z obiektu
				 * z zachowaniem struktury zdefiniowanej w szablonie
				 */
				$sciezka = array_reverse(array_filter(explode('/', $sciezka)));

				// budujemy zagłebioną tablice z odwroconej sciezki
				$tablica = array(); //pierwszy element jest tak naprawde blokiem
				while ($blokTablicy = array_shift($sciezka))
				{
					if(!empty($tablica) && in_array(strtolower(substr($blokTablicy, 0, strpos($blokTablicy, ' ') !== false ? strpos($blokTablicy, ' ') : strlen($blokTablicy))), array('if', 'elseif', 'else', 'unless')))
					{
						continue;
					}
					if (preg_match('/obiekt-[a-zA-Z0-9]+-[a-zA-Z0-9]+/', $blokTablicy, $obiektDef))
					{
						$blokTablicy = $obiektDef[0];
					}
					if ((string) $blokTablicy == (string) $definicjaObiektu)
					{
						$tablica = $wartoscZObiektu;
					}
					$tablica = array($blokTablicy => $tablica);
				}
				$dane = array_replace_recursive($dane, $tablica);
				//$dane = array_merge_recursive($dane, $tablica);
			}
		}
		
		$szablon->ustaw($dane);
		return $szablon->parsuj();
	}



	protected function wyslijEmail()
	{
		$konfiguracjaCms = Cms::inst()->config['email'];

		ob_start();
		$email = new PHPMailer();

		$email->IsSMTP();
		$email->Host = $konfiguracjaCms['smtp_host']; //adres serwera SMTP
		$email->Port = $konfiguracjaCms['smtp_port']; //port serwera SMTP
		$email->SMTPDebug = (isset($konfiguracjaCms['smtp_debug'])) ? abs((int)$konfiguracjaCms['smtp_debug']) : false;
		
		//$email->SMTPDebug = 1;
		if ($konfiguracjaCms['smtp_user'] != '' && $konfiguracjaCms['smtp_pass'] != '')
		{
			$email->SMTPAuth = true;
			$email->Username = $konfiguracjaCms['smtp_user']; //nazwa użytkownika
			$email->Password = $konfiguracjaCms['smtp_pass']; //nasze hasło do konta SMTP
		}
		if ($konfiguracjaCms['smtp_secur'] != '')
		{
			$email->SMTPSecure = $konfiguracjaCms['smtp_secur']; // protokol szyfrowania
		}


		$this->emailUstawTresc($email, $konfiguracjaCms);


		if ($this->ustawienia['emailNadawcaEmail'] != '')
			$email->From = $this->ustawienia['emailNadawcaEmail'];
		else
			$email->From = $konfiguracjaCms['from'];

		if ($this->ustawienia['emailNadawcaNazwa'] != '')
			$email->FromName = $this->ustawienia['emailNadawcaNazwa'];
		else
			$email->FromName = $konfiguracjaCms['from_name'];

		$this->emailDodajOdbiorcow($email, $this->ustawienia['emailOdbiorcy'], 'Odbiorcy');
		$this->emailDodajOdbiorcow($email, $this->ustawienia['emailKopie'], 'Kopie');
		$this->emailDodajOdbiorcow($email, $this->ustawienia['emailKopieUkryte'], 'KopieUkryte');
		$this->emailDodajOdbiorcow($email, $this->ustawienia['emailOdpowiedzi'], 'Odpowiedzi');
		if ($this->ustawienia['emailPotwierdzenieEmail'] != '')
			$this->emailDodajOdbiorcow($email, array($this->ustawienia['emailPotwierdzenieEmail']), 'Potwierdzenie');

		if ((bool)(trim($konfiguracjaCms['email_dev']) != '' && strpos(DOMENA, 'supertraders.pl') === false))
		{
			$adresaci = "-------------- EMAIL TRYB TESTOWY --------------";
			$adresaci .= $this->odbiorcyLog;
			$adresaci .= "\n-------------- EMAIL TRYB TESTOWY --------------\n\n";
			if ( ! empty($this->ustawienia['emailTrescHtml'])) $adresaci = nl2br($adresaci);

			$email->Body = $adresaci.$email->Body.

			$email->ConfirmReadingTo = '';
			$email->ClearReplyTos();
			$email->ClearAllRecipients();
			$email->AddAddress($konfiguracjaCms['email_dev']);
		}

		$emailWyslany = $email->Send();
		$email->ClearAddresses();
		$email->ClearAttachments();

		if ($email->SMTPDebug > 0)
		{
			$this->debug = ob_get_contents();
			Cms::inst()->temp('smtp_debug', $this->debug);
		}
		ob_end_clean();

		$this->zapiszLog($emailWyslany);

		if ($emailWyslany)
		{
			return true;
		}
		else
		{
			if ($email->SMTPDebug > 0) trigger_error($this->debug, E_USER_WARNING);
			return false;
		}
	}



	protected function emailUstawTresc(PHPMailer $email, Array $konfiguracjaCms)
	{
		$emailTrescHtml = $this->ustawienia['emailTrescHtml'];
		$emailTrescTxt = $this->ustawienia['emailTrescTxt'];
		$emailTytul = $this->ustawienia['emailTytul'];

		if (isset($konfiguracjaCms['charset']) && $konfiguracjaCms['charset'] != '')
		{
			$email->CharSet = strtoupper($konfiguracjaCms['charset']);
			$emailTrescHtml = iconv("UTF-8", $email->CharSet, $emailTrescHtml);
			$emailTrescTxt = iconv("UTF-8", $email->CharSet, $emailTrescTxt);
			$emailTytul = iconv("UTF-8", $email->CharSet, $emailTytul);
		}
		else
		{
			$email->CharSet = 'UTF-8';
		}

		if ($konfiguracjaCms['img_include'] &&  ! empty($emailTrescHtml))
		{
			$emailTrescHtml = $this->obrazkiDoZalacznika($emailTrescHtml, $email);
		}

		$email->Subject = $emailTytul;

		if ( ! empty($emailTrescHtml))
		{
			$email->IsHTML(true);
			$email->Body = $emailTrescHtml;
			$email->AltBody = $emailTrescTxt;
		}
		else
		{
			$email->IsHTML(false);
			$email->Body = $emailTrescTxt;
		}

		if (	is_array($this->ustawienia['emailZalaczniki']) && count($this->ustawienia['emailZalaczniki']) > 0
				  && ( $this->metodaWysylaniaZalacznikow == 'zalacznik' || $this->metodaWysylaniaZalacznikow == 'zalacznik_url') 
			)
		{
			$i = 0;
			foreach ($this->ustawienia['emailZalaczniki'] as $zalacznik)
			{
				if(is_array($this->ustawienia['emailZalacznikiKatalog']))
				{
					$zalacznik = $this->ustawienia['emailZalacznikiKatalog'][$i].'/'.$zalacznik;
					$i++;
				}
				else
				{
					$zalacznik = $this->ustawienia['emailZalacznikiKatalog'].'/'.$zalacznik;
				}
				$email->AddAttachment($zalacznik);
			}
		}

	}
	
	public function dodajZalaczniki(Array $zalaczniki, $katalog, Array $zalacznikiObjekt = [])
	{
		if(count($zalacznikiObjekt))
		{
			$this->dodajZalacznikiJakoUrl($zalacznikiObjekt);
		}
		$this->dodajZalacznikiJakoZalacznik ($zalaczniki, $katalog);
	}
	
	protected function dodajZalacznikiJakoZalacznik(Array $zalaczniki, $katalog)
	{
		if (is_array($zalaczniki) && count($zalaczniki) > 0)
		{
			$this->ustawienia['emailZalaczniki'] = $zalaczniki;
			$this->ustawienia['emailZalacznikiKatalog'] = $katalog;
		}
	}

	protected function dodajZalacznikiJakoUrl(Array $zalaczniki)
	{
		$szablon = new Szablon();
		$szablon->ladujTresc($this->szablonZalacznikiUrl);
		
		$zalacznikiUrl = array();
		$i = 0;
		foreach($zalaczniki as $zalacznik)
		{
			$zalacznikiUrl['pozycja'][$i]['link'] = $zalacznik->pobierzUrlZewnetrzny(true);
			$zalacznikiUrl['pozycja'][$i]['etykieta'] = $zalacznik->file;
			$i++;
		}
		
		$szablon->ustaw($zalacznikiUrl);
		$this->ustawienia['htmlZalaczniki'] = $szablon->parsuj();
	}

	protected function emailDodajOdbiorcow($email, Array $adresyEmail = array(), $typ)
	{
		if (count($adresyEmail) < 1) return;

		$email->SMTPKeepAlive = true;

		$adresyZapis = array();
		foreach ($adresyEmail as $adres => $nazwa)
		{
			if ($nazwa != '' || $adres != '')
				$adresyZapis[] = (is_int($adres)) ? $nazwa : "{$nazwa} ({$adres})";

			if (is_int($adres))
			{
				$adres = $nazwa;
				$nazwa ='';
			}
			switch ($typ)
			{
				case 'Odbiorcy': $email->AddAddress($adres, $nazwa); break;
				case 'Kopie': $email->AddCc($adres, $nazwa); break;
				case 'KopieUkryte': $email->AddBcc($adres, $nazwa); break;
				case 'Odpowiedzi': $email->AddReplyTo($adres, $nazwa); break;
				case 'Potwierdzenie': $email->ConfirmReadingTo = $adres; break;
			}
		}
		$this->odbiorcyLog .= "\n {$typ}: ".implode(', ',$adresyZapis);
	}



	/**
	 * Analizuje Html w poszukiwaniu obrazkow i dodaje je jako zalaczniki
	 *
	 * @param string $Html tresc wiadomosci do wysylki, ktora moze zawierac obrazki
	 * @param Poczta_PHPMailer $MailerObj obiekt PHPMailer'a, abyśmy mogli zalaczyc pliki
	 *
	 * @return string przetworzony html
	 */
	protected function obrazkiDoZalacznika($Html, PHPMailer $MailerObj)
	{
		$dopasowania = array();
		$dopasowanieTla = array();
		preg_match_all('/<img.*?>/', $Html, $dopasowania);
		preg_match_all('/background:url\(\'(.*?)\'\)/', $Html, $dopasowanieTla);
		if (!count($dopasowania) && !count($dopasowaniaTla)) return $Html;

		$dopasowania = array_merge($dopasowanieTla[0], $dopasowania[0]);
		$katalog = str_replace(Cms::inst()->config['katalogi']['public_temp'], '', Cms::inst()->katalog('public_temp'));
		$finfo = finfo_open(FILEINFO_MIME_TYPE);
		
		foreach ($dopasowania as $klucz => $obrazek)
		{
			if (!isset($obrazek)) continue;
			$sciezka = array();
			$nazwaObrazka = array();
			preg_match('/src="(.*?)"/', $obrazek, $sciezka);
			preg_match('/alt="(.*?)"/', $obrazek, $nazwaObrazka);
			if(empty($sciezka))
			{
				preg_match('/url\(\'(.*?)\'\)/', $obrazek, $sciezka);
			}

			$nazwaPliku = 'obraz_';
			if (isset($nazwaObrazka[1]) && strlen($nazwaObrazka[1]) > 0)
			{
				$nazwaPliku = Plik::unifikujNazwe($nazwaObrazka[1]) .'_';
			}

			if (!isset($sciezka[1])) continue;
			$url = parse_url($sciezka[1]);
			if(!file_exists($katalog.$url['path']))
			{
				$url['path'] = str_replace('_public', 'public', $url['path']);
			}
			if ((!isset($url['host']) || !isset($url['path'])) || !file_exists($katalog.$url['path'])) continue;

			$MailerObj->AddEmbeddedImage($katalog.$url['path'], $klucz+1001, $nazwaPliku.($klucz+1), 'base64', finfo_file($finfo, $katalog.$url['path']));
			$Html = str_replace($sciezka[1], 'cid:'.($klucz+1001), $Html);
		}
		return $Html;
	}



	protected function zapiszLog($emailWyslany)
	{
		$wiersz = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
		$wiersz .= ($emailWyslany) ? ' WYSLANO ' : ' BLAD    ';
		$wiersz .= "Temat: ".$this->ustawienia['emailTytul'];
		$wiersz .= $this->odbiorcyLog;
		$wiersz = str_replace(array("\n","\r"), '', $wiersz)."\n";
		error_log($wiersz, 3, LOGI_KATALOG.'/'.date ("Y-m-d", $_SERVER['REQUEST_TIME']).'-email.log');
	}

}


class PocztaWyjatek extends \Exception {}
