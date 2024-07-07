{{BEGIN fe_kontener_pusty}}
{{$tresc}}
{{END}}


{{BEGIN fe_kontener_div}}
<div{{BEGIN klasa}} class="{{$nazwa}}"{{END}}>
	{{$tresc}}
</div>
{{END}}


{{BEGIN fe_kontener_oferty_strona_glowna}}
<div class="title">
	<h3>{{$tytul_modulu}}</h3><a class="more" title="{{escape($link_etykieta)}}" href="{{$link_url}}">{{$link_etykieta}}<var><br/></var></a>
</div>
{{$tresc}}
{{END}}


{{BEGIN fe_kontener_zwin_rozwin}}
<script type="text/javascript">
<!--
$(document).ready(function(){
	$('.rollButton3.id{{$id}}').click(function () {
		x = $(this).parents('.title').next();

		if( ! $(this).hasClass('rev'))
		{
			x.slideDown(200);
			$(this).addClass('rev').find('span').html('{$e_zwin}');
		}
		else
		{
			x.slideUp(200);
			$(this).removeClass('rev').find('span').html('{$e_rozwin}');
		}
	});
});
-->
</script>
<div class="title">
	<span class="catListButtonTop rollButton3 id{{$id}} rev">
		<span>{$e_zwin}</span><var><br/></var></span><h3>{{$tytul_modulu}}</h3>
</div>
<div class="catListShell mbDimB">
{{$tresc}}
</div>
{{END}}


{{BEGIN fe_kontener_blue_box}}
<div class="boxTop">
	<h2 class="wA fontReplaceShadowWhite"><var><br /></var>{{$tytul_modulu}}</h2>
</div>
<div class="boxContent sizeA{{BEGIN klasa}} {{$nazwa}}{{END}}">
	<div class="bgTop"></div>
	<div class="content">
		{{$tresc}}
	</div>
<div class="bgBottom"></div>
</div>
{{END}}

{{BEGIN fe_kontener_blue_box_szeroki}}
<div class="boxTop">
	<h2 class="wC fontReplaceShadowWhite"><var><br /></var>{{$tytul_modulu}}</h2>
</div>
<div class="boxContent sizeA{{BEGIN klasa}} {{$nazwa}}{{END}}">
	<div class="bgTop"></div>
	<div class="content">
		{{$tresc}}
	</div>
<div class="bgBottom"></div>
</div>
{{END}}

{{BEGIN fe_kontener_blue_box_szeroki_link}}
<div class="boxTop">
	<h2 class="wC fontReplaceShadowWhite"><var><br /></var>{{$tytul_modulu}}<a title="{{escape($nazwa_firma)}}" href="{{$link_url}}"><span>{{$nazwa_firma}}</span></a></h2>
</div>
<div class="boxContent sizeA{{BEGIN klasa}} {{$nazwa}}{{END}}">
	<div class="bgTop"></div>
	<div class="content">
		{{$tresc}}
	</div>
<div class="bgBottom"></div>
</div>
{{END}}



{{BEGIN fe_kontener_blue_box_mapa_kategorii}}
<div class="boxTop" id="{{$id_bloku}}">
	<h2 class="wA fontReplaceShadowWhite"><var><br /></var>{{$tytul_modulu}}</h2>
</div>
<div class="boxContent sizeA">
	<div class="bgTop"></div>
	<div class="content">
		{{$tresc}}
		<a class="kontenerLink" href="{{escape($link_url)}}" title="{{escape($link_etykieta)}}">{{$link_etykieta}}</a>
	</div>
<div class="bgBottom">
</div>
</div>
{{END}}

{{BEGIN fe_kontener_blue_box_polecane}}
<div class="boxShell relative">
	<div class="boxTop">
		<h2 class="wC fontReplaceShadowWhite"><var><br /></var>{{$tytul_modulu}}</h2>
		{$kontener_polecane_popup}
	</div>
	<div class="boxContent sizeA">
		<div class="bgTop"></div>
		<div class="content">
			<div class="carouselShell hR relative">
				{{$tresc}}
			</div>
		</div>
	<div class="bgBottom"></div>
	</div>
</div>
{{END}}


{{BEGIN fe_kontener_supertraders}}
<div class="boxSimpleShell">
	<div class="bgTop"></div>
	<div class="content">
		<h2 class="subtitle2 fontReplace">{{$tytul_modulu}}</h2>
		{{$tresc}}
	</div>
</div>
{{END}}

{{BEGIN be_kontener_konto_uzytkownika}}
<h2>{{$tytul_modulu}}</h2>
{{$tresc}}
{{END}}

{{BEGIN be_kontener_konto_serwisowe}}
<h1 class="tytul_modulu">{{$tytul_modulu}}</h1>
{{$tresc}}
{{END}}

