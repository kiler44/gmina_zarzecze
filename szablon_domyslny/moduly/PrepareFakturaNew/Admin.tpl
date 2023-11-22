{{BEGIN index}}
<div class="prepare widget-box">
	<div class="widget-title">
		<ul class="nav nav-tabs">
		{{BEGIN zakladka}}
			<li class="{{$klasa}}">
				<a href="{{$url_zakladka}}" name="{{$etykieta_zakladka}}" class="">{{$etykieta_zakladka}} ({{$ilosc}})</a>
			</li>
		{{END}}
		</ul>
	</div>
	<div id="komunikatyBlok" style="padding: 10px;"></div>
	<div class="left">
		<ul class="stat-boxes">
			<li>
				<div class="left taken"><i class="icon icon-certificate"></i> <small>{{$etykieta_do_wziecia}}</small></div>
				<div class="left nopadding">
					<table class="ceny">
						<tr>
							<th>{{$etykieta_do_wziecia_reports}}</th>
							<th>{{$etykieta_do_wziecia_projects}}</th>
							<th>{{$etykieta_do_wziecia_private}}</th>
						</tr>
						<tr class="price">
							<td id="do_wziecia_raporty">{{$do_wziecia_raporty}}</td>
							<td id="do_wziecia_projekty">{{$do_wziecia_projekty}}</td>
							<td id="do_wziecia_prywatne">{{$do_wziecia_prywatne}}</td>
						</tr>
					</table>
				</div>
				<div class="right block">
					<strong id="do_wziecia_suma">{{$do_wziecia_suma}}</strong>
				</div>
			</li>
			 
			<!--
			<li><div><i class="icon icon-money"></i> <small>{{$etykieta_processing}}</small></div><div><strong>{{$processing}}</strong></div></li>
			{{BEGIN okres}}
			<li><div><i class="icon icon-calendar"></i> <small>{{$etykieta_okres}}</small></div><div><strong>{{$wartosc}}</strong></div></li>
			{{END}}
			-->
		</ul>
			{{IF $tab == 5}}
			<!-- <button class="btn btn-info margin" onclick="updateBlock('projekty', 1)" style="margin-top:-35px;" >{{$pokaz_zamkniete_etykieta}}</button> -->
			<a href="{{$url_pokaz_zamkniete}}" class="btn btn-info margin" style="margin-top:-35px;">{{$pokaz_zamkniete_etykieta}}</a>
			{{END}}
	</div>
	{{$bloki}}
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$('#dodajOpis').live('submit', function(){
			
			$.ajax({
				url: $(this).attr('action'),
				type: 'POST',
				dataType: 'json',
				data: $(this).serialize()+'&raport=1',
				success: function(dane) {
					if (dane.kod == 1)
					{
						$('.close').click();
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					var error = 'Send private order status: '+xhr.status;
					if (thrownError != '') 
					{
						error += ', with error: '+thrownError;
					}
					alertModal('AJAX request error' ,error);
				}
			});
			return false;
		})
	});
	
	
	
	
	function updatePossiblePrice()
	{
		$.ajax({
			url: '{{$url_ajax_possible}}',
			type: 'GET',
			dataType: 'json',
			async: true,
			success: function(dane) {
				$('#do_wziecia_raporty').html(dane.raporty);
				$('#do_wziecia_projekty').html(dane.projekty);
				$('#do_wziecia_prywatne').html(dane.prywatne);
				$('#do_wziecia_suma').html(dane.suma);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var error = 'Update cash to be taken failed: '+xhr.status;
				if (thrownError != '') 
				{
					error += ', with error: '+thrownError;
				}
				alertModal('AJAX request error' ,error);
				$('.mobile-loader').fadeOut("normal");
			}
		});
	}
</script>
{{END}}


