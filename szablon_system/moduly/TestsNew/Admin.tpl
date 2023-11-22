{{BEGIN index}}
<div class="tresc widget-box">
<div class="przyciskiFunkcyjne">
	<a href="{{$link_phpinfo}}" class="btn" title="{{$etykieta_link_phpinfo}}"><i class="icon-info-sign"></i> {{$etykieta_link_phpinfo}}</a>
	<a href="{{$link_logi}}" class="btn" title="{{$etykieta_link_logi}}"><i class="icon-file-alt"></i> {{$etykieta_link_logi}}</a>
	<a href="{{$link_porownanie_konfiguracji}}" class="btn" title="{{$etykieta_porownanie_konfiguracji}}"><i class="icon-columns"></i> {{$etykieta_porownanie_konfiguracji}}</a>
	<a href="{{$link_email_testowy}}" class="btn" title="{{$etykieta_email_testowy}}"><span><i class="icon-envelope"></i> {{$etykieta_email_testowy}}</a>
	<a href="{{$link_sprawdz_tlumaczenia}}" class="btn" title="{{$etykieta_sprawdz_tlumaczenia}}"><i class="icon-flag"></i> {{$etykieta_sprawdz_tlumaczenia}}</a>
	<a href="{{$link_sprawdz_konfiguracje}}" class="btn" title="{{$etykieta_sprawdz_konfiguracje}}"><i class="icon-wrench"></i> {{$etykieta_sprawdz_konfiguracje}}</a>
	<a href="{{$link_aktualizuj_produkty_zakupione_villa}}" class="btn" title="{{$etykieta_aktualizuj_produkty_zakupione_villa}}"><i class="icon-wrench"></i> {{$etykieta_aktualizuj_produkty_zakupione_villa}}</a>
	<a href="{{$link_aktualizuj_produkty_zakupione_b2b}}" class="btn" title="{{$etykieta_aktualizuj_produkty_zakupione_b2b}}"><i class="icon-wrench"></i> {{$etykieta_aktualizuj_produkty_zakupione_b2b}}</a>
</div>
{{BEGIN resetDanych}}
<br /><br /><br />
<h2>{{$etykieta_reset_danych}}</h2>
<div class="a_clear">
	<a onclick="{{$onclick_resetuj_dane}}" href="{{$link_resetuj_dane}}" class="btn" title="{{$etykieta_resetuj_dane}}"><i class="icon-remove-sign"></i> {{$etykieta_resetuj_dane}}</a>
</div>
{{END}}
	{{$grid}}
</div>
{{END}}

{{BEGIN podglad}}
<table border="0" cellspacing="0" class="input" width="100%">
<tr>
	<td class="etykieta"><span class="opis">{{$etykieta_kod}}</span></td>
	<td>{{$kod}}</td>
</tr>
<tr>
	<td class="etykieta"><span class="opis">{{$etykieta_nazwa}}</span></td>
	<td>{{$nazwa}}</td>
</tr>
<tr>
	<td class="etykieta"><span class="opis">{{$etykieta_typ}}</span></td>
	<td>{{$typ}}</td>
</tr>
<tr>
	<td class="etykieta"><span class="opis">{{$etykieta_opis}}</span></td>
	<td>{{$opis}}</td>
</tr>
<tr>
	<td class="etykieta"><span class="opis">{{$etykieta_uslugi}}</span></td>
	<td>{{$uslugi}}</td>
</tr>
<tr>
	<td class="etykieta"><span class="opis">{{$etykieta_wymagane}}</span></td>
	<td><ol>{{BEGIN wymagane}}<li>{{$nazwa}} ({{$kod}})</li>{{END}}</ol></td>
</tr>
<tr>
	<td class="etykieta"><span class="opis">{{$etykieta_projekty}}</span></td>
	<td><ol>{{BEGIN projekty}}<li>{{$nazwa}} ({{$domena}})</li>{{END}}</ol></td>
</tr>
</table>
{{END}}



{{BEGIN phpinfo}}
<div class="phpinfo widget-box">
<div class="grid_border">
	<div class="border_tl">
	<div class="border_tr">
	<div class="border_br">
	<div class="border_bl">
{{$grid}}
	</div>
	</div>
	</div>
	</div>
</div>
</div>
<script type="text/javascript">
<!--
$(document).ready(function(){
	//Podświetlanie wierszy po najechaniu kursorem
	$(".phpinfo tr").hover(
		function() {$(this).addClass("highlight");},
		function() {$(this).removeClass("highlight");}
	);
});
-->
</script>
{{END}}


{{BEGIN logi}}
<div class="widget-box">
{{$grid}}
</div>
{{BEGIN plik}}
<div class="grid_border">
	<div class="border_tl">
	<div class="border_tr">
	<div class="border_br">
	<div class="border_bl">
	<pre>{{$tresc}}</pre>
	</div>
	</div>
	</div>
	</div>
</div>
{{END}}
{{END}}

{{BEGIN sprawdz}}
<div class="widget-box">
<div class="przyciskiFunkcyjne">
	<a href="{{$link_napraw}}" onclick="return confirm('{{$etykieta_potwierdz_napraw}}')" class="btn" title="{{$etykieta_napraw}}"><i class="icon-wrench"></i> {{$etykieta_napraw}}</a>
	<a href="{{$link_usun_duplikaty}}" onclick="return confirm('{{$etykieta_potwierdz_usun_duplikaty}}')" class="btn" title="{{$etykieta_usun_duplikaty}}"><i class="icon-copy"></i> {{$etykieta_usun_duplikaty}}</a>
</div>
	{{$tabela_danych}}
</div>
{{END}}

{{BEGIN powielProdukty}}
	{{BEGIN produkt}}
	<div>
		<table class="table table-striped table-bordered">
			<thead>
				<tr class="naglowek">
					<td>
						produkt
					</td>
					<td>
						id
					</td>
					<td>
						nazwa
					</td>
					<td>
						ilosc kombinacji
					</td>
				 
					<td>
						cena
					</td>
					<td>
						połączony
					</td>
				</tr>
			</thead>
			<tbody>
			<tr>
				<td>
					stary
				</td>
				<td>
					ID:{{$staryId}}
				</td>
				<td>
					{{$staryNazwa}}
				</td>
				<td>
					{{$staryKombinacjeIlosc}}
				</td>
				 
			 
				<td>
					{{$staryCena}}
				</td>
				<td>
					{{$staryPolaczonyNazwa}} ({{$stary_polaczone}})
				</td>
			</tr>
			<tr>
				<td>
					nowy
				</td>
				<td>
					ID:{{$nowyId}}
				</td>
				<td>
					{{$nowyNazwa}}
				</td>
				<td>
					{{$nowyKombinacjeIlosc}}
				</td>
				 
				
				<td>
					{{$nowyCena}}
				</td>
				<td>
					{{$nowyPolaczonyNazwa}} ({{$nowy_polaczone}})
				</td>
			</tr>
			<tr>
				<td colspan="6">
					{{$kombinacjeNazwyStary}}
				</td>
			</tr>
			<tr>
				<td colspan="6">
					{{$kombinacjeNazwyNowy}}
				</td>
			</tr>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="6"> 
					=========================================================================================================================================================================================
					</td>
				</tr>
			</tfoot>
		</table>
		
	</div>
	{{END produkt}}
{{END powielProdukty}}