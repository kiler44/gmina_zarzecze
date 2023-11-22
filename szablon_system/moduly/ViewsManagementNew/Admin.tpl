{{BEGIN index}}
<div class="widget-box">
<div class="przyciskiFunkcyjne">
	<a href="{{$link_dodaj}}" class="btn" title="{{$etykieta_link_dodaj}}"><i class="icon-plus"></i> {{$etykieta_link_dodaj}}</a>
	<a href="{{$link_bloki}}" class="btn" title="{{$etykieta_link_bloki}}"><i class="icon-th"></i> {{$etykieta_link_bloki}}</a>
	<a href="{{$link_budowanie_ukladu}}" class="btn" title="{{$etykieta_budowanie_ukladu}}"><i class="icon-fighter-jet"></i> {{$etykieta_budowanie_ukladu}}</a>
	{{BEGIN przyciski}}
	<a href="{{$link_pobierz_konfiguracje}}" class="btn" title="{{$etykieta_link_pobierz_konfiguracje}}"><i class="icon-download-alt"></i> {{$etykieta_link_pobierz_konfiguracje}}</a>
	<a href="{{$link_wczytaj_konfiguracje}}" class="btn" title="{{$etykieta_link_wczytaj_konfiguracje}}"><i class="icon-share"></i> {{$etykieta_link_wczytaj_konfiguracje}}</a>
	{{END}}
</div>
{{$grid}}
</div>
{{END}}

{{BEGIN dodaj}}
{{$form}}
{{END}}

{{BEGIN edytuj}}
{{$form}}
{{END}}

{{BEGIN bloki}}
<div class="widget-box">
<div class="przyciskiFunkcyjne">
	<a href="{{$link_dodaj}}" class="btn" title="{{$etykieta_link_dodaj}}"><i class="icon-plus"></i> {{$etykieta_link_dodaj}}</a>
</div>
{{$grid}}
</div>
{{END}}

{{BEGIN dodajBlok}}
{{$form}}
{{END}}

{{BEGIN edytujBlok}}
{{$form}}
{{END}}


{{BEGIN struktura_kontener}}
<table border="0" cellspacing="10" cellpadding="0" width="99%">
	<tr>
		<td class="przypisaneBloki" valign="top">
			{{$przypisane_bloki}}
		</td>
		<td class="nieprzypisaneBloki" width="300" style="min-height: 500px;">
			<ul>
				{{$nieprzypisane_bloki}}
			</ul>
			<div class="clear"></div>
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td>
			<div class="a_clear">
				<a href="{{$link_dodaj}}" class="btn pull-right" title="{{$etykieta_link_dodaj}}"><i class="icon-plus"></i> {{$etykieta_link_dodaj}}</a>
			</div>
		</td>
	</tr>


</table>
<script type="text/javascript">
	<!--
	var regiony = new Array();
	{{$mozliwe_bloki}}

		function zaznaczDostepne(nazwaModulu)
{
	$(".region ul").each(function()
	{
		if(in_array('!wszystko', regiony[$(this).attr("id")]))
		{
				if(in_array(nazwaModulu, regiony[$(this).attr("id")])) $(this).addClass("dostepnyRegion");
			else $(this).addClass("locked");
		}
		else
		{
			if(!in_array(nazwaModulu, regiony[$(this).attr("id")])) $(this).addClass("dostepnyRegion");
		else $(this).addClass("locked");
	}
});
}

function pokazDostepne(nazwaModulu)
{
	$(".region ul").each(function()
	{
		if(in_array('!wszystko', regiony[$(this).attr("id")]))
		{
			if(in_array(nazwaModulu, regiony[$(this).attr("id")])) $(this).addClass("dostepnyR");
			else $(this).addClass("lck");
		}
		else
		{
			if(!in_array(nazwaModulu, regiony[$(this).attr("id")])) $(this).addClass("dostepnyR");
			else $(this).addClass("lck");
		}
	});
}

function czyscWidok()
{
	$(".region ul").each(function()
	{
		$(this).removeClass("dostepnyR").removeClass("lck");
	});
}

function serializujDane()
{
	var serializacja = "";
	$(".region ul").each(function()
	{
		var region = $(this).attr("id");
		serializacja += region + ",";
		$("#" + region +" li").each(function()
		{
			var blok = $(this).attr("id");
			serializacja += blok + ",";
		});
	});
	$("#struktura").val(serializacja);
}

