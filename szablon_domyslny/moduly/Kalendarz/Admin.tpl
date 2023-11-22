{{BEGIN angular}}
<style type="text/css">
	.komunikator{	top:115px;	}
</style>
<script src="/_system/js/jquery-3.0.js"></script>
<script src="/_system/js/bootstrap-editable.min.js"></script>
<script src="/_system/js/spectrum.js"></script>
<link rel="stylesheet" href="/_system/js/spectrum.css" />
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script type="text/javascript">

	var zaminyIstnieja = 0;
	/* filtry teamow */
	var limitDo = {{$limitDo}};
	var limitMax = {{$limitMax}};
	var limitOd = 1;
	
	// data start wyswietlanego kalendarza
	var dataStart = new Date('{{$dataStart}}');
	var dataStop = new Date('{{$dataStop}}');
	// data suwak stop
	var suwakStart = new Date('{{$suwakStart}}');
	// data suwak start
	var suwakStop = new Date('{{$suwakStop}}');
		
	var ilosc_dni = 0;
	var ilosc_dni_start = 0;
	var ilosc_dni_stop = 0;
	
	var szerokoscOkna;
	var szerokoscTeamu;
	var iloscTeamow;
	
	var $teamy;
	var $kolejnoscTeamy;
	var $daneDataTeam;
	var naglowek;
	var grupa = '{{$grupa}}';
	var przeniesEventTemp = [];
	
	var idEventZaznacz = {{$idEvent}}
	
	$(document).ready(initPage);
	
	function initPage()
	{
		$( window ).on( 'beforeunload' , function(e) {
			
			if(zaminyIstnieja)
			{
				 var message = 'You have unsaved stuff. Are you sure to leave?';
				 e.result = message;
				 e.returnValue = message;
				return message;
			}
		} );
		
		var Promise = ajax("{{$ulrPobierzTeamy}}" , succes, { grupa: grupa }, 'POST', 'json' );
		var PobierzDaneDataTeam = ajax("{{$urlPobierzDataTeam}}" , pobierzDaneDataTeam, { dataOd: dataStart.toISOString().substring(0, 10), dataDo: dataStop.toISOString().substring(0, 10) }, 'POST', 'json' );
		$('#divloader').show();
		$.when(
					PobierzDaneDataTeam,
					Promise
				)
		.done(function() 
		{
			setTimeout(function(){
				
				ustawDanePoczatkowe();
				generujTeamNaglowki(false);
				generujKalendarz(suwakStart, suwakStop, 1);
				ustawSliderData();
				ustawSzerokoscTeamu();
				ustawSliderPomocnik();
				klonujNaglowek();
				$(window).scroll(function() { scrollMenuSlider(); scrollTeamHead(); scrollDoGory() });
				ustawSpinner();
				$('.ui-spinner-button').on('click', function(){ iloscWyswietlanychTemow($(this)); } );
				addSortableFunction($('td.cal-team-data'), "td.cal-team-data");
				addResizableFunction();
				$('#divloader').hide(500);
				kolorPrzycisk($('#kolorTla'), '#90C3D4');
				kolorPrzycisk($('#kolorCzcionki'), '#000');
				
				if(idEventZaznacz > 0){ przejdzDoEventu(idEventZaznacz); selectEvent($('.event[data-id='+idEventZaznacz+']')); }
				
			}, 700);
			
		 });
		
		 $('.border').on('click', function(){
			 
			grupa = $(this).attr('data-grupa');
			$('#myTab').children('li').removeClass('active');
			$(this).parent('li').addClass('active');
			var Promise = ajax("{{$ulrPobierzTeamy}}" , succes, { grupa: grupa }, 'POST', 'json' );
			$.when(
					Promise
				)
			.done(function() 
			{
				setTimeout(function(){
					generujTeamNaglowki(true);
					ustawDanePoczatkowe();
					ustawSzerokoscTeamu();
					ustawSliderPomocnik();
					generujKalendarz(suwakStart, suwakStop, 1, true); 
					klonujNaglowek();
					ustawSpinner();
					addSortableFunction($('td.cal-team-data'), "td.cal-team-data");
					addResizableFunction();
					$('input[type=checkbox]').uniform();
					
				}, 500);
			 });
		});
		
		$(document).on('keydown', function(e){ przejdzDoEventuStrzalki(e);	});
		$(document).on('click', "#runButton", function(e){ uruchomBiezaceEventy();	});
		$(document).on('mousedown',".event", function (e) { if(e.button == 0){ selectEvent($(this)); return false; } });
		$(document).on('click', '.cal-team-zdjecia-wiecej',function(){	pokazCalyteam($(this));  });
		$(document).on('click', '.resize-data',function(){	powiekszData($(this), null);  });
		$(document).on('click', '.close-komentarz' ,function(){ $('#komentarzBox').hide("slide", { direction: "right" }, 300); });
		$(document).on('click', '#podgladZamowienia',function(){	podgladZamowienia($('#menuIdTeam').val());  });
		$(document).on('click', '.dodajEvent',function(){	dodajEvent( $(this).attr('id') ); });
		$(document).on('click', '#podgladKomentarz',function(){ podgladKomentarz(false, false); });
		$(document).on('click', '#edytujKomentarz',function(){ podgladKomentarz(true, false); });
		$(document).on('click', '#dodajKomentarz',function(){ podgladKomentarz(true, true); });
		$(document).on('click', '#zaznaczPodobneTeam',function(){ zaznaczPodobne('team'); });
		$(document).on('click', '#zaznaczPodobneEvent',function(){ zaznaczPodobne('event'); });
		$(document).on('click', '.team-resize',function(){ powiekszTeam($(this)); });
		$(document).on('click', '.edycjaTeamu',function(){ edycjaTeamu($(this)); return false; });
		$(document).on('click', '#usunKomentarz',function(){ usunKomentarz(); });
		$(document).on('mousedown mouseover',".zezwolZaznacz", function (e) { selectDay( $(this) , e); return false; });
		$(document).on('contextmenu','.cal-team-data', function(e){ menuPodreczne(e, $(this)); return false; });
		$(document).on('contextmenu','.event', function(e){ menuPodreczne(e, $(this)); return false; });
		$(document).on('contextmenu','.cal-godzina-team', function(e){ menuPodreczne(e, $(this)); return false; });
		$(document).on('click', '#usunPrzypisanie', function(){ $('.close-menu').click(); potwierdzenieModal1( "{{$potwierdzUsunPrzypisanie}}", 'Confirm', 'usunPrzypisanie()' ); } );
		$(document).on('click', '#usunNotatke', function(){ $('.close-menu').click(); potwierdzenieModal1( "{{$potwierdzUsunPrzypisanie}}", 'Confirm', 'usunPrzypisanie()' ); } );
		$(document).on('click', '#usunPowiadomienie', function(e){ $('.close-menu').click(); usunPowiadomienie(); } );
		$(document).on('click', '#konfiguracja', function(){ modalAjax( "{{$urlKonfiguracja}}" ); } );
		$(document).on('click', '.wynik', function(){ przejdzDoEventu($(this).data().id); })
		
		$('#czyscZaznaczenie, #czyscZaznaczenie2').on('click', function(){ $('.selected').removeClass('selected'); $('.selectedEvent').removeClass('selectedEvent'); $('.close-menu').click(); });
		$('#do-gory').on('click', function(){ doGory(); });
		$('.cal-przesun').on('click', function(){ scrollTablePomocnik($(this).attr('id'), true);	});
		$('#filtruj').on('click', function(){ filtrujTeam(); });
		$('#czyscFiltr').on('click', function(){ czyscFiltr(); });
		$('.close-menu').on('click', function(){ $('#menuPodreczne').hide(300); });
		$('.close-menu-copy').on('click', function(){ $('#menuCopy').hide(300); });
		$('#wczytaj-wiecej-dat').on('click', function(){ wczytajWiecej();  })
		$('#pokazSzczegolyDnia').on('click', function() { pokazSzczegolyDniaTeamu(); });
		$('#kolorTla').on('change', function(){ zmienKolor('tlo'); })
		$('#kolorCzcionki').on('change', function(){ zmienKolor('czcionka'); })
		$('.eventFiltr').on('change', function(){ filtrujTypEventu(); })
		$('#zamknijWynik').on('click', function(){ czyscWynik(); })
		
		wyszukiwarka();
	}
	
	function ustawZmianyIstnieja()
	{
		zaminyIstnieja = 1;
		$('#runButton').show();
	}
	
	function uruchomBiezaceEventy()
	{
		ajax("{{$urlUruchomBiezaceZadania}}" , potwierdzEventyWykonane, {}, 'POST', 'json' );
	}
	
	function potwierdzEventyWykonane()
	{
		zaminyIstnieja = 0;
	}
	
	function odswiezDane()
	{
		var PobierzDaneDataTeam = ajax("{{$urlPobierzDataTeam}}" , pobierzDaneDataTeam, { dataOd: dataStart.toISOString().substring(0, 10), dataDo: dataStop.toISOString().substring(0, 10) }, 'POST', 'json' );
		$('#divloader').show();
		$.when(
					PobierzDaneDataTeam
				)
		.done(function()
		{
			setTimeout(function(){
				
				generujKalendarz(suwakStart, suwakStop, 1);
				addSortableFunction($('td.cal-team-data'), "td.cal-team-data");
				addResizableFunction();
				//$(document).on('mousedown mouseover',".zezwolZaznacz", function (e) { selectDay( $(this) , e); return false; });
				
				$('#divloader').hide(500);
			}, 700);
			
		 });
	}
	
	function przejdzDoEventuStrzalki(e)
	{
		if(e.which == 40 && $('#wyniki').is(':visible'))
		{
			if($('li.zaznacz').length > 0 )
			{
				var element = $('li.zaznacz').removeClass('zaznacz').next('li');
			}
			else
			{
				var element = $('#wyniki ul').children('li:first');
			}
			$('#wyniki').scrollTop(element.position().top);
			element.addClass('zaznacz');
			element.click();
		}
		else if(e.which == 38 && $('#wyniki').is(':visible'))
		{
			if($('li.zaznacz').length > 0 )
			{
				var element = $('li.zaznacz').removeClass('zaznacz').prev('li');
			}
			else
			{
				var element = $('#wyniki ul').children('li:first');
			}
			$('#wyniki').scrollTop(element.position().top);
			element.addClass('zaznacz');
			element.click();
		}
	}
	
	function przejdzDoEventu(idEventu)
	{
		var element = $('.event[data-id='+idEventu+']');
		
		$('.wynik').removeClass('zaznacz');
		$('#wynik-'+idEventu).addClass('zaznacz');
		
		$('html, body').animate({
			scrollTop: (element.offset().top - 170),
		}, 0);
		$('.inner').scrollLeft(0);
	  	
		var parentElement = element.parent('.cal-team-data');
		var left = parentElement.position().left - 220;
		
		$( "#slider" ).slider( "value", left);
	  
	  	$('.inner').animate({
			scrollLeft: left,
	  }, 0);
	}
	
	function czyscWynik(){ $('#fraza').val(''); $('#wyniki').hide(); $('#wyniki ul').children('li').remove();  }
	
	function wyszukiwarka()
	{
		$("#fraza").keyup(function(){
 
	      var filter = $(this).val(), count = 0;
	 	   
			if(filter.length > 2)
			{
				$('#wyniki').show();
				$('#zamknijWynik').show();
				$(".event").each(function(){
					var daneEventu = $(this).data();
					if($(this).text().search(new RegExp(filter, "i")) < 0)
					{
						$('#wynik-'+daneEventu.id).remove();
					}
					else 
					{
						$('#wynik-0').remove();
						if($('#wynik-'+daneEventu.id).length == 0)
							$('#wyniki').children('ul').append('<li class="wynik" id="wynik-'+daneEventu.id+'" data-id="'+daneEventu.id+'"><strong>'+$teamy[daneEventu.team].teamNumber+'</strong> | <strong>'+daneEventu.data+'</strong> | '+$(this).text()+'</li>')
						
						count++;
		      	}
				});


				var numberItems = count;
				$("#filter-count").text("{{$znaleziono_zamowien}}"+count);
			}
			else
			{
				$('#zamknijWynik').hide();
				$('#wyniki').hide();
				$('#wyniki ul').children('li').remove();
			}
			if(count == 0 && $('#wynik-0').length == 0)
			{
				$('#wyniki').children('ul').append('<li id="wynik-0">{{$pusta_lista_wyszukiwania}}</li>');
			}
			
			
		});
	}

	function filtrujTypEventu()
	{
		var PobierzDaneDataTeam = ajax("{{$urlPobierzDataTeam}}" , pobierzDaneDataTeam, { typ: $('.eventFiltr').val() , dataOd: dataStart.toISOString().substring(0, 10), dataDo: dataStop.toISOString().substring(0, 10) }, 'POST', 'json' );
		$.when(
				PobierzDaneDataTeam
			)
		.done(function() 
		{
			setTimeout(function(){
				generujTeamNaglowki(true);
				ustawDanePoczatkowe();
				ustawSzerokoscTeamu();
				ustawSliderPomocnik();
				generujKalendarz(suwakStart, suwakStop, 1, true); 
				klonujNaglowek();
				ustawSpinner();
				$('input[type=checkbox]').uniform();
				addSortableFunction($('td.cal-team-data'), "td.cal-team-data");
			}, 500);
		 });
	}
	
	function potwierdzPrzeniesEvent(dane)
	{
		if(dane.blad > 0){
			$('.cal-team-data[data-team='+dane.oldTeam+'][data-data='+dane.oldData+']').prepend($('.event[data-id='+dane.id+']'));
			alertModal('Error!', dane.komunikat); 
			return false; 
		}
		
		$('#menuCopy').hide();
		przeniesEventTemp = [];
		odswiezDane();
	}
	
	function zmienKolor(typ)
	{
		if($('.selectedEvent').length == 0) return false;
		var ids = [];
		if(typ == 'czcionka')
		{
			var kolor = $('#kolorCzcionki').val();
			$.each($('.selectedEvent'), function(index, event){
				ids.push($(this).attr('data-id'));
				
				$(this).css('color', kolor);
			});
		}
		else if(typ == 'tlo')
		{
			var kolor = $('#kolorTla').val();
			$.each($('.selectedEvent'), function(index, event){
				ids.push($(this).attr('data-id'));
				$(this).css('background-color', $('#kolorTla').val());
			});
		}
		
		var dane = {
			ids: ids,
			kolor: kolor,
			typ: typ,
		};
		ajax("{{$urlZmienKolor}}" , potwierdzZmienKolor,  dane , 'POST', 'json' );
		
		
	}
	function potwierdzZmienKolor(dane)
	{
		if(dane.blad > 0)	alertModal('Error!', dane.komunikat);
	}
	
	function kolorPrzycisk(obiekt, kolorDomyslny)
	{
		obiekt.spectrum({
			color: kolorDomyslny,
			showInput: true,
			className: "full-spectrum",
			showInitial: true,
			showPalette: true,
			showSelectionPalette: true,
			maxSelectionSize: 10,
			preferredFormat: "hex",
			localStorageKey: "spectrum.demo",

			palette: [
				 ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)",
				 "rgb(204, 204, 204)", "rgb(217, 217, 217)","rgb(255, 255, 255)"],
				 ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
				 "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"], 
				 ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)", 
				 "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)", 
				 "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)", 
				 "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)", 
				 "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)", 
				 "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
				 "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
				 "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
				 "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)", 
				 "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
			]
	  });
	}
	
	function wylaczZaznaczanie()
	{
		$(document).off('mousedown mouseover',".zezwolZaznacz");
	}
	
	function wlaczZaznaczanie()
	{
		$(document).on('mousedown mouseover',".zezwolZaznacz", function (e) { selectDay( $(this) , e); return false; });
	}
	
	function addResizableFunction()
	{
		$('.event').resizable({
			 containment: 'document',
			 autoHide: true,
			 handles : "s",
			 start: function( event, ui ) {
				ui.element.css('position', 'absolute').css('z-index', '2');
				wylaczZaznaczanie();
			 },
			 stop:  function( event, ui ) {
				ustawZmianyIstnieja();
				ui.element.hide();
				var el = document.elementFromPoint( event.clientX , (event.clientY + 30));
				
				var data = {
					dataStop: el.getAttribute('data-data'),
					dataStart: ui.element.attr('data-data'),
					idTeam: ui.element.attr('data-team'),
					idEvent: ui.element.attr('data-id'),
				};
				ui.element.show();
				ajax( '{{$urlRozszerzEvent}}', potwierdzResizable, data, 'POST', 'json' );
				wlaczZaznaczanie();
			 }
		});
	}
	
	function potwierdzResizable()
	{
		odswiezDane();
	}
	
	function addSortableFunction(obiekt, conectedWith)
	{
		obiekt.sortable({
			items : ".event",
			connectWith: conectedWith ,
			cursor: "move",
			scrollSpeed: 40,
			tolerance: "intersect",
			placeholder: "placeholder",
			zIndex: 9999,
			start: function( event, ui ) {
				$(document).off('mousedown mouseover',".zezwolZaznacz");
				if(!ui.item.hasClass('selectedEvent'))
				{
					selectEvent(ui.item);
				}
				//ui.item.addClass('selectedEvent');
			},
			 
			update: function(event, ui) {
				
				menuKopiujKlonuj(event);
				
				var oldData = ui.item.attr('data-data');
				var oldTeam = ui.item.attr('data-team');
				
				var id = ui.item.attr('data-id');
				var eventDane = $daneDataTeam[ui.item.attr('data-data')][ui.item.attr('data-team')][ui.item.attr('data-id')];
				
				var newData = ui.item.parent('td').attr('data-data');
				var newTeam = ui.item.parent('td').attr('data-team');

				if(oldData != newData || oldTeam != newTeam)
				{
					var ids = []
					var dataStop = '';
					$('.selectedEvent[data-team='+oldTeam+']').each(function(){
						
						ids.push($(this).attr('data-id'));
						dataStop = $(this).attr('data-data');
						
					});
					przeniesEventTemp = {
						id: id,
						ids: ids,
						idTeam: newTeam,
						dataStara: oldData,
						dataNowa: newData,
						idEvent: eventDane['idEvent'],
					}
					ustawZmianyIstnieja();
					//ajax("{{$urlPrzeniesEvent}}" , potwierdzPrzeniesEvent,  dane , 'POST', 'json' );
				}

			}
	  });
	}
	
	function kopiujEvent()
	{
		ajax("{{$urlPrzeniesEvent}}" , potwierdzPrzeniesEvent,  przeniesEventTemp , 'POST', 'json' );
	}
	
	function klonujEvent()
	{
		ajax("{{$urlKlonujEvent}}" , potwierdzPrzeniesEvent,  przeniesEventTemp , 'POST', 'json' );
	}
	
	function usunSortowanie(obiekt)
	{
	   obiekt.sortable("destroy"); 
		obiekt.removeClass('ui-sortable');
	}
	function odznaczPodobne(typZaznaczenia)
	{
		var idTeam = $('#menuIdTeam').val();
		var data = $('#menuData').val();
		var idEvent = $('#menuId').val();
		
		var typ = $daneDataTeam[data][idTeam][idEvent].typ;
		var idObiektu = $daneDataTeam[data][idTeam][idEvent].idObiekt;
		
		if(typZaznaczenia == 'team')
		{
			$.each($daneDataTeam, function(index, dane){
				$.each(dane[idTeam], function(idEvent, event ){
					
					if(event.typ == typ && event.idObiekt == idObiektu && $('.event[data-id='+idEvent+']').hasClass('selectedEvent'))
						$('.event[data-id='+idEvent+']').removeClass('selectedEvent');
					
				});
			});
		}
		
	}
	
	function zaznaczPodobne(typZaznaczenia)
	{
		var idTeam = $('#menuIdTeam').val();
		var data = $('#menuData').val();
		var idEvent = $('#menuId').val();

		var typ = $daneDataTeam[data][idTeam][idEvent].typ;
		var idObiektu = $daneDataTeam[data][idTeam][idEvent].idObiekt;
		
		if(typZaznaczenia == 'team')
		{
			$.each($daneDataTeam, function(index, dane){
				$.each(dane[idTeam], function(idEvent, event ){
					
					if(event.typ == typ && event.idObiekt == idObiektu && !$('.event[data-id='+idEvent+']').hasClass('selectedEvent'))
						$('.event[data-id='+idEvent+']').addClass('selectedEvent');
					
				});
			});
		}
		else if(typZaznaczenia == 'event')
		{
			$.each($daneDataTeam, function(index, dane){
				$.each(dane, function(idTeam, teamEvent ){
					$.each(teamEvent, function(idEvent, event){
						if(event.typ == typ && event.idObiekt == idObiektu && !$('.event[data-id='+idEvent+']').hasClass('selectedEvent'))
							selectEvent($('.event[data-id='+idEvent+']'));
					})
				});
			});
		}
		
		$('.close-menu').trigger('click');
	}
	
	function selectEvent(obiekt){
		
		$('#menuIdTeam').val(obiekt.attr('data-team'));
		$('#menuData').val(obiekt.attr('data-data'));
		$('#menuId').val(obiekt.attr('data-id')); 
			
		if(obiekt.hasClass('selectedEvent'))
		{
			obiekt.toggleClass('selectedEvent');  
			odznaczPodobne('team');
		}
		else
		{
			obiekt.toggleClass('selectedEvent');  
			zaznaczPodobne('team');	
		}
	}
	
	function ustawSpinner()
	{
		$('#limitDo').val(limitDo);
		var max = (limitMax > 20) ? 20 : limitMax;
		$('#limitDo').spinner({	min:1,	max: max });
	}
	function wczytajWiecej()
	{
		var s = $( "#dateSlider" );
		suwakStop.setMonth(suwakStop.getMonth() + 1);
		$('#dataStop').val(suwakStop.toISOString().substring(0, 10));
		s.slider("option", "stop").call(s, null, { values:  [ ilosc_dni_start, 300 ] })
	}
	function usunPrzypisanie()
	{
		$('.close').click();
		//if(!czyZaznaczony()) return false;
		var idMenu = $('#menuId').val();
		
		var usunPrzypisanie = [];
		if($('.selectedEvent').length)
		{
			$('.selectedEvent').each(function(){
				usunPrzypisanie.push($(this).attr('data-id'));
			});
		}
		else
		{
			usunPrzypisanie.push(idMenu);
		}
		
		ajax("{{$urlUsunPrzypisanie}}" , potwierdzUsunPrzypisanie, { usun: usunPrzypisanie }, 'POST', 'json' );
	}
	
	function potwierdzUsunPrzypisanie(dane)
	{
		if(dane.blad > 0)	alertModal('Error!', dane.error);
		
		$.each(dane.usuniete, function(index, value){
			$('.event[data-id='+value+']').remove();
		});
	}
	
	function usunPowiadomienie()
	{
		//var id = $daneDataTeam[$('#menuData').val()][$('#menuIdTeam').val()].id;
		var id = $('#menuId').val();
		ajax("{{$urlUsunPrzypomnienie}}" , potwierdzUsunPowiadomienie, { id: id, }, 'POST', 'json' );
	}
	function potwierdzUsunPowiadomienie(dane){ if(dane.blad > 0){ alertModal('Error!', dane.error); }else{ $('.event[data-id='+dane.id+']').find('.icon-time').remove(); }	$('.close-menu').click();   }
	function usunKomentarz()
	{
		//var id = $daneDataTeam[$('#menuData').val()][$('#menuIdTeam').val()].id;
		var id = $('#menuId').val();
		ajax("{{$urlZapiszKomentarz}}" , potwierdzUsunKomentarz, { pk: id, value: '' }, 'POST', 'json' );
	}
	function potwierdzUsunKomentarz(dane){ if(dane.blad > 0){ alertModal('Error!', dane.tresc); }else{ $('.event[data-id='+dane.id+']').find('.icon-comment').remove(); }	$('.close-menu').click(); }
	function podgladKomentarz(edycja, dodajNowy)
	{
		var idTeam = $('#menuIdTeam').val();
		var dataTeam = $('#menuData').val();
		var id = $('#menuId').val();
		var event = $('.event[data-team='+idTeam+'][data-data='+dataTeam+']');
		var element = $('#menuPodreczne');
		//var top = ($('#cal-menu').hasClass('move')) ? element.position().top + 100 : element.position().top + 150;
		$('#komentarzBox').css('left', element.position().left - 100).css('top', element.position().top - 100).show("slide", { direction: "right" }, 300);
		$('.editableT').text($daneDataTeam[dataTeam][idTeam][id].komentarzTxt).attr('id', 'i-' + $daneDataTeam[dataTeam][idTeam][id].id );
		
		$('#i-' + $daneDataTeam[dataTeam][idTeam][id].id).editable({
			mode: 'popup',
			pk: function(){
				return $(this).attr('id').replace('i-', '');
			},
			url: '{{$urlZapiszKomentarz}}',
			success: function(response, newValue) {  if(response.status == 'error'){ return response.msg; }else{ $daneDataTeam[dataTeam][idTeam][id].komentarzTxt = newValue; $daneDataTeam[dataTeam][idTeam][id].komentarz = 1; if(dodajNowy){ event.prepend('<i class="icon icon-comment"></i> '); } return response.tresc; } }
		});
		
		$('.editableT').editable("setValue", $daneDataTeam[dataTeam][idTeam][id].komentarzTxt)  
		if(edycja){ setTimeout( function(){ $('.editableT').click(); }, 500 ); }
		$('.close-menu').click();
	}
	
	function dodajEvent(typ)
	{
		if(!czyZaznaczony()) return false;
		var tab = pobierzZaznaczone();
		
		//modalAjax("{{$urlDodajEvent}}"+'&idTeam='+tab['team']+'&idUser='+tab['user']+'&typ='+typ+'&eTyp='+tab['eTyp'], {width: 1200, height: 1000});
		modalAjax("{{$urlDodajEvent}}"+'&typ='+typ, {width: 1200, height: 1000}, 'POST', tab);
		$('.close-menu').click();
	}
	
	function pobierzZaznaczone()
	{
		var dataTeam = {};
		var godzina = null;
		var idUser = null;
		var eTyp = null;
				
		$('.selected').each(function(){
			if($(this).hasClass('cal-godzina-team'))
			{
				var $data = $(this).parents('td').attr('data-data');
				var $team = $(this).parents('td').attr('data-team');
				godzina = $(this).attr('data-godzina');
				eTyp = 'eTeam';
			}
			else if($(this).hasClass('cal-data-user'))
			{
				var $data = $(this).parents('td').attr('data-data');
				var $team = $(this).parents('td').attr('data-team');
				idUser = $(this).attr('data-user');
				eTyp = 'eUser';
			}
			else
			{
				var $data = $(this).attr('data-data');
				var $team = $(this).attr('data-team');
				eTyp = 'eTeam';
			}

			if (!dataTeam[$data]) dataTeam[$data] = {};
			if (!dataTeam[$data][$team]) dataTeam[$data][$team] = { istnieje: true };
			if (godzina != null)
			{
				if (!dataTeam[$data][$team]['godziny']) dataTeam[$data][$team]['godzina'] = [];
				dataTeam[$data][$team]['godziny'].push(godzina);
			}
			if (idUser != null)
			{
				if (!dataTeam[$data][$team]['users']) dataTeam[$data][$team]['users'] = [];
				dataTeam[$data][$team]['users'].push(idUser);
			}
		});
		/*
		$('.selected').each(function(){
			if($(this).hasClass('cal-godzina-team'))
			{
				if(!tab['team'][$(this).parents('td.cal-team-data').attr('data-team')]) tab['team'].push($(this).parents('td.cal-team-data').attr('data-team'));
				tab['eTyp'] = 'eTeam';
				
				var $data = $(this).parents('td').attr('data-data');
				var $team = $(this).parents('td').attr('data-team');
				godzina = $(this).attr('data-godzina');
			}
			else if($('.selected').hasClass('cal-data-user'))
			{
				if(!tab['user'][$(this).attr('data-user')]) tab['user'].push($(this).attr('data-user'));
				tab['eTyp'] = 'eUser';
				var $data = $(this).parents('td').attr('data-data');
				var $team = $(this).parents('td').attr('data-team');
				idUser = $(this).attr('data-user');
			}
			else if($('.selected').hasClass('cal-godzina-user'))
			{

				if(!tab['user'][$(this).attr('data-user')]) tab['user'].push($(this).attr('data-user'));
				tab['eTyp'] = 'eUser';
				
			}
			else
			{
				if(!tab['team'][$(this).attr('data-team')]) tab['team'].push($(this).attr('data-team'));
				tab['eTyp'] = 'eTeam';
				var $data = $(this).attr('data-data');
				var $team = $(this).attr('data-team');
			}
		});
		*/
		
		return {
			dataTeam: dataTeam,
			eTyp: eTyp,
		};
	}
	
	function doGory(){ $("html, body").animate({ scrollTop: 0 }, 500); }
	function czyZaznaczony(){ if($('.selected').length > 0){ return true; }else{ alertModal('Notice', '{{$nieZaznaczonoDatyKomunikat}}'); return false; } }
	function selectDay(obiekt, e)
	{
		if (e.buttons == 1 || e.buttons == 3) { (obiekt.hasClass('selected')) ? obiekt.removeClass('selected') : obiekt.addClass('selected');	}
	}
	
	function klonujNaglowek()
	{
		if(typeof naglowek !== 'undefined')
			naglowek.remove();

		naglowek = $('#cal-tabela thead').clone();
		naglowek.find('#cal-data').remove();
		naglowek.find('.remove').remove();
		naglowek.find('th').css('height', 'auto');
		naglowek.find('.cal-team-kontener').css('font-size', '18px');
		naglowek.addClass('cloneNaglowek');
		$('#cal-tabela').append(naglowek);
		naglowek.hide();
	}
	
	function scrollTeamHead()
	{
		if($('#cal-tabela').offset().top < $(window).scrollTop() && !naglowek.hasClass('moveHead'))
		{
			var teamRozszezony = naglowek.find('.uzytkownicyTeamuLista');
			if(teamRozszezony.length > 0)
			{
				naglowek.find('.cal-team-bil').hide();
				naglowek.find('.icon-truck').hide();
			}
				
			naglowek.addClass('moveHead');
			naglowek.show();
		}
		if(naglowek.hasClass('moveHead'))
		{
			
			naglowek.css('top', $(window).scrollTop() - 226);
		}
		var pozycja = 315;
		if(parseInt($(window).scrollTop()) < pozycja && naglowek.hasClass('moveHead'))
		{
			naglowek.removeClass('moveHead');
			naglowek.find('.cal-team-bil').show();
			naglowek.find('.icon-truck').show();
			naglowek.hide();
		}
	}
	
	function scrollDoGory()
	{
		var pozycja = 500;
		if(pozycja < $(window).scrollTop())	$('#do-gory').show(500);
		if(parseInt($(window).scrollTop()) < pozycja ) $('#do-gory').hide(500);
	}
	
	function scrollMenuSlider()
	{
		var width = $('#cal-menu').width();
		if($('#cal-menu').offset().top < $(window).scrollTop() && !$('#cal-menu').hasClass('move')){ $('#cal-menu').addClass('move').css('width', width);  }
		var pozycja = 315;
		if(parseInt($(window).scrollTop()) < pozycja && $('#cal-menu').hasClass('move')) $('#cal-menu').removeClass('move');
	}
	
	function succes(dane) {
		if(dane.warning > 0) { alertModal('Warning!', dane.warningTxt); }
		
		$teamy = dane.teamy; $kolejnoscTeamy = dane.kolejnosc; limitMax = Object.keys($teamy).length;
	}
	function pobierzDaneDataTeam(dane) { $daneDataTeam =  dane; };
	function edycjaTeamu(obiekt) { modalAjax(obiekt.attr('href')+'&id='+obiekt.attr('id').replace('edytuj-', '')); return false; };
	
	function menuPodreczneGodzinaUser(e)
	{
		$('#pokazSzczegolyDnia').hide();
		$('#dodajProjekt').hide();
		menuPodreczne(e);
		return false;
	}
	
	function pokazSzczegolyDniaTeamu()
	{
		var team = $('#menuIdTeam').val();
		var data =  $('#menuData').val();
		
		$('#menuPodreczne').hide();

		$('th.cal-team').filter('[data-team="'+team+'"]').find('.team-resize').click();
		powiekszData($('th.cal-data').children('button[data-data='+data+']'), $teamy[team].pracownicy);
	}
	
	function pokazMenuPodreczneDataTeam(obiekt, e)
	{
		$('#pokazSzczegolyDnia').show();
		$('#dodajProjekt').show();
		$('#menuIdTeam').val(obiekt.attr('data-team'));
		$('#menuData').val(obiekt.attr('data-data'));
		menuPodreczne(e);
		
	}
	
	function ustawDanePoczatkowe()
	{
		// suwakStop.setMonth(suwakStart.getMonth() + 5);
		var mDate_od = dataStart.getTime();
		var mDate_do = dataStop.getTime();
		
		ilosc_dni = liczDni(dataStart, dataStop); 
		ilosc_dni_start = liczDni(dataStart, suwakStart);
		ilosc_dni_stop = liczDni(dataStart, suwakStop);
	
		szerokoscOkna = $('.inner').width() - $('#cal-tabela').css('margin-left').replace('px', '');
	}
	
	function powiekszData(obiekt, users)
	{
		var godziny = { 6:'6:00', 7: '7:00' ,  8: '8:00' ,  9: '9:00' ,  10: '10:00' ,  11: '11:00' ,  12: '12:00' , 
			13: '13:00' ,  14: '14:00' ,  15: '15:00' ,  16: '16:00' ,  17: '17:00' ,  18: '18:00' ,  19: '19:00' ,  20: '20:00' ,
			21: '21:00' , 22: '22:00' , 23: '23:00' , 24: '24:00' , 1: '1:00' , 2: '2:00' , 3: '3:00' , 4: '4:00' , 5: '5:00' ,
		};
		
		if(obiekt.hasClass('In'))
		{
			if($('span.team-resize').hasClass('Out'))
			{
				if($('th.cal-team:visible').attr('data-team').length)
					users = $teamy[$('th.cal-team:visible').attr('data-team')].pracownicy
				
				obiekt.parents('tr.cal-row').attr('style', 'height:600px;');
				
				//var godzinyUzytkownika = $('#tabelaGodzinyTeam table').clone();
				var godzinyUzytkownikaDodaj = $('#tabelaGodzinyTeam table').clone();
				
				$.each(godziny, function(index, godzina){
					//var tr = godzinyUzytkownika.find('tr').clone();
					var tr = jQuery('<tr/>', { } );
					$.each(users, function (uIndex, user){
						var td = jQuery('<td/>', { 'data-user': user.id, 'data-godzina': index, 'class': 'cal-godzina-user zezwolZaznacz' } ).text(godzina);
						tr.append(td);
					})
					godzinyUzytkownikaDodaj.append(tr);
				})
				godzinyUzytkownikaDodaj.attr('style', 'margin-left:-9px;');
				obiekt.parents('tr.cal-row').children('td:visible').find('.uzytkownicyTeamuListaDat').hide();
				obiekt.parents('tr.cal-row').children('td:visible').removeClass('zezwolZaznacz').append(godzinyUzytkownikaDodaj);
				godzinyUzytkownikaDodaj.show();
				
			}
			else
			{
				obiekt.parents('tr.cal-row').attr('style', 'height:600px;');
				obiekt.parents('tr.cal-row').children('td').each(function(index, element){
					$(this).children('.event').hide();
					var atrybuty = $(this).data();
					var godziny = $('#tabelaGodziny .godziny').clone();
					$(this).removeClass('zezwolZaznacz');
					$(this).append(godziny);
					godziny.show();
					if(typeof $daneDataTeam[atrybuty.data] != 'undefined' && typeof $daneDataTeam[atrybuty.data][atrybuty.team] != 'undefined')
					{
						$.each($daneDataTeam[atrybuty.data][atrybuty.team], function(index, dane){
							if(dane.godziny != null){
								$.each(dane.godziny, function(gIndex, godzinaWartosc){
									var event = addEventElement(atrybuty.team, atrybuty.data, dane.kolor, dane.kolorCzcionki, dane.id, dane.nazwa, dane.powiadomienie, dane.komentarz);
									godziny.find('td[data-godzina=\''+godzinaWartosc+'\']').append(event);
								});
							}
						});
					}
				});
				
				//usunSortowanie($('td.cal-team-data'));
				//addSortableFunction($('td.cal-godzina-team'), 'td.cal-godzina-team');
			}
		}
		else
		{
			if($('span.team-resize').hasClass('Out'))
			{
				obiekt.parents('tr.cal-row').removeAttr('style').children('td:visible').find('.uzytkownicyTeamuListaDat').show();
				obiekt.parents('tr.cal-row').children('td:visible').find('.godziny').remove();
			}
			else
			{
				obiekt.parents('tr.cal-row').attr('style', 'height:auto;');
				obiekt.parents('tr.cal-row').children('td').each(function(index, element){
					//$(this).addClass('zezwolZaznacz').css('padding', '8px').find('table').remove();
					$(this).find('.event').show();
					$(this).addClass('zezwolZaznacz').removeAttr('style').find('table').remove();
				});
			}
			//usunSortowanie($('td.cal-godzina-team'));
			//addSortableFunction($('td.cal-team-data'), 'td.cal-team-data');
		}

		obiekt.toggleClass('In Out');
	}
	
	function powiekszTeam(obiekt)
	{
		czyscFiltr();
		var wiersz = obiekt.parents('.cal-team').attr('data-count');
		teamId = obiekt.parents('th').attr('data-team');
		
		if(obiekt.hasClass('In'))
		{
			obiekt.toggleClass('In Out');
			obiekt.parent('.cal-team-menu').find('.filtrTeam').prop('checked',true);
			obiekt.parents('.cal-team').find('.info').attr('style', 'display:inline');
			$.uniform.update();
			filtrujTeam();
			var width = 100 / $teamy[teamId].iloscPracownikow;
			var szczegolyUzytkownicy = $('#userListHead table').clone();
			var szczegolyUzytkownicyData = $('#userDataList table').clone();
			// $('.resize-data.Out')
			for(var i = 0; i < $teamy[teamId].iloscPracownikow; i++)
			{
				var pracownik = szczegolyUzytkownicy.find('tr th').clone();
				var pracownikDane = szczegolyUzytkownicyData.find('tr td').clone();
				
				pracownikDane.attr('data-user', $teamy[teamId]['pracownicy'][i].id);
				
				pracownik.css('width', width+'%');
				pracownikDane.css('width', width+'%');
			
				pracownik.append($teamy[teamId]['pracownicy'][i].imie+' '+$teamy[teamId]['pracownicy'][i].nazwisko);
				pracownik.children('img').attr('src', $teamy[teamId]['pracownicy'][i].zdjecie);
				
				szczegolyUzytkownicy.prepend(pracownik);
				szczegolyUzytkownicyData.prepend(pracownikDane);
			}
			szczegolyUzytkownicy.find('tbody').remove();
			szczegolyUzytkownicyData.find('tbody').remove();
			obiekt.parents('.cal-team').append(szczegolyUzytkownicy);
			
			var wierszTab = $('td.cal-team-data').filter('[data-count="'+wiersz+'"]');
			wierszTab.removeClass('zezwolZaznacz').addClass('powiekszTeam').append(szczegolyUzytkownicyData);
			wierszTab.find('.event').hide();
			
			$.each(wierszTab, function(){
				var parametryWiersza = $(this).data();
				var element = $(this);
				if(typeof $daneDataTeam[parametryWiersza.data] != 'undefined' && typeof $daneDataTeam[parametryWiersza.data][parametryWiersza.team] != 'undefined')
				{
					$.each($daneDataTeam[parametryWiersza.data][parametryWiersza.team], function(idEvent, daneEvent){
						var event = addEventElement(parametryWiersza.team, parametryWiersza.data, daneEvent.kolor, daneEvent.kolorCzcionki, daneEvent.id, daneEvent.nazwa, daneEvent.powiadomienie, daneEvent.komentarz);
						event.show();
						element.children('.uzytkownicyTeamuListaDat').find('.cal-data-user[data-user='+daneEvent.user+']').append(event);
					});
				}
			});
			
			szczegolyUzytkownicy.show();
			limitDo = 1;
		}
		else
		{
			obiekt.parents('.cal-team').find('.info').removeAttr('style');
			obiekt.toggleClass('Out In');
			obiekt.parents('.cal-team').find('.uzytkownicyTeamuLista').remove();
			$('td.cal-team-data').filter('[data-count="'+wiersz+'"]').removeAttr('style').removeClass('powiekszTeam').addClass('zezwolZaznacz').find('.uzytkownicyTeamuListaDat').remove();
			$('td.cal-team-data').filter('[data-count="'+wiersz+'"]').find('.event').show();
			limitDo = $('#limitDo').val();
		}
		
		$(this).toggleClass('In Out');
		klonujNaglowek();
		
		ustawSzerokoscTeamu();
	}
	
