<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
	<head>
		<title>404 / SuperTraders</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<meta http-equiv="content-language" content="pl" />
		<meta name="language" content="pl" />
		<meta name="author" content="" />
		<meta name="keywords" content="" />

		<meta name="description" content="" />
		<meta name="robots" content="index, follow" />
		<link href="/_szablon/fe_css/styles.css" rel="stylesheet" type="text/css" />
		<link href="favicon.ico" rel="shortcut icon" type="image/x-icon" />
		<script type="text/javascript" src="/_szablon/fe_biblioteki/strona_glowna.min.js"></script>
		<script type="text/javascript" src="/_szablon/fe_biblioteki/funkcje_bazowe.js?1"></script>

		<script type="text/javascript">
		<!--
		$(document).ready(function(){

			$('.searchChoose').text($('li.link_wszystko').text());
			$('.searchChoose').attr('id', $('li.link_wszystko').attr('class'));

			$('#rollOptions').click(function () {
				$('#rollOptions>ul').slideToggle(100);
			});

			$('#rollOptions li').click(function () {
				$('.searchChoose').text($(this).text());
				$('.searchChoose').attr('id', $(this).attr('class'));
			});

			$('#rollOptions').mouseleave(function () {
				$('#rollOptions>ul').slideUp(100);
			});

			var link = new Array();
			$("#searchArea #searchPhraze").focus(function(){
				if($(this).val() == 'szukana fraza')
				{
					$(this).val('');
				}
			});
			$("#searchArea #searchPhraze").blur(function(){
				if($(this).val() == '')
				{
					$(this).val('szukana fraza');
				}
			});

			$("#searchArea #searchLocation").focus(function(){
				if($(this).val() == 'lokalizacja')
				{
					$(this).val('');
				}
			});
			$("#searchArea #searchLocation").blur(function(){
				if($(this).val() == ''){
					$(this).val('lokalizacja');
				}
			});


			$("#searchArea #searchSubmit").click(function(){

				if ($("#searchArea #searchPhraze").val() == '' || $("#searchArea #searchPhraze").val() == 'szukana fraza'){
					alert('Formularz wyszukiwarki nie został uzupełniony.');
					return false;
				}

				link = $('.searchChoose').attr('id');

				if($("#searchArea #searchPhraze").val() == 'szukana fraza'){
					$("#searchArea #searchPhraze").val('');
				}

				if($("#searchArea #searchLocation").val() == 'lokalizacja'){
					$("#searchArea #searchLocation").val('');
				}

				if (link =='link_wszystko') link = 'http://www.{$DOMENA}/wyszukaj/?q={FRAZA}&l={LOKALIZACJA}';
				if (link =='link_produkt') link = 'http://www.{$DOMENA}/wyszukaj/produkt/?q={FRAZA}&l={LOKALIZACJA}';
				if (link =='link_usluga') link ='http://www.{$DOMENA}/wyszukaj/usluga/?q={FRAZA}&l={LOKALIZACJA}';
				if (link =='link_firma') link = 'http://www.{$DOMENA}/wyszukaj/firma/?q={FRAZA}&l={LOKALIZACJA}';

				link = link.replace(/{FRAZA}/, encodeURIComponent($("#searchArea #searchPhraze").val()));
				document.location.href = link.replace(/{LOKALIZACJA}/, encodeURIComponent($("#searchArea #searchLocation").val()));
				return false;
			});

			$("#searchArea").submit(function(){
				$("#searchArea #searchSubmit").click();
				return false;
			});

		});
		-->
		</script>
	</head>
	<body id="page">

		<h1 class="hide">404 /SuperTraders.pl - Twoja nawigacja w biznesie</h1>

		<div id="wsBody" class="relative">
			<div id="wsTopShell">
				<div class="handle hR">
				</div>
			</div>
			<div id="wsSubTopShell"><div>
				<div id="logoShell">
					<var class="bg"><br/></var>

					<a href="http://www.{$DOMENA}/" id="logo" title="Strona główna"><span class="hide">SuperTraders.pl - Twoja nawigacja w biznesie</span></a>
				</div>
				<div class="handle">
				</div>
			</div></div>
			<div id="wsContent" class="handle">
				<div class="fClear"><br/></div>

				<div class="boxSimpleShell">
					<div class="bgTop"></div>

					<div class="content">

							<h2 class="subtitle2 fontReplace">Logowanie do wersji testowej portalu SuperTraders.pl -  Zapraszamy</h2>

							<form enctype="multipart/form-data" id="logForm" name="logForm" method="post" action="">
								<input type="hidden" name="__logForm" value="wypelniony" />

								<fieldset >
										<div class="hR mbDimA input_ok">

											<label for="login" class="textLabel  wymagany">Login <strong>*</strong></label>
											<input type="text" name="login" id="login" value="" class="long"  />


											</div>
										<div class="hR mbDimA input_ok">
											<label for="haslo" class="textLabel  wymagany">Hasło <strong>*</strong></label>
											<input type="password" id="haslo" name="haslo" value=""  />

											</div>

								</fieldset>
							<div class="submitArea">
								<input class="btn-style1" type="submit" id="wyslij" name="wyslij" value="Zaloguj się"  />
							</div>
							</form>
					</div>
				</div>
				<div class="fClear"></div>

			</div>

			<script type="text/javascript">
				<!--

				var _gaq = _gaq || []; _gaq.push(['pageTracker1._setAccount', 'UA-29997902-1']); _gaq.push(['pageTracker1._setDomainName',   '.supertraders.pl']); _gaq.push(['pageTracker1._addIgnoredRef', 'supertraders.pl']); _gaq.push(['pageTracker1._trackPageview']); _gaq.push  (['pageTracker1._trackPageLoadTime']);
				_gaq.push(['pageTracker2._setAccount', 'UA-29991079-1']); _gaq.push  (['pageTracker2._setDomainName', '.supertraders.pl']); _gaq.push  (['pageTracker2._addIgnoredRef', 'supertraders.pl']); _gaq.push(['pageTracker2._trackPageview']);
				(function() { var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true; ga.src = ('https:' ==   document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js'; var s = document.getElementsByTagName('script')[0];   s.parentNode.insertBefore(ga, s);   })();
				-->
			</script>

	</body>
</html>