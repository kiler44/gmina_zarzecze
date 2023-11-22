{{BEGIN sciana}}
<div class="eg_sciana">
	<script type="text/javascript">
		var openedWindow = null;
	</script>
	<div class="widget-box menedzer_plikow">
	<div class="widget-content nopadding">
		{{BEGIN listaFiltrow}}
		<div class="listaFiltrow menu">
			<div class="header"><h5>{{$etykieta_naglowek_filtry}}</h5></div>
			<h6 class="listaFiltrow"><a href="{{$link}}" class="{{$wybrany}}"><i class="icon-folder-open"></i> {{$etykieta_link_korzen}}</a></h6>
			{{$filtry}}
		</div>
		{{END}}

		<div class="listaMiniatur">
			{{BEGIN wznow}}
				<div class="header"><h5 title="{{$wyjasnienie_wznow}}">{{$etykieta_naglowek_wznow_sesje}}</h5></div>
				<div class="edycjaWznow">
					<a href="javascript:void(0);" onclick="openedWindow = window.open('{{$link}}','','scrollbars,resizable,height='+screen.availHeight+',width='+screen.availWidth);"><img src="{{$obraz}}" class="min" alt="{{$plik}}" /></a>
					<a title="{{$etykieta_link_wznow_sesje}}" class="btn" href="javascript:void(0);" onclick="openedWindow = window.open('{{$link}}','','scrollbars,resizable,height='+screen.availHeight+',width='+screen.availWidth);"><i class="icon-pencil"></i> {{$etykieta_link_wznow_sesje}}</a><br /><strong>{{$plik}}</strong>
				</div>
			{{END}}
			{{BEGIN miniatury}}
				<div class="header"><h5 title="{{$wyjasnienie_miniatury}}">{{$etykieta_naglowek_rozpocznij_sesje}}</h5></div>

				<ul class="thumbnails">
				{{BEGIN miniatura}}
				<li class="span2">
					<a class="thumbnail {{$wybrany}}" title="{{$nazwa}}">
						<img src="{{$link}}" alt="{{$nazwa}}" title="{{$wyjasnienie_miniatury}}">
						<span class="thumbnailTytul" title="{{$obraz}}">{{$nazwa}}</span>
					</a>
					<div class="actions">
						<a onclick="{{BEGIN warning}} if(confirm('{{$pytanie}}')) {{END}} { if(openedWindow != null) { openedWindow.close(); } openedWindow = window.open('{{$url}}','','scrollbars,resizable,height='+screen.availHeight+',width='+screen.availWidth); }" href="javascript:void(0);" title="{{$nazwa}}"><i class="icon-pencil icon-white"></i></a>
					</div>
				</li>
				{{END}}
				</ul>
				{{BEGIN brak}}
					<h5>{{$komunikat_brak_miniatur}}</h5>
				{{END}}
				<div style="clear: both;"></div>
			{{END}}
		</div>
	</div>
	</div>
</div>
{{END}}

{{BEGIN drzewo}}
	{{BEGIN lista}}<ul class="eg_drzewo">{{$lista}}</ul>{{END}}

	{{BEGIN menu}}
		{{BEGIN katalog}}<li><a style="padding-left:{{$poziom}}0px;" href="{{$link}}" class="{{$wybrany}}"><i class="icon-folder-open"></i> {{$plik}}</a>{{$lista}}</li>{{END}}
	{{END}}
{{END}}