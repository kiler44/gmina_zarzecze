{{BEGIN index}}
<script type="text/javascript">
	var notLogin = 0;
	var status = 0;
	var dzial = 0;
		
	$(document).ready(function(){
		
		szukajStatus($('#status'));
		$('a[klucz=login]').addClass('btn-success');
		$('a[klucz=logout]').addClass('btn-warning');
		$('tr.niezalogowany').find('a[klucz=logout]').hide();
		$('tr.zalogowany').find('a[klucz=login]').hide();
		$('tr.wiersz').attr('attr-opcje', 0);
		
		$('select').select2();
		
		$("#filter").keyup(function(){
				var filter = $.trim($(this).val()), count = 0;
				if( ! $('#czyscWyniki').is('is:visible') && filter.length > 0)
				{
					$('#czyscWyniki').show();
				}
				if(filter.length == 0)
				{
					$('#czyscWyniki').hide();
				}
				$(".table tr[attr-opcje=0] .frazaSzukaj").each(function(){
					
					if($(this).text().search(new RegExp(filter, "i")) < 0)
					{
						$(this).parents('tr').fadeOut();
					}
					else
					{
						$(this).parents('tr').show();
						count++;
					}
				});
				
				var numberItems = count;
				
				$("#filter-count").text("{{$znaleziono_zamowien}}"+count);
		   });
		
		$('#oddzial').on('change', function(){ szukajDzial($(this)); });
		$('#status').on('change', function(){ szukajStatus($(this)); });
		$('#login').on('click', function() { szukajLogin($(this)); });
		$('.filterClose').on('click', function(){ wylaczFiltr($(this)); });
		$('a[klucz=login]').on('click', function(e){ wyswietlLogin(e, $(this));  return false;});
		$('a[klucz=logout]').on('click', function(e){ wyswietlLogout(e, $(this));  return false; });
		$('a[klucz=pokazDzien]').on('click', function(){
			var idUzytkownika = $(this).parents('tr').attr('id').replace('wiersz_', '');
			
			var dane = { idUzytkownika:idUzytkownika };  
			modalAjax("{{$podgladDni}}", false, 'POST', dane);  
			return false; 
		});
		$('.close-menu').on('click', function(){ $('#chmurka').hide(); });
		$('.zmienCzas').on('click', function(){ zmienCzas($(this)); return false; })
		$('.zatwierdzLog').on('click', function(){ if($(this).attr('data-action') == 'login'){ zaloguj($(this)); }else{ wyloguj($(this)); } });
		
	});
	
	function zaloguj(obiekt)
	{
		var godziny = $('.bootstrap-timepicker-hour').val();
		var minuty = $('.bootstrap-timepicker-minute').val();
		var idUzytkownika = $('input[name=id_uzytkownika]').val();
		
		var dane = { godziny: godziny, minuty: minuty, idUzytkownika:idUzytkownika };
		ajax("{{$urlZaloguj}}", potwierdzZalogowany, dane, 'POST', 'json');
	}
	
	function wyloguj(obiekt)
	{
		var godziny = $('.bootstrap-timepicker-hour').val();
		var minuty = $('.bootstrap-timepicker-minute').val();
		var idUzytkownika = $('input[name=id_uzytkownika]').val();
		
		var dane = { godziny: godziny, minuty: minuty, idUzytkownika:idUzytkownika };
		ajax("{{$urlWyloguj}}", potwierdzWylogowany, dane, 'POST', 'json');
	}
	
	function potwierdzZalogowany(dane)
	{
		if(dane.error)
		{
			alertModal('Error', dane.errorTxt);
		}
		else
		{
			var info = '<span class="badge badge-success"><small>from </small> '+dane.data+'</span>';
			$('.close-menu').click();
			$('tr#wiersz_'+dane.idUzytkownika).children('td').eq(5).html(info);
			$('tr#wiersz_'+dane.idUzytkownika).removeClass('niezalogowany');
			$('tr#wiersz_'+dane.idUzytkownika).find('a[klucz=login]').hide();
			$('tr#wiersz_'+dane.idUzytkownika).find('a[klucz=logout]').show();
		}
	}
	
	function potwierdzWylogowany(dane)
	{
		if(dane.error)
		{
			alertModal('Error', dane.errorTxt);
		}
		else
		{
			if(dane.info)
			{
				alertModal('Info', dane.infoTxt);
			}
			var info = '<span class="badge badge-info"><small>from </small> '+dane.start+' to '+dane.stop+'</span>';
			$('.close-menu').click();
			$('tr#wiersz_'+dane.idUzytkownika).children('td').eq(5).html(info);
			
			$('tr#wiersz_'+dane.idUzytkownika).find('a[klucz=login]').show();
			$('tr#wiersz_'+dane.idUzytkownika).find('a[klucz=logout]').hide();
		}
	}
	
	function zmienCzas(obiekt)
	{
		var akcja = obiekt.attr('data-action');
		var godziny = parseInt($('.bootstrap-timepicker-hour').val());
		var minuty = parseInt($('.bootstrap-timepicker-minute').val());
		
		if(akcja == 'incrementHour')
		{
			if(godziny >= 23){ godziny = 0;  $('.bootstrap-timepicker-hour').val(minuty); return; }
			godziny = godziny+1;
			$('.bootstrap-timepicker-hour').val(godziny);
			
		}
		if(akcja == 'incrementMinute')
		{
			if(minuty >= 45){ minuty = 0;  $('.bootstrap-timepicker-minute').val(minuty); return; }
			minuty = minuty+5;
			$('.bootstrap-timepicker-minute').val(minuty);
		}
		if(akcja == 'decrementHour')
		{
			if(godziny <= 0){ $('.bootstrap-timepicker-hour').val(23); return; }
			godziny = godziny-1;
			$('.bootstrap-timepicker-hour').val(godziny);
		}
		if(akcja == 'decrementMinute')
		{
			if(minuty <= 0){ minuty = 45;  $('.bootstrap-timepicker-minute').val(minuty); return; }
			minuty = minuty-5;
			$('.bootstrap-timepicker-minute').val(minuty);
		}
		
	}
	
	function wyswietlLogout(e, obiekt)
	{
		var chmurka = $('#chmurka');
		var mouseX = e.pageX-210;
		var mouseY = e.pageY-230;
		chmurka.css('left', mouseX);
		chmurka.css('top', mouseY);
		
		$('.bootstrap-timepicker-hour').val('18');
		$('.bootstrap-timepicker-minute').val('00');
		$('.zatwierdzLog').attr('data-action', 'logout');
		$('input[name=id_uzytkownika]').val(obiekt.parents('tr').attr('id').replace('wiersz_', ''));
		chmurka.show(100);
		return false;
	}
	
	function wyswietlLogin(e, obiekt)
	{
		var chmurka = $('#chmurka');
		var mouseX = e.pageX-210;
		var mouseY = e.pageY-230;
		chmurka.css('left', mouseX);
		chmurka.css('top', mouseY);
		
		$('.bootstrap-timepicker-hour').val('7');
		$('.bootstrap-timepicker-minute').val('30');
		$('.zatwierdzLog').attr('data-action', 'login');
		$('input[name=id_uzytkownika]').val(obiekt.parents('tr').attr('id').replace('wiersz_', ''));
		chmurka.show(100);
		return false;
	}
	
	function wylaczFiltr(obiekt)
	{
		var id = obiekt.attr('id');
		if(id == 'filtr_niezalogowany'){ notLogin = 0; $('#filtr_niezalogowany').hide(); $('#login').prop('checked' , false).uniform(); }
		if(id == 'filtr_status'){ status = 0; $('#filtr_status').hide(); $('#status').val(0).select2(); }
		if(id == 'filtr_dzial'){ dzial = 0; $('#filtr_dzial').hide(); $('#oddzial').val(0).select2(); }
		
		wyszukiwarka();
	}
	
	function szukajLogin(obiekt)
	{
		if(obiekt.is(':checked'))
		{
			$('#filtr_niezalogowany').show();
			
			notLogin = 1;
		}
		else
		{
			notLogin = 0;
			$('#filtr_niezalogowany').hide();
		}
		wyszukiwarka();
	}
	
	function szukajStatus(obiekt)
	{
		if(obiekt.val() != 0)
		{
			$('#filtr_status').show();
			$('#filtr_status').text( $('#status option[value='+obiekt.val()+']').text() );
			status = $.trim(obiekt.val());
			
		}
		else
		{
			status = "";
			$('#filtr_status').hide();
		}
		wyszukiwarka();
	}
	
	function szukajDzial(obiekt)
	{
		if(obiekt.val() > 0)
		{
			
			$('#filtr_dzial').show();
			$('#filtr_dzial').text( $('#oddzial option[value='+obiekt.val()+']').text() );

			dzial = $.trim(obiekt.val());
			
		}
		else
		{
			dzial = 0;
			$('#filtr_dzial').hide();
			
		}
		wyszukiwarka();
	}
	
	function wyszukiwarka()
	{
		$(".table tr").attr('attr-opcje', 0).show();
		
		if(dzial > 0)
		{
			$('.dzialS[dzial-attr!='+dzial+']').parents('tr').attr('attr-opcje', 1).hide();
		}
		if(status != "" && status != 0)
		{
			$('.statusS[status-attr!='+status+']').parents('tr').attr('attr-opcje', 1).hide();
		}
		if(notLogin == 1)
		{
			$('.login[login-attr=1]').parents('tr').attr('attr-opcje', 1).hide();
		}
		
		if( dzial > 0 || (status != "" && status != 0) || notLogin == 1)
		{
			$('#wybraneFiltry').show();
		}
		else
		{
			$('#wybraneFiltry').hide();
		}
		
	}
	
</script>
<div class="widget-box">
<div class="widget-title">
	{{$menuTop}}
</div>
<div id="chmurka" style='display: none;'>
<a href='javascript:void(0)' class='close-menu fL'><i class="icon icon-remove"></i></a><br/>
<div class="bootstrap-timepicker-widget dropdown-menu timepicker-orient-left timepicker-orient-bottom open" style="position: relative; border: none; box-shadow: initial; margin-left: 20px; margin-top: -30px;">
<table>
	<tbody>
		<tr>
			<td><a href="#" class="zmienCzas" data-action="incrementHour"><i class="icon-chevron-up"></i></a></td>
			<td class="separator">&nbsp;</td><td>
				<a href="#" class="zmienCzas" data-action="incrementMinute"><i class="icon-chevron-up"></i></a>
			</td>
		</tr>
		<tr>
			<td>
				<input class="bootstrap-timepicker-hour" maxlength="2" type="text"></td> 
			<td class="separator">:</td>
			<td><input class="bootstrap-timepicker-minute" maxlength="2" type="text"></td> 
		</tr>
		<tr>
			<td><a href="#" class="zmienCzas" data-action="decrementHour"><i class="icon-chevron-down"></i></a></td>
			<td class="separator"></td><td><a href="#" class="zmienCzas" data-action="decrementMinute"><i class="icon-chevron-down"></i></a></td>
		</tr>
	</tbody>
</table>
	<input type="hidden" name="id_uzytkownika" id="id_uzytkownika" value=""/>
	<button class="btn btn-info zatwierdzLog" data-action="" ><i class="icon icon-ok"></i></button>
</div>
</div>

