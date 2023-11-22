<?php
namespace Generic\Zdarzenie;
use Generic\Biblioteka\Zdarzenia\Zdarzenie;

/**
 * Zdarzenie informujace o dodaniu nowej wizytowki
 *
 * @author Krzysztof Lesiczka
 * @package dane
 */

class WizytowkaDodana extends Zdarzenie
{

	protected $daneWymagane = array(
		'obiekt_Wizytowka' => 'Generic\Model\Wizytowka\Obiekt',
	);

}
