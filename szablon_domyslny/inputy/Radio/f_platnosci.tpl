<div id="{{$nazwa}}">
{{BEGIN inline}}
	{{BEGIN radio}}
	<div class="boxWyborPlatnosci">
		<input type="radio" name="{{$nazwa}}" value="{{$klucz}}" id="{{$nazwa}}_{{$klucz}}" class="noinput" {{ if($selected,'checked="checked"') }} {{$atrybuty}} /><label for="{{$nazwa}}_{{$klucz}}">{{$wartosc}}</label><br />
	</div>
	{{END}}
{{END}}

{{BEGIN block}}
	{{BEGIN radio}}
		<span><input type="radio" name="{{$nazwa}}" value="{{$klucz}}" id="{{$nazwa}}_{{$klucz}}" class="noinput" {{ if($selected,'checked="checked"') }} {{$atrybuty}} /><label for="{{$nazwa}}_{{$klucz}}">{{$wartosc}}</label></span>
	{{END}}
{{END}}
<div class="clearfix"></div>
</div>