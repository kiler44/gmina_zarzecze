<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;


/**
 * Klasa wyświetlająca dowolną treść html z linkiem do jej zmiany.
 *
 * @author Konrad Rudowski
 * @package biblioteki
 */

class HtmlZmiana extends Input
{
	protected $katalogSzablonu = 'HtmlChangesNew';
	protected $tpl = '
	<div id="{{$nazwa}}" {{$atrybuty}}><strong>{{$wartosc}}</strong> {{IF $link_etykieta}}<span class="links" style="float:right;"><a href="{{$link_adres}}">{{$link_etykieta}}</a></span>{{END}}</div>
	';

	function pobierzHtml()
	{
		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'wartosc' => $this->pobierzWartosc(),
			'atrybuty' => $this->pobierzAtrybuty(),
		);
		if (isset($this->parametry['link_etykieta']) && (isset($this->parametry['link_adres']) && $this->parametry['link_adres'] != ''))
		{
			$dane = array_merge($dane, array(
				'link_etykieta' => $this->parametry['link_etykieta'],
				'link_adres' => $this->parametry['link_adres'],
			));
		}

		$this->szablon->ustaw($dane);

		return $this->szablon->parsuj();
	}

}
