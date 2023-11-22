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

{{BEGIN kontener_supertraders}}
<div class="modul supertraders">
<h1>{{$tytul_modulu}}</h1>
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

{{BEGIN kontener_blok_kategorii_ogloszen}}
<div class="kategorie_ogloszen">{{$tresc}}</div>
{{END}}

{{BEGIN kontener_tresc}}
<div class="modul">
	<div class="tresc">{{$tresc}}</div>
</div>
{{END}}


{{BEGIN kontener_blue_box}}
<div class="blue_box">
	<div class="gora"><b></b></div>
	<h3 class="tytul">{{$tytul_modulu}}</h3>
	<div class="tresc">
		{{$tresc}}
	</div>
	<div class="dol"><b class="l"></b><b class="r"></b></div>
</div>
{{END}}

{{BEGIN kontener_orange_box_wiecej}}
<div class="orange_box wiecej_box">
	<div class="gora"><b></b></div>
	<h3 class="tytul">{{$tytul_modulu}}</h3>
	<div class="tresc">
		{{$tresc}}
	</div>
	<div class="dol"><b class="l"></b><b class="r"></b></div>
</div>
{{END}}

{{BEGIN kontener_orange_box_notatka}}
<div class="orange_box wiecej_box">
	<div class="gora"><b></b></div>
	<h3 class="tytul">{{$tytul_modulu}}</h3>
	<div class="tresc">
		{{$tresc}}
	</div>
	<div class="zapisz">{{$etykieta_zapisz}}</div>
</div>
{{END}}

{{BEGIN kontener_orange_box}}
<div class="orange_box">
	<div class="gora"><b></b></div>
	<h3 class="tytul">{{$tytul_modulu}}</h3>
	<div class="tresc">
		{{$tresc}}
	</div>
	<div class="dol"><b class="l"></b><b class="r"></b></div>
</div>
{{END}}

{{BEGIN kontener_blue_box2}}
<div class="blue_box">
	<div class="gora"><b></b></div>
	<h3 class="tytul"><span class="kontener_tytul">{{$tytul_modulu}}</span><a class="kontener_link" href="{{escape($link_url)}}" title="{{escape($link_etykieta)}}">{{$link_etykieta}}</a><span class="clear"></span></h3>
	<div class="tresc2">
		{{$tresc}}
	</div>
	<div class="dol"><b class="l"></b><b class="r"></b></div>
</div>
{{END}}

{{BEGIN kontener_blue_box_przewijany}}
<div class="blue_box">
	<script>
		function otworzBoxPomocyBlok()
		{
			$('#boxPomocyBlokPomoc').css('display', 'block');
		}

		function zamknijBoxPomocyBlok()
		{
			$('#boxPomocyBlokPomoc').css('display', 'none');
		}
	</script>
	<div class="gora"><b></b></div>
	<h3 class="tytul"><span class="kontener_tytul">{{$tytul_modulu}}</span><a class="kontener_link" onclick="{{$link_onclick}}" title="{{escape($link_etykieta)}}">{{$link_etykieta}}</a><span class="clear"></span></h3>
	<div id="boxPomocyBlokPomoc" style="width:200px; height:150px; background-color: #eee; position:absolute; right:220px; border:1px solid #333; text-align:center; display:none;">
		<div onclick="zamknijBoxPomocyBlok();" style="width:20px; height:20px; background-color: #ccc; color:#fff; float:right;">X</div>
		<br /><br /><strong>{{$etykieta_pomoc}}</strong>
		<div style="background-color: #333; color:#fff; margin:10px;">{{$etykieta_pomoc2}}</div>
	</div>
	<div style="width:30px; background-color:#ddd; height:160px; float:left;">&laquo;</div>
	<div style="width:30px; background-color:#ddd; height:160px; float:right;">&raquo;</div>
	<div class="tresc2" style="height:160px; overflow:hidden;">
		<div style="width:2000px; height:160px; float:left;">
			{{$tresc}}
		</div>
	</div>
	<div class="dol"><b class="l"></b><b class="r"></b></div>
</div>
{{END}}


{{BEGIN kontener_orange_box2}}
<div class="orange_box">
	<div class="gora"><b></b></div>
	<h3 class="tytul"><span class="kontener_tytul">{{$tytul_modulu}}</span><a class="kontener_link" href="{{escape($link_url)}}" title="{{escape($link_etykieta)}}">{{$link_etykieta}}</a><span class="clear"></span></h3>
	<div class="tresc2">
		{{$tresc}}
	</div>
	<div class="dol"><b class="l"></b><b class="r"></b></div>
</div>
{{END}}


{{BEGIN kontener_wizytowka}}
<div class="modul wizytowka_zarzadzanie">
<h1>{{$tytul_modulu}}</h1>
<div class="tresc">{{$tresc}}</div>
</div>
{{END}}