function aktualizujWidok()
{
	var url = '{{$link_aktualizuj}}'.replace(/{STRUKTURA}/, $("#struktura").val());
	$.ajax({
		url: url,
		success: function(data) { }
	});
}

function podgladWidoku(url)
{
	if (url != '')
	{
		openedWindow = window.open(url, '', 'menubar=0,width=1000,height=600,toolbar=0,resizable=1,scrollbars=1');
	}
}

$(document).ready(function(){
	$(".blokPrzenaszalny").mouseover(function(){
		var nazwaModulu = $(this).attr("rel");
		pokazDostepne(nazwaModulu);
	});

	$(".blokPrzenaszalny").mouseout(function(){
		var nazwaModulu = $(this).attr("rel");
		czyscWidok();
	});
	
	$(".blokPrzenaszalny").mousedown(function(){
		var nazwaModulu = $(this).attr("rel");
		zaznaczDostepne(nazwaModulu);
	
		$(".nieprzypisaneBloki ul").sortable({
			connectWith: ['.dostepnyRegion, .nieprzypisaneBloki ul'],
			tolerance: 'pointer'
		});
	
		$(".dostepnyRegion").sortable({
			connectWith: ['.dostepnyRegion,  .nieprzypisaneBloki ul'],
			tolerance: 'pointer',
			update: function(event, ui) {
				serializujDane();
				aktualizujWidok();
			}
		});
	});
	
	$(".blokPrzenaszalny").mouseup(function(){
		$(".region ul").each(function(){
			$(this).removeClass("dostepnyRegion").removeClass("locked");
		});
	
		czyscWidok();
	});
	
	$("#zapisz").click(function(){
		serializujDane();
	});
});
-->
</script>
{{END}}

{{BEGIN struktura_blok}}
<li id="blok_{{$id_bloku}}" class="blokPrzenaszalny" rel="{{$kod_modulu}}">
	<i class="icon-fullscreen"></i>
	<span>{{$nazwa_bloku}} {{if($nazwa_modulu, '<em>\(')}}{{$nazwa_modulu}}{{if($nazwa_modulu, ')</em>')}}</a></span>
	{{BEGIN przyciski}}
	<div class="przyciski btn-group">
		<a class="btn btn-primary btn-mini" href="{{$link_tresc}}" title="{{$etykieta_link_tresc}}"><i class="icon-pencil"></i></a>
		<a class="btn btn-warning btn-mini" href="{{$link_edytuj}}" title="{{$etykieta_link_edytuj}}"><i class="icon-wrench"></i></a>
		<a class="btn btn-danger btn-small btn-mini" href="{{$link_usun}}" title="{{$etykieta_link_usun}}"><i class="icon-remove"></i></a>
	</div>
	{{END}}
</li>
{{END}}

{{BEGIN bledy}}

<br />
<h3>Niezaimportowane bloki:</h3>
(Proszę przypisać brakujące moduły do projektu i zaimportować konfiguracje jeszcze raz.)
{{BEGIN blad_brak_modulu}}
<p>Brak modułu: "{{$kod_modulu}}" - niezaimportowano bloku: "{{$nazwa}}".</p>
{{END}}

{{END}}

{{BEGIN uklad}}
<style typ="text/css">

.additional_element {
    margin: 5px;
    padding: 5px;
    color: white;
    cursor: pointer;
}

.grid_elements {
    width: 300px;
    float: left;
}
.grid_elements table {
    border-collapse: separate;
    width: 200px;
    height: 200px;
}
.actions_block {
    padding: 9px;
    float: right
}

.grid_elements table td {
    background-color: #CFCFCF;
    border-radius: 1px;
    -webkit-border-radius: 1px;
    -moz-border-radius: 1px;
}

.grid_elements table td.hover {
    background-color: #999;
}

.grid_elements table td:hover {
    cursor: pointer;
}

.gridster_blok .gridster_blok_nazwa {
    cursor: pointer;
}

.gridster_blok
{
	list-style: none;
}

.ui-resizable-resizing {
    z-index: 9999999 !important;
}

.layout_name_edit {
    background-color: inherit;
    background: url( '../media/images/icons/edit_input.gif' );
    background-repeat: no-repeat;
    background-position: 0 center;
    padding: 0px;
    margin: 0px;
    padding-left: 14px;
    border: none;
    font-size: 16px;
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    color: white;
    outline: none;
    width: 90%;
    font-style: italic;
    cursor: text !important;
}
.gridster_siatka .usun_blok {
    float: right;
    color: black;
    font-size: 12px;
    font-weight: bold;
    padding: 2px 5px;
    font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
    cursor: pointer;
    margin: 3px 0px 4px 4px;
}
.gridster_siatka .gridster_blok .info {
    color: white;
    font-size: 16px;
    font-family: Helvetica;
    padding: 10px;
}
/*! gridster.js - v0.1.0 - 2012-10-07
* http://gridster.net/
* Copyright (c) 2012 ducksboard; Licensed MIT */

