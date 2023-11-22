{{BEGIN index}}
	<h2 class="fontReplace">{{$tytul_modulu}}</h2>
	{{$drzewo}}
{{END}}

{{BEGIN drzewo}}
{{BEGIN listaStart}}<ul>{{END}}
{{BEGIN elementStart}}<li class="poziom{{$poziom}} {{$klasa}}">{{END}}
{{BEGIN elementTrescLink}}<var><br/></var><a href="{{$url}}" class="poziom{{$poziom}} {{$klasa}}" title="{{escape($nazwa)}}">{{$nazwa}}</a>{{END}}
{{BEGIN elementTrescLinkSeo}}<var><br/></var><span id="hsl{{$url}}" class="hsl poziom{{$poziom}} {{$klasa}}" title="{{escape($nazwa)}}">{{$nazwa}}</span>{{END}}
{{BEGIN elementTresc}}<var><br/></var><span class="poziom{{$poziom}} {{$klasa}}">{{$nazwa}}</span>{{END}}
{{BEGIN elementStop}}</li>{{END}}
{{BEGIN listaStop}}</ul>{{END}}
{{END}}