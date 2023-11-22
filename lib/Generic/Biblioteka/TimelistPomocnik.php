<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\Cms;
use Generic\Model\Uzytkownik;
use Generic\Model\Team;
use Generic\Model\Zamowienie;
use Generic\Model\Timelist;
use Generic\Model\Polaczenia;
/**
 * Obsluga notatek w systemie
 *
 * @author Marcin Mucha
 * @package biblioteki
 */
class TimelistPomocnik
{
	
	/**
	 * Objekt Uzytkownik
	 * 
	 * @var object
	 */
	protected $_obiektLider;
	
	/**
	 * Objekt Team.
	 * 
	 * @var object
	 */
	protected $_obiektTeam ;
	
	/**
	 * Objekt Timelist.
	 * 
	 * @var object
	 */
	protected $_obiektTimelist;
	
	/**
	 * Objekt Zamowienie.
	 * 
	 * @var object
	 */
	protected $_obiektZamowienie;
	
	/*
	 * Array przechowuje konfiguracje typow timelisty
	 * 
	 * @var array
	 */
	protected $_konfiguracjaTypow;

	/*
	 * Array przechowuje typy timelisty dla których nie można zalogować użytkownika
	 * 
	 * @var array
	 */
	protected $_zabronLogowaniaTypy;


	/**
	 * Konstruktor.
	 *
	 */
	function __construct() 
	{
		$this->pobierzKofiguracjeTypow();
	}
	
	/*
	 * loguje ekipe do zadania
	 * 
	 * @param int idZamowienia
	 */
	public function zalogujEkipeDoZadania($idZamowienia)
	{
		if(!isset($this->_obiektLider))
		{
			return false;
		}
		
		$this->ustawZamowienie($idZamowienia);
		
		if($this->czyEkipaPrzypisanaDoZadania())
		{
			if($this->sprawdzCzyReklamacja())
			{
				$this->ustawReklamacjie('zaloguj');
			}
			
			$this->wylogujEkipeZzadania();
			
			$this->ustawZamowienie($idZamowienia);
			foreach($this->_obiektTeam->idUsers as $idPracownika)
			{
				if($this->czyPracownikMaWolne($idPracownika))
				{
					continue;
				}
				
				$pracownik = $this->pobierzPracownika($idPracownika);
				
				$this->ustawObiektTimelisty();
				$this->ustawDataStart();
				$this->ustawPraktykant($pracownik);
				$this->ustawCenaZaGodzine();
				$this->ustawMnoznik($pracownik);
				$this->ustawStawke($pracownik);
				$this->ustawPodatek($pracownik);
				$this->ustawIdPracownika($pracownik);
				$this->zapiszTimelist();
				
			}
			return true;
		}
		else
		{
			trigger_error('Błąd. Ekipa '.$this->_obiektTeam->teamNumber.' nie jest przypisana do zamówienia o id : '.$idZamowienia , E_USER_ERROR);
			return false;
		}
	}
	
