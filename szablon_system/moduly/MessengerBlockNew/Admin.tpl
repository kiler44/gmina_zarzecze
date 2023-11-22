{{BEGIN index}}
<div class="komunikator">
	<a class="btn btn-info komunikator-switch"><i class="icon icon-comment"></i></a>
	<div class="content widget-box widget-chat komunikatorMain">
		<div class="widget-title">
			<span class="icon">
				<i class="icon icon-comments"></i>
			</span>
			<h5>{{$etykieta_naglowek}}</h5>
		</div>
		<div class="widget-content nopadding">
			<div class="chat-content panel-left">
				<div class="komunikaty_kontener"></div>
				<div class="selectedContacts">
					{{$etykieta_brak_kontaktow}}
				</div>									
				<div class="chat-message well" style="display: none">
					<div class="btn-group rodzaj_wysylki">
						<a href="javascript:wybierzMetodeWysylki('tryb_sms');" class="btn btn-info" id="tryb_sms"><i class="icon icon-comment"></i> {{$etykieta_sms}}</a>
						<a href="javascript:wybierzMetodeWysylki('tryb_email');" class="btn btn-info" id="tryb_email"><i class="icon icon-envelope-alt"></i> {{$etykieta_email}}</a>
					</div>
					<div class="input-group">
						{{$textarea}}
						<!--<textarea placeholder="{{$wiadomosc_placeholder}}" type="text"></textarea>-->
						<div class="ajaxLoader mobile-loader"></div>
						<div class="fL" id="powiazanyOrder" style="margin-top: 20px"></div>
						<button class="btn btn-success" id="chat-send"><i class="icon icon-envelope-alt"></i> {{$etykieta_wyslij}}</button>
					</div>
				</div>                   
			</div>
			<div class="chat-users panel-right">
				<div class="panel-title">
					<h5 class="fL">{{$etykieta_lista_kontaktow}}</h5> <a href="javascript:void(0);" class="btn btn-small btn-success fR margin" id="toggleCheckAll" data-select="{{$etykieta_zaznacz}}" data-unselect="{{$etykieta_odznacz}}"><i class="icon icon-check-sign"></i> <span>{{$etykieta_zaznacz}}</span></a>
					<input type="text" placeholder="{{$filtruj_placeholder}}" id="contactFilter" name="contatctFilter"/>
				</div>
				<div class="panel-content nopadding">
					<ul class="contact-list">
						{{BEGIN kontakt}}
						<li id="u-{{$id}}">
							<a href="{{$url_historia_podglad}}" class="fR historia tip-left" onclick="kartaHistorii(this.href); return false;" title="{{$etykieta_historia_podglad}}"><i class="icon icon-archive"></i></a>
							<a href="javascript:void(0)" id="ua-{{$id}}" title="{{IF $telefon}}{{$telefon}}, {{END IF}}{{IF $email}}{{$email}}{{END IF}}" class="tip-bottom contact"{{IF $email}} mail="{{$email}}"{{END IF}} {{IF $telefon}} telefon="{{$telefon}}"{{END IF}}>{{IF $zdjecie}}<img alt="{{$kontakt_nazwa}}" src="{{$zdjecie}}"/>{{ELSE}}<span class="brak_zdjecia">{{$inicjaly}}</span>{{END IF}} <span>{{$kontakt_nazwa}}</span></a>
							<span class="fraza_szukaj hidden">{{$kontakt_nazwa}} {{$email}} {{$telefon}}</span>
						</li>
						{{END kontakt}}
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="content widget-box widget-chat historiaKomunikatora" style="display: none"></div>
	<div class="overlay" style="display: none"></div>
