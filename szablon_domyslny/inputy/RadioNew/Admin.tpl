<div id="{{$nazwa}}" {{$atrybuty}}>
{{BEGIN inline}}
	{{BEGIN radio}}
	<label for="{{$nazwa}}_{{$klucz}}" class="{{$label_class}}" style="display: inline; margin-right: 30px"><input type="radio" name="{{$nazwa}}" value="{{$klucz}}" id="{{$nazwa}}_{{$klucz}}" class="noinput" {{ if($selected,'checked="checked"') }} {{$atrybuty}} /> {{$wartosc}}</label>
	{{END}}
{{END}}

{{BEGIN block}}
	{{BEGIN radio}}
		<label for="{{$nazwa}}_{{$klucz}}" class="{{$label_class}}"><input type="radio" name="{{$nazwa}}" value="{{$klucz}}" id="{{$nazwa}}_{{$klucz}}" class="noinput" {{ if($selected,'checked="checked"') }} {{$atrybuty}} /> {{$wartosc}}</label>
	{{END}}
{{END}}
</div>