	/*
	 * wylogowuje ekipe z ostatniego zadania
	 */
	public function wylogujEkipeZzadania()
	{
		if(!isset($this->_obiektLider))
		{
			return false;
		}
		
		$przepracowaneGodzinyLacznie = 0;
		$idZadaniaDoSprawdzenia = 0;
		foreach($this->_obiektTeam->idUsers as $idPracownika)
		{
			$zadanieDoZakonczenia = $this->pobierzNiezakonczoneZadaniePracownika($idPracownika);
			
			if(isset($zadanieDoZakonczenia) && count($zadanieDoZakonczenia) > 0)
			{
				foreach($zadanieDoZakonczenia as $zadanie)
				{
					$this->ustawObiektTimelisty($zadanie['id']);
					$dataStop = $this->ustawDataStop();
					$przepracowaneGodzinyLacznie =+ $this->ustawIloscGodzin($zadanie['data_start'], $dataStop);
					$this->zapiszTimelist();
					$idZadaniaDoSprawdzenia = $zadanie['id_object'];
				}
				
			}
		}
		
		// sprawdzamy czy zadanie nad którym obecnie pracje ekipa to reklamacja
		if($idZadaniaDoSprawdzenia > 0)
		{
			$this->ustawZamowienie($idZadaniaDoSprawdzenia);

			if($this->sprawdzCzyReklamacja())
			{
				$this->ustawReklamacjie('wyloguj', $przepracowaneGodzinyLacznie);
			}
		}
		
		return true;
	}
	
	
	/*
	 * dologowuje pracownika do zadania automatycznie przypisuje go do nowej ekipy i usuwa ze starej
	 * 
	 * @param int idPracownika
	 * @param Team\Obiekt $team - jeśli podany przenosimy pracownika do teamu i logujemy go do zadnia obecnenie wykonywanego przez Team lidera
	 * 
	 */
	public function dobierzPracownikaDoZadania($idPracownika, Team\Obiekt $team = null)
	{
		$pracownik = $this->pobierzPracownika($idPracownika);
		if($team != null)
		{
			$idZamowienia = $this->pobierzNiezakonczoneZadaniePracownika($team->idLeader);
			$this->_obiektTeam = $team;
		}
		else
		{
			$idZamowienia = $this->pobierzNiezakonczoneZadaniePracownika($this->_obiektLider->id);
		}
		
		$this->wylogujPracownikaZzadania($pracownik->id, true);
		$this->przepiszPracownikaDoTeamu($pracownik);
		
		if($idZamowienia)
		{
			$this->ustawZamowienie($idZamowienia[0]['id_object']);
			
			$this->ustawObiektTimelisty();
			$this->ustawDataStart();
			$this->ustawIdPracownika($pracownik);
			$this->ustawMnoznik($pracownik);
			$this->ustawPodatek($pracownik);
			$this->ustawStawke($pracownik);
			$this->ustawPraktykant($pracownik);
			if($this->zapiszTimelist())
			{
				return true;
			}
			else
			{
				return false;
			}
		}
		else
		{
			//trigger_error('Błąd. Ta ekipa nie jest obecnie zalogowana do żadnego zadania.', E_USER_ERROR);
			return true;
		}
		
	}
	
	
	/*
	 * wylogowuje pracownika z zadania automatycznie wywala pracownika z ekipy
	 * 
	 * @param int idPracownika
	 */
	public function wylogujPracownikaZzadania($idPracownika, $usunZteamu = false)
	{
		$pracownik = $this->pobierzPracownika($idPracownika);
		
		$zadaniaDoZakonczenia = $this->pobierzNiezakonczoneZadaniePracownika($pracownik->id);
		
		if($usunZteamu)
		{
			if(!$this->usunPracownikaZteamu($pracownik))
			{
				return false;
			}
		}
		
		if(count($zadaniaDoZakonczenia)>0)
		{
			$this->ustawObiektTimelisty($zadaniaDoZakonczenia[0]['id']);
			$this->ustawZamowienie($zadaniaDoZakonczenia[0]['id_object']);
			$dataStop = $this->ustawDataStop();
			$this->ustawIloscGodzin($zadaniaDoZakonczenia[0]['data_start'], $dataStop);
			if($this->zapiszTimelist())
				return true;
			else
				return false;
		}
		else
		{
			return true;
		}
		
		
	}
	
	/*
	 * przepisuje pracownika do zalogowanego teamu
	 * 
	 * @param \Generic\Model\Uzytkownik\Obiekt $pracownik
	 */
	public function przepiszPracownikaDoTeamu(Uzytkownik\Obiekt $pracownik)
	{
		
		if($this->usunPracownikaZteamu($pracownik))
		{
			
			// dodajemy uzytkownika do nowej ekipy
			$teamMapper = new Team\Mapper();
			$listaPracownikow = $teamMapper->pobierzPoId($this->_obiektTeam->id);
			$ekipa = (is_array($listaPracownikow->idUsers) ) ? $listaPracownikow->idUsers : array() ;
			array_push($ekipa, $pracownik->id);
			$listaPracownikow->idUsers = $ekipa;
			if($listaPracownikow->zapisz($teamMapper))
			{
				return true;
			}
			else
			{
				trigger_error('Błąd. Nie udało się przydzielić nowego pracownika do Ekipy ', E_USER_ERROR);
				return false;
			}
		}
		else
		{
			return false;
		}
		
	}

