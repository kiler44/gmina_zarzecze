{{BEGIN szablon_zdjecie_1}}
<tr id="{{$id}}">
	<td> <a href="{{$url}}" {{$rel}}><strong>{{$nazwa}}</strong></a></td>
	<td> <a href="javascript:void(0)" class="remove {{$funkcja_usun}}" id="{{$id}}" data-attr="usunBaza" rel="{{$id}}">{{$etykieta_usun}}<span></span></a> </td>
	<td> <input type="checkbox" class="no-js" name="nadaj_uprawnienia" {{IF($uprawnieniaUzytkownika, ' checked ')}} value="{{$id}}" /> </td>
</tr>
{{END}}

{{BEGIN szablon_zdjecie_2}}
<li id="{id}">
<tr>
<div class="edition-area">
	 
	  <td><strong class="qq-upload-file">{{$nazwa}}</strong></td>
	  <td><a href="javascript:void(0)" class="remove {{$funkcja_usun}}" id="{{$id}}" rel="{{$id}}">{{$etykieta_usun}}<span></span></a></td>
	  <!-- <td> <input type="checkbox" class="no-js" name="nadaj_uprawnienia" value="{{$usun_nazwa}}" /> </td> -->
		<div class="qq-upload-spinner"></div>
		<div class="qq-upload-size"></div>
		<a class="qq-upload-cancel" href="#"></a>
		<div class="qq-upload-failed-text"></div>
  </div>
<tr/>
</li>
{{END}}

{{BEGIN funkcja}}

<script type="text/javascript">
 

var blokuj_przycisk = false;

function blokadaWysylkiUpload()
{
	if(blokuj_przycisk == true){
		potwierdzenieUsun("{{$input_multi_upload_plikow_etykieta_blokada_tresc}}", $(this) , "{{$input_multi_upload_plikow_etykieta_blokada_tytul}}");
		return false;
	}
}

$("input[type='submit']").die("click").live("click",blokadaWysylkiUpload);

//Zwraca liczbe dodanych zdjec
function {{$nazwa}}_liczba_zdjec()
{
	return $("#{{$nazwa}}-separate-list tr").length;
}

function {{$nazwa}}_usun(ids, tpl, usunBaza)
{
	var idUzytkownik = $.urlParam('id');
	if($.isArray(ids))
	{
			idst = ids.join(',');
	}
	
	$.ajax({
		url: "{{$url_usun}}",
		type: "post",
		data: "ids=" + ids + "&token={{$token}}&usunBaza="+usunBaza+'&idUzytkownik='+idUzytkownik,
		dataType: "json",
		async: true,
		beforeSend: function() {
			$("#multiupload_{{$nazwa}}_usuwanie").slideDown();
		},
		error : function() {
		},
		success: function(dane) {
			if($.isArray(tpl))
			{
			   $(tpl).each(function(){
						$(this).remove();
					}
				);
			}
			else
			{
				$(tpl).remove();
			}
			
			$("#multiupload_{{$nazwa}}_usuwanie").slideUp();
			$("#multiupload_{{$nazwa}}_usunieto").slideDown();
			setTimeout(function () {$("#multiupload_{{$nazwa}}_usunieto").slideUp();}, {{$czas_pokazywania_komunikatu}});

			//Pokazanie przyciskow
			if ({{$nazwa}}_liczba_zdjec() == 0){
				$(".{{$nazwa}}.links.bottom, .{{$nazwa}}.links.top").hide();
			}

			//Aktualizacja liczby dodanych zdjec
			if ({{$nazwa}}_liczba_zdjec() < uploader._options.numFiles){
				uploader._options.numFiles = {{$nazwa}}_liczba_zdjec();
			}

		}
	});
}

