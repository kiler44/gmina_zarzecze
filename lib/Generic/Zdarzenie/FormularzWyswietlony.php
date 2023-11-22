<?php
namespace Generic\Zdarzenie;
use Generic\Biblioteka\Zdarzenia\Zdarzenie;
use Generic\Biblioteka\Zdarzenia\Zdarzenie\Formularze;

/**
 * Zdarzenie informujace o wyswietleniu formularza
 *
 * @author Konrad Rudowski
 * @package dane
 */

class FormularzWyswietlony extends Zdarzenie implements Formularze
{

	protected $daneWymagane = array(
	);

}
