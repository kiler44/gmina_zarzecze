{{BEGIN edytor}}
	{{$html}}
	<script type="text/javascript">
		var p_{{$nazwa}} = { {{BEGIN atrybut}}{{$atrybut_nazwa}}:'{{$atrybut_wartosc}}'{{if($_last,'',',')}} {{END atrybut}} };
	</script>
	{{BEGIN przelacznik}}
		<a onclick='if(CKEDITOR.instances.cke_{{$nazwa}} != undefined) { CKEDITOR.instances.cke_{{$nazwa}}.destroy(); $("#cke_{{$nazwa}}").attr(p_{{$nazwa}}); } else { CKEDITOR.replace("cke_{{$nazwa}}", {{$config}}); }' href="javascript:void(0);" class="turn_ckeditor_on_off btn">{{$etykieta}}</a>
	{{END przelacznik}}
{{END edytor}}
{{BEGIN textarea}}
	<textarea name="{{$nazwa}}" id="{{$nazwa}}" {{$atrybuty}}>{{$wartosc}}</textarea>
	{{BEGIN licznik}}
		<script type="text/javascript">
		var etykieta_licznik = '{{$etykieta_limit}}';
		{{IF $chowaj_licznik}}
		$("#{{$nazwa}}").live('focus', function(){
			limitZnakow("{{$nazwa}}", '{{$maxlength}}', "lim_{{$nazwa}}", "{{$etykieta_limit}}");
			$("#lim_{{$nazwa}}").fadeIn("normal");
		});

		$("#{{$nazwa}}").live('blur', function(){
			$("#lim_{{$nazwa}}").fadeOut("normal");
		});
		{{ELSE}}
		$(document).ready(function(){
			limitZnakow("{{$nazwa}}", '{{$maxlength}}', "lim_{{$nazwa}}", "{{$etykieta_limit}}");
		});
		{{END}}
		$("#{{$nazwa}}").live('keyup', function(){
			limitZnakow("{{$nazwa}}", '{{$maxlength}}', "lim_{{$nazwa}}", "{{$etykieta_limit}}");
		});
		</script>
		<p><span id="lim_{{$nazwa}}" {{IF $chowaj_licznik}}hide{{END}}></span>&nbsp;</p>
	{{END licznik}}
{{END textarea}}