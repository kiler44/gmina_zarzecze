{{BEGIN index}}
<div class="kategorie">
	{{$drzewo}}
</div>
{{END}}

{{BEGIN drzewo}}
{{BEGIN listaStart}}<ul>{{END}}
{{BEGIN elementStart}}<li class="poziom{{$poziom}} {{$klasa}}">{{END}}
{{BEGIN elementTrescLink}}<span class="poziom{{$poziom}} {{$klasa}} hsl" title="{{escape($nazwa)}}" id="hsl{{$rel}}"><span>{{$nazwa}}</span></span>{{END}}
{{BEGIN elementTresc}}<span class="poziom{{$poziom}} {{$klasa}}">{{$nazwa}}</span>{{END}}
{{BEGIN elementStop}}</li>{{END}}
{{BEGIN listaStop}}</ul>{{END}}
{{END}}