{{BEGIN index}}
<div class="widget-box">
{{$tabela_danych}}
</div>
{{END}}
{{BEGIN dodaj}}
<script type="text/javascript">
	
	function dodajNowyRadio(value, etykieta)
	{
			$('label[for="idLeader"]').parent('div').show();
			$('label[for="idLeader_0"]').hide();
			
			var input = '<input id="idLeader_'+value+'" class="noinput" type="radio" value="'+value+'" name="idLeader" style="opacity: 0;">';

			$("#idLeader").append(input);
			$("#idLeader_"+value).uniform();
			$("#uniform-idLeader_"+value).wrap('<label for="idLeader_'+value+'">');
			$("#uniform-idLeader_"+value).after(etykieta);
	}
	
	function usunRadio(klucz)
	{
		var iloscOpcji = $('#idUsers_wybrane option').length;
		if(iloscOpcji <= 1)
		{
			$('label[for="idLeader_0"]').show();
		}
		$('label[for="idLeader_'+klucz+'"]').remove();
	}
	
	function radioWybrane()
	{
		var iloscOpcji = $('#idUsers_wybrane option').length;
		var iloscRadio = $('#idLeader label').length;
		
		if(iloscOpcji > 0)
		{
			$("#idUsers_wybrane option").each(function()
			{
				var klucz = $(this).val();
				var wartosc = $(this).text();
				
				if($('label[for="idLeader_'+klucz+'"]').length)
				{
					
				}
				else
				{
					dodajNowyRadio(klucz, wartosc);
				}

			});
		}
	}
	
	function kolorujSelect()
	{
		$("#idUsers_lista option").each(function()
		{
			var klucz = $(this).val();
			var wartosc = $(this).text();
			
			if(wartosc.indexOf("(") > -1)
			{
			}	 
			else
			{
				$(this).css('color', 'red');
			}
			
			if(wartosc.indexOf("-") > -1)
			{
				$(this).css('color', '#C0C0C0');
			}
			
		});
	}
	
   $(document).ready(function () {
		
		radioWybrane();
		kolorujSelect();
		
		$('#idLeader_0').parent('span').removeClass('checked').addClass('unchecked').prop('checked', false);
		
		$('#idUsers_wybrane option').live('dblclick', function(){
			var klucz = $(this).val();
			var wartosc = $(this).text();
			usunRadio(klucz);	
		})
		
		$('#idUsers_lista option').live('dblclick', function(){
			var klucz = $(this).val();
			var wartosc = $(this).text();
			dodajNowyRadio(klucz, wartosc);
		})
		$("#idUsers_dodaj").click(function () {
			$("#idUsers_lista option:selected").each(function () {
				dodajNowyRadio($(this).val(), $(this).text());
			});
		});
		$("#idUsers_usun").click(function () {
			$("#idUsers_wybrane option:selected").each(function () {
				usunRadio($(this).val());
			});
		}); 
		
		$('.akceptuj_przelogowanie').on('click', function() {
			if($(this).attr('name') == "yes")
			{
				$('input#potwierdz_przeloguj').val('1');
				$('#zapisz').click();
			}
			else
			{
				$('#wstecz').click();
			}
		});
		
	});
	
</script>
<div id="miejsceNaFormularz" >
{{$form}}
</div>

{{END}}

{{BEGIN zmienEkipe}}
{{$form}}
<a class="btn btn tip-top" href="{{$link_wstecz}}" data-original-title="{{$etykieta_wstecz}}" >
<i class="icon-angle-left"></i>
	{{$etykieta_wstecz}}
</a>
</div>
{{END}}
{{BEGIN informacje_team}}
<table style="border-bottom: 2px solid #2F4F4F; margin-bottom: 8px; width:100%;">
	<tbody>
		<tr >
			<td style="width: 20%; border-bottom: 1px dotted #ccc; padding:10px 15px 16px 0px;"  valign="top"><strong>{{$ekipa_etykieta}} </strong> </td>
			<td style="border-bottom: 1px dotted #ccc; padding:10px 15px 16px 0px" valign="top" >{{$ekipa_nazwa}}</td>
		</tr>
		<tr>
			<td style="border-bottom: 1px dotted #ccc; padding:10px 15px 16px 0px" valign="top" ><strong>{{$lider_etykieta}}</strong> </td>
			<td style="border-bottom: 1px dotted #ccc; padding:10px 15px 16px 0px" valign="top" >{{$lider_nazwa}}</td>
		</tr>
		<tr>
			<td style="border-bottom: 1px dotted #ccc; padding:10px 15px 16px 0px" valign="top" ><strong>{{$pracownicy_etykieta}}</strong> </td>
			<td style="border-bottom: 1px dotted #ccc; padding:10px 15px 16px 0px" valign="top" >{{$pracownicy_lista}}</td>
		</tr>
	</tbody>
</table>
{{END}}