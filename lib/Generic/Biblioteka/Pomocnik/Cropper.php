<?php
namespace Generic\Biblioteka\Pomocnik;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Pomocnik;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Grafika;


/**
 * Obsluguje operacje ręcznego wycinania miniaturek obrazkow.
 *
 * @author Konrad Rudowski
 * @package biblioteki
 */

class Cropper
{

	public static function fomularzPrzycinania($zdjecieDoPrzyciecia, $linkPrzycinania, $listaMiniatur, $nazwyMiniatur, $tlumaczenia)
	{
		
		$kod = 'miniatura';

		$html = '';

		$html .= '<html><head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
	<script type="text/javascript" src="../_system/_biblioteki/jquery-1.7.2.min.js"></script>
	<script type="text/javascript" src="../_system/_biblioteki/jquery.Jcrop.min.js"></script>
	<script type="text/javascript" src="../_system/_biblioteki/funkcje_bazowe.js"></script>
	<script type="text/javascript" src="../_system/js/bootstrap.js"></script>
	<link rel="stylesheet" type="text/css" media="screen" href="../_system/css/cropper.css" />

		<style>
		/* Fixes issue here http://code.google.com/p/jcrop/issues/detail?id=1 */
		.jcrop-holder { text-align: left; }

		.jcrop-vline, .jcrop-hline
		{
			font-size: 0;
			position: absolute;
			background: white url(\'/_system/admin/Jcrop.gif\') top left repeat;
		}
		.jcrop-vline { height: 100%; width: 1px !important; }
		.jcrop-hline { width: 100%; height: 1px !important; }
		.jcrop-handle {
			font-size: 1px;
			width: 7px !important;
			height: 7px !important;
			border: 1px #eee solid;
			background-color: #333;
			*width: 9px;
			*height: 9px;
		}

		.jcrop-tracker { width: 100%; height: 100%; }

		.custom .jcrop-vline,
		.custom .jcrop-hline
		{
			background: yellow;
		}
		.custom .jcrop-handle
		{
			border-color: black;
			background-color: #C7BB00;
			-moz-border-radius: 3px;
			-webkit-border-radius: 3px;
		}


		/* cropowanie zdjec */

		.ramka, .ramka_podglad {
			float: left !important;
			background: #FFF;
		}
		.ramka {
			width: 500px;
			overflow: hidden !important;
			margin-right: 10px;
		}
		.ramka img {border: 1px solid #A9C4E1;}
		.ramka_podglad {
			width: 100px;
			height: 100px;
			border: 1px solid #A9C4E1;
			overflow: hidden !important;
		}

		.clear {margin-top:10px;}

		.select_wrap {
			padding: 6px 8px;
			display: inline-block;
			border: 1px solid #D9DFE6;
			border-radius: 6px;
			background: white;
			height: 17px;
			margin-right:10px;
		}

		select {
			border: none;
			background: none;
			color: #6E6E6E;
			font-size: 12px;
			font-family: Arial, Helvetica, sans-serif;
		}
		#miniatura_ramka_podglad_container {
			position: absolute;
			margin-left:500px;
			width:253px;
		}

		.centerText {
			text-align:center;
			font-weight: bold;
			margin-bottom:5px;
		}
	</style>
			
</head><body>
<div style="width:765px">';
$html .= '<span class="select_wrap"><select name="miniatura_ratio" id="miniatura_ratio">';
		$lista = array();
		$tabelaWymiary = '';

		//posortowanie rozmiarów od najwiekszego do najmniejszego
		asort($listaMiniatur, SORT_NUMERIC);
		$listaMiniatur = array_reverse($listaMiniatur, true);

		foreach ($listaMiniatur as $kod => $wymiary)
		{
			if ($kod == '')
			{
				continue;
			}
			$wymiary = explode('.',$wymiary);
			$tabelaWymiary .= 'tabelaWymiary[\''.$kod.'\'] = new Array(' . $wymiary[0] . ', ' . $wymiary[1] . ');' . "\n";

			if (trim($kod) != '' && is_numeric($wymiary[0]) && is_numeric($wymiary[1]))
			{
				$proporcja = number_format($wymiary[0]/$wymiary[1], 2, '.', '');
				if (array_search($proporcja, $lista) === false)
				{
					$html .= '<option value="'.$kod.'"' . ($kod == Cms::inst()->sesja->cropperOstatniaMiniaturka ? ' selected="selected"' : '') . '>'.(isset($nazwyMiniatur[$kod]) ? $nazwyMiniatur[$kod] : $kod).' ('. $wymiary[0] . 'x'. $wymiary[1] . ')</option>';
				}
				$lista[$kod] = $proporcja;
			}
		}

		$html .= '</select></span>';

	$html .= '
<input type="hidden" id="skaluj_podobne" name="skaluj_podobne" value="1" />
<div class="clear"></div>
<div id="miniatura_kontener">
<div style="float: left; margin-right: 6px;">
';
				$html .= '<input type="hidden" id="miniatura_ratio" name="miniatura_ratio" value="'.$kod.'">';


				$html .= '
</div>
<div class="clear"></div>
<div id="miniatura_ramka" class="ramka">
	<img src="'.$zdjecieDoPrzyciecia.'" alt="obraz" id="miniatura_obraz">
</div>
<div id="miniatura_ramka_podglad_container">
	<div class="centerText" id="etykietaPodglad">' . $tlumaczenia['podglad'] . '</div>
	<div id="miniatura_ramka_podglad" class="ramka_podglad">
		<img src="'.$zdjecieDoPrzyciecia.'" alt="miniatura" id="miniatura_obraz_podglad">
	</div>
	<a href="" id="miniatura_popraw" class="btn btn-primary"><span>' . $tlumaczenia['zatwierdz'] . '</span></a>
</div>
<div class="clear"></div>
</div>

<script type="text/javascript">
<!--

var time = new Date().getTime();
$(".podgladZdjecia", parent.document).height($(".podgladZdjecia", parent.document).height()+"px");

var plikPodgladu = $(".podgladZdjecia img", parent.document).attr("src").split("?");
//$(".podgladZdjecia img", parent.document).attr("src", plikPodgladu[0]+"?t="+time);
$("div#oknoModalne .modal-header h3", parent.document).html("'.$tlumaczenia['tytul'].'");
var miniatura_avc = undefined;
var miniatura_jcrop = undefined;
var tabelaRatio = new Array();
var tabelaWymiary = new Array();
var counters = new Array();
var cropowaneObszary = new Array();
var etykietaPodglad = "' . $tlumaczenia['podglad'] . '";
'.
$tabelaWymiary;

	foreach ($lista as $kod => $ratio)
	{
		$html .= '	tabelaRatio["'.$kod.'"] = '.(float)$ratio.';'."\n";
	}


	foreach (Pomocnik\Cropper::wczytajCropowanyObszar($zdjecieDoPrzyciecia) as $kod => $wartosci)
	{
		$html .= ' cropowaneObszary["' . $kod . '"] = new Array(' . intval($wartosci[0]) . ', ' . intval($wartosci[1]) . ', ' . intval($wartosci[2]) . ', ' . intval($wartosci[3]) . ');';
	}
	$html .= '

function ustawMiniature()
{
	if (cropowaneObszary[$("#miniatura_ratio").val()] == undefined)
	{
		miniatura_jcrop.setSelect(
			[ 0, 0, $("#miniatura_obraz").attr("width"), $("#miniatura_obraz").attr("height") ]
			);
	}
	else
	{
		miniatura_jcrop.setSelect(
			[ cropowaneObszary[$("#miniatura_ratio").val()][0], cropowaneObszary[$("#miniatura_ratio").val()][2], cropowaneObszary[$("#miniatura_ratio").val()][1], cropowaneObszary[$("#miniatura_ratio").val()][3] ]
			);
	}
}


var miniatura_generuj = function(coords) {
	miniatura_avc.h_podglad.width(tabelaWymiary[$("#miniatura_ratio").val()][0]);
	miniatura_avc.h_podglad.height(tabelaWymiary[$("#miniatura_ratio").val()][1]);

	var rx = miniatura_avc.h_podglad.width() / coords.w;
	var ry = miniatura_avc.h_podglad.height() / coords.h;

	miniatura_avc.h_miniatura.css({
		width: Math.round(rx * miniatura_avc.h_obraz.width()) + "px",
		height: Math.round(ry * miniatura_avc.h_obraz.height()) + "px",
		marginLeft: "-" + Math.round(rx * coords.x) + "px",
		marginTop: "-" + Math.round(ry * coords.y) + "px"
	});

	lewyMargines = (parseInt($("#miniatura_ramka_podglad_container").css("width")) - tabelaWymiary[$("#miniatura_ratio").val()][0]) / 2;
	$("#miniatura_ramka_podglad").css({marginLeft: lewyMargines + "px"});

	var x1 = parseFloat((coords.x / miniatura_avc.h_obraz.width()) * 100);
	var y1 = parseFloat((coords.y / miniatura_avc.h_obraz.height()) * 100);
	var x2 = parseFloat((coords.x2 / miniatura_avc.h_obraz.width()) * 100);
	var y2 = parseFloat((coords.y2 / miniatura_avc.h_obraz.height()) * 100);

	var link = "' . $linkPrzycinania . '";
	link = link.replace("{X1}",x1).replace("{Y1}",y1).replace("{X2}",x2).replace("{Y2}",y2).replace("{KOD}", $("#miniatura_ratio").val()).replace("{PODOBNE}", $("#skaluj_podobne").is(":checked")).replace("{COORDS}", coords.x + "|" + coords.x2 + "|" + coords.y + "|" + coords.y2);
	$("#miniatura_popraw").attr("href",link);
	$("#miniatura_popraw").css("visibility","visible");


	if ($("#miniatura_obraz_podglad").attr("width") > $("#miniatura_obraz").attr("width") || $("#miniatura_obraz_podglad").attr("height") > $("#miniatura_obraz").attr("height"))
	{
		$("#etykietaPodglad").html(etykietaPodglad + "' . $tlumaczenia['zbytMaleZaznaczenie'] . '");
	}
	else
	{
		$("#etykietaPodglad").html(etykietaPodglad);
	}

	ukryjPodobne();
}
//fix na opere
var test = new Image();
if (test.addEventListener)
{
    test.addEventListener(\'load\',function()
    {
    }, false);
}
test.setAttribute(\'src\',$("#miniatura_obraz").attr("src"));

function ukryjPodobne()
{
	counters = new Array();

	$("#miniatura_ratio option").each( function () {
		if (counters[tabelaRatio[$(this).val()]] == undefined)
		{
			counters[tabelaRatio[$(this).val()]] = 1;
		}
		else
		{
			counters[tabelaRatio[$(this).val()]]++;
		}


		if (counters[tabelaRatio[$(this).val()]] > 1)
		{
			$(this).css({display: "none"});
			$(this).attr("disabled", "true");
		}
		else
		{
			$(this).css({display: "block"});
			$(this).attr("disabled", "");
		}
		});

	var link = $("#miniatura_popraw").attr("href");

	if (counters[tabelaRatio[$("#miniatura_ratio").val()]] > 1)
	{
		link = link.replace("podobne=false", "podobne=true");
	}
	else
	{
		link = link.replace("podobne=true", "podobne=false");
	}

	$("#miniatura_popraw").attr("href", link);
}

$("#miniatura_obraz").load(function () {
	if(miniatura_avc == undefined || miniatura_jcrop == undefined) {
		miniatura_avc = new avcreator("miniatura");
		miniatura_avc.obraz = { w: miniatura_avc.h_obraz.width(), h: miniatura_avc.h_obraz.height() }
		miniatura_avc.skalujRamke();
		miniatura_avc.korekta();
		miniatura_avc.ustawRatio(tabelaRatio[$("#miniatura_ratio").val()]);
		miniatura_jcrop = $.Jcrop("#miniatura_obraz");
		miniatura_jcrop.setOptions({
			onChange: miniatura_generuj,
			onSelect: miniatura_generuj,
			aspectRatio: miniatura_avc.ratio,
		});
		ustawMiniature();


		$("#miniatura_ratio").change(function(){
			miniatura_avc.ustawRatio(tabelaRatio[$("#miniatura_ratio").val()]);
			miniatura_jcrop.setOptions({
				aspectRatio: miniatura_avc.ratio
			});
			ustawMiniature();
			miniatura_avc.korekta();

			var licznikPowtorzenRatio = 0;
			for (kod in tabelaRatio)
			{
				if (tabelaRatio[kod] == tabelaRatio[$("#miniatura_ratio").val()])
				{
					++licznikPowtorzenRatio;
				}
			}

			if (licznikPowtorzenRatio > 1)
			{
				$("#skaluj_kontener").css("display", "inline");
			}
			else
			{
				$("#skaluj_kontener").css("display", "none");
			}

			ukryjPodobne();
		});

		' . (Cms::inst()->sesja->cropperOstatniaMiniaturka != '' ? '$("#miniatura_ratio").change();' : '') . '

		ukryjPodobne();
	}
	miniatura_jcrop.enable();
	miniatura_jcrop.focus();

	ukryjPodobne();
	$("div#oknoModalne .modal-body iframe", parent.document).animate({height: $("body").height()+"px"});
	
});
$(".close").click(function(){
	$("div#oknoModalne .modal-body iframe", parent.document).height($("body").height()+"px");
	setTimeout(function(){
		$("div#oknoModalne .modal-body iframe", parent.document).animate({height: $("body").height()+"px"});
	}, 1);
});

-->
</script>
</div>
</body>
</html>
';

		return $html;

	}

	public static function przytnijObraz($obrazekDoPrzyciecia, $sciezkaZdjecia, $dozwoloneMiniatury, $kod, $skalujPodobne)
	{
		Cms::inst()->sesja->cropperOstatniaMiniaturka = $kod;

		$urlZdjecia = explode('/', $obrazekDoPrzyciecia);
		$zdjecie = $urlZdjecia[count($urlZdjecia) - 1];

		$wystapilBlad = false;

		$gora = Zadanie::pobierz('y1', 'trim', 'floatval');
		$lewa = Zadanie::pobierz('x1', 'trim', 'floatval');
		$dol = Zadanie::pobierz('y2', 'trim', 'floatval');
		$prawa = Zadanie::pobierz('x2', 'trim', 'floatval');

		$miniaturyDoZapisania = array();
		if ($skalujPodobne)
		{
			$rozmiar = $dozwoloneMiniatury[$kod];
			$rozmiarDocelowyObrazka = explode('.', $rozmiar);
			$ratio = $rozmiarDocelowyObrazka[0]/ $rozmiarDocelowyObrazka[1];

			foreach ($dozwoloneMiniatury as $kod => $rozmiar)
			{
				$rozmiarDocelowyObrazka = explode('.', $rozmiar);
				$ratioMiniatury = $rozmiarDocelowyObrazka[0]/ $rozmiarDocelowyObrazka[1];
				if ($ratio == $ratioMiniatury)
				{
					$miniaturyDoZapisania[$kod] = $rozmiar;
				}
			}
		}
		else
		{
			$miniaturyDoZapisania[$kod] = $dozwoloneMiniatury[$kod];
		}

		foreach ($miniaturyDoZapisania as $kod => $rozmiar)
		{
			if ($kod == '')
			{
				continue;
			}

			$grafika = new Grafika(new Grafika\IMagic());
			$grafika->wczytaj($sciezkaZdjecia . $zdjecie);

			$rozmiarDocelowyObrazka = explode('.', $rozmiar);

			if ($gora > 100)
			{
				$gora = 100;
			}
			if ($lewa > 100)
			{
				$lewa = 100;
			}
			if ($dol > 100)
			{
				$dol = 100;
			}
			if ($prawa > 100)
			{
				$prawa = 100;
			}

			if ( ! ($grafika->skalujUtnij($rozmiarDocelowyObrazka[0], $rozmiarDocelowyObrazka[1], $gora, $lewa, $dol, $prawa)
				&& $grafika->zapisz($sciezkaZdjecia.$kod.'-'.$zdjecie)))
			{
				$wystapilBlad = true;
			}
		}

		if ($wystapilBlad)
		{
			return false;
		}

		return true;
	}

	public static function zresetujOstaniaMiniaturka()
	{
		Cms::inst()->sesja->cropperOstatniaMiniaturka = '';
		unset(Cms::inst()->sesja->cropperOstatniaMiniaturka);
	}

	public static function zapamietajCropowanyObszar($obrazekDoPrzyciecia, $kod, $x1, $x2, $y1, $y2)
	{
		if ( ! isset(Cms::inst()->sesja->cropperCropowanyObszar))
		{
			Cms::inst()->sesja->cropperCropowanyObszar = array();
		}

		if ( ! isset(Cms::inst()->sesja->cropperCropowanyObszar[$obrazekDoPrzyciecia]))
		{
			Cms::inst()->sesja->cropperCropowanyObszar[$obrazekDoPrzyciecia] = array();
		}

		Cms::inst()->sesja->cropperCropowanyObszar[$obrazekDoPrzyciecia][$kod] = array($x1, $x2, $y1, $y2);
	}

	public static function wczytajCropowanyObszar($obrazekDoPrzyciecia)
	{
		if ( ! isset(Cms::inst()->sesja->cropperCropowanyObszar) ||  ! isset(Cms::inst()->sesja->cropperCropowanyObszar[$obrazekDoPrzyciecia]))
		{
			return array();
		}

		return Cms::inst()->sesja->cropperCropowanyObszar[$obrazekDoPrzyciecia];
	}

}
