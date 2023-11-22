{{BEGIN gridFakturaNazwa}}
<div class="fakturaNazwa">{{$nazwa}}</div>
<div id="i-{{$id}}" class="{{UNLESS $wyslana}}editable{{END UNLESS}} fakturanaglowek fL">{{$naglowek}}</div>
{{END gridFakturaNazwa}}

{{BEGIN index}}
<script src="/_system/js/bootstrap-editable.min.js"></script>
<script src="/_system/js/select2.js"></script>

	{{IF $edytuj_naglowek}}
	
	{{END IF}}
<script type="text/javascript">
	function filtruj(search)
	{
		var wyslana = $("input[name='wyslana']:checked").val();
		var typ = $("input[name='grupa']:checked").val();
		var platnosc = $("input[name='platnosc']:checked").val();
		var kategoria = $("input[name='kategoria']:checked").val();
		
		
		if(search)
		{
			$('tr').show();
		}
		
		if(wyslana == 'tak')
		{
			$('tr[attr-wyslana=0]').hide();
		}
		else if(wyslana == 'nie')
		{
			$('tr[attr-wyslana=1]').hide();
		}
		
		if(typ == 'get_project')
		{
			$('tr[attr-typ="Private"]').hide();
		}
		else if(typ == 'other_orders')
		{
			$('tr[attr-typ="get"]').hide();
		}
		
		if(platnosc == 'oplacone')
		{
			$('tr[attr-platnosc="po_terminie"]').hide();
			$('tr[attr-platnosc="nie"]').hide();
		}
		else if(platnosc == 'nie_oplacone')
		{
			$('tr[attr-platnosc="tak"]').hide();
		}
		else if(platnosc == 'przekroczone')
		{
			$('tr[attr-platnosc="tak"]').hide();
			$('tr[attr-platnosc="nie"]').hide();
		}
		
		if(kategoria == 'installation')
		{
			$('tr[attr-graving="1"][attr-installation="0"]').hide();
		}
		else if(kategoria == 'graving')
		{
			$('tr[attr-graving="0"][attr-installation="1"]').hide();
		}
		
		$('tr.wiersz[attr-data=0]').hide();
		
		setTimeout(function(){
			$('#sumaNetto').text(liczSumaFilter('netto'));
			$('#sumaBrutto').text(liczSumaFilter('brutto'));
			$('#sumaVat').text(liczSumaFilter('vat'));
			$('#sumaGraving').text(liczSumaFilter('suma_graving'));
			$('#sumaInstalacje').text(liczSumaFilter('suma_instalacja'));
			$('#sumaZaplacono').text(liczSumaInputFilter('faktura_zaplacono'));
			liczPozostaloDoZaplaty();
		},1000);
		
	}
	
	Date.prototype.addDays = function(days) {
		var date = new Date(this.valueOf());
		date.setDate(date.getDate() + days);
		return date;
	}
	
	var listaDat = [];
	function aktualizujListaData(start, stop)
	{
		var start = new Date(start);
		var stop = new Date(stop);
		
		if(start <= stop)
		{
			listaDat = [$.datepicker.formatDate('dd-mm-yy', start).toString()];
			while(stop > start)
			{
				start = start.addDays(1);
				listaDat.push($.datepicker.formatDate('dd-mm-yy', start).toString());
			}
		}
	}
	
	function filtrujListaDat()
	{
		$('.data_zaplaty').each(function(){
			
			if(listaDat.indexOf($(this).text()) >= 0)
			{
				$(this).parents('tr').attr('attr-data', 1);
			}
			else
			{
				$(this).parents('tr').attr('attr-data', 0);
			}
		});
	}
	
	function liczSumaFilter(klasa)
	{
			var suma = 0;
			$('.'+klasa+':visible').each(function()
				{
					var wartosc = parseFloat($(this).text().replace(/\ /g, ''));
					if(wartosc != 0 && wartosc !== '')
					{
						suma = parseFloat(suma) + wartosc;
					}
				}
			);

			return number_format(suma, 0, ',', ' ');
	}
	
	function liczSumaInputFilter(klasa)
	{
		var suma = 0;
		$('.'+klasa+':visible').each(function()
				{
					var wartosc = parseFloat($(this).val().replace(/\ /g, ''));
					if(wartosc != 0 && wartosc !== '')
					{
						suma = parseFloat(suma) + wartosc;
					}
				}
			);
		
		return number_format(suma, 2, '.', ' ');
	}
	
	$(document).ready(function(){
		
		var dataStart = '{{$dataOd}}';
		var dataStop = '{{$dataDo}}';
		
		aktualizujListaData(dataStart, dataStop);
		filtrujListaDat();
		
		$('#dataOd').on('change', function(){
				var start = $(this).val();
				var stop = $('input[name=dataDo]').val();
				aktualizujListaData(start, stop);
				filtrujListaDat();
				if($('#filter').val().length){ $('#filter').keyup(); }else{ filtruj(1); }
		});
		$('#dataDo').on('change', function(){
				var stop = $(this).val();
				var start = $('input[name=dataOd]').val();
				aktualizujListaData(start, stop);
				filtrujListaDat();
				if($('#filter').val().length){ $('#filter').keyup(); }else{ filtruj(1); }
		});
		
		$("input[name='kategoria']").on('change', function(){ if($('#filter').val().length){ $('#filter').keyup(); }else{ filtruj(1); } });
		$("input[name='wyslana']").on('change', function(){ if($('#filter').val().length){ $('#filter').keyup(); }else{ filtruj(1); } });
		$("input[name='grupa']").on('change', function(){ 	if($('#filter').val().length){ $('#filter').keyup(); }else{ filtruj(1); }	});
		$("input[name='platnosc']").on('change', function(){ 	if($('#filter').val().length){ $('#filter').keyup(); }else{ filtruj(1); }	});
		$('#fraza').bind('paste', function()
		{
			$(this).keyup();
		});
		$("#filter").keyup(function(){
				var filter = $.trim($(this).val()), count = 0;
				/*
				if( ! $('#czyscWyniki').is('is:visible') && filter.length > 0)
				{
					$('#czyscWyniki').show();
				}
				if(filter.length == 0)
				{
					$('#czyscWyniki').hide();
				}
				*/
				$('.table td:first-child').each(function(){
					
					if($(this).text().search(new RegExp(filter, "i")) < 0)
					{
						$(this).parents('tr').fadeOut();
					}
					else
					{
						$(this).parents('tr').show();
						count++;
					}
				});
				filtruj(0);
				/*
				var numberItems = count;
				
				$("#filter-count").text("{{$znaleziono_zamowien}}"+count);
				 */
		   });
		
		if($('th.fraza').length){ $('th.fraza').hide(); $('td:first-child').hide(); }
		
		{{IF $edytuj_naglowek}}
		$('.editable').editable({
			emptytext: '',
			mode: 'inline',
			pk: function(){
				return $(this).attr('id').replace('i-', '');
			},
			url: '{{$url_zmien_naglowek}}'
		});
			
			
		{{END IF}}
		
		$("select#archiwum").select2();
		$('.netto').parents('td').attr('class', 'faktura_netto price');
		$('.brutto').parents('td').attr('class', 'faktura_brutto price');
		$('.vat').parents('td').attr('class', 'faktura_vat price');
		$('.suma_graving').parents('td').attr('class', 'faktura_graving price');
		$('.suma_instalacja').parents('td').attr('class', 'faktura_instalacje price');
		$('.zaplacono_brutto').parents('td').attr('class', 'zaplacono_brutto price');
		$('.faktura_ilosc').parent('span').addClass('qty').attr('style', 'margin-right:0px;');
		$(".spn").spinner({min: 0});
		
		$('#emailForm #wstecz, #kreditnotaForm #wstecz').live('click', function(){
				$('#oknoModalne').modal('hide');
			}
		);
		
		$('.data_wystawienia').live('change' , function(){
			var dataWystawienia = $(this).val();
			var idWiersza = $(this).attr('id').replace('dataWystawienia_', '');
			var dni = $('#dniPlatnosci_'+idWiersza).val();
			liczDataPlatnosci(dataWystawienia, dni, idWiersza);
		});
		
		$('.data_platnosci').live( 'change' ,function(){
			var dataPlatnosci = $(this).val();
			var idWiersza = $(this).attr('id').replace('dataPlatnosci_', '');
			var dataWystawienia = $('#dataWystawienia_'+idWiersza).val();
			var dataPlatnosci = $('#dataPlatnosci_'+idWiersza).val();
			// poszukac innego rozwiazania
			var dataPlatnosciTab = dataPlatnosci.split('-');
			var dataWystawieniaTab = dataWystawienia.split('-');
			var dataPlatnosciDoPorownania = new Date(dataPlatnosciTab[2], dataPlatnosciTab[1], dataPlatnosciTab[0]);
			var dataWystawieniaDoPorowniania = new Date(dataWystawieniaTab[2], dataWystawieniaTab[1], dataWystawieniaTab[0]);
			
			if (dataWystawieniaDoPorowniania < dataPlatnosciDoPorownania)
			{
				liczDniPlatnosci(dataWystawienia, dataPlatnosci, idWiersza);
				$('#dataPlatnosci_'+idWiersza).attr('class', 'faktura_data data_platnosci');
				$('#dataPlatnosci_'+idWiersza).siblings('.help-inline').remove();
				$('#wiersz_'+idWiersza+' td').last().children('.btn-group').children('a[klucz="wystawFaktura"]').show(500);
			}
			else
			{
				$('#dataPlatnosci_'+idWiersza).attr('class', 'error_faktura_input faktura_data data_platnosci');
				$('#dataPlatnosci_'+idWiersza).siblings('.help-inline').remove();
				$('#dataPlatnosci_'+idWiersza).parent('.input-append').append('<span class="help-inline" style="float: left;" for="">{{$info_blad_daty}}</span>');
				$('#wiersz_'+idWiersza+' td').last().children('.btn-group').children('a[klucz="wystawFaktura"]').hide(500);
			}
			
		});
		
		$('.faktura_ilosc').live('keyup', function(){
			var dni = $(this).val();
			var idWiersza = $(this).attr('id').replace('dniPlatnosci_', '');
			var dataWystawienia = $('#dataWystawienia_'+idWiersza).val();
			liczDataPlatnosci(dataWystawienia, dni, idWiersza);
		});
		
		$('.parzysty .qty .ui-spinner-button, .nieparzysty .qty .ui-spinner-button').live('click', function(){
			var dni = $(this).siblings('.faktura_ilosc').val();
			var idWiersza = $(this).siblings('.faktura_ilosc').attr('id').replace('dniPlatnosci_', '');
			var dataWystawienia = $('#dataWystawienia_'+idWiersza).val();
			liczDataPlatnosci(dataWystawienia, dni, idWiersza);
		});
		
		$(".faktura_zaplacono").live('keyup', function(){
			var kwota = $(this).val().replace(',', '.');
			var idWiersza = $(this).attr('id').replace('zaplacono_', '');
			zaplaconoKwotaRecznie(kwota, idWiersza);
		});
		$("select#archiwum").live('change', function(){
			window.location.href = "{{$linkArchiwum}}&rok="+$(this).val();
		});
	});
	
	function liczDniPlatnosci(dataWystawienia, dataPlatnosci, idWiersza)
	{
		$.ajax({
				url: "{{$linkAjaxLiczDniPlatnosci}}",
				type: 'POST',
				dataType: 'json',
				data: "dataWystawienia="+dataWystawienia+"&dataPlatnosci="+dataPlatnosci+"&idFaktury="+idWiersza,
				async: true,
				success: function(dane) {
					if(dane['kod'] == 1)
					{
						$('#dniPlatnosci_'+idWiersza).val(dane['dni']);
						$('#dataPlatnosci_'+idWiersza).attr('class', 'faktura_data data_platnosci');
						$('#dataPlatnosci_'+idWiersza).siblings('.help-inline').remove();
						$('#wiersz_'+idWiersza+' td').last().children('.btn-group').children('a[klucz="wystawFaktura"]').show(500);
					}
					else if(dane['kod'] == 2)
					{
						$('#dataPlatnosci_'+idWiersza).attr('class', 'error_faktura_input faktura_data data_platnosci');
						$('#dataPlatnosci_'+idWiersza).siblings('.help-inline').remove();
						$('#dataPlatnosci_'+idWiersza).parent('.input-append').append('<span class="help-inline" style="float: left;" for="">{{$info_blad_daty}}</span>');
						$('#wiersz_'+idWiersza+' td').last().children('.btn-group').children('a[klucz="wystawFaktura"]').hide(500);
					}
					else if(dane['kod'] == 3)
					{
						alertModal("{{$error_licz_dni_naglowek}}", "{{$error_licz_dni_tresc}}");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
		})
		return false;
	}
	
	function liczDataPlatnosci(dataWystawienia, dni, idWiersza)
	{
		 $.ajax({
				url: "{{$linkAjaxLiczDatePlatnosci}}",
				type: 'POST',
				dataType: 'json',
				data: "dataWystawienia="+dataWystawienia+"&dni="+dni+"&idFaktury="+idWiersza,
				async: true,
				success: function(dane) {
					if(dane['kod'] == 1)
					{
						$('#dataPlatnosci_'+idWiersza).val(dane['dataPlatnosci']);
						$('#dataPlatnosci_'+idWiersza).attr('class', 'faktura_data data_platnosci');
						$('#dataPlatnosci_'+idWiersza).siblings('.help-inline').remove();
						$('#wiersz_'+idWiersza+' td').last().children('.btn-group').children('a[klucz="wystawFaktura"]').show(500);
					}
					else if(dane['kod'] == 2)
					{
						alertModal("{{$error_licz_data_platnosci_naglowek}}", "{{$error_licz_data_platnosci_tresc}}");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
		})
		return false;
	}
	
	function zaplaconoKwotaRecznie(zaplacono, idWiersza)
	{
		var dataOd = $.urlParam('dateFrom');
		var dataDo = $.urlParam('dateTo');
		
		$.ajax({
				url: "{{$linkAjaxZaplaconoKwotaRecznie}}",
				type: 'POST',
				dataType: 'json',
				data: "zaplacono="+zaplacono+"&idFaktury="+idWiersza+"&dataOd="+dataOd+"&dataDo="+dataDo,
				async: true,
				success: function(dane) {
					if(dane['kod'] == 1)
					{
						if(dane['oplaconaCalosc'])
						{
							$('#wiersz_'+dane['idFaktury']).attr('class', 'faktura_zaplacona');
							$('#wiersz_'+dane['idFaktury']+' td:last a[klucz="fakturaZaplacona"]').hide(500);
							$('#wiersz_'+dane['idFaktury']+' td:last a[klucz="dodajUpomnienie"]').hide(500);
							$('#wiersz_'+dane['idFaktury']+' td:last a[klucz="dodajKreditnota"]').hide(500);
						}
						else
						{
							$('#wiersz_'+dane['idFaktury']).removeClass('faktura_zaplacona');
							$('#wiersz_'+dane['idFaktury']+' td:last a[klucz="fakturaZaplacona"]').show(500);
							$('#wiersz_'+dane['idFaktury']+' td:last a[klucz="dodajUpomnienie"]').show(500);
							$('#wiersz_'+dane['idFaktury']+' td:last a[klucz="dodajKreditnota"]').show(500);
						}
						$('#sumaZaplacono').text(number_format(dane.kwota_zaplacona_brutto, 2, '.', ' '));
						$('#pozostaloDoZaplaty').text(number_format(dane.pozostalo_do_zaplaty, 2, '.', ' '));
					}
					else if(dane['kod'] == 2)
					{
						alertModal("{{$error_kwota_recznie_naglowek}}", "{{$error_kwota_recznie_tresc}}");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
		})
		return false;
	}
	
	function liczPozostaloDoZaplaty()
	{
		
		var sumaBrutto = parseFloat($('#sumaBrutto').text().replace(/\ /g, ''));
		var sumaZaplacono = parseFloat($('#sumaZaplacono').text().replace(/\ /g, ''));
		var pozostaloDoZaplaty = sumaBrutto - Math.abs(sumaZaplacono);

		$('#pozostaloDoZaplaty').text(number_format(pozostaloDoZaplaty, 2, '.', ' '));
	}
	
	function wrocDoPrzygotujFaktura(obiekt)
	{
		if (!confirm("Are you sure you want to move this invoice to Create invoces ?"))
				return false;
		var dataOd = $.urlParam('dateFrom');
		var dataDo = $.urlParam('dateTo');
		
		$.ajax({
				url: obiekt,
				type: 'POST',
				dataType: 'json',
				data: "&dataOd="+dataOd+"&dataDo="+dataDo,
				async: true,
				success: function(dane) {
					if(dane['kod'] == 1)
					{
						$('#wiersz_'+dane['idFaktury']).remove();
						$('#sumaNetto').text(liczSuma('netto'));
						$('#sumaBrutto').text(liczSuma('brutto'));
						$('#sumaVat').text(liczSuma('vat'));
						$('#sumaGraving').text(liczSuma('suma_graving'));
						$('#sumaInstalacje').text(liczSuma('suma_instalacja'));
					}
					else if(dane['kod'] == 2)
					{
						alertModal("{{$error_wroc_fakture_naglowek}}", "{{$error_wroc_fakture_tresc}}");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
		})
		return false;
		
	}
	
	function fakturaZaplacona(obiekt)
	{
		var dataOd = $.urlParam('dateFrom');
		var dataDo = $.urlParam('dateTo');
		
		$.ajax({
				url: obiekt.href,
				type: 'POST',
				dataType: 'json',
				data: "&dataOd="+dataOd+"&dataDo="+dataDo,
				async: true,
				success: function(dane) {
					if(dane['kod'] == 1)
					{
						$('#wiersz_'+dane['idFaktury']+' td:last a[klucz="wrocDoPrzygotujFaktura"]').hide(500);
						$('#zaplacono_'+dane['idFaktury']).val(dane['kwotaZaplacona']).attr('disabled', 'disabled');
						$('#wiersz_'+dane['idFaktury']).attr('class', 'faktura_zaplacona');
						$('.wiersz_'+dane['idFaktury']).attr('class', 'faktura_zaplacona');
						$('#wiersz_'+dane['idFaktury']+' td:last a[klucz="fakturaZaplacona"]').hide(500);
						$('#wiersz_'+dane['idFaktury']+' td:last a[klucz="dodajUpomnienie"]').hide(500);
						$('#wiersz_'+dane['idFaktury']+' td:last a[klucz="dodajKreditnota"]').hide(500);

						$('#sumaZaplacono').text(number_format(dane.kwota_zaplacona_brutto, 2, '.', ' '));
						$('#pozostaloDoZaplaty').text(number_format(dane.pozostalo_do_zaplaty, 2, '.', ' '));
					}
					else if(dane['kod'] == 2)
					{
						alertModal("{{$error_zaplac_fakture_naglowek}}", "{{$error_zaplac_fakture_tresc}}");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
		})
		return false;
	}
	var wyslijFakturaPrzycisk = '\
			<a class="btn tip-top btn-success" style="display:none;" onclick="wyslijFaktura(this); return false;" klucz="wyslijFaktura" target="_self" href="{LINK_WYSLIJ_FAKTURA}" data-original-title="Send an invoice">\n\
				<i class="icon-envelope-alt"></i>\n\
			</a>\n';
	function wystawFakture(obiekt)
	{
		$('.mobile-loader').fadeIn("normal");
		$.ajax({
				url: obiekt.href,
				type: 'POST',
				dataType: 'json',
				async: true,
				success: function(dane) {
					if(dane['kod'] == 1)
					{
						if(dane['rodzaj'] == 'faktura')
						{
							$('#wiersz_'+dane['id']).remove();
							$('#sumaNetto').text(liczSuma('netto'));
							$('#sumaBrutto').text(liczSuma('brutto'));
							$('#sumaVat').text(liczSuma('vat'));
							$('#sumaGraving').text(liczSuma('suma_graving'));
							$('#sumaInstalacje').text(liczSuma('suma_instalacja'));
						}
						else
						{
							$('#wiersz_'+dane['id']+' td:last a[klucz="wystawFaktura"]').hide(500);
							$('#wiersz_'+dane['id']+' td:last a[klucz="usun"]').hide(500);
							var znajdz = ["{LINK_WYSLIJ_FAKTURA}"];
							var zamien = [dane['linkWyslij']];
							var przycisk = wyslijFakturaPrzycisk.replaceArray(znajdz, zamien);
							$('#wiersz_'+dane['id']+' td:last a[klucz="fakturaPodglad"]').after(przycisk);
							$('#wiersz_'+dane['id']+' td:last a[klucz="wyslijFaktura"]').css('display', 'inline');
							$('#dataWystawienia_'+dane['id']).attr('disabled', 'disabled');
							$('#dataPlatnosci_'+dane['id']).attr('disabled', 'disabled');
							$('#dniPlatnosci_'+dane['id']).attr('disabled', 'disabled');
							$('#dniPlatnosci_'+dane['id']).siblings('a').hide(500);
						}
					}
					if(dane['kod'] == 2)
					{
						//alertModal('Blad', 'Nie udalo sie wystawic faktury');
						alertModal("{{$error_wystaw_fakture_naglowek}}", "{{$error_wystaw_fakture_tresc}}");
					}
					$('.mobile-loader').fadeOut("normal");
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
					$('.mobile-loader').fadeOut("normal");
				}
		})
		return false;
	}
	
	function liczSuma(klasa)
	{
		var suma = 0;
		$('.'+klasa).each(function()
				{
					var wartosc = parseFloat($(this).text().replace(/\ /g, ''));
					if(wartosc > 0)
					{
						suma = parseFloat(suma) + wartosc;
					}
				}
			);
		
		return number_format(suma, 0, ',', ' ');
	}
	
	function liczSumaInput(klasa)
	{
		var suma = 0;
		$('.'+klasa).each(function()
				{
					var wartosc = parseFloat($(this).val().replace(/\ /g, ''));
					if(wartosc != 0 && wartosc !== '')
					{
						suma = parseFloat(suma) + wartosc;
					}
				}
			);
		
		return number_format(suma, 2, '.', ' ');
	}
	
	function wyslijFaktura(url)
	{
		$('.mobile-loader').fadeIn("normal");
		$.ajax({
			url: url.href,
			type: 'POST',
			dataType: 'json',
			async: true,
			success: function(dane) {

				if(dane.kod == '1' )
				{
					$('#wiersz_'+dane['idFaktury']+' td:last a[klucz="wyslijFaktura"]').hide(500);
					$('#wiersz_'+dane['idFaktury']+' td:last a[klucz="wrocDoPrzygotujFaktura"]').hide(500);
				}
				if(dane.kod == '2')
				{
					modalAjax(dane.wyslijFakturaWprowadzEmail);
				}
				if(dane.kod == '3')
				{
					alertModal('{{$error_wyslij_fakture_naglowek}}', '{{$error_wyslij_fakture_tresc}}');
				}
				$('.mobile-loader').fadeOut("normal");
			},
			error: function (xhr, ajaxOptions, thrownError) {
				//alert(xhr.status);
				//alert(thrownError);
				$('.mobile-loader').fadeOut("normal"); 
			}
		});
	}
	
	$('#emailForm').live('submit', function(){
		
			$.ajax({
				url: $('#emailForm').attr('action'),
				type: $('#emailForm').attr('method'),
				data: $('#emailForm').serialize(),
				dataType: 'json',
				async: true,
				success: function(dane) {
					if(dane.kod == '1' )
					{
						$('#oknoModalne').attr('aria-hidden', 'true');
						$('#oknoModalne').modal('hide');
						$('#wiersz_'+dane['idFaktury']+' td:last a[klucz="wyslijFaktura"]').hide(500);
					}
					if(dane.kod == '2' )
					{
						$('#oknoModalne .modal-body').html(dane.html);
					}
					if(dane.kod == '3')
					{
						
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
					}
				}
			)
			return false;
		});
	
	function pokazZrodlo(link)
	{
		if (link.indexOf('editPayout') > -1)
				{	
			modalAjax(link);
				}
		if (link.indexOf('previewOrder') > -1)
				{
			modalAjax(link);
				}
		if (link.indexOf('previewAttachments') > -1)
		{
			modalIFrame(link);
			return false;
			}
	}
	
	 var wierszPurring = '<tr class="wiersz nieparzysty dziecko wiersz_{ID_FAKTURA}" id="wiersz_{ID_PURRING}" >\n\
		<td class="nieparzysty" valign="middle"><span>{DATA_WYSTAWIENIA}</span></td>\n\
		<td class="nieparzysty" valign="middle"><span class="qty">{DNI_PLATNOSCI}</span></td>\n\
		<td class="nieparzysty" valign="middle"><span>{DATA_PLATNOSCI}</span></td>\n\
		<td class="nieparzysty" valign="middle"><span>{NUMER_FAKTURA}</span></td>\n\
		<td class="nieparzysty" valign="middle"><span>{ODBIORCA}</span></td>\n\
		<td class="nieparzysty" valign="middle"><span>{NAZWA_FAKTURY}</span></td>\n\
		<td class="nieparzysty" valign="middle"><span><span class="">-</span></span></td>\n\\n\
		<td class="nieparzysty" valign="middle"><span><span class="">-</span></span></td>\n\\n\
		<td class="nieparzysty" valign="middle"><span><span class="">{KWOTA_NETTO}</span></span></td>\n\\n\
		<td class="nieparzysty" valign="middle"><span><span class="">{KWOTA_VAT}</span></span></td>\n\\n\
		<td class="nieparzysty" valign="middle"><span><span class="">{KWOTA_BRUTTO}</span></span></td>\n\\n\
		<td class="nieparzysty" valign="middle"><span><span class="zaplacono_brutto">-</span></span></td>\n\\n\
		<td class="nieparzysty przyciski" valign="middle">\n\
			<a class="btn tip-top btn-success" onclick="wystawFakture(this); return false;" klucz="wystawFaktura" target="_self" href="{LINK_WYSTAW_FAKTURE}" data-original-title="Create invoice">\n\
			<i class="icon-paste"></i>\n\
			</a>\n\
			<a class="btn tip-top" klucz="fakturaPodglad" target="_self" href="javascript: modalIFrame(\'{LINK_PODGLAD_FAKTURA}\');" data-original-title="Preview">\n\
			<i class="icon-search"></i>\n\
			</a>\n\
			<a class="btn tip-top " onclick="usunFaktura(this); return false;" klucz="usun" target="_self" href="{LINK_USUN_FAKTURA}" data-original-title="Delete">\n\
				<i class="icon-remove"></i>\n\
			</a>\n\
		</td>\n\
	</tr>';
	
	function fakturaUpomnienie(obiekt)
	{
		$.ajax({
				url: obiekt.href,
				type: 'POST',
				dataType: 'json',
				async: true,
				success: function(dane) {
					if(dane['kod'] == 1){
						var znajdz = ['{ID_FAKTURA}', '{ID_PURRING}', '{DATA_WYSTAWIENIA}', '{DNI_PLATNOSCI}', '{DATA_PLATNOSCI}', '{NUMER_FAKTURA}', '{ODBIORCA}', '{NAZWA_FAKTURY}', '{KWOTA_NETTO}', '{KWOTA_VAT}', '{KWOTA_BRUTTO}', '{LINK_WYSTAW_FAKTURE}', '{LINK_PODGLAD_FAKTURA}', '{LINK_USUN_FAKTURA}', '{LINK_WYSLIJ_FAKTURA}'];
						var zamien = [dane['idFaktury'], dane['idPurring'], dane['dataWystawienia'], dane['iloscDniNaPlatnosc'], dane['dataZaplaty'], dane['numerFaktura'],dane['odbiorca'], dane['nazwaFaktury'], dane['sumaNetto'], dane['sumaTax'], dane['kwotaDoZaplatyBrutto'], dane['linkWystawFakture'], dane['linkPodgladFaktura'], dane['linkUsunFaktura'], dane['linkWyslijFakture']];
						var zamienionyWiersz = wierszPurring.replaceArray(znajdz, zamien);
						
						$('#wiersz_'+dane['idFaktury']).after(zamienionyWiersz).animate('opacity:1');
						$('#wiersz_'+dane['idFaktury']+' td:last a[klucz="wrocDoPrzygotujFaktura"]').hide(500);
						
						$('#dniPlatnosci_'+dane['idPurring']).spinner({min: 0});
						if(dane['blokuj_dodaj_upomnienie'])
						{
							$('#wiersz_'+dane['idFaktury']+' td:last a[klucz="dodajUpomnienie"]').hide(500);
							
						}
					}
					else if(dane['kod'] == 2){
						
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
		})
		return false;
	}
	
	function usunFaktura(url)
	{
		if (!confirm("Are you sure you want to remove this factura ?"))
				return false;
		
		var dataOd = $.urlParam('dateFrom');
		var dataDo = $.urlParam('dateTo');
		var wykonaj = $.urlParam('do');
		var nrStrony = $.urlParam('nrStrony');
		var naStronie = $.urlParam('naStronie');
		var rok = $.urlParam('rok');
		
		$.ajax({
			url: url,
			type: 'POST',
			dataType: 'json',
			data: "&dataOd="+dataOd+"&dataDo="+dataDo+"&do="+wykonaj+"&naStronie="+naStronie+"&nrStrony="+nrStrony+"&rok="+rok,
			async: true,
			success: function(dane) {
				if(dane.kod == '1' )
				{
					//$('#wiersz_'+dane.idFaktura).remove();
					$('#tabela_faktury').html(dane.grid);
					$('#sumaZaplacono').text(number_format(dane.kwota_zaplacona_brutto, 2, '.', ' '));
					$('#pozostaloDoZaplaty').text(number_format(dane.pozostalo_do_zaplaty, 2, '.', ' '));
					$('#sumaInstalacje').text(number_format(dane.kwota_installation, 2, '.', ' '));
					$('#sumaGraving').text(number_format(dane.kwota_graving, 2, '.', ' '));
					$('#sumaNetto').text(number_format(dane.kwota_do_zaplaty_netto, 2, '.', ' '));
					$('#sumaBrutto').text(number_format(dane.kwota_do_zaplaty_brutto, 2, '.', ' '));
					$('#sumaVat').text(number_format(dane.kwota_vat, 2, '.', ' '));
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}
		});
	}
	
	function fakturaKreditnota(url)
	{
		$.ajax({
				url: url,
				type: 'POST',
				dataType: 'json',
				async: true,
				success: function(dane) {

					$('#wiersz_'+dane['idFaktury']+' td:last a[klucz="wrocDoPrzygotujFaktura"]').hide(500);
					$('#oknoModalne .modal-body').html(dane.html);
					//$('#oknoModalne .modal-header').html(dane.naglowek);
					$('#oknoModalne').modal('show');
					$('#dniPlatnosci').insertAfter("<span class='qty'>");
					$('#dniPlatnosci').spinner({min: 0});
					dopasujModala();
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
			});
	}
	
	function odswierzFaktura(url)
	{
			var rot = 0;
			$.ajax({
			url: url,
			type: 'POST',
			dataType: 'json',
			async: true,
			success: function(dane) {
				if(dane.kod == '1' )
				{
					if (rot===0)
						rot = 360;
					else
						rot = 0;
					
					$('#wiersz_'+dane['idFaktury']+' td:last a[klucz="odswierzFaktura"] .icon-refresh').stop().animate({rotation: rot}, {
						duration: 350,
						step: function(now, fx) {
							$(this).css({"transform": "rotate("+ now +"deg)"});
						}
					});
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}
		});
	}
	
	$('#kreditnotaForm').live('submit', function(){
		
			var dataOd = $.urlParam('dateFrom');
			var dataDo = $.urlParam('dateTo');
			var wykonaj = $.urlParam('do');
			var nrStrony = $.urlParam('nrStrony');
			var naStronie = $.urlParam('naStronie');
			var rok = $.urlParam('rok');
			
			$.ajax({
				url: $('#kreditnotaForm').attr('action'),
				type: $('#kreditnotaForm').attr('method'),
				data: $('#kreditnotaForm').serialize()+"&dataOd="+dataOd+"&dataDo="+dataDo+"&do="+wykonaj+"&naStronie="+naStronie+"&nrStrony="+nrStrony+"&rok="+rok,
				dataType: 'json',
				async: true,
				success: function(dane) {
					 
					if(dane.kod == '1' )
					{
						$('#oknoModalne').attr('aria-hidden', 'true');
						$('#oknoModalne').modal('hide');
						$('#tabela_faktury').html(dane.grid);
						$('#sumaZaplacono').text(number_format(dane.kwota_zaplacona_brutto, 2, '.', ' '));
						$('#pozostaloDoZaplaty').text(number_format(dane.pozostalo_do_zaplaty, 2, '.', ' '));

						$('#sumaInstalacje').text(number_format(dane.kwota_installation, 2, '.', ' '));
						$('#sumaGraving').text(number_format(dane.kwota_graving, 2, '.', ' '));
						$('#sumaNetto').text(number_format(dane.kwota_do_zaplaty_netto, 2, '.', ' '));
						$('#sumaBrutto').text(number_format(dane.kwota_do_zaplaty_brutto, 2, '.', ' '));
						$('#sumaVat').text(number_format(dane.kwota_vat, 2, '.', ' '));
					}
					if(dane.kod == '2' )
					{
						console.log('blad');
					}
					 
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
					}
				}
			)
			return false;
		});
	
	$('#dataWystawienia').live('change' , function(){
			var dataWystawienia = $(this).val();
			var dni = $('#dniPlatnosci').val();
			var dataWystawieniaTab = dataWystawienia.split('-');
			var dataWystawieniaNowa = new Date(dataWystawieniaTab[2], dataWystawieniaTab[1]-1, dataWystawieniaTab[0]);
			var dataZaplaty = new Date(dataWystawieniaNowa.getTime() + (parseInt(dni)*24*60*60*1000));
			$('#dataZaplaty').val($.datepicker.formatDate('dd-mm-yy', new Date(dataZaplaty)));
	});
	
	$('.controls .qty .ui-spinner-button').live('click', function(){
		var dataWystawienia = $('#dataWystawienia').val();
		var dni = $(this).siblings('#dniPlatnosci').val();
		var dataWystawieniaTab = dataWystawienia.split('-');
		var dataWystawieniaNowa = new Date(dataWystawieniaTab[2], dataWystawieniaTab[1]-1, dataWystawieniaTab[0]);
		var dataZaplaty = new Date(dataWystawieniaNowa.getTime() + (parseInt(dni)*24*60*60*1000));
		$('#dataZaplaty').val($.datepicker.formatDate('dd-mm-yy', new Date(dataZaplaty)));
	});
	
	$('#dataZaplaty').live('change' , function(){
			
			var dataZaplaty = $(this).val();
			var dataZaplatyTab = dataZaplaty.split('-');
			var dataZaplatyNowa = new Date(dataZaplatyTab[2], dataZaplatyTab[1]-1, dataZaplatyTab[0]);
			
			var dataWystawienia = $('#dataWystawienia').val();
			var dataWystawieniaTab = dataWystawienia.split('-');
			var dataWystawieniaNowa = new Date(dataWystawieniaTab[2], dataWystawieniaTab[1]-1, dataWystawieniaTab[0]);
			
			var dni = $('#dniPlatnosci').val((dataZaplatyNowa.getTime() - dataWystawieniaNowa.getTime())/(1000*60*60*24));
	});
	 
</script>
<div id="kontenerKomunikaty"></div>
{{$formularzWyszukaj}}
<div class="widget-box">
<div class="widget-title">
	<ul class="nav nav-tabs">
      {{BEGIN zakladka}}
      <li class="{{IF $active}}active{{END}}">
			<a class="{{IF $active}}active{{END}}" name="{{$etykieta}}" href="{{$url}}">{{$etykieta}}</a>
		</li>
      {{END}}
	</ul>
	<div class="wysokosc"></div>
</div>
<div style="clear:both;"></div>
{{BEGIN wyszukiwarka}}
<div class="widget-content">
	<div class="formularz_grid" style="padding-top:10px;">
		<form id="wyszukiwarka" class="form-inline" action="" method="post" name="no-focus-wyszukiwarka" enctype="multipart/form-data">
			<ul class="fL">
				<li class="fL" style="width:100%;">
					<label class="input_ok label-szukaj" for="szukaj" >Search: </label> 
					<input class="input-szukaj" autofocus type="text" placeholder="Enter at least 3 characters" autocomplete="off" name="fraza" id="filter" value="" />
					<br/>
					<span id="ilosc-wynikow" class="help-block"></span>
				</li>
				<li class="fL" style="width:100%;">
					<div id="" class="control-group ">
						<label class="control-label input_ok fL" style="margin-top:5px;" for="directAssignment">Sent : </label>
						<div class="controls">
							<div id="grupa">
								<label for="grupa_all" class=" labTxt"><input type="radio" name="wyslana" class="noinput" value="all" checked="">All</label>
								<label for="grupa_get_project" class=" labTxt"><input type="radio" name="wyslana" class="noinput" value="tak">Yes</label>
								<label for="grupa_other_orders" class=" labTxt"><input type="radio" name="wyslana" class="noinput" value="nie">No</label>
							</div>
						</div>
					</div>
				</li>
				<li class="fL" style="width:100%;">
					<div id="" class="control-group ">
						<label class="control-label input_ok fL" style="margin-top:5px;" for="directAssignment">Faktura type : </label>
						<div class="controls">
							<div id="grupa">
								<label for="grupa_all"><input type="radio" name="grupa" value="all" checked="">All</label>
								<label for="grupa_get_project"><input type="radio" name="grupa" value="get_project">Get project</label>
								<label for="grupa_other_orders"><input type="radio" name="grupa" value="other_orders">Private</label>
							</div>
						</div>
					</div>
				</li>
				<li class="fL" style="width:100%;">
					<div id="" class="control-group ">
						<label class="control-label input_ok fL" style="margin-top:5px;" for="directAssignment">Category : </label>
						<div class="controls">
							<div id="grupa">
								<label for="grupa_all"><input type="radio" name="kategoria" value="all" checked="">All</label>
								<label for="grupa_get_project"><input type="radio" name="kategoria" value="installation">Installation</label>
								<label for="grupa_other_orders"><input type="radio" name="kategoria" value="graving">Graving</label>
							</div>
						</div>
					</div>
				</li>
				<li class="fL" style="width:100%;">
					<div id="" class="control-group ">
						<label class="control-label input_ok fL" style="margin-top:5px;" for="directAssignment">Payment option : </label>
						<div class="controls">
							<div id="grupa">
								<label for="grupa_all"><input type="radio" name="platnosc" value="all" checked="">All</label>
								<label for="grupa_get_project"><input type="radio" name="platnosc" value="oplacone">Payed</label>
								<label for="grupa_other_orders"><input type="radio" name="platnosc" value="nie_oplacone">Not Payed</label>
								<label for="grupa_other_exceeded"><input type="radio" name="platnosc" value="przekroczone">Exceeded term</label>
							</div>
						</div>
					</div>
				</li>
				<li class="fL" style="width:100%;">
					<div id="" class="control-group ">
						<label class="control-label input_ok fL" style="margin-top:5px;" for="directAssignment">Data of payment range  </label>
						<div class="controls">
							<div id="grupa">
								<label style="margin-left:8px;"> From: </label>
								{{$inputDataZaplatyOd}}
								
								<label > To: </label>
								{{$inputDataZaplatyDo}}
								
							</div>
						</div>
					</div>
				</li>
				
			</ul>
		</form>
		<div class="clear"></div>
	</div>
</div>
{{END}}
<div class="clear"></div>

<div id="tabela_faktury">
{{$tabela_danych}}
</div>

{{BEGIN podsumowanie}}
<div class="row">
	<div class="col-xs-12 center" style="text-align: center;">					
		<ul class="stat-boxes">
			{{BEGIN wiersz}}
			<li class="{{$klasa}}">
				<div class="left">{{$etykieta}}</div>
				<div class="right faktura_suma">
					<strong id="{{$id}}">{{$kwota}}</strong><strong>{{$kwota_znaczek}}</strong>
				</div>
			</li>
			{{END}}
		</ul>
	</div>	
</div>
{{END}}
</div>
{{END}}

{{BEGIN fakturyReczne}}
{{$formularzWyszukaj}}
<div class="widget-box">
<div class="widget-title">
	<ul class="nav nav-tabs">
      {{BEGIN zakladka}}
      <li class="{{IF $active}}active{{END}}">
			<a class="{{IF $active}}active{{END}}" name="{{$etykieta}}" href="{{$url}}">{{$etykieta}}</a>
		</li>
      {{END}}
	</ul>
	<div class="wysokosc"></div>
</div>
<div style="clear:both;"></div>
<div id="tabela_faktury">
{{$tabela_danych}}
</div>
</div>
{{END}}

{{BEGIN dodajKreditnota}}
{{$formularz}}
{{END}}

{{BEGIN formatKomorkiTablicy}}
	<span class="{{$klasa}}">{{$wartosc}}</span>
{{END}}


{{BEGIN pdf}}
	{{BEGIN pagebreak}}
		<pagebreak />
	{{END}}
<!DOCTYPE html>
<html lang="no">
	<head>
		<meta charset="UTF-8" />
		<style media="print">
		body{
			font-family: Oswald;
		}
		.strong{
			font-family: oswaldbold;
		}
		th.naglowek_pozycje_faktury{
			text-transform:uppercase; border-top: solid 1px #7d7d7d; border-bottom: solid 1px #7d7d7d; border-right: 1px solid #fff; background: #dedede;  text-align: left;
		}
		h3{
			margin:0px 0px 0px 100px; text-transform: uppercase; font-weight: bold; font-size: 13pt; padding-bottom: 0px;
		}
		.kolorEtykieta{
			color:#1da4d0;
		}
		.pozycje_faktury{
			text-align: left; vertical-align: top; border-bottom: 1px solid #e6e6e6; padding: 6px 10px;
		}
		.podsumowanie_etykieta{
			text-transform:uppercase; color:#949494; text-align: right; font-weight: bold; font-size: 11pt;
		}
		.podsumowanie_wartosc{
			text-transform:uppercase; color:#363636; text-align: left; font-size: 11pt;
		}
		.bg_szary{
			background:#ececec;
		}
		.suma_etykieta{
			background:#3fb1d7; color:#fff; text-transform:uppercase; text-align: right; padding: 14px 6px; font-size: 14pt;
		}
		.suma_wartosc{
			background:#545454; color:#fff; padding: 14px 6px; font-size: 14pt;
		}
		.nadawca_odbiorca{
			text-transform:uppercase; font-size: 12pt;
		}
		.kreditnota_info{
			float:right; text-align: right; text-transform: uppercase;
		}
		</style>
	</head>
		<body style="background-image:url({{$tlo}});  background-image-resize: 1;  ">
			
			{{$faktura_pozycje}}
			{{IF $kreditnota_refering}}
			<!--
			<p class="kreditnota_info" >
			{{$kreditnota_refering}}
			</p>
			-->
			{{END}}
			{{$faktura_dane_dodatkowe}}
	</body>
</html>
	{{BEGIN header}}
	<table cellSpacing="0" cellPadding="0" border="0" align="left" width="100%" style="border-bottom: 2px solid #e8e8e4; padding: 0px; margin-left: 100px;">
		<tr>
			<td style="width: 50%"><img src="{{$logo}}" alt="{{$logo_alt}}" style="position: absolute; left: 0; top: 0; width: 200px" class="float: right"/><br/>
				<span class="nadawca_odbiorca" style="font-size:10pt;" >{{$nadawca_nazwa}}</span><br/>
				{{$nadawca_adres}}, {{$nadawca_miasto}}
			</td>
			<td style="width: 50%; text-align:right;">
				<table  cellSpacing="0" cellPadding="0" border="0" align="left" >
					<tr>
						<td style="text-align:left; padding-bottom: 5px;">
							<span style="text-transform: uppercase;" >{{$faktura_etykieta_data_wystawienia}} {{$dataWystawienia}} {{$faktura_nr_strony}} </span>
						</td>
					</tr>
					<tr>
						<td style="height:50px; bgcolor:#363636; padding: auto 50px; text-align: center;" bgcolor="#363636" >
							<span style="color:#fff; font-size: 14pt; text-transform: uppercase;">{{$fakturaNumer}}</span>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	{{END}}
	{{BEGIN nadawca_nr_faktura}}
	<table border="0" cellspacing="0" align="left" width="100%" style="page-break-inside:avoid; margin-left: 100px; margin-right: -30px; margin-top: 0px">
		<tr>
			<td width="61%" valign="top" style="font-size: 9pt; text-transform:uppercase;">
				<!-- <span class='kolorEtykieta' >{{$nadawca_etykieta}}</span><br/> -->
				<!-- <span class="nadawca_odbiorca" >{{$nadawca_nazwa}}</span><br/> -->
				<!--{{$nadawca_adres}}, {{$nadawca_miasto}} -->
				
			</td>
			<td width="39%" valign="top" style="font-size: 9pt; text-transform:uppercase;" >
				{{$nadawca_numer_konta}}<br/>
				{{$nadawca_org_numer}}<br/>
			</td>
			<!-- wrobel
			<td width="39%" valign="top" style="font-size: 9pt; text-transform:uppercase;" >
				<span class='kolorEtykieta' >{{$odbiorca_etykieta}}</span><br/>
				{{IF $adresKorespondencyjnyIstnieje}}
				<span class="nadawca_odbiorca" >{{$odbiorca_nazwa_korespondencja}}</span><br/>{{$odbiorca_adres_korespondencja}}<br/>{{$odbiorca_postcode_korespondencja}} {{$odbiorca_city_korespondencja}}<br clear="all"/>
				<br clear="all"/>{{END}}
				<span class="nadawca_odbiorca" >{{$odbiorca_nazwa}}</span><br/>{{$odbiorca_adres_ulica}}<br/>{{$odbiorca_adres_kod_miasto}}
			</td>
			-->
		</tr>
		<tr>
			<td style="height:10px;">
			</td>
			<td>
			</td>
		</tr>
		<tr>
			<!-- wrobel
			<td valign="top" style="text-transform:uppercase;"><br/>
				{{$nadawca_numer_konta}}<br/>
				{{$nadawca_org_numer}}<br/>
			</td>
			-->
			<td valign="top" style="text-transform:uppercase; padding-top : 10px; ">
				<!-- <span class='kolorEtykieta' >{{$odbiorca_etykieta}}</span><br/> -->
				{{IF $adresKorespondencyjnyIstnieje}}
				<span class="nadawca_odbiorca" >{{$odbiorca_nazwa_korespondencja}}</span><br/>{{$odbiorca_adres_korespondencja}}<br/>{{$odbiorca_postcode_korespondencja}} {{$odbiorca_city_korespondencja}}<br clear="all"/>
				<br clear="all"/>{{END}}
				<span class="nadawca_odbiorca" >{{$odbiorca_nazwa}}</span><br/>{{$odbiorca_adres_ulica}}<br/>{{$odbiorca_adres_kod_miasto}}
			</td>
			<td valign="top" style="text-transform:uppercase; padding-top : 30px; ">
				<table border="0" cellspacing="0" width="100%" >
					{{IF $faktura_wyswietlaj_bet_bet}}
					<tr>
						<td style="text-transform:uppercase;">{{$faktura_bet_bet_etykieta}}</td>
						<td style="text-transform:uppercase;" >{{$faktura_bet_bet_wartosc}}</td>
					</tr>
					{{END IF}}
					<tr>
						<td style="text-transform:uppercase;">{{$etykietaDataPlatnosci}}</td>
						<td>{{$dataPlatnosci}}</td>
					</tr>
					<tr>
						<td style="text-transform:uppercase;">{{$faktura_etykieta_deres_ref}}</td>
						<td style="text-transform:uppercase;" >{{$faktura_deres_ref}}</td>
					</tr>
					{{IF $faktura_kostsenter}}
					<tr>
						<td style="text-transform:uppercase;">{{$faktura_etykieta_kostsenter}}</td>
						<td style="text-transform:uppercase;" >{{$faktura_kostsenter}}</td>
					</tr>
					{{END IF}}
					{{IF $wyswietlaj_od_kogo}}
					<tr>
						<td style="text-transform:uppercase;">{{$faktura_etykieta_var_ref}}</td>
						<td style="text-transform:uppercase;">{{$faktura_var_ref}}</td>
					</tr>
					{{END IF}}
					<tr>
						<td colspan="2">
							<span class='kolorEtykieta' >{{$nadawca_etykieta}}</span>
						</td>
					</tr>
					<tr >
						<td style="text-transform:uppercase;">{{$faktura_etykieta_kundenr}}</td>
						<td style="text-transform:uppercase;">{{$faktura_kundenr}}</td>
					</tr>
					<tr >
						<td style="text-transform:uppercase;">{{$faktura_etykieta_innkjopsnr}}</td>
						<td style="text-transform:uppercase;">{{$faktura_innkjopsnr}}</td>
					</tr>
					<tr >
						<td style="text-transform:uppercase;" >{{$faktura_etykieta_prosjektnr}}</td>
						<td style="text-transform:uppercase;" >{{$faktura_prosjektnr}}</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	{{END}}
	{{BEGIN pozycje_faktury}}
	<div style="position:relative; padding-bottom: 80px;">
	{{IF $faktura_heading}}<h3>{{$faktura_heading}}</h3>{{END IF}}
	<table border="0"  cellpadding="10" cellspacing="6" repeat_header="1" align="left" width="620px" style="border-collapse:collapse; border-spacing:0px;  margin-left: 100px; margin-top: {{IF $faktura_heading}}0px{{ELSE}}20px{{END IF}}">
		<thead>
			<tr>
			<th class="naglowek_pozycje_faktury" >{{$naglowek_numer_pozycji}}</th>
			<th class="naglowek_pozycje_faktury" >{{$naglowek_nazwa_pozycji}}</th>
			<th class="naglowek_pozycje_faktury" >{{$naglowek_jednostka}}</th>
			<th class="naglowek_pozycje_faktury" >{{$naglowek_cena}}</th>
			<th class="naglowek_pozycje_faktury" >{{$naglowek_ilosc}}</th>
			{{IF $faktura_czastkowa}}
			<th class="naglowek_pozycje_faktury" >{{$naglowek_znaczek_av}}</th>
			<th class="naglowek_pozycje_faktury" >{{$naglowek_total}}</th>
			{{END}}
			<th class="naglowek_pozycje_faktury" >{{$naglowek_cena_lacznie}}</th>
			{{IF $rabat_rodzaj}}
			<th class="naglowek_pozycje_faktury" >{{$naglowek_rabat}} ({{$rabat_rodzaj}})  </th>
			<th class="naglowek_pozycje_faktury" >{{$naglowek_kwota_po_rabacie}}</th>
			{{END}}
			{{IF $wyswietlaj_vat_pozycje}}
			<th class="naglowek_pozycje_faktury">{{$naglowek_vat}}</th>
			<th class="naglowek_pozycje_faktury" style="border-right:none;">{{$naglowek_sum_pozycja}}</th>
			{{END}}
			</tr>
		</thead>
		{{$pozycje_faktury_szablon}}
		{{IF $faktura_opis}}
		<tr>
			<td {{IF $faktura_czastkowa}}colspan="8"{{ELSE}}colspan="6"{{END}} style="border : 1px solid #1da4d0;" >
				<span style="font-size: 9pt; color: #3fb1d7;">{{$faktura_opis}}</span>
			</td>
		</tr>
		{{END}}
	</table>
	
	<table border="0" cellspacing="0" align="left" width="100%" style="border-collapse:collapse; border-spacing:0px; page-break-inside:avoid; margin-top: 30px; margin-left: 100px; ">
		<tr>
			<td width="50%"  valign="top" style="text-align:left; text-transform:uppercase;">
				<!--
				<span>{{$etykietaDataPlatnosci}}</span> <strong>{{$dataPlatnosci}}</strong><br/>
				{{IF $faktura_wyswietlaj_bet_bet}}
				{{$faktura_bet_bet_etykieta}} {{$faktura_bet_bet_wartosc}}
				{{END}}
				<br/><br/>
				<span >{{$faktura_etykieta_deres_ref}}</span> {{$faktura_deres_ref}}   <br/>
				<span>{{$faktura_etykieta_var_ref}}</span> {{$faktura_var_ref}}<br/><br/>
				-->
				{{UNLESS $kreditnota}}
				<span style="font-size:12pt; font-weight: bold;">{{$informacje_etykieta_data_platnosci}} : <span class="strong">{{$dataPlatnosci}}</span></span><br/><br/>
				{{$informacje_etykieta_kwota_zaplaty}} : <span style="font-weight:bold; " >{{$kwota_brutto_faktury}}</span><br/>
				{{$nadawca_numer_konta}} <span style="font-weight:bold; " >{{$nadawca_numer_konta_wartosc}}</span><br/>
				{{$etykieta_med_fakturanr}} <span style="font-weight:bold; " >{{$faktura_numer}}</span><br/>
				{{ELSE}}
				<span style="font-weight:bold; " >{{$kreditnotaRefering}}</span>
				{{END}}
			</td>
			<td width="50%" >
				<table  cellpadding="8" width="100%" align="right">
					<tr class="bg_szary">
						<td  class="podsumowanie_etykieta" >{{$naglowek_sum}}</td>
						<td class="podsumowanie_wartosc" >{{$kwota_netto_faktury}}</td>
					</tr>
					{{IF $tax_procent}}
					<tr class="bg_szary">
						<td class="podsumowanie_etykieta" >{{$tax_etykieta}}</td>
						<td class="podsumowanie_wartosc" >{{$tax_procent}} {{$tax_procent_znaczek}}</td>
					</tr>
					{{END}}
					<tr class="bg_szary">
						<td class="podsumowanie_etykieta">{{$naglowek_tax}}</td>
						<td class="podsumowanie_wartosc">{{$kwota_tax_faktury}}</td>
					</tr>
					<tr >
						<td class="suma_etykieta strong">{{$naglowek_sum_total}}</td>
						<td class="suma_wartosc strong" >{{$kwota_brutto_faktury}}</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	</div>
	{{END}}
	{{BEGIN pozycje_faktury_wiersz}}
		<tr style="page-break-after: always">
			<td class="pozycje_faktury">{{$produkt_numer}}</td>
			<td class="pozycje_faktury">{{$nazwa}}</td>
			<td class="pozycje_faktury">{{$jednostka}}</td>
			<td class="pozycje_faktury">{{$kwota_calosc}}</td>
			<td class="pozycje_faktury">{{$ilosc}}</td>
			{{IF $faktura_czastkowa}}
			<td class="pozycje_faktury">{{$znaczek_av}}</td>
			<td class="pozycje_faktury">{{$ilosc_calosc}}</td>
			{{END}}
			<td class="pozycje_faktury">{{$kwota_faktura}}</td>
			{{IF $kwota_rabatu}}
			<td class="pozycje_faktury">{{$kwota_rabatu}}</td>
			<td class="pozycje_faktury">{{$kwota_po_rabacie}}</td>
			{{END}}
			{{IF $wyswietlaj_vat_pozycje}}
			<td class="pozycje_faktury">({{$vat}}%) {{$kwota_vat}} </td>
			<td class="pozycje_faktury">{{$kwota_brutto}} </td>
			{{END}}
		</tr>
	{{END}}
	{{BEGIN footer}}
		<table border="0" align="left" width="100%" style="margin-bottom: -10px; margin-left: 100px; border-top:2px solid #b0b1b1;">
			<tr >
				<td style="text-align: right; font-size: 7pt; text-transform: uppercase; text-align: center; padding-top: 7px;">
					<strong>{{$adres_etykieta}}</strong> {{$adres_wartosc}} {{$miasto_wartosc}} {{$znaczek_rozdziel}} 
					<strong>{{$telefon_etykieta}}</strong> {{$telefon_wartosc}} {{$znaczek_rozdziel}} 
					<strong>{{$email_etykieta}}</strong> {{$email_wartosc}} {{$znaczek_rozdziel}}
					{{$www_wartosc}}
				</td>
			</tr>
		</table>
	{{END}}
{{END}}

{{BEGIN purringPdf}}
<!DOCTYPE html>
<html lang="no">
	<head>
		<meta charset="UTF-8" />
		<style>
			body{
				font-family: Oswald;
				font-size: 11pt;
			}
			.strong{
				font-family: oswaldbold;
			}
			.etykietaStopka{
				color:#20a7d4;
			}
		</style>
	</head>
	<body style="background-image:url({{$tlo}});  background-image-resize: 1;  ">
		<div style="background:#21a8d5; position: absolute; left: 0; top: 0; width:30px; height: 100%; float: left;">
		</div>
	{{BEGIN header}}
		<table cellSpacing="0" cellPadding="0" border="0" align="left" width="620px" style="padding: 0px; margin-top:60px;">
			<tr>
				<td style="width: 50%"><img src="{{$logo}}" alt="{{$logo_alt}}" style="position: absolute; left: 0; top: 0; width: 228px" /></td>
			</tr>
			<tr>
				<td style="padding-top:10px; text-transform: uppercase; font-size: 10pt; color:#373737;">
					<span style="font-size:12pt;">{{$nadawca_nazwa}}</span><br/>
					{{$bkt_adres}}<br/>
					{{$bkt_miasto}}<br/><br/>
					<!--
					{{$bkt_adres}}, {{$bkt_miasto}} {{$znaczek_rozdziel}} {{$org_numer_etykieta}} {{$org_numer}}<br/>
					{{$numer_konta}} {{$znaczek_rozdziel}} {{$telefon_etykieta}} {{$telefon}}<br/>
					{{$email_etykieta}} {{$mail}} {{$znaczek_rozdziel}} {{$www}}
					-->
					
				</td>
			</tr>
		</table>
	{{END}}
	{{BEGIN odbiorca_data}}
	<br clear="all" />
		<table border="0" width="100%" style="margin-top: 50px;">
			<tr>
				<td style="width: 50%; text-align: left; text-transform:uppercase; ">
					{{IF $adresKorespondencyjnyIstnieje}}
					<span style="font-size:14pt;">{{$odbiorca_nazwa_korespondencja}}</span><br/>
					{{$odbiorca_adres_korespondencja}}<br/>
					{{$odbiorca_postcode_korespondencja}} {{$odbiorca_city_korespondencja}}<br clear="all"/><p style="float: left; width: 100%; display: block;"></p>
					<br clear="all"/>{{END}}<span style="font-size:14pt;">{{$odbiorca_nazwa}}</span><br/>
					{{$odbiorca_adres_ulica}}<br/>
					{{$odbiorca_adres_kod_miasto}}
					 
				</td>
				<td style="width: 50%; text-align: right; text-transform: uppercase;" valign="top">{{$miejsce_wystawienia}}, {{$data_wystawienia}}</td>
			</tr>
		</table>
	{{END}}
	{{BEGIN tresc}}
	<p style="margin-top:120px;">
		<span class="strong" style="text-transform:uppercase; font-size: 13pt;">{{$naglowek}}</strong>
		<p style="font-size: 11pt;" >
			{{$tresc}}
		</p>
	</p>
	{{END}}
	{{BEGIN pozycje}}
			<table border="0" cellpadding="7px;" width="100%" style="margin: 10px 0px; ">
			<tr>
				<th colspan="2" style="text-transform:uppercase; border-top: solid 1px #7d7d7d; border-bottom: solid 1px #7d7d7d; border-right: 1px solid #fff; background: #dedede;  text-align: left;">
					{{$pozycje_naglowek}}
				</th>
			</tr>
			<tr>
				<td style="text-align: left; font-size: 10pt; text-transform:uppercase;">
					{{$pozycja_pierwsza}}
				</td>
				<td style="text-align: right; font-size: 10pt; text-transform:uppercase;">
					{{$kr}} {{$kwota_purring}}
				</td>
			</tr>
			<tr>
				<td style="text-transform:uppercase; background: #3fb2d7; color: white; text-align: left; font-weight: bold; border-top: 1px solid #ccc; border-bottom: 1px solid #ccc;">
					{{$pozycja_podsumowanie}}
				</td>
				<td style="text-transform:uppercase; font-size: 13pt; background: #545454; color: white; border-top: 1px solid #ccc; font-weight: bold; border-bottom: 1px solid #ccc; text-align: right;" >
					{{$kr}} {{$kwota_lacznie}}
				</td>
			</tr>
		</table>
	{{END}}
	{{BEGIN konto}}
		{{$numerKonta}}
	{{END}}
	{{BEGIN nadawca}}
	<p>
		{{$nadwaca_naglowek}}<br/>
		{{$nadawca_firma}}
	<p>
		{{$nadawca_nazwa}}
	</p>
	</p>
	{{END}}
	</body>
</html>
	{{BEGIN footer}}
	<table border="0" align="center" width="100%" style="margin-bottom: -10px; border-top:2px solid #b0b1b1;">
		<tr>
			<td style="text-align: center; font-size: 7pt; text-transform: uppercase; padding-top: 10px;">
				<span class="etykietaStopka">{{$adres_etykieta}}</span> {{$adres_wartosc}} {{$miasto_wartosc}} {{$znaczek_rozdziel}} 
				<span class="etykietaStopka">{{$org_numer_etykieta}}</span> {{$org_numer_wartosc}} {{$znaczek_rozdziel}}
				<span class="etykietaStopka">{{$bankgiro_etykieta}}</span> {{$bankgiro_wartosc}} <br/>
				<span class="etykietaStopka">{{$telefon_etykieta}}</span> {{$telefon_wartosc}} {{$znaczek_rozdziel}} 
				<span class="etykietaStopka">{{$email_etykieta}}</span> {{$email_wartosc}} {{$znaczek_rozdziel}}
				{{$www_wartosc}}
			</td>
		</tr>
	</table>
	{{END}}
{{END}}


{{BEGIN dodajFaktura}}
<div>
	<div class="komunikaty"></div>
	{{$form}}
</div>

<script type="text/javascript">
	$('#nazwaFaktury, #fakturaHeading').parents('.control-group').css('clear', 'both');
	if(!zaladowane)
	{
		var zaladowane = 0;
	}
	
	var komunikat = '<div id="walidacja_komunikat" class="alert alert-warning ">{{$komunikat}}<a class="close" data-dismiss="alert" href="#">×</a></div>';
	
	if(zaladowane == 0)
	{
		$('#manualInvoice #zapisz').live('click', function(){
			dodajFakture();
		});
		zaladowane++;
	}
	
	$('.full-width ').css('width', '92%');
	
	var idKlientGet = '{{$id_klient_get}}';
	
	var $wyborAdresu = $('#wybor_adresu_html').parents('.control-group');
	var $wyborKlientaInfo = $('#wybor_klienta_info').parents('.control-group');
	var $deliveryAddress = $('#deliveryAddress').parents('.formularz_region');
	var $wyborProduktow = $('#wybor_produktow').parents('.formularz_region');
	var $daneDodatkoweGet = $('#dane_dodatkowe_get').parents('.formularz_region');
	var $daneZalaczniki = $('#zalaczniki').parents('.formularz_region');
	var $nazwaFaktury = $('#nazwaFaktury').parents('.control-group');
	var $naglowekFaktury = $('#fakturaHeading').parents('.control-group');
	var $zalaczniki = $('#zalaczniki_input').parents('.control-group');
	//var $daneDodatkowePrywatni = $('#dane_dodatkowe_prywatni').parents('.formularz_region');
	var $formularzStopka = $('.formularz_stopka');
	
	$wyborAdresu.hide();
	$deliveryAddress.hide();
	$wyborProduktow.hide();
	$daneDodatkoweGet.hide();
	$formularzStopka.hide();
	$nazwaFaktury.hide();
	$naglowekFaktury.hide();
	$daneZalaczniki.hide();
	$zalaczniki.hide();
	//$daneDodatkowePrywatni.hide();
	
	$('input[name="wybrany_adres"]').live('click', function(){
		if ($(this).val() == 'new')
			$deliveryAddress.show();
		else
			$deliveryAddress.hide();
	});
	
	function usunWierszRabatu(id)
	{
		var idUsun = id.replace(/ /g, '_');
		$('#id_'+idUsun).remove();
		$('input[name=rabat_rabat_na_calosc]').keyup();
	}
	
	function pokazUkryjRabat()
	{
		if($('#dodajRabat').is(':checked'))
		{
			$('.region_zamkniety').show();
		}
		else
		{
			$('.region_zamkniety').hide();
		}
	}
	
	$(document).ready(function(){
		
		$(document).on('click',"ul.nst .ui-spinner-button", function (e) { 
			console.log('tutaj');
			var rodzic = $(this).parents('li');
			
			setTimeout(function(){
				var id = rodzic.find('.hiddenId').val().replace(/ /g, '_');
				var total = rodzic.find('.hiddenCenaTmp').val().replace(',', '');
				var totalNowy = rodzic.find('.sum_total_price').val().replace(' ', '');
				var kwotaDoRabat = (parseFloat(totalNowy) - parseFloat(total));
				
				$('#id_'+id).find('.rabat_cena').val(totalNowy);
				$('.rabat_rabat').keyup();
			}, 100); });
		
		$('input[name=rabat_rabat_na_calosc]').keyup();
		
		$('#dodajRabat').on('click', function(){ pokazUkryjRabat(); });
		
		$(document).on('click',".remove_n", function (e) { usunWierszRabatu($(this).parent('li').find('.hiddenId').val()); });
		
		$('#add_niestandardowy').on('click', function(){
			var lista = $('#produkty_rabat');
			var znajdz = ['{NAZWA}', '{ID}', '{CENA}'];
			
			
			setTimeout(function(){
				var nowyWiersz = $('ul.nst li').last();
				var nazwa = nowyWiersz.find('.prd_projekt').text();
				
				var id = nowyWiersz.find('.hiddenId').val().replace(/ /g, '_');
				var cena = nowyWiersz.find('.sum_total_price').val();
				var zamien = [nazwa, id, cena];
				
				var zamienionyWiersz = wierszPatern.replaceArray(znajdz, zamien);
				lista.append(zamienionyWiersz);
				$('input[name=rabat_rabat_na_calosc]').keyup();
			}, 200);
		});
		
		if($("[name^=numberPrivatCustomer]").val())
		{
			generujOpcje(document.customer);
			$wyborAdresu.fadeIn();
			$wyborProduktow.fadeIn();
			$nazwaFaktury.fadeIn();
			$daneZalaczniki.fadeIn();

			$(document).on('click', '.ui-spinner-button', function(){
				var iloscPobrana = $(this).siblings('.procent_wykonania').val();
				var iloscMin = $(this).siblings('.procent_wykonania').attr('aria-valuemin');
				
				if(parseInt(iloscPobrana) > parseInt(iloscMin))
				{
					$formularzStopka.fadeIn();
				}
				else
				{
					$formularzStopka.fadeOut();
				}
			});
			if (document.customer.id == idKlientGet || document.customer.id_parent == idKlientGet)
			{
				$daneDodatkoweGet.fadeIn();
			}
			else
			{
				$daneDodatkoweGet.fadeOut();
			}
			$('select').select2();
		}
		$("[name^=numberPrivatCustomer]").bind('change', function(){
			$wyborKlientaInfo.hide();
			generujOpcje(document.customer);
			$wyborAdresu.fadeIn();
			$wyborProduktow.fadeIn();
			$nazwaFaktury.fadeIn();
			$naglowekFaktury.fadeIn();
			$daneZalaczniki.fadeIn();
			$('select').select2();
			$('#produkty_kategoria').select2({width: '120px'});
			var $controlGroupCustomer = $('#numberPrivatCustomer').parents('.control-group');
			$controlGroupCustomer.removeClass('input_blad error').addClass('input-ok');
			$controlGroupCustomer.find('.help-block').html('');

			if (document.customer.id == idKlientGet || document.customer.id_parent == idKlientGet)
			{
				$daneDodatkoweGet.fadeIn();
			}
			else
			{
				$daneDodatkoweGet.fadeOut();
			}
			$formularzStopka.fadeIn();
		});
		
		$('#zalaczniki_czy').live('click', function(){
			if ($('#zalaczniki_czy').is(':checked'))
			{
				$zalaczniki.fadeIn();
				ustawDodawanieZalacznikow(true);
			}
			else
			{
				$zalaczniki.hide();
				ustawDodawanieZalacznikow(false);
			}
		});
		
		if ($('input[name="wybrany_adres"]:checked').val() == 'new')
			$deliveryAddress.show();
		else
			$deliveryAddress.hide();
		
		$('#add_niestandardowy, .remove_n').bind('click', function(){
			setTimeout(function(){
				if ($('#zalaczniki_czy').is(':checked'))
					ustawDodawanieZalacznikow(true);
				else
					ustawDodawanieZalacznikow(false);
			}, 100);
		});
	});
	
	/*
	 * Sprawdza czy załączniki są dodawane - jeśli tak faktura nie może być dzielona i funkcja ta zablokuje taką możliwość
	 */
	function ustawDodawanieZalacznikow(status)
	{
		$('.prd_dodane .item').each(function(){
			if (status)
			{
				var iloscPoczatkowa = $(this).find('.quantity').val();
				
				var wartoscProcent = (iloscPoczatkowa == 1) ? 100 : iloscPoczatkowa;
				
				$(this).find('.procent_wykonania').val(wartoscProcent);
				$(this).find('.kwota_kontener .ui-spinner-up').click();
				$(this).find('.kwota_kontener .ui-spinner a').hide();
			}
			else
			{
				$(this).find('.kwota_kontener .ui-spinner a').show();
			}
		});
	}
	
	function generujOpcje(cust)
	{
		$('#select_address').html('');
		var opcje = new Array();
		var ilosc = 1;
			
		opcje['norm'] = {
			address: cust.address,
			postcode: cust.postcode,
			city: cust.city,
			etykieta: '{{$etykieta_norm}}',
			ikona: 'icon icon-home',
			checked: ($('#address').val() == '' || (cust.address == $('#address').val() && cust.postcode == $('#postcode').val() && cust.city == $('#city').val())) ? true : false
		};
		if (cust.korespondencja_address != '' &&  cust.korespondencja_address != null)
		{
			ilosc = 2;
			opcje['korespondencja'] = {
				address: cust.korespondencja_address,
				postcode: cust.korespondencja_postcode,
				city: cust.korespondencja_city,
				etykieta: '{{$etykieta_korespondencyjny}}',
				ikona: 'icon icon-globe',
				checked: (cust.korespondencja_address == $('#address').val() && cust.korespondencja_postcode == $('#postcode').val() && cust.korespondencja_city == $('#city').val()) ? true : false
			};
		}
		var i = 1;
		var checked = '';
		var czy_zaznaczono = false;
		for (klucz in opcje)
		{
			if (opcje[klucz]['checked'])
			{
				checked = 'checked="checked"';
				czy_zaznaczono = true;
			}
			$('#select_address').append('<label><input type="radio" class="wybrany_adres" '+checked+'name="wybrany_adres" value="'+klucz+'"/><i class="'+opcje[klucz]['ikona']+'"></i> <var>'+ opcje[klucz]['etykieta']+ '</var>: <strong>' + opcje[klucz]['address']+', '+opcje[klucz]['postcode']+ ' '+opcje[klucz]['city'] + '</strong></label>');
			i++;
		}
		if (!czy_zaznaczono)
			checked = 'checked="checked"';
		else
			checked = '';
		
		$('#select_address').append('<label><input type="radio" class="wybrany_adres" '+checked+'name="wybrany_adres" value="new"/><i class="icon icon-asterisk"></i> <var>{{$etykieta_nowy_adres}}</var></label>');
	}
	
	function dodajFakture()
	{
		if (! validateForm())
		{
			return false;
		}
		
		var produkty = {};
		var $items = $('.productsFull .item');
		if ($items.length > 0)
		{
			$items.each(function(){
				var id = $(this).find('.hiddenId').val().replace(/ /g, '_');
				
				produkty[id] = {
					nazwa: $(this).find('.hiddenNazwa').val(),
					kategoria: $(this).find('.produkt_kategoria option:selected').val(),
					ilosc: $(this).find('.quantity').attr('aria-valuenow'),
					cena: $(this).find('.produkty_ceny.price').val(),
					procent: $(this).find('.procent_wykonania').attr('aria-valuenow'),
					vat: $(this).find('.vat').val(),
				};
			});
		}
		
		var rodzaj_rabatu = null;
		if($('#dodajRabat').is(':checked'))
		{
			$('#produkty_rabat .item').each(function(){
				var id = $(this).attr('id').replace('id_', '');
				produkty[id]['rabat'] = $(this).find('.rabat_rabat').val();
				produkty[id]['kwota_po_rabacie'] = $(this).find('.rabat_kwota_po_rabacie').val();
			});
			rodzaj_rabatu = $('input[name=rabat_rabat_rodzaj]:checked').val();
		}
		
		var obj = {
			klient: document.customer,
			wybrany_adres: $('.wybrany_adres:checked').val(),
			produkty: produkty,
			numberProjectGet: $('#project_number_get').val(),
			numberProjectInkjops: $('#project_code_get').val(),
			nazwaFaktury: $('#nazwaFaktury').val(),
			naglowekFaktury: $('#fakturaHeading').val(),
			idRodzica: $('#idRodzica').val(),
			token: $('#zalaczniki_input_token').val(),
			rodzaj_rabatu: rodzaj_rabatu
		};
		if (obj.wybrany_adres === 'new')
		{
			obj['adres'] = {
				address: $('#address').val(),
				postcode: $('#postcode').val(),
				city: $('#city').val()
			};
		}
		
		$('.mobile-loader').fadeIn("normal");

		$.ajax({
			url: '{{$url_dodaj_faktura}}',
			type: 'POST',
			dataType: 'json',
			data: obj,
			async: true,
			success: function(dane) {
				if (dane !== null)
				{
					if (dane.success)
					{
						if(dane.przekierowanie == 1)
						{
							window.location.href = dane.przekierujUrl;
						}
						else
						{
							$('#tabela_faktury').html(dane.grid);
							$('#sumaInstalacje').text(number_format(dane.kwota_installation, 2, '.', ' '));
							$('#sumaGraving').text(number_format(dane.kwota_graving, 2, '.', ' '));
							$('#sumaNetto').text(number_format(dane.kwota_do_zaplaty_netto, 2, '.', ' '));
							$('#sumaBrutto').text(number_format(dane.kwota_do_zaplaty_brutto, 2, '.', ' '));
							$('#sumaVat').text(number_format(dane.kwota_vat, 2, '.', ' '));
							$('.close').click();
						}
					}
					else
					{
						$('.modal-body .komunikaty').html(dane.komunikaty);
					}
				}
				$('.mobile-loader').fadeOut("normal");
			},
			error: function (xhr, ajaxOptions, thrownError) {
				$('.mobile-loader').fadeOut("normal");
				var error = 'Adding new created manually invoice failed: '+xhr.status;
				if (thrownError != '') 
				{
					error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
					error += xhr.responseText;
				}
				
				alertModal('AJAX request error' ,error);
			}
		});
	}
	
	function validateForm()
	{
		var blad = false;
		// Sprawdzam klienta
		var $controlGroupCustomer = $('#numberPrivatCustomer').parents('.control-group');
		if (typeof document.customer === 'undefined')
		{
			$controlGroupCustomer.removeClass('input-ok').addClass('input_blad error');
			$controlGroupCustomer.find('.help-block').html('{{$blad_walidacji_klient}}');
			blad = true;
		}
		else
		{
			$controlGroupCustomer.removeClass('input_blad error').addClass('input-ok');
			$controlGroupCustomer.find('.help-block').html('');
		}
		
		// Sprawdzam produkty
		var $items = $('#wybor_produktow .item');
		$controlGroupProducts = $('#wybor_produktow').find('.control-group');
		
		if ($items.length === 0)
		{
			$controlGroupProducts.removeClass('input-ok').addClass('input_blad error');
			$controlGroupProducts.find('.help-block').html('{{$blad_walidacji_produkty}}');
			blad = true;
		}
		else
		{
			$controlGroupProducts.removeClass('input_blad error').addClass('input-ok');
			$controlGroupProducts.find('.help-block').html('');
		}
		if (document.kwota <= 0)
		{
			$controlGroupProducts.removeClass('input-ok').addClass('input_blad error');
			$controlGroupProducts.find('.help-block').html('{{$blad_zerowa_wartosc_faktury}}');
			blad = true;
		}
		else
		{
			$controlGroupProducts.removeClass('input_blad error').addClass('input-ok');
			$controlGroupProducts.find('.help-block').html('');
		}
		
		// Sprawdzam adres jeĹ›li wybrany niestandardowy
		
		if ($('.wybrany_adres:checked').val() === 'new')
		{
			var elementy = Array('address', 'postcode', 'city');
			console.log(elementy);
			for (element in elementy)
			{
				console.log(elementy[element]);
				var $cG = $('#'+elementy[element]).parents('.control-group');
				if ($('#'+elementy[element]).val() === '')
				{
					$cG.removeClass('input-ok').addClass('input_blad error');
					blad = true;
				}
				else
				{
					$cG.removeClass('input_blad error').addClass('input-ok');
				}
			}
		}
		
		if (blad)
		{
			if ($('#walidacja_komunikat').length === 0) $(komunikat).insertBefore('.widget-box');
			return false;
		}
		else
		{
			$('#walidacja_komunikat').remove();
			return true;
		}	
	}
</script>
{{END}}
{{BEGIN search}}
<script type="text/javascript">
	
	$.fn.delayKeyup = function(callback, ms){
		var timer = 0;
		var el = $(this);
		$(this).keyup(function(){                   
         clearTimeout (timer);
         timer = setTimeout(function(){
					callback(el)
					}, ms);
			});
		return $(this);
	};
	
	var blokujWysylanie = 0;
	var iPad = 0;
	var typ = 'all';
	$(document).ready(function () {
		

		$('#emailForm').live('submit', function(){

			$.ajax({
				url: $('#emailForm').attr('action'),
				type: $('#emailForm').attr('method'),
				data: $('#emailForm').serialize(),
				dataType: 'json',
				async: true,
				success: function(dane) {
					if(dane.kod == '1' )
					{
						$('#oknoModalne').attr('aria-hidden', 'true');
						$('#oknoModalne').modal('hide');
						$('#wiersz_'+dane['idFaktury']+' td:last a[klucz="wyslijFaktura"]').hide(500);
					}
					if(dane.kod == '2' )
					{
						$('#oknoModalne').html(dane.html);
					}
					if(dane.kod == '3')
					{

					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
					}
				}
			)
			return false;
		});
		
		$(window).scroll(function() {
			
			if($('.wyszukiwarka-lista li:not(#wiecej)').length >= $('#ilosc').text())
			{
			}
			else
			{
				if($('#fraza').val().length > 2)
				{
					if(($(window).scrollTop() + 280 ) > ($(document).height() - $(window).height())) {
						if(!blokujWysylanie)
						{
							blokujWysylanie = 1;
							szukaj($('#fraza').val(), typ);
						}
					}
				}
			}
		});
		
		$('input[type=radio]').uniform();
		
		$('input[type=radio]').live('change', function(){
			typ = $(this).val();
			if($('#fraza').val().length > {{$iloscZnakow}})
			{
				$('#nrStrony').val(0);
				szukaj($('#fraza').val(), typ);
			}
		});
		
		if(navigator.platform == 'iPad')
			iPad = 1;
		
		$('#fraza').delayKeyup(function(el){
			$('#nrStrony').val({{$nrStrony}});
			$('#naStronie').val({{$naStronie}});
			if(el.val().length > {{$iloscZnakow}})
			{
				szukaj(el.val(), typ);
			}
			else
			{
				$('ul.wyszukiwarka-lista').html('<li id="pusta-lista">{{$szukajFrazaPlaceholder}}</li>');
				$('#ilosc-wynikow').html("{{$znaleziono_ilosc_etykieta}} <span id='ilosc'>0</span>");
			}
			
		}, 500);
		
		$('#fraza').bind('paste', function()
		{
			$(this).keyup();
		});
		
	});
	
	function wyslijFaktura(url)
	{
		$('.mobile-loader').fadeIn("normal");
		$.ajax({
			url: url.href,
			type: 'POST',
			dataType: 'json',
			async: true,
			success: function(dane) {

				if(dane.kod == '1' )
				{
					$('#linkWyslij_'+dane['idFaktury']).hide(500);
				}
				if(dane.kod == '2')
				{
					modalAjax(dane.wyslijFakturaWprowadzEmail);
				}
				if(dane.kod == '3')
				{
					alertModal('{{$error_wyslij_fakture_naglowek}}', '{{$error_wyslij_fakture_tresc}}');
				}
				$('.mobile-loader').fadeOut("normal");
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
				$('.mobile-loader').fadeOut("normal"); 
			}
		});
	}
	
	function fakturaUpomnienie(obiekt)
	{
		$.ajax({
				url: obiekt.href,
				type: 'POST',
				dataType: 'json',
				async: true,
				success: function(dane) {
					if(dane['kod'] == 1)
					{
						$('#fraza').keyup();
					}
					else if(dane['kod'] == 2){
						
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
		})
		return false;
	}
	
	function fakturaKreditnota(url)
	{
		$.ajax({
				url: url,
				type: 'POST',
				dataType: 'json',
				async: true,
				success: function(dane) {

					$('#oknoModalne .modal-body').html(dane.html);
					$('#oknoModalne').modal('show');
					$('#dniPlatnosci').insertAfter("<span class='qty'>");
					$('#dniPlatnosci').spinner({min: 0});
					dopasujModala();
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
			});
	}
	
	$('#kreditnotaForm').live('submit', function(){

		$.ajax({
			url: $('#kreditnotaForm').attr('action'),
			type: $('#kreditnotaForm').attr('method'),
			data: $('#kreditnotaForm').serialize(),
			dataType: 'json',
			async: true,
			success: function(dane) {

				if(dane.kod == '1' )
				{
					$('#oknoModalne').attr('aria-hidden', 'true');
					$('#oknoModalne').modal('hide');
					$('#fraza').keyup();
				}
				if(dane.kod == '2' )
				{
					console.log('blad');
				}

			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
				}
			}
		)
		return false;
	});
	
	
	function fakturaZaplacona(obiekt)
	{
		$.ajax({
				url: obiekt.href,
				type: 'POST',
				dataType: 'json',
				data: "",
				async: true,
				success: function(dane) {
					if(dane['kod'] == 1)
					{
						$('#linkOplac_'+dane['idFaktury']).hide(500);
						$('#wynik_'+dane['idFaktury']).attr('style', 'background:#9ee7f7');
					}
					else if(dane['kod'] == 2)
					{
						alertModal("{{$error_zaplac_fakture_naglowek}}", "{{$error_zaplac_fakture_tresc}}");
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
		})
		return false;
	}
	
	function wystawFakture(obiekt)
	{
		$('.mobile-loader').fadeIn("normal");
		$.ajax({
				url: obiekt.href,
				type: 'POST',
				dataType: 'json',
				async: true,
				success: function(dane) {
					if(dane['kod'] == 1)
					{
						$('#linkWystaw_'+dane['id']).hide(500);
						$('#fraza').keyup();
					}
					if(dane['kod'] == 2)
					{
						alertModal("{{$error_wystaw_fakture_naglowek}}", "{{$error_wystaw_fakture_tresc}}");
					}
					$('.mobile-loader').fadeOut("normal");
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
					$('.mobile-loader').fadeOut("normal");
				}
		})
		return false;
	}
	
	function szukaj(fraza, kategoria)
	{
			
		var loader = "<div id=\"loader\"></div>";
		//$('ul.wyszukiwarka-lista').attr('style' ,  'min-height : 600px;');
		if($('ul.wyszukiwarka-lista').height() < 200)
		{
			$('ul.wyszukiwarka-lista').animate({height : 'auto',},300);
		}

		$('ul.wyszukiwarka-lista').append(loader);
			$('#loader').fadeIn(500);
			var nrStrony = $('#nrStrony').val();
			var nrStronie = $('#naStronie').val();
			$.ajax({
				url: "{{$linkPobierzWyniki}}",
				type: 'POST',
				dataType: 'json',
				data: '&fraza='+fraza+'&nrStrony='+nrStrony+'&naStronie='+nrStronie+'&typ='+typ,
				// data: { fraza: fraza , nrStrony: nrStrony , naStronie: naStronie, typ: typ },
				async: true,
				success: function(dane) {
					$('#loader').fadeOut(500);
					

					if(dane['kod'] == 1)
					{
						$('#pusta-lista').remove();
						$('ul.wyszukiwarka-lista').css('height', 'auto');
						
						if(nrStrony > 1)
							$('ul.wyszukiwarka-lista').append(dane['html']);
						else
							$('ul.wyszukiwarka-lista').html(dane['html']);
						
						blokujWysylanie = 0;
						$('#nrStrony').val(dane.nrStrony);
						$('#naStronie').val(dane.naStronie);
					}
					else
					{
						$('ul.wyszukiwarka-lista').html(dane['html']);
					}
					$('#ilosc-wynikow').html("{{$znaleziono_ilosc_etykieta}} <span id='ilosc'> " + dane['ilosc'] + ' </span>');
					//$('.tip-top').tooltip();
				},
				error: function (xhr, ajaxOptions, thrownError) {
					var error = 'Delete row failed: '+xhr.status;
					if (thrownError != '') 
					{
						error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
						error += xhr.responseText;
					}
					alertModal('AJAX request error' ,error);

				}
		});
		return false;
	}
	
	
	
</script>
<div class="widget-box">
<div class="widget-title">
	<ul class="nav nav-tabs">
      {{BEGIN zakladka}}
      <li class="{{IF $active}}active{{END}}">
			<a class="{{IF $active}}active{{END}}" name="{{$etykieta}}" href="{{$url}}">{{$etykieta}}</a>
		</li>
      {{END}}
	</ul>
	<div class="wysokosc"></div>
</div>
<div style="clear:both;"></div>
<div class="widget-content">
	<div class="formularz_grid" style="padding-top:10px;">
		<input type="hidden" name="nrStrony" id="nrStrony" value="{{$nrStrony}}" />
		<input type="hidden" name="naStronie" id="naStronie" value="{{$nrStronie}}" />
		<form id="wyszukiwarka" class="form-inline" action="" method="post" name="no-focus-wyszukiwarka" enctype="multipart/form-data">
		<ul class="fL">
			<li class="fL">
				<label class="input_ok label-szukaj" for="szukaj" >{{$szukajFraza}} </label> 
				<input class="input-szukaj" autofocus type="text" placeholder="{{$szukajFrazaPlaceholder}}" autocomplete="off" name="fraza" id="fraza" value="" />
				<br/>
				<div id="zbiorowy_directAssignment" class="control-group left">
				<label class="control-label input_ok fL" for="directAssignment">Search option : </label>
				<div class="controls">
				<div id="grupa" >
				{{BEGIN radioOpcje}}
				<label for="grupa_{{$wartosc}}" ><input type="radio" name="grupa" value="{{$wartosc}}" {{$zaznacz}} >{{$etykieta}}</label>
				{{END radioOpcje}}
				</div>
				</div>
				</div>
				<div class="clear"></div>
				<span id="ilosc-wynikow" class="help-block"></span>
			</li>
		</ul>
		</form>
		<div class="clear"></div>
	</div>
	<div class="widget-box">
		<div class="widget-content" >
			<ul class="wyszukiwarka-lista">
				{{BEGIN listaWynikow}}
				{{BEGIN pustaLista}}
					<li id="pusta-lista">{{$brakWynikowWyszukiwania}}</li>
				{{END pustaLista}}
				{{BEGIN wynik}}
				<li id="wynik_{{$id_faktura}}" style="background:{{$bg}}">
					<div class="widok-wyszukaj-naglowek">
						<div class="widok-wyszukaj-tytul fL"  >
							<div class="fL margin" style="width: 76%;" >
								{{IF $termin}}
								<span class="label label-info kategoria_magazyn">
								{{$termin}}	<small>({{$rok}})</small>
								</span>
								{{END}}
								<a class="label label-success kategoria_magazyn" >
									{{IF $numer_kreditnota}}
									<i class="icon icon-minus-sign"></i>
									{{$numer_kreditnota}}
									{{ELSEIF $faktura_rodzaj == 'purring'}}
									<i class="icon icon-legal"></i>
									{{$numer_faktury}}
									{{ELSEIF $faktura_rodzaj == 'inkassovarsel'}}
									<i class="icon icon-legal"></i>
									{{$numer_faktury}}
									{{ELSE}}
									<i class="icon icon-money"></i>
									{{$numer_faktury}}
									{{END}}
								</a>
								<strong class="tytul_produkt_magazyn">{{$nazwa_faktury}}</strong> 
								{{IF $data_wystawienia}}
								( {{$data_wystawienia}} / {{$data_zaplaty}} )
								{{END data_wystawienia}}
								<br/>
								<i>{{$naglowek_faktury}}</i>
							</div>
							{{IF $klient_istnieje}}
							<div class="fR margin" style="width: 20%;">
								<i class="icon icon-user"></i> {{IF $company_name}} {{$company_name}}<br/>{{END}}
								{{$name}} {{$second_name}} {{$surname}}
							</div>
							{{END klient_istnieje}}
						</div>
						
						<div class="widok-wyszukaj-przyciski fR" >
							<div class="fR">
							{{IF $wystawFaktureLink}}
							<a id="linkWystaw_{{$id_faktura}}" onclick="wystawFakture(this); return false;" href="{{$wystawFaktureLink}}" class="btn btn-success btn-lg edytujDane" title="{{$wystawFaktureEtykieta}}">
								<i class="icon icon-paste"></i>
							</a>
							{{END}}
							{{IF $wyslijFaktureLink}}
							<a id="linkWyslij_{{$id_faktura}}" onclick="wyslijFaktura(this); return false;" href="{{$wyslijFaktureLink}}" class="btn btn-success btn-lg edytujDane" title="{{$wyslijFaktureEtykieta}}">
								<i class="icon icon-envelope"></i>
							</a>
							{{END wyslijFaktureLink}}
							{{IF $zaznaczOplaconaLink}}
							<a id="linkOplac_{{$id_faktura}}" onclick="fakturaZaplacona(this); return false;" href="{{$zaznaczOplaconaLink}}" class="btn btn-info btn-lg edytujDane" title="{{$zaznaczOplaconaEtykieta}}">
								<i class="icon icon-money"></i>
							</a>
							{{END}}
							{{IF $dodajKreditnotaLink}}
							<a id="linkKreditnota_{{$id_faktura}}" onclick="fakturaKreditnota(this.href); return false;" href="{{$dodajKreditnotaLink}}" class="btn btn-success btn-lg edytujDane" title="{{$dodajKreditnotaEtykieta}}">
								<i class="icon icon-minus-sign"></i>
							</a>
							{{END}}
							{{IF $dodajUpomnienieLink}}
							<a id="linkUpomnienie_{{$id_faktura}}" onclick="fakturaUpomnienie(this); return false;" href="{{$dodajUpomnienieLink}}" class="btn btn-success btn-lg edytujDane" title="{{$dodajUpomnienieEtykieta}}">
								<i class="icon icon-legal"></i>
							</a>
							{{END}}
							{{IF $zalacznikiLink}}
							<a id="linkZalaczniki_{{$id_faktura}}" onclick="modalAjax(this); return false;" href="{{$zalacznikiLink}}" class="btn btn-success btn-lg edytujDane" title="{{$zalacznikiLinkEtykieta}}">
								<i class="icon icon-paper-clip"></i>
							</a>
							{{END}}
							<a id="podglad_{{$id_faktura}}" href="javascript: modalIFrame('{{$podgladFakturaLink}}');" class="btn btn-info btn-lg edytujDane" title="{{$podgladFakturaEtykieta}}">
								<i class="icon icon-search"></i>
							</a>
							</div>
							<div class="fR margin">
							<strong id="total_price" >{{$sumaNettoEtykieta}} {{$kwota_do_zaplaty_netto}}</strong><br/>
							<i>{{$instalEtykieta}} {{$kwota_installation}} / {{$gravEtykieta}} {{$kwota_graving}} </i>
							</div>
						</div>
						<div class="clear"></div>
					</div>
					<div class="zamowienie-informacje" style="display:none; position:relative;">

					</div>
					<div class="clear"></div>
				</li>
				{{END wynik}}
				{{END listaWynikow}}
			</ul>
			</div>
		</div>
</div>
</div>
{{END}}
