{{BEGIN index}}
<div class="sidebarHeader"><h5><span>App menu</span>{{IF $ustawienia}} <a href="{{$url_ustawienia}}"><i class="icon icon-cog"></i></a>{{END}}</h5><a href="javascript:void(0);" id="clip"><i class="icon icon-unlink"></i></a></div>
<ul class="leftMenu">
{{BEGIN element}}<li class="submenu{{IF $aktywny}} active{{END}}">
	<a href="{{$link_url}}" title="{{$link_etykieta}}"><i class="icon {{$ikona}}"></i> <span>{{$link_etykieta}}</span></a>
	<ul>
		{{BEGIN subElement}}<li{{IF $aktywny}} class="active"{{END}}><a href="{{$link_url}}"><i class="icon {{$ikona}}"></i> {{$link_etykieta}}</a></li>{{END}}
	</ul>
</li>
{{END}}
{{BEGIN elementPojedynczy}}
	<li{{IF $aktywny}} class="active"{{END}}><a href="{{$link_url}}" title="{{$link_etykieta}}">{{IF $ikona}}<i class="icon {{$ikona}}"></i> {{END}}<span>{{$link_etykieta}}</span></a></li>
{{END}}
</ul>
<script type="text/javascript">
	var clip = $.cookie('clip');
	if (clip == 1) {
		$('#sidebar').css('position', 'absolute');
		$('#clip i').removeClass('icon-unlink').addClass('icon-paper-clip');
	}
	else
	{
		$('#sidebar').css('position', 'fixed');
		$('#clip i').removeClass('icon-paper-clip').addClass('icon-unlink');
	}
	$('#clip').click(function(){
		if (clip == 1)
		{
			$('#sidebar').css('position', 'fixed');
			$('#clip i').removeClass('icon-paper-clip').addClass('icon-unlink');
			$.cookie('clip', 0, { expires: 365 });
			clip = 0;
		}
		else
		{
			$('#sidebar').css('position', 'absolute');
			$('#clip i').removeClass('icon-unlink').addClass('icon-paper-clip');
			$.cookie('clip', 1, { expires: 365 });
			clip = 1;
		}
	});
	$(".tablet #sidebar").css('position', 'absolute');
</script>
{{END}}

{{BEGIN ustawienia}}

	{{$formularz_uzytkownika}}
	
	{{BEGIN elementy}}
	<div class="widget-box" id="elementy">
		<div class="widget-title">
			<span class="icon"><i class="icon icon-file"></i></span>
			<h5>{{$elementy_etykieta}}</h5>
	  </div>
	<ul id="sortowanie" class="ui-sortable">
		{{BEGIN element}}
			<li id="id-{{$id}}">
				<span>{{IF $ikona}}<i class="icon {{$ikona}}"></i> {{END}}<strong>{{$etykieta}}</strong></span> <span><a class="faded" href="{{$url}}">{{$url}}</a></span>
				<div class="btn-group right">
					<a href="{{$url_edytuj}}" class="btn tip-top" title="{{$etykieta_edytuj}}"><i class="icon icon-edit"></i></a>
					<a href="{{$url_usun}}" class="btn tip-top" title="{{$etykieta_usun}}"><i class="icon icon-remove"></i></a>
				</div>
				<div class="clear"></div>
			</li>
		{{END}}
	</ul>
	</div>
	{{END}}
	
	{{BEGIN brak_elementow}}
		{{$komunikat}}
	{{END}}
	
	
	<div class="option {{IF $ilosc_elementow > 0}}hide{{END}}" id="formularzDodawania">{{$formularz_pozycji}}</div>
	<a href="javascript:void(0);" class="btn btn-info {{UNLESS $ilosc_elementow > 0}}hide{{END}}" id="pokazDodawanie"><i class="icon icon-plus-sign"></i> {{$etykieta_dodaj_element}}</a>

	<form action="" method="post" id="kolejnoscForm">
		<input type="hidden" name="kolejnosc" id="kolejnosc"/>
	</form>
	
<script type="text/javascript">
	$('#idUzytkownika').change(function(){
		$('body').prepend('<div class="modal-backdrop in hide"></div>');
		$(".modal-backdrop").fadeIn("fast");
		var url = $('#wybor-uzytkownika').attr('action').replace("{ID_UZYTKOWNIKA}", $(this).val());
		location.assign(url);
	});
	
	$("#pokazDodawanie").click(function(){
		pokazDodawanie();
	});
	$("#close").live("click", function(){
		ukryjDodawanie();
	});
	
	$(document).ready(function(){
		$("#zapiszKolejnosc").live('click', function(){
			$("#kolejnosc").val($("#sortowanie").sortable("toArray"));
			$("#kolejnoscForm").submit();
		});
		
		if ($("#formularz-pozycji").find(".input_blad").length)
		{
			pokazDodawanie();
		}
		
		$( ".ui-sortable" ).sortable({
			placeholder: 'placeholder',
			helper: "box",
			opacity: 0.8,
			update: function(){
				if (! $(".row-fluid").find("#zapiszKolejnosc").length)
				{
					$('<a href="javascript:void(0)" class="btn btn-success margin-right" id="zapiszKolejnosc"><i class="icon icon-save"></i> {{$etykieta_zapisz_kolejnosc}}</a>').insertBefore("#pokazDodawanie");
				}
			}
		});
		$( ".ui-sortable" ).disableSelection();
	});
	
function pokazDodawanie()
{
	$("#pokazDodawanie, #zapiszKolejnosc").fadeOut("normal");
	$("#elementy").slideUp("normal");
	if (!$("#formularzDodawania .formularz_stopka").find("#close").length)
		$("#formularzDodawania .formularz_stopka").append('<a href="javascript:void(0)" id="close" class="btn btn-small"><i class="icon icon-remove-sign"></i> {{$etykieta_zamknij}}</a>');
	$("#formularzDodawania").slideDown("normal");
	$("#formularzDodawania select").select2();
}
function ukryjDodawanie()
{
	$("#formularzDodawania").slideUp("normal");
	$("#pokazDodawanie, #zapiszKolejnosc").fadeIn();
	$("#elementy").slideDown("normal");
}
</script>
{{END}}

{{BEGIN edytuj}}
	<p class="option">{{$formularz_pozycji}}</p>
{{END}}