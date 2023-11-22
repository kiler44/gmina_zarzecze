<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\Katalog;


/**
 * Obsluguje operacje na pojedynczym katalogu.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Katalog
{

	/**
	 * Sciezka i nazwa katalogu.
	 *
	 * @var string
	 */
	protected $sciezkaKatalogu;



	/**
	 * Sprawdza czy katalog istnieje i opcjonalnie tworzy nowy.
	 *
	 * @param string $sciezkaNazwa Sciezka i nazwa katalogu.
	 * @param boolean $utworzNowy Czy tworzyc nowy jezeli nie znaleziono pliku.
	 * @param boolean $sprawdzPoprawnosc Czy zwrócić bład w przypadku braku katalogu
	 */
	public function __construct($sciezkaNazwa, $utworzNowy = false, $sprawdzPoprawnosc = true)
	{
		$sciezkaNazwa =  str_replace('//','\\',str_replace('\\','/',rtrim($sciezkaNazwa, "/")));
		if ($sciezkaNazwa != str_replace('//','\\',str_replace('\\','/',rtrim(realpath($sciezkaNazwa), "/"))) && $utworzNowy == false)
		{
			if ($sprawdzPoprawnosc)
			{
				trigger_error('Podano nieprawidlowa nazwe katalogu: '.$sciezkaNazwa, E_USER_ERROR);
			}
		}
		elseif (is_dir($sciezkaNazwa))
		{
			$this->sciezkaKatalogu = $sciezkaNazwa;
		}
		elseif ($utworzNowy)
		{
			$sciezkaNazwa = rtrim(preg_replace(array("/\\\\/", "/\/{2,}/"), "/", $sciezkaNazwa), "/");
			$e = explode("/", ltrim($sciezkaNazwa, "/"));
			if (substr($sciezkaNazwa, 0, 1) == "/") {
				$e[0] = "/".$e[0];
			}
			$c = count($e);
			$sciezka = $e[0];
			for ($i = 1; $i < $c; $i++) {
				if (!is_dir($sciezka) && !mkdir($sciezka)) return false;
				$sciezka .= "/".$e[$i];
			}
			if (mkdir($sciezkaNazwa))
			{
				$this->sciezkaKatalogu = $sciezkaNazwa;
			}
			else
			{
				trigger_error('Nie można utworzyć katalogu: '.$sciezkaNazwa, E_USER_WARNING);
			}
		}
		else
		{
			//trigger_error('To nie jest katalog: '.$sciezkaNazwa, E_USER_WARNING);
		}
	}



	/**
	 * Sprawdza czy katalog istnieje.
	 *
	 * @return boolean
	 */
	public function istnieje()
	{
		return is_dir($this->sciezkaKatalogu);
	}



	/**
	 * Sprawdza czy katalog ma prawa do zapisu.
	 *
	 * @return boolean
	 */
	public function doZapisu()
	{
		return is_writeable($this->sciezkaKatalogu);
	}



	/**
	 * Wyswietla informacje o katalogu w postaci tablicy.
	 *
	 * @return array
	 */
	public function info()
	{
		$info = array(
			'type' => filetype($this->sciezkaKatalogu),
			'size' => filesize($this->sciezkaKatalogu),
			'user' => fileowner($this->sciezkaKatalogu),
			'group' => filegroup($this->sciezkaKatalogu),
			'perms' => fileperms($this->sciezkaKatalogu),
			'mtime' => filemtime($this->sciezkaKatalogu),
		);
		return $info;
	}



	/**
	 * Kopiuje katalog do nowej lokalizacji i zwraca instancje obiektu Katalog dla kopii
	 *
	 * @param string $sciezkaNazwa Nowa lokalizacja i nazwa katalogu.
	 *
	 * @return Katalog
	 */
	public function kopiujDo($sciezkaNazwa)
	{
		if (!is_dir($sciezkaNazwa) && !mkdir($sciezkaNazwa))
		{
			return false;
		}
		$wynik = $this->kopiujDrzewo($this->sciezkaKatalogu, $sciezkaNazwa);
		if ($wynik['wszystkie'] == $wynik['skopiowane'])
		{
			return new Katalog($sciezkaNazwa);
		}
		return false;
	}


	/**
	 * Przenosi katalog do nowej lokalizacji i zwraca instancje obiektu Katalog dla kopii
	 *
	 * @param string $sciezkaNazwa Nowa lokalizacja i nazwa katalogu.
	 *
	 * @return boolean
	 */
	public function przeniesDo($sciezkaNazwa, $nadpisz = true)
	{
		if ($nadpisz == true && !is_dir($sciezkaNazwa) && !mkdir($sciezkaNazwa))
		{
			return false;
		}
		elseif ($nadpisz == false)
		{
			if (!file_exists($sciezkaNazwa))
			{
				if (!mkdir($sciezkaNazwa)) { return false; }
			}
			elseif (file_exists($sciezkaNazwa) && !is_dir($sciezkaNazwa))
			{
				$backupSciezkaNazwa = $sciezkaNazwa.'(%d)';
				$i = 0;
				while (file_exists($sciezkaNazwa))
				{
					$sciezkaNazwa = sprintf($backupSciezkaNazwa,++$i);
				}
				if (!mkdir($sciezkaNazwa)) { return false; }
			}
		}
		$wynik = $this->kopiujDrzewo($this->sciezkaKatalogu, $sciezkaNazwa, $nadpisz);
		if ($wynik['wszystkie'] == $wynik['skopiowane'] && $this->usunDrzewo($this->sciezkaKatalogu))
		{
			$this->sciezkaKatalogu = $sciezkaNazwa;
			return true;
		}
		return false;
	}



	/**
	 * Usuwa plik i niszczy obiekt.
	 *
	 * @return boolean
	 */
	public function usun()
	{
		return $this->usunDrzewo($this->sciezkaKatalogu);
	}



	/**
	 * Ustawia uprawnienia dla katalogu i podkatalogow
	 *
	 * @param string $kod Uprawnienia zapisane w formacie liczbowym (np. 0777).
	 *
	 * @return boolean
	 */
	public function ustawDostep($kod)
	{
		return $this->ustawDostepDrzewo($this->sciezkaKatalogu, $kod);
	}



	/**
	 * Zawartosc katalogu w postaci drzewa zapisanego w tablicy.
	 *
	 * @param integer $poziom Poziom zaglebienia.
	 *
	 * @return array
	 */
	public function pobierzZawartosc($poziom = 30)
	{
		return $this->pobierzDrzewo($this->sciezkaKatalogu, (int)$poziom);
	}



	/**
	 * Pobiera rekurencyjnie zawartosc katalogu i zwraca w postaci drzewa.
	 *
	 * @param string $sciezka Sciezka do katalogu
	 * @param integer $poziom Poziom zaglebienia drzewka.
	 *
	 * @return array
	 */
	protected function pobierzDrzewo($sciezka, $poziom)
	{
		$poziom = (int) $poziom;
		$elementy = array();
		if ($poziom > 0)
		{
			if ($uchwyt = opendir($sciezka))
			{
				while (false !== ($plik = readdir($uchwyt)))
				{
					$nowaSciezka = $sciezka.'/'.$plik;
					if ($plik != '.' && $plik != '..' && !is_link($nowaSciezka))
					{
						if (is_dir($nowaSciezka))
						{
							$elementy[$plik] = $this->pobierzDrzewo($nowaSciezka, $poziom-1);
						}
						elseif (is_file($nowaSciezka))
						{
							$elementy[$plik] = false;
						}
					}
				}
				closedir($uchwyt);
			}
		}
		return $elementy;
	}



	/**
	 * Kopiuje katalog z cala zawartoscia.
	 *
	 * @param string $zrodlo Katalog zrodlowy
	 * @param string $cel Katalog docelowy
	 *
	 * @return array
	 */
	protected function kopiujDrzewo($zrodlo, $cel, $nadpisz = true)
	{
		$elementy = array();
		$pliki = array();
		$pliki['wszystkie'] = 0;
		$pliki['skopiowane'] = 0;
		if ($uchwyt = opendir($zrodlo))
		{
			while (false !== ($plik = readdir($uchwyt)))
			{
				$noweZrodlo = $zrodlo.'/'.$plik;
				if (!$nadpisz && is_file($noweZrodlo) && $plik != '..' && $plik != '.')
				{
					$nazwa = explode('.',$plik);
					$rozszerzenie = array_pop($nazwa);
					$nazwa = implode('.',$nazwa);
					if (strlen($rozszerzenie)+1 >= strlen($plik))
					{
						$nazwa = $plik;
						$rozszerzenie = '';
					}
					else
					{
						if (trim($rozszerzenie) != '') { $rozszerzenie = '.'.$rozszerzenie; }
					}
					$i = 0;
					while (file_exists($cel.'/'.$plik))
					{
						$plik = sprintf('%s(%d)%s',$nazwa, ++$i, $rozszerzenie);
					}
				}
				$nowyCel = $cel.'/'.$plik;
				if ($plik != '.' && $plik != '..' && !is_link($noweZrodlo))
				{
					if (is_dir($noweZrodlo))
					{
						if (!file_exists($nowyCel) && mkdir($nowyCel, 0777))
						{
							$podkatalog = array();
							$podkatalog = $this->kopiujDrzewo($noweZrodlo, $nowyCel);
							$pliki['wszystkie'] += $podkatalog['wszystkie'];
							$pliki['skopiowane'] += $podkatalog['skopiowane'];
						}
						else
						{
							if ($nadpisz)
							{
								trigger_error('Nie mozna utworzyc katalogu '.$nowyCel, E_USER_WARNING);
							}
							else
							{
								$i = 0;
								$backupNowyCel = $nowyCel;
								while (file_exists($nowyCel))
								{
									$nowyCel = sprintf($backupNowyCel.'(%d)',++$i);
								}
								if (mkdir($nowyCel, 0777))
								{
									$podkatalog = array();
									$podkatalog = $this->kopiujDrzewo($noweZrodlo, $nowyCel);
									$pliki['wszystkie'] += $podkatalog['wszystkie'];
									$pliki['skopiowane'] += $podkatalog['skopiowane'];
								}
								else
								{
									trigger_error('Nie mozna utworzyc katalogu '.$nowyCel, E_USER_WARNING);
								}
							}
						}
					}
					elseif (is_file($noweZrodlo))
					{
						$pliki['wszystkie']++;
						$i = 0;
						$backupNowyCel = $nowyCel;
						while (file_exists($nowyCel))
						{
							$nowyCel = sprintf($backupNowyCel.'(%d)',++$i);
						}
						if (copy($noweZrodlo, $nowyCel))
						{
							$pliki['skopiowane']++;
						}
						else
						{
							trigger_error('Nie mozna skopiować pliku '.$noweZrodlo.' do lokalizacji '.$nowyCel, E_USER_WARNING);
						}
					}
				}
			}
			closedir($uchwyt);
		}
		return $pliki;
	}



	/**
	 * Usuwa katalog z cala zawartoscia.
	 *
	 * @param string $zrodlo Katalog do usuniecia.
	 *
	 * @return boolean
	 */
	protected function usunDrzewo($sciezka)
	{
		$elementy = array();
		if ($uchwyt = opendir($sciezka))
		{
			while (false !== ($plik = readdir($uchwyt)))
			{
				$nowaSciezka = $sciezka.'/'.$plik;
				if ($plik != '.' && $plik != '..')
				{
					if (is_dir($nowaSciezka))
					{
						$this->usunDrzewo($nowaSciezka);
					}
					else
					{
						unlink($nowaSciezka);
					}
				}
			}
			closedir($uchwyt);
		}
		return rmdir($sciezka);
	}



	/**
	 * Ustawia uprawnienia dla drzewa
	 *
	 * @param string $zrodlo Katalog dla ktorego maja byc ustawione uprawnienia.
	 * @param string $kod Uprawnienia zapisane w formacie liczbowym (np. 0777).
	 *
	 * @return boolean
	 */
	protected function ustawDostepDrzewo($sciezka, $kod)
	{

		$elementy = array();
		if ($uchwyt = opendir($sciezka))
		{
			while (false !== ($plik = readdir($uchwyt)))
			{
				$nowaSciezka = $sciezka.'/'.$plik;
				if ($plik != '.' && $plik != '..')
				{
					if (is_dir($nowaSciezka))
					{
						if (!$this->ustawDostepDrzewo($nowaSciezka, $kod))
						{
							return false;
						}
					}
					else
					{
						if (!chmod($nowaSciezka, $kod))
						{
							return false;
						}
					}
				}
			}
			closedir($uchwyt);
		}
		return chmod($sciezka, $kod);
	}



	public function __toString()
	{
		return $this->sciezkaKatalogu;
	}

}

class KatalogWyjatek extends \Exception {}

