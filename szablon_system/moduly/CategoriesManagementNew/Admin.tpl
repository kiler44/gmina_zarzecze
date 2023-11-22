{{BEGIN index}}
<script type="text/javascript">
<!--
$(document).ready(function(){
	$(".grid .wiersz").hover(
		function() {$(this).addClass("highlight");},
		function() {$(this).removeClass("highlight");}
	);
});
-->
</script>
<div class="przyciskiFunkcyjne">
	<a href="{{$link_sortowanie}}" class="btn" title="{{$etykieta_link_sortowanie}}"><i class="icon-random"></i> {{$etykieta_link_sortowanie}}</a>
	<a href="{{$link_usun_wszystkie}}" class="btn" title="{{$etykieta_link_usun_wszystkie}}" onclick="return confirm('{{$etykieta_link_usun_wszystkie_pytanie}}');"><i class="icon-undo"></i> {{$etykieta_link_usun_wszystkie}}</a>
	<a href="{{$link_przebudowa}}" class="btn" title="{{$etykieta_link_przebudowa}}"><i class="icon-refresh"></i> {{$etykieta_link_przebudowa}}</a>
	{{BEGIN przyciski}}
	<a href="{{$link_pobierz_konfiguracje}}" class="btn" title="{{$etykieta_link_pobierz_konfiguracje}}"><i class="icon-download-alt"></i> {{$etykieta_link_pobierz_konfiguracje}}</a>
	<a href="{{$link_wczytaj_konfiguracje}}" class="btn" title="{{$etykieta_link_wczytaj_konfiguracje}}"><i class="icon-share"></i> {{$etykieta_link_wczytaj_konfiguracje}}</a>
	{{END}}
</div>
<div class="widget-box">
	<div class="widget-content nopadding">
		<table class="table table-bordered table-striped table-hover">
		<thead>
			<tr class="naglowek">
				<th>{{$etykieta_nazwa_kategorii}}</th>
				<th width="10"></th>
				<th width="80">&nbsp;</th>
			</tr>
		</thead>
		<tbody>
		{{BEGIN kategoria_glowna}}
		<tr class="wiersz">
			<td colspan="2">
				<span class="treeLvl{{$poziom}} {{if($widoczna, '', ' katUkr')}}">{{$nazwa_kategorii}}</span>
			</td>
			<td class="przyciski">
				<div class="btn-group">
					<a class="btn btn-success" href="{{$link_dodaj}}" title="{{$etykieta_link_dodaj}}"><i class="icon-plus-sign"></i></a>
					<a class="btn" href="#" title="-">&nbsp;&nbsp;&nbsp;</a>
					<a class="btn" href="#" title="-">&nbsp;&nbsp;&nbsp;</a>
				</div>
			</td>
		</tr>{{END}}
		{{BEGIN kategoria}}
		<tr class="wiersz">
			<td>
				{{BEGIN link_start}}<a href="{{$link_tresc}}" class="{{$poziom}}" title="{{$etykieta_link_tresc}}">{{END}}<span class="treeLvl{{$poziom}} m{{$poziom}}{{if($widoczna, '', ' katUkr')}}">{{$nazwa_kategorii}} {{if($modul, '<em>\(')}}{{$modul}}{{if($modul, ')</em>')}}</span>{{BEGIN link_end}} <i class="icon-pencil"></i></a>{{END}}
			</td>
			<td>{{IF $widoczna}}<i class="icon icon-eye-open"></i>{{END}}</td>
			<td class="przyciski">
				<div class="btn-group">
					<a class="btn btn-success" href="{{$link_dodaj}}" title="{{$etykieta_link_dodaj}}"><i class="icon-plus-sign"></i></a>
					<a class="btn btn-primary" href="{{$link_edycja}}" title="{{$etykieta_link_edytuj}}"><i class="icon-pencil"></i></a>
					<a class="btn btn-danger" href="{{$link_usun}}" title="{{$etykieta_link_usun}}" onclick="return potwierdzenieUsun('{{$etykieta_link_usun_pytanie}}', $(this));"><i class="icon-remove"></i></a>
				</div>
			</td>
		</tr>{{END}}
		</tbody>
		</table>
	</div>