.gridster_siatka {
	position:relative !important;
	width: 840px;
	min-height: 300px;
	float: left;
	border: 1px solid black;
}

.gridster_siatka > * {
	margin: 0 auto;
	-webkit-transition: height .4s;
	-moz-transition: height .4s;
	-o-transition: height .4s;
	-ms-transition: height .4s;
	transition: height .4s;
}

.gridster_siatka ul {
	list-style-type: none;
	min-height: 660px;
}
.gridster_siatka .gs_w{
	z-index: 2;
	position: absolute;
}

.ready .gs_w:not(.preview-holder) {
	-webkit-transition: opacity .3s, left .3s, top .3s;
	-moz-transition: opacity .3s, left .3s, top .3s;
	-o-transition: opacity .3s, left .3s, top .3s;
	transition: opacity .3s, left .3s, top .3s;
}

.ready .gs_w:not(.preview-holder) {
	-webkit-transition: opacity .3s, left .3s, top .3s, width .3s, height .3s;
	-moz-transition: opacity .3s, left .3s, top .3s, width .3s, height .3s;
	-o-transition: opacity .3s, left .3s, top .3s, width .3s, height .3s;
	transition: opacity .3s, left .3s, top .3s, width .3s, height .3s;
}

.gridster_siatka .preview-holder {
	z-index: 1;
	position: absolute;
	background-color: inherit;
	border: none;
	opacity: 0.3;
}

.gridster_siatka .player-revert {
	z-index: 10!important;
	-webkit-transition: left .3s, top .3s!important;
	-moz-transition: left .3s, top .3s!important;
	-o-transition: left .3s, top .3s!important;
	transition:  left .3s, top .3s!important;
}

.gridster_siatka .dragging {
	z-index: 10!important;
	-webkit-transition: all 0s !important;
	-moz-transition: all 0s !important;
	-o-transition: all 0s !important;
	transition: all 0s !important;
}

.gridster-lewa{
	width: 80%;
	display: block;
	float: left;
}

.gridster-prawa{
	width: 20%;
	display: block;
	float: left;
}

.gridster_blok_nazwa_link
{
	color: white;
}
</style>
<link rel="stylesheet" type="text/css" href="http://code.jquery.com/ui/1.10.2/themes/smoothness/jquery-ui.css" />
<script src="/_system/js/jquery.gridster.with-extras.min.js"></script>
<script src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
<div class="navbar" id="navbarMenu">
	<div class="navbar-inner">
		<b><div style="float: left; display: block; margin-top: 10px;"><i class="icon-edit"></i>&nbsp;</div><a class="brand tip-bottom" href="#" id="nazwa_ukladu" style="color: burlywood;" data-original-title="Nazwa widoku. Kliknij, aby zmienić nazwę widoku.">{{$nazwa_ukladu_strony}}</a></b>
		<ul class="nav">
			<li><a href="{{$a_wstecz_link}}" data-original-title="Wstecz" class="tip-bottom"><i class="icon-arrow-left"></i> Wróć</a></li>
			<li><a id="a_zapisz_bloki" href="{{$a_zapisz_link}}" data-original-title="Zapisuje utworzony widok" class="tip-bottom"><i class="icon-save"></i> Zapisz</a></li>
			<li><a href="javascript:void(0);" class="a_dodaj_blok tip-bottom" data-original-title="Dodaje kolejny blok do widoku"><i class="icon-plus"></i> Dodaj blok</a></li>
			<li>
				<ul class="nav nav-tabs">
					<li class="dropdown tip-bottom" data-original-title="Pozwala przypisać widok do użytkownika. Użytkownika należy wybrać z listy poprzez kliknięcie.">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="icon-user"></i>&nbsp;<span id="user-choice" data="">Użytkownik</span><b class="caret"></b>
						</a>
						<ul class="dropdown-menu" id="dropdown-menu-user">
						<!-- links -->
						<li><a>Nie przypisuj</a></li>
						{{$lista_wyboru_uzytkownikow}}
						</ul>
					</li>
				</ul>
			</li>
			
			<li>
				<ul class="nav nav-tabs">
					<li class="dropdown tip-bottom" data-original-title="Pozwala przypisać widok do grupy. Grupę należy wybrać z listy poprzez kliknięcie.">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="icon-group"></i>&nbsp;<span id="group-choice" data="">Grupa</span><b class="caret"></b>
						</a>
						<ul class="dropdown-menu" id="dropdown-menu-group">
						<!-- links -->
						<li><a>Nie przypisuj</a></li>
						{{$lista_wyboru_grup}}
						</ul>
					</li>
				</ul>
			</li>
			
			<li>
				<ul class="nav nav-tabs">
					<li class="dropdown tip-bottom" data-original-title="Pozwala przypisać widok do akcji. Akcję nalezy wybrać z listy poprzez kliknięcie.">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="icon-cog"></i>&nbsp;<span id="action-choice" data="">Akcja</span><b class="caret"></b>
						</a>
						<ul class="dropdown-menu" id="dropdown-menu-action">
						<!-- links -->
						<li><a>Nie przypisuj</a></li>
						{{$lista_wyboru_akcji}}
						</ul>
					</li>
				</ul>
			</li>
			
			<li>
				<ul class="nav nav-tabs">
					<li class="dropdown tip-bottom" data-original-title="Pozwala wczytać istniejący widok do edycji. Aby wczytać istniejący widok należy wybrać go z listy poprzez kliknięcie.">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-th-large"></i>&nbsp;Wybierz widok do edycji<b class="caret"></b></a>
						<ul class="dropdown-menu">
						<!-- links -->
						{{$lista_istniejacych_widokow}}
						</ul>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</div>
 
