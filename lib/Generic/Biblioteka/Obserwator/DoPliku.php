<?php
namespace Generic\Biblioteka\Obserwator;
use Generic\Biblioteka\Zdarzenia;
use Generic\Model\Obserwator;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Model\Uzytkownik;
use Generic\Biblioteka\Zadanie;


/**
 * Klasa obserwatora logujaca zdarzenie do pliku
 *
 * @author Krzysztof Żak
 * @package biblioteki
 */

class DoPliku extends Zdarzenia\Obserwator
{

	private $zdarzenia = array();

	private $plikLog;



	protected function ustawieniaObserwatora(Obserwator\Obiekt $obserwator)
	{
		$this->plikLog = LOGI_KATALOG.'/'.date ("Y-m-d", $_SERVER['REQUEST_TIME']).'-'.$obserwator->obiekt_docelowy.'.log';
	}



	protected function obsluzZdarzenie(Zdarzenia\Zdarzenie $zdarzenie)
	{
		$zrodlo = $zdarzenie->pobierzZrodlo();
		if ($zrodlo instanceof Modul)
		{
			$dane = $zdarzenie->pobierzDane();

			$wiersz = array();
			$wiersz[] = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
			$wiersz[] = $zrodlo->pobierzNazweModulu();
			$wiersz[] = $dane['zdarzenie'];
			unset($dane['zdarzenie']);
			$dodatkowe = '';

			if (count($dane) > 0)
			{
				foreach ($dane as $k => $v)
				{
						if($v === true) $v = 'true';
						if($v === false) $v = 'false';
						if (is_object($v)) $v = get_class($v);
						$dodatkowe .= $k . '=' . str_replace(';', ' ', $v) . ';';
				}
			}
			$wiersz[] = $dodatkowe;
			$wiersz[] = (Cms::inst()->profil() instanceof Uzytkownik\Obiekt) ? Cms::inst()->profil()->id : 0;
			$wiersz[] = Zadanie::adresIp();
			$wiersz[] = (!empty($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : 'nieznana';
			$wiersz[] = Zadanie::wywolanyUrl();

			$this->zdarzenia[] = implode(' | ', $wiersz) . "\r\n\r\n\r\n";
		}
	}



	public function __destruct()
	{
		if ( ! empty($this->zdarzenia))
		{
			file_put_contents($this->plikLog, implode("\r\n\r\n\r\n", $this->zdarzenia), FILE_APPEND);
		}
	}

}
