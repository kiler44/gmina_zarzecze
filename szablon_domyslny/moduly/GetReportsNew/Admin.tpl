{{BEGIN index}}
<script>
	$(document).ready(function () {
		$("#filter").keyup(function(){
				var filter = $.trim($(this).val()), count = 0;
			
				$(".wiersz > td").children('span').children('.fraza_szukaj').each(function(){
					if($(this).text().search(new RegExp(filter, "i")) < 0)
					{
						$(this).parents('.wiersz').fadeOut();
					}
					else
					{
						$(this).parents('.wiersz').show();
						count++;
					}
				});
				
				var numberItems = count;
				$("#filter-count").show();
				$("#filter-count").text("{{$znaleziono_zamowien}}"+count);
		   });
		});
</script>
	<div class="widget-box">
		<div class="widget-title">
			<span class="icon"><i class="icon-legal"></i></span> <h5>{{$projektyZApartamentamiEtykieta}}</h5>
		</div>
	
	<div class="widget-content nopadding" >
		<div class="formularz_grid">
			<form id="live-search" class="form-inline" action="" method="post" name="live-search" enctype="multipart/form-data">
				<ul>
					 
					<li>
						<label for="filter" class="input_ok ">{{$szukajProjektEtykieta}} </label>
						<span class="formularz_opis"></span>
						<input type="text" style="width:500px;" name="filter" id="filter" value=""  autocomplete="off" class="long" />
						<div id="filter-count" class="no-shadow" style="display: none;">{{$znaleziono_zamowien}} {{$ilosc_znalezionych}}</div>
					</li>
				</ul>
			</form>
		</div>
		{{$grid}}
	</div>
	</div>
{{END index}}

{{BEGIN listaApartamentow}}
<script>
	var sprawdzony = 2;
	$(document).ready(function () {
		var status = [];
		
		
		$('.checkboxSprawdzony').on('click', function(){
			
			$("#filter").val('');
			sprawdzony = $(this).val();
			if(status.length > 0)
			{
				filtrujStatusy(status);
			}
			else
			{
			  if(sprawdzony == 2)
			  {
				  $('.wiersz').show();
			  }
			  else if(sprawdzony == 1)
			  {
				  $('.wiersz[data-akceptacja=0]').hide();
				  $('.wiersz[data-akceptacja=1]').show();
			  }
			  else if(sprawdzony == 0)
			  {
				  $('.wiersz[data-akceptacja=1]').hide();
				  $('.wiersz[data-akceptacja=0]').show();
			  }
			  else
			  {
				  $('.wiersz').show();
			  }
			}
			 
			
		});
		
		$('.akceptacjaGet').on('click', function(){
			var id = $(this).val();
			var akceptacja = $(this).is(':checked');
			
			var dane = { idApartamentu: id, akceptacja:akceptacja};
			ajax("{{$linkAkceptacjaGet}}", potwierdzAkceptacja, dane, 'POST', 'json');
		});
		
		
		$('.checkboxStatus').on('click', function(){
			status = [];
			$('.checkboxStatus').each(function(){
				if($(this).is(':checked'))
				{
					status.push($(this).val());
				}
			});
			filtrujStatusy(status);
		});
		
		$('#exportXls').on('click', function(){
			
			if(status.length)
			{
				var url = $(this).attr('href')+'&statusy='+status.join(',')+'&sprawdzony='+sprawdzony;
				location.href= url;
			}
			else
			{
				location.href = $(this).attr('href')+'&sprawdzony='+sprawdzony;
			}
			return false;
		});
		
		$('.statusDone').children('td').css('background-color', '{{$statusDone}}');
		$('.statusInProgress').children('td').css('background-color', '{{$statusInProgress}}');
		$('.statusNotDone').children('td').css('background-color', '{{$statusNotDone}}');
		
		$("#filter").keyup(function(){
				var filter = $.trim($(this).val()), count = 0;
			
				$(".wiersz > td").children('span').children('.fraza_szukaj').each(function(){
					/*
					if(status.length)
					{
						if($.inArray($(this).parents('.wiersz').attr('class').replace('wiersz nieparzysty ', '').replace('wiersz parzysty ', ''), status) > -1)
						{
							if($(this).text().search(new RegExp(filter, "i")) < 0)
							{
								$(this).parents('.wiersz').fadeOut();
							}
							else
							{
								$(this).parents('.wiersz').show();
								count++;
							}
						}
					}
					else
					{
						if($(this).text().search(new RegExp(filter, "i")) < 0)
						{
							$(this).parents('.wiersz').fadeOut();
						}
						else
						{
							$(this).parents('.wiersz').show();
							count++;
						}
					}
					*/
					if($(this).text().search(new RegExp(filter, "i")) < 0)
					{
						$(this).parents('.wiersz').fadeOut();
					}
					else
					{
						if(sprawdzFiltryDlaWiersza($(this).parents('.wiersz')))
						{
							$(this).parents('.wiersz').show();
							count++;
						}
						else
						{
							$(this).parents('.wiersz').fadeOut();
						}
						
					}
				});
				
				var numberItems = count;
				$("#filter-count").show();
				$("#filter-count").text("{{$znaleziono_zamowien}}"+count);
		   });
		
		});
		
		function potwierdzAkceptacja(dane)
		{
			if(dane.blad)
			{
				alertModal('error', dane.komunikat);
			}
			else
			{
				var akceptacja = (dane.akceptacja) ? 1 : 0;
				$('#wiersz_'+dane.id).attr('data-akceptacja', akceptacja);
			}
			
		}
		
		function sprawdzFiltryDlaWiersza(wiersz)
		{
			
			if(status.length > 0)
			{
				if($.inArray(wiersz.attr('class').replace('wiersz nieparzysty ', '').replace('wiersz parzysty ', ''), status) > -1)
				{
					if(sprawdzony == 2)
					{
						return true;
					}
					else if(sprawdzony == 1)
					{
						if(wiersz.attr('data-akceptacja') == 1)
						{
							return true;
						}
						else
						{
							return false;
						}
					}
					else if(sprawdzony == 0)
					{
						if(wiersz.attr('data-akceptacja') == 0)
						{
							return true;
						}
						else
						{
							return false;
						}
					}

				}
				else
					return false
			}
			else
			{
				if(sprawdzony == 2)
				{
					return true;
				}
				else if(sprawdzony == 1)
				{
					if(wiersz.attr('data-akceptacja') == 1)
					{
						return true;
					}
					else
					{
						return false;
					}
				}
				else if(sprawdzony == 0)
				{
					if(wiersz.attr('data-akceptacja') == 0)
					{
						return true;
					}
					else
					{
						return false;
					}
				}
				else
				{
					return true;
				}
			}
			
		}
		
		function filtrujStatusy(status)
		{
			$("#filter").val('');
			if(status.length > 0)
			{
				$(".wiersz").each(function(){

					if($.inArray($(this).attr('class').replace('wiersz nieparzysty ', '').replace('wiersz parzysty ', ''), status) > -1)
					{
						if(sprawdzony == 2)
						{
							$(this).show(); 
						}
						else if(sprawdzony == 1)
						{
							if($(this).attr('data-akceptacja') == 1)
							{
								$(this).show();
							}
							else
							{
								$(this).hide();
							}
						}
						else if(sprawdzony == 0)
						{
							if($(this).attr('data-akceptacja') == 0)
							{
								$(this).show();
							}
							else
							{
								$(this).hide();
							}
						}
						
					}
					else
						$(this).hide();

				});
			}
			else
			{
				$(".wiersz").show();
			}
		}
		
		 
		
		
