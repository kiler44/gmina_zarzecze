<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\Zadanie;


/**
 * Klasa obsługująca upload zdjęć z podglądem zdjęcia.
 *
 * @author Krzysztof Lesiczka, modyfikacja Łukasz Wrucha, Konrad Rudowski
 * @package biblioteki
 */

class ZdjecieCropowane extends Input
{
	protected $katalogSzablonu = 'PhotoCropperNew';
	protected $tpl = '
	<div class="section">
        <div class="info-gray clearfix">
        {{BEGIN jest_zdjecie}}
        	<input type="hidden" name="{{$nazwa}}" id="{{$nazwa}}" value="{{$zdjecie_name}}" {{$atrybuty}} />
        	{{IF $miniaturka}}<a href="{{$sciezka_plikow}}{{$zdjecie_name}}" rel="lightbox"><img class="inputZdjecieMiniatura" alt="" src="{{$sciezka_plikow}}{{$link_miniaturka}}"></a>{{END}}
        	<div class="right-upload">
        		{{BEGIN usun}}<a href="{{$link_usun}}" class="remove" title="{{$etykieta_usun}}" {{IF $potwierdz_usun}}onclick="return confirmLightbox(this, \'{{$etykieta_usun_tytul}}\', \'{{$etykieta_usun_pytanie}}\', \'eWarning\', \'confirm\')"{{END}}>{{$etykieta_usun}} <span></span></a>{{END}}
        	</div>
        	<div class="upload {{$nazwa}}">
        	{{IF $opis}}{{$etykieta_opis}} <input type="text" name="{{$nazwa}}_title" id="{{$nazwa}}_title" value="{{$zdjecie_description}}" /><br />{{END}}
        	<a href="{{$sciezka_plikow}}{{$zdjecie_name}}">{{$zdjecie_name}}</a>
			{{IF $popraw_miniature}}<a href="javascript:void(0);" class="popraw_miniature przyciskEdytuj" id="{{$nazwa}}_link_popraw" title="{{$etykieta_popraw}}"></a>{{END}}
			{{IF $pokaz_dozwolone_typy}}<p>{{$etykieta_dozwolone_typy}} {{$dozwolone_typy}}</p>{{END}}
			</div>
        {{END}}
        {{BEGIN brak_zdjecia}}
        	<div class="upload">
        	<input type="file" name="{{$nazwa}}" id="{{$nazwa}}" value="" {{$atrybuty}} />
			{{IF $pokaz_dozwolone_typy}}<p>{{$etykieta_dozwolone_typy}} {{$dozwolone_typy}}</p>{{END}}
			</div>
        {{END}}
		</div>
	</div>
	{{BEGIN obsluga_poprawy_miniaturek}}
		<script>
			$(document).ready(function () {
				$(\'#{{$nazwa}}_link_popraw\').live(\'click\', function () {
					$(\'#cboxLoadedContent\').html(\'\');

					$.fn.colorbox({
						href: "{{$link_popraw_miniaturke}}",
						width: (666 + 150),
						height: 695,
						iframe: true,
						rel: "nofollow",
						onClosed: function () {},
						onComplete: function () {
							if($(\'#cboxLoadedContent\').html().search(\'Request unsuccessful.\') != -1)
							{
								$(\'#cboxLoadedContent\').html(\'{{$etykieta_blad}}\');
								$(\'.komunikat\').css(\'margin-top\' , \'40px\');
							}
						}
					});
				});
			});
		</script>
	{{END}}
	';

	protected $parametry = array(
		'sciezka_plikow' => '', // okresla url katalogu w ktorym znajduje sie plik
		'link_usun' => '', // url do usuwania zdjecia, jezeli dodany pokaze sie link do usuwania
		'link_miniaturka' => '', // url miniaturki zdjecia, jezeli podany wyswietli miniaturke
		'link_popraw_miniaturke' => '', //url do poprawiania miniaturki zdjecia, jezeli dodany pokaze sie ekran do poprawiania miniaturki
		'rozmiary_miniaturek' => array(), // tablica z rozmiarami miniaturek w formacie array('kod_miniaturki' => 'szerokosc.wysokosc.kod_operacji'
		'dozwolone_typy' => '',
		'etykieta_usun' => '',
	);



	protected $tlumaczenia = array(
		'input_zdjecie_etykieta_usun' => 'Usuń to zdjęcie',
		'input_zdjecie_etykieta_usun_tytul' => 'Usuwanie obrazu',
		'input_zdjecie_etykieta_usun_pytanie' => 'Czy na pewno usunąć obraz?',
		'input_zdjecie_etykieta_popraw' => 'Popraw miniaturke',
		'input_zdjecie_etykieta_wybierz' => 'Wybierz miniaturke: ',
		'input_zdjecie_etykieta_zatwierdz' => 'Zatwierdź',
		'input_zdjecie_etykieta_opis' => 'Opis: ',
		'input_zdjecie_etykieta_dozwolone_typy' => 'Dozwolone typy plików: ',
		'input_zdjecie_etykieta_blad' => 'Wystąpił błąd.',
	);


	function pobierzHtml()
	{
		$zdjecie = $this->pobierzWartosc();

		$dane = array(
			'nazwa' => $this->pobierzNazwe(),
			'atrybuty' => $this->pobierzAtrybuty(),

			'etykieta_usun' => $this->tlumaczenia['input_zdjecie_cropowane_etykieta_usun'],
			'etykieta_usun_tytul' => $this->tlumaczenia['input_zdjecie_cropowane_etykieta_usun_tytul'],
			'etykieta_usun_pytanie' => $this->tlumaczenia['input_zdjecie_cropowane_etykieta_usun_pytanie'],
			'etykieta_popraw' => $this->tlumaczenia['input_zdjecie_cropowane_etykieta_popraw'],
			'etykieta_wybierz' => $this->tlumaczenia['input_zdjecie_cropowane_etykieta_wybierz'],
			'etykieta_zatwierdz' => $this->tlumaczenia['input_zdjecie_cropowane_etykieta_zatwierdz'],
			'etykieta_opis' => $this->tlumaczenia['input_zdjecie_cropowane_etykieta_opis'],
			'etykieta_dozwolone_typy' => $this->tlumaczenia['input_zdjecie_cropowane_etykieta_dozwolone_typy'],
			'etykieta_blad' => $this->tlumaczenia['input_zdjecie_cropowane_etykieta_blad'],
		);

		$this->szablon->ustawGlobalne($dane);

		$link_usun = null;
		$popraw_miniature = false;
		$opis = null;

		if ($zdjecie['name'] != '' && (!isset($zdjecie['tmp_name']) || $zdjecie['tmp_name'] == ''))
		{
			$dane['jest_zdjecie'] = array(
				'zdjecie_name' => $zdjecie['name'],
				'sciezka_plikow' => $this->parametry['sciezka_plikow'],
				'link_miniaturka' => $this->parametry['link_miniaturka'],
				'cacheDumper' => '?'.time(),
			);

			if ($this->parametry['link_miniaturka'] != '')
			{
				$dane['jest_zdjecie']['miniaturka'] = true;
			}

			if ($this->parametry['link_usun'] != '' && $this->parametry['link_miniaturka'] != '')
			{
				$dane['jest_zdjecie']['usun'] = array(
					'link_usun' => $this->parametry['link_usun'],
					'potwierdz_usun' => ( ! key_exists('sprawdz_usun', $this->parametry) || $this->parametry['sprawdz_usun'] != false) ? true : false,
				);
			}

			if ($this->parametry['link_popraw_miniaturke'] != '')
			{
				$popraw_miniature = true;
				if (!is_array($this->parametry['rozmiary_miniaturek']) || empty($this->parametry['rozmiary_miniaturek']))
				{
					trigger_error('Brak lub nieprawidlowy parametr \'rozmiary_miniaturek\'', E_USER_WARNING);
				}
				else
				{
					$dane['jest_zdjecie']['popraw_miniature'] = true;
				}
			}

			if (isset($zdjecie['description']))
			{
				$dane['jest_zdjecie']['opis'] = true;
				$dane['jest_zdjecie']['zdjecie_description'] = $zdjecie['description'];
			}

			if ($this->parametry['dozwolone_typy'] != '')
			{
				$dane['jest_zdjecie']['pokaz_dozwolone_typy'] = true;
				$dane['jest_zdjecie']['dozwolone_typy'] = strtoupper($this->parametry['dozwolone_typy']);
			}
		}
		else
		{
			$dane['brak_zdjecia'] = array(
				'nazwa' => $this->pobierzNazwe(),
			);
			if ($this->parametry['dozwolone_typy'] != '')
			{
				$dane['brak_zdjecia']['pokaz_dozwolone_typy'] = true;
				$dane['brak_zdjecia']['dozwolone_typy'] = strtoupper($this->parametry['dozwolone_typy']);
			}
		}

		if ($popraw_miniature !== null)
		{
			$dozwoloneMiniatury = Cms::inst()->sesja->dozwoloneMiniatury;
			$dozwoloneMiniatury[$this->parametry['sciezka_plikow'].$zdjecie['name']] = $this->parametry['rozmiary_miniaturek'];
			Cms::inst()->sesja->dozwoloneMiniatury = $dozwoloneMiniatury;

			$dane['obsluga_poprawy_miniaturek'] = array(
				'link_popraw_miniaturke' => $this->parametry['link_popraw_miniaturke'],
			);
		}

		$this->szablon->ustaw($dane);

		return $this->szablon->parsuj();
	}





	/**
	 * Ustawia wartosc poczatkowa inputa.
	 *
	 * @param mixed $wartoscPoczatkowa Wartosc poczatkowa inputa,
	 * powinna to byc tablica zawierajaca:
	 * - nazwe pliku (pole: 'name'),
	 * - ewantualnym opisem (pole: 'description')
	 * @param bool $wymus wymuszanie nadpisania wartosc.
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
		$opis = Zadanie::pobierz($this->pobierzNazwe().'_title');
		if (isset($_FILES[$this->pobierzNazwe()]))
		{
			$temp = $_FILES[$this->pobierzNazwe()];
			if ($opis !== null) $temp['description'] = $opis;
			$this->wartosc = $this->filtrujWartosc($temp);
			unset($temp);
		}
		elseif (Zadanie::pobierz($this->pobierzNazwe()) !== null)
		{
			$temp['name'] = Zadanie::pobierz($this->pobierzNazwe());
			if ($opis !== null) $temp['description'] = $opis;
			$this->wartosc = $this->filtrujWartosc($temp);
			unset($temp);
		}
		else
		{
			$this->wartosc = $this->pobierzWartoscPoczatkowa();
		}
		return $this->wartosc;
	}



	/**
	 * Filtruje wartosc podana w argumencie
	 *
	 * @param array $tablica Wartosc do filtrowania.
	 * @return array Wartosc po zastosowaniu filtrow.
	 */
	protected function filtrujWartosc($tablica)
	{
		if (isset($tablica['description']))
		{
			foreach($this->filtry as $filtr)
			{
				$tablica['description'] = $filtr($tablica['description']);
			}
		}
		$this->filtrowany = true;
		return $tablica;
	}



	/**
	 * Sprawdza czy input zostal zmodyfikowany.
	 *
	 * @return bool True jezel input zostal zmodyfikowany, false w przeciwnym wyadku.
	 */
	function zmieniony()
	{
		$wartoscPoczatkowa = $this->pobierzWartoscPoczatkowa();
		if ((isset($_FILES[$this->pobierzNazwe()]) && is_uploaded_file($_FILES[$this->pobierzNazwe()]['tmp_name']))
			||(isset($this->wartosc['description']) && $this->wartosc['description'] != $wartoscPoczatkowa['description']))
			return true;
		else
			return false;
	}




}

