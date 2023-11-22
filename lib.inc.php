<?php
use Generic\Biblioteka\DefinicjaObiektu;

use Generic\Model\Aktualnosc\Definicja;

use Generic\Library\File;
use Generic\Biblioteka\Katalog;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\Zadanie;

/* -------------------------------------------------------------------------- */
/* Przeniesienie ładowania cache z pliku index.php */
/*
$cfg = konfiguracjaCzytajPlik(true);
$cache_php = $cfg['cache']['php'];

$plik_boot_cache_php = CACHE_KATALOG.'/php/boot.php';
if ($cache_php && is_file($plik_boot_cache_php))
{
	include_once $plik_boot_cache_php;
}*/
/* -------------------------------------------------------------------------- */


function utworzObiektRaz($nazwa)
{
	static $obiekt = array();
	if (isset($obiekty[$nazwa]))
	{
		$obiekt = $obiekty[$nazwa];
	}
	else
	{
		$klasa = $nazwa;
		if (class_exists($nazwa))
		{
			$obiekt = new $klasa;
			$obiekty[$nazwa] = $obiekt;
		}
		else
			trigger_error('Nie można załadować klasy: '.$klasa, E_USER_ERROR);
	}
	return $obiekt;
}

function konfiguracjaCzytajPlik($wymus = false)
{
	static $wczytac = true;
	static $cfg = array();
	if ($wczytac || $wymus)
	{
		$plik = TEMP_KATALOG.'/config.inc.php';
		if (is_file($plik) && is_readable($plik))
		{
			$cfg = include($plik);
			if (is_array($cfg))
				$wczytac = false;
			else
				$cfg = array();
		}
	}
	return $cfg;
}

function vdd($var)
{
    echo "<pre style='margin-top: 50px'>\n";
    var_dump($var);
    echo "</pre>\n";
    die;
}

function dd($var)
{
    echo "<pre style='margin-top: 50px'>\n";
    print_r($var);
    echo "</pre>\n";
    die;
}

function dump($var)
{
	echo "<pre style='margin-top: 50px'>\n";
	print_r($var);
	echo "</pre>\n";
}


function vdump($var)
{
	echo "<pre style='margin-top: 50px'>\n";
	var_dump($var);
	echo "</pre>\n";
}


function cms_blad($tytul, $tresc, $kod = '', $szablon = null)
{
	if ($szablon == null)
	{
		$szablon = '/' . SZABLON_SYSTEM . '/cms_blad.tpl';
	}

	$tresc = '<p>'.implode('</p><p>', ( ! is_array($tresc)) ? array($tresc) : $tresc).'</p>';
	$blad = file_get_contents(CMS_KATALOG.$szablon);
	$blad = str_replace('{{$tytul_strony}}', $tytul, $blad);
	$blad = str_replace('{{$tresc_bledu}}', $tresc, $blad);
	$blad = str_replace('{$DOMENA}', defined('DOMENA') ? DOMENA : $_SERVER['SERVER_NAME'], $blad);

	if (!headers_sent())
	{
		switch (intval($kod))
		{
			case 403:
				header("HTTP/1.1 403 Forbidden");
				break;

			case 404:
				header("HTTP/1.1 404 Not Found");
				break;

			case 500:
				header("HTTP/1.1 500 Internal Server Error");
				break;

			case 503:
				header('HTTP/1.1 503 Service Temporarily Unavailable');
				header('Status: 503 Service Temporarily Unavailable');
				header('Retry-After: '.(6*60*60)); // Mozna probowac odwiedzic serwis za 6 godzin
				break;

			default: break;
		}
	}
	echo $blad;
	exit;
}



function cms_blad_404($tytul, $tresc, $szablon = null)
{
	if ($szablon == null)
	{
		$szablon = '/' . SZABLON_SYSTEM . '/cms_blad_404.tpl';
	}

	$tresc = '<p>'.implode('</p><p>', ( ! is_array($tresc)) ? array($tresc) : $tresc).'</p>';
	$blad = file_get_contents(CMS_KATALOG.$szablon);
	$blad = str_replace('{{$tytul_strony}}', $tytul, $blad);
	$blad = str_replace('{{$tresc_bledu}}', $tresc, $blad);
	$blad = str_replace('{$DOMENA}', defined('DOMENA') ? DOMENA : $_SERVER['SERVER_NAME'], $blad);

	if (!headers_sent())
		header("HTTP/1.1 404 Not Found");

	echo $blad;
	exit;
}


function losowyKlucz($dlugosc)
{
	$klucz = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$wynik = '';
	for($i = 0; $i < $dlugosc; $i++) {
		$temp = str_shuffle($klucz);
		$znak = mt_rand(0, strlen($temp)-1);
		$wynik .= $klucz[$znak];
	}
	return $wynik;
}
function masort(&$data, $sortby)
{
    static $sort_funcs = array();
    if (empty($sort_funcs[$sortby]))
    {
        foreach (explode(',', $sortby) as $key)
        {
            $array = array_pop($data);
            array_push($data, $array);
            if (isset($array[$key]) && is_numeric($array[$key]))
            {
                uasort($data, array(new TermMetaCmpClosure($key), "numeric"));
                //uasort($data, 'sortNumeric');

            }
            else
            {
                uasort($data, array(new TermMetaCmpClosure($key), "string"));
            }
        }
    }
    else
    {
        uasort($data, 'sortNumeric');
    }
}

function sortNumeric($a, $b, $klucz = 'lewy')
{
    $c = 0;
    if ( $c = (($a[$klucz] == $b[$klucz]) ? 0:(($a[$klucz] < $b[$klucz]) ? -1 : 1 )) ) return $c;
    return $c;
}

function sortString($a, $b, $klucz = 'lewy')
{
    $c = 0;
    if ( ($c = strcasecmp($a[$klucz], $b[$klucz])) != 0 ) return $c;
    return $c;
}

function sortNumericMa($a, $b, $klucz = 'lewy')
{
    $c = 0;
    if ( $c = (($a[$klucz] == $b[$klucz]) ? 0:(($a[$klucz] > $b[$klucz]) ? -1 : 1 )) ) return $c;
    return $c;
}




function marsort(&$data, $sortby)
{
    static $sort_funcs = array();
    if (empty($sort_funcs[$sortby]))
    {

        foreach (explode(',', $sortby) as $key)
        {
            $array = array_pop($data);
            array_push($data, $array);
            if (is_numeric($array[$key]))
            {
                uasort($data, array(new TermMetaCmpClosure($key), "numericMa"));
            }
            else
            {
                uasort($data, array(new TermMetaCmpClosure($key), "string"));
            }
        }

    }
    else
    {
        uasort($data, 'sortNumericMa');
    }

}

class TermMetaCmpClosure
{
    private $meta;

    function __construct( $meta ) {
        $this->meta = $meta;
    }

    function numeric( $a, $b ) {
        return sortNumeric($a, $b, $this->meta);
    }
    function numericMa( $a, $b ){
        return sortNumericMa($a, $b, $this->meta);
    }
    function string( $a, $b ) {
        return sortString($a, $b, $this->meta);
    }
}


function &array_merge_recursive_distinct(array &$array1, &$array2 = null)
{
	$merged = $array1;

	if (is_array($array2))
		foreach ($array2 as $key => $val)
			if (is_array($array2[$key]))
				$merged[$key] = (isset($merged[$key]) && is_array($merged[$key])) ? array_merge_recursive_distinct($merged[$key], $array2[$key]) : $array2[$key];
			else
				$merged[$key] = $val;

	return $merged;
}



