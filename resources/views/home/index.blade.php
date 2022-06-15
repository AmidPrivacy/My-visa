@extends('layouts.app-master')
@section('css')
	<link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
	<link href="{!! url('assets/css/style.css') !!}" rel="stylesheet">
	<link href="{!! url('assets/css/visa.css') !!}" rel="stylesheet">
	<link href="{!! url('assets/css/all.min.css') !!}" rel="stylesheet">
@endsection
@section('public-content')
	<header>
		<div class="header-top">
			<div class="main-container">
				<div class="leftcontact-info">
					<div class="mail">
						<i class="fas fa-envelope"></i>
						<span>info@myvisa.com</span>
					</div>
					<div class="telnum">
						<i class="fas fa-phone"></i>
						<span>+123 345 56</span>
					</div>
				</div>
				<div class="rightcontact-info">
					<a href="#">
						<i class="fab fa-facebook-square"></i>
					</a>
					<a href="#">
						<i class="fab fa-pinterest"></i>			
					</a>
					<a href="#">
						<i class="fab fa-twitter-square"></i>			
					</a>
					<a href="#">
						<i class="fab fa-vimeo-square"></i>			
					</a>
					<a href="#">
						<i class="fab fa-instagram"></i>			
					</a>
				</div>
			</div>
		</div>
		<div class="header-menu">
			<div class="main-container">
				<div class="logoname">
					<i class="far fa-compass"></i>
					<span>My Visa</span>
				</div>
			</div>
		</div>
	</header>
	<main>
		<div class="main-container">
		
			<h1 id="dest">My Visa</h1>

			<div class="azecon">
				<h3 class="continents">Pilot layihə olaraq pulsuz viza xidmətləri</h3>
				@if ($message = Session::get('success'))
					<div class="alert alert-success alert-block"> 
						<strong>{{ $message }}</strong>
					</div>
				@endif
				<div class="forms-cont">
					<form method="post" action="/appeal">
						<input class="inputs" type="text" name="name" placeholder="Ad" required>
						<input class="inputs" type="text" name="surname" placeholder="Soyad" required>
						<div class="phone-num-inpcont">
							<input class="input" id="ccode" name="c_code" value="+994" readonly="">
							<select name="c_preffix" id="pref" class="input">
								<option value="050" selected>050</option>
								<option value="051">051</option>
								<option value="010">010</option>
								<option value="055">055</option>
								<option value="070">070</option>
								<option value="077">077</option>
								<option value="099">099</option>
								<option value="060">060</option>
							</select>
							<input type="number" class="input _ph7num" name="c_number" placeholder="555 55 55" required>
						</div>
						<div class="appeal-types">
							@foreach($types as $type)
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="checkbox" name="appeal_types[]" id="inlineCheckbox1" value="{{ $type->id }}">
								<label class="form-check-label" for="inlineCheckbox1"> {{ $type->name }} </label>
								<a href="{{ $type->path }}" target="_blank">Ətraflı</a>
							</div>
							@endforeach 
						</div>
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
						<button class="Subm-Button">MÜRACİƏT ET</button>
					</form>
				</div>
				<h3 class="continents">Şikayət və təklifləriniz olarsa bu nömrəyə yaza bilərsiniz</h3>
			</div>
		</div>
	</main>
	<footer>
		<div class="footercontent">
			<div class="main-container">
				<div class="firstlayer">
				</div>
				<div class="logoname" id="logo-bottom">
					<i class="far fa-compass"></i>
					<span>My Visa</span>
				</div>
			</div>
		</div>
	</footer>
@endsection