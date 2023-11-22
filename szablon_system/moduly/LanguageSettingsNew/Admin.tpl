{{BEGIN index}}
<h3>{{$etykieta_wyszukiwarka}}</h3>
<br />
<form enctype="multipart/form-data" class="form-inline" id="email_testowy" name="email_testowy" method="post" action="{{$link_wyszukiwarka}}">
	<label for="fraza" class="input_ok wymagany">{{$etykieta_fraza}} *</label>
	<div class="input-append">
		<input name="fraza" id="fraza" value="" type="text">
		<input id="szukaj" name="szukaj" value="{{$etykieta_szukaj}}" type="submit" class="btn" />
	</div>
</form>
<br />
<a href="{{$link_tlumaczenia}}" class="btn" title="{{$etykieta_link_tlumaczenia}}"><i class="icon-download-alt"></i> {{$etykieta_link_tlumaczenia}}</a>
<br /><br /><br />
<h3>{{$etykieta_moduly_zwykle}}</h3>
<p>{{$opis_moduly_zwykle}}</p>
<div class="a_clear">
	<a href="{{$link_tlumaczenia_moduly_zwykle}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_moduly_zwykle}}"><i class="icon-list-alt"></i> {{$etykieta_link_moduly_zwykle}}</a>
</div>
<br />
<h3>{{$etykieta_moduly_administracyjne}}</h3>
<p>{{$opis_moduly_administracyjne}}</p>
<div class="a_clear">
	<a href="{{$link_tlumaczenia_moduly_administracyjne}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_moduly_administracyjne}}"><i class="icon-list-alt"></i> {{$etykieta_link_moduly_administracyjne}}</a>
</div>
<br />
<h3>{{$etykieta_biblioteki}}</h3>
<p>{{$opis_biblioteki}}</p>
<div class="a_clear">
	<a href="{{$link_tlumaczenia_biblioteki}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_biblioteki}}"><i class="icon-pencil"></i> {{$etykieta_link_biblioteki}}</a>
	<a href="{{$link_tlumaczenia_czysc_biblioteki}}" id="przycisk_czysc_tlumaczenia" class="btn" onclick="return false;" title="{{$etykieta_link_czysc_biblioteki}}"><i class="icon-undo"></i> {{$etykieta_link_czysc_biblioteki}}</a>
</div>
<br />
<script>
	$(document).ready(function () {
		$('#przycisk_czysc_tlumaczenia').click(function () {
			potwierdzenieUsun('{{$etykieta_link_czysc_biblioteki_potwierdzenie}}', $(this));
			return false;
		});
	});
</script>
{{END}}

{{BEGIN system}}
{{$form}}
{{END}}

{{BEGIN administracyjne}}
<div class="widget-box">
{{$grid}}
</div>
{{END}}

{{BEGIN zwykle}}
<div class="widget-box">
{{$grid}}
</div>
{{END}}

{{BEGIN edytujAdministracyjny}}
<div class="przyciskiFunkcyjne">
	<a href="{{$link_czysc}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_czysc}}"><i class="icon-undo"></i> {{$etykieta_link_czysc}}</a>
</div>
{{$form}}
{{END}}

{{BEGIN edytujZwykly}}
<div class="przyciskiFunkcyjne">
	<a href="{{$link_czysc}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_czysc}}"><i class="icon-undo"></i> {{$etykieta_link_czysc}}</a>
</div>
{{$form}}
{{END}}


{{BEGIN edytujKategorie}}
<div class="przyciskiFunkcyjne">
	<a href="{{$link_czysc}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_czysc}}"><i class="icon-undo"></i> {{$etykieta_link_czysc}}</a>
</div>
{{$form}}
{{END}}

{{BEGIN edytujBlok}}
<div class="przyciskiFunkcyjne">
	<a href="{{$link_czysc}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_czysc}}"><i class="icon-undo"></i> {{$etykieta_link_czysc}}</a>
</div>
{{$form}}
{{END}}

{{BEGIN linkCzyscKlucz}}<a href="{{$url}}" title="{{$etykieta}}"><span>{{$etykieta}}</span></a><br/>{{END}}

{{BEGIN podgladWartosciDomyslnej}}
<a href="#{{$id}}" title="{{$id}}" class="dialogLink" onclick="$('#' + this.title).modal('show'); return false;">{{$etykieta_link_podglad}}</a> |
<div title="{{$id}}" id="{{$id}}" class="dialogContent modal hide fade">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>&nbsp;</h3>
  </div>
  <div class="modal-body">
	  {{$podglad_tresc}}
  </div>
</div>
{{END podgladWartosciDomyslnej}}

{{BEGIN scriptNyroModal}}
<script type="text/javascript">
$(document).ready(function() {
	$('.dialogContent').modal({show:false});

	$('.dialogContent').each(function () {
		$(this).find('.modal-header h3').text($('label[for=' + $(this).attr('title').replace('nyro_', '') + ']').text());
	});

	$('.dialogContent .modal-body').find('a').remove();
	$('.dialogContent .modal-body').find('input[type=button]').remove();
	$('.dialogContent .modal-body').find('input').attr('disabled', 'disabled');
	$('.dialogContent .modal-body').find('select').attr('disabled', 'disabled');
	$('.dialogContent .modal-body').find('textarea').attr('disabled', 'disabled');
});
</script>
{{END}}
