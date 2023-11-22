{{BEGIN html}}
	{{$wyborZakresu}}
	{{$skoczDo}}
	{{$wyborStrony}}
{{END}}

{{BEGIN linkiWyborStrony}}

{{$pager_wybierz_strone}}
<ul class="pager">
	{{BEGIN skokPoprzednia}}<li class="prev"><span class="hsl" id="hsl{{$link_seo}}"><var class="icoL"><br /></var>{{$pager_wstecz}}</span></li>{{END}}
	{{BEGIN pierwszaStrona}}<li><span id="hsl{{$link_seo}}" class="hsl first prev">{{$nrStrony}}</span></li>{{END}}
	{{BEGIN skokWstecz}}<li><span id="hsl{{$link_seo}}" class="hsl {{if($pierwszy,'first')}} skok prev">{{$nrStrony}}</span> ..</li>{{END}}
	{{BEGIN poprzedzajacaStrona}}<li><span id="hsl{{$link_seo}}" class="hsl {{if($pierwszy,'first')}} prev">{{$nrStrony}}</span></li>{{END}}
	{{BEGIN biezacaStrona}}<li class="{{if($pierwszy,'first')}} {{if($ostatni,'last')}} active"><span>{{$nrStrony}}</span></li>{{END}}
	{{BEGIN nastepujacaStrona}}<li class="{{if($ostatni,'last')}}"><span id="hsl{{$link_seo}}" class="hsl {{if($ostatni,'last')}} next">{{$nrStrony}}</span></li>{{END}}
	{{BEGIN skokNaprzod}}<li class="{{if($ostatni,'last')}}">.. <span id="hsl{{$link_seo}}" class="{{if($ostatni,'last')}} skok next">{{$nrStrony}}</span></li>{{END}}
	{{BEGIN ostatniaStrona}}<li class="last"><span id="hsl{{$link_seo}}" class="hsl last next">{{$nrStrony}}</span></li>{{END}}
	{{BEGIN skokNastepna}}<li class="next"><span class="hsl" id="hsl{{$link_seo}}"><var class="icoR"><br /></var>{{$pager_przod}}</span></li>{{END}}
</ul>
{{END}}

{{BEGIN selectWyborStrony}}
	{{$pager_wybierz_przedzial}}
	{{BEGIN poprzednia}} <span id="hsl{{$link_seo}}" class="hsl strzalka prev">{{$pager_wstecz}}</span>{{END}}
	<select name="wybor_strony" onchange=" if (this.options[selectedIndex].value == '1') window.location = hexAscii('{{$urlPierwsza_seo}}', 'H2A').replace(/{NA_STRONIE}/, {{$pager_wartosc_naStronie}}).replace(/{NR_STRONY}/, this.options[selectedIndex].value); else  window.location = hexAscii('{{$url_seo}}', 'H2A').replace(/{NA_STRONIE}/, {{$pager_wartosc_naStronie}}).replace(/{NR_STRONY}/, this.options[selectedIndex].value);">
		{{BEGIN opcje}}<option value="{{$nrStrony}}" {{if($wybrany,"selected=\"selected\"")}}>{{$poczatek}} - {{$koniec}}</option>{{END}}
	</select>
	{{BEGIN nastepna}} <span id="hsl{{$link_seo}}" class="hsl strzalka next">{{$pager_przod}}</span>{{END}}
{{END}}

{{BEGIN linkiWyborZakresu}}
<div class="perPageArea">
	<span>{{$pager_wybierz_zakres}}</span>
	<ul>
		{{BEGIN opcje}}<li><span id="hsl{{$link_seo}}" class="hsl {{if($wybrany,'selected')}}">{{$zakres}}</span></li>{{END}}
		{{BEGIN wszystko}}<li><span id="hsl{{$link_seo}}" class="hsl {{if($wybrany,'selected')}}">{{$pager_pokaz_wszystko}}</span></li>{{END}}
	</ul>
</div>
{{END}}

{{BEGIN selectWyborZakresu}}
	{{$pager_wybierz_zakres}}
		<select name="naStronie" onchange="window.location = hexAscii('{{$url_seo}}', 'H2A').replace(/{NR_STRONY}/, {{$pager_wartosc_nrStrony}}).replace(/{NA_STRONIE}/, this.options[selectedIndex].value);">
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

	$(".pager_form_{{$klasaform}}").submit(function(){
		var wartosc = $(".pager_form_{{$klasaform}} .skocz_do").val();
		if ((!isNaN(wartosc) && parseInt(wartosc) == wartosc)
			&& (wartosc > 0 && wartosc <= parseInt('{{$ilosc_stron}}')))
		{
			if (wartosc == "1" && '{{$urlPierwsza_js_seo}}' != '')
			{
				document.location.href = hexAscii('{{$urlPierwsza_js_seo}}', 'H2A').replace(/{NR_STRONY}/, wartosc).replace(/{NA_STRONIE}/, {{$pager_wartosc_naStronie}});
			}
			else
			{
				document.location.href = hexAscii('{{$url_js_seo}}', 'H2A').replace(/{NR_STRONY}/, wartosc).replace(/{NA_STRONIE}/, {{$pager_wartosc_naStronie}});
			}
		}
		else
		{
			$(".pager_form_{{$klasaform}} .skocz_do").val('');
		}
		return false;
	});

	$('.submitBtn').click(function(){
		$(".pager_form_{{$klasaform}}").submit();
	});
});
-->
</script>
<form class="pager_form_{{$klasaform}} pageLink fR relative" action="#">
	<input type="text" name="strona" class="skocz_do" size="1" value="{{$pager_wartosc_skocz_do}}"/>
	<span>{{$pager_skocz_do}}</span>
	<var class="icoR submitBtn"><br /></var>
</form>
{{END}}