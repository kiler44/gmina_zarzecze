{{BEGIN index}}
<nav>
	{{$drzewo}}
</nav>
{{END}}

{{BEGIN drzewo}}
{{BEGIN listaStart}}<ul class="list-unstyled {{IF $poziom == '4'}} gz-nawigacja-boczna-submenu{{END iF}}">{{END}}
{{BEGIN elementStart}}<li class="{{IF $poziom == '3'}}gz-nawigacja-boczna{{END IF}} {{$klasa}}">{{END}}
{{BEGIN elementTrescLink}}<a href="{{$url}}" class="{{IF $poziom == '3'}}button{{ELSE}}{{END IF}} poziom{{$poziom}}" title="{{escape($nazwa)}}">{{$nazwa}}</a>{{END}}
{{BEGIN elementTrescLinkSeo}}<span id="hsl{{$url}}" class="hsl poziom{{$poziom}} {{$klasa}}" title="{{escape($nazwa)}}"><span>{{$nazwa}}</span></span>{{END}}
{{BEGIN elementTresc}}<span class="poziom{{$poziom}} {{$klasa}}">{{$nazwa}}</span>{{END}}
{{BEGIN elementStop}}</li>{{END}}
{{BEGIN listaStop}}</ul>{{END}}
{{END}}