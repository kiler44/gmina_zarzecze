<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;


/**
 * Klasa obsługująca pole wyboru bannera.
 *
 * @author KonradRudowski
 * @package biblioteki
 */

class WyborBannera extends Input
{
	protected $katalogSzablonu = 'BannerChoiceNew';
	protected $tpl = '
	<div id="{{$nazwa}}_kontener">
		<p class="mb"><input {{IF $kolor_checked}}checked="checked"{{END}} onclick="wybierzKolor(); aktualizujPodgladBannera();" type="radio" name="{{$nazwa}}" value="" id="{{$nazwa}}_kolor" class="noinput" {{$atrybuty}}/><label for="{{$nazwa}}_kolor" class="long">{{$etykieta_kolor}}</label></p>
		<div class="info-gray">{{$kolorTla_Input}}</div>
		<p class="mb mt"><input {{IF $checked}}checked="checked"{{END}} onclick="aktualizujPodgladBannera();" type="radio" name="{{$nazwa}}" value="wbudowany" id="{{$nazwa}}_gotowy" class="noinput" {{$atrybuty}}/><label style="width:150px;" for="{{$nazwa}}_gotowy">{{$etykieta_gotowy}}</label></p>
		<div class="banners collapsible-container"><div style="height:230px; overflow:hidden;" id="{{$nazwa}}_listaBannerow" class="info-gray">
			<ul>
			{{BEGIN lista}}
				<li {{IF $clear}}class="clear"{{END}} id="{{$nazwa}}listaBannerow_element_{{$klucz_zamieniony}}">
					<a href="{{$url}}" rel="lightbox" style="display:block;"><img style="margin:10px; width:329px;" src="{{$url}}" alt="" /></a>
					<a class="buttonSet buttonLight3 fR" onclick="wybierzBanner(\'{{$klucz}}\');">{{$etykieta_wybierz}}</a>
				</li>
			{{END}}
			</ul>
		</div>
		<div class="collapsible-control">
			<a onclick="pokazWiecejBannerow(2);" id="pokazWiecejBtn" style="float:right;">{{$etykieta_wiecej_bannerow}}</a>
			<a onclick="pokazMniejBannerow(2);" id="pokazMniejBtn" style="float:right; display:none; margin-right:10px;">{{$etykieta_mniej_bannerow}}</a>
		</div>
		{{BEGIN wlasny_banner}}
			<p class="mb mt"><input {{IF $wlasny_checked}}checked="checked"{{END}} onclick="wybierzWlasnyBanner();" type="radio" name="{{$nazwa}}" value="wlasny" id="{{$nazwa}}_wlasny" class="noinput" {{$atrybuty}}/><label for="{{$nazwa}}_wlasny">{{$etykieta_wlasny}}</label></p>
			{{$wlasnyBanner_Input}}
		{{END}}
		<input name="{{$nazwa}}_wbudowany" type="hidden" id="{{$nazwa}}" value="{{$wbudowany_wartosc}}">
	</div>
	<script>
		var ustawionyKolorTla = $("#kolorTla").val();
		var poprzedniBanner = "";
		function wybierzKolor()
		{
			$("#kolorTla").val(ustawionyKolorTla);
		}

		function wybierzBanner(banner)
		{
			if ($("#kolorTla").val() != "")
			{
				ustawionyKolorTla = $("#kolorTla").val();
			}
			$("#kolorTla").val("");
			$("#{{$nazwa}}").val(banner);
			$("#{{$nazwa}}_gotowy").attr("checked", true);
			zaladujBaner();

			if (poprzedniBanner != "")
			{
				$("#" + poprzedniBanner).css("backgroundColor", "");
				$("#" + poprzedniBanner + " span").css("display", "block");
			}
			$("#{{$nazwa}}listaBannerow_element_" + banner.replace(".", "_")).css("backgroundColor", "#ddd");
			poprzedniBanner = "{{$nazwa}}listaBannerow_element_" + banner.replace(".", "_");
			$("#" + poprzedniBanner + " span").css("display", "none");
		}

		function wybierzWlasnyBanner()
		{
			if ($("#kolorTla").val() != "")
			{
				ustawionyKolorTla = $("#kolorTla").val();
			}
			$("#kolorTla").val("");
			$("#{{$nazwa}}").val("wlasny");
			zaladujBaner();
		}

		function pokazWiecejBannerow(ileWierszy)
		{
			$("#pokazMniejBtn").css("display", "block");

			var max = {{$max_bannerow}};
			var krok = 115;

			var wysokosc = parseInt($("#{{$nazwa}}_listaBannerow").css("height").replace("px", ""));

			var nowaWysokosc = wysokosc + ileWierszy * krok;
			if ((max * krok) < (wysokosc + ileWierszy * krok))
			{
				nowaWysokosc = max * krok;
				$("#pokazWiecejBtn").css("display", "none");
			}

			$("#{{$nazwa}}_listaBannerow").css("height", nowaWysokosc + "px");

		}

