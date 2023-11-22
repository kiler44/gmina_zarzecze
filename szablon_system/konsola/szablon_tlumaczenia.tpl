<?php
namespace Generic\Tlumaczenie\{{$jezyk}}\{{$typ}}\{{$nazwa}};

use Generic\Tlumaczenie\Tlumaczenie;

/**
 * Zawiera tłumaczenie {{czego}}
{{BEGIN wartoscTekst}}
 * @property string $t['{{$klucz}}']
{{END}}
{{BEGIN wartoscTablica}} * @property array $t['{{$klucz}}']{{BEGIN wartoscTekst2}}
 * @property string $t['{{$klucz}}']['{{$klucz2}}']{{END}}
 {{END}}
 */
class {{$nazwaKlasy}} extends Tlumaczenie
{
	/**
	* Tłumaczenia domyślne
	* @var array
	*/
	protected $tlumaczeniaDomyslne = array(
	{{BEGIN wartoscTekst}}
		'{{$klucz}}' => '{{$wartosc}}',{{ if($todo, '	//TODO', '')}}
	{{END}}

{{BEGIN wartoscTablica}}
		'{{$klucz}}' => array(
{{BEGIN wartoscTekst2}}			'{{$klucz2}}' => '{{$wartosc2}}',{{ if($todo, '	//TODO', '')}}
		{{END}}
		),
	{{END}}
	);

	/**
	* Typy pól tłumaczeń
	*/
	protected $typyPolTlumaczen = array(
{{BEGIN typPola}}		'{{$klucz}}' => '{{$wartosc}}',
		{{END}}
	);
}