<div class="widget-box">
	<div class="formularz_grid" style="padding-top:10px;">
		<form id="wyszukiwarka" class="form-inline" action="" method="post" name="no-focus-wyszukiwarka" enctype="multipart/form-data">
		<ul class="fL">
			<li class="fL">
				<label class="input_ok" for="login" >{{$szukajLogin}} </label>
				<input type="checkbox" name="login" id="login" />
				<div class="clear"></div>
			</li>
			
			<li class="fL">
				<label class="input_ok" for="status" >{{$szukajStatus}} </label>
				<select name="status" id="status" >
					<option value="0">--select--</option>
					{{BEGIN status}}
					<option value="{{$status}}" {{$selected}} >{{$etykieta}}</option>
					{{END status}}
				</select>
				<div class="clear"></div>
			</li>
			<li class="fL">
				<label class="input_ok" for="szukaj" >{{$szukajOddzial}} </label>
				<select name="oddzial" id="oddzial" >
					<option value="0">--select--</option>
					{{BEGIN dzial}}
					<option value="{{$dzialId}}">{{$dzialNazwa}}</option>
					{{END dzial}}
				</select>
				<div class="clear"></div>
			</li>
			<li class="fL">
				<label class="input_ok label-szukaj" for="szukaj" >{{$szukajFraza}} </label> 
				<input class="input-szukaj" autofocus type="text" placeholder="{{$szukajFrazaPlaceholder}}" autocomplete="off" name="fraza" id="filter" value="" />
				<div class="clear"></div>
				 
				<div class="clear"></div>
				<span id="ilosc-wynikow" class="help-block"></span>
			</li>
		</ul>
		</form>
		<div class="clear"></div>
		<div id='wybraneFiltry' style='padding: 10px; margin-left: 116px; display:none;' >
			{{$etykieta_filtry}} 
			<span class='badge badge-default filterClose cursorPointer' id='filtr_dzial' style="display:none;" >Department <span> x </span></span>
			<span class='badge badge-default filterClose cursorPointer' id='filtr_status' style="display:none;" >Status <span> x </span></span>
			<span class='badge badge-default filterClose cursorPointer' id='filtr_produkt' style="display:none;" >Product <span> x </span></span>
			<span class='badge badge-default filterClose cursorPointer' id='filtr_niezalogowany' style="display:none;" >Not login <span> x </span></span>
		</div>
		<div class="clear"></div>
	</div>
</div>
<div class="widget-box">
	<div class="widget-content nopadding">
		{{$grid}}
	</div>
</div>
</div>
{{END}}

{{BEGIN test}}
<div class="widget-box">
	<div class="widget-content">
		 {{$formularzTestowy}}
		<table class="table table-striped table-bordered">
			<thead>
			<tr>
				<th>start</th>
				<th>stop</th>
				<th>name</th>
				<th>minutes</th>
				<th>x</th>
				<th>rate</th>
				<th>amount</th>
			</tr>
			</thead>
			{{BEGIN wpis}}
			<tbody>
			<tr>
				<td>{{$start}}</td>
				<td>{{$stop}}</td>
				<td>{{$nazwa}}</td>
				<td>{{$minuty}} ({{$godziny}} h)</td>
				<td>{{$mnoznik}}</td>
				<td>{{$stawka}} ({{$stawka_podstawowa}})</td>
				<td>{{$wyplata}}</td>
			</tr>
			</tbody>
			{{END}}
			{{BEGIN suma}}
			<tfoot>
			<tr>
				<td></td>
				<td></td>
				<td></td>
				<td>{{$sumaMinut}} ({{$sumaGodzin}} h)</td>
				<td>{{$sumaMinutyDat}} ({{$sumaGodzinDat}} h)</td>
				<td></td>
				<td>{{$sumaWyplata}}</td>
			</tr>
			</tfoot>
			{{END}}
		</table>
	</div>
</div>
{{END index}}

{{BEGIN dodajProdukt}}
<div class="widget-box">
	<div class="widget-content">
		 {{$formularz}}
	</div>
</div>
{{END dodajProdukt}}

{{BEGIN listaProduktow}}
<div class="widget-box">
	<div class="widget-content">
		{{$grid}}
	</div>
</div>
{{END listaProduktow}}

{{BEGIN podgladDni}}
<script>
	var opts = {showMeridian: false};
	
	if(jest == 0)
	{
		$(document).on('click', 'input[name=akceptuj]' ,function(){
			
			var idWpisu = $(this).val();
			var akceptacja = ($(this).is(':checked')) ? 'akceptacja' : 'oczekuje';
			
			ajax("{{$urlZapiszAkceptacja}}" , potwierdzAkceptacja, { idWpisu: idWpisu, akceptacja: akceptacja }, 'POST', 'json', true );

		});
		$(document).on('click', ".zapiszNotatke", function(e){ var notatka = $(this).prev('input[name=notatka]').val();
				var idWpisu = $(this).attr('data-id');
				zapiszNotatke(notatka, idWpisu);
				return false;	
			});

		$(document).on('click', ".usunWpis", function(e){ var idWpisu = $(this).attr('data-id');
				usunWpis(idWpisu);
				return false;	
			});
		$(document).on('change', 'select[name=listaProduktow]', function(){
			if($(this).parents('tbody').length)
			{
				var idWpisu = $(this).parents('tr').attr('data-id');
				var idProduktu = $(this).val();
				ajax("{{$linkAktualizujWpis}}" , potwierdzAktualizujWpis, { idWpisu: idWpisu, idProduktu: idProduktu }, 'POST', 'json' );
			}
		});
		
		jest++;
	}
	
	
	$(document).ready(function(){
		
		$('#wsteczPodgladDnia').on('click', function(){
			var link = $(this).attr('href');
			modalAjax( link , false, 'POST', { } ); 
			return false;
		});
		
		$('input[name=dataStart]').timepicker(opts);
		$('input[name=dataStop]').timepicker(opts);
		
		$('input[name=dataStart]').on('change', function(){ 
				zmienDataStart($(this));
		});
		
		
		$('input[name=dataStop]').on('change', function(){ 
				zmienDataStop($(this));
		});
		
		sprawdzZaznaczWszystkie();
		
		$('#zaznaczWszystkie').on('click', function(){
			
			var akceptacja = ($(this).is(':checked')) ? 'akceptacja' : 'oczekuje';
			var ilosc = $('input[name=akceptuj]').length;
			var i = 0;
			$('input[name=akceptuj]').each(function(){
				i++;
				
				if(i != ilosc){
					
					if(akceptacja == 'akceptacja')
						$(this).attr('checked', true);
					else
						$(this).attr('checked', false);

					var idWpisu = $(this).val();

					ajax("{{$urlZapiszAkceptacja}}" , potwierdzAkceptacja, { idWpisu: idWpisu, akceptacja: akceptacja }, 'POST', 'json' );
				}
			});
			
		});
		
		$('.dodajWpis').on('click', function(){
			
			var godzinaStart = $('input[name=dataStartNowa]').val();
			var godzinaStop = $('input[name=dataStopNowa]').val();
			var produkt = $('select[name=listaProduktow]').val();
			var notatka = $('input[name=notatkaNowa]').val();
			
			zapiszNowyWpis(godzinaStart, godzinaStop, produkt, notatka);
			return false;
		});
		
		$('input[name=dataStartNowa]').timepicker(opts);
		$('input[name=dataStopNowa]').timepicker(opts);

		$('input[name=dataStartNowa]').on('change', function(){ var czas = liczMinuty(); $('#minutyNowe').text( czas.godziny+'('+czas.minuty+')' ); });
		$('input[name=dataStopNowa]').on('change', function(){ var czas = liczMinuty(); $('#minutyNowe').text( czas.godziny+'('+czas.minuty+')' ); });
	
	});
	
	function sprawdzZaznaczWszystkie()
	{
		var zaznaczWszystkie = 0;
		var ilosc = $('input[name=akceptuj]').length;
		var i = 0;
		var iZaznaczone = 0;
		$('input[name=akceptuj]').each(function(){
			i++;
			if(i != ilosc)	if($(this).is(':checked')) iZaznaczone++ ;
		});
		 
		if( iZaznaczone > 0 && (ilosc - 1) == iZaznaczone){ $('#zaznaczWszystkie').attr('checked', true); }
		
	}
	
	function potwierdzAkceptacja(dane)
	{
			$('.numeryTygodnia').filter(function(){ return $(this).data("attr")   == dane.tydzien}).addClass('zaznaczonyTydzien').click();
			wyszukiwarka();
	}
	
	function zapiszNowyWpis(godzinaStart, godzinaStop, produkt, notatka)
	{
		ajax("{{$urlZapiszNowyWpis}}" , potwierdzZapiszNowyWpis, { godzinaStart: godzinaStart, godzinaStop: godzinaStop, produkt:produkt, notatka:notatka, data_start: '{{$data_start}}' }, 'POST', 'json' );
	}
	
	function potwierdzZapiszNowyWpis(dane)
	{
	
		var wpis = '<tr data-id="{ID}"><td style="background: {KOLOR}">{NAZWA_PRODUKTU}</td><td style="background: {KOLOR}">{START}</td><td style="background: {KOLOR}">{STOP}</td>\n\
						<td style="background: {KOLOR}">{CZAS} ({CZAS_MINUTY})</td>\n\
						<td style="background: {KOLOR}"><input name="notatka" value="{NOTATKA}" type="text">\n\
						<a class="btn tip-top btn-info zapiszNotatke" data-id="{ID}" href="" target="_self" data-original-title="Add note">\n\
						<i class="icon-ok"></i>\n\
						</a>\n\
						<td style="text-align:center;"><input type="checkbox" name="akceptuj" value="{ID}"></td>\n\
						<a class="btn tip-top btn-info zapiszNotatke" data-id="{ID}" href="" target="_self" data-original-title="Add note">\n\
						<i class="icon-ok"></i></a></td><td>\n\
						<a class="btn tip-top usunWpis" data-id="{ID}" href="" target="_self" data-original-title="Delete">\n\
						<i class="icon-remove"></i></a></td></tr>';
		var szukaj = ['{ID}', '{KOLOR}', '{NAZWA_PRODUKTU}', '{START}', '{STOP}', '{CZAS}', '{CZAS_MINUTY}', '{NOTATKA}'];
		var zamien = [dane.idWpisu, dane.kolor, dane.produkt_nazwa, dane.start, dane.stop, dane.godziny, dane.minuty, dane.notatka];
		
		var nowy_wpis = wpis.replaceArray(szukaj, zamien);
		$('.stawka_tabela').find('tbody').append(nowy_wpis);
		{{IF $poprawa}}
			$('.numeryTygodnia').filter(function(){ return $(this).data("attr")   == dane.tydzien}).addClass('zaznaczonyTydzien').click();
			wyszukiwarka();
		{{END IF}}
	}
	
	function zapiszNotatke(notatka, idWpisu)
	{
		 ajax("{{$urlZapiszNotatke}}" , potwierdzZapiszNotatke, { notatka: notatka, idWpisu: idWpisu }, 'POST', 'json' );
	}
	function potwierdzZapiszNotatke(dane)
	{
		alert(dane.info);
	}
	function usunWpis(idWpisu)
	{
		ajax("{{$urlUsunWpis}}" , potwierdzUsunWpis, { idWpisu: idWpisu }, 'POST', 'json' );
	}
	function potwierdzAktualizujWpis(dane)
	{
		if(dane.error == 1)
		{
			alert(dane.errorTxt);
		}
		else if(dane.error == 2)
		{
			$('tr[data-id='+dane.idWpisu+']').find('.minutyNowe').attr('style', 'color:red;').text('0');
		}
		else if(dane.godziny > 0 )
		{
			$('tr[data-id='+dane.idWpisu+']').find('.minutyNowe').removeAttr('style').text(dane.godziny);
			aktualizujSumaGodzin();
		}
	}
	function potwierdzUsunWpis(dane)
	{
		if(dane.blad)
		{
			alert(dane.info);
		}
		else
		{
			$('tr[data-id='+dane.idWpisu+']').remove();
		}
	}
	function zmienDataStart(obiekt)
	{
		var idWpisu = obiekt.parents('tr').attr('data-id');
		var dataRodzaj = 'start';
		var godzinaStart = obiekt.val();
		ajax("{{$linkAktualizujWpis}}" , potwierdzAktualizujWpis, { idWpisu: idWpisu, dataRodzaj: dataRodzaj, data: godzinaStart  }, 'POST', 'json' );
	}
	function zmienDataStop(obiekt)
	{
		var idWpisu = obiekt.parents('tr').attr('data-id');
		var dataRodzaj = 'stop';
		var godzinaStop = obiekt.val();

		ajax("{{$linkAktualizujWpis}}" , potwierdzAktualizujWpis, { idWpisu: idWpisu, dataRodzaj: dataRodzaj, data: godzinaStop  }, 'POST', 'json' );
	}
	function liczMinuty()
	{
		var start = $('input[name=dataStartNowa]').val();
		var stop = $('input[name=dataStopNowa]').val();
		var diff =  Math.abs(new Date("1970-1-1 " + start) - new Date("1970-1-1 " + stop));
		var minuty = diff/1000/60;
		var godziny = number_format( (diff/1000/60/60) , 2);
		var dane = {
			godziny:godziny,
			minuty:minuty
		}
		return dane;
	}
	
