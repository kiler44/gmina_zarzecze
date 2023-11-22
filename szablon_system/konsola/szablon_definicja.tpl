<?php

namespace Generic\Model\{{NAZWA}};
use Generic\Model\Projekt;
use Generic\Biblioteka;

/**
 * show off @property, @property-read, @property-write
 *
{{BEGIN PODPOWIEDZI}}
 * @property {{$TYP}} ${{$NAZWA}} {{KOMENTARZ}}
{{END}}
 */
class Definicja extends Biblioteka\DefinicjaObiektu
{



	/**
	* Przetrzymuje typy pól w bazie.
	* @var array
	*/
	public $polaObiektuTypy = array(
{{BEGIN POLA_OBIEKTU_TYPY}}
		'{{NAZWA_POLA}}' => self::_{{TYP_POLA}},{{KOMENTARZ}}
{{END}}
	);



	/**
	* Domyślne wartości dla kolumn, które nie mogą być puste (NOT NULL).
	* @var array
	*/
	public $domyslneWartosci = array(
{{BEGIN DOMYSLNE_WARTOSCI_POL}}
		'{{NAZWA_POLA}}' => '{{DOMYSLNA_WARTOSC_POLA}}',{{KOMENTARZ}}
{{END}}
	);



	/**
	* Dopuszczalne wartości dla pól enum.
	* @var array
	*/
	public $dopuszczalneWartosci = array(
{{BEGIN DOPUSZCZALNE_WARTOSCI}}
		'{{NAZWA_POLA}}' => array(
		{{BEGIN DOPUSZCZALNA_WARTOSC}}
			{{KOMENTARZ1}}'{{WARTOSC}}',{{KOMENTARZ2}}
		{{END}}
		),{{KOMENTARZ}}

{{END}}
	);



	/**
	* Definicja pól dla formularza tego obiektu.
	* @var array
	*/
	public $polaFormularza = array(
{{BEGIN POLA_FORMULARZA}}
		'{{NAZWA_POLA}}' => array(
		{{BEGIN INPUT}}
			'input' => '{{TYP_INPUTA}}',{{KOMENTARZ}}
		{{END}}
		{{BEGIN FILTROWANIE}}
			'filtry' => array(
			{{BEGIN FILTR}}
				'{{NAZWA_FILTRA}}',{{KOMENTARZ}}
			{{END}}
			),
		{{END}}
		{{BEGIN WYMAGANE}}
			'wymagane' => {{WYMAGAJ}},{{KOMENTARZ}}
		{{END}}
		{{BEGIN WALIDATORY}}
			'walidatory' => array(
				{{BEGIN WALIDATOR}}
					'{{WALIDATOR}}'{{BEGIN WARTOSC}} => {{WARTOSC}}{{END}}{{BEGIN DOZWOLONE_TABLICA}} => array({{BEGIN DOZWOLONE}}'{{DOZWOLONA_WARTOSC}}',{{END}}){{END}},{{KOMENTARZ}}
				{{END}}
			),
		{{END}}
		),

	{{END}}
	);
}