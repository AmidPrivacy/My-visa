@extends('layouts.client-master')
@section('css')
    <link type="text/css" rel="stylesheet" href="assets/css/client-side/tours.css" />
	<link type="text/css" rel="stylesheet" href="assets/css/client-side/footer.css" />
@endsection
@section('public-content')
    
	<div class="mainContent">
		<div class="container">
			<div class="nameOfServ">
				<h1>Turlar</h1>
			</div>
			<div class="cardsContainer">
			@foreach($list as $index => $item)
				<div class="card">
					<div class="cardsContent">
						<img src="assets/uploads/tour-images/{{ $item->picture }}" alt="">
						<div class="descrTourCont">
							<h1>{{ $item->title }}</h1>
							<p> Tarix: {{ $item->created_at }} </p>
							<p> Müddət: {{ $item->period }} </p>
                            <p> Qiymət: {{ isset($item->price) ? $item->price."manat" : "" }}</p>
                            <p> Qeyd: {{ $item->content }} </p>
						</div>
						<a href="#">Ətraflı</a>
					</div>
				</div>
			@endforeach 
			</div>
		</div>
	</div>
@endsection