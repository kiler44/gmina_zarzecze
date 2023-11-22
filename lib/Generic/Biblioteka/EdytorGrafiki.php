<?php
namespace Generic\Biblioteka;
use Generic\Biblioteka\Szablon;
use Generic\Biblioteka\Plik;
use Generic\Biblioteka\Grafika;


/**
 * Webowy interfejs do modyfikacji plików graficznych
 *
 * @author Dariusz Półtorak, trochę refaktoryzował Konrad Rudowski (ale nie przyznaje się do tego)
 *
 * @package biblioteki
 */

class EdytorGrafiki
{

	protected $szablon = null;


	protected $konfiguracja = array(
		'temp' => './temp',
		'link' => './temp',
		'linkHistoria' => '?x={NUMER}'
	);


	protected $tlumaczenia = array(
		'skaluj' => 'Skaluj',
		'utnij' => 'Utnij',
		'obroc' => 'Obróć',
		'odbij' => 'Odbij',
		'tekst' => 'Tekst',
		'nakWodny' => 'Znak wodny',
		'oryginal' => 'Oryginał',
		'aktualny' => 'Aktualny (%s)',

		'etykieta_nazwa' => 'Historia zmian',
		'etykieta_zmienRozmiar' => 'Zmień rozmiar',
		'etykieta_skaluj' => 'Skaluj',
		'etykieta_utnij' => 'Utnij',
		'etykieta_obroc' => 'Obróć',
		'etykieta_odbij' => 'Odbij',
		'etykieta_tekst' => 'Tekst',
		'etykieta_znakWodny' => 'Znak wodny',
		'etykieta_oryginal' => 'Oryginał',
		'etykieta_zapisz' => 'Zapisz',
		'etykieta_zapisz_pod_inna_nazwa' => 'Zapisz pod inną nazwą',
		'etykieta_zapisz_jako' => 'Zapisz jako',
		'etykieta_zapisznaoryginal' => 'Zapisz na oryginale',

		'etykieta_wysokosc' => 'Wysokość:',
		'etykieta_szerokosc' => 'Szerokość:',
		'etykieta_zachowanie' => 'Zachowanie:',
		'etykieta_zachowanieZmienRozmiar' => 'Zmień rozmiar',
		'etykieta_zachowanieSkaluj' => 'Skaluj z zachowaniem proporcji',
		'etykieta_zachowanieSkalujUtnij' => 'Zmień rozmiar i przytnij',

		'etykieta_pozycjaX' => 'Pozycja X:',
		'etykieta_pozycjaY' => 'Pozycja Y:',

		'etykieta_kat' => 'Kąt:',

		'etykieta_pionowo' => 'Pionowo:',
		'etykieta_poziomo' => 'Poziomo:',

		'etykieta_pozycja' => 'Pozycja:',

		'etykieta_srodek' => 'Środek',
		'etykietak_lewyGorny' => 'Lewy górny',
		'etykietak_gora' => 'Góra',
		'etykietak_prawyGorny' => 'Prawy górny',
		'etykietak_lewa' => 'Lewa',
		'etykietak_prawa' => 'Prawa',
		'etykietak_lewyDol' => 'Lewy dolny',
		'etykietak_Dol' => 'Dół',
		'etykietak_prawyDol' => 'Prawy dolny',

		'etykieta_czcionka' => 'Czcionka:',
		'etykieta_rozmiar' => 'Rozmiar:',
		'etykieta_kolor' => 'Kolor:',
		'etykieta_przezroczystosc' => 'Przeźroczystość:',
		'etykieta_tekst' => 'Tekst:',
		'etykieta_wstawTekst' => 'Wstaw tekst',
		'etykieta_poprawNazwe' => 'Nazwa jest nieprawidłowa, podaj nową',
		'menedzer_plikow_kom_zlaNazwa' => 'Nazwa jest nieprawidłowa, podaj nową',

		'etykieta_przywrocWersje' => 'Wróć do tej wersji',
		'menedzer_plikow_skalujRozmiar0' => 'Rozmiary obrazka muszą być większe od 0',
		'menedzer_plikow_utnijRozmiarNiepoprawny' => 'Rozmiar wycięcia musi miescić się w granicach obrazka oraz musi być większy od 0.',
		'menedzer_plikow_obrocKat0' => 'Należy wybrać kąt obrotu obrazka.',
		'menedzer_plikow_odbijNieWybrano' => 'Należy wybrać kierunek odbicia.',
		'menedzer_plikow_tekstBrakTekstu' => 'Należy wpisać tekst znaku wodnego.',
	);


	protected $info = array(
		'sciezka' => '',
		'nazwa' => '',
		'rozmiar' => '',
		'akcja' => '',
	);


