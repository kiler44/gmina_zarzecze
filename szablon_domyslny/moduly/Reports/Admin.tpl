{{BEGIN podswietl}}
<script type="text/javascript">
	var wierszeKoloruj = {
				{{$podswietleniaWierszy}}
			};
</script>
{{END}}

{{BEGIN raportyPdf}}

<script type="text/javascript">
	
	$(document).ready(function(){
		$.each(wierszeKoloruj, function(val, text) {
				$('tr#wiersz_'+val+' > td').css("background", text);
			});
		
	})
	
</script>
<div class="widget-box">
	<a href="{{$lista_raportow_url}}" class="btn btn-primary absolute"><i class="icon icon-list-ul"></i> {{$lista_raportow_etykieta}}</a>
	{{$tabela}}
</div>
{{END}}

{{BEGIN raportyExcel}}
<script src="/_system/js/bootstrap-editable.min.js"></script>
<script type="text/javascript">
	
	$('body').on('keyup', '.input-medium', function(){
		$(this).val($(this).val().replace(',','.'));
	});
	$(document).ready(function(){
		$('#szukaj').click(function(){
			//$('#dataEdycji').val('');
		});
		$('.editable').editable({
			emptytext: '',
			mode: 'inline',
			pk: function(){
				return $(this).attr('id').replace('i-', '');
			},
			url: '{{$url_zapisz_godziny}}'
		});
		$('.editable').keyup(function(){
			alert($(this).val());
			$(this).val($(this).val().replace(',','.'));
		});
		$('.remove_user').click(function(){
			$('.mobile-loader').fadeIn("normal");
			
			$.ajax({
				url: '{{$url_usun_pracownika}}',
				type: 'POST',
				dataType: 'json',
				async: true,
				data: {'data': $(this).attr('id').replace('remove.', '')},
				success: function(dane) {
					if (dane.status == 'ok')
					{
						$('#szukaj').click();
					}
					else
					{
						alert('Brzydko');
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					var error = 'Write operation failed: '+xhr.status;
					if (thrownError != '') 
					{
						error += ', with error: '+thrownError+'<br/><br/>Server said: <br/><br/>'+xhr.responseText;
					}
					alertModal('AJAX request error' ,error);
				}
			});
		});
		$('.writeDay').click(function(){
			$('.mobile-loader').fadeIn("normal");
			$('#dataEdycji').val('');
			var dzien =  $(this).attr('id');
			$.ajax({
				url: '{{$url_zapisz_dzien}}',
				type: 'POST',
				dataType: 'json',
				async: true,
				data: {'data': dzien},
				success: function(dane) {
					if (dane.status == 'ok')
					{
						$('#szukaj').click();
					}
					else
					{
						alert('Brzydko');
					}
				},
				error: function (xhr, ajaxOptions, thrownError) {
					var error = 'Write operation failed: '+xhr.status;
					if (thrownError != '') 
					{
						error += ', with error: '+thrownError+'<br/><br/>Server said: <br/><br/>'+xhr.responseText;
					}
					alertModal('AJAX request error' ,error);
				}
			});
		});
		
		$('.editDay').click(function(){
			$('.mobile-loader').fadeIn("normal");
			$('#dataEdycji').val($(this).attr('data-original-title'));
			$('#szukaj').click();
		});
		
		$('#download').click(function(){
			$('#downloadForm input[type=hidden]').remove();
			$('.editDay.btn-primary').each(function(i){
				$('<input>').attr({
					type: 'hidden',
					name: 'daty[]',
					value: $(this).attr('data-original-title')
				}).appendTo('#downloadForm');
			});
			/**
			if ($('#not_ready:checked'))
			{
				$('.writeDay').each(function(){
					$('<input>').attr({
						type: 'hidden',
						name: 'daty[]',
						value: $(this).attr('id')
					}).appendTo('#downloadForm');
				});
			}
			*/
			$('#downloadForm').submit();
		});
		
		$('.tgl').click(function(){
			//alert('#cnt-'+$(this).attr('id').replace('toggle-', '')));
			var selektor = '#cnt-'+$(this).attr('id').replace('toggle-', '');
			if ($(selektor).is(':hidden'))
			{
				$(selektor).show();
				var $ikona = $(this).find('i');
				$ikona.removeClass('icon-arrow-down').addClass('icon-remove-sign');
			}
			else
			{
				$(selektor).hide();
				var $ikona = $(this).find('i');
				$ikona.removeClass('icon-remove-sign').addClass('icon-arrow-down');
			}
		});
	});
	</script>

	<div id="correctionsContainer" class="excelReport">
		<div class="widget-box inside">
			<div class="widget-title">
				<ul class="nav nav-tabs">
					{{BEGIN zakladka}}
					<li {{IF $active}}class="active"{{END}}>
						<a href="{{$url}}" name="{{$etykieta}}" class="">{{$etykieta}}</a>
					</li>
					{{END}}
				</ul>
			</div>
		</div>
		{{BEGIN downloadExcel}}
		<form method="POST" action="{{$download_url}}" id="downloadForm" enctype="multipart/form-data">
		 <!--<label style="position: absolute; top: 65px; right: 280px"><input type="checkbox" id="not_ready" name="not_ready"/> {{$etykieta_not_ready}}</label>--><button id="download" type="submit" form="downloadForm" class="btn btn-large btn-success right margin-right"><i class="icon icon-table"></i> {{$etykieta_download_excel}}</button>
		</form>
		{{END}}
		<div class="padding-sides">
			<div class="left">
				{{$form}}
			</div>
			<div id="komunikatyContainer" class="alert alert-info clear margin hidden" style="margin: 15px 20% -20px"></div>
			{{IF $dzien_wypelniony}}
			<h2 class="clear margin-top-30">{{$etykieta_wypelnione_dni}}</h2>
			<ul class="editFilled">
				{{BEGIN dzien_wypelniony}}
				<li class="fL margin"><button class="btn {{IF $dane_ok}}btn-primary{{ELSE}}btn-danger{{END IF}} btn-medium editDay tip-top" title="{{$title}}"><i class="icon icon-calendar"></i> {{$data}} <i class="icon icon-edit-sign margin-left"></i></button></li>
				{{END}}
				<li style="clear: both"></li>
			</ul>
			{{END IF}}
			
			{{IF $dzien}}<h2 class="clear margin-top-30">{{$etykieta_do_wypelnienia_dni}}</h2>{{END IF}}
			{{BEGIN dzien}}
			<div class="clear no-margin" id="container-{{$data}}">
				<h4 style="padding-bottom: 8px; padding-top: 8px"><i class="icon icon-calendar"></i> {{$data}} ({{$dzien_tygodnia}}) <button class="btn btn-success btn-medium fR writeDay margin-right" id="{{$data_id}}"><i class="icon icon-save"></i> {{$etykieta_zapisz_dzien}}</button></h4>
				{{BEGIN team}}
				<div class="widget-box" style="width: 32.99%; float: left; clear: none">
					<div class="widget-title">
						<span class="icon">
							<i class="icon-truck"></i>
						</span>
						<h5>{{$team}}</h5>
						{{IF $ukrytych}}<button class="tgl fR margin btn-small btn-info tip-left" style="margin-bottom: -2px; width: 35px" id="toggle-{{$data}}-{{$team}}" title="{{$etykieta_pokaz_ukrytych_pracownikow}}"><i class="icon-arrow-down"></i></button>{{END IF}}
					</div>
					<div class="widget-content nopadding">
						<table class="table table-bordered table-striped table-hover">
							<tbody>
								{{BEGIN pracownik}}
								<tr>
								<td>{{$pracownik}} <button class="btn-mini btn-danger fR margin-right remove_user tip-left" title="{{$etykieta_usun_pracownika}}" id="remove.{{$data}}.{{$id_user}}.{{$id_team}}"><i class="icon-remove"></i></button></td>
								<td><div id="hours.{{$data}}.{{$id_user}}.{{$id_team}}" class="editable editable-click tip-top" title="{{$etykieta_domyslne_godziny}}">{{$wartosc_godziny}}</div></td>
								<td><div id="pause.{{$data}}.{{$id_user}}.{{$id_team}}" class="editable editable-click tip-top" title="{{$etykieta_domyslne_pauza}}">{{$wartosc_pauza}}</div></td>
								<td><div id="overtime.{{$data}}.{{$id_user}}.{{$id_team}}" class="editable editable-click tip-top" title="{{$etykieta_domyslne_nadgodziny}}">{{$wartosc_nadgodziny}}</div></td>
								</tr>
								{{END}}
							</tbody>
						</table>
					</div>
					{{IF $ukrytych}}
					<div class="widget-content nopadding" style="display: none" id="cnt-{{$data}}-{{$team}}">
					<table class="table table-bordered table-striped table-hover">
						<tbody>
							{{BEGIN pracownik_ukryty}}
							<tr>
							<td>{{$pracownik}} <button class="btn-mini btn-danger fR margin-right remove_user" title="{{$etykieta_usun_pracownika}}" id="remove.{{$data}}.{{$id_user}}.{{$id_team}}"><i class="icon-remove"></i></button></td>
							<td><div id="hours.{{$data}}.{{$id_user}}.{{$id_team}}" class="editable editable-click tip-top" title="{{$etykieta_domyslne_godziny}}">{{$wartosc_godziny}}</div></td>
							<td><div id="pause.{{$data}}.{{$id_user}}.{{$id_team}}" class="editable editable-click tip-top" title="{{$etykieta_domyslne_pauza}}">{{$wartosc_pauza}}</div></td>
							<td><div id="overtime.{{$data}}.{{$id_user}}.{{$id_team}}" class="editable editable-click tip-top" title="{{$etykieta_domyslne_nadgodziny}}">{{$wartosc_nadgodziny}}</div></td>
							</tr>
							{{END}}
						</tbody>
					</table>
					</div>
					{{END IF}}
				</div>
				{{END}}
			</div>
			{{END}}
		</div>
	</div>
{{END}}

{{BEGIN test}}
<a href="javascript:getData();">get data</a>
<div id="myIF" style="width: 100%; height: 600px"></div>
<script type="text/javascript">
	 
</script>
{{END}}

{{BEGIN indexZarzadzanie}}
<div class="widget-box">
	<!--<div class="widget-title"><a href="{{$link_dodaj}}" class="btn btn-info" style="display: inline-block; margin: 10px" title="{{$etykieta_dodaj}}"><i class="icon-plus"></i> {{$etykieta_dodaj}}</a></div>!-->
	{{$tabela_danych}}
</div>
{{END}}

{{BEGIN dodaj}}
	{{$form}}
{{END}}

{{BEGIN lista}}
	<div class="widget-box">

		
		<div class="widget-title">
			<ul class="nav nav-tabs">
				{{BEGIN zakladka}}
				<li id="zakladka_tytul_{{$id_raportu}}" class="zakladka_tytul {{$klasa}}" rel="{{$id_raportu}}">
					<a href="#raport-{{$id_raportu}}" id="raport-{{$id_raportu}}_tab">{{$etykieta}}</a>
				</li>
				{{END}}
			</ul>
		</div>
	
	{{BEGIN grupa}}
		<div class="widget-content nopadding">
			<div class="formularz_zakladka">
				<div id="raport-{{$id_raportu}}_tresc" class="zakladka_tresc clear {{$klasa}}">
				{{$tabela}}
				</div>
			</div>
		</div>
	{{END}}
	</div>
	<script>
		$(document).ready(function () {
			$('.zakladka_tytul').live('click', function () {
				$('.grupaRaportow').addClass('hidden');
				$('.zakladka_tytul').removeClass('active');

				$('#grupaRaportow_' + $(this).attr('rel')).removeClass('hidden');
				$(this).addClass('active');
			});

			if (window.location.hash != '')
			{
				$('#zakladka_tytul_' + parseInt(window.location.hash.replace('#', ''))).click();
			}
		});
	</script>
{{END}}

{{BEGIN podglad}}

	<div>
		{{BEGIN przycisk_csv}}
			<a class="buttonSet buttonLight" href="{{$link}}" style="float:left; margin:10px;">{{$etykieta}}</a>
		{{END}}
		<a class="buttonSet buttonRed" href="{{$link_powrot}}" style="float:right;">{{$etykieta_powrot}}</a>
	</div>
	<div id="dashboard" class="">
	{{$filtry}}
	{{$tabela}}
	</div>

{{END}}

{{BEGIN wykres}}
<div class="widget-box">
	<div class="widget-title">
		{{BEGIN przycisk_csv}}
			<!--<a class="buttonSet buttonLight" href="{{$link}}" style="float:left; margin-right:10px;">{{$etykieta}}</a>-->
			<a onclick="return false;" class="btn btn-primary btn-success margin" href="{{$link}}" id="pobierzCsvOgraniczony" style="float:left; margin-right:10px;"><i class="icon icon-download"></i> {{$etykieta}}</a>
		{{END}}
		<a class="btn btn-info margin" href="{{$link_powrot}}" style="float:right;"><i class="icon icon-backward"></i> {{$etykieta_powrot}}</a>

		{{BEGIN przycisk_filtry}}
			<a class="btn btn-info margin" href="{{$link}}" style="float:right; margin-right:10px;"><i class="icon icon-filter"></i> {{$etykieta}}</a>
		{{END}}
	</div>
{{$tresc}}
</div>
{{END}}

{{BEGIN filtryPoczatkowe}}
	{{$formularz}}
{{END}}