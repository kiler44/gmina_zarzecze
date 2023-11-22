<?php
namespace Generic\Model\Platnosc;
use Generic\Biblioteka\ObiektDanych;
use Generic\Biblioteka\Cms;
use Generic\Model\Kategoria;
use Generic\Biblioteka\Router;
use Generic\Biblioteka\Platnosc as Platnosci;
use Generic\Model\Dokument;
use Generic\Biblioteka\Zadanie;
use Generic\Model\PlatnoscHistoria;


/**
 * Klasa odwzorowująca płatność.
 * @author Krzysztof Lesiczka, Dariusz Półtorak
 * @package dane
 *
 * show off @property, @property-read, @property-write
 *
 * @property integer $id
 * @property integer $idProjektu
 * @property integer $idUzytkownika
 * @property string $dataDodania
 * @property string $systemPlatnosci
 * @property string $kodModulu
 * @property integer $idKategoriiModulu
 * @property string $typObiektu
 * @property integer $idObiektu
 * @property float $kwota
 * @property string $waluta
 * @property string $opis
 * @property string $typPlatnosci
 * @property integer $status
 * @property string $imie
 * @property string $nazwisko
 * @property string $ulica
 * @property string $nrDomu
 * @property string $nrLokalu
 * @property string $kodPocztowy
 * @property string $miasto
 * @property string $wojewodztwo
 * @property string $kraj
 * @property string $telefon
 * @property string $email
 * @property string $daneWyslane
 * @property string $daneOdebrane
 *
 * dostepne tylko z poziomu cache
 * @property string $urlObiektu
 * @property string $urlAdministracyjnyObiektu
 * @property array $historia
 * @property ObiektDanych $powiazanyObiekt
 */

class Obiekt extends ObiektDanych
{

	const DO_USUNIECIA = true;

	/**
	 * pola obslugiwane przez obiekt
	 * @var array
	 */
	protected $_pola = array(
		'id',
		'idProjektu',
		'idUzytkownika',
		'dataDodania',
		'systemPlatnosci',
		'kodModulu',
		'idKategoriiModulu',
		'typObiektu',
		'idObiektu',
		'kwota',
		'waluta',
		'opis',
		'typPlatnosci',
		'status',
		'imie',
		'nazwisko',
		'ulica',
		'nrDomu',
		'nrLokalu',
		'kodPocztowy',
		'miasto',
		'wojewodztwo',
		'kraj',
		'email',
		'telefon',
		'daneWyslane',
		'daneOdebrane',
	);



	// dozwolone statusy wizytowki
	protected $_statusy = array(
		'nierozpoczeta',
		'nowa',
		'oczekujaca',
		'anulowana',
		'odrzucona',
		'zakonczona',
		'blad',
	);



	function ustawStatus($wartosc)
	{
		$this->poleSprawdzUstawWartosc('status', strtolower($wartosc), $this->_statusy);
		}



	function pobierzDostepneStatusy()
	{
		return $this->_statusy;
	}



	function ustawDaneWyslane(Array $wartosc)
	{
		unset($wartosc['']);
		$this->_wartosci['daneWyslane'] = (count($wartosc) > 0) ? serialize($wartosc) : '';
		if (!in_array('daneWyslane', $this->_zmodyfikowane)) $this->_zmodyfikowane[] = 'daneWyslane';
	}



	function pobierzDaneWyslane()
	{
		return (isset($this->_wartosci['daneWyslane']) && $this->_wartosci['daneWyslane'] != '') ? unserialize($this->_wartosci['daneWyslane']) : array();
	}



	function pobierzHistoria()
	{
		$this->_cache['historia'] = null;
		if ($this->id > 0)
		{
			$mapper = Cms::inst()->dane()->PlatnoscHistoria();
			$this->_cache['historia'] = $mapper->pobierzDlaPlatnosci($this->id);
		}
		return $this->_cache['historia'];
	}



	public function pobierzUrlObiektu()
	{
		$this->_cache['urlObiektu'] = null;

		$mapper = Cms::inst()->dane()->Kategoria();
		$kategoria = $mapper->pobierzPoId($this->idKategoriiModulu);

		if ($kategoria instanceof Kategoria\Obiekt && $kategoria->kodModulu == $this->kodModulu)
		{
			switch ($this->kodModulu)
			{
				case 'Dokumenty':
					$this->_cache['urlObiektu'] = Router::urlHttp($kategoria);
					break;

				default:
					$this->_cache['urlObiektu'] = '';
					break;
			}
		}
		return $this->_cache['urlObiektu'];
	}



