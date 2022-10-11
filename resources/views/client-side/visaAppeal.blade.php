@extends('layouts.client-master')
@section('css')
    <link type="text/css" rel="stylesheet" href="/assets/css/client-side/custom.css" /> 
	<link type="text/css" rel="stylesheet" href="assets/css/client-side/footer.css" />
@endsection
@section('public-content') 
	<div class="mainContent">
		<div class="container">
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
			<form class="formWithValidation" method="post" action="/country-appeal" id="my-form" onsubmit="return validateMyForm()">
				<div class="nameOfCountry">
					<img src="/assets/uploads/flags/{{ count($countries)>0 ? $countries[0]->picture : '' }}" alt="">
					<h1>{{ count($countries)>0 ? $countries[0]->name : "" }}</h1>
				</div>
				<div class="chooseCont">
 
					<div class="chooseVisa">
						<h4>Viza növünü seçin:</h4>
						<select class="selectBtn" name="type_of_visa" id="visa-type" onchange="getPeriod(this)" required>
							@foreach($types as $type)
							<option value="{{ $type->id }}" data-period="{{ $type->period }}">{{ $type->name }}</option>
							@endforeach
						</select>
					</div>
					<div class="chooseVisa">
						<h4>Sığorta</h4>
						<select class="selectBtn" name="Ins_val">
							<option value="1">Bəli</option>
							<option value="0">Xeyr</option>
						</select>
					</div>
					
				</div>
				<div class="aboutVisaDescr">
					<div class="visDescrFirst visDescr">
						<img src="/assets/img/luggage (1) 1.svg" alt="">
						<div>Viza tələb edilir</div>
					</div>
					<div class="visDescrSecond visDescr">
						<img src="/assets/img/cash 1.svg" alt="">
						<div>
							Xidmət haqqı 
							<p> {{ count($countries)>0 ? $countries[0]->price." AZN" : "" }}</p>
						</div>
					</div>
					<div class="visDescrThird visDescr">
						<img src="/assets/img/Group.svg" alt="">
						<div id="viza-period-show">
							Viza verilmə müddəti  
							<p>3 ay</p>
						</div>
					</div>
				</div>
				<div class="formContent" id="main-fields">
					
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
						<!-- <div id="note-box">
							<label>Qeyd:</label>
							<textarea class="appealNote field" placeholder="Qeyd" maxlength="290" name="note"></textarea>
							<p id="note-error" class="form-validate"></p>
						</div>  -->
						{!! csrf_field() !!}
						<button class="valBtn" tabindex="5" type="submit">Müraciət et</button>
					
				</div>
			</form>
		</div>
	</div>
	<script>
		let currentSelect = document.getElementById("visa-type");
		function getPeriod(select) {
			var selectedOption = select.options[select.selectedIndex];
			var period = selectedOption.getAttribute('data-period');
			console.log(period);
			document.querySelector("#viza-period-show p").innerText = period;
		}
		getPeriod(currentSelect);

		 
	</script>
@endsection

