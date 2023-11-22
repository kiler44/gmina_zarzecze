<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Cms;


/**
 * Klasa obsługująca pole tekstowe(text).
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class Text extends Input
{

	protected $katalogSzablonu = 'TextNew';
	
	protected $tpl = '
{{BEGIN licznik}}
<input type="text" name="{{$nazwa}}" id="{{$nazwa}}" value="{{$wartosc}}" {{$atrybuty}} />
				<span id="lim_{{$nazwa}}"></span>
<script type="text/javascript">
	var limit{{$nazwa}} = {{$maxlength}};

	$("#{{$nazwa}}").focus(function(){
		liczbaZnakow(\'{{$nazwa}}\', limit{{$nazwa}}, \'lim_{{$nazwa}}\', \'{{$input_text_etykieta_licznik}}\');
	});

	$("#{{$nazwa}}").keyup(function(){
		liczbaZnakow(\'{{$nazwa}}\', limit{{$nazwa}}, \'lim_{{$nazwa}}\', \'{{$input_text_etykieta_licznik}}\');
	});

	liczbaZnakow(\'{{$nazwa}}\', limit{{$nazwa}}, \'lim_{{$nazwa}}\', \'{{$input_text_etykieta_licznik}}\');
</script>
{{END}}

{{BEGIN dlugoscBezSpacji}}
<input type="text" name="{{$nazwa}}" id="{{$nazwa}}" value="{{$wartosc}}" {{$atrybuty}} />
				<p><span id="lim_{{$nazwa}}"></span>&nbsp;</p>
<script type="text/javascript">
	var limit{{$nazwa}} = {{$dlugosc_bez_spacjis}};


	function liczbaZnakowBezSpacji(id, limit, info_id, komunikat)
	{
		var text = $(\'#\'+id).val();
		var textlength = text.length - text.split(\' \').length + 1;

		if (textlength > limit)
		{
			$(\'#\'+id).val(text.substr(0,limit + text.split(\' \').length - 1));
			textlength = limit;
		}

		$(\'#\' + info_id).html(komunikat.replace(\'{LICZBA}\', (textlength)).replace(\'{LIMIT}\', limit));
		return true;
	}

	$("#{{$nazwa}}").focus(function(){
		liczbaZnakowBezSpacji(\'{{$nazwa}}\', limit{{$nazwa}}, \'lim_{{$nazwa}}\', \'{{$input_text_etykieta_licznik_bez_spacji}}\');
	});

	$("#{{$nazwa}}").blur(function(){
		liczbaZnakowBezSpacji(\'{{$nazwa}}\', limit{{$nazwa}}, \'lim_{{$nazwa}}\', \'{{$input_text_etykieta_licznik_bez_spacji}}\');
	});

	$("#{{$nazwa}}").keyup(function(){
		liczbaZnakowBezSpacji(\'{{$nazwa}}\', limit{{$nazwa}}, \'lim_{{$nazwa}}\', \'{{$input_text_etykieta_licznik_bez_spacji}}\');
	});

	liczbaZnakowBezSpacji(\'{{$nazwa}}\', limit{{$nazwa}}, \'lim_{{$nazwa}}\', \'{{$input_text_etykieta_licznik_bez_spacji}}\');
</script>
{{END}}

{{BEGIN domyslny}}
<input type="text" name="{{$nazwa}}" id="{{$nazwa}}" value="{{$wartosc}}" {{$atrybuty}} />

	{{BEGIN domyslnyNapis}}
	<script>
		if ($("#{{$nazwa}}").val() == "")
		{
			$("#{{$nazwa}}").val("{{$domyslny_napis}}");
		}
		$("#{{$nazwa}}").focus(function () {
			if ($("#{{$nazwa}}").val() == "{{$domyslny_napis}}")
			{
				$("#{{$nazwa}}").val("");
			}
		})
		$("#{{$nazwa}}").blur(function () {
			if ($("#{{$nazwa}}").val() == "")
			{
				$("#{{$nazwa}}").val("{{$domyslny_napis}}");
			}
		})
	</script>
	{{END}}
{{END}}
';



	function pobierzHtml()
	{
		$cms = Cms::inst();

		//ustawienie domyślnej klasy css long
		if (isset($this->parametry['atrybuty']['class']))
		{
			$this->parametry['atrybuty']['class'] .= ' long';
		}
		else
		{
			$this->parametry['atrybuty']['class'] = 'long';
		}

		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'wartosc' => htmlspecialchars($this->pobierzWartosc()),
			'atrybuty' => $this->pobierzAtrybuty(),
			'input_text_etykieta_licznik' => $this->tlumaczenia['input_text_etykieta_licznik'],
			'input_text_etykieta_licznik_bez_spacji' => $this->tlumaczenia['input_text_etykieta_licznik_bez_spacji'],
		);
		
		if (isset($this->parametry['licznik']) && $this->parametry['licznik'])
		{
			$dane['maxlength'] = isset($this->parametry['atrybuty']['maxlength']) ? $this->parametry['atrybuty']['maxlength'] : 9999;
			return $this->szablon->parsujBlok('licznik', $dane);
		}
		elseif (isset($this->parametry['dlugoscBezSpacji']) && $this->parametry['dlugoscBezSpacji'] > 0)
		{
			$dane['dlugosc_bez_spacji'] = intval($this->parametry['dlugoscBezSpacji']);
			return $this->szablon->parsujBlok('dlugoscBezSpacji', $dane);
		}
		elseif (isset($this->parametry['spinner']) && $this->parametry['spinner'])
		{
			$dane['spinner_min'] = (isset($this->parametry['spinner_min'])) ? $this->parametry['spinner_min'] : 0;
			$dane['spinner_max'] =  (isset($this->parametry['spinner_max'])) ? $this->parametry['spinner_max'] : 99999;
			$dane['spinner_skok'] =  (isset($this->parametry['spinner_skok'])) ? $this->parametry['spinner_skok'] : 1;
			return $this->szablon->parsujBlok('spinner', $dane);
		}
		else
		{
			if (isset($this->parametry['domyslny_napis']) && $this->parametry['domyslny_napis'] != '')
			{
				$dane['domyslny_napis'] = $this->parametry['domyslny_napis'];
				$this->szablon->ustawBlok('/domyslny/domyslnyNapis', $dane);
			}

			return $this->szablon->parsujBlok('domyslny', $dane);
		}
	}

}
