{{BEGIN index}}
<div class="widget-box">
<div class="przyciskiFunkcyjne">
	<a href="{{$link_dodaj}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_doadaj}}"><i class="icon-plus" ></i> {{$etykieta_link_doadaj}}</a>
	<a href="{{$link_raport}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_raport}}"><i class="icon-download-alt"></i> {{$etykieta_link_raport}}</a>
	<a href="{{$link_sprawdz}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_sprawdz}}"><i class="icon-time"></i> {{$etykieta_link_sprawdz}}</a>
</div>
{{$tabela_danych}}
</div>
{{END}}

{{BEGIN dodaj}}
	{{$formularz}}
{{END}}


{{BEGIN edytuj}}
	{{$formularz}}
{{END}}

{{BEGIN sprawdz}}
<div class="widget-box">
	{{$tabela_danych}}
</div>
{{END}}