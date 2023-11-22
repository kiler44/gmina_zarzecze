{{BEGIN index}}
<script type="text/javascript" ></script>

{{END}}

































<!-- STARE MARCINA HISTORIE -->

{{BEGIN indexOLD}}



{{END}}

{{BEGIN danePracownik}}

<div class="row">
{{BEGIN zarobek}}
<div class="span6" style="margin-left:0px;">
	<div class="widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class="icon-time"></i>
			</span>
			<h5>{{$naglowek_przepracowane_godziny}}</h5>
		</div>
		<div class="widget-content nopadding">
			<table class="table table-bordered table-striped table-hover">
				<thead>
				<th>{{$typ_naglowek}}</th>
				<th>{{$godziny_naglowek}}</th>
				<th>{{$brutto_naglowek}}</th>
				</thead>
				<tbody>
				{{$informacje}}
				</tbody>
				<tfoot>
					<tr >
						<td class="podsumowanie">{{$suma_etykieta}}</td>
						<td class="podsumowanie">{{$suma_godzin}}</td>
						<td class="podsumowanie">{{$suma_brutto}} / {{$suma_netto}}</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	<a class="btn btn btn-info tip-top" href="{{$url_przepracowane_godziny}}" style="margin: 10px 0 10px 10px" data-original-title="{{$url_przepracowanych_godzin_etykieta}}" >
		<i class="icon-time"></i>
			{{$url_przepracowanych_godzin_etykieta}}
	</a>
</div>
{{END}}
{{BEGIN daneEkipa}}
<div class="span6" style="margin:0px 35px 0px 0px;">
	<div class="widget-box">
		<div class="widget-title">
			<span class="icon">
				<i class="icon-group"></i>
			</span>
			<h5>{{$ekipa_naglowek}}</h5>
		</div>
		<div class="widget-content">
			 {{$ekipa_etykieta}} {{$ekipa_nazwa}} 
			 <a class="btn btn btn-info tip-top" href="{{$link_zmien_ekipe}}" style="margin: 10px 0 10px 10px" data-original-title="{{$link_zmien_ekipe_etykieta}}" >
				<i class="icon-pencil"></i>
					{{$link_zmien_ekipe_etykieta}}
			</a>
			<br/>
			{{$pracownicy_ekipy_etykieta}}
			<ul>
				{{$pracownicy_html}}
			</ul>
			<button class="btn btn btn-primary tip-top" value="{{$url_dodaj_pracownika}}" onclick="location.href = this.value ;" style="margin: 10px 0 10px 10px" data-original-title="{{$link_zaloguj_etykieta}}" >
			<i class="icon-plus-sign-alt"></i>
				{{$url_dodaj_pracownika_etykieta}}
			</button>
			<button class="btn btn btn-warning tip-top" value="{{$url_usun_pracownika}}" onclick="location.href = this.value ;" style="margin: 10px 0 10px 10px" data-original-title="{{$link_zaloguj_etykieta}}" >
			<i class="icon-minus-sign-alt"></i>
				{{$url_usun_pracownika_etykieta}}
			</button>
		</div>
	</div>
	 
</div>
{{END}}

{{BEGIN info}}
<tr class="wiersz">
<td >{{$typ}}</td> 
<td>{{$iloscGodzin}}</td>
<td>{{$zarobil}}</td>
</tr>
{{END}}
{{BEGIN pracownicy}}
<li>{{$pracownik}}</li>
{{END}}
</div>
{{END}}

{{BEGIN poprawCalyTydzien}}
<script >
	$(document).ready(function(){
			$('.rozwinSzczegoly').on('click', function(){
				var content = $('.contentSzczegoly');
				if(content.is(':visible'))
				{
					content.hide();
					$(this).find('i.icon').toggleClass('icon-sort-up icon-sort-down');
					$('.wiecej-logowanie').find('i').toggleClass('icon-angle-up icon-angle-down');
					$('.wiecej-logowanie').find('span.etykieta').text("{{$etykieta_wiecej}}");
				}
				else
				{
					$(this).find('i.icon').toggleClass('icon-sort-down icon-sort-up');
					content.show();
					$('.wiecej-logowanie').find('i').toggleClass('icon-angle-down icon-angle-up');
					$('.wiecej-logowanie').find('span.etykieta').text("{{$etykieta_mniej}}");
				}
			});
			$('.rozwinSuma').on('click', function(){
				var content = $('.contentSuma');
				if(content.is(':visible'))
				{
					content.hide();
					$(this).find('i.icon').toggleClass('icon-sort-up icon-sort-down');
					$('.wiecej-logowanie').find('i').toggleClass('icon-angle-up icon-angle-down');
					$('.wiecej-logowanie').find('span.etykieta').text("{{$etykieta_wiecej}}");
				}
				else
				{
					$(this).find('i.icon').toggleClass('icon-sort-down icon-sort-up');
					content.show();
					$('.wiecej-logowanie').find('i').toggleClass('icon-angle-down icon-angle-up');
					$('.wiecej-logowanie').find('span.etykieta').text("{{$etykieta_mniej}}");
				}
			});
		});
