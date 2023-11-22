{{BEGIN index}}

<div class="widget-box">
{{$tabela_danych}}
<script type="text/javascript">
   $(document).ready(function () {
	var u = '{{$urlAjax}}';
	
	$('#{{$nazwa}}-test').live('click', function () {
		$.ajax({
			url: u,
			type: 'POST',
			dataType: 'html',
			async: true,
			success: function(dane) {

				$('#oknoModalne .modal-body').html(dane);
				$('#oknoModalne').modal('show');
				setTimeout(function(){ $('select#idParent').select2();  }, 200);
				setTimeout(function(){ $('select#type').select2();  }, 201);

			},
			error: function (xhr, ajaxOptions, thrownError) {
				alert(xhr.status);
				alert(thrownError);
			}
		})
	});
});
</script>
<!--
<a href="javascript:void(0);" id="link_test" >ajax</a>
-->
</div>
{{END}}

{{BEGIN dodaj}}
<div class="btn-group fL margin">
	<button class="rodzajFromularza btn btn-lg {{$prosty_active}}" id="simple"><i class="icon icon-magic"></i> {{$etykieta_prosty_form}}</button>
	<button class="rodzajFromularza btn btn-lg {{$pelny_active}}" id="complex"><i class="icon icon-puzzle-piece"></i> {{$etykieta_pelny_form}}</button>
</div>
{{$form}}
{{END}}

{{BEGIN dodajAjax}}
<script type="text/javascript">
		var opcjeDlaDeveloper = {
			{{$typyDlaDeveloper}}
		};
		var opcjeDlaCompany = {
			{{$typyDlaCompany}}
		};
		var pelnySelect = $("select#type").html();
		
</script>

<div class="klientKontener">
	<h3 class="heading3 margin fL">{{$etykieta_tytul}}</h3>
	<div class="btn-group fL margin">
		<button class="rodzajFromularza btn btn-lg {{$prosty_active}}" id="simple"><i class="icon icon-magic"></i> {{$etykieta_prosty_form}}</button>
		<button class="rodzajFromularza btn btn-lg {{$pelny_active}}" id="complex"><i class="icon icon-puzzle-piece"></i> {{$etykieta_pelny_form}}</button>
	</div>
	<div id="miejsceNaFormularz" class="klientDodajAjaxForm">
		{{$form}}
	</div>
</div>
	 
{{END}}

{{BEGIN script}}
<script type="text/javascript">

function sprawdzCoZaznaczone()
{
	var obecnieZaznaczone = $('select#type').val();

	if(obecnieZaznaczone == 'private')
	{
		  zmianDlaPrivate();
	}
	if(obecnieZaznaczone == 'company')
	{
		  zmienDlaCompany();
	}
	if(obecnieZaznaczone == 'developer')
	{
		  zmienDlaCompany();
	}
	if(obecnieZaznaczone == "branch contact person")
	{
		  zmianDlaBranchContactPerson();
	}
	if(obecnieZaznaczone == 0)
	{
		zmianDlaNieWybranego();
	}
}

var wymagane = [];
wymagane['private']	= ['type','name','surname','address','postcode','city','phoneMobile'];
wymagane['branch']	= ['type','idParent','name','surname','phoneMobile'];
wymagane['company']	= ['type','companyName','address','postcode','city','phoneMobile'];

function zmianDlaPrivate()
{
	$('form[id^="klientFormularz"] .control-group:not(:first-child)').hide();
	$('#korespondencja').parents('.formularz_region').hide();
	
	$('label[for="idCustomer"]').parent('div').show();
	
	for (index in wymagane['private'])
	{
		$('label[for="'+wymagane['private'][index]+'"]').parent('div').show();	
	}
		
	if ($('#formType').val() == 'complex')
	{
		$('label[for="secondName"]').parent('div').show();
		$('label[for="phoneNumber"]').parent('div').show();
		$('label[for="apartament"]').parent('div').show();
		$('label[for="fax"]').parent('div').show();
		$('label[for="email"]').parent('div').show();
		$('label[for="www"]').parent('div').show();
		$('#korespondencja').parents('.formularz_region').show();
		$('#korespondencja .control-group').show();
	}
	
	dodajGwiazdki('private');
}

function zmianDlaBranchContactPerson()
{
	$('form[id^="klientFormularz"] .control-group:not(:first-child)').hide();
	$('#korespondencja').parents('.formularz_region').hide();
	
	for (index in wymagane['branch'])
	{
		$('label[for="'+wymagane['branch'][index]+'"]').parent('div').show();	
	}
		
	if ($('#formType').val() == 'complex')
	{
		$('label[for="secondName"]').parent('div').show();
		$('label[for="phoneNumber"]').parent('div').show();
		$('label[for="fax"]').parent('div').show();
		$('label[for="email"]').parent('div').show();
		$('#korespondencja').parents('.formularz_region').show();
		$('#korespondencja .control-group').show();
	}
	
	dodajGwiazdki('branch');
}

function zmienDlaCompany()
{
	$('form[id^="klientFormularz"] .control-group').hide();
	$('#korespondencja').parents('.formularz_region').hide();
	
	$('label[for="idCustomer"]').parent('div').show();
	$('label[for="orgNumber"]').parent('div').show();
	for (index in wymagane['company'])
	{
		$('label[for="'+wymagane['company'][index]+'"]').parent('div').show();	
	}
		
	if ($('#formType').val() == 'complex')
	{
		$('label[for="phoneNumber"]').parent('div').show();
		$('label[for="fax"]').parent('div').show();
		$('label[for="email"]').parent('div').show();
		$('label[for="www"]').parent('div').show();
		$('#korespondencja').parents('.formularz_region').show();
		$('#korespondencja .control-group').show();
	}
	
	dodajGwiazdki('company');
}

function zmianDlaNieWybranego()
{
	$('form[id^="klientFormularz"] .control-group:not(:first-child)').hide();
	$('#korespondencja').parents('.formularz_region').hide();
	
	$('#select_customer_type_info').parents('.control-group').show();
}

function dodajGwiazdki(type)
{
	$('form[id^="klientFormularz"] label').each(function(){
		$(this).text($(this).text().replace('*', ''));
		if (inArray($(this).attr('for'), wymagane[type]))
		{
			$(this).text($(this).text()+'*');
		}
	});
}
$(document).ajaxComplete(function(){
	sprawdzCoZaznaczone();
})
$(document).ready(function () {
	sprawdzCoZaznaczone();
	$('#wstecz').live('click', function(e){
		$('#oknoModalne').modal('hide');
	});
	$('.rodzajFromularza').live('click', function(){
		if (! $(this).hasClass('active'))
		{
			var id = $(this).attr('id');
			$('.rodzajFromularza').removeClass('active');
			$(this).addClass('active');
			$('#formType').val(id);
			sprawdzCoZaznaczone();
		}
	});
	
	$('select#type').live('change', function(){
		if($(this).val() == 'private')
      {
			zmianDlaPrivate();
      }
		else if($(this).val() == 'company')
		{
			zmienDlaCompany();
		}
		else if($(this).val() == 'developer')
		{
			zmienDlaCompany();
		}
		else if($(this).val() == 'branch contact person')
		{
			zmianDlaBranchContactPerson();
			$('select#idParent').select2();
		}
      else
      {
			zmianDlaNieWybranego();
      }
   });
});
</script>
{{END}}
