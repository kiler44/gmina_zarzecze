<?php
namespace Generic\Biblioteka\Mandango;
use Generic\Biblioteka\Zadanie;

class LogowanieZapytan
{
	public static function pobierz($sciezkaPliku,$callbackCallable = null)
	{
		return function (Array $log) use ($sciezkaPliku, $callbackCallable)
		{
			$tresc = "\n[".date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
			$tresc .= (PHP_SAPI != 'cli') ? ', '.Zadanie::wywolanyUrl().', '.Zadanie::adresIp() : ', '.$_SERVER['SCRIPT_NAME'].', User: '.$_SERVER['USER'];
			$tresc .= '] ' . serialize($log);
			error_log($tresc, 3, $sciezkaPliku);

			if (is_callable($callbackCallable))
			{
				$callbackCallable($log);
			}
		};
	}
}