//////////////////////////////////////////////////////////////
/// menu podreczne
//////////////////////////////////////////////////////////////
	function menuKopiujKlonuj(e)
	{
		var menuKopiujKlonuj = $('#menuCopy');
		
		var mouseX = e.pageX-200;
		var mouseY = e.pageY-90;
		menuKopiujKlonuj.css('left', mouseX);
		menuKopiujKlonuj.css('top', mouseY);
		menuKopiujKlonuj.show(300);
	}

	function menuPodreczne(e, obiekt)
	{
		var data = obiekt.attr('data-data');
		var team = obiekt.attr('data-team');
		var id = obiekt.attr('data-id');
		var menuPodreczne = $('#menuPodreczne');
		$('#menuIdTeam').val(team);
		$('#menuData').val(data);
		$('#menuId').val(id);
		
		menuPodreczne.find('li[data-grupa=zamowienie]').hide();
		menuPodreczne.find('li[data-grupa=notatka]').hide();
		menuPodreczne.find('li[data-grupa=komentarz]').hide();
		menuPodreczne.find('li[data-grupa=powiadomienie]').hide();
		menuPodreczne.find('li[data-grupa=selectedEvent]').hide();
		menuPodreczne.find('li[data-grupa=selected]').hide();
		menuPodreczne.find('li[data-grupa=event]').hide();
		menuPodreczne.find('li.wypelniony').hide();
		
		if(obiekt.hasClass('wypelnione'))
		{
			switch($daneDataTeam[data][team][id].typ)
			{
				case 'zamowienie' : menuPodreczne.find('li[data-grupa=zamowienie]').show();
					break;
				case 'note' : menuPodreczne.find('li[data-grupa=notatka]').show();
					break;
				default: break;
			}
			
			if(obiekt.children('.icon-comment').length) { menuPodreczne.find('li[data-grupa=komentarz]').not('.wypelniony').show(); }else{ $('li.wypelniony').show(); }
			
		}
		// jesli jakas kratka jest zazaczona to wyswietlamy w menu czyszczenie zaznaczenia	
		if($('.selected').length > 0 || $('.selectedEvent').length > 0)  menuPodreczne.find('li[data-grupa=selected]').show();
		if($('.selectedEvent').length > 0) menuPodreczne.find('li[data-grupa=selectedEvent]').show();
		
		if($('.selected').length > 0)
		{	
			if($('.selected').hasClass('cal-team-data'))
			{
				menuPodreczne.find('li.eTeam[data-grupa=event]').show();
			}
			if($('.selected').hasClass('cal-data-user'))
			{
				menuPodreczne.find('li.eUser[data-grupa=event]').show();
			}
			
		}
		// cal-team-data, cal-data-user, cal-godzina-team, cal-godzina-user
		
		if(obiekt.children('.icon-time').length) { menuPodreczne.find('li[data-grupa=powiadomienie]').show(); }
			
		var mouseX = e.pageX-200;
		var mouseY = e.pageY-90;
		menuPodreczne.css('left', mouseX);
		menuPodreczne.css('top', mouseY);
		menuPodreczne.show(300);
	}
	
	function podgladZamowienia(idZamowienia){	modalAjax("{{$urlPodgladZamowienia}}"+'&id='+idZamowienia); $('.close-menu').click(); return false; 	}
	
 
 ////////////////////////////////////////////////////////////////////////////////////////////////////////////
 ///////////////////////// FILTRY DLA TEAMOW ////////////////////////////////////////////////////////////////
 ////////////////////////////////////////////////////////////////////////////////////////////////////////////
 
	function pokazCalyteam(obiekt)
	{
		var pozycja = (obiekt.offset().left - obiekt.parent('.cal-team-zdjecia').offset().left);
		var id = obiekt.attr('id').replace('caly-team-', '');
		var elementPokaz = $('#caly-team-podglad-'+id);

		if(elementPokaz.is(':visible'))
		{
			elementPokaz.hide(300);
		}
		else
		{
			elementPokaz.css('left', pozycja);
			elementPokaz.show(300);
		}
		
	}
	/*
	 * czysci filtry dla temów ustawia stan poczatkowy
	 */
	function czyscFiltr()
	{
		limitDo = {{$limitDo}};
		limitMax = {{$limitDo}};
		limitOd = 0;
		$('#limitDo').val(limitDo);
		$('.inner').scrollLeft(0);
		$('input.filtrTeam:checked').prop('checked',false);
		$.uniform.update();
		
		$('.cal-team').show();
		$('.cal-row').show();
		$('.cal-team-data').show();
		
		ustawSzerokoscTeamu();
		ustawSliderPomocnik();
		
		scrollTablePomocnik();
		klonujNaglowek();
		addSortableFunction($('td.cal-team-data'), 'td.cal-team-data');
		$('.cal-team > .uzytkownicyTeamuLista').remove();
	}
	
	/*
	 * 
	 * filtruje wyswietlane teamy
	 */
	function filtrujTeam()
	{
		if($('input.filtrTeam:checked').length <= 0) return false;
		
		$('.cal-team').each(function( index, element){
			var teamId = $(this).attr('data-team');
			var row = $(this).attr('data-count');
			if( $('#filtr-'+teamId).is(':checked') )
			{
				$('.cal-team').filter('[data-count="'+row+'"]').show();
				$('.cal-team-data').filter('[data-count="'+row+'"]').show();
			}
			else
			{
				$('.cal-team').filter('[data-count="'+row+'"]').hide();
				$('.cal-team-data').filter('[data-count="'+row+'"]').hide();
			}
				
		});
		usunSortowanie($('td.cal-team-data'));
		addSortableFunction($('td.cal-team-data:visible'), 'td.cal-team-data');
		klonujNaglowek();
		limitDo = $('input.filtrTeam:checked').length;
		ustawSzerokoscTeamu();
	}
	
	function ustawSliderPomocnik()
	{
		var max = $('#cal-tabela').outerWidth() - $('.inner').width()
		$('.inner').scrollLeft(0);
		$("#slider").slider({
			value: 0,
			max: max ,
			min: 0,
			slide: function(event, ui) {
				$('.inner').scrollLeft(ui.value);
				$('.cloneNaglowek').css({ left:  220 - ui.value});
			}
		});
	}
			
	function scrollTablePomocnik(przycisk)
	{
		var wartosc;
		
		if(przycisk == 'cal-up' )
		{
			wartosc = $( "#slider" ).slider( "value" ) + (szerokoscTeamu + (limitDo * 2));
			$( "#slider" ).slider( "value", wartosc );
		}
		else
		{
			wartosc = $( "#slider" ).slider( "value" ) - (szerokoscTeamu + (limitDo * 2));
			$( "#slider" ).slider( "value", wartosc );
		}
		$('.inner').scrollLeft(wartosc);
	}
	
	function iloscWyswietlanychTemow(obiekt)
	{
		limitDo = $('#limitDo').val();
		
		ustawSzerokoscTeamu();
		ustawSliderPomocnik();
	}
	function ustawSzerokoscTeamu()
	{
		// 220 bo padding dla tabeli tak ustawiony // 21,5 bo padding dla naglowka teamu + obramowanie
		szerokoscTeamu = ((szerokoscOkna - 220) / limitDo) - 21,5;
		$('.cal-team').css('min-width', szerokoscTeamu);
	}
	
	/*
	 * ustawia slider dla temow
	 */
	function ustawSlider(limitMax)
	{
		var tmp = 0;
		$("#slider").slider({ 
			max: ($('.cal-team').length - limitMax),
			min: 0,
			slide: function(event, ui) {
				if(tmp == 0){ tmp = ui.value; }
				if(tmp > ui.value)
					scrollTable('cal-down');
				else
					scrollTable('cal-up');

				tmp = ui.value;
			}
		});
	}
	
	/*
	 * suwak prawo lewo po teamach
	 */
	function scrollTable(kierunek , przycisk)
	{
		
		if( kierunek != null )
			if(kierunek == 'cal-up' ){
				if(przycisk){ $( "#slider" ).slider( "value", $( "#slider" ).slider( "value" )+1 ); }
				limitDo++; limitOd++;
			}else{
				if(przycisk){ $( "#slider" ).slider( "value", $( "#slider" ).slider( "value" )-1 ); }
				limitDo--;	limitOd--;	
			}
		
		var iloscElementow = $('.cal-team').length;
		
		limitOd = (limitOd <= 0) ? 0 : ( ((limitOd + limitMax) > iloscElementow ) ? (iloscElementow - limitMax) : limitOd ) ;
		limitDo = (limitDo >= iloscElementow) ? iloscElementow : (( limitDo <= limitMax ) ? limitMax : limitDo);
		
		var count = 0;
		
		$('.cal-team').each( function( index, element ){
			count++;
			
			if(count <= limitDo  && count > limitOd)
			{
				$('.cal-team').filter('[data-count="'+count+'"]').show();
				$('.cal-team-data').filter('[data-count="'+count+'"]').show();
			}
			else
			{
				$('.cal-team').filter('[data-count="'+count+'"]').hide();
				$('.cal-team-data').filter('[data-count="'+count+'"]').hide();
			}
		});
	}
	
////////////////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////// FILTRY DLA DATY ////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////
	function ustawSliderData()
	{

		$( "#dataStart" ).datepicker(
										{
											min: dataStart.toISOString().substring(0, 10),
											max: dataStop.toISOString().substring(0, 10),
										}
									).on('changeDate', function(ev){
											var mStart = new Date($('#dataStart').val());
											var mStop = new Date($('#dataStop').val());
											generujKalendarz(mStart, mStop);
									});
		$('#dataStop').datepicker({
											min: dataStart.toISOString().substring(0, 10),
											max: dataStop.toISOString().substring(0, 10),
										}).on('changeDate', function(ev){
												var mStart = new Date($('#dataStart').val());
												var mStop = new Date($('#dataStop').val());
												generujKalendarz(mStart, mStop);
										});
		
		$('#dataStart').val(suwakStart.toISOString().substring(0, 10)); 
		$('#dataStop').val(suwakStop.toISOString().substring(0, 10)); 	  
		
		$( "#dateSlider" ).slider({
			range: true,
			min: 0,
			max: ilosc_dni,
			step: 1,
			values: [ ilosc_dni_start, ilosc_dni_stop ],
			stop: function( event, ui ) {
				$('.mobile-loader').fadeIn("normal");
				var mStart = new Date($('#dataStart').val());
				var mStop = new Date($('#dataStop').val());
				generujKalendarz(mStart, mStop, 0);
				$('.mobile-loader').fadeOut("normal");
			},
			slide: function( event, ui ) {
				
				var start = new Date(dataStart.getTime());
				start.setDate(start.getDate()+ui.values[ 0 ]);
				
				$('#dataStart').val(new Date(start).toISOString().substring(0, 10));
				
				if(ui.values[ 1 ] != ilosc_dni)
				{
					var stop = new Date(dataStop.getTime());
					stop.setDate(stop.getDate() + (ui.values[ 1 ] - ilosc_dni) );
					$('#dataStop').val(new Date(stop).toISOString().substring(0, 10)); 	
				}
			}
		 });
	}
	
	
	function generujKalendarz(dataStart, dataStop, pierwszyRaz, odswiez)
	{
		$('#czyscFiltr').click();
		var nowaData = new Date(dataStart).setDate(dataStart.getDate()+1);
		
		var tabela = $('#cal-tabela > tbody');
		tabela.text('');
		
		ilosc_dni_kalendarz = liczDni(dataStart, dataStop);
		
		var wierszTmp = $('#tmp-wiersz tr.cal-row');
		if(odswiez){ wierszTmp.find('.cal-team-data ').remove(); }
		if(pierwszyRaz)
		{
			var i = 1;
			$.each($kolejnoscTeamy, function(index, idTeam){
				var kratka = $('#tmp-kratka td.cal-team-data').clone();
				kratka.attr('data-count', i).attr('data-team', idTeam);
				wierszTmp.append(kratka);
				i++;
			});
		}
		
		for(var i = 0 ; i <= ilosc_dni_kalendarz ; i++)
		{
			var wiersz = wierszTmp.clone();
			var nowaData = dataStart.addDays(i);
			var dataString = nowaData.toISOString().substring(0, 10);
			
			wiersz.children('td').prepend(dataString);
			
			if(typeof $daneDataTeam[dataString] !== 'undefined' )
			{
				
				$.each($daneDataTeam[dataString], function( idTeam, daneTab ) 
				{
					$.each(daneTab, function(index, dane){
						
						var znalezionyWiersz = wiersz.children('td[data-team="'+idTeam+'"]');
				
						var event = addEventElement(idTeam, dataString, dane.kolor, dane.kolorCzcionki, dane.id, dane.nazwa, dane.powiadomienie, dane.komentarz);
						znalezionyWiersz.append(event);
						
					});
				});
			};
			
			wiersz.find('.cal-data-txt').text(nowaData.getWeek()+' | '+nowaData.toDateString());
			wiersz.find('.cal-data').children('button').attr('data-data' , dataString);
			wiersz.children('td.cal-team-data').attr('data-data' , dataString);
			wiersz.attr('id', 'row-count-'+i);
			tabela.append(wiersz);
		}
		
	}
	
	function addEventElement(idTeam, dataString, kolor, kolorCzcionki, id, nazwa, powiadomienie, komentarz)
	{
		var event = $('<div/>', { 'data-team': idTeam, 'data-data': dataString, 
							'style': 'background-color:'+kolor+'; color:'+kolorCzcionki, 'data-id': id , 'class': 'event wypelnione' } ).text(nazwa);
						if(powiadomienie){ event.prepend('<i class="icon icon-time" ></i> '); }
						if(komentarz){ event.prepend('<i class="icon icon-comment" ></i> '); }
						
		return event;
	}
	
	function generujTeamNaglowki(odswierz)
	{
		var naglowek = $('#cal-tabela thead').not('.cloneNaglowek').children('tr');
		var pokazuj = $('#limitDo').val();
		var t = 1;
		
		if(odswierz)
		{
			naglowek.find('.cal-team').remove();
		}
		
		$.each($kolejnoscTeamy, function(index, idTeam){
			var value = $teamy[idTeam];
			if(typeof value != 'undefined') 
			{
				var teamNaglowek = $('#tmp-team th.cal-team').clone();
				teamNaglowek.attr("data-count", t).attr("data-team", value.idTeam);
				teamNaglowek.find('.edycjaTeamu').attr('id', 'edytuj-'+value.idTeam);
				teamNaglowek.find('.filtrTeam').attr('id', 'filtr-'+value.idTeam);
				teamNaglowek.find('.cal-team-bil').text(value.teamNumber);
				teamNaglowek.find('.cal-team-rejestracja').text(value.rejestracja);
				teamNaglowek.find('.cal-team-telefon').text(value.telefon);
				teamNaglowek.find('.cal-team-email').text(value.email);
				teamNaglowek.find('.cal-team-caly').attr('id', 'caly-team-podglad-'+value.idTeam);
				teamNaglowek.find('.cal-team-zdjecia-wiecej').attr('id', 'caly-team-'+value.idTeam)
				teamNaglowek.find('.cal-team-zdjecia').html(generujListaPracownikow(value.pracownicy, value.iloscPracownikow, teamNaglowek, value.idTeam));
				t++;
				naglowek.append(teamNaglowek);
				teamNaglowek.show();
			}
				
		});
		
	}
	
	function generujListaPracownikow(listaPracownikow, iloscPracownikow, teamNaglowek, idTeam)
	{
		var limitWyswietlania = 2;
		var iloscPracownikowWyswietlaj = (iloscPracownikow > limitWyswietlania) ? limitWyswietlania : iloscPracownikow;
		
		if(iloscPracownikow > 0)
		{
			var zbierajPelnaLista = (iloscPracownikow > iloscPracownikowWyswietlaj) ? true : false;
			var pelnaListaPracownikow = [];
			
			for( var i = 0 ; i < iloscPracownikow ; i++ )
			{
				
				var szablonPracownik = teamNaglowek.find('.cal-tem-zdjecie-szablon').children().clone();
				var pracownikNazwa = listaPracownikow[i].imie+' '+listaPracownikow[i].nazwisko;
				szablonPracownik.attr('rel', 'comm-'+ listaPracownikow[i].id).attr('src', listaPracownikow[i].zdjecie).attr('alt', pracownikNazwa).attr('data-oryginal-title', pracownikNazwa);
				
				if(listaPracownikow[i].lider)
					szablonPracownik.addClass('lider');
				
				if(i < iloscPracownikowWyswietlaj )
					teamNaglowek.find('.cal-team-zdjecia').prepend(szablonPracownik);
				
				if(zbierajPelnaLista)
				{
					var szablonPracownikSzczegoly = szablonPracownik.clone();
					teamNaglowek.find('.cal-team-caly').prepend(szablonPracownikSzczegoly);
				}
			};
		}
		else
			teamNaglowek.find('.cal-team-zdjecia').prepend('<div class="emptyTeam">Empty Team</div>');

		if(limitWyswietlania < iloscPracownikow)
			teamNaglowek.find('.cal-team-zdjecia-wiecej').show();
		
	}
	
</script>
<!-- team po rozszerzeniu -->
<div id='userListHead' style='display: none;'>
	<table class='uzytkownicyTeamuLista' >
			<tr>
				<th style="background:none;">
					<img class="tip top" src="/_public/zdjecia/xs-b5291134.png" style="border: 1px solid rgb(255, 0, 0); cursor: pointer;" alt="Janusz Pis" data-original-title="Janusz Pis" rel="comm-19">
				</th>
			</tr>
	</table>
</div>
<div id='userDataList' style='display: none;'>
	<table class='uzytkownicyTeamuListaDat' rules="cols" >
		<tr>
			<td class='cal-data-user zezwolZaznacz' style='background: none;' >
			</td>
		</tr>
	</table>
</div>
<!-- podglad i edycja komentarza -->
<div id="komentarzBox">
	<a class="close-komentarz fL margin" href="javascript:void(0)">
		<i class="icon icon-remove"></i>
	</a><div class="clear"></div>
	<div id="komentarzTresc"  data-type="textarea" class="margin editableT" ></div>
</div>
<!-- -->
<div id="menuCopy" class="cal-team-caly" style='display: none;'>
	<!--
	<a href='javascript:void(0)' class='close-menu-copy fL'><i class="icon icon-remove"></i></a><br/>
	-->
	<ul>
		<li ><a href="javascript:void(0)" onclick="kopiujEvent()" id="kopiujEventy" ><i class="icon icon-cut" ></i> <span>{{$menu_move_event}}</span></a></li>
		<li ><a href="javascript:void(0)" onclick="klonujEvent()" id="powielEventy" ><i class="icon icon-paste" ></i> <span>{{$menu_clone_event}}</span></a></li>
	</ul>
</div>
<!-- menu podreczne -->
<div id="menuPodreczne" class="cal-team-caly" style='display: none;'>
	<a href='javascript:void(0)' class='close-menu fL'><i class="icon icon-remove"></i></a><br/>
	<ul>
		<input type="hidden" id='menuIdTeam' value='' />
		<input type="hidden" id='menuData' value='' />
		<input type="hidden" id='menuId' value='' />
		<li data-grupa="selected" class="hide"><a href="javascript:void(0)" id="czyscZaznaczenie" ><i class="icon icon-eraser" ></i> <span>{{$menu_clear_select}}</span></a></li>
		<li data-grupa="selectedEvent" class="hide"><a href="javascript:void(0)" id="zaznaczPodobneEvent" ><i class="icon icon-bullhorn" ></i> <span>{{$menu_select_similar_event}}</span></a></li>
		<li data-grupa="selectedEvent" class="hide" ><a href="javascript:void(0)" id="usunPrzypisanie" ><i class="icon icon-remove"></i> <span>{{$menu_remove_selected_event}}</span></a></li>
		<li><hr/></li>
		<li><a href="javascript:void(0)" id="pokazSzczegolyDnia" ><i class="icon icon-time"></i> <span>{{$menu_show_day_details}}</span></a> </li>
		<li><hr/></li>
		<li data-grupa="event" ><a href="javascript:void(0)" class="dodajEvent" id='domyslny' ><i class="icon icon-crop" ></i> <span>{{$menu_add_event}}</span></a></li>
		{{BEGIN listaMenu}}
		<li data-grupa="event" class="{{$typWyswietlania}}" ><a href="javascript:void(0)"  class="dodajEvent" id='{{$szablonPhp}}' ><i class="icon icon-crop" ></i> <span>{{$szablonNazwa}}</span></a></li>
		{{END}}
		<li data-grupa="zamowienie" class="hide" ><hr/></li>
		<li data-grupa="zamowienie" class="hide" ><a href="javascript:void(0)" id="podgladZamowienia" ><i class="icon icon-search"></i> <span>{{$menu_show_order_details}}</span></a></li>
		<li data-grupa="notatka" class="hide" ><hr/></li>
		<li data-grupa="notatka" class="hide" ><a href="javascript:void(0)" id="podgladNotatki" ><i class="icon icon-search"></i> <span>{{$menu_show_note}}</span></a></li>
		<li data-grupa="komentarz" class="hide " ><hr/></li>
		<li data-grupa="komentarz" class="hide" ><a href="javascript:void(0)" id="podgladKomentarz" ><i class="icon icon-search"></i> <span>{{$menu_show_comment}}</span></a></li>
		<li data-grupa="komentarz" class="hide" ><a href="javascript:void(0)" id="usunKomentarz" ><i class="icon icon-remove"></i> <span>{{$menu_remove_comment}}</span></a></li>
		<li data-grupa="komentarz" class="hide" ><a href="javascript:void(0)" id="edytujKomentarz" ><i class="icon icon-pencil"></i> <span>{{$menu_edit_comment}}</span></a></li>
		<li data-grupa="komentarz" class="hide wypelniony" ><hr/></li>
		<li data-grupa="komentarz" class="hide wypelniony" ><a href="javascript:void(0)" id="dodajKomentarz" ><i class="icon icon-pencil"></i> <span>{{$menu_add_comment}}</span></a></li>
	</ul>
</div>
<div id="tabelaGodziny">
	<table class="godziny table table-bordered table-striped table-hover" style="display: none;" >
		<tr><td class='cal-godzina-team zezwolZaznacz' data-godzina="6" ><span class="godzina">6:00</span></td> </tr>
		<tr><td class='cal-godzina-team zezwolZaznacz' data-godzina="7" ><span class="godzina">7:00</span></td> </tr>
		<tr><td class='cal-godzina-team zezwolZaznacz' data-godzina="8" ><span class="godzina">8:00</span></td> </tr>
		<tr><td class='cal-godzina-team zezwolZaznacz' data-godzina="9" ><span class="godzina">9:00</span></td> </tr>
		<tr><td class='cal-godzina-team zezwolZaznacz' data-godzina="10" ><span class="godzina">10:00</span></td> </tr>
		<tr><td class='cal-godzina-team zezwolZaznacz' data-godzina="11" ><span class="godzina">11:00</span></td> </tr>
		<tr><td class='cal-godzina-team zezwolZaznacz' data-godzina="12" ><span class="godzina">12:00</span></td> </tr>
		<tr><td class='cal-godzina-team zezwolZaznacz' data-godzina="13" ><span class="godzina">13:00</span></td> </tr>
		<tr><td class='cal-godzina-team zezwolZaznacz' data-godzina="14" ><span class="godzina">14:00</span></td> </tr>
		<tr><td class='cal-godzina-team zezwolZaznacz' data-godzina="15" ><span class="godzina">15:00</span></td> </tr>
		<tr><td class='cal-godzina-team zezwolZaznacz' data-godzina="16" ><span class="godzina">16:00</span></td> </tr>
		<tr><td class='cal-godzina-team zezwolZaznacz' data-godzina="17" ><span class="godzina">17:00</span></td> </tr>
		<tr><td class='cal-godzina-team zezwolZaznacz' data-godzina="18" ><span class="godzina">18:00</span></td> </tr>
		<tr><td class='cal-godzina-team zezwolZaznacz' data-godzina="19" ><span class="godzina">19:00</span></td> </tr>
		<tr><td class='cal-godzina-team zezwolZaznacz' data-godzina="20" ><span class="godzina">20:00</span></td> </tr>
		<tr><td class='cal-godzina-team zezwolZaznacz' data-godzina="21" ><span class="godzina">21:00</span></td> </tr>
		<tr><td class='cal-godzina-team zezwolZaznacz' data-godzina="22" ><span class="godzina">22:00</span></td> </tr>
		<tr><td class='cal-godzina-team zezwolZaznacz' data-godzina="23" ><span class="godzina">23:00</span></td> </tr>
		<tr><td class='cal-godzina-team zezwolZaznacz' data-godzina="24" ><span class="godzina">24:00</span></td> </tr>
		<tr><td class='cal-godzina-team zezwolZaznacz' data-godzina="1" ><span class="godzina">1:00</span></td> </tr>
		<tr><td class='cal-godzina-team zezwolZaznacz' data-godzina="2" ><span class="godzina">2:00</span></td> </tr>
		<tr><td class='cal-godzina-team zezwolZaznacz' data-godzina="3" ><span class="godzina">3:00</span></td> </tr>
		<tr><td class='cal-godzina-team zezwolZaznacz' data-godzina="4" ><span class="godzina">4:00</span></td> </tr>
		<tr><td class='cal-godzina-team zezwolZaznacz' data-godzina="5" ><span class="godzina">5:00</span></td> </tr>
	</table>
</div>
<div id="tabelaGodzinyTeam">
	<table class="godziny table table-bordered table-striped table-hover" style="display: none;" >
	</table>
</div>

<!-- generuje tabele -->
<table id="tmp-wiersz" style="display: none;">
	<tr class="cal-row" >
		<th class="cal-data">
			<button class="resize-data In cursorPointer" data-data=''>
				<i class="icon icon-sort tip-top" title="resize" ></i>
			</button>
			<span class="cal-data-txt"></span>
		</th>
	</tr>
</table>
<table id="tmp-kratka" style="display: none;">
	<td class="cal-team-data zezwolZaznacz">
	</td>
