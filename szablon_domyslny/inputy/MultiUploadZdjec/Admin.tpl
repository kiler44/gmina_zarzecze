{{BEGIN szablon_zdjecie_1}}
<li id="{{$id}}" class="podgladZdjecia"  > <img src="{{$url}}" alt="{{$opis_zdjecia}}" data-name="{{$nazwa}}" width="92" height="88" />
  <div class="edition-area">
	<p><input type="checkbox" class="no-js" name="{{$usun_nazwa}}" value="{{$usun_wartosc}}" />
		{{IF $ikonaPopraw}}<a href="javascript:void(0)" class="przyciskEdytuj edit_thumb btn btn-info btn-small fR" rel="{{$linkPopraw}}"> {{$etykieta_popraw}} </a>{{END}}
		<button  class="remove {{$funkcja_usun}}" rel="{{$id}}">{{$etykieta_usun}}<span ></span></button>
	</p>
	  <label style="width: 230px;
  height: 20px;
  word-wrap: anywhere;
  overflow: hidden;"><strong>{{$nazwa}}</strong></label>

	  <p class="right">
	  <label>{{$etykieta_opis}}</label>
	  <input type="hidden" name="{{$id_nazwa}}" value="{{$id_wartosc}}"  />
	  <input type="text" name="{{$opis_nazwa}}" value="{{$opis_wartosc}}" style="width: 130px;" onclick="this.focus();" />
	  </p>

  </div>
</li>
{{END}}

{{BEGIN szablon_zdjecie_2}}
<li id="{id}" class="podgladZdjecia"> <img src="{{$url}}" alt="{{$opis_zdjecia}}" width="92" height="88" />
  <div class="edition-area">
	<p><input type="checkbox" class="no-js" name="{{$usun_nazwa}}" value="{{$usun_wartosc}}" />
	  <button class="remove {{$funkcja_usun}}" rel="{{$id}}">{{$etykieta_usun}}<span ></span></button> </p>
	  <label style="width: 230px;
  height: 20px;
  word-wrap: anywhere;
  overflow: hidden;"><strong class="qq-upload-file">{{$nazwa}}</strong></label>
		<div class="qq-upload-spinner"></div>
		<div class="qq-upload-size"></div>
		<a class="qq-upload-cancel" href="#"></a>
		<div class="qq-upload-failed-text"></div>

	<p class="right">
	  <label>{{$etykieta_opis}}</label>
	  <input type="text" name="{{$opis_nazwa}}" value="{{$opis_wartosc}}" style="width: 130px;" onclick="this.focus();" />
	  </p>

  </div>
</li>
{{END}}

{{BEGIN funkcja}}
<script type="text/javascript">
<!--

var blokuj_przycisk = false;

function blokadaWysylkiUpload()
{
	if(blokuj_przycisk == true){
		potwierdzenieUsun("{{$input_multi_upload_zdjec_etykieta_blokada_tresc}}", $(this) , "{{$input_multi_upload_zdjec_etykieta_blokada_tytul}}");
		return false;
	}
}

$("input[type='submit']").die("click").live("click",blokadaWysylkiUpload);
//$("input[type='submit']").die("click").live("click",blokadaWysylkiUpload);


//Zwraca liczbe dodanych zdjec
function {{$nazwa}}_liczba_zdjec()
{
	return $("#{{$nazwa}}-separate-list li").length;
}

function {{$nazwa}}_usun(ids, tpl, nazwa)
{
	$.ajax({
		url: "{{$url_usun}}",
		type: "post",
		data: "ids=" + ids + "&token={{$token}}&nazwa="+nazwa,
		dataType: "json",
		async: true,
		beforeSend: function() {
		},
		error : function() {
		},
		success: function(dane) {
			$(tpl).remove();
			$("#multiupload_{{$nazwa}}_usunieto").slideDown();
			setTimeout(function () {$("#multiupload_{{$nazwa}}_usunieto").slideUp();}, {{$czas_pokazywania_komunikatu}});
			liczIlosc();
			//Pokazanie przyciskow
			if ({{$nazwa}}_liczba_zdjec() == 0){
				$(".{{$nazwa}}.links.bottom, .{{$nazwa}}.links.top").hide();
			}

			//Aktualizacja liczby dodanych zdjec
			if ({{$nazwa}}_liczba_zdjec() < uploader._options.numFiles){
				uploader._options.numFiles = {{$nazwa}}_liczba_zdjec();
			}
			$('#usunPotwierdzenie').find('.close').click();
		}
	});
}