</script>
<div class="widget-box">
		<div class="widget-title">
			<span class="icon"><i class="icon-legal"></i></span> <h5>{{$listaApartamentowNaglowek}}</h5>
		</div>
		<div class="widget-content nopadding" >
			<div class="formularz_grid">
			<form id="live-search" class="form-inline" action="" method="post" name="live-search" enctype="multipart/form-data">
				<ul>
					<li>
						<a href="{{$listaProjektowLink}}" class="btn btn-info">{{$powrotDoListaProjektowEtykieta}}</a>
					</li>
					<li>
						<a href="{{$xlsExportLink}}" id="exportXls" class="btn btn-success">{{$xlsExportEtykieta}}</a>
					</li>
					<li>
						<label for="filter" class="input_ok ">{{$statusyEtykieta}} </label>
						{{$etykietaNew}} <input type="checkbox" class="checkboxStatus" name="new" value="statusNew" />
						{{$etykietaDone}} <input type="checkbox" class="checkboxStatus" name="done" value="statusDone" />
						{{$etykietaNotDone}} <input type="checkbox" class="checkboxStatus" name="not_done" value="statusNotDone" />
						{{$etykietaInProgress}} <input type="checkbox" class="checkboxStatus" name="in_progress" value="statusInProgress" />
					</li>
					<li>
						<label for="filter" class="input_ok ">{{$sprawdzonyEtykieta}} </label>
						{{$sprawdzony}} <input type="radio" class="checkboxSprawdzony" name="sprawdzony" value="1" />
						{{$nieSprawdzony}} <input type="radio" class="checkboxSprawdzony" name="sprawdzony" value="0" />
						All <input type="radio" class="checkboxSprawdzony" checked="checked" name="sprawdzony" value="2" />
					</li>
					<li>
						<label for="filter" class="input_ok ">{{$szukajProjektEtykieta}} </label>
						<span class="formularz_opis"></span>
						<input type="text" style="width:500px;" name="filter" id="filter" value=""  autocomplete="off" class="long" />
						<div id="filter-count" class="no-shadow" style="display: none;">{{$znaleziono_zamowien}} {{$ilosc_znalezionych}}</div>
					</li>
				</ul>
			</form>
		</div>
			{{$grid}}
		</div>
</div>
{{END}}