</div>
{{END}}


{{BEGIN dodaj}}
{{$formularz}}
<script type="text/javascript">
<!--

function uzupelnijKod1(){
	$("#kod").val(tworzKodBezPl($("#nazwa").val()));
	$("#pelnyLink").val("{{$sciezka}}" + $("#kod").val());
}

function uzupelnijKod2() {
	$("#kod").val(tworzKodBezPl($("#kod").val()));
	$("#pelnyLink").val("{{$sciezka}}" + $("#kod").val());
}

function kopiujTekst(id_zrodla, id_celu)
{
	$("#"+id_celu).val($("#"+id_zrodla).val());
}


$(document).ready(function() {

	$("#pelnyLink").val("{{$sciezka}}" + $("#kod").val());

	$("#nazwa").change(function () {uzupelnijKod1();});
	$("#nazwa").keyup(function () {uzupelnijKod1();});
	$("#kod").change(uzupelnijKod2);
	$("#kod").keyup(uzupelnijKod2);
	$("#kod").blur(uzupelnijKod2);
});
-->
</script>
{{END}}


{{BEGIN edytuj}}
{{$formularz}}
<script type="text/javascript">
<!--

function uzupelnijKod1(){
	$("#kod").val(tworzKodBezPl($("#nazwa").val()));
	$("#pelnyLink").val("{{$sciezka}}" + $("#kod").val());
}

function uzupelnijKod2() {
	$("#kod").val(tworzKodBezPl($("#kod").val()));
	$("#pelnyLink").val("{{$sciezka}}" + $("#kod").val());
}

function kopiujTekst(id_zrodla, id_celu)
{
	$("#"+id_celu).val($("#"+id_zrodla).val());
}


$(document).ready(function() {

	$("#pelnyLink").val("{{$sciezka}}" + $("#kod").val());

	$("#nazwa").change(function () {uzupelnijKod1();});
	$("#nazwa").keyup(function () {uzupelnijKod1();});
	$("#kod").change(uzupelnijKod2);
	$("#kod").keyup(uzupelnijKod2);
	$("#kod").blur(uzupelnijKod2);
});
-->
</script>
{{END}}


{{BEGIN sortowanie}}
<link rel="stylesheet" type="text/css" href="/_system/_biblioteki/tree_component.css" />
<script type="text/javascript" src="/_system/_biblioteki/jquery-ui-1.7.2.custom.min.js"></script>
<script type="text/javascript" src="/_system/_biblioteki/jquery.optionTree.js"></script>
<script type="text/javascript" src="/_system/_biblioteki/tree_component.min.js"></script>
<script type="text/javascript" src="/_system/_biblioteki/css.js"></script>
<div class="kategorieSortowanie">
{{$form}}
<script type="text/javascript">
<!--
$(function(){
$("#sortowanieKategorii").tree({
	cookies: true,
	ui: {
		theme_name  : "default",
		animation: 100
	},
	rules : {
		draggable: ["sortowalnaKategoria" ],
		dragrules: ["sortowalnaKategoria inside sortowalnaKategoria" ,
					"sortowalnaKategoria after sortowalnaKategoria",
					"sortowalnaKategoria before sortowalnaKategoria",
					"sortowalnaKategoria inside niesortowalnaKategoria"
					]
	},
	callback: {
		onmove : function(NODE,REF_NODE,TYPE) {
			$("#przenoszona").val(NODE.id);
			$("#cel").val(REF_NODE.id);
			$("#polozenie").val(TYPE);
			$("#formularzSortowanie").submit();
		}
	},
	opened: [{{$rozwin}}]
});
});
-->
</script>
</div>
{{END}}


{{BEGIN bledy}}

	<br />
	<h3>Niezaimportowane bloki:</h3>
	(Proszę przypisać brakujące moduły do projektu i zaimportować konfiguracje jeszcze raz.)
	{{BEGIN blad_brak_modulu}}
	<p>Brak modułu: "{{$kod_modulu}}" - niezaimportowano bloku: "{{$nazwa}}".</p>
	{{END}}

{{END}}