{{BEGIN index}}
<div class="widget-box">
	<div class="przyciskiFunkcyjne">
		<a href="{{$link_dodaj}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_dodaj}}"><i class="icon-plus-sign"></i> {{$etykieta_link_dodaj}}</a>
	</div>
	{{$tabela_danych}}
</div>
{{END}}

{{BEGIN dodaj}}
	{{$form}}
{{END}}

{{BEGIN edytuj}}
	{{$form}}
	<script>
		function pokazUkryjPolaKontekstu()
		{
			if ($('#kontekstowa').val() == 2)
			{
				$('#kontekstObiekt').parent().parent().parent().show();
				$('#kontekstPole').parent().parent().parent().show();
				$('#kontekstPowiazanie').parent().parent().parent().show();
				$('#kontekstPowiazanieKtoreId').parent().parent().parent().show();
			}
			else
			{
				$('#kontekstObiekt').parent().parent().parent().hide();
				$('#kontekstPole').parent().parent().parent().hide();
				$('#kontekstPowiazanie').parent().parent().parent().hide();
				$('#kontekstPowiazanieKtoreId').parent().parent().parent().hide();
			}
		}

		$(document).ready(function () {
			pokazUkryjPolaKontekstu();

			$('#kontekstowa').change(function () {
				pokazUkryjPolaKontekstu();
			});

			$('#kontekstObiekt').change(function () {
				$('#czyZapisac').val(0);
				$('form#edytuj').submit();
			});

			$('#zapisz').click(function () {
				$('#czyZapisac').val(1);
			});
		});
	</script>
{{END}}


{{BEGIN zaznacz_wiele_link}}
<div class="toggle_checkboxes btn-group zaznaczWieleUprawnienia">
	<a class="btn btn-success btn-mini zaznacz" rel="{{$rel}}"><i class="icon-check"></i> {{$etykieta_zaznacz_wiele}}</a>
	<a class="btn btn-warning btn-mini odznacz" rel="{{$rel}}"><i class="icon-check-empty"></i> {{$etykieta_odznacz_wiele}}</a>
	<a class="btn btn-danger btn-mini odwroc" rel="{{$rel}}"><i class="icon-retweet"></i> {{$etykieta_odwroc_zaznaczenie}}</a>
</div>
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
<table border="0" cellspacing="0" class="input table table-bordered table-striped">
<tr><td>{{$etykieta_kod}}</td><td>{{$kod}}</td><tr>
<tr><td>{{$etykieta_nazwa}}</td><td>{{$nazwa}}</td><tr>
<tr><td>{{$etykieta_opis}}</td><td>{{$opis}}</td><tr>
</table>
<h4>{{$etykieta_edytuj}}</h4>
<div class="a_clear">
	<a href="{{$link_edytuj}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_edytuj}}"><i class="icon-pencil"></i> {{$etykieta_link_edytuj}}</a>
</div>
<br />
<br />
<h4>{{$etykieta_uprawnienia_tresci}}</h4>
<div class="a_clear">
	<a href="{{$link_uprawnienia_tresci}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_uprawnienia_tresci}}"><i class="icon-pencil"></i> {{$etykieta_link_uprawnienia_tresci}}</a>
</div>
<br />
<br />
<h4>{{$etykieta_uprawnienia_administracyjne}}</h4>
<div class="a_clear">
	<a href="{{$link_uprawnienia_administracyjne}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_uprawnienia_administracyjne}}"><i class="icon-pencil"></i> {{$etykieta_link_uprawnienia_administracyjne}}</a>
</div>
<br />
<br />
<h4>{{$etykieta_uprawnienia_do_eventow}}</h4>
<div class="a_clear">
	<a href="{{$link_uprawnienia_do_eventow}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_uprawnienia_do_eventow}}"><i class="icon-pencil"></i> {{$etykieta_link_uprawnienia_do_eventow}}</a>
</div>
<br />
<br />
<h4>{{$etykieta_uprawnienia_obiektow}}</h4>
<div class="a_clear">
	<a href="{{$link_uprawnienia_obiektow}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_uprawnienia_obiektow}}"><i class="icon-pencil"></i> {{$etykieta_link_uprawnienia_obiektow}}</a>
</div>
{{END}}


{{BEGIN kategoria}}
<span class="treeLvl{{$poziom}}"><strong><em>{{$nazwa}}</em></strong></span>
	{{BEGIN zaznacz_wiele_link}}
	<div class="toggle_checkboxes  btn-group">
		<a class="btn btn-success btn-mini zaznacz" rel="{{$rel}}"><i class="icon-check"></i> {{$etykieta_zaznacz_wiele}}</a>
		<a class="btn btn-warning btn-mini odznacz" rel="{{$rel}}"><i class="icon-check-empty"></i> {{$etykieta_odznacz_wiele}}</a>
		<a class="btn btn-danger btn-mini odwroc" rel="{{$rel}}"><i class="icon-retweet"></i> {{$etykieta_odwroc_zaznaczenie}}</a>
	</div>
	{{END}}
{{END}}


{{BEGIN uprawnieniaTresci}}
	{{$form}}
{{END}}


{{BEGIN uprawnieniaAdministracyjne}}
	{{$form}}
	{{$skrypt}}
{{END}}
