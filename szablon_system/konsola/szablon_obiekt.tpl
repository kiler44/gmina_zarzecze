<?php
namespace Generic\Model\{{NAZWA}};
use Generic\Biblioteka\ObiektDanych;

/**
 * show off @property, @property-read, @property-write
 *
{{BEGIN KOMENTARZ}}
 * @property {{$TYP}} ${{$NAZWA}} {{KOMENTARZ}}
{{END}}
 */

class Obiekt extends ObiektDanych
{
	/**
	 * @var \Generic\Konfiguracja\Model\{{NAZWA}}\Obiekt
	 */
	protected $k;

	/**
	 * @var \Generic\Tlumaczenie\Pl\Model\{{NAZWA}}\Obiekt
	 */
	protected $j;
}