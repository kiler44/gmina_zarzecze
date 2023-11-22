<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>{{$tytul_strony}}</title>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta name="keywords" content="{{$slowa_kluczowe}}" />
	<meta name="description" content="{{$opis_strony}}" />
	<meta http-equiv="content-language" content="{{$jezyk_strony}}" />

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="/_szablon/css/app.css" />
	<script src="/_szablon/js/app.js"></script>

	<!-- dodatkowe naglowki -->
	{{$naglowek_html}}
	{{BEGIN rss}}<link rel="alternate" type="application/rss+xml" title="{{$tytul}}" href="{{$url}}" />
	{{END}}

</head>
<body>
	<div id="logo">
		<img src="/_system/img/logo.png" alt="BKT AS" />
	</div>
	<div id="loginbox">
		{{ $region_0 }}
	</div>

</body>
</html>
