<?php
namespace Generic\Biblioteka\Baza\Dekorator;
use Generic\Biblioteka\Baza;
use Generic\Biblioteka\Zadanie;


/**
 * Obsluga logowania do pliku zapytan do bazy danych.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */
class LogowanieZapytan extends Baza\Dekorator
{

	/**
	 * Przetrzymuje nazwe pliku loga.
	 *
	 * @var string
	 */
	private $plik = '';



	/**
	 * Przetrzymuje sformatowana tresc zapytan do zapisania w pliku.
	 *
	 * @var array
	 */
	private $zapytania = array();



	/**
	 * Konstruktor, przekazuje obiekt obslugujacy baze danych do wewnetrznej zmiennej.
	 *
	 * @param Baza_Interfejs $baza obiekt obslugujacy baze.
	 * @param string $plik plik do ktorego beda logowane zapytania.
	 */
	function __construct(Baza\Interfejs $baza, $plik)
	{
		parent::__construct($baza);
		$this->plik = (string)$plik;
	}



	/**
	 * Wysyla zapytanie SQL do bazy danych i zachowuje rezultat w postaci obiektu klasy PDOStatement.
	 * Zapisuje rowniez zapytanie i czas jego wykonania do wewnetrznej tablicy.
	 *
	 * @param string $sql zapytanie SQL.
	 */
	function zapytanie($sql)
	{
		$klucz = count($this->zapytania);
		$this->zapytania[$klucz]['sql'] = '['.$this->baza->pobierzIdentyfikator().']' . $sql;
		$this->zapytania[$klucz]['czas'] = 0;
		$this->baza->zapytanie($sql);
		$this->zapytania[$klucz]['czas'] = $this->baza->czasZapytania();
	}



	/**
	 * Destruktor, zapisuje wykonane zapytania do pliku loga
	 */
	function __destruct()
	{
		if (count($this->zapytania) > 0)
		{
			$zapytania = '';
			$suma = 0;
			foreach ($this->zapytania as $zapytanie)
			{
				$zapytania .= preg_replace('/[\s\n\t\r ]{1,}/' , ' ' ,$zapytanie['sql']).' ['.$zapytanie['czas']." s]\n";
				$suma += $zapytanie['czas'];
			}
			$user = \Generic\Biblioteka\Cms::inst()->profil();
			
			$tresc = "\n[".date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
            $_SERVER['USER'] = (isset($_SERVER['USER'])) ? $_SERVER['USER'] : 'cron';
			if ($user instanceof \Generic\Model\Uzytkownik\Obiekt) $tresc .= ', '.$user->login;
			$tresc .= (PHP_SAPI != 'cli') ? ', '.Zadanie::wywolanyUrl().', '.Zadanie::adresIp() : ', '.$_SERVER['SCRIPT_NAME'].', User: '.$_SERVER['USER'];
			$tresc .= ', Czas SQL: '.$suma.'s]'."\n".$zapytania;

			error_log($tresc, 3, $this->plik);
		}
	}

}
