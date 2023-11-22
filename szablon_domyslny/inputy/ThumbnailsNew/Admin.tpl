<table id="{{$nazwa}}" class="input_miniatury" border="0">
	{{BEGIN wiersz}}
		<tr class="wiersz_minatury">
			<td>{{$etykieta_kod}}<input type="text" size="10" name="{{$nazwa}}_min_kod[]" value="{{$kod}}"></td>
			<td>{{$etykieta_szerokosc}} <input type="text" size="4" maxlength="4" name="{{$nazwa}}_min_szerokosc[]" value="{{$szerokosc}}"></td>
			<td>{{$etykieta_wysokosc}} <input type="text" size="4" maxlength="4" name="{{$nazwa}}_min_wysokosc[]" value="{{$wysokosc}}"></td>
			<td>{{$etykieta_metoda}}
			<select name="{{$nazwa}}_min_metoda[]">
				<option value="scale" {{IF $metoda == 'scale'}}selected="selected"{{END}}>{{$metoda_scale}}</option>
				<option value="crop" {{IF $metoda == 'crop'}}selected="selected"{{END}}>{{$metoda_crop}}</option>
				<option value="scaleCrop" {{IF $metoda == 'scaleCrop'}}selected="selected"{{END}}>{{$metoda_scaleCrop}}</option>
				<option value="resize" {{IF $metoda == 'resize'}}selected="selected"{{END}}>{{$metoda_resize}}</option>
			</select></td>
		</tr>
	{{END}}
	</table>
	<div class="input_miniatury btn-group" id="{{$nazwa}}_control">
		<input type="button" value="{{$etykieta_dodaj_pole}}" class="dodaj_pole btn btn-success" />
		<input type="button" value="{{$etykieta_usun_pole}}" class="usun_pole btn btn-danger" />
	</div>
	<script type="text/javascript">
	<!--
	$(document).ready(function(){

		$("#{{$nazwa}}_control .dodaj_pole").click(function()
		{
			var input = '<tr class="wiersz_minatury"><td>{{$etykieta_kod}}<input type="text" size="10" name="{{$nazwa}}_min_kod[]" value=""></td><td>{{$etykieta_wysokosc}}<input type="text" size="4" maxlength="4" name="{{$nazwa}}_min_wysokosc[]" value=""></td><td>{{$etykieta_szerokosc}}<input type="text" size="4" maxlength="4" name="{{$nazwa}}_min_szerokosc[]" value=""></td><td>{{$etykieta_metoda}}<select name="{{$nazwa}}_min_metoda[]"><option value="scale">{{$metoda_scale}}</option><option value="crop">{{$metoda_crop}}</option><option value="resize">{{$metoda_resize}}</option></select></td></tr>';

			if ($("#{{$nazwa}} .wiersz_minatury").length >= {{$liczba_wierszy}})
			{
				return;
			}
			if ($("#{{$nazwa}} .wiersz_minatury:last").length == 0)
			{
				$("#{{$nazwa}}").prepend(input);
			}
			else
			{
				$("#{{$nazwa}} .wiersz_minatury:last").after(input);
			}
			$("#{{$nazwa}} .wiersz_minatury:last").show("fast");
		});

		$("#{{$nazwa}}_control .usun_pole").click(function()
		{
			if ($("#{{$nazwa}} .wiersz_minatury").length > 1)
			{
				$("#{{$nazwa}} .wiersz_minatury:last").fadeOut("normal").remove();
			}
		});
	});
	-->
	</script>