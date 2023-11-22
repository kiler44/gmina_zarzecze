<table id="{{$nazwa}}" class="input_array" border="0">
	<tr class="atrybut wierszAtrybutu" style="display: none;">
		<td><input type="text" name="{{$nazwa}}_klucz[]" value="{{$klucz}}" class="input_tablica_klucz" {{$atrybuty}} {{IF $disabled}}readonly="readonly"{{END}}/></td>
		<td>{{$etykieta_podzial}} </td>
		<td><input type="text" name="{{$nazwa}}_wartosc[]" value="{{$wartosc}}" class="input_tablica_wartosc" {{$atrybuty}} {{IF $disabled}}readonly="readonly"{{END}}/></td>
		<td>{{$etykieta_podzial_uprawnienia}} </td>
		<td>
			<select name="{{$nazwa}}_uprawnienie[]" class="input_tablica_uprawnienie clone" {{$atrybuty}}>
			{{BEGIN listaTmp}}
				<option value="{{$opcja}}" {{IF $selected}}selected="selected"{{END}}>{{$etykieta}}</option>
			{{END}}
			</select>
		</td>
		<td>
			<a  href="javascript:void(0);" class="btn btn-danger usun_pole" title="{{$etykieta_usun_pole}}" > <i class="icon icon-remove"></i> </a>
		</td>
	</tr>
	{{BEGIN wartosci}}
		<tr class="wierszAtrybutu" style="display:{{$wyswietlaj}}">
			<td><input type="text" name="{{$nazwa}}_klucz[]" value="{{$klucz}}" class="input_tablica_klucz" {{$atrybuty}} {{IF $disabled}}readonly="readonly"{{END}}/></td>
			<td>{{$etykieta_podzial}} </td>
			<td><input type="text" name="{{$nazwa}}_wartosc[]" value="{{$wartosc}}" class="input_tablica_wartosc" {{$atrybuty}} {{IF $disabled}}readonly="readonly"{{END}}/></td>
			<td>{{$etykieta_podzial_uprawnienia}} </td>
			<td>
				<select name="{{$nazwa}}_uprawnienie[]" class="input_tablica_uprawnienie" {{$atrybuty}}>
				{{IF $wybierz}}<option value="">{{$wybierz}}</option>{{END}}
				{{BEGIN lista}}
					<option value="{{$opcja}}" {{IF $selected}}selected="selected"{{END}}>{{$etykieta}}</option>
				{{END}}
				</select>
			</td>
			<td>
				<a  href="javascript:void(0);" class="btn btn-danger usun_pole" title="{{$etykieta_usun_pole}}" > <i class="icon icon-remove"></i> </a>
			</td>
		</tr>
	{{END}}
	</table>
	<a  href="javascript:void(0);" class="btn btn-default dodaj_pole" title="{{$etykieta_dodaj_pole}}" > 
		<i class="icon icon-plus"></i> {{$etykieta_dodaj_pole}} 
	</a>
	<script type="text/javascript">
	$(document).ready(function(){
		$('.input_tablica_uprawnienie:not(.clone)').select2();
		$(".dodaj_pole").on('click' , function()
		{
			var atrybut = $('.atrybut:first').clone();
			atrybut.removeClass('atrybut');
			atrybut.find('.input_tablica_klucz').val('');
			atrybut.find('.input_tablica_wartosc').val('');
			$('#{{$nazwa}}').append(atrybut);
			atrybut.show();
			atrybut.find('.input_tablica_uprawnienie').select2();
			return false;
		});
		$(document).on('click', '.usun_pole' , function(e){ usunPole($(this));	});
		
		
	});
	function usunPole(obiekt)
	{
		if($('#{{$nazwa}} .wierszAtrybutu').length < 3)
		{
			$('#{{$nazwa}} .wierszAtrybutu').find('.input_tablica_klucz').val('');
			$('#{{$nazwa}} .wierszAtrybutu').find('.input_tablica_wartosc').val('');
		}
		else
		{
			obiekt.parents('.wierszAtrybutu').remove();
		}
		
	}
	</script>