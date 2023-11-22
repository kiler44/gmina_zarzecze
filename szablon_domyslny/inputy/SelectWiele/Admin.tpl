<span id="{{$nazwa}}" class="controls select2">
{{BEGIN select}}
	<select multiple name="{{$nazwa}}[{{$numer}}]" {{$atrybuty}}>
	{{BEGIN wybierz}}
		<option value="">{{$etykieta_wybierz}}</option>
	{{END}}
	{{BEGIN optgroup}}
		<optgroup label="{{$klucz}}">
			{{BEGIN option}}
				<option value="{{$element}}" {{ if($selected,'selected="selected"') }}>{{$etykieta}}</option>
			{{END}}
		</optgroup>
	{{END}}
	{{BEGIN option}}
		<option value="{{$klucz}}" {{ if($selected,'selected="selected"') }}>{{$wartosc}}</option>
	{{END}}
	</select>
{{END}}
</span>