</table>
<table id="tmp-team" style="display: none;">
	<th class="cal-team" data-count="1" data-team="1">
		<div class="cal-team-kontener">
			<div class="cal-team-menu remove" >
				<input type="checkbox" name="filtrTeam[]" class="filtrTeam no-js" id="team-" />
				<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" title="resize" >
					<i class="icon icon-code"></i>
				</span>
				<a href="{{$urlEdytujTeam}}" title="edit" id="" class="fR margin edycjaTeamu tip-top" >edit</a>
			</div>
			<div class="cal-team-zdjecia remove">
				<div class="cal-tem-zdjecie-szablon" style="display:none;">
					<img class="tip top pracownik margin" rel="comm-19" data-original-title="" alt="" style="cursor: pointer;" src="" >
				</div>
				<div class="cal-team-zdjecia-wiecej" id="caly-team-3" style="display:none;" >
					<i class="icon icon-ellipsis-horizontal" ></i>
				</div>
			</div>
			<div class="" style="margin: 0 auto; width: 80%; text-align: center" >
				<div class="info" > 
					<i class="icon icon-truck" ></i> <span class="cal-team-bil" ></span>
				</div>
				<div class="remove info" >
					<i class="icon icon-phone"></i> <span class="cal-team-telefon"></span>
				</div>
				<div class="cal-team-email remove info" >
					<i class="icon icon-envelope" ></i> <span class="cal-team-email"></span>
				</div>
				<div class="cal-team-caly" id="caly-team-podglad" >
				
				</div>
			</div>
		</div>
	</th>
</table>
	<div class="col-xs-12">
			<div class="widget-content nopadding">
				<div class="tabbable inline" style="margin-top:10px;" >
					<ul id="myTab" class="nav nav-tabs tab-bricky">
						{{BEGIN zakladka}}
						<li class="{{$class}}">
							<a data-grupa="{{$idGrupy}}" class="border" style="border:1px solid #ccc;" href="#">{{$nazwaGrupy}} </a>
						</li>
						{{END zakladka}}
						<li style="float: right;">
							<a  class="border" id="runButton" style="" href="#" >{{$run_current_events_etykieta}}</a>
						</li>
					</ul>
					<div class="tab-content nopadding">
						<div id="panel_tab2_example1" class="tab-pane active">
							<div id="kalendarz">
								<table id="cal-menu"  class="table table-bordered table-striped table-hover">
									<tr>
										<td style="text-align: right;">
												{{$date_range_etykieta}} <input type="text" name="dataStart" style="width: 80px; font-weight:bold;" value="" id="dataStart" title="dd-mm-yyyy" data-date-format="yyyy-mm-dd" />
										</td>
										<td style="">
											<div id='dateSlider' ></div>
										</td>
										<td  style="width:10%;">
											<input type="text" name="dataStop" style="width: 80px; margin-left: 5px; font-weight:bold;" value="" id="dataStop" title="dd-mm-yyyy" data-date-format="yyyy-mm-dd" />
										</td>
										<td style="border-left: 1px solid #858585; border-right: 1px solid #858585; width: 32%;">
											{{$search_etykieta}} <input type="text" name="fraza" id="fraza" class="fraza" autocomplete="off" /><button id="zamknijWynik" style="display:none;" class="btn btn-default"><i class="icon icon-external-link"></i></button>
											<div id="wyniki">
												<ul>
													<li></li>
												</ul>
											</div>
											{{$typ_eventu_etykieta}}
											<select name="eventFiltr" class="eventFiltr">
												<option value="all"> all </option>
												{{BEGIN typSzablonu}}
												<option value="{{$szablonPhp}}"> {{$szablonNazwa}} </option>
												{{END}}
											</select>
											
										</td>
										<td colspan="2" style="width:14%;" >
											{{$bg_etykieta}} <input type="text" id="kolorTla" />
											{{$txt_etykieta}} <input type="text" id="kolorCzcionki" /> | 
											<button class="btn btn-default" id="czyscZaznaczenie2"><i class="icon icon-eraser"></i></button>
										</td>
										<td style="width:40px; border-left: 1px solid #858585; "><button  id="cal-down" class="btn btn-info cal-przesun" > < </button>
										<td>
											<div id="slider"></div>
										</td>
										<td style="width:40px;"><button  id="cal-up" class="btn btn-info cal-przesun" > > </button></td>
										<td style="width: 60px;">
											<button id="konfiguracja" class="btn btn-warning"><i class="icon icon-cogs"></i></button>
										</td>
									</tr>
								</table>
								<div class="outer">
									<div class="inner">
										<div id="przykryj"></div>
										<div id="divloader"></div>
										<table id="cal-tabela" class="table table-bordered table-bordered-strong table-striped table-hover">
											<thead>
												<tr>
													<th id="cal-data">
														<table>
															<tr>
																<td>
																	{{$team_filter_etykieta}} <br/>
																	<button  id="filtruj" class="btn btn-info btn-small" > {{$filter_etykieta}} </button>
																	<button  id="czyscFiltr" class="btn btn-warning btn-small" > {{$clear_etykieta}} </button>
																</td>
															</tr>
															<tr>
																<td>
																	{{$number_of_teams_etykieta}} <br/>
																	<span class="" >
																		<input type="text" name="limitDo" disabled="disabled" max="26" id="limitDo" value="10" />
																	</span>
																</td>
															</tr>
															<tr>
																<td style="text-align: center; background: transparent;">
																	{{$date_etykieta}}
																</td>
															</tr>
														</table>
													</th>
												</tr>
											</thead>
											<tbody>
											</tbody>
											 
										</table>
										<div id="wczytaj-wiecej-dat"><div id="wczytaj-wiecej">{{$get_more_etykieta}}</div></div>
										<div id="do-gory"></div>
									</div>
								</div>
							</div>
						</div>
						
					</div>
					
				</div>
				
			</div>
	</div>
	
	 
{{END}}

{{BEGIN edycjaTeamu}}
<script type="text/javascript">
	
	$(document).ready(function(){ initPage(); });
	
	function initPage()
	{
		$('.daty').datepicker();
		
		$(document).on('click', '.usun', function(){	potwierdzenieModal1( "{{$potwierdzUsunPracownika}}", 'Confirm', 'usunPracownika('+$(this).parents('li').attr('id').replace('i-', '')+', 0)' );  });
		$(document).on('click', '.ustawLidera',function(){	ustawLidera($(this));  });
		$(document).on('click', '.urlopButton',function(){	dodajUrlop($(this));  });
		
		$('#dodajUzytkownika').on('click', function(){ dodajUzytkownika(); });
		
		
		$('#userSelect').select2({
			placeholder: "Enter min. 3 characters",
			minimumInputLength: 3,
			ajax: {
				url: "{{$urlSearchUser}}",
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
					
					return {results: data.uzytkownicy, more: more};
				}
			},
			formatResult: ordersFormatResult, // omitted for brevity, see the source of this page
			formatSelection: ordersFormatSelection, // omitted for brevity, see the source of this page
			dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
			escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
		});
	}
	
	function usunPracownika(idPracownika, potwierdzenie){
		$('#usunPotwierdzenie').modal('hide');
		
		ajax("{{$urlUsunUser}}" , potwierdzUsunPracownik, { idPracownika: idPracownika, idTeamu: $('#idTeamu').val(), potwierdzUsun: potwierdzenie }, 'POST', 'json' );
	}
	function potwierdzUsunPracownik(dane)
	{
		if(dane.confirm){ potwierdzenieModal1( dane.txt, 'Confirm', 'usunPracownika('+dane.idPracownika+', 1)' ); return false; }
		if(dane.blad){ alertModal('Error!', dane.txt); return false; }
		
		$('#i-'+dane.idPracownika).remove();
	}
	function ustawLidera(obiekt)
	{
		var idPracownika = obiekt.parents('li').attr('id').replace('i-', '');
		ajax("{{$urlUstawLidera}}" , potwierdzUstawLidera, { idPracownika: idPracownika, idTeamu: $('#idTeamu').val()}, 'POST', 'json' );
	}
	function potwierdzUstawLidera(dane)
	{
		if(dane.blad){ alertModal('Error!', dane.txt); return false; }
		
		
		$('.site-stats').children('li').removeClass('lider');
		$('.site-stats').children('li').find('.icon-lider').hide();
		$('.ustawLidera').show();

		var obiekt = $('#i-'+dane.idPracownika).find('.ustawLidera');
		obiekt.hide();
		var kontener  = obiekt.parents('li');
		kontener.addClass('lider');
		kontener.find('.icon-star').show();
	}
	
	function dodajUrlop(obiekt)
	{
		var kontenerPokaz = obiekt.parent('.cc').next('.urlop');
			if(kontenerPokaz.is(':visible'))
				kontenerPokaz.hide(300);
			else
				kontenerPokaz.show(300);
	}
	function dodajUzytkownika()
	{
		var idPracownika = $('#userSelect').select2('data').id;
		ajax("{{$urlDodajUzytkownika}}" , potwierdzDodajUzytkownika, { idPracownika: idPracownika, idTeamu: $('#idTeamu').val()}, 'POST', 'json' );
	}
	
	function potwierdzDodajUzytkownika(dane)
	{
		if(dane.confirm){ potwierdzenieModal1( dane.txt, 'Confirm', 'usunPracownika('+dane.idPracownika+', 1)' ); return false; }
		if(dane.blad){ alertModal('Error!', dane.txt); return false; }
		
		var imie = $('#imie').val();
		var zdjecie = $('#zdjecie').val();

		var kopiuj = $('.site-stats').children('li.copy').clone();

		kopiuj.find('.zdjecie').attr('src', zdjecie);
		kopiuj.find('.zdjecie').attr('alt', imie);
		kopiuj.find('.imie').text(imie);
		kopiuj.show();
		$('.site-stats').prepend(kopiuj);
		kopiuj.show(500);
		
	}
	
	function ordersFormatResult(uzytkownik) {
		
			var markup = "<table style='width:100%;' ><tr>";
			if(uzytkownik.zdjecie != ' ' && uzytkownik.zdjecie != null)
			{
				markup += "<td style='width:80px;'><img style=\"width:50px;\" src='"+uzytkownik.zdjecie+"' /></td>"
			}
			markup += "<td style='text-align:left;'><div >" + uzytkownik.imie +" "+uzytkownik.nazwisko+" </div></td>";
			markup += "</tr></table>";
			return markup;
		}
	function ordersFormatSelection(uzytkownik) {
				$('#imie').val(uzytkownik.imie+' '+' '+uzytkownik.nazwisko+' ');
				$('#zdjecie').val(uzytkownik.zdjecie);
				return uzytkownik.imie+' '+' '+uzytkownik.nazwisko+' ';
			}
	 
</script>
<div class="row" style="width: 900px; margin: 0 auto;">
	<div class="col-xs-12">
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="icon icon-group"></i>
				</span>
				<h5>{{$edycja_teamu_etykieta}}</h5>
			</div>
			<div class="widget-content">
				<div class="row">
					<div class="col-xs-12 col-sm-4">
						<input type="hidden" name="idTeamu" id="idTeamu" value="{{$idTeamu}}" />
						<ul class="site-stats">
							<li class="copy" style="display:none;" >
								<div class="cc">
									<img class="tip top zdjecie" src="{{$zdjecie}}" style="width: 50px;" alt="{{$imie}} {{$nazwisko}}" data-original-title="{{$imie}} {{$nazwisko}}" >
									<strong  > <span class="imie">{{$imie}} {{$nazwisko}}</span> <i class="icon icon-star icon-lider" style="display:none;" ></i></strong>
									<button class="btn btn-danger fR tip-right margin usun" title="delete" >
										<i class="icon icon-remove"></i>
									</button>
									<button class="btn btn-primary fR tip-right margin urlopButton" title="{{$set_day_off_etykieta}}" >
										<i class="icon icon-picture"></i>
									</button>
									<button class="btn btn-primary fR tip-right margin ustawLidera" title="{{$set_as_leader_etykieta}}" {{IF $lider}}style="display:none;"{{END}}  >
										<i class="icon icon-star"></i>
									</button>
								</div>
								<div class="urlop" style="width: 100%; min-height: 100px; display: none;">
									<form class="form-horizontal" action="" method="post" name="zamowienie" enctype="multipart/form-data">
										<div class="control-group input_ok">
											<label class="control-label input_ok " for="dateStart">{{$date_from_etykieta}}</label>
											<div class="controls">
												<div class="input-append">
													<input class="daty" name="data-od" id="data-od" type="text" data-date-format="yyyy-mm-dd" title="dd-mm-yyyy" value="" >
													<span class="add-on">
														<i class="icon-calendar"></i>
													</span>
												</div>
											</div>
										</div>
										<div class="control-group input_ok">
											<label class="control-label input_ok " for="dateStart">{{$date_to_etykieta}}</label>
											<div class="controls">
												<div class="input-append">
													<input class="daty" name="data-do" id="data-do" type="text" data-date-format="yyyy-mm-dd" title="dd-mm-yyyy" value="" >
													<span class="add-on">
														<i class="icon-calendar"></i>
													</span>
												</div>
											</div>
										</div>
									</form>
								</div>
							</li>
							{{BEGIN pracownik}}
							<li {{IF $lider}}class="lider"{{END}} id="i-{{$id}}" >
								<div class="cc">
									<img class="tip top" src="{{$zdjecie}}" style="width: 50px;" alt="{{$imie}} {{$nazwisko}}" data-original-title="{{$imie}} {{$nazwisko}}" >
									<strong>{{$imie}} {{$nazwisko}} <i class="icon icon-star icon-lider" style="display:none;" ></i></strong>
									<button class="btn btn-danger fR tip-right margin usun" title="delete" >
										<i class="icon icon-remove"></i>
									</button>
									<button class="btn btn-primary fR tip-right margin urlopButton" title="set day off" >
										<i class="icon icon-picture"></i>
									</button>
									<button class="btn btn-primary fR tip-right margin ustawLidera" title="set as leader" {{IF $lider}}style="display:none;"{{END}}  >
										<i class="icon icon-star"></i>
									</button>
								</div>
								<div class="urlop" style="width: 100%; min-height: 100px; display: none;">
									<form class="form-horizontal" action="" method="post" name="zamowienie" enctype="multipart/form-data">
										<div class="control-group input_ok">
											<label class="control-label input_ok " for="dateStart">{{$date_from_etykieta}}</label>
											<div class="controls">
												<div class="input-append">
													<input class="daty" name="data-od" id="data-od" type="text" data-date-format="yyyy-mm-dd" title="dd-mm-yyyy" value="" >
													<span class="add-on">
														<i class="icon-calendar"></i>
													</span>
												</div>
											</div>
										</div>
										<div class="control-group input_ok">
											<label class="control-label input_ok " for="dateStart">{{$date_to_etykieta}}</label>
											<div class="controls">
												<div class="input-append">
													<input class="daty" name="data-do" id="data-do" type="text" data-date-format="yyyy-mm-dd" title="dd-mm-yyyy" value="" >
													<span class="add-on">
														<i class="icon-calendar"></i>
													</span>
												</div>
											</div>
										</div>
									</form>
								</div>
							</li>
							{{END}}
							<li>
								<div class="cc">
									<input type="hidden" name="zdjecie" id="zdjecie" value="" />
									<input type="hidden" name="imie" id="imie" value="" />
									<input class="js-data-example-ajax" style="width: 90%;" name="userSelect" id="userSelect" />
									<button class="btn btn-primary fR " id="dodajUzytkownika" >
										<i class="icon icon-plus"></i>
									</button>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{{END}}
{{BEGIN wydarzenie}}
<script>
		$(document).ready(function(){ initPage();	});
		
			function initPage(){
				$('.wstecz').on('click', function(){ zamknijModla(); })
				$('input[type=checkbox]').not('.no-uniform').uniform();
			}
			
		if(jest == 0)
		{
			$(document).on('click', '.zapisz', function(){
				
				zapiszWydarzenie($(this)); 
				return false; });
			
			function validacja(idForm)
			{
				var inputy = $('form#'+idForm).find('input');
				var bledy = 0;
				inputy.each(function(i, input){
					var funkcjaValidujaca = $(this).attr('data-valid');
					if(funkcjaValidujaca != '' && funkcjaValidujaca !='undefined' && typeof funkcjaValidujaca != 'undefined')
					{
						if(!window[funkcjaValidujaca]()) bledy++;
					}
				});
				return (bledy) ? false : true;
			}
			
			function zapiszWydarzenie(submit)
			{
				var idForm = submit.parents('form').attr('id');
				
				if(!validacja(idForm))
				{
					return false;
				}
				
				var dataTeam = pobierzZaznaczone();
				
				ustawZmianyIstnieja();

				var daneForm = $('form#'+idForm).serializeObject();
				var dane = { daneForm: daneForm, dataTeam: dataTeam.dataTeam, eTyp: dataTeam.eTyp }
				
				ajax("{{$urlZapiszWydarzenie}}" , potwierdzZapiszWydarzenie, dane, 'POST', 'json' );

				return false;
			}
			
			function wykonajWydarzenia(ids)
			{
				var dane = {
					ids: ids.split('|'),
				};
				ajax("{{$urlWykonajWydarzenie}}", potwierdzWykonajWydarzenia, dane, 'POST', 'json');
			}
			
			function potwierdzWykonajWydarzenia(dane)
			{
				if(dane.blad > 0) alertModal('Error', dane.bladTxt);
				$.each(dane.ids, function(i, id){
					$('.event:not(.projekt)[data-id='+id+']').attr('data-wykonany', 1);
				});
				$('#usunPotwierdzenie').find('.close').click();
			}
			
			function potwierdzZapiszWydarzenie(dane)
			{
				if(dane.blad > 0)	{ alertModal('Error!', dane.blad_txt);	}
				if(dane.komunikatUruchomEvent) 
				{
					var txt = dane.komunikatUruchomEventTxt+'<br/>';
					var ids = [];
					$.each(dane.eventyDoUruchomienia, function(i, event){
						ids.push(event.id);
						txt = txt+' '+event.name+'<br/> ';
					});
					var joinIds = ids.join('|');
					potwierdzenieModal1(txt, 'Confirm', 'wykonajWydarzenia(\''+joinIds+'\')' ); 
				}
				
				if(dane.eventy.length)
				{
					for( var $i = 0 ; $i < dane.eventy.length; $i++)
					{
						$('#listaEventow').append(dane.eventy[$i]);
						
					}
					for( var $j = 0 ; $j < dane.eventy.length; $j++)
					{
						umiescEvent( $('#event_'+dane.eventyId[$j]) );
					}
				}

				$('.selected').removeClass('selected');
				if(dane.blad == 0){	zamknijModla(); }
				
				setSortableEvent(".event:not(.nie-przenos)");
				setResizable();
				
			}
			jest++;
		}
		
		
		function rozwinNastepnyRegion(obiekt)
		{
			var tytul = obiekt.parents('.formularz_region ').next('.formularz_region').children('.region_tytul');
			if(tytul.hasClass('closed')){ tytul.click() }; 
		}
		
		function regionToggle(elem)
		{
			$(elem).toggleClass("closed");
			if($("+ .region_tresc", elem).is(":visible"))
			{
				$("+ .region_tresc", elem).slideUp("fast");
			}
			else
			{
				$("+ .region_tresc", elem).slideDown("fast");
			}
		}
		$(".region_tytul").click(function(){
			if ($(this).hasClass('closed'))
			{
				$(this).find('i').first().attr('class', 'icon-circle-arrow-up');
			}
			else
			{
				$(this).find('i').first().attr('class', 'icon-circle-arrow-down');
			}

			regionToggle($(this));
		});
		
		
</script>
<div class="widget-box">
	<div class="widget-content">
		<div class="tabbable inline">
			{{$komunikat}}
			<ul id="myTab2" class="nav nav-tabs tab-bricky">
				{{BEGIN zakladki}}
					<li class="{{$status}}">
						<a href="#{{$tag}}" data-toggle="tab" >{{$etykieta}}</a>
					</li>
				{{END}}
			</ul>
			<div class="tab-content">
			{{BEGIN panel}}
			<div id="{{$tag}}" class="tab-pane {{$status}}" >
				<div class="widget-content">
					 {{$html}}
				</div>
			</div>
			{{END}}
			{{BEGIN panel1}}
			<div id="{{$tag}}" class="tab-pane {{$status}}" >
				<div class="widget-box">
					<div class="widget-content nopadding">
						<form id="wydarzenie_{{$tag}}" class="form-horizontal" action="" method="post" name="zamowienie" enctype="multipart/form-data">
							<input name="szablon" type="hidden" value="{{$tag}}" />
							{{$html}}
							<div class="formularz_stopka form-actions">
								<input class="zapisz btn btn-primary" type="submit" value="{{$zapisz_etykieta}}" name="zapisz">
								<input class="btn wstecz" type="button" value="{{$anuluj_etykieta}}" name="wstecz">
							</div>
						</form>
					</div>
				</div>
			</div>
			{{END}}
		</div>
		</div>
	</div>
</div>
{{END}}
{{BEGIN dodajProjekt}}

