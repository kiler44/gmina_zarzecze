<input type="hidden" name="{{$nazwa}}" id="{{$nazwa}}" {{$atrybuty}} />

<script type="text/javascript">
	if (jestNst == 0)
	{
		var tags = Array();
	}
	tags['{{$nazwa}}'] = [
	{{BEGIN wiersz}}
		{id: '{{$wartosc}}', text: '{{$etykieta}}', konto: '{{$konto}}'},
	{{END}}
	];
	
	$(document).ready(function(){
		
		$("#{{$nazwa}}").select2({
				multiple: false,
				data: tags['{{$nazwa}}'],
				placeholder : '{{$wybierz}}',
				createSearchChoice: function(term) {
					return {
						 id: term,
						 text: term + ' (new)'
					};
			  },
			});
 
			var obj = getObject(tags['{{$nazwa}}'], 'id', '{{$wybrane}}');
			if(obj != false)
			{
				$("#{{$nazwa}}").select2( 'val' , '{{$wybrane}}' );
			}
			else
			{
			}
			
			$("#{{$nazwa}}").on('change', function(){
				var obj = getObject(tags['{{$nazwa}}'], 'id', $(this).val());
				$('#kontoBankowe').val(obj.konto);
			});
	});
	
	function getObject(obj,key,val) 
	{
		 var newObj = false; 
		 $.each(obj, function()
		 {
			  var testObject = this; 
			  $.each(testObject, function(k,v)
			  {
					//alert(k);
					if(val == v && k == key)
					{
						 newObj = testObject;
					}
			  });
		 });

		 return newObj;
	}
	
</script>