function listaZTablicy(array $tablica, $kolumnaKlucz = null, $kolumnaWartosc = null)
{
	$wynik = array();
	if ($kolumnaKlucz != '')
        if (is_array($kolumnaWartosc))
            foreach ($tablica as $wiersz) $wynik[$wiersz[$kolumnaKlucz]] = $wiersz[$kolumnaWartosc[0]].' '.$wiersz[$kolumnaWartosc[1]];
		else if ($kolumnaWartosc != '')
			foreach ($tablica as $wiersz) $wynik[$wiersz[$kolumnaKlucz]] = $wiersz[$kolumnaWartosc];
		else
			foreach ($tablica as $wiersz) $wynik[$wiersz[$kolumnaKlucz]] = $wiersz;
	else
		if ($kolumnaWartosc != '')
			foreach ($tablica as $wiersz) $wynik[] = $wiersz[$kolumnaWartosc];
		else
			return $tablica;
	return $wynik;
}



function listaZObiektow(array $obiekty, $kolumnaKlucz = null, $kolumnaWartosc = null)
{
	$wynik = array();
	if ($kolumnaKlucz != '')
		if ($kolumnaWartosc != '')
			foreach ($obiekty as $obiekt) $wynik[$obiekt->$kolumnaKlucz] = $obiekt->$kolumnaWartosc;
		else
			foreach ($obiekty as $obiekt) $wynik[$obiekt->$kolumnaKlucz] = $obiekt;
	else
		if ($kolumnaWartosc != '')
			foreach ($obiekty as $obiekt) $wynik[] = $obiekt->$kolumnaWartosc;
		else
			return $obiekty;
	return $wynik;
}



function str_cut($string, $max_length, $add_dots = true, $cut_first_word = true)
{
	if (mb_strlen($string) > $max_length)
	{
		$add_dots = ((bool)$add_dots === true) ? '...' : '';

		//Sprawdzenie czy nie przetniemy pierwszego wyrazu w stringu jesli tak wyswietlamy pierwszy wyraz
		$pos = mb_strpos($string, ' ');
		if($pos > $max_length && $cut_first_word == false)
			return mb_substr($string, 0, $pos).$add_dots;

		$string = mb_substr($string, 0, $max_length);
		$pos = mb_strrpos($string, ' ');
		if ($pos === false)
		{
			return mb_substr($string, 0, $max_length).$add_dots;
		}
		return mb_substr($string, 0, $pos).$add_dots;
	}
	else
	{
		return $string;
	}
}



function cut_word($string, $word_number)
{
	$stringArray = explode(' ', $string);
	if(count($stringArray) > (int) $word_number)
	{
		return implode(' ', array_slice($stringArray, 0, (int) $word_number));
	}
	else
		return $string;
}



function filename_cut($filename, $max_length, $add_dots = true)
{
	$max_length = (int)$max_length;
	if ($max_length > 0 && mb_strlen($filename) > $max_length)
	{
		$pos = mb_strrpos($filename, '.');
		$ext = ($pos===false) ? '' : mb_substr($filename, $pos); // pobieramy rozszerzenie
		$filename = mb_substr($filename, 0, $pos); // ucinamy rozszerzenie
		$temp = str_replace(array('_','-','.'),' ', $filename); // zamieniamy przerywniki na spacje
		$pos = mb_strrpos($temp, ' ', (($max_length-20 > 0) ? $max_length-20 : 0));
		if ($pos === false)
		{
			//jeżeli znaleziono spacje w zakresie od $max_length-20 do $max_length-20 to ucinamy tam gdzie jest spacja
			$filename = mb_substr($filename, 0, $pos);
		}
		else
		{
			//jeżeli nie znaleziono spacji to ucinamy tam gdzie wskazuje $max_length
			$filename = mb_substr($filename, 0, $max_length);
		}
		$add_dots = ((bool)$add_dots === true) ? '...' : '';

		return $filename.$add_dots.$ext;
	}
	else
	{
		return $filename;
	}
}



function st_strip_tags($input)
{
	$dozwolone_tagi = array(
		'<strong>', '<em>', '<ol>', '<ul>', '<li>', '<sup>', '<sub>', '<p>',
	);

	$regex = '#\s*<(/?\w+)\s+[^>]*\s*>#i';
	return preg_replace($regex, '<${1}>',strip_tags($input, implode('', $dozwolone_tagi)));
}



function will_strip_tags($str) {
	$dozwolone_tagi = array(
		'<strong>', '<em>', '<ol>', '<ul>', '<li>', '<sup>', '<sub>', '<p>', '<u>', '<strike>', '<blockquote>',
	);

	do {
		$count = 0;
		$str = preg_replace('/(<)([^>]*?<)/' , '&lt;$2' , $str , -1 , $count);
	} while ($count > 0);
	$regex = '#\s*<(/?\w+)\s+[^>]*\s*>#i';
	$str = preg_replace($regex, '<${1}>',strip_tags($str, implode('', $dozwolone_tagi)));
	return $str;
}

/**
 * Metoda dopuszcza tagi z wybranymi atrybutami.
 * UWAGA: jeżeli tag ma kilka atrybutów to dopuszczany jest tylko pierwszy z nich
 * @param type $str
 * @return type
 */
function will_strip_tags_without_attributes($str) {
	$dozwolone_tagi = array(
		'<strong>', '<em>', '<ol>', '<ul>', '<li>', '<sup>', '<sub>', '<p>', '<u>', '<strike>', '<blockquote>',
	);

	$dozwolone_atrybuty = array('style', 'class');

	do {
		$count = 0;
		$str = preg_replace('/(<)([^>]*?<)/' , '&lt;$2' , $str , -1 , $count);
	} while ($count > 0);

	$regex = "#\s*<(/?\w+)\s+((" . implode('|', $dozwolone_atrybuty) . ")=[\"'][^>'\"]*['\"])?[^>]*\s*>#i";
	$str = preg_replace($regex, '<${1} ${2}>',strip_tags($str, implode('', $dozwolone_tagi)));
	return $str;
}


function tylkoCyfry($tekst)
{
	$cyfry = array('0','1','2','3','4','5','6','7','8','9');
	$tekst = str_split($tekst);
	foreach ($tekst as $klucz => $znak)
	{
		if (!in_array($znak, $cyfry)) unset($tekst[$klucz]);
	}
	return implode('',$tekst);
}



function tylkoLitery($tekst)
{
	$litery = array(
		'a','b','c','d','e','f','g','h','i','j','k','l','m','n','o','p','q','r','s','t','u','w','v','x','y','z',
		'A','B','C','D','E','F','G','H','I','J','K','L','M','N','O','P','Q','R','S','T','U','W','V','X','Y','Z',
	);
	$tekst = str_split($tekst);
	foreach ($tekst as $klucz => $znak)
	{
		if (!in_array($znak, $litery)) unset($tekst[$klucz]);
	}
	return implode('',$tekst);
}



function html2txt($document)
{
	$search = array(
		'@<script[^>]*?>.*?</script>@si',   // Strip out javascript
		'@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
		'@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
		'@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments including CDATA
	);
	return preg_replace($search, '', $document);
}