</script>
<div class="widget-box">
	
	<div class="widget-content">
		<table class="table table-striped table-bordered stawka_tabela" style="">
			<thead>
				<tr>
					<th>{{$etykieta_nazwaProduktu}}</th>
					<th>{{$etykieta_dataStart}}</th>
					<th>{{$etykieta_dataStop}}</th>
					<th>{{$etykieta_minuty}}</th>
					<th>{{$etykieta_notatka}}</th>
					<th><input type="checkbox" id="zaznaczWszystkie" /></th>
					<th></th>
				</tr>
			</thead>
			<tbody>
				{{BEGIN produkt}}
				<tr data-id="{{$idWpisu}}" >
					<td style="background: {{$kolor}}">{{$inputProdukty}}</td>
					<td style="background: {{$kolor}}"><input type="text" name="dataStart" value="{{$dataStartGodziny}}" /></td>
					<td style="background: {{$kolor}}"><input type="text" name="dataStop" value="{{$dataStopGodziny}}" /></td>
					<td style="background: {{$kolor}}" class="minutyNowe">{{$minuty}}</td>
					<td style="background: {{$kolor}}">
							<input type="text" name="notatka" value="{{$notatka}}" />
							<a class="btn tip-top btn-info zapiszNotatke" data-id="{{$idWpisu}}" href="" target="_self" data-original-title="Add note">
								<i class="icon-ok"></i>
							</a>	
					</td>
					<td style="text-align:center;">
						<input type="checkbox" name="akceptuj" value="{{$idWpisu}}" {{$zaakceptowany}} />
					</td>
					<td>
						<a class="btn tip-top usunWpis" data-id="{{$idWpisu}}" href="" target="_self" data-original-title="Delete">
							<i class="icon-remove"></i>
						</a>
					</td>
					
				</tr>
				{{END produkt}}
			</tbody>
			<tfoot>
				<tr>
					<td>
						{{$selectListaProduktow}}
					</td>
					<td>
						<input type="text" name="dataStartNowa" />
					</td>
					<td>
						<input type="text" name="dataStopNowa" />
					</td>
					<td>
						<span id="minutyNowe">
							
						</span>
					</td>
					<td><input type="text" name="notatkaNowa" /></td>
					<td style="text-align:center;">
						<input type="checkbox" name="akceptuj" value="{{$idWpisu}}" />
					</td>
					<td>
						<a class="btn tip-top btn-info dodajWpis" href="" target="_self" data-original-title="Delete">
							<i class="icon-ok "></i>
						</a>
					</td>
					
					</td>
				</tr>
			</tfoot>
		</table>
		{{BEGIN przyciskWstecz}}
		<a href="{{$linkWstecz}}" id="wsteczPodgladDnia" class="btn btn-info">Back</a>
		{{END}}
	</div>
</div>
{{END podgladDni}}

{{BEGIN listaProduktowInput}}
<select name="listaProduktow" >
	{{BEGIN opcja}}
	<option value="{{$wartosc}}" class="ralcp-A98307" {{$selected}} style="background-color:{{$kolor}}" data-color="#A98307">{{$etykieta}}</option>
	{{END opcja}}
</select>
{{END}}

{{BEGIN sprawdzTydzien}}
<script type="text/javascript">
	
	var oczekuje = '';
	var akceptacja = '';
	var dzial = 0;
	var status = '';
	
	$(document).on('click', '.stanDzien', function(){
				var idUzytkownika = $(this).attr('data-id');
				var data = $(this).attr('data-data');
				var daneWysylane = { idUzytkownika:idUzytkownika, data:data };  
				
				modalAjax("{{$linkPoprawDzien}}", false, 'POST', daneWysylane);  
				return false;
		});
	$(document).on('click', '.poprawCalyTydzien', function(){
		
		modalAjax($(this).attr('href'), false, 'POST', {});
		return false;
	});
	$(document).on('click', '.sprawdzone', function(){
		
		var filterNazwa = $(this).attr('name');
		
		oczekuje = '';
		if(filterNazwa == 'oczekuje' && $(this).is(':checked')) oczekuje = 'oczekuje';
		akceptacja = '';
		if(filterNazwa == 'akceptacja' && $(this).is(':checked')) akceptacja =  'akceptacja';
		
		$('tr').show();
		if(oczekuje != '')
		{
			$('#listaUzytkownikow > tr').not('.oczekuje').hide();
			$('#akceptacja').prop('checked' , false).uniform();
		}
		
		if(akceptacja != '')
		{
			$('#listaUzytkownikow > tr').not('.akceptacja').hide();
			$('#oczekuje').prop('checked' , false).uniform();
		}
		wyszukiwarka();
	});
	
	function zamknijTydzien(dane)
	{
		if(dane.tydzienZamkniety)
		{
			var przyciskZamknijTydzien = $('button[name=zakmnijTydzien]');
			
			przyciskZamknijTydzien.addClass('btn-info');
			przyciskZamknijTydzien.find('.icon').removeClass('icon-unlock').addClass('icon-lock');
			przyciskZamknijTydzien.show();
			$('.numeryTygodnia[data-attr='+dane.tydzien+']').find('.icon').removeClass('icon-unlock').addClass('icon-lock');
			
		}
	}
	$(document).ready(function(){
		
		szukajStatus($('#status'));
		
		$('#status').on('change', function(){ szukajStatus($(this)); });
		
		$('button[name=zakmnijTydzien]').on('click', function(){
			var zaznaczonyTydzien = $('.zaznaczonyTydzien').attr('data-attr');
			ajax("{{$linkZamknijTydzien}}" , zamknijTydzien, { tydzien: zaznaczonyTydzien }, 'POST', 'json', true );
		});
		
		$('#listaUzytkownikow tr').attr('attr-opcje', 0);
		
		$('.numerTygodniaPrzesun').on('click', function(){ przesunTygodnie($(this).attr('data-attr')); });
		
		$('.numeryTygodnia').not('.numerTygodniaPrzesun').on('click', function(){ var tydzien = $(this).attr('data-attr'); ajax("{{$linkGridTydzien}}" , zmienTydzien, { tydzien: tydzien }, 'POST', 'json', true ); });
		//$('.numeryTygodnia').not('.numerTygodniaPrzesun').on('click', function(){ var tydzien = $(this).attr('data-attr'); location.href = "{{$linkSprawdzTydzien}}&tydzien="+tydzien; });
		$('#oddzial').on('change', function(){ szukajDzial(); } );
		
		$("#filter").keyup(function(){
				var filter = $.trim($(this).val()), count = 0;
				if( ! $('#czyscWyniki').is('is:visible') && filter.length > 0)
				{
					$('#czyscWyniki').show();
				}
				if(filter.length == 0)
				{
					$('#czyscWyniki').hide();
				}
				$(".table tr[attr-opcje=0] .frazaSzukaj").each(function(){
					if($(this).text().search(new RegExp(filter, "i")) < 0)
					{
						$(this).parents('tr').fadeOut();
					}
					else
					{
						if(oczekuje != '' && $(this).parents('tr').hasClass('oczekuje'))
							$(this).parents('tr').show();
						if(akceptacja != '' && $(this).parents('tr').hasClass('akceptacja') )
							$(this).parents('tr').show();
						if(oczekuje == '' && akceptacja == '')
							$(this).parents('tr').show();
						
						count++;
					}
				});
				
				var numberItems = count;
				
				$("#filter-count").text("{{$znaleziono_zamowien}}"+count);
		   });
		});
		
		
		function zmienTydzien(dane)
		{
			$('#listaUzytkownikow').html(dane.html);
			
			$('.numeryTygodnia').removeClass('zaznaczonyTydzien');
		   $('.numeryTygodnia').filter(function(){ return $(this).data("attr")   == dane.tydzien}).addClass('zaznaczonyTydzien');
			
			if(dane.iloscDoSprawdzenia == 0)
			{
				if($('.zaznaczonyTydzien').hasClass('tydzienNieSprawdzony'))
					$('.zaznaczonyTydzien').removeClass('tydzienNieSprawdzony').addClass('tydzienSprawdzony');
			}
			else
			{
				if($('.zaznaczonyTydzien').hasClass('tydzienSprawdzony'))
					$('.zaznaczonyTydzien').removeClass('tydzienSprawdzony').addClass('tydzienNieSprawdzony');
			}
			
			$('.wartoscNieSprawdzone').text(dane.iloscDoSprawdzenia);
			$('.wartoscSprawdzone').text(dane.iloscSprawdzonych);
			$('#listaUzytkownikow tr').attr('attr-opcje', 0);
			var przyciskZamknijTydzien = $('button[name=zakmnijTydzien]');
			
			if(dane.wyswietlajZamknijTydzien)
			{
				przyciskZamknijTydzien.removeClass('btn-info btn-warning').addClass(dane.klasaPrzycisku);
				przyciskZamknijTydzien.find('.icon').removeClass('icon-unlock icon-lock').addClass(dane.ikonaTydzienZamkniety);
				przyciskZamknijTydzien.show();
			}
			else
			{
				przyciskZamknijTydzien.hide();
			}
			
			wyszukiwarka(true);
		}
		
		function przesunTygodnie(kierunek)
		{
			var tydzienObecny = $('.zaznaczonyTydzien').attr('data-attr');
			var tydzienMax = $('tr.numeryTygodniaLinia td.tydzien:last').children('.numeryTygodnia ').attr('data-attr');
			 
			if(kierunek == 'prev')
			{
				var tydzienObecnyNowy = ( (tydzienObecny-1) < 1 ) ? 1 : parseInt(tydzienObecny-1);
			}
			else if(kierunek == 'prev10')
			{
				var tydzienObecnyNowy = ( (tydzienObecny-10) < 1 ) ? 1 : parseInt(tydzienObecny-10);
			}
			else if(kierunek == 'next')
			{
				var tydzienObecnyNowy = ( (tydzienObecny+1) > tydzienMax ) ? tydzienMax : (parseInt(tydzienObecny)+1);
			}
			else if(kierunek == 'next10')
			{
				var tydzienObecnyNowy = ( (tydzienObecny+10) > tydzienMax ) ? tydzienMax : (parseInt(tydzienObecny)+10);
			}
			
			var start = ((tydzienObecnyNowy - 10) < 1 ) ? 1 : (tydzienObecnyNowy - 10);
			var stop = ((tydzienObecnyNowy + 10) > tydzienMax ) ? tydzienMax : (tydzienObecnyNowy + 10);
			
			$('.numeryTygodnia').removeClass('zaznaczonyTydzien');
		   $('.numeryTygodnia').filter(function(){ return $(this).data("attr")   == tydzienObecnyNowy}).addClass('zaznaczonyTydzien').click();
			
			var i=0;
			$('td.tydzien').each(function()
				{
					( i >= start && i <= stop ) ? $(this).show() : $(this).hide();
					i++;
				});
			
		}
		
		function szukajStatus(obiekt)
		{
			if(obiekt.val() != 0)
			{
				$('#filtr_status').show();
				$('#filtr_status').text( $('#status option[value='+obiekt.val()+']').text() );
				status = $.trim(obiekt.val());

			}
			else
			{
				status = "";
				$('#filtr_status').hide();
			}
			
			wyszukiwarka();
		}
	
		function szukajDzial()
		{
			var obiekt = $('#oddzial');
			
			$('table.listaUzytkownikow tbody').children('tr').show();
			if(obiekt.val() > 0)
			{

				$('#filtr_dzial').show();
				$('#filtr_dzial').text( $('#oddzial option[value='+obiekt.val()+']').text() );

				dzial = $.trim(obiekt.val());

			}
			else
			{
				dzial = 0;
				$('#filtr_dzial').hide();

			}
			if(dzial > 0)
			{
				$('.dzialS[dzial-attr!='+dzial+']').parents('tr').attr('attr-opcje', 1).hide();
			}
			wyszukiwarka();
		}
		
		function wyszukiwarka(fraza)
		{
			$(".table tr").attr('attr-opcje', 0).show();

			if(dzial > 0)
			{
				$('.dzialS[dzial-attr!='+dzial+']').parents('tr').attr('attr-opcje', 1).hide();
			}
			if(akceptacja != "")
			{
				$('#listaUzytkownikow > tr').not('.akceptacja').attr('attr-opcje', 1).hide();
			}
			if(oczekuje != '')
			{
				$('#listaUzytkownikow > tr').not('.oczekuje').attr('attr-opcje', 1).hide();
			}
			if(fraza)
			{
				$('#filter').keyup();
			}
			if(status != "" && status != 0)
			{
				$('.statusS[status-attr!='+status+']').parents('tr').attr('attr-opcje', 1).hide();
			}
			if( dzial > 0 || oczekuje != "" || akceptacja != '')
			{
				$('#wybraneFiltry').show();
			}
			else
			{
				$('#wybraneFiltry').hide();
			}

		}
