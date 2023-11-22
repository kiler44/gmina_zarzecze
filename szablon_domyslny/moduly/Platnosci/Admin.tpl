

{{BEGIN index}}
<div class="a_clear">
<a href="{{$link_czysc}}" class="btn" onclick="return confirm('{{$etykieta_czysc_pytanie}}')" title="{{$etykieta_czysc}}"><span>{{$etykieta_czysc}}</span></a>
</div>
{{$grid}}
{{END}}



{{BEGIN platnosc}}
<table border="0" cellspacing="0" class="input" width="50%">
<tr>
	<td><strong>{{$etykieta_data_dodania}}</strong></td>
	<td>{{$data_dodania}}</td>
</tr>
<tr>
	<td><strong>{{$etykieta_opis}}</strong></td>
	<td>{{$opis}}</td>
</tr>
<tr>
	<td><strong>{{$etykieta_kwota}}</strong></td>
	<td>{{$kwota}}</td>
</tr>
<tr>
	<td><strong>{{$etykieta_obiekt}}</strong></td>
	<td><a href="{{$url}}">{{$obiekt}}</a></td>
</tr>
<tr>
	<td><strong>{{$etykieta_typ_platnosci}}</strong></td>
	<td>{{$typ_platnosci}}</td>
</tr>
<tr>
	<td><strong>{{$etykieta_kwota}}</strong></td>
	<td>{{$kwota}}</td>
</tr>
<tr>
	<td><strong>{{$etykieta_status}}</strong></td>
	<td>{{$status}}</td>
</tr>
<tr>
	<td colspan="2"><div class="a_clear">
	<a href="{{$link_sprawdz_status}}" class="btn" title="{{$etykieta_sprawdz_status}}"><span>{{$etykieta_sprawdz_status}}</span></a>
	<a href="{{$link_potwierdz}}" class="btn" onclick="return confirm('{{$etykieta_potwierdz_pytanie}}')" title="{{$etykieta_potwierdz}}"><span>{{$etykieta_potwierdz}}</span></a>
	<a href="{{$link_anuluj}}" class="btn" onclick="return confirm('{{$etykieta_anuluj_pytanie}}')" title="{{$etykieta_anuluj}}"><span>{{$etykieta_anuluj}}</span></a>
	<a href="{{$link_usun}}" class="btn" onclick="return confirm('{{$etykieta_usun_pytanie}}')" title="{{$etykieta_usun}}"><span>{{$etykieta_usun}}</span></a>
	</div></td>
</tr>
</table>
<h3>{{$etykieta_historia}}</h3>
{{BEGIN historia}}
<table border="0" cellspacing="0" class="grid"  width="100%">
<tr class="naglowek">
	<th>{{$etykieta_data_dodania}}</th>
	<th>{{$etykieta_operacja}}</th>
	<th>{{$etykieta_dane_wyslane}}</th>
	<th>{{$etykieta_dane_odebrane}}</th>
</tr>
{{BEGIN wiersz}}
<tr class="wiersz">
	<td>{{$data_dodania}}</td>
	<td>{{$operacja}}</td>
	<td>{{$dane_wyslane}}</td>
	<td>{{$dane_odebrane}}</td>
</tr>
{{END}}
</table>
{{END}}

<br/>
<br/>
{{END}}