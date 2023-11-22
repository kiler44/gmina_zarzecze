{{BEGIN index}}
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

{{$grid}}
{{$tabela_danych}}
</div>

{{END}}

{{BEGIN dodaj}}
        {{$form}}
{{END}}

{{BEGIN import_dane}}
	<script src="/_system/js/jquery.ui.datepicker.js"></script>
	<script src="/_system/js/jquery.jeditable.js"></script>
	<script src="/_system/js/jquery.jeditable.datapicker.js"></script>
	<script type="text/javascript">
		<!--
		$(document).ready(function() {
		$('.edit_text').editable('{{$url_ajax_edycja}}', { 
         type      : 'text',
         cancel    : '{{$przycisk_cancel}}',
         submit    : '{{$przycisk_ok}}',
         indicator : '<img src="/_system/img/spinner.gif">',
         tooltip   : '{{$jeditable_tooltip}}',
			width     : 350,
			height    : 20
     });
	  $('.edit_textarea').editable('{{$url_ajax_edycja}}', { 
         type      : 'textarea',
         cancel    : '{{$przycisk_cancel}}',
         submit    : '{{$przycisk_ok}}',
         indicator : '<img src="/_system/img/spinner.gif">',
         tooltip   : '{{$jeditable_tooltip}}',
			width     : 950,
			height    : 70
     });
	  $( '.edit_data' ).editable('{{$url_ajax_edycja}}', {
			type: 'datepicker',
			cancel    : '{{$przycisk_cancel}}',
         submit    : '{{$przycisk_ok}}',
			tooltip   : '{{$jeditable_tooltip}}',
         indicator : '<img src="/_system/img/spinner.gif">',
			datepicker: {
				format: 'yyyy-mm-dd',
				numberOfMonths: 2 
			}
		});
	});

	$(document).ready(function(){
		/*  ObsĹ‚uga regionow  */
		 
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
			regionToggle($(this));
		});
		
		$('#zaznacz_dodaj_nowe').on('click', function(){
			$('input:radio[value=new]').attr('checked', true);
			$('input:radio[value=update]').attr('checked', false);
			$('input:radio[value=pomin]').attr('checked', false);
			$('input:radio[value=new]').parent().addClass('checked');
			$('input:radio[value=update]').parent().removeClass('checked');
			$('input:radio[value=pomin]').parent().removeClass('checked');
		});
		
		$('#zaznacz_aktualizuj').on('click', function(){
			$('input:radio[value=update]').attr('checked', true);
			$('input:radio[value=new]').attr('checked', false);
			$('input:radio[value=pomin]').attr('checked', false);
			$('input:radio[value=update]').parent().addClass('checked');
			$('input:radio[value=new]').parent().removeClass('checked');
			$('input:radio[value=pomin]').parent().removeClass('checked');
			
		});
		$('#zaznacz_pomin').on('click', function(){
			$('input:radio[value=update]').attr('checked', false);
			$('input:radio[value=new]').attr('checked', false);
			$('input:radio[value=pomin]').attr('checked', true);
			$('input:radio[value=update]').parent().removeClass('checked');
			$('input:radio[value=new]').parent().removeClass('checked');
			$('input:radio[value=pomin]').parent().addClass('checked');
			
		});
		
		$('#zapisz_do_bazy').on('click', function(){
			
			var error = 0;
			
			$('input:radio').each(function(){
				var name = $(this).attr('name');
				var zaznaczony = $('input:radio[name='+name+']').is(':checked');
				if(!zaznaczony)
				{
					error=1;
				}
			});
			if(error)
			{
				alertModal("{{$zaznacz_radio_blad_naglowek}}", "{{$zaznacz_radio_blad}}");
			}
			else
			{
				$('#import_zapisz').submit();
			}
		});
		
	});

	-->
	</script>
	
	{{IF $istnieja_powielone_zamowienia}}
	<button class="btn btn-primary" style="margin-bottom:20px;" id="zaznacz_dodaj_nowe">{{$tlumaczenie_zaznacz_wszystkie}} {{$tlumaczenie_dodaj_jako_nowe}}</button>
	<button class="btn btn-primary" style="margin-bottom:20px;" id="zaznacz_aktualizuj">{{$tlumaczenie_zaznacz_wszystkie}} {{$tlumaczenie_aktualizuj}}</button>
	<button class="btn btn-primary" style="margin-bottom:20px;" id="zaznacz_pomin">{{$tlumaczenie_zaznacz_wszystkie}} {{$tlumaczenie_pomin}}</button>
	 
	<div class="clear"></div>
	{{END IF}}
	
	<form name="import_zapisz" id="import_zapisz" method="post" action="{{$urlZapiszDoBazy}}">
	{{$lista_zamowien}}
	</form>
	
	
  {{BEGIN dane}}
		{{IF $zamowienie_istnieje}}
			<span class="badge badge-error faded" style="margin-top: 5px; position: absolute; margin-left: 250px;">
			{{IF $zabronAktualizacji}}
				<label for="{{$numer_zamowienia}}_new" style="display: inline; margin-right: 30px">
					<input type="checkbox" checked="checked" disabled="disabled" id="{{$numer_zamowienia}}_new" class="noinput" name="{{$numer_zamowienia}}" value="new" /> {{$tlumaczenie_dodaj_jako_nowe}}
				</label>
			{{END}}
			{{UNLESS $zabronAktualizacji}}
				<label for="{{$numer_zamowienia}}_new" style="display: inline; margin-right: 30px">
					<input type="radio" id="{{$numer_zamowienia}}_new" class="noinput" name="{{$numer_zamowienia}}" value="new" /> {{$tlumaczenie_dodaj_jako_nowe}}
				</label>
				<label for="{{$numer_zamowienia}}_update" style="display: inline; margin-right: 30px">
					<input type="radio" class="noinput" name="{{$numer_zamowienia}}" id="{{$numer_zamowienia}}_update" value="update" />{{$tlumaczenie_aktualizuj}}
				</label>
				<label for="{{$numer_zamowienia}}_pomin" style="display: inline; margin-right: 30px">
					<input type="radio" class="noinput" name="{{$numer_zamowienia}}" id="{{$numer_zamowienia}}_pomin" value="pomin" />{{$tlumaczenie_pomin}}
				</label>
			{{END}}
			</span>
		{{END IF}}
		<div class="widget-title region_tytul closed">
			<span class="icon">
				<i class="icon-circle-arrow-down"></i>
			</span>
			<h5 style="width:auto;">{{$tlumaczenie_numer_zamowienia}}{{$numer_zamowienia}}</h5>
			{{if($poprawne_pdf, $import_poprawny_pdf, $import_blad_pdf)}}
			{{if($poprawne_xls, $import_poprawny_xls, $import_blad_xls)}}
			{{if($poprawne_zdjecie, $import_poprawny_zdjecie, $import_blad_zdjecie)}}
		</div>
		<div id="dane_zamowienia" class="region_tresc" style="display: none;">
		{{$tabela_danych}}
		</div>
	{{END}}
	{{BEGIN przycisk}}
	<button class="btn btn-primary" id="zapisz_do_bazy" href="{{$butonZapiszDoBazy}}" alt="{{$butonZapiszDoBazyEtykieta}}" >{{$butonZapiszDoBazyEtykieta}}</button>
	{{END}}
{{END}}

{{BEGIN import}}

	{{$formularz}}
{{END}}

{{BEGIN order}}
	{{$formularz}}
{{END}}
	

{{BEGIN addOrderViaGroup}}
<div class="widget-box">
<div class="widget-title">
	<ul class="nav nav-tabs">
		{{BEGIN import_button}}
		<li id="importButton"><button onclick="javascript:location = '{{$url}}';" class="btn btn-primary tip-top left-oriented" title="{{$etykieta}}"><i class="icon icon-upload"></i> {{$etykieta}}</button></li>
		{{END}}
      {{BEGIN zakladka}}
      <li class="{{IF $active}}active{{END}}">
			<a class="{{IF $active}}active{{END}}" name="{{$etykieta}}" href="{{$url}}">{{$etykieta}}</a>
		</li>
      {{END}}
	</ul>
	
{{END}}
	
{{BEGIN edytujOrder}}
{{BEGIN adresy}}
<script type="text/javascript">
<!--
$(document).ready(function(){
$('#address').attr('data-old-val', "{{$address}}");
$('#city').attr('data-old-val', "{{$city}}");
$('#postcode').attr('data-old-val', "{{$postcode}}");
});
-->
</script>
{{END}}
	{{IF $edit}}
<div class="widget-box">
	<div class="widget-title">
		<ul class="nav nav-tabs">
			{{BEGIN zakladka}}
			<li class="zakladka_tytul">
				<a id="{{url}}_tab" name="name_{{$url}}" href="#{{$url}}">{{$etykieta}}</a>
			</li>
			{{END}}
			<li id="notesButtonContainer">{{$button}}</li>
			<li id="notesButtonContainer"><button onclick="modalAjax('{{$previewUrl}}'); return false;" href="{{$previewUrl}}" class="btn btn-info tip-top" style="margin: 4px 0 0 50px" title="{{$previewEtykieta}}"><i class="icon icon-search"></i> {{$previewEtykieta}}</button></li>
			{{IF $reopen}}<li id="notesButtonContainer"><button onclick="window.location = '{{$reopenUrl}}';" href="{{$reopenUrl}}" class="btn btn-inverse tip-top right" style="margin: 4px 0 0 50px" title="{{$reopenEtykieta}}"><i class="icon icon-refresh"></i> {{$reopenEtykieta}}</button></li>{{END}}
			{{IF $closeOrder}}<li id="notesButtonContainer"><button href="{{$closeOrderUrl}}" onclick="window.location = '{{$closeOrderUrl}}';" class="btn btn-danger tip-top right" style="margin: 4px 0 0 50px"   title="{{$closeOrderEtykieta}}"><i class="icon icon-lock"></i> {{$closeOrderEtykieta}}</button></li>{{END}}
		</ul>
	{{END}}
	</div>
	<div id="Order_tresc" class="zakladka_tresc">
	{{$formularz}}
	</div>
	{{BEGIN podzamowienia}}
	<div id="Suborders_tresc" class="zakladka_tresc">
		<div class="przyciskiFunkcyjne">
		{{BEGIN dodajPodzamowienie}}<a class="btn margin" href="{{$url}}"><i class="icon icon-plus-sign"></i> {{$etykieta}}</a>{{END}}
		</div>
		{{$grid}}
		<div style="height: 30px; border-bottom: 1px solid silver"></div>
	</div>
	{{END}}
	{{BEGIN zalaczniki}}
	<div id="Attachements_tresc" class="zakladka_tresc">
		{{$formularz}}
	</div>
	{{END}}
	{{BEGIN reklamacje}}
	<div id="Reclamations_tresc" class="zakladka_tresc">
		{{$grid}}
	</div>
	{{END}}
</div>

<script type="text/javascript">
<!--
//$('.js-hide').parents('.control-group').hide();
$('.full-width').parents('.control-group').css({
	"clear": "both",
	"width": "100%"
});

$("input[name='rodzajPrzydzielenia']").click(function(){
	sprawdzPrzydzielanie();
});
$("#appointment").click(function(){
	sprawdzWyswietlanieAppointment();
});

$("#same_address").click(function(){
	sprawdzAdres();
});
$('#chargeType').change(function(){
	sprawdzChargeBy();
});

sprawdzChargeBy();
sprawdzWyswietlanieProduktow();
sprawdzWyswietlanieBudget();
sprawdzPrzydzielanie();
sprawdzAdres();

function sprawdzChargeBy()
{
	if($('#chargeType').val() == 'price per hour')
	{
		$('#produktyNiestandardowe').parents('.control-group').hide();
	}
	else
	{
		$('#produktyNiestandardowe').parents('.control-group').show();
	}
}

function sprawdzAdres()
{
	if ($("#same_address").is(":checked"))
	{
		$("#order_address input[type='text']").attr('readonly', 'readonly');
		$("#order_address input[type='text']").each(function(){
			$(this).attr('value', $(this).attr('data-old-val'));
		});
	}
	
	else
	{
		$("#order_address input[type='text']").removeAttr('readonly');
		$("#order_address input[type='text']").each(function(){
			if($(this).attr('data-new-val') == undefined)
			{
				$(this).attr('data-new-val', $(this).attr('value'));
			}
			$(this).attr('value', $(this).attr('data-new-val'));
		});
	}
}

