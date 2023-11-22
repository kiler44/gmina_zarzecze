<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\Zadanie;


/**
 * Obsluga sesji za pomoca standardowego mechanizmu PHP.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Sesja
{

	/**
	 * Nazwa sesji.
	 *
	 * @var string
	 */
	private $_nazwaSesji = "domyslna_sesja";



	/**
	 * Czas zycia sesji w sekundach.
	 *
	 * @var integer
	 */
	private $_czasZyciaSesji = 900;



	/**
	 * Czas zycia ciasteczka w sekundach.
	 *
	 * @var integer
	 */
	private $_czasZyciaCiasteczka = 0;



	/**
	 * Identyfikator sesji wygenerwany w PHP.
	 *
	 * @var string
	 */
	private $_idSesji;



	/**
	 * Konstruktor, startuje sesje.
	 *
	 * @param $parametry Parametry do konfiguracji sesji.
	 */
	function __construct($parametry = array())
	{

		// Set session parameters
		foreach ($parametry as $parametr => $wartosc)
		{
			switch ($parametr)
			{
				case 'nazwaSesji':
					$this->_nazwaSesji = $wartosc;
					break;

				case 'czasZyciaSesji':
					$this->_czasZyciaSesji = (int)$wartosc;
					break;

				case 'czasZyciaCiasteczka' :
					$this->_czasZyciaCiasteczka = (int)$wartosc;
					break;

				default:
					break;
			}
		}

		//ustawienia ciasteczek
		ini_set("session.use_cookies", true);
		ini_set("session.use_only_cookies", true);
		ini_set("session.cookie_lifetime", $this->_czasZyciaCiasteczka); // maksymalny czas zycia w sekundach, 0 - do zaminiecia przegladarki
		ini_set("session.cookie_httponly", false); // ciasteczko sesyjne niedostepne z poziomu javascript (XSS)

		// Ustawienia sesji
		ini_set("session.gc_maxlifetime", $this->_czasZyciaSesji); // czas miedzy kliknieciami

		session_name($this->_nazwaSesji);

		// odczytanie id wyslanych metoda POST (flash)
		/* 21.06.2011 wylaczane w celu przetestowania problemow z formularzem KL
		 * $idZadanie = Zadanie::pobierz($this->_nazwaSesji);
		if ($idZadanie != '')
		{
			setcookie($this->_nazwaSesji, $idZadanie, $this->_czasZyciaCiasteczka);
			session_id($idZadanie);
		}*/

		session_start();

		$browser = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';

		// zabezpieczenie przed przechwyceniem sesji(Session Fixation)
		if (!isset($_SESSION['id_check']))
		{
			//session_regenerate_id(true);
			$_SESSION['id_check'] = true;
		}
		if (isset($_SESSION['ip_check']) && isset($_SESSION['browser_check'])
			&& ($_SESSION['ip_check'] != Zadanie::adresIp() ||
				($_SESSION['browser_check'] != $browser
				/* && stripos($browser, 'flash') === false*/) //wyjatek dla flasha
			))
		{
			$tresc = '['.date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']).', '.Zadanie::wywolanyUrl().'] Proba przechwycenia sesji: '.Zadanie::adresIp().', '.$browser.', rozpoczeto z '.$_SESSION['ip_check'].', '.$_SESSION['browser_check']."\n";
			$plik = LOGI_KATALOG.'/'.date ("Y-m-d", $_SERVER['REQUEST_TIME']).'-sesja.log';
			error_log($tresc, 3, $plik);
			$this->zakoncz();
		}
		elseif(!isset($_SESSION['ip_check']) || !isset($_SESSION['browser_check']))
		{
			$_SESSION['ip_check'] = Zadanie::adresIp();
			$_SESSION['browser_check'] = $browser;
		}

		$this->_idSesji = session_id();
	}



	public function nazwaSesji()
	{
		return $this->_nazwaSesji;
	}



	public function idSesji()
	{
		return $this->_idSesji;
	}



	/**
	 * Pobiera wartosc zmiennej z sesji.
	 *
	 * @param $nazwa Nazwa zmiennej.
	 *
	 * @return mixed
	 */
	function & __get($nazwa)
	{
		return $_SESSION[$nazwa];
	}



	/**
	 * Ustawia wartosc zmiennej w sesji.
	 *
	 * @param $nazwa Nazwa zmiennej.
	 * @param $wartosc Nowa wartosc.
	 */
	function __set($nazwa, $wartosc)
	{
		return $_SESSION[$nazwa] = $wartosc;
	}



	/**
	 * Sprawdza obecnosc zmiennej w sesji.
	 *
	 * @param $nazwa Nazwa zmiennej.
	 *
	 * @return boolean
	 */
	function __isset($nazwa)
	{
		return isset($_SESSION[$nazwa]);
	}



	/**
	 * Usuwa zmienna z sesji.
	 *
	 * @param $nazwa Nazwa zmiennej.
	 */
	function __unset($nazwa)
	{
		unset($_SESSION[$nazwa]);
	}



	/**
	 * Konczy sesje i usuwa ciasteczko.
	 */
	function zakoncz()
	{
		setcookie($this->_nazwaSesji, "", 0, "/");
		session_destroy();
		$_SESSION = array();
	}

}


