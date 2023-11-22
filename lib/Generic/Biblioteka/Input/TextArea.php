<?php
namespace Generic\Biblioteka\Input;
use Generic\Biblioteka\Input;
use Generic\Biblioteka\Cms;
use Generic\Biblioteka\CKEditor;
use Generic\Biblioteka\Router;


/**
 * Klasa obsługująca blok tekstowy.
 *
 * @author Krzysztof Lesiczka
 * @package biblioteki
 */

class TextArea extends Input
{
	protected $katalogSzablonu = 'TextAreaNew';
	protected $parametry = array(
		'ckeditor' => false, //czy uzyc CKEditor
		'ckeditor_config' => false, // konfiguracja CKEditor
		'ckeditor_przelacznik' => true, // czy wyświetlać przełącznik CKEditor
		'ckeditor_licznik' => true,
		'chowaj_licznik' => false, // Czy licznik my byc ciagle widoczny
        'customConfig' => '',
	);

	protected $tpl = '
	{{BEGIN edytor}}
		{{$html}}
		<script type="text/javascript">
			var p_{{$nazwa}} = { {{BEGIN atrybut}}{{$atrybut_nazwa}}:\'{{$atrybut_wartosc}}\'{{if($_last,\'\',\',\')}} {{END atrybut}} };
		</script>
		{{BEGIN przelacznik}}
			<a onclick=\'if(CKEDITOR.instances.cke_{{$nazwa}} != undefined) { CKEDITOR.instances.cke_{{$nazwa}}.destroy(); $("#cke_{{$nazwa}}").attr(p_{{$nazwa}}); } else { CKEDITOR.replace("cke_{{$nazwa}}", {{$config}}); }\' href="javascript:void(0);" class="turn_ckeditor_on_off">{{$etykieta}}</a>
		{{END przelacznik}}
	{{END edytor}}
	{{BEGIN textarea}}
		<textarea name="{{$nazwa}}" id="{{$nazwa}}" {{$atrybuty}}>{{$wartosc}}</textarea>
		{{BEGIN licznik}}
			<script type="text/javascript">
				$("#{{$nazwa}}").focus(function(){
					limitZnakow("{{$nazwa}}", \'{{$maxlength}}\', "lim_{{$nazwa}}", "{{$etykieta_limit}}");
					$("#lim_{{$nazwa}}").fadeIn("normal");
				});

				$("#{{$nazwa}}").blur(function(){
					$("#lim_{{$nazwa}}").fadeOut("normal");
				});

				$("#{{$nazwa}}").keyup(function(){
					limitZnakow("{{$nazwa}}", \'{{$maxlength}}\', "lim_{{$nazwa}}", "{{$etykieta_limit}}");
				});
			</script>
			<p><span id="lim_{{$nazwa}}" class="hide"></span>&nbsp;</p>
		{{END licznik}}
	{{END textarea}}
	';

	function pobierzHtml()
	{
		$cms = Cms::inst();
		$dane = array();
		$dane['nazwa'] = $this->nazwa;
		if ($this->parametry['ckeditor'] == true)
		{
			$input = new CKEditor('/_system/ckeditor4/');
			$input->returnOutput = true;

			switch ($cms->usluga->kod())
			{
				case 'Admin':
					$config = array(
						'customConfig' => 'config_bkt.js',
						//'extraPlugins' => 'privatefiles',
						'removePlugins' => 'scayt,smiley,templates,wsc',
						'filebrowserBrowseUrl' => Router::urlPopup('admin', 'PlikiPubliczne', 'index'),
						'filebrowserImageBrowseUrl' => Router::urlPopup('admin', 'PlikiPubliczne', 'index', array('tryb' => 'Obrazy')),
						'filebrowserFlashBrowseUrl' => Router::urlPopup('admin', 'PlikiPubliczne', 'index', array('tryb' => 'Flash')),
						'filebrowserPrivateFilesUrl' => Router::urlPopup('admin', 'PlikiPrywatne', 'index'),
					);
				break;

				case 'Http':
					$config = array(
						'customConfig' => 'config_http.js',
						'removePlugins' => 'scayt,smiley,templates,wsc',
					);
				break;

				case 'Ajax':
					$config = array(
						'customConfig' => 'config_http.js',
						'removePlugins' => 'scayt,smiley,templates,wsc',
					);
				break;

				default:
					$config = array();
				break;
			}
            if( isset($this->parametry['customConfig']) && $this->parametry['customConfig'] != '' ) {
                $config = [
                    'customConfig' => $this->parametry['customConfig'],
                    'removePlugins' => 'scayt,smiley,templates,wsc',
                ];
            }
			if (is_array($this->parametry['ckeditor_config'])) $config = array_merge($config, $this->parametry['ckeditor_config']);
			$config['language'] = KOD_JEZYKA_ITERFEJSU;
			$config['contentsLanguage'] = KOD_JEZYKA;

			if ($this->parametry['ckeditor_licznik'])
			{
				if (isset($config['extraPlugins']))
				{
					$config['extraPlugins'] = implode(',', array_merge(explode(',', $config['extraPlugins']), array('charcount')));
				}
				else
				{
					$config['extraPlugins'] = 'charcount';
				}
			}

			$dane['html'] = $input->editor($this->nazwa, $this->pobierzWartosc(), $config);

			if ($this->parametry['ckeditor_przelacznik'])
			{
				$dane['config'] = json_encode($config);
				$dane['etykieta'] = $this->tlumaczenia['input_textarea_etykieta_wlacz_wylacz'];

				if (isset($this->parametry['atrybuty']))
				{
					foreach ($this->parametry['atrybuty'] as $atrybut_nazwa => $atrybut_wartosc)
					{
						$this->szablon->ustawBlok('/edytor/atrybut', compact('atrybut_nazwa', 'atrybut_wartosc'));
					}
				}
				$this->szablon->ustawBlok('/edytor/przelacznik', $dane);
			}
			return $this->szablon->parsujBlok('edytor', $dane);
		}
		else
		{
			if (!isset($this->parametry['atrybuty']['rows']) || $this->parametry['atrybuty']['rows'] < 1) $this->parametry['atrybuty']['rows'] = 10;
			if (!isset($this->parametry['atrybuty']['cols']) || $this->parametry['atrybuty']['cols'] < 1) $this->parametry['atrybuty']['cols'] = 60;

			$dane['atrybuty'] = $this->pobierzAtrybuty();
			$dane['wartosc'] = $this->pobierzWartosc();

			if (isset($this->parametry['atrybuty']['chowaj_licznik']) && $this->parametry['atrybuty']['chowaj_licznik'])
			{
				$dane['chowaj_licznik'] = true; 
			}
			
			if (isset($this->parametry['atrybuty']['maxlength']))
			{
				$dane['maxlength'] = $this->parametry['atrybuty']['maxlength'];
				$dane['etykieta_limit'] = (isset($cms->lang['inputy']['input_textarea_etykieta_limit'])) ? $cms->lang['inputy']['input_textarea_etykieta_limit'] : '';
				$this->szablon->ustawBlok('/textarea/licznik', $dane);
			}
			return $this->szablon->parsujBlok('textarea', $dane);
		}
	}
}
