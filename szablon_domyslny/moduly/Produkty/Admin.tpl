{{BEGIN indexKamienie}}
<div class="widget-box">
	<div class="widget-content">
		<div class="tabbable inline">
			{{$zakladki}}
			<div class="tab-content">
				<div id="panel_tab2_example1" class="tab-pane active">
					<div class="widget-content">
						Proszę wybrać jedną z opcji powyżej.
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{{END}}
{{BEGIN dodajKamien}}
<div class="widget-box">
	<div class="widget-content">
		<div class="tabbable inline">
			{{$zakladki}}
			<div class="tab-content">
				<div id="panel_tab2_example1" class="tab-pane active">
					<div class="widget-content">
						{{$form}}
						{{$grid}}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
{{END}}
{{BEGIN klientMobilny}}
<style>
#sidebar > ul > li > a > span {
		display: none;
	}
#sidebar, #sidebar > ul {width: 44px}
#sidebar > a {
	background-image: -moz-linear-gradient(top, #464646 0%, #404040 100%);
	border-bottom: 1px solid #6e6e6e;
}
#sidebar > ul {
	background-color: #444444;
}
#sidebar > ul ul:before {
	border-right: 7px solid rgba(0, 0, 0, 0.2);
}
#sidebar > ul ul:after {
	border-right: 6px solid #222222;
 }
 #sidebar h5 a span, #sidebar h5 span {display: none}
 #content {
    margin-left: 45px;
}
#adminToggle{
	display:none;
}
</style>
{{END}}
{{BEGIN zakladki}}
	<ul id="myTab" class="nav nav-tabs tab-bricky">
		{{BEGIN zakladka}}
		<li class="{{$klasa}}">
			<a href="{{$link}}" data-toggle="">{{IF $ikona}}<i class="icon {{$ikona}}"></i>{{END}} {{$nazwa}} 
				{{IF $wyswietlajIlosc2}}<span class="label {{$iloscKlasa2}} tip-left" data-original-title="">{{$ilosc2}}</span>{{END}} </a>
		</li>
		{{END}}
		{{BEGIN subzakladki}}
		<li class="dropdown {{$klasa}}">
			<a class="dropdown-toggle" href="#" data-toggle="dropdown">
				<i class="icon {{$ikona}}"></i> {{$nazwa}}
			</a>
			<ul class="dropdown-menu dropdown-info">
				{{BEGIN subzakladka}}
				<li>
					<a href="{{$link}}" data-toggle=""> {{$nazwa}} </a>
				</li>
				{{END}}
			</ul>
		</li>
		{{END}}
	</ul>
{{END}}
{{BEGIN index}}
<script type="text/javascript">
	$(document).ready(function(){
		$('#odbiorcaTeam').live('change', function(){
			if($('#odbiorcaTeam option:selected').val() > 0)
				$('#odbiorcaUzytkownik').select2().select2("val", null);
		});
		$('#odbiorcaUzytkownik').live('change', function(){
			if($('#odbiorcaUzytkownik option:selected').val() > 0)
				$('#odbiorcaTeam').select2().select2("val", null);
		});
	});
	
	function anulujZamowienie(obiekt)
	{
		var status = $.urlParam('status');
		$.ajax({
				url: obiekt.href,
				type: 'POST',
				dataType: 'json',
				success: function(dane) {
					if(dane.success == false)
						alertModal('Error', dane.error);
					else
					{
						if(status == 'wszystkie' || status == null || status == 0)
						{
							$('#wiersz_'+dane.id).find('a[klucz=edycja]').remove();
							$('#wiersz_'+dane.id).find('a[klucz=ustawZaakceptowane]').remove();
							$('#wiersz_'+dane.id).find('a[klucz=anuluj]').remove();
						}
						else
						{
							$('#wiersz_'+dane.id).remove();
						}
						
						$('#wiersz_'+dane.id+' > td').slice(2,3).html(dane.statusZamowienia);
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
		});
		return false;
	}
	
	function zaakceptujZamowienie(obiekt)
	{
		var status = $.urlParam('status');
		$.ajax({
				url: obiekt.href,
				type: 'POST',
				dataType: 'json',
				success: function(dane) {
					if(dane.success == false)
						alertModal('Error', dane.error);
					else
					{
						if(status == 'wszystkie' || status == null || status == 0)
						{
							$('#wiersz_'+dane.id).find('a[klucz=ustawZaakceptowane]').remove();
							$('#wiersz_'+dane.id).find('a[klucz=edycja]').remove();
							$('#wiersz_'+dane.id).find('a[klucz=anuluj]').remove();
							$('#wiersz_'+dane.id+' > td').slice(2,3).html(dane.statusZamowienia);
							
						}
						else
							$('#wiersz_'+dane.id).remove();
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
		});
		
		return false;
	}
	
</script>
<div class="widget-box">
<div class="widget-content">
	<div class="tabbable inline">
		{{$zakladki}}
		<div class="tab-content">
			<div id="panel_tab2_example1" class="tab-pane active">
				<div class="widget-content">
					{{$etykieta_filtr_po_statusie}}
					<a class="btn {{IF $status == 'wszystkie'}}btn-danger{{ELSE}}btn-info{{END}}" href="{{$link_wszystkie}}" >{{$etykieta_wszystkie}}</a>
					<a class="btn {{IF $status == 'oczekuje'}}btn-danger{{ELSE}}btn-info{{END}}" href="{{$link_oczekujace}}" >{{$etykieta_oczujace}}</a>
					<a class="btn {{IF $status == 'zaakceptowane'}}btn-danger{{ELSE}}btn-info{{END}}" href="{{$link_zaakceptowane}}" >{{$etykieta_zaakceptowane}}</a>
					<a class="btn {{IF $status == 'anulowane'}}btn-danger{{ELSE}}btn-info{{END}}" href="{{$link_anulowane}}" >{{$etykieta_anulowane}}</a>
					<a class="btn {{IF $status == 'wydane'}}btn-danger{{ELSE}}btn-info{{END}}" href="{{$link_wydane}}" >{{$etykieta_wydane}}</a>
					<div class="clear"></div>
					{{$form}}
				</div>
				{{$grid}}
			</div>
		</div>
	</div>
</div>
</div>
{{END}}

{{BEGIN listaPrzyjec}}
<script type="text/javascript">
	$(document).ready(function(){
		
		$('#odbiorcaTeam').live('change', function(){
			if($('#odbiorcaTeam option:selected').val() > 0)
				$('#odbiorcaUzytkownik').select2().select2("val", null);
		});
		$('#odbiorcaUzytkownik').live('change', function(){
			if($('#odbiorcaUzytkownik option:selected').val() > 0)
				$('#odbiorcaTeam').select2().select2("val", null);
		});
		sprawdzPrzyjete($('#przyjete'));
		$('#przyjete').on('click', function(){
			sprawdzPrzyjete($(this));
		});
		
		function sprawdzPrzyjete(obiekt)
		{
			if(obiekt.is(':checked'))
			{
				$('#odbiorcaTeam').select2().select2("val", null);
				$('#odbiorcaUzytkownik').select2().select2("val", null);
				$('#odbiorcaUzytkownik').attr('disabled', 'disabled');
				$('#odbiorcaTeam').attr('disabled', 'disabled');
			}
			else
			{
				$('#odbiorcaUzytkownik').removeAttr('disabled');
				$('#odbiorcaTeam').removeAttr('disabled');
			}
		}
	});
</script>
<div class="widget-box">
<div class="widget-content">
	<div class="tabbable inline">
		{{$zakladki}}
		<div class="tab-content">
			<div id="panel_tab2_example1" class="tab-pane active">
				<div class="widget-content">{{$form}}</div>
				{{$grid}}
			</div>
		</div>
	</div>
</div>
</div>
{{END}}

{{BEGIN breadcrumbs}}
<ol class = "breadcrumb">
	<li> <strong>{{$sciezka_label}} </strong></li>
	{{BEGIN strona}}
   <li><a href="javascript:" class="sciezka" id="kategoriaId_{{id}}" >{{$nazwa}}</a></li>
   {{END}}
</ol>
{{END}}

{{BEGIN grupaProduktowSzablon}}
<div class="grupa_{{$idProduktu}}">
	<table cellpadding="5" >
		<thead>
			<tr>
				<th>{{$kodEtykieta}}</th>
				<th>{{$nazwaEtykieta}}</th>
				<th>{{$iloscEtykieta}}</th>
			</tr>
		</thead>
	{{BEGIN grupaProduktow}}
	<tr>
		<td style="border-top:1px solid #ccc;" >{{$kod}}</td>
		<td style="border-top:1px solid #ccc;" >{{$nazwa}}</td>
		<td style="border-top:1px solid #ccc;" >{{$ilosc}}</td>
	</tr>
	{{END}}
	</table>
</div>
{{END}}
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
	var kategoria = 0;
	
	$(document).ready(function () {
		
		$(document).on('click', '.podgladProduktu' , function(e){ podgladProduktu($(this));	});

		$("#filter").keyup(function(){
 
	      var filter = $(this).val(), count = 0;
			
			$("q").each(function(){
				
				if($(this).text().search(new RegExp(filter, "i")) < 0)
				{
	         	$(this).addClass('ukryj');
					$(this).parent('li').addClass('ukryj');
				}
				else 
				{
					$(this).removeClass('ukryj');
					$(this).parent('li').removeClass('ukryj');
					count++;
	      	}
			})
		});
		

		$(window).scroll(function() {

			var pozycja = 315;

			if($('.wyszukiwarka-lista li:not(#wiecej)').length >= $('#ilosc').text())
			{
			}
			else
			{
				if($('#fraza').val().length > 2 || kategoria > 0)
				{
					if(($(window).scrollTop() + 280 ) > ($(document).height() - $(window).height())) {
						if(!blokujWysylanie)
						{
							blokujWysylanie = 1;
							szukaj($('#fraza').val(), kategoria);
						}
					}
				}
			}
		});
		
		if(navigator.platform == 'iPad')
			iPad = 1;
		
		
		$('#fraza').delayKeyup(function(el){
			$('#nrStrony').val({{$nrStrony}});
			$('#naStronie').val({{$naStronie}});
			if(kategoria > 0)
			{
				szukaj(el.val(), kategoria);
			}
			else if(el.val().length > {{$iloscZnakow}})
			{
				szukaj(el.val(), kategoria);
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
		
		$('#czyscSzukajKategorie').live('click', function(){
			
			$('#filter').val('');
			$('#filter').keyup();
			return false;
			
		});
		
		$('q').live('click', function(){
			
			$('#nrStrony').val({{$nrStrony}});
			$('#naStronie').val({{$naStronie}});
			
			kategoria = $(this).attr('id').replace('q', ''); 
			szukaj('', kategoria);
			$('#pokazKategorie').click();
			$('#fraza').val('');
		});
		

		$('#pokazKategorie').live('click', function(){
			if($('#kategoriePodglad').is(':visible'))
				$('#kategoriePodglad').slideUp(300);
			else
				$('#kategoriePodglad').slideDown(300);
			
			return false;
		});
		
		$('.sciezka').live('click', function(){
			szukaj('', $(this).attr('id').replace('kategoriaId_', ''));
			return false;
		})
	});
	
	
	function podgladProduktu(obiekt)
	{
		var id = obiekt.attr('id').replace('podgladId_', '');
		modalAjax("{{$podgladProduktu}}"+'&id_produktu='+id);
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
				data: '&fraza='+fraza+'&nrStrony='+nrStrony+'&naStronie='+nrStronie+'&kategoria='+kategoria,
				async: true,
				success: function(dane) {
					$('#loader').fadeOut(500);
					
					if(kategoria > 0)
						$('#sciezka').html(dane.sciezka);
					else
						$('#sciezka').html('');

					if(dane['kod'] == 1)
					{
						$('#pusta-lista').remove();
						$('ul.wyszukiwarka-lista').css('height', 'auto');
						
						if(nrStrony > 1)
							$('ul.wyszukiwarka-lista').append(dane['html']);
						else
							$('ul.wyszukiwarka-lista').html(dane['html']);

						$('.ilosc').spinner({min: 1});
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
<div id="sciezka" class="margin">
</div>
<div>
		<div class="formularz_grid" style="padding-top:10px;">
			<input type="hidden" name="nrStrony" id="nrStrony" value="{{$nrStrony}}" />
			<input type="hidden" name="naStronie" id="naStronie" value="{{$nrStronie}}" />
			<form id="wyszukiwarka" class="form-inline" action="" method="post" name="no-focus-wyszukiwarka" enctype="multipart/form-data">
			<ul class="fL">
				<li class="fL">
					{{BEGIN dodajNowyProdukt}}
					<a id="dodajProdukt" href="{{$urlDodajProdukt}}" class="btn btn-lg btn-success" style="font-size:14px;">
						<i class="icon icon-plus-sign-alt"></i> {{$dodajProduktEtykieta}}
					</a>
					{{END}}
					{{BEGIN produktySerwis}}
					<button id="serwis" data-id="{{$idKategoriiSerwis}}" class="btn btn-lg btn-warning" style="font-size:14px;">
						<i class="icon icon-wrench "></i> {{$produktySerwisEtykieta}}  <span class="label label-important tip-left">{{$iloscSerwis}}</span>
					</button>
					{{END}}
					{{BEGIN produktyNiekompletne}}
					<button id="niekompletne" data-id="{{$idKategoriiNiekompletne}}" class="btn btn-lg btn-success" style="font-size:14px;">
						<i class="icon icon-adjust"></i> {{$produktyNiekompletneEtykieta}}  <span class="label label-important tip-left">{{$iloscNiekompletne}}</span>
					</button>
					{{END}}
				</li>
				<li class="fL">
					<label class="input_ok label-szukaj" for="szukaj" >{{$szukajFraza}} </label> 
					<input class="input-szukaj szukaj-storage" type="text" placeholder="{{$szukajFrazaPlaceholder}}" autocomplete="off" name="fraza" id="fraza" value="" />
					<button class="btn btn-lg" id="pokazKategorie" ><i class="icon icon-list"></i></button>
					
					<span id="ilosc-wynikow" class="help-block"></span>
				</li>
				
			</ul>
			</form>
			
			<div class="clear"></div>
		</div>

</div>
<div id="kategoriePodglad" style="display:none;">
	{{$kategorie}}
</div>
<div class="widget-box" >
	<div class="widget-content" >
		<ul class="wyszukiwarka-lista">
			{{BEGIN listaWynikow}}
			{{BEGIN pustaLista}}
				<li id="pusta-lista">{{$brakWynikowWyszukiwania}}</li>
			{{END pustaLista}}
			{{BEGIN produkt}}
			<li id="zamowienie_{{$idProduktu}}">
				<div class="widok-wyszukaj-naglowek">
					<div class="widok-wyszukaj-tytul fL"  >
						<table cellpadding="8px">
							<tr>
								{{IF $zdjecieMiniaturka}}
								<td rowspan="2" class="no-padding">
									<a href="{{$zdjecieLink}}" data-lightbox="lightbox" >
										<div style="width:45px; height: 45px">
											<img src="{{$zdjecieMiniaturka}}" alt="{{$produktNazwa}}" width="45px" height="45px" />
										</div>
									</a>
								</td>
								{{END}}
								<td>
									<span >
										<i class="icon icon-list"></i>
										{{$kategoria}}
									</span>
								</td>
								<td>
									<strong class="tytul_produkt_magazyn">{{$produktNazwa}}</strong> 
								</td>
								<td >
									<i class="icon icon-barcode"></i> {{$produktKod}}
								</td>
								<td>
									<span class="badge badge-info" data-original-title="">
										{{$ilosc_etykieta}} {{$produktIlosc}}
									</span>
								</td>

							</tr>
						</table>
					</div>
					<div class="widok-wyszukaj-przyciski fR" style="width:30%;" >
						{{IF wyswietlajEdytujProdukt}}
						<a href="{{$edytujProduktLink}}" id="produktId_{{$idProduktu}}" class="btn btn-warning btn-lg edytujProdukt " title="{{$edytujProduktEtykieta}}">
							<i class="icon icon-pencil"></i>
						</a>
						{{END}}
						
						<button id="podgladId_{{$idProduktu}}" class="btn btn-success btn-lg podgladProduktu" title="{{$podgladProduktuEtykieta}}">
							<i class="icon icon-zoom-in"></i>
						</button>

					</div>
					<div class="clear"></div>
				</div>	
				<div class="zamowienie-informacje" id="podgladGrupyInformacje_{{$idProduktu}}" style="display:none; position:relative;">
					{{$szablonProdukty}}
				</div>
				<div class="clear"></div>
			</li>
			{{END produkt}}

			{{END listaWynikow}}
		</ul>
	</div>
</div>

{{END}}


{{BEGIN magazyn}}

<div class="widget-box">
<div class="widget-content">
	<div class="tabbable inline">
		{{$zakladki}}
		<div class="tab-content no-overflow" >
			<div id="panel_tab2" class="tab-pane active">
				{{$wyszukiwarka}}
			</div>
		</div>
	</div>
</div>
</div>
{{END}}

{{BEGIN dodajProdukt}}
<script type="text/javascript" >
	$(document).ready(function(){
		
		wyswietlajProduktyGrupy();
		
		$('input[name=grupa]').live('click', function(){
			wyswietlajProduktyGrupy();
		});
		
	});
	function wyswietlajProduktyGrupy()
	{
		if($('input[name=grupa]').is(':checked'))
		{
			$('#produktyGrupy').removeClass('js-hide');
			$('label[for=produktyGrupy]').parents('.control-group').show();
		}
		else
		{
			$('label[for=produktyGrupy]').parents('.control-group').hide();
		}
	}
</script>
<div class="widget-box">
<div class="widget-content">
	<div class="tabbable inline">
		{{$zakladki}}
		<div class="tab-content">
			<div id="panel_tab2_example1" class="tab-pane active">
				{{$formularz}}
			</div>
		</div>
	</div>
</div>
</div>
{{END}}

{{BEGIN produktyLista}}
<div class="widget-box">
<div class="widget-content">
	<div class="tabbable inline">
		{{$zakladki}}
		<div class="tab-content">
			<div id="panel_tab2_example1" class="tab-pane active">
				<p> Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan et iusto odio dignissim qui blandit praesent. </p>
				<div class="alert alert-info">
				<p> Raw denim you probably haven't heard of them jean shorts Austin. Nesciunt tofu stumptown aliqua, retro synth master cleanse. Mustache cliche tempor, williamsburg carles vegan helvetica. Reprehenderit butcher retro keffiyeh dreamcatcher synth. </p>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
{{END}}

{{BEGIN kategorieMenu}}
<div id="drzewoKategorii">
	<ul class="magazyn_tree menuKategorii">
		<li class="no-border" style="padding:8px;">
			<form id="wyszukiwarka" class="form-inline" enctype="multipart/form-data" name="no-focus-wyszukiwarka" method="post" action="">
			<label class="input_ok" for="szukaj">Search : </label> <input type="text" id="filter" name="szukajKategoria" class="szukajMenuKategori" />
			<button id="czyscSzukajKategorie" >Czyść</button>
			</form>
		</li>
		{{$etykieta_nazwa_kategorii}}
		</li>
		{{$kategorie}}
	</ul>
</div>
{{END kategorieMenu}}

{{BEGIN kategoria_glowna}}
<li id="{{$id_kategorii}}" class="idKategorii_{{$id_kategorii}}"><q class="poziom_{{$poziom}}" id="q{{$id_kategorii}}"><b>{{$nazwa_kategorii}}</b></q><ul>
{{END}}

{{BEGIN kategoria}}
<li id="{{$id_kategorii}}"><q id="q{{$id_kategorii}}" class="poziom_{{$poziom}}" style="padding-left:{{$padding}}px !important;">{{$nazwa_kategorii}} {{if($blokuj_wyswietlanie, '<img src="/_system/admin/ikony/deaktywuj.png"/>')}} {{if($blokuj_przypisywanie, '<img src="/_system/admin/ikony/blokuj.png"/>')}}{{if($filtr18, '<img src="/_system/admin/ikony/flag_blue.png"/>')}}</q> 
{{END}}

{{BEGIN drzewo}}
{{BEGIN listaStart}}<ul>{{END}}
{{BEGIN elementStart}}<li class="poziom{{$poziom}} {{$klasa}}">{{END}}
{{BEGIN elementStop}}</li>{{END}}
{{BEGIN listaStop}}</ul>{{END}}
{{END}}

{{BEGIN drzewoKategorii}}
<div class="widget-box">
<div class="widget-content">
<div class="tabbable inline">
	{{$zakladki}}
		<div class="tab-content">
			<div id="panel_tab2_example1" class="tab-pane active">
				<div class="alert alert-info">
					<p>Kliknij w wybraną kategorię aby móc nią zarządzać.</p>
				</div>
				<div class="grid_border">
					<div id="drzewoKategorii">
						<ul class="magazyn_tree">
							{{$etykieta_nazwa_kategorii}}
							</li>
							{{$kategorie}}
						</ul>
					</div>
				</div>
				<div id="menuKategorii" style="display:none;">
					<button href="#" id="link_dodaj" class="add btn btn-primary btn-xs" ><i class="icon icon-plus-sign"></i> Dodaj</button>
					<button href="#" id="link_edytuj" class="edit btn btn-success btn-xs"><i class="icon icon-pencil"></i> Edytuj</button>
					<button href="#" id="link_usun" class="delete btn btn-danger btn-xs"><i class="icon icon-minus-sign"></i> Usuń</button>
				</div>
			</div>
		</div>
</div>
</div>
</div>

<script >
	$(document).ready(function(){
		
		$('li q').live('mouseenter',function(e) {
			$('li q').css('color', 'black');
			$(this).css('color', '#03678A');

		});
		$('li q').live('click',function(e) {
			var id = $(this.parentNode).attr('id');
			var tooltip = $('#menuKategorii');

			$('li q').css('background', '');
			$(this).css('background', '#B8EDA6');
			tooltip.children('.add').attr('href', '{{$link_kategoria}}&a=dodaj&json=true&typ={{$typ}}&id=' + id);
			tooltip.children('.edit').attr('href', '{{$link_kategoria}}&a=edytuj&json=true&typ={{$typ}}&id=' + id);
			tooltip.children('.delete').attr('href', '{{$link_kategoria}}&a=usun&json=true&typ={{$typ}}&id=' + id);

			if ($(this.parentNode).has('ul').length > 0)
			{
				$('.delete').hide();
				$('#usun').hide();
			}
			else
			{
				$('.delete').show();
				$('#usun').show();
			}
			
			var left = $(this).offset().left;
			var top = $(this).offset().top;
			tooltip.css('left', left + ($(this).width()/2)).css('top', top - 275 )
			tooltip.show();
			
		});
		$("#link_dodaj").on('click', function(){
			otworzOkno($(this).attr('href'));
		});
		$("#link_usun").on('click', function(){
			potwierdzenieModal1('{{$usun_confirm_tresc}}', '{{$usun_confirm_naglowek}}', 'otworzOkno(\''+$(this).attr('href')+'\')');
			return false;
			//otworzOkno($(this).attr('href'));
		});
		$("#link_edytuj").on('click', function(){
			otworzOkno($(this).attr('href'));
		});
	});
	
	function otworzOkno(link)
		{
			$.ajax({
					url: link,
					type: 'POST',
					dataType: 'json',
					async: true,
					success: function(dane) {
						if(dane.akcja == 'usun')
						{
							$('li#'+dane.id).remove();
							$('.close').click();
						}
						else
						{
							$('#oknoModalne .modal-body').html(dane.html);
							$('#oknoModalne').modal('show');
							$('#oknoModalne .modal-body, #oknoModalne .modal-body iframe html').css('background', 'none');
							dopasujModala();
						}
						
					},
					error: function (xhr, ajaxOptions, thrownError) {
						alert(xhr.status);
						alert(thrownError);
					}
			})
			return false;
		}
</script>
{{END}}

{{BEGIN sortowanie}}
<link rel="stylesheet" type="text/css" href="/_system/_biblioteki/tree_component.css" />
<script type="text/javascript" src="/_system/_biblioteki/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="/_system/_biblioteki/jquery.optionTree.js"></script>
<script type="text/javascript" src="/_system/_biblioteki/tree_component.min.js"></script>
<script type="text/javascript" src="/_system/_biblioteki/css.js"></script>
<div class="widget-box">
<div class="widget-content">
<div class="tabbable inline">
	{{$zakladki}}
		<div class="tab-content">
			<div id="panel_tab2_example1" class="tab-pane active">
				<div class="kategorieSortowanie">
				{{$form}}
				</div>
			</div>
		</div>
</div>
</div>
</div>


<script type="text/javascript">
<!--
$(function(){
/*
 * Zamiana nazw zmiennych
 *
 * sortowalnaKategoria - s_k
 * niesortowalnaKategoria - n_s_k
 * kategoria - k
 * poziom - p
 */

$("#sortowanieKategorii").tree({
	cookies: true,
	ui: {
		theme_name  : "default",
		animation: 100
	},
	rules : {
		draggable: ["s_k" ],
		dragrules: ["s_k inside s_k" ,
					"s_k after s_k",
					"s_k before s_k",
					"s_k inside n_s_k"
					]
	},
	callback: {
		onmove : function(NODE,REF_NODE,TYPE) {
			$("#przenoszona").val(NODE.id);
			$("#cel").val(REF_NODE.id);
			$("#polozenie").val(TYPE);
			$("#formularzSortowanie").submit();
		}
	},
	opened: [{{$rozwin}}]
});
});
-->
</script>

{{END}}

{{BEGIN edytuj}}
{{$formularz}}
<script type="text/javascript">
$(document).ready(function(){

	$("#generujKod").click(function(){
		$("#kod").val(tworzKodBezPl($("#nazwa").val()));
	});

	$("#generujDaneUrl").click(function(){
		var url = tworzKodBezPl($("#nazwa").val());
		var rodzic = $('#kodRodzica').val();
		//var idKategorii = $('#idKategorii').val();
		//$("#url").val(rodzic+url+idKategorii);
		$("#url").val(rodzic+url);
	});

});

$('#zapisz').click(function() {

		$.ajax({
			url: '{{$link_kategoria_zapisz}}',
			type: 'post',
			dataType: 'json',
			data: $("#kategoriaEdycja").serialize(),
			beforeSend: function() {
			},
			error : function() {
			},
			success: function(data) {
				$('#oknoModalne .modal-body').html(data.html);

				if (data.status == 1)
				{
					if (data.akcja == 'dodaj')
					{
						$('#'+data.id).append('<ul><li id="'+data.id_dziecka+'"><q style="background: #51AD13; color: white;">'+data.nazwa+'</q></li></ul>');

						if (data.blokujWyswietlanie == 1)
							$('#'+data.id_dziecka).append('<img src="/_system/admin/ikony/deaktywuj.png">');

						if (data.blokujPrzypisywanie == 1)
							$('#'+data.id_dziecka).append('<img src="/_system/admin/ikony/blokuj.png">');
						
					}
					if (data.akcja == 'edytuj')
					{
						$('#q'+data.id).text(data.nazwa);
						$('#q'+data.id).css('background-color','green');
						$('#q'+data.id).css('color','white');
						var idKategorii = data.idKategorii.split(',');
						$.each(idKategorii, function(index, value) {
							$('#q'+value).siblings('img').remove();

							if (data.blokujPrzypisywanie == 1)
								$('#q'+value).after('<img src="/_system/admin/ikony/blokuj.png">');

							if (data.blokujWyswietlanie == 1)
								$('#q'+value).after('<img src="/_system/admin/ikony/deaktywuj.png">');
							
						});
					}

					var tooltip = $('.tooltip');
					tooltip.hide();
					setTimeout(function(){
						$('.close').click();
				  }, 2000);
					
				}
			}
		});
	});
</script>
{{END}}
{{BEGIN finalizacja}}

<script type="text/javascript">
	
	$(document).ready(function(){
		sprawdzWyswietlajSelect();
		$('.produktIlosc').spinner({
						min: 1,
					});
					
		$('.ui-spinner-button').live('click' ,function(){
		
			var input = $(this).siblings('.produktIlosc');
			if(input != 'undefined')
				edytujKoszyk(input.attr('id').replace('produktIloscId_', ''), input.val());
			
		});
		
		$('.produktIlosc').on('keyup', function(){
			
			edytujKoszyk($(this).attr('id').replace('produktIloscId_', ''), $(this).val());
		});
		
		$('input[name=dodajGrupowo]').live('change', function(){
			sprawdzWyswietlajSelect();
		});
		
		$('input[name=wybierzOdbiorce]').live('change', function(){
			sprawdzWyswietlajSelect();
		});
		
		$('.usunZKoszyka').live('click', function(){
			usunZKoszyka($(this).attr('id').replace('produktId_', ''));
		});
		
	});
	
	function sprawdzWyswietlajSelect()
	{
		if($('input[name=dodajGrupowo]').is(':checked'))
		{
			$('#odbiorcaUzytkownik').parents('.control-group').hide();
			$('#odbiorcaTeam').parents('.control-group').hide();
			$('label[for=wydaj]').parents('.control-group').hide();
			$('#wydaj').attr('checked', false);
			$('#wydaj').click();
			$('#wydaj').prop('checked', false);
			$('#wydaj').removeAttr('checked');
			if($("input[name=wybierzOdbiorce]:checked" ).val() == 'Team')
			{
				$('label[for=odbiorcaTeamLista]').parent('.control-group').show();
				$('label[for=odbiorcaUzytkownikLista]').parent('.control-group').hide();
			}
			else
			{
				$('label[for=odbiorcaUzytkownikLista]').parent('.control-group').show();
				$('label[for=odbiorcaTeamLista]').parent('.control-group').hide();
			}
		}
		else
		{
		
			$('label[for=odbiorcaTeamLista]').parent('.control-group').hide();
			$('label[for=odbiorcaUzytkownikLista]').parent('.control-group').hide();
			$('label[for=wydaj]').parents('.control-group').show();
			
			if($( "input[name=wybierzOdbiorce]:checked" ).val() == 'Team')
			{
				$('#odbiorcaUzytkownik').parents('.control-group').hide();
				$('#odbiorcaTeam').parents('.control-group').show();
				$('select#odbiorcaTeam').removeClass('js-hide');
				$('select#odbiorcaTeam').select2();
			}
			else
			{
				$('#odbiorcaUzytkownik').parents('.control-group').show();
				$('#odbiorcaTeam').parents('.control-group').hide();
			}
		}
	}
	
	function edytujKoszyk(idProduktu, ilosc)
	{
		$.ajax({
				url: "{{$edytujProduktZKoszyka}}",
				type: 'POST',
				dataType: 'json',
				data: {id:idProduktu, ilosc:ilosc},
				async: true,
				success: function(dane) {
					if(dane.success == false)
						alertModal('Error', "{{$bladEdycjiProduktu}}");
					else
						$('#koszykIlosc').html(dane.iloscProduktow);
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
	
	function usunZKoszyka(idProduktu)
	{
		$.ajax({
				url: "{{$usunZKoszykaLink}}",
				type: 'POST',
				dataType: 'json',
				data: {id:idProduktu, },
				async: true,
				success: function(dane) {
					$('#koszykIlosc').html(dane.iloscProduktow);
					$('#produktId_'+idProduktu).parents('tr').remove();
					if( dane.iloscProduktow == 0)
					{
						$('#miejsceNaTabele').html('<div class="alert alert-info">{{$koszyk_pusty}}</div>');
						$('#formularz').remove();
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
		});
		return false;
	}
	
</script>

<div class="widget-box">
<div class="widget-content">
	<div class="tabbable inline">
		{{$zakladki}}
		<div class="tab-content no-overflow" >
			<div id="panel_tab2" class="tab-pane active">
				<div class="widget-box nopadding">
					
					<div class="widget-title">
						<span class="icon"><i class="icon icon-list"></i></span>
						<h5>{{$listaZamowionychProduktowEtykieta}}</h5>
					</div>
					<div class="widget-content nopadding">
						{{BEGIN listaProduktow}}
						<div id="miejsceNaTabele">
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th style="width:100px;"> {{$zdjecieEtykieta}} </th>
										<th> {{$produktIdEtykieta}} </th>
										<th> {{$produktKodEtykieta}} </th>
										<th> {{$produktNazwaEtykieta}} </th>
										<th> {{$produktIloscEtykieta}} </th>
										<th> {{$usunEtykieta}} </th>
									</tr>
								</thead>
								<tbody>
									{{BEGIN produkt}}
									<tr class="wierszZamowienia">
										<td style="text-align:center;"> 
											{{IF $zdjecie}}
											<a href="{{$zdjecieLink}}" rel="lightbox" >
												<img src="{{$zdjecie}}" /> 
											</a>
											{{ELSE}}
												{{$brakZdjecia}}
											{{END}}
										</td>
										<td> #{{$produktId}} </td>
										<td> {{$produktKod}} </td>
										<td> {{$produktNazwa}} </td>
										<td style="text-align:center;"> 
											<span class="cena qty_full">
												<input type="text" name="produkt[]" {{IF wlaczOgraniczenieMaxIlosc}}max="{{$maxIlosc}}"{{END}} id="produktIloscId_{{$produktId}}" class="produktIlosc qty fL" value="{{$produktIlosc}}" />
											</span>
										</td>
										<td style="text-align:center;">
											<button id="produktId_{{$produktId}}" title="{{$usunEtykieta}}" class="btn btn-danger btn-small usunZKoszyka">
												<i class="icon icon-minus-sign"></i>
											</button>
										</td>
									</tr>
									{{END}}
								</tbody>
								<tfoot>
									<tr>
										<th class="total-label" colspan="4" style="text-align:right;"> <span style="font-size : 14pt;">{{$iloscLacznieEtykieta}} : </span> </th>
										<th class="total-amount" id="koszykIlosc"> <span style="font-size : 14pt;"> {{$iloscLacznie}}</span> </th>
										<th></th>
									</tr>
								</tfoot>
							</table>
							<div class="col-xs-6">
								{{$formularz}} 
							</div>
						</div>
						{{END}}
						<div id="formularz">
							<a class="btn btn-danger margin" href="{{$urlFinalizacjaCzysc}}" >{{$etykietaFinalizacjaCzysc}}</a>
							<a class="btn btn-warning margin" href="{{$wsteczLink}}" >{{$wsteczEtykieta}}</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>
{{END}}
{{BEGIN kartaZamowienia}}
<div class="widget-box">
<div class="widget-content">
	<div class="tabbable inline">
		{{$zakladki}}
		<div class="tab-content no-overflow" >
			<div id="panel_tab2" class="tab-pane active">
				<div class="widget-box">
					<div class="widget-title">
						<span class="icon">
							<i class="icon icon-th-list"></i>
						</span>
						<h5>{{$etykietaNaglowek}}</h5>
						<div class="buttons">
							<a class="btn" href="javascript: modalIFrame('{{$linkDrukuj}}');" title="{{$etykietaDrukuj}}">
								<i class="icon icon-print"></i>
								<span class="text">{{$etykietaDrukuj}}</span>
							</a>
						</div>
					</div>
					{{BEGIN informacje}}
					<div class="widget-content">
						<div class="invoice-content">
							<div class="invoice-head">
								<div class="invoice-meta">
									{{$zamowienieNoEtykieta}}
									<span class="invoice-number">#{{$zamowienieNo}} </span>
									<span class="invoice-date">{{$dataEtykieta}} {{$data}}</span>
								</div>
								<h4>{{$nazwa_tytul}}</h4>
								<div class="invoice-from">
									<ul>
										<li>
											<span>
												<strong>{{$from_etykieta}}</strong>
											</span>
											<span>{{$from_nazwa_firmy}}</span>
											<span>{{$from_ulica_firma}}</span>
											<span>{{$from_miasto_firma}}</span>
											{{ IF $osobaWydajacaNazwa}}
											<strong>{{$osobaWydajacaEtykieta}}</strong>
											<span>{{$osobaWydajacaNazwa}}</span>
											{{END IF}}
										</li>
									</ul>
								</div>
								{{BEGIN odbiorca}}
								<div class="invoice-to">
									<ul>
										<li>
											<span>
												<strong>{{$to_etykieta}}</strong>
											</span>
											<span>{{$to_nazwa}}</span>
											<span>{{$to_ulica}}</span>
											<span>{{$to_miasto}}</span>
										</li>
									</ul>
								</div>
								{{END}}
							</div>
							<div>
								<table class="table table-bordered table-striped table-hover">
									<thead>
										<tr>
											<th style="width:5%;"> {{$produktIdEtykieta}} </th>
											<th style="width:10%;"> {{$produktCodeEtykieta}} </th>
											<th> {{$produktNazwaEtykieta}} </th>
											<th style="width:10%;"> {{$produktIloscEtykieta}} </th>
										</tr>
									</thead>
									<tbody>
										{{BEGIN produkt}}
										<tr>
											<td style="text-align:center;"> #{{$produktId}} </td>
											<td style="text-align:center;">{{$produktKod}}</td>
											<td> 
												<strong style="font-size:13pt;">{{$produktNazwa}}</strong> <br/>
												{{BEGIN produktGrupyBlok}}
												<ul>
													{{BEGIN produktGrupy}}
													<li>
														( {{$produktKodGrupa}} ) {{$produktNazwaGrupa}} - {{$produktIloscGrupa}}
													</li>
													{{END}}
												</ul>
												{{END}}
											</td>
											<td style="text-align:center;"> {{$produktIlosc}} </td>
										</tr>
										{{END produkt}}
									</tbody>
									<tfoot>
										<tr>
											<th class="total-label" colspan="3" style="text-align:right;"> <span style="font-size : 14pt;">{{$iloscLacznieEtykieta}} </span> </th>
											<th style="text-align:center;" class="total-amount" id="koszykIlosc"> <span style="font-size : 14pt;"> {{$iloscLacznie}}</span> </th>
										</tr>
									</tfoot>
								</table>
							</div>
								{{BEGIN input}}
									{{$inputPodpis}}
								{{END}}
								{{BEGIN podpis}}
								
								<div style=" width: 400px; float: right;">
									<span class="podpisNaglowek"> {{$podpisane_przez}} <strong>{{$odbiorca}}</strong></span>
									<img width="400px;" src="data:{{$podpisImg}}" />
								</div>
								<br class="clear"></div>
								{{END}}
						</div>
					</div>
					</div>
					{{END informacje}}
				</div>
				<a href="{{$urlPowrot}}" class="btn btn-primary" alt="{{$powrotEtykieta}}">
					{{$powrotEtykieta}}
				</a>
			</div>
		</div>
	</div>
</div>
</div>
{{END}}
{{BEGIN kartaZamowieniaPdf}}
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
			th.naglowek_produkty{
				text-transform:uppercase; border-top: solid 1px #7d7d7d; border-bottom: solid 1px #7d7d7d; border-right: 1px solid #fff; background: #dedede;  text-align: left;
			}
			.pozycje_produkt{
				text-align: left; vertical-align: top; border-bottom: 1px solid #e6e6e6; padding: 6px 10px;
			}
			.suma_etykieta{
				background:#3fb1d7; color:#fff; text-transform:uppercase; text-align: right; padding: 6px 6px; font-size: 11pt;
			}
			.suma_wartosc{
				background:#545454; color:#fff; padding: 6px 10px; font-size: 11pt;
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
	{{BEGIN informacje}}
	<table border="0" cellspacing="0" align="left" width="100%" style="page-break-inside:avoid; margin-left: 0px; margin-right: -30px; margin-top: 50px">
		<tr>
			<td style="font-size: 13pt; text-align: left; width: 50%;">
				{{$zamowienieNoEtykieta}} {{$zamowienieNo}}
			</td>
			<td style="font-size: 13pt; text-align: right;">
				{{$dataEtykieta}} {{$data}}
			</td>
		</tr>
		<tr>
			<td style="height:40px;" ></td>
		</tr>
		<tr>
			<td style="font-size: 18pt; ">
				<strong>{{$nazwa_tytul}}</strong>
			</td>
		</tr>
		<tr>
			<td style="height:30px;" ></td>
		</tr>
		<tr>
			<td valign="top" style="font-size: 13pt; text-align: left; width: 50%;">
				<strong>{{$from_etykieta}}</strong><br/>
				{{$from_nazwa_firmy}}<br/>
				{{$from_ulica_firma}}<br/>
				{{$from_miasto_firma}}<br/>
				{{ IF $osobaWydajacaNazwa}}
				<strong>{{$osobaWydajacaEtykieta}}</strong><br/>
				<span>{{$osobaWydajacaNazwa}}</span><br/>
				{{END IF}}
			</td>
			<td valign="top" style="font-size: 13pt; text-align: left;">
				<strong>{{$to_etykieta}}</strong><br/>
				{{$to_nazwa}}
				
			</td>
		</tr>
	</table>
	<table width="100%" cellSpacing="0" cellPadding="8" border="0"  style="page-break-inside:avoid; margin-top: 30px;" >
		<tr>
			<th class='naglowek_produkty' >{{$produktIdEtykieta}}</th>
			<th class='naglowek_produkty' >{{$produktCodeEtykieta}}</th>
			<th class='naglowek_produkty' >{{$produktNazwaEtykieta}}</th>
			<th class='naglowek_produkty' >{{$produktIloscEtykieta}}</th>
		</tr>
		{{BEGIN produkt}}
		<tr>
			<td class='pozycje_produkt' >{{$produktId}}</td>
			<td class='pozycje_produkt' >{{$produktKod}}</td>
			<td class='pozycje_produkt' >
				<strong style="font-size:13pt;">{{$produktNazwa}}</strong> <br/>
				{{BEGIN produktGrupyBlok}}
				<ul>
					{{BEGIN produktGrupy}}
					<li>
						( {{$produktKodGrupa}} ) {{$produktNazwaGrupa}} - {{$produktIloscGrupa}}
					</li>
					{{END}}
				</ul>
				{{END}}
			</td>
			<td class='pozycje_produkt' >{{$produktIlosc}}</td>
		</tr>
		{{END}}
		<tr>
			<td></td>
			<td></td>
			<td class='suma_etykieta' >{{$iloscLacznieEtykieta}}</td>
			<td class='suma_wartosc' >{{$iloscLacznie}}</td>			
		</tr>
	</table>
	{{BEGIN podpis}}
	<table width='100%' style="margin-top:80px;">
		<tr>
			<td></td>
			<td style='text-align: right;'>
				<img width="400px;" src="data:{{$podpisImg}}" />
			</td>
		</tr>
	</table>
	{{END}}
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
	</body>
</html>

{{END}}

{{BEGIN zestawienieOdbiorcy}}
<div class="widget-box">
<div class="widget-content">
	<div class="tabbable inline">
		{{$zakladki}}
		<div class="tab-content">
			<div id="panel_tab2_example1" class="tab-pane active">
				<div class="widget-content">
					{{$formularz}}
				</div>
			</div>
		</div>
	</div>
</div>
</div> 

{{END}}
{{BEGIN podgladProduktu}}
<div class="widget-box">
	<div class="widget-content">
		<div id="kartaProduktu-container">
			<div class="kartaProduktu-zdjecie">
				{{IF $zdjecie}}
				<img src="{{$zdjecie}}" class="zdjecieProduktu" /><br/>
				{{END}}
				<small><i><strong>{{$t_status}} </strong>{{$status}}</i></small> | <small><i><strong>{{$t_dodany_przez}} </strong> {{$osoba_dodajaca}}</i></small>
				| <small><i><strong>{{$t_opiekun_produktu}} </strong>{{$opiekun}}</i></small>
			</div>
			<div class="kartaProduktu-opis">

				<h3 style="line-height:20px; color: #067499; ">{{$nazwa}}</h3>
				<small><strong>{{$t_kategoria}}</strong> {{BEGIN sciezka}} {{$nazwaKategorii}} / {{END}}</small>
				<br/>
				<h4>{{$t_kod_produktu}} {{$kod}} </h4>
				<h5>{{$t_ilosc}} {{$ilosc}} {{$t_szt}} </h5>
				{{IF $wyswietlajCena}}
				<h5>{{$t_cena}} {{$cena}} {{$t_kr}} </h5>
				{{END}}
				{{IF $opis}}
				<p style="background:#CAEEFA; padding: 10px;">
					{{$opis}}
				</p>
				{{END IF}}
				<br/>
				<hr />
				{{BEGIN atrybuty}}
				<table class="tabelaProduktu">
					<tr><th colspan="2" >{{$t_atrybuty_produktu}}</th></tr>
					{{BEGIN atrybut}}
					<tr>
						<td style="width:60%;" ><strong>{{$nazwa}}</strong></td>
						<td><span style="color:#000;" >{{$wartosc}}</span></td>
					</tr>
					{{END}}
				</table>
				{{END}}
				{{BEGIN produktyGrupa}}
				<table class="tabelaProduktu">
					<tr><th colspan="2" >{{$t_produkty_w_grupie}}</th></tr>
					{{BEGIN produkt}}
					<tr>
						<td style="width:60%;" ><strong>{{$nazwa}}</strong></td>
						<td><span style="color:#000;" >{{$ilosc}} {{$t_szt}} </span></td>
					</tr>
					{{END}}
				</table>
				{{END}}
				{{BEGIN zalaczniki}}
				<table class="tabelaProduktu">
					<tr><th colspan="2" >{{$t_zalaczniki}}</th></tr>
					{{BEGIN zalacznik}}
					<tr>
						<td style="width:60%;" ><strong>{{$nazwa}}</strong></td>
						<td><a class="btn btn-small btn-success" target="_blank" href="{{$link}}" ><i class="icon icon-download"></i></a></td>
					</tr>
					{{END}}
				</table>
				{{END}}
			</div>
		</div>
		<div class="clear"></div>
	</div>
</div>
{{END}}
{{BEGIN widokPracownika}}
<script>
	$(document).ready(function(){
		$('#odbiorcaTeam').live('change', function(){
			if($('#odbiorcaTeam option:selected').val() > 0)
				$('#odbiorcaUzytkownik').select2().select2("val", null);
		});
		$('#odbiorcaUzytkownik').live('change', function(){
			if($('#odbiorcaUzytkownik option:selected').val() > 0)
				$('#odbiorcaTeam').select2().select2("val", null);
		});
		$('#zaznacz_wszystkie, #odwroc_zaznaczenie').on('click', function(){
			sprawdzZaznaczone();
		});
		
		$('.wiersz').on('click', function()
		{
			sprawdzZaznaczGrupa($(this));
		});
		
		$(".region_tytul").click(function(){
			if ($(this).hasClass('closed'))
				$(this).find('i').first().attr('class', 'icon-circle-arrow-up');
			else
				$(this).find('i').first().attr('class', 'icon-circle-arrow-down');

			regionToggle($(this));
		});
		
		$('#zwrotProduktow').on('click', function(){
			var zaznaczone = pobierzZaznaczone();
			if(zaznaczone.length > 0)
			{
				var link = '{{$linkZwrocProdukty}}'+'&ids='+zaznaczone;
				window.location.href = link;
			}
			else
			{
				alertModal('{{$alertTytulNieZaznaczono}}', '{{$alertTrescNieZaznaczono}}');
			}
		});
	});
	
	function sprawdzZaznaczGrupa(obiekt)
	{
		var grupa = obiekt.attr('data-grupa');
		var produktgrupa = obiekt.attr('data-produktgrupa');
		var zaznaczony = obiekt.find('input[type=checkbox]').attr('checked');
		if(grupa != 'undefined' && grupa > 0)
		{
			if(zaznaczony == 'checked')
				$('.wiersz[data-produktgrupa='+grupa+']').find('input[type=checkbox]').prop('disabled', false).attr('checked', false);
			else
				$('.wiersz[data-produktgrupa='+grupa+']').find('input[type=checkbox]').prop('disabled', true);
		}
		else if(produktgrupa != 'undefined' )
		{
			if(zaznaczony != 'checked')
			{
				var zaznaczone = $('.wiersz[data-produktgrupa='+produktgrupa+']').find('input[type=checkbox]:checked').length;
				var wszystkie = $('.wiersz[data-produktgrupa='+produktgrupa+']').length - 1;

				if(zaznaczone == wszystkie)
				{
					$('.wiersz[data-grupa='+produktgrupa+']').find('input[type=checkbox]').attr('checked', true);
					$('.wiersz[data-produktgrupa='+produktgrupa+']').find('input[type=checkbox]').prop('disabled', true);
				}
				else
				{
					$('.wiersz[data-grupa='+produktgrupa+']').find('input[type=checkbox]').attr('checked', false);
					$('.wiersz[data-produktgrupa='+produktgrupa+']').find('input[type=checkbox]').prop('disabled', false);
				}
			}
		}
	}
	
	function sprawdzZaznaczone()
	{
		setTimeout(
				  function(){  
					  $('td.grupowe input[type="checkbox"]').each(function(){
						  var grupa = $(this).parents('.wiersz').attr('data-grupa');
						  if(grupa != 'undefined')
						  {
							  if($(this).is(':checked')){
									$('.wiersz[data-produktgrupa='+grupa+']').find('input[type=checkbox]').prop('disabled', true).attr('checked', false);
							  }
							  else
							  {
								  $('.wiersz[data-produktgrupa='+grupa+']').find('input[type=checkbox]').prop('disabled', false);
							  }
							} 
						  });
					}
				  , 200);
		
	}
	
	function pobierzZaznaczone()
	{
		var zaznaczone = [];
		$('td.grupowe input[type="checkbox"]:enabled').each(function(){
			if($(this).is(':checked'))
			{
				zaznaczone.push($(this).val());
			}
		});
	
		return zaznaczone;
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
		
</script>
<div class="tabbable inline">
	{{$zakladki}}
	<div class="tab-content">
		<div id="panel_tab2_example1" class="tab-pane active">
			<div class="widget-content">
				{{$form}}
				<div class="clear"></div>
			</div>
			{{BEGIN gridProduktyPracownika}}
			<h4 class="magazynNaglowek" ><i class="icon icon-user" ></i> {{$pracownikNaglowek}}</h4>
			<div class="formularz_region ">
				<div class="widget-title region_tytul">
					<span class="icon">
						<i class="icon-circle-arrow-up"></i>
					</span>
					<h5>{{$tytulListaProduktowPracownika}}</h5>
				</div>
				<div id="details" class="region_tresc region_zamkniety" style="display: block;">
					{{$gridProduktyPracownika}}
				</div>
				<button class="btn btn-info" id="zwrotProduktow" title="{{$etykietaZwrotProduktu}}" >{{$etykietaZwrotProduktu}}</button>
			</div>
			{{END}}
			{{BEGIN gridProduktyTeamu}}
			<h4 class="magazynNaglowek" ><i class="icon icon-user" ></i> {{$teamNaglowek}}</h4>
			<div class="formularz_region ">
				<div class="widget-title region_tytul">
					<span class="icon">
						<i class="icon-circle-arrow-up"></i>
					</span>
					<h5>{{$tytulListaProduktowTeamu}}</h5>
				</div>
				<div id="details" class="region_tresc region_zamkniety" style="display: block;">
					{{$produktyTeamu}}
				</div>
				<button class="btn btn-info" id="zwrotProduktow" title="{{$etykietaZwrotProduktu}}" >{{$etykietaZwrotProduktu}}</button>
			</div>
			{{END}}
		</div>
	</div>
</div>
{{END}}
{{BEGIN mojeProdukty}}
<script>
	$(document).ready(function(){
	
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
		
	});
	
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
		
</script>
<div class="tabbable inline">
	{{$zakladki}}
	<div class="tab-content">
		<div id="panel_tab2_example1" class="tab-pane active">
			<div class="widget-content">
				{{$form}}
				<div class="clear"></div>
			</div>
			{{BEGIN gridProduktyPracownika}}
			<h4 class="magazynNaglowek" ><i class="icon icon-user" ></i> {{$pracownikNaglowek}}</h4>
			<div class="formularz_region ">
				<div class="widget-title region_tytul">
					<span class="icon">
						<i class="icon-circle-arrow-up"></i>
					</span>
					<h5>{{$tytulListaProduktowPracownika}}</h5>
				</div>
				<div id="details" class="region_tresc region_zamkniety" style="display: block;">
					{{$gridProduktyPracownika}}
				</div>
			</div>
			{{END}}
			{{BEGIN gridProduktyTeamu}}
			<h4 class="magazynNaglowek" ><i class="icon icon-user" ></i> {{$teamNaglowek}}</h4>
			<div class="formularz_region ">
				<div class="widget-title region_tytul">
					<span class="icon">
						<i class="icon-circle-arrow-up"></i>
					</span>
					<h5>{{$tytulListaProduktowTeamu}}</h5>
				</div>
				<div id="details" class="region_tresc region_zamkniety" style="display: block;">
					{{$produktyTeamu}}
				</div>
			</div>
			{{END}}
		</div>
	</div>
</div>
{{END}}
{{BEGIN listaKartPracownika}}
<script>
	$(document).ready(function(){
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
	});
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
</script>
<div class="tabbable inline">
	{{$zakladki}}
	<div class="tab-content">
		<div id="panel_tab2_example1" class="tab-pane active">
			<div class="widget-content nopadding">
				<h4 class="magazynNaglowek" ><i class="icon icon-user" ></i> {{$tytulListaZamowienPracownika}}</h4>
				<div class="formularz_region ">
					<div class="widget-title region_tytul">
						<span class="icon">
							<i class="icon-circle-arrow-up"></i>
						</span>
						<h5>{{$tytulListaZamowienPracownika}}</h5>
					</div>
					<div id="details" class="region_tresc region_zamkniety" style="display: block;">
						{{$grid}}
					</div>
				</div>
				<h4 class="magazynNaglowek" ><i class="icon icon-truck" ></i> {{$tytulListaZamowienTeam}}</h4>
				<div class="formularz_region">
					<div class="widget-title region_tytul">
						<span class="icon">
							<i class="icon-circle-arrow-up"></i>
						</span>
						<h5>{{$tytulListaZamowienTeam}}</h5>
					</div>
					<div id="details" class="region_tresc region_zamkniety" style="display: block;">
						{{$gridTeam}}
					</div>
				</div>
				<div class="clear"></div>
			</div>
			
		</div>
	</div>
</div>
{{END}}
{{BEGIN zamowNowyProdukt}}
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
	var kategoria = 0;
	
	$(document).ready(function () {
		
		$(document).on('click', '.podgladProduktu' , function(e){ podgladProduktu($(this));	});
		
		$("#filter").keyup(function(){
 
	      var filter = $(this).val(), count = 0;
			
			$("q").each(function(){
				
				if($(this).text().search(new RegExp(filter, "i")) < 0)
				{
	         	$(this).addClass('ukryj');
					$(this).parent('li').addClass('ukryj');
				}
				else 
				{
					$(this).removeClass('ukryj');
					$(this).parent('li').removeClass('ukryj');
					count++;
	      	}
			})
		});
	});
	
</script>
	<div class="tabbable inline">
	{{$zakladki}}
	<div class="tab-content no-overflow" >
			<div id="panel_tab2" class="tab-pane active">
				{{$wyszukiwarka}}
			</div>
	</div>
	</div>
{{END}}

{{BEGIN zwrocProdukty}}
<script type="text/javascript">
	$(document).ready(function () {
		
		/*
		$('.stan').on('change', function(){
			var wartosc = $(this).val();
			if($(this).parents('tr').hasClass('grupa') && jQuery.inArray(wartosc, [{{$stanProduktuKosz}}]) >= 0)
			{
				var pomocnik = $('#produktInformacje');
				pomocnik.show();
				var top = ($(this).offset().top + 30);
				pomocnik.offset({
						left: $(this).offset().left,
						top: top
					});
			}
			else
			{
				$('#produktInformacje').hide();
			}
		});
		*/
		
		$('.transfer').on('click', function(){ transferSelect(); })
		
		$('.stan').on('change', function(){ sprawdzStan($(this)); })
		
		$('#zaznacz_wszystkie_transfer').on('click', function(){
			
			var i = $(this).find('i')
			i.toggleClass('icon-check-empty icon-check');
			if(i.hasClass('icon-check'))
			{
				$('.transfer:not(:disabled)').attr('checked', true);
			}
			else
			{
				$('.transfer').attr('checked', false);
			}
			
			transferSelect();
			
			$.uniform.update();
			
		});
		$('#zaznacz_wszystkie_nowe').on('click', function(){
			var i = $(this).find('i')
			i.toggleClass('icon-check-empty icon-check');
			if(i.hasClass('icon-check'))
			{
				$('.new').attr('checked', true);
			}
			else
			{
				$('.new').attr('checked', false);
			}
			$.uniform.update();
		});
		if(!klientMobilny())
			$('select').select2();
		
		$('.ilosc').spinner(
				{
					min:1
				}).uniform();
	});
	
	function transferSelect()
	{
		var zaznaczony = false;
		$('.transfer').each(function(){
			if($(this).is(':checked')) zaznaczony = true;
		});
		
		if(zaznaczony)
			$('.transferSelect').show();
		else
			$('.transferSelect').hide();
		
		$('.transferSelect select').select2();
		
	}
	
	function sprawdzStan(obiekt)
	{
		var wartosc = obiekt.val();
		if(wartosc == 'kosz' || wartosc == 'zgubiony' || wartosc == 'zniszczone_uzytkownik' || wartosc == 'serwis')
		{
			obiekt.parents('.wiersz').find('.transfer').prop("disabled", true);
		}
		else
		{
			obiekt.parents('.wiersz').find('.transfer').prop("disabled", false);
		}
	}
	
</script>

<div id="produktInformacje" class="popover bottom" style="display: none;" >
	<input type="checkbox" name="zamienNaNowy" /> Change for new <br/>
	<input type="checkbox" name="zamienNaZamiennik" /> Change for another products<br/>
	<select name="zamiennik">
		<option value="zamiennik 1">zamiennik 1</option>
		<option value="zamiennik 2">zamiennik 2</option>
		<option value="zamiennik 3">zamiennik 3</option>
	</select>
</div>

	<div class="tabbable inline">
	{{$zakladki}}
	<div class="tab-content no-overflow">
			<div id="panel_tab2" class="tab-pane active">
				<form name="zwrotProuktow" action="{{$linkZatwierdzZwrotProduktow}}" method="POST">
					<input type="hidden" name="idTeamu" value="{{$idTeamu}}" />
					<input type="hidden" name="idPracownika" value="{{$idPracownika}}" />
				<table class="table table-striped table-bordered">
					<thead>
						<tr>
							<th>{{$kodEtykieta}}</th>
							<th>{{$zdjecieEtykieta}}</th>
							<th>{{$nazwaEtykieta}}</th>
							<th>{{$iloscEtykieta}}</th>
							<th style="width:30%;">{{$opisEtykieta}}</th>
							<th>{{$statusEtykieta}}</th>
							<th>{{$przekazEtykieta}}</th>
							<th>{{$wymienEtykieta}}</th>
						</tr>
					</thead>
					<tbody>
						{{BEGIN produkt}}
						<tr class="wiersz wiersz_{{$id}} {{$klasa}} {{$grupa}}">
							<td>
								<input type="hidden" name="id[]" value="{{$id}}" />
								<input type="hidden" name="iloscMagazyn[]" class="iloscMagazyn-{{$id}}" value="{{$iloscMagazyn}}"
								{{$kod}}</td>
							<td>
								{{IF $zdjecieLink}}
								<a rel="lightbox" href="{{$zdjecieLink}}">
									<img alt="{{$nazwa}}" src="{{$zdjecie}}" />
								</a>
								{{ELSE}}
									{{$zdjecie}}
								{{END}}
							</td>
							<td>
								{{$nazwa}}
							</td>
							<td>
								<span class="wyszukiwarka_spinner qty">
									<input name="ilosc[]" class="ilosc" value="{{$ilosc}}" max="{{$ilosc}}" />
								</span>
							</td>
							<td>
								<textarea name="opis[]" class="opis" style="width: 90%;">
									
								</textarea>
							</td>
							<td>
								{{$stanInput}}
							</td>
							<td class="tdTransfer" >
								<input type="checkbox" name="przekazUzytkownikowi[]" class="transfer" {{IF $blokujTransfer}}disabled{{END}} value="{{$id}}" />
							</td>
							<td class="tdNew" >
								<input type="checkbox" {{IF $iloscMagazyn == 0}}disabled{{END}} {{IF $blokujZamiana}}disabled{{END}} {{IF $wymusZmiana}}disabled checked="checked"{{END}} name="zmienNaNowe[]" class="new" value="{{$id}}" />
							</td>
						</tr>
						{{END}}
						<tr>
							<td colspan="6">
							</td>
							<td>
								<a id="zaznacz_wszystkie_transfer" class="btn btn-small akcja_grupowa" title="Select/Unselect" href="javascript:void(0)">
									<i class="icon-check-empty" alt="Select/Unselect" title="Select/Unselect"></i>
								</a>
							</td>
							<td>
								<a id="zaznacz_wszystkie_nowe" class="btn btn-small akcja_grupowa" title="Select/Unselect" href="javascript:void(0)">
									<i class="icon-check-empty" alt="Select/Unselect" title="Select/Unselect"></i>
								</a>
							</td>
						</tr>
					</tbody>
				</table>
					<div class="control-group input_ok transferSelect" style="display:none;" >
						<label class="control-label input_ok" >{{$przekazLabel}}</label>
						<div class="controls">{{$inputSelectPrzekaz}}</div>
					</div>
					<button class="btn btn-primary">{{$etykietaZatwierdzZwrot}}</button>
					<a href="{{$powrotDoListaProduktowUrl}}" class="btn btn-info">{{$powrotDoListaProduktowEtykieta}}</a>
				</form>
			</div>
	</div>
	</div>
{{END}}

{{BEGIN zatwierdzZwrotProduktow}}
 <div class="tabbable inline">
	{{$zakladki}}
	<div class="tab-content no-overflow" >
		<div id="panel_tab2" class="tab-pane active"></div>
	</div>
 </div>
{{END}}
{{BEGIN kartaZwrotu}}
<div class="tabbable inline">
	{{$zakladki}}
	<div class="tab-content no-overflow" >
			<div id="panel_tab2" class="tab-pane active">
				{{BEGIN informacje}}
				<div class="widget-box">
				<div class="widget-title">
					<span class="icon">
						<i class="icon icon-th-list"></i>
					</span>
					<h5>{{$etykietaNaglowek}}</h5>
					<div class="buttons">
						<a class="btn" href="javascript: modalIFrame('{{$linkDrukuj}}');" title="{{$etykietaDrukuj}}">
							<i class="icon icon-print"></i>
							<span class="text">{{$etykietaDrukuj}}</span>
						</a>
					</div>
				</div>
				<div class="widget-content">
					<div class="invoice-content">
						<div class="invoice-head">
							<div class="invoice-meta">
								{{$zamowienieNoEtykieta}}
								<span class="invoice-number">#{{$zamowienieNo}} </span>
								<span class="invoice-date">{{$dataEtykieta}} {{$data}}</span>
							</div>
							<h4>{{$nazwa_tytul}}</h4>
							<div class="invoice-from">
								<ul>
									<li>
										<span>
											<strong>{{$from_etykieta}}</strong>
										</span>
										<span>{{$from_nazwa_firmy}}</span>
										<span>{{$from_ulica_firma}}</span>
										<span>{{$from_miasto_firma}}</span>
										{{ IF $osobaWydajacaNazwa}}
										<strong>{{$osobaWydajacaEtykieta}}</strong>
										<span>{{$osobaWydajacaNazwa}}</span>
										{{END IF}}
									</li>
								</ul>
							</div>
							{{BEGIN odbiorca}}
							<div class="invoice-to">
								<ul>
									<li>
										<span>
											<strong>{{$to_etykieta}}</strong>
										</span>
										<span>{{$to_nazwa}}</span>
										<span>{{$to_ulica}}</span>
										<span>{{$to_miasto}}</span>
									</li>
								</ul>
							</div>
							{{END}}
						</div>
						<div>
							<table class="table table-bordered table-striped table-hover">
								<thead>
									<tr>
										<th style="width:5%;"> {{$produktIdEtykieta}} </th>
										<th style="width:10%;"> {{$produktCodeEtykieta}} </th>
										<th> {{$produktNazwaEtykieta}} </th>
										<th> {{$produktStanEtykieta}} </th>
										<th style="width:10%;"> {{$produktIloscEtykieta}} </th>
									</tr>
								</thead>
								<tbody>
									{{BEGIN produkt}}
									<tr>
										<td style="text-align:center;"> #{{$produktId}} </td>
										<td style="text-align:center;">{{$produktKod}}</td>
										<td>
											<strong style="font-size:13pt;">{{$produktNazwa}}</strong> <br/>
											{{BEGIN produktGrupyBlok}}
											<table >
												{{BEGIN produktGrupy}}
												<tr>
													<td>{{$produktKodGrupa}}</td>
													<td>{{$produktNazwaGrupa}}</td>
													<td>{{$produktStan}}</td>
													<td>{{$produktIloscGrupa}}</td>
												</tr>
												{{END}}
											</table>
											{{END}}
										</td>
										<td>
											{{$produktStan}}
										</td>
										<td style="text-align:center;"> {{$produktIlosc}} </td>
									</tr>
									{{END produkt}}
								</tbody>
								<tfoot>
									<tr>
										<th class="total-label" colspan="4" style="text-align:right;"> <span style="font-size : 14pt;">{{$iloscLacznieEtykieta}} </span> </th>
										<th style="text-align:center;" class="total-amount" id="koszykIlosc"> <span style="font-size : 14pt;"> {{$iloscLacznie}}</span> </th>
									</tr>
								</tfoot>
							</table>
						</div>
						{{BEGIN input}}
							{{$inputPodpis}}
						{{END}}
						{{BEGIN podpis}}

						<div style=" width: 400px; float: right;">
							<span class="podpisNaglowek"> {{$podpisane_przez}} <strong>{{$odbiorca}}</strong></span>
							<img width="400px;" src="data:{{$podpisImg}}" />
						</div>
						<br class="clear"></div>
						{{END}}
					</div>
				</div>
				</div>
				</div>
				{{END}}
				<a href="{{$backToUrl}}" title="{{$backToEtykieta}}" class="btn btn-primary">{{$backToEtykieta}}</a>
			</div>
	</div>
</div>

{{END}}
{{BEGIN kartaZwrotuPdf}}
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
			th.naglowek_produkty{
				text-transform:uppercase; border-top: solid 1px #7d7d7d; border-bottom: solid 1px #7d7d7d; border-right: 1px solid #fff; background: #dedede;  text-align: left;
			}
			.pozycje_produkt{
				text-align: left; vertical-align: top; border-bottom: 1px solid #e6e6e6; padding: 6px 10px;
			}
			.suma_etykieta{
				background:#3fb1d7; color:#fff; text-transform:uppercase; text-align: right; padding: 6px 6px; font-size: 11pt;
			}
			.suma_wartosc{
				background:#545454; color:#fff; padding: 6px 10px; font-size: 11pt;
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
	{{BEGIN informacje}}
	<table border="0" cellspacing="0" align="left" width="100%" style="page-break-inside:avoid; margin-left: 0px; margin-right: -30px; margin-top: 50px">
		<tr>
			<td style="font-size: 13pt; text-align: left; width: 50%;">
				{{$zamowienieNoEtykieta}} {{$zamowienieNo}}
			</td>
			<td style="font-size: 13pt; text-align: right;">
				{{$dataEtykieta}} {{$data}}
			</td>
		</tr>
		<tr>
			<td style="height:40px;" ></td>
		</tr>
		<tr>
			<td style="font-size: 18pt; ">
				<strong>{{$nazwa_tytul}}</strong>
			</td>
		</tr>
		<tr>
			<td style="height:30px;" ></td>
		</tr>
		<tr>
			<td valign="top" style="font-size: 13pt; text-align: left; width: 50%;">
				<strong>{{$from_etykieta}}</strong><br/>
				{{$from_nazwa_firmy}}<br/>
				{{$from_ulica_firma}}<br/>
				{{$from_miasto_firma}}<br/>
				{{ IF $osobaWydajacaNazwa}}
				<strong>{{$osobaWydajacaEtykieta}}</strong><br/>
				<span>{{$osobaWydajacaNazwa}}</span><br/>
				{{END IF}}
			</td>
			<td valign="top" style="font-size: 13pt; text-align: left;">
				<strong>{{$to_etykieta}}</strong><br/>
				{{$to_nazwa}}
				
			</td>
		</tr>
	</table>
	<table width="100%" cellSpacing="0" cellPadding="8" border="0"  style="page-break-inside:avoid; margin-top: 30px;" >
		<tr>
			<th class='naglowek_produkty' >{{$produktIdEtykieta}}</th>
			<th class='naglowek_produkty' >{{$produktCodeEtykieta}}</th>
			<th class='naglowek_produkty' >{{$produktNazwaEtykieta}}</th>
			<th class='naglowek_produkty' >{{$produktStanEtykieta}}</th>
			<th class='naglowek_produkty' >{{$produktIloscEtykieta}}</th>
		</tr>
		{{BEGIN produkt}}
		<tr>
			<td class='pozycje_produkt' >{{$produktId}}</td>
			<td class='pozycje_produkt' >{{$produktKod}}</td>
			<td class='pozycje_produkt' >
				<strong style="font-size:13pt;">{{$produktNazwa}}</strong> <br/>
				{{BEGIN produktGrupyBlok}}
				<ul>
					{{BEGIN produktGrupy}}
					<li>
						( {{$produktKodGrupa}} ) {{$produktNazwaGrupa}} - {{$produktStan}} - {{$produktIloscGrupa}}
					</li>
					{{END}}
				</ul>
				{{END}}
			</td>
			<td>
				{{$produktStan}}
			</td>
			<td class='pozycje_produkt' >{{$produktIlosc}}</td>
		</tr>
		{{END}}
		<tr>
			<td></td>
			<td></td>
			<td></td>
			<td class='suma_etykieta' >{{$iloscLacznieEtykieta}}</td>
			<td class='suma_wartosc' >{{$iloscLacznie}}</td>			
		</tr>
	</table>
	{{BEGIN podpis}}
	<table width='100%' style="margin-top:80px;">
		<tr>
			<td></td>
			<td style='text-align: right;'>
				<img width="400px;" src="data:{{$podpisImg}}" />
			</td>
		</tr>
	</table>
	{{END}}
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
	</body>
</html>

{{END}}
{{BEGIN przyjmijTowar}}
<script type="text/javascript">
	
	$(document).on('click', '.zapiszIlosc' , function(e){ dodajTowar($(this));	});
	$(document).on('submit', 'form#products_form' , function(e){ 
		zapiszNowyProdukt($(this)); 
		return false;	});
	
	$(document).ready(function () {
		$('#dodajProdukt').on('click', function(){
			//zaladujDodajProduktForm();
			location.href = '{{$urlDodajProdukt}}';
			return false;
		});
	});
	
	function zapiszNowyProdukt(formularz)
	{
		//$('form')[2]
		//var formdata = new FormData();
		//formdata.append('zdjecie' , document.getElementById('zdjecie').files[0]);
		//console.log(document.getElementById('zdjecie').files[0]);
		$('select').select2('destroy');
		var data = formularz.serialize();
		
		ajax("{{$urlZaladujFormularzDodajProdukt}}" , potwierdzZapiszProdukt, data, 'POST', 'json' );
		return false;
	}
	
	function potwierdzZapiszProdukt(dane)
	{
		var divForm = $('#produktFormularz');
		divForm.remove();
		$('ul.wyszukiwarka-lista').append('<li id=\'produktFormularz\'>'+dane['html']+'</div>');
		return false;
	}
	
	function zaladujDodajProduktForm()
	{
		var divForm = $('#produktFormularz');
		
		if(divForm.length && divForm.is(':visible'))
		{
			divForm.remove();
		}
		else
		{
			ajax("{{$urlZaladujFormularzDodajProdukt}}" , formDodajProdukt, { }, 'POST', 'json' );
		}
		
		return false;
	}
	
	function formDodajProdukt(dane)
	{
		$('ul.wyszukiwarka-lista').append('<li id=\'produktFormularz\'>'+dane['html']+'</div>');
		return false;
	}
	
	
</script>
<div class="tabbable inline">
	{{$zakladki}}
	<div class="tab-content no-overflow" >
			<div id="panel_tab2" class="tab-pane active">
				{{$wyszukiwarka}}
			</div>
	</div>
</div>
{{END}}