</script>
<div class="widget-box">
<div class="widget-title">
	{{$menuTop}}
</div>
<div class="widget-box">
	<div class="formularz_grid" style="padding-top:10px;">
		<form id="wyszukiwarka" class="form-inline" action="" method="post" name="no-focus-wyszukiwarka" enctype="multipart/form-data">
		<ul class="fL">
			<li class="fL">
				checked : <input type="checkbox" name="akceptacja" class="sprawdzone" id="akceptacja" value="" />
				not checked : <input type="checkbox" name="oczekuje" class="sprawdzone" id="oczekuje" value="" />
			</li>
			<li class="fL">
				<label class="input_ok" for="status" >{{$szukajStatus}} </label>
				<select name="status" id="status" >
					<option value="0">--select--</option>
					{{BEGIN status}}
					<option value="{{$status}}" {{$selected}} >{{$etykieta}}</option>
					{{END status}}
				</select>
				<div class="clear"></div>
			</li>
			<li class="fL">
				<label class="input_ok" for="szukaj" >{{$szukajOddzial}} </label>
				<select name="oddzial" id="oddzial" >
					<option value="0">--select--</option>
					{{BEGIN dzial}}
					<option value="{{$dzialId}}">{{$dzialNazwa}}</option>
					{{END dzial}}
				</select>
				<div class="clear"></div>
			</li>
			<li class="fL">
				<label class="input_ok label-szukaj" for="szukaj" >{{$szukajFraza}} </label> 
				<input class="input-szukaj" autofocus type="text" placeholder="{{$szukajFrazaPlaceholder}}" autocomplete="off" name="fraza" id="filter" value="" />
				<div class="clear"></div>
				 
				<div class="clear"></div>
				<span id="ilosc-wynikow" class="help-block"></span>
			</li>
			
		</ul>
		</form>
		<ul class="stat-boxes fR" style="margin-top:-40px;">
			<li class="popover-users nopadding" data-original-title="" title="">
				<div class="right infoTidsbankTydzien infoTydzienSprawdzone">
					<div><strong class="wartoscSprawdzone"> {{$iloscSprawdzonych}} </strong></div>
				Checked
				</div>
			</li>
			<li class="popover-orders nopadding" data-original-title="" title="">
				<div class="right infoTidsbankTydzien infoTydzienNieSprawdzone">
					<div><strong class="wartoscNieSprawdzone"> {{$iloscDoSprawdzenia}} </strong></div>
					Not checked
				</div>
			</li>
		</ul>
		<div class="clear"></div>
	</div>
</div>
<div class="formularz_grid" style="padding-top:10px;">
	<table class="table table-striped table-bordered">
		<thead>
			<tr class="numeryTygodniaLinia">
				<td >
					<div class="numeryTygodnia numerTygodniaPrzesun " data-attr="prev" > <i class="icon icon-chevron-left"></i> </div>
				</td>
				<td >
					<div class="numeryTygodnia numerTygodniaPrzesun " data-attr="prev10"> <i class="icon icon-backward"></i> </div>
				</td>
				{{BEGIN numerTygodnia}}
				<td class="tydzien" style="display: {{$widoczna}};">
					<div class="numeryTygodnia {{$klasa}} {{$zaznaczonyTydzien}}" data-attr="{{$numerTygodnia}}">
						{{IF $ikonaTydzien}}<i class="icon {{$ikonaTydzien}}"></i>{{END IF}} {{$numerTygodnia}}
					</div>
				</td>
				{{END}}
				<td >
					<div class="numeryTygodnia numerTygodniaPrzesun" data-attr="next10" > <i class="icon icon-forward"></i> </div>
				</td>
				<td >

					<div class="numeryTygodnia numerTygodniaPrzesun" data-attr="next" > <i class="icon icon-chevron-right"></i> </div>
				</td>
			</tr>
		</thead>
	</table>
	
	<button class="btn btn-warning" {{IF $wyswietlajZamknijTydzien}} style="display:block;" {{ELSE}} style="display:none;" {{END}} name="zakmnijTydzien" > <i class="icon {{$ikonaTydzienZamkniety}}"></i> Close week</button>
	
</div>
<table class="table table-striped table-bordered listaUzytkownikow">
	<thead>
		<tr>
			<th>
				#
			</th>
			<th>
				<a href="{{$linkSortujImie}}">Name</a>
			</th>
			<th>
				Status per day
			</th>
			<th>
				Sum hours
			</th>
			<th>
				N
			</th>
			<th>
				OT
			</th>
			<th>
				...
			</th>
		</tr>
	</thead>
	<tbody id="listaUzytkownikow">
		{{$listaUzytkownikow}}
	</tbody>
	<tfoot>
		
	</tfoot>
</table>
</div>
{{END}}

{{BEGIN listaUzytkownikow}}
{{BEGIN uzytkownik}}
<tr class="{{$akceptacja}} {{$oczekuje}}">
	<td class="frazaSzukaj" style="display: none;">
		{{$frazaSzukaj}}
		<span class="dzialS" dzial-attr="{{$dzial}}" style="display:none"></span>
		<span class="statusS" status-attr="{{$status}}" style="display:none"></span>
	</td>
	<td>{{$numer}}</td>
	<td>{{$nazwa}}</td>
	<td>
		<table class="dniTygodnia">
			<tr>
				{{BEGIN dniTygodnia}}
				<td>
					<div class="uzytkownikDniTygodnia dataDzien">
						{{$data}}
					</div>
					<div class="uzytkownikDniTygodnia stanDzien {{$klasa}}" data-id="{{$idUzytkownika}}" data-data="{{$data}}" >
						{{$iloscOczekujacychNaSprawdzenie}}
					</div>

				</td>
				{{END}}
			</tr>
		</table>
	</td>
	<td>{{$czas}}</td>
	<td>{{$czasNormalvakt}}</td>
	<td>{{$czasOvertid}}</td>
	<td>
		<a class="btn tip-top poprawCalyTydzien"  href="{{$linkPoprawCalyTydzien}}" data-original-title="Check week">
			<i class="icon-qrcode"></i>
		</a>
	</td>
</tr>
{{END}}
{{END}}

