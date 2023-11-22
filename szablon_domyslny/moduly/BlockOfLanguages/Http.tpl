{{BEGIN komunikat}}
<div class="komunikat_{{typ}}">
	<span class="komunikat_tresc">{{$tresc}}</span>
</div>
{{END}}



{{BEGIN index}}
{{BEGIN wybrany}}
<div>
	{{$etykieta_wybrany_jezyk}} <img src="/_system/admin/flagi/{{$wybrany_jezyk}}.gif" height="11" width="16" border="0" alt="{{escape($nazwa_wybrany_jezyk)}}"/>
</div>
{{END}}
{{BEGIN zmien}}
<div>
	{{$etykieta_zmien_jezyk}}{{BEGIN link}}&nbsp;<a href="{{$url}}" title="{{escape($etykieta)}}"><img src="/_system/admin/flagi/{{$kod}}.gif" height="11" width="16" border="0" alt="{{escape($etykieta)}}"/></a>{{END}}
</div>
{{END}}
{{END}}