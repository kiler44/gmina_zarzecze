{{BEGIN index}}
<h3>{{$etykieta_wyszukiwarka}}</h3>
<br />

<form enctype="multipart/form-data" class="form-inline" name="email_testowy" method="post" action="{{$link_wyszukiwarka}}">
	<label for="fraza" class="input_ok wymagany">{{$etykieta_fraza}} *</label>
	<div class="input-append">
		<input name="fraza" id="fraza" value="" type="text" />
		<input id="szukaj" name="szukaj" value="{{$etykieta_szukaj}}" type="submit" class="btn" />
	</div>
</form>

<br />
<a href="{{$link_konfiguracja}}" class="btn" title="{{$etykieta_link_konfiguracja}}"><i class="icon-download-alt"></i> {{$etykieta_link_konfiguracja}}</a>
<br /><br /><br />
<h3>{{$etykieta_moduly_zwykle}}</h3>
<p>{{$opis_moduly_zwykle}}</p>
<div class="a_clear">
	<a href="{{$link_konfiguracja_moduly_zwykle}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_moduly_zwykle}}"><i class="icon-list-alt"></i> {{$etykieta_link_moduly_zwykle}}</a>
</div>
<br />
<h3>{{$etykieta_moduly_administracyjne}}</h3>
<p>{{$opis_moduly_administracyjne}}</p>
<div class="a_clear">
	<a href="{{$link_konfiguracja_moduly_administracyjne}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_moduly_administracyjne}}"><i class="icon-list-alt"></i> {{$etykieta_link_moduly_administracyjne}}</a>
</div>
<br />
<h3>{{$etykieta_system}}</h3>
<p>{{$opis_system}}</p>
<div class="a_clear">
	<a href="{{$link_konfiguracja_systemu}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_system}}"><i class="icon-pencil"></i> {{$etykieta_link_system}}</a>
	<a href="{{$link_konfiguracja_systemu_czysc}}" id="przycisk_czysc_konfiguracje" class="btn" onclick="return false;" title="{{$etykieta_link_konfiguracja_systemu_czysc}}"><i class="icon-undo"></i> {{$etykieta_link_konfiguracja_systemu_czysc}}</a>
</div>
<br />
<h3>{{$etykieta_globalne}}</h3>
<p>{{$opis_globalne}}</p>
<div class="a_clear">
	<a href="{{$link_konfiguracja_zmienne_globalne}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_globalne}}"><i class="icon-globe"></i> {{$etykieta_link_globalne}}</a>
</div>
<script>
	$(document).ready(function () {
		$('#przycisk_czysc_konfiguracje').click(function () {
			potwierdzenieUsun('{{$etykieta_link_konfiguracja_systemu_czysc_potwierdzenie}}', $(this));
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
	<a href="{{$link_pobierz_konfiguracje}}" class="btn" onclick="this.blur();" title="{{$etykieta_pobierz_konfiguracje}}"><i class="icon-download-alt"></i> {{$etykieta_pobierz_konfiguracje}}</a>
	<a href="{{$link_wczytaj_konfiguracje}}" class="btn" onclick="this.blur();" title="{{$etykieta_wczytaj_konfiguracje}}"><i class="icon-share"></i> {{$etykieta_wczytaj_konfiguracje}}</a>
</div>
{{$form}}
{{END}}

{{BEGIN linkCzyscKlucz}}
<a href="{{$url}}" title="{{$etykieta}}"><span>{{$etykieta}}</span></a><br/>
{{END linkCzyscKlucz}}

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
{{END scriptNyroModal}}