	/**
	 * Usuwa pracownika z Teamu
	 * @param \Generic\Model\Uzytkownik\Obiekt $pracownik
	 */
	public function usunPracownikaZteamu(Uzytkownik\Obiekt $pracownik)
	{
		$pracownicy = new Team\Definicja();
		$pracownicyPrzydzieleni = $pracownicy->pracownicyPrzydzieleni();
		
		$listaPracownikowDoZmiany = array();
		
		foreach($pracownicyPrzydzieleni as $idPracownika => $danePracownika)
		{
			
			if($idPracownika == $pracownik->id)
			{
				
				// usuwamy pracownika ze starej ekipy
				$team = new Team\Mapper();
				
				$listaPracownikow = $team->pobierzPoId($danePracownika['idTeamu']);
				$ekipa = $listaPracownikow->idUsers;
				
				if($listaPracownikow->idLeader == $pracownik->id)
				{
					$listaPracownikow->idLeader = '';
				}
				
				$ekipaPoUsunieciu = array_diff($ekipa, array($pracownik->id));
				$listaPracownikow->idUsers = $ekipaPoUsunieciu;
				
				if($listaPracownikow->zapisz($team))
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			
		}
		return true;
	}

	/**
	 * zwraca obiekt zamowienie nad którym obecnie pracuje zalogowana ekipa
	 * 
	 * return Zamowienie;
	 */
	
	public function pobierzDaneObecnegoZamowienia()
	{
		$idZamowienia = $this->pobierzNiezakonczoneZadaniePracownika($this->_obiektLider->id);
		
		if(isset($idZamowienia[0]['id_object']) && $idZamowienia[0]['id_object'] > 0)
		{
			$this->ustawZamowienie($idZamowienia[0]['id_object']);
		
			return $this->_obiektZamowienie;
		}
		else
		{
			return false;
		}
	}
	
	
	public function pobierzDaneObecneTimelist()
	{
		$idTimelisty = $this->pobierzNiezakonczoneZadaniePracownika($this->_obiektLider->id);
		
		if(isset($idTimelisty[0]['id']) && $idTimelisty[0]['id'] > 0)
		{
			$this->ustawObiektTimelisty($idTimelisty[0]['id']);
		
			return $this->_obiektTimelist;
		}
		else
		{
			return false;
		}
	}

	/*
	 * dodaje rekord ujemny do zadania
	 * 
	 * @param string $akcja - przyjmyje wartosc "zaloguj", "wyloguj"
	 * @param int $przepracowaneGodzinyNaRaklamacji - dla akcji wyloguj
	 */
	private function ustawReklamacjie($akcja, $przepracowaneGodzinyNaRaklamacji = 0)
	{
		$atrybutyReklamacji = $this->_obiektZamowienie->attributes;
		
		// ten typ obciążenia liczony tylko przy logowaniu
		if($akcja == 'zaloguj' && isset($atrybutyReklamacji['obciazyc']) && isset($atrybutyReklamacji['obciazyc']['order_hours']) && $atrybutyReklamacji['obciazyc']['order_hours'] > 0)
		{
			// sprawdzamy czy jakaś ekipa logowała się już do reklamacji
			$timeList = new Timelist\Mapper();
			$timelistaReklamacji = $timeList->pobierzPoIdZadania($this->_obiektZamowienie->id);
			
			// jeżeli pierwsze logowanie zabieramy godziny
			if(count($timelistaReklamacji) <= 0)
			{
				$zamowienie = new Zamowienie\Mapper();
				$reklamowaneZamowienie = $zamowienie->pobierzPoId($this->_obiektZamowienie->idParent);
				
				if($reklamowaneZamowienie instanceof Zamowienie\Obiekt)
				{
					$timelistReklamacja = new Timelist\Mapper();
					$timelistyPracownikow = $timelistReklamacja->pobierzPoIdZadania($reklamowaneZamowienie->id);

					foreach($timelistyPracownikow as $timelista)
					{
						$this->ustawObiektTimelistyReklamacja($timelista, $reklamowaneZamowienie);
						$pracownik = $this->pobierzPracownika($timelista->idUser);
						$this->ustawIdPracownika($pracownik);
						$przelicznik = - abs($atrybutyReklamacji['obciazyc']['order_hours']/100);
						$this->ustawMnoznik($pracownik, $przelicznik);
						$this->zapiszTimelist();
					}

				}
				else
				{
					trigger_error('Błąd. Zamowienie do którego przypisana jest reklamacja nie istnieje.', E_USER_ERROR);
					return false;
				}
			}
			
		}
		// ten typ obciążenia liczony tylko przy wylogowaniu
		elseif($akcja == 'wyloguj' && isset($atrybutyReklamacji['obciazyc']) && isset($atrybutyReklamacji['obciazyc']['reclamation_hours']) && $atrybutyReklamacji['obciazyc']['reclamation_hours'] > 0)
		{
			if($przepracowaneGodzinyNaRaklamacji <= 0)
			{
				trigger_error('Błąd. Ilość godzin do zabrania za reklamacje nie została podana.', E_USER_ERROR);
				return false;
			}
			
			$zamowienie = new Zamowienie\Mapper();
			$reklamowaneZamowienie = $zamowienie->pobierzPoId($this->_obiektZamowienie->idParent);
			
			if($reklamowaneZamowienie instanceof Zamowienie\Obiekt)
			{
				$timelistReklamacja = new Timelist\Mapper();
				$iloscPracownikowDoPodzialu = $timelistReklamacja->zwracaTablice()->pobierzPracownikowPoIdZadania($reklamowaneZamowienie->id);

				$godzinyDoZabraniaNaPracownika = ($przepracowaneGodzinyNaRaklamacji / count($iloscPracownikowDoPodzialu));
				
				foreach($iloscPracownikowDoPodzialu as $dane)
				{
					$mapperTimelist = new Timelist\Mapper();
					$daneTimelista = $mapperTimelist->pobierzPoId($dane['id']);
					$pracownik = $this->pobierzPracownika($dane['id_user']);
					
					$this->ustawObiektTimelistyReklamacja($daneTimelista, $reklamowaneZamowienie);
					$this->ustawIdPracownika($pracownik);
					$this->ustawMnoznik($pracownik, -1);
					$this->_obiektTimelist->hours = $godzinyDoZabraniaNaPracownika;
					$this->zapiszTimelist();
					
				}
				
			}
			else 
			{
				trigger_error('Błąd. Zamowienie do którego przypisana jest reklamacja nie istnieje.', E_USER_ERROR);
				return false;
			}
			
		}
		else
		{
			// reklamacja nie obciąża wcześniejszych wykonawców zadania
		}
		
	}
	
	
	/**
	 * sprawdza czy zamówienie nad którym pracuje ekipa jest reklamacją
	 * 
	 * @return boolean
	 */
	private function sprawdzCzyReklamacja()
	{
		$mapperKonfiguracja = new \Generic\Model\WierszKonfiguracji\Mapper();
		$idTypuReklamacja = $mapperKonfiguracja->pobierzWartoscWierszaKonfiguracji('index.id_typu_reklamacji', 'AssignTeams_Admin');
		
		if($this->_obiektZamowienie->idType == $idTypuReklamacja && $this->_obiektZamowienie->isReclamation)
			return true;
		else
			return false;
	}



	/*
	 * tworzy obiekt Uzytkownika na podstawie zalogowanej osoby
	 */
	public function ustawObiektLider()
	{
		$cms = Cms::inst();
		$pracownik = $cms->profil();
		
		if($pracownik instanceof Uzytkownik\Obiekt)
		{
			if($this->czyPracownikMaWolne($pracownik->id))
			{
				return false;
			}
			
			$mapperKonfiguracja = new \Generic\Model\WierszKonfiguracji\Mapper();
			$kody_rol = $mapperKonfiguracja->pobierzWartoscWierszaKonfiguracji('formularz.input_pracownicy_kody_rol', 'Team_Admin');
			
			if($pracownik->maRole($kody_rol))
			{

				$this->_obiektLider = $pracownik;
				
				if($this->ustawObiektTeamuDlaLidera($this->_obiektLider->id))
				{
					return true;
				}
				else
				{
					return false;
				}
				
			}
			else
			{
				// trigger_error('Błąd. Lider nie posiada uprawnień do logowania się do zadań.', E_USER_ERROR);
				return false;
			}
		
		}
		else
		{
			trigger_error('Błąd. Nie można pobrać lidera Teamu.', E_USER_ERROR);
			return false;
		}
		
	}
	
	
	public function pobierzObiektLidera()
	{
		if(isset($this->_obiektLider) && $this->_obiektLider->id > 0 )
		{
			return $this->_obiektLider;
		}
		else
		{
			return false;
		}
	}
	
	/*
	 * tworzy obiekt pracownika
	 * 
	 * @param idPracownika
	 * 
	 * @return Pracownik
	 */
	protected function pobierzPracownika($idPracownika)
	{
		$mapperUzytkownik = new Uzytkownik\Mapper();
		$pracownik = $mapperUzytkownik->pobierzPoId($idPracownika);
		
		if($pracownik instanceof Uzytkownik\Obiekt)
		{
			$mapperKonfiguracja = new \Generic\Model\WierszKonfiguracji\Mapper();
			$kody_rol = $mapperKonfiguracja->pobierzWartoscWierszaKonfiguracji('formularz.input_pracownicy_kody_rol', 'Team_Admin');
			
			if($pracownik->maRole($kody_rol))
			{
				return $pracownik;
			}
			else
			{
				trigger_error('Błąd. Pracownik o id : '.$idPracownika.' nie posiada uprawnień do logowania się do zadań.', E_USER_ERROR);
				return false;
			}
		}
		else
		{
			trigger_error('Błąd. Nie można pobrać pracownika o id '.$idPracownika , E_USER_ERROR);
			return false;
		}
	}
	
	
	public function pobierzPracownikowTeamu($praktykant = false)
	{
		$listaPracownikow = array();
		foreach($this->_obiektTeam->idUsers as $idPracownika)
		{
			$pracownik = $this->pobierzPracownika($idPracownika);
			if( $praktykant )
				$listaPracownikow[] = $pracownik;
			else
				if($pracownik->praktykant == false) $listaPracownikow[] = $pracownik;
			
		}
		return $listaPracownikow;
	}
	
	/*
	 * tworzy obiekt Team
	 * 
	 * @param int idPracownika
	 * 
	 */
	private function ustawObiektTeamuDlaLidera($idPracownika)
	{
		$mapperEkipa = new Team\Mapper();
		$ekipa = $mapperEkipa->pobierzPoIdLidera($idPracownika);
		if($ekipa instanceof Team\Obiekt)
		{
			$this->_obiektTeam = $ekipa;
			return true;
		}
		else
		{
			// trigger_error('Błąd. Pracownik nie posiada aktywnego teamu lub nie jest liderem.', E_USER_ERROR);
			return false;
		}
	}
	
	
	/**
	 * Zwraca obiek Team dla danego lidera jeśli takie da się pobrać inaczej FALSE
	 *
	 * @return \Generic\Model\Team\Obiekt
	 */
	public function pobierzObiektTeamuDlaLidera()
	{
		
		if(isset($this->_obiektTeam) && $this->_obiektTeam->id > 0 )
		{
			return $this->_obiektTeam;
		}
		else
		{
			return false;
		}
		
	}

	/*
	 *  sprawdza czy pracownik ma wolne
	 */
	private function czyPracownikMaWolne($idPracownika)
	{
		$mapperTimelist = new Timelist\Mapper();
		$kryteria['data'] = date('Y-m-d');
		$kryteria['typy'] = $this->_zabronLogowaniaTypy;
		$czyWolne = $mapperTimelist->sprawdzCzyPracownikMaUrlop($idPracownika, $kryteria);
		
		if($czyWolne > 0)
			return true;
		else
			return false;
			
	}
	
	/*
	 *  ustawia obiekt Zamowienie
	 * 
	 * @param int idZamowienia
	 */
	protected function ustawZamowienie($idZamowienia)
	{
		$mapperZadanie = new Zamowienie\Mapper();
		$zamowienie = $mapperZadanie->pobierzPoId($idZamowienia);
		if($zamowienie instanceof Zamowienie\Obiekt)
		{
			$this->_obiektZamowienie = $zamowienie;
		}
		else
		{
			trigger_error('Błąd. Próba uzyskania dostępu do zamówienia które nie istnieje. (id zamowienia : '.$idZamowienia.')', E_USER_ERROR);
			return false;
		}
	}
	
	protected function ustawCenaZaGodzine()
	{
		if($this->_obiektTimelist->praktykant)
			$this->_obiektTimelist->cenaZaGodzine = Cms::inst()->config['bkt_cena_za_godzine']['praktykant'];
		else	
			$this->_obiektTimelist->cenaZaGodzine = Cms::inst()->config['bkt_cena_za_godzine']['ogolna'];
	}
	
	/*
	 * zapisuje obiekt Timelist
	 */
	protected function zapiszTimelist()
	{
		if(isset($this->_obiektTimelist))
		{
			$mapper = Cms::inst()->dane()->Timelist();
			if(isset($this->_obiektLider) && ( $this->_obiektLider->id == $this->_obiektTimelist->idUser) )
				$this->_obiektTimelist->lider = true;
			else
				$this->_obiektTimelist->lider = false;
			
			if($this->_obiektTimelist->zapisz($mapper))
			{
				return true;
			}
			else
			{
				trigger_error('Błąd. Nie można zapisać timelisty. ' , E_USER_ERROR);
				return false;
			}
		}
		else
		{
			trigger_error('Błąd. Obiekt timelist nie istnieje. ' , E_USER_ERROR);
			return false;
		}
	}

	/*
	 * sprawdza czy zadanie do którego team się loguje jest do niego przypisane
	 */
	protected function czyEkipaPrzypisanaDoZadania()
	{
		if(isset($this->_obiektZamowienie))
		{
			if($this->_obiektZamowienie->idTeam != $this->_obiektTeam->id)
			{
				$polaczenia = new Polaczenia\Obiekt();
				$przypisaneProjekty = $polaczenia->pobierzPolaczeniaDlaObiekt2($this->_obiektTeam, true, array('id_object_1'));
				if(in_array($this->_obiektZamowienie->id, array_keys(listaZTablicy($przypisaneProjekty, 'id_object_1'))))
				{
					return true;
				}
				elseif($this->sprawdzCzyLogowanieDoApartamentuMozliwe())
				{
					return true;
				}
				else
				{
					return false;
				}
			}
			else
				return true;
		}
		else
		{
			trigger_error('Błąd. Zamówienie do którego Team jest logowany nie istnieje.', E_USER_ERROR);
			return false;
		}
	}
	
	private function sprawdzCzyLogowanieDoApartamentuMozliwe()
	{
		if(isset($this->_obiektZamowienie))
		{
			if($this->_obiektZamowienie->idTeam == "" && $this->_obiektZamowienie->idParent > 0)
			{
				$rodzic = $this->_obiektZamowienie->pobierzParent();
				if($rodzic instanceof Zamowienie\Obiekt)
				{
					if(
						( isset( $rodzic->additionalData['pierwsza']['teamy']) && in_array( $this->_obiektTeam->id, array_keys($rodzic->additionalData['pierwsza']['teamy'])))
						||
						( isset( $rodzic->additionalData['druga']['teamy'] ) && in_array( $this->_obiektTeam->id, array_keys($rodzic->additionalData['druga']['teamy'])))
					)
					{
						$mapperTimelist = new Timelist\Mapper();
						$kryteria = array('!id_team' => $this->_obiektTeam->id, 'obecnie_zalogowany' => true);
						$zalogowaneTeamy = $mapperTimelist->pobierzPoIdZadania($this->_obiektZamowienie->id, $kryteria);
						if(count($zalogowaneTeamy) > 0)
						{
							return false;
						}
						return true;
					}
					else
					{
						return false;
					}
				}
				else
				{
					return false;
				}
			}
			else
			{
				return false;
			}
		}
		else
			return false;
	}
	/*
	 * sprawdza czy uzytkownik nie posiada aktywnych zadań
	 * 
	 * @param int idPracownika
	 * 
	 * @return Array lista niezakończonych zadań pracownika;
	 */
	protected function pobierzNiezakonczoneZadaniePracownika($idPracownika)
	{
		$nieZakonczoneZadania = array();
		$mapperTimelist = new Timelist\Mapper();
		$nieZakonczoneZadania = $mapperTimelist->zwracaTablice('id', 'data_start', 'id_object')->pobierzNiezakonczoneZadaniaPracownika($idPracownika);
		$iloscNiezkonczonychZadan = count($nieZakonczoneZadania);

		if($iloscNiezkonczonychZadan > 1)
		{
			trigger_error('Błąd. Pracownik o id '.$idPracownika.' posiada więcej niezkończonych zadań niż jedno. Ilość niezkończonych zadań : '.$iloscNiezkonczonychZadan , E_USER_ERROR);
			return false;
		}
		else
		{
				return $nieZakonczoneZadania;
		}
		
	}
	
	/*
	 * na podstawie przekazanego obiektu ustala jego Typ
	 * 
	 * @param obiekt
	 * 
	 * @return string typ obiektu
	 * 
	 */
	private function ustawTypObjektu($obiekt)
	{
		$chunks = explode('\\', get_class($obiekt));
		return $chunks[count($chunks)-2];
	}
	
	/**
	 * ustawia obiekt timelista dla Reklamacji na podstawie danych z reklamowanych wierszy timelisty
	 * 
	 * @param arra $daneTimelista
	 */
	private function ustawObiektTimelistyReklamacja(Timelist\Obiekt $daneTimelista, $zamowienie)
	{
		$this->_obiektTimelist = new Timelist\Obiekt();
		$this->_obiektTimelist->idProjektu = ID_PROJEKTU;
		$this->_obiektTimelist->idObject = $daneTimelista->idObject;
		$this->_obiektTimelist->object = $this->ustawTypObjektu($zamowienie);
		$this->_obiektTimelist->idTeam = $daneTimelista->idTeam;
		$this->_obiektTimelist->dataStart = $daneTimelista->dataStart;
		$this->_obiektTimelist->dataStop = $daneTimelista->dataStop;
		$this->_obiektTimelist->hours = $daneTimelista->hours;
		$this->_obiektTimelist->stawka = $daneTimelista->stawka;
		$this->_obiektTimelist->taxTable = $daneTimelista->taxTable;
		$this->_obiektTimelist->type = $daneTimelista->type;
	}
	
	
	private function ustawObiektTimelisty($idTimelist = null)
	{
		if($idTimelist == null)
		{
			$this->_obiektTimelist = new Timelist\Obiekt();
			$this->_obiektTimelist->idProjektu = ID_PROJEKTU;
			$this->_obiektTimelist->idObject = $this->_obiektZamowienie->id;
			$this->_obiektTimelist->object = $this->ustawTypObjektu($this->_obiektZamowienie);
			$this->_obiektTimelist->idTeam = $this->_obiektTeam->id;
		}
		else
		{
			$mapperTimelist = new Timelist\Mapper();
			$obiektTimelist = $mapperTimelist->pobierzPoId($idTimelist);
			if($obiektTimelist instanceof Timelist\Obiekt)
			{
				$this->_obiektTimelist = $obiektTimelist;
			}
			else
			{
				trigger_error('Błąd. Obiekt Timelist do którego próbujesz uzyskać dostęp nie istnieje id : '.$idTimelist , E_USER_ERROR);
				return false;
			}
		}
		
	}
	
	// ustawia typ zadania orders, night_hours - tylko jeśli pracownik posiada odpowiedni skill
	// todo dorobić sprawdzanie czy uzytkownik posiada uprawnienia do godzin nocnych
	protected function ustawTypTimelisty($typ)
	{
		$this->_obiektTimelist->type = $typ;
	}
	
	public function zaokraglMinuty($data)
	{
		$rok = date("Y", strtotime($data));
		$miesac = date("m", strtotime($data));
		$dzien = date("d", strtotime($data));
		$godziny = date("H", strtotime($data));
		$minuty = date("i", strtotime($data));
		
		$roundedMinutes = ($minuty % 15);
		if ($roundedMinutes > 7)
		{
			$minutyPoZmianie = $minuty + (15-$roundedMinutes);
		}
		else
		{
			$minutyPoZmianie = $minuty - $roundedMinutes;
		}
		
		if($minutyPoZmianie == 60)
		{
			$godziny = $godziny+1;
			$minutyPoZmianie = '00';
		}
		
		$dataString = $rok.'-'.$miesac.'-'.$dzien.' '.$godziny.':'.$minutyPoZmianie.':00';
		$nowaData = date("Y-m-d H:i:s", strtotime($dataString));
		
		return $nowaData;
	}
	
	// ustawia date rozpoczęcia zadania
	protected function ustawDataStart($val = null)
	{
		if($val != null)
			$data = $val;
		else
			$data = date("Y-m-d H:i");
	
		//$dataZaokraglona = $this->zaokraglMinuty($data);
		$dataReguly = $this->regulyDataStart($data);

		$this->_obiektTimelist->dataStart = $dataReguly;
		return $dataReguly;
	}
	
	private function regulyDataStart($data)
	{
		$nowaData = $data;
		$zamowieniaTypMapper = Cms::inst()->dane()->ZamowienieTyp();
		$obiektZamowieniaTyp = $zamowieniaTypMapper->pobierzPoId($this->_obiektZamowienie->idType);
		$konfiguracjaTypu = $obiektZamowieniaTyp->pobierzKonfiguracjeTypu();
		$konfiguracjaTypu['timelist']['godzina_start_pracy'];

		$godzinaStart = $konfiguracjaTypu['timelist']['godzina_start_pracy'];
		$wymaganyStart = date('G', strtotime($godzinaStart));
		$godzinaLogowania = date('G', strtotime($data));
		
		if( ($godzinaLogowania < $wymaganyStart) || ($godzinaLogowania > $wymaganyStart && $godzinaLogowania < 8) )
		{
			$rok = date("Y", strtotime($data));
			$miesac = date("m", strtotime($data));
			$dzien = date("d", strtotime($data));
			$minuty = date("i", strtotime($data));
		
			$dataString = $rok.'-'.$miesac.'-'.$dzien.' '.$wymaganyStart.':00:00';
			$nowaData = date("Y-m-d H:i:s", strtotime($dataString));
		}
		return $nowaData;
	}
	
	// ustaw date zakończenia zadania
	protected function ustawDataStop($val = null)
	{
		if($val != null)
			$data = $val;
		else
			$data = date("Y-m-d H:i");
		
		// $dataZaokraglona = $this->zaokraglMinuty($data);
		
		$this->_obiektTimelist->dataStop = $data;
		return $data;
	}
	
	// ustawia multiplier dla zadania
	protected function ustawMnoznik(Uzytkownik\Obiekt $pracownik, $wymuszonyPrzelicznik = null)
	{
		$czas = strtotime(date("H:i"));
		$multiplier = 1;
		$type = 'orders';
		
		foreach($this->_konfiguracjaTypow as $typ => $wartosc)
		{
			if( ($czas > strtotime($this->_konfiguracjaTypow[$typ]['przedzial_godzin_od'])) && (strtotime($this->_konfiguracjaTypow[$typ]['przedzial_godzin_do']) < $czas)  )
			{
				if(isset($this->_konfiguracjaTypow[$typ]['wymagane_umiejetnosci']) && in_array($this->_konfiguracjaTypow[$typ]['wymagane_umiejetnosci'], $pracownik->umiejetnosci))
				{
					$multiplier = $this->_konfiguracjaTypow[$typ]['przelicznik'];
					$type = $typ;
				}
			}
		}
		if($wymuszonyPrzelicznik != null)
		{
			$multiplier = $wymuszonyPrzelicznik;
		}
		$this->ustawTypTimelisty($type);
		$this->_obiektTimelist->multiplier = $multiplier;
	}
	
	// wylicza różnicę między data_start a data_stop
	public function wyliczIloscGodzin($dataStart, $dataStop)
	{
		$data_od = strtotime($this->zaokraglMinuty($dataStart));
		$data_do = strtotime($this->zaokraglMinuty($dataStop));
		if ( $data_od <= $data_do )
		{
			$roznicaDat = $data_do - $data_od;
			return round(($roznicaDat/3600),2);
		}
		else
		{
			$roznicaDat = $data_od - $data_do;
			if(isset($this->_obiektTimelist->multiplier))
			{
				$this->_obiektTimelist->multiplier = -($this->_obiektTimelist->multiplier);
			}
			return round(($roznicaDat/3600),2);
		}
	}
	
	// ustawia ilość przepracowanych godzin
	protected function ustawIloscGodzin($dataStart, $dataStop)
	{
		$dataStartReguly = $this->regulyDataStart($dataStart);
		$iloscGodzin = $this->wyliczIloscGodzin($dataStartReguly, $dataStop);
		$this->_obiektTimelist->hours = $iloscGodzin;
		return $iloscGodzin;
	}
	
	// ustawia stawke wykonania zadania
	protected function ustawStawke(Uzytkownik\Obiekt $pracownik)
	{
		$this->_obiektTimelist->stawka = $pracownik->stawkaGodzinowa;
	}
	
	// ustawia tabele podatkową
	protected function ustawPodatek(Uzytkownik\Obiekt $pracownik)
	{
		$this->_obiektTimelist->taxTable = $pracownik->tabelaPodatkowa;
	}
	
	// ustawia id pracownika w Timelist
	protected function ustawIdPracownika(Uzytkownik\Obiekt $pracownik)
	{
		$this->_obiektTimelist->idUser = $pracownik->id;
	}
	
	protected function ustawPraktykant(Uzytkownik\Obiekt $pracownik)
	{
		$praktykant = $pracownik->praktykant;
		if($pracownik->praktykant && $pracownik->praktykantDataDo != '')
		{
			$data = new \DateTime();
			$dataWaznosci = new \DateTime($pracownik->praktykantDataDo);
			if($data > $dataWaznosci)
				$praktykant = false;
		}
		$this->_obiektTimelist->praktykant = $praktykant;
	}

		// ładuje konfiguracje Typów Timelisty
	protected function pobierzKofiguracjeTypow()
	{
		$mapperKonfiguracja = new \Generic\Model\WierszKonfiguracji\Mapper();
		$typyListy = $mapperKonfiguracja->pobierzWartoscWierszaKonfiguracji('timelistPomocnik.typy', 'Timelist_Admin');
		
		// timelistPomocnik.typy_przedzial_godzin
		$listaKofiguracjiDlaTypow = array();
		
		foreach($typyListy as $nazwaTypu)
		{
			$konfiguracja = $mapperKonfiguracja->pobierzWartoscWierszaKonfiguracji('konfiguracja.typ.'.$nazwaTypu , 'Timelist_Admin');
			
			if($konfiguracja['zabron_logowania'])
			{
				$this->_zabronLogowaniaTypy[] = '\''.$nazwaTypu.'\'';
			}
			if($konfiguracja['przelicznik_godziny_logowania'])
			{
				$this->_konfiguracjaTypow[$nazwaTypu] = $konfiguracja;
			}
			
		}
	}
	
}
?>
