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
<header class="gz-header">
	<div class="container">
		<div><a class="herb" href="{$URL}"><img alt="{$alt_herb}" src="/_szablon/images/svg/img-svg-01.svg" /></a></div>
		<div class="row gz-navbar-top align-items-center">
			<div class="col-md-8 col-sm-6 col-8 gz-navbar-title">
				<h2>{$TOP_TYTUL}</h2>
				<span id="gz-span-text-change" data-md-text="{$TOP_HASLO}" data-xs-text="{$TOP_HASLO}"></span>
			</div>
			<div class="col-md-4 col-sm-6 col-4 d-flex justify-content-end flex-column flex-sm-row align-items-end align-items-sm-start">
				{{ $region_1 }}
			</div>
		</div>
	</div>
</header>
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
