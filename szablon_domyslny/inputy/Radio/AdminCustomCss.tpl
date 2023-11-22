<div id="{{$nazwa}}" {{$atrybuty}}>
{{BEGIN inline}}
	{{BEGIN radio}}
	<label for="{{$nazwa}}_{{$klucz}}" class="{{$label_class}} labTxt" style="display: inline; margin-right: 30px"><input type="radio" name="{{$nazwa}}" value="{{$klucz}}" id="{{$nazwa}}_{{$klucz}}" class="noinput" {{ if($selected,'checked="checked"') }} {{$atrybuty}} /><label for="{{$nazwa}}_{{$klucz}}" class="btn"><i class="icon-circle"></i></label> {{$wartosc}}</label>
	{{END}}
{{END}}

{{BEGIN block}}
	{{BEGIN radio}}
	<label for="{{$nazwa}}_{{$klucz}}" class="{{$label_class}} labTxt"><input type="radio" name="{{$nazwa}}" value="{{$klucz}}" id="{{$nazwa}}_{{$klucz}}" class="noinput" {{ if($selected,'checked="checked"') }} {{$atrybuty}} /><label for="{{$nazwa}}_{{$klucz}}" class="btn"><i class="icon-circle"></i></label> {{$wartosc}}</label>
	{{END}}
{{END}}
</div>