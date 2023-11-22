<?php
namespace Generic\Tlumaczenie\{{JEZYK}}\{{MODEL_MODUL}};

use Generic\Tlumaczenie\Tlumaczenie;

/**
{{BEGIN PODPOWIEDZ}}
{{BEGIN ETYKIETA}}
 * @property string $t['{{NAZWA}}.etykieta']{{KOMENTARZ}}
{{END}}
{{BEGIN OPIS}}
 * @property string $t['{{NAZWA}}.opis']{{KOMENTARZ}}
{{END}}
{{BEGIN WARTOSCI}}
 * @property array $t['{{NAZWA}}']{{KOMENTARZ}}
{{END}}
{{END}}
 */
class {{NAZWA_KLASY}} extends Tlumaczenie
{

	protected $tlumaczeniaDomyslne = array(
	{{BEGIN TLUMACZENIE}}
		{{BEGIN ETYKIETA}}
		'{{NAZWA}}.etykieta' => '{{WARTOSC}}',{{KOMENTARZ}}
		{{END}}
		{{BEGIN OPIS}}
		'{{NAZWA}}.opis' => '{{WARTOSC}}',{{KOMENTARZ}}
		{{END}}
		{{BEGIN WARTOSCI}}
		'{{NAZWA}}.wartosci' => array(
			{{BEGIN WARTOSC}}
			'{{NAZWA}}' => '{{WARTOSC}}',{{KOMENTARZ}}
			{{END}}
		),{{KOMENTARZ}}
		{{END}}

	{{END}}
	);
}