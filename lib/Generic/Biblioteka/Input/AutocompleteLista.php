<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;


/**
 * Klasa obsługująca listę wybranych z efektem autocomplete
 *
 * @author Łukasz Wrucha, Krzysztof Lesiczka
 * @package biblioteki
 */

class AutocompleteLista extends Input
{
	protected $katalogSzablonu = 'AutocompleteListNew';
	protected $tpl = '
	<table border="0"><tr><td style="width: 400px;">
	{{BEGIN dodawanie_wierszy}}
		<input type="text" id="{{$nazwa}}_dodaj_inne" name="{{$nazwa}}_dodaj_inne"/>
		<input type="button" id="{{$nazwa}}_dodaj_inne_potwierdz" name="{{$nazwa}}_dodaj_inne_potwierdz" value="{{$etykieta_inne_potwierdz}}"/>
	{{END}}
	&nbsp;</td><td>&nbsp;</td><td style="vertical-align: middle;">
	{{$etykieta_wyszukaj}} <input type="text" id="{{$nazwa}}_podpowiedz" name="{{$nazwa}}_podpowiedz"/>
	</td></tr><tr><td style="width: 400px;">

	{{$etykieta_wybrane}}<br/>
	<select size="10" class="wybrane" multiple="multiple" style="width: 100%;" name="{{$nazwa}}_wybrane[]" id="{{$nazwa}}_wybrane" {{$atrybuty}}>
		{{BEGIN opcje_wybrane}}<option value="{{$wartosc}}" title="{{$etykieta}}" >{{$etykieta}}</option>{{END}}
	</select>
	</td><td style="vertical-align: middle;">
	<input id="{{$nazwa}}_dodaj" value="{{$etykieta_dodaj}}" type="button"/><br/><br/>
	<input id="{{$nazwa}}_usun" value="{{$etykieta_usun}}" type="button"/>
	</td><td style="width: 400px;">
	{{$etykieta_dostepne}}<br/>
	<select size="10" multiple="multiple" style="width: 100%;" name="{{$nazwa}}_lista[]" id="{{$nazwa}}_lista" {{$strybuty}}>
		{{BEGIN opcje_dostepne}}<option value="{{$klucz}}" title="{{$etykieta}}">{{$etykieta}}</option>{{END}}
	</select>
	</td></tr></table><div id="{{$nazwa}}_wartosc"></div>

<script type="text/javascript">
<!--

function {{$nazwa}}_odswierz()
{
	$(\'#{{$nazwa}}_lista option\').live(\'dblclick\', function() {
		$(this).appendTo(\'#{{$nazwa}}_wybrane\');
	});

	$(\'#{{$nazwa}}_wybrane option\').live(\'dblclick\', function() {
		$(this).appendTo(\'#{{$nazwa}}_lista\');
	});
}

function {{$nazwa}}_wartosci()
{
	$(\'#{{$nazwa}}_wartosc input\').remove();
	$(\'#{{$nazwa}}_wybrane option\').each(function() {
		$(\'#{{$nazwa}}_wartosc\').append(\'<input type="hidden" name="{{$nazwa}}[]" value="\' + $(this).val() + \'"/>\');
	});
	if ($(\'#{{$nazwa}}_wartosc input\').size() < 1) {
		$(\'#{{$nazwa}}_wartosc\').append(\'<input type="hidden" name="{{$nazwa}}[]" value=""/>\');
	}
}

$(document).ready(function(){
	
	$(\'#{{$nazwa}}_lista option\').live(\'dblclick\', function() {
		$(this).appendTo(\'#{{$nazwa}}_wybrane\');
		{{$nazwa}}_wartosci();
		{{$nazwa}}_odswierz();
	});

	$(\'#{{$nazwa}}_wybrane option\').live(\'dblclick\', function() {
		$(this).appendTo(\'#{{$nazwa}}_lista\');
		{{$nazwa}}_wartosci();
		{{$nazwa}}_odswierz();
	});

	$("#{{$nazwa}}_dodaj").click(function () {
		$("#{{$nazwa}}_lista option:selected").each(function () {
			$(this).appendTo(\'#{{$nazwa}}_wybrane\');
		});
		{{$nazwa}}_odswierz();
		{{$nazwa}}_wartosci();
	});

	{{IF $dodawanie_wierszy}}
		$("#{{$nazwa}}_dodaj_inne_potwierdz").click(function () {
			var nowa = $("#{{$nazwa}}_dodaj_inne").val();
			if (nowa != "") {
				var s = document.getElementById("{{$nazwa}}_wybrane");
				s.options[s.options.length]= new Option(nowa, nowa);
				$("#{{$nazwa}}_dodaj_inne").val("");
			}
			{{$nazwa}}_odswierz();
			{{$nazwa}}_wartosci();
		});
	{{END}}


	$("#{{$nazwa}}_usun").click(function () {
		$("#{{$nazwa}}_wybrane option:selected").each(function () {
			$(this).appendTo(\'#{{$nazwa}}_lista\');
		});
		{{$nazwa}}_odswierz();
		{{$nazwa}}_wartosci();
	});

	$(\'#{{$nazwa}}_podpowiedz\').keyup(function() {
		var fraza = jQuery.trim($(this).val());

		if (fraza != \'\') {
			$("#{{$nazwa}}_lista option").each(function () {
				if (eval("/" + fraza + "/i").test(this.text) > 0) {
					$(this).show();
				} else {
					$(this).hide();
				}
			});
		} else {
			$("#{{$nazwa}}_lista option").each(function () { $(this).show();});
		}
		{{$nazwa}}_odswierz();
	});

	{{$nazwa}}_wartosci();
});
-->
</script>';


	protected $parametry = array(
		'lista' => array(),
		'title' => array(),
		'dodawanie_wierszy' => false,
	);


	/**
	 * Pobiera obecna wartosc inputa.
	 *
	 * @return mixed Obecna wartosc inputa.
	 */
	function pobierzWartosc()
	{
		if ($this->wymusPoczatkowa)
		{
			return $this->pobierzWartoscPoczatkowa();
		}
		if ($this->filtrowany)
		{
			return $this->wartosc;
		}
		$temp = Zadanie::pobierz($this->pobierzNazwe());
		if (is_array($temp))
		{
			$czyPustePole = function($v) { return ! (is_string($v) && $v === ''); };
			$this->wartosc = $this->filtrujWartosc(array_filter(array_values($temp), $czyPustePole));
		}
		else
		{
			$this->wartosc = $this->pobierzWartoscPoczatkowa();
		}

		return $this->wartosc;
	}



	/**
	 * Filtruje wartosc podana w argumencie
	 *
	 * @param array $tablica Wartosc do filtrowania.
	 * @return array Wartosc po zastosowaniu filtrow.
	 */
	protected function filtrujWartosc($tablica)
	{
		foreach($this->filtry as $filtr)
		{
			foreach ($tablica as $klucz => $wartosc)
			{
				$tablica[$klucz] = $filtr($wartosc);
			}
		}
		$this->filtrowany = true;
		return $tablica;
	}



	/**
	 * Sprawdza czy input zostal zmodyfikowany.
	 *
	 * @return bool True jezel input zostal zmodyfikowany, false w przeciwnym wypadku.
	 */
	function zmieniony()
	{
		return ($this->pobierzWartosc() != $this->pobierzWartoscPoczatkowa());
	}



	function pobierzHtml()
	{
		$lista = array();
		if (is_array($this->parametry['lista']) && count($this->parametry['lista']) > 0)
		{
			$lista = $this->parametry['lista'];
			if(isset($this->parametry['title']))
				$title = $this->parametry['title'];
		}
		else
		{
			trigger_error('Brak listy danych dla pola AutoComplete', E_USER_WARNING);
		}

		$wybrane = $this->pobierzWartosc();
		$wybrane = (is_array($wybrane)) ? $wybrane : array($wybrane);
		$wybrane = array_filter($wybrane);

		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'atrybuty' => $this->pobierzAtrybuty(),
			'etykieta_wyszukaj' => $this->tlumaczenia['input_autocomplite_lista_etykieta_wyszukaj'],
			'etykieta_wybrane' => $this->tlumaczenia['input_autocomplite_lista_etykieta_wybrane'],
			'etykieta_dodaj' => $this->tlumaczenia['input_autocomplite_lista_etykieta_dodaj'],
			'etykieta_usun' => $this->tlumaczenia['input_autocomplite_lista_etykieta_usun'],
		);

		$this->szablon->ustawGlobalne($dane);

		if ($this->parametry['dodawanie_wierszy'])
		{
			$dane['dodawanie'] = true;
			$dane['dodawanie_wierszy'] = array(
				'etykieta_inne_potwierdz' => $this->tlumaczenia['input_autocomplite_lista_etykieta_dodaj_inne_potwierdz'],
			);
		}

		if (count($wybrane) > 0)
		{
			foreach($wybrane as $wartosc)
			{
				$etykieta = (isset($lista[$wartosc])) ? $lista[$wartosc] : $wartosc;
				 
				if(isset($title[$wartosc]))
				{
					$opis = $title[$wartosc];
				}
				else
				{
					$opis = $etykieta;
				}
				
				$dane['opcje_wybrane'][] = array(
					'wartosc' => $wartosc,
					'etykieta' => $etykieta,
					'title' => $opis,
				);
			}
		}


		if (count($lista) > 0)
		{
			foreach($lista as $klucz => $etykieta)
			{
				if (in_array($klucz, $wybrane)) continue;
				
				if(isset($title[$klucz]))
				{
					$opis = $title[$klucz];
				}
				else
				{
					$opis = $etykieta;
				}
				
				$dane['opcje_dostepne'][] = array(
					'klucz' => $klucz,
					'etykieta' => $etykieta,
					'title' => $opis,
				);
			}
		}

		$this->szablon->ustaw($dane);

		return $this->szablon->parsuj();
	}

}

