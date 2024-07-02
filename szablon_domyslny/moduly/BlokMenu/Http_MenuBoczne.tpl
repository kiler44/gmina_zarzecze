{{BEGIN index}}
	{{$drzewo}}
{{END}}

{{BEGIN drzewo}}
{{BEGIN listaStart}}<ul>{{END}}
{{BEGIN elementStart}}<li class="poziom{{$poziom}} {{$klasa}}">{{END}}
{{BEGIN elementTrescLink}}<a href="{{$url}}" class="poziom{{$poziom}} {{$klasa}}" title="{{escape($nazwa)}}"><span>{{$nazwa}}</span></a>{{END}}
{{BEGIN elementTrescLinkSeo}}<span id="hsl{{$url}}" class="hsl poziom{{$poziom}} {{$klasa}}" title="{{escape($nazwa)}}"><span>{{$nazwa}}</span></span>{{END}}
{{BEGIN elementTresc}}<span class="poziom{{$poziom}} {{$klasa}}">{{$nazwa}}</span>{{END}}
{{BEGIN elementStop}}</li>{{END}}
{{BEGIN listaStop}}</ul>{{END}}
{{END}}