<div class="gridster-lewa">
	<div class="gridster_siatka" id="gridster_siatka">
	<ul>
	
	</ul>
	</div>
</div>

<div class="gridster-prawa">

	<div class="accordion" id="akordeon">
		
		<div class="accordion-group">
		<div class="accordion-heading">
			<a class="accordion-toggle" data-toggle="collapse" data-parent="#akordeon" href="#zawartosc1">Gdzie ja jestem?</a>
		</div>
		<div id="zawartosc1" class="accordion-body collapse in">
			<div class="accordion-inner">
Znajdujesz się w widoku, który pozwala tworzyć nowe widoki za pomocą myszki w sposób wizualny bez kodowania w html i css. W tym widoku dostępne jest menu (belka) oraz obszar roboczy (poniżej menu).
			</div>
		</div>
		</div>
		
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#akordeon" href="#zawartosc2">Dodawanie nowego bloku</a>
			</div>
			<div id="zawartosc2" class="accordion-body collapse">
				<div class="accordion-inner">
Aby dodać nowy element do widoku należy na belce menu kliknąć <b>Dodaj blok</b>, po czym zostanie on umieszczony jako ostatni w obszarze roboczym. Przez blok należy tutaj rozumieć element graficzny odwzorowujący swoim położeniem i wielkością fragment szkieletu strony zakodowanej w html/css.
				</div>
			</div>
		</div>
		
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#akordeon" href="#zawartosc3">Usuwanie istniejącego bloku</a>
			</div>
			<div id="zawartosc3" class="accordion-body collapse">
				<div class="accordion-inner">
W celu usunięcia istniejącego bloku w obszarze roboczym po lewej należy w obrębie tego bloku kliknąć czerwony przycisk, po czym zostanie wyświetlone okienko dialogowe przyjmujące potwierdzenie usunięcia. Można także zaniechać zamiaru usunięcia przez kliknięcieprzycisku Anuluj. 
				</div>
			</div>
		</div>
		
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#akordeon" href="#zawartosc4">Rozmiar bloku</a>
			</div>
			<div id="zawartosc4" class="accordion-body collapse">
				<div class="accordion-inner">
Aby zmienić wysokość lub szerokość wybranego elementu/bloku należy najechać myszką w pobliżu jego prawej lub dolnej krawędzi od wewnątrz i przytrzymując wciśnięty lewy klawisz myszki przesuwać ją w odpowiednim kierunku, co spowoduje zmianę rozmiaru takiego bloku. Kazdy element ma swoje ograniczenia co do minimalnej i maksymalnej wielkości, których przekroczyć nie może. Wynika to z formatowania TwitterBootstrap.
				</div>
			</div>
		</div>
		
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#akordeon" href="#zawartosc5">Położenie bloku</a>
			</div>
			<div id="zawartosc5" class="accordion-body collapse">
				<div class="accordion-inner">
					Zmiana położenia elementu jest możliwa poprzez <b>przeciągnij i upuść</b>. Element nigdy nie opuści oszaru tworzenia widoku. Zmiana położenia jednego z elementów, może pociągnąć za sobą zminę położenia inych elementów.
				</div>
			</div>
		</div>
		
			<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#akordeon" href="#zawartosc6">Nazwa bloku</a>
			</div>
			<div id="zawartosc6" class="accordion-body collapse">
				<div class="accordion-inner">