//$(document).on('click', ".{{$nazwa}}-usun" ,function(){ preUsun($(this));  });
 
 function preUsun(obiekt){

		var ids = obiekt.attr("rel");
		var flag = potwierdzenieUsun1('{{$input_multi_upload_zdjec_etykieta_czy_usunac_plik}}', obiekt, "usunPliki("+ids+")");

		if(flag == false)
			return false;
		 
	}
$(document).ready(function(){

	$('.edit_thumb').live('click', function () {
			var link = $(this).attr('rel');
			$('#oknoModalne .modal-body').html('<iframe src="'+link+'" frameborder="0" width="100%" height="100%"></iframe>');
			$('#oknoModalne').modal('show');
	});

 
	$(".{{$nazwa}}-usun").live("click", function(){

		var ids = $(this).attr("rel");
		var flag = potwierdzenieUsun1('{{$input_multi_upload_zdjec_etykieta_czy_usunac_plik}}', $(this), "usunPliki("+ids+")");

		if(flag == false)
			return false;
		 
	});
					 
					 

	$(".{{$nazwa}}-usunWiele").live("click", function(event){
		var flag = potwierdzenieUsun1('{{$input_multi_upload_zdjec_etykieta_czy_usunac_pliki}}', $(this), "usunWiele();");

		if(flag == false)
			return false;
		
		 
	});
	
	$.uniform.restore("#{{$nazwa}}-separate-list input[type=checkbox]");
	liczIlosc();
	var token = "{{$token}}";
	var maxId = {{$max_id}};
	var nextId = {{$next_id}};
	var fileTemplate = '{{$szablon}}';

	if ({{$nazwa}}_liczba_zdjec() > 0){
		$(".{{$nazwa}}.links.bottom, .{{$nazwa}}.links.top").show();
	}

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
			uploadError: "{{$input_multi_upload_zdjec_blad_uploadu}}",
            typeError: "{{$input_multi_upload_zdjec_blad_zle_rozszerzenie}}",
            sizeError: "{{$input_multi_upload_zdjec_blad_za_duzy_plik}}",
            minSizeError: "{{$input_multi_upload_zdjec_blad_za_maly_plik}}",
			maxFilesError: "{{$input_multi_upload_zdjec_za_duzo_plikow}}",
            emptyError: "{{$input_multi_upload_zdjec_blad_pusty_plik}}",
            onLeave: "{{$input_multi_upload_zdjec_etykieta_trwa_wysylanie}}"
        },

		showMessage: function(message){
			alert(message);
		},

		//Metoda pobiera liczbe zapisanych zdjec i wysyla ja do obiektu uploadera
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
			liczIlosc();

			if(responseJSON.url_podglad != undefined)
			{
				var sciezka = responseJSON.url_podglad;
			}
			else
			{
				var sciezka = "/_public/trash/" + token ;
			}

			//Ustawienie obrazka minaturki
			tpl.find("img")
				.attr("src", sciezka + "/{{$prefix}}" + responseJSON.kod)
				.attr("alt", fileName).attr("data-name", responseJSON.kod);

			//Ustawienie poprawnej nazwy inputa z opisem do obrazka
			tpl.find("input[type=text]")
				.attr("name", responseJSON.id + "-{{$nazwa}}-opis");

			//Ustawienie poprawnej nazwy checkboxowi do usuwania obrazka
			tpl.find("input[type=checkbox]")
				.attr("name", responseJSON.id + "-{{$nazwa}}-usun")
				.val(responseJSON.id);

			tpl.find(".remove")
				.attr("rel", responseJSON.id)
				.addClass("{{$nazwa}}-usun").text('{{$etykieta_usun}}');

			//Aktualizacja kolejnosci
			$("input[name={{$nazwa}}_kolejnosc]").val($("#{{$nazwa}}-separate-list").sortable("toArray"));

			//Pokazanie przyciskow
			if ({{$nazwa}}_liczba_zdjec() > 0){
				$(".{{$nazwa}}.links.bottom, .{{$nazwa}}.links.top").show();
			}

			blokuj_przycisk = false;

		},
		onCancel: function(id, fileName) {
			blokuj_przycisk = false;
		}
	});
	$('.qq-upload-drop-area').hide();

	$("#{{$nazwa}}-separate-list").sortable({
		stop: function(event, ui) {
			$("input[name={{$nazwa}}_kolejnosc]").val($(this).sortable("toArray"));
		},
		placeholder: "multiupload-placeholder",
		opacity: 0.6
	});

	
	$("#{{$nazwa}}-separate-list").disableSelection();
	$("input[name={{$nazwa}}_kolejnosc]").val($("#{{$nazwa}}-separate-list").sortable("toArray"));

	

	$(".{{$nazwa}}-zaznaczWszystkie").on("click", function(){
		$("#{{$nazwa}}-separate-list input[type=checkbox]").click();
	});


	/**
	$(".edit_thumb").each(function () {
		$(this).click(function () {
			$("#cboxLoadedContent").html("");

			$.fn.colorbox({
				href: $(this).attr("rel"),
				width: (666 + 150),
				height: 695,
				iframe: true,
				rel: "nofollow",
				onClosed: function () {},
				onComplete: function (){
					if($('#cboxLoadedContent').html().search('Request unsuccessful.') != -1)
					{
						$('#cboxLoadedContent').html('{{$input_multi_upload_zdjec_etykieta_blad}}');
						$('.komunikat').css('margin-top' , '40px');
					}
				}
			});
		});
	});
	 **/
});

