{{BEGIN index}}
<div class="widget-box">
<div class="widget-title">
	<ul class="nav nav-tabs">
      {{BEGIN zakladka}}
      <li class="{{IF $active}}active{{END}}">
			<a class="{{IF $active}}active{{END}}" name="{{$etykieta}}" href="{{$url}}">{{$etykieta}} 
				{{IF $ilosc}}<span class="badge badge-success">{{$ilosc}}</span>{{END}}</a>
		</li>
      {{END}}
		<li>
			<a class="{{IF $active}}active{{END}}" name="{{$etykieta}}" href="{{$url}}">
				{{$etykieta}} 
			</a>
		</li>
	</ul>
	<div class="wysokosc"></div>
</div>
<div style="clear:both;"></div>
{{$formularzSzukaj}}
{{$tabela_danych}}
<script src="/_system/js/select2.js"></script>
<script type="text/javascript">
	 {{BEGIN select}}
		 $("select#{{$nazwaSelecta}}").select2();
	 {{END}}
</script>
<script type="text/javascript">
	$(document).ready(function () {
		
		$('#s2id_team').ready(function()
			{
				$('#s2id_team').css("display", "none");
			}
		);
		
		$('#bez_teamu').live('change', function(){
			
			if($(this).attr('checked'))
			{
				$('#s2id_team').css("display", "block");
			}
			else
			{
				$('#s2id_team').css("display", "none");
			}
			
		});
		
	});
</script>
</div>
{{END}}

{{BEGIN indexDrop}}
<script>
	$(function() {
		$(".maly-input" ).spinner({
			min: 0,
		});
	});
	
	var wystapilaZmiana = false;
	
	/**  drag and drop **/
	$(function() {

		$( ".column" ).sortable({
			items : ".portlet:not(.element_wylaczony, .element_wylacz)",
			connectWith: ".column",
			handle: ".zamowienie-naglowek",
			cancel: ".element_wylaczony, .element_wylacz",
			placeholder: "placeholder",
			cursor: "move",
			cursorAt: { left: 150 },
			tolerance: "pointer",
			helper: function(e,li) {
				if(li.attr('type') == 'get_project')
				{
					if($(e.currentTarget).attr('class') == "column column-team ui-sortable")
					{
						return li;
					}
					copyHelper = li.clone().insertAfter(li);
					return li.clone();
				}
				else
				{
					return li;
				}
		   },
			opacity: 0.8
			});
			
		$( ".column" ).on( "sortupdate", function( event, ui ) {
			
			// zliczamy ilosc zamowien
			 var paczkaZamowien = ui.item.parent(".column");
			 var iloscZamowien = paczkaZamowien.children(".portlet").size();
			 paczkaZamowien.prev().children('.ilosc_zamowien').html(iloscZamowien);
			 
			 // zliczamy ilosc godzin
			 var sumaGodzin = 0;
			 paczkaZamowien.children(".portlet").each(function(){
					sumaGodzin = sumaGodzin + (+$(this).find('.ilosc_godzin').val());
				}
			 )
			 paczkaZamowien.prev().children('.ilosc_godzin').html(sumaGodzin);
			 
			 var rodzic = ui.item.parents("form").attr("id");
			 if(rodzic == "teamlist")
			 {
				 ui.item.siblings('div').each(function(){
						if($(this).attr("id") == ui.item.attr('id'))
							$(this).remove();
				 });
				 ui.item.children(".zamowienie-naglowek").find(".box-naglowek > .icon-minus").toggleClass( "icon-minus icon-plus" );
				 ui.item.children(".zamowienie-opis").hide();
				 ui.item.children(".zamowienie-naglowek").find("a.usun_koordynatora").hide();
			 }
			 if(rodzic == "listaZamowienForm")
			 {
				
				ui.item.siblings('div').each(function(){
					if($(this).attr("id") == ui.item.attr('id'))
						$(this).remove();
				});
				 
				/*
				event.currentTarget.children('.portlet').each(function(){
						if($(this).attr("id") == ui.item.attr('id'))
							$(this).remove();
					});
					
				
				*/
				//paczkaZamowien.find('#'+ui.item.attr('id')).remove();
				
				ui.item.children(".zamowienie-naglowek").find(".box-naglowek > .icon-plus").toggleClass( "icon-plus icon-minus" );
				ui.item.children(".zamowienie-opis").show();
				ui.item.children(".zamowienie-naglowek").find("a.usun_koordynatora").show();
			 }
			 wystapilaZmiana = true;
		} );
		
		$( ".column" ).on( "sortover", function( event, ui ) {
			
			var paczkaZamowien = ui.item.parent(".column");
			var iloscZamowien = paczkaZamowien.children(".portlet").size();
			paczkaZamowien.prev().children('.ilosc_zamowien').html((iloscZamowien-1));
			 
			// zliczamy ilosc godzin
			var sumaGodzin = 0;
			paczkaZamowien.children(".portlet").each(function(){
				  sumaGodzin = sumaGodzin + (+$(this).find('.ilosc_godzin').val());
			  }
			)
			var zabierzIloscGodzin = ui.item.children('.ilosc_godzin').val();
			sumaGodzin = sumaGodzin - (+zabierzIloscGodzin);
			paczkaZamowien.prev().children('.ilosc_godzin').html(sumaGodzin);
			
			
			var idTeamTmp = event.delegateTarget.id;
			var tmp = idTeamTmp.toString().split('_');
			 
			var idZam = ui.item.context.id;
			ui.item.children(".zamowienie-opis").find("input#idZamTeam_"+idZam).val(tmp[1]);
			wystapilaZmiana = true;
		} );
		
		$( ".column" ).on( "sortstart", function( event, ui ) {
			if (ui.item.hasClass("zablokuj_przenoszenie")) {
				$(".column" ).sortable("option", "connectWith", false);
            $(".column" ).sortable("refresh");
			}
			$('.listaZamowien').addClass('sortowanieAktywne');
			$('.column-team').addClass('sortowanieAktywne');
		} );
		
		$( ".column" ).on( "sortstop", function( event, ui ) {
			ui.item.siblings('div').each(function(){
					if($(this).attr("id") == ui.item.attr('id'))
						$(this).remove();
				});
			$(".column" ).sortable("option", "connectWith", ".column");
			$(".column" ).sortable("refresh");
			$('.listaZamowien').removeClass('sortowanieAktywne');
			$('.column-team').removeClass('sortowanieAktywne');
		} );

		$( ".portlet" )
		.addClass( "ui-widget ui-widget-content ui-helper-clearfix ui-corner-all" )
		.find( ".zamowienie-naglowek" )
		.addClass( "ui-widget-header ui-corner-all" );

		$( ".icon-minus" ).live('click', function() {
			var icon = $( this );
			icon.toggleClass( "icon-minus icon-plus" );
			icon.closest( ".portlet" ).find( ".zamowienie-opis" ).toggle();
			});
		$( ".icon-plus" ).live('click', function() {
			var icon = $( this );
			icon.toggleClass( "icon-plus icon-minus" );
			icon.closest( ".portlet" ).find( ".zamowienie-opis" ).toggle();
		});
			
		$(".icon-minus-sign").click(function() {
			var icon = $( this );
			icon.toggleClass( "icon-minus-sign icon-plus-sign" );
			icon.parent( "div" ).next().toggle();
		});
	});
	
	/** zwijanie i rozwijanie całych regionów **/
	$("#toogle").live('click', function() {
		var etykieta = $(this).text();
		
		if(etykieta == "{{$rozwin_zamowienia_etykieta}}")
		{
			$(this).text("{{$zwin_zamowienia_etykieta}}");
			$(this).attr("data-original-title", "{{$zwin_zamowienia_etykieta}}");
			$(".listaZamowien  > .zamowienie > .zamowienie-opis").show(500);
			$(".listaZamowien  > .zamowienie > .zamowienie-naglowek").find("i:first").removeClass("icon-plus").addClass("icon-minus");
			
		}
		else
		{
			$(this).text("{{$rozwin_zamowienia_etykieta}}");
			$(this).attr("data-original-title", "{{$rozwin_zamowienia_etykieta}}");
			$(".listaZamowien  > .zamowienie > .zamowienie-opis").hide(500);
			$(".listaZamowien  > .zamowienie > .zamowienie-naglowek").find("i:first").removeClass("icon-minus").addClass("icon-plus");
		}
	})
	
	$(".rozwin_dla_teamu").live('click', function(){
		
		var etykieta = $(this).text();
		if(etykieta == "{{$rozwin_zamowienia_team}}")
		{
			var id = $(this).attr('rel');
			$("#team_"+id).find(".portlet > .zamowienie-opis").show(500);
			$("#team_"+id).children(".portlet").find("i:first").removeClass("icon-plus").addClass("icon-minus");
			
			$(this).text("{{$zwin_zamowienia_team}}");
			$(this).attr("data-original-title", "{{$zwin_zamowienia_team}}");
			
		}
		else
		{
			var id = $(this).attr('rel');
			$("#team_"+id).find(".portlet > .zamowienie-opis").hide(500);
			$("#team_"+id).children(".portlet").find("i:first").removeClass("icon-minus").addClass("icon-plus");
			
			$(this).text("{{$rozwin_zamowienia_team}}");
			$(this).attr("data-original-title", "{{$rozwin_zamowienia_team}}");
		}
		
	});
	
	$("#toogle_team").live('click', function() {
		var etykieta = $(this).text();
		
		if(etykieta == "{{$rozwin_team_etykieta}}")
		{
			$(this).text("{{$zwin_team_etykieta}}");
			$(this).attr("data-original-title", "{{$zwin_team_etykieta}}");
			$(".team  > .column-team").show(200);
			$(".team  > .team-naglowek").find("i.icon-plus-sign").removeClass("icon-plus-sign").addClass("icon-minus-sign");
		}
		else
		{
			$(this).text("{{$rozwin_team_etykieta}}");
			$(this).attr("data-original-title", "{{$rozwin_team_etykieta}}");
			$(".team  > .column-team").hide(200);
			$(".team  > .team-naglowek").find("i.icon-minus-sign").removeClass("icon-minus-sign").addClass("icon-plus-sign");
		}
	})
	
	
	$('#zaczep').live('click', function(){
		$(this).children('i').toggleClass('icon-unlink');
		$(this).parents("#przeniesienie").toggleClass("move");
	})
	
	
	$('.zaczep').live('click', function(){
		var idteamu = $(this).attr('id').split('_');
		
		var element_float = $("#teamId_"+idteamu[1]);
		if (element_float.hasClass('move'))
		{
			$(this).children('i').removeClass('icon-unlink');
			element_float.removeClass('move');
			element_float.find('.column').css({maxHeight: '100%', overflowY: 'inherit'});
			$('.team').removeClass('faded');
			$('.team .column-team, .duzy-widok').addClass('column').find('.zamowienie').removeClass('element_wylacz');
		}
		else
		{
			var max_h = $(window).height() - 150;
			$(this).children('i').addClass('icon-unlink');
			$('.team').removeClass('move').addClass('faded');
			element_float.addClass('move').removeClass('faded').find('.column-team').addClass('column');
			element_float.find('.column').css({maxHeight: max_h+'px', overflowY: 'auto'});
			element_float.find('.zamowienie').removeClass('element_wylacz');
			var pojemnikiWylaczone = $('.team:not(.move, .duzy-widok)').find('.column');
			element_float.width(pojemnikiWylaczone.width());
			pojemnikiWylaczone.removeClass('column').find('.zamowienie').addClass('element_wylacz');
		}
	})
	
	$('.powieksz').live('click', function(){
		var team = $(this).parents('.team');
		var klasa = team.attr('class');
		
		if(!team.hasClass('duzy-widok'))
		{
			team.addClass('duzy-widok').css('width', '45%');
			var max_h = $(window).height() - 180;
			$('.team:not(.duzy-widok)').addClass('faded').find('.powieksz').hide();
			$('.team:not(.duzy-widok) .column-team').removeClass('column').find('.zamowienie').addClass('element_wylacz');
			team.removeClass('faded').find('.column-team').addClass('column');
			team.removeClass('move');
			team.find(".zaczep").css("display", "none");
			team.find('.column').css({maxHeight: max_h+'px', overflowY: 'auto'});
			$(this).children(".icon").toggleClass('icon-zoom-out icon-zoom-in');
			$(this).attr('data-original-title', "{{$zmniejsz_etykieta}}");
			$(this).parent().find('img').each(function(){
				var src = $(this).attr('src');
				var srcZmiana = src.replace('xs', 'min');
				$(this).attr('src', srcZmiana);
			});
		}
		else
		{
			$('.team').removeClass('faded').find('.zamowienie').removeClass('element_wylacz');	
			$('.column-team').addClass('column');
			$('.team').find('.powieksz').show();
			team.find(".zaczep").css("display", "block");
			team.find('.column').css({maxHeight: '100%', overflowY: 'inherit'});
			$(this).children(".icon").toggleClass('icon-zoom-in icon-zoom-out');
			$(this).attr('data-original-title', "{{$powieksz_etykieta}}");
			$(this).parent().find('img').each(function(){
				var src = $(this).attr('src');
				var srcZmiana = src.replace('min', 'xs');
				$(this).attr('src', srcZmiana);
			});
			var szerokosc = $('#przeniesienie').width();
			$('.duzy-widok').removeClass('duzy-widok').css('width', szerokosc+'px');
		}
	})
	
</script>

<script type="text/javascript">