{{BEGIN blokRaportow}}
<div class="widget-box collapsible prepareFaktura">
	<div class="widget-title">
		<a href="#collapseReports" data-toggle="collapse" class="">
			<span class="icon"><i class="icon-legal"></i></span>
			<h5>{{$tytul}}</h5>
		</a>
	</div>
	<div style="height: auto;" class="in" id="collapseReports">
		<div class="widget-content nopadding">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>{{$etykieta_typ}}</th>
						<th>{{$etykieta_autor}}</th>
						<th>{{$etykieta_data_od}}</th>
						<th>{{$etykieta_data_do}}</th>
						<th>{{$etykieta_cena}}</th>
						<th>{{$etykieta_status}}</th>
						<th><i class="icon  icon-ellipsis-horizontal"></i></th>
					</tr>
				</thead>
				{{BEGIN wiersze}}
				<tbody id="daneRaportow">
					{{BEGIN wiersz}}
					<tr class="{{$klasa}}">
						<td>{{$nazwa}}</td>
						<td class="team-naglowek" style="text-align: center">{{$autor}}</td>
						<td>{{$data_od}}</td>
						<td>{{$data_do}}</td>
						<td class="price"><strong>{{$cena}}</strong></td>
						<td>{{$data_dodania}} <small>{{$status_tekst}}</small></td>
						<td>
							<div class="btn-group">
							{{IF $status == 'wyslany'}}
							<a class="btn btn-danger tip-top" onclick="return potwierdzenieUsun('{{$etykieta_potwierdz_cofnij}}', $(this))" href="javascript: undoReport({{$id}});" title="{{$etykieta_cofnij}}"><i class="icon icon-undo"></i></a>
							{{END IF}}
							{{IF $status == 'zafakturowany'}}
							<a class="btn btn-info tip-top" href="javascript: modalIFrame('{{$url_podglad_faktury}}');" title="{{$etykieta_pokaz}}"><i class="icon icon-search"></i></a>
							{{END IF}}
							{{IF $status == "nie_wyslany"}}
							<a class="btn btn-success tip-top" href="javascript: sendReport({{$id}});" title="{{$etykieta_wyslij}}"><i class="icon icon-envelope-alt"></i></a>
							<a class="btn btn-success tip-top" href="javascript: addDiscount({{$id}});" title="{{$etykieta_dodaj_rabat}}"><i class="icon icon-envelope"></i></a>
							<a class="btn btn-warning tip-top" href="javascript: addDescription({{$id}});" title="{{$etykieta_add_description}}"><i class="icon icon-comment-alt"></i></a>
							<a class="btn btn-info tip-top" href="javascript: modalIFrame('{{$podglad_url}}');" title="{{$etykieta_podglad}}"><i class="icon icon-search"></i></a>
							<a class="btn tip-top" href="{{$edytuj_url}}" title="{{$etykieta_edytuj}}"><i class="icon icon-edit"></i></a>
							{{END IF}}
							</div>
						</td>
					</tr>
					{{END}}
				</tbody>
				{{END}}
				{{UNLESS $sa_wiersze}}
				<tr><td colspan="7" style="text-align: center">{{$etykieta_brak_raportow}}</td></tr>
				{{END UNLESS}}
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	
	$(document).on('click', '#wyslijFakturaPrywatna',function(){	sendReport($('input[name=idRaportu]').val()); return false; });
	
	function undoReport(id)
	{
		$('.close').click();
		$('.mobile-loader').fadeIn("normal");
		$.ajax({
			url: '{{$url_ajax_undo}}',
			type: 'POST',
			dataType: 'json',
			data: {id: id},
			async: true,
			success: function(dane) {
				if (dane.success == 1)
				{
					$('#daneRaportow').replaceWith(dane.html);
					$('.tip-top').tooltip({ placement: 'top' });
					updatePossiblePrice();
				}
				$('#komunikatyBlok').html(dane.komunikaty);
				$('.mobile-loader').fadeOut("normal");
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var error = 'Undo report status: '+xhr.status;
				if (thrownError != '') 
				{
					error += ', with error: '+thrownError;
				}
				alertModal('AJAX request error' ,error);
				$('.mobile-loader').fadeOut("normal");
			}
		});
	}
	
	function addDescription(id)
	{
		$('.mobile-loader').fadeIn("normal");
		$.ajax({
			url: '{{$url_ajax_add_description}}',
			type: 'POST',
			dataType: 'json',
			data: {id: id, raport: 1},
			async: true,
			success: function(dane) {
				
				if(dane.kod == 1)
				{
					$('#oknoModalne .modal-body').html(dane.html);
					$('#oknoModalne').modal('show');
					$('#oknoModalne .modal-body, #oknoModalne .modal-body iframe html').css('background', 'none');
					dopasujModala();
				}
				$('#komunikatyBlok').html(dane.komunikaty);
				$('.mobile-loader').fadeOut("normal");
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var error = 'Send private order status: '+xhr.status;
				if (thrownError != '') 
				{
					error += ', with error: '+thrownError;
				}
				alertModal('AJAX request error' ,error);
				$('.mobile-loader').fadeOut("normal");
			}
		});
	}
	
	function addDiscount(id)
	{
		modalAjax('{{$url_ajax_dodaj_rabat}}'+'&id='+id);
	}
	
	function sendReport(id)
	{
		var rodzaj_rabatu = null;
		var produktyRabat = {};
		if($('#dodajRabat').is(':checked'))
		{
			$('#produkty_rabat .item').each(function(){
				var id = $(this).attr('id').replace('id_', '');
				produktyRabat[id] = {};
				produktyRabat[id]['rabat'] = $(this).find('.rabat_rabat').val();
				produktyRabat[id]['kwota_po_rabacie'] = $(this).find('.rabat_kwota_po_rabacie').val();
				
			});
			rodzaj_rabatu = $('input[name=rabat_rabat_rodzaj]:checked').val();
		}
		
		var data = {
			id: id,
			rodzaj_rabatu: rodzaj_rabatu,
			produkty: produktyRabat,
		}
		
		$('.mobile-loader').fadeIn("normal");
		$.ajax({
			url: '{{$url_ajax_send}}',
			type: 'POST',
			dataType: 'json',
			data: data,
			async: true,
			success: function(dane) {
				if (dane.success)
				{
					$('#daneRaportow').replaceWith(dane.html);
					$('.tip-top').tooltip({ placement: 'top' });
					updatePossiblePrice();
				}
				$('#komunikatyBlok').html(dane.komunikaty);
				$('.mobile-loader').fadeOut("normal");
				$('#oknoModalne').find('.close').click();
				$('#oknoModalne').find('#formularz').remove();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var error = 'Send report status: '+xhr.status;
				if (thrownError != '') 
				{
					error += ', with error: '+thrownError;
				}
				alertModal('AJAX request error' ,error);
				$('.mobile-loader').fadeOut("normal");
			}
		});
	}
	
