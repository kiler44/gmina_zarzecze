<table>
	<tr>
		<td>{{$etykieta_wyborZakresu}}</td>
		<td>
			<select name="{{$nazwa}}_pager_wyborZakresu" id="{{$nazwa}}_pager_wyborZakresu" class="input-medium">
				<option value="" {{IF $wyborZakresu == ''}}selected="selected"{{END}}>{{$wybor_brak}}</option>
				<option value="linki" {{IF $wyborZakresu == 'linki'}}selected="selected"{{END}}>{{$wybor_linki}}</option>
				<option value="select" {{IF $wyborZakresu == 'select'}}selected="selected"{{END}}>{{$wybor_select}}</option>
			</select>
		</td>
	</tr>
	<tr id="{{$nazwa}}_pr1">
		<td>{{$etykieta_dostepneZakresy}}</td>
		<td><input type="text" name="{{$nazwa}}_pager_dostepneZakresy" class="input-medium" value="{{$dostepneZakresy}}"></td>
	</tr>
	<tr>
		<td><label for="{{$nazwa}}_pager_skoczDo">{{$etykieta_skoczDo}}</label></td>
		<td>
			<input type="checkbox" name="{{$nazwa}}_pager_skoczDo" id="{{$nazwa}}_pager_skoczDo" class="input-medium" value="form" {{IF $skoczDo}}checked="checked"{{END}}/>
		</td>
	</tr>
	<tr>
		<td>{{$etykieta_wyborStrony}}</td>
		<td>
			<select name="{{$nazwa}}_pager_wyborStrony" id="{{$nazwa}}_pager_wyborStrony" class="input-medium">
				<option value="" {{IF $wyborStrony == ''}}selected="selected"{{END}}>{{$wybor_brak}}</option>
				<option value="linki" {{IF $wyborStrony == 'linki'}}selected="selected"{{END}}>{{$wybor_linki}}</option>
				<option value="select" {{IF $wyborStrony == 'select'}}selected="selected"{{END}}>{{$wybor_select}}</option>
			</select>
		</td>
	</tr>
	<tr id="{{$nazwa}}_pr2">
		<td><label for="{{$nazwa}}_pager_poprzedniaNastepna">{{$etykieta_poprzedniaNastepna}}</label></td>
		<td><input type="checkbox" name="{{$nazwa}}_pager_poprzedniaNastepna" id="{{$nazwa}}_pager_poprzedniaNastepna" value="1" {{IF $poprzedniaNastepna}}checked="checked"{{END}}/></td>
	</tr>
	<tr id="{{$nazwa}}_pr3">
		<td><label for="{{$nazwa}}_pager_pierwszaOstatnia">{{$etykieta_pierwszaOstatnia}}</label></td>
		<td><input type="checkbox" name="{{$nazwa}}_pager_pierwszaOstatnia" id="{{$nazwa}}_pager_pierwszaOstatnia" value="1" {{IF $pierwszaOstatnia}}checked="checked"{{END}}/></td>
	</tr>
	<tr id="{{$nazwa}}_pr4">
		<td>{{$etykieta_zakres}}</td>
		<td><input size="2" maxlength="2" type="text" name="{{$nazwa}}_pager_zakres" value="{{$zakres}}"/></td>
	</tr>
	<tr id="{{$nazwa}}_pr5">
		<td>{{$etykieta_skoki}}</td>
		<td class="btn-group">
			<input type="button" value="{{$etykieta_skoki_dodaj}}" class="dodaj_pole btn btn-success" />
			<input type="button" value="{{$etykieta_skoki_usun}}" class="usun_pole btn btn-danger" />
		</td>
	</tr>
</table>
<table id="{{$nazwa}}_pr6" class="input_pager">
{{BEGIN wiersze}}
	<tr class="para">
		<td><input type="text" size="3" maxlength="3" name="{{$nazwa}}_pager_skok[]" class="input-medium" value="{{$klucz}}" class="input_pager_klucz"/></td>
		<td>{{$etykieta_podzial}}</td>
		<td><input type="text" size="10" name="{{$nazwa}}_pager_skok_etykieta[]" class="input-medium" value="{{$wartosc}}" class="input_pager_wartosc"/></td>
	</tr>
{{END}}
</table>

<script type="text/javascript">
<!--
$(document).ready(function(){
	function {{$nazwa}}CheckPager()
	{
		if ($("#{{$nazwa}}_pager_wyborZakresu").val() == "")
		{
			$("#{{$nazwa}}_pr1").hide();
		}
		else
		{
			$("#{{$nazwa}}_pr1").show();
		}

		$("#{{$nazwa}}_pr2, #{{$nazwa}}_pr3, #{{$nazwa}}_pr4, #{{$nazwa}}_pr5, #{{$nazwa}}_pr6").hide();

		wybor = $("#{{$nazwa}}_pager_wyborStrony").val();
		if (wybor == 'select')
		{
			$("#{{$nazwa}}_pr2").show();
		}
		else if (wybor == 'linki')
		{
			$("#{{$nazwa}}_pr2, #{{$nazwa}}_pr3, #{{$nazwa}}_pr4, #{{$nazwa}}_pr5, #{{$nazwa}}_pr6").show();
		}
	}

	$("#{{$nazwa}}_pager_wyborZakresu, #{{$nazwa}}_pager_wyborStrony").change(function() { {{$nazwa}}CheckPager(); });

	{{$nazwa}}CheckPager();

	$("#{{$nazwa}}_pr5 .dodaj_pole").click(function()
	{
		var input = '<tr class="para"><td><input type="text" size="3" maxlength="3"  name="{{$nazwa}}_pager_skok[]" value="" class="input_pager_klucz"/></td><td>{{$etykieta_podzial}}</td><td><input type="text" size="10" name="{{$nazwa}}_pager_skok_etykieta[]" value="" class="input_pager_wartosc"/></td></tr>';

		if ($("#{{$nazwa}}_pr6 .para").length >= {{$liczba_wierszy}})
		{
			return;
		}
		if ($("#{{$nazwa}}_pr6 .para:last").length == 0)
		{
			$("#{{$nazwa}}_pr6").prepend(input);
		}
		else
		{
			$("#{{$nazwa}}_pr6 .para:last").after(input);
		}
		$("#{{$nazwa}}_pr6 .para:last").show("fast");
	});

	$("#{{$nazwa}}_pr5 .usun_pole").click(function(){
		if ($("#{{$nazwa}}_pr6 .para").length > 1)
		{
			$("#{{$nazwa}}_pr6 .para:last").fadeOut("normal").remove();
		}
	});
});
-->
</script>