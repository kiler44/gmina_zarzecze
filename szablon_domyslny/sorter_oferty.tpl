
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
		<option value="{{ escape($url) }}" {{if($selected, 'selected="selected"')}}>{{$etykieta}}</option>
		{{END}}
	</select>
	<script type="text/javascript">
	$(document).ready(function(){
		$(".sorter select").change(function(){
			document.location.href = $(this).val();
			return false;
		});
	});
	</script>
{{END}}

{{BEGIN sorter_linki}}
	{{BEGIN link}} {{ if($_first,'',' | ') }}<li class="{{$klasa}}"><a href="{{ escape($url) }}" title="{{escape($tytul)}}">{{$etykieta}}{{if $klasa}}<var><br /></var>{{end}}</a></li>{{END}}
	{{BEGIN etykieta}} {{ if($_first,'',' | ') }}<li class="{{$klasa}}"><span>{{$etykieta}}{{if $klasa}}<var><br /></var>{{end}}</span></li>{{END}}
{{END}}


