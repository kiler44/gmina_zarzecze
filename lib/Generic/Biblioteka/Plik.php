<?php
declare(strict_types=1);
namespace Generic\Biblioteka;
use Generic\Biblioteka\Scanner;
use Generic\Biblioteka\smsApi\Exception;
use Generic\Model\Zalacznik;

/**
 * Obsluguje operacje na pojedynczym pliku.
 *
 * @author Krzysztof Lesiczka
 * @author Marcin Mucha
 * @package biblioteki
 */

class Plik
{
	//use Scanner\ScannerTrait;

	/**
	 * Sciezka i nazwa pliku.
	 *
	 * @var string
	 */
	protected $sciezkaPliku;

	private $info;



	/**
	 * Cache dla metody pobierzTrescPliku()
	 *
	 * @var array
	 */
	private static $tresciPlikow = array();



	/**
	 * Sprawdza czy plik istnieje i opcjonalnie tworzy nowy.
	 *
	 * @param string $sciezkaNazwa Sciezka i nazwa pliku.
	 * @param boolean $utworzNowy Czy tworzyc nowy jezeli nie znaleziono pliku.
	 */
	public function __construct(string $sciezkaNazwa, bool $utworzNowy = false)
	{
		$sciezkaNazwa = str_replace('/', DIRECTORY_SEPARATOR, $sciezkaNazwa);

		if (is_file($sciezkaNazwa))
		{
			$this->sciezkaPliku = $sciezkaNazwa;
			$this->info = $this->info();
		}
		elseif ($utworzNowy)
		{
			if (file_put_contents($sciezkaNazwa, '') !== false)
			{
				$this->sciezkaPliku = $sciezkaNazwa;
                $this->info = $this->info();
			}
			else
			{
				throw new Exception('Nie mozna utworzyc pliku: '.$sciezkaNazwa);
			}
		}
		else
        {
           // throw new Exception('Plik nie istnieje: '.$sciezkaNazwa);
        }
	}

    /**
     * @param int|null $usun usuwa plik jeśli virus
     * @return bool
     */
	public function skanuj(?int $usun = null) : bool
	{
	    //$wynikSkanuj = $this->skan($this->sciezkaPliku);
	    //if($usun && !$wynikSkanuj)
	     //   $this->usun();

		//return $wynikSkanuj;
        return true;
	}
	/**
	 * Sprawdza czy plik istnieje.
	 *
	 * @return boolean
	 */
	public function istnieje() : bool
	{
		return is_file($this->sciezkaPliku);
	}


	/**
	 * Wyswietla informacje o pliku w postaci tablicy.
	 *
	 * @return array
	 */
	public function info(): array
	{
        return array(
            'type' => filetype($this->sciezkaPliku),
            'size' => filesize($this->sciezkaPliku),
            'user' => fileowner($this->sciezkaPliku),
            'group' => filegroup($this->sciezkaPliku),
            'perms' => fileperms($this->sciezkaPliku),
            'mtime' => filemtime($this->sciezkaPliku),
        );
	}

	public function getType()
    {
        return $this->info['type'];
    }

    public function getMimeType()
    {
        return mime_content_type($this->sciezkaPliku);
    }

/*
    public function zapiszDoBazy()
    {
        $plik = self::unifikujNazwe();

        $zalacznikMapper = new Zalacznik\Mapper();

        $zalacznik = new Zalacznik\Obiekt();
        $zalacznik->idProjektu = ID_PROJEKTU;
        $zalacznik->idObject = $idObjektu;
        $zalacznik->object = $objekt;
        $zalacznik->idAuthor = Cms::inst()->profil()->id;
        $zalacznik->file = $this->sciezkaPliku;
        return $zalacznik->zapisz($zalacznikMapper);
    }
*/


	/**
	 * Kopiuje plik do nowej lokalizacji i zwraca instancje obiektu Plik dla kopii
	 *
	 * @param string $sciezkaNazwa Nowa lokalizacja i nazwa pliku.
	 *
	 * @return Plik
	 */
	public function kopiujDo(string $sciezkaNazwa) : ?Plik
	{
		if ($this->istnieje() && copy($this->sciezkaPliku, $sciezkaNazwa))
		{
			$klasa = get_class($this);
			return new $klasa($sciezkaNazwa);
		}
		else
            return null;
	}



	/**
	 * Przenosi plik do nowej lokalizacji i zwraca instancje obiektu Plik dla kopii
	 *
	 * @param string $sciezkaNazwa Nowa lokalizacja i nazwa pliku.
	 *
	 * @return boolean
	 */
	public function przeniesDo( string $sciezkaNazwa ) : bool
	{
		if ($this->istnieje() && rename($this->sciezkaPliku, $sciezkaNazwa))
		{
			$this->sciezkaPliku = $sciezkaNazwa;
			return true;
		}
		else
		{
			return false;
		}
	}
	


	/**
	 * Usuwa plik i niszczy obiekt.
	 *
	 * @return boolean
	 */
	public function usun() : bool
	{
		return unlink($this->sciezkaPliku);
	}



	/**
	 * Ustawia uprawnienia do pliku
	 *
	 * @param string $kod Uprawnienia zapisane w formacie liczbowym (np. 0777).
	 *
	 * @return boolean
	 */
	public function ustawDostep( string $kod ) : bool
	{
		return chmod($this->sciezkaPliku, $kod);
	}



	/**
	 * Pobiera zawartosc pliku.
	 *
	 * @return mixed
	 */
	public function pobierzZawartosc()
	{
		if (!is_readable($this->sciezkaPliku)) return null;

		if( ($zawartosc = file_get_contents($this->sciezkaPliku)) == false)
            $zawartosc = null;

		return $zawartosc;
	}