</script>
{{END}}

{{BEGIN blokProjektow}}
<div class="widget-box collapsible prepareFaktura">
	<div class="formularz_grid">
		<form id="live-search" class="form-inline" action="" method="post" name="live-search" enctype="multipart/form-data">
			<ul>
				<li>
					<a class="btn btn-primary" style="background:#f98163;" id="ostatniaFaktura">{{$pokazOstatniaFaktura}}</a>
					<a class="btn btn-primary" style="background:#4bc69b;" id="pokazOstatnioOgladanyProjekt" >{{$pokazOstatnioOgladanyProjekt}}</a>
				</li>
				<li>
					<label for="filter" class="input_ok ">{{$szukajProjektEtykieta}} </label>
					<span class="formularz_opis"></span>
					<input type="text" style="width:500px;" name="filter" id="filter" value=""  autocomplete="off" class="long" />
					<button class="btn btn-default" id="czyscWyniki" style="display: none;">{{$czyscWynikiEtykieta}}</button>
					<div id="filter-count" class="no-shadow">{{$znaleziono_zamowien}} {{$iloscProjektow}}</div>
				</li>
				
			</ul>
		</form>
		
	</div>
	<div class="clear"></div>
	<div class="widget-title">
		<a href="#collapseProjects" data-toggle="collapse" class="">
			<span class="icon"><i class="icon-crop"></i></span>
			<h5>{{$tytul}}</h5>
		</a>
	</div>
	<div style="height: auto;" class="in" id="collapseProjects">
		<div class="widget-content nopadding">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>{{$etykieta_nazwa}}</th>
						<th>{{$etykieta_data_od}}</th>
						<th>{{$etykieta_data_do}}</th>
						<th>{{$etykieta_cena}}</th>
						<th>{{$etykieta_status}}</th>
						<th><i class="icon  icon-ellipsis-horizontal"></i></th>
					</tr>
				</thead>
				{{BEGIN wiersze}}
				<tbody id="daneProjektow">
					{{BEGIN wiersz}}
					<tr class="{{$klasa}}" id="tr-{{$id}}" >
						<td><a href="{{$payoutUrl}}" onclick="modalAjax(this.href); return false" title="{{$etykieta_edytuj}}">{{$nazwa}}</a></td>
						<td>{{$data_od}}</td>
						<td>{{$data_do}}</td>
						<td>{{$cena_wyslana}}/<strong>{{$cena}}</strong> ({{$procent}}%)</td>
						<td>{{$data_faktury}} <small>{{$status_tekst}}</small></td>
						<td>
							<div class="btn-group">
							{{IF $pokazWykonane}}
							<button class="btn btn-info tip-top" onclick="przywrocProjektConfirm({{$id}});" title="{{$etykieta_przywroc_projekt}}"><i class="icon icon-repeat"></i></button>
							{{ELSE}}
							{{IF $status == 'zafakturowany'}}
							<a class="btn btn-info tip-top" href="javascript: modalIFrame('{{$url_podglad_faktury}}');" title="{{$etykieta_pokaz}}"><i class="icon icon-search"></i></a>
							{{ELSE}}
							<a class="btn tip-top" href="{{$payoutUrl}}" onclick="modalAjax(this.href); return false" title="{{$etykieta_edytuj}}"><i class="icon icon-edit"></i></a>
							<a class="btn btn-success tip-top hidden" href="javascript: sendProject({{$id}});" title="{{$etykieta_wyslij}}"><i class="icon icon-envelope-alt"></i></a>
							<a class="btn btn-info tip-top" href="{{$podglad_url}}" onclick="modalAjax(this.href); return false;" title="{{$etykieta_podglad}}"><i class="icon icon-search"></i></a>
							<a class="btn btn-danger tip-top" id="usun_z_listy_{{$id}}" href="javascript: deleteFromListConfirm({{$id}});" title="{{$etykieta_usun_z_listy}}" ><i class="icon icon-remove-sign"></i></a>
							{{END IF}}
							{{END}}
							</div>
						</td>
					</tr>
					{{END}}
				</tbody>
				{{END}}
				{{UNLESS $sa_wiersze}}
				<tr><td colspan="6" style="text-align: center">{{$etykieta_brak_projektow}}</td></tr>
				{{END UNLESS}}
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		$(document).on('click', '.ui-spinner-button', function(){
			setTimeout(function(){
				pokazChowajButton();
			}, 201);
		});
		$('a[data-original-title="Payout"]').on('click', function(e){
			$('#daneProjektow > tr').removeClass('ostatnioPrzegladana');
			$(this).parents('tr').addClass('ostatnioPrzegladana');
			$('html, body').animate({
					scrollTop: $(".ostatnioPrzegladana").offset().top
			  }, 1500);
		});
		$('a[data-original-title="Preview project"]').on('click', function(e){
			$('#daneProjektow > tr').removeClass('ostatnioPrzegladana');
			$(this).parents('tr').addClass('ostatnioPrzegladana');
			e.preventDefault();
			return false;
		});
		$('#ostatniaFaktura').on('click', function(){
			$('html, body').animate({
					scrollTop: $(".ostatniaFaktura").offset().top
			  }, 1500);
			  
			  return false;
		});
		
		$('#pokazOstatnioOgladanyProjekt').on('click', function(){
			
			$('html, body').animate({
					scrollTop: $(".ostatnioPrzegladana").offset().top
			  }, 1500);
			  
			  return false;
		});
		
		$('#czyscWyniki').on('click', function(){
			$("#filter").val('').keyup();
			return false;
		});
		
		$("#filter").keyup(function(){
			
				var filter = $.trim($(this).val()), count = 0;
				if( ! $('#czyscWyniki').is('is:visible') && filter.length > 0)
				{
					$('#czyscWyniki').show();
				}
				if(filter.length == 0)
				{
					$('#czyscWyniki').hide();
				}
				$("#daneProjektow tr ").each(function(){
					if($(this).text().search(new RegExp(filter, "i")) < 0)
					{
						$(this).fadeOut();
					}
					else
					{
						$(this).show();
						count++;
					}
				});
				
				var numberItems = count;
				
				$("#filter-count").text("{{$znaleziono_zamowien}}"+count);
		   });
	});
	
	function przywrocProjektConfirm(id)
	{
		potwierdzenieModal1("{{$przywroc_projekt_alert_tresc}}" ,"{{$przywroc_projekt_alert_naglowek}}" , "przywrocProjekt("+id+")");
	}
	
	
	function pokazChowajButton()
	{
		if ($('#dodatkowoWartosc').html() != '')
		{
			$('#sendProjectButton').fadeIn("normal");
		}
		else
		{
			$('#sendProjectButton').fadeOut("fast");
		}
	}
	
	function przywrocProjekt(id)
	{
		$.ajax({
			url: '{{$url_ajax_przywroc_projekt}}',
			type: 'POST',
			dataType: 'json',
			data: {id: id},
			async: true,
			success: function(dane) {
				if (dane.success)
				{
					$('#tr-'+id).hide();
					updatePossiblePrice();
				}
				$('.modal-header').children('.close').click();
				$('#komunikatyBlok').html(dane.komunikaty);
				$('html, body').animate({ scrollTop: 0 }, 1000);
				
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var error = 'Remove project from list failed:  '+xhr.status;
				if (thrownError != '') 
				{
					error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
					error += xhr.responseText;
				}
				alertModal('AJAX request error' ,error);
				$('.mobile-loader').fadeOut("normal");
				toggleOverlay();
			}
		});
	}
	
	function undoInvoiceConfirm(id)
	{
		potwierdzenieModal1("{{$etykieta_potwierdz_cofnij}}" ,"{{$delete_from_list_alert_naglowek}}" , "undoInvoice("+id+")");
		return false;
	}
	
	function deleteFromListConfirm(id)
	{
		potwierdzenieModal1("{{$delete_from_list_alert_tresc}}" ,"{{$delete_from_list_alert_naglowek}}" , "deleteFromList("+id+")");
	}
	
	function deleteFromList(id)
	{
		$.ajax({
			url: '{{$url_ajax_usun_z_listy}}',
			type: 'POST',
			dataType: 'json',
			data: {id: id},
			async: true,
			success: function(dane) {
				if (dane.success)
				{
					$('#tr-'+id).hide();
					updatePossiblePrice();
				}
				$('#komunikatyBlok').html(dane.komunikaty);
				$('.modal-header').children('.close').click();
				$('html, body').animate({ scrollTop: 0 }, 1000);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var error = 'Remove project from list failed:  '+xhr.status;
				if (thrownError != '') 
				{
					error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
					error += xhr.responseText;
				}
				alertModal('AJAX request error' ,error);
				$('.mobile-loader').fadeOut("normal");
				toggleOverlay();
			}
		});
	}
	
	function sendProject(id)
	{
		var produkty = {};
		$('.mobile-loader').fadeIn("normal");
		$('#formularz .nst .item').each(function(){
			var id = $(this).find('.hiddenId').val();
			produkty[id] = {
				id: id,
				nazwa: $(this).find('.hiddenNazwa').val(),
				kategoria: $(this).find('.produkt_kategoria option:selected').val(),
				ilosc: $(this).find('.quantity').val(),
				cena: $(this).find('.ceny.price').val(),
				procent_wykonania: $(this).find('.procent_wykonania').attr('aria-valuenow'),
				procent_wykonania_wczesniej: $(this).find('.procent_wykonania').attr('aria-valuemin'),
				vat: $(this).find('.vat').val(),
			};
		});
		
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
		
		$.ajax({
			url: '{{$url_ajax_send_project}}',
			type: 'POST',
			dataType: 'json',
			data: {
				produkty: produkty,
				fakturaTitle: $('#fakturaTitle').val(),
				opis: $('#opis').val(),
				id: id,
				rodzaj_rabatu: rodzaj_rabatu
			},
			async: true,
			success: function(dane) {
				if (dane.success)
				{
					$('#daneProjektow').replaceWith(dane.html);
					$('.tip-top').tooltip({ placement: 'top' });
					updatePossiblePrice();
				}
				$('#komunikatyBlok').html(dane.komunikaty);
				$('.close').click();
				$('.mobile-loader').fadeOut("normal");
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var error = 'Send project to invoicing failed:  '+xhr.status;
				if (thrownError != '') 
				{
					error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
					error += xhr.responseText;
				}
				alertModal('AJAX request error' ,error);
				$('.mobile-loader').fadeOut("normal");
				toggleOverlay();
			}
		});
	}
	
	function updateBlock(block, pokazWykonane)
	{
		pokazWykonane = pokazWykonane || 0;
		
		$.ajax({
			url: '{{$url_ajax_update_block}}',
			type: 'POST',
			dataType: 'json',
			data: {blok: block, pokazWykonane:pokazWykonane},
			async: true,
			success: function(dane) {
				if (dane.success)
				{
					$('#'+dane.block).replaceWith(dane.html);
					$('.tip-top').tooltip({ placement: 'top' });
					updatePossiblePrice();
				}
				$('#komunikatyBlok').html(dane.komunikaty);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var error = 'Update projects list failed: '+xhr.status;
				if (thrownError != '') 
				{
					error += ', with error: '+thrownError;
				}
				alertModal('AJAX request error' ,error);
				toggleOverlay();
			}
		});
	}
	
	function undoInvoice(id)
	{
		$.ajax({
			url: '{{$url_ajax_edit_payout}}',
			type: 'GET',
			dataType: 'json',
			data: {idFaktury: id, undo: 1},
			async: true,
			success: function(dane) {
				if (dane.success)
				{	
					$('.tip-top').tooltip({ placement: 'top' });
					updateBlock('projekty');
				}
				else
				{
					$('html, body').animate({ scrollTop: 0 }, 500);
				}
				$('.modal-header').children('.close').click();
				$('#komunikatyBlok').html(dane.komunikaty);
				
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var error = 'Undo invoice: '+xhr.status;
				if (thrownError != '') 
				{
					error += ', with error: '+thrownError;
				}
				alertModal('AJAX request error' ,error);
			}
		});
	}
	
	function closeEdit()
	{
		$('.close').click();
	}
