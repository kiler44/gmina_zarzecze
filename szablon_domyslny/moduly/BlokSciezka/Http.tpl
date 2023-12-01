{{BEGIN index}}
<div class="gz-breadcrumb text-lg-start text-center gz-page-title">
	<nav aria-label="">
		<ol class="breadcrumb">
	{{BEGIN link}}<li><a href="{{$url}}">{{$nazwa}}</a><var>{{$znak_rozdzielajacy}}</var></li>{{END}}
{{BEGIN tekst}}<li class="active" aria-current="page">{{$nazwa}}</li>{{END}}
		</ol>
	</nav>
</div>
{{END}}