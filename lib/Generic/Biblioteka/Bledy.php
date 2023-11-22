<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\Bledy;
use Generic\Biblioteka\Cms;


/**
 * Przechwytywanie bledow
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
class Bledy
{

	/**
	 * Mechanizmy rejestrowania bledow
	 *
	 * @var array
	 */
	private $mechanizmy = array();


	/**
	 * Okresla czy przechwytujemy wyjatek czy blad
	 *
	 * @var boolean
	 */
	private $wyjatek = false;



	/**
	 * Dodaje nowy mechanizm do przechwytywania bledow.
	 *
	 * @param $mechanizm Obiekt rejestratora bledow.
	 */
	function dodajMechanizm(Bledy\Logowanie $mechanizm)
	{
		$this->mechanizmy[] = $mechanizm;
	}



	/**
	 * Rejestruje ta klase jako mechanizm przechwytywania bledow w php.
	 *
	 * @return boolean
	 */
	function rejestruj()
	{
		if (set_error_handler(array($this, 'przechwycBlad')) === false
			|| set_exception_handler(array($this, 'przechwycWyjatek')) === false
			|| register_shutdown_function(array($this, 'przechwycBladKrytyczny')))
		{
			trigger_error("Nie mozna ustawic przechwytywania bledow", E_USER_WARNING);
			return false;
		}
		else
		{
			return true;
		}
	}



	/**
	 * Wyrejestowuje mechanizm przechwytywania bledow w php.
	 */
	function wyrejestruj()
	{
		restore_error_handler();
		restore_exception_handler();
	}



	/**
	 * Przechwytuje bledy. Ustawiana przez set_error_handler().
	 *
	 * @param integer $poziomBledu Poziom.
	 * @param string $trescBledu Tresc bledu.
	 * @param string $plikBledu Plik w ktorym blad wystapil.
	 * @param integer $liniaBledu Linia w ktorej blad wystapil.
	 * @param array $dodatkoweArgumenty dodatkowe argumenty ktore moga byc dodane np. do funkcji trigger_error() tutaj nadpisany przez debug_backtrace()
	 */
	function przechwycBlad($poziomBledu, $trescBledu, $plikBledu, $liniaBledu, $dodatkoweArgumenty)
	{
		$stronaBledu = false;
		if ($this->wyjatek)
		{
			// sprawdzamy czy poziom bledu jest ustawiony i jezeli nie ma dodajemy domyslny
			$poziomBledu = ($poziomBledu > 0) ? $poziomBledu : E_ERROR;
			$this->wyjatek = false;
			$stronaBledu = true;
		}
		else
		{
			// jezeli nie wyjatek to w $dodatkoweArgumenty dodajemy sciezke wsteczna
			$dodatkoweArgumenty = debug_backtrace();
			array_shift($dodatkoweArgumenty);
		}
		foreach ($this->mechanizmy as $mechanizm)
		{
			$mechanizm->przechwyc($poziomBledu, $trescBledu, $plikBledu, $liniaBledu, $dodatkoweArgumenty);
		}
		if (in_array($poziomBledu, array(E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR)) && isset($_SERVER['HTTP_HOST']))
		{
			$stronaBledu = true;
		}
		if ($stronaBledu)
		{
			$cms = Cms::inst();
			cms_blad($cms->lang['bledy']['blad_aplikacji'], $cms->lang['bledy']['przerwane_przetwarzanie_strony'], 503);
		}
	}



	/**
	 * Przechwytuje wyjatki. Ustawiana przez set_exception_handler().
	 *
	 * @param Exception $exception przechwytywany wyjatek
	 */
	public function przechwycWyjatek(\Throwable $exception)
	{
		$this->wyjatek = true;
		$this->przechwycBlad($exception->getCode(), get_class($exception).': '.$exception->getMessage(), $exception->getFile(), $exception->getLine(), $exception->getTrace());
	}



	/**
	 * Przechwytuje bledy krytyczne. Ustawiana przez register_shutdown_function().
	 */
	public function przechwycBladKrytyczny()
	{
		$blad = error_get_last();
		if (is_array($blad) && count($blad) > 0)
		{
			$this->przechwycBlad($blad['type'], $blad['message'], $blad['file'], $blad['line'], array());
		}
	}
}