	protected $katalogCzcionek = './';


	protected $img = null;


	protected $wybrany = 0;


	protected $aktualny = 0;


	private $oryginal = '';


	protected $tpl = '
<div class="edytor_grafiki">
	<script type="text/javascript">
		var api = null;
		var img_w = null;
		var img_h = null;
		var total_h = 70;
		$("document").ready(function(){
			maximizeWindow();
			if(window.opener && getFromUrl("odswiez") != "")
			{
				var windowOpener = window.opener;
				windowOpener.location.reload();
			}
			var window_w = window.innerWidth;
			var window_h = window.innerHeight;
			$(".edytor_grafiki > .edytor").height(window_h-total_h);
			$(".edytor_grafiki > .edytor > .obszar_roboczy").width(window_w-250).height(window_h-total_h);
			$(".edytor_grafiki > .edytor > .historia").height(window_h-total_h).find("ul");
			var dumpImg = new Image();
			dumpImg.src = $("#img").attr("src");
			var img_w = 0;
			var img_h = 0;
			$(dumpImg).load(function(){
				img_w = $("#img").width();
				img_h = $("#img").height();
				$("#img").resizable({
					resize: function(event, ui) {
						var form = $(".edytor_grafiki > .opcje > form[name=\"skaluj\"]");
						form.find("input[name=\"wysokosc\"]").val(ui.size.height);
						form.find("input[name=\"szerokosc\"]").val(ui.size.width);
					}
				});
			});
			$(".edytor_grafiki > .menu > a").click(function() {
				$(".edytor_grafiki > .opcje > form").animate({ top: "200px" }, 200);
				var title = $(this).attr("title");
				$(".edytor_grafiki > .opcje > form[name=\'"+title+"\']").animate({ "top": "0px" }, 200);
				if(title == "skaluj") {
					$("#img").resizable({
						resize: function(event, ui) {
							var form = $(".edytor_grafiki > .opcje > form[name=\"skaluj\"]");
							form.find("input[name=\"wysokosc\"]").val(ui.size.height);
							form.find("input[name=\"szerokosc\"]").val(ui.size.width);
						}
					});
				}
				else {
					$("#img").resizable("destroy");
					$("#img").width(img_w);
					$("#img").height(img_h);
				}
				if(title == "tnij") {
					api = $.Jcrop("#img",{ bgColor: "black", onChange: kordynaty, onSelect: kordynaty });
				}
				else {
					if(api != null) {
						api.destroy();
					}
				}
				if(title == "tekst") {
					$(".edytor_grafiki > .opcje").animate({height: "80px"}, 200);
					total_h = 110;
				}
				else {
					$(".edytor_grafiki > .opcje").animate({height: "40px"}, 200);
					total_h = 70;
				}
				var window_w = window.innerWidth;
				var window_h = window.innerHeight;
				$(".edytor_grafiki > .edytor").height(window_h-total_h);
				$(".edytor_grafiki > .edytor > .obszar_roboczy").width(window_w-250).height(window_h-total_h);
				$(".edytor_grafiki > .edytor > .historia").height(window_h-total_h);
			});
		});

		$(window).resize(function(){
			window_w = window.innerWidth;
			window_h = window.innerHeight;
			$(".edytor_grafiki > .edytor").height(window_h-total_h);
			$(".edytor_grafiki > .edytor > .obszar_roboczy").width(window_w-250).height(window_h-total_h);
			$(".edytor_grafiki > .edytor > .historia").height(window_h-total_h);
		});

		function kordynaty(c) {
			var form = $(".edytor_grafiki > .opcje > form[name=\"tnij\"]")
			form.find("input[name=\"pozx\"]").val(c.x);
			form.find("input[name=\"pozy\"]").val(c.y);
			form.find("input[name=\"wysokosc\"]").val(c.h);
			form.find("input[name=\"szerokosc\"]").val(c.w);
		}

		function eg_poprawNazwe(test)
		{
			test = test.replace(/ę/i,"e");
			test = test.replace(/ż/i,"z");
			test = test.replace(/ó/i,"o");
			test = test.replace(/ł/i,"l");
			test = test.replace(/ć/i,"c");
			test = test.replace(/ś/i,"s");
			test = test.replace(/ź/i,"z");
			test = test.replace(/ń/i,"n");
			test = test.replace(/ą/i,"a");
			test = test.replace(/Ą/i,"A");
			test = test.replace(/[^-_A-Z0-9\s\.]/gi, "");
			test = test.replace(/^\s+|\s+$/g, "");
			test = test.replace(/\s+/g, "_");
			return test;
		}