		function pokazMniejBannerow(ileWierszy)
		{
			$("#pokazWiecejBtn").css("display", "block");

			var max = {{$max_bannerow}};
			var krok = 115;

			var wysokosc = parseInt($("#{{$nazwa}}_listaBannerow").css("height").replace("px", ""));

			var nowaWysokosc = wysokosc - ileWierszy * krok;
			if ((krok * 4) > (wysokosc - ileWierszy * krok))
			{
				nowaWysokosc = 2 * krok;
				$("#pokazMniejBtn").css("display", "none");
			}

			$("#{{$nazwa}}_listaBannerow").css("height", nowaWysokosc + "px");

		}
	</script>
	';

	protected $parametry = array(
		'lista' => array(),
		'inline' => false,
		'urlKatalogu' => '',
		'prefix' => '',
		'sciezkaPlikow' => '',
		'linkUsun' => '',
		'dozwolone_formaty_zdjec' =>  array(
			'jpg', 'png', 'jpeg', 'gif', 'jpe'
		),
		'dodawanie_wlasnego_bannera' => true,
	);

	protected $tlumaczenia = array(
		'etykieta_kolor' => 'Tylko kolor tła bez banera graficznego',
		'etykieta_gotowy' => 'Gotowy baner graficzny',
		'etykieta_wlasny' => 'Własny baner',
		'etykieta_wybierz' => 'Wybierz',
		'etykieta_wiecej_bannerow' => 'Pokaż więcej banerów',
		'etykieta_mniej_bannerow' => 'Pokaż mniej banerów',
		'etykieta_usunBanner' => 'Usuń baner',
	);


	function pobierzHtml()
	{
		$banner = $this->pobierzWartosc();

		//ustawienie koloru jeśli nie można dodać własnego bannera, a ten był wcześniej ustawiony
		if ($this->parametry['dodawanie_wlasnego_bannera'] == false && $banner['rodzajBannera'] == 'wlasny')
		{
			$banner['rodzajBannera'] = 'wbudowany';
		}

		$selected = '';//($klucz == $this->pobierzWartosc()) ? 'checked="checked"' : null;

		$kolorTla = new Input\Colorpicker('kolorTla', array(
			'wartosc' => $banner['kolorTla'],
			'click' => array('$("#'.$this->nazwa.'").val(\'\'); $("#'.$this->nazwa.'_kolor").attr("checked", true); aktualizujPodgladBannera();'),
		));

		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'atrybuty' => $this->pobierzAtrybuty(),

			'kolor_checked' => (($banner['rodzajBannera'] == 'wbudowany' || $banner['rodzajBannera'] == '') && $banner['bannerWbudowany'] == '') ? true : false,
			'wbudowany_checked' => ($banner['rodzajBannera'] == 'wbudowany' && $banner['bannerWbudowany'] != '') ? true : false,
			'kolorTla_Input' => $kolorTla->pobierzHtml(),
			'wbudowany_wartosc' => ($banner['rodzajBannera'] == 'wlasny') ? 'wlasny' : $banner['bannerWbudowany'],

			'etykieta_kolor' => $this->tlumaczenia['etykieta_kolor'],
			'etykieta_gotowy' => $this->tlumaczenia['etykieta_gotowy'],
			'etykieta_wlasny' => $this->tlumaczenia['etykieta_wlasny'],
			'etykieta_wybierz' => $this->tlumaczenia['etykieta_wybierz'],
			'etykieta_wiecej_bannerow' => $this->tlumaczenia['etykieta_wiecej_bannerow'],
			'etykieta_mniej_bannerow' => $this->tlumaczenia['etykieta_mniej_bannerow'],
			'etykieta_usunBanner' => $this->tlumaczenia['etykieta_usunBanner'],
		);

		$this->szablon->ustawGlobalne($dane);

		$ileBannerow = 0;

		foreach ($this->parametry['lista'] as $klucz => $wartosc)
		{
			$dane['lista'][] = array(
				'url' => $this->parametry['urlKatalogu'] . $klucz,
				'klucz' => $klucz,
				'klucz_zamieniony' => str_replace('.', '_', $klucz),
				'clear' => ($ileBannerow % 2 == 0) ? true: false,
			);

			++$ileBannerow;
		}


		if ($this->parametry['dodawanie_wlasnego_bannera'])
		{
			$wlasnyBanner = new Input\Zdjecie('bannerWlasny', array(
				'wartosc' => array('name' => (($banner['bannerWlasny'] != '') ? $banner['bannerWlasny'] : '')),
				'sciezka_plikow' => $this->parametry['sciezkaPlikow'],
				'link_usun' => $this->parametry['linkUsun'],
				'link_miniaturka' => ($banner['bannerWlasny'] != '') ? $this->parametry['prefix'].$banner['bannerWlasny'] : '',
				'dozwolone_typy' => implode(', ', $this->parametry['dozwolone_formaty_zdjec']),
				'etykieta_usun' => $this->tlumaczenia['etykieta_usunBanner'],
			));

			$dane['wlasny_banner'] = array(
				'wlasny_checked' => ($banner['rodzajBannera'] == 'wlasny') ? true : false,
				'wlasnyBanner_Input' => $wlasnyBanner->pobierzHtml()
			);
		}

		$dane['max_bannerow'] = round($ileBannerow / 2, 0);
		$this->szablon->ustaw($dane);

		return $this->szablon->parsuj();
	}

}
