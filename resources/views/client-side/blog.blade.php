@extends('layouts.client-master')
@section('css')
    <link type="text/css" rel="stylesheet" href="assets/css/client-side/custom.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/client-side/blog.css" />
    <link type="text/css" rel="stylesheet" href="assets/css/client-side/footer.css" />
@endsection
@section('public-content') 
    <section class="blogSection container">
        <div class="blogHead">Blog</div>

        @foreach($list as $index => $item)
        @if($index%2===0)
        <div class="blogs">
            <div class="blogsInfo">
                <div class="blogImage">
                    <img src="assets/img/vaduz-castle.png" alt="">
                </div>
                <div class="blogParagraphs">
                    <h3> 
                        <a href="/blog/{{ $item->uuid }}">{{ $item->title }}</a> 
                    </h3>
                    <p>
                    {{ $item->content }}
                    </p>
                    <p style="margin: 0;">
                        myvisa.az
                    </p>
                    <p style="margin: 0;">
                        {{ $item->created_at }}
                    </p>
                </div>
                
            </div>            
        </div>
        @else
        <div class="blogs">
            <div class="blogsInfo">
                
                <div class="blogParagraphs">
                    <h3> <a href="#">{{ $item->title }}</a> </h3>
                    <p>
                        {{ $item->content }}
                    </p>
                    <p style="margin: 0;">
                        myvisa.az
                    </p>
                    <p style="margin: 0;">
                        {{ $item->created_at }}
                    </p>
                </div>
                <div class="blogImage">
                    <img src="assets/img/vaduz-castle.png" alt="">
                </div>
                
            </div>            
        </div>
        @endif
        @endforeach
    </section>
@endsection