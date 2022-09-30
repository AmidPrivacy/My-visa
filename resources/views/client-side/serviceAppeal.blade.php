@extends('layouts.client-master')
@section('css')
    <link type="text/css" rel="stylesheet" href="/assets/css/client-side/custom.css" /> 
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
			<div class="formContent" id="main-fields">
				<form class="formWithValidation" method="post" action="#">
					<div>
                        <label>Ad:</label>
					    <input class="nameF field" placeholder ="Ad" tabindex="1" type="text" name="name">
                    </div>
					<div>
                        <label>Soyad:</label>
					    <input class="sureNameF field"placeholder ="Soyad" tabindex="2" type="text" name="surName">
                    </div>
					<div>
                        <label>Elektron poçt ünvanı:</label>
					    <input class="mailF field" placeholder ="Example@gmail.com" tabindex="3" type="text" name="mail">
                    </div>
					<div>
                        <label>Əlaqə nömrəsi:</label>
					    <input class="phoneNumF field" placeholder ="(+994) xx xxx xx xx" required maxlength="13" tabindex="4" type="tel" name="number">
                    </div> 
					<button type="submit" class="valBtn" tabindex="5" type="submit">Müraciət et</button>
				</form>
			</div>
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

