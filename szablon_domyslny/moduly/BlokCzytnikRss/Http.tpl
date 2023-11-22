{{BEGIN komunikat}}
	<div class="komunikatBlok {{$klasa}} ">
		<div class="box {{$typ}}">
			<span class="komunikat_tresc">{{$tresc}}</span>
		</div>
	</div>
{{END}}


{{BEGIN index}}
<table class="blokOgloszen" width="100%">
{{BEGIN wiersz}}<tr class="{{if($_odd,'parzysty','nieparzysty')}}"><td>
<a href="{{$url}}" title="{{escape($tytul)}}" >{{$tytul}}</a>
{{BEGIN opis}}<p class="splash">{{$opis_tresc}}</p>
	{{BEGIN link_wiecej}}<a href="{{$url}}" title="{{escape($tytul)}}" class="more"><span>{{$etykieta_link_wiecej}}</span></a>{{END}}
{{END}}
</td><td class="right">{{$data_dodania}}</td></tr>
{{END}}
</table>
{{END}}

