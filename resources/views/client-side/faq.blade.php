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
                <p>{{ $item->title }}</p>
            </div>
            @endforeach
            
        </div>
    </section>
@endsection