function sprawdzWyswietlanieProduktow()
{
	if ($("#chargeType").val() == 'by products')
	{
		$("#produkty").parents(".control-group").show();
	}
	else
	{
		$("#produkty").parents(".control-group").hide();
	}
}

function sprawdzWyswietlanieBudget()
{	
	
	if ($("#chargeType").val() == 'given price')
	{
		$("#budget").parents(".control-group").show();
	}
	else
	{
		$("#budget").parents(".control-group").hide();
	}
}

function sprawdzWyswietlanieAppointment()
{
	if ($("#appointment").is(":visible"))
	{
		if ($("#appointment").is(":checked"))
		{
			$("#zbiorowy_appointedTime .input-append").show();
		}
		else
		{
			$("#zbiorowy_appointedTime .input-append").hide();
			$("#zbiorowy_appointedTime .input-append").nextUntil('.input-append').hide();
		}
	}
}

function sprawdzPrzydzielanie()
{
	var rodzaj = $("input[name='rodzajPrzydzielenia']:checked").val();
	
	if (rodzaj == 'assignToCoordinator')
	{
		$("#zbiorowy_appointedTime, #zbiorowy_assignToCoordinator").show();
		$("#zbiorowy_assignToTeam").hide();
	}
	else if (rodzaj == 'assignToTeam')
	{
		$("#zbiorowy_appointedTime, #zbiorowy_assignToTeam").show();
		$("#zbiorowy_assignToCoordinator").hide();
	}
	else
	{
		$("#zbiorowy_assignToCoordinator, #zbiorowy_assignToTeam, #zbiorowy_appointedTime").hide();
	}
}

/*  Obsluga ajax notatek */
var linkGlobal;