</div>
<script type="text/javascript">
	$(document).on('click', "[rel^='comm-']:not(.disable-comm)", function(e){
		var id = $(this).attr('rel').replace('comm-', '');
		komunikator(id);
	});
	/*
	$(document).ready(function(){
		$("[rel^='comm-']:not(.disable-comm)").on('click', function () {
			
		});
	});
	*/

	$(document).ajaxComplete(function(){
		$("[rel^='comm-']").css('cursor', 'pointer');
		$("[rel^='comm-']:not(.disable-comm)").on('click', function () {
			var id = $(this).attr('rel').replace('comm-', '');
			komunikator(id);
		});
	});
	
	var p = '{{$sms_podpis}}: ';
	var podpis = '';
	var get_wo = '{{$get_wo}}';
	var bkt_wo = '{{$bkt_wo}}';
	var oid = null;
	var id_get = null;
	var id_bkt = null;
	var komunikatBrakKontaktow = '';
	var powiazaneZamowienie = '{{$powiazane_zamowienie}}';
	var wiecejZaznaczonych = false;
	$(window).resize(function(){
		zmienRozmiaryOkna();
		zmienRozmiarOknaHistoria();
	});
	
	function komunikator(id)
	{
		zamknijKarteHistorii();
		if (oid == id) return false;
		
		var ids = id.split(':');
		id = ids[0];
		
		if (ids.length > 2)
		{
			id_bkt = ids[1];
			id_get = ids[2];
			podpis = p.replace("{WO}", '('+get_wo+ids[2]+')');
		}
		else if (ids.length == 2)
		{
			id_bkt = ids[1];
			podpis = p.replace("{WO}", '('+bkt_wo+ids[1]+')');
		}
		else
		{
			podpis = p.replace("{WO}", '');
		}
		
		if (ids.length > 1)
		{
			var idZamowienia = '';
			if (typeof id_get != 'undefined' && id_get > 0)
				idZamowienia = 'WO: '+id_get;
			else if (typeof id_bkt != 'undefined' && id_bkt > 0)
				idZamowienia = 'BKT ID: '+id_bkt;

			znajdz = ['{WO}', '{ID}'];
			zamien = [idZamowienia, id_bkt];
			$('#powiazanyOrder').html(powiazaneZamowienie.replaceArray(znajdz, zamien));
		}
		else
		{
			$('#powiazanyOrder').html('');
		}

		var rodzaj = $('.rodzaj_wysylki a.active').attr('id');
		if (rodzaj === 'tryb_sms')
		{
			if (typeof $('li#u-'+id+' a.contact').attr('telefon') == 'undefined')
			{
				var komunikat_tresc = '{{$komunikat_brak_numeru_tresc}}';
				alertModal('{{$komunikat_brak_numeru_tytul}}', komunikat_tresc.replace('{ID}', id));
				return false;
			}
		}
		else
		{
			if (typeof $('li#u-'+id+' a.contact').attr('mail') == 'undefined')
			{
				var komunikat_tresc = '{{$komunikat_brak_maila_tresc}}';
				alertModal('{{$komunikat_brak_maila_tytul}}', komunikat_tresc.replace('{ID}', id));
				return false;
			}
		}
		zaznaczKontakt($('li#u-'+id+' a.contact'));
		
		komunikatorOpen();
		
		//setTimeout(function(){$('.close').click();}, 300);
	}
	
	function czyscPowiazanie()
	{
		podpis = p.replace('{WO}', '');
		$('#powiazanyOrder').html('');
		id_bkt = null;
		id_get = null;
		wybierzMetodeWysylki($('.rodzaj_wysylki a.active').attr('id'));
		/*
		var limit_znakow = 609 - podpis.length;
		
		$('#wiadomosc-tresc').attr('maxlength', limit_znakow);
		$("#wiadomosc-tresc").keyup(function(){
			limitZnakow("wiadomosc-tresc", limit_znakow, "lim_wiadomosc-tresc", "Characters left: {LICZBA} of {LIMIT}");
			walidujSms();
		});
		*/
	}
	
	function wypelnijListeZaznaczonych()
	{
		var ilosc = parseFloat($('.chat-users li.active').length);
		var ilosc_wszystkich = parseFloat($('.chat-users li').length);
		if (ilosc > 0)
		{
			if (komunikatBrakKontaktow == '')
				komunikatBrakKontaktow = $('.selectedContacts').html();
			
			$('.selectedContacts').html('');
			$('.contact-list a.active').each(function(){
				$('.selectedContacts').append($(this).clone().attr('title', $(this).find('span:not(.brak_zdjecia)').html()+"\n\n"+$(this).attr('data-original-title')));
			});
		}
		else
		{
			$('.selectedContacts').html(komunikatBrakKontaktow);
		}
		if (ilosc > (ilosc_wszystkich/2))
		{
			$('#toggleCheckAll').removeClass('btn-success').addClass('btn-danger');
			$('#toggleCheckAll span').html($('#toggleCheckAll').attr('data-unselect'));
			$('#toggleCheckAll .icon').removeClass('icon-check-sign').addClass('icon-check-empty');
		}
		else
		{
			$('#toggleCheckAll').removeClass('btn-danger').addClass('btn-success');
			$('#toggleCheckAll span').html($('#toggleCheckAll').attr('data-select'));
			$('#toggleCheckAll .icon').removeClass('icon-check-empty').addClass('icon-check-sign');
		}
		wybierzMetodeWysylki($.cookie('rodzaj_wysylki'));
	}
	
	$(document).ready(function(){
		
		var rodzaj_wysylki = $.cookie('rodzaj_wysylki');
		if (rodzaj_wysylki == '' || typeof rodzaj_wysylki == 'undefined')
		{
			wybierzMetodeWysylki('tryb_sms')
		}
		else
		{
			wybierzMetodeWysylki(rodzaj_wysylki);
		}
		
		$('#chat-send').on('click', function(){
			if (walidujFormularz())
			{
				wyslijWiadomosc();
			}
			else
				return;
		});
		
		$('.komunikator').find('.contact-list li a.contact').click(function(){
			toggleZaznaczOdznacz($(this));
		});
		$('#toggleCheckAll').click(function(){
			if ($('#toggleCheckAll span').html() == $('#toggleCheckAll').attr('data-select'))
			{
				zaznaczKontakt($('.contact-list li a.contact'));
			}
			else
				odznaczKontakt($('.contact-list li a.active'));
		});
		$('.selectedContacts a').on('click', function(){
			var id = $(this).attr('id');
			$('.contact-list #'+id).click();
		});
		
		if ($.cookie('communicator_state') == 'opened')
		{
			komunikatorOpen();
		}
		zmienRozmiaryOkna();
		
		$("#contactFilter").keyup(function(){
			var filter = $(this).val(), count = 0;
			
			$(".contact-list > li").children('.fraza_szukaj').each(function(){
				if($(this).text().search(new RegExp(filter, "i")) < 0)
				{
					$(this).parents('.contact-list > li').hide();
				}
				else
				{
					$(this).parents('.contact-list > li').fadeIn();
					count++;
				}
			});
			
			//var numberItems = count;

			//$("#filter-count").text("{{$znaleziono_zamowien}}"+count);
	   });
	});
	
	$('.komunikator-switch').click(function(){
		komunikatorToggle();
	});
	
	function komunikatorToggle()
	{
		var szerokosc = '60%';
		if ($('.komunikator .historiaKomunikatora').is(':visible'))
			szerokosc = '89%';
			
		if ($('.komunikator-switch').hasClass('active'))
		{
			$('.komunikator').animate({width: "0%"}, 300, "linear", function(){
				$('.komunikator-switch').removeClass('active');
				$('.komunikator-switch').addClass('btn-info');
				$('.komunikator-switch i').removeClass('icon-remove');
				$('.komunikator-switch i').addClass('icon-comment');
				$('.komunikator .well').fadeOut();
				$.cookie('communicator_state', 'closed');
			});
		}
		else
		{
			
			$('.komunikator').animate({width: szerokosc}, 750, "easeOutBounce", function(){
				zmienRozmiaryOkna();
				$('.komunikator .well').fadeIn();
			});
			$('.komunikator-switch').addClass('active');
			$('.komunikator-switch').removeClass('btn-info');
			$('.komunikator-switch i').removeClass('icon-comment');
			$('.komunikator-switch i').addClass('icon-remove');
			$.cookie('communicator_state', 'opened');
		}
	}
	function komunikatorOpen()
	{
		$('.komunikator').width("60%");
		$('.komunikator-switch').addClass('active');
		$('.komunikator-switch').removeClass('btn-info');
		$('.komunikator-switch i').removeClass('icon-comment');
		$('.komunikator-switch i').addClass('icon-remove');
		zmienRozmiaryOkna();
		$('.komunikator .well').fadeIn();
		$.cookie('communicator_state', 'opened');
	}
	function komunikatorClose()
	{
		$('.komunikator').width("0%");
		$('.komunikator-switch').removeClass('active');
		$('.komunikator-switch').addClass('btn-info');
		$('.komunikator-switch i').removeClass('.icon-remove');
		$('.komunikator-switch i').addClass('icon-comment');
		$('.komunikator .well').fadeOut();
		$.cookie('communicator_state', 'closed');
	}
	function zmienRozmiaryOkna()
	{
		var wys = $('.komunikator').height() - $('.komunikator .widget-title').height();
		$('.komunikator .widget-content').height(wys);
		$('.komunikator .panel-left, .komunikator .panel-right').height(wys);
		$('.komunikator .panel-left textarea').width($('.komunikator .well').width()-14);
		//$('.komunikator .well').fadeIn();
	}
	function zmienRozmiarOknaHistoria()
	{
		var wys = $('.komunikator .historiaKomunikatora').height() - $('.historiaKomunikatora .widget-title').height() - $('.historiaKomunikatora .contact-page').height() -55;
		$('.komunikator .tresc').height(wys);
	}
	
	function toggleZaznaczOdznacz(selector)
	{
		if (selector.parents('li').hasClass('active'))
		{
			odznaczKontakt(selector);
		}
		else
		{
			zaznaczKontakt(selector);
		}
	}
	
	function zaznaczKontakt(selector)
	{
		selector.each(function(){
			$(this).addClass('active');
			$(this).parents('li').addClass('active');
			
		});
		wypelnijListeZaznaczonych();
	}
	function odznaczKontakt(selector)
	{
		selector.each(function(){
			$(this).removeClass('active');
			$(this).parents('li').removeClass('active');
		});
		wypelnijListeZaznaczonych();
	}
	
	function wybierzMetodeWysylki(metoda)
	{
		if (komunikatBrakKontaktow == '')
				komunikatBrakKontaktow = $('.selectedContacts').html();
		if (metoda === 'tryb_sms')
		{
			$.cookie('rodzaj_wysylki', 'tryb_sms');
			
			$('#tryb_email').removeClass('active');
			$('#tryb_sms').addClass('active');
			$('.contact-list li').show();
			$('.komunikator').find('.contact-list li a.contact').each(function(){
				if (typeof $(this).attr('telefon') == 'undefined')
				{
					$(this).parents('li').hide();
				}
			});
			$('.selectedContacts').html('');
			$('.contact-list li:visible a.active').each(function(){
				$('.selectedContacts').append($(this).clone().attr('title', $(this).find('span:not(.brak_zdjecia)').html()+"\n\n"+$(this).attr('data-original-title')));
			});
			
			var limit_znakow = 609 - podpis.length;
			
			$('#wiadomosc-tresc').attr('maxlength', limit_znakow);
			$("#wiadomosc-tresc").keyup(function(){
				limitZnakow("wiadomosc-tresc", limit_znakow, "lim_wiadomosc-tresc", "Characters left: {LICZBA} of {LIMIT}");
				walidujSms();
			});
			$("#wiadomosc-tresc").focus(function(){
				limitZnakow("wiadomosc-tresc", limit_znakow, "lim_wiadomosc-tresc", "Characters left: {LICZBA} of {LIMIT}");
				$("#lim_wiadomosc-tresc").fadeIn("normal");
			});

			$("#wiadomosc-tresc").blur(function(){
				$("#lim_wiadomosc-tresc").fadeOut("normal");
			});
		}
		else if (metoda === 'tryb_email')
		{
			$.cookie('rodzaj_wysylki', 'tryb_email');
			$('#tryb_email').addClass('active');
			$('#tryb_sms').removeClass('active');
			$('.contact-list li').show();
			//wypelnijListeZaznaczonych();
			$('.komunikator').find('.contact-list li a.contact').each(function(){
				if (typeof $(this).attr('mail') == 'undefined')
				{
					$(this).parents('li').hide();
				}
			});
			$('.selectedContacts').html('');
			$('.contact-list li:visible a.active').each(function(){
				$('.selectedContacts').append($(this).clone().attr('title', $(this).find('span:not(.brak_zdjecia)').html()+"\n\n"+$(this).attr('data-original-title')));
			});
			$('#wiadomosc-tresc').removeAttr('maxlength');
			$('#wiadomosc-tresc').unbind('keyup blur focus');
		}
		if ($('.selectedContacts').html() == '')
		{
			$('.selectedContacts').html(komunikatBrakKontaktow);
		}
		$('.tip-top').tooltip({placement: 'top'});
		$('.tip-bottom').tooltip({placement: 'bottom'});
	}
	
	function walidujSms()
	{
		validChars = " ABCDEFGHIJKLMNOPQRSTUVWXYZÆØÜÅÕÄÖÃ1234567890"
			+ "abcdefghijklmnopqrstuvwxyuûüzæøåõäöãé.,/!@\"'-:;%()<>=$£¥&";
			
		var outSMS = replace(trim($('#wiadomosc-tresc').val()),"\\","/");
		var newSMS = outSMS;
		for(i=0;i<outSMS.length;i++){
			if(outSMS.charAt(i)=="?" || outSMS.charAt(i)=="(" || outSMS.charAt(i)==")"
				|| outSMS.charAt(i)=="*" || outSMS.charAt(i)=="+"
				|| outSMS.charCodeAt(i) == 10 || outSMS.charCodeAt(i) == 13){
				// do nothing
			} else if(!validChars.match(outSMS.charAt(i))){
				//alert(outSMS.charCodeAt(i));
				newSMS = replace(newSMS,outSMS.charAt(i),"");
			}
		}
		$('#wiadomosc-tresc').val(newSMS);
	}
	
	function replace(originalString, searchText, replaceText){
	
		var strLength = originalString.length;
		var txtLength = searchText.length;
		if((strLength==0)||(txtLength==0)){
			return originalString;
		}
		
		var i = originalString.indexOf(searchText);
		if((!i)&&(searchText!=originalString.substring(0, txtLength))){
			return originalString;
		}
		
		if(i==-1){
			return originalString;
		}
		
		var newstr = originalString.substring(0,i) + replaceText;
		
		if(i+txtLength < strLength){
			newstr += replace(originalString.substring(i+txtLength, strLength),searchText, replaceText);
		}
		
		return newstr;
	}
	function trim(str, chars) {
		return ltrim(str, chars);
	}
	function ltrim(str, chars) {
		chars = chars || "\\s";
		return str.replace(new RegExp("^[" + chars + "]+", "g"), "");
	}
	function rtrim(str, chars) {
		chars = chars || "\\s";
		return str.replace(new RegExp("[" + chars + "]+$", "g"), "");
	}
	
	function walidujFormularz()
	{
		var bledy = 0;
		var css_blad = {borderColor: "red",color: "red"};
		var css_ok = {borderColor: "#d9d9d9",color: "#555"};
		if ($('.selectedContacts a').length == 0)
		{
			$('.selectedContacts').css(css_blad);
			bledy++;
		}
		else
		{
			$('.selectedContacts').css(css_ok);
		}
		if ($('#wiadomosc-tresc').val() == '')
		{
			$('#wiadomosc-tresc').css(css_blad);
			bledy++;
		}
		else
		{
			$('#wiadomosc-tresc').css(css_ok);
		}
		
		if (bledy == 0)
			return true;
		
		return false;
	}
	function wyslijWiadomosc()
	{
		$('#chat-send').hide();
		$('.chat-message .ajaxLoader').show();
		var odbiorcy = [];
		$('.contact-list li:visible a.active').each(function(){
			var id = $(this).attr('id').replace('ua-','');
			if (id > 0)
			{
				odbiorcy.push({
					id: id,
					email: $(this).attr('mail'),
					telefon: $(this).attr('telefon'),
					nazwa: $(this).find('span').text()
				});
			}
		});
		
		var rodzaj_wysylki = $('.rodzaj_wysylki a.active').attr('id');
		var wiadomosc = $('#wiadomosc-tresc').val();
		if (rodzaj_wysylki == 'tryb_sms')
		{
			wiadomosc = podpis+wiadomosc;
		}
		
		var obj = {
			rodzaj_wysylki: rodzaj_wysylki,
			id_bkt: id_bkt,
			id_get: id_get,
			odbiorcy: odbiorcy,
			wiadomosc: wiadomosc
		};
		
		$.ajax({
			url: '{{$url_ajax_wyslij}}',
			type: 'POST',
			dataType: 'json',
			data: obj,
			async: true,
			success: function(dane) {
				$('.komunikator .komunikaty_kontener').html(dane.komunikaty);
				if (dane.success)
				{
					odznaczKontakt($('.contact-list li a.active'));
					$('#wiadomosc-tresc').val('');
					czyscPowiazanie();
				}
				$('#chat-send').show();
				$('.chat-message .ajaxLoader').hide();
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var error = 'Sending message failed: '+xhr.status;
				if (thrownError != '')
				{
					error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
					error += xhr.responseText;
				}
				alertModal('AJAX request error', error);
				$('#chat-send').show();
				$('.chat-message .ajaxLoader').hide();
			}
		});
	}
	function switchTo(mode, id)
	{
		$('#alertModal .close').click();
		wybierzMetodeWysylki(mode);
		komunikator(id);
	}
	
	function kartaHistorii(href)
	{	
		$('.komunikator').height($('.komunikator').height);
		$('.komunikator .overlay').fadeIn("fast");
		$.ajax({
			url: href,
			type: 'GET',
			dataType: 'json',
			async: true,
			success: function(dane) {
				if (dane.status)
				{
					$('.komunikator').animate({
						width: '89%',
					}, 300, "linear");
					$('.historiaKomunikatora').html(dane.html);
					$('.historiaKomunikatora').show();
					$('.komunikatorMain').hide();
					$('.komunikator .overlay').hide();
					zmienRozmiarOknaHistoria();
				}
				else
				{
					$('#komunikator .komunikaty_kontener').html(dane.komunikaty);
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
				$('.komunikator .overlay').hide();
			}
		});
	}
	function zamknijKarteHistorii()
	{
		$('.komunikator').animate({
			width: '60%',
		}, 300, "linear");
		$('.historiaKomunikatora').hide().html();
		$('.komunikatorMain').show();
	}
	
	function ladujStarsze(uid)
	{
		$('.komunikator .overlay').fadeIn("fast");
		$.ajax({
			url: '{{$url_laduj_starsze}}',
			data: {uid: uid},
			type: 'GET',
			dataType: 'json',
			async: true,
			success: function(dane) {
				if (dane.status)
				{
					if (dane.html != '')
					{
						$('#historiaTabela .empty-row').remove();
					}
					$('#historiaTabela').append(dane.html);
					$('.komunikator .overlay').hide();
					$('#dataOd').html(dane.dataOd);
					$("#historiaLicznik").text($('#historiaTabela tr:not(".empty-row")').length);
					var $lastRow = $('#historiaTabela tr:last');
					$('.historia .tresc').animate({
						scrollTop: $($lastRow).offset().top
					}, 750);
				}
				else
				{
					$('#komunikator .komunikaty_kontener').html(dane.komunikaty);
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
				$('.komunikator .overlay').hide();
			}
		});
	}
</script>
{{END index}}

{{BEGIN zaslepka}}
<script type="text/javascript">
	function komunikator(p)
	{
		return false;
	}
</script>
{{END zaslepka}}