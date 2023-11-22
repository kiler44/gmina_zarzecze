{{BEGIN index}}
<div class="widget-box">
{{$tabela_danych}}
</div>
{{BEGIN link_wstecz}}
<a href="{{$link_wstecz}}" class="btn btn btn-primary tip-top" alt="{{$link_etykieta}}" >
	{{$link_etykieta}}
</a>
{{END}}
{{END}}

{{BEGIN edycja}}
<script type="text/javascript">
		var stawkaPracownika = {
			{{$stawkaScript}}
		};
		var tabelaPodaktowaPracownika = {
			{{$tabelaPodatkowaScript}}
		};
		var teamIdPracownik = {
			{{$teamIdScript}}
		};
		
		$(document).ready(function () {
			
			$('select#idUser').live('change', function(){
				var idPracownika = $(this).val();
				$('#stawka').val(stawkaPracownika[idPracownika]);
				$('#taxTable').val(tabelaPodaktowaPracownika[idPracownika]);
				//$('select#idTeam').val(teamIdPracownik[idPracownika]);
				var team = teamIdPracownik[idPracownika];
				$('select#idTeam').select2("val", team);
			});
			
		});
		
</script>
{{$formularz}}
{{END}}

{{BEGIN seekday}}
{{$ilosc_dni_wolnych_informacja}}
{{$formularz}}
<div class="widget-box collapsible">
<div class="widget-title">
<a class="" href="#collapseThree" data-toggle="collapse">
<span class="icon">
<i class="{{$ikona}}"></i>
</span>
<h5>{{$chorobowe_naglowek}}</h5>
</a>
</div>
<div id="collapseThree" class="in collapse" style="height: auto;">
<div class="widget-content nopadding">
{{$tabela_chorobowe}}
</div>
</div>
</div>
{{END}}

{{BEGIN details}}
{{BEGIN info}}
<tr class="wiersz">
<td >{{$typ}}</td> 
<td>{{$iloscGodzin}}</td>
<td>{{$zarobil}}</td>
</tr>
{{END}}

{{$formularzWyszukaj}}
<div class="widget-box collapsible">
<div class="widget-title">
<a class="" data-toggle="collapse" href="#collapseOne">
<span class="icon">
<i class="icon-time"></i>
</span>
<h5>{{$podsumowanie_naglowek}}</h5>
</a>
</div>
<div id="collapseOne" class="in" style="height: auto;">
<div class="widget-content nopadding">
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>{{$podsumownie_etykieta_typ}}</th>
				<th>{{$podsumownie_etykieta_godziny}}</th>
				<th>{{$podsumownie_etykieta_zarobil}}</th>
			</tr>
		</thead>
		<tbody>
			{{$informacje}}
			<tr>
				<td class="podsumowanie"><strong>{{$suma_etykieta}}</strong></td>
				<td class="podsumowanie"><strong>{{$suma_godzin}}</strong></td>
				<td class="podsumowanie"><strong>{{$suma_brutto}} / {{$suma_netto}}</strong></td>
			</tr>
		</tbody>
	</table>

</div>
</div>
</div>


<div class="widget-box collapsible">
<div class="widget-title">
<a class="" href="#collapseTwo" data-toggle="collapse">
<span class="icon">
<i class="icon-file"></i>
</span>
<h5>{{$zamowienia_naglowek}}</h5>
</a>
</div>
<div id="collapseTwo" class="in collapse" style="height: auto;">
<div class="widget-content nopadding">
{{$tabela_zamowienia}}
</div>
</div>
</div>


<div class="widget-box collapsible">
<div class="widget-title">
<a class="" href="#collapseThree" data-toggle="collapse">
<span class="icon">
<i class="icon-ellipsis-horizontal"></i>
</span>
<h5>{{$chorobowe_naglowek}}</h5>
</a>
</div>
<div id="collapseThree" class="in collapse" style="height: auto;">
<div class="widget-content nopadding">
{{$tabela_chorobowe}}
</div>
</div>
</div>
{{BEGIN link_holiday}}
<button class="btn btn-primary tip-top" title="{{$holiday_link_etykieta}}" onclick="location.href = '{{$holiday_link}}';">
	<i class="icon-picture"></i>
	 {{$holiday_link_etykieta}}
</button>
{{END}}
<div class="widget-box collapsible">
<div class="widget-title">
<a class="" href="#collapseHoliday" data-toggle="collapse">
<span class="icon">
<i class="icon-picture"></i>
</span>
<h5>{{$holiday_naglowek}}</h5>
</a>
</div>
<div id="collapseHoliday" class="in collapse" style="height: auto;">
<div class="widget-content nopadding">
{{$tabela_holiday}}
</div>
</div>
</div>
{{BEGIN link_seek_day}}
<button class="btn btn-warning tip-top" title="{{$chorobowe_link_etykieta}}" onclick="location.href = '{{$chorobowe_link}}';">
	<i class="icon-ellipsis-horizontal"></i>
	 {{$chorobowe_link_etykieta}}
</button>
{{END}}
{{END}}

{{BEGIN edycjapracownikow}}
{{$formularz}}
{{END}}