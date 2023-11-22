{{BEGIN index}}
	<div class="widget-box">
	{{$tabela_danych}}
	</div>
{{END}}

{{BEGIN historiaWiadomosci}}
<div class="widget-title">
	<span class="icon">
		<i class="icon icon-comments"></i>
	</span>
	<h5>{{$etykieta_naglowek}}</h5>
</div>
<div class="contact-page">
	<img rel="comm-{{$uid}}" data-original-title="{{$kontakt_nazwa_wyswietlania}}" width="60" alt="{{$kontakt_nazwa_wyswietlania}}" style="" class="tip-top fL margin" src="{{$zdjecie}}">
	<div class="fL margin">
		<h5>{{$etykieta_historia_kontaktow}}</h5>
		<h4>{{$kontakt_nazwa_wyswietlania}}</h4>
	</div>
	<div class="fR"><a href="javascript:zamknijKarteHistorii();" class="btn btn-info margin-right" style="margin-top: 30px">{{$etykieta_zamknij_historie}}</a></div>
	<div class="clear"></div>
</div>
<div class="historia">
	<div class="belka">
		<span class="icon fL">
			<i class="icon icon-comments"></i>
		</span>
		<h5 class="fL">{{$etykieta_naglowek}}</h5>
		<span class="fL margin zakresDat">{{$etykieta_od}} <var id="dataOd">{{$data_od}}</var> {{$etykieta_do}} <var id="dataDo">{{$data_do}}</var></span>
		<input type="text" id="historyFilter" class="fL margin margin-bottom" name="historyFilter" placeholder="{{$etykieta_placeholder}}"/>
		<span class="fL margin zakresDat"><a href="javascript:ladujStarsze({{$uid}});">{{$etykieta_starsze}}</a></span>
		<span id="historiaLicznik" title="" class="label label-info tip-left fR">0</span>
	</div>
	<div class="tresc">
		<table id="historiaTabela" class="historiaWiadomosci clear" width="100%">
		{{$wierszeHistorii}}
		</table>
	</div>
</div>


{{BEGIN wiersze}}
	{{BEGIN wiersz}}
	<tr id="{{$id}}">
		<td class="center">
			<div class="btn-group">
				<span href="#" class="btn typ"><i class="icon {{$ikona}}"></i> {{$typ}}</span>
				<span class="btn">{{$data}}</span>
			</div>
		</td>
		<td><div class="cropText">{{IF $url_preview_order}}<a href="{{$url_preview_order}}" onclick="modalAjax(this.href); komunikatorToggle(); return false;">{{$wo}}</a>{{END IF}}</div></td>
		<td class="text">{{$tresc}}</td>
		<td><span data-original-title="" class="label label-{{$klasa}} margin-right">{{$status}}</span></td>
		<td class="hidden"><span class="fraza_szukaj">{{$typ}} {{$data}} {{$wo}} {{$tresc}} {{$status}}"</span></td>
	</tr>
	{{END wiersz}}
	{{BEGIN pustyWiersz}}
	<tr  class="empty-row"><td>{{$etykieta_brak_wynikow}}</td></tr>
	{{END pustyWiersz}}
{{END wiersze}}


<script type="text/javascript">
	var pusty_wiersz = '<tr class="empty-row"><td colspan="5">{{$etykieta_brak_wynikow_filtr}}</td></tr>';
	$(document).ready(function(){
		$("#historiaLicznik").text($('#historiaTabela tr:not(".empty-row")').length);
	});
	$("#historyFilter").keyup(function(){
		var filter = $(this).val(), count = 0;
		$(".historiaWiadomosci tr .fraza_szukaj").each(function(){
			if($(this).text().search(new RegExp(filter, "i")) < 0)
			{	
				$(this).parents('tr').hide();
			}
			else
			{
				$(this).parents('tr').fadeIn();
				count++;
			}
		});
		$('#historiaTabela .empty-row').remove();
		if (count == 0)
			$('#historiaTabela').append(pusty_wiersz);


		$("#historiaLicznik").text(count);
   });
</script>
{{END historiaWiadomosci}}