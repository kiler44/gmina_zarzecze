{{BEGIN selectAjax}}
	{{IF $podglad}}
		{{IF $selection}}
		<p class="previewContainer"><strong class="fL" id="{{$nazwa}}-podglad-{{$mid}}"></strong><a href="javascript:editCustomer({{$id}});" title="{{$etykieta_edytuj}}" class="btn btn-primary fL tip-top"><i class="icon icon-edit-sign"></i></a><a href="javascript:toggleChangeCustomer(true);" title="{{$etykieta_zamien}}" class="btn btn-danger fL tip-top"><i class="icon icon-refresh"></i></a></p>		
		<p class="hidenContainer" style="display: none"><input type="hidden" class="bigdrop full-width fL" name="{{$nazwa}}" {{$atrybuty}} id="{{$nazwa}}_{{$mid}}"/> <a href="javascript:void(0);" id="{{$nazwa}}-link-{{$mid}}" class="fL btn {{IF $zablokowany}}disabled{{ELSE}}tip-left{{END}} tip-top" title="{{$etykieta_dodaj_klienta}}"><i class="icon icon-plus-sign">{{$etykieta_dodaj}}</i></a><a href="javascript:toggleChangeCustomer(false);" title="{{$etykieta_powrot_podglad}}" class="btn btn-primary fL tip-top"><i class="icon icon-arrow-left"></i></a></p>
		{{ELSE}}
		<p class="hidenContainer"><input type="hidden" class="bigdrop full-width fL" name="{{$nazwa}}" {{$atrybuty}} id="{{$nazwa}}_{{mid}}"/> <a href="javascript:void(0);" id="{{$nazwa}}-link-{{$mid}}" class="fL btn {{IF $zablokowany}}disabled{{ELSE}}tip-left{{END}} tip-top" title="{{$etykieta_dodaj_klienta}}"><i class="icon icon-plus-sign">{{$etykieta_dodaj}}</i></a></p>
		{{END IF}}
	{{ELSE}}
		<p><input type="hidden" class="bigdrop full-width" {{$atrybuty}} name="{{$nazwa}}" id="{{$nazwa}}_{{$mid}}"/> <a href="javascript:void(0);" id="{{$nazwa}}-link-{{$mid}}" class="btn {{IF $zablokowany}}disabled{{ELSE}}tip-left{{END}}" title="{{$etykieta_dodaj_klienta}}"><i class="icon icon-plus-sign">{{$etykieta_dodaj}}</i></a></p>
	{{END IF}}

<script type="text/javascript">
	var u = '{{$urlKlientDodajAjax}}';
	
	function toggleChangeCustomer(on)
	{
		if (on)
		{
			$('.previewContainer').hide();
			$('.bigdrop.full-width').css('width', '80%');
			$('.hidenContainer').show();
		}
		else
		{
			$('#{{$nazwa}}-podglad-{{$mid}}').html($('#s2id_{{$nazwa}}_{{$mid}} .select2-chosen').html());
			$('.previewContainer').show();
			$('.hidenContainer').hide();
		}
		$('.tip-top').tooltip();
	}
	
	function ustawSelect2(element)
	{
		element.select2({
			placeholder: "{{$wybierz}}",
			minimumInputLength: 3,
			ajax: {
				url: "{{$urlAjax}}",
				dataType: 'json',
				quietMillis: 100,
				data: function (term, page) { // page is the one-based page number tracked by Select2
					return {
						fraza: term, //search term
						typKlienta: "{{$typKlienta}}",
						nrStrony: page,
						naStronie: {{$naStronie}},
					};
				},
				results: function (data, page) {
					var more = (page * {{$naStronie}}) < data.total; // whether or not there are more results available
					//// notice we return the value of more so Select2 knows if more results can be loaded
					return {results: data.cust, more: more};
				}
			},
			formatResult: formatResult, // omitted for brevity, see the source of this page
			formatSelection: formatSelection, // omitted for brevity, see the source of this page
			dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
			escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
		});
	}
	
	function dodajAjax(id)
	{
		{{UNLESS $dodaj_modal}}
		$('.mobile-loader').fadeIn("normal");
		if ($(".klientKontener").length > 0)
		{
			//$('#'+originalUpperFormID).slideUp("fast");
			$(".klientKontener").remove();
			//$(".klientKontener select").select2();
		}
		
		originalUpperFormID = $('#{{$nazwa}}_{{$mid}}').parents('form').attr('id');
		$('#'+originalUpperFormID).slideUp("fast");
		{{END UNLESS}}

		if($(this).attr('rel') != '#' && typeof $(this).attr('rel') != 'undefined')
		{
			u = $(this).attr('rel');
		}
		u += '&field={{$nazwa}}_{{$mid}}';
		
		$.ajax({
			url: u,
			type: 'POST',
			data: {id: id},
			dataType: 'html',
			async: true,
			success: function(dane) {
				{{UNLESS $dodaj_modal}}
					$('#'+originalUpperFormID).after(dane);
					$('.klientKontener').hide().slideDown("slow");
					$('.mobile-loader').fadeOut("fast");
					$('.klientKontener select').select2();
					$("#klientFormularz-{{$nazwa}}_{{$mid}} #wstecz").unbind('click');
					$("#klientFormularz-{{$nazwa}}_{{$mid}} #wstecz").bind('click', function(){
						$(".klientKontener").slideUp("fast");
						$('#'+originalUpperFormID).slideDown("slow");
						return false;
					});
				{{ELSE}}
					$('#oknoModalne .modal-body').html(dane);
					$('#oknoModalne').modal('show');
					dopasujModala()
					setTimeout(function(){$('select#idParent').select2();}, 500);
					setTimeout(function(){$('select#type').select2();}, 501);
				{{END UNLESS}}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				$('#'+originalUpperFormID).slideDown("fast");
				alert(xhr.status);
				alert(thrownError);
				$('.mobile-loader').hide();
			}
		});
	}
	
	function editCustomer(id)
	{
		dodajAjax(id);
	}
	
