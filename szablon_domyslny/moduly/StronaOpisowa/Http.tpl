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
</div>
{{END}}

{{BEGIN galeria}}
<div class="row gz-gallery-section">
	{{ BEGIN miniaturka }}
	<div class="col-lg-4 col-6 gallery-item">
		<a class="not-text-link" title="{{ $tytul }}" href="{{ $zdjecie_link }}" {{ if($lightbox, 'data-toggle="lightbox"') }}><img alt="{{escape($tytul)}}" src="{{ $miniaturka }}"/></a>
		<div class="caption">{{ $opis }}</div>
	</div>
	{{END}}
</div>
{{END}}