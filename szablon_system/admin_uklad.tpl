<!DOCTYPE html>
<html lang="no">
	<head>
		<title>{{ $tytul_strony }}</title>
		<meta charset="UTF-8" />
		<meta http-equiv="content-language" content="{{$jezyk_strony}}" />
		<meta name="robots" content="noindex" />
		<meta Http-Equiv="Cache-Control" Content="no-cache" />
		<meta Http-Equiv="Pragma" Content="no-cache" />
		<meta Http-Equiv="Expires" Content="0" />
		<meta Http-Equiv="Pragma-directive: no-cache" />
		<meta Http-Equiv="Cache-directive: no-cache" />
      <meta name="viewport" content="width=device-width, initial-scale=1.0" />
		<link rel="stylesheet" href="/_system/css/bootstrap.min.css" />
		<link rel="stylesheet" href="/_system/css/bootstrap-responsive.css" />
		<link rel="stylesheet" href="/_system/css/font-awesome.css" />
		<link rel="stylesheet" href="/_system/css/fullcalendar.css" />
      <link rel="stylesheet" href="/_system/css/datepicker.css" />
		<link rel="stylesheet" href="/_system/css/uniform.css" />
		<link rel="stylesheet" href="/_system/css/unicorn.main.css" />
		<link rel="stylesheet" href="/_system/css/unicorn.light.css" class="skin-color" />
		<link rel="stylesheet" href="/_system/css/bkt.css" class="st-skin" />
		<link rel="stylesheet" href="/_system/css/bkt.responsive.css" />
		<link rel="stylesheet" href="/_system/css/select2.css" />
		<link rel="stylesheet" href="/_system/css/bootstrap-timepicker.css" />
		<link rel="stylesheet" href="/_system/css/jquery.ferro.ferroSlider.css" />
		<link rel="stylesheet" href="/_system/css/lightbox.css" />

		<link href="/_system/dist/css/bootstrap-colorpicker.min.css" rel="stylesheet">
		<link href="/_system/css/bootstrap-editable.css" rel="stylesheet">


		<script src="/_system/_biblioteki/jquery-1.8.3.min.js"></script>
		<script src="/_system/_biblioteki/jquery.cookie.js"></script>
		<script src="/_system/_biblioteki/jquery.history.js"></script>
		<script src="/_system/js/jquery.optionTree.js"></script>

		<script type="text/javascript">var jest = 0; var jestNst = 0;</script>
	</head>
<body class="{{$klasa_nadrzedna}}">
<div class="modal-backdrop in mobile-loader"></div>
<div id="header">
	<h1><a href="{{$url_strona_glowna}}"></a></h1>
</div>
{{ $region_1 }}
<div id="sidebar">
	{{ $region_2 }}
</div>
<div id="content">
	{{ $region_3 }}
	{{ BEGIN region_0 }}
		{{ $region_0_tresc }}
	{{ END }}
</div>
<div id="oknoModalne2" class="modal hide fade large">
  <div class="modal-header">
    <button type="button" class="closeModal2 fR" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>&nbsp;</h3>
  </div>
  <div class="modal-body">

  </div>
</div>
<div id="oknoModalne" class="modal hide fade large">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
    <h3>&nbsp;</h3>
  </div>
  <div class="modal-body">

  </div>
</div>
<div id="alertModal" class="modal hide">
	<div class="modal-header">
		<button data-dismiss="modal" class="close" type="button">×</button>
		<h3 id="alertModalTytul"></h3>
	</div>
	<div class="modal-body">
		<p id="alertModalOpis"></p>
	</div>
	<div class="modal-footer">
		<a data-dismiss="modal" class="btn btn-primary" href="#"><i class="icon-ok"></i> OK</a>
	</div>
</div>
<div id="usunPotwierdzenie" class="modal hide">
	<div class="modal-header">
		<button data-dismiss="modal" class="close" type="button">×</button>
		<h3 id="usunPotwierdzenieTytul"></h3>
	</div>
	<div class="modal-body">
		<p id="usunPotwierdzenieOpis"></p>
	</div>
	<div class="modal-footer">
		<a id="usunPotwierdzeniePotwierdz" class="btn btn-primary" href="javascript:void(0);"><i class="icon-ok"></i> OK</a>
		<a data-dismiss="modal" class="btn" href="#"><i class="icon-remove"></i> Cancel</a>
	</div>
</div>
<div id="edytujWartoscOkno" class="modal hide">
	<div class="modal-header">
		<button data-dismiss="modal" class="close" type="button">×</button>
		<h3 id="edytujWartoscOknoTytul"></h3>
	</div>
	<div class="modal-body">
		<p id="edytujWartoscOknoOpis"></p>
		<input type="text" id="edytujWartoscOknoPole" />
	</div>
	<div class="modal-footer">
		<a id="edytujWartoscOknoPotwierdz" class="btn btn-primary" href="#"><i class="icon-ok"></i> OK</a>
		<a data-dismiss="modal" class="btn" href="#"><i class="icon-remove"></i> Cancel</a>
	</div>
</div>
		<script src="/_system/js/lightbox.js"></script>
		<script src="/_system/js/excanvas.min.js"></script>
		<!-- <script src="/_system/js/jquery.ui.custom.js"></script> -->
		<script src="/_system/js/jquery-ui-1.10.4.custom.js"></script>
		<script src="/_system/js/jquery.ui.datepicker.js"></script>
		<script src="/_system/js/bootstrap.min.js"></script>
		<script src="/_system/js/jquery.peity.min.js"></script>
		<script src="/_system/js/jquery.uniform.js"></script>
		<script src="/_system/js/fullcalendar.min.js"></script>
		<script src="/_system/js/bootstrap-datepicker.js"></script>
		<script src="/_system/js/jquery.uniform.js"></script>
		<script src="/_system/js/select2.js"></script>
		<script src="/_system/js/unicorn.js"></script>
		<script src="/_system/js/fileuploader.js"></script>
		<script src="/_system/js/fileuploader2.js"></script>
		<script src="/_system/js/unicorn.calendar.js"></script>

		<script src="/_system/_biblioteki/jquery.listen.js"></script>

		<script src="/_system/_biblioteki/jquery.cookie.js"></script>
		<script src="/_system/js/bootstrap-timepicker.min.js"></script>
		<script src="/_system/js/st.js"></script>
		<script src="/_system/_biblioteki/funkcje_bazowe.js"></script>
		<script src="/_system/dist/js/bootstrap-colorpicker.js"></script>
		<script src="/_system/js/jQueryRotateCompressed.js"></script>
		<script src="/_system/js/clipboard.min.js"></script>
		<script type="text/javascript">
			$('.full-width').css("width", "92%");
			$(document).ready(function(){

				var $root = $('html, body');
				$('a').click(function() {

					if ((typeof $(this).attr('href') != 'undefined' && $(this).attr('href').indexOf("#") == -1) && (typeof $(this).attr('rel') != 'undefined' && $(this).attr('rel') != 'lightbox'))
					{
						$('.tablet .mobile-loader').fadeIn("normal");
						var href = $.attr(this, 'href');
						$root.animate({
							 scrollTop: $(href).offset().top - 50
						}, 500, function () {
							 window.location.hash = href;
						});
					}
				});

				setTimeout(function(){
					if ($('.select2-container').length > 0)
					{
						$(window).unbind('resize.' + $('.select2-container').data('select2').containerId);
					}
				},120);

				setTimeout(function(){ $('.mobile-loader').fadeOut("fast"); },1);
			});
		</script>
	</body>
</html>