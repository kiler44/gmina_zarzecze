<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl">
<head>
	<title>{{ $tytul_strony }}</title>
	<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
	<meta http-equiv="content-language" content="{{$jezyk_strony}}" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="/_system/css/bootstrap.css" />
	<link rel="stylesheet" href="/_system/css/bootstrap-responsive.min.css" />
	<link rel="stylesheet" href="/_system/css/font-awesome.css" />
	<link rel="stylesheet" href="/_system/css/fullcalendar.css" />
	<link rel="stylesheet" href="/_system/css/datepicker.css" />
	<link rel="stylesheet" href="/_system/css/uniform.css" />
	<link rel="stylesheet" href="/_system/css/select2.css" />
	<link rel="stylesheet" href="/_system/css/unicorn.main.css" />
	<link rel="stylesheet" href="/_system/css/unicorn.grey.css" class="skin-color" />
	<link rel="stylesheet" href="/_system/css/bkt.css" class="st-skin" />
	<script src="/_system/js/jquery.min.js"></script>
</head>

<body class="popupBox">
	{{$tresc}}
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
	<script type="text/javascript" src="/_system/_biblioteki/jquery-ui-1.7.2.custom.min.js"></script>
	<script src="/_system/js/excanvas.min.js"></script>
	<script src="/_system/js/jquery.ui.custom.js"></script>
	<script src="/_system/js/jquery.ui.datepicker.js"></script>
	<script src="/_system/js/bootstrap.min.js"></script>
	<script src="/_system/js/jquery.peity.min.js"></script>
	<script src="/_system/js/jquery.uniform.js"></script>
	<script src="/_system/js/fullcalendar.min.js"></script>
	<script src="/_system/js/bootstrap-datepicker.js"></script>
	<script src="/_system/js/jquery.uniform.js"></script>
	<script src="/_system/js/select2.min.js"></script>
	<script src="/_system/js/unicorn.js"></script>
	<script src="/_system/_biblioteki/jquery.listen.js"></script>
	<script src="/_system/_biblioteki/jquery.cookie.js"></script>
	<script src="/_system/_biblioteki/jquery.history.js"></script>
	<script src="/_system/js/st.js"></script>
	<script src="/_system/_biblioteki/funkcje_bazowe.js"></script>
</body>
</html>