function akceptujNadajUprawnienia(dane)
{
	console.log(dane);
}
$(document).ready(function(){

	var token = "{{$token}}";
	var maxId = {{$max_id}};
	var nextId = {{$next_id}};
	var fileTemplate = '{{$szablon}}';

	if ({{$nazwa}}_liczba_zdjec() > 0){
		$(".{{$nazwa}}.links.bottom, .{{$nazwa}}.links.top").show();
	}
	
	$('input[name=nadaj_uprawnienia]').on('click' , function(){ 
		
		ajax('{{$urlUpranienia}}' , akceptujNadajUprawnienia, { idUzytkownik: $.urlParam('id'), id: $(this).val(), dodaj: $(this).is(':checked') }, 'POST', 'json', true ); 
	} );
	
	var ua = navigator.userAgent.toLowerCase();


	uploader = new qq.FileUploader({
		element: document.getElementById("{{$nazwa}}"),
		listElement: document.getElementById("{{$nazwa}}-separate-list"),
		action: "{{$url_upload}}",

		fileTemplate: fileTemplate,

		//Na safari wylaczamy multi wysylanie zdjec
		multiple: (ua.indexOf( "safari" ) != -1 && ua.indexOf("chrome") == -1) ? false : true,

		allowedExtensions: [{{$dozwolone_rozszerzenia}}],
		sizeLimit: {{$max_wielkosc_pliku}},
		minSizeLimit: {{$min_wielkosc_pliku}},
		maxFiles: {{$max_liczba_plikow}},
		numFiles: {{$nazwa}}_liczba_zdjec(),

		messages: {
			uploadError: "{{$input_multi_upload_plikow_blad_uploadu}}",
            typeError: "{{$input_multi_upload_plikow_blad_zle_rozszerzenie}}",
            sizeError: "{{$input_multi_upload_plikow_blad_za_duzy_plik}}",
            minSizeError: "{{$input_multi_upload_plikow_blad_za_maly_plik}}",
			maxFilesError: "{{$input_multi_upload_plikow_za_duzo_plikow}}",
            emptyError: "{{$input_multi_upload_plikow_blad_pusty_plik}}",
            onLeave: "{{$input_multi_upload_plikow_etykieta_trwa_wysylanie}}"
        },

		showMessage: function(message){
			alertModal(message);
		},

		//Metoda pobiera liczbe zapisanych zdjec i wysyla ja do biektu uploadera
		countUploadedFiles: function(message){
			return {{$nazwa}}_liczba_zdjec();
		},

		onSubmit: function(id, fileName){
				var id = id + nextId;

				uploader.setParams({
					token: "{{$token}}",
					id: id
				});

				this.fileTemplate = fileTemplate.replace("{id}", id);
				 blokuj_przycisk = true;

		},
		onProgress: function(id, fileName, loaded, total){
	      blokuj_przycisk = true;
		},

		onComplete: function(id, fileName, responseJSON){
			var tpl = $("#" + responseJSON.id);

		//Sprawdzenie czy zdjecie zostalo poprawnie wyslane
			if (responseJSON.success == 0){
				tpl.remove();
				uploader.showMessage(this.messages.uploadError.replace("{file}", fileName));
				uploader._options.numFiles = {{$nazwa}}_liczba_zdjec();
				return false;
			}

			//Ustawienie obrazka minaturki
			tpl.find("img")
				.attr("src", "/_public/trash/" + token + "/{{$prefix}}" + responseJSON.kod)
				.attr("alt", fileName);

			//Ustawienie poprawnej nazwy inputa z opisem do obrazka
			tpl.find("input[type=text]")
				.attr("name", responseJSON.id + "-{{$nazwa}}-opis");

			//Ustawienie poprawnej nazwy checkboxowi do usuwania obrazka
			tpl.find("input[type=checkbox]")
				.attr("name", responseJSON.id + "-{{$nazwa}}-usun")
				.val(responseJSON.id);

			tpl.find("a")
				.attr("rel", responseJSON.id)
				.addClass("{{$nazwa}}-usun");

			//Aktualizacja kolejnosci
			$("input[name={{$nazwa}}_kolejnosc]").val($("#{{$nazwa}}-separate-list").sortable("toArray"));

			//Pokazanie przyciskow
			if ({{$nazwa}}_liczba_zdjec() > 0){
				$(".{{$nazwa}}.links.bottom, .{{$nazwa}}.links.top").show();
			}
		 blokuj_przycisk = false;
		},
		onCancel: function(id, fileName){
		 blokuj_przycisk = false;
		}
	});

	$("#{{$nazwa}}-separate-list").sortable({
		stop: function(event, ui) {
			$("input[name={{$nazwa}}_kolejnosc]").val($(this).sortable("toArray"));
		}
	});
	$("#{{$nazwa}}-separate-list").disableSelection();
	$("input[name={{$nazwa}}_kolejnosc]").val($("#{{$nazwa}}-separate-list").sortable("toArray"));

	$(".{{$nazwa}}-usun").live("click", function(){

		var ids = $(this).attr("rel");
		var usunBaza = $(this).attr('data-attr');
	
		var flag = potwierdzenieUsun1("{{$input_multi_upload_plikow_etykieta_czy_usunac_plik}}", $(this), "usunPliki("+ids+", \""+usunBaza+"\")");

		if(flag == false)
			return false;
	});

	$(".{{$nazwa}}-usunWiele").live("click", function(){
		var flag = potwierdzenieUsun1("{{$input_multi_upload_plikow_etykieta_czy_usunac_pliki}}", $(this), "usunWiele();");

		if(flag == false)
			return false;
	});

	$(".{{$nazwa}}-zaznaczWszystkie").live("click", function(){
		$("#{{$nazwa}}-separate-list input[type=checkbox]").click();
	});
});

