<?php
namespace Generic\Konfiguracja\{{$typ}}\{{$nazwa}};

use Generic\Tlumaczenia\Tlumaczenia;

/**
{{BEGIN wartoscTablica}}
 * @property array $t['{{$klucz}}']{{END}}
{{BEGIN wartoscTekst}}
 * @property {{$wartoscTyp}} $t[\'{{$klucz}}\']{{END}}
 */

class {{$nazwaKlasy}} extends Tlumaczenie
{
	protected $tlumaczeniaDomyslne = array(
{{BEGIN wartoscTablica}}
	\'{{$klucz}}\' => array(
	{{BEGIN wartoscTekst2}}
		\'{{$klucz2}}\' => {{$todo}}\'\'//TODO{{END}}{{BEGIN wiersz2}}
	{{END}}
{{END}}
{{BEGIN wartoscTekst}}

{{END}}
	\'{{$klucz}}\' => array({{IF $todo}}//TODO{{END}}{{BEGIN wiersz2}}
		\'{{$klucz2}}\' => {{IF $wartosc2}}{{$wartosc2}}{{ELSE}}null{{END}},{{END}}{{BEGIN wiersz2Tablica}}
		\'{{$klucz2}}\' => array({{BEGIN wiersz3}}
			{{$klucz3}} => {{$wartosc3}},{{END}}
			{{BEGIN wiersz3Lista}}
			{{$wartosc3}},
			{{END}}
			),{{END}}
		),
	

	);
}