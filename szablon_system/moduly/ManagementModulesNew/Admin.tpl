{{BEGIN index}}
<div class="tresc widget-box">
	{{$grid}}
</div>
{{END}}

{{BEGIN podglad}}
<table border="0" cellspacing="0" class="table table-bordered table-striped table-condensed" width="100%">
<tr>
	<td class="etykieta"><span class="opis">{{$etykieta_kod}}</span></td>
	<td>{{$kod}}</td>
</tr>
<tr>
	<td class="etykieta"><span class="opis">{{$etykieta_nazwa}}</span></td>
	<td>{{$nazwa}}</td>
</tr>
<tr>
	<td class="etykieta"><span class="opis">{{$etykieta_typ}}</span></td>
	<td>{{$typ}}</td>
</tr>
<tr>
	<td class="etykieta"><span class="opis">{{$etykieta_opis}}</span></td>
	<td>{{$opis}}</td>
</tr>
<tr>
	<td class="etykieta"><span class="opis">{{$etykieta_uslugi}}</span></td>
	<td>{{$uslugi}}</td>
</tr>
<tr>
	<td class="etykieta"><span class="opis">{{$etykieta_wymagane}}</span></td>
	<td><ol>{{BEGIN wymagane}}<li>{{$nazwa}} ({{$kod}})</li>{{END}}</ol></td>
</tr>
<tr>
	<td class="etykieta"><span class="opis">{{$etykieta_dla_zalogowanych}}</span></td>
	<td>{{$dla_zalogowanych}}</td>
</tr>
<tr>
	<td class="etykieta"><span class="opis">{{$etykieta_cache}}</span></td>
	<td>{{$cache}}</td>
</tr>
<tr>
	<td class="etykieta"><span class="opis">{{$etykieta_projekty}}</span></td>
	<td><ol>{{BEGIN projekty}}<li>{{$nazwa}} ({{$domena}})</li>{{END}}</ol></td>
</tr>
</table>
{{END}}



{{BEGIN phpinfo}}
<div class="phpinfo">
<div class="grid_border">
	<div class="border_tl">
	<div class="border_tr">
	<div class="border_br">
	<div class="border_bl">
{{$grid}}
	</div>
	</div>
	</div>
	</div>
</div>
</div>
<script type="text/javascript">
<!--
$(document).ready(function(){
	//Podświetlanie wierszy po najechaniu kursorem
	$(".phpinfo tr").hover(
		function() {$(this).addClass("highlight");},
		function() {$(this).removeClass("highlight");}
	);
});
-->
</script>
{{END}}


{{BEGIN logi}}
{{$grid}}
{{BEGIN plik}}
<div class="grid_border">
	<div class="border_tl">
	<div class="border_tr">
	<div class="border_br">
	<div class="border_bl">
	<pre>{{$tresc}}</pre>
	</div>
	</div>
	</div>
	</div>
</div>
{{END}}
{{END}}