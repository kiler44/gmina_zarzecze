{{BEGIN pdf}}
<!DOCTYPE html>
<html lang="no">
	<head>
		<meta charset="UTF-8" />
		<style media="print">
		
		.zamowienie_naglowek{
			font-size: 12pt; padding: 8px 5px; font-weight: bold; border-top:1px solid #7d7d7d; border-bottom:1px solid #7d7d7d; border-right: 1px solid #fff;
		}
		.etykietaStopka{
			color:#20a7d4;
		}
		</style>
	</head>
	<body>
		
	</body>
</html>

{{END}}
{{BEGIN html}}
 <h1>Short raport (day by day) {{$dataStart}} - {{$dataStop}}</h1>
<table cellSpacing="0" cellPadding="7" width="100%" style="padding-bottom: 10px; ">
	{{BEGIN teamNaglowek}}
	<tr style="background-color: #7c7a7a; " >
		<td width="20%" class="zamowienie_naglowek" style="background:#3fb1d7; border-right: 0px; color: #fff; font-weight: bold;  " > {{$team}} </td>
		<td width="80%" colspan="5" class="zamowienie_naglowek" ></td>
	</tr>
	<tr>
		<td style="border-bottom: 1px solid #000;" >Date</td>
		<td style="border-bottom: 1px solid #000;" >Workers</td>
		<td style="border-bottom: 1px solid #000;" >Get time </td>
		<td style="border-bottom: 1px solid #000; text-align:center;" >Løpende timer <br/> hours</td>
		<td style="border-bottom: 1px solid #000;" >Workers time</td>
		<td style="border-bottom: 1px solid #000;" >Sum</td>
	</tr>
		{{BEGIN teamDataSuma}}
		<tr style="background:{{$bg}};" >
			<td style="color:{{$color}}" >{{$data}}</td>
			<td>{{$pracownicy}}</td>
			<td>{{$total_time}} </td>
			<td style="text-align:center;" >{{$suma_lopende_timer}}</td>
			<td>{{$godziny_pracownikow}}</td>
			<td style="color:{{$color}}" > {{$roznicaGodzin}} h ({{$iloscZamowien}} orders) </td>
		</tr>
		{{END}}
		{{BEGIN podsumowanie}}
		<tr style="background:#b3d2f9;" >
			<td style="border-top: 1px solid #000; border-bottom: 5px solid #fff; " ></td>
			<td style="border-top: 1px solid #000; border-bottom: 5px solid #fff;" ></td>
			<td style="border-top: 1px solid #000; border-bottom: 5px solid #fff;" >{{$sumaTotalTimeTydzien}} </td>
			<td style="text-align:center; border-top: 1px solid #000; border-bottom: 5px solid #fff;" >{{$sumaLopendeTimerTydzien}}</td>
			<td style="border-top: 1px solid #000; border-bottom: 5px solid #fff;" >{{$sumaCzasChlopakowTydzien}}</td>
			<td style="color:#ffffff; border-top: 1px solid #000;  border-bottom: 5px solid #fff; background:{{$bgColor}}; " > {{$roznicaGodzinTydzien}} h   </td>
		</tr>
		{{END}}
	{{END}}
</table>
<pagebreak> 
	<h1>Raport details</h1>
{{END}}



