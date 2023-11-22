{{BEGIN index}}
<div class="formularz_region ">
	<div class="widget-title region_tytul {{$wyswietlajRegion}}">
		<span class="icon">
		<i class="{{IF $wyswietlajRegion == 'closed'}} icon-circle-arrow-down {{ELSE}} icon-circle-arrow-up {{END}}"></i>
		</span>
		<h5>{{$tytul}}</h5>
	</div>
	<div id="{{$kod}}" class="region_tresc" {{IF $wyswietlajRegion == 'closed'}}style="display:none;"{{END}} >
{{BEGIN szukajZamowienia}}
	<script type="text/javascript">
		nalozSelect{{$kod}}();
		
		function nalozSelect{{$kod}}()
		{
			$('#zamowienieInput_{{$kod}}').select2({
				placeholder: "Enter min. 3 characters",
				minimumInputLength: 3,
				ajax: {
					url: "{{$urlSzukajZamowienie}}",
					dataType: 'json',
					quietMillis: 100,
					data: function (term, page) { 
						return {
							fraza: term, 
							nrStrony: page,
							naStronie: 20,
						};
					},
					results: function (data, page) {
						var more = (page * 20) < data.total; 

						return {results: data.orders, more: more};
					}
				},
				formatResult: ordersFormatResult, // omitted for brevity, see the source of this page
				formatSelection: ordersFormatSelection, // omitted for brevity, see the source of this page
				dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
				escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
			});
		}
	
		function ordersFormatResult(orders) {
		
			var markup = "<table class=''><tr>";
			markup += "<td class=''><div class='type'>" + orders.type_name + "</div></td>";

			if (orders.number_order_get != undefined && orders.number_order_get != '')
			{
				markup += "<td class=''><div>WO: " + orders.number_order_get + "</div></td>";
			}
			else
			{
				markup += "<td class=''><div>WO BKT: " + orders.id + "</div></td>";
			}

			if (orders.id_customer != undefined && orders.id_customer != '')
			{
				markup += "<td class='small'><div class='company'>(# "+ orders.id_customer +")</div></td>";
			}
			if (orders.name != undefined && orders.name != '' && orders.surname != undefined && orders.surname != '')
			{
				markup += "<td class=''><div>";
				markup += orders.name + " ";
				if (orders.second_name != undefined && orders.second_name != '')
				{
					markup += orders.second_name + " ";
				}
				markup += orders.surname + "</div></td>";
			}
			else if (orders.company_name != undefined && orders.company_name != '')
			{
				markup += "<td class=''><div>" + orders.company_name + "</div></td>";
			}
			else
			{
				markup += "<td class=''><div>{{$etykieta_BKT}}</div></td>";
			}
			if (orders.city != undefined && orders.city != '')
			{
				markup += "<td><div>("+ orders.postcode + " " + orders.city;

				if (orders.address != undefined && orders.address != '')
				{
					markup += ", " + orders.address;
				}

				markup += ")</div></td>";
			}
			if (orders.order_name != undefined && orders.order_name != '')
			{
				markup +="<td><strong>"+orders.order_name+"</strong></td>";
			}

			markup += "</tr></table>";
			return markup;
		}
		function ordersFormatSelection(orders) {
				$('input[name^=nazwaWyswietlana]').val('Event ' + orders.order_name);
				rozwinNastepnyRegion($('#zamowienieInput_{{$kod}}'));
				return orders.order_name;
		}
		
		function zamowienieValidacja()
		{
			var wartosc = $('#zamowienieInput_{{$kod}}').val();
			
			if(wartosc > 0)
			{
				$('.zamowienieInput_{{$kod}}').hide();
				return true;
			}
			else
			{
				$('.zamowienieInput_{{$kod}}').show();
				return false;
			}
		}
		
	</script>
	<div class="control-group input_ok" style="width:100%; ">
		<label class="control-label input_ok " for="address">Select order : </label>
			<div class="controls">
				<input class="js-data-example-ajax" style="width: 90%;" name="zamowienieInput" id="zamowienieInput_{{$kod}}" data-valid="zamowienieValidacja" />
				<span class="help-inline zamowienieInput_{{$kod}}" style="display:none;" >This field is required, please select a project</span>
		</div>
	</div>
	{{END szukajZamowienia}}
	{{BEGIN dodajJakoApartament}}
		<input type="checkbox" name="apartamenty" id="apartament_{{$kod}}"  />
	{{END dodajJakoApartament}}
	</div>
</div>
{{END index}}