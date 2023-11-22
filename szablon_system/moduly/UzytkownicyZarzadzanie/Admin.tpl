{{BEGIN index}}
<div class="widget-box">
<div class="przyciskiFunkcyjne">
	<a href="{{$link_dodaj}}" class="btn" onclick="this.blur();" title="{{$etykieta_link_doadaj}}"><i class="icon-plus-sign"></i> {{$etykieta_link_doadaj}}</a>
</div>
		{{$tabela_danych}}
</div>
{{END}}

{{BEGIN dodaj}}
<script type="text/javascript">
	
	$(document).ready(function(){
		$('#stawkaGodzinowa').on('keyup', function(){
			$(this).val($(this).val().replace(',','.'));
		});
		$('#stawka_stawka').on('keyup', function(){
			$(this).val($(this).val().replace(',','.'));
		});
		
	});
	
	
</script>
	{{$form}}
{{END}}

{{BEGIN import}}
	{{$form}}
{{END}}