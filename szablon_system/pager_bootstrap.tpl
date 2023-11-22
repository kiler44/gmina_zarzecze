{{BEGIN html}}
<div class="pager_boks select2">
	{{$wyborStrony}}
	<div class="input-prepend input-append pager_boks_skocz_zakres pull-right">
	<div class="btn btn-inverse">{{$pager_ilosc}} <strong>{{$pager_wartosc_ilosc}}</strong></div>
	{{$skoczDo}}
	{{$wyborZakresu}}
	</div>
</div>
{{END}}

{{BEGIN linkiWyborStrony}}
<div class="stronicowanie">{{$pager_wybierz_strone}}
	<div class="btn-group pull-right">
	{{BEGIN skokPoprzednia}} <a href="{{$link}}" class="strzalka prev btn btn-small">{{$pager_wstecz}}</a> {{END}}
	{{BEGIN pierwszaStrona}} <a href="{{$link}}" class="first prev btn btn-small">{{$nrStrony}}</a> {{END}}
	{{BEGIN skokWstecz}} <a href="{{$link}}" class="{{if($pierwszy,'first')}} skok prev btn btn-small">{{$nrStrony}}</a> .. {{END}}
	{{BEGIN poprzedzajacaStrona}} <a href="{{$link}}" class="{{if($pierwszy,'first')}} prev btn btn-small">{{$nrStrony}}</a> {{END}}
	{{BEGIN biezacaStrona}} <strong class="{{if($pierwszy,'first')}} {{if($ostatni,'last')}} selected btn btn-small btn-inverse">{{$nrStrony}}</strong> {{END}}
	{{BEGIN nastepujacaStrona}} <a href="{{$link}}" class="{{if($ostatni,'last')}} next btn btn-small">{{$nrStrony}}</a> {{END}}
	{{BEGIN skokNaprzod}} .. <a href="{{$link}}" class="{{if($ostatni,'last')}} skok next btn btn-small">{{$nrStrony}}</a> {{END}}
	{{BEGIN ostatniaStrona}} <a href="{{$link}}" class="last next btn btn-small">{{$nrStrony}}</a> {{END}}
	{{BEGIN skokNastepna}} <a href="{{$link}}" class="strzalka next btn btn-small">{{$pager_przod}}</a> {{END}}
	</div></div>
{{END}}

{{BEGIN selectWyborStrony}}
	{{$pager_wybierz_przedzial}}
	{{BEGIN poprzednia}} <a href="{{$link}}" class="strzalka prev">{{$pager_wstecz}}</a>{{END}}
	<select name="wybor_strony" onchange=" if (this.options[selectedIndex].value == '1') window.location = '{{$urlPierwsza}}'.replace(/{NA_STRONIE}/, {{$pager_wartosc_naStronie}}).replace(/{NR_STRONY}/, this.options[selectedIndex].value); else  window.location = '{{$url}}'.replace(/{NA_STRONIE}/, {{$pager_wartosc_naStronie}}).replace(/{NR_STRONY}/, this.options[selectedIndex].value);">
		{{BEGIN opcje}}<option value="{{$nrStrony}}" {{if($wybrany,"selected=\"selected\"")}}>{{$poczatek}} - {{$koniec}}</option>{{END}}
	</select>
	{{BEGIN nastepna}} <a href="{{$link}}" class="strzalka next">{{$pager_przod}}</a>{{END}}
{{END}}

{{BEGIN linkiWyborZakresu}}
	{{$pager_wybierz_zakres}}
	{{BEGIN opcje}}<a href="{{$link}}" class="{{if($wybrany,'selected')}}">{{$zakres}}</a> {{END}}
	{{BEGIN wszystko}}<a href="{{$link}}" class="{{if($wybrany,'selected')}}">{{$pager_pokaz_wszystko}}</a> {{END}}
{{END}}

{{BEGIN selectWyborZakresu}}
	  <span class="add-on ">{{$pager_wybierz_zakres}}</span>
		<select class="input-small select_wybor_zakresu" name="naStronie" onchange="window.location = '{{$url}}'.replace(/{NR_STRONY}/, {{$pager_wartosc_nrStrony}}).replace(/{NA_STRONIE}/, this.options[selectedIndex].value);">
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
	  <span class="add-on ">{{$pager_skocz_do}}</span>
	  <input type="text" name="strona" class="input-mini skocz_do" size="1" value="{{$pager_wartosc_skocz_do}}"/>
</form>
{{END}}