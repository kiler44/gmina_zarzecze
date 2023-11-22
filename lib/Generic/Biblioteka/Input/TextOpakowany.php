<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Cms;


/**
 * Klasa obsługująca pole tekstowe(text) z etykietami z przodu i z tyłu.
 *
 * @author Krzysztof Żak
 * @package biblioteki
 */

class TextOpakowany extends Input
{
	protected $katalogSzablonu = 'TextCoverNew';
	protected $parametry = array(
		'etykieta_poczatek' => '',
		'etykieta_koniec' => '',
	);

	protected $tpl = '
{{BEGIN licznik}}
{{$etykieta_poczatek}}<input type="text" name="{{$nazwa}}" id="{{$nazwa}}" value="{{$wartosc}}" {{$atrybuty}} />{{$etykieta_koniec}}
				<p><span id="lim_{{$nazwa}}"></span>&nbsp;</p>
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
{{$etykieta_poczatek}}<input type="text" name="{{$nazwa}}" id="{{$nazwa}}" value="{{$wartosc}}" {{$atrybuty}} />{{$etykieta_koniec}}
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
{{$etykieta_poczatek}}<input type="text" name="{{$nazwa}}" id="{{$nazwa}}" value="{{$wartosc}}" {{$atrybuty}} />{{$etykieta_koniec}}

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

		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'wartosc' => htmlspecialchars($this->pobierzWartosc()),
			'atrybuty' => $this->pobierzAtrybuty(),
			'input_text_etykieta_licznik' => $cms->lang['inputy']['input_text_etykieta_licznik'],
			'input_text_etykieta_licznik_bez_spacji' => $cms->lang['inputy']['input_text_etykieta_licznik_bez_spacji'],
			'etykieta_poczatek' => $this->parametry['etykieta_poczatek'],
			'etykieta_koniec' => $this->parametry['etykieta_koniec'],
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
		else
		{
			if (isset($this->parametry['domyslny_napis']) && $this->parametry['domyslny_napis'] != '')
			{
				$dane['domyslny_napis'] = $this->parametry['domyslny_napis'];
				$this->szablon->ustawBlok('domyslny/domyslnyNapis', $dane);
			}

			return $this->szablon->parsujBlok('domyslny', $dane);
		}
	}

}