</script>
<div class="widget-box">
	<div class="widget-content">
		<h4>{{$wybierzDateNaglowek}}</h4>
		<form name="wybierzMiesiac" class="form-inline" method="POST" action="" >
			<label>{{$rok}}</label> {{$selectRok}} <label>{{$miesiac}}</label>{{$selectMiesiac}} <input type="submit" name="wybierz" value="Select" class="btn btn-info" />
		</form>
	</div>
</div>
{{BEGIN sumaProduktow}}
<div class="widget-box">
	<div class="widget-title rozwinSuma cursorPointer">
				<span class="icon">
					<i class="icon sort icon-sort-down"></i>
				</span>
				<h5>{{$sumaGodzinNaglowek}}</h5>
				 
	</div>
	<div class="widget-content contentSuma">
		<h4>{{$sumaGodzinNaglowek}}</h4>
		<table>
			<tr>
				<th>{{$produktNazwa}}</th>
				<th>{{$godziny}}</th>
			</tr>
			{{BEGIN produkt}}
			<tr>
				<th style="text-align:left;">{{$nazwaProduktu}}</th><td style="text-align:right;">{{$sumaGodzin}}</td>
			</tr>
			{{END}}
		</table>
	</div>
</div>
{{END}}
<div class="widget-box">
	<div class="widget-title rozwinSzczegoly cursorPointer">
				<span class="icon">
					<i class="icon sort icon-sort-down"></i>
				</span>
				<h5>{{$szczegulyGodzinNaglowek}}</h5>
				 
	</div>
<div class="widget-content contentSzczegoly" style="display:none;">
		<h4>{{$szczegulyGodzinNaglowek}}</h4>
<table  class="table table-striped table-bordered">
	<thead>
		<tr>
			<td>{{$data}}</td>
			<td>{{$produktNazwa}}</td>
			<td>{{$godziny_od}}</td>
			<td>{{$godziny_do}}</td>
			<td>{{$godziny}}</td>
		</tr>
	</thead>
	<tbody>
		{{BEGIN wpisTimelist}}
			<tr class="{{$klasa}}" data-id="{{$idWpisu}}" >
				<td> {{IF $dataDzien}}  <span class="dataDzien">{{$dataDzien}}</span> {{END IF}} </td>
				<td> {{$autoLogoutInfo}} </td>
				<td>  </td>
				<td>  </td>
				<td>
					 
				</td>
				
			</tr>
			{{BEGIN wpisTimelistWypelniony}}
			<tr class="{{$klasa}}" data-id="{{$idWpisu}}" >
				<td> {{IF $dataDzien}} <span class="dataDzien">{{$dataDzien}}</span> {{END IF}} </td>
				<td>
					{{IF $pustyWiersz}} {{$produkt}} {{END IF}}
				</td>
				<td>
					{{IF $pustyWiersz}} {{$dataStart}} {{END IF}}
				</td>
				<td>
					{{IF $pustyWiersz}} {{$dataStop}} {{END IF}}
				</td>
				<td>
					{{IF $pustyWiersz}}
					<span class="minutyNowe">
						{{$czasGodziny}}
					</span>
					{{END IF}}
				</td>
			</tr>
			{{END}}
		{{END}}
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4" style="text-align: right;">
				{{$suma}}
			</td>
			<td colspan="4" id="sumaGodzin">
				{{$sumaGodzin}}
			</td>
		</tr>
	</tfoot>
</table>
		</div>
</div>
{{END poprawCalyTydzien}}



