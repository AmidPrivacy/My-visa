@extends('layouts.client-master')
@section('css')
    <link type="text/css" rel="stylesheet" href="assets/css/client-side/custom.css" />
@endsection
@section('public-content')
    <section class="container">
        <div class=" firstSec">
            <div class="selection">
                
                <div class="search-title">  
                    <p>Səyahət etmək istədiyiniz</p> <h3> ölkəni seçin</h3>
                </div>
                
                <div class="filterFlex">
                    <div class="dropdown">
                        <div class="drpInp">
                            <img src="assets/img/search.svg" class="iconSearch"  alt="">
                            <input type="text" id="search"placeholder="Məs: Türkiyə" onkeyup="myFunction(this, '.dropdown-content a')" /> 
                            <img src="assets/img/arrow.svg" class="arrow" alt="">
                        </div>
                        <div class="dropdown-content">
                            @foreach($countries as $index => $item)
                                <a href="/visa-appeal/{{ $item->id }}">
                                    <img src="assets/uploads/flags/{{ $item->picture }}"  style="width: 20px; height: 20px;" alt=""> 
                                    <span>{{ $item->name }}</span>
                                </a>
                            @endforeach 
                        </div>
                    </div>
                    <div class="filter"> 
                        <a href="/visa-services">
                            <button class="filterBtn">
                                <img src="assets/img/filter.svg" alt="">  
                            </button>
                        </a> 
                    </div>
                </div>
                <button class="confirmRequest"> Müraciət Et</button>
                
            </div>
            <div class="selectionImg">
                 <img src="assets/img/vector.svg" alt="">
            </div>
        </div>
    </section>
    <section class="mainSec" >
        <div class="container serviceSec">
            <p class="mobileService">Xidmətlərimiz:</p>
            <div class="serviceCard">
                @foreach($services as $service)
                <div class="card">
                    <a href="/service-appeal/{{ $service->id }}" class="visaService" target="_blank">
                        <img src="assets/uploads/service-images/{{ $service->picture }}" alt="">
                        <p>{{ $service->name }}</p>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        <div class="popularSec container">
            <p class="mobilePopular"> Ən çox tələb edilən vizalar:</p> 
            <div class="popularVisa">
                @foreach($types as $type)
                <div class="popularCard">
                    <img src="assets/uploads/flags/{{ $type->picture }}" alt="">
                    <p>{{ $type->country }}</p>
                    <div class="cardParent">
                        <div class="cardChild">
                            <h3>{{ $type->period }}</h3>
                            <p> Vizanin verilmə müddəti</p>
                        </div>
                    </div>
                    <button class="popularMore" id="morePopular">Ətraflı bax</button>
                </div> 
                @endforeach 
            </div>
        </div>
    </section>
@endsection