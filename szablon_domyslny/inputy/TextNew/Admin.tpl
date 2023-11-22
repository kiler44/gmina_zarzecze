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

{{BEGIN spinner}}
<span class="qty">
	<input type="text" name="{{$nazwa}}" id="{{$nazwa}}" value="{{$wartosc}}" {{$atrybuty}} />
</span>
	<script>
		$(document).ready(function(){
			$('#{{$nazwa}}').spinner({min: {{$spinner_min}},  step: {{$spinner_skok}}, max: {{$spinner_max}}});
		});
	</script>
{{END}}