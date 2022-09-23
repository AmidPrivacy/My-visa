@extends('layouts.client-master')
@section('css')
    <link type="text/css" rel="stylesheet" href="/assets/css/client-side/custom.css" /> 
@endsection
@section('public-content') 
	<div class="mainContent">
		<div class="container">
			<div class="nameOfCountry">
				<img src="/assets/uploads/flags/{{ count($countries)>0 ? $countries[0]->picture : '' }}" alt="">
				<h1>{{ count($countries)>0 ? $countries[0]->name : "" }}</h1>
			</div>
			<div class="chooseCont">
				<div class="chooseVisa">
					<h4>Viza növünü seçin:</h4>
                    <select class="selectBtn" name="type_of_visa">
                        <option value="1">Turist vizası</option>
                    </select>
				</div>
				<div class="chooseVisa">
					<h4>Sığorta</h4>
                    <select class="selectBtn" name="Ins_val">
                        <option value="1">Bəli</option>
                    </select>
				</div>
				
			</div>
			<div class="aboutVisaDescr">
				<div class="visDescrFirst visDescr">
					<img src="/assets/img/luggage (1) 1.svg" alt="">
					<p>Viza tələb edilir</p>
				</div>
				<div class="visDescrSecond visDescr">
					<img src="/assets/img/cash 1.svg" alt="">
					<p>Xidmət haqqı <br> 500 azn</p>
				</div>
				<div class="visDescrThird visDescr">
					<img src="/assets/img/Group.svg" alt="">
					<p>Viza verilmə müddəti <br> 3 ay</p>
				</div>
			</div>
			<div class="formContent">
				<form class="formWithValidation" method="get" action="#">
					<div>
                        <label>Ad:</label>
					    <input class="nameF field" placeholder ="Ad" tabindex="1" type="text" name="Name">
                    </div>
					<div>
                        <label>Soyad:</label>
					    <input class="sureNameF field"placeholder ="Soyad" tabindex="2" type="text" name="SureName">
                    </div>
					<div>
                        <label>Elektron poçt ünvanı:</label>
					    <input class="mailF field" placeholder ="Example@gmail.com" tabindex="3" type="text" name="Mail">
                    </div>
					<div>
                        <label>Əlaqə nömrəsi:</label>
					    <input class="phoneNumF field" placeholder ="(+994) xx xxx xx xx" required maxlength="13" tabindex="4" type="tel" name="TelNum">
                    </div> 
					<button class="valBtn" tabindex="5" type="submit">Müraciət et</button>
				</form>
			</div>
		</div>
	</div>
@endsection