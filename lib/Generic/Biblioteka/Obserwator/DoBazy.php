<?php
namespace Generic\Biblioteka\Obserwator;
use Generic\Biblioteka\Zdarzenia;
use Generic\Model\Obserwator;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Model\Log;
use Generic\Biblioteka\Zadanie;
use Generic\Model\Uzytkownik;


/**
 * Klasa obserwatora logujaca zdarzenie do bazy
 *
 * @author Krzysztof Żak
 * @package biblioteki
 */

class DoBazy extends Zdarzenia\Obserwator
{

	private $zdarzenia = array();


	protected function ustawieniaObserwatora(Obserwator\Obiekt $obserwator)
	{
	}



	protected function obsluzZdarzenie(Zdarzenia\Zdarzenie $zdarzenie)
	{
		$zrodlo = $zdarzenie->pobierzZrodlo();
		if ($zrodlo instanceof Modul)
		{
			$dane = $zdarzenie->pobierzDane();

			$cms = Cms::inst();

			$akcja = $dane['zdarzenie'];
			unset($dane['zdarzenie']);
			$dodatkowe = '';

			if (count($dane) > 0)
			{
				foreach ($dane as $k => $v)
				{
					if($v === true) $v = 'true';
					if($v === false) $v = 'false';
					if (is_object($v)) $v = get_class($v);
					$dodatkowe .= $k . '=' . str_replace(';', '', $v) . ';';
				}
			}

			$kod = explode('_', $zrodlo->pobierzNazweModulu());
			$usluga = $kod[1];
			$modul = $kod[0];

			$log = new Log\Obiekt();
			$log->idProjektu = ID_PROJEKTU;
			$log->kodJezyka = KOD_JEZYKA;
			$log->czas = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
			$log->adresIp = Zadanie::adresIp();
			$log->przegladarka = (!empty($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : 'nieznana';
			$log->zadanieHttp = Zadanie::wywolanyUrl();
			$log->idUzytkownika = ($cms->profil() instanceof Uzytkownik\Obiekt) ? (int)$cms->profil()->id : 0;
			$log->idKategorii = $zrodlo->pobierzIdKategorii();
			$log->usluga = $usluga;
			$log->kodModulu = $modul;
			$log->akcja = $akcja;
			$log->daneDodatkowe = $dodatkowe;

			$this->zdarzenia[] = $log;
		}
	}



	public function __destruct()
	{
		if ( ! empty($this->zdarzenia))
		{
			foreach($this->zdarzenia as $klucz => $log)
			{
				$log->zapisz(Cms::inst()->dane()->Log());
			}
		}
	}

}
