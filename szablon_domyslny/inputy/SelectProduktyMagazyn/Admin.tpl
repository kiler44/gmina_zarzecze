{{IF $wiersz}}
<div id='{{$nazwa}}_container' >
	<div>
	<input name="{{$nazwa}}" id="{{$nazwa}}" {{$atrybuty}} {{IF blokuj}}disabled="disabled"{{END}} style='width: 34.70%;'  />
	<span class="qty"><input type="text" class="spn" name="{{$nazwa}}_qty_add" value="1" id="{{$nazwa}}_qty_add" readonly="readonly"/></span>
	<input type="hidden" name="{{$nazwa}}_idTmp" id='id_produkt' value=""/>
	<input type="hidden" name="{{$nazwa}}_nazwaTmp" id='nawa_produkt' value=""/>
	<input type="hidden" name="{{$nazwa}}_iloscTmp" id='ilosc_produkt' value=""/>
	<input type="hidden" name="{{$nazwa}}_kodTmp" id='kod_produkt' value=""/>
	{{IF blokuj == 0}}<button id="add" class="btn btn-success"><i class="icon icon-plus"></i> {{$etykieta_dodaj}}</button>{{END}}
	</div>
</div>
{{END}}
<div class="prd_dodane" style="margin-top:30px;">
<ul>
{{BEGIN produkt_dodany}}
<li class="item" style="padding-top:5px;">
		<span class="prd">{{$wartosc_nazwa}}</span>
		<span class="qty">
			<input type="text" class="spn" name="{{$nazwa}}_qty[]" value="{{$wartosc_ilosc}}" readonly="readonly"/>
		</span>
		{{IF blokuj == 0}}<button class="btn btn-danger remove"><i class="icon icon-remove"></i> {{$etykieta_usun}}</button>{{END}}
		<input type="hidden" name="{{$nazwa}}_id[]" value="{{$wartosc_id}}"/>
		<input type="hidden" name="{{$nazwa}}_nazwa[]" value="{{$wartosc_nazwa}}"/>
		<input type="hidden" name="{{$nazwa}}_kod[]" value="{{$wartosc_kod}}"/>
	</li>
{{END}}
</ul>
</div>
<script type="text/javascript">
	var wiersz = '<li class="item"  style="padding-top:5px;">\n\
						<span class="prd">{NAZWA_PRODUKTU}</span>\n\
						<span class="qty {CLASS}"><input type="text" class="spn" name="{{$nazwa}}_qty[]" value="{ILOSC}""/></span>\n\
						<button class="btn btn-danger remove"><i class="icon icon-remove"></i> {{$etykieta_usun}}</button>\n\
						<input type="hidden" name="{{$nazwa}}_id[]" value="{ID}"/>\n\
						<input type="hidden" name="{{$nazwa}}_nazwa[]" value="{NAZWA_PRODUKTU}"/>\n\
						<input type="hidden" name="{{$nazwa}}_kod[]" value="{KOD_PRODUKTU}"/>\n\
						<input type="hidden" name="{{$nazwa}}_ilosc[]" value="{ILOSC}"/></li>';
	$("#add").click(function(){
		var id = $("#id_produkt").val();
		var nazwa = $("#nawa_produkt").val();
		var kod = $("#kod_produkt").val();
		var ilosc = $("#{{$nazwa}}_qty_add").val();
		
		var znajdz = [ '{ID}', '{NAZWA_PRODUKTU}', '{ILOSC}', '{KOD_PRODUKTU}'];
		var zamien = [id, nazwa, ilosc, kod];

		var zamienionyWiersz = wiersz.replaceArray(znajdz, zamien);
		
		$(".prd_dodane ul").append(zamienionyWiersz);
		$(".prd_dodane .spn").spinner({min: 1});
		$("#{{$nazwa}}_qty_add").val(1);

		return false;
	});
	
	
	$(".remove").click(function(event){
		event.isDefaultPrevented();
		$(this).parents('li.item').remove();
		return false;
	});
	
	
	$(document).ready(function(){
		{{IF blokuj == 0}}
		$(".spn").spinner({min: 1});
		{{END}}
		setTimeout(function(){
			$("#{{$nazwa}}_container").children('div').animate({width: "92%"}, 500);
		}, 100);
		$("#{{$nazwa}}").select2("destroy");
		
		$("#{{$nazwa}}").select2({
			placeholder: "{{$szukaj_produkty_magazyn_etykieta}}",
			minimumInputLength: 3,
			ajax: {
				url: "{{$linkAjaxSzukaj}}",
				dataType: 'json',
				quietMillis: 100,
				data: function (term, page) { // page is the one-based page number tracked by Select2
					return {
						fraza: term, //search term
						customer: "get",
						nrStrony: page,
						naStronie: 20,
					};
				},
				results: function (data, page) {
					var more = (page * 20) < data.total; // whether or not there are more results available
					//// notice we return the value of more so Select2 knows if more results can be loaded
					return {results: data.produkty, more: more};
				}
			},
			formatResult: ordersFormatResult, // omitted for brevity, see the source of this page
			formatSelection: ordersFormatSelection, // omitted for brevity, see the source of this page
			dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
			escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
		});
		
	});
	
	function ordersFormatResult(produkt) {
		
		var markup = "<table style='width:100%;' ><tr>";
		if(produkt.zdjecie != ' ' && produkt.zdjecie != null)
		{
			markup += "<td style='width:80px;'><img src='"+produkt.zdjecie+"' /></td>"
		}
		markup += "<td style='text-align:left;'><div >" + produkt.nazwa_produktu +" <strong>( "+produkt.kod+" )</strong></div></td>";
		markup += "</tr></table>";
		return markup;
	}
	
	function ordersFormatSelection(produkt) {
		$('#nawa_produkt').val(produkt.nazwa_produktu);
		$('#kod_produkt').val(produkt.kod);
		$('#id_produkt').val(produkt.id);
		
		return produkt.nazwa_produktu+' '+' <strong>( '+produkt.kod+' )</strong>';
	}
	
</script>