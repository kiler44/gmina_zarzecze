<table border="0" class="input_cron">
	<tr>
	{{BEGIN lista}}
		<td><label for="{{$nazwa}}_{{$pole}}">{{$etykieta}}<br/><select name="{{$nazwa}}_{{$pole}}" id="{{$nazwa}}_{{$pole}}" {{$atrybuty}}>
		{{IF $wybierz}}<option value="">{{$wybierz}}</option>{{END}}
		<option value="*" {{IF $wybrane_pole}}selected="selected"{{END}}>*</option>
		{{BEGIN wiersze}}
			<option value="{{$wartosc}}" {{IF $selected}}selected="selected"{{END}}>{{$wartosc}}</option>
		{{END}}
		</select></td>
	{{END}}
	</tr>
</table>