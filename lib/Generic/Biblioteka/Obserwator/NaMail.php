<?php
namespace Generic\Biblioteka\Obserwator;
use Generic\Biblioteka\Zdarzenia;
use Generic\Model\Obserwator;
use Generic\Biblioteka\Modul;
use Generic\Biblioteka\Cms;
use Generic\Model\Uzytkownik;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Pomocnik;


/**
 * Klasa obserwatora wysyjaca maila o zdarzeniu
 *
 * @author Krzysztof Żak
 * @package biblioteki
 */

class NaMail extends Zdarzenia\Obserwator
{

	private $odbiorca;

	private $zdarzenia;



	protected function ustawieniaObserwatora(Obserwator\Obiekt $obserwator)
	{
		$this->odbiorca = $obserwator->obiekt_docelowy;
	}



	protected function obsluzZdarzenie(Zdarzenia\Zdarzenie $zdarzenie)
	{
		$zrodlo = $zdarzenie->pobierzZrodlo();
		if ($zrodlo instanceof Modul)
		{
			$dane = $zdarzenie->pobierzDane();

			$wiersz = array();
			$wiersz['data'] = date('Y-m-d H:i:s', $_SERVER['REQUEST_TIME']);
			$wiersz['nazwa_modulu'] = $zrodlo->pobierzNazweModulu();
			$wiersz['zdarzenie'] = $dane['zdarzenie'];
			unset($dane['zdarzenie']);
			$dodatkowe = '';
			if (count($dane) > 0)
			{
				foreach ($dane as $k => $v)
				{
					if($v === true) $v = 'true';
					if($v === false) $v = 'false';
					if (is_object($v)) $v = get_class($v);
					$dodatkowe .= $k.' => '.$v."\r\n";
				}
			}
			$wiersz['uzytkownik_id'] = (Cms::inst()->profil() instanceof Uzytkownik\Obiekt) ? Cms::inst()->profil()->id : 0;
			$wiersz['ip'] = Zadanie::adresIp();
			$wiersz['przegladarka'] = (!empty($_SERVER['HTTP_USER_AGENT'])) ? $_SERVER['HTTP_USER_AGENT'] : 'nieznana';
			$wiersz['wywolany_url'] = Zadanie::wywolanyUrl();
			$wiersz['dodatkowe'] = $dodatkowe;

			$linia = '';

			foreach($wiersz as $klucz => $wartosc)
			{
				if($klucz == 'dodatkowe') continue;
				$linia .= $klucz . ' => ' . $wartosc . "\r\n";
			}

			$this->zdarzenia[] = $linia . $wiersz['dodatkowe'];
		}
	}



	public function __destruct() {

		if( ! empty($this->zdarzenia))
		{
			$poczta = new Pomocnik\Poczta();
			$poczta->wczytajUstawienia(array(
				'przygotujWiadomosc' => false,
				'emailOdbiorcy' => array($this->odbiorca),
				'emailTytul' => 'Nowe zdarzenie w serwisie',
				'emailTrescHtml' => str_replace("\r\n", "<br />", implode("<br />", $this->zdarzenia)),
				'emailTrescTxt' => implode("\r\n", $this->zdarzenia),
			));
			$wynik = $poczta->wyslij();
		}
	}

}