{{BEGIN be_kontener_wizytowka_zarzadzanie}}
<h2>{{$tytul_modulu}}
	{{IF $wyswietlajPodglad}}
		<span class="links"><a class="find" onclick="$.fn.colorbox({href:'{{escape($url_podgladu_strony)}}', width:'97%', height:'97%', iframe:true })">{{$etykieta_podglad_strony}}</a></span>
	{{END}}
</h2>
{{$tresc}}
<!--{{$wyswietlajPodglad}}{{$url_podgladu_strony}}{{$etykieta_podglad_strony}}-->
{{END}}

{{BEGIN fe_kontener_supertraders_bez_naglowka}}
<div class="boxSimpleShell">
	<div class="bgTop"></div>
	<div class="content">
		{{$tresc}}
	</div>
</div>
{{END}}


{{BEGIN fe_kontener_supertraders_formularz}}
<div class="boxPureShell">
	<span class="fR fs11">* pola wymagane</span>
		<h1 class="subtitle2 simple fontReplace">{{$tytul_modulu}}</h1>
		{{$tresc}}
</div>
{{END}}

{{BEGIN fe_kontener_supertraders_bialy}}
<div class="boxPureShell">
	<h2 class="subtitle2 simple mbDimA fontReplace">{{$tytul_modulu}}</h2>
	{{$tresc}}
</div>
{{END}}


{{BEGIN fe_kontener_pomocy}}
<div id="tabsContentShell" class="editorArea">
	<h3 class="subtitle3">{{$tytul_modulu}}</h3>
	{{$tresc}}
</div>
{{END}}


{{BEGIN fe_kontener_menu_h2}}
	<h2 class="subtitle2 simple mbDimA fontReplace">{{$tytul_modulu}}</h2>
	{{$tresc}}
{{END}}



{{BEGIN kontener_podstawowy}}
<div class="modul">
<h1>{{$tytul_modulu}}</h1>
	{{BEGIN linki}}
	<div class="linki">
		{{BEGIN link}}
			{{$tresc_linka}}
		{{END}}
	</div>
	{{END}}
<div class="tresc">{{$tresc}}</div>
</div>
{{END}}

{{BEGIN kontener_podstawowy_tresci}}
<div class="modul podstawowy">
<h1>{{$tytul_modulu}}</h1>
	{{BEGIN linki}}
	<div class="linki">
		{{BEGIN link}}
			{{$tresc_linka}}
		{{END}}
	</div>
	{{END}}
<div class="tresc">{{$tresc}}</div>
</div>
{{END}}

{{BEGIN kontener_galeria}}
<div class="modul">
<h1>{{$tytul_galerii}}</h1>
<div class="tresc">{{$tresc}}</div>
</div>
{{END}}

{{BEGIN kontener_pusty}}
{{$tresc}}
{{END}}


{{BEGIN kontener_tresc}}
<div class="modul">
	<div class="tresc">{{$tresc}}</div>
</div>
{{END}}

{{BEGIN kontener_sekcja}}
<section class="gz-section icobox-1-section">
	<div class="container" id="tiles-container">
		{{$tresc}}
	</div>
</section>
{{END}}

{{BEGIN kontener_sekcja_wideo}}
<section class="gz-video-gallery-section gz-section karuzela-2">
	<div class="container">
		<div class="row">
			<div class="col-12 gz-title text-lg-start text-center">
				<h2>{{$tytul_modulu}}</h2>
			</div>
			<div class="col-12">
				{{$tresc}}
			</div>
		</div>
	</div>
	<div class="modal fade" id="videoModal" tabindex="-1" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered gz-modal-lg">
			<div class="modal-content">
				<div class="modal-body">
					<video controls id="videoPlayer"></video>
				</div>
			</div>
		</div>
	</div>
</section>
{{END}}

{{BEGIN kontener_sekcja_kurier}}
<section class="gz-kurier gz-section karuzela-6">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div id="carousel-gz-2" class="carousel">
					<div class="carousel-inner">
						{{$tresc}}
					</div>
					<button class="carousel-control-prev" type="button" data-bs-target="#carousel-gz-2" data-bs-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden"></span>
					</button>
					<button class="carousel-control-next" type="button" data-bs-target="#carousel-gz-2" data-bs-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden"></span>
					</button>
				</div>
			</div>
		</div>
	</div>
</section>
{{END}}

{{BEGIN kontener_sekcja_banery}}
<section class="gz-banery-01 karuzela-4">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div id="carousel-gz-3" class="carousel">
					<div class="carousel-inner">
						{{$tresc}}
					</div>
					<button class="carousel-control-prev" type="button" data-bs-target="#carousel-gz-3" data-bs-slide="prev">
						<span class="carousel-control-prev-icon" aria-hidden="true"></span>
						<span class="visually-hidden"></span>
					</button>
					<button class="carousel-control-next" type="button" data-bs-target="#carousel-gz-3" data-bs-slide="next">
						<span class="carousel-control-next-icon" aria-hidden="true"></span>
						<span class="visually-hidden"></span>
					</button>
				</div>
			</div>
		</div>
	</div>
</section>
{{END}}