	/**
	 * Ustawia nowa zawartosc pliku.
	 *
	 * @param mixed $zawartosc Nowa zawartosc pliku.
	 * @param boolean $dopisz Czy dopisac tresc na koncu pliku.
	 *
	 * @return boolean
	 */
	public function ustawZawartosc($zawartosc, bool $dopisz = false) : bool
	{
	    if($dopisz)
            $zapisanoBajtow = file_put_contents($this->sciezkaPliku, $zawartosc, FILE_APPEND);
	    else
            $zapisanoBajtow = file_put_contents($this->sciezkaPliku, $zawartosc);

		return ($zapisanoBajtow !== false) ? true : false;
	}



	public function __toString() : string
	{
		return $this->sciezkaPliku;
	}



	/**
	 * Poprawia nazwe zostawiajac tylko litery, cyfry i podkreslnik
	 *
	 * @param string $nazwa Nazwa pliku do poprawienia.
	 *
	 * @return string
	 */
	public static function unifikujNazwe($nazwa)
	{
		$dozwolonyZnak = '-';

		$niechcianeZnaki = array(
			'!', '@', '#', '$', '%', '^', '&', '*', '(', ')', '=', '~', '`', '|',
			'{', '}', '[', ']', ':', '"', ';', '\'', '<', '>', '?', '/', '\\', ',',
			"%20",
			"%22",
			"%3c",	// <
			"%253c",// <
			"%3e",	// >
			"%0e",	// >
			"%28",	// (
			"%29",	// )
			"%2528",// (
			"%26",	// &
			"%24",	// $
			"%3f",	// ?
			"%3b",	// ;
			"%3d"	// =
		);
		//zamieniamy niechciane znaki
		$nazwa = str_replace($niechcianeZnaki, $dozwolonyZnak, $nazwa);

		$polskieZnaki = array(
			//UTF-8
			"\xc4\x85" => "a", "\xc4\x84" => "A", "\xc4\x87" => "c", "\xc4\x86" => "C", "\xc4\x99" => "e", "\xc4\x98" => "E",
			"\xc5\x82" => "l", "\xc5\x81" => "L", "\xc5\x84" => "n", "\xc5\x83" => "N", "\xc3\xb3" => "o", "\xc3\x93" => "O",
			"\xc5\x9b" => "s", "\xc5\x9a" => "S", "\xc5\xbc" => "z", "\xc5\xbb" => "Z", "\xc5\xba" => "z", "\xc5\xb9" => "Z",
			//WINDOWS-1250
			"\xb9" => "a", "\xa5" => "A", "\xe6" => "c", "\xc6" => "C", "\xea" => "e", "\xca" => "E",
			"\xb3" => "l", "\xa3" => "L", "\xf1" => "n", "\xd1" => "N", "\xf3" => "o", "\xd3" => "O",
			"\x9c" => "s", "\x8c" => "S", "\x9f" => "z", "\xaf" => "Z", "\xbf" => "z", "\xac" => "Z",
			//ISO-8859-2
			"\xb1" => "a", "\xa1" => "A", "\xe6" => "c", "\xc6" => "C", "\xea" => "e", "\xca" => "E",
			"\xb3" => "l", "\xa3" => "L", "\xf1" => "n", "\xd1" => "N", "\xf3" => "o", "\xd3" => "O",
			"\xb6" => "s", "\xa6" => "S", "\xbc" => "z", "\xac" => "Z", "\xbf" => "z", "\xaf" => "Z",
		);
		// zamieniamy polskie znaki i zmieniamy na male litery
		$nazwa = strtolower(strtr($nazwa, $polskieZnaki));

		// usuwamy niedozwolonym znakiem
		$nazwa = preg_replace('/[^0-9a-z\-_.]+/', $dozwolonyZnak, $nazwa);

		// redukujemy liczbę podkreslen do jednego obok siebie
		$nazwa = preg_replace('/[\-]+/', $dozwolonyZnak, $nazwa);

		// usuwamy niektore znaki na początku i końcu
		$nazwa = pathinfo($nazwa);
		$nazwa['filename'] = trim($nazwa['filename'], "_-. \t\n\r\0\x0B");
		$nazwa = $nazwa['filename'].((isset($nazwa['extension'])) ? '.'.$nazwa['extension'] : '');

		return $nazwa;
	}




	/**
	 * Pobiera tresc pliku o podanej sciezce i umieszcza w wewnętrznym cache
	 *
	 * @param string $sciezka Sciezka pliku.
	 *
	 * @return string
	 */
	public static function pobierzTrescPliku($sciezka)
	{
		$hash = md5($sciezka);
		if ( ! isset(self::$tresciPlikow[$hash]))
		{
			self::$tresciPlikow[$hash] = file_get_contents($sciezka);
		}
		return self::$tresciPlikow[$hash];
	}



	/**
	 * Laduje zbiorczy plik z trescia plikow do wewnetrznej zmiennej
	 *
	 * @param string $sciezka Sciezka pliku zbiorczego.
	 */
	public static function ladujTrescPlikow($sciezka)
	{
		include $sciezka;
	}



	/**
	 * Zapisuje tresc wewnetrznej zmiennej do pliku o podanej sciezce
	 *
	 * @param string $sciezka Sciezka pliku.
	 */
	public static function zapiszTrescPlikow($sciezka)
	{
		file_put_contents($sciezka, '<?php
        namespace Generic\Biblioteka;
        self::$tresciPlikow = '.var_export(self::$tresciPlikow, true).";\n");
	}
}

class PlikWyjatek extends \Exception {}

