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
		<table>
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
		<table>
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
		<table>
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
		<table>
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
						x{{$ilosc}}
					</td>
				</tr>
				{{END wpis}}
			</tbody>
		</table>
		</p>
		{{END produktyZakupione}}
	</p>
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