Nazwa bloku jest to biały tekst widoczny w obrębie danego bloku, który jest jego etykietą. Aby zmienić nazwę bloku należy kliknąć nią, po czym pojawi się okienko edycji, w którym można dokonać stosownych zmian.				
				</div>
			</div>
		</div>
		
			<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#akordeon" href="#zawartosc7">Nazwa widoku</a>
			</div>
			<div id="zawartosc7" class="accordion-body collapse">
				<div class="accordion-inner">
Nazwa widoku jest widoczna na belce menu, w kolorze jasno-pomarańczowym. Jej kliknięcie pozwala na dokonanie zmiany nazwy widoku w stosownym okienku dialogowym.				
				</div>
			</div>
		</div>
		
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#akordeon" href="#zawartosc8">Uprawnienia do widoku</a>
			</div>
			<div id="zawartosc8" class="accordion-body collapse">
				<div class="accordion-inner">
Uprawnienia to nic innego jak przypisanie widoku do użytkownika,grupy lub akcji. Aby przypisać widok do użytkownika należy z menu wybrać <b>Użytkownik</b> i na liście kliknąć odpowiedniego użytkownika. Aby przypisać widok do grupy należy z menu wyrać <b>Grupa</b> i kliknąć odpowiednią pozycję na liście. Natomiast aby przypisać widok do akcji należy z menu wybrać <b>Akcja</b> i na liście kliknąć odpowiednią pozycję.				
				</div>
			</div>
		</div>
		
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#akordeon" href="#zawartosc9">Zapis widoku</a>
			</div>
			<div id="zawartosc9" class="accordion-body collapse">
				<div class="accordion-inner">
					Aby zapisać widok należy kliknąć na belce menu <b>Zapisz</b>.			
				</div>
			</div>
		</div>
		
		<div class="accordion-group">
			<div class="accordion-heading">
				<a class="accordion-toggle" data-toggle="collapse" data-parent="#akordeon" href="#zawartosc10">Edycja istniejącego widoku</a>
			</div>
			<div id="zawartosc10" class="accordion-body collapse">
				<div class="accordion-inner">
W celu edycji istniejącego widoku należy na belce menu z <b>Wybierz widok do edycji</b>, po czym wybrać interesujący widok przez kliknięcie.			
				</div>
			</div>
		</div>
		
	</div>
</div>
<script type="text/javascript">
var gridster;

