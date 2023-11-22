{{BEGIN index}}
	{{BEGIN raportGetApartamenty}}
	<div class="col-xs-12 col-sm-6">
		<div class="widget-box">
			<div class="widget-title"><span class="icon"><i class="icon-file"></i></span><h5>{{$raport_get_apartamenty_naglowek}}</h5></div>
			<div class="widget-content nopadding">
				<ul class="recent-posts">
					{{BEGIN wiersz}}
					<li>
						
						<div class="article-post">
						<span class="user-info"> {{$dateStart}} - {{$dateStop}} </span>
						<p>
						<a href="{{$linkPodglad}}">{{$orderName}}</a>
						</p>
						<a href="{{$linkPodglad}}" class="btn btn-primary btn-xs">{{$przyciskPodglad}}</a> 
					</div>
					</li>
					{{END wiersz}}
					<li class="viewall">
					<a title="" class="tip-top" href="{{$linkWiecej}}" data-original-title="View all posts"> {{$wiecej}} </a>
					</li>
				</ul>
			</div>
		</div>
	</div>

	{{END raportGetApartamenty}}
	{{BEGIN alertBrakNumeru}}
	<script type="text/javascript" >
		$(document).ready(function(){
			$('#oknoModalne .modal-body').html('<div class="alert alert-danger"><strong>Alert!</strong><br/> {{$komunikat}} </div>');
			$('#oknoModalne').modal('show');
		});
		
		$('#profilowy').live('click', function(){
			zapiszNumer(0);
		});
		$('#tymczasowy').live('click', function(){
			zapiszNumer(1);
		});
		
		function zapiszNumer(tymczasowy)
		{
			var telefon = $('#telefon').val();
			if(telefon === '' )
			{
				$('#telefon').next('span').remove();
				$('#telefon').after('<span><strong> {{$telefonWymagany}} </strong></span>');
				return false;
			}
			$.ajax({
				url: "{{$linkUstawNumerTelefonu}}",
				type: 'POST',
				data: 'telefon='+telefon+'&tymczasowy='+tymczasowy,
				dataType: 'json',
				async: true,
				success: function(dane) {
					if(dane.kod == 3)
					{
						$('#telefon').next('span').remove();
						$('#telefon').after('<span><strong> {{$telefonWymagany}} </strong></span>');
					}
					else if(dane.kod == 2)
					{
						alert('{{$bladZapisuTelefonu}}');
					}
					else
					{
						$('.close').click();
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					alert(xhr.status);
					alert(thrownError);
				}
			})
			return false;
		}
	</script>
	{{END alertBrakNumeru}}
	
	{{BEGIN zamowienie}}
	<div class="widget-box logged-order"> 
		<div class="widget-title">
			<span class="icon"><i class="icon-tag"></i></span>
			<h5>{{$zamowienie_tytul_etykieta}} {{$zamowienie_tytul}}</h5>
		</div>
		<div class="widget-content">
			{{$start_pracy_etykieta}} {{$start_pracy}}
			<a class="btn btn btn-info tip-top" href="{{$url_podglad_zamowienia}}" style="margin: 10px 0 10px 10px" data-original-title="{{$link_zaloguj_etykieta}}" >
			<i class="icon-search"></i>
				{{$url_podglad_zamowienia_etykieta}}
			</a>
		</div>
		
	</div>
	{{END}}
	
	
	{{BEGIN sekcja-menu}}
	<ul class="menu">
		{{BEGIN element}}<li><a href="{{link}}" class="btn btn-lg {{$class}} btn-block">{{$etykieta}}</a></li>{{END}}
	</ul>
	{{END}}
	{{BEGIN zakoncz_prace}}
		<a class="btn btn-danger btn-block btn-lg tip-top" href="{{$url_zakoncz_prace}}" data-original-title="{{$link_zaloguj_etykieta}}" >
			<i class="icon-signin"></i>
			{{$url_zakoncz_prace_etykieta}}
		</a>
	{{END}}
	{{BEGIN sekcja-team}}
	<div class="widget-box sekcja-team">
		<div class="widget-title">
			<span class="icon">
				<i class="icon icon-truck"></i>
			</span>
			<h5>{{$nazwa_teamu}}</h5>
		</div>
		<div class="team-naglowek">
			{{BEGIN user}}
				<img title="{{$title}}" alt="{{$title}}" class="tip-bottom {{$klasa}}" src="{{$foto}}">
			{{END}}
			<div class="clear"></div>
		</div>
	</div>
	{{END}}
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




