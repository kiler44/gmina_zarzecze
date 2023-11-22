{{BEGIN index}}
<div class="widget-box">
<div class="przyciskiFunkcyjne">
	<a href="{{$link_dodaj}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_dodaj}}"><i class="icon-plus-sign"></i> {{$etykieta_link_dodaj}}</a>
	<a href="{{$link_raport}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_raport}}"><i class="icon-file"></i> {{$etykieta_link_raport}}</a>
</div>
{{$tabela_danych}}
</div>
{{END}}

{{BEGIN raport}}
<div class="widget-box">
<div class="przyciskiFunkcyjne">
	<a href="{{$link_pobierz_raport}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_pobierz_raport}}"><i class="icon-download-alt"></i> {{$etykieta_link_pobierz_raport}}</a>
</div>
{{$tabela_danych}}
</div>
{{END}}


{{BEGIN kategoria}}
<span class="treeLvl{{$poziom}}"><strong><em>{{$nazwa}}</em></strong></span>
	{{BEGIN zaznacz_wiele_link}}
	<div class="toggle_checkboxes btn-group">
		<a class="btn btn-success btn-mini zaznacz" rel="{{$rel}}"><i class="icon-check"></i> {{$etykieta_zaznacz_wiele}}</a>
		<a class="btn btn-warning btn-mini odznacz" rel="{{$rel}}"><i class="icon-check-empty"></i> {{$etykieta_odznacz_wiele}}</a>
		<a class="btn btn-danger btn-mini odwroc" rel="{{$rel}}"><i class="icon-retweet"></i> {{$etykieta_odwroc_zaznaczenie}}</a>
	</div>
	{{END}}
{{END}}

{{BEGIN zaznacz_skrypt}}
<script type="text/javascript">
function zaznaczWszystkie(region){$("."+region+":checkbox:not(:checked)").attr("checked", "checked"); $.uniform.update();}
function odznaczWszystkie(region){$("."+region+":checkbox:checked").click(); $.uniform.update();}
function odwrocZaznaczenie(region){$("."+region+":checkbox").click(); $.uniform.update();}

$(document).ready(function(){
	$(".toggle_checkboxes a").click(function(){
		if($(this).hasClass("zaznacz")){zaznaczWszystkie($(this).attr("rel"))}
		if($(this).hasClass("odznacz")){odznaczWszystkie($(this).attr("rel"))}
		if($(this).hasClass("odwroc")){odwrocZaznaczenie($(this).attr("rel"))}
		return false;
	});
});
</script>
{{END}}

{{BEGIN podglad}}
<br />
<table border="0" cellspacing="0" class="input" width="100%">
<tr><td>{{$etykieta_czas}}</td><td>{{$czas}}</td><tr>
<tr><td>{{$etykieta_zadanie_http}}</td><td>{{$zadanie_http}}</td><tr>
<tr><td>{{$etykieta_adres_ip}}</td><td>{{$adres_ip}}</td><tr>
<tr><td>{{$etykieta_przegladarka}}</td><td>{{$przegladarka}}</td><tr>
<tr><td>{{$etykieta_id_uzytkownika}}</td><td>{{$id_uzytkownika}}</td><tr>
<tr><td>{{$etykieta_kod_jezyka}}</td><td>{{$kod_jezyka}}</td><tr>
<tr><td>{{$etykieta_id_kategorii}}</td><td>{{$id_kategorii}}</td><tr>
<tr><td>{{$etykieta_usluga}}</td><td>{{$usluga}}</td><tr>
<tr><td>{{$etykieta_kod_modulu}}</td><td>{{$kod_modulu}}</td><tr>
<tr><td>{{$etykieta_akcja}}</td><td>{{$akcja}}</td><tr>
<tr><td>{{$etykieta_dane_dodatkowe}}</td><td>{{$dane_dodatkowe}}</td><tr>
</table>
{{END}}

{{BEGIN ustawienia}}
{{$formularz}}
{{END}}