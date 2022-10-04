@extends('layouts.client-master')
@section('css')
    <link type="text/css" rel="stylesheet" href="assets/css/client-side/custom.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/client-side/detail.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/client-side/footer.css" />
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
                <input type="text" id="searchDetail"placeholder="Məs: Türkiyə" /> 
            </div>
            <div class="detailCard"> 
                <input type="radio" name="visa_required" value="2" /> 
                <label>Viza Tələb Edən Ölkələr</label>
            </div>
            <div class="detailCard">
                <input type="radio" name="visa_required" value="1" />
                <label>Viza Tələb Etməyən Ölkələr</label> 
            </div>
            <div class="detailCard"> 
                <input type="checkbox" name="order_price" value="1"> 
                <label>Ən ucuz viza rüsumu olan ölkələr</label>
            </div>
        </div>
        <div class="detailBox">
            <ul class="boxUl">
                @foreach($countries as $index => $item)
                    <li class="selections" data-price="{{ $item->price }}" data-required="{{ $item->color }}">
                        <a href="/visa-appeal/{{ $item->id }}"> 
                            <img src="assets/uploads/flags/{{ $item->picture }}"  style="width: 20px; height: 20px;" alt=""> 
                            <span>{{ $item->name }}<span>
                        </a>
                    </li>
                @endforeach 
            </ul>
        </div>
    </section>

    <script src="assets/js/jquery-3.5.1.min.js"></script> 
    <script>
        $(function(){

            $(".detailCard input").change(function(){
                var inputValue = document.querySelector('#searchDetail').value;

                var visaRequire = "";
                if(document.querySelector('input[name="visa_required"]:checked') !==null) {
                    visaRequire = document.querySelector('input[name="visa_required"]:checked').value;
                }

                var orderPrice = "";
                if(document.querySelector('input[name="order_price"]:checked') !==null) {
                    orderPrice = document.querySelector('input[name="order_price"]:checked').value;
                }

                var url = `/search-country?inputValue=${inputValue}&visaRequire=${visaRequire}&orderPrice=${orderPrice}`;

                fetch(url).then(data => {
                    return data.json();
                }).then(res => { 
                    if(res.error==null) {
                        var box = document.querySelector(".detailBox .boxUl"); 
                        let str = "";
                        if(res.data.length>0) { 
                            res.data.forEach(function(item) {
                                str+= `
                                <li class="selections" data-price="${item.price}" data-required="${item.color}">
                                    <a href="/visa-appeal/${item.id}"> 
                                        <img src="assets/uploads/flags/${item.picture}" style="width: 20px; height: 20px;" alt=""> 
                                        <span>${item.name}<span>
                                    </a>
                                </li>
                            `;
                            })
                            
                        }
                
                        $(box).html(str);
                
                    } else {
                        console.log(res);
                    }
                    
                });
            }); 

        })
        
        
    </script>

@endsection