/**  Obsluga ajax notatek **/
	var linkGlobal;

	function otworzOkno(link)
	{
		linkGlobal = link;
		
		$.ajax({
				url: link,
				type: 'POST',
				dataType: 'html',
				async: true,
				success: function(dane) {
					$('#oknoModalne .modal-body').html(dane);
					$('#oknoModalne').modal('show');
					$('#oknoModalne .modal-body, #oknoModalne .modal-body iframe html').css('background', 'none');
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
		})
		return false;
	}
	
	function aktualizujNotatki(idObiektu)
	{

		var url = {{$linkAktualizujNotatki}} + "&id=" + idObiektu ;
		
		$('#'+idObiektu).children(".zamowienie-opis").find(".opis > .notatki").html('<div class="spinner"></div>');
		$.ajax({
			url: url ,
			type: 'GET',
			dataType: 'html',
			async: true,
			success: function(dane) {
				$('#'+idObiektu).children(".zamowienie-opis").find(".opis > .notatki").html(dane);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}
		})
		return false;
	}
	
	function usunNotatka(link)
	{
		var linkAjax = link;
		
		$.ajax({
				url: linkAjax,
				type: 'POST',
				dataType: 'json',
				async: true,
				success: function(dane) {
					$('#oknoModalne #tabela').html(dane.grid);
					aktualizujNotatki(dane.idObiekt);
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
		})
		return false;
	}
	
	function liczIloscZamowien(divIdTeam)
	{
		var paczkaZamowien = $('#team_'+divIdTeam);
		var iloscZamowien = paczkaZamowien.children(".portlet").size();
		paczkaZamowien.prev().children('.ilosc_zamowien').html(iloscZamowien);
	}
	function liczIloscGodzin(divIdTeam)
	{
		var sumaGodzin = 0;
		var paczkaZamowien = $('#team_'+divIdTeam);
		paczkaZamowien.children(".portlet").each(function(){
			  sumaGodzin = sumaGodzin + (+$(this).find('.ilosc_godzin').val());
		  }
		)
		paczkaZamowien.prev().children('.ilosc_godzin').html(sumaGodzin);
	}
	function przydzielEkipie(idDoPrzeniesienia, idEkipy, type)
	{
		wystapilaZmiana = true;
		console.log(wystapilaZmiana);
		
		if(type == "get_project")
		{
			var istnieje = 0;
			$('#team_'+idEkipy).children('div').each(function(){
				if($(this).attr('id') == idDoPrzeniesienia)
					istnieje = 1;
			});
			if(!istnieje)
			{
				$("#"+idDoPrzeniesienia).fadeOut( "slow", function(){
						
				});
				var nowy = $("#"+idDoPrzeniesienia).clone().appendTo('#team_'+idEkipy);
				$("#"+idDoPrzeniesienia).fadeIn('slow');
				 
					nowy.children(".zamowienie-opis").find("input#idZamTeam_"+idDoPrzeniesienia).val(idEkipy);
					nowy.children(".zamowienie-naglowek").find(".box-naglowek > .icon-minus").toggleClass( "icon-plus icon-minus" );
					nowy.find("a[rel='#"+idDoPrzeniesienia+"']").hide();
				 
			}
			return;
		}
		
		$("#"+idDoPrzeniesienia).fadeOut( "slow", function(){
			
			if(type == "prepend")
			{
				$("#"+idDoPrzeniesienia).prependTo('#team_'+idEkipy);
			}
			else
			{
				$("#"+idDoPrzeniesienia).appendTo('#team_'+idEkipy);
			}
			
			
			$("#"+idDoPrzeniesienia).fadeIn( "slow", function(){
				  //$("#"+ele).children(".zamowienie-naglowek").animate({ backgroundColor : "#ADFF2F"});
				  $("#"+idDoPrzeniesienia).children(".zamowienie-opis").find("input#idZamTeam_"+idDoPrzeniesienia).val(idEkipy);
				  $("#"+idDoPrzeniesienia).children(".zamowienie-naglowek").find(".box-naglowek > .icon-minus").toggleClass( "icon-plus icon-minus" );
				  $("a[rel='#"+idDoPrzeniesienia+"']").hide();
			  });
		});
	}
	
	$('.usun_koordynatora').live('click', function()
		{
			if (!confirm("{{$usun_koordynatora_confirm}}"))
				return false;
			
			var id = $(this).prop('rel').replace('#', '');
			var link = "{{$link_usun_koordynatora}}"+'&id='+id;

			$.ajax({
					url: link,
					type: "get",
					dataType: 'json',
					async: true,
					success: function(dane) {
						if(dane.kod == '1' )
						{
							if(dane.usun == 1)
							{
								$('#'+id).remove();
							}
							else
							{
								$('#'+id).find('.usun_koordynatora').remove();
							}
						}
						if(dane.kod == '2' )
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
		})
	
	$(document).ready(function () {
		
		$('.listaZamowien').height($('.row-fluid').height() - 170);
		$('#czysc_filtr').on('click', function()
		{
			$('#filter').val('').keyup();
			$('label[for=team]').attr('style', 'color:#333333');
			$('.error_ekipa').hide();
		});
		
		$('#przenies_szukane').on('click', function(){
			
			var obiektDoPrzeniesienia = $('.listaZamowien').find('div.portlet:visible').attr('id');
			var typePrzeniesienia = $('.listaZamowien').find('div.portlet:visible').attr('type');
			
			var ekipa = $('select#team').val();
			if(ekipa > 0)
			{
				przydzielEkipie(obiektDoPrzeniesienia, ekipa, typePrzeniesienia);
				setTimeout(function(){
					liczIloscZamowien(ekipa);
					liczIloscGodzin(ekipa);
				}, 1000);
				
				$('label[for=team]').attr('style', 'color:#333333');
				$('.error_ekipa').hide();
				$('#czysc_filtr').click();
			}
			else
			{
				$('label[for=team]').attr('style', 'color:#B94A48');
				$('.error_ekipa').show();
			}
		})
		
		$("#filter").keyup(function(){
 
	      var filter = $(this).val(), count = 0;
	 		if(filter.length > 0)
			{
				 $('#czysc_filtr').show('500');
			}
			else
			{
				$('#czysc_filtr').hide('500');
			}
			
			$(".listaZamowien .zamowienie-naglowek").each(function(){
				if($(this).text().search(new RegExp(filter, "i")) < 0)
				{
	         	$(this).parent('.portlet').fadeOut();
				}
				else 
				{
					$(this).parent('.portlet').show();
					count++;
	      	}
			});
			
			if(count == 1)
			{
				$('#przenies_szukane').show('500');	 
			}
			else
			{
				$('#przenies_szukane').hide('500');
			}
			var numberItems = count;
			$("#filter-count").text("{{$znaleziono_zamowien}}"+count);
		});

		$("select#listaTeamowSelect").select2();
		
		$('#wstecz').live('click', function(e){
			$('#oknoModalne').modal('hide');
		});
		
		$("#odwiez").live('click', function()
		{
			$.ajax({
					url: $(this).val(),
					type: "get",
					dataType: 'json',
					async: true,
					success: function(dane) {
						if(dane.kod == '1' )
						{
							$(".listaZamowien").prepend(dane.lista_zadan);
							$(".maly-input" ).spinner();
							$("#odwiez").attr("value", dane.link_aktualizuj);
							dane.id_zamowien.forEach(function(ele, id) {
								$("#"+ele).stop().animate({opacity: 1 }, 1000);
							});
						}
						if(dane.kod == '2' )
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
		
		$("#listaZamowienForm").live('submit', function() {
			
			var type = "preppend";
			if($(this).attr('type') != '')
			{
				type = $(this).attr('type');
			}
			
			$.ajax({
				url: {{$linkZapiszPrzydzielenie}},
				type: $('#listaZamowienForm').attr('method'),
				data: $('#listaZamowienForm').serialize(),
				dataType: 'json',
				async: true,
				success: function(dane) {
					
					if(dane.kod == '1' )
					{
						var divIdTeam = "#team_"+dane.idEkipy;
						
						dane.idZamowienPrzydzielonych.forEach(function(ele, id) {
							przydzielEkipie(ele, dane.idEkipy, type);
						});
						setTimeout(function(){
							// zliczamy ilosc zamowien
							liczIloscZamowien(dane.idEkipy);
							// zliczamy ilosc godzin
							liczIloscGodzin(dane.idEkipy);
							
						}, 1000);
						
					}
					if(dane.kod == '2' )
					{
						$('#oknoModalne .modal-body').html(dane.error);
						$('#oknoModalne').modal('show');
					}

				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
			})
			return false;
		})
		
		$('#filtrujPrzydzielenie').live('submit', function()
		{
			$(".modal-backdrop").fadeIn("fast");
			var daneDoWyslania = $('#teamlist').serialize()+'&'+$('#filtrujPrzydzielenie').serialize()+'&'+$('#listaZamowienForm').serialize();
			
			$.ajax({
					url: "{{$linkAjaxSzukaj}}",
					type: $('#filtrujPrzydzielenie').attr('method'),
					data: daneDoWyslania,
					dataType: 'json',
					async: true,
					success: function(dane) {
						$(".modal-backdrop").fadeOut("fast");
						if(dane.kod == '1' )
						{
							$('.listaZamowien').children('.portlet').remove().animate({opacity: 0 }, 1000);
							$(".listaZamowien").prepend(dane.lista_zadan);
							$(".maly-input" ).spinner();
							$('#filter-count').text("{{$znaleziono_zamowien}}"+dane.ilosc_wynikow);
						}
						if(dane.kod == '2' )
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
		
		$('#czysc').live('click', function(){
			$('#date_start_od').val('');
			$('#date_start_do').val('');
			$('#filtrujPrzydzielenie').submit();
		});
		
		$("#notes_form").live('submit', function() {
		$.ajax({
			url: linkGlobal,
			type: $('#notes_form').attr('method'),
			data: $('#notes_form').serialize(),
			dataType: 'json',
			async: true,
			success: function(dane) {
				
				if(dane.kod == '1' )
				{
					$('#miejsceNaFormularz').html(dane.info);
				}
				if(dane.kod == '2' )
				{
					$('#oknoModalne #tabela').html(dane.notatka);
					$('#miejsceNaFormularz').html(dane.formularz);
					if (linkGlobal.indexOf("editNote") >= 0)
					{
						$('#oknoModalne').attr('aria-hidden', 'true');
						$('#oknoModalne').modal('hide');
						window.location.reload();
					}
					else
					{
						aktualizujNotatki(dane.idObject);
					}
				}
				
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}
			}
		)
			return false;
	})

	$('#s2id_listaTeamowSelect').css('display', 'inline').css('float', 'none');
	 
		$('#zapisz_przydzielenie').live('click', function(){
			window.onbeforeunload = null;
			$('.mobile-loader').fadeIn("normal");
			var przydzielenia = {};
			$('.team').each(function(){
				var idTeamu = $(this).attr('id').replace('teamId_', '');

				$(this).find('input[value="'+idTeamu+'"][name^="idZamTeam_"]').each(function(){
					
					if(typeof przydzielenia[idTeamu] === 'undefined')
						przydzielenia[idTeamu] = [];
					
					var idZam = $(this).attr('id').replace('idZamTeam_', '');
					przydzielenia[idTeamu].push(idZam);
					
					});
			});
			
			$.ajax({
				url: '{{$url_zapisz_przydzielenie}}',
				type: 'POST',
				dataType: 'json',
				data: przydzielenia,
				async: true,
				success: function(dane) {
					
					if(dane.kod == 1)
					{
						alertModal('Info' , dane.info);
						setTimeout(function(){
							location.reload();
						}, 2000);
					}
					else
					{
						alertModal('Error!' , dane.info);
					}
					
					$('.mobile-loader').fadeOut("normal");
				},
				error: function (xhr, ajaxOptions, thrownError) {
					var error = 'Error: '+xhr.status;
					if (thrownError != '') 
					{
						error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
						error += xhr.responseText;
					}
					alertModal('AJAX request error' ,error);
					$('.mobile-loader').fadeOut("normal");
				}
			});
			return false;
		});
		
	window.onbeforeunload = function(){
			if(wystapilaZmiana)
			{
				return '{{$komunikat_opuszczenie_strony}}';
			}
		};
	$('#s2id_team').ready(function()
		{
			$('#s2id_team').css("width", "600");
		}
	);
});
  
</script>

<div class="widget-box container_{{$type}}">
	<div class="widget-title">
		<ul class="nav nav-tabs">
			{{$zakladki}}
		</ul>
	</div>
	<div class="widget-content">
		<button id="toogle" class="btn btn btn-warning btn-xs tip-top fL" data-original-title="{{$zwin_zamowienia_etykieta}}" style="margin:0px 0px 8px;">
			{{$zwin_zamowienia_etykieta}}
		</button>
		<button id="odwiez" value="{{$linkOdswiezListe}}" class="btn btn btn-warning btn-xs tip-top fL" data-original-title="{{$linkOdswiezListeEtykieta}}" style="margin:0px 5px 8px;">
			{{$linkOdswiezListeEtykieta}}
		</button>
		{{$formularzWyszukaj}}
		<button id="toogle_team" class="btn btn btn-warning btn-xs tip-top fR" data-original-title="{{$zwin_team_etykieta}}" style="margin:0px 0px 8px;">
			{{$zwin_team_etykieta}} 
		</button>
		<div class="clear"></div>
		{{$formularz_filtruj}}
		<div class="clear"></div>
		<span class="help-inline error_ekipa" style="margin-left:160px; display: none;" for="ekipa">{{$nie_wybrano_ekipy}}</span>
		<div class="clear"></div>
	</div>
	<form id="listaZamowienForm" method="POST" type="{{$type}}">
		<div  class="element_wylaczony team" id="przeniesienie" >
			<div class="team-naglowek control-group  widget-title">
				<i class="icon-group"></i> {{$wybierz_ekipe_label}}
				<a id="zaczep" href="javascript:void(0);" class="tip-left fR" data-original-title="{{$zaczep_etykieta}}">
					<i class="icon icon-paper-clip"></i>
				</a>
			</div>
			<div class="element_wylaczony"  >
				<select id="listaTeamowSelect" name="listaTeamowSelect" style="float:left;">
					{{$listaEkipSelect}}
				</select>
				<div class="clear"></div>
				<input id="zapiszAjax" class="btn btn-primary" type="submit" value="{{$zapiszWartosc}}" name="zapisz" style="margin-top:5px;">
			</div>
		</div>
	<div  id="listaZamowien">
		<div class="widget-title">
			<span class="icon">
				<i class="icon icon-briefcase"></i>
			</span>
			<h5>{{$lista_zamowien_naglowek}}</h5>
			<span id="filter-count" class="label label-info tip-left">{{$ilosc_orderow}}</span>
		</div>
		<div class="column listaZamowien">
		{{$listaZamowien}}
		</div>
	</div>
</form>
	
<div id="teamyContainer">
<form id="teamlist" method="POST" action="{{$linkPrzydzielZamowienia}}">
<input type="hidden" name="type" value="{{$type}}" />
{{$listaEkip}}
<div class="assignBox">
	<div class="formularz_stopka form-actions">
	<input id="zapisz_przydzielenie" class="btn btn-primary" type="submit" value="{{$zapisz_input}}" name="zapisz_przydzielenie" >
	</div>
</div>
</form>
	<div class="clear"></div>
</div>
<script src="/_system/js/jquery-ui-1.10.4.custom.js"></script>
{{END}}

{{BEGIN zakladki}}
	<li class="{{$class}}">
		<a class="tip-top {{$class}}" href="{{$link}}" name="{{$tag}}" title="{{$tag}}" >{{$tag}} ({{$ilosc}})</a>
	</li>
{{END}}
			
{{BEGIN listaZamowien}}
<div type="{{$type}}" class="portlet {{$type}} {{IF $apartamenty}}element_wylaczony{{END}} {{IF zalogowany}}element_wylaczony{{END}} {{IF zablokujPrzenoszenie}} zablokuj_przenoszenie {{ELSE}}zamowienie{{END}}" id="{{$id_zamowienia}}" {{IF opacity}}style="opacity:0;"{{END}} >
	<input name="ilosc_godzin" class="ilosc_godzin" type="hidden" value="{{$ilosc_godzin}}" >
	<div class="zamowienie-naglowek {{$type}}" style="background-color:{{$tlo_zamowienia}}" >
		<div class="naglowki">
		<div class="box-naglowek" >
			<i class='{{IF zwiniety}}icon-plus{{ELSE}}icon-minus{{END}} cursorPointer'></i>
			<span class="label label-info" data-original-title="{{$number_order_get}} {{$tlumaczenie_bkt_id}}{{$id_zamowienia}}" >{{IF $type == "get_project"}}<i class="icon icon-crop"></i>{{END}} {{$number_order_get}} {{$tlumaczenie_bkt_id}} {{$id_zamowienia}} </span>
			{{$typ_zamowienia}} {{$order_name}} 
			{{IF $apartamenty}}
			<span class="current"><i class="icon-time tip-top" ></i> {{$ilosc_dzieci_biezace}} </span> / <span class="total tip-top" ><i class="icon-home"></i> {{$ilosc_dzieci}} </span>
			({{$dataApartamenty}})
			{{END}}
		</div>
		<div class="box-naglowek" >
			<i class="icon-time"></i> {{$godziny_pracy}} ({{$dataStart}}){{IF $ilosc_godzin}} <strong>{{$ilosc_godzin}}h</strong>{{END IF}}
		</div>
		<div class="box-naglowek" >
			{{UNLESS $type == "get_project"}}
			<i class="icon-home"></i> <span class="tip-top" data-original-title="{{$pelny_adres}}" >{{$adres}} </span>
			{{END}}
			</div>
		</div>
		<div class="naglowkiAkcje">
			{{IF $id_koordynator}}
			<a href="" rel="#{{$id_zamowienia}}" class="fR usun_koordynatora btn btn-danger tip-left" title="{{$usun_koordynatora_title}}" style="margin-left : 10px; font-size: 15px; {{IF $zwiniety}}display:none{{END}}">
				<i class="icon icon-remove-circle" ></i>
			</a>
			{{END}}
			
			{{IF $type == "get_project"}}
				{{IF zamowienieZapartamentami}}
				<a href="{{$linkListaApartamentow}}" class="fR btn listaApartamenty tip-top" title="{{$lista_apartamentow_title}}" style="margin-left : 6px;">
				<i class="icon-list"></i>
				</a>
				{{END}}
				{{IF $url_import_apartamentow}}
				<a href="{{$url_import_apartamentow}}" onclick="modalAjax(this.href); return false;" class="fR btn import tip-top" title="{{$import_apartamentow_title}}" style="margin-left : 6px;">
				<i class="icon-cloud-upload"></i>
				</a>
				{{END IF}}
				{{IF $url_generuj_pdf}}
				<a href="{{$url_generuj_pdf}}" class="fR btn tip-top" title="{{$etykieta_generuj_pdf}}" style="margin-left : 6px;">
				<i class="icon-file"></i>
				</a>
				{{END IF}}
			{{END IF}}
			<a href='{{$link_podglad_zamowienia}}' onclick="modalAjax(this.href); return false;" class="fR btn tip-left" data-original-title="{{$etykieta_podglad_zamowienia}}" >
				<i class="icon-search"></i>
			</a>
			{{IF $apartamenty}}
			<a href='{{$link_przydziel_apartamenty}}'class="fR btn tip-left" style="margin-right: 3px;" data-original-title="{{$etykieta_przydziel_apartamenty}}" >
				<i class="icon-sitemap"></i>
			</a>
			{{END IF}}
		</div>
		<div class="clear"></div>
	</div>
	<div class="zamowienie-opis">
		<div class="pozycja">
			{{IF $apartamenty}}
			{{ELSE}}
			<input id="idZam_{{$id_zamowienia}}" class="maly-input" value="" name="idZam_{{$id_zamowienia}}" >
			<input id="type_{{$id_zamowienia}}" type="hidden" value="{{$type}}" name="type_{{$id_zamowienia}}" >
			<input id="idZamTeam_{{$id_zamowienia}}" type="hidden" value="{{$id_team}}" name="idZamTeam_{{$id_zamowienia}}[]" >
			<a class="btn btn btn-info tip-top btn-xs" data-original-title="Add note" href="{{$linkAjaxNote}}" onclick="return otworzOkno(this.href);" style="margin: 5px 0;" >
				<i class="icon icon-plus-sign"></i> {{$tlumaczenie_dodaj_notatke}}
			</a>
			{{END}}
		</div>
		<div class="opis">
			<p>{{$opis_prac}}</p>
			<div class="notatki" style="color:#800000">
				{{$notatki}}
			</div>
		</div>
	</div>
</div>
{{END}}

{{BEGIN listaTeamow}}
<div class="team" id="teamId_{{$id_teamu}}" >
	<div class="team-naglowek control-group  widget-title">
		<a href="javascript:void(0);" class="tip-left powieksz" data-original-title="{{$powieksz_etykieta}}" id="teamPowieksz_{{$id_teamu}}" >
			<i class="icon icon-zoom-in"></i>
		</a>
		<i class='icon-minus-sign cursorPointer'></i>
		<strong class="tip top" data-original-title="{{$umiejetnosciEkipy}}" > {{$nazwa_teamu}} </strong>
		{{$lista_pracownikow}}
		( {{$ilosc_zamowien_etykieta}} <span class="ilosc_zamowien">{{$iloscPrzydzielonychZamowien}}</span> {{$ilosc_godzin_etykieta}} <span class="ilosc_godzin">{{$totalTime}}</span> )
		<input type="hidden" name="team[]" value="{{$id_teamu}}" />

		<a href="javascript:void(0);" class="tip-left zaczep fR" data-original-title="{{$zaczep_etykieta}}" id="teamZaczep_{{$id_teamu}}" >
			<i class="icon icon-paper-clip"></i>
		</a>
		<span class="rozwin_dla_teamu" rel="{{$id_teamu}}" >{{$rozwin_zamowienia_team}}</span>
	</div>
	<div class="column column-team" id="team_{{$id_teamu}}" >
		{{$lista_zamowien_teamu}}
	</div>
</div>
{{END}}

{{BEGIN listaEkipSelectSzablon}}
<option value="{{$id_ekipy}}"> {{$nazwa_ekipy}} </option>
{{END}}

{{BEGIN listaPracownikowZdjecie}}
<img src="{{$zdjecie}}" class="tip top" {{IF lider}}style="border:1px solid #ff0000;"{{END}} alt="{{$pracownik}}" data-original-title="{{$pracownik}}" rel="comm-{{$id}}"/>
{{END}}
{{BEGIN listaPracownikow}}
<span class="tip top" alt="{{$pracownik}}" data-original-title="{{$pracownik}}" >{{$pracownik}}</span>
{{END}}


{{BEGIN mail_zamowienia}}
		<h1 style = "font-size: 18px; padding-bottom: 7px; text-align: left; color:#800000;" >{{$przydzielenie}}</h1>
		{{$zamowienia_lista}}
{{END}}

{{BEGIN zamowienie_informacje}}
<table style="border-bottom: 2px solid #2F4F4F; margin-bottom: 8px; width:100%;">
	<tbody>
		<tr >
			<td style="width: 20%; border-bottom: 1px dotted #ccc; padding:10px 15px 16px 0px;"  valign="top"><strong>{{$tytul_naglowek}} </strong> </td>
			<td style="border-bottom: 1px dotted #ccc; padding:10px 15px 16px 0px" valign="top" >{{$zamowienie_tytul}}</td>
		</tr>
		<tr>
			<td style="border-bottom: 1px dotted #ccc; padding:10px 15px 16px 0px" valign="top" ><strong>{{$naglowek_adres}}</strong> </td>
			<td style="border-bottom: 1px dotted #ccc; padding:10px 15px 16px 0px" valign="top" >{{$adres_informacje}}</td>
		</tr>
		<tr>
			<td style="border-bottom: 1px dotted #ccc; padding:10px 15px 16px 0px" valign="top" ><strong>{{$naglowek_opis}}</strong> </td>
			<td style="border-bottom: 1px dotted #ccc; padding:10px 15px 16px 0px" valign="top" >{{$zamowienie_opis}}</td>
		</tr>
		<tr>
			<td valign="top"  style="padding:10px 15px 16px 0px" ><strong>{{$naglowek_produkty}}</strong> </td>
			<td valign="top" style="padding:10px 15px 16px 0px" >{{$zamowienie_produkty}}</td>
		</tr>
	</tbody>
</table>
{{END}}

{{BEGIN mail_produkty}}
	<table >
		<tbody>
			{{$lista_produktow}}
		</tbody>
	</table>
{{END}}
{{BEGIN lista_produktow}}
		<tr>
			<td style="padding: 0px 8px 5px 0px">{{$nazwa}}</td>
			<td style="padding: 0px 8px 5px 0px">{{$ilosc}}</td>
		</tr>
{{END}}
{{BEGIN lista_produktow_suma}}
		<tr>
			<td style="padding: 0px 8px 5px 0px; border-bottom: 1px dotted #ccc;">{{$nazwa}}</td>
			{{UNLESS $projekt}}<td style="padding: 0px 8px 5px 0px; border-bottom: 1px dotted #ccc;">{{$ilosc}}</td>{{END}}
		</tr>
{{END}}
{{BEGIN mail_suma_produktow}}
	<table style="background: #FFFAFA; width: 50%; border-spacing: 10px; border:1px solid #FAEBD7; " >
		<thead>
			<th style="text-align: left; border-bottom: 1px solid #ccc;" >{{$produkt_naglowek}}</th>
			{{UNLESS $projekt}}<th style="text-align: left; border-bottom: 1px solid #ccc;" >{{$ilosc_naglowek}}</th>{{END}}
		</thead>
		<tbody>
			{{$lista_produktow}}
		</tbody>
	</table>
{{END}}
</div>
{{BEGIN przydzielApartamenty}}
<script src="/_system/js/bootstrap-editable.min.js"></script>
	<script type="text/javascript">
		
		function setWidth()
		{
			$('#konfiguracja').css({
				width: ($('#kontener').width() - $('#lista-apartamentow').width()-30)+'px'
			});
		}
		
		function setLayout(pos)
		{
			var wymiar = pos-$window.scrollTop();
			if (wymiar < 10)
			{
				przesuniecie = 10;
				wysokosc = $window.height() - 20;
			}
			else
			{
				przesuniecie = wymiar;
				wysokosc = $window.height() - wymiar - 10;
			}

			$('#konfiguracja-apartamentow .konfiguracja').css({
				top: przesuniecie+'px'
				//height: wysokosc+'px'
			});
			$('#konfiguracja-apartamentow .konfiguracja .widget-content').css({
				height: (wysokosc-38)+'px'
			});
		}
		
		$window = $(window);
		$(document).ready(function(){
			setWidth();
		});
	
		var selectTeam = '<li class="add"><select class="team-select" style="width: 120px;" name="team-select"><option>-select-</option>{{BEGIN teamSelect}}<option value="{{$idTeamu}}">{{$nazwaTeamu}}</option>{{END}}</select></li>'
		
		function aktualizujNotatki ()
		{
			
		}
		
		function usunNotatka(link)
		{
			$.ajax({
					url: link,
					type: 'POST',
					dataType: 'json',
					async: true,
					success: function(dane) {
						$('#oknoModalne #tabela').html(dane.grid);
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.status);
						alert(thrownError);
					}
			})
			return false;
		}
		
		$(document).ready(function () {
			
			$('.editable').editable({
				emptytext: '',
				mode: 'inline',
				pk: function(){
					return $(this).attr('id').replace('i-', '');
				},
				url: '{{$linkZmienHnummer}}'
			});
		
			$('.zaznacz').live('click', function(){
				if($('#autoCzas').is(':checked') ||	$('#autoData').is(':checked') || $('#autoTeam').is(':checked'))
				{
					przydzielFullAutomat($(this).parents('tr').attr('id').replace("id_", ""));
				}
				else
				{
					przypiszKonfiguracjeDoApartamentu($(this));
				}
			});
			
			$('#ukryjWypelnione').live('click', function(){
				ukryjWypelnione();
				$('#pokazWypelnione').show(500);
				return false;
			});
			
			$('#pokazWypelnione').live('click', function(){
				pokazWypelnione();
				$(this).hide(500);
				return false;
			});
			
			$('.dodaj-czas').live('click', function(){
				
				var wartoscPoprzednia = $(this).parent('li').prev('li').children('span').text();
				var godziny = wartoscPoprzednia.split(' - ');
				
				var time = '<li class="add" style="width: 200px;">\n\
							<div class="input-append bootstrap-timepicker" style="width: 85px; float: left;">\n\
								<input id="godzinaOd" style="width: 40px;" class="timepicker input-small long" type="text" data-minute-step="15" value="'+godziny[0]+'" name="godzinaOd">\n\
								<span class="add-on"><i class="icon-time"></i></span>\n\
							</div>\n\
							<div class="input-append bootstrap-timepicker" style="float: left;">\n\
								<input id="godzinaDo" style="width: 40px;" class="timepicker input-small long" type="text" data-minute-step="15" value="'+godziny[1]+'" name="godzinaOd">\n\
								<span class="add-on"><i class="icon-time"></i></span>\n\
							</div>\n\
						</li>';
				$(this).parent('li').before(time);
				var opts = {showMeridian: false, defaultTime: false};
				$(".timepicker").timepicker(opts);
				
				$(this).removeClass('dodaj-czas').addClass('akceptuj-czas').addClass('btn-warning');
				$(this).children('i').removeClass('icon-plus-sign-alt').addClass('icon-check');
			});
			
			$('.akceptuj-czas').live('click', function(){
				
				var blad = 0;
				
				var godzinaOd = $('#godzinaOd').val();
				if(godzinaOd === "")
				{
					blad = 1;
					$('#godzinaOd').addClass('errorInput');
				}
				var godzinaDo = $('#godzinaDo').val();
				if(godzinaDo === "")
				{
					blad = 1;
					$('#godzinaDo').addClass('errorInput');
				}
				
				if(blad === 0)
				{
					var wiersz = '<i class="icon icon-time"></i><span>'+godzinaOd+' - '+godzinaDo+'</span>';
					$(this).parent('li').prev('li').removeClass('add').removeAttr('style');
					$(this).parent('li').prev('li').html(wiersz);
					$(this).removeClass('btn-warning').removeClass('akceptuj-czas').addClass('dodaj-czas');
					$(this).children('i').removeClass('icon-check').addClass('icon-plus-sign-alt');
					przeslijKofiguracje();
				}
				
			});
			
			$('.akceptuj-czas-edycja').live('click', function(){
				var blad = 0;
				
				var godzinaOd = $('#godzinaOd').val();
				if(godzinaOd === "")
				{
					blad = 1;
					$('#godzinaOd').addClass('errorInput');
				}
				var godzinaDo = $('#godzinaDo').val();
				if(godzinaDo === "")
				{
					blad = 1;
					$('#godzinaDo').addClass('errorInput');
				}
				if(blad === 0)
				{
					var wiersz = '<i class="icon icon-time"></i><span>'+godzinaOd+' - '+godzinaDo+'</span>';
					$(this).parent('li').removeClass('add').removeAttr('style');
					$(this).parent('li').html(wiersz);
					$(this).remove();
					przeslijKofiguracje();
				}
			});
			
			$('.dodaj-team').live('click', function(){
				
				$(this).parent('li').before(selectTeam);
				$('select.team-select').select2();
			});
			
			$('.team-select').live('change', function(){
				var wartosc = $(".team-select option:selected").text();
				var idTeam = $(".team-select option:selected").val();
				var li = $(this).parents('li');
				
				var element = '<i class="icon icon-truck"></i><span>'+wartosc+'</span>';
				
				li.removeClass('add');
				li.addClass('team_'+idTeam);
				li.html(element);
				li.attr('id', 'team_'+idTeam);
				li.removeClass('zaznaczona_opcja');
				przeslijKofiguracje();
			});
			
			$('.dodaj-date').live('click', function(){
				var kalendarz = '<li class="add"><div class="input-append" style="width:120px;" ><input class="dateStart" style="width: 85px;" type="text" data-date-format="dd.mm.yyyy" title="dd.mm.yyyy" name="dateStart"><span class="add-on"><i class="icon-calendar"></i></span></div></li>'
				$(this).parent('li').before(kalendarz);
				$( ".dateStart" ).datepicker()
						  .on('changeDate', function(ev){
									$(".dateStart").change();
							});
			});
			
			$('.dateStart').live('change', function(){
				var wartosc = $(this).val();
				var li = $(this).parents('li');
				var elementData = '<i class="icon icon-calendar"></i><span>'+wartosc+'</span>';
				li.removeClass('add');
				li.html(elementData);
				$('.datepicker').hide(500);
				przeslijKofiguracje();
			});
			
			$('#zaznaczWszystkie').live('click', function(){
				
				var inputCzas = $('input#autoCzas');
				var autoData = $('input#autoData');
				var autoTeam = $('input#autoTeam');
				
				$('input:checkbox[name="id_apartament"]').each(function(i , el){
					
					if($(el).parents('tr').is(':visible'))
					{
						$(el).parent('span').addClass('checked');
						$(el).attr('checked', 'checked');
						//przydzielFullAutomat(0);
					}
				});
			});
			
			$('input:checkbox[name="apartament-blok"]').live('click', function(){
				
				var blokId = $(this).attr('id');
				var inputCzas = $('input#autoCzas');
				var autoData = $('input#autoData');
				var autoTeam = $('input#autoTeam');
				
				if($(this).parent('span').is('.checked'))
				{
					$('input:checkbox[class="'+blokId+'"]').each(function(i , el){
						if($(el).parents('tr').is(':visible'))
						{
							$(el).parent('span').addClass('checked');
							$(el).attr('checked', 'checked');
						}
					});
					if(inputCzas.is(':checked') || autoData.is(':checked') || autoTeam.is(':checked'))
					{
						 przydzielFullAutomat(0);
					}
					else
					{
						$('input:checkbox[class="'+blokId+'"]').each(function(i , el){
							if($(el).parents('tr').is(':visible'))
							{
								przypiszKonfiguracjeDoApartamentu($(el).parents('td'));
							}
						});
					}
					
				}
				else
				{
					$('input:checkbox[class="'+blokId+'"]').parent('span').removeClass('checked');
					$('input:checkbox[class="'+blokId+'"]').removeAttr('checked');
				}
			});
			
			$('.wyczysc').live('click', function(){
				wyczyscDane($(this));
			});
			
			$('.wyczysc-checkbox').live('click', function(){
				wyczyscZaznaczoneCheckboxy();
			});
			
			$('.wyczysc-informacje').live('click', function(){
				wyczyscZaznaczoneInformacje();
			});
			
			$('.data , .czas , .bil').live('mouseover', function(){
				if($(this).find('span').text() != '')
				{
					$(this).find('span').addClass('usun-wartosc');
				}
			});
			
			$('.data , .czas , .bil').live('mouseout', function(){
				if($(this).find('span').text() != '')
				{
					$(this).find('span').removeClass('usun-wartosc');
				}
			});
			
			$('.usun-wartosc').live('click', function(){
				$(this).html('');
				$(this).removeClass('usun-wartosc');
				if($(this).parent('td').is('.data'))
				{
					$(this).parents('tr').removeAttr('style');
				}
				$(this).parent('td').addClass('zaznacz');
				if($(this).parent('td').siblings('td.czas').children('span').text() === ''
					&& $(this).parent('td').siblings('td.data').children('span').text() === ''
					&& $(this).parent('td').siblings('td.bil').children('span').text() === ''
					)
				{
					$(this).parents('tr').last('td').find('.wyczysc').hide(500);
				}
				
				zapiszZmiany($(this).parents('tr').attr('id'), 'usun');
				
			});
			
			$('#konfiguracja-data li:not(.add)').live('click', function(){
				
				if($('#autoCzas').is(':checked'))
				{
					if($(this).is('.zaznaczona-opcja'))
					{
						$('#konfiguracja-data').addClass('podswietl');
					}
					else
					{
						$('#konfiguracja-data').removeClass('podswietl');
					}
				}
				if($('#autoData').is(':checked'))
				{
					return false;
				}
				if($(this).is('.zaznaczona-opcja'))
				{
					$('#konfiguracja-data li').removeClass('zaznaczona-opcja');
				}
				else
				{
					$('#konfiguracja-data li').removeClass('zaznaczona-opcja');
					$(this).addClass('zaznaczona-opcja');
					var wartosc = $(this).children('span').text();
					if($('#autoCzas').is(':checked') || $('#autoData').is(':checked'))
					{
						przydzielFullAutomat(0);
					}
					else
					{
						przypiszKonfiguracjeDoWieluApartamentow(wartosc, 'data');
					}
				}
				
			});
			
			$('#konfiguracja-czas li:not(.add)').live('click', function(){
				if($('#autoCzas').is(':checked'))
				{
					return false;
				}
				if($(this).is('.zaznaczona-opcja'))
				{
					$('#konfiguracja-czas li').removeClass('zaznaczona-opcja');
				}
				else
				{
					$('#konfiguracja-czas li').removeClass('zaznaczona-opcja');
					$(this).addClass('zaznaczona-opcja');
					var wartosc = $(this).children('span').text();
					przypiszKonfiguracjeDoWieluApartamentow(wartosc, 'czas');
				}
			});
			
			$('#konfiguracja-team li:not(.add)').live('click', function(){
				
				if($('#autoTeam').is(':checked'))
				{
					return false;
				}
				
				if($('#autoCzas').is(':checked') || $('#autoData').is(':checked'))
				{
					if($(this).is('.zaznaczona-opcja'))
					{
						$('#konfiguracja-team').addClass('podswietl');
					}
					else
					{
						$('#konfiguracja-team').removeClass('podswietl');
					}
				}
				
				if($(this).is('.zaznaczona-opcja'))
				{
					$('#konfiguracja-team li').removeClass('zaznaczona-opcja');
				}
				else
				{
					$('#konfiguracja-team li').removeClass('zaznaczona-opcja');
					$(this).addClass('zaznaczona-opcja');
					var wartosc = $(this).children('span').text();
					
					if($('#autoCzas').is(':checked') || $('#autoData').is(':checked'))
					{
						przydzielFullAutomat(0);
					}
					else
					{
						przypiszKonfiguracjeDoWieluApartamentow(wartosc, 'bil');
					}
				}
			});
			
			$window.resize(function(){
				setLayout(351);
				setWidth();
			});
			
			$('#zaczep').live('click', function(){
				var szerokoscKontenera = $('#kontener').width() - $('#lista-apartamentow').width()-30;
				if($(this).children('i').is('.icon-paper-clip'))
				{
					$(this).children('i').addClass('icon-unlink');
					$(this).children('i').removeClass('icon-paper-clip');
				}
				else
				{
					$(this).children('i').addClass('icon-paper-clip');
					$(this).children('i').removeClass('icon-unlink');
				}
				$('#konfiguracja').toggleClass("konfiguracja");
				
				if ($('#konfiguracja').hasClass('konfiguracja'))
				{
					setLayout(351);
					$('#konfiguracja').css({width: szerokoscKontenera+'px'});
				}
				else
				{
					$('#konfiguracja').css({
						top: '10px',
						height: 'auto',
					});
					$('#konfiguracja .widget-content').css({height: 'auto'});
				}
			});
			
			$.fn.followFrom = function(pos)
			{
				setLayout(pos);
				$window.scroll(function(e){
					setLayout(pos);
				});
			};

			$('#konfiguracja-apartamentow .konfiguracja').followFrom(351);
			
			$('.usun').live('click', function(){
				usunWiersz($(this));
			});
			
			$('.dodaj-wiersz').live('click', function(){
				dodajWiersz($(this).parents('tr').attr('id').replace('id_', ''), 'after');
			});
			
			$('.dodaj-wiersz-dziecka').live('click', function(){
				dodajWiersz($(this).parents('tr').next('tr').attr('id').replace('id_', ''), 'before');
			});
			
			$('.zapisz-adres').live('click', function(){
				zapiszAdres($(this));
				
			});
			
			$('.icon-calendar:not(.not-edit)').live('click', function(){
				
				var wartosc = $(this).siblings('span').text();
				var kalendarz = '<li class="add"><div class="input-append" style="width:120px;" ><input class="dateStart focus-out" autocomplete="off" old-value="'+wartosc+'" style="width: 85px;" type="text" data-date-format="dd.mm.yyyy" title="dd.mm.yyyy" name="dateStart"><span class="add-on"><i class="icon-calendar"></i></span></div></li>'
				$(this).parent('li').addClass('add').html(kalendarz);

				$( ".dateStart").datepicker()
						  .on('changeDate', function(ev){
									$(".dateStart").change();
							});
			});
			
			$('.icon-truck').live('click', function(){
				$(this).parent('li').removeClass();
				$(this).parent('li').addClass('add').html(selectTeam);
				$('.team-select').select2();
			});
			
			$('li > .icon-time:not(.not-edit)').live('click', function(){
				var wartoscPoprzednia = $(this).next('span').text();
				var godziny = wartoscPoprzednia.split('-');
				
				var time = '<li class="add" style="width: 200px;">\n\
							<div class="input-append bootstrap-timepicker" style="width: 85px; float: left;">\n\
								<input id="godzinaOd" style="width: 40px;" class="timepicker input-small long" type="text" data-minute-step="15" value="'+godziny[0]+'" name="godzinaOd">\n\
								<span class="add-on"><i class="icon-time"></i></span>\n\
							</div>\n\
							<div class="input-append bootstrap-timepicker" style="float: left;">\n\
								<input id="godzinaDo" style="width: 40px;" class="timepicker input-small long" type="text" data-minute-step="15" value="'+godziny[1]+'" name="godzinaOd">\n\
								<span class="add-on"><i class="icon-time"></i></span>\n\
							</div>\n\
							<br clear="all"/>\n\
							<button class="btn btn-xs fL akceptuj-czas-edycja btn-warning" href="javascript:void(0);">\n\
								<i class="icon icon-check"></i>\n\
							</button>\n\
						</li>';
				$(this).parent('li').addClass('add').html(time);
				var opts = {showMeridian: false, defaultTime: false};
				$(".timepicker").timepicker(opts);
				
				$(this).removeClass('dodaj-czas').addClass('akceptuj-czas').addClass('btn-warning');
				$(this).children('i').removeClass('icon-plus-sign-alt').addClass('icon-check');
			});
			
			$('#edytujKonfiguracje').live('click', function(){
				edytujKonfiguracje();
			});
			
			$('#autoCzas').live('click', function(){
				
				if($(this).is(':checked'))
				{
					$('ul#konfiguracja-czas li').removeClass('zaznaczona-opcja');
					$('ul#konfiguracja-data li').removeClass('zaznaczona-opcja');
					$('ul#konfiguracja-team li').removeClass('zaznaczona-opcja');
					$('ul#konfiguracja-data').addClass('podswietl');
					$('ul#konfiguracja-team').addClass('podswietl');
					
					$('#autoDataDiv').show(500);
				}
				else
				{
					$('ul#konfiguracja-data').removeClass('podswietl');
					$('ul#konfiguracja-team').removeClass('podswietl');
					
					$('#autoDataDiv').hide(500);
					$('#autoDataDiv').children('#uniform-autoData').find('span').removeClass('checked');
					$('#autoData').removeAttr('checked');
					
					$('#autoTeamDiv').hide(500);
					$('#autoTeamDiv').children('#uniform-autoTeam').find('span').removeClass('checked');
					$('#autoTeam').removeAttr('checked');
				}
				
			});
			
			$('#autoData').live('click', function(){
				if($(this).is(':checked'))
				{
					$('ul#konfiguracja-data').removeClass('podswietl');
					$('ul#konfiguracja-team').addClass('podswietl');
					$('ul#konfiguracja-czas li').removeClass('zaznaczona-opcja');
					$('ul#konfiguracja-data li').removeClass('zaznaczona-opcja');
					$('ul#konfiguracja-team li').removeClass('zaznaczona-opcja');
					
					$('#autoTeamDiv').show(500);
				}
				else
				{
					$('ul#konfiguracja-data').addClass('podswietl');
					
					$('#autoTeamDiv').hide(500);
					$('#autoTeamDiv').children('#uniform-autoTeam').find('span').removeClass('checked');
					$('#autoTeam').removeAttr('checked');
				}
			});
			
			$('#autoTeam').live('click', function(){
				if($(this).is(':checked'))
				{
					$('ul#konfiguracja-team').removeClass('podswietl');
					$('ul#konfiguracja-team li').removeClass('zaznaczona-opcja');
					if($('input[name="id_apartament"]').parent('.checked').length > 0)
					{
						przydzielFullAutomat(0);
					}
				}
				else
				{
					$('ul#konfiguracja-team').addClass('podswietl');
				}
			});
			
			$('#checkboxBlok').live('click', function(){
				if($(this).is(':checked'))
				{
					$(this).parents('#uniform-checkboxBlok').siblings('#adresApartament').show();
				}
				else
				{
					$(this).parents('#uniform-checkboxBlok').siblings('#adresApartament').hide();
				}
			});
			
			$("#filter").keyup(function(){
				var filter = $.trim($(this).val()), count = 0;
				{{IF flagaListaProjektow}}
				$(".wiersz > td").children('span').children('.fraza_szukaj').each(function(){
					if($(this).text().search(new RegExp(filter, "i")) < 0)
					{
						$(this).parents('.wiersz').fadeOut();
					}
					else
					{
						$(this).parents('.wiersz').show();
						count++;
					}
				});
				{{ELSE}}
				$('td.szukaj').each(function(){
					if($(this).text().search(new RegExp(filter, "i")) < 0)
					{
						
						if($(this).parents('tr').is('.apartament-blok:visible') && $('.apartament-blok:visible').size() == 1 )
						{
						}
						else
						{
							$(this).parents('tr').fadeOut();
						}
							
					}
					else 
					{
						/*
						if( $(this).parents('tr').prevAll('.apartament-blok:first').size() > 0 )
						{
							console.log('tutaj');
							$(this).parents('tr').prevAll('.apartament-blok:first').show();
						}
						
						*/
						
						$(this).parents('tr').show();
						if(!$(this).parents('tr').is('.apartament-blok'))
							count++;
					}
				});
				{{END}}
				var numberItems = count;
				
				$("#filter-count").text("{{$znaleziono_zamowien}}"+count);
		   });
			
			$('#zapisz-zmiany').live('click', function(){
				window.location.href = "{{$linkDodajInformacje}}";
			});
			
			$('#wyslij-email').live('click', function(){
				$('.mobile-loader').fadeIn("normal");
				$.ajax({
					url: "{{$linkWyslijEmail}}",
					type: 'POST',
					dataType: 'json',
					async: true,
					success: function(dane) {
						 if(dane['kod'] == 2)
						 {
							 alertModal('Error', dane['error']);
						 }
						 if(dane['kod'] == 1)
						 {
							alertModal('Information', dane['info']);
						 }

						 $('.mobile-loader').fadeOut("normal");
					},
					error: function (xhr, ajaxOptions, thrownError) {
						var error = 'Save data failed: '+xhr.status;
						if (thrownError != '') 
						{
							error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
							error += xhr.responseText;
						}
						alertModal('AJAX request error' ,error);
					}
				})
				return false;
			});
			
			$('#przydzielanieAutomatyczne').live('click', function(){
				przydzielFullAutomat(0);
			})
			
			$('#wyczyscZaznaczone').live('click', function(){
				usunPrzydzielenie();
			})
			
			$('#ustawJakoOtwarte').live('click', function(){
				ustawOtwarte();
			});
			
			$('#konfigurujAutomatycznie').live('click', function(){
				konfigurujAutomatycznie($(this).attr('href'));
				return false;
				}
			);
			
		});
		
		function aktualizujKonfiguracje()
		{
			$.ajax({
					url: "{{$linkAktualizujKonfiguracje}}",
					type: 'POST',
					dataType: 'json',
					async: true,
					success: function(dane) {
						if(dane['kod'] == 2)
						{
							alertModal(dane['error']);
							return false;
						}
						else
						{
							$('#konfiguracja-apartamentow-html').html(dane['html']);
							$('#autoCzas').uniform();
							$('#autoData').uniform();
							$('#autoTeam').uniform();
							setTimeout(function(){
									$('.tip-top').tooltip();
								}
								, 500);
							setWidth();
							setLayout(351);
						}
					},
					error: function (xhr, ajaxOptions, thrownError) {
						var error = 'Save data failed: '+xhr.status;
						if (thrownError != '') 
						{
							error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
							error += xhr.responseText;
						}
						alertModal('AJAX request error' ,error);
						return false;
					}
				});
		}
		
		function konfigurujAutomatycznie(href)
		{
			$.ajax({
				url: '"'+href+'"',
				type: 'POST',
				dataType: 'json',
				//data: "ids="+ids+'&secondRound='+secondRound,
				async: true,
				success: function(dane) {
					 if(dane['kod'] == 1)
					 {
						aktualizujKonfiguracje();
					 }
					 if(dane['kod'] == 2)
					 {
						 alertModal('Error', dane['info']);
					 }
				},
				error: function (xhr, ajaxOptions, thrownError) {
					var error = 'Save data failed: '+xhr.status;
					if (thrownError != '') 
					{
						error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
						error += xhr.responseText;
					}
					alertModal('AJAX request error' ,error);
				}
			})
			return false;
		}
		
		function ustawOtwarte()
		{
			var ids = Array();
			var secondRound = $.urlParam('secondRound');
			$('input[name="id_apartament"][type="checkbox"]:checked').each(function(i, el){
				ids.push($(this).val());
			});
			
			$('.mobile-loader').fadeIn("normal");
			$.ajax({
				url: "{{$linkUstawOtwarte}}",
				type: 'POST',
				dataType: 'json',
				data: "ids="+ids+'&secondRound='+secondRound,
				async: true,
				success: function(dane) {
					 if(dane['kod'] == 1)
					 {
						setTimeout(function(){
							$('input:checkbox[name="id_apartament"]').uniform();
							$('input:checkbox[name="apartament-blok"]').uniform();
						}, 600);
					 }
					 if(dane['kod'] == 2)
					 {
						 alertModal('Error', dane['error']);
					 }
					 $('#tabela-apartamenty').html(dane['tabela']);
					 $('.mobile-loader').fadeOut("normal");
					 $('#filter').keyup();
				},
				error: function (xhr, ajaxOptions, thrownError) {
					var error = 'Save data failed: '+xhr.status;
					if (thrownError != '') 
					{
						error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
						error += xhr.responseText;
					}
					alertModal('AJAX request error' ,error);
				}
			})
			return false;
		}
		
		function usunPrzydzielenie()
		{
			var secondRound = $.urlParam('secondRound');
			var ids = Array();
			$('input[name="id_apartament"][type="checkbox"]:checked').each(function(i, el){
				ids.push($(this).val());
			});
			$('.mobile-loader').fadeIn("normal");
			$.ajax({
				url: "{{$linkUsunPrzydzielenie}}",
				type: 'POST',
				dataType: 'json',
				data: "ids="+ids+'&secondRound='+secondRound,
				async: true,
				success: function(dane) {
					 if(dane['kod'] == 2)
					 {
						 alertModal('Error', dane['error']);
					 }
					 if(dane['kod'] == 1)
					 {
						$('#tabela-apartamenty').html(dane['tabela']);
						setTimeout(function(){
							$('input:checkbox[name="id_apartament"]').uniform();
							$('input:checkbox[name="apartament-blok"]').uniform();
							$('td.akcja').children('a, button').tooltip();
							$('tr.apartament-blok td').children('a, button').tooltip();
						}, 600);
						$('#filter').keyup();
					 }
					  
					 $('.mobile-loader').fadeOut("normal");
				},
				error: function (xhr, ajaxOptions, thrownError) {
					var error = 'Save data failed: '+xhr.status;
					if (thrownError != '') 
					{
						error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
						error += xhr.responseText;
					}
					alertModal('AJAX request error' ,error);
				}
			})
			return false;
		}
			
		function przydzielFullAutomat(id)
		{
			var autoCzas = $('#autoCzas').is(':checked');
			var autoData = $('#autoData').is(':checked');
			var autoTeam = $('#autoTeam').is(':checked');
			var autoDataWybrana = $('ul#konfiguracja-data li.zaznaczona-opcja').children('span').text();
			//var autoTeamWybrany = $('ul#konfiguracja-team li.zaznaczona-opcja').children('span').text();
			var autoTeamWybrany = 0;
			if(typeof $('ul#konfiguracja-team li.zaznaczona-opcja').attr('id') != 'undefined')
			{
				autoTeamWybrany = $('ul#konfiguracja-team li.zaznaczona-opcja').attr('id').replace('team_', '');
			}
			var przydzielJeden = 0;
			var secondRound = $.urlParam('secondRound');
			if(id > 0)
			{
				var ids = Array(id);
				var przydzielJeden = 1;
			}
			else
			{
				var ids = Array();
				$('input[name="id_apartament"][type="checkbox"]:checked').each(function(i, el){
					ids.push($(this).val());
				});
			}
			
			if((autoCzas && !autoData && !autoTeam) && (autoDataWybrana === "" || autoTeamWybrany == 0 || ids.length < 1))
			{
				return false;
			}
			if((autoData && !autoTeam) && (autoTeamWybrany == 0 || ids.length < 1) )
			{
				return false;
			}
			$('.mobile-loader').fadeIn("normal");
			$.ajax({
				url: "{{$linkFullAutomat}}",
				type: 'POST',
				dataType: 'json',
				data: "ids="+ids+"&autoCzas="+autoCzas+"&autoData="+autoData+"&autoTeam="+autoTeam+"&autoDataWybrana="+autoDataWybrana+"&autoTeamWybrany="+autoTeamWybrany+"&przydzielJeden="+przydzielJeden+'&secondRound='+secondRound,
				async: true,
				success: function(dane) {
					 if(dane['kod'] == 1)
					 {
						$('#tabela-apartamenty').html(dane['tabela']);
						setTimeout(function(){
							$('input:checkbox[name="id_apartament"]').uniform();
							$('input:checkbox[name="apartament-blok"]').uniform();
							$('td.akcja').children('a, button').tooltip();
							$('tr.apartament-blok td').children('a, button').tooltip();
						}, 400);
						$('#filter').keyup();
					 }
					 if(dane['kod'] == 2)
					 {
						 alertModal('Error', dane['error']);
					 }
					 if(dane['kod'] == 3)
					 {
						$('#id_'+dane['id']).children('td.czas').find('span').text(dane['czas']);
						$('#id_'+dane['id']).children('td.data').find('span').text(dane['data']);
						$('#id_'+dane['id']).children('td.bil').find('span').text(dane['team']);
						if(dane['kolor'] !='')
						{
							$('#id_'+dane['id']).animate({
								backgroundColor : dane['kolor'],
							}, 500);
						}
						$('#id_'+dane['id']).last('td').find('.wyczysc').show(500);
					 }
					 $('.mobile-loader').fadeOut("normal");
				},
				error: function (xhr, ajaxOptions, thrownError) {
					var error = 'Save data failed: '+xhr.status;
					if (thrownError != '') 
					{
						error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
						error += xhr.responseText;
					}
					alertModal('AJAX request error' ,error);
				}
			})
			return false;
		}
		
		function ukryjWypelnione()
		{
			$('.mobile-loader').fadeIn("normal");
			$('.apartamenty-tabela tr td.data').each(function(){
				if($(this).text().length > 0)
				{
					$(this).parents('tr').hide(500);
					$(this).siblings('td.apartament').find('input:checkbox[name="id_apartament"]').removeAttr('checked');
					$(this).siblings('td.apartament').find('span.checked').removeClass('checked');
				}
			});
			$('.mobile-loader').fadeOut("normal");
		}
		
		function pokazWypelnione()
		{
			$('.mobile-loader').fadeIn("normal");
			$('.apartamenty-tabela tr td.data').each(function(){
				if($(this).text().length > 0)
					$(this).parents('tr').show(500);
			});
			$('.mobile-loader').fadeOut("normal");
		}
		
		function dodajWiersz(idWiersza, miejsce)
		{
			$.ajax({
				url: "{{$linkDodajWiersz}}",
				type: 'POST',
				dataType: 'json',
				data: "id="+idWiersza,
				async: true,
				success: function(dane) {
					if(dane['kod'] == 2)
					{
						alertModal(dane['error']);
					}
					if(dane['kod'] == 1 )
					{
						var wiersz = $('#id_'+idWiersza).clone();
						wiersz.attr('id', 'id_'+dane['id']);
						wiersz.children('td.apartament').find('span.label').remove();
						var wartosc = $.trim(wiersz.children('td.apartament').text());
						var input = '<input type="text" name="adres" id="adres" value="'+wartosc+'" />';
						var inputBlok = '<input type="checkbox" name="checkboxBlok" id="checkboxBlok" />';
						var inputApartament = '<input type="text" name="adresApartament" style="width:45px; display:none;" id="adresApartament" />';
						wiersz.children('td.apartament').html(wiersz.children('td.apartament').html().replace(wartosc, ''));
						wiersz.children('td.apartament').append(input).append(inputBlok).append(inputApartament);
						wiersz.children('td.data, td.czas, td.bil ').find('span').text('');
						wiersz.removeAttr('style');
						$('.wyczysc-informacje').click();
						wiersz.children('td').last().children('.dodaj-wiersz').removeClass('dodaj-wiersz').addClass('zapisz-adres btn-warning').children('i').removeClass('icon-plus-sign-alt').addClass('icon-check');
						if(miejsce == "after")
							$('#id_'+idWiersza).after(wiersz);
						else
							$('#id_'+idWiersza).before(wiersz);
						
						$.uniform.restore(wiersz.children('td.apartament').find('#apartament_'+idWiersza));
						wiersz.children('td.apartament').find('#apartament_'+idWiersza).attr('id', 'apartament_'+dane['id']).val(dane['id']).uniform();
						
						setTimeout(function(){
							$('#checkboxBlok').uniform(); 
						}, 500 );
						$('#filter').keyup();
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					var error = 'Save data failed: '+xhr.status;
					if (thrownError != '') 
					{
						error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
						error += xhr.responseText;
					}
					alertModal('AJAX request error' ,error);
				}
			})
			return false;
		}
		
		function zapiszAdres(obiekt)
		{
			var idWiersza = obiekt.parents('tr').attr('id').replace('id_', '');
			var klasa = $('#id_'+idWiersza).children('td').find('input[type="checkbox"]').attr('class');
			var adres = obiekt.parents('tr').children('td.apartament').find('input[name="adres"]').val();
			var checkboxBlok = obiekt.parents('tr').children('td.apartament').find('input[name="checkboxBlok"]').is(':checked');
			var inputApartament = obiekt.parents('tr').children('td.apartament').find('input[name="adresApartament"]');
			var adresApartament = obiekt.parents('tr').children('td.apartament').find('input[name="adresApartament"]').val();
			
			if(checkboxBlok)
			{
				var inputApartamentWartosc = adresApartament;
				if(inputApartamentWartosc === "")
				{
					inputApartament.addClass('errorInput');
					return false;
				}
			}
			
			$.ajax({
				url: "{{$linkZapiszAdres}}",
				type: 'POST',
				dataType: 'json',
				data: "id="+idWiersza+"&adres="+adres+'&checkboxBlok='+checkboxBlok+'&adresApartament='+adresApartament,
				async: true,
				success: function(dane) {
					if(dane['kod'] == 2)
					{
						alertModal(dane['error']);
					}
					if(dane['kod'] == 1)
					{
						obiekt.removeClass('zapisz-adres btn-warning').addClass('dodaj-wiersz btn-primary').children('i').removeClass('icon-check').addClass('icon-plus-sign-alt');
						var input = obiekt.parents('tr').children('td.apartament').find('input[name="adres"]');
						var wartosc = input.val();
						var inputCheckbox = obiekt.parents('tr').children('td.apartament').find('input[name="checkboxBlok"]');
						var inputApartament = obiekt.parents('tr').children('td.apartament').find('input[name="adresApartament"]');
						var icon = "";
						if(obiekt.parents('tr').is('.apartament-villa'))
						{
							var icon = "icon-home";
						}
						if(checkboxBlok)
						{
							var inputApartamentWartosc = inputApartament.val();
							if(inputApartamentWartosc === "")
							{
								inputApartament.addClass('errorInput');
								return false;
							}
						}
						else
						{
							var inputApartamentWartosc = wartosc;
						}
						if(checkboxBlok)
						{
							klasa = "id_"+idWiersza;
						}
						
						var klasa="";
						if(dane.villa)
						{
							klasa = "apartament-villa";
							icon = 'icon-home';
						}
						
						var apartament = '<tr id="id_'+idWiersza+'" class="'+klasa+'">\n\
													<td class="szukaj" style="display:none;">'+dane.fraza_szukaj+'</td>\n\
													<td class="apartament zaznacz"><input class="'+klasa+'" type="checkbox" value="'+idWiersza+'" name="id_apartament" ><span class="icon">\n\
													<i class="fa '+icon+'"></i>\n\
													</span>'+inputApartamentWartosc+'</td>\n\
													<td class="data zaznacz"><span></span></td><td class="czas zaznacz"><span></span></td><td class="bil zaznacz"><span></span></td>\n\
													<td class="akcja"><a class="btn btn-danger fR usun tip-top" href="javascript:void(0);" data-original-title=""><i class="icon icon-minus-sign-alt"></i></a>\n\
													<a class="btn btn-primary fR podglad tip-top" href="'+dane['linkPodglad']+'" onclick="modalAjax(this.href); return false;" data-original-title="Preview"><i class="icon icon-search"></i></a>\n\
													<a class="btn btn-primary fR dodaj-notatke tip-top" href="'+dane['linkDodajNotatke']+'" onclick="return otworzOkno(this.href);" data-original-title="Add note"><i class="icon icon-file-text"></i></a>\n\
													<a class="btn btn-primary fR user tip-top" href="'+dane['linkDodajKlienta']+'" onclick="modalAjax(this.href); return false;" data-original-title=""><i class="icon icon-user"></i></a>\n\
													<button class="btn btn-success fR dodaj-wiersz tip-top" href="javascript:void(0);" data-original-title="Add apartment"><i class="icon icon-plus-sign-alt"></i> ⇓</button>\n\
													<a class="btn btn-default fR wyczysc tip-top" href="javascript:void(0);" style="display:none;" data-original-title=""><i class="icon icon-eraser"></i></a></td></tr>';
			
						if(checkboxBlok)
						{
							
							var blokNaglowek = '<tr class="apartament-blok">\n\
															<td class="szukaj" style="display:none;">'+dane.fraza_szukaj+'</td>\n\
															<td colspan="5"><span class="icon"><input id="blok_'+idWiersza+'" class="fL" type="checkbox" name="apartament-blok" ></span>\n\
															<span class="icon"><i class="fa icon-home"></i></span><h5 class="fL">'+wartosc+'</h5>\n\
															<a class="btn btn-danger fR usun usun-blok tip-top" href="javascript:void(0);" data-original-title=""><i class="icon icon-minus-sign-alt nopadding"></i></a>\n\
															<a class="btn btn-success fR dodaj-wiersz-dziecka" href="javascript:void(0);"><i class="icon icon-plus-sign-alt"></i> ⇓ Add apartment</a></td></tr>\n\
														';
							obiekt.parents('tr').after(apartament);
							obiekt.parents('tr').after(blokNaglowek);
							obiekt.parents('tr').remove();
							$('input#id_'+idWiersza).uniform();
						}
						else
						{
							obiekt.parents('tr').after(apartament);
							obiekt.parents('tr').remove();
						}
						
						$('tr#id_'+idWiersza).children('td').find('input[type="checkbox"]').uniform();
						input.remove();
						inputApartament.remove();
						inputCheckbox.parents('#uniform-checkboxBlok').remove();
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					var error = 'Save data failed: '+xhr.status;
					if (thrownError != '') 
					{
						error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
						error += xhr.responseText;
					}
					alertModal('AJAX request error' ,error);
				}
			})
			return false;
		}
		
		function zapiszZmiany(wierszId, mode)
		{
			var idWiersza = wierszId.replace('id_', '');
			var daty = $('ul#konfiguracja-data li:not(.add)');
			var datyPrzeslij = {};
			var i = 0;
			daty.each(function(){
				datyPrzeslij[i] = {
					data: $(this).children('span').text(),
					kolor: $(this).css('background-color'),
				};
				i++;
			});
			var wiersz = $('#'+wierszId);
			var data = wiersz.children('td.data').find('span').text();
			var czas = wiersz.children('td.czas').find('span').text();
			var team = wiersz.children('td.bil').find('span').text();
			var secondRound = $.urlParam('secondRound');
			
			if(mode !== "usun")
			{
				if($('#autoCzas').is(':checked'))
				{
					if($('#autoData').is(':checked'))
					{
						if($('#autoTeam').is(':checked'))
						{
							var autoTeam = 1;
						}
						else
						{
							var autoData = 1;
						}
					}
					else
					{
						if(data === "" || team === "")
						{
							return false;
						}
						
						var autoData = 0;
					}
					
					var autoCzas = 1;
				}
				else
				{
					var autoCzas = 0;
					var autoData = 0;
					var autoTeam = 0;
				}
			}
			
			var obj = {
				id: idWiersza,
				data: data,
				czas: czas,
				team: team,
				autoCzas: autoCzas,
				autoData: autoData,
				autoTeam: autoTeam,
				daty: datyPrzeslij,
				secondRound : secondRound,
			}
			$.ajax({
				url: "{{$linkZapiszPrzypisanie}}",
				type: 'POST',
				dataType: 'json',
				//data: "id="+idWiersza+"&data="+data+"&czas="+czas+"&team="+team+'&autoCzas='.autoCzas,
				data: obj,
				async: true,
				success: function(dane) {
					if(dane['usunErrorId'].length > 1 && !($('#id_'+dane['id']).is('.tableError')))
					{
						for(var i = 0 ; i < dane['usunErrorId'].length; i++)
						{
							if($('#id_'+dane['usunErrorId'][i]).is('.tableError'))
							{
								$('#id_'+dane['usunErrorId'][i]).removeClass('tableError');
								break;
							}
						}
					}
					if(dane['istnieje'] == 1)
					{
						$('#id_'+dane['id']).addClass('tableError');
					}
					else
					{
						$('#id_'+dane['id']).removeClass('tableError');
					}
					if(dane['kod'] == 1)
					{
						$('#id_'+dane['id']).children('td.czas').find('span').text(dane['czas']);
						$('#id_'+dane['id']).children('td.data').find('span').text(dane['data']);
						if(dane['kolor'] !='')
						{
							$('#id_'+dane['id']).animate({
								backgroundColor : dane['kolor'],
							}, 500);
						}
						if(dane['team'] != "")
						{
							$('#id_'+dane['id']).children('td.bil').find('span').text(dane['team']);
						}
					}
					if(dane['kod'] == 2)
					{
						alertModal("Error", dane['error']);
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					var error = 'Save data failed: '+xhr.status;
					if (thrownError != '') 
					{
						error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
						error += xhr.responseText;
					}
					alertModal('AJAX request error' ,error);
				}
			})
			return false;
		}
		
		function usunWiersz(obiekt)
		{
			if(obiekt.is('.usun-blok'))
			{
				var obiektNastepny = obiekt.parents('tr').next('tr').attr('id');
				
				if(jQuery.type( obiektNastepny ) === "undefined")
				{
					obiekt.parent('td').parent('tr').remove();
					return false;
				}
				else
				{
					var id = obiektNastepny.replace('id_', '');
				}
				
				var usunBlok = 1;
			}
			else
			{
				var id = obiekt.parent('td').parent('tr').attr('id').replace('id_', '');
				var usunBlok = 0;
			}
			
			$.ajax({
				url: "{{$linkUsunWiersz}}",
				type: 'POST',
				dataType: 'json',
				data: "id="+id+"&usunBlok="+usunBlok,
				async: true,
				success: function(dane) {
					if(dane['usunErrorId'] > 1)
					{
						$('#id_'+dane['usunErrorId']).removeClass('tableError');
					}
					if(dane['kod'] == 1)
					{
						for(var i = 0; i < dane['zamowieniaUsuniete'].length; i++)
						{
							$('#id_'+dane['zamowieniaUsuniete'][i]).remove();
							if(usunBlok)
							{
								obiekt.parent('td').parent('tr').remove();
							}
						}
						
						if($('#tabela-apartamenty tr').length < 2)
						{
							$('tr.pusty').show();
						}
						
						$('#filter').keyup();
					}
					if(dane['kod'] == 2)
					{
						alertModal(dane['error']);
					}
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
			})
			return false;
		}
		
		function wyczyscDane(obiekt)
		{
			obiekt.parent('td').parent('tr').removeAttr('style');
			obiekt.parent('td').siblings('td.data').find('span').html('');
			obiekt.parent('td').siblings('td.data').addClass('zaznacz');
			obiekt.parent('td').siblings('td.czas').find('span').html('');
			obiekt.parent('td').siblings('td.czas').addClass('zaznacz');
			obiekt.parent('td').siblings('td.bil').find('span').html('');
			obiekt.parent('td').siblings('td.bil').addClass('zaznacz');
			obiekt.parent('td').siblings('td.apartament').children('#uniform-undefined').children('span').removeClass('checked');
			obiekt.parent('td').siblings('td.apartament').children('#uniform-undefined').children('span').children('input').removeAttr("disabled");
			obiekt.hide(500);
			zapiszZmiany(obiekt.parent('td').parent('tr').attr('id'), 'usun');
		}
		
		function wyczyscZaznaczoneCheckboxy()
		{
			$('input:checkbox[name="id_apartament"]').removeAttr('checked');
			$("input:checkbox[name='id_apartament']:not(:disabled)").parent('span.checked').each(function(){
				$(this).removeClass('checked');
			});
		}
		
		function wyczyscZaznaczoneInformacje()
		{
			$('#konfiguracja-data li.zaznaczona-opcja').removeClass('zaznaczona-opcja');
			$('#konfiguracja-czas li.zaznaczona-opcja').removeClass('zaznaczona-opcja');
			$('#konfiguracja-team li.zaznaczona-opcja').removeClass('zaznaczona-opcja');
		}
		
		function przypiszKonfiguracjeDoWieluApartamentow(konfiguracja, klasa)
		{
			var team = $('#konfiguracja-team li:not(.add)').is('.zaznaczona-opcja');
			var data = $('#konfiguracja-data li:not(.add)').is('.zaznaczona-opcja');
			var inputCzas = $('input#autoCzas');
			var autoData = $('input#autoData');
			var autoTeam = $('input#autoTeam');
			
			if(inputCzas.is(':checked') && !autoData.is(':checked'))
			{
				if(data === false || team === false)
				{
					return false;
				}
			}
			
			var wyswietlajLoader = ((inputCzas.is(':checked') || autoData.is(':checked')) && $('input:checkbox[name="id_apartament"]').parent('span.checked').length > 0 );
			if(wyswietlajLoader)
			{
				$('.mobile-loader').fadeIn("normal");
				var czas = ($("input:checkbox[name='id_apartament']:not(:disabled)").parent('span.checked').length) * 500;
			}
			
			$("input:checkbox[name='id_apartament']:not(:disabled)").parent('span.checked').each(function(i , el){
				if(inputCzas.is(':checked') || autoData.is(':checked'))
				{
					setTimeout(function(){
						przypiszKonfiguracjeDoApartamentu($(el).parents('td'));
					},500 + ( i * 500 ));
				}
				else
				{
					przypiszKonfiguracjeDoApartamentu($(el).parents('td'));
				}
			});
			
			if(wyswietlajLoader)
			{
				setTimeout(function(){
					$('.mobile-loader').fadeOut("normal");
				},czas);
			}
		}
		
		function przypiszKonfiguracjeDoApartamentu(obiekt)
		{
			var wiersz = obiekt.parents('tr');
			var zaznaczona_data = $('#konfiguracja-data li.zaznaczona-opcja');
			var zaznaczony_czas = $('#konfiguracja-czas li.zaznaczona-opcja');
			var zaznaczony_team = $('#konfiguracja-team li.zaznaczona-opcja');
			var przypisanie = 0;
			if(zaznaczona_data.length !== 0)
			{
				wiersz.children('td.data').find('span').html(zaznaczona_data.children('span').text());
				wiersz.children('td.data').removeClass('zaznacz');
				var kolorTla = $('#konfiguracja-data li.zaznaczona-opcja').css('background-color');
				wiersz.animate({
					backgroundColor : kolorTla,
				}, 500);
				przypisanie = 1;
			}
			if(zaznaczony_czas.length !== 0)
			{
				wiersz.children('td.czas').find('span').html(zaznaczony_czas.children('span').text());
				wiersz.children('td.czas').removeClass('zaznacz');
				przypisanie = 1;
			}
			if(zaznaczony_team.length !== 0)
			{
				wiersz.children('td.bil').find('span').html(zaznaczony_team.children('span').text());
				wiersz.children('td.bil').removeClass('zaznacz');
				przypisanie = 1;
			}
			if($('#autoTeam').is(':checked'))
			{
				przypisanie = 1;
			}
			if(przypisanie)
			{
				wiersz.children('td').last().children('a.wyczysc').show(500);
				zapiszZmiany(wiersz.attr('id'), 'dodaj');
			}
			
		}
		
		function sprawdzCzyWypelniony(obiekt)
		{
			if(
						obiekt.children('td.data').find('span').text() != ''
					&& obiekt.children('td.czas').find('span').text() != ''
					&& obiekt.children('td.bil').find('span').text() != ''
			)
			{
				obiekt.removeClass('zaznacz');
			}
		}
		
		function przeslijKofiguracje()
		{
			$('ul#konfiguracja-team li:not(.add)').removeClass('zaznaczona-opcja');
			var teamy = $('ul#konfiguracja-team li:not(.add)');
			var daty = $('ul#konfiguracja-data li:not(.add)');
			var czasy = $('ul#konfiguracja-czas li:not(.add)');
			var idProjekt = $('#projekt').val();
			var drugaTura = $.urlParam('secondRound');
			
			var teamyPrzeslij = [];
			var teamyNazwy = [];
			teamy.each(function(){
				teamyNazwy.push($(this).children('span').text());
				teamyPrzeslij.push($(this).attr('id').replace('team_', ''));
			});
			
			var datyPrzeslij = {};
			var i = 0;
			daty.each(function(){
				datyPrzeslij[i] = {
					data: $(this).children('span').text(),
					kolor: $(this).css('background-color'),
				};
				i++;
			});
			
			var czasyPrzeslij = [];
			czasy.each(function(){
				czasyPrzeslij.push($(this).children('span').text());
			});
			var obj = {
				teamy: teamyPrzeslij,
				teamyNazwy : teamyNazwy,
				daty: datyPrzeslij,
				czasy: czasyPrzeslij,
				idProjektu: idProjekt,
				secondRound: drugaTura,
			};
			$.ajax({
				url: "{{$linkZapiszKonfiguracje}}",
				type: 'POST',
				dataType: 'json',
				data: obj,
				async: true,
				success: function(dane) {
					if(dane['kod'] == 2)
					{
						alertModal(dane['error']);
						return false;
					}
					else
					{
						return true;
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					var error = 'Save data failed: '+xhr.status;
					if (thrownError != '') 
					{
						error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
						error += xhr.responseText;
					}
					alertModal('AJAX request error' ,error);
					return false;
				}
			});
		}
		
		function sprawdzCzyKonfiguracjaWybrana()
		{
			var zaznaczona_data = $('#konfiguracja-data li.zaznaczona-opcja');
			var zaznaczony_czas = $('#konfiguracja-czas li.zaznaczona-opcja');
			var zaznaczony_team = $('#konfiguracja-team li.zaznaczona-opcja');
			
			if(
					zaznaczona_data.length != 0
					|| zaznaczony_czas.length != 0
					|| zaznaczony_team.length != 0
				)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}
		
		function edytujKonfiguracje()
		{
			modalAjax("{{$linkEdytujKonfiguracje}}");
			setTimeout(function(){
					dopasujModala();
				}, 600);
		}
		
		var linkGlobal;
		function otworzOkno(link)
		{
			linkGlobal = link;

			$.ajax({
					url: link,
					type: 'POST',
					dataType: 'html',
					async: true,
					success: function(dane) {
						$('#oknoModalne .modal-body').html(dane);
						$('#oknoModalne').modal('show');
						$('#oknoModalne .modal-body, #oknoModalne .modal-body iframe html').css('background', 'none');
						dopasujModala();
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.status);
						alert(thrownError);
					}
			})
			return false;
		}
		
		$("#notes_form").live('submit', function() {
			$.ajax({
				url: linkGlobal,
				type: $('#notes_form').attr('method'),
				data: $('#notes_form').serialize(),
				dataType: 'json',
				async: true,
				success: function(dane) {

					if(dane.kod == '1' )
					{
						$('#miejsceNaFormularz').html(dane.info);
					}
					if(dane.kod == '2' )
					{
						$('#oknoModalne #tabela').html(dane.notatka);
						$('#miejsceNaFormularz').html(dane.formularz);
						if (linkGlobal.indexOf("editNote") >= 0)
						{
							$('#oknoModalne').attr('aria-hidden', 'true');
							$('#oknoModalne').modal('hide');
							window.location.reload();
						}
						else
						{
							aktualizujNotatki(dane.idObject);
						}
					}

				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
				}
			)
				return false;
		})
		
		
	</script>
	{{BEGIN formularz}}
	<div class="widget-box">
		{{$formularzSzukaj}} 
	</div>
	{{END}}
	<div class="widget-box">
		<div class="widget-title">
			<ul class="nav nav-tabs">
			{{BEGIN zakladki}}
				<li class="{{$class}}">
					<a class="tip-top {{$class}}" href="{{$link}}" name="{{$tag}}" title="{{$tag}}" >{{$tag}} ({{$ilosc}})</a>
				</li>
			{{END}}
			</ul>
		</div>
		<div class="widget-content nopadding" id="kontener">
		{{BEGIN listaProjektowGrid}}
		<div class="formularz_grid">
			<form id="live-search" class="form-inline" action="" method="post" name="live-search" enctype="multipart/form-data">
				<ul>
					{{IF $pokaz_wykonane_url}}
					<li>
						<a href="{{$pokaz_wykonane_url}}" class="btn btn-primary">{{$pokaz_wykonane_etykieta}}</a>
					</li>
					{{END IF}}
					{{IF $link_pokaz_druga_tura}}
					<li>
						<a href="{{$link_pokaz_druga_tura}}" class="btn btn-primary">{{$linkTuraEtykieta}}</a>
					</li>
					{{END IF}}
					<li>
						<label for="filter" class="input_ok ">{{$szukajProjekt}} </label>
						<span class="formularz_opis"></span>
						<input type="text" style="width:500px;" name="filter" id="filter" value=""  autocomplete="off" class="long" />
						<div id="filter-count" class="no-shadow">{{$znaleziono_zamowien}} {{$ilosc_znalezionych}}</div>
					</li>
				</ul>
			</form>
		</div>
		<div class="clear"></div>
		{{$grid}}
		{{END}}
		{{BEGIN tabelaDane}}
		
		<div id="lista-apartamentow">
			<div class="widget-box">
				<div class="widget-content nopadding">
					<table class="table table-bordered apartamenty-tabela">
						<thead>
							 <tr>
								  <th><a class="btn btn-default btn-xs fL wyczysc-checkbox" href="javascript:void(0);"><i class="icon icon-eraser"></i></a>{{$apartment_etykieta}}</th>
								  <th style="width:150px;">{{$data_etykieta}}</th>
								  <th style="width:150px;">{{$time_etykieta}}</th>
								  <th style="width:100px;">{{$team_etykieta}}</th>
								  <th style="width:280px;"></th>
							 </tr>
						</thead>
						<tbody id="tabela-apartamenty">
							<tr class="wiersz pusty" style="display:{{IF $brakZamowien}}block{{ELSE}}none{{END}}; ">
								<td align="center" colspan="5">{{$brakZamowienKomunikat}}</td>
							</tr>
							{{$tabela}}
						</tbody>
				  </table>
				</div>
			</div>
		</div>
		{{END}}
		
		{{BEGIN konfiguracja}}
		<div id="konfiguracja-apartamentow">
			<div class="widget-box konfiguracja" id="konfiguracja">
				<div class="widget-title">
					<span class="icon tip-left" data-original-title="{{$edytuj_konfiguracje_etykieta}}">
						<a href="javascript:void(0);" id="edytujKonfiguracje" >
							<i class="fa icon-cogs"></i>
						</a>
					</span>
					<h5>{{$information_to_assign_etykieta}}</h5>
					<a id="zaczep" class="tip-left fR padding-sides" data-original-title="lock/unlock" href="javascript:void(0);">
						<i class="icon icon-unlink"></i>
					</a>
				</div>
				<div class="widget-content nopadding">
					<div id="konfiguracja-apartamentow-html">
					{{BEGIN konfiguracjaPrzycisk}}
						<div id="konfiguracjaPrzycisk">
							<a href="javascript:void(0);" id="edytujKonfiguracje" class="btn btn-large btn-success margin" ><i class="fa icon-cogs"></i> {{$kofniguracjaPrzyciskEtykieta}}</a>
							{{IF $wyswietlPrzyciskAutokonfiguracja}}
							<a href="{{$urlKonfigurujAutomatycznie}}" id="konfigurujAutomatycznie" class="btn btn-large btn-info margin" ><i class="icon icon-magic"></i> {{$kofniguracjaAutomatycznaPrzyciskEtykieta}}</a>
							{{END IF}}
						</div>
					{{END}}
					
					{{BEGIN opcjeKonfiguracji}}
					<div class="auto-czas">
						<label for="autoCzas" style="display:inline;">{{$autoCzas_etykieta}}</label> <input type="checkbox" name="autoCzas" id="autoCzas" />
						<div id="autoDataDiv" style="display: none;">
						<label for="autoData" style="display:inline;" >{{$autoData_etykieta}}</label> <input type="checkbox" name="autoData" id="autoData" />
						</div>
						<div id="autoTeamDiv" style="display: none;">
						<label for="autoTeam" style="display:inline;" >{{$autoTeam_etykieta}}</label> <input type="checkbox" name="autoTeam" id="autoTeam" />
						</div>
					</div>
					<ul id="konfiguracja-data" class="quick-actions box-konfiguracja">
						<li class="add">{{$data_etykieta}}</li>
						{{BEGIN data}}
						<li style="background: {{$kolor}}" ><i class="icon icon-calendar"></i><span>{{$data}}</span></li>
						{{END}}
						<li class="add">
							<button class="btn btn-primary fR dodaj-date" href="javascript:void(0);">
								<i class="icon icon-plus-sign-alt"></i>
							</button>
						</li>
					</ul>
					<ul id="konfiguracja-czas" class="quick-actions box-konfiguracja">
						<li class="add">{{$time_etykieta}}</li>
						{{BEGIN czas}}
						<li><i class="icon icon-time"></i><span>{{$czas}}</span></li>
						{{END}}
						<li class="add">
							<button class="btn btn-primary fR dodaj-czas" href="javascript:void(0);">
								<i class="icon icon-plus-sign-alt"></i>
							</button>
						</li>
					</ul>
					<ul id="konfiguracja-team" class="quick-actions box-konfiguracja">
						<li class="add">{{$team_etykieta}}</li>
						{{BEGIN team}}
						<li id="team_{{$idTeam}}" class="tip-left" data-original-title="{{$tip}}" ><i class="icon icon-truck"></i><span>{{$team}}</span></li>
						{{END}}
						<li class="add">
							<button class="btn btn-primary fR dodaj-team" href="javascript:void(0);">
								<i class="icon icon-plus-sign-alt"></i>
							</button>
						</li>
					</ul>
						<div id="konfiguracja-button">
							{{BEGIN przyciskiKonfiguracja}}
							<div id="konfiguracja-button-margin">
							<button class="btn btn-default btn-lg wyczysc-checkbox tip-top" title="{{$odznacz_apartamenty_etykieta}}"><i class="icon icon-check-empty"></i></button>
							<button class="btn btn-default btn-lg zaznaczWszystkie tip-top" id="zaznaczWszystkie" title="{{$zaznacz_wszystkie_etykieta}}"><i class="icon icon-check"></i></button>
							<button class="btn btn-info btn-lg przydzielanieAutomatyczne tip-top" id="przydzielanieAutomatyczne" title="{{$przydzielanie_automatyczne_etykieta}}"><i class="icon icon-bullseye"></i></button>
							<button class="btn btn-warning btn-lg ustawJakoOtwarte tip-top" id="ustawJakoOtwarte" title="{{$ustaw_otwarte_etykieta}}"><i class="icon icon-unlock"></i></button>
							<button class="btn btn-default btn-lg wyczyscZaznaczone tip-top" id="wyczyscZaznaczone" title="{{$wyczysc_zaznaczone_etykieta}}"><i class="icon icon-cut"></i></button>
							<button class="btn btn-lg btn-default wyczysc-informacje tip-top" title="{{$odznacz_informacje_etykieta}}"><i class="icon icon-eraser"></i></button>
							<button class="btn btn-lg btn-success ukryjWypelnione tip-top" id="ukryjWypelnione" title="{{$ukryj_wypelnione_etykieta}}"><i class="icon icon-magic"></i></button>
							<button class="btn btn-lg btn-warning pokazWypelnione tip-top" style="display: none;" id="pokazWypelnione" title="{{$pokaz_wypelnione_etykieta}}"><i class="icon icon-magic"></i></button>
							<button class="btn btn-lg btn-primary zapisz-zmiany tip-top" id="zapisz-zmiany" title="{{$zapisz_przydzielenie_etykieta}}"><i class="icon icon-save"></i></button>
							{{IF $plikPdfIstnieje}}
							<button class="btn btn-lg btn-info podglad-pdf tip-top" href="{{$urlPdf}}" rel="lightbox:fullPage" id="podglad-pdf" title="{{$podglad_pliku_pdf}}"><i class="icon icon-file-text"></i></button>
							{{END plikPdfIstnieje}}
							<button class="btn btn-lg btn-primary wyslij-email tip-top" id="wyslij-email" title="{{$wyslij_email_etykieta}}"><i class="icon icon-envelope-alt"></i></button>
							</div>
							{{END}}
						</div>
					{{END}}
					</div>
					<div class="clear"></div>
				</div>
			</div>
		</div>
		{{END}}
		<div class="clear"></div>	
		</div>
	</div>
		{{BEGIN naglowekBlok}}
		<tr class="apartament-blok">
			<td class="szukaj" style="display:none;">
				{{$miasto}}, {{$ulica}}
			</td>
			 <td colspan="5">
					<span class="icon">
						<input type="checkbox" id="blok_{{$id}}" name="apartament-blok" class="fL" >
					</span>
					<span class="icon">
						<i class="fa icon-home"></i>
					</span>
					<h5 class="fL">{{$miasto}}, {{$ulica}}</h5>
					<a class="btn btn-danger fR usun usun-blok tip-top" data-original-title="{{$usun_etykieta}}" href="javascript:void(0);"><i class="icon icon-minus-sign-alt nopadding" ></i></a> 
					<a class="btn btn-success fR dodaj-wiersz-dziecka tip-top" data-original-title="{{$dodaj_apartament_etykieta}}"  href="javascript:void(0);"><i class="icon icon-plus-sign-alt"></i>&dArr; {{$dodaj_apartament_etykieta}}</a>
			 </td>
		 </tr>
		{{END}}
		{{BEGIN apartament}}
		<tr id="id_{{$id}}" class="{{IF podkresl}}podkresl{{END}}" style="background:{{$bgKolor}}" >
			<td class="szukaj" style="display:none;">
				{{$miasto}}, {{$ulica}} {{$apartament}}
			</td>
			<td class="apartament {{UNLESS $zablokuj_edycja}}zaznacz{{END}}">
				{{UNLESS $zablokuj_edycja}}
				<input type="checkbox" class="blok_{{$id_rodzica}}" id="apartament_{{$id}}" name="id_apartament" value="{{$id}}" >
				{{END}}
				<span id="i-{{$id}}" class="apartament editable" >
				{{$apartament}}
				</span>
				{{IF $id_pdf != "" }} <span class="label label-info" data-original-title="{{$id_pdf}}"> {{$id_pdf}} </span>{{END}}
				{{IF $wykonane}} <span class="label label-success" data-original-title="DONE"> DONE </span> {{END}}
				{{IF $inProgress}} <span class="label label-warning" data-original-title="IN PROGRESS"> IN PROGRESS </span> {{END}}
				{{IF $notDone}} <span class="label label-inverse" data-original-title="NOT DONE"> NOT DONE </span> {{END}}
			</td>
			<td class="data {{UNLESS $zablokuj_edycja}}{{IF dataNieWybrana}}zaznacz{{END}}{{END}}" >{{UNLESS $zablokuj_edycja}}<span>{{END}}{{$data}}{{UNLESS $zablokuj_edycja}}</span>{{END}}</td>
			<td class="czas {{UNLESS $zablokuj_edycja}}{{IF czasNieWybrany}}zaznacz{{END}}{{END}}">{{UNLESS $zablokuj_edycja}}<span>{{END}}{{$czas}}{{UNLESS $zablokuj_edycja}}</span>{{END}}</td>
			<td class="bil {{UNLESS $zablokuj_edycja}}{{IF teamNieWybrany}}zaznacz{{END}}{{END}}">{{UNLESS $zablokuj_edycja}}<span>{{END}}{{$team}}{{UNLESS $zablokuj_edycja}}</span>{{END}}</td>
			<td class="akcja">
				{{UNLESS $zablokuj_edycja}}
				<a class="btn btn-danger fR usun tip-top" data-original-title="{{$usun_etykieta}}" href="javascript:void(0);"><i class="icon icon-minus-sign-alt"></i></a> 
				{{END}}
				<a class="btn btn-primary fR podglad tip-top" data-original-title="{{$podglad_etykieta}}" onclick="modalAjax(this.href); return false;" href="{{$linkPodglad}}" >
					<i class="icon icon-search"></i>
				</a>
				<a class="btn btn-primary fR dodaj-notatke tip-top" data-original-title="{{$notatka_etykieta}}" onclick="return otworzOkno(this.href);" href="{{$linkDodajNotatke}}" >
					<i class="icon icon-file-text"></i>
				</a>
				<a class="btn {{IF $klientIstnieje}}btn-warning{{ELSE}}btn-primary{{END}} fR user tip-top" data-original-title="{{$user_etykieta}}" onclick="modalAjax(this.href); return false;" href="{{$linkDodajKlienta}}" >
					<i class="icon icon-user"></i>
				</a>
				<button class="btn btn-success fR dodaj-wiersz tip-top" data-original-title="{{$dodaj_wiersz_etykieta}}" href="javascript:void(0);">
					<i class="icon icon-plus-sign-alt"></i> &dArr;
				</button>
				{{UNLESS $zablokuj_edycja}}
				<a class="btn btn-default fR wyczysc tip-top" data-original-title="{{$wyczysc_etykieta}}" style="display:{{IF $daneWypelnione}}}block{{ELSE}}none{{END}};" href="javascript:void(0);"><i class="icon icon-eraser"></i></a>
				{{END}}
			</td>
		</tr>
		{{END}}
		{{BEGIN mieszkanie }}
		<tr id="id_{{$id}}" class="apartament-villa" style="background:{{$bgKolor}}">
				<td class="szukaj" style="display:none;">
					{{$miasto}}, {{$ulica}} {{$apartament}}
				</td>
				<td class="apartament {{UNLESS $zablokuj_edycja}}zaznacz{{END}}">
					{{UNLESS $zablokuj_edycja}}
					<input type="checkbox" name="id_apartament" id="apartament_{{$id}}" value="{{$id}}" >
					{{END}}
					<span class="icon"><i class="fa icon-home"></i></span>
					{{$miasto}}, {{$ulica}} {{IF $id_pdf != "" }} <span class="label label-info" data-original-title="{{$id_pdf}}"> {{$id_pdf}} </span>{{END}}
					{{IF $wykonane}} <span class="label label-success" data-original-title="DONE"> DONE </span> {{END}}
					{{IF $inProgress}} <span class="label label-warning " data-original-title="IN PROGRESS"> IN PROGRESS </span> {{END}}
					{{IF $notDone}} <span class="label label-inverse" data-original-title="NOT DONE"> NOT DONE </span> {{END}}
				</td>
				<td class="data {{UNLESS $zablokuj_edycja}}{{IF dataNieWybrana}}zaznacz{{END}}{{END}}" >{{UNLESS $zablokuj_edycja}}<span>{{END}}{{$data}}{{UNLESS $zablokuj_edycja}}</span>{{END}}</td>
			<td class="czas {{UNLESS $zablokuj_edycja}}{{IF czasNieWybrany}}zaznacz{{END}}{{END}}">{{UNLESS $zablokuj_edycja}}<span>{{END}}{{$czas}}{{UNLESS $zablokuj_edycja}}</span>{{END}}</td>
			<td class="bil {{UNLESS $zablokuj_edycja}}{{IF teamNieWybrany}}zaznacz{{END}}{{END}}">{{UNLESS $zablokuj_edycja}}<span>{{END}}{{$team}}{{UNLESS $zablokuj_edycja}}</span>{{END}}</td>
				<td class="akcja">
					{{UNLESS $zablokuj_edycja}}
					<a class="btn btn-danger fR usun tip-top" data-original-title="{{$usun_etykieta}}" href="javascript:void(0);"><i class="icon icon-minus-sign-alt"></i></a>
					{{END}}
					<a class="btn btn-primary fR podglad tip-top" data-original-title="{{$podglad_etykieta}}" onclick="modalAjax(this.href); return false;" href="{{$linkPodglad}}" >
						<i class="icon icon-search"></i>
					</a>
					<a class="btn btn-primary fR dodaj-notatke tip-top" data-original-title="{{$notatka_etykieta}}" onclick="return otworzOkno(this.href);" href="{{$linkDodajNotatke}}" >
						<i class="icon icon-file-text"></i>
					</a>
					<a class="btn {{IF $klientIstnieje}}btn-warning{{ELSE}}btn-primary{{END}} user fR podglad tip-top" data-original-title="{{$user_etykieta}}"  onclick="modalAjax(this.href); return false;" href="{{$linkDodajKlienta}}" >
						<i class="icon icon-user"></i>
					</a>
					<button class="btn btn-success fR dodaj-wiersz tip-top" data-original-title="{{$dodaj_wiersz_etykieta}}" href="javascript:void(0);">
						<i class="icon icon-plus-sign-alt"></i> &dArr;
					</button>
					{{UNLESS $zablokuj_edycja}}
					<a class="btn btn-default fR wyczysc tip-top" data-original-title="{{$wyczysc_etykieta}}" style="display: {{IF $daneWypelnione}}}block{{ELSE}}none{{END}};" href="javascript:void(0);"><i class="icon icon-eraser"></i></a>
					{{END}}
				</td>
		 </tr>
	{{END}}
{{END}}
{{BEGIN edycjaSerialKonfiguracji}}
<div class="widget-box" style="width:1300px; margin: 0 auto;">
	<div id="komunikatWstaw"></div>
	<div class="widget-title">
		<ul class="nav nav-tabs">
			<li class="{{$linkKonfiguracjaAktywny}}">
				<a class="tip-top {{$linkKonfiguracjaAktywny}}" onclick="modalAjax(this.href); return false;" name="{{$konfiguracja_glowna_etykieta}}" href="{{$linkKonfiguracja}}" data-original-title="{{$konfiguracja_glowna_etykieta}}">
					{{$konfiguracja_glowna_etykieta}}
				</a>
			</li>
			<li class="{{$linkAutoKonfiguracjaAktywny}}">
				<a class="tip-top {{$linkAutoKonfiguracjaAktywny}}" onclick="modalAjax(this.href); return false;" name="{{$konfiguracja_auto_etykieta}}" href="{{$linkAutoKonfiguracja}}" data-original-title="{{$konfiguracja_auto_etykieta}}">
					{{$konfiguracja_auto_etykieta}}
				</a>
			</li>
			<li class="{{$linkSerialKonfiguracjaAktywny}}">
				<a class="tip-top {{$linkSerialKonfiguracjaAktywny}}" onclick="modalAjax(this.href); return false;" name="{{$konfiguracja_auto_etykieta}}" href="{{$linkSerialKonfiguracja}}" data-original-title="{{$konfiguracja_serial_etykieta}}">
					{{$konfiguracja_serial_etykieta}}
				</a>
			</li>
		</ul>
	</div>
	<div class="widget-content">
		<div class="alert alert-info ">
			{{$opis}}
			<a href="#" data-dismiss="alert" class="close">×</a>
		</div>
		<div>{{$etykieta}}</div>
		<div>{{$inputAtrybuty}}</div>
		
		<div>{{$etykietaOut}}</div>
		<div>{{$inputSerialOut}}</div>
		
		<input id="zapiszSerialKofiguracje" class="btn btn-success btn-large fR" style="margin-top:10px;" type="submit" value="{{$zapisz_konfiguracje}}" name="zapiszSerialKofiguracje">
		<input id="zamknijKonfiguracje" class="btn btn-default btn-large fR" style="margin:10px 10px 0 0;" type="button" value="{{$zamknij_konfiguracje}}" name="zamknij">
	</div>
</div>
	<div id="wartosci" style="display:none;">
		{{BEGIN wierszWartosci}}
		<fieldset class="para">
			<p>
				<label></label>
				<input name="serial_numbers_klucz[]" value="{{$etykieta}}" class="input_tablica_klucz" type="text">
				<label>&nbsp;-&gt;&nbsp;</label>
				<input name="serial_numbers_wartosc[]" value="{{$wartosc}}" class="input_tablica_wartosc listaPoleZPrzyciskiem" type="text">
				<label style="margin:3px;"> {{$boolenLabel}} </label><input {{$boolenWartosc}} style="margin:3px;" type="checkbox"  class="noWidth" name="serial_numbers_in_boolen[]" />
				<a class="usun_pole1 remove removeTablica btn btn-danger" href="javascript:void(0)"><i class="icon icon-remove"></i></a>
			</p>
		</fieldset>
		{{END}}
	</div>
	<div id="wartosciOut" style="display:none;">
		{{BEGIN wierszWartosciOut}}
		<fieldset class="para">
			<p>
				<label></label>
				<input name="serial_numbers_out_klucz[]" value="{{$etykieta}}" class="input_tablica_klucz" type="text">
				<label>&nbsp;-&gt;&nbsp;</label>
				<input name="serial_numbers_out_wartosc[]" value="{{$wartosc}}" class="input_tablica_wartosc listaPoleZPrzyciskiem" type="text">
				<label style="margin:3px;" >  {{$boolenLabel}} </label><input {{$boolenWartosc}} type="checkbox" style="margin:3px;" class="noWidth" name="serial_numbers_out_boolen[]" />
				<a class="usun_pole1 remove removeTablica btn btn-danger" href="javascript:void(0)"><i class="icon icon-remove"></i></a>
			</p>
		</fieldset>
		{{END}}
	</div>
	
<script type='text/javascript'>
	
	ustawWartosci();
	
	$('#zapiszSerialKofiguracje').on('click', function(){
		var serialsInEtykieta = [];
		var serialsInIloscZnakow = [];
		var serialInWymaganeZdjecia = [];
		
		var serialsOutEtykieta = [];
		var serialsOutIloscZnakow = [];
		var serialOutWymaganeZdjecia = [];
		
		if($('#serial_numbers_in').children('.para').length)
		{
			$('#serial_numbers_in').children('.para').each(function(){
				var klucz = $(this).find('.input_tablica_klucz').val();
				if(klucz != '')
				{
					serialsInEtykieta.push(klucz);
					serialsInIloscZnakow.push($(this).find('.input_tablica_wartosc').val());
					serialInWymaganeZdjecia.push($(this).find('.noWidth').is(':checked'));
				}
			});
		}
		if($('#serial_numbers_out').children('.para').length)
		{
			$('#serial_numbers_out').children('.para').each(function(){
				var klucz = $(this).find('.input_tablica_klucz').val();
				if(klucz != '')
				{
					serialsOutEtykieta.push(klucz);
					serialsOutIloscZnakow.push($(this).find('.input_tablica_wartosc').val());
					serialOutWymaganeZdjecia.push($(this).find('.noWidth').is(':checked'));
				}
			});
		}
		var daneDoWyslania =  {
			serialsInEtykieta: serialsInEtykieta, 
			serialsInIloscZnakow: serialsInIloscZnakow, 
			serialsOutEtykieta: serialsOutEtykieta, 
			serialsOutIloscZnakow: serialsOutIloscZnakow,
			serialOutWymaganeZdjecia: serialOutWymaganeZdjecia,
			serialInWymaganeZdjecia: serialInWymaganeZdjecia,
		};
		
		
		ajax("{{$linkZapiszSerialNumber}}" , succesZapisz, daneDoWyslania, 'POST', 'json' ); 
	});
	
	function succesZapisz(dane)
	{
		$('#komunikatWstaw').html('');
		$('#komunikatWstaw').append(dane.komunikat);
	}
	
	function ustawWartosci()
	{
		var wartosciInputa = $('#wartosci').html();
		if(wartosciInputa != "")
			$('#serial_numbers_in').prepend(wartosciInputa);
		
		var wartosciInputaOut = $('#wartosciOut').html();
		if(wartosciInputaOut != "")
			$('#serial_numbers_out').prepend(wartosciInputaOut);
	}
	
</script>
{{END edycjaSerialKonfiguracji}}

{{BEGIN edycjaAutoKonfiguracji}}
<div class="widget-box" style="width:1300px; margin: 0 auto;">
	<div class="widget-title">
		<ul class="nav nav-tabs">
			<li class="{{$linkKonfiguracjaAktywny}}">
				<a class="tip-top {{$linkKonfiguracjaAktywny}}" onclick="modalAjax(this.href); return false;" name="{{$konfiguracja_glowna_etykieta}}" href="{{$linkKonfiguracja}}" data-original-title="{{$konfiguracja_glowna_etykieta}}">
					{{$konfiguracja_glowna_etykieta}}
				</a>
			</li>
			<li class="{{$linkAutoKonfiguracjaAktywny}}">
				<a class="tip-top {{$linkAutoKonfiguracjaAktywny}}" onclick="modalAjax(this.href); return false;" name="{{$konfiguracja_auto_etykieta}}" href="{{$linkAutoKonfiguracja}}" data-original-title="{{$konfiguracja_auto_etykieta}}">
					{{$konfiguracja_auto_etykieta}}
				</a>
			</li>
			<li class="{{$linkSerialKonfiguracjaAktywny}}">
				<a class="tip-top {{$linkSerialKonfiguracjaAktywny}}" onclick="modalAjax(this.href); return false;" name="{{$konfiguracja_auto_etykieta}}" href="{{$linkSerialKonfiguracja}}" data-original-title="{{$konfiguracja_serial_etykieta}}">
					{{$konfiguracja_serial_etykieta}}
				</a>
			</li>
		</ul>
	</div>
	{{IF $plikIstnieje}}
	<div class="alert alert-error" style="margin: 10px;">
		{{$komunikatPlikIstnieje}}
		<a class="close" data-dismiss="alert" href="#">×</a>
	</div>
	{{END plikIstnieje}}
	
	{{BEGIN brakKonfiguracji}}
	<div class="alert alert-warning" style="margin: 10px;">
		{{$komunikat}}
		<a class="close" data-dismiss="alert" href="#">×</a>
	</div>
	{{END brakKonfiguracji}}
	<div class="widget-content nopadding">
		<form id="formularzAutoKonfiguracja" name="formularzAutoKonfiguracja" method="post" >
		<table class="table table-bordered apartamenty-tabela" >
			<tbody>
				{{BEGIN teamKonfiguracja}}
				<tr>
					<th colspan="2" class="auto-konfiguracja-naglowek" >
						<span class="label label-info"><i class="icon icon-truck"></i> {{$team}}</span>
					</th>
				</tr>
				<tr>
					<td style="width:50%;">
						<ul class="quick-actions box-auto-konfiguracja rightImportant godziny-auto-konfiguracja" id="team-czas-{{$idTeam}}">
							<li class="add zaznaczLiCzas">Time <i class="icon icon-check fR"></i></li>
							{{BEGIN liCzas}}
							<li value="{{$wartosc}}" >
								<i class="icon icon-time not-edit" ></i>
								<span>{{$wartosc}}</span>
							</li>
							{{END liCzas}}
						</ul>
					</td>
					<td >
						<ul class="quick-actions box-auto-konfiguracja dni-auto-konfiguracja" id="team-data-{{$idTeam}}">
							<li class="add zaznaczLiData">Date <i class="icon icon-check fR"></i></li>
							{{BEGIN liData}}
							<li style="background: {{$kolor}}" {{IF $podswietl}} class="dataWypelniona" {{END}} >
								<i class="icon icon-calendar not-edit"></i>
								<span>{{$wartosc}}</span>
								
								<input type="checkbox" class="auto-konfiguracja-podglad" name="dataTeam_{{$idTeam}}" value="{{$wartosc}}" />
								
								{{IF $podswietl}}
								<!--
								<div class="btn btn-xs btn-success auto-konfiguracja-podglad" rel="podglad-idTeam-{{$idTeam}}">
									<i class="icon icon-search not-edit no-border"></i>
								</div>
								-->
								{{END}}
							</li>
							{{END liData}}
						</ul>
					</td>
					
				</tr>
				{{END}}
			</tbody>
		</table>
		<input id="zapiszAutoKonfiguracje" class="btn btn-success btn-large fR" style="margin-top:10px;" type="submit" value="{{$zapisz_konfiguracje}}" name="zapiszAutoKofiguracje">
		<input id="zamknijKonfiguracje" class="btn btn-default btn-large fR" style="margin:10px 10px 0 0;" type="button" value="{{$zamknij_konfiguracje}}" name="zamknij">
		
		</form>
	</div>
</div>
		<script type='text/javascript'>
			if(typeof(jestNstOb) === "undefined")
			{
				var jestNstOb = 0;
			}
			teamDataCzas = [];
			function pobierzKonfiguracje()
			{
				$.ajax({
					url: "{{$linkPbierzAutokofiguracja}}",
					type: 'POST',
					dataType: 'json',
					async: true,
					success: function(dane) {
						if(dane['kod'] == 2)
						{
							alertModal(dane['error']);
							return false;
						}
						else
						{
							teamDataCzas = dane;
						}
					},
					error: function (xhr, ajaxOptions, thrownError) {
						var error = 'Save data failed: '+xhr.status;
						if (thrownError != '') 
						{
							error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
							error += xhr.responseText;
						}
						alertModal('AJAX request error' ,error);
						return false;
					}
				});
			}
			
			function sprawdzCzyWszystkieGdzinyZaznaczone(idTeam)
			{
				if($('#team-czas-'+idTeam).children('li.zaznaczona-opcja').length > 0)
				{
					$('#team-czas-'+idTeam).children('li.add').children('.icon').addClass('icon-check-empty').removeClass('icon-check');
				}
				else
				{
					$('#team-czas-'+idTeam).children('li.add').children('.icon').addClass('icon-check').removeClass('icon-check-empty');
				}
			}
			
			$(document).ready(function () {
				
				pobierzKonfiguracje();
				$('input[name^="dataTeam_"]').on('click', function(e){
						$(this).parent('li').removeClass('zaznaczona-opcja');
						e.stopPropagation();
					});
				if (jestNstOb == 0)
				{
					// zaznacza i odznacza wszystkie daty
					$('.zaznaczLiData').live('click', function(){
						
						var ikonka = $(this).children('.icon');
						ikonka.toggleClass('icon-check icon-check-empty');
						var idTeam = $(this).parent('ul').attr('id').replace('team-data-', '');
						
						// zaznaczamy wszystkie checkboxy
						if(ikonka.hasClass('icon-check-empty'))
						{
							$('ul#team-czas-'+idTeam).children('li').removeClass('zaznaczona-opcja');
							if($('ul#team-czas-'+idTeam).children('li.zaznaczLiCzas').children('.icon').hasClass('icon-check-empty'))
								$('ul#team-czas-'+idTeam).children('li.zaznaczLiCzas').children('.icon').toggleClass('icon-check-empty icon-check');
							
							$('input[name="dataTeam_'+idTeam+'"]').each(function(){
								if(!$(this).is(':checked'))
								{
									$(this).click();
								}
							});
						}
						else // odznaczamy checkboxy
						{
							$('input[name="dataTeam_'+idTeam+'"]').each(function(){
								if($(this).is(':checked'))
									$(this).click();
							});
						}
						
					});
					
					
					
					// zaznacza i odznacza wszystkie godziny
					$('.zaznaczLiCzas').live('click', function(){
						
						var ikonka = $(this).children('.icon');
						ikonka.toggleClass('icon-check icon-check-empty');
						var przyciskZaznaczWszystko = $(this);
						var idTeam = $(this).parent('ul').attr('id').replace('team-czas-', '');
						var zaznaczonaData = $('ul#team-data-'+idTeam).children('li.zaznaczona-opcja').children('span').text();
						
						var zaznaczoneDaty = $('input[name="dataTeam_'+idTeam+'"]:checked');
						if(ikonka.hasClass('icon-check-empty'))
						{
							przyciskZaznaczWszystko.siblings('li:not(.add)').addClass('zaznaczona-opcja');
							if(zaznaczoneDaty.length > 0)
							{
								zaznaczoneDaty.each(function(){
									var data = $(this).val();
									usunZkonfiguracji(data, 'all', idTeam);
									przyciskZaznaczWszystko.siblings('li:not(.add)').each(function(){
										var godzina = $(this).children('span').text();
										dodajDoKonfiguracji(data, godzina , idTeam);
									});
								});
							}
							else if(zaznaczonaData!='')
							{
								usunZkonfiguracji(zaznaczonaData, 'all', idTeam);
								przyciskZaznaczWszystko.siblings('li:not(.add)').each(function(){
									var godzina = $(this).children('span').text();
									dodajDoKonfiguracji(zaznaczonaData, godzina , idTeam);
								})
							}
						}
						else
						{
							przyciskZaznaczWszystko.siblings('li:not(.add)').removeClass('zaznaczona-opcja');
							if(zaznaczoneDaty.length > 0)
							{
								zaznaczoneDaty.each(function(){
									var data = $(this).val();
									przyciskZaznaczWszystko.siblings('li:not(.add)').each(function(){
										var godzina = $(this).children('span').text();
										usunZkonfiguracji(data, godzina , idTeam);
									});
								});
							}
							else if(zaznaczonaData!='')
							{
								przyciskZaznaczWszystko.siblings('li:not(.add)').each(function(){
									var godzina = $(this).children('span').text();
									usunZkonfiguracji(zaznaczonaData, godzina , idTeam);
								})
							}
						}
					});
					
					// kliknięci w wiersz z datą
					$('.dni-auto-konfiguracja li:not(.add)').live('click', function(){
						
						var idTeamData = $(this).parent('ul').attr('id').replace('team-data-', '');
						
						if($('input[name^="dataTeam_'+idTeamData+'"]').is(':checked'))
							return false;
						
						// jesli zaznaczony to odznaczamy
						if($(this).is('.zaznaczona-opcja'))
						{
							$(this).removeClass('zaznaczona-opcja');
							$('#team-czas-'+idTeamData).children('li').removeClass('zaznaczona-opcja');
						}
						else
						{
							// zaznaczamy wiersz z datą
							//var tablicaGodzin = null;
							$(this).siblings('li').removeClass('zaznaczona-opcja');
							$(this).addClass('zaznaczona-opcja');
							$('#team-czas-'+idTeamData).children('li').removeClass('zaznaczona-opcja');
							
							var data = $(this).children('span').text();
							if( typeof teamDataCzas[idTeamData] != 'undefined' && typeof teamDataCzas[idTeamData][data] != 'undefined')
							{
								var tablicaGodzin = [];
								var i = 0;
								for(var i = 0; teamDataCzas[idTeamData][data].length > i ; i++){
									tablicaGodzin[i] = teamDataCzas[idTeamData][data][i];
								};
								var listaGodzin = $('#team-czas-'+idTeamData).children('li');

								listaGodzin.each(function(){
									var szukanyText = $(this).children('span').text();
									var szukajWtablicy = jQuery.inArray(szukanyText, tablicaGodzin);
									if(szukajWtablicy !== -1)
									{
										$(this).addClass('zaznaczona-opcja');
										tablicaGodzin.splice(szukajWtablicy, 1);
									}
								});
							}
						}
						sprawdzCzyWszystkieGdzinyZaznaczone(idTeamData);
					});
					
					$('#zapiszAutoKonfiguracje').live('click', function(){
						zapiszAutoKonfiguracje();
						return false;
					});
					
					function dodajDoKonfiguracji(data, czas, idTeam)
					{
						if(typeof teamDataCzas[idTeam] == 'undefined')
						{
							teamDataCzas[idTeam] = {};
							teamDataCzas[idTeam][data] = [];
							teamDataCzas[idTeam][data].push(czas);
							
						}
						else if(typeof teamDataCzas[idTeam][data] != 'undefined')
						{
							teamDataCzas[idTeam][data].push(czas);
						}
						else
						{
							teamDataCzas[idTeam][data] = [];
							teamDataCzas[idTeam][data].push(czas);
							
						}
						if(teamDataCzas[idTeam][data].length > 0)
							$('input[name="dataTeam_'+idTeam+'"][value="'+data+'"]').parent('li').addClass('dataWypelniona');
					}
					
					function usunZkonfiguracji(data, czas, idTeam)
					{
						if(typeof teamDataCzas[idTeam] === 'undefined' || typeof teamDataCzas[idTeam][data] === 'undefined')
						{
							return false;
						}
						else if(typeof teamDataCzas[idTeam][data] != 'undefined')
						{
							if(czas == "all")
							{
								teamDataCzas[idTeam][data] = [];
							}
							else
							{
								var pozycja = $.inArray(czas, teamDataCzas[idTeam][data]);
								if(pozycja !==-1)
									teamDataCzas[idTeam][data].splice($.inArray(czas, teamDataCzas[idTeam][data]), 1);
							}
						}
						
						if(typeof teamDataCzas[idTeam][data] != 'undefined' && teamDataCzas[idTeam][data].length == 0)
							$('input[name="dataTeam_'+idTeam+'"][value="'+data+'"]').parent('li').removeClass('dataWypelniona');
						
					}
					
					function zapiszAutoKonfiguracje()
					{
						var przydzielenie = { przydzielenie : teamDataCzas };
						$.ajax({
								url: "{{$linkZapiszKonfiguracje}}",
								type: 'POST',
								dataType: 'json',
								data: przydzielenie,
								async: true,
								success: function(dane) {
									 if(dane.kod == 1)
									 {
										 $('#zamknijKonfiguracje').click();
									 }
									 else
									 {
										 alertModal('Error '+dane.kod ,dane.info);
									 }
								},
								error: function (xhr, ajaxOptions, thrownError) {
									var error = 'Save data failed: '+xhr.status;
									if (thrownError != '') 
									{
										error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
										error += xhr.responseText;
									}
									alertModal('AJAX request error' ,error);
									return false;
								}
							});
							return false;
					}
				
					$('.godziny-auto-konfiguracja li:not(.add)').live('click', function(){
						
						var idTeam = $(this).parent('ul').attr('id').replace('team-czas-', '');
						var znaznaczonaGodzina = $(this).children('span').text();
						var zaznaczonaData = $('#team-data-'+idTeam).children('li.zaznaczona-opcja');
						
						
						var zaznaczoneDaty = $('input[name="dataTeam_'+idTeam+'"]:checked');
						
						if($(this).is('.zaznaczona-opcja'))
						{
							if(zaznaczoneDaty.length > 0)
							{
								zaznaczoneDaty.each(function(){
									usunZkonfiguracji($(this).val() ,znaznaczonaGodzina, idTeam);
								});
								
							}
							else
							{
								usunZkonfiguracji(zaznaczonaData.children('span').text() ,znaznaczonaGodzina , idTeam);
							}
							$(this).removeClass('zaznaczona-opcja');
						}
						else
						{
							$(this).addClass('zaznaczona-opcja');
							var zaznaczoneGodziny = $('ul#team-czas-'+idTeam).children('li.zaznaczona-opcja');
							if(zaznaczoneDaty.length > 0)
							{
								if(zaznaczoneGodziny.length == 1)
								{
									zaznaczoneDaty.each(function(){
										usunZkonfiguracji($(this).val() , 'all', idTeam);
									});
								}
								zaznaczoneDaty.each(function(){
									dodajDoKonfiguracji($(this).val() ,znaznaczonaGodzina, idTeam);
								});
								
							}
							else
							{
								dodajDoKonfiguracji(zaznaczonaData.children('span').text() ,znaznaczonaGodzina, idTeam);
							}
							
						}
					});
					
					$('#formularzAutoKonfiguracja').live('submit', function(){
						
						$.ajax({
							url: "{{$linkZapiszKonfiguracje}}",
							type: 'POST',
							dataType: 'json',
							data: $(this).serialize(),
							async: true,
							success: function(dane) {
								if(dane['kod'] == 2)
								{
									alertModal(dane['error']);
									return false;
								}
								else
								{
									$('.close').click();
									return false;
								}
							},
							error: function (xhr, ajaxOptions, thrownError) {
								var error = 'Save data failed: '+xhr.status;
								if (thrownError != '') 
								{
									error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
									error += xhr.responseText;
								}
								alertModal('AJAX request error' ,error);
								return false;
							}
						});
						return false;
					});
					jestNstOb++;
				}
			});
			
		</script>
{{END}}
{{BEGIN edycjaKonfiguracji}}
<div class="widget-box" style="width:1300px; margin: 0 auto;">
	<div class="widget-title">
		<ul class="nav nav-tabs">
			<li class="{{$linkKonfiguracjaAktywny}}">
				<a class="tip-top {{$linkKonfiguracjaAktywny}}" onclick="modalAjax(this.href); return false;" name="{{$konfiguracja_glowna_etykieta}}" href="{{$linkKonfiguracja}}" data-original-title="{{$konfiguracja_glowna_etykieta}}">
					{{$konfiguracja_glowna_etykieta}}
				</a>
			</li>
			<li class="{{$linkAutoKonfiguracjaAktywny}}">
				<a class="tip-top {{$linkAutoKonfiguracjaAktywny}}" onclick="modalAjax(this.href); return false;" name="{{$konfiguracja_auto_etykieta}}" href="{{$linkAutoKonfiguracja}}" data-original-title="{{$konfiguracja_auto_etykieta}}">
					{{$konfiguracja_auto_etykieta}}
				</a>
			</li>
			<li class="{{$linkSerialKonfiguracjaAktywny}}">
				<a class="tip-top {{$linkSerialKonfiguracjaAktywny}}" onclick="modalAjax(this.href); return false;" name="{{$konfiguracja_auto_etykieta}}" href="{{$linkSerialKonfiguracja}}" data-original-title="{{$konfiguracja_serial_etykieta}}">
					{{$konfiguracja_serial_etykieta}}
				</a>
			</li>
		</ul>
	</div>
	{{IF $plikIstnieje}}
	<div class="alert alert-error" style="margin: 10px;">
		{{$komunikatPlikIstnieje}}
		<a class="close" data-dismiss="alert" href="#">×</a>
	</div>
	{{END plikIstnieje}}
	<div class="widget-content nopadding">
	<table class="table table-bordered apartamenty-tabela" >
		<tbody>
			<tr >
				<td class="nopadding" style="width: 33%;">
					<div class="widget-box konfiguracja-box">
						<div class="widget-title"><h5>Date</h5></div>
						<div class="widget-content konfiguracja-content">
						<table class="table konfiguracja">
							 
							<tr class="dataKonfigPoczatek">
								<td >
									<div class="input-append" style="width:120px;">
										<input class="dateStartKonfiguracjaPoczatkowa" value="{{$data}}" type="text" name="dateStartKonfiguracjaPoczatkowa" title="dd.mm.yyyy" data-date-format="dd.mm.yyyy" style="width: 85px;">
										<span class="add-on">
											<i class="icon-calendar"></i>
										</span>
									</div>
								</td>
								<td>
									<div class="input-append" style="width:120px;">
										<input class="dateStopKonfiguracjaPoczatkowa" value="{{$data}}" type="text" name="dateStartKonfiguracjaPoczatkowa" title="dd.mm.yyyy" data-date-format="dd.mm.yyyy" style="width: 85px;">
										<span class="add-on">
											<i class="icon-calendar"></i>
										</span>
									</div>
								</td>
								<td>
									<a class="btn btn-success fR zatwierdzDaty" href="javascript:void(0);">
										<i class="icon icon-check"></i>
									</a>
								</td>
							</tr>
							{{BEGIN dataWiersz}}
							<tr class="dataWierszKonfiguracja">
								<td class="dataKonfig">
									<div class="input-append" style="width:120px;">
										<input class="dateStartKonfiguracja" value="{{$data}}" type="text" name="dateStartKonfiguracja" title="dd.mm.yyyy" data-date-format="dd.mm.yyyy" style="width: 85px;">
										<span class="add-on">
											<i class="icon-calendar"></i>
										</span>
									</div>
								</td>
								<td class="kolorKonfig">
									<div class="demo2">
										<input type="text" style="width:70px;" value="{{$kolor}}" class="form-control dataKolor" />
										<span class="input-group-addon"><i></i></span>
									</div>
								</td>
								<td>
									<a class="btn btn-danger fR usunKonfiguracja" href="javascript:void(0);">
										<i class="icon icon-minus-sign-alt"></i>
									</a>
								</td>
							</tr>
							{{END}}
							<tr>
								<td></td>
								<td></td>
								<td>
									<button class="btn btn-primary fR dodaj-date-konfiguracja" href="javascript:void(0);">
										<i class="icon icon-plus-sign-alt"></i>
									</button>
								</td>
							</tr>
						</table>
						</div>
					</div>
				</td>
				<td class="nopadding" style="width: 33%;">
					<div class="widget-box konfiguracja-box" >
						<div class="widget-title"><h5>Time</h5></div>
						<div class="widget-content konfiguracja-content">
						<table class="table konfiguracja">
							<tr>
								<td colspan="3">
									<select id="selectKonfiguracjaCzasu" name="selectKonfiguracjaCzasu">
										<option>{{$wybierz_konfiguracje_etykieta}}</option>
										{{BEGIN optionKonfiguracjaCzasu}}
										<option>{{$nazwa}}</option>
										{{END}}
									</select>
								</td>
							</tr>
							{{BEGIN timeWiersz}}
							<tr class="dodanyCzas">
								<td class="timeKonfiguracja">
									<div class="input-append bootstrap-timepicker" style="width: 85px; float: left;">
										<input id="godzinaOd" class="timepicker input-small long" type="text" name="godzinaOd" value="{{$czasOd}}" data-minute-step="15" style="width: 40px;">
										<span class="add-on">
										<i class="icon-time"></i>
										</span>
									</div>
									<div class="input-append bootstrap-timepicker" style="float: left;">
										<input id="godzinaDo" class="timepicker input-small long" type="text" name="godzinaDo" value="{{$czasDo}}" data-minute-step="15" style="width: 40px; margin-left: 7px;">
										<span class="add-on">
										<i class="icon-time"></i>
										</span>
									</div>
								</td>
								<td>
									<a class="btn btn-danger fR usunKonfiguracja" href="javascript:void(0);">
										<i class="icon icon-minus-sign-alt"></i>
									</a>
								</td>
							</tr>
							{{END}}
							<tr>
								<td></td>
								<td>
									<button class="btn btn-primary fR dodaj-czas-konfiguracja" href="javascript:void(0);">
										<i class="icon icon-plus-sign-alt"></i>
									</button>
								</td>
							</tr>
							<tr>
								<td colspan="2" >
									{{$zapisz_konfiguracje_etykieta}} <input type="checkbox" id="zapiszGodzinyKofiguracji" name="zapiszGodzinyKofiguracji" />
									<br/>
									<span style="display: none;" class="nazwaKonfiguracji">
										<label class="control-label input_ok wymagany" for="numberPrivatCustomer">{{$nazwa_konfiguracji_etykieta}} </label>
										<input type="text" id="nazwaKonfiguracji" name="nazwaKonfiguracji" value="" />
									</span>
									
								</td>
							</tr>
						</table>
						</div>
					</div>
				</td>
				<td class="nopadding" style="width: 33%;">
					<div class="widget-box konfiguracja-box">
						<div class="widget-title"><h5>Team</h5></div>
						<div class="widget-content konfiguracja-content">
						<table class="table teamKonfiguracja konfiguracja">
							{{BEGIN teamWiersz}}
							<tr class="team-konfiguracja">
								<td class="teamKonfiguracjaWiersz">
									{{$team}}
								</td>
								<td>
									<a class="btn btn-danger fR usunKonfiguracja" href="javascript:void(0);">
										<i class="icon icon-minus-sign-alt"></i>
									</a>
								</td>
							</tr>
							{{END}}
							<tr>
								<td></td>
								<td>
									<button class="btn btn-primary fR dodaj-team-konfiguracja" href="javascript:void(0);">
										<i class="icon icon-plus-sign-alt"></i>
									</button>
								</td>
							</tr>
						</table>
						</div>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
	<input id="zapiszKonfiguracje" class="btn btn-success btn-large fR" style="margin-top:10px;" type="submit" value="{{$zapisz_konfiguracje}}" name="zapisz">
	<input id="zamknijKonfiguracje" class="btn btn-default btn-large fR" style="margin:10px 10px 0 0;" type="button" value="{{$zamknij_konfiguracje}}" name="zamknij">
	</div>
</div>
	<script>
		var tags = Array();
		
		{{BEGIN konfiguracjaCzasuJs}}
			tags['{{$nazwa}}'] = [
					{{$opcje}},
			];
		{{END}}
		
		var opts = {showMeridian: false, defaultTime: false};
		
		$('#selectKonfiguracjaCzasu').bind('change', function(){
			var opcjaWybrana = $('#selectKonfiguracjaCzasu option:selected').text();
			var tablica = tags[opcjaWybrana];
			
			var wierszeDoUsuniecia = $('.dodanyCzas');
			var wiersz = $(this).parents('tr').next();
			for (var n = 0; n < tablica.length; n++)
			{
				if(tablica[n] !== '' && jQuery.type( tablica[n] ) !== "undefined")
				{
					var godziny = tablica[n].split('-');
					var nowyWiersz = wiersz.clone();
					if(godziny[0] != '')
					{
						nowyWiersz.children('td.timeKonfiguracja').find('#godzinaOd').val(godziny[0]).timepicker(opts);
						nowyWiersz.children('td.timeKonfiguracja').find('#godzinaDo').val(godziny[1]).timepicker(opts);
						wiersz.before(nowyWiersz);
						nowyWiersz.children('td:last').children('a').show();
					}
				}
			}
			wierszeDoUsuniecia.remove();
		});
		$('#zamknijKonfiguracje').live('click', function(){
			$('.close').click();
		});
		
		
		
		setTimeout(function(){
					$(".timepicker").timepicker(opts);
					$("select[name='teamKonfiguracja']").select2();
					$("#selectKonfiguracjaCzasu").select2();
					$('.demo2').colorpicker();
					$( ".dateStartKonfiguracja" ).datepicker();
					$("#zapiszGodzinyKofiguracji").uniform();
				}, 300);
					
		$( ".dateStartKonfiguracjaPoczatkowa").datepicker();
		$( ".dateStopKonfiguracjaPoczatkowa").datepicker();
		
		if (jestNst == 0)
		{
			$('.zatwierdzDaty').live('click' , function()
			{
				var dataStart = $( ".dateStartKonfiguracjaPoczatkowa").val();
				var dataStop = $( ".dateStopKonfiguracjaPoczatkowa").val();

				$.ajax({
						url: "{{$linkPobierzZakresDat}}",
						type: 'POST',
						dataType: 'json',
						data: 'dataStart='+dataStart+'&dataStop='+dataStop,
						async: true,
						success: function(dane) {
							var wiersze = $('tr.dataWierszKonfiguracja');
							var wiersz = $('tr.dataWierszKonfiguracja:first');
							if(dane['daty'].length > 0)
							{
								for (var i = 0; i < dane['daty'].length; i++)
								{
								  var nowyWiersz = wiersz.clone();

								  wiersz.before(nowyWiersz);
								  nowyWiersz.children('.dataKonfig').find('.dateStartKonfiguracja').val(dane['daty'][i]);
								  nowyWiersz.children('.kolorKonfig').find('.dataKolor').val(dane['kolory'][i]);
								  nowyWiersz.children('td:last').children('a').show();
								}

								wiersze.remove();
								setTimeout(function(){
										  $('.dateStartKonfiguracja').datepicker();
										  $('.demo2').colorpicker();
									  }, 900);
							}
							
						},
						error: function (xhr, ajaxOptions, thrownError) {
							var error = 'Save data failed: '+xhr.status;
							if (thrownError != '') 
							{
								error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
								error += xhr.responseText;
							}
							alertModal('AJAX request error' ,error);
							return false;
						}
					});
			});
		
			$('#zapiszKonfiguracje').live('click', function(){
				zapiszEdycja();
			});
			
			$("#zapiszGodzinyKofiguracji").live('click', function(){
				if($(this).is(':checked'))
				{
					$('.nazwaKonfiguracji').show(500);
				}
				else
				{
					$('.nazwaKonfiguracji').hide(500);
				}
			});
			
			$('.dodaj-team-konfiguracja').live('click', function(){
				var wiersz = $(this).parents('tr').prev();
				var nowyWiersz = wiersz.clone();
				nowyWiersz.children('.teamKonfiguracjaWiersz').children('.select_wrap').find('#s2id_teamKonfiguracja').remove();
				wiersz.after(nowyWiersz);
				nowyWiersz.children('.teamKonfiguracjaWiersz').children('.select_wrap').find('select').removeClass();
				setTimeout(function(){
						nowyWiersz.children('.teamKonfiguracjaWiersz').children('.select_wrap').find('select').select2();
					}, 200);
				nowyWiersz.children('td:last').children('a').show();
			});

			$('.dodaj-czas-konfiguracja').live('click', function(){
				var wiersz = $(this).parents('tr').prev();
				var nowyWiersz = wiersz.clone();
				wiersz.after(nowyWiersz);
				nowyWiersz.find('#godzinaOd').timepicker(opts);
				nowyWiersz.find('#godzinaDo').timepicker(opts);
				nowyWiersz.children('td:last').children('a').show();
			});

			$('.dodaj-date-konfiguracja').live('click', function(){
				var wiersz = $(this).parents('tr').prev();
				var nowyWiersz = wiersz.clone();
				wiersz.after(nowyWiersz);
				nowyWiersz.children('td:last').children('a').show();
				setTimeout(function(){
						$('.dateStartKonfiguracja').datepicker();
						$('.demo2').colorpicker();
					}, 900);
				
			});

			$('.usunKonfiguracja').live('click', function(){
				var klasa = $(this).parents('tr').attr('class');
				if($('tr.'+klasa).length == 1)
				{
					$('tr.'+klasa).find('input').val('');
					$('tr.'+klasa).children('td:last').children('a').hide();
				}
				else if($('tr.'+klasa).length > 1)
				{
					$(this).parent('td').parent('tr').remove();
				}
				else
				{
					$('tr.'+klasa).children('td:last').children('a').show();
				}
				
				
			});

			function zapiszEdycja(){

				var teamy = $('select[name="teamKonfiguracja"] option:selected');
				var daty = $('.dataWierszKonfiguracja');
				var czasy = $('.timeKonfiguracja');
				//var idProjekt = $('#projekt').val();
				var idProjekt = {{$idProjektu}}
				var zapiszCzasy = $('#zapiszGodzinyKofiguracji').is(':checked');
				var zapiszCzasyNazwa = $('#nazwaKonfiguracji').val();

				var teamyPrzeslij = [];
				var teamyNazwy = [];
				teamy.each(function(){
					teamyPrzeslij.push($(this).val());
					teamyNazwy.push($(this).text());
				});

				var datyPrzeslij = {};
				var i = 0;
				daty.each(function(){
					datyPrzeslij[i] = {
						data: $(this).children('td.dataKonfig').find('.dateStartKonfiguracja').val(),
						kolor: $(this).children('td.kolorKonfig').find('.dataKolor').val(),
					};
					i++;
				});

				var czasyPrzeslij = [];
				czasy.each(function(){
					var dataOd = $(this).find('input[name="godzinaOd"]').val();
					var dataDo = $(this).find('input[name="godzinaDo"]').val();
					czasyPrzeslij.push(dataOd+'-'+dataDo);
				});
				
				var obj = {
					teamy: teamyPrzeslij,
					teamyNazwy: teamyNazwy,
					daty: datyPrzeslij,
					czasy: czasyPrzeslij,
					idProjektu: idProjekt,
					zapiszCzasy: zapiszCzasy,
					zapiszCzasyNazwa: zapiszCzasyNazwa,
				};
				
				if(zapiszCzasy && zapiszCzasyNazwa == "")
				{
					$('#nazwaKonfiguracji').addClass('errorInput');
					$('#nazwaKonfiguracji').after('<span class="help-inline" for="">This field cannot remain empty.</span>');
					return false;
				}
				$('.mobile-loader').fadeIn("normal");
				$.ajax({
					url: "{{$linkZapiszKonfiguracje}}",
					type: 'POST',
					dataType: 'json',
					data: obj,
					async: true,
					success: function(dane) {
						if(dane['kod'] == 2)
						{
							
							alertModal(dane['error']);
							return false;
						}
						else
						{
							aktualizujKonfiguracje();
						}
						$('.mobile-loader').fadeOut("normal");
					},
					error: function (xhr, ajaxOptions, thrownError) {
						var error = 'Save data failed: '+xhr.status;
						if (thrownError != '') 
						{
							error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
							error += xhr.responseText;
						}
						alertModal('AJAX request error' ,error);
						return false;
					}
				});
			}
			jestNst++;
		}
		</script>
{{END}}
{{BEGIN dodajKlienta}}
<script type="text/javascript">
	$('.full-width ').css('width', '80%');
	$("[name^=numberPrivatCustomer]").live('change', function(){
		if($(this).val() > 0)
		{
			$('#zapiszKlient').show(500);
		}
		else
		{
			$('#zapiszKlient').hide(500);
		}
	});
	
	$('#zapiszKlient').live('click', function(){
			dodajKlienta();
		});
	
	function pobierzKlienta(dane)
	{
		zapiszKlienta(dane.id);
	}
	
	function dodajKlienta()
	{
		var klientId = $("[name^=numberPrivatCustomer]").val();
		zapiszKlienta(klientId);
	}
	function zapiszKlienta(idKlienta)
	{
		$.ajax({
				url: "{{$linkZapiszKlienta}}",
				type: 'POST',
				dataType: 'json',
				data: 'klientId='+idKlienta,
				async: true,
				success: function(dane) {
					if(dane['kod'] == 2)
					{
						alertModal('Error', dane['error']);
						return false;
					}
					else
					{
						$('#id_'+dane['id']).children('td.akcja').find('.user').addClass('btn-warning').removeClass('btn-primary');
						$('.close').click();
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					var error = 'Save data failed: '+xhr.status;
					if (thrownError != '') 
					{
						error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
						error += xhr.responseText;
					}
					alertModal('AJAX request error' ,error);
					return false;
				}
			});
	}
</script>
{{$formularz}}
{{END}}
{{BEGIN podgladKlienta}}
<div class="widget-box">
	<div class="widget-title">
		<h5>{{$klient_naglowek}}</h5>
	</div>
	<div class="widget-content nopadding">
		<table class="table table-bordered apartamenty-tabela">
			<tbody>
				<tr>
					<td>{{$imie}} </td>
					<td>{{$klient_imie}} </td>
				</tr>
				<tr>
					<td>{{$adres}}</td>
					<td>{{$klient_address}} </td>
				</tr>
				{{IF adresKorespondencyjnyIstnieje}}
				<tr>
					<td>{{$adresKorespondencyjny}}</td>
					<td>{{$klient_adresKorespondencyjny}}</td>
				</tr>
				{{END}}
				<tr>
					<td>{{$telefon}}</td>
					<td>{{$klient_telefon}}</td>
				</tr>
				<tr>
					<td>{{$mail}} </td>
					<td>{{$klient_mail}} </td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
{{END}}
{{BEGIN pdf}}
<!DOCTYPE html>
<html lang="no">
	<head>
		<meta charset="UTF-8" />
		<style type="text/css">
			body{
				font-family: Oswald;
				font-size: 5pt;
			}
			.strong{
				font-family: oswaldbold;
			}
			.etykietaStopka{
				color:#20a7d4;
			}
		</style>
	</head>
	<body style="background-image:url({{$tlo}});  background-image-resize: 1; font-size:10pt; ">
	<div style="background:#21a8d5; position: absolute; left: 0; top: 0; bottom:0; width:30px; height: 100%; float: left;" >
	
	</div>
	 
	{{BEGIN header}}
	<table cellSpacing="0" cellPadding="0" border="0" align="left" width="620px" style="padding: 0px; margin-top:60px;">
		<tr>
			<td style="width: 50%"><img src="{{$logo}}" alt="{{$logo_alt}}" style="position: absolute; left: 0; top: 0; width: 228px" /></td>
		</tr>
		<tr>
			<td style="padding-top:10px; text-transform: uppercase; font-size: 7pt; color:#373737;">
				<!--
				{{$adres_wartosc}}, {{$miasto_wartosc}} {{$znaczek_rozdziel}} {{$org_numer_etykieta}} {{$org_numer_wartosc}}<br/>
				{{$bankgiro_etykieta}} {{$bankgiro_wartosc}} {{$znaczek_rozdziel}} {{$telefon_etykieta}} {{$telefon_wartosc}}<br/>
				{{$email_etykieta}} {{$email_wartosc}} {{$znaczek_rozdziel}} {{$www_wartosc}}
				-->
			</td>
		</tr>
	</table>
	{{END}}
	{{BEGIN htmlSzablon}}
		{{$tresc}}
		{{BEGIN pagebreak}}
			<pagebreak />
		{{END}}
	{{END htmlSzablon}}
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
	
	</body>
</html>
{{END}}
{{BEGIN dodajInformacje}}
<script>
$(document).ready(function () {
		$('#zapisz').live('click', function(){
			$('.mobile-loader').fadeIn("normal");
		});
		$('#podgladNaZywo').live('click', function(){
			//$('.mobile-loader').fadeIn("normal");
			var instalacja = $('#cke_cke_informacje').find('iframe').contents().find('body').html();
			var cennik = $('#cke_cke_dodatkoweCeny').find('iframe').contents().find('body').html();
			var idProjektu = $('#idProjektu').val();
			var nazwa = $('#nazwaProjektu').val();
			var szablon = $('#cke_cke_szablon').find('iframe').contents().find('body').html();
			
			var obj = {
				instalacja: instalacja,
				cennik: cennik,
				szablon: szablon,
				nazwa: nazwa,
				idProjektu: $('#idProjektu').val(),
			};
			//modalIFrame("{{$podglad_na_zywo_link}}"+'&instalacja='+instalacja+'&cennik='+cennik+'&nazwa='+nazwa+'&idProjektu='+idProjektu);
			
			$.ajax({
				url: "{{$podglad_na_zywo_link}}",
				type: 'POST',
				dataType: 'json',
				data: obj,
				async: true,
				success: function(dane) {

					 if(dane['kod'] == 2)
					 {
						 alertModal('Error', dane['error']);
					 }
					 if(dane['kod'] == 1)
					 {
						modalIFrame(dane['url']);
					 }

					 $('.mobile-loader').fadeOut("normal");
				},
				error: function (xhr, ajaxOptions, thrownError) {
					var error = 'Save data failed: '+xhr.status;
					if (thrownError != '') 
					{
						error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
						error += xhr.responseText;
					}
					alertModal('AJAX request error' ,error);
					$('.mobile-loader').fadeOut("normal");
				}
			})
			 
			return false;
		});
	});
</script>

<div class="widget-box">
	<div class="widget-title">
		<ul class="nav nav-tabs">
			<li class="{{IF $drugaTura == 0}}active{{END IF}}">
				<a class="tip-top " name="{{$etykieta_pierwsza_runda}}" href="{{$url_pierwsza_runda}}" data-original-title="{{$etykieta_pierwsza_runda}}" >
					{{$etykieta_pierwsza_runda}}
				</a>
			</li>
			<li class="{{IF $drugaTura}}active{{END IF}}">
				<a class="tip-top " name="{{$etykieta_druga_runda}}" href="{{$url_druga_runda}}" data-original-title="{{$etykieta_druga_runda}}" >
					{{$etykieta_druga_runda}}
				</a>
			</li>
		</ul>
	</div>
	<div class="widget-content">
		{{IF $plikPdfIstnieje}}
		<a class="btn btn-primary" rel="lightbox:fullPage" href="{{$pdfUrl}}" data-original-title="{{$podglad_pliku_etykieta}}" >
			<i class="icon icon-search"></i>
			{{$podglad_pliku_etykieta}}
		</a>
		{{END plikPdfIstnieje}}
		<a class="btn btn-primary" id="podgladNaZywo" data-original-title="{{$podglad_na_zywo_etykieta}}" >
			<i class="icon icon-search"></i>
			{{$podglad_na_zywo_etykieta}}
		</a>
		<a class="btn btn-warning" href="{{$urlWstecz}}" data-original-title="{{$etykietaWstecz}}" >
			<i class="icon icon-mail-reply"></i>
			{{$etykietaWstecz}}
		</a>
	</div>
</div>
{{$formularz}}
{{END}}
{{BEGIN projektyDoPrzydzieleniaKartek}}
<script>
	$(document).ready(function () {
		 
	});
	function wyslijEmail(link){
		$('.mobile-loader').fadeIn("normal");
		$.ajax({
			url: link,
			type: 'POST',
			dataType: 'json',
			async: true,
			success: function(dane) {
				
				 if(dane['kod'] == 2)
				 {
					 alertModal('Error', dane['error']);
				 }
				 if(dane['kod'] == 1)
				 {
					alertModal('Error', dane['info']);
				 }

				 $('.mobile-loader').fadeOut("normal");
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var error = 'Save data failed: '+xhr.status;
				if (thrownError != '') 
				{
					error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
					error += xhr.responseText;
				}
				alertModal('AJAX request error' ,error);
				$('.mobile-loader').fadeOut("normal");
			}
		})
		return false;
	};	
</script>

<div class="widget-box">
	<div class="widget-title">
		<ul class="nav nav-tabs">
			<li class="active">
				<a class="" title="{{$link_tab_etykieta}}" name="{{$link_tab_etykieta}}" href="{{$url_lista_projektow}}" >{{$link_tab_etykieta}} </a>
			</li>
		</ul>
	</div>
	<div id="kontener" class="widget-content nopadding">
		<div class="widokZamowien">
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="fa icon-th"></i>
					</span>
					<h5>{{$lista_projektow_etykieta}}</h5>
				</div>
				<div class="widget-content">
					{{BEGIN projekt}}
					<div id="{{$id}}_tresc" class="zakladka_tresc">
						<div id="i{{$id}}" class="portlet zamowienie">
							<div class="zamowienie-naglowek projekt" >
								
									<div class="box-naglowek">
										<span class="label label-info">
											<i class="icon icon-crop"></i>
											{{$bkt_id}} {{$id}}
										</span>
										( {{$get_projects}}{{$number_project_inkjops}} )  {{$projekt_nazwa}}
									</div>
									<div class="przyciski-margines-lewy">
									{{IF $ilosc_druga_tura > 0}}
									<a class="btn btn-success fR pozycjonowany auto-szerokosc" href="{{$link_lista_apartamentow_druga_tura}}" >
										<i class="icon icon-subscript"> </i> ({{$ilosc_druga_tura}})
									</a>
									{{END}}
									{{IF plikPdfDrugaTuraIstnieje}}
									<a class="btn btn-success fR pozycjonowany auto-szerokosc" rel="lightbox:fullPage" href="{{$urlPdfDrugaTura}}" >
										<i class="icon icon-copy"> </i>
										{{$url_pdf_etykieta}}
									</a>
									{{END plikPdfDrugaTuraIstnieje}}
									{{IF plikPdfDrugaTuraIstnieje}}
									<a class="btn btn-success wyslij-email fR pozycjonowany auto-szerokosc" onclick="wyslijEmail(this.href); return false;" href="{{$wyslij_email_url_druga_tura}}" >
										<i class="icon icon-envelope-alt"> </i>
										{{$wyslij_email_url_etykieta}}
									</a>
									{{END}}
									<a class="btn btn-warning fR pozycjonowany auto-szerokosc" href="{{$link_lista_apartamentow}}" >
										<i class="icon icon-list"> </i>
										({{$ilosc_apartamentow}}) {{$przycisk_lista_etykieta}}
									</a>
									
									{{IF plikPdfIstnieje}}
									<a class="btn btn-info fR pozycjonowany auto-szerokosc" rel="lightbox:fullPage" href="{{$urlPdf}}" >
										<i class="icon icon-file-text"> </i>
										{{$url_pdf_etykieta}}
									</a>
									{{END plikPdfIstnieje}}
									<a class="btn btn-info wyslij-email fR pozycjonowany auto-szerokosc" onclick="wyslijEmail(this.href); return false;" href="{{$wyslij_email_url}}" >
										<i class="icon icon-envelope-alt"> </i>
										{{$wyslij_email_url_etykieta}}
									</a>
									</div>
									<div class="clear"></div>
							</div>
							
							
						</div>
					</div>
					{{END projekt}}
				</div>
			</div>
		</div>
	</div>
</div>
{{END projektyDoPrzydzieleniaKartek}}
{{BEGIN listaAdresow}}
<div class="widget-box">
	<div class="widget-title">
		<ul class="nav nav-tabs">
			<li class="">
				<a class="" title="{{$link_tab_etykieta}}" name="{{$link_tab_etykieta}}" href="{{$url_lista_projektow}}" >{{$link_tab_etykieta}}</a>
			</li>
			<li class="active">
				<a class="" title="{{$addressList_tab_etykieta}}" name="{{$addressList_tab_etykieta}}" href="{{$url_address_list}}" >{{$addressList_tab_etykieta}}</a>
			</li>
		</ul>
	</div>
	<div id="kontener" class="widget-content nopadding">
		<div class="widokZamowien">
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="fa icon-th"></i>
					</span>
					<h5>{{$nazwa_projektu}}</h5>
				</div>
				<div class="widget-content">
					{{BEGIN adres}}
					<div class="zakladka_tresc">
						<div class="portlet zamowienie">
							<a class="btn btn-warning fR pozycjonowany" href="{{$link_lista_apartamentow}}" >
								<i class="icon-list"> </i>
								({{$ilosc}}) {{$przycisk_lista_etykieta}}
							</a>
							<div class="zamowienie-naglowek projekt" style="background:{{$background}};" >
								<a href="#{{$id}}">
									<div class="box-naglowek">
										{{$adres}}
									</div>
								</a>
							</div>
						</div>
					</div>
					{{END adres}}
				</div>
			</div>
		</div>
	</div>
</div>
{{END listaAdresow}}
{{BEGIN przydzielApartamentyLista}}
<script type='text/javascript'>
	var iPad = 1;
		if ( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) )
			iPad = 1;
		
		var ostatnioPrzypisanyTeam = {{$ostatnio_przypisany_team}};
		var teamName = []
		{{BEGIN teamName}}
				teamName[{{$idTeam}}] = '{{$teamNazwa}}';
		{{END teamName}}

		var teamData = [];
		{{BEGIN teamData}}
			teamData['{{$data}}'] = {
				{{BEGIN teamIlosc}}
					{{$team}}: {{$ilosc}},
				{{END}}
			};
		{{END teamData}}

	$(document).ready(function () {
		console.log(teamData);
		if(!iPad)
			$('.idTeam , .idPdf').select2();
		
		$('.zapiszPrzypisanie').live('click', function(){
			zapiszPrzypisanie($(this).parent('.zamowienie').attr('id').replace('id_', ''));
			return false;
		});
		
		$('#pokazPrzypisane').live('click', function(){
			pokazPrzypisane();
		});
		
		$('#ukryjPrzypisane').live('click', function(){
			ukryjPrzypisane();
		});
		
		$('.usunZamowienie').live('click', function(){
			var parametr = $(this).parent('.zamowienie').attr('id').replace('id_', '');
			if(!potwierdzenieModal1("{{$potwierdz_usun_zamowienie}}", "{{$potwierdz_usun_zamowienie_naglowek}}", "usunZamowienie("+parametr+")"))
			return false;
			usunZamowienie($(this).parent('.zamowienie').attr('id').replace('id_', ''));
		});
		
		$('.idPdf').live('change', function(){
			var data = $(this).children('option:selected').attr('rel');
			var teamy = Object.keys(teamData[data]);
			var selectTeam = $(this).parents('.zamowienie-naglowek').find('select.idTeam');
			var option = '';
			for(var i = 0; i < teamy.length; i++)
			{
				if(!selectTeam.is('.notChange'))
				{
					if(teamData[data][teamy[i]] > 0)
					{
						if(ostatnioPrzypisanyTeam == teamy[i])
							option += '<option value="'+teamy[i]+'" selected="selected" >'+teamName[teamy[i]]+'</option>';
						else
							option += '<option value="'+teamy[i]+'" >'+teamName[teamy[i]]+'</option>';
						
					}
				}
			}
			selectTeam.html(option);
			if(!iPad)
				selectTeam.select2();
			selectTeam.removeAttr('disabled');
		});
		
		$('#dodajApartament').live('click', function(){
			dodajApartament();
		});
		
		sprawdzCzyWszystkiePrzypisane();
	});
	
	function sprawdzCzyWszystkiePrzypisane()
	{
		if($('.zakladka_tresc:visible').size() == 0)
		{
			$('#zamowieniaPrzydzieloneInfo').show();
		}
		else
		{
			$('#zamowieniaPrzydzieloneInfo').hide();
		}
	}
	
	function dodajApartament()
	{
		$('.mobile-loader').fadeIn("normal");
		$.ajax({
			url: "{{$link_dodaj_apartament}}",
			type: 'POST',
			dataType: 'json',
			//data: 'idApartament='+id+'&idTeam='+idTeam+'&idPdf='+idPdf+'&address='+address,
			async: true,
			success: function(dane) {
				if(dane['kod'] == 2)
				{
					$('#idApp_'+id+'').find('select.idPdf').addClass('errorInput');
					alertModal('Error', dane['error']);
				}
				else if(dane['kod'] == 3)
				{
					$('#idApp_'+id+'').find('select.idTeam').addClass('errorInput');
					$('#idApp_'+id+'').find('select.idPdf').addClass('errorInput');
				}
				else
				{
					$('#listaApartamentow').prepend(dane['html']);
					setTimeout(function(){
						if(!iPad)
							$('.idTeam , .idPdf').select2();
					}, 300);
				}
				$('.mobile-loader').fadeOut("normal");
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var error = 'Save data failed: '+xhr.status;
				if (thrownError != '') 
				{
					error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
					error += xhr.responseText;
				}
				alertModal('AJAX request error' ,error);
				$('.mobile-loader').fadeOut("normal");
				return false;
			}
		});
	}
	
	function zapiszPrzypisanie(id)
	{
		var idTeam = $('#idApp_'+id+'').find('select.idTeam option:selected').val();
		var idPdf = $('#idApp_'+id+'').find('select.idPdf option:selected').val();
		var dataCzas = $('#idApp_'+id+'').find('select.idPdf option:selected').attr('rel');
		var inputEdycja = $('#id_'+id).find('input[name="address"]');
		var addressEdycja = inputEdycja.val();
		var typAddressEdycji = inputEdycja.attr('class');
		
		if(typeof addressEdycja === 'undefined') addressEdycja = "";
		if(typeof typAddressEdycji === 'undefined') typAddressEdycji = "";
		
		if(idTeam == 0 && addressEdycja == "")
		{
			$('#idApp_'+id+'').find('select.idTeam').addClass('errorInput');
			return  false;
		}
		else
			$('#idApp_'+id+'').find('select.idTeam').removeClass('errorInput');

		if(idPdf == 0  && addressEdycja == "")
		{
			$('#idApp_'+id+'').find('select.idPdf').addClass('errorInput');
			return  false;
		}
		else
			$('#idApp_'+id+'').find('select.idPdf').removeClass('errorInput');
		
		var pokazujPrzypisane = 0;
		if($('#ukryjPrzypisane').is(':visible'))
			pokazujPrzypisane = 1;
					
		var address = $.urlParam('address');
		//console.log(address); return false;
		$('.mobile-loader').fadeIn("normal");
		$.ajax({
			url: "{{$linkZapiszPrzypisanie}}",
			type: 'POST',
			dataType: 'json',
			data: 'idApartament='+id+'&idTeam='+idTeam+'&idPdf='+idPdf+'&address='+address+'&addressEdycja='+addressEdycja+'&typAddressEdycji='+typAddressEdycji+'&pokazujPrzypisane='+pokazujPrzypisane,
			async: true,
			success: function(dane) {
				if(dane['status'] == 0 && dane['error'] == 'niezalogowany')
				{
					alertModal('Error', 'You are not logged in to application. Please re login.');
				}
				else if(dane['kod'] == 2)
				{
					$('#idApp_'+id+'').find('select.idPdf').addClass('errorInput');
					alertModal('Error', dane['error']);
				}
				else if(dane['kod'] == 3)
				{
					$('#idApp_'+id+'').find('select.idTeam').addClass('errorInput');
					$('#idApp_'+id+'').find('select.idPdf').addClass('errorInput');
				}
				else
				{
					if(typeof teamData[dataCzas] != 'undefined' && typeof teamData[dataCzas][idTeam] != 'undefined')
						teamData[dataCzas][idTeam]--;
					
					$('#id_'+dane['id']).parent('.zakladka_tresc').addClass('przypisane');
					$('#id_'+dane['id']).children('.usunZamowienie').addClass('disabled');
					$('#id_'+dane['id']).children('.zapiszPrzypisanie').addClass('disabled');
					ostatnioPrzypisanyTeam = idTeam;
					
					if(addressEdycja == "" && !pokazujPrzypisane)
						ukryjZamowienie(dane['id']);
						
					setTimeout(function(){
						$('#listaApartamentow').html(dane['html']);
						if(!iPad)
							$('.idTeam , .idPdf').select2();
					}, 300);
				}
				setTimeout(function(){
						sprawdzCzyWszystkiePrzypisane();
					}, 500);
				$('.mobile-loader').fadeOut("normal");
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var error = 'Save data failed: '+xhr.status;
				if (thrownError != '') 
				{
					error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
					error += xhr.responseText;
				}
				alertModal('AJAX request error' ,error);
				$('.mobile-loader').fadeOut("normal");
				return false;
			}
		});
	}
	
	function ukryjZamowienie(id)
	{
		if(id > 0)
		{
			$('#id_'+id).parent('.zakladka_tresc').hide(500);
		}
	}
	
	function pokazPrzypisane()
	{
		$('.zakladka_tresc').show(500);
		$('#ukryjPrzypisane').show(500);
		
		setTimeout(function(){
			sprawdzCzyWszystkiePrzypisane();
		}, 500);
	}
	
	function ukryjPrzypisane()
	{
		$('.przypisane').hide(500);
		$('#ukryjPrzypisane').hide(500);
		
		setTimeout(function(){
			sprawdzCzyWszystkiePrzypisane();
		}, 500);
		
	}
	
	function usunZamowienie(id)
	{
		var usunBlok = 0;
		$.ajax({
			url: "{{$linkUsunWiersz}}",
			type: 'POST',
			dataType: 'json',
			data: "id="+id+"&usunBlok="+usunBlok,
			async: true,
			success: function(dane) {
				
				if(dane['kod'] == 1)
				{
					for(var i = 0; i < dane['zamowieniaUsuniete'].length; i++)
					{
						$('#id_'+dane['zamowieniaUsuniete'][i]).remove();
					}
				}
				$('.close').click();
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
		})
		return false;
	}
	
</script>
<div class="widget-box">
	<div class="widget-title">
		<ul class="nav nav-tabs">
			<li class="">
				<a class="" title="{{$link_tab_etykieta}}" name="{{$link_tab_etykieta}}" href="{{$url_lista_projektow}}" >{{$link_tab_etykieta}}</a>
			</li>
			<li class="">
				<a class="" title="{{$addressList_tab_etykieta}}" name="{{$addressList_tab_etykieta}}" href="{{$url_address_list}}" >{{$addressList_tab_etykieta}}</a>
			</li>
			<li class="active">
				<a class="" title="{{$apartmentsList_tab_etykieta}}" name="{{$apartmentsList_tab_etykieta}}" href="" >{{$apartmentsList_tab_etykieta}}</a>
			</li>
		</ul>
	</div>
	<div id="kontener" class="widget-content nopadding">
		<div class="widget-box">
			<div class="widget-content">
				<button id="pokazPrzypisane" class="btn btn-info" ><i class="icon icon-magic"></i> {{$pokaz_przypisane_etykieta}}</button>
				<button id="ukryjPrzypisane" class="btn btn-success" style="display:none;" ><i class="icon icon-magic"></i> {{$ukryj_przypisane_etykieta}}</button>
				<button id="dodajApartament" class="btn btn-primary"  ><i class="icon icon-plus-sign"></i> {{$dodaj_apartament_etykieta}}</button>
			</div>
		</div>
		<div class="widokZamowien">
			<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="fa icon-th"></i>
					</span>
					<h5>{{$projekt_nazwa}} - {{$address}}</h5>
				</div>
				<div class="alert alert-success" id="zamowieniaPrzydzieloneInfo" style="display:none">
					{{$info_zamowienia_przydzielone}}
					<a class="close" data-dismiss="alert" href="#"> × </a>
				</div>
				<div class="widget-content" id="listaApartamentow" >
					
				{{BEGIN apartamentyAjax}}
				{{BEGIN apartament}}
				<div class="zakladka_tresc {{IF zamowieniePrzypisane}}przypisane{{END zamowieniePrzypisane}}" {{IF displayBlock}}style="display:block;"{{ELSE}}style="display:none;"{{END}} >
					<div class="portlet zamowienie" id="id_{{$id_apartment}}">
						<button class="btn btn-primary fR pozycjonowany zapiszPrzypisanie" >
							<i class="icon icon-save"> </i>
							{{$przycisk_zatwierdz_etykieta}}
						</button>
						<button class="btn btn-danger fR pozycjonowany {{IF zamowieniePrzypisane}}disabled{{ELSE}}usunZamowienie{{END}}" style="margin-right:8px;" >
							<i class="icon icon-minus-sign"> </i>
							{{$przycisk_usun_etykieta}}
						</button>
						<div class="zamowienie-naglowek" >
							<div id="idApp_{{$id_apartment}}">
								<div class="box-naglowek" style="width: 19%;" >
									{{IF $edycja}}
										<input type="text" class="{{$typ_adres}}" name="address" value="{{$apartment}}" />
									{{ELSE}}
										{{$apartment}} {{IF klient_nazwa}} ({{$klient_nazwa}} {{$klient_telefon}}) {{END IF}}
									{{END}}
								</div>
								<div class="box-naglowek" style="float:right; width: 32%;">
									{{UNLESS $edycja}}{{$inputListaPDf}}{{END}}
								</div>
								<div class="box-naglowek" style="margin-left: 10px; width: 13%;" >
									{{UNLESS $edycja}}{{$inputTeam}}{{END}}
								</div>
							</div>
						</div>
					</div>
				</div>
				{{END apartament}}
				{{END apartamentyAjax}}
				</div>
			</div>
		</div>
	</div>
</div>
{{END przydzielApartamentyLista}}

{{BEGIN inputSelect}}
<div class="input_{{$class}}" >
<select pattern="\d*" type="number" name="{{$name}}" {{IF $disabled}}disabled="disabled"{{END disabled}} class="{{$class}}" style="width: {{$width}}px;" >
	{{BEGIN option}}
	<option value="{{$klucz}}" rel="{{$label}}" {{IF $zaznacz}}selected="selected"{{END}} >{{$wartosc}}</option>
	{{END option}}
</select>
</div>
{{END inputSelect}}

{{BEGIN wyszukiwarka}}
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
	$(document).ready(function () {
		
		if(navigator.platform == 'iPad')
			iPad = 1;
		// Zabezpieczenie przed wciśnięciem enter z przyzwyczajenia po wpisaniu frazy (na prośbę Vitalijego)
		$('#fraza').keydown(function(e){ 
			var code = (e.keyCode ? e.keyCode : e.which);
			if(code == 13) { //Enter keycode
				e.preventDefault();
				return false;
			}
		});
		
		$('#fraza').delayKeyup(function(el){
			$('#nrStrony').val({{$nrStrony}});
			$('#naStronie').val({{$naStronie}});
			
			if(el.val().length > 2)
			{
				szukaj(el.val());
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
		
		$('form#no-focus-notes').live('submit', function(){
			
			$('.mobile-loader').fadeIn("normal");
			$(this).parents('.zamowienie-informacje').children('.alert').remove();
			$.ajax({
				url: $(this).attr('action'),
				type: 'POST',
				dataType: 'json',
				data: $(this).serialize(),
				async: true,
				success: function(dane) {
					$('.zamowienie-informacje').prepend(dane['komunikat']);
					$('.mobile-loader').fadeOut("normal");
				},
				error: function (xhr, ajaxOptions, thrownError) {
					var error = 'Delete row failed: '+xhr.status;
					if (thrownError != '') 
					{
						error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
						error += xhr.responseText;
					}
					alertModal('AJAX request error' ,error);
					$('.mobile-loader').fadeOut("normal");
				}
			});
			return false;
		});
		
		$('#dodajZamowienie').live('click', function(){
			
			var elementWstaw = $(this).parents('.widok-wyszukaj-naglowek').next('.zamowienie-informacje');
			var loader = "<div id=\"loader\"></div>";
			
			if(elementWstaw.children().find('form#no-focus-dodajZamowienieForm').length)
			{
				elementWstaw.hide(500);
				elementWstaw.html("");
			}
			else
			{
				elementWstaw.show(500);
				//elementWstaw.attr('style', 'min-height:600px;');
				elementWstaw.html(loader);
				$('#loader').fadeIn(500);
				dodajZamowienieForm(elementWstaw, $(this).attr('href'));
			}
			return false;
		});
		
		$('.drugaTura').live('click', function(){
			dodajDrugaTura($(this));
			
			return false;
		});
		
		$('.pierwszaTura').live('click', function(){
			potwierdzenieModal1('{{$potwierdzPrzywrocPierwszaTura}}', '{{$potwierdzPrzywrocPierwszaTuraNaglowek}}', 'przywrocPierwszaTura(\''+$(this).attr('href')+'\')');
			return false;
		});
		
		$('form#no-focus-edytujZamowienie').live('submit', function(){
			var jestBlad = 0;
			//if( $(this).find('#team').val() > 0 ){ $(this).find('#team').removeClass('errorInput'); }else{ $(this).find('#team').addClass('errorInput'); jestBlad = 1 ; }
			if( $(this).find('#dateStart').val() != "" ){ $(this).find('#dateStart').removeClass('errorInput'); }else{ $(this).find('#dateStart').addClass('errorInput'); jestBlad = 1 ; }
			if( $(this).find('#godzinaOd').val() != "" || $(this).find('#godzinaDo').val() != "" )
			{ 
				$(this).find('#godzinaOd').removeClass('errorInput');
				$(this).find('#godzinaDo').removeClass('errorInput');
			}
			else
			{ 
				jestBlad = 1 ;
				$(this).find('#godzinaOd').addClass('errorInput');
				$(this).find('#godzinaDo').addClass('errorInput');
			}
			if(jestBlad)
				return false;
			
			var id = $(this).children('#id').val();
			$(this).parents('.zamowienie-informacje').children('.alert').remove();
			
			$('.mobile-loader').fadeIn("normal");
			$.ajax({
				url: $(this).attr('action'),
				type: 'POST',
				dataType: 'json',
				//data: $(this).serialize()+'&numberPrivatCustomer='+$(this).find("[name^=numberPrivatCustomer]").val(),
				data: $(this).serialize(),
				async: true,
				success: function(dane) {
					if(dane['error_team']){ $(this).find('#team').addClass('errorInput');  }else{ $(this).find('#team').removeClass('errorInput');  }
					if(dane['error_data']){ $(this).find('#dateStart').addClass('errorInput');  }else{ $(this).find('#dateStart').removeClass('errorInput');  }
					if(dane['error_godzina'])
					{
						$(this).find('#godzinaOd').addClass('errorInput');
						$(this).find('#godzinaDo').addClass('errorInput');
					}
					else
					{
						$(this).find('#godzinaOd').removeClass('errorInput');
						$(this).find('#godzinaDo').removeClass('errorInput');
					}
								
					$('li#zamowienie_'+id).find('.zamowienie-informacje').prepend(dane['komunikat']);
					
					if(dane['nowa_nazwa'] !='')
						$('li#zamowienie_'+id).find('strong').html(dane['nowa_nazwa']);
					
					$('.mobile-loader').fadeOut("normal");
				},
				error: function (xhr, ajaxOptions, thrownError) {
					var error = 'Delete row failed: '+xhr.status;
					if (thrownError != '') 
					{
						error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
						error += xhr.responseText;
					}
					alertModal('AJAX request error' ,error);
					$('.mobile-loader').fadeOut("normal");
				}
			});
			return false;
		});
		
		$('form#no-focus-dodajZamowienieForm').live('submit', function(){
			$('.mobile-loader').fadeIn("normal");
			$(this).parents('.zamowienie-informacje').children('.alert').remove();
			$.ajax({
				url: $(this).attr('action'),
				type: 'POST',
				dataType: 'json',
			//	data: $(this).serialize()+'&numberPrivatCustomer='+$(this).find("[name^=numberPrivatCustomer]").val(),
				data: $(this).serialize(),
				async: true,
				success: function(dane) {
					if(dane['kod'] == 1)
					{
						$('li#zamowienie_'+dane['id']).find('.zamowienie-informacje').hide(500);
						$('li#zamowienie_'+dane['id']).find('.zamowienie-informacje').html('');
						
						if(dane.nazwa_nowa!='')
							$('li#zamowienie_'+dane['id']).find('strong').html(dane.nazwa_nowa);
						
						$('li#zamowienie_'+dane['id']).after(dane.zamowienieDodane);
						setTimeout(function(){
							$('html, body').animate({
									scrollTop: (($('li#zamowienie_'+dane['id_nowe_zamowienie']).offset().top) - 170)
							},100);
						}, 300);
						$('li#zamowienie_'+dane['id_nowe_zamowienie']).find('.btn-etykieta').trigger( "click", [1, dane['komunikat'] ] );
						var ilosc = $('#ilosc').text();
						$('#ilosc').text(parseInt(ilosc)+1);
					}
					else
					{
						$('li#zamowienie_'+dane['id']).find('.zamowienie-informacje').prepend(dane['komunikat']);
					}
					$('.mobile-loader').fadeOut("normal");
				},
				error: function (xhr, ajaxOptions, thrownError) {
					var error = 'Delete row failed: '+xhr.status;
					if (thrownError != '') 
					{
						error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
						error += xhr.responseText;
					}
					alertModal('AJAX request error' ,error);
					$('.mobile-loader').fadeOut("normal");
				}
			});
			return false;
		});
		
		$('#edytujDane').live('click', function(event, dodane, komunikat){
			var elementWstaw = $(this).parents('.widok-wyszukaj-naglowek').next('.zamowienie-informacje');
			var loader = "<div id=\"loader\"></div>";
			
			if(elementWstaw.children().find('form#no-focus-edytujZamowienie').length)
			{
				elementWstaw.hide(500);
				elementWstaw.html("");
			}
			else
			{
				elementWstaw.show(500);
				elementWstaw.attr('style', 'min-height:300px;');
				elementWstaw.html(loader);
				$('#loader').fadeIn(500);
				edytujZamowienieForm(elementWstaw, $(this).attr('href'), dodane, komunikat);
			}
			return false;
		});
		
		$('.dodajNotatke').live('click', function(){
			var elementWstaw = $(this).parents('.widok-wyszukaj-naglowek').next('.zamowienie-informacje');
			var loader = "<div id=\"loader\"></div>";
			if(elementWstaw.children().find('form#no-focus-notes').length)
			{
				elementWstaw.hide(500);
				elementWstaw.html("");
			}
			else
			{
				elementWstaw.html(loader);
				$('#loader').fadeIn('normal');
				elementWstaw.attr('style', 'min-height:300px;');
				dodajNotatkeForm(elementWstaw, $(this).attr('href'));
			}
			return false;
		});
		
		$('.btn-etykieta').live('click', function(event, dodane, komunikat){

			var elementWstaw = $(this).parents('.widok-wyszukaj-naglowek').next('.zamowienie-informacje');
			var loader = "<div id=\"loader\"></div>";
			var href = $(this).attr('href');
			if(elementWstaw.is(':visible'))
			{
				if($(this).children('i').is('.icon-minus-sign'))
				{
					elementWstaw.hide(500);
					elementWstaw.html("");
					$(this).children('i').removeClass('icon-minus-sign');
					$(this).children('i').addClass('icon-plus-sign');
				}
				else
				{
					elementWstaw.html(loader);
					$('#loader').fadeIn(500);
					$(this).children('i').addClass('icon-minus-sign');
					podgladZamowienia(elementWstaw, href, dodane, komunikat);
				}
			}
			else
			{
				$(this).children('i').addClass('icon-minus-sign');
				elementWstaw.show(500);
				elementWstaw.attr('style', 'min-height:300px;');
				elementWstaw.html(loader);
				$('#loader').fadeIn(500);
				podgladZamowienia(elementWstaw, href, dodane, komunikat);
			}
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
							szukaj($('#fraza').val());
						}
					}
				}
			}
		});
		
		$('#ustaw-otwarte').live('click', function(){
				ustawOtwarte($(this));
				return false;
			})
		
		$('.usunZamowienie').live('click', function(){
			potwierdzenieModal1('{{$potwierdzUsunKomunikat}}', '{{$potwierdzUsunNaglowek}}', 'usunZamowienie(\''+$(this).attr('href')+'\')');
			return false;
		});
		
		$('.otworzZamkniete').live('click', function()
		{
			potwierdzenieModal1('{{$potwierdzZmianaStatusu}}', '{{$potwierdzZmianaStatusuNaglowek}}', 'otworzZamkniete(\''+$(this).attr('href')+'\')');
			return false;
		});
		
		$('.zamknijProjekt').live('click', function()
		{
			potwierdzenieModal1('{{$potwierdzZmianaStatusu}}', '{{$potwierdzZmianaStatusuNaglowek}}', 'zamknijProjekt(\''+$(this).attr('href')+'\')');
			return false;
		});
		
		$('.otworzProjekt').live('click', function()
		{
			potwierdzenieModal1('{{$potwierdzZmianaStatusu}}', '{{$potwierdzZmianaStatusuNaglowek}}', 'otworzProjekt(\''+$(this).attr('href')+'\')');
			return false;
		});
		
	});
	
	function zamknijProjekt(link)
	{
		ajax(link , succes, { wyslij: 1 }, 'POST', 'json' );
	}
	
	function otworzProjekt(link)
	{
		ajax(link , succes, { wyslij: 1 }, 'POST', 'json' );
	}
	
	function succes(dane) {
		if(dane.error > 0) { alertModal('Error!', dane.errorTxt); }
		$('.close').click();
		$('#fraza').keyup();
	}
	
	function otworzZamkniete(link)
	{
		$('.mobile-loader').fadeIn("normal");
		$.ajax({
			url: link,
			type: 'POST',
			dataType: 'json',
			async: true,
			success: function(dane) {
				
				if(dane['kod'] == 1)
				{
					$('#zamowienie_'+dane['id']).replaceWith(dane['html']);
				}
				else
				{
					alertModal(dane.komunikat);
				}
				$('.close').click();
				
				$('.mobile-loader').fadeOut("normal");
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var error = 'Delete row failed: '+xhr.status;
				if (thrownError != '') 
				{
					error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
					error += xhr.responseText;
				}
				alertModal('AJAX request error' ,error);
				$('.mobile-loader').fadeOut("normal");
			}
		});
		return false;
	}
	
	function usunZamowienie(link)
	{
		$.ajax({
			url: link,
			type: 'POST',
			dataType: 'json',
			async: true,
			success: function(dane) {
				if(dane.kod == 1)
				{
					$('#fraza').keyup();
					var ilosc = $('#ilosc').text();
					$('#ilosc').text(parseInt(ilosc)-1);
				}
				if(dane.kod == 2)
				{
					alertModal(dane.komunikat);
				}
				$('.close').click();
				$('.mobile-loader').fadeOut("normal");
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var error = 'Delete row failed: '+xhr.status;
				if (thrownError != '') 
				{
					error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
					error += xhr.responseText;
				}
				alertModal('AJAX request error' ,error);
				$('.mobile-loader').fadeOut("normal");
			}
		});
		return false;
	}
	
	function przywrocPierwszaTura(link)
	{
		$('.mobile-loader').fadeIn("normal");
		$.ajax({
			url: link,
			type: 'POST',
			dataType: 'json',
			//data: $(this).serialize(),
			async: true,
			success: function(dane) {
				if(dane.kod == 1)
				{
					if(dane.id != dane.id_rodzica)
						$('#zamowienie_'+dane.id).hide();
					
					$('li#zamowienie_'+dane['id_rodzica']).replaceWith(dane.html);
					
					setTimeout(function(){
						$('html, body').animate({
								scrollTop: (($('li#zamowienie_'+dane['id_rodzica']).offset().top) - 170)
						},100);
					}, 300);
					
					$('li#zamowienie_'+dane['id_rodzica']).find('#edytujDane').trigger( "click", [1, dane['komunikat'] ] );
					var ilosc = $('#ilosc').text();
					$('#ilosc').text(parseInt(ilosc)-1);
				}
				if(dane.kod == 2)
				{
					alertModal(dane.komunikat);
				}
				$('.mobile-loader').fadeOut("normal");
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var error = 'Delete row failed: '+xhr.status;
				if (thrownError != '') 
				{
					error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
					error += xhr.responseText;
				}
				alertModal('AJAX request error' ,error);
				$('.mobile-loader').fadeOut("normal");
			}
		});
		$('.close').click();
		return false;
	}
	
	function ustawOtwarte(przycisk)
	{
		$('.mobile-loader').fadeIn("normal");
		$.ajax({
			url: przycisk.attr('href'),
			type: 'POST',
			dataType: 'json',
			async: true,
			success: function(dane) {
				$('#loader').fadeOut(500);
				if(dane['kod'] == 1)
				{
					przycisk.parents('.widget-box').next('.widget-box').replaceWith(dane['html']);
					przycisk.parents('.zamowienie-informacje').prepend(dane['komunikat']);
					if(!iPad)
					{
						$('select#team').select2();
					}
					var opts = {showMeridian: false};
					$('#dateStart').datepicker({}).on('focus',function() { $(this).trigger('blur');	});
					$('li#zamowienie_'+dane['id']).find("#godzinaDo").timepicker(opts).on('focus',function() { $(this).trigger('blur'); });
					$('li#zamowienie_'+dane['id']).find("#godzinaOd").timepicker(opts).on('focus',function() { $(this).trigger('blur'); });
					$('li#zamowienie_'+dane['id']).find('.timepicker').wrap('<div class="input-append bootstrap-timepicker"></div>').after('<span class="add-on"><i class="icon-time"></i></span>');
					
					$('html, body').animate({
							scrollTop: ($('li#zamowienie_'+dane['id']).offset().top)
					  },100);
					  
					$('.mobile-loader').fadeOut("normal");
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var error = 'Delete row failed: '+xhr.status;
				if (thrownError != '') 
				{
					error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
					error += xhr.responseText;
				}
				alertModal('AJAX request error' ,error);
				$('.mobile-loader').fadeOut("normal");
			}
		});
		return false;
	}
		
	function dodajDrugaTura(obiekt)
	{
		// $('.mobile-loader').fadeIn("normal");
		$.ajax({
			url: obiekt.attr('href'),
			type: 'POST',
			dataType: 'json',
			//data: $(this).serialize(),
			async: true,
			success: function(dane) {
				if(dane.kod == 1)
				{
					//obiekt.parents('li').after(dane.html);
					//obiekt.hide();
					$('#fraza').keyup();
					var ilosc = $('#ilosc').text();
					$('#ilosc').text(parseInt(ilosc)+1);
				}
				if(dane.kod == 2)
				{
					alertModal(dane.komunikat);
				}
				$('.mobile-loader').fadeOut("normal");
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var error = 'Delete row failed: '+xhr.status;
				if (thrownError != '') 
				{
					error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
					error += xhr.responseText;
				}
				alertModal('AJAX request error' ,error);
				$('.mobile-loader').fadeOut("normal");
			}
		});
		return false;
	}
	
	$('input[name=faktura]').live('change', function(){
		$('#fraza').keyup();
	});
	
	function ukryjZamowienieInformacje(obiekt)
	{
		obiekt.parents('.zamowienie-informacje').hide(500);
	}
	
	function szukaj(fraza)
	{
		var loader = "<div id=\"loader\"></div>";
		//$('ul.wyszukiwarka-lista').attr('style' ,  'min-height : 600px;');
		if($('ul.wyszukiwarka-lista').height() < 200)
		{
			$('ul.wyszukiwarka-lista').animate({
						height : 'auto',
				  },300);
		}
		$('ul.wyszukiwarka-lista').append(loader);
		$('#loader').fadeIn(500);
		
		var url = '#';
		if($('input[name=faktura]').is(':checked'))
		{
			url = "{{$linkSzukajFaktura}}";
		}
		else
		{
			url = "{{$linkPobierzWyniki}}";
		}
		
		var nrStrony = $('#nrStrony').val();
		var nrStronie = $('#naStronie').val();
		$.ajax({
			url: url,
			type: 'POST',
			dataType: 'json',
			data: {fraza:fraza, nrStrony:nrStrony, naStronie:nrStronie},
			async: true,
			success: function(dane) {
				$('#loader').fadeOut(500);
				if(dane['kod'] == 1)
				{
					$('#pusta-lista').remove();
					$('ul.wyszukiwarka-lista').css('height', 'auto');
					if(nrStrony > 1)
					{
						$('ul.wyszukiwarka-lista').append(dane['html']);
					}
					else
					{
						$('ul.wyszukiwarka-lista').html(dane['html']);
					}
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
	
	function dodajZamowienieForm(elementWstaw, href)
	{
		$.ajax({
			url: href,
			type: 'POST',
			dataType: 'json',
			async: true,
			success: function(dane) {
				$('#loader').fadeOut(500);
				
				var opts = {showMeridian: false};
				setTimeout(function(){
					elementWstaw.html(dane.html).show(500);
				}, 500);
				
				setTimeout(function(){
					if(!iPad)
					{
						elementWstaw.find('#team').select2();
						elementWstaw.find('#produkty_szukaj').select2();
						$('#idCoordinator').select2();
						$('.bigdrop.full-width').css('width', '80%');
					}
					$('#dateStart').datepicker({}).on('focus',function() { $(this).trigger('blur');	});
					elementWstaw.find("#godzinaDo").timepicker(opts).on('focus',function() { $(this).trigger('blur'); });
					elementWstaw.find("#godzinaOd").timepicker(opts).on('focus',function() { $(this).trigger('blur'); });
					elementWstaw.find('.timepicker').wrap('<div class="input-append bootstrap-timepicker"></div>').after('<span class="add-on"><i class="icon-time"></i></span>');
					elementWstaw.find('.spn').spinner({min: 1});
					$('html, body').animate({
							scrollTop: (elementWstaw.parents('li').offset().top)
					  },100);
				}, 500);
					
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var error = 'Delete row failed: '+xhr.status;
				if (thrownError != '') 
				{
					error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
					error += xhr.responseText;
				}
				alertModal('AJAX request error' ,error);
				$('.mobile-loader').fadeOut("normal");
			}
		});
		return false;
	}
	
	function edytujZamowienieForm(elementWstaw, href, dodane, komunikat)
	{
		$.ajax({
			url: href,
			type: 'POST',
			dataType: 'json',
			async: true,
			success: function(dane) {
				$('#loader').fadeOut(500);
				setTimeout(function(){
					elementWstaw.html(dane.html).show(500);
					$('#dateStart').datepicker({}).on('focus',function(){ $(this).trigger('blur'); });
					$('#godzinaOd').timepicker().on('focus',function(){ $(this).trigger('blur'); });
					$('#godzinaDo').timepicker().on('focus',function(){ $(this).trigger('blur'); });
				}, 500);
					
				setTimeout(function(){
					$('html, body').animate({
							scrollTop: (elementWstaw.parents('li').offset().top)
						},100);
					if(dodane)
						elementWstaw.prepend(komunikat);
					if(!iPad)
					{
						$('#team').select2();
						$('#idCoordinator').select2();
					}
				}, 500);
				
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var error = 'Delete row failed: '+xhr.status;
				if (thrownError != '') 
				{
					error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
					error += xhr.responseText;
				}
				alertModal('AJAX request error' ,error);
				$('.mobile-loader').fadeOut("normal");
			}
		});
		return false;
	}
	
	function dodajNotatkeForm(elementWstaw, href)
	{
		$.ajax({
			url: href,
			type: 'POST',
			dataType: 'json',
			async: true,
			success: function(dane) {
				$('#loader').fadeOut(500);
				setTimeout(function(){
					elementWstaw.html(dane.html).show(500);
				}, 500);
				setTimeout(function(){
					elementWstaw.find('#notatka').focus();
					$('html, body').animate({
							scrollTop: (elementWstaw.parents('li').offset().top)
					  },100);
				}, 500);
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var error = 'Delete row failed: '+xhr.status;
				if (thrownError != '') 
				{
					error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
					error += xhr.responseText;
				}
				alertModal('AJAX request error' ,error);
				$('.mobile-loader').fadeOut("normal");
			}
		});
		return false;
	}
	
	function podgladZamowienia(elementWstaw, href, dodane, komunikat)
	{
		$.ajax({
			url: href,
			type: 'POST',
			dataType: 'json',
			async: true,
			success: function(dane) {
				$('#loader').fadeOut(500);
				setTimeout(function(){
					elementWstaw.html(dane.html).show(500);
					if(dodane)
						elementWstaw.prepend(komunikat);
					
				}, 500)
			},
			error: function (xhr, ajaxOptions, thrownError) {
				var error = 'Delete row failed: '+xhr.status;
				if (thrownError != '') 
				{
					error += ', with error: '+thrownError+' <br/><br/>Server said: <br/><br/>';
					error += xhr.responseText;
				}
				alertModal('AJAX request error' ,error);
				$('#loader').fadeOut(500);
			}
		});
		return false;
	}
	
</script>
<div class="widget-box">
	<div class="formularz_grid" style="padding-top:10px;">
		<input type="hidden" name="nrStrony" id="nrStrony" value="{{$nrStrony}}" />
		<input type="hidden" name="naStronie" id="naStronie" value="{{$nrStronie}}" />
		<form id="wyszukiwarka" class="form-inline" action="" method="post" name="no-focus-wyszukiwarka" enctype="multipart/form-data">
		<ul class="fL">
			<li class="fL">
				<label class="input_ok label-szukaj" for="szukaj" >{{$szukajFraza}} </label> 
				<input class="input-szukaj" autofocus type="text" placeholder="{{$szukajFrazaPlaceholder}}" autocomplete="off" name="fraza" id="fraza" value="" />
				<div class="clear"></div>
				{{BEGIN szukajFaktura}}
				<div id="zbiorowy_directAssignment" class="control-group left">
					<label class="control-label input_ok fL" for="directAssignment">Search invoice : </label>
						<div class="controls">
						<div id="grupa" >
						<input type="checkbox" name="faktura" />
						</div>
					</div>
				</div>
				{{END}}
				<div class="clear"></div>
				<span id="ilosc-wynikow" class="help-block"></span>
			</li>
		</ul>
		</form>
		<div class="clear"></div>
	</div>
</div>
<div class="widget-box">
	<div class="widget-content" >
		<ul class="wyszukiwarka-lista">
			{{BEGIN listaZamowien}}
			{{BEGIN pustaLista}}
			<li id="pusta-lista">{{$brakWynikowWyszukiwania}}</li>
			{{END pustaLista}}
			{{BEGIN zamowienie}}
			<li id="zamowienie_{{$idZamowienia}}">
				<div class="widok-wyszukaj-naglowek">
               
					<div class="widok-wyszukaj-tytul fL" {{IF $zamowienieStatus == 'CANCELLED' }}style="text-decoration: line-through;"{{END IF}} >
						<a class="btn btn-etykieta fL" href="{{$linkPodgladZamowienia}}" >
							<i class="icon icon-plus-sign"></i>
							{{$zamowienieTyp}}
						</a>
						{{IF drugaTura}}
						<span class="label label-info">
							<i class="icon icon-subscript"></i>
						</span>
						{{END drugaTura}}
						<strong>{{$zamowienieTytul}}</strong>
						{{IF $idPdf}}
						<span class="label label-success" data-original-title="">
							{{$idPdf}}
						</span>
						{{END}}
						<span class="label {{$status_klasa}}" data-original-title="">
							{{$zamowienieStatus}}
						</span>
					</div>
					<div class="widok-wyszukaj-przyciski fR" >
						{{IF $blokujEdycja == 0}}
						<a id="edytujDane" href="{{$edytujZamowienieLink}}" class="btn btn-info btn-lg edytujDane " title="{{$edytujDaneEtykieta}}">
							<i class="icon icon-pencil"></i>
						</a>
						{{END}}
						{{IF $apartament == 1}}
						{{IF $wyswietlPrzyciskDrugaTura}}
						<a id="drugaTura" href="{{$drugaTuraLink}}" class="btn btn-success btn-lg drugaTura " title="{{$drugaTuraEtykieta}}">
							<i class="icon icon-subscript"></i>
						</a>
						{{END}}
						{{IF $wyswietlPrzyciskPodgladPdf}}
						<a id="podgladPdf" rel="lightbox:fullPage" href="{{$podgladPdfLink}}" class="btn btn-success btn-lg  " title="{{$podgladPdfEtykieta}}">
							<i class="icon icon-file"></i>
						</a>
						{{END}}
						{{IF $linkPrzeniesDoPierwszejTury}}
						<a id="pierwszaTura"  href="{{$linkPrzeniesDoPierwszejTury}}" class="btn btn-danger btn-lg pierwszaTura " title="{{$pierwszaTuraEtykieta}}">
							<i class="icon icon-reply"></i>
						</a>
						{{END IF}}
						{{IF $linkOtworzZamkniete}}
						<a href="{{$linkOtworzZamkniete}}" class="btn btn-danger btn-lg otworzZamkniete " title="{{$otworzZamknieteEtykieta}}">
							<i class="icon icon-edit"></i>
						</a>
						{{END}}
						{{IF $linkUstawDone}}
						<a href="{{$linkUstawDone}}" class="btn btn-danger btn-lg otworzZamkniete " title="{{$ustawDoneEtykieta}}">
							<i class="icon icon-ok-sign"></i>
						</a>
						{{END}}
						{{IF $linkUstawNotDone}}
						<a href="{{$linkUstawNotDone}}" class="btn btn-danger btn-lg otworzZamkniete " title="{{$ustawNotDoneEtykieta}}">
							<i class="icon icon-minus-sign"></i>
						</a>
						{{END}}
						{{END}}
						
						{{IF $linkDodajZamowienie}}
						<a id="dodajZamowienie"  href="{{$linkDodajZamowienie}}" class="btn btn-warning btn-lg dodajZamowienie " title="{{$dodajZamowienieEtykieta}}">
							<i class="icon icon-plus-sign-alt"></i>
						</a>
						{{END IF}}
						<a id="dodajNotatke" href="{{$dodajNotatkeLink}}" class="btn btn-primary btn-lg dodajNotatke " title="{{$dodajNotatkeEtykieta}}">
							<i class="icon icon icon-file-text"></i>
						</a>
						{{IF $linkDodajReklamacja}}
						<a id="dodajZamowienie" href="{{$linkDodajReklamacja}}" class="btn btn-inverse btn-lg dodajReklamacje " title="{{$dodajReklamacjeEtykieta}}">
							<i class="icon icon icon-thumbs-down"></i>
						</a>
						{{END IF}}
						{{IF $linkUsunZamowienie}}
						<a id="usunZamowienie" href="{{$linkUsunZamowienie}}" class="btn btn-danger btn-lg usunZamowienie" title="{{$etykietaUsunZamowienie}}">
							<i class="icon icon icon-remove"></i>
						</a>
						{{END IF}}
						{{IF $linkZamknijProjekt}}
						<a  href="{{$linkZamknijProjekt}}" class="btn btn-danger btn-lg zamknijProjekt" title="{{$etykietaZamknijProjekt}}">
							<i class="icon icon-lock"></i>
						</a>
						{{END IF}}
						{{IF $linkOtworzProjekt}}
						<a  href="{{$linkOtworzProjekt}}" class="btn btn-danger btn-lg otworzProjekt" title="{{$etykietaOtworzProjekt}}">
							<i class="icon icon-unlock"></i>
						</a>
						{{END IF}}
					</div>
					<div class="clear"></div>
				</div>
				<div class="zamowienie-informacje" style="display:none; position:relative;">
					
				</div>
				<div class="clear"></div>
			</li>
			{{END zamowienie}}
			{{END listaZamowien}}
		</ul>
	</div>
</div>
{{END}}
{{BEGIN widokEdytujZamowienie}}
	<script>
		var iPad = 0;
		$(document).ready(function () {
			
			if(navigator.platform == 'iPad')
				iPad = 1;
		
			if(!iPad)
				$('li#zamowienie_{{idZamowienia}}').find('select#team').select2();
			
			var opts = {showMeridian: false};
			$('li#zamowienie_{{idZamowienia}}').find("#godzinaDo").timepicker(opts).on('focus',function(){ $(this).trigger('blur'); });
			$('li#zamowienie_{{idZamowienia}}').find("#dateStart").datepicker().on('focus',function(){ $(this).trigger('blur'); });
			$('li#zamowienie_{{idZamowienia}}').find("#godzinaOd").timepicker(opts).on('focus',function(){ $(this).trigger('blur'); });
			$('li#zamowienie_{{idZamowienia}}').find('.timepicker').wrap('<div class="input-append bootstrap-timepicker"></div>').after('<span class="add-on"><i class="icon-time"></i></span>');
			
		});
		
		
		
	</script>
	<div class="widget-box">
		<div class="widget-content">
			<a href="{{$linkUstawOtwarte}}" class="btn btn-info" id="ustaw-otwarte">{{$ustawOtwarteEtykieta}}</a>
		</div>
	</div>
	{{$formularz}}
	
{{END widokEdytujZamowienie}}