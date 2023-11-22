{{BEGIN html}}
<div class="pager">
	<div class="gora"><b></b></div>
	<div class="tresc">
	<div class="r_left">{{$wyborZakresu}}</div>
	<div class="r_right">
	{{$wyborStrony}}
	{{$skoczDo}}
	</div>
	<div class="r_clear"></div>
	</div>
	<div class="dol"><b class="l"></b><b class="r"></b></div>
</div>
{{END}}

{{BEGIN linkiWyborStrony}}
<span class="stronicowanie">{{$pager_wybierz_strone}}<b class="b"></b><span class="stronicowanie_box">

	{{BEGIN skokPoprzednia}} <a href="{{ escape($link) }}" class="strzalka prev">{{$pager_wstecz}}</a> {{END}}
	{{BEGIN pierwszaStrona}} <a href="{{ escape($link) }}" class="first prev">{{$nrStrony}}</a> {{END}}
	{{BEGIN skokWstecz}} <a href="{{ escape($link) }}" class="{{if($pierwszy,'first')}} skok prev">{{$nrStrony}}</a> .. {{END}}
	{{BEGIN poprzedzajacaStrona}} <a href="{{ escape($link) }}" class="{{if($pierwszy,'first')}} prev">{{$nrStrony}}</a> {{END}}
	{{BEGIN biezacaStrona}} <strong class="{{if($pierwszy,'first')}} {{if($ostatni,'last')}} selected">{{$nrStrony}}</strong> {{END}}
	{{BEGIN nastepujacaStrona}} <a href="{{ escape($link) }}" class="{{if($ostatni,'last')}} next">{{$nrStrony}}</a> {{END}}
	{{BEGIN skokNaprzod}} .. <a href="{{ escape($link) }}" class="{{if($ostatni,'last')}} skok next">{{$nrStrony}}</a> {{END}}
	{{BEGIN ostatniaStrona}} <a href="{{ escape($link) }}" class="last next">{{$nrStrony}}</a> {{END}}
	{{BEGIN skokNastepna}} <a href="{{ escape($link) }}" class="strzalka next">{{$pager_przod}}</a> {{END}}
</span></span>
{{END}}

{{BEGIN selectWyborStrony}}
	{{$pager_wybierz_przedzial}}
	{{BEGIN poprzednia}} <a href="{{ escape($link) }}" class="strzalka prev">{{$pager_wstecz}}</a>{{END}}
	<select name="wybor_strony" onchange=" if (this.options[selectedIndex].value == '1') window.location = '{{$urlPierwsza}}'.replace(/{NA_STRONIE}/, {{$pager_wartosc_naStronie}}).replace(/{NR_STRONY}/, this.options[selectedIndex].value); else  window.location = '{{$url}}'.replace(/{NA_STRONIE}/, {{$pager_wartosc_naStronie}}).replace(/{NR_STRONY}/, this.options[selectedIndex].value);">
		{{BEGIN opcje}}<option value="{{$nrStrony}}" {{if($wybrany,"selected=\"selected\"")}}>{{$poczatek}} - {{$koniec}}</option>{{END}}
	</select>
	{{BEGIN nastepna}} <a href="{{ escape($link) }}" class="strzalka next">{{$pager_przod}}</a>{{END}}
{{END}}

{{BEGIN linkiWyborZakresu}}
	{{$pager_wybierz_zakres}}
	{{BEGIN opcje}}<a href="{{ escape($link) }}" class="{{if($wybrany,'selected')}}">{{$zakres}}</a> {{END}}
	{{BEGIN wszystko}}<a href="{{ escape($link) }}" class="{{if($wybrany,'selected')}}">{{$pager_pokaz_wszystko}}</a> {{END}}
{{END}}

{{BEGIN selectWyborZakresu}}
	{{$pager_wybierz_zakres}}
		<select name="naStronie" onchange="window.location = '{{ escape($url) }}'.replace(/{NR_STRONY}/, {{$pager_wartosc_nrStrony}}).replace(/{NA_STRONIE}/, this.options[selectedIndex].value);">
			{{BEGIN opcje}}<option value="{{$zakres_wartosc}}" {{if($wybrany,"selected=\"selected\"")}}>{{$zakres_etykieta}}</option>{{END}}
		</select>
{{END}}

{{BEGIN formSkoczDo}}
<script type="text/javascript">
<!--
$(document).ready(function(){

	$(".pager_form_{{$klasaform}} .skocz_do").keyup(function(){
		$(".pager_form_{{$klasaform}} .skocz_do").val($(this).val());
	});
	$(".pager_form_{{$klasaform}} .skocz_do").focus(function(){
		$(this).val('');
	});
	$(".pager_form_{{$klasaform}} .skocz_do").blur(function(){
		$(this).val('{{$pager_wartosc_skocz_do}}');
	});

	$(".pager_form_{{$klasaform}}").submit(function(){
		var wartosc = $(".pager_form_{{$klasaform}} .skocz_do").val();
		if ((!isNaN(wartosc) && parseInt(wartosc) == wartosc)
			&& (wartosc > 0 && wartosc <= parseInt('{{$ilosc_stron}}')))
		{
			if (wartosc == "1" && '{{$urlPierwsza_js}}' != '')
			{
				document.location.href = '{{$urlPierwsza_js}}'.replace(/{NR_STRONY}/, wartosc).replace(/{NA_STRONIE}/, {{$pager_wartosc_naStronie}});
			}
			else
			{
				document.location.href = '{{$url_js}}'.replace(/{NR_STRONY}/, wartosc).replace(/{NA_STRONIE}/, {{$pager_wartosc_naStronie}});
			}
		}
		else
		{
			$(".pager_form_{{$klasaform}} .skocz_do").val('');
		}
		return false;
	});
});
-->
</script>
<form class="pager_form_{{$klasaform}} pager_form" action="#">
	{{$pager_skocz_do}}<input type="text" name="strona" class="skocz_do" size="1" value="{{$pager_wartosc_skocz_do}}"/>
</form>
{{END}}