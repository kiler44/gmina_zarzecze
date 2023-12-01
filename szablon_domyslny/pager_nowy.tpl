


			<li class="page-item gz-item"><a class="page-link" href="#">1</a></li>

			<li class="page-item gz-item"><a class="page-link" href="#">3</a></li>



{{BEGIN html}}
	{{$wyborZakresu}}
	{{$skoczDo}}
<div class="col-12">
	<nav class="gz-pagination">
		<ul class="pagination justify-content-center">
	{{$wyborStrony}}
		</ul>
	</nav>
</div>
{{END}}

{{BEGIN linkiWyborStrony}}
	{{BEGIN skokPoprzednia}}<li class="page-item nav-arrow"><a class="page-link" href="{{escape($link)}}" tabindex="-1" aria-disabled="true">{{ $pager_wstecz }}</a></li>{{END}}
			{{BEGIN pierwszaStrona}} <li class="page-item gz-item"><a href="{{escape($link)}}" class="page-link">{{$nrStrony}}</a></li>{{END}}
			{{BEGIN skokWstecz}} <li class="page-item nav-arrow"><a href="{{escape($link)}}" class="">{{$nrStrony}}</a></li>{{END}}
			{{BEGIN poprzedzajacaStrona}} <li class="page-item gz-item"><a href="{{escape($link)}}" class="page-link">{{$nrStrony}}</a></li>{{END}}
			{{BEGIN biezacaStrona}} <li class="page-item active"><a class="page-link">{{$nrStrony}}</a></li> {{END}}
			{{BEGIN nastepujacaStrona}}<li class="page-item gz-item"><a href="{{escape($link)}}" class="page-link">{{$nrStrony}}</a></li> {{END}}
			{{BEGIN skokNaprzod}}<li class="page-item gz-item"><a href="{{escape($link)}}" class="page-link">{{$nrStrony}}</a></li> {{END}}
			{{BEGIN ostatniaStrona}}<li class="page-item gz-item"><a href="{{escape($link)}}" class="page-link">{{$nrStrony}}</a></li> {{END}}
	{{BEGIN skokNastepna}}<li class="page-item nav-arrow"><a class="page-link" href="{{escape($link)}}">{{ $pager_przod }}</a></li>{{END}}
</span></span>
{{END}}

{{BEGIN selectWyborStrony}}
	{{$pager_wybierz_przedzial}}
	{{BEGIN poprzednia}} <a href="{{escape($link)}}" class="strzalka prev">{{$pager_wstecz}}</a>{{END}}
	<select name="wybor_strony" onchange=" if (this.options[selectedIndex].value == \'1\') window.location = \'{{$urlPierwsza}}\'.replace(/{NA_STRONIE}/, {{$pager_wartosc_naStronie}}).replace(/{NR_STRONY}/, this.options[selectedIndex].value); else  window.location = \'{{$url}}\'.replace(/{NA_STRONIE}/, {{$pager_wartosc_naStronie}}).replace(/{NR_STRONY}/, this.options[selectedIndex].value);">
		{{BEGIN opcje}}<option value="{{$nrStrony}}">{{$poczatek}} - {{$koniec}}</option>{{END}}
	</select>
	{{BEGIN nastepna}} <a href="{{escape($link)}}" class="strzalka next">{{$pager_przod}}</a>{{END}}
{{END}}

{{BEGIN linkiWyborZakresu}}
	{{$pager_wybierz_zakres}}
	{{BEGIN opcje}}{{if($pierwszy, '', ' | ')}}<a href="{{escape($link)}}" class="{{$wybrany}}">{{$zakres}}</a>{{END}}
	{{BEGIN wszystko}}<a href="{{escape($link)}}" class="">{{$pager_pokaz_wszystko}}</a> {{END}}
{{END}}

{{BEGIN selectWyborZakresu}}
	{{$pager_wybierz_zakres}}
		<select name="naStronie" onchange="window.location = '{{$url}}'.replace(/{NR_STRONY}/, {{$pager_wartosc_nrStrony}}).replace(/{NA_STRONIE}/, this.options[selectedIndex].value);">
			{{BEGIN opcje}}<option value="{{$zakres_wartosc}}" {{IF $wybrany}}selected="selected"{{END}}>{{$zakres_etykieta}}</option>{{END}}
		</select>
{{END}}

{{BEGIN formSkoczDo}}
<script type="text/javascript">
<!--
$(document).ready(function(){

	$(".pager_form_{{$klasaform}} .skocz_do").keyup(function(event){
		$(".pager_form_{{$klasaform}} .skocz_do").val($(this).val());

		if (event.which == 13)
		{
			$(".pager_form_{{$klasaform}} .zatwierdzStrone").click();
		}
	});
	$(".pager_form_{{$klasaform}} .skocz_do").focus(function(){
		$(this).val('');
	});
	/*$(".pager_form_{{$klasaform}} .skocz_do").blur(function(){
		$(this).val('{{$pager_wartosc_skocz_do}}');
	});*/

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

	$(".pager_form_{{$klasaform}} .zatwierdzStrone").click(function () {
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
<form class="pager_form_{{$klasaform}} pager_form pager" action="#" style="float:right;">
	<input type="text" name="strona" class="skocz_do" size="1" value="{{$pager_wartosc_skocz_do}}"/>
	<a href="#" class="next zatwierdzStrone"></a>
</form>
{{END}}