	public function pobierzUrlAdministracyjnyObiektu()
	{
		$this->_cache['urlAdministracyjnyObiektu'] = null;

		$mapper = Cms::inst()->dane()->Kategoria();
		$kategoria = $mapper->pobierzPoId($this->idKategoriiModulu);

		if ($kategoria instanceof Kategoria\Obiekt && $kategoria->kodModulu == $this->kodModulu)
		{
			switch ($this->kodModulu)
			{
				case 'Dokumenty':
					$this->_cache['urlAdministracyjnyObiektu'] = Router::urlAdmin($kategoria, 'podgladDokumentu' ,array('id' => $this->idObiektu));
					break;

				default:
					$this->_cache['urlAdministracyjnyObiektu'] = '';
					break;
			}
		}
		return $this->_cache['urlAdministracyjnyObiektu'];
	}



	public function pobierzPowiazanyObiekt()
	{
		$this->_cache['powiazanyObiekt'] = null;

		switch ($this->_wartosci['typObiektu'])
		{
			case 'Dokument':
				$mapper = Cms::inst()->dane()->Dokument();
				$this->_cache['powiazanyObiekt'] = $mapper->pobierzPoId($this->_wartosci['idObiektu']);
				break;

			default:
				$this->_cache['powiazanyObiekt'] = null;
				break;
		}
		return $this->_cache['powiazanyObiekt'];
	}



	function potwierdz()
	{
		if ($this->id < 1) return false;

		$systemPlatnosci = new Platnosci\PlatnosciPl();
		$systemPlatnosci->ustawKonfiguracje(Cms::inst()->config['platnosci']);

		$dane = $systemPlatnosci->potwierdz($this);

		if ($this->aktualizujHistorie('potwierdzenie', $dane['wyslane'], $dane['odebrane']))
		{
			return (bool)$dane['status'];
		}
		else
		{
			trigger_error('Problem z aktualizacja historii dla platnosci '.$this->id, E_USER_WARNING);
			return false;
		}
	}



	function anuluj()
	{
		if ($this->id < 1) return false;

		$systemPlatnosci = new Platnosci\PlatnosciPl();
		$systemPlatnosci->ustawKonfiguracje(Cms::inst()->config['platnosci']);

		$dane = $systemPlatnosci->anuluj($this);

		if ($this->aktualizujHistorie('anulowanie', $dane['wyslane'], $dane['odebrane']))
		{
			return (bool)$dane['status'];
		}
		else
		{
			trigger_error('Problem z aktualizacja historii dla platnosci '.$this->id, E_USER_WARNING);
			return false;
		}
	}



	function aktualizujStatus()
	{
		if ($this->id < 1) return false;

		$systemPlatnosci = new Platnosci\PlatnosciPl();
		$systemPlatnosci->ustawKonfiguracje(Cms::inst()->config['platnosci']);

		$dane = $systemPlatnosci->status($this);

		if ($dane['status'] == '') return false;

		if ($this->aktualizujHistorie('status', $dane['wyslane'], $dane['odebrane']))
		{
			$this->status = $dane['status'];
			if ($this->zapisz(Cms::inst()->dane()->Platnosc()))
				return true;
			else
				return false;
		}
		else
		{
			trigger_error('Problem z aktualizacja historii dla platnosci '.$this->id, E_USER_WARNING);
			return false;
		}
	}