<script type="text/javascript">
		
	$(document).ready(function(){ initPage();	});
	
	function initPage()
	{
		kolorPrzycisk($('#kolor'), '#90C3D4');
		nalozSelect();
		$('#zapisz').on('click', function(){  zapisz(); });
		$('#wstecz').on('click', function(){ $('.close').click(); } );
		$('input[type=checkbox]').not('.no-uniform').uniform();
	}
	
	function walidujFormularzProjekt()
	{
		var poprawny = true;
		if($('#kolor').val() != ''){ 
			$('#kolor').parents('.control-group').removeClass('error'); 
			$('#kolor').siblings('.help-block').hide();
		}
		else
		{ 
			$('#kolor').parents('.control-group').addClass('error');
			$('#kolor').siblings('.help-block').show();
			poprawny = false;
		}
		if($('#zamowienieSelect').val() > 0)
		{ 
			$('#zamowienieSelect').parents('.control-group').removeClass('error'); 
			$('#zamowienieSelect').siblings('.help-block').hide();
		}
		else
		{ 
			$('#zamowienieSelect').parents('.control-group').addClass('error'); 
			$('#zamowienieSelect').siblings('.help-block').show();
			poprawny = false;
		}
		if($('#nazwaWyswietlana').val() != ''){ 
			$('#nazwaWyswietlana').parents('.control-group').removeClass('error'); 
		}else{ $('#nazwaWyswietlana').parents('.control-group').addClass('error');  poprawny = false;}
		
		return poprawny;
	}
	
	function zapisz()
	{
		if(!walidujFormularzProjekt()) return false;
		
		var kolor = $('#kolor').val();
		var idProjektu = $('#zamowienieSelect').val();
		var nazwaProjektu = $('#zamowienieSelect').select2('data').order_name;
		var nazwaWyswietlana = $('#nazwaWyswietlana').val();
		
		var dataTeam = {};
		var godzina = null;
		var idUser = null;
		$('.selected').each(function(){
			if($(this).hasClass('cal-godzina-team'))
			{
				var $data = $(this).parents('td').attr('data-data');
				var $team = $(this).parents('td').attr('data-team');
				godzina = $(this).attr('data-godzina');
			}
			else if($(this).hasClass('cal-data-user'))
			{
				var $data = $(this).parents('td').attr('data-data');
				var $team = $(this).parents('td').attr('data-team');
				idUser = $(this).attr('data-user');
			}
			else
			{
				var $data = $(this).attr('data-data');
				var $team = $(this).attr('data-team');
			}
			
			if (!dataTeam[$data]) dataTeam[$data] = {};
			if (!dataTeam[$data][$team]) dataTeam[$data][$team] = { istnieje: true };
			if (godzina != null)
			{
				if (!dataTeam[$data][$team]['godzina']) dataTeam[$data][$team]['godzina'] = [];
				dataTeam[$data][$team]['godzina'].push(godzina);
			}
			if (idUser != null)
			{
				if (!dataTeam[$data][$team]['user']) dataTeam[$data][$team]['user'] = idUser;
			}
			/*
			if (!$daneDataTeam[$data]) $daneDataTeam[$data] = {};
			if (!$daneDataTeam[$data][$team]) $daneDataTeam[$data][$team] = {};
			
			$daneDataTeam[$data][$team] = { idObiekt: idProjektu, typ: 'zamowienie', kolor: kolor, nazwa: nazwaWyswietlana };
			*/
			
		});
		
		var powiadomienieZalogowany = {sms:0, email: 0};
		if($('#powiadomMnieSms').is(':checked')) { powiadomienieZalogowany.sms = 1 };
		if($('#powiadomMnieEmail').is(':checked')) { powiadomienieZalogowany.email = 1 };
		
		var powiadomienieUzytkownicy = {};
		$('#userList li').not('#tmpUzytkownik').each(function(){
			
			if(!powiadomienieUzytkownicy[$(this).find('.userId').val()]){ powiadomienieUzytkownicy[$(this).find('.userId').val()] = {sms:0, email: 0}; }
			if($(this).find('input[name=powiadomUzytkownikSms]').is(':checked')){	powiadomienieUzytkownicy[$(this).find('.userId').val()].sms = 1; } 
			if($(this).find('input[name=powiadomUzytkownikEmail]').is(':checked')){ powiadomienieUzytkownicy[$(this).find('.userId').val()].email = 1; }
		});
		
		var dane = {
			 kolor: kolor, 
			 idObiekt: idProjektu, 
			 nazwaWyswietlana: nazwaWyswietlana, 
			 typ: 'projekt', 
			 dataTeam: dataTeam,
			 komentarz: $('#komentarz').val(),
			 powiadomienieZalogowany: powiadomienieZalogowany,
			 powiadomienieUzytkownicy: powiadomienieUzytkownicy,
			 powiadomienieDni: $('#powiadomienieDni option:selected').val(),
		};
		
		ajax("{{$urlZapiszWydarzenie}}" , zapiszProjekt, dane, 'POST', 'json' );
	}
	
	function zapiszProjekt(dane)
	{
		if(dane.blad > 0)	{ alertModal('Error!', dane.blad_txt);	}
		
		$.each(dane.daty, function(index, value)
		{
			$.each(value , function(vIndex, vValue){
				
				$.each(vValue, function(id, dane){
					
					if(dane.godziny != null)
					{
						$.each(dane.godziny, function(gIndex, godzina){
							var event = addEventElement( vIndex, index, dane.kolor, dane.kolorCzcionki, dane.id, dane.nazwa, dane.powiadomienie, dane.komentarz );
							
							$('.selected[data-godzina='+godzina+']').append(event);
						});
					}
					else if(dane.user > 0)
					{
						var event = addEventElement( vIndex, index, dane.kolor, dane.kolorCzcionki, dane.id, dane.nazwa, dane.powiadomienie, dane.komentarz );
						var element = $('.cal-team-data[data-data='+index+'][data-team='+vIndex+']');
						element.find('.selected[data-user='+dane.user+']').append(event);
					}
					var element = $('.cal-team-data[data-data='+index+'][data-team='+vIndex+']');
					var event = addEventElement( vIndex, index, dane.kolor, dane.kolorCzcionki, dane.id, dane.nazwa, dane.powiadomienie, dane.komentarz );
					if(dane.godziny != null || dane.user > 0){ event.hide(); }
					element.prepend(event);
					 
					
					if (!$daneDataTeam[index]) $daneDataTeam[index] = {};
					if (!$daneDataTeam[index][vIndex]) $daneDataTeam[index][vIndex] = {};
					
					$daneDataTeam[index][vIndex][dane.id] = {
						id: dane.id,
						idObiekt: dane.idObiekt, 
						typ: dane.typ, 
						kolor: dane.kolor, 
						kolorCzcionki: dane.kolorCzcionki,
						nazwa: dane.nazwa,
						komentarz: dane.komentarz,
						komentarzTxt: dane.komentarzTxt,
						powiadomienie: dane.powiadomienie,
						godziny: dane.godziny,
						user: dane.user,
					};
					
				});
				//function addEventElement( vIndex, index, vValue[0].kolor, vValue[0].kolorCzcionki, vValue[0].id, vValue[0].nazwa, vValue[0].powiadomienie, vValue[0].komentarz );
				
				// element.attr('style', 'background:'+vValue[0].kolor+'; border-color:'+vValue[0].kolor+'; color:'+vValue[0].kolorCzcionki).text(vValue[0].nazwa).attr('data-id', vValue[0].id).addClass('wypelnione').removeClass('selected');
				/*
				if(vValue[0].powiadomienie)
					element.prepend(' <i class="icon icon-time"></i> ');
				
				if(vValue[0].komentarz)
					element.prepend(' <i class="icon icon-comment"></i> ');
					
				*/
				
			});
		});
		$('.selected').removeClass('selected');
		if(dane.blad == 0){	$('.close').click(); }
		
	}
	
	$('#userSelect').select2({
			placeholder: "Enter min. 3 characters",
			minimumInputLength: 3,
			ajax: {
				url: "{{$urlSearchUser}}",
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
					
					return {results: data.uzytkownicy, more: more};
				}
			},
			formatResult: userFormatResult, // omitted for brevity, see the source of this page
			formatSelection: userFormatSelection, // omitted for brevity, see the source of this page
			dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
			escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
		});

	function userFormatResult(uzytkownik) {
		
			var markup = "<table style='width:100%;' ><tr>";
			if(uzytkownik.zdjecie != ' ' && uzytkownik.zdjecie != null)
			{
				markup += "<td style='width:80px;'><img style=\"width:50px;\" src='"+uzytkownik.zdjecie+"' /></td>"
			}
			markup += "<td style='text-align:left;'><div >" + uzytkownik.imie +" "+uzytkownik.nazwisko+" </div></td>";
			markup += "</tr></table>";
			return markup;
		}
	function userFormatSelection(uzytkownik) {
		
				var uzytkownikElement = $('#tmpUzytkownik').clone();
				
				uzytkownikElement.find('.nazwa').text(uzytkownik.imie+' '+' '+uzytkownik.nazwisko+' ');
				uzytkownikElement.find('img').attr('src', uzytkownik.zdjecie);
				uzytkownikElement.find('.userId').val(uzytkownik.id);
				uzytkownikElement.removeAttr('id');
				$('#userList').append(uzytkownikElement);
				uzytkownikElement.show();
				uzytkownikElement.find('input[type=checkbox]').uniform();
				
				return uzytkownik.imie+' '+' '+uzytkownik.nazwisko+' ';
			}
	
	function nalozSelect()
	{
		$('#zamowienieSelect').select2({
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
				$('#nazwaWyswietlana').val(orders.order_name);
				return orders.order_name;
			}
</script>
<div class="control-group input_ok">
	<label class="control-label input_ok " for="address">Select order : </label>
		<div class="controls">
			<input class="js-data-example-ajax" style="width: 90%;" name="zamowienieSelect" id="zamowienieSelect" />
			<span class="help-block" style="display:none;" >{{$bladZamowienie}}</span>
	</div>
</div>
<div class="control-group input_ok">
	<label class="control-label input_ok " for="address">Name displayed : </label>
		<div class="controls">
			<input type="text" style="width: 90%;" name="nazwaWyswietlana" id="nazwaWyswietlana" />
			<span class="help-block" style="display:none;" >{{$bladNazwaWyswietlana}}</span>
	</div>
</div>
<div class="control-group input_ok">
	<label class="control-label input_ok " for="address">Select color : </label>
		<div class="controls">
			<div class="demo2">
				<input type="text" style="width:70px;" value="" name="kolor" id="kolor" class="form-control kolor" />
				<span class="input-group-addon"><i></i></span>
			</div>
		<span class="help-block" style="display:none;" >{{$bladKolor}}</span>
	</div>
</div>
<div class="control-group input_ok">
	<label class="control-label input_ok " for="address">Comment : </label>
		<div class="controls">
				<input type="text" style="width: 90%;" value="" name="komentarz" id="komentarz" />
				<span class="input-group-addon"><i></i></span>
		<span class="help-block"></span>
	</div>
</div>
<div class="control-group input_ok">
	<label class="control-label input_ok " for="address">Send notification : </label>
		<div class="controls">
			<select name="powiadomienieDni" id="powiadomienieDni">
				{{BEGIN przypomnienieOpcjeDni}}
				<option value="{{$klucz}}" >{{$wartosc}}</option>
				{{END}}
			</select>
		</div>
</div>
<div class="control-group input_ok">
	<label class="control-label input_ok " for="address">send me : </label>
		<div class="controls">
			<input type="checkbox" name="powiadomMnieSms" id="powiadomMnieSms" /><label for="powiadomMnieSms" style="display:inline;" >SMS</label>
			<input type="checkbox" name="powiadomMnieEmail" id="powiadomMnieEmail" /><label for="powiadomMnieEmail" style="display:inline;">E-mail</label>
	</div>
</div>
<div class="control-group input_ok" >
	<label class="control-label input_ok " for="address">send to : </label>
		<div class="controls">
			<input class="js-data-example-ajax" style="width: 50%;" name="userSelect" id="userSelect" />
			<span class="input-group-addon"><i></i></span>
			<span class="help-block"></span>
	</div>
</div>
<div class="control-group input_ok" >
	<ul id="userList" class="userList">
		<li id="tmpUzytkownik" style="display:none;" >
			<label class="control-label input_ok " for="address"><img src="/_public/zdjecia/min-a38e0781.jpg" style="width:30px;"> <strong class="nazwa">Jan Zastawny </strong> 
				<input type="hidden" name="userId[]" class="userId" value="" />
				<div style="right:0; top: 0; position: absolute;">
				<input type="checkbox" class="no-uniform" name="powiadomUzytkownikSms" id="powiadomUzytkownikSms" /> <label for="powiadomUzytkownikSms" style="display:inline;" >SMS</label>
				<input type="checkbox" class="no-uniform" name="powiadomUzytkownikEmail" id="powiadomUzytkownikEmail" /> <label for="powiadomUzytkownikEmail" style="display:inline;" >E-mail</label>
				</div>
			</label>
		</li>
		{{BEGIN uzytkownikPowiadom}}
		<li>
			<label class="control-label input_ok " for="address"><img src="{{$zdjecie}}" style="width:30px;"> <strong class="nazwa">{{$imie}} </strong> 
				<input type="hidden" name="userId[]" class="userId" value="{{$uId}}" />
				<div style="right:0; top: 0; position: absolute;">
				<input type="checkbox" name="powiadomUzytkownikSms" id="powiadomUzytkownikSms" /> <label for="powiadomUzytkownikSms" style="display:inline;" >SMS</label>
				<input type="checkbox" name="powiadomUzytkownikEmail" id="powiadomUzytkownikEmail" /> <label for="powiadomUzytkownikEmail" style="display:inline;" >E-mail</label>
				</div>
			</label>
		</li>
		{{END uzytkownikPowiadom}}
	</ul>
</div>

<div class="control-group input_ok">
	<input id="zapisz" class="btn btn-primary" type="submit" value="Save" name="zapisz">
	<input id="wstecz" class="btn " type="button" value="Cancel" name="wstecz">
</div>


{{END}}
{{BEGIN dodajNotatke}}
<script type="text/javascript">
		
	$(document).ready(function(){ initPage();	});
	
	function initPage()
	{
		kolorPrzycisk($('#kolorNotatki'), '#90C3D4');
		
		$('#zapiszNotatke').on('click', function(){ zapiszNotatke(); });
		$('#wsteczNote').on('click', function(){ $('.close').click(); } );
		$('#notatkaTresc').on('focusout', function() { ustawNazweWyswietlana(); } )
	}
	
	function walidujFormularzNotatka()
	{
		var poprawny = true;
		
		if($('#kolorNotatki').val() != ''){ 
			$('#kolorNotatki').parents('.control-group').removeClass('error'); 
			$('#kolorNotatki').siblings('.help-block').hide();
		}
		else
		{ 
			$('#kolorNotatki').parents('.control-group').addClass('error');
			$('#kolorNotatki').siblings('.help-block').show();
			poprawny = false;
		}
		if($('#notatkaTresc').val().length > 0)
		{ 
			$('#notatkaTresc').parents('.control-group').removeClass('error'); 
			$('#notatkaTresc').siblings('.help-block').hide();
		}
		else
		{ 
			$('#notatkaTresc').parents('.control-group').addClass('error'); 
			$('#notatkaTresc').siblings('.help-block').show();
			poprawny = false;
		}
		if($('#nazwaWyswietlanaNote').val() != ''){ 
			$('#nazwaWyswietlanaNote').parents('.control-group').removeClass('error'); 
		}else{ $('#nazwaWyswietlanaNote').parents('.control-group').addClass('error');  poprawny = false;}
		
		return poprawny;
	}
	
	function zapiszNotatke()
	{
		
		if(!walidujFormularzNotatka()) return false;
		
		var dataTeam = {};
		$('.selected').each(function(){
			var godzina = null;
			if($(this).hasClass('cal-godzina-team'))
			{
				var $data = $(this).parents('td').attr('data-data');
				var $team = $(this).parents('td').attr('data-team');
				godzina = $(this).attr('data-godzina');
			}
			else
			{
				var $data = $(this).attr('data-data');
				var $team = $(this).attr('data-team');
			}
			
			if (!dataTeam[$data]) dataTeam[$data] = {};
			if (!dataTeam[$data][$team]) dataTeam[$data][$team] = { istnieje: true };
			if (godzina != null)
			{
				if (!dataTeam[$data][$team]['godzina']) dataTeam[$data][$team]['godzina'] = [];
				dataTeam[$data][$team]['godzina'].push(godzina);
			}
			
		});
		
		var powiadomienieZalogowany = {sms:0, email: 0};
		if($('#powiadomMnieSmsNote').is(':checked')) { powiadomienieZalogowany.sms = 1 };
		if($('#powiadomMnieEmailNote').is(':checked')) { powiadomienieZalogowany.email = 1 };
		
		var powiadomienieUzytkownicy = {};
		$('#userListNote li').not('#tmpUzytkownik').each(function(){
			
			if(!powiadomienieUzytkownicy[$(this).find('.userId').val()]){ powiadomienieUzytkownicy[$(this).find('.userId').val()] = {sms:0, email: 0}; }
			if($(this).find('input[name=powiadomUzytkownikSms]').is(':checked')){	powiadomienieUzytkownicy[$(this).find('.userId').val()].sms = 1; } 
			if($(this).find('input[name=powiadomUzytkownikEmail]').is(':checked')){ powiadomienieUzytkownicy[$(this).find('.userId').val()].email = 1; }
		});
		
		var dane = {
			 kolor:  $('#kolorNotatki').val(), 
			 tresc: $('#notatkaTresc').val(), 
			 nazwaWyswietlana: $('#nazwaWyswietlanaNote').val(), 
			 typ: 'notatka', 
			 dataTeam: dataTeam,
			 komentarz: $('#komentarzNote').val(),
			 powiadomienieZalogowany: powiadomienieZalogowany,
			 powiadomienieUzytkownicy: powiadomienieUzytkownicy,
			 powiadomienieDni: $('#powiadomienieDniNote option:selected').val(),
		};
		
		ajax("{{$urlZapiszNotatka}}" , zapiszNotatkePotwierdz, dane, 'POST', 'json' );
	}
	
	function ustawNazweWyswietlana()
	{
		var notatka = $('#notatkaTresc').val();
		var notatkaWstaw = (notatka.length > 100) ? notatka.slice(0, 100)+'...' : notatka;
		$('#nazwaWyswietlanaNote').val(notatkaWstaw);
	}
	
	$('#userSelectNote').select2({
			placeholder: "Enter min. 3 characters",
			minimumInputLength: 3,
			ajax: {
				url: "{{$urlSearchUser}}",
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
					
					return {results: data.uzytkownicy, more: more};
				}
			},
			formatResult: userNoteFormatResult, // omitted for brevity, see the source of this page
			formatSelection: userNoteFormatSelection, // omitted for brevity, see the source of this page
			dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
			escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
		});

	function userNoteFormatResult(uzytkownik) {
		
			var markup = "<table style='width:100%;' ><tr>";
			if(uzytkownik.zdjecie != ' ' && uzytkownik.zdjecie != null)
			{
				markup += "<td style='width:80px;'><img style=\"width:50px;\" src='"+uzytkownik.zdjecie+"' /></td>"
			}
			markup += "<td style='text-align:left;'><div >" + uzytkownik.imie +" "+uzytkownik.nazwisko+" </div></td>";
			markup += "</tr></table>";
			return markup;
		}
	function userNoteFormatSelection(uzytkownik) {
		
				var uzytkownikElement = $('#tmpUzytkownik').clone();
				
				uzytkownikElement.find('.nazwa').text(uzytkownik.imie+' '+' '+uzytkownik.nazwisko+' ');
				uzytkownikElement.find('img').attr('src', uzytkownik.zdjecie);
				uzytkownikElement.find('.userId').val(uzytkownik.id);
				uzytkownikElement.removeAttr('id');
				$('#userListNote').append(uzytkownikElement);
				uzytkownikElement.show();
				uzytkownikElement.find('input[type=checkbox]').uniform();
				
				return uzytkownik.imie+' '+' '+uzytkownik.nazwisko+' ';
			}
	
	function zapiszNotatkePotwierdz(dane)
	{
		if(dane.blad > 0)	alertModal('Error!', dane.blad_txt);
		
		$.each(dane.daty, function(index, value)
		{
			$.each(value , function(vIndex, vValue){
				
				$.each(vValue, function(id, dane){
					
					if(dane.godziny != null)
					{
						$.each(dane.godziny, function(gIndex, godzina){
							var event = addEventElement( vIndex, index, dane.kolor, dane.kolorCzcionki, dane.id, dane.nazwa, dane.powiadomienie, dane.komentarz );
							
							$('.selected[data-godzina='+godzina+']').append(event);
						});
					}
					 
					var element = $('.cal-team-data[data-data='+index+'][data-team='+vIndex+']');
					var event = addEventElement( vIndex, index, dane.kolor, dane.kolorCzcionki, dane.id, dane.nazwa, dane.powiadomienie, dane.komentarz );
					if(dane.godziny != null){ event.hide(); }
					element.prepend(event);
					 
					
					if (!$daneDataTeam[index]) $daneDataTeam[index] = {};
					if (!$daneDataTeam[index][vIndex]) $daneDataTeam[index][vIndex] = {};
					
					$daneDataTeam[index][vIndex][dane.id] = {
						id: dane.id,
						idObiekt: dane.idObiekt, 
						typ: dane.typ, 
						kolor: dane.kolor, 
						kolorCzcionki: dane.kolorCzcionki,
						nazwa: dane.nazwa,
						komentarz: dane.komentarz,
						komentarzTxt: dane.komentarzTxt,
						powiadomienie: dane.powiadomienie,
						godziny: dane.godziny,
					};
					
				});
				
				
				//element.attr('data-id', vValue[0].id);
				//element.attr('style', 'background:'+vValue[0].kolor+'; border-color:'+vValue[0].kolor+'; color:'+vValue[0].kolorCzcionki).text(vValue[0].nazwa).addClass('wypelnione').removeClass('selected');
				
				//if (!$daneDataTeam[index]) $daneDataTeam[index] = {};
				//if (!$daneDataTeam[index][vIndex]) $daneDataTeam[index][vIndex] = {};
				
				
				/*
				if(vValue[0].powiadomienie)
					element.prepend(' <i class="icon icon-time"></i> ');
				
				if(vValue[0].komentarz)
					element.prepend(' <i class="icon icon-comment"></i> ');
				*/
				
			});
		});
		$('.selected').removeClass('selected');
		if(dane.blad == 0)
		{
			$('.close').click();
		}
				
	}
	
</script>
<div class="control-group input_ok">
	<label class="control-label input_ok " for="address">Add Note : </label>
		<div class="controls">
			<textarea class="" style="width: 90%;" name="notatkaTresc" id="notatkaTresc" ></textarea>
			<span class="help-block" style="display:none;">{{$bladNotatka}}</span>
	</div>
</div>
<div class="control-group input_ok">
	<label class="control-label input_ok " for="address">Select color : </label>
		<div class="controls">
			<div class="demo2">
				<input type="text" style="width:70px;" value="" name="kolorNotatki" id="kolorNotatki" class="form-control kolor" />
				<span class="input-group-addon"><i></i></span>
			</div>
		<span class="help-block" style="display:none;" >{{$bladKolor}}</span>
	</div>
</div>
<div class="control-group input_ok">
	<label class="control-label input_ok " for="address">Name displayed : </label>
		<div class="controls">
			<input type="text" style="width: 90%;" name="nazwaWyswietlanaNote" id="nazwaWyswietlanaNote" />
			<span class="help-block" style="display:none;" >{{$bladNazwaWyswietlana}}</span>
	</div>
</div>
<div class="control-group input_ok">
	<label class="control-label input_ok " for="address">Comment : </label>
		<div class="controls">
				<input type="text" style="width: 90%;" value="" name="komentarzNote" id="komentarzNote" />
				<span class="input-group-addon"><i></i></span>
		<span class="help-block"></span>
	</div>
</div>
<div class="control-group input_ok">
	<label class="control-label input_ok " for="address">Send notification : </label>
		<div class="controls">
			<select name="powiadomienieDniNote" id="powiadomienieDniNote">
				{{BEGIN przypomnienieOpcjeDni}}
				<option value="{{$klucz}}" >{{$wartosc}}</option>
				{{END}}
			</select>
		</div>
</div>
<div class="control-group input_ok">
	<label class="control-label input_ok " for="address">send me : </label>
		<div class="controls">
			<input type="checkbox" name="powiadomMnieSmsNote" id="powiadomMnieSmsNote" /><label for="powiadomMnieSmsNote" style="display:inline;" >SMS</label>
			<input type="checkbox" name="powiadomMnieEmailNote" id="powiadomMnieEmailNote" /><label for="powiadomMnieEmailNote" style="display:inline;">E-mail</label>
	</div>
</div>
<div class="control-group input_ok">
	<label class="control-label input_ok " for="address">send to : </label>
		<div class="controls">
			<input class="js-data-example-ajax" style="width: 50%;" name="userSelectNote" id="userSelectNote" />
			<span class="input-group-addon"><i></i></span>
			<span class="help-block"></span>
	</div>
</div>
<div class="control-group input_ok">
	<ul id="userListNote">
		<li id="tmpUzytkownik" style="display:none;" >
			<label class="control-label input_ok " for="address"><img src="/_public/zdjecia/min-a38e0781.jpg" style="width:30px;"> <strong class="nazwa">Jan Zastawny </strong> 
				<input type="hidden" name="userId[]" class="userId" value="" />
				<div style="right:0; top: 0; position: absolute;">
				<input type="checkbox" class="no-uniform" name="powiadomUzytkownikSms" id="powiadomUzytkownikSms" /> <label for="powiadomUzytkownikSms" style="display:inline;" >SMS</label>
				<input type="checkbox" class="no-uniform" name="powiadomUzytkownikEmail" id="powiadomUzytkownikEmail" /> <label for="powiadomUzytkownikEmail" style="display:inline;" >E-mail</label>
				</div>
			</label>
		</li>
		{{BEGIN uzytkownikPowiadom}}
		<li>
			<label class="control-label input_ok " for="address"><img src="{{$zdjecie}}" style="width:30px;"> <strong class="nazwa">{{$imie}} </strong> 
				<input type="hidden" name="userId[]" class="userId" value="{{$uId}}" />
				<div style="right:0; top: 0; position: absolute;">
				<input type="checkbox" name="powiadomUzytkownikSms" id="powiadomUzytkownikSms" /> <label for="powiadomUzytkownikSms" style="display:inline;" >SMS</label>
				<input type="checkbox" name="powiadomUzytkownikEmail" id="powiadomUzytkownikEmail" /> <label for="powiadomUzytkownikEmail" style="display:inline;" >E-mail</label>
				</div>
			</label>
		</li>
		{{END uzytkownikPowiadom}}
	</ul>
</div>
<div class="control-group input_ok">
	<input id="zapiszNotatke" class="btn btn-primary" type="submit" value="Save" name="zapiszNotatke">
	<input id="wsteczNote" class="btn " type="button" value="Cancel" name="wstecz">
</div>
{{END}}
{{BEGIN dodajWydarzenieSpecjalne}}
<div class="alert alert-info ">
IN PROGRESS
</div>
{{END}}

{{BEGIN listaTeamow}}
<script >
	var grupa = "{{$grupa}}";
	
	$(document).ready(function(){ initPage();	});

	function initPage()
	{
		$( "#sortowanie" ).sortable();
		$(document).on('click', '.usun', function(){	usunTeamZListy($(this));  });
		$(document).on('click', '.zapisz', function(){	zapiszSortowanie();  });
	}
	$('#teamSelect').select2({
		placeholder: "Enter min. 3 characters",
		minimumInputLength: 3,
		ajax: {
			url: "{{$urlSearchTeam}}",
			dataType: 'json',
			quietMillis: 100,
			data: function (term, page) { 
				return {
					fraza: term, 
					nrStrony: page,
					naStronie: 20,
					grupa: grupa
				};
			},
			results: function (data, page) {
				var more = (page * 20) < data.total; 
				return {results: data.team, more: more};
			}
		},
		formatResult: teamFormatResult, // omitted for brevity, see the source of this page
		formatSelection: teamFormatSelection, // omitted for brevity, see the source of this page
		dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
		escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
	});

	function teamFormatResult(team) {
			
			var markup = "<table style='width:100%;' ><tr>";
			 
			markup += "<td style='text-align:left;'><div >" + team.nazwa +" "+team.rejestracja+" </div></td>";
			markup += "</tr></table>";
			return markup;
		}
	function teamFormatSelection(team) {
		
				ajax("{{$urlDodajTeamDoListy}}"+'&grupa='+grupa, potwierdzDodajTeam, {id: team.id}, 'POST', 'json' );
				return  team.nazwa;
			}
	
	function potwierdzDodajTeam(dane)
	{
		if(dane.blad > 0) { alertModal('Error', dane.errorTxt); return false; }
		
		var element = $('#sortujTmp').clone();
		element.find('.nazwa').text(dane.team.nazwa);
		element.find('.rejestracja').text(dane.team.rejestracja);
		element.attr('id', 'i-'+dane.team.id);
		
		var listaUzytkownikow = element.find('.listaPracownikow');
		var user = element.find('.pracownik').clone();
		
		$.each(dane.team.pracownicy, function(index, value){
			var wybrany =	user.clone();
			wybrany.attr('src', value.zdjecie);
			listaUzytkownikow.append(wybrany);
		})
		element.show();
		$('#sortowanie').prepend(element);
	}
	function zapiszSortowanie()
	{
		var linkOrderData = $('#sortowanie').sortable('serialize');
		var dane = { 
			posortowane: linkOrderData, 
			iloscTeamow: $('#teamLimit').val(),
			dataStart: $('#dataStartK').val(),
			dataStop: $('#dataStopK').val(),
			dataSuwakStart: $('#dataSuwakStart').val(),
			dataSuwakStop: $('#dataSuwakStop').val(),
			domyslnaGrupa: $('#domyslnaGrupa').val(),
			grupa: grupa,
		};
		ajax("{{$urlZapiszSortowanie}}" , potwierdzSortowanieZapisane, dane , 'POST', 'json' );
	}
	function potwierdzSortowanieZapisane(dane)
	{
		if(dane.blad > 0) { alertModal('Error', dane.errorTxt); return false; }
		
		location.reload();
	}
	function usunTeamZListy(przycisk)
	{
		var id = przycisk.parents('.sortuj').attr('id').replace('i-', '');
		ajax("{{$urlUsunTeamZListy}}"+'&grupa='+grupa , potwierdzUsunTeam, {id: id}, 'POST', 'json' );
	}
	function potwierdzUsunTeam(dane)
	{
		if(dane.blad > 0) { alertModal('Error', dane.errorTxt); return false; }
		
		$('#i-'+dane.id).remove();
	}
	
</script>
	<div class="widget-content">
		<div >
			<div class="control-group input_ok" style="margin-left:50px;">
				<label class="control-label input_ok " for="address">Select team : </label>
					<div class="controls">
						<input class="js-data-example-ajax" style="width: 90%;" name="teamSelect" id="teamSelect" />
					</div>
			</div>
		</div>
	</div>
	<ul class="site-stats" id="sortowanie">
		{{BEGIN team}}
		<li class="sortuj" id="i-{{$idTeam}}">
			<div class="cc">
				<i class="icon icon-truck"></i>
				<strong>{{$nazwa}}</strong> <small>{{$rejestracja}}</small>
				{{BEGIN zdjecia_pracownikow}}
				<img class="tip top pracownik margin {{IF $lider}}lider{{END}}" src="{{$zdjecie}}" style="cursor: pointer;" alt="{{$imie}} {{$nazwisko}}" data-original-title="" rel="comm-{{$id}}" data-oryginal-title="{{$imie}} {{$nazwisko}}" />
				{{END}}
				<button alt="remove" class="btn btn-danger usun fR" ><i class="icon icon-remove"></i></button>
			</div>
		</li>
		{{END}}
		<li class="sortuj" style="display:none;" id="sortujTmp">
			<div class="cc">
				<i class="icon icon-truck"></i>
				<strong class="nazwa">{{$nazwa}}</strong> <small class="rejestracja">{{$rejestracja}}</small>
				<div class="listaPracownikow" style="display:inline;">
					<img class="tip top pracownik margin {{IF $lider}}lider{{END}}" src="{{$zdjecie}}" style="cursor: pointer;" alt="{{$imie}} {{$nazwisko}}" data-original-title="" rel="comm-{{$id}}" data-oryginal-title="{{$imie}} {{$nazwisko}}" />
				</div>
				<button alt="remove" class="btn btn-danger usun fR" ><i class="icon icon-remove"></i></button>
			</div>
		</li>
	</ul>
	<button name="zapisz" class="btn btn-primary zapisz" >{{$etykietaZapiszTeam}}</button>
{{END}}


{{BEGIN konfiguracja}}
<script >
	var grupa = '';
	var tags=[ 
		{{BEGIN grupaTeamow}}
			{id: '{{$wartosc}}', text: '{{$etykieta}}' },
		{{END}}
		];
		
	$(document).ready(function(){ initPage();	});

	function initPage()
	{
		$( "#sortowanie" ).sortable();
		$('#usunGrupe').on('click', function(){ potwierdzenieModal1( "{{$potwierdzUsunGrupe}}", 'Confirm', 'usunGrupe()' ); });
		$('#zamknijKonfiguracja').on('click', function(){ $('.close').click(); })
		$(document).on('click', '.usun', function(){	usunTeamZListy($(this));  });
		$(document).on('click', '.zapisz', function(){	zapiszSortowanie();  });
		
		$("#teamGroup").select2({
				data: tags,
				multiple: false,
				placeholder : 'Select group or add new',
				createSearchChoice: function(term, data) {
					return {
						 id: term.replace(' ', ''),
						 text: term + ' (new)'
					};
			  },
		  }).on("change", function (e) {
			  
			   var theID = $(this).select2('data').id;
				var theSelection = $(this).select2('data').text;
				grupa = theID;
				
				if(theSelection.indexOf('(new)') > -1)
				{
					$('#dodajGrupe').show();
					$('#usunGrupe').hide();
					$('#sortowanie').html('');
					$('#grupa').hide();
					ajax("{{$urlDodajGrupe}}", potwierdzDodajGrupe, { grupaId: theID, grupaNazwa: theSelection.replace('(new)', '') } , 'POST', 'json' );
				}
				else
				{
					$('#dodajGrupe').hide();
					ajax("{{$urlPobierzGrupe}}", potwierdzPobierzGrupe, { grupa: theID } , 'POST', 'json' );
				}
			});
	}
	function potwierdzDodajGrupe(dane)
	{
		if(dane.blad > 0){ alertModal('Error', dane.errorTxt); return false; }
		
		$('#dodajGrupe').hide();
		$('#grupa').show();
		tags.push( { id: dane.grupaId, text: dane.grupaNazwa } );
		
		$("#teamGroup").select2('data', tags);
		$("#teamGroup").select2('val', dane.grupaId); 
	}
	function usunGrupe()
	{
		var idGrupy = $('#teamGroup').select2('data').id;
		ajax("{{$urlUsunGrupe}}", potwierdzUsunGrupe, { grupa: idGrupy } , 'POST', 'json' );
	}
	function potwierdzUsunGrupe(dane)
	{
		if(dane.blad > 0){ 
			alertModal('Error', dane.errorTxt); return false; 
		}else if(dane.warning > 0) { alertModal('Warning', dane.warningTxt); }
		
		$.each(tags, function(index, value){
			if(value.id == dane.grupa) delete tags[index];
		});
		$('#sortowanie').html('');
		$('#grupa').hide();
		$('#usunPotwierdzenie').find('.close').click();
	}
	
	function potwierdzPobierzGrupe(dane)
	{
		$('#sortowanie').html(dane.html);
		$('#grupa').show();
		$('#usunGrupe').show();
	}
	
	$('#teamSelect').select2({
		placeholder: "Enter min. 3 characters",
		minimumInputLength: 3,
		ajax: {
			url: "{{$urlSearchTeam}}",
			dataType: 'json',
			quietMillis: 100,
			data: function (term, page) { 
				return {
					fraza: term, 
					nrStrony: page,
					naStronie: 20,
					grupa: grupa
				};
			},
			results: function (data, page) {
				var more = (page * 20) < data.total; 
				return {results: data.team, more: more};
			}
		},
		formatResult: teamFormatResult, // omitted for brevity, see the source of this page
		formatSelection: teamFormatSelection, // omitted for brevity, see the source of this page
		dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
		escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
	});

	function teamFormatResult(team) {
			
			var markup = "<table style='width:100%;' ><tr>";
			 
			markup += "<td style='text-align:left;'><div >" + team.nazwa +" "+team.rejestracja+" </div></td>";
			markup += "</tr></table>";
			return markup;
		}
	function teamFormatSelection(team) {
		
				ajax("{{$urlDodajTeamDoListy}}"+'&grupa='+grupa, potwierdzDodajTeam, {id: team.id}, 'POST', 'json' );
				return  team.nazwa;
			}
	
	function potwierdzDodajTeam(dane)
	{
		if(dane.blad > 0) { alertModal('Error', dane.errorTxt); return false; }
		
		var element = $('#sortujTmp').clone();
		element.find('.nazwa').text(dane.team.nazwa);
		element.find('.rejestracja').text(dane.team.rejestracja);
		element.attr('id', 'i-'+dane.team.id);
		
		var listaUzytkownikow = element.find('.listaPracownikow');
		var user = element.find('.pracownik').clone();
		
		$.each(dane.team.pracownicy, function(index, value){
			var wybrany =	user.clone();
			wybrany.attr('src', value.zdjecie);
			listaUzytkownikow.append(wybrany);
		})
		element.show();
		$('#sortowanie').prepend(element);
	}
	
	function zapiszSortowanie()
	{
		var linkOrderData = $('#sortowanie').sortable('serialize');
		var dane = { 
			posortowane: linkOrderData, 
			iloscTeamow: $('#teamLimit').val(),
			dataStart: $('#dataStartK').val(),
			dataStop: $('#dataStopK').val(),
			dataSuwakStart: $('#dataSuwakStart').val(),
			dataSuwakStop: $('#dataSuwakStop').val(),
			domyslnaGrupa: $('#domyslnaGrupa').val(),
			grupa: grupa,
		};
		ajax("{{$urlZapiszSortowanie}}" , potwierdzSortowanieZapisane, dane , 'POST', 'json' );
	}
	function potwierdzSortowanieZapisane(dane)
	{
		if(dane.blad > 0) { alertModal('Error', dane.errorTxt); return false; }
		
		location.reload();
	}
	function usunTeamZListy(przycisk)
	{
		var id = przycisk.parents('.sortuj').attr('id').replace('i-', '');
		ajax("{{$urlUsunTeamZListy}}"+'&grupa='+grupa , potwierdzUsunTeam, {id: id}, 'POST', 'json' );
	}
	function potwierdzUsunTeam(dane)
	{
		if(dane.blad > 0) { alertModal('Error', dane.errorTxt); return false; }
		
		$('#i-'+dane.id).remove();
	}
	
</script>
<div class="row" style="margin:0px;">
	<div style="width:49%; float: left;">
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
				<i class="icon icon-group"></i>
				</span>
				<h5>{{$etykietaKonfigurujTeam}}</h5>
			</div>
			<div class="widget-content">
				<div class="control-group input_ok" style="margin-left:50px;">
					<label class="control-label input_ok " for="address">{{$etykietaSelectGroup}} </label>
						<div class="controls">
							<input type='hidden' style="width: 90%;" name="teamGroup" id="teamGroup" />
							<button class="btn btn-danger" style="display:none;" id="usunGrupe" ><i class="icon icon-remove" ></i></button>
							<button class="btn btn-info" style="display:none;" id="dodajGrupe" ><i class="icon icon-ok" ></i></button>
						</div>
				</div>
			</div>
		</div>
		<div class="widget-box hide" id="grupa">
			<div class="widget-title">
				<span class="icon">
				<i class="icon icon-group"></i>
				</span>
				<h5>{{$etykietaKonfigurujTeam}}</h5>
			</div>
			<div class="widget-content">
				<div >
					<div class="control-group input_ok" style="margin-left:50px;">
						<label class="control-label input_ok " for="address">Select team : </label>
							<div class="controls">
								<input class="js-data-example-ajax" style="width: 90%;" name="teamSelect" id="teamSelect" />
							</div>
					</div>
					<li class="sortuj" style="display:none;" id="sortujTmp">
						<div class="cc">
							<i class="icon icon-truck"></i>
							<strong class="nazwa">{{$nazwa}}</strong> <small class="rejestracja">{{$rejestracja}}</small>
							<div class="listaPracownikow" style="display:inline;">
								<img class="tip top pracownik margin {{IF $lider}}lider{{END}}" src="{{$zdjecie}}" style="cursor: pointer;" alt="{{$imie}} {{$nazwisko}}" data-original-title="" rel="comm-{{$id}}" data-oryginal-title="{{$imie}} {{$nazwisko}}" />
							</div>
							<button alt="remove" class="btn btn-danger usun fR" ><i class="icon icon-remove"></i></button>
						</div>
					</li>
					
				</div>
			</div>
	</div>
	</div>
	<div style="width:49%; float: left; margin-left: 35px;">
		<div class="widget-box">
		<div class="widget-title">
		<span class="icon">
		<i class="icon icon-cog"></i>
		</span>
		<h5>Menage Data</h5>
		</div>
		<div class="widget-content">
			<div class="control-group input_ok" style="margin-left:50px;">
				<label class="control-label input_ok " for="address">Team limit : </label>
					<div class="controls">
						<input type="text" class="" style="width: 30%;" name="teamLimit" id="teamLimit" value="{{$wyswietlajIloscTeamow}}" />
				</div>
			</div>
			<div class="control-group input_ok" style="margin-left:50px;">
				<label class="control-label input_ok " for="address">{{$dataStartEtykieta}} </label>
					<div class="controls">
						<select name="dataStartK" id="dataStartK" >
							{{BEGIN zakresDatStart}}
							<option value="{{$wartosc}}" {{IF $selected}}selected='selected'{{END IF}} >{{$etykieta}}</option>
							{{END zakresDatStart}}
						</select>
					</div>
			</div>
			<div class="control-group input_ok" style="margin-left:50px;">
				<label class="control-label input_ok " for="address">{{$dataStopEtykieta}} </label>
					<div class="controls">
						<select name="dataStopK" id="dataStopK" >
							{{BEGIN zakresDatStop}}
							<option value="{{$wartosc}}" {{IF $selected}}selected='selected'{{END IF}} >{{$etykieta}}</option>
							{{END zakresDatStop}}
						</select>
					</div>
			</div>
			<div class="control-group input_ok" style="margin-left:50px;">
				<label class="control-label input_ok " for="address">{{$dataSuwakStartEtykieta}} </label>
					<div class="controls">
						<select name="dataSuwakStart" id="dataSuwakStart" >
							{{BEGIN zakresDatSuwakStart}}
							<option value="{{$wartosc}}" {{IF $selected}}selected='selected'{{END IF}} >{{$etykieta}}</option>
							{{END zakresDatSuwakStart}}
						</select>
					</div>
			</div>
			<div class="control-group input_ok" style="margin-left:50px;">
				<label class="control-label input_ok " for="address">{{$dataSuwakStopEtykieta}} </label>
					<div class="controls">
						<select name="dataSuwakStop" id="dataSuwakStop" >
							{{BEGIN zakresDatSuwakStop}}
							<option value="{{$wartosc}}" {{IF $selected}}selected='selected'{{END IF}} >{{$etykieta}}</option>
							{{END zakresDatSuwakStop}}
						</select>
					</div>
			</div>
			<div class="control-group input_ok" style="margin-left:50px;">
				<label class="control-label input_ok " for="address">{{$domyslnaGrupaEtykieta}} </label>
					<div class="controls">
						<select name="domyslnaGrupa" id="domyslnaGrupa" >
							<option value="" >{{$wybierzDomyslnaGrupeEtykieta}}</option>
							{{BEGIN domyslnaGrupa}}
							<option value="{{$wartosc}}" {{IF $selected}}selected='selected'{{END IF}} >{{$etykieta}}</option>
							{{END domyslnaGrupa}}
						</select>
					</div>
			</div>
		</div>
		</div>
		<div class="control-group input_ok" style="margin-left:50px;">
			<div class="controls">
				<input id="zamknijKonfiguracja" class="btn btn-default zamknijKonfiguracja" type="submit" value="Close" name="close">
				<input id="zapisz1" class="btn btn-primary zapisz" type="submit" value="Save" name="zapisz">
			</div>
		</div>
	</div>
</div>
{{END}}
{{BEGIN widokEventu}}
<script type="text/javascript">
		
		$(document).ready(function(){ initPage();	});
		
		function initPage()
		{
			{{BEGIN szukajZamowienia}}
			nalozSelect{{$nazwaSzablonu}}();
			{{END szukajZamowienia}}
			{{BEGIN daneStandardowe}}
			kolorPrzycisk($('#kolor{{$nazwaSzablonu}}'), '#90C3D4');
			{{END}}
		}
		
		{{BEGIN szukajZamowienia}}
		function nalozSelect{{$nazwaSzablonu}}()
		{
			$('#zamowienieInput{{$nazwaSzablonu}}').select2({
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
				$('#nazwaWyswietlana{{$nazwaSzablonu}}').val(orders.order_name);
				return orders.order_name;
		}
		{{END szukajZamowienia}}
</script>

	{{BEGIN szukajZamowienia}}
	<div class="control-group input_ok">
		<label class="control-label input_ok " for="address">Select order : </label>
			<div class="controls">
				<input class="js-data-example-ajax" style="width: 90%;" name="zamowienieInput{{$nazwaSzablonu}}" id="zamowienieInput{{$nazwaSzablonu}}" />
				<span class="help-block" style="display:none;" >{{$bladZamowienie}}</span>
		</div>
	</div>
	{{END szukajZamowienia}}
	
	{{BEGIN daneStandardowe}}
	<div class="control-group input_ok">
		<label class="control-label input_ok " for="address">Name displayed : </label>
			<div class="controls">
				<input type="text" style="width: 90%;" name="nazwaWyswietlana{{$nazwaSzablonu}}" id="nazwaWyswietlana{{$nazwaSzablonu}}" />
				<span class="help-block" style="display:none;" >{{$bladNazwaWyswietlana}}</span>
		</div>
	</div>
	<div class="control-group input_ok">
		<label class="control-label input_ok " for="address">Select color : </label>
			<div class="controls">
				<div class="demo2">
					<input type="text" style="width:70px;" value="" name="kolor{{$nazwaSzablonu}}" id="kolor{{$nazwaSzablonu}}" class="form-control kolor" />
					<span class="input-group-addon"><i></i></span>
				</div>
			<span class="help-block" style="display:none;" >{{$bladKolor}}</span>
		</div>
	</div>
	<div class="control-group input_ok">
		<label class="control-label input_ok " for="address">Comment : </label>
			<div class="controls">
					<input type="text" style="width: 90%;" value="" name="komentarz" id="komentarz" />
					<span class="input-group-addon"><i></i></span>
			<span class="help-block"></span>
		</div>
	</div>
	{{END daneStandardowe}}
	
	{{BEGIN powiadomienia}}
	<div class="control-group input_ok">
	<label class="control-label input_ok " for="address">Send notification : </label>
		<div class="controls">
			<select name="powiadomienieDni" id="powiadomienieDni">
				{{BEGIN przypomnienieOpcjeDni}}
				<option value="{{$klucz}}" >{{$wartosc}}</option>
				{{END}}
			</select>
		</div>
</div>
<div class="control-group input_ok">
	<label class="control-label input_ok " for="address">send me : </label>
		<div class="controls">
			<input type="checkbox" name="powiadomMnieSms" id="powiadomMnieSms" /><label for="powiadomMnieSms" style="display:inline;" >SMS</label>
			<input type="checkbox" name="powiadomMnieEmail" id="powiadomMnieEmail" /><label for="powiadomMnieEmail" style="display:inline;">E-mail</label>
	</div>
</div>
<div class="control-group input_ok">
	<label class="control-label input_ok " for="address">send to : </label>
		<div class="controls">
			<input class="js-data-example-ajax" style="width: 50%;" name="userSelect" id="userSelect" />
			<span class="input-group-addon"><i></i></span>
			<span class="help-block"></span>
	</div>
</div>
<div class="control-group input_ok">
	<ul id="userList">
		<li id="tmpUzytkownik" style="display:none;" >
			<label class="control-label input_ok " for="address"><img src="/_public/zdjecia/min-a38e0781.jpg" style="width:30px;"> <strong class="nazwa">Jan Zastawny </strong> 
				<input type="hidden" name="userId[]" class="userId" value="" />
				<div style="right:0; top: 0; position: absolute;">
				<input type="checkbox" class="no-uniform" name="powiadomUzytkownikSms" id="powiadomUzytkownikSms" /> <label for="powiadomUzytkownikSms" style="display:inline;" >SMS</label>
				<input type="checkbox" class="no-uniform" name="powiadomUzytkownikEmail" id="powiadomUzytkownikEmail" /> <label for="powiadomUzytkownikEmail" style="display:inline;" >E-mail</label>
				</div>
			</label>
		</li>
		{{BEGIN uzytkownikPowiadom}}
		<li>
			<label class="control-label input_ok " for="address"><img src="{{$zdjecie}}" style="width:30px;"> <strong class="nazwa">{{$imie}} </strong> 
				<input type="hidden" name="userId[]" class="userId" value="{{$uId}}" />
				<div style="right:0; top: 0; position: absolute;">
				<input type="checkbox" name="powiadomUzytkownikSms" id="powiadomUzytkownikSms" /> <label for="powiadomUzytkownikSms" style="display:inline;" >SMS</label>
				<input type="checkbox" name="powiadomUzytkownikEmail" id="powiadomUzytkownikEmail" /> <label for="powiadomUzytkownikEmail" style="display:inline;" >E-mail</label>
				</div>
			</label>
		</li>
		{{END uzytkownikPowiadom}}
	</ul>
</div>
	{{END powiadomienia}}
	
{{END widokEventu}}

{{BEGIN nowywidok}}
<link href="/_system/css/kalendarz.css" rel="stylesheet">
<link href='/_system/js/fullcalendar-2.9.1/fullcalendar.css' rel='stylesheet' />
<link href='./_system/js/fullcalendar-2.9.1/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='/_system/js/fullcalendar-2.9.1/lib/moment.min.js'></script>
<script src='/_system/js/fullcalendar-2.9.1/lib/jquery.min.js'></script>
<script src='/_system/js/fullcalendar-2.9.1/fullcalendar.min.js'></script>
<script>
	$(document).ready(function(){
		var d = new Date();
		var m = ('0' + (d.getMonth()+1)).slice(-2);
		
		$('.team-resize').on('click', function(){
			location.href = '{{$nowywidokfull}}';
		});
		
		$("#fraza").keyup(function(){
				var filter = $.trim($(this).val()), count = 0;
				
				$(".szukajTeam").each(function(){
					
					if($(this).text().search(new RegExp(filter, "i")) < 0)
					{
						$(this).parents('.teamKalendarz').fadeOut();
					}
					else
					{
						$(this).parents('.teamKalendarz').show();
						count++;
					}
				});
			});
			
		addSortableFunction($('#kalendarz'));
		$('.kalendarz').fullCalendar({
			header: {
				left: 'prev,next',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			defaultDate: '2016-08-12',
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events: [
				{
					title: 'Day off',
					start: '2016-'+m+'-01'
				},
				{
					title: 'JESSHEIM 2050, BRINKVEGEN 41 H0101',
					start: '2016-'+m+'-07',
					end: '2016-'+m+'-10'
				},
				{
					id: 999,
					title: 'Sick day',
					start: '2016-'+m+'-09T16:00:00',
					color: '#ff0000'
				},
				{
					id: 999,
					title: 'Olstadmoen BS 1, Prosjekt 06FIB14035',
					start: '2016-'+m+'-16T16:00:00',
					end: '2016-'+m+'-23',
					color: '#B190D4'
				},
				{
					title: 'Olstadmoen BS 1, Prosjekt 06FIB14035',
					start: '2016-'+m+'-11',
					end: '2016-'+m+'-20',
					color: '#ABD490'
				},
				{
					title: 'Brinken 1-4 Jessheim, Prosjekt 06FIB15020',
					start: '2016-'+m+'-12T10:30:00',
					end: '2016-'+m+'-14T12:30:00',
					color: '#D9751E'
				},
				{
					title: 'Teknikerbesøk Skjettenbyen',
					start: '2016-'+m+'-14T12:00:00',
					end: '2016-'+m+'-21',
					color: '#D9751E'
				},
				{
					title: 'Evjegata 5, Prosjekt 105212',
					start: '2016-'+m+'-14T14:30:00',
					end: '2016-'+m+'-17'
				},
				{
					title: 'Årvollia 1-27',
					start: '2016-'+m+'-10T17:30:00',
					end: '2016-'+m+'-15'
				},
				{
					title: 'Fjellhytta, Prosjekt 050613D',
					start: '2016-'+m+'-12T20:00:00',
					end: '2016-'+m+'-13'
				},
				{
					title: 'Birthday Party',
					start: '2016-'+m+'-13T07:00:00',
					end: '2016-'+m+'-14'
				},
				{
					title: 'Click for Google',
					url: 'http://google.com/',
					start: '2016-'+m+'-28'
				}
			]
		});
		
	});
	setTimeout(function(){
		$('.fc-header').removeAttr('style');
	},500);
	
	function addSortableFunction(obiekt)
	{
		obiekt.sortable({
			items : ".teamKalendarz",
			scrollSpeed: 40,
			tolerance: "intersect",
			placeholder: "ui-state-highlight",
			zIndex: 9999,	
			handle: ".kalendarzTeamNaglowek"
		});
	}
</script>
<div >
	<form id="wyszukiwarka" class="form-inline" enctype="multipart/form-data" name="no-focus-wyszukiwarka" method="post" action="">
		<ul class="fL">
		<li class="fL">
		<label class="input_ok label-szukaj" for="szukaj">Search : </label>
		<input id="fraza" class="input-szukaj" type="text" value="" name="fraza" autocomplete="off" placeholder="Enter at least 3 characters" autofocus="">
		<div class="clear"></div>
		<span id="ilosc-wynikow" class="help-block"></span>
		</li>
		</ul>
	</form>
	<br clear="all" />
	<ul id="kalendarz">
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 01 <span class="hidden">Maciej Walec Sereda</span> </strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 02 <span class="hidden">Janusz Pis</span></strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 03 <span class="hidden">Justyna Pis</span></strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 04 <span class="hidden">Michal Marek Pis</span></strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 05 <span class="hidden">Wojtek</span></strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 06 <span class="hidden">Magrys</span></strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 07</strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 08</strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 09</strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 10</strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 11</strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 12</strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 13</strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 14</strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 15</strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 16</strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 17</strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 18</strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 19</strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 20</strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 21</strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 22</strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 23</strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 24</strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 25</strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 26</strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 27</strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 28</strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 29</strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
		<li class="teamKalendarz">
			<div class="kalendarzTeamNaglowek">
				<table>
					<tr>
						<td>
							<img class="tip top pracownik margin lider" src="/_public/zdjecia/xs-b4ba78a3.jpg" style="cursor: pointer;" alt="Dariusz Wojtowicz" data-original-title="" rel="comm-8" data-oryginal-title="Dariusz Wojtowicz">
							<img class="tip top pracownik margin" src="/_public/zdjecia/xs-006f4331.jpg" style="cursor: pointer;" alt="Janusz Sereda" data-original-title="" rel="comm-21" data-oryginal-title="Janusz Sereda">
						</td>
						<td>
							<strong class="szukajTeam">Bil 30</strong>
						</td>
						<td>
							<span class="icon margin fR team-resize In cursorPointer tip-top" style="font-size: 16px;" data-original-title="resize">
								<i class="icon icon-code"></i>
							</span>
						</td>
					</tr>
				</table>
			</div>
			<div class="kalendarz"></div>
		</li>
	</ul>
</div>
{{END}}
{{BEGIN nowyWidokFull}}
<link href="/_system/css/kalendarz.css" rel="stylesheet">
<link href='/_system/js/fullcalendar-2.9.1/fullcalendar.css' rel='stylesheet' />
<link href='./_system/js/fullcalendar-2.9.1/fullcalendar.print.css' rel='stylesheet' media='print' />
<script src='/_system/js/fullcalendar-2.9.1/lib/moment.min.js'></script>
<script src='/_system/js/fullcalendar-2.9.1/lib/jquery.min.js'></script>
<script src='/_system/js/fullcalendar-2.9.1/fullcalendar.min.js'></script>
<script>
	$(document).ready(function(){
		var d = new Date();
		var m = ('0' + (d.getMonth()+1)).slice(-2);
		
		$('.team-resize').on('click', function(){
			
		});
		
		$('#fullKalendarz').fullCalendar({
			header: {
				left: 'prev,next',
				center: 'title',
				right: 'month,basicWeek,basicDay'
			},
			defaultDate: '2016-08-12',
			editable: true,
			eventLimit: true, // allow "more" link when too many events
			events: [
				{
					title: 'Day off',
					start: '2016-'+m+'-01'
				},
				{
					title: 'JESSHEIM 2050, BRINKVEGEN 41 H0101',
					start: '2016-'+m+'-07',
					end: '2016-'+m+'-10'
				},
				{
					id: 999,
					title: 'Sick day',
					start: '2016-'+m+'-09T16:00:00',
					color: '#ff0000'
				},
				{
					id: 999,
					title: 'Olstadmoen BS 1, Prosjekt 06FIB14035',
					start: '2016-'+m+'-16T16:00:00',
					end: '2016-'+m+'-23',
					color: '#B190D4'
				},
				{
					title: 'Olstadmoen BS 1, Prosjekt 06FIB14035',
					start: '2016-'+m+'-11',
					end: '2016-'+m+'-20',
					color: '#ABD490'
				},
				{
					title: 'Brinken 1-4 Jessheim, Prosjekt 06FIB15020',
					start: '2016-'+m+'-12T10:30:00',
					end: '2016-'+m+'-12T12:30:00',
					color: '#D9751E'
				},
				{
					title: 'Teknikerbesøk Skjettenbyen',
					start: '2016-'+m+'-14T12:00:00',
					end: '2016-'+m+'-21',
					color: '#D9751E'
				},
				{
					title: 'Evjegata 5, Prosjekt 105212',
					start: '2016-'+m+'-14T14:30:00',
					end: '2016-'+m+'-17'
				},
				{
					title: 'Årvollia 1-27',
					start: '2016-'+m+'-10T17:30:00',
					end: '2016-'+m+'-15'
				},
				{
					title: 'Fjellhytta, Prosjekt 050613D',
					start: '2016-'+m+'-12T20:00:00',
					end: '2016-'+m+'-13'
				},
				{
					title: 'Birthday Party',
					start: '2016-'+m+'-13T07:00:00',
					end: '2016-'+m+'-14'
				},
				{
					title: 'Click for Google',
					url: 'http://google.com/',
					start: '2016-'+m+'-28'
				}
			]
		});
		
	});
	setTimeout(function(){
		$('.fc-header').removeAttr('style');
	},500);
</script>
<div class="tabbable inline">
	<a class="btn btn-primary" href="{{$wstecz}}">Back</a><br/><br/>
	<ul id="myTab" class="nav nav-tabs tab-bricky">
		<li class="active">
			<a href="{{$link}}" data-toggle=""> Bil 01 </a>
		</li>
		<li class="">
			<a href="{{$link}}" data-toggle=""> Bil 02 </a>
		</li>
		<li class="">
			<a href="{{$link}}" data-toggle=""> Bil 03 </a>
		</li>
		<li class="">
			<a href="{{$link}}" data-toggle=""> Bil 04 </a>
		</li>
		<li class="">
			<a href="{{$link}}" data-toggle=""> Bil 05 </a>
		</li>
		<li class="">
			<a href="{{$link}}" data-toggle=""> Bil 06 </a>
		</li>
		<li class="">
			<a href="{{$link}}" data-toggle=""> Bil 07 </a>
		</li>
		<li class="">
			<a href="{{$link}}" data-toggle=""> Bil 08 </a>
		</li>
		<li class="">
			<a href="{{$link}}" data-toggle=""> Bil 09 </a>
		</li>
		<li class="">
			<a href="{{$link}}" data-toggle=""> Bil 10 </a>
		</li>
		<li class="">
			<a href="{{$link}}" data-toggle=""> Bil 11 </a>
		</li>
		<li class="">
			<a href="{{$link}}" data-toggle=""> Bil 12 </a>
		</li>
		<li class="">
			<a href="{{$link}}" data-toggle=""> Bil 13 </a>
		</li>
		<li class="">
			<a href="{{$link}}" data-toggle=""> Bil 14 </a>
		</li>
		<li class="">
			<a href="{{$link}}" data-toggle=""> Bil 15 </a>
		</li><li class="">
			<a href="{{$link}}" data-toggle=""> Bil 16 </a>
		</li>
		<li class="">
			<a href="{{$link}}" data-toggle=""> Bil 17 </a>
		</li>
		<li class="">
			<a href="{{$link}}" data-toggle=""> Bil 18 </a>
		</li>
		<li class="">
			<a href="{{$link}}" data-toggle=""> Bil 19 </a>
		</li>
		<li class="">
			<a href="{{$link}}" data-toggle=""> Bil 20 </a>
		</li>
		<li class="">
			<a href="{{$link}}" data-toggle=""> Bil 21 </a>
		</li>
		<li class="">
			<a href="{{$link}}" data-toggle=""> Bil 22 </a>
		</li>
		<li class="">
			<a href="{{$link}}" data-toggle=""> Bil 23 </a>
		</li>
		<li class="">
			<a href="{{$link}}" data-toggle=""> Bil 24 </a>
		</li>
		<li class="">
			<a href="{{$link}}" data-toggle=""> Bil 25 </a>
		</li>
		<li class="">
			<a href="{{$link}}" data-toggle=""> Bil 26 </a>
		</li>
		<li class="">
			<a href="{{$link}}" data-toggle=""> Bil 27 </a>
		</li>
		<li class="">
			<a href="{{$link}}" data-toggle=""> Bil 28 </a>
		</li>
		<li class="">
			<a href="{{$link}}" data-toggle=""> Bil 29 </a>
		</li>
		<li class="">
			<a href="{{$link}}" data-toggle=""> Bil 30 </a>
		</li>
		
	</ul>
		<div class="tab-content no-overflow" style="background:#fff;" >
			<div id="panel_tab2" class="tab-pane active">
				
				<div id="fullKalendarz"></div><br/><br/>
				<a class="btn btn-primary" href="{{$wstecz}}">Back</a>
			</div>
		</div>
</div>
{{END}}
{{BEGIN nowywidok2}}
<link href="/_system/css/kalendarz.css" rel="stylesheet">
<script src="/_system/js/jquery-3.0.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="/_system/js/spectrum.js"></script>
<link rel="stylesheet" href="/_system/js/spectrum.css" />
<script>
	var naglowek;
	var zaminyIstnieja;
	var przeniesEventTemp;
	var sortUserTemp;
	$(document).ready(function(){
		initPage();
	});
	
	$(document).on('click', '#usunZGrupy', function(event){ odepnijOdGrupy($(this)); });
	$(document).on('click', '.zaznaczPracownika ', function(e){  zaznaczPracownika($(this)); $('.close-menu').click(); e.defaultPrevented; return false; });
	$(document).on('click', '.zaznaczonyPracownik', function(e){ odznaczPracownika($(this)); e.defaultPrevented; return false; })
	$(document).on('click', '.cal-team:not(.opacityTeam , .nieZaznaczaj)', function(e){  sprawdzGrupe($(this)); e.defaultPrevented; return false; });
	$(document).on('click', '.team-wiecej' ,function(e){ zwinRozwinTeamWiecej($(this));  return false;	});
	$(document).on('mousedown mouseover',".zezwolZaznacz", function (e) { selectDay( $(this) , e); return false; });
	$(document).on('contextmenu','.cal-team-data', function(e){ menuPodreczne(e, $(this)); return false; });
	$(document).on('contextmenu','.pracownik', function(e){ menuPodreczne(e, $(this)); return false; });
	$(document).on('click', '.dodajEvent', function(){	dodajEvent( $(this).attr('id') ); });
	$(document).on('mousedown',".event:not(.nie-zaznaczaj)", function (e) { if(e.button == 0){ selectEvent($(this)); return false; } });
	$(document).on('click', '#usunPrzypisanie', function(){ $('.close-menu').click(); potwierdzenieModal1( "{{$potwierdzUsunPrzypisanie}}", 'Confirm', 'usunPrzypisanie()' ); } );
	$(document).on('click', '.grupaSzczegolyTeamu', function(){ pokazTeamGrupy($(this));  return false;  });
	$(document).on('click', '.doGrupy', function(){ powrotDoGrupy($(this));  return false; });
	$(document).on('click', '#wykonajEvent', function(){ wykonajEvent();  return false; });
	$(document).on('click', '#zapiszGrupe', function(){ zapiszGrupe();  return false; });
	$(document).on('click', '#listaPracownikowPrzycisk', function(){ pokazListePracownikow();  return false; });
	
	function initPage()
	{
		$('#nazwaGrupy').uniform();
		kolorPrzycisk($('#kolorTla'), '#90C3D4');
		kolorPrzycisk($('#kolorCzcionki'), '#000');
		$('#sortujTeam').on('click', function(){ sortujTeam(); });
		$('#kolorTla').on('change', function(){ zmienKolor('tlo'); })
		$('#kolorCzcionki').on('change', function(){ zmienKolor('czcionka'); })
		$('#nazwaGrupy').uniform();
		$('.closeStworzGrupe').on('click', function(){ $('#stworzGrupe').hide(); $('.stworzGrupeError').remove(); return false; });
		$('.usunGrupe').on('click', function(){ potwierdzenieModal1( "{{$potwierdzUsunGrupe}}", 'Confirm', 'usunGrupe(\''+$(this).parents('.cal-grupa').attr('data-grupa')+'\')' ); return false; });
		$('.edytujGrupe').on('click', function(){ modalAjax( "{{$urlEdytujGrupe}}"+'&grupa='+$(this).parents('th').attr('data-grupa'), {width: 1200, height: 1000} ); dopasujModala(); return false; });
		$('.close-menu').on('click', function(){ $('#menuPodreczne').hide(300); });
		$('#czyscZaznaczenie, #czyscZaznaczenie2').on('click', function(){ $('.selected').removeClass('selected'); $('.selectedEvent').removeClass('selectedEvent'); $('.close-menu').click(); });
		$('#ukryjEventy').on('click', function(){ ukryjEventy(); return false; });
		$('#pokazEventy').on('click', function(){ pokazEventy(); return false; });
		$('.ustawLidera').on('click', function(){ ustawLidera($(this)); return false; }  );
		$('#podgladZamowienia').on('click', function(){ podgladZamowienia($('.event-zaznaczony').attr('data-id')); });
		$('#do-gory').on('click', function(){ doGory(); });
		$('#wczytaj-wiecej-kalendarz').on('click', function(){ wczytajWiecejDat(); });
		$('.rozwinGrupaProjekty').on('click', function(){ rozwinGrupeProjekty($(this).parents('.event')); });
		$('.pokazBilGrupa').on('click', function(e){ pokazGrupe($(this)); return false; });
		
		//ustawSzerokoscTh();
		rozmiescEventy();
	   klonujNaglowek();
		setInterval(function(){ sprawdzZalogowanych(); }, {{$milisekundyOdswiezLogowanie}});
		
		$(window).scroll(function() { scrollTeamHead(); scrollDoGory(); });
		setSortableEvent(".event:not(.nie-przenos)");
		setSortableUser();
		setTimeout(function(){
			setResizable();
		}, 1000 );
		
	}
	
	function wykonajEvent()
	{
		if($('.event-zaznaczony').length > 0)
		{
			var ids = [];
			
			$.each($('.event-zaznaczony'),  function(i, event){
				ids.push($(this).attr('data-id'));
			});
			var dane = { ids: ids };
			ajax("{{$urlWykonajWydarzenie}}", eventWykonany, dane, 'POST', 'json');
		}
	}
	
	function eventWykonany(dane)
	{
		if(dane.blad > 0) alertModal('Error', dane.bladTxt);
		$.each(dane.ids, function(i, id){
			$('.event:not(.projekt)[data-id='+id+']').attr('data-wykonany', 1);
		});
		$('#menuPodreczne').find('.close-menu').click();
	}
	
	function odepnijOdGrupy(obiekt)
	{
		var idProjekt = $('#menuId').val();
		var idTeam = $('#menuIdTeam').val();
		ajax("{{$urlOdepnijOdGrupy}}", succesOdepnijOdGrupy, { idProjekt: idProjekt, idTeam:idTeam });
	}
	
	function succesOdepnijOdGrupy(dane)
	{
		if(dane.blad){ modalAlert('Something is wrong!'); return false; }
		
		var idProjekt = $('#menuId').val();
		var idTeam = $('#menuIdTeam').val();
		var data = $('#menuData').val();
		
		var grupaProjektow = $('.grupaZamowien[data-team='+idTeam+'][data-data='+data+']');
		var ids = grupaProjektow.attr('data-ids').split(',');
		ids.splice( $.inArray(idProjekt, ids), 1 );
		grupaProjektow.attr('data-ids', ids.join(','));
		umiescEvent($('.projekt[data-id='+idProjekt+'][data-team='+idTeam+']'));
		return true;
	}
	
	function rozwinGrupeProjekty(grupa)
	{
		var przycisk = grupa.find('.rozwinGrupaProjekty');
		var ids = grupa.attr('data-ids').split(',');
		var idTeam = grupa.attr('data-team');
		var data = grupa.attr('data-data');
		
		if(przycisk.hasClass('icon-plus'))
		{
			przycisk.toggleClass('icon-plus icon-minus');
			$.each(ids, function(k, id ){
				var event = $('.event[data-id='+id+'][data-team='+idTeam+']');
				event.removeClass('ukryty');
				umiescEvent(event);
			});
			
		}
		else
		{
			przycisk.toggleClass('icon-minus icon-plus');
			$.each(ids, function(k, id ){
				var event = $('.event[data-id='+id+'][data-team='+idTeam+']');
				event.appendTo('#listaEventow').addClass('ukryty');
				event.css('left', '0px');
				event.hide();
			});
			rozmiescEventyWPolu(idTeam, data);
			przeliczSzerokoscTeamu(idTeam);
		}
		$('.cal-team-data').removeClass('selected');
	}
	
	function sprawdzZalogowanych()
	{
		ajax( '{{$urlOdswiezLogowania}}', ustawZalogowane, { }, 'POST', 'json', false );
	}
	
	function ustawZalogowane(dane)
	{
		var zalogowanyProjekt = '<span class="zalogowanyEvent"></span>';
		$.each($('.cal-team').not('cal-grupa'), function(){
			var idTeam = $(this).attr('data-team');
			if(typeof dane[idTeam] != 'undefined')
			{
				$(this).find('.logowanieInfo').removeClass('niezalogowanyTeam').addClass('zalogowanyTeam');
				var zalogowany = $('.event[data-team='+idTeam+'][data-id='+dane[idTeam]+']');
				
				if( !zalogowany.find('.zalogowanyEvent').length )
				{
					zalogowany.prepend(zalogowanyProjekt);
				}
			}
			else
			{
				$(this).find('.logowanieInfo').removeClass('zalogowanyTeam').addClass('niezalogowanyTeam');
				$('.projekt[data-team='+idTeam+']').find('.zalogowanyEvent').remove();
			}
		});
		$.each($('.cal-team-grupa'), function(){
			var idTeam = $(this).attr('data-team');
			if(typeof dane[idTeam] != 'undefined')
			{
				$(this).find('.logowanieInfo').removeClass('niezalogowanyTeam').addClass('zalogowanyTeam');
				var zalogowany = $('.event[data-team='+idTeam+'][data-id='+dane[idTeam]+']');
				
				if( !zalogowany.find('.zalogowanyEvent').length )
				{
					zalogowany.prepend(zalogowanyProjekt);
				}
			}
			else
			{
				$(this).find('.logowanieInfo').removeClass('zalogowanyTeam').addClass('niezalogowanyTeam');
				$('.projekt[data-team='+idTeam+']').find('.zalogowanyEvent').remove();
			}
		});
	}
	
	function wczytajWiecejDat()
	{
		ajax("{{$urlWczytajWiecej}}" , succesWczytajWiecej, {}, 'POST', 'json', true );
	}
	
	function succesWczytajWiecej(dane)
	{
		$('#kalendarzSlim').html('');
		$('#kalendarzSlim').append(dane.html);
		
		$('#dataStart').val(dane.dataStart);
		$('#dataStop').val(dane.dataStop);
		
		initPage();
	}
	
	function doGory(){ $("html, body").animate({ scrollTop: 0 }, 500); }
	
	function pokazListePracownikow()
	{
		if($('#listaPracownikow').is(':visible'))
		{
			$('#listaPracownikow').animate({
				width: 0
		  }, 200);
			$('#listaPracownikow').hide();
		}
		else
		{
			$('#listaPracownikow').width('auto');
			var width = $('#listaPracownikow').width();
			$('#listaPracownikow').show();
			$('#listaPracownikow').animate({
				width: $('#listaPracownikow').get(0).scrollWidth
		  }, 200, function(){
				$(this).width(width);
		  });
		}
	}
	
	function powrotDoGrupy(obiekt)
	{
		var grupa = obiekt.attr('data-grupa');
		var team = obiekt.parents('.cal-team');
		team.appendTo($('#teamyGrupyUkryte'));
		$('th.cal-grupa').show();
		$('.zaznaczonyPracownik').click();
	}
	
	function pokazTeamGrupy(obiekt)
	{
		var idTeam = obiekt.attr('data-team');
		var grupa = obiekt.parents('.cal-grupa');
		var naglowek = $('.cal-team[data-team='+idTeam+']');
		var grupaNazwa = grupa.attr('data-grupa')
		grupa.hide();
		grupa.after( naglowek );
		przeliczSzerokoscTeamu(idTeam);
		naglowek.find('.doGrupy').attr('data-grupa', grupaNazwa);
	}
	
	function ustawLidera(obiekt)
	{
		var idPracownika = obiekt.parents('.pracownikMenu').attr('data-pracownik');
		var idTeamu = $('.imgPracownik[data-id='+idPracownika+']').parents('.cal-team').attr('data-team');
		ajax( '{{$urlUstawLidera}}', potwierdzUstawLidera, { idPracownika: idPracownika, idTeamu: idTeamu }, 'POST', 'json' );
	}
	
	function potwierdzUstawLidera(dane)
	{
		if(dane.blad){ alertModal('Error', dane.errorTxt); $('.close-menu').click(); return false; }
		
		$('.cal-team[data-team='+dane.idTeamu+']').find('.pracownik').removeClass('lider');
		$('.pracownik[rel=comm-'+dane.idPracownika+']').addClass('lider');
		$('.close-menu').click();
	}
	
	function ukryjEventy()
	{
		$('.event').hide();	$('.close-menu').click(); $('#ukryjEventy').hide(); $('#pokazEventy').show();
	}
	
	function pokazEventy()
	{
		$('.event:not(.ukryty)').show();	$('.close-menu').click(); $('#ukryjEventy').show(); $('#pokazEventy').hide();
	}
	
	function zaznaczPracownika(pracownik)
	{
		var idPracownika = pracownik.parents('.pracownikMenu').attr('data-pracownik');
		pracownik = $('.pracownik[rel=comm-'+idPracownika+']');
		
		var pracownikKontener = pracownik.parents('.cal-team');
		var team = pracownikKontener.attr('data-team');

		$('.cal-team').removeClass('wybranyUser');
		$('.cal-team-data').removeClass('wybranyUser');

		pracownik.parents('.cal-team').addClass('wybranyUser');
		$('.cal-team-data[data-team='+team+']').addClass('wybranyUser');

		$('.pracownik').removeClass('zaznaczonyPracownik');
		$('.cal-team-data').removeClass('selected');
		$('.event').removeClass('event-zaznaczony');
		//$('.event').addClass('nie-przenos');
		$('.cal-team-data').removeClass('opacityTeam');

		$('.cal-team').addClass('opacityTeam');
		$('.cal-team-data').not('.cal-team-data[data-team='+team+']').addClass('opacityTeam').removeClass('zezwolZaznacz');
		$('.cal-team[data-team='+team+']').removeClass('opacityTeam');
		pracownik.addClass('zaznaczonyPracownik');
		pracownik.addClass('disable-comm');
		
		$( ".sortable" ).sortable( "destroy" );
		setSortableEvent('.userEvent');
	}
	
	function odznaczPracownika(pracownik)
	{
		if(pracownik.hasClass('zaznaczonyPracownik'))
		{
			pracownik.parents('.cal-team').removeClass('wybranyUser');
			$('.cal-team-data').removeClass('wybranyUser');
			pracownik.removeClass('zaznaczonyPracownik');
			$('.cal-team').removeClass('opacityTeam');
			$('.cal-team-data').removeClass('opacityTeam').addClass('zezwolZaznacz');
			$('.cal-team-data').removeClass('selected');
			pracownik.removeClass('disable-comm');
			
			$( ".sortable" ).sortable( "destroy" );
			setSortableEvent(".event:not(.nie-przenos)");
		}
		
	}
	
	function sortujTeam()
	{
		var wymiar = {
			width: (screen.width - 100),
			height: 160,
			top: '30%',
		};
		modalAjax("{{$urlSortujTeam}}", wymiar );
		$('#oknoModalne').addClass('modal-no-resize');
	}
	
	function setResizable()
	{
		$('.event:not(.nie-rozszezaj)').resizable({
				grid: 180,
				handles: "s",
				distance: 50,
				start: function( event, ui ) {
					wylaczZaznaczanie(true);
					ui.element.addClass('pointerNone');
					if(ui.element.parents('.event').length)
					{
						ui.element.parents('.event').css('visibility', 'hidden');
						ui.element.css('visibility', 'visible');
					}
				},
				stop:  function( event, ui ) {
					ustawZmianyIstnieja();
					ui.element.removeClass('pointerNone');
					
					var data = {
						dataStop: event.originalEvent.target.getAttribute('data-data'),
						dataStart: event.target.getAttribute('data-data'),
						idTeam: event.target.getAttribute('data-team'),
						idUser: event.target.getAttribute('data-user'),
						idEvent: event.target.getAttribute('data-id'),
					};
					
					ajax( '{{$urlRozszerzEvent}}', potwierdzResizable, data, 'POST', 'json' );
					if(ui.element.parents('.event').length)
					{
						ui.element.parents('.event').css('visibility', 'visible');
						ui.element.css('visibility', 'visible');
					}
					wlaczZaznaczanie();
					
				}
		  });
	}
	
	function potwierdzResizable(dane)
	{
	}
	
	/* zarzadzanie grupami  */
	function sprawdzGrupe(obiekt)
	{
		if(obiekt.hasClass('teamZaznaczony'))
			obiekt.removeClass('teamZaznaczony')
		else
			obiekt.addClass('teamZaznaczony');
		
		if($('.teamZaznaczony').length > 1)
		{
			$('#stworzGrupe').show();
			$('#stworzGrupe').focus();
		}
		else
			$('#stworzGrupe').hide();
	}
	
	function zapiszGrupe()
	{
		var ids = pobierzZaznaczoneTeamy();
		if(ids.length && $('#nazwaGrupy').val() != '')
		{
			$('.stworzGrupeError').remove();
			var dane = {
				grupaNazwa: $('#nazwaGrupy').val(),
				grupaId: $('#nazwaGrupy').val().replace(' ', ''),
				ids: ids,
			};
			ajax("{{$ulrZapiszGrupe}}" , succesZapiszGrupe, dane, 'POST', 'json', true );
		}
		else
		{
			$('#stworzGrupe').append('<p style="color:red;" class="stworzGrupeError" >{{$ustawNazweGrupy}}</p>');
		}
		return false;
	}
	
	function succesZapiszGrupe(dane)
	{
		if(dane.blad){ alertModal(dane.bladTxt); return false; }
			
		$('#kalendarzSlim').html('');
		$('#kalendarzSlim').append(dane.html);
		$('#nazwaGrupy').val('');
		$('.closeStworzGrupe').click();
		initPage();
	}
	
	function pokazGrupe(przycisk)
	{
		$('.pokazBilGrupa').removeClass('zaznaczGrupa');
		przycisk.addClass('zaznaczGrupa');
		$('.grupaSzczegolyTeamu').hide();
		
		var grupa = przycisk.parents('.cal-grupa').attr('data-grupa');
		
		$('.cal-grupa-data[data-grupa='+grupa+']').children('.event').each(function(){
			$(this).hide();
			$('#listaEventow').append($(this));
		});

		if(przycisk.hasClass('grupa'))
		{
			$('.cal-grupa-data[data-grupa='+grupa+']').attr('data-team', grupa).removeClass('sortable').removeClass('zezwolZaznacz');
			$('#listaEventow .event[data-grupa='+grupa+']').each(function(){
					umiescEvent($(this));
			});
		}
		else
		{
			var team = przycisk.attr('data-team');
			$('.grupaSzczegolyTeamu[data-team='+team+']').show();
			$('.cal-grupa-data[data-grupa='+grupa+']').attr('data-team', team).addClass('sortable').addClass('zezwolZaznacz');

			$('#listaEventow .event[data-team='+team+']').each(function(){
					umiescEvent($(this), 1);
			});
			setSortableEvent(".event:not(.nie-przenos)");
		}
		return false;
	}
	
	function usunGrupe(idGrupy)
	{
		ajax("{{$urlUsunGrupe}}", potwierdzUsunGrupe, { grupa: idGrupy } , 'POST', 'json', true );
	}
	
	function potwierdzUsunGrupe(dane)
	{
		if(dane.blad > 0){ 
			alertModal('Error', dane.errorTxt); return false; 
		}else if(dane.warning > 0) { alertModal('Warning', dane.warningTxt); }
		
		$('#kalendarzSlim').html('');
		$('#kalendarzSlim').append(dane.html);
		$('.modal-header').children('.close').click();
		initPage();
	}
	
	/* koniec zarzadzanie grupami */
	
	/* zaznaczanie pol */
	function selectDay(obiekt, e)
	{
		if (e.buttons == 1 || e.buttons == 3) { (obiekt.hasClass('selected')) ? obiekt.removeClass('selected') : obiekt.addClass('selected');	$('.event-zaznaczony').removeClass('event-zaznaczony'); }
		
	}
	
	function selectEvent(obiekt){
		
		$('#menuIdTeam').val(obiekt.attr('data-team'));
		$('#menuData').val(obiekt.attr('data-data'));
		$('#menuId').val(obiekt.attr('id').replace('event_', '')); 
		
		if(obiekt.hasClass('event-zaznaczony'))
		{
			obiekt.toggleClass('event-zaznaczony');  
			//odznaczPodobne('team');
		}
		else
		{
			$('.selected').removeClass('selected');
			obiekt.toggleClass('event-zaznaczony');  
			//zaznaczPodobne('team');	
		}
	}
	
	/* koniec zaznaczanie pol */
	
	/* menu podreczne */
	function menuPodreczne(e, obiekt)
	{
		var wyswietlam = 0;
		var menuPodreczne = $('#menuPodreczne');
		
		menuPodreczne.find('li[data-grupa=pusty]').hide();
		menuPodreczne.find('li[data-grupa=selectedEvent]').hide();
		menuPodreczne.find('li[data-grupa=selected]').hide();
		menuPodreczne.find('li[data-grupa=event]').hide();
		menuPodreczne.find('li[data-grupa=zamowienie]').hide();
		menuPodreczne.find('li.wypelniony').hide();
		menuPodreczne.find('li[data-grupa=projekt-grupy]').hide();
		$('#userName').hide();
		
		// jesli jakas kratka jest zazaczona to wyswietlamy w menu czyszczenie zaznaczenia	
		if($('.selected').length > 0 ){  menuPodreczne.find('li[data-grupa=selected]').show(); wyswietlam = 1;}
		if($('.event-zaznaczony').length > 0){ menuPodreczne.find('li[data-grupa=selectedEvent]').show(); wyswietlam = 1; }
		if($('.event-zaznaczony').hasClass('projekt')) {  menuPodreczne.find('li[data-grupa=zamowienie]').show(); wyswietlam = 1; }
		if($('.event-zaznaczony').hasClass('projekt-grupy')) {  menuPodreczne.find('li[data-grupa=projekt-grupy]').show(); wyswietlam = 1; }
		if( $('.event-zaznaczony[data-wykonany=0]').length ) { menuPodreczne.find('li[data-grupa=wykonajEvent]').show(); wyswietlam = 1; }else{ menuPodreczne.find('li[data-grupa=wykonajEvent]').hide();  }
		if($('.selected').length > 0)
		{	
			if($('.selected').hasClass('cal-team-data'))
			{
				menuPodreczne.find('li.eTeam[data-grupa=event]').show();
			}
			if($('.selected').hasClass('cal-data-user'))
			{
				menuPodreczne.find('li.eUser[data-grupa=event]').show();
			}
			wyswietlam = 1;
		}
		
		if($('.zaznaczonyPracownik').length)
		{
			$('#userName').text($('.zaznaczonyPracownik').attr('alt'));
			$('#userName').show();
			
			menuPodreczne.find('li[data-grupa=pusty]').hide();
			//menuPodreczne.find('li[data-grupa=selectedEvent]').hide();
			menuPodreczne.find('li[data-grupa=selected]').hide();
			menuPodreczne.find('li[data-grupa=event]').hide();
			menuPodreczne.find('li.wypelniony').hide();
			$('li.eUser').show();
		}
		
		if(obiekt.hasClass('pracownik'))
		{
			var idPracownika = e.currentTarget.getAttribute('rel').replace('comm-', '');
			$('.pracownikMenu').attr('data-pracownik', idPracownika);
			$('.pracownikMenu').show();
		}
		else
		{
			$('.pracownikMenu').hide();
		}
		
		if(obiekt.children('.icon-time').length) { menuPodreczne.find('li[data-grupa=powiadomienie]').show(); wyswietlam = 1;}
			
		var mouseX = e.pageX-40;
		var mouseY = e.pageY-90;
		var koniecStrony = $('#content').offset().left + $('#content').width() - 200;
		if(koniecStrony < mouseX)
		{
			mouseX = mouseX - 200;
		}
	
		menuPodreczne.css('left', mouseX);
		menuPodreczne.css('top', mouseY);
		
		if(!wyswietlam)
			menuPodreczne.find('li[data-grupa=pusty]').show();

		menuPodreczne.show(100);
	}
	
	function podgladZamowienia(idZamowienia){	modalAjax("{{$urlPodgladZamowienia}}"+'&id='+idZamowienia); $('.close-menu').click(); return false; 	}
	
	function menuKopiujKlonuj(e)
	{
		var menuKopiujKlonuj = $('#menuCopy');
		
		var mouseX = e.pageX-40;
		var mouseY = e.pageY-90;
		menuKopiujKlonuj.css('left', mouseX);
		menuKopiujKlonuj.css('top', mouseY);
		menuKopiujKlonuj.show(300);
	}
	
	/* koniec menu podreczne */
	function kopiujEvent()
	{
		ajax("{{$urlPrzeniesEvent}}" , potwierdzPrzeniesEvent,  przeniesEventTemp , 'POST', 'json' );
	}
	
	function klonujEvent()
	{
		ajax("{{$urlKlonujEvent}}" , potwierdzKlonujEvent,  przeniesEventTemp , 'POST', 'json' );
	}
	
	function potwierdzPrzeniesEvent(dane)
	{
		if(dane.blad > 0){
			alertModal('Error!', dane.komunikat); 
			$('#menuCopy').hide();
			return false; 
		}
		$('#event_'+dane.idEvent).attr('data-team', dane.idTeam).attr('data-data', dane.dataNowa);
		$('#menuCopy').hide();
		rozmiescEventyWPolu(przeniesEventTemp.idStaryTeam, przeniesEventTemp.dataStara);
		
		var grupaProjektow = $('.grupaZamowien[data-team='+przeniesEventTemp.idStaryTeam+']');
		if(grupaProjektow.length)
		{
			var projektTekst = grupaProjektow.find('.tytulEvent strong');
			projektTekst.text('x '+(parseInt(projektTekst.text().replace('x', ''))-1));
			console.log(grupaProjektow.attr('data-ids').replace(przeniesEventTemp.idEvent+',', '').replace(','+przeniesEventTemp.idEvent, ''));
			grupaProjektow.attr('data-ids', grupaProjektow.attr('data-ids').replace(przeniesEventTemp.idEvent+',', '').replace(','+przeniesEventTemp.idEvent, '') );
		}
		przeniesEventTemp = [];
		
		if(dane.komunikatUruchomEvent) 
		{
			var txt = dane.komunikatUruchomEventTxt+'<br/>';
			var ids = [];
			$.each(dane.eventyDoUruchomienia, function(i, event){
				ids.push(event.id);
				txt = txt+' '+event.name+'<br/> ';
			});
			var joinIds = ids.join('|');
			potwierdzenieModal1(txt, 'Confirm', 'wykonajWydarzenia(\''+joinIds+'\')' ); 
		}
		 
	}
	
	function potwierdzKlonujEvent(dane)
	{
		if(dane.blad > 0){
			alertModal('Error!', dane.komunikat); 
			$('#menuCopy').hide();
			return false; 
		}
		var nowyEvent = $('.event[data-id='+dane.idEvent+'][data-team='+przeniesEventTemp.idStaryTeam+']').clone();
		nowyEvent.attr('id', 'event_'+dane.idEventNowy).attr('data-team', dane.idTeam).attr('data-data', dane.dataNowa).attr('data-id', dane.idEventNowy);
		$('#listaEventow').append(nowyEvent);
		
		var staryEvent = $('.event[data-id='+dane.idEvent+'][data-team='+przeniesEventTemp.idStaryTeam+']');
		staryEvent.attr('data-team', przeniesEventTemp.idStaryTeam).attr('data-data', przeniesEventTemp.dataStara);
		$('#listaEventow').append(staryEvent);
		
		
		umiescEvent(nowyEvent);
		umiescEvent(staryEvent);
		rozmiescEventyWPolu(przeniesEventTemp.idStaryTeam, przeniesEventTemp.dataStara);
		$('.event-zaznaczony').removeClass('event-zaznaczony');
		//rozmiescEventyWPolu(przeniesEventTemp.idStaryTeam, przeniesEventTemp.dataStara);
		$('#menuCopy').hide();
		przeniesEventTemp = [];
		
		if(dane.komunikatUruchomEvent) 
		{
			var txt = dane.komunikatUruchomEventTxt+'<br/>';
			var ids = [];
			$.each(dane.eventyDoUruchomienia, function(i, event){
				ids.push(event.id);
				txt = txt+' '+event.name+'<br/> ';
				$('#event_'+event.id).not('.project').attr('data-wykonany', 0);
			});
			var joinIds = ids.join('|');
			potwierdzenieModal1(txt, 'Confirm', 'wykonajWydarzenia(\''+joinIds+'\')' ); 
		}
		 
	}
	
	function wykonajWydarzenia(ids)
	{
		var dane = {
			ids: ids.split('|'),
		};
		ajax("{{$urlWykonajWydarzenie}}", potwierdzWykonajWydarzenia, dane, 'POST', 'json');
	}

	function potwierdzWykonajWydarzenia(dane)
	{
		if(dane.blad > 0) alertModal('Error', dane.bladTxt);
		$.each(dane.ids, function(i, id){
			$('.event:not(.projekt)[data-id='+id+']').attr('data-wykonany', 1);
		});
		$('#usunPotwierdzenie').find('.close').click();
	}
	
	function cancelMoveEvent()
	{
		umiescEvent($('.event[data-id='+przeniesEventTemp.idEvent+'][data-team='+przeniesEventTemp.idStaryTeam+']'));
		przeliczSzerokoscTeamu(przeniesEventTemp.idStaryTeam);
		przeliczSzerokoscTeamu(przeniesEventTemp.idTeam);
		$('#menuCopy').hide();
		 
	}
	
	/* obsługa eventow */
	/*(
	 * 
	 * @param {type} typ - typ wybranego eventu np dayOff
	 * @param {type} eTyp - rodzaj eventu czy dla teamu czy dla usera
	 * @returns {Boolean}
	 */
	function dodajEvent(typ)
	{
		if(!czyZaznaczony()) return false;
		var tab = pobierzZaznaczone();
		
		modalAjax("{{$urlDodajEvent}}"+'&typ='+typ+'&eTyp='+tab.eTyp, {width: 1200, height: 1000}, 'POST', tab);
		$('.close-menu').click();
	}
/* koniec obsluga eventow */
	
	function pobierzZaznaczoneTeamy()
	{
		var ids = [];
		$('.teamZaznaczony').each(function(){
			ids.push($(this).attr('data-team'));
		});
		return ids;
	}
	
	function zwinRozwinTeamWiecej(teamBox)
	{
		var wypelnienie = teamBox.parent('.wypelnienie');
		if(wypelnienie.find('.wiecejInfoTeam').is(':visible'))
		{
			wypelnienie.find('.wiecejInfoTeam').hide();
			wypelnienie.children('.team-wiecej').html('&or;');
		}
		else
		{
			wypelnienie.children('.team-wiecej').html('&and;');
			wypelnienie.find('.wiecejInfoTeam').show();
		}
	}
	
	function rozmiescEventy()
	{
		$('#listaEventow').children('.event').each(function(){
			umiescEvent($(this));
		});
	}
	
	function ustawSzerokoscTh()
	{
		$('.cal-team').each(function(){
			$(this).css('min-width', $(this).width());
			$(this).children('.wypelnienie').css('min-width', $(this).width());
			przeliczSzerokoscTeamu($(this).attr('data-team'));
		});
	}
	
	function klonujNaglowek()
	{
		if(typeof naglowek !== 'undefined')
			naglowek.remove();

		naglowek = $('#cal-tabela thead').clone();
		naglowek.addClass('klonNaglowek');
		naglowek.find('.pusty').css('height', 'auto');
		naglowek.find('img').remove();
		naglowek.find('.team-wiecej').remove();
		naglowek.find('.cal-team-zdjecia').remove();
		naglowek.find('.cal-team').css('height', '50px');
		naglowek.find('.cal-grupa').children('.grupa-menu').remove();
		naglowek.find('.rozwin-grupe').remove();
		naglowek.find('.wypelnienie').css('height', 'auto');
		$('.cal-team').each( function(i,v){
			if($(v).attr('data-team'))
				naglowek.find('.cal-team[data-team='+$(v).attr('data-team')+']').css('min-width', $(v).width());
			else
				naglowek.find('.cal-team[data-grupa='+$(v).attr('data-grupa')+']').css('min-width', $(v).width());
		 });
		 
		$('#cal-tabela').append(naglowek);
		naglowek.hide();
	}
	
	function scrollTeamHead()
	{
		if($('#cal-tabela').offset().top < $(window).scrollTop() && !naglowek.hasClass('moveHead'))
		{
			klonujNaglowek();
			var teamRozszezony = naglowek.find('.uzytkownicyTeamuLista');
			if(teamRozszezony.length > 0)
			{
				naglowek.find('.cal-team-bil').hide();
				naglowek.find('.icon-truck').hide();
			}
				
			naglowek.addClass('moveHead');
			naglowek.show();
		}
		if(naglowek.hasClass('moveHead'))
		{
			naglowek.css('top', $(window).scrollTop() - 270);
		}
		var pozycja = 315;
		if(parseInt($(window).scrollTop()) < pozycja && naglowek.hasClass('moveHead'))
		{
			naglowek.removeClass('moveHead');
			naglowek.find('.cal-team-bil').show();
			naglowek.find('.icon-truck').show();
			naglowek.hide();
		}
	}
	
	function setSortableUser()
	{
		$('.cal-team-zdjecia, .wiecejInfoTeam').sortable({
			items : ".imgPracownik",
			connectWith: '.cal-team-zdjecia' ,
			cursor: "move",
			scrollSpeed: 40,
			tolerance: "intersect",
			placeholder: "placeholder",
			zIndex: 9999,
			start: function( event, ui ){ 
				if(!ui.item.parents('#listaPracownikow').length)
				{
					$('#kosz').css('opacity', '1');
				}
				wylaczZaznaczanie(true); 
					
				},
			stop: function( event, ui ){ wlaczZaznaczanie(); 
					$('#kosz').css('opacity', '0');
				 },
			update: function(event, ui) {
				
				var idUzytkownika = ui.item.attr('data-id'); 
				var staryTeam = null;
				if(ui.sender != null)
				{
					staryTeam = ui.sender.parents('.cal-team').attr('data-team');
					if(typeof staryTeam == 'undefined')
					{
						staryTeam = ui.sender.attr('data-team');
					}
				}
				
				var nowyTeam = ui.item.parents('.cal-team').attr('data-team');
				
				if(nowyTeam > 0 && (nowyTeam == staryTeam))
					return false;
				
				if(staryTeam != null)
				{
					sortUserTemp = {
						staryTeam: staryTeam,
						nowyTeam: nowyTeam,
						idUzytkownika: idUzytkownika,
					};
					if(event.target.id == "kosz")
					{
						potwierdzenieModal2('Are you sure you want to remove this Worker from Team ?', 'Confirm', 'usunWorker()', 'anulujZamianaWTeamie()' );
						return false;
					}
					else if( staryTeam == 'kosz')
					{
						var dane = {
							staryTeam: null,
							nowyTeam: nowyTeam,
							idUzytkownika: idUzytkownika,
						}
						ajax("{{$urlEdytujTeam}}", potwierdzEdytujGrupe, dane , 'POST', 'json' );
					}
					else
					{
						var dane = {
							staryTeam: staryTeam,
							nowyTeam: nowyTeam,
							idUzytkownika: idUzytkownika,
						}
						ajax("{{$urlEdytujTeam}}", potwierdzEdytujGrupe, dane , 'POST', 'json' );
					}
				}
				
			}
	  });
	}
	
	function usunWorker()
	{
		var dane = {
							staryTeam: sortUserTemp.staryTeam,
							nowyTeam: null,
							idUzytkownika: sortUserTemp.idUzytkownika,
						}
		ajax("{{$urlEdytujTeam}}", potwierdzEdytujGrupe, dane , 'POST', 'json' );
	}
	
	function potwierdzEdytujGrupe(dane)
	{
		if(dane.potwierdz)
		{
			potwierdzenieModal2( dane.komunikatPotwierdz, 'Confirm', 'potwierdzenieZmianWTeamie(\''+dane.linkPotwierdz+'\')', 'anulujZamianaWTeamie()' );
			return false;
		}
		else
		{
			var wiecej = '<div class="team-wiecej" style="">∨</div>';
			var staryTeamKontener = $('.cal-team[data-team='+sortUserTemp.staryTeam+']');
			var nowyTeamKontener = $('.cal-team[data-team='+sortUserTemp.nowyTeam+']');
			var zmieniam = 0;
			if(typeof staryTeamKontener != 'undefined')
			{
				var pracownicyUkryciKontener = staryTeamKontener.find('.wiecejInfoTeam');
				var pracownicyWidoczniKontener = staryTeamKontener.find('.cal-team-zdjecia');
				
				if( (staryTeamKontener.find('.imgPracownik').length - 1) <= 2)
				{
					staryTeamKontener.find('.wypelnienie').removeClass('wypelnienie-rozwin');
					staryTeamKontener.find('.team-wiecej').remove();
				}
				
				if(pracownicyWidoczniKontener.children('.imgPracownik').length < 2)
				{
					var pracownikdDoPrzeniesienia = pracownicyUkryciKontener.children('.imgPracownik').first();
					pracownicyWidoczniKontener.append(pracownikdDoPrzeniesienia);
				}
				zmieniam = 1;
			}
			if(typeof nowyTeamKontener != 'undefined')
			{
				if( nowyTeamKontener.find('.imgPracownik').length > 2)
				{
					nowyTeamKontener.find('.wiecejInfoTeam ').append($('.imgPracownik[data-id='+sortUserTemp.idUzytkownika+']'));

					if(!nowyTeamKontener.find('.team-wiecej').length)
						nowyTeamKontener.find('.wypelnienie').append(wiecej);
				}
				zmieniam = 1;
			}
			sortUserTemp = {};
			
			
			$('#kosz').find('.imgPracownik[data-id='+dane.idUzytkownika+']').appendTo('#listaPracownikow');
			$('#usunPotwierdzenie').find('.close').click();
			
		}
	}
	
	function anulujZamianaWTeamie()
	{
		if(sortUserTemp.staryTeam > 0)
		{
			$('.imgPracownik[data-id='+sortUserTemp.idUzytkownika+']').appendTo(
						$('.cal-team[data-team='+sortUserTemp.staryTeam+']').find('.cal-team-zdjecia')
				  );
		}
		else
		{
			$('.imgPracownik[data-id='+sortUserTemp.idUzytkownika+']').appendTo($('#listaPracownikow'));
		}
	}
	
	function potwierdzenieZmianWTeamie(link)
	{
		 
		ajax("'"+link+"'", potwierdzEdytujGrupe, {} , 'POST', 'json' );
		 
		$('.modal-header').children('.close').click();
	}
	
	function setSortableEvent(items)
	{
		$('.sortable').sortable({
			//items : ".event:not(.nie-przenos)",
			items: items,
			connectWith: '.sortable' ,
			cursor: "move",
			scrollSpeed: 40,
			tolerance: "intersect",
			placeholder: "placeholder",
			zIndex: 9999,
			start: function( event, ui ){
					wylaczZaznaczanie(true); 
					$('#koszEvent').css('opacity', '1');
				},
			stop: function( event, ui ){
					wlaczZaznaczanie(); $('#koszEvent').css('opacity', '0');
				 },
			update: function( event, ui ) {
				var oldTeam = ui.item.attr('data-team');
				var oldData = ui.item.attr('data-data');
				
				var left = (( event.target.children.length - 1 ) * 30 ) + 3;
				var target = ui.item.parent('.cal-team-data');
				var idTeam = target.attr('data-team');
				var newData = ui.item.parent('td').attr('data-data');
				
				if(oldTeam == idTeam && oldData == newData)
					return false;

				ui.item.css('left', left );
				
				var oldData = ui.item.attr('data-data');
				var oldTeam = ui.item.attr('data-team');
				var newData = ui.item.parent('td').attr('data-data');
				var newTeam = ui.item.parent('td').attr('data-team');
				
				var id = ui.item.attr('data-id');
				var idEvent = ui.item.attr('data-id');
				var dni = ui.item.attr('data-dni');
				
				przeliczSzerokoscTeamu(newTeam);
				
				if(ui.sender != null)
					przeliczSzerokoscTeamu(oldTeam);
				
				var projekt = 0;
				if(ui.item.hasClass('projekt'))
					projekt = 1;
				
				przeniesEventTemp = {
					idTeam: newTeam,
					idStaryTeam: oldTeam,
					dataStara: oldData,
					dataNowa: newData,
					idEvent: idEvent,
					projekt: projekt,
					dni: dni
				}
				
				if(event.target != '')
				{
					if(event.target.id == "koszEvent")
					{
						$('#menuCopy').hide();
						potwierdzenieModal2('Are you sure you want to delete this Event ?', 'Confirm', 'usunEvent()', 'cancelMoveEvent()' );
					}
					else
						menuKopiujKlonuj(event);
				}
				
			}
	  });
	}
	
	function usunEvent()
	{
		var oddzielProjekt = [];
		if(przeniesEventTemp.projekt)
			var oddzielProjekt = [{ idTeam: przeniesEventTemp.idStaryTeam, idProjekt: przeniesEventTemp.idEvent }];
			
		var usunPrzypisanie = [przeniesEventTemp.idEvent];
		
		ajax("{{$urlUsunPrzypisanie}}" , potwierdzUsunPrzypisanie, { usun: usunPrzypisanie, usunProjekt: oddzielProjekt }, 'POST', 'json' );
		
	}
	
	function rozmiescEventyWPolu(idTeam, data)
	{
		var i = 0;
		var listaEventow = $('.cal-team-data[data-team='+idTeam+'][data-data='+data+']').children('.event');
		if(listaEventow.length)
		{
			listaEventow.each(function(){
				var left = ( i * 30 ) + 3;
				i++;
				$(this).css('left', left );
			});
		}
	}
	
	function przeliczSzerokoscTeamu(id, grupa)
	{
		var grupa = grupa|false;
		
		var max = 0;
		if(grupa)
			var lista = $('.cal-team-data[data-grupa='+id+']')
		else
			var lista = $('.cal-team-data[data-team='+id+']')
		
		lista.each(function(){
			var ilosc = $(this).children('.event').length;
			(ilosc > max) ? max = ilosc : null;
		});
		
		var left = (max == 0) ? 20 : (( max ) * 30 ) + 3;
		left = left +30;
		if(grupa)
		{
			var grupaKontener = $('.cal-team[data-grupa='+id+']');
			grupaKontener.css('min-width', left);
			grupaKontener.children('.wypelnienie').css('min-width', left);
		}
		else
		{
			var teamKontener = $('.cal-team[data-team='+id+']');
			teamKontener.css('min-width', left);
			teamKontener.children('.wypelnienie').css('min-width', left);
		}
	}
	
	function ustawWysokoscEventu(event)
	{
		var dni = event.attr('data-dni');
		// 180 tyle wynosi wysokosc jednego dnia w kalendarzu +1 obramowanie
		if(dni > 1)
			event.css('height', (parseInt(dni * 181) - 30 ));
		else
			event.css('height', 154 );
	}
	
	function umiescEvent(event, wymusTeam)
	{
		if(event.hasClass('ukryty') || event.hasClass('pomin')) return;
		
		var wymusTeam = wymusTeam|0;
		
		var team = event.attr('data-team');
		var grupa = event.attr('data-grupa');
		var data = event.attr('data-data');
		
		var dataUser = event.attr('data-user');
		var dataTeam = $();
		if(team > 0)
			var dataTeam = $('.cal-team-data[data-team='+team+'][data-data='+data+']');
		
		var idEventProjekt = event.attr('data-event');
		
		if(dataTeam.length) // eventy przypisane do teamu
		{
			// 30 px tyle wynosi szerokosc eventu + 3 lewy margines
			var left = (dataTeam.children().length * 30 ) + 3;
			event.css('left', left ); 
			dataTeam.append(event);
			
			if(dataUser && $('.zaznaczonyPracownik').length)
				event.removeClass('nie-przenos');
			
			przeliczSzerokoscTeamu(team);
			ustawWysokoscEventu(event);
			event.show(); 
		}
		// eventy wyswietlane na grupie
		else if(grupa != '' && wymusTeam == 0 && typeof(grupa) != 'undefined')
		{
			var dataGroup = $('.cal-team-data[data-grupa='+grupa+'][data-data='+data+']');
			if(dataGroup.length)
			{
				var left = (dataGroup.children().length * 30 ) + 3;
				event.css('left', left );
				dataGroup.append(event);
				przeliczSzerokoscTeamu(grupa, true);
				ustawWysokoscEventu(event);
				event.show();
			}
		}
		else
		{
		}
		if(idEventProjekt > 0)
		{
			var eventProjektu = $('#event_'+idEventProjekt+':not(.projekt)');
			var data = eventProjektu.attr('data-data');
			var pozycjaTop = $('.cal-team-data[data-data='+data+']').position().top-145;
			eventProjektu.addClass('pomin').addClass('nie-przenos');
			eventProjektu.appendTo(event);
			eventProjektu.css('left', -3 );
			event.addClass('nie-przenos');
			eventProjektu.css('top', pozycjaTop);
			ustawWysokoscEventu(eventProjektu);
			eventProjektu.show(); 
		}
	}
	
	function czyZaznaczony(){ if($('.selected').length > 0){ return true; }else{ alertModal('Notice', '{{$nieZaznaczonoDatyKomunikat}}'); return false; } }
	
	function wylaczZaznaczanie(czysc)
	{
		czysc = czysc|false;
		
		if(czysc)
			$('#czyscZaznaczenie').click();
			
		$(document).off('mousedown mouseover',".zezwolZaznacz");
	}
	
	function wlaczZaznaczanie()
	{
		$(document).on('mousedown mouseover',".zezwolZaznacz", function (e) { selectDay( $(this) , e); return false; });
	}
	
	function scrollDoGory()
	{
		var pozycja = 500;
		if(pozycja < $(window).scrollTop())	$('#do-gory').show(500);
		if(parseInt($(window).scrollTop()) < pozycja ) $('#do-gory').hide(500);
	}
	
	function pobierzZaznaczone()
	{
		eTyp = ($('.zaznaczonyPracownik').length) ? 'eUser' : 'eTeam';
		var dataTeam = {};
		var godzina = null;
			
		if(eTyp == 'eUser')
		{
			var $idUser = $('.zaznaczonyPracownik').attr('rel').replace('comm-', '');
			$('.selected').each(function()
			{
				var $data = $(this).attr('data-data');

				if (!dataTeam[$idUser]) dataTeam[$idUser] = {};
				if (!dataTeam[$idUser][$data]) dataTeam[$idUser][$data] = { istnieje: true };
			});
		}
		else if(eTyp == 'eTeam')
		{
			$('.selected').each(function()
			{
				var $team = $(this).attr('data-team');
				var $data = $(this).attr('data-data');

				if (!dataTeam[$team]) dataTeam[$team] = {};
				if (!dataTeam[$team][$data]) dataTeam[$team][$data] = { istnieje: true };
			});
		}

		return {
			dataTeam: dataTeam,
			eTyp: eTyp,
		};
	}
	
	function kolorPrzycisk(obiekt, kolorDomyslny)
	{
		obiekt.spectrum({
			color: kolorDomyslny,
			showInput: true,
			className: "full-spectrum",
			showInitial: true,
			showPalette: true,
			showSelectionPalette: true,
			maxSelectionSize: 10,
			preferredFormat: "hex",
			localStorageKey: "spectrum.demo",
			palette: [
				 ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)",
				 "rgb(204, 204, 204)", "rgb(217, 217, 217)","rgb(255, 255, 255)"],
				 ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
				 "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"], 
				 ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)", 
				 "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)", 
				 "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)", 
				 "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)", 
				 "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)", 
				 "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
				 "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
				 "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
				 "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)", 
				 "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
			]
	  });
	}
	
	function zmienKolor(typ)
	{
		if($('.event-zaznaczony').length == 0) return false;
		var ids = [];
		var projekts = [];
		
		if(typ == 'czcionka')
		{
			var kolor = $('#kolorCzcionki').val();
			$.each($('.event-zaznaczony'), function(index, event){
				if($(this).hasClass('projekt'))
					projekts.push($(this).attr('data-id'));
				else
					ids.push( $(this).attr('data-id'));
				
				$(this).css('color', kolor);
			});
		}
		else if(typ == 'tlo')
		{
			var kolor = $('#kolorTla').val();
			$.each($('.event-zaznaczony'), function(index, event){
				if($(this).hasClass('projekt'))
					projekts.push($(this).attr('data-id'));
				else
					ids.push( $(this).attr('data-id'));
				
				$(this).css('background-color', $('#kolorTla').val());
			});
		}
		
		var dane = {
			ids: ids,
			kolor: kolor,
			typ: typ,
			projekts: projekts,
		};
		ajax("{{$urlZmienKolor}}" , potwierdzZmienKolor,  dane , 'POST', 'json' );
	}
	
	function potwierdzZmienKolor(dane)
	{
		if(dane.blad > 0)	alertModal('Error!', dane.komunikat);
	}
	
	function usunPrzypisanie()
	{
		$('.modal-header').find('.close').click();
		
		var usunPrzypisanie = [];
		var oddzielProjekt = [];
		if($('.event-zaznaczony').length)
		{
			$('.event-zaznaczony').each(function(){
				var id = $(this).attr('data-id');
				if($(this).hasClass('projekt'))
				{
					var idTeam = $(this).parent('.cal-team-data').attr('data-team');
					oddzielProjekt.push({
						idTeam: idTeam,
						idProjekt: id
					});
					
				}
				else
				{
					usunPrzypisanie.push(id);
				}
			});
			ajax("{{$urlUsunPrzypisanie}}" , potwierdzUsunPrzypisanie, { usun: usunPrzypisanie, usunProjekt: oddzielProjekt }, 'POST', 'json' );
		}
	}
	
	function potwierdzUsunPrzypisanie(dane)
	{
		if(dane.blad > 0)	alertModal('Error!', dane.error);
		
		var teamArray = [];
		var teamData = [];
		
		if(dane.usuniete.length)
		{
			$.each(dane.usuniete, function(index, value){
				var event = $('.event[data-id='+value+']');
				var team = event.attr('data-team');
				var data = event.attr('data-data');

				teamArray.push(team);
				( typeof teamData[team] == 'undefined' ) ? teamData[team] = [] : '';
				teamData[team] = data;
				event.remove();
			});
		}
		
		if(dane.usunieteProjekty.length)
		{
			$.each(dane.usunieteProjekty, function(index, values){
				var event = $('.event[data-id='+values.idZamowienie+'][data-team='+values.idTeam+']');
				if(event.hasClass('projekt'))
				{
					var data = event.attr('data-data');
					teamArray.push(values.idTeam);
					( typeof teamData[values.idTeam] == 'undefined' ) ? teamData[values.idTeam] = [] : '';
					teamData[values.idTeam] = data;
					event.remove();
				}
			});
		}
		
		$.each(teamData, function(index, value){ if(typeof value != 'undefined'){ rozmiescEventyWPolu(index, value);	} } );
		// for(var i = 0 ; i < teamArray.length ; i++) przeliczSzerokoscTeamu(teamArray[i]);
		
		$('#usunPotwierdzenie').find('.close').click();
	}
	
	/*
	function odswiezDane()
	{
		ladujPreloader();
		var odswiez = ajax('{{$odswierzKalendarzUrl}}', potwierdzOdswiezDane, {} , 'POST', 'json' );
		
			$.when(
				odswiez
			)
		.done(function() 
		{
			setTimeout(function(){
			initPage();
				}, 1000 );
			 
		 });
	}
	
	function potwierdzOdswiezDane(dane)
	{
		
		$('#kalendarzSlim').html('');
		$('#kalendarzSlim').append(dane.html);
		$('.modal-header').children('.close').click();
		
		
	}
	*/
	
	function ustawZmianyIstnieja()
	{
		zaminyIstnieja = 1;
		$('#runButton').show();
	}
	
