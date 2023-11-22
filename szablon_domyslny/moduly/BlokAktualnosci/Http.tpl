{{BEGIN komunikat}}
	<div class="komunikatBlok {{$klasa}} ">
		<div class="box {{$typ}}">
			<span class="komunikat_tresc">{{$tresc}}</span>
		</div>
	</div>
{{END}}


{{BEGIN index}}
<table class="blokOgloszen {{$klasa}}" width="100%">
{{BEGIN wiersz}}<tr class="{{$klasa}}"><td><a href="{{$url}}" title="{{escape($tytul_alt)}}" >{{$tytul}}</a>
{{BEGIN zdjecie_glowne}}<a href="{{$url}}" title="{{escape($tytul_alt)}}" class="zdjecie"><img src="{{$zdjecie}}" alt="{{escape($tytul_alt)}}" /></a>{{END}}
{{BEGIN zajawka}}<p class="splash">{{$zajawka_tresc}}</p>{{BEGIN link_wiecej}}<a href="{{$url}}" title="{{escape($tytul_alt)}}" class="more"><span>{{$etykieta_link_wiecej}}</span></a>{{END}}{{END}}
{{BEGIN autor}}<span class="autor">{{$autor}}</span>{{END}}</td><td class="right">{{$data_dodania}}</td></tr>{{END}}
</table>
{{BEGIN link_wiecej}}<a class="rButton" title="{{escape($etykieta_link_wiecej_aktualnosci)}}" href="{{$url_wiecej}}"><span>{{$etykieta_link_wiecej_aktualnosci}}</span></a><div class="clear"></div>{{END}}
{{END}}

