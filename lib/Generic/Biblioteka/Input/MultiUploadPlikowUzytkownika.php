<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Zadanie;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Katalog;


/**
 * Klasa obsługująca multiupload plikow
 *
 *********************************************************************
 *
 * Wymagane parametry do prawidlowego dzialania inputa:
 *
 * - url_upload - ajaxowy adres url na ktory ma zostac wyslany plik, przyklad: Router::urlAjax('Http', $this->kategoria, 'zapiszZdjecie'),
 *
 * - url_plikow - sciezka do pliku, przyklad: '/_public/ogloszenia/'
 *
 * - url_usun - ajaxowy adres url do ktorego przekierowac podczas usuwania zdjecia,
 *				Wazne!!! adres musi posiadac parametr z id elementu do ktorego sa przypisane zdjecia, przyklad: Router::urlAjax('Http', $this->kategoria, 'usunZdjecia', array('id_ogloszenia' => $ogloszenie->id))
 *				W powyzszym przykladzie id elementu to id ogloszenia
 *
 *
 *********************************************************************
 * Reszta parametrow inputa:
 *
 * - lista - lista z tablica juz dodanych zdjec do inputa multiupload, struktora tablicy:
 *			 0 => // kluczem jest id zdjecia
 *				  array (
 *					'id' => 0, //id zdjecia
 *					'kod' => 'zdjecie-0.jpg', //kod zdjecia
 *					'nazwa' => 'Jellyfish.jpg', //poczatkowa nazwa zdjecia
 *					'rozmiar' => 270744, //rozmiar zdjecia podany w bajtach,
 *					'opis' =>, //opis do zdjecia
 *				  ),
 *
 * - prefix - prefix zdjecia miniaturki ktore wyswietla sie w podgladzie listy zdjec multiuploda
 *
 * - dozwolene_rozszerzenia - tablica z dozwolonymi rozszerzeniami zdjec
 *
 * - max_liczba_plikow - maksymalna liczba plikow jakie moga byc zapisane (domyslne: 0 - brak limitu)
 *
 * - min_wielkosc_pliku - minimalna wielkosc pliku podana w bajtach (domyslne: 0 - brak limitu)
 *
 * - max_wielkosc_pliku - maksymalna wielkosc pliku podana w bajtach (domyslne: 0 - brak limitu)
 *
 * ********************************************************************
 *
 *
 * @author Krzysztof Żak, Konrad Rudowski
 * @package biblioteki
 */
class MultiUploadPlikowUzytkownika extends Input
{

	protected $katalogSzablonu = 'MultiUploadPlikowUzytkownika';
	protected $parametry = array(
		'lista' => array(),
		'url_upload' => '',
		'urlPrzypiszUprawnienia' => '',
		'url_plikow' => '',
		'url_usun' => '',
		'prefix' => '',

		'dozwolone_rozszerzenia' => array(),
		'max_liczba_plikow' => 0,
		'min_wielkosc_pliku' => 0,
		'max_wielkosc_pliku' => 0,
		'czas_pokazywania_komunikatu' => 5000,
	);