</script>
{{END}}

{{BEGIN blokEdycjiProjektu}}

<div class="widokZamowien opened editWindow">
<div class="portlet zamowienie">
	<div style="background: #FFFAFA" class="zamowienie-naglowek">
		<div class="box-naglowek">
			<span class="label label-info">{{$identyfikator}}</span> {{$order_type}}
		</div>
		<div class="box-naglowek name">
			<i class="icon-quote-left"></i> {{$project_name}}
		</div>
		<div class="clear"></div>
	</div>
	<div class="zamowienie-opis">
		<div class="pozycja">
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="icon-user"></i>
					</span>
					<h5>{{$etykieta_liderzy}}</h5>
				</div>
				<div class="widget-content nopadding">
					<table class="table table-bordered table-striped table-hover" width="100%">
						<tbody>
							<tr>
								<td>{{$etykieta_lider_get}}</td>
								<td><strong>{{$lider_get}}</strong></th>
							</tr>
							<tr>
								<td>{{$etykieta_lider_bkt}}</td>
								<td><strong>{{$lider_bkt}}</strong></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
		<div class="opis">
			<div class="formularz">
				{{$form}}
			</div>
		</div>
		<div class="clear"></div>
		<p class="buttons">
			<a style="display: none" id="sendProjectButton" class="btn btn-large btn-success right margin" href="javascript: sendProject({{$id}});">{{$etykieta_send_project}}</a>
			<a class="btn right margin" href="javascript: closeEdit();">{{$etykieta_anuluj_edycja_projektu}}</a>
			<div class="clear"></div>
		</p>
			{{BEGIN historiaFakturowania}}
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="icon-dollar"></i>
					</span>
					<h5>{{$etykieta_historia_fakturowania}}</h5>
					<span title="" class="label label-info tip-left">
						{{$ilosc_faktur}}
					</span>
				</div>
				<div class="widget-content nopadding">
					<ul class="recent-comments faktury">
						<li>
							<table width="100%" class="table table-bordered table-striped table-hover">
								<tr>
									<th width="5%">#</th>
									<th width="15%">{{$etykieta_numer}}</th>
									<th width="15%">{{$etykieta_data}}</th>
									<th width="15%">{{$etykieta_netto}}</th>
									<th width="15%">{{$etykieta_podatek}}</th>
									<th width="15%">{{$etykieta_brutto}}</th>
									<th>{{$etykieta_procent_calosci}}</th>
									<th width="5%"><i class="icon  icon-ellipsis-horizontal"></i></th>
								</tr>
							</table>
						</li>
						{{BEGIN faktura}}
						<li class="{{$klasa}}">
							<table width="100%" class="table table-bordered table-striped table-hover">
									<tr {{UNLESS $fakturaDziecko}}class="naglowek_faktury"{{END}}>
										<td width="5%">{{IF $fakturaDziecko}}<i class="icon icon-minus"></i>{{ELSE}}{{$lp}}.{{END}}</td>
										<td width="15%">{{$numer}}</td>
										<td width="15%">{{$data}}</td>
										<td width="15%">{{$netto}}</td>
										<td width="15%">{{$podatek}}</td>
										<td width="15%">{{$brutto}}</td>
										<td>{{UNLESS $fakturaDziecko}}{{$procent_calosci}}%{{END}}</td>
										<td width="5%">
											{{IF $klasa == 'pending'}}
											<!-- <a class="btn btn-danger tip-top" onclick="return potwierdzenieUsun('{{$etykieta_potwierdz_cofnij}}', $(this));" href="javascript: undoInvoice({{$id}});" title="{{$etykieta_cofnij}}"><i class="icon icon-undo"></i></a> -->
											<a class="btn btn-danger tip-top" onclick="undoInvoiceConfirm('{{$id}}'); return false;" title="{{$etykieta_cofnij}}"><i class="icon icon-undo"></i></a>
											{{END IF}}
											{{IF $klasa == ''}}
											<a class="btn btn-info tip-top" href="javascript: modalIFrame('{{$url_podglad_faktury}}');" title="{{$etykieta_pokaz}}"><i class="icon icon-search"></i></a>
											{{END IF}}
											{{IF $klasa == 'pending no-undo'}}
											<a onclick="wystawFakture(this); $('.close').click(); return false;" klucz="wystawFaktura" target="_self" href="{{$url_wystaw}}" class="btn tip-top btn-success" title="{{$etykieta_wystaw}}"><i class="icon-paste"></i></a>
											{{END IF}}
										</td>
									</tr>
									<tr class="bottom">
										<td>&nbsp;</td>
										<td colspan="7">
											<table width="100%" class="table table-bordered table-striped table-hover produkty">
												<!--
												<tr>
													<th width="10%">#</th>
													<th width="60%">{{$etykieta_produkt}}</th>
													<th width="3%">{{$etykieta_procent}}</th>
													<th width="9%">{{$etykieta_kwota_netto}}</th>
													<th width="9%">{{$etykieta_kwota_podatku}}</th>
													<th>{{$etykieta_kwota_brutto}}</th>
												</tr>
												-->
												{{BEGIN pozycja}}
												<tr>
													<td width="5%" style="text-align: center">{{$_num}}.</td>
													<td style="width: 26.6%" >{{IF $kreditnota_zmniejszajaca}}<span class="label label-danger"><i class="icon icon-minus-sign"></i></span>{{END}} {{$produkt}}</td>
													<td style="width:15.7%;" >{{$kwota_netto}}</td>
													<td style="width:15.8%;" >{{$kwota_podatku}}</td>
													<td style="width:15.8%;" >{{$kwota_brutto}}</td>
													<td>{{$procent}}</td>
												</tr>
												{{END}}
											</table>
										</td>
									</tr>
								
							</table>
						</li>
						{{END}}
					</ul>
				</div>
			</div>
			{{END}}
	</div>