</script>
	
	<div id="stworzGrupe" >
		<a class="close closeStworzGrupe" href="#" data-dismiss="alert">×</a>
		<input type="text" placeholder="{{$ustawNazweGrupyPlaceholder}}" name="nawaGrupy" id="nazwaGrupy" style="background-color:#fff;" /><button class="btn btn-primary" id="zapiszGrupe" value="Save"  style="margin-top:-8px;" ><i class="icon icon-save"></i></button>
	</div>
	
	<a href="{{$urlKalendarzPracownika}}" id="widokPracownikow" class="label label-warning small"><i class="icon icon-group"></i> Users view</a>
	
	<a href="#" id="sortujTeam" class="label label-info small"><i class="icon icon-list"></i> {{$sortujTeamEtykieta}}</a>
	<div id="listaPracownikowPrzycisk" class="label label-info small" >
		<i class="icon icon-list"></i> Workers list
	</div>
	<div id="listaPracownikow" class="cal-team-zdjecia" data-team="kosz">
		{{BEGIN workerList}}
			<div class="imgPracownik" data-id="{{$id}}">
				<img class="tip top-left pracownik margin " src="{{$zdjecie}}" style="cursor: pointer;" alt="{{$imie}} {{$nazwisko}}" data-original-title="{{$imie}} {{$nazwisko}}" rel="comm-{{$id}}">
			</div>
		{{END workerList}}
	</div>
	
	<div id="kosz" class="cal-team-zdjecia kosz" >
		<i class="icon icon-trash"></i>
	</div>
	<div id="koszEvent" class="sortable kosz" >
		<i class="icon icon-trash"></i>
	</div>
	
	<div id="datyKalendarza">
		{{$formularzDaty}}
	</div>
	<div id='kalendarz_szerokosc'>
	<div id="kalendarzSlim">
		{{BEGIN kalendarz}}
		<table id="cal-tabela" class="table table-bordered table-bordered-strong" style="">
			<thead>
				<tr>
					<th class="pusty" ></th>
					{{BEGIN team}}
					<th class="cal-team " data-team="{{$idTeam}}" style="display: table-cell;" >
						
						<div class="wypelnienie">
							<div class="cal-team-kontener">
								<span><span class="logowanieInfo {{$niezalogowany}}" title="{{$niezalogowanyTitle}}" ></span> {{$nazwa}}</span>
								<div class="cal-team-zdjecia">
									{{BEGIN pracownik}}
									<div class="imgPracownik" data-id="{{$id}}" >
										<img class="tip top-left pracownik margin {{IF $lider}} lider {{END IF}}" src="{{$zdjecie}}" style="cursor: pointer;" alt="{{$imie}} {{$nazwisko}}" data-original-title="{{$imie}} {{$nazwisko}}" rel="comm-{{$id}}" ><br/>
									</div>
									{{END pracownik}}
								</div>
								<div class="wiecejInfoTeam" style="display:none;">
									{{BEGIN pracownikUkryty}}
									<div class="imgPracownik" data-id="{{$id}}" >
										<img class="tip top-left pracownik margin {{IF $lider}} lider {{END IF}}" src="{{$zdjecie}}" style="cursor: pointer;" alt="{{$imie}} {{$nazwisko}}" data-original-title="{{$imie}} {{$nazwisko}}" rel="comm-{{$id}}" ><br/>
									</div>
									{{END}}
								</div>
							</div>
							{{BEGIN wiecej}}
							<div style="" class="team-wiecej" >&or;</div>
							{{END}}
						</div>
					</th>
					{{END team}}
					{{BEGIN grupa}}
					<th class="cal-team cal-grupa nieZaznaczaj" data-grupa="{{$idGrupa}}"  style="display: table-cell;" >
						<div class="grupa-menu">
							<a class="close usunGrupe fR" title="Delete group" > <i class="icon icon-remove"></i> </a>
							<a class="close edytujGrupe fR" id="edytujGrupe"   title="Edit group" ><i class="icon icon-pencil"></i></a>
						</div>
						<div class="wypelnienie" >
							<div class="cal-team-kontener">
								<span class="pokazBilGrupa grupa" data-grupa="{{$idGrupa}}" >{{$nazwaGrupy}}</span><br/>
								<div class="cal-team-zdjecia">
									{{BEGIN bil}}
									<div class="cal-team-grupa" data-team="{{$teamId}}">
										<i class="icon icon-resize-full grupaSzczegolyTeamu " data-team="{{$teamId}}"></i> <span class="logowanieInfo smallLogowanie {{$niezalogowany}}" title="{{$niezalogowanyTitle}}" ></span> <span class="pokazBilGrupa {{$teamNazwa}}" data-team="{{$teamId}}">{{$teamNazwa}} </span><br/>
									</div>
									{{END}}
									<div class="wiecejInfoTeam" style="display:none;">
										{{BEGIN bilUkryty}}
										<div class="cal-team-grupa" data-team="{{$teamId}}">
											<i class="icon icon-resize-full grupaSzczegolyTeamu" data-team="{{$teamId}}"></i> <span class="logowanieInfo smallLogowanie {{$niezalogowany}}" title="{{$niezalogowanyTitle}}" ></span> <span class="pokazBilGrupa {{$teamNazwa}}" data-team="{{$teamId}}" >{{$teamNazwa}}</span><br/>
										</div>
										{{END}}
									</div>
								</div>
							</div>
							{{BEGIN wiecej}}
							<div class="team-wiecej" >&or;</div>
							{{END}}
						</div>
					</th>
					{{END}}
				</tr>
			</thead>
			<tbody>
				{{BEGIN data}}
				<tr id="row-count-0" class="cal-row">
					<th class="cal-data">
						{{$dataTydzien}}
					</th>
					{{BEGIN dataTeam}}
					<td class="cal-team-data sortable zezwolZaznacz {{$bgColor}}" data-team="{{$idTeam}}" data-data="{{$data}}">

					</td>
					{{END dataTeam}}
					{{BEGIN dataGroup}}
					<td data-team="{{$idGrupa}}" data-grupa="{{$idGrupa}}" data-data="{{$data}}" class="cal-team-data cal-grupa-data {{$bgColor}}">
					</td>
					{{END}}
				</tr>
				{{END data}}
			</tbody>
		</table>
		<div id="listaEventow">
			{{BEGIN zamowienie}}
				<div class="event tekstWPionie1 {{IF $zalogowany}}nie-przenos nie-rozszezaj{{END}} projekt {{$class}} {{IF $class == 'ukryty'}}projekt-grupy{{END IF}} " id="event_{{$id}}" data-id="{{$id}}" data-event="{{$id_event}}" data-dni="{{$iloscDni}}" data-data="{{$data}}" data-team="{{$idTeam}}" data-grupa="{{$grupa}}" style="background-color: {{$bgColor}}; color:{{$kolorCzcionki}}" title="{{$title}}" >
					{{IF $zalogowany}}<span class="zalogowanyEvent" ></span>{{END IF}}
					{{IF $teamName}} [ <strong> {{$teamName}} </strong> ]{{END}}
					<span class="tytulEvent">{{$nazwa}}</span>
				</div>
			{{END}}
			{{BEGIN zamowienieGrupa}}
				<div class="event tekstWPionie1 nie-przenos nie-rozszezaj grupaZamowien nie-zaznaczaj" id="event_{{$id}}" data-id="{{$id}}" style="background-color: {{$bgColor}}; color:{{$kolorCzcionki}}" data-dni="{{$iloscDni}}" data-data="{{$data}}" data-team="{{$idTeam}}" data-grupa="{{$grupa}}" title="{{$title}}" >
					<span class="tytulEvent">{{$nazwa}}</span>
				</div>
			{{END}}
			{{BEGIN projektyGrupa}}
				<div class="event tekstWPionie1 nie-przenos nie-rozszezaj grupaZamowien nie-zaznaczaj" data-ids="{{$idsProjektow}}" style="background-color: {{$bgColor}}; color:{{$kolorCzcionki}}" data-dni="{{$iloscDni}}" data-data="{{$data}}" data-team="{{$idTeam}}" title="{{$title}}" >
					<div class="label label-info small nopadding">
						<i class="icon icon-plus rozwinGrupaProjekty"></i>
					</div>
					<span class="tytulEvent">{{$nazwa}}</span>
				</div>
			{{END}}
			{{BEGIN event}}
				<div class="event tekstWPionie1 {{IF $user_id }}nie-przenos userEvent{{END IF}}" id="event_{{$id}}" data-wykonany="{{$wykonany}}" data-user="{{$user_id}}" data-id="{{$id}}" data-dni="{{$iloscDni}}" data-data="{{$data}}" data-team="{{$idTeam}}" data-grupa="{{$grupa}}" title="{{$title}}" style="background-color: {{$bgColor}}; color:{{$kolorCzcionki}}" >
					<span class="tytulEvent">{{$nazwa}}</span>
				</div>
			{{END}}
		</div>
		<div id="do-gory"></div>
		<div id="wczytaj-wiecej-kalendarz">Read more</div>
		{{END kalendarz}}
		
	</div>
	</div>