	protected $tpl = '
{{BEGIN szablon_zdjecie_1}}
<li id="{{$id}}">
  <div class="edition-area">
	<p><input type="checkbox" name="{{$usun_nazwa}}" value="{{$usun_wartosc}}" />
	 </p>
	  <label><strong>{{$nazwa}}</strong></label>
	  <a href="javascript:void(0)" class="remove {{$funkcja_usun}}" rel="{{$id}}">{{$etykieta_usun}}<span></span></a>
	  <p class="right">
	  <label>{{$etykieta_opis}}</label>
	  <input type="hidden" name="{{$opis_nazwa}}" value="{{$opis_wartosc}}" style="width: 130px;" onclick="this.focus();" /></p>
  </div>
</li>
{{END}}

{{BEGIN szablon_zdjecie_2}}
<li id="{id}">
  <div class="edition-area">
	<p><input type="checkbox" name="{{$usun_nazwa}}" value="{{$usun_wartosc}}" />
	   </p>
	  <label><strong class="qq-upload-file">{{$nazwa}}</strong></label>
	  <a href="javascript:void(0)" class="remove {{$funkcja_usun}}" rel="{{$id}}">{{$etykieta_usun}}<span></span></a>
		<div class="qq-upload-spinner"></div>
		<div class="qq-upload-size"></div>
		<a class="qq-upload-cancel" href="#"></a>
		<div class="qq-upload-failed-text"></div>
	<p class="right">
	  <label>{{$etykieta_opis}}</label>
	  <input type="hidden" name="{{$opis_nazwa}}" value="{{$opis_wartosc}}" style="width: 130px;" onclick="this.focus();" /></p>
  </div>
</li>
{{END}}

{{BEGIN funkcja}}
<script type="text/javascript" src="/_szablon/biblioteki/fileuploader2.js"></script>
<script type="text/javascript">
<!--

var blokuj_przycisk = false;

function blokadaWysylkiUpload()
{
	if(blokuj_przycisk == true){
		confirmLightbox(null, "{{$input_multi_upload_etykieta_blokada_tytul}}", "{{$input_multi_upload_etykieta_blokada_tresc}}", "eWarning", "info");
	}else{
			$(this).parents(".fullwidth").find("form").submit();
	}
	return false;
}

$("#zapisz").die("click").live("click",blokadaWysylkiUpload);
$("#podglad").die("click").live("click",blokadaWysylkiUpload);

//Zwraca liczbe dodanych zdjec
function {{$nazwa}}_liczba_zdjec()
{
	return $("#{{$nazwa}}-separate-list li").length;
}

function {{$nazwa}}_usun(ids, tpl)
{
	$.ajax({
		url: "{{$url_usun}}",
		type: "post",
		data: "ids=" + ids + "&token={{$token}}",
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

$(document).ready(function(){
	var token = "{{$token}}";
	var maxId = {{$max_id}};
	var nextId = {{$next_id}};
	var fileTemplate = \'{{$szablon}}\';

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
			uploadError: "{{$input_multi_upload_blad_uploadu}}",
            typeError: "{{$input_multi_upload_blad_zle_rozszerzenie}}",
            sizeError: "{{$input_multi_upload_blad_za_duzy_plik}}",
            minSizeError: "{{$input_multi_upload_blad_za_maly_plik}}",
			maxFilesError: "{{$input_multi_upload_za_duzo_plikow}}",
            emptyError: "{{$input_multi_upload_blad_pusty_plik}}",
            onLeave: "{{$input_multi_upload_etykieta_trwa_wysylanie}}"
        },

		showMessage: function(message){
			confirmLightbox(null, "", message, "eError", "info");
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
		var flag = confirmLightbox("usunPliki("+ids+")", "", "{{$input_multi_upload_etykieta_czy_usunac_plik}}", "eWarning", "confirm");

		if(flag == false)
			return false;
	});

	$(".{{$nazwa}}-usunWiele").live("click", function(){
		var flag = confirmLightbox("usunWiele()", "", "{{$input_multi_upload_etykieta_czy_usunac_pliki}}", "eWarning", "confirm");

		if(flag == false)
			return false;
	});

	$(".{{$nazwa}}-zaznaczWszystkie").live("click", function(){
		$("#{{$nazwa}}-separate-list input[type=checkbox]").click();
	});
});

function usunPliki(ids)
{
	var tpl = $("#" + ids);

	{{$nazwa}}_usun(ids, tpl);
}

function usunWiele()
{
	$("#{{$nazwa}}-separate-list input[type=checkbox]:checked").each(function(index){
		var ids = $(this).val();
		var tpl = $(this).parents("li");

		{{$nazwa}}_usun(ids, tpl);
	});
}

-->
</script>
<div class="gallery">
	<div class="message message_success " id="multiupload_{{$nazwa}}_usunieto" style="margin:0px 14px 22px 14px; display:none;">
		<div>
			<var class="messageMark success"></var>
			<p>{{input_multi_upload_etykieta_usunieto}}</p>
		</div>
	</div>
	<div class="links top {{$nazwa}}">
		<a class="{{$nazwa}}-zaznaczWszystkie">{{$input_multi_upload_etykieta_zaznacz_wszystkie}}</a> |
		<a class="{{$nazwa}}-usunWiele">{{$input_multi_upload_etykieta_usun_zaznaczone}}</a>
	</div>
	<ul id="{{$nazwa}}-separate-list" class="fields fileUploadList">{{$dodane_zdjecia}}</ul>
	<div class="links bottom {{$nazwa}}">
		<a class="{{$nazwa}}-zaznaczWszystkie">{{$input_multi_upload_etykieta_zaznacz_wszystkie}}</a> |
		<a class="{{$nazwa}}-usunWiele">{{$input_multi_upload_etykieta_usun_zaznaczone}}</a>
	</div>
	<div id="{{$nazwa}}"></div>
	<input type="hidden" name="{{$nazwa}}_kolejnosc" value="" />
	<input type="hidden" name="{{$nazwa}}_token" value="{{$token}}" />
</div>
{{END}}
';



	/**
	 * Katalog plikow tymczasowych
	 *
	 * @var string
	 */
	protected $katalog = null;


	/**
	 * Unikatowy token inputa multiuplod potrzebny do prawidlowego umieszczenia plikow tymczasowych
	 *
	 * @var string
	 */
	protected $token = null;


	/**
	 * Informacje na temat plikow tymczsowych przeslanych przy pomocy multiupload
	 *
	 * @var array
	 */
	protected $info = array();


	/**
 	 * Ustawienie wartosci poczatkowej inputa
	 *
	 * @param type $wartoscPoczatkowa
	 * @param type $wymus
	 */
	public function ustawWartosc($wartoscPoczatkowa, $wymus = false)
	{
		if (is_string($wartoscPoczatkowa))
		{
			$wartoscPoczatkowa = array('name' => $wartoscPoczatkowa);
		}
		$this->wartoscPoczatkowa = $wartoscPoczatkowa;
		$this->wymusPoczatkowa = (bool)$wymus;
	}



	/**
	 * Pobiera obecna wartosc inputa.
	 *
	 * @return mixed Obecna wartosc inputa.
	 */
	function pobierzWartosc()
	{
		if ($this->wymusPoczatkowa)
		{
			return $this->pobierzWartoscPoczatkowa();
		}
		if ($this->filtrowany)
		{
			return $this->wartosc;
		}

		$dane = Zadanie::pobierzWszystkie();

		$this->wartosc['token'] = $this->generujToken();
		$this->wartosc['pliki'] = $this->wszytajInformacje();

		foreach($dane as $klucz => $wartosc)
		{
			if (strpos($klucz, $this->nazwa . '-opis') !== false)
			{
				$k = explode('-', $klucz);
				$this->wartosc['pliki'][$k[0]]['opis'] = $this->filtrujWartosc($wartosc);
			}
			if (strpos($klucz, $this->nazwa . '-usun') !== false)
			{
				$k = explode('-', $klucz);
				$this->wartosc['usun'][$k[0]] = 1;
			}
		}

		/**
		 * Tablica przetrzymujaca id zdjec w ustalonej przez uzytkownika kolejnosci
		 */
		$kolejnosc = explode(',', $dane[$this->nazwa . '_kolejnosc']);

		/**
		 * Kolejnosc
		 */
		$k = 0;

		foreach($kolejnosc as $id)
		{
			if (isset($this->wartosc['pliki'][$id]))
				$this->wartosc['pliki'][$id]['kolejnosc'] = ++$k;
		}

		return $this->wartosc;
	}



	/**
	 * Filtruje wartosc podana w argumencie
	 *
	 * @param array $wartosc.
	 * @return array Wartosc po zastosowaniu filtrow.
	 */
	protected function filtrujWartosc($wartosc)
	{
		foreach($this->filtry as $filtr)
		{
			$wartosc = $filtr($wartosc);
		}
		$this->filtrowany = true;
		return $wartosc;
	}



	protected function parsujSzablon($szablon, $plik = null, $url = null)
	{
		if ($plik != null && $url != null)
		{
			$prefix = ($this->parametry['prefix'] != '') ? $this->parametry['prefix'] . '-' : '';

			if (isset($this->wartosc['pliki'][$plik['id']]['opis']))
				$opis = $this->wartosc['pliki'][$plik['id']]['opis'];
			elseif(isset($plik['opis']))
				$opis = $plik['opis'];
			else
				$opis = '';

			$_ext = explode('.', $plik['nazwa']);
			
			$ext = end($_ext);
			
			$dane = array(
				'url' => $url . '/' . $prefix . \Generic\Biblioteka\Plik::unifikujNazwe($plik['kod']),
				'opis_zdjecia' => $plik['kod'],
				'nazwa' => $plik['nazwa'],
				'rozmiar' => formatbytes($plik['rozmiar'], 'KB'),
				'opis_nazwa' => $plik['id'] . '-' . $this->nazwa . '-opis',
				'opis_wartosc' => $opis,
				'usun_nazwa' => $plik['id'] . '-' . $this->nazwa . '-usun',
				'usun_wartosc' => $plik['id'],
				'funkcja_usun' => $this->nazwa . '-usun',
				'id' => $plik['id'],
				'uprawnieniaUzytkownika' => $plik['uprawnieniaUzytkownika'],
				'etykieta_usun' => $this->tlumaczenia['input_multi_upload_plikow_etykieta_usun'],
				'rel' => (in_array($ext, array('jpg','gif','png','jpeg','bmp'))) ? 'rel="lightbox[\'zamowienie\']"' : '',
			);
		}

		$dane['etykieta_opis'] = $this->tlumaczenia['input_multi_upload_plikow_etykieta_opis'];
		$dane['etykieta_usun'] = $this->tlumaczenia['input_multi_upload_plikow_etykieta_usun'];

		return $this->szablon->parsujBlok($szablon, $dane);
	}


	/**
	 * Metoda generujaca unikalny token inputa
	 *
	 * @return type
	 */
	protected function generujToken()
	{
		if ($this->token == null)
			return (Zadanie::pobierz($this->nazwa . '_token', 'trim') != null) ? Zadanie::pobierz($this->nazwa . '_token', 'trim') : md5($this->nazwa . Cms::inst()->sesja->idSesji() . date('Y-m-d H:i:s'));
		else
			return $this->token;
	}


	/**
	 * Metoda pobiera katalog w ktorym znajdujs sie zdjecia tymczasowe
	 *
	 * @return Katalog
	 */
	protected function pobierzKatalog()
	{
		if ($this->katalog == null)
			return new Katalog(TEMP_KATALOG . '/public/trash/' . $this->generujToken(), true);
		else
			return $this->katalog;
	}


	/**
	 * Wczytanie pliku z informacja o zdjeciach tymczasowych
	 *
	 * @return array
	 */
	protected function wszytajInformacje()
	{
		if (count($this->info) > 0)
			return $this->info;

		$info = array();
		$plikDanych = $this->pobierzKatalog() . '/info.php';
		if (is_file($plikDanych))
		{
			$info = @include($plikDanych);
		}

		return $info;
	}



	public function pobierzHtml()
	{
		/**
		 * Generowanie tokena, jest to nazwa folderu w smietniku gdzie tymczsowo beda przechowywane zdjecia
		 */
		$this->token = $this->generujToken();

		/**
		 * Tworzenie katalogu w ktorym sa przechowywane tymczasowo przechowywane zdjecia
		 */
		$this->katalog = $this->pobierzKatalog();

		/**
		 * Tresc html dodanych zdjec
		 */
		$dodaneZdjecia = '';

		/**
		 * Najwieksze id dodanego zdjecia
		 */
		$maxId = null;

		/**
		 * Adres url do katalogu z plikami tymczasowymi inputya multiupload
		 */
		$urlTrash = '/_public/trash/' . $this->token;


		/**
		 * Wyswietlenie na liscie zdjec juz dodanych do elementu (np. ogloszenia)
		 * Na poczatku sortujemy elementy w odpowiedniej kolejnosci
		 */

		if (count($this->parametry['lista']) > 0)
		{
			//masort($this->parametry['lista'], 'kolejnosc');

			foreach($this->parametry['lista'] as $wartosc)
			{
				$dodaneZdjecia .= $this->parsujSzablon('szablon_zdjecie_1', $wartosc, $this->parametry['url_plikow']);
				$maxId = ($wartosc['id'] > (int) $maxId) ? $wartosc['id'] : (int) $maxId;
			}
		}

		$info = $this->wszytajInformacje();
		/**
		 * Wyswietlenie na liscie zdjec z folderu tymczasowego dla danego elementu (np. ogloszenia)
		 */

		foreach ($info as $wartosc)
		{
			$dodaneZdjecia .= $this->parsujSzablon('szablon_zdjecie_1', $wartosc, $urlTrash);
			$maxId = ($wartosc['id'] > (int) $maxId) ? $wartosc['id'] : (int) $maxId;
		}

		/**
		 * Ustawienie doposzczalnych rozszerzen zdjec
		 */
		$dozwoloneRozszerzenia = implode('","', $this->parametry['dozwolone_rozszerzenia']);
		$dozwoloneRozszerzenia = ($dozwoloneRozszerzenia != '') ? '"' . $dozwoloneRozszerzenia . '"' : $dozwoloneRozszerzenia;

		/**
		 * Zmienne globalne potrzebne do prawidlowego dzialania multiupload
		 */
		$this->szablon->ustawGlobalne($this->tlumaczenia);
		$this->szablon->ustawGlobalne($this->parametry);
		$this->szablon->ustawGlobalne(array(
			'urlPrzypiszUprawnienia' => $this->parametry['urlUpranienia'],
			'nazwa' => $this->pobierzNazwe(),
			'atrybuty' => $this->pobierzAtrybuty(),
			'token' => $this->token,
			'prefix' => ($this->parametry['prefix'] != '') ? $this->parametry['prefix'] . '-' : '',
			'dozwolone_rozszerzenia' => $dozwoloneRozszerzenia,
			'max_id' => $maxId === null ? 0 : $maxId,
			'next_id' => $maxId === null ? 0 : $maxId + 1,
			'szablon' => trim(preg_replace('/\s+/', ' ', $this->parsujSzablon('szablon_zdjecie_2'))),
		));

		return $this->szablon->parsujBlok('funkcja', array(
			'dodane_zdjecia' => $dodaneZdjecia,
		));
	}
}