{{BEGIN szczegolowyRaport}}
<table cellSpacing="0" cellPadding="7" width="100%" style="padding-bottom: 10px; ">
	{{BEGIN naglowek}}
	<tr style="background-color: #7c7a7a; " >
		<td class="zamowienie_naglowek" style="background:#3fb1d7; border-right: 0px; color: #fff; font-weight: bold;  " > {{$team}} </td>
		<td colspan="4" class="zamowienie_naglowek" style="color: #fff;" >{{$data}}  <span style="color: {{$color}}; font-weight:bold;">({{$roznicaGodzin}})</span> {{$iloscZamowien}} orders</td>
	</tr>
	{{END}}
	<tr>
		<td width="50%" style="border-bottom: 1px solid #000;" >
			Name
		</td>
		<td style="border-bottom: 1px solid #000;" >
			Get time
		</td>
		<td style="border-bottom: 1px solid #000; text-align:center;" >Løpende timer <br/>hours</td>
		<td style="border-bottom: 1px solid #000;" >
			Worker spent
		</td>
		<td style="border-bottom: 1px solid #000;" >
			Sum
		</td>
	</tr>
	{{BEGIN villa}}
	<tr style="background:{{$bg}};" >
		<td style="color:{{$color}}" > {{$name}} </td>
		<td style="color:{{$color}}" > {{$total_time}}h </td>
		<td style="color:{{$color}}; text-align:center; " > {{$czas_z_lopende_timer}} </td>
		<td style="color:{{$color}}" >  {{$godziny_pracownikow}}  h </td>
		<td style="color:{{$color}}" >{{$roznica_minut}} h</td>
	</tr>
	{{END}}
	{{BEGIN podsumowanie}}
	<tr style="background:#b3d2f9;" >
			<td style="border-top: 1px solid #000; border-bottom: 5px solid #fff;" ></td>
			<td style="border-top: 1px solid #000; border-bottom: 5px solid #fff;" >{{$suma_total_time}} </td>
			<td style="text-align:center; border-top: 1px solid #000; border-bottom: 5px solid #fff;" >{{$suma_lopende_timer}}</td>
			<td style="border-top: 1px solid #000; border-bottom: 5px solid #fff;" >{{$godziny_pracownikow}}</td>
			<td style="color:#ffffff; border-top: 1px solid #000;  border-bottom: 5px solid #fff; background:{{$bgColor}}; " > {{$roznicaGodzin}} h   </td>
		</tr>
	{{END}}
</table>
{{END}}
						

{{BEGIN header}}
	<table cellSpacing="0" cellPadding="0" border="0" align="left" width="100%;" style="border-bottom: 2px solid #e8e8e4; padding: 0px; ">
		<tr>
			<td style="width: 50%"><img src="{{$logo}}" alt="{{$logo_alt}}" style="position: absolute; left: 0; top: 0; width: 228px" class="float: right"/></td>
			<td style="width: 50%; text-align:right;">
				<table  cellSpacing="0" cellPadding="0" border="0" align="left" >
					<tr>
						<td style="text-align:left;">
							<span style="text-transform: uppercase; font-size: 10pt;" >{{$etykieta_page_number}}{PAGENO}</span>
						</td>
					</tr>
					<tr>
						<td style="height:50px; bgcolor:#363636; text-align: center;" >
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
{{END}}
{{BEGIN footer}}
	<table border="0" align="center" width="100%" style="margin-bottom: -10px; border-top:2px solid #b0b1b1;">
		<tr>
			<td style="text-align: center; font-size: 7pt; text-transform: uppercase; padding-top: 10px;">
				<span class="etykietaStopka">{{$adres_etykieta}}</span> {{$adres_wartosc}} {{$miasto_wartosc}} {{$znaczek_rozdziel}} 
				<span class="etykietaStopka">{{$org_numer_etykieta}}</span> {{$org_numer_wartosc}} {{$znaczek_rozdziel}}
				<span class="etykietaStopka">{{$bankgiro_etykieta}}</span> {{$bankgiro_wartosc}} <br/>
				<span class="etykietaStopka">{{$telefon_etykieta}}</span> {{$telefon_wartosc}} {{$znaczek_rozdziel}} 
				<span class="etykietaStopka">{{$email_etykieta}}</span> {{$email_wartosc}} {{$znaczek_rozdziel}}
				{{$www_wartosc}}
			</td>
		</tr>
	</table>
{{END}}


{{BEGIN raport}}
	
<!DOCTYPE html>
<html lang="no">
	<head>
		<meta charset="UTF-8" />
	</head>
<body >
{{BEGIN header}}
<table border="0" width="100%" style="border-bottom: 2px solid silver">
	<tr>
		<td style="width: 50%"></td>
		<td style="width: 50%; text-align: right"><img src="{{$logo}}" alt="Bredbånd og Kabel-TV Service AS" style="position: absolute; left: 0; top: 0; width: 260px" class="float: right"/></td>
	</tr>
