{{BEGIN wykres}}
	<div>
		{{BEGIN chartEdit}}
			<a class="buttonSet buttonLight" href="#" onclick="openEditor(); return false;" style="float:left;">{{$etykieta_modyfikuj_wykres}}</a>
		{{END}}
	</div>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1.1', {packages: ['corechart', 'controls', 'charteditor']});
    </script>
    <script type="text/javascript">

	var chart;
	var slider;
	var table;
	var dashboard;
	var filters = new Array();

	function updateCounter()
	{
		setTimeout(function(){
			 $('#dashboard #counter var').html($('.google-visualization-table-table tbody tr').length);
		 }, 100);
	}

	function drawVisualization() {
		var data = new google.visualization.DataTable();
		{{BEGIN kolumna}}
			data.addColumn('{{$typ}}', '{{$etykieta}}');
		{{END}}
		{{BEGIN wiersz}}
			data.addRow([{{BEGIN wartosc}}{{$wartoscPola}}{{UNLESS $_last}}, {{END}}{{END}}]);
		{{END}}
		
		{{BEGIN range}}
			filters[{{$licznik}}] = new google.visualization.ControlWrapper({
				'controlType': 'NumberRangeFilter',
				'containerId': 'control{{$id}}',
				'containerClass': 'control',
				'options': {
					'filterColumnLabel': '{{$kolumna}}',
					'minValue': null,
					'maxValue': null,
					'ui': {'labelStacking': 'vertical'}
				}
			});

			google.visualization.events.addListener(filters[{{$licznik}}], 'statechange', function() {
				$('#rangeFrom{{$id}}').val(filters[{{$licznik}}].getState().lowValue);
				$('#rangeTo{{$id}}').val(filters[{{$licznik}}].getState().highValue);
				updateCounter();
			});
		{{END}}
		{{BEGIN select}}
			filters[{{$licznik}}] = new google.visualization.ControlWrapper({
				'controlType': 'CategoryFilter',
				'containerId': 'control{{$id}}',
				'options': {
					'filterColumnLabel': '{{$kolumna}}',
					'ui': {
						'labelStacking': 'vertical',
						'allowTyping': false,
						'allowMultiple': false
					}
				}
			});
			google.visualization.events.addListener(filters[{{$licznik}}], 'statechange', function() {
				updateCounter();
			});
		{{END}}
		{{BEGIN text}}
			filters[{{$licznik}}] = new google.visualization.ControlWrapper({
				'controlType': 'StringFilter',
				'containerId': 'control{{$id}}',
				'options': {
					'filterColumnLabel': '{{$kolumna}}',
					'matchType': 'any'
				}
			});
			google.visualization.events.addListener(filters[{{$licznik}}], 'statechange', function() {
				updateCounter();
			});
		{{END}}
		{{BEGIN date}}
			filters[{{$licznik}}] = new google.visualization.ControlWrapper({
				'controlType': 'ChartRangeFilter',
				'containerId': 'controlDate{{$licznik}}',
				'options': {
					// Filter by the date axis.
					'filterColumnIndex': {{$filtrujKolumne}},
					'ui': {
						'chartType': 'LineChart',
						'chartOptions': {
							'backgroundColor': '#f9f9f9',
							'chartArea': {'width': '95%'},
							'hAxis': {'baselineColor': 'none'}
						},
						// Display a single series that shows the closing value of the stock.
						// Thus, this view has two columns: the date (axis) and the stock value (line series).
						'chartView': {
							'columns': [{{$filtrujKolumne}}, {{$kolumnaWykresuDaty}}]
						},
						// 1 day in milliseconds = 24 * 60 * 60 * 1000 = 86,400,000
						'minRangeSize': 86400
					}
			   },
				// Initial range: 2012-02-09 to 2012-03-20.
				'state': {'range': {'start': new Date('{{$minimum}}'), 'end': new Date('{{$maximum}}')} }
			});
			
			google.visualization.events.addListener(filters[{{$licznik}}], 'statechange', function() {
				$('#dateFrom{{$id}}').val($.datepicker.formatDate('yy-mm-dd',new Date(String(filters[{{$licznik}}].getState().range.start))));
				$('#dateTo{{$id}}').val($.datepicker.formatDate('yy-mm-dd',new Date(String(filters[{{$licznik}}].getState().range.end))));
				updateCounter();
			});
			$('#dateFrom{{$id}}').val($.datepicker.formatDate('yy-mm-dd',new Date('{{$minimum}}')));
			$('#dateTo{{$id}}').val($.datepicker.formatDate('yy-mm-dd',new Date('{{$maximum}}')));
		{{END}}

        // Define a category picker control for the Gender column


		{{BEGIN chart}}
			chart = new google.visualization.ChartWrapper({
				'chartType': '{{$typ}}',
				'containerId': 'chart1',
				'dataTable': data,
				'options': {
					'width': '98%',
					'height': 500,
					'legend': 'true',
					'pieSliceText': 'label'
				},
				'view': {'columns': [{{BEGIN kolumna}}{{$numerKolumny}}{{UNLESS $_last}}, {{END}}{{END}}]}
			});
		{{END}}

      // Create a dashboard
		table = new google.visualization.ChartWrapper({
			'chartType': 'Table',
			'containerId': 'chart2',
			'options': {
				'width': '98%'
			},
			'dataTable': data,
			'view': {'columns': [{{BEGIN kolumnaTab}}{{$numerKolumny}}{{UNLESS $_last}}, {{END}}{{END}}]}
		});
		
		if (filters.length > 0)
		{
			$('#dashboard #counter var').html(data.length);
			dashboard = new google.visualization.Dashboard(document.getElementById('dashboard'));
			dashboard.bind(filters, [{{BEGIN chart}}chart,{{END}} table]);
			google.visualization.events.addListener(dashboard, 'ready', updateCounter);
			dashboard.draw(data);
		}
		else
		{
			{{BEGIN chart}}chart.draw(data);{{END}}
			$('#dashboard #counter var').html(data.length);
			table = new google.visualization.Table(document.getElementById('chart2'));
			google.visualization.events.addListener(table, 'ready', updateCounter);
			table.draw(data, {
				'width': '98%'
			});
			//table.draw(data);
		}
		
		initializeChartEvents();
		
	}

	  function initializeChartEvents()
	  {
		  google.visualization.events.addListener(table, 'select', function() {
				if (typeof chart != 'undefined')
					chart.getChart().setSelection(table.getChart().getSelection());
				updateCounter();
		  });

		  google.visualization.events.addListener(chart, 'select', function() {
			table.getChart().setSelection(chart.getChart().getSelection());
			updateCounter();
		  });
	  }

		{{BEGIN chart}}
			function openEditor() {
			  // Handler for the "Open Editor" button.
			  var editor = new google.visualization.ChartEditor();
			  google.visualization.events.addListener(editor, 'ok',
				function() {
				  chart = editor.getChartWrapper();
				  chart.draw(document.getElementById('chart1'));
				  if (filters.length > 0)
				  {
					  dashboard.bind(filters, [chart]);
				  }
				  initializeChartEvents();
				  updateCounter();
			  });
			  editor.openDialog(chart);
			}
		{{END}}


      google.setOnLoadCallback(drawVisualization);


	  $('#pobierzCsvOgraniczony').click(function () {

		  var zmienneUrl = '';

	  {{BEGIN text}}
		zmienneUrl += '&{{$pole}}=' + encodeURI($('#control' + ({{$licznik}} + 1) + ' input').val());
	  {{END}}
	  {{BEGIN range}}
		zmienneUrl += '&{{$pole}}=' + encodeURI($('#rangeFrom' + ({{$licznik}} + 1)).val()) + '|' + encodeURI($('#rangeTo' + ({{$licznik}} + 1)).val());
	  {{END}}
	  {{BEGIN date}}
		zmienneUrl += '&{{$pole}}=' + encodeURI(($('#dateFrom' + ({{$licznik}} + 1)).val()) + '|' + encodeURI($('#dateTo' + ({{$licznik}} + 1)).val()));
	  {{END}}
	  {{BEGIN select}}
		zmienneUrl += '&{{$pole}}=' + encodeURI(filters[{{$licznik}}].getState().selectedValues);
	  {{END}}

		window.location.href = $(this).attr('href') + zmienneUrl;
	  });
    </script>
	<style type="text/css">
		.google-visualization-table-td {word-wrap: break-word;}
	</style>
	<div id="dashboard">
		{{BEGIN filtr}}
			<div style="float:left; padding: 5px; clear: right; margin-right: 10px; width: auto" id="control{{$id}}"></div>
			{{BEGIN przyciskiRange}}
			<div style="padding-left:5px; clear:left;">
					{{$etykietaOd}} <input id="rangeFrom{{$id}}" type="text" value="" /> {{$etykietaDo}} <input id="rangeTo{{$id}}" type="text" value="" /> <input class="btn btn-info" onclick="setRange{{$id}}(); return false;" type="button" value="{{$etykietaUstaw}}" />
				<script>
					function setRange{{$id}}()
					{
						if (parseInt($('#rangeFrom{{$id}}').val()) <= parseInt($('#rangeTo{{$id}}').val()))
						{
							filters[{{$licznik}}].setState({'lowValue': parseInt($('#rangeFrom{{$id}}').val()), 'highValue': parseInt($('#rangeTo{{$id}}').val())});
							filters[{{$licznik}}].draw();
						}
						else
						{
							//TODO: confirmLightbox(null, '', '{{$komunikat_wartosci_nieprawidlowe}}', '', 'warning');
						}
					}
					
				</script>
			</div>
			{{END}}
		{{END}}

		{{BEGIN date}}
			<div style="clear:left;"></div>
			<div style="clear:left; margin:5px 0px 10px 0px; padding-left:5px;">{{$etykieta}}</div>
			<div style="clear:left; height: 50px; margin-bottom: 20px;" id="controlDate{{$licznik}}"></div>
			{{BEGIN przyciskiDate}}
			<div style="padding-left:5px; clear:left; float: left">
				<label style="float: left; margin-right: 15px">{{$etykietaOd}} <input id="dateFrom{{$id}}" type="text" value="" /></label> <label style="float: left; margin-right: 15px">{{$etykietaDo}} <input id="dateTo{{$id}}" type="text" value="" /></label> <input class="btn btn-info" onclick="setDate{{$id}}(); return false;" type="button" value="{{$etykietaUstaw}}" />
				<script>
					function setDate{{$id}}()
					{
						filters[{{$licznik}}].setState({'range': {'start': new Date($('#dateFrom{{$id}}').val()), 'end': new Date($('#dateTo{{$id}}').val())} });
						filters[{{$licznik}}].draw();
						updateCounter();
					}
					$(document).ready(function () {
						$( "#dateFrom{{$id}}" ).datepicker({
							format: 'yyyy-mm-dd',
							showOn: "both",
							buttonImage: "/_szablon/images/calendar.png",
							buttonImageOnly: true,
							monthNames: ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec', 'Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień'],
							  monthNamesShort: ['Sty', 'Lut', 'Mar', 'Kwie', 'Maj', 'Czer', 'Lip', 'Sie', 'Wrze', 'Paź', 'Lis', 'Gru'],
							  dayNames: ['Niedziela', 'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota'],
							  dayNamesShort: ['Ni', 'Pn', 'Wt', 'Śr', 'Cz', 'Pt', 'So'],
							  dayNamesMin: ['Ni', 'Pn', 'Wt', 'Śr', 'Cz', 'Pt', 'So'],
							  firstDay: [1],
						});

						$( "#dateTo{{$id}}" ).datepicker({
							format: 'yyyy-mm-dd',
							showOn: "both",
							buttonImage: "/_szablon/images/calendar.png",
							buttonImageOnly: true,
							monthNames: ['Styczeń','Luty','Marzec','Kwiecień','Maj','Czerwiec', 'Lipiec','Sierpień','Wrzesień','Październik','Listopad','Grudzień'],
							  monthNamesShort: ['Sty', 'Lut', 'Mar', 'Kwie', 'Maj', 'Czer', 'Lip', 'Sie', 'Wrze', 'Paź', 'Lis', 'Gru'],
							  dayNames: ['Niedziela', 'Poniedziałek', 'Wtorek', 'Środa', 'Czwartek', 'Piątek', 'Sobota'],
							  dayNamesShort: ['Ni', 'Pn', 'Wt', 'Śr', 'Cz', 'Pt', 'So'],
							  dayNamesMin: ['Ni', 'Pn', 'Wt', 'Śr', 'Cz', 'Pt', 'So'],
							  firstDay: [1],
						});
					});
				</script>
			</div>
			{{END}}
		{{END}}
		<div id="counter">{{$etykieta_licznik}}: <var></var></div>
		<div style="clear:left;" id="chart1"></div>
		<div style="text-align: center" id="chart2"></div>
		<div style="" id="chart3"></div>
	</div>
{{END}}