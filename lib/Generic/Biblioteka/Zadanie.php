<?php
namespace Generic\Biblioteka;


/**
 * Obsluga zadania Http.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Zadanie
{

	/**
	 * Pobiera wartosc z tablicy REQUEST.
	 * Dodatkowo można zastosowac filtry w postaci funkcji z jednym paramertem
	 * Filtry można dodawac jako dodatkowe argumenty tej funkcji np. pobierz('id', 'intval');
	 *
	 * @param string $klucz Nazwa zmienej.
	 *
	 * @return mixed
	 */
	static function pobierz($klucz)
	{
		$filtry = func_get_args();
		array_shift($filtry);
		if (isset($_REQUEST[$klucz]))
		{
			$wartosc = $_REQUEST[$klucz];

			if (count($filtry) > 0)
			{
				foreach($filtry as $filtr)
				{
					$wartosc = self::filtruj($wartosc, $filtr);
				}
			}
		}
		else
		{
			$wartosc = null;
		}

		return $wartosc;
	}



	/**
	 * Pobiera tablice REQUEST.
	 * Dodatkowo można zastosowac filtry w postaci funkcji z jednym paramertem
	 * Filtry można dodawac jako dodatkowe argumenty tej funkcji np. pobierz('id', 'intval');
	 *
	 * @return array
	 */
	static function pobierzWszystkie()
	{
		$filtry = func_get_args();

		$tablica = array();
		foreach($_REQUEST as $klucz => $wartosc)
		{
			$tablica[$klucz] = $wartosc;

			if (count($filtry) > 0)
			{
				foreach($filtry as $filtr)
				{
					$tablica[$klucz] = self::filtruj($tablica[$klucz], $filtr);
				}
			}
		}

		return $tablica;
	}




	/**
	 * Pobiera wartosc z tablicy GET.
	 *
	 * @param string $klucz Nazwa zmiennej.
	 *
	 * @return mixed
	 */
	static function pobierzGet($klucz)
	{
		$filtry = func_get_args();
		array_shift($filtry);
		if (isset($_GET[$klucz]))
		{
			$wartosc = $_GET[$klucz];
			if (count($filtry) > 0)
			{
				foreach($filtry as $filtr)
				{
					$wartosc = self::filtruj($wartosc, $filtr);
				}
			}
		}
		else
		{
			$wartosc = null;
		}
		return $wartosc;
	}



	/**
	 * Pobiera wartosc z tablicy POST.
	 *
	 * @param string $klucz Nazwa zmiennej.
	 *
	 * @return mixed
	 */
	static function pobierzPost($klucz)
	{
		$filtry = func_get_args();
		array_shift($filtry);

		if (isset($_POST[$klucz]))
		{
			$wartosc = $_POST[$klucz];

			if (count($filtry) > 0)
			{
				foreach($filtry as $filtr)
				{
					$wartosc = self::filtruj($wartosc, $filtr);
				}
			}
		}
		else
		{
			$wartosc = null;
		}

		return $wartosc;
	}
	
	/**
	 * Pobiera wartosc z tablicy POST.
	 *
	 * @param string $klucz Nazwa zmiennej.
	 *
	 * @return mixed
	 */
	static function pobierzPlik($klucz)
	{
		$filtry = func_get_args();
		array_shift($filtry);

		if (isset($_FILES[$klucz]))
		{
			$wartosc = $_FILES[$klucz];

			if (count($filtry) > 0)
			{
				foreach($filtry as $filtr)
				{
					$wartosc = self::filtruj($wartosc, $filtr);
				}
			}
		}
		else
		{
			$wartosc = null;
		}

		return $wartosc;
	}


	/**
	 * Pobiera wartosc z tablicy COOKIE.
	 *
	 * @param string $klucz Nazwa zmiennej.
	 *
	 * @return mixed
	 */
	static function pobierzCookie($klucz)
	{
		$filtry = func_get_args();
		array_shift($filtry);

		if (isset($_COOKIE[$klucz]))
		{
			$wartosc = $_COOKIE[$klucz];

			if (count($filtry) > 0)
			{
				foreach($filtry as $filtr)
				{
					$wartosc = self::filtruj($wartosc, $filtr);
				}
			}
		}
		else
		{
			$wartosc = null;
		}

		return $wartosc;
	}



	/**
	 * Zwraca wartość wywolanego URL.
	 *
	 * @return string
	 */
	static function wywolanyUrl()
	{
		$url = '';
		if (isset($_SERVER['SERVER_NAME']))
		{
			$url .= Zadanie::protokol().'://';
			$url .= $_SERVER['SERVER_NAME'];
			$url .= isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '';
		}
		return $url;
	}



	/**
	 * Zwraca ciąg tekstowy zawierający parametry get z URL.
	 *
	 * @return string
	 */
	static function parametryGet()
	{
		return str_replace($_SERVER['SCRIPT_NAME'], '', $_SERVER['REQUEST_URI']);
	}



	/**
	 * Zwraca protokół przy pomocy ktorego wywołano zadanie.
	 *
	 * @return string
	 */
	static function protokol()
	{
		if (isset($_SERVER['HTTPS']))
			$protokol = 'https';
		elseif (!empty($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https' || !empty($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] == 'on') {
			$protokol = 'https';
		}
		else
			$protokol = ($_SERVER['SERVER_PORT'] == 443) ? 'https' : 'http';
		return $protokol;
	}



	/**
	 * Zwraca adres z ktorego pochodzi zadanie.
	 *
	 * @return string
	 */
	static function adresWywolujacego()
	{
		return (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : null);
	}



	/**
	 * Sprawdzenie czy zadanie przyszlo ajaxem
	 *
	 * @return boolean
	 */
	static function czyAjax()
	{
		return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && $_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest';
	}
	
	
	/**
	 * Sprawdzenie czy zadanie przyszlo do api
	 *
	 * @return boolean
	 */
	static function czyApi()
	{
		return (strpos($_SERVER['REQUEST_URI'], 'api') !== false);
	}
	


	/**
	 * Zwraca adres ip z ktorego pochodzi zadanie.
	 *
	 * @return string
	 */
	static function adresIp()
	{
		$ip = null;

		if (isset($_SERVER['REMOTE_ADDR']) && isset($_SERVER['HTTP_CLIENT_IP']))
		{
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (isset($_SERVER['REMOTE_ADDR']))
		{
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		elseif (isset($_SERVER['HTTP_CLIENT_IP']))
		{
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		}
		elseif (isset($_SERVER['HTTP_X_FORWARDED_FOR']))
		{
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		}

		if ($ip === null)
		{
			$ip = '0.0.0.0';
			return $ip;
		}
		if (strstr($ip, ','))
		{
			$x = explode(',', $ip);
			$ip = trim(end($x));
		}
		return $ip;
	}



	/**
	 * Zwraca czas zadania w formacie UNIX
	 *
	 * @return integer
	 */
	static function czasWywolania()
	{
		return (isset($_SERVER['REQUEST_TIME']) ? $_SERVER['REQUEST_TIME'] : null);
	}



	/**
	 * Filtrowanie zmiennej filtrem w postaci funkcji PHP np. stripslashes().
	 *
	 * @param mixed $wartosc wartosc zmiennej.
	 * @param string $filtr nazwa funkcji filtrujacej.
	 *
	 * @return mixed
	 */
	public static function filtruj($wartosc, $filtr)
	{
		if (is_array($wartosc))
		{
			foreach($wartosc as $k => $w)
			{
				$wartosc[$k] = self::filtruj($w, $filtr);
			}
		}
		else
		{
			$wartosc = $filtr($wartosc);
		}
		return $wartosc;
	}

}


