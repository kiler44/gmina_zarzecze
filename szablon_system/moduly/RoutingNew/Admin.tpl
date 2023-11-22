{{BEGIN index}}
<div class="widget-box">
<div class="przyciskiFunkcyjne">
	<a href="{{$link_dodaj}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_dodaj}}"><i class="icon-plus-sign"></i> {{$etykieta_link_dodaj}}</a>
	<a href="{{$link_sortuj}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_sortuj}}"><i class="icon-random"></i> {{$etykieta_link_sortuj}}</a>
	<a href="{{$link_przekierowania}}" class="btn" title="{{$etykieta_link_przekierowania}}"><i class="icon-retweet"></i> {{$etykieta_link_przekierowania}}</a>
	<a href="{{$link_blokady}}" class="btn" title="{{$etykieta_link_blokady}}"><i class="icon-minus-sign"></i> {{$etykieta_link_blokady}}</a>
</div>
{{$tabela_danych}}
</div>
{{END}}

{{BEGIN skryptyJs}}
<script>

function zaladujAkcje()
{
	if ($('#routing_kategoria option:selected').val() != '')
	{
		$.ajax({
		  url: "{{$urlAjax}}" + $('#routing_kategoria option:selected').val(),
		  context: document.body,
		  success: function(dane){
			$('#routing_nazwaAkcji').html(dane);
		  }
		});
	}
}

</script>
{{END}}

{{BEGIN dodaj}}
	{{$formularz}}
{{END}}


{{BEGIN edytuj}}
	{{$formularz}}
{{END}}

{{BEGIN sortuj}}
<div class="widget-box">
	<div class="przyciskiFunkcyjne">
		<a href="{{$link_dodaj}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_dodaj}}"><i class="icon-plus-sign"></i> {{$etykieta_link_dodaj}}</a>
		<a href="{{$link_wstecz}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_wstecz}}"><i class="icon-circle-arrow-left"></i> {{$etykieta_link_wstecz}}</a>
	</div>
	<br />
	{{$tabela_danych}}
</div>
{{END}}