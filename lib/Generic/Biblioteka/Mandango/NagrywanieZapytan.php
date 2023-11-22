<?php
namespace Generic\Biblioteka\Mandango;
use Generic\Biblioteka\Zadanie;

class NagrywanieZapytan
{
	public static function pobierz($sciezkaPliku, $callbackCallable = null)
	{
		return function (Array $log) use ($sciezkaPliku, $callbackCallable)
		{
			$tresc = serialize($log) . "\n";
			error_log($tresc, 3, $sciezkaPliku);

			if (is_callable($callbackCallable))
			{
				$callbackCallable($log);
			}
		};
	}
}