function liczIlosc()
{
	var ilosc = $('#{{$nazwa}}-separate-list li').length;
	$('input[name=iloscZdjec]').val(ilosc);
}	
						
function usunPliki(ids)
{
	var tpl = $("#" + ids);
	var nazwa = tpl.find('img').attr('data-name');
	{{$nazwa}}_usun(ids, tpl, nazwa);
}

function usunWiele()
{
	
	$("#{{$nazwa}}-separate-list input[type=checkbox]:checked").each(function(index){
		
		var ids = $(this).val();
		var tpl = $(this).parents("li");
		var nazwa = $(this).parents("li").find('img').attr('data-name');
		
		{{$nazwa}}_usun(ids, tpl, nazwa);
	});
}

-->
</script>
<div class="gallery">
	<div class="message message_success " id="multiupload_{{$nazwa}}_usunieto" style="margin:0px 14px 22px 14px; display:none;">
		<div>
			<var class="messageMark success"></var>
			<p>{{input_multi_upload_zdjec_etykieta_usunieto}}</p>
		</div>
	</div>
	<div class="links top {{$nazwa}}">
		<a class="{{$nazwa}}-zaznaczWszystkie btn btn-success btn-mini zaznacz">{{$input_multi_upload_zdjec_etykieta_zaznacz_wszystkie}}</a> |
		<a class="{{$nazwa}}-usunWiele btn btn-warning btn-mini odznacz">{{$input_multi_upload_zdjec_etykieta_usun_zaznaczone}}</a>
	</div>
	<ul id="{{$nazwa}}-separate-list" class="fields">{{$dodane_zdjecia}}</ul>
	<div class="links bottom {{$nazwa}}">
		<a class="{{$nazwa}}-zaznaczWszystkie btn btn-success btn-mini zaznacz">{{$input_multi_upload_zdjec_etykieta_zaznacz_wszystkie}}</a> |
		<a class="{{$nazwa}}-usunWiele btn btn-warning btn-mini odznacz">{{$input_multi_upload_zdjec_etykieta_usun}}</a>
	</div>
	<div id="{{$nazwa}}"></div>
	<input type="hidden" name="{{$nazwa}}_kolejnosc" value="" />
	<input type="hidden" name="{{$nazwa}}_token" value="{{$token}}" />
</div>
{{END}}
