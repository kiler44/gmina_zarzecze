<table border="0" {{$atrybuty}} ><tr><td style="width: 400px;">
	{{BEGIN dodawanie_wierszy}}
	<div class="input-append">
		<input type="text" id="{{$nazwa}}_dodaj_inne" name="{{$nazwa}}_dodaj_inne"/>
		<input class="btn" type="button" id="{{$nazwa}}_dodaj_inne_potwierdz" name="{{$nazwa}}_dodaj_inne_potwierdz" value="{{$etykieta_inne_potwierdz}}"/>
	</div>
	{{END}}
	&nbsp;</td><td>&nbsp;</td><td style="vertical-align: middle;">
			<div class="input-prepend"><span class="add-on">{{$etykieta_wyszukaj}}</span><input type="text" id="{{$nazwa}}_podpowiedz" name="{{$nazwa}}_podpowiedz"/></div>
	</td></tr><tr><td style="width: 400px;">

	{{$etykieta_wybrane}}<br/>
	<select size="10" multiple="multiple" style="width: 100%;" name="{{$nazwa}}_wybrane[]" id="{{$nazwa}}_wybrane" {{$atrybuty}}>
		{{BEGIN opcje_wybrane}}<option value="{{$wartosc}}" title="{{$title}}" >{{$etykieta}}</option>{{END}}
	</select>
	</td><td style="vertical-align: middle;">
	<input id="{{$nazwa}}_dodaj" value="{{$etykieta_dodaj}}" type="button" class="btn"/><br/><br/>
	<input id="{{$nazwa}}_usun" value="{{$etykieta_usun}}" type="button" class="btn"/>
	</td><td style="width: 400px;">
	{{$etykieta_dostepne}}<br/>
	<select size="10" multiple="multiple" style="width: 100%;" name="{{$nazwa}}_lista[]" id="{{$nazwa}}_lista" {{$strybuty}}>
		{{BEGIN opcje_dostepne}}<option value="{{$klucz}}" title="{{$title}}">{{$etykieta}}</option>{{END}}
	</select>
	</td></tr></table><div id="{{$nazwa}}_wartosc"></div>

<script type="text/javascript">
<!--

function {{$nazwa}}_odswierz()
{
	$('#{{$nazwa}}_lista option').live('dblclick', function() {
		$(this).appendTo('#{{$nazwa}}_wybrane');
	});

	$('#{{$nazwa}}_wybrane option').live('dblclick', function() {
		$(this).appendTo('#{{$nazwa}}_lista');
	});
}

function {{$nazwa}}_wartosci()
{
	$('#{{$nazwa}}_wartosc input').remove();
	$('#{{$nazwa}}_wybrane option').each(function() {
		$('#{{$nazwa}}_wartosc').append('<input type="hidden" name="{{$nazwa}}[]" value="' + $(this).val() + '"/>');
	});
	if ($('#{{$nazwa}}_wartosc input').size() < 1) {
		$('#{{$nazwa}}_wartosc').append('<input type="hidden" name="{{$nazwa}}[]" value=""/>');
	}
}

$(document).ready(function(){

	$('#{{$nazwa}}_lista option').live('dblclick', function() {
		$(this).appendTo('#{{$nazwa}}_wybrane');
		{{$nazwa}}_wartosci();
		{{$nazwa}}_odswierz();
	});

	$('#{{$nazwa}}_wybrane option').live('dblclick', function() {
		$(this).appendTo('#{{$nazwa}}_lista');
		{{$nazwa}}_wartosci();
		{{$nazwa}}_odswierz();
	});

	$("#{{$nazwa}}_dodaj").click(function () {
		$("#{{$nazwa}}_lista option:selected").each(function () {
			$(this).appendTo('#{{$nazwa}}_wybrane');
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
			$(this).appendTo('#{{$nazwa}}_lista');
		});
		{{$nazwa}}_odswierz();
		{{$nazwa}}_wartosci();
	});

	var opcje = $("#{{$nazwa}}_lista").html();
	$('#{{$nazwa}}_podpowiedz').bind('keyup', function() {
		var fraza = jQuery.trim($(this).val());

		if (fraza != '') {
			$("#{{$nazwa}}_lista").html(opcje);
			$("#{{$nazwa}}_lista option").each(function (i) {
				if (! (eval("/" + fraza + "/i").test(this.text) > 0))
				{	
					$(this).remove();
				}
			});
		} else {
			$("#{{$nazwa}}_lista").html(opcje);
		}
		{{$nazwa}}_odswierz();
	});

	{{$nazwa}}_wartosci();
});
-->
</script>