{{BEGIN poprawCalyTydzien}}
<script type="text/javascript">
	var opts = {showMeridian: false};
	
	if( jest == 0)
	{
		
		$(document).on('change', '#pracownik' ,function(){
			var idPracownika = $(this).val();
			ajax("{{$linkZmienPracownika}}" , potwierdzPobierzTydzien, { idUzytkownika:idPracownika }, 'POST', 'json' );
		});
		
		$(document).on('change', 'select[name=listaProduktow]', function(){
			
			var idWpisu = $(this).parents('tr').attr('data-id');
			var idProduktu = $(this).val();
			ajax("{{$linkAktualizujWpis}}" , potwierdzAktualizujWpis, { idWpisu: idWpisu, idProduktu: idProduktu }, 'POST', 'json' );
		});
		
		$(document).on('click', '.zapiszNotatke' ,function(){
			var notatka = $(this).prev('input[name=notatka]').val();
			var idWpisu = $(this).parents('tr').attr('data-id');
			zapiszNotatke(notatka, idWpisu);
			return false;	
		});
		
		$(document).on('click', 'input[name=akceptuj]' ,function(){
			var idWpisu = $(this).val();
			var akceptacja = ($(this).is(':checked')) ? 'akceptacja' : 'oczekuje';
			ajax("{{$urlZapiszAkceptacja}}" , potwierdzAkceptacja, { idWpisu: idWpisu, akceptacja: akceptacja }, 'POST', 'json' );
		});
		$(document).on('click', '.usunWpis' ,function(){
			var idWpisu = $(this).attr('data-id');
			usunWpis(idWpisu);
			return false;	
		});
		
		$(document).on('click', '.zmienCzas' ,function(){ zmienCzas($(this)); });
		$(document).on('click', 'a[klucz=login]' ,function(e){ wyswietlLogin(e, $(this)); return false; });
		 
		jest = 1;
	}
	
	$(document).ready(function(){
		
		$('.zatwierdzLog').on('click', function(){
			wyloguj($(this)); 
			return false;
		});
		
		$('.uzyjRealnyCzasLogowania').on('click', function(){
			wylogujReal($(this)); 
			return false;
		});
		
		sprawdzZaznaczWszystkie();
		
		$('.close-menu').on('click', function(){ $('#chmurka').hide(); });
		
		$('#zaznaczWszystkie').on('click', function(){
			
			var akceptacja = ($(this).is(':checked')) ? 'akceptacja' : 'oczekuje';
			var ilosc = $('input[name=akceptuj]').length;
			var i = 0;
			var idWpisu = [];
			$('input[name=akceptuj]').each(function(){
				i++;
				
				if(i != ilosc){
					
					if(akceptacja == 'akceptacja')
						$(this).attr('checked', true);
					else
						$(this).attr('checked', false);

					idWpisu.push($(this).val());
					
				}
			});
			
			ajax("{{$urlZapiszAkceptacja}}" , potwierdzAkceptacja, { idWpisu: idWpisu, akceptacja: akceptacja }, 'POST', 'json' );
			
		});
		
		$('input[name=dataStart]').timepicker(opts);
		$('input[name=dataStop]').timepicker(opts);
		
		$('.dodajWiersz').on('click', function(){
			var wpis = $(this).parents('tr');
			var idWpisu = wpis.attr('data-id');
			var data_start = $(this).parents('tr').find('.dataDzien').text();
			
			ajax("{{$linkDodajWpis}}" , dodajWierszWpisu, { data_start: data_start, idWpisuDoKopiowania: idWpisu }, 'POST', 'json' );
			return false;
		});
		 
		$('input[name=dataStart]').on('change', function(){ 
				zmienDataStart($(this));
		});
		
		
		$('input[name=dataStop]').on('change', function(){ 
				zmienDataStop($(this));
		});
		
		$('.prevWeek').on('click', function(){ ajax("{{$linkTydzienPrev}}" , potwierdzPobierzTydzien, {  }, 'POST', 'json' ); return false; });
		$('.nextWeek').on('click', function(){ ajax("{{$linkTydzienNext}}" , potwierdzPobierzTydzien, {  }, 'POST', 'json' ); return false; });
		
		$('.closePopup').on('click', function(){ $('.close').click();  return false; });
	
	});
	
	function wyloguj(obiekt)
	{
		var dataId = $('input[name=data-id]').val();
		var godzinyLogin = $('.bootstrap-timepicker-hour-login').val();
		var minutyLogin = $('.bootstrap-timepicker-minute-login').val();
		
		var godziny = $('.bootstrap-timepicker-hour-logout').val();
		var minuty = $('.bootstrap-timepicker-minute-logout').val();
		
		var idUzytkownika = $('input[name=id_uzytkownika]').val();
		var data = $('#data').val();
		
		var dane = {
			godziny: godziny, minuty: minuty, 
			godzinyLogin: godzinyLogin, minutyLogin: minutyLogin, 
			idUzytkownika:idUzytkownika,
			data: data,
			dataId: dataId,
		};
		ajax("{{$urlWyloguj}}", potwierdzWylogowany, dane, 'POST', 'json', true);
	}
	
	function wylogujReal(obiekt)
	{
		var dataIdWpisu = obiekt.attr('data-idWpis');
		var dataId = obiekt.attr('data-id');
		var idUzytkownika = obiekt.attr('data-user');
		var data = obiekt.attr('data-attr');
		
		
		var czasLogin = obiekt.parents('tr').find('input[name=godzinyStart]').val().split(':');
		var godzinyLogin = czasLogin[0];
		var minutyLogin = czasLogin[1];
		
		var czasLogout = obiekt.parents('tr').find('input[name=godzinyStop]').val().split(':');
		var godziny = czasLogout[0];
		var minuty = czasLogout[1];
		
		var dane = {
			godziny: godziny, minuty: minuty, 
			godzinyLogin: godzinyLogin, minutyLogin: minutyLogin, 
			idUzytkownika:idUzytkownika,
			data: data,
			dataId: dataId,
			relogin: 1,
			dataIdWpisu: dataIdWpisu,
		};
		
		ajax("{{$urlPrzeloguj}}", potwierdzWylogowany, dane, 'POST', 'json', true);
	}
	
	function potwierdzWylogowany(dane)
	{
		$('#chmurka').find('.close-menu').click();
		if(dane.usuniete.length)
		{
			var i;
			for(i = 0; dane.usuniete.length > i ; i++)
			{
				$('tr[data-id='+dane.usuniete[i]+']').remove();
			}
		}
		$('tr[data-id='+dane.dataId+']').after(dane.html);
		
		$('input[name=dataStart]').unbind('change');
		$('input[name=dataStop]').unbind('change');
		
		$('.numeryTygodnia').filter(function(){ return $(this).data("attr")   == dane.tydzien}).addClass('zaznaczonyTydzien').click();
		$('input[name=dataStart]').timepicker(opts);
		$('input[name=dataStop]').timepicker(opts);
		
		$('input[name=dataStart]').bind('change', function(){ zmienDataStart($(this)); });
		$('input[name=dataStop]').bind('change', function(){ zmienDataStop($(this)); } );
		
		wyszukiwarka();
	}
	
	function wyswietlLogin(e, obiekt)
	{
		var chmurka = $('#chmurka');
		
		var mouseX = e.pageX-210;
		var mouseY = 230;
		chmurka.css('left', mouseX);
		chmurka.css('top', mouseY);
		
		$('.bootstrap-timepicker-hour-login').val('7');
		$('.bootstrap-timepicker-minute-login').val('30');
		
		$('.bootstrap-timepicker-hour-logout').val('18');
		$('.bootstrap-timepicker-minute-logout').val('00');
		
		$('.zatwierdzLog').attr('data-action', 'login');
		chmurka.find('#data').val(obiekt.attr('data-attr'));
		chmurka.find('#data-id').val(obiekt.parents('tr').attr('data-id'));
		chmurka.show(100);
		
		return false;
	}
	
	function dodajWierszWpisu(dane)
	{
		var nowyWpis = $('#wpisPrzyklad').clone();
		nowyWpis.removeAttr('id');
		var kopiowanyWpis = $('tr[data-id='+dane.idWpisuDoKopiowania+']');
		nowyWpis.addClass(kopiowanyWpis.attr('class'));
		
		nowyWpis.attr('data-id', dane.idWpisu);
		
		$('tr[data-id='+dane.idWpisuDoKopiowania+']').after(nowyWpis);
		$('input[name=dataStart]').timepicker(opts);
		$('input[name=dataStop]').timepicker(opts);
		nowyWpis.find('input[name=dataStart]').bind('change', function(){ zmienDataStart($(this)); }).val(dane.godzinaStart);
		nowyWpis.find('input[name=dataStop]').bind('change', function(){ zmienDataStop($(this)); } ).val(dane.godzinaStop);
		nowyWpis.find('select[name=listaProduktow]').val(dane.produktId);
		nowyWpis.find('select[name=listaProduktow]').val(dane.produktId);
		nowyWpis.find('.minutyNowe').text(dane.godziny);
		nowyWpis.find('input[name=notatka]').text(dane.notatka);
		nowyWpis.find('input[name=akceptuj]').val(dane.idWpisu);
		nowyWpis.find('.usunWpis').attr('data-id', dane.idWpisu);
		nowyWpis.find('.zapiszNotatke').attr('data-id', dane.idWpisu);
		
		
		$('.numeryTygodnia').filter(function(){ return $(this).data("attr")   == dane.tydzien}).addClass('zaznaczonyTydzien').click();
		wyszukiwarka();
		return false;
	}
	
	function zmienDataStart(obiekt)
	{
		var idWpisu = obiekt.parents('tr').attr('data-id');
		var dataRodzaj = 'start';
		var godzinaStart = obiekt.val();
		ajax("{{$linkAktualizujWpis}}" , potwierdzAktualizujWpis, { idWpisu: idWpisu, dataRodzaj: dataRodzaj, data: godzinaStart  }, 'POST', 'json' );
	}
	function zmienDataStop(obiekt)
	{
		var idWpisu = obiekt.parents('tr').attr('data-id');
		var dataRodzaj = 'stop';
		var godzinaStop = obiekt.val();

		ajax("{{$linkAktualizujWpis}}" , potwierdzAktualizujWpis, { idWpisu: idWpisu, dataRodzaj: dataRodzaj, data: godzinaStop  }, 'POST', 'json' );
	}
	
	function aktualizujSumaGodzin()
	{
		var sumaGodzin = 0;
		$('.minutyNowe').each(function(){
			var val = parseFloat($(this).text());
			if(!isNaN(val))
			{
				sumaGodzin += parseFloat($(this).text());
			}
		});
		$('#sumaGodzin').text(sumaGodzin);
	}
	
	function potwierdzAktualizujWpis(dane)
	{
		if(dane.error == 1)
		{
			alert(dane.errorTxt);
		}
		else if(dane.error == 2)
		{
			$('tr[data-id='+dane.idWpisu+']').find('.minutyNowe').attr('style', 'color:red;').text('0');
		}
		else if(dane.godziny > 0 )
		{
			$('tr[data-id='+dane.idWpisu+']').find('.minutyNowe').removeAttr('style').text(dane.godziny);
			aktualizujSumaGodzin();
		}

	}
	
	function potwierdzPobierzTydzien(dane)
	{
		$('#oknoModalne').find('.modal-body').html(dane.html);
	}
	function zapiszNotatke(notatka, idWpisu)
	{
		 ajax("{{$urlZapiszNotatke}}" , potwierdzZapiszNotatke, { notatka: notatka, idWpisu: idWpisu }, 'POST', 'json' );
	}
	function potwierdzZapiszNotatke(dane)
	{
		alert(dane.info);
	}
	
	function potwierdzAkceptacja(dane)
	{
		if(dane.error)
		{
			alert(dane.errorTxt);
		}
		else
		{
			$('.numeryTygodnia').filter(function(){ return $(this).data("attr")   == dane.tydzien}).addClass('zaznaczonyTydzien').click();
			wyszukiwarka();
		}
	}
	
	function sprawdzZaznaczWszystkie()
	{
		var zaznaczWszystkie = 0;
		var ilosc = $('input[name=akceptuj]').length;
		var i = 0;
		var iZaznaczone = 0;
		$('input[name=akceptuj]').each(function(){
			i++;
			if(i != ilosc)	if($(this).is(':checked')) iZaznaczone++ ;
		});
		 
		if( iZaznaczone > 0 && (ilosc - 1) == iZaznaczone){ $('#zaznaczWszystkie').attr('checked', true); }
		
	}
	
	function usunWpis(idWpisu)
	{
		ajax("{{$urlUsunWpis}}" , potwierdzUsunWpis, { idWpisu: idWpisu }, 'POST', 'json' );
	}
	function potwierdzUsunWpis(dane)
	{
		if(dane.blad)
		{
			alert(dane.info);
		}
		else
		{
			$('tr[data-id='+dane.idWpisu+']').remove();
			aktualizujSumaGodzin();
		}
	}
	function zmienCzas(obiekt)
	{
		var akcja = obiekt.attr('data-action');
		var log = obiekt.attr('data-log');
		var godziny = parseInt($('.bootstrap-timepicker-hour-'+log).val());
		var minuty = parseInt($('.bootstrap-timepicker-minute-'+log).val());
		
		if(akcja == 'incrementHour')
		{
			if(godziny >= 23){ godziny = 0;  $('.bootstrap-timepicker-hour-'+log).val(minuty); return; }
			godziny = godziny+1;
			$('.bootstrap-timepicker-hour-'+log).val(godziny);
			
		}
		if(akcja == 'incrementMinute')
		{
			if(minuty >= 45){ minuty = 0;  $('.bootstrap-timepicker-minute-'+log).val(minuty); return; }
			minuty = minuty+5;
			$('.bootstrap-timepicker-minute-'+log).val(minuty);
		}
		if(akcja == 'decrementHour')
		{
			if(godziny <= 0){ $('.bootstrap-timepicker-hour-'+log).val(23); return; }
			godziny = godziny-1;
			$('.bootstrap-timepicker-hour-'+log).val(godziny);
		}
		if(akcja == 'decrementMinute')
		{
			if(minuty <= 0){ minuty = 45;  $('.bootstrap-timepicker-minute-'+log).val(minuty); return; }
			minuty = minuty-5;
			$('.bootstrap-timepicker-minute-'+log).val(minuty);
		}
		
	}
</script>
<div id="chmurka" style='display: none; width: 270px;'>
<a href='javascript:void(0)' class='close-menu fL'><i class="icon icon-remove"></i></a><br/>
<div class="bootstrap-timepicker-widget dropdown-menu timepicker-orient-left timepicker-orient-bottom open" style="position: relative; border: none; box-shadow: initial; margin-left: 20px; margin-top: -30px;">
<table>
	<tbody>
		<tr>
			<td style="border-right:1px solid black; padding: 10px;">
				<table >
					<tr>
						<td colspan="2">
							Login
						</td>
					</tr>
					<tr>
						<td><a href="#" class="zmienCzas" data-action="incrementHour" data-log="login"><i class="icon-chevron-up"></i></a></td>
						<td class="separator">&nbsp;</td><td>
							<a href="#" class="zmienCzas" data-action="incrementMinute" data-log="login"><i class="icon-chevron-up"></i></a>
						</td>
					</tr>
					<tr>
						<td>
							<input class="bootstrap-timepicker-hour-login" maxlength="2" type="text"></td> 
						<td class="separator">:</td>
						<td><input class="bootstrap-timepicker-minute-login" maxlength="2" type="text"></td> 
					</tr>
					<tr>
						<td><a href="#" class="zmienCzas" data-action="decrementHour" data-log="login"><i class="icon-chevron-down"></i></a></td>
						<td class="separator"></td><td><a href="#" class="zmienCzas" data-action="decrementMinute" data-log="login"><i class="icon-chevron-down"></i></a></td>
					</tr>
				</table>
			</td>
			<td style="padding: 10px;">
				<table >
					<tr>
						<td colspan="2">
							Logout
						</td>
					</tr>
					<tr>
						<td><a href="#" class="zmienCzas" data-action="incrementHour" data-log="logout"><i class="icon-chevron-up"></i></a></td>
						<td class="separator">&nbsp;</td><td>
							<a href="#" class="zmienCzas" data-action="incrementMinute" data-log="logout"><i class="icon-chevron-up"></i></a>
						</td>
					</tr>
					<tr>
						<td>
							<input class="bootstrap-timepicker-hour-logout" maxlength="2" type="text"></td> 
						<td class="separator">:</td>
						<td><input class="bootstrap-timepicker-minute-logout" maxlength="2" type="text"></td> 
					</tr>
					<tr>
						<td><a href="#" class="zmienCzas" data-action="decrementHour" data-log="logout" ><i class="icon-chevron-down"></i></a></td>
						<td class="separator"></td><td><a href="#" class="zmienCzas" data-action="decrementMinute" data-log="logout" ><i class="icon-chevron-down"></i></a></td>
					</tr>
				</table>
			</td>
		</tr>
	</tbody>
</table>
	<input type="hidden" name="id_uzytkownika" id="id_uzytkownika" value="{{$id_uzytkownika}}"/>
	<input type="hidden" name="data" id="data" value=""/>
	<input type="hidden" name="data-id" id="data-id" value=""/>
	<button class="btn btn-info zatwierdzLog" data-action="" ><i class="icon icon-ok"></i></button>
