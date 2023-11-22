<?php
namespace Generic\Tlumaczenie\No\Modul\Notes;

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie 
 */
class Cron extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
		'przypomnienie_brak_notatki' => 'Påminnelse. Du har ikke lagt til i dag notat til prosjektet som du er en leder ({PROJEKT_NAZWA} BKT Id. {BKT_ID}). Logg deg på til panelet og legge notat.',
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
	);
}