<!-- -->
<div id="teamyGrupyUkryte">
<table>
	<tr>
		{{BEGIN teamUkryty}}
			<th class="cal-team nieZaznaczaj" data-team="{{$idTeam}}"   style="display: table-cell;">
				<div class="wypelnienie">
					<div class="cal-team-kontener">
						<span class="doGrupy" data-grupa="" > << </span> | <span><span class="logowanieInfo {{$niezalogowany}}" title="{{$niezalogowanyTitle}}" ></span> {{$nazwa}}</span>
						<div class="cal-team-zdjecia">
							{{BEGIN pracownik}}
							<div class="imgPracownik" data-id="{{$id}}" >
								<img class="tip top-left pracownik margin {{IF $lider}} lider {{END IF}}" src="{{$zdjecie}}" style="cursor: pointer;" alt="{{$imie}} {{$nazwisko}}" data-original-title="{{$imie}} {{$nazwisko}}" rel="comm-{{$id}}" ><br/>
							</div>
							{{END pracownik}}
						</div>
						<div class="wiecejInfoTeam" style="display:none;">
							{{BEGIN pracownikUkryty}}
							<div class="imgPracownik" data-id="{{$id}}" >
								<img class="tip top-left pracownik margin {{IF $lider}} lider {{END IF}}" src="{{$zdjecie}}" style="cursor: pointer;" alt="{{$imie}} {{$nazwisko}}" data-original-title="{{$imie}} {{$nazwisko}}" rel="comm-{{$id}}" ><br/>
							</div>
							{{END}}
						</div>
					</div>
					{{BEGIN wiecej}}
					<div style="" class="team-wiecej" >&or;</div>
					{{END}}
				</div>
			</th>
		{{END teamUkryty}}
	</tr>
