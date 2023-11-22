<?php
namespace Generic\Konfiguracja\{{$typ}}\{{$nazwa}};

use Generic\Konfiguracja\Konfiguracja;

/**
 * Zawiera konfigurację dla {{czego}}
 *{{BEGIN wiersz}}
 * @property {{$wartoscTyp}} $k['{{$klucz}}']{{END}}
 */
class {{$nazwaKlasy}} extends Konfiguracja
{
	/**
	* Domyślna konfiguracja
	* @var array
	*/
	protected $konfiguracjaDomyslna = array(
	{{BEGIN wiersz}}

	'{{$klucz}}' => array({{IF $todo}}//TODO{{END}}{{BEGIN wiersz2}}
		'{{$klucz2}}' => {{IF $wartosc2}}{{$wartosc2}}{{ELSE}}null{{END}},{{END}}{{BEGIN wiersz2Tablica}}
		'{{$klucz2}}' => array({{BEGIN wiersz3}}
			{{$klucz3}} => {{$wartosc3}},{{END}}
			{{BEGIN wiersz3Lista}}
			{{$wartosc3}},
			{{END}}
			),{{END}}
		),
	{{END}}

	);
}