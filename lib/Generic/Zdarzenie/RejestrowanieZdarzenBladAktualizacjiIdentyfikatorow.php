<?php
namespace Generic\Zdarzenie;
use Generic\Biblioteka\Zdarzenia\Zdarzenie;
use Generic\Biblioteka\Zdarzenia\Zdarzenie\RejestrowanieZdarzen;

/**
 * Zdarzenie informujace o fakcie zaktualizowania identyfikatorow obiektow na podstawie tokenów formularzy
 *
 * @author Konrad Rudowski
 * @package dane
 */

class RejestrowanieZdarzenBladAktualizacjiIdentyfikatorow extends Zdarzenie implements RejestrowanieZdarzen
{

	protected $daneWymagane = array(
	);

}
