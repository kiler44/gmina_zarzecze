{{BEGIN index}}
<section class="gz-section-search d-flex align-items-center">
	<img class="gz-search-ico-1" src="/_szablon/images/ico/ico-03.svg" alt="">
	<a href="#czytaj-wiecej" class="gz-cta-search-more">{{$czytaj_wiecej_input}}</a>
	<div class="container">
		<div class="row">
			<div class="col-12 col-md-10 offset-md-1">
				<form name="szukajForm" method="post" action="{{$akcjaWyszukiwarki}}" >
					<div class="input-group flex-column flex-sm-row">

						<input type="text" name="fraza" required class="form-control" placeholder="{{$placeholder_szukaj}}" aria-label="{{$placeholder_szukaj}}" />

						<select class="form-select gz-form-md-right" name="gdzie" id="gdzie">
							<option selected>{{$placeholder_gdzie_szukac}}</option>
							{{BEGIN opcja}}
							<option value="{{$wartosc}}">{{$etykieta}}</option>
							{{END}}
						</select>
					<input type="submit" class="btn gz-btn-search"  name="submit" value="{{$szukaj_button}}" />
					</div>
				</form>
			</div>
		</div>
	</div>
</section>
{{END}}