</div>
</div>
<h3>{{$tytul}}</h3>
<div class="formularz_grid" style="padding-top:10px; padding-bottom: 10px;">
	<form id="wyszukiwarka" class="form-inline" action="" method="post" name="no-focus-wyszukiwarka" enctype="multipart/form-data">
		<ul class="fL">
			<li class="fL">
				<div class="form-group">
					<label class="input_ok" for="szukaj">Change week </label>
					<button class="btn prevWeek" data-tydzien="{{$numerTygodniaPrev}}" ><i class="icon icon-backward"></i></button>
					<input class="form-control input-sm" type="text" value="{{$tydzienDaty}}" name="tydzien" />
					<button class="btn nextWeek" data-tydzien="{{$numerTygodniaNext}}" ><i class="icon icon-forward"></i></button>
				</div>
				<div class="clear"></div>
			</li>
			<li class="fL">
				<label class="input_ok" for="szukaj">Change workers: </label>
				<select name="pracownik" id="pracownik">
					{{BEGIN pracownik}}
					<option {{$selected}} value="{{$id_pracownika}}" >{{$nazwa_pracownika}} </option>
					{{END}}
				</select>
				<div class="clear"></div>
			</li>
			<li class="fL">
				<button class="btn btn-default closePopup"><i class="icon icon-group"></i></button>
				<div class="clear"></div>
			</li>
		</ul>
	</form>
	<div class="clear"></div>
</div>
 

<table  class="table table-striped table-bordered">
	<thead>
		<tr>
			<td>Date</td>
			<td>Products</td>
			<td>From</td>
			<td>To</td>
			<td>Hour</td>
			<td>Note</td>
			<td><input type="checkbox" name="" id="zaznaczWszystkie" /></td>
			<td></td>
		</tr>
	</thead>
	<tbody>
		{{BEGIN wpisTimelist}}
			<tr class="{{$klasa}}" data-id="{{$idWpisu}}" >
				<td> {{IF $dataDzien}}<a href="" class="dodajWiersz"><i class="icon icon-plus"></i></a> <span class="dataDzien">{{$dataDzien}}</span> {{END IF}} </td>
				<td>{{$realLoginLabel}}</td>
				<td>{{$start}}<input type="hidden" name="godzinyStart" value="{{$start}}" /></td>
				<td>{{$stopDzien}}<input type="hidden" name="godzinyStop" value="{{$stopDzien}}" /></td>
				<td>
					{{IF $realLoginLabel}}
					<input type="button" class="btn btn-info uzyjRealnyCzasLogowania" data-user="{{$idUzytkownika}}" data-idWpis="{{$idCzasRealnyLogowania}}" data-id="{{$idWpisu}}" data-attr="{{$dataDzien}}" value="{{$logLabel}}" ></input>
					{{END IF}}
				</td>
				<td></td>
				<td>{{$autoLogoutInfo}}</td>
				<td>
				<a class="btn tip-top  btn-success" href="" target="_self" klucz="login" data-attr="{{$dataDzien}}" data-original-title="Login user">
					<i class="icon-signin"></i>
				</a>
				</td>
			</tr>
			{{BEGIN wpisTimelistWypelniony}}
			<tr class="{{$klasa}}" data-id="{{$idWpisu}}" >
				<td> {{IF $dataDzien}}<a href="" class="dodajWiersz"><i class="icon icon-plus"></i></a> <span class="dataDzien">{{$dataDzien}}</span> {{END IF}} </td>
				<td>
					{{IF $pustyWiersz}} {{$inputProdukty}} {{END IF}}
				</td>
				<td>
					{{IF $pustyWiersz}} <input type="text" name="dataStart" value="{{$dataStart}}" />{{END IF}}
				</td>
				<td>
					{{IF $pustyWiersz}}<input type="text" name="dataStop" value="{{$dataStop}}" />{{END IF}}
				</td>
				<td>
					{{IF $pustyWiersz}}
					<span class="minutyNowe">
						{{$czasGodziny}}
					</span>
					{{END IF}}
				</td>
				<td>
					{{IF $pustyWiersz}}
					<input type="text" name="notatka" value="{{$notatka}}" />
					<a class="btn tip-top btn-info zapiszNotatke" data-id="{{$idWpisu}}" href="" target="_self" data-original-title="Add note">
						<i class="icon-ok"></i>
					</a>
					{{END IF}}
				</td>
				<td>
					{{IF $pustyWiersz}}<input type="checkbox" name="akceptuj" {{$checked}} value="{{$idWpisu}}" />{{END IF}}
				</td>
				<td>
					{{IF $pustyWiersz}}
					<a class="btn tip-top btn-danger usunWpis" data-id="{{$idWpisu}}" href="" target="_self" data-original-title="Delete">
						<i class="icon-remove"></i>
					</a>
					{{ELSE}}
					<a class="btn tip-top  btn-success" href="" target="_self" klucz="login" data-attr="{{$dataDzien}}" data-original-title="Login user">
						<i class="icon-signin"></i>
					</a>
					{{END IF}}
				</td>
			</tr>
			{{END}}
		{{END}}
	</tbody>
	<tfoot>
		<tr>
			<td colspan="4" style="text-align: right;">
				Sum
			</td>
			<td colspan="4" id="sumaGodzin">
				{{$sumaGodzin}}
			</td>
		</tr>
	</tfoot>
</table>
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
		<table style="width:20%;">
			<tr>
				<th>{{$produktNazwa}}</th>
				<th>{{$godzinyNazwa}}</th>
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
		<div style="display:none;" >
			<table>
				<tr class="" data-id="{{$idWpisu}}" id="wpisPrzyklad" >
					<td>  </td>
					<td>
						{{$inputProdukty}}
					</td>
					<td>
						<input type="text" name="dataStart" value="{{$dataStart}}" />
					</td>
					<td>
						<input type="text" name="dataStop" value="{{$dataStop}}" />
					</td>
					<td>
						<span class="minutyNowe">

						</span>
					</td>
					<td>
						<input type="text" name="notatka" value="{{$notatka}}" />
						<a class="btn tip-top btn-info zapiszNotatke" data-id="{{$idWpisu}}" href="" target="_self" data-original-title="Add note">
							<i class="icon-ok"></i>
						</a>
					</td>
					<td>
						<input type="checkbox" name="akceptuj" {{$checked}} value="{{$idWpisu}}" />
					</td>
					<td>
						<a class="btn tip-top btn-danger usunWpis" data-id="{{$idWpisu}}" href="" target="_self" data-original-title="Delete">
							<i class="icon-remove"></i>
						</a>
					</td>
				</tr>
			</table>
	</div>
{{END}}
{{BEGIN raporty}}
<div class="widget-box">
<div class="widget-title">
	{{$menuTop}}
</div>
<div class="widget-content">
	<table class="table table-striped table-bordered">
		<thead>
			<tr>
				<th>
					Report name
				</th>
				<th>
					Report description
				</th>
				<th>
					Action
				</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>Ferie</td>
				<td></td>
				<td><a class="btn tip-top " href="{{$linkRaportFerie}}" target="_self" klucz="ferie" data-original-title="Ferie">
						<i class="icon-search"></i>
					</a></td>
			</tr>
			<tr>
				<td>Egenmeldinger rapport</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Egenmelding barns sykdom</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Sykefravær/lege</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Overtid</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Nattarbeid</td>
				<td></td>
				<td>
					<a class="btn tip-top " href="{{$linkRaportNattarbeid}}" target="_self" klucz="Nattarbeid" data-original-title="Nattarbeid">
						<i class="icon-search"></i>
					</a>
				</td>
			</tr>
			<tr>
				<td>Antall arbeidsdager i perioden</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Betalt spisetid</td>
				<td></td>
				<td>
					<a class="btn tip-top " href="{{$linkRaportPrzerwy}}" target="_self" klucz="Betalt spisetid" data-original-title="Betalt spisetid">
						<i class="icon-search"></i>
					</a>
				</td>
			</tr>
			<tr>
				<td>Lønnsbehandling</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Lønnsart</td>
				<td></td>
				<td>
					<a class="btn tip-top " href="{{$linkRaportWyplata}}" target="_self" klucz="wyplata" data-original-title="Lønnsart">
						<i class="icon-search"></i>
					</a>
				</td>
			</tr>
			<tr>
				<td>Gjennomsnitt på 8 uker</td>
				<td></td>
				<td></td>
			</tr>
			<tr>
				<td>Årlig Gjennomsnittsberegning</td>
				<td></td>
				<td></td>
			</tr>
		</tbody> 
	</table>
</div>
</div>
{{END raporty}}

{{BEGIN grupoweDodawanie}}
<script type="text/javascript">
	 
	var dzial = 0;
		
	$(document).ready(function(){
		szukajStatus($('#status'));
		$('input[name=dataDo]').datepicker();
		$('input[name=dataOd]').datepicker();
		 $('#status').on('change', function(){ szukajStatus($(this)); });
		$('tr.wiersz').attr('attr-opcje', 0);
		
		$('select').select2();
		
		$("#filter").keyup(function(){
			var filter = $.trim($(this).val()), count = 0;
			if( ! $('#czyscWyniki').is('is:visible') && filter.length > 0)
			{
				$('#czyscWyniki').show();
			}
			if(filter.length == 0)
			{
				$('#czyscWyniki').hide();
			}
			$(".table tr[attr-opcje=0] .frazaSzukaj").each(function(){

				if($(this).text().search(new RegExp(filter, "i")) < 0)
				{
					$(this).parents('tr').fadeOut();
				}
				else
				{
					$(this).parents('tr').show();
					count++;
				}
			});

			var numberItems = count;

			$("#filter-count").text("{{$znaleziono_zamowien}}"+count);
	   });
		
		$('button[name=zapiszGrupowo]').on('click', function(){
			
			var idProdukt = $('select[name=listaProduktow]').val();
			var pracownicy = pobierzZaznaczonych();
			var dataOd = $('input[name=dataOd]').val();
			var dataDo = $('input[name=dataDo]').val();
		
			ajax("{{$urlZapiszProduktGrupowy}}" , potwierdzDodajWpis, {  pracownicy:pracownicy.join(','), dataOd: dataOd, dataDo: dataDo , produkt: idProdukt  }, 'POST', 'json' );
			
			return false;
			
		});
		
		$('#oddzial').on('change', function(){ szukajDzial($(this)); });
		$('.filterClose').on('click', function(){ wylaczFiltr($(this)); });
		$('.close-menu').on('click', function(){ $('#chmurka').hide(); });
                
		$('a[klucz=podglad]').on('click', function(){ 
			 modalAjax($(this).attr('href'), false, 'POST', {}); 
			 dopasujModala()
			 return false; 
		 });
		 
		$('a[klucz=dodaj]').on('click', function(){ 
			modalAjax($(this).attr('href'), false, 'POST', {});  
			dopasujModala()
			return false; 
		});
		 
	});
	function szukajStatus(obiekt)
	{
		if(obiekt.val() != 0)
		{
			$('#filtr_status').show();
			$('#filtr_status').text( $('#status option[value='+obiekt.val()+']').text() );
			status = $.trim(obiekt.val());

		}
		else
		{
			status = "";
			$('#filtr_status').hide();
		}

		wyszukiwarka();
	}
	function szukajDzial()
	{
		var obiekt = $('#oddzial');

		$('table.listaUzytkownikow tbody').children('tr').show();
		if(obiekt.val() > 0)
		{

			$('#filtr_dzial').show();
			$('#filtr_dzial').text( $('#oddzial option[value='+obiekt.val()+']').text() );

			dzial = $.trim(obiekt.val());

		}
		else
		{
			dzial = 0;
			$('#filtr_dzial').hide();

		}
		if(dzial > 0)
		{
			$('.dzialS[dzial-attr!='+dzial+']').parents('tr').attr('attr-opcje', 1).hide();
		}
		wyszukiwarka();
	}
	
	function potwierdzDodajWpis(dane)
	{
		if(dane.error)
		{
			 alertModal('Warning', dane.komunikat);
		}
		else
		{
			 alertModal('Info', dane.komunikat);
		}
	}
	    
	function pobierzZaznaczonych()
	{
		var listaZaznaczonych = []; 
		$('input[name=zaznacz]').each(function(){
			if($(this).is(':checked'))
				listaZaznaczonych.push($(this).val());
		});
		return listaZaznaczonych;
	}
	
	function wylaczFiltr(obiekt)
	{
		var id = obiekt.attr('id');
		 
		if(id == 'filtr_dzial'){ dzial = 0; $('#filtr_dzial').hide(); $('#oddzial').val(0).select2(); }
		
		wyszukiwarka();
	}
	
	function wyszukiwarka()
	{
		$(".table tr").attr('attr-opcje', 0).show();
		if(status != "" && status != 0)
		{
			$('.statusS[status-attr!='+status+']').parents('tr').attr('attr-opcje', 1).hide();
		}
		if(dzial > 0)
		{
			$('.dzialS[dzial-attr!='+dzial+']').parents('tr').attr('attr-opcje', 1).hide();
		}
		 
		
	}
	
