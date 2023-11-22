{{BEGIN index}}
<div class="widget-box">
<div class="przyciskiFunkcyjne">
	<a href="{{$link_dodaj}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_dodaj}}"><i class="icon-plus-sign"></i> {{$etykieta_link_dodaj}}</a>
	<a href="{{$link_szablony}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_szablony}}"><i class="icon-file"></i> {{$etykieta_link_szablony}}</a>
	<a href="{{$link_kolejka}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_szablony}}"><i class="icon-list-alt"></i> {{$etykieta_link_kolejka}}</a>
</div>
{{$tabela_danych}}
</div>
{{END}}

{{BEGIN dodaj}}
	{{$form}}
{{END}}

{{BEGIN edytuj}}
	{{$form}}
{{END}}

{{BEGIN szablony}}
<div class="widget-box">
<div class="przyciskiFunkcyjne">
	<a href="{{$link_dodaj}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_dodaj}}"><i class="icon-plus-sign"></i> {{$etykieta_link_dodaj}}</a>
</div>
{{$tabela_danych}}
</div>
{{END}}

{{BEGIN dodaj_szablon}}
	{{$form}}
{{END}}

{{BEGIN edytuj_szablon}}
	{{$form}}
{{END}}

{{BEGIN kolejka}}
<div class="widget-box">
{{$tabela_danych}}
</div>
{{END}}

{{BEGIN podglad}}
	{{$form}}
	{{BEGIN formatka}}
		<strong>{{$tytul}}</strong></br>{{$opis}}
		<div class="a_clear">
			<a href="{{$link_formatka}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_formatka}}"><i class="icon-search"></i> {{$etykieta_link_formatka}}</a>
		</div>
	{{END}}
{{END}}


{{BEGIN podglad_tresci}}
<script type="text/javascript">
<!--
function podgladTresciHtml()
{
	var iWidth	= 640,	// 800 * 0.8,
		iHeight	= 420,	// 600 * 0.7,
		iLeft	= 80;	// (800 - 0.8 * 800) /2 = 800 * 0.1.
	try
	{
		var screen = window.screen;
		iWidth = Math.round( screen.width * 0.8 );
		iHeight = Math.round( screen.height * 0.7 );
		iLeft = Math.round( screen.width * 0.1 );
	}
	catch ( e ){}

	var input = $('textarea#emailTrescHtml');
	if (input.length < 1) input = $('textarea#cke_emailTrescHtml');

	if (input.length == 1) {
		var oWindow = window.open('', null, 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=' + iWidth + ',height=' + iHeight + ',left=' + iLeft );
		oWindow.document.write(input.val());
	}
}
-->
</script>
{{END}}


{{BEGIN podpowiedz}}
<script type="text/javascript">
$(document).ready(function() {
	var nyroModalContents = $('#podpowiedzTresc');

	nyroModalContents.dialog({
		autoOpen: false,
		modal: false,
		width: 380,
		position: 'left'
	});
});
</script>
<div id="podpowiedzTresc">
{{BEGIN obiekt}}
<p>
	<em> Obiekty: </em><strong>{{BEGIN etykiety}}{{UNLESS $_first}}, {{END}}{{$etykieta}}{{END}}</strong><em><br/> Propercje: </em>
<span>{{BEGIN propercje}}{{UNLESS $_first}}, {{END}}{{$propercja}}{{END}}</span>
</p>
{{END}}
</div>
{{END}}


{{BEGIN podglad_formatki}}
<script type="text/javascript">
<!--
function podgladTresciHtml(object)
{
	link = '{{$link_podglad}}';
	link = link.replace(/{TRESC}/, encodeURIComponent($('#{{$pole_tresc}}').val()));
	link = link.replace(/{SZABLON}/, encodeURIComponent($('#{{$pole_szablon}}').val()));

	oknoModalne (object, {
		url: link
	});

	/*$.nyroModalManual({
		//debug: true,
		type: 'iframe',
		url: link,
		minWidth: 1000,
		minHeight: 600
	});
	*/
}
-->
</script>
{{END}}