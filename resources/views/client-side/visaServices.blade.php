@extends('layouts.client-master')
@section('css')
    <link type="text/css" rel="stylesheet" href="assets/css/client-side/custom.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/client-side/detail.css" />
@endsection
@section('public-content') 
    <section class="detailSec container ">
        <div class="detailP">
            <p>Səyahət etmək istədiyiniz</p> 
            <h3>ölkəni seçin</h3>
        </div>
        <div class="detailDiv">
            <div class="detailCard ">
                <img src="assets/img/search.svg" class="iconSearch"  alt="">
                <input type="text" id="searchDetail"placeholder="Məs: Türkiyə" onkeyup="myFunction(this, '.detailBox .boxUl li')" /> 
            </div>
            <div class="detailCard"> <input type="checkbox" name="" id=""> <label>Viza Tələb Edən Ölkələr</label></div>
            <div class="detailCard"><input type="checkbox" name="" id=""><label>Viza Tələb Etməyən Ölkələr</label> </div>
            <div class="detailCard"> <input type="checkbox" name="" id=""> <label>Ən ucuz viza rüsumu olan ölkələr</label></div>
        </div>
        <div class="detailBox">
            <ul class="boxUl">
                @foreach($countries as $index => $item)
                    <li class="selections">
                        <a href="/visa-appeal/{{ $item->id }}"> 
                            <img src="assets/uploads/flags/{{ $item->picture }}"  style="width: 20px; height: 20px;" alt=""> 
                            <span>{{ $item->name }}<span>
                        </a>
                    </li>
                @endforeach 
            </ul>
        </div>
    </section>
@endsection