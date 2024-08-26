{{BEGIN komunikat}}
<div class="alert alert-warning {{$klasa}} {{$typ}}" role="alert">
	{{$tresc}}
</div>
{{END}}

{{BEGIN index}}
<h1>{{$tytul_modulu}}</h1>
<div class="gz-content">
	{{$tresc}}
	{{$galeria}}
	{{$zalaczniki}}
</div>
{{END}}

{{BEGIN galeria}}
<div class="row gz-gallery-section">
	{{ BEGIN miniaturka }}
	<div class="col-lg-4 col-6 gallery-item">
		<a class="not-text-link" title="{{ $tytul }}" href="{{ $zdjecie_link }}" {{IF $lightbox}} data-toggle="lightbox" data-gallery="galeria-{{$id}}"{{END IF}}><img alt="{{escape($tytul)}}" src="{{ $miniaturka }}"/></a>
		<div class="caption">{{ $opis }}</div>
	</div>
	{{END}}
</div>
{{END}}

{{BEGIN zalaczniki}}
<ul class="gz-download list-unstyled">
	{{ BEGIN element }}
	<li><a href="{{$link}}" class="gz-{{$rozszerzenie}} not-text-link">{{IF $opis !=''}}{{$opis}}{{ELSE}}{{$nazwa}}{{END IF}}</a><span>{{$rozmiar}}</span><!--<p> TODO: tutaj miejsce na dodatkowy opis z bazy</p>--></li>
	{{END}}
</ul>
{{END}}