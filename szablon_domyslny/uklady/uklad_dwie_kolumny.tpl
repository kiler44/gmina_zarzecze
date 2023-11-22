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
	<div class="row">
		<div class="col-md-3">{{ $region_2 }}</div>
		<div class="col-md-9">{{ $region_3 }}</div>
	</div>
	<div class="row">
		<div class="col-md-3" style="background: #0e90d2;">{{ $region_0 }}</div>
		<div class="col-md-9" style="background: #2f96b4;" >{{ $region_1 }}
		</div>
	</div>
<div class="row">
	<div class="col-md-12">
		{{ $region_4 }}
	</div>
</div>
</body>
</html>
