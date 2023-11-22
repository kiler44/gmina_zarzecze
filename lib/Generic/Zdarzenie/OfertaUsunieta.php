<?php
namespace Generic\Zdarzenie;
use Generic\Biblioteka\Zdarzenia\Zdarzenie;
use Generic\Biblioteka\Zdarzenia\Zdarzenie\OgloszeniaZmiany;

/**
 * Zdarzenie informujace o usunieciu oferty
 *
 * @author Krzysztof Lesiczka
 * @package dane
 */

class OfertaUsunieta extends Zdarzenie implements OgloszeniaZmiany
{

	protected $daneWymagane = array(
		'obiekt_Ogloszenie' => 'Generic\Model\Ogloszenie\Obiekt',
	);

}
