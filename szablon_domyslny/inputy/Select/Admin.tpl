<span class="select_wrap select2"><select name="{{$nazwa}}" id="{{$nazwa}}" {{$atrybuty}}>
{{IF $wybierz}}<option value="">{{$wybierz}}</option>{{END}}
{{BEGIN wiele_poziomow}}
	<optgroup label="{{$etykieta_grupy}}">
	{{BEGIN wiersz}}
		<option value="{{$wartosc}}" {{IF $selected}}selected="selected"{{END}}>{{$etykieta}}</option>
	{{END}}
	</optgroup>
{{END}}

{{BEGIN wiersz}}
	<option value="{{$wartosc}}" {{IF $selected}}selected="selected"{{END}}>{{$etykieta}}</option>
{{END}}
</select></span>