$(document).ready(function(){
	$('.tip-top').tooltip();
	if(navigator.platform == 'iPad')
		$('#{{$nazwa}}-link-{{$mid}}').removeClass('tip-left');
		
	var s_{{$nazwa}}_{{$mid}} = ustawSelect2($("#{{$nazwa}}_{{$mid}}"));
		{{IF $selection}}
			{{IF $podglad}}
			$('#{{$nazwa}}-podglad-{{$mid}}').html(formatSelection({{$selection}}));
			{{END IF}}
			$("#s2id_{{$nazwa}}_{{$mid}} .select2-choice").html("<span id=\"select2-chosen-1\" class=\"select2-chosen\">" + formatSelection({{$selection}}) + "</span><abbr class=\"select2-search-choice-close\"></abbr><div><b></b></div>");
		{{END IF}}
		$("#s2id_{{$nazwa}}_{{$mid}}").parents("form").submit(function(){
			var w = $("#{{$nazwa}}_{{$mid}}").val();
			$("#{{$nazwa}}_{{$mid}}").remove();
			//$(this).prepend('<input type="hidden" style="display:none;" name="{{$nazwa}}_{{$mid}}" value="' + w + '"/>');
			$(this).prepend('<input type="hidden" style="display:none;" name="{{$nazwa}}" value="' + w + '"/>');
		});
	});
	
	function formatResult(cust) 
	{
		var markup = "<table class=''><tr>";
		switch (cust.type)
		{
			case 'private' :
				markup += "<td class=''><div class='name'>" + cust.name + ((cust.second_name != undefined && cust.second_name != '') ? ' ' + cust.second_name : '') + ' ' + cust.surname + ' (' + cust.postcode + ' ' + cust.city + ', ' + cust.address + ')</div></td>';
				break;
			case 'branch contact person' :
				markup += "<td class=''><div class='name'>" + cust.name + ((cust.second_name != undefined && cust.second_name != '') ? ' ' + cust.second_name : '') + ' ' + cust.surname + ' (' + cust.phone_mobile  + ((cust.email != undefined && cust.email != "") ? ', '+cust.email : '')+')' + ((cust.company_name != undefined && cust.company_name != "") ? ' ['+cust.company_name+'] ' : '') + '</div></td>';
				break;
			default :
				markup += "<td class=''><div class='name'>" + cust.company_name + ' (' + cust.postcode + ' ' + cust.city + ', ' + cust.address +')</div></td>';
				break;
		}
		
		markup += "</tr></table>";
		return markup;
	}
	
	function formatSelection(cust) {
		
		document.customer = cust;
		$("#{{$nazwa}}_{{$mid}}").val(cust.id);
		if ($("#same_address").is(":checked"))
		{
			$("#address").val(cust.address);
			$("#apartment").val(cust.apartament);
			$("#city").val(cust.city);
			$("#postcode").val(cust.postcode);
		}
		
		$("#address").attr('data-old-val', cust.address);
		$("#apartment").attr('data-old-val', cust.apartament);
		$("#city").attr('data-old-val',cust.city);
		$("#postcode").attr('data-old-val',cust.postcode);
		
		$('#{{$nazwa}}_{{$mid}}').trigger('change');
		switch (cust.type)
		{
			case 'private' :
				return cust.name + ((cust.second_name != undefined && cust.second_name != '') ? ' ' + cust.second_name : '') + ' ' + cust.surname + ' (' + cust.postcode + ' ' + cust.city + ', ' + cust.address + ')';
				break;
			case 'branch contact person' :
				return cust.name + ((cust.second_name != undefined && cust.second_name != '') ? ' ' + cust.second_name : '') + ' ' + cust.surname + ' (' + cust.phone_mobile + ((cust.email != undefined && cust.email != "") ? ', '+cust.email : '')+')'+ ((cust.company_name != undefined && cust.company_name != "") ? ' ['+cust.company_name+'] ' : '');
				break;
			default :
				return cust.company_name + ' (' + cust.postcode + ' ' + cust.city + ', ' + cust.address +')';
				break;
		}
	}
