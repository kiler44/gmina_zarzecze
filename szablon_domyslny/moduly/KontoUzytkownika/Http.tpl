{{BEGIN glowna}}
<a class="buttonSet buttonRed" style="float: right;" href="{{$link_wyloguj}}">{{$etykieta_link_wyloguj}}</a>
<div class="clearfix"></div>
<p>&nbsp;</p>
<div>
	{{BEGIN link_podglad}}
		<span class="btn mid" style="float: left;"><a href="{{$link_podglad}}" rel="ext">{{$etykieta_link_podglad}}</a></span>
		<script type="text/javascript">
			$(document).ready(function(){
				$("[rel^='ext']").colorbox({
					width: "95%",
					height: "95%",
					iframe: true,
					rel: "nofollow"
				});
			});
		</script>
	{{END}}
</div>
<div id="menuPracownik" class="ikony_duze menuIcons">
	{{BEGIN admin}}
		<a href="{{$link_admin}}" id="admin" class="ikona">
			<div class="icon panel"></div>
			<span>{{$etykieta_admin}}</span>
		</a>
	{{END}}
</div>
{{END}}


{{BEGIN menu}}
<div class="zakladki">
<ul>
	<li class="zakladka_tytul {{ $active_zmien_dane }}"><a href="{{$link_zmien_dane}}"><span>{{$etykieta_link_zmien_dane}}</span></a></li>
	<li class="zakladka_tytul {{ $active_zmien_haslo }}"><a href="{{$link_zmien_haslo}}"><span>{{$etykieta_link_zmien_haslo}}</span></a></li>
	<li class="zakladka_tytul {{ $active_zmien_email }}"><a href="{{$link_zmien_email}}"><span>{{$etykieta_link_zmien_email}}</span></a></li>
	<li class="zakladka_tytul {{ $active_usun_konto }}"><a href="{{$link_usun_konto}}"><span>{{$etykieta_link_usun_konto}}</span></a></li>
	{{BEGIN zewnetrzny_link}}<li class="zakladka_tytul"><a href="{{$url}}" class="button"><span>{{$etykieta}}</span></a></li>{{END}}
	{{BEGIN narazie_wywalilem_tenlink}}<li class="zakladka_tytul przycisk wyloguj"><a href="{{$link_wyloguj}}"><span>{{$etykieta_link_wyloguj}}</span></a></li>{{END}}
</ul>
</div>
<script type="text/javascript">
$(document).ready(function(){
	domyslneWartosci = new Array();
	$(".tresc form input[type=text]:not('#email'), .tresc form input[type=hidden], .tresc form select").each(function(){
		domyslneWartosci[$(this).attr("name")] = $(this).val();
	});
	$(".tresc form input[type=checkbox],.tresc form input[type=radio]:checked").each(function(){

		var wartosc = ($(this).is(":checked")) ? $(this).val() : 0;
		domyslneWartosci[$(this).attr("name")] = wartosc;
	});


	$(".zakladka_tytul a").click(function(){
		var formularzZmieniony = false;
		$(".tresc form input[type=text]:not('#email'), .tresc form input[type=hidden], .tresc form select").each(function(){
			if(domyslneWartosci[$(this).attr("name")] != $(this).val())
			{
				formularzZmieniony = true;
				return false;
			}
		});
		$(".tresc form input[type=checkbox],.tresc form input[type=radio]:checked").each(function(){
			var akt_wartosc = ($(this).is(":checked")) ? $(this).val() : 0;
			if (akt_wartosc != domyslneWartosci[$(this).attr("name")])
			{
				formularzZmieniony = true;
				return false;
			}
		});

		if (formularzZmieniony)
		{
			return confirm("{{$formularz_nie_zapisany}}");
		}
	});
});
</script>
{{END}}

{{BEGIN zaloguj}}


            {{$formularz}}
			{{BEGIN linkPrzypomnienie}}
				<a class="fR" title="{{escape($etykieta_przypomnij_haslo)}}" href="{{$link_przypomnienie}}">{{$etykieta_przypomnij_haslo}}</a>
			{{END}}


{{END}}

{{BEGIN przypomnij}}
{{$formularz}}
{{END}}

{{BEGIN emailAktywacyjny}}
{{$formularz}}
{{END}}

{{BEGIN rejestracja}}
{{$formularz}}
{{END}}

{{BEGIN zmienHaslo}}
{{$formularz}}
{{END}}

{{BEGIN zmienEmail}}
{{$formularz}}
{{END}}

{{BEGIN edytuj}}
<script type="text/javascript">
$(document).ready(function(){
	$(document).ready(function(){

		$("h3").click(function(){
			$(this).next().slideToggle();
		});
	});
});
</script>
<div class="accordion">
	<h3 class="dropdown-header" id="dane"><a class="btn-style2 small padding4"><span></span></a>{{$etykieta_dane_kontaktowe}}</h3>
	<div class="opened-content">
		{{$formularz_dane}}
	</div>

	<h3 class="dropdown-header" id="haslo"><a class="btn-style2 small padding4"><span></span></a>{{$etykieta_zmien_haslo}}</h3>
	<div class="opened-content">
		{{$formularz_haslo}}
	</div>

		<h3 class="dropdown-header" id="email"><a class="btn-style2 small padding4"><span></span></a>{{$etykieta_zmien_email}}</h3>
	<div class="opened-content">
		{{$formularz_email}}
	</div>
	<script type="text/javascript">
		var kotwica = window.location.href.split('#');
		if (kotwica[1])
		{
			$('#' + kotwica[1]).click();
		}
	</script>
</div>

{{END}}

{{BEGIN usun_konto}}
<div>
	{{$formularz}}
</div>
{{END}}

{{BEGIN spacer}}<div id="_spacer_" style="height: 20px; border-bottom: 1px solid #cfdfef; margin: 5px 0 10px 0">&nbsp;</div>{{END}}
