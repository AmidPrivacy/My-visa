@extends('layouts.client-master')
@section('css')
    <link type="text/css" rel="stylesheet" href="assets/css/client-side/custom.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/client-side/faq.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/client-side/footer.css" />
@endsection
@section('public-content') 
    <section class="faqSec container">
        <div class="faqDiv">
            <div class="faqHead">
                <p>Ən çox verilən suallar</p>
            </div>

            @foreach($list as $index => $item)
            <div class="faqs">
                <div class="faq-according-header">{{ $item->title }}</div>
                <div class="faq-according-body">sdfd</div>
            </div>
            @endforeach
            
        </div>
    </section>

    <script>

        var acc = document.getElementsByClassName("faq-according-header"); 

        for (var i = 0; i < acc.length; i++) {
            acc[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var panel = this.nextElementSibling;
                if (panel.style.display === "block") {
                    panel.style.display = "none";
                } else {
                    panel.style.display = "block";
                }
            });
        }
        
    </script>
@endsection