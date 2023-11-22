
{{BEGIN html}}
<div class="sorter">
	<span>{{$etykieta_sorter}}</span>
	<ul id="sortBlock">
	{{$sorter}}
	</ul>
</div>
{{END}}

{{BEGIN sorter_select}}
	<select>
		{{BEGIN opcja}}
		<option value="{{$url_seo}}" {{if($selected, 'selected="selected"')}}>{{$etykieta}}</option>
		{{END}}
	</select>
	<script type="text/javascript">
	$(document).ready(function(){
		$(".sorter select").change(function(){
			document.location.href = hexAscii($(this).val(), 'H2A');
			return false;
		});
	});
	</script>
{{END}}

{{BEGIN sorter_linki}}
	{{BEGIN link}} {{ if($_first,'',' | ') }}<li class="{{$klasa}}"><span id="hsl{{$url_seo}}" class="hsl" title="{{escape($tytul)}}">{{$etykieta}}{{if $klasa}}<var><br /></var>{{end}}</span></li>{{END}}
	{{BEGIN etykieta}} {{ if($_first,'',' | ') }}<li class="{{$klasa}}"><span>{{$etykieta}}{{if $klasa}}<var><br /></var>{{end}}</span></li>{{END}}
{{END}}