</table>

</div>
<!-- -->
<!-- menu podreczne -->	
{{BEGIN menuPodreczne}}
<div id="menuPodreczne" class="cal-team-caly" style='display: none;'>
	<a href='javascript:void(0)' class='close-menu fL'><i class="icon icon-remove"></i></a><br/>
	<ul>
		<input type="hidden" id='menuIdTeam' value='' />
		<input type="hidden" id='menuData' value='' />
		<input type="hidden" id='menuId' value='' />
		<li class="hide" id='userName'>
			
		</li>
		<!--
		<li class="hide" data-grupa="pusty" >
			{{$brak_metod_dla_menu}}
		</li>
		-->
		<li id="ukryjEventy" ><a href="javascript:void(0)" ><i class="icon icon-adjust" ></i> <span>Hide events </span></a></li>
		<li id="pokazEventy" class="hide" ><a href="javascript:void(0)" ><i class="icon icon-bullseye" ></i> <span>Show events</span></a></li>
		<li><hr/></li>
		{{BEGIN selected}}
		<li data-grupa="selected" class="hide"><a href="{{$href}}" id="{{$id}}" ><i class="icon icon-eraser" ></i> <span>{{$etykieta}}</span></a></li>
		{{END selected}}
		{{BEGIN selected-event}}
		<!-- <li data-grupa="selectedEvent" class="hide"><a href="javascript:void(0)" id="zaznaczPodobneEvent" ><i class="icon icon-bullhorn" ></i> <span>{{$menu_select_similar_event}}</span></a></li> -->
		<li data-grupa="selectedEvent"   class="hide" > Bg :<input id="kolorTla" style="display: none;" type="text">  Txt <input id="kolorCzcionki" style="display: none;" type="text"></li>
		<li data-grupa="selectedEvent"  class="hide" ><hr/></li>
		<li data-grupa="selectedEvent" class="hide" ><a href="javascript:void(0)" id="usunPrzypisanie" ><i class="icon icon-remove"></i> <span>{{$menu_remove_selected_event}}</span></a></li>
		<li data-grupa="wykonajEvent" class="hide" ><a href="javascript:void(0)" id="wykonajEvent" ><i class="icon icon-play"></i> <span>{{$menu_wykonaj_event}}</span></a></li>
		<li data-grupa="selectedEvent" class="hide" ><hr/></li>
		{{END}}
		<li data-grupa="event"  class="hide" ><a href="javascript:void(0)" class="dodajEvent" id='domyslny' ><i class="icon icon-crop" ></i> <span>{{$menu_add_event}}</span></a></li>
		{{BEGIN listaMenu}}
		<li data-grupa="event" data-typ='{{$typWyswietlania}}' class="{{$typWyswietlania}} hide" ><a href="javascript:void(0)"  class="dodajEvent" id='{{$szablonPhp}}' ><i class="icon icon-crop" ></i> <span>{{$szablonNazwa}}</span></a></li>
		{{END}}
		
		<li class="pracownikMenu hide" ><a  href="javascript:void(0)" class='ustawLidera' > <i class="icon icon-star" ></i> <span>{{$menu_ustaw_lidera}}</span>  </a></li>
		<li class="pracownikMenu hide" ><a  href="javascript:void(0)" class='zaznaczPracownika' > <i class="icon icon-bullseye" ></i> <span>{{$menu_zaznacz_pracownika}}</span>  </a></li>
		<!--
		<li data-grupa="projekt-grupy" class="hide" ><a href="javascript:void(0)" id="usunZGrupy" ><i class="icon icon-certificate"></i> <span>{{$menu_usun_z_grupy}}</span></a></li>
		-->
		<li data-grupa="zamowienie" class="hide" ><a href="javascript:void(0)" id="podgladZamowienia" ><i class="icon icon-search"></i> <span>{{$menu_show_order_details}}</span></a></li>
		<li data-grupa="notatka" class="hide" ><hr/></li>
		<li data-grupa="notatka" class="hide" ><a href="javascript:void(0)" id="podgladNotatki" ><i class="icon icon-search"></i> <span>{{$menu_show_note}}</span></a></li>
		<li data-grupa="komentarz" class="hide " ><hr/></li>
		<li data-grupa="komentarz" class="hide" ><a href="javascript:void(0)" id="podgladKomentarz" ><i class="icon icon-search"></i> <span>{{$menu_show_comment}}</span></a></li>
		<li data-grupa="komentarz" class="hide" ><a href="javascript:void(0)" id="usunKomentarz" ><i class="icon icon-remove"></i> <span>{{$menu_remove_comment}}</span></a></li>
		<li data-grupa="komentarz" class="hide" ><a href="javascript:void(0)" id="edytujKomentarz" ><i class="icon icon-pencil"></i> <span>{{$menu_edit_comment}}</span></a></li>
		<li data-grupa="komentarz" class="hide wypelniony" ><hr/></li>
		<li data-grupa="komentarz" class="hide wypelniony" ><a href="javascript:void(0)" id="dodajKomentarz" ><i class="icon icon-pencil"></i> <span>{{$menu_add_comment}}</span></a></li>
	</ul>
</div>
{{END}}
<div id="menuCopy" class="cal-team-caly" style='display: none;'>
	<ul>
		<li ><a href="javascript:void(0)" onclick="cancelMoveEvent()" id="cancelMoveEvent" ><i class="icon icon-mail-reply-all" ></i> <span>{{$menu_move_event_cancel}}</span></a></li>
		<li ><a href="javascript:void(0)" onclick="kopiujEvent()" id="kopiujEventy" ><i class="icon icon-cut" ></i> <span>{{$menu_move_event}}</span></a></li>
		<li ><a href="javascript:void(0)" onclick="klonujEvent()" id="powielEventy" ><i class="icon icon-paste" ></i> <span>{{$menu_clone_event}}</span></a></li>
	</ul>
</div>
<!-- koniec menu podreczne -->
{{END}}

{{BEGIN teamSortowanie}}
<script >
	$(document).ready(function(){
		$('#zapiszSortujTeam').on('click', function(){ zapiszSortowanie(); return false; });
		setSortableTeam();
		$('.usunTeam').on('click', function(){
			$(this).parent('.grupa-menu').hide();
			$(this).parents('.cal-team').removeClass('posortowane'); 
			$('#cal-tabela-1').find('tr').append($(this).parents('.cal-team')); 
		});
		$('#anulujSortowanie').on('click', function(){
				console.log('tutut');
				$('#oknoModalne').find('.close').click();
			});
	});
	
	function zapiszSortowanie()
	{
		var posortowany = Array();
		$('.posortowane').each(function(){
			posortowany.push($(this).attr('data-team'));
		});
		var dane = {
				ids: posortowany,
			}
		ajax("{{$urlZapiszSortowanieTeamu}}", potwierdzSortowanie , dane , 'POST', 'json');
	}
	
	function potwierdzSortowanie(dane)
	{
		if(dane.blad > 0 )
		{
			alertModal(dane.errorTxt);
		}
		else
		{
			location.reload();
		}
	}
	
	function setSortableTeam()
	{
		$('.sortMe').sortable({
				items : ".cal-team-sort",
				connectWith: ".sortMe",
				cursor: "move",
				scrollSpeed: 40,
				tolerance: "intersect",
				placeholder: "placeholder",
				zIndex: 9999,
				update: function( event, ui ) {
					if(ui.item.parents('table').attr('id') == 'cal-tabela-2')
					{
						ui.item.addClass('posortowane');
						ui.item.find('.grupa-menu').show();
					}
					if(ui.item.parents('table').attr('id') == 'cal-tabela-1')
					{
						ui.item.find('.grupa-menu').hide();
						ui.item.removeClass('posortowane'); 
					}
				}
			}
	  );
	}
	
		
</script>
	<div style="display: table; margin: 0 auto;">
	<h3 class="sortujeNaglowek" >{{$listaTeamowUsunietych}}</h3>
	<table id="cal-tabela-1" class="table table-bordered table-bordered-strong sortujTeamHead" style="">
		<thead>
			<tr class="sortMe" >
				{{BEGIN teamyUsuniete}}
					<th class="cal-team cal-team-sort nieZaznaczaj" data-team="{{$idTeam}}"  style="display: table-cell;">
						<div class="wypelnienie">
							<div class="cal-team-kontener">
								<div class="grupa-menu" style="display:none;">
									<a class="close usunTeam fR" title="Delete team">
										<i class="icon icon-remove"></i>
									</a>
								</div>
								{{$nazwa}}
								<div class="cal-team-zdjecia">
									{{BEGIN pracownik}}
									<div class="imgPracownik" data-id="{{$id}}" >
										<img class="tip top-left pracownik margin {{IF $lider}} lider {{END IF}}" src="{{$zdjecie}}" style="cursor: pointer;" alt="{{$imie}} {{$nazwisko}}" data-original-title="{{$imie}} {{$nazwisko}}" rel="comm-{{$id}}" ><br/>
									</div>
									{{END pracownik}}
								</div>
								<div class="wiecejInfoTeam" style="display:none;">
									{{BEGIN pracownikUkryty}}
									<div class="imgPracownik" data-id="{{$id}}" >
										<img class="tip top-left pracownik margin {{IF $lider}} lider {{END IF}}" src="{{$zdjecie}}" style="cursor: pointer;" alt="{{$imie}} {{$nazwisko}}" data-original-title="{{$imie}} {{$nazwisko}}" rel="comm-{{$id}}" ><br/>
									</div>
									{{END}}
								</div>
							</div>
							{{BEGIN wiecej}}
							<div style="" class="team-wiecej" >&or;</div>
							{{END}}
						</div>
					</th>
				{{END}}
			</tr>
		</thead>
	</table>
	<h3 class="sortujeNaglowek">{{$listaTwoichTeamow}}</h3>
	<table id="cal-tabela-2" class="table table-bordered table-bordered-strong sortujTeamHead" style="">
		<thead>
			<tr class="sortMe">
				{{BEGIN team}}
				<th class="cal-team cal-team-sort posortowane nieZaznaczaj" data-team="{{$idTeam}}"  style="display: table-cell;">
					<div class="wypelnienie">
						<div class="cal-team-kontener">
							<div class="grupa-menu">
								<a class="close usunTeam fR" title="Delete team">
									<i class="icon icon-remove"></i>
								</a>
							</div>
							{{$nazwa}}
							<div class="cal-team-zdjecia">
								{{BEGIN pracownik}}
								<div class="imgPracownik" data-id="{{$id}}" >
									<img class="tip top-left pracownik margin {{IF $lider}} lider {{END IF}}" src="{{$zdjecie}}" style="cursor: pointer;" alt="{{$imie}} {{$nazwisko}}" data-original-title="{{$imie}} {{$nazwisko}}" rel="comm-{{$id}}" ><br/>
								</div>
								{{END pracownik}}
							</div>
							<div class="wiecejInfoTeam" style="display:none;">
								{{BEGIN pracownikUkryty}}
								<div class="imgPracownik" data-id="{{$id}}" >
									<img class="tip top-left pracownik margin {{IF $lider}} lider {{END IF}}" src="{{$zdjecie}}" style="cursor: pointer;" alt="{{$imie}} {{$nazwisko}}" data-original-title="{{$imie}} {{$nazwisko}}" rel="comm-{{$id}}" ><br/>
								</div>
								{{END}}
							</div>
						</div>
						{{BEGIN wiecej}}
						<div style="" class="team-wiecej" >&or;</div>
						{{END}}
					</div>
				</th>
				{{END team}}
			</tr>
		</thead>
	</table>
	<div class="row" style="margin-top:5px;">
		<button id="zapiszSortujTeam" class="label label-info small" href="#">{{$zapiszSortowanieEtykieta}}</button>
		<button id="anulujSortowanie" class="label label-primary small" href="#">{{$anulujSortowanieEtykieta}}</button>
	</div>
	
	</div>
{{END}}

{{BEGIN menuPodreczne}}
<div id="menuPodreczne" class="cal-team-caly" style='display: none;'>
	<a href='javascript:void(0)' class='close-menu fL'><i class="icon icon-remove"></i></a><br/>
	<ul>
		<input type="hidden" id='menuIdTeam' value='' />
		<input type="hidden" id='menuData' value='' />
		<input type="hidden" id='menuId' value='' />
		<li class="hide" id='userName'>
			
		</li>
		<!--
		<li class="hide" data-grupa="pusty" >
			{{$brak_metod_dla_menu}}
		</li>
		-->
		<li id="ukryjEventy" ><a href="javascript:void(0)" ><i class="icon icon-adjust" ></i> <span>Hide events </span></a></li>
		<li id="pokazEventy" class="hide" ><a href="javascript:void(0)" ><i class="icon icon-bullseye" ></i> <span>Show events</span></a></li>
		<li><hr/></li>
		{{BEGIN selected}}
		<li data-grupa="selected" class="hide"><a href="{{$href}}" id="{{$id}}" ><i class="icon icon-eraser" ></i> <span>{{$etykieta}}</span></a></li>
		{{END selected}}
		{{BEGIN selected-event}}
		<!-- <li data-grupa="selectedEvent" class="hide"><a href="javascript:void(0)" id="zaznaczPodobneEvent" ><i class="icon icon-bullhorn" ></i> <span>{{$menu_select_similar_event}}</span></a></li> -->
		<li data-grupa="selectedEvent"   class="hide" > Bg :<input id="kolorTla" style="display: none;" type="text">  Txt <input id="kolorCzcionki" style="display: none;" type="text"></li>
		<li data-grupa="selectedEvent"  class="hide" ><hr/></li>
		<li data-grupa="selectedEvent" class="hide" ><a href="javascript:void(0)" id="usunPrzypisanie" ><i class="icon icon-remove"></i> <span>{{$menu_remove_selected_event}}</span></a></li>
		<li data-grupa="wykonajEvent" class="hide" ><a href="javascript:void(0)" id="wykonajEvent" ><i class="icon icon-play"></i> <span>{{$menu_wykonaj_event}}</span></a></li>
		<li data-grupa="selectedEvent" class="hide" ><hr/></li>
		{{END}}
		<li data-grupa="event"  class="hide" ><a href="javascript:void(0)" class="dodajEvent" id='domyslny' ><i class="icon icon-crop" ></i> <span>{{$menu_add_event}}</span></a></li>
		{{BEGIN listaMenu}}
		<li data-grupa="event" data-typ='{{$typWyswietlania}}' class="{{$typWyswietlania}} hide" ><a href="javascript:void(0)"  class="dodajEvent" id='{{$szablonPhp}}' ><i class="icon icon-crop" ></i> <span>{{$szablonNazwa}}</span></a></li>
		{{END}}
		
		<li class="pracownikMenu hide" ><a  href="javascript:void(0)" class='ustawLidera' > <i class="icon icon-star" ></i> <span>{{$menu_ustaw_lidera}}</span>  </a></li>
		<li class="pracownikMenu hide" ><a  href="javascript:void(0)" class='zaznaczPracownika' > <i class="icon icon-bullseye" ></i> <span>{{$menu_zaznacz_pracownika}}</span>  </a></li>
		<!--
		<li data-grupa="projekt-grupy" class="hide" ><a href="javascript:void(0)" id="usunZGrupy" ><i class="icon icon-certificate"></i> <span>{{$menu_usun_z_grupy}}</span></a></li>
		-->
		<li data-grupa="zamowienie" class="hide" ><a href="javascript:void(0)" id="podgladZamowienia" ><i class="icon icon-search"></i> <span>{{$menu_show_order_details}}</span></a></li>
		<li data-grupa="notatka" class="hide" ><hr/></li>
		<li data-grupa="notatka" class="hide" ><a href="javascript:void(0)" id="podgladNotatki" ><i class="icon icon-search"></i> <span>{{$menu_show_note}}</span></a></li>
		<li data-grupa="komentarz" class="hide " ><hr/></li>
		<li data-grupa="komentarz" class="hide" ><a href="javascript:void(0)" id="podgladKomentarz" ><i class="icon icon-search"></i> <span>{{$menu_show_comment}}</span></a></li>
		<li data-grupa="komentarz" class="hide" ><a href="javascript:void(0)" id="usunKomentarz" ><i class="icon icon-remove"></i> <span>{{$menu_remove_comment}}</span></a></li>
		<li data-grupa="komentarz" class="hide" ><a href="javascript:void(0)" id="edytujKomentarz" ><i class="icon icon-pencil"></i> <span>{{$menu_edit_comment}}</span></a></li>
		<li data-grupa="komentarz" class="hide wypelniony" ><hr/></li>
		<li data-grupa="komentarz" class="hide wypelniony" ><a href="javascript:void(0)" id="dodajKomentarz" ><i class="icon icon-pencil"></i> <span>{{$menu_add_comment}}</span></a></li>
	</ul>
</div>
{{END}}

{{BEGIN kalendarzPracownicy}}
<link href="/_system/css/kalendarz.css" rel="stylesheet">
<script src="/_system/js/jquery-3.0.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="/_system/js/spectrum.js"></script>
<link rel="stylesheet" href="/_system/js/spectrum.css" />
	<a href="{{$urlKalendarzTeamy}}" id="widokPracownikow" class="label label-warning small"><i class="icon icon-truck"></i> Team view</a>
	<div id="datyKalendarza">
		{{$formularzDaty}}
	</div>
	<div id='kalendarz_szerokosc'>
	<div id="kalendarzSlim">
		{{BEGIN kalendarz}}
		<table id="cal-tabela" class="table table-bordered table-bordered-strong" style="">
			<thead>
				<tr>
					<th class="pusty" ></th>
					{{BEGIN uzytkownik}}
					<th class="cal-team cal-user" data-team="{{$id}}" style="display: table-cell;" >
							<div class="imgPracownik" data-id="{{$id}}" >
								<img class="tip top-left pracownik {{IF $lider}} lider {{END IF}}" src="{{$zdjecie}}" style="cursor: pointer;" alt="{{$imie}} {{$nazwisko}}" data-original-title="{{$imie}} {{$nazwisko}}" rel="comm-{{$id}}" ><br/>
							</div>
							<div class="imieUzytkownik">
								{{$nazwisko}}
							</div>
					</th>
					{{END uzytkownik}}
				</tr>
			</thead>
			<tbody>
				{{BEGIN data}}
				<tr id="row-count-0" class="cal-row">
					<th class="cal-data cal-data-user">
						{{$dataTydzien}}
					</th>
					{{BEGIN dataTeam}}
					<td class="cal-team-data cal-user-data sortable zezwolZaznacz wybranyUser {{$bgColor}}" data-team="{{$idTeam}}" data-data="{{$data}}">

					</td>
					{{END dataTeam}}
					{{BEGIN dataGroup}}
					<td data-team="{{$idGrupa}}" data-grupa="{{$idGrupa}}" data-data="{{$data}}" class="cal-team-data cal-grupa-data {{$bgColor}}">
					</td>
					{{END}}
				</tr>
				{{END data}}
			</tbody>
		</table>
		<div id="listaEventow">
			{{BEGIN zamowienie}}
				<div class="event tekstWPionie1 {{IF $zalogowany}}nie-przenos nie-rozszezaj{{END}} projekt {{$class}} {{IF $class == 'ukryty'}}projekt-grupy{{END IF}} " id="event_{{$id}}" data-id="{{$id}}" data-event="{{$id_event}}" data-dni="{{$iloscDni}}" data-data="{{$data}}" data-team="{{$idTeam}}" data-grupa="{{$grupa}}" style="background-color: {{$bgColor}}; color:{{$kolorCzcionki}}" title="{{$nazwa}}" >
					{{IF $zalogowany}}<span class="zalogowanyEvent" ></span>{{END IF}}
					{{IF $teamName}} [ <strong> {{$teamName}} </strong> ]{{END}}
					<span class="tytulEvent">{{$nazwa}}</span>
				</div>
			{{END}}
			{{BEGIN zamowienieGrupa}}
				<div class="event tekstWPionie1 nie-przenos nie-rozszezaj grupaZamowien nie-zaznaczaj" id="event_{{$id}}" data-id="{{$id}}" style="background-color: {{$bgColor}}; color:{{$kolorCzcionki}}" data-dni="{{$iloscDni}}" data-data="{{$data}}" data-team="{{$idTeam}}" data-grupa="{{$grupa}}" title="{{$title}}" >
					<span class="tytulEvent">{{$nazwa}}</span>
				</div>
			{{END}}
			{{BEGIN projektyGrupa}}
				<div class="event tekstWPionie1 nie-przenos nie-rozszezaj grupaZamowien nie-zaznaczaj" data-ids="{{$idsProjektow}}" style="background-color: {{$bgColor}}; color:{{$kolorCzcionki}}" data-dni="{{$iloscDni}}" data-data="{{$data}}" data-team="{{$idTeam}}" title="{{$title}}" >
					<div class="label label-info small nopadding">
						<i class="icon icon-plus rozwinGrupaProjekty"></i>
					</div>
					<span class="tytulEvent">{{$nazwa}}</span>
				</div>
			{{END}}
			{{BEGIN event}}
				<div class="event tekstWPionie1 {{IF $user_id }}userEvent{{END IF}}" id="event_{{$id}}" data-wykonany="{{$wykonany}}" data-user="{{$user_id}}" data-id="{{$id}}" data-dni="{{$iloscDni}}" data-data="{{$data}}" data-team="{{$idTeam}}" data-grupa="{{$grupa}}" title="{{$title}}" style="background-color: {{$bgColor}}; color:{{$kolorCzcionki}}" >
					<span class="tytulEvent">{{$nazwa}}</span>
				</div>
			{{END}}
		</div>
		<div id="do-gory"></div>
		<div id="wczytaj-wiecej-kalendarz">Read more</div>
		{{END kalendarz}}
		<div id="menuCopy" class="cal-team-caly" style='display: none;'>
			<ul>
				<li ><a href="javascript:void(0)" onclick="cancelMoveEvent()" id="cancelMoveEvent" ><i class="icon icon-mail-reply-all" ></i> <span>{{$menu_move_event_cancel}}</span></a></li>
				<li ><a href="javascript:void(0)" onclick="kopiujEvent()" id="kopiujEventy" ><i class="icon icon-cut" ></i> <span>{{$menu_move_event}}</span></a></li>
				<li ><a href="javascript:void(0)" onclick="klonujEvent()" id="powielEventy" ><i class="icon icon-paste" ></i> <span>{{$menu_clone_event}}</span></a></li>
			</ul>
		</div>
	</div>
	<div class="zaznaczonyPracownik" style="display: none;"></div>
</div>