</div>
<div class="clear"></div>
</div>
<script>
	$(document).ready(function(){
		$('#dodajRabat').uniform();
		$('#dodajRabat').on('click', function(){ pokazUkryjRabat(); });
		
		$('.ui-spinner-button').on('mouseup', function(){
			
			var rodzic = $(this).parents('li');
			setTimeout(function(){
				var id = rodzic.find('.hiddenId').val();
				var total = rodzic.find('.hiddenCenaTmp').val().replace(',', '');
				var totalNowy = rodzic.find('.sum_total_price').val().replace(' ', '');
				var kwotaDoRabat = (parseFloat(totalNowy) - parseFloat(total));
				
				$('#id_'+id).find('.rabat_cena').val(kwotaDoRabat);
				$('.rabat_rabat').keyup();
			}, 100);
			
		});
	});
	
	function pokazUkryjRabat()
	{
		var rabatCheckbox = $('#dodajRabat');
		
		if(rabatCheckbox.is(':checked'))
		{
			$('.region_zamkniety').show(500);
		}
		else
		{
			$('.region_zamkniety').hide(500);
		}
	}
</script>
{{END}}

{{BEGIN blokZamowienPrywatnych}}
<div class="widget-box collapsible prepareFaktura">
	<div class="widget-title">
		<a href="#collapsePrivateOrders" data-toggle="collapse" class="">
			<span class="icon"><i class="icon-home"></i></span>
			<h5>{{$tytul}}</h5>
		</a>
	</div>
	<div style="height: auto;" class="in" id="collapsePrivateOrders">
		<div class="widget-content nopadding">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>{{$etykieta_nazwa}}</th>
						<th>{{$etykieta_klient}}</th>
						<th>{{$etykieta_data_zakonczenia}}</th>
						<th>{{$etykieta_cena}}</th>
						<th>{{$etykieta_status}}</th>
						<th><i class="icon  icon-ellipsis-horizontal"></i></th>
					</tr>
				</thead>
				{{BEGIN wiersze}}
				<tbody id="daneZamowienPrywatnych">
					{{BEGIN wiersz}}
					<tr class="{{$klasa}}">
						<td>{{$nazwa}}</td>
						<td>{{$klient}}</td>
						<td>{{$data_zakonczenia}}</td>
						<td class="price"><strong>{{$cena}}</strong></td>
						<td>{{$status_tekst}}</td>
						<td>
							<div class="btn-group">
							{{IF $status == 'wyslany'}}
							<a class="btn btn-danger tip-top" onclick="return potwierdzenieUsun('{{$etykieta_potwierdz_cofnij}}', $(this))" href="javascript: undoPrivateOrder({{$id}});" title="{{$etykieta_cofnij}}"><i class="icon icon-undo"></i></a>
							{{END IF}}
							{{IF $status == 'zafakturowany'}}
							<a class="btn btn-info tip-top" href="javascript: preview({{$id}});" title="{{$etykieta_podglad}}"><i class="icon icon-search"></i></a>
							{{END IF}}
							{{IF $status == "nie_wyslany"}}
							<a class="btn btn-success tip-top" href="javascript: sendPrivateOrder({{$id}});" title="{{$etykieta_wyslij}}"><i class="icon icon-envelope-alt"></i></a>
							<a class="btn btn-success tip-top" href="javascript: sendPrivateOrderView({{$id}});" title="{{$etykieta_dodaj_rabat}}"><i class="icon icon-envelope"></i></a>
							<a class="btn btn-warning tip-top" href="javascript: addDescription({{$id}});" title="{{$etykieta_add_description}}"><i class="icon icon-comment-alt"></i></a>
							<a class="btn btn-info tip-top" href="{{$podglad_url}}" onclick="modalAjax(this.href); return false;" title="{{$etykieta_podglad}}"><i class="icon icon-search"></i></a>
							<a class="btn tip-top" href="{{$edytuj_url}}" title="{{$etykieta_edytuj}}"><i class="icon icon-edit"></i></a>
							{{END IF}}
							</div>
						</td>
					</tr>
					{{END}}
				</tbody>
				{{END}}
				{{UNLESS $sa_wiersze}}
				<tr><td colspan="6" style="text-align: center">{{$etykieta_brak_zamowien}}</td></tr>
				{{END UNLESS}}
			</table>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(document).ready(function(){
		
		$(document).on('click', '#wyslijFakturaPrywatna',function(){	sendPrivateOrder($('input[name=idZamowienia]').val()); return false; });
		
		$('#dodajOpis').live('submit', function(){
			
			$.ajax({
				url: $(this).attr('action'),
				type: 'POST',
				dataType: 'json',
				data: $(this).serialize(),
				success: function(dane) {
					if (dane.kod == 1)
					{
						$('.close').click();
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					var error = 'Send private order status: '+xhr.status;
					if (thrownError != '') 
					{
						error += ', with error: '+thrownError;
					}
					alertModal('AJAX request error' ,error);
					
				}
			});
			return false;
		})
	});
	
	
	function undoPrivateOrder(id)
	{
		$('.close').click();
		$('.mobile-loader').fadeIn("normal");
		$.ajax({
			url: '{{$url_ajax_undo}}',
			type: 'POST',
			dataType: 'json',
			data: {id: id},
			async: true,
			success: function(dane) {
				if (dane.success == 1)
				{
					$('#daneZamowienPrywatnych').replaceWith(dane.html);
					$('.tip-top').tooltip({ placement: 'top' });
					updatePossiblePrice();
				}
				$('#komunikatyBlok').html(dane.komunikaty);
				$('.mobile-loader').fadeOut("normal");
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var error = 'Undo private order status: '+xhr.status;
				if (thrownError != '') 
				{
					error += ', with error: '+thrownError;
				}
				alertModal('AJAX request error' ,error);
				$('.mobile-loader').fadeOut("normal");
			}
		});
	}
	
	function addDescription(id)
	{
		$('.mobile-loader').fadeIn("normal");
		$.ajax({
			url: '{{$url_ajax_add_description}}',
			type: 'POST',
			dataType: 'json',
			data: {id: id},
			async: true,
			success: function(dane) {
				
				if(dane.kod == 1)
				{
					$('#oknoModalne .modal-body').html(dane.html);
					$('#oknoModalne').modal('show');
					$('#oknoModalne .modal-body, #oknoModalne .modal-body iframe html').css('background', 'none');
					dopasujModala();
				}
				$('#komunikatyBlok').html(dane.komunikaty);
				$('.mobile-loader').fadeOut("normal");
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var error = 'Send private order status: '+xhr.status;
				if (thrownError != '') 
				{
					error += ', with error: '+thrownError;
				}
				alertModal('AJAX request error' ,error);
				$('.mobile-loader').fadeOut("normal");
			}
		});
	}
	
	function sendPrivateOrderView(id)
	{
		modalAjax('{{$url_ajax_dodaj_rabat}}'+'&id='+id);
	}
	
	function sendPrivateOrder(id)
	{
		var rodzaj_rabatu = null;
		var produktyRabat = {};
		if($('#dodajRabat').is(':checked'))
		{
			$('#produkty_rabat .item').each(function(){
				var id = $(this).attr('id').replace('id_', '');
				produktyRabat[id] = {};
				produktyRabat[id]['rabat'] = $(this).find('.rabat_rabat').val();
				produktyRabat[id]['kwota_po_rabacie'] = $(this).find('.rabat_kwota_po_rabacie').val();
				
			});
			rodzaj_rabatu = $('input[name=rabat_rabat_rodzaj]:checked').val();
		}
		
		var data = {
			id: id,
			description: $('#opis').val(),
			rodzaj_rabatu: rodzaj_rabatu,
			produkty: produktyRabat,
		}
		
		$('.mobile-loader').fadeIn("normal");
		$.ajax({
			url: '{{$url_ajax_send}}',
			type: 'POST',
			dataType: 'json',
			data: data,
			async: true,
			success: function(dane) {
				if (dane.success)
				{
						$('#daneZamowienPrywatnych').replaceWith(dane.html);
						$('.tip-top').tooltip({ placement: 'top' });
						updatePossiblePrice();
						$('.close').click();
				}
				$('#komunikatyBlok').html(dane.komunikaty);
				$('.mobile-loader').fadeOut("normal");
				$('#oknoModalne').find('.close').click();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var error = 'Send private order status: '+xhr.status;
				if (thrownError != '') 
				{
					error += ', with error: '+thrownError;
				}
				alertModal('AJAX request error' ,error);
				$('.mobile-loader').fadeOut("normal");
			}
		});
	}
	
</script>
</script>
{{END}}

{{BEGIN blokPodsumowania}}
<div class="widget-box collapsible">
	<div class="widget-title">
		<a href="#collapseOne" data-toggle="collapse" class="">
			<span class="icon"><i class="icon-dashboard"></i></span>
			<h5>{{$tytul}}</h5>
		</a>
	</div>
	<div style="height: auto;" class="in" id="collapseOne">
		<div class="widget-content nopadding">
			<table class="table table-striped table-bordered">
				<thead>
					<tr>
						<th>{{$etykieta_nazwa}}</th>
						<th>{{$etykieta_klient}}</th>
						<th>{{$etykieta_data_zakonczenia}}</th>
						<th>{{$etykieta_cena}}</th>
						<th>{{$etykieta_status}}</th>
						<th><i class="icon  icon-ellipsis-horizontal"></i></th>
					</tr>
				</thead>
				<tbody id="daneRaportow">
					{{BEGIN wiersz}}
					<tr class="{{$klasa}}">
						<td>{{$nazwa}}</td>
						<td>{{$klient}}</td>
						<td>{{$data_zakonczenia}}</td>
						<td><strong>{{$cena}}</strong></td>
						<td>{{$status}}</td>
						<td>{{$przyciski}}</td>
					</tr>
					{{END}}
				</tbody>
			</table>
		</div>
	</div>
</div>
{{END}}

{{BEGIN dodajOpis}}
{{$form}}
{{END}}
{{BEGIN dodajRabat}}
<script>
	$(document).ready(function(){
		$('#dodajRabat').on('click', function(){ pokazUkryjRabat(); });
	});
	function pokazUkryjRabat()
	{
		var rabatCheckbox = $('#dodajRabat');
		
		if(rabatCheckbox.is(':checked'))
		{
			$('#rabat').show(500);
		}
		else
		{
			$('#rabat').hide(500);
		}
	}
</script>
{{$form}}
{{END}}