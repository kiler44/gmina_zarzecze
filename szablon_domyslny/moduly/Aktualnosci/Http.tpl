
{{BEGIN listaAktualnosci}}
<div class="listaAktualnosci listaOgloszen">
{{$pager}}
<table border="0" width="100%">
{{ BEGIN lista }}
<tr class="{{ if($priorytetowa, 'important') }}">
	<td class="zdjecie">
	{{BEGIN zdjecie_glowne}}
		<a href="{{ $link }}" class="thumb"><img src="{{ $zdjecie }}" alt="{{escape($tytul)}}"/></a>
	{{END}}
	{{BEGIN brak_zdjecia}}
		<div class="brak_zdjecia">{{$etykieta_brak_zdjecia}}</div>
	{{END}}
	</td>
	<td class="tresc">
		<table cellpadding="0" cellspacing="0" border="0" width="100%" height="100%">
			<tr>
				<th class="tytul"><a href="{{ $link }}">{{ $tytul }}</a><span>{{ $autor }}@{{ $data }}</span></th>
			</tr>
			<tr class="wiersz_opis">
				<td>{{ $zajawka }}</td>
			</tr>
			<tr>
				<td class="wiecej"><a href="{{ $link }}" class="wiecej">{{ $etykieta_wiecej }}</a></td>
			</tr>
		</table>
	</td>
</tr>
{{ END }}
</table>
{{$pager}}
</div>
{{END}}



{{ BEGIN aktualnosc }}
<div class="aktualnosc">
	<h1><span class="tytul">{{ $tytul }}</span><span class="podpis">{{ $autor }}@{{ $data }}</span></h1>
	<div class="opis">
		<p><strong>{{ $tresc_krotka }}</strong></p>
		<div class="r_clear"></div>
		{{BEGIN zdjecie_glowne}}
		<div class="opis_zdjecie">
			<a href="{{$link}}" class="block" title="{{escape($tytul)}}" rel="{{if($uzyj_lightbox, 'lightbox')}}"><img src="{{$zdjecie}}" alt="{{escape($tytul)}}"/></a>
		</div>
		{{END}}
		{{$tresc_pelna}}
		<div class="opcje">
			<a href="{{ $link_wstecz }}" class="wstecz">{{ $etykieta_wstecz }}</a>
		</div>
		<div class="r_clear"></div>
	</div>
	{{$galeria}}
</div>
{{ END }}



{{BEGIN galeria}}
<div class="lista_miniaturek">
	{{ BEGIN miniaturka }}
	<div class="miniaturka">
		<div class="image">
			<a title="{{ $tytul }}" href="{{ $zdjecie_link }}" {{ if($lightbox, 'rel="lightbox"') }}><img alt="{{escape($tytul)}}" src="{{ $miniaturka }}"/></a>
		</div>
		<div class="caption">{{ $opis }}</div>
	</div>
	{{END}}
	<div class="r_clear"></div>
</div>
{{END}}