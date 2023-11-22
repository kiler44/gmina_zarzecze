{{IF $wiersz}}
<div class="select_wrap select2 products">
	<p>
	<span id="{{$nazwa}}_container" class="select">
	<select name="{{$nazwa}}" id="{{$nazwa}}" {{$atrybuty}}>
		{{BEGIN wiersz}}
			<option value="{{$wartosc}}" multiplied="{{$multiple}}" class="{{$main}}" data-unit="{{$jednostka}}">{{$etykieta}}</option>
		{{END}}
	</select>
	</span>
		<span class="qty" ><input type="text" class="spn" data-unit="" name="{{$nazwa}}_qty_add" value="1" id="{{$nazwa}}_qty_add" readonly="readonly"/></span>
		<button id="add" class="btn btn-success add_button add_button_{{$nazwa}}"><i class="icon icon-plus"></i> {{$etykieta_dodaj}}</button>
	</p>
</div>

{{ELSE}}
	<select name="{{$nazwa}}" id="{{$nazwa}}" {{$atrybuty}} style="display: none;">
		<option value="0" multiplied="0" ></option>
	</select>
	<div style="height: 40px"></div>
{{END}}

<div class="prd_dodane prd_dodane_{{$nazwa}}">
<ul>
{{BEGIN produkt_dodany}}
	<li class="item {{IF $_first}}bold{{END}}">
		<span class="prd" data-unit="{{$wartosc_jednostka}}">{{$wartosc_nazwa}}</span>{{IF $wartosc_multiple == "true"}}<span class="qty"><input type="text" class="spn" data-unit="{{$wartosc_jednostka}}" name="{{$nazwa}}_qty[]" value="{{$wartosc_ilosc}}" readonly="readonly"/></span>{{ELSE}}<input type="hidden" name="{{$nazwa}}_qty[]" value="1"/>{{END}}{{IF $wartosc_usun == true }}<button class="btn btn-danger remove"><i class="icon icon-remove"></i> {{$etykieta_usun}}</button>{{END}}
		<input type="hidden" name="{{$nazwa}}_id[]" value="{{$wartosc_id}}"/>
		<input type="hidden" name="{{$nazwa}}_nazwa[]" value="{{$wartosc_nazwa}}"/>
		<input type="hidden" name="{{$nazwa}}_ilosc[]" value="{{$wartosc_ilosc}}"/>
		<input type="hidden" name="{{$nazwa}}_multiple[]" value="{{$wartosc_multiple}}"/>
		<input type="hidden" name="{{$nazwa}}_jednostka[]" value="{{$wartosc_jednostka}}"/>
	</li>
{{END}}
</ul>
</div>
<script type="text/javascript">
	var wiersz = '<li class="item" ><span class="prd">{NAZWA_PRODUKTU}</span><span class="qty"><input type="text" class="spn" name="{{$nazwa}}_qty[]" value="{ILOSC}""/></span><button class="btn btn-danger remove"><i class="icon icon-remove"></i> {{$etykieta_usun}}</button><input type="hidden" name="{{$nazwa}}_id[]" value="{ID}"/><input type="hidden" name="{{$nazwa}}_nazwa[]" value="{NAZWA_PRODUKTU}"/><input type="hidden" name="{{$nazwa}}_ilosc[]" value="{ILOSC}"/><input type="hidden" name="{{$nazwa}}_multiple[]" value="{MULTIPLE}"/><input type="hidden" name="{{$nazwa}}_jednostka[]" value="{JEDNOSTKA}"/></li>';
	$("#add").click(function(){
		var id = $("#{{$nazwa}}").val();
		var nazwa = $("#{{$nazwa}} option[value="+id+"]").text();
		var ilosc = $("#{{$nazwa}}_qty_add").val();
		var multiple = $("#{{$nazwa}} option[value="+id+"]").attr('multiplied');
		var jednostka = $("#{{$nazwa}} option[value="+id+"]").attr('data-unit');
		
		var znajdz = [ '{ID}', '{NAZWA_PRODUKTU}', '{ILOSC}', '{MULTIPLE}', '{JEDNOSTKA}'];
		var zamien = [id, nazwa, ilosc, multiple, jednostka];

		var zamienionyWiersz = wiersz.replaceArray(znajdz, zamien);
		
		$(".prd_dodane_{{$nazwa}} ul").append(zamienionyWiersz);
		$(".prd_dodane_{{$nazwa}} .spn").spinner({min: 1});
		$("#{{$nazwa}}_qty_add").val(1);
		updateZamknijZamowienie(false);
		return false;
	});
	
	function sprawdzMultipleDodawanie()
	{
		var m = $('#{{$nazwa}} option:selected').attr('multiplied');
		var unit = $('#{{$nazwa}} option:selected').attr('data-unit');
		
		if (m == 'true')
		{
			$('#{{$nazwa}}_container').parent('p').find('.qty').show();
			$('#{{$nazwa}}_container').parent('p').find('.spn').attr('data-unit', unit);
			if(unit == 'h')
			{
				//$('#{{$nazwa}}_container').parent('p').find('.spn[data-unit=h]').val({{$min_h}});
				$(".spn[data-unit=h]").spinner( { min: {{$min_h}}, step: {{$skok_h}}, value: {{$min_h}} } );
			}
			else
			{
				//$('#{{$nazwa}}_container').parent('p').find('.spn[data-unit=szt]').val({{$min_szt}});
				$(".spn[data-unit=szt]").spinner( { min: {{$min_szt}}, step: {{$skok_szt}}, value: {{$min_szt}} } );
			}
		}
		else
			$('#{{$nazwa}}_container').parent('p').find('.qty').hide();
	}
	
	$('#{{$nazwa}}').live('change', function(){
		sprawdzMultipleDodawanie();
	});
	
	$(".remove").click(function(){
		var resetuj = false;
		if ($(this).parents('.item').hasClass('bold'))
		{
			if (confirm('{{$potwierdzResetuj}}'))
			{
				resetuj = true;
			}
			else
			{
				return false;
			}
		}
		var elementUsun = $(this).parent('li');
		var usuwaj = false;
		$('.prd_dodane ul').children('li').each(function(){
			
			if(elementUsun.is($(this)))
				usuwaj = true;
			
			if(usuwaj)
				$(this).remove();
		});
		//$(this).parents('li.item').remove();
		updateZamknijZamowienie(resetuj, true);
		return false;
	});
	$(".prd_dodane .spn").bind('propertychange keyup input paste', function(){
		updateZamknijZamowienie(false);
	});
	$(document).ready(function(){
		
		$(".spn[data-unit=szt]").spinner( { min: {{$min_szt}}, step: {{$skok_szt}}, value: {{$min_h}} } );
		$(".spn[data-unit=h]").spinner( { min: {{$min_h}}, step: {{$skok_h}}, value: {{$min_szt}} } );
		
		sprawdzMultipleDodawanie();
		
		$(".prd_dodane .ui-spinner-button").bind("mouseup", function() {
			updateZamknijZamowienie(false);
		});
		
		setTimeout(function(){
			$("#{{$nazwa}}_container").children('div').animate({width: "92%"}, 500);
		}, 100);
	});
</script>