$(document).ready(function()
{
	gridster = new function()
	{		
			this.maxKolumn = {{$maxKolumn}};
			this.maxWierszy = {{$maxWierszy}};
			this.maxWymiarBloku =
			{
				max_szerokosc: {{$max_szerokosc}},
				max_wysokosc: {{$max_wysokosc}}
			};
			this.podstawowaSzerokosc = {{$podstawowaSzerokosc}};
			this.podstawowaWysokosc = {{$podstawowaWysokosc}};
			this.marginesKolumn = {{$marginesKolumn}};
			this.marginesWierszy = {{$marginesWierszy}};
			this.uchwyt = null;

			this.init = function(element)
			{
				this.uchwyt = $('.'+element).gridster(
				{
					widget_margins: [this.marginesKolumn, this.marginesWierszy],
					widget_base_dimensions: [this.podstawowaSzerokosc,this.podstawowaWysokosc],
					autogenerate_stylesheet: {{$autogenerate_stylesheet}},
					avoid_overlapped_widgets: {{$avoid_overlapped_widgets}},
					min_cols: {{$min_cols}},
					min_rows: {{$min_rows}},
					max_size_x: {{$max_size_x}},
					max_size_y: {{$max_size_y}},
					extra_cols: {{$extra_cols}},
					extra_rows: {{$extra_rows}},
					serialize_params: function(element, widzet)
					{
						return {
							kolumna: widzet.col,
							wiersz: widzet.row,
							szerokosc: widzet.size_x,
							wysokosc: widzet.size_y,
							id: $(element).attr('data-id'),
							nazwa: $(element).find('.gridster_blok_nazwa').text()
						};
					},
					min_rows: this.maxWymiarBloku.max_wysokosc
				}).data('gridster');
			
				$('.'+element).css("height",null);
				this.wlaczEdycjaWielkosciBloku('gridster_blok','#' + element);
			};
			
			this.pobierzSzerokosc = function(element)
			{
				return parseInt(element.getAttribute('data-sizex'));
			};
			this.pobierzWysokosc = function(element)
			{
				return parseInt(element.getAttribute('data-sizey'));
			};
			this.pobierzWiersz = function(element)
			{
				return parseInt(element.getAttribute('data-row'));
			};
			this.pobierzKolumna = function(element)
			{
				return parseInt(element.getAttribute('data-col'));
			};
			
			this.ustawRozmiar = function(element, szerokosc, wysokosc)
			{
				element.css("top","");
				this.uchwyt.resize_widget($(element),szerokosc, wysokosc);
			}

			this.pobierzId = function(element)
			{
				return element.getAttribute('data-id');
			};

			this.blokuj = function()
			{
				this.uchwyt.disable();
			};
			this.odblokuj = function()
			{
				this.uchwyt.enable();
			};

			this.zmienRozmiar = function(element)
			{
				var elementOpakowany = jQuery(element);
				var elementSzerokosc = elementOpakowany.width();
				var elementWysokosc = elementOpakowany.height();
				var szerokoscElementu = elementOpakowany.width() - this.podstawowaSzerokosc;
				var wysokoscElementu = elementOpakowany.height() - this.podstawowaWysokosc;
	
				for (var gridsterElementSzerokosc = 1; szerokoscElementu > 0; szerokoscElementu -= (this.podstawowaSzerokosc + (this.marginesKolumn * 2)))
				{
					gridsterElementSzerokosc++;
					if(gridsterElementSzerokosc > this.maxKolumn)
					{
						gridsterElementSzerokosc = this.maxKolumn;
					}
				}
			
				for (var gridsterElementWysokosc = 1; wysokoscElementu > 0; wysokoscElementu -= (this.podstawowaWysokosc + (this.marginesWierszy * 2)))
				{
					gridsterElementWysokosc++;
					if(gridsterElementWysokosc > this.maxWierszy)
					{
						gridsterElementWysokosc = this.maxWierszy;
					}
				}
		
				this.ustawRozmiar(elementOpakowany, gridsterElementSzerokosc, gridsterElementWysokosc);
			};
			
			this.usun = function(co)
			{
				var id = this.pobierzId($(co).parent().parent());
				if(id != undefined)
				this.uchwyt.remove_widget($('.gridster_siatka li[data-id="' + id +'"]'));
			};
			
			this.zapisz = function()
			{
				var ukladPoSerializacji = this.uchwyt.serialize();
				var bloki = JSON.stringify(ukladPoSerializacji);
				var uzytkownik = parseInt($("#user-choice").attr("data"));
				if(isNaN(uzytkownik) || uzytkownik == '') uzytkownik = -1;
				var grupa = parseInt($("#group-choice").attr("data"));
				if(isNaN(grupa) || grupa == '') grupa = -1;
				var akcja = $("#action-choice").attr("data");
				var uklad = $("#nazwa_ukladu").text();
				
				$.ajax({
					type: "POST",
					url: "{{$a_zapisz_link}}",
					data: 
						{
							'bloki' : bloki,
							'podstawowaSzerokosc' : gridster.podstawowaSzerokosc,
							'podstawowaWysokosc' : gridster.podstawowaWysokosc,
							'nazwaUkladu' : uklad,
							'uzytkownik' : uzytkownik,
							'grupa' : grupa,
							'jakaAkcja' : akcja
						},
					dataType: "json",
					success: function(data)
					{
						info(data.odpowiedzTekstowa);
					}
				});
				return false;
			};
			
			this.wczytajElementy = function(json)
			{
				$(".gridster_blok").each(function(i,o){
					var el = $(o);
					gridster.uchwyt.remove_widget(el);
				});
				$.each(JSON.parse(json), function(i, blok)
				{
					html = 
'<li class="gridster_blok" data-id="' + blok.id + '" data-row="' + blok.wiersz + '" data-col="' + blok.kolumna + '" data-sizex="' + blok.szerokosc + '" data-sizey="' + blok.wysokosc + '" style="background-color: #333;">'
+'<div class="usun_blok"><span class="btn btn-small btn-danger btn-small usun nowy tip-top" data-original-title="Kliknij, aby usunąć ten blok">X</span></div>'
+'<div class="info">'
+'<span class="gridster_blok_nazwa"><a class="gridster_blok_nazwa_link">' + blok.nazwa + '</a></span>'
+'</div>';
			
				var x = parseInt(blok.szerokosc);
				var y = parseInt(blok.wysokosc);
				var l = parseInt(blok.kolumna);
				var t = parseInt(blok.wiersz);

				gridster.uchwyt.add_widget(html,x, y, l, t);
				});
				
				$('.usun_blok').live('click',function()
				{
					co = this;
					pytanie('Usuwanie bloku', 'Czy usunąć blok: ' + $(this).parent().find('span a').text() + '?',function(odpowiedz){
						if(odpowiedz != false)
						{
							$(co).parent().remove();
						}
						});
				});
				
				$(".gridster_blok").resizable(
				{
					grid: [gridster.podstawowaSzerokosc + (gridster.marginesKolumn * 2), gridster.podstawowaWysokosc + (gridster.marginesWierszy * 2)],
					animate: false,
					minWidth: gridster.podstawowaSzerokosc,
					minHeight: gridster.podstawowaWysokosc,
					containment: '#gridster_siatka ul',
					autoHide: true,

					stop: function(event, ui)
					{
						gridster.zmienRozmiar(this);
					}
				});
				
				$('.ui-resizable-handle').hover(function() {
					gridster.blokuj();
				}, function() {
					gridster.odblokuj();
				});
				gridster.odblokuj();
			};
			
		
			this.wlaczEdycjaWielkosciBloku = function(klasaBloku,rodzic)
			{
				var x = this.podstawowaSzerokosc;
				var y = this.podstawowaWysokosc;
				var szerokosc = x + (this.marginesKolumn * 2);
				var wysokosc = y + (this.marginesWierszy * 2);
				$("." + klasaBloku).resizable({
					grid: [szerokosc, wysokosc],
					animate: false,
					minWidth: x,
					minHeight: y,
					containment: rodzic,
					autoHide: true,

					stop: function(event, ui)
					{
						gridster.zmienRozmiar(this);
					}
				});
				$('.ui-resizable-handle').hover(function()
				{
					gridster.blokuj();
				}, function() {
					gridster.odblokuj();
				});	
			};
			
			this.dodajNowy = function()
			{
				var x = 1;
				var y = 1;
				var l = 1;
				var elementy = $(".gridster_siatka li");
				var t = elementy.length == 0 ? 0 : 1;
				var ostatni = elementy.last();
				if(ostatni.attr("class") != undefined)
				{
					var szer = parseInt(ostatni.attr("data-sizex"));
					var kol = parseInt(ostatni.attr("data-col"));
					var pozostaloMiejsca = parseInt('{{$max_size_x}}') - szer - kol;//alert("pozostało: " + pozostaloMiejsca);
					if(pozostaloMiejsca >= 0)
					{
							l = kol+szer;
							t = t - 2;
					}
					else
					{
						l = 1;
						t = t + 1;
					}
				}
				
				elementy.each(function(indeks, obiekt)
				{
					wiersz = gridster.pobierzWiersz(obiekt);
					if(wiersz > t){t = wiersz;}
				});
			
				var html = 
'<li class="gridster_blok nowy" data-row="' + t + '" data-col="' + l + '" data-sizex="' + x + '" data-sizey="' + y + '" style="background-color: #333;">'
+'<div class="usun_blok"><span class="btn btn-small btn-danger btn-small usun">X</span></div>'
+'<div class="info">'
+'<span class="gridster_blok_nazwa"><a class="gridster_blok_nazwa_link">Nowy</a></span>'
+'</div>';
				
				
				this.uchwyt.add_widget(html,x,y,l,t);
				
				$('.usun_blok').live('click',function(){
					co = this;
					pytanie('Usuwanie bloku', 'Czy usunąć blok: ' + $(this).parent().find('span a').text() + '?',function(odpowiedz){
						if(odpowiedz != false)
						{
							$(co).parent().remove();
						}
					});
				});
				this.wlaczEdycjaWielkosciBloku('nowy','#gridster_siatka ul');
				info("Dodano nowy blok");
			};
		};

	gridster.init('gridster_siatka ul');

	{{$wczytanie_elementow_widoku}}
		
	$('.usun').live('click',function()
	{
		var nazwaBloku = $(this).parent().parent().find('span a').text();
		co = this;
		pytanie('Usuwanie bloku', 'Czy usunąć blok: ' + nazwaBloku + '?',function(odpowiedz)
		{
			if(odpowiedz)
			{
				gridster.usun(co);
			}
		});
		
	});
	
	$(".a_dodaj_blok").live("click",function()
	{
		gridster.dodajNowy();
		return false;
	});
	
	$(".gridster_blok_nazwa_link").live("click",function()
	{
		var element = $(this);
		zmienNazweBloku(element,element.text());
	});
	
	$("#nazwa_ukladu").live("click",function()
	{
		zmien("Zmiana nazwy układu", $(this).text(),function(nowaNazwa)
		{
			$("#nazwa_ukladu").text(nowaNazwa);
			return false;
		});
	});
	
	$("#a_zapisz_bloki").live("click",function()
	{
		gridster.zapisz();
		return false;
	});
	
	
	function info(tekst)
	{
		var html =
'<div class="alert fade in" id="alert_info">'+
'		<button data-dismiss="alert" class="close" type="button">×</button>'+
'		<div id="info-box">' + tekst + '</div>'+
'	</div>';
		$(html).insertAfter("#navbarMenu");
		setTimeout(function()
		{
			$("#alert_info").remove();
		}, 3000);
		};

	});

	$(".dropdown-menu").css("max-height","300px").css("overflow-y","auto").css("overflow-x","hidden").css("z-index","10001");

	$("#dropdown-menu-user li a").click(function(){
		var element = $(this);
		var tekst = element.text();
		$("#user-choice").text(tekst).attr("data", element.parent().attr("id"));
	});
	
	$("#dropdown-menu-group li a").click(function(){
		var element = $(this);
		var tekst = element.text();
		$("#group-choice").text(tekst).attr("data", element.parent().attr("id"));
	});
	
	$("#dropdown-menu-action li a").click(function(){
		var element = $(this);
		var tekst = element.text();
		$("#action-choice").text(tekst).attr("data", tekst);
	});

	function pytanie(tytul, tekst, callback)
	{
		var modal = $("#pytanie_modal");
		$("#pytanie_modal_anuluj").unbind().click(function(){
			callback(false);
			$("#pytanie_modal").modal("hide");
		});
		$("#pytanie_modal_tytul").text(tytul);
		$("#pytanie_tresc").text(tekst);
		$("#pytanie_modal_zapisz").unbind().click(function()
		{
			callback(true);
			$("#pytanie_modal").modal("hide");
		});

		modal.modal(
		{
			keyboard: false,
			backdrop: true,
			show: true
		});

		return false;	
	}

	function zmien(tytul, tekst, callback)
	{
		var modal = $("#zmiana_nazwy_modal");
		$("#modal_anuluj").unbind().click(function()
		{
			$("#zmiana_nazwy_modal").modal("hide");
		});
		$("#modal_tytul").text(tytul);
		$("#modal_input_nazwa").attr("value",tekst);
		$("#modal_zapisz").unbind().click(function()
		{
			callback($("#modal_input_nazwa").attr("value"));
			$("#zmiana_nazwy_modal").modal("hide");
		});

		modal.modal(
		{
			keyboard: false,
			backdrop: true,
			show: true
		});

		return false;	
	}

	function zmienNazweBloku(wlasciciel,tekst)
	{
		zmien('Zmiana nazwy bloku', tekst, function(nowaNazwa)
		{
			wlasciciel.text(nowaNazwa);
		});
	}
</script>

<div id="zmiana_nazwy_modal" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3><i class="icon-edit"></i><span id="modal_tytul" style="margin-left: 5px;">Zmiana nazwy bloku</span></h3>
	</div>
	<div class="modal-body">
		<input type="text" value="" id="modal_input_nazwa" style="width: 95%; margin-right: 10px;"/>
	</div>
	<div class="modal-footer">
		<a id="modal_anuluj" href="#" class="btn"><i class="icon-arrow-left"></i> Anuluj</a>
		<a id="modal_zapisz" href="#" class="btn btn-primary"><i class="icon-save"></i> Zmień</a>
	</div>
</div>

<div id="pytanie_modal" class="modal hide fade">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
		<h3><i class="icon-edit"></i><span id="pytanie_modal_tytul" style="margin-left: 5px;">Zmiana nazwy bloku</span></h3>
	</div>
	<div class="modal-body" id="pytanie_tresc"></div>
	<div class="modal-footer">
		<a id="pytanie_modal_anuluj" href="#" class="btn"><i class="icon-arrow-left"></i> Anuluj</a>
		<a id="pytanie_modal_zapisz" href="#" class="btn btn-primary"><i class="icon-save"></i> OK</a>
	</div>
</div>

{{END}}