<script type="text/javascript">
<!--
	$(document).ready(function(){
		$("#sorter").sortable({
			opacity: 0.75,
			placeholder: "ui-state-highlight",
			update: function(){
				$("#zapisz_sortowanie").fadeIn("slow");
			}
		});
		$("#zapisz_sortowanie").click(function(){
			var data = "";
			var licznik = 0;
			$("#sorter li").each(function(i){
				licznik = (i+1);
				data += licznik + "," + $(this).attr("id");
				if($("#sorter li").length != licznik)
					data += ";"
			});
			$("#sorter_form").append('<input type="hidden" name="kolejnosc" id="kolejnosc" value="" />');
			$("#kolejnosc").val(data);
			$("#sorter_form").submit();
			return false;
		});
	});
-->
</script>
<style>
	.ui-state-highlight {height:36px; line-height:36px; background-color: #e5e5e5;}
</style>
	{{BEGIN tabela}}
	<div class="sortowanie">
		<form action="{{$akcja_formularza}}" method="post" id="sorter_form">
		<table cellpadding="0" cellspacing="0" class="table table-bordered">
			<tr class="stopka_wiersz">
				<td colspan="2">
					{{$naglowek_html}}
				</td>
			</tr>
			<tr>
				<th colspan="2">
					<div class="sorter_naglowek">
		{{BEGIN kolumna_naglowka}}
						<div class="head" style="width: {{$szerokosc_kolumny}}px; float: left">{{$nazwa_kolumny}}</div>
		{{END}}
						<div class="clear"></div>
					</div>
				</th>
			</tr>
			<tr>
				<td style="padding:0px;" colspan="2">
					<ul class="sorter" id="sorter">
		{{BEGIN wiersz}}
							<li id="id:{{$klucz}}" style="clear: both; min-height:36px;">
								<div class="wiersz">
			{{BEGIN kolumna}}
									<div style="width:{{$szerokosc_kolumny}}px;" class="element">{{$wartosc}}</div>
			{{END}}
								</div>
							</li>
		{{END}}
		{{BEGIN wiersz_brak_danych}}
							<li style="clear: both; width: 100%">
								<div class="wiersz">
									{{$etykieta_brak_wierszy}}
								</div>
							</li>
		{{END}}
					</ul>
					<div class="clear"></div>
				</td>
			</tr>
		</table>
			{{$stopka_html}}
			<button class="btn btn-primary" type="submit" style="display: none" id="zapisz_sortowanie" name="akcja" value="zapisz_sortowanie">{{$etykieta_zapisz_sortowanie}}</button>
		</form>
	</div>
	{{END}}