@extends('layouts.client-master')
@section('css')
    <link type="text/css" rel="stylesheet" href="/assets/css/client-side/custom.css" /> 
	<link type="text/css" rel="stylesheet" href="assets/css/client-side/footer.css" />
@endsection
@section('public-content') 
	<div class="mainContent">
		<div class="container">
			<div class="detailP">
				<p>{{ $service->name }}nə</p> 
				<h3>müraciət edin</h3>
			</div>
			<div class="chooseCont" id="service-contect">
				{!! $service->content !!}
			</div> 
			@if ($message = Session::get('success'))
				<div class="alert alert-success alert-block"> 
					<strong>{{ $message }}</strong>
				</div> 
			@endif

			@if ($error = Session::get('error'))
				<div class="alert alert-error alert-block"> 
					<strong>{{ $error }}</strong>
				</div> 
			@endif

			@if (count($errors) > 0)
				<div class="alert alert-danger"> 
					<ul>
						@foreach ($errors->all() as $error)
							<li>{{ $error }}</li>
						@endforeach
					</ul>
				</div>
			@endif
			<div class="formContent" id="main-fields">
				
				<form class="formWithValidation" method="post" action="/service-appeal" id="my-form" onsubmit="return validateMyForm()">
					<div>
						<label>Ad:</label>
						<input class="nameF field" placeholder ="Ad" maxlength="21" type="text" name="fName">
						<p id="first-name-error" class="form-validate"></p>
					</div>
					<div>
						<label>Soyad:</label>
						<input class="sureNameF field"placeholder ="Soyad" maxlength="21" type="text" name="lName">
						<p id="last-name-error" class="form-validate"></p>
					</div>
					<div>
						<label>Elektron poçt ünvanı:</label>
						<input class="mailF field" placeholder ="Example@gmail.com" maxlength="31" type="email" name="mail">
						<p id="mail-error" class="form-validate"></p>
					</div>
					<div>
						<label>Əlaqə nömrəsi:</label>
						<input class="phoneNumF field" placeholder ="(+994) xx xxx xx xx" maxlength="13" tabindex="4" type="number" name="number">
						<p id="number-error" class="form-validate"></p>
					</div> 
					<input type="hidden" name="status" value="{{ $id }}" />
					{!! csrf_field() !!}
					<button class="valBtn" tabindex="5" type="submit">Müraciət et</button>
				</form>
			</div>
		</div>
	</div>
	<script>
		// let currentSelect = document.getElementById("visa-type");
		// function getPeriod(select) {
		// 	var selectedOption = select.options[select.selectedIndex];
		// 	var period = selectedOption.getAttribute('data-period');
		// 	console.log(period);
		// 	document.querySelector("#viza-period-show p").innerText = period;
		// }
		// getPeriod(currentSelect);
	</script>
@endsection