		function eg_popraw(e)
		{
			if(e.value.length == 0) { alert("{{$menedzer_plikow_kom_zlaNazwa}}"); return false; }
			var kom = "{{$etykieta_poprawNazwe}}";
			var nazwa = e.value;
			e.value = test = eg_poprawNazwe(nazwa);
			if(test != nazwa) { alert("{{$etykieta_poprawNazwe}}"); return false; }
			return true;
		}
	</script>
	<div class="menu">
		<a href="javascript:void(0);" title="skaluj">{{$etykieta_zmienRozmiar}}</a>
		<a href="javascript:void(0);" title="tnij">{{$etykieta_utnij}}</a>
		<a href="javascript:void(0);" title="obroc">{{$etykieta_obroc}}</a>
		<a href="javascript:void(0);" title="odbij">{{$etykieta_odbij}}</a>
		<a href="javascript:void(0);" title="tekst">{{$etykieta_znakWodny}}</a>
		{{BEGIN zapisz}}<a href="#" title="zapisz">{{$etykieta_zapisz}}</a>{{END}}
	</div>
	<div class="opcje">
		<form action="" method="post" name="skaluj" style="top: 0;">
			<label>{{$etykieta_wysokosc}} </label> <input type="text" name="wysokosc" class="text">
			<label>{{$etykieta_szerokosc}} </label> <input type="text" name="szerokosc" class="text">
			<label>{{$etykieta_zachowanie}} </label>
			<select name="zachowanie">
				<option value="default">{{$etykieta_zachowanieZmienRozmiar}}</option>
				<option value="skaluj">{{$etykieta_zachowanieSkaluj}}</option>
				<option value="przytnij">{{$etykieta_zachowanieSkalujUtnij}}</option>
			</select>
			<input type="submit" name="wykonaj" value="{{$etykieta_skaluj}}">
			<input type="hidden" name="akcjaEdytora" value="skaluj">
		</form>
		<form action="" method="post" name="tnij">
			<label>{{$etykieta_pozycjaX}} </label> <input type="text" name="pozx" class="text">
			<label>{{$etykieta_pozycjaY}} </label> <input type="text" name="pozy" class="text">
			<label>{{$etykieta_wysokosc}} </label> <input type="text" name="wysokosc" class="text">
			<label>{{$etykieta_szerokosc}} </label> <input type="text" name="szerokosc" class="text">
			<input type="submit" name="wykonaj" value="{{$etykieta_utnij}}">
			<input type="hidden" name="akcjaEdytora" value="tnij">
		</form>
		<form action="" method="post" name="obroc">
			<label>{{$etykieta_kat}} </label> <input type="text" name="kat" class="text">
			<input type="submit" name="wykonaj" value="{{$etykieta_obroc}}">
			<input type="hidden" name="akcjaEdytora" value="obroc">
		</form>
		<form action="" method="post" name="odbij">
			<label>{{$etykieta_pionowo}} </label> <input type="radio" name="kierunek" value="y">
			<label>{{$etykieta_poziomo}} </label> <input type="radio" name="kierunek" value="x">
			<input type="submit" name="wykonaj" value="{{$etykieta_odbij}}">
			<input type="hidden" name="akcjaEdytora" value="odbij">
		</form>
		<form action="" method="post" name="tekst">
			<label>{{$etykieta_pozycja}} </label>
			<select name="pozycja">
				<option value="default">{{$etykieta_srodek}}</option>
				<option value="lewy_gorny">{{$etykietak_lewyGorny}}</option>
				<option value="gora">{{$etykietak_gora}}</option>
				<option value="prawy_gorny">{{$etykietak_prawyGorny}}</option>
				<option value="lewa">{{$etykietak_lewa}}</option>
				<option value="prawa">{{$etykietak_prawa}}</option>
				<option value="lewy_dolny"">{{$etykietak_lewyDol}}</option>
				<option value="dol">{{$etykietak_Dol}}</option>
				<option value="prawy_dolny"">{{$etykietak_prawyDol}}</option>
			</select>
			<label>{{$etykieta_czcionka}} </label>
			<select name="czcionka">
				<option value="agapes">Agapes</option>
				<option value="efnmacmt">Efnmacmt</option>
				<option value="efnzepsm">Efnzepsm</option>
				<option value="frankgon"">Frankgon</option>
				<option value="znakwodny">Frankgo Bold</option>
				<option value="scribeb"">Scribe</option>
				<option value="robin1"">Robin</option>
			</select>
			<label>{{$etykieta_rozmiar}}</label>
			<select name="rozmiar">
				<option value="10">10pt</option>
				<option value="12">12pt</option>
				<option value="14">14pt</option>
				<option value="15">16pt</option>
				<option value="18">18pt</option>
				<option value="24">24pt</option>
				<option value="30">30pt</option>
				<option value="36">36pt</option>
				<option value="44">44pt</option>
				<option value="54">54pt</option>
				<option value="66">66pt</option>
				<option value="72">72pt</option>
				<option value="80">80pt</option>
				<option value="94">94pt</option>
				<option value="100">100pt</option>
			</select>
			<label>{{$etykieta_kolor}}</label>
			<select name="kolor">
				<option value="000000" style="color: #000000; background: #000000;">000000</option>
				<option value="FFFFFF" style="color: #FFFFFF; background: #FFFFFF;">FFFFFF</option>
				<option value="003300" style="color: #003300; background: #003300;">003300</option>
				<option value="006600" style="color: #006600; background: #006600;">006600</option>
				<option value="009900" style="color: #009900; background: #009900;">009900</option>
				<option value="00CC00" style="color: #00CC00; background: #00CC00;">00CC00</option>
				<option value="00FF00" style="color: #00FF00; background: #00FF00;">00FF00</option>
				<option value="330000" style="color: #330000; background: #330000;">330000</option>
				<option value="336600" style="color: #336600; background: #336600;">336600</option>
				<option value="339900" style="color: #339900; background: #339900;">339900</option>
				<option value="33CC00" style="color: #33CC00; background: #33CC00;">33CC00</option>
				<option value="33FF00" style="color: #33FF00; background: #33FF00;">33FF00</option>
				<option value="660000" style="color: #660000; background: #660000;">660000</option>
				<option value="663300" style="color: #663300; background: #663300;">663300</option>
				<option value="666600" style="color: #666600; background: #666600;">666600</option>
				<option value="669900" style="color: #669900; background: #669900;">669900</option>
				<option value="66CC00" style="color: #66CC00; background: #66CC00;">66CC00</option>
				<option value="66FF00" style="color: #66FF00; background: #66FF00;">66FF00</option>
				<option value="990000" style="color: #990000; background: #990000;">990000</option>
				<option value="993300" style="color: #993300; background: #993300;">993300</option>
				<option value="996600" style="color: #996600; background: #996600;">996600</option>
				<option value="999900" style="color: #999900; background: #999900;">999900</option>
				<option value="99CC00" style="color: #99CC00; background: #99CC00;">99CC00</option>
				<option value="99FF00" style="color: #99FF00; background: #99FF00;">99FF00</option>
				<option value="CC0000" style="color: #CC0000; background: #CC0000;">CC0000</option>
				<option value="CC3300" style="color: #CC3300; background: #CC3300;">CC3300</option>
				<option value="CC6600" style="color: #CC6600; background: #CC6600;">CC6600</option>
				<option value="CC9900" style="color: #CC9900; background: #CC9900;">CC9900</option>
				<option value="CCCC00" style="color: #CCCC00; background: #CCCC00;">CCCC00</option>
				<option value="CCFF00" style="color: #CCFF00; background: #CCFF00;">CCFF00</option>
				<option value="FF0000" style="color: #FF0000; background: #FF0000;">FF0000</option>
				<option value="FF3300" style="color: #FF3300; background: #FF3300;">FF3300</option>
				<option value="FF6600" style="color: #FF6600; background: #FF6600;">FF6600</option>
				<option value="FF9900" style="color: #FF9900; background: #FF9900;">FF9900</option>
				<option value="FFCC00" style="color: #FFCC00; background: #FFCC00;">FFCC00</option>
				<option value="FFFF00" style="color: #FFFF00; background: #FFFF00;">FFFF00</option>
			</select><br>
			<label>{{$etykieta_przezroczystosc}}</label>
			<select name="przezroczystosc">
				<option value="100">0%</option>
				<option value="90">10%</option>
				<option value="80">20%</option>
				<option value="70">30%</option>
				<option value="60">40%</option>
				<option value="50">50%</option>
				<option value="40">60%</option>
				<option value="30">70%</option>
				<option value="20">80%</option>
				<option value="10">90%</option>
			</select>
			<label>Kąt: </label>
			<input type="text" name="kat" class="text">
			<label>{{$etykieta_tekst}} </label>
			<input type="text" name="tekst" value="">
			<input type="submit" name="wykonaj" value="{{$etykieta_wstawTekst}}">
			<input type="hidden" name="akcjaEdytora" value="tekst">
		</form>
		<form action="" method="post" name="zapisz">
			<input type="hidden" name="wykonaj" value="1">
			<input type="submit" name="zapiszOryginal" value="{{$etykieta_zapisznaoryginal}}">
			<input type="hidden" name="akcjaEdytora" value="zapisz">
			<label>{{$etykieta_zapisz_jako}} </label><input type="text" name="nazwa" value="">
			<input type="submit" name="zapiszJako" value="{{$etykieta_zapisz}}" onclick="if(!eg_popraw(this.form.nazwa)) { return false; }">
		</form>
	</div>
	<div class="edytor">
		<div class="obszar_roboczy">
			<div class="obraz">
				<img id="img" src="{{$link}}{{$plik}}" alt="{{$plik}}">
			</div>
		</div>
		<div class="historia">
		<h4>{{$etykieta_nazwa}}</h4>
			<ul>
				{{BEGIN akcja}}<li {{if($wybrany,\'class="wybrany"\');}}><a href="{{$link}}" title="{{$plik}}">{{$akcja}} <a href="{{$plik}}" class="wroc"></a></a></li>{{END}}
			</ul>
		</div>
	</div>
</div>
	';


	public function html()
	{
		$dane = array(
			'plik' => '0',
			'link' => $this->konfiguracja['link']
		);

		$this->szablon->ustawGlobalne($this->tlumaczenia);

		$historia = $this->historia();

		if ($this->wybrany == 0)
		{
			$aktualnyPlikNumer = $this->aktualny;
		}
		else
		{
			$aktualnyPlikNumer = $this->wybrany;
		}

		if (isset($historia[$aktualnyPlikNumer]))
		{
			if ($historia[$aktualnyPlikNumer]['akcja'] != '')
			{
				$plik = glob($this->konfiguracja['temp'] . $aktualnyPlikNumer . '.' . $historia[$aktualnyPlikNumer]['akcja'] . '.*.' . $historia[$aktualnyPlikNumer]['rozszerzenie']);
			}
			else
			{
				$plik = glob($this->konfiguracja['temp'] . $aktualnyPlikNumer . '.*.' . $historia[$aktualnyPlikNumer]['rozszerzenie']);
			}
		}
		else
		{
			$plik = glob($this->konfiguracja['temp'] . '0.*.' . $this->rozszerzenie($this->info['nazwa']));
		}

		$plik = basename($plik[0]);
		$dane['plik'] = $plik;

		if ( ! file_exists($this->konfiguracja['temp'].$plik))
		{
			trigger_error('Brak pliku obrazu w edytorze graficznym', E_USER_WARNING);
		}

		if (is_file($this->oryginal) && is_writable($this->oryginal))
		{
			$this->szablon->ustawBlok('/zapisz');
		}

		return $this->szablon->parsujBlok('/',$dane);
	}



	public function polozenie()
	{
		return str_replace('{NUMER}', $this->wybrany + 1, $this->konfiguracja['linkHistoria']);
	}



	protected function wczytaj($sciezkaPliku, $czyOryginal = false)
	{
		if (is_file($sciezkaPliku))
		{
			$this->pobierzInfo($sciezkaPliku);
			if ( ! $czyOryginal)
			{
				$info = $this->wczytajInfo();

				if ($info['sciezka'] == $this->info['sciezka'] &&
					$info['nazwa'] == $this->info['nazwa'] &&
					$info['rozmiar'] == $this->info['rozmiar'])
				{
					$sciezkaPliku = glob($this->konfiguracja['temp'] . '0.*.' . $this->rozszerzenie($info['nazwa']))[0];

					if (file_exists($sciezkaPliku))
					{
						if ($this->wybrany > 0)
						{
							$historia = $this->historia(true);

							if (isset($historia[$this->wybrany]))
							{
								$sciezkaPliku = $this->konfiguracja['temp'] . $historia[$this->wybrany]['nazwa'];
							}
						}
						$this->img->wczytaj($sciezkaPliku);
						return true;
					}
					else
					{
						$sciezkaPliku = $this->konfiguracja['temp'] . '0.' . abs(crc32(microtime(true))) . '.' . $this->rozszerzenie(basename($info['sciezka']));
						$this->usunWszystkie(true);
						if (copy($info['sciezka'], $sciezkaPliku))
						{
							$this->img->wczytaj($sciezkaPliku);
							return true;
						}
						else
						{
							trigger_error('Edytor graficzny nie mogl skopiowac pliku do katalogu tymczasowego', E_USER_ERROR);
							return false;
						}
					}

				}
				elseif (is_writable($this->konfiguracja['temp']))
				{
					$nazwaPliku = '0.' . abs(crc32(microtime(true))) . '.' . $this->rozszerzenie(basename($sciezkaPliku));

					if (copy($sciezkaPliku, $this->konfiguracja['temp'] . $nazwaPliku))
					{
						$this->img->wczytaj($this->konfiguracja['temp'] . $nazwaPliku);
						$this->zapiszInfo();
						return true;
					}
					else
					{
						return false;
					}
				}
				else
				{
					return false;
				}
			}
			elseif (is_writable($this->konfiguracja['temp']))
			{
				$this->usunWszystkie(true);
				$nazwaPliku = '0.' . abs(crc32(microtime(true))) . '.' . $this->rozszerzenie(basename($sciezkaPliku));
				copy($sciezkaPliku, $this->konfiguracja['temp'] . $nazwaPliku);
				if ($this->img->wczytaj($this->konfiguracja['temp'] . $nazwaPliku))
				{
					$this->zapiszInfo();
				}
				return true;
			}
			else
			{
				trigger_error('Nie mozna umiescic kopi obrazu w tymczasowym katalogu', E_USER_ERROR);
				return false;
			}
		}
		else
		{
			trigger_error('Nieprawidlowy plik dla edytora graficznego do wczytania', E_USER_ERROR);
			return false;
		}
	}



	protected function historia($nieWypisuj = false)
	{
		$uchwytKatalogu = opendir($this->konfiguracja['temp']);

		if (!$uchwytKatalogu)
		{
			return false;
		}
		$pliki = array();

		while (false !== ($nazwa = readdir($uchwytKatalogu)))
		{
			$plik = $this->rozbijNazwe($nazwa);

			if (!$plik) { continue; }
			$pliki[$plik['numer']]['nazwa'] = $nazwa;
			$pliki[$plik['numer']]['akcja'] = $plik['akcja'];
			$pliki[$plik['numer']]['rozszerzenie'] = $plik['rozszerzenie'];
			if ($plik['numer'] == $this->wybrany)
			{
				$pliki[$plik['numer']]['wybrany'] = 1;
			}
			else
			{
				$pliki[$plik['numer']]['wybrany'] = 0;
			}
		}
		ksort($pliki);
		if (count($pliki) > 0 && !$nieWypisuj)
		{
			foreach ($pliki as $plik)
			{
				if ($plik['akcja'] == '')
				{
					$akcja = $this->tlumaczenia['oryginal'];
				}
				elseif ($plik['wybrany'])
				{
					$akcja = sprintf($this->tlumaczenia['aktualny'], $this->tlumaczenia[$plik['akcja']]);
				}
				else
				{
					$akcja = $this->tlumaczenia[$plik['akcja']];
				}
				$numer = $this->rozbijNazwe($plik['nazwa'])['numer'];

				$this->szablon->ustawBlok('/akcja', array(
					'akcja' => $akcja,
					'link' => str_replace('{NUMER}', $numer, $this->konfiguracja['linkHistoria']),
					'plik' => $this->konfiguracja['link'].$plik['nazwa'],
					'wybrany' => $plik['wybrany']
				));
			}
		}
		return $pliki;
	}



	protected function zapisz($nr)
	{
		$nr = (int)$nr;
		$max = 1;
		$pliki = $this->historia(true);
		if($this->aktualny > 0) { $nr = $this->aktualny; }
		if(!isset($pliki[$this->aktualny]))
		{
			foreach($pliki as $nazwa => $info)
			{
				if($nazwa > $this->aktualny)
				{
					$nr = $this->aktualny = $nazwa;
				}
			}
		}
		foreach($pliki as $nazwa => $info)
		{
			$plik = glob($this->konfiguracja['temp'].$nazwa.'.'.$info['akcja'].'.*.'.$info['rozszerzenie']);
			if(count($plik) > 0) { $plik = $plik[0]; } else { $plik = $this->konfiguracja['temp']; }
			if($plik != '..' && $plik != '.' && $nazwa > $nr && file_exists($plik) && is_file($plik))
			{
				@unlink($plik);
			}
			elseif($plik != '..' && $plik != '.' && $nazwa <= $nr && file_exists($plik) && is_file($plik))
			{
				$max = $nazwa+1;
			}
		}
		$this->aktualny = $max;
		$plik = $this->konfiguracja['temp'].$max.'.'.$this->info['akcja'].'.'.abs(crc32(microtime(true))).'.'.$this->rozszerzenie($this->info['nazwa']);
		$this->zapiszPlik($plik);
	}



	protected function zapiszPlik($url = false)
	{
		if ($url === true)
		{
			$sciezka = dirname($this->info['sciezka']);
			if(!is_dir($sciezka) || !is_writable($sciezka))
			{
				return false;
			}
		}
		else
		{
			if (!is_dir(dirname($url)) || !is_writable(dirname($url)))
			{
				return false;
			}
			else
			{
				$sciezka = $url;
			}
		}
		return $this->img->zapisz($sciezka);
	}



	protected function usunWszystkie($usunZero = false)
	{
		$pliki = $this->historia(true);
		foreach ($pliki as $nazwa => $info)
		{
			$plik = glob($this->konfiguracja['temp'].$nazwa.'.'.$info['akcja'].'.*.'.$info['rozszerzenie']);
			if (count($plik)>0)
			{
				$plik = basename($plik[0]);
			}
			if ($nazwa > 0 && file_exists($this->konfiguracja['temp'].$plik) && is_file($this->konfiguracja['temp'].$plik))
			{
				unlink($this->konfiguracja['temp'].$plik);
			}
			if ($usunZero == true)
			{
				$plik = glob($this->konfiguracja['temp'].'0.*.'.$info['rozszerzenie']);
				if (count($plik)>0)
				{
					$plik = basename($plik[0]);
					if (file_exists($this->konfiguracja['temp'].$plik) && is_file($this->konfiguracja['temp'].$plik))
					{
						unlink($this->konfiguracja['temp'].$plik);
					}
				}
			}
		}

	}



	protected function pobierzInfo($url)
	{
		$sciezka = $url;
		$nazwa = basename($url);
		$rozmiar = filesize($url);
		$this->info = array(
			'sciezka' => $sciezka,
			'nazwa' => $nazwa,
			'rozmiar' => $rozmiar,
		);
	}



	protected function zapiszInfo()
	{
		$dane = implode("\n",$this->info);
		file_put_contents($this->konfiguracja['temp'].'info',$dane);
	}



	protected function wczytajInfo()
	{
		if ( ! is_file($this->konfiguracja['temp'].'info'))
		{
			return array(
				'sciezka' => '',
				'nazwa' => '',
				'rozmiar' => '',
			);
		}
		$dane = explode("\n",file_get_contents($this->konfiguracja['temp'].'info'));

		return array(
			'sciezka' => $dane['0'],
			'nazwa' => $dane['1'],
			'rozmiar' => (int)$dane['2'],
		);
	}



	public function skaluj($szerokosc, $wysokosc, $zachowanie = 'default')
	{
		$this->info['akcja'] = 'skaluj';
		switch($zachowanie) {
			case 'skaluj':
				$this->img->skaluj($szerokosc, $wysokosc);
			break;
			case 'przytnij':
				$this->img->skalujUtnij($szerokosc, $wysokosc);
			break;
			default: $this->img->zmienRozmiar($szerokosc,$wysokosc);
		}
		$this->zapisz($this->wybrany);
	}



	public function utnij($szerokosc, $wysokosc, $pozx, $pozy)
	{
		if ($szerokosc < 1 || $wysokosc < 1)
		{
			return false;
		}

		$this->info['akcja'] = 'utnij';
		$this->img->utnij($szerokosc, $wysokosc, $pozx, $pozy);
		$this->zapisz($this->wybrany);
	}



	public function obroc($kat)
	{
		$this->info['akcja'] = 'obroc';
		$this->img->obroc($kat);
		$this->zapisz($this->wybrany);
	}



	public function odbij($kierunek = 'x')
	{
		$this->info['akcja'] = 'odbij';
		$this->img->odbij($kierunek);
		$this->zapisz($this->wybrany);
	}



	public function tekst($pozycja, $czcionka, $rozmiar, $kolor, $przezroczystosc = 0, $kat = 0, $tekst = '')
	{
		$this->info['akcja'] = 'tekst';
		$czcionka = $this->czcionka($czcionka);
		if ($czcionka == false) {
			return false;
		}
		$this->img->wstawTekst($tekst, $pozycja, $czcionka, $rozmiar, $kolor, $przezroczystosc, $kat);
		$this->zapisz($this->wybrany);
	}



	public function zrodloCzcionek($dir)
	{
		if (is_dir($dir) && is_readable($dir))
		{
			$dir = str_replace('\\', '/', $dir);
			$this->katalogCzcionek = $dir;
		}
	}



	public function czcionka($nazwa)
	{
		$dir = rtrim($this->katalogCzcionek, '/') . '/' . $nazwa . '.ttf';

		if (is_file($dir) && is_readable($dir))
		{
			return $dir;
		}
		else
		{
			return false;
		}
	}



	public function ustawKonfiguracje(Array $config)
	{
		if (isset($config['temp']))
		{
			$katalogTemp = $config['temp'];
			if(is_dir($katalogTemp) && is_writable($katalogTemp))
			{
				if($katalogTemp[strlen($katalogTemp)-1] != '/')
				{
					$katalogTemp .= '/';
				}
				$this->konfiguracja['temp'] = $katalogTemp;
			}
			else
			{
				trigger_error('Katalog "temp" ustawiony w edytorze graficznym nie zezwala na zapis danych',E_USER_ERROR);
			}
		}

		if (isset($config['link']))
		{
			$katalogLink = $config['link'];
			if ($katalogLink[strlen($katalogLink)-1] != '/')
			{
				$katalogLink .= '/';
			}
			$this->konfiguracja['link'] = str_replace('&','&amp;',$katalogLink);
		}

		if (isset($config['linkHistoria']))
		{
			$this->konfiguracja['linkHistoria'] = $config['linkHistoria'];
		}
	}



	public function pobierzKonfiguracje()
	{
		return $this->konfiguracja;
	}



	public function ustawSzablon($trescSzablonu, $plik = true)
	{
		$nowySzablon = null;
		$this->inicjujSzablon();

		if ($plik)
		{
			$nowySzablon = new Szablon();
			$nowySzablon->ladujTresc(Plik::pobierzTrescPliku($trescSzablonu));
		}
		else
		{
			$nowySzablon = new Szablon();
			$nowySzablon->ladujTresc($trescSzablonu);
		}
		if (count(array_diff($this->szablon->struktura(), $nowySzablon->struktura())) == 0)
		{
			$this->szablon = $nowySzablon;
			$this->inicjujSzablon();
			return true;
		}
		else
		{
			trigger_error('Nieprawidlowa struktura zaladowanego szablonu dla pager-a', E_USER_WARNING);
			return false;
		}
	}



	public function ustawTlumaczenia($tlumaczenia = array())
	{
		if (is_array($tlumaczenia) && $this->tlumaczenia = array_merge($this->tlumaczenia, $tlumaczenia))
		{
			return true;
		}
		return false;
	}



	public function pobierzTlumaczenia()
	{
		return $this->tlumaczenia;
	}



	protected function inicjujSzablon()
	{
		if(!($this->szablon instanceof Szablon))
		{
			$this->szablon = new Szablon();
			$this->szablon->ladujTresc($this->tpl);
		}

		$this->szablon->ustawGlobalne($this->tlumaczenia);
	}



	protected function rozszerzenie($plik)
	{
		$nazwaPliku = explode('.',$plik);
		$return = end($nazwaPliku);
		if($return != $plik)
		{
			return $return;
		}
		else
		{
			return '';
		}
	}

	protected function rozbijNazwe($plik)
	{
		if (is_file($plik))
		{
			$plik = basename($plik);
		}

		$plik = explode('.', $plik);
		if ( ! is_array($plik) || (is_array($plik) && count($plik) < 3) || strlen($plik['0']) == 0)
		{
			return false;
		}

		$nr = $plik['0'];
		$akcja = $plik['1'];

		if ($nr == 0)
		{
			$akcja = '';
			$rozszerzenie = $plik['2'];
		}
		else
		{
			$rozszerzenie = $plik['3'];
		}

		$return = array(
			'numer' => $nr,
			'akcja' => $akcja,
			'rozszerzenie' => $rozszerzenie
		);

		return $return;
	}



	public function zapiszOryginal($nazwa = null)
	{
		if (is_file($this->oryginal) && is_writable($this->oryginal) && $nazwa == null)
		{
			$this->wybrany = $this->wybrany - 1;
			return $this->img->zapisz($this->oryginal);
		}
		elseif ($nazwa != null && trim($nazwa) != '')
		{
			$this->wybrany = $this->wybrany - 1;
			$dir = dirname($this->oryginal).'/';
			if (is_dir($dir) && is_writable($dir))
			{
				$rozszerzenie = $this->rozszerzenie(basename($this->oryginal));
				$sciezka = $dir.$nazwa.'.'.$rozszerzenie;
				if (file_exists($sciezka))
				{
					return false;
				}
				return $this->img->zapisz($sciezka);
			}
		}
		return false;
	}



	public function inicjuj($url, $wybrany, $oryginal = false)
	{
		$this->konfiguracja['rand'] = rand(1,10000);
		$this->oryginal = $url;
		$this->inicjujSzablon();
		$this->img = new Grafika(new Grafika\IMagic());
		if ($wybrany == '')
		{
			$hist = $this->historia(true); // ŁW Zmienna pośrednia (php 5.4 >= Przez referencje tylko zmienne)
			$historia = end($hist);
			$nazwa = $this->rozbijNazwe($historia['nazwa']);
			$this->wybrany = $nazwa['numer'];
		}
		else
		{
			$this->wybrany = (int)$wybrany;
		}

		$temp = $this->konfiguracja['temp'];
		if ($temp[strlen($temp)-1] != '/')
		{
			$temp .= '/';
			$this->konfiguracja['temp'] = $temp;
		}
		$this->konfiguracja['link'] = str_replace('&','&amp;',$this->konfiguracja['link']);
		$this->wczytaj($url, $oryginal);
	}

}

