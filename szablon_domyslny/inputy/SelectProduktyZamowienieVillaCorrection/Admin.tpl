<div class="select_wrap select2 products productsInput" id="{{$nazwa}}_input">
	<p>
	{{IF $dodawanie}}
	<span id="{{$nazwa}}_container" class="select">
		<select name="{{$nazwa}}" id="{{$nazwa}}" {{$atrybuty}}>
			<option value="0" > - select - </option>
			{{BEGIN wiersz}}
				<option value="{{$wartosc}}" data-unit="{{$jednostka}}" >{{$etykieta}}</option>
			{{END}}
		</select>
		<span class="qty"><input type="text" class="spn" data-unit="" name="{{$nazwa}}_qty_add" value="1" id="{{$nazwa}}_qty_add"/></span>
	</span>
		<a href="javascript:void(0);" class="btn btn-success add_button"><i class="icon icon-plus"></i> {{$etykieta_dodaj}}</a>
	</p>
	{{END}}
</div>
<div class="prd_dodane">
<ul>
{{BEGIN produkt_dodany}}
	<li class="item">
		<span class="prd">{{$wartosc_nazwa}}</span><span class="qty"><input type="text" class="spn" data-unit="{{$wartosc_jednostka}}" name="{{$nazwa}}_qty[]" value="{{$wartosc_ilosc}}""/></span>{{IF $dodawanie}}<button class="btn btn-danger remove"><i class="icon icon-remove"></i> {{$etykieta_usun}}</button>{{END}}
		<input type="hidden" name="{{$nazwa}}_id[]" value="{{$wartosc_id}}"/>
		<input type="hidden" name="{{$nazwa}}_nazwa[]" value="{{$wartosc_nazwa}}"/>
		<input type="hidden" name="{{$nazwa}}_ilosc[]" value="{{$wartosc_ilosc}}"/>
		<input type="hidden" name="{{$nazwa}}_jednostka[]" value="{{$wartosc_jednostka}}"/>
	</li>
{{END}}
</ul>
</div>
<script type="text/javascript">
	var wiersz = '<li class="item"><span class="prd">{NAZWA_PRODUKTU}</span><span class="qty"><input type="text" data-unit="{JEDNOSTKA}" class="spn" name="{NAZWA_INPUTA}_qty[]" value="{ILOSC}""/></span><button class="btn btn-danger remove"><i class="icon icon-remove"></i> {{$etykieta_usun}}</button><input type="hidden" name="{NAZWA_INPUTA}_id[]" value="{ID}"/><input type="hidden" name="{NAZWA_INPUTA}_nazwa[]" value="{NAZWA_PRODUKTU}"/><input type="hidden" name="{NAZWA_INPUTA}_ilosc[]" value="{ILOSC}"/><input type="hidden" name="{NAZWA_INPUTA}_jednostka[]" value="{JEDNOSTKA}"/></li>';
	$(document).ready(function(){
		
		if (jest == 0)
		{
			$('select[name={{$nazwa}}]').on('change', function(){
				var id = $(this).val();
				var unit = $(this).children('option[value='+id+']').attr('data-unit');
				
				if(unit == 'h')
				{
					$(this).siblings('.qty').find('.spn').attr('data-unit', unit);
					$(this).siblings('.qty').find('.spn').spinner( { min: 0, step: {{$skok_h}}, } );
				}
				else
				{
					$(this).siblings('.qty').find('.spn').attr('data-unit', unit);
					$(this).siblings('.qty').find('.spn').spinner( { min: 0, step: {{$skok_szt}}, } );
				}
				
				
			});
			
			{{IF $dodawanie}}
			$(".add_button").live('click', function(){
				var nazwa_inputa = $(this).parents('.productsInput').attr('id').replace('_input', '');
				var id = $(this).parents('.select_wrap').find("#"+nazwa_inputa).val();
				var nazwa = $(this).parents('.select_wrap').find("#"+nazwa_inputa+" option[value="+id+"]").text();
				var ilosc = $(this).parents('.select_wrap').find("#"+nazwa_inputa+"_qty_add").val();
				
				var jednostka = $(this).parents('.select_wrap').find("#"+nazwa_inputa+" option[value="+id+"]").attr('data-unit');
				var znajdz = [ '{ID}', '{NAZWA_PRODUKTU}', '{ILOSC}', '{NAZWA_INPUTA}', '{JEDNOSTKA}'];
				var zamien = [id, nazwa, ilosc, nazwa_inputa, jednostka];

				var zamienionyWiersz = wiersz.replaceArray(znajdz, zamien);

				$(this).parents('form').find(".prd_dodane ul").append(zamienionyWiersz);
				
				$(this).parents('form').find(".prd_dodane .spn[data-unit=szt]").spinner( { min: 0, step: {{$skok_szt}}, } );
				$(this).parents('form').find(".prd_dodane .spn[data-unit=h]").spinner( { min: 0, step: {{$skok_h}}, } );
					
				$("#{{$nazwa}}_qty_add").val(1);

				return false;
			});
			{{END}}
			
			setTimeout(function(){
				$("#{{$nazwa}}_container").children('div').animate({width: "92%"}, 500);
			}, 100);
			jest++;
		}
		
		$('#{{$nazwa}}_input').parents('.controls').find('.spn[data-unit=szt]').spinner( { min: 0 , step: {{$skok_szt}}, } );
		$('#{{$nazwa}}_input').parents('.controls').find('.spn[data-unit=h]').spinner( { min: 0, step: {{$skok_h}}, } );
		
		$(".remove").live('click', function(){
			$(this).parents('li.item').remove();
			return false;
		});
		
	});
</script>