function odswierzNotatkiButton()
{
	$('#notesButtonContainer').html('<div class="spinner"></div>');
	$.ajax({
		url: '{{$odswierz_button_url}}',
		type: 'GET',
		dataType: 'html',
		async: true,
		success: function(dane) {
			$('#notesButtonContainer').html(dane);
		},
		error: function (xhr, ajaxOptions, thrownError) {
			alert(xhr.status);
			alert(thrownError);
		}
	})
	return false;
}

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
	
	function usunNotatka(link)
	{
		$.ajax({
				url: link,
				type: 'POST',
				dataType: 'json',
				async: true,
				success: function(dane) {
					odswierzNotatkiButton();
					$('#oknoModalne #tabela').html(dane.grid);
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
		})
		return false;
	}

	function sprawdzCzyObciazyc()
	{
		if ($('#czyObciazyc').is(':checked'))
		{
			$('#zbiorowy_obciazenie').show('fast');
		}
		else
		{
			$('#zbiorowy_obciazenie').hide('fast');
		}
	}
	function sprawdzNotCharge()
	{
		if ($('#notCharge').is(':checked'))
		{
			$('#chargeType').parents('.control-group').hide();
			$('#budget').parents('.control-group').hide();
		}
		else
		{
			if($('#chargeType').val() == 'given price')
			{
				$('#budget').parents('.control-group').show();
			}
			$('#chargeType').parents('.control-group').show('fast');
			$('#chargeType').select2();
		}
	}
var wiersze;
var click = false;
$(document).ready(function(){
	var opts = {showMeridian: false};
	$("#godzinaDo").timepicker(opts);
	$("#godzinaOd").timepicker(opts);
	
	$('.timepicker').wrap('<div class="input-append bootstrap-timepicker"></div>').after('<span class="add-on"><i class="icon-time"></i></span>');
	
	sprawdzWyswietlanieAppointment();
	var minPrzesuniecia = 60;
	
	sprawdzNotCharge();
	$('#notCharge').live('change', function(){
		sprawdzNotCharge()
	});
	$("#chargeType").change(function(){
		sprawdzWyswietlanieProduktow();
		$("#produkty_add").select2();
		sprawdzWyswietlanieBudget();
	});

	$("#godzinaOd").change(function(){
		var timeOd = $(this).val().split(':');
		var timeDo = $("#godzinaDo").val().split(':');
		var minsOd = (parseInt(timeOd[0]) * 60) + parseInt(timeOd[1]);
		var minsDo = (parseInt(timeDo[0]) * 60) + parseInt(timeDo[1]);
		
		var wlasciweMins = minsOd + minPrzesuniecia;
		if (wlasciweMins > minsDo)
		{
			var hs = wlasciweMins / 60;
			var h = Math.floor(hs);
			var m = Math.round((hs - h) * 60, 0);
			if (h > 23) h = 0;
			if (m == 0) m = '00';
			$("#godzinaDo").val(h + ':' + m)
		}
	});
	$("#godzinaDo").click(function(){
		$(this).change();
	});
	$("#godzinaDo").change(function(){
		var timeOd = $("#godzinaOd").val().split(':');
		var timeDo = $(this).val().split(':');
		var minsOd = (parseInt(timeOd[0]) * 60) + parseInt(timeOd[1]);
		var minsDo = (parseInt(timeDo[0]) * 60) + parseInt(timeDo[1]);

		var wlasciweMins = minsDo - minPrzesuniecia;
		
		if (minsOd > wlasciweMins)
		{
			$(this).val((parseInt(timeOd[0])+1)+':'+timeOd[1]);
			return false;
		}
	});
	
	$("#godzinaDo").change();
	
	$("input[name='rodzajPrzydzielenia']").click(function(){
		$("#zbiorowy_assignToCoordinator select, #zbiorowy_assignToTeam select").select2();
	});
	sprawdzCzyObciazyc();
	$('#czyObciazyc').click(function(){
		sprawdzCzyObciazyc();
	});
		$('#wstecz').live('click', function(e){
			$('#oknoModalne').modal('hide');
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
					odswierzNotatkiButton();
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
/*  Obsługa zakładek  */
	
	$(".zakladka_tresc").not(":first").hide();
	$(".zakladka_tytul a").click(function(){
		
		$('.select2').find('select').select2();
		
		var tab = $(this).attr("href").substring(1);
		var options = { path: '/', expires: 10 };

		$.cookie('zakladka', tab, options);
		if(!$(this).hasClass("active"))
		{
			$(".zakladka_tytul").removeClass("active");
			$(".zakladka_tytul a").removeClass("active");
			$(this).addClass("active");
			$(this).parent().addClass("active");
			var id = $(this).attr("name").substr(5);
			$(".zakladka_tresc").hide();
			$("#"+id+"_tresc").fadeIn("normal");
			$(".zakladka_tresc:visible input:not(input[type=hidden]):first").focus();
		}	
	});
	$("#" + $.cookie('zakladka') + "_tab").click();

	var url = document.location.toString();
	if (url.match('#'))
	{
		var zakladka = '#' + url.split('#')[1];
		if (zakladka.match('|'))
		{
			wiersze = zakladka.split('|')[1];

			zakladka = zakladka.split('|')[0];

			if (wiersze != undefined)
			{
				wiersze = wiersze.split(',');
				for (var i = 0; i < wiersze.length; ++i)
				{
					try
					{
						if (i == 0)
						{
							setTimeout(function () {window.scroll(0, $('#' + wiersze[0]).parent().parent().offset().top)}, 100);
						}
						$('#' + wiersze[i]).parents('.input_ok').addClass('input_zaznaczony');
						$('#' + wiersze[i]).parents('.input_ok').removeClass('input_ok');

					}
					catch(e)
					{}

				}
			}
		}
		$(zakladka +"_tab").click();
	}

	$(".zakladka_tresc").each(function(){
		var blad = $(this).find(".input_blad .formularz_blad");
		if(blad.length > 0)
		{
			$("#" + $(this).attr("id").replace(/_tresc/, "_tab")).click();
			return false;
		}
	});
	if ($('.zakladka_tytul active').length == 0) $('.zakladka_tytul a:first').click();
	

	/*  Obsługa regionow  */
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

	
	$("#klientFormularz").live('submit', function() {
		//alert(u);
		$.ajax({
			url: u,
			type: $('#klientFormularz').attr('method'),
			data: $('#klientFormularz').serialize(),
			dataType: 'json',
			async: true,
			success: function(dane) {
				if(dane.kod == '1' )
				{
					$('#miejsceNaFormularz').html(dane.info);
				}
				if(dane.kod == '2' )
				{
						$('#oknoModalne').attr('aria-hidden', 'true');
						$('#oknoModalne').modal('hide');
				}
			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}
		});
		return false;
	});

	$("input:not(input[type=hidden]):first").focus();
});

$.History.bind(function(state){
	if(!state)
	{
		state = $(".zakladka_tytul:first").find("a").attr("href").substring(1);
	}

	$("#" + state + "_tab").click();
	$('.select2').find('select').select2();
});

-->
</script>
{{END}}


{{BEGIN orderTypes}}
<div class="widget-box">
   {{$grid}}
</div>
{{END}}

{{BEGIN orderAddEditTypes}}
	{{$formularz}}
{{END}}

{{BEGIN previewOrderTab}}
		<li class="zakladka_tytul {{$klasa}}">
			<a class="{{$klasa}}" id="{{$idZamowienia}}_tab" href="#{{$idZamowienia}}" name="name_{{$idZamowienia}}">{{$zamowienieData}}</a>
		</li>
{{END}}

{{BEGIN previewOrder}}
	{{IF $tab}}
	<script  >
		 $(document).ready(function(){
			
			$(".zakladka_tytul a").click(function(){
					$('.select2').find('select').select2();
					var tab = $(this).attr("href").substring(1);
					var options = { path: '/', expires: 10 };
					$.cookie('zakladka', tab, options);
					
					var id = $(this).attr("name").substr(5);
					
					if(!$(this).hasClass("active"))
					{
						$(".zakladka_tytul").removeClass("active");
						$(".zakladka_tytul a").removeClass("active");
						$(this).addClass("active");
						$(this).parent().addClass("active");
						$(".widokZamowien .zakladka_tresc").hide();
						$("#"+id+"_tresc").fadeIn("normal");
						$(".zakladka_tresc:visible input:not(input[type=hidden]):first").focus();
					}
					else
					{
						$(".widokZamowien .zakladka_tresc").hide();
						$("#"+id+"_tresc").show("normal");
					}
				});
				
		$(".zakladka_tytul a.active").click();		
				
		 
		 })
		 $('.wiecej').live('click' ,function(){
				$(this).next('.wiecej_rozwin').toggle(500);
			});
		</script>

	<div class="widget-title" style="width: 99.4%;">
		<ul class="nav nav-tabs">
			{{$tab}} 
		</ul>
	</div>
	{{END IF}}
	<script>
		/*
		 $(document).ready(function(){
			setTimeout(
					  function(){
						  console.log($('.zamowienie-opis').height()); 
					  }, 5000
			)
			
		 });
		 */
	</script>
	<div class="widokZamowien opened">
		{{$zamowienie}}
	</div>
{{END}}
	
{{BEGIN previewOrderOld}}
<div class="" style="padding: 0 20px 0 20px">
	{{$tresc}}
</div>
{{END}}

{{BEGIN notatkiButton}}
<button class="btn btn {{IF $ilosc_notatek > 0}}btn-danger{{ELSE}}btn-info{{END}} tip-top" title="{{$etykieta_notatki_akcja}}" style="margin: 4px 0 0 10px" onclick="return otworzOkno(this.value);" value="{{$link_ajax}}" ><i class="icon-bell"></i> {{$etykieta_notatki}} {{IF $ilosc_notatek > 0}}({{$ilosc_notatek}}){{END}}</button>
{{END}}


{{BEGIN login}}
<div id="noSignal" class="alert alert-danger spacedAlert no-signal hidden"><p></p>{{$komunikat_brak_internetu}}</div>
<script type="text/javascript">
	$('<img/>').attr('src', '/_system/img/no-signal.png').load(function() {
		$(this).remove();
	});
	function sprawdzWyswietlStatus(wartoscObecna)
	{
		if(wartoscObecna == 'wykonane' || wartoscObecna == 'anulowane' || wartoscObecna == undefined)
		{
			// $('#workStatus').parents('.control-group').hide();
		}
		else if(wartoscObecna == 'pomin_order' || wartoscObecna == 'nie_wykonane_b2b')
		{
			$('#sms').parents('.control-group').hide();
			$('#wyslij_sms').parents('.control-group').hide();
			$('#produkt_pierwszy').parents('.control-group').hide();
			$('#produkty').parents('.control-group').hide();
			$('#dodaj_zamowienie_wyswietlony').parents('.control-group').hide();
		}
	}
	
	function sprawdzWyswietlSzacownyCzas(wartoscObecna)
	{
		if(wartoscObecna == 'wykonane' || wartoscObecna == 'anulowane' || wartoscObecna == undefined || wartoscObecna == 'pomin_order')
		{
			$('#pozostalo_godzin').parents('.control-group').hide();
		}
		else if(wartoscObecna == 'nie_wykonane_b2b')
		{
			$('#pozostalo_godzin').parents('.control-group').show();
		}
	}
	
	function sprawdzWyswietlSms()
	{
		var wartosc = $('#wyslij_sms input[type="radio"]:checked').val();
		if(wartosc == 'dont_send')
		{
			$('label[for="sms"]').parent().hide("fast");
		}
		else
		{
			$('label[for="sms"]').parent().show("fast");
		}
	}
	
	function aktualizujSms()
	{
		var originalTxt = $('#trescSms').val();
		
		var seriale = [];
		var i = 0;
		
		var dekoder = [];
		var d = 0;
		
		var h_dek = [];
		var hd = 0;
		
		var modem = [];
		var m = 0;
		
		var h_modem = [];
		var hm = 0;
		
		var ont = [];
		var o = 0;
		
		var voip = [];
		var v = 0;
		
		$('.seriale').each(function(){
			if ($(this).val() != '')
			{
				if($(this).attr('name').indexOf("dekoder") >= 0)
				{
					dekoder[d] = $(this).val();
					d++;
				}
				if($(this).attr('name').indexOf("h_dek") >= 0)
				{
					h_dek[hd] = $(this).val();
					hd++;
				}
				if($(this).attr('name').indexOf("serial_modem") >= 0)
				{
					modem[m] = $(this).val();
					m++;
				}
				if($(this).attr('name').indexOf("serial_h_modem") >= 0)
				{
					h_modem[hm] = $(this).val();
					hm++;
				}
				if($(this).attr('name').indexOf("serial_ont") >= 0)
				{
					ont[o] = $(this).val();
					o++;
				}
				if($(this).attr('name').indexOf("serial_voip") >= 0)
				{
					voip[v] = $(this).val();
					v++;
				}
				
				seriale[i] = $(this).val();
				i++;
			}
		});
		
		var dekoder_txt = dekoder.join(" + ");
		var h_dek_txt = h_dek.join(" + ");
		var modem_txt = modem.join(" + ");
		var h_modem_txt = h_modem.join(" + ");
		var ont_txt = ont.join(" + ");
		var voip_txt = voip.join(" + ");
		
		originalTxt = originalTxt.replace("{dekoder}", dekoder_txt);
		originalTxt = originalTxt.replace("{h_dek}", h_dek_txt);
		originalTxt = originalTxt.replace("{modem}", modem_txt);
		originalTxt = originalTxt.replace("{h_modem}", h_modem_txt);
		originalTxt = originalTxt.replace("{ont}", ont_txt);
		originalTxt = originalTxt.replace("{voip}", voip_txt);
		
		//console.log(originalTxt);
		
		//seriale.reverse();
		//var seriale_txt = seriale.join(" + ");
		//if (seriale_txt != '')
		//{
		//	seriale_txt = ' + ' + seriale_txt;
		//}
		var tekst = '';
		if ($('#note').val() != '')
		{
			//var tekst = seriale_txt + ' + ' + $('#note').val();
			tekst = ' + ' + $('#note').val();
		}
		//else
		//{
		//	var tekst = seriale_txt;
		//}
		var koncowyTekst = originalTxt+tekst;
		$('#sms').val(koncowyTekst.replace("  ", " "));
	}
	
	var seconds = 5;
	var cDinterval;
	
	function countDown()
	{
		seconds--;
		$('#counter').html(seconds);
		if(seconds == 0){
			updateZamknijZamowienie(false);
		}
	}
	function sprawdzWyswietlAlertNieWysylajSms()
	{
		var status = $('input[name=status]:checked').val();
		var wyslijSmsOpcja = $('#wyslij_sms input[type="radio"]:checked').val();

		if(wyslijSmsOpcja == 'dont_send' && status == 'wykonane')
		{ 
			return true;
		}
		else
		{
			return false;
		}
	}
	function updateZamknijZamowienie(resetuj)
	{	
		var etykieta_zamowienie = etykieta_zamowienie;
		clearInterval(cDinterval);
		$('.mobile-loader').css({backgroundImage: 'url("/_system/img/ajax-loader.gif")', opacity: 0.8});
		$(".mobile-loader #noSignal").addClass('hidden');
		var reset = '';
		if (resetuj)
		{
			reset = '&resetProducts=1';
		}
		$(".modal-backdrop").fadeIn("fast");
		var form = $('form#zamknijZamowienie');
		var dane = form.serialize();
		$.ajax({
			url: '{{$urlZamknijAJAX}}'+reset,
			type: form.attr('method'),
			dataType: 'json',
			//dataType: 'html',
			data: dane,
			timeout: 5000,		  
			success: function(data) {
				$(".modal-backdrop").hide();
				if (data.status == 1)
				{
					$('#zamknijFormContainer').html(data.html);
					//$('#zamknijFormContainer').html(data);
					sprawdzWyswietlStatus($('input[name=status]:checked').val());
					nalozUniform();
					nalozSelect2();
					aktualizujSms();
					sprawdzWyswietlSms();
					var etykieta = $('#etykieta_licznik').val();
					limitZnakow("sms", '612', "lim_sms", etykieta);
				}
				else
				{
					window.location.href = 'http://www.{{$DOMENA}}/';
				}
			},
			error: function( xhr, err ) {
				seconds = 5;
				$('#counter').html(seconds);
				$(".mobile-loader").css({backgroundImage: 'none', opacity: 1});
				$(".mobile-loader").html($('#noSignal'));
				$(".mobile-loader #noSignal").removeClass('hidden');
				cDinterval = setInterval('countDown()', 1000);
			}
		});
	}
	function sprawdzDodajZamowienie()
	{
		if($('#dodaj_zamowienie').is(':checked'))
		{
			$('.region-klient').show();
			$('#status_zamowienie_dodane').removeClass('js-hide');
			$('#produkty_dodatkowe').removeClass('js-hide');
			$('#status_zamowienie_dodane').parents('.control-group').show();
			$('#produkty_dodatkowe').parents('.control-group').show();
			$('#dodaj_zamowienie').parents('.control-group').next('.control-group').next('.control-group').show();
		}
		else
		{
			$('#dodaj_zamowienie').parents('.control-group').next('.control-group').hide();
			$('#dodaj_zamowienie').parents('.control-group').next('.control-group').next('.control-group').hide();
			$('.region-klient').hide();
		}
	}
	
	$(document).ready(function(){
		$('.modal-backdrop').fadeOut('fast');
		
		
		sprawdzWyswietlSms();
		
		if($('label[for="sms"]').is( ':visible' ))
		{
			$('#zamknijFormContainer').before('<input type="hidden" id="etykieta_licznik" value="'+etykieta_licznik+'"/>');
			limitZnakow("sms", '612', "lim_sms", $('#etykieta_licznik').val());
			$("#note, .seriale").live('keyup', function(){
				var etykieta = $('#etykieta_licznik').val();
				limitZnakow("sms", '612', "lim_sms", etykieta);
			});

			aktualizujSms();
		}
		
		$('input[name=wyslij_sms]').live('change', function(){
			sprawdzWyswietlSms();
		});
		
		$('.seriale, #note').live('keyup input paste change', function(){
			aktualizujSms();
		});
		window.onbeforeunload = function(){
			return '{{$komunikat_opuszczenie_strony}}';
		};
		
		$('#dodaj_zamowienie').live('change', function(){
			if($(this).is(':checked'))
			{
				$(this).parents('.control-group').next('.control-group').show();
				$(this).parents('.control-group').next('.control-group').next('.control-group').show();
				$('.region-klient').show();
			}
			else
			{
				$(this).parents('.control-group').next('.control-group').hide();
				$(this).parents('.control-group').next('.control-group').next('.control-group').hide();
				$('.region-klient').hide();
			}
		});
		
		$('#zamknijZamowienie #zapisz, #zamknijZamowienie #zakoncz').live('click', function(){
			if(sprawdzWyswietlAlertNieWysylajSms())
			{
				if (!confirm("{{$potwierdz_nie_wysylaj_sms}}"))
					return false;
			}						
			window.onbeforeunload = null;
		});
	
		
		$('#produkt_pierwszy').live('change', function(){
			updateZamknijZamowienie(false);
		});
		
		
		var wartoscObecna = $('input[name=status]:checked').val();

		sprawdzWyswietlSzacownyCzas(wartoscObecna);
		sprawdzWyswietlStatus(wartoscObecna);
		
		var note = $('label[for="note"]').html();
		$('input[name=status]').live('change', function()
		{
			var wartoscRadio = $('input[name=status]:checked').val();
			sprawdzWyswietlSzacownyCzas(wartoscRadio);
			if(wartoscRadio == 'pomin_order')
			{
				//if((note.substring(note.length - 1, note.length)!='*'))
				//{
				//	 $('label[for="note"]').text(note + '*');
				//}
				$('label[for="produkty"]').parent().hide("fast");
				$('#produkt_pierwszy').parents('.control-group').hide("fast");
				$('#wyslij_sms').parents('.control-group').hide("fast");
				$('.seriale').parents('.control-group').hide("fast");
				$('label[for="sms"]').parent().hide("fast");
				
				$('#dodaj_zamowienie').parents('.control-group').hide();
				$('#dodaj_zamowienie').removeAttr('checked');
				$('#dodaj_zamowienie').parent('span').removeClass('checked');
				$('#produkty_dodatkowe_input').parents('.control-group').hide();
				$('#status_zamowienie_dodane').parents('.control-group').hide();
				$('.region-klient').hide();
				
				if(typeof $('label[for="pozostalo_godzin"]') == "undefined")
				{
					$('label[for="pozostalo_godzin"]').text($('label[for="pozostalo_godzin"]').html().replace('*', ''));
				}
				$('#workStatus').parents('.control-group').show();
			}
			else if(wartoscRadio == 'nie_wykonane_b2b')
			{
				$('label[for="pozostalo_godzin"]').text($('label[for="pozostalo_godzin"]').html() + '*');
				
				if((note.substring(note.length - 1, note.length)!='*'))
				{
					 $('label[for="note"]').text(note + '*');
				}
				$('label[for="produkty"]').parent().hide("fast");
				$('#produkt_pierwszy').parents('.control-group').hide("fast");
				$('#wyslij_sms').parents('.control-group').hide("fast");
				$('.seriale').parents('.control-group').hide("fast");
				$('label[for="sms"]').parent().hide("fast");
				$('#workStatus').parents('.control-group').show();
			}
			else if(wartoscRadio == 'anulowane')
			{
				$('label[for="produkty"]').parent().hide("fast");
				$('#produkt_pierwszy').parents('.control-group').hide("fast");
				$('#wyslij_sms').parents('.control-group').hide("fast");
				$('.seriale').parents('.control-group').hide("fast");
				$('label[for="sms"]').parent().hide("fast");
				$('label[for="note"]').text(note.replace('*', ''));
				if(typeof $('label[for="pozostalo_godzin"]') == "undefined")
				{
					$('label[for="pozostalo_godzin"]').text($('label[for="pozostalo_godzin"]').html().replace('*', ''));
				}
				$('#workStatus').parents('.control-group').hide();
			}
			else if(wartoscRadio == 'brak_klienta')
			{
				$('#dodaj_zamowienie').parents('.control-group').hide();
				$('#dodaj_zamowienie').removeAttr('checked');
				$('#dodaj_zamowienie').parent('span').removeClass('checked');
				$('#produkty_dodatkowe_input').parents('.control-group').hide();
				$('#status_zamowienie_dodane').parents('.control-group').hide();
				$('.region-klient').hide();
			}
			else if(wartoscRadio == 'spoznienie')
			{
				$('#dodaj_zamowienie').parents('.control-group').hide();
				$('#dodaj_zamowienie').removeAttr('checked');
				$('#dodaj_zamowienie').parent('span').removeClass('checked');
				$('#produkty_dodatkowe_input').parents('.control-group').hide();
				$('#status_zamowienie_dodane').parents('.control-group').hide();
				$('.region-klient').hide();
			}
			else
			{
				$('label[for="produkty"]').parent().show("fast");
				$('#produkt_pierwszy').parents('.control-group').show("fast");
				$('#wyslij_sms').parents('.control-group').show("fast");
				$('.seriale').parents('.control-group').show("fast");
				$('label[for="sms"]').parent().show("fast");
				$('label[for="note"]').text(note.replace('*', ''));
				$('#dodaj_zamowienie').parents('.control-group').show();
				
				if(typeof $('label[for="pozostalo_godzin"]') == "undefined")
				{
					$('label[for="pozostalo_godzin"]').text($('label[for="pozostalo_godzin"]').html().replace('*', ''));
				}
				$('#workStatus').parents('.control-group').hide();
			}
		});
		sprawdzDodajZamowienie();
	});
</script>
<div class="widget-box">
	{{BEGIN zadanie}}
		<div class="widget-title">
		<span class="icon">
		<i class="icon-tag"></i>
		</span>
		<h5>{{$zamowienie_tytul_etykieta}} {{$zamowienie_tytul}}</h5>
		</div>
		<div class="widget-content">
			{{$start_pracy_etykieta}} {{$start_pracy}}
		</div>
	{{END}}
	{{BEGIN formularz}}
	<div id="zamknijFormContainer">
		{{$form}}
	</div>
	{{END}}
	{{BEGIN link}}
		<a class="btn btn {{$klasa}} tip-top" href="{{$url}}" style="margin: 10px 0 10px 10px" title="{{$etykieta}}" ><i class="icon {{$ikona}}"></i> {{$etykieta}}</a>
	{{END}}
</div>
{{END}}

{{BEGIN selectReclamationOrder}}
	</div>
	<div id="" class="zakladka_tresc selectOrder">
		<input type="hidden" class="bigdrop" id="selectOrder" style="width: 100%"/>
	</div>
	
		
	<script type="text/javascript">
	$(document).ready(function(){
		$("#selectOrder").select2({
			placeholder: "{{$etykieta_placeholder}}",
			minimumInputLength: 3,
			ajax: {
				url: "{{$urlAjax}}",
				dataType: 'json',
				quietMillis: 100,
				data: function (term, page) { // page is the one-based page number tracked by Select2
					return {
						fraza: term, //search term
						customer: "{{$customer}}",
						nrStrony: page,
						naStronie: {{$naStronie}},
					};
				},
				results: function (data, page) {
					var more = (page * {{$naStronie}}) < data.total; // whether or not there are more results available
					//// notice we return the value of more so Select2 knows if more results can be loaded
					return {results: data.orders, more: more};
				}
			},
			formatResult: ordersFormatResult, // omitted for brevity, see the source of this page
			formatSelection: ordersFormatSelection, // omitted for brevity, see the source of this page
			dropdownCssClass: "bigdrop", // apply css that makes the dropdown taller
			escapeMarkup: function (m) { return m; } // we do not want to escape markup since we are displaying html in results
		});
	});
	
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
		
		markup += "</tr></table>";
		return markup;
	}
	
	function ordersFormatSelection(order) {
		$('body').prepend('<div class="modal-backdrop in hide"></div>');
		$(".modal-backdrop").fadeIn("fast");
		var url = '{{$url}}';
		url = url.replace('{ORDER_ID}', order.id);
		location.assign(url);
	}
	</script>
{{END}}

{{BEGIN tablet}}
	<script src="/_system/js/jquery.jeditable.js"></script>
	<script type="text/javascript">
		
		$('.wiecej').live('click' ,function(){
				$(this).next('.wiecej_rozwin').toggle(500);
			});
		$( ".zamowienie-naglowek").live('click', function() {
			$(this).find('i:first').toggleClass('icon-minus');
			$(this).next( ".zamowienie-opis" ).toggle();
		});
		
		$('.edytuj_wiadomosc').live('click', function() {
				$(this).prev('.edit_textarea').dblclick();
				$(this).prev('.edit_textarea').css('width', '90%');
				$(this).hide(500);
				$(this).next('.btn-danger').hide(500);
		});
		
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
		
		function timeString(secs)
		{
			var tekst = '';
			var czas = secondsToTime(secs)
			
			if (czas.h > 0) tekst = tekst + czas.h.toLocaleString()+'h ';
			if (czas.m > 0) tekst = tekst + czas.m.toLocaleString()+'m ';
			
			tekst = tekst + czas.s.toString()+'s';
			return tekst;
		}
		
		$(document).ready(function(){
			
			var uplyneloSekund = {{$uplynelo_sekund}};
			if (uplyneloSekund > 0)
			{
				$('#zalogowanyOd').html(timeString(uplyneloSekund));
				setInterval(function(){
					uplyneloSekund++;
					$('#zalogowanyOd').html(timeString(uplyneloSekund));
				}, 1000);
			}
			var i = 0;
			setInterval(function(){
				i = i+10;
				$('.icon-spinner').rotate(i);
			}, 60);
			
			$('#wstecz').live('click', function(e){
				$('#oknoModalne').modal('hide');
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
						$('#miejsceNaFormularz').html(dane.formularz);
						//if (linkGlobal.indexOf("editNote") >= 0)
						//{
							$('#oknoModalne').attr('aria-hidden', 'true');
							$('#oknoModalne').modal('hide');
							window.location.reload();
						//}
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
		
			if (document.location.hash != '' && document.location.hash != undefined)
				$(document.location.hash + " .zamowienie-naglowek").click();
			
			$('.edit_textarea').editable('{{$link_edytuj_sms}}', { 
				type      : 'textarea',
				cancel    : '{{$input_sms_ajax}}',
				submit    : '{{$input_sms_zapisz}}',
				indicator : '<img src="/_system/img/spinner.gif">',
				tooltip   : '{{$jeditable_tooltip}}',
				width     : 0,
				//height    : 70,
				event     : 'dblclick',
				onblur	 : 'ignore',
				textareaclass : 'textareaclass',
				onsubmit : function(){
					$('.textareaclass').parents('.edit_textarea').next('.edytuj_wiadomosc').show(500).next('.btn-danger').show(500);
				},
				onreset : function(){
					$('.textareaclass').parents('.edit_textarea').next('.edytuj_wiadomosc').show(500).next('.btn-danger').show(500);
				}
		
			});
			
			$('#pokazZsumowane').live('click', function(){
				$(this).children('i').toggleClass('icon-minus-sign');
				$('#rozwin-produkty-zsumowane').toggle('500');
			});
			 
		})
		
	</script>
	
	<div class="widokZamowien">
		{{BEGIN formularz}}
			{{$formularzWyszukaj}}
		{{END}}
		{{IF $ilosc_projektow_lidera > 0}}
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="fa icon-th"></i>
				</span>
				<h5>{{$projekty_lidera_bkt_naglowek}} ({{$ilosc_projektow_lidera}})</h5>
			</div>
			<div class="widget-content">
				{{$projekty_lidera_szablon}}
			</div>
		</div>
		{{END}}
		{{IF $ilosc_installation > 0}}
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="fa icon-th"></i>
				</span>
				<h5>{{$villa_installation_naglowek}} ({{$ilosc_installation}})</h5>
			</div>
			<div class="widget-content">
				{{$lista_zsumowanych_produktow}}
				{{$lista_zamowien}}
			</div>
		</div>
		{{END}}
		{{IF $ilosc_projekt > 0}}
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="fa icon-th-large"></i>
				</span>
				<h5>{{$projekty_naglowek}} ({{$ilosc_projekt}})</h5>
			</div>
			<div class="widget-content">
				{{$lista_projektow}}
			</div>
		</div>
		{{END}}
		{{BEGIN zakonczPrace}}
			<a href="{{$link_zakoncz_prace}}" class="btn btn-danger btn-block btn-lg"  >
			{{$zakoncz_prace_etykieta}}</a>
		{{END}}
	</div>
	
	{{BEGIN listaSms}}
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="icon-comment"></i>
				</span>
				<h5>{{$sms_naglowek}}</h5>
				<span class="label label-info tip-left" title="">
					{{$sms_ilosc}}
				</span>
			</div>

			<div class="widget-content nopadding">
				<ul class="recent-comments">
					{{$sms_lista}}
					{{IF $ilosc_smsWersje > 0}}
					<li class="wiecej widget-title" style="height: 10px; text-align: center; padding-top:5px; cursor: pointer;">
						<i class="icon-angle-down"></i>
						{{$pokaz_powiazane}}
					</li>
					<div class="wiecej_rozwin" style="display: none">
						{{$sms_lista_wersje}}
					</div>
					{{END}}
				</ul>
			</div>
		</div>
	{{END}}
	{{BEGIN sms_pojedynczy}}
		<li>
			<div class="user-thumb">
				<img width="40" height="40" src="{{$autor_zdjecie}}" alt="{{$autorNazwa}}">
			</div>
			<div class="comments">
				<span class="user-info"> {{$data_dodania}} {{$user}} {{$czy_wyslany}}  </span>
				<p >
					{{IF $wyslany_flaga}}<span id="{{$sms_id}}" class="edit_textarea">{{END}}{{$notatka}}{{IF $wyslany_flaga}}</span>{{END}}
					
					 {{IF $wyslany_flaga}}
					 <button class="edytuj_wiadomosc btn btn-primary fR" style="margin-left: 3px;">{{$sms_edytuj_etykieta}}</button>
					 <a href="{{$link_wyslij_sms}}" class="btn btn-danger fR">{{$sms_wyslij_ponownie_etykieta}}</a>
					 {{END}}
				</p>
				<div class="clear"></div>
			</div>
		</li>
	{{END}}
	
	{{BEGIN produkty_zsomowane}}
		<a id="pokazZsumowane" class="btn btn-info">
			<i class="incon icon-plus-sign"></i>
			{{$etykieta_produkty_zsumowane}}
		</a>
		<div class="widget-box hide margin" style="width: 50%;" id="rozwin-produkty-zsumowane">
			<div class="widget-title">
				<span class="icon">
					<i class="icon icon-qrcode"></i>
				</span>
				<h5>{{$etykieta_produkty_zsumowane}}</h5>
			</div>
			{{$lista_zsumowanych_produktow}}
		</div>
	{{END}}
	
	{{BEGIN produkty_szablon}}
	<table class="table table-bordered table-striped break">
		<thead>
			<tr>
				<th>{{$service_etykieta}}</th>
				<th>{{$quantity_etykieta}}</th>
				{{IF $widziCeny}}
				<th>{{$price_etykieta}}</th>
					{{IF $jestProjektem}}
					<th>{{$procent_etykieta}}</th>
					{{ELSE}}
					<th>{{$sum_price_etykieta}}</th>
					{{END IF}}
					{{IF $jestProjektem}}
					<th>{{$procent_price_etykieta}}</th>
					{{END IF}}
				{{END IF}}
				{{IF $jestCzas}}<th>{{$time_etykieta}}</th>{{END IF}}
			</tr>
		</thead>
		<tbody>
			{{$lista_prodoktow}}
		</tbody>
		<tfoot>
			{{IF $jestCzas}}
				<td colspan="2" style="text-align: right">{{$suma_time_etykieta}}</td>
			{{END IF}}
			{{IF $widziCeny}}
				{{IF $jestProjektem}}
				<td colspan="2" style="text-align: right">{{$suma_procent_price_etykieta}}</td>
				<td class="price">{{$suma_price}}</td>
				<td class="price">{{$suma_procent}}%</td>
				<td class="price">{{$suma_invoiced}}</td>
				{{ELSE}}
				{{UNLESS $jestCzas}}
				<td colspan="3" style="text-align: right">{{$suma_price_etykieta}}</td>
				{{END UNLESS}}
				<td class="price">{{$suma_price}}</td>
				
				{{END IF}}
			{{END IF}}
			{{IF $jestCzas}}<td>{{$suma_time}}</td>{{END IF}}
		</tfoot>
	</table>
	{{END}}
	
	{{BEGIN listaProduktow}}
		<tr class="tip-top{{IF $rejected}} rejected{{END}}" title="{{$data_dodania}}">
			<td><span>{{$nazwa_produktu}} </span> </td>
			<td> {{IF $ilosc_produktu}} {{UNLESS $widziCeny}}<span class="badge badge-success" >{{$ilosc_produktu}}</span>{{ELSE}}{{$ilosc_produktu}}{{END UNLESS}} {{END IF}}</td>
			{{IF $widziCeny}}
			<td class="price">{{$price}}</td>
				{{IF $jestProjektem}}
					<td>{{$procent}}</td>
					<td class="price">{{$procent_price}}</td>
				{{ELSE}}
					<td class="price"><strong>{{$sum_price}}</strong></td>
				{{END IF}}
			{{END IF}}
			{{IF $jestCzas}}<td>{{$time}}</td>{{END IF}}
		</tr>
	{{END}}
	
	{{BEGIN atrybuty}}
	<table class="table table-bordered table-striped break" >
		<thead>
			<tr>
				<th class="attr_etykieta" >{{$atrybuty_etykieta}}</th>
				<th class="attr_wartosc"></th>
			</tr>
		</thead>
		<tbody>
			{{$lista_atrybutow}}
		</tbody>
	</table>
	{{END}}
		
	{{BEGIN atrybutySzablon}}
		<tr>
			<td>{{$nazwa}}</td>
			<td>{{$wartosc}}</td>
		</tr>
	{{END}}
	
	{{BEGIN apartament}}
	<tr style="background: {{$tlo}}; ">
		<td>
			{{IF $naglowek}}<strong>{{END}}
			{{IF $pelny_adres}}{{$miasto}}, {{$ulica}} {{ELSE}} {{$apartament}} {{END}} {{IF $druga_tura}}<i class="icon-subscript"></i>{{END}} 
			{{IF $naglowek}}</strong>{{END}}
		</td>
		<td>
			{{$data}}
		</td>
		<td>
			{{$czas}}
		</td>
		<td>
			{{$team}}
		</td>
	</tr>
	{{END apartament}}
	
	{{BEGIN listaApartamentow}}
	<div class="widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class="icon-comment"></i>
			</span>
			<h5>{{$lista_apartamentow_etykieta}}</h5>
			<span class="label label-info tip-left" title="">
				{{$ilosc_apartamentow}}
			</span>
		</div>
		<div class="widget-content nopadding podglad-zamowienia-apartamenty" >
			<table class="table table-bordered table-hover">
				<tbody>
					<tr>
						{{$lista_apartamentow}}
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	{{END listaApartamentow}}
	
	{{BEGIN listaNotatek}}
	<div class="widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class="icon-comment"></i>
			</span>
			<h5>{{$note_naglowek}}</h5>
			<span class="label label-info tip-left" title="">
				{{$ilosc_notatek}}
			</span>
		</div>

		<div class="widget-content nopadding">
			<ul class="recent-comments">
				{{IF $ilosc_notatek > 4}}<ul class="notatki_wiecej">{{END}}
					{{$lista_notatek}}
				{{IF $ilosc_notatek > 4}}</ul>{{END}}
				
				{{IF $ilosc_notatekWersje > 0}}
					<li class="wiecej widget-title" style="height: 10px; text-align: center; padding-top:5px; cursor: pointer;">
						<i class="icon-angle-down"></i>{{$pokaz_powiazane}}
					</li>
					<div class="wiecej_rozwin" style="display:none;">
					{{$lista_notatek_szablonWersje}}
					</div>
				{{END}}
			</ul>
		</div>
	</div>
	{{END}}
						
	{{BEGIN listaNotatekSzablon}}
		<li>
			<div class="user-thumb">
				<img width="40" height="40" src="{{$autor_zdjecie}}" alt="{{$autorNazwa}}">
			</div>
			<div class="comments">
				<span class="user-info"> {{$data_dodania}} {{$user}}  </span>
				<p class="red">
					 {{$notatka}}
				</p>
			</div>
		</li>
	{{END}}
	
	{{BEGIN listaZalacznikow}}
	<div class="widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class="icon icon-paste"></i>
			</span>
			<h5>{{$zalacznik_naglowek}}</h5>
			<span class="label label-info tip-left" >
				{{$ilosc_zalacznikow}}
			</span>
		</div>
		<div class="widget-content nopadding">
			<table class="table table-bordered table-striped table-hover with-check">
				<tbody>
					<tr>
						{{$lista_zalacznikow}}
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	{{END}}
	
	{{BEGIN listaZalacznikowSzablon}}
		<tr>
			<td>
				<button class="btn btn-default">
					<i class="icon icon-file"></i>
				</button>
			</td>
			<td>
				{{$nazwa}}
			</td>
			<td>
				<a href="{{$url_pobierz}}" target="_blank" class="btn btn-default fR" >
					<i class="icon-download"></i> {{$pobierz_etykieta}}
				</a>
				<a href="{{$url}}" rel="lightbox:fullPage" class="btn btn-default fR" style="margin-right: 3px;">
					<i class="icon-search"></i> {{$podglad_etykieta}}
				</a>
			</td>
		</tr>
	{{END}}
	{{BEGIN projektLider}}
	<div class="widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class="icon-user"></i>
			</span>
			<h5>{{$project_leader_etykieta}}</h5>
		</div>
		<div class="widget-content nopadding">
			<table class="table table-bordered table-striped table-hover">
				<tbody>
					<tr>
						<td>{{$project_leader_name}}</td>
						<td>{{$project_leader_telefony}}</td>
					</tr>
				</tbody>
			</table>
		</div>
	</div>
	{{END}}
	{{BEGIN listaZamowien}}

	{{UNLESS $formularz_produktow_zakupionych_szablon}}<div id="{{$id_zamowienia}}_tresc" class="zakladka_tresc">{{END}}
		<div class="portlet zamowienie{{IF $zalogowany}} logedin{{END}}" id="i{{$id_zamowienia}}"  >
		{{IF $zamkniete}}
			{{IF $zalogowany}}
				<a class="btn btn-default fR pozycjonowany">
					<i class="icon-spinner"></i><span> {{$zalogowany_etykieta}}</span>
					<var id="zalogowanyOd"></var>
				</a>
			{{ELSE}}
				{{IF $link_zaloguj}}
				<button value="{{$link_zaloguj}}" onclick="location.href = this.value ;" class="btn {{IF $hightPriority}}btn-danger{{ELSE}}btn-info {{END}} fR pozycjonowany" >
					<i class="icon-signin"> </i> {{$zaloguj_etykieta}}
				</button>
				{{END}}
				{{IF $projektLiderBkt}}
				<button value="{{$linkDodajNotatke}}" onclick="return otworzOkno(this.value);" class="btn {{IF $hightPriority}}btn-danger{{ELSE}}btn-info {{END}} fR pozycjonowany" >
					<i class="icon-plus-sign"> </i> {{$etykietaDodajNotatke}}
				</button>
				{{END}}
			{{END}}
		{{END}}
		<div class="zamowienie-naglowek {{IF $projekt}}projekt{{END}} {{IF $hightPriority}}highpriority{{END}} {{IF $zalogowany}}logedin{{END}} {{IF $zamowienie_anulowane}}cancelled{{END}}" style="background: {{$zamowienie_bg}}" >
			<a href="{{IF $formularz_produktow_zakupionych_szablon}}#-{{$id_zamowienia}}{{ELSE}}#i{{$id_zamowienia}}{{END}}">
				<div class="box-naglowek{{UNLESS $projekt}} order{{END}}">
					{{IF $link_zaloguj}}<i class="icon-plus"></i>{{END}}
					{{IF $projektLiderBkt}}<i class="icon-plus"></i>{{END}}
					<span class="label label-info" >{{IF $projekt}}<i class="icon icon-crop"></i>{{END}} {{$number_order_get}} {{$etykieta_bkt_id}}  {{$bkt_id}} </span>
					{{UNLESS $projekt}}<br/>{{END}}{{$order_type}} {{IF $projekt}}{{$order_name}}{{END}}
				</div>
				{{UNLESS $projekt}}
				<div class="box-naglowek time">
					<i class="icon-time"></i> {{$godziny_pracy}} ({{$dataStart}})
				</div>
				<div class="box-naglowek address">
					<i class="icon-home"></i> <span  >{{$pelny_adres}}</span>
				</div>
				
				<div class="box-naglowek klient">
					<i class="icon-user"></i> {{$klient_nazwa}} {{$telefon_etykieta}} {{$klient_telefon}}
				</div>
				{{END}}
			</a>
			<div class="clear"></div>
		</div>
		<div class="zamowienie-opis">
			<div class="opis">
				<div class="alert alert-info alert-block">
					<h4 class="alert-heading">{{$job_description_naglowek}}</h4>
					<p class="opis_zamowienia">
					{{$job_description}}
					</p>
				</div>
				{{$szablonProjektLiderGet}}
				{{$szablonProjektLiderBkt}}
				<div class="widget-box">
					<div class="widget-title">
						<span class="icon">
							<i class="icon-user"></i>
						</span>
						<h5>{{$klient_nazwa}}</h5>
					</div>
					<div class="widget-content nopadding">
						<table class="table table-bordered table-striped table-hover">
							<thead>
								<tr>
									<th>{{$numer_klienta_etykieta}}</th>
									<th>{{$telefon_klienta_etykieta}} </th>
									<th>{{$adres_klienta_etykieta}}</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>{{$numer_klienta}}</td>
									<td>{{$telefony_klienta}}</td>
									<td>{{$adres_klienta}}</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				{{$szablon_sms}}
				{{$lista_notatek_szablon}}
				{{$team_obecnie_przypisany}}
				{{$historia_logowan}}
				{{$lista_zalacznikow_szablon}}
			</div>
			<div class="pozycja">
				{{IF $reopen}}<a href="{{$reopen_url}}" class="btn btn-info right margin margin-bottom-10"><i class="icon icon-refresh"></i> {{$reopen_etykieta}}</a>{{END}}
				
				{{UNLESS $zamowienie_zabokowana_edycja}}
					<a href="{{$edytuj_url}}" class="btn btn-primary right margin margin-bottom-10"><i class="icon icon-edit"></i> {{$edytuj_etykieta}}</a>
				{{END UNLESS}}
				
				
				{{IF $autoWylogowany}}
				<div class="alert alert-error" style="font-size: 16px"><i class="icon icon-exclamation-sign" style="font-size: 20px"></i> {{$autoWylogowanyAlert}}</div>
				{{END IF}}
				<a href="javascript:void(0)" {{IF $wyswietlaj_przycisk_zatwierdz == 1}} style="display:block" {{ELSE}} style="display:none" {{END}} class="btn btn-success btn-large oznaczSprawdzony {{IF $wyswietlaj_przycisk_zatwierdz == 1}}block{{END}} margin center">{{$przycisk_zatwierdz_etykieta}}</a>
				
				<a href="javascript:void(0)" {{IF $wyswietlaj_przycisk_usun_zatwierdz == 1}} style="display:block" {{ELSE}} style="display:none" {{END}} class="btn btn-warning btn-large usunSprawdzony {{IF $wyswietlaj_przycisk_usun_zatwierdz == 1}}block{{END}} margin center">{{$przycisk_usun_zatwierdz_etykieta}}</a>
			 
				{{IF $formularz_produktow_zakupionych_szablon}}
				
					{{$formularz_produktow_zakupionych_szablon}}
				
				{{END}}
				
	
				{{BEGIN produkty_szablon}}
				<table class="table table-bordered table-striped break">
					<thead>
						<tr>
							<th>{{$service_etykieta}}</th>
							<th>{{$quantity_etykieta}}</th>
						</tr>
					</thead>
					<tbody>
					{{BEGIN listaProduktow}}
						<tr class="tip-top" title="{{$data_dodania}}">
							<td><span>{{$nazwa_produktu}}</span> </td>
							<td> {{IF $ilosc_produktu}} <span class="badge badge-success" >{{$ilosc_produktu}}</span>{{END IF}}</td>
						</tr>
					{{END}}
					</tbody>
				</table>
				{{END}}
				
				{{$lista_produktow_zamowionych_szablon}}
				{{$lista_atrybutow_szablon}}
				{{$lista_apartamentow_szablon}}
				
			</div>
			<div class="clear"></div>
		</div>
	{{UNLESS $formularz_produktow_zakupionych_szablon}}</div>{{END}}</div>
	{{END}}
	
	{{BEGIN obecniePrzypisani}}
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="icon icon-time"></i>
				</span>
				<h5>{{$obecniePrzypisani_naglowek}}</h5>
			</div>
			<div class="widget-content nopadding">
				<ul class="recent-comments">
					{{BEGIN uzytkownikPrzypisany}}
					<li>
						<div class="user-thumb" {{IF $lider}} style="background: #ff0000;" {{END}}>
							<img height="40" width="40" alt="" src="{{$zdjecie}}">
						</div>
						<div class="comments">
							{{$imie}} {{$nazwisko}} ( {{$team}} )
							<p > {{$telefon}} </p>
						</div>
						<div class="clear" />
					</li>
					{{END uzytkownikPrzypisany}}
				</ul>
			</div>
		</div>
	{{END obecniePrzypisani}}
	
	{{BEGIN historiaLogowan}}
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="icon icon-time"></i>
				</span>
				<h5>{{$historiaLogowan_naglowek}}</h5>
				<span class="label label-info tip-left" >
					{{$ilosc_logowan}}
				</span>
			</div>
			<div class="widget-content nopadding">
				
				<table class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th><i class="icon icon-truck"></i></th>
							<th><i class="icon icon-play"></i></th>
							<th><i class="icon icon-stop"></i></th>
							<th><i class="icon icon-time"></i></th>
						</tr>
					</thead>
					<tbody class="team-naglowek">
						{{BEGIN wpis}}
						<tr {{IF $auto_logout}}class="auto_wylogowany"{{END}}>
							<td><strong>{{$team}}</strong> {{$pracownicy}}</td>
							<td>{{$start}}</td>
							<td>{{IF $stop}}{{$stop}}{{ELSE}}*{{END}}</td>
							<td style="text-align: center; font-weight: bold">{{$hours}}</td>
						</tr>
						{{END}}
					</tbody>
					<tfoot>
						<tr>
							<td colspan="3" style="text-align: right">{{$etykieta_suma_godzin}}</td>
							<td style="text-align: center">{{$suma_godzin}}</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	{{END}}
	{{BEGIN zdjecie_pracownika}}{{IF $zdjecie}}<img src="{{$zdjecie}}" title="{{$pracownik}}" class="tip-top" alt="{{$pracownik}}"/>{{ELSE}}<span title="{{$pracownik}}" class="tip-top">{{$pracownik}}</span>{{END}}{{END}}
{{END}}


{{BEGIN zamknijDzien}}
<div class="widget-box">
	<div class="widget-title">
		<span class="icon"><i class="icon-bar-chart"></i></span>
		<h5>{{$etykieta_statystyki_dnia}}</h5>
	</div>
	<div class="widget-content">
		<div class="row">
			<div class="span12">
				<ul class="stats-plain big">
					<li><i class="icon icon-time" style="{{IF $godziny_blad}}color: red{{END}}"></i> <h4><strong>{{$godziny_przepracowane}}</strong></h4> <span class="block">{{$etykieta_godziny_przepracowane}}</span></li>
					<li><i class="icon icon-bullseye"></i> <h4><strong>{{$ordery_wykonane}}</strong></h4><span class="block">{{$etykieta_ordery_wykonane}}</span></li>
					<li><i class="icon icon-shopping-cart"></i> <h4><strong>{{$produkty_dostarczone}}</strong></h4> <span class="block">{{$etykieta_produkty_dostarczone}}</span></li>
				</ul>
				<ul class="site-stats"><li class="divider"></li></ul>
				<ul class="stats-plain">
					<li><i class="icon icon-road"></i> <h5>{{$miejscowosci}}</h5> <span class="block">{{$etykieta_miejscowosci}}</span></li>
				</ul>
				<ul class="stats-plain">
					<li><h5>{{$etykieta_czy_skonczyles_o_godzinie}}</h5> <span class="block">{{$etykieta_straszak_o_godzinie}}</span></li>
					<li class="block">{{$formularz}}</li>
				</ul>
			</div>
		</div>
	</div>
</div>
{{IF $zamowienie}}
<div class="widget-box">
	<div class="widget-title">
		<span class="icon"><i class="icon-tasks"></i></span>
		<h5>{{$etykieta_lista_zamowien}}</h5>
	</div>
	<div class="widget-content">
		<ul class="widokZamowien">
			{{BEGIN zamowienie}}
			<li id="i75" class="zamowienie">
				<div style="background-color: {{$kolor}}" class="zamowienie-naglowek">
					<div class="box-naglowek">
						<span class="label label-info">{{IF $get_id}}{{$get_id}} {{END}}{{$etykieta_bkt_id}} {{$bkt_id}}</span>
						{{$order_type}}
					</div>
					<div class="box-naglowek">
						<i class="icon-time"></i> {{$hours_interval}} ({{$data_start}})
					</div>
					<div class="box-naglowek">
						<i class="icon-home"></i> <span>{{$postcode}} {{$city}}, {{$address}}</span>
					</div>
					<div class="box-naglowek">
						<i class="icon-user"></i> {{$name}} {{$surname}} {{$etykieta_telefon}} <i class="icon icon-phone"></i> {{$telefony}}
					</div>
					<div class="clear"></div>
				</div>
			</li>
			{{END}}
		</ul>
	</div>
</div>
{{END}}
<script type="text/javascript">
	$(document).ready(function(){
		$('#koniecPracy').parents('.control-group').find('.control-label').remove();
		$('#koniecPracy').parents('.controls').css('margin-left', '0');
	});
</script>
{{END}}









{{BEGIN tabletShort}}
	<script src="/_system/js/jquery.jeditable.js"></script>
	<script type="text/javascript">
		$('.wiecej').live('click' ,function(){
				$(this).next('.wiecej_rozwin').toggle(500);
			});
		$( ".zamowienie-naglowek").live('click', function() {
			$(this).find('i:first').toggleClass('icon-minus');
			$(this).next( ".zamowienie-opis" ).toggle();
		});
		
		$('.edytuj_wiadomosc').live('click', function() {
				$(this).prev('.edit_textarea').dblclick();
				$(this).prev('.edit_textarea').css('width', '90%');
				$(this).hide(500);
				$(this).next('.btn-danger').hide(500);
		});
		
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
		
		function timeString(secs)
		{
			var tekst = '';
			var czas = secondsToTime(secs)
			
			if (czas.h > 0) tekst = tekst + czas.h.toLocaleString()+'h ';
			if (czas.m > 0) tekst = tekst + czas.m.toLocaleString()+'m ';
			
			tekst = tekst + czas.s.toString()+'s';
			return tekst;
		}
		
		$(document).ready(function(){
			var uplyneloSekund = {{$uplynelo_sekund}};
			if (uplyneloSekund > 0)
			{
				$('#zalogowanyOd').html(timeString(uplyneloSekund));
				setInterval(function(){
					uplyneloSekund++;
					$('#zalogowanyOd').html(timeString(uplyneloSekund));
				}, 1000);
			}
			var i = 0;
			setInterval(function(){
				i = i+10;
				$('.icon-spinner').rotate(i);
			}, 60);
			
			$('#wstecz').live('click', function(e){
				$('#oknoModalne').modal('hide');
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
						$('#miejsceNaFormularz').html(dane.formularz);
						//if (linkGlobal.indexOf("editNote") >= 0)
						//{
							$('#oknoModalne').attr('aria-hidden', 'true');
							$('#oknoModalne').modal('hide');
							window.location.reload();
						//}
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
		
			if (document.location.hash != '' && document.location.hash != undefined)
				$(document.location.hash + " .zamowienie-naglowek").click();
			
			$('.edit_textarea').editable('{{$link_edytuj_sms}}', { 
				type      : 'textarea',
				cancel    : '{{$input_sms_ajax}}',
				submit    : '{{$input_sms_zapisz}}',
				indicator : '<img src="/_system/img/spinner.gif">',
				tooltip   : '{{$jeditable_tooltip}}',
				width     : 0,
				//height    : 70,
				event     : 'dblclick',
				onblur	 : 'ignore',
				textareaclass : 'textareaclass',
				onsubmit : function(){
					$('.textareaclass').parents('.edit_textarea').next('.edytuj_wiadomosc').show(500).next('.btn-danger').show(500);
				},
				onreset : function(){
					$('.textareaclass').parents('.edit_textarea').next('.edytuj_wiadomosc').show(500).next('.btn-danger').show(500);
				}
		
			});
			
			$('#pokazZsumowane').live('click', function(){
				$(this).children('i').toggleClass('icon-minus-sign');
				$('#rozwin-produkty-zsumowane').toggle('500');
			});
			
			hash = location.hash;
			if (hash.indexOf('_wersje') > -1)
			{
				var id = hash.replace('_wersje', '');
				var $opis = $(id+'_tresc').find('.zamowienie-opis');
				if (! $opis.is(':visible'))
				{
					$opis.css('display', 'block');
					$('html, body').animate({
						scrollTop: $(id+'_wersje').offset().top
					}, 500);
				}
			}
		})
		
	</script>
	
	<div class="widokZamowien">
		
		{{$formularzWyszukaj}}
		
		{{IF $ilosc_projektow_lidera > 0}}
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="fa icon-th"></i>
				</span>
				<h5>{{$projekty_lidera_bkt_naglowek}} ({{$ilosc_projektow_lidera}})</h5>
			</div>
			<div class="widget-content">
				{{$projekty_lidera_szablon}}
			</div>
		</div>
		{{END IF}}
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="fa icon-th"></i>
				</span>
				<h5>{{$villa_installation_naglowek}} ({{$ilosc_installation}})</h5>
			</div>
			<div class="widget-content">
				
			{{BEGIN produktyZsomowane}}
				<a id="pokazZsumowane" class="btn btn-info">
					<i class="incon icon-plus-sign"></i>
					{{$etykieta_produkty_zsumowane}}
				</a>
				<div class="widget-box hide margin" style="width: 50%;" id="rozwin-produkty-zsumowane">
					<div class="widget-title">
						<span class="icon">
							<i class="icon icon-qrcode"></i>
						</span>
						<h5>{{$etykieta_produkty_zsumowane}}</h5>
					</div>
					
					<table class="table table-bordered table-striped break">
						<thead>
							<tr>
								<th>{{$service_etykieta}}</th>
								<th>{{$quantity_etykieta}}</th>
							</tr>
						</thead>
						<tbody>
						{{BEGIN listaProduktow}}
							<tr class="tip-top{{IF $rejected}} rejected{{END}}" title="{{$data_dodania}}">
								<td><span>{{$nazwa_produktu}}</span> </td>
								<td> {{IF $ilosc_produktu}} <span class="badge badge-success" >{{$ilosc_produktu}}</span>{{ELSE}}{{END IF}}</td>
							</tr>
						{{END}}
						</tbody>
					</table>
				</div>
			{{END produktyZsomowane}}
				
			{{BEGIN zamowienie}}
				<div id="{{$id_zamowienia}}_tresc" class="zakladka_tresc">
					<div class="portlet zamowienie{{IF $zalogowany}} logedin{{END}}" id="i{{$id_zamowienia}}"  >
					{{IF $zamkniete}}
						{{IF $zalogowany}}
							<a class="btn btn-default fR pozycjonowany">
								<i class="icon-spinner"></i><span> {{$zalogowany_etykieta}}</span>
								<var id="zalogowanyOd"></var>
							</a>
						{{ELSE}}
							{{IF $link_zaloguj}}
								<button value="{{$link_zaloguj}}" onclick="location.href = this.value ;" class="btn {{IF $hightPriority}}btn-danger{{ELSE}}btn-info {{END}} fR pozycjonowany" >
									<i class="icon-signin"> </i> {{$zaloguj_etykieta}}
								</button>
							{{END IF}}
						{{END IF}}
					{{END}}
					<div class="zamowienie-naglowek {{IF $projekt}}projekt{{END}} {{IF $hightPriority}}highpriority{{END}} {{IF $zalogowany}}logedin{{END}} {{IF $zamowienie_anulowane}}cancelled{{END}}" style="background: {{$zamowienie_bg}}" >
						<a href="{{IF $formularz_produktow_zakupionych_szablon}}#-{{$id_zamowienia}}{{ELSE}}#i{{$id_zamowienia}}{{END}}">
							<div class="box-naglowek{{UNLESS $projekt}} order{{END}}">
								{{IF $link_zaloguj}}<i class="icon-plus"></i>{{END}}
								<span class="label label-info" >{{IF $projekt}}<i class="icon icon-crop"></i>{{END}} {{$number_order_get}} {{$etykieta_bkt_id}}  {{$bkt_id}} </span>
								{{UNLESS $projekt}}<br/>{{END}}{{$order_type}} {{IF $projekt}}{{$order_name}}{{END}}
							</div>
							{{UNLESS $projekt}}
							<div class="box-naglowek time">
								<i class="icon-time"></i> {{$godziny_pracy}} ({{$dataStart}})
							</div>
							<div class="box-naglowek address">
								<i class="icon-home"></i> <span  >{{$pelny_adres}}</span>
							</div>

							<div class="box-naglowek klient">
								<i class="icon-user"></i> {{$klient_nazwa}} {{$telefon_etykieta}} {{$klient_telefon}}
							</div>
							{{END}}
						</a>
						<div class="clear"></div>
					</div>
					<div class="zamowienie-opis">
						<div class="opis">
							{{IF $ilosc_wersji}}<a href="#{{$id_zamowienia}}_wersje" class="btn btn-warning right wersjaBtn">{{$etykieta_wersje}} {{$ilosc_wersji}}</a>{{END IF}}
							<div class="alert alert-info alert-block">
								<h4 class="alert-heading">{{$job_description_naglowek}}</h4>
								<p class="opis_zamowienia">
								{{$job_description}}
								</p>
							</div>
							{{BEGIN projektLider}}
								<div class="widget-box">
									<div class="widget-title">
										<span class="icon">
											<i class="icon-user"></i>
										</span>
										<h5>{{$project_leader_etykieta}}</h5>
									</div>
									<div class="widget-content nopadding">
										<table class="table table-bordered table-striped table-hover">
											<tbody>
												<tr>
													<td>{{$project_leader_name}}</td>
													<td>{{$project_leader_telefony}}</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							{{END projektLider}}
							{{UNLESS $projekt}}
							<div class="widget-box">
								<div class="widget-title">
									<span class="icon">
										<i class="icon-user"></i>
									</span>
									<h5>{{$klient_nazwa}}</h5>
								</div>
								<div class="widget-content nopadding">
									<table class="table table-bordered table-striped table-hover">
										<thead>
											<tr>
												<th>{{$numer_klienta_etykieta}}</th>
												<th>{{$telefon_klienta_etykieta}} </th>
												<th>{{$adres_klienta_etykieta}}</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>{{$numer_klienta}}</td>
												<td class="telefony">{{$telefony_klienta}}</td>
												<td>{{$adres_klienta}}</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							{{END UNLESS}}
							
							{{BEGIN listaSms}}
							<div class="widget-box">
								<div class="widget-title">
									<span class="icon">
										<i class="icon-comments"></i>
									</span>
									<h5>{{$sms_naglowek}}</h5>
									<span class="label label-info tip-left" title="">
										{{$sms_ilosc}}
									</span>
								</div>

								<div class="widget-content nopadding">
									<ul class="recent-comments">
										{{$sms_lista}}
										{{BEGIN wiadomosc}}
										<li>
											<div class="user-thumb">
												<img width="40" height="40" src="{{$autor_zdjecie}}" alt="{{$autorNazwa}}">
											</div>
											<div class="comments">
												<span class="user-info"> {{$data_dodania}} {{$user}} {{$czy_wyslany}}  </span>
												<p >
													{{IF $wyslany_flaga}}<span id="{{$sms_id}}" class="edit_textarea">{{END}}{{$notatka}}{{IF $wyslany_flaga}}</span>{{END}}

													 {{IF $wyslany_flaga}}
													 <button class="edytuj_wiadomosc btn btn-primary fR" style="margin-left: 3px;">{{$sms_edytuj_etykieta}}</button>
													 <a href="{{$link_wyslij_sms}}" class="btn btn-danger fR">{{$sms_wyslij_ponownie_etykieta}}</a>
													 {{END}}
												</p>
												<div class="clear"></div>
											</div>
										</li>
										{{END wiadomosc}}
										{{IF $ilosc_smsWersje > 0}}
										<li class="wiecej widget-title" style="height: 10px; text-align: center; padding-top:5px; cursor: pointer;">
											<i class="icon-angle-down"></i>
											{{$pokaz_powiazane}}
										</li>
										<div class="wiecej_rozwin" style="display: none">
											{{$sms_lista_wersje}}
										</div>
										{{END}}
									</ul>
								</div>
							</div>
							{{END listaSms}}
							
							{{BEGIN listaNotatek}}
								<div class="widget-box">
									<div class="widget-title">
										<span class="icon">
											<i class="icon-comment"></i>
										</span>
										<h5>{{$note_naglowek}}</h5>
										<span class="label label-info tip-left" title="">
											{{$ilosc_notatek}}
										</span>
									</div>

									<div class="widget-content nopadding">
										<ul class="recent-comments">
											{{IF $ilosc_notatek > 4}}<ul class="notatki_wiecej">{{END}}
												{{BEGIN notatka}}
													<li>
														<div class="user-thumb">
															<img width="40" height="40" src="{{$autor_zdjecie}}" alt="{{$autorNazwa}}">
														</div>
														<div class="comments">
															<span class="user-info"> {{$data_dodania}} {{$user}}  </span>
															<p class="red">
																 {{$notatka}}
															</p>
														</div>
													</li>
												{{END notatka}}
											{{IF $ilosc_notatek > 4}}</ul>{{END}}

											{{IF $ilosc_notatekWersje > 0}}
												<li class="wiecej widget-title" style="height: 10px; text-align: center; padding-top:5px; cursor: pointer;">
													<i class="icon-angle-down"></i>{{$pokaz_powiazane}}
												</li>
												<div class="wiecej_rozwin" style="display:none;">
												{{$lista_notatek_szablonWersje}}
												</div>
											{{END}}
										</ul>
									</div>
								</div>
							{{END listaNotatek}}
							
							{{BEGIN listaZalacznikow}}
								<div class="widget-box">
									<div class="widget-title">
										<span class="icon">
											<i class="icon icon-paste"></i>
										</span>
										<h5>{{$zalacznik_naglowek}}</h5>
										<span class="label label-info tip-left" >
											{{$ilosc_zalacznikow}}
										</span>
									</div>
									<div class="widget-content nopadding">
										<table class="table table-bordered table-striped table-hover with-check">
											<tbody>
												<tr>	
												{{BEGIN zalacznik}}
													<tr>
														<td>
															<button class="btn btn-default">
																<i class="icon icon-file"></i>
															</button>
														</td>
														<td>
															{{$nazwa}}
														</td>
														<td>
															<a href="{{$url_pobierz}}" target="_blank" class="btn btn-default fR" >
																<i class="icon-download"></i> {{$pobierz_etykieta}}
															</a>
															<a href="{{$url}}" rel="lightbox:fullPage" class="btn btn-default fR" style="margin-right: 3px;">
																<i class="icon-search"></i> {{$podglad_etykieta}}
															</a>
														</td>
													</tr>
												{{END zalacznik}}
												</tr>
											</tbody>
										</table>
									</div>
								</div>
							{{END listaZalacznikow}}
							
							{{BEGIN listaWersji}}
							<div class="widget-box" id="{{$id_zamowienia}}_wersje">
								<div class="widget-title">
									<span class="icon">
										<i class="icon icon-archive"></i>
									</span>
									<h5>{{$wersje_naglowek}}</h5>
									<span class="label label-warning tip-left" data-original-title="">
										{{$ilosc_wersji}}
									</span>
								</div>
								<div class="widget-content nopadding">
									<table class="table table-bordered table-striped table-hover with-check">
										<tbody>
										{{BEGIN wersja}}
											<tr>
												<td class="wersjaData">
													<div class="data"><i class="icon icon-plus"></i> {{$date_added}}</div>
													<div class="data"><i class="icon icon-flag-checkered"></i> {{$data_zakonczenia}}</div>
													<div class="status">{{$status}}</div>
												</td>
												<td>
													{{IF $job_description}}
													<div class="alert alert-info alert-block">
														<h4 class="alert-heading">{{$opis_etykieta}}</h4>
														<p class="opis_zamowienia">{{$job_description}}</p>
													</div>
													{{END IF}}
												
													{{BEGIN listaSms}}
													<div class="widget-box">
														<div class="widget-title">
															<span class="icon"><i class="{{$ikona}}"></i></span>
															<h5>{{$etykieta_naglowek}}</h5>
															<span class="label label-info tip-left" data-original-title="">{{$ilosc}}</span>
														</div>
														<div class="widget-content nopadding">
															<ul class="recent-comments">
																{{BEGIN sms}}
																<li>
																	<div class="user-thumb">
																		<img width="40" height="40" alt="{{$user}}" src="{{$autor_zdjecie}}">
																	</div>
																	<div class="comments">
																		<span class="user-info">{{$data_dodania}} {{$user}} {{$czy_wyslany}}</span>
																		<p class="{{$klasa}}">{{$notatka}}</p>
																		<div class="clear"></div>
																	</div>
																</li>
																{{END sms}}
															</ul>
														</div>
													</div>
													{{END listaSms}}
												</td>
											</tr>
										{{END wersja}}
										</tbody>
									</table>
								</div>
							</div>
							{{END listaWersji}}
						</div>
						<div class="pozycja">
						
						{{BEGIN listaProdukow}}
							<table class="table table-bordered table-striped break">
								<thead>
									<tr>
										<th>{{$service_etykieta}}</th>
										<th>{{$quantity_etykieta}}</th>
									</tr>
								</thead>
								<tbody>
								{{BEGIN produkt}}
									<tr class="tip-top" title="{{$data_dodania}}">
										<td><span>{{$nazwa_produktu}}</span> </td>
										<td> {{IF $ilosc_produktu}} <span class="badge badge-success" >{{$ilosc_produktu}}</span>{{END IF}}</td>
									</tr>
								{{END}}
								</tbody>
							</table>
						{{END}}
							
						{{BEGIN listaAtrybutow}}
							<table class="table table-bordered table-striped break" >
								<thead>
									<tr>
										<th class="attr_etykieta" >{{$atrybuty_etykieta}}</th>
										<th class="attr_wartosc"></th>
									</tr>
								</thead>
								<tbody>
								{{BEGIN atrybut}}
									<tr>
										<td>{{$nazwa}}</td>
										<td>{{$wartosc}}</td>
									</tr>
								{{END atrybut}}
								</tbody>
							</table>
						{{END listaAtrybutow}}

						</div>
						<div class="clear"></div>
					</div>
					</div>
				</div>
			{{END zamowienie}}
			
			{{IF $projektApartamenty}}
			<hr/>
			{{END IF}}
			{{BEGIN projektApartamenty}}
			<div class="zakladka_tresc portlet apartamenty">
				<button class="btn btn-info  fR pozycjonowany" onclick="location.href = this.value ;" value="{{$url}}"><i class="icon-th-large"> </i> {{$etykieta_podglad}}</button>
				<div style="background: {{$kolor}}" class="content">
					<a href="{{$url}}">
						<span class="boxApartamenty">
							<i class="icon icon-reorder"></i>
							<span class="label label-success">{{$info}}</span> 
						</span>
						<span class="boxApartamenty">{{$etykieta_apartamenty}}</span>
						<span class="boxApartamenty appartments ilosc">
							<span class="current"><i class="icon-time tip-top" title="{{$etykieta_biezace}}"></i> {{$ilosc_biezacych}}</span> / <span class="total tip-top" title="{{$etykieta_wszystkie}}"><i class="icon-home"></i> {{$ilosc_apartamentow}}</span>
						</span>
						<span class="boxApartamenty appartments">{{$order_name}}</span>
					</a>
					<div class="clear"></div>
				</div>
			</div>
			{{END projektApartamenty}}
			</div>
		</div>
		{{BEGIN zakonczPrace}}
			<a href="{{$link_zakoncz_prace}}" class="btn btn-danger btn-block btn-lg"  >
			{{$zakoncz_prace_etykieta}}</a>
		{{END}}
	
	</div>
{{END tabletShort}}

	{{BEGIN listaSms}}
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="icon-comment"></i>
				</span>
				<h5>{{$sms_naglowek}}</h5>
				<span class="label label-info tip-left" title="">
					{{$sms_ilosc}}
				</span>
			</div>

			<div class="widget-content nopadding">
				<ul class="recent-comments">
					{{$sms_lista}}
					{{IF $ilosc_smsWersje > 0}}
					<li class="wiecej widget-title" style="height: 10px; text-align: center; padding-top:5px; cursor: pointer;">
						<i class="icon-angle-down"></i>
						{{$pokaz_powiazane}}
					</li>
					<div class="wiecej_rozwin" style="display: none">
						{{$sms_lista_wersje}}
					</div>
					{{END}}
				</ul>
			</div>
		</div>
	{{END}}
	{{BEGIN sms_pojedynczy}}
		<li>
			<div class="user-thumb">
				<img width="40" height="40" src="{{$autor_zdjecie}}" alt="{{$autorNazwa}}">
			</div>
			<div class="comments">
				<span class="user-info"> {{$data_dodania}} {{$user}} {{$czy_wyslany}}  </span>
				<p >
					{{IF $wyslany_flaga}}<span id="{{$sms_id}}" class="edit_textarea">{{END}}{{$notatka}}{{IF $wyslany_flaga}}</span>{{END}}
					
					 {{IF $wyslany_flaga}}
					 <button class="edytuj_wiadomosc btn btn-primary fR" style="margin-left: 3px;">{{$sms_edytuj_etykieta}}</button>
					 <a href="{{$link_wyslij_sms}}" class="btn btn-danger fR">{{$sms_wyslij_ponownie_etykieta}}</a>
					 {{END}}
				</p>
				<div class="clear"></div>
			</div>
		</li>
	{{END}}
	
	{{BEGIN historiaLogowan}}
		<div class="widget-box">
			<div class="widget-title">
				<span class="icon">
					<i class="icon icon-time"></i>
				</span>
				<h5>{{$historiaLogowan_naglowek}}</h5>
				<span class="label label-info tip-left" >
					{{$ilosc_logowan}}
				</span>
			</div>
			<div class="widget-content nopadding">
				
				<table class="table table-bordered table-striped table-hover">
					<thead>
						<tr>
							<th><i class="icon icon-truck"></i></th>
							<th><i class="icon icon-play"></i></th>
							<th><i class="icon icon-stop"></i></th>
							<th><i class="icon icon-time"></i></th>
						</tr>
					</thead>
					<tbody class="team-naglowek">
						{{BEGIN wpis}}
						<tr {{IF $auto_logout}}class="auto_wylogowany"{{END}}>
							<td><strong>{{$team}}</strong> {{$pracownicy}}</td>
							<td>{{$start}}</td>
							<td>{{IF $stop}}{{$stop}}{{ELSE}}*{{END}}</td>
							<td style="text-align: center; font-weight: bold">{{$hours}}</td>
						</tr>
						{{END}}
					</tbody>
					<tfoot>
						<tr>
							<td colspan="3" style="text-align: right">{{$etykieta_suma_godzin}}</td>
							<td style="text-align: center">{{$suma_godzin}}</td>
						</tr>
					</tfoot>
				</table>
			</div>
		</div>
	{{END}}
	{{BEGIN zdjecie_pracownika}}{{IF $zdjecie}}<img src="{{$zdjecie}}" title="{{$pracownik}}" class="tip-top" alt="{{$pracownik}}"/>{{ELSE}}<span title="{{$pracownik}}" class="tip-top">{{$pracownik}}</span>{{END}}{{END}}
	
	{{BEGIN widokProjektApartamenty}}
	<script type="text/javascript">
		$(document).ready(function(){
			$('.dataLi').on('click' , function(){
				var data = $(this).find('.dataTekst').text();
				$('ul.contact-list li').removeClass('data-aktywna');
				$(this).addClass('data-aktywna');
				pobierzApartamentyData(data);
				return false;
			});
			$( ".kliknij").live('click', function() {
				$(this).find('i:first').toggleClass('icon-minus');
				$(this).next( ".zamowienie-opis" ).toggle();
			});
			
			var uplyneloSekund = {{$uplynelo_sekund}};
			if (uplyneloSekund > 0)
			{
				$('#zalogowanyOd').html(timeString(uplyneloSekund));
				setInterval(function(){
					uplyneloSekund++;
					$('#zalogowanyOd').html(timeString(uplyneloSekund));
				}, 1000);
			}
			var i = 0;
			setInterval(function(){
				i = i+10;
				$('.icon-spinner').rotate(i);
			}, 60);
			
		});
		function timeString(secs)
		{
			var tekst = '';
			var czas = secondsToTime(secs)
			
			if (czas.h > 0) tekst = tekst + czas.h.toLocaleString()+'h ';
			if (czas.m > 0) tekst = tekst + czas.m.toLocaleString()+'m ';
			
			tekst = tekst + czas.s.toString()+'s';
			return tekst;
		}
		function pobierzApartamentyData(data)
		{
			$('.mobile-loader').fadeIn("normal");
			$.ajax({
				url: "{{$linkPobierzApartamentyData}}",
				type: 'POST',
				dataType: 'json',
				data: '&idProjektu={{$idProjektu}}&data='+data+'&idTeam={{$idTeam}}',
				async: true,
				success: function(dane) {
					if(dane.kod == 1)
					{
						$('.lista-apartamentow').html(dane.html);
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
	</script>
	<div class="widget-box" >
		<div class="widget-title">
			<span class="icon"><i class="fa icon-th"></i></span>
			<h5>{{$listaApartamentowEtykieta}} - {{$nazwaProjektu}} </h5>
		</div>
		<div class="widget-content nopadding">
			<div class="chat-users panel-right lista-dat-apartamenty">
				<div class="panel-title"><h5>{{$datyApartamentowEtykieta}}</h5></div>
				<div class="panel-content nopadding">
					<ul class="contact-list">
						{{BEGIN dataLista}}
						{{BEGIN dataWiersz}}
						<li id="" class="data data-link dataLi {{IF aktywna}}data-aktywna{{END}}">
							<a href="#" class="dataWiersz" >
								<span class="icon">
									<i class="fa icon-calendar"></i>
								</span>
								{{IF $zamowieniaOtwarte}}
									<span class="dataTekstOtwarte">{{$data}}</span>
								{{ELSE}}
									<span class="dataTekst">{{$data}}</span>
								{{END}}
							</a>
								<span class="msg-count badge badge-info">{{$ilosc}}</span>
						</li>
						{{END data}}
						{{END dataLista}}
					</ul>
				</div>
				<div class="clear"></div>
			</div>
			<div class="chat-content panel-left widokZamowien lista-apartamentow">
				{{BEGIN apartamentyLista}}
				{{BEGIN apartamentWiersz}}
				<div id="5661_tresc" class="zakladka_tresc">
					<div id="i5753" class="portlet zamowienie">
						{{IF $zalogowany}}
						<a class="btn btn-default fR pozycjonowany">
							<i class="icon-spinner"></i><span> {{$zalogowany_etykieta}}</span>
							<var id="zalogowanyOd"></var>
						</a>
						{{ELSE}}
						<button class="btn btn-info fR pozycjonowany" onclick="location.href = this.value ;" value="{{$loginLink}}">
							<i class="icon-signin"> </i>
							{{$zalogujEtykieta}}
						</button>
						{{END}}
						
						<div class="zamowienie-naglowek {{IF $opis_istnieje}}kliknij{{END}} " style="background: {{$zamowienie_bg}}">
							<a href="#i5753">
								<div class="box-naglowek szerokosc">
									{{IF $opis_istnieje}}
									<i class="icon-plus"></i>
									{{END}}
									<span class="label label-info"> {{$idPdf}} ({{$bktIdEtykieta}} {{$id}})  </span>
									{{$adres}} {{$apartament}}
								</div>
								<div class="box-naglowek szerokosc">
									<i class="icon-time"></i>
									{{$czas}}
								</div>
							</a>
							<div class="clear"></div>
						</div>
						<div class="zamowienie-opis" style="display: none;">
							{{BEGIN listaNotatka}}
							<div class="widget-box">
								<div class="widget-title">
									<span class="icon">
										<i class="icon-comment"></i>
									</span>
									<h5>{{$notatki}}</h5>
									<span class="label label-info tip-left" data-original-title=""> 1 </span>
								</div>
								<div class="widget-content nopadding">
									<ul class="recent-comments">
										{{BEGIN notatka}}
										<li>
											<div class="user-thumb">
												<img height="40" width="40" alt="" src="{{$zdjecie}}">
											</div>
											<div class="comments">
												<span class="user-info"> {{$dataDodania}} {{$autor_nazwa}} </span>
												<p class="red"> {{$notatka}} </p>
											</div>
										</li>
										{{END notatka}}
									</ul>
								</div>
							</div>
							{{END listaNotatka}}
							{{IF $klient_istnieje}}
							<div class="clear"></div>
							<div class="widget-box">
								<div class="widget-title">
									<span class="icon">
										<i class="icon-user"></i>
									</span>
										<h5>{{$nazwa_klienta}}</h5>
								</div>
								<div class="widget-content nopadding">
									<table class="table table-bordered table-striped table-hover">
										<thead>
											<tr>
												<th>{{$numer_klienta_etykieta}}</th>
												<th>{{$telefon_klienta_etykieta}} </th>
												<th>{{$adres_klienta_etykieta}}</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>{{$numer_klienta}}</td>
												<td class="telefony">{{$telefony_klienta}}</td>
												<td>{{$adres_klienta}}</td>
											</tr>
										</tbody>
									</table>
									<div class="clear"></div>
								</div>
							</div>
							{{END}}
							<div class="clear"></div>
						</div>
					</div>
				</div>
				{{END apartamentWiersz}}
				{{END apartamentyLisa}}
				<div class="clear"></div>
			</div>
			<div class="clear"></div>
		</div>
	</div>
	{{END widokProjektApartamenty}}
	
	{{BEGIN raport}}
	<!DOCTYPE html>
	<html lang="no">
		<head>
			<meta charset="UTF-8" />
		</head>
	<body >
	{{BEGIN header}}
	<table border="0" width="100%" style="border-bottom: 2px solid silver">
		<tr>
			<td style="width: 50%"></td>
			<td style="width: 50%; text-align: right"><img src="{{$logo}}" alt="Bredbånd og Kabel-TV Service AS" style="position: absolute; left: 0; top: 0; width: 260px" class="float: right"/></td>
		</tr>
	</table>
	{{END}}
	<p >
		<h1>{{$naglowek}}</h1>
	</p>
	{{BEGIN zamowienie}}
	<p>
		
	<h3>{{$tytul}} </h3>
	<h4>{{$status_etykieta}} {{$status}}</h4>
		
		{{BEGIN klientInformacje}}
		<p>
		<table>
			<thead>
				<tr>
					<th style="text-align: left;" >{{$klient_etykieta}}</th>
				</tr>
			</thead>
			<tbody>
				{{IF $imie}}
				<tr>
					<td style="width:200px;">{{$klient_nazwa_etykieta}} </td>
					<td>
						{{$imie}} {{$drugie_imie}} {{$nazwisko}}
					</td>
				</tr>
				{{END}}
				<tr>
					<td style="width:200px;">{{$klient_firma_etykieta}}</td>
					<td>
						{{$firma}}
					</td>
				</tr>
				<tr>
					<td style="width:200px;">{{$klient_adres_etykieta}}</td>
					<td>
						{{$adres}}
					</td>
				</tr>
			</tbody>
		</table>
		</p>
		{{END}}
		
		{{BEGIN historiaLogowania}}
		<p>
		<table>
			<thead>
				<tr colspan="2" >
					<th style="text-align: left;" >{{$historia_logowania_etykieta}}</th>
				</tr>
			</thead>
			<tbody>
				{{BEGIN wpis}}
				{{IF $data}}
				<tr >
					<td style="width:200px; font-weight: bold;">{{$data}}</td>
				</tr>
				{{ELSE}}
				<tr>
					<td style="width:200px;" >  {{$godzina_start}} - {{$godzina_stop}} ({{$hours}})</td>
					<td>{{$ekipa}} {{$pracownik_imie}} {{$pracownik_nazwisko}}</td>
				</tr>
				{{END}}
				{{END wpis}}
			</tbody>
		</table>
		</p>
		{{END historiaLogowania}}
		
		{{BEGIN notatki}}
		<p>
		<table>
			<thead>
				<tr colspan="2" >
					<th style="text-align: left;">{{$notatki_etykieta}}</th>
				</tr>
			</thead>
			<tbody>
				{{BEGIN wpis}}
				<tr>
					<td style="width:200px; vertical-align: top; border-bottom: 1px solid #ccc; ">
						{{$data}}<br/>
						{{$uzytkownik_imie}} {{$uzytkownik_nazwisko}}
					</td>
					<td style="border-bottom: 1px solid #ccc; padding: 10px 0;">
						{{$tresc}}
					</td>
				</tr>
				{{END wpis}}
			</tbody>
		</table>
		</p>
		{{END notatki}}
		
		{{BEGIN produktyZakupione}}
		<p>
		<table>
			<thead>
				<tr colspan="2">
					<th style="text-align: left;">{{$produkty_zakupione_etykieta}}</th>
				</tr>
			</thead>
			<tbody>
				{{BEGIN wpis}}
				<tr>
					<td style="width:200px;">
						{{$produkt}}
					</td>
					<td>
						x{{$ilosc}}
					</td>
				</tr>
				{{END wpis}}
			</tbody>
		</table>
		</p>
		{{END produktyZakupione}}
	</p>
	{{END zamowienie}}
	{{BEGIN footer}}
		<table border="0" width="100%" style="margin-bottom: -10px">
			<tr>
				<td style="width: 45%; font-size: 7pt">{{$stopka_adres}}</td>
				<td style="width: 35%; font-size: 7pt">{{$stopka_telefon}}</td>
				<td style="width: 20%; font-size: 7pt">{{$stopka_email}}</td>
			</tr>
		</table>
	{{END}}
	{{END raport}}