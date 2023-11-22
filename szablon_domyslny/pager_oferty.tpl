{{BEGIN html}}
	{{$wyborZakresu}}
	{{$skoczDo}}
	{{$wyborStrony}}
{{END}}

{{BEGIN linkiWyborStrony}}

{{$pager_wybierz_strone}}
<ul class="pager">
	{{BEGIN skokPoprzednia}}<li class="prev"><a href="{{escape($link)}}"><var class="icoL"><br /></var>{{$pager_wstecz}}</a></li>{{END}}
	{{BEGIN pierwszaStrona}}<li><a href="{{escape($link)}}" class="first prev">{{$nrStrony}}</a></li>{{END}}
	{{BEGIN skokWstecz}}<li><a href="{{escape($link)}}" class="{{if($pierwszy,'first')}} skok prev">{{$nrStrony}} ...</a></li>{{END}}
	{{BEGIN poprzedzajacaStrona}}<li><a href="{{escape($link)}}" class="{{if($pierwszy,'first')}} prev">{{$nrStrony}}</a></li>{{END}}
	{{BEGIN biezacaStrona}}<li class="{{if($pierwszy,'first')}} {{if($ostatni,'last')}} active"><span>{{$nrStrony}}</span></li>{{END}}
	{{BEGIN nastepujacaStrona}}<li class="{{if($ostatni,'last')}}"><a href="{{escape($link)}}" class="{{if($ostatni,'last')}} next">{{$nrStrony}}</a></li>{{END}}
	{{BEGIN skokNaprzod}}<li class="{{if($ostatni,'last')}}"><a href="{{escape($link)}}" class="{{if($ostatni,'last')}} skok next">... {{$nrStrony}}</a></li>{{END}}
	{{BEGIN ostatniaStrona}}<li class="last"><a href="{{escape($link)}}" class="last next">{{$nrStrony}}</a></li>{{END}}
	{{BEGIN skokNastepna}}<li class="next"><a href="{{escape($link)}}"><var class="icoR"><br /></var>{{$pager_przod}}</a></li>{{END}}
</ul>
{{END}}

{{BEGIN selectWyborStrony}}
	{{$pager_wybierz_przedzial}}
	{{BEGIN poprzednia}} <a href="{{escape($link)}}" class="strzalka prev">{{$pager_wstecz}}</a>{{END}}
	<select name="wybor_strony" onchange=" if (this.options[selectedIndex].value == '1') window.location = '{{$urlPierwsza}}'.replace(/{NA_STRONIE}/, {{$pager_wartosc_naStronie}}).replace(/{NR_STRONY}/, this.options[selectedIndex].value); else  window.location = '{{$url}}'.replace(/{NA_STRONIE}/, {{$pager_wartosc_naStronie}}).replace(/{NR_STRONY}/, this.options[selectedIndex].value);">
		{{BEGIN opcje}}<option value="{{$nrStrony}}" {{if($wybrany,"selected=\"selected\"")}}>{{$poczatek}} - {{$koniec}}</option>{{END}}
	</select>
	{{BEGIN nastepna}} <a href="{{escape($link)}}" class="strzalka next">{{$pager_przod}}</a>{{END}}
{{END}}

{{BEGIN linkiWyborZakresu}}
<div class="perPageArea">
	<span>{{$pager_wybierz_zakres}}</span>
	<ul>
		{{BEGIN opcje}}<li><a href="{{escape($link)}}" class="{{if($wybrany,'selected')}}">{{$zakres}}</a></li>{{END}}
		{{BEGIN wszystko}}<li><a href="{{escape($link)}}" class="{{if($wybrany,'selected')}}">{{$pager_pokaz_wszystko}}</a></li>{{END}}
	</ul>
</div>
{{END}}

{{BEGIN selectWyborZakresu}}
	{{$pager_wybierz_zakres}}
		<select name="naStronie" onchange="window.location = '{{$url}}'.replace(/{NR_STRONY}/, {{$pager_wartosc_nrStrony}}).replace(/{NA_STRONIE}/, this.options[selectedIndex].value);">
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