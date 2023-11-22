<?php
namespace Generic\Zdarzenie;
use Generic\Biblioteka\Zdarzenia\Zdarzenie;
use Generic\Biblioteka\Zdarzenia\Zdarzenie\UzytkownikZmiany;

/**
 * Zdarzenie informujace aktywnej sesji użytkownika
 *
 * @author Konrad Rudowski
 * @package dane
 */

class UzytkownikAktualnieZalogowany extends Zdarzenie implements UzytkownikZmiany
{

	protected $etykietaObiektuGlownego = 'obiekt_Uzytkownik';

	protected $daneWymagane = array(
		'obiekt_Uzytkownik' => 'Generic\\Model\\Uzytkownik\\Obiekt',
	);

}