</script>

{{END}}

{{BEGIN zwykly}}
<span class="select_wrap select2">
	<select name="{{$nazwa}}" id="{{$nazwa}}_{{$mid}}" {{$atrybuty}}>
{{IF $wybierz}}<option value="">{{$wybierz}}</option>{{END}}
{{BEGIN wiele_poziomow}}
	<optgroup label="{{$etykieta_grupy}}">
	{{BEGIN wiersz}}
		<option value="{{$wartosc}}" {{IF $selected}}selected="selected"{{END}}>{{$etykieta}}</option>
	{{END}}
	</optgroup>
{{END}}

{{BEGIN wiersz}}
	<option value="{{$wartosc}}" {{IF $selected}}selected="selected"{{END}}>{{$etykieta}}</option>
{{END}}
	</select>
	<a href="javascript:void(0);" id="{{$nazwa}}-link-{{$mid}}" rel="#" class="btn {{IF $zablokowany}}disabled{{ELSE}}tip-left{{END}}" title="{{$etykieta_dodaj_klienta}}"><i class="icon icon-plus-sign">{{$etykieta_dodaj}}</i></a></span>
{{END}}

<script type="text/javascript">
	var odp = 0;
	var originalUpperFormID = '';
	
	var u = '{{$urlKlientDodajAjax}}';
	
	function formatSelection(cust) {
		
		$("#{{$nazwa}}_{{$mid}}").val(cust.id);
		if ($("#same_address").is(":checked"))
		{
			$("#address").val(cust.address);
			$("#apartment").val(cust.apartament);
			$("#city").val(cust.city);
			$("#postcode").val(cust.postcode);
		}
		
		$("#address").attr('data-old-val', cust.address);
		$("#apartment").attr('data-old-val', cust.apartament);
		$("#city").attr('data-old-val',cust.city);
		$("#postcode").attr('data-old-val',cust.postcode);
		
		$('#{{$nazwa}}_{{$mid}}').trigger('change');
		
		switch (cust.type)
		{
			case 'private' :
				return cust.name + ((cust.second_name != undefined && cust.second_name != '') ? ' ' + cust.second_name : '') + ' ' + cust.surname + ' (' + cust.postcode + ' ' + cust.city + ', ' + cust.address + ')';
				break;
			case 'branch contact person' :
				return cust.name + ((cust.second_name != undefined && cust.second_name != '') ? ' ' + cust.second_name : '') + ' ' + cust.surname + ' (' + cust.phone_mobile + ((cust.email != undefined && cust.email != "") ? ', '+cust.email : '')+')'+ ((cust.company_name != undefined && cust.company_name != "") ? ' ['+cust.company_name+'] ' : '');
				break;
			default :
				return cust.company_name + ' (' + cust.postcode + ' ' + cust.city + ', ' + cust.address +')';
				break;
		}
	}
	
	$(document).ready(function () {
		$('#{{$nazwa}}-link-{{$mid}}:not(.disabled)').live('click', function () {
			dodajAjax('', $(this));
		});
		
		function dodajAjax(id, przycisk)
		{
			{{UNLESS $dodaj_modal}}
			$('.mobile-loader').fadeIn("normal");
			if ($(".klientKontener").length > 0)
			{
				//$('#'+originalUpperFormID).slideUp("fast");
				$(".klientKontener").remove();
				//$(".klientKontener select").select2();
			}

			originalUpperFormID = $('#{{$nazwa}}_{{$mid}}').parents('form').attr('id');
			$('#'+originalUpperFormID).slideUp("fast");
			{{END UNLESS}}

			if(przycisk.attr('rel') != '#' && typeof przycisk.attr('rel') != 'undefined')
			{
				u = przycisk.attr('rel');

			}
			u += '&field={{$nazwa}}_{{$mid}}';

			$.ajax({
				url: u,
				type: 'POST',
				data: {id: id},
				dataType: 'html',
				async: true,
				success: function(dane) {
					{{UNLESS $dodaj_modal}}
						$('#'+originalUpperFormID).after(dane);
						$('.klientKontener').hide().slideDown("slow");
						$('.mobile-loader').fadeOut("fast");
						$('.klientKontener select').select2();
						$("#klientFormularz-{{$nazwa}}_{{$mid}} #wstecz").unbind('click');
						$("#klientFormularz-{{$nazwa}}_{{$mid}} #wstecz").bind('click', function(){
							$(".klientKontener").slideUp("fast");
							$('#'+originalUpperFormID).slideDown("slow");
							return false;
						});
					{{ELSE}}
						$('#oknoModalne .modal-body').html(dane);
						$('#oknoModalne').modal('show');
						dopasujModala()
						setTimeout(function(){$('select#idParent').select2();}, 500);
						setTimeout(function(){$('select#type').select2();}, 501);
					{{END UNLESS}}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					$('#'+originalUpperFormID).slideDown("fast");
					alert(xhr.status);
					alert(thrownError);
					$('.mobile-loader').hide();
				}
			});
		}
	
		$("#klientFormularz-{{$nazwa}}_{{$mid}}").live('submit', function(e) {
			$.ajax({
				url: u,
				type: $('#klientFormularz-{{$nazwa}}_{{$mid}}').attr('method'),
				data: $('#klientFormularz-{{$nazwa}}_{{$mid}}').serialize(),
				dataType: 'json',
				async: true,
				success: function(dane) {
					if (dane.kod == '1' )
					{
						$('#miejsceNaFormularz').html(dane.info);
						setTimeout(function(){$('select#idParent').select2();}, 500);
						setTimeout(function(){$('select#type').select2();}, 501);
						{{UNLESS $dodaj_modal}}
						$("#klientFormularz-{{$nazwa}}_{{$mid}} #wstecz").unbind('click');
						$("#klientFormularz-{{$nazwa}}_{{$mid}} #wstecz").bind('click', function(){
							$('.klientKontener').slideUp("fast");
							$('#'+originalUpperFormID).slideDown("slow");
							return false;
						});
						{{END UNLESS}}
					}
					if (dane.kod == '2')
					{
						if (typeof pobierzKlienta == 'function') 
						{
							pobierzKlienta(dane);
						}
						if (dane.id > 0)
						{
							{{UNLESS $dodaj_modal}}
							$('#'+originalUpperFormID).slideDown('slow');
							$('.klientKontener').remove();
							{{END UNLESS}}
							{{IF $selectAjax}}
								$("#s2id_{{$nazwa}}_{{$mid}} .select2-choice").html("<span id='select2-chosen-1' class='select2-chosen'>" + formatSelection(dane) + "</span><abbr class='select2-search-choice-close'></abbr>   <div><b></b></div>");
								$('#{{$nazwa}}-podglad-{{$mid}}').html(formatSelection(dane));
								$("#s2id_{{$nazwa}}_{{$mid}}").parents("form").submit(function(){
									var w = $("#{{$nazwa}}_{{$mid}}").val();
									$("#{{$nazwa}}_{{$mid}}").remove();
									console.log(w);
									//$(this).prepend('<input type="hidden" name="{{$nazwa}}_{{$mid}}" value="' + w + '"/>');
									$(this).prepend('<input type="hidden" name="{{$nazwa}}" value="' + w + '"/>');
								});
							{{ELSE}}
							var klientNazwa = formatSelection(dane);
							
							$('select#{{$nazwa}}_{{$mid}} option').removeAttr('selected');
							if (dane.type == 'developer' || dane.type == 'company')
							{
								$('select#{{$nazwa}}_{{$mid}}').prepend('<option selected="selected" value="'+dane.id+'">'+klientNazwa+')</option>');
								//pobierzListeLiderow();
							}
							else if (dane.type == 'branch contact person')
							{
								$('select#{{$nazwa}}_{{$mid}}').prepend('<option selected="selected" value="'+dane.id+'">'+klientNazwa+')</option>');
							}
							else
							{
								$('select#{{$nazwa}}_{{$mid}}').prepend('<option selected="selected" value="'+dane.id+'">'+klientNazwa+')</option>');
							}
							$('select#{{$nazwa}}_{{$mid}}').select2();
							{{END}}

						}
						else
						{
							alert('Error: Customer not added');
						}
						{{IF $dodaj_modal}}
						$('#oknoModalne').attr('aria-hidden', 'true');
						$('#oknoModalne').modal('hide');
						{{END}}
						$('#{{$nazwa}}_{{$mid}}').trigger('change');
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
					}
				}
			)
			e.preventDefault();
			return false;
		});
		
	});
	</script>