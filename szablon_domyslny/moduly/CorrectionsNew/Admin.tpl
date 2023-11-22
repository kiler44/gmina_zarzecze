{{BEGIN listaKontener}}
	{{BEGIN elementListy}}
	<div id="{{id}}" class="slidingSpaces widokZamowien opened"></div>
	{{END}}
{{END}}
{{BEGIN listaAjax}}

	{{BEGIN elementListy}}
	{{BEGIN naglowek}}<div class="correctionsListaOgloszenNaglowek"><strong>{{$data}}</strong></div>{{END}}
		<li id="li-{{$id_order}}" ferroId="{{$i}}" class="{{IF $checked}}checked{{END}}{{IF $_first}} first{{END}}{{IF $_last}} last{{END}} element" >{{IF $przekroczonyCzas}}<div class="right"><span class="label label-danger"><i class="icon icon-exclamation-sign"></i></span></div>{{END IF}}<a href="javascript:slideTo('{{$id_order}}');">{{$order_name}}</a></li>
	{{END}}

{{END}}
{{BEGIN index}}
	<div id="correctionsContainer">
		<div class="widget-box inside">
			<div class="widget-title">
				<ul class="nav nav-tabs">
					{{BEGIN zakladka}}
					<li {{IF $active}}class="active"{{END}}>
						<a href="{{$url}}" name="{{$etykieta}}" class="">{{$etykieta}}</a>
					</li>
					{{END}}
				</ul>
			</div>
		</div>
		<div class="padding-sides">
			<div class="left">
				{{$form}}
			</div>
			<div class="left">
				<div class="widget-box" style="height:38px;">
					<div class="widget-content nopadding">
						<div style="margin-bottom: 0;" id="filtry" name="filtry" class="form-horizontal " >
							<div class="control-group input_ok" style="width:320px; margin-top:-6px; float: left;">
								<label class="control-label input_ok " style="width: 100px;">Search phrase:</label>
								<div class="controls " style="margin-left:120px;">
									<div class="input-append" style="width:200px;">
										<input type="text" placeholder="Enter at least 3 characters" autocomplete="off" name="fraza" id="fraza" />
										<span class="add-on">
											<i class="icon-search"></i>
										</span>
									</div>
								</div>
							</div>
							<div class="control-group input_ok" style="width:150px; margin-top:-6px; float: left;">
								<label class="control-label input_ok " style="width: 40px;">Team:</label>
								<div class="controls " style="margin-left:60px; width:100px;">
									<select name="team" id="team" >
										<option value="0">select</option>
										{{BEGIN option}}
											<option value="{{$idTeam}}">{{$nazwa}}</option>
										{{END}}
									</select>
								</div>
							</div>
							<div class="control-group input_ok" style="width:270px; margin-top:-6px; float: left;">
								<label class="control-label input_ok " style="width: 40px;">User:</label>
								<div class="controls " style="margin-left:60px; width:100px;">
									<select name="user" id="user" >
										<option value="0">select</option>
										{{BEGIN optionUser}}
											<option value="{{$idUser}}">{{$nazwa}}</option>
										{{END}}
									</select>
								</div>
							</div>
							<div class="control-group input_ok" style="width:100px; margin-top:-6px; float: left;">
								<label class="control-label input_ok " style="width: 55px;">Archive:</label>
								<div class="controls " style="margin-left:65px; width:30px; margin-top:3px;">
									 <input type='checkbox' name='archiwum' id='archiwum' />
								</div>
							</div>
							<input id="czyscAjax" name="czyscAjax" value="Reset" class="btn" style="margin:3px 6px 0px 0px" type="button">
						</div>
					</div>
				</div>
			</div>
			<div class="left">
				<ul class="stat-boxes">
					<li id="ord_counter"><div class="left"><i class="icon icon-certificate"></i> <small>{{$etykieta_orders_counter}}</small></div><div class="right"><strong>0</strong> / <span>0</span></div></li>
					<li id="money_counter" class="hidden"><div class="left"><i class="icon icon-money"></i> <small>{{$etykieta_money_counter}}</small></div><div class="right no-margin"><span>{{$etykieta_waluta}} </span> <p>{{$etykieta_money_checked}}<br/><strong id="total_price_checked">0</strong> <strong>{{$etykieta_kwota_znaczek}}</strong></p> <strong id="total_price">0</strong> <strong>{{$etykieta_kwota_znaczek}}</strong></div></li>
				</ul>
			</div>
			{{IF $iloscWynikow}}
				<script src="/_system/_biblioteki/jquery.transit.min.js" type="text/javascript"></script>
				<script src="/_system/_biblioteki/jquery.ferro.ferroSlider-2.3.3.min.js" type="text/javascript"></script>
				<div class="right margin-bottom margin" >
					{{IF $pomin_raport}}
					<a href="javascript:sendToFaktura();" id="sendToFaktura" class="btn btn-large btn-info"><i class="icon icon-trophy"></i> {{$etykieta_wykonaj_fakturowanie}}</a>
					{{IF $wymus_wyswietla_wykonaj_raport}}
					<a href="javascript:makeReport();" id="makeReport" class="btn btn-large btn-info"><i class="icon icon-trophy"></i> {{$etykieta_wykonaj_raport}}</a>
					{{END}}
					{{ELSE}}
					<div class="btn-group margin-right"><a href="javascript:makeReport();" id="makeReport" class="btn btn-lg btn-info"><i class="icon icon-print"></i> {{$etykieta_wykonaj_raport}}</a> <a id="previewReport" class="btn btn-lg tip-bottom" title="{{$etykieta_podglad_raport}}"><i class="icon icon-laptop"></i></a></div>
					{{END}}
					{{IF $wyswietlaj_excel_raport}}
					<a href="javascript:makeReportExcel();" id="makeReportXls" class="btn btn-large btn-info"><i class="icon icon-trophy"></i> {{$etykieta_wykonaj_raport_xls}}</a>
					{{END IF}}
					<button onclick="$.fn.ferroSlider.slideToPrev()" class="btn btn-default btn-large"><i class="icon icon-arrow-left"></i></button>
					<button onclick="$.fn.ferroSlider.slideToNext()" class="btn btn-primary btn-large"><i class="icon icon-arrow-right"></i></button>
				</div>
				<div id="ordersLeftPane" class="widget-box no-margin">
					<div class="widget-title">
						<span class="icon"><i class="icon icon-briefcase"></i></span>
						<h5>{{$etykieta_lista_zamowien}}</h5>
					</div>
					<div class="widget-content">
						<ul id='listaCorrection' >
						{{BEGIN elementListy}}
						{{BEGIN naglowek}}<div class="correctionsListaOgloszenNaglowek"><strong>{{$data}}</strong></div>{{END}}
						<li id="li-{{$id_order}}" ferroId="{{$i}}" class="{{IF $checked}}checked{{END}}{{IF $_first}} first{{END}}{{IF $_last}} last{{END}} element" >{{IF $przekroczonyCzas}}<div class="right"><span class="label label-danger"><i class="icon icon-exclamation-sign"></i></span></div>{{END IF}}<a href="javascript:slideTo('{{$id_order}}');">{{$order_name}}</a></li>
						{{END}}
						</ul>
					</div>
				</div>
				<div id="ordersContainer">
					{{BEGIN elementListy}}
					<div id="{{$id_order}}" class="slidingSpaces widokZamowien opened{{IF $_first}} first{{END}}{{IF $_last}} last{{END}}"></div>
					{{END}}
				</div>
			{{END}}
		</div>
		<div class="clear"></div>
	</div>
	<div class="hidden"><div class="alert alert-warning clear margin notChargeAlert wzor">{{$notChargeAlert}}</div></div>

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
{{IF $cenyProduktow}}var ceny = new Array();{{END}}{{BEGIN cenyProduktow}}ceny[{{$id}}] = '{{$cena}}';{{END}}

