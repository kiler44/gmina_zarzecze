{{BEGIN formularz_start}}
	{{BEGIN formularz_js}}
	<script type="text/javascript">
	<!--
	var wiersze;
	var click = false;
	$(document).ready(function(){
		$(".help-inline").parents(".control-group").addClass("input_blad").addClass("error");
	/*  Obsługa zakładek  */

		$(".zakladka_tresc").not(":first").hide();
		$(".zakladka_tytul a").click(function(){
			$('.select2').find('select').select2();
			var tab = $(this).attr("href").substring(1);
			var options = { path: '/', expires: 10 };

			$.cookie('zakladka', tab, options);
			if(!$(this).hasClass("active"))
			{
				$(".zakladka_tytul").removeClass("active");
				$(".zakladka_tytul a").removeClass("active");
				$(this).addClass("active");
				$(this).parent().addClass("active");
				var id = $(this).attr("name").substr(5);
				$(".zakladka_tresc").hide();
				$("#"+id+"_tresc").fadeIn("normal");
				$(".zakladka_tresc:visible input:not(input[type=hidden]):first").focus();
			}
		});

		$("#" + $.cookie('zakladka') + "_tab").click();

		var url = document.location.toString();
		if (url.match('#'))
		{
			var zakladka = '#' + url.split('#')[1];
			if (zakladka.match('|'))
			{
				wiersze = zakladka.split('|')[1];

				zakladka = zakladka.split('|')[0];

				if (wiersze != undefined)
				{
					wiersze = wiersze.split(',');
					for (var i = 0; i < wiersze.length; ++i)
					{
						try
						{
							if (i == 0)
							{
								setTimeout(function () {window.scroll(0, $('#' + wiersze[0]).parent().parent().offset().top)}, 100);
							}
							$('#' + wiersze[i]).parents('.input_ok').addClass('input_zaznaczony');
							$('#' + wiersze[i]).parents('.input_ok').removeClass('input_ok');

						}
						catch(e)
						{}

					}
				}
			}
			$(zakladka +"_tab").click();
		}
		
	

		$(".zakladka_tresc").each(function(){
			var blad = $(this).find(".input_blad .formularz_blad");
			if(blad.length > 0)
			{
				$("#" + $(this).attr("id").replace(/_tresc/, "_tab")).click();
				return false;
			}
		});

		/*  Obsługa regionow formularz.tpl */
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

		$("form:not([name^=no-focus]) input:not(input[type=hidden]):first").focus();
	});

	$.History.bind(function(state){
		if(!state)
		{
			state = $(".zakladka_tytul:first").find("a").attr("href").substring(1);
		}

		$("#" + state + "_tab").click();
	});

	-->
	</script>
	{{END}}
<div class="widget-box">
{{BEGIN zakladki}}
<div class="widget-title">
	<ul class="nav nav-tabs">
	{{BEGIN zakladka_label}}
		<li class="zakladka_tytul {{$zakladka_klasa}}">
			<a href="#{{$zakladka_nazwa}}" id="{{$zakladka_nazwa}}_tab" name="name_{{$zakladka_nazwa}}" class="{{$zakladka_klasa}}">{{$zakladka_etykieta}}</a>
		</li>
	{{END}}
	</ul>
	<div class="wysokosc"></div>
</div>
<div style="clear:both;"></div>
{{END}}
<div class="widget-content nopadding">
				<form enctype="{{$typ}}" id="{{$nazwa}}" name="{{$nazwa}}" method="{{$metoda}}" action="{{$akcja}}" class="form-horizontal">
					<input type="hidden" name="__{{$nazwa}}" value="wypelniony" />
					{{BEGIN token}}<input type="hidden" name="__token" value="{{$token}}" />{{END}}
					{{BEGIN identyfikatorFormularza}}<input type="hidden" name="__identyfikator" value="{{$id}}" />{{END}}
{{END}}

{{BEGIN zakladka_start}}
<!-- poczatek zakladki "{{$zakladka_nazwa}}" -->
<div class="formularz_zakladka">
	<div class="zakladka_tresc" id="{{$zakladka_nazwa}}_tresc" {{$zakladka_tresc_atrybuty}}>
{{END}}

{{BEGIN zakladka_stop}}
	</div>
</div>
<!-- koniec zakladki "{{$zakladka_nazwa}}" -->
{{END}}

{{BEGIN region_start}}
<!-- poczatek regionu "{{$region_nazwa}}" -->
<div class="formularz_region {{$region_klasa}}">
	<div class="widget-title region_tytul {{if($region_zamkniety, 'closed')}}">
		<span class="icon">
			<i class="icon-circle-arrow-{{if($region_zamkniety, 'down', 'up')}}"></i>
		</span>
		<h5>{{$region_etykieta}}</h5>
	</div>

	<div class="region_tresc {{if($region_zamkniety, 'region_zamkniety')}}" id="{{$region_nazwa}}">
{{END}}

{{BEGIN region_stop}}
	</div>
</div>
<!-- koniec regionu "{{$region_nazwa}}" -->
{{END}}

{{BEGIN input}}
<div class="control-group {{$klasa}}">
	{{BEGIN etykieta}}<label for="{{$nazwa}}" class="control-label {{$klasa}} {{if($wymagany,'wymagany')}}">{{$etykieta}}{{if($wymagany,' *')}}</label>{{END}}
	<div class="controls">
		{{$html}}
		{{BEGIN blad}}<span for="{{$nazwa}}" class="help-inline">{{$tresc}}</span>{{END}}
		{{BEGIN etykieta}}<span class="help-block">{{$opis}}</span>{{END}}
	</div>
</div>
{{END}}

{{BEGIN input_zbiorowy}}
<div class="control-group {{$klasa}}" id="zbiorowy_{{$nazwa}}">
	{{BEGIN etykieta}}<label for="{{$nazwa}}" class="control-label {{$klasa}} {{if($wymagany,'wymagany')}}">{{$etykieta}}{{if($wymagany,' *')}}</label>{{END}}
	<div class="controls">
{{BEGIN pionowy}}<table class="{{$klasa}}">
	{{BEGIN pole}}<tr><td>
			{{$html}}
			{{BEGIN blad}}<span for="{{$nazwa}}" class="help-inline">{{$tresc}}</span>{{END}}
			{{BEGIN etykieta}}<span class="help-block">{{$opis}}</span>{{END}}
	</td></tr>{{END}}
</table>{{END}}
{{BEGIN poziomy}}
	{{BEGIN pole}}
			{{BEGIN etykieta}}<label class="help-block" for="{{$nazwa}}">{{$etykieta}}</label>{{END}}
			{{$html}}
			{{BEGIN blad}}<span class="help-inline">{{$tresc}}</span>{{END}}
	{{END}}
{{END}}
</div>
</div>
{{END}}

{{BEGIN pole_html}}
{{$tresc}}
{{END}}

{{BEGIN formularz_stop}}
{{BEGIN stopka}}
<div class="formularz_stopka form-actions">
	{{$input_html}}
</div>
{{END}}
<div class="clear"></div>
</form>
</div>
</div>
{{END}}
