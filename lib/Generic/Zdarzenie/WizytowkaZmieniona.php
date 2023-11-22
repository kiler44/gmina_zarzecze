<?php
namespace Generic\Zdarzenie;
use Generic\Biblioteka\Zdarzenia\Zdarzenie;
use Generic\Biblioteka\Zdarzenia\Zdarzenie\WizytowkiZmiany;

/**
 * Zdarzenie informujace o zmianie danych wizytowki
 *
 * @author Krzysztof Lesiczka
 * @package dane
 */

class WizytowkaZmieniona extends Zdarzenie implements WizytowkiZmiany
{

	protected $daneWymagane = array(
		'obiekt_Wizytowka' => 'Generic\Model\Wizytowka\Obiekt',
	);

}