function usunPliki(ids, usunBaza)
{
	var tpl = $("#" + ids);
	{{$nazwa}}_usun(ids, tpl, usunBaza);
	$('#usunPotwierdzenie').modal('hide');
}

function usunWiele()
{
	var tablica = [];
	var tpl = [];
	$("#{{$nazwa}}-separate-list input[type=checkbox]:checked").each(function(index){
		var ids = $(this).val();
		 
		tpl.push($(this).parents("li"));
		tablica.push(ids);
	});
	$('#usunPotwierdzenie').modal('hide');
	{{$nazwa}}_usun(tablica, tpl);
}

 
</script>
<div class="gallery">
	<div class="message message_success " id="multiupload_{{$nazwa}}_usuwanie" style="margin:0px 14px 22px 14px; display:none;">
		<div>
			<var class="messageMark success"></var>
			<p>Trwa usuwanie plików proszę czekać</p>
		</div>
	</div>
	<div class="message message_success " id="multiupload_{{$nazwa}}_usunieto" style="margin:0px 14px 22px 14px; display:none;">
		<div>
			<var class="messageMark success"></var>
			<p>{{input_multi_upload_plikow_etykieta_usunieto}}</p>
		</div>
	</div>
	<!--
	<div class="links top {{$nazwa}}">
		<a class="{{$nazwa}}-zaznaczWszystkie btn btn-success btn-mini zaznacz">{{$input_multi_upload_plikow_etykieta_zaznacz_wszystkie}}</a> |
		<a class="{{$nazwa}}-usunWiele btn btn-warning btn-mini odznacz">{{$input_multi_upload_plikow_etykieta_usun_zaznaczone}}</a>
	</div>
	-->
	<table id="{{$nazwa}}-separate-list" style="margin-left:10px;" class="fields fileUploadList table table-striped table-bordered">
		<thead>
			<tr>
				<th>Name</th>
				<th>Remove</th>
				<th>Premission for user</th>
			</tr>
		</thead>
		{{$dodane_zdjecia}}
	</table>
	<!--
	<div class="links bottom {{$nazwa}}">
		<a class="{{$nazwa}}-zaznaczWszystkie btn btn-success btn-mini zaznacz">{{$input_multi_upload_plikow_etykieta_zaznacz_wszystkie}}</a> |
		<a class="{{$nazwa}}-usunWiele btn btn-warning btn-mini odznacz">{{$input_multi_upload_plikow_etykieta_usun_zaznaczone}}</a>
	</div>
	-->
	<div id="{{$nazwa}}"></div>
	<input type="hidden" name="{{$nazwa}}_kolejnosc" value="" />
	<input type="hidden" name="{{$nazwa}}_token" value="{{$token}}" id="{{$nazwa}}_token" />
</div>

{{END}}