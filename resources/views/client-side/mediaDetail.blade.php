@extends('layouts.client-master')
@section('css')
    <link type="text/css" rel="stylesheet" href="/assets/css/client-side/custom.css" />
    <link type="text/css" rel="stylesheet" href="/assets/css/client-side/media.css" />
    <link type="text/css" rel="stylesheet" href="/assets/css/client-side/footer.css" />
@endsection
@section('public-content') 
    <section class="media-detail container">
        
        <div class="media-title"> {{ $media->title }}</div>
       
        <div class="media-content">
            <div class="main-description">
                <img src="/public/assets/uploads/{{ $isBlog==1 ? 'blog-files' : 'tour-images' }}/{{ $media->picture }}" alt="">
            </div>
            <div class="blogParagraphs">

                {{ $media->content }}

                <div class="additional-images">
                    @foreach($media->additionalFiles as $item)
                        <img class="file-item" src="/public/assets/uploads/{{ $isBlog==1 ? 'blog-files' : 'tour-images' }}/{{ $item->file }}" alt="">
                    @endforeach
                </div>

                <div class="detail-info">
                    <p style="margin: 0;">
                        myvisa.az
                    </p>
                    <p style="margin: 0;">
                        {{ $media->created_at }}
                    </p>
                </div>
                
            </div>       
        </div>
       
    </section>
@endsection