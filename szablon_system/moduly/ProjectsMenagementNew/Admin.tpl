{{BEGIN index}}
<div class="tresc widget-box">
<div class="przyciskiFunkcyjne">
	<a href="{{$link_dodaj}}" class="btn" title="{{$etykieta_dodaj}}"><i class="icon-plus-sign"></i> {{$etykieta_dodaj}}</a>
</div>
	{{$tabela_danych}}
</div>
{{END}}

{{BEGIN dodaj}}
<script type="text/javascript">
<!--
function zaznaczInputy(element, zapytanie)
{
	if ($(element).attr("checked"))
	{
		$(zapytanie).attr("checked", true);
	}
}
-->
</script>
{{$form}}
{{END}}

{{BEGIN edytuj}}
<script type="text/javascript">
<!--
function zaznaczInputy(element, zapytanie)
{
	if ($(element).attr("checked"))
	{
		$(zapytanie).attr("checked", true);
	}
}
-->
</script>
{{$skrypt}}

{{$form}}

{{END}}

{{BEGIN zaznacz_wiele_link}}
<!--<div class="toggle_checkboxes btn-group">
		<a class="btn btn-success btn-mini zaznacz" rel="{{$rel}}"><i class="icon-check"></i> {{$etykieta_zaznacz_wiele}}</a>
		<a class="btn btn-warning btn-mini odznacz" rel="{{$rel}}"><i class="icon-check-empty"></i> {{$etykieta_odznacz_wiele}}</a>
		<a class="btn btn-danger btn-mini odwroc" rel="{{$rel}}"><i class="icon-retweet"></i> {{$etykieta_odwroc_zaznaczenie}}</a>
</div>-->
{{END}}

{{BEGIN zaznacz_skrypt}}
<script type="text/javascript">
function zaznaczWszystkie(region){$("#"+region+" :checkbox:not(:checked)").attr("checked", "checked")}
function odznaczWszystkie(region){$("#"+region+" :checkbox:checked").attr("checked", "")}
function odwrocZaznaczenie(region){$("#"+region+" :checkbox").click()}

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

{{BEGIN vhost}}
<pre class="kodPodglad">
{{$tresc}}
</pre>
{{END}}
