<?php
namespace Generic\Biblioteka\Pomocnik;
use Generic\Biblioteka\Kontener;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka;
use Generic\Model\TidsbankenHours;
use Generic\Model\Uzytkownik;

/**
 * Description of TidsbankenHours
 *
 * @author Marcin
 */
class TidsbankenLogin {
	
	private $tidsbankenGodziny;
	
	public function __construct(TidsbankenHours\Obiekt $tidsbankenGodziny) {
		$this->tidsbankenGodziny = $tidsbankenGodziny;
	}
	
	private function pobierzPracownika()
	{
		$pracownik = Cms::inst()->dane()->Uzytkownik()->pobierzPoId($this->tidsbankenGodziny->idUser);
		if($pracownik instanceof Uzytkownik\Obiekt)
		{
			return $pracownik;
		}
		else
		{
			$pracownik = new Uzytkownik\Obiekt();
		}
		return $pracownik;
	}
	
	private function pobierzDateStart()
	{
		return $this->tidsbankenGodziny->start;
	}
	
	private function pobierzDateStop()
	{
		return $this->tidsbankenGodziny->stop;
	}
	
	
}

