<div class="select_wrap select2 productsInput products" id="{{$nazwa}}_input">
	<p>
	{{IF $dodawanie}}
	<span id="{{$nazwa}}_container" class="select">
		<select name="{{$nazwa}}" id="{{$nazwa}}" {{$atrybuty}}>
			{{BEGIN wiersz}}
				<option value="{{$wartosc}}">{{$etykieta}}</option>
			{{END}}
		</select>
	</span>
		<a href="javascript:void(0);" class="btn btn-success add_button add_button_{{$nazwa}}"><i class="icon icon-plus"></i> {{$etykieta_dodaj}}</a>
	</p>
	{{END}}
</div>
		
<div class="prd_dodane prd_dodane_{{$nazwa}}">
<ul>
{{BEGIN produkt_dodany}}
	<li class="item">
		<span class="prd">{{$wartosc_nazwa}}</span><span class="qty">{{IF $dodawanie}}<button class="btn btn-danger remove"><i class="icon icon-remove"></i> {{$etykieta_usun}}</button>{{END}}
		<input type="hidden" name="{{$nazwa}}_id[]" value="{{$wartosc_id}}"/>
		<input type="hidden" name="{{$nazwa}}_nazwa[]" value="{{$wartosc_nazwa}}"/>
	</li>
{{END}}
</ul>
</div>
<script type="text/javascript">
	var wierszLista = '<li class="item"><span class="prd">{NAZWA_PRODUKTU}</span>\n\
	<button class="btn btn-danger remove"><i class="icon icon-remove"></i> {{$etykieta_usun}}</button>\n\
<input type="hidden" name="{NAZWA_INPUTA}_id[]" value="{ID}"/><input type="hidden" name="{NAZWA_INPUTA}_nazwa[]" value="{NAZWA_PRODUKTU}"/>\n\
';
	$(document).ready(function(){
		
		if (jest == 0)
		{
			{{IF $dodawanie}}
			$(".add_button_{{$nazwa}}").live('click', function(){
				var nazwa_inputa = $(this).parents('.productsInput').attr('id').replace('_input', '');
				var id = $(this).parents('.select_wrap').find("#"+nazwa_inputa).val();
				var nazwa = $(this).parents('.select_wrap').find("#"+nazwa_inputa+" option[value="+id+"]").text();

				var znajdz = [ '{ID}', '{NAZWA_PRODUKTU}', '{NAZWA_INPUTA}'];
				var zamien = [id, nazwa, nazwa_inputa];

				var zamienionyWiersz = wierszLista.replaceArray(znajdz, zamien);

				$(this).parents('form').find(".prd_dodane_{{$nazwa}} ul").append(zamienionyWiersz);
				
				return false;
			});
			{{END}}
			
			setTimeout(function(){
				$("#{{$nazwa}}_container").children('div').animate({width: "92%"}, 500);
			}, 100);
			jest++;
		}
		
		
		$(".remove").live('click', function(){
			$(this).parents('li.item').remove();
			return false;
		});
		
	});
</script>