</script>
<div class="widget-box">
<div class="widget-title">
	{{$menuTop}}
</div>
<div class="widget-box">
	<div class="formularz_grid" style="padding-top:10px;">
		<form id="wyszukiwarka" class="form-inline" action="" method="post" name="no-focus-wyszukiwarka" enctype="multipart/form-data">
		<ul class="fL">
			<li class="fL">
				<a href="{{$linkDodajUzytkownika}}" class="btn btn-warning">Add new User</a>
			</li>
			<li class="fL">
				<label class="input_ok" for="status" >{{$szukajStatus}} </label>
				<select name="status" id="status" >
					<option value="0">--select--</option>
					{{BEGIN status}}
					<option value="{{$status}}" {{$selected}} >{{$etykieta}}</option>
					{{END status}}
				</select>
				<div class="clear"></div>
			</li>
			<li class="fL">
				<label class="input_ok" for="szukaj" >{{$szukajOddzial}} </label>
				<select name="oddzial" id="oddzial" >
					<option value="0">--select--</option>
					{{BEGIN dzial}}
					<option value="{{$dzialId}}">{{$dzialNazwa}}</option>
					{{END dzial}}
				</select>
				<div class="clear"></div>
			</li>
			<li class="fL">
				<label class="input_ok label-szukaj" for="szukaj" >{{$szukajFraza}} </label> 
				<input class="input-szukaj" autofocus type="text" placeholder="{{$szukajFrazaPlaceholder}}" autocomplete="off" name="fraza" id="filter" value="" />
				<div class="clear"></div>
				 
				<div class="clear"></div>
				<span id="ilosc-wynikow" class="help-block"></span>
			</li>
		</ul>
		</form>
		<div class="clear"></div>
		<form id="wyszukiwarka" class="form-inline" action="" method="post" name="no-focus-wyszukiwarka" enctype="multipart/form-data">
			<ul class="fL">
				<li class="fL">
					<button name="zapiszGrupowo" class="btn btn-info" value="{{$zapiszLabel}}" >{{$zapiszLabel}}</button>
				</li>
				<li class="fL">
					<label class="input_ok" for="dodaj ferie" >{{$dataDoLabel}} </label>
					<div class="input-append">
						<input type="text" name="dataDo" required value="" autocomplete="off" id="dataDo" title="dd-mm-yyyy" data-date-format="dd-mm-yyyy" />
						<span class="add-on"><i class="icon-calendar"></i></span>
					</div>
				</li>
				<li class="fL">
					<label class="input_ok" for="dodaj ferie" >{{$dataOdLabel}} </label>
					<div class="input-append">
						<input type="text" name="dataOd" required value="" autocomplete="off" id="dataOd" title="dd-mm-yyyy" data-date-format="dd-mm-yyyy" />
						<span class="add-on"><i class="icon-calendar"></i></span>
					</div>
				</li>
				<li class="fL">
					<label class="input_ok" for="dodaj ferie" >{{$dodajFerieLabel}} </label>
					{{$selectProduktyGrupowe}}
				</li>
			</ul>
		</form>
		
		<div class="clear"></div>
		<div id='wybraneFiltry' style='padding: 10px; margin-left: 116px; display:none;' >
			{{$etykieta_filtry}} 
			<span class='badge badge-default filterClose cursorPointer' id='filtr_dzial' style="display:none;" >Department <span> x </span></span>
			<span class='badge badge-default filterClose cursorPointer' id='filtr_status' style="display:none;" >Status <span> x </span></span>
			<span class='badge badge-default filterClose cursorPointer' id='filtr_produkt' style="display:none;" >Product <span> x </span></span>
			<span class='badge badge-default filterClose cursorPointer' id='filtr_niezalogowany' style="display:none;" >Not login <span> x </span></span>
		</div>
		<div class="clear"></div>
	</div>
</div>
<div class="widget-box">
	<div class="widget-content nopadding">
		{{$grid}}
	</div>
</div>
</div>
{{END}}
{{BEGIN podgladDlugoterminowy}}
<table class="table table-striped table-bordered">
    <thead>
        
    </thead>
    <tbody>
        
    </tbody>
</table>
{{END}}

{{BEGIN dodajProduktDlugoterminowy}}
<script>
	
	if( jest == 0)
	{
		$(document).on('click', '.dataPelna' , function(){ 
			var data = $(this).attr('data-attr');
			modalAjax( "{{$linkSzczegolyDni}}", false, 'POST', { data: data} );  
			return false;
		});
		jest = 1;
	}
		
	$(document).ready(function(){
		
		$('.rok').on('click', function(){
			
			$('.rok').removeClass('active');
			$('.rok').parent('li').removeClass('active');
			
			$(this).addClass('active');
			$(this).parent('li').addClass('active');
			
			ajax($(this).attr('href') , potwierdzOdswierzKalendarz, {  }, 'POST', 'json' );
			return false;
		});
		
		
		$('.tip-top').tooltip({placement: 'top'});
		$('input[name=dataDo]').datepicker();
		$('input[name=dataOd]').datepicker();
		
		$('button[name=zapiszGrupowoNowy]').on('click', function(){
			
			var idProdukt = $('#produktDlugoterminowy').find('select[name=listaProduktow]').val();
			var dataOd = $('#produktDlugoterminowy').find('input[name=dataOd]').val();
			var dataDo = $('#produktDlugoterminowy').find('input[name=dataDo]').val();
		
			ajax("{{$urlZapiszProduktGrupowy}}" , potwierdzDodajWpis, { dataOd: dataOd, dataDo: dataDo , produkt: idProdukt  }, 'POST', 'json' );
			
			return false;
			
		});
	});
	
	function potwierdzOdswierzKalendarz(dane)
	{
		$('#kalendarz').html(dane.html);
	}
	
	function potwierdzDodajWpis(dane)
	{
		if(dane.error)
		{
			alertModal('Warning', dane.komunikat);
		}
		else
		{
			alertModal('Info', dane.komunikat);
			var rok = $('li.active').children('.rok').attr('name');
			console.log(rok);
			//ajax("{{$linkOdswierzKalendarz}}" , potwierdzOdswierzKalendarz, { rok: rok }, 'POST', 'json' );
		}
	}
</script>
 
<h4>{{$pracownikNazwa}} Card</h4>
<div class="widget-box">
	<div class="widget-title">
		<span class="icon"><i class="icon-plus icon"></i></span>
		<h5>Select product for {{$pracownikNazwa}}</h5>
	</div>
	<div class="widget-content">
		<div class="formularz_grid" style="padding-top:10px;">
		<form id="produktDlugoterminowy" class="form-inline" action="" method="post" name="no-focus-wyszukiwarka" enctype="multipart/form-data">
			 
				<div class="region_tresc">
					<ul class="fL">
						<li class="fL">
							<button name="zapiszGrupowoNowy" class="btn btn-info" value="{{$zapiszLabel}}" >{{$zapiszLabel}}</button>
						</li>
						<li class="fL">
							<label class="input_ok" for="dodaj ferie" >{{$dataDoLabel}} </label>
							<div class="input-append">
								<input type="text" name="dataDo" required value="" autocomplete="off" id="dataDo" title="dd-mm-yyyy" data-date-format="dd-mm-yyyy" />
								<span class="add-on"><i class="icon-calendar"></i></span>
							</div>
						</li>
						<li class="fL">
							<label class="input_ok" for="dodaj ferie" >{{$dataOdLabel}} </label>
							<div class="input-append">
								<input type="text" name="dataOd" required value="" autocomplete="off" id="dataOd" title="dd-mm-yyyy" data-date-format="dd-mm-yyyy" />
								<span class="add-on"><i class="icon-calendar"></i></span>
							</div>
						</li>
						<li class="fL">
							<label class="input_ok" for="dodaj ferie" >{{$dodajFerieLabel}} </label>
							{{$selectListaProduktowDlugoterminowych}}
						</li>
					</ul>
			</div>
		</form>
	</div>
	</div>
</div>
<div class="widget-box">						
	<div class="widget-title">
		<span class="icon"><i class="icon-calendar icon"></i></span>
		<h5>Calendar</h5>
	</div>
	<div class="widget-title">
		<ul class="nav nav-tabs">
			{{BEGIN rok}}
			<li class="{{$class}}">
				<a class="{{$class}} rok" name="rok" title="{{$rok}}" href="{{$link}}" >{{$rok}}</a>
			</li>
			{{END}}
		</ul>
	</div>
	<div class="widget-content">
		{{$kalendarz}}
		<div class="clear"></div>
	</div>
</div>
{{END}}

{{BEGIN kalendarz}}
<div class="calendar fc fc-ltr" id="kalendarz">
	{{BEGIN miesiac}}
	<table class="table table-striped table-bordered fL tabelaKalendarz" >
			<tbody>
			<tr ><th  colspan="7" >{{$miesiac}}</th></tr>
			<tr><th>mo</th><th>tu</th><th>we</th><th>th</th><th>fr</th><th>sa</th><th>su</th></tr>
				{{BEGIN tydzien}}
					<tr>
						{{BEGIN dzien}}
							<td style="background-color: {{$kolor}}"   >
								<span class="tip-top dataPelna" data-attr="{{$data_pelna}}"  style="cursor: pointer;" data-original-title="{{$nazwa_produktu}}" > {{$data}}  </span>
							</td>
						{{END}}
					</tr>
				{{END}}
			</tbody>
		</table>
	{{END}}
</div>
{{END}}
			
{{BEGIN zakladki}}
	<ul class="nav nav-tabs">
		<!--
			<li class="">
				<a class="tip-top " href="{{$urlListaUzytkownikow}}" name="Users list" data-original-title="Users list">Users list</a>
			</li>
		-->
			<li class="{{$klasaAktywnaIndex}}">
				<a class="tip-top {{$klasaAktywnaIndex}}" href="{{$urlDzien}}" name="This day" data-original-title="This day">Current day</a>
			</li>
			<li class="{{$klasaAktywnaTydzien}}">
				<a class="tip-top {{$klasaAktywnaTydzien}}" href="{{$urlTydzien}}" name="Timesheet" data-original-title="Timesheet">Timesheet</a>
			</li>
			<li class="{{$klasaAktywnaGrupa}}">
				<a class="tip-top {{$klasaAktywnaGrupa}}" href="{{$urlGrupoweDodawanie}}" name="Timesheet" data-original-title="Timesheet">Users list</a>
			</li>
			<li class="{{$klasaAktywnaRaport}}">
				<a class="tip-top {{$klasaAktywnaRaport}}" href="{{$urlRaporty}}" name="Timesheet" data-original-title="Timesheet">Reports</a>
			</li>
	</ul>
{{END}}

{{BEGIN szczegolyDnia}}
<table class="table table-striped table-bordered" >
	<thead>
		<tr>
			<th>Hours</th>
			<th>Product name</th>
			<th>Time</th>
		</tr>
	</thead>
	<tbody>
		{{BEGIN produkt}}
		<tr>
			<td>{{$godziny}}</td>
			<td>{{$nazwa_produktu}}</td>
			<td>{{$czas}}</td>
		</tr>
		{{END}}
	</tbody>
	<tfooter>
		<tr>
			<td></td>
			<td style="text-align:right;"><strong>Sum:</strong></td>
			<td>{{$sumaGodzin}}</td>
		</tr>
	</tfooter>
</table>
		<button class="btn btn-info" name="wstecz" id="wstecz">Back to list</button>
		<button class="btn btn-info" name="edycja" id="edycja">Edit this day</button>
		<script>
			$(document).ready(function(){
				$('#wstecz').on('click', function(){
					 
					modalAjax( "{{$linkKalendarz}}", false, 'POST', { } );  
					return false;
				});
				$('#edycja').on('click', function(){
					 
					modalAjax( "{{$linkEdycja}}", false, 'POST', { } );  
					return false;
				});
			});
		</script>
{{END}}

