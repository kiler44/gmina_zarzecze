{{BEGIN index}}
<div class="collapse navbar-collapse" id="gz-Nav-Dropdown">
	{{$drzewo}}
</div>
{{END}}

{{BEGIN drzewo}}

{{BEGIN listaStart}}<ul class="{{IF $poziom == '1'}} navbar-nav gz-ul-navbar {{ELSE}} dropdown-menu {{END}}">{{END listaStart}}
{{BEGIN elementStart}}<li class="{{IF $poziom == '1'}} nav-item dropdown {{ELSE}}dropdown-item{{END}}">{{END elementStart}}
{{BEGIN elementTrescLink}} <a class="nav-link dropdown-toggle" href="{{$url}}">{{$nazwa}}</a>{{END}}
{{BEGIN elementTrescLinkSeo}}<var><br/></var><span id="hsl{{$url}}" class="hsl poziom{{$poziom}} {{$klasa}}" title="{{escape($nazwa)}}"><span>{{$nazwa}}</span></span>{{END}}
{{BEGIN elementTresc}}<a class="nav-link dropdown-toggle">{{$nazwa}}</a>{{END}}
{{BEGIN elementStop}}</li>{{END}}
{{BEGIN listaStop}}</ul>{{END}}

{{END}}