{{IF $iloscWynikow}}
	var idType = '{{$idType}}';
	var idReport = {{$idReport}};
	var idOrder = {{$idOrder}};
	var startupErrors = {contentLoaded: false, priceRefreshed: false};
	var sprawdzonych = 0;
	var i = 0;
	var flagaWynikiOgraniczone = false;
	var rodzajFormularza = '{{$rodzajFormularza}}';
	$(document).on('click', ".usunZListy", function(e){ potwierdzenieModal1( "{{$usunZListyConfirm}}", 'Confirm', 'usunZListy('+$(this).attr('data-id')+')' ); });
	$(document).ready(function() {
		
		var dataOd = $('#dataOd').val();
		var dataDo = $('#dataDo').val();
		$('#fraza').keydown(function(e){
			var code = (e.keyCode ? e.keyCode : e.which);
			if(code == 13) { //Enter keycode
				e.preventDefault();
				return false;
			}
		});
		
		$('#dataOd').on('change', function(){
			if(szukajWArchiwum())
			{
				setTimeout(function(){
					szukaj($('#fraza').val(), $('#team').val());
				}, 500);
			}
		});
		
		$('#dataDo').on('change', function(){
			if(szukajWArchiwum())
			{
				setTimeout(function(){
					szukaj($('#fraza').val(), $('#team').val());
				}, 500);
			}
		});
		
		$('#archiwum').on('click', function(){
			if($(this).is(':checked'))
			{
				/*
				if(dataOd == $('#dataOd').val())
				{
					$('#dataOd').val('');
				}
				if(dataDo == $('#dataDo').val())
				{
					$('#dataDo').val('');
				}
				*/
				if(szukajWArchiwum()){ szukaj($('#fraza').val(), $('#team').val()); }
			}
			else
			{
				$('#dataOd').val(dataOd);
				$('#dataDo').val(dataDo);
				szukaj($('#fraza').val(), $('#team').val());
			}
			
		});
		
		$('#czyscAjax').on('click', function(){ 
			
			$('#fraza').val('');
			$("#team").select2('val','0');
			$("#user").select2('val','0');
			if($('#archiwum').is(':checked')){ $('#archiwum').click(); $.uniform.update();}
			$('#dataOd').val(dataOd);
			$('#dataDo').val(dataDo);
			
			szukaj(null, null); 
			
			$('#makeReport').show();
			$('#previewReport').show();
			
		});
		
		$('#team').on('change', function(){
			var idTeam = $(this).val();
			szukaj($('#fraza').val(), idTeam);
		});
		
		$('#user').on('change', function(){
			szukaj($('#fraza').val(), $('#team').val());
		});
		
		$('#fraza').delayKeyup(function(el){
			if(el.val().length > 2)
			{
				var idTeam = $('#team').val();
				szukaj(el.val(), idTeam);
			}
		}, 500);
		
		function szukaj(fraza, idTeam)
		{
			$('#makeReport').hide();
			$('#previewReport').hide();
			var user = $('#user').val();
			dane = {
				user: user,
				fraza: fraza, 
				idType: {{idType}},
				idTeam: idTeam,
				dataZakonczenia: $('#dataDo').val(),
				dataStart: $('#dataOd').val(),
				szukajWArchiwum: szukajWArchiwum(),
				flagaWynikiOgraniczone: flagaWynikiOgraniczone
		  }
		  ladujPreloader();
		  ajax("{{$urlSzukaj}}", listaWyszukiwania , dane, 'POST', 'json', false );
		}
		
		function listaWyszukiwania(dane)
		{
			$('.alert-error').hide(500);
			$('.alert-info').hide(500);
			
			$('#listaCorrection').html('');
			if(dane.html != '')
			{
				
				$('#ordersContainer').html('');
				$(".slidingSpaces").unbind().removeData();
				$('#listaCorrection').html(dane.html);
				$('#ordersContainer').html(dane.htmlKontenery);
			}
			else
			{
				$('#ordersContainer').html('');
				$('#ordersContainer').prepend(dane.komunikat);
				usunPreloader();
			}
			
			setTimeout(function(){
				$(".slidingSpaces").ferroSlider({
					container		: $('#ordersContainer'),
					time				: 700,
					easing			: 'in',
					//disableSwipe	: true,
					createSensibleAreas: true,
					preventArrowNavigation : true,
				});
			}, 500);
			
			if(dane.html != '')
			{
				setTimeout(function(){
					var id = $('#listaCorrection li:first').attr('id').replace('li-', '');
					slideTo(parseInt(id));
					$('body, html').width($('body').width()-19);
					usunPreloader();
				}, 700);
			}
				
			if(dane.przekroczonoIloscWynikow)
			{
				setTimeout(function(){
					$('.container-fluid').prepend(dane.komunikat);
					$('#dataOd').val(dane.dataZakonczeniaOd);
				}, 700);
				flagaWynikiOgraniczone = true;
			}
			if(typeof dane.dataZakonczeniaDo != 'undefined' && dane.dataZakonczeniaDo.length && dane.dataZakonczeniaDo != '')
			{
				$('#dataDo').val(dane.dataZakonczeniaDo);
			}
			
			setOrderCounter();
			getCurrentTotalPrice();
		}
		
		$(window).resize(function(){setHeightAfterChangingProducts(location.hash.replace('#-', ''));});
		setOrderCounter();
		
		$('#correctionsContainer form').addClass('no-focus');
		
		$(".slidingSpaces").ferroSlider({
			container		: $('#ordersContainer'),
			time				: 700,
			easing			: 'in',
			//disableSwipe	: true,
			createSensibleAreas: true,
			//preventArrowNavigation : true,
		});
		
		$(document).bind("startslide",function(){
			var id = $.event.moveTo.id.replace('#','');
			setupLayout(id, true);
			
			{{UNLESS $oznacz_sprawdzone_przyciskiem}}
				markAsChecked($.event.moveFrom.id.replace('#',''), 1, false);
			{{END}}
		});
		$(document).bind("endslide",function(){
			var id = $.event.moveTo.id.replace('#','');
			markActive(id);
		});
		
		$('body:not(.tablet), html').width($('body').width()-19);
		
		$('.add_button, .add_button_n, .remove, .remove_n, .item .ui-spinner-button').live('click', function(){updatePrice(); setTimeout(function(){setHeightAfterChangingProducts($.fn.ferroSlider.getActualSlideId().replace('#', ''));},15);});
		$('input[name^=produktyNiestandardowe]').live('keyup', function(){updatePrice();});
		
		$('.oznaczSprawdzony').live('click', function(){
			markAsChecked($.fn.ferroSlider.getActualSlideId().replace('#', '') , 1, true);
			$(this).attr('style', 'display:none');
			$(this).removeClass('block');
			$(this).next('a.usunSprawdzony').attr('style', 'display:block');
			$(this).next('a.usunSprawdzony').addClass('block');
		});
		$('.usunSprawdzony').live('click', function(){
			markAsChecked($.fn.ferroSlider.getActualSlideId().replace('#', '') , 0, true);
			$(this).attr('style', 'display:none');
			$(this).removeClass('block');
			$(this).prev('a.oznaczSprawdzony').attr('style', 'display:block');
			$(this).prev('a.oznaczSprawdzony').addClass('block');
		});
		$('.czyNotatka').live('click', function(){
			sprawdzPokazNotatki(location.hash.replace('#-', ''));
		});
		$('#zbiorowy_wyborNotatki input[type=radio]').live('click', function(){
			var id = $.fn.ferroSlider.getActualSlideId().replace('#','');
			if ($(this).val() > 0)
			{
				$('#i'+id+' #trescNotatki').html($('#i'+id+' #noteContent-'+$(this).val()).val());
			}
			else
			{
				$('#i'+id+' #trescNotatki').html('');
			}
		});
		$('.saveButton').live('click', function(){
			saveProducts();
			return false;
		});
		
		$(window).on('resize', function(){
			setTimeout(function(){
				$('body, html').width($('body').width()-19);
			}, 0);
		});
		
		var id = $.fn.ferroSlider.getActualSlideId().replace('#','');
		
		if( !($('#li-'+id).length) )
		{
			id = $('#listaCorrection li:first').attr('id').replace('li-', '');
		}
		
		setupLayout(id, true);
		markActive(id);
		getCurrentTotalPrice();
		
		$('select').live('mouseover', function(){$(this).select2();});
		$('.wiecej.widget-title').live('click', function(){setTimeout(function(){setHeightAfterChangingProducts($.fn.ferroSlider.getActualSlideId().replace('#',''));}, 500);});
		$('#previewReport').click(function(){
			if (sprawdzonych > 0)
			{
				var daty = sprawdzDaty();
				var dataOd = '';
				var dataDo = '';
				if(daty != false)
				{
					dataOd = daty['dataOd'];
					dataDo = daty['dataDo'];
				}
				else
				{
					dataOd = $('#dataOd').val();
					dataDo = $('#dataDo').val();
				}

				modalIFrame($('#no-focus-filtr').attr('action')+'&a=makeReport&preview=true&dataOd='+dataOd+'&dataDo='+dataDo+'&idType='+idType+'&idReport='+idReport);
				return false;
			}
			else
			{
				$('#previewReport').attr('rel', '');
				alertModal('{{$alert_brak_sprawdzonych_tresc}}', '{{$alert_brak_sprawdzonych_tytul}}');
				return false;
			}
		});
		$('.notCharge').live('click', function(){
			var id = location.hash.replace('#-', '');
			sprawdzNotCharge(id);
			setHeightAfterChangingProducts(id);
		});
	});
	
	function szukajWArchiwum()
	{
		if( $('#archiwum').is(':checked') ){ return 1; }else{ return 0; };
		if(
				( $('#archiwum').is(':checked') && $('#fraza').val().length > 2 ) || 
				( $('#archiwum').is(':checked') && $('#user').val() > 0 ) || 
				( $('#archiwum').is(':checked') && $('#team').val() > 0 )
			){ return 1; }else{ return 0; }
	}

	function usunZListy(idZamowienia)
	{
		ajax("{{$urlUsunZListy}}", usunZListyPotwierdz, {id: idZamowienia}, 'POST', 'json' );
	}
	function usunZListyPotwierdz(dane)
	{
		if(dane.error > 0)	alertModal('Error!', dane.komunikat);
		
		$('#li-'+dane.idZamowienia).remove();
		$.fn.ferroSlider.slideToNext();
		$('.close').click();
	}
	
	function saveProducts()
	{
		var id = $.fn.ferroSlider.getActualSlideId().replace('#','');
		
		var iloscProduktow = 0;
		$('#no-focus-prod_'+id+' input[name^=produkty'+id+'_id], #no-focus-prod_'+id+' input[name^=produktyNiestandardowe'+id+'_id]').each(function(){iloscProduktow++;});
		var bledy = 0;
		if (iloscProduktow == 0)
		{
			$('#i'+id+' .select2-choice').css({border: '1px solid red'});
			bledy++;
		}
		else
		{
			$('i'+id+' .select2-choice').css({border: '1px solid #aaa'});
		}
		
		if ($('#czyNotatka-'+id).is(':checked') && $('#i'+id+' #trescNotatki').val().length == 0)
		{
			$('#i'+id+' #trescNotatki').css({border: '1px solid red'});
			bledy++;
		}
		else
		{
			$('#i'+id+' #trescNotatki').css({border: '1px solid #ccc'});
		}
		if (bledy > 0)
		{
			alertModal('{{$blad_formularza_tytul}}', '{{$blad_formularza_tresc}}');
			return false;
		}
		$('.mobile-loader').fadeIn("normal");
		$.ajax({
			url: '{{$url_ajax_zapisz}}',
			type: 'POST',
			dataType: 'json',
			data: $('#no-focus-prod_'+id).serialize(),
			async: true,
			success: function(dane) {
				if (dane.success == 1)
				{
					odswierzZamowienie(id, true);
					getCurrentTotalPrice();
					setHeight(id);
				}
				else
				{
					$('#correctionsContainer').insertBefore(dane.komunikaty);
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var error = 'Save products status: '+xhr.status;
				if (thrownError != '') 
				{
					error += ', with error: '+thrownError;
				}
				alertModal('AJAX request error' ,error);
				$('.mobile-loader').fadeOut("normal");
			}
		});
	}

	function sprawdzPokazNotatki(id)
	{
		if ($('#i'+id+' .czyNotatka').is(':checked'))
		{
			$('#i'+id+' #zbiorowy_wyborNotatki').show();
			$('#i'+id+' #trescNotatki').html($('#i'+id+' #noteContent-'+$('#notatka-'+id+' input[type=radio]:checked').val()).val());
		}
		else
		{
			$('#i'+id+' #zbiorowy_wyborNotatki').hide();
		}
		setTimeout(function(){setHeightAfterChangingProducts(id);}, 50);
	}
	
	function sprawdzNotCharge(id)
	{
		if ($('#i'+id+' .notCharge').is(":checked"))
		{
			$('#i'+id+' [id^="produktyNiestandardowe"],#i'+id+' [id^="produkty"]').parents('.control-group').hide();
			if ($('#i'+id+' .notChargeAlert').length < 1)
			{
				var $alert = $('.notChargeAlert.wzor').clone().removeClass('wzor');
				$('#i'+id+' .notCharge').parents('.control-group').append($alert.fadeIn());
			}
		}
		else
		{
			$('#i'+id+' [id^="produktyNiestandardowe"], #i'+id+' [id^="produkty"]').parents('.control-group').show();
			$('#i'+id+' .control-group .notChargeAlert').remove();
		}
		updatePrice();
	}
	
	
	function setOrderCounter()
	{
		var wszystkich = $('#ordersLeftPane ul li').length;
		sprawdzonych = $('#ordersLeftPane ul li.checked').length;
		$('#ord_counter strong').html(sprawdzonych);
		$('#ord_counter span').html(wszystkich);
	}

	function setupLayout(id, loader)
	{
		var l = 0;
		if (loader)
		{
			console.log('slider');
			ustawLoader();
			l++;
		}
	 
		if ($('#'+id).html() == '' || $('#'+id).html() == 'undefined')
		{
		 
			odswierzZamowienie(id, false);
		}
		setHeight(id);
	 
	}
	
	function setHeight(id)
	{
		var h = $('#i'+id).height();
		if (h !== 0 && h > 400)
		{
			h = h+10;
			$('.innerSlider, #outerSliderWrapper, #outerSlider, #ordersContainer').css({height: h+'px'});
			setTimeout(function(){
				sprawdzNotCharge(id);
				sprawdzPokazNotatki(id);
				usunLoader();
			}, 1010);
			return true;
		}
		setTimeout(function(){setHeight(id);}, 300);
	}
	
	function setHeightAfterChangingProducts(id)
	{
		var h = $('#i'+id).height();
		if (h != 0 && h > 400)
		{
			h = h+10;
			$('.innerSlider, #outerSliderWrapper, #outerSlider, #ordersContainer').css({height: h+'px'});
		}
	}
	
	function markActive(id)
	{
		$('#ordersLeftPane li').removeClass('active');
		var elem = $('#li-'+id);
		var container = $('#ordersLeftPane .widget-content');
		container.animate({scrollTop: elem.parent().scrollTop() + elem.offset().top - elem.parent().offset().top - (container.height()/2 - elem.height())}, {queue: false});
		elem.addClass('active');
		czyscDOM(id);
	}

	function getCurrentTotalPrice()
	{
		var dataOd = $.urlParam('dataOd');
		var dataDo = $.urlParam('dataDo');
		var fraza = $('#fraza').val();
		var user = $('#user').val();
		var team = $('#team').val();
		var archivum = szukajWArchiwum();
		
		$.ajax({
			url: '{{$url_ajax_pobierz_kwote}}',
			type: 'POST',
			dataType: 'json',
			data: {
				dataOd: (dataOd !== 0) ? dataOd : $('#dataOd').val(),
				dataDo: (dataDo !== 0) ? dataDo : $('#dataDo').val(),
				idType: idType,
				idReport: idReport,
				idOrder: idOrder,
				fraza: fraza,
				user: user,
				team: team,
				archivum: archivum
			},
			async: true,
			success: function(dane) {
				$('#total_price').html(dane.kwota);
				$('#total_price_checked').html(dane.kwotaChecked);
				$('#money_counter').removeClass('hidden').hide().slideDown();
				startupErrors['priceRefreshed'] = true;
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var error = 'Getting current total price status:'+xhr.status;
				if (thrownError != '')
				{
					error += ', with error: '+thrownError;
				}
				alertModal('AJAX request error', error);
			}
		});
	}
	
	function updatePrice()
	{
		var id = $.fn.ferroSlider.getActualSlideId().replace('#','');
		var cena = 0;
		if ($('#i'+id+' .notCharge').is(':checked'))
		{
			$('#price-'+id).html(number_format(cena, 0, '.', ' '));
			return;
		}
		setTimeout(function(){
			$('#no-focus-prod_'+id+' input[name^=produkty'+id+'_id]').each(function(){
				var p_id = $(this).val();
				var ilosc = $(this).parents('.item').find('input[name^=produkty'+id+'_qty]').attr('aria-valuenow');
				//alert(ilosc);
				if (ilosc != undefined)
				{
					cena += ceny[p_id] * ilosc;
				}
			});
			$('#no-focus-prod_'+id+' .item').each(function(){
				var ilosc = $(this).find('input[name^=produktyNiestandardowe'+id+'_qty]').attr('aria-valuenow');
				//alert(ilosc);
				if (ilosc != undefined)
				{
					cena += $(this).find('input[name^=produktyNiestandardowe'+id+'_cena]').val() * ilosc;
				}
			});
			var longest_distance = parseInt($('#no-focus-prod_'+id+' strong.longest_distance').html());
			if (longest_distance > 0) cena += longest_distance;
			$('#price-'+id).html(number_format(cena, 0, '.', ' '));
		}, 50);
	}
	
	function markAsChecked(id, flagaSprawdzony, ajaxLoader)
	{
		if (ajaxLoader) ustawLoader();
		$.ajax({
			url: '{{$url_ajax_oznacz_sprawdzony}}',
			type: 'POST',
			dataType: 'json',
			data: {
				id: id ,
				flagaSprawdzony : flagaSprawdzony
			},
			success: function(dane) {
				if (dane.success == 1)
				{
					if(flagaSprawdzony)
					{
						$('#li-'+id).addClass('checked');
						usunLoader();
						{{IF $oznacz_sprawdzone_przyciskiem}}
							$.fn.ferroSlider.slideToNext();
						{{ELSE}}
							odswierzZamowienie(id, true);
						{{END}}
					}
					else
					{
						$('#li-'+id).removeClass('checked');
						usunLoader();
					}
						
					setOrderCounter();
					getCurrentTotalPrice();
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var error = 'Marking order has failed (status: '+xhr.status+')';
				if (thrownError != '')
				{
					error += ', with error: '+thrownError;
				}
				alertModal('AJAX request error', error);
				usunLoader();
			}
		});
	}
	
	function odswierzZamowienie(id, przeladujTresc)
	{
		if (przeladujTresc || $('#'+id).html() == '')
		{
			$.ajax({
				url: '{{$url_ajax_order}}',
				type: 'POST',
				dataType: 'html',
				data: {id: id},
				success: function(dane) {
					$('#'+id).html('<div id="ajax-loaded-content-'+id+'">'+dane+'</div>');
					$('#'+id+' .tip-top').tooltip({ placement: 'top' });
					$('.mobile-loader').fadeOut("fast");
					startupErrors['contentLoaded'] = true;
					
				},
				error: function (xhr, ajaxOptions, thrownError) {
					var error = 'Refresh order status: '+xhr.status;
					if (thrownError != '')
					{
						error += ', with error: '+thrownError;
					}
					console.log('AJAX request error: '+error);
				}
			});
		}
	}
	
	function sprawdzDaty()
	{
		var zwracaneDaty = {};
		var parametryIstnieja = 0;
		var params = window.location.search.split(/\?|\&/);
		
		params.forEach( function(it) {
			if (it) {
				var param = it.split("=");
				if(param[0] == 'dataOd')
				{
					parametryIstnieja = 1;
					zwracaneDaty['dataOd'] = param[1].replace('%20', ' ');
				}
				if(param[0] == 'dataDo')
				{
					parametryIstnieja = 1;
					zwracaneDaty['dataDo'] = param[1].replace('%20', ' ');
				}
			}
		});
		
		if(parametryIstnieja)
		{
			return zwracaneDaty;
		}
		return false;
	}
	
	function makeReportExcel()
	{
		var daty = sprawdzDaty();
		if (! $('.mobile-loader').is(':visible')) $('.mobile-loader').show();
		if(daty != false)
		{
			$('#dataOd').val(daty['dataOd']);
			$('#dataDo').val(daty['dataDo']);
			var link = $('#no-focus-filtr').attr('action', $('#no-focus-filtr').attr('action')+'&a=raportExcel&dataOd='+daty['dataOd']+'&dataDo='+daty['dataDo']+'&idType='+idType+'&idReport='+idReport);
		}
		else
		{
			var link = $('#no-focus-filtr').attr('action', $('#no-focus-filtr').attr('action')+'&a=raportExcel&dataOd='+$('#dataOd').val()+'&dataDo='+$('#dataDo').val()+'&idType='+idType+'&idReport='+idReport);
		}
		
		$('#no-focus-filtr').submit();
		setTimeout(function(){ $('.mobile-loader').hide(); } , 8000);
	}
	
	function makeReport()
	{
		if (sprawdzonych > 0)
		{
			if (! $('.mobile-loader').is(':visible')) $('.mobile-loader').show();
			$('#makeReport').attr('href', 'javascript:void(0);');
			if (startupErrors['contentLoaded'] && startupErrors['priceRefreshed'])
			{
				var daty = sprawdzDaty();
				if(daty === 'FALSE' || daty == false)
				{
					var link = $('#no-focus-filtr').attr('action', $('#no-focus-filtr').attr('action')+'&a=makeReport&dataOd='+$('#dataOd').val()+'&dataDo='+$('#dataDo').val()+'&idType='+idType+'&idReport='+idReport);
				}
				else
				{
					$('#dataOd').val(daty['dataOd']);
					$('#dataDo').val(daty['dataDo']);
					var link = $('#no-focus-filtr').attr('action', $('#no-focus-filtr').attr('action')+'&a=makeReport&dataOd='+daty['dataOd']+'&dataDo='+daty['dataDo']+'&idType='+idType+'&idReport='+idReport);
				}
				
				$('#no-focus-filtr').submit();
			}
			else
			{
				setTimeout(function(){makeReport();}, 500);
			}
		}
		else
		{
			alertModal('{{$alert_brak_sprawdzonych_tresc}}', '{{$alert_brak_sprawdzonych_tytul}}');
		}
		
	}
	
	function sendToFaktura()
	{
		if (sprawdzonych > 0)
		{
			if (! $('.mobile-loader').is(':visible')) $('.mobile-loader').show();
			$('#sendToFaktura').attr('href', 'javascript:void(0);');
			if (startupErrors['contentLoaded'] && startupErrors['priceRefreshed'])
			{
				var ids = Array();
				var i = 0;
				$('#ordersLeftPane ul li.checked').each(function(){
					if (i > 0) ids += '|'; 
					ids += $(this).attr('id').replace('li-', '');
					i++;
				});
				
				$('#no-focus-filtr').attr('action', '{{$urlDodajFakturowanie}}&dataOd='+$('#dataOd').val()+'&dataDo='+$('#dataDo').val()+'&idType='+idType+'&ids='+ids);
				$('#no-focus-filtr').submit();
			}
			else
			{
				setTimeout(function(){sendToFaktura();}, 500);
			}
		}
		else
		{
			alertModal('{{$alert_brak_sprawdzonych_tresc}}', '{{$alert_brak_sprawdzonych_tytul}}');
		}
		
	}
	
	function slideTo(id)
	{
		//ustawLoader();
		$.fn.ferroSlider.slideTo(id);
	}
	
	function czyscDOM(id)
	{
		//ustawSelect2(id);
		var $aktualny = $('#li-'+id);
		
		if (! $aktualny.hasClass('first'))
		{
			var $poprzedni = $('#'+id).parents('.innerSlider').prev().find('.widokZamowien');
		}
		if (! $aktualny.hasClass('last'))
		{
			var $nastepny = $('#'+id).parents('.innerSlider').next().find('.widokZamowien');
		}
		
		var not = '#'+id;
		if (typeof $poprzedni != 'undefined')
		{
			var idPoprzedniego = $poprzedni.attr('id');
			not += ', #'+idPoprzedniego;
			setTimeout(function(){odswierzZamowienie(idPoprzedniego, false);}, 600);
		}
		if (typeof $nastepny != 'undefined')
		{
			var idNastepnego = $nastepny.attr('id');
			not += ', #'+idNastepnego;
			setTimeout(function(){odswierzZamowienie(idNastepnego, false);}, 400);
		}
		$('.innerSlider .widokZamowien:not('+not+')').html('').height(500);
	}
	
	var isIE = (function(){
		var undef,rv = -1; // Return value assumes failure.
		var ua = window.navigator.userAgent;
		var msie = ua.indexOf('MSIE ');
		var trident = ua.indexOf('Trident/');
		if (msie > 0) {
			// IE 10 or older => return version number
			rv = parseInt(ua.substring(msie + 5, ua.indexOf('.', msie)), 10);
		} else if (trident > 0) {
			// IE 11 (or newer) => return version number
			var rvNum = ua.indexOf('rv:');
			rv = parseInt(ua.substring(rvNum + 3, ua.indexOf('.', rvNum)), 10);
		}
		return ((rv > -1) ? rv : undef);
	}());
	
	function ustawSelect2(id)
	{
		var i = 0;
		$('#i'+id+' .select2-container').each(function(){i++;});
		if (i == 0)
		{
			$('select').select2();
			if (isIE)
			{
				setTimeout(function(){ustawSelect2(id);}, 1000);
			}
		}
	}
	
	function ustawLoader()
	{
		$('#ordersContainer').prepend('<div id="ferroslider-ajaxLoader" style="width: '+$('#outerSliderWrapper').width()+'px; z-index: 1001"><i class="icon-spinner icon-spin" style="margin-top: 229px;"></i></div>');
	}
	function usunLoader()
	{
		$('#ferroslider-ajaxLoader').remove();
	}
	$('.wiecej').live('click' ,function(){
		$(this).next('.wiecej_rozwin').toggle(500);
	});
{{END}}

</script>
{{END}}

{{BEGIN pdf}}
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
		.zamowienie_naglowek{
			font-size: 7pt; padding: 8px 5px; font-weight: bold; border-top:1px solid #7d7d7d; border-bottom:1px solid #7d7d7d; border-right: 1px solid #fff;
		}
		.etykietaStopka{
			color:#20a7d4;
		}
		</style>
	</head>
	<body>
		{{$tresc}}
		{{$podsumowanie}}
	</body>
</html>
	{{BEGIN header}}
		<htmlpageheader name="myHeader1">
		<table cellSpacing="0" cellPadding="0" border="0" align="left" width="100%;" style="border-bottom: 2px solid #e8e8e4; padding: 0px; ">
			<tr>
				<td style="width: 50%"><img src="{{$logo}}" alt="{{$logo_alt}}" style="position: absolute; left: 0; top: 0; width: 228px" class="float: right"/></td>
				<td style="width: 50%; text-align:right;">
					<table  cellSpacing="0" cellPadding="0" border="0" align="left" >
						<tr>
							<td style="text-align:left;">
								<span style="text-transform: uppercase; font-size: 10pt;" >{{$etykieta_page_number}}{PAGENO}</span>
							</td>
						</tr>
						<tr>
							<td style="height:50px; bgcolor:#363636; text-align: center;" bgcolor="#363636" >
								<span style="color:#fff; font-size: 14pt; text-transform: uppercase;">{{$etykieta_data}}</span>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
		</htmlpageheader>
	{{END}}
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
	{{BEGIN podsumowanie}}
		<table border="0" cellspacing="2" cellPadding="10" width="100%" style=" page-break-inside:avoid; border-top: solid 2px #0077b3; margin-top: 100px">
			<tr>
				<td colspan="4"  style="font-size: 12pt; background-color: #ededed; text-transform: uppercase; text-align: center;">{{$etykieta_podsumowanie}}</td>
			</tr>
			<tr>
				<td width="15%" style="font-size: 15pt; background-color: #ededed; text-transform: uppercase; text-align: center;" >{{$procent}} % </td>
				<td style="font-size: 11pt; background-color: #ededed; text-transform: uppercase;">{{$info_podsumowanie}}</td>
				<td width="20%" style="text-transform: uppercase; font-size: 13pt; background-color: #3fb2d7; color: white; text-align: right;"><span class="strong">{{$etykieta_total_price}}</span></td>
				<td width="20%" style="text-transform: uppercase; font-size: 13pt; background-color: #545454; color: white; text-align: left;"><span class="strong">{{$total_price}}</span></td>
			</tr>
		</table>
	{{END}}
	{{BEGIN listaProduktow}}
	<table width="100%" style="page-break-inside:avoid">
		{{BEGIN produkt}}
		<tr>
			<td style="{{UNLESS $_first}}border-top: solid 1px #eee;{{END}}">{{$_num}}. {{$nazwa_produktu}}</td>
			<td style="{{UNLESS $_first}}border-top: solid 1px #eee;{{END}} width: 1.5cm; text-align: right">{{$ilosc}}x</td>
			<td style="{{UNLESS $_first}}border-top: solid 1px #eee;{{END}} width: 2.6cm; text-align: right">{{$cena_jednostkowa}}</td>
			<td style="{{UNLESS $_first}}border-top: solid 1px #eee;{{END}} width: 2.6cm">{{$cena}}</td>
		</tr>
		{{END}}
	</table>
	{{END}}
{{END}}

{{BEGIN dzien}}
	{{BEGIN pagebreak}}
		<pagebreak />
	{{END}}
	<htmlpageheader name="myHeader{{$headerId}}">
		<table cellSpacing="0" cellPadding="0" border="0" align="left" width="100%;" style="border-bottom: 2px solid #e8e8e4; padding: 0px; ">
			<tr>
				<td style="width: 50%"><img src="{{$logo}}" alt="{{$logo_alt}}" style="position: absolute; left: 0; top: 0; width: 228px" class="float: right"/></td>
				<td style="width: 50%; text-align:right;">
					<table  cellSpacing="0" cellPadding="5" border="0" align="left" >
						<tr>
							<td style="text-align:right;">
								<span style="text-transform: uppercase; font-size: 10pt;" >{{$etykieta_page_number}}{PAGENO} {{$of}} {nbpg}</span>
							</td>
						</tr>
						<tr>
							<td style="height:50px; bgcolor:#363636; text-align: center; padding: 0px 20px;" bgcolor="#363636" >
								<span style="color:#fff; font-size: 14pt; text-transform: uppercase;">{{$etykieta_data}}</span>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</htmlpageheader>
	<sethtmlpageheader name="myHeader{{$headerId}}" value="on" show-this-page="1" />
	{{BEGIN zamowienie}}
	<table cellSpacing="0" cellPadding="7" width="100%" style="page-break-inside:avoid; padding-bottom: 10px; ">
		<tr style="background-color: #e1e1e1">
			<td width="15%" class="zamowienie_naglowek" style="background:#7d7d7d; border-right: 0px; color: #fff;" >{{$wo}}</td>
			<td width="25%" class="zamowienie_naglowek" >{{$cust_name}}</td>
			<td class="zamowienie_naglowek" >{{$address}}</td>
			<td width="15%" class="zamowienie_naglowek" >{{$time_finish}}</td>
		</tr>

		<tr>
			<td style="border-bottom:1px solid #e8e8e8; text-transform: uppercase; background: #aeb1af; color: #fff; font-weight: bold;" >{{$etykieta_tekst}}</td>
			<td style="border-bottom:1px solid #e8e8e8; text-transform: uppercase; " colspan="3">{{$tekst}}</td>
		</tr>
		{{IF $komentarz}}
		<tr>
			<td style="border-bottom:1px solid #e8e8e8; text-transform: uppercase; font-weight: bold;" >{{$etykieta_komentarz}}</td>
			<td style="border-bottom:1px solid #e8e8e8; text-transform: uppercase;" colspan="3">{{$komentarz}}</td>
		</tr>
		{{END}}

		<tr>
			<td colspan="2" ></td>
			<td colspan="2" style="text-align:right; padding: 0px;">
				<table cellSpacing="0" cellPadding="7" width="25%">
					<tr>
						<td width="40%" style="text-transform: uppercase; text-align: right; background: #3fb2d7; color: #fff; height: 100%; width: 40%;" ><span class="strong">{{$etykieta_price}}</span></td>
						<td width="60%" style="text-transform: uppercase; background:#545454; text-align: left; color: #fff; width: 60%;"><span class="strong">{{$price}}</span></td>
					</tr>
				</table>
				
			</td>
			
		</tr>
	</table>
	{{END}}
	{{BEGIN podsumowanieDnia}}
	<table width="100%" style="margin-top:60px; color: #363636;" >
		<tr>
			<td width="49%" valign="top" >
				<table border="0" cellspacing="3" width="100%" cellPadding="10" style="page-break-inside:avoid;">
					{{BEGIN teamLongestDistance}}
					{{IF $_first}}
					<tr>
						<td colspan="2" style="text-align: center; padding: 10px; text-transform: uppercase; margin-top: 5px; background-color: #ededed; font-size: 11pt">
							{{$etykieta_longest_distance}}
						</td>
					</tr>
					{{END}}
					<tr>
						<td  {{UNLESS $_last}}{{END}} style="background-color: #ededed; text-transform: uppercase;" >{{$longest_distance_text}}</td>
						<td width="20%" {{UNLESS $_last}}{{END}} style="text-transform: uppercase; background-color: #ededed; text-align: center;">{{$longest_distance_cena}}</td>
					</tr>
					{{END}}
				</table>
			</td>
			<td width="2%" >
			</td>
			<td width="49%" valign="top" >
				<table border="0" cellspacing="3"  cellPadding="10" width="100%" style="page-break-inside:avoid;">
					<tr>
						<td colspan="2" style="background-color: #ededed; font-size: 11pt; padding: 10px; text-transform: uppercase; text-align: center;">{{$etykieta_podsumowanie_dnia}}</td>
					</tr>
					<tr>
						<td style="background-color: #ededed; text-transform: uppercase; font-weight: bold; font-size: 19pt; color:#545454; text-align: center;" >{{$procentDone}} % </td>
						<td style="background-color: #ededed; text-transform: uppercase; font-size: 11pt" >{{$info_podsumowanie}}</td>
					</tr>
					<tr>
						<td style="background-color: #3fb2d7; color: white; text-transform: uppercase; font-size: 13pt; text-align: right;"><span class="strong">{{$etykieta_total_price}}</span></td>
						<td style="background-color: #545454; color: white; text-transform: uppercase; font-size: 13pt; text-align: left;"><span class="strong">{{$total_price}}</span></td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	{{END}}
	
{{END}}