{{BEGIN raportSumaProduktow}}
<script>
	
	$(document).ready(function(){
		$('input[name=dataDo]').datepicker();
		$('input[name=dataOd]').datepicker();
	});
	
</script>
<div class="widget-box">
	<div class="widget-title">
		{{$menuTop}}
	</div>
	<div class="widget-content">
		
<div class="widget-box">
	<div class="formularz_grid" style="padding-top:10px;">
		<form id="wyszukiwarka" class="form-inline" action="" method="post" name="no-focus-wyszukiwarka" enctype="multipart/form-data">
		<ul class="fL">
			<li class="fL">
				<input type="submit" class="btn btn-info" name="zapisz" value="search" />
			</li>
			<li class="fL">
				<label class="input_ok" for="dodaj ferie" >{{$miesiacLabel}} </label>
				<div class="input-append">
					<select name="miesiac" id="miesiac">
						{{BEGIN miesiac}}
						<option value="{{$numer}}" {{$zaznaczony}} >{{$miesiac}}</option>
						{{END}}
					</select>
				</div>
			</li>
			<li class="fL">
				<label class="input_ok" for="dodaj ferie" >{{$dataDoLabel}} </label>
				<div class="input-append">
					<input type="text" name="dataDo" required value="{{$wartoscDataOd}}" autocomplete="off" id="dataDo" title="yyyy-mm-dd" data-date-format="yyyy-mm-dd" />
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>
			</li>
			<li class="fL">
				<label class="input_ok" for="dodaj ferie" >{{$dataOdLabel}} </label>
				<div class="input-append">
					<input type="text" name="dataOd" required value="{{$wartoscDataDo}}" autocomplete="off" id="dataOd" title="yyyy-mm-dd" data-date-format="yyyy-mm-dd" />
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>
			</li>
			<!--
			<li class="fL">
				<label class="input_ok" for="szukaj" >{{$szukajOddzial}} </label>
				<select name="oddzial" id="oddzial" >
					<option value="0">--select--</option>
					{{BEGIN dzial}}
					<option value="{{$dzialId}}">{{$dzialNazwa}}</option>
					{{END dzial}}
				</select>
			</li>
			<li class="fL">
				<label class="input_ok" for="szukaj">Change workers: </label>
				<select name="pracownik" id="pracownik">
					<option  value="null" > - select - </option>
					{{BEGIN pracownik}}
					<option {{$selected}} value="{{$id_pracownika}}" >{{$nazwa_pracownika}} </option>
					{{END}}
				</select>
				<div class="clear"></div>
			</li>
			-->
		</ul>
		</form>
		<div class="clear"></div>
		 
	</div>
</div>
		<a href="{{$urlRaporty}}" class="btn btn-info">Back raport list</a>
		<a href="{{$urlWyplata}}" class="btn btn-danger">Lønnsart</a>
		<table class="table table-bordered" >
			<thead>
				<tr>
					<th>Product name</th>
					<th>Sum hours</th>
				</tr>
			</thead>
			<tbody>
				{{BEGIN produkt}}
				<tr style="background-color:{{$kolor}}">
					<td>{{$nazwaProduktu}}</td>
					<td>{{$czas}}</td>
				</tr>
				{{END}}
			</tbody>
			<tfooter>
				<tr>
					<td style="text-align:right;"><strong>Sum:</strong></td>
					<td>{{$sumaGodzin}}</td>
				</tr>
			</tfooter>
		</table>
		<a href="{{$urlRaporty}}" class="btn btn-info">Back to list</a>
		<a href="{{$urlWyplata}}" class="btn btn-danger">Lønnsart</a>
	</div>
</div>
					
{{END}}

{{BEGIN raportWyplata}}
<div class="widget-box">
	<div class="widget-title">
		{{$menuTop}}
	</div>
	<div class="widget-content">
		<a href="{{$urlRaporty}}" class="btn btn-info">Back raport list</a>
		<a href="{{$urlListaProduktow}}" class="btn btn-info">Back product list</a>
		<a href="{{$urlRaportWyplataXls}}" class="btn btn-warning">Generate Xls</a>
		<table class="table table-bordered" >
			<thead>
				<tr>
					{{BEGIN naglowek}}
						<th data-klucz="{{$klucz}}">{{$nazwa}}</th>
					{{END}}
				</tr>
			</thead>
			<tbody>
				{{BEGIN uzytkownik}}
				<tr style="background-color:{{$kolor}}">
					{{BEGIN kolumna}}
					<td>
						{{$wartosc}}
					</td>
					{{END}}
					 
				</tr>
				{{END}}
			</tbody>
			<tfooter>
				<tr>
					{{BEGIN naglowekSuma}}
					<td>{{$wartosc}}</td>
					{{END}}
				</tr>
			</tfooter>
		</table>
	</div>
	
</div>
{{END}}

{{BEGIN raportFerie}}

<script>
	$(document).ready(function(){
		$("#filter").keyup(function(){
			var filter = $.trim($(this).val()), count = 0;
			if( ! $('#czyscWyniki').is('is:visible') && filter.length > 0)
			{
				$('#czyscWyniki').show();
			}
			if(filter.length == 0)
			{
				$('#czyscWyniki').hide();
			}
			$(".table tr .frazaSzukaj").each(function(){

				if($(this).text().search(new RegExp(filter, "i")) < 0)
				{
					$(this).parents('tr').fadeOut();
				}
				else
				{
					$(this).parents('tr').show();
					count++;
				}
			});

			var numberItems = count;

			$("#filter-count").text("{{$znaleziono_zamowien}}"+count);
	   });
	});
	
</script>
<div class="widget-box">
	<div class="widget-title">
		{{$menuTop}}
	</div>
	<div class="widget-box">
		<div class="widget-title" >
			<ul class="nav nav-tabs">
				{{BEGIN rok}}
				<li class="{{$active}}">
					<a class="rok" name="rok" title="{{$rok}}" class="{{$active}}" href="{{$link}}">{{$rok}}</a>
				</li>
				{{END}}
			</ul>
		</div>
	<div class="formularz_grid" style="padding-top:10px;">
		<form id="wyszukiwarka" class="form-inline" action="" method="post" name="no-focus-wyszukiwarka" enctype="multipart/form-data">
		<ul class="fL">
			<li class="fL">
				<label class="input_ok label-szukaj" for="szukaj" >{{$szukajFraza}} </label> 
				<input class="input-szukaj" autofocus type="text" placeholder="{{$szukajFrazaPlaceholder}}" autocomplete="off" name="fraza" id="filter" value="" />
				<div class="clear"></div>
				<span id="ilosc-wynikow" class="help-block"></span>
			</li>
		</ul>
		<div class="clear"></div>
		</form>
	</div>
</div>
	<div class="widget-content">
		<a href="{{$urlRaporty}}" class="btn btn-info">Back raport list</a>
		<table class="table table-bordered" >
			<thead>
				<tr>
					<th >User name</th>
					<th >Available ferie days</th>
					<th >Taken ferie days</th>
				</tr>
			</thead>
			<tbody>
				{{BEGIN uzytkownik}}
				<tr style="background-color:{{$kolor}}">
					 
					<td class="frazaSzukaj">
						{{$nazwa}}
					</td>
					 <td>
						{{$dostepneDni}}
					</td>
					<td>
						{{$wybraneDni}}
					</td>
					 
				</tr>
				{{END}}
			</tbody>
		</table>
	</div>
</div>
{{END}}

{{BEGIN nattarbeid}}
<script>
	
	$(document).ready(function(){
		$('input[name=dataDo]').datepicker();
		$('input[name=dataOd]').datepicker();
	});
	
</script>
<div class="widget-box">
	<div class="widget-title">
		{{$menuTop}}
	</div>
	<div class="widget-content">
		
<div class="widget-box">
	
	<div class="formularz_grid" style="padding-top:10px;">
		<form id="wyszukiwarka" class="form-inline" action="" method="post" name="no-focus-wyszukiwarka" enctype="multipart/form-data">
		<ul class="fL">
			<li class="fL">
				<input type="submit" class="btn btn-info" name="zapisz" value="search" />
			</li>
			<li class="fL">
				<label class="input_ok" for="dodaj ferie" >{{$miesiacLabel}} </label>
				<div class="input-append">
					<select name="miesiac" id="miesiac">
						{{BEGIN miesiac}}
						<option value="{{$numer}}" {{$zaznaczony}} >{{$miesiac}}</option>
						{{END}}
					</select>
				</div>
			</li>
			<li class="fL">
				<label class="input_ok" for="dodaj ferie" >{{$dataDoLabel}} </label>
				<div class="input-append">
					<input type="text" name="dataDo" required value="{{$wartoscDataDo}}" autocomplete="off" id="dataDo" title="yyyy-mm-dd" data-date-format="yyyy-mm-dd" />
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>
			</li>
			<li class="fL">
				<label class="input_ok" for="dodaj ferie" >{{$dataOdLabel}} </label>
				<div class="input-append">
					<input type="text" name="dataOd" required value="{{$wartoscDataOd}}" autocomplete="off" id="dataOd" title="yyyy-mm-dd" data-date-format="yyyy-mm-dd" />
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>
			</li>
		</ul>
	</div>
	<div class="widget-content">
		<a href="{{$urlRaporty}}" class="btn btn-info">Back raport list</a>
		<table class="table table-bordered" >
			<thead>
				<tr>
					<th >User name</th>
					<th> Nattarbeid hours</th>
				</tr>
			</thead>
			<tbody>
				{{BEGIN uzytkownik}}
				<tr style="background-color:{{$kolor}}">
					 
					<td class="frazaSzukaj">
						{{$nazwa}}
					</td>
					 <td>
						{{$godziny}}
					</td>
				</tr>
				{{END}}
			</tbody>
		</table>
	</div>
					
</div>
{{END}}


{{BEGIN raportPrzerwy}}
<script>
	
	$(document).ready(function(){
		$('input[name=dataDo]').datepicker();
		$('input[name=dataOd]').datepicker();
	});
	
</script>
<div class="widget-box">
	<div class="widget-title">
		{{$menuTop}}
	</div>
	<div class="widget-content">
		
<div class="widget-box">
	
	<div class="formularz_grid" style="padding-top:10px;">
		<form id="wyszukiwarka" class="form-inline" action="" method="post" name="no-focus-wyszukiwarka" enctype="multipart/form-data">
		<ul class="fL">
			<li class="fL">
				<input type="submit" class="btn btn-info" name="zapisz" value="search" />
			</li>
			<li class="fL">
				<label class="input_ok" for="dodaj ferie" >{{$miesiacLabel}} </label>
				<div class="input-append">
					<select name="miesiac" id="miesiac">
						{{BEGIN miesiac}}
						<option value="{{$numer}}" {{$zaznaczony}} >{{$miesiac}}</option>
						{{END}}
					</select>
				</div>
			</li>
			<li class="fL">
				<label class="input_ok" for="dodaj ferie" >{{$dataDoLabel}} </label>
				<div class="input-append">
					<input type="text" name="dataDo" required value="{{$wartoscDataDo}}" autocomplete="off" id="dataDo" title="yyyy-mm-dd" data-date-format="yyyy-mm-dd" />
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>
			</li>
			<li class="fL">
				<label class="input_ok" for="dodaj ferie" >{{$dataOdLabel}} </label>
				<div class="input-append">
					<input type="text" name="dataOd" required value="{{$wartoscDataOd}}" autocomplete="off" id="dataOd" title="yyyy-mm-dd" data-date-format="yyyy-mm-dd" />
					<span class="add-on"><i class="icon-calendar"></i></span>
				</div>
			</li>
		</ul>
	</div>
	<div class="widget-content">
		<a href="{{$urlRaporty}}" class="btn btn-info">Back raport list</a>
		<table class="table table-bordered" >
			<thead>
				<tr>
					<th >User name</th>
					<th> Nattarbeid hours</th>
				</tr>
			</thead>
			<tbody>
				{{BEGIN uzytkownik}}
				<tr style="background-color:{{$kolor}}">
					 
					<td class="frazaSzukaj">
						{{$nazwa}}
					</td>
					 <td>
						{{$godziny}}
					</td>
				</tr>
				{{END}}
			</tbody>
		</table>
	</div>
					
</div>
{{END}}