function filtr_xss($wartosc)
{
	// Zabezpiecza przed podobnymi: ja	vascript
	if (mb_strpos($wartosc, "\t") !== FALSE)
	{
		$wartosc = str_replace("\t", ' ', $wartosc);
	}

	/*
	 * neutralizuje niebezpieczne elementy jezyka
	 *
	 * Np wartosc:	eval('some code')
	 * Zamieni na:	eval&#40;'some code'&#41;
	 */
	$wartosc = preg_replace('#(alert|cmd|passthru|eval|exec|expression|system|fopen|fsockopen|file|file_get_contents|readfile|unlink)(\s*)\((.*?)\)#si', "\\1\\2&#40;\\3&#41;", $wartosc);

	$niedozwolone_str = array(
		'document.cookie'	=> '[removed]',
		'document.write'	=> '[removed]',
		'.parentNode'		=> '[removed]',
		'.innerHTML'		=> '[removed]',
		'window.location'	=> '[removed]',
		'-moz-binding'		=> '[removed]',
		'<!--'				=> '&lt;!--',
		'-->'				=> '--&gt;',
		'<![CDATA['			=> '&lt;![CDATA[',
		'<?php'				=> '&lt;?php',
		'<?php'				=> '&lt;?PHP',
		'<?php'				=> '&lt;?',
		'?'.'>'				=> '?&gt;',
	);

	$niedozwolone_regex = array(
		"javascript\s*:"			=> '[removed]',
		"expression\s*(\(|&\#40;)"	=> '[removed]', // CSS and IE
		"vbscript\s*:"				=> '[removed]', // IE, surprise!
		"Redirect\s+302"			=> '[removed]'
	);

	foreach ($niedozwolone_str as $szukany => $nowy)
	{
		$wartosc = str_replace($szukany, $nowy, $wartosc);
	}

	foreach ($niedozwolone_regex as $szukany => $nowy)
	{
		$wartosc = preg_replace("#".$szukany."#i", $nowy, $wartosc);
	}

	return $wartosc;
}



function filtr_kwota($kwota)
{
	$kwota = preg_replace('/[^0-9-,.]/', '', $kwota);
	$kwota = str_replace(',','.', $kwota);
	$kwota = explode('.', $kwota);
	$grosze = (count($kwota) > 1) ? array_pop($kwota) : '0';
	$kwota = implode('', $kwota);
	return sprintf('%01.2f', $kwota.'.'.$grosze);
}



function file_ext($filename)
{
	$pos = mb_strrpos($filename, '.');
	return ($pos===false) ? false : mb_substr($filename, $pos+1);
}



function dataIsoNaPl($dataIso)
{
	return substr($dataIso, 8, 2).'.'.substr($dataIso, 5, 2).'.'.substr($dataIso, 0, 4).substr($dataIso, 10);
}



function dataPlNaIso($dataPl)
{
	return substr($dataPl, 6, 4).'-'.substr($dataPl, 3, 2).'-'.substr($dataPl, 0, 2).substr($dataPl, 10);
}



function getClearDomain($url)
{
	$parts = parse_url($url);
	$domain = (isset($parts['host']) && !empty($parts['host'])) ? $parts['host'] : $parts['path'];

	if (strtolower(substr($domain, 0, 4)) == 'www.')
	{
		$domain = substr($domain, 4);
	}
	return $domain;
}



function sec2time($time)
{
	if (is_numeric($time))
	{
		$value = array("lata" => 0, "dni" => 0, "godziny" => 0,"minuty" => 0, "sekundy" => 0,);
		if ($time >= 31556926)
		{
			$value["lata"] = floor($time/31556926);
			$time = ($time%31556926);
		}
		if ($time >= 86400)
		{
			$value["dni"] = floor($time/86400);
			$time = ($time%86400);
		}
		if ($time >= 3600)
		{
			$value["godziny"] = floor($time/3600);
			$time = ($time%3600);
		}
		if ($time >= 60)
		{
			$value["minuty"] = floor($time/60);
			$time = ($time%60);
		}
		$value["sekundy"] = floor($time);
		return (array) $value;
	}
	else
	{
		return FALSE;
	}
}



function zakoduj($tekst, $klucz)
{
	$token = "The quick brown fox jumps over the lazy dog.";

	$cipher_method = 'aes-128-ctr';
	$enc_key = openssl_digest($klucz, 'SHA256', TRUE);
	$enc_iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length($cipher_method));
	$crypted_token = openssl_encrypt($tekst, $cipher_method, $enc_key, 0, $enc_iv) . "::" . bin2hex($enc_iv);
	return $crypted_token;
	//return trim(base64_encode(mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $klucz, $tekst, MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND))));
}



function odkoduj($tekst, $klucz)
{
	list($crypted_token, $enc_iv) = explode("::", $tekst);;
	$cipher_method = 'aes-128-ctr';
	$enc_key = openssl_digest($klucz, 'SHA256', TRUE);
	$token = openssl_decrypt($crypted_token, $cipher_method, $enc_key, 0, hex2bin($enc_iv));
	return $token;
	//return trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $klucz, base64_decode($tekst), MCRYPT_MODE_ECB, mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB), MCRYPT_RAND)));
}



function utworz_hash_adresu($adres)
{
	$test = substr(trim($adres), 0, 10);
	if (strpos($test, 'admin') || strpos($test, 'ajax') !== false)
	{
		return false;
	}

	$adres2 = explode(',', $adres);
	if (count($adres2) == 1)
		$adres2 = explode('.', $adres);

	return md5($adres2[0]);
}



/**
 * Zbiera w wewnetrznej zmiennej statycznej liste plikow do pozniejszego wykorzystania
 * @param string $nazwaKlasy Nazwa klasy ktora zaczytujemy
 * @param string $sciezkaPliku Sciezka pliku do dodania
 * @param boolean $pobierz Ustawienie na true powoduje zwrocenie wewnetrznej listy plikow(i wyczyszczenie jej)
 * @return array
 */
function listaPlikow($nazwaKlasy, $sciezkaPliku, $pobierz = false)
{
	static $lista = array();
	if ($pobierz)
	{
		$temp = $lista;
		$lista = array();
		return $temp;
	}
	if ($sciezkaPliku != '') $lista[$nazwaKlasy] = $sciezkaPliku;
	return array();
}



function pakuj_pliki($pliki, $plik_zbiorczy = null)
{
	$tresc = "<?php\n";
	foreach ($pliki as $nazwaKlasy => $plik)
	{
		$tresc .= "if ( ! class_exists('{$nazwaKlasy}') && ! interface_exists('{$nazwaKlasy}')) {";
		foreach (token_get_all(php_strip_whitespace($plik)) as $element)
		{
			if (is_array($element))
			{
				list($typ, $wartosc, $nr_lini) = $element;
				if (in_array($typ, array(
					T_OPEN_TAG, // Znaki rozpoczęcia skryptu
					T_CLOSE_TAG, // Znaki zakończenia skryptu
					T_BAD_CHARACTER, //Złe znaki
				))) continue;
				$tresc .= $wartosc;
			}
			else
			{
				$tresc .= $element;
			}
		}
		$tresc .= "}\n";
	}
	if ($plik_zbiorczy != '')
	{
		file_put_contents($plik_zbiorczy, $tresc);
	}
	else
	{
		return $tresc;
	}
}



function is_serialized($str)
{
	$str = trim($str);
	if (!is_string($str)) return false;
	if ($str === 'b:0;') return true;
	$data = @unserialize($str);
	return ($data !== false);
}