<script>
	var naglowek;
	var zaminyIstnieja;
	var przeniesEventTemp;
	var sortUserTemp;
	$(document).ready(function(){
		initPage();
	});
	
	//$(document).on('click', '#usunZGrupy', function(event){ odepnijOdGrupy($(this)); });
	//$(document).on('click', '.zaznaczPracownika ', function(e){  zaznaczPracownika($(this)); $('.close-menu').click(); e.defaultPrevented; return false; });
	//$(document).on('click', '.zaznaczonyPracownik', function(e){ odznaczPracownika($(this)); e.defaultPrevented; return false; })
	//$(document).on('click', '.cal-team:not(.opacityTeam , .nieZaznaczaj)', function(e){  sprawdzGrupe($(this)); e.defaultPrevented; return false; });
	//$(document).on('click', '.team-wiecej' ,function(e){ zwinRozwinTeamWiecej($(this));  return false;	});
	$(document).on('mousedown mouseover',".zezwolZaznacz", function (e) { selectDay( $(this) , e); return false; });
	$(document).on('contextmenu','.cal-user-data', function(e){ menuPodreczne(e, $(this)); return false; });
	//$(document).on('contextmenu','.pracownik', function(e){ menuPodreczne(e, $(this)); return false; });
	$(document).on('click', '.dodajEvent', function(){	dodajEvent( $(this).attr('id') ); });
	$(document).on('mousedown',".event:not(.nie-zaznaczaj)", function (e) { if(e.button == 0){ selectEvent($(this)); return false; } });
	$(document).on('click', '#usunPrzypisanie', function(){ $('.close-menu').click(); potwierdzenieModal1( "{{$potwierdzUsunPrzypisanie}}", 'Confirm', 'usunPrzypisanie()' ); } );
	//$(document).on('click', '.grupaSzczegolyTeamu', function(){ pokazTeamGrupy($(this));  return false;  });
	//$(document).on('click', '.doGrupy', function(){ powrotDoGrupy($(this));  return false; });
	$(document).on('click', '#wykonajEvent', function(){ wykonajEvent();  return false; });
	//$(document).on('click', '#zapiszGrupe', function(){ zapiszGrupe();  return false; });
	//$(document).on('click', '#listaPracownikowPrzycisk', function(){ pokazListePracownikow();  return false; });
	
	function initPage()
	{
		$('#nazwaGrupy').uniform();
		kolorPrzycisk($('#kolorTla'), '#90C3D4');
		kolorPrzycisk($('#kolorCzcionki'), '#000');
		//$('#sortujTeam').on('click', function(){ sortujTeam(); });
		$('#kolorTla').on('change', function(){ zmienKolor('tlo'); })
		$('#kolorCzcionki').on('change', function(){ zmienKolor('czcionka'); })
		$//('#nazwaGrupy').uniform();
		//$('.closeStworzGrupe').on('click', function(){ $('#stworzGrupe').hide(); $('.stworzGrupeError').remove(); return false; });
		//$('.usunGrupe').on('click', function(){ potwierdzenieModal1( "{{$potwierdzUsunGrupe}}", 'Confirm', 'usunGrupe(\''+$(this).parents('.cal-grupa').attr('data-grupa')+'\')' ); return false; });
		//$('.edytujGrupe').on('click', function(){ modalAjax( "{{$urlEdytujGrupe}}"+'&grupa='+$(this).parents('th').attr('data-grupa'), {width: 1200, height: 1000} ); dopasujModala(); return false; });
		$('.close-menu').on('click', function(){ $('#menuPodreczne').hide(300); });
		$('#czyscZaznaczenie, #czyscZaznaczenie2').on('click', function(){ $('.selected').removeClass('selected'); $('.selectedEvent').removeClass('selectedEvent'); $('.close-menu').click(); });
		$('#ukryjEventy').on('click', function(){ ukryjEventy(); return false; });
		$('#pokazEventy').on('click', function(){ pokazEventy(); return false; });
		//$('.ustawLidera').on('click', function(){ ustawLidera($(this)); return false; }  );
		//$('#podgladZamowienia').on('click', function(){ podgladZamowienia($('.event-zaznaczony').attr('data-id')); });
		$('#do-gory').on('click', function(){ doGory(); });
		$('#wczytaj-wiecej-kalendarz').on('click', function(){ wczytajWiecejDat(); });
		//$('.rozwinGrupaProjekty').on('click', function(){ rozwinGrupeProjekty($(this).parents('.event')); });
		//$('.pokazBilGrupa').on('click', function(e){ pokazGrupe($(this)); return false; });
		
		//ustawSzerokoscTh();
		rozmiescEventy();
	   klonujNaglowek();
		//setInterval(function(){ sprawdzZalogowanych(); }, {{$milisekundyOdswiezLogowanie}});
		
		$(window).scroll(function() { scrollTeamHead(); scrollDoGory(); });
		setSortableEvent(".event:not(.nie-przenos)");
		//setSortableUser();
		setTimeout(function(){
			setResizable();
		}, 1000 );
		
	}
	
	function wykonajEvent()
	{
		if($('.event-zaznaczony').length > 0)
		{
			var ids = [];
			
			$.each($('.event-zaznaczony'),  function(i, event){
				ids.push($(this).attr('data-id'));
			});
			var dane = { ids: ids };
			ajax("{{$urlWykonajWydarzenie}}", eventWykonany, dane, 'POST', 'json');
		}
	}
	
	function eventWykonany(dane)
	{
		if(dane.blad > 0) alertModal('Error', dane.bladTxt);
		$.each(dane.ids, function(i, id){
			$('.event:not(.projekt)[data-id='+id+']').attr('data-wykonany', 1);
		});
		$('#menuPodreczne').find('.close-menu').click();
	}
	
	function wczytajWiecejDat()
	{
		ajax("{{$urlWczytajWiecej}}" , succesWczytajWiecej, {}, 'POST', 'json', true );
	}
	
	function succesWczytajWiecej(dane)
	{
		$('#kalendarzSlim').html('');
		$('#kalendarzSlim').append(dane.html);
		
		$('#dataStart').val(dane.dataStart);
		$('#dataStop').val(dane.dataStop);
		
		initPage();
	}
	
	function doGory(){ $("html, body").animate({ scrollTop: 0 }, 500); }
	
	function ukryjEventy()
	{
		$('.event').hide();	$('.close-menu').click(); $('#ukryjEventy').hide(); $('#pokazEventy').show();
	}
	
	function pokazEventy()
	{
		$('.event:not(.ukryty)').show();	$('.close-menu').click(); $('#ukryjEventy').show(); $('#pokazEventy').hide();
	}
	
	function setResizable()
	{
		$('.event:not(.nie-rozszezaj)').resizable({
				grid: 110,
				handles: "s",
				distance: 50,
				start: function( event, ui ) {
					wylaczZaznaczanie(true);
					ui.element.addClass('pointerNone');
					if(ui.element.parents('.event').length)
					{
						ui.element.parents('.event').css('visibility', 'hidden');
						ui.element.css('visibility', 'visible');
					}
				},
				stop:  function( event, ui ) {
					ustawZmianyIstnieja();
					ui.element.removeClass('pointerNone');
					
					var data = {
						dataStop: event.originalEvent.target.getAttribute('data-data'),
						dataStart: event.target.getAttribute('data-data'),
						idTeam: event.target.getAttribute('data-team'),
						idUser: event.target.getAttribute('data-user'),
						idEvent: event.target.getAttribute('data-id'),
					};
					
					ajax( '{{$urlRozszerzEvent}}', potwierdzResizable, data, 'POST', 'json' );
					if(ui.element.parents('.event').length)
					{
						ui.element.parents('.event').css('visibility', 'visible');
						ui.element.css('visibility', 'visible');
					}
					wlaczZaznaczanie();
					
				}
		  });
	}
	
	function potwierdzResizable(dane)
	{
	}
	
	
	/* zaznaczanie pol */
	function selectDay(obiekt, e)
	{
		if (e.buttons == 1 || e.buttons == 3) { (obiekt.hasClass('selected')) ? obiekt.removeClass('selected') : obiekt.addClass('selected');	$('.event-zaznaczony').removeClass('event-zaznaczony'); }
		
	}
	
	function selectEvent(obiekt){
		
		$('#menuIdTeam').val(obiekt.attr('data-team'));
		$('#menuData').val(obiekt.attr('data-data'));
		$('#menuId').val(obiekt.attr('id').replace('event_', '')); 
		
		if(obiekt.hasClass('event-zaznaczony'))
		{
			obiekt.toggleClass('event-zaznaczony');  
			//odznaczPodobne('team');
		}
		else
		{
			$('.selected').removeClass('selected');
			obiekt.toggleClass('event-zaznaczony');  
			//zaznaczPodobne('team');	
		}
	}
	
	/* koniec zaznaczanie pol */
	
	/* menu podreczne */
	function menuPodreczne(e, obiekt)
	{
		var wyswietlam = 0;
		var menuPodreczne = $('#menuPodreczne');
		
		
		$('#userName').hide();
		menuPodreczne.find('li[data-grupa=selected]').hide();
		if($('.selected').length > 0 ){
			
			$('.selected').each(function(){
				
			});
			
			var userId = $('.selected').attr('data-team');
			
			$('#userName').text($('.pracownik[rel=comm-'+userId+']').attr('alt'));
			$('#userName').show();
			
			menuPodreczne.find('li[data-grupa=pusty]').hide();
			menuPodreczne.find('li[data-grupa=selectedEvent]').hide();
			menuPodreczne.find('li[data-grupa=selected]').show();
			menuPodreczne.find('li[data-grupa=event]').hide();
			menuPodreczne.find('li.wypelniony').hide();
			$('li.eUser').show(); wyswietlam = 1;
		}

		if($('.event-zaznaczony').length > 0){ menuPodreczne.find('li[data-grupa=selectedEvent]').show(); wyswietlam = 1; }
		
		if(obiekt.hasClass('pracownik'))
		{
			var idPracownika = e.currentTarget.getAttribute('rel').replace('comm-', '');
			$('.pracownikMenu').attr('data-pracownik', idPracownika);
			$('.pracownikMenu').show();
		}
		else
		{
			$('.pracownikMenu').hide();
		}
		
		if(obiekt.children('.icon-time').length) { menuPodreczne.find('li[data-grupa=powiadomienie]').show(); wyswietlam = 1;}
			
		var mouseX = e.pageX-40;
		var mouseY = e.pageY-90;
		var koniecStrony = $('#content').offset().left + $('#content').width() - 200;
		if(koniecStrony < mouseX)
		{
			mouseX = mouseX - 200;
		}
	
		menuPodreczne.css('left', mouseX);
		menuPodreczne.css('top', mouseY);
		
		if(!wyswietlam)
			menuPodreczne.find('li[data-grupa=pusty]').show();

		menuPodreczne.show(100);
	}
	
	function menuKopiujKlonuj(e)
	{
		var menuKopiujKlonuj = $('#menuCopy');
		
		var mouseX = e.pageX-40;
		var mouseY = e.pageY-90;
		menuKopiujKlonuj.css('left', mouseX);
		menuKopiujKlonuj.css('top', mouseY);
		menuKopiujKlonuj.show(300);
	}
	
	/* koniec menu podreczne */
	function kopiujEvent()
	{
		ajax("{{$urlPrzeniesEvent}}" , potwierdzPrzeniesEvent,  przeniesEventTemp , 'POST', 'json' );
	}
	
	function klonujEvent()
	{
		ajax("{{$urlKlonujEvent}}" , potwierdzKlonujEvent,  przeniesEventTemp , 'POST', 'json' );
	}
	
	function potwierdzPrzeniesEvent(dane)
	{
		if(dane.blad > 0){
			alertModal('Error!', dane.komunikat); 
			$('#menuCopy').hide();
			return false; 
		}
		$('#event_'+dane.idEvent).attr('data-team', dane.idTeam).attr('data-data', dane.dataNowa);
		$('#event_'+dane.idEvent).find('.tytulEvent').text(dane.nazwaEventu);
		$('#menuCopy').hide();
		rozmiescEventyWPolu(przeniesEventTemp.idStaryTeam, przeniesEventTemp.dataStara);
		
		var grupaProjektow = $('.grupaZamowien[data-team='+przeniesEventTemp.idStaryTeam+']');
		if(grupaProjektow.length)
		{
			var projektTekst = grupaProjektow.find('.tytulEvent strong');
			projektTekst.text('x '+(parseInt(projektTekst.text().replace('x', ''))-1));
			grupaProjektow.attr('data-ids', grupaProjektow.attr('data-ids').replace(przeniesEventTemp.idEvent+',', '').replace(','+przeniesEventTemp.idEvent, '') );
		}
		przeniesEventTemp = [];
		
		if(dane.komunikatUruchomEvent) 
		{
			var txt = dane.komunikatUruchomEventTxt+'<br/>';
			var ids = [];
			$.each(dane.eventyDoUruchomienia, function(i, event){
				ids.push(event.id);
				txt = txt+' '+event.name+'<br/> ';
			});
			var joinIds = ids.join('|');
			potwierdzenieModal1(txt, 'Confirm', 'wykonajWydarzenia(\''+joinIds+'\')' ); 
		}
		 
	}
	
	function potwierdzKlonujEvent(dane)
	{
		if(dane.blad > 0){
			alertModal('Error!', dane.komunikat); 
			$('#menuCopy').hide();
			return false; 
		}
	
		var nowyEvent = $('.event[data-id='+dane.idEvent+'][data-user='+przeniesEventTemp.oldUser+']').clone();
		nowyEvent.attr('id', 'event_'+dane.idEventNowy).attr('data-user', dane.idUser).attr('data-data', dane.dataNowa).attr('data-id', dane.idEventNowy);
		nowyEvent.find('.tytulEvent').text(dane.nazwaEventu).attr('title', dane.nazwaEventu);
		$('#listaEventow').append(nowyEvent);
		
		var staryEvent = $('.event[data-id='+dane.idEvent+'][data-user='+przeniesEventTemp.oldUser+']');
		staryEvent.attr('data-team', przeniesEventTemp.oldUser).attr('data-user', dane.oldUser).attr('data-data', przeniesEventTemp.dataStara);
		$('#listaEventow').append(staryEvent);
		
		umiescEvent(nowyEvent);
		umiescEvent(staryEvent);
		//rozmiescEventyWPolu(przeniesEventTemp.oldUser, przeniesEventTemp.dataStara);
		$('.event-zaznaczony').removeClass('event-zaznaczony');
		//rozmiescEventyWPolu(przeniesEventTemp.idStaryTeam, przeniesEventTemp.dataStara);
		$('#menuCopy').hide();
		
		przeniesEventTemp = [];
		
		if(dane.komunikatUruchomEvent) 
		{
			var txt = dane.komunikatUruchomEventTxt+'<br/>';
			var ids = [];
			$.each(dane.eventyDoUruchomienia, function(i, event){
				ids.push(event.id);
				txt = txt+' '+event.name+'<br/> ';
				$('#event_'+event.id).not('.project').attr('data-wykonany', 0);
			});
			var joinIds = ids.join('|');
			potwierdzenieModal1(txt, 'Confirm', 'wykonajWydarzenia(\''+joinIds+'\')' ); 
		}
		 
	}
	
	function wykonajWydarzenia(ids)
	{
		var dane = {
			ids: ids.split('|'),
		};
		ajax("{{$urlWykonajWydarzenie}}", potwierdzWykonajWydarzenia, dane, 'POST', 'json');
	}

	function potwierdzWykonajWydarzenia(dane)
	{
		if(dane.blad > 0) alertModal('Error', dane.bladTxt);
		$.each(dane.ids, function(i, id){
			$('.event:not(.projekt)[data-id='+id+']').attr('data-wykonany', 1);
		});
		$('#usunPotwierdzenie').find('.close').click();
	}
	
	function cancelMoveEvent()
	{
		umiescEvent($('.event[data-id='+przeniesEventTemp.idEvent+'][data-team='+przeniesEventTemp.oldUser+']'));
		//przeliczSzerokoscTeamu(przeniesEventTemp.oldUser);
		//przeliczSzerokoscTeamu(przeniesEventTemp.idTeam);
		$('#menuCopy').hide();
		 
	}
	
	/* obsługa eventow */
	/*(
	 * 
	 * @param {type} typ - typ wybranego eventu np dayOff
	 * @param {type} eTyp - rodzaj eventu czy dla teamu czy dla usera
	 * @returns {Boolean}
	 */
	function dodajEvent(typ)
	{
		if(!czyZaznaczony()) return false;
		var tab = pobierzZaznaczone();
		modalAjax("{{$urlDodajEvent}}"+'&typ='+typ+'&eTyp='+tab.eTyp, {width: 1200, height: 1000}, 'POST', tab);
		$('.close-menu').click();
	}
/* koniec obsluga eventow */
	
	function pobierzZaznaczoneTeamy()
	{
		var ids = [];
		$('.teamZaznaczony').each(function(){
			ids.push($(this).attr('data-team'));
		});
		return ids;
	}
	
	function rozmiescEventy()
	{
		$('#listaEventow').children('.event').each(function(){
			umiescEvent($(this));
		});
	}
	
	function ustawSzerokoscTh()
	{
		$('.cal-team').each(function(){
			$(this).css('min-width', $(this).width());
			$(this).children('.wypelnienie').css('min-width', $(this).width());
			przeliczSzerokoscTeamu($(this).attr('data-team'));
		});
	}
	
	function klonujNaglowek()
	{
		if(typeof naglowek !== 'undefined')
			naglowek.remove();

		naglowek = $('#cal-tabela thead').clone();
		naglowek.addClass('klonNaglowek');
		naglowek.find('.pusty').css('height', 'auto');
		naglowek.find('.cal-team').css('height', '40px');
		naglowek.find('.imieUzytkownik').remove();
	 /*
		$('.cal-team').each( function(i,v){
			console.log($(this).attr('data-team'));
			naglowek.find('.cal-team[data-team='+$(this).attr('data-team')+']').css('min-width', $(this).width());
		 });
		 */
		 
		  
		$('#cal-tabela').append(naglowek);
		//naglowek.hide();
	}
	
	function scrollTeamHead()
	{
		if($('#cal-tabela').offset().top < $(window).scrollTop() && !naglowek.hasClass('moveHead'))
		{
			klonujNaglowek();
			var teamRozszezony = naglowek.find('.uzytkownicyTeamuLista');
			if(teamRozszezony.length > 0)
			{
				naglowek.find('.cal-team-bil').hide();
				naglowek.find('.icon-truck').hide();
			}
				
			naglowek.addClass('moveHead');
			naglowek.show();
		}
		if(naglowek.hasClass('moveHead'))
		{
			naglowek.css('top', $(window).scrollTop() - 270);
		}
		var pozycja = 315;
		if(parseInt($(window).scrollTop()) < pozycja && naglowek.hasClass('moveHead'))
		{
			naglowek.removeClass('moveHead');
			naglowek.find('.cal-team-bil').show();
			naglowek.find('.icon-truck').show();
			naglowek.hide();
		}
	}
	
	function setSortableEvent(items)
	{
		$('.sortable').sortable({
			//items : ".event:not(.nie-przenos)",
			items: items,
			connectWith: '.sortable' ,
			cursor: "move",
			scrollSpeed: 40,
			tolerance: "intersect",
			placeholder: "placeholder",
			zIndex: 9999,
			start: function( event, ui ){
					wylaczZaznaczanie(true);
					$('#koszEvent').css('opacity', '1');
				},
			stop: function( event, ui ){
					wlaczZaznaczanie(); $('#koszEvent').css('opacity', '0');
				 },
			update: function( event, ui ) {
				var oldUser = ui.item.attr('data-user');
				var oldData = ui.item.attr('data-data');
				
				//var left = (( event.target.children.length - 1 ) * 30 ) + 3;
				var target = ui.item.parent('.cal-team-data');
				var newUser = target.attr('data-team');
				var newData = ui.item.parent('td').attr('data-data');
				
				if(oldUser == newUser && oldData == newData)
					return false;

				//ui.item.css('left', left );
				
				var oldData = ui.item.attr('data-data');
				//var oldTeam = ui.item.attr('data-team');
				
				var idEvent = ui.item.attr('data-id');
				
				//przeliczSzerokoscTeamu(newTeam);
				
				if(ui.sender != null)
					//przeliczSzerokoscTeamu(oldTeam);
				
				var projekt = 0;
				if(ui.item.hasClass('projekt'))
					projekt = 1;
				
				var dni = ui.item.attr('data-dni');
				
				przeniesEventTemp = {
					newUser: newUser,
					oldUser: oldUser,
					dataStara: oldData,
					dataNowa: newData,
					idEvent: idEvent,
					projekt: projekt,
					dni: dni
				}
				
				if(event.target != '')
				{
					if(event.target.id == "koszEvent")
					{
						$('#menuCopy').hide();
						potwierdzenieModal2('Are you sure you want to delete this Event ?', 'Confirm', 'usunEvent()', 'cancelMoveEvent()' );
					}
					else
						menuKopiujKlonuj(event);
				}
				
			}
	  });
	}
	
	function usunEvent()
	{
		var oddzielProjekt = [];
		if(przeniesEventTemp.projekt)
			var oddzielProjekt = [{ idTeam: przeniesEventTemp.idStaryTeam, idProjekt: przeniesEventTemp.idEvent }];
			
		var usunPrzypisanie = [przeniesEventTemp.idEvent];
		
		ajax("{{$urlUsunPrzypisanie}}" , potwierdzUsunPrzypisanie, { usun: usunPrzypisanie, usunProjekt: oddzielProjekt }, 'POST', 'json' );
		
	}
	
	function rozmiescEventyWPolu(idTeam, data)
	{
		var i = 0;
		var listaEventow = $('.cal-team-data[data-team='+idTeam+'][data-data='+data+']').children('.event');
		if(listaEventow.length)
		{
			listaEventow.each(function(){
				var left = ( i * 30 ) + 3;
				i++;
				$(this).css('left', left );
			});
		}
	}
	
	 
	function przeliczSzerokoscTeamu(id, grupa)
	{
		var grupa = grupa|false;
		
		var max = 0;
		if(grupa)
			var lista = $('.cal-team-data[data-grupa='+id+']')
		else
			var lista = $('.cal-team-data[data-team='+id+']')
		
		lista.each(function(){
			var ilosc = $(this).children('.event').length;
			(ilosc > max) ? max = ilosc : null;
		});
		
		var left = (max == 0) ? 20 : (( max ) * 30 ) + 3;
		left = left +30;
		if(grupa)
		{
			var grupaKontener = $('.cal-team[data-grupa='+id+']');
			grupaKontener.css('min-width', left);
			grupaKontener.children('.wypelnienie').css('min-width', left);
		}
		else
		{
			var teamKontener = $('.cal-team[data-team='+id+']');
			teamKontener.css('min-width', left);
			teamKontener.children('.wypelnienie').css('min-width', left);
		}
	}
	 
	
	function ustawWysokoscEventu(event)
	{
		var dni = event.attr('data-dni');
		// 180 tyle wynosi wysokosc jednego dnia w kalendarzu +1 obramowanie
		if(dni > 1)
			event.css('height', (parseInt(dni * 111) - 30));
		else
			event.css('height', 81 );
	}
	
	function umiescEvent(event, wymusTeam)
	{
		//var team = event.attr('data-team');
		var data = event.attr('data-data');
		
		var dataUser = event.attr('data-user');
		var dataTeam = $('.cal-team-data[data-team='+dataUser+'][data-data='+data+']');
		
		if(dataTeam.length) // eventy przypisane do teamu
		{
			// 30 px tyle wynosi szerokosc eventu + 3 lewy margines
			//var left = (dataTeam.children().length * 30 ) + 3;
			left = 0;
			event.css('left', left ); 
			dataTeam.append(event);
			event.removeClass('nie-przenos');
			//przeliczSzerokoscTeamu(team);
			ustawWysokoscEventu(event);
			event.show(); 
		}
		/*
		 
		
		var team = event.attr('data-team');
		var data = event.attr('data-data');
		
		var dataUser = event.attr('data-user');
		var dataTeam = $('.cal-team-data[data-team='+team+'][data-data='+data+']');
		
		var idEventProjekt = event.attr('data-event');
		
		if(dataTeam.length) // eventy przypisane do teamu
		{
			// 30 px tyle wynosi szerokosc eventu + 3 lewy margines
			//var left = (dataTeam.children().length * 30 ) + 3;
			left = 0;
			event.css('left', left ); 
			dataTeam.append(event);
			przeliczSzerokoscTeamu(team);
			ustawWysokoscEventu(event);
			event.show(); 
		}
		// eventy wyswietlane na grupie
		else if(grupa != '' && wymusTeam == 0 && typeof(grupa) != 'undefined')
		{
			var dataGroup = $('.cal-team-data[data-grupa='+grupa+'][data-data='+data+']');
			if(dataGroup.length)
			{
				//var left = (dataGroup.children().length * 30 ) + 3;
				left = 0;
				event.css('left', left );
				dataGroup.append(event);
				przeliczSzerokoscTeamu(grupa, true);
				ustawWysokoscEventu(event);
				event.show();
			}
		}
		else
		{
		}
		if(idEventProjekt > 0)
		{
			var eventProjektu = $('#event_'+idEventProjekt+':not(.projekt)');
			var data = eventProjektu.attr('data-data');
			var pozycjaTop = $('.cal-team-data[data-data='+data+']').position().top-145;
			eventProjektu.addClass('pomin').addClass('nie-przenos');
			eventProjektu.appendTo(event);
			eventProjektu.css('left', -3 );
			event.addClass('nie-przenos');
			eventProjektu.css('top', pozycjaTop);
			ustawWysokoscEventu(eventProjektu);
			eventProjektu.show(); 
		}
		*/
	}
	
	function czyZaznaczony(){ if($('.selected').length > 0){ return true; }else{ alertModal('Notice', '{{$nieZaznaczonoDatyKomunikat}}'); return false; } }
	
	function wylaczZaznaczanie(czysc)
	{
		czysc = czysc|false;
		
		if(czysc)
			$('#czyscZaznaczenie').click();
			
		$(document).off('mousedown mouseover',".zezwolZaznacz");
	}
	
	function wlaczZaznaczanie()
	{
		$(document).on('mousedown mouseover',".zezwolZaznacz", function (e) { selectDay( $(this) , e); return false; });
	}
	
	function scrollDoGory()
	{
		var pozycja = 500;
		if(pozycja < $(window).scrollTop())	$('#do-gory').show(500);
		if(parseInt($(window).scrollTop()) < pozycja ) $('#do-gory').hide(500);
	}
	
	function pobierzZaznaczone()
	{
		eTyp = 'eUser';
		var dataTeam = {};
		var godzina = null;
			
		if(eTyp == 'eUser')
		{
			$('.selected').each(function()
			{
				var $data = $(this).attr('data-data');
				var $idUser = $(this).attr('data-team');
				if (!dataTeam[$idUser]) dataTeam[$idUser] = {};
				if (!dataTeam[$idUser][$data]) dataTeam[$idUser][$data] = { istnieje: true };
			});
		}
		else if(eTyp == 'eTeam')
		{
			$('.selected').each(function()
			{
				var $team = $(this).attr('data-team');
				var $data = $(this).attr('data-data');

				if (!dataTeam[$team]) dataTeam[$team] = {};
				if (!dataTeam[$team][$data]) dataTeam[$team][$data] = { istnieje: true };
			});
		}
		
		return {
			dataTeam: dataTeam,
			eTyp: eTyp,
		};
	}
	
	function kolorPrzycisk(obiekt, kolorDomyslny)
	{
		obiekt.spectrum({
			color: kolorDomyslny,
			showInput: true,
			className: "full-spectrum",
			showInitial: true,
			showPalette: true,
			showSelectionPalette: true,
			maxSelectionSize: 10,
			preferredFormat: "hex",
			localStorageKey: "spectrum.demo",
			palette: [
				 ["rgb(0, 0, 0)", "rgb(67, 67, 67)", "rgb(102, 102, 102)",
				 "rgb(204, 204, 204)", "rgb(217, 217, 217)","rgb(255, 255, 255)"],
				 ["rgb(152, 0, 0)", "rgb(255, 0, 0)", "rgb(255, 153, 0)", "rgb(255, 255, 0)", "rgb(0, 255, 0)",
				 "rgb(0, 255, 255)", "rgb(74, 134, 232)", "rgb(0, 0, 255)", "rgb(153, 0, 255)", "rgb(255, 0, 255)"], 
				 ["rgb(230, 184, 175)", "rgb(244, 204, 204)", "rgb(252, 229, 205)", "rgb(255, 242, 204)", "rgb(217, 234, 211)", 
				 "rgb(208, 224, 227)", "rgb(201, 218, 248)", "rgb(207, 226, 243)", "rgb(217, 210, 233)", "rgb(234, 209, 220)", 
				 "rgb(221, 126, 107)", "rgb(234, 153, 153)", "rgb(249, 203, 156)", "rgb(255, 229, 153)", "rgb(182, 215, 168)", 
				 "rgb(162, 196, 201)", "rgb(164, 194, 244)", "rgb(159, 197, 232)", "rgb(180, 167, 214)", "rgb(213, 166, 189)", 
				 "rgb(204, 65, 37)", "rgb(224, 102, 102)", "rgb(246, 178, 107)", "rgb(255, 217, 102)", "rgb(147, 196, 125)", 
				 "rgb(118, 165, 175)", "rgb(109, 158, 235)", "rgb(111, 168, 220)", "rgb(142, 124, 195)", "rgb(194, 123, 160)",
				 "rgb(166, 28, 0)", "rgb(204, 0, 0)", "rgb(230, 145, 56)", "rgb(241, 194, 50)", "rgb(106, 168, 79)",
				 "rgb(69, 129, 142)", "rgb(60, 120, 216)", "rgb(61, 133, 198)", "rgb(103, 78, 167)", "rgb(166, 77, 121)",
				 "rgb(91, 15, 0)", "rgb(102, 0, 0)", "rgb(120, 63, 4)", "rgb(127, 96, 0)", "rgb(39, 78, 19)", 
				 "rgb(12, 52, 61)", "rgb(28, 69, 135)", "rgb(7, 55, 99)", "rgb(32, 18, 77)", "rgb(76, 17, 48)"]
			]
	  });
	}
	
	function zmienKolor(typ)
	{
		if($('.event-zaznaczony').length == 0) return false;
		var ids = [];
		var projekts = [];
		
		if(typ == 'czcionka')
		{
			var kolor = $('#kolorCzcionki').val();
			$.each($('.event-zaznaczony'), function(index, event){
				if($(this).hasClass('projekt'))
					projekts.push($(this).attr('data-id'));
				else
					ids.push( $(this).attr('data-id'));
				
				$(this).css('color', kolor);
			});
		}
		else if(typ == 'tlo')
		{
			var kolor = $('#kolorTla').val();
			$.each($('.event-zaznaczony'), function(index, event){
				if($(this).hasClass('projekt'))
					projekts.push($(this).attr('data-id'));
				else
					ids.push( $(this).attr('data-id'));
				
				$(this).css('background-color', $('#kolorTla').val());
			});
		}
		
		var dane = {
			ids: ids,
			kolor: kolor,
			typ: typ,
			projekts: projekts,
		};
		ajax("{{$urlZmienKolor}}" , potwierdzZmienKolor,  dane , 'POST', 'json' );
	}
	
	function potwierdzZmienKolor(dane)
	{
		if(dane.blad > 0)	alertModal('Error!', dane.komunikat);
	}
	
	function usunPrzypisanie()
	{
		$('.modal-header').find('.close').click();
		
		var usunPrzypisanie = [];
		var oddzielProjekt = [];
		if($('.event-zaznaczony').length)
		{
			$('.event-zaznaczony').each(function(){
				var id = $(this).attr('data-id');
				if($(this).hasClass('projekt'))
				{
					var idTeam = $(this).parent('.cal-team-data').attr('data-team');
					oddzielProjekt.push({
						idTeam: idTeam,
						idProjekt: id
					});
					
				}
				else
				{
					usunPrzypisanie.push(id);
				}
			});
			ajax("{{$urlUsunPrzypisanie}}" , potwierdzUsunPrzypisanie, { usun: usunPrzypisanie, usunProjekt: oddzielProjekt }, 'POST', 'json' );
		}
	}
	
	function potwierdzUsunPrzypisanie(dane)
	{
		if(dane.blad > 0)	alertModal('Error!', dane.error);
		
		var teamArray = [];
		var teamData = [];
		
		if(dane.usuniete.length)
		{
			$.each(dane.usuniete, function(index, value){
				var event = $('.event[data-id='+value+']');
				var team = event.attr('data-team');
				var data = event.attr('data-data');

				teamArray.push(team);
				( typeof teamData[team] == 'undefined' ) ? teamData[team] = [] : '';
				teamData[team] = data;
				event.remove();
			});
		}
		
		if(dane.usunieteProjekty.length)
		{
			$.each(dane.usunieteProjekty, function(index, values){
				var event = $('.event[data-id='+values.idZamowienie+'][data-team='+values.idTeam+']');
				if(event.hasClass('projekt'))
				{
					var data = event.attr('data-data');
					teamArray.push(values.idTeam);
					( typeof teamData[values.idTeam] == 'undefined' ) ? teamData[values.idTeam] = [] : '';
					teamData[values.idTeam] = data;
					event.remove();
				}
			});
		}
		
		$.each(teamData, function(index, value){ if(typeof value != 'undefined'){ rozmiescEventyWPolu(index, value);	} } );
		//for(var i = 0 ; i < teamArray.length ; i++) przeliczSzerokoscTeamu(teamArray[i]);
		
		$('#usunPotwierdzenie').find('.close').click();
	}
	
	function ustawZmianyIstnieja()
	{
		zaminyIstnieja = 1;
		$('#runButton').show();
	}
	
</script>
{{END}}