</table>
{{END}}
<p >
	<h1>{{$naglowek}}</h1>
</p>
{{BEGIN zamowienie}}
	
<p>

<h3>{{$tytul}} </h3>
<h4>{{$status_etykieta}} {{$status}}</h4>

	{{BEGIN klientInformacje}}
	<p>
	<table style="page-break-inside:avoid">
		<thead>
			<tr>
				<th style="text-align: left;" >{{$klient_etykieta}}</th>
			</tr>
		</thead>
		<tbody>
			{{IF $imie}}
			<tr>
				<td style="width:200px;">{{$klient_nazwa_etykieta}} </td>
				<td>
					{{$imie}} {{$drugie_imie}} {{$nazwisko}}
				</td>
			</tr>
			{{END}}
			<tr>
				<td style="width:200px;">{{$klient_firma_etykieta}}</td>
				<td>
					{{$firma}}
				</td>
			</tr>
			<tr>
				<td style="width:200px;">{{$klient_adres_etykieta}}</td>
				<td>
					{{$adres}}
				</td>
			</tr>
		</tbody>
	</table>
	</p>
	{{END}}

	{{BEGIN historiaLogowania}}
	<p>
	<table style="page-break-inside:avoid">
		<thead>
			<tr colspan="2" >
				<th style="text-align: left;" >{{$historia_logowania_etykieta}}</th>
			</tr>
		</thead>
		<tbody>
			{{BEGIN wpis}}
			{{IF $data}}
			<tr >
				<td style="width:200px; font-weight: bold;">{{$data}}</td>
			</tr>
			{{ELSE}}
			<tr>
				<td style="width:200px;" >  {{$godzina_start}} - {{$godzina_stop}} ({{$hours}})</td>
				<td>{{$ekipa}} {{$pracownik_imie}} {{$pracownik_nazwisko}}</td>
			</tr>
			{{END}}
			{{END wpis}}
		</tbody>
	</table>
	</p>
	{{END historiaLogowania}}

	{{BEGIN notatki}}
	<p>
	<table style="page-break-inside:avoid">
		<thead>
			<tr colspan="2" >
				<th style="text-align: left;">{{$notatki_etykieta}}</th>
			</tr>
		</thead>
		<tbody>
			{{BEGIN wpis}}
			<tr>
				<td style="width:200px; vertical-align: top; border-bottom: 1px solid #ccc; ">
					{{$data}}<br/>
					{{$uzytkownik_imie}} {{$uzytkownik_nazwisko}}
				</td>
				<td style="border-bottom: 1px solid #ccc; padding: 10px 0;">
					{{$tresc}}
				</td>
			</tr>
			{{END wpis}}
		</tbody>
	</table>
	</p>
	{{END notatki}}

	{{BEGIN produktyZakupione}}
	<p>
	<table style="page-break-inside:avoid">
		<thead>
			<tr colspan="2">
				<th style="text-align: left;">{{$produkty_zakupione_etykieta}}</th>
			</tr>
		</thead>
		<tbody>
			{{BEGIN wpis}}
			<tr>
				<td style="width:200px;">
					{{$produkt}}
				</td>
				<td>
					{{$status}}
				</td>
				<td>
					x{{$ilosc}}
				</td>
			</tr>
			{{END wpis}}
		</tbody>
	</table>
	</p>
	{{END produktyZakupione}}
</p>
	{{BEGIN pagebreak}}
		<pagebreak />
	{{END}}
{{END zamowienie}}
	
{{BEGIN footer}}
	<table border="0" width="100%" style="margin-bottom: -10px">
		<tr>
			<td style="width: 45%; font-size: 7pt">{{$stopka_adres}}</td>
			<td style="width: 35%; font-size: 7pt">{{$stopka_telefon}}</td>
			<td style="width: 20%; font-size: 7pt">{{$stopka_email}}</td>
		</tr>
	</table>
{{END}}
	
{{END raport}}