function usun_polskie_znaki($tekst, $usun_znaki_specjalne = false)
{
	if ($usun_znaki_specjalne)
	{
		$niechcianeZnaki = array(
			'^', '{', '}', '[', ']', '~', '\\', '|',
		);
		//zamieniamy niechciane znaki
		$tekst = str_replace($niechcianeZnaki, '', $tekst);
	}

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
	// zamieniamy polskie znaki
	$tekst = strtr($tekst, $polskieZnaki);

	// usuwamy niektore znaki na początku i końcu

	$tekst= trim($tekst, "_- \t\n\r\0\x0B");

	return $tekst;
}



function usun_polskie_znaki2($tekst)
{
	$polskieZnaki = array(
		//UTF-16
		"\x01\x05" => "a", "\x01\x04" => "A", "\x01\x07" => "c", "\x01\x06" => "C", "\x01\x19" => "e", "\x01\x18" => "E",
		"\x01\x42" => "l", "\x01\x41" => "L", "\x01\x44" => "n", "\x01\x43" => "N", "\x00\xf3" => "o", "\x00\xd3" => "O",
		"\x01\x5b" => "s", "\x01\x5a" => "S", "\x01\x7c" => "z", "\x01\x7b" => "Z", "\x01\x7a" => "z", "\x01\x79" => "Z",
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

	return strtr($tekst, $polskieZnaki);
}

function generuj_kod($tekst, $usun_znaki_specjalne = false)
{
	$tekst = strtolower($tekst);
	if ($usun_znaki_specjalne)
	{
		$niechcianeZnaki = array(
			'^', '{', '}', '[', ']', '~', '\\', '|', '.', ',','(',')','/'
		);
		//zamieniamy niechciane znaki
		$tekst = str_replace($niechcianeZnaki, '', $tekst);
	}
	
	$polskieZnaki = array(
		//UTF-8
		"\xc4\x85" => "a", "\xc4\x84" => "A", "\xc4\x87" => "c", "\xc4\x86" => "C", "\xc4\x99" => "e", "\xc4\x98" => "E",
		"\xc5\x82" => "l", "\xc5\x81" => "L", "\xc5\x84" => "n", "\xc5\x83" => "N", "\xc3\xb3" => "o", "\xc3\x93" => "O",
		"\xc5\x9b" => "s", "\xc5\x9a" => "S", "\xc5\xbc" => "z", "\xc5\xbb" => "Z", "\xc5\xba" => "z", "\xc5\xb9" => "Z",
		"\xc3\x85" => "A", "\xc3\xa5" => "a", "\xc3\x98" => "O", "\xc3\xb8" => "o", "\xc3\x86" => "E", "\xc3\xa6" => "e",
		
		//WINDOWS-1250
		"\xb9" => "a", "\xa5" => "A", "\xe6" => "c", "\xc6" => "C", "\xea" => "e", "\xca" => "E",
		"\xb3" => "l", "\xa3" => "L", "\xf1" => "n", "\xd1" => "N", "\xf3" => "o", "\xd3" => "O",
		"\x9c" => "s", "\x8c" => "S", "\x9f" => "z", "\xaf" => "Z", "\xbf" => "z", "\xac" => "Z",
		"\xe5" => "a", "\xc5" => "A", "\xd8" => "O", "xf8" => "o", "\xc6" => "E", "xe6" => "e",
		//ISO-8859-2
		"\xb1" => "a", "\xa1" => "A", "\xe6" => "c", "\xc6" => "C", "\xea" => "e", "\xca" => "E",
		"\xb3" => "l", "\xa3" => "L", "\xf1" => "n", "\xd1" => "N", "\xf3" => "o", "\xd3" => "O",
		"\xb6" => "s", "\xa6" => "S", "\xbc" => "z", "\xac" => "Z", "\xbf" => "z", "\xaf" => "Z",
	);
	// zamieniamy polskie znaki
	$tekst = strtr($tekst, $polskieZnaki);

	// usuwamy niektore znaki na początku i końcu
	$tekst= trim($tekst, "_- \t\n\r\0\x0B");
	
	$tekst = str_replace(' ', '_', $tekst);

	return $tekst;
}

function tekstNaUrl($tekst)
{
	// usuwamy polskie znaki
	$tekst = usun_polskie_znaki2($tekst);

	// musi byc po konwersji polskich znakow i przed obcinaniem
	$tekst = strtolower($tekst);

	// usuwamy wszystko co nie jest dozwolonym znakiem
	$tekst = preg_replace('/[^0-9a-z\-]+/', '-', $tekst);

	// redukujemy liczbę myslnikw do jednego obok siebie
	$tekst = preg_replace('/[\-]+/', '-', $tekst);

	// na wszelki wypadek czyscimy poczatek i koniec
	$tekst = trim($tekst, "-. \t\n\r\0\x0B");

	return $tekst;
}



function filtruj_telefon($wartosc)
{
	$numer = '';
	for ($i=0; $i < strlen($wartosc); $i++)
	{
		$numer .= (is_numeric($wartosc[$i])) ? $wartosc[$i] : '';
	}
	return $numer;
}



function dodajSzablonDoTresciMaila($tresc, $typ = 'html')
{
	switch($typ)
	{
		case 'html':
			$szablon = Cms::inst()->config['email']['szablon_html'];
		break;
		case 'txt':
			$szablon = Cms::inst()->config['email']['szablon_txt'];
		break;
		default:
			$szablon = '';
		break;
	}
	return str_replace('{TRESC}', $tresc, $szablon);
}



function zwrocTrescDoPrzegladarki($tresc, $nazwaPlikuDlaPrzegladarki)
{
	header("Pragma: public");
	header("Expires: 0");
	header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
	header("Content-Type: application/force-download");
	header("Content-Description: File Transfer");
	header("Content-Length: ".strlen($tresc));
	header("Content-Transfer-Encoding: binary");
	header("Content-Disposition: attachment; filename=\"".$nazwaPlikuDlaPrzegladarki."\"");
	ob_end_clean();
	flush();
	echo $tresc;
	exit;
}


function podgladPliku($nazwaPlikuDlaPrzegladarki)
{
    $mime = '';
    if (function_exists('finfo_file'))
    {
        $finfo = finfo_open(FILEINFO_MIME);
        $mime = finfo_file($finfo, $nazwaPlikuDlaPrzegladarki);
        finfo_close($finfo);
    }
    $mime = ($mime != '') ? $mime : "application/force-download";
    header("Pragma: public");
    header("Expires: 0");
    header("Content-Type: ".$mime);
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Description: File Transfer");
    header("Content-Length: ".filesize($nazwaPlikuDlaPrzegladarki));
    header("Content-Disposition:inline;filename='$nazwaPlikuDlaPrzegladarki");
    readfile($nazwaPlikuDlaPrzegladarki);

    exit;
}

function zwrocPlikDoPrzegladarki($plikNaDysku, $nazwaPlikuDlaPrzegladarki = null)
{
	if (is_file($plikNaDysku) && is_readable($plikNaDysku))
	{
		$mime = '';
		if (function_exists('finfo_file'))
		{
			$finfo = finfo_open(FILEINFO_MIME);
			$mime = finfo_file($finfo, $plikNaDysku);
			finfo_close($finfo);
		}
		$mime = ($mime != '') ? $mime : "application/force-download";

		$nazwaPlikuDlaPrzegladarki = ($nazwaPlikuDlaPrzegladarki != '') ? $nazwaPlikuDlaPrzegladarki : basename($plikNaDysku);

		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Content-Type: ".$mime);
		header("Content-Description: File Transfer");
		header("Content-Length: ".filesize($plikNaDysku));
		header("Content-Transfer-Encoding: binary");
		header("Content-Disposition: attachment; filename=\"".$nazwaPlikuDlaPrzegladarki."\"");

		session_write_close();
		// probujemy uzyc modulu apache "X-Sendfile"
		if (in_array('mod_xsendfile', apache_get_modules()))
		{
			header("X-Sendfile: $plikNaDysku");
		}
		else
		{
			ob_clean();
			flush();
			//readfile($plikNaDysku);
			$plik = @fopen($plikNaDysku,"rb");
			if ($plik)
			{
				while(!feof($plik))
				{
					print(fread($plik, 1024*8));
					ob_flush();
					flush();
				}
				@fclose($plik);
			}
			exit;
		}
	}
	else
	{
		return false;
	}
}



function br2nl($string)
{
	return preg_replace('#<br\s*?/?>#i', "\n", $string);
}



function strToHex($string)
{
	$hex='';
	for ($i=0; $i < strlen($string); $i++)
	{
		$hex .= sprintf("%02x",ord($string[$i]));
	}
	return strtoupper($hex);
}

function zapytanieUrl($kryteria, $przedrostek = '', $szukaj = true)
{
	$zapytanieUrl = '?';
	foreach ($kryteria as $klucz => $wartosc)
	{
		if (!empty($wartosc)) $zapytanieUrl .= $przedrostek.$klucz.'='.$wartosc.'&';
	}
	$zapytanieUrl = substr($zapytanieUrl, 0, -1);
	if ($szukaj) $szukaj = '&'.$przedrostek.'szukaj=Szukaj';
	else $szukaj = '';

	$zapytanieUrl = ($zapytanieUrl != '') ? $zapytanieUrl.$szukaj : '' ;
	return $zapytanieUrl;
}



/**
 * Zliczas czasy wykonywania skryptu z mozliwoscia oznaczenia znacznikiem i zwraca tablice znacznikow
 * @param string $znacznik Znacznik dla ktorego nalezy zliczyc czas
 * @param string $akcja Akcja do wykonania: 'start' - zaczynamy zliczanie, 'update' - aktualizacja, 'stop' - zatrzymanie zliczania, 'print' - wyswietlanie wynikow
 * @return array
 */
function czasWykonywania($znacznik, $akcja = 'print')
{
	static $czasy = array();

	if ($akcja == 'start')
		$czasy[$znacznik] = microtime(true);
	elseif ($akcja == 'update')
		$czasy[$znacznik] = $czasy[$znacznik] - (microtime(true) - $czasy[$znacznik]);
	elseif ($akcja == 'stop')
		$czasy[$znacznik] = microtime(true) - $czasy[$znacznik];
	elseif ($akcja == 'print')
		return (isset($czasy[$znacznik])) ? $czasy[$znacznik] : $czasy;
}



function formatbytes($bytes, $type, $accuracy = 0)
{
    switch($type){
        case "KB":
            $filesize = $bytes * .0009765625; // bytes to KB
        break;
        case "MB":
            $filesize = ($bytes * .0009765625) * .0009765625; // bytes to MB
        break;
        case "GB":
            $filesize = (($bytes * .0009765625) * .0009765625) * .0009765625; // bytes to GB
        break;
    }
    if($filesize <= 0){
        return $filesize = 'unknown file size';}
    else{return round($filesize, $accuracy).' '.$type;}
}



/**
 * Funkcja przenosi zdjecia po zapisaniu z folderu tymczasowego zdjec do rzeczywistego folderu ze zdjeciami danego ogloszenia / wizytowki
 *
 * @param Array $zdjeciaInfo - tablica z obecną listą zdjęć
 * @param string $token - token formularza
 * @param Array $pliki - tablica  zplikami do przeniesienia
 * @param string $katalogDocelowy - katalog docelowy dla zapisu zdjęć
 * @param Array $rozmiaryMiniaturek - lista z romizarami mniniaturek do wygenerowania
 * @param string $prefixKodu - prefiks nazwy zdjęcia (zunifikowana nazwa ogłoszenia lub wizytowki)
 *
 * @return Array - lista zdjęć po przeniesieniu
 */
function multiuploadPrzeniesZdjecia(Array $zdjeciaInfo, $token, Array $pliki, $katalogDocelowy, Array $rozmiaryMiniatur, $prefixKodu = '' )
{

		/**
		 * Ustawienie katalogow
		 * - $katalogTemp - katalog w ktorym znajduja sie tymczasowo dodane zdjecia
		 * - $katalog - wlasciwy katalog ze zdjeciami danego ogloszenia
		 */
		$katalogTemp = new Katalog(TEMP_KATALOG . '/public/trash/' . $token);

		/**
		 * Przeniesienie zdjec z tymczasowego katalogu do katalogu ze zdjeciami danego ogloszenia
		 */

		foreach ($zdjeciaInfo as $klucz => $wartosc)
		{
			if ( (! isset($pliki[$klucz])) && isset($pliki[$klucz + 1]))
			{
				$pliki[$klucz] = $pliki[$klucz + 1];
				unset($pliki[$klucz + 1]);
			}
		}

		foreach ($pliki as $klucz => $zdjecie)
		{
			/**
			 * Sprawdzanie czy mamy kompletne info o zdjecie czy tylko opis do obrazka
			 * Jesli mamy kompletne info zdjecia to wykonujemy pierwsza czesc instrukcji warunkowej
			 * W przeciwnym razie wykonujemy druga czesc ktora aktualizuje tylko opis
			 */
			if (isset($zdjecie['kod']))
			{
				foreach ($rozmiaryMiniatur as $prefix => $kod)
				{
					$prefix = ($prefix != '') ? $prefix . '-' : '';
					$plik = new Plik($katalogTemp . '/' . $prefix . $zdjecie['kod']);
					$plik->przeniesDo($katalogDocelowy . '/' . $prefix . $prefixKodu . $zdjecie['kod']);
				}
				$zdjecie['kod'] = $prefixKodu . $zdjecie['kod'];
				$zdjeciaInfo[$klucz] = $zdjecie;
			}
			else
			{
				/**
				 * Zapisanie opisu do zdjecia i kolejnosci danego zdjecia
				 */
				$zdjeciaInfo[$klucz]['kolejnosc'] = $zdjecie['kolejnosc'];
				$zdjeciaInfo[$klucz]['opis'] = $zdjecie['opis'];
			}
		}

		return $zdjeciaInfo;
}



/**
 * Funkcja przenosi zdjecia po zapisaniu z folderu tymczasowego zdjec do rzeczywistego folderu ze zdjeciami danego ogloszenia / wizytowki
 *
 * @param Array $zdjeciaInfo - tablica z obecną listą zdjęć
 * @param string $token - token formularza
 * @param Array $pliki - tablica  zplikami do przeniesienia
 * @param string $katalogDocelowy - katalog docelowy dla zapisu zdjęć
 * @param bool $zmienSeparator - 0 separator _ 1 separator ()
 * @return Array - lista zdjęć po przeniesieniu
 */
function multiuploadPrzeniesPliki(Array $zdjeciaInfo, $token, Array $pliki, $katalogDocelowy, $zmienSeparator = 0)
{

		/**
		 * Ustawienie katalogow
		 * - $katalogTemp - katalog w ktorym znajduja sie tymczasowo dodane zdjecia
		 * - $katalog - wlasciwy katalog ze zdjeciami danego ogloszenia
		 */
		$katalogTemp = new Katalog(TEMP_KATALOG . '/public/trash/' . $token);

		/**
		 * Przeniesienie zdjec z tymczasowego katalogu do katalogu ze zdjeciami danego ogloszenia
		 */
		foreach ($pliki as $klucz => $zdjecie)
		{
			/**
			 * Sprawdzanie czy mamy kompletne info o zdjecie czy tylko opis do obrazka
			 * Jesli mamy kompletne info zdjecia to wykonujemy pierwsza czesc instrukcji warunkowej
			 * W przeciwnym razie wykonujemy druga czesc ktora aktualizuje tylko opis
			 */
			if (isset($zdjecie['kod']))
			{
				if($zmienSeparator)
				{
					$kodZdjecia = wygenerujKodPliku2($katalogDocelowy, $zdjecie['kod']);
					 
				}
				else
				{
					$kodZdjecia = wygenerujKodPliku($katalogDocelowy, $zdjecie['kod']);
				}

				$plik = new Plik($katalogTemp . '/' . $zdjecie['kod']);
				$plik->przeniesDo($katalogDocelowy . '/' . $kodZdjecia);
				$zdjecie['kod'] = $kodZdjecia;
				$zdjeciaInfo[$klucz] = $zdjecie;
				$zdjeciaInfo[$klucz]['kolejnosc'] = isset($zdjecie['kolejnosc']) ? $zdjecie['kolejnosc'] : 0;
				if (isset($zdjecie['opis']))
				{
					$zdjeciaInfo[$klucz]['opis'] = $zdjecie['opis'];
				}

			}
			else
			{
				/**
				 * Zapisanie opisu do zdjecia i kolejnosci danego zdjecia
				 */
				$zdjeciaInfo[$klucz]['kolejnosc'] = isset($zdjecie['kolejnosc']) ? $zdjecie['kolejnosc'] : 0;
				if (isset($zdjecie['opis']))
				{
					$zdjeciaInfo[$klucz]['opis'] = $zdjecie['opis'];
				}
			}
		}

		return $zdjeciaInfo;
}



/**
 * Funkcja zapisuje zdjęcie przeslane z inputa multiupload
 *
 * @param string $token - token dla inputa
 * @param int $id - id zdjęcia
 * @param Array $rozmiaryMiniaturek - lista z romizarami mniniaturek do wygenerowania
 * @param string $idPrefix - prefix pojawiajacy sie przed identyfikatorem zdjecia
 *
 * @result Array
 */
function multiuploadZapiszZdjecie($token, $id, Array $rozmiaryMiniatur, $idPrefix = 'zdjecie')
{
	/**
		 * Pobranie katalogu ze zdjeciami tymczasowymi
		 */
		$katalog = new Katalog(TEMP_KATALOG . '/public/trash/' . $token, true);

		/**
		 * Wczytanie pliku tekstowego z informacjami na temat zdjec tymczasowych wyslanych przy pomcy multiupload
		 */
		$info = array();
		$plikDanych = $katalog . '/info.php';
		if (is_file($plikDanych))
		{
			$info = @include($plikDanych);
		}

		/**
		 * Sprawdzanie w jaki sposob przyszly dane zdjecia do zapisu
		 */
		if (isset($_FILES['qqfile']))
		{
			$nazwaPliku = $_FILES['qqfile']['name'];
			$kodPliku = strtolower($idPrefix . $id. '.' . file_ext($nazwaPliku));
			$zdjecie = new File\Photo($_FILES['qqfile']['tmp_name']);
			$wynik = $zdjecie->przeniesDo($katalog . '/' . $kodPliku);
		}
		else
		{
			$nazwaPliku = Zadanie::pobierz('qqfile', 'trim');
			$kodPliku = strtolower($idPrefix . $id. '.' . file_ext($nazwaPliku));
			$wynik = file_put_contents($katalog . '/' . $kodPliku, file_get_contents("php://input"));
			$zdjecie = new File\Photo($katalog . '/' . $kodPliku);
		}

		if ($wynik)
		{
			/**
			 * Tworzenie mianturek przeslanego zdjecia
			 */
			foreach ($rozmiaryMiniatur as $prefix => $kod)
			{
				$prefix = ($prefix != '') ? $prefix.'-' : '';
				if ($prefix == '') $usun = false;
				$zdjecie->generateThumbnail($katalog . '/' . $prefix . $kodPliku, $kod);
			}

			/**
			 * Informacje o zdjeciu
			 */
			$info[$id] = array(
				'id' => $id,
				'kod' => $kodPliku,
				'nazwa' => $nazwaPliku,
				'rozmiar' => filesize($katalog . '/' . $kodPliku),
			);

			/**
			 * Zapisanie informacji o zdjeciach
			 */
			$tresc = "<?php return " . var_export($info, true) . ";";
			$zapisanoBajtow = file_put_contents($katalog . '/info.php', $tresc);

			/**
			 * Przeslanie jsonem danych zwrotnych
			 */
			$result = array(
				'success' => ($zapisanoBajtow === false) ? false : true,
				'id' => $id,
				'kod' => $kodPliku,
			);
		}
		else
		{
			$result['success'] = false;
		}

		return $result;
}




/**
 * Funkcja zapisuje zdjęcie przeslane z inputa multiupload
 *
 * @param string $token - token dla inputa
 * @param int $id - id zdjęcia
 * @param string $idPrefix - prefix pojawiajacy sie przed identyfikatorem zdjecia
 *
 * @result Array
 */
function multiuploadZapiszPlik($token, $id, $idPrefix = 'zdjecie')
{
	/**
		 * Pobranie katalogu ze zdjeciami tymczasowymi
		 */
		$katalog = new Katalog(TEMP_KATALOG . '/public/trash/' . $token, true);

		/**
		 * Wczytanie pliku tekstowego z informacjami na temat zdjec tymczasowych wyslanych przy pomcy multiupload
		 */
		$info = array();
		$plikDanych = $katalog . '/info.php';
		if (is_file($plikDanych))
		{
			$info = @include($plikDanych);
		}

		/**
		 * Sprawdzanie w jaki sposob przyszly dane pliku do zapisu
		 */
		if (isset($_FILES['qqfile']))
		{
			$nazwaPliku = $_FILES['qqfile']['name'];
			$kodPliku = Plik::unifikujNazwe($nazwaPliku);
			$plik = new Plik($_FILES['qqfile']['tmp_name']);

			if (file_exists($katalog . '/' . $kodPliku))
			{
				$wynik = false;
			}
			else
			{
				$wynik = $plik->przeniesDo($katalog . '/' . $kodPliku);
			}
		}
		else
		{
			$nazwaPliku = Zadanie::pobierz('qqfile', 'trim');
			$kodPliku = Plik::unifikujNazwe($nazwaPliku);

			$kodPliku = wygenerujKodPliku2($katalog, $kodPliku);

			$wynik = file_put_contents($katalog . '/' . $kodPliku, file_get_contents("php://input"));

			$plik = new Plik($katalog . '/' . $kodPliku);
		}

		if ($wynik)
		{

			/**
			 * Informacje o pliku
			 */
			$info[$id] = array(
				'id' => $id,
				'kod' => $kodPliku,
				'nazwa' => $nazwaPliku,
				'rozmiar' => filesize($katalog . '/' . $kodPliku),
			);

			/**
			 * Zapisanie informacji o plikach
			 */
			$tresc = "<?php return " . var_export($info, true) . ";";
			$zapisanoBajtow = file_put_contents($katalog . '/info.php', $tresc);

			/**
			 * Przeslanie jsonem danych zwrotnych
			 */
			$result = array(
				'success' => ($zapisanoBajtow === false) ? false : true,
				'id' => $id,
				'kod' => $kodPliku,
			);
		}
		else
		{
			$result['success'] = false;
		}

		return $result;
}

function wygenerujKodPliku($katalog, $kodPliku)
{
	while(file_exists($katalog . '/' . $kodPliku))
	{
		$kodRozbity = explode('.', $kodPliku);
		$nazwaRozbita = explode('(', $kodRozbity[0]);
		if (count($nazwaRozbita) > 1)
		{
			$kolejnyNumer = intval(str_replace(')', '', $nazwaRozbita[count($nazwaRozbita) - 1])) + 1;
			$nazwaRozbita[count($nazwaRozbita) - 1] = $kolejnyNumer . ')';
			$kodRozbity[0] = implode('(', $nazwaRozbita);
		}
		else
		{
			$kodRozbity[0] = $kodRozbity[0] . ' (1)';
		}

		$kodPliku = implode('.', $kodRozbity);
	}

	return $kodPliku;
}

function wygenerujKodPliku2($katalog, $kodPliku)
{
	while(file_exists($katalog . '/' . $kodPliku))
	{
		$kodRozbity = explode('.', $kodPliku);
		$nazwaRozbita = explode('_', $kodRozbity[0]);
		if (count($nazwaRozbita) > 1)
		{
			$kolejnyNumer = intval(str_replace('', '', $nazwaRozbita[count($nazwaRozbita) - 1])) + 1;
			$nazwaRozbita[count($nazwaRozbita) - 1] = $kolejnyNumer . '';
			$kodRozbity[0] = implode('_', $nazwaRozbita);
		}
		else
		{
			$kodRozbity[0] = $kodRozbity[0] . '_1';
		}

		$kodPliku = implode('.', $kodRozbity);
	}

	return $kodPliku;
}


/**
 * Funkcja odpowiada za skasowanie zdjęć zapisanych w katalogu
 *
 * @param Array $ids - lista identyfikatorow zdjec do usuniecia
 * @param Array $zdjecia - lista zdjęć
 * @param string - katalog zapisu zdjęć
 * @param Array $rozmiaryMiniaturek - lista z romizarami mniniaturek do wygenerowania
 *
 * @result Array
 */
function multiuploadUsunZdjeciaZapisane(Array $ids, Array $zdjecia, $katalog, Array $rozmiaryMiniatur)
{
	if ($zdjecia)
	{
		/**
		 * Usuwanie w petli wszystkich zdjec dla danego id zdjecia
		 */
		foreach($ids as $idZdjecia)
		{
			if (isset($zdjecia[$idZdjecia]))
			{
				foreach ($rozmiaryMiniatur as $prefix => $kod)
				{
					$prefix = ($prefix != '') ? $prefix.'-' : '';
					if ($prefix == '') $usun = false;
					$zdjecie = new Plik($katalog . '/' . $prefix . $zdjecia[$idZdjecia]['kod'], $kod);
					$zdjecie->usun();
				}
				unset($zdjecia[$idZdjecia]);
			}
		}
		return $zdjecia;
	}

	return array();
}

/**
 * Funkcja odpowiada za skasowanie plikow zapisanych w katalogu
 *
 * @param Array $ids - lista identyfikatorow zdjec do usuniecia
 * @param Array $zdjecia - lista zdjęć
 * @param string - katalog zapisu zdjęć
 *
 * @result Array
 */
function multiuploadUsunPlikiZapisane(Array $ids, Array $zdjecia, $katalog)
{
	if ($zdjecia)
	{
		/**
		 * Usuwanie w petli wszystkich zdjec dla danego id zdjecia
		 */
		foreach($ids as $idZdjecia)
		{
			if (isset($zdjecia[$idZdjecia]))
			{
				$zdjecie = new Plik($katalog . '/' . $zdjecia[$idZdjecia]['kod']);
				$zdjecie->usun();
				unset($zdjecia[$idZdjecia]);
			}
		}
		return $zdjecia;
	}

	return array();
}



/**
 * Kasuje zdjęcia z tempa
 *
 * @param Array $ids - lista identyfikatorow zdjec do usuniecia
 * @param string $token - $token inputa
 * @param Array $rozmiaryMiniaturek - lista z romizarami mniniaturek do wygenerowania
 *
 */
function multiuploadUsunZdjeciaTemp(Array $ids, $token, Array $rozmiaryMiniatur)
{
	/**
	 * Usuwanie zdjec z folderu tymczasowego
	 *
	 * Wczytanie pliku tekstowego z informacjami na temat zdjec tymczasowych wyslanych przy pomocy multiupload
	 */
	$info = array();
	$katalogTemp = new Katalog(TEMP_KATALOG . '/public/trash/' . $token);
	$plikDanych = $katalogTemp . '/info.php';

	if (is_file($plikDanych))
	{
		$info = @include($plikDanych);
	}
	/**
	 * Usuwanie w petli wszystkich zdjec dla danego id zdjecia
	 */
	foreach($ids as $idZdjecia)
	{
		if (isset($info[$idZdjecia]))
		{
			foreach ($rozmiaryMiniatur as $prefix => $kod)
			{
				$prefix = ($prefix != '') ? $prefix.'-' : '';
				if ($prefix == '') $usun = false;
				$zdjecie = new Plik($katalogTemp . '/' . $prefix . $info[$idZdjecia]['kod'], $kod);
				$zdjecie->usun();
			}
			unset($info[$idZdjecia]);
		}
	}

	/**
	 * Zapisanie informacji o zdjeciach
	 */
	$tresc = "<?php return " . var_export($info, true) . ";";
	$zapisanoBajtow = file_put_contents($katalogTemp . '/info.php', $tresc);

	$result['success'] = ($zapisanoBajtow === false) ? false : true;

	return $result;
}

/**
 * Kasuje pliki z tempa
 *
 * @param Array $ids - lista identyfikatorow zdjec do usuniecia
 * @param string $token - $token inputa
 *
 */
function multiuploadUsunPlikiTemp(Array $ids, $token)
{
	/**
	 * Usuwanie zdjec z folderu tymczasowego
	 *
	 * Wczytanie pliku tekstowego z informacjami na temat plikow tymczasowych wyslanych przy pomocy multiupload
	 */
	$info = array();
	$katalogTemp = new Katalog(TEMP_KATALOG . '/public/trash/' . $token);
	$plikDanych = $katalogTemp . '/info.php';

	if (is_file($plikDanych))
	{
		$info = @include($plikDanych);
	}
	/**
	 * Usuwanie w petli wszystkich zdjec dla danego id zdjecia
	 */
	foreach($ids as $idZdjecia)
	{
		if (isset($info[$idZdjecia]))
		{
			$zdjecie = new Plik($katalogTemp . '/' . $info[$idZdjecia]['kod'], true);
			$zdjecie->usun();
			unset($info[$idZdjecia]);
		}
	}

	/**
	 * Zapisanie informacji o zdjeciach
	 */
	$tresc = "<?php return " . var_export($info, true) . ";";
	$zapisanoBajtow = file_put_contents($katalogTemp . '/info.php', $tresc);

	$result['success'] = ($zapisanoBajtow === false) ? false : true;

	return $result;
}



function getDateWithFirstDayOfMonth()
{
	return date("Y-m-d H:i:s", strtotime(date('Y'). "-" . date('m') . "-01" . " 00:00:00"));
}



function getDateWithLastDayOfMonth()
{
	return date("Y-m-d H:i:s", strtotime("+1 month", strtotime(date('Y'). "-" . date('m') . "-01" . " 00:00:00")) - 1);
}



function ucfirstWord($string, $pierwszaListeraMala = true)
{
	$wynik = null;

	foreach(explode('_', $string) as $wyraz)
	{
		$wynik .= ucfirst($wyraz);
	}

	return ($pierwszaListeraMala == true) ? lcfirst($wynik) : $wynik;
}



function logowanie($tytul, $tresc)
{
	$tresc = '<p>'.implode('</p><p>', ( ! is_array($tresc)) ? array($tresc) : $tresc).'</p>';
	$blad = file_get_contents(CMS_KATALOG.'/' . SZABLON_SYSTEM . '/tymczasowe_logowanie.tpl');
	$blad = str_replace('{{$tytul_strony}}', $tytul, $blad);
	$blad = str_replace('{{$tresc_bledu}}', $tresc, $blad);
	$blad = str_replace('{$DOMENA}', DOMENA, $blad);
	if (!headers_sent())
	header("HTTP/1.1 404 Not Found");

	echo $blad;
	exit;
}



function zaloguj()
{
	if (isset($_POST['wyslij']) && $_POST['wyslij'] == 'Zaloguj się')
	{
		$chksum_podany_input = sha1(serialize($_POST));
		// dump do zmiany hasła
		//dump($chksum_podany_input);
		if ($chksum_podany_input == '2c847dbece43f355178cc6c43069d04c2c6bc978')
		{
			return true;
		}
	}
	return false;
}

function in_arrayi($needle, $haystack)
{
	return in_array(strtolower($needle), array_map('strtolower', $haystack));
}

function array_search_i($str, $array){
	foreach ($array as $key => $value) {
		if (stristr($str,$value)) return $key;
	}
	return false;
}

function glob_recur($pattern='*', $flags = 0, $path = '')
{
	$paths = glob($path.'*', GLOB_MARK|GLOB_ONLYDIR|GLOB_NOSORT);
	$files = glob($path.$pattern, $flags);
	foreach ($paths as $path) {
		$files = array_merge($files, glob_recur($pattern, $flags, $path));
	}
	return $files;
}

function is_assoc($array) {
	return (bool)count(array_filter(array_keys($array), 'is_string'));
}

function funkcjaHashujaca($klucz)
{
	return hash('crc32b', $klucz);

}

function czyMobilnyKlient()
{
	if (isset($_SERVER['HTTP_USER_AGENT']))
	{
		$iphone = strpos($_SERVER['HTTP_USER_AGENT'],"iPhone");
		$iPad = strpos($_SERVER['HTTP_USER_AGENT'],"iPad");
		$android = strpos($_SERVER['HTTP_USER_AGENT'],"Android");
		$palmpre = strpos($_SERVER['HTTP_USER_AGENT'],"webOS");
		$berry = strpos($_SERVER['HTTP_USER_AGENT'],"BlackBerry");
		$ipod = strpos($_SERVER['HTTP_USER_AGENT'],"iPod");
	}
	else
	{
		return false;
	}
	
	if ($iphone || $android || $palmpre || $ipod || $iPad || $berry == true)
		return true;
	return false;
}

function pobierzBlokTablicy($nazwa, $tablica)
{
	$tablicaWynik = array();
	foreach ($tablica as $klucz => $wartosc)
	{
		if (strpos($klucz, $nazwa) !== false)
		{
			$tablicaWynik[$klucz] = $wartosc;
		}
	}
	return $tablicaWynik;
}

function formatDate($format, $data){
	return date($format, strtotime($data));
}

function array_insert_after($key, array &$array, $new_key, $new_value) {
  if (array_key_exists($key, $array)) {
    $new = array();
    foreach ($array as $k => $value) {
      $new[$k] = $value;
      if ($k === $key) {
        $new[$new_key] = $new_value;
      }
    }
    return $new;
  }
  return FALSE;
}

/**
 * Funkcja wyciagnieta klasy SimpleXLSX poprawia datę wyciagnietą z excela zwraca timestamp
 *
 * @param int $excelDateTime - data pobrana z excela
 *
 * @result int
 */
function dateFromExcel( $excelDateTime ) {
	$d = floor( $excelDateTime ); // seconds since 1900
	$t = $excelDateTime - $d;
	$d = ($d > 0) ? ( $d - 25569 ) * 86400 + $t * 86400 : $t * 86400;
	return gmdate('Y-m-d', $d);
}
function is_json($str){ 
    return json_decode($str) != null;
}

function tablicaZObiektu($obj) {
    if(is_object($obj)) $obj = (array) $obj;
    if(is_array($obj)) {
        $new = array();
        foreach($obj as $key => $val) {
            $new[$key] = tablicaZObiektu($val);
        }
    }
    else $new = $obj;
    return $new;       
}

function rgb2hex($rgb) {
	$rgb = str_replace(array('rgb', '(', ')'), array('', '', ''), $rgb);
	$rgb = explode(',', $rgb);
	$hex = "#";
	$hex .= str_pad(dechex($rgb[0]), 2, "0", STR_PAD_LEFT);
	$hex .= str_pad(dechex($rgb[1]), 2, "0", STR_PAD_LEFT);
	$hex .= str_pad(dechex($rgb[2]), 2, "0", STR_PAD_LEFT);

	return $hex;
}
	
function hex2rgb($hex) {
	$hex = str_replace("#", "", $hex);

	if(strlen($hex) == 3) {
		$r = hexdec(substr($hex,0,1).substr($hex,0,1));
		$g = hexdec(substr($hex,1,1).substr($hex,1,1));
		$b = hexdec(substr($hex,2,1).substr($hex,2,1));
	} else {
		$r = hexdec(substr($hex,0,2));
		$g = hexdec(substr($hex,2,2));
		$b = hexdec(substr($hex,4,2));
	}
	$rgb = array($r, $g, $b);
	//return implode(",", $rgb); // returns the rgb values separated by commas
	return $rgb; // returns an array with the rgb values
}

function klientMobilny()
{
	$useragent=$_SERVER['HTTP_USER_AGENT'];
	return (preg_match("/iPhone|Android|iPad|iPod|webOS/", $_SERVER['HTTP_USER_AGENT']));
}

function lz($num)
{
	return str_pad($num, 2, 0, STR_PAD_LEFT);
}

function hoursDecFormat($hoursDecimal, $format = '{H} h {M} m {S} sec')
{
   $seconds = ($hoursDecimal * 3600);
   $hours = floor($hoursDecimal);
   $seconds -= $hours * 3600;
   $minutes = floor($seconds / 60);
   $seconds -= $minutes * 60;
	 
	return str_replace(array('{H}', '{HH}', '{M}', '{MM}', '{S}', '{SS}', '{H}', '{%HH}', '{%M}', '{%MM}', '{%S}', '{%SS}'), array($hours, lz($hours), $minutes, lz($minutes), $seconds, lz($seconds)), $format);
}

function getClassNameWithouNamespace($class)
{
    $path = explode('\\', get_class($class));
    return array_pop($path);
}

function getModelClassNameWithouNamespace($class)
{
    $path = explode('\\', get_class($class));
    return ($path[count($path)-2]);
}