<div>
	<div class="fL" style="margin-right: 30px;" >
		Data start : 
		<div class="input-append">
			<input type="text" name="{{$nazwa}}" value="{{$wartoscStart}}" autocomplete="off" id="{{$nazwa}}_start" title="dd-mm-yyyy" data-date-format="{{$format_daty}}" />
			<span class="add-on"><i class="icon-calendar"></i></span>
		</div>
	</div>
	<div class="fL" style="margin-right: 30px;" >
		Data stop:
		<div class="input-append">
			<input type="text" name="{{$nazwa}}" value="{{$wartoscStop}}" autocomplete="off" id="{{$nazwa}}_stop" title="dd-mm-yyyy" data-date-format="{{$format_daty}}" />
			<span class="add-on"><i class="icon-calendar"></i></span>
		</div>
	</div>
	<div class="fL" style="margin-right: 30px;" >
		Wage
		<input type="text" name="{{$nazwa}}_stawka" value="{{$wartoscStawka}}" style="width: 190px;" id="{{$nazwa}}_stawka" />
	</div>
	<div class="fL">
		<a class="{{$nazwa}}_dodajStawke btn btn-info" ><i class="icon icon-plus"></i></a>
	</div>
	<div class="{{$nazwa}}_error fL" style="display:none; width: 100%;">
		<span class="error" style="color:#ff0000; ">Wrong data range or wage is empty</span>
	</div>
</div>
<div style="margin-top:40px;">
	<table class="table table-striped table-bordered {{$nazwa}}_tabela" style="width:inherit;" >
		<thead>
		<tr>
			<th style="width:260px; text-align: left;" >From</th>
			<th style="width:260px; text-align: left;" >To</th>
			<th style="width:260px; text-align: left;" >Weight</th>
			<th style="width:260px; text-align: left;" >Action</th>
		</tr>
		</thead>
		<tbody>
			{{BEGIN stawkaLista}}
			<tr>
				<td style="border-top: 1px solid #ccc;" >{{$data_start}}</td>
				<td style="border-top: 1px solid #ccc;">{{$data_stop}}</td>
				<td style="border-top: 1px solid #ccc;">{{$stawka}}</td>
				<td style="border-top: 1px solid #ccc;">
					<a  class="btn btn-error {{$nazwa}}_usunStawke" stawka-id="{{$idStawki}}" title="delete" ><i class="icon icon-minus"></i></a>
					<a  class="btn btn-error {{$nazwa}}_aktualizujStawke" stawka-id="{{$idStawki}}" title="update in timelist" ><i class="icon icon-refresh"></i></a>
				</td>
			</tr>
			{{END}}
		</tbody>
		<tfoot></tfoot>
	</table>
</div>
<script type="text/javascript">
var wiersz = '<tr><td style="border-top: 1px solid #ccc;" >{DATA_START}</td>\n\
				<td style="border-top: 1px solid #ccc;">{DATA_STOP}</td>\n\
				<td style="border-top: 1px solid #ccc;">{STAWKA}</td>\n\
				<td style="border-top: 1px solid #ccc;">\n\
					<a  class="btn btn-error {{$nazwa}}_usunStawke" title="delete" stawka-id="{ID}" ><i class="icon icon-minus"></i></a>\n\
					<a  class="btn btn-error {{$nazwa}}_aktualizujStawke" stawka-id="{ID}" title="update in timelist" ><i class="icon icon-refresh"></i></a>\n\
				</td></tr>';
 
	$(document).on('click', '.{{$nazwa}}_usunStawke', function(e){ var idUsun = $(this).attr('stawka-id'); potwierdzenieModal1('Are You sure You want delete this item?', 'Confirm', '{{$nazwa}}usunWiersz(\''+idUsun+'\')'); });
	$(document).on('click',  '.{{$nazwa}}_aktualizujStawke', function(e){ var idUsun = $(this).attr('stawka-id'); potwierdzenieModal1('Are You sure You want update wage in this data range ?', 'Confirm', '{{$nazwa}}aktualizujStawke(\''+idUsun+'\')'); });
	
	$(document).ready(function(){
		
		$('.{{$nazwa}}_dodajStawke').on('click', function(){
			$('.{{$nazwa}}_error').hide();
			{{$nazwa}}dodajWiersz();
		});
	 
		
		$( "#{{$nazwa}}_start" ).datepicker({
			weekStart: 1,
			{{$datepicker_cfg}}
		}).on('changeDate', function(ev){
								$("#{{$nazwa}}").change();
						});
						
		$( "#{{$nazwa}}_stop" ).datepicker({
			weekStart: 1,
			{{$datepicker_cfg}}
		}).on('changeDate', function(ev){
								$("#{{$nazwa}}").change();
						});
	});
	
	function {{$nazwa}}dodajWiersz()
	{
		var dataStart = $('#{{$nazwa}}_start').val();
		var dataStop = $('#{{$nazwa}}_stop').val();
		var stawka = $('#{{$nazwa}}_stawka').val();
		
		if(dataStart != '' && parseInt(stawka) > 0 )
		{
			
			var dataStartO = new Date(dataStart);
			if(dataStop != '')
			{
				var dataStopO = new Date(dataStop);
				if(dataStopO.getTime() < dataStartO.getTime())
				{
					$('.{{$nazwa}}_error').show();
					return false;
				}
			}
		 
			ajax("{{$urlDodajStawke}}" , potwierdzStawkaDodana, { idUzytkownika: {{idUzytkownika}}, dataStart: dataStart, dataStop: dataStop, stawka: stawka }, 'POST', 'json' );
		}
		else
		{
			$('.{{$nazwa}}_error').show();
			return false;
		}
	}
	
	function potwierdzStawkaDodana(dane)
	{
		if(dane.error)
		{
			alert(dane.errorMsg);
		}
		else
		{
			if(dane.dataStop == '')
			{
				var dataStop = '<i class="icon icon-arrow-right"></i>';
			}
			else
			{
				var dataStop = dane.dataStop;
			}
			
			var znajdz = [ '{DATA_START}', '{DATA_STOP}', '{STAWKA}', '{ID}'];
			var zamien = [dane.dataStart, dane.dataStop, dane.stawka, dane.id];

			var zamienionyWiersz = wiersz.replaceArray(znajdz, zamien);
			$('.{{$nazwa}}_tabela').find('tbody').append(zamienionyWiersz);
		}
	}
	
	function {{$nazwa}}usunWiersz(idUsun)
	{
		ajax("{{$urlUsunStawke}}" , potwierdzUsunStawke, { idUzytkownika: {{idUzytkownika}}, idStawki: idUsun }, 'POST', 'json' );
		$('.modal-header').children('.close').click();
	}
	
	function potwierdzUsunStawke(dane)
	{
		if(dane.error)
		{
			alert('Something is wrong with data saved');
		}
		else
		{
			var przycisk = $('.{{$nazwa}}_usunStawke[stawka-id='+dane.id+']');
			przycisk.parents('tr').remove();
		}
	}
	
	function {{$nazwa}}aktualizujStawke(idWpisu)
	{
		ajax("{{$urlAktualizujStawke}}" , potwierdzStawkaZaktualizowana, { idWpisu: idWpisu }, 'POST', 'json' );
	}
	
	function potwierdzStawkaZaktualizowana(dane)
	{
		if(dane.error)
		{
			alert('Something is wrong with data saved');
		}
			
		$('.modal-header').children('.close').click();
	}
	
</script>