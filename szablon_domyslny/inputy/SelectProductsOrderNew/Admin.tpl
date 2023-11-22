<div class="select_wrap select2 products productsInput" id="{{$nazwa}}_input">
	<p>
		<input type="hidden" class="skok" name="{{$nazwa}}_skok"  value="{{$skok}}"/>
	{{IF $dodawanie}}
	<span id="{{$nazwa}}_container" class="select">
		<select name="{{$nazwa}}" id="{{$nazwa}}" {{$atrybuty}}>
			{{BEGIN wiersz}}
				<option value="{{$wartosc}}">{{$etykieta}}</option>
			{{END}}
		</select>
		<span class="qty"><input type="text" class="spn" name="{{$nazwa}}_qty_add" value="1" id="{{$nazwa}}_qty_add"/></span>
	</span>
		<a href="javascript:void(0);" class="btn btn-success add_button add_button_{{$nazwa}}"><i class="icon icon-plus"></i> {{$etykieta_dodaj}}</a>
	</p>
	{{END}}
</div>
		
<div class="prd_dodane prd_dodane_{{$nazwa}}">
<ul>
{{BEGIN produkt_dodany}}
	<li class="item">
		<span class="prd">{{$wartosc_nazwa}}</span><span class="qty"><input type="text" class="spn" name="{{$nazwa}}_qty[]" value="{{$wartosc_ilosc}}""/></span>{{IF $dodawanie}}<button class="btn btn-danger remove"><i class="icon icon-remove"></i> {{$etykieta_usun}}</button>{{END}}
		<input type="hidden" name="{{$nazwa}}_id[]" value="{{$wartosc_id}}"/>
		<input type="hidden" name="{{$nazwa}}_nazwa[]" value="{{$wartosc_nazwa}}"/>
		<input type="hidden" name="{{$nazwa}}_ilosc[]" value="{{$wartosc_ilosc}}"/>
	</li>
{{END}}
</ul>
</div>
<script type="text/javascript">
	var wiersz = '<li class="item"><span class="prd">{NAZWA_PRODUKTU}</span><span class="qty"><input type="text" class="spn" name="{NAZWA_INPUTA}_qty[]" value="{ILOSC}""/></span><button class="btn btn-danger remove"><i class="icon icon-remove"></i> {{$etykieta_usun}}</button><input type="hidden" name="{NAZWA_INPUTA}_id[]" value="{ID}"/><input type="hidden" name="{NAZWA_INPUTA}_nazwa[]" value="{NAZWA_PRODUKTU}"/><input type="hidden" name="{NAZWA_INPUTA}_ilosc[]" value="{ILOSC}"/></li>';
	$(document).ready(function(){
		
		if (jest == 0)
		{
			{{IF $dodawanie}}
			$(".add_button_{{$nazwa}}").live('click', function(){
				var nazwa_inputa = $(this).parents('.productsInput').attr('id').replace('_input', '');
				var id = $(this).parents('.select_wrap').find("#"+nazwa_inputa).val();
				var nazwa = $(this).parents('.select_wrap').find("#"+nazwa_inputa+" option[value="+id+"]").text();
				var ilosc = $(this).parents('.select_wrap').find("#"+nazwa_inputa+"_qty_add").val();

				var znajdz = [ '{ID}', '{NAZWA_PRODUKTU}', '{ILOSC}', '{NAZWA_INPUTA}'];
				var zamien = [id, nazwa, ilosc, nazwa_inputa];

				var zamienionyWiersz = wiersz.replaceArray(znajdz, zamien);

				$(this).parents('form').find(".prd_dodane_{{$nazwa}} ul").append(zamienionyWiersz);
				
				$(this).parents('form').find(".prd_dodane_{{$nazwa}} .spn").spinner({min: 0});
					
				$("#{{$nazwa}}_qty_add").val(1);

				return false;
			});
			{{END}}
			
			setTimeout(function(){
				$("#{{$nazwa}}_container").children('div').animate({width: "92%"}, 500);
			}, 100);
			jest++;
		}
		
		$('#{{$nazwa}}_input').parents('.controls').find('.spn').spinner({min: 0});
		
		$(".remove").live('click', function(){
			$(this).parents('li.item').remove();
			return false;
		});
		
	});
</script>