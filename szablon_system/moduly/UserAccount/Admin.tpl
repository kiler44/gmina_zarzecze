{{BEGIN menu}}
<div class="span11">
	<a href="{{ escape($link_zmien_dane) }}" class="btn"><i class="icon-pencil"></i> {{$etykieta_link_zmien_dane}}</a>
	<a href="{{ escape($link_zmien_haslo) }}" class="btn"><i class="icon-lock"></i> {{$etykieta_link_zmien_haslo}}</a>
	<a href="{{ escape($link_zmien_email) }}" class="btn"><i class="icon-envelope"></i> {{$etykieta_link_zmien_email}}</a>
	{{BEGIN zewnetrzny_link}}<a href="{{$url}}" class="btn">{{$etykieta}}</a>{{END}}
</div>
{{END}}

{{BEGIN zaloguj}}
<h3>{{$tytul_modulu}}</h3>
<div class="formularz_logowania">
{{$formularz}}
	<div class="a_clear">
		<a href="{{ escape($link_przypomnij_haslo) }}" class="button"><span>{{$etykieta_link_przypomnij_haslo}}</span></a>
	</div>
</div>
{{END}}

{{BEGIN przypomnij}}
<div class="formularz_logowania">
{{$formularz}}
</div>
{{END}}

{{BEGIN edytuj}}
{{$formularz}}
{{END}}

{{BEGIN zmienHaslo}}
<h3>{{$tytul_modulu}}</h3>
{{$formularz}}
{{END}}

{{BEGIN zmienEmail}}
{{$formularz}}
{{END}}

{{BEGIN podsumowanie}}
<div class="span6" style="margin-left:0px;">
	{{$wiadomosci}}

	{{$wiadomosciKontakt}}

	{{$wizytowki}}
</div>
<div class="span6">
	{{$linki}}

	{{$wizytowkiOpublikowane}}

	{{$ogloszenia}}
</div>
{{END}}