	public function aktualizujPowiazanyObiekt($usunieciePlatnosci = false)
	{
		if ($this->powiazanyObiekt instanceof Dokument\Obiekt)
		{
			$dokument = $this->powiazanyObiekt;

			if ($dokument->statusPlatnosci == 'oplacony' || $dokument->statusPlatnosci == 'wycofany')
			{
				return true;
			}

			$nowyStatus = '';
			if (in_array($this->status, array('odrzucona', 'anulowana', 'blad', 'nierozpoczeta')) || (bool)$usunieciePlatnosci)
			{
				$nowyStatus = 'nieoplacony';
			}
			elseif (in_array($this->status, array('nowa')))
			{
				$nowyStatus = 'oczekuje';
			}
			// zawiera statusy: "rozpoczęta", "oczekuje na odbiór" - platnosci.pl
			elseif (in_array($this->status, array('oczekujaca')))
			{
				$nowyStatus = 'wrealizacji';
			}
			elseif ($this->status == 'zakonczona')
			{
				$nowyStatus = 'oplacony';
			}

			if ($nowyStatus == '' || ! in_array($nowyStatus, $dokument->dostepneStatusyPlatnosci) )
			{
				trigger_error("Nie można okreslic statusu platnosci dokumentu {$dokument->id} dla transakcji {$this->id}", E_USER_WARNING);
				return false;
			}
			if ($nowyStatus == $dokument->statusPlatnosci)
			{
				return true;
			}

			$dokumentyMapper = Cms::inst()->dane()->Dokument();

			$dokument->statusPlatnosci = $nowyStatus;
			$zmienionoStatus = $dokument->zapisz($dokumentyMapper);

			if ($zmienionoStatus && $dokument->idRodzica > 0)
			{
				$dokumentNadrzedny = $dokumentyMapper->pobierzPoId($dokument->idRodzica);

				if ($dokumentNadrzedny instanceof Dokument\Obiekt && $dokumentNadrzedny->czyRatyOplacone()
					&& in_array($dokumentNadrzedny->statusPlatnosci, array('nieoplacony', 'oczekuje', 'wrealizacji')))
				{
					$dokumentNadrzedny->statusPlatnosci = 'oplacony';
					$zmienionoStatus = $dokumentNadrzedny->zapisz($dokumentyMapper);
				}
			}
			if ($zmienionoStatus)
			{
				$zmienionoStatus = $dokument->aktualizujPowiazane();
			}
			return $zmienionoStatus;
		}
		return true;
	}



	/**
	 * Sprawdza czy odebrane powiadomienie o sukcesie jest prawidlowe
	 *
	 * @return array
	 */
	public static function odbierzSukces()
	{
		$dane = array(
			'pos_id' => Zadanie::pobierz('pos_id', 'intval', 'abs'),
			'session_id' => Zadanie::pobierz('session_id', 'intval','abs'),
		);

		$konfiguracja = Cms::inst()->config['platnosci'];

		if ($dane['pos_id'] != intval($konfiguracja['id_punktu_sklepu']))
		{
			trigger_error("Nie zgadzają się dane punktu platnosci {$dane['pos_id']} lokalnie {$konfiguracja['id_punktu_sklepu']}", E_USER_WARNING);
			return;
		}
		if ($dane['session_id'] < 1)
		{
			trigger_error("Nieprawidlowy identyfikator platnosci {$dane['session_id']}", E_USER_WARNING);
			return;
		}

		return $dane;
	}



	/**
	 * Sprawdza czy odebrane powiadomienie o bledzie jest prawidlowe
	 *
	 * @return array
	 */
	public static function odbierzBlad()
	{
		$dane = array(
			'pos_id' => Zadanie::pobierz('pos_id', 'intval', 'abs'),
			'session_id' => Zadanie::pobierz('session_id', 'intval','abs'),
			'error_nr' => Zadanie::pobierz('error', 'intval','abs'),

		);

		$konfiguracja = Cms::inst()->config['platnosci'];

		if ($dane['pos_id'] != intval($konfiguracja['id_punktu_sklepu']))
		{
			trigger_error("Nie zgadzają się dane punktu platnolci {$dane['pos_id']} lokalnie {$konfiguracja['id_punktu_sklepu']}", E_USER_WARNING);
			return;
		}
		if ($dane['session_id'] < 1)
		{
			trigger_error("Nieprawidlowy identyfikator platnosci {$dane['session_id']}", E_USER_WARNING);
			return;
		}

		$systemPlatnosci = new Platnosci\PlatnosciPl();
		$systemPlatnosci->ustawKonfiguracje($konfiguracja);
		$dane = $systemPlatnosci->tlumaczOdebrane($dane);

		return $dane;
	}



	protected function aktualizujHistorie($operacja, $daneWyslane, $daneOdebrane)
	{
		if ($this->_wartosci['id'] < 1) return false;

		$wpis = new PlatnoscHistoria\Obiekt();

		$wpis->idPlatnosci = $this->_wartosci['id'];
		$wpis->dataDodania = date('Y-m-d H:i:s');
		$wpis->operacja = $operacja;
		$wpis->daneWyslane = serialize($daneWyslane);
		$wpis->daneOdebrane = serialize($daneOdebrane);

		return $wpis->zapisz(Cms::inst()->dane()->PlatnoscHistoria());
	}

}
